<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idReaction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Publication", inversedBy="reactions")
     */
    private $publication;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUtilisateur", type="integer", nullable=false)
     */
    private $idUtilisateur;

    /**
     * @var integer
     *
     * @ORM\Column(name="typeReaction", type="integer", nullable=false)
     */
    private $typeReaction;

    /**
     * @return mixed
     */
    public function getIdReaction()
    {
        return $this->idReaction;
    }

    /**
     * @param mixed $idReaction
     */
    public function setIdReaction($idReaction): void
    {
        $this->idReaction = $idReaction;
    }

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    /**
     * @param int $idUtilisateur
     */
    public function setIdUtilisateur(int $idUtilisateur): void
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    /**
     * @return string
     */
    public function getTypeReaction(): string
    {
        return $this->typeReaction;
    }

    /**
     * @param string $typeReaction
     */
    public function setTypeReaction(string $typeReaction): void
    {
        $this->typeReaction = $typeReaction;
    }


}
