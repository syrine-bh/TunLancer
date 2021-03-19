<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210319000828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score ADD quiz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_32993751853CD175 ON score (quiz_id)');
        $this->addSql('ALTER TABLE score RENAME INDEX fk_32993751a76ed395 TO IDX_32993751A76ED395');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751853CD175');
        $this->addSql('DROP INDEX IDX_32993751853CD175 ON score');
        $this->addSql('ALTER TABLE score DROP quiz_id');
        $this->addSql('ALTER TABLE score RENAME INDEX idx_32993751a76ed395 TO FK_32993751A76ED395');
    }
}
