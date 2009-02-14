-- MySQL dump 10.11
--
-- Host: localhost    Database: trunk2
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
-- Table structure for table `config_options`
--

DROP TABLE IF EXISTS `config_options`;
CREATE TABLE `config_options` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `module` varchar(100) default NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `type` varchar(1000) default 'string',
  `value` varchar(10000) default '',
  `sort` int(11) NOT NULL default '10',
  `editable` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` USING HASH (`name`,`module`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config_options`
--

LOCK TABLES `config_options` WRITE;
/*!40000 ALTER TABLE `config_options` DISABLE KEYS */;
INSERT INTO `config_options` VALUES
(1,'Content','defaultPageTitle','Default Page Title','string','Edit Page Title Using Site Config',0,'1'),
(2,'Blog','frontPage','Blogs to show on Front Page (list of user ids)','list','1',10,'1'),
(3,'Blog','feedTitle','Title of RSS Feed','string','Green Party of Nova Scotia',10,'1'),
(4,'Calendar','frontPage','Calendar ID to show as main calendar','string','1',10,'0'),
(5,NULL,'linkables','Linkable modules','list','Content',0,'0'),
(6,'Content','defaultPage','Sets default page fallback','string','Home',0,'0'),
(9,NULL,'CMSname','Appears in admin titlebar','string','Norex Core Web Development',0,'0'),
(10,'Content','restrictedPages','Are some pages restricted to certain users?','enum(true,false)','false',0,'0'),
(11,'Menu','minimumNumber','Minimum number of menus','int','1',0,'0'),
(12,'Menu','maximumNumber','Maximum number of menus','int','3',0,'0'),
(13,'Menu','numberWithSubmenus','Number of main menus which have submenus','int','1',0,'0'),
(14,'Menu','templates','Templates which are selectable by the Client','list','menu_rendertop',0,'0'),
(15,NULL,'modules','Active modules in display order','list','Content, Menu, User, Block, Analytics',0,'0'),
(16,NULL,'cachedModules','Modules with static pages which depend only on get params','list','Content',0,'0'),
(17,NULL,'live','Set true to make site live','enum(live,)','',0,'0');
/*!40000 ALTER TABLE `config_options` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-01-02 15:35:07
