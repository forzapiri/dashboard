DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `key` text,
  `class` text,
  `name` text,
  `description` text,
  `group_id` int(11) default NULL,
  `status` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `permissions` VALUES 
(1 ,'view','CMS','Admin Access',NULL,1,1),
(2 ,'view','Permission','View Permissions',NULL,1,1),
(3 ,'addedit','Permission','Add/Edit Permissions',NULL,1,1),
(4 ,'delete','Permission','Delete Permissions','',1,1),
(5 ,'view','User','View Users','',1,1),
(6 ,'addedit','User','Add/Edit Users','',1,1),
(7 ,'delete','User','Delete Users','',1,1),
(8 ,'view','Group','View Groups','',1,1),
(9 ,'addedit','Group','Add/Edit Groups','',1,1),
(10,'delete','Group','Delete Groups','',1,1),
(11,'view','ContentPage','View Content Pages','',1,1),
(12,'addedit','ContentPage','Add / Edit Content Pages','',1,1),
(13,'delete','ContentPage','Delete Content Pages','',1,1);
