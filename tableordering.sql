-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.21-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for tablefoodordering
DROP DATABASE IF EXISTS `tablefoodordering`;
CREATE DATABASE IF NOT EXISTS `tablefoodordering` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tablefoodordering`;

-- Dumping structure for table tablefoodordering.bokeditems
DROP TABLE IF EXISTS `bokeditems`;
CREATE TABLE IF NOT EXISTS `bokeditems` (
  `bi_id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL,
  `bi_transactioncode` varchar(255) NOT NULL,
  PRIMARY KEY (`bi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- Dumping data for table tablefoodordering.bokeditems: ~34 rows (approximately)
DELETE FROM `bokeditems`;
/*!40000 ALTER TABLE `bokeditems` DISABLE KEYS */;
INSERT INTO `bokeditems` (`bi_id`, `itemid`, `bi_transactioncode`) VALUES
	(1, 1, '0000'),
	(2, 2, '0000'),
	(3, 3, '0000'),
	(4, 6, 'TRC-1530078275551'),
	(5, 5, 'TRC-1530078275551'),
	(6, 1, 'TRC-1530078275551'),
	(7, 0, 'TRC-1530078275551'),
	(8, 6, 'TRC-1530080534330'),
	(9, 3, 'TRC-1530080534330'),
	(10, 0, 'TRC-1530080534330'),
	(11, 6, 'TRC-1530088410518'),
	(12, 3, 'TRC-1530088410518'),
	(13, 1, 'TRC-1530088410518'),
	(14, 0, 'TRC-1530088410518'),
	(15, 6, 'TRC-1530098776983'),
	(16, 3, 'TRC-1530098776983'),
	(17, 1, 'TRC-1530098776983'),
	(18, 0, 'TRC-1530098776983'),
	(19, 6, 'TRC-1530098789356'),
	(20, 3, 'TRC-1530098789356'),
	(21, 1, 'TRC-1530098789356'),
	(22, 0, 'TRC-1530098789356'),
	(23, 6, 'TRC-1530099213144'),
	(24, 3, 'TRC-1530099213144'),
	(25, 1, 'TRC-1530099213144'),
	(26, 0, 'TRC-1530099213144'),
	(27, 6, 'TRC-1530099279548'),
	(28, 3, 'TRC-1530099279548'),
	(29, 1, 'TRC-1530099279548'),
	(30, 0, 'TRC-1530099279548'),
	(31, 6, 'TRC-1530099568370'),
	(32, 3, 'TRC-1530099568370'),
	(33, 1, 'TRC-1530099568370'),
	(34, 0, 'TRC-1530099568370');
/*!40000 ALTER TABLE `bokeditems` ENABLE KEYS */;

-- Dumping structure for table tablefoodordering.foods
DROP TABLE IF EXISTS `foods`;
CREATE TABLE IF NOT EXISTS `foods` (
  `fd_id` int(11) NOT NULL AUTO_INCREMENT,
  `fd_name` varchar(50) DEFAULT NULL,
  `fd_type` varchar(50) DEFAULT NULL,
  `fd_price` double NOT NULL DEFAULT '0',
  `fd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fd_status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table tablefoodordering.foods: ~5 rows (approximately)
DELETE FROM `foods`;
/*!40000 ALTER TABLE `foods` DISABLE KEYS */;
INSERT INTO `foods` (`fd_id`, `fd_name`, `fd_type`, `fd_price`, `fd_date`, `fd_status`) VALUES
	(1, 'Ugali', 'FOOD', 2000, '2018-06-20 21:39:18', 0),
	(3, 'Water', 'BEVERAGE', 50, '2018-06-22 10:43:49', 0),
	(4, 'chappatti', 'Food', 2400, '2018-06-22 10:50:29', 0),
	(5, 'Wine', 'Beverage', 1400, '2018-06-22 10:50:57', 0),
	(6, 'Rice', 'Food', 2500, '2018-06-22 10:51:16', 0);
/*!40000 ALTER TABLE `foods` ENABLE KEYS */;

-- Dumping structure for table tablefoodordering.tbbooked
DROP TABLE IF EXISTS `tbbooked`;
CREATE TABLE IF NOT EXISTS `tbbooked` (
  `tbk_id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_id` int(11) NOT NULL,
  `transactioncode` varchar(255) NOT NULL,
  `postingdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paymentstatus` varchar(50) NOT NULL DEFAULT 'pending',
  `totalamount` double NOT NULL,
  `servingstatus` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tbk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table tablefoodordering.tbbooked: ~9 rows (approximately)
DELETE FROM `tbbooked`;
/*!40000 ALTER TABLE `tbbooked` DISABLE KEYS */;
INSERT INTO `tbbooked` (`tbk_id`, `tbl_id`, `transactioncode`, `postingdate`, `paymentstatus`, `totalamount`, `servingstatus`) VALUES
	(1, 1, '0000', '2018-06-25 23:28:18', 'pending', 3000, 0),
	(2, 1, 'TRC-1530078275551', '2018-06-27 08:44:35', 'pending', 5900, 0),
	(3, 2, 'TRC-1530080534330', '2018-06-27 09:22:13', 'pending', 2550, 0),
	(4, 2, 'TRC-1530088410518', '2018-06-27 11:41:46', 'pending', 4550, 0),
	(5, 2, 'TRC-1530098776983', '2018-06-27 14:34:33', 'pending', 4550, 0),
	(6, 2, 'TRC-1530098789356', '2018-06-27 14:34:45', 'PAYED', 4550, 0),
	(7, 1, 'TRC-1530099213144', '2018-06-27 14:41:49', 'PAYED', 4550, 0),
	(8, 1, 'TRC-1530099279548', '2018-06-27 14:42:55', 'pending', 4550, 0),
	(9, 2, 'TRC-1530099568370', '2018-06-27 14:47:44', 'PAYED', 4550, 0);
/*!40000 ALTER TABLE `tbbooked` ENABLE KEYS */;

-- Dumping structure for table tablefoodordering.tbltables
DROP TABLE IF EXISTS `tbltables`;
CREATE TABLE IF NOT EXISTS `tbltables` (
  `tbl_id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_numusers` int(11) NOT NULL DEFAULT '0',
  `tbl_name` varchar(50) DEFAULT NULL,
  `tbl_totalnumusers` int(11) NOT NULL DEFAULT '4',
  `tbl_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tbl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table tablefoodordering.tbltables: ~3 rows (approximately)
DELETE FROM `tbltables`;
/*!40000 ALTER TABLE `tbltables` DISABLE KEYS */;
INSERT INTO `tbltables` (`tbl_id`, `tbl_numusers`, `tbl_name`, `tbl_totalnumusers`, `tbl_date`) VALUES
	(1, 0, 'Table 001', 4, '2018-06-20 19:56:45'),
	(2, 2, 'Table 002', 8, '2018-06-20 19:57:27'),
	(3, 0, 'Table 003', 8, '2018-06-27 19:07:07');
/*!40000 ALTER TABLE `tbltables` ENABLE KEYS */;

-- Dumping structure for table tablefoodordering.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(13) NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_passwordsalt` text,
  `user_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_phone` (`user_phone`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table tablefoodordering.users: ~3 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_name`, `user_phone`, `user_email`, `user_password`, `user_passwordsalt`, `user_date`, `user_type`) VALUES
	(2, 'Yonah', '0056700', '', '0000', '4a7d1ed414474e4033ac29ccb8653d9b', '2018-06-20 12:41:36', 0),
	(10, 'mose', '0705119250', 'mose@gmail.com', '12345', '827ccb0eea8a706c4c34a16891f84e7b', '2018-06-20 19:17:39', 0),
	(11, 'Yk', '0711268164', 'yk@g.com', '1995', '3f088ebeda03513be71d34d214291986', '2018-06-27 08:06:06', 2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
