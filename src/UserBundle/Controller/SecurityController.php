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
use UserBundle\Form\Type\PositionType;

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
      }

      $role = $repository->getRoleByCode($code);

      $session = new Session();
      $session->set('code', $code);
      $session->set('email', $email);
      $session->set('role', $role);

      return $this->redirectToRoute('register');
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
        'Email has been sent! '
      );

      return $this->redirectToRoute('employee_add');
    }

    return $this->render(
      '@User/security/employee/employee_add.html.twig',
      array('form' => $form->createView())
    );
  }

  /**
   * Check user inputted good registration code.
   */
  public function isDuringRegistration()
  {
    $session = new Session();
    $code = $session->get('code');
    $email = $session->get('email');

    $repository = $this->getDoctrine()->getRepository('UserBundle:ActivationCode');

    $code = $repository
        ->findByCodeAndEmail($code, $email);

    if (count($code) > 0)
    {
      return true;
    } else {
    return false;
  }
  }

  public function manageEmployeesAction()
  {
    $repository = $this->getDoctrine()->getRepository("UserBundle:User");

    $users = $repository->findAll();

    return $this->render("@User/security/employee/manage_employees.html.twig", array(
      'users' => $users,
    ));
  }

  public function changePositionAction($id, Request $request) {
    $repository = $this->getDoctrine()->getRepository('UserBundle:User');
    $user = $repository->find($id);
    
    $form = $this->createForm(PositionType::class, $user);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      $em->refresh($user);

      $this->addFlash(
          'notice',
          'Position has been changed! '
      );

      return $this->redirectToRoute('dashboard');
    }

    return $this->render(
        '@User/security/employee/change_position.html.twig',
        array('form' => $form->createView())
    );
  }

  public function removeUserAction($id)
  {
    if ($this->get('security.authorization_checker')->isGranted('ROLE_BOSS')) {
      $repository = $this->getDoctrine()->getRepository('UserBundle:User');
      $repository->removeById($id);
    }

    return $this->redirectToRoute('dashboard');
  }

  public function showDriverListAction()
  {
    $repository = $this->getDoctrine()->getRepository("UserBundle:User");
    $users = $repository->findAll();

    return $this->render('@User/driver_list.html.twig', array(
      'users' => $users,
    ));
  }

  public function showDriverStatisticsAction()
  {
    $repository = $this->getDoctrine()->getRepository("UserBundle:User");
    $users = $repository->findAll();

    return $this->render('@User/driver_statistics.html.twig', array(
      'users' => $users,
    ));
  }
}