<?php

namespace Acme\RememberSeriesBundle\Entity;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
}