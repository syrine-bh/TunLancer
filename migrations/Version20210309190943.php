<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309190943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_signal (id INT AUTO_INCREMENT NOT NULL, receiver_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, reason INT DEFAULT NULL, date DATETIME DEFAULT NULL, state TINYINT(1) DEFAULT NULL, content TEXT DEFAULT NULL, INDEX sender_id (sender_id), INDEX receiver_id (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_signal ADD CONSTRAINT FK_115E8EC8CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_signal ADD CONSTRAINT FK_115E8EC8F624B39D FOREIGN KEY (sender_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD is_enabled TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_signal');
        $this->addSql('ALTER TABLE users DROP is_enabled');
    }
}
