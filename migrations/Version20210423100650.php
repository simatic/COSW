<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423100650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modele_item (modele_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_D99C5139AC14B70A (modele_id), INDEX IDX_D99C5139126F525E (item_id), PRIMARY KEY(modele_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE modele_item ADD CONSTRAINT FK_D99C5139AC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_item ADD CONSTRAINT FK_D99C5139126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
        $this->addSql('CREATE INDEX IDX_4D59FF6EAC14B70A ON soutenance (modele_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE modele_item');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EAC14B70A');
        $this->addSql('DROP INDEX IDX_4D59FF6EAC14B70A ON soutenance');
    }
}
