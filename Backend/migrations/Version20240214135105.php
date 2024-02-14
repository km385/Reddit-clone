<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214135105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE community DROP CONSTRAINT fk_1b6040337e3c61f9');
        $this->addSql('DROP INDEX idx_1b6040337e3c61f9');
        $this->addSql('ALTER TABLE community RENAME COLUMN owner_id TO creator_id');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT FK_1B60403361220EA6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1B60403361220EA6 ON community (creator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE community DROP CONSTRAINT FK_1B60403361220EA6');
        $this->addSql('DROP INDEX IDX_1B60403361220EA6');
        $this->addSql('ALTER TABLE community RENAME COLUMN creator_id TO owner_id');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT fk_1b6040337e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1b6040337e3c61f9 ON community (owner_id)');
    }
}
