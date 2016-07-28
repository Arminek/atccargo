<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use TransportBundle\Entity\Transport;
use TransportBundle\Form\Type\TransportType;
use Symfony\Component\HttpFoundation\Request;

class TransportController extends Controller
{
  public function reportAction(Request $request)
  {
    $transport = new Transport();
    $form = $this->createForm(TransportType::class, $transport);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $validator = $this->get('validator');
      $errors = $validator->validate($transport);

      if (count($errors) > 0) {
        return $this->render('@Transport/Form/report_new_transport.html.twig', array(
          'form' => $form,
          'errors' => $errors,
        ));
      }

      $employeeId = $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
      $score = $this->calculateScore($transport->getDistance(), $transport->getDamage());
      $transportId = $this->generateTransportId();
      $transport->setScore($score);
      $transport->setTransportId($transportId);
      $transport->setEmployeeId($employeeId);
      
      $em = $this->getDoctrine()->getManager();
      $em->persist($transport);
      $em->flush();

      $this->addFlash(
        'notice',
        'Transport has been reported!'
      );

      return $this->redirectToRoute('transport_report');
    }

    return $this->render(
      '@Transport/Form/report_new_transport.html.twig',
      array('form' => $form->createView())
    );
  }

  public function notActivatedAction()
  {
    $repository = $this->getDoctrine()->getRepository('TransportBundle:Transport');

    $transports = $repository->findNotActivated();

    return $this->render('@Transport/browse_transports.html.twig', array(
      'transports' => $transports,
    ));
  }

  public function calculateScore($distance, $damage)
  {
    $multipler = $this->getRoleMultipler();
    $score = ($distance * $multipler) * ((100-$damage) / 100);

    return $score;
  }

  public function getRoleMultipler()
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $rolesAsArray = $user->getRoles();
    $roles = $rolesAsArray[0];

    switch($roles)
    {
      case 'ROLE_BOSS':
        $multipler = 1.7;
        break;
      case 'ROLE_VICEBOSS':
        $multipler = 1.7;
        break;
      case 'ROLE_DISPATCHER':
        $multipler = 1.3;
        break;
      case 'ROLE_DRIVER':
        $multipler = 1.3;
        break;
      case 'ROLE_DEMO':
        $multipler = 0.8;
        break;
    }

    return $multipler;
  }

  public function generateTransportId()
  {
    $repository = $this->getDoctrine()->getRepository('TransportBundle:Transport');
    $transportCount = count($repository->findAll());

    $transportId = 'CGGE/'.date('M')[0].'000'.date('WdN').date('z')[0].$transportCount.'/'.date('isd');

    return $transportId;
  }

  public function activateTransportAction($id, Request $request)
  {
    if ($this->get('security.authorization_checker')->isGranted('ROLE_DISPATCHER')) {
      $em = $this->getDoctrine()
          ->getRepository('TransportBundle:Transport')
          ->activateById($id);

      $uri = $request->headers->get('referer');

      return $this->redirect($uri);
    }

    return $this->redirectToRoute('dashboard');
  }

  public function deactivateTransportAction($id, Request $request)
  {
    if ($this->get('security.authorization_checker')->isGranted('ROLE_DISPATCHER')) {
      $em = $this->getDoctrine()
          ->getRepository('TransportBundle:Transport')
          ->deactivateById($id);

      $uri = $request->headers->get('referer');

      return $this->redirect($uri);
    }

    return $this->redirectToRoute('dashboard');
  }

  public function removeTransportAction($id)
  {
    if ($this->get('security.authorization_checker')->isGranted('ROLE_DISPATCHER')) {
      $em = $this->getDoctrine()
          ->getRepository('TransportBundle:Transport')
          ->removeById($id);

      $uri = $request->headers->get('referer');

      return $this->redirect($uri);
    }

    return $this->redirectToRoute('dashboard');
  }

  public function showEmployeeTransportsAction($id)
  {
    $repository = $this->getDoctrine()->getRepository("TransportBundle:Transport");
    $transports = $repository->findAllById($id);

    return $this->render("@Transport/show_transports.html.twig", array(
        'transports' => $transports,
    ));
  }

  public function showMyTransportsAction()
  {
    $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();

    $repository = $this->getDoctrine()->getRepository('TransportBundle:Transport');
    $transports = $repository->findAllById($userId);

    return $this->render("@Transport/my_transports.html.twig", array(
      'transports' => $transports,
    ));
  }
}