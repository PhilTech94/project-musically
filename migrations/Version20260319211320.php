<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260319211320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration vide car colonnes deja presentes et relation billing-user abandonnee';
    }

    public function up(Schema $schema): void
    {
        // Rien a faire
    }

    public function down(Schema $schema): void
    {
        // Rien a faire
    }
}
