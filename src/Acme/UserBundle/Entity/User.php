<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToMany(targetEntity="Acme\RememberSeriesBundle\Entity\Series")
     */
    private $series;

    public function __construct()
    {
        parent::__construct();
        
        $this->series = new ArrayCollection();
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
     * Add series
     *
     * @param \Acme\RememberSeriesBundle\Entity\Series $series
     * @return User
     */
    public function addSeries(\Acme\RememberSeriesBundle\Entity\Series $series)
    {
        $this->series[] = $series;
    
        return $this;
    }

    /**
     * Remove series
     *
     * @param \Acme\RememberSeriesBundle\Entity\Series $series
     */
    public function removeSeries(\Acme\RememberSeriesBundle\Entity\Series $series)
    {
        $this->series->removeElement($series);
    }
}