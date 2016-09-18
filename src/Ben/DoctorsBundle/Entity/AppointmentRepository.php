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

class AppointmentRepository extends EntityRepository
{
    public function counter() {
        $qb = $this->createQueryBuilder('m')->select('COUNT(m)');
        return $qb->getQuery()->getSingleScalarResult();
    }

}