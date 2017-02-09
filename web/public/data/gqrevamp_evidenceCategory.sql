/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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