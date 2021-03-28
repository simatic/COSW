<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328124154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
        $this->addSql('CREATE INDEX IDX_4D59FF6EAC14B70A ON soutenance (modele_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EAC14B70A');
        $this->addSql('DROP INDEX IDX_4D59FF6EAC14B70A ON soutenance');
    }
}
