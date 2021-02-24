<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Soutenance::class, mappedBy="session")
     */
    private $soutenances;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;
    
    
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        
        return $this;
    }
    
    public function getNom(): ?string
    {
        return $this->nom;
    }
    
    public function __construct()
    {
        $this->soutenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $soutenance->setSession($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): self
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getSession() === $this) {
                $soutenance->setSession(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }
}
