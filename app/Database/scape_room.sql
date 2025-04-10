-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-04-2025 a las 04:27:34
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
-- Base de datos: `scape_room`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `nombre`, `creado_en`) VALUES
(1, 'Los Criptógrafos', '2025-03-26 07:15:33'),
(2, 'Escape Masters', '2025-03-26 07:15:33'),
(3, 'Cipher Squad', '2025-03-26 07:15:33'),
(4, 'Los Descifradores', '2025-03-26 07:15:33'),
(5, 'Enigma Team', '2025-03-26 07:15:33'),
(6, 'Brain Hackers', '2025-03-26 07:15:33'),
(7, 'Puzzle Kings', '2025-03-26 07:15:33'),
(8, 'Mentes Maestras', '2025-03-26 07:15:33'),
(24, 'Los Escapistas', '2025-04-09 08:11:56'),
(25, 'Exploradores del Laberinto', '2025-04-09 08:21:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `sala_id` int(11) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `sala_id`, `hora`) VALUES
(1, 1, '15:00:00'),
(2, 1, '16:30:00'),
(3, 1, '19:30:00'),
(4, 1, '21:00:00'),
(5, 2, '15:00:00'),
(6, 2, '16:30:00'),
(7, 2, '18:00:00'),
(8, 3, '19:30:00'),
(9, 3, '21:00:00'),
(10, 3, '22:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ranking`
--

CREATE TABLE `ranking` (
  `id` int(11) NOT NULL,
  `equipo_id` int(11) NOT NULL,
  `sala_id` int(11) NOT NULL,
  `puntaje` decimal(10,2) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `tiempo` time NOT NULL,
  `registrado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ranking`
--

INSERT INTO `ranking` (`id`, `equipo_id`, `sala_id`, `puntaje`, `codigo`, `tiempo`, `registrado_en`) VALUES
(1, 1, 1, 800.50, NULL, '09:50:30', '2025-03-27 04:12:24'),
(2, 2, 2, 833.54, NULL, '00:45:12', '2025-03-27 04:12:24'),
(3, 3, 3, 690.25, NULL, '00:48:45', '2025-03-27 04:12:24'),
(4, 4, 2, 100.00, NULL, '18:25:33', '2025-03-27 04:12:24'),
(5, 5, 3, 566.48, NULL, '00:52:33', '2025-03-27 04:12:24'),
(6, 24, 2, 0.00, NULL, '00:45:22', '2025-04-09 08:11:56'),
(7, 25, 2, 396.00, 'EQP-0CDF3', '00:38:12', '2025-04-09 08:21:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `sala_id` int(11) NOT NULL,
  `horario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad_jugadores` int(11) NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada') DEFAULT 'pendiente',
  `metodo_pago` enum('yape','plin','transferencia') NOT NULL,
  `precio_total` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id`, `cliente`, `correo`, `telefono`, `sala_id`, `horario_id`, `fecha`, `cantidad_jugadores`, `estado`, `metodo_pago`, `precio_total`, `created_at`, `activo`) VALUES
(1, 'Sofía Ramírez', 'sofia.ramirez@mail.com', '987654321', 1, 2, '2025-04-25', 4, 'pendiente', 'yape', 120.00, '2025-04-03 03:29:23', 0),
(2, 'Laura Ríos', 'laura.rios@mail.com', '944555666', 1, 1, '2025-04-20', 4, 'pendiente', 'yape', 120.50, '2025-04-03 03:44:54', 1),
(3, 'Carlos Huamán', 'carlos.huaman@mail.com', '987111222', 2, 5, '2025-04-20', 5, 'pendiente', 'plin', 140.00, '2025-04-03 09:08:20', 1),
(4, 'Patricia León', 'patricia.leon@mail.com', '912333444', 1, 1, '2025-04-21', 3, 'pendiente', 'transferencia', 90.50, '2025-04-03 09:08:29', 1),
(5, 'Vanessa Ortiz', 'vanessa.ortiz@mail.com', '987654987', 1, 1, '2025-04-07', 4, 'pendiente', 'yape', 160.00, '2025-04-03 22:38:30', 1),
(6, 'Sandra Perez', 'sandra.perez@gmail.com', '978415121', 1, 1, '2025-04-25', 3, 'pendiente', 'plin', 120.00, '2025-04-09 05:45:54', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `min_jugadores` int(11) NOT NULL,
  `max_jugadores` int(11) NOT NULL,
  `duracion` int(11) NOT NULL,
  `dificultad` enum('Baja','Media','Alta','Extrema') NOT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `tags` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `reservas_hoy` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`id`, `nombre`, `descripcion`, `min_jugadores`, `max_jugadores`, `duracion`, `dificultad`, `rating`, `tags`, `imagen`, `destacado`, `reservas_hoy`, `created_at`) VALUES
(1, 'Código Enigma', 'Atrapado en una antigua oficina de inteligencia, debes descifrar los códigos secretos para evitar que información clasificada caiga en manos enemigas.', 2, 6, 60, 'Alta', 4.2, 'Enigmas,Histórico,Difícil', 'codigo-enigma.jpg', 1, 15, '2025-03-24 07:14:09'),
(2, 'La Bóveda', 'Un robo perfecto a la bóveda más segura del mundo. Encuentra la combinación maestra y escapa antes de que llegue la policía.', 3, 6, 60, 'Extrema', 5.0, 'Heist,Lógica,Extremo', 'la-boveda.jpg', 1, 20, '2025-03-24 07:14:09'),
(3, 'El Refugio', 'Después de un apocalipsis nuclear, solo una cápsula de oxígeno queda. Resuelve los acertijos antes de que se acabe el aire.', 2, 5, 45, 'Media', 3.8, 'Postapocalíptico,Estrategia', 'el-refugio.jpg', 0, 7, '2025-03-24 07:14:09'),
(4, 'La Biblioteca Maldita', 'Una vieja biblioteca donde los libros susurran y las sombras se mueven solas. ¿Podrás salir antes de que la maldición caiga sobre ti?', 2, 4, 50, 'Alta', 4.6, 'Terror,Puzzle,Fantasía', 'biblioteca-maldita.jpg', 0, 9, '2025-03-24 07:14:09'),
(5, 'Misión Espacial', 'Estás atrapado en una estación espacial fuera de órbita. Repara los sistemas y encuentra el código de reingreso antes de que se acabe el oxígeno.', 3, 6, 60, 'Media', 4.3, 'Sci-Fi,Aventura,Colaborativo', 'mision-espacial.jpg', 1, 12, '2025-03-24 07:14:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_admin`
--

CREATE TABLE `usuarios_admin` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_admin`
--

INSERT INTO `usuarios_admin` (`id`, `nombre`, `email`, `password`, `rol`, `estado`, `created_at`) VALUES
(30, 'Kevin', 'kevin@mail.com', 'escape23', 'admin', 'activo', '2025-04-08 21:36:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sala_hora` (`sala_id`,`hora`);

--
-- Indices de la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipo_sala` (`equipo_id`,`sala_id`),
  ADD KEY `sala_id` (`sala_id`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sala_fecha_hora` (`sala_id`,`horario_id`,`fecha`),
  ADD KEY `horario_id` (`horario_id`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios_admin`
--
ALTER TABLE `usuarios_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`sala_id`) REFERENCES `sala` (`id`);

--
-- Filtros para la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD CONSTRAINT `ranking_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ranking_ibfk_2` FOREIGN KEY (`sala_id`) REFERENCES `sala` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`sala_id`) REFERENCES `sala` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`horario_id`) REFERENCES `horario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
