-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 07:48 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`S_ID`),
  ADD KEY `FK_1` (`T_ID`),
  ADD KEY `FK_2` (`R_ID`);

--
-- Constraints for dumped tables
--

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
