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
    public function getExportDataMatiere()
    {
        return \array_merge([
            'Matière' => $this->nom,
            'semestre' => $this->semestre,
            'volume horaire' => $this->volume_heure,
        ]);
    }

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
     * @ORM\Column(type="string", length=255)
     */
    private $semestre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $volume_heure;

    /**
     * @ORM\OneToMany(targetEntity=Contrat::class, mappedBy="matiere")
     */
    private $contrats;

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
    }


    public function __toString(): string
    {
        return $this->getNom();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getSemestre(): ?string
    {
        return $this->semestre;
    }

    public function setSemestre(string $semestre): self
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getVolumeHeure(): ?string
    {
        return $this->volume_heure;
    }

    public function setVolumeHeure(string $volume_heure): self
    {
        $this->volume_heure = $volume_heure;

        return $this;
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


}
