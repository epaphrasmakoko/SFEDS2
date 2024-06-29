-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2024 at 09:52 PM
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
  `description` varchar(255) DEFAULT NULL,
  `passphrase` varchar(255) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_email`, `file_name`, `file_path`, `description`, `passphrase`, `upload_time`, `file_type`) VALUES
(27, 'epaphrasmakoko55@gmail.com', 'pdfcoffee.com_all-challenges-flags-5-pdf-free.pdf', '/opt/lampp/htdocs/SFEDS2/uploads/pdfcoffee.com_all-challenges-flags-5-pdf-free.pdf.enc', 'pdf', 'pdf', '2024-06-29 13:32:36', 'pdf'),
(28, 'epaphrasmakoko55@gmail.com', 'fxhacker.jpg', '/opt/lampp/htdocs/SFEDS2/uploads/fxhacker.jpg.enc', 'jpg', 'jpg', '2024-06-29 13:36:51', 'jpg'),
(30, 'epaphrasmakoko55@gmail.com', 'possible from lectures.pdf', '/opt/lampp/htdocs/SFEDS2/uploads/possible from lectures.pdf.enc', 'pdf', 'pdf', '2024-06-29 14:05:21', 'pdf'),
(31, 'epaphrasmakoko55@gmail.com', 'sample.mp3', '/opt/lampp/htdocs/SFEDS2/uploads/sample.mp3.enc', 'Muziki sample', 'mp3', '2024-06-29 17:01:22', 'mp3'),
(32, 'jescakagande@gmail.com', 'MOuntain1.jpeg', '/opt/lampp/htdocs/SFEDS2/uploads/MOuntain1.jpeg.enc', 'milima', 'jpeg', '2024-06-29 19:40:28', 'jpeg'),
(33, 'esterhaule@gmail.com', 'Lecture 1 - Malware Analysis Fundamentals.pdf', '/opt/lampp/htdocs/SFEDS2/uploads/Lecture 1 - Malware Analysis Fundamentals.pdf.enc', 'malware', 'pdf', '2024-06-29 19:50:26', 'pdf');

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
(13, 'admin', 'admin', '255742029829', 'admin@gmail.com', '$2y$10$p9beFzfRzFovZRptdVB8COLMJ9AEs3FeWzw35amBUMumiqy0.SXAi', '2024-05-22 21:58:32', 1),
(14, 'Epaphras', 'Makoko', '255742029829', 'epaphrasmakoko55@gmail.com', '$2y$10$lN/d45uOzWszGzCC/lgF/O6iw8MeLST8ul5TPMBF/NIzNvXAZXp1O', '2024-05-22 22:22:59', 1),
(18, 'jesca', 'kagande', '255742029829', 'jescakagande@gmail.com', '$2y$10$.HuJMeM26jLUW1lKfO7FFOL4dBfxdShhJEcIneY/rtuwAiGn3f.Z.', '2024-06-29 19:39:37', 1),
(19, 'collins', 'kimweri', '255742029829', 'collinkimweri@gmail.com', '$2y$10$OCzFZZk5jjCvUwCz1cmOdOb5DIE6j8w56xTosvwKOMoFSbMVYVWpm', '2024-06-29 19:41:34', 1),
(20, 'ester', 'haule', '255742029829', 'esterhaule@gmail.com', '$2y$10$nVzh.v9pv.bCT2ptSpa1ounnHRxYQgj.VE5/z.YoHZdwiVBO/4y7G', '2024-06-29 19:45:21', 1),
(21, 'mariel', 'fred', '255742029829', 'marielfred@gmail.com', '$2y$10$1z6EcHeYJQp9RPO221qLlOJgyUNVjhmhpDuBDWfJXLr/sJYuBcc0.', '2024-06-29 19:46:44', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
