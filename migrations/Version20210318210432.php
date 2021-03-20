<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318210432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA38B217A7');
        $this->addSql('DROP INDEX IDX_BF5476CA38B217A7 ON notification');
        $this->addSql('ALTER TABLE notification ADD vu INT NOT NULL, ADD lien VARCHAR(255) NOT NULL, DROP id_utilisateur, DROP type, CHANGE publication_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAFB88E14F ON notification (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAFB88E14F');
        $this->addSql('DROP INDEX IDX_BF5476CAFB88E14F ON notification');
        $this->addSql('ALTER TABLE notification ADD type INT NOT NULL, DROP lien, CHANGE utilisateur_id publication_id INT DEFAULT NULL, CHANGE vu id_utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA38B217A7 ON notification (publication_id)');
    }
}
