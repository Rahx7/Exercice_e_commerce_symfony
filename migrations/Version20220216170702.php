<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220216170702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contenu_panier (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, quantite INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_80507DC0F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu_panier_produit (contenu_panier_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_179C43E361405BF (contenu_panier_id), INDEX IDX_179C43E3F347EFB (produit_id), PRIMARY KEY(contenu_panier_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, date DATETIME NOT NULL, etat TINYINT(1) NOT NULL, INDEX IDX_24CC0DF2FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, stock INT NOT NULL, photo VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenu_panier ADD CONSTRAINT FK_80507DC0F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE contenu_panier_produit ADD CONSTRAINT FK_179C43E361405BF FOREIGN KEY (contenu_panier_id) REFERENCES contenu_panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contenu_panier_produit ADD CONSTRAINT FK_179C43E3F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenu_panier_produit DROP FOREIGN KEY FK_179C43E361405BF');
        $this->addSql('ALTER TABLE contenu_panier DROP FOREIGN KEY FK_80507DC0F77D927C');
        $this->addSql('ALTER TABLE contenu_panier_produit DROP FOREIGN KEY FK_179C43E3F347EFB');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2FB88E14F');
        $this->addSql('DROP TABLE contenu_panier');
        $this->addSql('DROP TABLE contenu_panier_produit');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
