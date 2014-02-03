<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {

        $securityContext = $this->container->get('security.context');

//      authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $response = $this->forward('AcmeRememberSeriesBundle:Series:seriesList');
        } else {
            $response = $this->forward('AcmeRememberSeriesBundle:Default:welcome');
        }

        return $response;
    }
    
    public function welcomeAction() {
        return $this->render('AcmeRememberSeriesBundle:Default:index.html.twig');
    }
}
