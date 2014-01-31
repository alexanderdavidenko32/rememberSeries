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
        $seasons = $series->getSeasons();

        $params['series'] = $series;
        $params['seasons'] = $seasons;

        return $this->render('AcmeRememberSeriesBundle:Default:series.html.twig', $params);
    }

    public function seasonAction($season_id) {
        $params = array();

        $season = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Season')
                ->find($season_id);
        $episodes = $season->getEpisodes();

        $params['season'] = $season;
        $params['episodes'] = $episodes;

        return $this->render('AcmeRememberSeriesBundle:Default:season.html.twig', $params);
    }

    public function episodeAction($episode_id) {
        $params = array();

        $episode = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Episode')
                ->find($episode_id);

        $params['episode'] = $episode;

        return $this->render('AcmeRememberSeriesBundle:Default:episode.html.twig', $params);
    }
}
