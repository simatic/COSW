<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(min="0", max="100")
     */
    private ?int $noteFinale;

    /**
     * @ORM\ManyToOne(targetEntity=FicheEvaluation::class)
     */
    private $fiche;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteFinale(): ?int
    {
        return $this->noteFinale;
    }

    public function setNoteFinale(?int $noteFinale): self
    {
        $this->noteFinale = $noteFinale;

        return $this;
    }

    public function getFiche(): ?ficheEvaluation
    {
        return $this->fiche;
    }

    public function setFiche(?ficheEvaluation $fiche): self
    {
        $this->fiche = $fiche;

        return $this;
    }

    public function __toString()
    {
        return "Évaluation " . (string)$this->getId();
    }
}
