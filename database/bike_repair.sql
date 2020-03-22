-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2020 at 04:00 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bike_repair`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_lg`
--

CREATE TABLE `admin_lg` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `First_Name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `Last_Name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_lg`
--

INSERT INTO `admin_lg` (`id`, `username`, `password`, `First_Name`, `Last_Name`, `status`) VALUES
(6, 'admin', '$2y$10$ygQSVDRCaKRw8iQ/RbvzkuKZbLu.FglB7lat6jidWcVia9EkVBjru', 'Bunditpong', 'Tapinta', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bike_user`
--

CREATE TABLE `bike_user` (
  `bu_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bike_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `year_bike` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bike_user`
--

INSERT INTO `bike_user` (`bu_id`, `user_id`, `bike_id`, `color`, `year_bike`, `brand`) VALUES
(16, 1, 'กง1151', 'เขียว', '2552', 'honda');

-- --------------------------------------------------------

--
-- Table structure for table `dealer`
--

CREATE TABLE `dealer` (
  `dl_id` int(11) NOT NULL,
  `dl_nameshop` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dl_address` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dl_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `line` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dealer`
--

INSERT INTO `dealer` (`dl_id`, `dl_nameshop`, `dl_address`, `dl_email`, `dl_phone`, `facebook`, `line`) VALUES
(2, 'Honda', 'asdasdsada', 'Honda@hotmail.com', '1234566789', 'HondaBigWing', '@Honda');

-- --------------------------------------------------------

--
-- Table structure for table `detail_repair`
--

CREATE TABLE `detail_repair` (
  `dt_id` int(11) NOT NULL,
  `h_id` int(11) NOT NULL,
  `bike_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `p_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `num` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `detail_repair`
--

INSERT INTO `detail_repair` (`dt_id`, `h_id`, `bike_id`, `p_id`, `price`, `num`) VALUES
(45, 46, 'กง1151', 30, 1600, 1),
(46, 46, 'กง1151', 31, 350, 1);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `h_id` int(11) NOT NULL,
  `bike_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `h_detail` text COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`h_id`, `bike_id`, `user_id`, `datetime`, `h_detail`, `staff_id`) VALUES
(46, 'กง1151', 1, '2020-03-22 14:58:00', 'asdasdasd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `pname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `numproduct` int(7) NOT NULL,
  `detail` text COLLATE utf8_unicode_ci NOT NULL,
  `dl_id` int(11) NOT NULL,
  `dl_insurance` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `num_insurance` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `pname`, `price`, `numproduct`, `detail`, `dl_id`, `dl_insurance`, `num_insurance`) VALUES
(30, 'โซ่ DID. O-ring สีทอง 120L', 1600, 98, '  ใช้ได้กับรถ Wave 125 / Wave 110i', 2, 'ไม่มี', '0'),
(31, 'น้ำมันเครื่อง', 350, 97, ' ใช้ได้กับรถจักรยานยนต์ Wave125 / Wave 110i', 2, 'ไม่มี', '0');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_fname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `staff_lname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `staff_address` text COLLATE utf8_unicode_ci NOT NULL,
  `staff_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `staff_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `staff_duty` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_fname`, `staff_lname`, `staff_address`, `staff_email`, `staff_phone`, `staff_duty`) VALUES
(1, 'จอห์น', 'ดอย', '25/2 ต.แม่นาเติง อ.ปาย จ.แม่ฮ่องสอน', 'john_112@hotmail.com', '0631820019', 'พนักงานซ่อม');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idcard` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `user_address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `user_facebook` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_line` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `idcard`, `user_address`, `phone`, `email`, `user_facebook`, `user_line`) VALUES
(1, 'สมศรี', 'ดีจริง', '1580300087300', '111/1 ต.แม่นาเติง อ.ปาย จ.แม่ฮ่องสอน', '0953103854', 'Somsee_112@hotmail.com', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_lg`
--
ALTER TABLE `admin_lg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bike_user`
--
ALTER TABLE `bike_user`
  ADD PRIMARY KEY (`bu_id`);

--
-- Indexes for table `dealer`
--
ALTER TABLE `dealer`
  ADD PRIMARY KEY (`dl_id`);

--
-- Indexes for table `detail_repair`
--
ALTER TABLE `detail_repair`
  ADD PRIMARY KEY (`dt_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`h_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_lg`
--
ALTER TABLE `admin_lg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bike_user`
--
ALTER TABLE `bike_user`
  MODIFY `bu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dealer`
--
ALTER TABLE `dealer`
  MODIFY `dl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_repair`
--
ALTER TABLE `detail_repair`
  MODIFY `dt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
