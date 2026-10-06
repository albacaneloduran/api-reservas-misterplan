CREATE DATABASE  IF NOT EXISTS `misterplan_reservas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `misterplan_reservas`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: misterplan_reservas
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserva` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_huesped` varchar(120) NOT NULL,
  `email_huesped` varchar(150) NOT NULL,
  `nombre_alojamiento` varchar(150) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada') NOT NULL DEFAULT 'pendiente',
  `importe` decimal(10,2) NOT NULL,
  `notas` text,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (1,'Alba Canelo','alba@email.com','Apartamento Rural Cáceres','2026-11-10','2026-11-15','pendiente',250.00,NULL,'2026-10-06 00:17:56');
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva_evento`
--

DROP TABLE IF EXISTS `reserva_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserva_evento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserva_id` int NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_evento_reserva` (`reserva_id`),
  CONSTRAINT `fk_evento_reserva` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva_evento`
--

LOCK TABLES `reserva_evento` WRITE;
/*!40000 ALTER TABLE `reserva_evento` DISABLE KEYS */;
INSERT INTO `reserva_evento` VALUES (1,1,'CREACION','Reserva creada inicialmente en estado pendiente','2026-10-06 00:17:56');
/*!40000 ALTER TABLE `reserva_evento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06  0:26:18
