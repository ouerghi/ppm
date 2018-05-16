<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyHistoryRepository")
 */
class CompanyHistory extends PMHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Company", cascade={"remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */

	private $company;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $name;

	/**
	 * @return mixed
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * @param mixed $company
	 */
	public function setCompany(Company $company ): void {
		$this->company = $company;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ): void {
		$this->name = $name;
	}


}
