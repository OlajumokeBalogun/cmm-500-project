-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2023 at 02:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kikedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `Appointment_id` int(20) NOT NULL,
  `Patient_Id` int(20) NOT NULL,
  `Patient_name` varchar(200) NOT NULL,
  `status` varchar(40) NOT NULL,
  `doctor_name` varchar(200) NOT NULL,
  `Appointment_date` date NOT NULL,
  `Appointment_time` time NOT NULL,
  `staff_scheduling` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`Appointment_id`, `Patient_Id`, `Patient_name`, `status`, `doctor_name`, `Appointment_date`, `Appointment_time`, `staff_scheduling`) VALUES
(1, 6, 'olajumoke balogun', 'Pending', 'gbenga adesina', '2023-08-08', '03:28:00', 'gbenga adesina'),
(2, 6, 'olajumoke balogun', 'Done', 'gbenga adesina', '0000-00-00', '03:02:00', 'gbenga adesina');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `Billing_id` int(20) NOT NULL,
  `Patient_name` text NOT NULL,
  `Amount` varchar(11) NOT NULL,
  `Payment_mode` text DEFAULT NULL,
  `Payment_status` varchar(20) NOT NULL,
  `Billing_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`Billing_id`, `Patient_name`, `Amount`, `Payment_mode`, `Payment_status`, `Billing_date`) VALUES
(2, 'Kingsley Balogun', '£505', 'card/contactless', 'Paid', '2023-08-05 01:27:08'),
(3, 'olajumoke balogun', '£400', 'card/contactless', 'Paid', '2023-08-05 01:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `drug`
--

CREATE TABLE `drug` (
  `Drug_id` int(20) NOT NULL,
  `Drug_name` text DEFAULT NULL,
  `Drug_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drug`
--

INSERT INTO `drug` (`Drug_id`, `Drug_name`, `Drug_desc`) VALUES
(6, 'gdjgd', 'jgd'),
(7, 'gf', 'jkzkf');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `Patient_Id` int(20) NOT NULL,
  `Firstname` varchar(40) DEFAULT NULL,
  `Middlename` varchar(40) DEFAULT NULL,
  `Lastname` varchar(40) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `bloodgroup` varchar(10) DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `Date_joined` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`Patient_Id`, `Firstname`, `Middlename`, `Lastname`, `dob`, `age`, `email`, `bloodgroup`, `weight`, `height`, `address`, `gender`, `Date_joined`) VALUES
(6, 'olajumoke', 'olamide', 'balogun', '2023-08-01', 29, 'olajumokebalogun22@gmail.com', 'O+', '77kg', '5.3ft', 'aberdeen', 'Male', '2023-08-01 09:34:14');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `Prescription_id` int(20) NOT NULL,
  `Patient_name` varchar(255) NOT NULL,
  `Staff_name` varchar(255) NOT NULL,
  `Drug_name` varchar(255) NOT NULL,
  `prescription_status` varchar(50) NOT NULL,
  `Doctor_note` text DEFAULT NULL,
  `Prescription_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`Prescription_id`, `Patient_name`, `Staff_name`, `Drug_name`, `prescription_status`, `Doctor_note`, `Prescription_date`) VALUES
(1, '', '', '', 'Collected', '', '2023-08-01 11:11:30'),
(2, 'Kingsley Balogun', '1', 'kikelomo drugs', 'Awaiting Collection', 'fsfstgtsgfgfs', '2023-08-01 11:47:05'),
(3, 'olajumoke balogun', 'gbenga adesina', 'kikelomo drugs', 'Awaiting Collection', 'dj', '2023-08-02 09:24:39'),
(4, 'olajumoke balogun', 'aminat Balogun', 'gdjgd', 'Collected', '&lt;p&gt;io[g[&lt;/p&gt;cz', '2023-08-05 03:00:07'),
(6, 'olajumoke balogun', 'aminat Balogun', 'gdjgd', 'Collected', '&lt;p&gt;saf&lt;/p&gt;', '2023-08-05 03:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `Test_id` int(20) NOT NULL,
  `Patient_name` text NOT NULL,
  `Staff_name` text NOT NULL,
  `Test_name` text DEFAULT NULL,
  `Test_results` text DEFAULT NULL,
  `Test_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`Test_id`, `Patient_name`, `Staff_name`, `Test_name`, `Test_results`, `Test_date`) VALUES
(4, 'olajumoke balogun', 'aminat Balogun', 'malaria', '&lt;p&gt;asfGG&lt;/p&gt;', '2023-08-05 02:25:06'),
(5, 'olajumoke balogun', '1', 'malaria', '&lt;p&gt;dsd&lt;/p&gt;', '2023-08-07 22:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `password_change` int(40) NOT NULL,
  `otp_expiration` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `email`, `password`, `type`, `otp`, `password_change`, `otp_expiration`, `date_created`) VALUES
(1, 'gbenga', 'abimbola', 'adesina', 'olajumokebalogun22@gmail.com', '$2y$10$ipPO/lDYC.tkUUZfdAVhLewUIAFjVuzquetlmxCh8KfMW77krlUI6', 'doctor', NULL, 0, NULL, '2023-07-31 17:28:57'),
(2, 'admin', 'admin', 'admin', 'adesina.abimbola@yahoo.com', '$2y$10$r1cCDKqCTl6eGz77CUT4dOtKK7rvw66JCH5k8dcPpl5JWHvZAjL3u', 'admin', NULL, 0, NULL, '2023-08-02 20:54:23'),
(14, 'aminat', 'olamide', 'Balogun', 'harnidex86@gmail.com', '$2y$10$.coQlA7laHHcRAK/v9u4bur9CQGOXbWiRBT80Mc8RGX0QnRXYloEC', 'receptioni', NULL, 0, NULL, '2023-08-03 01:48:50'),
(19, 'admin', 'admin', 'admin', 'adesina.abimbola@yahoo.com', '$2y$10$N8Ur1JRKREsRiOy3G7/jKO6DHKdicFEquuaJBYQUf.iwoz3K93QUK', 'admin', NULL, 0, NULL, '2023-08-06 19:07:52'),
(32, 'olajumoke', 'abimbola', 'balogun', 'lajumokebalo@gmail.com', '$2y$10$UqQIFHXMFDpYiCuN75lO8uk1NixS8jXi08qBXsjNTkNgrVGM7HzSC', 'nurse', NULL, 0, NULL, '2023-08-07 21:09:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`Appointment_id`),
  ADD KEY `Patient_Id` (`Patient_Id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`Billing_id`);

--
-- Indexes for table `drug`
--
ALTER TABLE `drug`
  ADD PRIMARY KEY (`Drug_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`Patient_Id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`Prescription_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`Test_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `Appointment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `Billing_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `drug`
--
ALTER TABLE `drug`
  MODIFY `Drug_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `Patient_Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `Prescription_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `Test_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`Patient_Id`) REFERENCES `patient` (`Patient_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
