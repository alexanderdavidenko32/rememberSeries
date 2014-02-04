<?php

namespace Acme\RememberSeriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Season
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\RememberSeriesBundle\Entity\SeasonRepository")
 */
class Season
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
     * @ORM\ManyToOne(targetEntity="Series", inversedBy="seasons")
     * @ORM\JoinColumn(name="series_id", referencedColumnName="id")
     */
    private $seriesId;

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
     * @ORM\OneToMany(targetEntity="Episode", mappedBy="season_id")
     */
    private $episodes;

    public function __construct()
    {
        $this->seriesId = new ArrayCollection();
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
     * Set number
     *
     * @param integer $number
     * @return Season
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

    /**
     * Set name
     *
     * @param string $name
     * @return Season
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
     * Set series_id
     *
     * @param integer $seriesId
     * @return Season
     */
    public function setSeriesId($seriesId)
    {
        $this->series_id = $seriesId;

        return $this;
    }

    /**
     * Get series_id
     *
     * @return integer
     */
    public function getSeriesId()
    {
        return $this->series_id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Season
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
     * Add episodes
     *
     * @param \Acme\RememberSeriesBundle\Entity\Episode $episodes
     * @return Season
     */
    public function addEpisode(\Acme\RememberSeriesBundle\Entity\Episode $episodes)
    {
        $this->episodes[] = $episodes;

        return $this;
    }

    /**
     * Remove episodes
     *
     * @param \Acme\RememberSeriesBundle\Entity\Episode $episodes
     */
    public function removeEpisode(\Acme\RememberSeriesBundle\Entity\Episode $episodes)
    {
        $this->episodes->removeElement($episodes);
    }

    /**
     * Get episodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }
}