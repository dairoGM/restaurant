<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629012746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notificaciones_usuario ADD url TEXT DEFAULT NULL');
        //$this->addSql('DROP INDEX uniq_6ef526033a909126cd2b7e7c');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE UNIQUE INDEX uniq_6ef526033a909126cd2b7e7c ON planificacion.tbd_plan (nombre, estructura_id)');
        $this->addSql('ALTER TABLE notificaciones_usuario DROP url');
    }
}
