<?php

namespace App\Entity;

use App\Repository\RepliesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Utilisateurs;


/**
 * @ORM\Entity(repositoryClass=RepliesRepository::class)
 */
class Replies
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="entrez votre nom")
     */
    private $auteur;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @Assert\Length(
     *     min="5",
     *     max="800"
     * )
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Topics::class, inversedBy="replies")
     */
    private $topic;

    /**
     * @ORM\OneToMany(targetEntity=PostLike::class, mappedBy="reply")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=PostDislike::class, mappedBy="reply")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $dislikes;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="replies")
     */
    private $user;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTopic(): ?Topics
    {
        return $this->topic;
    }

    public function setTopic(?Topics $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return Collection|PostLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(PostLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setReply($this);
        }

        return $this;
    }

    public function removeLike(PostLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getReply() === $this) {
                $like->setReply(null);
            }
        }

        return $this;
    }

    /**
     * le commentaire est liké par un utilisateur
     * @param Utilisateurs $user
     * @return bool
     */
    public function isLikedByUser(Utilisateurs $user): bool {
        foreach ($this->likes as $like){
            if ($like->getUser()=== $user) return true;
        }

        return false;

    }

/**
 * @return Collection|PostDislike[]
 */
public function getDislikes(): Collection
{
    return $this->dislikes;
}

public function addDislike(PostDislike $dislike): self
{
    if (!$this->dislikes->contains($dislike)) {
        $this->dislikes[] = $dislike;
        $dislike->setReply($this);
    }

    return $this;
}

public function removeDislike(PostDislike $dislike): self
{
    if ($this->dislikes->removeElement($dislike)) {
        // set the owning side to null (unless already changed)
        if ($dislike->getReply() === $this) {
            $dislike->setReply(null);
        }
    }

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
