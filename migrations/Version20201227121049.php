<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201227121049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technology ADD preview_picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE technology ADD CONSTRAINT FK_F463524DFE49D60A FOREIGN KEY (preview_picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F463524DFE49D60A ON technology (preview_picture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technology DROP CONSTRAINT FK_F463524DFE49D60A');
        $this->addSql('DROP INDEX IDX_F463524DFE49D60A');
        $this->addSql('ALTER TABLE technology DROP preview_picture_id');
    }
}
