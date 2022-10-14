<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608224426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE planificacion.plan_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbd_plan_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbd_plan_desglose_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbd_plan_general_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_periodo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_periodo_desglose_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_tipo_desglose_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_tipo_plan_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbd_plan (id INT NOT NULL, tipo_plan_id INT NOT NULL, periodo_id INT NOT NULL, tipo_desglose_id INT DEFAULT NULL, plan_padre_id INT DEFAULT NULL, nombre VARCHAR(250) NOT NULL, descripcion TEXT DEFAULT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6EF52603FB60233B ON planificacion.tbd_plan (tipo_plan_id)');
        $this->addSql('CREATE INDEX IDX_6EF526039C3921AB ON planificacion.tbd_plan (periodo_id)');
        $this->addSql('CREATE INDEX IDX_6EF5260345EF93A ON planificacion.tbd_plan (tipo_desglose_id)');
        $this->addSql('CREATE INDEX IDX_6EF526036F59DB22 ON planificacion.tbd_plan (plan_padre_id)');
        $this->addSql('CREATE TABLE planificacion.tbd_plan_desglose (id INT NOT NULL, plan_id INT NOT NULL, indicador_id INT NOT NULL, evaluacion_id INT DEFAULT NULL, periodo_desglose_id INT NOT NULL, plan_valor DOUBLE PRECISION NOT NULL, plan_real DOUBLE PRECISION DEFAULT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_69F4D43CE899029B ON planificacion.tbd_plan_desglose (plan_id)');
        $this->addSql('CREATE INDEX IDX_69F4D43C47D487D1 ON planificacion.tbd_plan_desglose (indicador_id)');
        $this->addSql('CREATE INDEX IDX_69F4D43CE715F406 ON planificacion.tbd_plan_desglose (evaluacion_id)');
        $this->addSql('CREATE INDEX IDX_69F4D43C4B133677 ON planificacion.tbd_plan_desglose (periodo_desglose_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_69F4D43CE899029B47D487D1 ON planificacion.tbd_plan_desglose (plan_id, indicador_id)');
        $this->addSql('CREATE TABLE planificacion.tbd_plan_general (id INT NOT NULL, plan_id INT NOT NULL, indicador_id INT NOT NULL, forma_evaluacion_id INT NOT NULL, responsable_id INT NOT NULL, plan_valor DOUBLE PRECISION NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FBDE9DF4E899029B ON planificacion.tbd_plan_general (plan_id)');
        $this->addSql('CREATE INDEX IDX_FBDE9DF447D487D1 ON planificacion.tbd_plan_general (indicador_id)');
        $this->addSql('CREATE INDEX IDX_FBDE9DF4DF54F6F6 ON planificacion.tbd_plan_general (forma_evaluacion_id)');
        $this->addSql('CREATE INDEX IDX_FBDE9DF453C59D72 ON planificacion.tbd_plan_general (responsable_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FBDE9DF4E899029B47D487D1 ON planificacion.tbd_plan_general (plan_id, indicador_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_periodo (id INT NOT NULL, tipo_plan_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, siglas VARCHAR(12) NOT NULL, orden INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64AFB258FB60233B ON planificacion.tbn_periodo (tipo_plan_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_periodo_desglose (id INT NOT NULL, tipo_desglose_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, siglas VARCHAR(12) NOT NULL, orden INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1407240345EF93A ON planificacion.tbn_periodo_desglose (tipo_desglose_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_tipo_desglose (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, token_tipo_desglose VARCHAR(255) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbn_tipo_plan (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, token_tipo_plan VARCHAR(255) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF52603FB60233B FOREIGN KEY (tipo_plan_id) REFERENCES planificacion.tbn_tipo_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF526039C3921AB FOREIGN KEY (periodo_id) REFERENCES planificacion.tbn_periodo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF5260345EF93A FOREIGN KEY (tipo_desglose_id) REFERENCES planificacion.tbn_tipo_desglose (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF526036F59DB22 FOREIGN KEY (plan_padre_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT FK_69F4D43CE899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT FK_69F4D43C47D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT FK_69F4D43CE715F406 FOREIGN KEY (evaluacion_id) REFERENCES planificacion.tbn_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT FK_69F4D43C4B133677 FOREIGN KEY (periodo_desglose_id) REFERENCES planificacion.tbn_periodo_desglose (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT FK_FBDE9DF4E899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT FK_FBDE9DF447D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT FK_FBDE9DF4DF54F6F6 FOREIGN KEY (forma_evaluacion_id) REFERENCES planificacion.tbd_forma_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT FK_FBDE9DF453C59D72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_periodo ADD CONSTRAINT FK_64AFB258FB60233B FOREIGN KEY (tipo_plan_id) REFERENCES planificacion.tbn_tipo_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_periodo_desglose ADD CONSTRAINT FK_1407240345EF93A FOREIGN KEY (tipo_desglose_id) REFERENCES planificacion.tbn_tipo_desglose (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.plan');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF526036F59DB22');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose DROP CONSTRAINT FK_69F4D43CE899029B');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general DROP CONSTRAINT FK_FBDE9DF4E899029B');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF526039C3921AB');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose DROP CONSTRAINT FK_69F4D43C4B133677');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF5260345EF93A');
        $this->addSql('ALTER TABLE planificacion.tbn_periodo_desglose DROP CONSTRAINT FK_1407240345EF93A');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF52603FB60233B');
        $this->addSql('ALTER TABLE planificacion.tbn_periodo DROP CONSTRAINT FK_64AFB258FB60233B');
        $this->addSql('DROP SEQUENCE planificacion.tbd_plan_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbd_plan_desglose_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbd_plan_general_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_periodo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_periodo_desglose_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_tipo_desglose_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_tipo_plan_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.plan_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.plan (id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE planificacion.tbd_plan');
        $this->addSql('DROP TABLE planificacion.tbd_plan_desglose');
        $this->addSql('DROP TABLE planificacion.tbd_plan_general');
        $this->addSql('DROP TABLE planificacion.tbn_periodo');
        $this->addSql('DROP TABLE planificacion.tbn_periodo_desglose');
        $this->addSql('DROP TABLE planificacion.tbn_tipo_desglose');
        $this->addSql('DROP TABLE planificacion.tbn_tipo_plan');
    }
}
