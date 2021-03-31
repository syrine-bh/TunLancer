<?php

namespace App\Entity;

use App\Repository\PostLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostLikeRepository::class)
 */
class PostLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Replies::class, inversedBy="likes")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $reply;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="likes")
     */
    private $user;





    public function getReply(): ?Replies
    {
        return $this->reply;
    }

    public function setReply(?Replies $reply): self
    {
        $this->reply = $reply;

        return $this;
    }



public function getUser(): ?Utilisateurs
{
    return $this->user;
}

public function setUser(?Utilisateurs $user): self
{
    $this->user = $user;

    return $this;
}




}
