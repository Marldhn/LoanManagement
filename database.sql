-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 15, 2026 at 05:27 AM
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
(2, 'Maya', '11000', 'qwf'),
(6, 'BPI', '9311', '123'),
(7, 'Maribank', '9998', '20'),
(8, 'wqfqwf', '1123', 'qwfqwf');

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
(1, 'Marldohn Rubinossss', '129047891274', 'fwelnfion', '2026-05-14 02:25:58'),
(5, 'qwfjibqwhb', 'b', 'uibu', '2026-05-14 20:44:29'),
(6, 'wqfqwf', 'qwfqwf', 'qwfqwf', '2026-05-15 02:38:39'),
(7, 'qdqd', 'qsdqsd', 'qsdqsd', '2026-05-15 03:27:06');

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
(1, 'wqfqwfqwdqwd5466', 'qwfqw', 'fqwf', '2026-05-14 03:55:11');

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
(6, NULL, 10000.00, 100.00, 20000.00, 'active', '2026-05-14 03:12:07', 1, NULL, NULL, NULL, NULL, 1),
(14, NULL, 10000.00, 100.00, 20000.00, 'active', '2026-05-14 17:07:45', 1, NULL, NULL, NULL, NULL, 1),
(15, NULL, 1.00, 1.00, 1.01, 'active', '2026-05-14 20:29:22', 1, NULL, 1, NULL, NULL, 0),
(16, NULL, 2.00, 1.00, 2.02, 'active', '2026-05-14 20:29:26', 1, NULL, 1, NULL, NULL, 0),
(19, NULL, 1000.00, 1.00, 1010.00, 'active', '2026-05-14 20:59:34', 1, NULL, NULL, '2026-05-15', '2026-05-30', 0),
(20, NULL, 1000.00, 15.00, 1150.00, 'active', '2026-05-15 02:14:13', 5, NULL, 1, '2026-05-15', '2026-06-14', 0),
(21, NULL, 10000.00, 100.00, 20000.00, 'active', '2026-05-15 02:39:30', 6, NULL, NULL, '2026-05-17', '2026-06-16', 0),
(24, NULL, 1000.00, 1.00, 1010.00, 'active', '2026-05-15 02:46:12', 6, NULL, 1, '2026-05-22', '2026-05-23', 1);

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
(3, 7, 3, 500.00, '2026-05-14 03:56:26'),
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
(16, 24, 2, 1000.00, '2026-05-15 02:46:12');

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
(11, 20, 5, 100.00, '100', '2026-05-15 03:17:16');

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
(1, 'Admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin');

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
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`);

--
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guarantors`
--
ALTER TABLE `guarantors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
