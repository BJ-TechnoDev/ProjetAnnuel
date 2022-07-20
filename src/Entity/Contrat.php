<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContratRepository::class)
 */
class Contrat
{
    public function getExportData()
    {
        return \array_merge([
            'Date Demande' => $this->dateDemande->format('d.m.Y H:m'),
            'Marque / Ecole' => $this->marqueOuEcole,
            'Intervenant' => $this->intervenant,
            'Societe' => $this->typeSociete,
            'Commentaires' => $this->commentaire,
            'Statut Contrat' => $this->statusContrat,
            'Type de Mission' => $this->typeMission,
            'Tarif a appliquer' => $this->tarif,
            'Horaire ou Forfaite' => $this->horaire,
            'TTC/SST' => $this->ttcSst,
            'Volume Horaire' => $this->volumeHoraire,
            'Unite' => $this->unite,
            'Date Debut' => $this->dateDebut->format('d.m.Y H:m'),
            'Date Fin' => $this->dateFin->format('d.m.Y H:m'),
            'Matiere' => $this->matiere,
            'Promotion' => $this->promotion,
            'Alternant/Initial' => $this->alternant,
            'Periode' => $this->periode,
            'RP' => $this->rp,
            'Type Recrutement' => $this->typeRecrutement,
            'Diplome le plus eleve' => $this->DiplomeLePlusEleve,
            'Domaine de Compétence Principal' => $this->domaineCompetence1,
            'Domaine de Compétence 2' => $this->domaineCompetence2,
            'Domaine de Compétence 3' => $this->domaineCompetence3,
            'Niveau d\'Expertise en Pédagogique' => $this->niveauExpertisePedagogique,
            'Niveau d\'Expertise Matière Professionnelle' =>$this->niveauExpertisePro,
            'Etat (Valeur actuelle)' =>$this->etat,
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
     * @ORM\Column(type="string", length=255)
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
    private $promotion;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="string", length=255)
     */
    private $niveauExpertisePedagogique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveauExpertisePro;

    /**
     * @ORM\ManyToOne(targetEntity=Intervenant::class, inversedBy="contrats")
     */
    private $intervenant;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="contrats")
     */
    private $matiere;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
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

    public function getTtcSst(): ?string
    {
        return $this->ttcSst;
    }

    public function setTtcSst(string $ttcSst): self
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

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(string $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getAlternant(): ?string
    {
        return $this->alternant;
    }

    public function setAlternant(string $alternant): self
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

    public function getNiveauExpertisePedagogique(): ?string
    {
        return $this->niveauExpertisePedagogique;
    }

    public function setNiveauExpertisePedagogique(string $niveauExpertisePedagogique): self
    {
        $this->niveauExpertisePedagogique = $niveauExpertisePedagogique;

        return $this;
    }

    public function getNiveauExpertisePro(): ?string
    {
        return $this->niveauExpertisePro;
    }

    public function setNiveauExpertisePro(string $niveauExpertisePro): self
    {
        $this->niveauExpertisePro = $niveauExpertisePro;

        return $this;
    }

    public function getIntervenant(): ?Intervenant
    {
        return $this->intervenant;
    }

    public function setIntervenant(?Intervenant $intervenant): self
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

}
