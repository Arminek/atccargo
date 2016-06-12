<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class ProfileController extends Controller
{
    public function indexAction()
    {
        return $this->render('@User/security/profile.html.twig', array(
            'role' => $this->transformRoles(),
        ));
    }

    public function transformRoles()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $role = implode(" ", $user->getRoles());

        switch($role)
        {
            case "ROLE_BOSS":
                $role = 'Boss';
                break;
            case "ROLE_VICEBOSS":
                $role = 'Vice Boss';
                break;
            case "ROLE_DISPATCHER":
                $role = 'Dispatcher';
                break;
            case "ROLE_DRIVER":
                $role = 'Driver';
                break;
            case "ROLE_DEMO":
                $role = "Demo";
                break;
        }

        return $role;
    }
}
