<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609143828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE planificacion.tbr_plan_indicador_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE planificacion.tbr_plan_indicador (id INT NOT NULL, plan_id INT NOT NULL, indicador_id INT NOT NULL, forma_evaluacion_id INT NOT NULL, evaluacion_id INT DEFAULT NULL, responsable_id INT NOT NULL, plan_valor DOUBLE PRECISION NOT NULL, plan_real DOUBLE PRECISION DEFAULT NULL, creado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actualizado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_43E6A518E899029B ON planificacion.tbr_plan_indicador (plan_id)');
        $this->addSql('CREATE INDEX IDX_43E6A51847D487D1 ON planificacion.tbr_plan_indicador (indicador_id)');
        $this->addSql('CREATE INDEX IDX_43E6A518DF54F6F6 ON planificacion.tbr_plan_indicador (forma_evaluacion_id)');
        $this->addSql('CREATE INDEX IDX_43E6A518E715F406 ON planificacion.tbr_plan_indicador (evaluacion_id)');
        $this->addSql('CREATE INDEX IDX_43E6A51853C59D72 ON planificacion.tbr_plan_indicador (responsable_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_43E6A518E899029B47D487D1 ON planificacion.tbr_plan_indicador (plan_id, indicador_id)');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A518E899029B FOREIGN KEY (plan_id) REFERENCES planificacion.tbd_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A51847D487D1 FOREIGN KEY (indicador_id) REFERENCES planificacion.tbd_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A518DF54F6F6 FOREIGN KEY (forma_evaluacion_id) REFERENCES planificacion.tbd_forma_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A518E715F406 FOREIGN KEY (evaluacion_id) REFERENCES planificacion.tbn_evaluacion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE planificacion.tbr_plan_indicador ADD CONSTRAINT FK_43E6A51853C59D72 FOREIGN KEY (responsable_id) REFERENCES personal.tbd_persona (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE planificacion.tbr_plan_indicador_id_seq CASCADE');
        $this->addSql('DROP TABLE planificacion.tbr_plan_indicador');
    }
}
