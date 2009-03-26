-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 04, 2008 at 02:17 PM
-- Server version: 5.0.41
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `trunk`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_content`
-- 

CREATE TABLE `mail_content` (
  `mail_id` int(11) NOT NULL auto_increment,
  `mail_subject` varchar(128) default NULL,
  `mail_content` longtext,
  `mail_lastmod` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `mail_from_name` varchar(64) NOT NULL,
  `mail_from_address` varchar(128) NOT NULL,
  PRIMARY KEY  (`mail_id`),
  KEY `mail_lastmod` (`mail_lastmod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_delivery_log`
-- 

CREATE TABLE `mail_delivery_log` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `mso_id` int(11) NOT NULL,
  `mail_queue_id` int(11) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_lists`
-- 

CREATE TABLE `mail_lists` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_queue`
-- 

CREATE TABLE `mail_queue` (
  `mso_id` int(11) default NULL,
  `mail_user_id` int(11) default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `mso_id` (`mso_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_sendout`
-- 

CREATE TABLE `mail_sendout` (
  `mso_id` int(11) NOT NULL auto_increment,
  `mso_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `mso_subject` varchar(128) NOT NULL,
  `mso_content` longtext NOT NULL,
  `mso_fromName` varchar(64) default NULL,
  `mso_fromAddress` varchar(128) NOT NULL,
  `mso_listcount` int(11) default NULL,
  `list_name` varchar(128) default NULL,
  PRIMARY KEY  (`mso_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_users`
-- 

CREATE TABLE `mail_users` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(128) NOT NULL,
  `first_name` varchar(32) default NULL,
  `last_name` varchar(32) default NULL,
  `notes` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_users_to_lists`
-- 

CREATE TABLE `mail_users_to_lists` (
  `id` int(11) NOT NULL auto_increment,
  `mail_user_id` int(11) NOT NULL,
  `mail_list_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_view_log`
-- 

CREATE TABLE `mail_view_log` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) NOT NULL,
  `mso_id` int(11) NOT NULL,
  `browser` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;
