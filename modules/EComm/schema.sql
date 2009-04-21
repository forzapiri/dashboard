-- MySQL dump 10.11
--
-- Host: localhost    Database: ecomm
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
-- Insert the SiteConfig options
-- 
-- INSERT INTO `config_options` VALUES ('EComm','CurrencySign','How the currency will be displayed to end users','enum($,C$,U$,â¬,Â£)','C$',13,'1'),('EComm','AdminEmail','The emaaddress that orders notifications will be sent to','string','anas@norex.ca',8,'0'),('EComm','MinimumOrderValue','The minimum amount of value per order','string','17.30',5,'0'),('EComm','PaypalBusinessEmailAddress','The business email account that the money to be deposited to','enum(anas_s_1232461915_biz@norex.ca)','anas_s_1232461915_biz@norex.ca',2,'0'),('EComm','PaypalHostName','If this website is beta, set PaypalHostName to sandbox. If it is live, set it to paypal.com','enum(www.sandbox.paypal.com,www.paypal.com)','www.sandbox.paypal.com',1,'0'),('EComm','Currency','The currency used in the transactions','enum(CAD,USD,EUR,GBP)','CAD',12,'0');


--
-- Table structure for table `ecomm_cart_item`
--

DROP TABLE IF EXISTS `ecomm_cart_item`;
CREATE TABLE `ecomm_cart_item` (
  `id` int(11) NOT NULL auto_increment,
  `session` int(11) NOT NULL default '0',
  `product` int(11) NOT NULL default '0',
  `quantity` int(11) NOT NULL default '1',
  `transaction` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_category`
--

DROP TABLE IF EXISTS `ecomm_category`;
CREATE TABLE `ecomm_category` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `parent_category` int(11) NOT NULL default '0',
  `image` int(11) NOT NULL default '0',
  `date_added` datetime default NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL default '0',
  `details` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=309 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_order`
--

DROP TABLE IF EXISTS `ecomm_order`;
CREATE TABLE `ecomm_order` (
  `id` int(11) NOT NULL auto_increment,
  `tid` varchar(255) NOT NULL default '',
  `user` int(11) NOT NULL default '0',
  `customer_name` varchar(255) NOT NULL default '',
  `user_email` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `shipping_street` varchar(255) NOT NULL default '',
  `shipping_city` varchar(255) NOT NULL default '',
  `shipping_postal` varchar(255) NOT NULL default '',
  `shipping_province` varchar(255) NOT NULL default '',
  `shipping_country` varchar(255) NOT NULL default '',
  `billing_street` varchar(255) NOT NULL default '',
  `billing_city` varchar(255) NOT NULL default '',
  `billing_postal` varchar(255) NOT NULL default '',
  `billing_province` varchar(255) NOT NULL default '',
  `billing_country` varchar(255) NOT NULL default '',
  `cost_subtotal` float NOT NULL default '0',
  `cost_tax` float NOT NULL default '0',
  `cost_shipping` float NOT NULL default '0',
  `cost_total` float NOT NULL default '0',
  `ip` varchar(30) NOT NULL default '',
  `shipping_class` varchar(255) NOT NULL default '',
  `payment_class` varchar(255) NOT NULL default '',
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `delivery_instructions` text NOT NULL,
  `status` varchar(255) NOT NULL default 'Pending',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_order_comment`
--

DROP TABLE IF EXISTS `ecomm_order_comment`;
CREATE TABLE `ecomm_order_comment` (
  `id` int(11) NOT NULL auto_increment,
  `order_nb` int(11) NOT NULL default '0',
  `status` varchar(255) NOT NULL default '',
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_order_detail`
--

DROP TABLE IF EXISTS `ecomm_order_detail`;
CREATE TABLE `ecomm_order_detail` (
  `id` int(11) NOT NULL auto_increment,
  `order_nb` int(11) NOT NULL default '0',
  `product` int(11) NOT NULL default '0',
  `product_name` varchar(255) NOT NULL default '',
  `quantity` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_paypal_ipn`
--

DROP TABLE IF EXISTS `ecomm_paypal_ipn`;
CREATE TABLE `ecomm_paypal_ipn` (
  `id` int(11) NOT NULL auto_increment,
  `is_verified` int(1) NOT NULL default '0',
  `transaction` varchar(255) NOT NULL default '',
  `txnid` varchar(255) NOT NULL default '',
  `payment_status` varchar(255) NOT NULL default '',
  `post_string` text NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_product`
--

DROP TABLE IF EXISTS `ecomm_product`;
CREATE TABLE `ecomm_product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `supplier` int(11) NOT NULL default '0',
  `category` int(11) NOT NULL default '0',
  `producttype` int(11) NOT NULL default '0',
  `tax_class` int(11) NOT NULL default '0',
  `stock_quantity` int(11) NOT NULL default '0',
  `image` int(11) NOT NULL default '0',
  `price` float(11,2) NOT NULL default '0.00',
  `date_added` datetime default NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL default '0',
  `details` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6982 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_product_type`
--

DROP TABLE IF EXISTS `ecomm_product_type`;
CREATE TABLE `ecomm_product_type` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `image` int(11) NOT NULL default '0',
  `date_added` datetime default NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL default '0',
  `details` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_session`
--

DROP TABLE IF EXISTS `ecomm_session`;
CREATE TABLE `ecomm_session` (
  `id` int(11) NOT NULL auto_increment,
  `ip_address` varchar(15) default NULL,
  `status` int(1) NOT NULL default '0',
  `user` int(11) NOT NULL default '0',
  `shipping_class` varchar(255) NOT NULL default '',
  `payment_class` varchar(255) NOT NULL default '',
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_supplier`
--

DROP TABLE IF EXISTS `ecomm_supplier`;
CREATE TABLE `ecomm_supplier` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `image` int(11) NOT NULL default '0',
  `date_added` datetime default NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL default '0',
  `details` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=265 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_tax_class`
--

DROP TABLE IF EXISTS `ecomm_tax_class`;
CREATE TABLE `ecomm_tax_class` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `date_added` datetime default NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL default '0',
  `details` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_tax_rate`
--

DROP TABLE IF EXISTS `ecomm_tax_rate`;
CREATE TABLE `ecomm_tax_rate` (
  `id` int(11) NOT NULL auto_increment,
  `country` int(11) NOT NULL default '0',
  `province` int(11) NOT NULL default '0',
  `tax_class` int(11) NOT NULL default '0',
  `tax_rate` float(5,2) NOT NULL default '0.00',
  `date_added` datetime default NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `details` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_transaction`
--

DROP TABLE IF EXISTS `ecomm_transaction`;
CREATE TABLE `ecomm_transaction` (
  `id` int(11) NOT NULL auto_increment,
  `tid` varchar(255) NOT NULL default '',
  `session` int(11) NOT NULL default '0',
  `user` int(11) NOT NULL default '0',
  `phone` varchar(255) NOT NULL default '',
  `shipping_street` varchar(255) NOT NULL default '',
  `shipping_city` varchar(255) NOT NULL default '',
  `shipping_postal` varchar(255) NOT NULL default '',
  `shipping_province` varchar(255) NOT NULL default '',
  `shipping_country` varchar(255) NOT NULL default '',
  `billing_street` varchar(255) NOT NULL default '',
  `billing_city` varchar(255) NOT NULL default '',
  `billing_postal` varchar(255) NOT NULL default '',
  `billing_province` varchar(255) NOT NULL default '',
  `billing_country` varchar(255) NOT NULL default '',
  `cost_subtotal` float NOT NULL default '0',
  `cost_tax` float NOT NULL default '0',
  `cost_shipping` float NOT NULL default '0',
  `cost_total` float NOT NULL default '0',
  `ip` varchar(30) NOT NULL default '',
  `shipping_class` varchar(255) NOT NULL default '',
  `payment_class` varchar(255) NOT NULL default '',
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `delivery_instructions` text NOT NULL,
  `status` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

--
-- Table structure for table `ecomm_user_details`
--

DROP TABLE IF EXISTS `ecomm_user_details`;
CREATE TABLE `ecomm_user_details` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) NOT NULL default '0',
  `phone_number` varchar(255) NOT NULL default '',
  `shipping_address` int(11) NOT NULL default '0',
  `billing_address` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-03-09  0:51:27
