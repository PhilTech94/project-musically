<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260221202520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, phone VARCHAR(20) NOT NULL, email VARCHAR(180) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE billing_sound (id INT AUTO_INCREMENT NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, sound_id INT NOT NULL, billing_id INT NOT NULL, INDEX IDX_FDF1E6A96AAA5C3E (sound_id), INDEX IDX_FDF1E6A93B025C87 (billing_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sound (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, category_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_F88EC38412469DE2 (category_id), INDEX IDX_F88EC384BACD6074 (style_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE billing_sound ADD CONSTRAINT FK_FDF1E6A96AAA5C3E FOREIGN KEY (sound_id) REFERENCES sound (id)');
        $this->addSql('ALTER TABLE billing_sound ADD CONSTRAINT FK_FDF1E6A93B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC38412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC384BACD6074 FOREIGN KEY (style_id) REFERENCES style (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing_sound DROP FOREIGN KEY FK_FDF1E6A96AAA5C3E');
        $this->addSql('ALTER TABLE billing_sound DROP FOREIGN KEY FK_FDF1E6A93B025C87');
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC38412469DE2');
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC384BACD6074');
        $this->addSql('DROP TABLE billing');
        $this->addSql('DROP TABLE billing_sound');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE sound');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
