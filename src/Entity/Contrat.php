<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContratRepository::class)
 */
class Contrat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDemande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marqueOuEcole;

    /**
     * @ORM\Column(type="boolean")
     */
    private $civilite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeSociete;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statusContrat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeMission;

    /**
     * @ORM\Column(type="integer")
     */
    private $tarif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $horaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ttcSst;

    /**
     * @ORM\Column(type="integer")
     */
    private $volumeHoraire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matiere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $promotion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $alternant;

    /**
     * @ORM\Column(type="integer")
     */
    private $periode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeRecrutement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DiplomeLePlusEleve;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaineCompetence1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaineCompetence2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaineCompetence3;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveauExpertisePedagogique;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveauExpertisePro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): self
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getMarqueOuEcole(): ?string
    {
        return $this->marqueOuEcole;
    }

    public function setMarqueOuEcole(string $marqueOuEcole): self
    {
        $this->marqueOuEcole = $marqueOuEcole;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

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

    public function getTypeSociete(): ?string
    {
        return $this->typeSociete;
    }

    public function setTypeSociete(string $typeSociete): self
    {
        $this->typeSociete = $typeSociete;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getStatusContrat(): ?string
    {
        return $this->statusContrat;
    }

    public function setStatusContrat(string $statusContrat): self
    {
        $this->statusContrat = $statusContrat;

        return $this;
    }

    public function getTypeMission(): ?string
    {
        return $this->typeMission;
    }

    public function setTypeMission(string $typeMission): self
    {
        $this->typeMission = $typeMission;

        return $this;
    }

    public function getTarif(): ?int
    {
        return $this->tarif;
    }

    public function setTarif(int $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function isTtcSst(): ?bool
    {
        return $this->ttcSst;
    }

    public function setTtcSst(bool $ttcSst): self
    {
        $this->ttcSst = $ttcSst;

        return $this;
    }

    public function getVolumeHoraire(): ?int
    {
        return $this->volumeHoraire;
    }

    public function setVolumeHoraire(int $volumeHoraire): self
    {
        $this->volumeHoraire = $volumeHoraire;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(string $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function isAlternant(): ?bool
    {
        return $this->alternant;
    }

    public function setAlternant(bool $alternant): self
    {
        $this->alternant = $alternant;

        return $this;
    }

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(int $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getRp(): ?string
    {
        return $this->rp;
    }

    public function setRp(string $rp): self
    {
        $this->rp = $rp;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTypeRecrutement(): ?string
    {
        return $this->typeRecrutement;
    }

    public function setTypeRecrutement(string $typeRecrutement): self
    {
        $this->typeRecrutement = $typeRecrutement;

        return $this;
    }

    public function getDiplomeLePlusEleve(): ?string
    {
        return $this->DiplomeLePlusEleve;
    }

    public function setDiplomeLePlusEleve(string $DiplomeLePlusEleve): self
    {
        $this->DiplomeLePlusEleve = $DiplomeLePlusEleve;

        return $this;
    }

    public function getDomaineCompetence1(): ?string
    {
        return $this->domaineCompetence1;
    }

    public function setDomaineCompetence1(string $domaineCompetence1): self
    {
        $this->domaineCompetence1 = $domaineCompetence1;

        return $this;
    }

    public function getDomaineCompetence2(): ?string
    {
        return $this->domaineCompetence2;
    }

    public function setDomaineCompetence2(string $domaineCompetence2): self
    {
        $this->domaineCompetence2 = $domaineCompetence2;

        return $this;
    }

    public function getDomaineCompetence3(): ?string
    {
        return $this->domaineCompetence3;
    }

    public function setDomaineCompetence3(string $domaineCompetence3): self
    {
        $this->domaineCompetence3 = $domaineCompetence3;

        return $this;
    }

    public function getNiveauExpertisePedagogique(): ?int
    {
        return $this->niveauExpertisePedagogique;
    }

    public function setNiveauExpertisePedagogique(int $niveauExpertisePedagogique): self
    {
        $this->niveauExpertisePedagogique = $niveauExpertisePedagogique;

        return $this;
    }

    public function getNiveauExpertisePro(): ?int
    {
        return $this->niveauExpertisePro;
    }

    public function setNiveauExpertisePro(int $niveauExpertisePro): self
    {
        $this->niveauExpertisePro = $niveauExpertisePro;

        return $this;
    }
}
