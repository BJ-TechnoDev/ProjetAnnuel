<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
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
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Maquette::class, mappedBy="classe")
     */
    private $maquettes;

    public function __construct()
    {
        $this->maquettes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNom();
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

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Maquette>
     */
    public function getMaquettes(): Collection
    {
        return $this->maquettes;
    }

    public function addMaquette(Maquette $maquette): self
    {
        if (!$this->maquettes->contains($maquette)) {
            $this->maquettes[] = $maquette;
            $maquette->addClasse($this);
        }

        return $this;
    }

    public function removeMaquette(Maquette $maquette): self
    {
        if ($this->maquettes->removeElement($maquette)) {
            $maquette->removeClasse($this);
        }

        return $this;
    }
}
