<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503073539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD vat_id INT NOT NULL, ADD brand_id INT NOT NULL, ADD category_id INT NOT NULL, ADD discount_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DF71ADEB FOREIGN KEY (vat_id) REFERENCES vat (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66111D2463 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6688C5F785 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66D6FF0B78 FOREIGN KEY (discount_id) REFERENCES discount (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66DF71ADEB ON article (vat_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66111D2463 ON article (brand_id)');
        $this->addSql('CREATE INDEX IDX_23A0E6688C5F785 ON article (category_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66D6FF0B78 ON article (discount_id)');
        $this->addSql('ALTER TABLE `order` ADD order_user_id INT DEFAULT NULL, ADD order_deliveries_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939851147ADE FOREIGN KEY (order_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985576EEB8 FOREIGN KEY (order_deliveries_id) REFERENCES deliveries_fees (id)');
        $this->addSql('CREATE INDEX IDX_F529939851147ADE ON `order` (order_user_id)');
        $this->addSql('CREATE INDEX IDX_F52993985576EEB8 ON `order` (order_deliveries_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DF71ADEB');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66111D2463');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6688C5F785');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66D6FF0B78');
        $this->addSql('DROP INDEX IDX_23A0E66DF71ADEB ON article');
        $this->addSql('DROP INDEX IDX_23A0E66111D2463 ON article');
        $this->addSql('DROP INDEX IDX_23A0E6688C5F785 ON article');
        $this->addSql('DROP INDEX IDX_23A0E66D6FF0B78 ON article');
        $this->addSql('ALTER TABLE article DROP vat_id, DROP brand_id, DROP category_id, DROP discount_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939851147ADE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985576EEB8');
        $this->addSql('DROP INDEX IDX_F529939851147ADE ON `order`');
        $this->addSql('DROP INDEX IDX_F52993985576EEB8 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP order_user_id, DROP order_deliveries_id');
    }
}
