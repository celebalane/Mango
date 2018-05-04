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

    public function userInfosAction(Request $request)  //Affichage des infos sur l'utilisateur
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

    public function editInfosAction(Request $request) //Modification des infos de l'utilisateur
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
