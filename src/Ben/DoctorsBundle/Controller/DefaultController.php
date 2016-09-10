<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Validator\Constraints\DateTime;
use Ben\DoctorsBundle\Entity\Consultation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;


class DefaultController extends Controller
{


    /********************************/
    public function getThisMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=month(now())')//
      ->andWhere('YEAR(co.created)=YEAR (now()) ');//
      return $qb->getQuery()->getResult();
    }
    public function getPreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-1)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get2PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-2)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get3PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-3)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get4PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-4)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get5PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-5)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get6PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-6)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get7PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-7)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get8PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-8)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get9PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-9)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get10PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-10)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get11PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-11)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function get12PreviousMonth()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:consultation','co')
      ->where('month(co.created)=(month(now())-12)')//
      ->andWhere('YEAR(co.created)=(YEAR (now())) ');//
      return $qb->getQuery()->getResult();
    }
    public function getBirthdays()
    {
      $em=$this->getDoctrine()->getManager();

      $qb = $em->createQueryBuilder();
      $qb->select('co')
      ->from('BenDoctorsBundle:person','co')
      ->where('co.birthday is not null');
      return $qb->getQuery()->getResult();
    }
    /**chart appointments*
    */
    public function chartApiAction()
    {
      if(count($usersCo=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByIsActivated(1))==0)
      {
        //go to /login
        return new RedirectResponse('http://localhost:8080/admin');
      }
      else {
        $chart=json_encode([
          "this_month"=>count($this->getThisMonth()),
          "previous_month"=>count($this->getPreviousMonth()),
          "twoprevious_month"=>count($this->get2PreviousMonth()),
          "threeprevious_month"=>count($this->get3PreviousMonth()),
          "fourprevious_month"=>count($this->get4PreviousMonth()),
          "fiveprevious_month"=>count($this->get5PreviousMonth()),
          "sixprevious_month"=>count($this->get6PreviousMonth()),
          "sevenprevious_month"=>count($this->get7PreviousMonth()),
          "eightprevious_month"=>count($this->get8PreviousMonth()),
          "nineprevious_month"=>count($this->get9PreviousMonth()),
          "tenprevious_month"=>count($this->get10PreviousMonth()),
          "elevenprevious_month"=>count($this->get11PreviousMonth()),
          "twelveprevious_month"=>count($this->get12PreviousMonth())
        ]);
        return new Response($chart);
      }
    }
    /************************************/
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
      $em=$this->getDoctrine()->getManager();
      $objts=$em->getRepository('BenUserBundle:User')->findByIsActivated(1);
      if (count($objts)>0)
      {
        $em = $this->getDoctrine()->getManager();
        $nbentities = $em->getRepository('BenDoctorsBundle:Person')->counter();
        $women=$em->getRepository('BenDoctorsBundle:Person')->findByGender('Féminin');
        $birth=$this->getBirthdays();
        $bNull=$em->getRepository('BenDoctorsBundle:Person')->findByBirthday(NULL);
        $denAges=$nbentities-count($bNull);
        $p_femmes=(count($women)/$nbentities)*100;
        $p_hommes=100-$p_femmes;
        $nb_patients_this_month=count($this->getThisMonth());
        $old=0;
        $now=new \DateTime('now');
        $y=(int)$now->format('y');
        $m=(int)($now->format('m'));
        $d=(int)($now->format('d'));
        foreach ($birth as $key => $value) {
          if($value->getBirthday()!=null){
            ///to be modified

            $my_y=((int)($value->getBirthday()->format('y')))-100;
            $my_m=(int)($value->getBirthday()->format('m'));
            $my_d=(int)($value->getBirthday()->format('d'));
            $old+=($y-$my_y)+($m-$my_m)/12+($d-$my_d)/365;
          }
        }
        $age=$old/$denAges;
        $evolution=$nb_patients_this_month-count($this->getPreviousMonth());

        return $this->render('BenDoctorsBundle:Default:index.html.twig',array(
          'age'=>round($age),
          'p_femmes'=>$p_femmes,
          'p_hommes'=>$p_hommes,
          'nb_patients_this_month'=>$nb_patients_this_month,
          'evolution'=>$evolution

        ));

      }else {
        return new RedirectResponse('http://localhost:8080/admin');
      }
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function statsAction(Request $request)
    {
        $daterange = $request->get('daterange');
        $statsHandler = $this->get('ben.stats_handler')->setDateRange($daterange);
        $availableWidgets = ['meds', 'stock', 'cnss', 'consultations_demande', 'consultations_demande_gender', 'consultations_demande_resident',
                         'consultations_demande_resident_gender', 'consultations_systematique_resident', 'consultations_systematique_resident_gender',
                          'consultations_visual_issue', 'consultations_special', 'consultations_special_gender', 'consultations_chronic',
                          'consultations_not_chronic', 'consultations_structures'];
        $widgets = $request->get('widgets');
        $stats = [];
        if (isset($widgets)) {
            foreach ($widgets as $key => $val) {
                if(in_array($key, $availableWidgets))
                    $stats[$key] = $statsHandler->setDataColumn($key)->processData();
            }
        }

        return $this->render('BenDoctorsBundle:Default:ajaxStats.html.twig', array(
            'stats' => $stats));
    }
}
