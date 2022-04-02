-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2021 at 08:27 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarymanage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(20) NOT NULL,
  `Member_id` int(20) NOT NULL,
  `Name` varchar(90) NOT NULL,
  `Emailid` varchar(150) NOT NULL,
  `MobileNo` varchar(20) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Member_id`, `Name`, `Emailid`, `MobileNo`, `photo`, `password`, `regdate`) VALUES
(1, 11, 'Ankit Kumar', 'ankit12@gmail.com', '5544421', 'uploads/calm-interesting-bearded-guy-trendy-260nw-1017384106.jpg', '123', '2021-11-14 05:06:12'),
(2, 123, 'Charles', 'charles123@gmail.com', '52232313', 'uploads/senior-s-face-as-biometric-passport-photo-neutral-154060648.jpg', '123', '2021-11-15 07:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `a_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `regdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`a_id`, `name`, `status`, `regdate`) VALUES
(1, 'George T Heineman', 1, '2021-11-14 05:43:11'),
(2, 'Gary Pollice', 1, '2021-11-14 05:43:27'),
(3, 'Stanley Selkow', 1, '2021-11-14 05:43:53'),
(4, 'Robert L. Kruse', 1, '2021-11-14 05:44:10'),
(5, 'Seymour Lipschutz', 1, '2021-11-14 05:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `b_id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `author` varchar(200) NOT NULL,
  `volume` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `cover` varchar(200) NOT NULL,
  `isbn` int(20) NOT NULL,
  `price` float NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`b_id`, `name`, `categoryid`, `author`, `volume`, `quantity`, `cover`, `isbn`, `price`, `regdate`) VALUES
(1, 'Algorithms in a Nutshell', 3, 'George T Heineman,Gary Pollice,Stanley Selkow', 0, 4, 'uploads/PDF-Algorithms-in-a-Nutshell-By-George-T-Heineman-Gary-Pollice-Stanley-Selkow-Book-Free-Download.jpg', 1244105, 950.5, '2021-11-14 07:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `name`, `status`, `creationdate`) VALUES
(1, 'Arts and Music', 1, '2021-11-14 05:29:14'),
(2, 'Business', 1, '2021-11-14 05:29:55'),
(3, 'Computers & Tech', 1, '2021-11-14 05:30:44'),
(4, 'Entertainment', 1, '2021-11-14 05:31:07'),
(5, 'History', 1, '2021-11-14 05:31:24'),
(6, 'Literature & Fiction', 1, '2021-11-14 05:32:00'),
(7, 'Medical', 1, '2021-11-14 05:32:12'),
(8, 'Science & Math', 1, '2021-11-14 05:32:44'),
(9, 'Social Science', 1, '2021-11-14 05:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `issuedbook`
--

CREATE TABLE `issuedbook` (
  `i_id` int(20) NOT NULL,
  `bookid` int(20) NOT NULL,
  `Studentid` int(20) NOT NULL,
  `issuedate` timestamp NULL DEFAULT NULL,
  `returndate` timestamp NULL DEFAULT NULL,
  `returneddate` timestamp NULL DEFAULT NULL,
  `fine` float NOT NULL DEFAULT 0,
  `returnstatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `issuedbook`
--

INSERT INTO `issuedbook` (`i_id`, `bookid`, `Studentid`, `issuedate`, `returndate`, `returneddate`, `fine`, `returnstatus`) VALUES
(14, 1, 123, '2021-11-16 18:30:00', '2021-12-07 18:30:00', NULL, 0, 1),
(15, 1, 222, '2021-11-17 18:30:00', '2021-12-08 18:30:00', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `r_id` int(20) NOT NULL,
  `bookid` int(20) NOT NULL,
  `Studentid` int(20) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedate` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`r_id`, `bookid`, `Studentid`, `regdate`, `updatedate`, `status`) VALUES
(10, 1, 123, '2021-11-17 09:51:29', '2021-11-16 18:30:00', 3),
(13, 1, 1199, '2021-11-18 03:57:32', '2021-11-17 18:30:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Studentid` int(20) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Emailid` varchar(150) NOT NULL,
  `Mobilenumber` varchar(20) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `book_slot` int(11) NOT NULL DEFAULT 5,
  `photo` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Studentid`, `Name`, `Emailid`, `Mobilenumber`, `Password`, `book_slot`, `photo`, `status`, `regdate`) VALUES
(123, 'Neha', 'neha453@gmail.com', '4333245672', '123', 5, 'uploads/5f2d25348d99b_thumb900.jpg', 1, '2021-11-17 16:02:38'),
(222, 'Robert', 'robert123@gmail.com', '4321456712', '123', 4, 'uploads/655271f0571687022d6b4ba3ca276c48.jpg', 1, '2021-11-18 03:55:10'),
(1199, 'Julie', 'julie@gmail.com', '9999999999', '123', 5, 'uploads/pexels-photo-6283527.jpeg', 1, '2021-11-18 03:58:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `memberid` (`Member_id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `category` (`categoryid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `issuedbook`
--
ALTER TABLE `issuedbook`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `bookid` (`bookid`),
  ADD KEY `student` (`Studentid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `studentid` (`Studentid`),
  ADD KEY `book` (`bookid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Studentid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `b_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `issuedbook`
--
ALTER TABLE `issuedbook`
  MODIFY `i_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `r_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Studentid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11200;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `category` FOREIGN KEY (`categoryid`) REFERENCES `category` (`c_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `issuedbook`
--
ALTER TABLE `issuedbook`
  ADD CONSTRAINT `bookid` FOREIGN KEY (`bookid`) REFERENCES `books` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student` FOREIGN KEY (`Studentid`) REFERENCES `students` (`Studentid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `book` FOREIGN KEY (`bookid`) REFERENCES `books` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studentid` FOREIGN KEY (`Studentid`) REFERENCES `students` (`Studentid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
