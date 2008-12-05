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
-- Table structure for table `locale`
--

DROP TABLE IF EXISTS `locale`;
CREATE TABLE `locale` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(16) NOT NULL,
  `display_name` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locale`
--

LOCK TABLES `locale` WRITE;
/*!40000 ALTER TABLE `locale` DISABLE KEYS */;
INSERT INTO `locale` VALUES (1,'en_CA','English (Canada)'),(2,'fr_CA','Fran&ccedil;ais (Canada)'),(3,'ja_JP','Japanese (&#x65e5;&#x672c;&#x8a9e;)'),(4,'ar_OM','Arabic (Oman)\r\n(&#x0627;&#x0644;&#x0639;&#x0631;&#x0628;&#x064a;&#x0629;)'),(5,'el_GR','Greek\r\n(&#x0395;&#x03bb;&#x03bb;&#x03b7;&#x03bd;&#x03b9;&#x03ba;&#x03ac;)'),(6,'ar_SY','Arabic (Syria)\r\n(&#x0627;&#x0644;&#x0639;&#x0631;&#x0628;&#x064a;&#x0629;)'),(7,'id_ID','Bahasa Indonesia'),(8,'bs_BA','Bosanski'),(9,'bg_BG','Bulgarian\r\n(&#x0411;&#x044a;&#x043b;&#x0433;&#x0430;&#x0440;&#x0441;&#x043a;&#x0438;)'),(10,'ca_ES','Catal&agrave;'),(11,'zh_CN','Chinese (Simplified)\r\n(&#x7b80;&#x4f53;&#x4e2d;&#x6587;)'),(12,'zh_TW','Chinese (Traditional)\r\n(&#x6b63;&#x9ad4;&#x4e2d;&#x6587;)'),(13,'cs_CZ','Czech (&#x010c;esky)'),(14,'da_DK','Dansk'),(15,'de_DE','Deutsch'),(16,'en_US','English (American)'),(17,'en_GB','English (British)'),(18,'es_ES','Espa&ntilde;ol'),(19,'et_EE','Eesti'),(20,'gl_ES','Galego'),(21,'he_IL','Hebrew (&#x05E2;&#x05D1;&#x05E8;&#x05D9;&#x05EA;)'),(22,'is_IS','&Iacute;slenska'),(23,'it_IT','Italiano'),(24,'km_KH','Khmer (&#x1781;&#x17d2;&#x1798;&#x17c2;&#x179a;)'),(25,'ko_KR','Korean (&#xd55c;&#xad6d;&#xc5b4;)'),(26,'lv_LV','Latvie&#x0161;u'),(27,'lt_LT','Lietuvi&#x0173;'),(28,'mk_MK','Macedonian\r\n(&#x041c;&#x0430;&#x043a;&#x0435;&#x0434;&#x043e;&#x043d;&#x0441;&#x043a;&#x0438;)'),(29,'hu_HU','Magyar'),(30,'nl_NL','Nederlands'),(31,'nb_NO','Norsk bokm&aring;l'),(32,'nn_NO','Norsk nynorsk'),(33,'fa_IR','Persian (&#x0641;&#x0627;&#x0631;&#x0633;&#x0649;)'),(34,'pl_PL','Polski'),(35,'pt_PT','Portugu&ecirc;s'),(36,'pt_BR','Portugu&ecirc;s Brasileiro'),(37,'ro_RO','Rom&acirc;n&auml;'),(38,'ru_RU','Russian\r\n(&#x0420;&#x0443;&#x0441;&#x0441;&#x043a;&#x0438;&#x0439;)'),(39,'sk_SK','Slovak (Sloven&#x010d;ina)'),(40,'sl_SI','Slovenian (Sloven&#x0161;&#x010d;ina)'),(41,'fi_FI','Suomi'),(42,'sv_SE','Svenska'),(43,'th_TH','Thai (&#x0e44;&#x0e17;&#x0e22;)'),(44,'tr_TR','T&uuml;rk&ccedil;e'),(45,'uk_UA','Ukrainian\r\n(&#x0423;&#x043a;&#x0440;&#x0430;&#x0457;&#x043d;&#x0441;&#x044c;&#x043a;&#x0430;)');
/*!40000 ALTER TABLE `locale` ENABLE KEYS */;
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
