<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304213525 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE replies ADD topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672A1F55203D FOREIGN KEY (topic_id) REFERENCES topics (id)');
        $this->addSql('CREATE INDEX IDX_A000672A1F55203D ON replies (topic_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672A1F55203D');
        $this->addSql('DROP INDEX IDX_A000672A1F55203D ON replies');
        $this->addSql('ALTER TABLE replies DROP topic_id');
    }
}
