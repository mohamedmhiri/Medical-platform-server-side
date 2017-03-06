<?php
namespace Ben\UserBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Ben\UserBundle\Controller\SecurityController  ;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManager;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler {

  private $router;
    // private $em;
protected $container;
     /**
      * Constructor
      * @param RouterInterface   $router
      * @param EntityManager     $em
      */

    public function __construct( HttpUtils $httpUtils, array $options ,RouterInterface $router, \Symfony\Component\DependencyInjection\ContainerInterface $cont) {
        parent::__construct( $httpUtils, $options );
        $this->router = $router;
        $this->container=$cont;
        //$this->em = $em;
    }

    public function onAuthenticationSuccess( Request $request, TokenInterface $token) {
      $lastUsername=$request->request->get('_username');
      //$passwd=$request->request->get('_password');

      $em=$this->container->get('doctrine.orm.entity_manager');

      $objts=$em->getRepository('BenUserBundle:User')->findByUsername($lastUsername);
      //$objs=$em->getRepository('BenUserBundle:User')->findByPassword($passwd);
      echo $objts[0]->getFirstName();


      if (count/*(array_intersect*/($objts/*,$objs)*/)==1)
      {
          $em->persist($objts[0]->setIsActivated(true));
          $em->flush();
          $em->clear();

          //return $this->redirect("http://localhost:8000");

        /*  $entitiesLength = $em->getRepository('BenDoctorsBundle:Person')->counter();
          $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();
          return $this->render('BenDoctorsBundle:Person:index.html.twig', array(
              'cities' => $cities,
              'entitiesLength' => $entitiesLength,
              'image'=>       $image=$objts[0]->getImage()
));*/
      return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
      }
    }
}
