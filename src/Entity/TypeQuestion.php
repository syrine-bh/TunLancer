<?php

namespace App\Entity;

use App\Repository\TypeQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeQuestionRepository::class)
 */
class TypeQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMultiple;

    /**
     * @ORM\OneToMany(targetEntity=questionConcour::class, mappedBy="typeQuestion")
     */
    private $questionConcour;

    /**
     * @ORM\OneToMany(targetEntity=OptionQuestion::class, mappedBy="typeQuestion", orphanRemoval=true)
     */
    private $optionQuestions;

    public function __construct()
    {
        $this->questionConcour = new ArrayCollection();
        $this->optionQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsMultiple(): ?bool
    {
        return $this->isMultiple;
    }

    public function setIsMultiple(?bool $isMultiple): self
    {
        $this->isMultiple = $isMultiple;

        return $this;
    }

    /**
     * @return Collection|questionConcour[]
     */
    public function getQuestionConcour(): Collection
    {
        return $this->questionConcour;
    }

    public function addQuestionConcour(questionConcour $questionConcour): self
    {
        if (!$this->questionConcour->contains($questionConcour)) {
            $this->questionConcour[] = $questionConcour;
            $questionConcour->setTypeQuestion($this);
        }

        return $this;
    }

    public function removeQuestionConcour(questionConcour $questionConcour): self
    {
        if ($this->questionConcour->removeElement($questionConcour)) {
            // set the owning side to null (unless already changed)
            if ($questionConcour->getTypeQuestion() === $this) {
                $questionConcour->setTypeQuestion(null);
            }
        }

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
            $optionQuestion->setTypeQuestion($this);
        }

        return $this;
    }

    public function removeOptionQuestion(OptionQuestion $optionQuestion): self
    {
        if ($this->optionQuestions->removeElement($optionQuestion)) {
            // set the owning side to null (unless already changed)
            if ($optionQuestion->getTypeQuestion() === $this) {
                $optionQuestion->setTypeQuestion(null);
            }
        }

        return $this;
    }
}
