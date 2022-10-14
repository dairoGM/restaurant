<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603205812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE plan_actividades.tbr_responsable_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP CONSTRAINT FK_316FA52FF5F88DB9');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP CONSTRAINT FK_316FA52F6014FACA');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP CONSTRAINT tbr_responsable_pkey');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD CONSTRAINT FK_316FA52FF5F88DB9 FOREIGN KEY (persona_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD CONSTRAINT FK_316FA52F6014FACA FOREIGN KEY (actividad_id) REFERENCES plan_actividades.tbd_actividad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE plan_actividades.tbr_responsable_id_seq CASCADE');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP CONSTRAINT fk_316fa52ff5f88db9');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP CONSTRAINT fk_316fa52f6014faca');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP CONSTRAINT tbr_responsable_pkey');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP id');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP creado');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable DROP actualizado');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD CONSTRAINT fk_316fa52ff5f88db9 FOREIGN KEY (persona_id) REFERENCES plan_actividades.tbd_actividad (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD CONSTRAINT fk_316fa52f6014faca FOREIGN KEY (actividad_id) REFERENCES personal.tbd_persona (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plan_actividades.tbr_responsable ADD PRIMARY KEY (persona_id, actividad_id)');
    }
}
