<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331012735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, domaine VARCHAR(255) NOT NULL, INDEX IDX_94D4687F3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, poste VARCHAR(255) NOT NULL, societe VARCHAR(255) NOT NULL, periode DATE DEFAULT NULL, INDEX IDX_590C1033256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiences (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, poste VARCHAR(255) NOT NULL, societe VARCHAR(255) NOT NULL, datedeb DATE NOT NULL, date_fin DATE NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_82020E703256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, periode DATE NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_404021BF3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, userid_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, priorite VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_527EDB2558E0A285 (userid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F3256915B FOREIGN KEY (relation_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C1033256915B FOREIGN KEY (relation_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE experiences ADD CONSTRAINT FK_82020E703256915B FOREIGN KEY (relation_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF3256915B FOREIGN KEY (relation_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2558E0A285 FOREIGN KEY (userid_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD age INT NOT NULL, ADD sexe VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE experiences');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE task');
        $this->addSql('ALTER TABLE users DROP age, DROP sexe');
    }
}
