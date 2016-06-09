<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
  public function findAll()
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT user FROM UserBundle:User user ORDER BY user.username ASC'
      )
      ->getResult();
  }
}
