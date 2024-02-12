<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212155629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE community_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community (id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(500) DEFAULT NULL, number_of_users INT NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, status VARCHAR(10) NOT NULL, send_welcome_message BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B6040335E237E06 ON community (name)');
        $this->addSql('CREATE INDEX IDX_1B6040337E3C61F9 ON community (owner_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, nickname VARCHAR(50) NOT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(200) NOT NULL, login VARCHAR(50) NOT NULL, birthday DATE NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A188FE64 ON "user" (nickname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT FK_1B6040337E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE community_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE community DROP CONSTRAINT FK_1B6040337E3C61F9');
        $this->addSql('DROP TABLE community');
        $this->addSql('DROP TABLE "user"');
    }
}
