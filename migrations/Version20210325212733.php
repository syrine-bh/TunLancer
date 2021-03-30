<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325212733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE topics_utilisateurs (topics_id INT NOT NULL, utilisateurs_id INT NOT NULL, INDEX IDX_38DE8D8BF06A414 (topics_id), INDEX IDX_38DE8D81E969C5 (utilisateurs_id), PRIMARY KEY(topics_id, utilisateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE topics_utilisateurs ADD CONSTRAINT FK_38DE8D8BF06A414 FOREIGN KEY (topics_id) REFERENCES topics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topics_utilisateurs ADD CONSTRAINT FK_38DE8D81E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F6463951E8871B');
        $this->addSql('DROP INDEX IDX_91F6463951E8871B ON topics');
        $this->addSql('ALTER TABLE topics DROP favoris_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE topics_utilisateurs');
        $this->addSql('ALTER TABLE topics ADD favoris_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F6463951E8871B FOREIGN KEY (favoris_id) REFERENCES utilisateurs (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_91F6463951E8871B ON topics (favoris_id)');
    }
}
