<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisanRepository")
 * @UniqueEntity(fields={"cin"}, message="This field must be unique")
 */
class Artisan extends PM
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $qualification;


	/**
	 * @ORM\Column(type="string")
	 */
    private $nationality;

	/**
	 * @ORM\Column(type="smallint")
	 */
	private $employee;


    /**
     * @ORM\Column(type="string", length=200)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $cin ;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	private $grade;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $birthday ;

	/**
	 * @return mixed
	 */
	public function getBirthday() {
		return $this->birthday;
	}

	/**
	 * @param mixed $birthday
	 */
	public function setBirthday( $birthday ): void {
		$this->birthday = $birthday;
	}


    /**
     * Artisan constructor.
     */
    public function __construct ()
    {
       parent::__construct();
    }

    public function getType() {
	    return parent::TYPE_Artisan;
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
	public function getQualification() {
		return $this->qualification;
	}

	/**
	 * @param mixed $qualification
	 */
	public function setQualification( $qualification ): void {
		$this->qualification = $qualification;
	}

	/**
	 * @return mixed
	 */
	public function getNationality() {
		return $this->nationality;
	}

	/**
	 * @param mixed $nationality
	 */
	public function setNationality( $nationality ): void {
		$this->nationality = $nationality;
	}


	/**
	 * @return mixed
	 */
	public function getEmployee() {
		return $this->employee;
	}

	/**
	 * @param mixed $employee
	 */
	public function setEmployee( $employee ): void {
		$this->employee = $employee;
	}

	/**
	 * @return mixed
	 */
	public function getGrade() {
		return $this->grade;
	}

	/**
	 * @param mixed $grade
	 */
	public function setGrade( $grade ): void {
		$this->grade = $grade;
	}


}