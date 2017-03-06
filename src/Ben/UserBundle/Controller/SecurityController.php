<?php

namespace Ben\UserBundle\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;




class SecurityController extends Controller
{
    /**
     * @Route("/error",name="error")
     *
     */
    public function errorAction()
    {
        return $this->render('/var/www/html/medical/src/Ben/UserBundle/Resources/views/Security/error.html.twig');

    }
  /**
  * @Route("/login", name="login")
  */
    public function loginAction()
    {
        if(count($usersCo=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByIsActivated(1))==1)
        {
            //user can't access to login
            return $this->render('/var/www/html/medical/src/Ben/UserBundle/Resources/views/Security/error.html.twig');
        }
        else
        {
              $request = $this->container->get('request');
              /* @var $request \Symfony\Component\HttpFoundation\Request */
              $session = $request->getSession();
              /* @var $session \Symfony\Component\HttpFoundation\Session\Session */
            //if(count($usersCo=$this->getDoctrine()->getManager()->getRepository('BenUserBundle:User')->findByIsActivated(1))==0)

            //{
              // get the error if any (works with forward and redirect -- see below)
              if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                  $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
              } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
                  $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                  $session->remove(SecurityContext::AUTHENTICATION_ERROR);
              } else {
                  $error = '';
              }

              if ($error) {
                  $error = $error->getMessage();
              }
              // last username entered by the user
              $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

              $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

              $registrationForm = $this->container->get('fos_user.registration.form');

               return $this->render('/var/www/html/medical/src/Ben/UserBundle/Resources/views/Security/login.html.twig',
               array(
                   'last_username' => $lastUsername,
                   'error'         => $error,
                   'csrf_token' => $csrfToken,
                   'form' => $registrationForm->createView(),
               ));
          //return new RedirectResponse("http://localhost:8080/admin");

        }


    }
    /**
    * @Route("/logout", name="logout")
    */
    public function logoutAction()
    {
        $em = $this->getDoctrine()->getManager();
        $objts = $em->getRepository('BenUserBundle:User')->findByIsActivated(1);
        if (count($objts) > 0) {
            $em->persist($objts[0]->setIsActivated(false));
            $em->flush();
            $em->clear();
        }
        $registrationForm = $this->container->get('fos_user.registration.form');
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return $this->render('/var/www/html/medical/src/Ben/UserBundle/Resources/views/Security/login.html.twig',
            array(
                'last_username' => '',
                'error' => '',
                'csrf_token' => '',
                'form' => $registrationForm->createView(),
            ));
    }
    /**
    * @Route("/check", name="check")
    */
    public function loginCheckAction(Request $request)
    {
      $lastUsername=$request->request->get('_username');
      $passwd=$request->request->get('_password');
      $em=$this->getDoctrine()->getManager();

      $objts=$em->getRepository('BenUserBundle:User')->findByUsername($lastUsername);
      //$objs=$em->getRepository('BenUserBundle:User')->findByPassword($passwd);



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
      }
      /*else {
        return $this->redirect("/login");
      }*/
    }
}
