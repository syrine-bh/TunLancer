<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310141642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signaler ADD id_utilisateur_id INT DEFAULT NULL, DROP idUtilisateur');
        $this->addSql('ALTER TABLE signaler ADD CONSTRAINT FK_EF69B32C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_EF69B32C6EE5C49 ON signaler (id_utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE signaler DROP FOREIGN KEY FK_EF69B32C6EE5C49');
        $this->addSql('DROP INDEX IDX_EF69B32C6EE5C49 ON signaler');
        $this->addSql('ALTER TABLE signaler ADD idUtilisateur INT NOT NULL, DROP id_utilisateur_id');
    }
}
