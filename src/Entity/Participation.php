<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=concour::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $concour;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userAgent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addrIP;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getAddrIP(): ?string
    {
        return $this->addrIP;
    }

    public function setAddrIP(?string $addrIP): self
    {
        $this->addrIP = $addrIP;

        return $this;
    }
}
