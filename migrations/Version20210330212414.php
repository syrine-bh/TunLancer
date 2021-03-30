<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330212414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation ADD video_id INT DEFAULT NULL, ADD note INT DEFAULT NULL, ADD user_agent VARCHAR(255) DEFAULT NULL, ADD addr_ip VARCHAR(255) DEFAULT NULL, ADD date_participation DATETIME DEFAULT NULL, DROP video, DROP dateParticipation');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_AB55E24F29C1004E ON participation (video_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F29C1004E');
        $this->addSql('DROP INDEX IDX_AB55E24F29C1004E ON participation');
        $this->addSql('ALTER TABLE participation ADD video VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'0\' NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD dateParticipation DATETIME NOT NULL, DROP video_id, DROP note, DROP user_agent, DROP addr_ip, DROP date_participation');
    }
}
