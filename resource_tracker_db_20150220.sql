CREATE DATABASE  IF NOT EXISTS `resource_tracker_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `resource_tracker_db`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: resource_tracker_db
-- ------------------------------------------------------
-- Server version	5.5.14

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
-- Table structure for table `angularcode_customers`
--

DROP TABLE IF EXISTS `angularcode_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `angularcode_customers` (
  `customerNumber` int(11) NOT NULL AUTO_INCREMENT,
  `customerName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postalCode` varchar(15) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  PRIMARY KEY (`customerNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `angularcode_customers`
--

LOCK TABLES `angularcode_customers` WRITE;
/*!40000 ALTER TABLE `angularcode_customers` DISABLE KEYS */;
INSERT INTO `angularcode_customers` VALUES (103,'Atelier graphique','Nantes@gmail.com','54, rue Royale','Nantes',NULL,'44000','France'),(112,'Signal Gift Stores','LasVegas@gmail.com','8489 Strong St.','Las Vegas','NV','83030','USA'),(114,'Australian Collectors, Co.','Melbourne@gmail.com','636 St Kilda Road','Melbourne','Victoria','3004','Australia'),(119,'La Rochelle Gifts','Nantes@gmail.com','67, rue des Cinquante Otages','Nantes',NULL,'44000','France'),(121,'Baane Mini Imports','Stavern@gmail.com','Erling Skakkes gate 78','Stavern',NULL,'4110','Norway'),(124,'Mini Gifts Distributors Ltd.','SanRafael@gmail.com','5677 Strong St.','San Rafael','CA','97562','USA'),(125,'Havel & Zbyszek Co','Warszawa@gmail.com','ul. Filtrowa 68','Warszawa',NULL,'01-012','Poland'),(128,'Blauer See Auto, Co.','Frankfurt@gmail.com','Lyonerstr. 34','Frankfurt',NULL,'60528','Germany'),(129,'Mini Wheels Co.','SanFrancisco@gmail.com','5557 North Pendale Street','San Francisco','CA','94217','USA'),(131,'Land of Toys Inc.','NYC@gmail.com','897 Long Airport Avenue','NYC','NY','10022','USA'),(141,'Euro+ Shopping Channel','Madrid@gmail.com','C/ Moralzarzal, 86','Madrid',NULL,'28034','Spain'),(145,'Danish Wholesale Imports','Kobenhavn@gmail.com','Vinbltet 34','Kobenhavn',NULL,'1734','Denmark'),(146,'Saveley & Henriot, Co.','Lyon@gmail.com','2, rue du Commerce','Lyon',NULL,'69004','France'),(148,'Dragon Souveniers, Ltd.','Singapore@gmail.com','Bronz Sok.','Singapore',NULL,'079903','Singapore'),(151,'Muscle Machine Inc','NYC@gmail.com','4092 Furth Circle','NYC','NY','10022','USA'),(157,'Diecast Classics Inc.','Allentown@gmail.com','7586 Pompton St.','Allentown','PA','70267','USA'),(161,'Technics Stores Inc.','Burlingame@gmail.com','9408 Furth Circle','Burlingame','CA','94217','USA'),(166,'Handji Gifts& Co','Singapore@gmail.com','106 Linden Road Sandown','Singapore',NULL,'069045','Singapore'),(167,'Herkku Gifts','Bergen@gmail.com','Brehmen St. 121','Bergen',NULL,'N 5804','Norway  ');
/*!40000 ALTER TABLE `angularcode_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authority`
--

DROP TABLE IF EXISTS `authority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authority` (
  `authority_id` int(11) NOT NULL AUTO_INCREMENT,
  `authority_name` varchar(255) NOT NULL,
  PRIMARY KEY (`authority_id`),
  UNIQUE KEY `AuthorityName_UNIQUE` (`authority_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authority`
--

LOCK TABLES `authority` WRITE;
/*!40000 ALTER TABLE `authority` DISABLE KEYS */;
INSERT INTO `authority` VALUES (1,'CHMT'),(3,'MOHSW'),(4,'Other authority'),(2,'RHMT');
/*!40000 ALTER TABLE `authority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budget`
--

DROP TABLE IF EXISTS `budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budget` (
  `budget_id` int(11) NOT NULL AUTO_INCREMENT,
  `financing_currency_id` int(11) NOT NULL,
  `spending_currency_id` int(11) NOT NULL,
  `financial_year_id` int(11) NOT NULL,
  `total_budget` double DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`budget_id`),
  UNIQUE KEY `unique_budget_for_project_in_financial_year` (`project_id`,`financial_year_id`),
  KEY `fk_Budget_Currency1_idx` (`financing_currency_id`),
  KEY `fk_Budget_FinancialYear1_idx` (`financial_year_id`),
  KEY `fk_Budget_Project1_idx` (`project_id`),
  KEY `fk_Budget_Currency2_idx` (`spending_currency_id`),
  CONSTRAINT `fk_Budget_Currency1` FOREIGN KEY (`financing_currency_id`) REFERENCES `currency` (`currency_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Budget_Currency2` FOREIGN KEY (`spending_currency_id`) REFERENCES `currency` (`currency_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Budget_FinancialYear1` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_year` (`financial_year_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Budget_Project1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget`
--

LOCK TABLES `budget` WRITE;
/*!40000 ALTER TABLE `budget` DISABLE KEYS */;
INSERT INTO `budget` VALUES (1,1,33,2,1400000,1),(2,1,33,2,1523000,2);
/*!40000 ALTER TABLE `budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cost_category`
--

DROP TABLE IF EXISTS `cost_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cost_category` (
  `cost_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`cost_category_id`),
  UNIQUE KEY `CostCategoryName_UNIQUE` (`cost_category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_category`
--

LOCK TABLES `cost_category` WRITE;
/*!40000 ALTER TABLE `cost_category` DISABLE KEYS */;
INSERT INTO `cost_category` VALUES (1,'Communication and advocacy'),(2,'Conferences / workshops'),(3,'Direct budget support'),(4,'Drugs and food supplies'),(5,'Equipment: medical'),(6,'Equipment: non-medical '),(18,'Other'),(7,'Overhead/ general administrative costs'),(8,'Procurement and supply management '),(9,'Program buildings/ infrastructure/ renovation'),(10,'Research/ M&E'),(11,'Salaries and benefits: government personnel'),(12,'Salaries and benefits: non-government health workers'),(13,'Technical assistance: external consultants '),(14,'Technical assistance: in-country consultants'),(15,'Training'),(16,'Travel costs: Domestic '),(17,'Travel costs: International');
/*!40000 ALTER TABLE `cost_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(45) NOT NULL,
  PRIMARY KEY (`currency_id`),
  UNIQUE KEY `CurrencyName_UNIQUE` (`currency_name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (7,'AUD - Australian Dollar'),(8,'BIF - Burundi Franc'),(9,'CAD - Canadian Dollar'),(31,'CHF - Swiss Franc'),(4,'CNY - Chinese Yuan'),(10,'CZK - Czech Koruna'),(11,'DKK - Danish Krone'),(12,'ETB - Ethiopian Birr'),(5,'EUR - Euro'),(13,'FIM - Finnish Markka'),(3,'GBP - British Pound'),(15,'HKD - Hong Kong Dollar'),(17,'ILS - Israeli New Shekel'),(6,'INR - Indian Rupee'),(16,'ISK - Iceland Krona'),(18,'JPY - Japanese Yen'),(19,'KES - Kenyan Shilling'),(28,'KRW - South-Korean Won'),(20,'LUF - Luxembourg Franc'),(22,'NOK - Norwegian Krone'),(21,'NZD - New Zealand Dollar'),(23,'RUB - Russian Rouble'),(24,'RWF - Rwandan Franc'),(30,'SEK - Swedish Krona'),(26,'SGD - Singapore Dollar'),(29,'SZL - Swaziland Lilangeni'),(32,'TWD - Taiwan Dollar'),(2,'TZS - Tanzanian Shilling'),(33,'UGX - Uganda Shilling'),(1,'USD - US Dollar'),(25,'XAG - Silver (oz.)'),(14,'XAU - Gold (oz.)');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_auth`
--

DROP TABLE IF EXISTS `customers_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers_auth` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers_auth`
--

LOCK TABLES `customers_auth` WRITE;
/*!40000 ALTER TABLE `customers_auth` DISABLE KEYS */;
INSERT INTO `customers_auth` VALUES (169,'Swadesh Behera','swadesh@gmail.com','1234567890','$2a$10$251b3c3d020155f7553c1ugKfEH04BD6nbCbo78AIDVOqS3GVYQ46','4092 Furth Circle','Singapore','2014-08-31 15:21:20'),(170,'Ipsita Sahoo','ipsita@gmail.com','1111111111','$2a$10$d84ffcf46967db4e1718buENHT7GVpcC7FfbSqCLUJDkKPg4RcgV2','2, rue du Commerce','NYC','2014-08-31 15:30:58'),(171,'Trisha Tamanna Priyadarsini','trisha@gmail.com','2222222222','$2a$10$c9b32f5baa3315554bffcuWfjiXNhO1Rn4hVxMXyJHJaesNHL9U/O','C/ Moralzarzal, 86','Burlingame','2014-08-31 15:32:03'),(172,'Sai Rimsha','rimsha@gmail.com','3333333333','$2a$10$477f7567571278c17ebdees5xCunwKISQaG8zkKhvfE5dYem5sTey','897 Long Airport Avenue','Madrid','2014-08-31 17:34:21'),(173,'Satwik Mohanty','satwik@gmail.com','4444444444','$2a$10$2b957be577db7727fed13O2QmHMd9LoEUjioYe.zkXP5lqBumI6Dy','Lyonerstr. 34','San Francisco\n','2014-08-31 17:36:02'),(174,'Tapaswini Sahoo','linky@gmail.com','5555555555','$2a$10$b2f3694f56fdb5b5c9ebeulMJTSx2Iv6ayQR0GUAcDsn0Jdn4c1we','ul. Filtrowa 68','Warszawa','2014-08-31 17:44:54'),(175,'Manas Ranjan Subudhi','manas@gmail.com','6666666666','$2a$10$03ab40438bbddb67d4f13Odrzs6Rwr92xKEYDbOO7IXO8YvBaOmlq','5677 Strong St.','Stavern\n','2014-08-31 17:45:08'),(178,'AngularCode Administrator','admin@angularcode.com','0000000000','$2a$10$72442f3d7ad44bcf1432cuAAZAURj9dtXhEMBQXMn9C8SpnZjmK1S','C/1052, Bangalore','','2014-08-31 18:00:26'),(187,'TWESIGOMWE GILBERT','gilbert.gillz@gmail.com','+256702016262','$2a$10$89398c1209637ccf3f5daO1A037tq593ZqzzzgwMf6z6LZC.cZ2B.','Plot 67 Bukoto Street Kamokya Kampala','','2015-02-16 21:05:47');
/*!40000 ALTER TABLE `customers_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(45) NOT NULL,
  `region_id` int(11) NOT NULL,
  PRIMARY KEY (`district_id`),
  UNIQUE KEY `DistrictName_UNIQUE` (`district_name`),
  KEY `fk_District_Region1_idx` (`region_id`),
  CONSTRAINT `fk_District_Region1` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (1,'Kampala',1),(2,'Mpigi',1),(3,'Busia',2),(4,'Tororo',2),(6,'Lira',3),(7,'Rukungiri',4),(8,'Mbarara',4);
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district_partner_budget`
--

DROP TABLE IF EXISTS `district_partner_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district_partner_budget` (
  `district_partner_budget_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_sub_category_of_support_budget_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `budget_amount` double DEFAULT NULL,
  PRIMARY KEY (`district_partner_budget_id`),
  UNIQUE KEY `unique_project_sub_category_of_support_budget` (`partner_id`,`district_id`,`project_sub_category_of_support_budget_id`),
  KEY `fk_District_has_District_Partner_District_Partner1_idx` (`partner_id`),
  KEY `fk_District_has_District_Partner_District1_idx` (`district_id`),
  KEY `fk_District_Partner_Budget_Project_Sub_Category_Of_Support__idx` (`project_sub_category_of_support_budget_id`),
  CONSTRAINT `fk_District_has_District_Partner_District1` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_District_has_District_Partner_District_Partner1` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`partner_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_District_Partner_Budget_Project_Sub_Category_Of_Support_Bu1` FOREIGN KEY (`project_sub_category_of_support_budget_id`) REFERENCES `project_sub_category_of_support_budget` (`project_sub_category_of_support_budget_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district_partner_budget`
--

LOCK TABLES `district_partner_budget` WRITE;
/*!40000 ALTER TABLE `district_partner_budget` DISABLE KEYS */;
INSERT INTO `district_partner_budget` VALUES (1,1,1,1,1000),(2,2,2,2,2000);
/*!40000 ALTER TABLE `district_partner_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district_partner_cost_category`
--

DROP TABLE IF EXISTS `district_partner_cost_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district_partner_cost_category` (
  `district_partner_cost_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_partner_budget_id` int(11) NOT NULL,
  `cost_category_id` int(11) NOT NULL,
  `district_partner_cost_category_budget_amount` double DEFAULT NULL,
  PRIMARY KEY (`district_partner_cost_category_id`),
  UNIQUE KEY `unique_cost_category_for_district_partner_budget` (`district_partner_budget_id`,`cost_category_id`),
  KEY `fk_Project_Location_has_Cost_Category_Cost_Category1_idx` (`cost_category_id`),
  KEY `fk_District_Cost_Category_District_Partner_Budget1_idx` (`district_partner_budget_id`),
  CONSTRAINT `fk_District_Cost_Category_District_Partner_Budget1` FOREIGN KEY (`district_partner_budget_id`) REFERENCES `district_partner_budget` (`district_partner_budget_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Project_Location_has_Cost_Category_Cost_Category1` FOREIGN KEY (`cost_category_id`) REFERENCES `cost_category` (`cost_category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district_partner_cost_category`
--

LOCK TABLES `district_partner_cost_category` WRITE;
/*!40000 ALTER TABLE `district_partner_cost_category` DISABLE KEYS */;
INSERT INTO `district_partner_cost_category` VALUES (1,1,1,500),(2,2,2,200);
/*!40000 ALTER TABLE `district_partner_cost_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_year`
--

DROP TABLE IF EXISTS `financial_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_year` (
  `financial_year_id` int(11) NOT NULL AUTO_INCREMENT,
  `financial_year_name` varchar(20) NOT NULL,
  PRIMARY KEY (`financial_year_id`),
  UNIQUE KEY `FinancialYearName_UNIQUE` (`financial_year_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_year`
--

LOCK TABLES `financial_year` WRITE;
/*!40000 ALTER TABLE `financial_year` DISABLE KEYS */;
INSERT INTO `financial_year` VALUES (6,'2014/2015'),(4,'2015/2016'),(2,'2016/2017'),(3,'2017/2018');
/*!40000 ALTER TABLE `financial_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `national_budget`
--

DROP TABLE IF EXISTS `national_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `national_budget` (
  `national_budget_id` int(11) NOT NULL AUTO_INCREMENT,
  `budget_id` int(11) NOT NULL,
  `budget_amount` double DEFAULT NULL,
  PRIMARY KEY (`national_budget_id`),
  UNIQUE KEY `budget_id_UNIQUE` (`budget_id`),
  KEY `fk_national_budget_Budget1_idx` (`budget_id`),
  CONSTRAINT `fk_national_budget_Budget1` FOREIGN KEY (`budget_id`) REFERENCES `budget` (`budget_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `national_budget`
--

LOCK TABLES `national_budget` WRITE;
/*!40000 ALTER TABLE `national_budget` DISABLE KEYS */;
INSERT INTO `national_budget` VALUES (1,1,50000),(2,2,60000);
/*!40000 ALTER TABLE `national_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `national_budget_cost_category`
--

DROP TABLE IF EXISTS `national_budget_cost_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `national_budget_cost_category` (
  `national_budget_cost_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `national_budget_id` int(11) NOT NULL,
  `cost_category_id` int(11) NOT NULL,
  `national_budget_amount` double DEFAULT NULL,
  PRIMARY KEY (`national_budget_cost_category_id`),
  UNIQUE KEY `unique_cost_category_for_national_budget` (`cost_category_id`,`national_budget_id`),
  KEY `fk_national_budget_has_Cost_Category_Cost_Category1_idx` (`cost_category_id`),
  KEY `fk_national_budget_has_Cost_Category_national_budget1_idx` (`national_budget_id`),
  CONSTRAINT `fk_national_budget_has_Cost_Category_Cost_Category1` FOREIGN KEY (`cost_category_id`) REFERENCES `cost_category` (`cost_category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_national_budget_has_Cost_Category_national_budget1` FOREIGN KEY (`national_budget_id`) REFERENCES `national_budget` (`national_budget_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `national_budget_cost_category`
--

LOCK TABLES `national_budget_cost_category` WRITE;
/*!40000 ALTER TABLE `national_budget_cost_category` DISABLE KEYS */;
INSERT INTO `national_budget_cost_category` VALUES (3,1,1,4000),(4,1,2,3000),(5,1,3,700),(6,2,4,3000),(7,2,5,1000),(8,2,6,2000);
/*!40000 ALTER TABLE `national_budget_cost_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisation`
--

DROP TABLE IF EXISTS `organisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organisation` (
  `organisation_id` int(11) NOT NULL AUTO_INCREMENT,
  `organisation_name` varchar(255) DEFAULT NULL,
  `organisation_type_id` int(11) NOT NULL,
  `fiscal_year_start` year(4) DEFAULT NULL,
  `provided_pools_fund_for_health` tinyint(1) DEFAULT NULL,
  `signed_mou_with_moh` tinyint(1) DEFAULT NULL,
  `date_started_working_in_districts` date DEFAULT NULL,
  `authority_consulted_Id` int(11) NOT NULL,
  `contact_name` varchar(45) DEFAULT NULL,
  `mobile_phone` varchar(45) DEFAULT NULL,
  `office_phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`organisation_id`),
  UNIQUE KEY `organisation_name_UNIQUE` (`organisation_name`),
  KEY `fk_Organisation_OrganisationType1_idx` (`organisation_type_id`),
  KEY `fk_Organisation_Authority1_idx` (`authority_consulted_Id`),
  CONSTRAINT `fk_Organisation_Authority1` FOREIGN KEY (`authority_consulted_Id`) REFERENCES `authority` (`authority_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Organisation_OrganisationType1` FOREIGN KEY (`organisation_type_id`) REFERENCES `organisation_type` (`organisation_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisation`
--

LOCK TABLES `organisation` WRITE;
/*!40000 ALTER TABLE `organisation` DISABLE KEYS */;
INSERT INTO `organisation` VALUES (1,'Test Organisation 1',1,2015,1,1,'2014-01-01',1,'testc contact name','0783423234','0414637263','testmail@mail.com'),(2,'Test Organisation 2',1,2015,1,0,'2013-01-01',2,'test contact name 2','0784234241','0414732343','testmail2@mail.com');
/*!40000 ALTER TABLE `organisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisation_type`
--

DROP TABLE IF EXISTS `organisation_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organisation_type` (
  `organisation_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `organisation_type_name` varchar(100) NOT NULL,
  PRIMARY KEY (`organisation_type_id`),
  UNIQUE KEY `organisation_type_name_UNIQUE` (`organisation_type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisation_type`
--

LOCK TABLES `organisation_type` WRITE;
/*!40000 ALTER TABLE `organisation_type` DISABLE KEYS */;
INSERT INTO `organisation_type` VALUES (3,'Bilateral'),(5,'GOT'),(1,'International NGO'),(2,'Local NGO'),(4,'Multi-lateral'),(7,'Private');
/*!40000 ALTER TABLE `organisation_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner`
--

DROP TABLE IF EXISTS `partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner` (
  `partner_id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_type_id` int(11) NOT NULL,
  `partner_name` varchar(45) DEFAULT NULL,
  `partner_contact_name` varchar(45) DEFAULT NULL,
  `partner_contact_phone` varchar(20) DEFAULT NULL,
  `partner_contact_email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`partner_id`),
  KEY `fk_Partner_Partner_Type1_idx` (`partner_type_id`),
  KEY `unique_partner_name_for_partner_type` (`partner_type_id`,`partner_name`),
  CONSTRAINT `fk_Partner_Partner_Type1` FOREIGN KEY (`partner_type_id`) REFERENCES `partner_type` (`partner_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner`
--

LOCK TABLES `partner` WRITE;
/*!40000 ALTER TABLE `partner` DISABLE KEYS */;
INSERT INTO `partner` VALUES (1,1,'Test Partner name 1','test partner contact name','0702132342','test_partner_email_1@test.com'),(2,2,'Test Partner name 2','test partner contact name 2','0755637283','test_partner_email_2@test.com');
/*!40000 ALTER TABLE `partner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_district`
--

DROP TABLE IF EXISTS `partner_district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_district` (
  `partner_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  PRIMARY KEY (`partner_id`,`district_id`),
  KEY `fk_partner_has_district_district1_idx` (`district_id`),
  KEY `fk_partner_has_district_partner1_idx` (`partner_id`),
  CONSTRAINT `fk_partner_has_district_district1` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_partner_has_district_partner1` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`partner_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_district`
--

LOCK TABLES `partner_district` WRITE;
/*!40000 ALTER TABLE `partner_district` DISABLE KEYS */;
INSERT INTO `partner_district` VALUES (1,1),(1,2),(2,3),(2,4);
/*!40000 ALTER TABLE `partner_district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_type`
--

DROP TABLE IF EXISTS `partner_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_type` (
  `partner_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`partner_type_id`),
  UNIQUE KEY `partner_type_name_UNIQUE` (`partner_type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_type`
--

LOCK TABLES `partner_type` WRITE;
/*!40000 ALTER TABLE `partner_type` DISABLE KEYS */;
INSERT INTO `partner_type` VALUES (2,'Local Government'),(1,'NGO');
/*!40000 ALTER TABLE `partner_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `project_description` varchar(255) DEFAULT NULL,
  `organisation_financing_agent_id` int(11) NOT NULL,
  `organisation_implementer_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `project_name_UNIQUE` (`project_name`),
  UNIQUE KEY `unique_financing_agent_on_project` (`organisation_financing_agent_id`,`project_name`),
  UNIQUE KEY `unique_implementer_on_project` (`organisation_implementer_id`,`project_name`),
  KEY `fk_Project_Organisation1_idx` (`organisation_financing_agent_id`),
  KEY `fk_Project_Organisation2_idx` (`organisation_implementer_id`),
  CONSTRAINT `fk_Project_Organisation1` FOREIGN KEY (`organisation_financing_agent_id`) REFERENCES `organisation` (`organisation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Project_Organisation2` FOREIGN KEY (`organisation_implementer_id`) REFERENCES `organisation` (`organisation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'Test Project 1',' Project description for test project 1',1,2),(2,'Test Project 2','Project description for test project 2',2,1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_sub_category_of_support_budget`
--

DROP TABLE IF EXISTS `project_sub_category_of_support_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_sub_category_of_support_budget` (
  `project_sub_category_of_support_budget_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_support_budget_id` int(11) NOT NULL,
  `sub_category_of_support_id` int(11) NOT NULL,
  `budget_amount` double DEFAULT NULL,
  PRIMARY KEY (`project_sub_category_of_support_budget_id`),
  UNIQUE KEY `unique_sub_category_of_support_budget_for_type_of_support_bduget` (`type_of_support_budget_id`,`sub_category_of_support_id`),
  KEY `fk_Project_has_SubCategoryOfSupport_SubCategoryOfSupport1_idx` (`sub_category_of_support_id`),
  KEY `fk_Project_Sub_Category_Of_Support_Type_Of_Support_Budget1_idx` (`type_of_support_budget_id`),
  CONSTRAINT `fk_Project_has_SubCategoryOfSupport_SubCategoryOfSupport1` FOREIGN KEY (`sub_category_of_support_id`) REFERENCES `sub_category_of_support` (`sub_category_of_support_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Project_Sub_Category_Of_Support_Type_Of_Support_Budget1` FOREIGN KEY (`type_of_support_budget_id`) REFERENCES `type_of_support_budget` (`type_of_support_budget_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_sub_category_of_support_budget`
--

LOCK TABLES `project_sub_category_of_support_budget` WRITE;
/*!40000 ALTER TABLE `project_sub_category_of_support_budget` DISABLE KEYS */;
INSERT INTO `project_sub_category_of_support_budget` VALUES (1,1,1,3000),(2,2,2,4000);
/*!40000 ALTER TABLE `project_sub_category_of_support_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_undertaken`
--

DROP TABLE IF EXISTS `project_undertaken`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_undertaken` (
  `project_undertaken_id` int(11) NOT NULL AUTO_INCREMENT,
  `organisation_id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`project_undertaken_id`),
  UNIQUE KEY `unique_project_undertaken_for_organisation` (`organisation_id`,`project_name`),
  KEY `fk_project_undertaken_organisation1_idx` (`organisation_id`),
  CONSTRAINT `fk_project_undertaken_organisation1` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`organisation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_undertaken`
--

LOCK TABLES `project_undertaken` WRITE;
/*!40000 ALTER TABLE `project_undertaken` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_undertaken` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(45) NOT NULL,
  PRIMARY KEY (`region_id`),
  UNIQUE KEY `RegionName_UNIQUE` (`region_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Central Region'),(2,'Eastern Region'),(3,'Northern Region'),(4,'Western Region');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `RoleName_UNIQUE` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Test Role 1'),(2,'Test Role 2');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_category_of_support`
--

DROP TABLE IF EXISTS `sub_category_of_support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_category_of_support` (
  `sub_category_of_support_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_of_support_name` varchar(255) DEFAULT NULL,
  `type_of_support_id` int(11) NOT NULL,
  PRIMARY KEY (`sub_category_of_support_id`),
  UNIQUE KEY `unique_sub_category_of_support_for_type_of_support` (`type_of_support_id`,`sub_category_of_support_name`),
  KEY `fk_SubCategoryOfSupport_TypeOfSupport1_idx` (`type_of_support_id`),
  CONSTRAINT `fk_SubCategoryOfSupport_TypeOfSupport1` FOREIGN KEY (`type_of_support_id`) REFERENCES `type_of_support` (`type_of_support_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_category_of_support`
--

LOCK TABLES `sub_category_of_support` WRITE;
/*!40000 ALTER TABLE `sub_category_of_support` DISABLE KEYS */;
INSERT INTO `sub_category_of_support` VALUES (2,'Adolescent reproductive health',1),(4,'Fistula repair',1),(5,'Gender-based violence',1),(1,'Gynecology',1),(3,'Reproductive cancers',1),(6,'STI prevention and management',1),(9,'Case management of pneumonia',2),(11,'Civil registration and death audits',2),(8,'Diarrheal diseases',2),(7,'General quality pediatric care',2),(10,'Integrated care management',2),(13,'Malaria treatment and prevention',2),(12,'PMTCT',2),(20,'Cold chain',3),(15,'Diptheria, tetanus, pertussis, haemophilus influenae, hepatitis B',3),(14,'Full immunization',3),(21,'Measles',3),(16,'Oral polio vaccine (OPV)',3),(18,'Pneumococcal conjugate vaccine (PCV)',3),(19,'Rotavirus vaccine',3),(17,'Tetanus toxoid',3),(26,'Breastfeeding support',4),(27,'Complementary feeding',4),(22,'General nutritional food support',4),(25,'Growth monitoring and promotion',4),(30,'Hemoglobin level',4),(29,'Iron/folic acid supplementation',4),(23,'Management of acute malnutrition',4),(28,'Micronutrient supplementation',4),(24,'Vitamin A',4),(31,'Cross cutting RMNCH Activities',5),(37,'General Health System Support',6),(32,'HIV/AIDs',6),(36,'Malaria',6),(35,'Non-communicable Conditions',6),(34,'Other Communicable Conditions',6),(33,'TB',6),(41,'Bilateral tubular ligation/vasectomy',7),(38,'Cross cutting family planning activities',7),(40,'Depo-provera injection',7),(42,'Emergency contraception',7),(44,'Female condoms',7),(46,'IUD',7),(43,'Male condoms',7),(45,'Norplant/implant',7),(39,'Oral contraceptive pill',7);
/*!40000 ALTER TABLE `sub_category_of_support` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_of_support`
--

DROP TABLE IF EXISTS `type_of_support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_support` (
  `type_of_support_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_support_name` varchar(45) NOT NULL,
  PRIMARY KEY (`type_of_support_id`),
  UNIQUE KEY `TypeOfSupportName_UNIQUE` (`type_of_support_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_of_support`
--

LOCK TABLES `type_of_support` WRITE;
/*!40000 ALTER TABLE `type_of_support` DISABLE KEYS */;
INSERT INTO `type_of_support` VALUES (5,'Cross cutting RMNCH Activities'),(7,'Family Planning'),(2,'Neonatal and Child Health'),(4,'Nutrition'),(6,'Other'),(1,'Reproductive and Maternal Health'),(3,'Vaccines');
/*!40000 ALTER TABLE `type_of_support` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_of_support_budget`
--

DROP TABLE IF EXISTS `type_of_support_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_support_budget` (
  `type_of_support_budget_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_support_id` int(11) DEFAULT NULL,
  `budget_id` int(11) DEFAULT NULL,
  `budget_amount` double DEFAULT NULL,
  PRIMARY KEY (`type_of_support_budget_id`),
  UNIQUE KEY `unique_type_of_support_budget` (`type_of_support_id`,`budget_id`),
  KEY `fk_Type_Of_Support_has_Budget_Budget1_idx` (`budget_id`),
  KEY `fk_Type_Of_Support_has_Budget_Type_Of_Support1_idx` (`type_of_support_id`),
  CONSTRAINT `fk_Type_Of_Support_has_Budget_Budget1` FOREIGN KEY (`budget_id`) REFERENCES `budget` (`budget_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Type_Of_Support_has_Budget_Type_Of_Support1` FOREIGN KEY (`type_of_support_id`) REFERENCES `type_of_support` (`type_of_support_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_of_support_budget`
--

LOCK TABLES `type_of_support_budget` WRITE;
/*!40000 ALTER TABLE `type_of_support_budget` DISABLE KEYS */;
INSERT INTO `type_of_support_budget` VALUES (1,1,1,34000),(2,2,2,60000);
/*!40000 ALTER TABLE `type_of_support_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `Username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Agaba','John','0783727372','user1@mail.com','user1','pass1'),(2,'Tumwine','Ben','0778734212','user2@mail.com','user2','pass2');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_User_has_Role_Role1_idx` (`role_id`),
  KEY `fk_User_has_Role_User1_idx` (`user_id`),
  CONSTRAINT `fk_User_has_Role_Role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Role_User1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-02-20  4:07:49
