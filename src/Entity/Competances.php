<?php

namespace App\Entity;

use App\Repository\CompetancesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetancesRepository::class)
 */
class Competances
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */

    private $TitreCompetance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaine;

    /**
     * @ORM\Column(type="float")
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCompetance(): ?int
    {
        return $this->id_competance;
    }

    public function setIdCompetance(int $id_competance): self
    {
        $this->id_competance = $id_competance;

        return $this;
    }

    public function getTitreCompetance(): ?string
    {
        return $this->TitreCompetance;
    }

    public function setTitreCompetance(string $TitreCompetance): self
    {
        $this->TitreCompetance = $TitreCompetance;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }
}
