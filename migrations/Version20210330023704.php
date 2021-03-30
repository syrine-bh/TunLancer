<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330023704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video ADD owner INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CCF60E67C FOREIGN KEY (owner) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CCF60E67C ON video (owner)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CCF60E67C');
        $this->addSql('DROP INDEX IDX_7CC7DA2CCF60E67C ON video');
        $this->addSql('ALTER TABLE video DROP owner');
    }
}
