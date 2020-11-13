<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110200346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE seo_redirect_rules (id VARCHAR(255) NOT NULL, source_template VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, code INT NOT NULL, priority INT NOT NULL, stopped BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE seo_rules (id VARCHAR(255) NOT NULL, pattern VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, meta_tags TEXT NOT NULL, extra TEXT NOT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN seo_rules.meta_tags IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN seo_rules.extra IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE seo_redirect_rules');
        $this->addSql('DROP TABLE seo_rules');
    }
}
