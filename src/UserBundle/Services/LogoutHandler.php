<?php

namespace UserBundle\Services;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutHandler implements LogoutSuccessHandlerInterface
{
  public function onLogoutSuccess(Request $request)
  {
    return new RedirectResponse("/login");
  }
}