-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-10-2017 a las 07:23:23
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `db_parcial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE IF NOT EXISTS `personas` (
`id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `sexo` varchar(15) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `password`, `mail`, `sexo`, `foto`) VALUES
(81, 'Admin', '1aaxKRwFlYIGM', 'Admin', 'Masculino', ''),
(82, 'Emiliano', '1aaxKRwFlYIGM', 'iron_emi7@hotmail.com', 'Masculino', '20161224_204044.jpg'),
(83, 'Nico', '1aaxKRwFlYIGM', 'Nico@hotmail.com', 'Masculino', '20161224_204044.jpg'),
(84, 'Lucas', '1aaxKRwFlYIGM', 'Lucas@gmail.com', 'Masculino', '20161224_204044.jpg'),
(85, 'Anastassia', '1aaxKRwFlYIGM', 'Anastassia@gmail.com', 'Femenino', 'bufanda_lenny_kravitz_95.jpg'),
(86, 'Wendy', '1aaxKRwFlYIGM', 'Wendy@gmail.com', 'Femenino', 'Ala Akbar.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=87;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
