-- MySQL dump 10.11
--
-- Host: localhost    Database: master
-- ------------------------------------------------------
-- Server version	5.0.41-log

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk`
--

LOCK TABLES `chunk` WRITE;
/*!40000 ALTER TABLE `chunk` DISABLE KEYS */;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk_revision`
--

LOCK TABLES `chunk_revision` WRITE;
/*!40000 ALTER TABLE `chunk_revision` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` VALUES ('Module_Content','content.tpl','<script type=\"text/javascript\">genFlash(\'/flash/leftCol.swf?pagetitle={$content->getPageTitle()}\', 615, 35, \'\', \'transparent\');</script>\r\n{$content->getContent()}','2008-07-28 20:26:32',1,NULL),('CMS','css/cssMenus.css','','2008-07-29 00:42:33',2,NULL),('CMS','css/style.css','ol {\r\n	list-style-type: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n\r\nfieldset {\r\n	border: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n','2008-07-29 00:44:53',3,NULL),('Module_Menu','menu_rendertop.tpl','<div id=\"nav\">\r\n	<ul id=\"navUl\">\r\n	{assign var=menuCount value=0}\r\n	{foreach from=$menu item=item}\r\n		{assign var=menuCount value=$menuCount+1}\r\n		{strip}<li><a href=\"{$item->link}\"{if $item->target == \"new\"} target=\"_blank\"{/if}>{$item->display}</a>\r\n		{if $item->children}{assign var=\"children\" value=true}<ul>{else}{assign var=\"children\" value=false}{/if}\r\n		{foreach from=$item->children item=item}\r\n		{assign var=\"depth\" value=1}\r\n		{include file=db:menu_renderitems.tpl menu=item}\r\n		{/foreach}\r\n		{if $children}</ul>{/if}\r\n		</li>\r\n		{if $menuCount < $menu|@count}\r\n			<li class=\"menuDivider\">?</li>\r\n		{/if}{/strip}\r\n		{/foreach}\r\n	</ul>\r\n</div>','2008-07-29 01:43:02',4,NULL),('CMS','site.tpl','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\r\n<meta name=\"keywords\" content=\"{$metaKeywords}\" />\r\n<meta name=\"description\" content=\"{$metaDescription}\" />\r\n<meta name=\"title\" content=\"{$metaTitle}\" />\r\n<title>{$title}</title>\r\n<link rel=\"stylesheet\" href=\"/css/style.css,/css/cssMenus.css{if $css.norm|@count > 0}{foreach from=$css.norm item=cssUrl},{$cssUrl}{/foreach}{/if}\" type=\"text/css\" />\r\n{if $css.print|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.print item=cssUrl}{$cssUrl}{if $css.print|@key < $css.print|@count},{/if}{/foreach}\" type=\"text/css\" media=\"print\" />\r\n{/if}\r\n{if $css.screen|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.screen item=cssUrl}{$cssUrl}{if $css.screen|@key < $css.screen|@count},{/if}{/foreach}\" type=\"text/css\" media=\"screen\" />\r\n{/if}\r\n\r\n<script type=\"text/javascript\" src=\"/js/prototype.js{foreach from=$js item=jsUrl},{$jsUrl}{/foreach}\"></script>\r\n\r\n</head>\r\n\r\n<body>\r\n\r\n<h1>{$title}</h1>\r\n\r\n{module class=\"Menu\"}\r\n	\r\n{if $user}<a href=\"/user/logout\">Logout</a>{else}<a href=\"/user/login\">Login</a>{/if}\r\n\r\n{module class=$module}\r\n\r\n</body>\r\n</html>\r\n','2008-12-23 14:18:02',5,'site'),('CMS','chunks.tpl','{insert_in file=\"db:site.tpl\"}\r\n{$chunks->get(\"Title: type=text\")}\r\n{$chunks->get(\"First Column: type=tinymce; role=col\")}\r\n{$chunks->get(\"Second Column: type=tinymce; preview=h1,p; role=col\")}\r\n{$chunks->get(\"Date: type=date\")}\r\n{/insert_in}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n','2009-01-31 20:46:38',6,'chunks');
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbtable`
--

LOCK TABLES `dbtable` WRITE;
/*!40000 ALTER TABLE `dbtable` DISABLE KEYS */;
INSERT INTO `dbtable` VALUES (1,'chunk','id','','id','hidden'),(2,'chunk','type','DBColumn Type','text',''),(3,'chunk','role','Role','text',''),(4,'chunk','name','Name','text',''),(7,'chunk','sort','Sort','sort',''),(5,'chunk','parent_class','Parent Class','text',''),(6,'chunk','parent','Parent ID','integer',''),(11,'chunk_revision','id','','id','hidden'),(15,'chunk_revision','status','Status','enum(active,draft,inactive)',''),(13,'chunk_revision','content','Content','text',''),(14,'chunk_revision','timestamp','Timestamp','timestamp',''),(12,'chunk_revision','parent','Chunk','integer','');
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content_pages`
--

LOCK TABLES `content_pages` WRITE;
/*!40000 ALTER TABLE `content_pages` DISABLE KEYS */;
INSERT INTO `content_pages` VALUES (1,'Home','2007-12-15 23:23:33',1,'public','home','chunks.tpl');
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

-- Dump completed on 2009-02-06  2:21:48
