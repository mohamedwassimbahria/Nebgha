<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220080045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT NOT NULL, role_admin VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, date_naissance DATE NOT NULL, niveau_etude VARCHAR(255) NOT NULL, parcour_suivi VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, id_prof_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(60) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, capacite INT DEFAULT NULL, nombre_participants INT DEFAULT NULL, frais_participation DOUBLE PRECISION DEFAULT NULL, tags LONGTEXT DEFAULT NULL, INDEX IDX_B26681E755C5E8E (id_prof_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_etudiant (evenement_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_FE18B90BFD02F13 (evenement_id), INDEX IDX_FE18B90BDDEAB1A3 (etudiant_id), PRIMARY KEY(evenement_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, duree VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cout DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) DEFAULT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(60) NOT NULL, date_lancement DATETIME DEFAULT NULL, date_expiration DATETIME DEFAULT NULL, prix_original DOUBLE PRECISION DEFAULT NULL, prix_reduit DOUBLE PRECISION DEFAULT NULL, pourcentage_reduction DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_formation (offre_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_1CC889404CC8505A (offre_id), INDEX IDX_1CC889405200282E (formation_id), PRIMARY KEY(offre_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT NOT NULL, specialite VARCHAR(255) NOT NULL, date_embauche DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, num_tel VARCHAR(20) NOT NULL, role VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E755C5E8E FOREIGN KEY (id_prof_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE evenement_etudiant ADD CONSTRAINT FK_FE18B90BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_etudiant ADD CONSTRAINT FK_FE18B90BDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_formation ADD CONSTRAINT FK_1CC889404CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_formation ADD CONSTRAINT FK_1CC889405200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3BF396750');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E755C5E8E');
        $this->addSql('ALTER TABLE evenement_etudiant DROP FOREIGN KEY FK_FE18B90BFD02F13');
        $this->addSql('ALTER TABLE evenement_etudiant DROP FOREIGN KEY FK_FE18B90BDDEAB1A3');
        $this->addSql('ALTER TABLE offre_formation DROP FOREIGN KEY FK_1CC889404CC8505A');
        $this->addSql('ALTER TABLE offre_formation DROP FOREIGN KEY FK_1CC889405200282E');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299BF396750');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_etudiant');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_formation');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
