-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 07:16 PM
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
  `bringVehicle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bringLaptop` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointmentStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointmentinfo`
--

INSERT INTO `appointmentinfo` (`id`, `staffID`, `contVisitID`, `appointmentPurpose`, `appointmentAgenda`, `appointmentDate`, `appointmentTime`, `bringVehicle`, `bringLaptop`, `appointmentStatus`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Meeting', 'Repair machine A', '2023-07-18', '14:00:00', 'Yes', 'Yes', 'Attend', '2023-07-16 23:04:31', '2023-07-16 23:23:47');

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
(1, 2, '64b5152f9007e.jpg', '2023-07-16 22:36:20', '2023-07-16 22:36:20');

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

-- --------------------------------------------------------

--
-- Table structure for table `companyinfo`
--

CREATE TABLE `companyinfo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyPhoneNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companyinfo`
--

INSERT INTO `companyinfo` (`id`, `companyName`, `companyEmail`, `companyPhoneNo`, `companyAddress`, `created_at`, `updated_at`) VALUES
(1, 'Universiti Malaysia Pahang', 'ump@ump.edu.my', '0123456789', 'Pekan, Pahang', NULL, NULL);

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
  `passExpiryDate` date NOT NULL,
  `birthDate` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validityPassPhoto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `laptopinfo`
--

INSERT INTO `laptopinfo` (`id`, `appointmentID`, `laptopBrand`, `laptopModel`, `laptopColor`, `laptopSerialNo`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Huawei', 'Matebook D', 'Silver', '3234235', 'Approved', NULL, '2023-07-16 23:39:14');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `category`, `status`, `companyID`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nurain Aleeya', 'nurainaleeyacz@gmail.com', NULL, '$2y$10$qv7cTmodwkPs801UpgawCez8Pmt4o9BoiaD3TEaZxAs2xBpyJrtmm', 'Staff', 'Active', NULL, NULL, '2023-07-16 22:24:19', '2023-07-16 22:24:19'),
(2, 'Nur Alia Hidayah', 'aliahidayah00@gmail.com', NULL, '$2y$10$WSFwiTaybg2o4TmWiSRr5.VujMqHFtg/FQXxKJLoAy2zYQNQP80mW', 'Visitor', 'Blacklisted', 1, NULL, NULL, '2023-07-17 09:03:32'),
(3, 'Nurin Azyyati', 'theocloud1479@gmail.com', NULL, '$2y$10$5hKtl5ewifIZiyDzD6D.fOHjPCxtvR9ps9wlRZJxltHPyRW2VKAle', 'SHEQ Officer', 'Active', NULL, NULL, '2023-07-16 22:34:01', '2023-07-16 22:34:01'),
(4, 'Maisarah Faisal', 'maisarahfaisal75@gmail.com', NULL, '$2y$10$kQi48NoJiWxZCTlrxggkHeP.s239m4efJLlMDGL/EJpjwp0Y84kxG', 'SHEQ Guard', 'Active', NULL, NULL, '2023-07-16 23:41:15', '2023-07-16 23:41:15'),
(5, 'Alia', 'aliahidayah146@gmail.com', NULL, '$2y$10$bq1fbVE17YTlXb6ascsFkOz3MYqc4rmRyegTRhJzR0e4T6EJW9TaC', 'Contractor', 'Registered', 1, NULL, NULL, NULL);

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

--
-- Dumping data for table `vehicleinfo`
--

INSERT INTO `vehicleinfo` (`id`, `appointmentID`, `vehicleType`, `vehicleBrand`, `vehicleColor`, `vehicleRegNo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Car', 'Myvi', 'Silver', 'ABC123', NULL, NULL);

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
(1, 2, 1, 'AM2357385334', 'Executive', '0123456789', '2023-07-17', 'Pekan, Pahang', NULL, NULL);

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

--
-- Dumping data for table `visitorqrscan`
--

INSERT INTO `visitorqrscan` (`id`, `name`, `email`, `phoneNo`, `companyName`, `employeeNo`, `occupation`, `visitPurpose`, `passNo`, `checkInDate`, `checkInTime`, `checkOutDate`, `checkOutTime`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad', 'ahmad@gmail.com', '0123456789', '1', 'AM2357385367', 'Manager', 'Enforcement', NULL, '2023-07-18', '00:08:28', '2023-07-18', '00:25:20', NULL, '2023-07-17 08:25:20');

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blacklistvisitor`
--
ALTER TABLE `blacklistvisitor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `briefingsession`
--
ALTER TABLE `briefingsession`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companyinfo`
--
ALTER TABLE `companyinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contractorinfo`
--
ALTER TABLE `contractorinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laptopinfo`
--
ALTER TABLE `laptopinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicleinfo`
--
ALTER TABLE `vehicleinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitorinfo`
--
ALTER TABLE `visitorinfo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitorqrscan`
--
ALTER TABLE `visitorqrscan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitrecord`
--
ALTER TABLE `visitrecord`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
