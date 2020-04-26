-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2020 at 11:38 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eevee`
--

-- --------------------------------------------------------

--
-- Table structure for table `mapstatus`
--

CREATE TABLE `mapstatus` (
  `id` int(11) NOT NULL,
  `md5` text NOT NULL,
  `status` int(11) NOT NULL,
  `rankedby` text NOT NULL,
  `special` text NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `playername` text NOT NULL,
  `md5pass` text NOT NULL,
  `score` int(11) NOT NULL,
  `banned` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `players`
--



-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `scoreid` int(11) NOT NULL,
  `beatmaphash` text NOT NULL,
  `username` text NOT NULL,
  `score` int(11) NOT NULL,
  `maxcombo` int(11) NOT NULL,
  `hit300` int(11) NOT NULL,
  `hit100` int(11) NOT NULL,
  `hit50` int(11) NOT NULL,
  `hit0` int(11) NOT NULL,
  `hitGeki` int(11) NOT NULL,
  `hitKatu` int(11) NOT NULL,
  `perfect` text NOT NULL,
  `mods` int(11) NOT NULL,
  `pass` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scores`
--


-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `userid` int(11) NOT NULL,
  `username` text NOT NULL,
  `privledge` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`userid`, `username`, `privledge`) VALUES

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mapstatus`
--
ALTER TABLE `mapstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`scoreid`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
