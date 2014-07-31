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


            for ($i = 1; $i <= 6; $i++) {

                $season = new Season();
                $season->setNumber($i);
                $season->setName('Lost season ' . $i);
                $season->setSeriesId($series);

                for ($j = 1; $j <= 10; $j++) {
                    $episode = new Episode();
                    $episode->setName('Lost episode ' . $j);
                    $episode->setNumber($j);
                    $episode->setDescription('Lost episode ' . $j . ' description');
                    $episode->setSeasonId($season);

                    $manager->persist($episode);
                }
                $manager->persist($season);
            }

            $manager->persist($series);
            $manager->flush();
        }

    }

} 