<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326210354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE replies ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_A000672AA76ED395 ON replies (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672AA76ED395');
        $this->addSql('DROP INDEX IDX_A000672AA76ED395 ON replies');
        $this->addSql('ALTER TABLE replies DROP user_id');
    }
}
