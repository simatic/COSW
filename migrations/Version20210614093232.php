<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210614093232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE eval_item');
        $this->addSql('DROP TABLE fiche_evaluation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eval_item (id INT AUTO_INCREMENT NOT NULL, soutenance_id INT NOT NULL, user_id INT DEFAULT NULL, item_id INT NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_4C29623AA59B3775 (soutenance_id), UNIQUE INDEX UNIQ_4C29623A126F525E (item_id), INDEX IDX_4C29623AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE fiche_evaluation (id INT AUTO_INCREMENT NOT NULL, evaluateur_id INT DEFAULT NULL, soutenance_id INT DEFAULT NULL, note_final DOUBLE PRECISION NOT NULL, ponderation DOUBLE PRECISION NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_BD75A182A59B3775 (soutenance_id), INDEX IDX_BD75A182231F139 (evaluateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623A126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623AA59B3775 FOREIGN KEY (soutenance_id) REFERENCES soutenance (id)');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE fiche_evaluation ADD CONSTRAINT FK_BD75A182231F139 FOREIGN KEY (evaluateur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE fiche_evaluation ADD CONSTRAINT FK_BD75A182A59B3775 FOREIGN KEY (soutenance_id) REFERENCES soutenance (id)');
    }
}
