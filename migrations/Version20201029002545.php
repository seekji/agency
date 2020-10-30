<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029002545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE site_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE site_user (id INT NOT NULL, name VARCHAR(50) DEFAULT NULL, username VARCHAR(255) NOT NULL, surname VARCHAR(100) DEFAULT NULL, email VARCHAR(255) NOT NULL, about TEXT DEFAULT NULL, email_confirmed BOOLEAN DEFAULT \'false\' NOT NULL, enabled BOOLEAN DEFAULT \'false\' NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6096BB0F85E0677 ON site_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6096BB0E7927C74 ON site_user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE site_user_id_seq CASCADE');
        $this->addSql('DROP TABLE site_user');
    }
}
