<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=users::class, inversedBy="test")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=concour::class, inversedBy="notes")
     */
    private $concours;

    /**
     * @ORM\Column(type="integer")
     */
    private $NoteConcour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?users
    {
        return $this->users;
    }

    public function setUsers(?users $users): self
    {
        $this->users = $users;

        return $this;
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

    public function getNoteConcour(): ?int
    {
        return $this->NoteConcour;
    }

    public function setNoteConcour(int $NoteConcour): self
    {
        $this->NoteConcour = $NoteConcour;

        return $this;
    }
}
