/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.30-MariaDB : Database - cmaxs-demo-2
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cmaxs-demo-2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `cmaxs-demo-2`;

/*Table structure for table `m_billing_method` */

DROP TABLE IF EXISTS `m_billing_method`;

CREATE TABLE `m_billing_method` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month_billing` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` tinyint(3) unsigned NOT NULL,
  `unit` tinyint(3) unsigned NOT NULL,
  `method` tinyint(3) unsigned NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `charge` double(20,2) NOT NULL,
  `link_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_billing_method` */

/*Table structure for table `m_company` */

DROP TABLE IF EXISTS `m_company`;

CREATE TABLE `m_company` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nation_id` bigint(20) NOT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_office_address` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `represent_person` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fund` double(20,2) DEFAULT NULL,
  `employees_number` int(10) unsigned DEFAULT NULL,
  `year_research` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_method_id` bigint(20) NOT NULL,
  `month_billing` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_deadline_no` int(10) unsigned DEFAULT NULL,
  `billing_day_no` int(10) unsigned DEFAULT NULL,
  `currency_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `ope_person_name_1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ope_position_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_department_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_postal_code_1` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_address_1` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_phone_1` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_fax_1` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_email_1` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ope_person_name_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_position_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_department_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_postal_code_2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_address_2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_phone_2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_fax_2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_email_2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ope_company_id` bigint(20) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_company` */

insert  into `m_company`(`id`,`name_jp`,`name_en`,`nation_id`,`postal_code`,`head_office_address`,`represent_person`,`fund`,`employees_number`,`year_research`,`billing_method_id`,`month_billing`,`payment_deadline_no`,`billing_day_no`,`currency_code`,`currency_id`,`ope_person_name_1`,`ope_position_1`,`ope_department_1`,`ope_postal_code_1`,`ope_address_1`,`ope_phone_1`,`ope_fax_1`,`ope_email_1`,`ope_person_name_2`,`ope_position_2`,`ope_department_2`,`ope_postal_code_2`,`ope_address_2`,`ope_phone_2`,`ope_fax_2`,`ope_email_2`,`ope_company_id`,`url`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'\r\nA社','Company A',112,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.A',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ1',NULL,NULL,NULL,NULL,NULL,NULL,'email1@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,NULL,NULL,NULL,NULL),(2,'\r\nB社','Company B',112,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.B',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ2',NULL,NULL,NULL,NULL,NULL,NULL,'email2@yahoo.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,0,NULL,NULL,NULL,NULL),(3,'\r\nC社','Company C',200,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.Obama',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ3',NULL,NULL,NULL,NULL,NULL,NULL,'aloha@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,0,NULL,NULL,NULL,NULL),(4,'\r\nD社','Company D',46,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.Obama1',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ4',NULL,NULL,NULL,NULL,NULL,NULL,'obama@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,0,NULL,NULL,NULL,NULL),(5,'\r\nE社','Company E',112,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.Obama2',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ5',NULL,NULL,NULL,NULL,NULL,NULL,'obama1@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,0,NULL,NULL,NULL,NULL),(6,'\r\nAA社','Company AA',112,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.Obama3',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ6',NULL,NULL,NULL,NULL,NULL,NULL,'obama2@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,0,NULL,NULL,NULL,NULL),(7,'\r\nAB社','Company AB',46,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.Obama4',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ7',NULL,NULL,NULL,NULL,NULL,NULL,'o.ba.ma@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,NULL,NULL,NULL,NULL),(8,'\r\nBC社','Company BC',46,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.BC',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ8',NULL,NULL,NULL,NULL,NULL,NULL,'o.ba.ma@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,0,NULL,NULL,NULL,NULL),(9,'\r\nABC社','Company ABC',200,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.ABC',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ9',NULL,NULL,NULL,NULL,NULL,NULL,'emai3@yahoo.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,NULL,NULL,NULL,NULL),(10,'\r\nCBAD社','Company CBAD',200,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.CBAD',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ10',NULL,NULL,NULL,NULL,NULL,NULL,'email4@yahoo.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,0,NULL,NULL,NULL,NULL),(11,'\r\nAAA社','Company AAA',112,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','MR.AAA',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ11',NULL,NULL,NULL,NULL,NULL,NULL,'email5@yahoo.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,0,NULL,NULL,NULL,NULL),(12,'\r\nBBB社','Company BBB',112,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','Ms.BBB',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ12',NULL,NULL,NULL,NULL,NULL,NULL,'email6@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,NULL,0,NULL,NULL,NULL,NULL),(13,'\r\nBBA社','Company BBA',3,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','Ms.ABCAB',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ13',NULL,NULL,NULL,NULL,NULL,NULL,'email7@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,0,NULL,NULL,NULL,NULL),(14,'\r\nDDCB社','Company DDCB',2,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','Ms.Obama1',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ14',NULL,NULL,NULL,NULL,NULL,NULL,'email8@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,NULL,NULL,NULL,NULL),(15,'\rABEC社','Company ABEC',1,NULL,'東京都港区芝浦4-13-23 MS芝浦ビル','Ms.Obama2',NULL,NULL,NULL,0,'',NULL,NULL,'',0,'氏オバマ15',NULL,NULL,NULL,NULL,NULL,NULL,'email9@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,NULL,0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_company_operation` */

DROP TABLE IF EXISTS `m_company_operation`;

CREATE TABLE `m_company_operation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nation_id` bigint(20) NOT NULL,
  `address` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` tinyint(1) NOT NULL DEFAULT '0',
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_company_operation` */

insert  into `m_company_operation`(`id`,`name`,`short_name`,`nation_id`,`address`,`language`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'ClassNKコンサルティングサービス','NKCS',1,'',0,0,NULL,NULL,NULL,NULL),(2,'株式会社IMC','IMC',1,'',0,0,NULL,NULL,NULL,NULL),(3,'Japan Marine United Singapore Pte. Ltd.','JMUS',1,'',0,0,NULL,NULL,NULL,NULL),(4,'石川島船舶工程有限公司','IMCS',3,'',0,0,NULL,NULL,NULL,NULL),(5,'IMBV b.v.','IMBV',3,'',0,0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_contract` */

DROP TABLE IF EXISTS `m_contract`;

CREATE TABLE `m_contract` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `revision_number` double(3,1) DEFAULT NULL,
  `ship_id` bigint(20) NOT NULL,
  `service_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `approved_flag` tinyint(4) NOT NULL DEFAULT '2',
  `reason_reject` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_contract` */

insert  into `m_contract`(`id`,`revision_number`,`ship_id`,`service_id`,`currency_id`,`start_date`,`end_date`,`status`,`approved_flag`,`reason_reject`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,1.0,1,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(2,1.0,1,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(3,1.0,2,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(4,1.0,2,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(5,1.0,2,3,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(6,1.0,3,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(7,1.0,3,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(8,1.0,4,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(9,1.0,4,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(10,1.0,5,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(11,1.0,5,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(12,1.0,6,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(13,1.0,6,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(14,1.0,7,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(15,1.0,7,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(16,1.0,7,3,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(17,1.0,8,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(18,1.0,8,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(19,1.0,9,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(20,1.0,10,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(21,1.0,11,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(22,1.0,12,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(23,1.0,12,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(24,1.0,13,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(25,1.0,13,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(26,1.0,13,3,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(27,1.0,14,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(28,1.0,14,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(29,1.0,15,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(30,1.0,15,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(31,1.0,16,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(32,1.0,17,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(33,1.0,17,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(34,1.0,18,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(35,1.0,19,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(36,1.0,20,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(37,1.0,21,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(38,1.0,21,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(39,1.0,22,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(40,1.0,22,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(41,1.0,22,3,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(42,1.0,23,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(43,1.0,23,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(44,1.0,23,3,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(45,1.0,24,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(46,1.0,24,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(47,1.0,24,3,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(48,1.0,25,1,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(49,1.0,25,2,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL),(50,1.0,1,3,0,'2019-07-28','2019-06-29',0,1,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `m_currency` */

DROP TABLE IF EXISTS `m_currency`;

CREATE TABLE `m_currency` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_jp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,4) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_currency` */

/*Table structure for table `m_nation` */

DROP TABLE IF EXISTS `m_nation`;

CREATE TABLE `m_nation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_number` int(10) unsigned NOT NULL,
  `iso_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_jp` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_nation` */

insert  into `m_nation`(`id`,`code`,`iso_number`,`iso_code`,`name_jp`,`name_en`,`currency_code`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'',4,'AFG','アフガニスタン・イスラム共和国','Afghanistan','AFN\r',0,NULL,NULL,NULL,NULL),(2,'',248,'ALA','オーランド諸島','Aland Islands','EUR\r',0,NULL,NULL,NULL,NULL),(3,'',8,'ALB','アルバニア共和国','Albania','ALL\r',0,NULL,NULL,NULL,NULL),(4,'',12,'DZA','アルジェリア民主人民共和国','Algeria','DZD\r',0,NULL,NULL,NULL,NULL),(5,'',16,'ASM','米領サモア','American Samoa','WST\r',0,NULL,NULL,NULL,NULL),(6,'',20,'AND','アンドラ公国','Andorra','EUR\r',0,NULL,NULL,NULL,NULL),(7,'',24,'AGO','アンゴラ共和国','Angola','AOA\r',0,NULL,NULL,NULL,NULL),(8,'',660,'AIA','アンギラ','Anguilla','XCD\r',0,NULL,NULL,NULL,NULL),(9,'',10,'ATA','南極','Antarctica','',0,NULL,NULL,NULL,NULL),(10,'',28,'ATG','アンティグア・バーブーダ','Antigua and Barbuda','XCD\r',0,NULL,NULL,NULL,NULL),(11,'',32,'ARG','アルゼンチン共和国','Argentina','ARS\r',0,NULL,NULL,NULL,NULL),(12,'',51,'ARM','アルメニア共和国','Armenia','AMD\r',0,NULL,NULL,NULL,NULL),(13,'',533,'ABW','アルバ','Aruba','AWG\r',0,NULL,NULL,NULL,NULL),(14,'',36,'AUS','オーストラリア連邦','Australia','AUD\r',0,NULL,NULL,NULL,NULL),(15,'',40,'AUT','オーストリア共和国','Austria','EUR\r',0,NULL,NULL,NULL,NULL),(16,'',31,'AZE','アゼルバイジャン共和国','Azerbaijan','AZN\r',0,NULL,NULL,NULL,NULL),(17,'',44,'BHS','バハマ国','Bahamas','BSD\r',0,NULL,NULL,NULL,NULL),(18,'',48,'BHR','バーレーン王国','Bahrain','BHD\r',0,NULL,NULL,NULL,NULL),(19,'',50,'BGD','バングラデシュ人民共和国','Bangladesh','BDT\r',0,NULL,NULL,NULL,NULL),(20,'',52,'BRB','バルバドス','Barbados','BBD\r',0,NULL,NULL,NULL,NULL),(21,'',112,'BLR','ベラルーシ共和国','Belarus','BYN\r',0,NULL,NULL,NULL,NULL),(22,'',56,'BEL','ベルギー王国','Belgium','EUR\r',0,NULL,NULL,NULL,NULL),(23,'',84,'BLZ','ベリーズ','Belize','BZD\r',0,NULL,NULL,NULL,NULL),(24,'',204,'BEN','ベナン共和国','Benin','XOF\r',0,NULL,NULL,NULL,NULL),(25,'',60,'BMU','バミューダ諸島','Bermuda','BMD\r',0,NULL,NULL,NULL,NULL),(26,'',64,'BTN','ブータン王国','Bhutan','BTN\r',0,NULL,NULL,NULL,NULL),(27,'',68,'BOL','ボリビア多民族国','Bolivia Plurinational State of','BOB\r',0,NULL,NULL,NULL,NULL),(28,'',535,'BES','ボネール、シント・ユースタティウスおよびサバ','Bonaire Saint Eustatius and Sa','USD\r',0,NULL,NULL,NULL,NULL),(29,'',70,'BIH','ボスニア・ヘルツェゴビナ','Bosnia and Herzegovina','BAM\r',0,NULL,NULL,NULL,NULL),(30,'',72,'BWA','ボツワナ共和国','Botswana','BWP\r',0,NULL,NULL,NULL,NULL),(31,'',74,'BVT','ブーベ島','Bouvet Island','NOK\r',0,NULL,NULL,NULL,NULL),(32,'',76,'BRA','ブラジル連邦共和国','Brazil','BRL\r',0,NULL,NULL,NULL,NULL),(33,'',86,'IOT','英領インド洋地域','British Indian Ocean Territory','GBP\r',0,NULL,NULL,NULL,NULL),(34,'',96,'BRN','ブルネイ・ダルサラーム国','Brunei Darussalam','BND\r',0,NULL,NULL,NULL,NULL),(35,'',100,'BGR','ブルガリア共和国','Bulgaria','BGN\r',0,NULL,NULL,NULL,NULL),(36,'',854,'BFA','Faso	ブルキナファソ','Burkina','XOF\r',0,NULL,NULL,NULL,NULL),(37,'',108,'BDI','ブルンジ共和国','Burundi','BIF\r',0,NULL,NULL,NULL,NULL),(38,'',116,'KHM','カンボジア王国','Cambodia','KHR\r',0,NULL,NULL,NULL,NULL),(39,'',120,'CMR','カメルーン共和国','Cameroon','XAF\r',0,NULL,NULL,NULL,NULL),(40,'',124,'CAN','カナダ','Canada','CAD\r',0,NULL,NULL,NULL,NULL),(41,'',132,'CPV','カーボベルデ共和国','Cape Verde','CVE\r',0,NULL,NULL,NULL,NULL),(42,'',136,'CYM','ケイマン諸島','Cayman Islands','KYD\r',0,NULL,NULL,NULL,NULL),(43,'',140,'CAF','中央アフリカ共和国','Central African Republic','XAF\r',0,NULL,NULL,NULL,NULL),(44,'',148,'TCD','チャド共和国','Chad','XAF\r',0,NULL,NULL,NULL,NULL),(45,'',152,'CHL','チリ共和国','Chile','CLP\r',0,NULL,NULL,NULL,NULL),(46,'',156,'CHN','中華人民共和国	','China','NY\r',0,NULL,NULL,NULL,NULL),(47,'',162,'CXR','クリスマス島','Christmas Island','AUD\r',0,NULL,NULL,NULL,NULL),(48,'',166,'CCK','ココス諸島','Cocos (Keeling) Islands','AUD\r',0,NULL,NULL,NULL,NULL),(49,'',170,'COL','コロンビア共和国','Colombia','COP\r',0,NULL,NULL,NULL,NULL),(50,'',174,'COM','コモロ連合','Comoros','KMF\r',0,NULL,NULL,NULL,NULL),(51,'',178,'COG','コンゴ共和国','Congo Republic of the','XAF\r',0,NULL,NULL,NULL,NULL),(52,'',180,'COD','コンゴ民主共和国','Congo Democratic Republic of t','CDF\r',0,NULL,NULL,NULL,NULL),(53,'',184,'COK','クック諸島','Cook Islands','NZD\r',0,NULL,NULL,NULL,NULL),(54,'',188,'CRI','コスタリカ共和国','Costa Rica','CRC\r',0,NULL,NULL,NULL,NULL),(55,'',384,'CIV','コートジボワール共和国','Cote d\'Ivoire','XOF\r',0,NULL,NULL,NULL,NULL),(56,'',191,'HRV','クロアチア共和国','Croatia','HRK\r',0,NULL,NULL,NULL,NULL),(57,'',192,'CUB','キューバ共和国','Cuba','CUC\r',0,NULL,NULL,NULL,NULL),(58,'',531,'CUW','キュラソー','Curacao','ANG\r',0,NULL,NULL,NULL,NULL),(59,'',196,'CYP','キプロス共和国','Cyprus','EUR\r',0,NULL,NULL,NULL,NULL),(60,'',203,'CZE','チェコ共和国','Czech Republic','CZK\r',0,NULL,NULL,NULL,NULL),(61,'',208,'DNK','デンマーク王国','Denmark','DKK\r',0,NULL,NULL,NULL,NULL),(62,'',262,'DJI','ジブチ共和国','Djibouti','DJF\r',0,NULL,NULL,NULL,NULL),(63,'',212,'DMA','ドミニカ国','Dominica','XCD\r',0,NULL,NULL,NULL,NULL),(64,'',214,'DOM','ドミニカ共和国','Dominican Republic','DOP\r',0,NULL,NULL,NULL,NULL),(65,'',218,'ECU','エクアドル共和国','Ecuador','USD\r',0,NULL,NULL,NULL,NULL),(66,'',818,'EGY','エジプト・アラブ共和国','Egypt','EGP\r',0,NULL,NULL,NULL,NULL),(67,'',222,'SLV','エルサルバドル共和国','El Salvador','SVC\r',0,NULL,NULL,NULL,NULL),(68,'',226,'GNQ','赤道ギニア共和国','Equatorial Guinea','XAF\r',0,NULL,NULL,NULL,NULL),(69,'',232,'ERI','エリトリア国','Eritrea','ERN\r',0,NULL,NULL,NULL,NULL),(70,'',233,'EST','エストニア共和国','Estonia','EUR\r',0,NULL,NULL,NULL,NULL),(71,'',231,'ETH','エチオピア連邦民主共和国','Ethiopia','ETB\r',0,NULL,NULL,NULL,NULL),(72,'',238,'FLK','フォークランド(マルビナス)諸島','Falkland Islands (Malvinas)','FKP\r',0,NULL,NULL,NULL,NULL),(73,'',234,'FRO','フェロー諸島','Faroe Islands','DKK\r',0,NULL,NULL,NULL,NULL),(74,'',242,'FJI','フィジー諸島共和国','Fiji','FJD\r',0,NULL,NULL,NULL,NULL),(75,'',246,'FIN','フィンランド共和国','Finland','EUR\r',0,NULL,NULL,NULL,NULL),(76,'',250,'FRA','フランス共和国','France','EUR\r',0,NULL,NULL,NULL,NULL),(77,'',254,'GUF','フランス領ギアナ','French Guiana','EUR\r',0,NULL,NULL,NULL,NULL),(78,'',258,'PYF','フランス領ポリネシア','French Polynesia','XPF\r',0,NULL,NULL,NULL,NULL),(79,'',260,'ATF','フランス領極南諸島','French Southern Territories','XPF\r',0,NULL,NULL,NULL,NULL),(80,'',266,'GAB','ガボン共和国','Gabon','XAF\r',0,NULL,NULL,NULL,NULL),(81,'',270,'GMB','ガンビア共和国','Gambia','GMD\r',0,NULL,NULL,NULL,NULL),(82,'',268,'GEO','グルジア','Georgia','GEL\r',0,NULL,NULL,NULL,NULL),(83,'',276,'DEU','ドイツ連邦共和国','Germany','EUR\r',0,NULL,NULL,NULL,NULL),(84,'',288,'GHA','ガーナ共和国','Ghana','GHC\r',0,NULL,NULL,NULL,NULL),(85,'',292,'GIB','ジブラルタル','Gibraltar','GIP\r',0,NULL,NULL,NULL,NULL),(86,'',300,'GRC','ギリシャ共和国','Greece','EUR\r',0,NULL,NULL,NULL,NULL),(87,'',304,'GRL','グリーンランド','Greenland','DKK\r',0,NULL,NULL,NULL,NULL),(88,'',308,'GRD','グレナダ','Grenada','XCD\r',0,NULL,NULL,NULL,NULL),(89,'',312,'GLP','グアドループ島','Guadeloupe','EUR\r',0,NULL,NULL,NULL,NULL),(90,'',316,'GUM','グアム','Guam','USD\r',0,NULL,NULL,NULL,NULL),(91,'',320,'GTM','グアテマラ共和国','Guatemala','GTQ\r',0,NULL,NULL,NULL,NULL),(92,'',831,'GGY','ガーンジー島','Guernsey','なし\r',0,NULL,NULL,NULL,NULL),(93,'',324,'GIN','ギニア共和国','Guinea','GNF\r',0,NULL,NULL,NULL,NULL),(94,'',624,'GNB','ギニアビサウ共和国','Guinea-Bissau','XOF\r',0,NULL,NULL,NULL,NULL),(95,'',328,'GUY','ガイアナ共和国','Guyana','GYD\r',0,NULL,NULL,NULL,NULL),(96,'',332,'HTI','ハイチ共和国','Haiti','HTG\r',0,NULL,NULL,NULL,NULL),(97,'',334,'HMD','ハード島・マクドナルド諸島','Heard Island and McDonald Isla','AUD\r',0,NULL,NULL,NULL,NULL),(98,'',336,'VAT','バチカン市国','Holy See (Vatican City State)','EUR\r',0,NULL,NULL,NULL,NULL),(99,'',340,'HND','ホンジュラス共和国','Honduras','HNL\r',0,NULL,NULL,NULL,NULL),(100,'',344,'HKG','ホンコン(香港)特別行政区','Hong Kong','HKD\r',0,NULL,NULL,NULL,NULL),(101,'',348,'HUN','ハンガリー共和国','Hungary','HUF\r',0,NULL,NULL,NULL,NULL),(102,'',352,'ISL','イスランド共和国','Iceland	','ISK\r',0,NULL,NULL,NULL,NULL),(103,'',356,'IND','インド','India','INR\r',0,NULL,NULL,NULL,NULL),(104,'',360,'IDN','インドネシア共和国','Indonesia','IDR\r',0,NULL,NULL,NULL,NULL),(105,'',364,'IRN','イラン・イスラム共和国','Iran Islamic Republic of','IRR\r',0,NULL,NULL,NULL,NULL),(106,'',368,'IRQ','イラク共和国','Iraq','IQD\r',0,NULL,NULL,NULL,NULL),(107,'',372,'IRL','アイルランド','Ireland','EUR\r',0,NULL,NULL,NULL,NULL),(108,'',833,'IMN','マン島','Isle of Man','GBP\r',0,NULL,NULL,NULL,NULL),(109,'',376,'ISR','イスラエル国','Israel','ILS\r',0,NULL,NULL,NULL,NULL),(110,'',380,'ITA','イタリア共和国','Italy','EUR\r',0,NULL,NULL,NULL,NULL),(111,'',388,'JAM','ジャマイカ','Jamaica','JMD\r',0,NULL,NULL,NULL,NULL),(112,'',392,'JPN','日本国','Japan','JPY\r',0,NULL,NULL,NULL,NULL),(113,'',832,'JEY','ジャージー島','Jersey','GBP\r',0,NULL,NULL,NULL,NULL),(114,'',400,'JOR','ヨルダン・ハシミテ王国','Jordan','JOD\r',0,NULL,NULL,NULL,NULL),(115,'',398,'KAZ','カザフスタン共和国','Kazakhstan','KZT\r',0,NULL,NULL,NULL,NULL),(116,'',404,'KEN','ケニア共和国','Kenya','KES\r',0,NULL,NULL,NULL,NULL),(117,'',296,'KIR','キリバス共和国','Kiribati','AUD\r',0,NULL,NULL,NULL,NULL),(118,'',408,'PRK','朝鮮民主主義人民共和国','Korea Democratic People\'s Repu','KPW\r',0,NULL,NULL,NULL,NULL),(119,'',410,'KOR','大韓民国','Korea Republic of','KRW\r',0,NULL,NULL,NULL,NULL),(120,'',414,'KWT','クウェート国','Kuwait','KWD\r',0,NULL,NULL,NULL,NULL),(121,'',417,'KGZ','キルギス共和国','Kyrgyzstan','KGS\r',0,NULL,NULL,NULL,NULL),(122,'',418,'LAO','ラオス人民民主共和国','Lao People\'s Democratic Republ','LAK\r',0,NULL,NULL,NULL,NULL),(123,'',428,'LVA','ラトビア共和国','Latvia','EUR\r',0,NULL,NULL,NULL,NULL),(124,'',422,'LBN','レバノン共和国','Lebanon','LBP\r',0,NULL,NULL,NULL,NULL),(125,'',426,'LSO','レソト王国','Lesotho','LSL\r',0,NULL,NULL,NULL,NULL),(126,'',430,'LBR','リベリア共和国','Liberia','LRD\r',0,NULL,NULL,NULL,NULL),(127,'',434,'LBY','リビア','Libya','LYD\r',0,NULL,NULL,NULL,NULL),(128,'',438,'LIE','リヒテンシュタイン公国','Liechtenstein','CHF\r',0,NULL,NULL,NULL,NULL),(129,'',440,'LTU','リトアニア共和国','Lithuania','LTL\r',0,NULL,NULL,NULL,NULL),(130,'',442,'LUX','ルクセンブルク大公国','Luxembourg','EUR\r',0,NULL,NULL,NULL,NULL),(131,'',446,'MAC','マカオ(澳門)特別行政区','Macao','MOP\r',0,NULL,NULL,NULL,NULL),(132,'',807,'MKD','マケドニア旧ユーゴスラビア共和国','Macedonia the former Yugoslav ','MKD\r',0,NULL,NULL,NULL,NULL),(133,'',450,'MDG','マダガスカル共和国','Madagascar','MGA\r',0,NULL,NULL,NULL,NULL),(134,'',454,'MWI','マラウイ共和国','Malawi','MWK\r',0,NULL,NULL,NULL,NULL),(135,'',458,'MYS','マレーシア','Malaysia','MYR\r',0,NULL,NULL,NULL,NULL),(136,'',462,'MDV','モルディブ共和国','Maldives','MVR\r',0,NULL,NULL,NULL,NULL),
(137,'',466,'MLI','マリ共和国','Mali','XOF\r',0,NULL,NULL,NULL,NULL),(138,'',470,'MLT','マルタ共和国','Malta','EUR\r',0,NULL,NULL,NULL,NULL),(139,'',584,'MHL','マーシャル諸島共和国','Marshall Islands','USD\r',0,NULL,NULL,NULL,NULL),(140,'',474,'MTQ','マルチニーク島','Martinique','EUR\r',0,NULL,NULL,NULL,NULL),(141,'',478,'MRT','モーリタニア・イスラム共和国','Mauritania','MRO\r',0,NULL,NULL,NULL,NULL),(142,'',480,'MUS','モーリシャス共和国','Mauritius','MUR\r',0,NULL,NULL,NULL,NULL),(143,'',175,'MYT','マイヨット島','Mayotte','EUR\r',0,NULL,NULL,NULL,NULL),(144,'',484,'MEX','メキシコ合衆国','Mexico','MXN\r',0,NULL,NULL,NULL,NULL),(145,'',583,'FSM','ミクロネシア連邦','Micronesia Federated States of','USD\r',0,NULL,NULL,NULL,NULL),(146,'',498,'MDA','モルドバ共和国','Moldova Republic of','MDL\r',0,NULL,NULL,NULL,NULL),(147,'',492,'MCO','モナコ公国','Monaco','EUR\r',0,NULL,NULL,NULL,NULL),(148,'',496,'MNG','モンゴル国','Mongolia','MNT\r',0,NULL,NULL,NULL,NULL),(149,'',499,'MNE','モンテネグロ','Montenegro','EUR\r',0,NULL,NULL,NULL,NULL),(150,'',500,'MSR','モントセラト','Montserrat','XCD\r',0,NULL,NULL,NULL,NULL),(151,'',504,'MAR','モロッコ王国','Morocco','MAD\r',0,NULL,NULL,NULL,NULL),(152,'',508,'MOZ','モザンビーク共和国','Mozambique','MZN\r',0,NULL,NULL,NULL,NULL),(153,'',104,'MMR','ミャンマー連邦','Myanmar','MMK\r',0,NULL,NULL,NULL,NULL),(154,'',516,'NAM','ナミビア共和国','Namibia','NAD\r',0,NULL,NULL,NULL,NULL),(155,'',520,'NRU','ナウル共和国','Nauru','AUD\r',0,NULL,NULL,NULL,NULL),(156,'',524,'NPL','ネパール連邦民主共和国','Nepal','NPR\r',0,NULL,NULL,NULL,NULL),(157,'',528,'NLD','オランダ王国','Netherlands','EUR\r',0,NULL,NULL,NULL,NULL),(158,'',540,'NCL','ニューカレドニア','New Caledonia','XPF\r',0,NULL,NULL,NULL,NULL),(159,'',554,'NZL','ニュージーランド','New Zealand','NZD\r',0,NULL,NULL,NULL,NULL),(160,'',558,'NIC','ニカラグア共和国','Nicaragua','NIO\r',0,NULL,NULL,NULL,NULL),(161,'',562,'NER','ニジェール共和国','Niger','XOF\r',0,NULL,NULL,NULL,NULL),(162,'',566,'NGA','ナイジェリア連邦共和国','Nigeria','NGN\r',0,NULL,NULL,NULL,NULL),(163,'',570,'NIU','ニウエ','Niue','NZD\r',0,NULL,NULL,NULL,NULL),(164,'',574,'NFK','ノーフォーク島','Norfolk Island','AUD\r',0,NULL,NULL,NULL,NULL),(165,'',580,'MNP','北マリアナ諸島','Northern Mariana Islands','USD\r',0,NULL,NULL,NULL,NULL),(166,'',578,'NOR','ノルウェー王国','Norway','NOK\r',0,NULL,NULL,NULL,NULL),(167,'',512,'OMN','オマーン国','Oman','OMR\r',0,NULL,NULL,NULL,NULL),(168,'',586,'PAK','パキスタン・イスラム共和国','Pakistan','PKR\r',0,NULL,NULL,NULL,NULL),(169,'',585,'PLW','パラオ共和国','Palau','USD\r',0,NULL,NULL,NULL,NULL),(170,'',275,'PSE','西岸・ガザ(パレスチナ自治区)','Palestinian Territory Occupied','JOD\r',0,NULL,NULL,NULL,NULL),(171,'',591,'PAN','パナマ共和国','Panama','PAB\r',0,NULL,NULL,NULL,NULL),(172,'',598,'PNG','パプアニューギニア独立国','Papua New Guinea','PGK\r',0,NULL,NULL,NULL,NULL),(173,'',600,'PRY','パラグアイ共和国','Paraguay','PYG\r',0,NULL,NULL,NULL,NULL),(174,'',604,'PER','ペルー共和国','Peru','PEN\r',0,NULL,NULL,NULL,NULL),(175,'',608,'PHL','フィリピン共和国','Philippines','PHP\r',0,NULL,NULL,NULL,NULL),(176,'',612,'PCN','ピトケアン諸島','Pitcairn','NZD\r',0,NULL,NULL,NULL,NULL),(177,'',616,'POL','ポーランド共和国','Poland','PLN\r',0,NULL,NULL,NULL,NULL),(178,'',620,'PRT','ポルトガル共和国','Portugal','EUR\r',0,NULL,NULL,NULL,NULL),(179,'',630,'PRI','プエルトリコ','Puerto Rico','USD\r',0,NULL,NULL,NULL,NULL),(180,'',634,'QAT','カタール国','Qatar','QAR\r',0,NULL,NULL,NULL,NULL),(181,'',638,'REU','レユニオン','Reunion','EUR\r',0,NULL,NULL,NULL,NULL),(182,'',642,'ROU','ルーマニア','Romania','RON\r',0,NULL,NULL,NULL,NULL),(183,'',643,'RUS','ロシア連邦','Russian Federation','RUB\r',0,NULL,NULL,NULL,NULL),(184,'',646,'RWA','ルワンダ共和国','Rwanda','RWF\r',0,NULL,NULL,NULL,NULL),(185,'',652,'BLM','サンバルテルミー','Saint Barth?lemy','EUR\r',0,NULL,NULL,NULL,NULL),(186,'',654,'SHN','セントヘレナ・アセンション・トリスタンダクーニャ','Saint Helena Ascension and Tri','SHP\r',0,NULL,NULL,NULL,NULL),(187,'',659,'KNA','セントキッツ・ネービス','Saint Kitts and Nevis','XCD\r',0,NULL,NULL,NULL,NULL),(188,'',662,'LCA','セントルシア','Saint Lucia','XCD\r',0,NULL,NULL,NULL,NULL),(189,'',663,'MAF','サンマルタン','Saint Martin (French part)','EUR\r',0,NULL,NULL,NULL,NULL),(190,'',666,'SPM','サンピエール島・ミクロン島','Saint Pierre and Miquelon','EUR\r',0,NULL,NULL,NULL,NULL),(191,'',670,'VCT','セントビンセント・グレナディーン諸島','Saint Vincent and the Grenadin','XCD\r',0,NULL,NULL,NULL,NULL),(192,'',882,'WSM','サモア独立国','Samoa','WST\r',0,NULL,NULL,NULL,NULL),(193,'',674,'SMR','サンマリノ共和国','San Marino','EUR\r',0,NULL,NULL,NULL,NULL),(194,'',678,'STP','サントメ・プリンシペ民主共和国','Sao Tome and Principe','STD\r',0,NULL,NULL,NULL,NULL),(195,'',682,'SAU','サウジアラビア王国','Saudi Arabia','SAR\r',0,NULL,NULL,NULL,NULL),(196,'',686,'SEN','セネガル共和国','Senegal','XOF\r',0,NULL,NULL,NULL,NULL),(197,'',688,'SRB','セルビア共和国','Serbia','RSD\r',0,NULL,NULL,NULL,NULL),(198,'',690,'SYC','セーシェル共和国','Seychelles','SCR\r',0,NULL,NULL,NULL,NULL),(199,'',694,'SLE','シエラレオネ共和国','Sierra Leone','SLL\r',0,NULL,NULL,NULL,NULL),(200,'',702,'SGP','シンガポール共和国','Singapore','SGD\r',0,NULL,NULL,NULL,NULL),(201,'',534,'SXM','シント・マールテン(オランダ領)','Sint Maarten (Dutch part)','ANG\r',0,NULL,NULL,NULL,NULL),(202,'',703,'SVK','スロバキア共和国','Slovakia','EUR\r',0,NULL,NULL,NULL,NULL),(203,'',705,'SVN','スロベニア共和国','Slovenia','EUR\r',0,NULL,NULL,NULL,NULL),(204,'',90,'SLB','ソロモン諸島','Solomon Islands','SBD\r',0,NULL,NULL,NULL,NULL),(205,'',706,'SOM','ソマリア民主共和国','Somalia','SOS\r',0,NULL,NULL,NULL,NULL),(206,'',710,'ZAF','南アフリカ共和国','South Africa','ZAR\r',0,NULL,NULL,NULL,NULL),(207,'',239,'SGS','南ジョージア島・南サンドイッチ諸島','South Georgia and the South Sa','GBP\r',0,NULL,NULL,NULL,NULL),(208,'',728,'SSD','南スーダン','South Sudan','SSP\r',0,NULL,NULL,NULL,NULL),(209,'',724,'ESP','スペイン','Spain','EUR\r',0,NULL,NULL,NULL,NULL),(210,'',144,'LKA','スリランカ民主社会主義共和国','Sri Lanka','LKR\r',0,NULL,NULL,NULL,NULL),(211,'',736,'SDN','スーダン共和国','Sudan','SDG\r',0,NULL,NULL,NULL,NULL),(212,'',740,'SUR','スリナム共和国','Suriname','SRD\r',0,NULL,NULL,NULL,NULL),(213,'',744,'SJM','スバールバル諸島・ヤンマイエン島','Svalbard and Jan Mayen','NOK\r',0,NULL,NULL,NULL,NULL),(214,'',748,'SWZ','スワジランド王国','Swaziland','SZL\r',0,NULL,NULL,NULL,NULL),(215,'',752,'SWE','スウェーデン王国','Sweden','SEK\r',0,NULL,NULL,NULL,NULL),(216,'',756,'CHE','スイス連邦','Switzerland','CHF\r',0,NULL,NULL,NULL,NULL),(217,'',760,'SYR','シリア・アラブ共和国','Syrian Arab Republic','SYP\r',0,NULL,NULL,NULL,NULL),(218,'',158,'TWN','台湾','Taiwan Province of China','TWD\r',0,NULL,NULL,NULL,NULL),(219,'',762,'TJK','タジキスタン共和国','Tajikistan','TJS\r',0,NULL,NULL,NULL,NULL),(220,'',834,'TZA','タンザニア連合共和国','Tanzania United Republic of','TZS\r',0,NULL,NULL,NULL,NULL),(221,'',764,'THA','タイ王国','Thailand','THB\r',0,NULL,NULL,NULL,NULL),(222,'',626,'TLS','東ティモール民主共和国','Timor-Leste','USD\r',0,NULL,NULL,NULL,NULL),(223,'',768,'TGO','トーゴ共和国','Togo','XOF\r',0,NULL,NULL,NULL,NULL),(224,'',772,'TKL','トケラウ諸島','Tokelau','NZD\r',0,NULL,NULL,NULL,NULL),(225,'',776,'TON','トンガ王国','Tonga','TOP\r',0,NULL,NULL,NULL,NULL),(226,'',780,'TTO','トリニダード・トバゴ共和国','Trinidad and Tobago','TTD\r',0,NULL,NULL,NULL,NULL),(227,'',788,'TUN','チュニジア共和国','Tunisia','TND\r',0,NULL,NULL,NULL,NULL),(228,'',792,'TUR','トルコ共和国','Turkey','TRL\r',0,NULL,NULL,NULL,NULL),(229,'',795,'TKM','トルクメニスタン','Turkmenistan','TMM\r',0,NULL,NULL,NULL,NULL),(230,'',796,'TCA','タークス・カイコス諸島','Turks and Caicos Islands','USD\r',0,NULL,NULL,NULL,NULL),(231,'',798,'TUV','ツバル','Tuvalu','なし\r',0,NULL,NULL,NULL,NULL),(232,'',800,'UGA','ウガンダ共和国	','Uganda','GX\r',0,NULL,NULL,NULL,NULL),(233,'',804,'UKR','ウクライナ','Ukraine','UAH\r',0,NULL,NULL,NULL,NULL),(234,'',784,'ARE','アラブ首長国連邦','United Arab Emirates','AED\r',0,NULL,NULL,NULL,NULL),(235,'',826,'GBR','グレートブリテン・北アイルランド連合王国(英国)','United Kingdom','GBP\r',0,NULL,NULL,NULL,NULL),(236,'',840,'USA','アメリカ合衆国','United States','USD\r',0,NULL,NULL,NULL,NULL),(237,'',581,'UMI','米領小離島','United States Minor Outlying I','USD\r',0,NULL,NULL,NULL,NULL),(238,'',858,'URY','ウルグアイ東方共和国','Uruguay','UYU\r',0,NULL,NULL,NULL,NULL),(239,'',860,'UZB','ウズベキスタン共和国','Uzbekistan','UZS\r',0,NULL,NULL,NULL,NULL),(240,'',548,'VUT','バヌアツ共和国','Vanuatu','VUV\r',0,NULL,NULL,NULL,NULL),(241,'',862,'VEN','ベネズエラ・ボリバル共和国','Venezuela Bolivarian Republic ','VEF\r',0,NULL,NULL,NULL,NULL),(242,'',704,'VNM','ベトナム社会主義共和国','Viet Nam','VND\r',0,NULL,NULL,NULL,NULL),(243,'',92,'VGB','英領バージン諸島','Virgin Islands British','USD\r',0,NULL,NULL,NULL,NULL),(244,'',850,'VIR','米領バージン諸島','Virgin Islands U.S.','USD\r',0,NULL,NULL,NULL,NULL),(245,'',876,'WLF','ワリス・フテュナ諸島','Wallis and Futuna','XPF\r',0,NULL,NULL,NULL,NULL),(246,'',732,'ESH','西サハラ','Western Sahara','MAD\r',0,NULL,NULL,NULL,NULL),(247,'',887,'YEM','イエメン共和国','Yemen','YER\r',0,NULL,NULL,NULL,NULL),(248,'',894,'ZMB','ザンビア共和国','Zambia','ZMW\r',0,NULL,NULL,NULL,NULL),(249,'',716,'ZWE','ジンバブエ共和国','Zimbabwe','USD\r',0,NULL,NULL,NULL,NULL),(250,'',999,'ZZZ','その他','Others','',0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_service` */

DROP TABLE IF EXISTS `m_service`;

CREATE TABLE `m_service` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_short` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version_max` double(5,2) NOT NULL,
  `version_min` double(5,2) NOT NULL,
  `version_rev` double(5,2) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_service` */

insert  into `m_service`(`id`,`name_jp`,`name_en`,`name_short`,`version_max`,`version_min`,`version_rev`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'CMAXS保守管理システム PMS','CMAXS Planned Maintenance System','CMAXS PMS',1.00,0.00,0.00,0,NULL,NULL,NULL,NULL),(2,'CMAXS予備品管理システム SPIC','CMAXS Spare Parts Inventory Control System','CMAXS SPICS',1.00,0.00,0.00,0,NULL,NULL,NULL,NULL),(3,'CMAXSアブログ管理システム ABLOG','CMAXS Abstract Log System','CMAXS ABLOG',1.00,0.00,0.00,0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_ship` */

DROP TABLE IF EXISTS `m_ship`;

CREATE TABLE `m_ship` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `imo_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mmsi_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nation_id` bigint(20) NOT NULL,
  `classification_id` bigint(20) NOT NULL,
  `register_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` bigint(20) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `water_draft` int(11) DEFAULT NULL,
  `total_weight_ton` int(11) DEFAULT NULL,
  `total_ton` int(11) DEFAULT NULL,
  `member_number` int(11) DEFAULT NULL,
  `url_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_ship` */

insert  into `m_ship`(`id`,`name`,`company_id`,`imo_number`,`mmsi_number`,`nation_id`,`classification_id`,`register_number`,`type_id`,`width`,`height`,`water_draft`,`total_weight_ton`,`total_ton`,`member_number`,`url_1`,`url_2`,`url_3`,`remark`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'SHIP 1',1,'',NULL,1,1,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(2,'SHIP 2',2,'',NULL,1,2,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(3,'SHIP 3',3,'',NULL,1,3,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(4,'SHIP 4',4,'',NULL,1,4,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(5,'SHIP 5',5,'',NULL,1,5,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(6,'SHIP 6',6,'',NULL,1,6,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(7,'SHIP 7',7,'',NULL,1,7,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(8,'SHIP 8',8,'',NULL,1,8,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(9,'SHIP 9',9,'',NULL,1,9,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(10,'SHIP 10',10,'',NULL,1,10,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(11,'SHIP 11',11,'',NULL,1,11,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(12,'SHIP 12',12,'',NULL,1,12,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(13,'SHIP 13',13,'',NULL,1,1,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(14,'SHIP 14',14,'',NULL,1,2,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(15,'SHIP 15',15,'',NULL,1,3,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(16,'SHIP 16',1,'',NULL,1,4,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(17,'SHIP 17',2,'',NULL,1,5,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(18,'SHIP 18',3,'',NULL,1,6,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(19,'SHIP 19',4,'',NULL,1,7,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(20,'SHIP 20',5,'',NULL,1,8,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(21,'SHIP 21',6,'',NULL,1,9,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(22,'SHIP 22',7,'',NULL,1,10,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(23,'SHIP 23',8,'',NULL,1,11,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(24,'SHIP 24',9,'',NULL,1,12,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(25,'SHIP 25',10,'',NULL,1,1,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(26,'SHIP 26',11,'',NULL,1,2,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(27,'SHIP 27',12,'',NULL,1,3,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(28,'SHIP 28',13,'',NULL,1,4,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(29,'SHIP 29',14,'',NULL,1,5,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(30,'SHIP 30',15,'',NULL,1,6,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_ship_classification` */

DROP TABLE IF EXISTS `m_ship_classification`;

CREATE TABLE `m_ship_classification` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_jp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_ship_classification` */

insert  into `m_ship_classification`(`id`,`code`,`name_jp`,`name_en`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'NK','ClassNK','ClassNK',0,NULL,NULL,NULL,NULL),(2,'LRS','Lloyds Register of Shipping','Lloyds Register of Shipping',0,NULL,NULL,NULL,NULL),(3,'ABS','American Bureau of Shipping','American Bureau of Shipping',0,NULL,NULL,NULL,NULL),(4,'BV','Bureau Veritas','Bureau Veritas',0,NULL,NULL,NULL,NULL),(5,'DNV','DNV GL','DNV GL',0,NULL,NULL,NULL,NULL),(6,'RINA','RINA','RINA',0,NULL,NULL,NULL,NULL),(7,'CCS','China Classificatoin Society','China Classificatoin Society',0,NULL,NULL,NULL,NULL),(8,'IRC','Indian Register of Shipping','Indian Register of Shipping',0,NULL,NULL,NULL,NULL),(9,'PRS','Polish Register of Shipping','Polish Register of Shipping',0,NULL,NULL,NULL,NULL),(10,'RS','Russian Maritime Register of Shipping','Russian Maritime Register of Shipping',0,NULL,NULL,NULL,NULL),(11,'KR','Korean Register','Korean Register',0,NULL,NULL,NULL,NULL),(12,'Korean Reg','Croatian Register of Shipping','Croatian Register of Shipping',0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_ship_type` */

DROP TABLE IF EXISTS `m_ship_type`;

CREATE TABLE `m_ship_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_ship_type` */

insert  into `m_ship_type`(`id`,`code`,`type`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'GCC','General Cargo Carrier',0,NULL,NULL,NULL,NULL),(2,'BCC','Bulk Carrier',0,NULL,NULL,NULL,NULL),(3,'UCC','Container Ship',0,NULL,NULL,NULL,NULL),(4,'OCC','Clude Oil Tanker',0,NULL,NULL,NULL,NULL),(5,'PCC','Pure Car Carrier',0,NULL,NULL,NULL,NULL);

/*Table structure for table `m_spot` */

DROP TABLE IF EXISTS `m_spot`;

CREATE TABLE `m_spot` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_jp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `charge` double(20,2) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `m_spot` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2018_05_11_045952_create_t_history_billing_monthly_table',1),(2,'2018_07_02_025646_create_m_nation_table',1),(3,'2018_07_02_031252_create_m_service_table',1),(4,'2018_07_02_040231_create_m_ship_classification_table',1),(5,'2018_07_02_040356_create_m_ship_type_table',1),(6,'2018_07_02_040447_create_m_spot_table',1),(7,'2018_07_02_040805_create_t_detail_history_usage_table',1),(8,'2018_07_02_042441_create_t_discount_common_table',1),(9,'2018_07_02_042603_create_t_discount_individual_1_table',1),(10,'2018_07_02_042906_create_t_history_billing_1_table',1),(11,'2018_07_02_043821_create_t_history_usage_table',1),(12,'2018_07_02_044303_create_t_price_service_table',1),(13,'2018_07_02_045736_create_t_volume_discount_1_table',1),(14,'2018_07_02_045806_create_m_currency_table',1),(15,'2018_07_02_045848_create_m_billing_method_1_table',1),(16,'2018_07_02_045919_create_m_company_operation_1_table',1),(17,'2018_07_02_050009_create_m_company_1_table',1),(18,'2018_07_02_050045_create_m_contract_1_table',1),(19,'2018_07_02_050110_create_m_ship_1_table',1),(20,'2018_07_02_050141_create_t_ship_spot_1_table',1),(21,'2018_07_02_050210_create_t_user_login_1_table',1);

/*Table structure for table `t_detail_history_usage` */

DROP TABLE IF EXISTS `t_detail_history_usage`;

CREATE TABLE `t_detail_history_usage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `history_usage_id` bigint(20) NOT NULL,
  `charge_type_id` tinyint(4) NOT NULL,
  `detail_charge_type_id` tinyint(4) NOT NULL,
  `month_usage` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint(20) NOT NULL,
  `money_billing` double(20,2) DEFAULT NULL,
  `money` double(20,2) DEFAULT NULL,
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_detail_history_usage` */

/*Table structure for table `t_discount_common` */

DROP TABLE IF EXISTS `t_discount_common`;

CREATE TABLE `t_discount_common` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `setting_month` date NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `money_discount` double(20,2) NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_discount_common` */

/*Table structure for table `t_discount_individual` */

DROP TABLE IF EXISTS `t_discount_individual`;

CREATE TABLE `t_discount_individual` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint(20) NOT NULL,
  `setting_month` date NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `money_discount` double(20,2) NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_discount_individual` */

/*Table structure for table `t_history_billing` */

DROP TABLE IF EXISTS `t_history_billing`;

CREATE TABLE `t_history_billing` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `claim_date` date NOT NULL,
  `billing_method_id` bigint(20) NOT NULL,
  `payment_due_date` date NOT NULL,
  `payment_deadline_no` int(10) unsigned DEFAULT NULL,
  `billing_day_no` int(10) unsigned DEFAULT NULL,
  `payment_actual_date` date DEFAULT NULL,
  `currency_id` bigint(20) NOT NULL,
  `total_amount_billing` double(20,2) DEFAULT NULL,
  `total_money` double(20,2) DEFAULT NULL,
  `ope_company_id` bigint(20) NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_original_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_flag` tinyint(4) NOT NULL DEFAULT '2',
  `reason_reject` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_history_billing` */

/*Table structure for table `t_history_billing_monthly` */

DROP TABLE IF EXISTS `t_history_billing_monthly`;

CREATE TABLE `t_history_billing_monthly` (
  `id` bigint(20) NOT NULL,
  `contract_id` bigint(20) NOT NULL,
  `usage_month` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `history_billing_id` bigint(20) DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_month_billing` double(20,2) DEFAULT NULL,
  `month_usage_charge` double(20,2) DEFAULT NULL,
  `inital_charge` double(20,2) DEFAULT NULL,
  `create_data_cost` double(20,2) DEFAULT NULL,
  `spot_cost` double(20,2) DEFAULT NULL,
  `discount` double(20,2) DEFAULT NULL,
  `notice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_history_billing_monthly` */

/*Table structure for table `t_history_usage` */

DROP TABLE IF EXISTS `t_history_usage`;

CREATE TABLE `t_history_usage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ship_id` bigint(20) NOT NULL,
  `month_usage` date NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `total_amount_billing` double(20,2) DEFAULT NULL,
  `total_money` double(20,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billed_flag` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_history_usage` */

/*Table structure for table `t_price_service` */

DROP TABLE IF EXISTS `t_price_service`;

CREATE TABLE `t_price_service` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `price` double(20,2) NOT NULL,
  `charge_register` double(20,2) NOT NULL DEFAULT '0.00',
  `charge_create_data` double(20,2) NOT NULL DEFAULT '0.00',
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_price_service` */

/*Table structure for table `t_ship_spot` */

DROP TABLE IF EXISTS `t_ship_spot`;

CREATE TABLE `t_ship_spot` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ship_id` bigint(20) NOT NULL,
  `month_usage` date NOT NULL,
  `spot_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `amount_charge` double(20,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_flag` tinyint(4) NOT NULL DEFAULT '2',
  `reason_reject` text COLLATE utf8mb4_unicode_ci,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_ship_spot` */

/*Table structure for table `t_user_login` */

DROP TABLE IF EXISTS `t_user_login`;

CREATE TABLE `t_user_login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ope_company_id` bigint(20) NOT NULL,
  `department` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth_create` tinyint(1) NOT NULL DEFAULT '0',
  `auth_approve` tinyint(1) NOT NULL DEFAULT '0',
  `auth_reference` tinyint(1) NOT NULL DEFAULT '0',
  `auth_admin` tinyint(1) NOT NULL DEFAULT '0',
  `login_id` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_user_login` */

insert  into `t_user_login`(`id`,`name`,`ope_company_id`,`department`,`position`,`auth_create`,`auth_approve`,`auth_reference`,`auth_admin`,`login_id`,`password`,`type`,`del_flag`,`created_by`,`created_at`,`updated_at`,`updated_by`) values (1,'Kanrisha',1,'HlQnxGdNgWCmCXng3FT1','aE0MbVY4nlXGUfWfwaQ6Kad2uCqd3FFJdoX1WtbydWUTSqd738',0,0,0,0,'admin','$2y$10$y45k4s/iZ.K5ExO1G1zsFePOo6d/.uKkc.EQVyIzgZ.Ucn4pTahgG',0,0,NULL,NULL,NULL,NULL),(2,'Cathryn Larson',1,'4BhrPeaOe33Dufl6kGEb','z01qN7QhzVDFkcphRwheIIbP7b2wuucBWKhnhdmMJi7tFX5Qwq',0,0,0,0,'admin1','$2y$10$UjRwB5QzteYrYyYFNSKZr.OLAcc3QbXMw6QIYgyXVTcDteS61TPW2',0,0,'1','2018-07-08 04:43:21','2018-07-08 04:43:21',NULL),(3,'Arianna Schmidt',1,'j9rzJ5MB0TT40PwTZcmZ','d0A68BUm7m3JckCigH1zBUmPlS6rxqfT8RZkTdb4tUncnCyxsD',0,0,0,0,'admin2','$2y$10$T/Zzs690ZvtuujbuYx0xm.sGhWulGFYeqyvrdOYBvirFHLl7SC5Q.',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL),(4,'Boris Glover II',1,'OZ0QmiGimr7qc86kC63N','1V93vYlQ42XTNDxWd0MTrYmPgxEJgJ4eALZpcyk3jebOQkGOK9',0,0,0,0,'admin3','$2y$10$oGADbyxhRQFVV8XM2bFA/OQNnhxBXfH/zh/p6a8zLYbw9rOL56RuK',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL),(5,'Maynard Padberg',1,'0gbOeli43CQbhXjOD6vi','ZSC7pDwEgSjHI9cw1WxsJLXylHXM4BqWn52jNqbBx3t7yP13Ws',0,0,0,0,'admin4','$2y$10$8CoT0mgtTjTOcWasYI7GFOBTZQ2TxBKovDgRu9U3FHjNVsQKe0/lO',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL),(6,'George Simonis',1,'4jF0UvGTlkYiETgJ4xwO','zzJEkOclDxA4whjKCXHikVxHvJBrcuTzh4YqjWxz8QbJIgOeru',0,0,0,0,'admin5','$2y$10$9GTVZ55hje7rrearQVy/5uOtcUlr5y7jJkdCR5jCbmjMULMnFn8wG',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL),(7,'Gianni Zulauf',1,'0jVjjsjpFhqNcJh5IqwB','j0mjrPWHeD7oG9NeBgrrAwJaZ9tEpY8ouFZuihbXpzwkC87Crq',0,0,0,0,'admin6','$2y$10$A9Pbt8YOYlUBUyZKlV.cG.AB7REZJpPzUXCJg0FyLPP46FC8qlIFO',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL),(8,'Dr. John Heathcote II',1,'DWwK1JF6CM6HWSZeHClv','FilKCKK9pjEX6eQj2cqartvW2LKKUvfup07Acql01NkzH3tgkr',0,0,0,0,'admin7','$2y$10$Kdh5veb3IaOJ79TpYCDkRuUEWuLINJtVOElkWU9QfAT//EQU2Edme',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL),(9,'Emery Feil',1,'SMmfmTHhdaPreLRVz7zA','WxuRzWIB3wP7WmigHxiDPFOdHGWYIvxocR77wQyPhYo97T26cp',0,0,0,0,'admin8','$2y$10$15S0DAk79pBJqKnkWPcLweZgEF5WpQnpIBPL69.Ad18nkVG7N1Dxu',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL),(10,'Claudine Hahn',1,'ByFbgalqg55nHLQf5PpP','qzip1dqMmr6osPq7TqxxR6PaKv6XKwQxFyOBnarWm7X8rypFGH',0,0,0,0,'admin9','$2y$10$ZHDC/WJT5Cy1wdZrXv0I.uwPRByqCYC7aZivZGpRz/vYW/QyyBFVC',0,0,'1','2018-07-08 04:43:22','2018-07-08 04:43:22',NULL);

/*Table structure for table `t_volume_discount` */

DROP TABLE IF EXISTS `t_volume_discount`;

CREATE TABLE `t_volume_discount` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) NOT NULL,
  `cl_number` int(11) NOT NULL,
  `money_discount` double(20,2) NOT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `t_volume_discount` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
