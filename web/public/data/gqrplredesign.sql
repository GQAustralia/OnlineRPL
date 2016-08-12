-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2016 at 02:41 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gqrplredesign`
--

-- --------------------------------------------------------

--
-- Table structure for table `document_type`
--

CREATE TABLE IF NOT EXISTS `document_type` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` varchar(150) NOT NULL,
  `points` int(2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `document_type`
--

INSERT INTO `document_type` (`id`, `type`, `points`, `created`) VALUES
(1, 'Birth Certificate', 70, '2015-01-09 03:36:52'),
(2, 'Birth card issued by the New South Wales', 70, '2015-01-09 03:36:52'),
(3, 'Citizenship Certificate', 70, '2015-01-09 03:36:52'),
(4, 'Current passport', 70, '2015-01-09 03:36:52'),
(5, 'Expired passport', 70, '2015-01-09 03:36:52'),
(6, 'Diplomatic Documents', 70, '2015-01-09 03:36:52'),
(7, 'Driver licence', 40, '2015-01-09 03:36:52'),
(8, 'Roads and Maritime Services', 40, '2015-01-09 03:36:52'),
(9, 'Licence issued under Commonwealth or Territory Government', 40, '2015-01-09 03:36:52'),
(10, 'Public Employee Identification Card', 40, '2015-01-09 03:36:52'),
(11, 'Identification card issued by the Commonwealth', 40, '2015-01-09 03:36:52'),
(12, 'student Identification card', 40, '2015-01-09 03:36:52'),
(13, 'A document held by a cash dealer', 35, '2015-01-09 03:36:52'),
(14, 'A mortgage of security held by a financial body', 35, '2015-01-09 03:36:52'),
(15, 'Council rates notice', 35, '2015-01-09 03:36:52'),
(16, 'current employer or previous employer documents', 35, '2015-01-09 03:36:52'),
(17, 'Land Titles Office record', 35, '2015-01-09 03:36:52'),
(18, 'Document from the Credit Reference', 35, '2015-01-09 03:36:52'),
(19, 'Marriage certificate', 25, '2015-01-09 03:36:52'),
(20, 'Credit card', 25, '2015-01-09 03:36:52'),
(21, 'Foreign driver licence', 25, '2015-01-09 03:36:52'),
(22, 'Medicare card', 25, '2015-01-09 03:36:52'),
(23, 'EFTPOS card', 25, '2015-01-09 03:36:52'),
(24, 'Records of a public utility', 25, '2015-01-09 03:36:52'),
(25, 'Records of a financial institution', 25, '2015-01-09 03:36:52'),
(26, 'Electoral roll', 25, '2015-01-09 03:36:52'),
(27, 'A record held under a law', 25, '2015-01-09 03:36:52'),
(28, 'Lease/rent agreement', 25, '2015-01-09 03:36:52'),
(29, 'Rent receipt from a licensed real estate agent', 25, '2015-01-09 03:36:52'),
(30, 'Primary, Secondary or Tertiary education', 25, '2015-01-09 03:36:52'),
(31, 'professional or trade association', 25, '2015-01-09 03:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `evidence`
--

CREATE TABLE IF NOT EXISTS `evidence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(20) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_code` varchar(50) DEFAULT NULL,
  `course_code` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `evidence`
--

INSERT INTO `evidence` (`id`, `size`, `type`, `user_id`, `unit_code`, `course_code`, `created`) VALUES
(47, '826KB', 'image', 1, 'CHCCS400C', 'CHC30113', '2016-08-11 11:27:19'),
(50, '760KB', 'image', 1, '', '', '2016-08-11 13:15:06'),
(51, '606KB', 'image', 1, '', '', '2016-08-11 13:35:54'),
(52, '548KB', 'image', 1, '', '', '2016-08-11 13:35:54'),
(53, '760KB', 'image', 1, '', '', '2016-08-11 13:35:55'),
(54, '581KB', 'image', 1, 'CHCECE003', 'CHC30113', '2016-08-11 13:36:42'),
(55, '826KB', 'image', 1, 'CHCECE003', 'CHC30113', '2016-08-11 13:36:42'),
(58, '581KB', 'image', 1, 'CHCECE002', 'CHC30113', '2016-08-11 13:45:01'),
(60, '581KB', 'image', 1, '', '', '2016-08-11 13:58:30'),
(61, '826KB', 'image', 1, '', '', '2016-08-11 13:58:30'),
(62, '758KB', 'image', 1, '', '', '2016-08-11 13:58:31'),
(63, '826KB', 'image', 1, 'CHCCS400C', 'CHC30113', '2016-08-11 14:00:50'),
(68, '826KB', 'image', 1, '', 'CHC30113', '2016-08-11 14:43:51'),
(70, '826KB', 'image', 1, '', 'CHC30113', '2016-08-11 14:43:52'),
(72, '760KB', 'image', 5, '', '', '2016-08-12 03:10:25'),
(75, NULL, 'text', 6, 'ICTICT809', 'ICT80115', '2016-08-12 04:35:48'),
(76, '606KB', 'image', 2, 'BSBLDR803', 'ICT80115', '2016-08-12 05:05:06'),
(77, '606KB', 'image', 2, 'BSBLDR803', 'ICT80115', '2016-08-12 05:05:41'),
(78, NULL, 'text', 2, 'BSBLDR803', 'ICT80115', '2016-08-12 05:05:58'),
(79, NULL, 'text', 2, 'BSBLDR803', 'ICT80115', '2016-08-12 05:05:59'),
(80, '581KB', 'image', 2, 'BSBLDR803', 'ICT80115', '2016-08-12 05:06:36'),
(81, '606KB', 'image', 2, 'BSBLDR803', 'ICT80115', '2016-08-12 05:07:26'),
(82, '581KB', 'image', 2, 'BSBLDR803', 'ICT80115', '2016-08-12 05:08:31'),
(83, '606KB', 'image', 1, 'BSBSUS301A', 'CHC30113', '2016-08-12 05:13:18'),
(84, '859KB', 'image', 6, 'BSBLDR803', 'ICT80115', '2016-08-12 05:13:59'),
(85, NULL, 'text', 1, 'BSBSUS301A', 'CHC30113', '2016-08-12 05:14:27'),
(86, NULL, 'text', 6, 'BSBLDR803', 'ICT80115', '2016-08-12 05:15:32'),
(87, NULL, 'text', 1, 'CHCCS400C', 'CHC30113', '2016-08-12 05:57:43'),
(88, '581KB', 'image', 1, '', '', '2016-08-12 06:00:38'),
(89, '758KB', 'image', 1, '', '', '2016-08-12 06:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_audio`
--

CREATE TABLE IF NOT EXISTS `evidence_audio` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_file`
--

CREATE TABLE IF NOT EXISTS `evidence_file` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_file`
--

INSERT INTO `evidence_file` (`id`, `path`, `name`) VALUES
(2, '2016-08-10-57ab43c0f12dcGQ_Australia_plan_+RAID.xlsx', 'GQ_Australia_plan_+RAID.xlsx'),
(3, '2016-08-10-57ab44170fbabtemp_1470734931.pdf', 'temp_1470734931.pdf'),
(15, '2016-08-11-57ac2b04e4f6dPhanindra-Salaka_Certificate-III-in-Early-Childhood-Education-and-Care_1470749240.pdf', 'Phanindra-Salaka_Certificate-III-in-Early-Childhood-Education-and-Care_1470749240.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_image`
--

CREATE TABLE IF NOT EXISTS `evidence_image` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_image`
--

INSERT INTO `evidence_image` (`id`, `path`, `name`) VALUES
(5, '2016-08-10-57ab4aff000aeLighthouse.jpg', 'Lighthouse.jpg'),
(6, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(7, '2016-08-11-57ac106f52677Lighthouse.jpg', 'Lighthouse.jpg'),
(8, '2016-08-11-57ac1083a7ed4NEW.jpg', 'NEW.jpg'),
(9, '2016-08-11-57ac1d605d94aKoala.jpg', 'Koala.jpg'),
(10, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(11, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(12, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(13, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(14, '2016-08-11-57ac106f52677Lighthouse.jpg', 'Lighthouse.jpg'),
(16, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(17, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(18, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(19, '2016-08-10-57ab4c3844dafNEW.jpg', 'NEW.jpg'),
(21, '2016-08-11-57ac31e6ab948Hydrangeas.jpg', 'Hydrangeas.jpg'),
(22, '2016-08-11-57ac3212e0c6dJellyfish.jpg', 'Jellyfish.jpg'),
(23, '2016-08-11-57ac32c4af6c6Tulips_venki.jpg', 'Tulips_venki.jpg'),
(24, '2016-08-11-57ac32c4af6c6Tulips_venki.jpg', 'Tulips_venki.jpg'),
(25, '2016-08-11-57ac33105b2ffJellyfish.jpg', 'Jellyfish.jpg'),
(26, '2016-08-11-57ac3315982efTulips.jpg', 'Tulips.jpg'),
(28, '2016-08-11-57ac32c4af6c6Tulips_venki.jpg', 'Tulips_venki.jpg'),
(29, '2016-08-11-57ac32c4af6c6Tulips_venki.jpg', 'Tulips_venki.jpg'),
(30, '2016-08-11-57ac36f465427Jellyfish.jpg', 'Jellyfish.jpg'),
(31, '2016-08-11-57ac3e41b5283Penguins.jpg', 'Penguins.jpg'),
(32, '2016-08-11-57ac3e97a9999Desert.jpg', 'Desert.jpg'),
(33, '2016-08-11-57ac401fe9dc8Koala.jpg', 'Koala.jpg'),
(34, '2016-08-11-57ac409cccd1eKoala.jpg', 'Koala.jpg'),
(35, '2016-08-11-57ac43a5ab167Hydrangeas.jpg', 'Hydrangeas.jpg'),
(36, '2016-08-11-57ac43a5ab7d3Lighthouse.jpg', 'Lighthouse.jpg'),
(37, '2016-08-11-57ac43a5abf3eDesert.jpg', 'Desert.jpg'),
(38, '2016-08-11-57ac43a5ad5acJellyfish.jpg', 'Jellyfish.jpg'),
(39, '2016-08-11-57ac43a5af668Koala.jpg', 'Koala.jpg'),
(40, '2016-08-11-57ac43a72231fTulips.jpg', 'Tulips.jpg'),
(41, '2016-08-11-57ac43a724262Penguins.jpg', 'Penguins.jpg'),
(42, '2016-08-11-57ac51d504ef7Penguins.jpg', 'Penguins.jpg'),
(43, '2016-08-11-57ac51d5068aaTulips_venki.jpg', 'Tulips_venki.jpg'),
(44, '2016-08-11-57ac51fa8eafcHydrangeas.jpg', 'Hydrangeas.jpg'),
(46, '2016-08-11-57ac60ec20a5aChrysanthemum.jpg', 'Chrysanthemum.jpg'),
(47, '2016-08-11-57ac610d68287Desert.jpg', 'Desert.jpg'),
(50, '2016-08-11-57ac7a5189612Penguins.jpg', 'Penguins.jpg'),
(51, '2016-08-11-57ac7f31a6d89Tulips.jpg', 'Tulips.jpg'),
(52, '2016-08-11-57ac7f31a3fccLighthouse.jpg', 'Lighthouse.jpg'),
(53, '2016-08-11-57ac7f31a8478Penguins.jpg', 'Penguins.jpg'),
(54, '2016-08-11-57ac7f6160466Hydrangeas.jpg', 'Hydrangeas.jpg'),
(55, '2016-08-11-57ac7f615fb77Desert.jpg', 'Desert.jpg'),
(58, '2016-08-11-57ac8153f28b7Hydrangeas.jpg', 'Hydrangeas.jpg'),
(60, '2016-08-11-57ac847d9e52eHydrangeas.jpg', 'Hydrangeas.jpg'),
(61, '2016-08-11-57ac847d9e52fDesert.jpg', 'Desert.jpg'),
(62, '2016-08-11-57ac847d9e963Jellyfish.jpg', 'Jellyfish.jpg'),
(63, '2016-08-11-57ac85088e760Desert.jpg', 'Desert.jpg'),
(65, '2016-08-11-57ac85f595185Koala.jpg', 'Koala.jpg'),
(67, '2016-08-11-57ac60ec20a5aChrysanthemum.jpg', 'Chrysanthemum.jpg'),
(68, '2016-08-11-57ac610d68287Desert.jpg', 'Desert.jpg'),
(69, '2016-08-11-57ac60ec20a5aChrysanthemum.jpg', 'Chrysanthemum.jpg'),
(70, '2016-08-11-57ac610d68287Desert.jpg', 'Desert.jpg'),
(72, '2016-08-12-57ad3e189a1b0Penguins.jpg', 'Penguins.jpg'),
(73, '2016-08-12-57ad3e1899dd1Tulips.jpg', 'Tulips.jpg'),
(74, '2016-08-12-57ad5020607fePenguins.jpg', 'Penguins.jpg'),
(76, '2016-08-12-57ad58f822ad0Tulips.jpg', 'Tulips.jpg'),
(77, '2016-08-12-57ad591b04cb2Tulips.jpg', 'Tulips.jpg'),
(80, '2016-08-12-57ad595223a05Hydrangeas.jpg', 'Hydrangeas.jpg'),
(81, '2016-08-12-57ad598401b54Tulips.jpg', 'Tulips.jpg'),
(82, '2016-08-12-57ad59c6905caHydrangeas.jpg', 'Hydrangeas.jpg'),
(83, '2016-08-12-57ad5ae440dd1Tulips_venki.jpg', 'Tulips_venki.jpg'),
(84, '2016-08-12-57ad5b0de9c7cChrysanthemum.jpg', 'Chrysanthemum.jpg'),
(88, '2016-08-12-57ad65fdcce37Hydrangeas.jpg', 'Hydrangeas.jpg'),
(89, '2016-08-12-57ad65fdcc6e6Jellyfish.jpg', 'Jellyfish.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_recording`
--

CREATE TABLE IF NOT EXISTS `evidence_recording` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_text`
--

CREATE TABLE IF NOT EXISTS `evidence_text` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `self_assessment` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_text`
--

INSERT INTO `evidence_text` (`id`, `content`, `self_assessment`) VALUES
(20, 'effective ways of working\n\n2.1.	Jointly establish ground rules f\n\neffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules feffective ways of working\n\n2.1.	Jointly establish ground rules f', 1),
(27, 'of legislation and common law relevant to work role\n\n1.1	Demonstrate in all work, an understanding of the legal responsibilities and obligations of the work role\n\n1.2	Demonstrate key statutory and regulatory requirements relevant to the work role\n\nof legislation and common law relevant to work role\n\n1.1	Demonstrate in all work, an understanding of the legal responsibilities and obligations of the work role\n\n1.2	Demonstrate key statutory and regulatory requirements relevant to the work roleof legislation and common law relevant to work role\n\n1.1	Demonstrate in all work, an understanding of the legal responsibilities and obligations of the work role\n\n1.2	Demonstrate key statutory and regulatory requirements relevant to the work roleof legislation and common law relevant to work role\n\n1.1	Demonstrate in all work, an understanding of the legal responsibilities and obligations of the work role\n\n1.2	Demonstrate key statutory and regulatory requirements relevant to the work roleof legislation and common law relevant to work role\n\n1.1	Demonstrate in all work, an understanding of the legal responsibilities and obligations of the work role\n\n1.2	Demonstrate key statutory and regulatory requirements relevant to the work role', 1),
(45, 'testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing testing ', 1),
(48, 'CHC30113 Certificate III in Early Childhood Education and Care CHC30113 Certificate III in Early Childhood Education and Care CHC30113 Certificate III in Early Childhood Education and Care CHC30113 Certificate III in Early Childhood Education and Care CHC30113 Certificate III in Early Childhood Education and Care CHC30113 Certificate III in Early Childhood Education and Care CHC30113 Certificate III in Early Childhood Education and Care', 1),
(56, '1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage ', 1),
(57, '1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage 1.2	Supervise and engage ', 1),
(59, '€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r€™s health needs\n\n1.1 Communicate with families about childrenâ€™s health needs\n\n1.2 Maintain confidentiality in r', 1),
(66, '1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n1.3 Reflect on potential impact own background may have on interactions and relationships with people from other cultures\n\n', 1),
(71, '1.Create opportunities to maximise innovation within the team 1.Create opportunities to maximise innovation within the team 1.Create opportunities to maximise innovation within the team 1.Create opportunities to maximise innovation within the team 1.Create opportunities to maximise innovation within the team 1.Create opportunities to maximise innovation within the team 1.Create opportunities to maximise innovation within the team 1.Create opportunities to maximise innovation within the team', 1),
(75, 'HI I have done my graduation in the facilitate business analysis.  Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects\n\n\n\n\n\n', 1),
(78, 'HI I have done my graduation in the facilitate business analysis.  Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects\n\n\n\n\n\n', NULL),
(79, 'HI I have done my graduation in the facilitate business analysis.  Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects. Conduct a business case study for integrating sustainability in ICT planning and design projects\n\n\n\n\n\n', NULL),
(85, 'Testing of submitting the evidence for review  Testing of submitting the evidence for review Testing of submitting the evidence for review  Testing of submitting the evidence for review Testing of submitting the evidence for review  Testing of submitting the evidence for review Testing of submitting the evidence for review  Testing of submitting the evidence for review Testing of submitting the evidence for review  Testing of submitting the evidence for review Testing of submitting the evidence for review  Testing of submitting the evidence for review ', 1),
(86, 'I have added the evidence for the course which was opted. Please check the evidences and check the unit for review. PLease check it. I have added the evidence for the course which was opted. Please check the evidences and check the unit for review. PLease check it.I have added the evidence for the course which was opted. Please check the evidences and check the unit for review. PLease check it.', 1),
(87, 'I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences I have the evidences ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evidence_video`
--

CREATE TABLE IF NOT EXISTS `evidence_video` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_video`
--

INSERT INTO `evidence_video` (`id`, `path`, `name`) VALUES
(4, '2016-08-10-57ab44dbaa5a81001.mp4', '1001.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `faq_que` text NOT NULL,
  `faq_ans` text NOT NULL,
  `faq_sts` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1-Active,0-Inactive',
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `faq_que`, `faq_ans`, `faq_sts`) VALUES
(1, 'Can volunteer work be used as evidence?', 'Volunteering, work experience and internships can all be used if the experience you have gained relates to any of the units contained in the Qualification. Even hobby related activities may be used as evidence if you can provide samples which are relevant.', '1'),
(2, 'Can I use a family member as a reference if I work for a family business?', 'If you work for a family business you can ask a family member to provide a reference, however this must include a Statutory Declaration that is sighted and signed by a Justice of the Peace.', '1'),
(3, 'What is an RTO?', 'RTO means Registered Training Organisation. An RTO is required to conform to the Standards for Registered Training Organisations (RTOs) 2015 which is administered by the Australian Skills Quality Authority (ASQA). This ensures that the standard of training and assessment provided by RTOs meets the expected vocational benchmarks.', '1');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `unit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `to_user`, `from_user`, `subject`, `message`, `created`, `read_status`, `from_status`, `to_status`, `reply`, `replymid`, `unit_id`) VALUES
(1, 2, 1, 'Test message', 'Test message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message Test messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest messageTest message', '2016-08-10 15:08:21', 1, 0, 0, 0, 0, 0),
(2, 2, 1, 'Re: Test message', 'test reply test reply', '2016-08-10 15:09:15', 1, 0, 0, 0, 1, 0),
(3, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call VM Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 04:45:45', 1, 0, 0, 0, 0, 0),
(4, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Partial Evidence Received.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 04:45:51', 1, 0, 0, 0, 0, 0),
(5, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Evidence Being Reviewed.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 04:45:57', 1, 0, 0, 0, 0, 0),
(6, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Evidence Feedback Provided.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 04:46:01', 1, 0, 0, 0, 0, 0),
(7, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call Completed Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 04:46:05', 1, 0, 0, 0, 0, 0),
(8, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call VM Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:10:27', 1, 0, 0, 0, 0, 0),
(9, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to All Evidence Received.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:01', 1, 0, 0, 0, 0, 0),
(10, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Needs Follow Up With Candidate.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:09', 1, 0, 0, 0, 0, 0),
(11, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call Completed Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:11', 1, 0, 0, 0, 0, 0),
(12, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Partial Evidence Received.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:27', 1, 0, 0, 0, 0, 0),
(13, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call VM Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:30', 1, 0, 0, 0, 0, 0),
(14, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call Completed Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:33', 1, 0, 0, 0, 0, 0),
(15, 3, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:55', 1, 0, 0, 0, 0, 0),
(16, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:55', 1, 0, 0, 0, 0, 0),
(17, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call VM Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 05:11:58', 1, 0, 0, 0, 0, 0),
(18, 1, 2, 'CHC30113 - Certificate III in Early Childhood Education and Care', '', '2016-08-11 06:30:23', 1, 0, 0, 0, 0, 0),
(19, 2, 3, 'Re: Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Hi Kishore,\r\n\r\nPlease  check this', '2016-08-11 07:13:40', 1, 0, 0, 0, 15, 0),
(20, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call Completed Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 07:25:01', 1, 0, 0, 0, 0, 0),
(21, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call VM Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 07:25:59', 1, 0, 0, 0, 0, 0),
(22, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call Completed Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 08:48:23', 1, 0, 0, 0, 0, 0),
(23, 2, 3, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Kishore Thalla, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>Bala Krishnan\n', '2016-08-11 08:50:52', 1, 0, 0, 0, 0, 0),
(24, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 08:50:52', 1, 0, 0, 0, 0, 0),
(25, 2, 3, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Kishore Thalla, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFZFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Bala Krishnan\n', '2016-08-11 08:53:11', 1, 0, 0, 0, 0, 0),
(26, 1, 2, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFZFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 08:53:11', 1, 0, 0, 0, 0, 0),
(27, 2, 3, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Kishore Thalla, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFdjOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Bala Krishnan\n', '2016-08-11 09:06:41', 1, 0, 0, 0, 0, 0),
(28, 1, 2, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFdjOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 09:06:41', 1, 0, 0, 0, 0, 0),
(29, 2, 4, 'Test message', 'Test', '2016-08-11 09:29:46', 1, 0, 0, 0, 0, 0),
(30, 2, 1, 'Re: Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'testing', '2016-08-11 10:18:03', 1, 0, 0, 0, 28, 0),
(31, 2, 1, 'Test message', 'test', '2016-08-11 10:18:34', 1, 0, 0, 0, 0, 0),
(32, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Welcome Call VM Docs Sent.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 11:23:34', 1, 0, 0, 0, 0, 0),
(33, 1, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Partial Evidence Received.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 11:23:41', 1, 0, 0, 0, 0, 0),
(34, 2, 3, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Kishore Thalla, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFhjOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Bala Krishnan\n', '2016-08-11 11:49:12', 1, 0, 0, 0, 0, 0),
(35, 1, 2, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFhjOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 11:49:12', 1, 0, 0, 0, 0, 0),
(36, 2, 3, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Kishore Thalla, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VGtFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Bala Krishnan\n', '2016-08-11 11:52:40', 1, 0, 0, 0, 0, 0),
(37, 1, 2, 'Competency conversation invitation for - CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Venkaiah Kancharlapalli, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VGtFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 11:52:40', 1, 0, 0, 0, 0, 0),
(38, 2, 3, 'CHC30113 - Certificate III in Early Childhood Education and Care', 'Hi,\n\nPlease check the record', '2016-08-11 13:24:41', 1, 0, 0, 0, 0, 0),
(39, 1, 2, 'Evidenced are Not sufficient for the unit Develop cultural competence ', 'please add more evidence', '2016-08-11 14:07:04', 1, 0, 0, 0, 0, 2),
(40, 1, 2, 'Evidences disapproved for - CHC30113 : Certificate III in Early Childhood Education and Care - Unit : Develop cultural competence ', 'Dear Venkaiah Kancharlapalli, <br/><br/>  Qualification : CHC30113 - Certificate III in Early Childhood Education and Care<br/> Unit : CHCECE001 Develop cultural competence  <br/> Provided evidences for above unit are not yet competetent please add more evidences and get back to us.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-11 14:07:04', 1, 0, 0, 0, 0, 2),
(41, 1, 2, 'Re: Evidenced are Not sufficient for the unit Develop cultural competence ', ' m adding now ', '2016-08-11 14:10:18', 1, 0, 0, 0, 39, 0),
(42, 2, 5, ' Request', 'Hi Kishore,\r\n\r\nI am happy to be a part of this.\r\n\r\n', '2016-08-12 03:16:59', 1, 0, 0, 0, 0, 0),
(43, 2, 6, 'Test', 'Testing the email', '2016-08-12 04:21:45', 0, 0, 0, 0, 0, 0),
(44, 6, 2, 'Portfolio Update : ICT80115 : Graduate Certificate in Information Technology and Strategic Management', 'Dear sarath jampani, <br/>  Portfolio Status of : ICT80115 : Graduate Certificate in Information Technology and Strategic Management has been updated to Partial Evidence Received.<br/><br/> Regards, <br/>Kishore Thalla\n', '2016-08-12 04:48:25', 0, 0, 0, 0, 0, 0),
(45, 2, 1, 'test message', 'test message please validate my evidences', '2016-08-12 05:59:39', 1, 0, 0, 0, 0, 0),
(46, 1, 2, 'Evidenced are Not sufficient for the unit Provide care for babies and toddlers ', 'not satified with', '2016-08-12 06:34:49', 1, 0, 0, 0, 0, 28),
(47, 1, 2, 'Evidences disapproved for - CHC30113 : Certificate III in Early Childhood Education and Care - Unit : Provide care for babies and toddlers ', 'Dear Venkaiah Kancharlapalli, <br/><br/>  Qualification : CHC30113 - Certificate III in Early Childhood Education and Care<br/> Unit : CHCECE005 Provide care for babies and toddlers  <br/> Provided evidences for above unit are not yet competetent please add more evidences and get back to us.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-08-12 06:34:49', 0, 0, 0, 0, 0, 28),
(48, 2, 3, 'Competency conversation invitation for - 10480NAT-D : Graduate Diploma of Business Management (Hospitality)', 'Dear Hannah Hardy, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VGxFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>John Doe\n', '2016-08-12 06:56:05', 1, 0, 0, 0, 0, 0),
(49, 7, 2, 'Competency conversation invitation for - 10480NAT-D : Graduate Diploma of Business Management (Hospitality)', 'Dear ashok kumar, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VGxFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-08-12 06:56:05', 1, 0, 0, 0, 0, 0),
(50, 2, 3, 'Competency conversation invitation for - 10480NAT-D : Graduate Diploma of Business Management (Hospitality)', 'Dear Hannah Hardy, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VG1jOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>John Doe\n', '2016-08-12 06:59:19', 0, 0, 0, 0, 0, 0),
(51, 7, 2, 'Competency conversation invitation for - 10480NAT-D : Graduate Diploma of Business Management (Hospitality)', 'Dear ashok kumar, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VG1jOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-08-12 06:59:19', 0, 0, 0, 0, 0, 0),
(52, 2, 3, 'Competency conversation invitation for - 10480NAT-D : Graduate Diploma of Business Management (Hospitality)', 'Dear Hannah Hardy, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VG5jOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>John Doe\n', '2016-08-12 07:00:31', 0, 0, 0, 0, 0, 0),
(53, 7, 2, 'Competency conversation invitation for - 10480NAT-D : Graduate Diploma of Business Management (Hospitality)', 'Dear ashok kumar, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VG5jOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-08-12 07:00:31', 0, 0, 0, 0, 0, 0),
(54, 3, 2, 'All evidences are enough competent in - ICT80115 : Graduate Certificate in Information Technology and Strategic Management', 'Dear John Doe, <br/>  All the evidences for the Qualification : ICT80115 : Graduate Certificate in Information Technology and Strategic Management are enough competent. <br/>  Qualification and portfolio has been submitted to you.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-08-12 12:03:34', 0, 0, 0, 0, 0, 0),
(55, 6, 2, 'All evidences are enough competent in - ICT80115 : Graduate Certificate in Information Technology and Strategic Management', 'Dear sarath jampani, <br/>  All the evidences for the Qualification : ICT80115 : Graduate Certificate in Information Technology and Strategic Management are enough competent. <br/>  Qualification and portfolio has been submitted to Assessor.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-08-12 12:03:34', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` text NOT NULL,
  `unit_id` int(11) NOT NULL,
  `course_id` int(10) DEFAULT '0',
  `type` enum('a','f') NOT NULL COMMENT 'a=assessor, f=facilitator',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id`, `note`, `unit_id`, `course_id`, `type`, `created`) VALUES
(1, 'noo', 0, 4, 'f', '2016-08-12 12:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `other_files`
--

CREATE TABLE IF NOT EXISTS `other_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `size` int(20) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE IF NOT EXISTS `reminder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `reminder`
--

INSERT INTO `reminder` (`id`, `user_course_id`, `user_id`, `date`, `message`, `completed`, `completed_date`, `created`, `created_by`, `type`, `reminder_type_id`) VALUES
(1, NULL, 2, '2016-08-12 00:00:00', 'need to complete as early as possible', 1, '2016-08-12 16:18:23', '2016-08-12 06:17:53', 2, 'message', 45),
(2, 4, 2, '2016-08-12 00:00:00', '', 0, NULL, '2016-08-12 07:47:58', 2, 'portfolio', 4),
(3, 3, 2, '2016-08-12 00:00:00', 'yes need to check ', 0, NULL, '2016-08-12 07:48:28', 2, 'portfolio', 3),
(4, 1, 2, '2016-08-12 00:00:00', 'is this correct ', 0, NULL, '2016-08-12 07:48:53', 2, 'portfolio', 1),
(5, NULL, 2, '2016-08-12 00:00:00', 'pol', 0, NULL, '2016-08-12 07:51:24', 2, 'evidence', 83),
(6, NULL, 2, '2016-08-12 00:00:00', 'need to ', 0, NULL, '2016-08-12 07:52:05', 2, 'evidence', 84);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` char(255) DEFAULT NULL,
  `assessor` int(11) DEFAULT NULL,
  `applicant` int(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `sessionid`, `assessor`, `applicant`, `created`) VALUES
(1, '1_MX40NTYzMDg4Mn5-MTQ3MDkwNTU5Nzk0NH4wWmMvVTF2RlFBbGRNbXpib2YvbTZOUDF-fg', 3, 1, '2016-08-11 08:53:11'),
(2, '2_MX40NTYzMDg4Mn5-MTQ3MDkwNjQwODU2N35wNityeHN2aVc3RXpXZVdUNGE5WVUvWmd-fg', 3, 1, '2016-08-11 09:06:41'),
(3, '1_MX40NTYzMDg4Mn5-MTQ3MDkxNjE1OTA4M35wSEZxN0g2TXk5MHMvbzNqbUNiYXNvVmV-fg', 3, 1, '2016-08-11 11:49:12'),
(4, '1_MX40NTYzMDg4Mn5-MTQ3MDkxNjM2NzA0NX5VZU50V0MwSkFrNi9QSkN6aTRKL0lzaUx-fg', 3, 1, '2016-08-11 11:52:40'),
(5, '2_MX40NTYzMDg4Mn5-MTQ3MDk4NDk3MjQ3Nn44dDd1UVRheTBjR3BURW5OOEJOQ0lVUkp-fg', 3, 7, '2016-08-12 06:56:05'),
(6, '2_MX40NTYzMDg4Mn5-MTQ3MDk4NTE2NjUxNH5kcWJteUpGMlFsTithRUdMME9sTTc0RlR-fg', 3, 7, '2016-08-12 06:59:19'),
(7, '1_MX40NTYzMDg4Mn5-MTQ3MDk4NTIzODA5OH5oeFNHSXhjTHg5eGUyQlFTc1cwaEJ3SHB-fg', 3, 7, '2016-08-12 07:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file`
--

CREATE TABLE IF NOT EXISTS `tbl_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fileName` varchar(500) NOT NULL DEFAULT '',
  `filePath` varchar(1000) NOT NULL DEFAULT '',
  `fileSize` int(10) unsigned DEFAULT '0',
  `category` enum('daily','weekly','monthly') NOT NULL DEFAULT 'daily',
  `reportDate` date NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Used to store data about individual pics' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(250) NOT NULL DEFAULT '',
  `lastName` varchar(250) NOT NULL DEFAULT '',
  `emailId` varchar(150) NOT NULL DEFAULT '0',
  `password` varchar(150) NOT NULL DEFAULT '0',
  `userType` enum('Admin','Normal') NOT NULL DEFAULT 'Normal',
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_files`
--

CREATE TABLE IF NOT EXISTS `tbl_user_files` (
  `userId` int(10) unsigned NOT NULL DEFAULT '0',
  `fileId` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `FK_tbl_user_files_tbl_user` (`userId`),
  KEY `FK_tbl_user_files_tbl_file` (`fileId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `date_of_birth`, `gender`, `universal_student_identifier`, `role_type`, `user_img`, `password_token`, `token_expiry`, `token_status`, `course_condition_status`, `contact_name`, `contact_phone`, `contact_email`, `updated`, `created`, `ceo_name`, `ceo_email`, `ceo_phone`, `created_by`, `status`, `crm_id`, `applicantStatus`) VALUES
(1, 'Venkaiah', 'Kancharlapalli', 'venkaiah.kancharlapalli@valuelabs.com', '$2y$10$N.i9nOS17GuW7nC80ITzN.nO/cmQeNuOv9eCvD9.7wQGcD47nvzi.', '919441134888', '30-12-1981', 'male', 'ASDF345667', 1, '1439985856-Desert.jpg', '57ab3d2586d68', '2016-08-11 16:41:41', '0', '0', '', '', '', '2016-08-10 14:40:08', '0000-00-00 00:00:00', '', '', '', 0, '1', '', 0),
(2, 'Hannah', 'Hardy', 'kishore.thalla@valuelabs.com', '$2y$10$3W/SZMu7RF28C6I/OzvZmOsZan8dWnqVXrdQYFpRFCTGr17RnxNH.', '9879877689', '01/21/1985', 'male', '12', 2, '1425907325-image.jpg', '57ab3fde203c8', '2016-08-11 16:53:18', '0', '0', NULL, NULL, 'kishore.thalla@valuelabs.com', '2016-08-10 14:50:56', '0000-00-00 00:00:00', NULL, NULL, NULL, 0, '1', '123456', 0),
(3, 'John', 'Doe', 'bala.gajendiran@valuelabs.com', '$2y$10$3W/SZMu7RF28C6I/OzvZmOsZan8dWnqVXrdQYFpRFCTGr17RnxNH.', '123456789', '01/21/1981', 'male', '', 3, '1439985856-Desert.jpg', '', '0000-00-00 00:00:00', '1', '0', NULL, NULL, NULL, '2016-08-10 16:26:04', '0000-00-00 00:00:00', NULL, NULL, NULL, 0, '1', NULL, 0),
(4, 'Get Qualified Australia', '10480NAT', 'madhavi.garimella@valuelabs.com', '$2y$10$3W/SZMu7RF28C6I/OzvZmOsZan8dWnqVXrdQYFpRFCTGr17RnxNH.', '', '01/21/1983', 'female', '', 4, '1425907325-image.jpg', '', '0000-00-00 00:00:00', '1', '0', 'MIS', '12345678', NULL, '2016-08-10 16:26:04', '0000-00-00 00:00:00', NULL, NULL, NULL, 0, '1', NULL, 0),
(6, 'sarath', 'jampani', 'sarath.jampani@valuelabs.com', '$2y$10$sMjdkqSqYSihVdKvIdgpEOA2Mvi9AimEt.aZ3D9xp7sJEHcan71o.', '919441134888', '30-12-1981', 'male', 'ASDF345667', 1, '1425907325-image.jpg', '', '0000-00-00 00:00:00', '1', '0', '', '', '', '2016-08-12 04:12:29', '0000-00-00 00:00:00', '', '', '', 0, '1', '', 0),
(7, 'ashok', 'kumar', 'ashok.chelikani@valuelabs.com', '$2y$10$p1E1pd8G9l4G3R.nc9YlrOco6ockET54FHEQCkSIq6w0aj7wPg/Vy', '919441134888', '30-12-1981', 'male', 'ASDF345667', 1, '', '57ad56ce0d42d', '2016-08-12 06:55:42', '1', '', '', '', '', '2016-08-12 04:55:00', '0000-00-00 00:00:00', '', '', '', 0, '1', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` varchar(150) NOT NULL,
  `area` varchar(150) DEFAULT NULL,
  `suburb` varchar(150) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `pincode` varchar(10) NOT NULL,
  `updated` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_users_address1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address`, `area`, `suburb`, `city`, `state`, `country`, `pincode`, `updated`, `created`) VALUES
(1, 1, '200', 'Broadway Av', 'WEST BEACH', 'sydney', 'SA', 'Australia', '5024', '0000-00-00 00:00:00', '2016-08-10 14:40:08'),
(2, 2, '', NULL, NULL, NULL, NULL, NULL, '', '0000-00-00 00:00:00', '2016-08-10 16:27:54'),
(3, 3, '13', 'Broadway Av', 'Sudburn', 'Melbourne', 'NSW', 'Australia', '5023', '0000-00-00 00:00:00', '2016-08-10 16:27:54'),
(4, 4, '200', 'Broadway Av', 'New south Wales', 'SA', 'SA', 'Australia', '5023', '0000-00-00 00:00:00', '2016-08-10 16:27:54'),
(5, 5, '11', 'Albert Steert', 'Redfern', 'Sydney', 'New South Wales', 'Australia', '2151', '0000-00-00 00:00:00', '2016-08-11 18:02:43'),
(6, 6, '11', 'Albert Steert', 'Redfern', 'Sydney', 'New South Wales', 'Australia', '2151', '0000-00-00 00:00:00', '2016-08-12 04:12:29'),
(7, 7, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2016-08-12 04:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE IF NOT EXISTS `user_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_status` int(11) NOT NULL COMMENT '1 - current, 0 - completed, 2-FacilitatorApproved, 3-Assessor Approved, 15- Submitted to RTO, 16- RTO Issued certificate',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `facilitator` int(11) NOT NULL,
  `assessor` int(11) DEFAULT NULL,
  `rto` int(11) DEFAULT NULL,
  `facilitator_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- pending, 1 - approved',
  `assessor_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- pending, 1 - approved',
  `rto_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- pending, 1 - approved',
  `facilitator_date` datetime DEFAULT NULL,
  `assessor_date` datetime DEFAULT NULL,
  `rto_date` datetime DEFAULT NULL,
  `target_date` datetime NOT NULL,
  `zoho_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_code` (`course_code`),
  KEY `course_name` (`course_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_id`, `course_code`, `course_name`, `course_status`, `created_on`, `facilitator`, `assessor`, `rto`, `facilitator_status`, `assessor_status`, `rto_status`, `facilitator_date`, `assessor_date`, `rto_date`, `target_date`, `zoho_id`) VALUES
(1, 1, 'CHC30113', 'Certificate III in Early Childhood Education and Care', 15, '2016-08-10 14:54:42', 2, 3, 4, 1, 1, 0, '2016-08-08 00:00:00', NULL, NULL, '2016-11-02 00:00:00', NULL),
(3, 6, 'ICT80115', 'Graduate Certificate in Information Technology and Strategic Management', 2, '0000-00-00 00:00:00', 2, 3, 4, 1, 0, 0, '2016-08-12 22:03:34', NULL, NULL, '2016-10-27 14:11:29', '34545'),
(4, 7, '10480NAT-D', 'Graduate Diploma of Business Management (Hospitality)', 2, '0000-00-00 00:00:00', 2, 3, 4, 1, 0, 0, NULL, NULL, NULL, '2016-11-10 14:11:00', '34545');

-- --------------------------------------------------------

--
-- Table structure for table `user_course_units`
--

CREATE TABLE IF NOT EXISTS `user_course_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `unit_id` varchar(100) NOT NULL,
  `course_code` varchar(100) NOT NULL,
  `type` varchar(255) NOT NULL,
  `facilitator_status` tinyint(1) NOT NULL DEFAULT '0',
  `assessor_status` tinyint(1) NOT NULL DEFAULT '0',
  `rto_status` tinyint(1) DEFAULT '0',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '0- inactive, 1 - active',
  `elective_status` int(2) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `user_course_units`
--

INSERT INTO `user_course_units` (`id`, `user_id`, `unit_id`, `course_code`, `type`, `facilitator_status`, `assessor_status`, `rto_status`, `status`, `elective_status`, `created_on`) VALUES
(1, 1, 'CHCCS400C', 'CHC30113', 'core', 1, 1, 0, '1', 0, '2016-08-11 04:51:54'),
(2, 1, 'CHCECE001', 'CHC30113', 'core', 2, 0, 0, '1', 0, '2016-08-11 04:51:54'),
(3, 1, 'CHCECE002', 'CHC30113', 'core', 1, 0, 0, '1', 0, '2016-08-11 04:51:54'),
(4, 1, 'CHCECE003', 'CHC30113', 'core', 1, 0, 0, '1', 0, '2016-08-11 04:51:54'),
(5, 1, 'BSBINN301A', 'CHC30113', 'elective', 1, 0, 0, '1', 1, '2016-08-11 04:51:54'),
(6, 1, 'BSBSUS301A', 'CHC30113', 'elective', 0, 0, 0, '1', 1, '2016-08-11 04:51:54'),
(7, 5, 'BSBWOR204A', 'CHC30113', 'core', 1, 1, 0, '1', 0, '2016-08-11 04:51:54'),
(8, 6, 'BSBLDR803', 'ICT80115', 'elective', 1, 0, 0, '1', 1, '2016-08-12 04:22:47'),
(9, 6, 'ICTICT801', 'ICT80115', 'elective', 0, 0, 0, '0', 0, '2016-08-12 04:22:47'),
(10, 6, 'ICTICT802', 'ICT80115', 'elective', 0, 0, 0, '0', 1, '2016-08-12 04:22:47'),
(11, 6, 'ICTICT803', 'ICT80115', 'elective', 0, 0, 0, '0', 0, '2016-08-12 04:22:47'),
(12, 6, 'ICTICT804', 'ICT80115', 'elective', 0, 0, 0, '0', 1, '2016-08-12 04:22:47'),
(13, 6, 'ICTICT805', 'ICT80115', 'elective', 0, 0, 0, '0', 1, '2016-08-12 04:22:47'),
(14, 6, 'ICTICT806', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(15, 6, 'ICTICT807', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(16, 6, 'ICTICT808', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(17, 6, 'ICTICT809', 'ICT80115', 'core', 1, 0, 0, '1', NULL, '2016-08-12 04:22:47'),
(18, 6, 'ICTICT810', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(19, 6, 'ICTICT811', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(20, 6, 'ICTICT812', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(21, 6, 'ICTICT813', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(22, 6, 'ICTICT814', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(23, 6, 'ICTSUS7236A', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(24, 6, 'ICTSUS801', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(25, 6, 'ICTSUS802', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(26, 6, 'ICTSUS804', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:22:47'),
(27, 1, 'CHCECE004', 'CHC30113', 'core', 1, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(28, 1, 'CHCECE005', 'CHC30113', 'core', 2, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(29, 1, 'CHCECE006', 'CHC30113', 'elective', 0, 0, 0, '0', 1, '2016-08-12 04:48:50'),
(30, 1, 'CHCECE007', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(31, 1, 'CHCECE009', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(32, 1, 'CHCECE010', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(33, 1, 'CHCECE011', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(34, 1, 'CHCECE012', 'CHC30113', 'elective', 0, 0, 0, '0', 1, '2016-08-12 04:48:50'),
(35, 1, 'CHCECE013', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(36, 1, 'CHCECE014', 'CHC30113', 'elective', 0, 0, 0, '0', 0, '2016-08-12 04:48:50'),
(37, 1, 'CHCECE015', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:48:50'),
(38, 1, 'CHCECE017', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:48:50'),
(39, 1, 'CHCORG303C', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:48:50'),
(40, 1, 'CHCPRT001', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(41, 1, 'CHCPRT003', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:48:50'),
(42, 1, 'CHCSAC004', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:48:50'),
(43, 1, 'HLTAID004', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(44, 1, 'HLTHIR403C', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:48:50'),
(45, 1, 'HLTHIR404D', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(46, 1, 'HLTWHS001', 'CHC30113', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:48:50'),
(47, 1, 'SRCCRO008B', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:48:51'),
(48, 7, 'BSBINN801A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(49, 7, 'BSBITB701A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(50, 7, 'BSBFIM701A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(51, 7, 'MSS408005A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(52, 7, 'MSS408007A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(53, 7, 'MSS017004A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(54, 7, 'MSS027010A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(55, 7, 'BSBRES801A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, '2016-08-12 04:57:24'),
(56, 7, 'SITXINV601', '10480NAT-D', 'elective', 0, 0, 0, '0', NULL, '2016-08-12 04:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_ids`
--

CREATE TABLE IF NOT EXISTS `user_ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(150) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_ids_ibfk_1` (`user_id`),
  KEY `user_ids_ibfk_2` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_ids`
--

INSERT INTO `user_ids` (`id`, `user_id`, `type`, `name`, `path`, `created`, `size`) VALUES
(5, 1, 8, 'Jellyfish.jpg', '2016-08-12-57ad5c39297d7Jellyfish.jpg', '2016-08-12 05:18:57', '775702'),
(7, 1, 5, 'Jellyfish.jpg', '2016-08-12-57ad62d30c3b7Jellyfish.jpg', '2016-08-12 05:47:08', '775702');

--
-- Constraints for dumped tables
--

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
-- Constraints for table `user_ids`
--
ALTER TABLE `user_ids`
  ADD CONSTRAINT `user_ids_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ids_ibfk_2` FOREIGN KEY (`type`) REFERENCES `document_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
