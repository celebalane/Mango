<?php
namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Entity\User;
use Mango\PlatformBundle\Entity\Rent;
use Mango\PlatformBundle\Entity\Buy;
use Mango\PlatformBundle\Form\RentType;
use Mango\PlatformBundle\Form\BuyType;

class UserController extends Controller
{
    public function indexAction()  //Affichage page d'accueil des utilisateurs, affiche le récapitulatif de leurs annonces
    {
        $userId = $this->getUser()->getId(); //Récupère l'id de l'utilisateur courant
        $listRents = $this->getDoctrine()   
                            ->getManager()
                            ->getRepository('MangoPlatformBundle:Rent')
                            ->getRentsByUser($userId);  //Récupère toutes les annonces de l'utilisateur

        $listBuys = $this->getDoctrine()  
                            ->getManager()
                            ->getRepository('MangoPlatformBundle:Buy')
                            ->getBuysByUser($userId);  

        return $this->render('MangoPlatformBundle:User:index.html.twig', array('listBuys' => $listBuys, 'listRents' => $listRents));
    }

    //////////////////////////////////////////////////////// AJOUT /////////////////////////////////////////////////////////////////////////

	public function addRentAction(Request $request)  //Ajout d'une annonce de location
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) { //Verification role utilisateur
      
            throw new AccessDeniedException('Veuillez vous connecter.');
        }
        $title = 'rent';
        $userId = $this->getUser()->getId(); //Récupère l'id de l'utilisateur courant
        $rent = new Rent(); //Ajout d'une annonce de location

        $form = $this->createForm(RentType::class, $rent); 

    	if($request->isMethod('POST')){
    		$form ->handleRequest($request); //Lie les valeurs du formulaire à $rent
                if($form->getData()->getMeuble() == null){
                    $rent->setMeuble(0);
                }else if ($form->getData()->getMeuble() == 1){
                    $rent->setMeuble(1);
                }
                if($form->getData()->getCollocation() == null){
                    $rent->setCollocation(0);
                }else if ($form->getData()->getCollocation() == 1){
                    $rent->setCollocation(1);
                }

            if($form->isValid()){      //si valide on enregistre en bdd 
                $rent->setPublished(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($rent);
                $em->flush();

                $request->getsession()->getflashBag()->add('success', 'Votre annonce a bien été enregistrée, celle-ci sera visible après validation par notre équipe'); //Notification

                return $this->RedirectToRoute('mango_platform_user');
            }
    	}
    	return $this->render('MangoPlatformBundle:User:add.html.twig', array('form' => $form->createView(), 'userId' => $userId, 'title' => $title));
    }


    public function addBuyAction(Request $request)  //Ajout d'une annonce de vente
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) { //Verification role utilisateur
      
            throw new AccessDeniedException('Veuillez vous connecter.');
        }
        $title = 'buy';
        $userId = $this->getUser()->getId(); //Récupère l'id de l'utilisateur courant
        $buy = new Buy(); //Ajout d'une annonce de location

        $form = $this->createForm(BuyType::class, $buy); 

        if($request->isMethod('POST')){
            $form ->handleRequest($request); //Lie les valeurs du formulaire à $rent

            if($form->isValid()){      //si valide on enregistre en bdd 
                $rent->setPublished(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($buy);
                $em->flush();

                $request->getsession()->getflashBag()->add('success', 'Votre annonce a bien été enregistrée, celle-ci sera visible après validation par notre équipe'); //Notification

                return $this->RedirectToRoute('mango_platform_user');
            }
        }
        return $this->render('MangoPlatformBundle:User:add.html.twig', array('form' => $form->createView(), 'userId' => $userId, 'title' => $title));
    }

    ////////////////////////////////////////////////////////////////// EDITION ///////////////////////////////////////////////////////////////////////////

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rent = $em->getRepository('MangoPlatformBundle:Rent')->find($id);
        $buy = $em->getRepository('MangoPlatformBundle:Buy')->find($id);

        if (null === $rent && null === $buy) {
            throw new NotFoundHttpException("L'annonce n°" . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(RentEditType::class, $rent); //Ajouter condition si rent ou buy

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush(); //On enregistre les modifs

            $request->getSession()->getFlashBag()->add('notice', "L'annonce a bien été modifiée.");

            return $this->redirectToRoute('mango_platform_view', array('id' => $rent->getId()));
        }

        return $this->render('MangoPlatformBundle:User:edit.html.twig', array('rent' => $rent,'form' => $form->createView()));
    }

    //////////////////////////////////////////////////// SUPPRESSION //////////////////////////////////////////////////////////////////////////////

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rent = $em->getRepository('MangoPlatformBundle:Rent')->find($id);
        $buy = $em->getRepository('MangoPlatformBundle:Buy')->find($id);

        if (null === $rent && null === $buy) {
            throw new NotFoundHttpException("L'annonce n°" . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(); //Création d'un form vide n'ayant qu'un champ CSRF pour proteger d'une faille

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            if (isset($rent)){
                $em->remove($rent);
                $em->flush();
            }else{
                $em->remove($buy);
                $em->flush();
            }

            $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

            return $this->redirectToRoute('mango_platform_user'); 
        }
        return $this->render('MangoPlatformBundle:User:delete.html.twig', array('rent' => $rent,'buy' =>$buy, 'form' => $form->createView()));
    }
}