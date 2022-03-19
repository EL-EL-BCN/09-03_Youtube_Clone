-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2020 at 10:20 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videotube`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Film & Animation'),
(2, 'Autos & Vehicles'),
(3, 'Music'),
(4, 'Pets & Animals'),
(5, 'Sport'),
(6, 'Travel & Events'),
(7, 'Gaming'),
(8, 'People & Blogs'),
(9, 'Comedy'),
(10, 'Entertainment'),
(11, 'News & Politics'),
(12, 'Howto & Style'),
(13, 'Education'),
(14, 'Science & Technology'),
(15, 'Nonprofits & Activism');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postedBy` varchar(50) NOT NULL,
  `videoId` int(11) NOT NULL,
  `responseTo` int(11) NOT NULL,
  `body` text NOT NULL,
  `datePosted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `postedBy`, `videoId`, `responseTo`, `body`, `datePosted`) VALUES
(3, 'Mickey_Mouse', 36, 0, 'This is a really anoying video', '2020-09-17 15:33:49'),
(7, 'Mickey_Mouse', 36, 0, 'what do you mean? There was no TV transmission during the night?', '2020-09-17 18:22:07'),
(8, 'Mickey_Mouse', 36, 0, 'I thought this screen had a picture of a little girl in it?', '2020-09-17 18:24:26'),
(16, 'Mickey_Mouse', 36, 0, 'Test Message?', '2020-09-17 19:52:27'),
(33, 'Mickey_Mouse', 36, 8, 'The one with the little girl was used on the BBC in the UK.', '2020-09-17 22:58:33'),
(34, 'Mickey_Mouse', 36, 33, 'Oh. THe BBC should be funded by advertising and not taxpayer money.', '2020-09-17 23:25:44'),
(35, 'Mickey_Mouse', 36, 34, 'noooooooooo. the BBC is a great british institution.', '2020-09-17 23:29:14'),
(36, 'Mickey_Mouse', 36, 16, 'yes it was used as a test message for TV transmission also.', '2020-09-17 23:32:52'),
(37, 'Mickey_Mouse', 36, 36, 'oh. ok thx.', '2020-09-17 23:33:05');

-- --------------------------------------------------------

--
-- Table structure for table `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `commentId` int(11) NOT NULL,
  `videoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dislikes`
--

INSERT INTO `dislikes` (`id`, `username`, `commentId`, `videoId`) VALUES
(8, 'Mickey_Mouse', 32, 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `commentId` int(11) NOT NULL,
  `videoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `commentId`, `videoId`) VALUES
(38, 'Mickey_Mouse', 0, 36),
(39, 'Daffy_Duck', 0, 47),
(40, 'Daffy_Duck', 0, 48);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `userTo` varchar(50) NOT NULL,
  `UserFrom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `userTo`, `UserFrom`) VALUES
(1, 'Goofy_Dog', 'Daffy_Duck'),
(2, 'Daffy_Duck', 'Goofy_Dog'),
(3, 'Daffy_Duck', 'Mickey_Mouse'),
(4, 'Mickey_Mouse', 'Daffy_Duck'),
(5, 'Goofy_Dog', 'Mickey_Mouse'),
(9, 'Mickey_Mouse', 'Goofy_Dog');

-- --------------------------------------------------------

--
-- Table structure for table `thumbnails`
--

CREATE TABLE `thumbnails` (
  `id` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `filePath` varchar(250) NOT NULL,
  `selected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thumbnails`
--

INSERT INTO `thumbnails` (`id`, `videoId`, `filePath`, `selected`) VALUES
(49, 34, 'uploads/videos/thumbnails/34-5f5ea28ac0808.jpg', 1),
(50, 34, 'uploads/videos/thumbnails/34-5f5ea28e3abc2.jpg', 0),
(51, 34, 'uploads/videos/thumbnails/34-5f5ea290b0f48.jpg', 0),
(52, 35, 'uploads/videos/thumbnails/35-5f5ea3ddd549a.jpg', 1),
(53, 35, 'uploads/videos/thumbnails/35-5f5ea3e22860c.jpg', 0),
(54, 35, 'uploads/videos/thumbnails/35-5f5ea3e88269c.jpg', 0),
(55, 36, 'uploads/videos/thumbnails/36-5f60b0a8875d0.jpg', 1),
(56, 36, 'uploads/videos/thumbnails/36-5f60b0a929df0.jpg', 0),
(57, 36, 'uploads/videos/thumbnails/36-5f60b0a994034.jpg', 0),
(58, 37, 'uploads/videos/thumbnails/37-5f60b0ea9ba7b.jpg', 1),
(59, 37, 'uploads/videos/thumbnails/37-5f60b0eb5e525.jpg', 0),
(60, 37, 'uploads/videos/thumbnails/37-5f60b0ec8f637.jpg', 0),
(61, 38, 'uploads/videos/thumbnails/38-5f60b1803ddb4.jpg', 1),
(62, 38, 'uploads/videos/thumbnails/38-5f60b18288ee7.jpg', 0),
(63, 38, 'uploads/videos/thumbnails/38-5f60b1872d307.jpg', 0),
(64, 39, 'uploads/videos/thumbnails/39-5f62a69de766b.jpg', 1),
(65, 39, 'uploads/videos/thumbnails/39-5f62a69f2754a.jpg', 0),
(66, 39, 'uploads/videos/thumbnails/39-5f62a6a0dbf0f.jpg', 0),
(67, 40, 'uploads/videos/thumbnails/40-5f62a6f0cc4dc.jpg', 1),
(68, 40, 'uploads/videos/thumbnails/40-5f62a6f197efc.jpg', 0),
(69, 40, 'uploads/videos/thumbnails/40-5f62a6f2b0cce.jpg', 0),
(70, 41, 'uploads/videos/thumbnails/41-5f62a81addc5e.jpg', 1),
(71, 41, 'uploads/videos/thumbnails/41-5f62a81b63fb9.jpg', 0),
(72, 41, 'uploads/videos/thumbnails/41-5f62a81c0bf5e.jpg', 0),
(73, 42, 'uploads/videos/thumbnails/42-5f62a839dc0d4.jpg', 1),
(74, 42, 'uploads/videos/thumbnails/42-5f62a83a7f448.jpg', 0),
(75, 42, 'uploads/videos/thumbnails/42-5f62a83b29c07.jpg', 0),
(76, 43, 'uploads/videos/thumbnails/43-5f6355a87e9f7.jpg', 1),
(77, 43, 'uploads/videos/thumbnails/43-5f6355a96f44d.jpg', 0),
(78, 43, 'uploads/videos/thumbnails/43-5f6355aab5d5d.jpg', 0),
(79, 44, 'uploads/videos/thumbnails/44-5f6359cf6354d.jpg', 1),
(80, 44, 'uploads/videos/thumbnails/44-5f6359dd1a4d3.jpg', 0),
(81, 44, 'uploads/videos/thumbnails/44-5f6359fae1af2.jpg', 0),
(82, 45, 'uploads/videos/thumbnails/45-5f652acb5bb51.jpg', 0),
(83, 45, 'uploads/videos/thumbnails/45-5f652acda5872.jpg', 0),
(84, 45, 'uploads/videos/thumbnails/45-5f652ad119a2d.jpg', 1),
(85, 46, 'uploads/videos/thumbnails/46-5f652c1f0f396.jpg', 1),
(86, 46, 'uploads/videos/thumbnails/46-5f652c21b1d43.jpg', 0),
(87, 46, 'uploads/videos/thumbnails/46-5f652c25351ad.jpg', 0),
(88, 47, 'uploads/videos/thumbnails/47-5f652f0a20a68.jpg', 0),
(89, 47, 'uploads/videos/thumbnails/47-5f652f127111a.jpg', 0),
(90, 47, 'uploads/videos/thumbnails/47-5f652f1f69520.jpg', 1),
(91, 48, 'uploads/videos/thumbnails/48-5f65305f2f436.jpg', 0),
(92, 48, 'uploads/videos/thumbnails/48-5f6530602d92b.jpg', 0),
(93, 48, 'uploads/videos/thumbnails/48-5f653061a1b7d.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT current_timestamp(),
  `profilePic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `email`, `password`, `signUpDate`, `profilePic`) VALUES
(1, 'Mickey', 'Mouse', 'Mickey_Mouse', 'mickey_mouse@disney.com', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '2020-09-15 00:26:36', 'assets/images/profilePictures/default.png'),
(2, 'Daffy', 'Duck', 'Daffy_Duck', 'Daffy_Duck@disney.com', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '2020-09-15 00:34:04', 'assets/images/profilePictures/default.png'),
(3, 'Goofy', 'Dog', 'Goofy_Dog', 'Goofy_dog@disney.com', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '2020-09-18 23:37:25', 'assets/images/profilePictures/default.png');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `uploadedBy` varchar(50) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT 0,
  `filePath` varchar(250) NOT NULL,
  `category` int(11) NOT NULL DEFAULT 0,
  `uploadDate` datetime NOT NULL DEFAULT current_timestamp(),
  `views` int(11) NOT NULL DEFAULT 0,
  `duration` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `uploadedBy`, `title`, `description`, `privacy`, `filePath`, `category`, `uploadDate`, `views`, `duration`) VALUES
(36, 'Daffy_Duck', 'Bars and tones', 'Video of old bars and tone display from when there was no TV transmissions during the night.', 1, 'uploads/videos/5f60b09ff41f0.mp4', 1, '2020-09-15 14:16:32', 203, '00:06'),
(37, 'Daffy_Duck', 'Mobility Scooter Race', 'Mobility scooter street racing', 1, 'uploads/videos/5f60b0e0153c3.mp4', 2, '2020-09-15 14:17:36', 8, '00:17'),
(38, 'Mickey_Mouse', 'Car at night', 'Video of car driving through city at night', 1, 'uploads/videos/5f60b11ec0343.mp4', 2, '2020-09-15 14:18:38', 45, '00:10'),
(39, 'Daffy_Duck', 'Girl on Beach', 'Girl sat on Beach looking at waves on the sea.', 1, 'uploads/videos/5f62a6799f49b.mp4', 6, '2020-09-17 01:57:45', 7, '00:13'),
(40, 'Daffy_Duck', 'Rotating Earth', 'Rotating earth at night seen from space.', 1, 'uploads/videos/5f62a6e76f90b.mp4', 14, '2020-09-17 01:59:35', 6, '00:30'),
(41, 'Mickey_Mouse', 'Water Droplet', 'Water droplet hitting a bowl of water', 1, 'uploads/videos/5f62a816878ad.mp4', 14, '2020-09-17 02:04:38', 2, '00:06'),
(42, 'Mickey_Mouse', 'flame', 'A flame burst', 1, 'uploads/videos/5f62a83746058.mp4', 14, '2020-09-17 02:05:11', 14, '00:03'),
(43, 'Daffy_Duck', 'Animated film trailer', 'Animated film trailer', 1, 'uploads/videos/5f6355880ccc0.mp4', 1, '2020-09-17 14:24:40', 1, '00:52'),
(44, 'Mickey_Mouse', 'Moving clouds', 'Clouds moving through the sky', 1, 'uploads/videos/5f6356c0732e6.mp4', 14, '2020-09-17 14:29:52', 1, '01:00'),
(45, 'Goofy_Dog', 'Collie Video', 'Collie dog', 1, 'uploads/videos/5f652a4dc9249.mp4', 4, '2020-09-18 23:44:45', 1, '00:08'),
(47, 'Goofy_Dog', 'A White dog', 'happy white dog sitting lying on grass', 1, 'uploads/videos/5f652d8872cc6.mp4', 4, '2020-09-18 23:58:32', 7, '00:14'),
(48, 'Goofy_Dog', 'Watersports', 'Stand up paddle & scuba diving', 1, 'uploads/videos/5f653018849ce.mp4', 5, '2020-09-19 00:09:28', 5, '00:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `thumbnails`
--
ALTER TABLE `thumbnails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
