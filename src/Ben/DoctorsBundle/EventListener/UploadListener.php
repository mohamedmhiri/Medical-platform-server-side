<?php

namespace  Ben\DoctorsBundle\EventListener;

use Ben\DoctorsBundle\Entity\image;
use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadListener
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $request;

    public function __construct(ObjectManager $om,RequestStack $requestStack)
    {
        $this->om = $om;
        $this->request = $requestStack->getCurrentRequest();

    }

    public function onUpload(PostPersistEvent $event)
    {
        $files = $event->getFile();
//        foreach ($files as $file) {
        if(!$files)
            return new JsonResponse(["response"=>"error"]);
        $object = new image();
        $object->setPath($files->getFileName());
        $test=$this->om->getRepository('BenDoctorsBundle:Test')->findById(1);
        $object->setTest($test[0]);
        $this->om->persist($object);
//        }

        $this->om->flush();
    }

}