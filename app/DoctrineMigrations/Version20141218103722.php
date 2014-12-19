<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141218103722 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        //migration to create security_tokens table.
        $sql = "CREATE TABLE IF NOT EXISTS `security_tokens` (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `token` varchar(255) NOT NULL,
                                    `remote_address` varchar(200) NOT NULL,
                                    `inserted_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0- expired, 1 - active',
                                    PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";
        $this->addSql($sql);

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
