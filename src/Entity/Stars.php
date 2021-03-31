<?php

namespace App\Entity;

use App\Repository\StarsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StarsRepository::class)
 */
class Stars
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $rateindex;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRateindex(): ?int
    {
        return $this->rateindex;
    }

    public function setRateindex(?int $rateindex): self
    {
        $this->rateindex = $rateindex;

        return $this;
    }
}
