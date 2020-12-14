-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-12-2020 a las 20:29:57
-- Versión del servidor: 8.0.13-4
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupo17`
--
CREATE DATABASE IF NOT EXISTS `grupo17` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `grupo17`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Area`
--

CREATE TABLE `Area` (
  `codigo` int(2) NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Area`
--

INSERT INTO `Area` (`codigo`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Encargado de taller'),
(4, 'Chofer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Arrastre`
--

CREATE TABLE `Arrastre` (
  `patente` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chasis` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `codigo_tipoArrastre` int(11) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1 - Disponible | 2 - En viaje | 3 - Fuera de servicio '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Arrastre`
--

INSERT INTO `Arrastre` (`patente`, `chasis`, `codigo_tipoArrastre`, `estado`) VALUES
('AA189AD', '775168', 1, 2),
('AA274AG', '498515', 1, 1),
('AA362AS', '831768', 2, 1),
('AA415TV', '12345678', 4, 1),
('AA449AD', '884654', 3, 1),
('AA537AG', '752105', 3, 1),
('AA624AS', '852157', 4, 1),
('AA712AD', '468708', 4, 1),
('AA800AG', '820810', 4, 1),
('AA887AS', '777450', 1, 2),
('AB135AG', '705687', 1, 1),
('AB230AS', '678666', 1, 1),
('AB318AD', '595287', 2, 1),
('AB405AG', '583419', 3, 2),
('AB493AS', '595948', 3, 1),
('AB581AD', '761560', 4, 1),
('AB668AG', '815072', 4, 1),
('AB756AS', '616372', 4, 1),
('AB843AD', '670323', 1, 1),
('AB931AG', '806730', 1, 1),
('AC125AD', '605737', 1, 1),
('AC208AG', '642287', 1, 2),
('AC296AS', '882174', 2, 1),
('AC383AD', '535330', 2, 1),
('AC471AG', '510019', 3, 1),
('AC559AS', '554550', 3, 1),
('AC646AD', '710797', 4, 1),
('AC734AG', '661897', 4, 1),
('AC821AS', '731202', 1, 1),
('AC909AD', '485098', 1, 1),
('AD100AQ', '730502', 5, 1),
('AD100AZ', '730027', 5, 1),
('AD145XA', '585822', 1, 1),
('AD14XAW', '775161', 1, 2),
('AD166AS', '815082', 1, 1),
('AD252AD', '758967', 1, 2),
('AD340AG', '549916', 2, 1),
('AD427AS', '703673', 3, 1),
('AD515AD', '704640', 3, 1),
('AD602AG', '555608', 4, 1),
('AD690AS', '495851', 4, 1),
('AD778AD', '873758', 4, 1),
('AD865AG', '747642', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Celulares`
--

CREATE TABLE `Celulares` (
  `id` int(10) NOT NULL,
  `numero` bigint(10) NOT NULL,
  `compañia` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(10) NOT NULL DEFAULT '1' COMMENT ' 1 -disponible | 2 -No disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Celulares`
--

INSERT INTO `Celulares` (`id`, `numero`, `compañia`, `estado`) VALUES
(1, 1522334455, 'Claro', 2),
(2, 1524334444, 'Movistar', 2),
(4, 1521335566, 'Claro', 2),
(5, 1544666666, 'Movistar', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Chofer`
--

CREATE TABLE `Chofer` (
  `dni_chofer` int(8) NOT NULL,
  `tipo_licencia` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `vehiculo_asignado` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_celular` int(10) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT ' 1 - Finalizado | 2 - En viaje | 3 - Fuera de servicio|'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Chofer`
--

INSERT INTO `Chofer` (`dni_chofer`, `tipo_licencia`, `vehiculo_asignado`, `id_celular`, `estado`) VALUES
(14521474, 'B1', 'AA150QW', 5, 2),
(32514124, 'C1', 'AC989QW', 2, 2),
(35909713, '', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cliente`
--

CREATE TABLE `Cliente` (
  `CUIT` bigint(11) NOT NULL,
  `denominacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` int(15) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contacto1` bigint(15) DEFAULT '0',
  `contacto2` bigint(15) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Cliente`
--

INSERT INTO `Cliente` (`CUIT`, `denominacion`, `direccion`, `telefono`, `email`, `contacto1`, `contacto2`) VALUES
(2735666332, 'Pepito S.A', 'Laprida 2', 1533994499, 'mar@correo.com', 0, 0),
(20142510002, 'Unlam', 'Florencio Varela 2800', 41241148, 'unlam@correo.com', 0, 0),
(20145554442, 'Nuevo S.A.', ' Arieta 3522', 41112141, 'contacto@nuevo.com.ar', 0, 0),
(25444111419, 'La Tablada S.A.', 'Av. Eva Perón 1344', 1541145215, 'tablada@correo.com', 1511221115, 0),
(27221114445, 'Laprida S.A', ' Av. Eva Perón 1555', 41145215, 'nicolasvilavila@gmail.com', 0, 0),
(27999888229, 'Mastil S.A.', 'Av. Eva Perón 2000', 41145215, 'mastil@correo.com', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Costeo`
--

CREATE TABLE `Costeo` (
  `codigo` int(11) NOT NULL,
  `codigo_viaje` int(11) NOT NULL,
  `numero_factura` bigint(30) DEFAULT NULL,
  `detalles` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `litros_combustible` int(4) DEFAULT NULL,
  `precio` int(255) NOT NULL,
  `codigo_gastos` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Costeo`
--

INSERT INTO `Costeo` (`codigo`, `codigo_viaje`, `numero_factura`, `detalles`, `direccion`, `litros_combustible`, `precio`, `codigo_gastos`) VALUES
(4, 27, 12345, 'Prueba', 'Prueba 1234', NULL, 1500, 1),
(6, 27, 123456, 'ypf', 'Lalala 123', NULL, 3500, 2),
(7, 27, 123, 'shell', 'Lalala 123', NULL, 3500, 2),
(8, 27, 111, 'Shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 70, 3500, 2),
(9, 27, 12345, 'shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 205, 15, 2),
(10, 27, 123, 'Comida', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 200, 1),
(11, 27, 111, 'Comida', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 200, 1),
(12, 27, 525, 'Comida', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 500, 1),
(13, 27, 858, 'Comida', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 500, 1),
(14, 27, 52555, 'Comida', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 152, 3),
(15, 27, 52555, 'Comida', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 152, 3),
(16, 27, 878, 'Comida', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 150, 1),
(17, 27, 99, 'Shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 20, 4000, 2),
(18, 27, 150, 'ypf', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 50, 2500, 2),
(19, 27, 150, 'ypf', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 20, 155, 2),
(20, 27, 878889, 'Shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 25, 5000, 2),
(21, 27, 252, 'Shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 15, 3000, 2),
(22, 27, 150, 'ypf', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 15, 3000, 2),
(23, 27, 75, 'Shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 25, 25, 2),
(24, 27, 871, 'Shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 15, 1500, 2),
(25, 27, 500, '500', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 500, 500, 2),
(26, 27, 150, '150', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 150, 150, 2),
(27, 27, 150, 'Shell', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 150, 150, 2),
(28, 36, 1234567890, 'Sanguche de milanesa', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 250, 1),
(31, 27, 12344541, 'ruta 3', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 140, 3),
(32, 27, 12344541, 'ruta 3', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', NULL, 140, 3),
(33, 27, 1224444, 'axion', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 1233, 1444, 2),
(34, 27, 12333, 'axion', 'Ruta Provincial 13 2401, Avenida Cerro de la Gloria, 5539 Challao, Argentina', 2444, 233, 2),
(35, 41, 12345, 'axion market', 'del Bañado 378, 1755 Rafael Castillo, Argentina', NULL, 200, 1),
(36, 42, 45212, 'ruta 3', 'del Bañado 378, 1755 Rafael Castillo, Argentina', NULL, 150, 1),
(37, 42, 12445, 'shell', 'Ipiranga 3420, 1757 Gregorio de Laferrere, Argentina', NULL, 1200, 1),
(38, 42, 1244, 'shell', 'del Bañado 378, 1755 Rafael Castillo, Argentina', NULL, 200, 1),
(39, 42, 1244, 'shell', 'del Bañado 378, 1755 Rafael Castillo, Argentina', NULL, 200, 1),
(40, 42, 1242, 'shell', 'Ipiranga 3420, 1757 Gregorio de Laferrere, Argentina', NULL, 1266, 1),
(41, 42, 12444, 'shell', 'tornquist 56', 300, 1200, 2),
(42, 42, 12345678, 'Almuerzo', 'Pablo H Martin, Luis María Drago, 1755 Rafael Castillo, Argentina', NULL, 400, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Gastos`
--

CREATE TABLE `Gastos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Gastos`
--

INSERT INTO `Gastos` (`codigo`, `nombre`) VALUES
(1, 'Viaticos'),
(2, 'Combustible'),
(3, 'Peajes'),
(6, 'Pesajes'),
(7, 'Extras'),
(8, 'Hazard'),
(9, 'Reefer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Mantenimiento`
--

CREATE TABLE `Mantenimiento` (
  `codigo` int(3) NOT NULL,
  `patente_vehiculo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha inicio` date NOT NULL,
  `fecha final` date DEFAULT NULL,
  `kilometraje` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  `cod_taller` bigint(11) DEFAULT NULL,
  `dni_mecanico` int(20) NOT NULL,
  `id_proximo` int(5) DEFAULT NULL,
  `repuestos_cambiados` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Mantenimiento`
--

INSERT INTO `Mantenimiento` (`codigo`, `patente_vehiculo`, `fecha inicio`, `fecha final`, `kilometraje`, `costo`, `cod_taller`, `dni_mecanico`, `id_proximo`, `repuestos_cambiados`) VALUES
(7, 'AA123CD', '2020-11-27', '2020-11-30', 15000, 20000, 2014125982, 14521414, 18, 'Luces');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Marca`
--

CREATE TABLE `Marca` (
  `codigo` int(2) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Marca`
--

INSERT INTO `Marca` (`codigo`, `nombre`) VALUES
(1, 'Iveco'),
(2, 'Scania'),
(3, 'Mercedes Benz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Modelo`
--

CREATE TABLE `Modelo` (
  `cod_modelo` int(11) NOT NULL,
  `cod_marca` int(11) NOT NULL,
  `descripcion` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Modelo`
--

INSERT INTO `Modelo` (`cod_modelo`, `cod_marca`, `descripcion`) VALUES
(1, 1, 'Cursor'),
(2, 2, 'G310'),
(3, 2, 'G410'),
(4, 2, 'G460'),
(5, 3, 'Actros 1846');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Proforma`
--

CREATE TABLE `Proforma` (
  `numero` int(10) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fee_previsto` int(8) NOT NULL,
  `total_estimado` int(10) NOT NULL,
  `cuit_cliente` bigint(11) NOT NULL,
  `cod_viaje` int(11) NOT NULL,
  `fee_total` int(8) DEFAULT NULL,
  `total_real` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Proforma`
--

INSERT INTO `Proforma` (`numero`, `fecha_emision`, `fee_previsto`, `total_estimado`, `cuit_cliente`, `cod_viaje`, `fee_total`, `total_real`) VALUES
(24, '2020-11-13', 100, 5000, 25444111419, 36, 100, 250),
(29, '2020-12-09', 6000, 6800, 25444111419, 41, NULL, 200),
(30, '2020-12-10', 7000, 12950, 2735666332, 42, NULL, 4616),
(31, '2020-12-10', 15000, 43000, 20142510002, 43, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Repuesto`
--

CREATE TABLE `Repuesto` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Service`
--

CREATE TABLE `Service` (
  `id` int(5) NOT NULL,
  `patente_vehiculo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Service`
--

INSERT INTO `Service` (`id`, `patente_vehiculo`, `fecha`) VALUES
(17, 'AA123CD', '2020-12-08'),
(18, 'AA123CD', '2021-01-27'),
(19, 'AA123CD', '2021-01-13'),
(21, 'AB582QW', '2020-12-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Taller`
--

CREATE TABLE `Taller` (
  `CUIT` bigint(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Taller`
--

INSERT INTO `Taller` (`CUIT`, `nombre`, `direccion`, `telefono`) VALUES
(2014125982, 'Empresa', 'Av. Eva Perón 1432', 41145214),
(20218346426, 'Propio', 'Av. Eva Perón 1500', 41112141);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoArrastre`
--

CREATE TABLE `tipoArrastre` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipoArrastre`
--

INSERT INTO `tipoArrastre` (`codigo`, `nombre`) VALUES
(1, 'Araña'),
(2, 'Jaula'),
(3, 'Tanque'),
(4, 'Granel'),
(5, 'CarCarrier');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `dni` int(8) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fecha de nacimiento` date NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rol` int(1) NOT NULL DEFAULT '0',
  `cod_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`dni`, `nombre`, `apellido`, `fecha de nacimiento`, `email`, `password`, `rol`, `cod_area`) VALUES
(12345678, 'Matias', 'Alarcon', '2000-12-28', 'usuario@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1),
(14521474, 'Jose', 'Hernandez', '1980-12-01', 'chofer2@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', 4, 4),
(27233444, 'Juan', 'Delgado', '2020-11-06', 'jd@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 3, 3),
(32514124, 'Señor', 'Chofer', '2000-12-01', 'chofer@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', 4, 4),
(32521412, 'Marcos', 'Andrada', '1990-10-01', 'marcos@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', 0, 2),
(32521419, 'juan', 'delgado', '2020-12-17', 'vilavila@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 0, 1),
(35909000, 'Jessica', 'Delgado', '1990-12-28', 'supervisor@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 2),
(35909713, 'Matias', 'Alarcon', '1990-12-28', 'matias@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', 4, 4),
(35909715, 'Matias', 'Alarcon', '1980-12-24', 'matias1@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vehiculo`
--

CREATE TABLE `Vehiculo` (
  `patente` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cod_marca` int(11) NOT NULL,
  `cod_modelo` int(11) NOT NULL,
  `anio_fabricacion` int(4) NOT NULL,
  `chasis` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `motor` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `km actual` int(10) NOT NULL DEFAULT '0',
  `km total` int(10) NOT NULL,
  `posicion_actual` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT ' 1 - disponible, 2 - en viaje, 3 - fuera de servicio,4 - en mantenimiento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `Vehiculo`
--

INSERT INTO `Vehiculo` (`patente`, `cod_marca`, `cod_modelo`, `anio_fabricacion`, `chasis`, `motor`, `km actual`, `km total`, `posicion_actual`, `estado`) VALUES
('AA123CD', 1, 1, 2016, '5554455AS', '53879558', 0, 150, '-34.6947584,-58.612121599999995', 2),
('AA124DC', 1, 1, 2015, 'R69904367', '69904367', 0, 2000, '-34.695845299999995,-58.6194019', 2),
('AA150QW', 2, 3, 2014, 'I82039512', '82039512', 0, 1000, NULL, 2),
('AB582QW', 3, 5, 2018, 'V17800122', '17800122', 0, 500, NULL, 1),
('AC989QW', 3, 5, 2013, 'F64092078', '64092078', 0, 14000, '-32.865343,-68.926989', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Viaje`
--

CREATE TABLE `Viaje` (
  `codigo` int(11) NOT NULL,
  `fecha_viaje` date NOT NULL,
  `ETA` date NOT NULL,
  `direccion_origen` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `localidad_origen` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `provincia_origen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pais_origen` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `direccion_destino` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `localidad_destino` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `provincia_destino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pais_destino` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tipo_carga` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `peso_neto` int(10) NOT NULL,
  `imo_class` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temperatura` int(11) DEFAULT NULL,
  `km_previsto` int(10) NOT NULL,
  `combustible_previsto` int(7) NOT NULL,
  `viaticos_previsto` int(10) NOT NULL,
  `peajes_previsto` int(10) NOT NULL,
  `pesajes_previsto` int(10) NOT NULL,
  `extras_previsto` int(10) NOT NULL,
  `hazard_previsto` int(10) NOT NULL DEFAULT '0',
  `reefer_previsto` int(10) NOT NULL DEFAULT '0',
  `patente_vehiculo` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `patente_arrastre` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dni_chofer` int(11) NOT NULL,
  `id_celular` int(10) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' 0-No iniciado | 1 - En viaje | 2 - Finalizado ',
  `desviaciones` int(8) DEFAULT '0',
  `km_totales` int(255) DEFAULT '0',
  `eta_real` date DEFAULT NULL,
  `combustible_total` int(255) DEFAULT '0',
  `hazard_total` int(11) DEFAULT '0',
  `reefer_total` int(10) DEFAULT '0',
  `viaticos_total` int(10) DEFAULT NULL,
  `peajes_total` int(10) DEFAULT NULL,
  `pesajes_total` int(10) DEFAULT NULL,
  `extras_total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Viaje`
--

INSERT INTO `Viaje` (`codigo`, `fecha_viaje`, `ETA`, `direccion_origen`, `localidad_origen`, `provincia_origen`, `pais_origen`, `direccion_destino`, `localidad_destino`, `provincia_destino`, `pais_destino`, `tipo_carga`, `peso_neto`, `imo_class`, `temperatura`, `km_previsto`, `combustible_previsto`, `viaticos_previsto`, `peajes_previsto`, `pesajes_previsto`, `extras_previsto`, `hazard_previsto`, `reefer_previsto`, `patente_vehiculo`, `patente_arrastre`, `dni_chofer`, `id_celular`, `estado`, `desviaciones`, `km_totales`, `eta_real`, `combustible_total`, `hazard_total`, `reefer_total`, `viaticos_total`, `peajes_total`, `pesajes_total`, `extras_total`) VALUES
(27, '2020-11-24', '2020-11-25', 'Hornos 500', 'San Justo', 'Bs As', 'Argentina', 'Ruiz 5100', 'Mar Del Plata', 'Buenos Aires', 'Argentina', '40\"', 500, NULL, NULL, 500, 4000, 0, 0, 0, 0, 0, 0, 'AA123CD', 'AD14XAW', 14521474, 2, 2, 0, 180, NULL, 1827, 0, 0, 0, 280, 0, 0),
(28, '2020-11-12', '2020-11-24', 'Estrada', 'Castillo', 'BsAS', 'Argentina', 'Rojas', 'Morón', 'Bs As', 'Argentina', '40\"', 22222, 'Clase 8', NULL, 222, 2222, 0, 0, 0, 0, 0, 0, 'AA123CD', 'AD145XA', 32514124, NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0),
(29, '2020-11-23', '2020-11-24', 'Estrada', 'Castillo', 'hh', 'Argentina', 'Rojas', 'Morón', 'Bs As', 'Argentina', '40\"', 1222, 'Clase 1', NULL, 222, 222, 0, 0, 0, 0, 0, 0, 'AA123CD', 'AD145XA', 32514124, NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0),
(30, '2020-11-24', '2020-11-25', 'Estrada', 'Castillo', 'BsAS', 'Argentina', 'Rojas', 'Morón', 'Bs As', 'Argentina', 'Líquida', 233, 'Clase 1', 2222, 2222, 22222, 0, 0, 0, 0, 0, 0, 'AA123CD', 'AD14XAW', 32514124, NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0),
(31, '2020-11-24', '2020-11-30', 'Estrada', 'Castillo', 'BsAS', 'Argentina', 'Rojas', 'Morón', 'Bs As', 'Argentina', 'Granel', 2222, NULL, NULL, 222, 222, 0, 0, 0, 0, 0, 0, 'AA123CD', 'AD14XAW', 32514124, NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0),
(32, '2020-11-24', '2020-11-25', 'Estrada', 'Castillo', 'BsAS', 'Argentina', 'Rojas', 'Morón', 'Bs As', 'Argentina', '20\"', 1233, NULL, NULL, 1222, 12222, 0, 0, 0, 0, 0, 0, 'AA123CD', 'AD145XA', 32514124, NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0),
(35, '2020-11-02', '2020-11-04', 'Rojas 78', 'CABA', 'Bs As', 'Argentina', 'Ruiz 5000', 'Mar Del Plata', 'Buenos Aires', 'Argentina', '20\"', 500, NULL, NULL, 500, 4000, 0, 0, 0, 0, 0, 0, 'AC989QW', 'AD14XAW', 32514124, 1, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0),
(36, '2020-11-30', '2020-12-03', 'La rioja 123', 'Rafael Castillo', 'BsAS', 'Argentina', 'Madrid 24', 'Morón', 'Bs As', 'Argentina', '20\"', 1200, 'Clase 1', NULL, 1244, 12555, 0, 0, 0, 0, 500, 0, 'AC989QW', 'AD14XAW', 32514124, 2, 0, 0, 147, NULL, 0, 0, 0, 250, 0, 0, 0),
(37, '2020-11-30', '2020-12-01', 'Andes 150', 'San Justo', 'Bs As', 'Argentina', 'Ruiz 5000', 'Mar Del Plata', 'Buenos Aires', 'Argentina', 'Líquida', 500, 'Clase 2', -50, 0, 0, 0, 0, 0, 0, 1500, 1500, 'AA123CD', 'AA449AD', 14521474, 1, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0),
(38, '2020-11-02', '2020-11-03', 'Andes 150', 'San Justo', 'Bs As', 'Argentina', 'Ruiz 5000', 'Mar Del Plata', 'Buenos Aires', 'Argentina', '20\"', 500, NULL, NULL, 1, 2, 3, 5, 6, 8, 0, 0, 'AA123CD', 'AC296AS', 14521474, 1, 0, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL),
(39, '2020-12-02', '2020-12-03', 'Varela 500', 'Moron', 'Bs As', 'Argentina', 'Ruiz 5000', 'Mar Del Plata', 'Buenos Aires', 'Argentina', 'CarCarrier', 500, NULL, NULL, 1, 2, 3, 4, 5, 6, 0, 0, 'AA123CD', 'AD252AD', 14521474, 1, 0, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL),
(40, '2020-12-03', '2020-12-04', 'Varela 500', 'San Justo', 'Bs As', 'Argentina', 'Ruiz 5000', 'Mar Del Plata', 'Buenos Aires', 'Argentina', '40\"', 500, NULL, NULL, 500, 600, 700, 800, 900, 1000, 0, 0, 'AA123CD', 'AA189AD', 14521474, 1, 0, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL),
(41, '2020-12-09', '2020-12-10', 'La rioja 123', 'Ciudadela', 'BsAS', 'Argentina', 'Madrid 24', 'Morón', 'Bs As', 'Argentina', 'Granel', 30000, NULL, NULL, 2000, 500, 100, 200, 2000, 0, 0, 0, 'AA123CD', 'AC208AG', 14521474, 1, 0, 0, 120, NULL, 0, 0, 0, NULL, NULL, NULL, NULL),
(42, '2020-12-12', '2020-12-13', 'La rioja 123', 'Rafael Castillo', 'BsAS', 'Argentina', 'Rojas', 'Morón', 'Bs As', 'Argentina', '20\"', 2000, 'Clase 4.1', NULL, 2000, 5000, 100, 200, 200, 150, 500, 0, 'AA124DC', 'AA887AS', 14521474, 4, 0, 0, 250, NULL, 0, 0, 0, NULL, NULL, NULL, NULL),
(43, '2020-12-11', '2020-12-12', 'Av Presidente Peron 1550', 'San Justo', 'Bs As', 'Argentina', 'Ruiz 5000', 'Mar Del Plata', 'Buenos Aires', 'Argentina', 'Líquida', 500, 'Clase 5.1', -68, 450, 7000, 3000, 3000, 10000, 5000, 5000, 5000, 'AA150QW', 'AB405AG', 14521474, 5, 0, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Area`
--
ALTER TABLE `Area`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `Arrastre`
--
ALTER TABLE `Arrastre`
  ADD PRIMARY KEY (`patente`),
  ADD KEY `fk_Arrastre_tipoArrastre` (`codigo_tipoArrastre`);

--
-- Indices de la tabla `Celulares`
--
ALTER TABLE `Celulares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Chofer`
--
ALTER TABLE `Chofer`
  ADD PRIMARY KEY (`dni_chofer`),
  ADD KEY `fk_chofer_vehiculo` (`vehiculo_asignado`),
  ADD KEY `fk_chofer_cel` (`id_celular`);

--
-- Indices de la tabla `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`CUIT`);

--
-- Indices de la tabla `Costeo`
--
ALTER TABLE `Costeo`
  ADD PRIMARY KEY (`codigo`,`codigo_viaje`),
  ADD KEY `fk_costeo_gastos` (`codigo_gastos`),
  ADD KEY `fk_costeo_viaje` (`codigo_viaje`);

--
-- Indices de la tabla `Gastos`
--
ALTER TABLE `Gastos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `Mantenimiento`
--
ALTER TABLE `Mantenimiento`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_taller` (`cod_taller`),
  ADD KEY `fk_vehiculo` (`patente_vehiculo`),
  ADD KEY `fk_proximo_service` (`id_proximo`);

--
-- Indices de la tabla `Marca`
--
ALTER TABLE `Marca`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `Modelo`
--
ALTER TABLE `Modelo`
  ADD PRIMARY KEY (`cod_modelo`,`cod_marca`),
  ADD KEY `cod_marca` (`cod_marca`);

--
-- Indices de la tabla `Proforma`
--
ALTER TABLE `Proforma`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `fk_viaje_proforma` (`cod_viaje`),
  ADD KEY `fk_proforma_cliente` (`cuit_cliente`);

--
-- Indices de la tabla `Repuesto`
--
ALTER TABLE `Repuesto`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`id`,`patente_vehiculo`),
  ADD KEY `patente_vehiculo` (`patente_vehiculo`);

--
-- Indices de la tabla `Taller`
--
ALTER TABLE `Taller`
  ADD PRIMARY KEY (`CUIT`);

--
-- Indices de la tabla `tipoArrastre`
--
ALTER TABLE `tipoArrastre`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`dni`),
  ADD KEY `fk_usuarios_area` (`cod_area`);

--
-- Indices de la tabla `Vehiculo`
--
ALTER TABLE `Vehiculo`
  ADD PRIMARY KEY (`patente`),
  ADD KEY `cod_modelo` (`cod_modelo`),
  ADD KEY `cod_marca` (`cod_marca`) USING BTREE;

--
-- Indices de la tabla `Viaje`
--
ALTER TABLE `Viaje`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_viaje_vehiculo` (`patente_vehiculo`),
  ADD KEY `fk_viaje_arrastre` (`patente_arrastre`),
  ADD KEY `fk_viaje_chofer` (`dni_chofer`),
  ADD KEY `fk_viaje_celulares` (`id_celular`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Area`
--
ALTER TABLE `Area`
  MODIFY `codigo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Celulares`
--
ALTER TABLE `Celulares`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Costeo`
--
ALTER TABLE `Costeo`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `Gastos`
--
ALTER TABLE `Gastos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Mantenimiento`
--
ALTER TABLE `Mantenimiento`
  MODIFY `codigo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `Marca`
--
ALTER TABLE `Marca`
  MODIFY `codigo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Modelo`
--
ALTER TABLE `Modelo`
  MODIFY `cod_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Proforma`
--
ALTER TABLE `Proforma`
  MODIFY `numero` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `Repuesto`
--
ALTER TABLE `Repuesto`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Service`
--
ALTER TABLE `Service`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tipoArrastre`
--
ALTER TABLE `tipoArrastre`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Viaje`
--
ALTER TABLE `Viaje`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Arrastre`
--
ALTER TABLE `Arrastre`
  ADD CONSTRAINT `fk_Arrastre_tipoArrastre` FOREIGN KEY (`codigo_tipoArrastre`) REFERENCES `tipoArrastre` (`codigo`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Chofer`
--
ALTER TABLE `Chofer`
  ADD CONSTRAINT `fk_chofer_cel` FOREIGN KEY (`id_celular`) REFERENCES `Celulares` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_chofer_dni` FOREIGN KEY (`dni_chofer`) REFERENCES `Usuarios` (`dni`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_chofer_vehiculo` FOREIGN KEY (`vehiculo_asignado`) REFERENCES `Vehiculo` (`patente`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Costeo`
--
ALTER TABLE `Costeo`
  ADD CONSTRAINT `fk_costeo_gastos` FOREIGN KEY (`codigo_gastos`) REFERENCES `Gastos` (`codigo`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_costeo_viaje` FOREIGN KEY (`codigo_viaje`) REFERENCES `Viaje` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Mantenimiento`
--
ALTER TABLE `Mantenimiento`
  ADD CONSTRAINT `fk_proximo_service` FOREIGN KEY (`id_proximo`) REFERENCES `Service` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_taller` FOREIGN KEY (`cod_taller`) REFERENCES `Taller` (`cuit`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_vehiculo` FOREIGN KEY (`patente_vehiculo`) REFERENCES `Vehiculo` (`patente`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Modelo`
--
ALTER TABLE `Modelo`
  ADD CONSTRAINT `Modelo_ibfk_1` FOREIGN KEY (`cod_marca`) REFERENCES `Marca` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Proforma`
--
ALTER TABLE `Proforma`
  ADD CONSTRAINT `fk_proforma_cliente` FOREIGN KEY (`cuit_cliente`) REFERENCES `Cliente` (`cuit`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_viaje_proforma` FOREIGN KEY (`cod_viaje`) REFERENCES `Viaje` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Service`
--
ALTER TABLE `Service`
  ADD CONSTRAINT `Service_ibfk_1` FOREIGN KEY (`patente_vehiculo`) REFERENCES `Vehiculo` (`patente`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `fk_usuarios_area` FOREIGN KEY (`cod_area`) REFERENCES `Area` (`codigo`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Vehiculo`
--
ALTER TABLE `Vehiculo`
  ADD CONSTRAINT `Vehiculo_ibfk_1` FOREIGN KEY (`cod_modelo`) REFERENCES `Modelo` (`cod_modelo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Vehiculo_ibfk_2` FOREIGN KEY (`cod_marca`) REFERENCES `Modelo` (`cod_marca`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Viaje`
--
ALTER TABLE `Viaje`
  ADD CONSTRAINT `fk_viaje_arrastre` FOREIGN KEY (`patente_arrastre`) REFERENCES `Arrastre` (`patente`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_viaje_celulares` FOREIGN KEY (`id_celular`) REFERENCES `Celulares` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_viaje_chofer` FOREIGN KEY (`dni_chofer`) REFERENCES `Usuarios` (`dni`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_viaje_vehiculo` FOREIGN KEY (`patente_vehiculo`) REFERENCES `Vehiculo` (`patente`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
