<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402143257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE room_software (room_id INT NOT NULL, software_id INT NOT NULL, INDEX IDX_D736A80B54177093 (room_id), INDEX IDX_D736A80BD7452741 (software_id), PRIMARY KEY(room_id, software_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room_software ADD CONSTRAINT FK_D736A80B54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_software ADD CONSTRAINT FK_D736A80BD7452741 FOREIGN KEY (software_id) REFERENCES software (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE software_room DROP FOREIGN KEY FK_579A5B67D7452741');
        $this->addSql('ALTER TABLE software_room DROP FOREIGN KEY FK_579A5B6754177093');
        $this->addSql('DROP TABLE software_room');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE software_room (software_id INT NOT NULL, room_id INT NOT NULL, INDEX IDX_579A5B6754177093 (room_id), INDEX IDX_579A5B67D7452741 (software_id), PRIMARY KEY(software_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE software_room ADD CONSTRAINT FK_579A5B67D7452741 FOREIGN KEY (software_id) REFERENCES software (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE software_room ADD CONSTRAINT FK_579A5B6754177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_software DROP FOREIGN KEY FK_D736A80B54177093');
        $this->addSql('ALTER TABLE room_software DROP FOREIGN KEY FK_D736A80BD7452741');
        $this->addSql('DROP TABLE room_software');
    }
}
