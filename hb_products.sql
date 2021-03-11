-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 09, 2021 at 07:40 PM
-- Server version: 5.7.33-0ubuntu0.18.04.1
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hb_products`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `status`) VALUES
(1, 'tv', 'active'),
(2, 'ac', 'active'),
(3, 'fan', 'active'),
(4, 'mobile', 'active'),
(5, 'Electronics', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `status` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `code`, `product_price`, `quantity`, `category_id`, `rating`, `status`) VALUES
(4, 'apple', '', '40000', '', 1, '3', 'no'),
(10, 'hitech tv', '', '12000', '12', 2, '2.5', 'yes'),
(11, 'godrej', '', '220000', '14', 3, '1', 'no'),
(14, 'boash', '', '26000', '19', 3, '3', 'yes'),
(19, 'godrej', '', '29000', '16', 4, '4', 'no'),
(23, 'havels fan', '', '3500', '200', 5, '5', 'no'),
(29, 'honor9', '', '19000', '', 1, '3.6', 'yes'),
(50, 'haier', 'haier_ac', '24000', '', 4, '3.6', 'yes'),
(51, 'samsung', 'samsung_machine', '25000', '', 4, '3.6', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `gender`, `mobile`, `password`, `dob`, `date_time`, `status`) VALUES
(3, 'ramesh', 'ramesh.kreddi@gmail.com', 'male', '9848845035', '8df889240644c267cbec33e644229015', '20/04 /1993', '2021-02-02 14:10:27', '1'),
(12, 'raju', 'raju@gmail.com', 'male', '98488456035', '4b5ba10870c4b63ddc5233864beeaf7b', '2021-02-03', '2021-02-02 14:25:02', '1'),
(13, 'ram', 'ram@gmail.com', 'male', '985462170', '7a16e4fc701b0e9c8e73429ce68cd06c', '2021-02-09', '2021-02-02 14:32:41', '1'),
(15, 'ramesh k', 'ramesh.kreddi@gmail.com', 'male', '9848845036', 'ddfe07856e786d673f34e3da56697231', '1993-04-20', '2021-02-09 14:55:55', '0'),
(17, 'ramesh', 'ramesh.kreddi1@gmail.com', 'male', '9848845035', 'ddfe07856e786d673f34e3da56697231', '1993-04-20', '2021-02-09 18:21:33', '0'),
(18, 'ramesh', 'ramesh.kreddi2@gmail.com', 'male', '9848845035', 'ddfe07856e786d673f34e3da56697231', '1993-04-20', '2021-02-09 18:23:43', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
