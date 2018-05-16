<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TradesRepository")
 * @ORM\Entity
 * @ORM\Table(name="trades")
 * @UniqueEntity(
 *     fields={"codeTrades"},
 *     message="Le code doit être unique"
 * )
 */
class Trades
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
	 * @param $code
	 */
    public function setCode ($code): void
    {
        $this->code = $code;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="trades")
     * @ORM\JoinColumn(nullable=true)
     */
    private $activities;


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

    /**
     * @return mixed
     */
    public function getActivities ()
    {
        return $this->activities;
    }

    /**
     * @param mixed $activities
     */
    public function setActivities (Activity $activities)
    {
        $this->activities = $activities;
    }
}
