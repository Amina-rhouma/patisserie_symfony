<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701145155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products RENAME cake;');
        $this->addSql('CREATE TABLE cake_like (id INT AUTO_INCREMENT NOT NULL, cake_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_794A48A99F8008B6 (cake_id), INDEX IDX_794A48A9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cake_like ADD CONSTRAINT FK_794A48A99F8008B6 FOREIGN KEY (cake_id) REFERENCES cake (id)');
        $this->addSql('ALTER TABLE cake_like ADD CONSTRAINT FK_794A48A9A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cake_like');
        $this->addSql('ALTER TABLE cake RENAME products;');
    }
}
