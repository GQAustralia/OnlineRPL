ALTER TABLE `message` ADD `is_flagged` ENUM('0','1') NOT NULL AFTER `unit_id`, ADD `course_code` INT NOT NULL AFTER `is_flagged`, ADD `is_new` ENUM('0','1') NOT NULL AFTER `course_code`;
ALTER TABLE `message` ADD `is_system_gen` ENUM('0','1') NOT NULL AFTER `is_new`;
ALTER TABLE `message` ADD `is_draft` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `is_system_gen`;
ALTER TABLE `message` CHANGE `course_code` `course_code` VARCHAR(11) NOT NULL;