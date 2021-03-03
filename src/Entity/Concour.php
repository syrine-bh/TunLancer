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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="concours")
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="concours")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=QuestionConcour::class, mappedBy="concours")
     */
    private $questionConcours;

    public function __construct()
    {
        $this->test = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->questionConcours = new ArrayCollection();
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
     * @return Collection|Users[]
     */
    public function getTest(): Collection
    {
        return $this->test;
    }

    public function addTest(Users $test): self
    {
        if (!$this->test->contains($test)) {
            $this->test[] = $test;
            $test->addConcour($this);
        }

        return $this;
    }

    public function removeTest(Users $test): self
    {
        if ($this->test->removeElement($test)) {
            $test->removeConcour($this);
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setConcours($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getConcours() === $this) {
                $note->setConcours(null);
            }
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
            $questionConcour->setConcours($this);
        }

        return $this;
    }

    public function removeQuestionConcour(QuestionConcour $questionConcour): self
    {
        if ($this->questionConcours->removeElement($questionConcour)) {
            // set the owning side to null (unless already changed)
            if ($questionConcour->getConcours() === $this) {
                $questionConcour->setConcours(null);
            }
        }

        return $this;
    }
}
