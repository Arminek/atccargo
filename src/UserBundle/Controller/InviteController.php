<?php

namespace UserBundle\Controller;

use UserBundle\Form\Type\ActivationCodeType;
use UserBundle\Entity\ActivationCode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InviteController extends Controller
{
  public function inviteAction(Request $request)
  {
    $activationCode = new ActivationCode();
    $form = $this->createForm(ActivationCodeType::class, $activationCode);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      
      $generatedCode = $this->generateCode();
      $message = \Swift_Message::newInstance()
        ->setSubject('ATC Cargo - Twój kod aktywacyjny do rejestracji')
        ->setFrom('freshekm@gmail.com')
        ->setTo($activationCode->getEmail())
        ->setBody(
          $this->renderView(
            '@User/email/invitation.html.twig',
            array(
              'code' => $generatedCode,
              'role' => $activationCode->getRole(),
            )
          ),
          'text/html'
        )
      ;

      $activationCode->setActivationCode($generatedCode);
      $em = $this->getDoctrine()->getManager();
      $em->persist($activationCode);
      $em->flush();

      $this->get('mailer')->send($message);

      $this->addFlash(
        'notice',
        'Email has been sent!'
      );

      return $this->redirectToRoute('employee_add');
    }

    return $this->render(
      '@User/security/invite.html.twig',
      array('form' => $form->createView())
    );
  }
  public function generateCode()
  {
    return rand(1000, 9999);
  }
}