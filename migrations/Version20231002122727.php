<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002122727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, biographie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_livre (author_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_BAEB6F54F675F31B (author_id), INDEX IDX_BAEB6F5437D925CB (livre_id), PRIMARY KEY(author_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, genre_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre_livre (genre_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_1165505C4296D31F (genre_id), INDEX IDX_1165505C37D925CB (livre_id), PRIMARY KEY(genre_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, isbn VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, date_edition DATETIME NOT NULL, number_pages VARCHAR(255) NOT NULL, resume VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, correspond_id INT DEFAULT NULL, commentaire VARCHAR(255) NOT NULL, date_review DATETIME NOT NULL, rating INT NOT NULL, INDEX IDX_794381C667B3B43D (users_id), INDEX IDX_794381C698DE379A (correspond_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lectures (user_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_63C861D0A76ED395 (user_id), INDEX IDX_63C861D037D925CB (livre_id), PRIMARY KEY(user_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recommendations (user_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_73904ED7A76ED395 (user_id), INDEX IDX_73904ED737D925CB (livre_id), PRIMARY KEY(user_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE author_livre ADD CONSTRAINT FK_BAEB6F54F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE author_livre ADD CONSTRAINT FK_BAEB6F5437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_livre ADD CONSTRAINT FK_1165505C4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_livre ADD CONSTRAINT FK_1165505C37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C667B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C698DE379A FOREIGN KEY (correspond_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE lectures ADD CONSTRAINT FK_63C861D0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lectures ADD CONSTRAINT FK_63C861D037D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recommendations ADD CONSTRAINT FK_73904ED7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recommendations ADD CONSTRAINT FK_73904ED737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author_livre DROP FOREIGN KEY FK_BAEB6F54F675F31B');
        $this->addSql('ALTER TABLE author_livre DROP FOREIGN KEY FK_BAEB6F5437D925CB');
        $this->addSql('ALTER TABLE genre_livre DROP FOREIGN KEY FK_1165505C4296D31F');
        $this->addSql('ALTER TABLE genre_livre DROP FOREIGN KEY FK_1165505C37D925CB');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C667B3B43D');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C698DE379A');
        $this->addSql('ALTER TABLE lectures DROP FOREIGN KEY FK_63C861D0A76ED395');
        $this->addSql('ALTER TABLE lectures DROP FOREIGN KEY FK_63C861D037D925CB');
        $this->addSql('ALTER TABLE recommendations DROP FOREIGN KEY FK_73904ED7A76ED395');
        $this->addSql('ALTER TABLE recommendations DROP FOREIGN KEY FK_73904ED737D925CB');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_livre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_livre');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE lectures');
        $this->addSql('DROP TABLE recommendations');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
