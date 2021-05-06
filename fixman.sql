-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2021 at 08:17 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fixman`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitylog`
--

CREATE TABLE `activitylog` (
  `no` int(11) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activitylog`
--

INSERT INTO `activitylog` (`no`, `user_type`, `id`, `created`) VALUES
(258, 'Customer', 1000002, '2021-05-05 10:33:18'),
(259, 'Customer', 1000002, '2021-05-05 11:09:45'),
(260, 'Customer', 1000002, '2021-05-05 13:11:49'),
(261, 'Repairman', 40, '2021-05-05 14:51:17'),
(262, 'Repairman', 63, '2021-05-05 15:02:22'),
(263, 'Repairman', 40, '2021-05-05 15:05:37'),
(264, 'Repairman', 40, '2021-05-05 15:12:12'),
(265, 'Customer', 1000002, '2021-05-05 15:45:50'),
(266, 'Customer', 1000002, '2021-05-05 16:29:22'),
(267, 'Repairman', 40, '2021-05-05 23:38:59'),
(268, 'Customer', 1000002, '2021-05-05 23:56:43'),
(269, 'Repairman', 40, '2021-05-05 23:56:59'),
(270, 'Repairman', 62, '2021-05-05 23:59:22'),
(271, 'Repairman', 40, '2021-05-05 23:59:42'),
(272, 'Customer', 1000002, '2021-05-06 00:17:08'),
(273, 'Customer', 1000002, '2021-05-06 00:39:19'),
(274, 'Repairman', 62, '2021-05-06 01:47:57'),
(275, 'Repairman', 40, '2021-05-06 01:48:04'),
(276, 'Customer', 1000002, '2021-05-06 02:04:36'),
(277, 'Repairman', 40, '2021-05-06 02:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `no` int(11) NOT NULL,
  `bookingid` varchar(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `repairmanid` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `timebooked` varchar(50) NOT NULL,
  `dateob` varchar(50) NOT NULL,
  `endob` varchar(50) NOT NULL,
  `timeob` time NOT NULL,
  `category` varchar(50) NOT NULL,
  `fee` decimal(11,2) NOT NULL,
  `totaldays` varchar(50) NOT NULL,
  `totalfee` decimal(11,2) NOT NULL,
  `reason` varchar(200) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `repairmanid` int(11) NOT NULL,
  `bookingid` varchar(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id`, `repairmanid`, `bookingid`, `title`, `start`, `end`) VALUES
(6, 40, '876dac', '01:00 PM', '2021-06-01 00:00:00', '2021-06-10 00:00:00'),
(7, 40, '876dac', 'Liza Soberano', '2021-06-01 00:00:00', '2021-06-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `messto` int(11) NOT NULL,
  `messfrom` int(11) NOT NULL,
  `chatid` varchar(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `created` varchar(21) NOT NULL,
  `useen` varchar(10) NOT NULL,
  `rseen` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `moodofpayment`
--

CREATE TABLE `moodofpayment` (
  `modid` int(11) NOT NULL,
  `repairmanid` int(11) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `bankno` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `paymentapp` varchar(50) NOT NULL,
  `paymentappname` varchar(50) NOT NULL,
  `paymentappnumber` varchar(50) NOT NULL,
  `paymentappqrcode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `moodofpayment`
--

INSERT INTO `moodofpayment` (`modid`, `repairmanid`, `bank`, `bankno`, `name`, `paymentapp`, `paymentappname`, `paymentappnumber`, `paymentappqrcode`) VALUES
(23, 29, 'BDO', '123412341234', 'Jomar Mahusay', 'Coins.Ph', 'Jomar Mahusay', '09988256352', 'qrcode1.jpg'),
(35, 40, 'BPI', '1111111111111111', 'Juan Ponce Enrile', 'GCash', 'Juan Ponce Enrile', '09988256352', 'qrcode1.jpg'),
(36, 61, 'BPI', '4563463', 'Manny Pacquiao', 'GCash', 'Manny Pacquiao', '01234567891', 'qrcode1.jpg'),
(37, 60, 'BPI', '34534534', 'Nancy Binay', 'Coins.Ph', 'Nancy Binay', '01234567891', 'qrcode.jpg'),
(38, 62, 'Metrobank', '3141241', 'Sonny Angara', 'GCash', 'Sonny Angara', '01234567891', 'qrcode1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `no` int(11) NOT NULL,
  `notifid` varchar(11) NOT NULL,
  `notifto` int(11) NOT NULL,
  `notiffrom` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `created` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`no`, `notifid`, `notifto`, `notiffrom`, `content`, `link`, `created`, `status`) VALUES
(216, 'bf3ed', 1000002, 40, 'Your booking for Mechanic has been approved', 'http://localhost/fixman/user/customerviewbookingdetailsstep1.php?bookingid=876dac&repairmanid=40&notifid=bf3ed', '2021-05-06 02:07:53', 0),
(217, 'cb3f5', 1000002, 40, 'You still have unpaid booking for Mechanic.', 'http://localhost/fixman/user/customerviewbookingdetailsstep2.php?bookingid=876dac&repairmanid=40&notifid=cb3f5', '2021-05-06 02:16:44', 0),
(218, '12b20', 1000002, 40, 'You can rate and give feedback to your Mechanic.', 'http://localhost/fixman/user/customerviewbookingdetailsstep3.php?bookingid=876dac&repairmanid=40&notifid=12b20', '2021-05-06 02:17:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ratingsandfeedback`
--

CREATE TABLE `ratingsandfeedback` (
  `ratingandfeedbackid` int(11) NOT NULL,
  `bookingid` varchar(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `repairmanid` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratingsandfeedback`
--

INSERT INTO `ratingsandfeedback` (`ratingandfeedbackid`, `bookingid`, `userid`, `repairmanid`, `rate`, `feedback`, `created`) VALUES
(47, '567695', 1000002, 40, 5, 'Professional', '2021-04-19'),
(48, 'ea1c6c', 1000002, 40, 4, 'asdasdf', '2021-04-19'),
(49, '2a86c6', 1000002, 40, 3, 'hi', '2021-04-19'),
(50, 'b1193d', 1000002, 40, 4, 'hello', '2021-04-19'),
(51, 'bfd362', 1000002, 40, 5, 'hehehe', '2021-04-20');

-- --------------------------------------------------------

--
-- Table structure for table `repairman`
--

CREATE TABLE `repairman` (
  `repairmanid` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `bdate` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `contactno` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `fee` decimal(11,2) NOT NULL,
  `documents` varchar(100) NOT NULL,
  `documents2` varchar(50) NOT NULL,
  `documents3` varchar(50) NOT NULL,
  `profilepix` varchar(200) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `transaction` varchar(50) NOT NULL,
  `paymentopt` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repairman`
--

INSERT INTO `repairman` (`repairmanid`, `fname`, `mname`, `lname`, `age`, `bdate`, `address`, `contactno`, `gender`, `username`, `password`, `email`, `category`, `experience`, `fee`, `documents`, `documents2`, `documents3`, `profilepix`, `user_type`, `status`, `transaction`, `paymentopt`) VALUES
(29, 'xjomar1', 'dimagiba1', 'mahusay1', 12, '1997-09-20', 'Suba-Masulog Lapu-Lapu City', '0123456789', 'Female', 'repairman', 'repairman', 'hahaha@gmail.com', 'Electrician', '6 - 10 years', '450.00', 'nc2 for electrician.jpg', '', '', 'cat.jpg', 'Repairman', 'Approved', 'Available', '1'),
(40, 'Juan', 'Ponce', 'Enrile', 97, '1997-09-20', 'Pajac Lapu-Lapu City', '09988256352', 'Male', 'juan', '123456', 'juan@yahoo.com', 'Mechanic', '11- 15 years', '750.00', 'nc2 for electrician.jpg', '', '', 'cat.jpg', 'Repairman', 'Approved', 'Available', '1'),
(60, 'Nancy', 'Binay', 'Binay', 1, '2020-01-01', 'Canjulao', '09123456789', 'Female', 'nancy', 'nancy', 'nancy@yahoo.com', 'Carpenter', '11- 15 years', '500.00', 'nc2 for electrician.jpg', '', '', '../profilepix/1619714999.png', 'Repairman', 'Approved', 'Available', '1'),
(61, 'Manny', 'Pacman', 'Pacquiao', 21, '2000-01-01', 'Mandaue City', '09123456789', 'Male', 'manny', 'manny', 'manny@yahoo.com', 'Plumber', '6 - 10 years', '580.00', 'nc2 for electrician.jpg', '', '', '../profilepix/1619715092.png', 'Repairman', 'Approved', 'Available', '1'),
(62, 'Sonny', 'Angara', 'Angara', 21, '2000-01-01', 'Cebu City', '09123456789', 'Male', 'sonny', 'sonny', 'sonny@yahoo.com', 'Technician', '0 - 5 years', '560.50', 'nc2 for electrician.jpg', '', '', '../profilepix/1619715165.png', 'Repairman', 'Approved', 'Available', '1'),
(63, 'Seanmark', 'Godinez', 'Canete', 23, '1997-09-20', 'Suba-Masulog Lapu-Lapu City', '0123456789', 'Male', 'seanmark', 'seanmark', 'seanmark@yahoo.com', 'Electrician', '6 - 10 years', '0.00', 'nc2 for electrician.jpg', '', '', '../profilepix/1620197943.png', 'Repairman', 'Approved', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `bdate` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `contactno` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `profilepix` varchar(200) NOT NULL,
  `code` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `fname`, `mname`, `lname`, `age`, `bdate`, `address`, `contactno`, `gender`, `username`, `password`, `email`, `user_type`, `profilepix`, `code`, `status`) VALUES
(1, '', '', '', 0, '0000-00-00', '', '', '', 'admin', 'admin', 'admin@yahoo.com', 'Admin', '', '', ''),
(1000002, 'Liza', 'Liza', 'Soberano', 20, '1997-09-20', 'Suba-Masulog Lapu Lapu City', '09123456789', 'Male', 'user', 'user', 'qwerty@yahoo.com', 'Customer', 'cat.jpg', '6153cdae', 'Verified'),
(1000019, 'Kyle', 'Godinez', 'Canete', 23, '1997-09-20', 'Suba-Masulog Lapu-Lapu City', '09988256352', 'Male', 'anbuk54', 'kyle123', 'kyle_54cute@yahoo.com', 'Customer', '../profilepix/1620192028.png', '9675ecbc', 'Verified');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitylog`
--
ALTER TABLE `activitylog`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moodofpayment`
--
ALTER TABLE `moodofpayment`
  ADD PRIMARY KEY (`modid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `ratingsandfeedback`
--
ALTER TABLE `ratingsandfeedback`
  ADD PRIMARY KEY (`ratingandfeedbackid`),
  ADD UNIQUE KEY `bookingid` (`bookingid`);

--
-- Indexes for table `repairman`
--
ALTER TABLE `repairman`
  ADD PRIMARY KEY (`repairmanid`);

--
-- Indexes for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activitylog`
--
ALTER TABLE `activitylog`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT for table `moodofpayment`
--
ALTER TABLE `moodofpayment`
  MODIFY `modid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `ratingsandfeedback`
--
ALTER TABLE `ratingsandfeedback`
  MODIFY `ratingandfeedbackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `repairman`
--
ALTER TABLE `repairman`
  MODIFY `repairmanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000020;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
