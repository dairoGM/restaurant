<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624035929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE personal.tbd_responsable_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE seguridad.tbr_rol_estructura_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personal.tbd_responsable (id INT NOT NULL, persona_id INT NOT NULL, activo BOOLEAN NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2355D865F5F88DB9 ON personal.tbd_responsable (persona_id)');
        $this->addSql('CREATE TABLE seguridad.tbr_rol_estructura (id INT NOT NULL, rol_id INT NOT NULL, estructura_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_248D984E4BAB96C ON seguridad.tbr_rol_estructura (rol_id)');
        $this->addSql('CREATE INDEX IDX_248D984ECD2B7E7C ON seguridad.tbr_rol_estructura (estructura_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_248D984E4BAB96CCD2B7E7C ON seguridad.tbr_rol_estructura (rol_id, estructura_id)');
        $this->addSql('ALTER TABLE personal.tbd_responsable ADD CONSTRAINT FK_2355D865F5F88DB9 FOREIGN KEY (persona_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seguridad.tbr_rol_estructura ADD CONSTRAINT FK_248D984E4BAB96C FOREIGN KEY (rol_id) REFERENCES seguridad.tbd_rol (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seguridad.tbr_rol_estructura ADD CONSTRAINT FK_248D984ECD2B7E7C FOREIGN KEY (estructura_id) REFERENCES estructura.tbd_estructura (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ADD propietario_id INT NOT NULL');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ADD CONSTRAINT FK_616066AE53C8D32C FOREIGN KEY (propietario_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_616066AE53C8D32C ON plan_actividades.tbd_actividad (propietario_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan DROP CONSTRAINT FK_2363561F53C59D72');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan ADD CONSTRAINT FK_2363561F53C59D72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_responsable (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan DROP CONSTRAINT FK_2363561F53C59D72');
        $this->addSql('DROP SEQUENCE personal.tbd_responsable_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE seguridad.tbr_rol_estructura_id_seq CASCADE');
        $this->addSql('DROP TABLE personal.tbd_responsable');
        $this->addSql('DROP TABLE seguridad.tbr_rol_estructura');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad DROP CONSTRAINT FK_616066AE53C8D32C');
        $this->addSql('DROP INDEX IDX_616066AE53C8D32C');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad DROP propietario_id');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan DROP CONSTRAINT fk_2363561f53c59d72');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan ADD CONSTRAINT fk_2363561f53c59d72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
