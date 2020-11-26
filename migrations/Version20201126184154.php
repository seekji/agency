<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126184154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases DROP slide_title');
        $this->addSql('ALTER TABLE settings ADD terms VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE settings ALTER privacy TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE settings ALTER privacy DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases ADD slide_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE settings DROP terms');
        $this->addSql('ALTER TABLE settings ALTER privacy TYPE TEXT');
        $this->addSql('ALTER TABLE settings ALTER privacy DROP DEFAULT');
    }
}
