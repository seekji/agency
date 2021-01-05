<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105212902 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases ADD preview_big_picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038B50015E58 FOREIGN KEY (preview_big_picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1C1B038B50015E58 ON cases (preview_big_picture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038B50015E58');
        $this->addSql('DROP INDEX IDX_1C1B038B50015E58');
        $this->addSql('ALTER TABLE cases DROP preview_big_picture_id');
    }
}
