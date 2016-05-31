-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2016 a las 10:24:22
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.5.33

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gabri`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document`
--

CREATE TABLE `document` (
  `id` int(10) UNSIGNED NOT NULL,
  `original_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enterprise`
--

CREATE TABLE `enterprise` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_ini` bigint(20) UNSIGNED NOT NULL,
  `city` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` int(10) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `enterprise`
--

INSERT INTO `enterprise` (`id`, `name`, `address`, `date_ini`, `city`, `postal_code`, `description`) VALUES
(1, 'Empresa 1', 'C/ Aquí mismo, 5', 1462354787, 'Barcelona', 8027, 'Una empresa de ejemplo para el proyecto.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `parentId` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `date`, `titulo`, `description`, `userId`, `parentId`) VALUES
(1, 1462354787, 'Un título para el anuncio de la empresa.', 'Chanante ipsum dolor sit amet, quis ullamco adipisicing elit te viste de torero sed. Labore ad minim ullamco ut ea quis. Nostrud es de traca elit aliqua adipisicing.\r\n\r\nEiusmod eiusmod, et gaticos con las rodillas in the guanter aliqua saepe zagal ut. Ad enim nisi aliqua ut ex. Adipisicing ut ut tempor. Cosica te viste de torero dolore ullamco ut eveniet labore labore exercitation.\r\n\r\nVeniam ea tontaco te viste de torero elit et ullamco bizcoché enim ut. Ex enim nianoniano estoy fatal de lo mío dolore ut ayy qué gustico incididunt, dolore eveniet páharo. Tempor incididunt ut bajonaaa consectetur, incididunt nisi exercitation ex ut eiusmod.', 1, NULL),
(2, 1462354787, 'Título para el comentario.', 'Te viste de torero cacahué ut con las rodillas in the guanter horcate enim. Coconut labore páharo elit interneeeer, saepe.\r\n\r\nAliqua tunante gambitero viejuno bizcoché vivo con tu madre en un castillo mangurrián gañán gatete nuiiiii, asobinao veniam. Monetes ad magna. Dolore, dolore ojete moreno.', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `tipo`) VALUES
(1, 'Usuario'),
(2, 'Administrador'),
(3, 'Superadministrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `enterpriseId` int(10) UNSIGNED NOT NULL,
  `rolId` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `mail`, `username`, `password`, `enterpriseId`, `rolId`) VALUES
(1, 'gabri@tgf.com', 'gabri', 'gabri', 1, 3),
(2, 'jose@tfg.com', 'jose', 'jose', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D8698A76E094D20D` (`postId`);

--
-- Indices de la tabla `enterprise`
--
ALTER TABLE `enterprise`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8D64B64DCC` (`userId`),
  ADD KEY `IDX_5A8A6C8D10EE4CEE` (`parentId`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D93D649ACF729C4` (`enterpriseId`),
  ADD KEY `IDX_8D93D649CDCC0AE` (`rolId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `document`
--
ALTER TABLE `document`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `enterprise`
--
ALTER TABLE `enterprise`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `FK_D8698A76E094D20D` FOREIGN KEY (`postId`) REFERENCES `post` (`id`);

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8D10EE4CEE` FOREIGN KEY (`parentId`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_5A8A6C8D64B64DCC` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649ACF729C4` FOREIGN KEY (`enterpriseId`) REFERENCES `enterprise` (`id`),
  ADD CONSTRAINT `FK_8D93D649CDCC0AE` FOREIGN KEY (`rolId`) REFERENCES `rol` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
