<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301194348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD publication_id INT DEFAULT NULL, DROP idPublication');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC38B217A7 ON commentaire (publication_id)');
        $this->addSql('ALTER TABLE reaction ADD publication_id INT DEFAULT NULL, DROP idPublication');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F738B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_A4D707F738B217A7 ON reaction (publication_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('DROP INDEX IDX_67F068BC38B217A7 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD idPublication INT NOT NULL, DROP publication_id');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F738B217A7');
        $this->addSql('DROP INDEX IDX_A4D707F738B217A7 ON reaction');
        $this->addSql('ALTER TABLE reaction ADD idPublication INT NOT NULL, DROP publication_id');
    }
}
