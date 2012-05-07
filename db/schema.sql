-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: databibDB
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

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
-- Table structure for table `approved`
--

create database databibDB;
use databibDB;

DROP TABLE IF EXISTS `approved`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `approved` (
  `id_rep` int(11) NOT NULL AUTO_INCREMENT,
  `rep_title` varchar(512) NOT NULL,
  `rep_url` varchar(2048) NOT NULL,
  `rep_authority` varchar(512) NOT NULL,
  `rep_description` text,
  `rep_status` varchar(32) DEFAULT NULL,
  `rep_startdate` varchar(32) DEFAULT NULL,
  `rep_location` varchar(32) DEFAULT NULL,
  `rep_access` varchar(512) DEFAULT NULL,
  `rep_deposit` varchar(512) DEFAULT NULL,
  `rep_type` varchar(32) DEFAULT NULL,
  `rep_editors` varchar(512) DEFAULT NULL,
  `submitter` varchar(32) DEFAULT NULL,
  `contributors` varchar(1024) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  PRIMARY KEY (`id_rep`),
  FULLTEXT KEY `rep_title` (`rep_title`,`rep_description`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(1024) NOT NULL,
  `author` varchar(256) NOT NULL,
  `approved` varchar(8) NOT NULL,
  `recordid` int(11) NOT NULL,
  `editor` varchar(256) NOT NULL,
  `postdate` datetime NOT NULL,
  `authorfullname` varchar(256) NOT NULL,
  PRIMARY KEY (`id_comment`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notapproved`
--

DROP TABLE IF EXISTS `notapproved`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notapproved` (
  `id_rep` int(11) NOT NULL AUTO_INCREMENT,
  `rep_title` varchar(512) NOT NULL,
  `rep_url` varchar(2048) NOT NULL,
  `rep_authority` varchar(512) NOT NULL,
  `rep_subjects` varchar(512) NOT NULL,
  `rep_description` text,
  `rep_status` varchar(32) DEFAULT NULL,
  `rep_startdate` varchar(32) DEFAULT NULL,
  `rep_location` varchar(32) DEFAULT NULL,
  `rep_access` varchar(512) DEFAULT NULL,
  `rep_deposit` varchar(512) DEFAULT NULL,
  `rep_type` varchar(32) DEFAULT NULL,
  `rep_editors` varchar(512) DEFAULT NULL,
  `submitter` varchar(32) DEFAULT NULL,
  `contributors` varchar(1024) DEFAULT NULL,
  `rep_link_to_approved` int(11) DEFAULT NULL,
  `assignedtoeditor` varchar(8) DEFAULT NULL,
  `reviewed` varchar(8) DEFAULT NULL,
  `subjectheading_ids` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id_rep`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id_subject` int(11) NOT NULL AUTO_INCREMENT,
  `sub_title` varchar(128) NOT NULL DEFAULT '',
  `sub_url` varchar(1024) DEFAULT NULL,
  `broadersubjects` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id_subject`,`sub_title`),
  KEY `subjecttitle` (`sub_title`)
) ENGINE=MyISAM AUTO_INCREMENT=402741 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `user_role` varchar(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `confirmcode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-12-15  0:31:44
