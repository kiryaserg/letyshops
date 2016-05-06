<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160506173143 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, shop_id INT DEFAULT NULL, import_shop_id VARCHAR(100) NOT NULL, order_id VARCHAR(100) NOT NULL, state VARCHAR(50) NOT NULL, order_payment NUMERIC(10, 2) NOT NULL, currency VARCHAR(3) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E52FFDEE4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, api_uri VARCHAR(255) NOT NULL, last_import_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql("INSERT INTO `letyshops`.`shop`
(`id`,
`name`,
`api_uri`,
`last_import_time`)
VALUES
(1,
'shopA',
'http://localhost:8000/staticmocks/test_vendor1_csv.csv',
'0000-00-00 00:00:00');
");
    $this->addSql("INSERT INTO `letyshops`.`shop`
(`id`,
`name`,
`api_uri`,
`last_import_time`)
VALUES
(2,
'shopB',
    'http://localhost:8000/staticmocks/test_vendor2_xml.xml',
'0000-00-00 00:00:00'
);
");
        
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE4D16C4DD');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE shop');
    }
}
