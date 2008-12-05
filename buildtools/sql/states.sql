-- MySQL dump 10.11
--
-- Host: localhost    Database: trunk
-- ------------------------------------------------------
-- Server version	5.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL default '0',
  `country` int(10) unsigned NOT NULL default '0',
  `code` varchar(5) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (72,31,'NU','Nunavut'),(1,31,'AB','Alberta'),(2,31,'BC','British Columbia'),(3,31,'MB','Manitoba'),(4,31,'NB','New Brunswick'),(5,31,'NF','Newfoundland'),(6,31,'NT','Northwest Territories'),(7,31,'NS','Nova Scotia'),(8,31,'ON','Ontario'),(9,31,'PE','Prince Edward Island'),(10,31,'QC','Quebec'),(11,31,'SK','Saskatchewan'),(12,31,'YT','Yukon'),(13,184,'AL','Alabama'),(14,184,'AK','Alaska'),(15,184,'AS','American Samoa'),(16,184,'AZ','Arizona'),(17,184,'AR','Arkansas'),(18,184,'CA','California'),(19,184,'CO','Colorado'),(20,184,'CT','Connecticut'),(21,184,'DE','Delaware'),(22,184,'DC','District of Columbia'),(23,184,'FM','Fed. States of Micronesia'),(24,184,'FL','Florida'),(25,184,'GA','Georgia'),(26,184,'GU','Guam'),(27,184,'HI','Hawaii'),(28,184,'ID','Idaho'),(29,184,'IL','Illinois'),(30,184,'IN','Indiana'),(31,184,'IA','Iowa'),(32,184,'KS','Kansas'),(33,184,'KY','Kentucky'),(34,184,'LA','Louisiana'),(35,184,'ME','Maine'),(36,184,'MH','Marshall Islands'),(37,184,'MD','Maryland'),(38,184,'MA','Massachusetts'),(39,184,'MI','Michigan'),(40,184,'MN','Minnesota'),(41,184,'MS','Mississippi'),(42,184,'MO','Missouri'),(43,184,'MT','Montana'),(44,184,'NE','Nebraska'),(45,184,'NV','Nevada'),(46,184,'NH','New Hampshire'),(47,184,'NJ','New Jersey'),(48,184,'NM','New Mexico'),(49,184,'NY','New York'),(50,184,'NC','North Carolina'),(51,184,'ND','North Dakota'),(52,184,'MP','Northern Mariana Is.'),(53,184,'OH','Ohio'),(54,184,'OK','Oklahoma'),(55,184,'OR','Oregon'),(56,184,'PW','Palau'),(57,184,'PA','Pennsylvania'),(58,184,'PR','Puerto Rico'),(59,184,'RI','Rhode Island'),(60,184,'SC','South Carolina'),(61,184,'SD','South Dakota'),(62,184,'TN','Tennessee'),(63,184,'TX','Texas'),(64,184,'UT','Utah'),(65,184,'VT','Vermont'),(66,184,'VA','Virginia'),(67,184,'VI','Virgin Islands'),(68,184,'WA','Washington'),(69,184,'WV','West Virginia'),(70,184,'WI','Wisconsin'),(71,184,'WY','Wyoming');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-10-09 14:50:46
