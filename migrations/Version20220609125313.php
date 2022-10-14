<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609125313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT fk_6ef526039c3921ab');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT fk_6ef5260345ef93a');
        $this->addSql('ALTER TABLE planificacion.tbn_periodo_desglose DROP CONSTRAINT fk_1407240345ef93a');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose DROP CONSTRAINT fk_69f4d43c4b133677');
        $this->addSql('DROP SEQUENCE planificacion.tbn_periodo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_periodo_desglose_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbn_tipo_desglose_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_plan_objetivo_especifico_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbr_plan_objetivo_general_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbr_plan_objetivo_especifico (id INT NOT NULL, plan_id INT NOT NULL, objetivo_especifico_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3C9D4DE899029B ON planificacion.tbr_plan_objetivo_especifico (plan_id)');
        $this->addSql('CREATE INDEX IDX_3C9D4D6731F5F8 ON planificacion.tbr_plan_objetivo_especifico (objetivo_especifico_id)');
        $this->addSql('CREATE TABLE planificacion.tbr_plan_objetivo_general (id INT NOT NULL, plan_id INT NOT NULL, objetivo_general_id INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_39D24E0DE899029B ON planificacion.tbr_plan_objetivo_general (plan_id)');
        $this->addSql('CREATE INDEX IDX_39D24E0D2487A46B ON planificacion.tbr_plan_objetivo_general (objetivo_general_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_especifico ADD CONSTRAINT FK_3C9D4DE899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_especifico ADD CONSTRAINT FK_3C9D4D6731F5F8 FOREIGN KEY (objetivo_especifico_id) REFERENCES planificacion.tbn_objetivo_especifico (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_general ADD CONSTRAINT FK_39D24E0DE899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_objetivo_general ADD CONSTRAINT FK_39D24E0D2487A46B FOREIGN KEY (objetivo_general_id) REFERENCES planificacion.tbn_objetivo_general (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.tbn_periodo');
        $this->addSql('DROP TABLE planificacion.tbn_tipo_desglose');
        $this->addSql('DROP TABLE planificacion.tbn_periodo_desglose');
        $this->addSql('DROP INDEX planificacion.idx_6ef5260345ef93a');
        $this->addSql('DROP INDEX planificacion.idx_6ef526039c3921ab');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD periodo DATE NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP periodo_id');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP tipo_desglose_id');
        $this->addSql('DROP INDEX planificacion.idx_69f4d43c4b133677');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose DROP periodo_desglose_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE planificacion.tbr_plan_objetivo_especifico_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE planificacion.tbr_plan_objetivo_general_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_periodo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_periodo_desglose_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE planificacion.tbn_tipo_desglose_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbn_periodo (id INT NOT NULL, tipo_plan_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, siglas VARCHAR(12) NOT NULL, orden INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_64afb258fb60233b ON planificacion.tbn_periodo (tipo_plan_id)');
        $this->addSql('CREATE TABLE planificacion.tbn_tipo_desglose (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, token_tipo_desglose VARCHAR(255) NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE planificacion.tbn_periodo_desglose (id INT NOT NULL, tipo_desglose_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion TEXT DEFAULT NULL, activo BOOLEAN NOT NULL, siglas VARCHAR(12) NOT NULL, orden INT NOT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1407240345ef93a ON planificacion.tbn_periodo_desglose (tipo_desglose_id)');
        $this->addSql('ALTER TABLE planificacion.tbn_periodo ADD CONSTRAINT fk_64afb258fb60233b FOREIGN KEY (tipo_plan_id) REFERENCES planificacion.tbn_tipo_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbn_periodo_desglose ADD CONSTRAINT fk_1407240345ef93a FOREIGN KEY (tipo_desglose_id) REFERENCES planificacion.tbn_tipo_desglose (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE planificacion.tbr_plan_objetivo_especifico');
        $this->addSql('DROP TABLE planificacion.tbr_plan_objetivo_general');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD periodo_id INT NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD tipo_desglose_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP periodo');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT fk_6ef526039c3921ab FOREIGN KEY (periodo_id) REFERENCES planificacion.tbn_periodo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT fk_6ef5260345ef93a FOREIGN KEY (tipo_desglose_id) REFERENCES planificacion.tbn_tipo_desglose (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6ef5260345ef93a ON planificacion.tbd_plan (tipo_desglose_id)');
        $this->addSql('CREATE INDEX idx_6ef526039c3921ab ON planificacion.tbd_plan (periodo_id)');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD periodo_desglose_id INT NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_plan_desglose ADD CONSTRAINT fk_69f4d43c4b133677 FOREIGN KEY (periodo_desglose_id) REFERENCES planificacion.tbn_periodo_desglose (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_69f4d43c4b133677 ON planificacion.tbd_plan_desglose (periodo_desglose_id)');
    }
}
