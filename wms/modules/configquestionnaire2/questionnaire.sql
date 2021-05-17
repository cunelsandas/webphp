-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2019 at 05:49 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web29900`
--

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_detail`
--

CREATE TABLE `questionnaire_detail` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `submaster_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questionnaire_detail`
--

INSERT INTO `questionnaire_detail` (`id`, `project_id`, `master_id`, `submaster_id`, `name`) VALUES
(1, 1, 1, 0, 'ชื่อผู้่ขอรับบริการ'),
(2, 1, 1, 0, 'ที่อยู่ผู้ขอรับบริการ'),
(3, 1, 1, 0, 'โทรศัพท์ผู้ขอรับบริการ'),
(4, 1, 1, 0, 'หน่วยงานที่ขอรับบริการ'),
(5, 1, 2, 0, 'การขอข้อมูลข่าวสารทางราชการ'),
(6, 1, 2, 0, 'การยื่นเรื่องร้องทุกข์/ร้องเรียน'),
(7, 1, 2, 0, 'การใช้อินเตอร์เน็ตตำบล ฟรีไวไฟ'),
(8, 1, 2, 0, 'การขออนุญาตปลูกสร้างอาคาร'),
(9, 1, 2, 0, 'การขอแบบบ้านเพื่อประชาชน'),
(10, 1, 3, 1, 'เจ้าหน้าที่พุดจาสุภาพ อัธยาศัยดี แต่งกายสุภาพ การวางตัวเรียบร้อย'),
(11, 1, 3, 1, 'เจ้าหน้าที่ให้บริการด้วยความเต็มใจ รวดเร็วและเอาใจใส่');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_master`
--

CREATE TABLE `questionnaire_master` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questionnaire_master`
--

INSERT INTO `questionnaire_master` (`id`, `project_id`, `name`, `type_id`) VALUES
(1, 1, 'ส่วนที่ 1 ข้อมูลทั่วไปผู้ขอใช้บริการ', 1),
(2, 1, 'ส่วนที่ 2 เรื่องที่ขอรับบริการ', 2),
(3, 1, 'ส่วนที่ 3 แบบสอบถามความพึงพอใจต่อการให้บริการ', 4),
(4, 1, 'ส่วนที่ 4 ท่านคิดว่าเทศบาลควรปรับปรุงด้านใด ตอบได้มากว่า1ข้อ', 3);

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_project`
--

CREATE TABLE `questionnaire_project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questionnaire_project`
--

INSERT INTO `questionnaire_project` (`id`, `name`) VALUES
(1, 'แบบสำรวจความพึงพอใจต่อการให้บริการของเทศบาล');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_result`
--

CREATE TABLE `questionnaire_result` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `project_id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `submaster_id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  `detail_value` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `edittime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questionnaire_result`
--

INSERT INTO `questionnaire_result` (`id`, `date`, `project_id`, `master_id`, `submaster_id`, `detail_id`, `detail_value`, `ip`, `edittime`) VALUES
(1, '2019-10-08', 1, 1, 0, 1, 'test1', '::1', '2019-10-08 02:55:32'),
(2, '2019-10-08', 1, 1, 0, 2, 'test2', '::1', '2019-10-08 02:55:32'),
(3, '2019-10-08', 1, 1, 0, 3, 'test3', '::1', '2019-10-08 02:55:32'),
(4, '2019-10-08', 1, 1, 0, 4, 'test4', '::1', '2019-10-08 02:55:32'),
(5, '2019-10-08', 1, 2, 0, 5, 'Array', '::1', '2019-10-08 02:55:32'),
(6, '2019-10-08', 1, 2, 0, 6, '', '::1', '2019-10-08 02:55:32'),
(7, '2019-10-08', 1, 2, 0, 7, '', '::1', '2019-10-08 02:55:32'),
(8, '2019-10-08', 1, 2, 0, 8, '', '::1', '2019-10-08 02:55:32'),
(9, '2019-10-08', 1, 2, 0, 9, '', '::1', '2019-10-08 02:55:32'),
(10, '2019-10-08', 1, 3, 1, 10, '', '::1', '2019-10-08 02:55:32'),
(11, '2019-10-08', 1, 3, 1, 11, '', '::1', '2019-10-08 02:55:32'),
(12, '2019-10-08', 1, 1, 0, 1, 'x1', '::1', '2019-10-08 03:06:01'),
(13, '2019-10-08', 1, 1, 0, 2, 'x2', '::1', '2019-10-08 03:06:01'),
(14, '2019-10-08', 1, 1, 0, 3, 'x3', '::1', '2019-10-08 03:06:01'),
(15, '2019-10-08', 1, 1, 0, 4, 'x4', '::1', '2019-10-08 03:06:01'),
(16, '2019-10-08', 1, 2, 0, 5, '', '::1', '2019-10-08 03:06:01'),
(17, '2019-10-08', 1, 2, 0, 6, '', '::1', '2019-10-08 03:06:01'),
(18, '2019-10-08', 1, 2, 0, 7, '', '::1', '2019-10-08 03:06:01'),
(19, '2019-10-08', 1, 2, 0, 8, '', '::1', '2019-10-08 03:06:01'),
(20, '2019-10-08', 1, 2, 0, 9, '', '::1', '2019-10-08 03:06:01'),
(21, '2019-10-08', 1, 3, 1, 10, '', '::1', '2019-10-08 03:06:01'),
(22, '2019-10-08', 1, 3, 1, 11, '', '::1', '2019-10-08 03:06:01'),
(23, '2019-10-08', 1, 1, 0, 1, 'b1', '::1', '2019-10-08 03:20:20'),
(24, '2019-10-08', 1, 1, 0, 2, 'b2', '::1', '2019-10-08 03:20:20'),
(25, '2019-10-08', 1, 1, 0, 3, 'b3', '::1', '2019-10-08 03:20:20'),
(26, '2019-10-08', 1, 1, 0, 4, 'b4', '::1', '2019-10-08 03:20:20'),
(27, '2019-10-08', 1, 2, 0, 5, '', '::1', '2019-10-08 03:20:20'),
(28, '2019-10-08', 1, 2, 0, 6, '', '::1', '2019-10-08 03:20:20'),
(29, '2019-10-08', 1, 2, 0, 7, '', '::1', '2019-10-08 03:20:20'),
(30, '2019-10-08', 1, 2, 0, 8, '', '::1', '2019-10-08 03:20:20'),
(31, '2019-10-08', 1, 2, 0, 9, '', '::1', '2019-10-08 03:20:20'),
(32, '2019-10-08', 1, 3, 1, 10, '3', '::1', '2019-10-08 03:20:20'),
(33, '2019-10-08', 1, 3, 1, 11, '1', '::1', '2019-10-08 03:20:20'),
(34, '2019-10-08', 1, 1, 0, 1, 'g', '::1', '2019-10-08 03:27:43'),
(35, '2019-10-08', 1, 1, 0, 2, 'g', '::1', '2019-10-08 03:27:43'),
(36, '2019-10-08', 1, 1, 0, 3, 'g', '::1', '2019-10-08 03:27:43'),
(37, '2019-10-08', 1, 1, 0, 4, 'g', '::1', '2019-10-08 03:27:43'),
(38, '2019-10-08', 1, 2, 0, 5, 'yes', '::1', '2019-10-08 03:27:43'),
(39, '2019-10-08', 1, 2, 0, 6, 'yes', '::1', '2019-10-08 03:27:43'),
(40, '2019-10-08', 1, 2, 0, 7, 'yes', '::1', '2019-10-08 03:27:43'),
(41, '2019-10-08', 1, 2, 0, 8, 'yes', '::1', '2019-10-08 03:27:43'),
(42, '2019-10-08', 1, 2, 0, 9, 'yes', '::1', '2019-10-08 03:27:43'),
(43, '2019-10-08', 1, 3, 1, 10, '4', '::1', '2019-10-08 03:27:43'),
(44, '2019-10-08', 1, 3, 1, 11, '5', '::1', '2019-10-08 03:27:43'),
(45, '2019-10-08', 1, 1, 0, 1, 'g', '::1', '2019-10-08 03:28:39'),
(46, '2019-10-08', 1, 1, 0, 2, 'g', '::1', '2019-10-08 03:28:39'),
(47, '2019-10-08', 1, 1, 0, 3, 'g', '::1', '2019-10-08 03:28:39'),
(48, '2019-10-08', 1, 1, 0, 4, 'g', '::1', '2019-10-08 03:28:39'),
(49, '2019-10-08', 1, 2, 0, 5, '6', '::1', '2019-10-08 03:28:39'),
(50, '2019-10-08', 1, 2, 0, 6, '6', '::1', '2019-10-08 03:28:39'),
(51, '2019-10-08', 1, 2, 0, 7, '6', '::1', '2019-10-08 03:28:39'),
(52, '2019-10-08', 1, 2, 0, 8, '6', '::1', '2019-10-08 03:28:39'),
(53, '2019-10-08', 1, 2, 0, 9, '6', '::1', '2019-10-08 03:28:39'),
(54, '2019-10-08', 1, 3, 1, 10, '4', '::1', '2019-10-08 03:28:39'),
(55, '2019-10-08', 1, 3, 1, 11, '5', '::1', '2019-10-08 03:28:39'),
(56, '2019-10-08', 1, 1, 0, 1, 'g', '::1', '2019-10-08 03:31:49'),
(57, '2019-10-08', 1, 1, 0, 2, 'g', '::1', '2019-10-08 03:31:49'),
(58, '2019-10-08', 1, 1, 0, 3, 'g', '::1', '2019-10-08 03:31:49'),
(59, '2019-10-08', 1, 1, 0, 4, 'g', '::1', '2019-10-08 03:31:49'),
(60, '2019-10-08', 1, 2, 0, 5, 'no', '::1', '2019-10-08 03:31:49'),
(61, '2019-10-08', 1, 2, 0, 6, 'no', '::1', '2019-10-08 03:31:49'),
(62, '2019-10-08', 1, 2, 0, 7, 'no', '::1', '2019-10-08 03:31:49'),
(63, '2019-10-08', 1, 2, 0, 8, 'no', '::1', '2019-10-08 03:31:49'),
(64, '2019-10-08', 1, 2, 0, 9, 'no', '::1', '2019-10-08 03:31:49'),
(65, '2019-10-08', 1, 3, 1, 10, '4', '::1', '2019-10-08 03:31:49'),
(66, '2019-10-08', 1, 3, 1, 11, '5', '::1', '2019-10-08 03:31:49'),
(67, '2019-10-08', 1, 1, 0, 1, 'g', '::1', '2019-10-08 03:39:16'),
(68, '2019-10-08', 1, 1, 0, 2, 'g', '::1', '2019-10-08 03:39:16'),
(69, '2019-10-08', 1, 1, 0, 3, 'g', '::1', '2019-10-08 03:39:16'),
(70, '2019-10-08', 1, 1, 0, 4, 'g', '::1', '2019-10-08 03:39:16'),
(71, '2019-10-08', 1, 2, 0, 5, '0', '::1', '2019-10-08 03:39:16'),
(72, '2019-10-08', 1, 2, 0, 6, '6', '::1', '2019-10-08 03:39:16'),
(73, '2019-10-08', 1, 2, 0, 7, '0', '::1', '2019-10-08 03:39:16'),
(74, '2019-10-08', 1, 2, 0, 8, '0', '::1', '2019-10-08 03:39:16'),
(75, '2019-10-08', 1, 2, 0, 9, '0', '::1', '2019-10-08 03:39:16'),
(76, '2019-10-08', 1, 3, 1, 10, '4', '::1', '2019-10-08 03:39:16'),
(77, '2019-10-08', 1, 3, 1, 11, '5', '::1', '2019-10-08 03:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_submaster`
--

CREATE TABLE `questionnaire_submaster` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questionnaire_submaster`
--

INSERT INTO `questionnaire_submaster` (`id`, `project_id`, `master_id`, `type_id`, `name`) VALUES
(1, 1, 3, 4, '1 ด้านเจ้าหน้าที่ผู้ให้บริการ'),
(2, 1, 3, 4, '2 ด้านกระบวนการขั้นตอนการให้บริการ'),
(3, 1, 3, 4, '3 ด้านสิ่งอำนวยความสะดวก');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_type`
--

CREATE TABLE `questionnaire_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questionnaire_type`
--

INSERT INTO `questionnaire_type` (`id`, `name`) VALUES
(1, 'inputdata'),
(2, 'select_one'),
(3, 'select_multiple'),
(4, 'point_5choice'),
(5, 'point_3choice');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questionnaire_detail`
--
ALTER TABLE `questionnaire_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_master`
--
ALTER TABLE `questionnaire_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_project`
--
ALTER TABLE `questionnaire_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_result`
--
ALTER TABLE `questionnaire_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_submaster`
--
ALTER TABLE `questionnaire_submaster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_type`
--
ALTER TABLE `questionnaire_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questionnaire_detail`
--
ALTER TABLE `questionnaire_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `questionnaire_master`
--
ALTER TABLE `questionnaire_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questionnaire_project`
--
ALTER TABLE `questionnaire_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questionnaire_result`
--
ALTER TABLE `questionnaire_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `questionnaire_submaster`
--
ALTER TABLE `questionnaire_submaster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questionnaire_type`
--
ALTER TABLE `questionnaire_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
