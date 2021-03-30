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
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="reactions")
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

    public function getIdUtilisateur(): ?Users
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Users $utilisateur): self
    {
        $this->idUtilisateur = $utilisateur;
        return $this;
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
