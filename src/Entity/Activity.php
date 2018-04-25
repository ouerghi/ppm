<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 * @UniqueEntity(
 *     fields={"code"},
 *     message="Le code doit être unique"
 * )
 */
class Activity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10,nullable=false, unique=true)
     * @Assert\Valid()
     * @Assert\Length(max="4")
     */
    private $code;

    /**
     * @return mixed
     */
    public function getCode ()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode ($code): void
    {
        $this->code = $code;
    }


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trades", mappedBy="activities")
     */
    private $trades;

    public function __construct()
    {
        $this->trades = new ArrayCollection();
    }

    /**
     * @return Collection|Trades[]
     */
    public function getTrades()
    {
        return $this->trades;
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
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName ($name): void
    {
        $this->name = $name;
    }


}
