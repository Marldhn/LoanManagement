-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2026 at 03:50 AM
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
-- Database: `loan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `balance` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_name`, `balance`, `description`) VALUES
(1, 'Gcash ', '5000', 'NA'),
(2, 'Maya', '12500', 'qwf'),
(6, 'BPI', '8311', '123'),
(7, 'Maribank', '3334', '20');

-- --------------------------------------------------------

--
-- Table structure for table `account_transfers`
--

CREATE TABLE `account_transfers` (
  `id` int(11) NOT NULL,
  `from_account_id` int(11) DEFAULT NULL,
  `to_account_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrowers`
--

CREATE TABLE `borrowers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowers`
--

INSERT INTO `borrowers` (`id`, `fullname`, `contact`, `address`, `created_at`) VALUES
(1, 'Marldohn Rubinos', '09061941138', 'Jakosalem Street', '2026-05-14 02:25:58'),
(8, 'March Shelou Ardillo', '09059626063', 'Sikatuna', '2026-05-17 10:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `guarantors`
--

CREATE TABLE `guarantors` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guarantors`
--

INSERT INTO `guarantors` (`id`, `fullname`, `contact`, `address`, `created_at`) VALUES
(1, 'Marldohn Rubinos', '09061941138', 'Jakosalem Street', '2026-05-14 03:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `borrower_name` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `interest` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `borrower_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `guarantor_id` int(11) DEFAULT NULL,
  `borrowed_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `borrower_name`, `amount`, `interest`, `total`, `status`, `created_at`, `borrower_id`, `account_id`, `guarantor_id`, `borrowed_date`, `due_date`, `is_deleted`) VALUES
(19, NULL, 1000.00, 1.00, 1010.00, 'active', '2026-05-14 20:59:34', 1, NULL, NULL, '2026-05-15', '2026-05-30', 1),
(41, NULL, 1000.00, 10.00, 1100.00, 'active', '2026-05-17 21:46:05', 8, NULL, NULL, '2026-05-18', '2026-07-17', 0),
(42, NULL, 10000.00, 10.00, 11000.00, 'active', '2026-05-17 23:22:03', 1, NULL, 1, '2026-05-18', '2026-06-17', 0),
(43, NULL, 1000.00, 1.00, 1010.00, 'active', '2026-05-18 00:48:47', 8, NULL, 1, '2026-05-18', '2026-05-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loan_accounts`
--

CREATE TABLE `loan_accounts` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_accounts`
--

INSERT INTO `loan_accounts` (`id`, `loan_id`, `account_id`, `amount`, `created_at`) VALUES
(1, 6, 2, 6000.00, '2026-05-14 03:12:07'),
(2, 6, 1, 4000.00, '2026-05-14 03:12:07'),
(4, 13, 3, 1000.00, '2026-05-14 04:27:54'),
(5, 13, 1, 1000.00, '2026-05-14 04:27:55'),
(6, 14, 7, 10000.00, '2026-05-14 17:07:45'),
(9, 18, 7, 1.00, '2026-05-14 20:46:28'),
(10, 18, 2, 1.00, '2026-05-14 20:46:28'),
(11, 19, 7, 1000.00, '2026-05-14 20:59:34'),
(12, 20, 7, 1000.00, '2026-05-15 02:14:13'),
(13, 22, 7, 7000.00, '2026-05-15 02:39:35'),
(14, 22, 6, 3000.00, '2026-05-15 02:39:35'),
(15, 23, 2, 499.00, '2026-05-15 02:43:47'),
(16, 24, 2, 1000.00, '2026-05-15 02:46:12'),
(20, 27, 6, 1000.00, '2026-05-17 11:35:45'),
(21, 28, 7, 10000.00, '2026-05-17 12:56:12'),
(22, 41, 7, 1000.00, '2026-05-17 21:46:05'),
(23, 42, 2, 10000.00, '2026-05-17 23:22:03'),
(24, 43, 7, 1000.00, '2026-05-18 00:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `loan_id`, `account_id`, `amount`, `payment_date`, `notes`, `created_at`) VALUES
(8, 27, NULL, 500.00, '2026-05-17 12:46:22', 'NA', '2026-05-17 12:46:22'),
(9, 41, 7, 1000.00, '2026-05-17 22:06:57', '1000', '2026-05-17 22:06:57'),
(10, 41, 7, 100.00, '2026-05-17 22:21:21', 'NA', '2026-05-17 22:21:21'),
(11, 19, 7, 1233.00, '2026-05-17 22:45:27', 'NA', '2026-05-17 22:45:27'),
(12, 42, 2, 11500.00, '2026-05-17 23:22:41', 'NA', '2026-05-17 23:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `penalties`
--

CREATE TABLE `penalties` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalties`
--

INSERT INTO `penalties` (`id`, `loan_id`, `borrower_id`, `amount`, `reason`, `created_at`) VALUES
(1, 16, 1, 100.00, 'NA', '2026-05-15 02:06:23'),
(2, 16, 1, 123.00, '1', '2026-05-15 02:06:29'),
(3, 15, 1, 1.00, '1', '2026-05-15 02:06:37'),
(4, 15, 1, 100.00, 'NA', '2026-05-15 02:06:47'),
(5, 14, 1, 123.00, '12', '2026-05-15 02:06:55'),
(6, 6, 1, 123.00, '123', '2026-05-15 02:06:59'),
(7, 19, 1, 123.00, '123', '2026-05-15 02:07:02'),
(8, 6, 1, 123.00, '123', '2026-05-15 02:11:07'),
(10, 21, 6, 100.00, '100', '2026-05-15 03:17:13'),
(11, 20, 5, 100.00, '100', '2026-05-15 03:17:16'),
(12, 27, 8, 100.00, 'NA', '2026-05-17 12:51:16'),
(13, 27, 8, 100.00, 'NA', '2026-05-17 12:51:36'),
(14, 19, 1, 100.00, 'NA', '2026-05-17 22:34:54'),
(15, 42, 1, 500.00, 'LAte Fee', '2026-05-17 23:22:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin'),
(2, 'Marldohn Rubinos', 'mrubinos@azpired.net', '$2y$10$9oTMcNKnSA6s91R457LK4OnRBm297ASYYgnomB4umnZrCGnaJWd1K', 'admin'),
(3, 'Marldohn Rubinos', '123123@gmail.com', '$2y$10$qtcYl2YkOe3JxsEx1Y10kuhntxeEyN.i.eTBIEeDHjrOTU5ZLCPcu', 'admin'),
(4, 'Marldohn Rubinos', 'mrubinos@azpired.net', '$2y$10$MORMUsj3qWohEupKXyerauSbPonWKXegxRX813cPMaTvjrJy.El5e', 'admin'),
(5, 'noli@gmail.com', 'noli@gmail.com', '$2y$10$kMDXIniz93Br1OFjfWvFlORuLIMUDwRVj0fDfL0RbBQTeYBKLUyze', 'admin'),
(6, 'march ', 'march@gmail.com', '$2y$10$KWyPZXhaaxzcMmfqq91F..i3a1atpGGyw/Sha7iBk1SCxWVRgy4xu', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_transfers`
--
ALTER TABLE `account_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guarantors`
--
ALTER TABLE `guarantors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`);


-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `account_transfers`
--
ALTER TABLE `account_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `guarantors`
--
ALTER TABLE `guarantors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
