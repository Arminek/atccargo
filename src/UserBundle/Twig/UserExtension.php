<?php

namespace UserBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class UserExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
  private $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function getGlobals()
  {
    return array(
      'fuelBurned'        => 1234,
      'distanceTravelled' => 1234,
      'moneyEarned'       => 1234,
      "transportsMaded"   => 1234,
    );
  }

  public function getName()
  {
    return 'user_extension';
  }
}