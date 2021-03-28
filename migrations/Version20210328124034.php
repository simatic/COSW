<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328124034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item CHANGE note note DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE rubrique CHANGE commentaire commentaire LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6E13830278');
        $this->addSql('DROP INDEX IDX_4D59FF6E13830278 ON soutenance');
        $this->addSql('ALTER TABLE soutenance ADD modele_id INT NOT NULL, DROP fiche_evaluation_id, CHANGE note note DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
        $this->addSql('CREATE INDEX IDX_4D59FF6EAC14B70A ON soutenance (modele_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item CHANGE note note DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE rubrique CHANGE commentaire commentaire LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EAC14B70A');
        $this->addSql('DROP INDEX IDX_4D59FF6EAC14B70A ON soutenance');
        $this->addSql('ALTER TABLE soutenance ADD fiche_evaluation_id INT DEFAULT NULL, DROP modele_id, CHANGE note note DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6E13830278 FOREIGN KEY (fiche_evaluation_id) REFERENCES fiche_evaluation (id)');
        $this->addSql('CREATE INDEX IDX_4D59FF6E13830278 ON soutenance (fiche_evaluation_id)');
    }
}
