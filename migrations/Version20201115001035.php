<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201115001035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases ADD is_active BOOLEAN NOT NULL default true');
        $this->addSql('ALTER TABLE cases ADD is_item_big BOOLEAN NOT NULL default false');
        $this->addSql('ALTER TABLE cases ADD is_show_on_homepage BOOLEAN NOT NULL default true');
        $this->addSql('ALTER TABLE cases ADD sort INT NOT NULL default 0');
        $this->addSql('ALTER TABLE cases ADD task_title VARCHAR(255) NOT NULL default \'\'');
        $this->addSql('ALTER TABLE cases ADD achievements JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD slide_title VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases DROP is_active');
        $this->addSql('ALTER TABLE cases DROP is_item_big');
        $this->addSql('ALTER TABLE cases DROP is_show_on_homepage');
        $this->addSql('ALTER TABLE cases DROP sort');
        $this->addSql('ALTER TABLE cases DROP task_title');
        $this->addSql('ALTER TABLE cases DROP achievements');
        $this->addSql('ALTER TABLE cases DROP slide_title');
    }
}
