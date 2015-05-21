# SQL Manager Lite for MySQL 5.4.3.43929
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : olapictest


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `olapictest`
    CHARACTER SET 'latin1'
    COLLATE 'latin1_spanish_ci';

USE `olapictest`;

#
# Structure for the `media_elements` table : 
#

CREATE TABLE `media_elements` (
  `id` VARCHAR(50) COLLATE latin1_spanish_ci NOT NULL,
  `timeout` DATETIME DEFAULT '0000-00-00 00:00:00',
  `lat` DOUBLE(15,6) DEFAULT NULL,
  `long` DOUBLE(15,6) DEFAULT NULL,
  `contry` VARCHAR(80) COLLATE latin1_spanish_ci DEFAULT NULL,
  `state` VARCHAR(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `place` VARCHAR(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `fclname` VARCHAR(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY USING BTREE (`id`) COMMENT ''
)ENGINE=InnoDB
CHARACTER SET 'latin1' COLLATE 'latin1_spanish_ci'
COMMENT=''
;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
