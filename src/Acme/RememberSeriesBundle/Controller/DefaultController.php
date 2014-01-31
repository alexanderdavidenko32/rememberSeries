<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {
        $params = array();

        $seriesRepository = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series');
        $seriesQuery = $seriesRepository->createQueryBuilder('s')->getQuery();
        $series = $seriesQuery->getResult();
                
        $params['movies'] = array(
            array(
                'name' => 'movie1',
                'text' => 'mv1'
            ),
            array(
                'name' => 'movie2',
                'text' => 'mv2'
            )
        );
        $params['series'] = $series;
//        var_dump($series); die;

//        $params['user'] = null;

//        $securityContext = $this->container->get('security.context');
//        if( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
//            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
////            var_dump($securityContext);die;
//            $params['user'] = $securityContext;
//
//        }
//        $user = $this->container->get('fos_user.user_manager')->findUserByUserName('admin');
//        var_dump($user);die;

        return $this->render('AcmeRememberSeriesBundle:Default:index.html.twig', $params);
    }

    public function seriesAction($series_id) {
        $params = array();
        
        $seriesRepository = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series');
        $seriesQuery = $seriesRepository->createQueryBuilder('s')
                ->where('s.id = ' . $series_id)
                ->getQuery();
        $series = $seriesQuery->getSingleResult();
        
        $params['series'] = $series;

        return $this->render('AcmeRememberSeriesBundle:Default:series.html.twig', $params);
    }
}
