-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2023 a las 04:19:55
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
-- Base de datos: `sales_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `current_discounts`
--

CREATE TABLE `current_discounts` (
  `id` int(11) NOT NULL,
  `console` varchar(20) NOT NULL,
  `min_price` int(10) UNSIGNED NOT NULL,
  `max_price` int(10) UNSIGNED NOT NULL,
  `discount` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `current_discounts`
--

INSERT INTO `current_discounts` (`id`, `console`, `min_price`, `max_price`, `discount`) VALUES
(1, 'PS4', 100000, 0, 5),
(2, 'XBOX', 100001, 150000, 7),
(3, 'PC', 150000, 0, 15),
(4, 'OTRA', 500000, 1000000, 10),
(5, 'N/A', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales_history`
--

CREATE TABLE `sales_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `console` varchar(20) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `discount_id` int(10) NOT NULL,
  `final_price` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sales_history`
--

INSERT INTO `sales_history` (`id`, `console`, `price`, `discount_id`, `final_price`) VALUES
(4, 'PS2', 400000, 5, 400000),
(5, 'XBOX', 140000, 2, 130200);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `current_discounts`
--
ALTER TABLE `current_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sales_history`
--
ALTER TABLE `sales_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discount_id` (`discount_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `current_discounts`
--
ALTER TABLE `current_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sales_history`
--
ALTER TABLE `sales_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sales_history`
--
ALTER TABLE `sales_history`
  ADD CONSTRAINT `sales_history_ibfk_1` FOREIGN KEY (`discount_id`) REFERENCES `current_discounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
