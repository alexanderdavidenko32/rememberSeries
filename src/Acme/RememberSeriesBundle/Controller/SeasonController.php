<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of SeriesController
 *
 * @author Alexander.Davidenko
 */
class SeasonController extends Controller {

     public function seasonAction($season_id) {
        $params = array();

        $season = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Season')
                ->find($season_id);
        $episodes = $season->getEpisodes();

        $params['title'] = 'season: ' . $season->getName();
        $params['season'] = $season;
        $params['episodes'] = $episodes;

        return $this->render('AcmeRememberSeriesBundle:Season:season.html.twig', $params);
    }
}

