-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: shareddb1e.hosting.stackcp.net
-- Generation Time: Aug 30, 2019 at 02:40 PM
-- Server version: 10.2.26-MariaDB-log
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `PhatData-3233ccd6`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(16) NOT NULL,
  `block` varchar(255) NOT NULL,
  `start` text NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `block`, `start`, `data`) VALUES
(1, 'chat-box', '{}', '[{\"user\":\"chris\",\"msg\":\"!@#$%^&*()_+\",\"date\":\"2019-02-17 19:18:51\"},{\"user\":\"chris\",\"msg\":\"!\",\"date\":\"2019-02-17 19:18:56\"},{\"user\":\"chris\",\"msg\":\"@\",\"date\":\"2019-02-17 19:18:58\"},{\"user\":\"chris\",\"msg\":\"#\",\"date\":\"2019-02-17 19:18:59\"},{\"user\":\"chris\",\"msg\":\"$\",\"date\":\"2019-02-17 19:19:02\"},{\"user\":\"chris\",\"msg\":\"%\",\"date\":\"2019-02-17 19:19:03\"},{\"user\":\"chris\",\"msg\":\"^\",\"date\":\"2019-02-17 19:19:03\"},{\"user\":\"chris\",\"msg\":\"&\",\"date\":\"2019-02-17 19:19:05\"},{\"user\":\"chris\",\"msg\":\"*\",\"date\":\"2019-02-17 19:19:06\"},{\"user\":\"chris\",\"msg\":\"(\",\"date\":\"2019-02-17 19:19:07\"},{\"user\":\"chris\",\"msg\":\")\",\"date\":\"2019-02-17 19:19:09\"},{\"user\":\"chris\",\"msg\":\"_\",\"date\":\"2019-02-17 19:19:10\"},{\"user\":\"chris\",\"msg\":\"+\",\"date\":\"2019-02-17 19:19:11\"},{\"user\":\"chris\",\"msg\":\"!@\",\"date\":\"2019-02-17 19:19:13\"},{\"user\":\"chris\",\"msg\":\"@#\",\"date\":\"2019-02-17 19:19:14\"},{\"user\":\"chris\",\"msg\":\"#$\",\"date\":\"2019-02-17 19:19:14\"},{\"user\":\"chris\",\"msg\":\"$%\",\"date\":\"2019-02-17 19:19:15\"},{\"user\":\"chris\",\"msg\":\"%^\",\"date\":\"2019-02-17 19:19:16\"},{\"user\":\"chris\",\"msg\":\"^&\",\"date\":\"2019-02-17 19:19:16\"},{\"user\":\"chris\",\"msg\":\"&*\",\"date\":\"2019-02-17 19:19:17\"},{\"user\":\"chris\",\"msg\":\"*(\",\"date\":\"2019-02-17 19:19:18\"},{\"user\":\"chris\",\"msg\":\"()\",\"date\":\"2019-02-17 19:19:18\"},{\"user\":\"chris\",\"msg\":\")_\",\"date\":\"2019-02-17 19:19:19\"},{\"user\":\"chris\",\"msg\":\"_+\",\"date\":\"2019-02-17 19:19:21\"},{\"user\":\"chris\",\"msg\":\"!@#$%\",\"date\":\"2019-02-17 19:19:30\"},{\"user\":\"chris\",\"msg\":\"^&*()_+\",\"date\":\"2019-02-17 19:19:32\"},{\"user\":\"chris\",\"msg\":\"#$%^&*\",\"date\":\"2019-02-17 19:19:37\"},{\"user\":\"chris\",\"msg\":\"!@#$%^&*()_+\",\"date\":\"2019-02-17 19:19:43\"},{\"user\":\"chris\",\"msg\":\"!@#$%^&*()_+\",\"date\":\"2019-02-17 19:19:47\"},{\"user\":\"chris\",\"msg\":\"YAY :D\",\"date\":\"2019-02-20 17:10:49\"},{\"user\":\"chris\",\"msg\":\"Chatroom works! \",\"date\":\"2019-02-20 17:11:08\"},{\"user\":\"chris\",\"msg\":\"need moar cafe\",\"date\":\"2019-02-20 17:12:00\"},{\"user\":\"chris\",\"msg\":\"This success deserves some Apex.\",\"date\":\"2019-02-20 17:15:53\"},{\"user\":\"null\",\"msg\":\"\",\"date\":\"2019-02-21 12:53:20\"},{\"user\":\"abe\",\"msg\":\"yo\",\"date\":\"2019-02-27 04:06:10\"},{\"user\":\"abe\",\"msg\":\"this is abe\",\"date\":\"2019-06-22 04:59:33\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(16) NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(16) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `options` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
