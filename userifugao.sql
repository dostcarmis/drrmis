-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2017 at 03:40 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dewsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `role_id` int(11) NOT NULL,
  `municipality_id` int(50) DEFAULT NULL,
  `province_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cellphone_num` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `profile_img`, `role_id`, `municipality_id`, `province_id`, `email`, `password`, `remember_token`, `position`, `designation`, `created_at`, `updated_at`, `cellphone_num`) VALUES
(1, 'Root', 'Developer', 'http://localhost/blog/public/photos/1/1000324_627030130664045_1136545810_n.jpg', 1, 31, 3, 'sangwayjoel@gmail.com', '$2y$10$MlE1bx.SlwaKKoHAvqUaQOCQ8L9NeU39CdXGquyqpsdh.qzG/jzOK', 'v2mFg7l82ZvoR0GNpyX8HAgK8Ky3sIZFiLGg88c8LJLpJfMwPBHytFnRblOo', '', '', '2017-04-21 05:56:21', '2017-04-27 05:09:29', ''),
(8, 'Super User', '', 'http://192.168.2.15/blog/public/assets/images/default.jpg', 4, 31, 3, 'lo@gmail.com', '$2y$10$/e4hi71r.2tDaarFLuHEJOjUURtKqpPh3.XWjVeDNAgndqUzUbkc6', NULL, '', '', '2017-04-21 06:01:55', '2017-04-21 06:01:55', ''),
(9, 'Daryl', 'codangos', 'http://192.168.2.15/blog/public/assets/images/default.jpg', 4, 31, 3, 'darylcodangos@gmail.com', '$2y$10$Mz042jrYapjlWspNOpn5/OLeNjZ.Hva5VAFn8GJ9Xq7C87XQR47ly', NULL, '', '', '2017-04-21 06:02:11', '2017-04-21 06:02:11', ''),
(11, 'John', 'Dela Cruz', 'http://192.168.2.15/blog/public/assets/images/default.jpg', 4, 51, 1, 'johndelacruz@gmail.com', '$2y$10$WDooZ5L2hDedFvBGU3xABOMbIPc16LEjzzbOpkV0K07Iaw/0I.DZi', 'kCdW6Gxj2yhvZo581j0JnqYE0ynjqcWXYa5gA2Qf1ifAQ8tJZMUhxLQhVJrj', '', '', '2017-04-21 08:11:14', '2017-04-21 08:11:25', ''),
(12, 'Ifugao', 'Test Account', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 30, 3, 'samplelastname@gmail.com', '$2y$10$M4oSFQcUJJFR1R0bE71/7u8oIFqp6XtxS89hXCoqJW1wxdiry5Zei', 'TCQ3XZXkbDAhpPjHECILBmfJOydNQ6zGkE2Q0iW5ooEl4jyCWZJtq4cxjQGM', '', '', '2017-04-27 02:41:43', '2017-04-27 03:56:53', ''),
(13, 'test', 'test', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 30, 3, 'test01@gmail.com', '$2y$10$vYPTb6G/E6Wo8A9gs5jXqeXponwqbYOc2bB2i82yjJNiFrZzGB8NO', 'bbWmE0Ebmf7tkFCIvmrTZ5O5S4Owb9fT2QGPbc8L8P2yLKVx7A4889dshFiw', '', '', '2017-04-27 04:35:17', '2017-04-27 04:50:47', ''),
(14, 'Lowil Ray', 'Delos Reyes', 'http://localhost/blog/public/assets/images/default.jpg', 1, 31, 3, 'lowildlr10@gmail.com', '$2y$10$9axVq3iCwnXLtu.Ew3h.OO.JewpQ8eHK7nhJCpaNp2WYd0XOUEbBu', NULL, '', '', '2017-04-27 04:50:25', '2017-04-27 04:50:25', '+639129527475'),
(15, 'RAMIL JANE', 'LICYAYO', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 26, 4, 'XYREY10@GMAIL.COM', '$2y$10$rTkFq8O9VW6T8ipOzoq23e0kXHf6k/5JN.uxSdTGntpYKBqwUxTjS', NULL, '', '', '2017-04-27 05:25:01', '2017-04-27 05:25:01', ''),
(16, 'LOLINA', 'TUGUINAY-GARCIA', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 20, 4, 'lolina.tuguinay@yahoo.com', '$2y$10$FcBrtMNanxCm7bU/GIh0GeJudorcIkLiS.RnIn.Lg2SNoNlV/7Vqm', NULL, '', '', '2017-04-27 05:25:07', '2017-04-27 05:25:07', ''),
(17, 'Lydia', 'Buyawe', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 27, 4, 'abayan62@yahoo.com', '$2y$10$GQ9nCgAgo1IN0IKXqUG.PeD0ydVPu9CZSuYmze.JraqnD2Qp.iz2C', NULL, '', '', '2017-04-27 05:25:28', '2017-04-27 05:25:28', ''),
(18, 'ema', 'rafil', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 24, 4, 'ema.rafil@yahoo.com', '$2y$10$MaW5KsQTNA6l6hgRlAbPA.ySuf0EhXvrDHM4mFbxcWTCQ5XviFGYS', NULL, '', '', '2017-04-27 05:26:12', '2017-04-27 05:26:12', ''),
(19, 'Ramil', 'Licyayo', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 26, 4, 'xramir07@yahoo.com', '$2y$10$HKwo5b.QFwtq.98u00uoXuhRrSzNO2NyRa0FCuDnbNndlGn/TpjtW', '9mJ8OXJ1P9FYMw3Ekv19pSMkuB6ddOWIwTkA2QGHTLW7b5fGlyyqNNIbOa6P', '', '', '2017-04-27 05:26:40', '2017-04-27 05:58:02', ''),
(20, 'RONALYN', 'TAGUILINGON', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 21, 4, 'rjtaguilingon@yahoo.com', '$2y$10$YcRgqg0bRLijBpRrOC0WWehijhnYKlcdCqMydqgq0G.q9iZNXX0Xi', NULL, '', '', '2017-04-27 05:28:09', '2017-04-27 05:28:09', ''),
(21, 'Divine Rose', 'Polahon', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 26, 4, 'xiakeith_13@yahoo.com', '$2y$10$B/VqIpPof0nColdabq2CXOKEa6zOFU1jWodxAI55vU98bmwifDSS6', NULL, '', '', '2017-04-27 05:28:10', '2017-04-27 05:28:10', ''),
(22, 'Marisa', 'Bahatan', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 26, 4, 'marisabahatan@gmail.com', '$2y$10$21Su/7.ygkQuk6TQcTftnub2//Im43G5jH.WHQq7x3FF9KmNP1DZy', NULL, '', '', '2017-04-27 05:28:46', '2017-04-27 05:28:46', ''),
(23, 'julius', 'dogwe', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 22, 4, 'doy_62879@yahoo.com', '$2y$10$N/M9Y90QRWhe0BL0Pi4Bs.5DMJF9x5jHpSrdcpe5F3dwlyS/8xYva', NULL, '', '', '2017-04-27 05:28:49', '2017-04-27 05:28:49', ''),
(24, 'Junifer', 'Ngannoy', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 27, 4, 'papaalpha08@yahoo.com', '$2y$10$ESM7s8rx9yOsC4PWC7RJZOSmzt7LhEXvMt4OulbY2CZEkJV36FVk.', NULL, '', '', '2017-04-27 05:29:05', '2017-04-27 05:29:05', ''),
(25, 'josephine', 'dominong', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 26, 4, 'jomacdominong@gmail.com', '$2y$10$uMi3q2YL4WRhkrQ7RQ158O1dxCdzNSwwHmwXz5Z2qovmnb2Bap0lG', NULL, '', '', '2017-04-27 05:30:43', '2017-04-27 05:30:43', ''),
(26, 'Gaye', 'Tam', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 25, 4, 'midnytstar78@yahoo.com', '$2y$10$100rJj6LfH8HZdepVSrmYeeQfbUhJ06bbjtyZ4DoFMTlZa4emWOQS', NULL, '', '', '2017-04-27 05:30:58', '2017-04-27 05:30:58', ''),
(27, 'Eric', 'Tundagui', 'http://192.168.1.135/blog/public/assets/images/default.jpg', 4, 25, 4, 'cire_jan15@yahoo.com', '$2y$10$x4OyYquSAcaqFxbwnwshCuKL1pp7Aj1WBW7Kaq1tsNjbSLL1mVkna', NULL, '', '', '2017-04-27 05:54:44', '2017-04-27 05:54:44', ''),
(28, 'Test', 'test', 'http://localhost/blog/public/assets/images/default.jpg', 4, 4, 6, 'test@gmail.com', '$2y$10$SZAR/cKdRwVmJJ5eXTFRGe2fA6A8HoHjIt0LHXBIT9a2F6RZfa4ym', NULL, '', '', '2017-05-07 01:28:10', '2017-05-07 01:28:10', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
