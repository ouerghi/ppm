<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="It looks like your already used this login!")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorMap({"enqueutor" = "Enqueutor", "user" = "User"})
 */
 class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     *  @Assert\NotBlank()
     * * @Assert\Length(min="4", minMessage="Your login must be at least {{ limit }} characters long")
     */
    private $username;

    /**
     * @ORM\Column(type="json_array")
     */

    private $roles = array();
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Government", )
     *  @ORM\JoinColumn(nullable=false)
     */
    private $government;
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
    public function getId ()
    {
        return $this->id;
    }
    /**
     * @param mixed $username
     */
    public function setUsername ($username)
    {
        $this->username = $username;
    }
    /**
     * @param mixed $password
     */
    public function setPassword ($password)
    {
        $this->password = $password;
    }
    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\Length(min="5", minMessage="Your password must be at least {{ limit }} characters long")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $date ;

    /**
     * @param mixed $isActive
     */
    public function setIsActive ( $isActive): void
    {
        $this->isActive = $isActive;
    }
    /**
     * @return mixed
     */
    public function getIsActive ()
    {
        return $this->isActive;
    }
    public function __construct()
    {
    	  $this->date = new \DateTime("now");
//        $this->roles = array('ROLE_DRC');
    }



	/**
	 * @return mixed
	 */
	public function getDate() {
		return $this->date;
	}

    public function getUsername()
    {
        return $this->username;
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRoles()
    {
        $roles = $this->roles;
//        $roles[] = 'ROLE_DRC';
        return array_unique($roles);
    }
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        // allows for chaining
        return $this;
    }
    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }


}
