<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307095657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_question (id INT AUTO_INCREMENT NOT NULL, question_concour_id INT DEFAULT NULL, type_question_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_968038EAD2CD440C (question_concour_id), INDEX IDX_968038EA553E212E (type_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_question (id INT AUTO_INCREMENT NOT NULL, question_concour_id INT DEFAULT NULL, user_id INT DEFAULT NULL, option_question_id INT DEFAULT NULL, INDEX IDX_E97BC639D2CD440C (question_concour_id), INDEX IDX_E97BC639A76ED395 (user_id), INDEX IDX_E97BC6393813AF0B (option_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EAD2CD440C FOREIGN KEY (question_concour_id) REFERENCES question_concour (id)');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EA553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC639D2CD440C FOREIGN KEY (question_concour_id) REFERENCES question_concour (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC639A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC6393813AF0B FOREIGN KEY (option_question_id) REFERENCES option_question (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC6393813AF0B');
        $this->addSql('DROP TABLE option_question');
        $this->addSql('DROP TABLE reponse_question');
    }
}
