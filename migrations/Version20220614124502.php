<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614124502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, etat TINYINT(1) NOT NULL, date_demande DATETIME NOT NULL, marque_ou_ecole VARCHAR(255) NOT NULL, civilite VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, type_societe VARCHAR(255) NOT NULL, commentaire VARCHAR(255) NOT NULL, status_contrat VARCHAR(255) NOT NULL, type_mission VARCHAR(255) NOT NULL, tarif INT NOT NULL, horaire VARCHAR(255) NOT NULL, ttc_sst TINYINT(1) NOT NULL, volume_horaire INT NOT NULL, unite VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, matiere VARCHAR(255) NOT NULL, promotion VARCHAR(255) NOT NULL, alternant TINYINT(1) NOT NULL, periode INT NOT NULL, rp VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, type_recrutement VARCHAR(255) NOT NULL, diplome_le_plus_eleve VARCHAR(255) NOT NULL, domaine_competence1 VARCHAR(255) NOT NULL, domaine_competence2 VARCHAR(255) NOT NULL, domaine_competence3 VARCHAR(255) NOT NULL, niveau_expertise_pedagogique INT NOT NULL, niveau_expertise_pro INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intervenant CHANGE telephone telephone VARCHAR(255) NOT NULL, CHANGE prénom prenom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contrat');
        $this->addSql('ALTER TABLE intervenant CHANGE telephone telephone INT NOT NULL, CHANGE prenom prénom VARCHAR(255) NOT NULL');
    }
}
