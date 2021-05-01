<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, EncoderAwareInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $role = [];

    /**
     * @ORM\OneToMany(targetEntity=FicheEvaluation::class, mappedBy="evaluateur")
     */
    private $ficheEvaluations;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="User")
     */
    private $evaluations;

    public function __construct()
    {
        $this->ficheEvaluations = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->role;
    }

    public function setRoles(array $role): self
    {
        $this->role = $role;

        return $this;
    }
    
    public function getSalt(): ?string{
        return $this->getPassword();
    }
    
    public function eraseCredentials(){
        return ;
    }
    public function getEncoderName()
    {
        return 'harsh';
    }

    /**
     * @return Collection|FicheEvaluation[]
     */
    public function getFicheEvaluations(): Collection
    {
        return $this->ficheEvaluations;
    }

    public function addFicheEvaluation(FicheEvaluation $ficheEvaluation): self
    {
        if (!$this->ficheEvaluations->contains($ficheEvaluation)) {
            $this->ficheEvaluations[] = $ficheEvaluation;
            $ficheEvaluation->setEvaluateur($this);
        }

        return $this;
    }

    public function removeFicheEvaluation(FicheEvaluation $ficheEvaluation): self
    {
        if ($this->ficheEvaluations->removeElement($ficheEvaluation)) {
            // set the owning side to null (unless already changed)
            if ($ficheEvaluation->getEvaluateur() === $this) {
                $ficheEvaluation->setEvaluateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setUser($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getUser() === $this) {
                $evaluation->setUser(null);
            }
        }

        return $this;
    }

}
