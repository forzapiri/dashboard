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
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_cart_item`
--

LOCK TABLES `ecomm_cart_item` WRITE;
/*!40000 ALTER TABLE `ecomm_cart_item` DISABLE KEYS */;
INSERT INTO `ecomm_cart_item` VALUES (3,3,1,5,0),(4,3,2,17,0),(5,3,1,17,0),(6,4,3,14,0),(7,4,6,1,0),(8,4,6,1,0),(23,5,1,1,0),(27,5,1,1,0),(13,5,1,2,0),(28,7,1,1,0),(26,5,6,9,0),(25,5,1,3,0),(22,5,4,12,0),(24,5,1,1,0),(29,7,6,2,0),(30,7,2,3,0),(31,9,1,1,0),(32,23,1,1,0),(33,23,6,1,0),(34,23,2,3,0),(35,23,3,10,0),(36,26,1,1,0),(37,26,2,2,0),(38,27,1,1,0),(39,29,6,10,0),(40,29,2,22,0),(41,29,3,3,0),(42,31,6,1,0),(43,31,2,1,0),(44,31,6,1,0),(45,33,1,1,0),(46,33,2,1,0),(47,33,6,10,0),(48,37,1,1,0),(49,37,2,1,0),(50,37,3,2,0),(51,38,3,13,0),(52,38,4,15,0),(53,40,1,1,0),(54,40,3,2,0),(55,40,5,3,0),(56,40,6,4,0),(57,40,1,2,0),(58,40,2,3,0),(59,40,3,4,0),(60,40,6,5,0),(64,44,1,1,0),(63,43,2,1,0),(65,44,2,13,0),(66,44,2,1,0),(67,44,1,1,0),(68,44,1,1,0),(69,45,6,2,0),(70,45,2,1,0),(71,46,2,1,0),(72,46,107,2,0),(73,48,2,1,0),(74,48,106,2,0),(75,49,2,1,0),(76,49,106,3,0),(79,51,2,1,0);
/*!40000 ALTER TABLE `ecomm_cart_item` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_category`
--

LOCK TABLES `ecomm_category` WRITE;
/*!40000 ALTER TABLE `ecomm_category` DISABLE KEYS */;
INSERT INTO `ecomm_category` VALUES (6,'test',0,0,'2009-01-14 13:48:32','2009-01-15 15:44:11',0,'<p>just a test</p>'),(5,'testchild',6,0,'2009-01-14 10:44:25','2009-01-14 17:51:11',1,'<p>testsest</p>'),(7,'Electronics',0,32,'2009-01-14 18:37:20','2009-01-14 22:39:01',1,'<p>The electronics category.</p>\r\n<p>This category includes products such as iPods, DVD players, computers, etc</p>'),(8,'Food',0,33,'2009-01-14 18:39:04','2009-01-14 22:39:55',1,'<p>This category includes items such as fries, burgers, coke, etc</p>\r\n<p>It\'s the food category</p>'),(9,'Clothes',0,34,'2009-01-14 18:39:58','2009-01-14 22:40:52',1,'<p>The cloths category</p>\r\n<p>includes products such as women wear, men\'s wear, etc</p>'),(10,'Men\'s wear',9,36,'2009-01-14 18:39:58','2009-01-14 22:43:57',1,'<p>The men\'s wear category</p>\r\n<p>&nbsp;</p>'),(11,'women\'s wear',9,37,'2009-01-14 18:44:05','2009-01-14 22:45:23',1,'<p>Women\'s wear</p>'),(12,'Sports',0,41,'2009-01-15 11:27:12','2009-01-15 15:28:05',1,'<p>This is the sport category</p>\r\n<p>It contains products such as:</p>\r\n<p>Football</p>\r\n<p>Baseball</p>\r\n<p>Basketball</p>\r\n<p>Hockey</p>\r\n<p>Golf</p>\r\n<p>Etc</p>'),(13,'Cars',0,42,'2009-01-15 11:39:45','2009-01-15 15:40:09',1,'<p>This category includes cars</p>'),(14,'Pets',0,43,'2009-01-15 11:40:45','2009-01-15 15:41:31',1,'');
/*!40000 ALTER TABLE `ecomm_category` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_order`
--

LOCK TABLES `ecomm_order` WRITE;
/*!40000 ALTER TABLE `ecomm_order` DISABLE KEYS */;
INSERT INTO `ecomm_order` VALUES (4,'997497865393161821463974849139',1,'Anas Trabulsi','anas@norex.ca','+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',279.94,19.6,6,305.54,'127.0.0.1','CanadaPost','Paypal','2009-01-20 19:23:04','hi there\njust a test','Shipped'),(7,'992941128797862835778384785719',1,'Norex Development','anas@norex.ca','+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',109.47,7.66,3,120.13,'127.0.0.1','CanadaPost','Paypal','2009-01-25 15:47:40','','Pending'),(8,'329399666784397397111454941678',1,'Norex Development','anas@norex.ca','+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',134.98,9.45,2,146.43,'127.0.0.1','CanadaPost','Paypal','2009-01-25 16:37:26','','Pending'),(9,'584986817153397111489517812224',1,'Norex Development','anas@norex.ca','+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',132.37,9.27,13,154.64,'127.0.0.1','CanadaPost','Paypal','2009-01-25 16:38:39','','Pending'),(10,'216186364546161236784713267357',1,'Norex Development','anas@norex.ca','+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',102.49,7.17,1,110.66,'127.0.0.1','CanadaPost','Paypal','2009-01-25 16:42:54','','Pending');
/*!40000 ALTER TABLE `ecomm_order` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_order_comment`
--

LOCK TABLES `ecomm_order_comment` WRITE;
/*!40000 ALTER TABLE `ecomm_order_comment` DISABLE KEYS */;
INSERT INTO `ecomm_order_comment` VALUES (2,0,'Shipped','hi there'),(3,0,'Shipped','test'),(4,4,'Shipped','hi there'),(5,4,'Complete','Product has arrived\nto the client\nyesterday'),(6,4,'Complete','new comment'),(7,4,'Shipped','Tracking number is: 123');
/*!40000 ALTER TABLE `ecomm_order_comment` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_order_detail`
--

LOCK TABLES `ecomm_order_detail` WRITE;
/*!40000 ALTER TABLE `ecomm_order_detail` DISABLE KEYS */;
INSERT INTO `ecomm_order_detail` VALUES (1,4,1,'product 122',2),(2,4,6,'Pants',4),(3,7,2,'1234',1),(4,7,106,'abc',2),(5,8,104,'1122',1),(6,8,2,'1234',1),(7,9,104,'1122',3),(8,9,106,'abc',10),(9,10,2,'1234',1);
/*!40000 ALTER TABLE `ecomm_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_paypal_ipn`
--

LOCK TABLES `ecomm_paypal_ipn` WRITE;
/*!40000 ALTER TABLE `ecomm_paypal_ipn` DISABLE KEYS */;
INSERT INTO `ecomm_paypal_ipn` VALUES (8,0,'','','','&module=EComm&section=IPN&page=&asdf=3&PHPSESSID=6eee77936842b970686fc50344931b13&authchallenge=f4a9a94efcd3e84a5448df313ecd2fa9','The IPN couldn\'t be verified. This could be a potential hack attempt'),(9,0,'','','','&module=EComm&section=IPN&page=&PHPSESSID=f219e00a80960e3678a43efff59ed955','The IPN couldn\'t be verified. This could be a potential hack attempt'),(10,0,'','','','&module=EComm&section=IPN&page=2&PHPSESSID=f219e00a80960e3678a43efff59ed955','The IPN couldn\'t be verified. This could be a potential hack attempt'),(11,0,'','','','&module=EComm&section=IPN&page=w&PHPSESSID=f219e00a80960e3678a43efff59ed955','The IPN couldn\'t be verified. This could be a potential hack attempt'),(12,0,'','','','&module=EComm&section=IPN&page=OrderComplete&tid=12345678&PHPSESSID=472dae2e8ee5f85c100b864212966df3&authchallenge=82431f3d0d71888125113d6de08f476a','The IPN couldn\'t be verified. This could be a potential hack attempt'),(13,0,'','','','&module=EComm&section=IPN&page=&PHPSESSID=f219e00a80960e3678a43efff59ed955','The IPN couldn\'t be verified. This could be a potential hack attempt'),(14,1,'xyz123','211251523','Completed','&module=EComm&section=IPN&page=&test_ipn=1&payment_type=instant&payment_date=07:23:21 Jan. 25, 2009 PST&payment_status=Completed&address_status=confirmed&payer_status=verified&first_name=John&last_name=Smith&payer_email=buyer@paypalsandbox.com&payer_id=TESTBUYERID01&address_name=John Smith&address_country=United States&address_country_code=US&address_zip=95131&address_state=CA&address_city=San Jose&address_street=123, any street&business=seller@paypalsandbox.com&receiver_email=seller@paypalsandbox.com&receiver_id=TESTSELLERID1&residence_country=US&item_name=something&item_number=AK-1234&quantity=1&shipping=3.04&tax=2.02&mc_currency=USD&mc_fee=0.44&mc_gross=12.34&txn_type=web_accept&txn_id=211251523&notify_version=2.1&custom=xyz123&invoice=abc1234&charset=windows-1252&verify_sign=A0VTxsoEtoN7NMAyYz.xr6-TlNUpAOOIdtnXe28Lqk29GQtoT1tW6wBy','Verified'),(15,1,'128919712431198184121917217313','1MG724212A810503W','Completed','&module=EComm&section=IPN&page=&mc_gross=331.99&protection_eligibility=Eligible&address_status=confirmed&payer_id=GEUY2KFH8RHE8&tax=21.52&address_street=1 Maire-Victorin&payment_date=07:27:41 Jan 25, 2009 PST&payment_status=Completed&charset=windows-1252&address_zip=M5A 1E1&first_name=Test&mc_fee=9.93&address_country_code=CA&address_name=Test User&notify_version=2.6&custom=128919712431198184121917217313&payer_status=unverified&business=anas_s_1232461915_biz@norex.ca&address_country=Canada&address_city=Toronto&quantity=1&verify_sign=A4JlhQWbF6iVzknuG9noES80yKb3AEFxl6WamKsDFREfpQz6lbqbJHCS&payer_email=anas_b_1232461939_per@norex.ca&txn_id=1MG724212A810503W&payment_type=instant&last_name=User&address_state=Ontario&receiver_email=anas_s_1232461915_biz@norex.ca&payment_fee=&receiver_id=DGVE4VBNQ46NN&txn_type=web_accept&item_name=&mc_currency=CAD&item_number=&residence_country=CA&test_ipn=1&handling_amount=0.00&transaction_subject=128919712431198184121917217313&payment_gross=&shipping=3.00','Verified'),(16,1,'449841674693553772482545868633','4AF66538TH1866626','Completed','&module=EComm&section=IPN&page=&mc_gross=120.13&protection_eligibility=Eligible&address_status=confirmed&payer_id=GEUY2KFH8RHE8&tax=7.66&address_street=1 Maire-Victorin&payment_date=07:38:23 Jan 25, 2009 PST&payment_status=Completed&charset=windows-1252&address_zip=M5A 1E1&first_name=Test&mc_fee=3.78&address_country_code=CA&address_name=Test User&notify_version=2.6&custom=449841674693553772482545868633&payer_status=unverified&business=anas_s_1232461915_biz@norex.ca&address_country=Canada&address_city=Toronto&quantity=1&verify_sign=AbqHsCVczOa37cHykLilN9-pJc-bA5qpxj4ywNqKYYJ8WR8MDVdgHmdl&payer_email=anas_b_1232461939_per@norex.ca&txn_id=4AF66538TH1866626&payment_type=instant&last_name=User&address_state=Ontario&receiver_email=anas_s_1232461915_biz@norex.ca&payment_fee=&receiver_id=DGVE4VBNQ46NN&txn_type=web_accept&item_name=&mc_currency=CAD&item_number=&residence_country=CA&test_ipn=1&handling_amount=0.00&transaction_subject=449841674693553772482545868633&payment_gross=&shipping=3.00','Verified'),(17,1,'473268255229666356943516876279','15A50379415278154','Completed','&module=EComm&section=IPN&page=&mc_gross=124.87&protection_eligibility=Eligible&address_status=confirmed&payer_id=GEUY2KFH8RHE8&tax=7.91&address_street=1 Maire-Victorin&payment_date=07:43:56 Jan 25, 2009 PST&payment_status=Completed&charset=windows-1252&address_zip=M5A 1E1&first_name=Test&mc_fee=3.92&address_country_code=CA&address_name=Test User&notify_version=2.6&custom=473268255229666356943516876279&payer_status=unverified&business=anas_s_1232461915_biz@norex.ca&address_country=Canada&address_city=Toronto&quantity=1&verify_sign=AnZu0Xe-EKyJyPDnWvj5M5hhDfGwA7j2mbmBHsEnLXJjcnDM9zzMi3KJ&payer_email=anas_b_1232461939_per@norex.ca&txn_id=15A50379415278154&payment_type=instant&last_name=User&address_state=Ontario&receiver_email=anas_s_1232461915_biz@norex.ca&payment_fee=&receiver_id=DGVE4VBNQ46NN&txn_type=web_accept&item_name=&mc_currency=CAD&item_number=&residence_country=CA&test_ipn=1&handling_amount=0.00&transaction_subject=473268255229666356943516876279&payment_gross=&shipping=4.00','Verified'),(18,1,'992941128797862835778384785719','016221899N465750H','Completed','&module=EComm&section=IPN&page=&mc_gross=120.13&protection_eligibility=Eligible&address_status=confirmed&payer_id=GEUY2KFH8RHE8&tax=7.66&address_street=1 Maire-Victorin&payment_date=07:47:34 Jan 25, 2009 PST&payment_status=Completed&charset=windows-1252&address_zip=M5A 1E1&first_name=Test&mc_fee=3.78&address_country_code=CA&address_name=Test User&notify_version=2.6&custom=992941128797862835778384785719&payer_status=unverified&business=anas_s_1232461915_biz@norex.ca&address_country=Canada&address_city=Toronto&quantity=1&verify_sign=ANxj.NqqMR-e5XeLzdNPH3aY..qIAfTu0vZbO0Mi0nXe-kHhnQSasK3E&payer_email=anas_b_1232461939_per@norex.ca&txn_id=016221899N465750H&payment_type=instant&last_name=User&address_state=Ontario&receiver_email=anas_s_1232461915_biz@norex.ca&payment_fee=&receiver_id=DGVE4VBNQ46NN&txn_type=web_accept&item_name=&mc_currency=CAD&item_number=&residence_country=CA&test_ipn=1&handling_amount=0.00&transaction_subject=992941128797862835778384785719&payment_gross=&shipping=3.00','Verified'),(19,1,'329399666784397397111454941678','7DA84660DE4076340','Completed','&module=EComm&section=IPN&page=&mc_gross=146.43&protection_eligibility=Eligible&address_status=confirmed&payer_id=GEUY2KFH8RHE8&tax=9.45&address_street=1 Maire-Victorin&payment_date=08:37:18 Jan 25, 2009 PST&payment_status=Completed&charset=windows-1252&address_zip=M5A 1E1&first_name=Test&mc_fee=4.55&address_country_code=CA&address_name=Test User&notify_version=2.6&custom=329399666784397397111454941678&payer_status=unverified&business=anas_s_1232461915_biz@norex.ca&address_country=Canada&address_city=Toronto&quantity=1&verify_sign=Ab-smSLpiNDsoIUg8bwICxdYTB75AhqOoJEcQqkXz68oeevn-TM2Ykbt&payer_email=anas_b_1232461939_per@norex.ca&txn_id=7DA84660DE4076340&payment_type=instant&last_name=User&address_state=Ontario&receiver_email=anas_s_1232461915_biz@norex.ca&payment_fee=&receiver_id=DGVE4VBNQ46NN&txn_type=web_accept&item_name=&mc_currency=CAD&item_number=&residence_country=CA&test_ipn=1&handling_amount=0.00&transaction_subject=329399666784397397111454941678&payment_gross=&shipping=2.00','Verified'),(20,1,'584986817153397111489517812224','9DL94025LU2724208','Completed','&module=EComm&section=IPN&page=&mc_gross=154.64&protection_eligibility=Eligible&address_status=confirmed&payer_id=GEUY2KFH8RHE8&tax=9.27&address_street=1 Maire-Victorin&payment_date=08:38:31 Jan 25, 2009 PST&payment_status=Completed&charset=windows-1252&address_zip=M5A 1E1&first_name=Test&mc_fee=4.78&address_country_code=CA&address_name=Test User&notify_version=2.6&custom=584986817153397111489517812224&payer_status=unverified&business=anas_s_1232461915_biz@norex.ca&address_country=Canada&address_city=Toronto&quantity=1&verify_sign=AFcWxV21C7fd0v3bYYYRCpSSRl31A1rdl7GF1AtTS7KLIJ694yDQYbaG&payer_email=anas_b_1232461939_per@norex.ca&txn_id=9DL94025LU2724208&payment_type=instant&last_name=User&address_state=Ontario&receiver_email=anas_s_1232461915_biz@norex.ca&payment_fee=&receiver_id=DGVE4VBNQ46NN&txn_type=web_accept&item_name=&mc_currency=CAD&item_number=&residence_country=CA&test_ipn=1&handling_amount=0.00&transaction_subject=584986817153397111489517812224&payment_gross=&shipping=13.00','Verified'),(21,1,'216186364546161236784713267357','2E019249VF377572B','Completed','&module=EComm&section=IPN&page=&mc_gross=110.66&protection_eligibility=Eligible&address_status=confirmed&payer_id=GEUY2KFH8RHE8&tax=7.17&address_street=1 Maire-Victorin&payment_date=08:42:42 Jan 25, 2009 PST&payment_status=Completed&charset=windows-1252&address_zip=M5A 1E1&first_name=Test&mc_fee=3.51&address_country_code=CA&address_name=Test User&notify_version=2.6&custom=216186364546161236784713267357&payer_status=unverified&business=anas_s_1232461915_biz@norex.ca&address_country=Canada&address_city=Toronto&quantity=1&verify_sign=An5ns1Kso7MWUdW4ErQKJJJ4qi4-Awm6ke7GCqRf6WKY2-TI1vEuOY-Y&payer_email=anas_b_1232461939_per@norex.ca&txn_id=2E019249VF377572B&payment_type=instant&last_name=User&address_state=Ontario&receiver_email=anas_s_1232461915_biz@norex.ca&payment_fee=&receiver_id=DGVE4VBNQ46NN&txn_type=web_accept&item_name=&mc_currency=CAD&item_number=&residence_country=CA&test_ipn=1&handling_amount=0.00&transaction_subject=216186364546161236784713267357&payment_gross=&shipping=1.00','Verified');
/*!40000 ALTER TABLE `ecomm_paypal_ipn` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_product`
--

LOCK TABLES `ecomm_product` WRITE;
/*!40000 ALTER TABLE `ecomm_product` DISABLE KEYS */;
INSERT INTO `ecomm_product` VALUES (1,'product 122',1,6,12,1,1,22,99.99,'2009-01-14 13:32:01','2009-01-15 17:51:21',1,'<p>just a test product</p>'),(2,'1234',1,6,12,1,2,28,99.99,'2009-01-14 13:40:19','2009-01-23 14:32:42',1,'<p>test</p>'),(3,'iPod',2,9,14,2,10,0,99.99,'2009-01-14 13:45:07','2009-01-15 20:00:06',1,'<p>Nano iPod</p>'),(4,'hi there',1,5,14,2,10,30,99.99,'2009-01-14 14:14:52','2009-01-14 18:15:14',1,'<p>just a test</p>'),(5,'hi there',1,5,14,2,10,31,99.99,'2009-01-14 14:14:52','2009-01-14 18:18:29',1,'<p>just a test</p>'),(6,'Pants',1,10,12,1,1,38,19.99,'2009-01-14 19:50:01','2009-01-24 19:25:06',1,'<p>These pants are for men</p>\r\n<p>only men can wear them</p>'),(103,'soccer ball',1,12,12,1,10,50,4.99,'2009-01-24 15:35:55','2009-01-24 19:36:47',1,''),(104,'1122',1,6,12,1,12,51,29.99,'2009-01-24 15:36:54','2009-01-24 19:37:16',1,''),(105,'painting',1,6,12,1,8,52,49.99,'2009-01-24 15:37:19','2009-01-24 19:38:29',1,''),(106,'abc',1,6,12,1,1,58,0.99,'2009-01-24 15:38:48','2009-01-24 19:39:00',1,''),(107,'def',1,6,12,1,3,59,99.99,'2009-01-24 15:39:02','2009-01-24 19:39:16',1,''),(108,'def',1,6,12,1,3,60,99.99,'2009-01-24 15:39:02','2009-01-24 19:44:04',1,''),(109,'mp3 song',1,6,12,1,2,61,0.99,'2009-01-25 10:06:35','2009-01-25 14:07:08',1,''),(110,'mp3 song2',1,6,12,1,23,62,1.99,'2009-01-25 10:07:09','2009-01-25 14:07:26',1,'');
/*!40000 ALTER TABLE `ecomm_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ecomm_product_alternative_image`
--

DROP TABLE IF EXISTS `ecomm_product_alternative_image`;
CREATE TABLE `ecomm_product_alternative_image` (
  `id` int(11) NOT NULL auto_increment,
  `product` int(11) NOT NULL default '0',
  `image` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_product_alternative_image`
--

LOCK TABLES `ecomm_product_alternative_image` WRITE;
/*!40000 ALTER TABLE `ecomm_product_alternative_image` DISABLE KEYS */;
INSERT INTO `ecomm_product_alternative_image` VALUES (4,2,48),(2,2,45),(5,2,49),(6,105,53),(7,105,54),(8,105,55),(9,105,56),(10,105,57);
/*!40000 ALTER TABLE `ecomm_product_alternative_image` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `ecomm_product_type`
--

LOCK TABLES `ecomm_product_type` WRITE;
/*!40000 ALTER TABLE `ecomm_product_type` DISABLE KEYS */;
INSERT INTO `ecomm_product_type` VALUES (12,'Physical Products',39,'2009-01-13 21:21:40','2009-01-15 12:56:52',1,'<p>Physical products that require shipping</p>'),(14,'Virtual Products',40,'2009-01-13 21:28:30','2009-01-15 12:58:32',1,'<p>Products that can be downloaded</p>\r\n<p>No shipping required</p>');
/*!40000 ALTER TABLE `ecomm_product_type` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_session`
--

LOCK TABLES `ecomm_session` WRITE;
/*!40000 ALTER TABLE `ecomm_session` DISABLE KEYS */;
INSERT INTO `ecomm_session` VALUES (22,'127.0.0.1',1,9,'','','2009-01-18 14:26:37'),(23,'127.0.0.1',1,10,'','','2009-01-18 14:27:53'),(24,'127.0.0.1',1,1,'','','2009-01-18 15:54:19'),(25,'127.0.0.1',1,9,'','','2009-01-18 15:54:47'),(26,'127.0.0.1',1,10,'','','2009-01-18 15:55:15'),(27,'127.0.0.1',1,11,'','','2009-01-18 15:56:22'),(28,'127.0.0.1',1,1,'','','2009-01-18 15:57:01'),(29,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-18 23:24:03'),(30,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 14:18:27'),(31,'127.0.0.1',1,1,'','','2009-01-19 19:47:41'),(34,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 23:19:47'),(33,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 23:04:30'),(35,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 23:21:49'),(36,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 23:31:27'),(37,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 23:36:35'),(38,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 23:48:28'),(39,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-19 23:52:03'),(40,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-20 14:27:39'),(41,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-20 18:28:26'),(42,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-20 18:30:38'),(43,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-21 13:56:41'),(44,'127.0.0.1',1,1,'FedEx','Paypal','2009-01-23 16:49:56'),(45,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 15:18:40'),(46,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 15:19:16'),(47,'216.113.191.33',1,0,'','','2009-01-25 15:26:12'),(48,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 15:27:08'),(49,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 15:38:09'),(50,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 15:43:42'),(51,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 15:47:21'),(52,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 15:54:15'),(53,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 16:37:03'),(54,'127.0.0.1',1,1,'CanadaPost','Paypal','2009-01-25 16:38:18'),(55,'127.0.0.1',1,18,'CanadaPost','Paypal','2009-01-25 16:52:03');
/*!40000 ALTER TABLE `ecomm_session` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_supplier`
--

LOCK TABLES `ecomm_supplier` WRITE;
/*!40000 ALTER TABLE `ecomm_supplier` DISABLE KEYS */;
INSERT INTO `ecomm_supplier` VALUES (1,'test',0,'2009-01-14 09:45:05','2009-01-14 13:45:55',1,'<p>test</p>'),(2,'123',18,'2009-01-14 09:45:16','2009-01-14 13:45:25',1,'<p>123456</p>');
/*!40000 ALTER TABLE `ecomm_supplier` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_tax_class`
--

LOCK TABLES `ecomm_tax_class` WRITE;
/*!40000 ALTER TABLE `ecomm_tax_class` DISABLE KEYS */;
INSERT INTO `ecomm_tax_class` VALUES (1,'Taxable goods','2009-01-14 10:55:38','2009-01-23 16:42:32',1,'<p>test</p>'),(2,'test2','2009-01-14 10:55:44','2009-01-14 14:55:51',0,'<p>sdfasdf</p>');
/*!40000 ALTER TABLE `ecomm_tax_class` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_tax_rate`
--

LOCK TABLES `ecomm_tax_rate` WRITE;
/*!40000 ALTER TABLE `ecomm_tax_rate` DISABLE KEYS */;
INSERT INTO `ecomm_tax_rate` VALUES (5,31,7,1,7.00,'2009-01-18 14:43:39','2009-01-20 18:28:07','<p>another tax value</p>'),(4,31,7,2,14.00,'2009-01-14 12:10:57','2009-01-20 18:28:00','<p>just a test for a tax rate haha</p>');
/*!40000 ALTER TABLE `ecomm_tax_rate` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_transaction`
--

LOCK TABLES `ecomm_transaction` WRITE;
/*!40000 ALTER TABLE `ecomm_transaction` DISABLE KEYS */;
INSERT INTO `ecomm_transaction` VALUES (9,'',0,0,'','','','','','','','','','','',0,0,0,0,'','','Paypal','2009-01-21 17:42:58','','Failed'),(10,'575788297749321545273792966874',45,1,'+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',147.47,10.32,3,160.79,'127.0.0.1','CanadaPost','Paypal','2009-01-25 15:19:16','',''),(11,'',0,0,'','','','','','','','','','','',0,0,0,0,'','','','2009-01-25 15:26:12','','The user has not paid for what they ordered, hacking attempt'),(12,'128919712431198184121917217313',46,1,'+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',307.47,21.52,3,331.99,'127.0.0.1','CanadaPost','Paypal','2009-01-25 15:27:08','','The user has not paid for what they ordered, hacking attempt'),(13,'449841674693553772482545868633',48,1,'+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',109.47,7.66,3,120.13,'127.0.0.1','CanadaPost','Paypal','2009-01-25 15:38:09','','The user has not paid for what they ordered. Amont paid is: 120.13 CAD Amount required is: 140.13 CAD'),(14,'473268255229666356943516876279',49,1,'+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',112.96,7.91,4,124.87,'127.0.0.1','CanadaPost','Paypal','2009-01-25 15:43:42','','The user has not paid for what they ordered. Amont paid is: 124.87 CAD Amount required is: 124.870002747 CAD'),(16,'793236563972817293288334624349',51,1,'+1(902) 237-6541','211 - ','ghj,','b3m','Nova Scotia','Canada','test','halifax','bem3n9','Alberta','Afghanistan',102.49,7.17,1,110.66,'127.0.0.1','CanadaPost','Paypal','2009-01-25 15:54:15','','');
/*!40000 ALTER TABLE `ecomm_transaction` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecomm_user_details`
--

LOCK TABLES `ecomm_user_details` WRITE;
/*!40000 ALTER TABLE `ecomm_user_details` DISABLE KEYS */;
INSERT INTO `ecomm_user_details` VALUES (2,10,'+1(902)237-6541',517,516),(3,1,'+1(902) 237-6541',518,519),(4,9,'',0,0),(5,11,'',0,0),(6,12,'',0,0),(7,0,'',0,0),(8,15,'',0,0),(9,16,'',0,0),(10,17,'',0,0),(11,18,'',0,0);
/*!40000 ALTER TABLE `ecomm_user_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-01-26 14:08:47
