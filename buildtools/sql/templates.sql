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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` VALUES ('Module_Content','content.tpl','<script type=\"text/javascript\">genFlash(\'/flash/leftCol.swf?pagetitle={$content->getPageTitle()}\', 615, 35, \'\', \'transparent\');</script>\r\n{$content->getContent()}','2008-07-28 20:26:32',1,NULL),('CMS','css/cssMenus.css','','2008-07-29 00:42:33',2,NULL),('CMS','css/style.css','ol {\r\n	list-style-type: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n\r\nfieldset {\r\n	border: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n','2008-07-29 00:44:53',3,NULL),('Module_Menu','menu_rendertop.tpl','<div id=\"nav\">\n  <ul id=\"navUl\">\n	{assign var=menuCount value=0}\n	{foreach from=$menu item=item}\n	{assign var=menuCount value=$menuCount+1}\n	{strip}<li><a href=\"{$item->getLinkTarget()}\"{if $item->get(\'target\') == \"new\"} target=\"_blank\"{/if}>{$item->get(\'display\')}</a>\n	  {if $item->children}\n	  <ul>\n		{foreach from=$item->children item=item}\n		{assign var=\"depth\" value=1}\n		{include file=db:menu_renderitem.tpl menu=item}\n		{/foreach}\n	  </ul>\n	  {/if}\n	</li>\n	{/strip}\n	{/foreach}\n  </ul>\n</div>\n','2009-02-23 10:39:04',4,''),('Module_Menu','menu_renderitem.tpl','{*\n<li><a href=\"{$item->getLinkTarget()}\" style=\"padding-left: {math equation=\"x * 10\" x=$depth}px!important;\"{if $item->getTarget() == \"new\"} target=\"_blank\"{/if}>{$item->getDisplay()}</a></li>\n*}\n<li><a href=\"{$item->getLinkTarget()}\"{if $item->getTarget() == \"new\"} target=\"_blank\"{/if}>{$item->getDisplay()}</a></li>\n{if $item->children}\n<ul>\n{foreach from=$item->children item=item}\n	{include file=db:menu_renderitem.tpl menu=item depth=$depth+1}\n{/foreach}\n</ul>\n{/if}\n','2009-03-24 20:06:20',8,''),('CMS','site.tpl','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\r\n<meta name=\"keywords\" content=\"{$metaKeywords}\" />\r\n<meta name=\"description\" content=\"{$metaDescription}\" />\r\n<meta name=\"title\" content=\"{$metaTitle}\" />\r\n<title>{$title}</title>\r\n{stylesheets}{javascripts}\r\n\r\n</head>\r\n\r\n<body>\r\n\r\n<h1>{$title}</h1>\r\n\r\n{module class=\"Menu\"}\r\n	\r\n{if $user}<a href=\"/user/logout\">Logout</a>{else}<a href=\"/user/login\">Login</a>{/if}\r\n\r\n{module class=$module}\r\n\r\n</body>\r\n</html>\r\n','2008-12-23 14:18:02',5,'site'),('CMS','chunks.tpl','{insert_in file=\"db:site.tpl\"}\r\n{$chunks->get(\"Title: type=text\")}\r\n{$chunks->get(\"First Column: type=tinymce; role=col\")}\r\n{$chunks->get(\"Second Column: type=tinymce; preview=h1,p; role=col\")}\r\n{$chunks->get(\"Date: type=date\")}\r\n{/insert_in}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n','2009-01-31 20:46:38',6,'chunks'),('CMS','splash.tpl','','2009-03-24 20:04:49',7,'Splash Page');
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-03-24 20:08:21
