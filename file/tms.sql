-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 02:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Name` varchar(250) DEFAULT NULL,
  `EmailId` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Name`, `EmailId`, `MobileNumber`, `Password`, `updationDate`) VALUES
(1, 'admin', 'Rabinaemy', 'rabinaemy12@gmail.com', 9800000000, 'f925916e2754e5e03f75dd58a5733251', '2024-11-10 05:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `BookingId` int(11) NOT NULL,
  `PackageId` int(11) DEFAULT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `FromDate` varchar(100) DEFAULT NULL,
  `ToDate` varchar(100) DEFAULT NULL,
  `Comment` mediumtext DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `CancelledBy` varchar(5) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbooking`
--

INSERT INTO `tblbooking` (`BookingId`, `PackageId`, `UserEmail`, `FromDate`, `ToDate`, `Comment`, `RegDate`, `status`, `CancelledBy`, `UpdationDate`) VALUES
(7, 13, 'rabinasapkota123@gmail.com', '2024-11-10', '2024-11-19', 'Nice View', '2024-11-18 14:21:18', 1, NULL, '2024-11-18 14:32:39'),
(8, 17, 'emy123@gmail.com', '2024-11-12', '2024-11-14', 'Fantastic View', '2024-11-18 14:25:57', 1, NULL, '2024-11-18 14:32:32'),
(9, 11, 'rabinasapkota123@gmail.com', '2024-11-20', '2024-11-22', 'nhello', '2024-11-20 05:15:43', 1, NULL, '2024-12-05 13:40:23'),
(10, 11, 'rabinasapkota123@gmail.com', '2024-11-10', '2024-11-19', 'Nice View', '2024-12-14 12:21:18', 0, NULL, NULL),
(11, 15, 'rabin123@gmail.com', '2024-11-10', '2024-11-19', 'Nice View', '2024-12-14 13:03:03', 0, NULL, NULL),
(12, 16, 'sunita123@gmail.com', '2024-11-10', '2024-11-14', 'nsn', '2024-12-14 13:06:19', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE `tblenquiry` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblenquiry`
--

INSERT INTO `tblenquiry` (`id`, `FullName`, `EmailId`, `MobileNumber`, `Subject`, `Description`, `PostingDate`, `Status`) VALUES
(6, 'Emylisa Pandit', 'emy12@gmail.com', '9800000000', 'mistake', 'Suggestion is not that much efficient.', '2024-11-18 14:30:14', 1),
(7, 'Rabina Sapkota', 'rabinasapkota123@gmail.com', '9800000000', 'Enquiry for places', 'Tell me the more description about the places.', '2024-12-12 05:44:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblissues`
--

CREATE TABLE `tblissues` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `Issue` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminremarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblissues`
--

INSERT INTO `tblissues` (`id`, `UserEmail`, `Issue`, `Description`, `PostingDate`, `AdminRemark`, `AdminremarkDate`) VALUES
(0, 'rabinasapkota123@gmail.com', 'Booking Issues', 'Can\'t book the destination which i want to do', '2024-11-20 01:45:50', 'ok we will slove this problem', '2024-11-20 01:47:02');

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT '',
  `detail` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbltourpackages`
--

CREATE TABLE `tbltourpackages` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(200) DEFAULT NULL,
  `PackageType` varchar(150) DEFAULT NULL,
  `PackageLocation` varchar(100) DEFAULT NULL,
  `PackagePrice` int(11) DEFAULT NULL,
  `PackageFetures` varchar(255) DEFAULT NULL,
  `PackageDetails` mediumtext DEFAULT NULL,
  `PackageImage` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO `tbltourpackages` (`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackagePrice`, `PackageFetures`, `PackageDetails`, `PackageImage`, `Creationdate`, `UpdationDate`) VALUES
(11, 'Pokhara, Fewa Taal', 'Family Package, Group Package', 'Pokhara', 300, 'No package feature', 'Phewa Tal is a lake in Nepal and is the biggest lake in the Pokhara. It is famous for having a lot of domestic and international tourists who visit and sail, swim and fish on the Phewa lake. ', 'Phewalake.png', '2024-11-18 08:35:28', '2024-11-18 14:13:07'),
(12, 'Basantapur', 'Group Package', 'Kathmandu, Nepal', 400, 'free pickup service', 'It is a heritage of Nepal which show the lots of special architecture.\r\n', 'bastapur.png', '2024-11-18 12:55:49', '2024-12-14 12:29:44'),
(13, 'PoonHill, Ghorepani', 'Couple Package', 'Maygdi', 500, 'Trekking root', 'you’ll see mountains like Annapurna and Dhaulagiri. These mountains are covered in snow and look breathtaking, especially when the sun rises or sets. ', 'poonnhill.jpg', '2024-11-18 13:03:41', NULL),
(14, 'Kokhe Dada,GhiliBaryang', 'Group Package', 'Parbat', 400, 'Trekking root', ' Kokhe Danda is a hilltop situated at around 3303m altitude in Annapurna Dhaulagiri region. It is the hill just next to Mohare Danda. This is also the highest point of Parbat district and a great viewpoint for the view of Himalayas.', 'kokhe.jpg', '2024-11-18 13:09:42', '2024-11-18 13:10:20'),
(15, ' Buddha birth place', 'Family package', 'Lumbini', 600, 'No package feature', 'Lumbini is the Buddha\'s birthplace, located at Rupandehi, Nepal, is one of the world\'s most important spiritual sites and attracts Buddhist pilgrims from around the world.', 'lumbini.png', '2024-11-18 13:58:37', NULL),
(16, 'Muktinath Darsan', 'Group Package', 'Mustang', 1500, 'free pickup service', 'Muktinath Temple of Nepal  and its premises are one of the great Pilgrimage site for both Hinduism and Buddhism follower. There are several holy sites in Nepal, belongs to or related to different god and goddess. Among them this shrine area is very special, Situated in the Lap of remote Mukthinath Valley area at an elevation of 3,710 metres (12171 ft)', 'muktinath.png', '2024-11-18 14:02:35', '2024-12-14 12:31:27'),
(17, 'Champadevi  Hikes', 'Couple Package', 'Kathmandu, Nepal', 500, 'Trekking root', 'Champadevi Hike is one of the shortest one-day hikes in Nepal. This hike is suited for those who have comparatively less time. It gives enough gateway to explore the beauty of Nepal.', 'cham.jpg', '2024-11-18 14:07:11', '2024-12-14 12:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `EmailId` varchar(70) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `MobileNumber`, `EmailId`, `Password`, `RegDate`, `UpdationDate`) VALUES
(12, 'Rabina Sapkota', '9800000000', 'rabinasapkota123@gmail.com', '6f64d928477a46a9825c0846bc272524', '2024-11-18 08:41:37', '2024-11-20 01:38:10'),
(13, 'Emylisa Pandit', '9800000000', 'emy123@gmail.com', '70f64e18d275e03acdabb6d73701eac4', '2024-11-18 14:22:56', NULL),
(14, 'Rabin Sapkota', '981111111', 'rabinsapkota2055bs@gmail.com', '1ab68f1405e466e85f91176d3a35546b', '2024-11-18 14:27:00', NULL),
(15, 'DikshyaMagar', '9811111111', 'dikshya12@gmail.com', '4eaa050b271de0a1b762a798374cfe4d', '2024-11-18 14:28:16', NULL),
(16, 'Aaisha Prasain', '9800000000', 'aaisha12@gmail.com', 'a674ca2670f8bda8863337121e107a47', '2024-11-18 14:28:40', NULL),
(17, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2024-11-20 01:45:50', NULL),
(18, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2024-11-20 01:46:12', NULL),
(19, 'Rabin Sapkota', '9845806889', 'rabin123@gmail.com', '31029dde2976f44e327edbeef34aac01', '2024-12-10 11:46:06', NULL),
(20, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2024-12-12 05:59:00', NULL),
(21, 'Sunita Sapkota', '9800000000', 'sunita123@gmail.com', '2380290cdae994b378ed783d7e563b67', '2024-12-14 12:32:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userinteractions`
--

CREATE TABLE `userinteractions` (
  `InteractionID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PackageID` int(11) NOT NULL,
  `InteractionType` varchar(100) DEFAULT NULL,
  `InteractionDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinteractions`
--

INSERT INTO `userinteractions` (`InteractionID`, `UserID`, `PackageID`, `InteractionType`, `InteractionDate`) VALUES
(1, 6, 11, 'booked', '2024-11-19 13:34:27'),
(2, 7, 12, 'booked', '2024-11-19 13:40:30'),
(3, 8, 13, 'booked', '2024-11-20 13:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `userpackageviews`
--

CREATE TABLE `userpackageviews` (
  `ViewID` int(11) NOT NULL,
  `EmailId` varchar(255) NOT NULL,
  `PackageID` int(11) NOT NULL,
  `ViewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userpackageviews`
--

INSERT INTO `userpackageviews` (`ViewID`, `EmailId`, `PackageID`, `ViewDate`) VALUES
(1, 'rabinasapkota123@gmail.com', 11, '2024-12-09 15:10:06'),
(2, 'rabinasapkota123@gmail.com', 11, '2024-12-14 12:19:53'),
(3, 'rabinasapkota123@gmail.com', 11, '2024-12-14 12:21:18'),
(4, 'sunita123@gmail.com', 11, '2024-12-14 12:33:25'),
(5, 'sunita123@gmail.com', 14, '2024-12-14 12:49:21'),
(6, 'sunita123@gmail.com', 16, '2024-12-14 12:49:36'),
(7, 'sunita123@gmail.com', 12, '2024-12-14 12:49:43'),
(8, 'sunita123@gmail.com', 17, '2024-12-14 12:49:49'),
(9, 'sunita123@gmail.com', 12, '2024-12-14 12:49:56'),
(10, 'sunita123@gmail.com', 16, '2024-12-14 12:50:01'),
(11, 'sunita123@gmail.com', 14, '2024-12-14 12:50:12'),
(12, 'rabin123@gmail.com', 15, '2024-12-14 12:53:19'),
(13, 'rabin123@gmail.com', 14, '2024-12-14 12:53:29'),
(14, 'rabin123@gmail.com', 14, '2024-12-14 12:56:27'),
(15, 'rabin123@gmail.com', 14, '2024-12-14 12:56:29'),
(16, 'rabin123@gmail.com', 14, '2024-12-14 12:56:30'),
(17, 'rabin123@gmail.com', 14, '2024-12-14 12:56:30'),
(18, 'rabin123@gmail.com', 13, '2024-12-14 12:56:53'),
(19, 'rabinasapkota123@gmail.com', 16, '2024-12-14 12:58:37'),
(20, 'rabinasapkota123@gmail.com', 17, '2024-12-14 12:58:52'),
(21, 'rabinasapkota123@gmail.com', 17, '2024-12-14 12:58:58'),
(22, 'rabinasapkota123@gmail.com', 16, '2024-12-14 12:59:00'),
(23, 'rabin123@gmail.com', 15, '2024-12-14 13:02:53'),
(24, 'rabin123@gmail.com', 15, '2024-12-14 13:03:03'),
(25, 'sunita123@gmail.com', 16, '2024-12-14 13:05:59'),
(26, 'sunita123@gmail.com', 16, '2024-12-14 13:06:19'),
(27, 'sunita123@gmail.com', 16, '2024-12-14 13:06:25'),
(28, 'sunita123@gmail.com', 16, '2024-12-14 13:12:19'),
(29, 'sunita123@gmail.com', 16, '2024-12-14 13:12:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`BookingId`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblissues`
--
ALTER TABLE `tblissues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`),
  ADD KEY `EmailId_2` (`EmailId`);

--
-- Indexes for table `userinteractions`
--
ALTER TABLE `userinteractions`
  ADD PRIMARY KEY (`InteractionID`),
  ADD KEY `PackageID` (`PackageID`);

--
-- Indexes for table `userpackageviews`
--
ALTER TABLE `userpackageviews`
  ADD PRIMARY KEY (`ViewID`),
  ADD KEY `PackageID` (`PackageID`),
  ADD KEY `EmailId` (`EmailId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `userpackageviews`
--
ALTER TABLE `userpackageviews`
  MODIFY `ViewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userpackageviews`
--
ALTER TABLE `userpackageviews`
  ADD CONSTRAINT `userpackageviews_ibfk_1` FOREIGN KEY (`PackageID`) REFERENCES `tbltourpackages` (`PackageId`),
  ADD CONSTRAINT `userpackageviews_ibfk_2` FOREIGN KEY (`EmailId`) REFERENCES `tblusers` (`EmailId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
