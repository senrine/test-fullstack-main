<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726092841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clocking (date DATE NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, clocking_user_id INTEGER NOT NULL, CONSTRAINT FK_D3E9DCCDA1F846FC FOREIGN KEY (clocking_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D3E9DCCDA1F846FC ON clocking (clocking_user_id)');
        $this->addSql('CREATE TABLE clocking_detail (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, duration INTEGER NOT NULL, project_id INTEGER NOT NULL, clocking_id INTEGER NOT NULL, CONSTRAINT FK_E2609D6166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E2609D6B6D103F FOREIGN KEY (clocking_id) REFERENCES clocking (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E2609D6166D1F9C ON clocking_detail (project_id)');
        $this->addSql('CREATE INDEX IDX_E2609D6B6D103F ON clocking_detail (clocking_id)');
        $this->addSql('CREATE TABLE project (address VARCHAR(255) NOT NULL, date_end DATE DEFAULT NULL, date_start DATE NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE "user" (first_name VARCHAR(255) NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64912B2DC9C ON "user" (matricule)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE clocking');
        $this->addSql('DROP TABLE clocking_detail');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
