<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {
        $params = array();

        $securityContext = $this->container->get('security.context');

//      authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
        if( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
            $series = $securityContext->getToken()->getUser()->getSeries();
        } else {
            $seriesRepository = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series');
            $seriesQuery = $seriesRepository->createQueryBuilder('s')->getQuery();
            $series = $seriesQuery->getResult();
        }

        $params['series'] = $series;

        return $this->render('AcmeRememberSeriesBundle:Default:index.html.twig', $params);
    }
}
