-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 01, 2019 at 03:43 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ATM`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `account_number` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `amount_of_money` double DEFAULT NULL,
  `password_try` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`account_number`, `Name`, `Password`, `amount_of_money`, `password_try`) VALUES
(1, 'Mohamed Abdelfatah', '2', 9700, 1),
(2, 'Ahmed', '2', 36919, 0),
(3, 'Ayman', '3', 41110, 0),
(101010, 'Mohamed Abdelfatah', '123456', 20100, 4);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Transactions` varchar(45) DEFAULT NULL,
  `Number_transactions` int(11) DEFAULT NULL,
  `client_account_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`Transactions`, `Number_transactions`, `client_account_number`) VALUES
('100', 0, 1),
('100', 1, 1),
('100', 2, 1),
('100', 3, 1),
('100', 4, 1),
('100', 5, 1),
('-300', 6, 1),
('-300', 7, 1),
('1000', 0, 2),
('30', 1, 2),
('4010', 2, 2),
('3220', 3, 2),
('-1221', 4, 2),
('-120', 5, 2),
('10', 0, 3),
('100', 1, 3),
('1000', 2, 3),
('2000', 3, 3),
('-2000', 4, 3),
('100', 0, 101010),
('3000', 1, 101010),
('3000', 2, 101010),
('3000', 3, 101010),
('3000', 4, 101010),
('-2000', 5, 101010);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`account_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
