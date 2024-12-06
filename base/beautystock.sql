-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: beautystock
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (25,'5594554','veronica','67676','Caaguazu','14 de mayo');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `precio` decimal(65,0) NOT NULL,
  `stock` int NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Labial roj','Labial mate de larga duracion',30000,16,'2024-11-19 14:32:30'),(2,'Crema Hidratante ','Crema facial con acido hialuronico 250 gr',50000,10,'2024-11-19 14:32:30'),(3,'Base OG','Base OG comfort matte 125 Warm Nude 30ml',40000,49,'2024-11-19 14:50:35'),(4,'Base OG','Base OG comfort matte 125 Warm Nude 30ml',40000,10,'2024-11-19 14:54:18'),(5,'Corrector OG','Nro 03 5ml',35000,48,'2024-11-19 14:55:30'),(6,'Corrector OG','Nro 03 5ml',35000,40,'2024-11-19 14:57:27'),(7,'Corrector OG','Nro 03 5ml',35000,6,'2024-11-19 15:06:10'),(9,'Nivea Soft Crema','Suave y refrescante crema humectante 98gr',40000,49,'2024-11-19 16:55:29'),(10,'Ruby Rose Polvo Translucido','Polvo translucido matificante 7,5g',40000,11,'2024-11-19 17:10:43'),(11,'Base Melu by Ruby Rose','Base liquida, cobertura media, aloe vera, pantenol 29ml',50000,2,'2024-11-19 17:41:30'),(12,'Ruby Rose Blush','Rubor HB-6104 7.4G',50000,15,'2024-11-19 20:52:50'),(13,'Ruby Rose Blush 024','tono 024',50000,39,'2024-11-20 19:41:05'),(14,'Ruby Rose Corrector 5ml','tono 02',40000,39,'2024-11-20 21:32:38'),(15,'Labial Rosa OG','Labial mate de larga duracion',50000,0,'2024-11-20 21:35:43'),(16,'Labial Rosa ','rosa',50000,17,'2024-11-20 22:13:26'),(17,'Base Loreal Paris','tono 1',115000,18,'2024-11-20 22:44:43'),(18,'LA ROCHE-POSAY Protector solar','anti-brillos Rostro 50+SPF 50ML',124000,12,'2024-11-22 14:01:09'),(19,'Maybelline Labial','Vinyl ink Lippy Labial liquido',99000,36,'2024-11-22 14:54:33'),(25,'Crema facial','crema 50gr',50000,18,'2024-11-27 23:10:52'),(26,'Mascarilla Facial','mascarilla 5g',10000,18,'2024-11-27 23:16:57'),(27,'Mascarilla Facial','mascarilla 5g',10000,20,'2024-11-27 23:17:10'),(28,'Rubor Melu','rubor tono 02',40000,18,'2024-11-29 23:18:48'),(29,'Mascara TG','Mascara depestañas',30000,28,'2024-12-01 15:31:52'),(30,'base  Rubi 01','TONO 01',30000,27,'2024-12-02 21:48:21'),(31,'base Maybelline','tono 01',110000,50,'2024-12-05 14:11:46');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_cliente` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ci_cliente` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono_cliente` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion_cliente` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,1,1,'2024-11-19 17:46:37',NULL,NULL,NULL,NULL,NULL),(2,1,2,'2024-11-19 17:47:01',NULL,NULL,NULL,NULL,NULL),(3,7,1,'2024-11-19 19:19:09','Veronnica','12345','12345','Caaguazu',NULL),(4,10,1,'2024-11-19 19:19:22','Veronnica','12345','12345','Caaguazu',NULL),(5,10,2,'2024-11-19 19:21:54','Veronnica','1234555','12345','Caaguazu',NULL),(6,10,2,'2024-11-19 19:34:51','Veronnica','1234555','12345','Caaguazu',NULL),(7,10,2,'2024-11-19 19:34:57','Veronnica','1234555','12345','Caaguazu',NULL),(8,1,1,'2024-11-19 19:36:41','Veronnica','1234555','12345','Caaguazu',NULL),(9,1,1,'2024-11-19 19:37:20','Veronnica','1234555','12345','Caaguazu',NULL),(10,1,1,'2024-11-19 19:37:25','Veronnica','1234555','12345','Caaguazu',NULL),(11,1,1,'2024-11-19 19:37:59','Veronnica','1234555','12345','Caaguazu',NULL),(12,1,1,'2024-11-19 19:38:03','Veronnica','1234555','12345','Caaguazu',NULL),(13,1,1,'2024-11-19 19:40:23','Veronnica','1234555','12345','Caaguazu',NULL),(14,3,2,'2024-11-19 19:41:53','Veronnica','1234555','12345','Caaguazu',NULL),(15,9,2,'2024-11-19 19:43:34','Veronnica','1234555','12345','Caaguazu',NULL),(16,9,2,'2024-11-19 19:44:29','Veronnica','1234555','12345','Caaguazu',NULL),(17,9,2,'2024-11-19 19:45:08','Veronnica','1234555','12345','Caaguazu',NULL),(18,9,2,'2024-11-19 19:51:44','Veronnica','1234555','12345','Caaguazu',NULL),(19,9,2,'2024-11-19 19:51:49','Veronnica','1234555','12345','Caaguazu',NULL),(20,5,2,'2024-11-19 19:56:29','Veronnica','1234555','12345','Caaguazu',NULL),(21,5,2,'2024-11-19 19:57:40','Veronnica','1234555','12345','Caaguazu',NULL),(22,11,2,'2024-11-19 20:00:09','lore','1234555','12345','Caaguazu',NULL),(23,11,2,'2024-11-19 20:03:19','lore','1234555','12345','Caaguazu',NULL),(24,11,2,'2024-11-19 20:07:25','lore','1234555','12345','Caaguazu',NULL),(25,11,2,'2024-11-19 20:19:10','lore','1234555','12345','Caaguazu',NULL),(26,11,2,'2024-11-19 20:20:09','lore','1234555','12345','Caaguazu',NULL),(27,11,2,'2024-11-19 20:28:38','lore','1234555','12345','Caaguazu',NULL),(28,10,2,'2024-11-19 20:46:31','lore','56789','789','Caaguazu',NULL),(29,12,1,'2024-11-19 21:16:23','lore','56789','789','Caaguazu',NULL),(30,12,1,'2024-11-19 21:16:28','lore','56789','789','Caaguazu',NULL),(31,12,2,'2024-11-19 21:35:35','Vero','1234555','345678','Caaguazu',NULL),(32,12,2,'2024-11-19 21:39:32','Vero','1234555','345678','Caaguazu',NULL),(33,12,2,'2024-11-19 21:48:50','Vero','1234555','345678','Caaguazu',NULL),(34,12,2,'2024-11-19 21:49:02','Veronica Oviedo','1234555','345678','Caaguazu',NULL),(35,12,1,'2024-11-19 22:41:33','Veronnica','12345','345678','Caaguazu',NULL),(36,12,1,'2024-11-19 22:41:53','Veronnica','12345','345678','Caaguazu',NULL),(37,12,1,'2024-11-19 22:51:44','Veronnica','12345','345678','Caaguazu',NULL),(38,12,1,'2024-11-19 22:51:49','Veronnica','12345','345678','Caaguazu',NULL),(39,12,1,'2024-11-19 22:59:42',NULL,NULL,NULL,NULL,NULL),(40,12,1,'2024-11-19 23:13:17','Veronnica','12345','345678','Caaguazu',NULL),(41,12,1,'2024-11-19 23:15:28','Veronnica','12345','345678','Caaguazu',NULL),(42,12,1,'2024-11-19 23:20:37','Veronnica','12345','345678','Caaguazu',NULL),(43,12,1,'2024-11-19 23:34:12','Veronica Oviedo','1234555','345678','Caaguazu',NULL),(44,12,3,'2024-11-19 23:44:06','Veronica Oviedo','1234555','345678','Caaguazu',NULL),(45,12,3,'2024-11-19 23:46:11','Veronica Oviedo','1234555','345678','Caaguazu',NULL),(46,11,1,'2024-11-20 01:20:28','deisy','8979','789','Caagua',NULL),(47,11,1,'2024-11-20 01:20:36','deisy','8979','789','Caaguazu',NULL),(48,11,1,'2024-11-20 02:07:41','deisy','8979','789','Caaguazu',NULL),(49,11,1,'2024-11-20 02:09:03','deisy','8979','789','Caaguazu',NULL),(50,11,1,'2024-11-20 02:16:46','deisy','8979','789','Caaguazu',NULL),(51,11,1,'2024-11-20 14:37:27','deisy','8979','789','Caaguazu',NULL),(52,1,1,'2024-11-20 14:58:50','deisy','8979','789','Caaguazu',NULL),(53,13,1,'2024-11-20 19:41:20','deisy','8979','789','Caaguazu',NULL),(54,14,1,'2024-11-20 21:32:56','deisy','8979','789','Caaguazu',NULL),(55,15,19,'2024-11-20 21:36:17','Wilder','45678','456789','Caaguazu',NULL),(56,16,1,'2024-11-20 22:13:40','Wilder','45678','456789','Caaguazu',NULL),(57,17,2,'2024-11-20 22:45:10','Jnaini','34567','3456789','Caaguazu',NULL),(58,19,1,'2024-11-22 18:38:22','Jnaini','34567','3456789','Caaguazu',NULL),(59,18,2,'2024-11-22 22:00:35','meli','34567','56789','Caaguazu',NULL),(60,18,2,'2024-11-22 22:00:51','meli','34567','56789','Caaguazu',NULL),(61,19,3,'2024-11-22 22:12:28','SDFGHJK','4567890','3456789','Caaguazu',NULL),(62,18,2,'2024-11-27 22:23:50','Jnaini','456789','67890','kjh',NULL),(63,18,2,'2024-11-27 22:24:03','Jnaini','456789','67890','kjh',NULL),(64,1,1,'2024-11-27 23:06:47','Vero','1234555','67890','kjh',NULL),(65,25,1,'2024-11-27 23:11:48','osvaldo','1234555','67890','kjh',NULL),(66,25,1,'2024-11-27 23:11:57','osvaldo','1234555','67890','kjh',NULL),(69,28,1,'2024-11-30 03:07:57','Veronnica','1234555','345678','Caaguazu',40000.00),(70,28,1,'2024-11-30 03:08:00','Veronnica','1234555','345678','Caaguazu',40000.00),(71,29,1,'2024-12-01 15:32:09','Veronnica','4567890','345678','Caaguazu',30000.00),(76,5,1,'2024-12-03 17:10:37','Veronnica','12345','123456','Caaguazu',35000.00),(77,5,1,'2024-12-03 17:10:43','Veronnica','12345','123456','Caaguazu',35000.00),(78,15,1,'2024-12-03 18:33:43','Veronica O','55945543','0955555555','14 de mayo',50000.00),(80,1,1,'2024-12-05 14:18:43','veronica','5594554','67676','14 de mayo',30000.00),(81,1,1,'2024-12-05 14:18:48','veronica','5594554','67676','14 de mayo',30000.00);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-05 11:21:21
