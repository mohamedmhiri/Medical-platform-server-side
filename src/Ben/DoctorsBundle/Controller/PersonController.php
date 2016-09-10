<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Person;
use Ben\DoctorsBundle\Form\PersonType;

use Ben\DoctorsBundle\Pagination\Paginator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Person controller.
 *
 */
class PersonController extends Controller
{



    public function linkAction()
    {
      return new RedirectResponse('http://medical.placeholder.tn/booking2/public/admin/appointments');
    }
    /**
     * Lists all Person entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        // var_dump($this);die;
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Person')->counter();
        $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();

        return $this->render('BenDoctorsBundle:Person:index.html.twig', array(
            'cities' => $cities,
            'entitiesLength' => $entitiesLength));
    }
    public function prepareJWT()
    {
      if(count($usersCo=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByIsActivated(1))==0)
      {
        //go to /login
        return 'http://localhost:8080/admin';
      }
      else
      {
        return $usersCo[0]->getFirstName().' '.$usersCo[0]->getFamilyName();

      }
    }
    /**
     * persons list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $persons=array();
        if(!strpos($this->prepareJWT()," "))
        {
          //hedhi heya eli trajaa f response
          return new RedirectResponse("http://localhost:8080/admin");

        }
        else
        {
        $list=$this->listNonPatients();
        $persons=$this->storeNonPatients($list,$persons);
        for($i=0;$i<count($persons) ;$i++) {
          $em->persist($persons[$i]);
          $em->flush();
          $em->clear();
        }
        $entities = $em->getRepository('BenDoctorsBundle:Person')->search($searchParam)/*findAll()*/;
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:Person:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                  ));
        }
    }
    /**utility
    *
    */
    function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
    /**
    *persons list wia web Api
    *
    */
    public function listNonPatients/*Action*/()
    {
        if(!strpos($this->prepareJWT()," "))
        {
          //hedhi heya eli trajaa f response
          return array('jwt'=>$this->prepareJWT(),'error'=>"",'last_username'=>"");

        }
        else
        {
          $name=str_replace(" ","%20",$this->prepareJWT());
          //echo 'http://localhost:8080/patients/'.$name;
          //$json = file_get_contents('http://medical.placeholder.tn/booking2/public/patients'.$email);
          $json = $this->file_get_contents_curl('http://localhost:8080/patients/'.$name);
          return $obj = json_decode($json);
        }

    }

    /**
    * test weather person is nonpatient or patient
    *
    */
    public function isNonPatient($person)
    {
      $isPatient = false;
      $entities = $this->getDoctrine()->getManager()
                       ->getRepository('BenDoctorsBundle:Person')->findAll();
      $i=0;
      while ($i < count($entities)) {
          if(strcmp(strtolower($entities[$i]->getEmail()),strtolower($person->email))!=0)
            $i++;
          else
            break 1;
      }
      if(($i ==(count($entities)))&&(strcmp(strtolower($entities[count($entities)-1]->getEmail()),strtolower($person->email))!=0))
        return true;
      else
        return false;
    }
    /**
    *
    * get the notpatient's email
    * to test weather old_email is up to date or not
    */
    public function oldEmail($entity)
    {
      $npatients=$this->listNonPatients();

      if($entity->getISNP()==true)
        {$i=0;
        while($i<count($npatients))
        {
          if($npatients[$i]->id==$entity->getNpid())
            return $npatients[$i]->email;
          else
            $i++;
        }
      }

    }

    /**
    * store nonpatients entities into an array
    *
    */
    public function storeNonPatients($list,$persons)
    {

      for ($i=0;$i< count($list);$i++)
      {
        if($this->isNonPatient($list[$i])==true)
        {
          $entity = new Person();
          $entity=$entity->setEmail($list[$i]->email);
          $entity=$entity->setOldemail($list[$i]->email);
          $entity=$entity->setFamilyname($list[$i]->last_name);
          $entity=$entity->setFirstname($list[$i]->first_name);
          $entity=$entity->setGsm($list[$i]->contact_number);
          $entity=$entity->setCin(" ");
          $entity=$entity->setGender(" ");
          $entity=$entity->setCnsstype(" ");
          $entity=$entity->setISNP(true);
          $entity=$entity->setNpid($list[$i]->id);
          $entity=$entity->setCreated(null);
          array_push($persons,$entity);
        }

      }
      return $persons;
    }


    /**
     * Creates a new Person entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Person();
        $form = $this->createForm(new PersonType(), $entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "Le patient a été ajouté avec succès.");
            return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getId())));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
        return $this->render('BenDoctorsBundle:Person:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Displays a form to create a new Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction()
    {
        $entity = new Person();
        $form = $this->createForm(new PersonType(), $entity);
        $em = $this->getDoctrine()->getManager();
        // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();

        return $this->render('BenDoctorsBundle:Person:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Finds and displays a Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Person:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }
        if(strcmp(strtolower($entity->getOldemail()),strtolower($this->oldEmail($entity))!=0))
        {
          $entity->setOldemail($this->oldEmail($entity));
          $em->flush();
        }
        $editForm = $this->createForm(new PersonType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();

        return $this->render('BenDoctorsBundle:Person:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }
    /**
     * Edits an existing Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }
        $email=$entity->getEmail();
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PersonType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
          if($entity->getISNP()==true)
          {
            $entity_to_array=array();
            // "first_name": "Joe",
            //"last_name": "Danger",
            // "contact_number": "6666666666",
            //    "new_email":"joe@gmail.com" ,
            //"old_email": "joedanger@gmail.com"
            $entity_to_array["first_name"]=$entity->getFirstName();
            $entity_to_array["last_name"]=$entity->getFamilyName();
            $entity_to_array["contact_number"]=$entity->getGsm();
            $entity_to_array["new_email"]=$editForm->getData()->getEmail();
            $entity_to_array["old_email"]=$entity->getOldemail();//$entity->getEmail();//$request->get('email');
            // if($this->isOld($entity->getOldemail())==true)
            //
            // else
            //   $entity_to_array["old_email"]=$entity->getEmail();
            $jsonInfo=json_encode($entity_to_array);
            if(!strpos($this->prepareJWT()," "))
            {
              return $this->render($this->prepareJWT());
            }
            else
            {
              $name=str_replace(" ","%20",$this->prepareJWT(),array('error'=>"",'last_username'=>""));
              $curl = curl_init('http://localhost:8080/updatePatient/'.$jsonInfo.'/'.$name);
              // Send the request & save response to $resp
              $resp = curl_exec($curl);
              // Close request to clear up some resources
              curl_close($curl);
            }
            //$curl = curl_init('http://medical.placeholder.tn/booking2/public/updatePatient/'.$jsonInfo.$email);

            //$r=file_get_contents('http://medical.placeholder.tn/booking2/public/updatePatient/'.$jsonInfo);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "Le patient a été mis à jour avec succès.");
            return $this->redirect($this->generateUrl('person_edit', array('id' => $id)));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
        return $this->render('BenDoctorsBundle:Person:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }
    /**
     * Deletes multiple entities
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction(Request $request)
    {
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BenDoctorsBundle:Person')->search(array('ids'=>$ids));
        foreach( $entities as $entity)
        {
          if($entity->getISNP()==true)
          {


            if(!strpos($this->prepareJWT()," "))
            {
              return $this->render($this->prepareJWT(),array('error'=>"",'last_username'=>""));
            }
            else
            {
              $name=str_replace(" ","%20",$this->prepareJWT());
              $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_RETURNTRANSFER => 1,
                  //CURLOPT_URL => 'http://medical.placeholder.tn/booking2/public/deletePatient/'.$entity->getEmail().$email
                  CURLOPT_URL => 'http://localhost:8080/deletePatient/'.$entity->getEmail().'/'.$name

                ));
              // Send the request & save response to $resp
              $resp = curl_exec($curl);
              // Close request to clear up some resources
              curl_close($curl);
            }


          }
          $em->remove($entity);
        }
        $em->flush();

        return $this->redirect($this->generateUrl('person'));
    }
    /**
     * Deletes a Person entity.
     * @Secure(roles="ROLE_MANAGER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);



            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Person')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Person entity.');
            }
            /*send a put httprequest to delete the entity*/
            if($entity->getISNP()==true)
            {
              if(!strpos($this->prepareJWT()," "))
              {
                return $this->render($this->prepareJWT(),array('error'=>"",'last_username'=>""));
              }
              else
              {
                $name=str_replace(" ","%20",$this->prepareJWT());
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    //CURLOPT_URL => 'http://medical.placeholder.tn/booking2/public/deletePatient/'.$entity->getEmail().$email
                    CURLOPT_URL => 'http://localhost:8080/deletePatient/'.$entity->getEmail().'/'.$name

                  ));
                // Send the request & save response to $resp
                $resp = curl_exec($curl);
                // Close request to clear up some resources
                curl_close($curl);
              }
            }
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Action effectué avec succès !");


        return $this->redirect($this->generateUrl('person'));
    }

    /**
     * Creates a form to delete a Person entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    /**
    *guzzle trial
    *
    */
    public function guzzleAction()
    {
      /*$curl = curl_init('http://localhost:8080/guzzle/'.$this->prepareJWT());
      // Send the request & save response to $resp
      $resp = curl_exec($curl);
      // Close request to clear up some resources
      curl_close($curl);*/

      return new JsonResponse(array('name'=>json_encode($this->prepareJWT())));
    }


}
