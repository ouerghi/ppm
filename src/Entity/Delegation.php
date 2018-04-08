<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DelegationRepository")
 */
class Delegation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Government")
     * @ORM\JoinColumn(nullable=false)
     */

    private $government;

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
    public function getGovernment ()
    {
        return $this->government;
    }

    /**
     * @param mixed $government
     */
    public function setGovernment (Government $government): void
    {
        $this->government = $government;
    }

    // add your own fields
}
