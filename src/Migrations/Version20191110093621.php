<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191110093621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_lobby (user_id INT NOT NULL, lobby_id INT NOT NULL, INDEX IDX_2E26AEAFA76ED395 (user_id), INDEX IDX_2E26AEAFB6612FD9 (lobby_id), PRIMARY KEY(user_id, lobby_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_lobby ADD CONSTRAINT FK_2E26AEAFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_lobby ADD CONSTRAINT FK_2E26AEAFB6612FD9 FOREIGN KEY (lobby_id) REFERENCES lobby (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE lobby_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lobby_user (lobby_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1FD535B1A76ED395 (user_id), INDEX IDX_1FD535B1B6612FD9 (lobby_id), PRIMARY KEY(lobby_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lobby_user ADD CONSTRAINT FK_1FD535B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lobby_user ADD CONSTRAINT FK_1FD535B1B6612FD9 FOREIGN KEY (lobby_id) REFERENCES lobby (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_lobby');
    }
}
