<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201115004844 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE case_block_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE case_block (id INT NOT NULL, media_id INT DEFAULT NULL, cases_id INT DEFAULT NULL, type INT NOT NULL, text TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D1F26DCEEA9FDD75 ON case_block (media_id)');
        $this->addSql('CREATE INDEX IDX_D1F26DCE2A69AB62 ON case_block (cases_id)');
        $this->addSql('ALTER TABLE case_block ADD CONSTRAINT FK_D1F26DCEEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE case_block ADD CONSTRAINT FK_D1F26DCE2A69AB62 FOREIGN KEY (cases_id) REFERENCES cases (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE case_block_id_seq CASCADE');
        $this->addSql('DROP TABLE case_block');
    }
}
