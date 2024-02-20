<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Memberships migration.
 */
final class Version20240220122939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE membership_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE membership (id INT NOT NULL, subreddit_id INT NOT NULL, member_id INT NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_86FFD28531DBE174 ON membership (subreddit_id)');
        $this->addSql('CREATE INDEX IDX_86FFD2857597D3FE ON membership (member_id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD28531DBE174 FOREIGN KEY (subreddit_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD2857597D3FE FOREIGN KEY (member_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE membership_id_seq CASCADE');
        $this->addSql('ALTER TABLE membership DROP CONSTRAINT FK_86FFD28531DBE174');
        $this->addSql('ALTER TABLE membership DROP CONSTRAINT FK_86FFD2857597D3FE');
        $this->addSql('DROP TABLE membership');
    }
}
