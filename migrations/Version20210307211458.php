<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307211458 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE replies CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE topics ADD likes INT DEFAULT NULL, ADD dislikes INT DEFAULT NULL, ADD views INT DEFAULT NULL, CHANGE id_topic id_topic INT NOT NULL, CHANGE date date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE replies CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE topics DROP likes, DROP dislikes, DROP views, CHANGE id_topic id_topic INT DEFAULT NULL, CHANGE date date DATETIME DEFAULT NULL');
    }
}
