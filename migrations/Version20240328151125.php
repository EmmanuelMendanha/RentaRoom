<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328151125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD user_id INT DEFAULT NULL, DROP final_price');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495C872AB0');
        $this->addSql('DROP INDEX IDX_8D93D6495C872AB0 ON user');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, DROP booking_users_id, DROP firstname, CHANGE name name VARCHAR(50) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP INDEX IDX_E00CEDDEA76ED395 ON booking');
        $this->addSql('ALTER TABLE booking ADD final_price NUMERIC(10, 2) NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE user ADD booking_users_id INT DEFAULT NULL, ADD firstname VARCHAR(255) DEFAULT NULL, DROP is_verified, CHANGE name name VARCHAR(50) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495C872AB0 FOREIGN KEY (booking_users_id) REFERENCES booking (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6495C872AB0 ON user (booking_users_id)');
    }
}
