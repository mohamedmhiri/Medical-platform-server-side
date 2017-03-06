<?php

namespace  Ben\DoctorsBundle\EventListener;

use Ben\DoctorsBundle\Entity\image;
use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Oneup\UploaderBundle\Event\PreUploadEvent;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Doctrine\ORM\EntityManager;

class UploadListener
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $request;
    protected $fileName;

    public function __construct(ObjectManager $om,RequestStack $requestStack)
    {
        $this->om = $om;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function onUpload(PostPersistEvent $event)
    {
//        $files = $event->getFile();
////        foreach ($files as $file) {
//        if(!$files)
//            return new JsonResponse(["response"=>"error"]);
//        $object = new image();
//        $object->setPath($files->getFileName());
//        $test=$this->om->getRepository('BenDoctorsBundle:Test')->findById(1);
//        $object->setTest($test[0]);
//        $this->om->persist($object);
////        }
//
//        $this->om->flush();
        $file = $event->getFile();
        $this->fileName = $file->getClientOriginalName();

//        $object = new image();
//        $object->setName($file->getClientOriginalName());
//        //$object->setName($file->getPathName());
//
//        $this->om->persist($object);
//        $this->om->flush();
//        $response = $event->getResponse();
//        $response['success'] = true;
//        return $response;
    }
    public function onPostUpload(PostPersistEvent $event)
    {
        $file = $event->getFile();

        $object = new image();
        $object->setPath($file->getClientOriginalName());
        //$object->setName($file->getPathName());

        $this->om->persist($object);
        $this->om->flush();
    }
}



