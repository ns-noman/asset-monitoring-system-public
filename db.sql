-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 11, 2025 at 04:44 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int NOT NULL,
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `branch_id`, `employee_id`, `name`, `username`, `type`, `mobile`, `email`, `password`, `image`, `status`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 1, 1, 'Super Admin', NULL, 1, '01800000000', 'admin@gmail.com', '$2y$10$72mM6bhPWEoFlgJKq1WaueJN1g7vMISry0HMa1c5THjRYa7HTISV2', 'admin-1725091483.jpeg', 1, '2024-08-31 07:03:44', '2025-01-01 05:48:55', 'KWi534nl3SanDQakODtyLBzJ4CSoEUTXrXoFnjtqBdD3V3PSuaXNrOC3OMw2'),
(2, 8, 2, 'Nowab Shorif', NULL, 8, '01839317038', 'b@gmail.com', '$2y$10$72mM6bhPWEoFlgJKq1WaueJN1g7vMISry0HMa1c5THjRYa7HTISV2', NULL, 1, '2024-08-31 07:44:59', '2025-01-20 06:25:20', 'RlM8Rki0I9yjpbl1jkdEGWqrRj2PIXUvViOM0dZ2YMuX3CDxpCpzXMpqtVhg'),
(3, 2, 3, 'Alexander Reed', NULL, 8, '01839317038', 'c@gmail.com', '$2y$10$72mM6bhPWEoFlgJKq1WaueJN1g7vMISry0HMa1c5THjRYa7HTISV2', NULL, 1, '2024-10-27 09:39:39', '2025-01-11 11:09:41', 'Wc9GVhYTWX1zmQoFbv4nXTxHpivhIW4rtUqXQG0bsG0k62q1jHW3MVmkKyHp'),
(4, 1, 4, 'Malek Azad', NULL, 3, '345678', 'malek@gmail.com', '$2y$10$0Q7BGtHOlXHlst0ze5v99e2rlT8Yy.FYDdcAxCnuvvDMrYMxAZlSe', NULL, 1, '2025-01-20 04:40:10', '2025-01-20 04:40:10', NULL),
(5, 1, 5, 'Brendan Grimes', NULL, 8, '87', 'cyjabimazy@mailinator.com', '$2y$10$oTd9UvyA.h7VpjnXAOT2q.O.fsib0pW26ejBox3nrBapTrcZe.JeW', NULL, 1, '2025-01-20 04:53:59', '2025-01-20 05:43:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` int NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `purchase_date` date DEFAULT NULL,
  `purchase_value` decimal(10,2) DEFAULT NULL,
  `warranty_time` int DEFAULT NULL,
  `asset_life` int DEFAULT NULL,
  `depreciation_rate` decimal(10,2) DEFAULT NULL,
  `is_assigned` tinyint NOT NULL DEFAULT '0',
  `is_okay` tinyint NOT NULL DEFAULT '1',
  `location` tinyint NOT NULL DEFAULT '0' COMMENT '0=store, 1=branch, 2=transit,3=garage',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by_id` bigint DEFAULT NULL,
  `updated_by_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `category_id`, `code`, `title`, `description`, `purchase_date`, `purchase_value`, `warranty_time`, `asset_life`, `depreciation_rate`, `is_assigned`, `is_okay`, `location`, `status`, `created_by_id`, `updated_by_id`, `created_at`, `updated_at`) VALUES
(1, 9, 'com-0001', 'HP Elite Book 840 G8', 'RAM-16 GB\r\nNVME -512GB\r\nProccessor-Core i7, 11th Gen', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 0, 1, 1, 1, 1, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(2, 9, '0010', 'HP Elite Book 850 G8', 'RAM-16 GB\r\nNVME -512GB\r\nProcessor Core i7, 12th Gen', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 0, 1, 1, 1, 1, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(3, 2, 'M-3534', 'DELL M-2234', 'DELL M-2234,\r\nwarranty - 10 years', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 1, 1, 1, 1, 1, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(4, 8, '8082', 'SAMSUNG Computer 8082', 'SAMSUNG Monitor 8082', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 1, 1, 1, 1, 1, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(5, 12, 'BH-1212', 'Bluetooth Headphone', 'Bluetooth Headphone', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 1, 1, 1, 1, NULL, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(6, 12, 'WH-32432', 'Wired Headphone', 'Wired Headphone', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 0, 2, 1, 1, NULL, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(7, 13, 'NBS-1232', 'Nokia Bluetooth Speaker', 'Nokia Bluetooth Speaker', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 1, 1, 1, 1, NULL, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(8, 13, 'SP-3253', 'Huwei Speaker', 'Speaker', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 1, 2, 1, 1, NULL, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(9, 15, 'G-405', 'Gree AC G-405', 'Gree AC G-405', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 1, 1, 1, 1, NULL, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(10, 10, 'E-1', 'Telephone E-1', 'Telephone E-1', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 0, 1, 1, 1, 1, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(11, 7, 'WL-1323', 'Walton WL-1323', 'Walton WL-1323', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 1, 1, 1, 1, NULL, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(12, 7, 'WL-1324', 'Walton WL-1324', 'Walton WL-1324', '2025-01-01', '10000.00', 6, 2, '10.00', 1, 0, 2, 1, 1, 1, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(13, 8, 'D-1212', 'Hp Desktop D-1212', 'Hp Desktop D-1212', '2025-01-01', '10000.00', 6, 2, '10.00', 0, 1, 0, 1, 1, NULL, '2024-12-31 18:00:00', '2024-12-31 18:00:00'),
(14, 8, 'Sequi autem omnis et', 'Incididunt facilis m', 'Est minima incididun', '2025-01-01', '10000.00', 6, 2, '10.00', 0, 1, 0, 1, 1, 1, '2024-12-31 18:00:00', '2024-12-31 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `asset_statuses`
--

CREATE TABLE `asset_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint NOT NULL,
  `asset_id` bigint NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_okay` tinyint NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  `created_by_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_statuses`
--

INSERT INTO `asset_statuses` (`id`, `branch_id`, `asset_id`, `remarks`, `is_okay`, `date`, `created_by_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, NULL, 0, '2025-01-04', 1, '2025-01-03 23:20:46', NULL),
(2, 1, 10, NULL, 0, '2025-01-04', 1, '2025-01-03 23:20:46', NULL),
(3, 1, 11, NULL, 1, '2025-01-04', 1, '2025-01-03 23:20:46', NULL),
(4, 1, 12, NULL, 1, '2025-01-04', 1, '2025-01-03 23:20:46', NULL),
(5, 1, 11, NULL, 1, '2025-01-04', 1, '2025-01-03 23:22:30', NULL),
(6, 1, 9, NULL, 0, '2025-01-04', 1, '2025-01-03 23:22:30', NULL),
(7, 1, 12, NULL, 1, '2025-01-04', 1, '2025-01-03 23:22:30', NULL),
(8, 1, 10, NULL, 0, '2025-01-04', 1, '2025-01-03 23:22:30', NULL),
(9, 1, 11, NULL, 1, '2025-01-04', 1, '2025-01-03 23:34:46', NULL),
(10, 1, 9, NULL, 0, '2025-01-04', 1, '2025-01-03 23:34:46', NULL),
(11, 1, 12, NULL, 1, '2025-01-04', 1, '2025-01-03 23:34:46', NULL),
(12, 1, 10, NULL, 0, '2025-01-04', 1, '2025-01-03 23:34:46', NULL),
(13, 1, 11, NULL, 1, '2025-01-04', 1, '2025-01-04 00:00:55', NULL),
(14, 1, 9, NULL, 0, '2025-01-04', 1, '2025-01-04 00:00:55', NULL),
(15, 1, 12, NULL, 1, '2025-01-04', 1, '2025-01-04 00:00:55', NULL),
(16, 1, 10, NULL, 0, '2025-01-04', 1, '2025-01-04 00:00:55', NULL),
(17, 1, 9, 'Gree AC G-405 Fan is not working', 0, '2025-01-04', 1, '2025-01-04 00:04:18', NULL),
(18, 1, 10, 'Line is broaken', 0, '2025-01-04', 1, '2025-01-04 00:04:18', NULL),
(19, 1, 11, NULL, 1, '2025-01-04', 1, '2025-01-04 00:04:18', NULL),
(20, 1, 12, NULL, 1, '2025-01-04', 1, '2025-01-04 00:04:18', NULL),
(21, 1, 9, 'Gree AC G-405 Fan is not working', 0, '2025-01-05', 1, '2025-01-05 04:32:30', NULL),
(22, 1, 10, 'Gree AC G-405', 0, '2025-01-05', 1, '2025-01-05 04:32:30', NULL),
(23, 1, 11, NULL, 1, '2025-01-05', 1, '2025-01-05 04:32:30', NULL),
(24, 1, 12, NULL, 1, '2025-01-05', 1, '2025-01-05 04:32:30', NULL),
(25, 1, 11, NULL, 1, '2025-01-05', 1, '2025-01-05 06:43:47', NULL),
(26, 1, 9, NULL, 0, '2025-01-05', 1, '2025-01-05 06:43:47', NULL),
(27, 1, 12, NULL, 1, '2025-01-05', 1, '2025-01-05 06:43:47', NULL),
(28, 1, 10, NULL, 0, '2025-01-05', 1, '2025-01-05 06:43:47', NULL),
(29, 8, 1, NULL, 1, '2025-01-05', 2, '2025-01-05 06:46:25', NULL),
(30, 8, 4, NULL, 1, '2025-01-05', 2, '2025-01-05 06:46:25', NULL),
(31, 8, 6, NULL, 1, '2025-01-05', 2, '2025-01-05 06:46:25', NULL),
(32, 8, 8, NULL, 1, '2025-01-05', 2, '2025-01-05 06:46:25', NULL),
(33, 8, 1, 'Charging Port is broken', 0, '2025-01-05', 2, '2025-01-05 06:48:03', NULL),
(34, 8, 4, NULL, 1, '2025-01-05', 2, '2025-01-05 06:48:03', NULL),
(35, 8, 6, NULL, 1, '2025-01-05', 2, '2025-01-05 06:48:03', NULL),
(36, 8, 8, NULL, 1, '2025-01-05', 2, '2025-01-05 06:48:03', NULL),
(37, 1, 11, NULL, 1, '2025-01-05', 1, '2025-01-04 20:20:25', NULL),
(38, 1, 9, NULL, 0, '2025-01-05', 1, '2025-01-04 20:20:25', NULL),
(39, 1, 12, NULL, 1, '2025-01-05', 1, '2025-01-04 20:20:25', NULL),
(40, 1, 10, NULL, 0, '2025-01-05', 1, '2025-01-04 20:20:25', NULL),
(41, 8, 1, NULL, 0, '2025-01-07', 2, '2025-01-06 20:05:31', NULL),
(42, 8, 4, NULL, 1, '2025-01-07', 2, '2025-01-06 20:05:31', NULL),
(43, 8, 6, NULL, 1, '2025-01-07', 2, '2025-01-06 20:05:31', NULL),
(44, 8, 8, NULL, 1, '2025-01-07', 2, '2025-01-06 20:05:31', NULL),
(45, 1, 11, NULL, 1, '2025-01-11', 1, '2025-01-11 05:02:00', NULL),
(46, 1, 9, NULL, 0, '2025-01-11', 1, '2025-01-11 05:02:00', NULL),
(47, 1, 12, NULL, 1, '2025-01-11', 1, '2025-01-11 05:02:00', NULL),
(48, 1, 10, NULL, 0, '2025-01-11', 1, '2025-01-11 05:02:00', NULL),
(49, 2, 2, NULL, 1, '2025-01-11', 3, '2025-01-10 23:56:59', NULL),
(50, 2, 3, NULL, 1, '2025-01-11', 3, '2025-01-10 23:56:59', NULL),
(51, 2, 5, NULL, 1, '2025-01-11', 3, '2025-01-10 23:56:59', NULL),
(52, 2, 7, NULL, 1, '2025-01-11', 3, '2025-01-10 23:56:59', NULL),
(53, 8, 4, NULL, 1, '2025-01-11', 2, '2025-01-10 23:59:29', NULL),
(54, 8, 6, NULL, 1, '2025-01-11', 2, '2025-01-10 23:59:29', NULL),
(55, 8, 8, NULL, 1, '2025-01-11', 2, '2025-01-10 23:59:29', NULL),
(56, 2, 2, NULL, 1, '2025-01-11', 3, '2025-01-11 00:01:36', NULL),
(57, 2, 3, NULL, 1, '2025-01-11', 3, '2025-01-11 00:01:36', NULL),
(58, 2, 5, NULL, 1, '2025-01-11', 3, '2025-01-11 00:01:36', NULL),
(59, 2, 7, NULL, 1, '2025-01-11', 3, '2025-01-11 00:01:36', NULL),
(60, 2, 1, NULL, 0, '2025-01-11', 3, '2025-01-11 00:01:36', NULL),
(77, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-15 23:45:25', NULL),
(78, 8, 8, 'Speaker wire is broken.', 0, '2025-01-16', 2, '2025-01-15 23:45:25', NULL),
(79, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-15 23:45:46', NULL),
(80, 8, 8, 'Speaker wire is broken.', 0, '2025-01-16', 2, '2025-01-15 23:45:46', NULL),
(81, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-15 23:45:59', NULL),
(82, 8, 8, 'Speaker wire is broken.', 1, '2025-01-16', 2, '2025-01-15 23:45:59', NULL),
(83, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-15 23:46:07', NULL),
(84, 8, 8, 'Speaker wire is broken.', 0, '2025-01-16', 2, '2025-01-15 23:46:07', NULL),
(85, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-15 23:46:13', NULL),
(86, 8, 8, 'Speaker wire is broken.', 1, '2025-01-16', 2, '2025-01-15 23:46:13', NULL),
(87, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-15 23:46:34', NULL),
(88, 8, 8, 'Speaker wire is broken.', 0, '2025-01-16', 2, '2025-01-15 23:46:34', NULL),
(89, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-15 23:46:55', NULL),
(90, 8, 8, 'Speaker wire is broken.', 1, '2025-01-16', 2, '2025-01-15 23:46:55', NULL),
(91, 8, 6, NULL, 1, '1900-01-16', 2, '2025-01-16 00:06:29', NULL),
(92, 8, 8, 'Speaker wire is broken.', 0, '1900-01-16', 2, '2025-01-16 00:06:29', NULL),
(93, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-16 00:06:48', NULL),
(94, 8, 8, 'Speaker wire is broken.', 0, '2025-01-16', 2, '2025-01-16 00:06:48', NULL),
(95, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-16 00:09:00', NULL),
(96, 8, 8, 'Speaker wire is broken.', 0, '2025-01-16', 2, '2025-01-16 00:09:00', NULL),
(97, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-16 00:09:14', NULL),
(98, 8, 8, 'Speaker wire is broken.', 0, '2025-01-16', 2, '2025-01-16 00:09:14', NULL),
(99, 8, 6, NULL, 1, '2025-01-16', 2, '2025-01-16 00:10:13', NULL),
(100, 8, 8, NULL, 1, '2025-01-16', 2, '2025-01-16 00:10:13', NULL),
(101, 8, 6, NULL, 0, '2025-01-16', 2, '2025-01-16 00:12:45', NULL),
(102, 8, 8, NULL, 1, '2025-01-16', 2, '2025-01-16 00:12:45', NULL),
(103, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:13:37', NULL),
(104, 1, 9, NULL, 0, '2025-01-17', 1, '2025-01-16 19:13:37', NULL),
(105, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:13:37', NULL),
(106, 1, 10, NULL, 0, '2025-01-17', 1, '2025-01-16 19:13:37', NULL),
(107, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:14:27', NULL),
(108, 1, 9, NULL, 0, '2025-01-17', 1, '2025-01-16 19:14:27', NULL),
(109, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:14:27', NULL),
(110, 1, 10, 'Speaker is not working', 0, '2025-01-17', 1, '2025-01-16 19:14:27', NULL),
(111, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:14:48', NULL),
(112, 1, 9, 'Span is not working', 0, '2025-01-17', 1, '2025-01-16 19:14:48', NULL),
(113, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:14:48', NULL),
(114, 1, 10, 'Speaker is not working', 0, '2025-01-17', 1, '2025-01-16 19:14:48', NULL),
(115, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:15:26', NULL),
(116, 1, 9, 'Span is not working', 0, '2025-01-17', 1, '2025-01-16 19:15:26', NULL),
(117, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:15:26', NULL),
(118, 1, 10, 'Speaker is not working', 0, '2025-01-17', 1, '2025-01-16 19:15:26', NULL),
(119, 1, 11, 'fsdfkslfkslfsdf', 1, '2025-01-17', 1, '2025-01-16 19:21:22', NULL),
(120, 1, 9, 'Span is not working', 0, '2025-01-17', 1, '2025-01-16 19:21:22', NULL),
(121, 1, 12, 'sdfsdfsdfsdfds', 1, '2025-01-17', 1, '2025-01-16 19:21:22', NULL),
(122, 1, 10, 'Speaker is not working', 0, '2025-01-17', 1, '2025-01-16 19:21:22', NULL),
(123, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:29:53', NULL),
(124, 1, 9, 'Span is not working', 0, '2025-01-17', 1, '2025-01-16 19:29:53', NULL),
(125, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:29:53', NULL),
(126, 1, 10, 'Speaker is not working', 0, '2025-01-17', 1, '2025-01-16 19:29:53', NULL),
(127, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:30:17', NULL),
(128, 1, 9, 'Span is not working', 1, '2025-01-17', 1, '2025-01-16 19:30:17', NULL),
(129, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:30:17', NULL),
(130, 1, 10, NULL, 1, '2025-01-17', 1, '2025-01-16 19:30:17', NULL),
(131, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:30:37', NULL),
(132, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:30:37', NULL),
(133, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:30:37', NULL),
(134, 1, 10, NULL, 1, '2025-01-17', 1, '2025-01-16 19:30:37', NULL),
(135, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:34:57', NULL),
(136, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:34:57', NULL),
(137, 1, 12, 'Hello world how are you', 0, '2025-01-17', 1, '2025-01-16 19:34:57', NULL),
(138, 1, 10, 'It is not working...', 0, '2025-01-17', 1, '2025-01-16 19:34:57', NULL),
(139, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:36:32', NULL),
(140, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:36:32', NULL),
(141, 1, 12, 'Not cooling', 0, '2025-01-17', 1, '2025-01-16 19:36:32', NULL),
(142, 1, 10, 'It is not working...', 0, '2025-01-17', 1, '2025-01-16 19:36:32', NULL),
(143, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:36:39', NULL),
(144, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:36:39', NULL),
(145, 1, 12, 'Not cooling', 0, '2025-01-17', 1, '2025-01-16 19:36:39', NULL),
(146, 1, 10, 'It is not working...', 0, '2025-01-17', 1, '2025-01-16 19:36:39', NULL),
(147, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:36:53', NULL),
(148, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:36:53', NULL),
(149, 1, 12, NULL, 0, '2025-01-17', 1, '2025-01-16 19:36:53', NULL),
(150, 1, 10, 'It is not working...', 0, '2025-01-17', 1, '2025-01-16 19:36:53', NULL),
(151, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:37:26', NULL),
(152, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:37:26', NULL),
(153, 1, 12, 'Not cooling', 0, '2025-01-17', 1, '2025-01-16 19:37:26', NULL),
(154, 1, 10, 'It is not working...', 0, '2025-01-17', 1, '2025-01-16 19:37:26', NULL),
(155, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:37:59', NULL),
(156, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:37:59', NULL),
(157, 1, 12, 'Not cooling', 0, '2025-01-17', 1, '2025-01-16 19:37:59', NULL),
(158, 1, 10, 'It is not working...', 0, '2025-01-17', 1, '2025-01-16 19:37:59', NULL),
(159, 1, 11, NULL, 1, '2025-01-15', 1, '2025-01-16 19:38:15', NULL),
(160, 1, 9, NULL, 1, '2025-01-15', 1, '2025-01-16 19:38:15', NULL),
(161, 1, 12, 'Not cooling', 0, '2025-01-15', 1, '2025-01-16 19:38:15', NULL),
(162, 1, 10, 'It is not working...', 0, '2025-01-15', 1, '2025-01-16 19:38:15', NULL),
(163, 1, 11, NULL, 1, '2025-01-17', 1, '2025-01-16 19:42:41', NULL),
(164, 1, 9, NULL, 1, '2025-01-17', 1, '2025-01-16 19:42:41', NULL),
(165, 1, 12, NULL, 1, '2025-01-17', 1, '2025-01-16 19:42:41', NULL),
(166, 1, 10, NULL, 1, '2025-01-17', 1, '2025-01-16 19:42:41', NULL),
(167, 1, 11, NULL, 1, '2025-01-16', 1, '2025-01-16 19:43:12', NULL),
(168, 1, 9, NULL, 1, '2025-01-16', 1, '2025-01-16 19:43:12', NULL),
(169, 1, 12, NULL, 1, '2025-01-16', 1, '2025-01-16 19:43:12', NULL),
(170, 1, 10, NULL, 1, '2025-01-16', 1, '2025-01-16 19:43:12', NULL),
(171, 1, 11, NULL, 1, '2025-01-16', 1, '2025-01-16 19:45:42', NULL),
(172, 1, 9, NULL, 1, '2025-01-16', 1, '2025-01-16 19:45:42', NULL),
(173, 1, 12, NULL, 1, '2025-01-16', 1, '2025-01-16 19:45:42', NULL),
(174, 1, 10, 'This is not working', 0, '2025-01-16', 1, '2025-01-16 19:45:42', NULL),
(175, 1, 11, NULL, 1, '2025-01-19', 1, '2025-01-18 22:56:59', NULL),
(176, 1, 9, NULL, 1, '2025-01-19', 1, '2025-01-18 22:56:59', NULL),
(177, 1, 12, NULL, 1, '2025-01-19', 1, '2025-01-18 22:56:59', NULL),
(178, 1, 10, 'This is not working', 0, '2025-01-19', 1, '2025-01-18 22:56:59', NULL),
(179, 8, 6, NULL, 0, '2025-01-19', 2, '2025-01-18 22:57:21', NULL),
(180, 8, 8, NULL, 1, '2025-01-19', 2, '2025-01-18 22:57:21', NULL),
(181, 8, 12, 'Compressor Damange', 0, '2025-01-28', 2, '2025-01-27 19:48:11', NULL),
(182, 8, 11, NULL, 1, '2025-01-28', 2, '2025-01-27 19:48:11', NULL),
(183, 8, 9, NULL, 1, '2025-01-28', 2, '2025-01-27 19:48:11', NULL),
(184, 8, 11, NULL, 1, '2025-01-28', 2, '2025-01-27 19:51:04', NULL),
(185, 8, 9, NULL, 1, '2025-01-28', 2, '2025-01-27 19:51:04', NULL),
(186, 1, 10, 'This is not working', 0, '2025-01-28', 1, '2025-01-27 21:59:33', NULL),
(187, 1, 2, NULL, 1, '2025-01-28', 1, '2025-01-27 21:59:33', NULL),
(188, 1, 10, 'This is not working', 0, '2025-01-27', 1, '2025-01-27 21:59:42', NULL),
(189, 1, 2, NULL, 1, '2025-01-27', 1, '2025-01-27 21:59:42', NULL),
(190, 1, 10, 'This is not working', 0, '2025-01-26', 1, '2025-01-27 21:59:50', NULL),
(191, 1, 2, NULL, 1, '2025-01-26', 1, '2025-01-27 21:59:50', NULL),
(192, 1, 10, 'This is not working', 0, '2025-01-24', 1, '2025-01-27 22:00:29', NULL),
(193, 1, 2, NULL, 1, '2025-01-24', 1, '2025-01-27 22:00:29', NULL),
(194, 1, 10, NULL, 1, '2025-01-28', 1, '2025-01-27 22:01:08', NULL),
(195, 1, 2, NULL, 1, '2025-01-28', 1, '2025-01-27 22:01:08', NULL),
(196, 1, 10, NULL, 1, '2025-01-29', 1, '2025-01-27 22:01:29', NULL),
(197, 1, 2, NULL, 1, '2025-01-29', 1, '2025-01-27 22:01:29', NULL),
(198, 1, 10, NULL, 1, '2025-01-30', 1, '2025-01-27 22:01:44', NULL),
(199, 1, 2, NULL, 1, '2025-01-30', 1, '2025-01-27 22:01:44', NULL),
(200, 1, 10, 'This Should Be Come', 0, '2025-01-31', 1, '2025-01-27 22:02:05', NULL),
(201, 1, 2, NULL, 1, '2025-01-31', 1, '2025-01-27 22:02:05', NULL),
(202, 1, 10, 'Line is broken', 0, '2025-02-01', 1, '2025-01-27 22:02:43', NULL),
(203, 1, 2, NULL, 1, '2025-02-01', 1, '2025-01-27 22:02:43', NULL),
(204, 1, 10, 'Line is broken', 0, '2025-01-28', 1, '2025-01-27 22:03:00', NULL),
(205, 1, 2, 'This Should Be Come', 0, '2025-01-28', 1, '2025-01-27 22:03:00', NULL),
(206, 1, 10, 'Line is broken', 0, '2025-02-01', 1, '2025-01-27 22:03:21', NULL),
(207, 1, 2, 'SSD is damaged', 0, '2025-02-01', 1, '2025-01-27 22:03:21', NULL),
(208, 1, 10, 'Line is broken', 0, '2025-01-28', 1, '2025-01-27 23:18:04', NULL),
(209, 1, 2, 'SSD is damaged', 0, '2025-01-28', 1, '2025-01-27 23:18:04', NULL),
(210, 1, 10, 'Line is broken', 0, '2025-02-07', 1, '2025-01-27 23:18:15', NULL),
(211, 1, 2, 'SSD is damaged', 0, '2025-02-07', 1, '2025-01-27 23:18:15', NULL),
(212, 1, 10, 'Line is broken', 0, '2025-02-08', 1, '2025-01-27 23:18:29', NULL),
(213, 1, 2, 'SSD is damaged', 0, '2025-02-08', 1, '2025-01-27 23:18:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_status_temps`
--

CREATE TABLE `asset_status_temps` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint NOT NULL,
  `asset_id` bigint NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_okay` tinyint NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  `created_by_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_transfers`
--

CREATE TABLE `asset_transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `from_branch_id` int NOT NULL,
  `to_branch_id` int NOT NULL,
  `asset_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=panding,1=received/done,2=cancelled',
  `date` date NOT NULL,
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_transfers`
--

INSERT INTO `asset_transfers` (`id`, `from_branch_id`, `to_branch_id`, `asset_id`, `status`, `date`, `created_by_id`, `updated_by_id`, `created_at`, `updated_at`) VALUES
(1, 8, 2, 4, 1, '2025-01-11', 2, 3, '2025-01-11 10:09:48', '2025-01-11 12:02:40'),
(2, 8, 2, 1, 1, '2025-01-11', 2, 3, '2025-01-11 10:09:48', '2025-01-11 11:58:46'),
(3, 8, 2, 6, 1, '2025-01-19', 2, 1, '2025-01-19 11:23:52', '2025-01-19 11:34:10'),
(4, 8, 2, 8, 1, '2025-01-19', 2, 1, '2025-01-19 11:23:52', '2025-01-19 11:34:21'),
(5, 1, 8, 11, 1, '2025-01-20', 1, 2, '2025-01-20 11:23:40', '2025-01-20 11:29:08'),
(6, 8, 1, 11, 1, '2025-01-20', 2, 1, '2025-01-20 11:32:05', '2025-01-20 11:32:50'),
(7, 1, 8, 12, 1, '2025-01-20', 1, 2, '2025-01-20 11:38:19', '2025-01-20 11:40:01'),
(8, 1, 8, 11, 1, '2025-01-20', 1, 2, '2025-01-20 11:38:19', '2025-01-20 11:40:04'),
(9, 1, 8, 9, 1, '2025-01-20', 1, 2, '2025-01-20 11:38:19', '2025-01-20 11:40:07'),
(10, 2, 1, 2, 1, '2025-01-28', 3, 1, '2025-01-28 06:11:41', '2025-01-28 06:12:01'),
(11, 2, 1, 6, 0, '2025-01-28', 3, NULL, '2025-01-28 06:11:41', '2025-01-28 06:11:41'),
(12, 2, 1, 8, 0, '2025-01-28', 3, NULL, '2025-01-28 06:11:41', '2025-01-28 06:11:41'),
(13, 8, 1, 12, 0, '2025-01-28', 2, NULL, '2025-01-28 07:49:07', '2025-01-28 07:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `assign_assets`
--

CREATE TABLE `assign_assets` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` int NOT NULL,
  `asset_id` int NOT NULL,
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `date` date NOT NULL,
  `in_branch` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_assets`
--

INSERT INTO `assign_assets` (`id`, `branch_id`, `asset_id`, `created_by_id`, `updated_by_id`, `date`, `in_branch`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 1, 3, '2024-12-29', 0, '2024-12-29 05:52:18', '2025-01-11 11:58:46'),
(2, 2, 2, 1, 3, '2024-12-29', 0, '2024-12-29 05:57:59', '2025-01-28 06:11:41'),
(3, 8, 4, 1, 3, '2024-12-29', 0, '2024-12-29 05:58:30', '2025-01-11 12:02:40'),
(4, 2, 3, 1, NULL, '2024-12-29', 1, '2024-12-29 09:29:20', '2024-12-29 09:29:20'),
(5, 2, 5, 1, NULL, '2025-01-01', 1, '2025-01-01 09:58:32', '2025-01-01 09:58:32'),
(6, 8, 6, 1, NULL, '2025-01-01', 0, '2025-01-01 10:03:38', '2025-01-19 11:23:52'),
(7, 2, 7, 1, NULL, '2025-01-01', 1, '2025-01-01 10:03:51', '2025-01-01 10:03:51'),
(8, 8, 8, 1, NULL, '2025-01-01', 0, '2025-01-01 10:04:03', '2025-01-19 11:23:52'),
(9, 1, 11, 1, NULL, '2025-01-04', 0, '2025-01-04 06:07:10', '2025-01-20 11:18:12'),
(10, 1, 9, 1, 1, '2025-01-04', 0, '2025-01-04 06:07:45', '2025-01-20 11:38:19'),
(11, 1, 12, 1, 1, '2025-01-04', 0, '2025-01-04 06:08:04', '2025-01-20 11:38:19'),
(12, 1, 10, 1, NULL, '2025-01-04', 1, '2025-01-04 06:08:14', '2025-01-04 06:08:14'),
(13, 2, 1, 3, NULL, '0000-00-00', 1, '2025-01-11 11:58:46', '2025-01-11 11:58:46'),
(14, 2, 4, 3, NULL, '0000-00-00', 1, '2025-01-11 12:02:40', '2025-01-11 12:02:40'),
(15, 2, 6, 3, 3, '0000-00-00', 0, '2025-01-19 11:34:09', '2025-01-28 06:11:41'),
(16, 2, 8, 3, 3, '0000-00-00', 0, '2025-01-19 11:34:21', '2025-01-28 06:11:41'),
(17, 8, 11, 2, 2, '0000-00-00', 0, '2025-01-20 11:29:08', '2025-01-20 11:32:05'),
(18, 1, 11, 1, 1, '0000-00-00', 0, '2025-01-20 11:32:50', '2025-01-20 11:38:19'),
(19, 8, 12, 2, 2, '0000-00-00', 0, '2025-01-20 11:40:01', '2025-01-28 07:49:07'),
(20, 8, 11, 2, NULL, '0000-00-00', 1, '2025-01-20 11:40:04', '2025-01-20 11:40:04'),
(21, 8, 9, 2, NULL, '0000-00-00', 1, '2025-01-20 11:40:07', '2025-01-20 11:40:07'),
(22, 1, 2, 1, NULL, '0000-00-00', 1, '2025-01-28 06:12:01', '2025-01-28 06:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `basic_infos`
--

CREATE TABLE `basic_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `facebook_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `twitter_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `linkedin_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `youtube_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `assets_value` int NOT NULL,
  `total_employees` int NOT NULL,
  `total_companies` int NOT NULL,
  `start_year` int NOT NULL,
  `map_embed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_embed_1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_embed_2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_embed_3` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_infos`
--

INSERT INTO `basic_infos` (`id`, `title`, `meta_keywords`, `meta_description`, `logo`, `favicon`, `phone`, `telephone`, `fax`, `email`, `location`, `address`, `web_link`, `facebook_link`, `twitter_link`, `linkedin_link`, `youtube_link`, `assets_value`, `total_employees`, `total_companies`, `start_year`, `map_embed`, `video_embed_1`, `video_embed_2`, `video_embed_3`, `created_at`, `updated_at`) VALUES
(1, 'Asset Monitoring System', 'In consequuntur quib', 'Iusto Nam consectetu', 'logo-1734425209.jpg', 'favicon-1734425209.jpg', '+1 (405) 617-2988', '+1 (757) 692-3065', '+1 (343) 205-9606', 'nojo@mailinator.com', 'Velit quia corrupti', 'Dolorem debitis aut', 'Quia atque nostrum q', 'Enim neque culpa ex', 'Deserunt odio cum ad', 'Deserunt in ducimus', 'Obcaecati autem reru', 60, 23, 72, 1993, 'Sit placeat et ut o', 'Vel dolore necessita', 'Consequuntur ex nesc', 'Proident dolore off', NULL, '2025-01-04 04:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_main_branch` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `code`, `title`, `phone`, `address`, `is_main_branch`, `status`, `created_by_id`, `updated_by_id`, `created_at`, `updated_at`) VALUES
(1, '0001', 'Apex - Jamuna Future Park---(A)', '01774813568', 'K/244 Progoti Shoroni,Kuril,Bashundhara Baridhara Jamuna Future Park,Level-3', 1, 1, 1, NULL, '2024-12-22 04:43:37', '2025-01-01 09:54:31'),
(2, '0002', 'Apex - Lakecity, Khilkhet---(C)', '01842084971', 'Kha. 100/2,C Boat Guard Namapara Joar Shara Lakecity Road Khilkhet Dhaka-1229', 0, 1, 1, NULL, '2024-12-22 05:27:11', '2025-01-01 09:55:52'),
(3, '0003', 'Apex - Shahazadpur', '01762629480', 'Pake Villa G/3 Pragati Sarani, Shahajadpur, Dhaka', 0, 1, 1, NULL, '2024-12-22 05:29:47', '2024-12-22 05:34:33'),
(4, '0004', 'Apex - Middle Badda', '01774813567', 'Ga-131/1.Pragati Sarani Midda Badda Dhaka', 0, 1, 1, NULL, '2024-12-22 05:30:16', '2024-12-22 05:34:40'),
(5, '0005', 'Apex - Concord Silvi, Gulshan 1', '01842085033', '75 Gulshan Avenue, Plot-11A, Bir Uttam Mir Shawkat Road. Gulshan Dhaka', 0, 1, 1, NULL, '2024-12-22 05:31:20', '2024-12-22 05:34:49'),
(6, '0006', 'Apex - Ashkona, Dakkhin Khan', '01842085066', 'House :250/1,Rd:Ashkona Main Road Po: Hajjcamp, Ps:Dokkhinkhan', 0, 1, 1, NULL, '2024-12-22 05:31:54', '2024-12-22 05:34:55'),
(7, '0007', 'Apex - Galleria, Banani 11', '01842085073', 'House# 25, Road# 11, Block# F, Banani, Dhaka-1213', 0, 1, 1, NULL, '2024-12-22 05:32:22', '2024-12-22 05:35:06'),
(8, '0008', 'Apex - Banani---(B)', '01733243995', 'House-25, Road-11 ,Block No F, Banani Dhaka.', 0, 1, 1, NULL, '2024-12-22 05:32:47', '2025-01-01 09:54:45'),
(9, '0009', 'Apex - Galleria Gulshan 1', '01842085074', 'Holding No, Swg-2 & 2/A, Road No-5 Bir Uttam Shawkat Ali Road, Gulshan 1 Dhaka 1212', 0, 1, 1, NULL, '2024-12-22 05:33:17', '2024-12-22 05:35:17'),
(10, '0010', 'Apex - Gulshan Avenue', '01842085068', 'Plot# Swg 2/A,Road-05 Bir Uttam Shawkat Ali Sarak Gulshan 1', 0, 1, 1, NULL, '2024-12-22 05:33:45', '2024-12-22 05:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_cat_id` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_cat_id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Computer', NULL, 1, '2024-12-17 09:34:51', '2024-12-17 09:34:51'),
(2, 0, 'Monitor', NULL, 1, '2024-12-17 09:37:29', '2024-12-17 10:56:02'),
(4, 0, 'Printer', NULL, 1, '2024-12-17 11:59:07', '2024-12-17 11:59:07'),
(5, 0, 'Scanner', NULL, 1, '2024-12-17 11:59:15', '2024-12-17 11:59:15'),
(6, 0, 'Others', NULL, 1, '2024-12-17 11:59:27', '2025-01-04 05:52:25'),
(7, 0, 'Fridge', NULL, 1, '2024-12-17 11:59:33', '2025-01-04 05:51:44'),
(8, 1, 'Desktop', NULL, 1, '2024-12-17 12:01:29', '2024-12-28 10:35:18'),
(9, 1, 'Laptop', NULL, 1, '2024-12-17 12:01:45', '2024-12-28 10:35:12'),
(10, 0, 'Telephone', NULL, 1, '2024-12-22 04:39:45', '2025-01-04 05:52:48'),
(11, 0, 'Electronics', NULL, 1, '2024-12-29 09:30:44', '2024-12-29 09:30:44'),
(12, 11, 'Headphone', NULL, 1, '2024-12-29 09:31:01', '2024-12-29 09:31:01'),
(13, 11, 'Speaker', NULL, 1, '2024-12-29 09:31:11', '2024-12-29 09:31:11'),
(14, 11, 'Fan', NULL, 1, '2025-01-04 05:07:33', '2025-01-04 05:07:33'),
(15, 11, 'AC', NULL, 1, '2025-01-04 05:48:55', '2025-01-04 05:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'HR', '2025-01-12 11:24:07', '2025-01-12 11:24:07'),
(2, 'Accounts', '2025-01-12 11:24:32', '2025-01-12 11:24:32'),
(3, 'IT', '2025-01-12 11:24:39', '2025-01-12 11:24:39');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Sales Man', '2025-01-19 18:39:03', '2025-01-19 18:39:03'),
(2, 'AGM', '2025-01-19 18:40:06', '2025-01-19 18:40:49'),
(3, 'HOD', '2025-01-19 18:40:31', '2025-01-19 18:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` int NOT NULL,
  `department_id` int NOT NULL,
  `designation_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `is_user_created` int NOT NULL DEFAULT '0' COMMENT '0=not created, 1=created',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `branch_id`, `department_id`, `designation_id`, `name`, `email`, `contact`, `date_of_birth`, `date_of_joining`, `is_user_created`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'Super Admin', 'admin@gmail.com', '24', '1971-02-06', '2017-06-21', 1, 1, '2025-01-19 19:28:04', '2025-01-19 19:28:04'),
(2, 8, 3, 3, 'Nowab Shorif', 'b@gmail.com', '87', '2008-09-13', '2019-12-19', 1, 1, '2025-01-19 19:35:50', '2025-01-20 06:25:20'),
(3, 2, 3, 3, 'Alexander Reed', 'c@gmail.com', '22', '1996-06-07', '1989-10-09', 1, 1, '2025-01-20 03:38:28', '2025-01-20 04:49:33'),
(4, 1, 3, 1, 'Malek Azad', 'malek@gmail.com', '91', '1996-12-12', '2024-08-05', 1, 1, '2025-01-20 03:38:34', '2025-01-20 04:49:16'),
(5, 1, 1, 2, 'Brendan Grimes', 'cyjabimazy@mailinator.com', '65', '1994-10-19', '2012-10-15', 1, 1, '2025-01-20 03:38:40', '2025-01-20 04:49:05'),
(6, 8, 2, 2, 'Kitra Dejesus', 'lypyr@mailinator.com', '21', '1974-04-29', '1983-11-29', 0, 1, '2025-01-20 03:38:57', '2025-01-20 04:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_menus`
--

CREATE TABLE `frontend_menus` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `srln` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_in_menus` tinyint NOT NULL DEFAULT '1',
  `is_in_pages` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `srln` int NOT NULL DEFAULT '1',
  `menu_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `navicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_side_menu` tinyint NOT NULL DEFAULT '0',
  `create_route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `srln`, `menu_name`, `navicon`, `is_side_menu`, `create_route`, `route`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Dashboard', '<i class=\"nav-icon fas fa-tachometer-alt\"></i>', 1, NULL, 'dashboard.index', 1, '2024-10-26 08:56:54', '2024-10-28 04:37:52'),
(2, 0, 2, 'Basic Info', '<i class=\"nav-icon fa-solid fa-gear\"></i>', 1, NULL, 'basic-infos.index', 1, '2024-10-26 09:11:38', '2025-01-04 04:51:57'),
(3, 0, 3, 'Admin Manage', '<i class=\"nav-icon fa-solid fa-users-line\"></i>', 1, NULL, NULL, 1, '2024-10-26 09:16:45', '2024-11-04 04:01:46'),
(4, 3, 1, 'Roles', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'roles.create', 'roles.index', 1, '2024-10-26 09:17:46', '2024-10-27 06:44:02'),
(5, 3, 2, 'Admins', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'admins.create', 'admins.index', 1, '2024-10-26 09:34:05', '2024-10-26 11:40:22'),
(6, 4, 1, 'Add', NULL, 0, NULL, 'roles.create', 1, '2024-10-26 09:37:12', '2024-10-27 11:12:43'),
(7, 4, 2, 'Edit', NULL, 0, NULL, 'roles.edit', 1, '2024-10-26 09:37:49', '2024-10-26 09:37:49'),
(8, 4, 3, 'Delete', NULL, 0, NULL, 'roles.destroy', 1, '2024-10-26 09:38:13', '2024-10-26 09:38:13'),
(9, 5, 1, 'Add', NULL, 0, NULL, 'admins.create', 1, '2024-10-26 09:47:35', '2024-10-27 10:57:28'),
(10, 5, 2, 'Edit', NULL, 0, NULL, 'admins.edit', 1, '2024-10-26 09:47:54', '2024-10-27 07:00:26'),
(11, 5, 3, 'Delete', NULL, 0, NULL, 'admins.destroy', 1, '2024-10-26 09:48:07', '2024-10-27 06:51:02'),
(12, 0, 4, 'Frontend Menus', '<i class=\"nav-icon fas fa-wrench\"></i>', 1, 'frontend-menus.create', 'frontend-menus.index', 0, '2024-10-27 10:13:54', '2024-12-17 08:49:59'),
(13, 0, 5, 'Backend Menus', '<i class=\"nav-icon fas fa-clipboard-list\"></i>', 1, 'menus.create', 'menus.index', 1, '2024-10-27 11:17:41', '2024-11-13 09:14:48'),
(15, 29, 7, 'Category', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'categories.create', 'categories.index', 1, '2024-10-27 12:09:17', '2024-12-17 12:07:20'),
(16, 0, 7, 'Asset', '<i class=\"nav-icon fa fa-desktop\"></i>', 1, 'assets.create', 'assets.index', 1, '2024-10-28 04:25:23', '2024-12-28 09:31:25'),
(17, 29, 8, 'Sub Category', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'sub-categories.create', 'sub-categories.index', 1, '2024-10-28 11:21:04', '2024-12-17 12:07:37'),
(18, 17, 1, 'Add', NULL, 0, NULL, 'products.index', 1, '2024-10-29 12:03:50', '2024-10-31 10:33:53'),
(19, 0, 8, 'Asset Assign', '<i class=\"nav-icon fa fa-tasks\"></i>', 1, 'assign-assets.create', 'assign-assets.index', 1, '2024-10-30 11:33:37', '2025-01-04 06:01:14'),
(20, 35, 1, 'Outgoing Requisition', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, 'transfer-requisitions.create', 'transfer-requisitions.index', 1, '2024-10-30 11:34:25', '2025-01-01 05:06:31'),
(21, 19, 1, 'Add', NULL, 0, NULL, 'service-types.create', 1, '2024-10-31 10:28:22', '2024-10-31 10:31:33'),
(23, 19, 3, 'Delete', NULL, 0, NULL, 'service-types.destroy', 1, '2024-10-31 10:29:54', '2024-10-31 10:31:16'),
(24, 16, 1, 'Add', NULL, 0, NULL, 'assets.create', 1, '2024-10-31 10:32:07', '2024-12-28 10:36:44'),
(25, 16, 2, 'Edit', NULL, 0, NULL, 'assets.edit', 1, '2024-10-31 10:32:22', '2024-12-28 10:36:57'),
(26, 16, 3, 'Delete', NULL, 0, NULL, 'assets.destroy', 1, '2024-10-31 10:32:42', '2024-12-28 10:37:01'),
(27, 17, 2, 'Edit', NULL, 0, NULL, 'products.edit', 1, '2024-10-31 10:34:24', '2024-10-31 10:34:24'),
(28, 17, 3, 'Delete', NULL, 0, NULL, 'products.destroy', 1, '2024-10-31 10:34:46', '2024-10-31 10:34:46'),
(29, 0, 6, 'Category Manage', '<i class=\"nav-icon fa fa-tag\"></i>', 1, NULL, NULL, 1, '2024-11-03 08:16:54', '2024-12-17 12:08:26'),
(30, 0, 10, 'Asset Transfer', '<i class=\"nav-icon fas fa-share-alt\"></i>', 1, NULL, NULL, 1, '2024-11-03 10:01:16', '2025-01-01 06:20:39'),
(31, 30, 1, 'Outgoing', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'assets-transfers.create', 'assets-transfers.outgoing', 1, '2024-11-03 10:02:33', '2025-01-01 06:29:51'),
(32, 30, 2, 'Incoming', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, NULL, 'assets-transfers.incoming', 1, '2024-11-03 10:02:40', '2025-01-01 11:38:15'),
(33, 2, 1, 'Edit', NULL, 0, NULL, 'basic-infos.edit', 1, '2024-11-09 10:07:19', '2024-11-09 10:07:19'),
(34, 43, 1, 'Branch Manage', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'branches.create', 'branches.index', 1, '2024-12-22 04:37:22', '2025-01-12 11:37:55'),
(35, 0, 9, 'Transfer Requisition', '<i class=\"nav-icon fa fa-shipping-fast\"></i>', 1, NULL, NULL, 1, '2024-12-29 10:40:45', '2024-12-29 10:41:25'),
(36, 35, 2, 'Incoming Requisition', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, 'transfer-requisitions.incoming-requisition', 1, '2024-12-29 11:01:41', '2025-01-01 05:06:55'),
(37, 20, 1, 'Add', NULL, 0, NULL, 'transfer-requisitions.create', 1, '2024-12-30 12:04:19', '2024-12-30 12:04:19'),
(38, 20, 2, 'Edit', NULL, 0, NULL, 'transfer-requisitions.edit', 1, '2024-12-30 12:04:54', '2024-12-30 12:04:54'),
(39, 20, 3, 'Delete', NULL, 0, NULL, 'transfer-requisitions.destroy', 1, '2024-12-30 12:05:24', '2024-12-30 12:05:24'),
(40, 0, 11, 'Asset Status', '<i class=\"nav-icon fa fa-check-circle\"></i>', 1, 'assets-statuses.create', 'assets-statuses.index', 1, '2025-01-04 05:01:10', '2025-01-04 05:40:36'),
(41, 40, 1, 'Add', '<i class=\"nav-icon fas fa-check-circle\"></i>', 0, NULL, 'assets-statuses.create', 1, '2025-01-04 06:21:56', '2025-01-04 06:21:56'),
(42, 36, 1, 'Edit', NULL, 0, NULL, 'transfer-requisitions.edit-incoming', 1, '2025-01-06 12:01:59', '2025-01-06 12:01:59'),
(43, 0, 12, 'Employee Manage', '<i class=\"nav-icon fa fa-user-tie\"></i>', 1, NULL, NULL, 1, '2025-01-12 11:17:06', '2025-01-12 11:18:40'),
(44, 43, 1, 'Departments', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'departments.create', 'departments.index', 1, '2025-01-12 11:20:43', '2025-01-12 11:22:11'),
(45, 43, 4, 'Employee', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'employees.create', 'employees.index', 1, '2025-01-12 11:37:35', '2025-01-19 18:31:03'),
(46, 1, 1, 'Total Assets', NULL, 0, NULL, NULL, 1, '2025-01-19 08:34:20', '2025-01-19 08:34:20'),
(47, 1, 2, 'Good & Running', NULL, 0, NULL, NULL, 1, '2025-01-19 08:34:37', '2025-01-19 08:34:37'),
(48, 1, 3, 'Bad & Damaged', NULL, 0, NULL, NULL, 1, '2025-01-19 08:34:50', '2025-01-19 08:34:50'),
(49, 1, 4, 'In transit', NULL, 0, NULL, NULL, 1, '2025-01-19 08:35:06', '2025-01-19 08:35:06'),
(50, 1, 5, 'Asset List', NULL, 0, NULL, NULL, 1, '2025-01-19 09:07:13', '2025-01-19 09:07:13'),
(51, 43, 3, 'Designation', '<i class=\"far fa-dot-circle nav-icon\"></i>', 1, 'designations.create', 'designations.index', 1, '2025-01-19 18:29:53', '2025-01-19 18:32:16'),
(52, 0, 13, 'All Reports', '<i class=\"nav-icon fas fa-file-alt\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:26:54', '2025-01-29 04:27:25'),
(53, 52, 1, 'Asset Inventory', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, 'asset-innventory.assetInventoryIndex', 1, '2025-01-29 04:29:32', '2025-01-29 08:34:26'),
(54, 52, 2, 'Asset Performance', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:30:09', '2025-01-29 04:31:39'),
(55, 52, 3, 'Maintenance Schedule', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:30:44', '2025-01-29 04:31:21'),
(56, 52, 4, 'Asset Utilization', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:33:07', '2025-01-29 04:34:16'),
(57, 52, 5, 'Asset Depreciation', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:36:00', '2025-01-29 04:36:00'),
(58, 52, 6, 'Incident Report', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:36:22', '2025-01-29 04:36:22'),
(59, 52, 7, 'Asset Location', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:36:39', '2025-01-29 04:36:39'),
(60, 52, 8, 'Warranty Expiry', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:36:58', '2025-01-29 04:39:33'),
(61, 52, 9, 'Procurement History', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:37:22', '2025-01-29 04:37:22'),
(62, 52, 10, 'Compliance', '<i class=\"nav-icon far fa-dot-circle\"></i>', 1, NULL, NULL, 1, '2025-01-29 04:37:43', '2025-01-29 04:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 2),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(4, '2014_10_12_000000_create_users_table', 4),
(5, '2024_01_30_123321_create_roles_table', 5),
(6, '2024_01_30_123933_create_privileges_table', 6),
(8, '2023_12_26_114309_create_admins_table', 7),
(9, '2023_10_21_001204_create_basic_infos_table', 8),
(11, '2024_01_30_140322_create_menus_table', 9),
(13, '2024_10_26_114524_create_frontend_menus_table', 10),
(17, '2024_10_29_111249_create_galleries_table', 12),
(18, '2024_10_30_143258_create_service_types_table', 13),
(23, '2024_10_30_144304_create_services_table', 14),
(27, '2024_10_31_151502_create_products_table', 15),
(28, '2024_10_31_173528_create_companies_table', 16),
(29, '2024_10_29_091121_create_sliders_table', 17),
(30, '2024_11_03_155721_create_blog_categories_table', 18),
(31, '2024_11_03_162934_create_blogs_table', 19),
(32, '2024_11_18_112031_create_messages_table', 20),
(33, '2023_12_13_144516_create_categories_table', 21),
(34, '2024_12_22_100832_create_branches_table', 22),
(37, '2024_12_28_110325_create_assets_table', 23),
(38, '2024_12_28_172113_create_assign_assets_table', 24),
(45, '2024_12_29_154950_create_transfer_requisitions_table', 25),
(46, '2024_12_29_155541_create_requisition_details_table', 25),
(48, '2025_01_01_114048_create_asset_transfers_table', 26),
(49, '2025_01_04_104709_create_asset_statuses_table', 27),
(50, '2024_05_06_145650_create_departments_table', 28),
(53, '2025_01_16_100435_create_asset_status_temps_table', 30),
(54, '2024_05_06_120259_create_designations_table', 31),
(56, '2024_05_06_143612_create_employees_table', 32);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(71, 3, 1, '2024-12-30 10:53:51', '2024-12-30 10:53:51'),
(72, 3, 35, '2024-12-30 10:53:51', '2024-12-30 10:53:51'),
(73, 3, 20, '2024-12-30 10:53:51', '2024-12-30 10:53:51'),
(74, 3, 36, '2024-12-30 10:53:51', '2024-12-30 10:53:51'),
(297, 8, 1, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(298, 8, 46, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(299, 8, 47, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(300, 8, 48, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(301, 8, 49, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(302, 8, 50, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(303, 8, 16, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(304, 8, 35, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(305, 8, 20, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(306, 8, 37, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(307, 8, 38, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(308, 8, 39, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(309, 8, 36, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(310, 8, 42, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(311, 8, 30, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(312, 8, 31, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(313, 8, 32, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(314, 8, 40, '2025-01-19 10:10:00', '2025-01-19 10:10:00'),
(315, 8, 41, '2025-01-19 10:10:00', '2025-01-19 10:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `requisition_details`
--

CREATE TABLE `requisition_details` (
  `id` bigint UNSIGNED NOT NULL,
  `requisition_id` int NOT NULL,
  `category_id` int NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requisition_details`
--

INSERT INTO `requisition_details` (`id`, `requisition_id`, `category_id`, `quantity`, `created_at`, `updated_at`) VALUES
(3, 1, 8, 1, '2025-01-11 05:15:33', '2025-01-11 05:15:33'),
(4, 1, 9, 1, '2025-01-11 05:15:33', '2025-01-11 05:15:33'),
(5, 2, 12, 1, '2025-01-11 05:34:57', '2025-01-11 05:34:57'),
(6, 2, 13, 1, '2025-01-11 05:34:57', '2025-01-11 05:34:57'),
(7, 3, 7, 2, '2025-01-11 08:34:50', '2025-01-11 08:34:50'),
(8, 3, 15, 1, '2025-01-11 08:34:50', '2025-01-11 08:34:50'),
(9, 4, 9, 1, '2025-01-28 06:05:44', '2025-01-28 06:05:44'),
(10, 4, 12, 1, '2025-01-28 06:05:44', '2025-01-28 06:05:44'),
(11, 4, 13, 1, '2025-01-28 06:05:44', '2025-01-28 06:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `is_superadmin` tinyint NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `is_superadmin`, `created_by`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Super Admin', '2024-08-31 07:03:44', '2024-08-31 07:03:44'),
(3, 0, 1, 'General Manager', '2024-08-31 07:43:20', '2024-10-27 09:48:02'),
(8, 0, 1, 'Branch Manager', '2024-10-27 09:39:31', '2024-12-30 10:40:18');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_requisitions`
--

CREATE TABLE `transfer_requisitions` (
  `id` bigint UNSIGNED NOT NULL,
  `tr_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `by_branch_id` int NOT NULL,
  `from_branch_id` int NOT NULL,
  `to_branch_id` int NOT NULL,
  `date` date NOT NULL,
  `creator_branch_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_branch_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `from_branch_created_by_id` int DEFAULT NULL,
  `from_branch_updated_by_id` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=pending, 1=Approved, 2=cancel, 3=back to corrections,\r\n4=done',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfer_requisitions`
--

INSERT INTO `transfer_requisitions` (`id`, `tr_no`, `by_branch_id`, `from_branch_id`, `to_branch_id`, `date`, `creator_branch_remarks`, `receiver_branch_remarks`, `created_by_id`, `updated_by_id`, `from_branch_created_by_id`, `from_branch_updated_by_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '0000001', 1, 8, 2, '2025-01-11', 'Send these items in emergency', 'Please wait. It will take at least 2 days.', 1, 1, NULL, 2, 4, '2025-01-11 05:13:17', '2025-01-11 10:09:48'),
(2, '0000002', 1, 8, 2, '2025-01-11', NULL, NULL, 1, NULL, NULL, 2, 4, '2025-01-11 05:34:57', '2025-01-19 11:23:52'),
(3, '0000003', 1, 1, 2, '2025-01-11', NULL, NULL, 1, NULL, NULL, 1, 4, '2025-01-11 08:34:50', '2025-01-20 11:38:19'),
(4, '0000004', 2, 2, 1, '2025-01-28', NULL, NULL, 3, NULL, NULL, 1, 4, '2025-01-28 06:05:44', '2025-01-28 06:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_code_unique` (`code`);

--
-- Indexes for table `asset_statuses`
--
ALTER TABLE `asset_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_status_temps`
--
ALTER TABLE `asset_status_temps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_transfers`
--
ALTER TABLE `asset_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_assets`
--
ALTER TABLE `assign_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_infos`
--
ALTER TABLE `basic_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_code_unique` (`code`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `frontend_menus`
--
ALTER TABLE `frontend_menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `frontend_menus_slug_unique` (`slug`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
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
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requisition_details`
--
ALTER TABLE `requisition_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_requisitions`
--
ALTER TABLE `transfer_requisitions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tr_no` (`tr_no`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `asset_statuses`
--
ALTER TABLE `asset_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `asset_status_temps`
--
ALTER TABLE `asset_status_temps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=794;

--
-- AUTO_INCREMENT for table `asset_transfers`
--
ALTER TABLE `asset_transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `assign_assets`
--
ALTER TABLE `assign_assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `basic_infos`
--
ALTER TABLE `basic_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_menus`
--
ALTER TABLE `frontend_menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- AUTO_INCREMENT for table `requisition_details`
--
ALTER TABLE `requisition_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transfer_requisitions`
--
ALTER TABLE `transfer_requisitions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
