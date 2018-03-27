<?php

namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Mango\PlatformBundle\Form\ContactType;
use Mango\PlatformBundle\Entity\Contact;

class IndexController extends Controller  
{
    public function indexAction()  //Affichage page d'accueil
    {
        $active = '';
    	return $this->render('MangoPlatformBundle:Index:index.html.twig', array('active' => $active));
    }

    public function proposerAction()  //Affichage page d'ajout, si non connecté
    {
        $active = "proposer";  //ajout classe active sur le lien de la page concernée
        return $this->render('MangoPlatformBundle:Index:proposer.html.twig', array('active' => $active));
    }

    public function contactAction(Request $request)  //Afffichage page contact
    {
        $active = "contacter";
    	$contact = new Contact();
    	$form = $this->createForm(ContactType::class, $contact); //Création du formulaire

    	if($request->isMethod('POST')){
    		$form ->handleRequest($request); //Lie les valeurs du formulaire à $contact
            
            if($form->isValid()){
            	$message = (new \Swift_Message())  //Envoi mail
            			->setSubject($contact->getSubject())
            			->setFrom($contact->getEmail())
            			->setTo('emilie.leterme@gmail.com')
            			->setBody($this->renderView('MangoPlatformBundle:Index:message.html.twig', array('contact' => $contact)));
                $this->get('mailer')->send($message);

            	$request->getsession()->getflashBag()->add('notice', 'Votre message a bien été envoyé, il sera traité dans les plus brefs délais'); //Notification
            }
        } 
        return $this->render('MangoPlatformBundle:Index:contact.html.twig', array('form'=>$form->createView(), 'active' => $active));
    }
}
