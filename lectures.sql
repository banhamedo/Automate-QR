-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2024 at 12:00 AM
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
-- Database: `qr-code`
--

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qr_code_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`id`, `name`, `qr_code_url`, `created_at`) VALUES
(1, 'mlops', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=mlops', '2024-11-15 14:39:58'),
(2, 'mlops1', 'http://localhost/rfidattendance/aws-fitch.phpmlops1', '2024-11-15 14:41:15'),
(3, 'mlops1', 'http://localhost/rfidattendance/aws-fitch.phpmlops1', '2024-11-15 14:45:27'),
(4, 'mlops', 'http://localhost/rfidattendance/aws-fitch.phpmlops', '2024-11-15 14:45:36'),
(5, 'mlops1', 'http://localhost/rfidattendance/aws-fitch.phpmlops1', '2024-11-15 19:07:01'),
(6, 'mlops1', 'http://localhost/rfidattendance/aws-fitch.phpmlops1', '2024-11-15 19:09:51'),
(7, 'mlops1', 'http://localhost/rfidattendance/aws-fitch.phpmlops1', '2024-11-15 19:10:36'),
(8, 'mlops1', 'http://localhost/rfidattendance/aws-fitch.phpmlops1', '2024-11-15 19:10:39'),
(9, 'mlops1', 'http://localhost/rfidattendance/aws-fitch.phpmlops1', '2024-11-15 19:15:30'),
(10, 'k;ol\':', 'http://localhost/rfidattendance/aws-fitch.phpk%3Bol%5C%27%3A', '2024-11-15 19:29:50'),
(11, 'iikiii', 'http://localhost/rfidattendance/aws-fitch.phpiikiii', '2024-11-15 19:30:27'),
(12, 'mlops1', 'https://api.qrserver.com/v1/create-qr-code/?data=mlops1', '2024-11-20 19:42:16'),
(13, 'mlops1', 'http://127.0.0.1:5000/latest_qrmlops1', '2024-11-20 19:43:17'),
(14, 'mklkl', 'http://127.0.0.1:5000/latest_qrmklkl', '2024-11-20 19:47:09'),
(15, 'mklkl', 'http://127.0.0.1:5000/latest_qrmklkl', '2024-11-20 19:49:21'),
(16, 'new lec', 'http://127.0.0.1:5000/latest_qrnew+lec', '2024-11-20 19:49:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
