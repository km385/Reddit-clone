<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215121724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE thread_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE thread (id INT NOT NULL, author_id INT DEFAULT NULL, community_id INT NOT NULL, title VARCHAR(300) NOT NULL, content TEXT DEFAULT NULL, status VARCHAR(16) NOT NULL, type VARCHAR(6) NOT NULL, is_nsfw BOOLEAN NOT NULL, is_spoiler BOOLEAN NOT NULL, is_locked BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_31204C83F675F31B ON thread (author_id)');
        $this->addSql('CREATE INDEX IDX_31204C83FDA7B0BF ON thread (community_id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community ALTER name TYPE VARCHAR(21)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE thread_id_seq CASCADE');
        $this->addSql('ALTER TABLE thread DROP CONSTRAINT FK_31204C83F675F31B');
        $this->addSql('ALTER TABLE thread DROP CONSTRAINT FK_31204C83FDA7B0BF');
        $this->addSql('DROP TABLE thread');
        $this->addSql('ALTER TABLE community ALTER name TYPE VARCHAR(100)');
    }
}
