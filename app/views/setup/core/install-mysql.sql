-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2019 at 10:02 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` varchar(250) NOT NULL PRIMARY KEY,
  `comp_name` varchar(250) NULL DEFAULT NULL,
  `logo` text NULL DEFAULT NULL,
  `designer` varchar(250) NULL DEFAULT NULL,
  `site` varchar(250) NULL DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` varchar(65) NOT NULL PRIMARY KEY,
  `data` varchar(250) NULL DEFAULT NULL,
  `last_accessed` varchar(250) NULL DEFAULT NULL,
  `session_expire` varchar(100) NULL DEFAULT NULL,
  `login_type` varchar(200) NULL DEFAULT NULL,
  `ip_address` varchar(250) NULL DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posting_data`
--

CREATE TABLE `posting_data` (
 `ippis_no` varchar(250)  NOT NULL PRIMARY KEY,
`ref_no` varchar(250) NULL DEFAULT NULL,
  `surname` varchar(250) NULL DEFAULT NULL,
  `other_name` varchar(250) NULL DEFAULT NULL,
  `first_name` varchar(250) NULL DEFAULT NULL,
`sex` varchar(250) NULL DEFAULT NULL,
`phone` varchar(250) NULL DEFAULT NULL,
`designation` varchar(250) NULL DEFAULT NULL,
  `from_mda` varchar(250) NULL DEFAULT NULL,
  `to_mda` varchar(250) NULL DEFAULT NULL,
  `posting_reason` varchar(250) NULL DEFAULT NULL,
`vice_by` varchar(250) NULL DEFAULT NULL,
  `posting_date` Date NOT NULL,
 `effective_date` Date NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posting_data`
--

CREATE TABLE `posting_data_temp` (
 `ippis_no` varchar(250)  NOT NULL PRIMARY KEY,
`ref_no` varchar(250) NULL DEFAULT NULL,
  `surname` varchar(250) NULL DEFAULT NULL,
  `other_name` varchar(250) NULL DEFAULT NULL,
  `first_name` varchar(250) NULL DEFAULT NULL,
`sex` varchar(250) NULL DEFAULT NULL,
`phone` varchar(250) NULL DEFAULT NULL,
`designation` varchar(250) NULL DEFAULT NULL,
  `from_mda` varchar(250) NULL DEFAULT NULL,
  `to_mda` varchar(250) NULL DEFAULT NULL,
  `posting_reason` varchar(250) NULL DEFAULT NULL,
`vice_by` varchar(250) NULL DEFAULT NULL,
  `posting_date` Date NOT NULL,
 `effective_date` Date NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `posting_history`
--

CREATE TABLE `posting_history` (
    `id` BigInt(250) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`ref_no` varchar(250) NULL DEFAULT NULL,
   `ippis_no` varchar(250) NULL DEFAULT NULL,
  `surname` varchar(250) NULL DEFAULT NULL,
  `other_name` varchar(250) NULL DEFAULT NULL,
  `first_name` varchar(250) NULL DEFAULT NULL,
`sex` varchar(250) NULL DEFAULT NULL,
`phone` varchar(250) NULL DEFAULT NULL,
`designation` varchar(250) NULL DEFAULT NULL,
  `from_mda` varchar(250) NULL DEFAULT NULL,
  `to_mda` varchar(250) NULL DEFAULT NULL,
 `posting_reason` varchar(250) NULL DEFAULT NULL,
`vice_by` varchar(250) NULL DEFAULT NULL,
  `posting_date` Date NOT NULL,
 `effective_date` Date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
`username` varchar(250) NOT NULL PRIMARY KEY,
  `first_name` varchar(250)NULL DEFAULT NULL,
  `last_name` varchar(250) NULL DEFAULT NULL,
  `sex` varchar(250) NULL DEFAULT NULL,
  `email_address` varchar(250) NULL DEFAULT NULL,
  `password` varchar(250) NULL DEFAULT NULL,
  `isadmin` tinyint(2) NOT NULL DEFAULT '0',
  `isuser` tinyint(2) NOT NULL DEFAULT '0',
  `change_pwd` tinyint(2) NOT NULL DEFAULT '0',
  `date_created` datetime NULL DEFAULT NULL,
  `created_by` varchar(100) NULL DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vportal`
--

CREATE TABLE `vportal` (
  `ippis_no` varchar(250) NOT NULL PRIMARY KEY,
  `surname` varchar(250) NULL DEFAULT NULL,
  `other_name` varchar(250) NULL DEFAULT NULL,
  `first_name` varchar(250) NULL DEFAULT NULL,
`sex` varchar(250) NULL DEFAULT NULL,
`phone` varchar(250) NULL DEFAULT NULL,
  `dob` varchar(250) NULL DEFAULT NULL,
  `dofa` varchar(250) NULL DEFAULT NULL,
  `mda_location` varchar(250) NULL DEFAULT NULL,
  `designation` varchar(250) NULL DEFAULT NULL,
  `sgl` varchar(250) NULL DEFAULT NULL,
  `department` varchar(250) NULL DEFAULT NULL,
    `mda_name` text NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
