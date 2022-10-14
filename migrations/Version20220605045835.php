<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605045835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE planificacion.tbd_forma_evaluacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbd_indicador_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_area_resultado_clave_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_evaluacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_formula_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_objetivo_especifico_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_objetivo_general_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_tipo_evaluacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_tipo_indicador_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_unidad_medida_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_rango_evaluacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbd_forma_evaluacion (id INT NOT NULL, formula_id INT NOT NULL, tipo_evaluacion_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_66A2AF3AA50A6386 ON planificacion.tbd_forma_evaluacion (formula_id)');
        $this->addSql('CREATE INDEX IDX_66A2AF3AE7A6A758 ON planificacion.tbd_forma_evaluacion (tipo_evaluacion_id)');
        $this->addSql('CREATE TABLE planificacion.tbd_indicador (id INT NOT NULL, unidad_medida_id INT NOT NULL, tipo_indicador_id INT NOT NULL, objetivo_especifico_id INT NOT NULL, default_forma_evaluacion_id INT DEFAULT NULL, codigo VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, siglas VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, seguimiento BOOLEAN NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F69FF0A2E003F4 ON planificacion.tbd_indicador (unidad_medida_id)');
        $this->addSql('CREATE INDEX IDX_F69FF0AF487D9D1 ON planificacion.tbd_indicador (tipo_indicador_id)');
        $this->addSql('CREATE INDEX IDX_F69FF0A6731F5F8 ON planificacion.tbd_indicador (objetivo_especifico_id)');
        $this->addSql('CREATE INDEX IDX_F69FF0A76881DAB ON planificacion.tbd_indicador (default_forma_evaluacion_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_area_resultado_clave (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, codigo VARCHAR(255) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbn_evaluacion (id INT NOT NULL, tipo_evaluacion_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, siglas VARCHAR(12) NOT NULL, orden INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D6A023E7E7A6A758 ON planificacion.tbn_evaluacion (tipo_evaluacion_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_formula (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, token_tipo_formula VARCHAR(255) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbn_objetivo_especifico (id INT NOT NULL, objetivo_general_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, codigo VARCHAR(255) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C9D87002487A46B ON planificacion.tbn_objetivo_especifico (objetivo_general_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_objetivo_general (id INT NOT NULL, area_resultado_clave_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, codigo VARCHAR(255) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9477ED322A9CE418 ON planificacion.tbn_objetivo_general (area_resultado_clave_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_tipo_evaluacion (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbn_tipo_indicador (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbn_unidad_medida (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, siglas VARCHAR(12) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbr_rango_evaluacion (id INT NOT NULL, forma_evaluacion_id INT NOT NULL, evaluacion_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, min_value DOUBLE PRECISION NOT NULL, max_value DOUBLE PRECISION NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6313DB2DF54F6F6 ON planificacion.tbr_rango_evaluacion (forma_evaluacion_id)');
        $this->addSql('CREATE INDEX IDX_6313DB2E715F406 ON planificacion.tbr_rango_evaluacion (evaluacion_id)');
        $this->addSql('ALTER TABLE planificacion.tbd_forma_evaluacion ADD CONSTRAINT FK_66A2AF3AA50A6386 FOREIGN KEY (formula_id) REFERENCES planificacion.tbn_formula (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_forma_evaluacion ADD CONSTRAINT FK_66A2AF3AE7A6A758 FOREIGN KEY (tipo_evaluacion_id) REFERENCES planificacion.tbn_tipo_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD CONSTRAINT FK_F69FF0A2E003F4 FOREIGN KEY (unidad_medida_id) REFERENCES planificacion.tbn_unidad_medida (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD CONSTRAINT FK_F69FF0AF487D9D1 FOREIGN KEY (tipo_indicador_id) REFERENCES planificacion.tbn_tipo_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD CONSTRAINT FK_F69FF0A6731F5F8 FOREIGN KEY (objetivo_especifico_id) REFERENCES planificacion.tbn_objetivo_especifico (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD CONSTRAINT FK_F69FF0A76881DAB FOREIGN KEY (default_forma_evaluacion_id) REFERENCES planificacion.tbd_forma_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_evaluacion ADD CONSTRAINT FK_D6A023E7E7A6A758 FOREIGN KEY (tipo_evaluacion_id) REFERENCES planificacion.tbn_tipo_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_especifico ADD CONSTRAINT FK_C9D87002487A46B FOREIGN KEY (objetivo_general_id) REFERENCES planificacion.tbn_objetivo_general (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general ADD CONSTRAINT FK_9477ED322A9CE418 FOREIGN KEY (area_resultado_clave_id) REFERENCES planificacion.tbn_area_resultado_clave (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_rango_evaluacion ADD CONSTRAINT FK_6313DB2DF54F6F6 FOREIGN KEY (forma_evaluacion_id) REFERENCES planificacion.tbd_forma_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_rango_evaluacion ADD CONSTRAINT FK_6313DB2E715F406 FOREIGN KEY (evaluacion_id) REFERENCES planificacion.tbn_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP CONSTRAINT FK_F69FF0A76881DAB');
        $this->addSql('ALTER TABLE planificacion.tbr_rango_evaluacion DROP CONSTRAINT FK_6313DB2DF54F6F6');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general DROP CONSTRAINT FK_9477ED322A9CE418');
        $this->addSql('ALTER TABLE planificacion.tbr_rango_evaluacion DROP CONSTRAINT FK_6313DB2E715F406');
        $this->addSql('ALTER TABLE planificacion.tbd_forma_evaluacion DROP CONSTRAINT FK_66A2AF3AA50A6386');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP CONSTRAINT FK_F69FF0A6731F5F8');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_especifico DROP CONSTRAINT FK_C9D87002487A46B');
        $this->addSql('ALTER TABLE planificacion.tbd_forma_evaluacion DROP CONSTRAINT FK_66A2AF3AE7A6A758');
        $this->addSql('ALTER TABLE planificacion.tbn_evaluacion DROP CONSTRAINT FK_D6A023E7E7A6A758');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP CONSTRAINT FK_F69FF0AF487D9D1');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP CONSTRAINT FK_F69FF0A2E003F4');
        $this->addSql('DROP SEQUENCE planificacion.tbd_forma_evaluacion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbd_indicador_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_area_resultado_clave_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_evaluacion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_formula_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_objetivo_especifico_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_objetivo_general_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_tipo_evaluacion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_tipo_indicador_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_unidad_medida_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbr_rango_evaluacion_id_seq CASCADE');
        $this->addSql('DROP TABLE planificacion.tbd_forma_evaluacion');
        $this->addSql('DROP TABLE planificacion.tbd_indicador');
        $this->addSql('DROP TABLE planificacion.tbn_area_resultado_clave');
        $this->addSql('DROP TABLE planificacion.tbn_evaluacion');
        $this->addSql('DROP TABLE planificacion.tbn_formula');
        $this->addSql('DROP TABLE planificacion.tbn_objetivo_especifico');
        $this->addSql('DROP TABLE planificacion.tbn_objetivo_general');
        $this->addSql('DROP TABLE planificacion.tbn_tipo_evaluacion');
        $this->addSql('DROP TABLE planificacion.tbn_tipo_indicador');
        $this->addSql('DROP TABLE planificacion.tbn_unidad_medida');
        $this->addSql('DROP TABLE planificacion.tbr_rango_evaluacion');
    }
}
