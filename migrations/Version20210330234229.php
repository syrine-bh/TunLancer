<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330234229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, lieux VARCHAR(255) NOT NULL, renumeration VARCHAR(255) NOT NULL, INDEX IDX_F65593E5BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_dislike (id INT AUTO_INCREMENT NOT NULL, reply_id INT DEFAULT NULL, user VARCHAR(255) DEFAULT NULL, INDEX IDX_C3D35B998A0E4E7F (reply_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like (id INT AUTO_INCREMENT NOT NULL, reply_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_653627B88A0E4E7F (reply_id), INDEX IDX_653627B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postuler (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, cv VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, message VARCHAR(255) NOT NULL, INDEX IDX_8EC5A68D8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, date DATETIME NOT NULL, likes INT DEFAULT NULL, dislikes INT DEFAULT NULL, views INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_91F64639A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topics_utilisateurs (topics_id INT NOT NULL, utilisateurs_id INT NOT NULL, INDEX IDX_38DE8D8BF06A414 (topics_id), INDEX IDX_38DE8D81E969C5 (utilisateurs_id), PRIMARY KEY(topics_id, utilisateurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel INT DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, bibliography VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE post_dislike ADD CONSTRAINT FK_C3D35B998A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B88A0E4E7F FOREIGN KEY (reply_id) REFERENCES replies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68D8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE topics_utilisateurs ADD CONSTRAINT FK_38DE8D8BF06A414 FOREIGN KEY (topics_id) REFERENCES topics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topics_utilisateurs ADD CONSTRAINT FK_38DE8D81E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE replies ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672A1F55203D FOREIGN KEY (topic_id) REFERENCES topics (id)');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_A000672A1F55203D ON replies (topic_id)');
        $this->addSql('CREATE INDEX IDX_A000672AA76ED395 ON replies (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68D8805AB2F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672A1F55203D');
        $this->addSql('ALTER TABLE topics_utilisateurs DROP FOREIGN KEY FK_38DE8D8BF06A414');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B8A76ED395');
        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672AA76ED395');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639A76ED395');
        $this->addSql('ALTER TABLE topics_utilisateurs DROP FOREIGN KEY FK_38DE8D81E969C5');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE post_dislike');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE postuler');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE topics');
        $this->addSql('DROP TABLE topics_utilisateurs');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP INDEX IDX_A000672A1F55203D ON replies');
        $this->addSql('DROP INDEX IDX_A000672AA76ED395 ON replies');
        $this->addSql('ALTER TABLE replies DROP user_id');
    }
}
