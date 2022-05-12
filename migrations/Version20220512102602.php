<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512102602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB03A8386 FOREIGN KEY (created_by_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FB03A8386 ON message (created_by_id)');
        $this->addSql('ALTER TABLE topic ADD created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BB03A8386 FOREIGN KEY (created_by_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1BB03A8386 ON topic (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB03A8386');
        $this->addSql('DROP INDEX IDX_B6BD307FB03A8386 ON message');
        $this->addSql('ALTER TABLE message DROP created_by_id');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BB03A8386');
        $this->addSql('DROP INDEX IDX_9D40DE1BB03A8386 ON topic');
        $this->addSql('ALTER TABLE topic DROP created_by_id');
    }
}
