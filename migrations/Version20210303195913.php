<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303195913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_concour DROP FOREIGN KEY FK_701561EB3BF28ECB');
        $this->addSql('ALTER TABLE question_concour DROP FOREIGN KEY FK_701561EB553E212E');
        $this->addSql('DROP TABLE question_concour');
        $this->addSql('DROP TABLE type_question');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_concour (id INT AUTO_INCREMENT NOT NULL, concour_id INT NOT NULL, type_question_id INT NOT NULL, type_questions_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_701561EB553E212E (type_question_id), INDEX IDX_701561EBB519DB84 (concour_id), INDEX IDX_701561EB3BF28ECB (type_questions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_question (id INT AUTO_INCREMENT NOT NULL, is_multiple TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EB3BF28ECB FOREIGN KEY (type_questions_id) REFERENCES type_question (id)');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EB553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EBB519DB84 FOREIGN KEY (concour_id) REFERENCES concour (id)');
    }
}
