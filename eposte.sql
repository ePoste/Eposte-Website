-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 07:42 AM
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
-- Database: `eposte`
--

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `folderId` int(11) NOT NULL,
  `ownerEmail` varchar(255) DEFAULT NULL,
  `folderName` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postId` int(11) NOT NULL,
  `ownerEmail` varchar(255) DEFAULT NULL,
  `folderId` int(11) DEFAULT NULL,
  `postName` varchar(255) DEFAULT NULL,
  `postDescription` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posttags`
--

CREATE TABLE `posttags` (
  `postTagsId` int(11) NOT NULL,
  `postId` int(11) DEFAULT NULL,
  `tagId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sharedfolders`
--

CREATE TABLE `sharedfolders` (
  `sharedFoldersId` int(11) NOT NULL,
  `folderId` int(11) DEFAULT NULL,
  `sharedTo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sharedposts`
--

CREATE TABLE `sharedposts` (
  `sharedPostsId` int(11) NOT NULL,
  `postId` int(11) DEFAULT NULL,
  `sharedTo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tagId` int(11) NOT NULL,
  `tagName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagId`, `tagName`) VALUES
(1, 'project'),
(2, 'report'),
(3, 'website'),
(4, 'marketing'),
(5, 'design'),
(6, 'react'),
(7, 'flutter'),
(8, 'school'),
(9, 'personal'),
(10, 'urgent'),
(11, 'memes'),
(12, 'fun'),
(13, 'eating'),
(14, 'foodie'),
(15, 'travel'),
(16, 'vacation'),
(17, 'fitness'),
(18, 'inspiration'),
(19, 'selfie'),
(20, 'reels'),
(21, 'shorts'),
(22, 'tiktok'),
(23, 'viral'),
(24, 'photography'),
(25, 'social'),
(26, 'influencer'),
(27, 'motivation'),
(28, 'vlog'),
(29, 'daily'),
(30, 'friends'),
(31, 'weekend'),
(32, 'party'),
(33, 'quotes'),
(34, 'lifestyle'),
(35, 'throwback'),
(36, 'eat');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `userName`) VALUES
('anhkhoi2901@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`folderId`),
  ADD KEY `ownerEmail` (`ownerEmail`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `ownerEmail` (`ownerEmail`),
  ADD KEY `folderId` (`folderId`);

--
-- Indexes for table `posttags`
--
ALTER TABLE `posttags`
  ADD PRIMARY KEY (`postTagsId`),
  ADD KEY `postId` (`postId`),
  ADD KEY `tagId` (`tagId`);

--
-- Indexes for table `sharedfolders`
--
ALTER TABLE `sharedfolders`
  ADD PRIMARY KEY (`sharedFoldersId`),
  ADD KEY `folderId` (`folderId`),
  ADD KEY `sharedTo` (`sharedTo`);

--
-- Indexes for table `sharedposts`
--
ALTER TABLE `sharedposts`
  ADD PRIMARY KEY (`sharedPostsId`),
  ADD KEY `postId` (`postId`),
  ADD KEY `sharedTo` (`sharedTo`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `folderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `posttags`
--
ALTER TABLE `posttags`
  MODIFY `postTagsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sharedfolders`
--
ALTER TABLE `sharedfolders`
  MODIFY `sharedFoldersId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sharedposts`
--
ALTER TABLE `sharedposts`
  MODIFY `sharedPostsId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tagId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_ibfk_1` FOREIGN KEY (`ownerEmail`) REFERENCES `users` (`email`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`ownerEmail`) REFERENCES `users` (`email`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`folderId`) REFERENCES `folders` (`folderId`);

--
-- Constraints for table `posttags`
--
ALTER TABLE `posttags`
  ADD CONSTRAINT `posttags_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `posts` (`postId`) ON DELETE CASCADE,
  ADD CONSTRAINT `posttags_ibfk_2` FOREIGN KEY (`tagId`) REFERENCES `tags` (`tagId`);

--
-- Constraints for table `sharedfolders`
--
ALTER TABLE `sharedfolders`
  ADD CONSTRAINT `sharedfolders_ibfk_1` FOREIGN KEY (`folderId`) REFERENCES `folders` (`folderId`),
  ADD CONSTRAINT `sharedfolders_ibfk_2` FOREIGN KEY (`sharedTo`) REFERENCES `users` (`email`);

--
-- Constraints for table `sharedposts`
--
ALTER TABLE `sharedposts`
  ADD CONSTRAINT `sharedposts_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `posts` (`postId`),
  ADD CONSTRAINT `sharedposts_ibfk_2` FOREIGN KEY (`sharedTo`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
