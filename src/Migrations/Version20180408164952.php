<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180408164952 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE artisan_history (id INT AUTO_INCREMENT NOT NULL, artisan_id INT NOT NULL, activity_id INT NOT NULL, trade_id INT NOT NULL, user_id INT NOT NULL, old_date_creation DATE NOT NULL, old_cin INT NOT NULL, date_update DATE NOT NULL, INDEX IDX_1335E55A5ED3C7B7 (artisan_id), INDEX IDX_1335E55A81C06096 (activity_id), INDEX IDX_1335E55AC2D9760 (trade_id), INDEX IDX_1335E55AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artisan_history ADD CONSTRAINT FK_1335E55A5ED3C7B7 FOREIGN KEY (artisan_id) REFERENCES artisan (id)');
        $this->addSql('ALTER TABLE artisan_history ADD CONSTRAINT FK_1335E55A81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE artisan_history ADD CONSTRAINT FK_1335E55AC2D9760 FOREIGN KEY (trade_id) REFERENCES trades (id)');
        $this->addSql('ALTER TABLE artisan_history ADD CONSTRAINT FK_1335E55AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE artisan_history');
    }
}
