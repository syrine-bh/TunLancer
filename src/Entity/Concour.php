<?php

namespace App\Entity;

use App\Repository\ConcoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcoursRepository::class)
 */
class Concour
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
    private $sujet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;


    /**
     * @var DateTime $created
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="concour")
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity=QuestionConcour::class, mappedBy="concour")
     */
    private $questionConcours;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="concour", orphanRemoval=true)
     */
    private $participations;

    public function __construct()
    {
        $this->questionConcours = new ArrayCollection();
        $this->participations = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getTest(): Collection
    {
        return $this->test;
    }

    public function addTest(User $test): self
    {
        if (!$this->test->contains($test)) {
            $this->test[] = $test;
            $test->addConcour($this);
        }

        return $this;
    }

    public function removeTest(User $test): self
    {
        if ($this->test->removeElement($test)) {
            $test->removeConcour($this);
        }

        return $this;
    }

    /**
     * @return Collection|QuestionConcour[]
     */
    public function getQuestionConcours(): Collection
    {
        return $this->questionConcours;
    }

    public function addQuestionConcour(QuestionConcour $questionConcour): self
    {
        if (!$this->questionConcours->contains($questionConcour)) {
            $this->questionConcours[] = $questionConcour;
            $questionConcour->setConcour($this);
        }

        return $this;
    }

    public function removeQuestionConcour(QuestionConcour $questionConcour): self
    {
        if ($this->questionConcours->removeElement($questionConcour)) {
            // set the owning side to null (unless already changed)
            if ($questionConcour->getConcour() === $this) {
                $questionConcour->setConcour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setConcour($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getConcour() === $this) {
                $participation->setConcour(null);
            }
        }

        return $this;
    }




}
