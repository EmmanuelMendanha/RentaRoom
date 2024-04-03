<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402135715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE software_room (software_id INT NOT NULL, room_id INT NOT NULL, INDEX IDX_579A5B67D7452741 (software_id), INDEX IDX_579A5B6754177093 (room_id), PRIMARY KEY(software_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE software_room ADD CONSTRAINT FK_579A5B67D7452741 FOREIGN KEY (software_id) REFERENCES software (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE software_room ADD CONSTRAINT FK_579A5B6754177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_software DROP FOREIGN KEY FK_4713ECE9D7452741');
        $this->addSql('ALTER TABLE equipment_software DROP FOREIGN KEY FK_4713ECE9517FE9FE');
        $this->addSql('DROP TABLE equipment_software');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment_software (equipment_id INT NOT NULL, software_id INT NOT NULL, INDEX IDX_4713ECE9D7452741 (software_id), INDEX IDX_4713ECE9517FE9FE (equipment_id), PRIMARY KEY(equipment_id, software_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE equipment_software ADD CONSTRAINT FK_4713ECE9D7452741 FOREIGN KEY (software_id) REFERENCES software (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_software ADD CONSTRAINT FK_4713ECE9517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE software_room DROP FOREIGN KEY FK_579A5B67D7452741');
        $this->addSql('ALTER TABLE software_room DROP FOREIGN KEY FK_579A5B6754177093');
        $this->addSql('DROP TABLE software_room');
    }
}
