-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2023 at 08:19 AM
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
-- Database: `rms`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'BS-IT'),
(2, 'BS-CS'),
(5, 'jnj');

-- --------------------------------------------------------

--
-- Table structure for table `mess`
--

CREATE TABLE `mess` (
  `id` int(11) NOT NULL,
  `dish1` varchar(100) NOT NULL,
  `dish2` varchar(100) NOT NULL,
  `dish1_units` int(11) NOT NULL,
  `dish2_units` int(11) NOT NULL,
  `day` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mess`
--

INSERT INTO `mess` (`id`, `dish1`, `dish2`, `dish1_units`, `dish2_units`, `day`) VALUES
(1, 'alo indaa1', 'chana rice7', 121, 166, 1),
(2, 'dal frijhj', 'sabziyt', 167, 108, 2),
(3, 'das', 'cxz', 12, 22, 3),
(4, 'dsad', 'zxc', 12, 14, 4),
(5, 'asd', 'ads', 10, 12, 5),
(6, 'kjk', 'kkj', 8, 90, 6),
(7, 'jbm', 'jjhj', 99, 9, 7);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `issue_date` date NOT NULL,
  `type` tinyint(4) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `image`, `title`, `description`, `issue_date`, `type`, `is_active`) VALUES
(4, 'images/news/1691177060_B612_20210527_185133_695.jpg', 'm1', 'holo1', '2023-08-03', 0, 1),
(8, 'images/news/1691311235_17c23deffcaa4cd7909debe54bb5703e.jpg', 'S', 'AS', '2023-08-01', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 1,
  `current` int(11) NOT NULL DEFAULT 0,
  `is_active` smallint(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `capacity`, `current`, `is_active`) VALUES
(10, 1, 2, 2, 1),
(11, 2, 4, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default_room.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`id`, `room_id`, `image`) VALUES
(33, 10, 'images/rooms/1690714589_20210316_174318.jpg'),
(34, 10, 'images/rooms/1690714589_20210316_174343.jpg'),
(35, 10, 'images/rooms/1690714589_B612_20210527_185133_695.jpg'),
(37, 11, 'images/rooms/1691087195_B612_20210527_185140_660.jpg'),
(38, 11, 'images/rooms/1691087195_B612_20210527_185317_164.jpg'),
(39, 11, 'images/rooms/1691087195_B612_20210527_185320_222.jpg'),
(40, 11, 'images/rooms/1691087195_B612_20210527_185324_408.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `room_user`
--

CREATE TABLE `room_user` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'images/default_user.png',
  `name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `image`, `name`, `role`, `is_active`) VALUES
(26, 'images/staff/1692338606_17c23deffcaa4cd7909debe54bb5703e.jpg', 'tgdf', 'fggf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `blood_group` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cnic` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL,
  `requested_room` int(11) NOT NULL DEFAULT 0,
  `dept_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default_img.png',
  `phone` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0,
  `is_verified` tinyint(4) NOT NULL DEFAULT 0,
  `registered_date` date NOT NULL DEFAULT current_timestamp(),
  `room_assigned_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `blood_group`, `dob`, `gender`, `email`, `cnic`, `password`, `room_id`, `requested_room`, `dept_id`, `image`, `phone`, `address`, `city`, `is_active`, `is_admin`, `is_verified`, `registered_date`, `room_assigned_date`) VALUES
(2, 'usama', 'rasheed', 'B+', '2023-07-28', 'male', 'usama1@gmail.com', '2323', '', 11, 0, 1, 'images/users/1690726121_17c23deffcaa4cd7909debe54bb5703e.jpg', 'password', 'password', 'password', 1, 1, 1, '2023-07-29', NULL),
(3, 'usama12', 'rasheed12', 'AB+', '2023-07-30', 'male', 'usama22@gmail.com', '499042', '', 11, 0, 1, 'images/users/1690726090_FB_IMG_1613192819562.jpg', 'password12', 'password12', 'password12', 1, 1, 1, '2023-07-29', NULL),
(6, 'zc', 'zcx', 'a', '2023-08-01', 'male', 'sad@da.ca', '32423432432', '', 10, 0, 1, 'images/users/1692304102_IMG_20210307_091457~2.jpg', 'a', 'adsasd', '', 1, 0, 1, '2023-08-05', '2023-08-01'),
(7, 'sdsd', 'zcxsd', 'a', '2023-08-01', 'male', 'sasd@da.ca1', '324234324312', '', 10, 0, 2, 'images/users/1692304199_B612_20210527_185133_695.jpg', 'a', 'adsasd', '', 1, 0, 1, '2023-08-05', '2023-08-01'),
(8, 'usama12s', 'rasheed12s', 'AB+', '2023-07-30', 'male', 'usama22s@gmail.com', '499042', '$2y$10$2kxdMWMC9OL27J9OQiqCh.9oapNxBohpNyTWk087ui9b.BqIYfNX.', 11, 0, 5, 'images/users/1690726090_FB_IMG_1613192819562.jpg', 'password12', 'password12', 'password12', 1, 0, 1, '2023-07-29', NULL),
(9, 'usama', 'rasheed', 'A-', '0000-00-00', '', 'usamaR@gmail.com', 'usamaR@gmail.com', '$2y$10$2kxdMWMC9OL27J9OQiqCh.9oapNxBohpNyTWk087ui9b.BqIYfNX.', 0, 0, 1, 'images/users/1691609581_20210316_174343.jpg', '', '', '', 1, 1, 1, '2023-08-09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webcontent`
--

CREATE TABLE `webcontent` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sup_image` varchar(255) NOT NULL,
  `sup_name` varchar(255) NOT NULL,
  `sup_message` text NOT NULL,
  `main_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `webcontent`
--

INSERT INTO `webcontent` (`id`, `title`, `description`, `sup_image`, `sup_name`, `sup_message`, `main_image`) VALUES
(1, 'ad1', 'sd1', 'images/web/1692221575_FB_IMG_1612424777555.jpg', 'sa1', 'sa1', 'images/web/1692221575_4ee9eb5298a34c52b4672cebf6385c7d.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mess`
--
ALTER TABLE `mess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_user`
--
ALTER TABLE `room_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webcontent`
--
ALTER TABLE `webcontent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mess`
--
ALTER TABLE `mess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `room_user`
--
ALTER TABLE `room_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `webcontent`
--
ALTER TABLE `webcontent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
