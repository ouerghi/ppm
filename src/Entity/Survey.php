<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurveyRepository")
 */
class Survey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artisan")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artisan;
    /**
     * @ORM\Column(type="datetime")
     */
    private $start;
    /**
     * @ORM\Column(type="datetime")
     */
    private $end;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct ()
    {
        $this->date = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }

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
    public function setUser ($user): void
    {
        $this->user = $user;
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
    public function setArtisan ($artisan): void
    {
        $this->artisan = $artisan;
    }

    /**
     * @return mixed
     */
    public function getStart ()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart ($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd ()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd ($end): void
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getDate ()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate ($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription ($description): void
    {
        $this->description = $description;
    }


    // add your own fields
}
