<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425155326 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_1323A575DF522508');
        $this->addSql('CREATE TEMPORARY TABLE __temp__evaluation AS SELECT id, fiche_id, note_finale FROM evaluation');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('CREATE TABLE evaluation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fiche_id INTEGER NOT NULL, note_finale INTEGER DEFAULT NULL, CONSTRAINT FK_1323A575DF522508 FOREIGN KEY (fiche_id) REFERENCES fiche_evaluation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO evaluation (id, fiche_id, note_finale) SELECT id, fiche_id, note_finale FROM __temp__evaluation');
        $this->addSql('DROP TABLE __temp__evaluation');
        $this->addSql('CREATE INDEX IDX_1323A575DF522508 ON evaluation (fiche_id)');
        $this->addSql('DROP INDEX IDX_1F1B251E3BD38833');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, rubrique_id, title FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rubrique_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, note INTEGER DEFAULT NULL, CONSTRAINT FK_1F1B251E3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, rubrique_id, title) SELECT id, rubrique_id, title FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251E3BD38833 ON item (rubrique_id)');
        $this->addSql('DROP INDEX IDX_8FA4097C13830278');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rubrique AS SELECT id, fiche_evaluation_id, title FROM rubrique');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('CREATE TABLE rubrique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fiche_evaluation_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_8FA4097C13830278 FOREIGN KEY (fiche_evaluation_id) REFERENCES fiche_evaluation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rubrique (id, fiche_evaluation_id, title) SELECT id, fiche_evaluation_id, title FROM __temp__rubrique');
        $this->addSql('DROP TABLE __temp__rubrique');
        $this->addSql('CREATE INDEX IDX_8FA4097C13830278 ON rubrique (fiche_evaluation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_1323A575DF522508');
        $this->addSql('CREATE TEMPORARY TABLE __temp__evaluation AS SELECT id, fiche_id, note_finale FROM evaluation');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('CREATE TABLE evaluation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fiche_id INTEGER NOT NULL, note_finale INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO evaluation (id, fiche_id, note_finale) SELECT id, fiche_id, note_finale FROM __temp__evaluation');
        $this->addSql('DROP TABLE __temp__evaluation');
        $this->addSql('CREATE INDEX IDX_1323A575DF522508 ON evaluation (fiche_id)');
        $this->addSql('DROP INDEX IDX_1F1B251E3BD38833');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, rubrique_id, title FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rubrique_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO item (id, rubrique_id, title) SELECT id, rubrique_id, title FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251E3BD38833 ON item (rubrique_id)');
        $this->addSql('DROP INDEX IDX_8FA4097C13830278');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rubrique AS SELECT id, fiche_evaluation_id, title FROM rubrique');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('CREATE TABLE rubrique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fiche_evaluation_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO rubrique (id, fiche_evaluation_id, title) SELECT id, fiche_evaluation_id, title FROM __temp__rubrique');
        $this->addSql('DROP TABLE __temp__rubrique');
        $this->addSql('CREATE INDEX IDX_8FA4097C13830278 ON rubrique (fiche_evaluation_id)');
    }
}
