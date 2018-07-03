-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 192.168.99.100    Database: cmaxs
-- ------------------------------------------------------
-- Server version	5.7.22

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
-- Table structure for table `m_billing_method`
--

DROP TABLE IF EXISTS `m_billing_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_billing_method` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `month_billing` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `month` tinyint(2) NOT NULL,
  `unit` tinyint(1) NOT NULL DEFAULT '0',
  `method` tinyint(1) DEFAULT NULL,
  `currency_id` bigint(20) DEFAULT NULL,
  `link_temple` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `charge` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_billing_method`
--

LOCK TABLES `m_billing_method` WRITE;
/*!40000 ALTER TABLE `m_billing_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_billing_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_company`
--

DROP TABLE IF EXISTS `m_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_company` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nation_id` bigint(20) NOT NULL,
  `postal_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `head_office_address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `represent_person` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fund` double(20,2) DEFAULT NULL,
  `employees_number` int(5) DEFAULT NULL,
  `year_research` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_method_id` bigint(20) NOT NULL,
  `month_billing` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_deadline_no` int(2) DEFAULT NULL,
  `billing_day_no` int(2) DEFAULT NULL,
  `currency_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `ope_person_name_1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ope_position_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_department_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_postal_code_1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_address_1` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_phone_1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_fax_1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_email_1` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `ope_person_name_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_position_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_department_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_postal_code_2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_address_2` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_phone_2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_fax_2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_email_2` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ope_company_id` bigint(20) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_company`
--

LOCK TABLES `m_company` WRITE;
/*!40000 ALTER TABLE `m_company` DISABLE KEYS */;
INSERT INTO `m_company` VALUES (1,'CTY 1','Com 1',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',1,'1',0,'1','2018-06-26 08:43:41',NULL,NULL),(2,'CTY 2','Com 2',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',2,'1',0,'1','2018-06-26 08:43:41',NULL,NULL),(3,'CTY 3','Com 3',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',3,'1',0,'1','2018-06-26 08:43:41',NULL,NULL),(4,'CTY 4','Com 4',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',4,'1',0,'1','2018-06-26 08:43:41',NULL,NULL),(5,'CTY 5','Com 5',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',5,'1',0,'1','2018-06-26 08:43:41',NULL,NULL),(6,'CTY 6','Com 6',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',1,'1',0,'1','2018-06-26 08:43:41',NULL,NULL),(7,'CTY 7','Com 7',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',2,'1',0,'1','2018-06-26 08:43:41',NULL,NULL);
/*!40000 ALTER TABLE `m_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_company_operation`
--

DROP TABLE IF EXISTS `m_company_operation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_company_operation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nation_id` bigint(20) NOT NULL DEFAULT '0',
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `language` tinyint(1) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_company_operation`
--

LOCK TABLES `m_company_operation` WRITE;
/*!40000 ALTER TABLE `m_company_operation` DISABLE KEYS */;
INSERT INTO `m_company_operation` VALUES (1,'RIKKEI','RIKKEI',2,'123',1,0,'1','2018-06-26 08:47:07',NULL,NULL),(2,'IBM','IBM',1,'123123',1,0,'1','2018-06-26 08:47:07',NULL,NULL),(3,'BMC','BMC',1,'123123',1,0,'1','2018-06-26 08:47:07',NULL,NULL),(4,'FPT','FPT',2,'12312',1,0,'1','2018-06-26 08:47:07',NULL,NULL),(5,'ENCLAVE','ENCLAVE',3,'123123',1,0,'1','2018-06-26 08:47:07',NULL,NULL);
/*!40000 ALTER TABLE `m_company_operation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_contract`
--

DROP TABLE IF EXISTS `m_contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_contract` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `revision_number` double(3,1) DEFAULT NULL,
  `ship_id` bigint(20) DEFAULT NULL,
  `service_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_contract`
--

LOCK TABLES `m_contract` WRITE;
/*!40000 ALTER TABLE `m_contract` DISABLE KEYS */;
INSERT INTO `m_contract` VALUES (1,1.0,1,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL),(2,1.0,1,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL),(4,1.0,2,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL),(5,1.0,2,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL),(6,1.0,3,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL),(7,1.0,4,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL),(8,1.0,5,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL),(9,1.0,8,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(10,1.0,5,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(11,1.0,1,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(12,1.0,6,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(13,1.0,7,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(14,1.0,7,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(15,1.0,8,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(16,1.0,6,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(17,1.0,7,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(18,1.0,1,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(19,1.0,1,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(20,1.0,1,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(21,1.0,2,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(22,1.0,2,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(23,1.0,3,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(24,1.0,4,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(25,1.0,5,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(26,1.0,8,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(27,1.0,5,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(28,1.0,4,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(29,1.0,6,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(30,1.0,7,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(31,1.0,7,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(32,1.0,8,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(33,1.0,6,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(34,1.0,7,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:06',NULL,NULL),(35,1.0,1,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 09:02:05',NULL,NULL);
/*!40000 ALTER TABLE `m_contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_currency`
--

DROP TABLE IF EXISTS `m_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_currency` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_jp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rate` double(8,4) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_currency`
--

LOCK TABLES `m_currency` WRITE;
/*!40000 ALTER TABLE `m_currency` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_nation`
--

DROP TABLE IF EXISTS `m_nation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_nation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `iso_number` int(5) NOT NULL,
  `iso_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name_jp` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `currency_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_nation`
--

LOCK TABLES `m_nation` WRITE;
/*!40000 ALTER TABLE `m_nation` DISABLE KEYS */;
INSERT INTO `m_nation` VALUES (1,123,'123','Japan','jappan','123',0,'1','2018-06-26 08:44:49',NULL,NULL),(2,123,'21','VietNam','VietNam','1231',0,'1','2018-06-26 08:44:49',NULL,NULL),(3,123,'123','USA','America','123',0,'1','2018-06-26 08:44:49',NULL,NULL);
/*!40000 ALTER TABLE `m_nation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_service`
--

DROP TABLE IF EXISTS `m_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_service` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_short` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `version_max` double(5,2) NOT NULL,
  `version_min` double(5,2) NOT NULL,
  `version_rev` double(5,2) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_service`
--

LOCK TABLES `m_service` WRITE;
/*!40000 ALTER TABLE `m_service` DISABLE KEYS */;
INSERT INTO `m_service` VALUES (1,'SPIC','SPIC EN','SPIC',123.00,1.00,123.00,0,'1','2018-06-26 08:50:34',NULL,NULL),(2,'PMG','PMG EN','PMG',123.00,1.00,123.00,0,'1','2018-06-26 08:50:34',NULL,NULL),(3,'ABLOG','ABLOG EN','ABLOG',123.00,1.00,123.00,0,'1','2018-06-26 08:50:34',NULL,NULL),(4,'AMG','AMG EN','AMG',123.00,1.00,123.00,0,'1','2018-06-26 08:50:34',NULL,NULL);
/*!40000 ALTER TABLE `m_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_ship`
--

DROP TABLE IF EXISTS `m_ship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_ship` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `imo_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mmsi_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nation_id` bigint(20) NOT NULL,
  `classification_id` bigint(20) DEFAULT NULL,
  `register_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `width` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `water_draft` int(10) NOT NULL,
  `total_weight_ton` int(10) NOT NULL,
  `weight_ton` int(10) NOT NULL,
  `member_number` int(5) NOT NULL,
  `url_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_ship`
--

LOCK TABLES `m_ship` WRITE;
/*!40000 ALTER TABLE `m_ship` DISABLE KEYS */;
INSERT INTO `m_ship` VALUES (1,'SHIP 1',1,'imo1','mmsi1',1,1,'123',1,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL),(2,'SHIP 2',2,'imo1','mmsi1',3,2,'12',5,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL),(3,'SHIP 3',3,'imo1','mmsi1',2,4,'123',2,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL),(4,'SHIP 4',1,'imo1','mmsi1',1,2,'123',1,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL),(5,'SHIP 5',4,'imo1','mmsi1',2,4,'123',5,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL),(6,'SHIP 6',6,'imo1','mmsi1',3,3,'123',3,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL),(7,'SHIP 7',7,'imo1','mmsi1',2,1,'123',1,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL),(8,'SHIP 8',5,'imo1','mmsi1',1,1,'453',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 08:56:11',NULL,NULL);
/*!40000 ALTER TABLE `m_ship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_ship_classification`
--

DROP TABLE IF EXISTS `m_ship_classification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_ship_classification` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name_jp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_ship_classification`
--

LOCK TABLES `m_ship_classification` WRITE;
/*!40000 ALTER TABLE `m_ship_classification` DISABLE KEYS */;
INSERT INTO `m_ship_classification` VALUES (1,'c1','class1','class1',0,'1','2018-06-26 08:52:00',NULL,NULL),(2,'c2','class2','class2',0,'1','2018-06-26 08:52:00',NULL,NULL),(3,'c3','class3','class3',0,'1','2018-06-26 08:52:00',NULL,NULL),(4,'c4','class4','class4',0,'1','2018-06-26 08:52:00',NULL,NULL);
/*!40000 ALTER TABLE `m_ship_classification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_ship_type`
--

DROP TABLE IF EXISTS `m_ship_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_ship_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_ship_type`
--

LOCK TABLES `m_ship_type` WRITE;
/*!40000 ALTER TABLE `m_ship_type` DISABLE KEYS */;
INSERT INTO `m_ship_type` VALUES (1,'t1','type1',0,'1','2018-06-26 08:52:48',NULL,NULL),(2,'t2','type2',0,'1','2018-06-26 08:52:48',NULL,NULL),(3,'t3','type3',0,'1','2018-06-26 08:52:48',NULL,NULL),(4,'t4','type4',0,'1','2018-06-26 08:52:48',NULL,NULL),(5,'t5','type5',0,'1','2018-06-26 08:52:48',NULL,NULL);
/*!40000 ALTER TABLE `m_ship_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_spot`
--

DROP TABLE IF EXISTS `m_spot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_spot` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `charge` double(20,2) DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_spot`
--

LOCK TABLES `m_spot` WRITE;
/*!40000 ALTER TABLE `m_spot` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_spot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_detail_history_usage`
--

DROP TABLE IF EXISTS `t_detail_history_usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_detail_history_usage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `history_usage_id` bigint(20) NOT NULL,
  `charge_type_id` tinyint(1) NOT NULL,
  `detail_charge_type_id` tinyint(1) NOT NULL,
  `month_usage` date NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_id` bigint(20) NOT NULL,
  `money_billing` double(20,2) DEFAULT NULL,
  `money` double(20,2) DEFAULT NULL,
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_detail_history_usage`
--

LOCK TABLES `t_detail_history_usage` WRITE;
/*!40000 ALTER TABLE `t_detail_history_usage` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_detail_history_usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_discount_common`
--

DROP TABLE IF EXISTS `t_discount_common`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_discount_common` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `setting_month` date NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `money_discount` double(20,2) NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_discount_common`
--

LOCK TABLES `t_discount_common` WRITE;
/*!40000 ALTER TABLE `t_discount_common` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_discount_common` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_discount_individual`
--

DROP TABLE IF EXISTS `t_discount_individual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_discount_individual` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contract_id` bigint(20) NOT NULL,
  `setting_month` date NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `money_discount` double(20,2) NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_discount_individual`
--

LOCK TABLES `t_discount_individual` WRITE;
/*!40000 ALTER TABLE `t_discount_individual` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_discount_individual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_history_billing`
--

DROP TABLE IF EXISTS `t_history_billing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_history_billing` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `claim_date` date NOT NULL,
  `billing_method_id` bigint(20) NOT NULL,
  `payment_due_date` date NOT NULL,
  `billing_day_no` int(2) NOT NULL,
  `payment_actual_date` date DEFAULT NULL,
  `currency_id` bigint(20) NOT NULL,
  `total_amount_billing` double(20,2) DEFAULT NULL,
  `total_money` double(20,2) DEFAULT NULL,
  `ope_company_id` bigint(20) NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf_original_link` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_history_billing`
--

LOCK TABLES `t_history_billing` WRITE;
/*!40000 ALTER TABLE `t_history_billing` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_history_billing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_history_usage`
--

DROP TABLE IF EXISTS `t_history_usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_history_usage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ship_id` bigint(20) NOT NULL,
  `month_usage` date NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `total_month_billing` double(20,2) DEFAULT NULL,
  `total_money` double(20,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billed_flag` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_history_usage`
--

LOCK TABLES `t_history_usage` WRITE;
/*!40000 ALTER TABLE `t_history_usage` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_history_usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_price_service`
--

DROP TABLE IF EXISTS `t_price_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_price_service` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `price` double(20,2) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_price_service`
--

LOCK TABLES `t_price_service` WRITE;
/*!40000 ALTER TABLE `t_price_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_price_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_ship_spot`
--

DROP TABLE IF EXISTS `t_ship_spot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ship_spot` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ship_id` bigint(20) NOT NULL,
  `month_usage` date NOT NULL,
  `spot_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `amount_charge` double(20,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_ship_spot`
--

LOCK TABLES `t_ship_spot` WRITE;
/*!40000 ALTER TABLE `t_ship_spot` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_ship_spot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_user_login`
--

DROP TABLE IF EXISTS `t_user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user_login` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ope_company_id` bigint(20) NOT NULL,
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `authority_create` tinyint(1) NOT NULL DEFAULT '0',
  `authority_approve` tinyint(1) NOT NULL DEFAULT '0',
  `authority_reference` tinyint(1) NOT NULL DEFAULT '0',
  `operation` tinyint(1) NOT NULL DEFAULT '0',
  `login_id` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_user_login`
--

LOCK TABLES `t_user_login` WRITE;
/*!40000 ALTER TABLE `t_user_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_user_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_volume_discount`
--

DROP TABLE IF EXISTS `t_volume_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_volume_discount` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) NOT NULL,
  `cl_number` int(4) NOT NULL,
  `money_discount` double(20,2) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_volume_discount`
--

LOCK TABLES `t_volume_discount` WRITE;
/*!40000 ALTER TABLE `t_volume_discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_volume_discount` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-26 17:50:26
