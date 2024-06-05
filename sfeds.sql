-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2024 at 09:13 AM
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
(6, 'jesca', 'kagande', '255742029829', 'jescakagande@gmail.com', '$2y$10$.WYXrzlaxAqQZX7RnZJtGOAA6VqrybYI07hpKDUCbS5tzkGvYWxFO', '2024-05-22 19:14:26', 1),
(12, 'mariel', 'fred', '255742029829', 'marielfred@gmail.com', '$2y$10$3Ok.r1OMDI.GjQS.fmFuEurdfUiV7P12PYTmToQwT0Z.2iwZF6Mla', '2024-05-22 21:14:06', 1),
(13, 'admin', 'admin', '255742029829', 'admin@gmail.com', '$2y$10$LOYIV.poDy0TC8XnpijCKOIWdxThUL2/jlT1pJyxPI6q3YLyMM4ea', '2024-05-22 21:58:32', 1),
(14, 'Epaphras', 'Makoko', '255742029829', 'epaphrasmakoko55@gmail.com', '$2y$10$5O6ZcPfj7JMFoM5nJFtqT.4Pekr8RzUK6y5WVPsDwrQzoZQVX.E0W', '2024-05-22 22:22:59', 1);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
