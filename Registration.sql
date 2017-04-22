-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 22, 2017 at 07:21 AM
-- Server version: 5.7.17-0ubuntu0.16.04.2
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `Details`
--

CREATE TABLE `Details` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `max_response` int(11) NOT NULL DEFAULT '10',
  `is_accepting` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Details`
--

INSERT INTO `Details` (`id`, `name`, `uname`, `password`, `max_response`, `is_accepting`) VALUES
(1, 'FOSS Lab Registration', 'admin', 'fosslab', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Fields`
--

CREATE TABLE `Fields` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Fields`
--

INSERT INTO `Fields` (`id`, `name`) VALUES
(1, 'First Name'),
(2, 'Last Name'),
(3, 'Branch'),
(4, 'Semester'),
(5, 'Email'),
(6, 'Phone'),
(7, ''),
(8, ''),
(9, ''),
(10, '');

-- --------------------------------------------------------

--
-- Table structure for table `Responses`
--

CREATE TABLE `Responses` (
  `id` int(11) NOT NULL,
  `col1` varchar(500) NOT NULL DEFAULT '',
  `col2` varchar(500) NOT NULL DEFAULT '',
  `col3` varchar(500) NOT NULL DEFAULT '',
  `col4` varchar(500) NOT NULL DEFAULT '',
  `col5` varchar(500) NOT NULL DEFAULT '',
  `col6` varchar(500) NOT NULL DEFAULT '',
  `col7` varchar(500) NOT NULL DEFAULT '',
  `col8` varchar(500) NOT NULL DEFAULT '',
  `col9` varchar(500) NOT NULL DEFAULT '',
  `col10` varchar(500) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Responses`
--

INSERT INTO `Responses` (`id`, `col1`, `col2`, `col3`, `col4`, `col5`, `col6`, `col7`, `col8`, `col9`, `col10`, `time`) VALUES
(1, 'Bruce', 'Wayne', 'CSE', 'S4', 'iambatman@gmail.com', '1234567890', '', '', '', '', '2017-04-18 16:39:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Details`
--
ALTER TABLE `Details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Fields`
--
ALTER TABLE `Fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Responses`
--
ALTER TABLE `Responses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Details`
--
ALTER TABLE `Details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Fields`
--
ALTER TABLE `Fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Responses`
--
ALTER TABLE `Responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
