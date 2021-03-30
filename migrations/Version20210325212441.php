<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325212441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topics ADD favoris_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F6463951E8871B FOREIGN KEY (favoris_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_91F6463951E8871B ON topics (favoris_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F6463951E8871B');
        $this->addSql('DROP INDEX IDX_91F6463951E8871B ON topics');
        $this->addSql('ALTER TABLE topics DROP favoris_id');
    }
}
