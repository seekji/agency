<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201002625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE aizek_id_seq CASCADE');
        $this->addSql('DROP TABLE aizek');
        $this->addSql('ALTER TABLE media ADD technology_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6A2CA10C4235D463 ON media (technology_id)');
        $this->addSql('ALTER TABLE technology ADD picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE technology ADD CONSTRAINT FK_F463524DEE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F463524DEE45BDBF ON technology (picture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE aizek_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aizek (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C4235D463');
        $this->addSql('DROP INDEX IDX_6A2CA10C4235D463');
        $this->addSql('ALTER TABLE media DROP technology_id');
        $this->addSql('ALTER TABLE technology DROP CONSTRAINT FK_F463524DEE45BDBF');
        $this->addSql('DROP INDEX IDX_F463524DEE45BDBF');
        $this->addSql('ALTER TABLE technology DROP picture_id');
    }
}
