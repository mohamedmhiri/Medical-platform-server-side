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

        $persons = $em->getRepository('BenDoctorsBundle:Person')->findActive();
        $entities = $em->getRepository('BenDoctorsBundle:Availability')->findComing();
        $apps_ = $em->getRepository('BenDoctorsBundle:Appointment')->findComing();
        $apps = [];
        $dates = [];
        $patients = [];
        foreach ( $persons as $person)
        {
            array_push($patients,$person);
        }
        foreach ($apps_ as $app)
        {
            array_push($apps,substr($app["date"],0,-3));
        }
        foreach ( $entities as $entity)
        {
            $time=substr($entity["start"],0,-3);
            while ($time < substr($entity["end"],0,-3))
            {
                if( !in_array( $time ,$apps ) )
                {
                    array_push($dates, $time );
                }
                $date_obj = date_create($time);
                $date_obj->modify('+30 minutes');
                $time = $date_obj->format('Y-m-d H:i');
            }
        }
        // there is an hour difference between now and tunisia
        return ["patients"=>$patients, "dates"=>$dates];
    }
    /**
     * returns calendar vue
     */
    public function indexAction()
    {
        return $this->render('BenDoctorsBundle:Calendar:calendar.html.twig',
//        return $this->render(
//            '/var/www/html/medical/src/Ben/DoctorsBundle/Resources/views/Calendar/calendar.html.twig',
            array("prepare"=>$this->prepare())
        );
//        return $this->prepare();
    }

    /**
     * Y-m-d H:i :string ==> array(Y) => array(m) => array(d H:i)
     */
    public function formatString($dates)
    {

    }

}