-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2024 at 02:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_test_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_credentials`
--

INSERT INTO `admin_credentials` (`id`, `username`, `password`) VALUES
(1, 'gpmtestadmin', '4ef71a6f7b71fae542f6779824bb9338');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`) VALUES
(93, 24, 'Mumbai'),
(94, 24, 'Banglore'),
(95, 24, 'Delhi'),
(96, 24, 'Hyderabad'),
(97, 25, 'Narendra Modi'),
(98, 25, 'Modi ji'),
(99, 25, 'Narendra Modi Ji'),
(100, 25, 'All of above'),
(101, 26, 'Delhi'),
(102, 26, 'Pune'),
(103, 26, 'Nagpur'),
(104, 26, 'Mumbai'),
(105, 27, 'Pune '),
(106, 27, 'Manipur'),
(107, 27, 'Rajasthan'),
(108, 27, 'kerala'),
(109, 28, 'Eknath Shinde '),
(110, 28, 'Devendra Fadanvis'),
(111, 28, 'Raj Thakre'),
(112, 28, 'None'),
(113, 29, 'Atharva Mane'),
(114, 29, 'ABC'),
(115, 29, 'XYZ'),
(116, 29, 'MNO'),
(117, 30, 'Subrahmanyam Jaishankar'),
(118, 30, 'ABC'),
(119, 30, 'XYZ'),
(120, 30, 'MNO'),
(121, 31, 'I dont know!'),
(122, 31, 'I dont have a name'),
(123, 31, 'Both'),
(124, 31, 'None'),
(125, 32, 'Mumbai'),
(126, 32, 'Banglore'),
(127, 32, 'Modiji'),
(128, 32, 'Hyderabad'),
(129, 33, 'Delhi'),
(130, 33, 'Banglore'),
(131, 33, 'Modiji'),
(132, 33, 'Hyderabad');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `question_text` text NOT NULL,
  `correct_option` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `question_text`, `correct_option`) VALUES
(24, 32, 'Capital of India', 'c'),
(25, 32, 'Prime Minister of India is', 'd'),
(26, 32, 'Capital of Maharshtra', 'd'),
(27, 32, 'Which of the Following is Deserted region', 'c'),
(28, 32, 'Who is Chief Minister of Maharashtra', 'a'),
(29, 33, 'Founder of Atharvalisation', 'a'),
(30, 33, 'Foreign Minister if Indian is', 'a'),
(31, 37, 'What is your name?', 'a'),
(32, 38, 'Prime Minister of India', 'c'),
(33, 39, 'Capital of India', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `student_responses`
--

CREATE TABLE `student_responses` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `element_number` varchar(50) NOT NULL,
  `roll_number` varchar(50) NOT NULL,
  `answer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_responses`
--

INSERT INTO `student_responses` (`id`, `test_id`, `question_id`, `student_name`, `element_number`, `roll_number`, `answer`) VALUES
(21, 32, 24, 'Atharva Vinayak Mane', '2101310150', '21339', 93),
(22, 32, 25, 'Atharva Vinayak Mane', '2101310150', '21339', 100),
(23, 32, 26, 'Atharva Vinayak Mane', '2101310150', '21339', 104),
(24, 32, 27, 'Atharva Vinayak Mane', '2101310150', '21339', 107),
(25, 32, 28, 'Atharva Vinayak Mane', '2101310150', '21339', 109),
(26, 37, 31, 'Atharva Vinayak Mane', '2101310150', '21339', 121),
(27, 38, 32, 'Atharva Vinayak Mane', '2101310150', '21339', 127),
(28, 39, 33, 'Atharva Vinayak Mane', '2101310150', '21339', 129);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `test_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `test_code`) VALUES
(32, '111'),
(33, '222'),
(37, '333'),
(38, '444'),
(39, '555');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `student_responses`
--
ALTER TABLE `student_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_code` (`test_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `student_responses`
--
ALTER TABLE `student_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`);

--
-- Constraints for table `student_responses`
--
ALTER TABLE `student_responses`
  ADD CONSTRAINT `student_responses_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  ADD CONSTRAINT `student_responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
