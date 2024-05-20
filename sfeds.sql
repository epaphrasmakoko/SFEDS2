-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 20, 2024 at 08:48 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `password`, `created_at`) VALUES
(1, 'Epaphras', 'Makoko', '0742029829', 'epaphrasmakoko55@gmail.com', '$2y$10$lLbiwNJfWhqtoyGqfBRqfuC3BIBsUISUyXsdKhsPGuCYZTWP6Olsu', '2024-05-20 08:24:59'),
(2, 'jesca', 'kagande', '0747079196', 'jescakagande@gmail.com', '$2y$10$lPniAJSd4HBOagER7OP6Cel03ANEzZcza1GTt7H2s1OdCLYi3o/UO', '2024-05-20 09:08:04'),
(3, 'collins', 'kimweri', '0756290460', 'collinskimweri@gmail.com', '$2y$10$qQPpoBJoLZlbBocTb0Kne.Cag4rwnw1sRT1a/45Xa87eoXHRevj6e', '2024-05-20 13:55:00'),
(4, 'admin', 'admin', '1234567890', 'admin@gmail.com', '$2y$10$uyM/TVsbuu1ur7wXrKsh7eqYIvRVfwSTyRZ4Xd/b1IaIvu/by2upi', '2024-05-20 15:51:28');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
