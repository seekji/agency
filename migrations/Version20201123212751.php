<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123212751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE page_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE page_treatments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE page (id INT NOT NULL, title VARCHAR(255) NOT NULL, type INT NOT NULL, coordinates VARCHAR(255) DEFAULT NULL, excerpt TEXT DEFAULT NULL, is_published BOOLEAN NOT NULL, description TEXT DEFAULT NULL, achievements JSON DEFAULT NULL, history JSON DEFAULT NULL, locale VARCHAR(3) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE page_specialist (page_id INT NOT NULL, specialist_id INT NOT NULL, PRIMARY KEY(page_id, specialist_id))');
        $this->addSql('CREATE INDEX IDX_C9C77B6AC4663E4 ON page_specialist (page_id)');
        $this->addSql('CREATE INDEX IDX_C9C77B6A7B100C1A ON page_specialist (specialist_id)');
        $this->addSql('CREATE TABLE page_treatments (id INT NOT NULL, page_id INT DEFAULT NULL, picture_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, sort INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_41A8FF93C4663E4 ON page_treatments (page_id)');
        $this->addSql('CREATE INDEX IDX_41A8FF93EE45BDBF ON page_treatments (picture_id)');
        $this->addSql('ALTER TABLE page_specialist ADD CONSTRAINT FK_C9C77B6AC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_specialist ADD CONSTRAINT FK_C9C77B6A7B100C1A FOREIGN KEY (specialist_id) REFERENCES specialist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_treatments ADD CONSTRAINT FK_41A8FF93C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_treatments ADD CONSTRAINT FK_41A8FF93EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_specialist DROP CONSTRAINT FK_C9C77B6AC4663E4');
        $this->addSql('ALTER TABLE page_treatments DROP CONSTRAINT FK_41A8FF93C4663E4');
        $this->addSql('DROP SEQUENCE page_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE page_treatments_id_seq CASCADE');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_specialist');
        $this->addSql('DROP TABLE page_treatments');
    }
}
