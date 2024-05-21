-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2024 a las 04:36:48
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
-- Base de datos: `nitalink2`
--

-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `nitalink2`
CHARACTER SET utf8mb4
COLLATE utf8mb4_spanish_ci;
USE `nitalink2`;


--
-- Estructura de tabla para la tabla `books_digital`
--

CREATE TABLE `books_digital` (
  `product_id` int(11) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `author` varchar(255) NOT NULL,
  `pages` int(11) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `publish_date` date NOT NULL,
  `availability_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `books_digital`
--

INSERT INTO `books_digital` (`product_id`, `isbn`, `author`, `pages`, `publisher`, `publish_date`, `availability_date`) VALUES
(6, '9782070612758', 'Antoine de Saint-Exupéry', 960, 'Gallimard', '1993-12-12', '1994-12-12 12:00:00'),
(7, '9780811213783', 'Jorge Luis Borges', 174, 'New Directions', '2024-01-01', '2024-01-02 00:00:00'),
(8, '9780307950929', 'Jorge Luis Borges', 224, 'Vintage Books', '2024-01-01', '2024-01-02 00:00:00'),
(9, '9780451524935', 'George Orwell', 328, 'Signet Classics', '2024-01-01', '2024-01-02 00:00:00'),
(10, '9780060850524', 'Aldous Huxley', 288, 'Harper Perennial', '2024-01-01', '2024-01-02 00:00:00'),
(23, '9788497592203', 'Umberto Eco', 528, 'Debolsillo', '2024-01-01', '2024-01-02 00:00:00'),
(24, '9780061120084', 'J.R.R. Tolkien', 366, 'HarperCollins', '2024-01-01', '2024-01-02 00:00:00'),
(25, '9780142437223', 'Dante Alighieri', 798, 'Penguin Classics', '2024-01-01', '2024-01-02 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books_physical`
--

CREATE TABLE `books_physical` (
  `product_id` int(11) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `author` varchar(255) NOT NULL,
  `pages` int(11) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `publish_date` date DEFAULT NULL,
  `availability_date` datetime DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `width` decimal(5,2) DEFAULT NULL,
  `length` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `fragile` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `books_physical`
--

INSERT INTO `books_physical` (`product_id`, `isbn`, `author`, `pages`, `publisher`, `publish_date`, `availability_date`, `height`, `width`, `length`, `weight`, `fragile`) VALUES
(2, '9780142437230', 'Miguel de Cervantes', 1072, 'Penguin Classics', '2024-01-01', '2024-01-02 01:00:00', 23.00, 15.00, 4.00, 0.80, 0),
(3, '9780307389732', 'Gabriel García Márquez', 348, 'Vintage Books', '2024-01-01', '2024-01-02 00:00:00', 21.00, 14.00, 2.50, 0.60, 0),
(4, '9788408163381', 'Carlos Ruiz Zafón', 569, 'Planeta', '2024-01-01', '2024-01-02 00:00:00', 22.00, 14.00, 3.50, 0.70, 0),
(5, '9786070104228', 'Julio Cortázar', 600, 'Alfaguara', '2024-01-01', '2024-01-02 00:00:00', 24.00, 16.00, 3.80, 0.75, 0),
(16, '9780307950929', 'Mario Vargas Llosa', 368, 'Vintage Books', '2024-01-01', '2024-01-02 00:00:00', 20.00, 13.00, 3.00, 0.60, 0),
(17, '9780060883287', 'Mario Vargas Llosa', 556, 'Harper Perennial', '2024-01-01', '2024-01-02 00:00:00', 22.00, 15.00, 3.50, 0.70, 0),
(18, '9780380733384', 'Ernesto Sabato', 184, 'Penguin Books', '2024-01-01', '2024-01-02 00:00:00', 20.00, 12.00, 2.50, 0.50, 0),
(19, '9788420471842', 'Juan Rulfo', 136, 'Debolsillo', '2024-01-01', '2024-01-02 00:00:00', 19.00, 12.00, 2.00, 0.40, 0),
(20, '9780553383805', 'Isabel Allende', 481, 'Dial Press', '2024-01-01', '2024-01-02 00:00:00', 21.00, 14.00, 3.00, 0.60, 0),
(21, '9780060932199', 'Mario Vargas Llosa', 544, 'Harper Perennial', '2024-01-01', '2024-01-02 00:00:00', 22.00, 15.00, 3.50, 0.70, 0),
(22, '9780061122415', 'Paulo Coelho', 208, 'HarperOne', '2024-01-01', '2024-01-02 00:00:00', 20.00, 13.00, 2.50, 0.50, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `membership_type` varchar(100) DEFAULT NULL,
  `account_balance` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `address`, `email`, `phone_number`, `membership_type`, `account_balance`) VALUES
(1, 'Empresa ', 'Calle Falsa 123, Madrid', 'empresa.alpha@correo.com', '60000000134', 'Premium', 100033),
(2, 'Juan Pérez', 'Calle Real 45, Barcelona', 'juan.perez@correo.com', '600000002', 'Standard', 500),
(3, 'Empresa Beta', 'Avenida Principal 67, Sevilla', 'empresa.beta@correo.com', '600000003', 'Premium', 1500),
(4, 'Ana García', 'Calle Menor 89, Valencia', 'ana.garcia@correo.com', '600000004', 'Premium', 750),
(5, 'Empresa Gamma', 'Plaza Mayor 101, Zaragoza', 'empresa.gamma@correo.com', '600000005', 'Gold', 2000),
(6, 'Luis Fernández', 'Calle Alta 23, Bilbao', 'luis.fernandez@correo.com', '600000006', 'Gold', 600),
(7, 'Empresa Delta', 'Avenida Secundaria 345, Málaga', 'empresa.delta@correo.com', '600000007', 'Gold', 1200),
(8, 'María López', 'Calle Baja 78, Murcia', 'maria.lopez@correo.com', '600000008', 'Gold', 650),
(9, 'Empresa Epsilon', 'Camino Verde 12, Granada', 'empresa.epsilon@correo.com', '600000009', 'Gold', 3000),
(10, 'Carlos González', 'Calle Azul 56, Alicante', 'carlos.gonzalez@correo.com', '600000010', 'Gold', 850),
(11, 'Empresa Zeta', 'Paseo del Parque 90, Córdoba', 'empresa.zeta@correo.com', '600000011', 'Gold', 3500),
(12, 'Laura Martínez', 'Calle Roja 43, Vigo', 'laura.martinez@correo.com', '600000012', 'Gold', 950),
(13, 'Empresa Eta', 'Carretera Amarilla 67, Gijón', 'empresa.eta@correo.com', '600000013', 'Gold', 2700),
(14, 'Pedro Sánchez', 'Calle Negra 89, Salamanca', 'pedro.sanchez@correo.com', '600000014', 'Gold', 800),
(15, 'Empresa Theta', 'Avenida Blanca 23, Tarragona', 'empresa.theta@correo.com', '600000015', 'Gold', 4000),
(16, 'Isabel Gómez', 'Calle Verde 45, León', 'isabel.gomez@correo.com', '600000016', 'Gold', 900),
(17, 'Empresa Iota', 'Plaza Roja 67, Santander', 'empresa.iota@correo.com', '600000017', 'Gold', 4200),
(18, 'Fernando Ruiz', 'Avenida Azul 89, Almería', 'fernando.ruiz@correo.com', '600000018', 'Gold', 980),
(19, 'Empresa Kappa', 'Calle Principal 101, Logroño', 'empresa.kappa@correo.com', '600000019', 'Gold', 3300),
(20, 'Marta Ramírez', 'Calle Menor 12, Oviedo', 'marta.ramirez@correo.com', '600000020', 'Gold', 870),
(21, 'Empresa Lambda', 'Calle Mayor 34, Palma', 'empresa.lambda@correo.com', '600000021', 'Gold', 4600),
(22, 'Diego Jiménez', 'Calle Alta 56, Burgos', 'diego.jimenez@correo.com', '600000022', 'Gold', 760),
(23, 'Empresa Mu', 'Avenida Verde 78, Badajoz', 'empresa.mu@correo.com', '600000023', 'Gold', 3700),
(24, 'Lucía Torres', 'Calle Roja 90, Albacete', 'lucia.torres@correo.com', '600000024', 'Gold', 640),
(25, 'Empresa Nu', 'Carretera Azul 123, Huelva', 'empresa.nu@correo.com', '600000025', 'Gold', 4800),
(26, 'Antonio Domínguez', 'Calle Falsa 123, Madrid', 'antonio.dominguez@correo.com', '600000026', 'Standard', 720),
(27, 'Empresa Xi', 'Avenida Principal 45, Cádiz', 'empresa.xi@correo.com', '600000027', 'Gold', 4100),
(28, 'Elena Moreno', 'Calle Alta 67, Castellón', 'elena.moreno@correo.com', '600000028', 'Standard', 680),
(29, 'Empresa Omicron', 'Calle Baja 89, Ceuta', 'empresa.omicron@correo.com', '600000029', 'Gold', 3900),
(30, 'Sergio Navarro', 'Plaza Menor 101, Melilla', 'sergio.navarro@correo.com', '600000030', 'Standard', 860),
(31, 'Empresa Pi', 'Calle Principal 123, Toledo', 'empresa.pi@correo.com', '600000031', 'Gold', 4500),
(32, 'Paula Castro', 'Calle Secundaria 45, La Coruña', 'paula.castro@correo.com', '600000032', 'Standard', 720),
(33, 'Empresa Rho', 'Avenida Baja 67, Ávila', 'empresa.rho@correo.com', '600000033', 'Gold', 3900),
(34, 'Alberto Serrano', 'Calle Alta 89, Cuenca', 'alberto.serrano@correo.com', '600000034', 'Standard', 900),
(35, 'Empresa Sigma', 'Plaza Mayor 101, Segovia', 'empresa.sigma@correo.com', '600000035', 'Gold', 4100),
(36, 'Rosa Ortiz', 'Calle Roja 123, Zamora', 'rosa.ortiz@correo.com', '600000036', 'Standard', 850),
(37, 'Empresa Tau', 'Avenida Azul 45, Soria', 'empresa.tau@correo.com', '600000037', 'Gold', 3700),
(38, 'Raúl Gil', 'Calle Verde 67, Guadalajara', 'raul.gil@correo.com', '600000038', 'Standard', 800),
(39, 'Empresa Upsilon', 'Plaza Negra 89, Teruel', 'empresa.upsilon@correo.com', '600000039', 'Gold', 4300),
(40, 'Eva Vázquez', 'Calle Principal 101, Huesca', 'eva.vazquez@correo.com', '600000040', 'Standard', 900),
(41, 'Empresa Phi', 'Calle Menor 123, Jaén', 'empresa.phi@correo.com', '600000041', 'Gold', 3700),
(42, 'José Molina', 'Avenida Secundaria 45, Pontevedra', 'jose.molina@correo.com', '600000042', 'Standard', 870),
(43, 'Empresa Chi', 'Calle Roja 67, Ourense', 'empresa.chi@correo.com', '600000043', 'Gold', 3600),
(44, 'Carmen Reyes', 'Calle Baja 89, Cáceres', 'carmen.reyes@correo.com', '600000044', 'Standard', 910),
(45, 'Empresa Psi', 'Plaza Alta 101, Ciudad Real', 'empresa.psi@correo.com', '600000045', 'Gold', 3800),
(46, 'Javier Herrera', 'Calle Negra 123, Lugo', 'javier.herrera@correo.com', '600000046', 'Standard', 940),
(47, 'Empresa Omega', 'Avenida Azul 45, Tarragona', 'empresa.omega@correo.com', '600000047', 'Gold', 4000),
(48, 'Natalia Flores', 'Calle Verde 67, Palma', 'natalia.flores@correo.com', '600000048', 'Standard', 860),
(49, 'Empresa Alpha II', 'Calle Baja 89, Ibiza', 'empresa.alpha2@correo.com', '600000049', 'Gold', 4200),
(50, 'Victor Castillo', 'Plaza Menor 101, Menorca', 'victor.castillo@correo.com', '600000050', 'Gold', 920);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companyclients`
--

CREATE TABLE `companyclients` (
  `client_id` int(11) NOT NULL,
  `workers` int(11) DEFAULT NULL,
  `social_reason` varchar(255) DEFAULT NULL,
  `client_type` varchar(7) NOT NULL DEFAULT 'Empresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `companyclients`
--

INSERT INTO `companyclients` (`client_id`, `workers`, `social_reason`, `client_type`) VALUES
(1, 502, 'Alpha Sociedad Anónima', 'Empresa'),
(3, 30, 'Beta Sociedad Limitada', 'Empresa'),
(5, 40, 'Gamma S.L.', 'Empresa'),
(7, 25, 'Delta S.A.', 'Empresa'),
(9, 20, 'Epsilon Corporación', 'Empresa'),
(11, 35, 'Zeta S.A.', 'Empresa'),
(13, 28, 'Eta Ltd.', 'Empresa'),
(15, 45, 'Theta Inc.', 'Empresa'),
(17, 32, 'Iota Sociedad Anónima', 'Empresa'),
(19, 50, 'Kappa S.L.', 'Empresa'),
(21, 22, 'Lambda Corp.', 'Empresa'),
(23, 38, 'Mu Sociedad Limitada', 'Empresa'),
(25, 44, 'Nu S.A.', 'Empresa'),
(27, 26, 'Xi Ltd.', 'Empresa'),
(29, 40, 'Omicron S.A.', 'Empresa'),
(31, 29, 'Pi Corporation', 'Empresa'),
(33, 33, 'Rho Ltd.', 'Empresa'),
(35, 36, 'Sigma Corp.', 'Empresa'),
(37, 42, 'Tau Inc.', 'Empresa'),
(39, 50, 'Upsilon Ltd.', 'Empresa'),
(41, 24, 'Phi Sociedad Anónima', 'Empresa'),
(43, 31, 'Chi S.L.', 'Empresa'),
(45, 39, 'Psi S.A.', 'Empresa'),
(47, 27, 'Omega Inc.', 'Empresa'),
(49, 28, 'Alpha II Sociedad Anónima', 'Empresa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companyproviders`
--

CREATE TABLE `companyproviders` (
  `provider_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `workers` int(11) NOT NULL,
  `social_reason` varchar(255) NOT NULL,
  `delivery_days` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `companyproviders`
--

INSERT INTO `companyproviders` (`provider_id`, `company_id`, `workers`, `social_reason`, `delivery_days`) VALUES
(6, 101, 50, 'Razón Social 1', 'Lunes,Miércoles,Viernes'),
(7, 102, 100, 'Razón Social 2', 'Martes,Jueves,Sábado'),
(8, 103, 150, 'Razón Social 3', 'Lunes,Martes,Miércoles'),
(9, 104, 200, 'Razón Social 4', 'Jueves,Viernes,Sábado'),
(10, 105, 250, 'Razón Social 5', 'Lunes,Miércoles,Viernes'),
(16, 106, 300, 'Razón Social 6', 'Martes,Jueves,Sábado'),
(17, 107, 350, 'Razón Social 7', 'Lunes,Martes,Miércoles'),
(18, 108, 400, 'Razón Social 8', 'Jueves,Viernes,Sábado'),
(19, 109, 450, 'Razón Social 9', 'Lunes,Miércoles,Viernes'),
(20, 110, 500, 'Razón Social 10', 'Martes,Jueves,Sábado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `product_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `language` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`product_id`, `duration`, `instructor`, `language`) VALUES
(11, 60, 'Pedro González Blanco', 'Español'),
(12, 80, 'Laura Martínez', 'Español'),
(13, 100, 'Carlos Fernández', 'Español'),
(14, 120, 'Ana Rodríguez', 'Español'),
(15, 90, 'Javier Pérez', 'Español'),
(27, 100, 'Lucía Hernández', 'Español'),
(28, 110, 'Marta Sánchez', 'Español'),
(29, 120, 'Sergio García', 'Español'),
(30, 130, 'Juan López', 'Español'),
(31, 140, 'Paula Torres', 'Español'),
(32, 90, 'Marcos Díaz', 'Español'),
(33, 80, 'Sara Ruiz', 'Español'),
(34, 70, 'David Muñoz', 'Español'),
(35, 110, 'Irene Gómez', 'Español'),
(36, 120, 'Miguel Ortiz', 'Español'),
(37, 130, 'Alicia Jiménez', 'Español'),
(38, 140, 'José Martínez', 'Español'),
(39, 150, 'Laura Sánchez', 'Español'),
(40, 160, 'Rosa Pérez', 'Español'),
(41, 90, 'Francisco García', 'Español'),
(42, 100, 'Carmen Hernández', 'Español'),
(43, 110, 'Antonio Fernández', 'Español'),
(44, 120, 'María Torres', 'Español'),
(45, 130, 'Jorge Ruiz', 'Español'),
(46, 140, 'Elena Muñoz', 'Español'),
(47, 150, 'Luis Pérez', 'Español'),
(48, 160, 'Ángel Díaz', 'Español'),
(49, 170, 'Isabel Sánchez', 'Español');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `individualclients`
--

CREATE TABLE `individualclients` (
  `client_id` int(11) NOT NULL,
  `dni` varchar(50) DEFAULT NULL,
  `client_type` varchar(10) NOT NULL DEFAULT 'Particular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `individualclients`
--

INSERT INTO `individualclients` (`client_id`, `dni`, `client_type`) VALUES
(2, '12345678Z', 'Particular'),
(4, '87654321X', 'Particular'),
(6, '11223344A', 'Particular'),
(8, '44332211B', 'Particular'),
(10, '55667788C', 'Particular'),
(12, '99887766D', 'Particular'),
(14, '66778899E', 'Particular'),
(16, '44556677F', 'Particular'),
(18, '22334455G', 'Particular'),
(20, '33445566H', 'Particular'),
(22, '77889900I', 'Particular'),
(24, '99001122J', 'Particular'),
(26, '11002233K', 'Particular'),
(28, '55443322L', 'Particular'),
(30, '33221100M', 'Particular'),
(32, '77665544N', 'Particular'),
(34, '88990011O', 'Particular'),
(36, '44557788P', 'Particular'),
(38, '22331144Q', 'Particular'),
(40, '66770088R', 'Particular'),
(42, '11004422S', 'Particular'),
(44, '99881122T', 'Particular'),
(46, '55446677U', 'Particular'),
(48, '66778899V', 'Particular'),
(50, '33225544W', 'Particular');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `individualproviders`
--

CREATE TABLE `individualproviders` (
  `provider_id` int(11) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `delivery_days` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `individualproviders`
--

INSERT INTO `individualproviders` (`provider_id`, `dni`, `delivery_days`) VALUES
(1, '12345678A', 'Lunes,Miércoles,Viernes'),
(2, '23456789B', 'Martes,Jueves,Sábado'),
(3, '34567890C', 'Lunes,Martes,Miércoles'),
(4, '45678901D', 'Jueves,Viernes,Sábado'),
(5, '56789012E', 'Lunes,Miércoles,Viernes'),
(11, '67890123F', 'Martes,Jueves,Sábado'),
(12, '78901234G', 'Lunes,Martes,Miércoles'),
(13, '89012345H', 'Jueves,Viernes,Sábado'),
(14, '90123456I', 'Lunes,Miércoles,Viernes'),
(15, '01234567J', 'Martes,Jueves,Sábado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_type` varchar(15) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `quantity`, `product_type`, `image_url`) VALUES
(2, 'Don Quijote de la Mancha prueba', 30.00, 20, 'Libro Físico', 'https://cdn.pixabay.com/photo/2022/11/18/16/37/man-7600526_640.jpg'),
(3, 'El Amor en los Tiempos del Cólera', 20.00, 10, 'Libro Físico', 'https://cdn.pixabay.com/photo/2022/12/17/04/41/ai-generated-7660971_640.jpg'),
(4, 'La Sombra del Viento', 22.00, 25, 'Libro Físico', 'https://cdn.pixabay.com/photo/2023/03/12/20/37/road-7847795_1280.jpg'),
(5, 'Rayuela', 18.00, 12, 'Libro Físico', 'https://cdn.pixabay.com/photo/2022/10/27/20/26/house-7551753_640.jpg'),
(6, 'El Principito', 5.00, 50, 'Libro Digital', 'https://cdn.pixabay.com/photo/2022/09/26/01/14/skeleton-7479456_640.png'),
(7, 'Ficciones', 7.00, 40, 'Libro Digital', 'https://example.com/images/ficciones.jpg'),
(8, 'El Aleph', 6.00, 45, 'Libro Digital', 'https://example.com/images/el_aleph.jpg'),
(9, '1984', 8.00, 30, 'Libro Digital', 'https://example.com/images/1984.jpg'),
(10, 'Brave New World', 9.00, 35, 'Libro Digital', 'https://example.com/images/brave_new_world.jpg'),
(11, 'Curso de Programación en Python ', 50.00, 100, 'Curso', 'https://example.com/images/curso_programacion_python.jpg'),
(12, 'Curso de Data Science', 70.00, 80, 'Curso', 'https://example.com/images/curso_data_science.jpg'),
(13, 'Curso de Machine Learning', 90.00, 60, 'Curso', 'https://example.com/images/curso_machine_learning.jpg'),
(14, 'Curso de Inteligencia Artificial', 120.00, 40, 'Curso', 'https://example.com/images/curso_inteligencia_artificial.jpg'),
(15, 'Curso de Desarrollo Web', 100.00, 70, 'Curso', 'https://example.com/images/curso_desarrollo_web.jpg'),
(16, 'La Ciudad y los Perros', 15.00, 15, 'Libro Físico', 'https://example.com/images/la_ciudad_y_los_perros.jpg'),
(17, 'Conversación en La Catedral', 18.00, 15, 'Libro Físico', 'https://example.com/images/conversacion_en_la_catedral.jpg'),
(18, 'El Tunel', 12.00, 10, 'Libro Físico', 'https://example.com/images/el_tunel.jpg'),
(19, 'Pedro Páramo', 14.00, 12, 'Libro Físico', 'https://example.com/images/pedro_paramo.jpg'),
(20, 'La Casa de los Espíritus', 16.00, 20, 'Libro Físico', 'https://example.com/images/la_casa_de_los_espiritus.jpg'),
(21, 'La Fiesta del Chivo', 20.00, 25, 'Libro Físico', 'https://example.com/images/la_fiesta_del_chivo.jpg'),
(22, 'El Alquimista', 12.00, 30, 'Libro Físico', 'https://example.com/images/el_alquimista.jpg'),
(23, '1984', 8.00, 30, 'Libro Digital', 'https://example.com/images/1984.jpg'),
(24, 'El Nombre de la Rosa', 15.00, 35, 'Libro Digital', 'https://example.com/images/el_nombre_de_la_rosa.jpg'),
(25, 'El Hobbit', 10.00, 40, 'Libro Digital', 'https://example.com/images/el_hobbit.jpg'),
(26, 'La Divina Comedia', 20.00, 30, 'Libro Digital', 'https://example.com/images/la_divina_comedia.jpg'),
(27, 'Curso de Marketing Digital', 150.00, 20, 'Curso', 'https://example.com/images/curso_marketing_digital.jpg'),
(28, 'Curso de Fotografía', 100.00, 15, 'Curso', 'https://example.com/images/curso_fotografia.jpg'),
(29, 'Curso de Java', 220.00, 10, 'Curso', 'https://example.com/images/curso_java.jpg'),
(30, 'Curso de SQL', 180.00, 25, 'Curso', 'https://example.com/images/curso_sql.jpg'),
(31, 'Curso de Kubernetes', 200.00, 20, 'Curso', 'https://example.com/images/curso_kubernetes.jpg'),
(32, 'Curso de Docker', 170.00, 30, 'Curso', 'https://example.com/images/curso_docker.jpg'),
(33, 'Curso de Big Data', 190.00, 15, 'Curso', 'https://example.com/images/curso_big_data.jpg'),
(34, 'Curso de Python Avanzado', 120.00, 40, 'Curso', 'https://example.com/images/curso_python_avanzado.jpg'),
(35, 'Curso de Desarrollo de Apps', 110.00, 50, 'Curso', 'https://example.com/images/curso_desarrollo_apps.jpg'),
(36, 'Curso de Frontend', 130.00, 45, 'Curso', 'https://example.com/images/curso_frontend.jpg'),
(37, 'Curso de Backend', 140.00, 40, 'Curso', 'https://example.com/images/curso_backend.jpg'),
(38, 'Curso de UX/UI', 100.00, 35, 'Curso', 'https://example.com/images/curso_ux_ui.jpg'),
(39, 'Curso de Ciberseguridad', 90.00, 30, 'Curso', 'https://example.com/images/curso_ciberseguridad.jpg'),
(40, 'Curso de DevOps', 120.00, 25, 'Curso', 'https://example.com/images/curso_devops.jpg'),
(41, 'Curso de Blockchain', 150.00, 20, 'Curso', 'https://example.com/images/curso_blockchain.jpg'),
(42, 'Curso de Criptografía', 160.00, 15, 'Curso', 'https://example.com/images/curso_criptografia.jpg'),
(43, 'Curso de IA', 140.00, 20, 'Curso', 'https://example.com/images/curso_ia.jpg'),
(44, 'Curso de VR/AR', 180.00, 10, 'Curso', 'https://example.com/images/curso_vr_ar.jpg'),
(45, 'Curso de Robótica', 200.00, 15, 'Curso', 'https://example.com/images/curso_robotica.jpg'),
(46, 'Curso de IoT', 220.00, 10, 'Curso', 'https://example.com/images/curso_iot.jpg'),
(47, 'Curso de Cloud Computing', 190.00, 20, 'Curso', 'https://example.com/images/curso_cloud_computing.jpg'),
(48, 'Curso de Redes', 170.00, 15, 'Curso', 'https://example.com/images/curso_redes.jpg'),
(49, 'Curso de Sistemas Operativos', 160.00, 25, 'Curso', 'https://example.com/images/curso_sistemas_operativos.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `provider_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `product_supplied` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`provider_id`, `name`, `address`, `email`, `phone_number`, `product_supplied`) VALUES
(1, 'Proveedor Individual 1', 'Calle Falsa 123, Ciudad', 'ind1@example.com', '600123456', 'Producto A'),
(2, 'Proveedor Individual 2', 'Avenida Siempre Viva 742, Ciudad', 'ind2@example.com', '600234567', 'Producto B'),
(3, 'Proveedor Individual 3', 'Calle de la Luna 45, Ciudad', 'ind3@example.com', '600345678', 'Producto C'),
(4, 'Proveedor Individual 4', 'Calle del Sol 78, Ciudad', 'ind4@example.com', '600456789', 'Producto D'),
(5, 'Proveedor Individual 5', 'Avenida del Mar 12, Ciudad', 'ind5@example.com', '600567890', 'Producto E'),
(6, 'Proveedor Empresa 1', 'Calle del Comercio 99, Ciudad', 'emp1@example.com', '600678901', 'Producto F'),
(7, 'Proveedor Empresa 2', 'Boulevard Industrial 34, Ciudad', 'emp2@example.com', '600789012', 'Producto G'),
(8, 'Proveedor Empresa 3', 'Calle de las Empresas 56, Ciudad', 'emp3@example.com', '600890123', 'Producto H'),
(9, 'Proveedor Empresa 4', 'Avenida Corporativa 89, Ciudad', 'emp4@example.com', '600901234', 'Producto I'),
(10, 'Proveedor Empresa 5', 'Calle Comercial 77, Ciudad', 'emp5@example.com', '600123789', 'Producto J'),
(11, 'Proveedor Individual 6', 'Calle Nueva 11, Ciudad', 'ind6@example.com', '600321456', 'Producto K'),
(12, 'Proveedor Individual 7', 'Avenida Vieja 22, Ciudad', 'ind7@example.com', '600432567', 'Producto L'),
(13, 'Proveedor Individual 8', 'Boulevard Moderno 33, Ciudad', 'ind8@example.com', '600543678', 'Producto M'),
(14, 'Proveedor Individual 9', 'Calle Antigua 44, Ciudad', 'ind9@example.com', '600654789', 'Producto N'),
(15, 'Proveedor Individual 10', 'Avenida Central 55, Ciudad', 'ind10@example.com', '600765890', 'Producto O'),
(16, 'Proveedor Empresa 6', 'Calle Urbana 66, Ciudad', 'emp6@example.com', '600876901', 'Producto P'),
(17, 'Proveedor Empresa 7', 'Avenida Metropolis 77, Ciudad', 'emp7@example.com', '600987012', 'Producto Q'),
(18, 'Proveedor Empresa 8', 'Boulevard Central 88, Ciudad', 'emp8@example.com', '600098123', 'Producto R'),
(19, 'Proveedor Empresa 9', 'Calle Principal 99, Ciudad', 'emp9@example.com', '600109234', 'Producto S'),
(20, 'Proveedor Empresa 10', 'Avenida Principal 100, Ciudad', 'emp10@example.com', '600120345', 'Producto T');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('client','employee','provider') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `type`) VALUES
(1, 'Dani', 'dani', 'employee'),
(2, 'Ivan', 'ivan', 'client'),
(3, 'Albert', 'albert', 'provider'),
(4, 'Ivan algo', 'hola', 'employee');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `books_digital`
--
ALTER TABLE `books_digital`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indices de la tabla `books_physical`
--
ALTER TABLE `books_physical`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `companyclients`
--
ALTER TABLE `companyclients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indices de la tabla `companyproviders`
--
ALTER TABLE `companyproviders`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `individualclients`
--
ALTER TABLE `individualclients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indices de la tabla `individualproviders`
--
ALTER TABLE `individualproviders`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`provider_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `books_digital`
--
ALTER TABLE `books_digital`
  ADD CONSTRAINT `books_digital_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Filtros para la tabla `books_physical`
--
ALTER TABLE `books_physical`
  ADD CONSTRAINT `books_physical_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Filtros para la tabla `companyclients`
--
ALTER TABLE `companyclients`
  ADD CONSTRAINT `companyclients_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `companyproviders`
--
ALTER TABLE `companyproviders`
  ADD CONSTRAINT `companyproviders_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`provider_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Filtros para la tabla `individualclients`
--
ALTER TABLE `individualclients`
  ADD CONSTRAINT `individualclients_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `individualproviders`
--
ALTER TABLE `individualproviders`
  ADD CONSTRAINT `individualproviders_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`provider_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

