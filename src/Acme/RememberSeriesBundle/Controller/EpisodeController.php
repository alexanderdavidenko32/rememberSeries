<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of SeriesController
 *
 * @author Alexander.Davidenko
 */
class EpisodeController extends Controller {

    public function episodeAction($episode_id) {
        $params = array();

        $episode = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Episode')
                ->find($episode_id);

        $params['title'] = 'episode: ' . $episode->getName();
        $params['episode'] = $episode;

        return $this->render('AcmeRememberSeriesBundle:Episode:episode.html.twig', $params);
    }
}