<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisanRepository")
 */
class Artisan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
     private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trades;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville")
     * * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    /**
     * @return mixed
     */
    public function getVille ()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille (Ville $ville): void
    {
        $this->ville = $ville;
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
    public function setActivity ( Activity $activity): void
    {
        $this->activity = $activity;
    }



    /**
     * @ORM\Column(type="string", length=200)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $lastName;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $cin;

    /**
     * Artisan constructor.
     */
    public function __construct ()
    {
        $this->date = new \DateTime();
    }



    /**
     * @return mixed
     */
    public function getUser ()
    {
        return $this->user;
    }


    /**
     * @param User $user
     */
    public function setUser (User $user)
    {
        $this->user = $user;

    }

    /**
     * @return mixed
     */
    public function getId ()
    {
         //return sprintf("%'.07d",$this->id);
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
    public function getFirstName ()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName ($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName ()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName ($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getDate ()
    {
        return $this->date;
    }



    /**
     * @return mixed
     */
    public function getCin ()
    {
        return $this->cin;
    }

    /**
     * @param mixed $cin
     */
    public function setCin ($cin): void
    {
        $this->cin = $cin;
    }

    /**
     * @return mixed
     */
    public function getTrades ()
    {
        return $this->trades;
    }

    /**
     * @param mixed $trades
     */
    public function setTrades ( Trades $trades): void
    {
        $this->trades = $trades;
    }


}
