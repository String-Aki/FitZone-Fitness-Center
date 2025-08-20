-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2025 at 07:02 PM
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
-- Database: `fitzone_7306`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `Appointment_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Trainer_ID` int(11) NOT NULL,
  `Session_Type` enum('Strength Training','Cardio','Yoga','Pilates','HIIT','Spin','Personal Training') NOT NULL,
  `Session_Date` date NOT NULL,
  `Session_Time` time NOT NULL,
  `Status` enum('pending','confirmed','completed','cancelled') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`Appointment_ID`, `User_ID`, `Trainer_ID`, `Session_Type`, `Session_Date`, `Session_Time`, `Status`, `created_at`) VALUES
(59, 20, 2, 'Spin', '2025-08-02', '23:57:00', 'confirmed', '2025-08-02 20:23:27'),
(60, 20, 1, 'Spin', '2025-08-03', '05:40:00', 'cancelled', '2025-08-03 14:10:25'),
(61, 29, 22, 'Cardio', '2025-08-04', '09:42:00', 'cancelled', '2025-08-03 14:12:08'),
(62, 20, 6, 'Cardio', '2025-08-13', '23:39:00', 'pending', '2025-08-13 20:09:39'),
(63, 20, 9, 'Strength Training', '2025-08-14', '00:00:00', 'cancelled', '2025-08-14 15:54:10'),
(65, 53, 9, 'Pilates', '2025-08-16', '16:32:00', 'cancelled', '2025-08-16 13:02:16'),
(66, 53, 1, 'Spin', '2025-08-16', '19:32:00', 'confirmed', '2025-08-16 13:02:28'),
(68, 53, 22, 'HIIT', '2025-08-18', '13:09:00', 'completed', '2025-08-17 21:39:49'),
(80, 20, 22, 'Strength Training', '2025-08-20', '16:55:01', 'cancelled', '2025-08-18 16:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `broadcasts`
--

CREATE TABLE `broadcasts` (
  `Broadcast_ID` int(10) NOT NULL,
  `Admin_ID` int(11) NOT NULL,
  `Topic` varchar(255) NOT NULL,
  `Announcement` varchar(255) NOT NULL,
  `Created_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `Guest_ID` int(11) NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone_Number` int(15) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `Status` enum('pending','responded','closed') NOT NULL,
  `response` text NOT NULL,
  `responded_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `File_ID` int(6) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `File_Name` varchar(500) NOT NULL,
  `File_Path` varchar(500) NOT NULL,
  `File_Type` enum('File','Profile','','') NOT NULL,
  `Uploaded_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `Membership_ID` int(5) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Plan_Type` enum('Basic','Pro','Elite') NOT NULL,
  `Status` enum('Approved','Not Approved') NOT NULL,
  `Requested_Date` date DEFAULT NULL,
  `Approved_Date` date DEFAULT NULL,
  `Expiry_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`Membership_ID`, `User_ID`, `Plan_Type`, `Status`, `Requested_Date`, `Approved_Date`, `Expiry_Date`) VALUES
(16, 20, 'Basic', 'Approved', '2025-08-17', '2025-08-18', '2025-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `Message_ID` int(6) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Recipient_ID` int(11) NOT NULL,
  `Topic` enum('Membership Inquiry','Class Schedule','Personal Training','Facility Access','Billing and Payments','Other') NOT NULL,
  `Message` varchar(500) NOT NULL,
  `Upload_Name` varchar(500) DEFAULT NULL,
  `Upload_Path` varchar(500) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Response` varchar(500) NOT NULL,
  `Responded_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Status` enum('pending','responded') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`Message_ID`, `User_ID`, `Recipient_ID`, `Topic`, `Message`, `Upload_Name`, `Upload_Path`, `Created_At`, `Response`, `Responded_At`, `Status`) VALUES
(3, 20, 2, 'Membership Inquiry', 'I\'m interested in joining your gym and would like to know more about your membership options. Could you provide details on pricing, contract terms, and any special offers for new members?', 'Book a Class.png', 'Uploads/Book a Class.png', '2025-07-19 17:50:48', 'Thank you for your interest in our gym! We offer several membership plans, including monthly, quarterly, and annual options, starting at $30/month with no long-term contract required. New members can enjoy a 10% discount on their first three months or a free guest pass for a friend. Please visit our front desk or check our website at fitzone.com for a full breakdown of plans and to sign up!', '2025-07-18 22:03:12', 'responded'),
(4, 20, 1, 'Personal Training', 'I\'m looking to work with a personal trainer to help me achieve my fitness goals, specifically strength training and weight loss. Can you share details about your trainers\' qualifications and session pricing?', '', '', '2025-07-19 03:13:06', 'Ok', '2025-08-17 22:40:33', 'responded'),
(34, 20, 1, 'Personal Training', 'HI', '', '', '2025-08-02 14:55:13', 'Hey', '2025-08-17 22:40:39', 'responded'),
(35, 20, 9, 'Personal Training', 'Hello When can we have our PERSONAL TRAINING 😏', '', '', '2025-08-14 10:21:42', 'How about NOW', '2025-08-14 13:52:47', 'responded'),
(42, 53, 22, 'Billing and Payments', 'Testing', '', '', '2025-08-16 07:29:25', 'Working 1', '2025-08-18 14:48:57', 'responded'),
(43, 53, 22, 'Facility Access', 'Testing 2', '81YqH88N8vL._AC_UF1000,1000_QL80.png', '../../../includes/Uploads/files/81YqH88N8vL._AC_UF1000,1000_QL80.png', '2025-08-16 07:29:46', 'Working 2', '2025-08-18 14:48:52', 'responded'),
(49, 20, 22, 'Billing and Payments', 'Testing Staff Dashboard 5', '', '', '2025-08-17 22:32:48', 'test', '2025-08-18 15:13:55', 'responded'),
(50, 20, 22, 'Other', 'Testing File Download', 'dev-atrophy-certificate-80percent.png', '../../../includes/Uploads/files/dev-atrophy-certificate-80percent.png', '2025-08-18 15:47:46', '', '2025-08-18 15:47:46', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `Trainer_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Speciality` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`Trainer_ID`, `User_ID`, `Name`, `Speciality`) VALUES
(1, 21, 'Emily Carter', 'Yoga and Mindfulness'),
(2, 22, 'Mark Thompson', 'High-Intensity Interval Training'),
(6, 35, 'Alex Carter', 'Strength & Conditioning'),
(7, 36, 'Maya Rodriguez', 'Yoga & Flexibility Training'),
(8, 37, 'Olivia Bennett', 'Pilates & Core Strength'),
(9, 38, 'Lovey Vishwakarma', 'Being Cute'),
(20, 55, 'Daniel Fischer', 'Strength Training & Nutrition Coaching'),
(21, 56, 'Test Account', 'None'),
(22, 57, 'Shay Mcgee', 'Nothing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) DEFAULT NULL,
  `Phone` int(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role` enum('customer','staff','admin') NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Profile_Img_Path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `First_Name`, `Last_Name`, `Phone`, `Email`, `Role`, `Password`, `Profile_Img_Path`) VALUES
(6, 'Akira', 'Ackerman', 752020626, 'xapah62063@coderdir.com', 'customer', '$2y$10$7umLyb908nFrvRqFfa8FFu0tcJp7hLbeIYP76VCIG9wqRIotQ0IMu', NULL),
(20, 'Akira', 'Ackerman', 721170144, 'Aki@gmail.com', 'customer', '$2y$10$6hddLFfBihGDwB4aFTFZuu5EdWLlok76UHmOOkNbAVZfpiXAM3.5i', NULL),
(21, 'Emily', 'Carter', 123456789, 'emily.carter@fitzone.com', 'staff', '$2y$10$BJMkZiU95dOMwQrRxzd0DOLHWv23XOXDpUVrgBUljVkTLDmtr47Pq', '../../../includes/Uploads/pfp/download.jpeg'),
(22, 'Mark', 'Thompson', 123456789, 'mark.thompson@fitzone.com', 'staff', '$2y$10$vSO9EeiFR2rJc2K5PCkideklep/vpvJVJmZqMMavOuC7w4ZdfP7pO', NULL),
(23, 'Test1', 'Test', 123456789, 'TestAccount@gmail.com', 'customer', '$2y$10$RFdIWxx/UZnPjrXP4dazB.WAM2DTS3GHYJ0Ph9ugCH2DjIKyHWrvq', NULL),
(29, 'Lovey', '.', 2147483647, 'Loveyvishwakarma18@gmail.com', 'customer', '$2y$10$XJPuiqz34DsOr.sCqmL1Z.aeZa2OFlW5FRTe8g.K.xZUQf3STWsbm', '../../../includes/Uploads/pfp/Profile.jpeg'),
(30, 'Deepak', 'Akash', 752020626, 'shay.mcgee127@gmail.com', 'customer', '$2y$10$KErjxK/C59MDY9R.oqe60.hnFOxqtyZu1uHybDF9TrpHxjQ9Jk1ze', NULL),
(31, 'Shay', 'Mcgee', 123456789, 'Admin@fitzone.com', 'admin', '$2y$10$tcWOVoBaRcX9i5iCEgCLPe/ecUXgK7C3OgLwpNMRLR9htXSsZiFW6', NULL),
(35, 'Alex', 'Carter', 712345678, 'alex@fitzone.com', 'staff', '$2y$10$cqXKBxR1Oe/M.3dkSerC7.5XSxjO8SPZS3FShIovLSPydAOyCHBwi', '../../includes/Uploads/pfp/Profile.jpeg'),
(36, 'Maya', 'Rodriguez', 779876543, 'maya@fitzone.com', 'staff', '$2y$10$i6cI3RXciax19nWRNlTZ6.6bg3vUyio7XJofK9lcPl9qYWLPTytSC', NULL),
(37, 'Olivia', 'Bennett', 2147483647, 'test@fitzone.com', 'staff', '$2y$10$L2Nwcmj5zoBsE9Pqr8rAYuTqjs32S1Mbc/Fz3IRFrwdukJejP4KTy', NULL),
(38, 'Lovey', 'Vishwakarma', 2147483647, 'lovey@fitzone.com', 'staff', '$2y$10$TmOvOVMcq8P0qVSv2yM2eed7l2w1zsTFvHreHtMM8ckEvT01AUSJC', '../../../includes/Uploads/pfp/Profile.jpeg'),
(53, 'Deepak', 'Akash', 2147483647, 'Deepak@gmail.com', 'customer', '$2y$10$lhXCujPLfd6/rsXB0zO72uNgWsS6h/ag6zGBCqY5cEe8zcnZrT3Vi', '../../../includes/Uploads/pfp/1_2.jpeg'),
(54, 'Test', 'Test', 123456, 'nevifa7666@colimarl.com', 'customer', '$2y$10$8Nzpj9lPjtLZ/wBxq5GiXOI2qzGWUI2dGwd14Ddf61SQQdTBtTBlO', NULL),
(55, 'Daniel', 'Fischer', 2147483647, 'daniel@fitzone.com', 'staff', '$2y$10$wJX.wBxjrrTmKV5lZ.uTn.5DRpLqYCysfamGc2t.lwwBzE0kAoVyO', NULL),
(56, 'Test', 'Account', 12345, 'test@fitzone.com', 'staff', '$2y$10$91zZRPJdC.3ptYz9hNMOcutr43kfgjdoCELf9v9aOPRpaxeOVm2I.', NULL),
(57, 'Shay', 'Mcgee', 123456, 'shay@fitzone.com', 'staff', '$2y$10$BJMkZiU95dOMwQrRxzd0DOLHWv23XOXDpUVrgBUljVkTLDmtr47Pq', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`Appointment_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Trainer_ID` (`Trainer_ID`);

--
-- Indexes for table `broadcasts`
--
ALTER TABLE `broadcasts`
  ADD PRIMARY KEY (`Broadcast_ID`),
  ADD KEY `Admin_ID` (`Admin_ID`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`Guest_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`File_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`Membership_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Trainer_ID` (`Recipient_ID`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`Trainer_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `Appointment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `broadcasts`
--
ALTER TABLE `broadcasts`
  MODIFY `Broadcast_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `Guest_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `Membership_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `Message_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `Trainer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`Trainer_ID`) REFERENCES `trainers` (`Trainer_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `broadcasts`
--
ALTER TABLE `broadcasts`
  ADD CONSTRAINT `broadcasts_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `users` (`User_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD CONSTRAINT `contact_queries_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `trainers` (`Trainer_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`Recipient_ID`) REFERENCES `trainers` (`Trainer_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `trainers_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
