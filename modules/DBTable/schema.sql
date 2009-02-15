DROP TABLE IF EXISTS `dbtable`;
CREATE TABLE `dbtable` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(50) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `modifier` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO `dbtable` VALUES
(1,'chunk','id','','id','hidden'),
(2,'chunk','type','DBColumn Type','text',''),
(3,'chunk','role','Role','text',''),
(4,'chunk','name','Name','text',''),
(5,'chunk','parent_class','Parent Class','text',''),
(6,'chunk','parent','Parent ID','integer',''),
(7,'chunk','sort','Sort','sort',''),
(11,'chunk_revision','id','','id','hidden'),
(12,'chunk_revision','parent','Chunk','integer',''),
(13,'chunk_revision','content','Content','text',''),
(14,'chunk_revision','timestamp','Timestamp','timestamp',''),
(15,'chunk_revision','status','Status','enum(active,draft,inactive)',''),
(21,'chunk_revision','count','Count','integer','');
