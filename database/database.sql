-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for mulu
CREATE DATABASE IF NOT EXISTS `mulu` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mulu`;


-- Dumping structure for table mulu.zipcodes
DROP TABLE IF EXISTS `zipcodes`;
CREATE TABLE IF NOT EXISTS `zipcodes` (
  `idContact` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(15) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `agentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`idContact`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Dumping data for table mulu.zipcodes: ~38 rows (approximately)
/*!40000 ALTER TABLE `zipcodes` DISABLE KEYS */;
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(1, 'Michael', '85273', 46.8755, -2.00786, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(2, 'James', '85750', 32.2992, -110.843, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(3, 'Brian', '85751', 32.2506, -110.855, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(4, 'Nicholas', '85383', 33.7868, -112.286, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(5, 'Jennifer', '85716', 32.2479, -110.921, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(6, 'Christopher', '85014', 33.5083, -112.057, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(7, 'Patricia', '95032', 37.2261, -121.93, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(8, 'Beth', '94556', 37.8357, -122.118, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(9, 'Cathy', '92260', 33.6917, -116.408, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(10, 'Harold', '92120', 32.7926, -117.074, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(11, 'Robin', '94062', 37.4109, -122.288, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(12, 'James', '90503', 33.841, -118.352, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(13, 'Douglas', '32159', 28.9178, -81.888, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(14, 'Donald', '32404', 30.1974, -85.4994, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(15, 'Ilene', '33140', 25.8177, -80.1373, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(16, 'William', '33417', 26.7169, -80.1261, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(17, 'Lynn', '32789', 28.5951, -81.3509, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(18, 'Katherine', '32034', 30.5945, -81.4938, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(19, 'Melissa', '30516', 34.3887, -83.0469, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(20, 'Kimberly', '30345', 33.8484, -84.2858, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(21, 'Richard', '30606', 33.9448, -83.4323, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(22, 'Richard', '30312', 33.7441, -84.3779, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(23, 'Ayn', '31901', 32.466, -84.987, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(24, 'Bruce', '31410', 32.0005, -80.9761, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(25, 'Fred', '89451', 39.2355, -119.939, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(26, 'Robert', '89110', 36.1679, -115.041, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(27, 'David', '89042', 37.753, -114.287, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(28, 'Maureen', '89074', 36.0376, -115.076, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(29, 'Mary Sue', '89705', 39.0716, -119.847, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(30, 'Janet', '89144', 36.178, -115.313, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(31, 'John', '89145', 36.1683, -115.266, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(32, 'Rand', '12580', 41.8615, -73.8537, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(33, 'Kathy', '10604', 41.0604, -73.7419, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(34, 'Susan', '13601', 43.996, -75.9231, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(35, 'Robin', '10021', 40.7701, -73.958, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(36, 'Peter', '12550', 41.5306, -74.0535, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(37, 'Diana', '10603', 41.0557, -73.7772, NULL);
REPLACE INTO `zipcodes` (`idContact`, `name`, `code`, `lat`, `lng`, `agentId`) VALUES
	(38, 'Richard', '12018', 42.613, -73.5359, NULL);
/*!40000 ALTER TABLE `zipcodes` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
