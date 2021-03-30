<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310205613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B88A0E4E7F');
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B88A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B88A0E4E7F');
        $this->addSql('ALTER TABLE post_like CHANGE user user VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B88A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
