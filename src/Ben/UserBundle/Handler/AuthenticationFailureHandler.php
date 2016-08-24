<?php
namespace Ben\UserBundle\Handler;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler {

protected $container;
    public function __construct( HttpKernelInterface $httpKernel, HttpUtils $httpUtils, array $options, LoggerInterface $logger = null ,\Symfony\Component\DependencyInjection\ContainerInterface $cont) {
        parent::__construct( $httpKernel, $httpUtils, $options, $logger );
        $this->container=$cont;

    }

    public function onAuthenticationFailure( Request $request, AuthenticationException $exception ) {
      /*return $this->container->get('templating')->redirectToRoute('/login',
      array(
          'last_username' => "",
          'error'         => "",
          'csrf_token' => "",
          'form' => $this->container->get('fos_user.registration.form')->createView(),
      ));*/
      //return $this->httpUtils->createRedirectResponse($request, $this->determineFailureUrl($request));
      return $response = new RedirectResponse($request->headers->get('referer'));

    }
}
