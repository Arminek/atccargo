<?php

namespace AppBundle\Controller;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
  public function selectAction()
  {
    if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
      return $this->redirectToRoute('login');
    } else {
      return $this->redirectToRoute('dashboard');
    }
  }
}