<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210231259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, place SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictogramme (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_30A016C7BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', first_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, firstname_parent1 VARCHAR(255) DEFAULT NULL, surname_parent1 VARCHAR(255) DEFAULT NULL, firstname_parent2 VARCHAR(255) DEFAULT NULL, surname_parent2 VARCHAR(255) DEFAULT NULL, firstname_educateur VARCHAR(255) DEFAULT NULL, surname_educateur VARCHAR(255) DEFAULT NULL, firstname_orthophoniste VARCHAR(255) DEFAULT NULL, surname_orthophoniste VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) NOT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, confirmation_reset_password VARCHAR(255) DEFAULT NULL, date_de_naissance DATE DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_login DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pictogramme ADD CONSTRAINT FK_30A016C7BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictogramme DROP FOREIGN KEY FK_30A016C7BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE pictogramme');
        $this->addSql('DROP TABLE user');
    }
}
