<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180406184328 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE delegation (id INT AUTO_INCREMENT NOT NULL, government_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_292F436DF55836AA (government_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE government (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(21) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delegation ADD CONSTRAINT FK_292F436DF55836AA FOREIGN KEY (government_id) REFERENCES government (id)');
        $this->addSql('ALTER TABLE artisan_history ADD CONSTRAINT FK_1335E55AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1335E55AA76ED395 ON artisan_history (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delegation DROP FOREIGN KEY FK_292F436DF55836AA');
        $this->addSql('DROP TABLE delegation');
        $this->addSql('DROP TABLE government');
        $this->addSql('ALTER TABLE artisan_history DROP FOREIGN KEY FK_1335E55AA76ED395');
        $this->addSql('DROP INDEX IDX_1335E55AA76ED395 ON artisan_history');
    }
}
