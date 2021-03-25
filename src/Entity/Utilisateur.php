<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
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
    private $Password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Photo;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $Bibliography;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="idUtilisateur", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Signaler", mappedBy="idUtilisateur", orphanRemoval=true)
     */
    private $signaux;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reaction", mappedBy="idUtilisateur", orphanRemoval=true)
     */
    private $reactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publication", mappedBy="idU", orphanRemoval=true)
     */
    private $publications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publication", mappedBy="Utilisateur", orphanRemoval=true)
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vues", mappedBy="Utilisateur", orphanRemoval=true)
     */
    private $viewers;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->reactions = new ArrayCollection();
        $this->publications = new ArrayCollection();
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
            $commentaire->setIdUtilisateur($this);
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
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }
    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUtilisateur($this);
        }
        return $this;
    }
    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
        }
        return $this;
    }

    /**
     * @return Collection|publication[]
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }
    public function addPublications(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications[] = $publication;
            $publication->setIdU($this);
        }
        return $this;
    }
    public function removePublications(Publication $publication): self
    {
        if ($this->publications->contains($publication)) {
            $this->publications->removeElement($publication);
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
            $reaction->setIdUtilisateur($this);
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
            $signaler->setIdUtilisateur($this);
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
            $viewer->setUtilisateur($this);
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
     * @return mixed
     */
    public function getNom()
    {
        return $this->Nom;
    }

    /**
     * @param mixed $Nom
     */
    public function setNom($Nom): void
    {
        $this->Nom = $Nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->Prenom;
    }

    /**
     * @param mixed $Prenom
     */
    public function setPrenom($Prenom): void
    {
        $this->Prenom = $Prenom;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->Tel;
    }

    /**
     * @param mixed $Tel
     */
    public function setTel($Tel): void
    {
        $this->Tel = $Tel;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @param mixed $Password
     */
    public function setPassword($Password): void
    {
        $this->Password = $Password;
    }

    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->Pays;
    }

    /**
     * @param mixed $Pays
     */
    public function setPays($Pays): void
    {
        $this->Pays = $Pays;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->Role;
    }

    /**
     * @param mixed $Role
     */
    public function setRole($Role): void
    {
        $this->Role = $Role;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->Photo;
    }

    /**
     * @param mixed $Photo
     */
    public function setPhoto($Photo): void
    {
        $this->Photo = $Photo;
    }

    /**
     * @return mixed
     */
    public function getBibliography()
    {
        return $this->Bibliography;
    }

    /**
     * @param mixed $Bibliography
     */
    public function setBibliography($Bibliography): void
    {
        $this->Bibliography = $Bibliography;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


}
