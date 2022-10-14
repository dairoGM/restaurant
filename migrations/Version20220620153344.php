<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620153344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX personal.idx_d817a223db38439e');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D817A223DB38439E ON personal.tbd_persona (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_D817A223DB38439E');
        $this->addSql('CREATE INDEX idx_d817a223db38439e ON personal.tbd_persona (usuario_id)');
    }
}
