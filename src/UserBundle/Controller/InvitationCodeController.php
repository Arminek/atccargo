<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Form\Type\CheckCodeType;
use UserBundle\Entity\ActivationCode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InvitationCodeController extends Controller
{
  public function checkAction(Request $request)
  {
    $activationCode = new ActivationCode();
    $session = new Session();

    $form = $this->createForm(CheckCodeType::class, $activationCode);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $formCode = $activationCode->getActivationCode();
      $formEmail = $activationCode->getEmail();

      $result = $this->getDoctrine()
        ->getRepository('UserBundle:ActivationCode')
        ->findByCodeAndEmail($formCode, $formEmail);

      if (count($result) < 1) {
        $this->addFlash(
          'notice',
          'Kod jest niepoprawny!'
        );

        return $this->redirectToRoute('register_verification');
      } else {
        $session->set('DURING_REGISTER', true);
        $session->set('email', $formEmail);
        $session->set('code', $formCode);
        $session->set('ROLE', 'Szef');

        return $this->redirectToRoute('register');
      }
    }

    return $this->render(
      '@User/registration/register_key.html.twig',
      array('form' => $form->createView())
    );
  }
}