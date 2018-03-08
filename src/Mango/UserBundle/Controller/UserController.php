<?php
 
namespace Mango\UserBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\SecurityController as SecurityController;
 
use Mango\UserBundle\Entity\User;
 
/**
 * Description of UserController
 *
 */
class UserController extends SecurityController {
 
    public function LoginBisAction()
{
    $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
 
    return $this->container->get('templating')->renderResponse('FOSUserBundle:Security:login_content.html.twig', array(
        'last_username' => null,
        'error'         => null,
        'csrf_token'    => $csrfToken
    ));
}
     
}