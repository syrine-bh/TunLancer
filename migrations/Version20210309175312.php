<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309175312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, domaine VARCHAR(255) NOT NULL, INDEX IDX_94D4687F3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, poste VARCHAR(255) NOT NULL, societe VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_590C1033256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, periode DATE NOT NULL, INDEX IDX_404021BF3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F3256915B FOREIGN KEY (relation_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C1033256915B FOREIGN KEY (relation_id) REFERENCES users (id)');


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE formation');
    }
}
