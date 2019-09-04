<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaryRepository")
 */
class Commentary
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commentaries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie", inversedBy="commentaries")
     */
    private $idSerie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="commentaries")
     */
    private $idSeason;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Episode", inversedBy="commentaries")
     */
    private $idEpisode;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $spoil=false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rating;

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

    public function getIdSerie(): ?Serie
    {
        return $this->idSerie;
    }

    public function setIdSerie(?Serie $idSerie): self
    {
        $this->idSerie = $idSerie;

        return $this;
    }

    public function getIdSeason(): ?Season
    {
        return $this->idSeason;
    }

    public function setIdSeason(?Season $idSeason): self
    {
        $this->idSeason = $idSeason;

        return $this;
    }

    public function getIdEpisode(): ?Episode
    {
        return $this->idEpisode;
    }

    public function setIdEpisode(?Episode $idEpisode): self
    {
        $this->idEpisode = $idEpisode;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSpoil(): ?bool
    {
        return $this->spoil;
    }

    public function setSpoil(bool $spoil): self
    {
        $this->spoil = $spoil;

        return $this;
    }

    public function getRating(): ?bool
    {
        return $this->rating;
    }

    public function setRating(?bool $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
