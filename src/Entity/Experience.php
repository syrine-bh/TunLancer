<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExperienceRepository::class)
 */
class Experience
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poste;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Societe;

    /**
     * @ORM\Column(type="date" , nullable=true)
     */
    private $Periode;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="experiences")
     */
    private $relation;






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getSociete(): ?string
    {
        return $this->Societe;
    }

    public function setSociete(string $Societe): self
    {
        $this->Societe = $Societe;

        return $this;
    }

    public function getPeriode(): ?\DateTimeInterface
    {
        return $this->Periode;
    }

    public function setPeriode(\DateTimeInterface $Periode): self
    {
        $this->Periode = $Periode;

        return $this;
    }

    public function getRelation(): ?Users
    {
        return $this->relation;
    }

    public function setRelation(?Users $relation): self
    {
        $this->relation = $relation;

        return $this;
    }










}
