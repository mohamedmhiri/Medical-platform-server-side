<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 2016/09/16
 * Time: 6:56 AM
 */

namespace Ben\DoctorsBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AvailabilityRepository extends EntityRepository
{
    public function counter() {
        $qb = $this->createQueryBuilder('m')->select('COUNT(m)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * get coming availabilities
     */
    public function findComing()
    {
        return  $this->fetch("select distinct start, end from availabilities where start > date(now())");
    }

    private function fetch($query)
    {
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute();
        return  $stmt->fetchAll();
    }

}