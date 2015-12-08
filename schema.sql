-- phpMyAdmin SQL Dump
-- version 4.2.9
-- http://www.phpmyadmin.net
--
-- Host: webdb.uvm.edu
-- Generation Time: Dec 07, 2015 at 10:22 PM
-- Server version: 5.5.45-37.4-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `DSCHICK_Pettr`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblNonOwners`
--

CREATE TABLE IF NOT EXISTS `tblNonOwners` (
  `pmkId` varchar(12) NOT NULL,
  `fldOwnerName` varchar(100) NOT NULL,
  `fldDesc` text NOT NULL,
  `fldEmail` varchar(100) NOT NULL,
  `fldPhone` varchar(50) NOT NULL,
  `fldCity` varchar(50) NOT NULL,
  `fldState` varchar(2) NOT NULL,
  `fldPetType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblNonOwners`
--

INSERT INTO `tblNonOwners` (`pmkId`, `fldOwnerName`, `fldDesc`, `fldEmail`, `fldPhone`, `fldCity`, `fldState`, `fldPetType`) VALUES
('dschick', 'Danny Schick', 'Looking to pet some pets', 'schickd12@gmail.com', '8029224404', 'Burlington', 'VT', 'Dog');

-- --------------------------------------------------------

--
-- Table structure for table `tblOwners`
--

CREATE TABLE IF NOT EXISTS `tblOwners` (
  `fldDesc` text,
  `fldOwnerName` varchar(50) DEFAULT NULL,
  `fldEmail` varchar(75) DEFAULT NULL,
  `fldPhone` varchar(50) DEFAULT NULL,
  `fldCity` varchar(50) DEFAULT NULL,
  `fldPetName` varchar(15) DEFAULT NULL,
  `fldPetType` varchar(100) DEFAULT NULL,
  `fldPetAge` int(2) DEFAULT NULL,
  `fldState` varchar(12) DEFAULT NULL,
  `pmkId` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblOwners`
--

INSERT INTO `tblOwners` (`fldDesc`, `fldOwnerName`, `fldEmail`, `fldPhone`, `fldCity`, `fldPetName`, `fldPetType`, `fldPetAge`, `fldState`, `pmkId`) VALUES
('Hi! I''ve been a bit busy lately and haven''t been able to take out my dog for a walk everyday, looking for some help!', 'Alex Barnes', 'atbarnes@uvm.edu', '8028816375', 'Colchester', 'Murphy', 'Dog', 6, 'Vermont', 'atbarnes'),
('Leo is a cutie who''s looking to meet freinds', 'Danny Schick', NULL, NULL, 'Burlington', 'Leo', 'Cat', 4, 'Vermont', 'dschick'),
('I have a dog that I want to be taken on walks', 'John Barrows', 'jBarr@gmail.com', NULL, 'Burlington', 'Barry', 'Dog', 10, 'VT', 'jbarr'),
('Looking for a playmate', 'Keri Honmy', 'KeriHon@gmail.com', '8028675309', 'Colchester', 'Cupcake', 'Corgi', 6, 'VT', 'KHon'),
('Love long walks and getting caught in the rain!', 'Eric Levri', 'leviJe@gmail.com', '8028675309', 'Burlington', 'Mittens', 'Black Lab', 4, 'VT', 'leviJeans'),
('Looking for a friend to play frisbee with', 'Matt Lucier', 'mlucier96@gmail.com', '3027346127', 'Colchester', 'Toby', 'Retreiver', 10, 'VT', 'mlucier'),
('Looking for other dogs to go on adventures with', 'Phil Masterson', 'philMast@gmail.com', '802675309', 'Winooski', 'Hutch', 'Husky', 9, 'VT', 'philM'),
('Looking for other dogs to play fetch with!', 'Joe Schmitt', 'jSchmitty@gmail.com', '8028675309', 'South Burlington', 'Fido', 'Shiba Inu', 7, 'VT', 'schmitty'),
('Come spend time with my beautiful dog! You won''t regret it if you do!', 'Sam Pakulski', 'bigswoof@gmail.com', NULL, 'Colchester', 'Buckaroo', 'Alaskan Husky', 2, 'Vermont', 'spakulsk');

-- --------------------------------------------------------

--
-- Table structure for table `tblPhotos`
--

CREATE TABLE IF NOT EXISTS `tblPhotos` (
`pmkPhotoId` int(100) NOT NULL,
  `fldURL` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblPhotos`
--

INSERT INTO `tblPhotos` (`pmkPhotoId`, `fldURL`) VALUES
(4, 'uploads/1115151705_HDR.jpg'),
(11, 'uploads/IMG_20151115_162640.jpg'),
(12, 'uploads/petr.png'),
(13, 'uploads/desktop-hd-pics-of-dogs-at-christmas.jpg'),
(14, 'uploads/beautiful-cute-dog-high-definition-wallpaper-for-desktop-background-free-download.jpg'),
(15, 'images/alexDog.jpg'),
(16, 'uploads/dog.jpg'),
(18, 'uploads/'),
(19, 'uploads/'),
(20, 'uploads/'),
(27, 'uploads/ye0qo1Q.jpg'),
(28, 'uploads/2001SpaceOdyssey.jpg'),
(31, 'uploads/Penguins.jpg'),
(32, 'uploads/Lighthouse.jpg'),
(33, 'uploads/43fa5497dcee9ce7dab90d23ccd7aeb1.jpg'),
(34, 'uploads/6902527-black-lab-hd.jpg'),
(35, 'uploads/shibe.jpg'),
(36, 'uploads/shibe2.jpg'),
(37, 'uploads/Siberian_Husky_with_Blue_Eyes.jpg'),
(38, 'uploads/aladdin-siberian-husky-10.jpg'),
(39, 'uploads/corgi.jpg'),
(40, 'uploads/corgi2.jpg'),
(41, 'uploads/goldenretrieversf1.jpg'),
(42, 'uploads/retrieve.jpeg'),
(43, 'uploads/retrieve3.jpeg'),
(44, 'uploads/goldenretrieversf1.jpg'),
(45, 'uploads/hqdefault.jpg'),
(46, 'uploads/43d201e307893789c3231a4d677d61dc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblRelations`
--

CREATE TABLE IF NOT EXISTS `tblRelations` (
  `fnkUserId` varchar(100) NOT NULL,
  `fnkProfileId` varchar(100) NOT NULL,
  `fldLiked` varchar(10) NOT NULL DEFAULT 'F',
  `fldMatched` varchar(10) NOT NULL DEFAULT 'F'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblRelations`
--

INSERT INTO `tblRelations` (`fnkUserId`, `fnkProfileId`, `fldLiked`, `fldMatched`) VALUES
('jbarr', 'dschick', 'T', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `tblSeen`
--

CREATE TABLE IF NOT EXISTS `tblSeen` (
  `pmkUserId` varchar(12) NOT NULL,
  `fnkProfileId` varchar(12) NOT NULL,
  `fldSeen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblSeen`
--

INSERT INTO `tblSeen` (`pmkUserId`, `fnkProfileId`, `fldSeen`) VALUES
('dschick', 'atbarnes', 0),
('dschick', 'dschick', 0),
('dschick', 'jbarr', 0),
('dschick', 'KHon', 0),
('dschick', 'leviJeans', 0),
('dschick', 'mlucier', 0),
('dschick', 'philM', 0),
('dschick', 'schmitty', 0),
('dschick', 'spakulsk', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblUserPhotos`
--

CREATE TABLE IF NOT EXISTS `tblUserPhotos` (
  `fnkUserId` varchar(100) NOT NULL,
`fnkPhotoId` int(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblUserPhotos`
--

INSERT INTO `tblUserPhotos` (`fnkUserId`, `fnkPhotoId`) VALUES
('jbarr', 13),
('jbarr', 14),
('atbarnes', 15),
('atbarnes', 16),
('dschick', 31),
('dschick', 32),
('leviJeans', 33),
('leviJeans', 34),
('schmitty', 35),
('schmitty', 36),
('philM', 37),
('philM', 38),
('KHon', 39),
('KHon', 40),
('blank', 41),
('mlucier', 42),
('mlucier', 43),
('mlucier', 44),
('spakulsk', 45),
('spakulsk', 46);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblNonOwners`
--
ALTER TABLE `tblNonOwners`
 ADD PRIMARY KEY (`pmkId`);

--
-- Indexes for table `tblOwners`
--
ALTER TABLE `tblOwners`
 ADD UNIQUE KEY `fnkId` (`pmkId`);

--
-- Indexes for table `tblPhotos`
--
ALTER TABLE `tblPhotos`
 ADD PRIMARY KEY (`pmkPhotoId`);

--
-- Indexes for table `tblRelations`
--
ALTER TABLE `tblRelations`
 ADD PRIMARY KEY (`fnkUserId`,`fnkProfileId`);

--
-- Indexes for table `tblSeen`
--
ALTER TABLE `tblSeen`
 ADD PRIMARY KEY (`pmkUserId`,`fnkProfileId`);

--
-- Indexes for table `tblUserPhotos`
--
ALTER TABLE `tblUserPhotos`
 ADD PRIMARY KEY (`fnkPhotoId`), ADD UNIQUE KEY `fnkPhotoId` (`fnkPhotoId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblPhotos`
--
ALTER TABLE `tblPhotos`
MODIFY `pmkPhotoId` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `tblUserPhotos`
--
ALTER TABLE `tblUserPhotos`
MODIFY `fnkPhotoId` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
