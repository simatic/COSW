<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


class Evaluate extends \App\Entity\FicheEvaluation
{

    private ?int $id;
    /**
     * @ORM\OneToMany(targetEntity=Rubrique::class, mappedBy="ficheEvaluation")
     */
    private ?ArrayCollection $rubriques = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Rubrique[]
     */
    public function getRubriques(): Collection
    {
        return $this->rubriques;
    }

    public function addRubrique(Rubrique $rubrique): self
    {
        if (!$this->rubriques->contains($rubrique)) {
            $this->rubriques[] = $rubrique;
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        if ($this->rubriques->removeElement($rubrique)) {
            // set the owning side to null (unless already changed)
            if ($rubrique->getFicheEvaluation() === $this) {
                $rubrique->setFicheEvaluation(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return "Evaluate " . (string)$this->getId();
    }
}
