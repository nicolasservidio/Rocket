-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 09:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rocket`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesorios-vehiculos`
--

CREATE TABLE `accesorios-vehiculos` (
  `idAccesorio` int(11) NOT NULL,
  `nombreAccesorio` varchar(50) NOT NULL,
  `descripcionAccesorio` varchar(200) DEFAULT NULL COMMENT 'Campo optativo con una descripción del accesorio, en caso de requerirse',
  `precioAccesorio` float NOT NULL,
  `estadoAccesorio` varchar(100) DEFAULT NULL COMMENT 'Campo optativo con referencias al estado del accesorio',
  `disponibilidadAccesorio` varchar(1) NOT NULL COMMENT 'Campo de un solo caracter, S (sí) para disponible, N (no) para no disponible',
  `idTipoInsumo` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `idVehiculoHospedante` int(11) DEFAULT NULL COMMENT 'Campo optativo para el caso de que un accesorio esté siendo utilizado en un vehículo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `descripcion`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'GERENTE_OPERACIONES'),
(3, 'GERENTE_COMERCIAL'),
(4, 'GERENTE_TALLER'),
(5, 'ENCARGADO_ATPUBLICO'),
(6, 'ENCARGADO_VENTAS'),
(7, 'ENCARGADO_TALLER'),
(8, 'ENCARGADO_COMPRAS'),
(9, 'OPERATIVO_ATPUBLICO'),
(10, 'OPERATIVO_VENTAS'),
(11, 'OPERATIVO_TALLER'),
(12, 'OPERATIVO_COMPRAS');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `apellidoCliente` varchar(50) NOT NULL,
  `nacionalidadCliente` varchar(50) DEFAULT NULL,
  `dniCliente` int(10) NOT NULL,
  `nroPasaporteCliente` int(11) DEFAULT NULL,
  `mailCliente` varchar(50) NOT NULL,
  `telefonoCliente` int(20) NOT NULL,
  `ciudadCliente` varchar(50) DEFAULT NULL,
  `direccionCliente` varchar(50) NOT NULL,
  `comprobanteDomicilio` int(1) DEFAULT NULL,
  `propositoAlquiler` varchar(100) DEFAULT NULL,
  `licenciaConducir` varchar(10) DEFAULT NULL,
  `licenciaInternacionalConducir` int(11) DEFAULT NULL,
  `tarjetaCredito_titular` varchar(50) DEFAULT NULL,
  `tarjetaCredito_numero` int(11) DEFAULT NULL,
  `tarjetaCredito_vencim` date DEFAULT NULL,
  `tarjetaCredito_codSeguridad` int(11) DEFAULT NULL,
  `seguroCliente_nombre` varchar(100) DEFAULT NULL,
  `seguroCliente_tipo` varchar(100) DEFAULT NULL,
  `seguroCliente_descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`) VALUES
(1, 'Bruno', 'Carossi', 'Argentina', 38103736, NULL, 'brunocarossi@hotmail.com', 2147483647, 'JUAN ANCHORENA', '829 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Visa BRUNO CAROSSI', 3323332, '2024-12-01', NULL, 'Zurich Argentina', 'A', NULL),
(2, 'Lucia', 'HRASTE', 'Argentina', 31741578, NULL, 'lucia@hotmail.com', 214748368, 'URQUIZA', '829 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Visa LUCIA HRASTE', 2233323, '2024-11-30', NULL, 'San Cristobal', 'A', NULL),
(3, 'Eduardo Facundo', 'Mota', 'Argentina', 38343866, NULL, 'facundo@hotmail.com', 31474836, 'SIERRA DE LA VENTANA', '828 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Visa EDUARDO FACUNDO MOTA', 8949389, '2025-07-30', NULL, 'Seguros Rivadavia', 'A', NULL),
(4, 'Roberto', 'Sanchez', 'Argentina', 77433645, NULL, 'roberto@gmail.com', 55147483, 'CABA', '821 Av Malvinas Argentinas', 0, NULL, 'B2', NULL, NULL, NULL, NULL, NULL, 'San Cristobal', 'C', NULL),
(5, 'Maria', 'Ricardi', 'Argentina', 33224445, NULL, 'maria@gmail.com', 31474838, 'CABA', '222 Av Malvinas Argentinas', 0, NULL, 'B2', NULL, NULL, NULL, NULL, NULL, 'Seguros Rivadavia', 'A', NULL),
(6, 'Ana', 'Smith', 'Argentina', 33244232, NULL, 'ana@gmail.com', 77474839, 'CABA', '223 Av Malvinas Argentinas', 0, NULL, 'B2', NULL, NULL, NULL, NULL, NULL, 'San Cristobal', 'A', NULL),
(7, 'Gabriel', 'Garcia', 'Argentina', 44555999, NULL, 'gabriel@hotmail.com', 41474831, 'MAR DEL PLATA', '332 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Mastercard GABRIEL GARCIA', NULL, '2024-11-14', NULL, 'Zurich Argentina', 'B', NULL),
(8, 'Rosa', 'Alonso', 'Argentina', 33222444, NULL, 'rosa@hotmail.com', 51474832, 'MAR DEL PLATA', '444 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Visa ROSA ALONSO', NULL, '2024-11-15', NULL, 'Seguros Rivadavia', 'D', NULL),
(9, 'Rosario', 'Acosta', 'Argentina', 77888444, NULL, 'rosario@hotmail.com', 61474833, 'CORDOBA', '555 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Visa ROSARIO ACOSTA', NULL, '2024-11-15', NULL, 'Seguros Rivadavia', 'A', NULL),
(10, 'Francisco Juan', 'Lopez', 'Argentina', 66332557, NULL, 'francisco@hotmail.com', 71474834, 'CORDOBA', '666 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Mastercard FRANCISCO JUAN LOPEZ', NULL, '2024-11-15', NULL, 'San Cristobal', 'B', NULL),
(11, 'Lorena', 'Berlusconi', 'Argentina', 443332555, NULL, 'lorena@hotmail.com', 81474891, 'VILLA CARLOS PAZ', '777 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Visa LORENA BERLUSCONI', NULL, '2024-12-15', NULL, 'Zurich Argentina', 'A', NULL),
(12, 'Nicolás', 'Servidio', 'Argentina', 33222558, NULL, 'nicolas@hotmail.com', 91474892, 'BAHIA BLANCA', '888 Av Malvinas Argentinas', 1, NULL, 'B2', NULL, 'Visa NICOLAS SERVIDIO', NULL, '2024-11-25', NULL, 'Zurich Argentina', 'A', NULL),
(15, 'Padme', 'Amidala', NULL, 33222557, NULL, 'padme@gmail.com', 44656324, NULL, '323 Organa, Naboo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Ana', 'Rossi', NULL, 33256642, NULL, 'anarossi@gmail.com', 455887241, NULL, '1498 Cuyo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `combustibles`
--

CREATE TABLE `combustibles` (
  `idCombustible` int(11) NOT NULL,
  `tipoCombustible` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `combustibles`
--

INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES
(1, 'INFINIA TC2000'),
(2, 'INFINIA Top Race'),
(3, 'INFINIA Rally Argent'),
(4, 'INFINIA CARX'),
(5, 'Axion Diesel'),
(6, 'Axion Power Diesel'),
(7, 'Axion Turbo Diesel'),
(8, 'Shell V-Power'),
(9, 'A definir');

-- --------------------------------------------------------

--
-- Table structure for table `contratos-alquiler`
--

CREATE TABLE `contratos-alquiler` (
  `idContrato` int(11) NOT NULL,
  `fechaInicioContrato` date DEFAULT NULL,
  `fechaFinContrato` date DEFAULT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `fechaDevolucion` date DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idVendedor` int(11) DEFAULT NULL,
  `idDetalleContrato` int(11) DEFAULT NULL,
  `idEstadoContrato` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `contratos-alquiler`
--

INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES
(1, '2024-12-01', '2024-12-03', NULL, NULL, 12, 32, NULL, 1, 6),
(2, '2024-12-02', '2024-12-09', NULL, NULL, 9, 24, NULL, 2, 6),
(3, '2024-12-08', '2024-12-10', NULL, NULL, 15, 21, NULL, 3, 4),
(4, '2024-12-06', '2024-12-09', NULL, NULL, 6, 2, NULL, 4, 6),
(5, '2024-12-08', '2024-12-10', NULL, NULL, 7, 19, NULL, 5, 4),
(7, '2024-12-09', '2025-04-04', NULL, NULL, 11, 6, NULL, 7, 6),
(8, '2024-12-11', '2024-12-13', NULL, NULL, 17, 24, NULL, 8, 6),
(10, '2024-12-14', '2024-12-16', NULL, NULL, 7, 28, NULL, 10, 6),
(11, '2024-12-15', '2024-12-17', NULL, NULL, 8, 20, NULL, 11, 4),
(12, '2024-12-17', '2024-12-20', NULL, NULL, 7, 32, NULL, 12, 4),
(13, '2024-12-17', '2024-12-20', NULL, NULL, 8, 6, NULL, 13, 4),
(14, '2024-12-11', '2024-12-27', NULL, NULL, 6, 19, NULL, 14, 4),
(15, '2024-12-14', '2025-01-04', NULL, NULL, 12, 36, NULL, 15, 4),
(16, '2024-12-31', '2025-01-04', NULL, NULL, 15, 35, NULL, 16, 3),
(17, '2025-01-01', '2025-01-03', NULL, NULL, 1, 24, NULL, 17, 4),
(18, '2025-01-02', '2025-01-04', NULL, NULL, 3, 1, NULL, 18, 6),
(19, '2024-01-01', '2024-01-05', NULL, NULL, 6, 2, NULL, 19, 6),
(20, '2024-01-02', '2024-01-07', NULL, NULL, 4, 32, NULL, 20, 6),
(21, '2024-01-02', '2024-01-05', NULL, NULL, 5, 3, NULL, 21, 6),
(22, '2024-01-03', '2024-01-11', NULL, NULL, 7, 35, NULL, 22, 6),
(23, '2024-01-05', '2024-01-10', NULL, NULL, 1, 7, NULL, 23, 6),
(24, '2024-01-05', '2024-01-10', NULL, NULL, 2, 19, NULL, 24, 6),
(25, '2024-01-09', '2024-01-12', NULL, NULL, 3, 30, NULL, 25, 3),
(26, '2024-01-11', '2024-01-17', NULL, NULL, 8, 6, NULL, 26, 3),
(27, '2024-01-16', '2024-01-19', NULL, NULL, 9, 1, NULL, 27, 6),
(28, '2024-01-18', '2024-01-23', NULL, NULL, 10, 28, NULL, 28, 4),
(29, '2024-01-20', '2024-01-24', NULL, NULL, 11, 18, NULL, 29, 3),
(30, '2024-01-21', '2024-01-29', NULL, NULL, 12, 21, NULL, 30, 6),
(31, '2024-01-25', '2024-01-27', NULL, NULL, 15, 23, NULL, 31, 6),
(32, '2024-01-27', '2024-01-30', NULL, NULL, 17, 24, NULL, 32, 6),
(33, '2024-01-27', '2024-01-29', NULL, NULL, 1, 36, NULL, 33, 6),
(34, '2024-01-29', '2024-02-02', NULL, NULL, 2, 20, NULL, 34, 3),
(35, '2024-02-01', '2024-02-03', NULL, NULL, 3, 2, NULL, 35, 6),
(36, '2024-02-02', '2024-02-03', NULL, NULL, 4, 32, NULL, 36, 6),
(37, '2024-02-03', '2024-02-05', NULL, NULL, 5, 3, NULL, 37, 6),
(38, '2024-02-05', '2024-02-06', NULL, NULL, 6, 35, NULL, 38, 6),
(39, '2024-02-05', '2024-02-10', NULL, NULL, 7, 7, NULL, 39, 6),
(40, '2024-02-07', '2024-02-09', NULL, NULL, 8, 19, NULL, 40, 6),
(41, '2024-02-09', '2024-02-12', NULL, NULL, 9, 30, NULL, 41, 3),
(42, '2024-02-10', '2024-02-14', NULL, NULL, 10, 6, NULL, 42, 6),
(43, '2024-02-12', '2024-02-15', NULL, NULL, 11, 25, NULL, 43, 6),
(44, '2024-02-13', '2024-02-16', NULL, NULL, 12, 1, NULL, 44, 6),
(45, '2024-02-15', '2024-02-17', NULL, NULL, 15, 28, NULL, 45, 3),
(46, '2024-02-17', '2024-02-20', NULL, NULL, 17, 18, NULL, 46, 3),
(47, '2024-02-20', '2024-02-24', NULL, NULL, 1, 21, NULL, 47, 6),
(48, '2024-02-20', '2024-02-29', NULL, NULL, 2, 23, NULL, 48, 6),
(49, '2024-02-21', '2024-02-23', NULL, NULL, 3, 24, NULL, 49, 6),
(50, '2024-02-24', '2024-02-27', NULL, NULL, 4, 36, NULL, 50, 6),
(51, '2024-02-24', '2024-02-27', NULL, NULL, 5, 20, NULL, 51, 6),
(52, '2024-02-25', '2024-02-27', NULL, NULL, 6, 2, NULL, 52, 6),
(53, '2024-02-25', '2024-02-28', NULL, NULL, 7, 32, NULL, 53, 6),
(54, '2024-02-27', '2024-02-29', NULL, NULL, 8, 35, NULL, 54, 6),
(55, '2024-02-29', '2024-03-05', NULL, NULL, 12, 3, NULL, 55, 6),
(56, '2024-02-29', '2024-03-04', NULL, NULL, 11, 35, NULL, 56, 3),
(57, '2024-03-01', '2024-03-02', NULL, NULL, 15, 7, NULL, 57, 6),
(58, '2024-03-01', '2024-03-04', NULL, NULL, 17, 19, NULL, 58, 6),
(59, '2024-03-02', '2024-03-05', NULL, NULL, 9, 2, NULL, 59, 6),
(60, '2024-03-02', '2024-03-07', NULL, NULL, 10, 32, NULL, 60, 6),
(61, '2024-03-02', '2024-03-05', NULL, NULL, 11, 3, NULL, 61, 6),
(62, '2024-03-03', '2024-03-07', NULL, NULL, 12, 35, NULL, 62, 6),
(63, '2024-03-03', '2024-03-09', NULL, NULL, 15, 7, NULL, 63, 6),
(64, '2024-03-04', '2024-03-05', NULL, NULL, 1, 19, NULL, 64, 6),
(65, '2024-03-05', '2024-03-06', NULL, NULL, 2, 30, NULL, 65, 6),
(66, '2024-03-06', '2024-03-11', NULL, NULL, 3, 6, NULL, 66, 6),
(67, '2024-03-07', '2024-03-10', NULL, NULL, 4, 25, NULL, 67, 6),
(68, '2024-03-07', '2024-03-10', NULL, NULL, 5, 1, NULL, 68, 3),
(69, '2024-03-08', '2024-03-11', NULL, NULL, 6, 28, NULL, 69, 3),
(70, '2024-03-09', '2024-03-11', NULL, NULL, 7, 18, NULL, 70, 6),
(71, '2024-03-09', '2024-03-12', NULL, NULL, 8, 21, NULL, 71, 6),
(72, '2024-03-12', '2024-03-14', NULL, NULL, 9, 23, NULL, 72, 6),
(73, '2024-03-15', '2024-03-17', NULL, NULL, 10, 24, NULL, 73, 6),
(74, '2024-03-16', '2024-03-18', NULL, NULL, 11, 36, NULL, 74, 6),
(75, '2024-03-18', '2024-03-21', NULL, NULL, 12, 20, NULL, 75, 6),
(76, '2024-03-19', '2024-03-22', NULL, NULL, 15, 25, NULL, 76, 6),
(77, '2024-03-24', '2024-03-25', NULL, NULL, 17, 32, NULL, 77, 6),
(78, '2024-04-01', '2024-04-03', NULL, NULL, 1, 3, NULL, 78, 6),
(79, '2024-04-03', '2024-04-05', NULL, NULL, 4, 2, NULL, 79, 6),
(80, '2024-04-05', '2024-04-08', NULL, NULL, 7, 35, NULL, 80, 6),
(81, '2024-04-07', '2024-04-09', NULL, NULL, 10, 7, NULL, 81, 3),
(82, '2024-04-07', '2024-04-10', NULL, NULL, 11, 19, NULL, 82, 6),
(83, '2024-04-10', '2024-04-12', NULL, NULL, 15, 1, NULL, 83, 3),
(84, '2024-04-12', '2024-04-15', NULL, NULL, 17, 23, NULL, 84, 6),
(85, '2024-04-14', '2024-04-16', NULL, NULL, 4, 2, NULL, 85, 6),
(86, '2024-04-19', '2024-04-23', NULL, NULL, 5, 19, NULL, 86, 6),
(87, '2024-04-26', '2024-04-30', NULL, NULL, 6, 23, NULL, 87, 6),
(88, '2024-05-03', '2024-05-06', NULL, NULL, 1, 1, NULL, 88, 6),
(89, '2024-05-06', '2024-05-09', NULL, NULL, 2, 19, NULL, 89, 6),
(90, '2024-05-07', '2024-05-10', NULL, NULL, 3, 18, NULL, 90, 3),
(91, '2024-05-09', '2024-05-11', NULL, NULL, 6, 23, NULL, 91, 6),
(92, '2024-05-11', '2024-05-15', NULL, NULL, 10, 36, NULL, 92, 6),
(93, '2024-05-14', '2024-05-17', NULL, NULL, 12, 2, NULL, 93, 3),
(94, '2024-05-22', '2024-05-25', NULL, NULL, 17, 3, NULL, 94, 6),
(95, '2024-05-24', '2024-05-26', NULL, NULL, 5, 7, NULL, 95, 6),
(96, '2024-05-26', '2024-05-29', NULL, NULL, 8, 18, NULL, 96, 3),
(97, '2024-06-01', '2024-06-03', NULL, NULL, 9, 2, NULL, 97, 3),
(98, '2024-06-03', '2024-06-04', NULL, NULL, 10, 3, NULL, 98, 3),
(99, '2024-06-04', '2024-06-07', NULL, NULL, 11, 7, NULL, 99, 6),
(100, '2024-06-05', '2024-06-09', NULL, NULL, 12, 36, NULL, 100, 6),
(101, '2024-06-07', '2024-06-10', NULL, NULL, 17, 19, NULL, 101, 6),
(102, '2024-06-09', '2024-06-12', NULL, NULL, 1, 36, NULL, 102, 3),
(103, '2024-06-12', '2024-06-15', NULL, NULL, 4, 32, NULL, 103, 3),
(104, '2024-06-15', '2024-06-18', NULL, NULL, 3, 20, NULL, 104, 6),
(105, '2024-06-20', '2024-06-22', NULL, NULL, 6, 3, NULL, 105, 6),
(106, '2024-06-22', '2024-06-25', NULL, NULL, 7, 32, NULL, 106, 6),
(107, '2024-06-25', '2024-06-27', NULL, NULL, 10, 21, NULL, 107, 6),
(108, '2024-07-03', '2024-07-06', NULL, NULL, 2, 35, NULL, 108, 6),
(109, '2024-07-05', '2024-07-08', NULL, NULL, 6, 7, NULL, 109, 6),
(110, '2024-07-09', '2024-07-12', NULL, NULL, 5, 2, NULL, 110, 6),
(111, '2024-07-10', '2024-07-13', NULL, NULL, 1, 6, NULL, 111, 6),
(112, '2024-07-13', '2024-07-16', NULL, NULL, 8, 35, NULL, 112, 6),
(113, '2024-07-13', '2024-07-18', NULL, NULL, 12, 30, NULL, 113, 6),
(114, '2024-07-15', '2024-07-18', NULL, NULL, 17, 1, NULL, 114, 3),
(115, '2024-07-16', '2024-07-20', NULL, NULL, 3, 3, NULL, 115, 6),
(116, '2024-08-03', '2024-08-06', NULL, NULL, 4, 2, NULL, 116, 6),
(117, '2024-08-07', '2024-08-09', NULL, NULL, 5, 6, NULL, 117, 6),
(118, '2024-08-10', '2024-08-12', NULL, NULL, 6, 25, NULL, 118, 6),
(119, '2024-08-13', '2024-08-16', NULL, NULL, 7, 18, NULL, 119, 3),
(120, '2024-08-23', '2024-08-25', NULL, NULL, 10, 36, NULL, 120, 6),
(121, '2024-08-29', '2024-08-31', NULL, NULL, 15, 23, NULL, 121, 6),
(122, '2024-09-05', '2024-09-09', NULL, NULL, 1, 1, NULL, 122, 6),
(123, '2024-10-07', '2024-10-10', NULL, NULL, 15, 19, NULL, 123, 6),
(124, '2024-10-09', '2024-10-14', NULL, NULL, 1, 25, NULL, 124, 6),
(125, '2024-10-16', '2024-10-19', NULL, NULL, 3, 18, NULL, 125, 6),
(126, '2024-11-02', '2024-11-07', NULL, NULL, 12, 2, NULL, 126, 6),
(127, '2024-11-07', '2024-11-10', NULL, NULL, 5, 23, NULL, 127, 6),
(128, '2024-11-12', '2024-11-14', NULL, NULL, 6, 24, NULL, 128, 3),
(129, '2024-11-13', '2024-11-15', NULL, NULL, 11, 24, NULL, 129, 6),
(130, '2025-01-02', '2025-01-04', NULL, NULL, 6, 23, NULL, 130, 6),
(131, '2025-01-02', '2025-01-09', NULL, NULL, 12, 19, NULL, 131, 6),
(132, '2025-01-02', '2025-01-02', NULL, NULL, 15, 25, NULL, 132, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cuentas-clientes`
--

CREATE TABLE `cuentas-clientes` (
  `idCuentaCliente` int(11) NOT NULL,
  `nombreUsuarioCliente` varchar(20) NOT NULL,
  `passwordCliente` varchar(50) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idEstadoCuentaCliente` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cuentas-clientes`
--

INSERT INTO `cuentas-clientes` (`idCuentaCliente`, `nombreUsuarioCliente`, `passwordCliente`, `idCliente`, `idEstadoCuentaCliente`) VALUES
(1, 'brunancio', '123', 1, 2),
(2, 'nicosio', '123', 12, 1),
(3, 'facunyo', '123', 3, 1),
(4, 'nosoyunbot', '123', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `detalle-contratos`
--

CREATE TABLE `detalle-contratos` (
  `idDetalleContrato` int(11) NOT NULL,
  `precioPorDiaContrato` float NOT NULL,
  `cantidadDiasContrato` int(11) NOT NULL,
  `montoTotalContrato` float NOT NULL,
  `condicionesContrato` varchar(100) DEFAULT NULL COMMENT 'Aclaraciones opcionales sobre condiciones del contrato',
  `estadoContrato` varchar(100) DEFAULT NULL COMMENT 'Aclaraciones opcionales sobre el estado del contrato',
  `idEntregaVehiculo` int(11) DEFAULT NULL,
  `idDevVehiculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `detalle-contratos`
--

INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES
(1, 50, 2, 100, NULL, 'El estado ha sido modificado', NULL, NULL),
(2, 55.1, 7, 385.7, NULL, 'El estado ha sido modificado', NULL, NULL),
(3, 150.5, 2, 301, NULL, 'El estado ha sido modificado', NULL, NULL),
(4, 40.2, 3, 120.6, NULL, 'El estado ha sido modificado', NULL, NULL),
(5, 33.6, 2, 67.2, NULL, 'El estado ha sido modificado', NULL, NULL),
(7, 60, 116, 6960, NULL, 'El estado ha sido modificado', NULL, NULL),
(8, 60.2, 2, 120.4, NULL, 'El estado ha sido modificado', NULL, NULL),
(10, 53.5, 2, 107, NULL, 'El estado ha sido modificado', NULL, NULL),
(11, 55, 2, 110, NULL, 'El estado ha sido modificado', NULL, NULL),
(12, 50.5, 3, 151.5, NULL, 'El estado ha sido modificado', NULL, NULL),
(13, 33.2, 3, 99.6, NULL, 'El estado ha sido modificado', NULL, NULL),
(14, 90, 16, 1440, NULL, 'El estado ha sido modificado', NULL, NULL),
(15, 50, 21, 1050, NULL, 'El estado ha sido modificado', NULL, NULL),
(16, 100, 4, 400, NULL, 'El estado ha sido modificado', NULL, NULL),
(17, 80, 2, 160, NULL, 'El estado ha sido modificado', NULL, NULL),
(18, 90.6, 2, 181.2, NULL, NULL, NULL, NULL),
(19, 55, 4, 220, NULL, 'El estado ha sido modificado', NULL, NULL),
(20, 61, 5, 305, NULL, 'El estado ha sido modificado', NULL, NULL),
(21, 73.2, 3, 219.6, NULL, 'El estado ha sido modificado', NULL, NULL),
(22, 89, 8, 712, NULL, 'El estado ha sido modificado', NULL, NULL),
(23, 48.61, 5, 243.05, NULL, 'El estado ha sido modificado', NULL, NULL),
(24, 58.43, 5, 292.15, NULL, 'El estado ha sido modificado', NULL, NULL),
(25, 72.49, 3, 217.47, NULL, 'El estado ha sido modificado', NULL, NULL),
(26, 34.27, 6, 205.62, NULL, 'El estado ha sido modificado', NULL, NULL),
(27, 88.9, 3, 266.7, NULL, 'El estado ha sido modificado', NULL, NULL),
(28, 81.6, 5, 408, NULL, 'El estado ha sido modificado', NULL, NULL),
(29, 99.1, 4, 396.4, NULL, 'El estado ha sido modificado', NULL, NULL),
(30, 71.8, 8, 574.4, NULL, 'El estado ha sido modificado', NULL, NULL),
(31, 75, 2, 150, NULL, 'El estado ha sido modificado', NULL, NULL),
(32, 89.3, 3, 267.9, NULL, 'El estado ha sido modificado', NULL, NULL),
(33, 89, 2, 178, NULL, 'El estado ha sido modificado', NULL, NULL),
(34, 73, 4, 292, NULL, 'El estado ha sido modificado', NULL, NULL),
(35, 46.8, 2, 93.6, NULL, 'El estado ha sido modificado', NULL, NULL),
(36, 70, 1, 70, NULL, 'El estado ha sido modificado', NULL, NULL),
(37, 79.3, 2, 158.6, NULL, 'El estado ha sido modificado', NULL, NULL),
(38, 65.81, 1, 65.81, NULL, 'El estado ha sido modificado', NULL, NULL),
(39, 69.81, 5, 349.05, NULL, 'El estado ha sido modificado', NULL, NULL),
(40, 78.3, 2, 156.6, NULL, 'El estado ha sido modificado', NULL, NULL),
(41, 98.1, 3, 294.3, NULL, 'El estado ha sido modificado', NULL, NULL),
(42, 110.32, 4, 441.28, NULL, 'El estado ha sido modificado', NULL, NULL),
(43, 87, 3, 261, NULL, 'El estado ha sido modificado', NULL, NULL),
(44, 82.99, 3, 248.97, NULL, 'El estado ha sido modificado', NULL, NULL),
(45, 87.39, 2, 174.78, NULL, 'El estado ha sido modificado', NULL, NULL),
(46, 91.15, 3, 273.45, NULL, 'El estado ha sido modificado', NULL, NULL),
(47, 86.87, 4, 347.48, NULL, 'El estado ha sido modificado', NULL, NULL),
(48, 78.2, 9, 703.8, NULL, 'El estado ha sido modificado', NULL, NULL),
(49, 98.2, 2, 196.4, NULL, 'El estado ha sido modificado', NULL, NULL),
(50, 110.25, 3, 330.75, NULL, 'El estado ha sido modificado', NULL, NULL),
(51, 105.4, 3, 316.2, NULL, 'El estado ha sido modificado', NULL, NULL),
(52, 67, 2, 134, NULL, 'El estado ha sido modificado', NULL, NULL),
(53, 68, 3, 204, NULL, 'El estado ha sido modificado', NULL, NULL),
(54, 78, 2, 156, NULL, 'El estado ha sido modificado', NULL, NULL),
(55, 71.11, 5, 355.55, NULL, 'El estado ha sido modificado', NULL, NULL),
(56, 78.12, 4, 312.48, NULL, 'El estado ha sido modificado', NULL, NULL),
(57, 88.7, 1, 88.7, NULL, 'El estado ha sido modificado', NULL, NULL),
(58, 91.3, 3, 273.9, NULL, 'El estado ha sido modificado', NULL, NULL),
(59, 67.88, 3, 203.64, NULL, 'El estado ha sido modificado', NULL, NULL),
(60, 78.28, 5, 391.4, NULL, 'El estado ha sido modificado', NULL, NULL),
(61, 76.9, 3, 230.7, NULL, 'El estado ha sido modificado', NULL, NULL),
(62, 89.88, 4, 359.52, NULL, 'El estado ha sido modificado', NULL, NULL),
(63, 91.9, 6, 551.4, NULL, 'El estado ha sido modificado', NULL, NULL),
(64, 81.71, 1, 81.71, NULL, 'El estado ha sido modificado', NULL, NULL),
(65, 86.8, 1, 86.8, NULL, 'El estado ha sido modificado', NULL, NULL),
(66, 101.3, 5, 506.5, NULL, 'El estado ha sido modificado', NULL, NULL),
(67, 201, 3, 603, NULL, 'El estado ha sido modificado', NULL, NULL),
(68, 120.8, 3, 362.4, NULL, 'El estado ha sido modificado', NULL, NULL),
(69, 110.9, 3, 332.7, NULL, 'El estado ha sido modificado', NULL, NULL),
(70, 99.9, 2, 199.8, NULL, 'El estado ha sido modificado', NULL, NULL),
(71, 110.99, 3, 332.97, NULL, 'El estado ha sido modificado', NULL, NULL),
(72, 110.9, 2, 221.8, NULL, 'El estado ha sido modificado', NULL, NULL),
(73, 105.99, 2, 211.98, NULL, 'El estado ha sido modificado', NULL, NULL),
(74, 110, 2, 220, NULL, 'El estado ha sido modificado', NULL, NULL),
(75, 115.88, 3, 347.64, NULL, 'El estado ha sido modificado', NULL, NULL),
(76, 113.99, 3, 341.97, NULL, 'El estado ha sido modificado', NULL, NULL),
(77, 120, 1, 120, NULL, 'El estado ha sido modificado', NULL, NULL),
(78, 120.99, 2, 241.98, NULL, 'El estado ha sido modificado', NULL, NULL),
(79, 110, 2, 220, NULL, 'El estado ha sido modificado', NULL, NULL),
(80, 120, 3, 360, NULL, 'El estado ha sido modificado', NULL, NULL),
(81, 130, 2, 260, NULL, 'El estado ha sido modificado', NULL, NULL),
(82, 120, 3, 360, NULL, 'El estado ha sido modificado', NULL, NULL),
(83, 125, 2, 250, NULL, 'El estado ha sido modificado', NULL, NULL),
(84, 130, 3, 390, NULL, 'El estado ha sido modificado', NULL, NULL),
(85, 100, 2, 200, NULL, 'El estado ha sido modificado', NULL, NULL),
(86, 120, 4, 480, NULL, 'El estado ha sido modificado', NULL, NULL),
(87, 120, 4, 480, NULL, 'El estado ha sido modificado', NULL, NULL),
(88, 125, 3, 375, NULL, 'El estado ha sido modificado', NULL, NULL),
(89, 113, 3, 339, NULL, 'El estado ha sido modificado', NULL, NULL),
(90, 135, 3, 405, NULL, 'El estado ha sido modificado', NULL, NULL),
(91, 117, 2, 234, NULL, 'El estado ha sido modificado', NULL, NULL),
(92, 140, 4, 560, NULL, 'El estado ha sido modificado', NULL, NULL),
(93, 130, 3, 390, NULL, 'El estado ha sido modificado', NULL, NULL),
(94, 120, 3, 360, NULL, 'El estado ha sido modificado', NULL, NULL),
(95, 135, 2, 270, NULL, 'El estado ha sido modificado', NULL, NULL),
(96, 110, 3, 330, NULL, 'El estado ha sido modificado', NULL, NULL),
(97, 135, 2, 270, NULL, 'El estado ha sido modificado', NULL, NULL),
(98, 145, 1, 145, NULL, 'El estado ha sido modificado', NULL, NULL),
(99, 150, 3, 450, NULL, 'El estado ha sido modificado', NULL, NULL),
(100, 140, 4, 560, NULL, 'El estado ha sido modificado', NULL, NULL),
(101, 130, 3, 390, NULL, 'El estado ha sido modificado', NULL, NULL),
(102, 140, 3, 420, NULL, 'El estado ha sido modificado', NULL, NULL),
(103, 135, 3, 405, NULL, 'El estado ha sido modificado', NULL, NULL),
(104, 145, 3, 435, NULL, 'El estado ha sido modificado', NULL, NULL),
(105, 135, 2, 270, NULL, 'El estado ha sido modificado', NULL, NULL),
(106, 125, 3, 375, NULL, 'El estado ha sido modificado', NULL, NULL),
(107, 155, 2, 310, NULL, 'El estado ha sido modificado', NULL, NULL),
(108, 135, 3, 405, NULL, 'El estado ha sido modificado', NULL, NULL),
(109, 145, 3, 435, NULL, 'El estado ha sido modificado', NULL, NULL),
(110, 128, 3, 384, NULL, 'El estado ha sido modificado', NULL, NULL),
(111, 145, 3, 435, NULL, 'El estado ha sido modificado', NULL, NULL),
(112, 135, 3, 405, NULL, 'El estado ha sido modificado', NULL, NULL),
(113, 145, 5, 725, NULL, 'El estado ha sido modificado', NULL, NULL),
(114, 150, 3, 450, NULL, 'El estado ha sido modificado', NULL, NULL),
(115, 130, 4, 520, NULL, 'El estado ha sido modificado', NULL, NULL),
(116, 145, 3, 435, NULL, 'El estado ha sido modificado', NULL, NULL),
(117, 165, 2, 330, NULL, 'El estado ha sido modificado', NULL, NULL),
(118, 165, 2, 330, NULL, 'El estado ha sido modificado', NULL, NULL),
(119, 165, 3, 495, NULL, 'El estado ha sido modificado', NULL, NULL),
(120, 200, 2, 400, NULL, 'El estado ha sido modificado', NULL, NULL),
(121, 180, 2, 360, NULL, 'El estado ha sido modificado', NULL, NULL),
(122, 205, 4, 820, NULL, 'El estado ha sido modificado', NULL, NULL),
(123, 120, 3, 360, NULL, 'El estado ha sido modificado', NULL, NULL),
(124, 138.9, 5, 694.5, NULL, 'El estado ha sido modificado', NULL, NULL),
(125, 135.7, 3, 407.1, NULL, 'El estado ha sido modificado', NULL, NULL),
(126, 110, 5, 550, NULL, 'El estado ha sido modificado', NULL, NULL),
(127, 125, 3, 375, NULL, 'El estado ha sido modificado', NULL, NULL),
(128, 125, 2, 250, NULL, 'El estado ha sido modificado', NULL, NULL),
(129, 135, 2, 270, NULL, 'El estado ha sido modificado', NULL, NULL),
(130, 55, 2, 110, NULL, 'El estado ha sido modificado', NULL, NULL),
(131, 45, 7, 315, NULL, 'El estado ha sido modificado', NULL, NULL),
(132, 55, 0, 0, NULL, 'El estado ha sido modificado', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detalle-pedidoaproveedor`
--

CREATE TABLE `detalle-pedidoaproveedor` (
  `idDetallePedidoAProveedor` int(11) NOT NULL,
  `descripcionPedido` varchar(200) DEFAULT NULL COMMENT 'Se sugiere colocar breve descripción del insumo pedido a proveedor.',
  `precioPorUnidad` float NOT NULL,
  `cantidadUnidades` int(11) NOT NULL,
  `montoTotalPedido` float NOT NULL,
  `condicionesDeEntrega` varchar(200) DEFAULT NULL COMMENT 'Campo opcional que permite registrar condiciones pactadas de entrega.',
  `estadoDelPedido` varchar(200) DEFAULT NULL COMMENT 'Campo opcional que permite incorporar información adicional sobre el estado del pedido, en caso de ser necesario.',
  `idRepuestoVehiculo` int(11) DEFAULT NULL COMMENT 'Cada registro de "Pedido a Proveedor" involucra solo un repuesto, un producto, o un accesorio, nunca puede involucrar a los tres campos.',
  `idProductoVehiculo` int(11) DEFAULT NULL COMMENT 'Cada registro de "Pedido a Proveedor" involucra solo un repuesto, un producto, o un accesorio, nunca puede involucrar a los tres campos.',
  `idAccesorioVehiculo` int(11) DEFAULT NULL COMMENT 'Cada registro de "Pedido a Proveedor" involucra solo un repuesto, un producto, o un accesorio, nunca puede involucrar a los tres campos.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devoluciones-vehiculos`
--

CREATE TABLE `devoluciones-vehiculos` (
  `idDevolucion` int(11) NOT NULL,
  `fechaDevolucion` date NOT NULL,
  `estadoDevolucion` varchar(200) DEFAULT NULL COMMENT 'Campo opcional señalando el estado del vehículo en caso de requerirse',
  `aclaracionesDevolucion` varchar(200) DEFAULT NULL COMMENT 'Campo opcional con aclaraciones sobre la devolución en caso de requerirse',
  `infraccionesDevolucion` varchar(200) DEFAULT NULL COMMENT 'Campo opcional señalando infracciones cometidas',
  `costosInfracciones` float DEFAULT NULL,
  `montoExtra` float DEFAULT NULL COMMENT 'Monto extra a cobrar por infracciones, en caso de requerirse',
  `idCliente` int(11) DEFAULT NULL,
  `idContrato` int(11) DEFAULT NULL,
  `idVerificacion` int(11) DEFAULT NULL COMMENT 'Rutina de verificación asociada a la devolución del vehículo',
  `idVendedorReceptor` int(11) DEFAULT NULL COMMENT 'Vendedor que recibe el vehículo al ser devuelto',
  `horaDevolucion` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `devoluciones-vehiculos`
--

INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `horaDevolucion`) VALUES
(2, '2025-04-11', 'Capot dañado', 'Choque en autopista RNA001 ', 'Velocidad', 1000, 4000, 6, 14, NULL, NULL, '04:09'),
(3, '2025-04-25', 'Sin cambios', 'Cliente reporta problemas con el limpiaparabrisas', 'Ninguna', 0, 0, 8, 13, NULL, NULL, '04:09'),
(4, '2024-12-21', 'Requiere limpieza profunda', 'Accidente con aderesos y otros alimentos en el asiento trasero', 'Ninguna', 0, 45, 17, 8, NULL, NULL, '07:00'),
(5, '2025-04-04', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', 0, 0, 11, 7, NULL, NULL, '07:00'),
(6, '2025-01-04', 'Sin cambios', 'Cliente reporta problemas de inflado de neumáticos', 'Ninguna', 0, 0, 6, 130, NULL, NULL, '21:20'),
(7, '2025-01-09', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', 0, 0, 12, 131, NULL, NULL, '07:00'),
(8, '2025-02-08', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', 0, 0, 3, 18, NULL, NULL, '16:30'),
(9, '2024-12-18', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', 0, 0, 7, 10, NULL, NULL, '20:00');

-- --------------------------------------------------------

--
-- Table structure for table `empleados`
--

CREATE TABLE `empleados` (
  `idEmpleado` int(11) NOT NULL,
  `nombreEmpleado` varchar(50) NOT NULL,
  `apellidoEmpleado` varchar(50) NOT NULL,
  `dniEmpleado` int(10) NOT NULL,
  `mailEmpleado` varchar(100) NOT NULL,
  `telefonoEmpleado` int(10) NOT NULL,
  `direccionEmpleado` varchar(100) NOT NULL,
  `cargoEmpleado` varchar(100) NOT NULL,
  `salarioEmpleado` float NOT NULL,
  `fechaIngresoEmpleado` date NOT NULL,
  `idSucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entregas-vehiculos`
--

CREATE TABLE `entregas-vehiculos` (
  `idEntrega` int(11) NOT NULL,
  `fechaEntrega` date NOT NULL,
  `horaEntrega` varchar(8) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idContrato` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `entregas-vehiculos`
--

INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES
(1, '2024-01-01', '07:00', 6, 19),
(2, '2025-01-02', '07:35', 6, 130),
(3, '2025-01-02', '13:15', 3, 18),
(4, '2024-12-11', '15:00', 17, 8),
(5, '2025-04-16', '02:10', 7, 12),
(6, '2025-04-16', '19:12', 12, 15),
(7, '2024-12-14', '21:30', 7, 10),
(8, '2024-12-15', '07:15', 8, 11),
(9, '2024-01-18', '08:20', 10, 28),
(10, '2025-01-01', '17:00', 1, 17),
(11, '2025-01-02', '06:00', 12, 131),
(12, '2025-01-02', '07:00', 15, 132),
(13, '2024-12-09', '05:00', 11, 7);

-- --------------------------------------------------------

--
-- Table structure for table `estados-contratos`
--

CREATE TABLE `estados-contratos` (
  `idEstadoContrato` int(11) NOT NULL,
  `estadoContrato` varchar(50) NOT NULL,
  `descripcionEstadoContrato` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `estados-contratos`
--

INSERT INTO `estados-contratos` (`idEstadoContrato`, `estadoContrato`, `descripcionEstadoContrato`) VALUES
(1, 'En Preparación', NULL),
(2, 'Firmado', NULL),
(3, 'Cancelado', NULL),
(4, 'Activo', NULL),
(5, 'Renovado', NULL),
(6, 'Finalizado', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estados-cuentacliente`
--

CREATE TABLE `estados-cuentacliente` (
  `idEstadoCuenta` int(11) NOT NULL,
  `Denominacion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `estados-cuentacliente`
--

INSERT INTO `estados-cuentacliente` (`idEstadoCuenta`, `Denominacion`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `estados-pedidoaproveedor`
--

CREATE TABLE `estados-pedidoaproveedor` (
  `idEstadoPedido` int(11) NOT NULL,
  `estadoPedido` varchar(50) NOT NULL,
  `descripcionEstadoPedido` varchar(200) DEFAULT NULL COMMENT 'Descripción optativa del estado.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `estados-pedidoaproveedor`
--

INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES
(1, 'Pendiente', NULL),
(2, 'Confirmado', NULL),
(3, 'Cancelado', NULL),
(4, 'En Preparación', NULL),
(5, 'Enviado', NULL),
(6, 'Entregado', NULL),
(7, 'Devuelto', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks-clientes`
--

CREATE TABLE `feedbacks-clientes` (
  `idFeedbackCliente` int(11) NOT NULL,
  `descripcionFeedback` varchar(200) NOT NULL,
  `puntuacionFeedback` int(1) NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idCuentaCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `feedbacks-clientes`
--

INSERT INTO `feedbacks-clientes` (`idFeedbackCliente`, `descripcionFeedback`, `puntuacionFeedback`, `idVehiculo`, `idCuentaCliente`) VALUES
(1, 'Gran experiencia. Los frenos están un poco quemados', 4, 1, 1),
(2, 'La verdad que podría mejorar', 2, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `grupos-vehiculos`
--

CREATE TABLE `grupos-vehiculos` (
  `idGrupo` int(11) NOT NULL,
  `nombreGrupo` varchar(40) NOT NULL,
  `descripcionGrupo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `grupos-vehiculos`
--

INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`) VALUES
(1, 'Automóvil deportivo', NULL),
(2, 'Compacto deportivo', NULL),
(3, 'Sedán deportivo', NULL),
(4, 'Sedán', NULL),
(5, 'Deportivo', NULL),
(6, 'Superdeportivo ', NULL),
(7, 'Gran turismo', NULL),
(8, 'Descapotable', NULL),
(9, 'Bólido muscle americano', NULL),
(10, 'Pony', NULL),
(11, 'Coupe', NULL),
(12, 'Camioneta pickup ', NULL),
(13, 'Sedán de lujo', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `intereses-clientes`
--

CREATE TABLE `intereses-clientes` (
  `idInteresCliente` int(11) NOT NULL,
  `motivoDeInteres` varchar(100) NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idCuentaCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `intereses-clientes`
--

INSERT INTO `intereses-clientes` (`idInteresCliente`, `motivoDeInteres`, `idVehiculo`, `idCuentaCliente`) VALUES
(1, 'lindo auto para alquilar cuando tenga $!', 1, 4),
(2, 'Alcanza 230kmh en ruta!', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mantenimientos-vehiculos`
--

CREATE TABLE `mantenimientos-vehiculos` (
  `idMantenimiento` int(11) NOT NULL,
  `nombreMantenimiento` varchar(50) NOT NULL,
  `descripcionMantenimiento` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del tipo de mantenimiento realizado',
  `fechaInicioMantenimiento` date NOT NULL,
  `fechaFinMantenimiento` date NOT NULL,
  `costoMantenimiento` float NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idRepuestoUsado` int(11) DEFAULT NULL COMMENT 'En caso de que se haya utilizado un repuesto en las labores de mantenimiento. Cada registro de mantenimiento puede involucrar cero (0) a un (1) repuestos.',
  `idProductoUsado` int(11) DEFAULT NULL COMMENT 'En caso de que se haya utilizado un producto en las labores de mantenimiento. Cada registro de mantenimiento puede involucrar cero (0) a un (1) producto.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modelos`
--

CREATE TABLE `modelos` (
  `idModelo` int(11) NOT NULL,
  `nombreModelo` varchar(20) NOT NULL,
  `descripcionModelo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `modelos`
--

INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES
(1, 'Toyota Hilux', NULL),
(2, 'Ford Ranger', NULL),
(3, 'Mercedes Clase S', NULL),
(4, 'Porsche Taycan', NULL),
(5, 'Mercedes EQS', NULL),
(6, 'Rolls-Royce Phantom', NULL),
(7, 'Rolls-Royce Ghost', NULL),
(8, 'Porsche Cayenne', NULL),
(9, 'Range Rover', NULL),
(10, 'Audi RS7 Sportback', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pedido-a-proveedor`
--

CREATE TABLE `pedido-a-proveedor` (
  `idPedido` int(11) NOT NULL,
  `fechaPedido` date NOT NULL,
  `fechaEntregaPedido` date NOT NULL,
  `idDetallePedido` int(11) DEFAULT NULL COMMENT 'Detalle de la transacción.',
  `idProveedor` int(11) DEFAULT NULL,
  `idEstadoPedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preparaciones-vehiculos`
--

CREATE TABLE `preparaciones-vehiculos` (
  `idPreparacion` int(11) NOT NULL,
  `descripcionPreparacion` varchar(200) DEFAULT NULL COMMENT 'Breve descripción opcional del tipo de preparación realizada.',
  `fechaInicioPreparacion` date NOT NULL,
  `fechaFinPreparacion` date NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `idProductoUsado` int(11) DEFAULT NULL COMMENT 'Solo se admite un producto por cada registro de "preparación". '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos-vehiculo`
--

CREATE TABLE `productos-vehiculo` (
  `idProducto` int(11) NOT NULL,
  `nombreProducto` varchar(50) NOT NULL,
  `descripcionProducto` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del producto',
  `precioProducto` float NOT NULL,
  `estadoProducto` varchar(100) DEFAULT NULL COMMENT 'Descripción optativa del estado del producto en caso de requerirse',
  `idTipoInsumo` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `idVehiculoDestinatario` int(11) DEFAULT NULL COMMENT 'Campo optativo que señala para cuál vehículo se adquirió el producto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` int(11) NOT NULL,
  `nombreProveedor` varchar(50) NOT NULL,
  `mailProveedor` varchar(50) NOT NULL,
  `direccionProveedor` varchar(50) NOT NULL,
  `telefonoProveedor` int(15) NOT NULL,
  `localidadProveedor` varchar(50) NOT NULL,
  `idTipoInsumo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repuestos-vehiculos`
--

CREATE TABLE `repuestos-vehiculos` (
  `idRepuesto` int(11) NOT NULL,
  `nombreRepuesto` varchar(100) NOT NULL,
  `descripcionRepuesto` varchar(200) NOT NULL,
  `precioRepuesto` float NOT NULL,
  `estadoRepuesto` varchar(100) DEFAULT NULL COMMENT 'Campo opcional con aclaraciones sobre el estado del repuesto',
  `disponibilidadRepuesto` char(1) NOT NULL COMMENT 'N (no) para no disponible, S (sí) para disponible',
  `idTipoInsumo` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `idVehiculoHospedante` int(11) DEFAULT NULL COMMENT 'El vehículo que lleva el repuesto en caso de encontrarse no disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservas-vehiculos`
--

CREATE TABLE `reservas-vehiculos` (
  `idReserva` int(11) NOT NULL,
  `numeroReserva` int(11) DEFAULT NULL COMMENT 'Número de reserva del cliente',
  `fechaReserva` date NOT NULL,
  `fechaInicioReserva` date NOT NULL,
  `FechaFinReserva` date NOT NULL,
  `precioPorDiaReserva` float NOT NULL,
  `cantidadDiasReserva` int(11) NOT NULL,
  `totalReserva` float NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idContrato` int(11) DEFAULT NULL,
  `idSucursal` int(11) DEFAULT NULL,
  `idVehiculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `reservas-vehiculos`
--

INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`) VALUES
(1, 12, '2024-11-01', '2024-11-02', '2024-11-05', 30, 3, 90, 8, NULL, 1, 18),
(2, 5, '2024-11-01', '2024-11-05', '2024-11-07', 20, 2, 40, 15, NULL, 1, 20),
(3, 8, '2024-11-01', '2024-11-04', '2024-11-08', 50, 4, 200, 4, NULL, 2, 32),
(5, 9, '2024-11-01', '2024-11-13', '2024-11-20', 20, 7, 140, 12, NULL, NULL, 1),
(6, 10, '2024-11-01', '2024-11-07', '2024-11-10', 20, 3, 60, 11, NULL, NULL, 3),
(7, 15, '2024-11-29', '2024-11-20', '2024-11-23', 20, 3, 60, 6, NULL, NULL, 24),
(8, 1, '2024-11-01', '2024-11-12', '2024-11-15', 20, 3, 60, 10, NULL, NULL, 3),
(9, 3, '2024-11-01', '2024-11-15', '2024-11-18', 20, 3, 60, 11, NULL, NULL, 2),
(10, 2, '2024-11-01', '2024-11-22', '2024-11-25', 20, 3, 60, 1, NULL, NULL, 2),
(14, 22, '2024-11-30', '2024-12-03', '2024-12-05', 20, 4, 80, 4, NULL, NULL, 2),
(17, 4, '2024-12-04', '2024-12-17', '2024-12-23', 20.5, 3, 61.5, 7, NULL, NULL, 19),
(18, 21, '2024-12-04', '2024-12-25', '2024-12-27', 20, 21, 420, 9, NULL, NULL, 2),
(19, 20, '2024-12-04', '2024-12-10', '2024-12-11', 20, 6, 120, 17, NULL, NULL, 7),
(20, 11, '2024-12-04', '2024-12-06', '2024-12-07', 20, 2, 40, 5, NULL, NULL, 23),
(21, 6, '2024-12-04', '2024-12-05', '2024-12-08', 20, 1, 20, 11, NULL, NULL, 23),
(22, 23, '2024-12-06', '2024-12-11', '2024-12-13', 20, 5, 100, 17, 8, NULL, 2),
(24, 24, '2024-12-07', '2024-12-14', '2024-12-16', 20, 7, 140, 7, 10, NULL, 1),
(25, 25, '2024-12-07', '2024-12-17', '2024-12-19', 50.1, 2, 100.2, 7, 12, 4, 32),
(26, 26, '2024-12-07', '2024-12-17', '2024-12-19', 33.3, 2, 66.6, 8, 13, 2, 6),
(27, 27, '2024-12-07', '2024-12-11', '2024-12-27', 90, 16, 1440, 6, 14, 4, 19),
(28, 28, '2024-12-07', '2024-12-14', '2025-01-04', 50, 21, 1050, 12, 15, 4, 36),
(29, 29, '2024-12-07', '2025-01-02', '2025-01-04', 90.6, 2, 181.2, 3, 18, 1, 1),
(30, 30, '2024-12-07', '2024-01-02', '2024-01-07', 61, 5, 305, 4, 20, 4, 32),
(31, 31, '2024-12-07', '2024-01-02', '2024-01-05', 73.2, 3, 219.6, 5, 21, 1, 3),
(32, 32, '2024-12-07', '2024-01-03', '2024-01-11', 89, 8, 712, 7, 22, 4, 35),
(33, 33, '2024-12-07', '2024-01-05', '2024-01-10', 48.61, 5, 243.05, 1, 23, 2, 7),
(34, 34, '2024-12-07', '2024-01-05', '2024-01-10', 58.43, 5, 292.15, 2, 24, 4, 19),
(35, 35, '2024-12-07', '2024-01-09', '2024-01-12', 72.49, 3, 217.47, 3, 25, 3, 30),
(36, 36, '2024-12-07', '2024-01-11', '2024-01-17', 34.27, 6, 205.62, 8, 26, 2, 6),
(37, 37, '2024-12-07', '2024-01-16', '2024-01-19', 88.9, 3, 266.7, 9, 27, 1, 1),
(38, 38, '2024-12-07', '2024-01-18', '2024-01-23', 81.6, 5, 408, 10, 28, 3, 28),
(39, 39, '2024-12-07', '2024-01-20', '2024-01-24', 99.1, 4, 396.4, 11, 29, 3, 18),
(40, 40, '2024-12-07', '2024-01-21', '2024-01-29', 71.8, 8, 574.4, 12, 30, 2, 21),
(41, 41, '2024-12-07', '2024-01-25', '2024-01-27', 75, 2, 150, 15, 31, 1, 23),
(42, 42, '2024-12-07', '2024-01-27', '2024-01-30', 89.3, 3, 267.9, 17, 32, 1, 24),
(43, 43, '2024-12-07', '2024-01-27', '2024-01-29', 89, 2, 178, 1, 33, 4, 36),
(44, 44, '2024-12-07', '2024-01-29', '2024-02-02', 73, 4, 292, 2, 34, 3, 20),
(45, 45, '2024-12-07', '2024-02-01', '2024-02-03', 46.8, 2, 93.6, 3, 35, 2, 2),
(46, 46, '2024-12-07', '2024-02-02', '2024-02-03', 70, 1, 70, 4, 36, 4, 32),
(47, 47, '2024-12-07', '2024-02-03', '2024-02-05', 79.3, 2, 158.6, 5, 37, 1, 3),
(48, 48, '2024-12-07', '2024-02-05', '2024-02-06', 65.81, 1, 65.81, 6, 38, 4, 35),
(49, 49, '2024-12-07', '2024-02-05', '2024-02-10', 69.81, 5, 349.05, 7, 39, 2, 7),
(50, 50, '2024-12-07', '2024-02-07', '2024-02-09', 78.3, 2, 156.6, 8, 40, 4, 19),
(51, 51, '2024-12-07', '2024-02-09', '2024-02-12', 98.1, 3, 294.3, 9, 41, 3, 30),
(52, 52, '2024-12-07', '2024-02-10', '2024-02-14', 110.32, 4, 441.28, 10, 42, 2, 6),
(53, 53, '2024-12-07', '2024-02-12', '2024-02-15', 87, 3, 261, 11, 43, 2, 25),
(54, 54, '2024-12-07', '2024-02-13', '2024-02-16', 82.99, 3, 248.97, 12, 44, 1, 1),
(55, 55, '2024-12-07', '2024-02-15', '2024-02-17', 87.39, 2, 174.78, 15, 45, 3, 28),
(56, 56, '2024-12-07', '2024-02-17', '2024-02-20', 91.15, 3, 273.45, 17, 46, 3, 18),
(57, 57, '2024-12-07', '2024-02-20', '2024-02-24', 86.87, 4, 347.48, 1, 47, 2, 21),
(58, 58, '2024-12-07', '2024-02-20', '2024-02-29', 78.2, 9, 703.8, 2, 48, 1, 23),
(59, 59, '2024-12-07', '2024-02-21', '2024-02-23', 98.2, 2, 196.4, 3, 49, 1, 24),
(60, 60, '2024-12-07', '2024-02-24', '2024-02-27', 110.25, 3, 330.75, 4, 50, 4, 36),
(61, 61, '2024-12-07', '2024-02-24', '2024-02-27', 105.4, 3, 316.2, 5, 51, 3, 20),
(62, 62, '2024-12-07', '2024-02-25', '2024-02-27', 67, 2, 134, 6, 52, 2, 2),
(63, 63, '2024-12-07', '2024-02-25', '2024-02-28', 68, 3, 204, 7, 53, 4, 32),
(64, 64, '2024-12-07', '2024-02-27', '2024-02-29', 78, 2, 156, 8, 54, 4, 35),
(65, 65, '2024-12-07', '2024-02-29', '2024-03-05', 71.11, 5, 355.55, 12, 55, 1, 3),
(66, 66, '2024-12-07', '2024-02-29', '2024-03-04', 78.12, 4, 312.48, 11, 56, 4, 35),
(67, 67, '2024-12-07', '2024-03-01', '2024-03-02', 88.7, 1, 88.7, 15, 57, 2, 7),
(68, 68, '2024-12-07', '2024-03-01', '2024-03-04', 91.3, 3, 273.9, 17, 58, 4, 19),
(69, 69, '2024-12-07', '2024-03-02', '2024-03-05', 67.88, 3, 203.64, 9, 59, 2, 2),
(70, 70, '2024-12-07', '2024-03-02', '2024-03-07', 78.28, 5, 391.4, 10, 60, 4, 32),
(71, 71, '2024-12-07', '2024-03-02', '2024-03-05', 76.9, 3, 230.7, 11, 61, 1, 3),
(72, 72, '2024-12-07', '2024-03-03', '2024-03-07', 89.88, 4, 359.52, 12, 62, 4, 35),
(73, 73, '2024-12-07', '2024-03-03', '2024-03-09', 91.9, 6, 551.4, 15, 63, 2, 7),
(74, 74, '2024-12-07', '2024-03-04', '2024-03-05', 81.71, 1, 81.71, 1, 64, 4, 19),
(75, 75, '2024-12-07', '2024-03-05', '2024-03-06', 86.8, 1, 86.8, 2, 65, 3, 30),
(76, 76, '2024-12-07', '2024-03-06', '2024-03-11', 101.3, 5, 506.5, 3, 66, 2, 6),
(77, 77, '2024-12-07', '2024-03-07', '2024-03-10', 201, 3, 603, 4, 67, 2, 25),
(78, 78, '2024-12-07', '2024-03-07', '2024-03-10', 120.8, 3, 362.4, 5, 68, 1, 1),
(79, 79, '2024-12-07', '2024-03-08', '2024-03-11', 110.9, 3, 332.7, 6, 69, 3, 28),
(80, 80, '2024-12-07', '2024-03-09', '2024-03-11', 99.9, 2, 199.8, 7, 70, 3, 18),
(81, 81, '2024-12-07', '2024-03-09', '2024-03-12', 110.99, 3, 332.97, 8, 71, 2, 21),
(82, 82, '2024-12-07', '2024-03-12', '2024-03-14', 110.9, 2, 221.8, 9, 72, 1, 23),
(83, 83, '2024-12-07', '2024-03-15', '2024-03-17', 105.99, 2, 211.98, 10, 73, 1, 24),
(84, 84, '2024-12-07', '2024-03-16', '2024-03-18', 110, 2, 220, 11, 74, 4, 36),
(85, 85, '2024-12-07', '2024-03-18', '2024-03-21', 115.88, 3, 347.64, 12, 75, 3, 20),
(86, 86, '2024-12-07', '2024-03-19', '2024-03-22', 113.99, 3, 341.97, 15, 76, 2, 25),
(87, 87, '2024-12-07', '2024-03-24', '2024-03-25', 120, 1, 120, 17, 77, 4, 32),
(88, 88, '2024-12-07', '2024-04-01', '2024-04-03', 120.99, 2, 241.98, 1, 78, 1, 3),
(89, 89, '2024-12-07', '2024-04-03', '2024-04-05', 110, 2, 220, 4, 79, 2, 2),
(90, 90, '2024-12-07', '2024-04-05', '2024-04-08', 120, 3, 360, 7, 80, 4, 35),
(91, 91, '2024-12-07', '2024-04-07', '2024-04-09', 130, 2, 260, 10, 81, 2, 7),
(92, 92, '2024-12-07', '2024-04-07', '2024-04-10', 120, 3, 360, 11, 82, 4, 19),
(93, 93, '2024-12-07', '2024-04-10', '2024-04-12', 125, 2, 250, 15, 83, 1, 1),
(94, 94, '2024-12-07', '2024-04-12', '2024-04-15', 130, 3, 390, 17, 84, 1, 23),
(95, 95, '2024-12-07', '2024-04-14', '2024-04-16', 100, 2, 200, 4, 85, 2, 2),
(96, 96, '2024-12-07', '2024-04-19', '2024-04-23', 120, 4, 480, 5, 86, 4, 19),
(97, 97, '2024-12-07', '2024-04-26', '2024-04-30', 120, 4, 480, 6, 87, 1, 23),
(98, 98, '2024-12-07', '2024-05-03', '2024-05-06', 125, 3, 375, 1, 88, 1, 1),
(99, 99, '2024-12-07', '2024-05-06', '2024-05-09', 113, 3, 339, 2, 89, 4, 19),
(100, 100, '2024-12-07', '2024-05-07', '2024-05-10', 135, 3, 405, 3, 90, 3, 18),
(101, 101, '2024-12-07', '2024-05-09', '2024-05-11', 117, 2, 234, 6, 91, 1, 23),
(102, 102, '2024-12-07', '2024-05-11', '2024-05-15', 140, 4, 560, 10, 92, 4, 36),
(103, 103, '2024-12-07', '2024-05-14', '2024-05-17', 130, 3, 390, 12, 93, 2, 2),
(104, 104, '2024-12-07', '2024-05-22', '2024-05-25', 120, 3, 360, 17, 94, 1, 3),
(105, 105, '2024-12-07', '2024-05-24', '2024-05-26', 135, 2, 270, 5, 95, 2, 7),
(106, 106, '2024-12-07', '2024-05-26', '2024-05-29', 110, 3, 330, 8, 96, 3, 18),
(107, 107, '2024-12-07', '2024-06-01', '2024-06-03', 135, 2, 270, 9, 97, 2, 2),
(108, 108, '2024-12-07', '2024-06-03', '2024-06-04', 145, 1, 145, 10, 98, 1, 3),
(109, 109, '2024-12-07', '2024-06-04', '2024-06-07', 150, 3, 450, 11, 99, 2, 7),
(110, 110, '2024-12-07', '2024-06-05', '2024-06-09', 140, 4, 560, 12, 100, 4, 36),
(111, 111, '2024-12-07', '2024-06-07', '2024-06-10', 130, 3, 390, 17, 101, 4, 19),
(112, 112, '2024-12-07', '2024-06-09', '2024-06-12', 140, 3, 420, 1, 102, 4, 36),
(113, 113, '2024-12-07', '2024-06-12', '2024-06-15', 135, 3, 405, 4, 103, 4, 32),
(114, 114, '2024-12-07', '2024-06-15', '2024-06-18', 145, 3, 435, 3, 104, 3, 20),
(115, 115, '2024-12-07', '2024-06-20', '2024-06-22', 135, 2, 270, 6, 105, 1, 3),
(116, 116, '2024-12-07', '2024-06-22', '2024-06-25', 125, 3, 375, 7, 106, 4, 32),
(117, 117, '2024-12-07', '2024-06-25', '2024-06-27', 155, 2, 310, 10, 107, 2, 21),
(118, 118, '2024-12-07', '2024-07-03', '2024-07-06', 135, 3, 405, 2, 108, 4, 35),
(119, 119, '2024-12-07', '2024-07-05', '2024-07-08', 145, 3, 435, 6, 109, 2, 7),
(120, 120, '2024-12-07', '2024-07-09', '2024-07-12', 128, 3, 384, 5, 110, 2, 2),
(121, 121, '2024-12-07', '2024-07-10', '2024-07-13', 145, 3, 435, 1, 111, 2, 6),
(122, 122, '2024-12-07', '2024-07-13', '2024-07-16', 135, 3, 405, 8, 112, 4, 35),
(123, 123, '2024-12-07', '2024-07-13', '2024-07-18', 145, 5, 725, 12, 113, 3, 30),
(124, 124, '2024-12-07', '2024-07-15', '2024-07-18', 150, 3, 450, 17, 114, 1, 1),
(125, 125, '2024-12-07', '2024-07-16', '2024-07-20', 130, 4, 520, 3, 115, 1, 3),
(126, 126, '2024-12-07', '2024-08-03', '2024-08-06', 145, 3, 435, 4, 116, 2, 2),
(127, 127, '2024-12-07', '2024-08-07', '2024-08-09', 165, 2, 330, 5, 117, 2, 6),
(128, 128, '2024-12-07', '2024-08-10', '2024-08-12', 165, 2, 330, 6, 118, 2, 25),
(129, 129, '2024-12-07', '2024-08-13', '2024-08-16', 165, 3, 495, 7, 119, 3, 18),
(130, 130, '2024-12-07', '2024-08-23', '2024-08-25', 200, 2, 400, 10, 120, 4, 36),
(131, 131, '2024-12-07', '2024-08-29', '2024-08-31', 180, 2, 360, 15, 121, 1, 23),
(132, 132, '2024-12-07', '2024-09-05', '2024-09-09', 205, 4, 820, 1, 122, 1, 1),
(133, 133, '2024-12-07', '2024-10-07', '2024-10-10', 120, 3, 360, 15, 123, 4, 19),
(134, 134, '2024-12-07', '2024-10-09', '2024-10-14', 138.9, 5, 694.5, 1, 124, 2, 25),
(135, 135, '2024-12-07', '2024-10-16', '2024-10-19', 135.7, 3, 407.1, 3, 125, 3, 18),
(136, 136, '2024-12-07', '2024-11-02', '2024-11-07', 110, 5, 550, 12, 126, 2, 2),
(137, 139, '2024-12-07', '2024-11-07', '2024-11-10', 125, 3, 375, 5, 127, 1, 23),
(138, 140, '2024-12-07', '2024-11-12', '2024-11-14', 125, 2, 250, 6, 128, 1, 24),
(139, 141, '2024-12-07', '2024-11-13', '2024-11-15', 135, 2, 270, 11, 129, 1, 24),
(140, 142, '2025-04-05', '2025-01-02', '2025-01-09', 45, 7, 315, 12, 131, 4, 19);

-- --------------------------------------------------------

--
-- Table structure for table `sucursales`
--

CREATE TABLE `sucursales` (
  `idSucursal` int(11) NOT NULL,
  `numeroSucursal` int(11) NOT NULL,
  `direccionSucursal` varchar(50) NOT NULL,
  `ciudadSucursal` varchar(50) NOT NULL,
  `telefonoSucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `sucursales`
--

INSERT INTO `sucursales` (`idSucursal`, `numeroSucursal`, `direccionSucursal`, `ciudadSucursal`, `telefonoSucursal`) VALUES
(1, 3, 'Isabel la Católica 1632', 'Córdoba', NULL),
(2, 7, 'Av. Callao 2720', 'CABA', NULL),
(3, 0, 'A definir', 'Argentina', NULL),
(4, 11, 'Alem 238', 'Bahía Blanca', 22311167),
(5, 9, 'Rivadavia 320', 'Villa Carlos Paz', 99745211);

-- --------------------------------------------------------

--
-- Table structure for table `tipo-insumo`
--

CREATE TABLE `tipo-insumo` (
  `idTipoInsumo` int(11) NOT NULL,
  `tipoInsumo` varchar(50) NOT NULL,
  `nombreInsumo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `usuario` varchar(250) DEFAULT NULL,
  `contrasena` varchar(250) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES
(1, 'ADMINISTRADOR', 'ADMIN', 'ADMIN', 1),
(2, 'Nicolas Servidio', 'nservidio', '1234', 2),
(3, 'Facundo Mota', 'fmota', '1234', 3),
(4, 'Bruno Carossi', 'bcarossi', '1234', 4),
(5, 'Luke Skywalker', 'luke-skywalker', '1234', 12),
(6, 'Master Yoda', 'elorejudo', '1234', 9),
(7, 'Obi-Wan Kenobi', 'generalkenobi', '1234', 10);

-- --------------------------------------------------------

--
-- Table structure for table `vehiculos`
--

CREATE TABLE `vehiculos` (
  `idVehiculo` int(11) NOT NULL,
  `matricula` varchar(7) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `fechaCompra` date DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  `numeroMotor` int(11) DEFAULT NULL,
  `numeroChasis` int(11) DEFAULT NULL,
  `puertas` int(11) DEFAULT NULL,
  `asientos` int(11) DEFAULT NULL,
  `esAutomatico` char(1) DEFAULT NULL,
  `aireAcondicionado` char(1) DEFAULT NULL,
  `dirHidraulica` char(1) DEFAULT NULL,
  `estadoFisicoDelVehiculo` varchar(50) DEFAULT NULL,
  `disponibilidad` varchar(5) DEFAULT NULL,
  `kilometraje` int(11) DEFAULT NULL,
  `idModelo` int(11) DEFAULT NULL,
  `idCombustible` int(11) DEFAULT NULL,
  `idGrupoVehiculo` int(11) DEFAULT NULL,
  `idSucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehiculos`
--

INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `fechaCompra`, `anio`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `disponibilidad`, `kilometraje`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`) VALUES
(1, 'AB468FG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 6, 8, 13, 1),
(2, 'AA070DE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 1, 4, 12, 2),
(3, 'AC340FY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 2, 7, 12, 1),
(6, 'ADCS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 5, 3, 6, 5),
(7, 'HWUW9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 3, 4, 7, 2),
(18, 'HH667S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 7, 9, 4, 3),
(19, 'FFFDAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 3, 9, 7, 1),
(20, 'ASASA3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 10, 9, 1, 3),
(21, 'HABN32', NULL, '2024-10-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 8, 9, 2, 2),
(23, 'JHGP77F', NULL, '2024-10-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 8, 4, 10, 1),
(24, 'NE32SR', NULL, '2024-10-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 8, 9, 2, 2),
(25, 'XY909BM', NULL, '2024-10-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 5, 2, 1, 2),
(28, 'WYS88A', NULL, '2024-11-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 6, 9, 1, 1),
(30, 'XY33BM', NULL, '2024-11-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 4, 9, 3, 3),
(32, 'BLABLA9', NULL, '2024-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 1, 6, 12, 4),
(35, 'ROR99C', NULL, '2024-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 2, 3, 4, 4),
(36, 'RBA11R', NULL, '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 9, 7, 8, 5);

-- --------------------------------------------------------

--
-- Table structure for table `vendedores`
--

CREATE TABLE `vendedores` (
  `idVendedor` int(11) NOT NULL,
  `idEmpleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verificaciones-vehiculos`
--

CREATE TABLE `verificaciones-vehiculos` (
  `idVerificacion` int(11) NOT NULL,
  `nombreVerificacion` varchar(100) NOT NULL,
  `descripcionVerificacion` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional en caso de requerirse',
  `fechaVerificacion` date NOT NULL,
  `resultadoVerificacion` varchar(40) NOT NULL,
  `observacionesVerificacion` varchar(200) DEFAULT NULL COMMENT 'Observaciones sobre el proceso de verificación en caso de requerirse',
  `idVehiculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesorios-vehiculos`
--
ALTER TABLE `accesorios-vehiculos`
  ADD PRIMARY KEY (`idAccesorio`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idVehiculoHospedante` (`idVehiculoHospedante`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `combustibles`
--
ALTER TABLE `combustibles`
  ADD PRIMARY KEY (`idCombustible`);

--
-- Indexes for table `contratos-alquiler`
--
ALTER TABLE `contratos-alquiler`
  ADD PRIMARY KEY (`idContrato`),
  ADD KEY `contratosalquiler_ibfk_1` (`idCliente`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idVendedor` (`idVendedor`),
  ADD KEY `idDetalleContrato` (`idDetalleContrato`),
  ADD KEY `idEstadoContrato` (`idEstadoContrato`);

--
-- Indexes for table `cuentas-clientes`
--
ALTER TABLE `cuentas-clientes`
  ADD PRIMARY KEY (`idCuentaCliente`),
  ADD KEY `cliente` (`idCliente`),
  ADD KEY `estado cuenta` (`idEstadoCuentaCliente`);

--
-- Indexes for table `detalle-contratos`
--
ALTER TABLE `detalle-contratos`
  ADD PRIMARY KEY (`idDetalleContrato`),
  ADD KEY `idEntregaVehiculo` (`idEntregaVehiculo`),
  ADD KEY `idDevVehiculo` (`idDevVehiculo`);

--
-- Indexes for table `detalle-pedidoaproveedor`
--
ALTER TABLE `detalle-pedidoaproveedor`
  ADD PRIMARY KEY (`idDetallePedidoAProveedor`),
  ADD KEY `idRepuestoVehiculo` (`idRepuestoVehiculo`),
  ADD KEY `idProductoVehiculo` (`idProductoVehiculo`),
  ADD KEY `idAccesorioVehiculo` (`idAccesorioVehiculo`);

--
-- Indexes for table `devoluciones-vehiculos`
--
ALTER TABLE `devoluciones-vehiculos`
  ADD PRIMARY KEY (`idDevolucion`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idContrato` (`idContrato`),
  ADD KEY `idVendedorReceptor` (`idVendedorReceptor`),
  ADD KEY `idVerificacion` (`idVerificacion`);

--
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD KEY `idSucursal` (`idSucursal`);

--
-- Indexes for table `entregas-vehiculos`
--
ALTER TABLE `entregas-vehiculos`
  ADD PRIMARY KEY (`idEntrega`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idContrato` (`idContrato`);

--
-- Indexes for table `estados-contratos`
--
ALTER TABLE `estados-contratos`
  ADD PRIMARY KEY (`idEstadoContrato`);

--
-- Indexes for table `estados-cuentacliente`
--
ALTER TABLE `estados-cuentacliente`
  ADD PRIMARY KEY (`idEstadoCuenta`);

--
-- Indexes for table `estados-pedidoaproveedor`
--
ALTER TABLE `estados-pedidoaproveedor`
  ADD PRIMARY KEY (`idEstadoPedido`);

--
-- Indexes for table `feedbacks-clientes`
--
ALTER TABLE `feedbacks-clientes`
  ADD PRIMARY KEY (`idFeedbackCliente`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idCuentaCliente` (`idCuentaCliente`);

--
-- Indexes for table `grupos-vehiculos`
--
ALTER TABLE `grupos-vehiculos`
  ADD PRIMARY KEY (`idGrupo`);

--
-- Indexes for table `intereses-clientes`
--
ALTER TABLE `intereses-clientes`
  ADD PRIMARY KEY (`idInteresCliente`),
  ADD KEY `vehiculo` (`idVehiculo`),
  ADD KEY `cuenta del cliente` (`idCuentaCliente`);

--
-- Indexes for table `mantenimientos-vehiculos`
--
ALTER TABLE `mantenimientos-vehiculos`
  ADD PRIMARY KEY (`idMantenimiento`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idRepuestoUsado` (`idRepuestoUsado`),
  ADD KEY `idProductoUsado` (`idProductoUsado`);

--
-- Indexes for table `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`idModelo`);

--
-- Indexes for table `pedido-a-proveedor`
--
ALTER TABLE `pedido-a-proveedor`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idDetallePedido` (`idDetallePedido`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idEstadoPedido` (`idEstadoPedido`);

--
-- Indexes for table `preparaciones-vehiculos`
--
ALTER TABLE `preparaciones-vehiculos`
  ADD PRIMARY KEY (`idPreparacion`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idEmpleado` (`idEmpleado`),
  ADD KEY `idProductoUsado` (`idProductoUsado`);

--
-- Indexes for table `productos-vehiculo`
--
ALTER TABLE `productos-vehiculo`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idVehiculoDestinatario` (`idVehiculoDestinatario`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`);

--
-- Indexes for table `repuestos-vehiculos`
--
ALTER TABLE `repuestos-vehiculos`
  ADD PRIMARY KEY (`idRepuesto`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idVehiculoHospedante` (`idVehiculoHospedante`);

--
-- Indexes for table `reservas-vehiculos`
--
ALTER TABLE `reservas-vehiculos`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idContrato` (`idContrato`),
  ADD KEY `idSucursal` (`idSucursal`),
  ADD KEY `idVehiculo` (`idVehiculo`);

--
-- Indexes for table `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`idSucursal`);

--
-- Indexes for table `tipo-insumo`
--
ALTER TABLE `tipo-insumo`
  ADD PRIMARY KEY (`idTipoInsumo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cargo` (`id_cargo`),
  ADD KEY `id_cargo_2` (`id_cargo`);

--
-- Indexes for table `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`idVehiculo`),
  ADD KEY `modelo` (`idModelo`),
  ADD KEY `combustible` (`idCombustible`),
  ADD KEY `grupo` (`idGrupoVehiculo`),
  ADD KEY `sucursal` (`idSucursal`);

--
-- Indexes for table `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`idVendedor`),
  ADD KEY `idEmpleado` (`idEmpleado`);

--
-- Indexes for table `verificaciones-vehiculos`
--
ALTER TABLE `verificaciones-vehiculos`
  ADD PRIMARY KEY (`idVerificacion`),
  ADD KEY `idVehiculo` (`idVehiculo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesorios-vehiculos`
--
ALTER TABLE `accesorios-vehiculos`
  MODIFY `idAccesorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `combustibles`
--
ALTER TABLE `combustibles`
  MODIFY `idCombustible` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contratos-alquiler`
--
ALTER TABLE `contratos-alquiler`
  MODIFY `idContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `cuentas-clientes`
--
ALTER TABLE `cuentas-clientes`
  MODIFY `idCuentaCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detalle-contratos`
--
ALTER TABLE `detalle-contratos`
  MODIFY `idDetalleContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `detalle-pedidoaproveedor`
--
ALTER TABLE `detalle-pedidoaproveedor`
  MODIFY `idDetallePedidoAProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devoluciones-vehiculos`
--
ALTER TABLE `devoluciones-vehiculos`
  MODIFY `idDevolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entregas-vehiculos`
--
ALTER TABLE `entregas-vehiculos`
  MODIFY `idEntrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `estados-contratos`
--
ALTER TABLE `estados-contratos`
  MODIFY `idEstadoContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `estados-cuentacliente`
--
ALTER TABLE `estados-cuentacliente`
  MODIFY `idEstadoCuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `estados-pedidoaproveedor`
--
ALTER TABLE `estados-pedidoaproveedor`
  MODIFY `idEstadoPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedbacks-clientes`
--
ALTER TABLE `feedbacks-clientes`
  MODIFY `idFeedbackCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grupos-vehiculos`
--
ALTER TABLE `grupos-vehiculos`
  MODIFY `idGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `intereses-clientes`
--
ALTER TABLE `intereses-clientes`
  MODIFY `idInteresCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mantenimientos-vehiculos`
--
ALTER TABLE `mantenimientos-vehiculos`
  MODIFY `idMantenimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modelos`
--
ALTER TABLE `modelos`
  MODIFY `idModelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pedido-a-proveedor`
--
ALTER TABLE `pedido-a-proveedor`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preparaciones-vehiculos`
--
ALTER TABLE `preparaciones-vehiculos`
  MODIFY `idPreparacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos-vehiculo`
--
ALTER TABLE `productos-vehiculo`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repuestos-vehiculos`
--
ALTER TABLE `repuestos-vehiculos`
  MODIFY `idRepuesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservas-vehiculos`
--
ALTER TABLE `reservas-vehiculos`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `idSucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tipo-insumo`
--
ALTER TABLE `tipo-insumo`
  MODIFY `idTipoInsumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `idVehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `idVendedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verificaciones-vehiculos`
--
ALTER TABLE `verificaciones-vehiculos`
  MODIFY `idVerificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accesorios-vehiculos`
--
ALTER TABLE `accesorios-vehiculos`
  ADD CONSTRAINT `accesorios-vehiculos_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accesorios-vehiculos_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accesorios-vehiculos_ibfk_3` FOREIGN KEY (`idVehiculoHospedante`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `contratos-alquiler`
--
ALTER TABLE `contratos-alquiler`
  ADD CONSTRAINT `contratos-alquiler_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_2` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_3` FOREIGN KEY (`idVendedor`) REFERENCES `vendedores` (`idVendedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_4` FOREIGN KEY (`idDetalleContrato`) REFERENCES `detalle-contratos` (`idDetalleContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_5` FOREIGN KEY (`idEstadoContrato`) REFERENCES `estados-contratos` (`idEstadoContrato`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `cuentas-clientes`
--
ALTER TABLE `cuentas-clientes`
  ADD CONSTRAINT `cliente` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `estado cuenta` FOREIGN KEY (`idEstadoCuentaCliente`) REFERENCES `estados-cuentacliente` (`idEstadoCuenta`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `detalle-contratos`
--
ALTER TABLE `detalle-contratos`
  ADD CONSTRAINT `detalle-contratos_ibfk_1` FOREIGN KEY (`idEntregaVehiculo`) REFERENCES `entregas-vehiculos` (`idEntrega`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detalle-contratos_ibfk_2` FOREIGN KEY (`idDevVehiculo`) REFERENCES `devoluciones-vehiculos` (`idDevolucion`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `detalle-pedidoaproveedor`
--
ALTER TABLE `detalle-pedidoaproveedor`
  ADD CONSTRAINT `detalle-pedidoaproveedor_ibfk_1` FOREIGN KEY (`idRepuestoVehiculo`) REFERENCES `repuestos-vehiculos` (`idRepuesto`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detalle-pedidoaproveedor_ibfk_2` FOREIGN KEY (`idProductoVehiculo`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detalle-pedidoaproveedor_ibfk_3` FOREIGN KEY (`idAccesorioVehiculo`) REFERENCES `accesorios-vehiculos` (`idAccesorio`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `devoluciones-vehiculos`
--
ALTER TABLE `devoluciones-vehiculos`
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_3` FOREIGN KEY (`idVendedorReceptor`) REFERENCES `vendedores` (`idVendedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_4` FOREIGN KEY (`idVerificacion`) REFERENCES `verificaciones-vehiculos` (`idVerificacion`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `entregas-vehiculos`
--
ALTER TABLE `entregas-vehiculos`
  ADD CONSTRAINT `entregas-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `entregas-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `feedbacks-clientes`
--
ALTER TABLE `feedbacks-clientes`
  ADD CONSTRAINT `feedbacks-clientes_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `feedbacks-clientes_ibfk_2` FOREIGN KEY (`idCuentaCliente`) REFERENCES `cuentas-clientes` (`idCuentaCliente`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `intereses-clientes`
--
ALTER TABLE `intereses-clientes`
  ADD CONSTRAINT `cuenta del cliente` FOREIGN KEY (`idCuentaCliente`) REFERENCES `cuentas-clientes` (`idCuentaCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `vehiculo` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `mantenimientos-vehiculos`
--
ALTER TABLE `mantenimientos-vehiculos`
  ADD CONSTRAINT `mantenimientos-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `mantenimientos-vehiculos_ibfk_2` FOREIGN KEY (`idRepuestoUsado`) REFERENCES `repuestos-vehiculos` (`idRepuesto`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `mantenimientos-vehiculos_ibfk_3` FOREIGN KEY (`idProductoUsado`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pedido-a-proveedor`
--
ALTER TABLE `pedido-a-proveedor`
  ADD CONSTRAINT `pedido-a-proveedor_ibfk_1` FOREIGN KEY (`idDetallePedido`) REFERENCES `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pedido-a-proveedor_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pedido-a-proveedor_ibfk_3` FOREIGN KEY (`idEstadoPedido`) REFERENCES `estados-pedidoaproveedor` (`idEstadoPedido`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `preparaciones-vehiculos`
--
ALTER TABLE `preparaciones-vehiculos`
  ADD CONSTRAINT `preparaciones-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `preparaciones-vehiculos_ibfk_2` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `preparaciones-vehiculos_ibfk_3` FOREIGN KEY (`idProductoUsado`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `productos-vehiculo`
--
ALTER TABLE `productos-vehiculo`
  ADD CONSTRAINT `productos-vehiculo_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `productos-vehiculo_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `productos-vehiculo_ibfk_3` FOREIGN KEY (`idVehiculoDestinatario`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `repuestos-vehiculos`
--
ALTER TABLE `repuestos-vehiculos`
  ADD CONSTRAINT `repuestos-vehiculos_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `repuestos-vehiculos_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `repuestos-vehiculos_ibfk_3` FOREIGN KEY (`idVehiculoHospedante`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `reservas-vehiculos`
--
ALTER TABLE `reservas-vehiculos`
  ADD CONSTRAINT `reservas-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `reservas-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `reservas-vehiculos_ibfk_3` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `reservas-vehiculos_ibfk_4` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `combustible` FOREIGN KEY (`idCombustible`) REFERENCES `combustibles` (`idCombustible`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `grupo` FOREIGN KEY (`idGrupoVehiculo`) REFERENCES `grupos-vehiculos` (`idGrupo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `modelo` FOREIGN KEY (`idModelo`) REFERENCES `modelos` (`idModelo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `sucursal` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `vendedores`
--
ALTER TABLE `vendedores`
  ADD CONSTRAINT `vendedores_ibfk_1` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `verificaciones-vehiculos`
--
ALTER TABLE `verificaciones-vehiculos`
  ADD CONSTRAINT `verificaciones-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
