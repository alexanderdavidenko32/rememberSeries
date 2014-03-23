<?php

namespace Acme\RememberSeriesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Episode
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\RememberSeriesBundle\Entity\EpisodeRepository")
 */
class Episode
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="episodes")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $season_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Acme\RememberSeriesBundle\Entity\UserEpisode", mappedBy="episodeId", cascade={"remove"}, orphanRemoval=true)
     */
    private $users;

    public function __construct()
    {
        $this->season_id = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Episode
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Episode
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set season_id
     *
     * @param \Acme\RememberSeriesBundle\Entity\Season $seasonId
     * @return Episode
     */
    public function setSeasonId(\Acme\RememberSeriesBundle\Entity\Season $seasonId = null)
    {
        $this->season_id = $seasonId;

        return $this;
    }

    /**
     * Get season_id
     *
     * @return \Acme\RememberSeriesBundle\Entity\Season
     */
    public function getSeasonId()
    {
        return $this->season_id;
    }

    /**
     * Add users
     *
     * @param \Acme\RememberSeriesBundle\Entity\UserEpisode $users
     * @return Episode
     */
    public function addUser(\Acme\RememberSeriesBundle\Entity\UserEpisode $users)
    {
        if (!$this->users->contains($users)) {
            $this->users->add($users);
            $users->setEpisodeId($this);
        }

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Acme\RememberSeriesBundle\Entity\UserEpisode $users
     */
    public function removeUser(\Acme\RememberSeriesBundle\Entity\UserEpisode $users)
    {
        if ($this->users->contains($users)) {
            $this->users->removeElement($users);
            $users->setEpisodeId(null);
        }
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get related user list
     *
     * @return array_map
     */
    public function getUsersList() {
        return array_map(
            function ($user) {
                return $user->getUserId();
            },
            $this->users->toArray()
        );
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Episode
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }
}