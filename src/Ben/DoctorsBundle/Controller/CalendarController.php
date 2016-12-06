<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 2016/09/19
 * Time: 6:28 AM
 */

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ben\DoctorsBundle\Entity\Appointment;
use Ben\DoctorsBundle\Form\AppointmentType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CalendarController
 * @package Ben\DoctorsBundle\Controller
 */
class CalendarController extends  Controller
{
    /**
     * lists all periods where a client can take an appointment
     */
    public function prepare()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BenDoctorsBundle:Availability')->findAll();
        $apps_ = $em->getRepository('BenDoctorsBundle:Appointment')->findAll();
        $apps = [];
        $dates = [];
        foreach ($apps_ as $app){
            array_push($apps,$app->getDate()->format('Y-m-d H:i:s'));
        }
        foreach ( $entities as $entity)
        {

            $time=$entity->getStart();
            while ($time->format('Y-m-d H:i:s') <= $entity->getEnd()->format('Y-m-d H:i:s')) {
                if( !in_array( $time->format('Y-m-d H:i:s') ,$apps ))
                    array_push($dates, $time->format('Y-m-d H:i:s') );
                $time->modify('+30 minutes')->format('Y-m-d H:i:s');
            }
        }
        return $dates;

    }
    /**
     * returns calendar vue
     */
    public function indexAction()
    {
        return $this->render(
            '/var/www/html/medical/src/Ben/DoctorsBundle/Resources/views/Calendar/calendar.html.twig',
            array("prepare"=>$this->prepare())
        );
    }

}