<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ben\DoctorsBundle\Entity\Availability;
use Ben\DoctorsBundle\Form\AvailabilityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * Availability controller.
 *
 */
class AvailabilityController extends Controller
{
    /**
     * makes an object able to be parsed with JSON
     */
    public function jsonFormatter($entity){
        $item=array(
            "id"=>$entity->getId(),
            "start"=>$entity->getStart()->format('Y-m-d H:i:s'),
            "end"=>$entity->getEnd()->format('Y-m-d H:i:s'),
            "user_id"=>$entity->getUser()->getId()
        );
        return $item;
    }
    /**
     * transforms a string of "yyyymmddhhmmss" to a Datetime Object
     */
    public function dateTimeFormatter($datetime)
    {
        $year=substr($datetime,0,4);
        $month=substr($datetime,4,2);
        $day=substr($datetime,6,2);
        $hour=substr($datetime,8,2);
        $minute=substr($datetime,10,2);
        $second=substr($datetime,12,2);
        $date=new \DateTime();
        $date->setDate($year,$month,$day);
        $date->setTime($hour,$minute,$second);
        return $date;
    }
    /**
     * Lists all Availability entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BenDoctorsBundle:Availability')->findAll();
        $availabilities=array();
        foreach ( $entities as $entity)
        {
            $item=$this->jsonFormatter($entity);
            array_push($availabilities,$item);
        }
        return new JsonResponse(($availabilities));
    }
    /**
     * Lists all Availability entities with "availabilities=> {...}.
     *
     */
    public function retrieveAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BenDoctorsBundle:Availability')->findAll();
        $availabilities=array();
        foreach ( $entities as $entity)
        {
            $item=$this->jsonFormatter($entity);
            array_push($availabilities,$item);
        }
        return new JsonResponse(["availabilities"=>$availabilities]);
    }
    /**
     * Creates a new Availability entity.
     *
     */
    public function createAction($start,$end)
    {
        if(strlen($start)===14 && strlen($end) ===14){
            $entity = new Availability();
            $_start=$this->dateTimeFormatter($start);
            $_end=$this->dateTimeFormatter($end);
            $entity->setStart($_start);
            $entity->setEnd($_end);
            $em=$this->getDoctrine()->getManager();
            $entity->setUser($em->getRepository('BenUserBundle:User')->findByIsActivated(1)[0]);
            $em->persist($entity);
            $em->flush();
            $tab=$this->jsonFormatter($entity);
            $tab["response"]="ok";
            return new JsonResponse($tab);
        }
        else
        {
            return new JsonResponse(["response"=>"error"]);
        }

    }


    /**
     * Finds and displays an Availability entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Availability')->find($id);

        if (!$entity) {
            return new JsonResponse(["response"=>"error"]);

        }
        $tab=$this->jsonFormatter($entity);
        $tab["response"]="ok";
        return new JsonResponse($tab);
    }

    /**
     * Edits an existing Availability entity.
     *
     */
    public function updateAction($id,$start,$end)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Availability')->find($id);

        if (!$entity) {
            return new JsonResponse(["response"=>"error"]);

        }
            if(strlen($start)===14){
                $_start=$this->dateTimeFormatter($start);
                $entity->setStart($_start);
            }
            if(strlen($end)===14){
                $_end=$this->dateTimeFormatter($end);
                $entity->setEnd($_end);
            }
            $em->persist($entity);
            $em->flush();
            $tab=$this->jsonFormatter($entity);
            $tab["response"]="ok";
            return new JsonResponse($tab);
    }
    /**
     * Deletes a Availability entity.
     *
     */
    public function deleteAction($id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Availability')->find($id);

            if (!$entity) {
                return new JsonResponse(["response"=>"error"]);
            }

            $em->remove($entity);
            $em->flush();
            $tab=$this->jsonFormatter($entity);
            $tab["response"]="ok";
            return new JsonResponse($tab);
    }

}
