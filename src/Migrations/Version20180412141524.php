<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412141524 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE artisan_history ADD government_id INT NOT NULL, ADD delegation_id INT NOT NULL, ADD government_changed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE artisan_history ADD CONSTRAINT FK_1335E55AF55836AA FOREIGN KEY (government_id) REFERENCES government (id)');
        $this->addSql('ALTER TABLE artisan_history ADD CONSTRAINT FK_1335E55A56CBBCF5 FOREIGN KEY (delegation_id) REFERENCES delegation (id)');
        $this->addSql('CREATE INDEX IDX_1335E55AF55836AA ON artisan_history (government_id)');
        $this->addSql('CREATE INDEX IDX_1335E55A56CBBCF5 ON artisan_history (delegation_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE artisan_history DROP FOREIGN KEY FK_1335E55AF55836AA');
        $this->addSql('ALTER TABLE artisan_history DROP FOREIGN KEY FK_1335E55A56CBBCF5');
        $this->addSql('DROP INDEX IDX_1335E55AF55836AA ON artisan_history');
        $this->addSql('DROP INDEX IDX_1335E55A56CBBCF5 ON artisan_history');
        $this->addSql('ALTER TABLE artisan_history DROP government_id, DROP delegation_id, DROP government_changed');
    }
}
