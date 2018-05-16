<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

//http://www.ins.tn/sites/default/files/publication/pdf/codegeo_2013.pdf liste des codes delegations

/**
 * @ORM\Entity(repositoryClass="App\Repository\DelegationRepository")
 * @UniqueEntity(
 *     fields={"codeDelegation"},
 *     message="Le code doit être unique"
 * )
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
     * @ORM\Column(type="string", length=10,nullable=true, unique=true)
     * @Assert\Valid()
     * @Assert\Length(max="4")
     */
    private $code;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Government", inversedBy="delegation")
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

	/**
	 * @return mixed
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param mixed $code
	 */
	public function setCode( $code ): void {
		$this->code = $code;
	}

    // add your own fields
}
