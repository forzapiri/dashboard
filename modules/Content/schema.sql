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
-- Table structure for table `content_page_data`
--

DROP TABLE IF EXISTS `content_page_data`;
CREATE TABLE `content_page_data` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `locale_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL default '0',
  `page_title` text NOT NULL,
  `meta_title` varchar(64) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` varchar(128) NOT NULL,
  `page_template` varchar(128) default 'site.tpl',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content_page_data`
--

LOCK TABLES `content_page_data` WRITE;
/*!40000 ALTER TABLE `content_page_data` DISABLE KEYS */;
INSERT INTO `content_page_data` VALUES (8,2,'<p>Etiam quis felis dictum sem commodo sagittis. Curabitur vel nisi eget ante tincidunt condimentum. Cras sit amet quam a ante malesuada pulvinar. Curabitur adipiscing pede sed tellus. Aliquam ullamcorper magna sit amet libero. Donec suscipit ipsum nec pede. Quisque placerat lorem sed nibh. Sed quam mauris, pellentesque ac, pulvinar ut, pellentesque sed, neque. Sed vel ligula a ante venenatis dignissim. Ut in sapien. Morbi convallis orci vitae tellus.</p>\r\n<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed aliquam nisi non lectus. Praesent dapibus magna pretium magna. Fusce et dolor nec purus volutpat malesuada. Nullam eu nisi a velit feugiat egestas. Nulla id lectus. Mauris auctor tortor ut mi. Sed quam. Nunc dui elit, sagittis et, iaculis vel, pellentesque vel, augue. Mauris gravida. Curabitur in arcu.</p>\r\n<p>Curabitur bibendum velit eu diam. Vivamus viverra libero a elit. Nullam tempor. Proin diam. Donec vitae dui nec est placerat hendrerit. Duis at magna sit amet diam sollicitudin malesuada. In hac habitasse platea dictumst. Sed pulvinar. Etiam turpis eros, hendrerit non, faucibus non, euismod et, velit. Nulla aliquet sodales lectus. Nam sit amet nibh eu mi rhoncus luctus. Cras sodales lacinia neque. Sed congue est eu metus. Nunc ante urna, fermentum sit amet, mollis et, posuere vitae, pede.</p>',0,'2008-11-21 21:47:21',0,'This is a test page','','','','site_no_blogs.tpl'),(6,1,'<p>Lorem ipsum <strong>dolor</strong> sit amet, consectetuer adipiscing elit. Mauris ultricies. Vivamus vel ante. Mauris ut leo. Curabitur ac risus i<a href=\\\"/file/13\\\">n quam iaculis e</a>uismod. Praesent at felis. Phasellus in quam. Quisque laoreet leo venenatis erat tempor adipiscing. Cras dolor. Aenean ligula turpis, viverra eget, aliquet blandit, sodales sit amet, ligula. Maecenas bibendum euismod tortor. Phasellus aliquet augue in enim. Morbi id mi. Sed lacus. Vivamus consequat.</p>\n<p>Nullam aliquam dolor vitae odio. Donec vulputate varius turpis. Sed mollis consectetuer erat. Nulla non quam. Duis ac lorem. Aenean eu nisi id nisl suscipit pellentesque. Aenean aliquam elit eget nulla. Nunc porttitor ultricies velit. Nam sed massa. Mauris sit amet nisl. Aenean justo eros, laoreet id, sollicitudin vel, aliquam in, tortor. Praesent ornare. Nam imperdiet luctus tortor. Donec lobortis. Ut sodales, metus eu cursus egestas, nunc lacus vulputate lorem, non lacinia elit sem bibendum nulla. Curabitur dolor urna, eleifend semper, dictum eget, pulvinar vitae, nisi. Morbi lacinia.</p>\n<p>Praesent pharetra, urna non egestas ultricies, tellus ligula consectetuer nisl, eu adipiscing eros ante nec enim. Mauris ut metus vitae tellus blandit malesuada. Praesent hendrerit dui. Quisque tristique magna in urna. Phasellus tellus purus, euismod sed, porttitor eget, tempor et, purus. Quisque sed orci. Etiam nec ligula sit amet risus vulputate ultrices. Fusce a orci. Sed libero nisi, iaculis nec, mattis vel, malesuada vel, arcu. Sed et ante sit amet velit ultrices pulvinar. Quisque eget magna ut ligula fringilla consectetuer. Vestibulum lectus.</p>\n<p>In nibh elit, tristique sed, semper vitae, eleifend sit amet, leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tortor. Fusce tortor metus, pretium sit amet, ornare imperdiet, vestibulum sit amet, erat. Nam dui. Suspendisse at felis vitae lectus congue hendrerit. Donec dictum neque in tortor eleifend placerat. Integer volutpat eros vitae felis. Integer porta pede sed libero. Nullam velit augue, consequat vel, vestibulum quis, egestas feugiat, erat. Phasellus quis mauris. Sed tincidunt imperdiet ipsum. Morbi aliquam, augue sed viverra mollis, quam neque vehicula pede, nec luctus enim magna at sem. Curabitur pharetra ante eleifend velit. Etiam eu est.</p>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. In eu mauris! Curabitur fermentum, lectus nec aliquet vehicula, mauris quam accumsan sapien, in sollicitudin erat mi sit amet purus. Phasellus pretium neque sollicitudin tellus. Sed in est. Morbi ac sem. Quisque ornare iaculis sapien. Donec eleifend aliquet nisl. Fusce dapibus ipsum nec metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas malesuada nibh id turpis. Aliquam erat volutpat. Etiam aliquet volutpat justo. Etiam at tortor.<br /> <br /> Donec a est. Nulla vitae mi. Fusce vehicula turpis eget mauris sodales pellentesque? Donec tempor! Aliquam malesuada urna sit amet purus. Duis quis purus ut est sollicitudin semper. Maecenas erat nisi, luctus sit amet, rutrum ac, malesuada ac; arcu? Donec at lacus. Duis ac eros vitae pede adipiscing placerat? Sed id nunc. Fusce justo eros, vehicula ac; elementum non, tristique eu, ligula. Etiam non sem quis neque placerat molestie. Mauris commodo purus eget pede.<br /> <br /> Aliquam ornare orci ut nulla. Integer in mauris. Vivamus erat. Pellentesque in eros. Curabitur eleifend metus et felis. Maecenas varius ante non enim. Aenean mollis ipsum id nisi. In iaculis. Nulla quis pede? In nisi? Praesent gravida, quam eu tincidunt lacinia, pede lacus scelerisque justo; et rutrum dolor eros id lorem. Quisque blandit rutrum mi. In hac habitasse platea dictumst. Donec eleifend pede quis nisi. Nam lectus ante, dapibus eget; molestie sit amet, pulvinar vitae, diam. Quisque nec leo et sapien sodales sollicitudin. Maecenas et mauris et erat viverra adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam varius rutrum eros.</p>',0,'2008-11-21 20:23:12',0,'The Green Party of Nova Scotia','','','','site_no_blogs.tpl'),(7,1,'<p>Lorem ipsum <strong>dolor</strong> sit amet, consectetuer adipiscing elit. Mauris ultricies. Vivamus vel ante. Mauris ut leo. Curabitur ac risus i<a href=\\\"/file/13\\\">n quam iaculis e</a>uismod. Praesent at felis. Phasellus in quam. Quisque laoreet leo venenatis erat tempor adipiscing. Cras dolor. Aenean ligula turpis, viverra eget, aliquet blandit, sodales sit amet, ligula. Maecenas bibendum euismod tortor. Phasellus aliquet augue in enim. Morbi id mi. Sed lacus. Vivamus consequat.</p>\n<p>Nullam aliquam dolor vitae odio. Donec vulputate varius turpis. Sed mollis consectetuer erat. Nulla non quam. Duis ac lorem. Aenean eu nisi id nisl suscipit pellentesque. Aenean aliquam elit eget nulla. Nunc porttitor ultricies velit. Nam sed massa. Mauris sit amet nisl. Aenean justo eros, laoreet id, sollicitudin vel, aliquam in, tortor. Praesent ornare. Nam imperdiet luctus tortor. Donec lobortis. Ut sodales, metus eu cursus egestas, nunc lacus vulputate lorem, non lacinia elit sem bibendum nulla. Curabitur dolor urna, eleifend semper, dictum eget, pulvinar vitae, nisi. Morbi lacinia.</p>\n<p>Praesent pharetra, urna non egestas ultricies, tellus ligula consectetuer nisl, eu adipiscing eros ante nec enim. Mauris ut metus vitae tellus blandit malesuada. Praesent hendrerit dui. Quisque tristique magna in urna. Phasellus tellus purus, euismod sed, porttitor eget, tempor et, purus. Quisque sed orci. Etiam nec ligula sit amet risus vulputate ultrices. Fusce a orci. Sed libero nisi, iaculis nec, mattis vel, malesuada vel, arcu. Sed et ante sit amet velit ultrices pulvinar. Quisque eget magna ut ligula fringilla consectetuer. Vestibulum lectus.</p>\n<p>In nibh elit, tristique sed, semper vitae, eleifend sit amet, leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tortor. Fusce tortor metus, pretium sit amet, ornare imperdiet, vestibulum sit amet, erat. Nam dui. Suspendisse at felis vitae lectus congue hendrerit. Donec dictum neque in tortor eleifend placerat. Integer volutpat eros vitae felis. Integer porta pede sed libero. Nullam velit augue, consequat vel, vestibulum quis, egestas feugiat, erat. Phasellus quis mauris. Sed tincidunt imperdiet ipsum. Morbi aliquam, augue sed viverra mollis, quam neque vehicula pede, nec luctus enim magna at sem. Curabitur pharetra ante eleifend velit. Etiam eu est.</p>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. In eu mauris! Curabitur fermentum, lectus nec aliquet vehicula, mauris quam accumsan sapien, in sollicitudin erat mi sit amet purus. Phasellus pretium neque sollicitudin tellus. Sed in est. Morbi ac sem. Quisque ornare iaculis sapien. Donec eleifend aliquet nisl. Fusce dapibus ipsum nec metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas malesuada nibh id turpis. Aliquam erat volutpat. Etiam aliquet volutpat justo. Etiam at tortor.<br /> <br /> Donec a est. Nulla vitae mi. Fusce vehicula turpis eget mauris sodales pellentesque? Donec tempor! Aliquam malesuada urna sit amet purus. Duis quis purus ut est sollicitudin semper. Maecenas erat nisi, luctus sit amet, rutrum ac, malesuada ac; arcu? Donec at lacus. Duis ac eros vitae pede adipiscing placerat? Sed id nunc. Fusce justo eros, vehicula ac; elementum non, tristique eu, ligula. Etiam non sem quis neque placerat molestie. Mauris commodo purus eget pede.<br /> <br /> Aliquam ornare orci ut nulla. Integer in mauris. Vivamus erat. Pellentesque in eros. Curabitur eleifend metus et felis. Maecenas varius ante non enim. Aenean mollis ipsum id nisi. In iaculis. Nulla quis pede? In nisi? Praesent gravida, quam eu tincidunt lacinia, pede lacus scelerisque justo; et rutrum dolor eros id lorem. Quisque blandit rutrum mi. In hac habitasse platea dictumst. Donec eleifend pede quis nisi. Nam lectus ante, dapibus eget; molestie sit amet, pulvinar vitae, diam. Quisque nec leo et sapien sodales sollicitudin. Maecenas et mauris et erat viverra adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam varius rutrum eros.</p>',0,'2008-11-21 20:46:10',0,'The Green Party of Nova Scotia','','','','site.tpl'),(9,1,'<p>Lorem ipsum <b>dolor</b> sit amet, consectetuer adipiscing elit. Mauris ultricies. Vivamus vel ante. Mauris ut leo. Curabitur ac risusmod. Praesent at felis. Phasellus in quam. Quisque laoreet leo venenatis erat tempor adipiscing. Cras dolor. Aenean ligula turpis, viverra eget, aliquet blandit, sodales sit amet, ligula. Maecenas bibendum euismod tortor. Phasellus aliquet augue in enim. Morbi id mi. Sed lacus. Vivamus consequat.</p>\n<p>Nullam aliquam dolor vitae odio. Donec vulputate varius turpis. Sed mollis consectetuer erat. Nulla non quam. Duis ac lorem. Aenean eu nisi id nisl suscipit pellentesque. Aenean aliquam elit eget nulla. Nunc porttitor ultricies velit. Nam sed massa. Mauris sit amet nisl. Aenean justo eros, laoreet id, sollicitudin vel, aliquam in, tortor. Praesent ornare. Nam imperdiet luctus tortor. Donec lobortis. Ut sodales, metus eu cursus egestas, nunc lacus vulputate lorem, non lacinia elit sem bibendum nulla. Curabitur dolor urna, eleifend semper, dictum eget, pulvinar vitae, nisi. Morbi lacinia.</p>\n<p>Praesent pharetra, urna non egestas ultricies, tellus ligula consectetuer nisl, eu adipiscing eros ante nec enim. Mauris ut metus vitae tellus blandit malesuada. Praesent hendrerit dui. Quisque tristique magna in urna. Phasellus tellus purus, euismod sed, porttitor eget, tempor et, purus. Quisque sed orci. Etiam nec ligula sit amet risus vulputate ultrices. Fusce a orci. Sed libero nisi, iaculis nec, mattis vel, malesuada vel, arcu. Sed et ante sit amet velit ultrices pulvinar. Quisque eget magna ut ligula fringilla consectetuer. Vestibulum lectus.</p>\n<p>In nibh elit, tristique sed, semper vitae, eleifend sit amet, leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tortor. Fusce tortor metus, pretium sit amet, ornare imperdiet, vestibulum sit amet, erat. Nam dui. Suspendisse at felis vitae lectus congue hendrerit. Donec dictum neque in tortor eleifend placerat. Integer volutpat eros vitae felis. Integer porta pede sed libero. Nullam velit augue, consequat vel, vestibulum quis, egestas feugiat, erat. Phasellus quis mauris. Sed tincidunt imperdiet ipsum. Morbi aliquam, augue sed viverra mollis, quam neque vehicula pede, nec luctus enim magna at sem. Curabitur pharetra ante eleifend velit. Etiam eu est.</p>\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. In eu mauris! Curabitur fermentum, lectus nec aliquet vehicula, mauris quam accumsan sapien, in sollicitudin erat mi sit amet purus. Phasellus pretium neque sollicitudin tellus. Sed in est. Morbi ac sem. Quisque ornare iaculis sapien. Donec eleifend aliquet nisl. Fusce dapibus ipsum nec metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas malesuada nibh id turpis. Aliquam erat volutpat. Etiam aliquet volutpat justo. Etiam at tortor.<br> <br> Donec a est. Nulla vitae mi. Fusce vehicula turpis eget mauris sodales pellentesque? Donec tempor! Aliquam malesuada urna sit amet purus. Duis quis purus ut est sollicitudin semper. Maecenas erat nisi, luctus sit amet, rutrum ac, malesuada ac; arcu? Donec at lacus. Duis ac eros vitae pede adipiscing placerat? Sed id nunc. Fusce justo eros, vehicula ac; elementum non, tristique eu, ligula. Etiam non sem quis neque placerat molestie. Mauris commodo purus eget pede.<br> <br> Aliquam ornare orci ut nulla. Integer in mauris. Vivamus erat. Pellentesque in eros. Curabitur eleifend metus et felis. Maecenas varius ante non enim. Aenean mollis ipsum id nisi. In iaculis. Nulla quis pede? In nisi? Praesent gravida, quam eu tincidunt lacinia, pede lacus scelerisque justo; et rutrum dolor eros id lorem. Quisque blandit rutrum mi. In hac habitasse platea dictumst. Donec eleifend pede quis nisi. Nam lectus ante, dapibus eget; molestie sit amet, pulvinar vitae, diam. Quisque nec leo et sapien sodales sollicitudin. Maecenas et mauris et erat viverra adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam varius rutrum eros.</p>',0,'2008-11-24 19:46:42',0,'The Green Party of Nova Scotia','','','','site.tpl'),(12,1,'<p><strong>Lorem</strong> ipsum <strong>dolor</strong> sit amet, consectetuer adipiscing elit. Mauris ultricies. Vivamus vel ante. Mauris ut leo. Curabitur ac risusmod. Praesent at felis. Phasellus in quam. Quisque laoreet leo venenatis erat tempor adipiscing. Cras dolor. Aenean ligula turpis, viverra eget, aliquet blandit, sodales sit amet, ligula. Maecenas bibendum euismod tortor. Phasellus aliquet augue in enim. Morbi id mi. Sed lacus. Vivamus consequat.</p>\r\n<p>Nullam aliquam dolor vitae odio. Donec vulputate varius turpis. Sed mollis consectetuer erat. Nulla non quam. Duis ac lorem. Aenean eu nisi id nisl suscipit pellentesque. Aenean aliquam elit eget nulla. Nunc porttitor ultricies velit. Nam sed massa. Mauris sit amet nisl. Aenean justo eros, laoreet id, sollicitudin vel, aliquam in, tortor. Praesent ornare. Nam imperdiet luctus tortor. Donec lobortis. Ut sodales, metus eu cursus egestas, nunc lacus vulputate lorem, non lacinia elit sem bibendum nulla. Curabitur dolor urna, eleifend semper, dictum eget, pulvinar vitae, nisi. Morbi lacinia.</p>\r\n<p>Praesent pharetra, urna non egestas ultricies, tellus ligula consectetuer nisl, eu adipiscing eros ante nec enim. Mauris ut metus vitae tellus blandit malesuada. Praesent hendrerit dui. Quisque tristique magna in urna. Phasellus tellus purus, euismod sed, porttitor eget, tempor et, purus. Quisque sed orci. Etiam nec ligula sit amet risus vulputate ultrices. Fusce a orci. Sed libero nisi, iaculis nec, mattis vel, malesuada vel, arcu. Sed et ante sit amet velit ultrices pulvinar. Quisque eget magna ut ligula fringilla consectetuer. Vestibulum lectus.</p>\r\n<p>In nibh elit, tristique sed, semper vitae, eleifend sit amet, leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tortor. Fusce tortor metus, pretium sit amet, ornare imperdiet, vestibulum sit amet, erat. Nam dui. Suspendisse at felis vitae lectus congue hendrerit. Donec dictum neque in tortor eleifend placerat. Integer volutpat eros vitae felis. Integer porta pede sed libero. Nullam velit augue, consequat vel, vestibulum quis, egestas feugiat, erat. Phasellus quis mauris. Sed tincidunt imperdiet ipsum. Morbi aliquam, augue sed viverra mollis, quam neque vehicula pede, nec luctus enim magna at sem. Curabitur pharetra ante eleifend velit. Etiam eu est.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. In eu mauris! Curabitur fermentum, lectus nec aliquet vehicula, mauris quam accumsan sapien, in sollicitudin erat mi sit amet purus. Phasellus pretium neque sollicitudin tellus. Sed in est. Morbi ac sem. Quisque ornare iaculis sapien. Donec eleifend aliquet nisl. Fusce dapibus ipsum nec metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas malesuada nibh id turpis. Aliquam erat volutpat. Etiam aliquet volutpat justo. Etiam at tortor.<br /> <br /> Donec a est. Nulla vitae mi. Fusce vehicula turpis eget mauris sodales pellentesque? Donec tempor! Aliquam malesuada urna sit amet purus. Duis quis purus ut est sollicitudin semper. Maecenas erat nisi, luctus sit amet, rutrum ac, malesuada ac; arcu? Donec at lacus. Duis ac eros vitae pede adipiscing placerat? Sed id nunc. Fusce justo eros, vehicula ac; elementum non, tristique eu, ligula. Etiam non sem quis neque placerat molestie. Mauris commodo purus eget pede.<br /> <br /> Aliquam ornare orci ut nulla. Integer in mauris. Vivamus erat. Pellentesque in eros. Curabitur eleifend metus et felis. Maecenas varius ante non enim. Aenean mollis ipsum id nisi. In iaculis. Nulla quis pede? In nisi? Praesent gravida, quam eu tincidunt lacinia, pede lacus scelerisque justo; et rutrum dolor eros id lorem. Quisque blandit rutrum mi. In hac habitasse platea dictumst. Donec eleifend pede quis nisi. Nam lectus ante, dapibus eget; molestie sit amet, pulvinar vitae, diam. Quisque nec leo et sapien sodales sollicitudin. Maecenas et mauris et erat viverra adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam varius rutrum eros.</p>',0,'2008-11-25 16:33:03',0,'The Green Party of Nova Scotia','','','','site.tpl'),(10,2,'<p>Etiam quis felis dictum sem commodo sagittis. Curabitur vel nisi eget ante tincidunt condimentum. Cras sit amet quam a ante malesuada pulvinar. Curabitur adipiscing pede sed tellus. Aliquam ullamcorper magna sit amet libero. Donec suscipit ipsum nec pede. Quisque placerat lorem sed nibh. Sed quam mauris, pellentesque ac, pulvinar ut, pellentesque sed, neque. Sed vel ligula a ante venenatis dignissim. Ut in sapien. Morbi convallis orci vitae tellus.</p>\r\n<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed aliquam nisi non lectus. Praesent dapibus magna pretium magna. Fusce et dolor nec purus volutpat malesuada. Nullam eu nisi a velit feugiat egestas. Nulla id lectus. Mauris auctor tortor ut mi. Sed quam. Nunc dui elit, sagittis et, iaculis vel, pellentesque vel, augue. Mauris gravida. Curabitur in arcu.</p>\r\n<p>Curabitur bibendum velit eu diam. Vivamus viverra libero a elit. Nullam tempor. Proin diam. Donec vitae dui nec est placerat hendrerit. Duis at magna sit amet diam sollicitudin malesuada. In hac habitasse platea dictumst. Sed pulvinar. Etiam turpis eros, hendrerit non, faucibus non, euismod et, velit. Nulla aliquet sodales lectus. Nam sit amet nibh eu mi rhoncus luctus. Cras sodales lacinia neque. Sed congue est eu metus. Nunc ante urna, fermentum sit amet, mollis et, posuere vitae, pede.</p>',0,'2008-11-25 13:19:25',1,'This is a test page','','','','site_no_blogs.tpl'),(11,1,'<p>Lorem ipsum <strong>dolor</strong> sit amet, consectetuer adipiscing elit. Mauris ultricies. Vivamus vel ante. Mauris ut leo. Curabitur ac risusmod. Praesent at felis. Phasellus in quam. Quisque laoreet leo venenatis erat tempor adipiscing. Cras dolor. Aenean ligula turpis, viverra eget, aliquet blandit, sodales sit amet, ligula. Maecenas bibendum euismod tortor. Phasellus aliquet augue in enim. Morbi id mi. Sed lacus. Vivamus consequat.</p>\r\n<p>Nullam aliquam dolor vitae odio. Donec vulputate varius turpis. Sed mollis consectetuer erat. Nulla non quam. Duis ac lorem. Aenean eu nisi id nisl suscipit pellentesque. Aenean aliquam elit eget nulla. Nunc porttitor ultricies velit. Nam sed massa. Mauris sit amet nisl. Aenean justo eros, laoreet id, sollicitudin vel, aliquam in, tortor. Praesent ornare. Nam imperdiet luctus tortor. Donec lobortis. Ut sodales, metus eu cursus egestas, nunc lacus vulputate lorem, non lacinia elit sem bibendum nulla. Curabitur dolor urna, eleifend semper, dictum eget, pulvinar vitae, nisi. Morbi lacinia.</p>\r\n<p>Praesent pharetra, urna non egestas ultricies, tellus ligula consectetuer nisl, eu adipiscing eros ante nec enim. Mauris ut metus vitae tellus blandit malesuada. Praesent hendrerit dui. Quisque tristique magna in urna. Phasellus tellus purus, euismod sed, porttitor eget, tempor et, purus. Quisque sed orci. Etiam nec ligula sit amet risus vulputate ultrices. Fusce a orci. Sed libero nisi, iaculis nec, mattis vel, malesuada vel, arcu. Sed et ante sit amet velit ultrices pulvinar. Quisque eget magna ut ligula fringilla consectetuer. Vestibulum lectus.</p>\r\n<p>In nibh elit, tristique sed, semper vitae, eleifend sit amet, leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tortor. Fusce tortor metus, pretium sit amet, ornare imperdiet, vestibulum sit amet, erat. Nam dui. Suspendisse at felis vitae lectus congue hendrerit. Donec dictum neque in tortor eleifend placerat. Integer volutpat eros vitae felis. Integer porta pede sed libero. Nullam velit augue, consequat vel, vestibulum quis, egestas feugiat, erat. Phasellus quis mauris. Sed tincidunt imperdiet ipsum. Morbi aliquam, augue sed viverra mollis, quam neque vehicula pede, nec luctus enim magna at sem. Curabitur pharetra ante eleifend velit. Etiam eu est.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. In eu mauris! Curabitur fermentum, lectus nec aliquet vehicula, mauris quam accumsan sapien, in sollicitudin erat mi sit amet purus. Phasellus pretium neque sollicitudin tellus. Sed in est. Morbi ac sem. Quisque ornare iaculis sapien. Donec eleifend aliquet nisl. Fusce dapibus ipsum nec metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas malesuada nibh id turpis. Aliquam erat volutpat. Etiam aliquet volutpat justo. Etiam at tortor.<br /> <br /> Donec a est. Nulla vitae mi. Fusce vehicula turpis eget mauris sodales pellentesque? Donec tempor! Aliquam malesuada urna sit amet purus. Duis quis purus ut est sollicitudin semper. Maecenas erat nisi, luctus sit amet, rutrum ac, malesuada ac; arcu? Donec at lacus. Duis ac eros vitae pede adipiscing placerat? Sed id nunc. Fusce justo eros, vehicula ac; elementum non, tristique eu, ligula. Etiam non sem quis neque placerat molestie. Mauris commodo purus eget pede.<br /> <br /> Aliquam ornare orci ut nulla. Integer in mauris. Vivamus erat. Pellentesque in eros. Curabitur eleifend metus et felis. Maecenas varius ante non enim. Aenean mollis ipsum id nisi. In iaculis. Nulla quis pede? In nisi? Praesent gravida, quam eu tincidunt lacinia, pede lacus scelerisque justo; et rutrum dolor eros id lorem. Quisque blandit rutrum mi. In hac habitasse platea dictumst. Donec eleifend pede quis nisi. Nam lectus ante, dapibus eget; molestie sit amet, pulvinar vitae, diam. Quisque nec leo et sapien sodales sollicitudin. Maecenas et mauris et erat viverra adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam varius rutrum eros.</p>',0,'2008-11-25 13:42:55',0,'The Green Party of Nova Scotia','','','','site.tpl'),(13,1,'<p><strong>Lorem</strong> ipsum <strong>dolor</strong> sit amet, consectetuer adipiscing elit. Mauris ultricies. Vivamus vel ante. Mauris ut leo. Curabitur ac risusmod. Praesent at felis. Phasellus in quam. Quisque laoreet leo venenatis erat tempor adipiscing. Cras dolor. Aenean ligula turpis, viverra eget, aliquet blandit, sodales sit amet, ligula. Maecenas bibendum euismod tortor. Phasellus aliquet augue in enim. Morbi id mi. Sed lacus. Vivamus consequat.</p>\r\n<p>Nullam aliquam dolor vitae odio. Donec vulputate varius turpis. Sed mollis consectetuer erat. Nulla non quam. Duis ac lorem. Aenean eu nisi id nisl suscipit pellentesque. Aenean aliquam elit eget nulla. Nunc porttitor ultricies velit. Nam sed massa. Mauris sit amet nisl. Aenean justo eros, laoreet id, sollicitudin vel, aliquam in, tortor. Praesent ornare. Nam imperdiet luctus tortor. Donec lobortis. Ut sodales, metus eu cursus egestas, nunc lacus vulputate lorem, non lacinia elit sem bibendum nulla. Curabitur dolor urna, eleifend semper, dictum eget, pulvinar vitae, nisi. Morbi lacinia.</p>\r\n<p>Praesent pharetra, urna non egestas ultricies, tellus ligula consectetuer nisl, eu adipiscing eros ante nec enim. Mauris ut metus vitae tellus blandit malesuada. Praesent hendrerit dui. Quisque tristique magna in urna. Phasellus tellus purus, euismod sed, porttitor eget, tempor et, purus. Quisque sed orci. Etiam nec ligula sit amet risus vulputate ultrices. Fusce a orci. Sed libero nisi, iaculis nec, mattis vel, malesuada vel, arcu. Sed et ante sit amet velit ultrices pulvinar. Quisque eget magna ut ligula fringilla consectetuer. Vestibulum lectus.</p>\r\n<p>In nibh elit, tristique sed, semper vitae, eleifend sit amet, leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tortor. Fusce tortor metus, pretium sit amet, ornare imperdiet, vestibulum sit amet, erat. Nam dui. Suspendisse at felis vitae lectus congue hendrerit. Donec dictum neque in tortor eleifend placerat. Integer volutpat eros vitae felis. Integer porta pede sed libero. Nullam velit augue, consequat vel, vestibulum quis, egestas feugiat, erat. Phasellus quis mauris. Sed tincidunt imperdiet ipsum. Morbi aliquam, augue sed viverra mollis, quam neque vehicula pede, nec luctus enim magna at sem. Curabitur pharetra ante eleifend velit. Etiam eu est.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. In eu mauris! Curabitur fermentum, lectus nec aliquet vehicula, mauris quam accumsan sapien, in sollicitudin erat mi sit amet purus. Phasellus pretium neque sollicitudin tellus. Sed in est. Morbi ac sem. Quisque ornare iaculis sapien. Donec eleifend aliquet nisl. Fusce dapibus ipsum nec metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas malesuada nibh id turpis. Aliquam erat volutpat. Etiam aliquet volutpat justo. Etiam at tortor.<br /> <br /> Donec a est. Nulla vitae mi. Fusce vehicula turpis eget mauris sodales pellentesque? Donec tempor! Aliquam malesuada urna sit amet purus. Duis quis purus ut est sollicitudin semper. Maecenas erat nisi, luctus sit amet, rutrum ac, malesuada ac; arcu? Donec at lacus. Duis ac eros vitae pede adipiscing placerat? Sed id nunc. Fusce justo eros, vehicula ac; elementum non, tristique eu, ligula. Etiam non sem quis neque placerat molestie. Mauris commodo purus eget pede.<br /> <br /> Aliquam ornare orci ut nulla. Integer in mauris. Vivamus erat. Pellentesque in eros. Curabitur eleifend metus et felis. Maecenas varius ante non enim. Aenean mollis ipsum id nisi. In iaculis. Nulla quis pede? In nisi? Praesent gravida, quam eu tincidunt lacinia, pede lacus scelerisque justo; et rutrum dolor eros id lorem. Quisque blandit rutrum mi. In hac habitasse platea dictumst. Donec eleifend pede quis nisi. Nam lectus ante, dapibus eget; molestie sit amet, pulvinar vitae, diam. Quisque nec leo et sapien sodales sollicitudin. Maecenas et mauris et erat viverra adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam varius rutrum eros.</p>',0,'2008-11-26 14:51:27',1,'The Green Party of Nova Scotia','','','','site.tpl');
/*!40000 ALTER TABLE `content_page_data` ENABLE KEYS */;
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
  PRIMARY KEY  (`id`),
  KEY `page_name` (`name`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content_pages`
--

LOCK TABLES `content_pages` WRITE;
/*!40000 ALTER TABLE `content_pages` DISABLE KEYS */;
INSERT INTO `content_pages` VALUES (1,'Home','2007-12-15 23:23:33',1,'public','home'),(2,'Test Page','2008-11-21 21:47:14',1,'public','test_page');
/*!40000 ALTER TABLE `content_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_rel`
--

DROP TABLE IF EXISTS `content_rel`;
CREATE TABLE `content_rel` (
  `revision_id` int(11) NOT NULL,
  `child_type` enum('block','menu') default 'block',
  `child_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `module` varchar(100) default 'Content',
  KEY `revision_id` (`revision_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content_rel`
--

LOCK TABLES `content_rel` WRITE;
/*!40000 ALTER TABLE `content_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_rel` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-12-01 16:00:03
