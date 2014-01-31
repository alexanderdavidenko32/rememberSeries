<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {
        $params = array();

        $securityContext = $this->container->get('security.context');
        
        if( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
//            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            $series = $securityContext->getToken()->getUser()->getSeries();
        } else {
            $seriesRepository = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series');
            $seriesQuery = $seriesRepository->createQueryBuilder('s')->getQuery();
            $series = $seriesQuery->getResult();
        }
        
        $params['series'] = $series;

        return $this->render('AcmeRememberSeriesBundle:Default:index.html.twig', $params);
    }

    public function seriesAction($series_id) {
        $params = array();
        
        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);
        
        $params['series'] = $series;

        return $this->render('AcmeRememberSeriesBundle:Default:series.html.twig', $params);
    }
    
    public function seasonsAction($series_id) {
        $params = array();
        
        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);
        $seasons = $series->getSeasons();        
        
        $params['seasons'] = $seasons;
//        var_dump($seasons); die;
        return $this->render('AcmeRememberSeriesBundle:Default:seasons.html.twig', $params);
    }
}
