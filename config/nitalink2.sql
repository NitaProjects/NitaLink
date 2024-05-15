-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2024 a las 03:52:11
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
  `availability_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `books_digital`
--

INSERT INTO `books_digital` (`product_id`, `isbn`, `author`, `pages`, `publisher`, `publish_date`, `availability_date`) VALUES
(11, '9781593279288', 'Mark Lutz', 1640, 'OReilly Media', '2019-07-31', '2019-08-10'),
(12, '9780134379093', 'Robert Lafore', 800, 'Prentice Hall', '2004-05-14', '2004-06-01'),
(13, '9781449319274', 'Ethan Marcotte', 320, 'A Book Apart', '2012-10-01', '2012-11-01'),
(14, '9780137081073', 'Ryan Stephens', 480, 'Addison-Wesley Professional', '2011-04-01', '2011-04-15'),
(15, '9780134845623', 'Andreas Mueller', 400, 'OReilly Media', '2016-03-01', '2016-03-15'),
(16, '9781484226032', 'Daniel Drescher', 256, 'Apress', '2017-03-01', '2017-04-01'),
(17, '9781119096726', 'Bruce Schneier', 784, 'John Wiley & Sons', '2015-10-01', '2015-11-01'),
(18, '9780262035613', 'Ian Goodfellow', 800, 'MIT Press', '2016-11-18', '2016-12-01'),
(19, '9780136042594', 'Stuart Russell', 1152, 'Pearson', '2009-12-11', '2010-01-01');

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
  `publish_date` date NOT NULL,
  `availability_date` date NOT NULL,
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
(1, '9780134685991', 'Joshua Bloch', 416, 'Addison-Wesley', '2018-05-11', '2018-06-01', 23.50, 15.60, 3.20, 0.78, 0),
(2, '9780132350884', 'Robert C. Martin', 464, 'Prentice Hall', '2008-08-01', '2008-08-15', 23.00, 17.00, 2.50, 0.54, 0),
(3, '9780486415871', 'Fiódor Dostoyevski', 671, 'Penguin Books', '2002-04-02', '2002-04-20', 19.80, 12.90, 4.10, 0.75, 0),
(4, '9780451524935', 'George Orwell', 328, 'Editorial Planeta', '2017-01-01', '2017-01-15', 21.00, 14.80, 2.20, 0.40, 0),
(5, '9780321751041', 'Donald E. Knuth', 3168, 'Addison-Wesley', '2011-03-03', '2011-03-18', 24.10, 17.10, 15.20, 2.91, 0),
(6, '9780061122415', 'Paulo Coelho', 208, 'HarperCollins', '1993-05-01', '1993-05-15', 20.00, 13.00, 2.00, 0.25, 0),
(7, '9788420412146', 'Miguel de Cervantes', 1344, 'Santillana', '2005-05-22', '2005-06-01', 21.00, 14.00, 5.50, 1.80, 1),
(8, '9780553212044', 'Dante Alighieri', 928, 'Bantam Classics', '1982-01-01', '1982-02-01', 17.80, 11.00, 4.30, 0.68, 0),
(9, '9780142437247', 'Herman Melville', 720, 'Penguin Classics', '2001-12-01', '2002-01-01', 19.00, 13.00, 3.80, 0.77, 0),
(10, '9780451488336', 'Ken Follett', 1104, 'Viking', '1989-09-01', '1989-10-01', 24.00, 16.00, 6.00, 1.40, 0);

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
(2, 'Jane Smith', '456 Oak St', 'jane.smith@example.com', '555-5678', 'Standard', 85.5),
(3, 'Carlos Ray', '789 Pine St', 'carlos.ray@example.com', '555-8765', 'Gold', 200),
(4, 'Alice Johnson', '321 Maple St', 'alice.johnson@example.com', '555-4321', 'Standard', 120);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companyclients`
--

CREATE TABLE `companyclients` (
  `client_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `workers` int(11) DEFAULT NULL,
  `social_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `companyclients`
--

INSERT INTO `companyclients` (`client_id`, `company_id`, `workers`, `social_reason`) VALUES
(4, 101, 50, 'Tech Innovations Inc.');

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
(21, 120, 'Juan Pérez', 'Español'),
(22, 100, 'Ana Gómez', 'Español'),
(23, 90, 'Carlos López', 'Español'),
(24, 110, 'Diana Ramírez', 'Español'),
(25, 130, 'Miguel Ángel', 'Español'),
(26, 120, 'Laura Martínez', 'Español'),
(27, 150, 'Pablo Fernández', 'Español'),
(28, 160, 'Sofía Castro', 'Español'),
(29, 180, 'Enrique Juárez', 'Español'),
(30, 200, 'Beatriz González', 'Español');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `individualclients`
--

CREATE TABLE `individualclients` (
  `client_id` int(11) NOT NULL,
  `dni` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `individualclients`
--

INSERT INTO `individualclients` (`client_id`, `dni`) VALUES
(2, '23456789E'),
(3, '34567812Q');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_type` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `quantity`, `product_type`) VALUES
(1, 'Java Efectivo', 45.00, 10, 'Libro físico'),
(2, 'Código Limpio', 35.00, 15, 'Libro físico'),
(3, 'Crimen y Castigo', 25.00, 10, 'Libro físico'),
(4, '1984', 30.00, 8, 'Libro físico'),
(5, 'El Arte de la Programación', 120.00, 4, 'Libro físico'),
(6, 'El Alquimista', 22.00, 12, 'Libro físico'),
(7, 'Don Quijote', 40.00, 7, 'Libro físico'),
(8, 'La Divina Comedia', 33.00, 5, 'Libro físico'),
(9, 'Moby Dick', 19.00, 6, 'Libro físico'),
(10, 'Los Pilares de la Tierra', 38.00, 9, 'Libro físico'),
(11, 'Python para Todos', 20.00, 30, 'Libro digital'),
(12, 'Estructuras de Datos en Java', 25.00, 25, 'Libro digital'),
(13, 'Diseño Web Moderno', 30.00, 20, 'Libro digital'),
(14, 'Fundamentos de SQL', 28.00, 15, 'Libro digital'),
(15, 'Aprendizaje Automático para Principiantes', 45.00, 10, 'Libro digital'),
(16, 'Blockchain Básico', 55.00, 8, 'Libro digital'),
(17, 'Criptografía Aplicada', 60.00, 12, 'Libro digital'),
(18, 'Redes Neuronales', 50.00, 20, 'Libro digital'),
(19, 'Inteligencia Artificial', 70.00, 15, 'Libro digital'),
(20, 'JavaScript Avanzado', 40.00, 5, 'Libro digital'),
(21, 'Curso de Desarrollo Web', 200.00, 30, 'Curso'),
(22, 'Curso de Marketing Digital', 150.00, 20, 'Curso'),
(23, 'Curso de Fotografía', 100.00, 15, 'Curso'),
(24, 'Curso de Python', 180.00, 25, 'Curso'),
(25, 'Curso de Java', 220.00, 10, 'Curso'),
(26, 'Curso de C++', 150.00, 20, 'Curso'),
(27, 'Curso de Diseño Gráfico', 130.00, 30, 'Curso'),
(28, 'Curso de Animación', 250.00, 10, 'Curso'),
(29, 'Curso de Seguridad Informática', 300.00, 12, 'Curso'),
(30, 'Curso de Gestión de Proyectos', 280.00, 15, 'Curso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `password` varchar(20) NOT NULL,
  `type` enum('client','employee','provider') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `type`) VALUES
(1, 'Dani', 'dani', 'employee'),
(2, 'Ivan', 'ivan', 'client'),
(3, 'Albert', 'albert', 'provider'),
(4, 'Dani JR', 'danijr', 'client'),
(5, 'Javivi', 'javivi', 'client'),
(6, 'dime', 'adi', 'client');

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
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

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
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Filtros para la tabla `individualclients`
--
ALTER TABLE `individualclients`
  ADD CONSTRAINT `individualclients_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
