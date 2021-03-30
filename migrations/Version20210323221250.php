<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323221250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_dislike (id INT AUTO_INCREMENT NOT NULL, reply_id INT DEFAULT NULL, user VARCHAR(255) DEFAULT NULL, INDEX IDX_C3D35B998A0E4E7F (reply_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_dislike ADD CONSTRAINT FK_C3D35B998A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id)');
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE post_dislike');
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
