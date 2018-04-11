<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GovernmentRepository")
 */
class Government
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=21)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Delegation", mappedBy="government")
     */
    private $delegation;

    public function __construct ()
    {
        $this->delegation = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDelegation ()
    {
        return $this->delegation;
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


    // add your own fields
}
