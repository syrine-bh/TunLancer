<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309125658 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC6393813AF0B');
        $this->addSql('ALTER TABLE option_question DROP FOREIGN KEY FK_968038EAD2CD440C');
        $this->addSql('ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC639D2CD440C');
        $this->addSql('ALTER TABLE option_question DROP FOREIGN KEY FK_968038EA553E212E');
        $this->addSql('ALTER TABLE question_concour DROP FOREIGN KEY FK_701561EB553E212E');
        $this->addSql('CREATE TABLE adminuser (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questiontab (id INT AUTO_INCREMENT NOT NULL, questions VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponsetab (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, reponses VARCHAR(255) NOT NULL, statu TINYINT(1) NOT NULL, INDEX IDX_DABA3DBE1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, score VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponsetab ADD CONSTRAINT FK_DABA3DBE1E27F6BF FOREIGN KEY (question_id) REFERENCES questiontab (id)');
        $this->addSql('DROP TABLE option_question');
        $this->addSql('DROP TABLE question_concour');
        $this->addSql('DROP TABLE reponse_question');
        $this->addSql('DROP TABLE type_question');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponsetab DROP FOREIGN KEY FK_DABA3DBE1E27F6BF');
        $this->addSql('CREATE TABLE option_question (id INT AUTO_INCREMENT NOT NULL, question_concour_id INT DEFAULT NULL, type_question_id INT DEFAULT NULL, text VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_968038EA553E212E (type_question_id), INDEX IDX_968038EAD2CD440C (question_concour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE question_concour (id INT AUTO_INCREMENT NOT NULL, type_question_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_701561EB553E212E (type_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reponse_question (id INT AUTO_INCREMENT NOT NULL, question_concour_id INT DEFAULT NULL, user_id INT DEFAULT NULL, option_question_id INT DEFAULT NULL, INDEX IDX_E97BC639A76ED395 (user_id), INDEX IDX_E97BC639D2CD440C (question_concour_id), INDEX IDX_E97BC6393813AF0B (option_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_question (id INT AUTO_INCREMENT NOT NULL, is_multiple TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EA553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EAD2CD440C FOREIGN KEY (question_concour_id) REFERENCES question_concour (id)');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EB553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC6393813AF0B FOREIGN KEY (option_question_id) REFERENCES option_question (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC639A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC639D2CD440C FOREIGN KEY (question_concour_id) REFERENCES question_concour (id)');
        $this->addSql('DROP TABLE adminuser');
        $this->addSql('DROP TABLE questiontab');
        $this->addSql('DROP TABLE reponsetab');
        $this->addSql('DROP TABLE score');
    }
}
