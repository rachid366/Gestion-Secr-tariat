<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621100911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE final_result (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, pac_id INT DEFAULT NULL, vote TINYINT(1) NOT NULL, INDEX IDX_E3644A04FB88E14F (utilisateur_id), INDEX IDX_E3644A04AE21B650 (pac_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taf (id INT AUTO_INCREMENT NOT NULL, pac_id INT DEFAULT NULL, INDEX IDX_748E8715AE21B650 (pac_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taf_utilisateur (taf_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_DC43C0D626E0474 (taf_id), INDEX IDX_DC43C0D6FB88E14F (utilisateur_id), PRIMARY KEY(taf_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE final_result ADD CONSTRAINT FK_E3644A04FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE final_result ADD CONSTRAINT FK_E3644A04AE21B650 FOREIGN KEY (pac_id) REFERENCES pac (id)');
        $this->addSql('ALTER TABLE taf ADD CONSTRAINT FK_748E8715AE21B650 FOREIGN KEY (pac_id) REFERENCES pac (id)');
        $this->addSql('ALTER TABLE taf_utilisateur ADD CONSTRAINT FK_DC43C0D626E0474 FOREIGN KEY (taf_id) REFERENCES taf (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taf_utilisateur ADD CONSTRAINT FK_DC43C0D6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taf_utilisateur DROP FOREIGN KEY FK_DC43C0D626E0474');
        $this->addSql('DROP TABLE final_result');
        $this->addSql('DROP TABLE taf');
        $this->addSql('DROP TABLE taf_utilisateur');
    }
}
