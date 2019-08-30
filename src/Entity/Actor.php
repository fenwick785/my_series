<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActorRepository")
 */
class Actor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $deathDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Serie", inversedBy="actors")
     */
    private $idSerie;

    public function __construct()
    {
        $this->idSerie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getDeathDate(): ?\DateTimeInterface
    {
        return $this->deathDate;
    }

    public function setDeathDate(?\DateTimeInterface $deathDate): self
    {
        $this->deathDate = $deathDate;

        return $this;
    }

    /**
     * @return Collection|Serie[]
     */
    public function getIdSerie(): Collection
    {
        return $this->idSerie;
    }

    public function addIdSerie(Serie $idSerie): self
    {
        if (!$this->idSerie->contains($idSerie)) {
            $this->idSerie[] = $idSerie;
        }

        return $this;
    }

    public function removeIdSerie(Serie $idSerie): self
    {
        if ($this->idSerie->contains($idSerie)) {
            $this->idSerie->removeElement($idSerie);
        }

        return $this;
    }
    public function __toString() {
        $actor=$this->firstName." ".$this->lastName;
        return $actor;
    }
}
