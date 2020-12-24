-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2020 at 02:44 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zigma_f3aemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` bigint(15) NOT NULL,
  `password` varchar(150) NOT NULL,
  `location` varchar(100) NOT NULL,
  `education` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `specialization` varchar(150) NOT NULL,
  `university` varchar(100) NOT NULL,
  `coursetype` varchar(100) NOT NULL,
  `passedout` int(10) NOT NULL,
  `percentage` varchar(100) NOT NULL,
  `resume` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `utype` varchar(15) NOT NULL DEFAULT 'Candidate',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='All employers(user) details';

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `name`, `email`, `contact`, `password`, `location`, `education`, `course`, `specialization`, `university`, `coursetype`, `passedout`, `percentage`, `resume`, `status`, `utype`, `created_at`, `updated_at`) VALUES
(1, 'Akeel', 'ahamedalakeel@gmail.com', 8528528520, '$2y$10$AjuP3wZ3q0..OR.DeHUh.eD77KJl9YrUXZc1djvnJC1L/caPdnCeW', '', '', '', '', '', '', 0, '', '', 1, 'Candidate', '2020-06-10 17:28:39', '2020-06-10 17:28:39'),
(2, 'mouly', 'moulyraj279@gmail.com', 7485961230, '$2y$10$sP4eX9wxcIR7i0AjiW2I5uULkqmRF8pCodlaY3T69q8sez2JP5HNe', 'Erode', '', '', '', '', '', 0, '', '', 1, 'Candidate', '2020-06-11 10:17:25', '2020-06-11 10:17:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
