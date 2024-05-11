-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2024 a las 02:41:02
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
-- Base de datos: `nitalink`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE `books` (
  `product_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `pages` int(11) NOT NULL,
  `publisher` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`product_id`, `author`, `pages`, `publisher`) VALUES
(1, 'R. A. Adams', 600, 'Pearson'),
(2, 'J. Random', 320, 'Oxford Press'),
(3, 'I. M. Chemist', 400, 'Springer'),
(4, 'N/A', 0, 'N/A'),
(5, 'N/A', 0, 'N/A'),
(6, '23', 23, '23');

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
  `client_type` varchar(50) DEFAULT NULL,
  `account_balance` decimal(10,2) DEFAULT NULL,
  `membership_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`client_id`, `name`, `address`, `email`, `phone_number`, `client_type`, `account_balance`, `membership_type`) VALUES
(1, 'Juan Pérez', 'Calle Sol 123', 'juan.perezosa@example.com', '1234567890', 'particular', 100.00, 'Gold'),
(2, 'Maria López', 'Avenida Luna 456', 'maria.lopez@example.com', '2345678901', 'empresa', 1500.00, 'Premium'),
(3, 'Carlos Jimenez', 'Calle Estrella 789', 'carlos.jimenez@example.com', '3456789012', 'particular', 200.00, 'Standard'),
(4, 'Ana Torres', 'Avenida Cometa 321', 'ana.torres@example.com', '4567890123', 'empresa', 3000.00, 'Gold'),
(5, 'Roberto Gómez', 'Calle Lago 654', 'roberto.gomez@example.com', '5678901234', 'particular', 250.00, 'Gold'),
(6, 'Lucia Fernández', 'Avenida Río 987', 'lucia.fernandez@example.com', '6789012345', 'empresa', 3500.00, 'Premium'),
(7, 'David Martín', 'Calle Bosque 135', 'david.martin@example.com', '7890123456', 'particular', 300.00, 'Standard'),
(8, 'Sofia Castro', 'Avenida Montaña 246', 'sofia.castro@example.com', '8901234567', 'empresa', 2200.00, 'Gold'),
(9, 'Oscar Ruiz', 'Calle Océano 357', 'oscar.ruiz@example.com', '9012345678', 'particular', 450.00, 'Premium'),
(10, 'Laura Díaz', 'Avenida Nube 468', 'laura.diaz@example.com', '0123456789', 'empresa', 1200.00, 'Standard'),
(11, 'Pepito ', 'quinto pino', 'danielnita.cefpnuria@gmail.com', '722353895', 'particular', 400.00, 'Gold');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companydata`
--

CREATE TABLE `companydata` (
  `company_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `company_workers` int(11) DEFAULT NULL,
  `corporate_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `companydata`
--

INSERT INTO `companydata` (`company_id`, `client_id`, `company_workers`, `corporate_reason`) VALUES
(1, 2, 50, 'Innovaciones S.A.'),
(2, 4, 120, 'Construcciones XYZ'),
(3, 6, 200, 'Tecnologías Avanzadas Ltd.'),
(4, 8, 300, 'Renovables S.A.'),
(5, 10, 30, 'Logística Integral Corp.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `product_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`product_id`, `duration`, `instructor`, `language`) VALUES
(1, 0, 'N/A', 'N/A'),
(2, 0, 'N/A', 'N/A'),
(3, 0, 'N/A', 'N/A'),
(4, 20, 'Jose Fernandez', 'Spanish'),
(5, 150, 'Anna Smith', 'English');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`employee_id`, `name`, `address`, `email`, `phone_number`, `department`, `salary`) VALUES
(1, 'Daniel Roberts', '1st Street', 'daniel@example.com', 5562345, 'HRM', 50000.00),
(2, 'Esther Adams', '2nd Street', 'esther@example.com', 5567890, 'Marketing', 45000.00),
(3, 'Fiona Glen', '3rd Street', 'fiona@example.com', 5563456, 'Engineering', 55000.00),
(4, 'George Harris', '4th Street', 'george@example.com', 5569087, 'Sales', 40000.00),
(5, 'Ivy Jacks', '5th Street', 'ivy@example.com', 5565678, 'Engineering', 60000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operations`
--

CREATE TABLE `operations` (
  `operation_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `date_time` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operations`
--

INSERT INTO `operations` (`operation_id`, `customer_name`, `date_time`, `total_amount`) VALUES
(1, 'Ana Ruiz', '2024-04-24 14:00:00', 180.00),
(2, 'Luis Molina', '2024-04-25 15:30:00', 0.00),
(3, 'Clara Jiménez', '2024-04-26 16:45:00', 0.00),
(4, 'Marco Antonio', '2024-04-27 17:00:00', 0.00),
(5, 'Sofía Castillo', '2024-04-28 18:20:00', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `operation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_details`
--

INSERT INTO `order_details` (`operation_id`, `product_id`, `quantity`, `unit_price`, `discount`) VALUES
(1, 1, 2, 100.00, 10.00),
(2, 3, 1, 19.99, 0.00),
(3, 4, 3, 39.99, 10.00),
(5, 5, 2, 24.99, 20.00);

--
-- Disparadores `order_details`
--
DELIMITER $$
CREATE TRIGGER `update_total_amount_after_insert` AFTER INSERT ON `order_details` FOR EACH ROW BEGIN
    UPDATE operations
    SET total_amount = total_amount + (NEW.unit_price * NEW.quantity * (1 - NEW.discount / 100))
    WHERE operation_id = NEW.operation_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_amount_after_update` AFTER UPDATE ON `order_details` FOR EACH ROW BEGIN
    UPDATE operations
    SET total_amount = total_amount - (OLD.unit_price * OLD.quantity * (1 - OLD.discount / 100)) + (NEW.unit_price * NEW.quantity * (1 - NEW.discount / 100))
    WHERE operation_id = OLD.operation_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `quantity` int(11) DEFAULT 0,
  `product_type` enum('book','course') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `discount_percent`, `quantity`, `product_type`) VALUES
(1, 'Advanced Mathematics', 50.00, 10.00, 3, 'book'),
(2, 'Introduction to Philosophy', 40.00, 0.00, 1, 'book'),
(3, 'Organic Chemistry', 60.00, 5.00, 4, 'book'),
(4, 'Learning Spanish', 30.00, 0.00, 2, 'course'),
(5, 'Digital Marketing 101', 45.00, 20.00, 2, 'course'),
(6, 'ada', 23.00, 0.00, 23, 'book');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `provider_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `product_supplied` varchar(255) NOT NULL,
  `delivery_days` text NOT NULL,
  `company_workers` int(11) DEFAULT NULL,
  `corporate_reason` varchar(255) DEFAULT NULL,
  `provider_type` varchar(255) DEFAULT 'particular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`provider_id`, `name`, `address`, `email`, `phone_number`, `product_supplied`, `delivery_days`, `company_workers`, `corporate_reason`, `provider_type`) VALUES
(1, 'SupplyCo', '100 Industry Way', 'contact@supplyco.com', 5571234, 'Electronics', '[\"Monday\", \"Wednesday\", \"Friday\"]', 300, 'SupplyCo Inc.', 'empresa'),
(2, 'PartsPros', '200 Parts Rd', 'info@partspros.com', 5575678, 'Automotive', '[\"Tuesday\", \"Thursday\"]', 150, 'Parts Professionals LLC', 'empresa'),
(3, 'GadgetGuru', '300 Tech Ave', 'support@gadgetguru.com', 5579101, 'Gadgets', 'null', 23, 'Dani SL', 'particular'),
(4, 'BuildIt', '400 Construction Ln', 'sales@buildit.com', 5571213, 'Construction', '[\"Lunes\", \"Miércoles\", \"Viernes\"]', 120, 'BuildIt Supplies Ltd', 'empresa'),
(5, 'FarmFinds', '500 Agriculture St', 'service@farmfinds.com', 5571415, 'Agriculture', '[\"Lunes\", \"Martes\"]', NULL, NULL, 'particular'),
(6, 'Proveedor Uno', 'Calle Falsa 123', 'contacto@proveedoruno.com', 555123456, 'Electrónica', '[\"Lunes\", \"Martes\"]', NULL, NULL, 'particular'),
(7, 'Proveedor Dos', 'Avenida Siempreviva 742', 'info@proveedordos.com', 555654321, 'Ropa', '[\"Lunes\", \"Martes\" , \"Miércoles\"]', 50, 'Proveedor Dos S.A.', 'empresa'),
(8, 'Proveedor Tres', 'Camino Largo 456', 'ventas@proveedortres.com', 555987654, 'Accesorios', '[\"Lunes\", \"Miércoles\", \"Viernes\"]', NULL, NULL, 'particular'),
(9, 'Proveedor Cuatro', 'Plaza Central 789', 'support@proveedorcuatro.com', 555321654, 'Libros', '[\"Martes\"]', 150, 'Libros Ltd.', 'empresa'),
(10, 'Proveedor Cinco', 'Sector 5 101', 'hello@proveedorcinco.com', 555789123, 'Herramientas', '[\"Lunes\", \"Miércoles\", \"Viernes\"]', 30, 'Herramientas Universal S.L.', 'empresa');

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
(6, 'Daniel Nita ', 'dani', 'employee'),
(7, 'Carlota', 'hola', 'employee'),
(8, 'Pepe', 'dani', 'client');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `companydata`
--
ALTER TABLE `companydata`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indices de la tabla `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`operation_id`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`operation_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`provider_id`);

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
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `companydata`
--
ALTER TABLE `companydata`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `operations`
--
ALTER TABLE `operations`
  MODIFY `operation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `companydata`
--
ALTER TABLE `companydata`
  ADD CONSTRAINT `companydata_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`operation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
