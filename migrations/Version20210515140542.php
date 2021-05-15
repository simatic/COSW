<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210515140542 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eval_item DROP FOREIGN KEY FK_4C29623AA76ED395');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A76ED395');
        $this->addSql('ALTER TABLE fiche_evaluation DROP FOREIGN KEY FK_BD75A182231F139');
        $this->addSql('DROP TABLE evaluation_item');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDE7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F2BC9BD7E7927C74 ON account_request (email)');
        $this->addSql('ALTER TABLE eval_item DROP FOREIGN KEY FK_4C29623AA76ED395');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623AA76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A76ED395');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
        $this->addSql('ALTER TABLE fiche_evaluation DROP FOREIGN KEY FK_BD75A182231F139');
        $this->addSql('ALTER TABLE fiche_evaluation ADD CONSTRAINT FK_BD75A182231F139 FOREIGN KEY (evaluateur_id) REFERENCES Users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation_item (evaluation_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_525D6AA6456C5646 (evaluation_id), INDEX IDX_525D6AA6126F525E (item_id), PRIMARY KEY(evaluation_id, item_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, role LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evaluation_item ADD CONSTRAINT FK_525D6AA6126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_item ADD CONSTRAINT FK_525D6AA6456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_F2BC9BD7E7927C74 ON account_request');
        $this->addSql('ALTER TABLE eval_item DROP FOREIGN KEY FK_4C29623AA76ED395');
        $this->addSql('ALTER TABLE eval_item ADD CONSTRAINT FK_4C29623AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A76ED395');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fiche_evaluation DROP FOREIGN KEY FK_BD75A182231F139');
        $this->addSql('ALTER TABLE fiche_evaluation ADD CONSTRAINT FK_BD75A182231F139 FOREIGN KEY (evaluateur_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX UNIQ_D5428AEDE7927C74 ON Users');
        $this->addSql('ALTER TABLE Users CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
