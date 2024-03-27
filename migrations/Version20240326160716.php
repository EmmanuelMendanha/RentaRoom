<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326160716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room CHANGE image_main image_main VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD booking_users_id INT DEFAULT NULL, ADD name VARCHAR(50) NOT NULL, ADD phone VARCHAR(20) DEFAULT NULL, ADD address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495C872AB0 FOREIGN KEY (booking_users_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495C872AB0 ON user (booking_users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room CHANGE image_main image_main VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495C872AB0');
        $this->addSql('DROP INDEX IDX_8D93D6495C872AB0 ON user');
        $this->addSql('ALTER TABLE user DROP booking_users_id, DROP name, DROP phone, DROP address');
    }
}
