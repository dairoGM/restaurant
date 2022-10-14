<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608144507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad DROP hora_inicio');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_inicio TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_inicio DROP DEFAULT');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_fin TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_fin DROP DEFAULT');
        $this->addSql('ALTER TABLE personal.tbn_carrera ADD nivel_escolar_id INT NOT NULL');
        $this->addSql('ALTER TABLE personal.tbn_carrera ADD CONSTRAINT FK_D3C253165873B5B9 FOREIGN KEY (nivel_escolar_id) REFERENCES personal.tbn_nivel_escolar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D3C253165873B5B9 ON personal.tbn_carrera (nivel_escolar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ADD hora_inicio TIME(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_inicio TYPE DATE');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_inicio DROP DEFAULT');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_fin TYPE DATE');
        $this->addSql('ALTER TABLE plan_actividades.tbd_actividad ALTER fecha_fin DROP DEFAULT');
        $this->addSql('ALTER TABLE personal.tbn_carrera DROP CONSTRAINT FK_D3C253165873B5B9');
        $this->addSql('DROP INDEX IDX_D3C253165873B5B9');
        $this->addSql('ALTER TABLE personal.tbn_carrera DROP nivel_escolar_id');
    }
}
