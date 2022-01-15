-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 15, 2022 at 10:01 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hazel`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `freelanceId` int(11) NOT NULL,
  `isConfirmedByClient` tinyint(1) NOT NULL DEFAULT '1',
  `isConfirmedByFreelance` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `clientId`, `freelanceId`, `isConfirmedByClient`, `isConfirmedByFreelance`, `date`) VALUES
(1, 7, 1, 1, 0, '2022-01-15 20:33:32'),
(2, 7, 1, 1, 0, '2022-01-15 20:35:43'),
(3, 7, 1, 1, 0, '2022-01-15 20:36:20'),
(4, 7, 1, 1, 0, '2022-01-15 20:36:57'),
(5, 7, 1, 1, 0, '2022-01-15 20:39:11'),
(6, 7, 1, 1, 0, '2022-01-18 17:20:00'),
(7, 7, 1, 1, 0, '2022-01-18 17:20:00'),
(8, 7, 1, 1, 0, '2022-01-18 17:20:00'),
(9, 7, 1, 1, 0, '2022-01-19 13:20:00'),
(10, 7, 1, 1, 0, '2022-01-26 10:15:00'),
(11, 7, 1, 1, 0, '2022-01-18 11:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `postId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `cityName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `fullAdress` varchar(255) NOT NULL,
  `coordinates` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `mediaUrl` varchar(255) NOT NULL,
  `mediaType` enum('video','image') NOT NULL,
  `text` text NOT NULL,
  `isComment` tinyint(1) NOT NULL,
  `postId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthday` datetime DEFAULT CURRENT_TIMESTAMP,
  `isVerified` tinyint(1) NOT NULL DEFAULT '0',
  `placeId` int(11) DEFAULT NULL,
  `role` enum('photographer','client','admin') NOT NULL DEFAULT 'client',
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) NOT NULL,
  `description` varchar(300) DEFAULT 'Cet utilisateur n''a pas de description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `birthday`, `isVerified`, `placeId`, `role`, `createdAt`, `updatedAt`, `email`, `description`) VALUES
(1, 'justezach', 'justezach', 'justezach', '2022-01-12 21:14:37', 1, NULL, 'client', '2022-01-12 21:13:59', '2022-01-12 21:14:37', 'coucou@cc.com', 'Salut c\'est zach'),
(3, 'admin@admin.admin', 'kodeskodes', 'azeaze azeaz', '2022-01-15 16:06:33', 0, NULL, 'photographer', '2022-01-15 16:06:33', '2022-01-15 16:06:33', 'mmzacy@gmail.com', 'Cet utilisateur n\'a pas de description'),
(4, 'ccbb', 'kodeskodes', 'azeaze azeaz', '2022-01-15 16:08:16', 0, NULL, 'photographer', '2022-01-15 16:08:16', '2022-01-15 16:08:16', 'ccbb@gmail.com', 'Cet utilisateur n\'a pas de description'),
(5, 'cccccc', 'kodeskodes', 'azeaze azeaz', '2022-01-15 16:08:51', 0, NULL, 'photographer', '2022-01-15 16:08:51', '2022-01-15 16:08:51', 'ccccc@gmail.com', 'Cet utilisateur n\'a pas de description'),
(6, 'sqdqsdqdsq', 'kodeskodes', 'azeaze azeaz', '2022-01-15 16:09:04', 0, NULL, 'client', '2022-01-15 16:09:04', '2022-01-15 16:09:04', 'qsdsqdqsd@gmail.com', 'Cet utilisateur n\'a pas de description'),
(7, 'azeazeazeazeaze', 'kodeskodes', 'azeaze azeaz', '2022-01-15 16:10:40', 0, NULL, 'client', '2022-01-15 16:10:40', '2022-01-15 16:10:40', 'azeazeazeaze@gmail.com', 'Cet utilisateur n\'a pas de description');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_freelance_apptm` (`freelanceId`),
  ADD KEY `fk_client_apptm` (`clientId`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_post` (`postId`),
  ADD KEY `fk_user_likes` (`userId`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_user` (`userId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_placeid` (`placeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_client_apptm` FOREIGN KEY (`clientId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_freelance_apptm` FOREIGN KEY (`freelanceId`) REFERENCES `user` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_user_likes` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_placeid` FOREIGN KEY (`placeId`) REFERENCES `places` (`id`);
