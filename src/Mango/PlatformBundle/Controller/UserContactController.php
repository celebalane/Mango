<?php
namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserContactController extends Controller
{
   
    public function viewMailAction($id, Request $request){
        $em = $this->getDoctrine()->getManager(); //Enclenche les processus de Doctrine pour les entités 
        $id = $request->request->get('id');;
        $user = $em->getRepository('UserBundle:User')->find($id); 

        if($request->isXmlHttpRequest()){

            $mail = $user->getEmail();

            return $this->render('MangoPlatformBundle:Index:viewMail.html.twig', array( 'mail' => $mail));
        }
    }

    public function viewPhoneAction($id, Request $request){
        $em = $this->getDoctrine()->getManager(); 
        $id = $request->request->get('id');
        $user = $em->getRepository('UserBundle:User')->find($id); 

        if($request->isXmlHttpRequest()){

            $phone = $user->getPhone();

            return $this->render('MangoPlatformBundle:Index:viewPhone.html.twig', array( 'phone' => $phone));
        }
    }

}
