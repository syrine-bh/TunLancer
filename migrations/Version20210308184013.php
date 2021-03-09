<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308184013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD id_utilisateur_id INT DEFAULT NULL, DROP idUtilisateur');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCC6EE5C49 ON commentaire (id_utilisateur_id)');
        $this->addSql('ALTER TABLE reaction ADD id_utilisateur_id INT DEFAULT NULL, DROP idUtilisateur');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_A4D707F7C6EE5C49 ON reaction (id_utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC6EE5C49');
        $this->addSql('DROP INDEX IDX_67F068BCC6EE5C49 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD idUtilisateur INT NOT NULL, DROP id_utilisateur_id');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7C6EE5C49');
        $this->addSql('DROP INDEX IDX_A4D707F7C6EE5C49 ON reaction');
        $this->addSql('ALTER TABLE reaction ADD idUtilisateur INT NOT NULL, DROP id_utilisateur_id');
    }
}
