<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GovernmentRepository")
 * @UniqueEntity(
 *     fields={"codeGovernment"},
 *     message="Le code doit être unique"
 * )
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
     * @ORM\Column(type="string", length=10,nullable=false, unique=true)
     * @Assert\Valid()
     * @Assert\Length(max="4")
     */
    private $codeGovernment;

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

    /**
     * @return mixed
     */
    public function getCodeGovernment ()
    {
        return $this->codeGovernment;
    }

	/**
	 * @param string $codeGovernment
	 */
    public function setCode (string $codeGovernment): void
    {
        $this->codeGovernment = $codeGovernment;
    }


    // add your own fields
}
