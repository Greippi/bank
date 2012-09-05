-- MySQL dump 10.13  Distrib 5.5.24, for Win64 (x86)
--
-- Host: localhost    Database: vault
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
  `owner` varchar(45) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,34.56,'John Doe'),(2,2000000,'Money Inc'),(3,3000.34,'Mary Doe');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (4,1,2,'1',-100.45,'Rent','2012-09-05 07:14:05'),(5,2,3,'2',-5007.23,'Holiday trip','2012-09-05 07:14:05'),(6,1,1,'3',-100.23,'Gas bill','2012-09-05 07:14:05'),(7,2,2,'4',10000.5,'Stock sales','2012-09-05 08:21:11'),(8,3,6,'5',300.45,'Xmart inc','2012-09-05 08:22:09'),(9,1,1,'50474b0f8fdae',-100,'ATM','2012-09-05 12:52:31'),(10,1,1,'50474b5510f0d',-100,'ATM','2012-09-05 12:53:41'),(11,1,1,'50474b7202311',-100,'ATM','2012-09-05 12:54:10'),(12,1,1,'50474c1097e71',-100,'ATM','2012-09-05 12:56:48'),(13,1,1,'50474c1306645',-100,'ATM','2012-09-05 12:56:51'),(14,1,1,'50474c156fa95',-100,'ATM','2012-09-05 12:56:53'),(15,1,1,'50474c179ce12',-100,'ATM','2012-09-05 12:56:55'),(16,1,1,'50474c19e2913',-100,'ATM','2012-09-05 12:56:57'),(17,1,1,'50474d90e81da',-100,'ATM','2012-09-05 13:03:12'),(18,1,1,'50474da47a73b',-100,'ATM','2012-09-05 13:03:32');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

-- Dump completed on 2012-09-05 16:05:37
