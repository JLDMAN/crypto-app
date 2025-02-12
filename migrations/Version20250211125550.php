<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211125550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE [user] (id INT IDENTITY NOT NULL, user_name NVARCHAR(180) NOT NULL, email NVARCHAR(180) NOT NULL, password NVARCHAR(255) NOT NULL, date_created DATETIME2(6) NOT NULL, is_active BIT NOT NULL, last_login DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON [user] (email) WHERE email IS NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USER_NAME ON [user] (user_name) WHERE user_name IS NOT NULL');
        $this->addSql('ALTER TABLE [user] ADD CONSTRAINT DF_8D93D649_1B5771DD DEFAULT 1 FOR is_active');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('CREATE TABLE users (id INT IDENTITY NOT NULL, user_name NVARCHAR(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL, email NVARCHAR(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL, password NVARCHAR(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL, date_created DATETIME2(6) NOT NULL, is_active BIT NOT NULL, last_login DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE NONCLUSTERED INDEX UQ__users__AB6E61646B28E9AD ON users (email) WHERE email IS NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT DF_1483A5E9_8BDAB045 DEFAULT CURRENT_TIMESTAMP FOR date_created');
        $this->addSql('DROP TABLE [user]');
    }
}
