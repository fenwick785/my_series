<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TranslatedLanguageRepository")
 */
class TranslatedLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Season", inversedBy="translatedLanguages")
     */
    private $idSeason;

    public function __construct()
    {
        $this->idSeason = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getIdSeason(): Collection
    {
        return $this->idSeason;
    }

    public function addIdSeason(Season $idSeason): self
    {
        if (!$this->idSeason->contains($idSeason)) {
            $this->idSeason[] = $idSeason;
        }

        return $this;
    }

    public function removeIdSeason(Season $idSeason): self
    {
        if ($this->idSeason->contains($idSeason)) {
            $this->idSeason->removeElement($idSeason);
        }

        return $this;
    }
    public function __toString() {
        
        return $this->language;
    }
}
