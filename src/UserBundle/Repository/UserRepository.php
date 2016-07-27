<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
  public function findAll()
  {
    return $this->getEntityManager()
      ->createQuery('SELECT u FROM UserBundle:User u ORDER BY u.username ASC')
      ->getResult();
  }
  
  public function removeById($id)
  {
    return $this->getEntityManager()
        ->createQuery("DELETE u FROM UserBundle:User u WHERE u.id = $id")
        ->getResult();
  }

  public function getTransportsCount()
  {
    return $this->getEntityManager()
        ->createQuery("SELECT COUNT `*` FROM TransportBundle:Transport t LEFT JOIN UserBundle:User u WHERE t.employeeId = u.id")
        ->getResult();
  }
}
