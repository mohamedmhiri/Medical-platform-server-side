<?php
//
//namespace Ben\DoctorsBundle\Entity;
//
///**
// * DefaultRepository
// *
// * This class is used to get statistics.
// */
//class DefaultRepository extends EntityRepository
//{
//
//
//    public function findByNbCustomersInMonth($nb)
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=month(now()-:nb)')
//            ->setParameter('nb', $nb)
////            ->andWhere('YEAR(co.created)-(YEAR (now())) <2')
//        ;//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function getPreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-1)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get2PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-2)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get3PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-3)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get4PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-4)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get5PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-5)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get6PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-6)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get7PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-7)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get8PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-8)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get9PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-9)')//
//            ->andWhere('YEAR(co.created)=(YEAR (now())) ')
//            ->orWhere('YEAR(co.created)-(YEAR (now())) <2');//
//
//        return $qb->getQuery()->getResult();
//    }
//    public function get10PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-10)')//
//            ->andWhere('YEAR(co.created)=(YEAR (now())) ')
//            ->orWhere('YEAR(co.created)-(YEAR (now())) <2');//
//        return $qb->getQuery()->getResult();
//    }
//    public function get11PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-11)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2 ');//
//        return $qb->getQuery()->getResult();
//    }
//    public function get12PreviousMonth()
//    {
//        $em=$this->getDoctrine()->getManager();
//
//        $qb = $em->createQueryBuilder();
//        $qb->select('co')
//            ->from('BenDoctorsBundle:consultation','co')
//            ->where('month(co.created)=(month(now())-12)')//
//            ->andWhere('YEAR(co.created)-(YEAR (now())) <2');//
//        return $qb->getQuery()->getResult();
//    }

//}