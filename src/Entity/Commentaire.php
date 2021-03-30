<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idCommentaire;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Publication", inversedBy="commentaires")
     */
    private $publication;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="commentaires")
     */
    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenuCommentaire", type="string", length=255, nullable=false)
     */
    private $contenuCommentaire;





    /**
     * @return mixed
     */
    public function getIdCommentaire()
    {
        return $this->idCommentaire;
    }

    /**
     * @param mixed $idCommentaire
     */
    public function setIdCommentaire($idCommentaire): void
    {
        $this->idCommentaire = $idCommentaire;
    }

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;

        return $this;
    }

    public function getIdUtilisateur(): ?Users
    {
        return $this->idUtilisateur;
    }
    public function setIdUtilisateur(?Users $utilisateur): self
    {
        $this->idUtilisateur = $utilisateur;
        return $this;
    }





    public function getContenuCommentaire(): ?string
    {
        return $this->contenuCommentaire;
    }


    public function setContenuCommentaire(?string $contenuCommentaire): void
    {
        $this->contenuCommentaire = $contenuCommentaire;
    }







}
