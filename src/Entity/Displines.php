<?php

namespace App\Entity;

use App\Repository\DisplinesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DisplinesRepository::class)
 */
class Displines
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fait;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $point;

    /**
     * @ORM\ManyToOne(targetEntity=Eleves::class, inversedBy="displines")
     */
    private $eleves;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFait(): ?string
    {
        return $this->fait;
    }

    public function setFait(string $fait): self
    {
        $this->fait = $fait;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPoint(): ?string
    {
        return $this->point;
    }

    public function setPoint(string $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getEleves(): ?Eleves
    {
        return $this->eleves;
    }

    public function setEleves(?Eleves $eleves): self
    {
        $this->eleves = $eleves;

        return $this;
    }
}
