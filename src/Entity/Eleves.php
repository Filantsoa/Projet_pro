<?php

namespace App\Entity;

use App\Repository\ElevesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ElevesRepository::class)
 * @UniqueEntity(fields={"matricule"}, message="Votre matricule existe déjà !")
 */
class Eleves
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mere;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $pere;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $tuteur;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $sexe;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="eleves")
     */
    private $classe;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $religion;

    /**
     * @ORM\OneToMany(targetEntity=Displines::class, mappedBy="eleves")
     */
    private $displines;

    public function __construct()
    {
        $this->displines = new ArrayCollection();
    }
    public function __toString()
    {
        
        return  $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): self
    {
        $this->matricule = $matricule;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMere(): ?string
    {
        return $this->mere;
    }

    public function setMere(string $mere): self
    {
        $this->mere = $mere;

        return $this;
    }

    public function getPere(): ?string
    {
        return $this->pere;
    }

    public function setPere(string $pere): self
    {
        $this->pere = $pere;

        return $this;
    }

    public function getTuteur(): ?string
    {
        return $this->tuteur;
    }

    public function setTuteur(string $tuteur): self
    {
        $this->tuteur = $tuteur;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getReligion(): ?string
    {
        return $this->religion;
    }

    public function setReligion(string $religion): self
    {
        $this->religion = $religion;

        return $this;
    }

    /**
     * @return Collection<int, Displines>
     */
    public function getDisplines(): Collection
    {
        return $this->displines;
    }

    public function addDispline(Displines $displine): self
    {
        if (!$this->displines->contains($displine)) {
            $this->displines[] = $displine;
            $displine->setEleves($this);
        }

        return $this;
    }

    public function removeDispline(Displines $displine): self
    {
        if ($this->displines->removeElement($displine)) {
            // set the owning side to null (unless already changed)
            if ($displine->getEleves() === $this) {
                $displine->setEleves(null);
            }
        }

        return $this;
    }
}
