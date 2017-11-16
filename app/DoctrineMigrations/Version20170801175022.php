<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170801175022 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE exerciseitem ADD labels_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE exerciseitem ADD CONSTRAINT FK_7C2CED5EB8478C02 FOREIGN KEY (labels_id) REFERENCES ExerciseLabel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C2CED5EB8478C02 ON exerciseitem (labels_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ExerciseItem DROP CONSTRAINT FK_7C2CED5EB8478C02');
        $this->addSql('DROP INDEX IDX_7C2CED5EB8478C02');
        $this->addSql('ALTER TABLE ExerciseItem DROP labels_id');
    }
}
