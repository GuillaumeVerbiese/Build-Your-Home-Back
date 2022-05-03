<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503072358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, brand_name VARCHAR(30) NOT NULL, brand_slug VARCHAR(30) DEFAULT NULL, brand_created_at DATETIME NOT NULL, brand_updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(30) NOT NULL, category_picture_link VARCHAR(255) NOT NULL, category_slug VARCHAR(30) DEFAULT NULL, category_created_at DATETIME NOT NULL, category_updated_at DATETIME DEFAULT NULL, category_display_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deliveries_fees (id INT AUTO_INCREMENT NOT NULL, delivery_fees_name VARCHAR(30) NOT NULL, delivery_fees_price DOUBLE PRECISION NOT NULL, delivery_fees_created_at DATETIME NOT NULL, delivery_fees_updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, discount_name VARCHAR(30) NOT NULL, discount_rate DOUBLE PRECISION NOT NULL, discount_created_at DATETIME NOT NULL, discount_updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, order_ref VARCHAR(255) NOT NULL, order_status INT NOT NULL, order_created_at DATETIME NOT NULL, order_updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_lastname VARCHAR(30) NOT NULL, user_firstname VARCHAR(30) NOT NULL, user_adress VARCHAR(255) NOT NULL, user_birthdate DATETIME NOT NULL, user_password VARCHAR(255) NOT NULL, user_role VARCHAR(64) NOT NULL, user_mail VARCHAR(255) NOT NULL, user_phone VARCHAR(20) NOT NULL, user_created_at DATETIME NOT NULL, user_updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vat (id INT AUTO_INCREMENT NOT NULL, vat_name VARCHAR(30) NOT NULL, vat_rate DOUBLE PRECISION NOT NULL, vat_created_at DATETIME NOT NULL, vat_updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE deliveries_fees');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vat');
    }
}
