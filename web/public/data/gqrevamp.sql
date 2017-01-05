-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2017 at 10:50 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gqrevamp`
--

-- --------------------------------------------------------

--
-- Table structure for table `disability_element`
--

CREATE TABLE `disability_element` (
  `id` int(10) NOT NULL,
  `type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_type`
--

CREATE TABLE `document_type` (
  `id` int(2) NOT NULL,
  `type` varchar(150) NOT NULL,
  `points` int(2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employment`
--

CREATE TABLE `employment` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `current_employment_status` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `study_reason` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evidence`
--

CREATE TABLE `evidence` (
  `id` int(11) NOT NULL,
  `size` varchar(20) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_code` varchar(50) DEFAULT NULL,
  `course_code` varchar(100) DEFAULT NULL,
  `job_id` varchar(100) DEFAULT NULL,
  `facilitator_view_status` enum('0','1') NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_audio`
--

CREATE TABLE `evidence_audio` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_file`
--

CREATE TABLE `evidence_file` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_image`
--

CREATE TABLE `evidence_image` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_recording`
--

CREATE TABLE `evidence_recording` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_text`
--

CREATE TABLE `evidence_text` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `self_assessment` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_video`
--

CREATE TABLE `evidence_video` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `faq_que` text NOT NULL,
  `faq_ans` text NOT NULL,
  `faq_sts` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1-Active,0-Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `language_diversity`
--

CREATE TABLE `language_diversity` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `born_country` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `speak_english` enum('1','0') COLLATE utf8_unicode_ci DEFAULT NULL,
  `specify_excenglish` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `rate_level_eng` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `related_origin` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `disability` enum('1','0') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `action` int(10) NOT NULL,
  `page_name` varchar(200) NOT NULL,
  `date_time` datetime NOT NULL,
  `message` text NOT NULL,
  `role` int(11) NOT NULL COMMENT '1. Applicant 2. Facilitator 3. Assessor 4. RTO 5. Manager 6. Super Admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_status` tinyint(1) NOT NULL,
  `from_status` tinyint(1) NOT NULL COMMENT '0 - active, 1- trash, 2 - delete',
  `to_status` tinyint(1) NOT NULL COMMENT '0 - active, 1- trash, 2 - delete',
  `reply` int(11) NOT NULL,
  `replymid` int(10) NOT NULL,
  `unit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `note` text NOT NULL,
  `unit_id` int(11) NOT NULL,
  `course_id` int(10) DEFAULT '0',
  `type` enum('a','f') NOT NULL COMMENT 'a=assessor, f=facilitator',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `other_files`
--

CREATE TABLE `other_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `size` int(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isdeleted` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `previous_qualifications`
--

CREATE TABLE `previous_qualifications` (
  `id` int(10) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `id` int(11) NOT NULL,
  `user_course_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `message` text NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `completed_date` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `reminder_type_id` int(10) DEFAULT NULL,
  `reminder_view_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `sessionid` char(255) DEFAULT NULL,
  `assessor` int(11) DEFAULT NULL,
  `applicant` int(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `s3_jobs`
--

CREATE TABLE `s3_jobs` (
  `job_id` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schooling`
--

CREATE TABLE `schooling` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `highest_completed_school_level` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `which_year` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `secondary_school_level` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file`
--

CREATE TABLE `tbl_file` (
  `id` int(10) UNSIGNED NOT NULL,
  `fileName` varchar(500) NOT NULL DEFAULT '',
  `filePath` varchar(1000) NOT NULL DEFAULT '',
  `fileSize` int(10) UNSIGNED DEFAULT '0',
  `category` enum('daily','weekly','monthly') NOT NULL DEFAULT 'daily',
  `reportDate` date NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Used to store data about individual pics' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstName` varchar(250) NOT NULL DEFAULT '',
  `lastName` varchar(250) NOT NULL DEFAULT '',
  `emailId` varchar(150) NOT NULL DEFAULT '0',
  `password` varchar(150) NOT NULL DEFAULT '0',
  `userType` enum('Admin','Normal') NOT NULL DEFAULT 'Normal',
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_files`
--

CREATE TABLE `tbl_user_files` (
  `userId` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `fileId` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date_of_birth` varchar(100) NOT NULL,
  `gender` varchar(59) NOT NULL,
  `universal_student_identifier` varchar(200) NOT NULL COMMENT 'USI - Universal Student Identifier',
  `role_type` tinyint(2) NOT NULL,
  `user_img` varchar(255) NOT NULL,
  `password_token` varchar(255) NOT NULL,
  `token_expiry` datetime NOT NULL,
  `token_status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1-active, 0 - inactive',
  `course_condition_status` enum('0','1') NOT NULL DEFAULT '0',
  `contact_name` varchar(155) DEFAULT NULL,
  `contact_phone` varchar(55) DEFAULT NULL,
  `contact_email` varchar(155) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created` datetime NOT NULL,
  `ceo_name` varchar(30) DEFAULT NULL,
  `ceo_email` varchar(30) DEFAULT NULL,
  `ceo_phone` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1 - Active, 0 - Inactive',
  `crm_id` varchar(200) DEFAULT NULL,
  `applicantStatus` int(20) NOT NULL,
  `login_token` varchar(200) DEFAULT NULL,
  `curr_australia` int(10) DEFAULT NULL,
  `inter_student_VET` int(10) DEFAULT NULL,
  `exemption_sir` int(10) DEFAULT NULL,
  `like_apply_usi` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `buildingname` varchar(250) DEFAULT NULL,
  `address` varchar(150) NOT NULL,
  `area` varchar(150) DEFAULT NULL,
  `suburb` varchar(150) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `pincode` varchar(10) NOT NULL,
  `postal` varchar(500) DEFAULT NULL,
  `updated` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_status` int(11) NOT NULL COMMENT '1 - current, 0 - completed, 2-FacilitatorApproved, 3-Assessor Approved, 15- Submitted to RTO, 16- RTO Issued certificate',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `manager` int(11) DEFAULT NULL,
  `facilitator` int(11) DEFAULT NULL,
  `assessor` int(11) DEFAULT NULL,
  `rto` int(11) DEFAULT NULL,
  `facilitator_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- pending, 1 - approved',
  `assessor_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- pending, 1 - approved',
  `rto_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- pending, 1 - approved',
  `f_read` tinyint(1) NOT NULL DEFAULT '0',
  `a_read` tinyint(1) NOT NULL DEFAULT '0',
  `r_read` tinyint(1) NOT NULL DEFAULT '0',
  `facilitator_date` datetime DEFAULT NULL,
  `assessor_date` datetime DEFAULT NULL,
  `rto_date` datetime DEFAULT NULL,
  `target_date` datetime NOT NULL,
  `zoho_id` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_course_file`
--

CREATE TABLE `user_course_file` (
  `id` int(11) NOT NULL,
  `usercourse_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_course_units`
--

CREATE TABLE `user_course_units` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_id` varchar(100) NOT NULL,
  `course_code` varchar(100) NOT NULL,
  `type` varchar(255) NOT NULL,
  `facilitator_status` tinyint(1) NOT NULL DEFAULT '0',
  `assessor_status` tinyint(1) NOT NULL DEFAULT '0',
  `rto_status` tinyint(1) DEFAULT '0',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '0- inactive, 1 - active',
  `elective_status` int(2) DEFAULT NULL,
  `issubmitted` int(2) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_disability`
--

CREATE TABLE `user_disability` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `disability_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_ids`
--

CREATE TABLE `user_ids` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(150) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size` varchar(20) NOT NULL,
  `status` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_prev_qualifications`
--

CREATE TABLE `user_prev_qualifications` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `prev_qual_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disability_element`
--
ALTER TABLE `disability_element`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_type`
--
ALTER TABLE `document_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employment`
--
ALTER TABLE `employment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employment_ibfk_1` (`user_id`);

--
-- Indexes for table `evidence`
--
ALTER TABLE `evidence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evidence_audio`
--
ALTER TABLE `evidence_audio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evidence_file`
--
ALTER TABLE `evidence_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evidence_image`
--
ALTER TABLE `evidence_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evidence_recording`
--
ALTER TABLE `evidence_recording`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evidence_text`
--
ALTER TABLE `evidence_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evidence_video`
--
ALTER TABLE `evidence_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `language_diversity`
--
ALTER TABLE `language_diversity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_diversity_ibfk_1` (`user_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_files`
--
ALTER TABLE `other_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `previous_qualifications`
--
ALTER TABLE `previous_qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schooling`
--
ALTER TABLE `schooling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schooling_ibfk_1` (`user_id`);

--
-- Indexes for table `tbl_file`
--
ALTER TABLE `tbl_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_files`
--
ALTER TABLE `tbl_user_files`
  ADD KEY `FK_tbl_user_files_tbl_user` (`userId`),
  ADD KEY `FK_tbl_user_files_tbl_file` (`fileId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_name` (`first_name`),
  ADD KEY `last_name` (`last_name`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_address1` (`user_id`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `course_name` (`course_name`);

--
-- Indexes for table `user_course_file`
--
ALTER TABLE `user_course_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_course_units`
--
ALTER TABLE `user_course_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_disability`
--
ALTER TABLE `user_disability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_disability_ibfk_1` (`user_id`),
  ADD KEY `user_disability_ibfk_2` (`disability_id`);

--
-- Indexes for table `user_ids`
--
ALTER TABLE `user_ids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ids_ibfk_1` (`user_id`),
  ADD KEY `user_ids_ibfk_2` (`type`);

--
-- Indexes for table `user_prev_qualifications`
--
ALTER TABLE `user_prev_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_prev_qualifications_ibfk_1` (`user_id`),
  ADD KEY `user_prev_qualifications_ibfk_2` (`prev_qual_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disability_element`
--
ALTER TABLE `disability_element`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `document_type`
--
ALTER TABLE `document_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `employment`
--
ALTER TABLE `employment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evidence`
--
ALTER TABLE `evidence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1352;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `language_diversity`
--
ALTER TABLE `language_diversity`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2141;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1407;
--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `other_files`
--
ALTER TABLE `other_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `previous_qualifications`
--
ALTER TABLE `previous_qualifications`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `schooling`
--
ALTER TABLE `schooling`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_file`
--
ALTER TABLE `tbl_file`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `user_course_file`
--
ALTER TABLE `user_course_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_course_units`
--
ALTER TABLE `user_course_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5027;
--
-- AUTO_INCREMENT for table `user_disability`
--
ALTER TABLE `user_disability`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_ids`
--
ALTER TABLE `user_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `user_prev_qualifications`
--
ALTER TABLE `user_prev_qualifications`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employment`
--
ALTER TABLE `employment`
  ADD CONSTRAINT `employment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `language_diversity`
--
ALTER TABLE `language_diversity`
  ADD CONSTRAINT `language_diversity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `schooling`
--
ALTER TABLE `schooling`
  ADD CONSTRAINT `schooling_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `tbl_user_files`
--
ALTER TABLE `tbl_user_files`
  ADD CONSTRAINT `FK_tbl_user_files_tbl_file` FOREIGN KEY (`fileId`) REFERENCES `tbl_file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_user_files_tbl_user` FOREIGN KEY (`userId`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_disability`
--
ALTER TABLE `user_disability`
  ADD CONSTRAINT `user_disability_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_disability_ibfk_2` FOREIGN KEY (`disability_id`) REFERENCES `disability_element` (`id`);

--
-- Constraints for table `user_ids`
--
ALTER TABLE `user_ids`
  ADD CONSTRAINT `user_ids_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ids_ibfk_2` FOREIGN KEY (`type`) REFERENCES `document_type` (`id`);

--
-- Constraints for table `user_prev_qualifications`
--
ALTER TABLE `user_prev_qualifications`
  ADD CONSTRAINT `user_prev_qualifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_prev_qualifications_ibfk_2` FOREIGN KEY (`prev_qual_id`) REFERENCES `previous_qualifications` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
