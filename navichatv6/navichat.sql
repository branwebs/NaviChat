-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2025 at 09:47 AM
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
-- Table structure for table `chatbot_config`
--

CREATE TABLE `chatbot_config` (
  `id` int(11) NOT NULL,
  `industry` varchar(50) NOT NULL,
  `intent` varchar(50) NOT NULL,
  `chat_title` varchar(100) NOT NULL,
  `agent_id` varchar(100) NOT NULL,
  `language_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot_config`
--

INSERT INTO `chatbot_config` (`id`, `industry`, `intent`, `chat_title`, `agent_id`, `language_code`) VALUES
(1, 'F&B', 'WELCOME', 'NaviChatbot', '693746d9-89f4-4297-be57-c63d5235df1a', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `data_count`
--

CREATE TABLE `data_count` (
  `id` int(11) NOT NULL,
  `symptom` varchar(50) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_count`
--

INSERT INTO `data_count` (`id`, `symptom`, `count`, `last_updated`) VALUES
(1, 'fever', 3, '2025-02-04 08:37:24'),
(2, 'cough', 0, '2025-02-01 07:57:53'),
(3, 'fatigue', 0, '2025-02-01 07:58:00'),
(4, 'pain', 0, '2025-02-01 07:58:10'),
(5, 'covid', 0, '2025-02-04 07:29:31');

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
('What are the benefits of NaviChat?', 'Increase customer satisfaction: NaviBot analyzes customer questions and delivers human-like answers in seconds. This enables your customers to receive the information they need 24/7.');

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
('Price', '59', 'Chatbot API + Analytics + Ticketing');

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
  `industry` varchar(50) NOT NULL,
  `subscription` varchar(20) NOT NULL,
  `startDate` varchar(50) DEFAULT NULL,
  `expireDate` varchar(50) DEFAULT NULL,
  `access` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `name`, `password`, `phone`, `company`, `industry`, `subscription`, `startDate`, `expireDate`, `access`) VALUES
('admin@navibot.com', 'admin', '$2y$10$z8oNNL1qxprkflbzlQOdW.peQy/Q2mEHbRo/2a265rCyal88mfrZy', 0, 'navichat', '', '', NULL, NULL, 4),
('bran@mail.com', 'bran', '$2y$10$dwaFY.SACKUTkTpDhiO5ge/3EBfvuvAc7sfdIRPEBNbeTETzWMqNS', 90909090, 'fyp', '', '', NULL, NULL, 1),
('eggs@farm.com', 'yolk', '$2y$10$iAaztbztcQLPMw4bV72Br.8Xn/fIL3yBHSbilD5l8OtQJ7zxTI28K', 86549012, 'eggs', 'F&B', '', NULL, NULL, 1),
('lol@riot.com', 'jinx', '$2y$10$wBmwFs7hqRtZGdx5Bj6mheQN.lP4RqBmqxaT68KEMJeej/RJ3UwYS', 44444444, 'riot', '', '', NULL, NULL, 1),
('ryan@mail.com', 'ryan', '$2y$10$o4Ocmo2FAEr8FfcC9/ALseQ.9WqU4Q61ntERxiJ1714fLGEJYrRrO', 90009000, 'yellow', 'Retail', '', NULL, NULL, 1),
('smith@mail.com', 'john', '$2y$10$bDQG2x.lxJ7li/Wd9y9MHunimr1pel46ggqQ7sHgS9clb74NX5GJW', 77778888, 'smithy', '', '', NULL, NULL, 1),
('summers@mail.com', 'hope', '$2y$10$kuNxNNG1L0ipqN18bKuZp.SWLuEFkjzViS6kQU4hOKtONMbnF15pq', 62353535, 'summer', '', '', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatbot_config`
--
ALTER TABLE `chatbot_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_count`
--
ALTER TABLE `data_count`
  ADD PRIMARY KEY (`id`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatbot_config`
--
ALTER TABLE `chatbot_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_count`
--
ALTER TABLE `data_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
