-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: SocialMedia
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

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
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_Publication` int NOT NULL,
  `id_compte` int NOT NULL,
  `contenu` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Publication` (`id_Publication`),
  KEY `id_compte` (`id_compte`),
  CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`id_Publication`) REFERENCES `Publication` (`id`),
  CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`id_compte`) REFERENCES `Compte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
INSERT INTO `Comments` VALUES (19,11,5,'LOl XD','2024-09-24 09:25:50'),(21,11,1,'Marina zany akiii a','2024-09-24 10:34:54'),(27,19,1,'Ndana maka ao amin\'ny siten\'ny unity','2024-09-27 07:27:41'),(29,19,2,'Tsidio ito rohy ito : https://unity.com/download','2024-09-30 22:44:05'),(32,21,2,'here -> https://legacy.reactjs.org/docs/getting-started.html ','2024-10-01 07:09:59');
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Compte`
--

DROP TABLE IF EXISTS `Compte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Compte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Compte`
--

LOCK TABLES `Compte` WRITE;
/*!40000 ALTER TABLE `Compte` DISABLE KEYS */;
INSERT INTO `Compte` VALUES (1,'RANDRIA','Liantsoa','liantsoarandrianasimbolarivelo@gmail.com','liantsoa08'),(2,'RANDRIA','Liantsoa','liantsoa@gmail.com','liantsoa08'),(3,'RANDRIA','admin','adm@gmail.com','adm08'),(4,'ADM','admin','adm@gmail.com','liantsoa08'),(5,'Hents','Mins','andriamifidyhenintsoa@gmail.com','Mowglette10'),(6,'Hents','Mins','andriamifidyhenintsoa@gmail.com','moglette10');
/*!40000 ALTER TABLE `Compte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Publication`
--

DROP TABLE IF EXISTS `Publication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Publication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compte` int NOT NULL,
  `contenu` text NOT NULL,
  `date_pub` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`),
  CONSTRAINT `Publication_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `Compte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Publication`
--

LOCK TABLES `Publication` WRITE;
/*!40000 ALTER TABLE `Publication` DISABLE KEYS */;
INSERT INTO `Publication` VALUES (9,1,'Ahoana ny fiompiana trondro anaty trano?','2024-09-24 00:43:38'),(11,5,'Houeeeeee efa mandeha amin&#039;izay ehhhhh','2024-09-24 09:25:14'),(12,5,'salut  le  con','2024-09-24 15:01:46'),(19,1,'Ahooana ny fomba iinstallena Unity','2024-09-27 07:26:18'),(21,2,'Can I get the documentation of ReactJs','2024-09-30 22:50:15');
/*!40000 ALTER TABLE `Publication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reaction`
--

DROP TABLE IF EXISTS `Reaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reaction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_publication` int NOT NULL,
  `id_compte` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_publication` (`id_publication`),
  KEY `id_compte` (`id_compte`),
  CONSTRAINT `Reaction_ibfk_1` FOREIGN KEY (`id_publication`) REFERENCES `Publication` (`id`),
  CONSTRAINT `Reaction_ibfk_2` FOREIGN KEY (`id_compte`) REFERENCES `Compte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reaction`
--

LOCK TABLES `Reaction` WRITE;
/*!40000 ALTER TABLE `Reaction` DISABLE KEYS */;
INSERT INTO `Reaction` VALUES (2,9,1,'like','2024-09-24 14:33:50'),(4,9,5,'like','2024-09-24 14:36:31'),(5,11,5,'like','2024-09-24 15:23:02'),(6,12,1,'dislike','2024-09-25 11:33:35'),(9,11,2,'like','2024-09-26 20:38:30'),(10,9,2,'like','2024-09-26 20:46:58'),(11,11,1,'like','2024-09-26 23:41:56'),(12,19,1,'like','2024-09-27 07:26:23'),(15,19,2,'like','2024-09-30 22:49:31'),(16,21,2,'dislike','2024-09-30 23:03:31');
/*!40000 ALTER TABLE `Reaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ReactionComment`
--

DROP TABLE IF EXISTS `ReactionComment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ReactionComment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_comment` int NOT NULL,
  `id_compte` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_comment` (`id_comment`),
  KEY `id_compte` (`id_compte`),
  CONSTRAINT `ReactionComment_ibfk_1` FOREIGN KEY (`id_comment`) REFERENCES `Comments` (`id`),
  CONSTRAINT `ReactionComment_ibfk_2` FOREIGN KEY (`id_compte`) REFERENCES `Compte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ReactionComment`
--

LOCK TABLES `ReactionComment` WRITE;
/*!40000 ALTER TABLE `ReactionComment` DISABLE KEYS */;
INSERT INTO `ReactionComment` VALUES (4,19,1,'like','2024-09-26 23:15:59'),(5,21,1,'like','2024-09-26 23:41:50'),(6,27,1,'like','2024-09-27 07:27:45'),(8,32,2,'like','2024-09-30 23:18:34'),(9,21,2,'like','2024-10-01 07:14:06'),(10,32,1,'dislike','2024-10-01 11:14:14');
/*!40000 ALTER TABLE `ReactionComment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-01 21:02:36
