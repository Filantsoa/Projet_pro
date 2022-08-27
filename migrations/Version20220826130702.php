<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826130702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE displines (id INT AUTO_INCREMENT NOT NULL, eleves_id INT DEFAULT NULL, fait VARCHAR(100) NOT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, point VARCHAR(255) NOT NULL, INDEX IDX_77A3C36AC2140342 (eleves_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE displines ADD CONSTRAINT FK_77A3C36AC2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE displines DROP FOREIGN KEY FK_77A3C36AC2140342');
        $this->addSql('DROP TABLE displines');
    }
}
