<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171007152515 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE item_label (item_id UUID NOT NULL, label_id UUID NOT NULL, PRIMARY KEY(item_id, label_id))');
        $this->addSql('CREATE INDEX IDX_24004B38126F525E ON item_label (item_id)');
        $this->addSql('CREATE INDEX IDX_24004B3833B92F39 ON item_label (label_id)');
        $this->addSql('ALTER TABLE item_label ADD CONSTRAINT FK_24004B38126F525E FOREIGN KEY (item_id) REFERENCES ExerciseItem (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_label ADD CONSTRAINT FK_24004B3833B92F39 FOREIGN KEY (label_id) REFERENCES ExerciseLabel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE exerciseitem DROP CONSTRAINT fk_7c2ced5eb8478c02');
        $this->addSql('DROP INDEX idx_7c2ced5eb8478c02');
        $this->addSql('ALTER TABLE exerciseitem DROP labels_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE item_label');
        $this->addSql('ALTER TABLE ExerciseItem ADD labels_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE ExerciseItem ADD CONSTRAINT fk_7c2ced5eb8478c02 FOREIGN KEY (labels_id) REFERENCES exerciselabel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7c2ced5eb8478c02 ON ExerciseItem (labels_id)');
    }
}
