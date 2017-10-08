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
-- Dumping data for table `colegio`
--

INSERT INTO `colegio` (`id`, `nombre`) VALUES
(1, 'Instituto Americano'),
(2, 'Boliviano Israelita');


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
-- Dumping data for table `profesion`
--

INSERT INTO `profesion` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Informático', 'Especializado en programación');

--
-- Dumping data for table `zona`
--


--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Estudiante', 'Usuario concursante'),
(2, 'Mentor', 'Usuario responsable de los equipos'),
(3, 'Juez', 'Usuario revisor de los proyectos'),
(4, 'Experto', 'Usuario que ayuda a los distintos equipos'),
(5, 'Admin', 'Súper usuario');

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `password`, `nombres`, `apellidos`, `fecha_nacimiento`, `celular`, `terminos_uso`, `activo`, `fecha_creacion`, `fecha_actualizacion`, `ciudad_id`, `genero_id`) VALUES
(4, 'baruchspredd@gmail.com', '$2y$10$cX/RXho3AQFtSrJ3xsV5quahbQ0IplGX.skwjW95Y924WEqJgxMoe', 'Pablo Diego', 'Montes', '1990-08-07', 70123232, 0, 0, '2017-08-26 20:35:45', '2017-08-26 20:35:45', 1, 2),
(5, 'baruchspred@gmail.com', '$2y$10$w1Tz0yev5r1q8vpYFntF8.86NRKRkUNKU1vCaIs6z3YSFcxfyzYCS', 'Diego', 'Alvarez', '1990-08-07', 70123232, 1, 1, '2017-08-26 20:37:35', '2017-09-04 15:38:54', 1, 2),
(8, 'diemontes@hotmail.com', '$2y$10$TEezUZkbwZSjJTf/oYqGmO7jMPWpxfQjqEbcc.GcCjc.CZ22wmfFq', 'Pablo Diegoz', 'Montes Jordan', '1990-08-07', 70162630, 1, 1, '2017-08-26 20:47:05', '2017-09-03 13:58:21', 1, 2),
(9, 'id.galarza.sa@gmail.com', '$2y$10$TfIOAhOxXVipliUEf4Mu0OEe4zo8FwJCGzOUVnvhWHwHRzTogNcJG', 'Ivan', 'Galarza', '1990-08-07', 70123232, 0, 1, '2017-08-26 20:49:08', '2017-09-10 19:43:47', 1, 2),
(14, 'marcemarce@gmail.com', '$2y$10$tG0Ir0/LTNuylYSmZsmpB.TK/XGIVe6chOYfyBO9yRDtD1Ezm.DsG', 'Marcelo', 'Peralta', '1964-06-06', 68119232, 0, 0, '2017-08-26 22:37:46', '2017-08-26 22:37:46', 1, 2),
(17, 'mariana@gmail.com', '$2y$10$N9IgulnOBm5lyZRoXmH5weM0Ybud8aGk8sIL7K2ICXoZUkkvPmk36', 'Mariana', 'Velasquez', '1989-02-03', 70123123, 0, 0, '2017-08-26 22:55:47', '2017-08-26 22:55:47', 1, 1),
(22, 'david@gmail.com', '$2y$10$Tr1DZT.hMIc0XaydPMchs..NjqCIr1KdzVudg7qXlTISuNRW.SpBi', 'Mariana', 'Velasquez', '1989-02-03', 70123123, 0, 0, '2017-08-26 23:10:26', '2017-08-26 23:10:26', 1, 1),
(25, 'alzapa@gmail.com', '$2y$10$Yq2OjZXJzDDNIPCI9tCW.uo5iZ71k/4TRaPkRfcjqjrNH8EGDo.se', 'alvaro', 'Zaparan', '1969-09-07', 70123123, 1, 1, '2017-08-29 10:12:44', '2017-09-12 01:21:28', 1, 2),
(26, 'alvzpp@gmail.com', '$2y$10$s/dAdIQ.WxigPrby8qsObuyp91MPSDQoekcuy3UNMHCr0IuCKiyw6', 'Ana', 'Romero', '2010-08-09', 70123213, 1, 1, '2017-08-29 10:23:20', '2017-09-12 12:30:04', 1, 1),
(27, 'dani.g18@gmail.com', '$2y$10$HeVQNlQADoXeS2IJWgswLu5Aa0IE2ve2TZ.RApc4Ibx/bT2zicuta', 'Daniella', 'Garcia', '1983-12-30', 72254077, 1, 1, '2017-08-29 11:35:09', '2017-09-04 09:32:10', 1, 1),
(28, 'elemental.bolivia@gmail.com', '$2y$10$nFnQHQ7FI9h5tlhnBoISWOSnP9dtNIKvPgPFYk8RO.2.1BLf.s0Vm', 'Marcelo Candia', 'Alvárez', '1962-03-03', 70123236, 0, 1, '2017-08-29 11:45:57', '2017-08-29 18:25:47', 1, 2),
(29, 'esther@gmail.com', '$2y$10$rCqnFV/YUQc9h1n0cQQ1GO3INkSOkOJItjHQZo0LMEdFoTfD6CNKC', 'Esther', 'Jordan', '1969-11-07', 70619793, 0, 1, '2017-09-12 01:57:45', '2017-09-12 01:57:45', 2, 1),
(30, 'alicia@gmail.com', '$2y$10$8x4Ix.8OtyWF3UgHAApUHesUvpWC5W2u6wQXfEM9ppAse4DOTtrea', 'Alicia', 'De las Maravillas', '2008-06-13', 6818212, 0, 1, '2017-09-12 11:46:51', '2017-09-12 11:46:51', 1, 1),
(31, 'jorge.esquivel@gmail.com', '$2y$10$N8rXAFq3lDKu9JARoD8y1.2bFFp97h/fSvn/QMbcDiLIiyuB7kbJW', 'Jorge', 'Esquivel', '1964-08-09', 78013123, 1, 1, '2017-09-14 22:51:45', '2017-09-15 05:17:48', 1, 2),
(33, 'lulu@gmail.com', '$2y$10$g834zhQ0cHEY2CgfaIGbj.YGyaGIX7aV.rBUv2Wx08euMvKsPM/Ze', 'lucia', 'Calderon', '1994-09-06', 70131232, 1, 1, '2017-09-16 15:34:29', '2017-09-16 19:45:03', 2, 2),
(34, 'brenda@gmail.com', '$2y$10$NkQ5yl7Q0J8V2l8Sx9Si3.VjAjkRPOixxw39d..zpiCT1NS1p8WKK', 'Brenda', 'Garcia', '1974-08-05', 701213123, 1, 1, '2017-09-16 16:15:24', '2017-09-16 20:17:17', 1, 1),
(35, 'ingrid@gmail.com', '$2y$10$eMNoVnLsJc6Jye7wiWjoO.ADj01pqlZT/0y9Cj5A.qg2u3OmKzoKG', 'Ingrid', 'Alvárez', '1982-07-01', 70112312, 0, 0, '2017-09-17 12:38:02', '2017-09-17 12:38:02', 1, 1),
(36, 'admin@gmail.com', '$2y$10$fmQxTATrjwzNuq7zVRedqeIo33GPDQnUj6uh4ge7vY8xS1Q.LYqAG', 'Daniella', 'Garcia', '1986-08-11', 7012312, 0, 1, '2017-09-17 15:28:57', '2017-09-17 15:28:57', 1, 1),
(39, 'salva@gmail.com', '$2y$10$UyAH4J/dHcxpegfZuzmHdu2bKtXgG2SQEn0OFYGv9UZoGEwl0MPIy', 'Salvador', 'Montes', '1990-10-09', 7012312, 1, 1, '2017-09-17 23:10:27', '2017-09-18 03:13:51', 1, 2),
(40, 'isabel@gmail.com', '$2y$10$yUsuxkMW7scmw/wcz5FR9.UWC1WTu5Q.N4r42j7rc5Q7wDSFOoFbm', 'Isabel', 'Del Carmen', '2006-10-07', 70131232, 1, 1, '2017-09-17 23:16:42', '2017-09-18 14:09:56', 2, 1),
(41, 'pao@gmail.com', '$2y$10$pxQSWk.f5EsBiAe7mIN4p.bpvu7DHLYimh.1XCakUtw2w/kDm/1pO', 'Paola', 'Garcia', '1987-09-07', 68912165, 1, 1, '2017-09-17 23:19:17', '2017-09-18 14:06:36', 1, 1),
(43, 'guille@gmail.com', '$2y$10$ncnvvuQCIK6ecaLp2ORNvugGil6aZmMLNV4dPj2Mws6ukWDFz26Am', 'Guillermo', 'Careaga', '1995-11-08', 70123128, 1, 1, '2017-09-17 23:43:30', '2017-09-18 03:44:00', 1, 2),
(46, 'pedro@gmail.com', '$2y$10$BZw5IOAwCW6hVKQ3sJyT5OavbBuYpfsyfXCa9/k1bIITtYNhzRC.C', 'Pedro', 'Cabaña', '1992-01-11', 7012314, 0, 1, '2017-09-17 23:54:24', '2017-09-17 23:54:24', 1, 2),
(47, 'susana@gmail.com', '$2y$10$YLcNymBPBjmqV7A1hyXBmOHVtCG3LoLmvNHyAV0cL.fEZA2rgtDw6', 'Susana', 'Carpio', '1991-07-19', 70123146, 1, 1, '2017-09-18 08:24:06', '2017-09-18 12:24:44', 1, 1);

--
-- Dumping data for table `usuario_tiene_rol`
--

INSERT INTO `usuario_tiene_rol` (`id`, `usuario_id`, `rol_id`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(3, 4, 1, '2017-08-26 20:35:46', '2017-08-26 20:35:46'),
(4, 5, 1, '2017-08-26 20:37:36', '2017-08-26 20:37:36'),
(7, 8, 1, '2017-08-26 20:47:05', '2017-08-26 20:47:05'),
(8, 9, 1, '2017-08-26 20:49:08', '2017-08-26 20:49:08'),
(9, 14, 2, '2017-08-26 22:37:46', '2017-08-26 22:37:46'),
(10, 17, 3, '2017-08-26 22:55:47', '2017-08-26 22:55:47'),
(11, 22, 3, '2017-08-26 23:10:26', '2017-08-26 23:10:26'),
(12, 25, 1, '2017-08-29 10:12:44', '2017-08-29 10:12:44'),
(13, 26, 1, '2017-08-29 10:23:20', '2017-08-29 10:23:20'),
(14, 27, 1, '2017-08-29 11:35:10', '2017-08-29 11:35:10'),
(15, 28, 3, '2017-08-29 11:45:57', '2017-08-29 11:45:57'),
(16, 29, 1, '2017-09-12 01:57:45', '2017-09-12 01:57:45'),
(17, 30, 1, '2017-09-12 11:46:51', '2017-09-12 11:46:51'),
(18, 31, 2, '2017-09-14 22:51:45', '2017-09-14 22:51:45'),
(19, 33, 2, '2017-09-16 15:34:29', '2017-09-16 15:34:29'),
(20, 34, 2, '2017-09-16 16:15:24', '2017-09-16 16:15:24'),
(21, 35, 3, '2017-09-17 12:38:02', '2017-09-17 12:38:02'),
(22, 36, 5, '2017-09-17 15:28:57', '2017-09-17 15:28:57'),
(25, 39, 2, '2017-09-17 23:10:27', '2017-09-17 23:10:27'),
(26, 40, 2, '2017-09-17 23:16:42', '2017-09-17 23:16:42'),
(27, 41, 2, '2017-09-17 23:19:17', '2017-09-17 23:19:17'),
(29, 43, 2, '2017-09-17 23:43:30', '2017-09-17 23:43:30'),
(32, 46, 1, '2017-09-17 23:54:24', '2017-09-17 23:54:24'),
(33, 47, 1, '2017-09-18 08:24:06', '2017-09-18 08:24:06');

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `usuario_id`) VALUES
(1, 36);
--
-- Dumping data for table `juez`
--

INSERT INTO `juez` (`id`, `usuario_id`) VALUES
(1, 17),
(2, 22),
(3, 28),
(4, 35);

--
-- Dumping data for table `mentor`
--

INSERT INTO `mentor` (`id`, `usuario_id`) VALUES
(4, 14),
(5, 31),
(6, 33),
(7, 34),
(10, 39),
(11, 40),
(12, 41),
(14, 43);

--
-- Dumping data for table `estudiante`
--

INSERT INTO `estudiante` (`id`, `usuario_id`, `colegio_id`) VALUES
(3, 4, 1),
(4, 5, 1),
(7, 8, 2),
(8, 9, 1),
(9, 25, 1),
(10, 26, 1),
(11, 27, 2),
(12, 29, 1),
(13, 30, 2),
(16, 46, 2),
(17, 47, 1);

--
-- Dumping data for table `biografia`
--

INSERT INTO `biografia` (`id`, `usuario_id`, `descripcion`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(3, 8, 'Soy desarrollador web, con 1 año de experiencia en el campo. He desarrollado varios trabajos, entre las instituciones para las que trabaje están: ATB, ANAPOL, Fundación Unifranz. Ahora desarrollo la plataforma para Elemental - Héroes Digitales', '2017-08-29 05:02:19', '2017-08-29 06:15:52'),
(4, 27, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero laudantium architecto eos maxime, quia fugiat. Omnis possimus recusandae molestias eum doloribus adipisci, suscipit repellendus dolorem provident nemo ipsum quaerat. Pariatur.', '2017-08-29 15:43:14', '2017-08-29 15:43:14'),
(5, 5, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni modi omnis, deserunt iure quod saepe qui fugiat, inventore animi earum suscipit mollitia amet esse quibusdam excepturi maiores impedit vel repudiandae.', '2017-09-04 15:05:07', '2017-09-04 15:05:07'),
(6, 9, NULL, '2017-09-10 19:43:47', '2017-09-10 19:43:47'),
(7, 25, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit ad cumque ea rem, illum consequuntur praesentium, velit minima? Similique, nulla, nihil. Laudantium accusamus tempora blanditiis commodi praesentium perspiciatis, odit pariatur?', '2017-09-12 01:22:14', '2017-09-12 01:22:14'),
(8, 26, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint distinctio dicta molestias natus, blanditiis deserunt, molestiae eaque error soluta libero veniam. Sunt quisquam a fugit numquam perferendis, fugiat tempore quod.', '2017-09-12 12:30:53', '2017-09-12 12:30:53'),
(10, 31, 'akdalksdklasdklaskdaklsdlkaskdaklsdaksjdjadashdnasudasndiuansdiasdiausnass', '2017-09-15 18:47:43', '2017-09-15 18:47:43'),
(11, 33, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium porro libero inventore possimus tempora iure itaque voluptas repudiandae a deserunt? Minima consequuntur ut cumque, laborum quisquam deserunt et quod quo.', '2017-09-16 15:45:36', '2017-09-16 15:45:36'),
(12, 34, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis nemo sequi ex modi quasi culpa expedita non corporis, vel provident nostrum, cumque ducimus ea. Officia adipisci laborum eaque quasi tempore.', '2017-09-16 16:17:33', '2017-09-16 16:17:33'),
(13, 39, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae officiis delectus illo, enim maxime corrupti. Suscipit eum alias omnis, voluptates, maiores cumque minus consequuntur aperiam ratione, qui minima voluptatum, laboriosam!', '2017-09-17 23:20:40', '2017-09-17 23:20:40'),
(14, 43, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor est, dolores! Beatae sit suscipit accusantium, voluptatem totam rem veritatis voluptatum laborum nam, porro consequuntur repellat magni veniam dolorem. Maiores, eum.', '2017-09-17 23:44:28', '2017-09-17 23:44:28'),
(15, 47, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae perferendis modi ipsum molestiae, doloribus soluta tenetur dolore labore quibusdam nemo distinctio quos, ducimus alias ipsam inventore maxime accusamus consequatur fugiat.', '2017-09-18 08:25:31', '2017-09-18 08:25:31'),
(16, 41, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate non deleniti officia at minus quidem beatae, alias quis, delectus perferendis saepe molestiae eos dolorum ullam neque, aut sit explicabo. Similique!', '2017-09-18 10:08:36', '2017-09-18 10:08:36'),
(17, 40, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate non deleniti officia at minus quidem beatae, alias quis, delectus perferendis saepe molestiae eos dolorum ullam neque, aut sit explicabo. Similique!', '2017-09-18 10:10:13', '2017-09-18 10:10:13');


--
-- Dumping data for table `confirmacion_email`
--

INSERT INTO `confirmacion_email` (`id`, `usuario_id`, `token`, `fecha_creacion`) VALUES
(3, 4, 'd41d8cd98f00b204e9800998ecf8427e8c27f4a927b6bad487de2d736c5cd8b5', '2017-08-26 20:35:46'),
(4, 5, 'd41d8cd98f00b204e9800998ecf8427e42dd75bd9b0b5c558bb79dd675b4a348', '2017-08-26 20:37:36'),
(7, 8, 'd41d8cd98f00b204e9800998ecf8427e7901539654509e64f3af39248ba8f0f7', '2017-08-26 20:47:05'),
(8, 9, 'd41d8cd98f00b204e9800998ecf8427e6fa2a759ff61e1ce42425539ec557e88', '2017-08-26 20:49:08'),
(9, 14, 'd41d8cd98f00b204e9800998ecf8427efe82e9c6fc1e04a10b8ab62bf2e3f8d5', '2017-08-26 22:37:46'),
(10, 17, 'd41d8cd98f00b204e9800998ecf8427e7edce3dfb58e76b803c2471fdea08df3', '2017-08-26 22:55:47'),
(11, 22, 'd41d8cd98f00b204e9800998ecf8427ef348dc6c57680b295193a0173bb31388', '2017-08-26 23:10:26'),
(12, 25, 'd41d8cd98f00b204e9800998ecf8427e9aeb014982fa927b5d537e7ba296f03b', '2017-08-29 10:12:44'),
(13, 26, 'd41d8cd98f00b204e9800998ecf8427eed91077f8934837f23406ec009c6cfa3', '2017-08-29 10:23:20'),
(14, 27, 'd41d8cd98f00b204e9800998ecf8427e2c0b35a585c10d8242822adc59ddf187', '2017-08-29 11:35:10'),
(15, 28, 'd41d8cd98f00b204e9800998ecf8427ea27623968eb1f4bfe6c5ae3c4cf1a0bc', '2017-08-29 11:45:57'),
(16, 29, 'd41d8cd98f00b204e9800998ecf8427e8af04ea7fa3d2ae5723547b33059138c', '2017-09-12 01:57:45'),
(17, 30, 'd41d8cd98f00b204e9800998ecf8427eec1d37aa94e4983e92c215ea325b6b88', '2017-09-12 11:46:51'),
(18, 31, 'd41d8cd98f00b204e9800998ecf8427e173f0b108cab5ce4a7311f3e7a535d93', '2017-09-14 22:51:45'),
(19, 33, 'd41d8cd98f00b204e9800998ecf8427e3fccbc10419d72b9a70d9bc95cd875fa', '2017-09-16 15:34:29'),
(20, 34, 'd41d8cd98f00b204e9800998ecf8427ea8c1f8ca5f84d8fcf19b715768b21935', '2017-09-16 16:15:24'),
(21, 22, 'f3c52e5ef3d2b471d0ef51c66c21d10c3a413683eb99bc88898845153a3472d1', '2017-09-17 21:51:05'),
(22, 28, 'a0ccfdf030256cf5b8b8e5260e819c3ac81e87cc7b053d620f9497d6657171ff', '2017-09-17 17:53:11'),
(23, 28, 'a0ccfdf030256cf5b8b8e5260e819c3a7799ab3aaa37c6451de8d39ea2a57788', '2017-09-17 17:55:39'),
(26, 39, 'd41d8cd98f00b204e9800998ecf8427e4cd711f8312520303135426f17126cf7', '2017-09-17 23:10:27'),
(27, 40, 'd41d8cd98f00b204e9800998ecf8427e831664b6e0e0394751b6543f9d7d48de', '2017-09-17 23:16:42'),
(28, 41, 'd41d8cd98f00b204e9800998ecf8427e8010f652128f925b81f180baa38be46b', '2017-09-17 23:19:17'),
(30, 43, 'd41d8cd98f00b204e9800998ecf8427e1cc84c6611174c641a0f5d1784914ddc', '2017-09-17 23:43:30'),
(33, 46, 'd41d8cd98f00b204e9800998ecf8427effb19bcc969f4798a92748014bb6d3a1', '2017-09-17 23:54:24'),
(34, 47, 'd41d8cd98f00b204e9800998ecf8427efda16565e5a2c18afe584b55ccfa0d05', '2017-09-18 08:24:06');

--
-- Dumping data for table `datos_profesionales`
--

INSERT INTO `datos_profesionales` (`id`, `usuario_id`, `profesion_id`, `organizacion`, `trabajo`, `cv`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(2, 14, 1, 'ADSIB', 'Gerente de sistemas', NULL, '2017-08-26 22:37:46', '2017-08-26 22:37:46'),
(3, 17, 1, 'AGETIC', 'Analista de sistemas', '7edce3dfb58e76b803c2471fdea08df370efdf2ec9b086079795c442636b55fb.', '2017-08-26 22:55:47', '2017-08-26 22:55:47'),
(4, 22, 1, 'AGETIC', 'Analista de sistemas', 'f348dc6c57680b295193a0173bb31388b6d767d2f8ed5d21a44b0e5886680cb9.docx', '2017-08-26 23:10:26', '2017-08-26 23:10:26'),
(5, 28, 1, 'Vicepresidencia', 'Administrador de Base de Datos', 'a27623968eb1f4bfe6c5ae3c4cf1a0bc33e75ff09dd601bbe69f351039152189.pdf', '2017-08-29 11:45:57', '2017-08-29 11:45:57'),
(6, 31, 1, 'ADSIB', 'Programador', NULL, '2017-09-14 22:51:45', '2017-09-15 18:49:38'),
(7, 33, 1, 'Colegio 20 de octubre', 'Desarrolladora', NULL, '2017-09-16 15:34:29', '2017-09-16 15:34:29'),
(8, 34, 1, 'Universidad Catolica', 'Diseñadora', NULL, '2017-09-16 16:15:24', '2017-09-16 16:15:24'),
(9, 35, 1, 'Banco Union', 'ingrid@gmail.com', 'cb9c1af3c895bab13f1027c382b47ccc1c383cd30b7c298ab50293adfecb7b18.docx', '2017-09-17 12:38:02', '2017-09-17 12:38:02'),
(12, 39, 1, 'AGETIC', 'salva@gmail.com', NULL, '2017-09-17 23:10:27', '2017-09-17 23:10:27'),
(13, 40, 1, 'Universidad Franz Tamayo', 'Programadora', NULL, '2017-09-17 23:16:42', '2017-09-17 23:16:42'),
(14, 41, 1, 'Banco Central de Bolivia', 'Diseñadora', NULL, '2017-09-17 23:19:17', '2017-09-18 10:08:36'),
(16, 43, 1, 'Banco Unión', 'Administrador', NULL, '2017-09-17 23:43:30', '2017-09-17 23:43:30');

-- Dumping data for table `equipo`
--

INSERT INTO `equipo` (`id`, `ciudad_id`, `division_id`, `nombre_equipo`, `modelo_negocio_archivo`, `activo`, `fecha_creacion`, `fecha_actualizacion`, `imagen`) VALUES
(7, 1, 2, 'PachaX', NULL, 1, '2017-09-03 18:23:13', '2017-09-16 15:29:56', 'b1c5d5a5411ff0b3736c9b25cb7179ed8f14e45fceea167a5a36dedd4bea2543.jpg'),
(8, 2, 2, 'TraficcApp', NULL, 1, '2017-09-04 09:38:51', '2017-09-04 09:38:51', '4525a87da108578a406f08969f6e754302e74f10e0327ad868d138f2b4fdd6f0.jpg'),
(9, 1, 1, 'chicocos', NULL, 1, '2017-09-04 11:37:47', '2017-09-04 11:37:47', '02424a25cdbb7064d22ddeeb0ae55505e4da3b7fbbce2345d7772b0674a318d5.jpg'),
(12, 1, 2, 'Womanx', NULL, 1, '2017-09-16 16:33:06', '2017-09-16 16:33:06', 'ad9da98c3c65265202c9039015d0e055e369853df766fa44e1ed0ff613f563bd.jpg'),
(13, 1, 2, 'RoboCall', NULL, 1, '2017-09-17 23:21:21', '2017-09-17 23:21:21', 'b88c939bfdfadb391df588a5276c5e1bd67d8ab4f4c10bf22aa353e27879133c.jpg'),
(14, 1, 2, 'Save the Pacha', NULL, 1, '2017-09-17 23:45:37', '2017-09-17 23:45:37', '25e791655776aec80b19ee1d0662bda417e62166fc8586dfa4d1bc0e1742c08b.jpg'),
(15, 2, 2, 'Earth', NULL, 1, '2017-09-18 08:26:11', '2017-09-18 10:01:37', '95bfabf73e4648ac455108bed3a9d74f9bf31c7ff062936a96d3c8bd1f8f2ff3.jpg'),
(16, 1, 1, 'Trafico', NULL, 1, '2017-09-18 10:11:52', '2017-09-18 10:11:52', 'dda019c4576ce0849f430902f3035e19d645920e395fedad7bbbed0eca3fe2e0.jpg');


--
-- Dumping data for table `estudiante_mentor_tiene_equipo`
--

INSERT INTO `estudiante_mentor_tiene_equipo` (`id`, `equipo_id`, `mentor_id`, `estudiante_id`, `lider_equipo`, `aprobado`, `activo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 7, NULL, 7, 1, 1, 1, '2017-09-03 18:23:13', '2017-09-03 18:23:13'),
(2, 8, NULL, 11, 1, 1, 1, '2017-09-04 09:38:51', '2017-09-04 09:38:51'),
(3, 9, NULL, 4, 1, 1, 1, '2017-09-04 11:37:47', '2017-09-04 11:37:47'),
(4, 7, NULL, 8, 0, 1, 1, '2017-09-11 04:03:52', '2017-09-11 16:41:58'),
(5, 8, NULL, 8, 0, 0, 0, '2017-09-11 04:12:25', '2017-09-11 04:12:25'),
(6, 9, NULL, 8, 0, 0, 0, '2017-09-11 04:12:38', '2017-09-11 04:12:38'),
(7, 7, NULL, 9, 0, 1, 1, '2017-09-12 02:17:09', '2017-09-12 02:17:09'),
(8, 7, NULL, 12, 0, 0, 0, '2017-09-12 06:01:42', '2017-09-12 06:01:42'),
(9, 9, NULL, 10, 0, 1, 1, '2017-09-12 12:31:38', '2017-09-12 12:31:38'),
(10, 9, NULL, 12, 0, 1, 1, '2017-09-12 12:37:02', '2017-09-12 12:38:08'),
(11, 8, NULL, 13, 0, 0, 0, '2017-09-12 18:17:36', '2017-09-12 18:17:36'),
(12, 8, NULL, 13, 0, 0, 0, '2017-09-12 18:27:59', '2017-09-12 18:27:59'),
(13, 8, NULL, 13, 0, 0, 0, '2017-09-12 18:28:38', '2017-09-12 18:28:38'),
(14, 8, NULL, 13, 0, 0, 0, '2017-09-12 18:31:24', '2017-09-12 18:31:24'),
(15, 8, NULL, 13, 0, 0, 0, '2017-09-12 18:31:36', '2017-09-12 18:31:36'),
(16, 7, NULL, 13, 0, 0, 0, '2017-09-12 14:37:51', '2017-09-12 14:37:51'),
(17, 9, NULL, 13, 0, 1, 1, '2017-09-12 14:37:59', '2017-09-16 16:00:22'),
(19, 7, 5, NULL, 1, 1, 1, '2017-09-15 20:23:29', '2017-09-15 20:23:29'),
(20, 9, 6, NULL, 1, 1, 1, '2017-09-16 15:52:02', '2017-09-16 15:52:02'),
(21, 12, 7, NULL, 1, 1, 1, '2017-09-16 16:33:06', '2017-09-16 16:33:06'),
(22, 13, 10, NULL, 1, 1, 1, '2017-09-17 23:21:21', '2017-09-17 23:21:21'),
(23, 14, 14, NULL, 1, 1, 1, '2017-09-17 23:45:37', '2017-09-17 23:45:37'),
(24, 13, NULL, 16, 0, 1, 1, '2017-09-17 23:55:52', '2017-09-17 23:57:43'),
(25, 15, NULL, 17, 1, 1, 1, '2017-09-18 08:26:11', '2017-09-18 08:26:11'),
(26, 15, 12, NULL, 0, 1, 1, '2017-09-18 08:40:27', '2017-09-18 10:00:58'),
(27, 16, 11, NULL, 1, 1, 1, '2017-09-18 10:11:52', '2017-09-18 10:11:52');

--
-- Dumping data for table `imagen`
--

INSERT INTO `imagen` (`id`, `usuario_id`, `nombre_archivo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 8, '1cc47c421096a1973e0617473421c510c9f0f895fb98ab9159f51fd0297e236d.jpg', '2017-08-29 06:03:58', '2017-09-01 00:42:04'),
(2, 27, '1fab734ed5f0c2d0ce814b2af8c3582a02e74f10e0327ad868d138f2b4fdd6f0.jpg', '2017-08-29 15:42:08', '2017-08-29 15:42:08'),
(3, 5, 'e7b962ec9d3c6f0f74df2f69a5cbfd63e4da3b7fbbce2345d7772b0674a318d5.jpg', '2017-09-04 15:02:25', '2017-09-04 15:02:25'),
(4, 25, '4e026253d0cb84f1c291227e5cb8ba088e296a067a37563370ded05f5a3bf3ec.jpg', '2017-09-12 01:22:38', '2017-09-12 01:22:38'),
(5, 26, 'b83735f8e3a92eaef6fc7266ecdf789b4e732ced3463d06de0ca9a15b6153677.jpg', '2017-09-12 12:31:02', '2017-09-12 12:31:02'),
(6, 31, 'fa22291698fa95b3b7224d44a48b9a54c16a5320fa475530d9583c34fd356ef5.jpg', '2017-09-15 01:18:10', '2017-09-15 01:18:10'),
(7, 33, 'fa29dd03160463537b9cd9f41647c1f4182be0c5cdcd5072bb1864cdee4d3d6e.jpg', '2017-09-16 15:45:52', '2017-09-16 15:45:52'),
(8, 34, '83dd12b555e2bcccd12ea1b739da7c4ce369853df766fa44e1ed0ff613f563bd.jpg', '2017-09-16 16:17:41', '2017-09-16 16:17:41'),
(9, 39, 'f92704caadcc334015d8a68c3b3c4002d67d8ab4f4c10bf22aa353e27879133c.jpg', '2017-09-17 23:20:11', '2017-09-17 23:20:11'),
(10, 43, 'cb9688958b94d9baaf83ba3c110feef317e62166fc8586dfa4d1bc0e1742c08b.jpg', '2017-09-17 23:44:11', '2017-09-17 23:44:11'),
(11, 47, '74f3d38aab35ac4b83e01cbebff311ac67c6a1e7ce56d3d6fa748ab6d9af3fd7.jpg', '2017-09-18 08:25:11', '2017-09-18 08:25:11'),
(12, 41, '3ebd7df3538f23cec71f6db600209a703416a75f4cea9109507cacd8e2f2aefc.jpg', '2017-09-18 10:06:43', '2017-09-18 10:06:43'),
(13, 40, 'dcc1825fde25e06ff43a762c4ac3cd80d645920e395fedad7bbbed0eca3fe2e0.jpg', '2017-09-18 10:10:04', '2017-09-18 10:10:04');

--
-- Dumping data for table `invitaciones_equipo`
--

INSERT INTO `invitaciones_equipo` (`id`, `estudiante_id`, `mentor_id`, `equipo_id`, `confirmacion`, `fecha_creacion`, `fecha_actualizacion`, `activo`) VALUES
(2, 9, NULL, 7, 1, '2017-09-11 21:46:07', '2017-09-12 02:17:09', 1),
(3, 10, NULL, 9, 0, '2017-09-12 05:54:44', '2017-09-12 12:31:31', 0),
(4, 10, NULL, 9, 1, '2017-09-12 12:29:31', '2017-09-12 12:31:38', 1),
(5, 12, NULL, 9, 0, '2017-09-12 12:32:46', '2017-09-12 12:32:46', 1),
(6, 13, NULL, 9, 0, '2017-09-12 16:28:45', '2017-09-12 16:28:45', 1),
(7, 13, NULL, 7, 0, '2017-09-12 16:44:49', '2017-09-12 16:44:49', 1),
(11, NULL, 5, 7, 1, '2017-09-15 19:58:55', '2017-09-15 20:23:29', 1),
(12, NULL, 6, 9, 1, '2017-09-16 15:46:52', '2017-09-16 15:52:01', 1);


--
-- Dumping data for table `mentor_tiene_habilidad`
--

INSERT INTO `mentor_tiene_habilidad` (`id`, `experticia_id`, `habilidad_id`, `mentor_id`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 2, 1, 5, '2017-09-15 18:47:43', '2017-09-15 18:47:43'),
(2, 3, 2, 5, '2017-09-15 18:47:43', '2017-09-15 18:47:43'),
(3, 1, 3, 5, '2017-09-15 18:47:43', '2017-09-15 18:47:43'),
(4, 3, 4, 5, '2017-09-15 18:47:43', '2017-09-15 18:47:43'),
(5, 1, 5, 5, '2017-09-15 18:47:43', '2017-09-15 18:47:43'),
(6, 3, 1, 6, '2017-09-16 15:45:37', '2017-09-16 15:45:37'),
(7, 3, 2, 6, '2017-09-16 15:45:37', '2017-09-16 15:45:37'),
(8, 2, 3, 7, '2017-09-16 16:17:33', '2017-09-16 16:17:33'),
(9, 2, 1, 10, '2017-09-17 23:20:40', '2017-09-17 23:20:40'),
(10, 1, 2, 10, '2017-09-17 23:20:40', '2017-09-17 23:20:40'),
(11, 1, 3, 10, '2017-09-17 23:20:40', '2017-09-17 23:20:40'),
(12, 2, 1, 14, '2017-09-17 23:44:28', '2017-09-17 23:44:28'),
(13, 3, 3, 14, '2017-09-17 23:44:28', '2017-09-17 23:44:28'),
(14, 2, 1, 12, '2017-09-18 10:08:36', '2017-09-18 10:08:36'),
(15, 1, 2, 12, '2017-09-18 10:08:36', '2017-09-18 10:08:36'),
(16, 1, 3, 12, '2017-09-18 10:08:36', '2017-09-18 10:08:36'),
(17, 3, 5, 12, '2017-09-18 10:08:36', '2017-09-18 10:08:36'),
(18, 3, 3, 11, '2017-09-18 10:10:13', '2017-09-18 10:10:13');


--
-- Dumping data for table `proyecto`
--

INSERT INTO `proyecto` (`id`, `equipo_id`, `nombre_proyecto`, `codigo_fuente_archivo`, `plataforma`, `fecha_creacion`, `fecha_actualizacion`, `categoria_id`, `descripcion`) VALUES
(1, 7, 'PachaCUTI', NULL, NULL, '2017-09-03 18:23:13', '2017-09-04 23:36:05', 1, 'La app dara informacion sobre animales en peligro de extincion'),
(2, 8, '', NULL, NULL, '2017-09-04 09:38:51', '2017-09-04 09:38:51', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni modi omnis, deserunt iure quod saepe qui fugiat, inventore animi earum suscipit mollitia amet esse quibusdam excepturi maiores impedit vel repudiandae.'),
(3, 9, '', NULL, NULL, '2017-09-04 11:37:47', '2017-09-04 11:37:47', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste provident excepturi aliquam ducimus consectetur quaerat debitis ut commodi. Culpa nihil rem eveniet inventore. Mollitia rem corrupti delectus facere, error necessitatibus.'),
(4, 12, 'primero soy yo', NULL, NULL, '2017-09-16 16:33:06', '2017-09-16 16:33:06', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis nemo sequi ex modi quasi culpa expedita non corporis, vel provident nostrum, cumque ducimus ea. Officia adipisci laborum eaque quasi tempore.'),
(5, 13, 'Aplicacion para llamadas de emergencia', NULL, NULL, '2017-09-17 23:21:21', '2017-09-17 23:21:21', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae officiis delectus illo, enim maxime corrupti. Suscipit eum alias omnis, voluptates, maiores cumque minus consequuntur aperiam ratione, qui minima voluptatum, laboriosam!'),
(6, 14, 'Aplicacion para detectar lugares protegidos', NULL, NULL, '2017-09-17 23:45:37', '2017-09-17 23:45:37', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor est, dolores! Beatae sit suscipit accusantium, voluptatem totam rem veritatis voluptatum laborum nam, porro consequuntur repellat magni veniam dolorem. Maiores, eum.'),
(7, 15, 'Earth', NULL, NULL, '2017-09-18 08:26:11', '2017-09-18 08:26:11', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae perferendis modi ipsum molestiae, doloribus soluta tenetur dolore labore quibusdam nemo distinctio quos, ducimus alias ipsam inventore maxime accusamus consequatur fugiat.'),
(8, 16, 'Trafico', NULL, NULL, '2017-09-18 10:11:52', '2017-09-18 10:11:52', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate non deleniti officia at minus quidem beatae, alias quis, delectus perferendis saepe molestiae eos dolorum ullam neque, aut sit explicabo. Similique!');

--
-- Dumping data for table `reestablecer_password`
--

INSERT INTO `reestablecer_password` (`id`, `usuario_id`, `token`, `fecha_inicio`, `fecha_fin`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(9, 8, 'c9f0f895fb98ab9159f51fd0297e236d08dd2ee2ee118f6871f8d25c4f9cb1f9', '2017-09-03 13:12:30', '2017-09-06 13:12:30', '2017-09-03 13:12:30', '2017-09-03 13:12:30'),
(10, 27, '02e74f10e0327ad868d138f2b4fdd6f04706305f4abd230e793ab7b555be0b4b', '2017-09-04 09:29:55', '2017-09-07 09:29:55', '2017-09-04 09:29:55', '2017-09-04 09:29:55');

--
-- Dumping data for table `responsable`
--

INSERT INTO `responsable` (`id`, `estudiante_id`, `firma`, `fecha_creacion`) VALUES
(1, 7, 'Esther Jordan', '2017-08-28 18:32:08'),
(2, 11, 'Esther Jordan', '2017-08-29 11:40:47'),
(3, 11, 'Esther Jordan', '2017-08-29 11:40:51'),
(4, 11, 'Esther Jordan', '2017-08-29 11:40:52'),
(5, 11, 'Esther Jordan', '2017-08-29 11:40:52'),
(6, 11, 'Esther Jordan', '2017-08-29 11:41:43'),
(7, 4, 'Esther', '2017-09-04 11:02:14'),
(8, 9, 'Esther', '2017-09-11 21:21:55'),
(9, 10, 'Juan', '2017-09-12 08:30:27'),
(10, 17, 'Jose Carpio', '2017-09-18 08:24:53');





/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
