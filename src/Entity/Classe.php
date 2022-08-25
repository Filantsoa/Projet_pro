<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 * @UniqueEntity(fields={"nomClasse"}, message="Votre Classe existe déjà !")
 * @UniqueEntity(fields={"profTitulaire"}, message="Votre Prof Titulaire existe déjà !")
 */
class Classe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $nomClasse;

    /**
     * @ORM\OneToOne(targetEntity=ProfTitulaire::class, inversedBy="classe", cascade={"persist", "remove"})
     * @Assert\NotBlank()
     */
    private $profTitulaire;

    /**
     * @ORM\OneToMany(targetEntity=Eleves::class, mappedBy="classe")
     */
    private $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNomClasse();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nomClasse;
    }

    public function setNomClasse(string $nomClasse): self
    {
        $this->nomClasse = $nomClasse;

        return $this;
    }

    public function getProfTitulaire(): ?ProfTitulaire
    {
        return $this->profTitulaire;
    }

    public function setProfTitulaire(?ProfTitulaire $profTitulaire): self
    {
        $this->profTitulaire = $profTitulaire;

        return $this;
    }

    /**
     * @return Collection<int, Eleves>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleves $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves[] = $elefe;
            $elefe->setClasse($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasse() === $this) {
                $elefe->setClasse(null);
            }
        }

        return $this;
    }
}
