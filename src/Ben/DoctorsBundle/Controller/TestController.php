<?php

namespace Ben\DoctorsBundle\Controller;

use Ben\DoctorsBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Test;
use Ben\DoctorsBundle\Form\TestType;
use Ben\DoctorsBundle\Entity\image;

use Ben\DoctorsBundle\Pagination\Paginator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


/**
 * Test controller.
 *
 */
class TestController extends Controller
{

    /**
     * Lists all Test entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $doctors = $em->getRepository('BenUserBundle:User')->findAll();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Test')->counter();

        return $this->render('BenDoctorsBundle:Test:index.html.twig', array(
            'doctors' => $doctors,
            'entitiesLength' => $entitiesLength));
    }

    /**
     * Tests list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('BenDoctorsBundle:Test')->search($searchParam);
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:Test:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }
    /**
     * Creates a new Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Test();
        $form = $this->createForm(new TestType(), $entity);
        $form->handleRequest($request);
//        return new JsonResponse(["files"=>$request->files]);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setPerson($em->getRepository('BenDoctorsBundle:Person')->find((int)$request->get("person")));

            $em->persist($entity);
            $em->flush();
//            $this->get('session')->getFlashBag()->add('info', "L'examen a été ajouté avec succès.");
//            return new JsonResponse(["response" => $entity->getId()]);
            $images = [];
            $i=0;
            while($files = $request->get('file'.$i))
            {
//                echo $files;
                $image = new image();
                $image->setTest($entity);
                $image->setPath($files);

//                $tmp = $image->getFile();
                array_push($images,$tmp);
//                $fileName = md5(uniqid()).'.'.$file->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                $file->move(
//                    $this->getParameter('brochures_directory'),
//                    $fileName
//                );
                $em->persist($image);
                $em->flush();
                $i++;
            }


//            return new JsonResponse(["files"=>$images]);
//            if(is_array($files))
//            {
//                foreach ($files as $file)
//                {
//                    $image = new image();
//                    $image->setTest($entity);
//                    $image->setPath($file);
//                    $em->persist($image);
//                    $em->flush();
//                }
//            }else
//            {
//                $image = new image();
//                $image->setTest($entity);
//                $image->setPath($files);
//                $em->persist($image);
//                $em->flush();
//            }

//            sleep(100000);

            return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getPerson()->getId())));
        }

//        $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
        return $this->render('BenDoctorsBundle:Test:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    // public function createAction(Request $request)
    // {
    //     $entity = new Person();
    //     $form = $this->createForm(new PersonType(), $entity);
    //     $form->handleRequest($request);
    //     $em = $this->getDoctrine()->getManager();
    //
    //     if ($form->isValid()) {
    //         $em->persist($entity);
    //         $em->flush();
    //
    //         $this->get('session')->getFlashBag()->add('info', "Le patient a été ajouté avec succès.");
    //         return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getId())));
    //     }
    //     // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();
    //
    //     $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
    //     return $this->render('BenDoctorsBundle:Person:new.html.twig', array(
    //         'entity' => $entity,
    //         'form'   => $form->createView(),
    //         // 'cities' => $cities,
    //     ));
    // }

    /**
     * Displays a form to create a new Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction(Person $person)
    {
        $entity = new Test();
        $entity->setPerson($person);
        $form   = $this->createForm(new TestType(), $entity);

        return $this->render('BenDoctorsBundle:Test:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        return $this->render('BenDoctorsBundle:Test:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }
        $editForm = $this->createForm(new TestType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Test:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Edits an existing Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TestType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            foreach ($entity->getImages() as $key => $value) {
            $value->upload();  
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getPerson()->getId())));
        }

        return $this->render('BenDoctorsBundle:Test:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Test entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);
            if (!$entity)
                throw $this->createNotFoundException('Unable to find Test entity.');

//            $consultation = $entity->getConsultation();
//            $currentUser = $this->get('security.context')->getToken()->getUser();
//            if ($currentUser != $consultation->getUser() && !$this->get('security.context')->isGranted('ROLE_ADMIN'))
//            {}
////                $this->get('session')->getFlashBag()->add('danger', "Unauthorized access.");
//            else{
            $entity->setIsDeleted(true);
            $em->persist($entity);
            $em->flush();
//                $this->get('session')->getFlashBag()->add('info', "Action effectué avec succès !");
//            }

        return $this->redirect($this->generateUrl('person_show', array('id' => $entity->getPerson()->getId())));
    }

    /**
     * Creates a form to delete a Test entity by id.
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
     * Deletes multiple entities
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction(Request $request)
    {
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BenDoctorsBundle:Test')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }
    /**
     * Finds and displays a test's image.
     *
     *
     */
    public function showImageAction($id,$id_image)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }
        $image=null;
        foreach ($entity->getImages() as $key => $value) {
            if($value->getId()==$id_image){
              $image=$value->getPath();
              break;
            }
        }


        return $this->render('BenDoctorsBundle:Test:image.html.twig', array(
            'image'      => $image,

        ));
    }
    /**
     * inserts an array of images into db
     */
    public function addImageAction($file,$id)
    {
        //$images=$request->request->/*get('file');*/all();

        if(!$file)
            return new JsonResponse(["response"=>"error"]);
        $em = $this->getDoctrine()->getManager();
        $object = new image();
        $object->setPath($file);
        $test = $em->getRepository('BenDoctorsBundle:Test')->find($id);
        $object->setTest($test);
        $fs = new Filesystem();

        $fs->copy("/home/mohamed/Pictures/".$file,"uploads/img/".$file);
        $em->persist($object);
        $em->flush();
        return new JsonResponse(["response"=>"OK"]);
    }

    /***
     * @return JsonResponse
     * @param $id
     * returns list of images for a specific test
     */
    public function getImagesAction($id){

        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('BenDoctorsBundle:Test')->find($id);
        if($test){
            $images = $test->getImages();
            $response = [];
            $response[ "id" ]= $id;
            $response[ "id_images" ] = [];
            foreach ($images as $index=>$image){
                $response[ "id_images"][$index] = [];
                array_push($response[ "id_images" ][$index], $image->getId());
                array_push($response[ "id_images" ][$index], $image->getPath());
            }

            return new JsonResponse(["response"=> $response ]);
        }
        return new JsonResponse(["response"=>"error"]);
    }
}
