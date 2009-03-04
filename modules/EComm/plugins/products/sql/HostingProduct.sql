-- phpMyAdmin SQL Dump
-- version 3.2.0-dev
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2009 at 04:24 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `dynamichosting-green`
--

-- --------------------------------------------------------

--
-- Table structure for table `ecomm_product_hosting`
--

CREATE TABLE IF NOT EXISTS `ecomm_product_hosting` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `specs` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
