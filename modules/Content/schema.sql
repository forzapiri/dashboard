-- MySQL dump 10.11
--
-- Host: localhost    Database: master
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
-- Table structure for table `chunk`
--

DROP TABLE IF EXISTS `chunk`;
CREATE TABLE `chunk` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` varchar(256) default NULL,
  `role` varchar(256) default NULL,
  `name` varchar(256) default NULL,
  `parent_class` varchar(256) default NULL,
  `parent` int(11) default NULL,
  `sort` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk`
--

LOCK TABLES `chunk` WRITE;
/*!40000 ALTER TABLE `chunk` DISABLE KEYS */;
INSERT INTO `chunk` VALUES (28,'text',NULL,NULL,'ContentPage',2,0),(29,'tinymce','col','test1','ContentPage',2,1),(30,'tinymce','col',NULL,'ContentPage',2,2),(31,'date',NULL,NULL,'ContentPage',2,3),(32,'tinymce','col','test1',NULL,NULL,NULL),(57,'text',NULL,NULL,'ContentPage',4,0),(58,'tinymce','col','test1','ContentPage',4,1),(59,'tinymce','col','','ContentPage',4,2),(60,'date',NULL,NULL,'ContentPage',4,3),(67,'tinymce','col','test1','ContentPage',6,2),(66,'tinymce','col','','ContentPage',6,1),(65,'text',NULL,NULL,'ContentPage',6,0),(68,'date',NULL,NULL,'ContentPage',6,3),(69,'text',NULL,NULL,'ContentPage',7,0),(70,'tinymce','col','test1','ContentPage',7,1),(71,'tinymce','col','','ContentPage',7,2),(72,'date',NULL,NULL,'ContentPage',7,3),(73,'text',NULL,NULL,'ContentPage',8,0),(74,'tinymce','col','test1','ContentPage',8,1),(75,'tinymce','col','','ContentPage',8,2),(76,'date',NULL,NULL,'ContentPage',8,3),(77,'text',NULL,NULL,'ContentPage',9,0),(78,'tinymce','col','','ContentPage',9,1),(79,'tinymce','col','','ContentPage',9,2),(80,'date',NULL,NULL,'ContentPage',9,3),(81,'text',NULL,NULL,'ContentPage',10,0),(82,'tinymce','col','test1','ContentPage',10,1),(83,'tinymce','col','test1','ContentPage',10,2),(84,'date',NULL,NULL,'ContentPage',10,3);
/*!40000 ALTER TABLE `chunk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chunk_revision`
--

DROP TABLE IF EXISTS `chunk_revision`;
CREATE TABLE `chunk_revision` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(11) default NULL,
  `content` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` enum('active','draft','inactive') default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk_revision`
--

LOCK TABLES `chunk_revision` WRITE;
/*!40000 ALTER TABLE `chunk_revision` DISABLE KEYS */;
INSERT INTO `chunk_revision` VALUES (46,31,'Word of Mouth','2009-01-12 17:28:05',NULL),(99,32,'<p>test</p>','2009-01-31 21:27:28','active'),(100,31,'2007-12-31 00:00:00','2009-01-31 21:27:28',NULL),(101,30,'<p>test2</p>','2009-01-31 21:28:12','active'),(102,31,'2009-02-18 00:00:00','2009-01-31 21:29:13','active'),(103,57,'Test of b','2009-02-02 15:38:40','active'),(104,58,'<p>Test of b<br mce_bogus=\"1\"></p>','2009-02-02 15:38:40',NULL),(105,59,'<h1>Title</h1>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus</p>','2009-02-02 15:38:40','active'),(106,60,'2009-02-02 00:00:00','2009-02-02 15:38:40','active'),(107,58,'<p>qwerqwerqwer</p>','2009-02-02 18:04:35',NULL),(108,58,'<p>qwerqwerqwerbfghhfg</p>','2009-02-02 18:09:13','active'),(54,28,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices mauris augue non arcu. Donec et sem nec libero viverra accumsan.','2009-01-12 17:41:20','active'),(55,32,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices mauris augue non arcu. Donec et sem nec libero viverra accumsan.','2009-01-12 17:41:20',NULL),(56,30,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices mauris augue non arcu. Donec et sem nec libero viverra accumsan.','2009-01-12 17:41:20',NULL),(135,82,'<p>test first column</p>','2009-02-02 21:07:19','active'),(134,82,'<p>test89</p>','2009-02-02 20:44:05','active'),(133,83,'<h1>Title8</h1>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus 888<br></p>','2009-02-02 20:43:52','active'),(129,81,'test8 title','2009-02-02 20:15:49','active'),(130,82,'Test','2009-02-02 20:15:49','active'),(131,83,'<h1>Title8</h1>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus 8<br></p>','2009-02-02 20:15:49','inactive'),(132,84,'2009-02-02 00:00:00','2009-02-02 20:15:49','active');
/*!40000 ALTER TABLE `chunk_revision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
CREATE TABLE `templates` (
  `module` varchar(32) NOT NULL default '',
  `path` varchar(64) NOT NULL,
  `data` longtext NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(64) default NULL,
  PRIMARY KEY  (`id`),
  KEY `path` (`path`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` VALUES ('Module_Content','content.tpl','<script type=\"text/javascript\">genFlash(\'/flash/leftCol.swf?pagetitle={$content->getPageTitle()}\', 615, 35, \'\', \'transparent\');</script>\r\n{$content->getContent()}','2008-07-28 20:26:32',1,NULL),('CMS','css/cssMenus.css','','2008-07-29 00:42:33',2,NULL),('CMS','css/style.css','ol {\r\n	list-style-type: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n\r\nfieldset {\r\n	border: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n','2008-07-29 00:44:53',3,NULL),('Module_Menu','menu_rendertop.tpl','<div id=\"nav\">\r\n	<ul id=\"navUl\">\r\n	{assign var=menuCount value=0}\r\n	{foreach from=$menu item=item}\r\n		{assign var=menuCount value=$menuCount+1}\r\n		{strip}<li><a href=\"{$item->link}\"{if $item->target == \"new\"} target=\"_blank\"{/if}>{$item->display}</a>\r\n		{if $item->children}{assign var=\"children\" value=true}<ul>{else}{assign var=\"children\" value=false}{/if}\r\n		{foreach from=$item->children item=item}\r\n		{assign var=\"depth\" value=1}\r\n		{include file=db:menu_renderitems.tpl menu=item}\r\n		{/foreach}\r\n		{if $children}</ul>{/if}\r\n		</li>\r\n		{if $menuCount < $menu|@count}\r\n			<li class=\"menuDivider\">?</li>\r\n		{/if}{/strip}\r\n		{/foreach}\r\n	</ul>\r\n</div>','2008-07-29 01:43:02',4,NULL),('CMS','site.tpl','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\r\n<meta name=\"keywords\" content=\"{$metaKeywords}\" />\r\n<meta name=\"description\" content=\"{$metaDescription}\" />\r\n<meta name=\"title\" content=\"{$metaTitle}\" />\r\n<title>{$title}</title>\r\n<link rel=\"stylesheet\" href=\"/css/style.css,/css/cssMenus.css{if $css.norm|@count > 0}{foreach from=$css.norm item=cssUrl},{$cssUrl}{/foreach}{/if}\" type=\"text/css\" />\r\n{if $css.print|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.print item=cssUrl}{$cssUrl}{if $css.print|@key < $css.print|@count},{/if}{/foreach}\" type=\"text/css\" media=\"print\" />\r\n{/if}\r\n{if $css.screen|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.screen item=cssUrl}{$cssUrl}{if $css.screen|@key < $css.screen|@count},{/if}{/foreach}\" type=\"text/css\" media=\"screen\" />\r\n{/if}\r\n\r\n<script type=\"text/javascript\" src=\"/js/prototype.js{foreach from=$js item=jsUrl},{$jsUrl}{/foreach}\"></script>\r\n\r\n</head>\r\n\r\n<body>\r\n\r\n<h1>{$title}</h1>\r\n\r\n{module class=\"Menu\"}\r\n	\r\n{if $user}<a href=\"/user/logout\">Logout</a>{else}<a href=\"/user/login\">Login</a>{/if}\r\n\r\n{module class=$module}\r\n\r\n</body>\r\n</html>\r\n','2008-12-23 14:18:02',5,'site'),('CMS','chunks.tpl','{insert_in file=\"db:site.tpl\"}\r\n{$chunks->get(\"Title: type=text\")}\r\n{$chunks->get(\"First Column: type=tinymce; role=col\")}\r\n{$chunks->get(\"Second Column: type=tinymce; preview=h1,p; role=col\")}\r\n{$chunks->get(\"Date: type=date\")}\r\n{/insert_in}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n','2009-01-31 20:46:38',22,'chunks'),('CMS','chunks.tpl','{insert_in file=\"db:site.tpl\"}\r\n{$chunks->get(\"Title: type=text\")}\r\n{$chunks->get(\"First Column: type=tinymce; role=col1\")}\r\n{$chunks->get(\"Second Column: type=tinymce; preview=h1,p; role=service\")}\r\n{$chunks->get(\"Date: type=date\")}\r\n{/insert_in}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n','2009-01-31 20:45:34',21,'chunks'),('CMS','chunks.tpl','{insert_in file=\"db:site.tpl\"}\r\n{$chunks->get(\"Title: type=text\")}\r\n{$chunks->get(\"First Column: type=tinymce; role=col1\")\r\n{$chunks->get(\"Second Column: type=tinymce; preview=h1,p; role=service\")}\r\n{$chunks->get(\"Date: type=date\")}\r\n{/insert_in}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n','2009-01-31 18:32:46',20,'chunks');
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbtable`
--

DROP TABLE IF EXISTS `dbtable`;
CREATE TABLE `dbtable` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(50) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `modifier` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbtable`
--

LOCK TABLES `dbtable` WRITE;
/*!40000 ALTER TABLE `dbtable` DISABLE KEYS */;
INSERT INTO `dbtable` VALUES (81,'chunk','id','','id','hidden'),(84,'chunk','type','DBColumn Type','text',''),(87,'chunk','role','Role','text',''),(88,'chunk','name','Name','text',''),(100,'chunk','sort','Sort','sort',''),(90,'chunk','parent_class','Parent Class','text',''),(91,'chunk','parent','Parent ID','integer',''),(94,'chunk_revision','id','','id','hidden'),(105,'chunk_revision','status','Status','enum(active,draft,inactive)',''),(96,'chunk_revision','content','Content','text',''),(97,'chunk_revision','timestamp','Timestamp','timestamp',''),(95,'chunk_revision','parent','Chunk','integer','');
/*!40000 ALTER TABLE `dbtable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_pages`
--

DROP TABLE IF EXISTS `content_pages`;
CREATE TABLE `content_pages` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  `access` varchar(64) NOT NULL default 'public',
  `url_key` varchar(32) NOT NULL,
  `page_template` varchar(128) default 'site.tpl',
  PRIMARY KEY  (`id`),
  KEY `page_name` (`name`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content_pages`
--

LOCK TABLES `content_pages` WRITE;
/*!40000 ALTER TABLE `content_pages` DISABLE KEYS */;
INSERT INTO `content_pages` VALUES (1,'Home','2007-12-15 23:23:33',1,'public','home','site.tpl'),(2,'Chunk','2009-01-31 18:25:49',1,'public','chunk','chunks.tpl'),(3,'New normal page','2009-02-02 15:36:32',0,'public','a','site.tpl'),(4,'New chunk page','2009-02-02 15:36:41',0,'public','b','chunks.tpl'),(10,'test8','2009-02-02 20:15:31',0,'public','test8','chunks.tpl');
/*!40000 ALTER TABLE `content_pages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-02-03  0:03:05
