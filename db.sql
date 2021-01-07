-- MySQL dump 10.13  Distrib 5.7.30, for FreeBSD12.1 (amd64)
--
-- Host: localhost    Database: garbage_managment
-- ------------------------------------------------------
-- Server version	5.7.29-log

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED='d92b2d87-4dc5-11ea-af02-000e0ca46406:1-720';

--
-- Table structure for table `bin`
--

DROP TABLE IF EXISTS `bin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bin` (
  `id_bin` int(11) NOT NULL AUTO_INCREMENT,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL,
  `alert` int(11) NOT NULL,
  `washDate` date NOT NULL,
  PRIMARY KEY (`id_bin`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bin`
--

LOCK TABLES `bin` WRITE;
/*!40000 ALTER TABLE `bin` DISABLE KEYS */;
/*!40000 ALTER TABLE `bin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logfiles`
--

DROP TABLE IF EXISTS `logfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=691 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logfiles`
--

LOCK TABLES `logfiles` WRITE;
/*!40000 ALTER TABLE `logfiles` DISABLE KEYS */;
INSERT INTO `logfiles` VALUES (689,'109.178.151.162',7,'2020-07-24 12:18:05','105'),(690,'109.178.151.162',0,'2020-07-24 12:18:12','102');
/*!40000 ALTER TABLE `logfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mails`
--

DROP TABLE IF EXISTS `mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mails` (
  `name` varchar(30) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `subject` tinytext,
  `message` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mails`
--

LOCK TABLES `mails` WRITE;
/*!40000 ALTER TABLE `mails` DISABLE KEYS */;
/*!40000 ALTER TABLE `mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bin_id` int(11) NOT NULL,
  `bin_contend` int(30) DEFAULT NULL,
  `bins_humidity` int(30) DEFAULT NULL,
  `bins_temperature` int(30) DEFAULT NULL,
  `button` int(1) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bin_id` (`bin_id`),
  CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`bin_id`) REFERENCES `bin` (`id_bin`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `age` int(10) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `role` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `reset` varchar(12) NOT NULL,
  `rememberMe` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-24 15:21:05
