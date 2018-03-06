<?php
namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RentController extends Controller
{
    public function indexRentAction($page)  //Afffichage page des annonces de vente
    {
        $nbPerPage = 8;
        $listRents = $this->getDoctrine()   
                            ->getManager()
                            ->getRepository('MangoPlatformBundle:Rent')
                            ->getRents($page, $nbPerPage);  //Récupère toutes les annonces

        $nbPages = ceil(count($listRents)/$nbPerPage); //calcul du nb de page à afficher pour la pagination

        if($page>$nbPages){
            throw new NotFoundHTTPException("La page " . $page . " d'annonces n'existe pas");
        }
        return $this->render('MangoPlatformBundle:Rent:index.html.twig', array('listRents' => $listRents));
    }

    public function viewAction($id)
    {
    	$em = $this->getDoctrine()->getManager(); //Enclenche les processus de Doctrine pour les entités 

        $rent = $em->getRepository('MangoPlatformBundle:Rent')->find($id); //Récupération de l'objet Rent en fonction de son id

        if(null===$rent){
            throw new NotFoundHttpException("Désolé, l'annonce n°" . $id . " n'existe pas");
        }
    	return $this->render('MangoPlatformBundle:Rent:view.html.twig', array('rent' => $rent));
    }

    /*public function addAction(Request $request)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR')) { //Verification role utilisateur
      
            throw new AccessDeniedException('Accès limité aux auteurs.');
        }
        //Ajouter condition "si location"
        $rent = new Rent(); //Ajout d'une annonce de location

        $form = $this->createForm(RentType::class, $rent); 

    	if($request->isMethod('POST')){
    		$form ->handleRequest($request); //Lie les valeurs du formulaire à $rent

            if($form->isValid()){      //si valide on enregistre en bdd 
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();

                $request->getsession()->getflashBag()->add('notice', 'Votre annonce a bien été enregistrée, celle-ci sera visible après validation par notre équipe'); //Notification

                return $this->RedirectToRoute('mango_platform_view', array('id'=>$rent->getId()));
            }
    	}
    	return $this->render('MangoPlatformBundle:User:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rent = $em->getRepository('MangoPlatformBundle:Rent')->find($id);

        if (null === $rent) {
            throw new NotFoundHttpException("L'annonce n°" . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(RentEditType::class, $rent);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush(); //On enregistre les modifs

            $request->getSession()->getFlashBag()->add('notice', "L'annonce a bien été modifiée.");

            return $this->redirectToRoute('mango_platform_view', array('id' => $rent->getId()));
        }

        return $this->render('MangoPlatformBundle:User:edit.html.twig', array('rent' => $rent,'form' => $form->createView()));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $rent = $em->getRepository('MangoPlatformBundle:Rent')->find($id);

        if (null === $rent) {
            throw new NotFoundHttpException("L'annonce n°" . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(); //Création d'un form vide n'ayant qu'un champ CSRF pour proteger d'une faille

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($advert);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

            return $this->redirectToRoute('mango_platform_home'); //Changer le chemin pour retomber sur la page d'accueil utilisateur
        }
        return $this->render('MangoPlatformBundle:User:delete.html.twig', array('rent' => $rent,'form' => $form->createView()));
    }*/
}