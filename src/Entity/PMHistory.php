<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PMHistoryRepository")
 * /**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"artisan_history" = "ArtisanHistory", "company_history" = "CompanyHistory"})
 */
 Abstract class PMHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Activity", cascade={"remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $activity;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Trades" ,cascade={"remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $trade;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Government" ,cascade={"remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $government;
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Delegation" ,cascade={"remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $delegation;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * @ORM\Column(type="date")
	 */
	private $old_dateCreation ;
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $activityChanged = false;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $governmentChanged = false;

	/**
	 * @ORM\Column(type="date")
	 */
	private $dateUpdate;

	 /**
	  * @ORM\Column(type="boolean")
	  */
	 private $isDeleted = false ;



	 public function __construct ()
	{
		$this->dateUpdate = new \DateTime();
	}


	public function getId()
	{
		return $this->id;
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
	public function setActivity( $activity ): void {
		$this->activity = $activity;
	}

	/**
	 * @return mixed
	 */
	public function getTrade() {
		return $this->trade;
	}

	/**
	 * @param mixed $trade
	 */
	public function setTrade( $trade ): void {
		$this->trade = $trade;
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
	public function setGovernment( $government ): void {
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
	public function setDelegation( $delegation ): void {
		$this->delegation = $delegation;
	}

	/**
	 * @return mixed
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( $user ): void {
		$this->user = $user;
	}

	/**
	 * @return mixed
	 */
	public function getOldDateCreation() {
		return $this->old_dateCreation;
	}

	/**
	 * @param mixed $old_dateCreation
	 */
	public function setOldDateCreation( $old_dateCreation ): void {
		$this->old_dateCreation = $old_dateCreation;
	}

	/**
	 * @return mixed
	 */
	public function getActivityChanged() {
		return $this->activityChanged;
	}

	/**
	 * @param mixed $activityChanged
	 */
	public function setActivityChanged( $activityChanged ): void {
		$this->activityChanged = $activityChanged;
	}

	/**
	 * @return mixed
	 */
	public function getGovernmentChanged() {
		return $this->governmentChanged;
	}

	/**
	 * @param mixed $governmentChanged
	 */
	public function setGovernmentChanged( $governmentChanged ): void {
		$this->governmentChanged = $governmentChanged;
	}

	/**
	 * @return mixed
	 */
	public function getDateUpdate() {
		return $this->dateUpdate;
	}

	/**
	 * @param mixed $dateUpdate
	 */
	public function setDateUpdate( $dateUpdate ): void {
		$this->dateUpdate = $dateUpdate;
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


}
