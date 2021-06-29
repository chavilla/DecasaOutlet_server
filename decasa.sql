-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-06-2021 a las 23:15:28
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `decasa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Hogar', '2021-06-27 02:43:04', '2021-06-27 02:43:04'),
(2, 'Cocina', '2021-06-27 02:43:20', '2021-06-27 02:43:20'),
(3, 'Deportes', '2021-06-27 02:43:31', '2021-06-27 02:43:31'),
(4, 'Tecnologia', '2021-06-27 02:43:55', '2021-06-27 02:43:55'),
(5, 'Otros', '2021-06-27 02:56:11', '2021-06-27 02:56:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ruc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_ruc_unique` (`ruc`),
  UNIQUE KEY `clients_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `ruc`, `name`, `lastName`, `phone`, `email`, `active`, `created_at`, `updated_at`) VALUES
(1, '6273885', 'Jose', 'García', '6653-7215', 'jose.gomez@hotmail.com', 1, '2021-02-21 04:31:36', '2021-06-27 03:40:13'),
(2, '3984217', 'Pedro', 'Tabarez', '6746-6265', 'pedrotab05@gmail.com', 1, '2021-02-21 04:31:36', '2021-06-27 03:40:36'),
(3, '3283645', 'Andrea', 'Valdez', '6093-6117', 'andrevaldez9802@gmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:37:28'),
(4, '3971191', 'David', 'Amador', '6504-2010', 'dsamador@hotmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:42:53'),
(5, '6669512', 'Natalia', 'Bustamante', '6711-3177', 'natalia2004@hotmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:45:58'),
(6, '2393594', 'Alberto', 'Griman', '6440-1042', 'albertog1978@gmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:48:01'),
(7, '1129295', 'Guillermo', 'Sanz', '6359-5972', 'guillesanz_23@hotmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:49:06'),
(8, '9554469', 'Liliana', 'Sandoval', '6126-5408', 'liliana.23@hotmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:50:04'),
(9, '4697924', 'Regina', 'Barraza', '6363-1818', 'regibar@hotmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:50:57'),
(10, '4566177', 'Bridguide', 'Pérez', '6694-0225', 'bernhard47@hotmail.com', 1, '2021-02-21 04:31:36', '2021-03-14 08:51:43'),
(20, 'AR388376', 'Rubiela', 'Villa', '6232-9802', 'cuyitela19642010@hotmail.com', 1, '2021-02-21 04:31:36', '2021-03-15 09:57:54'),
(26, 'AW907213', 'Oswaldo', 'Ayala', '6675-6605', 'oswaldo@gmail.com', 1, '2021-03-06 10:51:56', '2021-03-06 10:51:56'),
(27, 'AF997234', 'Giovanni', 'Carpio', '6485-3720', 'giovani23@gmail.com', 1, '2021-03-09 10:10:47', '2021-03-09 10:10:47'),
(28, 'AL633099', 'Lucio', 'Vélez', '6690-5600', 'lucio_velez67@hotmail.com', 1, '2021-03-09 10:15:40', '2021-03-09 10:15:40'),
(29, '3909667', 'Jorge', 'Quiroz', '6232-8756', 'jorgeq77@hotmail.com', 1, '2021-03-09 10:31:29', '2021-03-09 10:31:29'),
(30, '7790303', 'Ismael', 'Ochoa', '6640-2345', 'ismael234@gmail.com', 1, '2021-03-13 05:30:33', '2021-03-13 05:30:33'),
(31, '2702909', 'Milena', 'Pérez', '6905-3304', 'mile333@gmail.com', 1, '2021-03-14 09:36:23', '2021-03-14 09:36:23'),
(32, '9505778', 'Ashley', 'Collado', '6355-2338', 'ashley2000@gmail.com', 1, '2021-03-14 14:34:32', '2021-03-14 14:34:32'),
(33, 'AR632504', 'José', 'Espinoza', '6675-9078', 'jose2000_esp@hotmail.com', 1, '2021-03-14 15:49:35', '2021-03-14 15:49:35'),
(34, '2207679', 'Diana', 'Vargas', '6675-9030', 'dianavargas02@hotmail.com', 1, '2021-03-21 06:19:24', '2021-03-21 06:19:24'),
(35, '2567909', 'Marleny', 'Marulanda', '6690-7883', 'mmarulanda659@misena.edu.co', 1, '2021-03-28 06:43:20', '2021-03-28 06:43:20'),
(36, '2707998', 'Ingrid', 'Vargas', '6305-7873', 'ingridlavargas@hotmail.com', 1, '2021-04-03 03:19:46', '2021-04-03 03:19:46'),
(37, '2765404', 'Miriam', 'Vargas', '6875-8904', 'mirivargas@hotmail.com', 1, '2021-06-27 03:02:51', '2021-06-27 03:02:51'),
(38, '8990567', 'Frank', 'Moreno', '6767-4503', 'frank3434@gmail.com', 1, '2021-06-27 03:03:33', '2021-06-27 03:03:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `details`
--

DROP TABLE IF EXISTS `details`;
CREATE TABLE IF NOT EXISTS `details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `priceUnit` double(5,2) NOT NULL,
  `priceTotal` double(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `details_invoice_id_foreign` (`invoice_id`),
  KEY `details_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `details`
--

INSERT INTO `details` (`id`, `invoice_id`, `product_id`, `amount`, `priceUnit`, `priceTotal`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 2, 1.99, 3.98, '2021-06-27 03:56:43', '2021-06-27 03:56:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inputs`
--

DROP TABLE IF EXISTS `inputs`;
CREATE TABLE IF NOT EXISTS `inputs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `cost` double(5,2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inputs_product_id_foreign` (`product_id`),
  KEY `inputs_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inputs`
--

INSERT INTO `inputs` (`id`, `product_id`, `amount`, `cost`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 61.89, 1, '2021-06-27 03:32:39', '2021-06-27 03:32:39'),
(2, 1, 3, 10.87, 1, '2021-06-27 03:36:18', '2021-06-27 03:36:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `ruc_client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double(5,2) NOT NULL,
  `payMode` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_user_id_foreign` (`user_id`),
  KEY `invoices_client_id_foreign` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `user_id`, `client_id`, `ruc_client`, `total`, `payMode`, `created_at`, `updated_at`) VALUES
(2, '0001', 1, 3, '3283645', 3.98, '1', '2021-06-27 03:56:43', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardexes`
--

DROP TABLE IF EXISTS `kardexes`;
CREATE TABLE IF NOT EXISTS `kardexes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_pp` double(10,2) NOT NULL,
  `input_amount` int(11) DEFAULT '0',
  `input_value` double(10,2) DEFAULT '0.00',
  `output_amount` int(11) DEFAULT '0',
  `output_value` double(10,2) DEFAULT '0.00',
  `balance_amount` int(11) NOT NULL,
  `balance_value` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kardexes_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `kardexes`
--

INSERT INTO `kardexes` (`id`, `product_id`, `description`, `cost_pp`, `input_amount`, `input_value`, `output_amount`, `output_value`, `balance_amount`, `balance_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'Stock Inicial .Cantidad: 4. Costo: 10.99', 10.99, 4, 43.96, 0, 0.00, 4, 43.96, '2021-06-27 02:45:05', '2021-06-27 02:45:05'),
(2, 2, 'Stock Inicial .Cantidad: 3. Costo: 337.89', 337.89, 3, 1013.67, 0, 0.00, 3, 1013.67, '2021-06-27 02:48:53', '2021-06-27 02:48:53'),
(3, 3, 'Stock Inicial .Cantidad: 1. Costo: 68.67', 68.67, 1, 68.67, 0, 0.00, 1, 68.67, '2021-06-27 02:52:57', '2021-06-27 02:52:57'),
(4, 4, 'Stock Inicial .Cantidad: 12. Costo: 1.65', 1.65, 12, 19.80, 0, 0.00, 12, 19.80, '2021-06-27 02:57:09', '2021-06-27 02:57:09'),
(5, 3, 'Compra Factura FC1099. Cantidad: 2. Costo: 61.89', 64.15, 2, 123.78, 0, 0.00, 3, 192.45, '2021-06-27 03:32:39', '2021-06-27 03:32:39'),
(8, 1, 'Compra Factura FV678. Cantidad: 3. Costo: 10.87', 10.94, 3, 32.61, 0, 0.00, 7, 76.57, '2021-06-27 03:36:18', '2021-06-27 03:36:18'),
(9, 4, 'Venta Factura 0001', 1.65, 0, 0.00, 2, 3.98, 10, 15.82, '2021-06-27 03:56:43', '2021-06-27 03:56:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '2014_10_12_000000_create_users_table', 1),
(19, '2014_10_12_100000_create_password_resets_table', 1),
(20, '2019_08_19_000000_create_failed_jobs_table', 1),
(28, '2021_02_09_172753_create_products_table', 2),
(22, '2021_02_09_173459_create_categories_table', 1),
(23, '2021_02_09_173642_create_clients_table', 1),
(25, '2021_02_09_174105_create_invoices_table', 1),
(26, '2021_03_24_162628_create_details_table', 1),
(27, '2021_03_28_211808_create_kardexes_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `cost` double(10,2) NOT NULL,
  `codebar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `priceTotal` double(10,2) NOT NULL,
  `tax` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_reference_unique` (`reference`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `category_id`, `cost`, `codebar`, `stock`, `priceTotal`, `tax`, `active`, `description`, `reference`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 4, 10.94, '6374903090292', 7, 13.67, 0, 1, 'Trípode Celular', 'TRI-3030', 1, '2021-06-27 02:45:05', '2021-06-27 03:36:18'),
(2, 4, 337.89, '3392789648394', 3, 421.99, 0, 1, 'Computador Dell Inspiron14', '3000 series', 1, '2021-06-27 02:48:53', '2021-06-27 02:48:53'),
(3, 4, 64.15, '210122513970', 3, 91.78, 0, 1, 'Ups Nt751', 'NT-751', 1, '2021-06-27 02:52:57', '2021-06-27 03:32:39'),
(4, 5, 1.65, '742307005134', 10, 1.99, 0, 1, 'Alcohol 70', 'Alivia+', 1, '2021-06-27 02:57:09', '2021-06-27 03:56:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jesús', 'jcharris.villa@gmail.com', 'admin', 1, NULL, '$2y$10$zijX77drjqVTUrG7pmMkZemNXGdj5c5k8BXdq/k25rZZvqk2BZyjC', NULL, '2021-06-16 06:15:22', '2021-06-16 06:15:22'),
(2, 'Luis', 'lualchavi1997@hotmail.com', 'user', 1, NULL, '$2y$10$rJgJHhgIpZM.wCobg2ShsOrA2onAKqI/54mhbmtGa/dba/Mq027Uq', NULL, '2021-06-27 03:11:11', '2021-06-27 03:11:11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
