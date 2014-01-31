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
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $series_id;

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

    public function __construct()
    {
        $this->series_id = new ArrayCollection();
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
}