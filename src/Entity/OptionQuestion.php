<?php

namespace App\Entity;

use App\Repository\OptionQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionQuestionRepository::class)
 */
class OptionQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=questionConcour::class, inversedBy="optionQuestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $questionConcour;

    /**
     * @ORM\ManyToOne(targetEntity=typeQuestion::class, inversedBy="optionQuestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeQuestion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionConcour(): ?questionConcour
    {
        return $this->questionConcour;
    }

    public function setQuestionConcour(?questionConcour $questionConcour): self
    {
        $this->questionConcour = $questionConcour;

        return $this;
    }

    public function getTypeQuestion(): ?typeQuestion
    {
        return $this->typeQuestion;
    }

    public function setTypeQuestion(?typeQuestion $typeQuestion): self
    {
        $this->typeQuestion = $typeQuestion;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
