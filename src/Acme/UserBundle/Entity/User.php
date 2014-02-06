<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Acme\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Acme\RememberSeriesBundle\Entity\UserSeries", mappedBy="userId", cascade={"remove"}, orphanRemoval=true)
     * @Assert\Type(type="Acme\RememberSeriesBundle\Entity\Series")
     */
    private $series;
    
    /**
     * @ORM\OneToMany(targetEntity="Acme\RememberSeriesBundle\Entity\Series", mappedBy="ownerId")
     */
    private $createdSeries;

    public function __construct()
    {
        parent::__construct();

        $this->series = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdSeries = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get series
     */
    public function getSeries() {
        return $this->series;
    }
    
    /**
     * Get related series list
     * 
     * @return array_map
     */
    public function getSeriesList() {
        return array_map(
            function ($series) {
                return $series->getSeriesId();
            },
            $this->series->toArray()
        );
    }
    
    public function getRelatedSeries() {
        
    }
   
    /**
     * Get createdSeries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedSeries()
    {
        return $this->createdSeries;
    }

    /**
     * Add createdSeries
     *
     * @param \Acme\RememberSeriesBundle\Entity\Series $createdSeries
     * @return User
     */
    public function addCreatedSerie(\Acme\RememberSeriesBundle\Entity\Series $createdSeries)
    {
        $this->createdSeries[] = $createdSeries;
    
        return $this;
    }

    /**
     * Remove createdSeries
     *
     * @param \Acme\RememberSeriesBundle\Entity\Series $createdSeries
     */
    public function removeCreatedSerie(\Acme\RememberSeriesBundle\Entity\Series $createdSeries)
    {
        $this->createdSeries->removeElement($createdSeries);
    }

    /**
     * Add series
     *
     * @param \Acme\RememberSeriesBundle\Entity\UserSeries $series
     * @return User
     */
    public function addSerie(\Acme\RememberSeriesBundle\Entity\UserSeries $series)
    {
        if (!$this->series->contains($series)) {
            $this->series->add($series);
            $series->setUserId($this);
        }
    
        return $this;
    }

    /**
     * Remove series
     *
     * @param \Acme\RememberSeriesBundle\Entity\UserSeries $series
     */
    public function removeSerie(\Acme\RememberSeriesBundle\Entity\UserSeries $series)
    {
        if ($this->series->contains($series)) {
            $this->series->removeElement($series);
            $series->setUserId(null);
        }
        return $this;
    }
}