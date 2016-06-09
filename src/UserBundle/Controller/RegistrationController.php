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

                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $this->get('security.password_encoder')
                  ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // 4) save the User!
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                  'notice',
                  'Account has been created!'
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
}