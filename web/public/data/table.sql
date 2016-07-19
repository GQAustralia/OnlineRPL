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