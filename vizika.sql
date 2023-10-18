-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 06:09 AM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u826812296_vizika`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointmentinfo`
--

CREATE TABLE `appointmentinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staffID` bigint(20) NOT NULL,
  `contVisitID` bigint(20) NOT NULL,
  `appointmentPurpose` varchar(255) NOT NULL,
  `appointmentAgenda` varchar(255) NOT NULL,
  `appointmentDateStart` date NOT NULL,
  `appointmentDateEnd` date NOT NULL,
  `appointmentTime` time NOT NULL,
  `bringVehicle` varchar(255) NOT NULL,
  `bringLaptop` varchar(255) NOT NULL,
  `appointmentStatus` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointmentinfo`
--

INSERT INTO `appointmentinfo` (`id`, `staffID`, `contVisitID`, `appointmentPurpose`, `appointmentAgenda`, `appointmentDateStart`, `appointmentDateEnd`, `appointmentTime`, `bringVehicle`, `bringLaptop`, `appointmentStatus`, `created_at`, `updated_at`) VALUES
(1, 1, 22, 'Meeting', 'Repair machine A', '2023-09-25', '2023-09-27', '14:00:00', 'Yes', 'Yes', 'Attend', '2023-07-16 23:04:31', '2023-07-16 23:23:47'),
(2, 1, 2, 'Meeting', 'Meeting about project KANEKA website', '2023-08-09', '2023-08-10', '14:00:00', 'Yes', 'Yes', 'Attend', '2023-07-20 05:20:35', '2023-07-20 05:21:20'),
(5, 1, 2, 'Meeting', 'Meeting about project ', '2023-08-10', '2023-08-11', '15:00:00', 'No', 'No', 'Attend', NULL, NULL),
(6, 1, 2, 'Meeting', 'Meeting about project ', '2023-08-10', '2023-08-10', '14:00:00', 'No', 'No', 'Attend', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `biometricinfo`
--

CREATE TABLE `biometricinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `facialRecognition` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `biometricinfo`
--

INSERT INTO `biometricinfo` (`id`, `userID`, `facialRecognition`, `created_at`, `updated_at`) VALUES
(2, 2, '64b818c6d7392.jpg', '2023-07-19 17:09:26', '2023-07-19 17:09:26'),
(9, 22, '64f5df4b5e5b1.jpg', '2023-09-04 13:44:43', '2023-09-04 13:44:43'),
(12, 26, '6507e4cc6fe7b.jpg', '2023-09-18 05:49:00', '2023-09-18 05:49:00'),
(15, 32, '651976d6b9966.jpg', '2023-10-01 13:37:57', '2023-10-01 13:37:57'),
(16, 33, '6519781827470.jpg', '2023-10-01 13:46:00', '2023-10-01 13:46:00'),
(17, 34, '651cd11dc7b56.jpg', '2023-10-04 02:42:37', '2023-10-04 02:42:37'),
(18, 34, '651cd11dc7b8f.jpg', '2023-10-04 02:42:37', '2023-10-04 02:42:37'),
(19, 35, '652f5f4375d0e.jpg', '2023-10-18 04:29:55', '2023-10-18 04:29:55');

-- --------------------------------------------------------

--
-- Table structure for table `blacklistvisitor`
--

CREATE TABLE `blacklistvisitor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `blacklistReason` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `briefingsession`
--

CREATE TABLE `briefingsession` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `briefingID` bigint(20) NOT NULL,
  `contractorID` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `briefingsession`
--

INSERT INTO `briefingsession` (`id`, `briefingID`, `contractorID`, `created_at`, `updated_at`) VALUES
(15, 42, 26, NULL, NULL),
(18, 41, 32, NULL, NULL),
(19, 40, 33, NULL, NULL),
(20, 44, 34, NULL, NULL),
(21, 44, 35, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companyinfo`
--

CREATE TABLE `companyinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `staffID` int(11) NOT NULL,
  `mngtPICName` varchar(255) NOT NULL,
  `mngtPICEmail` varchar(255) NOT NULL,
  `safetyPICName` varchar(255) NOT NULL,
  `safetyPICEmail` varchar(255) NOT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `companyEmail` varchar(255) DEFAULT NULL,
  `companyPhoneNo` varchar(255) DEFAULT NULL,
  `companyAddress` varchar(255) DEFAULT NULL,
  `companyIndustries` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companyinfo`
--

INSERT INTO `companyinfo` (`id`, `userID`, `staffID`, `mngtPICName`, `mngtPICEmail`, `safetyPICName`, `safetyPICEmail`, `companyName`, `companyEmail`, `companyPhoneNo`, `companyAddress`, `companyIndustries`, `created_at`, `updated_at`) VALUES
(1, 30, 1, 'Ahmad', 'ahmad@gmail.com', 'Aminah', 'aminah@gmail.com', 'Universiti Malaysia Pahang', 'ump@ump.edu.my', '0123456789', 'Pekan, Pahang', 'Engineering', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contractName` varchar(255) NOT NULL,
  `contractStartDate` date NOT NULL,
  `contractEndDate` date NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `contractorID` bigint(20) NOT NULL,
  `staffID` bigint(20) NOT NULL,
  `contractAmount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`id`, `contractName`, `contractStartDate`, `contractEndDate`, `companyID`, `contractorID`, `staffID`, `contractAmount`, `created_at`, `updated_at`) VALUES
(3, 'Contract with Plant A', '2022-10-09', '2023-10-09', 2, 6, 1, 20, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contractorinfo`
--

CREATE TABLE `contractorinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `employeeNo` varchar(255) NOT NULL,
  `phoneNo` varchar(255) NOT NULL,
  `passExpiryDate` date DEFAULT NULL,
  `passStatus` varchar(255) DEFAULT NULL,
  `birthDate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `validityPassPhoto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractorinfo`
--

INSERT INTO `contractorinfo` (`id`, `userID`, `companyID`, `employeeNo`, `phoneNo`, `passExpiryDate`, `passStatus`, `birthDate`, `address`, `validityPassPhoto`, `created_at`, `updated_at`) VALUES
(10, 26, 1, '01395', '0122840027', '2024-03-18', NULL, '1983-11-05', 'no 37 lorong bukit setongkol. kuantan', NULL, NULL, '2023-09-18 06:33:32'),
(13, 32, 1, 'AM2357385234', '0195785840', NULL, NULL, '2000-06-14', 'Tanjung Malim, Perak', NULL, NULL, NULL),
(14, 33, 1, 'AM2357385234', '0123456789', NULL, NULL, '2000-04-15', 'Bera, Pahang', NULL, NULL, NULL),
(15, 34, 1, '1234', '0122840027', NULL, NULL, '2022-07-05', 'No 37 Lorong Bukit Setongkol 13 \r\nTaman Cenderawasih Indah', NULL, NULL, NULL),
(16, 35, 1, '123', '0122840027', NULL, NULL, '1983-08-18', 'Pekan Pahang', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laptopinfo`
--

CREATE TABLE `laptopinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointmentID` bigint(20) NOT NULL,
  `laptopBrand` varchar(255) NOT NULL,
  `laptopModel` varchar(255) NOT NULL,
  `laptopColor` varchar(255) NOT NULL,
  `laptopSerialNo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laptopinfo`
--

INSERT INTO `laptopinfo` (`id`, `appointmentID`, `laptopBrand`, `laptopModel`, `laptopColor`, `laptopSerialNo`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Huawei', 'Matebook D', 'Silver', '3234235', 'Approved', NULL, '2023-07-16 23:39:14'),
(2, 2, 'Huawei', 'Matebook D', 'Silver', '3234235', 'Rejected', NULL, '2023-07-20 05:22:43'),
(3, 4, 'acer', 'xxxx123', 'black', '123123abc', 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(144, '2014_10_12_000000_create_users_table', 1),
(145, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(146, '2014_10_12_100000_create_password_resets_table', 1),
(147, '2019_08_19_000000_create_failed_jobs_table', 1),
(148, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(149, '2023_03_24_134814_create_contractorinfo_table', 1),
(150, '2023_03_26_033852_create_appointmentinfo_table', 1),
(151, '2023_03_29_133443_create_visitorinfo_table', 1),
(152, '2023_03_29_161140_create_blacklistvisitor_table', 1),
(153, '2023_03_29_162020_create_briefingsession_table', 1),
(154, '2023_03_29_163029_create_safetybriefinginfo_table', 1),
(155, '2023_03_29_163506_create_visitrecord_table', 1),
(156, '2023_03_31_072517_create_companyinfo_table', 1),
(157, '2023_05_31_161858_create_biometricinfo_table', 1),
(158, '2023_07_09_145916_create_laptopinfo_table', 1),
(159, '2023_07_13_153223_create_vehicleinfo_table', 1),
(160, '2023_07_17_154955_create_visitorqrscan_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `safetybriefinginfo`
--

CREATE TABLE `safetybriefinginfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `briefingDate` date NOT NULL,
  `briefingTimeStart` time NOT NULL,
  `briefingTimeEnd` time NOT NULL,
  `maxParticipant` bigint(20) NOT NULL,
  `briefingStatus` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `safetybriefinginfo`
--

INSERT INTO `safetybriefinginfo` (`id`, `briefingDate`, `briefingTimeStart`, `briefingTimeEnd`, `maxParticipant`, `briefingStatus`, `created_at`, `updated_at`) VALUES
(1, '2023-09-25', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(2, '2023-09-25', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(3, '2023-09-26', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(4, '2023-09-26', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(5, '2023-09-27', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(6, '2023-09-27', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(7, '2023-09-28', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(8, '2023-09-28', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(9, '2023-09-29', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(10, '2023-09-29', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(11, '2023-10-02', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(12, '2023-10-02', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(13, '2023-10-03', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(14, '2023-10-03', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(15, '2023-10-04', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(16, '2023-10-04', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(17, '2023-10-05', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(18, '2023-10-05', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(19, '2023-10-06', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(20, '2023-10-06', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(21, '2023-10-09', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(22, '2023-10-09', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(23, '2023-10-10', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(24, '2023-10-10', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(25, '2023-10-11', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(26, '2023-10-11', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(27, '2023-10-12', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(28, '2023-10-12', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(29, '2023-10-13', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(30, '2023-10-13', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(31, '2023-10-16', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(32, '2023-10-16', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(33, '2023-10-17', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(34, '2023-10-17', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(35, '2023-10-18', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(36, '2023-10-18', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(37, '2023-10-19', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(38, '2023-10-19', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(39, '2023-10-20', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(40, '2023-10-20', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(41, '2023-10-23', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(42, '2023-10-23', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(43, '2023-10-24', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(44, '2023-10-24', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visitDate` date NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `vehicleRegNo` varchar(255) NOT NULL,
  `contractorID` varchar(255) NOT NULL,
  `noIC` varchar(255) NOT NULL,
  `plant` varchar(255) NOT NULL,
  `passNo` varchar(255) NOT NULL,
  `checkInTime` time NOT NULL,
  `checkOutTime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transportinspection`
--

CREATE TABLE `transportinspection` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `visitDate` date NOT NULL,
  `vehicleRegNo` varchar(255) NOT NULL,
  `primeMoverInside` varchar(255) NOT NULL,
  `primeMoverBack` varchar(255) NOT NULL,
  `trailerUnder` varchar(255) NOT NULL,
  `trailerBehind` varchar(255) NOT NULL,
  `trailerLeft` varchar(255) NOT NULL,
  `trailerRight` varchar(255) NOT NULL,
  `security` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transportinspection`
--

INSERT INTO `transportinspection` (`id`, `companyID`, `visitDate`, `vehicleRegNo`, `primeMoverInside`, `primeMoverBack`, `trailerUnder`, `trailerBehind`, `trailerLeft`, `trailerRight`, `security`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-08-01', 'ABC123', 'on', 'on', '0', 'on', '0', 'on', 'No', NULL, NULL),
(2, 2, '2023-08-01', 'VKF546', 'on', 'on', 'on', 'on', 'on', 'on', 'All good', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userchangerequests`
--

CREATE TABLE `userchangerequests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `original_value` varchar(255) NOT NULL,
  `field_changed` varchar(255) NOT NULL,
  `new_value` varchar(255) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `requestStatus` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userchangerequests`
--

INSERT INTO `userchangerequests` (`id`, `userID`, `original_value`, `field_changed`, `new_value`, `request_date`, `requestStatus`, `created_at`, `updated_at`) VALUES
(1, 25, '0123456789', 'phoneNo', '0195785840', '2023-09-14 09:08:59', 'Approved', '2023-09-14 09:08:59', '2023-09-14 09:08:59'),
(2, 25, 'Proton City', 'address', 'Tanjung Malim, Perak', '2023-09-14 09:08:59', 'Pending', '2023-09-14 09:08:59', '2023-09-14 09:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icNo` varchar(255) DEFAULT NULL,
  `companyRegNo` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `companyID` bigint(20) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `icNo`, `companyRegNo`, `name`, `email`, `email_verified_at`, `password`, `category`, `status`, `companyID`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Nurain Aleeya', 'nurainaleeyacz@gmail.com', NULL, '$2y$10$qv7cTmodwkPs801UpgawCez8Pmt4o9BoiaD3TEaZxAs2xBpyJrtmm', 'Staff', 'Active', NULL, 'rq9TAtxPlSzbpvlpQSS0VSRqcNOS7TNn6g0rR4oFVxkstUthNc0SFvHsTchx', '2023-07-16 22:24:19', '2023-07-16 22:24:19'),
(2, NULL, NULL, 'Farra Alia', 'farraalia280@gmail.com', NULL, '$2y$10$WSFwiTaybg2o4TmWiSRr5.VujMqHFtg/FQXxKJLoAy2zYQNQP80mW', 'Visitor', 'Active', 1, 'cjIqcpdMe1wiOFiR9NvB2TTiVw5OPiA2stJrTBGRPtalECwvIJweAJIj08qk', NULL, '2023-07-17 09:03:32'),
(3, NULL, NULL, 'Nurin Azyyati', 'theocloud1479@gmail.com', NULL, '$2y$10$5hKtl5ewifIZiyDzD6D.fOHjPCxtvR9ps9wlRZJxltHPyRW2VKAle', 'SHEQ Officer', 'Active', NULL, 'FqXRj9f9cbjA7UC5m5LBKNUyPn591nC6HooATzUhYb96gvTI0UChOLB3BI8u', '2023-07-16 22:34:01', '2023-07-16 22:34:01'),
(4, NULL, NULL, 'Maisarah Faisal', 'maisarahfaisal75@gmail.com', NULL, '$2y$10$kQi48NoJiWxZCTlrxggkHeP.s239m4efJLlMDGL/EJpjwp0Y84kxG', 'SHEQ Guard', 'Active', NULL, 'HzAuxXJJZr0lhs0sYa8i9jEtjLnToAbPM9SoJuNaDRuq5PdDtrraQttOeRCG', '2023-07-16 23:41:15', '2023-07-16 23:41:15'),
(5, NULL, NULL, 'Farhan Firdaus', 'farhanfirdaus@gmail.com', NULL, '$2y$10$bq1fbVE17YTlXb6ascsFkOz3MYqc4rmRyegTRhJzR0e4T6EJW9TaC', 'Contractor', 'Active', 1, NULL, NULL, '2023-08-17 01:14:57'),
(7, NULL, NULL, 'Ghadafi Ismail', 'ghadafi.ismail@kaneka.com.my', NULL, '$2y$10$TTAlCNHDEWKKtlsq7NwOC.lmUVGkNA2esAuiLPPJaU0ADMVbJWNXS', 'Staff', 'Active', NULL, NULL, '2023-07-20 02:21:26', '2023-07-20 02:21:26'),
(8, NULL, NULL, 'Azri Misdar', 'azri.misdar@kaneka.com.my', NULL, '$2y$10$hnDj5yiw8GLRzR2ON0EzQu/XZHsa3.zrs40.7XQVnS.4VtiPRujF.', 'Staff', 'Active', NULL, NULL, '2023-07-20 02:22:17', '2023-07-20 02:22:17'),
(9, NULL, NULL, 'Ahmad Mohdrudin', 'ahmad.mohdrudin@kaneka.com.my', NULL, '$2y$10$eYWG1vhKuFbDrRY5I5ms..J1EMU.0MCOnSBnfr5vzbGhkIQr18Hie', 'Staff', 'Active', NULL, NULL, '2023-07-20 02:23:07', '2023-07-20 02:23:07'),
(11, NULL, NULL, 'Mohd Shaiful Afzam Bin Mukhtar', 'bobkaneka@gmail.com', NULL, '$2y$10$Bc4/ENQwcnzwzbMC1tmLzeeDeoCoa/t/kd4f6arbEE2SMKumSsdl6', 'Visitor', 'Registered', 1, NULL, NULL, NULL),
(26, '831105146178', NULL, 'nurzety azuan', 'zety80@gmail.com', NULL, '$2y$10$SQZ6/HUaBGmanalGg6NbSuZ1GBHFCOtAGAjo0JWSU8jdJEzviWwTi', 'Contractor', 'Active', 1, 'uLvqFSqiy1mRRLIPPgnkNu6tB3xRvEUK2b7XZTlyFfLT3nCUPS9fxyTijjwt', NULL, '2023-09-18 06:33:32'),
(27, NULL, 'A-11212', 'alam sejahtera sdn bhd', 'ars@gmail.com', NULL, '$2y$10$2OyvbIfG3KcFIOST2XTFiOGhcaUXxTbLAxT5wyNBpbPoKqhz/G59.', 'Company', 'Pending', NULL, 'P1ZC3sWGMNXRCbgg52cYjpROmNNu6zftmkOR4UxHBIdXqvqEmCte0dCkkink', NULL, '2023-09-18 06:04:28'),
(29, NULL, 'B121234', 'Default', 'sejahteralam@gmail.com', NULL, '$2y$10$3/4R5PkC7YrBqszCtuOLZeSDVbFVtw4mF15iXVqeNGt3aUtYdHwAC', 'Company', 'Pending', NULL, NULL, NULL, NULL),
(30, NULL, '33423456', 'Universiti Malaysia Pahang', 'ump@ump.edu.my', NULL, '$2y$10$TBAyZSpOpCQ13rmmxdldH.vVPvpQ90EtzMkYvelZm73RjMCG98J62', 'Company', 'Pending', NULL, NULL, NULL, '2023-09-24 16:17:51'),
(32, '000614031234', NULL, 'Nur Alia Hidayah', 'aliahidayah00@gmail.com', NULL, '$2y$10$GrgYCExdZcGvzgoVg6uCs.sD/MxuvMLxoiMnQVWvYqYJSm93OyyMu', 'Contractor', 'Pending', 1, NULL, NULL, '2023-10-01 13:37:18'),
(33, '000415101234', NULL, 'Nur Fatihah', 'fatihah.jeyy15@gmail.com', NULL, '$2y$10$TWvolJrnlZ1wTU7rtDtq1.6UQKVyoNgLoCweE4CGmWwsT9rDBfWea', 'Contractor', 'Pending', 1, NULL, NULL, '2023-10-01 13:44:13'),
(34, '821223129999', NULL, 'nurzety azuan', 'aqtar@ump.edu.my', NULL, '$2y$10$uV2ISrAeNtKgrjtm90THT.jb62l4MlddEy0t2sPRxxKBJkHueXSRC', 'Contractor', 'Pending', 1, NULL, NULL, '2023-10-04 02:41:48'),
(35, '821231111921', NULL, 'nurzety azuan', 'zety.azuan@gmail.com', NULL, '$2y$10$DR2pGFHmgUUw1x22AR0Q5.nUBsSOStSiKez3uEE2GrQQ3wUv9VdTe', 'Contractor', 'Pending', 1, NULL, NULL, '2023-10-18 03:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicleRegNo` varchar(255) NOT NULL,
  `vehicleType` varchar(255) NOT NULL,
  `vehicleCC` varchar(255) NOT NULL,
  `vehicleColour` varchar(255) NOT NULL,
  `vehicleWeight` varchar(255) NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicleRegNo`, `vehicleType`, `vehicleCC`, `vehicleColour`, `vehicleWeight`, `companyID`, `created_at`, `updated_at`) VALUES
(1, 'ABC123', '10 Tan Lorry', '2.2CC', 'Black', '10 Tan', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicleinfo`
--

CREATE TABLE `vehicleinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointmentID` bigint(20) NOT NULL,
  `vehicleType` varchar(255) NOT NULL,
  `vehicleBrand` varchar(255) NOT NULL,
  `vehicleColor` varchar(255) NOT NULL,
  `vehicleRegNo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicleinfo`
--

INSERT INTO `vehicleinfo` (`id`, `appointmentID`, `vehicleType`, `vehicleBrand`, `vehicleColor`, `vehicleRegNo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Car', 'Myvi', 'Silver', 'ABC123', NULL, NULL),
(2, 2, 'Car', 'Myvi', 'Silver', 'ABC123', NULL, NULL),
(3, 4, 'sedan', 'proton', 'grey', 'vam 1161', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitorinfo`
--

CREATE TABLE `visitorinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `icNo` varchar(255) NOT NULL,
  `employeeNo` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `phoneNo` varchar(255) NOT NULL,
  `birthDate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitorinfo`
--

INSERT INTO `visitorinfo` (`id`, `userID`, `companyID`, `icNo`, `employeeNo`, `occupation`, `phoneNo`, `birthDate`, `address`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '23232343', 'AM2357385334', 'Executive', '0123456789', '2023-07-17', 'Pekan, Pahang', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitorqrscan`
--

CREATE TABLE `visitorqrscan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNo` varchar(255) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `employeeNo` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `visitPurpose` varchar(255) NOT NULL,
  `passNo` varchar(255) DEFAULT NULL,
  `checkInDate` date NOT NULL,
  `checkInTime` time NOT NULL,
  `checkOutDate` date DEFAULT NULL,
  `checkOutTime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitorqrscan`
--

INSERT INTO `visitorqrscan` (`id`, `name`, `email`, `phoneNo`, `companyName`, `employeeNo`, `occupation`, `visitPurpose`, `passNo`, `checkInDate`, `checkInTime`, `checkOutDate`, `checkOutTime`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad', 'ahmad@gmail.com', '0123456789', '1', 'AM2357385367', 'Manager', 'Enforcement', NULL, '2023-07-18', '00:08:28', '2023-07-18', '00:25:20', NULL, '2023-07-17 08:25:20'),
(2, 'Amirul Aizat', 'aizat@gmail.com', '0123456789', '1', 'AH374772', 'Manager', 'Enforcement Visit', NULL, '2023-07-20', '00:58:29', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitrecord`
--

CREATE TABLE `visitrecord` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointmentID` bigint(20) NOT NULL,
  `passNo` varchar(255) NOT NULL,
  `checkInDate` date NOT NULL,
  `checkInTime` time NOT NULL,
  `checkOutDate` date DEFAULT NULL,
  `checkOutTime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitrecord`
--

INSERT INTO `visitrecord` (`id`, `appointmentID`, `passNo`, `checkInDate`, `checkInTime`, `checkOutDate`, `checkOutTime`, `created_at`, `updated_at`) VALUES
(2, 1, '456', '2023-08-14', '14:56:12', '2023-08-14', '14:56:14', NULL, '2023-08-07 06:56:14'),
(3, 2, '098', '2023-08-09', '14:58:31', '2023-08-09', '14:58:32', NULL, '2023-08-07 06:58:32'),
(4, 5, '379', '2023-08-10', '15:20:42', '2023-08-10', '17:20:42', NULL, NULL),
(5, 6, '188', '2023-08-10', '14:27:42', '2023-08-10', '16:22:42', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointmentinfo`
--
ALTER TABLE `appointmentinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biometricinfo`
--
ALTER TABLE `biometricinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklistvisitor`
--
ALTER TABLE `blacklistvisitor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `briefingsession`
--
ALTER TABLE `briefingsession`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companyinfo`
--
ALTER TABLE `companyinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contractorinfo`
--
ALTER TABLE `contractorinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `laptopinfo`
--
ALTER TABLE `laptopinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `safetybriefinginfo`
--
ALTER TABLE `safetybriefinginfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transportinspection`
--
ALTER TABLE `transportinspection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userchangerequests`
--
ALTER TABLE `userchangerequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicleinfo`
--
ALTER TABLE `vehicleinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitorinfo`
--
ALTER TABLE `visitorinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitorqrscan`
--
ALTER TABLE `visitorqrscan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitrecord`
--
ALTER TABLE `visitrecord`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointmentinfo`
--
ALTER TABLE `appointmentinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `biometricinfo`
--
ALTER TABLE `biometricinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `blacklistvisitor`
--
ALTER TABLE `blacklistvisitor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `briefingsession`
--
ALTER TABLE `briefingsession`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `companyinfo`
--
ALTER TABLE `companyinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contractorinfo`
--
ALTER TABLE `contractorinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laptopinfo`
--
ALTER TABLE `laptopinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `safetybriefinginfo`
--
ALTER TABLE `safetybriefinginfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transportinspection`
--
ALTER TABLE `transportinspection`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userchangerequests`
--
ALTER TABLE `userchangerequests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicleinfo`
--
ALTER TABLE `vehicleinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visitorinfo`
--
ALTER TABLE `visitorinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visitorqrscan`
--
ALTER TABLE `visitorqrscan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visitrecord`
--
ALTER TABLE `visitrecord`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
