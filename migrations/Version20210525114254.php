<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525114254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', type VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, username VARCHAR(30) DEFAULT NULL, UNIQUE INDEX UNIQ_D5428AEDE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account_request (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT \'PENDING\' NOT NULL, UNIQUE INDEX UNIQ_F2BC9BD7E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, soutenance_id INT NOT NULL, auteur VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_67F068BCA59B3775 (soutenance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eval_item (id INT AUTO_INCREMENT NOT NULL, soutenance_id INT NOT NULL, user_id INT DEFAULT NULL, item_id INT NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_4C29623AA59B3775 (soutenance_id), INDEX IDX_4C29623AA76ED395 (user_id), UNIQUE INDEX UNIQ_4C29623A126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, soutenance_id INT DEFAULT NULL, user_id INT DEFAULT NULL, item_id INT NOT NULL, note DOUBLE PRECISION DEFAULT NULL, INDEX IDX_1323A575A59B3775 (soutenance_id), INDEX IDX_1323A575A76ED395 (user_id), INDEX IDX_1323A575126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_evaluation (id INT AUTO_INCREMENT NOT NULL, evaluateur_id INT DEFAULT NULL, soutenance_id INT DEFAULT NULL, note_final DOUBLE PRECISION NOT NULL, ponderation DOUBLE PRECISION NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_BD75A182231F139 (evaluateur_id), INDEX IDX_BD75A182A59B3775 (soutenance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, rubrique_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_1F1B251E3BD38833 (rubrique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele_rubrique (modele_id INT NOT NULL, rubrique_id INT NOT NULL, INDEX IDX_E77C377EAC14B70A (modele_id), INDEX IDX_E77C377E3BD38833 (rubrique_id), PRIMARY KEY(modele_id, rubrique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele_item (modele_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_D99C5139AC14B70A (modele_id), INDEX IDX_D99C5139126F525E (item_id), PRIMARY KEY(modele_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, commentaire LONGTEXT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_user (session_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4BE2D663613FECDF (session_id), INDEX IDX_4BE2D663A76ED395 (user_id), PRIMARY KEY(session_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE soutenance (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, modele_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, date_soutenance DATETIME NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_4D59FF6E613FECDF (session_id), INDEX IDX_4D59FF6EAC14B70A (modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE upload (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA59B3775 FOREIGN KEY (soutenance_id) REFERENCES soutenance (id)');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623AA59B3775 FOREIGN KEY (soutenance_id) REFERENCES soutenance (id)');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623AA76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623A126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A59B3775 FOREIGN KEY (soutenance_id) REFERENCES soutenance (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE fiche_evaluation ADD CONSTRAINT FK_BD75A182231F139 FOREIGN KEY (evaluateur_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE fiche_evaluation ADD CONSTRAINT FK_BD75A182A59B3775 FOREIGN KEY (soutenance_id) REFERENCES soutenance (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE modele_rubrique ADD CONSTRAINT FK_E77C377EAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_rubrique ADD CONSTRAINT FK_E77C377E3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_item ADD CONSTRAINT FK_D99C5139AC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_item ADD CONSTRAINT FK_D99C5139126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_user ADD CONSTRAINT FK_4BE2D663613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_user ADD CONSTRAINT FK_4BE2D663A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6E613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eval_item DROP FOREIGN KEY FK_4C29623AA76ED395');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A76ED395');
        $this->addSql('ALTER TABLE fiche_evaluation DROP FOREIGN KEY FK_BD75A182231F139');
        $this->addSql('ALTER TABLE session_user DROP FOREIGN KEY FK_4BE2D663A76ED395');
        $this->addSql('ALTER TABLE eval_item DROP FOREIGN KEY FK_4C29623A126F525E');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575126F525E');
        $this->addSql('ALTER TABLE modele_item DROP FOREIGN KEY FK_D99C5139126F525E');
        $this->addSql('ALTER TABLE modele_rubrique DROP FOREIGN KEY FK_E77C377EAC14B70A');
        $this->addSql('ALTER TABLE modele_item DROP FOREIGN KEY FK_D99C5139AC14B70A');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EAC14B70A');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E3BD38833');
        $this->addSql('ALTER TABLE modele_rubrique DROP FOREIGN KEY FK_E77C377E3BD38833');
        $this->addSql('ALTER TABLE session_user DROP FOREIGN KEY FK_4BE2D663613FECDF');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6E613FECDF');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA59B3775');
        $this->addSql('ALTER TABLE eval_item DROP FOREIGN KEY FK_4C29623AA59B3775');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A59B3775');
        $this->addSql('ALTER TABLE fiche_evaluation DROP FOREIGN KEY FK_BD75A182A59B3775');
        $this->addSql('DROP TABLE Users');
        $this->addSql('DROP TABLE account_request');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE eval_item');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE fiche_evaluation');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE modele');
        $this->addSql('DROP TABLE modele_rubrique');
        $this->addSql('DROP TABLE modele_item');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_user');
        $this->addSql('DROP TABLE soutenance');
        $this->addSql('DROP TABLE upload');
    }
}
