<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201001457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blocks ADD picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blocks ADD CONSTRAINT FK_CEED9578EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CEED9578EE45BDBF ON blocks (picture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blocks DROP CONSTRAINT FK_CEED9578EE45BDBF');
        $this->addSql('DROP INDEX IDX_CEED9578EE45BDBF');
        $this->addSql('ALTER TABLE blocks DROP picture_id');
    }
}
