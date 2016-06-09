<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ActivationCodeRepository extends \Doctrine\ORM\EntityRepository
{
  public function findByCodeAndEmail($code, $email)
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT p FROM UserBundle:ActivationCode p WHERE p.activationCode = :code AND p.email = :email'
      )->setParameter('code', $code)
      ->setParameter('email', $email)
      ->getResult();
  }
}
