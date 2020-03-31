<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311080733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vetement DROP FOREIGN KEY FK_3CB446CF6F285051');
        $this->addSql('DROP INDEX IDX_3CB446CF6F285051 ON vetement');
        $this->addSql('ALTER TABLE vetement DROP couleur_id_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vetement ADD couleur_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE vetement ADD CONSTRAINT FK_3CB446CF6F285051 FOREIGN KEY (couleur_id_id) REFERENCES couleur (id)');
        $this->addSql('CREATE INDEX IDX_3CB446CF6F285051 ON vetement (couleur_id_id)');
    }
}
