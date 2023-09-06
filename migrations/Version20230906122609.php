<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906122609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, filliere_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contact VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_717E22E393FA3A0A (filliere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL, duree INT NOT NULL, heure VARCHAR(255) NOT NULL, session VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, classe VARCHAR(255) NOT NULL, INDEX IDX_514C8FECAFC2B591 (module_id), INDEX IDX_514C8FECBAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filliere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, filliere_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C24262893FA3A0A (filliere_id), INDEX IDX_C242628BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, module_id INT DEFAULT NULL, valeur DOUBLE PRECISION NOT NULL, mention VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_CFBDFA14DDEAB1A3 (etudiant_id), INDEX IDX_CFBDFA14AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cni VARCHAR(255) NOT NULL, contact VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E393FA3A0A FOREIGN KEY (filliere_id) REFERENCES filliere (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C24262893FA3A0A FOREIGN KEY (filliere_id) REFERENCES filliere (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E393FA3A0A');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECAFC2B591');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECBAB22EE9');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C24262893FA3A0A');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628BAB22EE9');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14AFC2B591');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE filliere');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
