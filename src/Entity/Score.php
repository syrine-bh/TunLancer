<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;
use ArrayAccess;
/**
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score implements ArrayAccess
{
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }



    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageProfil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="scores")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=quiz::class, inversedBy="scores")
     */
    private $quiz;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function getPourcentage(): ?string
    {
        $scores = explode("/", $this->getScore());
        $points = floatval($scores[0]);
        $totalPoints = floatval($scores[1]);
        $pourcentage = ( $points / $totalPoints ) * 100 ;

        return $pourcentage." %";
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getImageProfil(): ?string
    {
        return $this->imageProfil;
    }

    public function setImageProfil(?string $imageProfil): self
    {
        $this->imageProfil = $imageProfil;

        return $this;
    }
    function compareScores($a, $b) {

        $scores1 = explode("/", $a->getScore());
        $points1 = floatval($scores1[0]);
        $totalPoints1 = floatval($scores1[1]);
        $pourcentage1 = ( $points1 / $totalPoints1 ) * 100 ;

        $scores2 = explode("/", $b->getScore());
        $points2 = floatval($scores2[0]);
        $totalPoints2 = floatval($scores2[1]);
        $pourcentage2 = ( $points2 / $totalPoints2 ) * 100 ;

        if( $pourcentage1 > $pourcentage2 ) {
            return -1;
        }
        else return 1;
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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getQuiz(): ?quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }






}
