-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2021 a las 14:56:16
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idRole` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `apellido`, `codigo`, `email`, `email_verified_at`, `password`, `idRole`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Carlos Campos', NULL, '123456', 'carlos.campos@hotmail.com', NULL, '$2y$10$kwSC0thCAm9faMDhwMA22..u8H4IfT/YaYvyI2D2XABVaYB9O9AEG', 2, NULL, '2020-01-10 21:37:39', '2020-01-10 21:37:39'),
(3, 'Fernanda', NULL, '789456', 'escafons@hotmail.com', NULL, '$2y$10$yVyuT5yS163vX/oeLuoyXOqmYaAQHprUEuZ9EZ4/VGvF8QnTqIa4u', 1, NULL, '2021-04-22 04:45:42', '2021-04-22 04:45:42'),
(4, 'Samia Jhoana', NULL, '7894561', 'escafons1@hotmail.com', NULL, '$2y$10$UQXzkHwn5cctvHgd6tAuyeRUIAXK5tOOJTIxtiHYgsiBw1HVM502e', 2, NULL, '2021-04-22 19:46:50', '2021-04-22 19:46:50'),
(5, 'Juan', 'Chiang', '7358', 'jchiang@hotmail.com', NULL, '$2y$10$TcMnUSNV5h8fZnp6DmMP6OoUtvywa8MPQ9CRmywsIvlBIYzMAPDxG', 2, NULL, '2021-04-22 23:05:04', '2021-04-22 23:05:04'),
(6, 'Jose', 'Morales', '1285', 'jmorales@hotmail.com', NULL, '$2y$10$g5TfWcPQG3ELS8ZDFcDjROD12GAfpvkal1Xj0HVTgxYlYTfqnsPri', 2, NULL, '2021-04-22 23:06:43', '2021-04-22 23:06:43'),
(7, 'David', 'Alvario', '1953', 'dalvario@hotmail.com', NULL, '$2y$10$oCQRfqnMxwWlyh3G6dZFm.AZiDcxVgJHQ69a1Aa.Kv8Rizrq7EAGO', 2, NULL, '2021-04-22 23:07:44', '2021-04-22 23:07:44'),
(8, 'Ruben', 'Ceron', '4685', 'rceron@hotmail.com', NULL, '$2y$10$LVuH6L9VIqSIrnbuuQ0P/e/9YAEPvzZqSn7tWyy9h5ajieEO70cx.', 2, NULL, '2021-04-22 23:08:58', '2021-04-22 23:08:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `code` (`codigo`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
