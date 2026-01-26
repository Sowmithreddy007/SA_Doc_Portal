-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 05:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doc_portal`
--
CREATE DATABASE IF NOT EXISTS `doc_portal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `doc_portal`;

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `letter_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `letter_id`, `action`, `user_id`, `details`, `created_at`) VALUES
(1, 1, 'created', NULL, NULL, '2026-01-16 16:09:26'),
(2, 2, 'created', NULL, NULL, '2026-01-16 16:23:51'),
(3, 3, 'created', NULL, NULL, '2026-01-16 17:19:53'),
(4, 4, 'created', NULL, NULL, '2026-01-16 17:37:22'),
(5, 5, 'created', NULL, NULL, '2026-01-18 12:15:56'),
(6, 6, 'created', NULL, NULL, '2026-01-18 12:25:50'),
(7, 7, 'created', NULL, NULL, '2026-01-18 12:33:51'),
(8, 8, 'created', NULL, NULL, '2026-01-18 12:41:47'),
(9, 9, 'created', NULL, NULL, '2026-01-18 13:14:57'),
(10, 10, 'created', NULL, NULL, '2026-01-18 13:23:27'),
(11, 11, 'created', NULL, NULL, '2026-01-18 14:32:56'),
(12, 12, 'created', NULL, NULL, '2026-01-18 15:04:24'),
(13, 13, 'created', NULL, NULL, '2026-01-18 15:06:53'),
(14, 14, 'created', NULL, NULL, '2026-01-19 04:14:37'),
(15, 15, 'created', NULL, NULL, '2026-01-19 04:25:05'),
(16, 16, 'created', NULL, NULL, '2026-01-19 04:33:39'),
(17, 17, 'created', NULL, NULL, '2026-01-19 07:28:07'),
(18, 18, 'created', NULL, NULL, '2026-01-19 08:48:48'),
(19, 19, 'created', NULL, NULL, '2026-01-19 11:19:04'),
(20, 20, 'created', NULL, NULL, '2026-01-19 11:37:10'),
(21, 21, 'created', NULL, NULL, '2026-01-20 13:35:44'),
(22, 22, 'created', NULL, NULL, '2026-01-20 14:36:01'),
(23, 23, 'created', NULL, NULL, '2026-01-20 14:45:12'),
(24, 24, 'created', NULL, NULL, '2026-01-20 14:46:32'),
(25, 25, 'created', NULL, NULL, '2026-01-20 14:47:35'),
(26, 26, 'created', NULL, NULL, '2026-01-21 05:59:12'),
(27, 27, 'created', NULL, NULL, '2026-01-21 05:59:52'),
(28, 28, 'created', NULL, NULL, '2026-01-21 06:01:16'),
(29, 29, 'created', NULL, NULL, '2026-01-21 06:23:15'),
(30, 30, 'created', NULL, NULL, '2026-01-21 14:57:25'),
(31, 31, 'created', NULL, NULL, '2026-01-21 15:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `letters`
--

CREATE TABLE `letters` (
  `id` int(11) NOT NULL,
  `cand_id` varchar(50) NOT NULL,
  `roll_no` varchar(50) NOT NULL,
  `letter_type_id` int(11) NOT NULL,
  `data_json` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `letters`
--

INSERT INTO `letters` (`id`, `cand_id`, `roll_no`, `letter_type_id`, `data_json`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '', '22bk1a72a5', 1, '{\"present_date\":\"2026-01-16\",\"name\":\"Akshitha\",\"position\":\"em\",\"start_date\":\"2026-01-11\",\"end_date\":\"2026-01-31\",\"contributions\":\"test\",\"signatory_name\":\"akshitha\",\"signatory_title\":\"presedent\"}', NULL, '2026-01-16 16:09:26', NULL),
(2, '', '22bk1a72a5', 1, '{\"present_date\":\"2026-01-16\",\"name\":\"Akshitha\",\"position\":\"em\",\"start_date\":\"2026-01-16\",\"end_date\":\"2026-01-31\",\"contributions\":\"test\",\"signatory_name\":\"akshitha\",\"signatory_title\":\"presedent\"}', NULL, '2026-01-16 16:23:51', NULL),
(3, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-16\",\"name\":\"Akshitha\",\"position\":\"em\",\"start_date\":\"2026-01-16\",\"duration\":\"sdfg\",\"signatory_name\":\"sdfg\",\"signatory_title\":\"sdfg\"}', NULL, '2026-01-16 17:19:53', NULL),
(4, '', '22bk1a72a5', 4, '{\"present_date\":\"2026-01-16\",\"name\":\"Akshitha\",\"previous_position\":\"em\",\"present_position\":\"presedent\",\"start_date\":\"2026-01-16\",\"years_served\":\"7\",\"last_working_day\":\"2026-01-17\",\"signatory_name\":\"akshitha\",\"signatory_title\":\"presedent\"}', NULL, '2026-01-16 17:37:22', NULL),
(5, '', '22bk1a72a5', 1, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"em\",\"start_date\":\"2026-01-19\",\"end_date\":\"2026-01-19\",\"contributions\":\"test\\r\\n\",\"signatory_name\":\"akshitha\",\"signatory_title\":\"presedent\"}', NULL, '2026-01-18 12:15:56', NULL),
(6, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"asd\",\"start_date\":\"2026-01-19\",\"duration\":\"sdfg\",\"signatory_name\":\"asdasdf\",\"signatory_title\":\"ad\"}', NULL, '2026-01-18 12:25:50', NULL),
(7, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"asxdf\",\"start_date\":\"2026-01-19\",\"duration\":\"sd\",\"signatory_name\":\"asd\",\"signatory_title\":\"zxcvbnm,\"}', NULL, '2026-01-18 12:33:51', NULL),
(8, '', '22bk1a72a5', 3, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"ghjkl\",\"start_date\":\"2026-01-19\",\"custom_body\":\"sdfghj\",\"signatory_name\":\"fgbhnm,\",\"signatory_title\":\"ghjk\"}', NULL, '2026-01-18 12:41:47', NULL),
(9, '', '22bk1a72a5', 1, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"zsad\",\"start_date\":\"2026-01-19\",\"end_date\":\"2026-01-18\",\"contributions\":\"wert\\r\\n\",\"signatory_name\":\"ghjk\",\"signatory_title\":\"serg\"}', NULL, '2026-01-18 13:14:57', NULL),
(10, '', '22bk1a72a5', 1, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"end_date\":\"2026-01-18\",\"contributions\":\"test\\r\\n\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-18 13:23:27', NULL),
(11, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"duration\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-18 14:32:56', NULL),
(12, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"duration\":\"sdfg\",\"signatory_name\":\"asd\",\"signatory_title\":\"ghjk\"}', NULL, '2026-01-18 15:04:24', NULL),
(13, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-18\",\"name\":\"Akshitha\",\"position\":\"sdf\",\"start_date\":\"2026-01-19\",\"duration\":\"xcvbn\",\"signatory_name\":\"fghj\",\"signatory_title\":\"fghj\"}', NULL, '2026-01-18 15:06:53', NULL),
(14, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-19\",\"name\":\"Akshitha\",\"position\":\"dfghjk\",\"start_date\":\"2026-01-19\",\"duration\":\"ghjkl\",\"signatory_name\":\"hgjhjkl\",\"signatory_title\":\"fghj\"}', NULL, '2026-01-19 04:14:37', NULL),
(15, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-19\",\"name\":\"Akshitha\",\"position\":\"dfghjk\",\"start_date\":\"2026-01-19\",\"duration\":\"ghjkl\",\"signatory_name\":\"hgjhjkl\",\"signatory_title\":\"fghj\"}', NULL, '2026-01-19 04:25:05', NULL),
(16, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-19\",\"name\":\"Akshitha\",\"position\":\"asd\",\"start_date\":\"2026-01-19\",\"duration\":\"sdv\",\"signatory_name\":\"sdf\",\"signatory_title\":\"sd\"}', NULL, '2026-01-19 04:33:39', NULL),
(17, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-19\",\"name\":\"Akshitha\",\"position\":\"em\",\"start_date\":\"2026-01-19\",\"duration\":\"asd\",\"signatory_name\":\"asdf\",\"signatory_title\":\"asdf\"}', NULL, '2026-01-19 07:28:07', NULL),
(18, '', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-19\",\"name\":\"Akshitha\",\"position\":\"em\",\"start_date\":\"2026-01-19\",\"duration\":\"asd\",\"signatory_name\":\"asdf\",\"signatory_title\":\"asdf\"}', NULL, '2026-01-19 08:48:48', NULL),
(19, '', '22bk1a72a5', 1, '{\"present_date\":\"2026-01-19\",\"name\":\"Akshitha\",\"position\":\"vbbbbbbbbbnnnnnn\",\"start_date\":\"2026-01-19\",\"end_date\":\"2026-01-19\",\"contributions\":\"fghj\",\"signatory_name\":\"m,\",\"signatory_title\":\"m,\"}', NULL, '2026-01-19 11:19:04', NULL),
(20, 'sa02', '22bk1a72a6', 2, '{\"present_date\":\"2026-01-19\",\"name\":\"test\",\"position\":\"wef\",\"start_date\":\"\",\"duration\":\"wersfe\",\"signatory_name\":\"sedd\",\"signatory_title\":\"er\"}', NULL, '2026-01-19 11:37:10', NULL),
(21, 'sa02', '22bk1a72a6', 1, '{\"present_date\":\"2026-01-20\",\"name\":\"test\",\"position\":\"test\",\"start_date\":\"\",\"end_date\":\"2026-01-21\",\"contributions\":\"test\",\"signatory_name\":\"akshitha\",\"signatory_title\":\"test\"}', NULL, '2026-01-20 13:35:44', NULL),
(22, 'sa02', '22bk1a72a6', 3, '{\"present_date\":\"2026-01-21\",\"name\":\"test\",\"position\":\"test\",\"start_date\":\"\",\"custom_body\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-20 14:36:01', NULL),
(23, 'sa02', '22bk1a72a6', 3, '{\"present_date\":\"2026-01-21\",\"name\":\"test\",\"position\":\"test\",\"start_date\":\"\",\"custom_body\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-20 14:45:12', NULL),
(24, 'sa02', '22bk1a72a6', 3, '{\"present_date\":\"2026-01-21\",\"name\":\"test\",\"position\":\"test\",\"start_date\":\"\",\"custom_body\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-20 14:46:32', NULL),
(25, 'sa02', '22bk1a72a6', 3, '{\"present_date\":\"2026-01-21\",\"name\":\"test\",\"position\":\"test\",\"start_date\":\"\",\"custom_body\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-20 14:47:35', NULL),
(26, 'sa01', '22bk1a72a5', 3, '{\"present_date\":\"2026-01-21\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"custom_body\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-21 05:59:12', NULL),
(27, 'sa01', '22bk1a72a5', 3, '{\"present_date\":\"2026-01-21\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"custom_body\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-21 05:59:51', NULL),
(28, 'sa01', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-16\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"duration\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-21 06:01:16', NULL),
(29, 'sa02', '22bk1a72a6', 2, '{\"present_date\":\"2026-01-22\",\"name\":\"test\",\"position\":\"test\",\"start_date\":\"\",\"duration\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-21 06:23:15', NULL),
(30, 'sa01', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-21\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"duration\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-21 14:57:25', NULL),
(31, 'sa01', '22bk1a72a5', 2, '{\"present_date\":\"2026-01-22\",\"name\":\"Akshitha\",\"position\":\"test\",\"start_date\":\"2026-01-19\",\"duration\":\"test\",\"signatory_name\":\"test\",\"signatory_title\":\"test\"}', NULL, '2026-01-21 15:49:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `letter_types`
--

CREATE TABLE `letter_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `fields_json` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `letter_types`
--

INSERT INTO `letter_types` (`id`, `name`, `slug`, `fields_json`, `created_at`) VALUES
(1, 'Release / Notice of Term Completion & Release', 'release', '[{\"name\":\"present_date\",\"label\":\"Present Date\",\"type\":\"date\",\"required\":true},{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"required\":true},{\"name\":\"position\",\"label\":\"Position\",\"type\":\"text\",\"required\":true},{\"name\":\"start_date\",\"label\":\"Start Date\",\"type\":\"date\",\"required\":true},{\"name\":\"end_date\",\"label\":\"End Date\",\"type\":\"date\",\"required\":true},{\"name\":\"contributions\",\"label\":\"Contributions (one per line)\",\"type\":\"textarea\",\"required\":false},{\"name\":\"signatory_name\",\"label\":\"Signatory Name\",\"type\":\"text\",\"required\":false},{\"name\":\"signatory_title\",\"label\":\"Signatory Title\",\"type\":\"text\",\"required\":false}]', '2026-01-16 16:03:57'),
(2, 'Appointment', 'appointment', '[{\"name\":\"present_date\",\"label\":\"Present Date\",\"type\":\"date\",\"required\":true},{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"required\":true},{\"name\":\"position\",\"label\":\"Position\",\"type\":\"text\",\"required\":true},{\"name\":\"start_date\",\"label\":\"Start Date\",\"type\":\"date\",\"required\":true},{\"name\":\"duration\",\"label\":\"Duration\",\"type\":\"text\",\"required\":false},{\"name\":\"signatory_name\",\"label\":\"Signatory Name\",\"type\":\"text\",\"required\":false},{\"name\":\"signatory_title\",\"label\":\"Signatory Title\",\"type\":\"text\",\"required\":false}]', '2026-01-16 16:03:57'),
(3, 'LOR', 'lor', '[{\"name\":\"present_date\",\"label\":\"Present Date\",\"type\":\"date\",\"required\":true},{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"required\":true},{\"name\":\"position\",\"label\":\"Position\",\"type\":\"text\",\"required\":true},{\"name\":\"start_date\",\"label\":\"Start Date\",\"type\":\"date\",\"required\":true},{\"name\":\"custom_body\",\"label\":\"Recommendation Text\",\"type\":\"textarea\",\"required\":true},{\"name\":\"signatory_name\",\"label\":\"Signatory Name\",\"type\":\"text\",\"required\":false},{\"name\":\"signatory_title\",\"label\":\"Signatory Title\",\"type\":\"text\",\"required\":false}]', '2026-01-16 16:03:57'),
(4, 'Promotion', 'promotion', '[{\"name\":\"present_date\",\"label\":\"Present Date\",\"type\":\"date\",\"required\":true},{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"required\":true},{\"name\":\"previous_position\",\"label\":\"Previous Position\",\"type\":\"text\",\"required\":true},{\"name\":\"present_position\",\"label\":\"Present Position\",\"type\":\"text\",\"required\":true},{\"name\":\"start_date\",\"label\":\"Start Date\",\"type\":\"date\",\"required\":true},{\"name\":\"years_served\",\"label\":\"Years Served\",\"type\":\"number\",\"required\":true},{\"name\":\"last_working_day\",\"label\":\"Last Working Day\",\"type\":\"date\",\"required\":true},{\"name\":\"signatory_name\",\"label\":\"Signatory Name\",\"type\":\"text\",\"required\":false},{\"name\":\"signatory_title\",\"label\":\"Signatory Title\",\"type\":\"text\",\"required\":false}]', '2026-01-16 16:03:57'),
(5, 'Termination', 'termination', '[{\"name\":\"present_date\",\"label\":\"Present Date\",\"type\":\"date\",\"required\":true},{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"required\":true},{\"name\":\"remarks\",\"label\":\"Remarks/Reason\",\"type\":\"textarea\",\"required\":true},{\"name\":\"signatory_name\",\"label\":\"Signatory Name\",\"type\":\"text\",\"required\":false},{\"name\":\"signatory_title\",\"label\":\"Signatory Title\",\"type\":\"text\",\"required\":false}]', '2026-01-16 16:03:57'),
(6, 'Undertaking (1st year)', 'undertaking', '[{\"name\":\"present_date\",\"label\":\"Present Date\",\"type\":\"date\",\"required\":true},{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"required\":true},{\"name\":\"position\",\"label\":\"Position\",\"type\":\"text\",\"required\":true},{\"name\":\"remarks\",\"label\":\"Remarks\",\"type\":\"textarea\",\"required\":true},{\"name\":\"duration\",\"label\":\"Duration\",\"type\":\"text\",\"required\":true},{\"name\":\"signatory_name\",\"label\":\"Signatory Name\",\"type\":\"text\",\"required\":false},{\"name\":\"signatory_title\",\"label\":\"Signatory Title\",\"type\":\"text\",\"required\":false}]', '2026-01-16 16:03:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `display_name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `display_name`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', '2026-01-16 16:03:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_kyc`
--

CREATE TABLE `user_kyc` (
  `id` int(11) NOT NULL,
  `cand_id` varchar(50) NOT NULL,
  `roll_no` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `additional_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_kyc`
--

INSERT INTO `user_kyc` (`id`, `cand_id`, `roll_no`, `name`, `email`, `phone`, `position`, `department`, `date_of_joining`, `date_of_birth`, `address`, `city`, `state`, `pincode`, `qualification`, `designation`, `additional_data`, `created_at`, `updated_at`) VALUES
(1, 'sa01', '22bk1a72a5', 'Akshitha', '', '', '', '', '2026-01-19', '2026-01-01', '', '', '', '', '', '', NULL, '2026-01-19 09:16:31', NULL),
(2, 'sa02', '22bk1a72a6', 'test', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', NULL, '2026-01-19 11:24:06', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `letters`
--
ALTER TABLE `letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `letter_type_id` (`letter_type_id`);

--
-- Indexes for table `letter_types`
--
ALTER TABLE `letter_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_kyc`
--
ALTER TABLE `user_kyc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cand_id` (`cand_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `letters`
--
ALTER TABLE `letters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `letter_types`
--
ALTER TABLE `letter_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_kyc`
--
ALTER TABLE `user_kyc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `letters`
--
ALTER TABLE `letters`
  ADD CONSTRAINT `letters_ibfk_1` FOREIGN KEY (`letter_type_id`) REFERENCES `letter_types` (`id`) ON DELETE CASCADE;
--

