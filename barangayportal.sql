-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 07:31 PM
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
-- Database: `barangayportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `announcement_date` varchar(30) DEFAULT NULL,
  `announcement_time` varchar(10) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `is_pinned` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `content`, `created_at`, `announcement_date`, `announcement_time`, `image_path`, `video_path`, `is_pinned`) VALUES
(425, 'Pahibalo!!\r\nBarangay San Miguel, Tagum City\r\nOktubre 9, 2024\r\n\r\nMaayong Adlaw, Pumuluyo!\r\n\r\nGusto namo ipahibalo nga adunay miting nga pagahimoon sa:\r\n\r\nPetsa: [10/10/10]\r\nOras: [Mga alas 3 sa kadlawn]\r\nLugar: [Malamang sa barangay hall asa paman diay!]\r\n\r\nAng miting maghisgot sa bag-ong iskedyul para sa mga kalihokan sa komunidad. Dako ang among pagpasalamat sa inyong kooperasyon ug partisipasyon.\r\n\r\nPinakamaayong panghinaut,\r\n[Imong Ngalan]\r\nKapitan sa Barangay,\r\n\r\n\r\n[Imong Ngalan]                         [Oras og Kanus a]\r\nKapitan sa Barangay', '2024-10-09 12:27:46', 'October 09, 2024', '08:27 PM', NULL, NULL, 1),
(426, 'Barangay sanmiguel shiish', '2024-10-09 14:50:10', 'October 09, 2024', '10:50 PM', 'IMG-670698233c0863.77038645.png', NULL, 1),
(427, 'Ugma mag buhat ko atong ma add ang residents sa admin tho dapat lang', '2024-10-09 14:52:58', 'October 09, 2024', '10:52 PM', NULL, NULL, 1),
(429, 'Ang Katong complain pud e himog katong drodown toggle aron maka butang patag user_type duhhh!', '2024-10-09 15:23:47', 'October 09, 2024', '11:23 PM', NULL, NULL, 1),
(430, 'tae', '2024-10-12 15:47:53', 'October 12, 2024', '11:47 PM', 'IMG-670a9a292b5f70.66914100.png', NULL, 1),
(431, 'Pahibalo!!\r\nBarangay San Miguel, Tagum City\r\nOktubre 9, 2024\r\n\r\nMaayong Adlaw, Pumuluyo!\r\n\r\nGusto namo ipahibalo nga adunay miting nga pagahimoon sa:\r\n\r\nPetsa: [Ibutang ang Petsa]\r\nOras: [Ibutang ang Oras]\r\nLugar: [Ibutang ang Lugar]\r\n\r\nAng miting maghisgot sa bag-ong iskedyul para sa mga kalihokan sa komunidad. Dako ang among pagpasalamat sa inyong kooperasyon ug partisipasyon.\r\n\r\nPinakamaayong panghinaut,\r\n[Imong Ngalan]\r\nKapitan sa Barangay,\r\n\r\n\r\n[Imong Ngalan]                         [Oras og Kanus a]\r\nKapitan sa Barangay', '2024-10-13 09:47:40', 'October 13, 2024', '05:47 PM', NULL, NULL, 1),
(432, 'tae', '2024-10-14 15:26:59', 'October 14, 2024', '11:26 PM', 'IMG-670d384321edb2.00765459.jpg', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `barangay_applications`
--

CREATE TABLE `barangay_applications` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `emailad` varchar(255) DEFAULT NULL,
  `application_code` varchar(5) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `pickup_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_applications`
--

INSERT INTO `barangay_applications` (`id`, `full_name`, `address`, `contact_number`, `purpose`, `created_at`, `emailad`, `application_code`, `status`, `pickup_date`) VALUES
(21, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 09:23:56', 'f.amoguis.141492.tc@umindanao.edu.ph', 'OUCEE', 'Pending', NULL),
(22, 'longlong', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 09:40:13', 'f55876061@gmail.com', '91ZST', 'Claim', NULL),
(23, 'Kirigaya Sanraku', 'Pangi Maco Comval', '', 'Compostela Valley', '2024-10-14 11:24:55', 'f55876061@gmail.com', 'APLXU', 'Claim', NULL),
(24, 'Kirigaya Kirito', 'Pangi Maco Comval', '', 'Compostela Valley', '2024-10-14 11:25:44', 'f.amoguis.141492.tc@umindanao.edu.ph', '89XKN', 'Claim', NULL),
(25, 'prank', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 11:28:00', 'f55876061@gmail.com', '72047', 'Claim', NULL),
(26, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 14:28:51', '', 'UWHO0', 'Pending', NULL),
(27, 'Plonglong', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 14:41:35', 'f55876061@gmail.com', 'KD061', 'Claim', NULL),
(28, 'longskie', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 14:45:57', 'nestorbacojr876@gmail.com', 'LZD9K', 'Claim', NULL),
(29, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 14:46:51', 'nestorbacojr876@gmail.com', 'Z58BT', 'Pending', NULL),
(30, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 14:48:12', 'f55876061@gmail.com', 'QURLT', 'Pending', NULL),
(31, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 14:48:56', 'f55876061@gmail.com', '08N0L', 'Pending', NULL),
(32, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 14:50:04', 'f55876061@gmail.com', 'XXXF3', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barangay_clearance`
--

CREATE TABLE `barangay_clearance` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `emailad` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pickup_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `submission_date` date DEFAULT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_clearance`
--

INSERT INTO `barangay_clearance` (`id`, `name`, `address`, `contact`, `emailad`, `purpose`, `created_at`, `pickup_date`, `status`, `submission_date`, `code`) VALUES
(31, 'Kirigaya Sanraku', '', '09079254972', 'f.amoguis.141492.tc@umindanao.edu.ph', 'Compostela Valley', '2024-10-14 09:18:01', NULL, 'Pending', '2024-10-16', 'um5eu'),
(32, 'Kirigaya Sanraku', '', '09079254972', 'f55876061@gmail.com', 'Compostela Valley', '2024-10-14 10:28:24', NULL, 'Claim', '2024-10-26', 'hwVDa'),
(33, 'Kirigaya Sanraku', '', '09079254972', 'f.amoguis.141492.tc@umindanao.edu.ph', 'Compostela Valley', '2024-10-14 11:18:35', NULL, 'Pending', '2024-10-15', '1lINs'),
(34, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'f.amoguis.141492.tc@umindanao.edu.ph', 'Compostela Valley', '2024-10-14 11:22:23', NULL, 'Pending', '2024-10-15', '4ojNx'),
(35, 'Kirigaya Sanraku', '', '09079254972', 'ebrgyweb0911@gmail.com', 'Compostela Valley', '2024-10-14 11:22:50', NULL, 'Pending', '2024-10-14', '3H1m3'),
(36, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'f.amoguis.141492.tc@umindanao.edu.ph', 'Compostela Valley', '2024-10-14 11:23:55', NULL, 'Claim', '2024-10-04', 'PFjIP');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_permits`
--

CREATE TABLE `barangay_permits` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `purpose` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `emailad` varchar(255) DEFAULT NULL,
  `submission_date` datetime DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `pickup_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_permits`
--

INSERT INTO `barangay_permits` (`id`, `name`, `address`, `phone`, `purpose`, `created_at`, `emailad`, `submission_date`, `code`, `status`, `pickup_date`) VALUES
(25, 'Kirigaya Sanraku', 'Pangi Maco Comval', '09079254972', 'Compostela Valley', '2024-10-14 11:44:21', 'f55876061@gmail.com', '2024-10-14 13:44:21', 'fP8Dr', 'Claim', NULL),
(26, 'tae', 'Pangi Maco Comval', '09', 'Compostela Valley', '2024-10-14 17:16:17', 'nestorbacojr876@gmail.com', '2024-10-14 19:16:17', 'ME1Wg', 'Claim', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `id` int(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT '''user''',
  `position` varchar(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `civil_status` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `verify_token` varchar(255) NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `city_municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `otp_verified` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`id`, `user_type`, `position`, `first_name`, `middle_name`, `last_name`, `age`, `birthdate`, `place_of_birth`, `gender`, `civil_status`, `email`, `password`, `phone`, `verify_token`, `barangay_name`, `city_municipality`, `province`, `zip_code`, `otp_verified`, `created_at`) VALUES
(130, 'Admin', '', 'Francis Jay', 'Marcojos', 'Maco', 22, '2002-05-09', 'Tagum Doctors Hospital', 'Male', 'Single', 'f55876061@gmail.com', '$2y$10$kMFRsaa.Q3iwIiULDXLu6OpcoeB/nq4tHQ9D5xw2KY2cdudn2m/uO', '09079254972', '968595', 'Prk Avocado', 'Maco', 'Compostela Valley', '8806', 1, '2024-08-25 10:10:59'),
(161, 'Residents', '', 'Damnson!', 'Marcojos', 'Sanraku', 13, '2024-10-16', 'Tagum Doctors Hospital', 'Male', 'Single', 'nestorbacojr876@gmail.com', '$2y$10$BvSsGmKgvOfC.SoXKfoZq.VoBgkUXvNkknCUKRkVTyoU8N9eqInqe', '09079254972', '769899', 'Prk Durian', 'Maco', 'Compostela Valley', '8806', 1, '2024-10-14 12:31:10'),
(162, 'Residents', '', 'Bulok na longlon', 'Marcojos', 'Longlong', 13, '2024-10-15', 'Tagum Doctors Hospital', 'Male', 'Single', 'francisjay0911@gmail.com', '$2y$10$G4Tq4IuJJZ2z49HRaDIBOufom/Wx4/znnYMISF1dgELmIhKLUp0Sq', '09079254972', '357958', 'Prk Avocado', 'Davao', 'Davao', '8806', 1, '2024-10-14 12:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `tblblotter`
--

CREATE TABLE `tblblotter` (
  `id` int(11) NOT NULL,
  `complainant` varchar(255) NOT NULL,
  `respondent` varchar(255) NOT NULL,
  `victim` varchar(255) NOT NULL,
  `blotter_type` enum('Amicable','Incident') NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('Active','Settled','Schedule','Pending') NOT NULL,
  `details` text NOT NULL,
  `time_am_pm` time DEFAULT NULL,
  `date` date NOT NULL,
  `formatted_date` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `days_of_week` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblblotter`
--

INSERT INTO `tblblotter` (`id`, `complainant`, `respondent`, `victim`, `blotter_type`, `location`, `status`, `details`, `time_am_pm`, `date`, `formatted_date`, `created_at`, `start_time`, `end_time`, `days_of_week`) VALUES
(185, 'asd', 'asdasd', 'asd', 'Amicable', 'Pangi', 'Settled', 'asdasdasda hahaha', '22:46:00', '2024-10-01', NULL, '2024-10-01 14:47:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(187, 'nigga', 'aa', 'aa', 'Amicable', 'a', 'Schedule', 'haha', '23:10:00', '2024-10-03', NULL, '2024-10-02 15:11:05', '2024-10-05 18:45:00', '2024-10-05 21:45:00', 'Monday'),
(196, 'Flowngiiii', 'Test', 'Francis huhu', 'Amicable', 'Pangi', 'Schedule', 'wahaha\r\n', '21:00:00', '2024-10-04', NULL, '2024-10-04 13:01:02', '2024-10-06 17:07:00', '2024-10-06 18:07:00', 'Monday'),
(198, 'asd', 'asdasd', 'asd', 'Amicable', 'asd', 'Schedule', 'asdasd', '21:13:00', '2024-10-04', NULL, '2024-10-04 13:13:26', '2024-10-05 18:45:00', '2024-10-05 08:45:00', 'Tuesday'),
(199, 'Flowngiiii', 'asdas', 'dasd', 'Amicable', 'asd', 'Settled', 'asdasdasd', '21:19:00', '2024-10-04', NULL, '2024-10-04 13:19:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(200, 'Nestor', 'Test', 'test', 'Incident', 'Pangi', 'Pending', 'wahaha', '21:52:00', '2024-10-04', NULL, '2024-10-04 13:52:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(201, 'Flowngiiii', 'Test', 'assd', 'Amicable', 'Pangi', 'Pending', 'wahahah pending', '22:05:00', '2024-10-04', NULL, '2024-10-04 14:05:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(202, 'asda', 'sdasd', 'asdas', 'Amicable', 'asdas', 'Pending', 'asdasd', '18:30:00', '0000-00-00', NULL, '2024-10-05 10:30:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(203, 'asd', 'asdasd', 'asd', 'Amicable', 'aasdas', 'Pending', 'asdasd', '18:34:00', '0000-00-00', 'October 5, 2024', '2024-10-05 10:34:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(205, 'Flowngiiii', 'asdasd', 'Nestorprocedure', 'Amicable', 'Pangi', 'Schedule', 'asdasd', '04:44:00', '2024-10-24', NULL, '2024-10-14 08:45:01', '2024-10-14 16:44:00', '2024-10-14 17:44:00', 'Monday');

-- --------------------------------------------------------

--
-- Table structure for table `tblimages`
--

CREATE TABLE `tblimages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblofficial`
--

CREATE TABLE `tblofficial` (
  `id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `verify_token` varchar(255) NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `city_municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `proof_house` varchar(255) NOT NULL,
  `otp_verified` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay_applications`
--
ALTER TABLE `barangay_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay_permits`
--
ALTER TABLE `barangay_permits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblblotter`
--
ALTER TABLE `tblblotter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblimages`
--
ALTER TABLE `tblimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblofficial`
--
ALTER TABLE `tblofficial`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=433;

--
-- AUTO_INCREMENT for table `barangay_applications`
--
ALTER TABLE `barangay_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `barangay_permits`
--
ALTER TABLE `barangay_permits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `tblblotter`
--
ALTER TABLE `tblblotter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `tblimages`
--
ALTER TABLE `tblimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblofficial`
--
ALTER TABLE `tblofficial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblimages`
--
ALTER TABLE `tblimages`
  ADD CONSTRAINT `tblimages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tblaccounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
