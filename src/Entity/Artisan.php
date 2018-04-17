<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisanRepository")
 * @UniqueEntity(fields={"cin"}, message="This field must be unique")
 */
class Artisan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trades;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Government")
     *  @ORM\JoinColumn(nullable=false)
     */
    private $government;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Delegation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $delegation;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Juridique")
     * @ORM\JoinColumn(nullable=false)
     */
    private $juridique;

    /**
     * @return mixed
     */
    public function getJuridique ()
    {
        return $this->juridique;
    }

    /**
     * @param mixed $juridique
     */
    public function setJuridique (Juridique $juridique): void
    {
        $this->juridique = $juridique;
    }
    /**
     * @return mixed
     */
    public function getDelegation ()
    {
        return $this->delegation;
    }
    /**
     * @param mixed $delegation
     */
    public function setDelegation (Delegation $delegation): void
    {
        $this->delegation = $delegation;
    }
    /**
     * @return mixed
     */
    public function getGovernment ()
    {
        return $this->government;
    }
    /**
     * @param Government $government
     */
    public function setGovernment (Government $government): void
    {
        $this->government = $government;
    }
    /**
     * @return mixed
     */
    public function getActivity ()
    {
        return $this->activity;
    }
    /**
     * @param mixed $activity
     */
    public function setActivity ( Activity $activity): void
    {
        $this->activity = $activity;
    }
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $lastName;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $cin ;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
     private $typeArtisan;

    /**
     * @return mixed
     */
    public function getTypeArtisan ()
    {
        return $this->typeArtisan;
    }

    /**
     * @param mixed $typeArtisan
     */
    public function setTypeArtisan ( int $typeArtisan): void
    {
        $this->typeArtisan = $typeArtisan;
    }
    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false ;

    /**
     * @return mixed
     */
    public function getIsDeleted ()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     */
    public function setIsDeleted ( $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation ;


    /**
     * @return mixed
     */
    public function getDateCreation ()
    {
        return $this->dateCreation;
    }
    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation (\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }
    /**
     * @ORM\Column(type="date")
     */
    private $birthday ;

    /**
     * @return mixed
     */
    public function getBirthday ()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday ( \DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActivityUpdated = false;
    /**
     * @return mixed
     */
    public function getIsActivityUpdated ()
    {
        return $this->isActivityUpdated;
    }
    /**
     * @param mixed $isActivityUpdated
     */
    public function setIsActivityUpdated ($isActivityUpdated): void
    {
        $this->isActivityUpdated = $isActivityUpdated;
    }
    /**
     * Artisan constructor.
     */
    public function __construct ()
    {
        $this->date = new \DateTime();
        $this->dateCreation = new \DateTime();
    }
    /**
     * @return mixed
     */
    public function getUser ()
    {
        return $this->user;
    }
    /**
     * @param User $user
     */
    public function setUser (User $user)
    {
        $this->user = $user;
    }
    /**
     * @return mixed
     */
    public function getId ()
    {
        //return sprintf("%'.07d",$this->id);
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
    public function getDate ()
    {
        return $this->date;
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
    public function getTrades ()
    {
        return $this->trades;
    }
    /**
     * @param mixed $trades
     */
    public function setTrades ( Trades $trades): void
    {
        $this->trades = $trades;
    }
}