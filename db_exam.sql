-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2023 at 02:24 PM
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
  `yearlevel` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `role`, `email`, `first_name`, `last_name`, `student_id`, `status`, `list_of_subject`, `yearlevel`) VALUES
(1, 'admin', 'adminadmin', 'admin', '', '', '', '', 'active', '', '0'),
(258, 'fac1', '123', 'faculty', 'fac1@gmail.com', 'Fac', 'One', NULL, 'active', NULL, NULL),
(259, 'student1', '123', 'student', 'student1@gmail.com', 'Stud', 'One', '15645', 'active', NULL, '2nd');

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
(153, '15645', 'UEAU1KCA', '12');

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
(37, 'DSAA211', 'Y-3', '12', 'UEAU1KCA', 'Prelim', '2nd', '1st', 'Fac One', 258, 2, 2, 2, 2, 'open', '30', 'List');

-- --------------------------------------------------------

--
-- Table structure for table `exam_session`
--

CREATE TABLE `exam_session` (
  `session_id` varchar(255) NOT NULL,
  `time_remaining` int(11) NOT NULL,
  `multipleChoiceScore` int(11) DEFAULT NULL,
  `identificationScore` int(11) DEFAULT NULL,
  `matchingTypeScore` int(11) DEFAULT NULL,
  `trueOrFalseScore` int(11) DEFAULT NULL,
  `start_number_multiple` int(11) DEFAULT 0,
  `start_number_identification` int(11) DEFAULT 0,
  `start_number_matching` int(11) DEFAULT 0,
  `start_number_tor` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `yearl` varchar(32) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(126, 'DSAA211', 'UEAU1KCA', 'A term used to insert an element into the stack', 'Push', '2nd', 'Prelim', '1st', '-', 258, ''),
(127, 'DSAA211', 'UEAU1KCA', 'A term used to delete an element from the stack', 'Pop', '2nd', 'Prelim', '1st', '-', 258, ''),
(128, 'DSAA211', 'UEAU1KCA', 'Place where all insertion and deletion takes place', 'Top', '2nd', 'Prelim', '1st', '-', 258, ''),
(129, 'DSAA211', 'UEAU1KCA', 'Contains elements of same type arranged in sequential order. Operations takes place at both ends, insertion is done at end and deletion is done at front. ', 'Queue', '2nd', 'Prelim', '1st', '-', 258, ''),
(130, 'DSAA211', 'UEAU1KCA', 'contains elements of same type arranged in sequential order. All operations takes place at a single end that is top of the stack and following operations can be performed', 'Stack', '2nd', 'Prelim', '1st', '-', 258, '');

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
(13, 'Return an element from the list at any given position.', 'get()', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, '', 'List'),
(14, 'Insert an element at any position of the list.', 'insert()', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, '', 'List'),
(15, 'Remove the element at a specified location from a non-empty list.', 'removeAt()', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, '', 'List'),
(16, 'Return the number of elements in the list.', 'size()', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, '', 'List');

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
(99, 'DSAA211', 'UEAU1KCA', 'Adds an element to the top of the stack.', 'pop()', 'push()', 'peek()', 'part()', 'None of the above', 'B', '2nd', 'Prelim', '1st', '-', 258, ''),
(100, 'DSAA211', 'UEAU1KCA', 'Removes the topmost element from the stack.', 'pop()', 'push()', 'peek()', 'part()', 'None of the above', 'A', '2nd', 'Prelim', '1st', '-', 258, ''),
(101, 'DSAA211', 'UEAU1KCA', 'Return the element at the top of the stack without removing it.', 'pop()', 'push()', 'peek()', 'part()', 'None of the above', 'C', '2nd', 'Prelim', '1st', '-', 258, ''),
(102, 'DSAA211', 'UEAU1KCA', 'Return true if the list is full, otherwise return false.', 'isEmpty()', 'size()', 'isFull()', 'replace()', 'None of the above', 'C', '2nd', 'Prelim', '1st', '-', 258, '');

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
(57, '258', 'UEAU1KCA', 'main');

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
(12, 'Y-3', 'UEAU1KCA', 'Fac One', '258');

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
(14, 'DSAA211', '', 'UEAU1KCA', '', '1st', '2nd');

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
(18, 'Complex data structures are programmed using primitive data types', 'FALSE', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, ''),
(19, 'Simple data structures use composite or user-defined data types.', 'FALSE', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, ''),
(20, 'Records is a collection of related data items or fields.', 'TRUE', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, ''),
(21, 'Entity is a set of values that the variable may assume', 'FALSE', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, ''),
(22, 'Attribute is a property of an entity', 'TRUE', 'DSAA211', 'UEAU1KCA', '2nd', 'Prelim', '1st', '-', 258, '');

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
-- Indexes for table `exam_session`
--
ALTER TABLE `exam_session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `exam_take`
--
ALTER TABLE `exam_take`
  ADD PRIMARY KEY (`examtake_id`),
  ADD UNIQUE KEY `student_name` (`student_id`,`subject_id`,`grading_per`) USING BTREE,
  ADD KEY `fk_exam_session` (`session_id`);

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `enrolled_student`
--
ALTER TABLE `enrolled_student`
  MODIFY `enrolled_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `examcreated`
--
ALTER TABLE `examcreated`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `exam_take`
--
ALTER TABLE `exam_take`
  MODIFY `examtake_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `identification`
--
ALTER TABLE `identification`
  MODIFY `examiden_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `matchingtype`
--
ALTER TABLE `matchingtype`
  MODIFY `matchtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `multiplechoice`
--
ALTER TABLE `multiplechoice`
  MODIFY `exammulti_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `prof_subjects`
--
ALTER TABLE `prof_subjects`
  MODIFY `prof_subject_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `trueorfalse`
--
ALTER TABLE `trueorfalse`
  MODIFY `trueorfalse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_take`
--
ALTER TABLE `exam_take`
  ADD CONSTRAINT `fk_exam_session` FOREIGN KEY (`session_id`) REFERENCES `exam_session` (`session_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
