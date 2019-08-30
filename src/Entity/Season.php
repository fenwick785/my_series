<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 */
class Season
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderSeason;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie", inversedBy="seasons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idSerie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalEpisodes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="idSeason")
     */
    private $episodes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TranslatedLanguage", mappedBy="idSeason")
     */
    private $translatedLanguages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentary", mappedBy="idSeason")
     */
    private $commentaries;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
        $this->translatedLanguages = new ArrayCollection();
        $this->commentaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getOrderSeason(): ?int
    {
        return $this->orderSeason;
    }

    public function setOrderSeason(int $orderSeason): self
    {
        $this->orderSeason = $orderSeason;

        return $this;
    }

    public function getIdSerie(): ?Serie
    {
        return $this->idSerie;
    }

    public function setIdSerie(?Serie $idSerie): self
    {
        $this->idSerie = $idSerie;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getTotalEpisodes(): ?int
    {
        return $this->totalEpisodes;
    }

    public function setTotalEpisodes(?int $totalEpisodes): self
    {
        $this->totalEpisodes = $totalEpisodes;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setIdSeason($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getIdSeason() === $this) {
                $episode->setIdSeason(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TranslatedLanguage[]
     */
    public function getTranslatedLanguages(): Collection
    {
        return $this->translatedLanguages;
    }

    public function addTranslatedLanguage(TranslatedLanguage $translatedLanguage): self
    {
        if (!$this->translatedLanguages->contains($translatedLanguage)) {
            $this->translatedLanguages[] = $translatedLanguage;
            $translatedLanguage->addIdSeason($this);
        }

        return $this;
    }

    public function removeTranslatedLanguage(TranslatedLanguage $translatedLanguage): self
    {
        if ($this->translatedLanguages->contains($translatedLanguage)) {
            $this->translatedLanguages->removeElement($translatedLanguage);
            $translatedLanguage->removeIdSeason($this);
        }

        return $this;
    }

    /**
     * @return Collection|Commentary[]
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries[] = $commentary;
            $commentary->setIdSeason($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentaries->contains($commentary)) {
            $this->commentaries->removeElement($commentary);
            // set the owning side to null (unless already changed)
            if ($commentary->getIdSeason() === $this) {
                $commentary->setIdSeason(null);
            }
        }

        return $this;
    }
    public function __toString() {
        
        return $this->title;
    }
}
