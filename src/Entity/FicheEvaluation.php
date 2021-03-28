<?php

namespace App\Entity;

use App\Repository\FicheEvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FicheEvaluationRepository::class)
 */
class FicheEvaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Rubrique::class, mappedBy="ficheEvaluation")
     */
    private $rubriques;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ficheEvaluations")
     */
    private $evaluateur;

    /**
     * @ORM\ManyToOne(targetEntity=Soutenance::class, inversedBy="ficheEvaluations")
     */
    private $soutenance;

    /**
     * @ORM\Column(type="float")
     */
    private $noteFinal;

    /**
     * @ORM\Column(type="float")
     */
    private $ponderation;

    /**
     * @ORM\OneToMany(targetEntity=Soutenance::class, mappedBy="ficheEvaluation")
     */
    private $soutenances;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    public function __construct()
    {
        $this->rubriques = new ArrayCollection();
        $this->soutenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|rubrique[]
     */
    public function getRubriques(): Collection
    {
        return $this->rubriques;
    }

    public function addRubrique(rubrique $rubrique): self
    {
        if (!$this->rubriques->contains($rubrique)) {
            $this->rubriques[] = $rubrique;
            $rubrique->setFicheEvaluation($this);
        }

        return $this;
    }

    public function removeRubrique(rubrique $rubrique): self
    {
        if ($this->rubriques->removeElement($rubrique)) {
            // set the owning side to null (unless already changed)
            if ($rubrique->getFicheEvaluation() === $this) {
                $rubrique->setFicheEvaluation(null);
            }
        }

        return $this;
    }

    public function getEvaluateur(): ?user
    {
        return $this->evaluateur;
    }

    public function setEvaluateur(?user $evaluateur): self
    {
        $this->evaluateur = $evaluateur;

        return $this;
    }

    public function getSoutenance(): ?Soutenance
    {
        return $this->soutenance;
    }

    public function setSoutenance(?Soutenance $soutenance): self
    {
        $this->soutenance = $soutenance;

        return $this;
    }

    public function getNoteFinal(): ?float
    {
        return $this->noteFinal;
    }

    public function setNoteFinal(float $noteFinal): self
    {
        $this->noteFinal = $noteFinal;

        return $this;
    }

    public function getPonderation(): ?float
    {
        return $this->ponderation;
    }

    public function setPonderation(float $ponderation): self
    {
        $this->ponderation = $ponderation;

        return $this;
    }

    /**
     * @return Collection|Soutenance[]
     */
    public function getSoutenances(): Collection
    {
        return $this->soutenances;
    }

    public function addSoutenance(Soutenance $soutenance): self
    {
        if (!$this->soutenances->contains($soutenance)) {
            $this->soutenances[] = $soutenance;
            $soutenance->setFicheEvaluation($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): self
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getFicheEvaluation() === $this) {
                $soutenance->setFicheEvaluation(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    
    public function __toString() {
        return $this->nom;
    }
}
