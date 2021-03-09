<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308185323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication ADD id_u_id INT DEFAULT NULL, DROP id_u');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796F858F92 FOREIGN KEY (id_u_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_AF3C67796F858F92 ON publication (id_u_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796F858F92');
        $this->addSql('DROP INDEX IDX_AF3C67796F858F92 ON publication');
        $this->addSql('ALTER TABLE publication ADD id_u VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_u_id');
    }
}
