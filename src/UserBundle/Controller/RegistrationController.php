<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Form\Type\UserType;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $session = new Session();
        if ($session->get('DURING_REGISTER') == true ) {
            // 1) build the form
            $user = new User();
            $form = $this->createForm(UserType::class, $user);

            // 2) handle the submit (will only happen on POST)
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $role = $this->transformRoles($session->get('roles'));
                $password = $this->get('security.password_encoder')
                  ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setRoles($role);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);

                $formCode = $session->get('code');
                $activationCode = $this->getDoctrine()
                  ->getRepository('UserBundle:ActivationCode')
                  ->findByCode($formCode);
                $em->remove($activationCode);
                $em->flush();
                $session->clear();

                $this->addFlash(
                  'notice',
                  'Pomyślnie zarejestrowano konto!'
                );
                
                return $this->redirectToRoute('login');
            }

            return $this->render(
              '@User/registration/register.html.twig',
              array('form' => $form->createView())
            );
        } else {
            return $this->redirectToRoute('home');
        }
    }
    public function transformRoles($roles)
    {
        switch($roles)
        {
            case "Szef":
                $role = "ROLE_BOSS";
                break;
            case "V-CE Szef":
                $role = "ROLE_VICEBOSS";
                break;
            case "Dyspozytor":
                $role = "ROLE_DISPATCHER";
                break;
            case "Kierowca":
                $role = "ROLE_DRIVER";
                break;
            case "Okres testowy":
                $role = "ROLE_DEMO";
                break;
        }

        return $role;
    }
}