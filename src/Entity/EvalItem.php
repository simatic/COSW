<?php

namespace App\Entity;

use App\Repository\EvalItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvalItemRepository::class)
 */
class EvalItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $relation;

    /**
     * @ORM\ManyToOne(targetEntity=Soutenance::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Soutenance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $User;

    /**
     * @ORM\OneToOne(targetEntity=Item::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getSoutenance(): ?Soutenance
    {
        return $this->Soutenance;
    }

    public function setSoutenance(?Soutenance $Soutenance): self
    {
        $this->Soutenance = $Soutenance;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->Item;
    }

    public function setItem(Item $Item): self
    {
        $this->Item = $Item;

        return $this;
    }
}
