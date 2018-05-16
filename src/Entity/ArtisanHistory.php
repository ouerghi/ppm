<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisanHistoryRepository")
 */
class ArtisanHistory extends PMHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artisan", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */

    private $artisan;


    /**
     * @ORM\Column(type="integer")
     */
    private $old_cin;

    /**
     * @return mixed
     */
    public function getOldCin ()
    {
        return $this->old_cin;
    }

    /**
     * @param mixed $old_cin
     */
    public function setOldCin ($old_cin): void
    {
        $this->old_cin = $old_cin;
    }



    /**
     * @return mixed
     */
    public function getArtisan ()
    {
        return $this->artisan;
    }

    /**
     * @param mixed $artisan
     */
    public function setArtisan (Artisan $artisan): void
    {
        $this->artisan = $artisan;
    }

    // add your own fields
}
