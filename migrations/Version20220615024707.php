<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220615024707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad DROP CONSTRAINT fk_544c5de7e899029b');
        $this->addSql('DROP INDEX planificacion.idx_544c5de7e899029b');
        $this->addSql('DROP INDEX planificacion.uniq_544c5de7e899029b47d487d16ca204ef');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad DROP plan_id');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad DROP plan_valor');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad DROP plan_real');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_544C5DE747D487D16CA204EF ON planificacion.tbr_plan_indicador_entidad (indicador_id, entidad_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_544C5DE747D487D16CA204EF');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD plan_id INT NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD plan_valor DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD plan_real DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD CONSTRAINT fk_544c5de7e899029b FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_544c5de7e899029b ON planificacion.tbr_plan_indicador_entidad (plan_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_544c5de7e899029b47d487d16ca204ef ON planificacion.tbr_plan_indicador_entidad (plan_id, indicador_id, entidad_id)');
    }
}
