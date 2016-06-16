<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\ActivationCode;
use UserBundle\Form\Type\ActivationCodeType;
use UserBundle\Entity\User;
use UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\CheckCodeType;

class SecurityController extends Controller
{
  public function loginAction(Request $request)
  {
    $authenticationUtils = $this->get('security.authentication_utils');

    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render(
      '@User/security/login.html.twig',
      array(
        'last_username' => $lastUsername,
        'error'         => $error,
      )
    );
  }

  public function registerVerificationAction(Request $request)
  {
    $activationCode = new ActivationCode();
    $form = $this->createForm(CheckCodeType::class, $activationCode);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $repository = $this->getDoctrine()->getRepository('UserBundle:ActivationCode');
      $code = $activationCode->getActivationCode();
      $email = $activationCode->getEmail();

      $registrationCode = $repository
        ->findByCodeAndEmail($code, $email);

      if (count($registrationCode) < 1) {

        $this->addFlash(
          'notice',
          'transport_report_succes'
        );

        return $this->redirectToRoute('register_verification');
      } else {

        $role = $repository->getRoleByCode($code);

        $session = new Session();
        $session->set('DURING_REGISTER', true);
        $session->set('code', $code);
        $session->set('role', $role);

        return $this->redirectToRoute('register');
      }
    }

    return $this->render(
      '@User/security/registration/register_verification.html.twig',
      array('form' => $form->createView())
    );
  }

  public function registerAction(Request $request)
  {
    if ($this->isDuringRegistration()) {
      $user = new User();
      $session = new Session();
      $form = $this->createForm(UserType::class, $user);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
          return $this->render(
            '@User/security/registration/register.html.twig', array(
              'form' => $form->createView(),
              'errors' => $errors,
            )
          );
        }
        
        $password = $this->get('security.password_encoder')
          ->encodePassword($user, $user->getPlainPassword());
        $role = $session->get('role');

        $user->setPassword($password);
        $user->setRoles($role);

        // Add user to database
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);

        // Remove used registration code
        $session = new Session();
        $code = $session->get('code');
        $registrationCode = $this->getDoctrine()
          ->getRepository('UserBundle:ActivationCode')
          ->findByCode($code);
        $em->remove($registrationCode);
        $em->flush();
        $session->clear();

        $this->addFlash(
          'notice',
          'Account has been created!'
        );

        return $this->redirectToRoute('login');
      }

      return $this->render(
        '@User/security/registration/register.html.twig', array(
          'form' => $form->createView(),
          'role' => $session->get('role'),
        )
      );
    }

    return $this->redirectToRoute('register_verification');
  }

  public function employeeAddAction(Request $request)
  {
    $activationCode = new ActivationCode();
    $form = $this->createForm(ActivationCodeType::class, $activationCode);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $registrationCode = $activationCode->generateRegistrationCode();
      $role = $activationCode->getRole();

      $message = \Swift_Message::newInstance()
        ->setSubject('ATC Cargo - Twój kod rejestracyjny!')
        ->setFrom('freshekm@gmail.com')
        ->setTo($activationCode->getEmail())
        ->setBody(
          $this->renderView(
            '@User/email/registration_code.twig',
            array(
              'code' => $registrationCode,
              'role' => $role,
            )
          ),
          'text/html'
        )
      ;

      // Add registration code to database.
      $activationCode->setActivationCode($registrationCode);
      $activationCode->setRole($this->transformRole($role));
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
      '@User/security/employee/employee_add.html.twig',
      array('form' => $form->createView())
    );
  }

  public function transformRole($role)
  {
    switch($role)
    {
      case 'boss':
        $role = 'ROLE_BOSS';
        break;
      case 'vice boss':
        $role = 'ROLE_VICEBOSS';
        break;
      case 'dispatcher':
        $role = 'ROLE_DISPATCHER';
        break;
      case 'driver':
        $role = 'ROLE_DRIVER';
        break;
      case 'demo':
        $role = 'ROLE_DEMO';
        break;
      case 'szef':
        $role = 'ROLE_BOSS';
        break;
      case 'vice szef':
        $role = 'ROLE_VICEBOSS';
        break;
      case 'dyspozytor':
        $role = 'ROLE_DISPATCHER';
        break;
      case 'kierowca':
        $role = 'ROLE_DRIVER';
        break;
      case 'okres testowy':
        $role = 'ROLE_DEMO';
        break;
    }

    return $role;
  }

  /**
   * Check user inputted good registration code.
   */
  public function isDuringRegistration()
  {
    $session = new Session();
    $result = $session->get('DURING_REGISTER');

    if ($result == true) {
      return true;
    } else {
      return false;
    }
  }
}