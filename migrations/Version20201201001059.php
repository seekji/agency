<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201001059 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE aizek_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE blocks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE technology_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aizek (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE blocks (id INT NOT NULL, technology_id INT NOT NULL, group_name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, text TEXT DEFAULT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CEED95784235D463 ON blocks (technology_id)');
        $this->addSql('CREATE TABLE technology (id INT NOT NULL, media_id INT DEFAULT NULL, aizek_picture_block_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, excerpt TEXT NOT NULL, is_active BOOLEAN NOT NULL, sort INT NOT NULL, type INT NOT NULL, aizek_text TEXT DEFAULT NULL, aizek_achievements JSON DEFAULT NULL, aizek_achievements_title VARCHAR(255) DEFAULT NULL, locale VARCHAR(3) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F463524DEA9FDD75 ON technology (media_id)');
        $this->addSql('CREATE INDEX IDX_F463524D121F4252 ON technology (aizek_picture_block_id)');
        $this->addSql('ALTER TABLE blocks ADD CONSTRAINT FK_CEED95784235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE technology ADD CONSTRAINT FK_F463524DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE technology ADD CONSTRAINT FK_F463524D121F4252 FOREIGN KEY (aizek_picture_block_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blocks DROP CONSTRAINT FK_CEED95784235D463');
        $this->addSql('DROP SEQUENCE aizek_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE blocks_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE technology_id_seq CASCADE');
        $this->addSql('DROP TABLE aizek');
        $this->addSql('DROP TABLE blocks');
        $this->addSql('DROP TABLE technology');
    }
}
