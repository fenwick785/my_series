<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EpisodeRepository")
 */
class Episode
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idSeason;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderEpisode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentary", mappedBy="idEpisode")
     */
    private $commentaries;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ListUserSerie", mappedBy="episode")
     */
    private $listUserSeries;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    public function __construct()
    {
        $this->commentaries = new ArrayCollection();
        $this->listUserSeries = new ArrayCollection();
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

    public function getIdSeason(): ?Season
    {
        return $this->idSeason;
    }

    public function setIdSeason(?Season $idSeason): self
    {
        $this->idSeason = $idSeason;

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

    public function getOrderEpisode(): ?int
    {
        return $this->orderEpisode;
    }

    public function setOrderEpisode(int $orderEpisode): self
    {
        $this->orderEpisode = $orderEpisode;

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
            $commentary->setIdEpisode($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentaries->contains($commentary)) {
            $this->commentaries->removeElement($commentary);
            // set the owning side to null (unless already changed)
            if ($commentary->getIdEpisode() === $this) {
                $commentary->setIdEpisode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ListUserSerie[]
     */
    public function getListUserSeries(): Collection
    {
        return $this->listUserSeries;
    }

    public function addListUserSeries(ListUserSerie $listUserSeries): self
    {
        if (!$this->listUserSeries->contains($listUserSeries)) {
            $this->listUserSeries[] = $listUserSeries;
            $listUserSeries->addEpisode($this);
        }

        return $this;
    }

    public function removeListUserSeries(ListUserSerie $listUserSeries): self
    {
        if ($this->listUserSeries->contains($listUserSeries)) {
            $this->listUserSeries->removeElement($listUserSeries);
            $listUserSeries->removeEpisode($this);
        }

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }
}
