-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 07:48 AM
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
-- Database: `newsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `ArticleID` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Content` text NOT NULL,
  `AuthorID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `PublishedAt` datetime NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`ArticleID`, `Title`, `Content`, `AuthorID`, `CategoryID`, `Image`, `PublishedAt`, `Status`) VALUES
(1, 'Saka to miss \'many weeks\' with torn hamstring - Arteta news conference & reaction new', 'Shame for Saka, but I put this down more to Arteta. It was his decision for Saka (and Rice) to play virtually every game for the past 2/3 seasons.\r\nnew\r\nnew\r\nnew\r\nnew', 4, 1, 'img/news/sport/1735021622.jpg', '2024-12-23 15:08:41', 'edited'),
(2, 'Spillane\'s Tower heads King George line-up', 'The six-year-old, trained by Jimmy Mangan for owner JP McManus, was a dual winner at the top Grade One level last season and was added as a supplementary entry last week along with last year\'s fourth-placed finisher The Real Whacker and French contender Juntos Ganamos.\r\n\r\n', 4, 1, 'img/news/sport/2c1350c20-bed7-11ef-b73c-311ce229ab28.jpg.webp', '2024-12-23 15:34:19', 'published'),
(3, 'Saka to miss \'many weeks\' with torn hamstring - Arteta news conference & reaction', 'Shame for Saka, but I put this down more to Arteta. It was his decision for Saka (and Rice) to play virtually every game for the past 2/3 seasons.', 4, 1, 'img/news/sport/1298e19e0-c114-11ef-a0f2-fd81ae5962f4.jpg', '2024-12-23 15:39:21', ''),
(7, 'sssssssssssssssssssssssssssssssssss', 'sssssssssssssssssssssssssssssssssss\r\nsssssssssssssssssssssssssssssssssss\r\nsssssssssssssssssssssssssssssssssss\r\nsssssssssssssssssssssssssssssssssss', 4, 2, 'img/news/business/1735018068.png', '2024-12-24 06:27:48', 'Published'),
(8, 'Saka to miss \'many weeks\' with torn hamstring - Arteta news conference & reaction', 'Saka to miss \'many weeks\' with torn hamstring - Arteta news conference & reaction\r\nSaka to miss \'many weeks\' with torn hamstring - Arteta news conference & reaction\r\nSaka to miss \'many weeks\' with torn hamstring - Arteta news conference & reaction', 4, 1, 'img/news/sport/1735018121.jpg', '2024-12-24 06:28:41', 'Published');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Name`, `Description`) VALUES
(1, 'sport', 'All exclusive sports news'),
(2, 'business', 'All exclusive business news'),
(3, 'technology', 'All exclusive technologies news'),
(4, 'earth', 'All exclusive earth news');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `ArticleID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`CommentID`, `ArticleID`, `UserID`, `Comment`, `CreatedAt`) VALUES
(1, 3, 3, 'das', '2024-12-23 22:27:12'),
(2, 3, 3, 'dasd', '2024-12-23 22:27:24'),
(3, 3, 3, 'das', '2024-12-23 22:51:07'),
(4, 3, 3, 'asd', '2024-12-23 22:51:52'),
(5, 2, 3, 'das', '2024-12-23 22:55:34'),
(6, 1, 3, 'dasdas', '2024-12-23 22:57:23'),
(7, 1, 3, 'dfa', '2024-12-23 22:57:26'),
(8, 1, 3, 'fads', '2024-12-23 22:57:54'),
(9, 1, 3, 'fffffffffffffffffffffffffff', '2024-12-23 22:57:58'),
(10, 3, 3, 'd', '2024-12-24 06:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `LikeID` int(11) NOT NULL,
  `ArticleID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `email_message` text NOT NULL,
  `message_content` text NOT NULL,
  `username` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `email_message`, `message_content`, `username`) VALUES
(2, 'fathyfathy705@yahoo.com', 'asdfdfafdsadfsafdsfdasafdsafdsfdasfadsfadsafds', 'Fathy Ahmed'),
(3, 'fathyfathy705@yahoo.com', 'asdffffffffffffffffffffffffffffffffffffffffffff', 'Fathy Ahmed'),
(4, 'fathyfathy705@yahoo.com', 'asdffffffffffffffffffffffffffffffffffffffffffff', 'Fathy Ahmed'),
(5, 'fathy@gmail.com', 'fuck!\r\nfuck!\r\nfuck!\r\nfuck!\r\nfuck!\r\nfuck!\r\nfuck!\r\nfuck!\r\nfuck!\r\nfuck!', 'Fathy Ahmed Fathy ');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `Rolename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleID`, `Rolename`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Email`, `Password`, `RoleID`, `CreatedAt`) VALUES
(3, 'Fathy1', 'fathyahmed42205392@gmail.com', '123456789', 2, '2024-12-23 12:37:55'),
(4, 'Admin1', 'admin@news.com', '123456789', 1, '2024-12-23 15:03:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ArticleID`),
  ADD KEY `fk_Article_AuthorID` (`AuthorID`),
  ADD KEY `fk_Article_CategoryID` (`CategoryID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`),
  ADD KEY `idx_Category_Name` (`Name`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `fk_Comment_ArticleID` (`ArticleID`),
  ADD KEY `fk_Comment_UserID` (`UserID`);

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`LikeID`),
  ADD KEY `fk_Like_ArticleID` (`ArticleID`),
  ADD KEY `fk_Like_UserID` (`UserID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`),
  ADD KEY `idx_Role_Rolename` (`Rolename`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `uc_User_Email` (`Email`),
  ADD KEY `fk_User_RoleID` (`RoleID`),
  ADD KEY `idx_User_Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `ArticleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `like`
--
ALTER TABLE `like`
  MODIFY `LikeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_Article_AuthorID` FOREIGN KEY (`AuthorID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `fk_Article_CategoryID` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_Comment_ArticleID` FOREIGN KEY (`ArticleID`) REFERENCES `article` (`ArticleID`),
  ADD CONSTRAINT `fk_Comment_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `fk_Like_ArticleID` FOREIGN KEY (`ArticleID`) REFERENCES `article` (`ArticleID`),
  ADD CONSTRAINT `fk_Like_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_RoleID` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
