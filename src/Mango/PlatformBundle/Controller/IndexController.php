<?php

namespace Mango\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class IndexController extends Controller  //
{
    public function indexAction()  //Affichage page d'accueil
    {
    	return $this->render('MangoPlatformBundle:Index:index.html.twig');
    }

    public function contactAction()  //Afffichage page contact
    {
        return $this->render('MangoPlatformBundle:Index:contact.html.twig');
    }
}