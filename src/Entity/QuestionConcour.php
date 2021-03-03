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
     * @ORM\ManyToOne(targetEntity=concour::class, inversedBy="questionConcours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $concours;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text_question;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=OptionQuestion::class, mappedBy="questionConcours")
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

    public function getConcours(): ?concour
    {
        return $this->concours;
    }

    public function setConcours(?concour $concours): self
    {
        $this->concours = $concours;

        return $this;
    }

    public function getTextQuestion(): ?string
    {
        return $this->text_question;
    }

    public function setTextQuestion(string $text_question): self
    {
        $this->text_question = $text_question;

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
            $optionQuestion->setQuestionConcours($this);
        }

        return $this;
    }

    public function removeOptionQuestion(OptionQuestion $optionQuestion): self
    {
        if ($this->optionQuestions->removeElement($optionQuestion)) {
            // set the owning side to null (unless already changed)
            if ($optionQuestion->getQuestionConcours() === $this) {
                $optionQuestion->setQuestionConcours(null);
            }
        }

        return $this;
    }
}
