<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210321201755 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ADD userid_id INT DEFAULT NULL, CHANGE priorit priorité VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2558E0A285 FOREIGN KEY (userid_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_527EDB2558E0A285 ON task (userid_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2558E0A285');
        $this->addSql('DROP INDEX IDX_527EDB2558E0A285 ON task');
        $this->addSql('ALTER TABLE task DROP userid_id, CHANGE priorité priorit VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
