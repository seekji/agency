<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031160224 extends AbstractMigration
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
        $this->addSql('CREATE SEQUENCE media__gallery_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media__gallery_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media__media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE partner_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE site_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE branch (id INT NOT NULL, title VARCHAR(255) NOT NULL, sort INT NOT NULL, locale VARCHAR(3) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cases (id INT NOT NULL, branch_id INT NOT NULL, preview_picture_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, excerpt TEXT DEFAULT NULL, locale VARCHAR(3) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1C1B038BDCD6CC49 ON cases (branch_id)');
        $this->addSql('CREATE INDEX IDX_1C1B038BFE49D60A ON cases (preview_picture_id)');
        $this->addSql('CREATE TABLE cases_service (cases_id INT NOT NULL, service_id INT NOT NULL, PRIMARY KEY(cases_id, service_id))');
        $this->addSql('CREATE INDEX IDX_666D70652A69AB62 ON cases_service (cases_id)');
        $this->addSql('CREATE INDEX IDX_666D7065ED5CA9E6 ON cases_service (service_id)');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, name VARCHAR(255) NOT NULL, about TEXT DEFAULT NULL, locale VARCHAR(3) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE media__gallery (id INT NOT NULL, name VARCHAR(255) NOT NULL, context VARCHAR(64) NOT NULL, default_format VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE media__gallery_media (id INT NOT NULL, gallery_id INT DEFAULT NULL, media_id INT DEFAULT NULL, position INT NOT NULL, enabled BOOLEAN NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_80D4C5414E7AF8F ON media__gallery_media (gallery_id)');
        $this->addSql('CREATE INDEX IDX_80D4C541EA9FDD75 ON media__gallery_media (media_id)');
        $this->addSql('CREATE TABLE media__media (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, enabled BOOLEAN NOT NULL, provider_name VARCHAR(255) NOT NULL, provider_status INT NOT NULL, provider_reference VARCHAR(255) NOT NULL, provider_metadata JSON DEFAULT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, length NUMERIC(10, 0) DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, content_size INT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, context VARCHAR(64) DEFAULT NULL, cdn_is_flushable BOOLEAN DEFAULT NULL, cdn_flush_identifier VARCHAR(64) DEFAULT NULL, cdn_flush_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, cdn_status INT DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE partner (id INT NOT NULL, picture_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, sort INT NOT NULL, is_active BOOLEAN NOT NULL, locale VARCHAR(3) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_312B3E16EE45BDBF ON partner (picture_id)');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, title VARCHAR(255) NOT NULL, sort INT NOT NULL, locale VARCHAR(3) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE site_user (id INT NOT NULL, name VARCHAR(50) DEFAULT NULL, username VARCHAR(255) NOT NULL, surname VARCHAR(100) DEFAULT NULL, email VARCHAR(255) NOT NULL, about TEXT DEFAULT NULL, email_confirmed BOOLEAN DEFAULT \'false\' NOT NULL, enabled BOOLEAN DEFAULT \'false\' NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6096BB0F85E0677 ON site_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6096BB0E7927C74 ON site_user (email)');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038BDCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038BFE49D60A FOREIGN KEY (preview_picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases_service ADD CONSTRAINT FK_666D70652A69AB62 FOREIGN KEY (cases_id) REFERENCES cases (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases_service ADD CONSTRAINT FK_666D7065ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038BDCD6CC49');
        $this->addSql('ALTER TABLE cases_service DROP CONSTRAINT FK_666D70652A69AB62');
        $this->addSql('ALTER TABLE media__gallery_media DROP CONSTRAINT FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038BFE49D60A');
        $this->addSql('ALTER TABLE media__gallery_media DROP CONSTRAINT FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE partner DROP CONSTRAINT FK_312B3E16EE45BDBF');
        $this->addSql('ALTER TABLE cases_service DROP CONSTRAINT FK_666D7065ED5CA9E6');
        $this->addSql('DROP SEQUENCE branch_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cases_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media__gallery_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media__gallery_media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media__media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE partner_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE site_user_id_seq CASCADE');
        $this->addSql('DROP TABLE branch');
        $this->addSql('DROP TABLE cases');
        $this->addSql('DROP TABLE cases_service');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE media__gallery');
        $this->addSql('DROP TABLE media__gallery_media');
        $this->addSql('DROP TABLE media__media');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE site_user');
    }
}
