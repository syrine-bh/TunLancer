<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $Tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bibliography;

    /**
     * @ORM\ManyToMany(targetEntity=concour::class, inversedBy="test")
     */
    private $concours;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="users")
     */
    private $test;

    public function __construct()
    {
        $this->concours = new ArrayCollection();
        $this->test = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }


    public function getTel(): ?int
    {
        return (string) $this->Tel;
    }

    public function setTel($Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): self
    {
        $this->Role = $Role;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getBibliography(): ?string
    {
        return $this->bibliography;
    }

    public function setBibliography(?string $bibliography): self
    {
        $this->bibliography = $bibliography;

        return $this;
    }

    /**
     * @return Collection|concour[]
     */
    public function getConcours(): Collection
    {
        return $this->concours;
    }

    public function addConcour(concour $concour): self
    {
        if (!$this->concours->contains($concour)) {
            $this->concours[] = $concour;
        }

        return $this;
    }

    public function removeConcour(concour $concour): self
    {
        $this->concours->removeElement($concour);

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getTest(): Collection
    {
        return $this->test;
    }

    public function addTest(Note $test): self
    {
        if (!$this->test->contains($test)) {
            $this->test[] = $test;
            $test->setUsers($this);
        }

        return $this;
    }

    public function removeTest(Note $test): self
    {
        if ($this->test->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getUsers() === $this) {
                $test->setUsers(null);
            }
        }

        return $this;
    }
}
