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
     */
    private $questionConcours;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textOption;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTrue;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionConcours(): ?questionConcour
    {
        return $this->questionConcours;
    }

    public function setQuestionConcours(?questionConcour $questionConcours): self
    {
        $this->questionConcours = $questionConcours;

        return $this;
    }

    public function getTextOption(): ?string
    {
        return $this->textOption;
    }

    public function setTextOption(string $textOption): self
    {
        $this->textOption = $textOption;

        return $this;
    }

    public function getIsTrue(): ?bool
    {
        return $this->isTrue;
    }

    public function setIsTrue(bool $isTrue): self
    {
        $this->isTrue = $isTrue;

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
}
