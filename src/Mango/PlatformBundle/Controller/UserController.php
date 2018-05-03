<?php
namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Entity\User;
use Mango\UserBundle\Form\UserType;
use Mango\PlatformBundle\Entity\Rent;
use Mango\PlatformBundle\Entity\Buy;
use Mango\PlatformBundle\Form\RentType;
use Mango\PlatformBundle\Form\BuyType;
use Mango\PlatformBundle\Form\RentEditType;
use Mango\PlatformBundle\Form\BuyEditType;

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////// ANNONCES //////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////// AJOUT ANNONCE /////////////////////////////////////////////////////////////////////////

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

                if($form->getData()->getMeuble() === null){  //Pour éviter l'erreur de doublon de champ
                    $rent->setMeuble(0);
                }else if ($form->getData()->getMeuble() == 1){
                    $rent->setMeuble(1);
                }
                if($form->getData()->getCollocation() === null){
                    $rent->setCollocation(0);
                }else if ($form->getData()->getCollocation() == 1){
                    $rent->setCollocation(1);
                }

            if($form->isValid()){      //si valide on enregistre en bdd 
                $rent->setPublished(0);
                $rent->setEdited(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($rent);
                $em->flush();

                $request->getsession()->getflashBag()->add('notice', 'Votre annonce a bien été enregistrée, celle-ci sera visible après validation par notre équipe'); //Notification

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
                $buy->setPublished(0);
                $buy->setEdited(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($buy);
                $em->flush();

                $request->getsession()->getflashBag()->add('notice', 'Votre annonce a bien été enregistrée, celle-ci sera visible après validation par notre équipe'); //Notification

                return $this->RedirectToRoute('mango_platform_user');
            }
        }
        return $this->render('MangoPlatformBundle:User:add.html.twig', array('form' => $form->createView(), 'userId' => $userId, 'title' => $title));
    }

    ////////////////////////////////////////////////////////////////// EDITION ANNONCE ///////////////////////////////////////////////////////////////////////////

    public function editRentAction(Request $request)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) { //Verification role utilisateur
      
            throw new AccessDeniedException('Veuillez vous connecter.');
        }

        $title = 'rentEdit';

        $rent = $this->getDoctrine()->getRepository('MangoPlatformBundle:Rent')->findWithoutLocalisation($request->get('id')); //Pour avoir moins de requêtes

        if (null === $rent) {
            throw new NotFoundHttpException("L'annonce n°" . $request->get('id') . " n'existe pas.");
        }

        $form = $this->createForm(RentEditType::class, $rent);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            if($form->getData()->getMeuble() === null){
                $rent->setMeuble(0);
            }else if ($form->getData()->getMeuble() == 1){
                $rent->setMeuble(1);
            }
            if($form->getData()->getCollocation() === null){
                    $rent->setCollocation(0);
            }else if ($form->getData()->getCollocation() == 1){
                $rent->setCollocation(1);
            }

            $rent->setPublished(0);
            $rent->setEdited(1);
            $this->getDoctrine()->getManager()->flush(); //On enregistre les modifs

            $request->getSession()->getFlashBag()->add('notice', "L'annonce a bien été modifiée, celle-ci sera de nouveau visible après validation par notre équipe.");

            return $this->redirectToRoute('mango_platform_user');
        }

        return $this->render('MangoPlatformBundle:User:edit.html.twig', array('rent' => $rent, 'title' => $title, 'form' => $form->createView()));
    }

    public function editBuyAction(Request $request)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) { //Verification role utilisateur
      
            throw new AccessDeniedException('Veuillez vous connecter.');
        }

        $title = 'buyEdit';

        $buy = $this->getDoctrine()->getRepository('MangoPlatformBundle:Buy')->findWithoutLocalisation($request->get('id')); 

        if (null === $buy) {
            throw new NotFoundHttpException("L'annonce n°" . $request->get('id') . " n'existe pas.");
        }

        $form = $this->createForm(BuyEditType::class, $buy);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $buy->setPublished(0);
            $buy->setEdited(1);
            $this->getDoctrine()->getManager()->flush(); //On enregistre les modifs

            $request->getSession()->getFlashBag()->add('notice', "L'annonce a bien été modifiée, celle-ci sera de nouveau visible après validation par notre équipe.");

            return $this->redirectToRoute('mango_platform_user');
        }

        return $this->render('MangoPlatformBundle:User:edit.html.twig', array('buy' => $buy, 'title' => $title, 'form' => $form->createView()));
    }

    //////////////////////////////////////////////////// SUPPRESSION ANNONCE //////////////////////////////////////////////////////////////////////////////

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

            $request->getSession()->getFlashBag()->add('notice', "L'annonce a bien été supprimée.");

            return $this->redirectToRoute('mango_platform_user'); 
        }
        return $this->render('MangoPlatformBundle:User:delete.html.twig', array('rent' => $rent,'buy' =>$buy, 'form' => $form->createView()));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////// USER //////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function userInfosAction(Request $request)
    {
        $infos = $this->getUser();

        if (null === $infos) {
            throw new NotFoundHttpException("Cet utilisateur n'existe pas");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {  //Suppression du compte

            $userId = $infos->getId();    //Recherche des annonces liées à l'utilisateur
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('UserBundle:User')->find($userId);
            $listRents = $em->getRepository('MangoPlatformBundle:Rent')->getRentsByUser($userId);
            $listBuys = $em->getRepository('MangoPlatformBundle:Buy')->getBuysByUser($userId);

            foreach ($listRents as $rent){  //Un utilisateur peut avoir plusieurs annonces
                $em->remove($rent);
            }

            foreach ($listBuys as $buy) {
                $em->remove($buy);
            }

            $em->remove($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success-delete', "Votre compte à bien été supprimé");

            return $this->redirectToRoute('fos_user_security_logout'); 
        }

        return $this->render('MangoPlatformBundle:User:infos.html.twig', array('infos' => $infos, 'form' => $form->createView()));
    }

    public function editInfosAction(Request $request)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) { //Verification role utilisateur
      
            throw new AccessDeniedException('Veuillez vous connecter.');
        }

        $infos = $this->getUser();

        if (null === $infos) {
            throw new NotFoundHttpException("Cet utilisateur n'existe pas");
        }

        $form = $this->createForm(UserType::class, $infos);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $this->getDoctrine()
                 ->getManager()
                 ->flush(); 

            $request->getSession()->getFlashBag()->add('success-info', "Vos coordonnées ont bien été modifiées");

            return $this->redirectToRoute('mango_platform_user_info');
        }

        return $this->render('MangoPlatformBundle:User:editUserInfos.html.twig', array('infos' => $infos, 'form' => $form->createView()));
    }
}
