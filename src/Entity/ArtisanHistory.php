<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisanHistoryRepository")
 */
class ArtisanHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artisan")
     * @ORM\JoinColumn(nullable=false)
     */

    private $artisan;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trade;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Government")
     * @ORM\JoinColumn(nullable=false)
     */
    private $government;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Delegation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $delegation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser ()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser (User $user): void
    {
        $this->user = $user;
    }
    /**
     * @ORM\Column(type="date")
     */
    private $old_dateCreation ;

    /**
     * @return mixed
     */
    public function getOldDateCreation ()
    {
        return $this->old_dateCreation;
    }

    /**
     * @param mixed $old_dateCreation
     */
    public function setOldDateCreation (\DateTime $old_dateCreation): void
    {
        $this->old_dateCreation = $old_dateCreation;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $old_cin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activityChanged = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $governmentChanged = false;

    /**
     * @return mixed
     */
    public function getGovernment ()
    {
        return $this->government;
    }

    /**
     * @param mixed $government
     */
    public function setGovernment ($government): void
    {
        $this->government = $government;
    }

    /**
     * @return mixed
     */
    public function getDelegation ()
    {
        return $this->delegation;
    }

    /**
     * @param mixed $delegation
     */
    public function setDelegation ($delegation): void
    {
        $this->delegation = $delegation;
    }

    /**
     * @return mixed
     */
    public function getGovernmentChanged ()
    {
        return $this->governmentChanged;
    }

    /**
     * @param mixed $governmentChanged
     */
    public function setGovernmentChanged ($governmentChanged): void
    {
        $this->governmentChanged = $governmentChanged;
    }

    /**
     * @return mixed
     */
    public function getActivityChanged ()
    {
        return $this->activityChanged;
    }

    /**
     * @param mixed $activityChanged
     */
    public function setActivityChanged ($activityChanged): void
    {
        $this->activityChanged = $activityChanged;
    }

    /**
     * @return mixed
     */
    public function getArtisanDeleted ()
    {
        return $this->artisanDeleted;
    }

    /**
     * @param mixed $artisanDeleted
     */
    public function setArtisanDeleted ($artisanDeleted): void
    {
        $this->artisanDeleted = $artisanDeleted;
    }
    /**
     * @ORM\Column(type="boolean")
     */
    private $artisanDeleted = false ;

    /**
     * @return mixed
     */
    public function getOldCin ()
    {
        return $this->old_cin;
    }

    /**
     * @param mixed $old_cin
     */
    public function setOldCin ($old_cin): void
    {
        $this->old_cin = $old_cin;
    }

    /**
     * @return mixed
     */
    public function getTrade ()
    {
        return $this->trade;
    }

    /**
     * @param mixed $trade
     */
    public function setTrade (Trades $trade): void
    {
        $this->trade = $trade;
    }

    /**
     * @return mixed
     */
    public function getActivity ()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity (Activity $activity): void
    {
        $this->activity = $activity;
    }

    /**
     * @ORM\Column(type="date")
     */
    private $dateUpdate;

    /**
     * @return mixed
     */
    public function getDateUpdate ()
    {
        return $this->dateUpdate;
    }

    public function __construct ()
    {
        $this->dateUpdate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId ($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getArtisan ()
    {
        return $this->artisan;
    }

    /**
     * @param mixed $artisan
     */
    public function setArtisan (Artisan $artisan): void
    {
        $this->artisan = $artisan;
    }

    // add your own fields
}
