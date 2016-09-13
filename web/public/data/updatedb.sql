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

ALTER TABLE `evidence` CHANGE `job_id` `job_id` VARCHAR(100) NULL DEFAULT NULL;

-- facilitator has read the applicant
ALTER TABLE `user_courses`  ADD `f_read` TINYINT(1) NOT NULL DEFAULT '0'  AFTER `rto_status`;

-- assessor has read the applicant
ALTER TABLE `user_courses`  ADD `a_read` TINYINT(1) NOT NULL DEFAULT '0'  AFTER `f_read`;

-- rto has read the applicant
ALTER TABLE `user_courses`  ADD `r_read` TINYINT(1) NOT NULL DEFAULT '0'  AFTER `a_read`;


-- reminder view status
ALTER TABLE `evidence` ADD `facilitator_view_status` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `job_id`;

--for softdelete
ALTER TABLE `user_ids` ADD `status` INT(2) NULL AFTER `size`;

ALTER TABLE `other_files`  ADD `isdeleted` INT(2) NULL  AFTER `created`;

ALTER TABLE `user_courses` ADD `manager` INT(2) NULL AFTER `created_on`;

ALTER TABLE `user_courses` CHANGE `manager` `manager` INT(11) NULL DEFAULT NULL;
ALTER TABLE `user_courses` CHANGE `facilitator` `facilitator` INT(11) NULL DEFAULT NULL;

ALTER TABLE `user` ADD `login_token` VARCHAR(200) NULL AFTER `applicantStatus`;

CREATE TABLE `user_course_file` ( `id` INT(11) NOT NULL AUTO_INCREMENT ,  `usercourse_id` INT(11) NOT NULL ,  `type` VARCHAR(50) NOT NULL ,  `path` TEXT NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `action` int(10) NOT NULL,
  `page_name` varchar(200) NOT NULL,
  `date_time` datetime NOT NULL,
  `message` text NOT NULL,
  `role` int(11) NOT NULL COMMENT '1. Applicant 2. Facilitator 3. Assessor 4. RTO 5. Manager 6. Super Admin'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;