-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 11, 2026 at 10:10 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `host_id` int NOT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `max_participants` int DEFAULT NULL,
  `reg_start_date` date NOT NULL,
  `reg_end_date` date NOT NULL,
  `unique_token` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_token` (`unique_token`),
  KEY `host_id` (`host_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `host_id`, `event_name`, `event_date`, `event_time`, `max_participants`, `reg_start_date`, `reg_end_date`, `unique_token`, `created_at`) VALUES
(1, 4, 'Holy Ghost Service: Brand New Beginning', '2026-02-05', '18:00:00', NULL, '2026-02-02', '2026-02-05', '77b11b6118afcd1c', '2026-01-08 15:46:18'),
(2, 3, 'Golden Globes Awards 2026', '2026-01-11', '20:00:00', NULL, '2026-01-09', '2026-01-10', 'e8088c9164c92076', '2026-01-08 23:01:26'),
(3, 3, 'Golden Globes Awards 2026', '2026-01-17', '12:00:00', 60000, '2026-01-09', '2026-01-16', 'cba05b1bcd8f4f66', '2026-01-09 03:09:25'),
(4, 7, 'Upcoming Kdrama: undercover Miss Hong', '2026-01-17', '00:00:00', 5000, '2026-01-09', '2026-01-16', 'f10c893321787858', '2026-01-09 06:22:37'),
(5, 4, 'Golden Disk Awards 2026', '2026-01-10', '18:30:00', 10000, '2026-01-10', '2026-01-11', '1fe63df1b591db4c', '2026-01-10 14:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

DROP TABLE IF EXISTS `hosts`;
CREATE TABLE IF NOT EXISTS `hosts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hosts`
--

INSERT INTO `hosts` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Oreoluwa', 'ally@gmail.com', '$2y$10$Rz7EiXohsNpIeecF1oefi.TDB2xnJd6FZr2iNg.M5w7ccfFw/1j1W', '2026-01-08 12:26:46'),
(2, 'Oreoluwa', 'alicefavomodeinde@gmail.com', '$2y$10$x23Fmo309n5zUB/Pxw0LQ.vOU4p9gpi2enPgSq/IdapyU2K8HOal6', '2026-01-08 12:31:39'),
(3, 'favalicia_editz', 'oreofe@gmail.com', '$2y$10$ldA0MbMDAQNfqFnV9UAtbeXQ8MOjJqND5dYAHILdysg9XLPSrbZ4a', '2026-01-08 12:36:01'),
(4, 'GraceFavour', 'alicassss@gmail.com', '$2y$10$VV//XQvKbt.Y1uuHk89NGu0QbyfkRYLTIZcqmC6n.UC.Xh/qGUI2a', '2026-01-08 13:08:13'),
(5, 'Olivia', 'lly@gmail.com', '$2y$10$x5grOOcE8S1Hyn6nWuNh2Ov3ZOIU0zIf/AYAGWyy7zIipmtEOqIOm', '2026-01-08 14:47:00'),
(6, 'Olivia', 'oreally@gmail.com', '$2y$10$EZH.33nKR2v1eNmCZAtB0eMVfTdvmEpaMHJw1/sg1BX.c41bm7eAC', '2026-01-08 14:57:47'),
(7, 'Olivia', 'allyarty@gmail.com', '$2y$10$NYB6c26cj2CFo76lJov6EuHRecDMxzLSRYV4dqj8wWJtB1kACxQ.G', '2026-01-08 15:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
CREATE TABLE IF NOT EXISTS `registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `expectation` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `event_id`, `full_name`, `gender`, `email`, `phone`, `location`, `expectation`, `created_at`) VALUES
(1, 3, 'Oreoluwa Arty', 'female', 'alicefavomodeinde@gmail.com', '081124721311', 'Luck Way, Aduwawa, Benin City. Edo state', 'I i\'m expecting Lisa to present wonderfully at tomorrows event. Also, i hope that Ariana Grande, Cynthia Erivo or at least wicked movie wins home one of the awards. I know Golden of Huntrix is going to be winning in their category as well I hope!', '2026-01-10 17:22:03'),
(2, 4, 'Prince Art', 'male', 'alicefavomodeinde@gmail.com', '07075337215', 'Luck Way, Aduwawa, Benin City. Edo state', 'I really love the cast for this drama can\'t wait to see our female lead in action.', '2026-01-10 17:52:22'),
(3, 3, 'Prince Art', 'male', 'oreofe@gmail.com', '07075337215', 'Luck Way, Aduwawa, Benin City. Edo state', 'I heard Lisa from BlackPink is going to be presenting on tomorrows event. I can\'t honestly #LALISA #blackpink #kpop', '2026-01-10 19:21:13'),
(4, 3, 'Prince Art', 'male', 'ally@gmail.com', '07075337215', 'Luck Way, Aduwawa, Benin City. Edo state', 'I love Lisa so much!', '2026-01-10 19:23:00'),
(5, 3, 'Prince Art', 'male', 'lly@gmail.com', '07075337215', 'Luck Way, Aduwawa, Benin City. Edo state', 'GGA 2026', '2026-01-10 19:26:32'),
(6, 5, 'Grace Favour', 'female', 'ally@gmail.com', '07075337215', 'Luck Way, Aduwawa, Benin City. Edo state', 'I\'m expecting Jennie to slay at her performance just like she did in the MMA. I also expect that she would win many awards as well. I have really high hopes for her album, Ruby and her global hit song Like Jennie. I aslo expect a spectacular performance from Straykids as well as Enhypen, Lessarafim and BoyNextDoor.', '2026-01-11 10:04:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
