

CREATE TABLE `evidence_category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created` TIMESTAMP NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evidence_category`
--
ALTER TABLE `evidence_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evidence_category`
--
ALTER TABLE `evidence_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `evidence` ADD `category` INT(10) NULL DEFAULT NULL AFTER `job_id`, ADD INDEX (`category`);

ALTER TABLE `evidence`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`category`) REFERENCES `evidence_category` (`id`);


INSERT INTO `evidence_category` (`id`, `name`, `created`) VALUES
(1, 'Resume, references & job descriptions', '2017-02-07 11:09:17'),
(2, 'Word samples, memos, letters, reports', '2017-02-07 11:09:17'),
(3, 'Photographic and video evidence', '2017-02-07 11:09:17'),
(4, 'Education, training and qualifications', '2017-02-07 11:09:17'),
(5, 'Other evidences', '2017-02-07 11:09:17');