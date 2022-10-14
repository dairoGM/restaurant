<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620151209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE planificacion.tbr_indicador_entidad_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE objetivo_especifico_usuario_favoritos_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_area_resultado_clave_indicador_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_indicador_estructura_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE objetivo_especifico_usuario_favoritos (id INT NOT NULL, objetivo_especifico_id INT DEFAULT NULL, usuario_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9A6AE7936731F5F8 ON objetivo_especifico_usuario_favoritos (objetivo_especifico_id)');
        $this->addSql('CREATE INDEX IDX_9A6AE793DB38439E ON objetivo_especifico_usuario_favoritos (usuario_id)');
        $this->addSql('CREATE TABLE planificacion.tbr_area_resultado_clave_indicador (id INT NOT NULL, area_resultado_clave_id INT NOT NULL, indicador_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0825DB32A9CE418 ON planificacion.tbr_area_resultado_clave_indicador (area_resultado_clave_id)');
        $this->addSql('CREATE INDEX IDX_C0825DB347D487D1 ON planificacion.tbr_area_resultado_clave_indicador (indicador_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0825DB347D487D12A9CE418 ON planificacion.tbr_area_resultado_clave_indicador (indicador_id, area_resultado_clave_id)');
        $this->addSql('CREATE TABLE planificacion.tbr_indicador_estructura (id INT NOT NULL, indicador_id INT NOT NULL, estructura_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C8640A6547D487D1 ON planificacion.tbr_indicador_estructura (indicador_id)');
        $this->addSql('CREATE INDEX IDX_C8640A65CD2B7E7C ON planificacion.tbr_indicador_estructura (estructura_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8640A6547D487D1CD2B7E7C ON planificacion.tbr_indicador_estructura (indicador_id, estructura_id)');
        $this->addSql('ALTER TABLE objetivo_especifico_usuario_favoritos ADD CONSTRAINT FK_9A6AE7936731F5F8 FOREIGN KEY (objetivo_especifico_id) REFERENCES planificacion.tbn_objetivo_especifico (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE objetivo_especifico_usuario_favoritos ADD CONSTRAINT FK_9A6AE793DB38439E FOREIGN KEY (usuario_id) REFERENCES seguridad.tbd_usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_area_resultado_clave_indicador ADD CONSTRAINT FK_C0825DB32A9CE418 FOREIGN KEY (area_resultado_clave_id) REFERENCES planificacion.tbn_area_resultado_clave (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_area_resultado_clave_indicador ADD CONSTRAINT FK_C0825DB347D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura ADD CONSTRAINT FK_C8640A6547D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura ADD CONSTRAINT FK_C8640A65CD2B7E7C FOREIGN KEY (estructura_id) REFERENCES estructura.tbd_estructura (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.tbr_indicador_entidad');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD municipio_id INT NOT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD provincia_id INT NOT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD telefono VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD direccion TEXT NOT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD CONSTRAINT FK_BF47AB8558BC1BE0 FOREIGN KEY (municipio_id) REFERENCES estructura.tbn_municipio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD CONSTRAINT FK_BF47AB854E7121AF FOREIGN KEY (provincia_id) REFERENCES estructura.tbn_provincia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BF47AB8558BC1BE0 ON estructura.tbd_estructura (municipio_id)');
        $this->addSql('CREATE INDEX IDX_BF47AB854E7121AF ON estructura.tbd_estructura (provincia_id)');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT fk_6ef526036ca204ef');
        $this->addSql('DROP INDEX planificacion.idx_6ef526036ca204ef');
        $this->addSql('ALTER TABLE planificacion.tbd_plan RENAME COLUMN entidad_id TO estructura_id');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF52603CD2B7E7C FOREIGN KEY (estructura_id) REFERENCES estructura.tbd_estructura (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6EF52603CD2B7E7C ON planificacion.tbd_plan (estructura_id)');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general ADD icono VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ALTER forma_evaluacion_id DROP NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ALTER plan_valor DROP NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable ALTER responsable_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE objetivo_especifico_usuario_favoritos_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbr_area_resultado_clave_indicador_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbr_indicador_estructura_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_indicador_entidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbr_indicador_entidad (id INT NOT NULL, indicador_id INT NOT NULL, entidad_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_110cfe1447d487d1 ON planificacion.tbr_indicador_entidad (indicador_id)');
        $this->addSql('CREATE INDEX idx_110cfe146ca204ef ON planificacion.tbr_indicador_entidad (entidad_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_110cfe1447d487d16ca204ef ON planificacion.tbr_indicador_entidad (indicador_id, entidad_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_entidad ADD CONSTRAINT fk_110cfe1447d487d1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_entidad ADD CONSTRAINT fk_110cfe146ca204ef FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE objetivo_especifico_usuario_favoritos');
        $this->addSql('DROP TABLE planificacion.tbr_area_resultado_clave_indicador');
        $this->addSql('DROP TABLE planificacion.tbr_indicador_estructura');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF52603CD2B7E7C');
        $this->addSql('DROP INDEX IDX_6EF52603CD2B7E7C');
        $this->addSql('ALTER TABLE planificacion.tbd_plan RENAME COLUMN estructura_id TO entidad_id');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT fk_6ef526036ca204ef FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6ef526036ca204ef ON planificacion.tbd_plan (entidad_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable ALTER responsable_id SET NOT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP CONSTRAINT FK_BF47AB8558BC1BE0');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP CONSTRAINT FK_BF47AB854E7121AF');
        $this->addSql('DROP INDEX IDX_BF47AB8558BC1BE0');
        $this->addSql('DROP INDEX IDX_BF47AB854E7121AF');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP municipio_id');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP provincia_id');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP email');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP telefono');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP direccion');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general DROP icono');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ALTER forma_evaluacion_id SET NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ALTER plan_valor SET NOT NULL');
    }
}
