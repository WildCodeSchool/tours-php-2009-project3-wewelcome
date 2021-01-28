<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126131625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE keys_vision (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, photo VARCHAR(255) NOT NULL, text1 VARCHAR(50) NOT NULL, text2 VARCHAR(50) NOT NULL, text3 VARCHAR(50) NOT NULL, text4 VARCHAR(50) NOT NULL, text5 VARCHAR(50) DEFAULT NULL, text6 VARCHAR(50) DEFAULT NULL, text7 VARCHAR(50) DEFAULT NULL, text8 VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE keys_vision');
    }
}
