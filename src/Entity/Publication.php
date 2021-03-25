<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 * @Vich\Uploadable
 */
class Publication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="publications")
     */
    private $idU;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $archive;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="publication_image", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="publication", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reaction", mappedBy="publication", orphanRemoval=true)
     */
    private $reactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Signaler", mappedBy="publication", orphanRemoval=true)
     */
    private $signaux;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="publication", orphanRemoval=true)
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vues", mappedBy="Publication", orphanRemoval=true)
     */
    private $viewers;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->reactions = new ArrayCollection();
        $this->signaux = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->viewers = new ArrayCollection();
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }
    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setPublication($this);
        }
        return $this;
    }
    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
        }
        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }
    public function addReaction(Reaction $reaction): self
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions[] = $reaction;
            $reaction->setPublication($this);
        }
        return $this;
    }
    public function removeReaction(Reaction $reaction): self
    {
        if ($this->reactions->contains($reaction)) {
            $this->reactions->removeElement($reaction);
        }
        return $this;
    }



    /**
     * @return Collection|Signaler[]
     */
    public function getSignaux(): Collection
    {
        return $this->signaux;
    }
    public function addSignaler (Signaler $signaler): self
    {
        if (!$this->signaux->contains($signaler)) {
            $this->signaux[] = $signaler;
            $signaler->setPublication($this);
        }
        return $this;
    }
    public function removeSignaler (Signaler $signaler): self
    {
        if ($this->signaux->contains($signaler)) {
            $this->signaux->removeElement($signaler);
        }
        return $this;
    }


    /**
     * @return Collection|Vues[]
     */
    public function getViewers(): Collection
    {
        return $this->viewers;
    }
    public function addViewer(Vues $viewer): self
    {
        if (!$this->viewers->contains($viewer)) {
            $this->viewers[] = $viewer;
            $viewer->setPublication($this);
        }
        return $this;
    }
    public function removeViewer(Vues $viewer): self
    {
        if ($this->viewers->contains($viewer)) {
            $this->viewers->removeElement($viewer);
        }
        return $this;
    }



    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }
    public function addNotification (Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setPublication($this);
        }
        return $this;
    }
    public function removeNotification (Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
        }
        return $this;
    }






    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }



    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return mixed
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param mixed $localisation
     */
    public function setLocalisation($localisation): void
    {
        $this->localisation = $localisation;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdU(): ?Utilisateur
    {
        return $this->idU;
    }
    public function setIdU(Utilisateur  $utilisateur): self
    {
        $this->idU = $utilisateur;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getArchive(): ?int
    {
        return $this->archive;
    }

    public function setArchive(int $archive): self
    {
        $this->archive = $archive;
        return $this;
    }



}
