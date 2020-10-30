<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201030234008 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE branch_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cases_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE branch (id INT NOT NULL, title VARCHAR(255) NOT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cases (id INT NOT NULL, branch_id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1C1B038BDCD6CC49 ON cases (branch_id)');
        $this->addSql('CREATE TABLE cases_service (cases_id INT NOT NULL, service_id INT NOT NULL, PRIMARY KEY(cases_id, service_id))');
        $this->addSql('CREATE INDEX IDX_666D70652A69AB62 ON cases_service (cases_id)');
        $this->addSql('CREATE INDEX IDX_666D7065ED5CA9E6 ON cases_service (service_id)');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, name VARCHAR(255) NOT NULL, about TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, title VARCHAR(255) NOT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038BDCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases_service ADD CONSTRAINT FK_666D70652A69AB62 FOREIGN KEY (cases_id) REFERENCES cases (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases_service ADD CONSTRAINT FK_666D7065ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038BDCD6CC49');
        $this->addSql('ALTER TABLE cases_service DROP CONSTRAINT FK_666D70652A69AB62');
        $this->addSql('ALTER TABLE cases_service DROP CONSTRAINT FK_666D7065ED5CA9E6');
        $this->addSql('DROP SEQUENCE branch_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cases_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('DROP TABLE branch');
        $this->addSql('DROP TABLE cases');
        $this->addSql('DROP TABLE cases_service');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE service');
    }
}
