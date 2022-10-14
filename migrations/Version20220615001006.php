<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220615001006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE planificacion.tbd_plan_desglose_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbd_plan_general_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_plan_indicador_responsable_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbr_plan_indicador_responsable (id INT NOT NULL, plan_id INT NOT NULL, indicador_id INT NOT NULL, responsable_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5B327005E899029B ON planificacion.tbr_plan_indicador_responsable (plan_id)');
        $this->addSql('CREATE INDEX IDX_5B32700547D487D1 ON planificacion.tbr_plan_indicador_responsable (indicador_id)');
        $this->addSql('CREATE INDEX IDX_5B32700553C59D72 ON planificacion.tbr_plan_indicador_responsable (responsable_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5B327005E899029B47D487D153C59D72 ON planificacion.tbr_plan_indicador_responsable (plan_id, indicador_id, responsable_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable ADD CONSTRAINT FK_5B327005E899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable ADD CONSTRAINT FK_5B32700547D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_responsable ADD CONSTRAINT FK_5B32700553C59D72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.tbd_plan_desglose');
        $this->addSql('DROP TABLE planificacion.tbd_plan_general');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP CONSTRAINT FK_AB79ADA66CA204EF');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP CONSTRAINT FK_AB79ADA64E7121AF');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD CONSTRAINT FK_AB79ADA66CA204EF FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD CONSTRAINT FK_AB79ADA64E7121AF FOREIGN KEY (provincia_id) REFERENCES estructura.tbn_provincia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general DROP CONSTRAINT fk_9477ed322a9ce418');
        $this->addSql('DROP INDEX planificacion.idx_9477ed322a9ce418');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general DROP area_resultado_clave_id');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP CONSTRAINT fk_43e6a51853c59d72');
        $this->addSql('DROP INDEX planificacion.idx_43e6a51853c59d72');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador DROP responsable_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE planificacion.tbr_plan_indicador_responsable_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbd_plan_desglose_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbd_plan_general_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbd_plan_desglose (id INT NOT NULL, plan_id INT NOT NULL, indicador_id INT NOT NULL, evaluacion_id INT DEFAULT NULL, plan_valor DOUBLE PRECISION NOT NULL, plan_real DOUBLE PRECISION DEFAULT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_69f4d43ce899029b ON planificacion.tbd_plan_desglose (plan_id)');
        $this->addSql('CREATE INDEX idx_69f4d43ce715f406 ON planificacion.tbd_plan_desglose (evaluacion_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_69f4d43ce899029b47d487d1 ON planificacion.tbd_plan_desglose (plan_id, indicador_id)');
        $this->addSql('CREATE INDEX idx_69f4d43c47d487d1 ON planificacion.tbd_plan_desglose (indicador_id)');
        $this->addSql('CREATE TABLE planificacion.tbd_plan_general (id INT NOT NULL, plan_id INT NOT NULL, indicador_id INT NOT NULL, forma_evaluacion_id INT NOT NULL, responsable_id INT NOT NULL, plan_valor DOUBLE PRECISION NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_fbde9df4e899029b47d487d1 ON planificacion.tbd_plan_general (plan_id, indicador_id)');
        $this->addSql('CREATE INDEX idx_fbde9df4df54f6f6 ON planificacion.tbd_plan_general (forma_evaluacion_id)');
        $this->addSql('CREATE INDEX idx_fbde9df447d487d1 ON planificacion.tbd_plan_general (indicador_id)');
        $this->addSql('CREATE INDEX idx_fbde9df4e899029b ON planificacion.tbd_plan_general (plan_id)');
        $this->addSql('CREATE INDEX idx_fbde9df453c59d72 ON planificacion.tbd_plan_general (responsable_id)');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT fk_69f4d43ce899029b FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT fk_69f4d43c47d487d1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT fk_69f4d43ce715f406 FOREIGN KEY (evaluacion_id) REFERENCES planificacion.tbn_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT fk_fbde9df4e899029b FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT fk_fbde9df447d487d1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT fk_fbde9df4df54f6f6 FOREIGN KEY (forma_evaluacion_id) REFERENCES planificacion.tbd_forma_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_general ADD CONSTRAINT fk_fbde9df453c59d72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.tbr_plan_indicador_responsable');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP CONSTRAINT fk_ab79ada66ca204ef');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP CONSTRAINT fk_ab79ada64e7121af');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD CONSTRAINT fk_ab79ada66ca204ef FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_estructura (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD CONSTRAINT fk_ab79ada64e7121af FOREIGN KEY (provincia_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general ADD area_resultado_clave_id INT NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbn_objetivo_general ADD CONSTRAINT fk_9477ed322a9ce418 FOREIGN KEY (area_resultado_clave_id) REFERENCES planificacion.tbn_area_resultado_clave (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9477ed322a9ce418 ON planificacion.tbn_objetivo_general (area_resultado_clave_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD responsable_id INT NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT fk_43e6a51853c59d72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_43e6a51853c59d72 ON planificacion.tbr_plan_indicador (responsable_id)');
    }
}
