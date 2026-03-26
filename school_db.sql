-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 09:17 AM
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
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `building` varchar(50) DEFAULT NULL,
  `floor` int(11) DEFAULT 1,
  `room` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id`, `building`, `floor`, `room`) VALUES
(301, 'Science Hall', 2, '201'),
(302, 'Tech Building', 1, '105'),
(303, 'Main Hall', 3, '310');

-- --------------------------------------------------------

--
-- Table structure for table `classstanding`
--

CREATE TABLE `classstanding` (
  `id` int(11) NOT NULL,
  `class_name` varchar(20) NOT NULL,
  `max_credits` int(11) DEFAULT NULL,
  `min_credits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classstanding`
--

INSERT INTO `classstanding` (`id`, `class_name`, `max_credits`, `min_credits`) VALUES
(1, 'Freshman', 18, 12),
(2, 'Sophomore', 18, 12),
(3, 'Junior', 18, 12),
(4, 'Senior', 18, 12);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `crn` int(11) NOT NULL,
  `instructor` int(11) DEFAULT NULL,
  `classroom` int(11) DEFAULT NULL,
  `days` varchar(20) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`crn`, `instructor`, `classroom`, `days`, `time`) VALUES
(401, 201, 301, 'MWF', '10:00AM'),
(402, 202, 302, 'TTH', '1:00PM'),
(403, 203, 303, 'MWF', '3:00PM');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled`
--

CREATE TABLE `enrolled` (
  `student` int(11) NOT NULL,
  `course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolled`
--

INSERT INTO `enrolled` (`student`, `course`) VALUES
(101, 401),
(102, 401),
(103, 402),
(104, 403),
(105, 402),
(106, 401);

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `specialty` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`employee_id`, `first_name`, `last_name`, `specialty`) VALUES
(201, 'Drake', 'Mills', 'Computer Science'),
(202, 'Laura', 'Hill', 'Mathematics'),
(203, 'James', 'Carter', 'Biology');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `class_standing` int(11) DEFAULT NULL,
  `major` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `street`, `city`, `state`, `zip`, `class_standing`, `major`) VALUES
(101, 'John', 'Doe', '123 Main St', 'Greensboro', 'NC', '27401', 1, 'IT'),
(102, 'Jane', 'Smith', '456 Oak St', 'Durham', 'NC', '27701', 2, 'Math'),
(103, 'Mike', 'Brown', '789 Pine St', 'Raleigh', 'NC', '27601', 3, 'CS'),
(104, 'Sara', 'White', '111 Elm St', 'Greensboro', 'NC', '27405', 4, 'Biology'),
(105, 'Tom', 'Black', '222 Ash St', 'Charlotte', 'NC', '28202', 1, 'History'),
(106, 'Anna', 'Green', '333 Cedar St', 'Winston', 'NC', '27101', 2, 'Nursing'),
(107, 'Chris', 'Blue', '444 Maple St', 'Boone', 'NC', '28607', 3, 'Physics'),
(108, 'Emma', 'Gray', '555 Birch St', 'Asheville', 'NC', '28801', 4, 'Chemistry'),
(109, 'David', 'King', '666 Walnut St', 'High Point', 'NC', '27260', 2, 'IT'),
(110, 'Lily', 'Green', '777 Cherry St', 'Greensboro', 'NC', '27410', 1, 'Art');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `building` (`building`);

--
-- Indexes for table `classstanding`
--
ALTER TABLE `classstanding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`crn`),
  ADD KEY `instructor` (`instructor`),
  ADD KEY `classroom` (`classroom`);

--
-- Indexes for table `enrolled`
--
ALTER TABLE `enrolled`
  ADD PRIMARY KEY (`student`,`course`),
  ADD KEY `course` (`course`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_standing` (`class_standing`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`instructor`) REFERENCES `instructor` (`employee_id`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`classroom`) REFERENCES `classroom` (`id`);

--
-- Constraints for table `enrolled`
--
ALTER TABLE `enrolled`
  ADD CONSTRAINT `enrolled_ibfk_1` FOREIGN KEY (`student`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `enrolled_ibfk_2` FOREIGN KEY (`course`) REFERENCES `course` (`crn`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_standing`) REFERENCES `classstanding` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
