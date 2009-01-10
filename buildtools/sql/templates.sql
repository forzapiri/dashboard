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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` VALUES ('Module_Content','content.tpl','<script type=\"text/javascript\">genFlash(\'/flash/leftCol.swf?pagetitle={$content->getPageTitle()}\', 615, 35, \'\', \'transparent\');</script>\r\n{$content->getContent()}','2008-07-28 20:26:32',1,NULL),('CMS','css/cssMenus.css','','2008-07-29 00:42:33',2,NULL),('CMS','css/style.css','ol {\r\n	list-style-type: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n\r\nfieldset {\r\n	border: none;\r\n	padding-left: 0px;\r\n	margin-left: 0px;\r\n}\r\n','2008-07-29 00:44:53',3,NULL),('Module_Menu','menu_rendertop.tpl','<div id=\"nav\">\r\n	<ul id=\"navUl\">\r\n	{assign var=menuCount value=0}\r\n	{foreach from=$menu item=item}\r\n		{assign var=menuCount value=$menuCount+1}\r\n		{strip}<li><a href=\"{$item->link}\"{if $item->target == \"new\"} target=\"_blank\"{/if}>{$item->display}</a>\r\n		{if $item->children}{assign var=\"children\" value=true}<ul>{else}{assign var=\"children\" value=false}{/if}\r\n		{foreach from=$item->children item=item}\r\n		{assign var=\"depth\" value=1}\r\n		{include file=db:menu_renderitems.tpl menu=item}\r\n		{/foreach}\r\n		{if $children}</ul>{/if}\r\n		</li>\r\n		{if $menuCount < $menu|@count}\r\n			<li class=\"menuDivider\">?</li>\r\n		{/if}{/strip}\r\n		{/foreach}\r\n	</ul>\r\n</div>','2008-07-29 01:43:02',4,NULL),('CMS','site.tpl','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\r\n<meta name=\"keywords\" content=\"{$metaKeywords}\" />\r\n<meta name=\"description\" content=\"{$metaDescription}\" />\r\n<meta name=\"title\" content=\"{$metaTitle}\" />\r\n<title>{$title}</title>\r\n<link rel=\"stylesheet\" href=\"/css/style.css,/css/cssMenus.css{if $css.norm|@count > 0}{foreach from=$css.norm item=cssUrl},{$cssUrl}{/foreach}{/if}\" type=\"text/css\" />\r\n{if $css.print|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.print item=cssUrl}{$cssUrl}{if $css.print|@key < $css.print|@count},{/if}{/foreach}\" type=\"text/css\" media=\"print\" />\r\n{/if}\r\n{if $css.screen|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.screen item=cssUrl}{$cssUrl}{if $css.screen|@key < $css.screen|@count},{/if}{/foreach}\" type=\"text/css\" media=\"screen\" />\r\n{/if}\r\n\r\n<script type=\"text/javascript\" src=\"/js/prototype.js{foreach from=$js item=jsUrl},{$jsUrl}{/foreach}\"></script>\r\n\r\n</head>\r\n\r\n<body>\r\n\r\n<h1>{$title}</h1>\r\n\r\n{module class=\"Menu\"}\r\n	\r\n{if $user}<a href=\"/user/logout\">Logout</a>{else}<a href=\"/user/login\">Login</a>{/if}\r\n\r\n{module class=$module}\r\n\r\n</body>\r\n</html>\r\n','2008-12-23 14:18:02',5,'site'),('CMS','chunks.tpl','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\r\n<meta name=\"keywords\" content=\"{$metaKeywords}\" />\r\n<meta name=\"description\" content=\"{$metaDescription}\" />\r\n<meta name=\"title\" content=\"{$metaTitle}\" />\r\n<title>{$title}</title>\r\n<link rel=\"stylesheet\" href=\"/css/style.css,/css/cssMenus.css{if $css.norm|@count > 0}{foreach from=$css.norm item=cssUrl},{$cssUrl}{/foreach}{/if}\" type=\"text/css\" />\r\n{if $css.print|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.print item=cssUrl}{$cssUrl}{if $css.print|@key < $css.print|@count},{/if}{/foreach}\" type=\"text/css\" media=\"print\" />\r\n{/if}\r\n{if $css.screen|@count > 0}\r\n	<link rel=\"stylesheet\" href=\"{foreach from=$css.screen item=cssUrl}{$cssUrl}{if $css.screen|@key < $css.screen|@count},{/if}{/foreach}\" type=\"text/css\" media=\"screen\" />\r\n{/if}\r\n\r\n<script type=\"text/javascript\" src=\"/js/prototype.js{foreach from=$js item=jsUrl},{$jsUrl}{/foreach}\"></script>\r\n\r\n</head>\r\n\r\n<body>\r\n\r\n<h1>{$title}</h1>\r\n\r\n{module class=\"Menu\"}\r\n{* CHUNK Title: text *}\r\n{* CHUNK First Column: tinymce *}\r\n{* CHUNK Second Column: tinymce *}\r\n{if $user}<a href=\"/user/logout\">Logout</a>{else}<a href=\"/user/login\">Login</a>{/if}\r\n\r\n{module class=$module}\r\n\r\n</body>\r\n</html>\r\n\r\n','2009-01-10 01:09:58',6,'chunks');
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

-- Dump completed on 2009-01-10  1:11:57
