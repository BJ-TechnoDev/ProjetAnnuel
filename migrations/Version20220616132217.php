<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616132217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat CHANGE etat etat VARCHAR(255) NOT NULL, CHANGE ttc_sst ttc_sst VARCHAR(255) NOT NULL, CHANGE alternant alternant VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat CHANGE etat etat TINYINT(1) NOT NULL, CHANGE ttc_sst ttc_sst TINYINT(1) NOT NULL, CHANGE alternant alternant TINYINT(1) NOT NULL');
    }
}
