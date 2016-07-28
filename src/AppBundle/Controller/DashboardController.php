<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
  public function showAction()
  {
    $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();

    $transports = $this->getDoctrine()->getRepository('TransportBundle:Transport')
        ->findFiveById($userId);

    return $this->render('@User/home.html.twig', array(
      'transports' => $transports,
    ));
  }
}