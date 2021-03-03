<?php

namespace App\Entity;

use App\Repository\QuestionConcourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionConcourRepository::class)
 */
class QuestionConcour
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ImageURL;

    /**
     * @ORM\ManyToOne(targetEntity=concour::class, inversedBy="questionConcours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $concour;

    /**
     * @ORM\ManyToOne(targetEntity=TypeQuestion::class, inversedBy="questionConcour")
     */
    private $typeQuestion;

    /**
     * @ORM\OneToMany(targetEntity=OptionQuestion::class, mappedBy="questionConcour")
     */
    private $optionQuestions;

    public function __construct()
    {
        $this->optionQuestions = new ArrayCollection();
    }

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

    public function getImageURL(): ?string
    {
        return $this->ImageURL;
    }

    public function setImageURL(?string $ImageURL): self
    {
        $this->ImageURL = $ImageURL;

        return $this;
    }

    public function getConcour(): ?concour
    {
        return $this->concour;
    }

    public function setConcour(?concour $concour): self
    {
        $this->concour = $concour;

        return $this;
    }

    public function getTypeQuestion(): ?TypeQuestion
    {
        return $this->typeQuestion;
    }

    public function setTypeQuestion(?TypeQuestion $typeQuestion): self
    {
        $this->typeQuestion = $typeQuestion;

        return $this;
    }

    /**
     * @return Collection|OptionQuestion[]
     */
    public function getOptionQuestions(): Collection
    {
        return $this->optionQuestions;
    }

    public function addOptionQuestion(OptionQuestion $optionQuestion): self
    {
        if (!$this->optionQuestions->contains($optionQuestion)) {
            $this->optionQuestions[] = $optionQuestion;
            $optionQuestion->setQuestionConcour($this);
        }

        return $this;
    }

    public function removeOptionQuestion(OptionQuestion $optionQuestion): self
    {
        if ($this->optionQuestions->removeElement($optionQuestion)) {
            // set the owning side to null (unless already changed)
            if ($optionQuestion->getQuestionConcour() === $this) {
                $optionQuestion->setQuestionConcour(null);
            }
        }

        return $this;
    }
}
