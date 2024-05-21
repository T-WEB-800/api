<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521005455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_query ADD target_location VARCHAR(255) NOT NULL, ADD accomodation_budget INT DEFAULT NULL, ADD restauration_budget INT DEFAULT NULL, ADD events_budget INT DEFAULT NULL, DROP departure_location, DROP departure_date, DROP arrival_location, DROP preferred_transportation, CHANGE user_id user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_query ADD departure_date DATETIME NOT NULL, ADD arrival_location VARCHAR(255) NOT NULL, ADD preferred_transportation VARCHAR(255) NOT NULL, DROP accomodation_budget, DROP restauration_budget, DROP events_budget, CHANGE user_id user_id INT NOT NULL, CHANGE target_location departure_location VARCHAR(255) NOT NULL');
    }
}
