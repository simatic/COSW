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
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity=Soutenance::class, mappedBy="session")
     */
    private $soutenances;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="sessions")
     */
    private $users;

    /**
     * @ORM\Column(type="text")
     */
    private $listeEtudiant;

    /**
     * @ORM\Column(type="text")
     */
    private $listeJury;

    /**
     * @ORM\Column(type="text")
     */
    private $texteMailEtudiant;

    /**
     * @ORM\Column(type="text")
     */
    private $texteMailJury;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uid;
    
    
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
        $this->users = new ArrayCollection();
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


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getListeEtudiant(): ?string
    {
        return $this->listeEtudiant;
    }

    public function setListeEtudiant(?string $listeEtudiant): self
    {
        $this->listeEtudiant = $listeEtudiant;

        return $this;
    }

    public function getListeJury(): ?string
    {
        return $this->listeJury;
    }

    public function setListeJury(?string $listeJury): self
    {
        $this->listeJury = $listeJury;

        return $this;
    }

    public function getTexteMailEtudiant(): ?string
    {
        return $this->texteMailEtudiant;
    }

    public function setTexteMailEtudiant(?string $texteMailEtudiant): self
    {
        $this->texteMailEtudiant = $texteMailEtudiant;

        return $this;
    }

    public function getTexteMailJury(): ?string
    {
        return $this->texteMailJury;
    }

    public function setTexteMailJury(?string $texteMailJury): self
    {
        $this->texteMailJury = $texteMailJury;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(?string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }
}
