<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503075428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, comment_article_id INT NOT NULL, comment_user_id INT NOT NULL, comment_body VARCHAR(255) NOT NULL, comment_rating INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9474526CF0750CBC (comment_article_id), INDEX IDX_9474526C541DB185 (comment_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, favorite_user_id INT NOT NULL, favorite_article_id INT NOT NULL, INDEX IDX_68C58ED9FA3A7DFB (favorite_user_id), INDEX IDX_68C58ED96C5F6461 (favorite_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orderlist (id INT AUTO_INCREMENT NOT NULL, orderlist_order_id INT NOT NULL, orderlist_article_id INT NOT NULL, created_at DATETIME NOT NULL, quantity INT NOT NULL, INDEX IDX_4AF8AE82AD69A89B (orderlist_order_id), INDEX IDX_4AF8AE821CB07F7F (orderlist_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF0750CBC FOREIGN KEY (comment_article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C541DB185 FOREIGN KEY (comment_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9FA3A7DFB FOREIGN KEY (favorite_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED96C5F6461 FOREIGN KEY (favorite_article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE orderlist ADD CONSTRAINT FK_4AF8AE82AD69A89B FOREIGN KEY (orderlist_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE orderlist ADD CONSTRAINT FK_4AF8AE821CB07F7F FOREIGN KEY (orderlist_article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article ADD rating DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE orderlist');
        $this->addSql('ALTER TABLE article DROP rating');
    }
}
