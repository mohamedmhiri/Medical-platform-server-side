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
    /**
     * @param $int
     * @return array
     * this function returns an array
     * of a specific (month, year)
     */
    public function getMonthAndYear($int)
    {
        $month = date("n", strtotime("-".$int." month"));
        $year = date("Y", strtotime("-".$int." month"));
        return array(
            "month" => $month,
            "year" => $year
        );
    }

    /**
     *
     */
    public function averageAge()
    {
        $birth=$this->
        getDoctrine()
            ->getManager()
            ->getRepository('BenDoctorsBundle:Person')
            ->findByBirthdays();
        $sum = 0;
        foreach ($birth as $b)
        {
            $sum += date_create($b["birthday"])->diff(date_create('today'))->y ;
        }
        return round($sum / count($birth));
    }

    public function prepareTopChart()
    {
        return $consultations = $this->getDoctrine()
            ->getManager()
            ->getRepository('BenDoctorsBundle:Consultation')
            ->findByMonthOrderedByNbConsultation();
    }
    public function trialAction($int)
    {
        $consultations = $this->getDoctrine()
            ->getManager()
            ->getRepository('BenDoctorsBundle:Appointment')
            ->findByPerson($int);
        $i=0;
        while ($i < count($consultations))
        {
            print_r($consultations[$i]["date"]);
            $i++;
        }
    }
    public function prepareChart($month_0,$month_1,$month_2,$month_3,$month_4)
    {
        $nb_patients_this_month = $this->nbConsultationInMonth($month_0)["nb_patients"];
        $nb_patients_previous_month = $this->nbConsultationInMonth($month_1)["nb_patients"];
        $nb_patient2 = $this->nbConsultationInMonth($month_2)["nb_patients"];
        $nb_patient3 = $this->nbConsultationInMonth($month_3)["nb_patients"];
        $nb_patient4 = $this->nbConsultationInMonth($month_4)["nb_patients"];
        $sum = $nb_patients_this_month+$nb_patients_previous_month+$nb_patient2+$nb_patient3+$nb_patient4;

        $patients_this = round(($nb_patients_this_month/$sum)*100);
        $patients_1 = round(($nb_patients_previous_month/$sum)*100);
        $patients_2 = round(($nb_patient2/$sum)*100);
        $patients_3 = round(($nb_patient3/$sum)*100);
        $patients_4 = round(($nb_patient4/$sum)*100);
        return array(
            "month_0" => $patients_this,
            "date_0" => $this->nbConsultationInMonth(0)["date"],
            "month_1" => $patients_1,
            "date_1" => $this->nbConsultationInMonth(1)["date"],
            "month_2" => $patients_2,
            "date_2" => $this->nbConsultationInMonth(2)["date"],
            "month_3" => $patients_3,
            "date_3" => $this->nbConsultationInMonth(3)["date"],
            "month_4" => $patients_4,
            "date_4" => $this->nbConsultationInMonth(4)["date"]
        );
    }
    /**chart appointments*
    */
    public function chartApiAction()
    {
        $chart=json_encode(
            $this->prepareChart(0,1,2,3,4)
        );
        return new Response($chart);
//      }
    }
    /**chart appointments*
     */
    public function topChartApiAction()
    {
        $chart=json_encode(
            $this->prepareTopChart()
        );
        return new Response($chart);
//      }
    }


    public function nbConsultationInMonth($int)
    {
        $month = $this->getMonthAndYear($int)["month"];
        $year = $this->getMonthAndYear($int)["year"];
//        $chart=json_encode([
            $nb = count($this->getDoctrine()
                ->getManager()
                ->getRepository('BenDoctorsBundle:Consultation')
                ->findByNbCustomersInMonth($month, $year)
            );
        return array("nb_patients" => $nb, "date" =>$month."-".$year);
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
        $age=$this->averageAge();
        $p_femmes=(count($women)/$nbentities)*100;
        $p_hommes=100-$p_femmes;
        $nb_patients_this_month = $this->nbConsultationInMonth(0)["nb_patients"];
        $nb_patients_previous_month = $this->nbConsultationInMonth(1)["nb_patients"];
        $evolution=$nb_patients_this_month-$nb_patients_previous_month;
        $index_array = array(
            'age'=>round($age),
            'p_femmes'=>$p_femmes,
            'p_hommes'=>$p_hommes,
            'nb_patients_this_month'=>$nb_patients_this_month,
            'evolution'=>$evolution,
            //pie chart
            'date_0'=>$this->prepareChart(0,1,2,3,4)["date_0"],
            'month_0'=>$this->prepareChart(0,1,2,3,4)["month_0"],
            'date_1'=>$this->prepareChart(0,1,2,3,4)["date_1"],
            'month_1'=>$this->prepareChart(0,1,2,3,4)["month_1"],
            'date_2'=>$this->prepareChart(0,1,2,3,4)["date_2"],
            'month_2'=>$this->prepareChart(0,1,2,3,4)["month_2"],
            'date_3'=>$this->prepareChart(0,1,2,3,4)["date_3"],
            'month_3'=>$this->prepareChart(0,1,2,3,4)["month_3"],
            'date_4'=>$this->prepareChart(0,1,2,3,4)["date_4"],
            'month_4'=>$this->prepareChart(0,1,2,3,4)["month_4"]);
          if(count($this->prepareTopChart())>0)
          {
              $index_array['top_0']=$this->prepareTopChart()[0]['rendezvous'];
              $index_array['nb_0']=$this->prepareTopChart()[0]['total'];
          }else
          {
              $index_array['top_0']=null;
              $index_array['nb_0']=null;
          }
          if(count($this->prepareTopChart())>1)
          {
              $index_array['top_1']=$this->prepareTopChart()[1]['rendezvous'];
              $index_array['nb_1']=$this->prepareTopChart()[1]['total'];
          }else
          {
              $index_array['top_1']=null;
              $index_array['nb_1']=null;
          }
          if(count($this->prepareTopChart())>2)
          {
              $index_array['top_2']=$this->prepareTopChart()[2]['rendezvous'];
              $index_array['nb_2']=$this->prepareTopChart()[2]['total'];
          }else
          {
              $index_array['top_2']=null;
              $index_array['nb_2']=null;
          }
          if(count($this->prepareTopChart())>3)
          {
              $index_array['top_3']=$this->prepareTopChart()[3]['rendezvous'];
              $index_array['nb_3']=$this->prepareTopChart()[3]['total'];
          }else
          {
              $index_array['top_3']=null;
              $index_array['nb_3']=null;
          }
          if(count($this->prepareTopChart())>4)
          {
              $index_array['top_4']=$this->prepareTopChart()[4]['rendezvous'];
              $index_array['nb_4']=$this->prepareTopChart()[4]['total'];
          }else
          {
              $index_array['top_4']=null;
              $index_array['nb_4']=null;
          }
        return $this->render('BenDoctorsBundle:Default:index.html.twig'
            ,$index_array);
                //top chart

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

    public function uploadAction()
    {
        return $this->render('BenDoctorsBundle:Default:upload.html.twig');
    }
}
