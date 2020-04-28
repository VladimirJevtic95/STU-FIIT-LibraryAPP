-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2020 at 03:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_systems_stu_fiit`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `book_count` int(11) NOT NULL,
  `book_author_FK` int(11) NOT NULL,
  `book_genre_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(40) COLLATE utf8_bin NOT NULL,
  `author_surname` varchar(40) COLLATE utf8_bin NOT NULL,
  `author_date_of_birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `book_genre`
--

CREATE TABLE `book_genre` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `book_genre`
--

INSERT INTO `book_genre` (`genre_id`, `genre_name`) VALUES
(1, 'Action and adventure'),
(2, 'Alternate history'),
(3, 'Anthology'),
(4, 'Chick lit'),
(5, 'Children\'s'),
(6, 'Comic book'),
(7, 'Coming-of-age'),
(8, 'Crime'),
(9, 'Drama'),
(10, 'Fairy-tale'),
(11, 'Fantasy'),
(12, 'Graphic novel'),
(13, 'Historical fiction'),
(14, 'Horror'),
(15, 'Mystery'),
(16, 'Paranormal romance'),
(17, 'Picture book'),
(18, 'Poetry'),
(19, 'Political thriller'),
(20, 'Romance'),
(21, 'Satire'),
(22, 'Science fiction'),
(23, 'Short story'),
(24, 'Suspense'),
(25, 'Thriller'),
(26, 'Young adult'),
(27, 'Novel'),
(28, 'Art'),
(29, 'Autobiography'),
(30, 'Biography'),
(31, 'Book review'),
(32, 'Cookbook'),
(33, 'Diary'),
(34, 'Dictionary'),
(35, 'Encyclopedia'),
(36, 'Guide'),
(37, 'Health'),
(38, 'History'),
(39, 'Journal'),
(40, 'Math'),
(41, 'Memoir'),
(42, 'Prayer'),
(43, 'Religion, spirituality, and new age'),
(44, 'Textbook'),
(45, 'Review'),
(46, 'Science'),
(47, 'Self help'),
(48, 'Travel'),
(49, 'True crime');

-- --------------------------------------------------------

--
-- Table structure for table `book_located`
--

CREATE TABLE `book_located` (
  `book_located_id` int(11) NOT NULL,
  `book_located_book_FK` int(11) NOT NULL,
  `book_located_library_FK` int(11) NOT NULL,
  `book_located_left` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `book_rented`
--

CREATE TABLE `book_rented` (
  `rent_id` int(11) NOT NULL,
  `rent_person_FK` int(11) NOT NULL,
  `rent_book_FK` int(11) NOT NULL,
  `rent_date` date NOT NULL,
  `rent_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `book_review`
--

CREATE TABLE `book_review` (
  `review_id` int(11) NOT NULL,
  `review_text` varchar(400) COLLATE utf8_bin NOT NULL,
  `review_rating` int(11) NOT NULL,
  `review_time` time NOT NULL,
  `review_date` date NOT NULL,
  `review_book_id_FK` int(11) NOT NULL,
  `review_person_id_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `library_data`
--

CREATE TABLE `library_data` (
  `library_id` int(11) NOT NULL,
  `library_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `library_country` varchar(5) COLLATE utf8_bin NOT NULL,
  `library_adress` varchar(100) COLLATE utf8_bin NOT NULL,
  `library_size_FK` int(11) NOT NULL,
  `library_type_FK` int(11) NOT NULL,
  `library_phone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `library_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `library_website` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `library_size`
--

CREATE TABLE `library_size` (
  `library_size_id` int(11) NOT NULL,
  `library_size_name` varchar(40) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `library_type`
--

CREATE TABLE `library_type` (
  `library_type_id` int(11) NOT NULL,
  `library_type_name` varchar(40) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `person_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `person_surname` varchar(20) COLLATE utf8_bin NOT NULL,
  `person_username` varchar(50) COLLATE utf8_bin NOT NULL,
  `person_password` varchar(50) COLLATE utf8_bin NOT NULL,
  `person_age` int(11) DEFAULT NULL,
  `person_role_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `person_name`, `person_surname`, `person_username`, `person_password`, `person_age`, `person_role_FK`) VALUES
(1, 'Vladimir', 'Jevtic', 'Vladica24', 'Vladica24', 24, 1),
(2, 'Danica', 'Patric', 'DanDan', 'DanDan', 56, 2),
(4, 'admin', 'admin', 'admin', 'admin', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'renter'),
(2, 'librarian'),
(3, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `book_author_FK` (`book_author_FK`),
  ADD KEY `book_genre_FK` (`book_genre_FK`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `book_genre`
--
ALTER TABLE `book_genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `book_located`
--
ALTER TABLE `book_located`
  ADD PRIMARY KEY (`book_located_id`),
  ADD KEY `book_located_book_FK` (`book_located_book_FK`),
  ADD KEY `book_located_library_FK` (`book_located_library_FK`);

--
-- Indexes for table `book_rented`
--
ALTER TABLE `book_rented`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `rent_person_FK` (`rent_person_FK`),
  ADD KEY `rent_book_FK` (`rent_book_FK`);

--
-- Indexes for table `book_review`
--
ALTER TABLE `book_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `review_book_id_FK` (`review_book_id_FK`),
  ADD KEY `review_person_id_FK` (`review_person_id_FK`);

--
-- Indexes for table `library_data`
--
ALTER TABLE `library_data`
  ADD PRIMARY KEY (`library_id`),
  ADD KEY `library_size_FK` (`library_size_FK`),
  ADD KEY `library_tye_FK` (`library_type_FK`);

--
-- Indexes for table `library_size`
--
ALTER TABLE `library_size`
  ADD PRIMARY KEY (`library_size_id`);

--
-- Indexes for table `library_type`
--
ALTER TABLE `library_type`
  ADD PRIMARY KEY (`library_type_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`),
  ADD KEY `person_role_FK` (`person_role_FK`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_author`
--
ALTER TABLE `book_author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_genre`
--
ALTER TABLE `book_genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `book_located`
--
ALTER TABLE `book_located`
  MODIFY `book_located_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_rented`
--
ALTER TABLE `book_rented`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_review`
--
ALTER TABLE `book_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_data`
--
ALTER TABLE `library_data`
  MODIFY `library_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_size`
--
ALTER TABLE `library_size`
  MODIFY `library_size_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library_type`
--
ALTER TABLE `library_type`
  MODIFY `library_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`book_author_FK`) REFERENCES `book_author` (`author_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`book_genre_FK`) REFERENCES `book_genre` (`genre_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_located`
--
ALTER TABLE `book_located`
  ADD CONSTRAINT `book_located_ibfk_1` FOREIGN KEY (`book_located_library_FK`) REFERENCES `library_data` (`library_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_located_ibfk_2` FOREIGN KEY (`book_located_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_rented`
--
ALTER TABLE `book_rented`
  ADD CONSTRAINT `book_rented_ibfk_1` FOREIGN KEY (`rent_book_FK`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_rented_ibfk_2` FOREIGN KEY (`rent_person_FK`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_review`
--
ALTER TABLE `book_review`
  ADD CONSTRAINT `book_review_ibfk_1` FOREIGN KEY (`review_book_id_FK`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_review_ibfk_2` FOREIGN KEY (`review_person_id_FK`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `library_data`
--
ALTER TABLE `library_data`
  ADD CONSTRAINT `library_data_ibfk_1` FOREIGN KEY (`library_size_FK`) REFERENCES `library_size` (`library_size_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `library_data_ibfk_2` FOREIGN KEY (`library_type_FK`) REFERENCES `library_type` (`library_type_id`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`person_role_FK`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
