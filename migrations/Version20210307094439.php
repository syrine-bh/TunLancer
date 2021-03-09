<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307094439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_concour ADD type_question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_concour ADD CONSTRAINT FK_701561EB553E212E FOREIGN KEY (type_question_id) REFERENCES type_question (id)');
        $this->addSql('CREATE INDEX IDX_701561EB553E212E ON question_concour (type_question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_concour DROP FOREIGN KEY FK_701561EB553E212E');
        $this->addSql('DROP INDEX IDX_701561EB553E212E ON question_concour');
        $this->addSql('ALTER TABLE question_concour DROP type_question_id');
    }
}
