<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503121341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE created_at comment_created_at DATETIME NOT NULL, CHANGE updated_at comment_updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE orderlist CHANGE created_at orderlist_created_at DATETIME NOT NULL, CHANGE quantity orderlist_quantity INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE comment_created_at created_at DATETIME NOT NULL, CHANGE comment_updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE orderlist CHANGE orderlist_created_at created_at DATETIME NOT NULL, CHANGE orderlist_quantity quantity INT NOT NULL');
    }
}
