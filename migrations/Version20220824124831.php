<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824124831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleves (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, matricule INT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(150) NOT NULL, date_naissance DATE NOT NULL, adresse VARCHAR(100) NOT NULL, telephone INT NOT NULL, mere VARCHAR(100) NOT NULL, pere VARCHAR(100) NOT NULL, tuteur VARCHAR(100) NOT NULL, sexe VARCHAR(100) NOT NULL, religion VARCHAR(150) NOT NULL, INDEX IDX_383B09B18F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B18F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B18F5EA509');
        $this->addSql('DROP TABLE eleves');
    }
}
