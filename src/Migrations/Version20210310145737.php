<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310145737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questiontab ADD concour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questiontab ADD CONSTRAINT FK_B857083B519DB84 FOREIGN KEY (concour_id) REFERENCES concour (id)');
        $this->addSql('CREATE INDEX IDX_B857083B519DB84 ON questiontab (concour_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questiontab DROP FOREIGN KEY FK_B857083B519DB84');
        $this->addSql('DROP INDEX IDX_B857083B519DB84 ON questiontab');
        $this->addSql('ALTER TABLE questiontab DROP concour_id');
    }
}
