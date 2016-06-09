<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
  public function showAction()
  {
    return $this->render("@User/home.html.twig");
  }
}