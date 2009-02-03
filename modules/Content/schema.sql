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
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk`
--

LOCK TABLES `chunk` WRITE;
/*!40000 ALTER TABLE `chunk` DISABLE KEYS */;
INSERT INTO `chunk` VALUES (85,'text',NULL,NULL,'ContentPage',11,0),(86,'tinymce','col','named chunk','ContentPage',11,1),(87,'tinymce','col','named chunk',NULL,NULL,NULL),(88,'tinymce','col','','ContentPage',11,2),(89,'date',NULL,NULL,'ContentPage',11,3),(90,'text',NULL,NULL,'ContentPage',12,0),(91,'tinymce','col','','ContentPage',12,1),(92,'tinymce','col','','ContentPage',12,2),(93,'date',NULL,NULL,'ContentPage',12,3),(94,'text',NULL,NULL,'ContentPage',13,0),(95,'tinymce','col','','ContentPage',13,1),(96,'tinymce','col','named chunk','ContentPage',13,2),(97,'date',NULL,NULL,'ContentPage',13,3);
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
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk_revision`
--

LOCK TABLES `chunk_revision` WRITE;
/*!40000 ALTER TABLE `chunk_revision` DISABLE KEYS */;
INSERT INTO `chunk_revision` VALUES (136,85,'This is the title','2009-02-03 01:22:57','active'),(137,87,'<p>This is a named chunk which can be reused<br mce_bogus=\"1\"></p>','2009-02-03 01:22:57','active'),(138,86,'<p>This is a named chunk which can be reused<br mce_bogus=\"1\"></p>','2009-02-03 01:22:57','active'),(139,88,'<h1>Title2</h1>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus</p>','2009-02-03 01:22:57','active'),(140,89,'2009-01-02 00:00:00','2009-02-03 01:22:57','active'),(141,90,'Title 2','2009-02-03 01:25:34','active'),(142,91,'<p>Content 2<br mce_bogus=\"1\"></p>','2009-02-03 01:25:35','active'),(143,92,'<h1>Title of chunk 2<br></h1>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus</p>','2009-02-03 01:25:35','active'),(144,93,'2009-03-02 00:00:00','2009-02-03 01:25:35','active'),(145,94,'','2009-02-03 01:26:10','active'),(146,95,'<p>test 3<br mce_bogus=\"1\"></p>','2009-02-03 01:26:10','active'),(147,96,'<h1>Title</h1>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus</p>','2009-02-03 01:26:10','active'),(148,97,'2009-02-02 00:00:00','2009-02-03 01:26:10','active');
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content_pages`
--

LOCK TABLES `content_pages` WRITE;
/*!40000 ALTER TABLE `content_pages` DISABLE KEYS */;
INSERT INTO `content_pages` VALUES (1,'Home','2007-12-15 23:23:33',1,'public','home','site.tpl'),(11,'Chunk Test','2009-02-03 01:22:24',1,'public','chunk','chunks.tpl'),(12,'Chunk test 2','2009-02-03 01:25:00',1,'public','chunk2','chunks.tpl'),(13,'Chunk 3','2009-02-03 01:25:49',1,'public','chunk3','chunks.tpl');
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

-- Dump completed on 2009-02-03  1:39:17
