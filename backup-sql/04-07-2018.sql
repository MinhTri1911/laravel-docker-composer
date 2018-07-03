/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.30-MariaDB : Database - cmaxs-demo-1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cmaxs-demo-1` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `cmaxs-demo-1`;

/*Table structure for table `m_billing_method` */

DROP TABLE IF EXISTS `m_billing_method`;

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

/*Data for the table `m_billing_method` */

/*Table structure for table `m_company` */

DROP TABLE IF EXISTS `m_company`;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `m_company` */

insert  into `m_company`(`id`,`name_jp`,`name_en`,`nation_id`,`postal_code`,`head_office_address`,`represent_person`,`fund`,`employees_number`,`year_research`,`billing_method_id`,`month_billing`,`payment_deadline_no`,`billing_day_no`,`currency_code`,`currency_id`,`ope_person_name_1`,`ope_position_1`,`ope_department_1`,`ope_postal_code_1`,`ope_address_1`,`ope_phone_1`,`ope_fax_1`,`ope_email_1`,`ope_person_name_2`,`ope_position_2`,`ope_department_2`,`ope_postal_code_2`,`ope_address_2`,`ope_phone_2`,`ope_fax_2`,`ope_email_2`,`ope_company_id`,`url`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'CTY 1','Com 1',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',1,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(2,'CTY 2','Com 2',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',2,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(3,'CTY 3','Com 3',2,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',3,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(4,'CTY 4','Com 4',3,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',4,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(5,'CTY 5','Com 5',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',5,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(6,'CTY 6','Com 6',3,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',1,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(7,'CTY 7','Com 7',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',2,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(8,'CTY 8','Com 8',2,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',2,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(9,'CTY 9','Com 9',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',2,'1',0,'1','2018-06-26 15:43:41',NULL,NULL),(10,'CTY 10','Com 10',1,'123','123345','4234',123.00,123123,'123',1,'1',1,1,'1',1,'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',2,'1',0,'1','2018-06-26 15:43:41',NULL,NULL);

/*Table structure for table `m_company_operation` */

DROP TABLE IF EXISTS `m_company_operation`;

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

/*Data for the table `m_company_operation` */

insert  into `m_company_operation`(`id`,`name`,`short_name`,`nation_id`,`address`,`language`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'RIKKEI','RIKKEI',2,'123',1,0,'1','2018-06-26 15:47:07',NULL,NULL),(2,'IBM','IBM',1,'123123',1,0,'1','2018-06-26 15:47:07',NULL,NULL),(3,'BMC','BMC',1,'123123',1,0,'1','2018-06-26 15:47:07',NULL,NULL),(4,'FPT','FPT',2,'12312',1,0,'1','2018-06-26 15:47:07',NULL,NULL),(5,'ENCLAVE','ENCLAVE',3,'123123',1,0,'1','2018-06-26 15:47:07',NULL,NULL);

/*Table structure for table `m_contract` */

DROP TABLE IF EXISTS `m_contract`;

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `m_contract` */

insert  into `m_contract`(`id`,`revision_number`,`ship_id`,`service_id`,`currency_id`,`start_date`,`end_date`,`status`,`remark`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,1.0,1,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(2,1.0,1,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(4,1.0,2,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(5,1.0,2,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(6,1.0,3,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(7,1.0,4,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(8,1.0,5,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(9,1.0,10,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(10,1.0,5,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(11,1.0,1,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(12,1.0,6,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(13,1.0,7,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(14,1.0,7,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(15,1.0,10,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(16,1.0,6,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(17,1.0,7,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(18,1.0,1,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(19,1.0,8,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(20,1.0,8,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(21,1.0,9,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(22,1.0,10,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(23,1.0,3,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(24,1.0,4,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(25,1.0,5,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(26,1.0,8,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(27,1.0,5,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(28,1.0,4,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(29,1.0,6,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(30,1.0,7,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(31,1.0,11,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(32,1.0,8,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(33,1.0,6,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(34,1.0,14,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(35,1.0,9,4,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:05',NULL,NULL),(36,1.0,11,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(37,1.0,12,1,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(38,1.0,12,2,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL),(39,1.0,12,3,1,'2018-01-11','2019-01-11',0,'213123','1','2018-06-26 16:02:06',NULL,NULL);

/*Table structure for table `m_currency` */

DROP TABLE IF EXISTS `m_currency`;

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

/*Data for the table `m_currency` */

/*Table structure for table `m_nation` */

DROP TABLE IF EXISTS `m_nation`;

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

/*Data for the table `m_nation` */

insert  into `m_nation`(`id`,`iso_number`,`iso_code`,`name_jp`,`name_en`,`currency_code`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,123,'123','Japan','jappan','123',0,'1','2018-06-26 15:44:49',NULL,NULL),(2,123,'21','VietNam','VietNam','1231',0,'1','2018-06-26 15:44:49',NULL,NULL),(3,123,'123','USA','America','123',0,'1','2018-06-26 15:44:49',NULL,NULL);

/*Table structure for table `m_service` */

DROP TABLE IF EXISTS `m_service`;

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

/*Data for the table `m_service` */

insert  into `m_service`(`id`,`name_jp`,`name_en`,`name_short`,`version_max`,`version_min`,`version_rev`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'SPIC','SPIC EN','SPIC',123.00,1.00,123.00,0,'1','2018-06-26 15:50:34',NULL,NULL),(2,'PMG','PMG EN','PMG',123.00,1.00,123.00,0,'1','2018-06-26 15:50:34',NULL,NULL),(3,'ABLOG','ABLOG EN','ABLOG',123.00,1.00,123.00,0,'1','2018-06-26 15:50:34',NULL,NULL),(4,'AMG','AMG EN','AMG',123.00,1.00,123.00,0,'1','2018-06-26 15:50:34',NULL,NULL);

/*Table structure for table `m_ship` */

DROP TABLE IF EXISTS `m_ship`;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `m_ship` */

insert  into `m_ship`(`id`,`name`,`company_id`,`imo_number`,`mmsi_number`,`nation_id`,`classification_id`,`register_number`,`type_id`,`width`,`height`,`water_draft`,`total_weight_ton`,`weight_ton`,`member_number`,`url_1`,`url_2`,`url_3`,`remark`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'SHIP 1',1,'imo1','mmsi1',1,1,'123',1,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(2,'SHIP 2',2,'imo1','mmsi1',3,2,'12',5,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(3,'SHIP 3',3,'imo1','mmsi1',2,4,'123',2,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(4,'SHIP 4',1,'imo1','mmsi1',1,2,'123',1,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(5,'SHIP 5',4,'imo1','mmsi1',2,4,'123',5,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(6,'SHIP 6',6,'imo1','mmsi1',3,3,'123',3,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(7,'SHIP 7',7,'imo1','mmsi1',2,1,'123',1,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(8,'SHIP 8',5,'imo1','mmsi1',1,1,'453',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-06-26 15:56:11',NULL,NULL),(9,'SHIP 9',8,'imo1','mmsi1',1,1,'456',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-07-03 19:32:45',NULL,NULL),(10,'SHIP 10',8,'imo1','mmsi1',1,1,'456',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-07-03 19:33:29',NULL,NULL),(11,'SHIP 11',8,'imo','mmsi1',2,1,'123',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-07-03 19:35:21',NULL,NULL),(12,'SHIP 12',9,'imo','mmsi1',2,1,'123',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-07-03 19:36:14',NULL,NULL),(13,'SHIP 13',9,'imo','mmsi1',2,1,'123',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-07-03 19:36:27',NULL,NULL),(14,'SHIP 14',10,'imo','mmsi1',2,1,'123',4,12,12,0,0,0,0,'0','0','0','123',0,'1','2018-07-03 19:36:53',NULL,NULL);

/*Table structure for table `m_ship_classification` */

DROP TABLE IF EXISTS `m_ship_classification`;

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

/*Data for the table `m_ship_classification` */

insert  into `m_ship_classification`(`id`,`code`,`name_jp`,`name_en`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'c1','class1','class1',0,'1','2018-06-26 15:52:00',NULL,NULL),(2,'c2','class2','class2',0,'1','2018-06-26 15:52:00',NULL,NULL),(3,'c3','class3','class3',0,'1','2018-06-26 15:52:00',NULL,NULL),(4,'c4','class4','class4',0,'1','2018-06-26 15:52:00',NULL,NULL);

/*Table structure for table `m_ship_type` */

DROP TABLE IF EXISTS `m_ship_type`;

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

/*Data for the table `m_ship_type` */

insert  into `m_ship_type`(`id`,`code`,`type`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'t1','type1',0,'1','2018-06-26 15:52:48',NULL,NULL),(2,'t2','type2',0,'1','2018-06-26 15:52:48',NULL,NULL),(3,'t3','type3',0,'1','2018-06-26 15:52:48',NULL,NULL),(4,'t4','type4',0,'1','2018-06-26 15:52:48',NULL,NULL),(5,'t5','type5',0,'1','2018-06-26 15:52:48',NULL,NULL);

/*Table structure for table `m_spot` */

DROP TABLE IF EXISTS `m_spot`;

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

/*Data for the table `m_spot` */

/*Table structure for table `t_detail_history_usage` */

DROP TABLE IF EXISTS `t_detail_history_usage`;

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

/*Data for the table `t_detail_history_usage` */

/*Table structure for table `t_discount_common` */

DROP TABLE IF EXISTS `t_discount_common`;

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

/*Data for the table `t_discount_common` */

/*Table structure for table `t_discount_individual` */

DROP TABLE IF EXISTS `t_discount_individual`;

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

/*Data for the table `t_discount_individual` */

/*Table structure for table `t_history_billing` */

DROP TABLE IF EXISTS `t_history_billing`;

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

/*Data for the table `t_history_billing` */

/*Table structure for table `t_history_usage` */

DROP TABLE IF EXISTS `t_history_usage`;

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

/*Data for the table `t_history_usage` */

/*Table structure for table `t_price_service` */

DROP TABLE IF EXISTS `t_price_service`;

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

/*Data for the table `t_price_service` */

/*Table structure for table `t_ship_spot` */

DROP TABLE IF EXISTS `t_ship_spot`;

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

/*Data for the table `t_ship_spot` */

/*Table structure for table `t_user_login` */

DROP TABLE IF EXISTS `t_user_login`;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `t_user_login` */

insert  into `t_user_login`(`id`,`name`,`ope_company_id`,`department`,`position`,`authority_create`,`authority_approve`,`authority_reference`,`operation`,`login_id`,`password`,`type`,`del_flag`,`created_by`,`created_at`,`updated_by`,`updated_at`) values (1,'Lorna Abernathy',1,'mKLDGSDaupjanT5ObGYe','q2c9GwCJHfqroKdFHjtHwwV3hs9MnTXG4YdwpF0DMUZkEasbLj',0,0,0,0,'admin1','$2y$10$RtUqLwzGf3zYHsdcJuTCHeQLo9XnIhkpWgFQIXT7UimRIBQSZf1f6',0,0,'1','2018-07-03 12:46:06',NULL,'2018-07-03 12:46:06'),(2,'Doyle Ratke III',1,'s7OX0wRDvJJVvbFnon2S','6YIk3U0wtR8qgRZViIGpbjgolqQOgJdl3gPe0dBOxAfENknNGf',0,0,0,0,'admin2','$2y$10$XMh.VR5/Nabr9Cl2SkS5AOh.w91KkUfBDVIUeDuVi0zfDdFiYfEAm',0,0,'1','2018-07-03 12:46:06',NULL,'2018-07-03 12:46:06'),(3,'Dr. Napoleon Kiehn DVM',1,'1m1OzQyXYtxtD52gNGJO','eHl74ELJ63geDUvYkCrL1P9On0MFh9tYZ62ZRixo0IRj1QWKH2',0,0,0,0,'admin3','$2y$10$wMmGbztKNnRBjzfTBGzZK.l78nSZCsV6vMGAMzHbC2TIpHv.WV.UC',0,0,'1','2018-07-03 12:46:06',NULL,'2018-07-03 12:46:06'),(4,'Daniella Schowalter',1,'hSVBlCE0rRzx5bv3s6cl','A94k4YeFsHIOdEEREyvU5iGaPUhtQPk8fDj4X2sIJuMIruAgtw',0,0,0,0,'admin4','$2y$10$Dl.LoFoSpQY4ChWapMPV2OxoO.e.OCpcPKbBg2KHhKhoqcO66Q81G',0,0,'1','2018-07-03 12:46:06',NULL,'2018-07-03 12:46:06'),(5,'Dr. Margarete Rempel',1,'i5RarMLjbxhZBjdyt5eH','YLnIAqIvfj6nTpNxErl7e4bvR719obLrRxu2bOkdiqKnRjJpVX',0,0,0,0,'admin5','$2y$10$jdMYu9.smA7KxoYMes9E0u7unVGYQ66FQkNCDMxYtP2Slu6dirgIG',0,0,'1','2018-07-03 12:46:07',NULL,'2018-07-03 12:46:07'),(6,'Audreanne Grant',1,'9Z8gLwJCxQj8KehEzKWz','PehEuLZmBB13KL88jQHJ9dGdiBTSU8iBSddN5LNi3WqVVyBh0g',0,0,0,0,'admin6','$2y$10$XgO/LNFAH96Do3H/b568YOCcWq3fYXTdWqPwzYnBId/3W7INMAt0u',0,0,'1','2018-07-03 12:46:07',NULL,'2018-07-03 12:46:07'),(7,'Ella Harber',1,'IrqhbX4z31Vdt45WEFqx','BDz36OAnT8oTPomqQQPb5CBdiXn4VCHR2rAM0qWSLUMQIoedMF',0,0,0,0,'admin7','$2y$10$OmfXsoms36e5/ML7Lp1ivuTeN6ToIL7SB1Yr1o.E1wSJxircc7gxi',0,0,'1','2018-07-03 12:46:07',NULL,'2018-07-03 12:46:07'),(8,'Miss Della Littel',1,'YlUfVjYlN2Xmy3zGoBaX','IN9WkbJTlScpTsPG5KKEwqqpqGzfNJyI1cdQaPwycxALTXWgsN',0,0,0,0,'admin8','$2y$10$Zh2heb0eLLJus9QmI4a66unNs80urX4MQWOZbC0LUEBufB5mqieRm',0,0,'1','2018-07-03 12:46:07',NULL,'2018-07-03 12:46:07'),(9,'Blaze Kertzmann',1,'KFM4ckaBnQMjPty5NblA','epyC8BinhHAVjsDJNazcn2VOUhAG9HJMzXvPQRsdKN95LVHcVP',0,0,0,0,'admin9','$2y$10$I19K.KEg27YPxVLGxX9hPu52BcsX.BcO1ukgY5YADjlVdZVG.pMrm',0,0,'1','2018-07-03 12:46:07',NULL,'2018-07-03 12:46:07');

/*Table structure for table `t_volume_discount` */

DROP TABLE IF EXISTS `t_volume_discount`;

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

/*Data for the table `t_volume_discount` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
