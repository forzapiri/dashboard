-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 21, 2008 at 11:08 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `trunk`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `blocks`
-- 

DROP TABLE IF EXISTS blocks;
CREATE TABLE `blocks` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  `sort` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `status` (`status`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;


DELETE FROM `permissions` WHERE class = 'Blocks';
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('addedit','Block','Add/Edit Blocks','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('view','Block','View Blocks','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('delete','Block','Delete Blocks',NULL,'1','1');
