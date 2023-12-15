-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 08:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internshipmanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_ID` varchar(5) NOT NULL,
  `C_name` varchar(50) NOT NULL,
  `C_telephone` varchar(10) NOT NULL,
  `C_website` text NOT NULL,
  `C_staff_name` varchar(50) NOT NULL,
  `C_staff_position` varchar(50) NOT NULL,
  `C_staff_phone` varchar(10) NOT NULL,
  `C_img` varchar(225) NOT NULL,
  `C_tambon` varchar(50) NOT NULL,
  `C_amphoe` int(50) NOT NULL,
  `C_province` int(50) NOT NULL,
  `timestamp_company` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_ID`, `C_name`, `C_telephone`, `C_website`, `C_staff_name`, `C_staff_position`, `C_staff_phone`, `C_img`, `C_tambon`, `C_amphoe`, `C_province`, `timestamp_company`) VALUES
('12345', 'วัดพระแก้ว', '0983239764', 'https://www.facebook.com/', 'พระเกจิ มาสุโท', 'เจ้าอาววาส', '1234567890', '12345.jpg', 'กุดมง', 0, 0, '2023-12-14 18:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `M_ID` varchar(15) NOT NULL,
  `M_Name` varchar(100) NOT NULL,
  `M_college` varchar(225) NOT NULL,
  `M_img` varchar(225) NOT NULL,
  `M_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`M_ID`, `M_Name`, `M_college`, `M_img`, `M_address`) VALUES
('1', 'คอมพิวเตอร์ธุรกิจดิจ', 'วิทยาลัยการอาชีพขอนแก่น', '1.jpg', 'อ.ชนบท จ.ขอนแก่น');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` varchar(15) NOT NULL,
  `RE_how` varchar(20) NOT NULL,
  `RE_reason` text NOT NULL,
  `RE_teacher_opinion` text NOT NULL,
  `RE_teacherH_opinion` varchar(20) NOT NULL,
  `RE_commentH` varchar(20) NOT NULL,
  `RE_comment` text NOT NULL,
  `RE_status` varchar(45) NOT NULL,
  `S_ID` varchar(10) NOT NULL,
  `company_ID` varchar(5) NOT NULL,
  `RE_period` varchar(50) NOT NULL,
  `timestamp_request` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `RE_how`, `RE_reason`, `RE_teacher_opinion`, `RE_teacherH_opinion`, `RE_commentH`, `RE_comment`, `RE_status`, `S_ID`, `company_ID`, `RE_period`, `timestamp_request`) VALUES
('111111111112345', 'sss', 'eeee', '', '', '', '', '1', '1111111111', '12345', '15/12/2023 - 30/04/2024', '2023-12-14 18:21:55'),
('653423100112345', '1', 's', '', '', '', '', '1', '6534231001', '12345', '15/12/2023 - 30/04/2024', '2023-12-14 18:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `R_ID` int(5) NOT NULL,
  `R_level` varchar(5) NOT NULL,
  `R_level_number` varchar(2) NOT NULL,
  `R_room` varchar(2) NOT NULL,
  `T_ID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`R_ID`, `R_level`, `R_level_number`, `R_room`, `T_ID`) VALUES
(1, 'ปวช.', '2', '5', '4444444444'),
(7, 'ปวช.', '1', '5', '1407600001');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `S_ID` varchar(10) NOT NULL,
  `S_fname` varchar(10) NOT NULL,
  `S_lname` varchar(10) NOT NULL,
  `S_gender` varchar(10) NOT NULL,
  `S_birthday` varchar(10) NOT NULL,
  `S_address` text NOT NULL,
  `S_phone` varchar(10) NOT NULL,
  `S_email` varchar(100) NOT NULL,
  `S_enrollment_term` varchar(1) NOT NULL,
  `S_enrollment_year` varchar(5) NOT NULL,
  `S_status` varchar(10) NOT NULL,
  `S_gpa` varchar(4) NOT NULL,
  `S_health` text NOT NULL,
  `S_major` varchar(50) NOT NULL,
  `S_level` varchar(5) NOT NULL,
  `S_img` varchar(225) NOT NULL,
  `S_ralative_name` varchar(50) NOT NULL,
  `S_ralative_phone` varchar(10) NOT NULL,
  `S_ralative_address` text NOT NULL,
  `T_ID` varchar(10) NOT NULL,
  `R_ID` int(5) NOT NULL,
  `S_username` varchar(50) NOT NULL,
  `S_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`S_ID`, `S_fname`, `S_lname`, `S_gender`, `S_birthday`, `S_address`, `S_phone`, `S_email`, `S_enrollment_term`, `S_enrollment_year`, `S_status`, `S_gpa`, `S_health`, `S_major`, `S_level`, `S_img`, `S_ralative_name`, `S_ralative_phone`, `S_ralative_address`, `T_ID`, `R_ID`, `S_username`, `S_password`) VALUES
('1111111111', 'ธัญญารัตน์', 'อาจจะสวย', 'ชาย', '2001-07-03', ' -', '2222222222', '11@gmail.com', '1', '2566', '0', '3.14', ' -', 'สาขาเทคโนโลยีธุรกิจดิจิทัล', '', '1111111111.jpg', 'เศรษฐวัฒน์ พันธสาร', '0981291439', ' -', '1407600001', 1, '11@gmail.com', '1111111111'),
('6534231001', 'วชิระ', 'บุญปก', 'ชาย', '2014-12-31', 's', '0983239764', 'w@gmail.com', '1', '2566', '0', '3.77', 's', 'สาขาเทคโนโลยีธุรกิจดิจิทัล', '', '6534231001.jpg', '9', '0983239764', 's', '4444444444', 7, 'w@gmail.com', '6534231001');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `T_ID` varchar(10) NOT NULL,
  `T_fname` varchar(50) NOT NULL,
  `T_lname` varchar(50) NOT NULL,
  `T_position` varchar(50) NOT NULL,
  `T_address` text NOT NULL,
  `T_birthday` date NOT NULL,
  `T_img` varchar(225) NOT NULL,
  `T_status` varchar(1) NOT NULL,
  `T_phone` varchar(10) NOT NULL,
  `T_email` varchar(100) NOT NULL,
  `T_gender` varchar(10) NOT NULL,
  `T_password` varchar(15) NOT NULL,
  `T_username` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`T_ID`, `T_fname`, `T_lname`, `T_position`, `T_address`, `T_birthday`, `T_img`, `T_status`, `T_phone`, `T_email`, `T_gender`, `T_password`, `T_username`) VALUES
('1407600001', 'วชิระ1', 'บุญปก', 'ครูชำนาญการ', '-', '2001-07-04', '1407600001.jpg', '1', '0983239764', 'ta@gmail.com', 'ชาย', '1234567890', 'T1'),
('4444444444', 'วชิระ0', 'บุญปก', 'ครูชำนาญพิเศษ', ' -', '2014-08-07', '4444444444.jpg', '0', '0983239764', 'w@gmail.com', 'ชาย', '1234567890', 'T0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_ID`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`M_ID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `FK_1` (`S_ID`),
  ADD KEY `FK_2` (`company_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`R_ID`),
  ADD KEY `FK_1` (`T_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`S_ID`),
  ADD KEY `FK_1` (`T_ID`),
  ADD KEY `FK_2` (`R_ID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`T_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `R_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `FK_4` FOREIGN KEY (`S_ID`) REFERENCES `student` (`S_ID`),
  ADD CONSTRAINT `FK_5` FOREIGN KEY (`company_ID`) REFERENCES `company` (`company_ID`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `FK_9_1` FOREIGN KEY (`T_ID`) REFERENCES `teacher` (`T_ID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_1` FOREIGN KEY (`T_ID`) REFERENCES `teacher` (`T_ID`),
  ADD CONSTRAINT `FK_2` FOREIGN KEY (`R_ID`) REFERENCES `room` (`R_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
