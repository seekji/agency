<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202144937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seo_rules DROP meta_tags');
        $this->addSql('ALTER TABLE seo_rules DROP extra');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seo_rules ADD meta_tags TEXT NOT NULL');
        $this->addSql('ALTER TABLE seo_rules ADD extra TEXT NOT NULL');
        $this->addSql('COMMENT ON COLUMN seo_rules.meta_tags IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN seo_rules.extra IS \'(DC2Type:array)\'');
    }
}
