<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string")
     */
    private $government;


    /**
     * @ORM\Column(type="string")
     */
    private $delegation;
    /**
     * @ORM\Column(type="string")
     */
    private $location;
    /**
     * @ORM\Column(type="string")
     */
    private $zip;
    /**
     * @ORM\Column(type="smallint")
     */
    private $order;
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
    public function getGovernment ()
    {
        return $this->government;
    }

    /**
     * @param mixed $government
     */
    public function setGovernment ($government): void
    {
        $this->government = $government;
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
    public function setDelegation ($delegation): void
    {
        $this->delegation = $delegation;
    }

    /**
     * @return mixed
     */
    public function getLocation ()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation ($location): void
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getZip ()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip ($zip): void
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getOrder ()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder ($order): void
    {
        $this->order = $order;
    }



}
