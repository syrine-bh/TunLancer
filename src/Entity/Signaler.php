<?php

namespace App\Entity;

use App\Repository\SignalerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignalerRepository::class)
 */
class Signaler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="signaux")
     */
    private $idUtilisateur;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Publication", inversedBy="signaux")
     */
    private $publication;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;


    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;


    public function getId(): ?int
    {
        return $this->id;
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

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
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
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

}
