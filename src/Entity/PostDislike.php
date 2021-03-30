<?php

namespace App\Entity;

use App\Repository\PostDislikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostDislikeRepository::class)
 */
class PostDislike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Replies::class, inversedBy="dislikes")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $reply;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReply(): ?Replies
    {
        return $this->reply;
    }

    public function setReply(?Replies $reply): self
    {
        $this->reply = $reply;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): self
    {
        $this->user = $user;

        return $this;
    }
}
