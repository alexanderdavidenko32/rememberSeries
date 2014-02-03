<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of SeriesController
 *
 * @author Alexander.Davidenko
 */
class SeriesController extends Controller {

    public function seriesAction($series_id) {
        $params = array();

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);
        $seasons = $series->getSeasons();

        $params['series'] = $series;
        $params['seasons'] = $seasons;

        return $this->render('AcmeRememberSeriesBundle:Series:series.html.twig', $params);
    }

    public function seriesListAction() {
        $params = array();

        $securityContext = $this->container->get('security.context');

        $series = $securityContext->getToken()->getUser()->getSeries();
        $params['series'] = $series;
        $response = $this->render('AcmeRememberSeriesBundle:Series:seriesList.html.twig', $params);

        return $response;
    }

    public function seriesListAllAction() {
        $params = array();

        $securityContext = $this->container->get('security.context');
        
        $userSeries = $securityContext->getToken()->getUser()->getSeries()->toArray();

        $seriesRepository = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series');
        $series = $seriesRepository->createQueryBuilder('s')
                ->where('s.id NOT IN (:ids)')
                ->setParameter('ids',  $userSeries)
                ->getQuery()
                ->getResult();


        $params['series'] = $series;
        return $this->render('AcmeRememberSeriesBundle:Series:seriesListAll.html.twig', $params);
    }

    public function seriesAddAction($series_id) {

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);

        $securityContext = $this->container->get('security.context');
        
        $user = $securityContext->getToken()->getUser();

        $user->addSeries($series);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_remember_series_homepage'));
    }
    
    public function seriesRemoveAction($series_id) {

        $series = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Series')
                ->find($series_id);

        $securityContext = $this->container->get('security.context');
        
        $user = $securityContext->getToken()->getUser();

        $user->removeSeries($series);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_remember_series_homepage'));
    }

}

