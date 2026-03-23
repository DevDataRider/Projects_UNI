-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-07-2025 a las 05:48:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdcomedor`
--
CREATE DATABASE IF NOT EXISTS `bdcomedor` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bdcomedor`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_estudiantes`
--

CREATE TABLE `actividad_estudiantes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `accion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividad_estudiantes`
--

INSERT INTO `actividad_estudiantes` (`id`, `student_id`, `accion`, `fecha`) VALUES
(1, 1, 'Generó un ticket para desayuno', '2025-07-06 02:10:59'),
(2, 2, 'Solicitó cambio de menú', '2025-07-06 02:10:59'),
(3, 3, 'Se presentó sin ticket', '2025-07-06 02:10:59'),
(4, 4, 'Actualizó sus datos personales', '2025-07-10 15:15:32'),
(5, 2, 'afadfaa', '2025-07-14 23:41:52'),
(6, 6, 'Canceló un ticket', '2025-07-10 17:45:01'),
(7, 7, 'Solicitó ayuda técnica', '2025-07-10 18:32:22'),
(8, 8, 'Generó un ticket para desayuno', '2025-07-11 12:45:00'),
(9, 9, 'Se presentó sin carnet', '2025-07-11 13:10:00'),
(10, 10, 'Solicitó cambio de menú', '2025-07-11 14:00:00'),
(11, 11, 'Anuló un ticket duplicado', '2025-07-11 14:15:00'),
(12, 12, 'Generó un ticket para cena', '2025-07-11 17:30:00'),
(13, 13, 'Consultó su historial de asistencia', '2025-07-11 18:10:00'),
(14, 14, 'Reportó error en su beca', '2025-07-11 19:00:00'),
(15, 15, 'Actualizó correo institucional', '2025-07-11 19:30:00'),
(16, 16, 'Solicitó soporte por app', '2025-07-11 20:00:00'),
(17, 17, 'Generó un ticket para desayuno', '2025-07-11 21:00:00'),
(18, 18, 'Ingresó al comedor sin ticket', '2025-07-11 22:00:00'),
(19, 19, 'Anuló ticket por error', '2025-07-11 22:30:00'),
(20, 20, 'Consultó horarios del comedor', '2025-07-11 23:00:00'),
(21, 21, 'Generó ticket y lo anuló luego', '2025-07-11 23:30:00'),
(22, 22, 'Reportó incidente en fila', '2025-07-12 00:00:00'),
(23, 23, 'Generó un ticket para cena', '2025-07-12 00:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `fecha_ingreso` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `ticket_id`, `fecha_ingreso`) VALUES
(2, 2, '2025-06-22 17:01:06'),
(3, 3, '2025-06-22 17:01:06'),
(4, 5, '2025-06-22 17:01:06'),
(5, 6, '2025-07-10 12:00:00'),
(6, 7, '2025-07-10 13:00:00'),
(7, 8, '2025-07-10 13:15:00'),
(8, 9, '2025-07-10 13:30:00'),
(9, 10, '2025-07-10 14:00:00'),
(10, 11, '2025-07-10 14:15:00'),
(11, 12, '2025-07-10 15:00:00'),
(12, 13, '2025-07-10 15:30:00'),
(13, 14, '2025-07-10 16:00:00'),
(14, 15, '2025-07-10 16:30:00'),
(15, 16, '2025-07-10 17:00:00'),
(16, 17, '2025-07-10 17:15:00'),
(17, 18, '2025-07-10 17:30:00'),
(18, 19, '2025-07-10 18:00:00'),
(19, 20, '2025-07-10 18:15:00'),
(20, 21, '2025-07-10 18:30:00'),
(21, 22, '2025-07-10 19:00:00'),
(22, 23, '2025-07-10 19:15:00'),
(23, 24, '2025-07-10 19:30:00'),
(24, 25, '2025-07-10 20:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `valor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `clave`, `valor`) VALUES
(1, 'limite_tickets_diarios', '1'),
(2, 'hora_cierre_emision', '09:00:00'),
(3, 'limite_tickets_becados', '1000'),
(4, 'limite_tickets_no_becados', '500');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incidencias`
--

INSERT INTO `incidencias` (`id`, `student_id`, `descripcion`, `fecha`) VALUES
(1, 1, 'Olvidó su carnet', '2025-07-10 08:15:00'),
(2, 1, 'Se presentó fuera de horario.', '2025-06-22 16:59:36'),
(3, 1, 'No respetó el orden de ingreso.', '2025-06-22 16:59:36'),
(4, 1, 'Problema con validación del ticket.', '2025-06-22 16:59:36'),
(5, 1, 'vgvhhbnbn', '2025-07-05 00:00:00'),
(6, 2, 'no uso su ticket', '2025-07-07 00:00:00'),
(7, 3, 'fsaadvxv', '2025-07-20 00:00:00'),
(8, 8, 'Reclamo por comida fría', '2025-07-10 10:00:00'),
(9, 9, 'Intentó duplicar ticket', '2025-07-10 10:15:00'),
(10, 10, 'Discrepancia con tipo de comida', '2025-07-10 10:30:00'),
(11, 11, 'No respetó su turno', '2025-07-10 10:45:00'),
(12, 12, 'Problemas con beca', '2025-07-10 11:00:00'),
(13, 13, 'Reportó incidente en comedor', '2025-07-10 11:15:00'),
(14, 14, 'Comida en mal estado', '2025-07-10 11:30:00'),
(15, 15, 'Ruido excesivo', '2025-07-10 11:45:00'),
(16, 16, 'No portaba identificación', '2025-07-10 12:00:00'),
(17, 17, 'Intentó ingresar por otra puerta', '2025-07-10 12:15:00'),
(18, 18, 'Se negó a mostrar ticket', '2025-07-10 12:30:00'),
(19, 19, 'Uso inadecuado de la app', '2025-07-10 12:45:00'),
(20, 20, 'Inasistencia repetida sin justificación', '2025-07-10 13:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_ingreso`
--

CREATE TABLE `logs_ingreso` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `logs_ingreso`
--

INSERT INTO `logs_ingreso` (`id`, `student_id`, `ip_address`, `user_agent`, `fecha`) VALUES
(2, 1, '192.168.0.105', 'Mozilla/5.0 (Linux)', '2025-06-22 22:00:08'),
(3, 1, '192.168.0.110', 'Chrome/90.0 (Windows)', '2025-06-22 22:00:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos_del_dia`
--

CREATE TABLE `platos_del_dia` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo_comida_id` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos_del_dia`
--

INSERT INTO `platos_del_dia` (`id`, `fecha`, `tipo_comida_id`, `descripcion`) VALUES
(5, '2025-06-23', 2, 'Arroz con pollo y ensalada rusa'),
(6, '2025-06-24', 2, 'Tallarin rojo con papa a la huancaína'),
(7, '2025-06-25', 2, 'Lentejas con arroz y huevo frito '),
(8, '2025-06-26', 2, 'Ají de gallina con arroz blanco'),
(9, '2025-06-27', 2, 'Estofado de carne con papas y arroz'),
(10, '2025-06-28', 2, 'Arroz con pollo'),
(11, '2025-07-08', 2, 'Arroz con pollo, ensalada rusa y refresco de maracuyá'),
(12, '2025-07-09', 2, 'Lentejas con arroz, apanado de pollo y limonada'),
(13, '2025-07-10', 2, 'Tallarin rojo con presa de pollo y chicha morada'),
(14, '2025-07-11', 2, 'Seco de res con frejoles, arroz blanco y refresco de cebada'),
(15, '2025-07-12', 2, 'Ají de gallina con arroz blanco y refresco de hierba luisa'),
(16, '2025-07-13', 2, 'Estofado de pollo con arroz y refresco de manzana'),
(17, '2025-07-14', 2, 'Arroz chaufa de pollo con salsa de soja y té helado'),
(18, '2025-07-21', 2, 'Arroz con pollo y ensalada de zanahoria'),
(19, '2025-07-22', 2, 'Tallarín verde con papa a la huancaína'),
(20, '2025-07-23', 2, 'Menestrón con trozos de carne y arroz'),
(21, '2025-07-24', 2, 'Ají de gallina con arroz y aceitunas'),
(22, '2025-07-25', 2, 'Lomo saltado con arroz y papas fritas'),
(23, '2025-07-28', 2, 'Pachamanca especial por Fiestas Patrias'),
(24, '2025-07-29', 2, 'Carapulcra con sopa seca'),
(25, '2025-07-30', 2, 'Seco de pollo con frejoles'),
(26, '2025-07-31', 2, 'Arroz tapado con huevo y plátano'),
(27, '2025-08-01', 2, 'Causa rellena y escabeche de pollo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `university_code` varchar(20) NOT NULL,
  `email_institutional` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `gender` enum('masculino','femenino','otro') DEFAULT NULL,
  `is_scholarship` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `full_name`, `dni`, `university_code`, `email_institutional`, `mobile`, `gender`, `is_scholarship`, `created_at`, `password`) VALUES
(1, 'Leydi Veronica Aguilar Mendoza', '09343655', '2225220281', 'lvaguilarm@unac.edu.pe', '+51912345678', 'femenino', 1, '2025-06-22 01:27:25', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(2, 'Luis Fernando Pérez Gómez ', '09345678', '2225220258', 'lpgomez@unac.edu.pe', '+51923456789', 'masculino', 0, '2025-06-22 01:27:25', '$2y$10$bXNHE2L7S/MWhhgByrPjd.b19.AsvlZiFVE5kNztIqE3.17z0ubve'),
(3, 'María Carla Ortiz Ruiz', '09567890', '2225220283', 'mortizruiz@unac.edu.pe', '+51934567890', 'femenino', 0, '2025-06-22 01:27:25', '$2y$10$avgOOg2mENgxesFJpdrYkufkSJkZDwGQv0AtQ9lfweHZpbNax5m/2'),
(4, 'Andrés Torres Salas', '09311111', '2225220284', 'atorress@unac.edu.pe', '+51987654321', 'masculino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(5, 'Camila Ríos Luján', '09322222', '2225220285', 'crioslujan@unac.edu.pe', '+51987654322', 'femenino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(6, 'Jorge Villanueva Pérez', '09333333', '2225220286', 'jvillaperez@unac.edu.pe', '+51987654323', 'masculino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(7, 'Luciana Huamán Cordero', '09344444', '2225220287', 'lhuamanc@unac.edu.pe', '+51987654324', 'femenino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(8, 'Diego Ramírez Soto', '09355555', '2225220288', 'dramirezs@unac.edu.pe', '+51987654325', 'masculino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(9, 'Valeria Paredes Flores', '09366666', '2225220289', 'vparedesf@unac.edu.pe', '+51987654326', 'femenino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(10, 'Miguel Herrera Olivos', '09377777', '2225220290', 'mherrerao@unac.edu.pe', '+51987654327', 'masculino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(11, 'Sofía Medina Chávez', '09388888', '2225220291', 'smedinac@unac.edu.pe', '+51987654328', 'femenino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(12, 'Cristian Lazo Quispe', '09399999', '2225220292', 'clazoq@unac.edu.pe', '+51987654329', 'masculino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(13, 'Ariana Castro León', '09400000', '2225220293', 'acastroleon@unac.edu.pe', '+51987654330', 'femenino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(14, 'Kevin Zegarra Tuesta', '09411111', '2225220294', 'kzegarrat@unac.edu.pe', '+51987654331', 'masculino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(15, 'Daniela Ramos Mejía', '09422222', '2225220295', 'dramosm@unac.edu.pe', '+51987654332', 'femenino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(16, 'Bruno Pacheco Rivas', '09433333', '2225220296', 'bpachecor@unac.edu.pe', '+51987654333', 'masculino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(17, 'Natalia Suárez Calderón', '09444444', '2225220297', 'nsuarezc@unac.edu.pe', '+51987654334', 'femenino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(18, 'Mauricio León Ríos', '09455555', '2225220298', 'mleonrios@unac.edu.pe', '+51987654335', 'masculino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(19, 'Estefanía Quispe Llosa', '09466666', '2225220299', 'equispellosa@unac.edu.pe', '+51987654336', 'femenino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(20, 'Julio Acosta Milla', '09477777', '2225220300', 'jacostam@unac.edu.pe', '+51987654337', 'masculino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(21, 'Isabel Romero Sánchez', '09488888', '2225220301', 'iromeros@unac.edu.pe', '+51987654338', 'femenino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(22, 'Héctor Bravo Tello', '09499999', '2225220302', 'hbravot@unac.edu.pe', '+51987654339', 'masculino', 0, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(23, 'Fiorella Linares Ríos', '09500000', '2225220303', 'flinaresr@unac.edu.pe', '+51987654340', 'femenino', 1, '2025-07-20 03:35:20', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(24, 'Valeria Mendoza Huamán', '09390024', '2225220324', 'vmendoza@unac.edu.pe', '+51987654324', 'femenino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(25, 'Jorge Ramírez Zegarra', '09390025', '2225220325', 'jramirez@unac.edu.pe', '+51987654325', 'masculino', 1, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(26, 'Lucía Campos Díaz', '09390026', '2225220326', 'lcampos@unac.edu.pe', '+51987654326', 'femenino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(27, 'Andrés Cárdenas León', '09390027', '2225220327', 'acardenas@unac.edu.pe', '+51987654327', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(28, 'Diana López Salas', '09390028', '2225220328', 'dlopez@unac.edu.pe', '+51987654328', 'femenino', 1, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(29, 'Gabriel Núñez Chumpitaz', '09390029', '2225220329', 'gnunez@unac.edu.pe', '+51987654329', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(30, 'María Fernanda Soto Vega', '09390030', '2225220330', 'mfsoto@unac.edu.pe', '+51987654330', 'femenino', 1, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(31, 'Kevin Rojas Aguirre', '09390031', '2225220331', 'krojas@unac.edu.pe', '+51987654331', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(32, 'Alejandra Ponce Torres', '09390032', '2225220332', 'aponce@unac.edu.pe', '+51987654332', 'femenino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(33, 'Juan Diego Salinas Olivares', '09390033', '2225220333', 'jsalinas@unac.edu.pe', '+51987654333', 'masculino', 1, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(34, 'Carmen Aguilar Villanueva', '09390034', '2225220334', 'caguilar@unac.edu.pe', '+51987654334', 'femenino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(35, 'Luis Torres Sosa', '09390035', '2225220335', 'ltorres@unac.edu.pe', '+51987654335', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(36, 'Nicole Vásquez Ramos', '09390036', '2225220336', 'nvasquez@unac.edu.pe', '+51987654336', 'femenino', 1, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(37, 'Franco Medina Luján', '09390037', '2225220337', 'fmedina@unac.edu.pe', '+51987654337', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(38, 'Elena Rivas Alarcón', '09390038', '2225220338', 'erivas@unac.edu.pe', '+51987654338', 'femenino', 1, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(39, 'Martín Bravo Quijano', '09390039', '2225220339', 'mbravo@unac.edu.pe', '+51987654339', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(40, 'Paula Sánchez Ayala', '09390040', '2225220340', 'psanchez@unac.edu.pe', '+51987654340', 'femenino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(41, 'Oscar León Carrillo', '09390041', '2225220341', 'oleon@unac.edu.pe', '+51987654341', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(42, 'Brenda Gamarra Pezo', '09390042', '2225220342', 'bgamarra@unac.edu.pe', '+51987654342', 'femenino', 1, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2'),
(43, 'Rodrigo Silva Tenorio', '09390043', '2225220343', 'rsilva@unac.edu.pe', '+51987654343', 'masculino', 0, '2025-07-20 03:48:18', '$2y$10$mXG7QC/N60c6/5TotIHUpup80Qjy0PkGPEoPQ/ivNYewyX.RH93R2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo_comida_id` int(11) NOT NULL,
  `estado` enum('pendiente','usado','anulado') DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id`, `student_id`, `fecha`, `tipo_comida_id`, `estado`, `created_at`) VALUES
(1, 1, '2025-07-14', 2, 'pendiente', '2025-07-20 03:41:06'),
(2, 1, '2025-06-24', 2, 'pendiente', '2025-06-22 22:00:48'),
(3, 1, '2025-06-23', 2, 'usado', '2025-06-22 22:00:48'),
(4, 1, '2025-06-22', 2, 'anulado', '2025-06-22 22:00:48'),
(5, 1, '2025-06-21', 2, 'usado', '2025-06-22 22:00:48'),
(6, 6, '2025-07-15', 2, 'pendiente', '2025-07-20 03:41:06'),
(7, 7, '2025-07-16', 2, 'pendiente', '2025-07-20 03:41:06'),
(8, 8, '2025-07-16', 2, 'usado', '2025-07-20 03:41:06'),
(9, 9, '2025-07-16', 2, 'pendiente', '2025-07-20 03:41:06'),
(10, 10, '2025-07-17', 2, 'anulado', '2025-07-20 03:41:06'),
(11, 11, '2025-07-17', 2, 'pendiente', '2025-07-20 03:41:06'),
(12, 12, '2025-07-17', 2, 'pendiente', '2025-07-20 03:41:06'),
(13, 13, '2025-07-18', 2, 'pendiente', '2025-07-20 03:41:06'),
(14, 14, '2025-07-18', 2, 'usado', '2025-07-20 03:41:06'),
(15, 15, '2025-07-18', 2, 'pendiente', '2025-07-20 03:41:06'),
(16, 16, '2025-07-19', 2, 'pendiente', '2025-07-20 03:41:06'),
(17, 17, '2025-07-19', 2, 'pendiente', '2025-07-20 03:41:06'),
(18, 18, '2025-07-19', 2, 'anulado', '2025-07-20 03:41:06'),
(19, 19, '2025-07-20', 2, 'pendiente', '2025-07-20 03:41:06'),
(20, 20, '2025-07-20', 2, 'usado', '2025-07-20 03:41:06'),
(21, 21, '2025-07-20', 2, 'pendiente', '2025-07-20 03:41:06'),
(22, 22, '2025-07-21', 2, 'pendiente', '2025-07-20 03:41:06'),
(23, 23, '2025-07-21', 2, 'usado', '2025-07-20 03:41:06'),
(24, 4, '2025-07-21', 2, 'pendiente', '2025-07-20 03:41:06'),
(25, 9, '2025-07-21', 2, 'pendiente', '2025-07-20 03:41:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comida`
--

CREATE TABLE `tipo_comida` (
  `id` int(11) NOT NULL,
  `nombre` enum('desayuno','almuerzo','cena') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_comida`
--

INSERT INTO `tipo_comida` (`id`, `nombre`) VALUES
(1, 'desayuno'),
(2, 'almuerzo'),
(3, 'cena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `university_code` varchar(20) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `perfil` varchar(50) NOT NULL DEFAULT 'Administrador',
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `university_code`, `dni`, `nombre`, `perfil`, `password`) VALUES
(1, '2225220280', '12345678', 'Administrador General', 'Administrador', '$2y$10$$2y$10$/fW7qBlWHUw3jehekpENGuUR5Iroy.BWTVHs1YbokxbGFKh/N947C');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad_estudiantes`
--
ALTER TABLE `actividad_estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indices de la tabla `logs_ingreso`
--
ALTER TABLE `logs_ingreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indices de la tabla `platos_del_dia`
--
ALTER TABLE `platos_del_dia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`,`tipo_comida_id`),
  ADD KEY `tipo_comida_id` (`tipo_comida_id`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `university_code` (`university_code`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tipo_comida_id` (`tipo_comida_id`);

--
-- Indices de la tabla `tipo_comida`
--
ALTER TABLE `tipo_comida`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `university_code` (`university_code`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad_estudiantes`
--
ALTER TABLE `actividad_estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `logs_ingreso`
--
ALTER TABLE `logs_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `platos_del_dia`
--
ALTER TABLE `platos_del_dia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tipo_comida`
--
ALTER TABLE `tipo_comida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad_estudiantes`
--
ALTER TABLE `actividad_estudiantes`
  ADD CONSTRAINT `actividad_estudiantes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Filtros para la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Filtros para la tabla `logs_ingreso`
--
ALTER TABLE `logs_ingreso`
  ADD CONSTRAINT `logs_ingreso_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Filtros para la tabla `platos_del_dia`
--
ALTER TABLE `platos_del_dia`
  ADD CONSTRAINT `platos_del_dia_ibfk_1` FOREIGN KEY (`tipo_comida_id`) REFERENCES `tipo_comida` (`id`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`tipo_comida_id`) REFERENCES `tipo_comida` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
