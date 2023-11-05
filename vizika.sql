-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2023 at 04:09 PM
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
  `appointmentDateStart` date NOT NULL,
  `appointmentDateEnd` date NOT NULL,
  `appointmentTime` time NOT NULL,
  `bringVehicle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bringLaptop` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointmentStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointmentinfo`
--

INSERT INTO `appointmentinfo` (`id`, `staffID`, `contVisitID`, `appointmentPurpose`, `appointmentAgenda`, `appointmentDateStart`, `appointmentDateEnd`, `appointmentTime`, `bringVehicle`, `bringLaptop`, `appointmentStatus`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'Meeting', 'Meeting Project', '2023-10-30', '2023-10-31', '15:49:35', 'No', 'No', 'Attend', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `biometricinfo`
--

CREATE TABLE `biometricinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `facialRecognition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `biometricinfo`
--

INSERT INTO `biometricinfo` (`id`, `userID`, `facialRecognition`, `created_at`, `updated_at`) VALUES
(1, 6, '65104e1a53a9e.jpg', '2023-09-24 06:56:26', '2023-09-24 06:56:26'),
(2, 7, '651966ba41d41.jpg', '2023-10-01 04:31:54', '2023-10-01 04:31:54'),
(3, 8, '6519714488672.jpg', '2023-10-01 05:16:52', '2023-10-01 05:16:52'),
(4, 10, '6547ac135877a.jpg', '2023-11-05 06:52:03', '2023-11-05 06:52:03');

-- --------------------------------------------------------

--
-- Table structure for table `blacklistvisitor`
--

CREATE TABLE `blacklistvisitor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `blacklistReason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 36, 6, NULL, NULL),
(2, 44, 7, NULL, NULL),
(3, 40, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companyinfo`
--

CREATE TABLE `companyinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `staffID` bigint(20) NOT NULL,
  `mngtPICName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mngtPICEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `safetyPICName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `safetyPICEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyRegNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyEmail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyPhoneNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyAddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyIndustries` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companyinfo`
--

INSERT INTO `companyinfo` (`id`, `userID`, `staffID`, `mngtPICName`, `mngtPICEmail`, `safetyPICName`, `safetyPICEmail`, `companyName`, `companyRegNo`, `companyEmail`, `companyPhoneNo`, `companyAddress`, `companyIndustries`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'Ahmad', 'ahmad@gmail.com', 'Aminah', 'aminah@gmail.com', 'Universiti Malaysia Pahang', NULL, 'ump@ump.edu.my', '01234567890', 'Pekan, Pahang', 'Engineering', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contractName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contractStartDate` date NOT NULL,
  `contractEndDate` date NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `contractorID` bigint(20) NOT NULL,
  `staffID` bigint(20) NOT NULL,
  `contractAmount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractorinfo`
--

CREATE TABLE `contractorinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `employeeNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passExpiryDate` date DEFAULT NULL,
  `birthDate` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validityPassPhoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractorinfo`
--

INSERT INTO `contractorinfo` (`id`, `userID`, `companyID`, `employeeNo`, `phoneNo`, `passExpiryDate`, `birthDate`, `address`, `validityPassPhoto`, `created_at`, `updated_at`) VALUES
(2, 6, 1, 'AM2357385334', '0195785840', '2024-03-24', '2000-06-14', 'Tanjung Malim, Perakk', NULL, NULL, '2023-09-24 06:57:43'),
(3, 7, 1, 'AM2357385234', '0123456789', '2024-04-08', '2000-04-15', 'Bera, Pahang', NULL, NULL, '2023-10-08 07:56:12'),
(4, 8, 1, 'AM2357385367', '0123456789', NULL, '2000-01-22', 'Pekan, Pahang', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laptopinfo`
--

CREATE TABLE `laptopinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointmentID` bigint(20) NOT NULL,
  `laptopBrand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `laptopModel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `laptopColor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `laptopSerialNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(176, '2014_10_12_000000_create_users_table', 1),
(177, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(178, '2014_10_12_100000_create_password_resets_table', 1),
(179, '2019_08_19_000000_create_failed_jobs_table', 1),
(180, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(181, '2023_03_24_134814_create_contractorinfo_table', 1),
(182, '2023_03_26_033852_create_appointmentinfo_table', 1),
(183, '2023_03_29_133443_create_visitorinfo_table', 1),
(184, '2023_03_29_161140_create_blacklistvisitor_table', 1),
(185, '2023_03_29_162020_create_briefingsession_table', 1),
(186, '2023_03_29_163029_create_safetybriefinginfo_table', 1),
(187, '2023_03_29_163506_create_visitrecord_table', 1),
(188, '2023_03_31_072517_create_companyinfo_table', 1),
(189, '2023_05_31_161858_create_biometricinfo_table', 1),
(190, '2023_07_09_145916_create_laptopinfo_table', 1),
(191, '2023_07_13_153223_create_vehicleinfo_table', 1),
(192, '2023_07_17_154955_create_visitorqrscan_table', 1),
(193, '2023_08_01_123316_create_transport_table', 1),
(194, '2023_08_01_130217_create_transportinspection_table', 1),
(195, '2023_08_02_025106_create_vehicle_table', 1),
(196, '2023_08_08_144926_create_contract_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `briefingStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `safetybriefinginfo`
--

INSERT INTO `safetybriefinginfo` (`id`, `briefingDate`, `briefingTimeStart`, `briefingTimeEnd`, `maxParticipant`, `briefingStatus`, `created_at`, `updated_at`) VALUES
(45, '2023-10-31', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(46, '2023-10-31', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(47, '2023-11-01', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(48, '2023-11-01', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(49, '2023-11-02', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(50, '2023-11-02', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(51, '2023-11-03', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(52, '2023-11-03', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(53, '2023-11-06', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(54, '2023-11-06', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(55, '2023-11-07', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(56, '2023-11-07', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(57, '2023-11-08', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(58, '2023-11-08', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(59, '2023-11-09', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(60, '2023-11-09', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(61, '2023-11-10', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(62, '2023-11-10', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(63, '2023-11-13', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(64, '2023-11-13', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(65, '2023-11-14', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(66, '2023-11-14', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(67, '2023-11-15', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(68, '2023-11-15', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(69, '2023-11-16', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(70, '2023-11-16', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(71, '2023-11-17', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(72, '2023-11-17', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(73, '2023-11-20', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(74, '2023-11-20', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(75, '2023-11-21', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(76, '2023-11-21', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(77, '2023-11-22', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(78, '2023-11-22', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(79, '2023-11-23', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(80, '2023-11-23', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(81, '2023-11-24', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(82, '2023-11-24', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(83, '2023-11-27', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(84, '2023-11-27', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(85, '2023-11-28', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(86, '2023-11-28', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(87, '2023-11-29', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(88, '2023-11-29', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL),
(89, '2023-11-30', '09:00:00', '11:00:00', 30, 'Active', NULL, NULL),
(90, '2023-11-30', '15:00:00', '17:00:00', 30, 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visitDate` date NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `vehicleRegNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contractorID` bigint(20) NOT NULL,
  `noIC` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `vehicleRegNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primeMoverInside` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primeMoverBack` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailerUnder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailerBehind` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailerLeft` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailerRight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `security` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userchangerequests`
--

CREATE TABLE `userchangerequests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `original_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_changed` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `requestStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userchangerequests`
--

INSERT INTO `userchangerequests` (`id`, `userID`, `original_value`, `field_changed`, `new_value`, `request_date`, `requestStatus`, `created_at`, `updated_at`) VALUES
(1, 2, '0123456787', 'phoneNo', '0195785840', '2023-09-14 08:18:21', 'Pending', '2023-09-14 00:18:21', '2023-09-14 00:18:21'),
(2, 2, 'Proton City', 'address', 'Tanjung Malim', '2023-09-14 08:18:21', 'Pending', '2023-09-14 00:18:21', '2023-09-14 00:18:21'),
(3, 51, '1', 'companyID', '2', '2023-09-14 09:21:07', 'Pending', '2023-09-14 01:21:07', '2023-09-14 01:21:07'),
(4, 51, 'Universiti Malaysia Pahang', 'companyID', 'Petronas', '2023-09-14 09:29:13', 'Pending', '2023-09-14 01:29:13', '2023-09-14 01:29:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyRegNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyID` bigint(20) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `icNo`, `companyRegNo`, `name`, `email`, `email_verified_at`, `password`, `category`, `status`, `companyID`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Nurain Aleeya', 'nurainaleeyacz@gmail.com', NULL, '$2y$10$FGMKPGvBy09mfwhNOvLY9.xkGvQgRNemu8Rn8KbIiEaYiGe7sSpvm', 'Staff', 'Pending', NULL, NULL, '2023-09-24 06:37:58', '2023-09-24 06:37:58'),
(2, NULL, NULL, 'Nurin Azyyati', 'theocloud1479@gmail.com', NULL, '$2y$10$SuH1XW5FaHcmcBgi6uNGYecjKa8IUsaIhFfXJja6aO520KTRt1HQG', 'SHEQ Officer', 'Pending', NULL, NULL, '2023-09-24 06:38:35', '2023-09-24 06:38:35'),
(3, NULL, NULL, 'Maisarah Faisal', 'maisarahfaisal75@gmail.com', NULL, '$2y$10$TN1rc2/Lg3M.c3wki9Vvb.tSFhug8VK0wtrFYDZxOHiyszLx8xrVq', 'SHEQ Guard', 'Pending', NULL, NULL, '2023-09-24 06:41:09', '2023-09-24 06:41:09'),
(5, NULL, '24235346346', 'Universiti Malaysia Pahang', 'ump@ump.edu.my', NULL, '$2y$10$lAvayA49hFRX0eAdS.IVpuNbrWaT6XjPhXujp.T2x1Ta86JFwz/WW', 'Company', 'Pending', NULL, NULL, NULL, '2023-09-24 06:48:38'),
(6, '00061403101234', NULL, 'Nur Alia Hidayah Binti Rohaya Udin', 'aliahidayah00@gmail.com', NULL, '$2y$10$I.BvmBHQF3FA94UXu1.S8.WzQ42yUhjk1zgL6GYAk.e2E7kRP/EAm', 'Contractor', 'Active', 1, NULL, NULL, '2023-09-24 06:57:43'),
(7, '000415101234', NULL, 'Fatihah', 'fatihah.jeyy15@gmail.com', NULL, '$2y$10$rIQzRZlrq1n3wIslJiGnGOWxTJnLtt7H8tzn3O6JPVqbZAASLe.KG', 'Contractor', 'Active', 1, NULL, NULL, '2023-10-08 07:56:12'),
(8, '000122061234', NULL, 'Huda Ramli', 'hudaramli01@gmail.com', NULL, '$2y$10$MXjI5iSAcgBGmwgDd6Uc3ecGqwqJs2urCl3j3EF8C6LbtrJRGePOq', 'Visitor', 'Active', 1, NULL, NULL, '2023-10-01 05:15:53'),
(10, '123456789123', NULL, 'Aminah', 'aminah@gmail.com', NULL, '$2y$10$qpsIkNHDwJKYqi5aD2mUJuw9YMGBAomokhus/qynTSRlg1B.y0TbC', 'Visitor', 'Pending', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicleRegNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicleType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicleCC` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicleColour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicleWeight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicleinfo`
--

CREATE TABLE `vehicleinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointmentID` bigint(20) NOT NULL,
  `vehicleType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicleBrand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicleColor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicleRegNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitorinfo`
--

CREATE TABLE `visitorinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) NOT NULL,
  `companyID` bigint(20) NOT NULL,
  `employeeNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthDate` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitorinfo`
--

INSERT INTO `visitorinfo` (`id`, `userID`, `companyID`, `employeeNo`, `occupation`, `phoneNo`, `birthDate`, `address`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 'DR2346777', 'Executive', '0123456789', '2000-02-01', 'Pekan, Pahang', NULL, NULL),
(2, 10, 1, 'AM2357385234', 'Manager', '0189563345', '2000-01-01', 'RESIDEN PELAJAR 5, UNIVERSITI MALAYSIA PAHANG KAMPUS PEKAN', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitorqrscan`
--

CREATE TABLE `visitorqrscan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employeeNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visitPurpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkInDate` date NOT NULL,
  `checkInTime` time NOT NULL,
  `checkOutDate` date DEFAULT NULL,
  `checkOutTime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitrecord`
--

CREATE TABLE `visitrecord` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointmentID` bigint(20) NOT NULL,
  `passNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkInDate` date NOT NULL,
  `checkInTime` time NOT NULL,
  `checkOutDate` date DEFAULT NULL,
  `checkOutTime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `biometricinfo`
--
ALTER TABLE `biometricinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blacklistvisitor`
--
ALTER TABLE `blacklistvisitor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `briefingsession`
--
ALTER TABLE `briefingsession`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companyinfo`
--
ALTER TABLE `companyinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractorinfo`
--
ALTER TABLE `contractorinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laptopinfo`
--
ALTER TABLE `laptopinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `safetybriefinginfo`
--
ALTER TABLE `safetybriefinginfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transportinspection`
--
ALTER TABLE `transportinspection`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userchangerequests`
--
ALTER TABLE `userchangerequests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicleinfo`
--
ALTER TABLE `vehicleinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitorinfo`
--
ALTER TABLE `visitorinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visitorqrscan`
--
ALTER TABLE `visitorqrscan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitrecord`
--
ALTER TABLE `visitrecord`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
