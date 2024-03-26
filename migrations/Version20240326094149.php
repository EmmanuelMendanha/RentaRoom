<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326094149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, date_in DATETIME NOT NULL, date_out DATETIME NOT NULL, final_price NUMERIC(10, 2) NOT NULL, status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, icone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_software (equipment_id INT NOT NULL, software_id INT NOT NULL, INDEX IDX_4713ECE9517FE9FE (equipment_id), INDEX IDX_4713ECE9D7452741 (software_id), PRIMARY KEY(equipment_id, software_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ergonomy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, decription VARCHAR(255) NOT NULL, icone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, surface INT NOT NULL, description VARCHAR(255) NOT NULL, title VARCHAR(50) NOT NULL, capacity INT NOT NULL, address VARCHAR(80) NOT NULL, price NUMERIC(10, 2) NOT NULL, image_main VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_booking (room_id INT NOT NULL, booking_id INT NOT NULL, INDEX IDX_C2E513E54177093 (room_id), INDEX IDX_C2E513E3301C60 (booking_id), PRIMARY KEY(room_id, booking_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_ergonomy (room_id INT NOT NULL, ergonomy_id INT NOT NULL, INDEX IDX_49537F5154177093 (room_id), INDEX IDX_49537F5145CF4AB6 (ergonomy_id), PRIMARY KEY(room_id, ergonomy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_equipment (room_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_4F9135EA54177093 (room_id), INDEX IDX_4F9135EA517FE9FE (equipment_id), PRIMARY KEY(room_id, equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_image (room_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_8F81A5F454177093 (room_id), INDEX IDX_8F81A5F43DA5256D (image_id), PRIMARY KEY(room_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE software (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, booking_users_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(80) NOT NULL, phone VARCHAR(80) NOT NULL, password VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_8D93D6495C872AB0 (booking_users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment_software ADD CONSTRAINT FK_4713ECE9517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_software ADD CONSTRAINT FK_4713ECE9D7452741 FOREIGN KEY (software_id) REFERENCES software (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_booking ADD CONSTRAINT FK_C2E513E54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_booking ADD CONSTRAINT FK_C2E513E3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_ergonomy ADD CONSTRAINT FK_49537F5154177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_ergonomy ADD CONSTRAINT FK_49537F5145CF4AB6 FOREIGN KEY (ergonomy_id) REFERENCES ergonomy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_equipment ADD CONSTRAINT FK_4F9135EA54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_equipment ADD CONSTRAINT FK_4F9135EA517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_image ADD CONSTRAINT FK_8F81A5F454177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_image ADD CONSTRAINT FK_8F81A5F43DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495C872AB0 FOREIGN KEY (booking_users_id) REFERENCES booking (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_software DROP FOREIGN KEY FK_4713ECE9517FE9FE');
        $this->addSql('ALTER TABLE equipment_software DROP FOREIGN KEY FK_4713ECE9D7452741');
        $this->addSql('ALTER TABLE room_booking DROP FOREIGN KEY FK_C2E513E54177093');
        $this->addSql('ALTER TABLE room_booking DROP FOREIGN KEY FK_C2E513E3301C60');
        $this->addSql('ALTER TABLE room_ergonomy DROP FOREIGN KEY FK_49537F5154177093');
        $this->addSql('ALTER TABLE room_ergonomy DROP FOREIGN KEY FK_49537F5145CF4AB6');
        $this->addSql('ALTER TABLE room_equipment DROP FOREIGN KEY FK_4F9135EA54177093');
        $this->addSql('ALTER TABLE room_equipment DROP FOREIGN KEY FK_4F9135EA517FE9FE');
        $this->addSql('ALTER TABLE room_image DROP FOREIGN KEY FK_8F81A5F454177093');
        $this->addSql('ALTER TABLE room_image DROP FOREIGN KEY FK_8F81A5F43DA5256D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495C872AB0');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE equipment_software');
        $this->addSql('DROP TABLE ergonomy');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_booking');
        $this->addSql('DROP TABLE room_ergonomy');
        $this->addSql('DROP TABLE room_equipment');
        $this->addSql('DROP TABLE room_image');
        $this->addSql('DROP TABLE software');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
