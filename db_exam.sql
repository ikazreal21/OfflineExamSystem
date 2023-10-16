-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2023 at 05:03 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `list_of_subject` varchar(2000) DEFAULT NULL,
  `yearlevel` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `role`, `email`, `first_name`, `last_name`, `student_id`, `status`, `list_of_subject`, `yearlevel`) VALUES
(1, 'admin', 'adminadmin', 'admin', '', '', '', '', 'active', '', '0'),
(3, 'student1', 'student123', 'student', 'test@gmail.com', 'test1', 'test1', '1111111', 'active', '', '1st'),
(4, 'faculty1', '123', 'faculty', 'faculty@gmail.com', 'Test Prof', 'Test', '', 'active', '', ''),
(5, 'faculty2', '123', 'faculty', 'faculty@gmail.com', 'Test Prof2', 'Test', '', 'active', '', ''),
(6, 'zaki', '2001210809', 'student', 'joaquinzaki21@gmail.com', 'Joaquin Zaki', 'Soriano', '1111111111', 'active', '', '4th'),
(7, 'joaquin', '12346', 'student', 'joaquinzaki211@gmail.com ', 'Joaquin Zaki', 'Soriano', '1313131314', 'active', '', '2nd'),
(8, 'joaquin', '12347', 'student', 'joaquinzaki212@gmail.com ', 'Joaquin Zaki', 'Soriano', '1313131315', 'active', '', '3rd'),
(9, 'joaquin', '12348', 'student', 'joaquinzaki213@gmail.com ', 'Joaquin Zaki', 'Soriano', '1313131316', 'active', '', '4th'),
(20, 'zaki', 'zaki', 'student', 'joaquinzaki21@gmail.comfffffaaaa', 'Joaquin', 'Soriano', '121212121', 'active', '', '3rd');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_student`
--

CREATE TABLE `enrolled_student` (
  `enrolled_id` int(50) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `section_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrolled_student`
--

INSERT INTO `enrolled_student` (`enrolled_id`, `student_id`, `subject_id`, `section_id`) VALUES
(46, '1111111', 'WJCLJYC0', '2'),
(47, '1111111111', 'WJCLJYC0', '2'),
(54, '1111111', 'WJCLJYC0', '8'),
(55, '1111111111', 'WJCLJYC0', '8'),
(60, '1313131314', 'WJCLJYC0', '2'),
(61, '1313131315', 'WJCLJYC0', '2'),
(62, '1313131316', 'WJCLJYC0', '2');

-- --------------------------------------------------------

--
-- Table structure for table `examcreated`
--

CREATE TABLE `examcreated` (
  `exam_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `section_id` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `grading_period` varchar(255) NOT NULL,
  `yearlevel` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `prof_name` varchar(255) NOT NULL,
  `prof_id` int(50) NOT NULL,
  `multiplechoice` int(50) NOT NULL,
  `identification` int(50) NOT NULL,
  `matching` int(255) NOT NULL,
  `trueorfalse` int(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `timer` varchar(255) NOT NULL,
  `matching_topic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `examcreated`
--

INSERT INTO `examcreated` (`exam_id`, `subject`, `section_name`, `section_id`, `subject_id`, `grading_period`, `yearlevel`, `semester`, `prof_name`, `prof_id`, `multiplechoice`, `identification`, `matching`, `trueorfalse`, `status`, `timer`, `matching_topic`) VALUES
(24, 'Test3', 'Dash 1', '2', 'WJCLJYC0', 'Prelim', '1st', '1st', 'Test Prof Test', 4, 1, 1, 1, 1, 'close', '15', ''),
(27, 'Test3', 'Dash 1', '2', 'WJCLJYC0', 'Prelim', '1st', '1st', 'Test Prof Test', 4, 1, 1, 1, 1, 'close', '15', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `exam_take`
--

CREATE TABLE `exam_take` (
  `examtake_id` int(11) NOT NULL,
  `exam_id` int(255) NOT NULL,
  `student_name` varchar(32) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `subject` varchar(32) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `section_id` varchar(255) NOT NULL,
  `grading_per` varchar(32) NOT NULL,
  `score` int(32) DEFAULT NULL,
  `out_of` int(255) NOT NULL,
  `yearl` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_take`
--

INSERT INTO `exam_take` (`examtake_id`, `exam_id`, `student_name`, `student_id`, `subject`, `subject_id`, `section_name`, `section_id`, `grading_per`, `score`, `out_of`, `yearl`) VALUES
(42, 23, 'Test1 Test1', '1111111', 'Test3', 'WJCLJYC0', 'Dash 1', '2', 'Prelim', 3, 5, '1st');

-- --------------------------------------------------------

--
-- Table structure for table `identification`
--

CREATE TABLE `identification` (
  `examiden_id` int(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `grading_period` varchar(200) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `prof_name` varchar(255) NOT NULL,
  `prof_id` int(50) NOT NULL,
  `difficulty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `identification`
--

INSERT INTO `identification` (`examiden_id`, `subject`, `subject_id`, `question`, `answer`, `yearlevel`, `grading_period`, `semester`, `prof_name`, `prof_id`, `difficulty`) VALUES
(115, 'Test3', 'WJCLJYC0', 'Test1', 'Test1', '1st', 'Prelim', '1st', 'Test Prof Test', 4, 'easy');

-- --------------------------------------------------------

--
-- Table structure for table `matchingtype`
--

CREATE TABLE `matchingtype` (
  `matchtype_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `grading_period` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `prof_name` varchar(255) NOT NULL,
  `prof_id` int(50) NOT NULL,
  `difficulty` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matchingtype`
--

INSERT INTO `matchingtype` (`matchtype_id`, `question`, `answer`, `subject`, `subject_id`, `yearlevel`, `grading_period`, `semester`, `prof_name`, `prof_id`, `difficulty`, `topic`) VALUES
(2, 'Test1', 'Test1', 'Test3', 'WJCLJYC0', '1st', 'Prelim', '1st', 'Test Prof Test', 4, 'easy', 'Test'),
(3, 'Test555', 'Test1', 'Test3', 'WJCLJYC0', '1st', 'Prelim', '1st', 'Test Prof Test', 4, 'easy', 'Test'),
(4, 'Test111', '1', 'Test3', 'WJCLJYC0', '1st', 'Prelim', '1st', 'Test Prof Test', 4, '', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `multiplechoice`
--

CREATE TABLE `multiplechoice` (
  `exammulti_id` int(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `A` varchar(255) NOT NULL,
  `B` varchar(255) NOT NULL,
  `C` varchar(255) NOT NULL,
  `D` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `grading_period` varchar(200) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `profname` varchar(200) NOT NULL,
  `prof_id` int(50) NOT NULL,
  `difficulty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `multiplechoice`
--

INSERT INTO `multiplechoice` (`exammulti_id`, `subject`, `subject_id`, `question`, `A`, `B`, `C`, `D`, `E`, `answer`, `yearlevel`, `grading_period`, `semester`, `profname`, `prof_id`, `difficulty`) VALUES
(84, 'TEST1', '0AIUEYAZ', 'TEST40', 'MC8', 'MC9', 'MC10', 'MC11', 'MC12', 'A', '1st', 'Prelim', '1st', 'Test', 5, 'medium'),
(85, 'TEST1', '0AIUEYAZ', 'TEST41', 'MC9', 'MC10', 'MC11', 'MC12', 'MC13', 'A', '1st', 'Prelim', '1st', 'Test', 5, ''),
(86, 'TEST1', '0AIUEYAZ', 'TEST42', 'MC10', 'MC11', 'MC12', 'MC13', 'MC14', 'A', '1st', 'Prelim', '1st', 'Test', 5, ''),
(87, 'Test', '0AIUEYAZ', 'Test', '1', '1', '1', '1', '1', '1', '1st', 'Prelim', '1st', 'Test Prof Test', 4, 'easy'),
(89, 'Test3', 'WJCLJYC0', 'Test', '1', '6', '9', '4', '2', '1', '1st', 'Prelim', '1st', 'Test Prof Test', 4, 'easy');

-- --------------------------------------------------------

--
-- Table structure for table `prof_subjects`
--

CREATE TABLE `prof_subjects` (
  `prof_subject_id` int(50) NOT NULL,
  `prof_id` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prof_subjects`
--

INSERT INTO `prof_subjects` (`prof_subject_id`, `prof_id`, `subject_id`, `role`) VALUES
(44, '4', '0AIUEYAZ', ''),
(45, '5', '0AIUEYAZ', 'main'),
(50, '4', 'WJCLJYC0', 'main'),
(51, '5', 'WJCLJYC0', ''),
(54, '5', 'B0EZ0VSP', '');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(255) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `prof_name` varchar(255) NOT NULL,
  `prof_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`, `subject_id`, `prof_name`, `prof_id`) VALUES
(2, 'Dash 1', 'WJCLJYC0', 'Test Prof Test', '4'),
(7, 'Dash 1', 'B0EZ0VSP', 'Test Prof2 Test', '5'),
(8, 'Dash 2', 'WJCLJYC0', 'Test Prof2 Test', '5'),
(9, 'Dash 1', '0AIUEYAZ', 'Test Prof Test', '4');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(255) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `num_of_student` varchar(255) NOT NULL,
  `rnd_id` varchar(255) NOT NULL,
  `list_of_student` varchar(2000) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `yearlevel` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `num_of_student`, `rnd_id`, `list_of_student`, `semester`, `yearlevel`) VALUES
(8, 'Test', '', '0AIUEYAZ', '', '1st', '1st'),
(10, 'Test3', '', 'WJCLJYC0', '', '1st', '1st'),
(11, 'IPTC411', '', 'B0EZ0VSP', '', '1st', '4th');

-- --------------------------------------------------------

--
-- Table structure for table `trueorfalse`
--

CREATE TABLE `trueorfalse` (
  `trueorfalse` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `grading_period` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `prof_name` varchar(255) NOT NULL,
  `prof_id` int(50) NOT NULL,
  `difficulty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trueorfalse`
--

INSERT INTO `trueorfalse` (`trueorfalse`, `question`, `answer`, `subject`, `subject_id`, `yearlevel`, `grading_period`, `semester`, `prof_name`, `prof_id`, `difficulty`) VALUES
(6, 'Test222', 'True', 'Test3', 'WJCLJYC0', '1st', 'Prelim', '1st', 'Test Prof Test', 4, 'easy'),
(7, 'Test', 'True', 'Test3', 'WJCLJYC0', '1st', 'Prelim', '1st', 'Test Prof Test', 4, 'easy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrolled_student`
--
ALTER TABLE `enrolled_student`
  ADD PRIMARY KEY (`enrolled_id`);

--
-- Indexes for table `examcreated`
--
ALTER TABLE `examcreated`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `exam_take`
--
ALTER TABLE `exam_take`
  ADD PRIMARY KEY (`examtake_id`),
  ADD UNIQUE KEY `student_name` (`student_id`,`subject_id`,`grading_per`) USING BTREE;

--
-- Indexes for table `identification`
--
ALTER TABLE `identification`
  ADD PRIMARY KEY (`examiden_id`),
  ADD UNIQUE KEY `question` (`question`,`subject_id`) USING BTREE;

--
-- Indexes for table `matchingtype`
--
ALTER TABLE `matchingtype`
  ADD PRIMARY KEY (`matchtype_id`),
  ADD UNIQUE KEY `question` (`question`,`subject_id`) USING BTREE;

--
-- Indexes for table `multiplechoice`
--
ALTER TABLE `multiplechoice`
  ADD PRIMARY KEY (`exammulti_id`),
  ADD UNIQUE KEY `qs` (`question`,`subject_id`) USING BTREE;

--
-- Indexes for table `prof_subjects`
--
ALTER TABLE `prof_subjects`
  ADD PRIMARY KEY (`prof_subject_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `trueorfalse`
--
ALTER TABLE `trueorfalse`
  ADD PRIMARY KEY (`trueorfalse`),
  ADD UNIQUE KEY `question` (`question`,`subject_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `enrolled_student`
--
ALTER TABLE `enrolled_student`
  MODIFY `enrolled_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `examcreated`
--
ALTER TABLE `examcreated`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `exam_take`
--
ALTER TABLE `exam_take`
  MODIFY `examtake_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `identification`
--
ALTER TABLE `identification`
  MODIFY `examiden_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `matchingtype`
--
ALTER TABLE `matchingtype`
  MODIFY `matchtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `multiplechoice`
--
ALTER TABLE `multiplechoice`
  MODIFY `exammulti_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `prof_subjects`
--
ALTER TABLE `prof_subjects`
  MODIFY `prof_subject_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `trueorfalse`
--
ALTER TABLE `trueorfalse`
  MODIFY `trueorfalse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
