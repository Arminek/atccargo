<?php

namespace UserBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class UserExtension extends \Twig_Extension
{
  protected $doctrine;

  public function __construct(RegistryInterface $doctrine)
  {
    $this->doctrine = $doctrine;
  }

  public function getName()
  {
    return 'user_extension';
  }

  public function getGlobals()
  {
    return array('user' => $this->findAll());
  }

  public function findAll()
  {
    return $this->doctrine->getRepository('UserBundle:User')->findAll();
  }
}