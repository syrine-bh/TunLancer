<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303205046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_question (id INT AUTO_INCREMENT NOT NULL, question_concour_id INT NOT NULL, type_question_id INT NOT NULL, nom VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_968038EAD2CD440C (question_concour_id), INDEX IDX_968038EA553E212E (type_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EAD2CD440C FOREIGN KEY (question_concour_id) REFERENCES question_concour (id)');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EA553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE option_question');
    }
}
