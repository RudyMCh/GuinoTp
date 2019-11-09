<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109154023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doc ADD user_id INT NOT NULL, ADD lobby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doc ADD CONSTRAINT FK_8641FD64A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE doc ADD CONSTRAINT FK_8641FD64B6612FD9 FOREIGN KEY (lobby_id) REFERENCES lobby (id)');
        $this->addSql('CREATE INDEX IDX_8641FD64A76ED395 ON doc (user_id)');
        $this->addSql('CREATE INDEX IDX_8641FD64B6612FD9 ON doc (lobby_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doc DROP FOREIGN KEY FK_8641FD64A76ED395');
        $this->addSql('ALTER TABLE doc DROP FOREIGN KEY FK_8641FD64B6612FD9');
        $this->addSql('DROP INDEX IDX_8641FD64A76ED395 ON doc');
        $this->addSql('DROP INDEX IDX_8641FD64B6612FD9 ON doc');
        $this->addSql('ALTER TABLE doc DROP user_id, DROP lobby_id');
    }
}
