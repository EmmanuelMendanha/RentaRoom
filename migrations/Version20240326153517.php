<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326153517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ergonomy CHANGE decription decription VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE room CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, DROP role, CHANGE email email VARCHAR(180) NOT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ergonomy CHANGE decription decription VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL, DROP roles, CHANGE email email VARCHAR(80) NOT NULL, CHANGE phone phone VARCHAR(80) DEFAULT NULL');
    }
}
