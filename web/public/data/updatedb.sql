-- Add Course Id field for Note Table
ALTER TABLE `note` ADD `course_id` INT(10) DEFAULT '0' AFTER `unit_id`;

-- Add replymid field for message Table
ALTER TABLE `message` ADD `replymid` INT(10) NOT NULL AFTER `reply`;

