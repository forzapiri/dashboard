DROP TABLE IF EXISTS `dbtable`;
CREATE TABLE `dbtable` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(50) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `modifier` varchar(20) default NULL,
  `sort` int(10) NOT NULL,
  KEY `table` (`table`),
  KEY `type` (`type`),
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO `dbtable` VALUES
(1,'chunk','id','','id','hidden',1),
(2,'chunk','type','DBColumn Type','text','',2),
(3,'chunk','role','Role','text','',3),
(4,'chunk','name','Name','text','',4),
(5,'chunk','parent_class','Parent Class','text','',5),
(6,'chunk','parent','Parent ID','integer','',6),
(7,'chunk','sort','Sort','sort','',7),
(11,'chunk_revision','id','','id','hidden',1),
(12,'chunk_revision','parent','Chunk','integer','',2),
(13,'chunk_revision','content','Content','text','',3),
(14,'chunk_revision','timestamp','Timestamp','timestamp','',4),
(15,'chunk_revision','status','Status','enum(active,draft,inactive)','',5),
(21,'chunk_revision','count','Count','integer','',6),
(22,'chunk_revision','version','Version','text','',0);
