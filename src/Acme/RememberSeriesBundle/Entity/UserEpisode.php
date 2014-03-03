<?php

namespace Acme\RememberSeriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEpisode
 *
 * @ORM\Table(name="user_episode    ")
 * @ORM\Entity(repositoryClass="Acme\RememberSeriesBundle\Entity\UserEpisodeRepository")
 */
class UserEpisode
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
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="episodes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Acme\RememberSeriesBundle\Entity\Episode", inversedBy="users")
     * @ORM\JoinColumn(name="episode_id", referencedColumnName="id")
     */
    private $episodeId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="watched", type="boolean")
     */
    private $watched;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="progress", type="time")
     */
    private $progress;


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
     * @return UserEpisode
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
     * Set episodeId
     *
     * @param integer $episodeId
     * @return UserEpisode
     */
    public function setEpisodeId($episodeId)
    {
        $this->episodeId = $episodeId;
    
        return $this;
    }

    /**
     * Get episodeId
     *
     * @return integer 
     */
    public function getEpisodeId()
    {
        return $this->episodeId;
    }

    /**
     * Set watched
     *
     * @param boolean $watched
     * @return UserEpisode
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

    /**
     * Set progress
     *
     * @param \DateTime $progress
     * @return UserEpisode
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
    
        return $this;
    }

    /**
     * Get progress
     *
     * @return \DateTime 
     */
    public function getProgress()
    {
        return $this->progress;
    }
}
