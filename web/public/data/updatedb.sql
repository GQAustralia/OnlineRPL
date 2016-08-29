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

-- To display candidate selfassesment 
ALTER TABLE `evidence_text`  ADD `self_assessment` INT(1) NOT NULL DEFAULT '0'  AFTER `content`;

-- To elective status of the course unit
ALTER TABLE `user_course_units` ADD `elective_status` INT(2) NOT NULL DEFAULT '0' AFTER `status`;

-- submit this Unit Status
ALTER TABLE `user_course_units` ADD `issubmitted` INT(2) NULL DEFAULT NULL AFTER `elective_status`;

-- reminder view status
ALTER TABLE `reminder` ADD `reminder_view_status` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `reminder_type_id`;

-- transcoder job id
ALTER TABLE `evidence` ADD `job_id` VARCHAR(100) NOT NULL AFTER `course_code`;

-- facilitator has read the applicant
ALTER TABLE `user_courses`  ADD `f_read` TINYINT(1) NULL DEFAULT '0'  AFTER `rto_status`;

-- assessor has read the applicant
ALTER TABLE `user_courses`  ADD `a_read` TINYINT(1) NULL DEFAULT '0'  AFTER `f_read`;

-- rto has read the applicant
ALTER TABLE `user_courses`  ADD `r_read` TINYINT(1) NULL DEFAULT '0'  AFTER `a_read`;

-- reminder view status
ALTER TABLE `reminder` ADD `facilitator_view_status` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `reminder_view_status`;