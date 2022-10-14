<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608232829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP CONSTRAINT fk_f69ff0af487d9d1');
        $this->addSql('DROP INDEX IF EXISTS planificacion.idx_f69ff0af487d9d1');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP tipo_indicador_id');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador DROP siglas');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD tipo_indicador_id INT NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD siglas VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE planificacion.tbd_indicador ADD CONSTRAINT fk_f69ff0af487d9d1 FOREIGN KEY (tipo_indicador_id) REFERENCES planificacion.tbn_tipo_indicador (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f69ff0af487d9d1 ON planificacion.tbd_indicador (tipo_indicador_id)');
    }
}
