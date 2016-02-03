CREATE DATABASE  IF NOT EXISTS `controle_horas` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `controle_horas`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: controle_horas
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `ch_app_menu`
--

DROP TABLE IF EXISTS `ch_app_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_app_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_app_menu`
--

LOCK TABLES `ch_app_menu` WRITE;
/*!40000 ALTER TABLE `ch_app_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `ch_app_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_calendar`
--

DROP TABLE IF EXISTS `ch_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_calendar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `holiday` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `repeat` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_calendar`
--

LOCK TABLES `ch_calendar` WRITE;
/*!40000 ALTER TABLE `ch_calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `ch_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_chats`
--

DROP TABLE IF EXISTS `ch_chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_chats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `users` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('N','G') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_chats`
--

LOCK TABLES `ch_chats` WRITE;
/*!40000 ALTER TABLE `ch_chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `ch_chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_chats_messages`
--

DROP TABLE IF EXISTS `ch_chats_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_chats_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `see` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `chats_messages_user_id_foreign` (`user_id`),
  KEY `chats_messages_chat_id_foreign` (`chat_id`),
  CONSTRAINT `chats_messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `ch_chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chats_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_chats_messages`
--

LOCK TABLES `ch_chats_messages` WRITE;
/*!40000 ALTER TABLE `ch_chats_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `ch_chats_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_clients`
--

DROP TABLE IF EXISTS `ch_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `responsible` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_clients`
--

LOCK TABLES `ch_clients` WRITE;
/*!40000 ALTER TABLE `ch_clients` DISABLE KEYS */;
INSERT INTO `ch_clients` VALUES (1,'Alelo','José da Silva','jose@alelo.com','(11) 99875-412','','2015-07-30 23:12:24','2015-07-30 23:12:24');
/*!40000 ALTER TABLE `ch_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_clients_groups`
--

DROP TABLE IF EXISTS `ch_clients_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_clients_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `clients_groups_client_id_foreign` (`client_id`),
  CONSTRAINT `clients_groups_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `ch_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_clients_groups`
--

LOCK TABLES `ch_clients_groups` WRITE;
/*!40000 ALTER TABLE `ch_clients_groups` DISABLE KEYS */;
INSERT INTO `ch_clients_groups` VALUES (2,1,'Teste','Teste para segmento','2015-08-26 23:43:25','2015-08-29 16:39:47');
/*!40000 ALTER TABLE `ch_clients_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_holidays`
--

DROP TABLE IF EXISTS `ch_holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_holidays` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `holiday_type` enum('N','O','S','E') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_holidays`
--

LOCK TABLES `ch_holidays` WRITE;
/*!40000 ALTER TABLE `ch_holidays` DISABLE KEYS */;
INSERT INTO `ch_holidays` VALUES (1,'Ano Novo',1,1,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Carnaval',17,2,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'Páscoa',5,3,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'Tiradentes',21,3,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'Dia do Trabalho',1,5,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'Corpus Christi',4,6,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'Independência do Brasil',7,9,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'Nossa Senhora Aparecida',12,10,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,'Finados',2,11,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,'Proclamação da República',15,11,'N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,'Natal',25,12,'N','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ch_holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_migrations`
--

DROP TABLE IF EXISTS `ch_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_migrations`
--

LOCK TABLES `ch_migrations` WRITE;
/*!40000 ALTER TABLE `ch_migrations` DISABLE KEYS */;
INSERT INTO `ch_migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_06_15_125752_proposals_types_table',1),('2015_06_21_164400_create_clients_table',1),('2015_06_21_165901_clients_groups_table',1),('2015_06_21_171459_create_proposals_table',1),('2015_06_22_144415_create_projects_table',1),('2015_07_02_114149_entrust_setup_tables',1),('2015_07_11_165345_create_projects_times_table',1),('2015_07_15_012315_create_projects_times_tasks_table',1),('2015_07_24_012315_create_users_notifications_table',1),('2015_07_25_013910_chats_table',1),('2015_07_25_014909_chats_messages_table',1),('2015_07_26_120352_create_teams_table',1),('2015_07_26_121230_create_users_teams_table',1),('2015_08_05_194603_calendar_table',1),('2015_08_05_202459_timesheet_table',1),('2015_08_05_202459_timesheet_tasks_table',1),('2015_08_15_122750_proposals_versions_table',1),('2015_08_15_155717_app_menu_table',1),('2015_08_29_202034_alter_proposals_table',1),('2015_08_31_103424_users_localizations_table',1),('2015_08_31_103528_users_benefits_table',1),('2015_08_31_103548_users_settings_table',1),('2015_09_03_190612_create_tasks_teams_table',1),('2015_09_08_183357_create_holidays_table',1);
/*!40000 ALTER TABLE `ch_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_password_resets`
--

DROP TABLE IF EXISTS `ch_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_password_resets`
--

LOCK TABLES `ch_password_resets` WRITE;
/*!40000 ALTER TABLE `ch_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `ch_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_permission_role`
--

DROP TABLE IF EXISTS `ch_permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `ch_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ch_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_permission_role`
--

LOCK TABLES `ch_permission_role` WRITE;
/*!40000 ALTER TABLE `ch_permission_role` DISABLE KEYS */;
INSERT INTO `ch_permission_role` VALUES (2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(2,2),(3,2),(4,2),(5,2),(8,2),(11,2),(12,2),(13,2),(14,2),(15,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(29,2),(30,2),(31,2),(7,3),(8,3),(11,3),(15,3),(19,3),(21,3),(23,3),(32,3),(36,3);
/*!40000 ALTER TABLE `ch_permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_permissions`
--

DROP TABLE IF EXISTS `ch_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_permissions`
--

LOCK TABLES `ch_permissions` WRITE;
/*!40000 ALTER TABLE `ch_permissions` DISABLE KEYS */;
INSERT INTO `ch_permissions` VALUES (1,'god-mode','Modo faz tudo',NULL,'2015-08-25 23:23:59','2015-08-25 23:23:59'),(2,'ProposalController@index','Visualizar ProposalController','Visualizar os ProposalController','2015-08-25 23:25:21','2015-08-25 23:25:21'),(3,'ProjectController@index','Visualizar ProjectController','Visualizar os ProjectController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(4,'TaskController@index','Visualizar TaskController','Visualizar os TaskController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(5,'ClientController@index','Visualizar ClientController','Visualizar os ClientController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(6,'ClientGroupController@index','Visualizar ClientGroupController','Visualizar os ClientGroupController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(7,'UserController@index','Visualizar UserController','Visualizar os UserController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(8,'TimesheetController@index','Visualizar TimesheetController','Visualizar os TimesheetController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(9,'TeamController@index','Visualizar TeamController','Visualizar os TeamController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(10,'GroupPermissionController@index','Visualizar GroupPermissionController','Visualizar os GroupPermissionController','2015-08-25 23:25:22','2015-08-25 23:25:22'),(11,'ProposalController@create','Criar ProposalController','Criar novo ProposalController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(12,'ProposalController@edit','Editar ProposalController','Editar novo ProposalController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(13,'ProposalController@delete','Deletar ProposalController','Deletar o(s) ProposalController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(14,'ProjectController@create','Criar ProjectController','Criar novo ProjectController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(15,'ProjectController@edit','Editar ProjectController','Editar novo ProjectController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(16,'ProjectController@delete','Deletar ProjectController','Deletar o(s) ProjectController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(17,'TaskController@create','Criar TaskController','Criar novo TaskController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(18,'TaskController@edit','Editar TaskController','Editar novo TaskController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(19,'TaskController@delete','Deletar TaskController','Deletar o(s) TaskController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(20,'ClientController@create','Criar ClientController','Criar novo ClientController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(21,'ClientController@edit','Editar ClientController','Editar novo ClientController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(22,'ClientController@delete','Deletar ClientController','Deletar o(s) ClientController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(23,'ClientGroupController@create','Criar ClientGroupController','Criar novo ClientGroupController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(24,'ClientGroupController@edit','Editar ClientGroupController','Editar novo ClientGroupController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(25,'ClientGroupController@delete','Deletar ClientGroupController','Deletar o(s) ClientGroupController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(26,'UserController@create','Criar UserController','Criar novo UserController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(27,'UserController@edit','Editar UserController','Editar novo UserController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(28,'UserController@delete','Deletar UserController','Deletar o(s) UserController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(29,'TimesheetController@create','Criar TimesheetController','Criar novo TimesheetController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(30,'TimesheetController@edit','Editar TimesheetController','Editar novo TimesheetController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(31,'TimesheetController@delete','Deletar TimesheetController','Deletar o(s) TimesheetController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(32,'TeamController@create','Criar TeamController','Criar novo TeamController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(33,'TeamController@edit','Editar TeamController','Editar novo TeamController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(34,'TeamController@delete','Deletar TeamController','Deletar o(s) TeamController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(35,'GroupPermissionController@create','Criar GroupPermissionController','Criar novo GroupPermissionController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(36,'GroupPermissionController@edit','Editar GroupPermissionController','Editar novo GroupPermissionController','2015-08-25 23:25:43','2015-08-25 23:25:43'),(37,'GroupPermissionController@delete','Deletar GroupPermissionController','Deletar o(s) GroupPermissionController','2015-08-25 23:25:43','2015-08-25 23:25:43');
/*!40000 ALTER TABLE `ch_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_projects`
--

DROP TABLE IF EXISTS `ch_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `proposal_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_complement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `budget` decimal(9,2) NOT NULL,
  `schedule_time` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('A','D','F') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `projects_user_id_foreign` (`user_id`),
  KEY `projects_proposal_id_foreign` (`proposal_id`),
  CONSTRAINT `projects_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `ch_proposals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_projects`
--

LOCK TABLES `ch_projects` WRITE;
/*!40000 ALTER TABLE `ch_projects` DISABLE KEYS */;
INSERT INTO `ch_projects` VALUES (1,2,1,'PAL123','-ALELO-DESK-DESK-APL-08/15 V1',10000.00,100,'Teste de Projeto','Teste de projeto para o teste!','A','2015-08-31 13:53:25','2015-08-31 13:53:25');
/*!40000 ALTER TABLE `ch_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_projects_times`
--

DROP TABLE IF EXISTS `ch_projects_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_projects_times` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `cycle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `budget` decimal(9,2) NOT NULL,
  `schedule_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `projects_times_project_id_foreign` (`project_id`),
  CONSTRAINT `projects_times_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `ch_projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_projects_times`
--

LOCK TABLES `ch_projects_times` WRITE;
/*!40000 ALTER TABLE `ch_projects_times` DISABLE KEYS */;
INSERT INTO `ch_projects_times` VALUES (2,1,'Frente',1021100.00,150,'2015-09-03 22:04:05','2015-09-03 22:04:05'),(3,1,'Planejamento',1000000.00,200,'2015-09-03 22:04:05','2015-09-03 22:04:05');
/*!40000 ALTER TABLE `ch_projects_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_projects_times_tasks`
--

DROP TABLE IF EXISTS `ch_projects_times_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_projects_times_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `project_time_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `projects_times_tasks_project_id_foreign` (`project_id`),
  KEY `projects_times_tasks_project_time_id_foreign` (`project_time_id`),
  CONSTRAINT `projects_times_tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `ch_projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `projects_times_tasks_project_time_id_foreign` FOREIGN KEY (`project_time_id`) REFERENCES `ch_projects_times` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_projects_times_tasks`
--

LOCK TABLES `ch_projects_times_tasks` WRITE;
/*!40000 ALTER TABLE `ch_projects_times_tasks` DISABLE KEYS */;
INSERT INTO `ch_projects_times_tasks` VALUES (1,1,2,'TCASS','','2015-10-13 16:20:46','2015-10-13 16:20:46');
/*!40000 ALTER TABLE `ch_projects_times_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_proposals`
--

DROP TABLE IF EXISTS `ch_proposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_proposals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `client_group_id` int(10) unsigned NOT NULL,
  `proposal_type_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `proposals_user_id_foreign` (`user_id`),
  KEY `proposals_client_id_foreign` (`client_id`),
  KEY `proposals_client_group_id_foreign` (`client_group_id`),
  KEY `proposals_proposal_type_id_foreign` (`proposal_type_id`),
  CONSTRAINT `proposals_client_group_id_foreign` FOREIGN KEY (`client_group_id`) REFERENCES `ch_clients_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proposals_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `ch_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proposals_proposal_type_id_foreign` FOREIGN KEY (`proposal_type_id`) REFERENCES `ch_proposals_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proposals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_proposals`
--

LOCK TABLES `ch_proposals` WRITE;
/*!40000 ALTER TABLE `ch_proposals` DISABLE KEYS */;
INSERT INTO `ch_proposals` VALUES (1,1,1,2,3,'APL','Teste1',0,'2015-08-25 23:28:29','2015-08-29 17:41:26'),(2,1,1,2,3,'Teste','Teste',0,'2015-08-30 15:16:44','2015-08-30 15:16:44');
/*!40000 ALTER TABLE `ch_proposals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_proposals_types`
--

DROP TABLE IF EXISTS `ch_proposals_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_proposals_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_proposals_types`
--

LOCK TABLES `ch_proposals_types` WRITE;
/*!40000 ALTER TABLE `ch_proposals_types` DISABLE KEYS */;
INSERT INTO `ch_proposals_types` VALUES (1,'WEB','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Mobile','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'Desk','','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ch_proposals_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_proposals_versions`
--

DROP TABLE IF EXISTS `ch_proposals_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_proposals_versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `proposal_id` int(10) unsigned NOT NULL,
  `proposal` text COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `send` int(11) NOT NULL,
  `date_send` date NOT NULL,
  `date_return` date NOT NULL,
  `authorise` tinyint(1) NOT NULL,
  `data_authorise` date NOT NULL,
  `signing_board` tinyint(1) NOT NULL,
  `date_signing_board` date NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `proposals_versions_proposal_id_foreign` (`proposal_id`),
  CONSTRAINT `proposals_versions_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `ch_proposals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_proposals_versions`
--

LOCK TABLES `ch_proposals_versions` WRITE;
/*!40000 ALTER TABLE `ch_proposals_versions` DISABLE KEYS */;
INSERT INTO `ch_proposals_versions` VALUES (1,1,'lorem ipsum','v1',0,'0000-00-00','0000-00-00',0,'0000-00-00',0,'0000-00-00',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ch_proposals_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_role_user`
--

DROP TABLE IF EXISTS `ch_role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ch_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_role_user`
--

LOCK TABLES `ch_role_user` WRITE;
/*!40000 ALTER TABLE `ch_role_user` DISABLE KEYS */;
INSERT INTO `ch_role_user` VALUES (1,1),(4,1),(37,1),(2,2);
/*!40000 ALTER TABLE `ch_role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_roles`
--

DROP TABLE IF EXISTS `ch_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_roles`
--

LOCK TABLES `ch_roles` WRITE;
/*!40000 ALTER TABLE `ch_roles` DISABLE KEYS */;
INSERT INTO `ch_roles` VALUES (1,'Godless-Admin','Godless Admin','Godless Admin can do anything, literally anything','2015-10-13 16:17:38','2015-10-13 16:17:38'),(2,'Gerente','Gerente','Gerente de projetos','2015-10-13 16:17:38','2015-10-13 16:17:38'),(3,'ATG','Teste','Teste do teste','2015-12-23 15:46:29','2015-12-23 15:46:29');
/*!40000 ALTER TABLE `ch_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_sessions`
--

DROP TABLE IF EXISTS `ch_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_sessions` (
  `id` varchar(2555) NOT NULL,
  `payload` text,
  `last_activity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_sessions`
--

LOCK TABLES `ch_sessions` WRITE;
/*!40000 ALTER TABLE `ch_sessions` DISABLE KEYS */;
INSERT INTO `ch_sessions` VALUES ('ffd3a16b08059c2b130d81c97371ad21dccbb0e5','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMmZQVjFxbG9uU1NqdWN3QUJic1ppV3IzdTJUVGtUNUhZVHhKbzVmWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly90aW1lc2hlZXQubG9jYWxob3N0LmNvbS9yZWdpc3RlciI7fXM6NToiZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozODoibG9naW5fODJlNWQyYzU2YmRkMDgxMTMxOGYwY2YwNzhiNzhiZmMiO3M6ODoibGJlemVycmEiO3M6OToiX3NmMl9tZXRhIjthOjM6e3M6MToidSI7aToxNDUxNDk3ODA0O3M6MToiYyI7aToxNDUxNDk3NzY4O3M6MToibCI7czoxOiIwIjt9fQ==',1451497804);
/*!40000 ALTER TABLE `ch_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_tasks_teams`
--

DROP TABLE IF EXISTS `ch_tasks_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_tasks_teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(10) unsigned NOT NULL,
  `project_time_task_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tasks_teams_team_id_foreign` (`team_id`),
  KEY `tasks_teams_project_time_task_id_foreign` (`project_time_task_id`),
  CONSTRAINT `tasks_teams_project_time_task_id_foreign` FOREIGN KEY (`project_time_task_id`) REFERENCES `ch_projects_times_tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tasks_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `ch_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_tasks_teams`
--

LOCK TABLES `ch_tasks_teams` WRITE;
/*!40000 ALTER TABLE `ch_tasks_teams` DISABLE KEYS */;
INSERT INTO `ch_tasks_teams` VALUES (3,2,1,'2015-10-13 17:21:17','2015-10-13 17:21:17'),(4,3,1,'2015-10-13 17:21:17','2015-10-13 17:21:17'),(5,5,1,'2015-10-13 17:21:17','2015-10-13 17:21:17');
/*!40000 ALTER TABLE `ch_tasks_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_teams`
--

DROP TABLE IF EXISTS `ch_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `teams_user_id_foreign` (`user_id`),
  CONSTRAINT `teams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_teams`
--

LOCK TABLES `ch_teams` WRITE;
/*!40000 ALTER TABLE `ch_teams` DISABLE KEYS */;
INSERT INTO `ch_teams` VALUES (1,1,'Bravo','#727272','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,2,'Alpha','#AA0055','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,'Charlie','#88FF33','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,2,'Delta','#1021EE','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,1,'Mucha','#1200fc','2015-10-13 17:19:52','2015-10-13 17:19:52');
/*!40000 ALTER TABLE `ch_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_timesheets`
--

DROP TABLE IF EXISTS `ch_timesheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_timesheets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `workday` date NOT NULL,
  `start` time NOT NULL,
  `lunch_start` time NOT NULL,
  `lunch_end` time NOT NULL,
  `lunch_hours` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `end` time NOT NULL,
  `hours` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('W','F','P','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `timesheets_user_id_foreign` (`user_id`),
  CONSTRAINT `timesheets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_timesheets`
--

LOCK TABLES `ch_timesheets` WRITE;
/*!40000 ALTER TABLE `ch_timesheets` DISABLE KEYS */;
INSERT INTO `ch_timesheets` VALUES (1,1,'2015-10-13','14:57:43','00:00:00','00:00:00','0.00','00:00:00','0.00','N','2015-10-13 17:57:43','2015-10-13 17:57:43'),(2,1,'2015-12-22','11:31:25','00:00:00','00:00:00','0.00','00:00:00','0.00','N','2015-12-22 13:31:25','2015-12-22 13:31:25'),(3,1,'2015-12-28','11:16:46','00:00:00','00:00:00','0.00','00:00:00','0.00','N','2015-12-28 13:16:46','2015-12-28 13:16:46'),(4,1,'2015-12-29','08:16:46','12:30:00','00:00:00','','00:00:00','0','N','2015-12-29 10:16:46','2015-12-29 10:16:46'),(5,1,'2015-12-30','08:03:13','10:19:00','11:20:31','01:1:00','00:00:00','0','N','2015-12-30 10:03:13','2015-12-30 13:20:31'),(6,4,'2015-12-30','15:04:20','00:00:00','00:00:00','','00:00:00','0','N','2015-12-30 17:04:20','2015-12-30 17:04:20'),(9,37,'2015-12-30','16:35:22','00:00:00','00:00:00','','00:00:00','0','N','2015-12-30 18:35:22','2015-12-30 18:35:22');
/*!40000 ALTER TABLE `ch_timesheets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_timesheets_tasks`
--

DROP TABLE IF EXISTS `ch_timesheets_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_timesheets_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timesheet_id` int(10) unsigned NOT NULL,
  `project_id` int(10) NOT NULL,
  `work_package_id` int(10) unsigned NOT NULL,
  `hours` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start` time NOT NULL,
  `end` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `timesheets_tasks_timesheet_id_foreign` (`timesheet_id`),
  KEY `timesheets_tasks_project_time_task_id_foreign` (`work_package_id`),
  CONSTRAINT `timesheets_tasks_timesheet_id_foreign` FOREIGN KEY (`timesheet_id`) REFERENCES `ch_timesheets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_timesheets_tasks`
--

LOCK TABLES `ch_timesheets_tasks` WRITE;
/*!40000 ALTER TABLE `ch_timesheets_tasks` DISABLE KEYS */;
INSERT INTO `ch_timesheets_tasks` VALUES (1,3,10,34,'01:44:0','13:19:29','15:03:59','2015-12-28 15:19:29','2015-12-28 17:03:59'),(2,3,10,33,'00:23:00','15:28:20','15:52:01','2015-12-28 17:28:20','2015-12-28 17:52:01'),(3,3,10,33,'00:0:00','15:53:00','15:53:15','2015-12-28 17:53:00','2015-12-28 17:53:15'),(4,3,10,34,'00:5:00','15:54:42','15:59:44','2015-12-28 17:54:42','2015-12-28 17:59:44'),(5,3,10,34,'00:12:00','15:56:06','16:08:35','2015-12-28 17:56:06','2015-12-28 18:08:35'),(6,3,10,34,'01:8:00','15:56:45','17:05:44','2015-12-28 17:56:45','2015-12-28 19:05:44'),(7,3,10,34,'01:8:00','15:57:18','17:06:11','2015-12-28 17:57:18','2015-12-28 19:06:11'),(8,3,10,33,'00:0:00','17:05:57','17:06:18','2015-12-28 19:05:57','2015-12-28 19:06:18'),(9,3,10,30,'00:0:00','17:09:06','17:09:33','2015-12-28 19:09:06','2015-12-28 19:09:33'),(10,3,10,29,'00:0:00','17:14:38','17:15:14','2015-12-28 19:14:38','2015-12-28 19:15:14'),(11,4,10,34,'00:4:00','08:52:23','08:56:46','2015-12-29 10:52:23','2015-12-29 10:56:46'),(12,4,10,32,'00:6:00','09:01:33','09:07:46','2015-12-29 11:01:33','2015-12-29 11:07:46'),(13,4,10,28,'00:2:00','09:11:55','09:14:06','2015-12-29 11:11:55','2015-12-29 11:14:06'),(14,4,10,31,'00:6:00','09:14:46','09:21:04','2015-12-29 11:14:46','2015-12-29 11:21:04'),(15,4,10,33,'00:2:00','09:23:51','09:25:52','2015-12-29 11:23:51','2015-12-29 11:25:52'),(16,4,10,28,'00:1:00','09:29:41','09:31:05','2015-12-29 11:29:41','2015-12-29 11:31:05'),(17,4,10,34,'00:1:00','09:32:23','09:33:53','2015-12-29 11:32:23','2015-12-29 11:33:53'),(18,4,10,30,'00:1:00','09:34:40','09:35:49','2015-12-29 11:34:40','2015-12-29 11:35:49'),(19,4,10,32,'00:1:00','09:47:44','09:49:02','2015-12-29 11:47:44','2015-12-29 11:49:02'),(20,4,10,31,'00:1:00','09:50:17','09:52:15','2015-12-29 11:50:17','2015-12-29 11:52:15'),(21,4,10,29,'01:3:00','09:55:28','10:58:44','2015-12-29 11:55:28','2015-12-29 12:58:44'),(22,4,10,33,'00:12:00','11:02:39','11:15:33','2015-12-29 13:02:39','2015-12-29 13:15:33'),(23,4,10,33,'00:12:00','11:02:48','11:15:45','2015-12-29 13:02:48','2015-12-29 13:15:45'),(24,4,10,33,'00:12:00','11:03:08','11:15:53','2015-12-29 13:03:08','2015-12-29 13:15:53'),(25,4,10,33,'00:11:00','11:04:00','11:15:59','2015-12-29 13:04:00','2015-12-29 13:15:59'),(26,4,10,33,'00:12:00','11:04:07','11:16:27','2015-12-29 13:04:07','2015-12-29 13:16:27'),(27,4,10,33,'00:11:00','11:04:53','11:16:38','2015-12-29 13:04:53','2015-12-29 13:16:38'),(28,4,10,33,'00:10:00','11:06:46','11:16:50','2015-12-29 13:06:46','2015-12-29 13:16:50'),(29,4,10,33,'00:6:00','11:10:00','11:16:54','2015-12-29 13:10:00','2015-12-29 13:16:54'),(30,4,10,33,'00:6:00','11:10:53','11:17:03','2015-12-29 13:10:53','2015-12-29 13:17:03'),(31,4,10,33,'00:6:00','11:10:57','11:17:10','2015-12-29 13:10:57','2015-12-29 13:17:10'),(32,4,10,33,'00:6:00','11:11:12','11:17:17','2015-12-29 13:11:12','2015-12-29 13:17:17'),(33,4,10,33,'00:3:00','11:14:24','11:17:33','2015-12-29 13:14:24','2015-12-29 13:17:33'),(34,4,10,30,'00:0:00','12:54:19','12:54:27','2015-12-29 14:54:19','2015-12-29 14:54:27'),(35,4,10,29,'00:17:00','12:55:00','13:12:54','2015-12-29 14:55:00','2015-12-29 15:12:54'),(36,4,10,32,'00:10:00','14:11:41','14:22:14','2015-12-29 16:11:41','2015-12-29 16:22:14'),(37,4,10,35,'00:0:00','14:22:29','14:22:31','2015-12-29 16:22:29','2015-12-29 16:22:31'),(38,4,10,30,'00:6:00','14:35:13','14:42:04','2015-12-29 16:35:13','2015-12-29 16:42:05'),(39,4,10,32,'00:17:00','14:36:02','14:53:43','2015-12-29 16:53:02','2015-12-29 16:53:43'),(40,4,10,34,'00:31:00','14:37:47','15:09:26','2015-12-29 16:55:47','2015-12-29 17:09:27'),(41,5,10,34,'00:0:00','11:23:59','11:24:11','2015-12-30 13:23:59','2015-12-30 13:24:12'),(42,6,10,29,'00:0:00','15:04:34','15:04:39','2015-12-30 17:04:34','2015-12-30 17:04:40'),(43,9,10,32,'00:3:00','16:36:05','16:39:15','2015-12-30 18:36:05','2015-12-30 18:39:16'),(44,9,10,32,NULL,'16:36:12',NULL,'2015-12-30 18:36:12','2015-12-30 18:36:12'),(45,9,10,32,NULL,'16:36:13',NULL,'2015-12-30 18:36:13','2015-12-30 18:36:13'),(46,9,10,32,NULL,'16:36:14',NULL,'2015-12-30 18:36:14','2015-12-30 18:36:14'),(47,9,10,32,NULL,'16:36:14',NULL,'2015-12-30 18:36:14','2015-12-30 18:36:14'),(48,9,10,32,NULL,'16:36:15',NULL,'2015-12-30 18:36:15','2015-12-30 18:36:15'),(49,9,10,32,NULL,'16:36:15',NULL,'2015-12-30 18:36:15','2015-12-30 18:36:15'),(50,9,10,32,NULL,'16:36:15',NULL,'2015-12-30 18:36:15','2015-12-30 18:36:15'),(51,9,10,32,NULL,'16:36:16',NULL,'2015-12-30 18:36:16','2015-12-30 18:36:16'),(52,9,10,32,NULL,'16:36:24',NULL,'2015-12-30 18:36:24','2015-12-30 18:36:24'),(53,9,10,32,NULL,'16:38:09',NULL,'2015-12-30 18:38:09','2015-12-30 18:38:09');
/*!40000 ALTER TABLE `ch_timesheets_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_users`
--

DROP TABLE IF EXISTS `ch_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rg` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('F','M') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'M',
  `status` enum('N','A','D','B') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_cpf_unique` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_users`
--

LOCK TABLES `ch_users` WRITE;
/*!40000 ALTER TABLE `ch_users` DISABLE KEYS */;
INSERT INTO `ch_users` VALUES (1,'','Admin','SVLabs','admin@svlabs.com.br','../uploads/users/photos/user_admin_1.jpg','(11) 99890-9909','12.345.678-X','123.456.789-09','1990-10-04','$2y$10$4IE5wBWK4hTiygrz/q4GgeGS7fcoSJ53rBHXI3ZQo9ZiSgLNAhGX.','M','A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Eleonor','Eleonor','Amora','admin2@svlabs.com.br','../uploads/users/photos/img-thing.jpg','(11) 99890-9909','12.345.678-X','123.456.789-19','1990-10-04','$2y$10$6sMHnB60XRgnUaBpVHvPuuvtipzNH4V8IchQY.U42LGGOFhDhCshu','F','A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'lalmeida','Leonardo','Almeida','lalmeida@svlabs.com.br','../uploads/users/photos/img-thing.jpg','(11) 99890-9909','12.345.678-X','123.456.789-11','1969-12-31','$2y$10$4IE5wBWK4hTiygrz/q4GgeGS7fcoSJ53rBHXI3ZQo9ZiSgLNAhGX.','M','A',NULL,NULL,'0000-00-00 00:00:00','2015-12-23 15:44:19'),(37,'vmorimoto','Vivian','Morimoto','vmorimoto@svlabs.com.br','../uploads/users/photos/keep-calm-and-foca-no-feriado-7.png','(11) 30551-977_','08.971.395-1','065.634.529-22','1988-05-03','$2y$10$su9Ug2sayadpfqpINyLzY.F83U3UG9l8MYEFL2Ji4D9nWKnEfcvhW','M','N','1s5BSBlq9RzsEFojvX1w0qlD6F8D1r',NULL,'2015-12-30 18:32:55','2015-12-30 18:32:55');
/*!40000 ALTER TABLE `ch_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_users_benefits`
--

DROP TABLE IF EXISTS `ch_users_benefits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_users_benefits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `vr` decimal(15,2) NOT NULL,
  `vt` decimal(15,2) NOT NULL,
  `health_care_agreement` decimal(15,2) NOT NULL,
  `salary` decimal(15,2) NOT NULL,
  `assistance_contibution` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_benefits_user_id_foreign` (`user_id`),
  CONSTRAINT `users_benefits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_users_benefits`
--

LOCK TABLES `ch_users_benefits` WRITE;
/*!40000 ALTER TABLE `ch_users_benefits` DISABLE KEYS */;
/*!40000 ALTER TABLE `ch_users_benefits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_users_localization`
--

DROP TABLE IF EXISTS `ch_users_localization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_users_localization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `latitude` text COLLATE utf8_unicode_ci NOT NULL,
  `longitude` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_localization_user_id_foreign` (`user_id`),
  CONSTRAINT `users_localization_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_users_localization`
--

LOCK TABLES `ch_users_localization` WRITE;
/*!40000 ALTER TABLE `ch_users_localization` DISABLE KEYS */;
INSERT INTO `ch_users_localization` VALUES (1,1,'-23.4949883','-46.8467602','2015-12-22 10:21:49','2015-12-22 10:21:49'),(2,1,'-23.4954','-46.8477122','2015-12-22 10:23:37','2015-12-22 10:23:37');
/*!40000 ALTER TABLE `ch_users_localization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_users_notifications`
--

DROP TABLE IF EXISTS `ch_users_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_users_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `faicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `see` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `users_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_users_notifications`
--

LOCK TABLES `ch_users_notifications` WRITE;
/*!40000 ALTER TABLE `ch_users_notifications` DISABLE KEYS */;
INSERT INTO `ch_users_notifications` VALUES (1,1,'group','Voc&ecirc; criou e &eacute; lider da equipe <strong>Mucha</strong>',0,'2015-10-13 17:19:53','2015-10-13 17:19:53'),(2,2,'group','Voc&ecirc; faz parte da equipe <strong>Mucha</strong>',0,'2015-10-13 17:19:53','2015-10-13 17:19:53');
/*!40000 ALTER TABLE `ch_users_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_users_settings`
--

DROP TABLE IF EXISTS `ch_users_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_users_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `skin` text COLLATE utf8_unicode_ci,
  `boxed` text COLLATE utf8_unicode_ci,
  `sidebar_toggle` text COLLATE utf8_unicode_ci,
  `right_sidebar_slide` text COLLATE utf8_unicode_ci,
  `right_sidebar_white` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_settings_user_id_foreign` (`user_id`),
  CONSTRAINT `users_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_users_settings`
--

LOCK TABLES `ch_users_settings` WRITE;
/*!40000 ALTER TABLE `ch_users_settings` DISABLE KEYS */;
INSERT INTO `ch_users_settings` VALUES (2,1,'skin-black-light','false','false','control-sidebar-open','true','2015-12-22 10:51:45','2015-12-22 10:51:45'),(3,4,'skin-black-light','false','false','control-sidebar-open','true','2015-12-22 10:51:45','2015-12-22 10:51:45'),(6,37,'skin-yellow','false','false','control-sidebar-open','true','2015-12-30 18:32:55','2015-12-30 18:32:55');
/*!40000 ALTER TABLE `ch_users_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_users_teams`
--

DROP TABLE IF EXISTS `ch_users_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ch_users_teams` (
  `user_id` int(10) unsigned NOT NULL,
  `team_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `users_teams_user_id_foreign` (`user_id`),
  KEY `users_teams_team_id_foreign` (`team_id`),
  CONSTRAINT `users_teams_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `ch_teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_teams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `ch_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_users_teams`
--

LOCK TABLES `ch_users_teams` WRITE;
/*!40000 ALTER TABLE `ch_users_teams` DISABLE KEYS */;
INSERT INTO `ch_users_teams` VALUES (1,5,'2015-10-13 17:19:52','2015-10-13 17:19:52'),(2,5,'2015-10-13 17:19:53','2015-10-13 17:19:53'),(1,1,'2015-10-13 17:19:52','2015-10-13 17:19:52'),(2,1,'2015-10-13 17:19:53','2015-10-13 17:19:53'),(1,2,'2015-10-13 17:19:52','2015-10-13 17:19:52'),(2,2,'2015-10-13 17:19:53','2015-10-13 17:19:53'),(1,3,'2015-10-13 17:19:52','2015-10-13 17:19:52'),(2,3,'2015-10-13 17:19:53','2015-10-13 17:19:53'),(1,4,'2015-10-13 17:19:52','2015-10-13 17:19:52'),(2,4,'2015-10-13 17:19:53','2015-10-13 17:19:53');
/*!40000 ALTER TABLE `ch_users_teams` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-04  9:27:32
