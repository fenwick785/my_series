<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListUserSerieRepository")
 */
class ListUserSerie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="listUserSeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Serie", inversedBy="listUserSeries")
     */
    private $ListSeries;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Episode", inversedBy="listUserSeries")
     */
    private $episode;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $state;

    public function __construct()
    {
        $this->ListSeries = new ArrayCollection();
        $this->episode = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection|Serie[]
     */
    public function getListSeries(): Collection
    {
        return $this->ListSeries;
    }

    public function addListSeries(Serie $listSeries): self
    {
        if (!$this->ListSeries->contains($listSeries)) {
            $this->ListSeries[] = $listSeries;
        }

        return $this;
    }

    public function removeListSeries(Serie $listSeries): self
    {
        if ($this->ListSeries->contains($listSeries)) {
            $this->ListSeries->removeElement($listSeries);
        }

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisode(): Collection
    {
        return $this->episode;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episode->contains($episode)) {
            $this->episode[] = $episode;
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episode->contains($episode)) {
            $this->episode->removeElement($episode);
        }

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
