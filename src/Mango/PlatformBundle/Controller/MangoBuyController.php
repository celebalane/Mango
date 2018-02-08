<?php
namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Mango\PlatformBundle\Entity\Advert;
use Mango\PlatformBundle\Form\AdvertType;
use Mango\PlatformBundle\Form\AdvertEditType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MangoBuyController extends Controller
{
    public function indexBuyAction($page)  //Afffichage page des annonces de vente
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
        return $this->render('MangoPlatformBundle:Buy:index.html.twig');
    }
}