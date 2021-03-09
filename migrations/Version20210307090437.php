<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307090437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_concour (id INT AUTO_INCREMENT NOT NULL, type_question_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, INDEX IDX_701561EB553E212E (type_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_question (id INT AUTO_INCREMENT NOT NULL, is_multiple TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EB553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_concour DROP FOREIGN KEY FK_701561EB553E212E');
        $this->addSql('DROP TABLE question_concour');
        $this->addSql('DROP TABLE type_question');
    }
}
