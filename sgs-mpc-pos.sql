-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2016 at 05:14 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgs-mpc-pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `employeedetails`
--

CREATE TABLE IF NOT EXISTS `employeedetails` (
  `EmployeeID` varchar(16) NOT NULL,
  `SurrName` varchar(50) NOT NULL,
  `GivenName` varchar(30) NOT NULL,
  `MiddleName` varchar(30) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Branch` varchar(50) NOT NULL,
  `Position` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Address` varchar(256) NOT NULL,
  `ContactNo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employeelogin`
--

CREATE TABLE IF NOT EXISTS `employeelogin` (
  `EmployeeID` varchar(16) NOT NULL,
  `Password` varchar(65) NOT NULL,
  `LastUpdated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderdetail`
--

CREATE TABLE IF NOT EXISTS `purchaseorderdetail` (
  `ItemID` varchar(7) NOT NULL,
  `PurchaseRequestID` varchar(6) NOT NULL,
  `Item` varchar(30) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderheader`
--

CREATE TABLE IF NOT EXISTS `purchaseorderheader` (
  `PurchaseRequestID` varchar(6) NOT NULL,
  `EmployeeID` varchar(16) NOT NULL,
  `RequestDate` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employeedetails`
--
ALTER TABLE `employeedetails`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `employeelogin`
--
ALTER TABLE `employeelogin`
  ADD UNIQUE KEY `EmployeeID` (`EmployeeID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
