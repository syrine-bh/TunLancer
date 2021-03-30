<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324215836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_dislike DROP FOREIGN KEY FK_C3D35B998A0E4E7F');
        $this->addSql('ALTER TABLE post_dislike ADD CONSTRAINT FK_C3D35B998A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_dislike DROP FOREIGN KEY FK_C3D35B998A0E4E7F');
        $this->addSql('ALTER TABLE post_dislike ADD CONSTRAINT FK_C3D35B998A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
