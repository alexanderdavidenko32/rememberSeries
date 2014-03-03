<?php

namespace Acme\RememberSeriesBundle\Controller;

use Acme\RememberSeriesBundle\Entity\Series;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\RememberSeriesBundle\Entity\UserSeason;

/**
 * Description of SeriesController
 *
 * @author Alexander.Davidenko
 */
class SeasonController extends Controller {
    
    public function getSecurityContext() {
        return $this->container->get('security.context');
    }

    public function getUser() {
        return $this->getSecurityContext()->getToken()->getUser();
    }


    /**
     * Season single page
     *
     * @param $season_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seasonAction($season_id) {
        $params = array();

        $season = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Season')
                ->find($season_id);
        $episodes = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Episode')
                ->getEpisodesForUser($season, $this->getUser());

        $params['title'] = 'season: ' . $season->getName();
        $params['season'] = $season;
        $params['episodes'] = $episodes;

        return $this->render('AcmeRememberSeriesBundle:Season:season.html.twig', $params);
    }

    /**
     * Set or unset season as watched
     *
     * @param $season_id
     * @param $is_watched
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function seasonSetWatchedAction($season_id, $is_watched) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $season = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:Season')
                ->find($season_id);
        
        $series_id = $season->getSeriesId()->getId();
        
        $userSeason = $this->getDoctrine()->getRepository('AcmeRememberSeriesBundle:UserSeason')
                ->findOneBy(array('seasonId' => $season, 'userId' => $user->getId()));

        if ($is_watched) {
            
            if (!$userSeason) {
                $userSeason = new UserSeason();
                $userSeason->setSeasonId($season);
                $em->persist($userSeason);
                $user->addSeason($userSeason);
            }
            
        } else {
            $user->removeSeason($userSeason);
        }
        
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_remember_series_single_page', array('series_id' => $series_id)));
    }
}

