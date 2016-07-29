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

  public function getStatistics()
  {
    return $this->getEntityManager()
        ->createQuery("SELECT u.id, u.avatar, u.username, u.roles, sum(t.burnedFuel) as fuelBurned, sum(t.distance) as distanceTravelled, count(t.id) AS transportsMaded, sum(t.score) as moneyEarned FROM UserBundle:User u, TransportBundle:Transport t WHERE t.userId = u.id GROUP BY u.id")
        ->getResult();
  }
}
