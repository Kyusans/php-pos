-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 12:03 PM
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
-- Database: `dbpos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beginning_balance`
--

CREATE TABLE `tbl_beginning_balance` (
  `beginning_balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_beginning_balance`
--

INSERT INTO `tbl_beginning_balance` (`beginning_balance`) VALUES
(2000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `prod_id` int(11) NOT NULL COMMENT 'Barcode ni',
  `prod_name` varchar(100) NOT NULL,
  `prod_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`prod_id`, `prod_name`, `prod_price`) VALUES
(1001, 'Rice', 40),
(1002, 'Bread', 50),
(1003, 'Sugar', 50),
(1004, 'Salt', 20),
(1005, 'Flour', 45),
(1006, 'Oil', 12),
(1007, 'Coffee', 18),
(1008, 'Soy', 25),
(1009, 'Eggs', 6),
(1010, 'Garlic', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales`
--

CREATE TABLE `tbl_sales` (
  `sale_id` int(11) NOT NULL,
  `sale_userId` int(11) NOT NULL,
  `sale_cashTendered` int(11) NOT NULL,
  `sale_change` int(11) NOT NULL,
  `sale_totalAmount` int(11) NOT NULL,
  `sale_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sales`
--

INSERT INTO `tbl_sales` (`sale_id`, `sale_userId`, `sale_cashTendered`, `sale_change`, `sale_totalAmount`, `sale_date`) VALUES
(15, 1, 1000, 1000, 10000, '2024-07-03 16:11:20'),
(16, 1, 1000, 1000, 10000, '2024-07-30 16:11:21'),
(17, 1, 1000, 1000, 1000, '2024-07-23 16:11:21'),
(18, 2, 2000, 2000, 2000, '2024-07-10 17:03:50'),
(19, 2, 2000, 2000, 2000, '2024-07-15 17:03:51'),
(20, 3, 2000, 2000, 2000, '2024-07-29 17:03:54'),
(21, 2, 2341, 1234, 123, '2024-08-07 17:45:52'),
(22, 2, 2341, 1234, 12311, '2024-08-08 17:45:53'),
(23, 2, 2341, 1234, 12333, '2024-08-09 17:45:53'),
(24, 2, 2341, 1234, 123, '2024-08-06 17:45:53'),
(25, 2, 2341, 1234, 123, '2024-08-06 17:45:54'),
(26, 2, 2341, 1234, 1123, '2024-08-06 17:49:45'),
(27, 2, 2341, 1234, 12333, '2024-08-06 18:55:44'),
(28, 2, 2341, 1234, 123, '2024-08-06 19:10:01'),
(29, 2, 2341, 1234, 123, '2024-08-06 19:10:07'),
(30, 2, 2341, 1234, 1233, '2024-08-06 19:10:12'),
(31, 2, 2341, 1234, 123, '2024-08-06 19:10:15'),
(32, 2, 2341, 1234, 123, '2024-08-06 19:10:20'),
(33, 2, 2341, 1234, 123, '2024-08-06 19:10:24'),
(34, 2, 2341, 1234, 123, '2024-08-06 19:10:29'),
(35, 2, 2341, 1234, 123, '2024-08-06 19:16:57'),
(36, 2, 2341, 1234, 123, '2024-08-06 19:16:58'),
(37, 2, 2341, 1234, 123, '2024-08-06 19:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_item`
--

CREATE TABLE `tbl_sale_item` (
  `sale_item_id` int(11) NOT NULL,
  `sale_item_saleId` int(11) NOT NULL,
  `sale_item_productId` int(11) NOT NULL COMMENT 'Barcode ni',
  `sale_item_quantity` int(11) NOT NULL,
  `sale_item_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sale_item`
--

INSERT INTO `tbl_sale_item` (`sale_item_id`, `sale_item_saleId`, `sale_item_productId`, `sale_item_quantity`, `sale_item_price`) VALUES
(28, 15, 1001, 10, 1000),
(29, 15, 1002, 10, 1000),
(30, 16, 1001, 10, 1000),
(31, 16, 1002, 10, 1000),
(32, 17, 1001, 10, 1000),
(33, 17, 1002, 10, 1000),
(34, 18, 1001, 10, 1000),
(35, 18, 1002, 10, 1000),
(36, 19, 1001, 10, 1000),
(37, 19, 1002, 10, 1000),
(38, 20, 1001, 10, 1000),
(39, 20, 1002, 10, 1000),
(40, 21, 1003, 2, 123123),
(41, 21, 1002, 10, 1000),
(42, 22, 1003, 2, 123123),
(43, 22, 1002, 10, 1000),
(44, 23, 1003, 2, 123123),
(45, 23, 1002, 10, 1000),
(46, 24, 1003, 2, 123123),
(47, 24, 1002, 10, 1000),
(48, 25, 1003, 2, 123123),
(49, 25, 1002, 10, 1000),
(50, 26, 1003, 2, 123123),
(51, 26, 1002, 10, 1000),
(52, 27, 1001, 50, 123123),
(53, 27, 1002, 10, 1000),
(54, 28, 1004, 50, 123123),
(55, 28, 1002, 10, 1000),
(56, 29, 1005, 50, 123123),
(57, 29, 1002, 10, 1000),
(58, 30, 1006, 50, 123123),
(59, 30, 1002, 10, 1000),
(60, 31, 1007, 700, 123123),
(61, 31, 1002, 10, 1000),
(62, 32, 1008, 50, 123123),
(63, 32, 1002, 10, 1000),
(64, 33, 1009, 50, 123123),
(65, 33, 1002, 10, 1000),
(66, 34, 1010, 50, 123123),
(67, 34, 1002, 10, 1000),
(68, 35, 1010, 50, 123123),
(69, 35, 1002, 10, 1000),
(70, 36, 1010, 50, 123123),
(71, 36, 1002, 10, 1000),
(72, 37, 1010, 50, 123123),
(73, 37, 1002, 10, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_fullName` varchar(100) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_contactNumber` varchar(50) NOT NULL,
  `user_level` varchar(50) NOT NULL DEFAULT '90'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_username`, `user_password`, `user_fullName`, `user_email`, `user_contactNumber`, `user_level`) VALUES
(1, 'admin', 'admin', 'POS ADMINISTRATOR', 'admin@gmail.com', '09690364687', 'admin'),
(2, 'pitok', 'pitok', 'Pitok Batolata', 'pitok@gmail.com', '09010152687', 'user'),
(3, 'joe', 'joe', 'Joe Rogan', 'joe@gmail.com', '09675883549', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `tbl_sale_item`
--
ALTER TABLE `tbl_sale_item`
  ADD PRIMARY KEY (`sale_item_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_sale_item`
--
ALTER TABLE `tbl_sale_item`
  MODIFY `sale_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
