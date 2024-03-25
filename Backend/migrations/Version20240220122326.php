<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Communities migration.
 */
final class Version20240220122326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE community_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community (id INT NOT NULL, creator_id INT DEFAULT NULL, name VARCHAR(21) NOT NULL, description VARCHAR(500) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(10) NOT NULL, send_welcome_message BOOLEAN NOT NULL, is_nsfw BOOLEAN NOT NULL, amount_of_members INT NOT NULL, welcome_message_text TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B6040335E237E06 ON community (name)');
        $this->addSql('CREATE INDEX IDX_1B60403361220EA6 ON community (creator_id)');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT FK_1B60403361220EA6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE community_id_seq CASCADE');
        $this->addSql('ALTER TABLE community DROP CONSTRAINT FK_1B60403361220EA6');
        $this->addSql('DROP TABLE community');
    }
}
