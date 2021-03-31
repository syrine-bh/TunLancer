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
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;




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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Video")
     * @ORM\JoinColumn(name="video_id", referencedColumnName="id" ,onDelete="CASCADE")
     */
    private $video;

    /**
     * @ORM\Column(type="datetime", nullable=true,options={"default": "CURRENT_TIMESTAMP"})
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
