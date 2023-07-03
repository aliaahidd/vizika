-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2023 at 06:28 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `category`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nurin Azyyati', 'theocloud1479@gmail.com', NULL, '$2y$10$zw6n9d0FuxAUIMiRtN6Zm.NQDo3lGuHMi3kI5nBwne7l3g.fxMPpi', 'SHEQ Officer', NULL, '2023-06-14 18:22:15', '2023-06-14 18:22:15'),
(2, 'Nurain Aleeya', 'nurainaleeyacz@gmail.com', NULL, '$2y$10$.FYQwNcCW4Po3w6KJEf2s.aMZ4RXL0J1wp6uZeei8.8upxpZ0hb3m', 'Staff', NULL, '2023-06-14 18:41:25', '2023-06-14 18:41:25'),
(3, 'Maisarah Faisal', 'maisarahfaisal75@gmail.com', NULL, '$2y$10$nTK7MHnSiPDq3NRBUbCotuLdpYXkuaiAXgvjiLFBhpFkT29geq4Mi', 'SHEQ Guard', NULL, '2023-06-14 18:42:16', '2023-06-14 18:42:16'),
(4, 'Nur Alia Hidayah', 'aliahidayah00@gmail.com', NULL, '$2y$10$jfau1IdzNUkOyo3574eWpOOu1RHEPUfWJ2XQ4UCIfO3S2YqSMirhK', 'Contractor', NULL, NULL, NULL),
(5, 'Farra Alia', 'farraalia280@gmail.com', NULL, '$2y$10$tpIyRZhYVdhX798srYujbu7qfjEHgWSjzhV/dz3BsfcJ8dJhVea6.', 'Visitor', NULL, NULL, '2023-06-17 02:05:30'),
(6, 'Nur Afiqah', 'fiqahimnida@gmail.com', NULL, '$2y$10$nUx0OfMPg18ZUbvfOW2zdu19NHEg5lPCb/HFRHE.wEZlT5bPLf1Dy', 'Visitor', NULL, NULL, NULL),
(7, 'Nurul Huda', 'hudaramli01@gmail.com', NULL, '$2y$10$StXmxZ1.5RsEVPB0oAJMteajj5SoDGYKy3VzjmxieS7w5iTBz0ESi', 'Visitor', NULL, NULL, NULL),
(8, 'Nursyahkina Othman', 'kino@gmail.com', NULL, '$2y$10$9JGINh8GzOZ9JcrLGGznG.Lxr6E1QJFtwZ.abkgBbJXa9iprHxZtO', 'Staff', NULL, '2023-06-18 02:46:29', '2023-06-18 02:46:29'),
(9, 'Amira Natasha', 'nnatasha0607@gmail.com', NULL, '$2y$10$OrfE3bQeMwMuEdusZ7IpxO5gt3v6Oq7mIhM1qgbBl3pNwsJ7LEqMy', 'Visitor', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
