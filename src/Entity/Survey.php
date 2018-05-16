<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


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
	 * @ORM\ManyToMany(targetEntity="App\Entity\User", cascade={"persist"})
	 * @ORM\JoinTable(name="pm_survey_users")
	 */
    private $users;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"ALL"})
	 */
    private $user;
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
    private $dates;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;



    public function __construct()
    {
    	$this->users = new ArrayCollection();
    	$this->dates = new \DateTime();
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
	public function setUser( User $user ): void {
		$this->user = $user;
	}

	/**
	 * @return mixed
	 */
	public function getUsers()
	{
		return $this->users;
	}

	/**
	 * @param User $user
	 */
	public function addUser(User $user)
	{
		$this->users[] = $user;
	}

	/**
	 * @param User $user
	 */
	public function removeUser(User $user)
	{
		$this->users->removeElement($user);
	}

	/**
	 * @return mixed
	 */
	public function getEnqueutor() {
		return $this->enqueutor;
	}

	/**
	 * @param mixed $enqueutor
	 */
	public function setEnqueutor(Enqueutor $enqueutor ): void {
		$this->enqueutor = $enqueutor;
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
        return $this->dates;
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
