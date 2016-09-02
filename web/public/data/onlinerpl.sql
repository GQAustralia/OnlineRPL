-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 02, 2016 at 08:36 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `onlinerpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `document_type`
--

CREATE TABLE IF NOT EXISTS `document_type` (
  `id` int(2) NOT NULL,
  `type` varchar(150) NOT NULL,
  `points` int(2) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

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
  `id` int(11) NOT NULL,
  `size` varchar(20) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_code` varchar(50) DEFAULT NULL,
  `course_code` varchar(100) DEFAULT NULL,
  `job_id` varchar(100) DEFAULT NULL,
  `facilitator_view_status` enum('0','1') NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence`
--

INSERT INTO `evidence` (`id`, `size`, `type`, `user_id`, `unit_code`, `course_code`, `job_id`, `facilitator_view_status`, `created`) VALUES
(2, '5KB', 'image', 16, '', '', '', '0', '2016-08-30 09:38:38'),
(3, '8KB', 'image', 16, '', '', '', '0', '2016-08-30 09:38:38'),
(4, '5KB', 'image', 16, '', '', '', '0', '2016-08-30 09:38:38'),
(5, '10KB', 'image', 16, '', '', '', '0', '2016-08-30 09:38:38'),
(6, '8KB', 'image', 16, '', '', '', '0', '2016-08-30 09:38:38'),
(7, '8KB', 'image', 16, 'CPCCCA3021A', 'CPC31511', '', '0', '2016-08-30 09:39:12'),
(8, NULL, 'text', 16, 'CPCCCA3021A', 'CPC31511', '', '0', '2016-08-30 09:39:51'),
(9, '548KB', 'image', 16, 'CPCCCA3015A', 'CPC31511', '', '0', '2016-08-30 09:40:30'),
(11, '39KB', 'image', 16, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-30 09:49:05'),
(12, NULL, 'text', 16, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-30 09:50:24'),
(15, NULL, 'text', 16, 'CPCCCA3015A', 'CPC31511', '', '0', '2016-08-30 09:58:54'),
(17, '5KB', 'image', 16, 'CPCCCA3019A', 'CPC31511', '', '0', '2016-08-30 10:00:59'),
(18, NULL, 'text', 16, 'CPCCCA3019A', 'CPC31511', '', '0', '2016-08-30 10:01:13'),
(19, '8MB', 'image', 16, 'CPCCCM3001C', 'CPC31511', '', '0', '2016-08-30 10:03:48'),
(20, NULL, 'text', 16, 'CPCCCM3001C', 'CPC31511', '', '0', '2016-08-30 10:05:45'),
(21, '5KB', 'image', 16, 'RIIOHS202A', 'CPC31511', '', '0', '2016-08-30 10:10:25'),
(22, NULL, 'text', 16, 'RIIOHS202A', 'CPC31511', '', '0', '2016-08-30 10:10:36'),
(23, '548KB', 'image', 16, 'CPCCCA3022A', 'CPC31511', '', '0', '2016-08-30 10:11:14'),
(24, NULL, 'text', 16, 'CPCCCA3022A', 'CPC31511', '', '0', '2016-08-30 10:11:30'),
(25, NULL, 'text', 16, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-30 10:20:45'),
(27, '10KB', 'image', 16, 'CPCCCM1013A', 'CPC31511', '', '0', '2016-08-30 10:26:05'),
(28, NULL, 'text', 16, 'CPCCCM1013A', 'CPC31511', '', '0', '2016-08-30 10:26:54'),
(29, NULL, 'text', 16, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-30 10:32:24'),
(30, '5KB', 'image', 16, 'CPCCCA2002B', 'CPC31511', '', '0', '2016-08-30 10:37:16'),
(31, NULL, 'text', 16, 'CPCCCA2002B', 'CPC31511', '', '0', '2016-08-30 10:37:48'),
(32, '5KB', 'image', 16, 'CPCCCO2013A', 'CPC31511', '', '0', '2016-08-30 10:40:01'),
(33, NULL, 'text', 16, 'CPCCCO2013A', 'CPC31511', '', '0', '2016-08-30 10:40:15'),
(34, '5KB', 'image', 16, 'CPCCCA2002B', 'CPC31511', '', '0', '2016-08-30 10:57:03'),
(35, NULL, 'text', 16, 'CPCCCA3022A', 'CPC31511', '', '0', '2016-08-30 11:07:07'),
(36, NULL, 'text', 16, 'RIIOHS202A', 'CPC31511', '', '0', '2016-08-30 11:07:50'),
(37, NULL, 'text', 16, 'CPCCCM3001C', 'CPC31511', '', '0', '2016-08-30 11:30:42'),
(38, '5KB', 'image', 16, 'CPCCCA3001A', 'CPC31511', '', '0', '2016-08-30 11:31:07'),
(39, NULL, 'text', 16, 'CPCCCA3001A', 'CPC31511', '', '0', '2016-08-30 11:31:35'),
(40, '5KB', 'image', 16, 'CPCCCM2001A', 'CPC31511', '', '0', '2016-08-30 11:31:59'),
(41, NULL, 'text', 16, 'CPCCCM2001A', 'CPC31511', '', '0', '2016-08-30 11:32:08'),
(42, '8KB', 'image', 16, 'CPCCCA3023A', 'CPC31511', '', '0', '2016-08-30 11:32:37'),
(43, NULL, 'text', 16, 'CPCCCA3023A', 'CPC31511', '', '0', '2016-08-30 11:32:48'),
(44, '548KB', 'image', 16, 'CPCCCA2011A', 'CPC31511', '', '0', '2016-08-30 11:33:35'),
(45, NULL, 'text', 16, 'CPCCCA2011A', 'CPC31511', '', '0', '2016-08-30 11:33:47'),
(46, '10KB', 'image', 16, 'CPCCCM1014A', 'CPC31511', '', '0', '2016-08-30 11:34:16'),
(47, '10KB', 'image', 16, 'CPCCCM1014A', 'CPC31511', '', '0', '2016-08-30 11:34:18'),
(48, NULL, 'text', 16, 'CPCCCM1014A', 'CPC31511', '', '0', '2016-08-30 11:34:33'),
(49, '8KB', 'image', 16, 'CPCCCM1012A', 'CPC31511', '', '0', '2016-08-30 11:35:03'),
(50, NULL, 'text', 16, 'CPCCCM1012A', 'CPC31511', '', '0', '2016-08-30 11:35:12'),
(51, '39KB', 'image', 16, 'CPCCCA3002A', 'CPC31511', '', '0', '2016-08-30 11:36:05'),
(52, '39KB', 'image', 16, 'CPCCCA3002A', 'CPC31511', '', '0', '2016-08-30 11:36:07'),
(53, NULL, 'text', 16, 'CPCCCA3002A', 'CPC31511', '', '0', '2016-08-30 11:36:19'),
(54, '8KB', 'image', 16, 'CPCCCM2002A', 'CPC31511', '', '0', '2016-08-30 11:36:56'),
(55, NULL, 'text', 16, 'CPCCCM2002A', 'CPC31511', '', '0', '2016-08-30 11:37:08'),
(56, '8KB', 'image', 16, 'CPCCOHS2001A', 'CPC31511', '', '0', '2016-08-30 11:37:44'),
(57, NULL, 'text', 16, 'CPCCOHS2001A', 'CPC31511', '', '0', '2016-08-30 11:37:53'),
(58, '8KB', 'image', 16, 'CPCCCM2010B', 'CPC31511', '', '0', '2016-08-30 11:38:26'),
(59, NULL, 'text', 16, 'CPCCCM2010B', 'CPC31511', '', '0', '2016-08-30 11:38:36'),
(60, '5KB', 'image', 16, 'CPCCCM2007B', 'CPC31511', '', '0', '2016-08-30 11:39:08'),
(61, '5KB', 'image', 16, 'CPCCCM2007B', 'CPC31511', '', '0', '2016-08-30 11:39:09'),
(65, '758KB', 'image', 1, '', '', '', '0', '2016-08-30 11:50:01'),
(66, '758KB', 'image', 1, '', '', '', '0', '2016-08-30 11:50:42'),
(67, '25MB', 'video', 1, '', '', '1472557979181-kjwacb', '0', '2016-08-30 11:52:46'),
(68, '250KB', 'image', 1, '', '', '', '0', '2016-08-30 13:18:52'),
(69, '250KB', 'image', 1, 'CHCCS400C', 'CHC30113', '', '0', '2016-08-30 14:36:37'),
(72, '5KB', 'image', 18, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-31 10:08:50'),
(73, '5KB', 'image', 18, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-31 10:08:50'),
(74, '8KB', 'image', 18, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-31 10:08:50'),
(75, '8KB', 'image', 18, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-31 10:08:51'),
(76, '10KB', 'image', 18, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-31 10:08:51'),
(77, NULL, 'text', 18, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-08-31 10:09:03'),
(78, '71KB', 'image', 1, '', '', '', '0', '2016-08-31 10:10:08'),
(79, '10KB', 'image', 18, 'CPCCCA3022A', 'CPC31511', '', '1', '2016-08-31 10:11:19'),
(83, '10KB', 'image', 18, 'CPCCCM1013A', 'CPC31511', '', '0', '2016-08-31 10:41:21'),
(86, NULL, 'text', 18, 'CPCCCM1013A', 'CPC31511', '', '0', '2016-08-31 10:46:06'),
(89, NULL, 'text', 18, 'CPCCCA2002B', 'CPC31511', '', '0', '2016-08-31 10:49:42'),
(90, NULL, 'text', 18, 'CPCCCA2002B', 'CPC31511', '', '0', '2016-08-31 10:50:12'),
(91, '5KB', 'image', 18, 'CPCCCO2013A', 'CPC31511', '', '1', '2016-08-31 11:04:13'),
(92, NULL, 'text', 18, 'CPCCCO2013A', 'CPC31511', '', '1', '2016-08-31 11:04:30'),
(93, '5KB', 'image', 18, 'CPCCCA3001A', 'CPC31511', '', '0', '2016-08-31 11:13:33'),
(94, NULL, 'text', 18, 'CPCCCA3001A', 'CPC31511', '', '0', '2016-08-31 11:13:45'),
(95, '8KB', 'image', 18, 'CPCCCM2001A', 'CPC31511', '', '1', '2016-08-31 11:14:08'),
(96, NULL, 'text', 18, 'CPCCCM2001A', 'CPC31511', '', '1', '2016-08-31 11:14:19'),
(97, '758KB', 'image', 18, 'CPCCCM1014A', 'CPC31511', '', '1', '2016-08-31 11:14:59'),
(98, NULL, 'text', 18, 'CPCCCM1014A', 'CPC31511', '', '0', '2016-08-31 11:15:20'),
(99, '1MB', 'video', 18, '', '', '', '0', '2016-08-31 12:00:35'),
(100, '859KB', 'image', 18, 'CPCCCM1015A', 'CPC31511', '', '1', '2016-08-31 12:06:15'),
(101, NULL, 'text', 18, 'CPCCCM1015A', 'CPC31511', '', '1', '2016-08-31 12:07:26'),
(102, '548KB', 'image', 18, 'CPCCCM2007B', 'CPC31511', '', '0', '2016-08-31 12:09:54'),
(103, NULL, 'text', 18, 'CPCCCM2007B', 'CPC31511', '', '0', '2016-08-31 12:10:19'),
(104, NULL, 'text', 18, 'CPCCCM2007B', 'CPC31511', '', '0', '2016-08-31 12:10:21'),
(105, '1MB', 'video', 18, 'CPCCCM2010B', 'CPC31511', '', '0', '2016-08-31 12:10:48'),
(106, NULL, 'text', 18, 'CPCCCM2010B', 'CPC31511', '', '0', '2016-08-31 12:10:58'),
(107, '25MB', 'video', 18, '', '', '1472646341167-b37ql8', '0', '2016-08-31 12:25:28'),
(108, '25MB', 'video', 18, 'RIIOHS202A', 'CPC31511', '1472646459548-jjv4tp', '1', '2016-08-31 12:27:26'),
(109, NULL, 'text', 18, 'RIIOHS202A', 'CPC31511', '', '1', '2016-08-31 12:27:44'),
(110, '8MB', 'audio', 18, 'CPCCCA3023A', 'CPC31511', '1472646511815-57k7ya', '0', '2016-08-31 12:28:18'),
(111, NULL, 'text', 18, 'CPCCCA3023A', 'CPC31511', '', '0', '2016-08-31 12:28:29'),
(112, '4MB', 'audio', 18, 'CPCCCA3016A', 'CPC31511', '1472646574308-517hg9', '1', '2016-08-31 12:29:21'),
(113, NULL, 'text', 18, 'CPCCCA3016A', 'CPC31511', '', '0', '2016-08-31 12:31:33'),
(114, '5MB', 'audio', 18, 'CPCCCA3018A', 'CPC31511', '1472646947913-s9srzo', '0', '2016-08-31 12:35:34'),
(115, NULL, 'text', 18, 'CPCCCA3018A', 'CPC31511', '', '0', '2016-08-31 12:54:22'),
(116, '861 bytes', 'image', 18, 'CPCCOHS2001A', 'CPC31511', '', '0', '2016-08-31 12:56:48'),
(117, NULL, 'text', 18, 'CPCCOHS2001A', 'CPC31511', '', '0', '2016-08-31 12:57:12'),
(118, '8MB', 'audio', 18, 'CPCCSF2003A', 'CPC31511', '1472648321287-ad92f3', '0', '2016-08-31 12:58:28'),
(119, NULL, 'text', 18, 'CPCCSF2003A', 'CPC31511', '', '0', '2016-08-31 12:58:48'),
(120, '8MB', 'audio', 18, 'BSBSMB301A', 'CPC31511', '', '0', '2016-08-31 13:01:03'),
(121, NULL, 'text', 18, 'BSBSMB301A', 'CPC31511', '', '0', '2016-08-31 13:01:15'),
(122, NULL, 'text', 18, 'BSBSMB406A', 'CPC31511', '', '0', '2016-08-31 13:02:37'),
(123, NULL, 'text', 18, 'BSBSMB406A', 'CPC31511', '', '0', '2016-08-31 13:02:43'),
(124, '5MB', 'audio', 18, 'CPCCCA2011A', 'CPC31511', '', '0', '2016-08-31 13:07:02'),
(125, NULL, 'text', 18, 'CPCCCA2011A', 'CPC31511', '', '0', '2016-08-31 13:08:31'),
(126, '26KB', 'file', 18, 'CPCCCM1012A', 'CPC31511', '', '0', '2016-08-31 13:09:11'),
(127, NULL, 'text', 18, 'CPCCCM1012A', 'CPC31511', '', '0', '2016-08-31 13:09:20'),
(128, '8KB', 'image', 18, 'CPCCCM2002A', 'CPC31511', '', '0', '2016-08-31 13:10:40'),
(129, NULL, 'text', 18, 'CPCCCM2002A', 'CPC31511', '', '0', '2016-08-31 13:10:57'),
(130, '8KB', 'image', 18, 'CPCCCA3002A', 'CPC31511', '', '0', '2016-08-31 13:11:25'),
(131, NULL, 'text', 18, 'CPCCCA3002A', 'CPC31511', '', '0', '2016-08-31 13:11:36'),
(132, NULL, 'text', 18, 'CPCCCM2002A', 'CPC31511', '', '0', '2016-08-31 13:22:13'),
(134, '10KB', 'image', 19, 'CPCCCM2008B', 'CPC31511', '', '1', '2016-08-31 15:00:24'),
(136, '9KB', 'image', 1, '', '', '', '0', '2016-08-31 16:12:54'),
(137, '2KB', 'image', 19, '', '', '', '0', '2016-09-01 05:53:09'),
(138, '212KB', 'image', 13, 'CHCECE010', 'CHC30113', '', '0', '2016-09-01 09:28:59'),
(139, NULL, 'text', 13, 'CHCECE010', 'CHC30113', '', '0', '2016-09-01 09:31:22'),
(140, NULL, 'text', 13, 'CHCECE010', 'CHC30113', '', '0', '2016-09-01 09:49:41'),
(141, '2KB', 'image', 18, 'CPCCWC3003A', 'CPC31511', '', '0', '2016-09-01 10:06:57'),
(142, NULL, 'text', 18, 'CPCCWC3003A', 'CPC31511', '', '0', '2016-09-01 10:07:32'),
(143, NULL, 'text', 18, 'CPCCCM1014A', 'CPC31511', '', '0', '2016-09-01 10:08:02'),
(144, NULL, 'text', 18, 'CPCCCM1014A', 'CPC31511', '', '0', '2016-09-01 10:20:51'),
(145, '210KB', 'image', 13, 'CHCECE010', 'CHC30113', '', '1', '2016-09-01 10:37:51'),
(146, NULL, 'text', 13, 'CHCECE010', 'CHC30113', '', '0', '2016-09-01 10:39:47'),
(147, '8KB', 'image', 13, 'SRCCRO008B', 'CHC30113', '', '1', '2016-09-01 10:46:07'),
(148, NULL, 'text', 13, 'SRCCRO008B', 'CHC30113', '', '0', '2016-09-01 10:47:15'),
(160, NULL, 'text', 13, 'CHCECE014', 'CHC30113', '', '0', '2016-09-01 12:25:53'),
(161, NULL, 'text', 13, 'CHCECE014', 'CHC30113', '', '0', '2016-09-01 12:25:53'),
(162, NULL, 'text', 13, 'CHCECE014', 'CHC30113', '', '0', '2016-09-01 12:25:53'),
(163, NULL, 'text', 13, 'CHCECE014', 'CHC30113', '', '0', '2016-09-01 12:25:53'),
(164, NULL, 'text', 13, 'CHCECE014', 'CHC30113', '', '0', '2016-09-01 12:26:19'),
(165, NULL, 'text', 13, 'CHCDIV001', 'CHC30113', '', '1', '2016-09-01 12:27:21'),
(166, NULL, 'text', 13, 'CHCDIV001', 'CHC30113', '', '1', '2016-09-01 12:27:21'),
(167, NULL, 'text', 13, 'CHCDIV001', 'CHC30113', '', '1', '2016-09-01 12:27:21'),
(168, NULL, 'text', 13, 'CHCDIV001', 'CHC30113', '', '1', '2016-09-01 12:27:21'),
(169, NULL, 'text', 13, 'CHCDIV001', 'CHC30113', '', '1', '2016-09-01 12:27:21'),
(170, NULL, 'text', 13, 'CHCECE014', 'CHC30113', '', '0', '2016-09-01 13:14:01'),
(177, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '1', '2016-09-01 13:23:21'),
(178, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:21'),
(179, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:21'),
(180, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:21'),
(181, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:22'),
(182, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:22'),
(183, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:22'),
(184, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:22'),
(185, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:22'),
(186, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:22'),
(187, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:23'),
(188, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:23'),
(189, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:23'),
(190, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:23'),
(191, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:23'),
(192, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:24'),
(193, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:24'),
(194, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:24'),
(195, '8KB', 'image', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:23:24'),
(196, NULL, 'text', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:25:06'),
(197, NULL, 'text', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-01 13:25:06'),
(198, '217KB', 'image', 13, 'CHCECE012', 'CHC30113', '', '1', '2016-09-01 13:53:26'),
(199, NULL, 'text', 13, 'CHCECE012', 'CHC30113', '', '1', '2016-09-01 13:53:54'),
(200, '2KB', 'image', 19, 'CPCCCM2008B', 'CPC31511', '', '1', '2016-09-02 06:05:23'),
(201, NULL, 'text', 19, 'CPCCCM2008B', 'CPC31511', '', '0', '2016-09-02 06:05:54'),
(202, NULL, 'text', 13, 'CHCDIV001', 'CHC30113', '', '0', '2016-09-02 06:30:27'),
(203, NULL, 'text', 13, 'HLTWHS001', 'CHC30113', '', '0', '2016-09-02 06:34:32'),
(204, NULL, 'text', 13, 'CHCDIV001', 'CHC30113', '', '0', '2016-09-02 07:34:59'),
(206, '12KB', 'image', 19, '', '', '', '0', '2016-09-02 07:44:01'),
(209, '859KB', 'image', 1, '', '', '', '0', '2016-09-02 07:53:15'),
(210, '5KB', 'image', 13, '', '', '', '0', '2016-09-02 10:37:20'),
(212, '10KB', 'image', 13, '', '', '', '0', '2016-09-02 12:31:19'),
(213, '304MB', 'video', 19, '', '', '1472822085725-vv3bsh', '0', '2016-09-02 13:14:32'),
(215, NULL, 'text', 13, 'CHCPRT001', 'CHC30113', '', '0', '2016-09-02 13:31:05'),
(216, NULL, 'text', 13, 'CHCPRT001', 'CHC30113', '', '0', '2016-09-02 13:31:05'),
(217, NULL, 'text', 13, 'CHCPRT001', 'CHC30113', '', '0', '2016-09-02 13:31:40'),
(218, '101KB', 'image', 19, '', '', '', '0', '2016-09-02 13:31:45'),
(219, '75KB', 'image', 19, '', '', '', '0', '2016-09-02 13:32:22'),
(220, '199KB', 'image', 13, '', '', '', '0', '2016-09-02 14:03:06'),
(221, '210KB', 'image', 13, '', '', '', '0', '2016-09-02 14:03:06'),
(222, '257KB', 'image', 13, '', '', '', '0', '2016-09-02 14:03:06'),
(223, '199KB', 'image', 13, 'CHCPRT003', 'CHC30113', '', '0', '2016-09-02 14:12:40'),
(224, '210KB', 'image', 13, 'CHCPRT003', 'CHC30113', '', '0', '2016-09-02 14:12:40'),
(225, '257KB', 'image', 13, 'CHCPRT003', 'CHC30113', '', '0', '2016-09-02 14:12:40'),
(227, '882KB', 'image', 19, '', '', '', '0', '2016-09-02 14:17:43'),
(228, '666MB', 'video', 19, '', '', '1472826347745-6qi9uq', '0', '2016-09-02 14:25:34'),
(229, '25MB', 'video', 19, 'RIIOHS202A', 'CPC31511', '1472827598663-p1bmd6', '0', '2016-09-02 14:46:24'),
(230, '25MB', 'video', 19, 'RIIOHS202A', 'CPC31511', '', '0', '2016-09-02 14:50:11'),
(231, '6MB', 'image', 18, '', '', '', '0', '2016-09-02 14:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_audio`
--

CREATE TABLE IF NOT EXISTS `evidence_audio` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_audio`
--

INSERT INTO `evidence_audio` (`id`, `path`, `name`) VALUES
(110, 'transcode-2016-08-31-57c6cd58018d5Kalimba.mp3', 'Kalimba.mp3'),
(112, 'transcode-2016-08-31-57c6cd96f3ea9Maid with the Flaxen Hair.mp3', 'Maid with the Flaxen Hair.mp3'),
(114, 'transcode-2016-08-31-57c6cf0bea701Sleep Away.mp3', 'Sleep Away.mp3'),
(118, 'transcode-2016-08-31-57c6d469690d1Kalimba.mp3', 'Kalimba.mp3'),
(120, 'transcode-2016-08-31-57c6d469690d1Kalimba.mp3', 'Kalimba.mp3'),
(124, 'transcode-2016-08-31-57c6cf0bea701Sleep Away.mp3', 'Sleep Away.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_file`
--

CREATE TABLE IF NOT EXISTS `evidence_file` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_file`
--

INSERT INTO `evidence_file` (`id`, `path`, `name`) VALUES
(126, '2016-08-31-57c6d6f144c95Venkaiah-Kancharlapalli_Certificate-III-in-Early-Childhood-Education-and-Care_1471872729.pdf', 'Venkaiah-Kancharlapalli_Certificate-III-in-Early-Childhood-Education-and-Care_1471872729.pdf'),
(226, '2016-09-02-57c989af33015Hadoop.pdf', 'Hadoop.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_image`
--

CREATE TABLE IF NOT EXISTS `evidence_image` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_image`
--

INSERT INTO `evidence_image` (`id`, `path`, `name`) VALUES
(1, '2016-08-30-57c552d4dc85bTree (1).jpg', 'Tree (1).jpg'),
(2, '2016-08-30-57c554189a22eFlower.jpg', 'Flower.jpg'),
(3, '2016-08-30-57c5541891774Tree (1).jpg', 'Tree (1).jpg'),
(4, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(5, '2016-08-30-57c55418954e9Sunset.jpg', 'Sunset.jpg'),
(6, '2016-08-30-57c55418877c6index.jpg', 'index.jpg'),
(7, '2016-08-30-57c55418877c6index.jpg', 'index.jpg'),
(9, '2016-08-30-57c554878c25dLighthouse.jpg', 'Lighthouse.jpg'),
(11, '2016-08-30-57c5568add9b6IMG-20160830-WA0001.jpg', 'IMG-20160830-WA0001.jpg'),
(16, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(17, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(19, '2016-08-30-57c559f6ef7761472551412133-1283517641.jpg', '1472551412133-1283517641.jpg'),
(21, '2016-08-30-57c554189a22eFlower.jpg', 'Flower.jpg'),
(23, '2016-08-30-57c55bbbbe4cdLighthouse.jpg', 'Lighthouse.jpg'),
(26, '2016-08-30-57c55bbbbe4cdLighthouse.jpg', 'Lighthouse.jpg'),
(27, '2016-08-30-57c55418954e9Sunset.jpg', 'Sunset.jpg'),
(30, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(32, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(34, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(38, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(40, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(42, '2016-08-30-57c5541891774Tree (1).jpg', 'Tree (1).jpg'),
(44, '2016-08-30-57c55bbbbe4cdLighthouse.jpg', 'Lighthouse.jpg'),
(46, '2016-08-30-57c55418954e9Sunset.jpg', 'Sunset.jpg'),
(47, '2016-08-30-57c55418954e9Sunset.jpg', 'Sunset.jpg'),
(49, '2016-08-30-57c5541891774Tree (1).jpg', 'Tree (1).jpg'),
(51, '2016-08-30-57c5568add9b6IMG-20160830-WA0001.jpg', 'IMG-20160830-WA0001.jpg'),
(52, '2016-08-30-57c5568add9b6IMG-20160830-WA0001.jpg', 'IMG-20160830-WA0001.jpg'),
(54, '2016-08-30-57c55418877c6index.jpg', 'index.jpg'),
(56, '2016-08-30-57c55418877c6index.jpg', 'index.jpg'),
(58, '2016-08-30-57c55418877c6index.jpg', 'index.jpg'),
(60, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(61, '2016-08-30-57c554189383aM1.jpg', 'M1.jpg'),
(63, '2016-08-30-57c554189a22eFlower.jpg', 'Flower.jpg'),
(65, '2016-08-30-57c572dd005eaJellyfish.jpg', 'Jellyfish.jpg'),
(66, '2016-08-30-57c573045be19Jellyfish.jpg', 'Jellyfish.jpg'),
(68, '2016-08-30-57c587b0cdb93Screenshot_2016-08-23-16-19-39.png', 'Screenshot_2016-08-23-16-19-39.png'),
(69, '2016-08-30-57c587b0cdb93Screenshot_2016-08-23-16-19-39.png', 'Screenshot_2016-08-23-16-19-39.png'),
(70, '2016-08-31-57c67672d902cIMG-20160822-WA0000.jpg', 'IMG-20160822-WA0000.jpg'),
(71, '2016-08-31-57c689847f2c014726291215921769453295.jpg', '14726291215921769453295.jpg'),
(72, '2016-08-31-57c6acad71ca1M1.jpg', 'M1.jpg'),
(73, '2016-08-31-57c6acad716f0Flower.jpg', 'Flower.jpg'),
(74, '2016-08-31-57c6acad71ee4index.jpg', 'index.jpg'),
(75, '2016-08-31-57c6acad75e08Tree (1).jpg', 'Tree (1).jpg'),
(76, '2016-08-31-57c6acad7c457Sunset.jpg', 'Sunset.jpg'),
(78, '2016-08-31-57c6acf982606image.jpg', 'image.jpg'),
(79, '2016-08-31-57c6acad7c457Sunset.jpg', 'Sunset.jpg'),
(80, '2016-08-31-57c6acad7c457Sunset.jpg', 'Sunset.jpg'),
(81, '2016-08-31-57c6acad7c457Sunset.jpg', 'Sunset.jpg'),
(82, '2016-08-31-57c6acad7c457Sunset.jpg', 'Sunset.jpg'),
(83, '2016-08-31-57c6acad7c457Sunset.jpg', 'Sunset.jpg'),
(84, '2016-08-31-57c6acad7c457Sunset.jpg', 'Sunset.jpg'),
(91, '2016-08-31-57c6acad71ca1M1.jpg', 'M1.jpg'),
(93, '2016-08-31-57c6acad716f0Flower.jpg', 'Flower.jpg'),
(95, '2016-08-31-57c6acad75e08Tree (1).jpg', 'Tree (1).jpg'),
(97, '2016-08-31-57c6bc2c13cdcJellyfish.jpg', 'Jellyfish.jpg'),
(100, '2016-08-31-57c6c830568a9NEW.jpg', 'NEW.jpg'),
(102, '2016-08-31-57c6c90b6269fLighthouse.jpg', 'Lighthouse.jpg'),
(116, '2016-08-31-57c6d40aa838bCAMERA.png', 'CAMERA.png'),
(128, '2016-08-31-57c6d74adae4fTree (1).jpg', 'Tree (1).jpg'),
(130, '2016-08-31-57c6d74adae4fTree (1).jpg', 'Tree (1).jpg'),
(133, '2016-08-31-57c6ed6a1bb0dimage.jpg', 'image.jpg'),
(134, '2016-08-31-57c6f102bb724Sunset.jpg', 'Sunset.jpg'),
(136, '2016-08-31-57c70200a1d42PngImage_20160729_105405.jpg', 'PngImage_20160729_105405.jpg'),
(137, '2016-09-01-57c7c240cfa90uncheckmark.png', 'uncheckmark.png'),
(138, '2016-09-01-57c7f4d54f85ferror in the rto pop up..png', 'error in the rto pop up..png'),
(141, '2016-09-01-57c7fdbc2655fcheckmark.jpeg', 'checkmark.jpeg'),
(145, '2016-09-01-57c804f8651b8Doubt.png', 'Doubt.png'),
(147, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(149, '2016-09-01-57c808985af24Sunset.jpg', 'Sunset.jpg'),
(171, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(172, '2016-09-01-57c804f8651b8Doubt.png', 'Doubt.png'),
(173, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(174, '2016-09-01-57c804f8651b8Doubt.png', 'Doubt.png'),
(175, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(176, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(177, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(178, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(179, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(180, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(181, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(182, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(183, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(184, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(185, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(186, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(187, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(188, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(189, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(190, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(191, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(192, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(193, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(194, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(195, '2016-09-01-57c806ea327eaTree (1).jpg', 'Tree (1).jpg'),
(198, '2016-09-01-57c832cfdb406makechanges.png', 'makechanges.png'),
(200, '2016-09-02-57c9169de08dfcheckmark.jpeg', 'checkmark.jpeg'),
(205, '2016-09-02-57c92d08a3de614728020550981288047831.jpg', '14728020550981288047831.jpg'),
(206, '2016-09-02-57c92dbb1e60fimages (20).jpg', 'images (20).jpg'),
(207, '2016-09-02-57c92e5828055images (20).jpg', 'images (20).jpg'),
(208, '2016-09-02-57c92e66deae21472802413076-616562633.jpg', '1472802413076-616562633.jpg'),
(209, '2016-09-02-57c92fe4cf1b4Chrysanthemum.jpg', 'Chrysanthemum.jpg'),
(210, '2016-09-02-57c9565ba9759Flower value.jpg', 'Flower value.jpg'),
(211, '2016-09-02-57c96f5b7e290IMG_20160902_175300016.jpg', 'IMG_20160902_175300016.jpg'),
(212, '2016-09-02-57c971110d448Sunset.jpg', 'Sunset.jpg'),
(218, '2016-09-02-57c97f39a82ddimage.jpg', 'image.jpg'),
(219, '2016-09-02-57c97f5fd2804image.jpg', 'image.jpg'),
(220, '2016-09-02-57c98693bf74dedited USI AND RELOGGED IN.png', 'edited USI AND RELOGGED IN.png'),
(221, '2016-09-02-57c98693c093bDoubt.png', 'Doubt.png'),
(222, '2016-09-02-57c98693beec3edit.png', 'edit.png'),
(223, '2016-09-02-57c988d0ab68dedited USI AND RELOGGED IN.png', 'edited USI AND RELOGGED IN.png'),
(224, '2016-09-02-57c988d0ab604Doubt.png', 'Doubt.png'),
(225, '2016-09-02-57c988d0ab61bedit.png', 'edit.png'),
(227, '2016-09-02-57c989ffb569614728258441111481694901.jpg', '14728258441111481694901.jpg'),
(231, '2016-09-02-57c991e0319a5IMG_20160902_202101944.jpg', 'IMG_20160902_202101944.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_recording`
--

CREATE TABLE IF NOT EXISTS `evidence_recording` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evidence_text`
--

CREATE TABLE IF NOT EXISTS `evidence_text` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `self_assessment` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_text`
--

INSERT INTO `evidence_text` (`id`, `content`, `self_assessment`) VALUES
(8, '1.5. Material quantity requirements are calculated in accordance with plans, specifications and quality requirements  . 1.5. Material quantity requirements are calculated in accordance with plans, specifications and quality requirements  . 1.5. Material quantity requirements are calculated in accordance with plans, specifications and quality requirements  . 1.5. Material quantity requirements are calculated in accordance with plans, specifications and quality requirements  . ', 1),
(10, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.', 1),
(12, 'Plan and prepare.\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information , confirmed and applied for planning and preparation  purposes. \nPlan and prepare.\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information , confirmed and applied for planning and preparation  purposes. ', 1),
(13, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.', 1),
(14, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes.', 1),
(15, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes. Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation  purposes. purposes. purposes. purposes. ', 1),
(18, 'Plant, tools and equipment  selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. Plant, tools and equipment  selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. ', 1),
(20, ' Work planning and preparation  are conducted using plans, specifications, quality requirements and operational details, obtained, confirmed and applied from relevant information . \n1.2. Safety  (OHS )  Work planning and preparation  are conducted using plans, specifications, quality requirements and operational details, obtained, confirmed and applied from relevant information . \n1.2. Safety  (OHS ) requirement', 1),
(22, 'Obtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted task', 1),
(24, 'Area below construction face is cleared and isolated with designed barricade to OHS regulations and job work plans allowing for support plant and equipment  . Area below construction face is cleared and isolated with designed barricade to OHS regulations and job work plans allowing for support plant and equipment  . ', 1),
(25, 'Obtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted task', NULL),
(28, 'Ideas for improvement are suggested and implemented in future planning and organising of work activities.Ideas for improvement are suggested and implemented in future planning and organising of work activities. Ideas for improvement are suggested and implemented in future planning and organising of work activities. Ideas for improvement are suggested and implemented in future planning and organising of work activities.', 1),
(29, 'Obtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted task', 1),
(31, 'Work instructions and operational details are obtained, confirmed and applied from relevant information  to undertake planning and preparation Work instructions and operational details are obtained, confirmed and applied from relevant information  to undertake planning and preparation Work instructions and operational details are obtained, confirmed and applied from relevant information  to undertake planning and preparation', 1),
(33, 'Materials quantity requirements are calculated in accordance with plans, specifications and quality requirements  .\n1.6. Materials  appropriate to the work application are identified, obtained, prepared, safely handled and located ready for use.\n1.7. Environmental requirements  are identified for the project in accordance with environmental plans and regulatory obligations and applied. ', 1),
(35, 'Area below construction face is cleared and isolated with designed barricade to OHS regulations and job work plans allowing for support plant and equipment  . Area below construction face is cleared and isolated with designed barricade to OHS regulations and job work plans allowing for support plant and equipment  . ', 1),
(36, 'Obtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted taskObtain, confirm and apply work instructions  relevant to the allotted task', 1),
(37, ' Work planning and preparation  are conducted using plans, specifications, quality requirements and operational details, obtained, confirmed and applied from relevant information . \n1.2. Safety  (OHS )  Work planning and preparation  are conducted using plans, specifications, quality requirements and operational details, obtained, confirmed and applied from relevant information . \n1.2. Safety  (OHS ) requirement', 1),
(39, 'emolition procedures are carried out consistent with safe and effective processes of dismantling or demolishing and removing materials from location to designated storage area.emolition procedures are carried out consistent with safe and effective processes of dismantling or demolishing and removing materials from location to designated storage area. Area prepared prepared', 1),
(41, 'Environmental requirements  and controls are identified from job plans, specifications and environmental plan. Environmental requirements  and controls are identified from job plans, specifications and environmental plan. Environmental requirements  and controls are identified from job plans, specifications and environmental plan. Environmental requirements  and controls are identified from job plans, specifications and environmental plan. ', 1),
(43, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  .Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  .Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  .', 1),
(45, 'Carpentry materials and components are sorted to suit material type and size, stacked for ease of identification and retrieval and for task sequence and job location in accordance with job specifications.\n2.3. Carpentry materials and components are protected  against Carpentry materials and components are sorted to suit material type and size, stacked for ease of identification and retrieval and for task sequence and job location in accordance with job specifications.\n2.3. Carpentry materials and components are protected  against ', 1),
(48, ' Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled.', 1),
(50, ' Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled. Visual communication that is unclear or ambiguous is questioned or visually cancelled.', 1),
(53, 'ools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement.ools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement.', 1),
(55, 'Machine operator is assisted with excavation to ensure correct route, line and depth, and that correct procedures are used to minimise risk to self and others.Machine operator is assisted with excavation to ensure correct route, line and depth, and that correct procedures are used to minimise risk to self and others.', 1),
(57, 'Machine operator is assisted with excavation to ensure correct route, line and depth, and that correct procedures are used to minimise risk to self and others.Machine operator is assisted with excavation to ensure correct route, line and depth, and that correct procedures are used to minimise risk to self and others.Machine operator is assisted with excavation to ensure correct route, line and depth, and that correct procedures are used to minimise risk to self and others.', 1),
(59, 'Identify work area requirements.\nSite of proposed work at heights  is identified from relevant information . Identify work area requirements.\nSite of proposed work at heights  is identified from relevant information . Identify work area requirements.\nSite of proposed work at heights  is identified from relevant information . Identify work area requirements.\nSite of proposed work at heights  is identified from relevant information . ', 1),
(62, 'Plan and prepare.\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation . Plan and prepare.\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information  for planning and preparation . ', 1),
(64, 'Safety  (OHS  ) requirements are obtained from site safety plan, other regulatory specifications or legal obligations, and are applied.\n1.3. Measuring and calculating equipment  selected to carry ouSafety  (OHS  ) requirements are obtained from site safety plan, other regulatory specifications or legal obligations, and are applied.\n1.3. Measuring and calculating equipment  selected to carry ouSafety  (OHS  ) requirements are obtained from site safety plan, other regulatory specifications or legal obligations, and are applied.\n1.3. Measuring and calculating equipment  selected to carry ou', 1),
(77, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information, confirmed and applied for planning and preparation purposes. Work instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information, confirmed and applied for planning and preparation purposes. ', 1),
(85, '2.	Plan steps to complete tasks.\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in \n2.	Plan steps to complete tasks.\n\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in conjunctio', 1),
(86, '2.	Plan steps to complete tasks.\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in \n2.	Plan steps to complete tasks.\n\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in conjunctio', 1),
(87, '2.	Plan steps to complete tasks.\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in \n2.	Plan steps to complete tasks.\n\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in conjunctio', 1),
(88, '2.	Plan steps to complete tasks.\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in \n2.	Plan steps to complete tasks.\n\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in conjunctio', 1),
(89, '2.	Plan steps to complete tasks.\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in \n2.	Plan steps to complete tasks.\n\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in conjunctio', NULL),
(90, '2.	Plan steps to complete tasks.\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in \n2.	Plan steps to complete tasks.\n\n2.1.	Task is interpreted and relevant steps are identified to ensure efficient conduct of work, and in accordance with safety (OHS), environmental requirements and quality requirements.\n2.2.	Steps are planned in conjunctio', 1),
(92, 'Plant, tools and equipment are cleaned, checked, maintained and stored in accordance with manufacturer recommendations and standard work practices.Plant, tools and equipment are cleaned, checked, maintained and stored in accordance with manufacturer recommendations and standard work practices.Plant, tools and equipment are cleaned, checked, maintained and stored in accordance with manufacturer recommendations and standard work practices.', 1),
(94, 'Plant, tools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. Plant, tools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. ', 1),
(96, 'Amendments to specifications are checked to ensure currency of information and conveyed to others where appropriate. Amendments to specifications are checked to ensure currency of information and conveyed to others where appropriate. Amendments to specifications are checked to ensure currency of information and conveyed to others where appropriate. Amendments to specifications are checked to ensure currency of information and conveyed to others where appropriate. ', 1),
(98, 'Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. ', 1),
(101, 'Measuring and calculating equipment selected to carry out tasks is consistent with job requirements, is checked for serviceability, and any faults are rectified or reported. Safety (OHS) requirements are obtained from site safety plan, other regulatory specifications or legal obligations, and are applied.Safety (OHS) requirements are obtained from site safety plan, other regulatory specifications or legal obligations, and are applied.', 1),
(103, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation.', 1),
(104, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation.Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation.', 1),
(106, 'Approved methods of moving tools and equipment to work area are identified to minimise potential of falling objects, removal of scaffold components, inappropriate carrying of materials on ladders, and excessive bending or twisting in pass-up situations.Approved methods of moving tools and equipment to work area are identified to minimise potential of falling objects, removal of scaffold components, inappropriate carrying of materials on ladders, and excessive bending or twisting in pass-up situations.', 1),
(109, 'Select tools and equipment to carry out tasks that are consistent with the requirements of the job and check them for serviceability and rectify or report any faults Select tools and equipment to carry out tasks that are consistent with the requirements of the job and check them for serviceability and rectify or report any faults Select tools and equipment to carry out tasks that are consistent with the requirements of the job and check them for serviceability and rectify or report any faults ', 1),
(111, 'Material quantity requirements are calculated in accordance with plans, specifications and quality requirements. Material quantity requirements are calculated in accordance with plans, specifications and quality requirements. Material quantity requirements are calculated in accordance with plans, specifications and quality requirements. Material quantity requirements are calculated in accordance with plans, specifications and quality requirements. ', 1),
(113, ' Construct timber external stairs  Construct timber external stairs  Construct timber external stairs  Construct timber external stairs  Construct timber external stairs  Construct timber external stairs  Construct timber external stairs Construct timber external stairs  Construct timber external stairs  Construct timber external  Construct timber external stairs Construct timber external stairs Construct timber external stairs', 1),
(115, 'Construct, erect and dismantle formwork for stairs and rampsConstruct, erect and dismantle formwork for stairs and rampsConstruct, erect and dismantle formwork for stairs and rampsConstruct, erect and dismantle formwork for stairs and rampsConstruct, erect and dismantle formwork for stairs and rampsConstruct, erect and dismantle formwork for stairs and ramps Construct, erect and dismantle formwork for stairs and ramps', 1),
(117, 'OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. ', 1),
(119, 'Plant, tools and equipment are selected to carry out tasks are consistent with the requirements of the job, checked for serviceability and any faults are rectified or reported prior to commencement. Plant, tools and equipment are selected to carry out tasks are consistent with the requirements of the job, checked for serviceability and any faults are rectified or reported prior to commencement. ', 1),
(121, 'Gather market information from primary and secondary sources to identify possible market needs in relation to business ideasGather market information from primary and secondary sources to identify possible market needs in relation to business ideasGather market information from primary and secondary sources to identify possible market needs in relation to business ideas', 1),
(122, 'OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. ', NULL),
(123, 'OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. OHS, hazard, accident or incident reports are contributed to according to workplace procedures and Australian government and state or territory OHS legislation and relevant information. ', 1),
(125, 'Work instructions and operational details are obtained, confirmed and applied from relevant information for planning and preparation purposes. Work instructions and operational details are obtained, confirmed and applied from relevant information for planning and preparation purposes. Work instructions and operational details are obtained, confirmed and applied from relevant information for planning and preparation purposes. ', 1),
(127, 'Trends in technology, work processes and environmental issues which are likely to impact on the construction industry are identified and evaluated in terms of employment options.Trends in technology, work processes and environmental issues which are likely to impact on the construction industry are identified and evaluated in terms of employment options.', 1),
(129, 'Tools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. Tools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. ', 1),
(131, 'Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation. Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation. Work instructions, including plans, specifications, quality requirements and operational details, are obtained, confirmed and applied from relevant information for planning and preparation. ', 1),
(132, 'Tools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. Tools and equipment selected to carry out tasks are consistent with job requirements, checked for serviceability, and any faults are rectified or reported prior to commencement. ', 1),
(135, '	\n\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information, confirmed and applied for planning and preparation purposes. 	\n\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information, confirmed and applied for planning and preparation purposes. ', 1),
(139, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', 1),
(140, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', 1),
(142, 'Install dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systemsInstall dry wall passive fire-rated systems', 1),
(143, 'Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. ', 1),
(144, 'Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. Work signage interpretation and other safety (OHS) requirements are responded to with correct action. ', 1),
(146, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', 1),
(148, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', 1),
(150, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', 1),
(151, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', 1),
(152, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', NULL),
(153, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(154, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(155, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(156, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', NULL),
(157, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(158, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(159, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(160, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', NULL),
(161, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(162, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(163, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(164, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', 1),
(165, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(166, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(167, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(168, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL);
INSERT INTO `evidence_text` (`id`, `content`, `self_assessment`) VALUES
(169, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', NULL),
(170, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', 1),
(196, 'Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification Qualification  Qualification Qualification Qualification Qualification Qualification', NULL),
(197, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', NULL),
(199, 'review please review please  review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please review please ', 1),
(201, 'work instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information, confirmed and applied for planning and preparation purposes 1.1\n\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information, confirmed and applied for planning and preparation purposes1.1\n\nWork instructions, including plans, specifications, quality requirements and operational details, are obtained from relevant sources of information, confirmed and applied for planning and preparation purposes ', 1),
(202, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', 1),
(203, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', 1),
(204, 'dentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biases', 1),
(215, 'dentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biasesdentify and reflect on own social and cultural perspectives and biases', NULL),
(216, '	\n\nPromote infant''s and toddler''s social development through recreation activities\n	\n\n1.1\n	\n\nEncourage infants and toddlers to initiate and develop contact with others\n\n1.2\n	\n\nStructure experiences and recreation equipment and toys in a way which promotes cooperation\n\n1.3\n	\n\nPlan opportunities for social interaction between infants and toddlers with respect to their needs, interests and stage of development\n\n1.4\n	\n\nAcknowledge and encourage appropriate and effective communication between infants and toddlers\n\n1.5\n	\n\nMaintain a clean and hygienic environment according to regulations and organisation policy and procedures and resources\n\n2\n	\n\nCreate a positive relationship between infants and toddlers and their parents\n	\n\n2.1', NULL),
(217, '	\n\nPERFORMANCE CRITERIA\n	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA	\n\nPERFORMANCE CRITERIA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evidence_video`
--

CREATE TABLE IF NOT EXISTS `evidence_video` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evidence_video`
--

INSERT INTO `evidence_video` (`id`, `path`, `name`) VALUES
(67, 'transcode-2016-08-30-57c57383f0d0bWildlife.mp4', 'Wildlife.wmv'),
(99, '2016-08-31-57c6c6d65f952VID-20160830-WA0000.mp4', 'VID-20160830-WA0000.mp4'),
(105, '2016-08-31-57c6c6d65f952VID-20160830-WA0000.mp4', 'VID-20160830-WA0000.mp4'),
(107, 'transcode-2016-08-31-57c6ccabbeaeaWildlife.mp4', 'Wildlife.wmv'),
(108, 'transcode-2016-08-31-57c6cd23a058aWildlife.mp4', 'Wildlife.wmv'),
(213, 'transcode-2016-09-02-57c97b1c8e6f81002.mp4', '1002.mp4'),
(214, 'transcode-2016-09-02-57c97cfa421251002.mp4', '1002.mp4'),
(228, 'transcode-2016-09-02-57c98af27858d[ZippyMovieZ.CC]Bichagadu (2016)Telugu DVDScr 700MB-ZippyMoviez.mp4', '[ZippyMovieZ.CC]Bichagadu (2016)Telugu DVDScr 700MB-ZippyMoviez.mkv'),
(229, 'transcode-2016-09-02-57c990b51b8e3Wildlife.mp4', 'Wildlife.wmv'),
(230, 'transcode-2016-09-02-57c9919906e87Wildlife.mp4', 'Wildlife.wmv');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `faq_id` int(11) NOT NULL,
  `faq_que` text NOT NULL,
  `faq_ans` text NOT NULL,
  `faq_sts` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1-Active,0-Inactive'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `to_user`, `from_user`, `subject`, `message`, `created`, `read_status`, `from_status`, `to_status`, `reply`, `replymid`, `unit_id`) VALUES
(1, 13, 2, 'Evidenced are Not sufficient for the unit Support the holistic development of children in early childhood', 'can you please update it correctly .', '2016-09-01 09:40:18', 1, 0, 0, 0, 0, 201),
(2, 13, 2, 'Evidences disapproved for - CHC30113 : Certificate III in Early Childhood Education and Care - Unit : Support the holistic development of children in early childhood', 'Dear Bindu Mishra, <br/><br/>  Qualification : CHC30113 - Certificate III in Early Childhood Education and Care<br/> Unit : CHCECE010 Support the holistic development of children in early childhood <br/> Provided evidences for above unit are not yet competetent please add more evidences and get back to us.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 09:40:18', 1, 0, 0, 0, 0, 201),
(3, 2, 13, 'Re: Evidenced are Not sufficient for the unit Support the holistic development of children in early childhood', 'ok i will update my files shortly ', '2016-09-01 09:41:45', 1, 0, 0, 0, 1, 0),
(4, 2, 3, 'Evidences disapproved for - CPC31511 : Certificate III in Formwork/Falsework - Unit : Conduct workplace communication ', 'Dear Hannah Hardy, <br/><br/>  Qualification : CPC31511 - Certificate III in Formwork/Falsework<br/>  Unit : CPCCCM1014A Conduct workplace communication  <br/> Evidences are not yet competetent for user Mahalakshmi Devi.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 09:50:24', 1, 0, 0, 0, 0, 141),
(5, 18, 2, 'Evidences disapproved for - CPC31511 : Certificate III in Formwork/Falsework - Unit : Conduct workplace communication ', 'Dear Mahalakshmi Devi, <br/><br/>  Qualification : CPC31511 - Certificate III in Formwork/Falsework<br/> Unit : CPCCCM1014A Conduct workplace communication  <br/> Provided evidences for above unit are not yet competetent please add more evidences and get back to us.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 09:50:25', 1, 0, 0, 0, 0, 141),
(6, 18, 3, 'Evidenced are Not sufficient for the unit Conduct workplace communication ', 'NOT YET COMPETENT\n\n', '2016-09-01 09:50:25', 1, 0, 0, 0, 0, 141),
(7, 13, 2, 'Evidenced are Not sufficient for the unit Support the holistic development of children in early childhood', 'no still its wrong ........', '2016-09-01 09:50:28', 1, 0, 0, 0, 0, 201),
(8, 13, 2, 'Evidences disapproved for - CHC30113 : Certificate III in Early Childhood Education and Care - Unit : Support the holistic development of children in early childhood', 'Dear Bindu Mishra, <br/><br/>  Qualification : CHC30113 - Certificate III in Early Childhood Education and Care<br/> Unit : CHCECE010 Support the holistic development of children in early childhood <br/> Provided evidences for above unit are not yet competetent please add more evidences and get back to us.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 09:50:28', 1, 0, 0, 0, 0, 201),
(9, 13, 2, 'Re: Evidenced are Not sufficient for the unit Support the holistic development of children in early childhood', 'can you do it quickly', '2016-09-01 09:51:54', 1, 0, 0, 0, 7, 0),
(10, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Needs Follow Up With Candidate.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 10:05:27', 1, 0, 0, 0, 0, 0),
(11, 18, 2, 'Evidences disapproved for - CPC31511 : Certificate III in Formwork/Falsework - Unit : Conduct workplace communication ', 'Dear Mahalakshmi Devi, <br/><br/>  Qualification : CPC31511 - Certificate III in Formwork/Falsework<br/> Unit : CPCCCM1014A Conduct workplace communication  <br/> Provided evidences for above unit are not yet competetent please add more evidences and get back to us.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 10:10:02', 1, 0, 0, 0, 0, 141),
(12, 18, 2, 'Evidenced are Not sufficient for the unit Conduct workplace communication ', 'this unit is \nNOT YET SATISFACTORY\nthis unit is \nNOT YET SATISFACTORY\n\nthis unit is \nNOT YET SATISFACTORY\n\nthis unit is \nNOT YET SATISFACTORY\n\n', '2016-09-01 10:10:02', 1, 0, 0, 0, 0, 141),
(13, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to All Evidence Received.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 10:22:01', 1, 0, 0, 0, 0, 0),
(14, 3, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear John Die, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to you.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 10:22:06', 1, 0, 0, 0, 0, 0),
(15, 18, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to Assessor.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 10:22:06', 1, 0, 0, 0, 0, 0),
(16, 13, 2, 'Re: Re: Evidenced are Not sufficient for the unit Support the holistic development of children in early childhood', 'hey once again .dearo', '2016-09-01 10:24:18', 1, 0, 0, 0, 7, 0),
(17, 2, 3, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 10:39:02', 1, 0, 0, 0, 0, 0),
(18, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 10:39:02', 1, 0, 0, 0, 0, 0),
(19, 13, 2, 'HI', 'DD', '2016-09-01 11:00:40', 1, 0, 0, 0, 0, 0),
(20, 3, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:07:21', 1, 0, 0, 0, 0, 0),
(21, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:07:21', 1, 0, 0, 0, 0, 0),
(22, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to All Evidence Received.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:08:36', 0, 0, 0, 0, 0, 0),
(23, 3, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear John Die, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to you.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:20:18', 1, 0, 0, 0, 0, 0),
(24, 18, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to Assessor.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:20:19', 0, 0, 0, 0, 0, 0),
(25, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to All Evidence Received.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:20:25', 0, 0, 0, 0, 0, 0),
(26, 3, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear John Die, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to you.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:20:41', 1, 0, 0, 0, 0, 0),
(27, 18, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to Assessor.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:20:41', 0, 0, 0, 0, 0, 0),
(28, 2, 3, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 12:31:02', 1, 0, 0, 0, 0, 0),
(29, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:31:03', 0, 0, 0, 0, 0, 0),
(30, 3, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:33:02', 1, 0, 0, 0, 0, 0),
(31, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:33:02', 0, 0, 0, 0, 0, 0),
(32, 3, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear John Die, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to you.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:37:05', 1, 0, 0, 0, 0, 0),
(33, 18, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Qualification and portfolio has been submitted to Assessor.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:37:05', 0, 0, 0, 0, 0, 0),
(34, 2, 3, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 12:39:51', 1, 0, 0, 0, 0, 0),
(35, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:39:51', 0, 0, 0, 0, 0, 0),
(36, 3, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:40:14', 1, 0, 0, 0, 0, 0),
(37, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Booked.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:40:14', 0, 0, 0, 0, 0, 0),
(38, 2, 3, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Completed.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 12:40:59', 1, 0, 0, 0, 0, 0),
(39, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Completed.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:40:59', 1, 0, 0, 0, 0, 0),
(40, 2, 3, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 12:51:19', 1, 0, 0, 0, 0, 0),
(41, 18, 2, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:51:19', 1, 0, 0, 0, 0, 0),
(42, 2, 3, 'Competency conversation invitation for - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFZFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 12:54:55', 1, 0, 0, 0, 0, 0),
(43, 18, 2, 'Competency conversation invitation for - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFZFOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 12:54:55', 1, 0, 0, 0, 0, 0),
(44, 3, 2, 'Re: Competency conversation invitation for - CPC31511 : Certificate III in Formwork/Falsework', '', '2016-09-01 13:09:37', 1, 0, 0, 0, 42, 0),
(45, 2, 3, 'Competency conversation invitation for - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFdjOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 13:17:24', 1, 0, 0, 0, 0, 0),
(46, 18, 2, 'Competency conversation invitation for - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  Please <a href=''http://onlinerpl.stg.valuelabs.com/login''>login</a>  to your GQ-RPL account and use this URL http://onlinerpl.stg.valuelabs.com/applicant/VFdjOVBRPT0= to join the competency conversation. <br/>  Awaiting for your response.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 13:17:24', 1, 0, 0, 0, 0, 0),
(47, 2, 3, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Validated all the evidences in the qualification.<br/><br/> Regards, <br/>John Die\n', '2016-09-01 13:19:25', 1, 0, 0, 0, 0, 0),
(48, 18, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Validated all the evidences in the qualification.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 13:19:26', 1, 0, 0, 0, 0, 0),
(49, 4, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Get Qualified Australia 10480NAT, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Validated all the evidences in the qualification and portfolio has been submitted to you.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 13:25:58', 1, 0, 0, 0, 0, 0),
(50, 18, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Validated all the evidences in the qualification and portfolio has been submitted to RTO.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-01 13:25:58', 1, 0, 0, 0, 0, 0),
(51, 18, 2, 'CPC31511 - Certificate III in Formwork/Falsework', 'Your qualification is being reviewed', '2016-09-01 13:27:27', 1, 0, 0, 0, 0, 0),
(52, 18, 2, 'Re: CPC31511 - Certificate III in Formwork/Falsework', 'Hi', '2016-09-01 15:12:08', 1, 0, 0, 0, 51, 0),
(53, 2, 13, 'Re: Re: Re: Evidenced are Not sufficient for the unit Support the holistic development of children in early childhood', 'yyy', '2016-09-02 06:34:06', 1, 0, 0, 0, 7, 0),
(54, 13, 2, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Bindu Mishra, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Partial Evidence Received.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-02 06:54:51', 1, 0, 0, 0, 0, 0),
(55, 13, 2, 'Evidenced are Not sufficient for the unit Work with diverse people', 'please add', '2016-09-02 07:27:07', 1, 0, 0, 0, 0, 204),
(56, 13, 2, 'Evidences disapproved for - CHC30113 : Certificate III in Early Childhood Education and Care - Unit : Work with diverse people', 'Dear Bindu Mishra, <br/><br/>  Qualification : CHC30113 - Certificate III in Early Childhood Education and Care<br/> Unit : CHCDIV001 Work with diverse people <br/> Provided evidences for above unit are not yet satisfactory please add more evidences and get back to us.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-02 07:27:08', 1, 0, 0, 0, 0, 204),
(57, 2, 19, 'Hi', 'Thank you for accepting my work', '2016-09-02 07:29:23', 1, 0, 0, 0, 0, 0),
(58, 18, 2, 'All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Dear Mahalakshmi Devi, <br/>  All the evidences for the Qualification : CPC31511 : Certificate III in Formwork/Falsework are enough competent. <br/>  Validated all the evidences in the qualification and issued the certificate.<br/><br/> Regards, <br/>Hannah Hardy\n', '2016-09-02 08:09:08', 1, 0, 0, 0, 0, 0),
(59, 2, 3, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>John Die\n', '2016-09-02 08:09:13', 1, 0, 0, 0, 0, 0),
(60, 2, 3, 'Portfolio Update : CHC30113 : Certificate III in Early Childhood Education and Care', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CHC30113 : Certificate III in Early Childhood Education and Care has been updated to Competency Conversation Completed.<br/><br/> Regards, <br/>John Die\n', '2016-09-02 08:09:24', 1, 0, 0, 0, 0, 0),
(61, 14, 19, 'Assigned Facilitator for your qualification - OnlineRPL', 'Dear Sarath Jampani, <br/>  Welcome to OnlineRPL.Hannah Hardy is assigned as your Facilitator for qualification CPC31511.<br/><br/> Regards, <br/>OnlineRPL       \n', '2016-09-02 09:31:25', 1, 0, 0, 0, 0, 0),
(62, 14, 2, 'Assigned as Facilitator - OnlineRPL', 'Dear Hannah Hardy, <br/>  Welcome to OnlineRPL.You are the facilitator of Sarath Jampani for qualification CPC31511.<br/><br/> Regards, <br/>OnlineRPL                                           \n', '2016-09-02 09:31:25', 1, 0, 0, 0, 0, 0),
(63, 14, 19, 'Assigned Facilitator for your qualification - OnlineRPL', 'Dear Sarath Jampani, <br/>  Welcome to OnlineRPL.Hannah Hardy is assigned as your Facilitator for qualification CPC31511.<br/><br/> Regards, <br/>OnlineRPL       \n', '2016-09-02 09:32:52', 1, 0, 0, 0, 0, 0),
(64, 14, 2, 'Assigned as Facilitator - OnlineRPL', 'Dear Hannah Hardy, <br/>  Welcome to OnlineRPL.You are the facilitator of Sarath Jampani for qualification CPC31511.<br/><br/> Regards, <br/>OnlineRPL                                           \n', '2016-09-02 09:32:52', 1, 0, 0, 0, 0, 0),
(65, 2, 3, 'Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'Dear Hannah Hardy, <br/>  Portfolio Status of : CPC31511 : Certificate III in Formwork/Falsework has been updated to Competency Conversation Needed.<br/><br/> Regards, <br/>John Die\n', '2016-09-02 10:05:42', 1, 0, 0, 0, 0, 0),
(66, 2, 3, 'Re: Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'hello hannah i m still reviewing..................................................................cccccccccccccccccccccccccccccccccccccccccccccc', '2016-09-02 10:16:43', 1, 0, 0, 0, 65, 0),
(67, 3, 2, 'Re: Re: Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'ok continueee', '2016-09-02 10:18:10', 1, 0, 0, 0, 65, 0),
(68, 3, 2, 'Re: Re: Re: Portfolio Update : CPC31511 : Certificate III in Formwork/Falsework', 'alright ', '2016-09-02 10:19:55', 1, 0, 0, 0, 65, 0),
(69, 2, 19, 'Hi', '123', '2016-09-02 12:20:38', 1, 0, 0, 0, 0, 0),
(70, 2, 19, 'Re: Hi', '1223333', '2016-09-02 12:20:56', 1, 0, 0, 0, 69, 0),
(71, 2, 19, 'Re: Hi', '1223333', '2016-09-02 12:21:02', 1, 0, 0, 0, 69, 0),
(72, 2, 13, 'Re: Evidences disapproved for - CHC30113 : Certificate III in Early Childhood Education and Care - Unit : Work with diverse people', 'check this now ', '2016-09-02 12:34:29', 1, 0, 0, 0, 56, 0),
(73, 13, 2, 'Re: Re: Evidences disapproved for - CHC30113 : Certificate III in Early Childhood Education and Care - Unit : Work with diverse people', 'done now ', '2016-09-02 12:35:25', 1, 0, 0, 0, 56, 0),
(74, 2, 13, 'space', 'aaa', '2016-09-02 12:36:35', 1, 0, 0, 0, 0, 0),
(75, 13, 2, 'Re: space', 'grt ', '2016-09-02 12:37:01', 1, 0, 0, 0, 74, 0),
(76, 19, 2, 'hi', 'hi', '2016-09-02 13:18:41', 1, 0, 0, 0, 0, 0),
(77, 19, 2, 'Re: hi', 'hjkkkkjk', '2016-09-02 13:20:50', 1, 0, 0, 0, 76, 0),
(78, 2, 18, 'Re: All evidences are enough competent in - CPC31511 : Certificate III in Formwork/Falsework', 'Thank you\r\n', '2016-09-02 14:50:01', 1, 0, 0, 0, 58, 0);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL,
  `note` text NOT NULL,
  `unit_id` int(11) NOT NULL,
  `course_id` int(10) DEFAULT '0',
  `type` enum('a','f') NOT NULL COMMENT 'a=assessor, f=facilitator',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id`, `note`, `unit_id`, `course_id`, `type`, `created`) VALUES
(1, 'hello', 0, 9, 'a', '2016-08-31 18:28:30'),
(2, 'hi', 0, 9, 'f', '2016-09-01 11:24:11'),
(3, 'hello', 0, 9, 'f', '2016-09-01 17:56:47'),
(4, '222', 0, 9, 'f', '2016-09-02 12:32:19'),
(5, 'just see', 0, 6, 'f', '2016-09-02 18:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `other_files`
--

CREATE TABLE IF NOT EXISTS `other_files` (
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
-- Table structure for table `reminder`
--

CREATE TABLE IF NOT EXISTS `reminder` (
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reminder`
--

INSERT INTO `reminder` (`id`, `user_course_id`, `user_id`, `date`, `message`, `completed`, `completed_date`, `created`, `created_by`, `type`, `reminder_type_id`, `reminder_view_status`) VALUES
(1, 7, 2, '2016-08-30 00:00:00', 'Work quickly', 1, '2016-08-30 21:45:44', '2016-08-30 11:43:56', 2, NULL, NULL, '0'),
(2, NULL, 2, '2016-08-30 00:00:00', 'Hi', 1, '2016-08-30 23:45:17', '2016-08-30 12:24:00', 2, 'note', 0, '0'),
(3, 8, 2, '2016-08-30 00:00:00', 'kkk', 1, '2016-08-31 00:24:55', '2016-08-30 14:23:59', 2, 'portfolio', 8, '0'),
(4, NULL, 2, '2016-08-31 00:00:00', '55', 1, '2016-08-31 23:05:30', '2016-08-31 13:04:51', 2, 'evidence', 79, '0'),
(5, 9, 3, '2016-08-31 00:00:00', 'hi', 1, '2016-09-01 00:14:13', '2016-08-31 13:58:24', 3, NULL, NULL, '0'),
(6, NULL, 2, '2016-09-02 00:00:00', 'Hello', 1, '2016-09-02 01:09:07', '2016-09-01 06:00:26', 2, 'note', 0, '0'),
(7, 9, 2, '2016-09-01 00:00:00', 'hi please redo it again', 1, '2016-09-01 19:20:04', '2016-09-01 09:03:53', 2, NULL, NULL, '0'),
(8, 6, 2, '2016-09-01 00:00:00', 'PLEASE ADD', 1, '2016-09-01 20:47:54', '2016-09-01 10:44:23', 2, NULL, NULL, '0'),
(9, 1, 2, '2016-09-01 00:00:00', '', 1, '2016-09-01 20:59:28', '2016-09-01 10:59:18', 2, 'portfolio', 1, '0'),
(10, 9, 2, '2016-09-01 00:00:00', 'hi', 1, '2016-09-01 23:27:48', '2016-09-01 13:26:27', 2, NULL, NULL, '0'),
(11, NULL, 2, '2016-09-02 00:00:00', '', 1, '2016-09-02 16:42:10', '2016-09-02 06:42:04', 2, 'message', 38, '0'),
(12, NULL, 2, '2016-09-02 00:00:00', '', 1, '2016-09-02 16:42:31', '2016-09-02 06:42:25', 2, 'evidence', 177, '0'),
(13, 6, 2, '2016-09-02 00:00:00', 'yesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyes', 1, '2016-09-02 18:16:34', '2016-09-02 07:02:44', 2, NULL, NULL, '0'),
(14, 6, 2, '2016-09-02 00:00:00', 'yesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyesyes', 1, '2016-09-02 17:09:34', '2016-09-02 07:04:02', 2, NULL, NULL, '0'),
(15, 9, 2, '2016-09-02 00:00:00', 'helo', 1, '2016-09-02 18:16:31', '2016-09-02 08:02:46', 2, NULL, NULL, '0'),
(16, 10, 2, '2016-09-02 00:00:00', 'hi', 1, '2016-09-02 18:16:57', '2016-09-02 08:16:53', 2, 'portfolio', 10, '0'),
(17, 10, 3, '2016-09-02 00:00:00', 'Certificate III in Formwork/Falsework', 1, '2016-09-02 18:17:47', '2016-09-02 08:17:39', 3, 'portfolio', 10, '0'),
(18, NULL, 2, '2016-09-02 00:00:00', '', 1, '2016-09-02 18:22:56', '2016-09-02 08:20:50', 2, 'message', 57, '0'),
(19, NULL, 2, '2016-09-02 00:00:00', 'pleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleasepleaseplease', 1, '2016-09-02 20:11:07', '2016-09-02 10:09:31', 2, 'note', 0, '0'),
(20, NULL, 2, '2016-09-02 00:00:00', '', 1, '2016-09-02 20:11:14', '2016-09-02 10:09:47', 2, 'evidence', 198, '0'),
(21, NULL, 2, '2016-09-02 00:00:00', '', 1, '2016-09-02 20:12:20', '2016-09-02 10:10:51', 2, 'evidence', 79, '0'),
(22, 9, 2, '2016-09-02 00:00:00', 'hi', 1, '2016-09-02 20:12:17', '2016-09-02 10:10:57', 2, 'portfolio', 9, '0'),
(23, 9, 3, '2016-09-02 00:00:00', 'dddd', 1, '2016-09-02 23:22:01', '2016-09-02 10:15:53', 3, NULL, NULL, '0'),
(24, 9, 2, '2016-09-02 00:00:00', '', 1, '2016-09-02 22:25:57', '2016-09-02 10:32:30', 2, 'portfolio', 9, '0'),
(25, 10, 3, '2016-09-02 00:00:00', '', 0, NULL, '2016-09-02 13:22:08', 3, 'portfolio', 10, '0'),
(26, NULL, 2, '2016-09-02 00:00:00', '', 1, '2016-09-03 00:42:13', '2016-09-02 13:23:17', 2, 'evidence', 198, '0'),
(27, NULL, 2, '2016-09-02 00:00:00', '', 1, '2016-09-03 00:42:15', '2016-09-02 13:23:41', 2, 'evidence', 79, '0'),
(28, 6, 2, '2016-09-02 00:00:00', '', 1, '2016-09-03 01:00:02', '2016-09-02 14:48:42', 2, 'portfolio', 6, '0');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL,
  `sessionid` char(255) DEFAULT NULL,
  `assessor` int(11) DEFAULT NULL,
  `applicant` int(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `sessionid`, `assessor`, `applicant`, `created`) VALUES
(1, '2_MX40NTY0MjY5Mn5-MTQ3MjczNDUwOTM5Mn5FVE1OUjNkanZ6S2p2bFJneExvZHB1cmF-fg', 3, 1, '2016-09-01 12:54:55'),
(2, '1_MX40NTY0MjY5Mn5-MTQ3MjczNTg1NzY4Mn5JWHFBdnZWYllEQnlNZ2QzT3dxWXJuZVN-fg', 3, 18, '2016-09-01 13:17:23');

-- --------------------------------------------------------

--
-- Table structure for table `s3_jobs`
--

CREATE TABLE IF NOT EXISTS `s3_jobs` (
  `job_id` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `s3_jobs`
--

INSERT INTO `s3_jobs` (`job_id`, `status`) VALUES
('1472556090151-q89c1j', 1),
('1472557979181-kjwacb', 1),
('1472558171814-ks3woz', 1),
('1472646341167-b37ql8', 1),
('1472646425386-hejktj', 1),
('1472646459548-jjv4tp', 1),
('1472646511815-57k7ya', 1),
('1472646557605-51j35f', 1),
('1472646574308-517hg9', 1),
('1472646947913-s9srzo', 1),
('1472648321287-ad92f3', 1),
('1472732944378-od339b', 1),
('1472732964230-dw9gs5', 1),
('1472733046757-u9naoq', 1),
('1472733173167-wd3odc', 1),
('1472822085725-vv3bsh', 1),
('1472822564233-v27vq5', 1),
('1472826347745-6qi9uq', 1),
('1472827598663-p1bmd6', 1),
('1472827825547-suzapa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file`
--

CREATE TABLE IF NOT EXISTS `tbl_file` (
  `id` int(10) unsigned NOT NULL,
  `fileName` varchar(500) NOT NULL DEFAULT '',
  `filePath` varchar(1000) NOT NULL DEFAULT '',
  `fileSize` int(10) unsigned DEFAULT '0',
  `category` enum('daily','weekly','monthly') NOT NULL DEFAULT 'daily',
  `reportDate` date NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Used to store data about individual pics';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(10) unsigned NOT NULL,
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

CREATE TABLE IF NOT EXISTS `tbl_user_files` (
  `userId` int(10) unsigned NOT NULL DEFAULT '0',
  `fileId` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
  `applicantStatus` int(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `date_of_birth`, `gender`, `universal_student_identifier`, `role_type`, `user_img`, `password_token`, `token_expiry`, `token_status`, `course_condition_status`, `contact_name`, `contact_phone`, `contact_email`, `updated`, `created`, `ceo_name`, `ceo_email`, `ceo_phone`, `created_by`, `status`, `crm_id`, `applicantStatus`) VALUES
(2, 'Hannah                        ', 'Hardy', 'kishore.thalla@valuelabs.com', '$2y$10$3W/SZMu7RF28C6I/OzvZmOsZan8dWnqVXrdQYFpRFCTGr17RnxNH.', '8888-899-898', '01/21/1985', 'male', '12', 2, '2016-09-01-57c7ef49e8977checkmark.jpeg', '57ba9a5f961cf', '2016-08-22 08:23:27', '1', '0', NULL, NULL, 'kishore.thalla@valuelabs.com', '2016-08-10 14:50:56', '0000-00-00 00:00:00', NULL, NULL, NULL, 0, '1', '123456', 0),
(3, 'John', 'Die', 'bala.gajendiran@valuelabs.com', '$2y$10$3W/SZMu7RF28C6I/OzvZmOsZan8dWnqVXrdQYFpRFCTGr17RnxNH.', '9490-123-456', '01/21/1981', 'male', '', 3, '2016-08-31-57c6e152a9693M1.jpg', '', '0000-00-00 00:00:00', '1', '0', NULL, NULL, NULL, '2016-08-10 16:26:04', '0000-00-00 00:00:00', NULL, NULL, NULL, 0, '1', NULL, 0),
(4, 'Get Qualified Australia', '10480NAT', 'madhavi.garimella@valuelabs.com', '$2y$10$I1tHJCe9T59nipJIZ/JV/.fp4TZ32ZLKkz6brBmboBRLvN0Z8LeZW', '', '01/21/1983', 'female', '', 4, '2016-09-02-57c930a53c258uncheckmark.png', '57c053eae5017', '2016-08-27 16:36:26', '0', '0', 'MIS', '12345678', NULL, '2016-08-10 16:26:04', '0000-00-00 00:00:00', NULL, NULL, NULL, 0, '1', NULL, 0),
(13, 'Bindu', 'Mishra', 'bindu.mishra@valuelabs.com', '$2y$10$/.Z6WGf9tGmfmq.ww2ocruisU2eUGAZoGsAo3OmAUJ.7mqSUuI7xy', '919441134888', '30-12-1981', 'female', 'ASDF345667', 1, '', '57c95ade5b38a', '2016-09-02 12:56:30', '1', '', '', '', '', '2016-08-26 13:11:12', '0000-00-00 00:00:00', '', '', '', 0, '1', '', 0),
(14, 'Manager', 'manager', 'manager@gmail.com', '$2y$10$2UYE6S7w/bYrwNAG55Q0Quuf1ynnSqG2vSarzaZT5l5aSOvwM3kcm', '9000757', '02/24/2016', 'male', '2222', 5, '2016-09-02-57c946774a36fC_m__MSG _1.1.png', '552cb3f6bc31c', '2015-04-14 08:30:14', '0', '1', NULL, NULL, NULL, '2014-12-02 07:30:00', '2014-12-03 00:00:00', '', '', '', 0, '1', NULL, 0),
(15, 'Super', 'Admin', 'superadmin@gmail.com', '$2y$10$2UYE6S7w/bYrwNAG55Q0Quuf1ynnSqG2vSarzaZT5l5aSOvwM3kcm', '9000757', '02/24/2016', 'male', '2222', 6, '2016-09-02-57c949d9352dfC_m__MSG _1.1.png', '552cb3f6bc31c', '2015-04-14 08:30:14', '0', '1', NULL, NULL, NULL, '2014-12-02 07:30:00', '2014-12-03 00:00:00', '', '', '', 0, '1', NULL, 0),
(18, 'Mahalakshmi', 'Devi', 'mahalakshmi.gutti@valuelabs.com', '$2y$10$ZME4vSmIi9QKG1wRN0epzu54QBFVwBwM0xoxfSSjtAuLu9EsLI/3m', '919441134888', '30-12-1989', 'female', 'ASDF345667', 1, '', '57c6bd117b7a1', '2016-08-31 13:18:41', '0', '', '', '', '', '2016-08-31 09:26:52', '0000-00-00 00:00:00', '', '', '', 0, '1', '', 0),
(19, 'Sarath', 'Jampani', 'sarath.jampani@valuelabs.com', '$2y$10$9kVB1NrAThDz7NsxES2oeOAodkxo3pzRz9Y/F9ZYNN5S0WxVQQ8dK', '919441134888', '30-12-1989', 'male', 'ASDF345667', 1, '', '57c96d8104eea', '2016-09-02 14:16:01', '0', '', '', '', '', '2016-08-31 10:15:58', '0000-00-00 00:00:00', '', '', '', 0, '1', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(150) NOT NULL,
  `area` varchar(150) DEFAULT NULL,
  `suburb` varchar(150) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `pincode` varchar(10) NOT NULL,
  `updated` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address`, `area`, `suburb`, `city`, `state`, `country`, `pincode`, `updated`, `created`) VALUES
(1, 1, '200hjjvj jbub', 'Broadway Av', 'WEST BEACH', 'sydney', 'SA', 'Australia', '5024', '0000-00-00 00:00:00', '2016-08-10 14:40:08'),
(2, 2, '', NULL, NULL, NULL, NULL, NULL, '', '0000-00-00 00:00:00', '2016-08-10 16:27:54'),
(3, 3, 'Walkway', '123/a', 'Queenland', 'Melbourne', 'Victoria', 'Australia', '123456', '0000-00-00 00:00:00', '2016-08-10 16:27:54'),
(4, 4, '200', 'Broadway Av', 'New south Wales', 'SA', 'SA', 'Australia', '5023', '0000-00-00 00:00:00', '2016-08-10 16:27:54'),
(5, 5, '11', 'Albert Steert', 'Redfern', 'Sydney', 'New South Wales', 'Australia', '2151', '0000-00-00 00:00:00', '2016-08-11 18:02:43'),
(6, 6, '11', 'Albert Steert', 'Redfern', 'Sydney', 'New South Wales', 'Australia', '2151', '0000-00-00 00:00:00', '2016-08-12 04:12:29'),
(7, 7, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2016-08-12 04:55:00'),
(8, 8, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2016-08-26 07:28:26'),
(9, 9, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2016-08-26 07:53:54'),
(10, 10, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2016-08-26 08:43:52'),
(11, 11, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2016-08-26 08:46:58'),
(12, 12, '11c', 'Aston', 'New south wales', 'Canberra', 'Wales', 'Australia', '511234', '0000-00-00 00:00:00', '2016-08-26 08:49:00'),
(13, 13, '899', 'Lane', 'Forest District', 'Sydney', 'Sydney', 'Australia', '2020', '0000-00-00 00:00:00', '2016-08-26 13:11:12'),
(14, 16, '200', 'Walkway', 'BEACH', 'sydney', 'SA', 'Australia', '5024', '0000-00-00 00:00:00', '2016-08-30 07:14:35'),
(15, 17, '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2016-08-30 13:16:25'),
(16, 18, '111', 'Walkway', 'BEACH', 'Canberra', 'NSW', 'Australia', '21212', '0000-00-00 00:00:00', '2016-08-31 09:26:52'),
(17, 19, '123', 'James', 'NSW', 'Canberra', 'Southwales', 'Australia', '21212', '0000-00-00 00:00:00', '2016-08-31 10:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE IF NOT EXISTS `user_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_status` int(11) NOT NULL COMMENT '1 - current, 0 - completed, 2-FacilitatorApproved, 3-Assessor Approved, 15- Submitted to RTO, 16- RTO Issued certificate',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `manager` int(2) DEFAULT NULL,
  `facilitator` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_id`, `course_code`, `course_name`, `course_status`, `created_on`, `manager`, `facilitator`, `assessor`, `rto`, `facilitator_status`, `assessor_status`, `rto_status`, `f_read`, `a_read`, `r_read`, `facilitator_date`, `assessor_date`, `rto_date`, `target_date`, `zoho_id`) VALUES
(6, 13, 'CHC30113', 'Certificate III in Early Childhood Education and Care', 1, '2016-08-29 18:30:00', NULL, 2, NULL, NULL, 0, 0, 0, 1, 0, 0, NULL, NULL, NULL, '2016-11-24 23:11:12', NULL),
(9, 18, 'CPC31511', 'Certificate III in Formwork/Falsework', 11, '2016-08-31 13:38:59', NULL, 2, 3, 4, 1, 1, 1, 1, 1, 1, '2016-09-01 23:25:58', '2016-09-01 23:19:25', NULL, '2016-11-29 19:11:59', NULL),
(10, 19, 'CPC31511', 'Certificate III in Formwork/Falsework', 1, '2016-08-31 14:38:59', NULL, 2, 3, 4, 0, 0, 0, 1, 1, 1, NULL, NULL, NULL, '2016-11-29 20:11:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_course_units`
--

CREATE TABLE IF NOT EXISTS `user_course_units` (
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
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_course_units`
--

INSERT INTO `user_course_units` (`id`, `user_id`, `unit_id`, `course_code`, `type`, `facilitator_status`, `assessor_status`, `rto_status`, `status`, `elective_status`, `issubmitted`, `created_on`) VALUES
(1, 1, 'CHCCS400C', 'CHC30113', 'core', 1, 0, 0, '1', 0, 1, '2016-08-11 04:51:54'),
(2, 1, 'CHCECE001', 'CHC30113', 'core', 0, 0, 0, '1', 0, NULL, '2016-08-11 04:51:54'),
(3, 1, 'CHCECE002', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-11 04:51:54'),
(4, 1, 'CHCECE003', 'CHC30113', 'core', 0, 0, 0, '1', 0, NULL, '2016-08-11 04:51:54'),
(5, 1, 'BSBINN301A', 'CHC30113', 'elective', 0, 0, 0, '1', 0, NULL, '2016-08-11 04:51:54'),
(6, 1, 'BSBSUS301A', 'CHC30113', 'elective', 0, 0, 0, '1', 1, 0, '2016-08-11 04:51:54'),
(7, 5, 'BSBWOR204A', 'CHC30113', 'core', 1, 1, 0, '1', 0, NULL, '2016-08-11 04:51:54'),
(8, 6, 'BSBLDR803', 'ICT80115', 'elective', 1, 1, 0, '1', 1, NULL, '2016-08-12 04:22:47'),
(9, 6, 'ICTICT801', 'ICT80115', 'elective', 1, 1, 0, '1', 1, NULL, '2016-08-12 04:22:47'),
(10, 6, 'ICTICT802', 'ICT80115', 'elective', 1, 1, 0, '1', 1, NULL, '2016-08-12 04:22:47'),
(11, 6, 'ICTICT803', 'ICT80115', 'elective', 0, 0, 0, '0', 0, NULL, '2016-08-12 04:22:47'),
(12, 6, 'ICTICT804', 'ICT80115', 'elective', 1, 1, 0, '1', 1, NULL, '2016-08-12 04:22:47'),
(13, 6, 'ICTICT805', 'ICT80115', 'elective', 1, 1, 0, '1', 1, NULL, '2016-08-12 04:22:47'),
(14, 6, 'ICTICT806', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(15, 6, 'ICTICT807', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(16, 6, 'ICTICT808', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(17, 6, 'ICTICT809', 'ICT80115', 'core', 1, 1, 0, '1', NULL, NULL, '2016-08-12 04:22:47'),
(18, 6, 'ICTICT810', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(19, 6, 'ICTICT811', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(20, 6, 'ICTICT812', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(21, 6, 'ICTICT813', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(22, 6, 'ICTICT814', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(23, 6, 'ICTSUS7236A', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(24, 6, 'ICTSUS801', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(25, 6, 'ICTSUS802', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(26, 6, 'ICTSUS804', 'ICT80115', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:22:47'),
(27, 1, 'CHCECE004', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(28, 1, 'CHCECE005', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(29, 1, 'CHCECE006', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-12 04:48:50'),
(30, 1, 'CHCECE007', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(31, 1, 'CHCECE009', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(32, 1, 'CHCECE010', 'CHC30113', 'core', 0, 0, 0, '1', NULL, 0, '2016-08-12 04:48:50'),
(33, 1, 'CHCECE011', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(34, 1, 'CHCECE012', 'CHC30113', 'elective', 0, 0, 0, '0', 0, NULL, '2016-08-12 04:48:50'),
(35, 1, 'CHCECE013', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(36, 1, 'CHCECE014', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-12 04:48:50'),
(37, 1, 'CHCECE015', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-12 04:48:50'),
(38, 1, 'CHCECE017', 'CHC30113', 'elective', 0, 0, 0, '0', 0, NULL, '2016-08-12 04:48:50'),
(39, 1, 'CHCORG303C', 'CHC30113', 'elective', 0, 0, 0, '0', 0, NULL, '2016-08-12 04:48:50'),
(40, 1, 'CHCPRT001', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(41, 1, 'CHCPRT003', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:48:50'),
(42, 1, 'CHCSAC004', 'CHC30113', 'elective', 0, 0, 0, '0', NULL, NULL, '2016-08-12 04:48:50'),
(43, 1, 'HLTAID004', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(44, 1, 'HLTHIR403C', 'CHC30113', 'elective', 0, 0, 0, '0', 0, NULL, '2016-08-12 04:48:50'),
(45, 1, 'HLTHIR404D', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(46, 1, 'HLTWHS001', 'CHC30113', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:48:50'),
(47, 1, 'SRCCRO008B', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-12 04:48:51'),
(48, 7, 'BSBINN801A', '10480NAT-D', 'core', 1, 1, 1, '1', NULL, NULL, '2016-08-12 04:57:24'),
(49, 7, 'BSBITB701A', '10480NAT-D', 'core', 1, 1, 1, '1', NULL, NULL, '2016-08-12 04:57:24'),
(50, 7, 'BSBFIM701A', '10480NAT-D', 'core', 1, 0, 0, '1', NULL, NULL, '2016-08-12 04:57:24'),
(51, 7, 'MSS408005A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:57:24'),
(52, 7, 'MSS408007A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:57:24'),
(53, 7, 'MSS017004A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:57:24'),
(54, 7, 'MSS027010A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:57:24'),
(55, 7, 'BSBRES801A', '10480NAT-D', 'core', 0, 0, 0, '1', NULL, NULL, '2016-08-12 04:57:24'),
(56, 7, 'SITXINV601', '10480NAT-D', 'elective', 0, 0, 0, '0', 1, NULL, '2016-08-12 04:57:24'),
(57, 12, 'CHCPRT001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:31'),
(58, 12, 'HLTWHS001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(59, 12, 'CHCCS400C', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(60, 12, 'CHCECE001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(61, 12, 'CHCECE002', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(62, 12, 'CHCECE003', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(63, 12, 'CHCECE004', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(64, 12, 'CHCECE005', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(65, 12, 'HLTHIR404D', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(66, 12, 'HLTAID004', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(67, 12, 'CHCECE013', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(68, 12, 'CHCECE011', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(69, 12, 'CHCECE010', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(70, 12, 'CHCECE009', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(71, 12, 'CHCECE007', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-26 12:25:33'),
(72, 12, 'BSBSUS301A', 'CHC30113', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-26 12:25:33'),
(73, 12, 'CHCECE006', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:33'),
(74, 12, 'CHCECE012', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:33'),
(75, 12, 'CHCECE014', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:33'),
(76, 12, 'CHCECE015', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:33'),
(77, 12, 'CHCECE017', 'CHC30113', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-26 12:25:33'),
(78, 12, 'CHCORG303C', 'CHC30113', 'elective', 1, 0, 0, '0', 0, 1, '2016-08-26 12:25:33'),
(79, 12, 'BSBINN301A', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:33'),
(80, 12, 'HLTHIR403C', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:33'),
(81, 12, 'CHCSAC004', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:34'),
(82, 12, 'CHCPRT003', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-26 12:25:34'),
(83, 12, 'SRCCRO008B', 'CHC30113', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-26 12:25:34'),
(84, 1, 'BSBINN301', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-29 06:32:00'),
(85, 1, 'CHCDIV001', 'CHC30113', 'core', 0, 0, 0, '1', 1, 0, '2016-08-29 06:32:00'),
(86, 1, 'CHCDIV002', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-29 06:32:00'),
(87, 1, 'BSBWOR301', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-29 06:32:00'),
(88, 1, 'BSBSUS301', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-29 06:32:00'),
(89, 1, 'CHCLEG001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-29 06:32:00'),
(90, 12, 'BSBINN301', 'CHC30113', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-29 07:08:36'),
(91, 12, 'CHCDIV001', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-29 07:08:36'),
(92, 12, 'CHCDIV002', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-29 07:08:36'),
(93, 12, 'BSBWOR301', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-29 07:08:36'),
(94, 12, 'BSBSUS301', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-29 07:08:36'),
(95, 12, 'CHCLEG001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-08-29 07:08:36'),
(96, 16, 'CPCCCA3022A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(97, 16, 'CPCCCM2008B', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(98, 16, 'RIIOHS202A', 'CPC31511', 'elective', 1, 0, 0, '0', 1, 1, '2016-08-30 07:21:05'),
(99, 16, 'CPCCCM1013A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(100, 16, 'CPCCCA2002B', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(101, 16, 'CPCCCO2013A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(102, 16, 'CPCCCM3001C', 'CPC31511', 'elective', 1, 0, 0, '0', 1, 1, '2016-08-30 07:21:05'),
(103, 16, 'CPCCCA3020A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(104, 16, 'CPCCCA3001A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(105, 16, 'CPCCWC3003A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(106, 16, 'CPCCCM2001A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(107, 16, 'CPCCCM1014A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(108, 16, 'RIICCM210A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(109, 16, 'CPCCCM1015A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(110, 16, 'CPCCCM2007B', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(111, 16, 'CPCCCA3016A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(112, 16, 'CPCCCA3018A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(113, 16, 'CPCCCA3014A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(114, 16, 'RIIWMG203A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(115, 16, 'BSBSMB406A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(116, 16, 'BSBSMB301A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(117, 16, 'CPCCCM2010B', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(118, 16, 'CPCCOHS2001A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(119, 16, 'CPCCSF2004A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(120, 16, 'CPCCCA3019A', 'CPC31511', 'elective', 1, 0, 0, '0', 1, 1, '2016-08-30 07:21:05'),
(121, 16, 'CPCCCM2002A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(122, 16, 'CPCCCA3002A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(123, 16, 'CPCCCM1012A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(124, 16, 'CPCCCA2003A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(125, 16, 'CPCCCA2011A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(126, 16, 'CPCCCA3023A', 'CPC31511', 'core', 1, 0, 0, '1', 0, 1, '2016-08-30 07:21:05'),
(127, 16, 'CPCCSF2003A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-30 07:21:05'),
(128, 16, 'CPCCCA3015A', 'CPC31511', 'elective', 1, 0, 0, '0', 1, 1, '2016-08-30 07:21:05'),
(129, 16, 'CPCCCA3021A', 'CPC31511', 'elective', 1, 0, 0, '0', 1, 1, '2016-08-30 07:21:05'),
(130, 18, 'CPCCCA3022A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(131, 18, 'CPCCCM2008B', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(132, 18, 'RIIOHS202A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(133, 18, 'CPCCCM1013A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(134, 18, 'CPCCCA2002B', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(135, 18, 'CPCCCO2013A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(136, 18, 'CPCCCM3001C', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(137, 18, 'CPCCCA3020A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(138, 18, 'CPCCCA3001A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(139, 18, 'CPCCWC3003A', 'CPC31511', 'elective', 1, 1, 1, '0', 1, 1, '2016-08-31 09:50:10'),
(140, 18, 'CPCCCM2001A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(141, 18, 'CPCCCM1014A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(142, 18, 'RIICCM210A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(143, 18, 'CPCCCM1015A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(144, 18, 'CPCCCM2007B', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(145, 18, 'CPCCCA3016A', 'CPC31511', 'elective', 1, 1, 1, '0', 1, 1, '2016-08-31 09:50:10'),
(146, 18, 'CPCCCA3018A', 'CPC31511', 'elective', 1, 1, 1, '0', 1, 1, '2016-08-31 09:50:10'),
(147, 18, 'CPCCCA3014A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(148, 18, 'RIIWMG203A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(149, 18, 'BSBSMB406A', 'CPC31511', 'elective', 1, 1, 1, '0', 1, 1, '2016-08-31 09:50:10'),
(150, 18, 'BSBSMB301A', 'CPC31511', 'elective', 1, 1, 1, '0', 1, 1, '2016-08-31 09:50:10'),
(151, 18, 'CPCCCM2010B', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(152, 18, 'CPCCOHS2001A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(153, 18, 'CPCCSF2004A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(154, 18, 'CPCCCA3019A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(155, 18, 'CPCCCM2002A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(156, 18, 'CPCCCA3002A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(157, 18, 'CPCCCM1012A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(158, 18, 'CPCCCA2003A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(159, 18, 'CPCCCA2011A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(160, 18, 'CPCCCA3023A', 'CPC31511', 'core', 1, 1, 1, '1', 0, 1, '2016-08-31 09:50:10'),
(161, 18, 'CPCCSF2003A', 'CPC31511', 'elective', 1, 1, 1, '0', 1, 1, '2016-08-31 09:50:10'),
(162, 18, 'CPCCCA3015A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(163, 18, 'CPCCCA3021A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 09:50:10'),
(164, 19, 'CPCCCA3022A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(165, 19, 'CPCCCM2008B', 'CPC31511', 'core', 0, 0, 0, '1', 0, 1, '2016-08-31 14:44:17'),
(166, 19, 'RIIOHS202A', 'CPC31511', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-31 14:44:17'),
(167, 19, 'CPCCCM1013A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(168, 19, 'CPCCCA2002B', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(169, 19, 'CPCCCO2013A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(170, 19, 'CPCCCM3001C', 'CPC31511', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-31 14:44:17'),
(171, 19, 'CPCCCA3020A', 'CPC31511', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-31 14:44:17'),
(172, 19, 'CPCCCA3001A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(173, 19, 'CPCCWC3003A', 'CPC31511', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-31 14:44:17'),
(174, 19, 'CPCCCM2001A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(175, 19, 'CPCCCM1014A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(176, 19, 'RIICCM210A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(177, 19, 'CPCCCM1015A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(178, 19, 'CPCCCM2007B', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(179, 19, 'CPCCCA3016A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(180, 19, 'CPCCCA3018A', 'CPC31511', 'elective', 0, 0, 0, '0', 1, 0, '2016-08-31 14:44:17'),
(181, 19, 'CPCCCA3014A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(182, 19, 'RIIWMG203A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(183, 19, 'BSBSMB406A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(184, 19, 'BSBSMB301A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(185, 19, 'CPCCCM2010B', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(186, 19, 'CPCCOHS2001A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(187, 19, 'CPCCSF2004A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(188, 19, 'CPCCCA3019A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(189, 19, 'CPCCCM2002A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(190, 19, 'CPCCCA3002A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(191, 19, 'CPCCCM1012A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(192, 19, 'CPCCCA2003A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(193, 19, 'CPCCCA2011A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(194, 19, 'CPCCCA3023A', 'CPC31511', 'core', 0, 0, 0, '1', 0, 0, '2016-08-31 14:44:17'),
(195, 19, 'CPCCSF2003A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(196, 19, 'CPCCCA3015A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(197, 19, 'CPCCCA3021A', 'CPC31511', 'elective', 0, 0, 0, '0', 0, 0, '2016-08-31 14:44:17'),
(198, 13, 'SRCCRO008B', 'CHC30113', 'elective', 1, 0, 0, '0', 1, 1, '2016-09-01 08:23:12'),
(199, 13, 'BSBINN301', 'CHC30113', 'elective', 1, 0, 0, '0', 1, 1, '2016-09-01 08:23:12'),
(200, 13, 'CHCECE014', 'CHC30113', 'elective', 1, 0, 0, '0', 1, 1, '2016-09-01 08:23:12'),
(201, 13, 'CHCECE010', 'CHC30113', 'core', 1, 0, 0, '1', 0, 1, '2016-09-01 08:23:13'),
(202, 13, 'HLTWHS001', 'CHC30113', 'core', 1, 0, 0, '1', 0, 1, '2016-09-01 08:23:13'),
(203, 13, 'CHCPRT001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 1, '2016-09-01 08:23:13'),
(204, 13, 'CHCDIV001', 'CHC30113', 'elective', 1, 0, 0, '0', 1, 1, '2016-09-01 08:23:13'),
(205, 13, 'CHCDIV002', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(206, 13, 'CHCPRT003', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13'),
(207, 13, 'CHCECE012', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13'),
(208, 13, 'CHCECE004', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(209, 13, 'CHCECE005', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(210, 13, 'CHCECE002', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(211, 13, 'CHCECE001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(212, 13, 'BSBWOR301', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13'),
(213, 13, 'CHCECE006', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13'),
(214, 13, 'BSBSUS301', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13'),
(215, 13, 'CHCECE017', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13'),
(216, 13, 'CHCECE009', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(217, 13, 'CHCLEG001', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(218, 13, 'CHCECE013', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(219, 13, 'CHCSAC004', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13'),
(220, 13, 'HLTAID004', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(221, 13, 'CHCECE003', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(222, 13, 'CHCECE007', 'CHC30113', 'core', 0, 0, 0, '1', 0, 0, '2016-09-01 08:23:13'),
(223, 13, 'CHCECE015', 'CHC30113', 'elective', 0, 0, 0, '0', 0, 0, '2016-09-01 08:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_ids`
--

CREATE TABLE IF NOT EXISTS `user_ids` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(150) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size` varchar(20) NOT NULL,
  `status` int(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_ids`
--

INSERT INTO `user_ids` (`id`, `user_id`, `type`, `name`, `path`, `created`, `size`, `status`) VALUES
(1, 18, 1, 'Sunset.jpg', '2016-08-31-57c6a78a8a658Sunset.jpg', '2016-08-31 09:46:56', '10257', NULL),
(2, 18, 7, 'Tree (1).jpg', '2016-08-31-57c6a798edc56Tree (1).jpg', '2016-08-31 09:47:10', '7796', NULL),
(6, 19, 1, 'Tree (1).jpg', '2016-08-31-57c6f2d395031Tree (1).jpg', '2016-08-31 15:08:09', '7796', 1),
(7, 19, 3, 'Flower.jpg', '2016-08-31-57c6f2e18ec03Flower.jpg', '2016-08-31 15:08:22', '5484', 1),
(8, 13, 1, 'index.jpg', '2016-09-01-57c7ea1b51a16index.jpg', '2016-09-01 08:43:12', '8455', 1),
(9, 13, 5, 'Sunset.jpg', '2016-09-01-57c7ea301328eSunset.jpg', '2016-09-01 08:43:33', '10257', 1),
(10, 19, 2, '30-Chrysanthemum.jpg', '2016-09-02-57c9732df03a330-Chrysanthemum.jpg', '2016-09-02 12:40:20', '879394', 1),
(11, 13, 3, 'Flower value.jpg', '2016-09-02-57c9866947cb1Flower value.jpg', '2016-09-02 14:02:22', '5484', 1),
(12, 13, 5, 'Tree (1).jpg', '2016-09-02-57c9867e681aeTree (1).jpg', '2016-09-02 14:02:43', '7796', NULL),
(13, 19, 1, 'Chrysanthemum.jpg', '2016-09-02-57c9882375559Chrysanthemum.jpg', '2016-09-02 14:09:53', '879394', NULL),
(14, 13, 1, 'Tree (1).jpg', '2016-09-02-57c98916ab904Tree (1).jpg', '2016-09-02 14:13:48', '7796', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `document_type`
--
ALTER TABLE `document_type`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `user_course_units`
--
ALTER TABLE `user_course_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_ids`
--
ALTER TABLE `user_ids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ids_ibfk_1` (`user_id`),
  ADD KEY `user_ids_ibfk_2` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document_type`
--
ALTER TABLE `document_type`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `evidence`
--
ALTER TABLE `evidence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=232;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `other_files`
--
ALTER TABLE `other_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_file`
--
ALTER TABLE `tbl_file`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_course_units`
--
ALTER TABLE `user_course_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=224;
--
-- AUTO_INCREMENT for table `user_ids`
--
ALTER TABLE `user_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
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
