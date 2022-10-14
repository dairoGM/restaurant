<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428191502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA seguridad');
        $this->addSql('CREATE SCHEMA estructura');
        $this->addSql('CREATE SCHEMA personal');
        $this->addSql('CREATE SCHEMA planificacion');
        $this->addSql('CREATE SCHEMA plan_actividades');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SCHEMA seguridad');
        $this->addSql('DROP SCHEMA estructura');
        $this->addSql('DROP SCHEMA personal');
        $this->addSql('DROP SCHEMA planificacion');
        $this->addSql('DROP SCHEMA plan_actividades');
    }
}
