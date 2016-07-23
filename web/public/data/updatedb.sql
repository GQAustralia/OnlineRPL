-- Add Course Id field for Note Table
ALTER TABLE `note` ADD `course_id` INT(10) DEFAULT '0' AFTER `unit_id`;

-- Add replymid field for message Table
ALTER TABLE `message` ADD `replymid` INT(10) NOT NULL AFTER `reply`;

ALTER TABLE `user_ids` ADD `size` VARCHAR(20) NOT NULL AFTER `created`;

ALTER TABLE `reminder` ADD `type` VARCHAR(20) NULL AFTER `created_by`;

ALTER TABLE `reminder` ADD `reminder_type_id` INT(10) NULL AFTER `type`;

