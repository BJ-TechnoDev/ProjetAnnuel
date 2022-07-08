<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
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
     * @ORM\Column(type="string", length=255)
     */
    private $semestre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $volume_heure;


    /**
     * @ORM\ManyToOne(targetEntity=Contrat::class, inversedBy="matiere")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contrat;


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


    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }
}
