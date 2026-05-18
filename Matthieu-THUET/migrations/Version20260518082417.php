<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260518082417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessibility_consulting_request (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, company_name VARCHAR(150) DEFAULT NULL, email_address VARCHAR(150) NOT NULL, web_site_url VARCHAR(150) DEFAULT NULL, app_name VARCHAR(100) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, company_name VARCHAR(150) DEFAULT NULL, email_address VARCHAR(255) NOT NULL, subject VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, rgpd TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE web_creation_request (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, company_name VARCHAR(150) DEFAULT NULL, email_address VARCHAR(150) NOT NULL, project_title VARCHAR(100) NOT NULL, short_project_description LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE accessibility_consulting_request');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE web_creation_request');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
