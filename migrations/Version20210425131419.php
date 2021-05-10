<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425131419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiche_evaluation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, title FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rubrique_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_1F1B251E3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO item (id, title) SELECT id, title FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('CREATE INDEX IDX_1F1B251E3BD38833 ON item (rubrique_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rubrique AS SELECT id, title FROM rubrique');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('CREATE TABLE rubrique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fiche_evaluation_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_8FA4097C13830278 FOREIGN KEY (fiche_evaluation_id) REFERENCES fiche_evaluation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rubrique (id, title) SELECT id, title FROM __temp__rubrique');
        $this->addSql('DROP TABLE __temp__rubrique');
        $this->addSql('CREATE INDEX IDX_8FA4097C13830278 ON rubrique (fiche_evaluation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fiche_evaluation');
        $this->addSql('DROP INDEX IDX_1F1B251E3BD38833');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, title FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO item (id, title) SELECT id, title FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
        $this->addSql('DROP INDEX IDX_8FA4097C13830278');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rubrique AS SELECT id, title FROM rubrique');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('CREATE TABLE rubrique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO rubrique (id, title) SELECT id, title FROM __temp__rubrique');
        $this->addSql('DROP TABLE __temp__rubrique');
    }
}
