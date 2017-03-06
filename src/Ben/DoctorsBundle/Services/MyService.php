<?php
use Symfony\Component\HttpFoundation\RequestStack;

class MyService
{

protected $request;

public function setRequest(RequestStack $request_stack)
{
$this->request = $request_stack->getCurrentRequest();
}

}