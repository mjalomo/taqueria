-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 25, 2018 at 08:54 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taqueria`
--

-- --------------------------------------------------------

--
-- Table structure for table `combo`
--

CREATE TABLE `combo` (
  `id` int(11) NOT NULL,
  `price` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `combo_food`
--

CREATE TABLE `combo_food` (
  `combo_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `combo_request`
--

CREATE TABLE `combo_request` (
  `combo_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `name` char(32) NOT NULL,
  `price` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `person_name` char(32) NOT NULL,
  `special_id` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_food`
--

CREATE TABLE `request_food` (
  `request_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `combo`
--
ALTER TABLE `combo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo_food`
--
ALTER TABLE `combo_food`
  ADD PRIMARY KEY (`combo_id`,`food_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `combo_request`
--
ALTER TABLE `combo_request`
  ADD PRIMARY KEY (`combo_id`,`request_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_food`
--
ALTER TABLE `request_food`
  ADD PRIMARY KEY (`request_id`,`food_id`),
  ADD KEY `food_id` (`food_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `combo`
--
ALTER TABLE `combo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `combo_food`
--
ALTER TABLE `combo_food`
  ADD CONSTRAINT `combo_food_ibfk_1` FOREIGN KEY (`combo_id`) REFERENCES `combo` (`id`),
  ADD CONSTRAINT `combo_food_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`);

--
-- Constraints for table `combo_request`
--
ALTER TABLE `combo_request`
  ADD CONSTRAINT `combo_request_ibfk_1` FOREIGN KEY (`combo_id`) REFERENCES `combo` (`id`),
  ADD CONSTRAINT `combo_request_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `request` (`id`);

--
-- Constraints for table `request_food`
--
ALTER TABLE `request_food`
  ADD CONSTRAINT `request_food_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `request` (`id`),
  ADD CONSTRAINT `request_food_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
