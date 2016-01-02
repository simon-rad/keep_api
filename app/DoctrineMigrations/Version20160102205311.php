<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160102205311 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE note_labels (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AD0355C55E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, color VARCHAR(31) NOT NULL, type ENUM(\'text\', \'list\') COMMENT \'(DC2Type:NoteType)\' NOT NULL COMMENT \'(DC2Type:NoteType)\', content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes_labels (note_id INT NOT NULL, label_id INT NOT NULL, INDEX IDX_639D561126ED0855 (note_id), INDEX IDX_639D561133B92F39 (label_id), PRIMARY KEY(note_id, label_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notes_labels ADD CONSTRAINT FK_639D561126ED0855 FOREIGN KEY (note_id) REFERENCES note (id)');
        $this->addSql('ALTER TABLE notes_labels ADD CONSTRAINT FK_639D561133B92F39 FOREIGN KEY (label_id) REFERENCES note_labels (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE notes_labels DROP FOREIGN KEY FK_639D561133B92F39');
        $this->addSql('ALTER TABLE notes_labels DROP FOREIGN KEY FK_639D561126ED0855');
        $this->addSql('DROP TABLE note_labels');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE notes_labels');
    }
}
