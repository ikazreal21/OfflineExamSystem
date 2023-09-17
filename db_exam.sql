-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2023 at 10:20 PM
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
  `student_id` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `list_of_subject` varchar(2000) NOT NULL,
  `yearlevel` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `role`, `email`, `first_name`, `last_name`, `student_id`, `status`, `list_of_subject`, `yearlevel`) VALUES
(1, 'admin', 'adminadmin', 'admin', '', '', '', '', '', '', '0'),
(3, 'student1', 'student123', 'student', 'test@gmail.com', 'test1', 'test1', '1111111', 'active', '', '1st'),
(4, 'faculty1', '123', 'faculty', 'faculty@gmail.com', 'Test Prof', 'Test', '', 'active', '', ''),
(5, 'faculty2', '123', 'faculty', 'faculty@gmail.com', 'Test Prof2', 'Test', '', 'active', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_student`
--

CREATE TABLE `enrolled_student` (
  `enrolled_id` int(50) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrolled_student`
--

INSERT INTO `enrolled_student` (`enrolled_id`, `student_id`, `subject_id`) VALUES
(24, '1111111', '0AIUEYAZ'),
(26, '1111111', 'WJCLJYC0');

-- --------------------------------------------------------

--
-- Table structure for table `examcreated`
--

CREATE TABLE `examcreated` (
  `exam_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
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
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `examcreated`
--

INSERT INTO `examcreated` (`exam_id`, `subject`, `subject_id`, `grading_period`, `yearlevel`, `semester`, `prof_name`, `prof_id`, `multiplechoice`, `identification`, `matching`, `trueorfalse`, `status`) VALUES
(1, 'TEST111', '', 'Midterm', '2nd', '2nd', 'TEST PROF', 0, 60, 60, 0, 0, 'close'),
(2, 'PPCG11', '', 'Midterm', '2nd', '2nd', 'Test prof1', 0, 60, 50, 0, 0, 'close'),
(3, 'TEST 123', '', 'Prelim', '1st', '1st', 'Zaki', 0, 3, 3, 0, 0, 'close'),
(4, 'TEST1', '', 'Prelim', '1st', '1st', 'TEST PROF', 0, 5, 5, 0, 0, 'close'),
(5, 'TEST1', '', 'Midterm', '2nd', '2nd', 'TEST PROF', 0, 3, 3, 0, 0, 'close'),
(6, 'TEST1', '', 'Midterm', '2nd', '2nd', 'TEST PROF', 0, 5, 5, 0, 0, 'close'),
(7, 'TEST1', '', 'Special', '4th', '2nd', 'TEST PROF', 0, 5, 5, 0, 0, 'close'),
(8, 'Test', '8', 'Prelim', '1st', '1st', 'Test Prof2 Test', 5, 10, 10, 10, 10, 'close'),
(9, 'Test', '0AIUEYAZ', 'Prelim', '1st', '1st', 'Test Prof2 Test', 5, 5, 5, 5, 5, 'close'),
(10, 'Test', '0AIUEYAZ', 'Finals', '1st', '1st', 'Test Prof2 Test', 5, 1, 1, 1, 1, 'close'),
(11, 'Test', '0AIUEYAZ', 'Prelim', '1st', '1st', 'Test Prof Test', 4, 1, 1, 1, 1, 'close'),
(12, 'Test', '0AIUEYAZ', 'Prelim', '1st', '1st', 'Test Prof Test', 4, 1, 1, 1, 1, 'close'),
(13, 'Test3', 'WJCLJYC0', 'Midterm', '1st', '1st', 'Test Prof Test', 4, 2, 2, 2, 2, 'close'),
(14, 'Test2', 'SLM98HPR', 'Finals', '4th', '1st', 'Test Prof Test', 4, 4, 3, 5, 6, 'close'),
(15, 'Test', '0AIUEYAZ', 'Prelim', '1st', '1st', 'Test Prof Test', 4, 2, 2, 2, 2, 'close'),
(16, 'Test', '0AIUEYAZ', 'Prelim', '1st', '1st', 'Test Prof Test', 4, 1, 1, 1, 1, 'open');

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
  `grading_per` varchar(32) NOT NULL,
  `score` int(32) DEFAULT NULL,
  `out_of` int(255) NOT NULL,
  `yearl` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_take`
--

INSERT INTO `exam_take` (`examtake_id`, `exam_id`, `student_name`, `student_id`, `subject`, `subject_id`, `grading_per`, `score`, `out_of`, `yearl`) VALUES
(31, 16, 'Test1 Test1', '1111111', 'Test', '0AIUEYAZ', 'Prelim', 4, 4, '1st');

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
  `prof_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `identification`
--

INSERT INTO `identification` (`examiden_id`, `subject`, `subject_id`, `question`, `answer`, `yearlevel`, `grading_period`, `semester`, `prof_name`, `prof_id`) VALUES
(113, 'Test', '0AIUEYAZ', 'Test', 'Test1', '1st', 'Prelim', '1st', 'Test Prof Test', 4);

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
  `prof_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matchingtype`
--

INSERT INTO `matchingtype` (`matchtype_id`, `question`, `answer`, `subject`, `subject_id`, `yearlevel`, `grading_period`, `semester`, `prof_name`, `prof_id`) VALUES
(1, 'Test', 'Test1', 'Test', '0AIUEYAZ', '1st', 'Prelim', '1st', 'Test Prof Test', 4);

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
  `prof_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `multiplechoice`
--

INSERT INTO `multiplechoice` (`exammulti_id`, `subject`, `subject_id`, `question`, `A`, `B`, `C`, `D`, `E`, `answer`, `yearlevel`, `grading_period`, `semester`, `profname`, `prof_id`) VALUES
(45, 'Test', '0AIUEYAZ', 'Test', 'a', 'b', 'c', 'd', 'e', 'a', '1st', 'Prelim', '1st', 'Test Prof Test', 4),
(66, 'TEST1', '0AIUEYAZ', 'TEST23', 'MC1', 'MC2', 'MC3', 'MC4', 'MC5', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(67, 'TEST1', '0AIUEYAZ', 'TEST24', 'MC2', 'MC3', 'MC4', 'MC5', 'MC6', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(68, 'TEST1', '0AIUEYAZ', 'TEST25', 'MC3', 'MC4', 'MC5', 'MC6', 'MC7', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(69, 'TEST1', '0AIUEYAZ', 'TEST26', 'MC4', 'MC5', 'MC6', 'MC7', 'MC8', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(70, 'TEST1', '0AIUEYAZ', 'TEST27', 'MC5', 'MC6', 'MC7', 'MC8', 'MC9', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(71, 'TEST1', '0AIUEYAZ', 'TEST28', 'MC6', 'MC7', 'MC8', 'MC9', 'MC10', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(72, 'TEST1', '0AIUEYAZ', 'TEST29', 'MC7', 'MC8', 'MC9', 'MC10', 'MC11', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(73, 'TEST1', '0AIUEYAZ', 'TEST30', 'MC8', 'MC9', 'MC10', 'MC11', 'MC12', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(74, 'TEST1', '0AIUEYAZ', 'TEST31', 'MC9', 'MC10', 'MC11', 'MC12', 'MC13', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(75, 'TEST1', '0AIUEYAZ', 'TEST32', 'MC10', 'MC11', 'MC12', 'MC13', 'MC14', 'A', '1st', 'Prelim', '1st', 'Test', 4),
(76, 'Test2', 'SLM98HPR', 'Test for Prof 2', '1', '2', '3', '4', '5', 'A', '4th', 'Prelim', '1st', 'Test Prof2 Test', 5),
(77, 'TEST1', '0AIUEYAZ', 'TEST33', 'MC1', 'MC2', 'MC3', 'MC4', 'MC5', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(78, 'TEST1', '0AIUEYAZ', 'TEST34', 'MC2', 'MC3', 'MC4', 'MC5', 'MC6', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(79, 'TEST1', '0AIUEYAZ', 'TEST35', 'MC3', 'MC4', 'MC5', 'MC6', 'MC7', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(80, 'TEST1', '0AIUEYAZ', 'TEST36', 'MC4', 'MC5', 'MC6', 'MC7', 'MC8', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(81, 'TEST1', '0AIUEYAZ', 'TEST37', 'MC5', 'MC6', 'MC7', 'MC8', 'MC9', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(82, 'TEST1', '0AIUEYAZ', 'TEST38', 'MC6', 'MC7', 'MC8', 'MC9', 'MC10', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(83, 'TEST1', '0AIUEYAZ', 'TEST39', 'MC7', 'MC8', 'MC9', 'MC10', 'MC11', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(84, 'TEST1', '0AIUEYAZ', 'TEST40', 'MC8', 'MC9', 'MC10', 'MC11', 'MC12', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(85, 'TEST1', '0AIUEYAZ', 'TEST41', 'MC9', 'MC10', 'MC11', 'MC12', 'MC13', 'A', '1st', 'Prelim', '1st', 'Test', 5),
(86, 'TEST1', '0AIUEYAZ', 'TEST42', 'MC10', 'MC11', 'MC12', 'MC13', 'MC14', 'A', '1st', 'Prelim', '1st', 'Test', 5);

-- --------------------------------------------------------

--
-- Table structure for table `prof_subjects`
--

CREATE TABLE `prof_subjects` (
  `prof_subject_id` int(50) NOT NULL,
  `prof_id` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prof_subjects`
--

INSERT INTO `prof_subjects` (`prof_subject_id`, `prof_id`, `subject_id`) VALUES
(44, '4', '0AIUEYAZ'),
(45, '5', '0AIUEYAZ'),
(47, '5', 'SLM98HPR'),
(50, '4', 'WJCLJYC0'),
(51, '5', 'WJCLJYC0');

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
(9, 'Test2', '', 'SLM98HPR', '', '1st', '4th'),
(10, 'Test3', '', 'WJCLJYC0', '', '1st', '1st');

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
  `prof_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trueorfalse`
--

INSERT INTO `trueorfalse` (`trueorfalse`, `question`, `answer`, `subject`, `subject_id`, `yearlevel`, `grading_period`, `semester`, `prof_name`, `prof_id`) VALUES
(5, 'Test', 'True', 'Test', '0AIUEYAZ', '1st', 'Prelim', '1st', 'Test Prof Test', 4);

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
  ADD UNIQUE KEY `question` (`question`);

--
-- Indexes for table `matchingtype`
--
ALTER TABLE `matchingtype`
  ADD PRIMARY KEY (`matchtype_id`),
  ADD UNIQUE KEY `question` (`question`);

--
-- Indexes for table `multiplechoice`
--
ALTER TABLE `multiplechoice`
  ADD PRIMARY KEY (`exammulti_id`),
  ADD UNIQUE KEY `qs` (`question`);

--
-- Indexes for table `prof_subjects`
--
ALTER TABLE `prof_subjects`
  ADD PRIMARY KEY (`prof_subject_id`);

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
  ADD UNIQUE KEY `question` (`question`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrolled_student`
--
ALTER TABLE `enrolled_student`
  MODIFY `enrolled_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `examcreated`
--
ALTER TABLE `examcreated`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `exam_take`
--
ALTER TABLE `exam_take`
  MODIFY `examtake_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `identification`
--
ALTER TABLE `identification`
  MODIFY `examiden_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `matchingtype`
--
ALTER TABLE `matchingtype`
  MODIFY `matchtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `multiplechoice`
--
ALTER TABLE `multiplechoice`
  MODIFY `exammulti_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `prof_subjects`
--
ALTER TABLE `prof_subjects`
  MODIFY `prof_subject_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trueorfalse`
--
ALTER TABLE `trueorfalse`
  MODIFY `trueorfalse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
