<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201115003102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE specialist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE specialist (id INT NOT NULL, picture_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, quote TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C2274AF4EE45BDBF ON specialist (picture_id)');
        $this->addSql('ALTER TABLE specialist ADD CONSTRAINT FK_C2274AF4EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases ADD detail_media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD specialist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD similar_case_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD offer TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD tools TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038B1C4134AE FOREIGN KEY (detail_media_id) REFERENCES media__media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038B7B100C1A FOREIGN KEY (specialist_id) REFERENCES specialist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cases ADD CONSTRAINT FK_1C1B038B7A9945E1 FOREIGN KEY (similar_case_id) REFERENCES cases (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1C1B038B1C4134AE ON cases (detail_media_id)');
        $this->addSql('CREATE INDEX IDX_1C1B038B7B100C1A ON cases (specialist_id)');
        $this->addSql('CREATE INDEX IDX_1C1B038B19EB6921 ON cases (client_id)');
        $this->addSql('CREATE INDEX IDX_1C1B038B7A9945E1 ON cases (similar_case_id)');
        $this->addSql('ALTER TABLE client ADD picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C7440455EE45BDBF ON client (picture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038B7B100C1A');
        $this->addSql('DROP SEQUENCE specialist_id_seq CASCADE');
        $this->addSql('DROP TABLE specialist');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455EE45BDBF');
        $this->addSql('DROP INDEX IDX_C7440455EE45BDBF');
        $this->addSql('ALTER TABLE client DROP picture_id');
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038B1C4134AE');
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038B19EB6921');
        $this->addSql('ALTER TABLE cases DROP CONSTRAINT FK_1C1B038B7A9945E1');
        $this->addSql('DROP INDEX IDX_1C1B038B1C4134AE');
        $this->addSql('DROP INDEX IDX_1C1B038B7B100C1A');
        $this->addSql('DROP INDEX IDX_1C1B038B19EB6921');
        $this->addSql('DROP INDEX IDX_1C1B038B7A9945E1');
        $this->addSql('ALTER TABLE cases DROP detail_media_id');
        $this->addSql('ALTER TABLE cases DROP specialist_id');
        $this->addSql('ALTER TABLE cases DROP client_id');
        $this->addSql('ALTER TABLE cases DROP similar_case_id');
        $this->addSql('ALTER TABLE cases DROP offer');
        $this->addSql('ALTER TABLE cases DROP tools');
    }
}
