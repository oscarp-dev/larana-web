-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2025 a las 18:07:39
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
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio`) VALUES
(2, 6, 3, 1, 90.00),
(3, 7, 3, 1, 90.00),
(4, 8, 4, 1, 110.00),
(5, 8, 3, 1, 90.00),
(6, 8, 2, 1, 150.00),
(7, 9, 2, 1, 150.00),
(8, 10, 3, 2, 90.00),
(9, 11, 3, 1, 90.00),
(10, 12, 3, 1, 90.00),
(11, 12, 1, 1, 120.00),
(12, 12, 2, 1, 150.00),
(13, 13, 1, 1, 90.00),
(14, 14, 4, 1, 110.00),
(15, 14, 2, 1, 150.00),
(16, 14, 3, 1, 90.00),
(17, 15, 1, 1, 120.00),
(18, 16, 3, 1, 90.00),
(19, 16, 2, 1, 150.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','entregado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `fecha`, `total`, `estado`) VALUES
(6, 2, '2025-10-24 04:46:36', 90.00, 'pendiente'),
(7, 2, '2025-10-24 04:47:50', 90.00, 'pendiente'),
(8, 2, '2025-10-24 04:48:29', 350.00, 'pendiente'),
(9, 2, '2025-10-24 09:23:27', 150.00, 'pendiente'),
(10, 2, '2025-10-26 22:15:04', 180.00, 'pendiente'),
(11, 2, '2025-10-26 22:15:56', 90.00, 'pendiente'),
(12, 2, '2025-10-26 22:25:38', 360.00, 'pendiente'),
(13, 3, '2025-10-27 09:25:43', 90.00, 'pendiente'),
(14, 2, '2025-10-27 14:27:22', 350.00, 'pendiente'),
(15, 4, '2025-10-29 09:32:11', 120.00, 'pendiente'),
(16, 5, '2025-11-05 17:10:36', 240.00, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `categoria`, `fecha_creacion`) VALUES
(1, 'Pulsera Dorada', 'Pulsera elegante con baño dorado y diseño minimalista.', 120.00, 10, 'images/producto2.jpg', 'Pulseras', '2025-10-24 02:41:50'),
(2, 'Collar Elegante', 'Collar con colgante brillante ideal para ocasiones especiales.', 150.00, 10, 'images/producto3.jpg', 'Collares', '2025-10-24 02:41:50'),
(3, 'Anillo Minimal', 'Anillo de diseño minimalista, perfecto para uso diario.', 90.00, 10, 'images/producto1.jpg', 'Anillos', '2025-10-24 02:41:50'),
(4, 'Pendientes Clásicos', 'Pendientes dorados de estilo clásico y atemporal.', 110.00, 10, 'images/producto4.jpg', 'Pendientes', '2025-10-24 02:41:50'),
(54, 'Collar con gema', 'Un collar elegante y brillante gracias a su ziorita de gran tamaño', 150.00, 50, 'images/collar_con_gema.jpg', 'Collares', '2025-11-05 02:42:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stars` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `acepta_terminos` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `direccion`, `acepta_terminos`, `fecha_registro`, `admin`) VALUES
(2, 'Santiago', 'Enfedaque', 'sanenfcor@gmail.com', '$2y$10$HQqqu0gzpXnweprQocscnuZyO5zz.IVMBaAtDjdkhW1A0KE23nmS.', '644464952', 'Cuarteles 37', 1, '2025-10-21 17:22:21', 1),
(3, 'Alejandro', 'Brito', 'prueba@gmail.com', '$2y$10$q2NJFXHBG7s/WiK5el4yXuHfE6Yz2m1FzVjRL16oZUHxHBY7PbSI6', '666666666', 'Atapuerca', 1, '2025-10-27 00:48:32', 0),
(4, 'Javier', 'Carreño', 'prueba2@gmail.com', '$2y$10$6oaG9fRy1xmnkA9LuAr/r.RiiFb92Qrx904gKO.2VyUsJ5.w.3ro6', '555555555', 'Acapulco', 1, '2025-10-27 00:52:01', 0),
(5, 'Oscar Daniel', 'Perez Colina', 'osdapeco@gmail.com', '$2y$10$lnIUSuIxBPVLFl5HLDYfHuWJJsRaZoGHhnpsMxqkEmxTiF/1JxFT2', '682811737', 'Calle carlota pasaron 10 2do puerta 4', 1, '2025-11-05 16:10:06', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedidos_usuarios` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_producto` FOREIGN KEY (`product_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


