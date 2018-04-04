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
     * @ORM\Column(type="integer")
     */
    private $old_cin;

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
