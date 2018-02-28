<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180228174803 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_5CA2E8E5D1B862B8 ON secret');
        $this->addSql('ALTER TABLE secret DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE secret DROP id, CHANGE hash hash CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE secret ADD PRIMARY KEY (hash)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE secret DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE secret ADD id INT NOT NULL, CHANGE hash hash VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5CA2E8E5D1B862B8 ON secret (hash)');
        $this->addSql('ALTER TABLE secret ADD PRIMARY KEY (id)');
    }
}
