<?php

namespace Acme\RememberSeriesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Series
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\RememberSeriesBundle\Entity\SeriesRepository")
 */
class Series
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
     * @var boolean
     *
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="createdSeries")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $ownerId = true;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Acme\RememberSeriesBundle\Entity\UserSeries", mappedBy="seriesId", cascade={"remove"}, orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Season", mappedBy="seriesId")
     * @ORM\OrderBy({"number"="ASC"})
     */
    private $seasons;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seasons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ownerId = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Series
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
     * @return Series
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
     * Add seasons
     *
     * @param \Acme\RememberSeriesBundle\Entity\Season $seasons
     * @return Series
     */
    public function addSeason(\Acme\RememberSeriesBundle\Entity\Season $seasons)
    {
        $this->seasons[] = $seasons;

        return $this;
    }

    /**
     * Remove seasons
     *
     * @param \Acme\RememberSeriesBundle\Entity\Season $seasons
     */
    public function removeSeason(\Acme\RememberSeriesBundle\Entity\Season $seasons)
    {
        $this->seasons->removeElement($seasons);
    }

    /**
     * Get seasons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeasons()
    {
        return $this->seasons;
    }

    /**
     * Get user
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
     * Set ownerId
     *
     * @param \Acme\UserBundle\Entity\User $ownerId
     * @return Series
     */
    public function setOwnerId(\Acme\UserBundle\Entity\User $ownerId = null)
    {
        $this->ownerId = $ownerId;
    
        return $this;
    }

    /**
     * Get ownerId
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * Add users
     *
     * @param \Acme\RememberSeriesBundle\Entity\UserSeries $users
     * @return Series
     */
    public function addUser(\Acme\RememberSeriesBundle\Entity\UserSeries $users)
    {
       if (!$this->users->contains($users)) {
            $this->users->add($users);
            $users->setSeriesId($this);
        }
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Acme\RememberSeriesBundle\Entity\UserSeries $users
     */
    public function removeUser(\Acme\RememberSeriesBundle\Entity\UserSeries $users)
    {
        if ($this->users->contains($users)) {
            $this->users->removeElement($users);
            $users->setSeriesId(null);
        }
    }
}