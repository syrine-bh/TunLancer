<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("post:read")
     * @Assert\NotBlank(message="titre is required")
     *      @Assert\Length(
     *      min = "3",
     *      max = "50",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )     *
     *
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     * @Assert\NotBlank(message="Description  is required")
     *
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Groups("post:read")
     * @Assert\NotBlank(message="Date  is required")
     *
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="annonces")
     * @Groups("post:read")
     *
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="lieux is required")
     */
    private $lieux;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="renumeration is required")
     */
    private $renumeration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCategorie(): ?categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(string $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getRenumeration(): ?string
    {
        return $this->renumeration;
    }

    public function setRenumeration(string $renumeration): self
    {
        $this->renumeration = $renumeration;

        return $this;
    }
}
