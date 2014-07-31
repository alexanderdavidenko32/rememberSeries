<?php
/**
 * Created by PhpStorm.
 * User: Alexander.Davidenko
 * Date: 7/30/14
 * Time: 5:52 PM
 */

namespace Acme\RememberSeriesBundle\DataFixtures\ORM;

use Acme\RememberSeriesBundle\Entity\Episode;
use Acme\RememberSeriesBundle\Entity\Season;
use Acme\RememberSeriesBundle\Entity\Series;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSeries implements FixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $user = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => 1));

        if ($user) {

            $series = new Series();
            $series->setName('Lost');
            $series->setOwnerId($user);

            $season = new Season();
            $season->setNumber(1);
            $season->setName('Lost season 1');
            $season->setSeriesId($series);

            $episode = new Episode();
            $episode->setName('Lost episode 1');
            $episode->setNumber(1);
            $episode->setDescription('Lost episode 1 description');
            $episode->setSeasonId($season);

            $manager->persist($episode);
            $manager->persist($season);
            $manager->persist($series);
            $manager->flush();
        }

    }

} 