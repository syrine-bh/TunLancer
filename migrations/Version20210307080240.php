<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307080240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_question DROP FOREIGN KEY FK_968038EAD2CD440C');
        $this->addSql('ALTER TABLE option_question DROP FOREIGN KEY FK_968038EA553E212E');
        $this->addSql('ALTER TABLE question_concour DROP FOREIGN KEY FK_701561EB553E212E');
        $this->addSql('CREATE TABLE user_concour (user_id INT NOT NULL, concour_id INT NOT NULL, INDEX IDX_26C4AAFCA76ED395 (user_id), INDEX IDX_26C4AAFCB519DB84 (concour_id), PRIMARY KEY(user_id, concour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_concour ADD CONSTRAINT FK_26C4AAFCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concour ADD CONSTRAINT FK_26C4AAFCB519DB84 FOREIGN KEY (concour_id) REFERENCES concour (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE option_question');
        $this->addSql('DROP TABLE question_concour');
        $this->addSql('DROP TABLE type_question');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_question (id INT AUTO_INCREMENT NOT NULL, question_concour_id INT NOT NULL, type_question_id INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, text VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_968038EA553E212E (type_question_id), INDEX IDX_968038EAD2CD440C (question_concour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE question_concour (id INT AUTO_INCREMENT NOT NULL, concour_id INT NOT NULL, type_question_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_701561EB553E212E (type_question_id), INDEX IDX_701561EBB519DB84 (concour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_question (id INT AUTO_INCREMENT NOT NULL, is_multiple TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EA553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
        $this->addSql('ALTER TABLE option_question ADD CONSTRAINT FK_968038EAD2CD440C FOREIGN KEY (question_concour_id) REFERENCES question_concour (id)');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EB553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EBB519DB84 FOREIGN KEY (concour_id) REFERENCES concour (id)');
        $this->addSql('DROP TABLE user_concour');
    }
}
