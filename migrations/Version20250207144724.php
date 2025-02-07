<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207144724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
        IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = \'user\')
            BEGIN
                CREATE TABLE user (
                    id INT PRIMARY KEY IDENTITY(1,1),
                    user_name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    date_created DATETIME DEFAULT GETDATE() NOT NULL,
                    is_active BIT NOT NULL,
                    last_login DATETIME NULL
                );
            END
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
        IF EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = \'user\')
        BEGIN
            DROP TABLE user;
        END
    ');
    }
}
