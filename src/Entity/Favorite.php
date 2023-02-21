<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?Videos $idVideo = null;

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

    public function getIdVideo(): ?Videos
    {
        return $this->idVideo;
    }

    public function setIdVideo(?Videos $idVideo): self
    {
        $this->idVideo = $idVideo;

        return $this;
    }
}
