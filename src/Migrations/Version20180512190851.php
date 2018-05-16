<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180512190851 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFC9F858258');
        $this->addSql('DROP INDEX IDX_AD5F9BFC9F858258 ON survey');
        $this->addSql('ALTER TABLE survey CHANGE enqueutor_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AD5F9BFCA76ED395 ON survey (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFCA76ED395');
        $this->addSql('DROP INDEX IDX_AD5F9BFCA76ED395 ON survey');
        $this->addSql('ALTER TABLE survey CHANGE user_id enqueutor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFC9F858258 FOREIGN KEY (enqueutor_id) REFERENCES enqueutor (id)');
        $this->addSql('CREATE INDEX IDX_AD5F9BFC9F858258 ON survey (enqueutor_id)');
    }
}
