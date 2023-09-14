<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913221954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant_module (etudiant_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_185A404BDDEAB1A3 (etudiant_id), INDEX IDX_185A404BAFC2B591 (module_id), PRIMARY KEY(etudiant_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant_module ADD CONSTRAINT FK_185A404BDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_module ADD CONSTRAINT FK_185A404BAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant_module DROP FOREIGN KEY FK_185A404BDDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_module DROP FOREIGN KEY FK_185A404BAFC2B591');
        $this->addSql('DROP TABLE etudiant_module');
    }
}
