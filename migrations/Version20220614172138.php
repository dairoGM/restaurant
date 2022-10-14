<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614172138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE planificacion.tbr_plan_indicador_entidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbr_plan_indicador_entidad (id INT NOT NULL, plan_id INT NOT NULL, indicador_id INT NOT NULL, entidad_id INT NOT NULL, plan_valor DOUBLE PRECISION DEFAULT NULL, plan_real DOUBLE PRECISION DEFAULT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_544C5DE7E899029B ON planificacion.tbr_plan_indicador_entidad (plan_id)');
        $this->addSql('CREATE INDEX IDX_544C5DE747D487D1 ON planificacion.tbr_plan_indicador_entidad (indicador_id)');
        $this->addSql('CREATE INDEX IDX_544C5DE76CA204EF ON planificacion.tbr_plan_indicador_entidad (entidad_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_544C5DE7E899029B47D487D16CA204EF ON planificacion.tbr_plan_indicador_entidad (plan_id, indicador_id, entidad_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD CONSTRAINT FK_544C5DE7E899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD CONSTRAINT FK_544C5DE747D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador_entidad ADD CONSTRAINT FK_544C5DE76CA204EF FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP CONSTRAINT FK_AB79ADA64E7121AF');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD entidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD CONSTRAINT FK_AB79ADA66CA204EF FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_estructura (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD CONSTRAINT FK_AB79ADA64E7121AF FOREIGN KEY (provincia_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AB79ADA66CA204EF ON estructura.tbd_entidad (entidad_id)');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP CONSTRAINT fk_bf47ab854e7121af');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP CONSTRAINT fk_bf47ab8558bc1be0');
        $this->addSql('DROP INDEX estructura.idx_bf47ab8558bc1be0');
        $this->addSql('DROP INDEX estructura.idx_bf47ab854e7121af');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP provincia_id');
        $this->addSql('ALTER TABLE estructura.tbd_estructura DROP municipio_id');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD entidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ALTER periodo TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ALTER periodo DROP DEFAULT');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ADD CONSTRAINT FK_6EF526036CA204EF FOREIGN KEY (entidad_id) REFERENCES estructura.tbd_entidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6EF526036CA204EF ON planificacion.tbd_plan (entidad_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE planificacion.tbr_plan_indicador_entidad_id_seq CASCADE');
        $this->addSql('DROP TABLE planificacion.tbr_plan_indicador_entidad');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD provincia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD municipio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD CONSTRAINT fk_bf47ab854e7121af FOREIGN KEY (provincia_id) REFERENCES estructura.tbn_provincia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE estructura.tbd_estructura ADD CONSTRAINT fk_bf47ab8558bc1be0 FOREIGN KEY (municipio_id) REFERENCES estructura.tbn_municipio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_bf47ab8558bc1be0 ON estructura.tbd_estructura (municipio_id)');
        $this->addSql('CREATE INDEX idx_bf47ab854e7121af ON estructura.tbd_estructura (provincia_id)');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP CONSTRAINT FK_AB79ADA66CA204EF');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP CONSTRAINT fk_ab79ada64e7121af');
        $this->addSql('DROP INDEX IDX_AB79ADA66CA204EF');
        $this->addSql('ALTER TABLE estructura.tbd_entidad DROP entidad_id');
        $this->addSql('ALTER TABLE estructura.tbd_entidad ADD CONSTRAINT fk_ab79ada64e7121af FOREIGN KEY (provincia_id) REFERENCES estructura.tbn_provincia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP CONSTRAINT FK_6EF526036CA204EF');
        $this->addSql('DROP INDEX IDX_6EF526036CA204EF');
        $this->addSql('ALTER TABLE planificacion.tbd_plan DROP entidad_id');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ALTER periodo TYPE DATE');
        $this->addSql('ALTER TABLE planificacion.tbd_plan ALTER periodo DROP DEFAULT');
    }
}
