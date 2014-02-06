<?php

namespace Acme\RememberSeriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSeries
 *
 * @ORM\Table(name="user_series")
 * @ORM\Entity(repositoryClass="Acme\RememberSeriesBundle\Entity\UserSeriesRepository")
 */
class UserSeries
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
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="series")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Acme\RememberSeriesBundle\Entity\Series", inversedBy="users")
     * @ORM\JoinColumn(name="series_id", referencedColumnName="id")
     */
    private $seriesId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="watched", type="boolean")
     */
    private $watched = false;

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
     * Set userId
     *
     * @param integer $userId
     * @return UserSeries
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set seriesId
     *
     * @param integer $seriesId
     * @return UserSeries
     */
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    
        return $this;
    }

    /**
     * Get seriesId
     *
     * @return integer 
     */
    public function getSeriesId()
    {
        return $this->seriesId;
    }

    /**
     * Set watched
     *
     * @param boolean $watched
     * @return UserSeries
     */
    public function setWatched($watched)
    {
        $this->watched = $watched;
    
        return $this;
    }

    /**
     * Get watched
     *
     * @return boolean 
     */
    public function getWatched()
    {
        return $this->watched;
    }
}