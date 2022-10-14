<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622205548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE notificaciones_usuario_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_estado_plan_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_plan_estado_plan_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE notificaciones_usuario (id INT NOT NULL, usuario_envia_id INT DEFAULT NULL, usuario_recive_id INT DEFAULT NULL, texto TEXT NOT NULL, leido BOOLEAN NOT NULL, fecha_creado DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C66FA6F59DA2C333 ON notificaciones_usuario (usuario_envia_id)');
        $this->addSql('CREATE INDEX IDX_C66FA6F55FA3BDA6 ON notificaciones_usuario (usuario_recive_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_estado_plan (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbr_plan_estado_plan (id INT NOT NULL, plan_id INT NOT NULL, estado_plan_id INT NOT NULL, responsable_id INT DEFAULT NULL, descripcion TEXT DEFAULT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2363561FE899029B ON planificacion.tbr_plan_estado_plan (plan_id)');
        $this->addSql('CREATE INDEX IDX_2363561FCAC8AD4A ON planificacion.tbr_plan_estado_plan (estado_plan_id)');
        $this->addSql('CREATE INDEX IDX_2363561F53C59D72 ON planificacion.tbr_plan_estado_plan (responsable_id)');
        $this->addSql('ALTER TABLE notificaciones_usuario ADD CONSTRAINT FK_C66FA6F59DA2C333 FOREIGN KEY (usuario_envia_id) REFERENCES seguridad.tbd_usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notificaciones_usuario ADD CONSTRAINT FK_C66FA6F55FA3BDA6 FOREIGN KEY (usuario_recive_id) REFERENCES seguridad.tbd_usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan ADD CONSTRAINT FK_2363561FE899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan ADD CONSTRAINT FK_2363561FCAC8AD4A FOREIGN KEY (estado_plan_id) REFERENCES planificacion.tbn_estado_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan ADD CONSTRAINT FK_2363561F53C59D72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP CONSTRAINT FK_F69FF0A6731F5F8');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD CONSTRAINT FK_F69FF0A6731F5F8 FOREIGN KEY (objetivo_especifico_id) REFERENCES planificacion.tbn_objetivo_especifico (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal.tbd_persona ADD twitter VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF526036F59DB22');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD estado_plan_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF52603CAC8AD4A FOREIGN KEY (estado_plan_id) REFERENCES planificacion.tbn_estado_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF526036F59DB22 FOREIGN KEY (plan_padre_id) REFERENCES planificacion.tbd_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6EF52603CAC8AD4A ON planificacion.tbd_plan (estado_plan_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EF526033A909126CD2B7E7C ON planificacion.tbd_plan (nombre, estructura_id)');
        $this->addSql('ALTER TABLE planificacion.tbn_evaluacion ADD color VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_especifico DROP CONSTRAINT FK_C9D87002487A46B');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_especifico ADD CONSTRAINT FK_C9D87002487A46B FOREIGN KEY (objetivo_general_id) REFERENCES planificacion.tbn_objetivo_general (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura DROP CONSTRAINT FK_C8640A6547D487D1');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura DROP CONSTRAINT FK_C8640A65CD2B7E7C');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura ADD CONSTRAINT FK_C8640A6547D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura ADD CONSTRAINT FK_C8640A65CD2B7E7C FOREIGN KEY (estructura_id) REFERENCES estructura.tbd_estructura (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT FK_43E6A51847D487D1');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT FK_43E6A518DF54F6F6');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT FK_43E6A518E715F406');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT FK_43E6A518E899029B');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A51847D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A518DF54F6F6 FOREIGN KEY (forma_evaluacion_id) REFERENCES planificacion.tbd_forma_evaluacion (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A518E715F406 FOREIGN KEY (evaluacion_id) REFERENCES planificacion.tbn_evaluacion (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A518E899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable DROP CONSTRAINT FK_5B327005E899029B');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable ADD CONSTRAINT FK_5B327005E899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_especifico DROP CONSTRAINT FK_3C9D4DE899029B');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_especifico ADD CONSTRAINT FK_3C9D4DE899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_general DROP CONSTRAINT FK_39D24E0DE899029B');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_general ADD CONSTRAINT FK_39D24E0DE899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF52603CAC8AD4A');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_estado_plan DROP CONSTRAINT FK_2363561FCAC8AD4A');
        $this->addSql('DROP SEQUENCE notificaciones_usuario_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_estado_plan_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbr_plan_estado_plan_id_seq CASCADE');
        $this->addSql('DROP TABLE notificaciones_usuario');
        $this->addSql('DROP TABLE planificacion.tbn_estado_plan');
        $this->addSql('DROP TABLE planificacion.tbr_plan_estado_plan');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT fk_6ef526036f59db22');
        $this->addSql('DROP INDEX IDX_6EF52603CAC8AD4A');
        $this->addSql('DROP INDEX UNIQ_6EF526033A909126CD2B7E7C');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP estado_plan_id');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT fk_6ef526036f59db22 FOREIGN KEY (plan_padre_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable DROP CONSTRAINT fk_5b327005e899029b');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable ADD CONSTRAINT fk_5b327005e899029b FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT fk_43e6a518e899029b');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT fk_43e6a51847d487d1');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT fk_43e6a518df54f6f6');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT fk_43e6a518e715f406');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT fk_43e6a518e899029b FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT fk_43e6a51847d487d1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT fk_43e6a518df54f6f6 FOREIGN KEY (forma_evaluacion_id) REFERENCES planificacion.tbd_forma_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT fk_43e6a518e715f406 FOREIGN KEY (evaluacion_id) REFERENCES planificacion.tbn_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_especifico DROP CONSTRAINT fk_c9d87002487a46b');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_especifico ADD CONSTRAINT fk_c9d87002487a46b FOREIGN KEY (objetivo_general_id) REFERENCES planificacion.tbn_objetivo_general (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_evaluacion DROP color');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura DROP CONSTRAINT fk_c8640a6547d487d1');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura DROP CONSTRAINT fk_c8640a65cd2b7e7c');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura ADD CONSTRAINT fk_c8640a6547d487d1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_indicador_estructura ADD CONSTRAINT fk_c8640a65cd2b7e7c FOREIGN KEY (estructura_id) REFERENCES estructura.tbd_estructura (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_general DROP CONSTRAINT fk_39d24e0de899029b');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_general ADD CONSTRAINT fk_39d24e0de899029b FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal.tbd_persona DROP twitter');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_especifico DROP CONSTRAINT fk_3c9d4de899029b');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_especifico ADD CONSTRAINT fk_3c9d4de899029b FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP CONSTRAINT fk_f69ff0a6731f5f8');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD CONSTRAINT fk_f69ff0a6731f5f8 FOREIGN KEY (objetivo_especifico_id) REFERENCES planificacion.tbn_objetivo_especifico (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
