-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 19, 2013 at 11:40 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `myhealth`
--
CREATE DATABASE IF NOT EXISTS `myhealth` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `myhealth`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill`
--

CREATE TABLE IF NOT EXISTS `tbl_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `payment_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_failed_logins`
--

CREATE TABLE IF NOT EXISTS `tbl_failed_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipadress` varchar(45) NOT NULL,
  `datetime` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_failed_logins`
--

INSERT INTO `tbl_failed_logins` (`id`, `ipadress`, `datetime`, `user_id`) VALUES
(1, '::1', '2013-09-18 13:27:27', 1),
(2, '::1', '2013-09-18 13:28:00', 1),
(3, '::1', '2013-09-18 13:28:09', 1),
(4, '::1', '2013-09-18 13:40:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `code` varchar(128) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_practitioner`
--

CREATE TABLE IF NOT EXISTS `tbl_practitioner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `first_name` varchar(24) NOT NULL,
  `last_name` varchar(24) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_practitioner`
--

INSERT INTO `tbl_practitioner` (`id`, `email`, `first_name`, `last_name`) VALUES
(1, 'parctisioner@gmail.com', 'Prac', 'Tisioner');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(64) NOT NULL,
  `first_login` tinyint(1) NOT NULL,
  `language` varchar(12) NOT NULL,
  `last_login` datetime NOT NULL,
  `practitioner_id` int(11) NOT NULL,
  `bsn` varchar(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prac_id` (`practitioner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`, `first_login`, `language`, `last_login`, `practitioner_id`, `bsn`) VALUES
(1, 'user', '$2a$13$RDDRuG4w8rW3x63j2uvLC.worZ9NJkhqWYdE0ZpLpAXXyKjMw00nK', 'user@gmail.com', 0, 'dutch', '2013-09-18 00:00:00', 1, '000000000');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bill`
--
ALTER TABLE `tbl_bill`
  ADD CONSTRAINT `bill_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_failed_logins`
--
ALTER TABLE `tbl_failed_logins`
  ADD CONSTRAINT `failed_logins_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `order_bill_id` FOREIGN KEY (`bill_id`) REFERENCES `tbl_bill` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `user_practitioner_id` FOREIGN KEY (`practitioner_id`) REFERENCES `tbl_practitioner` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
