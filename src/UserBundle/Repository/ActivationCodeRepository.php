<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine;

class ActivationCodeRepository extends \Doctrine\ORM\EntityRepository
{
  public function findByCodeAndEmail($code, $email)
  {
    return $this->getEntityManager()
      ->createQuery('SELECT p FROM UserBundle:ActivationCode p WHERE p.activationCode = :code AND p.email = :email')
      ->setParameter('code', $code)
      ->setParameter('email', $email)
      ->getResult();
  }

  public function findByCode($code)
  {
    return $this->getEntityManager()
      ->createQuery('SELECT aC FROM UserBundle:ActivationCode aC WHERE aC.activationCode = :code')
      ->setParameter('code', $code)
      ->getSingleResult();
  }

  public function getRoleByCode($code)
  {
    return $this->getEntityManager()
      ->createQuery('SELECT aC.role FROM UserBundle:ActivationCode aC WHERE aC.activationCode = :code')
      ->setParameter('code', $code)
      ->getSingleScalarResult();
  }
}
