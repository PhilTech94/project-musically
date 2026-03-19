<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260312152645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute firstname, lastname, phone à user et url à sound';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(100) DEFAULT NULL, ADD lastname VARCHAR(100) DEFAULT NULL, ADD phone VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE sound ADD url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP phone');
        $this->addSql('ALTER TABLE sound DROP url');
    }
}
