<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620160545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seguridad.tbd_usuario DROP CONSTRAINT fk_17879b6f5f88db9');
        $this->addSql('DROP INDEX seguridad.uniq_17879b6f5f88db9');
        $this->addSql('ALTER TABLE seguridad.tbd_usuario DROP persona_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE seguridad.tbd_usuario ADD persona_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seguridad.tbd_usuario ADD CONSTRAINT fk_17879b6f5f88db9 FOREIGN KEY (persona_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_17879b6f5f88db9 ON seguridad.tbd_usuario (persona_id)');
    }
}
