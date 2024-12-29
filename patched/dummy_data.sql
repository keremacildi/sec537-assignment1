USE cs437project;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: cs437project
-- ------------------------------------------------------
-- Server version	11.4.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dummy_data`
--

DROP TABLE IF EXISTS `dummy_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dummy_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `registered_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dummy_data`
--

LOCK TABLES `dummy_data` WRITE;
/*!40000 ALTER TABLE `dummy_data` DISABLE KEYS */;
INSERT INTO `dummy_data` VALUES (1,'Alice Johnson','alice.johnson@example.com',25,'USA','2024-12-25 19:08:24'),(2,'Bob Smith','bob.smith@example.com',30,'UK','2024-12-25 19:08:24'),(3,'Charlie Brown','charlie.brown@example.com',35,'Canada','2024-12-25 19:08:24'),(4,'Daisy Ridley','daisy.ridley@example.com',28,'Australia','2024-12-25 19:08:24'),(5,'Ethan Hunt','ethan.hunt@example.com',40,'USA','2024-12-25 19:08:24'),(6,'Fiona Clarke','fiona.clarke@example.com',22,'Ireland','2024-12-25 19:08:24'),(7,'George Miller','george.miller@example.com',45,'Germany','2024-12-25 19:08:24'),(8,'Hannah White','hannah.white@example.com',29,'France','2024-12-25 19:08:24'),(9,'Isaac Newton','isaac.newton@example.com',50,'UK','2024-12-25 19:08:24'),(10,'Jane Doe','jane.doe@example.com',33,'Canada','2024-12-25 19:08:24');
/*!40000 ALTER TABLE `dummy_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-25 23:04:23
