<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141215081035 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        //migration to create assessor table.
        $sql = "CREATE TABLE IF NOT EXISTS `assessor` (`assessor_code` varchar(16) NOT NULL,
                                                        `assessor_name` varchar(225) NOT NULL,
                                                        `assessor_email` varchar(225) NOT NULL,
                                                        `assessor_phone` varchar(225) NOT NULL,
                                                        PRIMARY KEY (`assessor_code`)
                                                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $this->addSql($sql);
        
        //migration to create assessor_course table.
        $sql = "CREATE TABLE IF NOT EXISTS `assessor_course` (`assessor_id` varchar(16) NOT NULL,
                                                            `course_id` varchar(32) CHARACTER SET utf8 NOT NULL,
                                                            `id` int(11) NOT NULL AUTO_INCREMENT,
                                                            PRIMARY KEY (`id`),
                                                            KEY `course_id` (`course_id`),
                                                            KEY `assessor_id` (`assessor_id`)
                                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
        $this->addSql($sql);
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
