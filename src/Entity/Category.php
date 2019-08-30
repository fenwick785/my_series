<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Serie", inversedBy="categories")
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
        
        return $this->type;

    }
}
