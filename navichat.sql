-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 07:33 AM
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
-- Database: `navichat`
--
CREATE DATABASE IF NOT EXISTS `navichat` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `navichat`;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `title` varchar(100) NOT NULL,
  `details` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`title`, `details`) VALUES
('Is NaviChat easy to use?', 'Our design is user friendly and all controlled in the user dashboard convieneintly.'),
('Is NaviChat Effective?', 'Yes as shown in our reviews many of our customers have seen a significant increase in customer retention and sales.'),
('What are the benefits of NaviChat?', 'Increase customer satisfaction: NaviBot analyzes customer questions and delivers human-like answers in seconds. This enables your customers to receive the information they need 24/7, increasing their ');

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE `pricing` (
  `tier` varchar(20) NOT NULL,
  `price` varchar(20) NOT NULL,
  `features` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`tier`, `price`, `features`) VALUES
('premium', '59 /mo', 'Chatbot API'),
('starter', '29 /mo', 'Chatbot API');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `review` varchar(200) NOT NULL,
  `reviewer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`review`, `reviewer`) VALUES
('After using this chatbot service for my business my sales leads has went up significantly!', 'Jamie, Founder of SlappyCakes'),
('I used to be overwhelmed with customer enquries but now all quieres are answered promptly and customers are satisfied!', 'Sophie, Customer Service Agent at Beds&Pillows');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(20) NOT NULL,
  `company` varchar(100) NOT NULL,
  `access` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `name`, `password`, `phone`, `company`, `access`) VALUES
('admin', 'admin', '$2y$10$3FoWDbomqvc7Ao5hT3mNSuw', 0, 'navichat', 4),
('bryden@box.com', 'bryden', '$2y$10$ISMGjoaYzKZXaxEI5du9D.vfu.SkpFA.bTILxG8eiMO/MQ0Kgd51K', 2147483647, 'hi5', 1),
('cdshop@business.com', 'Carl Goodwill', '$2y$10$NGkAJvmGVPrdh/GYdTtkNO5', 82353535, 'cdshop', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `pricing`
--
ALTER TABLE `pricing`
  ADD UNIQUE KEY `tier` (`tier`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD UNIQUE KEY `reviewer` (`reviewer`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
