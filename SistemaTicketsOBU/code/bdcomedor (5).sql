-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bdcomedor
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actividad_estudiantes`
--

DROP TABLE IF EXISTS `actividad_estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad_estudiantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `accion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `actividad_estudiantes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad_estudiantes`
--

LOCK TABLES `actividad_estudiantes` WRITE;
/*!40000 ALTER TABLE `actividad_estudiantes` DISABLE KEYS */;
INSERT INTO `actividad_estudiantes` VALUES (1,1,'Generó un ticket para desayuno','2025-07-06 02:10:59'),(2,2,'Solicitó cambio de menú','2025-07-06 02:10:59'),(3,3,'Se presentó sin ticket','2025-07-06 02:10:59'),(4,4,'Actualizó sus datos personales','2025-07-10 15:15:32'),(6,6,'Canceló un ticket','2025-07-10 17:45:01'),(7,7,'Solicitó ayuda técnica','2025-07-10 18:32:22'),(8,8,'Generó un ticket para desayuno','2025-07-11 12:45:00'),(9,9,'Se presentó sin carnet','2025-07-11 13:10:00'),(10,10,'Solicitó cambio de menú','2025-07-11 14:00:00'),(11,11,'Anuló un ticket duplicado','2025-07-11 14:15:00'),(12,12,'Generó un ticket para cena','2025-07-11 17:30:00'),(13,13,'Consultó su historial de asistencia','2025-07-11 18:10:00'),(14,14,'Reportó error en su beca','2025-07-11 19:00:00'),(15,15,'Actualizó correo institucional','2025-07-11 19:30:00'),(16,16,'Solicitó soporte por app','2025-07-11 20:00:00'),(17,17,'Generó un ticket para desayuno','2025-07-11 21:00:00'),(18,18,'Ingresó al comedor sin ticket','2025-07-11 22:00:00'),(19,19,'Anuló ticket por error','2025-07-11 22:30:00'),(20,20,'Consultó horarios del comedor','2025-07-11 23:00:00'),(21,21,'Generó ticket y lo anuló luego','2025-07-11 23:30:00'),(22,22,'Reportó incidente en fila','2025-07-12 00:00:00'),(23,23,'Generó un ticket para cena','2025-07-12 00:30:00');
/*!40000 ALTER TABLE `actividad_estudiantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `fecha_ingreso` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencias`
--

LOCK TABLES `asistencias` WRITE;
/*!40000 ALTER TABLE `asistencias` DISABLE KEYS */;
INSERT INTO `asistencias` VALUES (2,2,'2026-07-16 17:01:06'),(3,3,'2026-07-15 17:01:06'),(4,5,'2026-07-13 17:01:06'),(5,6,'2026-07-13 12:00:00'),(6,7,'2026-07-14 13:00:00'),(7,8,'2026-07-14 13:15:00'),(8,9,'2026-07-14 13:30:00'),(9,10,'2026-07-15 14:00:00'),(10,11,'2026-07-15 14:15:00'),(11,12,'2026-07-15 15:00:00'),(12,13,'2026-07-16 15:30:00'),(13,14,'2026-07-16 16:00:00'),(14,15,'2026-07-16 16:30:00'),(15,16,'2026-07-17 17:00:00'),(16,17,'2026-07-17 17:15:00'),(17,18,'2026-07-17 17:30:00'),(18,19,'2026-07-13 18:00:00'),(19,20,'2026-07-13 18:15:00'),(20,21,'2026-07-13 18:30:00'),(21,22,'2026-07-14 19:00:00'),(22,23,'2026-07-14 19:15:00'),(23,24,'2026-07-14 19:30:00');
/*!40000 ALTER TABLE `asistencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(50) NOT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (1,'limite_tickets_diarios','1'),(2,'hora_cierre_emision','19:00:00'),(3,'limite_tickets_becados','1000'),(4,'limite_tickets_no_becados','500');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidencias`
--

DROP TABLE IF EXISTS `incidencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencias`
--

LOCK TABLES `incidencias` WRITE;
/*!40000 ALTER TABLE `incidencias` DISABLE KEYS */;
INSERT INTO `incidencias` VALUES (1,1,'Olvidó su carnet','2025-07-10 08:15:00'),(2,1,'Se presentó fuera de horario.','2025-06-22 16:59:36'),(3,1,'No respetó el orden de ingreso.','2025-06-22 16:59:36'),(4,1,'Problema con validación del ticket.','2025-06-22 16:59:36'),(5,1,'vgvhhbnbn','2025-07-05 00:00:00'),(6,2,'no uso su ticket','2025-07-07 00:00:00'),(8,8,'Reclamo por comida fría','2025-07-10 10:00:00'),(9,9,'Intentó duplicar ticket','2025-07-10 10:15:00'),(10,10,'Discrepancia con tipo de comida','2025-07-10 10:30:00'),(11,11,'No respetó su turno','2025-07-10 10:45:00'),(12,12,'Problemas con beca','2025-07-10 11:00:00'),(13,13,'Reportó incidente en comedor','2025-07-10 11:15:00'),(14,14,'Comida en mal estado','2025-07-10 11:30:00'),(15,15,'Ruido excesivo','2025-07-10 11:45:00'),(16,16,'No portaba identificación','2025-07-10 12:00:00'),(17,17,'Intentó ingresar por otra puerta','2025-07-10 12:15:00'),(18,18,'Se negó a mostrar ticket','2025-07-10 12:30:00'),(20,20,'Inasistencia repetida sin justificación','2025-07-10 13:00:00');
/*!40000 ALTER TABLE `incidencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs_ingreso`
--

DROP TABLE IF EXISTS `logs_ingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs_ingreso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `logs_ingreso_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs_ingreso`
--

LOCK TABLES `logs_ingreso` WRITE;
/*!40000 ALTER TABLE `logs_ingreso` DISABLE KEYS */;
INSERT INTO `logs_ingreso` VALUES (2,1,'192.168.0.105','Mozilla/5.0 (Linux)','2025-06-22 22:00:08'),(3,1,'192.168.0.110','Chrome/90.0 (Windows)','2025-06-22 22:00:08');
/*!40000 ALTER TABLE `logs_ingreso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platos_del_dia`
--

DROP TABLE IF EXISTS `platos_del_dia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platos_del_dia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `tipo_comida_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fecha` (`fecha`,`tipo_comida_id`),
  KEY `tipo_comida_id` (`tipo_comida_id`),
  CONSTRAINT `platos_del_dia_ibfk_1` FOREIGN KEY (`tipo_comida_id`) REFERENCES `tipo_comida` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platos_del_dia`
--

LOCK TABLES `platos_del_dia` WRITE;
/*!40000 ALTER TABLE `platos_del_dia` DISABLE KEYS */;
INSERT INTO `platos_del_dia` VALUES (5,'2025-06-23',2,'Arroz con pollo y ensalada rusa'),(6,'2025-06-24',2,'Tallarin rojo con papa a la huancaína'),(7,'2025-06-25',2,'Lentejas con arroz y huevo frito '),(8,'2025-06-26',2,'Ají de gallina con arroz blanco'),(9,'2025-06-27',2,'Estofado de carne con papas y arroz'),(10,'2025-06-28',2,'Arroz con pollo'),(11,'2025-07-08',2,'Arroz con pollo, ensalada rusa y refresco de maracuyá'),(12,'2025-07-09',2,'Lentejas con arroz, apanado de pollo y limonada'),(13,'2025-07-10',2,'Tallarin rojo con presa de pollo y chicha morada'),(14,'2025-07-11',2,'Seco de res con frejoles, arroz blanco y refresco de cebada'),(15,'2025-07-12',2,'Ají de gallina con arroz blanco y refresco de hierba luisa'),(16,'2025-07-13',2,'Estofado de pollo con arroz y refresco de manzana'),(17,'2025-07-14',2,'Arroz chaufa de pollo con salsa de soja y té helado'),(18,'2025-07-21',2,'Arroz con pollo y ensalada de zanahoria'),(19,'2025-07-22',2,'Tallarín verde con papa a la huancaína'),(20,'2025-07-23',2,'Menestrón con trozos de carne y arroz'),(21,'2025-07-24',2,'Ají de gallina con arroz y aceitunas'),(22,'2025-07-25',2,'Lomo saltado con arroz y papas fritas'),(23,'2026-07-13',2,'Pachamanca especial por Fiestas Patrias'),(24,'2026-07-14',2,'Carapulcra con sopa seca'),(25,'2026-07-15',2,'Seco de pollo con frejoles'),(26,'2026-07-16',2,'Arroz tapado con huevo y plátano'),(27,'2026-07-17',2,'Causa rellena y escabeche de pollo'),(28,'2026-07-13',1,'Pan con queso, pan con palta, cuaquer y mandarina'),(30,'2026-07-13',3,'Sopa criolla y pan (prueba cena)'),(31,'2026-07-14',1,'Pan con mermelada, pan con torreja, cafe con leche y 1 huevo sancochado'),(32,'2026-07-15',1,'Pan con lomo, pan con jamonada, soya y galleta rellenitas'),(33,'2026-07-16',1,'Pan integral con palta, pan con tortilla, emoliente y queque'),(34,'2026-07-17',1,'Pan con queso, pan con palta, cuaquer y mandarina'),(35,'2026-07-20',1,'Pan con Torreja, pan con camote, cuaquer y huevo sancochado');
/*!40000 ALTER TABLE `platos_del_dia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `university_code` varchar(20) NOT NULL,
  `email_institutional` varchar(100) DEFAULT NULL,
  `facultad` varchar(150) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `gender` enum('masculino','femenino','otro') DEFAULT NULL,
  `is_scholarship` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `university_code` (`university_code`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'Leydi Veronica Aguilar Mendoza','09343655','2225220281','lvaguilarm@unac.edu.pe','FIIS','+51912345678','femenino',1,'2025-06-22 01:27:25','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(2,'Luis Fernando Pérez Gómez ','09345678','2225220258','lpgomez@unac.edu.pe','FIPA','+51923456789','masculino',0,'2025-06-22 01:27:25','$2y$10$bXNHE2L7S/MWhhgByrPjd.b19.AsvlZiFVE5kNztIqE3.17z0ubve'),(3,'María Carla Ortiz Ruiz','09567890','2225220283','mortizruiz@unac.edu.pe','FIQ','+51934567890','femenino',0,'2025-06-22 01:27:25','$2y$10$avgOOg2mENgxesFJpdrYkufkSJkZDwGQv0AtQ9lfweHZpbNax5m/2'),(4,'Andrés Torres Salas','09311111','2225220284','atorress@unac.edu.pe','Ciencias de la Salud','+51987654321','masculino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(5,'Camila Ríos Luján','09322222','2225220285','crioslujan@unac.edu.pe','Ciencias Economicas','+51987654322','femenino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(6,'Jorge Villanueva Pérez','09333333','2225220286','jvillaperez@unac.edu.pe','Administracion','+51987654323','masculino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(7,'Luciana Huamán Cordero','09344444','2225220287','lhuamanc@unac.edu.pe','FIEE','+51987654324','femenino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(8,'Diego Ramírez Soto','09355555','2225220288','dramirezs@unac.edu.pe','FIIS','+51987654325','masculino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(9,'Valeria Paredes Flores','09366666','2225220289','vparedesf@unac.edu.pe','FIPA','+51987654326','femenino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(10,'Miguel Herrera Olivos','09377777','2225220290','mherrerao@unac.edu.pe','FIQ','+51987654327','masculino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(11,'Sofía Medina Chávez','09388888','2225220291','smedinac@unac.edu.pe','Ciencias de la Salud','+51987654328','femenino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(12,'Cristian Lazo Quispe','09399999','2225220292','clazoq@unac.edu.pe','Ciencias Economicas','+51987654329','masculino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(13,'Ariana Castro León','09400000','2225220293','acastroleon@unac.edu.pe','Administracion','+51987654330','femenino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(14,'Kevin Zegarra Tuesta','09411111','2225220294','kzegarrat@unac.edu.pe','FIEE','+51987654331','masculino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(15,'Daniela Ramos Mejía','09422222','2225220295','dramosm@unac.edu.pe','FIIS','+51987654332','femenino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(16,'Bruno Pacheco Rivas','09433333','2225220296','bpachecor@unac.edu.pe','FIPA','+51987654333','masculino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(17,'Natalia Suárez Calderón','09444444','2225220297','nsuarezc@unac.edu.pe','FIQ','+51987654334','femenino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(18,'Mauricio León Ríos','09455555','2225220298','mleonrios@unac.edu.pe','Ciencias de la Salud','+51987654335','masculino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(19,'Estefanía Quispe Llosa','09466666','2225220299','equispellosa@unac.edu.pe','Ciencias Economicas','+51987654336','femenino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(20,'Julio Acosta Milla','09477777','2225220300','jacostam@unac.edu.pe','Administracion','+51987654337','masculino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(21,'Isabel Romero Sánchez','09488888','2225220301','iromeros@unac.edu.pe','FIEE','+51987654338','femenino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(22,'Héctor Bravo Tello','09499999','2225220302','hbravot@unac.edu.pe','FIIS','+51987654339','masculino',0,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(23,'Fiorella Linares Ríos','09500000','2225220303','flinaresr@unac.edu.pe','FIPA','+51987654340','femenino',1,'2025-07-20 03:35:20','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(24,'Valeria Mendoza Huamán','09390024','2225220324','vmendoza@unac.edu.pe','FIQ','+51987654324','femenino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(25,'Jorge Ramírez Zegarra','09390025','2225220325','jramirez@unac.edu.pe','Ciencias de la Salud','+51987654325','masculino',1,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(26,'Lucía Campos Díaz','09390026','2225220326','lcampos@unac.edu.pe','Ciencias Economicas','+51987654326','femenino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(27,'Andrés Cárdenas León','09390027','2225220327','acardenas@unac.edu.pe','Administracion','+51987654327','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(28,'Diana López Salas','09390028','2225220328','dlopez@unac.edu.pe','FIEE','+51987654328','femenino',1,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(29,'Gabriel Núñez Chumpitaz','09390029','2225220329','gnunez@unac.edu.pe','FIIS','+51987654329','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(30,'María Fernanda Soto Vega','09390030','2225220330','mfsoto@unac.edu.pe','FIPA','+51987654330','femenino',1,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(31,'Kevin Rojas Aguirre','09390031','2225220331','krojas@unac.edu.pe','FIQ','+51987654331','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(32,'Alejandra Ponce Torres','09390032','2225220332','aponce@unac.edu.pe','Ciencias de la Salud','+51987654332','femenino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(33,'Juan Diego Salinas Olivares','09390033','2225220333','jsalinas@unac.edu.pe','Ciencias Economicas','+51987654333','masculino',1,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(34,'Carmen Aguilar Villanueva','09390034','2225220334','caguilar@unac.edu.pe','Administraci├│n','+51987654334','femenino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(35,'Luis Torres Sosa','09390035','2225220335','ltorres@unac.edu.pe','FIEE','+51987654335','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(36,'Nicole Vásquez Ramos','09390036','2225220336','nvasquez@unac.edu.pe','FIIS','+51987654336','femenino',1,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(37,'Franco Medina Luján','09390037','2225220337','fmedina@unac.edu.pe','FIPA','+51987654337','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(38,'Elena Rivas Alarcón','09390038','2225220338','erivas@unac.edu.pe','FIQ','+51987654338','femenino',1,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(39,'Martín Bravo Quijano','09390039','2225220339','mbravo@unac.edu.pe','Ciencias de la Salud','+51987654339','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(40,'Paula Sánchez Ayala','09390040','2225220340','psanchez@unac.edu.pe','Ciencias Econ├│micas','+51987654340','femenino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(41,'Oscar León Carrillo','09390041','2225220341','oleon@unac.edu.pe','Administraci├│n','+51987654341','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(42,'Brenda Gamarra Pezo','09390042','2225220342','bgamarra@unac.edu.pe','FIEE','+51987654342','femenino',1,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),(43,'Rodrigo Silva Tenorio','09390043','2225220343','rsilva@unac.edu.pe','FIIS','+51987654343','masculino',0,'2025-07-20 03:48:18','$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo_comida_id` int(11) NOT NULL,
  `estado` enum('pendiente','usado','anulado') DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `tipo_comida_id` (`tipo_comida_id`),
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`tipo_comida_id`) REFERENCES `tipo_comida` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (2,1,'2026-07-16',2,'pendiente','2025-06-22 22:00:48'),(3,1,'2026-07-15',2,'usado','2025-06-22 22:00:48'),(4,1,'2026-07-14',2,'anulado','2025-06-22 22:00:48'),(5,1,'2026-07-13',2,'usado','2025-06-22 22:00:48'),(6,6,'2026-07-13',2,'pendiente','2025-07-20 03:41:06'),(7,7,'2026-07-14',2,'pendiente','2025-07-20 03:41:06'),(8,8,'2026-07-14',2,'usado','2025-07-20 03:41:06'),(9,9,'2026-07-14',2,'pendiente','2025-07-20 03:41:06'),(10,10,'2026-07-15',2,'anulado','2025-07-20 03:41:06'),(11,11,'2026-07-15',2,'pendiente','2025-07-20 03:41:06'),(12,12,'2026-07-15',2,'pendiente','2025-07-20 03:41:06'),(13,13,'2026-07-16',2,'pendiente','2025-07-20 03:41:06'),(14,14,'2026-07-16',2,'usado','2025-07-20 03:41:06'),(15,15,'2026-07-16',2,'pendiente','2025-07-20 03:41:06'),(16,16,'2026-07-17',2,'pendiente','2025-07-20 03:41:06'),(17,17,'2026-07-17',2,'pendiente','2025-07-20 03:41:06'),(18,18,'2026-07-17',2,'anulado','2025-07-20 03:41:06'),(19,19,'2026-07-13',2,'pendiente','2025-07-20 03:41:06'),(20,20,'2026-07-13',2,'usado','2025-07-20 03:41:06'),(21,21,'2026-07-13',2,'pendiente','2025-07-20 03:41:06'),(22,22,'2026-07-14',2,'pendiente','2025-07-20 03:41:06'),(23,23,'2026-07-14',2,'usado','2025-07-20 03:41:06'),(24,4,'2026-07-14',2,'pendiente','2025-07-20 03:41:06'),(25,9,'2026-07-14',2,'pendiente','2025-07-20 03:41:06'),(26,1,'2026-07-16',2,'pendiente','2026-07-16 03:13:49');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_comida`
--

DROP TABLE IF EXISTS `tipo_comida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_comida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` enum('desayuno','almuerzo','cena') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_comida`
--

LOCK TABLES `tipo_comida` WRITE;
/*!40000 ALTER TABLE `tipo_comida` DISABLE KEYS */;
INSERT INTO `tipo_comida` VALUES (1,'desayuno'),(2,'almuerzo'),(3,'cena');
/*!40000 ALTER TABLE `tipo_comida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_code` varchar(20) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `perfil` varchar(50) NOT NULL DEFAULT 'Administrador',
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `university_code` (`university_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'2225220280','12345678','Administrador General','Administrador','$2y$10$$2y$10$/fW7qBlWHUw3jehekpENGuUR5Iroy.BWTVHs1YbokxbGFKh/N947C');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-19 22:31:07
