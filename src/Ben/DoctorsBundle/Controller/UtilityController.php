<?php

namespace Ben\DoctorsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Httpfoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\JsonResponse;
use Ben\DoctorsBundle\Entity\Customer;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


class UtilityController extends Controller
{

    /**
     * trial function to test fineUploader
     */
    public function fineUploadAction(){
        return $this->render('/var/www/html/medical/src/Ben/DoctorsBundle/Resources/views/try.html.twig');
    }


    public function prepareLoginAction($name)
    {
      $em = $this->getDoctrine()->getManager();
      $users=$em->getRepository('BenDoctorsBundle:Customer')->findByName($name);
      $dt = Carbon::now();
      $tmp=$users[count($users)-1]->getValidUntil();
      $updt_tmp=$tmp->format('Y-m-d H:i:s');
      $date_time= Carbon::parse($updt_tmp);
      if($this->isLowerThen($dt,$date_time)===true)
      {
        $response=json_encode(array(
          'name'=>$users[count($users)-1]->getName(),
          'id'=>$users[count($users)-1]->getId()
        ));
      }
      else{
          $user=$users[count($users)-1]->setIsValid(false);
          $new_customer= new Customer();
          $new_customer->setName($name);
          $em->persist($user);
          $em->persist($new_customer);
          $em->flush();
          $em->clear();
          $response=json_encode(array(
            'name'=>$new_customer->getName(),
            'id'=>$new_customer->getId()

          ));
        }
        return new Response($response);
    }

    /**
    *
    * this function compares two Carbon objects and returns
    * weather the first obj is less/grater then the second obj or
    *
    */
    public function isLowerThen($date1,$date2)
    {
      $response=false;
      if($date1->year < $date2->year)
        $response=true;
      else if(($date1->year === $date2->year) && ($date1->month < $date2->month))
        $response=true;
      else if (($date1->year === $date2->year)&&($date1->month === $date2->month)&&($date1->day < $date2->day))
        $response=true;
      else if(($date1->year === $date2->year)&&($date1->month === $date2->month)&&($date1->day === $date2->day)&&($date1->hour < $date2->hour))
        $response=true;
      else if(($date1->year === $date2->year)&&($date1->month === $date2->month)&&($date1->day === $date2->day)&&($date1->hour === $date2->hour)&&($date1->minute < $date2->minute))
        $response=true;
      else if(($date1->year === $date2->year)&&($date1->month === $date2->month)&&($date1->day === $date2->day)&&($date1->hour === $date2->hour)&&($date1->minute === $date2->minute)&&($date1->second < $date2->second))
        $response=true;
      return $response;
    }
    public function authenticateAction($name,$id)
    {
      $customer=null;
      $em = $this->getDoctrine()->getManager();
      $users=$em->getRepository('BenDoctorsBundle:Customer')->findByName($name);
      $client=$em->getRepository('BenDoctorsBundle:Customer')->findById($id);
      foreach ($users as $key => $user) {
        if($user->getPassword()===$client[0]->getPassword())
        {
          $customer=$user;
          break;
        }
      }
      try {
        if($customer)
        {
            $repo  = $em->getRepository("BenUserBundle:User"); //Entity Repository
            $user = $repo->findByUsername("admin");
            if (!$user) {
                throw new UsernameNotFoundException("User not found");
            } else {

                $token = new UsernamePasswordToken($user[0], null, $this->container->getParameter('fos_user.firewall_name'), $user[0]->getRoles());
                $this->get("security.context")->setToken($token); //now the user is logged in

                //now dispatch the login event
                $request = $this->get("request");
                $event = new InteractiveLoginEvent($request, $token);
                $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                $em->persist($user[0]->setIsActivated(true));
                $em->flush();
                $em->clear();
                return new RedirectResponse("http://localhost:8000");
            }


        }
      } catch (Exception $e) {
          echo $e;
      }

    }
}
