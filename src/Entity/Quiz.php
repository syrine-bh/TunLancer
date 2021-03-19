<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Questiontab::class, mappedBy="quiz", orphanRemoval=true)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=Concour::class, inversedBy="quiz")
     */
    private $concour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbQuestions;

    /**
     * @ORM\OneToMany(targetEntity=Questiontab::class, mappedBy="quiz")
     */
    private $questiontab;

    /**
     * @ORM\OneToMany(targetEntity=Score::class, mappedBy="quiz")
     */
    private $scores;



    public function __construct()
    {
        $this->question = new ArrayCollection();
        $this->questiontab = new ArrayCollection();
        $this->scores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Questiontab[]
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Questiontab $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question[] = $question;
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Questiontab $question): self
    {
        if ($this->question->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    public function getConcour(): ?Concour
    {
        return $this->concour;
    }

    public function setConcour(?Concour $concour): self
    {
        $this->concour = $concour;

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

    public function getNbQuestions(): ?int
    {
        return $this->nbQuestions;
    }

    public function setNbQuestions(int $nbQuestions): self
    {
        $this->nbQuestions = $nbQuestions;

        return $this;
    }

    /**
     * @return Collection|Questiontab[]
     */
    public function getQuestiontab(): Collection
    {
        return $this->questiontab;
    }

    public function addQuestiontab(Questiontab $questiontab): self
    {
        if (!$this->questiontab->contains($questiontab)) {
            $this->questiontab[] = $questiontab;
            $questiontab->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestiontab(Questiontab $questiontab): self
    {
        if ($this->questiontab->removeElement($questiontab)) {
            // set the owning side to null (unless already changed)
            if ($questiontab->getQuiz() === $this) {
                $questiontab->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Score[]
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(Score $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setQuiz($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getQuiz() === $this) {
                $score->setQuiz(null);
            }
        }

        return $this;
    }



}
