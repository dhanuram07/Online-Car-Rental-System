-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 01, 2024 at 05:49 AM
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
-- Database: `rental_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bid` int(11) NOT NULL,
  `carid` varchar(5) DEFAULT NULL,
  `carnum` varchar(10) DEFAULT NULL,
  `userid` int(5) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `finalamt` decimal(10,3) DEFAULT NULL,
  `carname` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `carid` varchar(5) NOT NULL,
  `carnum` varchar(10) DEFAULT NULL,
  `carname` varchar(20) DEFAULT NULL,
  `seating` int(11) NOT NULL,
  `flag` int(11) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `dayprice` decimal(10,2) DEFAULT NULL,
  `hourprice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`carid`, `carnum`, `carname`, `seating`, `flag`, `image`, `dayprice`, `hourprice`) VALUES
('c1', 'KA05KJ5656', 'Mahindra XUV500', 5, 1, 'images/cars/xuv500.jpg', 3000.00, 300.00),
('c10', 'KA05UV9908', 'VW Taigun', 5, 1, 'images/cars/vw_taigun.jpg', 2700.00, 270.00),
('c11', 'KA05JS7732', 'Mercedes-Benz GLA', 5, 1, 'images/cars/mb_gla.jpg', 5300.00, 600.00),
('c12', 'KA05MD6656', 'BMW X1', 5, 1, 'images/cars/bmw_x1.jpg', 6000.00, 740.00),
('c13', 'KA05ER8430', 'Mercedes-Benz GLS600', 4, 1, 'images/cars/gls600.jpg', 7000.00, 810.00),
('c14', 'KA05FF3410', 'BMW 7 Series', 4, 1, 'images/cars/bmw_7.jpg', 7100.00, 810.00),
('c15', 'KA05RQ1111', 'Rolls-Royce Phantom', 5, 1, 'images/cars/phantom.jpg', 11000.00, 1100.00),
('c16', 'KA05DG8055', 'Bentley Continental', 5, 1, 'images/cars/continental.jpg', 10000.00, 1000.00),
('c2', 'KA05KM1968', 'Tata Safari', 8, 1, 'images/cars/tata_safari.jpg', 3000.00, 300.00),
('c3', 'KA05JSM816', 'Tata Nexon', 5, 1, 'images/cars/tata_nexon.jpeg', 2300.00, 250.00),
('c4', 'KA05YT6119', 'Hyundai Creta', 5, 1, 'images/cars/hyundai_creta.jpg', 2600.00, 280.00),
('c5', 'KA05PK1243', 'Renault Kwid', 5, 1, 'images/cars/kwid.jpg', 2200.00, 220.00),
('c6', 'KA05KP3421', 'Toyota Innova Hycros', 8, 1, 'images/cars/hycross.jpg', 3100.00, 370.00),
('c7', 'KA05KB7789', 'Toyota Fortuner', 7, 1, 'images/cars/fortuner.jpg', 3300.00, 400.00),
('c8', 'KA05AP0081', 'Jeep Compass', 5, 1, 'images/cars/compass.jpg', 2800.00, 360.00),
('c9', 'KA05TD1155', 'Skoda Kushaq', 5, 1, 'images/cars/kushaq.jpg', 2500.00, 360.00);

-- --------------------------------------------------------

--
-- Table structure for table `rent_history`
--

CREATE TABLE `rent_history` (
  `hid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `carnum` varchar(10) DEFAULT NULL,
  `carname` varchar(20) DEFAULT NULL,
  `finalamt` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent_history`
--

INSERT INTO `rent_history` (`hid`, `userid`, `carnum`, `carname`, `finalamt`) VALUES
(1, 25, 'KA05JS7732', 'Mercedes-Benz GLA', 2400.000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(5) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` int(12) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `fullname`, `username`, `email`, `phone`, `password`) VALUES
(25, 'dhanuram', 'dhanuram07', 'dhanuram@d.com', 82782882, 'dhanuram');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`carid`);

--
-- Indexes for table `rent_history`
--
ALTER TABLE `rent_history`
  ADD PRIMARY KEY (`hid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rent_history`
--
ALTER TABLE `rent_history`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
