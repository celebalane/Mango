<?php
namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BuyController extends Controller
{
    public function indexBuyAction($page)  //Afffichage page des annonces de vente
    {
        $active = "acheter";
        $nbPerPage = 8;
        $listBuys = $this->getDoctrine()  
                            ->getManager()
                            ->getRepository('MangoPlatformBundle:Buy')
                            ->getBuys($page, $nbPerPage);  //Récupère toutes les annonces

        $nbPages = ceil(count($listBuys)/$nbPerPage); //calcul du nb de page à afficher pour la pagination

        if($page>$nbPages){
            throw new NotFoundHTTPException("La page " . $page . " d'annonces n'existe pas");
        }
        return $this->render('MangoPlatformBundle:Buy:index.html.twig', array('listBuys' => $listBuys, 'nbPages'=>$nbPages, 'page'=>$page, 'active' => $active));
    }

    public function viewAction($id) //Affichage d'une seule annonce
    {
        $active = "acheter";
        $em = $this->getDoctrine()->getManager(); //Enclenche les processus de Doctrine pour les entités 

        $buy = $em->getRepository('MangoPlatformBundle:Buy')->find($id); //Récupération de l'objet Buy selon son Id
        $userId = $buy->getUserId();
        $user = $em->getRepository('UserBundle:User')->find($userId); //Récupération de l'objet User

        if(null===$buy){
            throw new NotFoundHttpException("Désolé, l'annonce n°" . $id . " n'existe pas");
        }
        return $this->render('MangoPlatformBundle:Buy:view.html.twig', array('buy' => $buy, 'user' => $user, 'active' => $active));
    }

    public function viewMailAction(Request $request){
        $user = $em->getRepository('UserBundle:User')->find($userId); 
        if($request->isXmlHttpRequest())
        {
            $request->getData();
            $mailUser = $user->getEmail();
            $data->setData($mailUser);

            return $data;
        }
    }

}
