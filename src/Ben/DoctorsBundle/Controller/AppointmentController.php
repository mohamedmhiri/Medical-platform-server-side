<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ben\DoctorsBundle\Entity\Appointment;
use Ben\DoctorsBundle\Form\AppointmentType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * Appointment controller.
 *
 */
class AppointmentController extends Controller
{
    /**
     * makes an object able to be parsed with JSON
     */
    public function jsonFormatter($entity){
        $item=array();
        $item["id"]=$entity->getId();
        $item["start"]=$entity->getdate()->format('Y-m-d H:i:s');
        $tmp_end=$entity->getdate();
        $tmp_end->modify('+30 minutes');
        $item["end"]=$tmp_end->format('Y-m-d H:i:s');
        $item["person_id"]=$entity->getPerson()->getId();
        return $item;
    }
    /**
     * transforms a string of "yyyymmddhhmmss" to a Datetime Object
     */
    public function dateTimeFormatter($date)
    {
        $year=substr($date,0,4);
        $month=substr($date,4,2);
        $day=substr($date,6,2);
        $hour=substr($date,8,2);
        $minute=substr($date,10,2);
        $second=substr($date,12,2);
        $date=new \DateTime();
        $date->setDate($year,$month,$day);
        $date->setTime($hour,$minute,$second);
        return $date;
    }
    /**
     * Lists all Appointment entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BenDoctorsBundle:Appointment')->findAll();
        $appointments=array();
        foreach ( $entities as $entity)
        {
            $item=$this->jsonFormatter($entity);
            array_push($appointments,$item);
        }
        return new JsonResponse($appointments);
    }
    /**
     * Creates a new Appointment entity.
     *
     */
    public function createAction($date,$person)
    {
//        if(strlen($date)===14){
            $entity = new Appointment();
            $_date=$this->dateTimeFormatter($date);
            $entity->setDate($_date);
            $em=$this->getDoctrine()->getManager();
            $entity->setPerson($em->getRepository('BenDoctorsBundle:Person')->findById($person)[0]);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('ben_doctors_calendar'));

//        }
//        else
//        {
//            return new JsonResponse(["response"=>"error"]);
//        }

    }


    /**
     * Finds and displays a Appointment entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Appointment')->find($id);

        if (!$entity) {
            return new JsonResponse(["response"=>"error"]);

        }
        $tab=$this->jsonFormatter($entity);
        $tab["response"]="ok";
        return new JsonResponse($tab);
    }

    /**
     * Edits an existing Appointment entity.
     *
     */
    public function updateAction($id,$date,$person)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Appointment')->find($id);

        if (!$entity) {
            return new JsonResponse(["response"=>"error"]);

        }
        if(strlen($date)===14){
            $_date=$this->dateTimeFormatter($date);
            $entity->setDate($_date);
        }
        if(strlen($person)!==0)
            $entity->setPerson($em->getRepository('BenDoctorsBundle:Person')->findById($person)[0]);
        $em->persist($entity);
        $em->flush();
        $tab=$this->jsonFormatter($entity);
        $tab["response"]="ok";
        return new JsonResponse($tab);
    }
    /**
     * Deletes a Appointment entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BenDoctorsBundle:Appointment')->find($id);

        if (!$entity) {
            return new JsonResponse(["response"=>"error"]);
        }

        $em->remove($entity);
        $em->flush();
        $tab=$this->jsonFormatter($entity);
        $tab["response"]="ok";
        return new JsonResponse($tab);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function takeAppointmentAction($date, $patient){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BenDoctorsBundle:Person')->find($patient);
        $appointment = new Appointment();
        $_date = str_replace("%20"," ",$date);
        $appointment->setDate(date_create($_date));
        $appointment->setPerson($entity);
        $em->persist($appointment);
        $em->flush();
        return $this->redirect($this->generateUrl('ben_doctors_calendar'));
//        return new JsonResponse(["patient"=>$patient,"date"=>$date]);
    }

}
