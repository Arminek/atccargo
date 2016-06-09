<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
  public function showAction()
  {
    return $this->render("@User/security/admin.html.twig");
  }
}