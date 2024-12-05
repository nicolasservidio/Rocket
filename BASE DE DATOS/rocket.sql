-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2024 a las 00:57:40
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rocket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorios-vehiculos`
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
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cargo`
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
-- Estructura de tabla para la tabla `clientes`
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
-- Volcado de datos para la tabla `clientes`
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
-- Estructura de tabla para la tabla `combustibles`
--

CREATE TABLE `combustibles` (
  `idCombustible` int(11) NOT NULL,
  `tipoCombustible` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `combustibles`
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
-- Estructura de tabla para la tabla `contratos-alquiler`
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
-- Volcado de datos para la tabla `contratos-alquiler`
--

INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES
(1, '2024-12-01', '2024-12-03', NULL, NULL, 12, 20, NULL, 1, 1),
(2, '2024-12-02', '2024-12-06', NULL, NULL, 9, 24, NULL, 2, 1),
(3, '2024-12-08', '2024-12-10', NULL, NULL, 15, 21, NULL, 3, 1),
(4, '2024-12-06', '2024-12-09', NULL, NULL, 6, 2, NULL, 4, 1),
(5, '2024-12-08', '2024-12-10', NULL, NULL, 7, 19, NULL, 5, 1),
(7, '2024-12-09', '2024-12-14', NULL, NULL, 11, 6, NULL, 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas-clientes`
--

CREATE TABLE `cuentas-clientes` (
  `idCuentaCliente` int(11) NOT NULL,
  `nombreUsuarioCliente` varchar(20) NOT NULL,
  `passwordCliente` varchar(50) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idEstadoCuentaCliente` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cuentas-clientes`
--

INSERT INTO `cuentas-clientes` (`idCuentaCliente`, `nombreUsuarioCliente`, `passwordCliente`, `idCliente`, `idEstadoCuentaCliente`) VALUES
(1, 'brunancio', '123', 1, 2),
(2, 'nicosio', '123', 12, 1),
(3, 'facunyo', '123', 3, 1),
(4, 'nosoyunbot', '123', 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle-contratos`
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
-- Volcado de datos para la tabla `detalle-contratos`
--

INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES
(1, 50, 3, 150, NULL, NULL, NULL, NULL),
(2, 55.25, 4, 221, NULL, NULL, NULL, NULL),
(3, 150.5, 2, 301, NULL, NULL, NULL, NULL),
(4, 40.2, 3, 120.6, NULL, NULL, NULL, NULL),
(5, 33.6, 2, 67.2, NULL, NULL, NULL, NULL),
(7, 60, 5, 300, NULL, 'El estado ha sido modificado', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle-pedidoaproveedor`
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
-- Estructura de tabla para la tabla `devoluciones-vehiculos`
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
  `idVendedorReceptor` int(11) DEFAULT NULL COMMENT 'Vendedor que recibe el vehículo al ser devuelto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
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
-- Estructura de tabla para la tabla `entregas-vehiculos`
--

CREATE TABLE `entregas-vehiculos` (
  `idEntrega` int(11) NOT NULL,
  `fechaEntrega` date NOT NULL,
  `horaEntrega` varchar(5) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idContrato` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados-contratos`
--

CREATE TABLE `estados-contratos` (
  `idEstadoContrato` int(11) NOT NULL,
  `estadoContrato` varchar(50) NOT NULL,
  `descripcionEstadoContrato` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del estado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estados-contratos`
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
-- Estructura de tabla para la tabla `estados-cuentacliente`
--

CREATE TABLE `estados-cuentacliente` (
  `idEstadoCuenta` int(11) NOT NULL,
  `Denominacion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estados-cuentacliente`
--

INSERT INTO `estados-cuentacliente` (`idEstadoCuenta`, `Denominacion`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados-pedidoaproveedor`
--

CREATE TABLE `estados-pedidoaproveedor` (
  `idEstadoPedido` int(11) NOT NULL,
  `estadoPedido` varchar(50) NOT NULL,
  `descripcionEstadoPedido` varchar(200) DEFAULT NULL COMMENT 'Descripción optativa del estado.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estados-pedidoaproveedor`
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
-- Estructura de tabla para la tabla `feedbacks-clientes`
--

CREATE TABLE `feedbacks-clientes` (
  `idFeedbackCliente` int(11) NOT NULL,
  `descripcionFeedback` varchar(200) NOT NULL,
  `puntuacionFeedback` int(1) NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idCuentaCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `feedbacks-clientes`
--

INSERT INTO `feedbacks-clientes` (`idFeedbackCliente`, `descripcionFeedback`, `puntuacionFeedback`, `idVehiculo`, `idCuentaCliente`) VALUES
(1, 'Gran experiencia. Los frenos están un poco quemados', 4, 1, 1),
(2, 'La verdad que podría mejorar', 2, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos-vehiculos`
--

CREATE TABLE `grupos-vehiculos` (
  `idGrupo` int(11) NOT NULL,
  `nombreGrupo` varchar(40) NOT NULL,
  `descripcionGrupo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupos-vehiculos`
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
-- Estructura de tabla para la tabla `intereses-clientes`
--

CREATE TABLE `intereses-clientes` (
  `idInteresCliente` int(11) NOT NULL,
  `motivoDeInteres` varchar(100) NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idCuentaCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `intereses-clientes`
--

INSERT INTO `intereses-clientes` (`idInteresCliente`, `motivoDeInteres`, `idVehiculo`, `idCuentaCliente`) VALUES
(1, 'lindo auto para alquilar cuando tenga $!', 1, 4),
(2, 'Alcanza 230kmh en ruta!', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos-vehiculos`
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
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `idModelo` int(11) NOT NULL,
  `nombreModelo` varchar(20) NOT NULL,
  `descripcionModelo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modelos`
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
-- Estructura de tabla para la tabla `pedido-a-proveedor`
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
-- Estructura de tabla para la tabla `preparaciones-vehiculos`
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
-- Estructura de tabla para la tabla `productos-vehiculo`
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
-- Estructura de tabla para la tabla `proveedores`
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
-- Estructura de tabla para la tabla `repuestos-vehiculos`
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
-- Estructura de tabla para la tabla `reservas-vehiculos`
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
-- Volcado de datos para la tabla `reservas-vehiculos`
--

INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`) VALUES
(1, 12, '2024-11-01', '2024-11-02', '2024-11-05', 30, 3, 90, 8, NULL, 1, 18),
(2, 5, '2024-11-01', '2024-11-05', '2024-11-07', 35, 2, 70, 15, NULL, 1, 20),
(3, 8, '2024-11-01', '2024-11-04', '2024-11-08', 50, 4, 200, 4, NULL, 2, NULL),
(5, 9, '2024-11-01', '2024-11-13', '2024-11-20', 0, 0, 0, 12, NULL, NULL, 1),
(6, 10, '2024-11-01', '2024-11-07', '2024-11-10', 0, 0, 0, 11, NULL, NULL, 3),
(7, 15, '2024-11-29', '2024-11-20', '2024-11-23', 0, 0, 0, 6, NULL, NULL, 24),
(8, 1, '2024-11-01', '2024-11-12', '2024-11-15', 0, 0, 0, 10, NULL, NULL, 3),
(9, 3, '2024-11-01', '2024-11-15', '2024-11-18', 0, 0, 0, 11, NULL, NULL, 2),
(10, 2, '2024-11-01', '2024-11-22', '2024-11-25', 0, 0, 0, 1, NULL, NULL, 2),
(14, 22, '2024-11-30', '2024-12-03', '2024-12-05', 0, 0, 0, 4, NULL, NULL, 2),
(17, 4, '2024-12-04', '2024-12-17', '2024-12-23', 0, 0, 0, 7, NULL, NULL, 19),
(18, 21, '2024-12-04', '2024-12-25', '2024-12-27', 0, 0, 0, 9, NULL, NULL, 2),
(19, 20, '2024-12-04', '2024-12-10', '2024-12-11', 0, 0, 0, 17, NULL, NULL, 7),
(20, 11, '2024-12-04', '2024-12-06', '2024-12-07', 0, 0, 0, 5, NULL, NULL, 23),
(21, 6, '2024-12-04', '2024-12-05', '2024-12-08', 0, 0, 0, 11, NULL, NULL, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `idSucursal` int(11) NOT NULL,
  `numeroSucursal` int(11) NOT NULL,
  `direccionSucursal` varchar(50) NOT NULL,
  `ciudadSucursal` varchar(50) NOT NULL,
  `telefonoSucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`idSucursal`, `numeroSucursal`, `direccionSucursal`, `ciudadSucursal`, `telefonoSucursal`) VALUES
(1, 3, 'Isabel la Católica 1632', 'Córdoba', NULL),
(2, 7, 'Av. Callao 2720', 'CABA', NULL),
(3, 0, 'A definir', 'Argentina', NULL),
(4, 11, 'Alem 238', 'Bahía Blanca', 22311167),
(5, 9, 'Rivadavia 320', 'Villa Carlos Paz', 99745211);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo-insumo`
--

CREATE TABLE `tipo-insumo` (
  `idTipoInsumo` int(11) NOT NULL,
  `tipoInsumo` varchar(50) NOT NULL,
  `nombreInsumo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `usuario` varchar(250) DEFAULT NULL,
  `contrasena` varchar(250) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES
(1, 'ADMINISTRADOR', 'ADMIN', 'ADMIN', 1),
(2, 'Nicolas Servidio', 'nservidio', '1234', 2),
(3, 'Facundo Mota', 'fmota', '1234', 3),
(4, 'Bruno Carossi', 'bcarossi', '1234', 4),
(5, 'Luke Skywalker', 'luke-skywalker', '1234', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
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
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `fechaCompra`, `anio`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `disponibilidad`, `kilometraje`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`) VALUES
(1, 'AB468FG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 6, 8, 13, 1),
(2, 'AA070DE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 1, 4, 12, 2),
(3, 'AC340FY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 2, 7, 12, 1),
(6, 'ADCS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 5, 3, 6, 2),
(7, 'HWUW9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 3, 4, 7, 2),
(18, 'HH667S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 7, 9, 4, 3),
(19, 'FFFDAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 3, 9, 7, 4),
(20, 'ASASA3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 10, 9, 1, 3),
(21, 'HABN32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, 8, 9, 2, 2),
(23, 'JHGP77F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 8, 4, 10, 1),
(24, 'NE32SR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 8, 9, 2, 1),
(25, 'XY909BM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 5, 3, 1, 2),
(28, 'WYS88A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 6, 9, 1, 3),
(30, 'XY33BM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, 4, 9, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `idVendedor` int(11) NOT NULL,
  `idEmpleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verificaciones-vehiculos`
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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorios-vehiculos`
--
ALTER TABLE `accesorios-vehiculos`
  ADD PRIMARY KEY (`idAccesorio`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idVehiculoHospedante` (`idVehiculoHospedante`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `combustibles`
--
ALTER TABLE `combustibles`
  ADD PRIMARY KEY (`idCombustible`);

--
-- Indices de la tabla `contratos-alquiler`
--
ALTER TABLE `contratos-alquiler`
  ADD PRIMARY KEY (`idContrato`),
  ADD KEY `contratosalquiler_ibfk_1` (`idCliente`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idVendedor` (`idVendedor`),
  ADD KEY `idDetalleContrato` (`idDetalleContrato`),
  ADD KEY `idEstadoContrato` (`idEstadoContrato`);

--
-- Indices de la tabla `cuentas-clientes`
--
ALTER TABLE `cuentas-clientes`
  ADD PRIMARY KEY (`idCuentaCliente`),
  ADD KEY `cliente` (`idCliente`),
  ADD KEY `estado cuenta` (`idEstadoCuentaCliente`);

--
-- Indices de la tabla `detalle-contratos`
--
ALTER TABLE `detalle-contratos`
  ADD PRIMARY KEY (`idDetalleContrato`),
  ADD KEY `idEntregaVehiculo` (`idEntregaVehiculo`),
  ADD KEY `idDevVehiculo` (`idDevVehiculo`);

--
-- Indices de la tabla `detalle-pedidoaproveedor`
--
ALTER TABLE `detalle-pedidoaproveedor`
  ADD PRIMARY KEY (`idDetallePedidoAProveedor`),
  ADD KEY `idRepuestoVehiculo` (`idRepuestoVehiculo`),
  ADD KEY `idProductoVehiculo` (`idProductoVehiculo`),
  ADD KEY `idAccesorioVehiculo` (`idAccesorioVehiculo`);

--
-- Indices de la tabla `devoluciones-vehiculos`
--
ALTER TABLE `devoluciones-vehiculos`
  ADD PRIMARY KEY (`idDevolucion`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idContrato` (`idContrato`),
  ADD KEY `idVendedorReceptor` (`idVendedorReceptor`),
  ADD KEY `idVerificacion` (`idVerificacion`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD KEY `idSucursal` (`idSucursal`);

--
-- Indices de la tabla `entregas-vehiculos`
--
ALTER TABLE `entregas-vehiculos`
  ADD PRIMARY KEY (`idEntrega`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idContrato` (`idContrato`);

--
-- Indices de la tabla `estados-contratos`
--
ALTER TABLE `estados-contratos`
  ADD PRIMARY KEY (`idEstadoContrato`);

--
-- Indices de la tabla `estados-cuentacliente`
--
ALTER TABLE `estados-cuentacliente`
  ADD PRIMARY KEY (`idEstadoCuenta`);

--
-- Indices de la tabla `estados-pedidoaproveedor`
--
ALTER TABLE `estados-pedidoaproveedor`
  ADD PRIMARY KEY (`idEstadoPedido`);

--
-- Indices de la tabla `feedbacks-clientes`
--
ALTER TABLE `feedbacks-clientes`
  ADD PRIMARY KEY (`idFeedbackCliente`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idCuentaCliente` (`idCuentaCliente`);

--
-- Indices de la tabla `grupos-vehiculos`
--
ALTER TABLE `grupos-vehiculos`
  ADD PRIMARY KEY (`idGrupo`);

--
-- Indices de la tabla `intereses-clientes`
--
ALTER TABLE `intereses-clientes`
  ADD PRIMARY KEY (`idInteresCliente`),
  ADD KEY `vehiculo` (`idVehiculo`),
  ADD KEY `cuenta del cliente` (`idCuentaCliente`);

--
-- Indices de la tabla `mantenimientos-vehiculos`
--
ALTER TABLE `mantenimientos-vehiculos`
  ADD PRIMARY KEY (`idMantenimiento`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idRepuestoUsado` (`idRepuestoUsado`),
  ADD KEY `idProductoUsado` (`idProductoUsado`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`idModelo`);

--
-- Indices de la tabla `pedido-a-proveedor`
--
ALTER TABLE `pedido-a-proveedor`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idDetallePedido` (`idDetallePedido`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idEstadoPedido` (`idEstadoPedido`);

--
-- Indices de la tabla `preparaciones-vehiculos`
--
ALTER TABLE `preparaciones-vehiculos`
  ADD PRIMARY KEY (`idPreparacion`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idEmpleado` (`idEmpleado`),
  ADD KEY `idProductoUsado` (`idProductoUsado`);

--
-- Indices de la tabla `productos-vehiculo`
--
ALTER TABLE `productos-vehiculo`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idVehiculoDestinatario` (`idVehiculoDestinatario`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`);

--
-- Indices de la tabla `repuestos-vehiculos`
--
ALTER TABLE `repuestos-vehiculos`
  ADD PRIMARY KEY (`idRepuesto`),
  ADD KEY `idTipoInsumo` (`idTipoInsumo`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idVehiculoHospedante` (`idVehiculoHospedante`);

--
-- Indices de la tabla `reservas-vehiculos`
--
ALTER TABLE `reservas-vehiculos`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idContrato` (`idContrato`),
  ADD KEY `idSucursal` (`idSucursal`),
  ADD KEY `idVehiculo` (`idVehiculo`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`idSucursal`);

--
-- Indices de la tabla `tipo-insumo`
--
ALTER TABLE `tipo-insumo`
  ADD PRIMARY KEY (`idTipoInsumo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cargo` (`id_cargo`),
  ADD KEY `id_cargo_2` (`id_cargo`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`idVehiculo`),
  ADD KEY `modelo` (`idModelo`),
  ADD KEY `combustible` (`idCombustible`),
  ADD KEY `grupo` (`idGrupoVehiculo`),
  ADD KEY `sucursal` (`idSucursal`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`idVendedor`),
  ADD KEY `idEmpleado` (`idEmpleado`);

--
-- Indices de la tabla `verificaciones-vehiculos`
--
ALTER TABLE `verificaciones-vehiculos`
  ADD PRIMARY KEY (`idVerificacion`),
  ADD KEY `idVehiculo` (`idVehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorios-vehiculos`
--
ALTER TABLE `accesorios-vehiculos`
  MODIFY `idAccesorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `combustibles`
--
ALTER TABLE `combustibles`
  MODIFY `idCombustible` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `contratos-alquiler`
--
ALTER TABLE `contratos-alquiler`
  MODIFY `idContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cuentas-clientes`
--
ALTER TABLE `cuentas-clientes`
  MODIFY `idCuentaCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle-contratos`
--
ALTER TABLE `detalle-contratos`
  MODIFY `idDetalleContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle-pedidoaproveedor`
--
ALTER TABLE `detalle-pedidoaproveedor`
  MODIFY `idDetallePedidoAProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devoluciones-vehiculos`
--
ALTER TABLE `devoluciones-vehiculos`
  MODIFY `idDevolucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entregas-vehiculos`
--
ALTER TABLE `entregas-vehiculos`
  MODIFY `idEntrega` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados-contratos`
--
ALTER TABLE `estados-contratos`
  MODIFY `idEstadoContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estados-cuentacliente`
--
ALTER TABLE `estados-cuentacliente`
  MODIFY `idEstadoCuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados-pedidoaproveedor`
--
ALTER TABLE `estados-pedidoaproveedor`
  MODIFY `idEstadoPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `feedbacks-clientes`
--
ALTER TABLE `feedbacks-clientes`
  MODIFY `idFeedbackCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `grupos-vehiculos`
--
ALTER TABLE `grupos-vehiculos`
  MODIFY `idGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `intereses-clientes`
--
ALTER TABLE `intereses-clientes`
  MODIFY `idInteresCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mantenimientos-vehiculos`
--
ALTER TABLE `mantenimientos-vehiculos`
  MODIFY `idMantenimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `idModelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedido-a-proveedor`
--
ALTER TABLE `pedido-a-proveedor`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preparaciones-vehiculos`
--
ALTER TABLE `preparaciones-vehiculos`
  MODIFY `idPreparacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos-vehiculo`
--
ALTER TABLE `productos-vehiculo`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `repuestos-vehiculos`
--
ALTER TABLE `repuestos-vehiculos`
  MODIFY `idRepuesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas-vehiculos`
--
ALTER TABLE `reservas-vehiculos`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `idSucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo-insumo`
--
ALTER TABLE `tipo-insumo`
  MODIFY `idTipoInsumo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `idVehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `idVendedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `verificaciones-vehiculos`
--
ALTER TABLE `verificaciones-vehiculos`
  MODIFY `idVerificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesorios-vehiculos`
--
ALTER TABLE `accesorios-vehiculos`
  ADD CONSTRAINT `accesorios-vehiculos_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accesorios-vehiculos_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `accesorios-vehiculos_ibfk_3` FOREIGN KEY (`idVehiculoHospedante`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `contratos-alquiler`
--
ALTER TABLE `contratos-alquiler`
  ADD CONSTRAINT `contratos-alquiler_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_2` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_3` FOREIGN KEY (`idVendedor`) REFERENCES `vendedores` (`idVendedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_4` FOREIGN KEY (`idDetalleContrato`) REFERENCES `detalle-contratos` (`idDetalleContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `contratos-alquiler_ibfk_5` FOREIGN KEY (`idEstadoContrato`) REFERENCES `estados-contratos` (`idEstadoContrato`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `cuentas-clientes`
--
ALTER TABLE `cuentas-clientes`
  ADD CONSTRAINT `cliente` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `estado cuenta` FOREIGN KEY (`idEstadoCuentaCliente`) REFERENCES `estados-cuentacliente` (`idEstadoCuenta`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `detalle-contratos`
--
ALTER TABLE `detalle-contratos`
  ADD CONSTRAINT `detalle-contratos_ibfk_1` FOREIGN KEY (`idEntregaVehiculo`) REFERENCES `entregas-vehiculos` (`idEntrega`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detalle-contratos_ibfk_2` FOREIGN KEY (`idDevVehiculo`) REFERENCES `devoluciones-vehiculos` (`idDevolucion`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `detalle-pedidoaproveedor`
--
ALTER TABLE `detalle-pedidoaproveedor`
  ADD CONSTRAINT `detalle-pedidoaproveedor_ibfk_1` FOREIGN KEY (`idRepuestoVehiculo`) REFERENCES `repuestos-vehiculos` (`idRepuesto`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detalle-pedidoaproveedor_ibfk_2` FOREIGN KEY (`idProductoVehiculo`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `detalle-pedidoaproveedor_ibfk_3` FOREIGN KEY (`idAccesorioVehiculo`) REFERENCES `accesorios-vehiculos` (`idAccesorio`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `devoluciones-vehiculos`
--
ALTER TABLE `devoluciones-vehiculos`
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_3` FOREIGN KEY (`idVendedorReceptor`) REFERENCES `vendedores` (`idVendedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `devoluciones-vehiculos_ibfk_4` FOREIGN KEY (`idVerificacion`) REFERENCES `verificaciones-vehiculos` (`idVerificacion`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `entregas-vehiculos`
--
ALTER TABLE `entregas-vehiculos`
  ADD CONSTRAINT `entregas-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `entregas-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `feedbacks-clientes`
--
ALTER TABLE `feedbacks-clientes`
  ADD CONSTRAINT `feedbacks-clientes_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `feedbacks-clientes_ibfk_2` FOREIGN KEY (`idCuentaCliente`) REFERENCES `cuentas-clientes` (`idCuentaCliente`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `intereses-clientes`
--
ALTER TABLE `intereses-clientes`
  ADD CONSTRAINT `cuenta del cliente` FOREIGN KEY (`idCuentaCliente`) REFERENCES `cuentas-clientes` (`idCuentaCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `vehiculo` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `mantenimientos-vehiculos`
--
ALTER TABLE `mantenimientos-vehiculos`
  ADD CONSTRAINT `mantenimientos-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `mantenimientos-vehiculos_ibfk_2` FOREIGN KEY (`idRepuestoUsado`) REFERENCES `repuestos-vehiculos` (`idRepuesto`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `mantenimientos-vehiculos_ibfk_3` FOREIGN KEY (`idProductoUsado`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `pedido-a-proveedor`
--
ALTER TABLE `pedido-a-proveedor`
  ADD CONSTRAINT `pedido-a-proveedor_ibfk_1` FOREIGN KEY (`idDetallePedido`) REFERENCES `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pedido-a-proveedor_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pedido-a-proveedor_ibfk_3` FOREIGN KEY (`idEstadoPedido`) REFERENCES `estados-pedidoaproveedor` (`idEstadoPedido`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `preparaciones-vehiculos`
--
ALTER TABLE `preparaciones-vehiculos`
  ADD CONSTRAINT `preparaciones-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `preparaciones-vehiculos_ibfk_2` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `preparaciones-vehiculos_ibfk_3` FOREIGN KEY (`idProductoUsado`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `productos-vehiculo`
--
ALTER TABLE `productos-vehiculo`
  ADD CONSTRAINT `productos-vehiculo_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `productos-vehiculo_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `productos-vehiculo_ibfk_3` FOREIGN KEY (`idVehiculoDestinatario`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `repuestos-vehiculos`
--
ALTER TABLE `repuestos-vehiculos`
  ADD CONSTRAINT `repuestos-vehiculos_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `repuestos-vehiculos_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `repuestos-vehiculos_ibfk_3` FOREIGN KEY (`idVehiculoHospedante`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `reservas-vehiculos`
--
ALTER TABLE `reservas-vehiculos`
  ADD CONSTRAINT `reservas-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `reservas-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `reservas-vehiculos_ibfk_3` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `reservas-vehiculos_ibfk_4` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `combustible` FOREIGN KEY (`idCombustible`) REFERENCES `combustibles` (`idCombustible`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `grupo` FOREIGN KEY (`idGrupoVehiculo`) REFERENCES `grupos-vehiculos` (`idGrupo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `modelo` FOREIGN KEY (`idModelo`) REFERENCES `modelos` (`idModelo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `sucursal` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD CONSTRAINT `vendedores_ibfk_1` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `verificaciones-vehiculos`
--
ALTER TABLE `verificaciones-vehiculos`
  ADD CONSTRAINT `verificaciones-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
