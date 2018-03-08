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
        $active = "louer";
        $nbPerPage = 8;
        $listRents = $this->getDoctrine()   
                            ->getManager()
                            ->getRepository('MangoPlatformBundle:Rent')
                            ->getRents($page, $nbPerPage);  //Récupère toutes les annonces

        $nbPages = ceil(count($listRents)/$nbPerPage); //calcul du nb de page à afficher pour la pagination

        if($page>$nbPages){
            throw new NotFoundHTTPException("La page " . $page . " d'annonces n'existe pas");
        }
        return $this->render('MangoPlatformBundle:Rent:index.html.twig', array('listRents' => $listRents, 'nbPages'=>$nbPages, 'page'=>$page, 'active' => $active));
    }

    public function viewAction($id)
    {
        $active = "louer";
    	$em = $this->getDoctrine()->getManager(); //Enclenche les processus de Doctrine pour les entités 

        $rent = $em->getRepository('MangoPlatformBundle:Rent')->find($id); //Récupération de l'objet Rent en fonction de son id

        if(null===$rent){
            throw new NotFoundHttpException("Désolé, l'annonce n°" . $id . " n'existe pas");
        }
    	return $this->render('MangoPlatformBundle:Rent:view.html.twig', array('rent' => $rent, 'active' => $active));
    }
}