<?php

namespace App\Entity;

use App\Repository\IntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\IntervenantRepository", repositoryClass=IntervenantRepository::class)
 */
class Intervenant

{
    public function getExportDataIntervenant()
    {
        return \array_merge([
            'Nom de famille ' => $this->Nom,
            'Prenom' => $this->Prenom,
            'Adresse e-mail' => $this->Email,
            'Numéro de Téléphone' => $this->Telephone,
            'Adresse postale' => $this->Adresse,
            'Entrez le role' => $this->Roles,
            'Societe' => $this->societe,
            'Numero de contact' => $this->numero_contact,
            'Mail de contact' => $this->mail_contact,
            'Type de societe' => $this->type_societe,
            'Volume horaire total' => $this->volume_horaire,
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Roles;

    /**
     * @ORM\OneToMany(targetEntity=Contrat::class, mappedBy="intervenant")
     */
    private $contrats;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $societe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero_contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail_contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_societe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $volume_horaire;

    public function __toString(): string
    {
        return $this->getNom() . ' ' . $this->getPrenom();
    }

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }


    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->Roles;
    }

    public function setRoles(string $Roles): self
    {
        $this->Roles = $Roles;

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
            $contrat->setIntervenant($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getIntervenant() === $this) {
                $contrat->setIntervenant(null);
            }
        }

        return $this;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(?string $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getNumeroContact(): ?string
    {
        return $this->numero_contact;
    }

    public function setNumeroContact(string $numero_contact): self
    {
        $this->numero_contact = $numero_contact;

        return $this;
    }

    public function getMailContact(): ?string
    {
        return $this->mail_contact;
    }

    public function setMailContact(string $mail_contact): self
    {
        $this->mail_contact = $mail_contact;

        return $this;
    }

    public function getTypeSociete(): ?string
    {
        return $this->type_societe;
    }

    public function setTypeSociete(string $type_societe): self
    {
        $this->type_societe = $type_societe;

        return $this;
    }

    public function getVolumeHoraire(): ?int
    {
        return $this->volume_horaire;
    }

    public function setVolumeHoraire(int $volume_horaire): self
    {
        $this->volume_horaire = $volume_horaire;

        return $this;
    }
}
