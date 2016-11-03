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
     * returns calendar vue
     */
    public function indexAction()
    {
        return $this->render('/var/www/html/medical/src/Ben/DoctorsBundle/Resources/views/Calendar/calendar.html.twig');
    }

}