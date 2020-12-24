-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2020 at 12:17 PM
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
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Main category table';

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ITI', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(2, 'LABOURS', '2019-12-08 02:09:27', '2019-12-21 02:51:16'),
(3, 'ACCOUNTS', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(4, 'AGRICULTURE', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(5, 'DRIVER', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(6, 'ENGINEERING', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(7, 'HUMAN RESOURCES', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(8, 'IT', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(9, 'SUPERVISOR', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(10, 'MANAGER', '2019-12-08 02:09:27', '2019-12-08 02:09:27'),
(11, 'Advertisement', '2019-12-12 03:20:54', '2019-12-12 03:20:54'),
(12, 'Marketing', '2020-01-02 11:49:23', '2020-01-02 11:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `id` int(11) NOT NULL,
  `company` varchar(100) NOT NULL,
  `hr` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` bigint(15) NOT NULL,
  `address` varchar(180) NOT NULL,
  `title` varchar(50) NOT NULL,
  `incorporat` year(4) NOT NULL,
  `hr_email` varchar(100) NOT NULL,
  `hr_contact` bigint(15) NOT NULL,
  `password` varchar(150) NOT NULL,
  `about` varchar(180) NOT NULL,
  `utype` enum('Employer','Admin') NOT NULL DEFAULT 'Employer',
  `status` enum('1','2','3') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='All employers(user) details';

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `company`, `hr`, `email`, `contact_number`, `address`, `title`, `incorporat`, `hr_email`, `hr_contact`, `password`, `about`, `utype`, `status`, `created_at`, `updated_at`) VALUES
(1, 'xess', 'akeel', 'ahamedalakeel@gmail.com', 9876543210, 'erode', 'Private', 2014, 'ahamedalakeel@gmail.com', 9876543210, '$2y$10$8sKgbe.FwMrwiTFRrt/ckOG2DemGY0EoTnVnGtTrnkraLujBBk7EC', 'asdasfafd', 'Employer', '1', '2019-12-07 14:14:25', '2020-03-26 14:28:08'),
(2, 'Round table', 'akeel', 'admin@employindia.com', 9876543210, 'erode, india', 'Partnership Firm', 2014, 'ahamedalakeel@gmail.com', 9876543210, '$2y$10$TQcdg0BIRrPGERMj21pLGuJRk1ex.D1yyU4xDloAPOi4OkNWFTYZq', 'asdasfafd', 'Admin', '1', '2019-12-07 14:14:25', '2020-01-02 11:03:45'),
(3, 'xess', 'akeel', 'xesstechlink@gmail.com', 8989898989, 'erode', 'Public', 2017, 'xesstechlink@gmail.com', 9638527410, '$2y$10$GvQ7NYxGLInDPjBrkAEKbOAbpiI4U/0Kc3u2dqwqRWznLvkVtkZXq', '95jhgjhgjhgjk\r\n', 'Employer', '1', '2020-01-02 11:45:04', '2020-01-02 11:45:04'),
(5, 'Saravana Chem Dyes', 'saran', 'karthikbalaji21@gmail.com', 7339222562, 'Erode', 'Partnership Firm', 1983, 'kb@saravanachemdyes.com', 7339222562, '$2y$10$i9ZSAw13dd56fedsIso5Ae4l0QjhXj0WtfvLPj74IcdZ3jO8UPRKu', 'Distributor for Textile Dyes and Chemicals', 'Employer', '1', '2020-03-11 13:28:50', '2020-03-11 13:28:50'),
(6, 'mouly', 'abc', 'moulyraj279@gmail.com', 7418529630, 'mouly', 'Private', 2014, 'abc@gmail.com', 7444564545, '$2y$10$qWP0GqF45yW6mdr2rWaX6Ot8JKIjtFDzmEiZrU57mGNotMBoOCko.', 'test', 'Employer', '1', '2020-06-09 06:23:16', '2020-06-09 06:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(10) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mechanic', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(2, 1, 'Electrician', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(3, 1, 'Apprentice', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(4, 1, 'Machine Operator', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(5, 2, 'Delivery Boy', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(6, 2, 'Labours / Unskilled Worker', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(7, 2, 'Loadman', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(8, 2, 'Packing Staff', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(9, 3, 'Account Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(10, 3, 'Accountant', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(11, 4, 'Agricultural Consultant', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(12, 5, 'Bus Driver', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(13, 5, 'Lorry / LCV Driver', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(14, 6, 'Civil Engineer', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(15, 6, 'Computer Engineer', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(16, 6, 'Field / Site Engineer', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(17, 7, 'HR Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(18, 7, 'Recruitment Officer', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(19, 8, 'Specify', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(20, 9, 'Factory / Production Supervisor', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(21, 9, 'Hostel Supervisor', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(22, 9, 'Shift Supervisor', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(23, 9, 'Site Supervisor', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(24, 10, 'Administration Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(25, 10, 'General Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(26, 10, 'HR Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(27, 10, 'Inventory Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(28, 10, 'Marketing Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(29, 10, 'Showroom Manager', '2019-12-08 02:09:54', '2019-12-08 02:09:54'),
(30, 1, 'Mechanic', '2019-12-12 03:11:31', '2019-12-12 03:11:31'),
(31, 8, 'ECE', '2019-12-12 03:15:11', '2019-12-12 03:15:11'),
(32, 12, 'Area Sales Manager', '2020-01-02 11:49:58', '2020-01-02 11:49:58'),
(33, 6, 'Mechanical', '2020-03-11 13:59:22', '2020-03-11 13:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `vacancy`
--

CREATE TABLE `vacancy` (
  `id` int(10) NOT NULL,
  `employer` int(10) NOT NULL,
  `category` int(10) NOT NULL,
  `sub_category` int(10) NOT NULL,
  `experience` varchar(100) NOT NULL,
  `qualification` varchar(150) NOT NULL,
  `job_title` varchar(50) NOT NULL,
  `vacancy` varchar(100) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `expiry` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vacancy`
--

INSERT INTO `vacancy` (`id`, `employer`, `category`, `sub_category`, `experience`, `qualification`, `job_title`, `vacancy`, `salary`, `expiry`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '10+', '', '', '5', '', '2020-01-03', '5', '2019-12-09 02:30:41', '2019-12-10 03:42:30'),
(2, 1, 2, 6, '3-5', '', '', '8', '', '2020-01-22', '', '2019-12-09 02:30:41', '2019-12-10 01:42:25'),
(4, 2, 1, 2, 'Fresher', '', '', '3', '', '2019-12-11', '', '2019-12-10 02:49:50', '2019-12-10 02:49:50'),
(6, 2, 1, 1, '1-3', 'bsc cs', '', '9', '', '2020-01-31', '', '2019-12-21 02:02:21', '2019-12-21 02:02:21'),
(7, 2, 7, 17, 'Fresher', 'MBA', '', '1', '', '2020-01-05', '', '2020-01-02 11:00:11', '2020-01-02 11:00:11'),
(8, 3, 6, 14, 'Fresher', 'BE ', '', '1', '', '2020-01-07', '', '2020-01-02 11:47:25', '2020-01-02 11:47:25'),
(9, 3, 2, 5, 'Fresher', 'asd', '', '23', '', '2020-01-08', 'dfsfsd', '2020-01-02 11:57:08', '2020-01-02 11:57:08'),
(11, 2, 2, 5, 'Fresher', 'Hsk', '', '46', '', '2020-01-23', 'Shjr', '2020-01-04 15:44:04', '2020-01-04 15:44:04'),
(12, 5, 7, 17, '3-5', 'MBA', '', '2', '', '2020-03-31', 'HR and Liasons', '2020-03-11 13:30:59', '2020-03-11 13:30:59'),
(13, 5, 6, 16, '3-5', 'Diploma', '', '3', '', '2020-03-31', 'Water Treatmment field', '2020-03-11 13:34:19', '2020-03-11 13:34:19'),
(14, 6, 1, 1, 'Fresher', 'MBA', 'h1', '1', 'Rs.100000 - Rs.150000', '2020-06-14', 'test', '2020-06-09 08:27:26', '2020-06-09 08:45:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subcategory_category` (`category_id`);

--
-- Indexes for table `vacancy`
--
ALTER TABLE `vacancy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_id_category` (`category`),
  ADD KEY `fk_sub_category_id_fk_subcategory_category` (`sub_category`),
  ADD KEY `fk_employer_id_employer` (`employer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `vacancy`
--
ALTER TABLE `vacancy`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `fk_subcategory_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vacancy`
--
ALTER TABLE `vacancy`
  ADD CONSTRAINT `fk_category_id_category` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_employer_id_employer` FOREIGN KEY (`employer`) REFERENCES `employer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sub_category_id_fk_subcategory_category` FOREIGN KEY (`sub_category`) REFERENCES `subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
