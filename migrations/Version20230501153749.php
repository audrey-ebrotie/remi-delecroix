<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501153749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C20E1466B');
        $this->addSql('DROP TABLE comment_image');
        $this->addSql('DROP INDEX UNIQ_9474526C20E1466B ON comment');
        $this->addSql('ALTER TABLE comment ADD image VARCHAR(255) NOT NULL, DROP comment_image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_image (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comment ADD comment_image_id INT DEFAULT NULL, DROP image');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C20E1466B FOREIGN KEY (comment_image_id) REFERENCES comment_image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9474526C20E1466B ON comment (comment_image_id)');
    }
}
