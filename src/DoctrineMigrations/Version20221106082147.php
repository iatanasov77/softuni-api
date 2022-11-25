<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106082147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE WGP_Users_Favorites (user_id INT NOT NULL, favorite_id INT NOT NULL, INDEX IDX_C688191BA76ED395 (user_id), INDEX IDX_C688191BAA17481D (favorite_id), PRIMARY KEY(user_id, favorite_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE WGP_Tablatures (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, artist VARCHAR(255) NOT NULL, song VARCHAR(255) NOT NULL, public TINYINT(1) DEFAULT 1 NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B4690701A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE WGP_Tablatures_Files (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, type VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL COMMENT \'The Original Name of the File.\', UNIQUE INDEX UNIQ_B0C962317E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE WGP_Users_Favorites ADD CONSTRAINT FK_C688191BA76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE WGP_Users_Favorites ADD CONSTRAINT FK_C688191BAA17481D FOREIGN KEY (favorite_id) REFERENCES WGP_Tablatures (id)');
        $this->addSql('ALTER TABLE WGP_Tablatures ADD CONSTRAINT FK_B4690701A76ED395 FOREIGN KEY (user_id) REFERENCES VSUM_Users (id)');
        $this->addSql('ALTER TABLE WGP_Tablatures_Files ADD CONSTRAINT FK_B0C962317E3C61F9 FOREIGN KEY (owner_id) REFERENCES WGP_Tablatures (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id maintenance_page_id  INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id ) REFERENCES VSCMS_Pages (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE WGP_Users_Favorites DROP FOREIGN KEY FK_C688191BA76ED395');
        $this->addSql('ALTER TABLE WGP_Users_Favorites DROP FOREIGN KEY FK_C688191BAA17481D');
        $this->addSql('ALTER TABLE WGP_Tablatures DROP FOREIGN KEY FK_B4690701A76ED395');
        $this->addSql('ALTER TABLE WGP_Tablatures_Files DROP FOREIGN KEY FK_B0C962317E3C61F9');
        $this->addSql('DROP TABLE WGP_Users_Favorites');
        $this->addSql('DROP TABLE WGP_Tablatures');
        $this->addSql('DROP TABLE WGP_Tablatures_Files');
        $this->addSql('ALTER TABLE VSAPP_Settings DROP FOREIGN KEY FK_4A491FD507FAB6A');
        $this->addSql('DROP INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings');
        $this->addSql('ALTER TABLE VSAPP_Settings CHANGE maintenance_page_id  maintenance_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VSAPP_Settings ADD CONSTRAINT FK_4A491FD507FAB6A FOREIGN KEY (maintenance_page_id) REFERENCES VSCMS_Pages (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4A491FD507FAB6A ON VSAPP_Settings (maintenance_page_id)');
    }
}
