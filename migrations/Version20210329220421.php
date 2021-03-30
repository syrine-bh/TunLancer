<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329220421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id_commentaire INT AUTO_INCREMENT NOT NULL, publication_id INT DEFAULT NULL, id_utilisateur_id INT DEFAULT NULL, contenuCommentaire VARCHAR(255) NOT NULL, INDEX IDX_67F068BC38B217A7 (publication_id), INDEX IDX_67F068BCC6EE5C49 (id_utilisateur_id), PRIMARY KEY(id_commentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, vu INT NOT NULL, description VARCHAR(255) NOT NULL, lien VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_BF5476CAFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, id_u_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, type INT NOT NULL, archive INT NOT NULL, image_name VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, INDEX IDX_AF3C67796F858F92 (id_u_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (id_reaction INT AUTO_INCREMENT NOT NULL, publication_id INT DEFAULT NULL, id_utilisateur_id INT DEFAULT NULL, typeReaction INT NOT NULL, INDEX IDX_A4D707F738B217A7 (publication_id), INDEX IDX_A4D707F7C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id_reaction)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signaler (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT DEFAULT NULL, publication_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_EF69B32C6EE5C49 (id_utilisateur_id), INDEX IDX_EF69B3238B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, bibliography VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vues (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, publication_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, pays_code VARCHAR(255) NOT NULL, date DATETIME NOT NULL, operateur VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, INDEX IDX_ECAC3583FB88E14F (utilisateur_id), INDEX IDX_ECAC358338B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796F858F92 FOREIGN KEY (id_u_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F738B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE signaler ADD CONSTRAINT FK_EF69B32C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE signaler ADD CONSTRAINT FK_EF69B3238B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE vues ADD CONSTRAINT FK_ECAC3583FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE vues ADD CONSTRAINT FK_ECAC358338B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F738B217A7');
        $this->addSql('ALTER TABLE signaler DROP FOREIGN KEY FK_EF69B3238B217A7');
        $this->addSql('ALTER TABLE vues DROP FOREIGN KEY FK_ECAC358338B217A7');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC6EE5C49');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAFB88E14F');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796F858F92');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7C6EE5C49');
        $this->addSql('ALTER TABLE signaler DROP FOREIGN KEY FK_EF69B32C6EE5C49');
        $this->addSql('ALTER TABLE vues DROP FOREIGN KEY FK_ECAC3583FB88E14F');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE signaler');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vues');
    }
}
