<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327142813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP final_price');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, DROP firstname, CHANGE name name VARCHAR(50) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD final_price NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) DEFAULT NULL, DROP is_verified, CHANGE name name VARCHAR(50) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL');
    }
}
