<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
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
     * @ORM\OneToMany(targetEntity=Contrat::class, mappedBy="matiere")
     */
    private $contrats;

    /**
     * @ORM\ManyToMany(targetEntity=Maquette::class, mappedBy="matiere")
     */
    private $maquettes;

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
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
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->setMatiere($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getMatiere() === $this) {
                $contrat->setMatiere(null);
            }
        }

        return $this;
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
            $maquette->addMatiere($this);
        }

        return $this;
    }

    public function removeMaquette(Maquette $maquette): self
    {
        if ($this->maquettes->removeElement($maquette)) {
            $maquette->removeMatiere($this);
        }

        return $this;
    }
}
