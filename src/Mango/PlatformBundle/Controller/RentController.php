<?php
namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Mango\PlatformBundle\Entity\Advert;
use Mango\PlatformBundle\Form\AdvertType;
use Mango\PlatformBundle\Form\AdvertEditType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RentController extends Controller
{
    public function indexRentAction($page)  //Afffichage page des annonces de vente
    {
        if ($page<1){
            throw new NotFoundHTTPException("La page " .$page. " d'annonces n'existe pas");
        }

        /*$nbPerPage=3;
        $listAdverts = $this->getDoctrine()  
                            ->getManager()
                            ->getRepository('MangoPlatformBundle:Advert')
                            ->getAdverts($page, $nbPerPage);  //Récupère toutes les annonces

        $nbPages = ceil(count($listAdverts)/$nbPerPage); //calcul du nb de page à afficher pour la pagination

        if ($page>$nbPages){
            throw new NotFoundHTTPException("La page " .$page. " d'annonces n'existe pas");
        }*/
        return $this->render('MangoPlatformBundle:Rent:index.html.twig');
    }

    public function menuAction($limit)
    {
    	$em = $this->getDoctrine()->getManager();

        $listAdverts = $em->getRepository('MangoPlatformBundle:Advert')->findBy(array(),array('date'=>'desc'),$limit,0);

    	return $this->render('MangoPlatformBundle:Advert:menu.html.twig', array('listAdverts'=>$listAdverts));
    }

    public function viewAction($id)
    {
    	$em = $this->getDoctrine()->getManager(); //Enclenche les processus de Doctrine pour les entités (objets)

        $advert = $em->getRepository('MangoPlatformBundle:Advert')->find($id); //Doctrine va chercher l'objet Advert en fonction de son id

        if(null===$advert){
            throw new NotFoundHttpException("L'annonce ".$id." n'existe pas");
        }

        $listApplications = $em->getRepository('MangoPlatformBundle:Application')->findBy(array('advert'=>$advert)); //Cherche toutes les candidatures (objet Application) liées à l'annonce précédement cherchée
        $listAdvertSkills = $em->getRepository('MangoPlatformBundle:AdvertSkill')->findBy(array('advert'=>$advert));
    	return $this->render('MangoPlatformBundle:Advert:view.html.twig', array('advert'=>$advert, 'listApplications'=>$listApplications, 'listAdvertSkills'=>$listAdvertSkills));
    }

    public function addAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR')) { //Verification role utilisateur
      
            throw new AccessDeniedException('Accès limité aux auteurs.');
        }
        $advert = new Advert(); //Ajout d une annonce

        $form = $this->createForm(AdvertType::class, $advert); 

    	if($request->isMethod('POST')){
    		$form ->handleRequest($request); //Lie les valeurs du formulaire à $advert

            if($form->isValid()){//si valide on enregistre en bdd 
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();

                $request->getsession()->getflashBag()->add('notice', 'Votre annonce a bien été enregistrée'); //Notification

                return $this->RedirectToRoute('mango_platform_view', array('id'=>$advert->getId()));
            }
    	}

    	return $this->render('MangoPlatformBundle:Advert:add.html.twig', array('form'=>$form->createView()));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('MangoPlatformBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $form = $this->get('form.factory')->create(AdvertEditType::class, $advert);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush(); //On enregistre les modifs

            $request->getSession()->getFlashBag()->add('notice', "L'annonce a bien été modifiée.");

            return $this->redirectToRoute('mango_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('MangoPlatformBundle:Advert:edit.html.twig', array('advert' => $advert,'form'   => $form->createView()));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('MangoPlatformBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $form = $this->get('form.factory')->create(); //Création d'un form vide n'ayant qu'un champ CSRF pour proteger d'une faille

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($advert);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

            return $this->redirectToRoute('mango_platform_home');
        }
    
        return $this->render('MangoPlatformBundle:Advert:delete.html.twig', array('advert' => $advert,'form'   => $form->createView()));
    }
}