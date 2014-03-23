<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Acme\RememberSeriesBundle\Entity\UserEpisode;
use Acme\RememberSeriesBundle\Form\UserEpisodeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of SeriesController
 *
 * @author Alexander.Davidenko
 */
class EpisodeController extends Controller {

    public function getSecurityContext() {
        return $this->container->get('security.context');
    }

    public function getUser() {
        return $this->getSecurityContext()->getToken()->getUser();
    }

    public function episodeAction($episode_id) {
        $params = array();

        $episode = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Episode')
                ->find($episode_id);

        $params['title'] = 'episode: ' . $episode->getName();
        $params['episode'] = $episode;

        return $this->render('AcmeRememberSeriesBundle:Episode:episode.html.twig', $params);
    }

    public function episodeSetWatchedAction($episode_id, $is_watched) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $episode = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Episode')
            ->find($episode_id);

        $season_id = $episode->getSeasonId()->getId();

        $userEpisode = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:UserEpisode')
            ->findOneBy(array('episodeId' => $episode, 'userId' => $user->getId()));

        if ($is_watched) {

            if (!$userEpisode) {
                $userEpisode = new UserEpisode();
                $userEpisode->setEpisodeId($episode);
                $userEpisode->setWatched($is_watched);
                $userEpisode->setProgress(new \DateTime('1980-01-01'));
                $em->persist($userEpisode);
                $user->addEpisode($userEpisode);
            } else {
                $userEpisode->setWatched($is_watched);
            }

        } else {
//            $user->removeEpisode($userEpisode);
            $userEpisode->setWatched($is_watched);
        }

        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_remember_series_season', array('season_id' => $season_id)));

    }

    public function episodeSetProgressAction(Request $request) {
        $form = $this->createForm(new UserEpisodeType(), new UserEpisode());

        $form->handleRequest($request);

        if ($form->isValid()) {
            // data from the form
            $userEpisode = $form->getData();
            $season = $userEpisode->getEpisodeId()->getSeasonId();

            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            // find existing UserEpisode
            $UserEpisode = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:UserEpisode')
                ->findOneBy(array('userId' => $this->getUser(), 'episodeId' => $userEpisode->getEpisodeId()));

            if (!$UserEpisode) {
                $UserEpisode = new UserEpisode();
                $UserEpisode->setUserId($user);
//                $UserEpisode->setWatched($userEpisode->getWatched());
                $UserEpisode->setWatched(false);
                $UserEpisode->setEpisodeId($userEpisode->getEpisodeId());
                $em->persist($UserEpisode);
                $user->addEpisode($UserEpisode);
            }


            $UserEpisode->setProgress($userEpisode->getProgress());

            $em->persist($UserEpisode);
            $em->flush();

            return $this->redirect($this->generateUrl('acme_remember_series_season', array('season_id' => $season->getId())));
        }
        return $this->redirect($this->generateUrl('_welcome'));
    }
}