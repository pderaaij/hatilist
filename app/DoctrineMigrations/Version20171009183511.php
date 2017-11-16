<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171009183511 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE ExerciseItem_Label (item_id UUID NOT NULL, label_id UUID NOT NULL, PRIMARY KEY(item_id, label_id))');
        $this->addSql('CREATE INDEX IDX_1491782B126F525E ON ExerciseItem_Label (item_id)');
        $this->addSql('CREATE INDEX IDX_1491782B33B92F39 ON ExerciseItem_Label (label_id)');
        $this->addSql('ALTER TABLE ExerciseItem_Label ADD CONSTRAINT FK_1491782B126F525E FOREIGN KEY (item_id) REFERENCES ExerciseItem (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ExerciseItem_Label ADD CONSTRAINT FK_1491782B33B92F39 FOREIGN KEY (label_id) REFERENCES ExerciseLabel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE item_label');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE item_label (item_id UUID NOT NULL, label_id UUID NOT NULL, PRIMARY KEY(item_id, label_id))');
        $this->addSql('CREATE INDEX idx_24004b38126f525e ON item_label (item_id)');
        $this->addSql('CREATE INDEX idx_24004b3833b92f39 ON item_label (label_id)');
        $this->addSql('ALTER TABLE item_label ADD CONSTRAINT fk_24004b38126f525e FOREIGN KEY (item_id) REFERENCES exerciseitem (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_label ADD CONSTRAINT fk_24004b3833b92f39 FOREIGN KEY (label_id) REFERENCES exerciselabel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE ExerciseItem_Label');
    }
}
