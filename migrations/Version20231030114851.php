<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030114851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre ADD thumbnail VARCHAR(255) DEFAULT NULL, ADD small_thumbnail VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C698DE379A');
        $this->addSql('DROP INDEX IDX_794381C698DE379A ON review');
        $this->addSql('ALTER TABLE review CHANGE correspond_id livres_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6EBF07F38 FOREIGN KEY (livres_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_794381C6EBF07F38 ON review (livres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP thumbnail, DROP small_thumbnail');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6EBF07F38');
        $this->addSql('DROP INDEX IDX_794381C6EBF07F38 ON review');
        $this->addSql('ALTER TABLE review CHANGE livres_id correspond_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C698DE379A FOREIGN KEY (correspond_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_794381C698DE379A ON review (correspond_id)');
    }
}
