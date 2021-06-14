<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use App\Entity\User;
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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="text")
     */
    private $Contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Soutenance::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $soutenance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

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
}
