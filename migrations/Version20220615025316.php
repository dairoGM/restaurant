<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220615025316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE planificacion.tbr_plan_indicador_entidad_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_indicador_entidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbr_indicador_entidad (id INT NOT NULL, indicador_id INT NOT NULL, entidad_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_110CFE1447D487D1 ON planificacion.tbr_indicador_entidad (indicador_id)');
        $this->addSql('CREATE INDEX IDX_110CFE146CA204EF ON planificacion.tbr_indicador_entidad (entidad_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_110CFE1447D487D16CA204EF ON planificacion.tbr_indicador_entidad (indicador_id, entidad_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_entidad ADD CONSTRAINT FK_110CFE1447D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_entidad ADD CONSTRAINT FK_110CFE146CA204EF FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.tbr_plan_indicador_entidad');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE planificacion.tbr_indicador_entidad_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_plan_indicador_entidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbr_plan_indicador_entidad (id INT NOT NULL, indicador_id INT NOT NULL, entidad_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_544c5de76ca204ef ON planificacion.tbr_plan_indicador_entidad (entidad_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_544c5de747d487d16ca204ef ON planificacion.tbr_plan_indicador_entidad (indicador_id, entidad_id)');
        $this->addSql('CREATE INDEX idx_544c5de747d487d1 ON planificacion.tbr_plan_indicador_entidad (indicador_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD CONSTRAINT fk_544c5de747d487d1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD CONSTRAINT fk_544c5de76ca204ef FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.tbr_indicador_entidad');
    }
}
