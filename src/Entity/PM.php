<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"artisan" = "Artisan", "company" = "Company"})
 * @ORM\Entity(repositoryClass="App\Repository\PMRepository")
 */
Abstract class PM
{

	/**
	 * @const company
	 */
	const  TYPE_COMPANY = 'company';
	/**
	 * @const artisan
	 */
	const  TYPE_Artisan = 'artisan';
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"remove"} )
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $user;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Activity", cascade={"remove"} )
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	protected $activity;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Trades", cascade={"remove"} )
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	protected $trades;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Government", cascade={"remove"} )
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $government;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Delegation", cascade={"remove"} )
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	protected $delegation;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Juridique", cascade={"remove"} )
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	protected $juridique;

	/**
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank()
	 */
	protected $zip;
	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank()
	 */
	protected $adresse;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $local;


	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $date;


	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $isDeleted = false;


	/**
	 * @ORM\Column(type="date")
	 * @Assert\DateTime()
	 */
	protected $dateCreation;


	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $isActivityUpdated = false;

	/**
	 * Artisan constructor.
	 */
	public function __construct() {
		$this->date         = new \DateTime();
		$this->dateCreation = new \DateTime();
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	abstract public function getType();

	/**
	 * @return mixed
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( User $user ): void {
		$this->user = $user;
	}

	/**
	 * @return mixed
	 */
	public function getActivity() {
		return $this->activity;
	}

	/**
	 * @param mixed $activity
	 */
	public function setActivity( Activity $activity ): void {
		$this->activity = $activity;
	}

	/**
	 * @return mixed
	 */
	public function getTrades() {
		return $this->trades;
	}

	/**
	 * @param mixed $trades
	 */
	public function setTrades( Trades $trades ): void {
		$this->trades = $trades;
	}

	/**
	 * @return mixed
	 */
	public function getGovernment() {
		return $this->government;
	}

	/**
	 * @param mixed $government
	 */
	public function setGovernment(Government $government ): void {
		$this->government = $government;
	}

	/**
	 * @return mixed
	 */
	public function getDelegation() {
		return $this->delegation;
	}

	/**
	 * @param mixed $delegation
	 */
	public function setDelegation(Delegation $delegation ): void {
		$this->delegation = $delegation;
	}

	/**
	 * @return mixed
	 */
	public function getJuridique() {
		return $this->juridique;
	}

	/**
	 * @param mixed $juridique
	 */
	public function setJuridique( Juridique $juridique ): void {
		$this->juridique = $juridique;
	}

	/**
	 * @return mixed
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * @param mixed $zip
	 */
	public function setZip( $zip ): void {
		$this->zip = $zip;
	}

	/**
	 * @return mixed
	 */
	public function getAdresse() {
		return $this->adresse;
	}

	/**
	 * @param mixed $adresse
	 */
	public function setAdresse( $adresse ): void {
		$this->adresse = $adresse;
	}

	/**
	 * @return mixed
	 */
	public function getLocal() {
		return $this->local;
	}

	/**
	 * @param mixed $local
	 */
	public function setLocal( $local ): void {
		$this->local = $local;
	}

	/**
	 * @return mixed
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param mixed $date
	 */
	public function setDate( $date ): void {
		$this->date = $date;
	}

	/**
	 * @return mixed
	 */
	public function getIsDeleted() {
		return $this->isDeleted;
	}

	/**
	 * @param mixed $isDeleted
	 */
	public function setIsDeleted( $isDeleted ): void {
		$this->isDeleted = $isDeleted;
	}

	/**
	 * @return mixed
	 */
	public function getDateCreation() {
		return $this->dateCreation;
	}

	/**
	 * @param mixed $dateCreation
	 */
	public function setDateCreation( $dateCreation ): void {
		$this->dateCreation = $dateCreation;
	}

	/**
	 * @return mixed
	 */
	public function getIsActivityUpdated() {
		return $this->isActivityUpdated;
	}

	/**
	 * @param mixed $isActivityUpdated
	 */
	public function setIsActivityUpdated( $isActivityUpdated ): void {
		$this->isActivityUpdated = $isActivityUpdated;
	}

}
