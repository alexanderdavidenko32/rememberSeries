<?php

namespace Acme\RememberSeriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSeason
 *
 * @ORM\Table(name="user_season")
 * @ORM\Entity(repositoryClass="Acme\RememberSeriesBundle\Entity\UserSeasonRepository")
 */
class UserSeason
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
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="seasons")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Acme\RememberSeriesBundle\Entity\Season", inversedBy="users")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $seasonId;

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
     * Set seasonId
     *
     * @param integer $seasonId
     * @return UserSeason
     */
    public function setSeasonId($seasonId)
    {
        $this->seasonId = $seasonId;
    
        return $this;
    }

    /**
     * Get seasonId
     *
     * @return integer 
     */
    public function getSeasonId()
    {
        return $this->seasonId;
    }

    /**
     * Set userId
     *
     * @param \Acme\UserBundle\Entity\User $userId
     * @return UserSeason
     */
    public function setUserId(\Acme\UserBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}