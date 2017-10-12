-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2017 at 06:28 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `heroes_digitales`
--



-- External tables
--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Medio ambiente', 'Proyectos relacionados a energías renovables');


--
-- Dumping data for table `ciudad`
--

INSERT INTO `ciudad` (`id`, `nombre`) VALUES
(1, 'La Paz'),
(2, 'El Alto');


--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Junior', 'Solo pueden participar equipos conformados por niños/as de 10 a 14 años'),
(2, 'Senior', 'Solo pueden participar equipos conformados por adolescentes de 14 a 18 años');


--
-- Dumping data for table `experticia`
--

INSERT INTO `experticia` (`id`, `nombre`) VALUES
(1, 'Nada'),
(2, 'Regular'),
(3, 'Bueno');

--
-- Dumping data for table `genero`
--

INSERT INTO `genero` (`id`, `descripcion`) VALUES
(1, 'Femenino'),
(2, 'Masculino');

--
-- Dumping data for table `habilidad`
--

INSERT INTO `habilidad` (`id`, `nombre`, `descripcion`) VALUES
(1, 'AppInventor', 'Herramienta para desarrollo de aplicaciones Android'),
(2, 'Android', 'Plataforma para desarrollo de aplicaciones'),
(3, 'Java', 'Lenguaje de programción'),
(4, 'Diseño', 'Aspecto estético sobre las aplicaciones'),
(5, 'Documentación', 'Documentos que permiten y facilitan el uso de los sistemas'),
(6, 'Emprendimiento', 'Capacidad para idear nuevas ideas/soluciones a distintos problemas');


--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Estudiante', 'Usuario concursante'),
(2, 'Mentor', 'Usuario responsable de los equipos'),
(3, 'Juez', 'Usuario revisor de los proyectos'),
(4, 'Experto', 'Usuario que ayuda a los distintos equipos'),
(5, 'Admin', 'Súper usuario');

INSERT INTO `tamano_polera` (`id`, `nombre`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
