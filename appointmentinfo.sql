-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 06:30 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vizika`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointmentinfo`
--

CREATE TABLE `appointmentinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staffID` bigint(20) NOT NULL,
  `contVisitID` bigint(20) NOT NULL,
  `appointmentPurpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointmentAgenda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointmentDate` date NOT NULL,
  `appointmentTime` time NOT NULL,
  `appointmentStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointmentinfo`
--

INSERT INTO `appointmentinfo` (`id`, `staffID`, `contVisitID`, `appointmentPurpose`, `appointmentAgenda`, `appointmentDate`, `appointmentTime`, `appointmentStatus`, `created_at`, `updated_at`) VALUES
(1, 6, 10, 'Audit', 'Audit ', '2023-05-12', '15:49:35', 'Attend', NULL, NULL),
(2, 23, 20, 'Meeting', 'Launch new product', '2023-05-22', '10:00:00', 'Attend', NULL, NULL),
(3, 23, 8, 'Meeting', 'Launch new product', '2023-05-19', '10:00:00', 'Attend', NULL, NULL),
(4, 23, 18, 'Meeting', 'Discussion project', '2023-05-18', '12:30:00', 'Attend', NULL, NULL),
(5, 6, 21, 'Meeting', 'Discussion', '2023-05-18', '15:00:00', 'Attend', NULL, NULL),
(6, 23, 22, 'Meeting', 'Discussion', '2023-05-25', '15:00:00', 'Attend', NULL, NULL),
(7, 6, 20, 'Meeting', 'Discussion', '2023-05-31', '15:00:00', 'Attend', NULL, NULL),
(8, 6, 19, 'Meeting', 'Discussion', '2023-05-30', '15:00:00', 'Attend', NULL, NULL),
(9, 23, 18, 'Meeting', 'Discussion', '2023-05-03', '15:00:00', 'Attend', NULL, NULL),
(10, 6, 20, 'Meeting', 'Discussion', '2023-05-25', '15:00:00', 'Attend', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointmentinfo`
--
ALTER TABLE `appointmentinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointmentinfo`
--
ALTER TABLE `appointmentinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
