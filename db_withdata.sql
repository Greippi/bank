-- MySQL dump 10.13  Distrib 5.5.24, for Win64 (x86)
--
-- Host: localhost    Database: bank
-- ------------------------------------------------------
-- Server version	5.5.24

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `balance` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`),
  KEY `fk_owner` (`account_id`),
  CONSTRAINT `fk_owner` FOREIGN KEY (`account_id`) REFERENCES `user` (`accountid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,3960),(2,3111),(3,3000.34);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `account_id` int(11) NOT NULL,
  `originator` varchar(45) NOT NULL,
  `session` varchar(45) NOT NULL,
  `valid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`account_id`,`originator`),
  UNIQUE KEY `session_UNIQUE` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `account` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `reference` varchar(30) NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(45) NOT NULL DEFAULT '',
  `done` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`),
  UNIQUE KEY `transaction_id_UNIQUE` (`transaction_id`),
  KEY `fk_account` (`account`),
  CONSTRAINT `fk_account` FOREIGN KEY (`account`) REFERENCES `account` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (22,1,1,'5048413f81572',100,'ATM','2012-09-06 06:22:55'),(23,1,1,'50484200badad',-100,'ATM','2012-09-06 06:26:08'),(24,1,1,'5048420d0c265',-100,'ATM','2012-09-06 06:26:21'),(25,1,1,'504842a39e09d',-100,'ATM','2012-09-06 06:28:51'),(26,1,1,'504842b16dd40',-100,'ATM','2012-09-06 06:29:05'),(27,1,1,'504852f667fcb',-100,'ATM withdraw','2012-09-06 07:38:30'),(28,1,1,'5048530b05666',-100,'ATM withdraw','2012-09-06 07:38:51'),(29,1,1,'504861a1bc3ae',-100,'ATM withdraw','2012-09-06 08:41:05'),(30,1,1,'50486661ba837',-100,'ATM withdraw','2012-09-06 09:01:21'),(31,1,1,'504866a8c66df',-100,'ATM withdraw','2012-09-06 09:02:32'),(32,1,1,'5048697e6062f',-100,'ATM withdraw','2012-09-06 09:14:38'),(33,1,1,'5048698d0f816',-100,'ATM withdraw','2012-09-06 09:14:53'),(34,1,1,'504869b01c485',-100,'ATM withdraw','2012-09-06 09:15:28'),(35,1,1,'504887a8c395f',-100,'ATM withdraw','2012-09-06 11:23:20'),(36,1,1,'504887b73ae27',-100,'ATM withdraw','2012-09-06 11:23:35'),(37,1,1,'50488800d8a7f',-100,'ATM withdraw','2012-09-06 11:24:48'),(38,1,1,'504888124e827',-100,'ATM withdraw','2012-09-06 11:25:06'),(39,1,1,'50488840ba14f',-100,'ATM withdraw','2012-09-06 11:25:52'),(40,1,1,'504888d157b34',-100,'ATM withdraw','2012-09-06 11:28:17'),(41,1,1,'50488a953651e',-100,'ATM withdraw','2012-09-06 11:35:49'),(42,1,1,'50488b5611802',-100,'ATM withdraw','2012-09-06 11:39:02'),(43,1,1,'50488c6216c1e',-100,'ATM withdraw','2012-09-06 11:43:30'),(44,1,1,'50488eade4292',-100,'ATM withdraw','2012-09-06 11:53:17'),(45,1,1,'50488eb6aa38b',-100,'ATM withdraw','2012-09-06 11:53:26'),(46,1,1,'50488ebaba1bf',-100,'ATM withdraw','2012-09-06 11:53:30'),(47,1,1,'50488ef32b713',-100,'ATM withdraw','2012-09-06 11:54:27'),(48,1,1,'50488ef6d7fb1',-100,'ATM withdraw','2012-09-06 11:54:30'),(49,1,1,'50488f2205282',-100,'ATM withdraw','2012-09-06 11:55:14'),(50,1,1,'50488f6379403',-100,'ATM withdraw','2012-09-06 11:56:19'),(51,1,1,'50488fb63b574',-100,'ATM withdraw','2012-09-06 11:57:42'),(52,1,1,'50488ff45a881',-100,'ATM withdraw','2012-09-06 11:58:44'),(53,1,1,'50488ff7ef966',-100,'ATM withdraw','2012-09-06 11:58:47'),(54,1,1,'5048908e24505',-100,'ATM withdraw','2012-09-06 12:01:18'),(55,1,1,'5048912c1e2df',-100,'ATM withdraw','2012-09-06 12:03:56'),(56,1,1,'504891605d8f5',-100,'ATM withdraw','2012-09-06 12:04:48'),(57,1,1,'504891a4c5852',-100,'ATM withdraw','2012-09-06 12:05:56'),(58,1,1,'504891bc9ac86',-100,'ATM withdraw','2012-09-06 12:06:20'),(59,1,1,'504892bcd9fa8',-100,'ATM withdraw','2012-09-06 12:10:36'),(60,1,1,'5048944db1778',0,'ATM withdraw','2012-09-06 12:17:17'),(61,1,1,'504896e0c8f0b',0,'ATM withdraw','2012-09-06 12:28:16'),(62,1,1,'50489722a776d',0,'ATM withdraw','2012-09-06 12:29:22'),(63,1,1,'504899b1cd585',0,'ATM withdraw','2012-09-06 12:40:17'),(64,1,1,'504899c5b6574',0,'ATM withdraw','2012-09-06 12:40:37'),(65,1,1,'504899f2597f8',0,'ATM withdraw','2012-09-06 12:41:22'),(66,1,1,'50489a1db50f5',0,'ATM withdraw','2012-09-06 12:42:05'),(67,1,1,'50489a4d710c8',0,'ATM withdraw','2012-09-06 12:42:53'),(68,1,1,'50489a6f220b9',0,'ATM withdraw','2012-09-06 12:43:27'),(69,1,1,'50489a83d70d6',0,'ATM withdraw','2012-09-06 12:43:47'),(70,1,1,'50489a98b69f2',0,'ATM withdraw','2012-09-06 12:44:08'),(71,1,1,'50489ab66dd84',0,'ATM withdraw','2012-09-06 12:44:38'),(72,1,1,'50489ad65911b',0,'ATM withdraw','2012-09-06 12:45:10'),(73,1,1,'50489b8a047a6',0,'ATM withdraw','2012-09-06 12:48:10'),(74,1,1,'504992bb5d2c6',0,'ATM withdraw','2012-09-07 06:22:51'),(75,1,1,'5049930ba5247',-100,'ATM withdraw','2012-09-07 06:24:11'),(76,1,1,'504993286c98e',-100,'ATM withdraw','2012-09-07 06:24:40'),(77,1,1,'5049ab9c6b4d9',-100,'ATM withdraw','2012-09-07 08:09:00'),(78,1,1,'5049ad240eaac',-100,'ATM withdraw','2012-09-07 08:15:32'),(79,1,1,'5049ad413d9e2',-100,'ATM withdraw','2012-09-07 08:16:01'),(80,1,1,'5049ae29acc89',-100,'ATM withdraw','2012-09-07 08:19:53'),(81,1,1,'5049ae9838d3e',-1,'ATM withdraw','2012-09-07 08:21:44'),(82,1,1,'5049aee537cc2',-1,'ATM withdraw','2012-09-07 08:23:01'),(83,1,1,'5049af0da789b',-1,'ATM withdraw','2012-09-07 08:23:41'),(84,1,1,'5049b38455f16',-20,'ATM withdraw','2012-09-07 08:42:44'),(85,1,1,'5049b3b1ba7cc',-20,'ATM withdraw','2012-09-07 08:43:29'),(86,1,1,'5049b3bca45c6',-20,'ATM withdraw','2012-09-07 08:43:40'),(87,1,1,'5049b3beb4f3e',-20,'ATM withdraw','2012-09-07 08:43:42'),(88,1,1,'5049b97756472',-20,'ATM withdraw','2012-09-07 09:08:07'),(89,1,1,'5049b99dba517',-20,'ATM withdraw','2012-09-07 09:08:45'),(90,1,1,'5049b9c2d7fbe',-20,'ATM withdraw','2012-09-07 09:09:22'),(91,1,1,'5049bfc1a0e42',-20,'ATM withdraw','2012-09-07 09:34:57'),(92,1,1,'5049bfc713a44',-20,'ATM withdraw','2012-09-07 09:35:03'),(93,1,1,'5049bfcbcb8fe',-20,'ATM withdraw','2012-09-07 09:35:07'),(94,1,1,'5049bfce10ae1',-20,'ATM withdraw','2012-09-07 09:35:10'),(95,1,1,'5049bfd04217a',-20,'ATM withdraw','2012-09-07 09:35:12'),(96,1,1,'5049bffc8ea96',-20,'ATM withdraw','2012-09-07 09:35:56'),(97,1,1,'5049c04f0be06',-20,'ATM withdraw','2012-09-07 09:37:19'),(98,1,1,'5049c11d42ddf',-20,'ATM withdraw','2012-09-07 09:40:45'),(99,1,1,'5049c125d4d4c',-20,'ATM withdraw','2012-09-07 09:40:53'),(100,1,1,'5049c1286430a',-20,'ATM withdraw','2012-09-07 09:40:56'),(101,1,1,'5049c12a44d41',-20,'ATM withdraw','2012-09-07 09:40:58'),(104,1,1,'504dbcaed9955',-20,'ATM withdraw','2012-09-10 10:10:54'),(105,1,1,'504dc474ee532',-20,'ATM withdraw','2012-09-10 10:44:04'),(106,2,2,'504dca1019911',-500,'reppana is withdraw 500 amount credits.','2012-09-10 11:08:00'),(107,2,2,'504dca17d0d82',1500,'reppana is depositing 1500 amount credits.','2012-09-10 11:08:07'),(108,1,2,'505315a429fc4',-200,'ATM withdraw','2012-09-14 11:31:48'),(109,1,2,'505315cab6804',-200,'ATM withdraw','2012-09-14 11:32:26'),(110,1,2,'505315d5021f4',-200,'ATM withdraw','2012-09-14 11:32:37'),(111,1,2,'50570b305962a',-200,'ATM withdraw','2012-09-17 11:36:16'),(112,1,2,'50570b4f13857',-200,'ATM withdraw','2012-09-17 11:36:47');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `passwordsalt` varchar(45) NOT NULL,
  `loginname` varchar(45) NOT NULL,
  `passwordhash` varchar(45) NOT NULL,
  `accountid` int(11) NOT NULL,
  `salt` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `loginname` (`loginname`),
  KEY `account_id` (`accountid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Mary','Doe','e10adc3949ba59abbe56e057f20f883e','x','9dd4e461268c8034f5c8564e155c67a6',1,''),(2,'John','Doe','e10adc3949ba59abbe56e057f20f883e','y','415290769594460e2e485922904f345d',2,' '),(3,'Stan','Doe','e10adc3949ba59abbe56e057f20f883e','z','fbade9e36a3f36d3d676c1b808451dd7',3,' ');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-09-17 15:04:17
