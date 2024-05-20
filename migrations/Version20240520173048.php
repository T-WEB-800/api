<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520173048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE search_query (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, departure_location VARCHAR(255) NOT NULL, departure_date DATE NOT NULL, arrival_location VARCHAR(255) NOT NULL, arrival_date DATE NOT NULL, preferred_transportation VARCHAR(255) NOT NULL, INDEX IDX_10887602A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE search_query ADD CONSTRAINT FK_10887602A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_query DROP FOREIGN KEY FK_10887602A76ED395');
        $this->addSql('DROP TABLE search_query');
    }
}
