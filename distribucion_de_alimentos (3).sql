-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-08-2025 a las 01:33:42
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
-- Base de datos: `distribucion de alimentos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `stock` int(30) NOT NULL,
  `fecha_entrada` int(11) NOT NULL,
  `stock_esp` int(30) NOT NULL,
  `nombre_lote` varchar(222) NOT NULL,
  `num_lote` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`stock`, `fecha_entrada`, `stock_esp`, `nombre_lote`, `num_lote`) VALUES
(-12, 20250731, 1, 'megan', '7'),
(6, 20250718, 2, 'magali', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id_alumno` int(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `dni` varchar(30) NOT NULL,
  `curso` varchar(30) NOT NULL,
  `division` varchar(30) NOT NULL,
  `celiaco` tinyint(1) NOT NULL,
  `diabetico` tinyint(1) NOT NULL,
  `modulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_alumno`, `nombre`, `apellido`, `dni`, `curso`, `division`, `celiaco`, `diabetico`, `modulo`) VALUES
(2, 'agustina', 'acebeso', '71', '3ro', '6ta', 1, 0, 19),
(3, 'agustina', 'acebeso', '121212', '3ro', '6ta', 0, 1, 4),
(4, 'agustina', 'acebeso', '2323', '2do', '4ta', 0, 0, 3),
(5, 'magali', 'mozon', '1', '6to', '5ta', 0, 0, 2),
(6, 'maga', 'battagliaaaa', '1', '2do', '5ta', 0, 0, 1),
(7, 'agustina', 'battagli', '23', '5to', '4ta', 0, 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `descripcion`) VALUES
(1, 'Director'),
(2, 'Preceptor'),
(3, 'Auxiliar'),
(4, 'Cambio de funcion'),
(5, 'Profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha_despacho`
--

CREATE TABLE `fecha_despacho` (
  `id_distribucion` int(11) NOT NULL,
  `id_alumnoo` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fecha_despacho`
--

INSERT INTO `fecha_despacho` (`id_distribucion`, `id_alumnoo`, `fecha_entrega`) VALUES
(1, 2, '2025-08-16'),
(7, 2, '2025-08-16'),
(8, 2, '2025-08-19'),
(9, 3, '2025-08-19'),
(10, 3, '2025-08-19'),
(11, 2, '2025-08-19'),
(12, 3, '2025-08-19'),
(13, 4, '2025-08-19'),
(14, 7, '2025-08-19'),
(15, 2, '2025-08-19'),
(16, 2, '2025-08-19'),
(17, 2, '2025-08-19'),
(18, 2, '2025-08-19'),
(19, 2, '2025-08-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `contraseña` varchar(30) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `foto` varchar(222) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `correo`, `contraseña`, `id_cargo`, `foto`, `descripcion`) VALUES
(1, 'magali', 'mozo', 'maga@gmail.com', '11', 1, 'fotos_perfil/perfil_68a65a62cccaf.jpg', 'hola mundo'),
(2, 'axel', 'casas', 'casas@gmail.com', '1234', 3, '', ''),
(3, 'arturo', 'emanuel', 'arturo@gmail.com', '1212', 2, '', ''),
(4, 'agustin', 'battagli', 'agus12@gmail.com', '23', 2, '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_alumno`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fecha_despacho`
--
ALTER TABLE `fecha_despacho`
  ADD PRIMARY KEY (`id_distribucion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id_alumno` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `fecha_despacho`
--
ALTER TABLE `fecha_despacho`
  MODIFY `id_distribucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
