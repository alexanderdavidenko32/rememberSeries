<?php

namespace Acme\RememberSeriesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SeriesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SeriesRepository extends EntityRepository
{
    /**
     * Gets Series that user added to his list
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return array
     */
    public function getUserSeriesList(\Acme\UserBundle\Entity\User $user) {

        /**
         * TODO: Make this method for user homepage. look at EpisodeRepository for example.
         * change seriesList.html.twig after that
         */

        $series = $this->getEntityManager()
                ->getRepository('AcmeRememberSeriesBundle:UserSeries')
                ->createQueryBuilder('s')
                ->where('s.userId = :this_user')
                ->setParameter('this_user', $user)
//                ->orderBy('s.name', 'ASC')
                ->getQuery()
                ->getResult();
//        var_dump($series); die;

        return $series;
    }

    public function getSeriesForSeason(\Acme\RememberSeriesBundle\Entity\Season $season) {

        $series = $this->getEntityManager()
            ->getRepository('AcmeRememberSeriesBundle:Series')
            ->createQueryBuilder('s')
            ->leftJoin('Acme\RememberSeriesBundle\Entity\Season', 'season', 'WITH', 'season.seriesId = s.id')
            ->where('season.id = :seasonId')
            ->setParameter('seasonId', $season)
            ->getQuery()
            ->getSingleResult();
        return $series;
    }

}
