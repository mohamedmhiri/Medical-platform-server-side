<?php

namespace Ben\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Httpfoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
//$response = new JsonResponse();


class UserController extends Controller {



    public function trialAction()
    {
      /*count($usersCo=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByIsActivated(0));
      echo $usersCo[0]->getFirstName().' '.$usersCo[0]->getFamilyName();*/
      /*$objts=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByFirstName(explode(" ","Mohamed Mhiri")[0]);
      $objs=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByFamilyName(explode(" ","Mohamed Mhiri")[1]);
      print (count(array_intersect($objts,$objs)));*/
      //echo explode(" ","Mohamed Mhiri")[0]."</br>";
      //echo explode(" ","Mohamed Mhiri")[1];
        $em=$this->getDoctrine()->getManager();
        $id=$em->getRepository('BenUserBundle:User')->findByIsActivated(1)[0]->getId();
      /*$usersCo=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByUsername('admin');
      echo $usersCo[0]->getFirstName().' '.$usersCo[0]->getFamilyName();*/
      return new JsonResponse($id);
    }
    public function loginFbAction() {
        return $this->redirect($this->generateUrl("home"));
    }
    //

    /**
     * @Template()
     */
    public function whoIsOnlineAction() {
        $users = $this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->getActive();

        return array('users' => $users);
    }
    public function jsonFormatter($id)
    {


      $entity = $this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->find($id);
      $json_entity=array();
      $json_entity['id']=$entity.getId();
      $json_entity['familyname']=$entity.getFamilyName();
      $json_entity['firstname']=$entity.getFirstName();
      $json_entity['tel']=$entity.getTel();
      $json_entity['created']=$entity.getCreated();
      $json_entity['lastActivity']=$entity.getLastActivity();
      $json_entity['consultations']=$entity.getConsultations();
      return $json_entity;
    }
    /**
     * lists all users entities
     * using json response
     */
    public function listEntitiesAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('BenUserBundle:User');
        $response = new JsonResponse();
        $entities=$repository->findAll();
        $users=array();
        for($i=0;$i <count($entities);$i++)
        {
          $users[$i]=array();
          $users[$i]['id']=$entities[$i]->getId();
          $users[$i]['family_name']=$entities[$i]->getFamilyName();
          $users[$i]['first_name']=$entities[$i]->getFirstName();
          $users[$i]['tel']=$entities[$i]->getTel();
          $users[$i]['created']=$entities[$i]->getCreated();
          $users[$i]['lastActivity']=$entities[$i]->getLastActivity();
          $users[$i]['consultations']=$entities[$i]->getConsultations();
        }
        return $response->setData(array(
        'users' => $users/*[0]->getFirstName()*/ ));
    }
    /*
    * Post new user via Web Api
    */
    public function postEntityAction($entity)
    {
      $em = $this->get('fos_user.user_manager');
      $entity = new User();
      $form = $this->createForm(new userType(), $entity);
      $form->bind($request);
      if ($form->isValid()) {
          $em->updateUser($entity, false);
          $entity->getImage()->upload();

          $this->getDoctrine()->getManager()->flush();
          $this->get('session')->getFlashBag()->add('info', "L'utilisateur a été ajouté avec succès.");
          return $this->redirect($this->generateUrl('ben_show_user', array('id' => $entity->getId())));
      }
      $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");

      return $this->render('BenUserBundle:user:new.html.twig', array('entity' => $entity, 'form' => $form->createView()));
    }
    /**
     * user json list
     */
    public function autocompleteAction() {
        $request = $this->get('request');
        $keyword = $request->get('term');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BenUserBundle:User')->autocomplete($keyword);
        return $this->render('BenUserBundle:User:autocomplete.json.twig', array(
                    'entities' => $entities
                ));
    }

}
