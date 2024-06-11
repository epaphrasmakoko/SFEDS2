-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2024 at 10:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfeds`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `encryption_method` enum('generatedKey','passphrase') NOT NULL,
  `passphrase` varchar(255) DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_email`, `file_name`, `file_path`, `encryption_method`, `passphrase`, `upload_time`, `file_type`) VALUES
(4, 'epaphrasmakoko55@gmail.com', 'Add a heading (1).pdf', '../uploads/Add a heading (1).pdf', 'passphrase', 'ok', '2024-06-10 19:45:16', NULL),
(5, 'epaphrasmakoko55@gmail.com', 'Add a heading (2).pdf', '../uploads/Add a heading (2).pdf', 'passphrase', 'ok', '2024-06-10 19:48:25', 'pdf'),
(6, 'epaphrasmakoko55@gmail.com', 'Blue Purple Futuristic Modern 3D Tech Company Business Presentation (1).pdf', '../uploads/Blue Purple Futuristic Modern 3D Tech Company Business Presentation (1).pdf', 'passphrase', 'okok', '2024-06-10 20:02:59', 'pdf'),
(7, 'jescakagande@gmail.com', 'CamScanner 07-02-2023 09.38.pdf', '../uploads/CamScanner 07-02-2023 09.38.pdf', 'passphrase', 'ok', '2024-06-10 20:04:57', 'pdf'),
(8, 'jescakagande@gmail.com', 'Blue Purple Futuristic Modern 3D Tech Company Business Presentation (1).pdf', '../uploads/Blue Purple Futuristic Modern 3D Tech Company Business Presentation (1).pdf', 'passphrase', 'okok', '2024-06-10 20:51:29', 'pdf'),
(9, 'epaphrasmakoko55@gmail.com', 'full package.pdf', '../uploads/full package.pdf', 'passphrase', 'ok', '2024-06-11 06:54:20', 'pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `password`, `created_at`, `is_active`) VALUES
(6, 'jesca', 'kagande', '255742029829', 'jescakagande@gmail.com', '$2y$10$TLF7ENgmdjlGgCgkHGYkreqS6Cfad.AQvw3dHLYnJVKxZb55XtNMG', '2024-05-22 19:14:26', 1),
(12, 'mariel', 'fred', '255742029829', 'marielfred@gmail.com', '$2y$10$3Ok.r1OMDI.GjQS.fmFuEurdfUiV7P12PYTmToQwT0Z.2iwZF6Mla', '2024-05-22 21:14:06', 1),
(13, 'admin', 'admin', '255742029829', 'admin@gmail.com', '$2y$10$vgc/YrZrnbSMxUCa6/yAXeeo9LH/sROBuMHmhGRTYpzUyrkTD4k9S', '2024-05-22 21:58:32', 1),
(14, 'Epaphras', 'Makoko', '255742029829', 'epaphrasmakoko55@gmail.com', '$2y$10$5O6ZcPfj7JMFoM5nJFtqT.4Pekr8RzUK6y5WVPsDwrQzoZQVX.E0W', '2024-05-22 22:22:59', 1),
(17, 'test', 'test', '255742029829', 'test@gmail.com', '$2y$10$I6cshYXqETuBGCI85Jy7oe2FjixMGhwQfaUupQAumK5WOeQd2U3dO', '2024-06-05 08:42:41', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
