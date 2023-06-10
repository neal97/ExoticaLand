<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512135103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_articles (commande_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_69FD29F282EA2E54 (commande_id), INDEX IDX_69FD29F21EBAF6CC (articles_id), PRIMARY KEY(commande_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_articles ADD CONSTRAINT FK_69FD29F282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_articles ADD CONSTRAINT FK_69FD29F21EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D7294869C');
        $this->addSql('DROP INDEX IDX_6EEAA67D7294869C ON commande');
        $this->addSql('ALTER TABLE commande DROP article_id, DROP prix');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_articles DROP FOREIGN KEY FK_69FD29F282EA2E54');
        $this->addSql('ALTER TABLE commande_articles DROP FOREIGN KEY FK_69FD29F21EBAF6CC');
        $this->addSql('DROP TABLE commande_articles');
        $this->addSql('ALTER TABLE commande ADD article_id INT DEFAULT NULL, ADD prix INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7294869C FOREIGN KEY (article_id) REFERENCES articles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6EEAA67D7294869C ON commande (article_id)');
    }
}
