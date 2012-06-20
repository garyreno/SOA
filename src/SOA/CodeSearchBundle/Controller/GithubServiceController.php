<?php

namespace SOA\CodeSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GithubServiceController extends Controller
{  
    public function indexAction()
    {
        if($this->getRequest()->query->has("wsdl")) {
            $soap = new \Zend_Soap_AutoDiscover("Zend_Soap_Wsdl_Strategy_ArrayOfTypeComplex");
            $soap->setUri($this->getRequest()->getUriForPath("/github"));
            $soap->setClass("SOA\CodeSearchBundle\Services\GithubService");
        } else {
            $soap = new \Zend_Soap_Server($this->getRequest()->getUri()."?wsdl");
            $soap->setObject($this->get('GithubService'));
        }
        $res = new Response();
        $res->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        ob_start();
        $soap->handle();
        $res->setContent(ob_get_clean());
        return $res;
    }
}
