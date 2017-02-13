ALTER TABLE `note` CHANGE `unit_id` `unit_id` VARCHAR(100) NOT NULL;

ALTER TABLE `note` ADD `acknowledged` INT(1) NOT NULL AFTER `created`;