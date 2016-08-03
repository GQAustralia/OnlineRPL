-- Add Course Id field for Note Table
ALTER TABLE `note` ADD `course_id` INT(10) DEFAULT '0' AFTER `unit_id`;

-- Add replymid field for message Table
ALTER TABLE `message` ADD `replymid` INT(10) NOT NULL AFTER `reply`;

-- Add size to display sizes for User Id files
ALTER TABLE `user_ids` ADD `size` VARCHAR(20) NOT NULL AFTER `created`;

ALTER TABLE `reminder` ADD `type` VARCHAR(20) NULL AFTER `created_by`;

ALTER TABLE `reminder` ADD `reminder_type_id` INT(10) NULL AFTER `type`;

--size to display for matrix files
ALTER TABLE `other_files` ADD `size` INT(20) NOT NULL AFTER `path`;

ALTER TABLE `evidence` CHANGE `unit_code` `unit_code` VARCHAR(50) NULL DEFAULT NULL;

ALTER TABLE `evidence` CHANGE `course_code` `course_code` VARCHAR(100) NULL DEFAULT NULL;

--New Applicant landing pages
ALTER TABLE `user` ADD `applicantStatus` INT(20) NOT NULL AFTER `crm_id`;

