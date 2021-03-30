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
     * @ORM\ManyToOne(targetEntity=Concour::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $concour;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=true)
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

//    /**
//     * @ORM\OneToOne(targetEntity=score::class, cascade={"persist", "remove"})
//     */
//    private $score;

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

//    public function getScore(): ?score
//    {
//        return $this->score;
//    }
//
//    public function setScore(?score $score): self
//    {
//        $this->score = $score;
//
//        return $this;
//    }
    /**
     * @ORM\ManyToOne(targetEntity="Video")
     * @ORM\JoinColumn(name="video_id", referencedColumnName="id" ,onDelete="CASCADE")
     */
    private $video;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateParticipation;

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    public function getDateParticipation(): ?\DateTimeInterface
    {
        return $this->dateParticipation;
    }

    public function setDateParticipation(?\DateTimeInterface $dateParticipation): self
    {
        $this->dateParticipation = $dateParticipation;

        return $this;
    }
}