-- phpMyAdmin SQL Dump
-- version 4.0.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2014 at 09:54 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rdet`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_authors_person_idx` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `person_id`, `type`) VALUES
(4, 32, 2),
(5, 33, 1),
(6, 26, 3),
(7, 28, 1),
(8, 31, 2);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `research_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filetype` varchar(30) NOT NULL,
  `filesize` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_files_research1_idx` (`research_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `research_id`, `title`, `filename`, `filetype`, `filesize`) VALUES
(21, 7, 'sdfsdfdsf', '9c1d4e1404765ca44d6856fdcf0c81ec.jpg', 'image/jpeg', 826),
(22, 7, 'sdfsdfsdf', 'ed7383fd36931992f4b4287fc069eb52.jpg', 'image/jpeg', 760),
(23, 7, 'asdgasdghdfgasdgsdg', 'eab1c054a40a8765907ddfb0bae57a67.jpg', 'image/jpeg', 548),
(24, 7, 'sadgawetawegagawgawg', '5c1c0e8fcf8288719754526eac54657e.jpg', 'image/jpeg', 859),
(28, 7, 'ttvgyhbunjmkl', '09ccd7b67e2abf371741cb3b09417828.jpg', 'image/jpeg', 859);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `first_name`, `middle_name`, `last_name`, `birth_date`, `sex`, `address`) VALUES
(26, 'Robin', 'nibor', 'Hood', '2013-12-05', 'MALE', 'ENGLAND'),
(28, 'Jack', 'Brown', 'Black', '1993-12-01', 'FEMALE', 'BAGUIO'),
(30, 'Johny', 'D', 'Doe', '2013-12-18', 'MALE', 'MANILA'),
(31, 'JAKE', 'GUR', 'Hoard', '2014-01-21', 'MALE', 'BAGUIO CITY'),
(32, 'Bonding', 'Bond', 'James', NULL, 'FEMALE', NULL),
(33, 'Jano', 'Gibbs', 'Apo', NULL, 'FEMALE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publish`
--

CREATE TABLE IF NOT EXISTS `publish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `authors_id` int(11) NOT NULL,
  `research_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_publish_authors1_idx` (`authors_id`),
  KEY `fk_publish_research1_idx` (`research_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `publish`
--

INSERT INTO `publish` (`id`, `authors_id`, `research_id`) VALUES
(1, 4, 1),
(2, 5, 1),
(11, 5, 2),
(12, 8, 2),
(13, 6, 2),
(14, 8, 6),
(15, 8, 1),
(16, 4, 8),
(17, 5, 9),
(18, 6, 10),
(19, 7, 11),
(20, 8, 12),
(21, 8, 13),
(22, 7, 14),
(23, 6, 15),
(24, 5, 16),
(25, 8, 18),
(26, 4, 18),
(29, 5, 18);

-- --------------------------------------------------------

--
-- Table structure for table `research`
--

CREATE TABLE IF NOT EXISTS `research` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `publication_type` tinyint(4) DEFAULT NULL,
  `research_books` tinyint(4) DEFAULT NULL,
  `research_type` tinyint(4) DEFAULT NULL,
  `presentation` tinyint(4) DEFAULT NULL,
  `funding_agency` varchar(150) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `date_completed` date DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT NULL,
  `year_published` year(4) DEFAULT NULL,
  `downloads` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `research`
--

INSERT INTO `research` (`id`, `title`, `publication_type`, `research_books`, `research_type`, `presentation`, `funding_agency`, `status`, `date_completed`, `date_added`, `year_published`, `downloads`, `views`) VALUES
(1, 'Beginning PHP', 1, 2, 1, 1, 'RDET Office', 1, '2013-12-11', '2013-12-24 20:41:34', 2013, 5, 2),
(2, 'Build A Better Website', 2, 1, 1, 1, 'IFSU', 2, NULL, '2013-12-25 18:11:08', NULL, 2, 5),
(3, 'High Performance Websites', 1, 2, 2, 2, 'IFSU', 1, '2007-08-09', '2013-12-25 18:15:05', 2007, 5, 6),
(4, 'The quick brown fox', 1, 2, 1, 1, 'Tanib Funds', 2, NULL, '2013-12-26 23:03:47', NULL, 7, 1),
(5, 'Abacus', 3, 2, 1, 1, 'Man Funds', 2, NULL, '2013-12-26 23:05:04', NULL, 4, 4),
(6, '30 ways to promote your website on a shoe string budget', 1, 2, 3, 1, 'IFSU RDET', 1, '2008-07-01', '2008-07-01 19:41:34', 2008, 3, 1),
(7, '101 ways to promote your web site 5th Edition', 2, 1, 2, 2, 'IFSU RDET', 1, '2010-09-06', '2010-09-06 23:41:34', 2010, 5, 3),
(8, 'Be #1 on Google', 3, 2, 1, 3, 'IFSU RDET', 2, '0000-00-00', '2012-12-24 19:41:34', 0000, 2, 8),
(9, 'Beginners guide to content management system', 1, 1, 3, 1, 'IFSU RDET', 2, '0000-00-00', '2013-12-24 20:41:34', 0000, 5, 1),
(10, 'Cisco Press - The business case for e-learning', 2, 2, 2, 2, 'IFSU RDET', 1, '2002-12-09', '2002-12-09 18:41:34', 2002, 4, 3),
(11, 'Developing a Content Management System', 3, 1, 1, 3, 'IFSU RDET', 1, '2009-10-12', '2009-10-12 23:41:34', 2009, 8, 4),
(12, 'Docrtine ORM for PHP', 1, 2, 3, 1, 'IFSU RDET', 2, '0000-00-00', '2011-12-24 20:41:34', 0000, 4, 7),
(13, 'Drupal 7 Bible', 2, 1, 2, 2, 'IFSU RDET', 2, '0000-00-00', '2013-12-24 17:41:34', 0000, 2, 1),
(14, 'Open Source CMS eBook', 3, 2, 1, 3, 'IFSU RDET', 1, '2004-11-03', '2004-11-03 15:41:34', 2004, 1, 2),
(15, 'Using moddle 2nd Edition', 1, 1, 3, 1, 'IFSU RDET', 1, '2001-01-06', '2001-01-06 20:41:34', 2001, 3, 4),
(16, 'Web API design', 2, 2, 2, 2, 'IFSU RDET', 2, '0000-00-00', '2011-12-24 18:41:34', 0000, 4, 4),
(17, 'Professional Mobile Web Development', 3, 1, 1, 3, 'IFSU RDET', 2, '0000-00-00', '2013-12-25 00:41:34', 0000, 6, 3),
(18, 'Jack the Giant Slayer', 1, 1, 1, 1, NULL, 2, NULL, '2014-01-02 06:16:11', NULL, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(15) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `privilege` tinyint(4) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_accounts_person1_idx` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `emp_id`, `date_created`, `privilege`, `username`, `password`, `active`, `person_id`) VALUES
(24, '1003', '2013-12-21 03:31:15', 2, 'robin', 'rdet', 1, 26),
(26, '1004', '2013-12-21 05:07:50', 2, 'jack', 'rdet', 1, 28),
(28, '1001', '2013-12-21 06:52:18', 1, 'admin', 'admin', 1, 30);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `fk_authors_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fk_files_research1` FOREIGN KEY (`research_id`) REFERENCES `research` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `publish`
--
ALTER TABLE `publish`
  ADD CONSTRAINT `fk_publish_authors1` FOREIGN KEY (`authors_id`) REFERENCES `authors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_publish_research1` FOREIGN KEY (`research_id`) REFERENCES `research` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD CONSTRAINT `fk_user_accounts_person1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
