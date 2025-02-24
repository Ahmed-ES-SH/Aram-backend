-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 24, 2025 at 03:54 PM
-- Server version: 8.0.36-28
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aram`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_card_types`
--

CREATE TABLE `affiliate_card_types` (
  `id` bigint UNSIGNED NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_before_discount` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `features_ar` json NOT NULL,
  `features_en` json NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('allow','not_allow','under_review') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_allow',
  `organization_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_services`
--

CREATE TABLE `affiliate_services` (
  `id` bigint UNSIGNED NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `features_en` text COLLATE utf8mb4_unicode_ci,
  `features_ar` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `check_status` enum('done','waiting','updated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `confirmation_status` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_price` decimal(8,2) DEFAULT NULL,
  `number_of_orders` int NOT NULL DEFAULT '0',
  `organization_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `affiliate_services`
--

INSERT INTO `affiliate_services` (`id`, `title_ar`, `title_en`, `description_en`, `description_ar`, `features_en`, `features_ar`, `image`, `icon`, `status`, `check_status`, `confirmation_status`, `confirmation_price`, `number_of_orders`, `organization_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'خدمة autem', 'Service facere', 'Neque pariatur aut consequatur porro aut. Vero quidem illo magnam rerum distinctio omnis voluptatem id. Libero sed harum perferendis facere. Fugit voluptates et aut ea.', 'Impedit voluptatum nesciunt corrupti qui esse deserunt. Aliquam autem autem expedita non quibusdam magni. Dolorem quibusdam et dolor quidem.', '[\"laborum\",\"cupiditate\",\"aspernatur\"]', '[\"harum\",\"dolor\",\"et\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/009922?text=icons+facere', 0, 'waiting', 1, 87.19, 24, 3, 11, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(2, 'خدمة laudantium', 'Service et', 'Quam ea minima ea officiis aut asperiores quia. Vero omnis repellat ratione excepturi blanditiis dolore nisi.', 'Quo veritatis tenetur minima delectus. Tempore dolorem quia dolorum recusandae ab quibusdam et.', '[\"consequuntur\",\"esse\",\"voluptatem\"]', '[\"quo\",\"ad\",\"sit\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_3_679400e49baf6.jpg', 'https://via.placeholder.com/64x64.png/0077bb?text=icons+eligendi', 0, 'waiting', 0, 30.10, 76, 17, 15, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(3, 'خدمة dolore', 'Service culpa', 'Quis sunt magnam sint. Perferendis necessitatibus voluptatem temporibus est. Accusantium rerum sed alias aut expedita. Architecto et alias assumenda distinctio.', 'Dolorem ratione ea quaerat esse consequatur corrupti. Placeat nulla perspiciatis eaque velit corporis. Impedit quia ad quis eum repudiandae nobis unde. Iusto eius inventore sit sint dolorum vel.', '[\"vitae\",\"fugiat\",\"veniam\"]', '[\"ut\",\"excepturi\",\"consectetur\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/003344?text=icons+dicta', 1, 'waiting', 0, 31.04, 95, 18, 8, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(4, 'خدمة dolorum', 'Service aperiam', 'Et a corrupti rerum voluptatem est occaecati illo. Sunt quia et cum explicabo qui occaecati et. Perferendis id alias impedit voluptatum consequuntur accusantium modi.', 'Voluptas blanditiis autem nihil iusto et eum. Distinctio labore illum minima illum. Corporis aut nostrum deserunt ad facere.', '[\"hic\",\"ipsum\",\"eum\"]', '[\"earum\",\"et\",\"iste\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-02.jpg', 'https://via.placeholder.com/64x64.png/005544?text=icons+reiciendis', 0, 'waiting', 1, 57.22, 41, 8, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(5, 'خدمة eum', 'Service aliquam', 'Vel corrupti facilis rerum distinctio enim. Minima necessitatibus excepturi fugiat quia. Officia similique dolorum facere beatae voluptas itaque. Quia vel sit qui minus sit.', 'Et molestiae hic id qui. Iusto deserunt et eos est quos officiis sint. Natus modi quidem consectetur neque quisquam voluptatem.', '[\"explicabo\",\"harum\",\"quia\"]', '[\"quo\",\"voluptatum\",\"dicta\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/0088cc?text=icons+debitis', 0, 'waiting', 0, 41.39, 58, 12, 4, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(6, 'خدمة placeat', 'Service et', 'Debitis impedit ea est in. Voluptas saepe sint labore velit animi vel. Eos deleniti modi sed eum ad.', 'Repellat quos officia placeat vel recusandae provident. Fuga quo et quam quia sapiente praesentium. Blanditiis voluptatibus optio doloremque asperiores minus. Suscipit quidem voluptatem vero quo hic.', '[\"neque\",\"esse\",\"qui\"]', '[\"quidem\",\"consequuntur\",\"voluptas\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/00aa55?text=icons+nesciunt', 1, 'waiting', 0, 53.21, 8, 19, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(7, 'خدمة eaque', 'Service in', 'Amet molestiae est voluptatum voluptas. Cupiditate in expedita quia animi sit deserunt. Voluptatum sit enim doloribus. Ea quidem sit aut assumenda.', 'Et dolorum laudantium nisi in sit minima eos magni. Voluptatum sunt vel pariatur nisi sit aspernatur. Facere illo similique quas molestiae.', '[\"sed\",\"similique\",\"sint\"]', '[\"autem\",\"voluptates\",\"facere\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/002266?text=icons+perspiciatis', 1, 'waiting', 0, 47.50, 3, 2, 12, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(8, 'خدمة sapiente', 'Service quia', 'Nihil reiciendis et quia quaerat vel ad. Impedit qui natus odio harum. Et recusandae blanditiis cumque placeat eveniet. Perferendis facere sunt commodi eius illum voluptatum dolorem.', 'Voluptas nostrum aut quos omnis minima. Aliquid nihil officia odio molestias magnam id voluptas. Optio consectetur itaque sed pariatur fugiat fuga.', '[\"quas\",\"provident\",\"amet\"]', '[\"in\",\"voluptatem\",\"cum\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/00bb00?text=icons+sed', 0, 'waiting', 0, 28.24, 9, 1, 16, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(9, 'خدمة eum', 'Service atque', 'Quisquam quas quia ad ut adipisci cupiditate. A sed ut non harum eaque. Assumenda eius porro dicta sed doloribus ab dolorem.', 'Animi et eos fugiat qui. Harum sint debitis autem. Quia id nostrum facilis. Voluptate deleniti enim et cumque. Et hic aliquid voluptas id sit.', '[\"eveniet\",\"quo\",\"itaque\"]', '[\"aut\",\"molestiae\",\"ex\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-02.jpg', 'https://via.placeholder.com/64x64.png/004400?text=icons+tempore', 0, 'waiting', 1, 51.35, 24, 2, 17, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(10, 'خدمة amet', 'Service sit', 'Earum neque vel qui. Nisi necessitatibus vero et rem ut. Repellat quibusdam accusantium et numquam impedit ad error.', 'Et et ea veniam quo earum beatae sit modi. Aut itaque sunt cumque ut occaecati est earum. Et omnis et cum eligendi. Adipisci et et sunt beatae ab dolor.', '[\"assumenda\",\"distinctio\",\"incidunt\"]', '[\"repellendus\",\"deleniti\",\"aliquid\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_3_679400e49baf6.jpg', 'https://via.placeholder.com/64x64.png/00ffee?text=icons+ad', 0, 'waiting', 0, 62.93, 62, 18, 2, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(11, 'خدمة veniam', 'Service tempora', 'Doloremque laboriosam quia neque ratione est iste nesciunt. Culpa modi non ratione ducimus. Earum aut sit atque aperiam asperiores id consequatur. Quia ut fuga est et quo sed.', 'Quidem ad laudantium animi necessitatibus. Necessitatibus voluptatem ut dolorum rerum est amet. Doloremque id consectetur ut vel.', '[\"qui\",\"eius\",\"porro\"]', '[\"voluptate\",\"magnam\",\"consequatur\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/001199?text=icons+et', 1, 'waiting', 0, 83.12, 69, 15, 13, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(12, 'خدمة quibusdam', 'Service dignissimos', 'Totam quam qui suscipit nesciunt a doloribus. Repudiandae nihil quam rem ab cupiditate asperiores voluptatem.', 'Quos ipsa repellat ex et architecto autem pariatur. Quas et totam quas excepturi sint porro sed aut. Voluptatem voluptatem voluptatum vel culpa voluptatem quis.', '[\"fugit\",\"dolorum\",\"eligendi\"]', '[\"temporibus\",\"suscipit\",\"culpa\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_3_679400e49baf6.jpg', 'https://via.placeholder.com/64x64.png/00dd88?text=icons+iusto', 0, 'waiting', 1, 87.31, 96, 4, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(13, 'خدمة necessitatibus', 'Service natus', 'Numquam ut omnis ipsa est sit totam. Sunt quos dolor culpa ut dolore voluptatem. Laboriosam dolor praesentium quidem ut numquam est asperiores. Quam asperiores nihil velit sunt nemo aut soluta.', 'Sapiente eos non et sed. Numquam id et perspiciatis autem et dolore eveniet. Minus fugiat aliquam earum voluptates. Praesentium veniam laboriosam provident. Similique beatae ducimus ab enim unde et doloremque.', '[\"ab\",\"nostrum\",\"eaque\"]', '[\"molestiae\",\"numquam\",\"voluptatem\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/001155?text=icons+neque', 1, 'waiting', 0, 23.20, 75, 12, 20, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(14, 'خدمة alias', 'Service aut', 'Reiciendis repudiandae accusamus magni illo eum non facere corporis. Rerum et vel adipisci minus officia distinctio excepturi. Delectus et natus repellat quod. Iure iste hic consectetur.', 'Culpa ad repudiandae assumenda omnis iste tempore. Voluptatem accusantium aut ratione facilis. Ut corrupti qui autem vel autem eveniet quisquam. Nihil incidunt quibusdam exercitationem eos.', '[\"omnis\",\"sit\",\"ut\"]', '[\"natus\",\"quia\",\"aperiam\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_3_679400e49baf6.jpg', 'https://via.placeholder.com/64x64.png/003366?text=icons+vel', 1, 'waiting', 0, 78.44, 24, 14, 7, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(15, 'خدمة ut', 'Service dolorum', 'Qui est accusamus mollitia doloribus. Neque quo dolorem nulla ratione debitis doloribus. At fuga quasi sequi itaque.', 'Voluptas ut nemo aperiam et. Quam rerum temporibus aut delectus officia autem magni. Autem eaque illum et. Voluptas qui consequatur repudiandae ut ut.', '[\"inventore\",\"cumque\",\"quas\"]', '[\"quia\",\"itaque\",\"recusandae\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_3_679400e49baf6.jpg', 'https://via.placeholder.com/64x64.png/00aa66?text=icons+repellat', 0, 'waiting', 1, 95.30, 45, 15, 6, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(16, 'خدمة eum', 'Service voluptas', 'Corporis illum pariatur a quae ex neque molestiae culpa. Ab voluptatibus modi qui quidem velit sed voluptates magni. Enim voluptates animi at et pariatur.', 'Id quos non atque est quibusdam nemo debitis. Et consequatur beatae excepturi eos quas et eum enim. Eum molestiae hic fuga sit occaecati.', '[\"suscipit\",\"exercitationem\",\"suscipit\"]', '[\"assumenda\",\"ea\",\"velit\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_3_679400e49baf6.jpg', 'https://via.placeholder.com/64x64.png/006677?text=icons+expedita', 1, 'waiting', 1, 38.53, 72, 15, 2, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(17, 'خدمة id', 'Service quia', 'Ut neque enim porro magnam consequatur. Est adipisci voluptatibus amet voluptas autem fuga rem. Eveniet enim natus fuga officiis. Ducimus et consectetur voluptas in aut assumenda deleniti voluptate.', 'Nisi exercitationem cumque sint sit enim. Est rerum dolorem dolor illum odio. In voluptate repellat aut qui minus hic.', '[\"tempore\",\"cupiditate\",\"pariatur\"]', '[\"repudiandae\",\"necessitatibus\",\"aut\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/0077cc?text=icons+voluptatem', 0, 'waiting', 1, 66.79, 61, 4, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(18, 'خدمة nostrum', 'Service nihil', 'Magnam qui laboriosam enim exercitationem voluptas. Minima ipsam aspernatur qui beatae a et quibusdam. Sit ex sint sint tempora ut. Temporibus minima consequatur occaecati numquam quia aliquam quia. Eaque est sapiente vel in pariatur id eum voluptatem.', 'Aut cum est a qui vero hic. Hic amet magnam eum consequatur. Totam quos autem praesentium dolor ut ut dignissimos sapiente. Aliquid velit facilis sunt nisi consequatur et.', '[\"sequi\",\"explicabo\",\"velit\"]', '[\"possimus\",\"nihil\",\"totam\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-02.jpg', 'https://via.placeholder.com/64x64.png/00bbee?text=icons+voluptatibus', 0, 'waiting', 1, 46.23, 2, 18, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(19, 'خدمة at', 'Service natus', 'Deserunt sunt assumenda iusto molestias unde delectus quo. Nobis earum deserunt corporis accusamus rerum ipsam. Aut dolorem aut aut suscipit perferendis delectus asperiores quo.', 'Aliquam et occaecati explicabo qui natus labore. Ratione esse nihil animi occaecati sed odit. Expedita magni odio id incidunt accusantium et. Facilis expedita quidem et id.', '[\"quam\",\"nobis\",\"non\"]', '[\"et\",\"expedita\",\"voluptatum\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service_3_679400e49baf6.jpg', 'https://via.placeholder.com/64x64.png/0077dd?text=icons+a', 1, 'waiting', 1, 82.31, 3, 11, 9, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(20, 'خدمة facilis', 'Service omnis', 'Enim voluptas aut eum aut dolor ipsum quia. Officiis perspiciatis corrupti culpa nihil. Dolorum nam enim cupiditate totam quasi odio. Neque eos laborum consequatur voluptatem consequatur.', 'Adipisci aliquid ipsam fugiat sint. Culpa et provident eos amet autem cupiditate beatae. Recusandae expedita sed quo est. Deleniti officiis deleniti id nisi.', '[\"laborum\",\"non\",\"tempora\"]', '[\"possimus\",\"quia\",\"nulla\"]', 'https://datafromapi-2.aram-gulf.com/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/003300?text=icons+quo', 0, 'waiting', 1, 51.60, 75, 6, 16, '2025-02-18 12:39:53', '2025-02-18 12:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `arma__cards`
--

CREATE TABLE `arma__cards` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `issue_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `usage_limit` int DEFAULT NULL,
  `cvv` int DEFAULT NULL,
  `current_usage` int NOT NULL DEFAULT '0',
  `cardtype_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arma__cards`
--

INSERT INTO `arma__cards` (`id`, `user_id`, `card_number`, `price`, `issue_date`, `expiry_date`, `status`, `usage_limit`, `cvv`, `current_usage`, `cardtype_id`, `created_at`, `updated_at`) VALUES
(1, 51, '7431815975702146', 9.99, '2025-02-19 18:55:43', '2025-03-19 15:55:43', 'active', NULL, 507, 0, 4, '2025-02-19 18:55:43', '2025-02-19 15:55:43'),
(2, 51, NULL, 9.99, '1 month', NULL, 'inactive', NULL, NULL, 0, 4, NULL, NULL),
(3, 54, '3675474831112152', 30.00, '2025-02-20 02:05:34', '2025-03-19 23:05:34', 'active', NULL, 335, 0, 4, '2025-02-20 02:05:34', '2025-02-19 23:05:34'),
(4, 54, '7944103486835566', 30.00, '2025-02-21 13:03:47', '2025-08-21 10:03:47', 'active', NULL, 405, 0, 2, '2025-02-21 13:03:47', '2025-02-21 10:03:47'),
(5, 54, '4536608365127179', 30.00, '2025-02-21 13:07:15', '2025-03-21 10:07:15', 'active', NULL, 884, 0, 2, '2025-02-21 13:07:15', '2025-02-21 10:07:15'),
(6, 54, '8011758768690097', 50.00, '2025-02-21 22:32:22', '2025-03-21 19:32:22', 'active', NULL, 204, 0, 3, '2025-02-21 22:32:22', '2025-02-21 19:32:22'),
(7, 54, NULL, 30.00, '12', NULL, 'inactive', NULL, NULL, 0, 12, NULL, NULL),
(8, 51, NULL, 30.00, '12', NULL, 'inactive', NULL, NULL, 0, 2, NULL, NULL),
(9, 51, NULL, 50.00, '12', NULL, 'inactive', NULL, NULL, 0, 3, NULL, NULL),
(10, 51, NULL, 30.00, '12', NULL, 'inactive', NULL, NULL, 0, 2, NULL, NULL),
(11, 51, NULL, 50.00, '12', NULL, 'inactive', NULL, NULL, 0, 3, NULL, NULL),
(12, 51, NULL, 30.00, '12', NULL, 'inactive', NULL, NULL, 0, 2, NULL, NULL),
(13, 51, NULL, 50.00, '12', NULL, 'inactive', NULL, NULL, 0, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `artical_categories`
--

CREATE TABLE `artical_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artical_categories`
--

INSERT INTO `artical_categories` (`id`, `title_ar`, `title_en`, `image`, `created_at`, `updated_at`) VALUES
(1, 'التقنية', 'Technology', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/search.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(2, 'الصحة', 'Health', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/blog.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(3, 'العلوم', 'Science', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/newspaper.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(4, 'الاقتصاد', 'Economics', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/search.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(5, 'البيئة', 'Environment', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/newspaper.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(6, 'التعليم', 'Education', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/blog.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(7, 'الرياضة', 'Sports', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/search.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(8, 'الثقافة', 'Culture', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/search.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(9, 'السفر', 'Travel', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/newspaper.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(10, 'الطعام', 'Food', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/writing.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(11, 'الأعمال', 'Business', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/blog.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(12, 'الفن', 'Art', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/blog.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(13, 'التاريخ', 'History', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/newspaper.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(14, 'المالية', 'Finance', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/search.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(15, 'الأزياء', 'Fashion', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/blog.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(16, 'التسويق', 'Marketing', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/search.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(17, 'التكنولوجيا الحديثة', 'Modern Technology', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/search.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(18, 'الإعلام', 'Media', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/articles.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(19, 'التحليل السياسي', 'Political Analysis', 'https://datafromapi-2.aram-gulf.com/images/articals_categories/blog.png', '2025-02-18 12:39:48', '2025-02-18 12:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `article_reactions_count`
--

CREATE TABLE `article_reactions_count` (
  `id` bigint UNSIGNED NOT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `dislikes` int NOT NULL DEFAULT '0',
  `loves` int NOT NULL DEFAULT '0',
  `laughs` int NOT NULL DEFAULT '0',
  `total_reactions` int NOT NULL DEFAULT '0',
  `first_reaction_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ أول تفاعل',
  `last_reaction_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ آخر تفاعل',
  `article_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_reactions_count`
--

INSERT INTO `article_reactions_count` (`id`, `likes`, `dislikes`, `loves`, `laughs`, `total_reactions`, `first_reaction_at`, `last_reaction_at`, `article_id`, `created_at`, `updated_at`) VALUES
(1, 147, 11, 26, 120, 304, '2024-03-06 12:15:08', '2025-02-02 12:15:08', 2, NULL, NULL),
(2, 481, 28, 37, 183, 728, '2024-09-22 12:15:08', '2025-01-29 12:15:08', 5, NULL, '2025-02-18 13:25:57'),
(3, 135, 36, 154, 78, 403, '2024-03-30 12:15:08', '2025-02-08 12:15:08', 4, NULL, NULL),
(4, 304, 96, 252, 108, 760, '2024-02-26 12:15:08', '2025-02-07 12:15:08', 1, NULL, NULL),
(5, 299, 48, 39, 169, 554, '2024-07-11 12:15:08', '2025-01-23 12:15:08', 3, NULL, '2025-02-18 13:26:10'),
(6, 378, 77, 232, 115, 802, '2024-09-11 12:15:45', '2025-02-10 12:15:45', 1, NULL, NULL),
(7, 110, 18, 26, 151, 305, '2024-08-19 12:15:45', '2025-01-23 12:15:45', 3, NULL, NULL),
(8, 281, 99, 9, 53, 442, '2024-06-06 12:15:45', '2025-02-06 12:15:45', 2, NULL, NULL),
(9, 46, 10, 82, 157, 295, '2024-10-18 12:15:45', '2025-02-07 12:15:45', 4, NULL, NULL),
(10, 381, 68, 242, 179, 870, '2024-08-02 12:15:45', '2025-01-23 12:15:45', 5, NULL, NULL),
(11, 243, 53, 42, 96, 434, '2024-11-22 12:18:05', '2025-01-30 12:18:05', 5, NULL, NULL),
(12, 329, 63, 82, 86, 560, '2024-12-09 12:18:05', '2025-02-11 12:18:05', 4, NULL, NULL),
(13, 34, 100, 290, 184, 608, '2025-01-16 12:18:05', '2025-02-08 12:18:05', 2, NULL, NULL),
(14, 368, 57, 83, 89, 597, '2024-12-17 12:18:05', '2025-01-30 12:18:05', 3, NULL, NULL),
(15, 404, 92, 4, 25, 525, '2024-05-04 12:18:05', '2025-02-09 12:18:05', 1, NULL, NULL),
(16, 53, 100, 18, 1, 172, '2024-05-19 12:19:06', '2025-02-11 12:19:06', 4, NULL, NULL),
(17, 201, 87, 225, 24, 537, '2024-10-14 12:19:06', '2025-01-31 12:19:06', 3, NULL, NULL),
(18, 65, 76, 292, 141, 574, '2024-10-12 12:19:06', '2025-01-25 12:19:06', 1, NULL, NULL),
(19, 27, 46, 30, 175, 278, '2024-09-01 12:19:06', '2025-02-02 12:19:06', 2, NULL, NULL),
(20, 96, 60, 219, 131, 506, '2024-08-20 12:19:06', '2025-01-29 12:19:06', 5, NULL, NULL),
(21, 235, 83, 223, 128, 669, '2025-01-15 12:20:00', '2025-02-10 12:20:00', 4, NULL, NULL),
(22, 328, 59, 26, 19, 432, '2024-10-19 12:20:00', '2025-02-09 12:20:00', 2, NULL, NULL),
(23, 118, 9, 239, 8, 374, '2025-01-08 12:20:00', '2025-02-16 12:20:00', 5, NULL, NULL),
(24, 264, 59, 92, 28, 443, '2024-06-08 12:20:00', '2025-02-16 12:20:00', 1, NULL, NULL),
(25, 114, 57, 48, 151, 370, '2024-07-06 12:20:00', '2025-01-20 12:20:00', 3, NULL, NULL),
(26, 300, 89, 144, 27, 560, '2024-11-10 12:21:07', '2025-02-02 12:21:07', 3, NULL, NULL),
(27, 224, 73, 259, 98, 654, '2024-06-27 12:21:07', '2025-01-28 12:21:07', 2, NULL, NULL),
(28, 253, 72, 283, 113, 721, '2024-09-05 12:21:07', '2025-01-22 12:21:07', 1, NULL, NULL),
(29, 188, 56, 108, 182, 534, '2024-08-24 12:21:07', '2025-01-24 12:21:07', 5, NULL, NULL),
(30, 177, 5, 241, 99, 522, '2025-01-02 12:21:07', '2025-02-11 12:21:07', 4, NULL, NULL),
(31, 293, 35, 245, 178, 751, '2024-06-16 12:21:59', '2025-02-02 12:21:59', 4, NULL, NULL),
(32, 429, 57, 300, 155, 941, '2024-11-02 12:21:59', '2025-01-20 12:21:59', 2, NULL, NULL),
(33, 489, 1, 235, 119, 844, '2024-09-02 12:21:59', '2025-01-21 12:21:59', 1, NULL, NULL),
(34, 431, 95, 29, 12, 567, '2024-04-26 12:21:59', '2025-02-16 12:21:59', 3, NULL, NULL),
(35, 295, 71, 104, 66, 536, '2024-05-25 12:21:59', '2025-02-08 12:21:59', 5, NULL, NULL),
(36, 248, 98, 84, 121, 551, '2024-03-30 12:32:03', '2025-02-11 12:32:03', 5, NULL, NULL),
(37, 446, 11, 261, 118, 836, '2024-12-20 12:32:03', '2025-01-29 12:32:03', 1, NULL, NULL),
(38, 373, 17, 3, 1, 394, '2024-04-16 12:32:03', '2025-02-06 12:32:03', 4, NULL, NULL),
(39, 76, 15, 249, 146, 486, '2024-04-27 12:32:03', '2025-02-16 12:32:03', 3, NULL, NULL),
(40, 9, 86, 14, 57, 166, '2024-09-14 12:32:03', '2025-02-04 12:32:03', 2, NULL, NULL),
(41, 8, 90, 49, 95, 242, '2024-08-12 12:39:48', '2025-01-21 12:39:48', 4, NULL, NULL),
(42, 250, 14, 76, 2, 342, '2024-07-14 12:39:48', '2025-01-31 12:39:48', 5, NULL, NULL),
(43, 173, 5, 169, 27, 374, '2024-05-15 12:39:48', '2025-01-30 12:39:48', 3, NULL, NULL),
(44, 278, 81, 81, 27, 467, '2024-05-06 12:39:48', '2025-02-13 12:39:48', 2, NULL, NULL),
(45, 428, 69, 160, 42, 699, '2024-05-15 12:39:48', '2025-02-15 12:39:48', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `pending_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `available_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `user_id`, `organization_id`, `pending_balance`, `available_balance`, `total_balance`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1773.00, 0.00, 1773.00, '2025-02-18 12:15:49', '2025-02-18 12:39:53'),
(2, 2, 12, 1758.00, 0.00, 1758.00, '2025-02-18 12:18:09', '2025-02-18 12:39:53'),
(3, 3, 15, 1800.00, 0.00, 1800.00, '2025-02-18 12:18:09', '2025-02-18 12:39:53'),
(4, NULL, 2, 20.00, 0.00, 20.00, '2025-02-22 08:41:43', '2025-02-22 08:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `bells`
--

CREATE TABLE `bells` (
  `id` bigint UNSIGNED NOT NULL,
  `bell_items` json DEFAULT NULL,
  `bell_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bells`
--

INSERT INTO `bells` (`id`, `bell_items`, `bell_type`, `amount`, `account_type`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:15 PM\", \"expire_in\": \"12:30 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '132', 'Organization', 1, '2025-02-18 12:15:49', '2025-02-18 12:15:49'),
(2, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:15 PM\", \"expire_in\": \"12:30 PM\", \"organization_id\": 20, \"additional_notes\": null}', 'confirm_booked', '239', 'Organization', 2, '2025-02-18 12:15:49', '2025-02-18 12:15:49'),
(3, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:18 PM\", \"expire_in\": \"12:33 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '90', 'Organization', 1, '2025-02-18 12:18:09', '2025-02-18 12:18:09'),
(4, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:18 PM\", \"expire_in\": \"12:33 PM\", \"organization_id\": 12, \"additional_notes\": null}', 'confirm_booked', '267', 'Organization', 2, '2025-02-18 12:18:09', '2025-02-18 12:18:09'),
(5, '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:18 PM\", \"expire_in\": \"12:33 PM\", \"organization_id\": 15, \"additional_notes\": null}', 'confirm_booked', '278', 'Organization', 3, '2025-02-18 12:18:09', '2025-02-18 12:18:09'),
(6, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:19 PM\", \"expire_in\": \"12:34 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '209', 'Organization', 1, '2025-02-18 12:19:10', '2025-02-18 12:19:10'),
(7, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:19 PM\", \"expire_in\": \"12:34 PM\", \"organization_id\": 12, \"additional_notes\": null}', 'confirm_booked', '467', 'Organization', 2, '2025-02-18 12:19:10', '2025-02-18 12:19:10'),
(8, '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:19 PM\", \"expire_in\": \"12:34 PM\", \"organization_id\": 15, \"additional_notes\": null}', 'confirm_booked', '439', 'Organization', 3, '2025-02-18 12:19:10', '2025-02-18 12:19:10'),
(9, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:20 PM\", \"expire_in\": \"12:35 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '119', 'Organization', 1, '2025-02-18 12:20:05', '2025-02-18 12:20:05'),
(10, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:20 PM\", \"expire_in\": \"12:35 PM\", \"organization_id\": 12, \"additional_notes\": null}', 'confirm_booked', '58', 'Organization', 2, '2025-02-18 12:20:05', '2025-02-18 12:20:05'),
(11, '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:20 PM\", \"expire_in\": \"12:35 PM\", \"organization_id\": 15, \"additional_notes\": null}', 'confirm_booked', '352', 'Organization', 3, '2025-02-18 12:20:05', '2025-02-18 12:20:05'),
(12, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:21 PM\", \"expire_in\": \"12:36 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '148', 'Organization', 1, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(13, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:21 PM\", \"expire_in\": \"12:36 PM\", \"organization_id\": 12, \"additional_notes\": null}', 'confirm_booked', '231', 'Organization', 2, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(14, '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:21 PM\", \"expire_in\": \"12:36 PM\", \"organization_id\": 15, \"additional_notes\": null}', 'confirm_booked', '149', 'Organization', 3, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(15, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:22 PM\", \"expire_in\": \"12:37 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '412', 'Organization', 1, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(16, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:22 PM\", \"expire_in\": \"12:37 PM\", \"organization_id\": 12, \"additional_notes\": null}', 'confirm_booked', '284', 'Organization', 2, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(17, '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:22 PM\", \"expire_in\": \"12:37 PM\", \"organization_id\": 15, \"additional_notes\": null}', 'confirm_booked', '76', 'Organization', 3, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(18, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:32 PM\", \"expire_in\": \"12:47 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '206', 'Organization', 1, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(19, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:32 PM\", \"expire_in\": \"12:47 PM\", \"organization_id\": 12, \"additional_notes\": null}', 'confirm_booked', '98', 'Organization', 2, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(20, '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:32 PM\", \"expire_in\": \"12:47 PM\", \"organization_id\": 15, \"additional_notes\": null}', 'confirm_booked', '112', 'Organization', 3, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(21, '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:39 PM\", \"expire_in\": \"12:54 PM\", \"organization_id\": 10, \"additional_notes\": null}', 'confirm_booked', '457', 'Organization', 1, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(22, '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:39 PM\", \"expire_in\": \"12:54 PM\", \"organization_id\": 12, \"additional_notes\": null}', 'confirm_booked', '353', 'Organization', 2, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(23, '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:39 PM\", \"expire_in\": \"12:54 PM\", \"organization_id\": 15, \"additional_notes\": null}', 'confirm_booked', '394', 'Organization', 3, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(24, '[{\"id\": \"4\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/card_1.jpg\", \"price\": \"9.99\", \"title\": \"Basic Subscription\", \"duration\": \"1 month\", \"quantity\": 1}]', 'cards_bell', '9.99', 'User', 51, '2025-02-19 15:49:55', '2025-02-19 15:49:55'),
(25, '[{\"id\": \"4\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/card_1.jpg\", \"price\": \"9.99\", \"title\": \"Basic Subscription\", \"duration\": \"1 month\", \"quantity\": 1}]', 'cards_bell', '9.99', 'User', 51, '2025-02-19 15:53:42', '2025-02-19 15:53:42'),
(26, '[{\"id\": \"4\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (14)_67b64d38c6ecb.png\", \"price\": \"30.00\", \"title\": \"Basic Subscription\", \"duration\": \"12\", \"quantity\": 1}]', 'cards_bell', '11.54', 'User', 54, '2025-02-19 23:05:17', '2025-02-19 23:05:17'),
(27, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"6\", \"quantity\": 1}]', 'cards_bell', '11.54', 'User', 54, '2025-02-21 10:03:22', '2025-02-21 10:03:22'),
(28, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"12\", \"quantity\": 1}]', 'cards_bell', '30', 'User', 54, '2025-02-21 10:06:52', '2025-02-21 10:06:52'),
(29, '[{\"id\": \"3\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png\", \"price\": \"50.00\", \"title\": \"Enterprise Subscription\", \"duration\": \"12\", \"quantity\": 1}]', 'cards_bell', '19.23', 'User', 54, '2025-02-21 19:29:27', '2025-02-21 19:29:27'),
(30, '{\"user_id\": \"51\", \"book_day\": \"2025-02-22\", \"book_time\": \"10:30 AM\", \"expire_in\": \"10:45 AM\", \"organization_id\": \"2\", \"additional_notes\": null}', 'confirm_booked', '20', 'User', 51, '2025-02-22 08:41:43', '2025-02-22 08:41:43'),
(31, '[{\"id\": \"12\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh aram card_67b9050e1f1e0.png\", \"price\": \"30.00\", \"title\": \"mmmm\", \"duration\": \"12\", \"quantity\": 1}]', 'cards_bell', '30', 'User', 54, '2025-02-22 08:49:49', '2025-02-22 08:49:49'),
(32, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"12\", \"quantity\": 1}, {\"id\": \"3\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png\", \"price\": \"50.00\", \"title\": \"Enterprise Subscription\", \"duration\": \"12\", \"quantity\": 1}]', 'cards_bell', '80', 'User', 51, '2025-02-23 14:24:55', '2025-02-23 14:24:55'),
(33, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"12\", \"quantity\": 1}, {\"id\": \"3\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png\", \"price\": \"50.00\", \"title\": \"Enterprise Subscription\", \"duration\": \"12\", \"quantity\": 1}]', 'cards_bell', '80', 'User', 51, '2025-02-23 14:26:18', '2025-02-23 14:26:18'),
(34, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"12\", \"quantity\": 1}, {\"id\": \"3\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png\", \"price\": \"50.00\", \"title\": \"Enterprise Subscription\", \"duration\": \"12\", \"quantity\": 1}]', 'cards_bell', '80', 'User', 51, '2025-02-23 14:27:51', '2025-02-23 14:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` bigint UNSIGNED NOT NULL,
  `blocker_id` bigint UNSIGNED NOT NULL,
  `blocker_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked_id` bigint UNSIGNED NOT NULL,
  `blocked_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` bigint UNSIGNED NOT NULL,
  `views` int NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT '2025-02-18 12:10:21',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `slug`, `image`, `title_ar`, `title_en`, `content_ar`, `content_en`, `author_id`, `active`, `category_id`, `views`, `published_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'https://datafromapi-2.aram-gulf.com/images/services/images/service_5.jpg', 'العناية بالعيون', 'Eye Care', 'نقدم خدمات شاملة للعناية بالعيون لجميع الأعمار، من حديثي الولادة إلى كبار السن. يقدم أطباؤنا المتخصصون في طب العيون فحوصات شاملة للعيون، والكشف المبكر عن أمراض العين، وخيارات علاج لحالات مثل الجلوكوما، إعتام عدسة العين، والتنكس البقعي. كما نخصص خدمات تصحيح الرؤية الشخصية مثل جراحة الليزك، العدسات اللاصقة، والنظارات الطبية. هدفنا هو ضمان صحة عيونك على المدى الطويل ومساعدتك في الحفاظ على رؤية واضحة وصحية طوال حياتك. كما نقدم متابعة دورية ورعاية وقائية للكشف المبكر عن أي مشاكل قد تظهر.', 'We provide comprehensive eye care services for all ages, from newborns to the elderly. Our expert ophthalmologists offer advanced eye exams, early detection of eye diseases, and treatment options for conditions such as glaucoma, cataracts, and macular degeneration. We also specialize in providing personalized vision correction treatments including LASIK surgery, contact lenses, and prescription glasses. Our goal is to ensure the long-term health of your eyes and to help you maintain clear and healthy vision throughout your life. We also offer regular follow-ups and preventative care to catch any potential issues early on.', 42, 1, 8, 0, '2025-02-18 12:10:21', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(2, NULL, 'https://datafromapi-2.aram-gulf.com/images/services/images/service_4.jpg', 'خدمات طب الأسنان', 'Dental Services', 'عيادتنا لطب الأسنان تقدم مجموعة كاملة من الخدمات المصممة للحفاظ على صحة الفم المثلى وتقديم حلول لمختلف القضايا الأسنان. يشمل ذلك الفحوصات الدورية، التنظيف المهني، الحشوات، والعلاجات الوقائية مثل تطبيقات السيلانت والفلواريد. نحن متخصصون في خدمات طب الأسنان التجميلية مثل تبييض الأسنان، الفينير، والتيجان لتحسين مظهر ابتسامتك. كما يعالج فريقنا من المتخصصين في طب الأسنان أمراض اللثة، حساسية الأسنان، ويقوم بعمل قنوات الجذور عند الحاجة. نحن ملتزمون بتقديم رعاية أسنان خالية من الألم وضمان أن كل زيارة مريحة وخالية من التوتر.', 'Our dental clinic offers a full range of dental services designed to maintain optimal oral health and provide solutions for various dental concerns. This includes regular check-ups, professional cleanings, fillings, and preventive treatments such as sealants and fluoride applications. We specialize in cosmetic dentistry services including teeth whitening, veneers, and crowns to enhance the appearance of your smile. Our team of experienced dental professionals also treats gum disease, tooth sensitivity, and performs root canals when necessary. We are dedicated to providing pain-free dental care and ensuring that every visit is comfortable and stress-free.', 41, 1, 14, 0, '2025-02-18 12:10:21', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(3, NULL, 'https://datafromapi-2.aram-gulf.com/images/services/images/service-01.jpg', 'أمراض القلب', 'Cardiology', 'يقدم قسم أمراض القلب لدينا رعاية متخصصة لصحة القلب والأمراض القلبية الوعائية. يقدم فريق من أطباء القلب الخبراء فحوصات قلب شاملة، اختبارات تشخيصية، وخطط علاج مخصصة لحالات مثل أمراض القلب، ارتفاع ضغط الدم، اضطرابات النظم القلبي، وارتفاع الكوليسترول. نحن نقدم تقنيات تشخيصية متطورة مثل تخطيط القلب الكهربائي، تخطيط صدى القلب، واختبارات الإجهاد لمتابعة صحة القلب. بالنسبة للمرضى الذين يعانون من حالات أكثر خطورة، نقدم إجراءات متقدمة مثل بالون الأوعية الدموية، وضع الدعامة، وجراحة القلب. هدفنا هو المساعدة في الوقاية من النوبات القلبية، السكتات الدماغية، والأحداث القلبية الوعائية الأخرى، وضمان أفضل نوعية حياة ممكنة لمرضانا.', 'Our cardiology department offers specialized care for heart health and cardiovascular diseases. Our team of expert cardiologists provides comprehensive heart evaluations, diagnostic testing, and personalized treatment plans for conditions such as heart disease, hypertension, arrhythmias, and high cholesterol. We offer cutting-edge diagnostic technologies such as ECGs, echocardiograms, and stress tests to monitor heart health. For patients with more serious conditions, we provide advanced procedures including angioplasty, stent placement, and heart surgery. Our goal is to help prevent heart attacks, strokes, and other cardiovascular events, ensuring the best possible quality of life for our patients.', 32, 1, 13, 0, '2025-02-18 12:10:21', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(4, NULL, 'https://datafromapi-2.aram-gulf.com/images/services/images/service-01.jpg', 'طب الأطفال', 'Pediatrics', 'نقدم خدمات رعاية صحية متخصصة للأطفال من جميع الأعمار، من حديثي الولادة إلى المراهقين. أطباؤنا المتخصصون في طب الأطفال ملتزمون بتقديم رعاية طبية عالية الجودة، مع التركيز على الوقاية من الأمراض وعلاجها في مرحلة الطفولة. نحن نقدم فحوصات منتظمة لمتابعة النمو والتطور، نقدم التطعيمات، ونوفر العلاجات للمشاكل الصحية الشائعة للأطفال مثل الربو، والحساسية، والتهابات الأذن، وحالات الجلد. كما يتقن أطباؤنا إدارة الحالات المزمنة مثل السكري، فرط النشاط، والتأخر في النمو. نحن نؤكد على النهج الشمولي لصحة الأطفال، حيث ندمج الرفاهية الجسدية والعاطفية في رعايتنا.', 'We provide expert healthcare services for children of all ages, from newborns to adolescents. Our pediatricians are dedicated to providing high-quality medical care, focusing on preventing and treating childhood illnesses. We offer regular check-ups to monitor growth and development, administer vaccinations, and provide treatments for common pediatric issues such as asthma, allergies, ear infections, and skin conditions. Our pediatricians are also skilled in managing chronic conditions like diabetes, ADHD, and developmental delays. We emphasize a holistic approach to children’s health, incorporating both physical and emotional well-being into our care.', 22, 1, 3, 0, '2025-02-18 12:10:21', '2025-02-18 12:39:48', '2025-02-18 12:39:48'),
(5, NULL, 'https://datafromapi-2.aram-gulf.com/images/services/images/service-01.jpg', 'جراحة العظام', 'Orthopedics', 'يقدم قسم جراحة العظام لدينا رعاية متخصصة للعظام والمفاصل والعضلات والأربطة. نحن نقدم علاجات لمجموعة واسعة من المشاكل العظمية مثل الكسور، التهاب المفاصل، الإصابات الرياضية، آلام الظهر، واضطرابات المفاصل. جراحونا المتخصصون في جراحة العظام خبراء في إجراء عمليات مثل استبدال المفاصل، منظار المفصل، وإعادة ترتيب العظام. كما نقدم خدمات العلاج الطبيعي وإعادة التأهيل لمساعدة المرضى على التعافي من الإصابات والجراحة. هدفنا هو استعادة الحركة، تقليل الألم، وتحسين جودة حياة مرضانا.', 'Our orthopedic department provides specialized care for bones, joints, muscles, and ligaments. We offer treatments for a wide range of orthopedic issues including fractures, arthritis, sports injuries, back pain, and joint disorders. Our orthopedic surgeons are experts in performing surgeries such as joint replacements, arthroscopy, and bone realignment. We also provide physical therapy and rehabilitation services to help patients recover from injuries and surgeries. Our goal is to restore mobility, reduce pain, and improve quality of life for our patients.', 28, 1, 5, 0, '2025-02-18 12:10:21', '2025-02-18 12:39:48', '2025-02-18 12:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `book_day` date DEFAULT NULL,
  `book_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('done','waiting','expired','acceptable','unacceptable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `book_day`, `book_time`, `expire_in`, `additional_notes`, `status`, `user_id`, `organization_id`, `created_at`, `updated_at`) VALUES
(1, '2025-02-19', '15:16:00', '2025-03-10', 'ملاحظات إضافية للموعد رقم 1', 'waiting', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(2, '2025-02-20', '10:06:00', '2025-03-06', 'ملاحظات إضافية للموعد رقم 2', 'expired', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(3, '2025-02-21', '14:28:00', '2025-03-12', 'ملاحظات إضافية للموعد رقم 3', 'waiting', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(4, '2025-02-22', '08:35:00', '2025-03-16', 'ملاحظات إضافية للموعد رقم 4', 'expired', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(5, '2025-02-23', '09:08:00', '2025-03-03', 'ملاحظات إضافية للموعد رقم 5', 'acceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(6, '2025-02-24', '11:54:00', '2025-02-25', 'ملاحظات إضافية للموعد رقم 6', 'unacceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(7, '2025-02-25', '12:38:00', '2025-03-27', 'ملاحظات إضافية للموعد رقم 7', 'acceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(8, '2025-02-26', '16:22:00', '2025-03-15', 'ملاحظات إضافية للموعد رقم 8', 'waiting', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(9, '2025-02-27', '12:07:00', '2025-03-23', 'ملاحظات إضافية للموعد رقم 9', 'acceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(10, '2025-02-28', '14:27:00', '2025-03-14', 'ملاحظات إضافية للموعد رقم 10', 'expired', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(11, '2025-03-01', '13:02:00', '2025-03-19', 'ملاحظات إضافية للموعد رقم 11', 'done', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(12, '2025-03-02', '10:37:00', '2025-03-21', 'ملاحظات إضافية للموعد رقم 12', 'done', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(13, '2025-03-03', '13:14:00', '2025-03-14', 'ملاحظات إضافية للموعد رقم 13', 'unacceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(14, '2025-03-04', '13:28:00', '2025-03-25', 'ملاحظات إضافية للموعد رقم 14', 'acceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(15, '2025-03-05', '13:36:00', '2025-03-29', 'ملاحظات إضافية للموعد رقم 15', 'unacceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(16, '2025-03-06', '17:50:00', '2025-03-24', 'ملاحظات إضافية للموعد رقم 16', 'expired', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(17, '2025-03-07', '15:19:00', '2025-03-28', 'ملاحظات إضافية للموعد رقم 17', 'done', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(18, '2025-03-08', '13:37:00', '2025-03-27', 'ملاحظات إضافية للموعد رقم 18', 'acceptable', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(19, '2025-03-09', '16:52:00', '2025-03-23', 'ملاحظات إضافية للموعد رقم 19', 'waiting', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(20, '2025-03-10', '13:02:00', '2025-04-02', 'ملاحظات إضافية للموعد رقم 20', 'done', 51, 12, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(21, '2025-02-22', '10:30 AM', '10:45 AM', NULL, 'waiting', 51, 2, '2025-02-22 08:41:41', '2025-02-22 08:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_types`
--

CREATE TABLE `card_types` (
  `id` bigint UNSIGNED NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_before_discount` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `features_ar` json NOT NULL,
  `features_en` json NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_promotional_purchases` int NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `card_types`
--

INSERT INTO `card_types` (`id`, `title_en`, `title_ar`, `description_en`, `description_ar`, `price_before_discount`, `price`, `features_ar`, `features_en`, `duration`, `image`, `number_of_promotional_purchases`, `active`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Basic Subscription', 'الاشتراك الأساسي', 'A starter plan for individuals.', 'خطة بداية مناسبة للأفراد.', 12.99, 30.00, '\"[\\\"الوصول إلى الميزات الأساسية\\\",\\\"دعم البريد الإلكتروني\\\",\\\"تحليلات بسيطة\\\",\\\"لوحة تحكم مخصصة\\\"]\"', '\"[\\\"Access to basic features\\\",\\\"Email support\\\",\\\"Simple analytics\\\",\\\"Custom dashboard\\\"]\"', '12', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (7)_67b64cb3c8d73.png', 0, 1, 7, NULL, '2025-02-22 08:54:06'),
(2, 'Pro Subscription', 'الاشتراك الاحترافي', 'An advanced plan for professionals.', 'خطة متقدمة للمحترفين.', 25.99, 30.00, '\"[\\\"تحليلات متقدمة\\\",\\\"دعم أولوية\\\",\\\"إدارة الفرق\\\",\\\"مشاريع غير محدودة\\\"]\"', '\"[\\\"Advanced analytics\\\",\\\"Priority support\\\",\\\"Team management\\\",\\\"Unlimited projects\\\"]\"', '12', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png', 3, 1, 6, NULL, '2025-02-23 14:27:51'),
(3, 'Enterprise Subscription', 'اشتراك الشركات', 'A premium plan for businesses.', 'خطة متميزة للشركات.', 55.99, 50.00, '\"[\\\"مدير حساب مخصص\\\",\\\"تكامل مخصص\\\",\\\"أمان محسّن\\\",\\\"دعم على مدار الساعة\\\"]\"', '\"[\\\"Dedicated account manager\\\",\\\"Custom integrations\\\",\\\"Enhanced security\\\",\\\"24/7 support\\\"]\"', '12', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png', 3, 1, 2, NULL, '2025-02-23 14:27:51'),
(4, 'Basic Subscription', 'الاشتراك الأساسي', 'A starter plan for individuals.', 'خطة بداية مناسبة للأفراد.', 12.99, 30.00, '\"[\\\"الوصول إلى الميزات الأساسية\\\",\\\"دعم البريد الإلكتروني\\\",\\\"تحليلات بسيطة\\\",\\\"لوحة تحكم مخصصة\\\"]\"', '\"[\\\"Access to basic features\\\",\\\"Email support\\\",\\\"Simple analytics\\\",\\\"Custom dashboard\\\"]\"', '12', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (14)_67b64d38c6ecb.png', 0, 1, 7, NULL, '2025-02-19 21:32:18'),
(5, 'Pro Subscription', 'الاشتراك الاحترافي', 'An advanced plan for professionals.', 'خطة متقدمة للمحترفين.', 25.99, 19.99, '[\"تحليلات متقدمة\", \"دعم أولوية\", \"إدارة الفرق\", \"مشاريع غير محدودة\"]', '[\"Advanced analytics\", \"Priority support\", \"Team management\", \"Unlimited projects\"]', '1 month', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/card_2_679b299dd99fe.png', 0, 1, 5, NULL, NULL),
(6, 'Enterprise Subscription', 'اشتراك الشركات', 'A premium plan for businesses.', 'خطة متميزة للشركات.', 55.99, 49.99, '[\"مدير حساب مخصص\", \"تكامل مخصص\", \"أمان محسّن\", \"دعم على مدار الساعة\"]', '[\"Dedicated account manager\", \"Custom integrations\", \"Enhanced security\", \"24/7 support\"]', '1 year', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/card_3_676fa576a59ff.jpg', 0, 1, 5, NULL, NULL),
(7, 'Basic Subscription', 'الاشتراك الأساسي', 'A starter plan for individuals.', 'خطة بداية مناسبة للأفراد.', 12.99, 30.00, '\"[\\\"الوصول إلى الميزات الأساسية\\\",\\\"دعم البريد الإلكتروني\\\",\\\"تحليلات بسيطة\\\",\\\"لوحة تحكم مخصصة\\\"]\"', '\"[\\\"Access to basic features\\\",\\\"Email support\\\",\\\"Simple analytics\\\",\\\"Custom dashboard\\\"]\"', '11', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (3)_67b8445121e31.png', 0, 1, 4, NULL, '2025-02-21 09:16:01'),
(8, 'Pro Subscription', 'الاشتراك الاحترافي', 'An advanced plan for professionals.', 'خطة متقدمة للمحترفين.', 25.99, 19.99, '[\"تحليلات متقدمة\", \"دعم أولوية\", \"إدارة الفرق\", \"مشاريع غير محدودة\"]', '[\"Advanced analytics\", \"Priority support\", \"Team management\", \"Unlimited projects\"]', '1 month', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/card_2_679b299dd99fe.png', 0, 1, 2, NULL, NULL),
(9, 'Enterprise Subscription', 'اشتراك الشركات', 'A premium plan for businesses.', 'خطة متميزة للشركات.', 55.99, 49.99, '[\"مدير حساب مخصص\", \"تكامل مخصص\", \"أمان محسّن\", \"دعم على مدار الساعة\"]', '[\"Dedicated account manager\", \"Custom integrations\", \"Enhanced security\", \"24/7 support\"]', '1 year', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/card_3_676fa576a59ff.jpg', 0, 1, 2, NULL, NULL),
(12, 'mmmm', 'mmm', 'nnnnn', 'nnnnn', 49.00, 30.00, '\"[]\"', '\"[]\"', '12', 'https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh aram card_67b9050e1f1e0.png', 0, 0, 11, '2025-02-21 22:58:22', '2025-02-21 22:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `card_type_categories`
--

CREATE TABLE `card_type_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `card_type_categories`
--

INSERT INTO `card_type_categories` (`id`, `title_en`, `title_ar`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Gift Cards', 'بطاقات الهدايا', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/search.png', NULL, NULL),
(2, 'Gaming Cards', 'بطاقات الألعاب', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/facebook_67a6219843bee.png', NULL, NULL),
(3, 'Payment Cards', 'بطاقات الدفع', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/articles.png', NULL, NULL),
(4, 'Shopping Cards', 'بطاقات التسوق', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/blog.png', NULL, NULL),
(5, 'Subscription Cards', 'بطاقات الاشتراكات', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/search.png', NULL, NULL),
(6, 'Entertainment Cards', 'بطاقات الترفيه', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/facebook_67a6219843bee.png', NULL, NULL),
(7, 'Travel Cards', 'بطاقات السفر', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/writing.png', NULL, NULL),
(8, 'Food & Beverage Cards', 'بطاقات المطاعم والمشروبات', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/articles.png', NULL, NULL),
(9, 'Education Cards', 'بطاقات التعليم', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/newspaper.png', NULL, NULL),
(10, 'Healthcare Cards', 'بطاقات الرعاية الصحية', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/facebook_67a6219843bee.png', NULL, NULL),
(11, 'SPORT', 'وقت اللياقة', 'https://datafromapi-2.aram-gulf.com/images/cardTypeCategories/5454-removebg-preview_67b8430ff039f.png', '2025-02-21 09:10:39', '2025-02-21 09:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `card_visits`
--

CREATE TABLE `card_visits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `card_visits`
--

INSERT INTO `card_visits` (`id`, `user_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 11, '50.36.127.217', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(2, 41, '61.78.49.44', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(3, 19, '89.20.221.186', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(4, 14, '184.116.175.105', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(5, 3, '186.205.67.139', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(6, 8, '16.207.152.173', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(7, 12, '144.132.23.77', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(8, 6, '75.20.183.252', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(9, 35, '99.166.42.5', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(10, 45, '153.203.25.120', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(11, 16, '239.199.122.57', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(12, 24, '7.213.98.168', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(13, 4, '193.10.1.33', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(14, 32, '155.177.113.188', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(15, 11, '12.197.33.46', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(16, 19, '247.101.84.180', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(17, 36, '172.44.75.60', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(18, 23, '187.33.118.52', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(19, 31, '251.34.231.159', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(20, 10, '213.149.255.185', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(21, 26, '119.17.38.158', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(22, 34, '137.225.170.212', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(23, 34, '110.110.46.69', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(24, 40, '192.110.91.249', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(25, 32, '9.107.219.174', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(26, 43, '215.189.35.25', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(27, 46, '159.58.165.254', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(28, 30, '20.173.62.87', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(29, 25, '12.78.69.164', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(30, 16, '110.91.156.195', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(31, 40, '25.38.248.119', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(32, 33, '12.105.197.20', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(33, 15, '87.152.225.145', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(34, 37, '206.244.226.118', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(35, 49, '85.249.247.235', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(36, 46, '242.156.153.33', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(37, 5, '239.135.114.32', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(38, 1, '126.145.253.219', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(39, 14, '136.65.255.183', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(40, 12, '17.120.28.246', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(41, 44, '46.140.179.89', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(42, 45, '75.228.47.221', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(43, 1, '223.220.77.69', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(44, 25, '205.8.92.194', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(45, 5, '71.152.211.15', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(46, 31, '204.135.239.36', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(47, 42, '130.51.185.174', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(48, 2, '37.245.220.5', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(49, 18, '237.217.132.120', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(50, 46, '97.131.252.185', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(51, 13, '56.235.48.100', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(52, 38, '214.138.195.101', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(53, 12, '154.153.91.181', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(54, 44, '126.115.88.183', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(55, 17, '181.161.200.230', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(56, 11, '60.177.44.126', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(57, 32, '61.164.50.19', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(58, 22, '110.179.48.192', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(59, 22, '14.40.140.231', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(60, 43, '173.97.188.150', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(61, 49, '119.228.38.255', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(62, 36, '104.77.212.235', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(63, 15, '112.224.208.173', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(64, 47, '127.127.146.230', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(65, 13, '48.37.167.230', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(66, 4, '202.20.186.230', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(67, 18, '91.0.52.141', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(68, 3, '190.117.202.116', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(69, 41, '213.39.101.169', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(70, 9, '232.244.99.89', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(71, 49, '26.178.245.58', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(72, 39, '142.112.127.51', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(73, 25, '49.77.136.240', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(74, 23, '208.210.127.100', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(75, 24, '87.14.59.182', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(76, 8, '199.86.168.107', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(77, 14, '66.25.215.195', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(78, 32, '206.21.192.9', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(79, 28, '203.59.213.202', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(80, 24, '255.161.122.221', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(81, 1, '41.77.130.170', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(82, 38, '105.180.141.250', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(83, 20, '14.210.145.209', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(84, 1, '112.117.180.149', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(85, 12, '197.163.17.122', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(86, 18, '2.144.188.239', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(87, 23, '133.155.187.143', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(88, 31, '141.162.162.86', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(89, 33, '153.242.77.73', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(90, 19, '24.161.15.146', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(91, 32, '8.179.20.232', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(92, 24, '214.244.83.75', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(93, 40, '92.104.66.247', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(94, 31, '95.237.108.222', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(95, 37, '208.248.104.24', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(96, 34, '180.40.84.118', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(97, 49, '26.195.147.203', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(98, 44, '250.100.198.105', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(99, 20, '169.54.25.200', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(100, 37, '230.58.6.129', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(101, 27, '92.11.196.96', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(102, 14, '159.91.134.168', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(103, 34, '41.244.140.167', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(104, 42, '202.70.50.165', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(105, 41, '85.162.140.237', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(106, 26, '53.112.139.218', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(107, 25, '187.176.145.242', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(108, 2, '14.243.180.67', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(109, 33, '188.92.135.229', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(110, 14, '105.96.253.242', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(111, 8, '60.18.185.255', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(112, 41, '137.58.189.65', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(113, 48, '13.9.23.156', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(114, 19, '75.124.91.215', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(115, 5, '150.236.164.209', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(116, 8, '147.174.85.94', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(117, 39, '207.229.35.4', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(118, 36, '62.37.104.113', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(119, 4, '202.127.159.121', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(120, 50, '184.51.79.119', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(121, 50, '51.212.89.176', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(122, 35, '115.238.107.226', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(123, 11, '39.82.95.140', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(124, 47, '175.118.97.211', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(125, 2, '248.240.108.99', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(126, 12, '207.88.212.194', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(127, 17, '135.64.211.1', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(128, 38, '50.52.193.6', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(129, 36, '232.156.37.115', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(130, 9, '145.47.253.149', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(131, 28, '61.58.61.231', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(132, 46, '88.114.5.66', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(133, 33, '192.124.145.162', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(134, 10, '169.127.242.73', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(135, 41, '229.164.221.170', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(136, 43, '94.158.206.168', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(137, 36, '37.8.177.77', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(138, 9, '55.70.210.179', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(139, 15, '19.139.18.133', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(140, 1, '162.143.0.147', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(141, 8, '236.213.12.184', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(142, 44, '54.207.61.186', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(143, 35, '179.205.204.153', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(144, 31, '206.181.128.222', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(145, 45, '169.185.252.134', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(146, 27, '7.219.193.161', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(147, 6, '47.254.226.111', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(148, 42, '82.60.250.134', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(149, 44, '31.176.108.231', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(150, 38, '17.225.137.103', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(151, 21, '230.110.22.24', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(152, 16, '188.117.180.153', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(153, 9, '30.37.229.36', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(154, 49, '144.209.138.219', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(155, 30, '230.1.34.39', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(156, 43, '246.91.175.197', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(157, 25, '10.153.43.225', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(158, 25, '182.39.206.195', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(159, 3, '80.67.10.1', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(160, 5, '127.161.37.77', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(161, 37, '138.133.197.146', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(162, 50, '192.150.237.122', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(163, 37, '142.13.144.189', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(164, 22, '57.223.152.248', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(165, 41, '23.165.176.133', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(166, 7, '167.97.185.146', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(167, 28, '165.68.245.144', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(168, 46, '82.18.132.195', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(169, 27, '96.52.125.13', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(170, 22, '126.138.169.255', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(171, 27, '118.2.55.31', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(172, 41, '95.45.233.29', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(173, 50, '156.15.173.54', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(174, 23, '114.200.61.253', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(175, 50, '56.125.168.19', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(176, 31, '211.170.178.217', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(177, 44, '243.241.11.214', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(178, 36, '39.210.216.241', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(179, 27, '246.123.200.187', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(180, 27, '214.95.101.145', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(181, 13, '219.194.159.64', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(182, 44, '24.186.203.66', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(183, 27, '65.85.146.214', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(184, 35, '150.232.168.128', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(185, 29, '102.16.142.170', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(186, 36, '6.138.121.46', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(187, 15, '24.69.200.173', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(188, 46, '93.172.0.9', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(189, 29, '104.240.17.66', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(190, 37, '32.170.226.146', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(191, 34, '226.76.118.118', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(192, 45, '101.34.5.120', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(193, 41, '184.78.171.80', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(194, 18, '251.76.133.219', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(195, 27, '187.121.110.202', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(196, 31, '31.81.103.197', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(197, 24, '82.46.78.149', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(198, 12, '91.32.127.56', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(199, 16, '242.121.196.218', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(200, 39, '27.238.225.55', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(201, 46, '169.85.48.192', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(202, 1, '114.165.35.139', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(203, 16, '97.226.57.160', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(204, 30, '57.137.75.128', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(205, 13, '242.82.124.250', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(206, 29, '96.160.72.55', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(207, 21, '82.4.54.82', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(208, 3, '193.45.182.213', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(209, 40, '158.64.171.224', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(210, 24, '116.30.153.234', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(211, 32, '53.227.142.94', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(212, 26, '145.205.205.226', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(213, 43, '225.89.236.93', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(214, 12, '69.63.14.218', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(215, 20, '185.48.198.137', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(216, 3, '112.237.130.198', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(217, 41, '134.226.206.152', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(218, 35, '191.184.149.168', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(219, 29, '45.220.179.45', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(220, 50, '254.111.153.171', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(221, 23, '48.246.203.103', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(222, 40, '76.227.101.33', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(223, 44, '23.93.240.138', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(224, 12, '175.72.185.229', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(225, 38, '135.85.126.239', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(226, 20, '200.142.13.56', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(227, 50, '25.7.133.235', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(228, 16, '145.137.25.144', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(229, 7, '237.79.184.152', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(230, 39, '192.28.90.57', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(231, 44, '51.106.214.75', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(232, 18, '38.98.93.202', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(233, 4, '71.145.113.122', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(234, 29, '170.194.42.229', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(235, 31, '234.234.252.197', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(236, 31, '40.42.103.236', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(237, 28, '56.19.50.242', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(238, 30, '178.12.38.114', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(239, 16, '184.5.189.14', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(240, 47, '252.152.190.71', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(241, 6, '20.247.66.129', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(242, 28, '130.184.117.196', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(243, 30, '25.100.255.61', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(244, 50, '50.198.180.149', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(245, 6, '36.94.73.193', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(246, 1, '76.61.105.185', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(247, 23, '182.199.229.64', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(248, 33, '236.238.65.137', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(249, 44, '192.134.116.59', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(250, 4, '175.119.176.96', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(251, 8, '204.166.224.57', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(252, 13, '19.122.66.97', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(253, 16, '56.96.161.131', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(254, 25, '124.149.9.248', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(255, 19, '207.228.139.201', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(256, 23, '253.91.174.201', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(257, 36, '120.196.70.131', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(258, 26, '150.170.240.106', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(259, 40, '12.111.83.106', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(260, 25, '144.157.249.80', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(261, 27, '58.39.63.66', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(262, 28, '181.182.204.78', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(263, 2, '8.245.28.221', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(264, 35, '113.114.16.44', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(265, 5, '87.65.121.66', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(266, 34, '234.26.150.180', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(267, 21, '77.205.81.140', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(268, 18, '252.133.129.144', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(269, 37, '193.177.158.151', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(270, 24, '110.192.78.25', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(271, 28, '56.241.154.230', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(272, 46, '25.251.94.92', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(273, 4, '252.87.49.135', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(274, 31, '70.253.176.115', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(275, 40, '1.15.11.142', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(276, 26, '66.221.223.30', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(277, 1, '112.238.182.124', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(278, 19, '8.191.83.30', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(279, 38, '242.221.202.16', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(280, 35, '230.187.239.72', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(281, 1, '67.118.201.39', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(282, 25, '230.69.180.218', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(283, 43, '245.188.22.178', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(284, 49, '32.94.255.46', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(285, 46, '173.95.22.18', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(286, 46, '215.251.115.58', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(287, 27, '185.191.121.105', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(288, 18, '220.3.216.30', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(289, 36, '251.61.15.51', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(290, 48, '225.106.50.247', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(291, 26, '70.229.18.137', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(292, 30, '29.111.195.206', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(293, 13, '24.140.83.53', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(294, 26, '204.227.67.219', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(295, 25, '115.38.79.165', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(296, 23, '90.59.22.62', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(297, 20, '229.33.155.170', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(298, 4, '89.201.186.83', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(299, 33, '100.104.140.13', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(300, 20, '194.135.116.225', '2025-02-18 12:39:53', '2025-02-18 12:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `user_type`, `content`, `created_at`, `updated_at`) VALUES
(1, 9, 6, 'Organization', 'Asperiores expedita non et placeat doloribus eum cumque delectus voluptate ea mollitia est.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(2, 9, 18, 'User', 'Nihil qui suscipit quis facilis officia praesentium commodi laudantium cum.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(3, 9, 44, 'Organization', 'Deserunt laudantium laboriosam cumque eum commodi ea.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(4, 9, 49, 'Organization', 'Commodi enim consequatur delectus fuga sit enim.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(5, 9, 4, 'Organization', 'Aut adipisci sequi odit labore rerum animi.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(6, 9, 43, 'User', 'Aut voluptates temporibus debitis quia ut saepe.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(7, 9, 17, 'User', 'Magnam atque neque quod recusandae tempore voluptatum delectus.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(8, 9, 16, 'User', 'Molestiae maxime officia voluptatem neque sit aliquid blanditiis.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(9, 9, 36, 'Organization', 'Est minima quia voluptates id rem et sit.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(10, 9, 48, 'User', 'Eos et molestias quia qui et aliquid molestias omnis dolores eum.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(11, 9, 22, 'User', 'Et accusamus nisi quis mollitia sed eius amet nam dolor.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(12, 9, 9, 'User', 'Consequatur eveniet quia fugit fuga laboriosam quo praesentium.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(13, 9, 28, 'User', 'Eius fugit quibusdam magnam ipsa ipsum veritatis quis quod eos omnis illum sunt.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(14, 9, 29, 'Organization', 'Modi hic enim ut natus suscipit doloribus nesciunt minus et aut exercitationem aspernatur.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(15, 9, 49, 'User', 'Qui est totam iusto provident rem deserunt inventore ut tempora minima quis.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(16, 9, 48, 'User', 'Autem quas perferendis similique iste in cum corporis voluptas dolore quae ut.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(17, 9, 27, 'User', 'Necessitatibus qui laborum eos consequuntur et qui tempora.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(18, 9, 3, 'Organization', 'Quas ipsam maiores vel fuga occaecati aut dolor fugiat quia dolores inventore autem.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(19, 9, 11, 'Organization', 'Animi dolores molestiae eum et corrupti dolore eos sunt ab velit quod.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(20, 9, 18, 'User', 'Aperiam dolorum quae ducimus et molestiae quia voluptatem ut qui nisi.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(21, 9, 31, 'User', 'Laborum voluptas porro unde et similique nisi natus.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(22, 9, 14, 'User', 'Eaque vero necessitatibus est veritatis quisquam blanditiis veniam iusto dignissimos quis quidem.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(23, 9, 6, 'User', 'Blanditiis magnam ea excepturi accusantium minima sint sed occaecati voluptatem.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(24, 9, 2, 'User', 'Laudantium et odio totam quia corrupti omnis sit quibusdam corrupti necessitatibus eius repellat doloribus.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(25, 9, 44, 'User', 'Et sed consequatur fugit quam illo aut.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(26, 9, 49, 'Organization', 'Eius amet velit minima ad in officia numquam facilis quia placeat sit dolorem.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(27, 9, 30, 'Organization', 'Molestiae placeat et est quasi pariatur deserunt eos numquam quidem ratione cumque.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(28, 9, 6, 'User', 'Ea fugiat provident et voluptas incidunt aliquam nisi sit quam.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(29, 9, 9, 'User', 'Cumque ea veritatis eum earum animi ut aliquam.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(30, 9, 28, 'User', 'Quibusdam illo molestiae hic quis doloribus tempora beatae voluptatibus qui quas ex.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(31, 9, 2, 'User', 'Necessitatibus a est voluptates voluptate fugit vitae.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(32, 9, 27, 'User', 'Ad libero quasi ipsam minus ipsa dolor reiciendis fuga ad.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(33, 9, 25, 'User', 'Fuga in dolores nesciunt assumenda at sed repellat voluptatibus sint ut.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(34, 9, 7, 'User', 'Omnis voluptatem exercitationem harum aut consequuntur dolores pariatur ut.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(35, 9, 27, 'Organization', 'Et veniam dicta quia voluptatem reprehenderit dignissimos est.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(36, 9, 31, 'Organization', 'Et culpa magnam quia aut exercitationem quam nesciunt.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(37, 9, 13, 'User', 'In numquam enim ducimus sed voluptatem odio et nostrum corporis.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(38, 9, 8, 'Organization', 'Adipisci quas nesciunt qui ea veritatis aut nihil.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(39, 9, 38, 'User', 'Impedit cumque nam porro omnis cum qui et.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(40, 9, 19, 'User', 'Cupiditate dolore debitis fugit nobis quas nobis ut non laborum distinctio molestiae qui.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(41, 9, 38, 'Organization', 'Aut quisquam quia nihil quibusdam nam dolorem quisquam sint nulla repellendus distinctio.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(42, 9, 50, 'User', 'Voluptates sit cum sint omnis iure architecto repellendus vero exercitationem id et.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(43, 9, 42, 'Organization', 'Et id iure sit nam et magnam sunt quasi iusto autem.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(44, 9, 7, 'User', 'Ullam molestiae cum voluptatem error in qui quidem.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(45, 9, 39, 'User', 'Nemo itaque maxime velit aliquam nostrum dolorum ut perspiciatis sequi quasi et dicta.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(46, 9, 28, 'Organization', 'Assumenda earum at at numquam quas non.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(47, 9, 18, 'User', 'Voluptates amet blanditiis reiciendis et delectus quasi nemo voluptatibus est non accusamus.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(48, 9, 40, 'Organization', 'Velit aut dolore doloribus dignissimos sed perspiciatis aliquid non sit.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(49, 9, 18, 'Organization', 'Sunt sint enim quia fugiat explicabo amet perspiciatis ut et earum ab perspiciatis nisi.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(50, 9, 33, 'User', 'Perspiciatis et atque reiciendis exercitationem amet reiciendis ut consequatur.', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(51, 3, 51, 'User', 'hi', '2025-02-18 13:26:16', '2025-02-18 13:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `company_detailes`
--

CREATE TABLE `company_detailes` (
  `id` bigint UNSIGNED NOT NULL,
  `whatsapp_number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gmail_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `x_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instgram_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `snapchat_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `about_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vision_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vision_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `goals_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `goals_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `values_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `values_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_map` tinyint(1) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cooperation_pdf` text COLLATE utf8mb4_unicode_ci,
  `about_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vision_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goals_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `values_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_detailes`
--

INSERT INTO `company_detailes` (`id`, `whatsapp_number`, `gmail_account`, `facebook_account`, `x_account`, `youtube_account`, `instgram_account`, `snapchat_account`, `about_ar`, `about_en`, `vision_ar`, `vision_en`, `goals_ar`, `goals_en`, `values_en`, `values_ar`, `show_map`, `address`, `cooperation_pdf`, `about_image`, `vision_image`, `goals_image`, `values_image`, `main_video`, `created_at`, `updated_at`) VALUES
(1, '2', 'sd', 's', 'sd', 'sd', 'sd', 'sd', 'sd', 'sd', 'sds', 'sd', 'sd', 'sd', 'ds', 'sd', 0, NULL, 'https://datafromapi-2.aram-gulf.com/uploads/pdfs/اتفاقية_تعاون_المراكز_ارام_(7)[1]_67bc84794dce4.pdf', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-24 14:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','reviewed','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone_number`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Waldo Ratke', 'ilene12@example.org', '470.438.5946', NULL, 'Voluptatibus esse quae et animi ipsa tempore porro.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(2, 'Aurelie Cummerata DDS', 'dianna73@example.org', '561.671.5657', NULL, 'Officia neque eum nemo sint rem optio quod repellat enim voluptatem consequatur laboriosam quibusdam.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(3, 'Dock Frami III', 'aufderhar.melisa@example.net', '+1-616-768-2861', NULL, 'Praesentium officia cumque quo labore maiores et ut est ut ducimus.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(4, 'Dr. Izaiah Willms III', 'nienow.crystel@example.com', '+1-279-454-7191', NULL, 'Incidunt saepe sint dolorum dolorum esse neque quidem dolor deserunt cum rerum.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(5, 'Frida Zulauf', 'kihn.elda@example.net', '+1 (830) 776-8463', NULL, 'Iusto dolores sit aperiam voluptatum voluptatum veniam neque voluptas.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(6, 'Kathlyn Emmerich', 'arden.glover@example.com', '937-595-5307', NULL, 'Assumenda id consequatur deserunt dicta rerum qui sequi similique.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(7, 'Miss Dahlia Krajcik PhD', 'brandon57@example.net', '619.486.4816', NULL, 'Totam dignissimos tenetur vitae iste minus velit suscipit sint qui impedit soluta maxime.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(8, 'Emmitt Strosin', 'julie.wilderman@example.com', '+15868495573', NULL, 'Aut sunt voluptatibus maiores est rerum ea est quod porro voluptas aperiam consectetur voluptates.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(9, 'Mrs. Genesis Baumbach', 'natasha07@example.net', '1-972-956-9500', NULL, 'Quia qui natus tempora iste voluptates minima quidem pariatur.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(10, 'Libbie Willms', 'wyatt31@example.net', '+1-689-851-4077', NULL, 'Fugiat culpa sequi a neque alias ullam voluptas ipsa rem perspiciatis ut.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(11, 'Jayda Nicolas', 'bosco.oliver@example.com', '1-847-783-2125', NULL, 'Aut et tempora et doloremque velit occaecati.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(12, 'Arno Stroman', 'bertram.kovacek@example.org', '949-562-7994', NULL, 'Dolores occaecati quo recusandae laudantium assumenda non ut eum alias sapiente et.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(13, 'Leonora Reichert', 'trever.stracke@example.net', '341-366-5004', NULL, 'Ea facilis eum neque maxime numquam commodi facilis fugit totam sed blanditiis.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(14, 'Prof. Emilio Baumbach', 'green47@example.net', '+1-959-260-3351', NULL, 'Repellendus atque earum esse tenetur natus labore consequatur omnis.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(15, 'Miss Laurianne Walter Sr.', 'zboncak.anna@example.com', '(224) 429-9144', NULL, 'Magni provident eius commodi culpa dolorem atque debitis quibusdam ab.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(16, 'Kenneth Waters PhD', 'bailey.korey@example.com', '+1.828.404.5739', NULL, 'Assumenda omnis aut impedit a qui provident et velit voluptatibus quidem et.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(17, 'Nolan Hoeger', 'sdubuque@example.net', '+1-231-615-0596', NULL, 'Nihil nulla nulla laudantium harum qui nihil rerum quas omnis dolores eius et voluptatem.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(18, 'Dr. Stuart Denesik', 'wiza.myra@example.org', '445-896-6300', NULL, 'Asperiores id tenetur temporibus culpa esse consectetur corrupti accusamus et aut.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(19, 'Fae Casper MD', 'dschulist@example.org', '743-337-7406', NULL, 'Qui eos quidem incidunt voluptatem aut occaecati aliquid culpa consequatur eum eum.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(20, 'Joana Wuckert', 'ilindgren@example.org', '986-595-3683', NULL, 'Sit quidem est consectetur odit soluta reprehenderit sunt qui.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(21, 'Cicero Rowe', 'agerlach@example.net', '1-612-943-9213', NULL, 'Inventore iusto vero aut reiciendis corporis quia rerum laboriosam est.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(22, 'Adella Roob', 'mdickinson@example.org', '+1-341-803-4026', NULL, 'Voluptatem qui et corrupti molestiae velit laborum vel quos quam voluptates voluptatum ea.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(23, 'Misty Nader', 'chloe.mcglynn@example.com', '603.416.5128', NULL, 'Quasi dolores in dolor est quo deleniti voluptate autem ad possimus.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(24, 'Elouise Willms', 'talon61@example.net', '+1-616-468-4698', NULL, 'Qui cupiditate nisi a molestiae non sit.', 'reviewed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(25, 'Jazlyn Balistreri', 'amaggio@example.com', '(858) 368-1242', NULL, 'Dolorem velit tempora optio delectus et vel dolore pariatur.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(26, 'Stephen Fahey', 'major.mccullough@example.org', '+1-860-848-1059', NULL, 'Possimus eveniet voluptatem et consequatur sed perspiciatis qui et atque ad molestiae dolorem iure.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(27, 'Dr. Coby Miller Sr.', 'zbechtelar@example.net', '1-985-529-4842', NULL, 'Officiis ab magni reprehenderit nihil rem odio accusantium.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(28, 'Geo Jakubowski', 'modesto46@example.net', '+1.352.591.3792', NULL, 'Aut rem pariatur quidem rerum quod ducimus sapiente.', 'pending', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(29, 'Wade Ruecker I', 'lia07@example.net', '+1.530.919.5170', NULL, 'Repellendus autem at optio est voluptatem et dolores rerum aut earum.', 'reviewed', '2025-02-18 12:39:53', '2025-02-21 20:11:26'),
(30, 'Dr. Maddison Upton IV', 'gaston.altenwerth@example.net', '1-540-915-0579', NULL, 'Architecto mollitia veniam veniam eveniet et corporis laudantium numquam aut at quo similique quod.', 'closed', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(31, 'Shawakh Alborsan', 'shawakh@borsanacademy.com', '+1-231-615-0596', NULL, 'مرحبا ارام', 'reviewed', '2025-02-21 10:10:48', '2025-02-21 10:11:54'),
(32, 'Shawakh Alborsan', 'shawakh@borsanacademy.com', '+1-231-615-0596', NULL, 'ارام مرحبا لدي مشكلة', 'reviewed', '2025-02-21 10:13:01', '2025-02-21 20:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `participant_one_id` bigint UNSIGNED NOT NULL,
  `participant_one_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participant_two_id` bigint UNSIGNED NOT NULL,
  `participant_two_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_by` json DEFAULT NULL,
  `blocked_by` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `participant_one_id`, `participant_one_type`, `participant_two_id`, `participant_two_type`, `deleted_by`, `blocked_by`, `created_at`, `updated_at`) VALUES
(2, 63, 'User', 22, 'Organization', NULL, '[]', '2025-02-23 10:39:31', '2025-02-23 10:42:05'),
(3, 63, 'User', 1, 'User', NULL, NULL, '2025-02-23 11:00:52', '2025-02-23 11:00:52'),
(4, 68, 'User', 22, 'Organization', NULL, NULL, '2025-02-23 11:13:34', '2025-02-23 11:13:34'),
(5, 64, 'User', 1, 'User', NULL, NULL, '2025-02-24 12:24:27', '2025-02-24 12:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `copones`
--

CREATE TABLE `copones` (
  `id` bigint UNSIGNED NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `number_of_uses` int NOT NULL DEFAULT '0',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `status` enum('waiting','active','expired') COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `organization_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `copones`
--

INSERT INTO `copones` (`id`, `title_ar`, `title_en`, `image`, `description_ar`, `description_en`, `number_of_uses`, `code`, `discount_value`, `start_date`, `status`, `end_date`, `is_active`, `organization_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'عرض adipisci', 'Offer sit', 'https://datafromapi-2.aram-gulf.com/images/offers/service_6.jpg', 'Vel id ut aut. Et maiores fugiat et deleniti voluptatibus tempore. Consequatur nulla nisi id non dolor.', 'Ipsa ad neque maiores sunt velit nisi minus nobis. Inventore harum non occaecati vero non occaecati. Error voluptates quia temporibus ipsum. Aperiam culpa error placeat sed et delectus odit.', 0, 'OFF41417', 14.11, '2025-02-16', 'waiting', '2025-02-21', 1, 13, 3, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(2, 'عرض hic', 'Offer voluptatum', 'https://datafromapi-2.aram-gulf.com/images/offers/service_1_679f9d4a131a8.jpg', 'Debitis eveniet quod voluptatem et quae expedita in. Asperiores dolorum non mollitia harum consectetur ut harum. Numquam aut sed animi architecto excepturi nihil.', 'Soluta velit aut et ullam. Similique voluptate iusto quia minima soluta eum. Itaque repudiandae et atque facilis illo omnis. Id nisi autem ullam voluptatem molestiae eum atque.', 0, 'OFF08365', 33.96, '2025-01-25', 'waiting', '2025-03-05', 1, 14, 5, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(3, 'عرض sed', 'Offer sit', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_679b1eb33a8fe.jpg', 'Quis ducimus aut cupiditate in. Sed et commodi molestiae omnis veritatis sunt molestiae. Ipsa possimus minus sequi. Sequi est ut officia. Molestias et rem alias laudantium eveniet facere neque dignissimos.', 'Magnam expedita quisquam quia non qui autem. Ex omnis quo earum facilis iusto vitae vel. Vitae enim tempora occaecati at saepe ex nihil. Placeat voluptatem distinctio similique fugiat.', 0, 'OFF98396', 29.19, '2025-01-18', 'waiting', '2025-03-14', 1, 12, 20, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(4, 'عرض voluptatibus', 'Offer quia', 'https://datafromapi-2.aram-gulf.com/images/offers/service_2_67b2f396b4c52.jpg', 'Veritatis saepe et temporibus voluptas necessitatibus aut dolor. Labore excepturi voluptatum autem vel laborum ut veniam. Quae voluptas dignissimos amet accusamus delectus.', 'Laudantium et a assumenda impedit modi. Quam placeat incidunt molestiae voluptas quos. Impedit fugiat ab alias dolorem tempore optio totam.', 0, 'OFF54244', 44.28, '2025-02-13', 'waiting', '2025-03-06', 0, 9, 14, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(5, 'عرض qui', 'Offer quam', 'https://datafromapi-2.aram-gulf.com/images/offers/service-02.jpg', 'Laudantium qui quae autem sit. Earum dolor est iste delectus. Amet ut molestiae necessitatibus eos aliquid accusamus neque.', 'Ipsam et est et qui soluta. At ipsam fugiat repellendus voluptatem itaque deserunt perferendis. Itaque ut dolores non officia reprehenderit dolor.', 0, 'OFF46158', 33.35, '2025-02-12', 'waiting', '2025-02-19', 1, 15, 15, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(6, 'عرض alias', 'Offer fugit', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_67b333afb1112.jpg', 'Vel aut exercitationem deserunt illum saepe dolorem expedita debitis. Quis perferendis dignissimos assumenda qui reprehenderit rerum vero. Eos necessitatibus rerum cum id sint impedit. Natus quia dolores itaque velit et sint qui.', 'Ratione ut omnis enim voluptas. Distinctio dolor dolor et omnis voluptas. Repellendus deleniti asperiores ea quas quos.', 0, 'OFF14404', 21.14, '2025-02-03', 'waiting', '2025-03-12', 1, 5, 15, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(7, 'عرض voluptatem', 'Offer repellat', 'https://datafromapi-2.aram-gulf.com/images/offers/service_4_67ac50c73a0b4.jpg', 'Ipsa autem minus facere a amet pariatur. Quis iste nostrum dolorem voluptatem eius occaecati. Nobis accusamus qui nulla. Voluptatem nobis dolor quis sit est.', 'Veritatis perferendis voluptatibus omnis. Non non autem non quia alias rem qui. Esse voluptatem inventore voluptate et exercitationem. Eius eos ad voluptas rerum quibusdam.', 0, 'OFF52347', 20.38, '2025-01-20', 'waiting', '2025-03-11', 1, 18, 11, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(8, 'عرض sed', 'Offer et', 'https://datafromapi-2.aram-gulf.com/images/offers/service_3_6799b91a31976.jpg', 'Sit doloribus doloremque doloremque exercitationem optio praesentium voluptatem. Odio soluta rem hic et voluptatem itaque corrupti. Amet animi aspernatur nisi est et. Id laudantium vel quia modi molestiae.', 'Aut quae consequatur omnis et. Est veritatis ut quibusdam quia quae. Illo voluptatem odio et voluptatem deserunt temporibus est.', 0, 'OFF90164', 29.44, '2025-01-28', 'waiting', '2025-03-02', 1, 14, 3, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(9, 'عرض illum', 'Offer libero', 'https://datafromapi-2.aram-gulf.com/images/offers/service_1_679f9d4a131a8.jpg', 'Sunt enim aut quis. Corporis quos quam consequatur sunt. Ea tenetur et non rerum minima omnis veritatis. Repellat est inventore eveniet est sapiente unde nulla ipsum.', 'Aut odio et labore natus dignissimos facilis labore. Molestiae sit ullam optio ea. Ipsa excepturi qui dicta.', 0, 'OFF33247', 24.30, '2025-01-28', 'waiting', '2025-02-24', 1, 2, 5, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(10, 'عرض ab', 'Offer et', 'https://datafromapi-2.aram-gulf.com/images/offers/service_1_679f9d4a131a8.jpg', 'Repellendus ipsam eligendi libero ea laudantium occaecati numquam. Veritatis et distinctio modi eveniet reiciendis. Repudiandae vitae eligendi quos qui.', 'Hic ut vitae cum illo id iste voluptatem. Modi in et sint totam et in commodi et.', 0, 'OFF97851', 25.73, '2025-02-06', 'waiting', '2025-03-12', 1, 5, 7, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(11, 'عرض ea', 'Offer voluptates', 'https://datafromapi-2.aram-gulf.com/images/offers/service_1_679f9d4a131a8.jpg', 'Tempora mollitia dolores illo. Veniam et culpa qui veniam quidem voluptas. Eligendi magni et possimus sint iste assumenda.', 'Delectus omnis quam adipisci sapiente nobis veniam perferendis id. Aut veniam occaecati facere iure dolorem ea pariatur quia. Sunt ut distinctio est.', 0, 'OFF56025', 41.94, '2025-01-27', 'waiting', '2025-03-14', 1, 2, 2, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(12, 'عرض quaerat', 'Offer voluptates', 'https://datafromapi-2.aram-gulf.com/images/offers/service_3_6799b91a31976.jpg', 'Reiciendis velit molestiae beatae enim doloremque autem nostrum. Quos soluta sunt nam ut velit hic possimus et. Voluptatibus non in totam voluptates facere molestiae nisi.', 'Possimus ratione minus sit inventore assumenda sed molestias quas. Numquam rem quis est autem ut. Ut a et quasi velit quo necessitatibus ut.', 0, 'OFF85193', 15.08, '2025-02-13', 'waiting', '2025-03-01', 1, 10, 8, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(13, 'عرض voluptas', 'Offer culpa', 'https://datafromapi-2.aram-gulf.com/images/offers/service_3_6799b91a31976.jpg', 'Ipsam sunt provident eveniet minima qui. Perferendis aut beatae nihil. Animi et quia eos ea necessitatibus. Ipsa maiores eius error.', 'Iusto distinctio ut repellat adipisci earum soluta fuga. A neque reprehenderit recusandae. Aperiam error ut est et. Inventore vero voluptatem et nesciunt aut aliquid libero.', 0, 'OFF05404', 23.73, '2025-01-28', 'waiting', '2025-03-06', 1, 8, 20, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(14, 'عرض qui', 'Offer non', 'https://datafromapi-2.aram-gulf.com/images/offers/service_3_6799b91a31976.jpg', 'Molestias dolorem praesentium aperiam. Necessitatibus et nemo vel. Occaecati totam vitae ducimus aut commodi.', 'Voluptas unde maxime eveniet sunt repellat dolorem at est. Quibusdam iure aut facere in sed qui. Aut fuga quasi corrupti quaerat.', 0, 'OFF54246', 29.91, '2025-02-13', 'waiting', '2025-03-12', 1, 8, 20, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(15, 'عرض provident', 'Offer provident', 'https://datafromapi-2.aram-gulf.com/images/offers/service_2_679b1dcf6cd99.jpg', 'Voluptatem consequuntur aperiam hic praesentium et non. Autem repellat non assumenda harum esse. Voluptatem at rerum asperiores accusamus nihil.', 'Repellat repellendus vel soluta. Enim modi aperiam nihil cum hic. Hic velit animi consequatur fugit eum fugit exercitationem quis.', 0, 'OFF36602', 45.03, '2025-02-15', 'waiting', '2025-03-06', 1, 2, 19, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(16, 'عرض quia', 'Offer placeat', 'https://datafromapi-2.aram-gulf.com/images/offers/service_3_6799b91a31976.jpg', 'Ipsum voluptate qui natus. Aut tempora suscipit asperiores. Beatae pariatur dolor suscipit dolorem vero autem. Pariatur quaerat libero quos nulla est.', 'Numquam dicta rerum pariatur repellendus voluptas qui illo. Nisi necessitatibus possimus non voluptas ut. Nihil corporis expedita optio tenetur aut. Quibusdam quam voluptas necessitatibus odio tempora similique fugit.', 0, 'OFF97560', 30.01, '2025-02-15', 'waiting', '2025-03-04', 0, 7, 3, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(17, 'عرض commodi', 'Offer praesentium', 'https://datafromapi-2.aram-gulf.com/images/offers/service_5_679fced3ba66c.jpg', 'Ducimus consectetur est reprehenderit deleniti consequatur dolore aperiam. Ex ut accusamus ea aut est. Ipsam excepturi asperiores quod sed. Maxime exercitationem mollitia cum quibusdam praesentium quia excepturi.', 'Laboriosam ipsum rerum voluptates tempora quia. Ex culpa voluptas ratione id cum. Ex vero sed eum. Et aut necessitatibus occaecati autem deleniti.', 0, 'OFF14468', 5.53, '2025-02-09', 'waiting', '2025-02-25', 0, 14, 15, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(18, 'عرض nisi', 'Offer consequatur', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_67b333afb1112.jpg', 'Et facilis maxime eius. Iste labore eaque et qui. Repudiandae consequatur perspiciatis porro iure labore fuga in.', 'Aut qui dolore et asperiores. Maiores consequuntur aut dolorum enim illo delectus. Eveniet veritatis amet ex blanditiis ea autem magni. Sit blanditiis ea voluptatem ea vel.', 0, 'OFF56845', 30.36, '2025-01-31', 'waiting', '2025-03-08', 1, 6, 9, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(19, 'عرض voluptatem', 'Offer illum', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_679b1eb33a8fe.jpg', 'Aliquid deserunt reprehenderit vero ut nobis qui. Et porro facilis est dolores. Est culpa praesentium ex sed.', 'Aperiam minus et quia sit. Nisi similique minima reprehenderit voluptas in rerum culpa qui. Saepe pariatur accusamus quam est ducimus molestiae inventore voluptas. Neque rerum ea non doloremque et quaerat.', 0, 'OFF36296', 38.36, '2025-01-29', 'waiting', '2025-03-13', 0, 18, 8, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(20, 'عرض ab', 'Offer quis', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_679b1eb33a8fe.jpg', 'Nihil ut quo dolorem quo. Nisi non itaque nostrum non odit magni sit. Quasi architecto illo in fugiat corporis.', 'Qui vel qui quaerat exercitationem eum. Corporis inventore autem harum nulla incidunt quos nihil. Fuga aliquid blanditiis ut qui. Cum in consequatur officiis et officiis ut.', 0, 'OFF92978', 49.87, '2025-01-21', 'waiting', '2025-03-17', 1, 2, 14, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(21, 'test', 'test', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_67b5d96584007.jpg', 'test', 'test', 0, 'DDAmwOTL7M', 12.00, '2025-02-20', 'waiting', '2025-02-28', 0, 20, 7, '2025-02-19 13:15:17', '2025-02-19 13:15:17'),
(22, 'اختبار -3', 'test-2', 'https://datafromapi-2.aram-gulf.com/images/offers/ARAM CARD (3)_67b662e9d9a61.png', 'jjjj', 'hhhhh', 0, 'kO46ieCpTB', 28.00, '2025-02-01', 'active', '2025-12-03', 1, 5, 1, '2025-02-19 23:02:01', '2025-02-19 23:02:01'),
(23, 'بورسان', 'borsan', 'https://datafromapi-2.aram-gulf.com/images/offers/ARAM CARD (2)_67b84555a7076.png', 'كوبون السياحة', 'TOURISM', 0, 'E4WjIuwmQa', 20.00, '2025-02-20', 'active', '2025-03-02', 1, 1, 1, '2025-02-21 09:20:21', '2025-02-21 09:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_user`
--

CREATE TABLE `coupon_user` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `coupon_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_user`
--

INSERT INTO `coupon_user` (`id`, `user_id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(1, 51, 21, '2025-02-19 13:15:52', '2025-02-19 13:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_transactions`
--

CREATE TABLE `financial_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `bell_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_operation` enum('deposit','withdraw') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bell_items` json NOT NULL,
  `amount` int NOT NULL,
  `balance_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('waiting','done','refused') COLLATE utf8mb4_unicode_ci DEFAULT 'waiting',
  `user_id` bigint UNSIGNED NOT NULL,
  `bell_id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_transactions`
--

INSERT INTO `financial_transactions` (`id`, `bell_type`, `type_operation`, `account_type`, `bell_items`, `amount`, `balance_type`, `status`, `user_id`, `bell_id`, `organization_id`, `created_at`, `updated_at`) VALUES
(1, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:15 PM\", \"expire_in\": \"12:30 PM\", \"organization_id\": 10, \"additional_notes\": null}', 132, 'pending_balance', 'waiting', 1, 1, 10, '2025-02-18 12:15:49', '2025-02-18 12:15:49'),
(3, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:18 PM\", \"expire_in\": \"12:33 PM\", \"organization_id\": 10, \"additional_notes\": null}', 90, 'pending_balance', 'waiting', 1, 3, 10, '2025-02-18 12:18:09', '2025-02-18 12:18:09'),
(4, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:18 PM\", \"expire_in\": \"12:33 PM\", \"organization_id\": 12, \"additional_notes\": null}', 267, 'pending_balance', 'waiting', 2, 4, 12, '2025-02-18 12:18:09', '2025-02-18 12:18:09'),
(5, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:18 PM\", \"expire_in\": \"12:33 PM\", \"organization_id\": 15, \"additional_notes\": null}', 278, 'pending_balance', 'waiting', 3, 5, 15, '2025-02-18 12:18:09', '2025-02-18 12:18:09'),
(6, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:19 PM\", \"expire_in\": \"12:34 PM\", \"organization_id\": 10, \"additional_notes\": null}', 209, 'pending_balance', 'waiting', 1, 6, 10, '2025-02-18 12:19:10', '2025-02-18 12:19:10'),
(7, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:19 PM\", \"expire_in\": \"12:34 PM\", \"organization_id\": 12, \"additional_notes\": null}', 467, 'pending_balance', 'waiting', 2, 7, 12, '2025-02-18 12:19:10', '2025-02-18 12:19:10'),
(8, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:19 PM\", \"expire_in\": \"12:34 PM\", \"organization_id\": 15, \"additional_notes\": null}', 439, 'pending_balance', 'waiting', 3, 8, 15, '2025-02-18 12:19:10', '2025-02-18 12:19:10'),
(9, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:20 PM\", \"expire_in\": \"12:35 PM\", \"organization_id\": 10, \"additional_notes\": null}', 119, 'pending_balance', 'waiting', 1, 9, 10, '2025-02-18 12:20:05', '2025-02-18 12:20:05'),
(10, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:20 PM\", \"expire_in\": \"12:35 PM\", \"organization_id\": 12, \"additional_notes\": null}', 58, 'pending_balance', 'waiting', 2, 10, 12, '2025-02-18 12:20:05', '2025-02-18 12:20:05'),
(11, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:20 PM\", \"expire_in\": \"12:35 PM\", \"organization_id\": 15, \"additional_notes\": null}', 352, 'pending_balance', 'waiting', 3, 11, 15, '2025-02-18 12:20:05', '2025-02-18 12:20:05'),
(12, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:21 PM\", \"expire_in\": \"12:36 PM\", \"organization_id\": 10, \"additional_notes\": null}', 148, 'pending_balance', 'waiting', 1, 12, 10, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(13, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:21 PM\", \"expire_in\": \"12:36 PM\", \"organization_id\": 12, \"additional_notes\": null}', 231, 'pending_balance', 'waiting', 2, 13, 12, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(14, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:21 PM\", \"expire_in\": \"12:36 PM\", \"organization_id\": 15, \"additional_notes\": null}', 149, 'pending_balance', 'waiting', 3, 14, 15, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(15, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:22 PM\", \"expire_in\": \"12:37 PM\", \"organization_id\": 10, \"additional_notes\": null}', 412, 'pending_balance', 'waiting', 1, 15, 10, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(16, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:22 PM\", \"expire_in\": \"12:37 PM\", \"organization_id\": 12, \"additional_notes\": null}', 284, 'pending_balance', 'waiting', 2, 16, 12, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(17, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:22 PM\", \"expire_in\": \"12:37 PM\", \"organization_id\": 15, \"additional_notes\": null}', 76, 'pending_balance', 'waiting', 3, 17, 15, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(18, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:32 PM\", \"expire_in\": \"12:47 PM\", \"organization_id\": 10, \"additional_notes\": null}', 206, 'pending_balance', 'waiting', 1, 18, 10, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(19, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:32 PM\", \"expire_in\": \"12:47 PM\", \"organization_id\": 12, \"additional_notes\": null}', 98, 'pending_balance', 'waiting', 2, 19, 12, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(20, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:32 PM\", \"expire_in\": \"12:47 PM\", \"organization_id\": 15, \"additional_notes\": null}', 112, 'pending_balance', 'waiting', 3, 20, 15, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(21, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 1, \"book_day\": \"2025-02-18\", \"book_time\": \"12:39 PM\", \"expire_in\": \"12:54 PM\", \"organization_id\": 10, \"additional_notes\": null}', 457, 'pending_balance', 'waiting', 1, 21, 10, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(22, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 2, \"book_day\": \"2025-02-18\", \"book_time\": \"12:39 PM\", \"expire_in\": \"12:54 PM\", \"organization_id\": 12, \"additional_notes\": null}', 353, 'pending_balance', 'waiting', 2, 22, 12, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(23, 'confirm_booked', NULL, 'Organization', '{\"user_id\": 3, \"book_day\": \"2025-02-18\", \"book_time\": \"12:39 PM\", \"expire_in\": \"12:54 PM\", \"organization_id\": 15, \"additional_notes\": null}', 394, 'pending_balance', 'waiting', 3, 23, 15, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(24, 'confirm_booked', 'deposit', 'User', '{\"user_id\": \"51\", \"book_day\": \"2025-02-22\", \"book_time\": \"10:30 AM\", \"expire_in\": \"10:45 AM\", \"organization_id\": \"2\", \"additional_notes\": null}', 20, 'pending_balance', 'waiting', 51, 30, 2, '2025-02-22 08:41:43', '2025-02-22 08:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `footers`
--

CREATE TABLE `footers` (
  `id` bigint UNSIGNED NOT NULL,
  `list1` json NOT NULL,
  `list2` json NOT NULL,
  `list3` json NOT NULL,
  `list4` json NOT NULL,
  `list5` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footers`
--

INSERT INTO `footers` (`id`, `list1`, `list2`, `list3`, `list4`, `list5`, `created_at`, `updated_at`) VALUES
(1, '\"[{\\\"name\\\":\\\"Home\\\",\\\"url\\\":\\\"\\\\/home\\\"},{\\\"name\\\":\\\"About Us\\\",\\\"url\\\":\\\"\\\\/about\\\"},{\\\"name\\\":\\\"Contact\\\",\\\"url\\\":\\\"\\\\/contact\\\"}]\"', '\"[{\\\"name\\\":\\\"Services\\\",\\\"url\\\":\\\"\\\\/services\\\"},{\\\"name\\\":\\\"Portfolio\\\",\\\"url\\\":\\\"\\\\/portfolio\\\"},{\\\"name\\\":\\\"Careers\\\",\\\"url\\\":\\\"\\\\/careers\\\"}]\"', '\"[{\\\"name\\\":\\\"Blog\\\",\\\"url\\\":\\\"https://aram-gulf.com/blog\\\"},{\\\"name\\\":\\\"News\\\",\\\"url\\\":\\\"/news\\\"},{\\\"name\\\":\\\"Press\\\",\\\"url\\\":\\\"/press\\\"}]\"', '\"[{\\\"name\\\":\\\"Privacy Policy\\\",\\\"url\\\":\\\"privacypolicyusers/\\\"},{\\\"name\\\":\\\"Terms of Service\\\",\\\"url\\\":\\\"/terms\\\"},{\\\"name\\\":\\\"Support\\\",\\\"url\\\":\\\"/support\\\"}]\"', '\"[{\\\"name\\\":\\\"FAQ\\\",\\\"url\\\":\\\"/FAQ\\\"},{\\\"name\\\":\\\"Help Center\\\",\\\"url\\\":\\\"/help-center\\\"},{\\\"name\\\":\\\"Contact Sales\\\",\\\"url\\\":\\\"/contact-sales\\\"}]\"', '2025-02-19 15:32:37', '2025-02-22 08:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mainpages`
--

CREATE TABLE `mainpages` (
  `id` bigint UNSIGNED NOT NULL,
  `main_screen` tinyint(1) DEFAULT '0',
  `video` longtext COLLATE utf8mb4_unicode_ci,
  `link_video` longtext COLLATE utf8mb4_unicode_ci,
  `main_text_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_text_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_text_en` text COLLATE utf8mb4_unicode_ci,
  `second_text_ar` text COLLATE utf8mb4_unicode_ci,
  `third_text_en` text COLLATE utf8mb4_unicode_ci,
  `third_text_ar` text COLLATE utf8mb4_unicode_ci,
  `forth_text_en` text COLLATE utf8mb4_unicode_ci,
  `forth_text_ar` text COLLATE utf8mb4_unicode_ci,
  `image` longtext COLLATE utf8mb4_unicode_ci,
  `image_2` longtext COLLATE utf8mb4_unicode_ci,
  `bg_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mainpages`
--

INSERT INTO `mainpages` (`id`, `main_screen`, `video`, `link_video`, `main_text_en`, `main_text_ar`, `second_text_en`, `second_text_ar`, `third_text_en`, `third_text_ar`, `forth_text_en`, `forth_text_ar`, `image`, `image_2`, `bg_color`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, NULL, 'Access Trusted Medical Information', 'احصل على معلومات طبية موثوقة', 'Explore expert advice from top healthcare professionals.', 'استكشف نصائح الخبراء من أفضل المتخصصين في الرعاية الصحية.', 'Learn about treatments, wellness tips, and more!', 'تعرف على العلاجات، نصائح العناية الصحية، والمزيد!', 'Empower yourself with knowledge to make informed decisions.', 'قم بتمكين نفسك بالمعلومات لاتخاذ قرارات مستنيرة.', 'https://datafromapi-2.aram-gulf.com/images/mainpage/BORSAN ACADEMY (4)_67b8fed67d0ec.png', 'https://datafromapi-2.aram-gulf.com/images/mainpage/oman-5490735_1280_67b8fed67e992.jpg', NULL, NULL, '2025-02-21 22:31:50'),
(2, 1, NULL, 'https://www.youtube.com/embed/FSAAz70a6iw?autoplay=1&mute=1&controls=0&modestbranding=1&rel=0&playsinline=1&loop=1&playlist=FSAAz70a6iw&fs=0', 'Committed to Your Health and Well-being', 'ملتزمون بصحتك ورفاهيتك', 'Our platform connects you with top medical professionals and trusted healthcare resources, empowering you to make informed decisions about your health.', 'منصتنا تربطك بأفضل المتخصصين الطبيين ومصادر الرعاية الصحية الموثوقة، لنمكنك من اتخاذ قرارات مستنيرة بشأن صحتك.', NULL, NULL, NULL, NULL, 'https://datafromapi-2.aram-gulf.com/images/about/service-02.jpg', 'https://datafromapi-2.aram-gulf.com/images/about/service_6.jpg', NULL, NULL, '2025-02-19 15:31:26'),
(3, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-18 13:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'failloser1@gmail.com', '2025-02-18 14:00:26', '2025-02-18 14:00:26'),
(2, 'safaaltamimi99@gmail.com', '2025-02-23 11:17:31', '2025-02-23 11:17:31');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `sender_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `message_type` enum('text','image','audio') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `conversation_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_06_144548_create_card_type_categories_table', 1),
(5, '2024_11_02_112758_create_service_categories_table', 1),
(6, '2024_11_03_110712_create_artical_categories_table', 1),
(7, '2024_11_09_064658_create_card_types_table', 1),
(8, '2024_11_10_133100_create_personal_access_tokens_table', 1),
(9, '2024_11_10_134644_create_categories_table', 1),
(10, '2024_11_10_134740_create_testimonials_table', 1),
(11, '2024_11_10_134752_create_sliders_table', 1),
(12, '2024_11_10_134838_create_payments_table', 1),
(13, '2024_11_19_072748_create_blogs_table', 1),
(14, '2024_11_19_073641_create_comments_table', 1),
(15, '2024_11_19_134443_create_organizations_table', 1),
(16, '2024_11_19_142513_create_company_detailes_table', 1),
(17, '2024_11_20_061453_create_arma__cards_table', 1),
(18, '2024_11_20_181906_create_contact_messages_table', 1),
(19, '2024_11_20_183508_create_services_table', 1),
(20, '2024_11_20_192212_create_subscribers_table', 1),
(21, '2024_12_05_064404_create_mainpages_table', 1),
(22, '2024_12_11_110143_create_members_table', 1),
(23, '2024_12_11_184240_create_privacy_policy_users_table', 1),
(24, '2024_12_11_184357_create_privacy_policy_organizations_table', 1),
(25, '2024_12_11_185127_create_terms_condition_organizations_table', 1),
(26, '2024_12_11_185138_create_terms_condition_users_table', 1),
(27, '2024_12_15_055017_create_provisional_data_table', 1),
(28, '2024_12_15_084805_create_reactions_table', 1),
(29, '2024_12_15_105955_create_bells_table', 1),
(30, '2024_12_16_060801_user_article_reaction', 1),
(31, '2024_12_16_064821_article_reaction_counts', 1),
(32, '2024_12_29_110553_create_books_table', 1),
(33, '2025_01_03_072440_create_notifications_table', 1),
(34, '2025_01_06_060652_create_conversations_table', 1),
(35, '2025_01_06_060708_create_messages_table', 1),
(36, '2025_01_06_061515_create_participants_table', 1),
(37, '2025_01_08_105621_create_blocked_users_table', 1),
(38, '2025_01_13_060059_create_footers_table', 1),
(39, '2025_01_21_015733_create_affiliate_services_table', 1),
(40, '2025_01_21_030426_create_offers_table', 1),
(41, '2025_01_25_144516_create_question__answers_table', 1),
(42, '2025_01_28_192855_create_affiliate_card_types_table', 1),
(43, '2025_01_31_064317_create_financial_transactions_table', 1),
(44, '2025_01_31_085126_create_balances_table', 1),
(45, '2025_02_01_025223_create_withdrawalrequests_table', 1),
(46, '2025_02_02_144941_create_copones_table', 1),
(47, '2025_02_02_151137_create_coupon_user_table', 1),
(48, '2025_02_03_105822_create_visits_table', 1),
(49, '2025_02_03_144656_create_purchases_table', 1),
(50, '2025_02_03_215003_create_card_visits_table', 1),
(51, '2025_02_06_141130_create_organization_reviews_table', 1),
(52, '2025_02_07_070802_create_review_likes_checks_table', 1),
(53, '2025_02_12_111126_create_promoter_new_users_table', 1),
(54, '2025_02_13_104557_create_promotional_cards_table', 1),
(55, '2025_02_17_115047_create_point_cooperations_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `account_type`, `is_read`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'تم رفض طلب نشر العرض \"عرض architecto\". يرجى التواصل مع الدعم لمزيد من التفاصيل.', 'Organization', 0, 7, '2025-02-19 13:16:57', '2025-02-19 13:16:57'),
(2, 'تم رفض طلب نشر العرض \"عرض architecto\". يرجى التواصل مع الدعم لمزيد من التفاصيل.', 'Organization', 0, 7, '2025-02-19 13:17:03', '2025-02-19 13:17:03'),
(3, 'gfhfghfghfghfgh', 'User', 1, 51, '2025-02-19 13:24:17', '2025-02-19 15:47:39'),
(4, 'gfhfghfghfghfgh', 'User', 1, 51, '2025-02-19 13:28:18', '2025-02-19 15:47:39'),
(5, 'gfhfghfghfghfgh', 'User', 1, 51, '2025-02-19 14:00:50', '2025-02-19 15:47:39'),
(6, 'gfhfghfghfghfgh', 'User', 1, 51, '2025-02-19 14:04:10', '2025-02-19 15:47:39'),
(7, 'gfhfghfghfghfgh', 'User', 1, 51, '2025-02-19 14:05:22', '2025-02-19 15:47:39'),
(8, 'gfhfghfghfghfgh', 'User', 1, 51, '2025-02-19 14:05:44', '2025-02-19 15:47:39'),
(9, 'aczxczxczxc', 'Organization', 0, 17, '2025-02-21 14:29:05', '2025-02-21 14:29:05'),
(10, 'aczxczxczxc', 'Organization', 0, 16, '2025-02-21 14:29:05', '2025-02-21 14:29:05'),
(11, 'تمت الموافقة على نشر الخدمة بعنوان Service tempora بنجاح!', 'Organization', 0, 15, '2025-02-23 12:11:59', '2025-02-23 12:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint UNSIGNED NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `number_of_uses` int NOT NULL DEFAULT '0',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `status` enum('waiting','active','expired') COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `title_ar`, `title_en`, `image`, `description_ar`, `description_en`, `number_of_uses`, `code`, `discount_value`, `start_date`, `status`, `end_date`, `is_active`, `organization_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'عرض sit', 'Offer aut', 'https://datafromapi-2.aram-gulf.com/images/offers/service_5_679fced3ba66c.jpg', 'Et esse dolore et eos earum inventore. Quia dolores molestias sunt quod voluptate. Explicabo facilis maiores ut ipsum.', 'In quas ut ea esse molestias reprehenderit. Quia culpa voluptatem itaque consequatur et quo. Eos quibusdam iure laboriosam magni animi.', 0, 'OFF54482', 35.84, '2025-02-05', 'active', '2025-03-07', 1, 13, 1, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(2, 'عرض et', 'Offer quis', 'https://datafromapi-2.aram-gulf.com/images/offers/service-02.jpg', 'Beatae a placeat ipsa nihil quis. Qui aut magni voluptatem iusto adipisci est tenetur. Earum consequatur iusto at non. Sunt ea asperiores nemo recusandae quos labore error.', 'Temporibus et dolorem qui odit. Dolore non odio vel soluta amet soluta adipisci. Ut id velit consequatur voluptate dolor ut sit. Adipisci molestias ipsam ea accusantium suscipit itaque in. Autem est laudantium molestias consequatur similique modi corrupti.', 0, 'OFF63393', 6.68, '2025-02-11', 'active', '2025-03-15', 1, 7, 4, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(3, 'عرض accusantium', 'Offer dolores', 'https://datafromapi-2.aram-gulf.com/images/offers/service_1_679f9d4a131a8.jpg', 'Nihil ullam consequatur incidunt qui. Rerum cumque laboriosam aut. Odio illum ut optio alias aut.', 'Hic architecto tenetur qui ratione et et. Molestiae veniam molestiae esse est voluptas. Consequatur dolores id cumque. Sapiente similique occaecati dolores temporibus.', 0, 'OFF45594', 43.70, '2025-02-03', 'active', '2025-03-07', 1, 16, 4, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(4, 'عرض ducimus', 'Offer aliquam', 'https://datafromapi-2.aram-gulf.com/images/offers/service_5_679fced3ba66c.jpg', 'Qui quo aut dolorem similique ut id aut. Error cumque natus consequatur. Ducimus voluptatem quaerat a ducimus rerum quia. Velit cupiditate consectetur veritatis tempora rerum aut. Fuga ut praesentium maiores nobis voluptate consequatur.', 'Et voluptate qui expedita expedita voluptatibus voluptate. Exercitationem debitis est est cupiditate ipsum dolorem quo.', 0, 'OFF69921', 25.47, '2025-02-16', 'active', '2025-02-24', 0, 4, 19, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(5, 'عرض veniam', 'Offer asperiores', 'https://datafromapi-2.aram-gulf.com/images/offers/service-02.jpg', 'Ipsam cumque quo doloremque aut in omnis sit officia. Quas explicabo sit tenetur magni sunt reprehenderit ut. Quae tempore debitis aut tenetur distinctio voluptatem dolores. Soluta dolores sit reprehenderit id. Aut et quam fuga accusamus.', 'Quaerat voluptatum incidunt culpa dolorem. Eos est exercitationem cupiditate autem fugiat similique soluta.', 0, 'OFF07514', 41.70, '2025-02-04', 'expired', '2025-02-19', 0, 9, 4, '2025-02-18 12:39:53', '2025-02-22 07:37:35'),
(6, 'عرض consectetur', 'Offer reiciendis', 'https://datafromapi-2.aram-gulf.com/images/offers/service_4_67ac50c73a0b4.jpg', 'Est vero autem at odio aut. Qui eveniet esse eos nobis illo excepturi. Nihil natus provident est voluptate eligendi suscipit.', 'Maxime suscipit placeat sapiente id quibusdam voluptatum. Fugit sit tenetur et laudantium quaerat hic quo. Inventore odit voluptatem consequatur veritatis sed sed et. Iusto consequatur ullam voluptatem praesentium natus blanditiis.', 0, 'OFF32472', 7.50, '2025-01-25', 'active', '2025-03-06', 1, 2, 10, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(7, 'عرض dolore', 'Offer veniam', 'https://datafromapi-2.aram-gulf.com/images/offers/service_2_679b1dcf6cd99.jpg', 'Quasi tempora hic quia commodi aut aspernatur laborum vel. Est soluta consequatur eius optio doloribus et. Vitae et ab commodi tempore qui atque ex.', 'Corporis ea facere est et. Quae officiis ut ipsam iure. Placeat aut et nisi. Repudiandae quia explicabo aliquid asperiores.', 0, 'OFF38061', 21.71, '2025-02-17', 'active', '2025-03-07', 1, 8, 9, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(8, 'عرض repellat', 'Offer cupiditate', 'https://datafromapi-2.aram-gulf.com/images/offers/service_2_679b1dcf6cd99.jpg', 'Corporis officiis esse dolor accusamus laborum sit. Amet illo deserunt est nulla est. Ex qui ipsum rerum excepturi. Natus tempora ut voluptatem minima vel. Consequuntur ipsam earum atque explicabo.', 'Minus nam non ullam est. Nesciunt quasi quod aut praesentium vel provident voluptatum.', 0, 'OFF26350', 9.05, '2025-01-19', 'active', '2025-03-07', 1, 2, 10, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(9, 'عرض id', 'Offer quo', 'https://datafromapi-2.aram-gulf.com/images/offers/service_6.jpg', 'Illo et deserunt nemo voluptate laborum id. Distinctio amet eligendi rem sint qui odit corrupti. Maxime minus enim laudantium laboriosam nobis.', 'Autem quis ut quas nesciunt blanditiis sint. Voluptatem molestiae dolorum cupiditate exercitationem neque vel. Officiis quidem nihil reprehenderit consequuntur.', 0, 'OFF00793', 37.67, '2025-02-04', 'active', '2025-03-15', 0, 6, 4, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(10, 'عرض possimus', 'Offer tenetur', 'https://datafromapi-2.aram-gulf.com/images/offers/service_6.jpg', 'Voluptatum inventore et esse voluptatem deleniti nesciunt. Omnis voluptas odit autem repellendus. Repellendus saepe eligendi voluptatibus rerum sequi vitae.', 'Ratione in sed deleniti. Eaque cupiditate distinctio cupiditate. Qui labore id aliquam consequatur id qui. Quo vero et earum ut id itaque.', 0, 'OFF48988', 46.85, '2025-01-23', 'active', '2025-03-07', 1, 5, 14, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(11, 'عرض ut', 'Offer laboriosam', 'https://datafromapi-2.aram-gulf.com/images/offers/service_6.jpg', 'Veritatis veritatis cupiditate iste suscipit aut et voluptatem deserunt. Maxime aut blanditiis quasi repellat soluta repellat. Neque quia nihil quos ea distinctio. Quas ut dicta id tempore eos odio minima.', 'Explicabo maxime minima quia vero. Ut aspernatur distinctio deleniti sequi provident velit ab. Cupiditate amet animi dolores maiores ea quo repudiandae autem. Impedit deserunt placeat dolor laudantium esse impedit.', 0, 'OFF81335', 15.04, '2025-01-22', 'active', '2025-03-01', 1, 1, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(12, 'عرض voluptatem', 'Offer esse', 'https://datafromapi-2.aram-gulf.com/images/offers/service-02.jpg', 'Veniam dolorem aut suscipit magnam consectetur animi et. Voluptas eum neque eos quia porro aut et. Distinctio atque esse id ipsa aperiam et excepturi ex. Alias odio blanditiis ex dolor omnis eos aliquam.', 'Dolores esse provident magni officia officia repudiandae est nemo. Assumenda nostrum laborum architecto fuga eos quo ut. Distinctio quis hic adipisci beatae. Sapiente est ab dolorem quae omnis molestias saepe impedit.', 0, 'OFF78206', 26.47, '2025-02-09', 'active', '2025-02-23', 0, 10, 8, '2025-02-18 12:39:53', '2025-02-24 01:25:07'),
(13, 'عرض mollitia', 'Offer voluptatem', 'https://datafromapi-2.aram-gulf.com/images/offers/service_4_67ac50c73a0b4.jpg', 'Sunt assumenda vero dolorem quaerat omnis molestiae fugiat consequatur. Magni nam expedita aut distinctio vitae ut perspiciatis. Soluta dolor excepturi corrupti quia.', 'Ab consequuntur ea reprehenderit minima maxime delectus. Ad ea dolore quis dolorum modi. Alias quis enim odit eaque atque vitae exercitationem.', 0, 'OFF44388', 8.21, '2025-02-09', 'active', '2025-03-13', 1, 9, 20, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(14, 'عرض itaque', 'Offer excepturi', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_679b1eb33a8fe.jpg', 'Vel id dicta voluptatum excepturi ut consectetur ullam. Magnam mollitia a provident rerum sed. Ullam pariatur enim ab quia sint laudantium.', 'Nihil animi omnis ducimus et fuga quae ut. Non deleniti doloremque sint ullam et. Et magnam at dolores eveniet. Dolores quod et iure est. Quod non qui laborum illo natus quisquam aperiam.', 0, 'OFF01376', 45.76, '2025-01-23', 'expired', '2025-02-19', 0, 10, 11, '2025-02-18 12:39:53', '2025-02-22 07:37:35'),
(15, 'عرض a', 'Offer non', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_67b333afb1112.jpg', 'Repellendus corporis dolorum saepe voluptas nobis quisquam. Laborum laborum et voluptas. Consequatur quasi et aut et soluta saepe. Ea at corrupti sit voluptatibus vel.', 'Debitis nemo sed commodi iure. Debitis voluptatem ullam non autem et ut voluptas. Omnis quo quidem atque doloribus amet. Saepe omnis pariatur incidunt et omnis. Quod officiis consequatur aut eos.', 0, 'OFF94615', 8.69, '2025-01-29', 'active', '2025-03-04', 1, 10, 19, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(16, 'عرض totam', 'Offer velit', 'https://datafromapi-2.aram-gulf.com/images/offers/service_3_6799b91a31976.jpg', 'Quisquam natus voluptatum quod. Ducimus velit dolore facilis repellat. Quia tempora aliquam nostrum. Similique repellendus unde eveniet at sed.', 'Harum necessitatibus magni impedit doloribus quos error. Delectus itaque est soluta excepturi dolorum rerum. Voluptatem et quisquam est officiis quasi omnis ratione consequatur.', 0, 'OFF72651', 23.50, '2025-02-16', 'active', '2025-02-22', 0, 19, 12, '2025-02-18 12:39:53', '2025-02-23 00:07:38'),
(17, 'عرض doloremque', 'Offer alias', 'https://datafromapi-2.aram-gulf.com/images/offers/service_1_679f9d4a131a8.jpg', 'Maiores est et corporis culpa ex tempore illo. At atque pariatur expedita quaerat at et voluptatem. Consectetur qui dolores vel at animi omnis quae. Omnis molestiae ratione aut.', 'Aut aut aspernatur est libero temporibus ea. Omnis facilis quo hic rerum eius maxime ex. Similique blanditiis qui quidem cumque.', 0, 'OFF78052', 21.19, '2025-02-02', 'active', '2025-03-15', 1, 15, 13, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(18, 'عرض molestiae', 'Offer delectus', 'https://datafromapi-2.aram-gulf.com/images/offers/service-03_67b333afb1112.jpg', 'Sint sunt et consequatur. Sed error accusantium totam doloremque rerum magnam. Nihil aperiam mollitia et tenetur iste. Laboriosam praesentium nobis inventore aspernatur.', 'Porro mollitia et maiores labore numquam. Fuga exercitationem temporibus porro sed. Eos odit reprehenderit perspiciatis rerum totam illo voluptatum magni. Eum dolores blanditiis aperiam unde et.', 0, 'OFF55545', 24.09, '2025-02-16', 'active', '2025-03-06', 0, 8, 16, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(19, 'عرض debitis', 'Offer dolor', 'https://datafromapi-2.aram-gulf.com/images/offers/service_4_67ac50c73a0b4.jpg', 'Provident necessitatibus doloremque iusto aut laboriosam. Nostrum eius molestias iusto non et. Vel totam quaerat doloremque omnis eaque. Non non qui voluptas assumenda qui. Aliquid unde a cumque voluptatem perferendis in.', 'Et minus cumque dolores natus odit. Ad doloribus tempore iure voluptas repellendus ullam delectus. Et et necessitatibus ut voluptatibus non repellat hic. Hic optio vero in maxime.', 0, 'OFF18331', 38.06, '2025-01-22', 'active', '2025-02-25', 1, 18, 12, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(20, 'عرض architecto', 'Offer consequatur', 'https://datafromapi-2.aram-gulf.com/images/offers/service_2_679b1dcf6cd99.jpg', 'Beatae sint molestiae architecto voluptas error tempora. Aliquid eos debitis dolorem doloremque temporibus.', 'Dolorum sit id assumenda voluptas. Quisquam dolorem cupiditate nostrum quis ut sunt. Consequuntur dicta minus sint est quod in.', 0, 'OFF64921', 35.87, '2025-02-06', 'active', '2025-03-02', 0, 7, 9, '2025-02-18 12:39:53', '2025-02-19 13:16:57'),
(21, 'بورسان', 'FITNESS TIME', 'https://datafromapi-2.aram-gulf.com/images/offers/ARAM CARD (2)_67b6616f8314d.png', 'hhhhhh', 'ggggggg', 0, 'O4E14RsZQU', 28.00, '2025-02-01', 'active', '2025-03-15', 1, 4, 1, '2025-02-19 22:55:43', '2025-02-21 11:11:20'),
(22, 'بورسان', 'borsan', 'https://datafromapi-2.aram-gulf.com/images/offers/ARAM CARD (7)_67b84621ade97.png', 'يييي', 'XXXX', 0, 'SztEGOFGTl', 13.00, '2025-02-02', 'active', '2025-03-03', 1, 1, 1, '2025-02-21 09:23:45', '2025-02-21 11:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` longtext COLLATE utf8mb4_unicode_ci,
  `accaptable_message` text COLLATE utf8mb4_unicode_ci,
  `unaccaptable_message` text COLLATE utf8mb4_unicode_ci,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmation_status` tinyint(1) DEFAULT NULL,
  `open_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `close_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_price` decimal(8,2) DEFAULT '0.00',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('published','not_published','under_review') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_published',
  `rateing` decimal(3,2) NOT NULL DEFAULT '0.00',
  `categories_ids` json NOT NULL,
  `cooperation_file` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` date DEFAULT NULL,
  `number_of_reservations` int NOT NULL DEFAULT '0',
  `is_signed` tinyint(1) NOT NULL DEFAULT '0',
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Organization',
  `email_verification_token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `email`, `password`, `title_ar`, `title_en`, `description_ar`, `description_en`, `features`, `accaptable_message`, `unaccaptable_message`, `location`, `phone_number`, `confirmation_status`, `open_at`, `close_at`, `url`, `image`, `confirmation_price`, `icon`, `active`, `status`, `rateing`, `categories_ids`, `cooperation_file`, `email_verified_at`, `number_of_reservations`, `is_signed`, `account_type`, `email_verification_token`, `created_at`, `updated_at`) VALUES
(1, 'abdullah.maanee@example.org', '$2y$12$RxfJw3hCQnAF8pQBQGv7OOiuJNSPXTlHJEzq8a2bkN.CM2NqYDgDu', 'مركز الطب العام', 'General Medicine Center', 'مركز يقدم خدمات الطب العام لجميع الأعمار.', 'A center offering general medicine services for all ages.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345678', NULL, '08:00', '11:00', 'http://rabee.com/culpa-deserunt-natus-possimus-alias-aperiam-sed-quisquam.html', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241207191900.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/instagram_6792d8cebfafd.png', 1, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', 'https://datafromapi-2.aram-gulf.com/uploads/pdfs/نقاط أساسيات تصميم واجهات المستخدم و تجارب المستخدم_67bc86697ba1f.pdf', NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:49', '2025-02-24 14:47:05'),
(2, 'bashar.abulebbeh@example.com', '$2y$12$ZdXG3c.iHDVNnacdbD3Y5u2zUjCakiDxLxy9lliDDkuBv17pvtwHG', 'مركز الأسنان', 'Dental Center', 'مركز متكامل لطب الأسنان وجراحة الفم.', 'A comprehensive center for dental care and oral surgery.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345679', NULL, '09:00', '11:00', 'http://www.rabee.info/excepturi-praesentium-omnis-cupiditate-saepe-incidunt.html', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241207191900.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 1, 'published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 1, 0, 'Organization', NULL, '2025-02-18 12:39:49', '2025-02-22 08:41:41'),
(3, 'bashar95@example.com', '$2y$12$cDtYijgNioAtqZO/wSQX6uLPZ/suAiaxnZ6xPKhC3YdtWKeHbgwK2', 'مركز الأمراض الجلدية', 'Dermatology Center', 'مركز متخصص في علاج الأمراض الجلدية.', 'A center specializing in dermatological treatments.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345680', NULL, '08:30', '11:30', 'http://www.shami.com/et-rerum-facere-consequuntur-dolorum-ipsum', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_6_676e9524ac256.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 1, 'published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:49', '2025-02-18 12:39:49'),
(4, 'hadi.fadi@example.net', '$2y$12$7XxjWMpjL4dx.WLwExsQGOrcm8zPY5dzHWzKhfZig0Hp9Ph17q1zy', 'مركز العيون', 'Ophthalmology Center', 'مركز متقدم لعلاج أمراض العيون.', 'An advanced center for eye care.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345681', NULL, '08:00', '11:00', 'http://www.qasem.sa/', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241204121338.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/20241203143808.png', 1, 'published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:49', '2025-02-18 12:39:49'),
(5, 'osama74@example.org', '$2y$12$IdH17fy0DbF1hpUNBCif9.5/RKsKzFcq5jgUWjxh0jdj6fujeBX8a', 'مركز النساء والتوليد', 'Obstetrics and Gynecology Center', 'مركز يقدم خدمات النساء والتوليد.', 'A center offering obstetrics and gynecology services.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345682', NULL, '09:00', '11:00', 'http://www.qasem.net/voluptas-porro-fuga-qui-perferendis-sapiente-ut-aut', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241208115616.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/instagram_6792d8cebfafd.png', 1, 'published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:49', '2025-02-18 12:39:49'),
(6, 'qasem.saleem@example.org', '$2y$12$sTD8Gu32w0dvtGzXLqWiReW8FvNVYbZN.94lB2BEYWe1ugcSR9Kq.', 'مركز العلاج الطبيعي', 'Physical Therapy Center', 'مركز متخصص في العلاج الطبيعي والتأهيل.', 'A center specialized in physical therapy and rehabilitation.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345683', NULL, '07:30', '11:30', 'http://www.flefel.sa/', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241204121614.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 1, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:50', '2025-02-18 12:39:50'),
(7, 'mutaz26@example.com', '$2y$12$rw8q3okykt.8ypietzsWKup2l8eNuVTQ0zD6ulgyVbRYtVXsQSRmO', 'مركز أمراض القلب', 'Cardiology Center', 'مركز متخصص في علاج أمراض القلب.', 'A center specialized in treating heart diseases.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345684', NULL, '08:00', '11:00', 'http://www.abbas.com/dolores-voluptas-magnam-enim-eaque-iure-reprehenderit.html', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241204121614.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/instagram_6792d8cebfafd.png', 1, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:50', '2025-02-18 12:39:50'),
(8, 'hamad.ahmad@example.net', '$2y$12$Y4NAsrDyFdyXvJszXMQsnuiZmwO0NfqPBSnXpFdozVi/JbLltl3M2', 'مركز الأورام', 'Oncology Center', 'مركز متخصص في علاج السرطان والأورام.', 'A center specializing in cancer and oncology treatments.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345685', NULL, '08:00', '11:00', 'http://www.rabee.biz/quas-autem-natus-nostrum-cum-laborum', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_6_676e9524ac256.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/20241203143808.png', 1, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:50', '2025-02-18 12:39:50'),
(9, 'abbad.sami@example.com', '$2y$12$6bKX/h1T0yypOHwpQQPIkOhFVrJ9TbbuzE9D4Si.97YxUUt0T0beG', 'مركز الأطفال', 'Pediatric Center', 'مركز متخصص في رعاية الأطفال.', 'A center specialized in pediatric care.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345686', NULL, '09:00', '11:00', 'http://jabri.info/rerum-eum-aperiam-quis-atque-ut-et', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_3_6792d8ceb3912.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/google_6778c7b74881a.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:50', '2025-02-18 12:39:50'),
(10, 'rami51@example.com', '$2y$12$fRBrAgzP5Zn.XzMPxVhkv.vUTn/3oLFuvT/PpIQxnLFCVZxjCIJdC', 'مركز الطوارئ', 'Emergency Center', 'مركز الطوارئ لتقديم العناية العاجلة.', 'Emergency center for urgent care.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345687', NULL, '24/7', '24/7', 'http://jabri.com/', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241204121338.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/instagram_6792d8cebfafd.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:50', '2025-02-18 12:39:50'),
(11, 'mohammad.abulebbeh@example.net', '$2y$12$oipqthlqehnPCjkqz0EYtORtkZR.av/iiEXn52NsLJKims8BRCwGm', 'مركز المسالك البولية', 'Urology Center', 'مركز متخصص في علاج المسالك البولية.', 'A center specializing in urology.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345688', NULL, '08:00', '11:00', 'http://www.melhem.com/', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_4_6795c17b5d93c.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/google_6778c7b74881a.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:51', '2025-02-18 12:39:51'),
(12, 'fadi.abulebbeh@example.org', '$2y$12$NiY7Xca0eW2pP9k29.eYJOVPwmuJIAwVqt1U1iyyPYLGg.7liutKu', 'مركز الغدد الصماء', 'Endocrinology Center', 'مركز متخصص في علاج أمراض الغدد الصماء.', 'A center specialized in endocrinology.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345689', NULL, '09:00', '11:00', 'https://abbas.com/iste-quia-aspernatur-cumque-aut-voluptas-quod.html', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241204121338.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:51', '2025-02-18 12:39:51'),
(13, 'rashwani.layth@example.org', '$2y$12$QlPhVjiueA620wRAMcmbh.x/xq5rM6N2OOA/5OXYjMqBM6WY8NchC', 'مركز الباطنة', 'Internal Medicine Center', 'مركز متخصص في علاج الأمراض الباطنية.', 'A center specializing in internal medicine.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345690', NULL, '08:30', '11:30', 'http://www.abbadi.net/accusamus-eos-sunt-architecto-deserunt-nesciunt-voluptatem-reprehenderit.html', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241204121338.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:51', '2025-02-18 12:39:51'),
(14, 'akram34@example.net', '$2y$12$iQ5vUv4HWYqpjD4X2xN3GO0.owcA67XI7s9ntx/ub7JOI3D68xBh.', 'مركز الأذن والأنف والحنجرة', 'ENT Center', 'مركز متخصص في أمراض الأذن والأنف والحنجرة.', 'A center specialized in ENT diseases.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345691', NULL, '08:00', '11:00', 'http://www.kanaan.biz/consequatur-cumque-commodi-sit-reiciendis-quasi', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241204121614.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:51', '2025-02-18 12:39:51'),
(15, 'bilal51@example.com', '$2y$12$3qWE2HzfWE.CJqUVOMtNgOwnEUhoBKFKZsfXOX4MKE3mORGnksFb.', 'مركز جراحة العظام', 'Orthopedic Surgery Center', 'مركز متخصص في جراحة العظام.', 'A center specialized in orthopedic surgery.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345692', NULL, '09:00', '11:00', 'http://www.rabee.org/veniam-assumenda-modi-rerum-molestiae.html', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_3_6792d8ceb3912.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(16, 'hamad.akram@example.net', '$2y$12$kkIuH/ur1l86ySmqSnBep.HBbVJaCXf2iDUVRh58.nEN.SareuVqS', 'مركز الطب الرياضي', 'Sports Medicine Center', 'مركز متخصص في علاج الإصابات الرياضية.', 'A center specializing in sports injuries treatment.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345693', NULL, '07:00', '11:00', 'http://www.rashwani.net/quia-neque-facilis-debitis-corrupti.html', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241207191900.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/google_6778c7b74881a.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(17, 'fadi.abbad@example.com', '$2y$12$RPRBYpvJzUiNTh2F3SiJpOOWk7QzYwCStcdTJgG1yaWFPEIYH8OrC', 'مركز التحاليل الطبية', 'Medical Lab Center', 'مركز لإجراء التحاليل الطبية المخبرية.', 'A center for conducting medical laboratory tests.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345694', NULL, '08:00', '11:00', 'http://abulebbeh.com/ea-sapiente-dolor-est-nihil-explicabo', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/20241207191900.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(18, 'yazan07@example.com', '$2y$12$HwFPoeJLvRNoCy0wDK0SZOfC0IvYHw.ob6nQ9wFXv.WUfuOHfmkrm', 'مركز الصيدلية', 'Pharmacy Center', 'مركز يحتوي على صيدلية تقدم الأدوية والعلاجات.', 'A center with a pharmacy offering medicines and treatments.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345695', NULL, '08:00', '11:00', 'http://www.rashwani.com/', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service-02_675bc532eed30.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_6781009e548b1.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(19, 'fadi.maanee@example.org', '$2y$12$A4d.4MyY7ULfSnIrXkQ9IupNG3.mC7POctKqrZJLJ3Os1anj8nsdO', 'مركز الصحة العامة', 'Public Health Center', 'مركز يقدم خدمات الصحة العامة الوقائية.', 'A center offering public health and preventive services.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', NULL, NULL, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '0112345696', NULL, '09:00', '11:00', 'http://abbadi.net/maxime-omnis-voluptas-odio-ab', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_4_6795c17b5d93c.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/google_6778c7b74881a.png', 0, 'not_published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(20, 'test-2@gmail.com', '$2y$12$jWXoLNkG8IFcKY.gcLMXKOLFqKqUF35uBTwPSGMnDDEfVwWUKKGsy', 'test-2', 'test-2', 'test-2', 'test-2', NULL, NULL, NULL, '{\"address\":\"مصطفى الاجرودى, الغربية, 31953, مصر\",\"latitude\":30.9696706,\"longitude\":31.168083}', '010175323', 0, '08:00', '23:00', 'https://www.youtube.com/watch?v=M3xjz4nxzGQ', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_6_67b5c601910ab.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/facebook_67b5c60193094.png', 0, 'published', 0.00, '\"[\\\"7\\\",\\\"15\\\",\\\"11\\\",\\\"19\\\",\\\"18\\\",\\\"14\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-19 11:52:33', '2025-02-19 11:56:52'),
(21, 'bc@majors-om.com', '$2y$12$aJIt4xMvjL8yQp1BKfoDoegyrH80pn2XFtgzM3hr/ptc80DfAhsLS', 'مايجورز للادارة والاستشارات', 'MAJORS GCC for Management and Consultancies', 'في مايجورز للاستشارات الإدارية وتطوير الأعمال، نؤمن بتحويل الأفكار إلى واقع مؤثر. مهمتنا هي تمكين الشركات من خلال استراتيجيات مبتكرة وتوجيهات خبيرة وحلول مخصصة تقود إلى النجاح. 📈 سواء كنت شركة ناشئة أو علامة تجارية راسخة، نحن هنا لمساعدتك في تطوير عملك، وصقل رؤيتك، وتحقيق تأثير دائم.\r\n✨ دعونا نبني النجاح معًا\r\n🔗 تواصل معنا اليوم وانطلق بعملك نحو القمة', '🚀 At Majors for Management Consulting & Business Development, we believe in turning ideas into impactful realities. Our mission is to empower businesses with innovative strategies, expert guidance, and tailored solutions that drive success.\r\n📈 Whether you\'re a startup or an established brand, we are here to elevate your growth, refine your vision, and create lasting impact.\r\n✨ Let\'s build success together.\r\n🔗 Contact us today and take your business to the next level.', '[\"test\"]', 'null', 'null', '{\"address\":\"تبوك, محافظة تبوك, منطقة تبوك, 47731, السعودية\",\"latitude\":28.358043489489823,\"longitude\":36.49807526867355}', '96383535', 0, '09:00', '17:00', 'https://majors-om.com/', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/IMG_7560_67b6fa97c085f.jpeg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/IMG_7639_67b6fa97c9453.jpeg', 0, 'not_published', 0.00, '[\"18\"]', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-20 09:49:11', '2025-02-22 08:09:55'),
(22, 'Sales@chatrainvest.com', '$2y$12$exThRw3f9/rvJNwYUUlsbOX0Yyad8bZVM7zgwByt0riNU3teGNY0e', 'شعيا للتجارة والاستثمار', 'CHAAYA TRADING AND INVESTMENT', 'نحن نتعامل مع الاستيراد والتصدير والاستثمار يربط الأسواق العالمية من خلال تسهيل حركة البضائع عبر الحدود ، مما يمكن الشركات من الوصول إلى منتجات جديدة والوصول إلى قواعد عملاء أوسع. بالإضافة إلى التجارة ، نستثمر في أسواق متنوعة ، ونسعى للحصول على فرص مربحة في المشاريع الدولية. من خلال الجمع بين الخبرة التجارية والاستثمارات الاستراتيجية ، فإنها تساهم في النمو الاقتصادي وتوسيع السوق وتكوين الثروة للشركات والمستثمرين.', 'We deal with Import and Export and Investment bridges global markets by facilitating the movement of goods across borders, enabling businesses to access new products and reach broader customer bases. In addition to trade, we invest in diverse markets, seeking profitable opportunities in international ventures. By combining trade expertise with strategic investments, they contribute to economic growth, market expansion, and wealth creation for businesses and investors.', '[\"test\"]', 'null', 'null', '{\"address\":\"مسقط, 133, عمان\",\"latitude\":23.583179576288785,\"longitude\":58.410588189736266}', '77151114', 1, '09:00', '17:00', 'https://www.chatrainvest.com/', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/04abc624-e1d8-4c2c-b826-2296342ff370_67b707eb79f80.jpeg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/IMG_7640_67b707eb7cd86.jpeg', 0, 'published', 0.00, '[\"12\"]', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-20 10:46:03', '2025-02-24 09:42:04'),
(23, 'mouhanadch123@gmail.com', '$2y$12$1HPkzS.qoAai1qFDzK7RTuTa8BFHP97FePpAV8t7sgAf8Kf0U2Mxq', 'مركز اللياقة والتخسيس', 'basics fît', 'مركز لياقة و تخسيس للرجال والنساء', 'fitness and weight loss center for and woman', NULL, NULL, NULL, '{\"address\":\"سكة 4204, مسقط, 911, عمان\",\"latitude\":23.589653498038906,\"longitude\":58.38621715266202}', '71072970', NULL, '10:30', '23:00', NULL, NULL, 20.00, NULL, 0, 'not_published', 0.00, '\"[\\\"11\\\"]\"', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-21 10:25:44', '2025-02-21 10:25:44'),
(24, 'sadasd@sf.com', '$2y$12$Op8FMhx4rneRELeIlc3BXeqRAOnZvdrraRsNaYXuauq3twkK5ZuHy', 'test', 'test', 'test', 'test', '[\"2\",\"23\",\"34\"]', 'null', 'null', '{\"address\":\"شارع الجلاء, احمد ماهر, طنطا, الغربية, 31531, مصر\",\"latitude\":30.7865086,\"longitude\":31.0003757}', '99092343451', 0, '07:00', '23:00', 'https://www.youtube.com/watch?v=M3xjz4nxzGQ', 'https://datafromapi-2.aram-gulf.com/images/organizations/images/service_6_67b96af3bb271.jpg', 20.00, 'https://datafromapi-2.aram-gulf.com/images/organizations/icons/logo_67b96af3bd729.ico', 0, 'published', 0.00, '[\"19\"]', NULL, NULL, 0, 0, 'Organization', NULL, '2025-02-22 06:10:56', '2025-02-22 08:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `organization_reviews`
--

CREATE TABLE `organization_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `stars` int NOT NULL,
  `head_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `like_counts` int NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_reviews`
--

INSERT INTO `organization_reviews` (`id`, `stars`, `head_line`, `content`, `like_counts`, `user_id`, `organization_id`, `created_at`, `updated_at`) VALUES
(11, 4, 'Ea earum aperiam et cumque nemo.', 'Est dolorum asperiores totam harum et. Et sint consequuntur sit temporibus vitae saepe. Mollitia aliquid nostrum et dolore totam voluptas. Sed reiciendis vel non aspernatur ullam illum deserunt soluta.', 0, 15, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(12, 2, 'Reprehenderit doloremque natus minus veritatis deserunt molestiae esse architecto.', 'Velit sit molestias et voluptatum. Cumque nisi similique dolore sed quam harum mollitia. Optio qui odio iure non.', 0, 34, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(13, 3, 'Iure eligendi quia culpa.', 'Enim iure quae non esse quod nesciunt qui. Eaque iure vitae accusantium doloremque necessitatibus commodi unde. Eos expedita at quia ipsam esse consequatur qui et. Sunt sequi blanditiis aliquid aut et.', 22, 28, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(14, 1, 'Qui aut enim tempore quis dignissimos.', 'Alias maiores aliquid est est. In esse illo vel cum. Qui sit quis voluptatum incidunt molestiae.', 21, 28, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(15, 1, 'Sit laudantium perspiciatis ipsa dolor aut.', 'Exercitationem ratione omnis doloremque. Eos adipisci non fugit omnis delectus omnis doloremque exercitationem. Nihil reiciendis sit beatae nobis ullam dolores sint unde.', 0, 7, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(16, 2, 'Quis aut sed quia incidunt.', 'Sed unde laborum laboriosam voluptatem vitae. Delectus quia aut et non facilis suscipit magnam. Dolor sint ducimus at aut aperiam iusto omnis.', 0, 47, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(17, 1, 'Porro vel amet velit maxime ducimus eaque.', 'Nemo rem ut fugit amet reiciendis. Aperiam est quos quia voluptates at. Architecto ab qui ipsam similique mollitia assumenda est.', 0, 50, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(18, 5, 'Sapiente possimus illum molestiae sunt maiores.', 'Hic dolorem ipsam ullam numquam ratione ipsum amet animi. Qui qui dolores inventore. Molestiae totam recusandae qui cumque voluptatem alias qui maiores.', 66, 1, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(19, 4, 'Maxime deserunt quis minima voluptatem.', 'Quod qui facilis est id. Dicta ea repudiandae est quia adipisci quia beatae. Est et molestias voluptatum earum.', 0, 43, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(20, 3, 'Dolorem et totam quod non voluptatem cum placeat.', 'Accusamus error et sed et. Deserunt sint nobis alias et et quam. Rerum est modi ratione eius aut deserunt.', 40, 33, 18, '2025-02-18 12:20:46', '2025-02-18 12:20:46'),
(21, 3, 'Qui reiciendis inventore est vero.', 'Facilis sint ea placeat aut quisquam non aperiam. Sapiente consequatur cumque debitis corrupti porro illum. Autem dolor officia est in qui est.', 72, 40, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(22, 3, 'Minus accusamus placeat voluptas eos doloremque dolor.', 'Odit cupiditate id repellat. Et labore voluptas temporibus maxime praesentium rerum inventore. Sunt facere quibusdam deleniti rerum atque vel.', 14, 28, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(23, 5, 'Quod esse dolore qui qui perspiciatis rerum pariatur.', 'Tempora qui praesentium nulla id veritatis accusamus. Quos eum voluptatem beatae quas voluptatem. Aut amet quisquam vel asperiores.', 0, 17, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(24, 3, 'Sed eaque aliquam et sit sit.', 'Repellendus cupiditate exercitationem qui sapiente. Omnis qui ut quia corporis id iste. Rerum cum voluptas omnis debitis.', 49, 4, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(25, 4, 'Inventore quisquam sit dolorem perspiciatis.', 'Saepe et assumenda quis non sint sint. Facere qui praesentium aperiam eius omnis voluptatem. Perferendis temporibus delectus aspernatur fuga odit quo. Dolorem animi corrupti non quod doloremque.', 0, 48, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(26, 1, 'Velit cupiditate ea voluptatem nostrum in et qui.', 'Dolores fugit delectus non repellat nam nihil. Est qui ut aut delectus ipsa. Dolorem laborum tenetur maxime nihil facilis nobis et et. Illum reprehenderit et aut maxime ducimus et.', 22, 3, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(27, 5, 'Alias explicabo consequatur expedita.', 'Necessitatibus et a autem nobis dolores. Aut culpa illo quam consequatur dolore quo dolorum. Dolorum pariatur a blanditiis itaque id.', 34, 18, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(28, 5, 'Nostrum recusandae omnis commodi nihil eius.', 'Quas sed blanditiis soluta eum sed sit eligendi. Qui nulla aperiam eaque aliquam exercitationem est. Eum dolorem id quia vel voluptas.', 12, 27, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(29, 3, 'Praesentium a dolore inventore numquam maxime quia sunt.', 'Cum mollitia consequuntur reprehenderit sed sit nostrum. Quia quae inventore quo commodi illo vel vitae voluptatum. Molestiae commodi tenetur harum est voluptatem est ea.', 96, 47, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(30, 4, 'Quod ex vel quod vel quisquam qui.', 'In libero perspiciatis magni quia. Mollitia eaque quo quidem animi libero nobis nostrum natus.', 79, 29, 18, '2025-02-18 12:21:12', '2025-02-18 12:21:12'),
(31, 2, 'Numquam qui accusantium perspiciatis praesentium et porro.', 'Sint autem consequatur eius itaque nostrum et dolor possimus. Est unde veniam aut aliquid et. Ut harum dolor autem nulla est esse nesciunt excepturi. Iure nihil aut est amet ullam.', 62, 14, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(32, 4, 'Aspernatur quas ullam dolor iure ullam.', 'Consequatur eum consequatur rem et et quos. Aliquid aspernatur nam aperiam accusamus. Sint assumenda quo qui a est id. Tempore est reiciendis tenetur aut.', 65, 19, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(33, 5, 'Qui in odio non dolorem officia dolorem.', 'Impedit debitis rem quisquam et laudantium ab repudiandae. Cumque quaerat eaque ipsa ut ut eius et. Dolorum molestiae enim libero asperiores. Repellat tempore et et dolor nihil modi qui.', 96, 10, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(34, 2, 'Deleniti quo suscipit et consequatur.', 'Sed quidem nulla molestiae vero eos rerum rem assumenda. Voluptatem commodi id cumque atque molestias corrupti corrupti nisi. Hic excepturi et minima ab enim.', 0, 34, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(35, 2, 'Asperiores dolor consequuntur minima minus repellat.', 'Repudiandae et voluptate nisi itaque odit deleniti. Expedita voluptas consectetur fuga praesentium sequi tenetur. Accusamus ut omnis occaecati dolorem dicta numquam quos.', 7, 49, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(36, 1, 'Nam odio repellendus autem numquam possimus quis.', 'Rerum sint corrupti quidem hic. Modi dolorem non quidem dolor laudantium. Dicta possimus et rerum dolorem recusandae quia.', 0, 42, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(37, 4, 'Enim veritatis voluptatem voluptas ipsa ullam.', 'Aut maxime assumenda adipisci inventore. Ut laudantium est a et voluptas sint. Et dolorum reiciendis ut atque nihil sapiente provident.', 15, 34, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(38, 2, 'Quas culpa voluptatum animi cumque placeat earum et sit.', 'Nihil reprehenderit nam ex minus culpa. Rerum debitis qui ullam. Occaecati aut itaque numquam laborum molestiae omnis. Exercitationem vel temporibus autem exercitationem magnam sequi quia.', 15, 43, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(39, 3, 'Ducimus sunt veritatis a maiores.', 'Quod quis dolorum voluptas ut distinctio illum impedit. Consequatur ipsam distinctio cumque sit velit voluptas. Praesentium deserunt laudantium et.', 0, 12, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(40, 5, 'Velit quod fuga perferendis blanditiis nesciunt aut animi consectetur.', 'Et dolores quasi voluptates quo qui. Minus sunt laborum officiis ut. Enim eum autem non recusandae molestiae autem corrupti.', 36, 5, 18, '2025-02-18 12:22:03', '2025-02-18 12:22:03'),
(41, 2, 'Non distinctio neque est rerum.', 'Soluta aut minus enim nulla aperiam impedit. Eveniet quaerat omnis sint sunt. Ipsam atque occaecati non. Corrupti neque ut deserunt expedita et.', 7, 7, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(42, 2, 'Omnis id voluptas occaecati atque quia.', 'Sapiente aut eveniet esse. Magni nostrum eos ut commodi. Eius et consequatur ut ut delectus unde. Dolorem dolor mollitia quis sequi fugiat.', 48, 20, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(43, 1, 'Qui officiis nostrum exercitationem dolorem sunt accusamus nihil.', 'Dolorem rerum fuga aut sed earum qui. Aut animi reprehenderit eius nesciunt esse sed.', 0, 9, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(44, 4, 'Itaque cupiditate consequatur reiciendis itaque voluptatum placeat.', 'Expedita officia commodi voluptatibus deserunt. Quibusdam natus officiis maiores minima sed aliquam eos enim. Et et magni sapiente mollitia nihil. Quo totam voluptatibus quas commodi et sunt eveniet aut. Corrupti non nisi nemo modi voluptatem.', 0, 7, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(45, 1, 'Magni maxime rerum delectus est sed assumenda hic.', 'In rerum omnis repellat officia dolore asperiores illum. Iure voluptas atque dolores in et. Ut qui eligendi dolor sed quos suscipit. Itaque soluta ipsam labore.', 0, 28, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(46, 3, 'Ad doloribus adipisci dicta magnam maiores quia commodi.', 'Possimus sed at sint qui. Distinctio totam et sunt exercitationem dolorum. Voluptate in necessitatibus repudiandae commodi ratione.', 72, 3, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(47, 5, 'Voluptas sint minima quis voluptatem.', 'Tenetur reprehenderit in vero voluptatem. Eius iste et id. Est alias consequuntur id aut quod libero. Eveniet repellat fugiat reprehenderit in et.', 0, 43, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(48, 5, 'Saepe et vel provident laudantium quis aliquam quo.', 'Minima et voluptas rerum quia eos voluptatum facere. Officiis ut accusamus ut unde officiis.', 58, 25, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(49, 2, 'Unde eius aut dolore cumque voluptatum modi.', 'Corporis eos repudiandae pariatur hic. Accusantium officia sed et exercitationem nobis omnis. Quaerat consectetur est maxime culpa.', 0, 49, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(50, 3, 'Distinctio voluptatem animi commodi ea quia.', 'Est nam aut ipsa dolor. Incidunt hic doloremque et harum rerum pariatur temporibus. Porro quia voluptas sequi id et vitae. Debitis nulla cumque ab eaque libero.', 0, 35, 18, '2025-02-18 12:32:07', '2025-02-18 12:32:07'),
(51, 2, 'Repellat quis est possimus distinctio fugiat qui.', 'Enim voluptatem mollitia ipsam esse earum error officia. Qui temporibus et quos omnis eaque. Ullam quas facilis optio occaecati voluptates nihil quaerat odio. Facere sed vero odio.', 0, 21, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(52, 5, 'Fuga distinctio consequuntur odio est eos.', 'Minima harum unde hic. Animi suscipit doloribus quae recusandae quibusdam debitis. Eaque nisi ut aut quia aut molestiae. Quod reprehenderit nobis qui consequatur.', 98, 3, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(53, 4, 'Ea ad doloribus consequatur impedit eveniet est ad.', 'Sunt totam nesciunt consequatur animi consequatur beatae. Sit sequi molestiae quos adipisci doloribus a placeat voluptas. Impedit ratione et soluta quia. Dignissimos voluptas error ratione quia delectus.', 0, 34, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(54, 2, 'Qui quasi architecto quasi cupiditate.', 'Ex eligendi repellendus est magnam. Magnam non voluptatem asperiores est sint repudiandae et ea. Consequatur recusandae aut quod.', 0, 8, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(55, 3, 'Repudiandae dolore autem illo vitae natus.', 'Quibusdam quos et pariatur enim facilis et deserunt. Exercitationem ipsa consequatur sequi architecto quia.', 0, 26, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(56, 2, 'Ad iste vero officiis et incidunt.', 'Voluptatibus esse quia consectetur vel. Molestias eos corrupti sunt distinctio voluptates. Est qui id deserunt aut eum ad explicabo dolores. Cumque error eius et qui dolor totam et.', 0, 39, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(57, 5, 'Iusto est voluptatem nesciunt alias.', 'Eius rerum modi ipsum quam ea voluptatibus. Consequatur necessitatibus at sit natus a quo ullam. Corrupti vel placeat omnis ullam dolore eligendi.', 0, 35, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(58, 5, 'Alias necessitatibus rem nemo hic ea rerum.', 'Totam nihil possimus officia rerum voluptates. Quia in ut id. Error beatae reiciendis et soluta. Molestiae omnis ipsam sed sed iste quia nihil.', 89, 7, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(59, 2, 'Minus eligendi error cumque et in voluptatem rem.', 'Cum nulla vero ducimus at. Libero sint ut dolore omnis voluptas similique. Occaecati ducimus amet a dolor et incidunt atque tempore. Non ab natus dolor itaque et.', 56, 29, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(60, 1, 'Quis nesciunt saepe aut quidem.', 'Asperiores quasi laboriosam possimus dignissimos dolorem. Eum culpa aspernatur iste ipsum blanditiis cumque tempore. Aperiam similique odio cum repudiandae velit eos in et.', 22, 49, 18, '2025-02-18 12:39:53', '2025-02-18 12:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `participant_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participant_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 51, 'auth_token', 'b101ba0f37d0ae4e36948b21ec27574bc67fd4dd9af3ad4c1313a93f639f9f60', '[\"*\"]', NULL, NULL, '2025-02-18 13:14:30', '2025-02-18 13:14:30'),
(3, 'App\\Models\\User', 51, 'auth_token', '49440d8aa0e1daee92f5991598e42dbd033a871830311b3b1baa27f3fb74e608', '[\"*\"]', '2025-02-18 16:57:27', NULL, '2025-02-18 14:11:44', '2025-02-18 16:57:27'),
(4, 'App\\Models\\User', 52, 'auth_token', 'a30f1a57981413bc4329a12d7f21ba28ee89ecb196f6188ae882467e37f3bcc0', '[\"*\"]', '2025-02-19 15:24:38', NULL, '2025-02-19 09:36:54', '2025-02-19 15:24:38'),
(7, 'App\\Models\\User', 51, 'auth_token', 'f0917dd04806bd4d3a1b34556246dcd03a583102b4b37ac61e27e82dbde8b497', '[\"*\"]', NULL, NULL, '2025-02-19 12:18:03', '2025-02-19 12:18:03'),
(8, 'App\\Models\\User', 51, 'auth_token', '727fb67eed02bc3c063c71ee4f33e3d49ec5d2567e7bf85dee7081cc31b177d0', '[\"*\"]', NULL, NULL, '2025-02-19 12:18:20', '2025-02-19 12:18:20'),
(9, 'App\\Models\\User', 51, 'auth_token', 'a17bb59bf2287cb36614614759a8e04f271b8535b5413a90f23a32e013b954e5', '[\"*\"]', NULL, NULL, '2025-02-19 12:18:30', '2025-02-19 12:18:30'),
(10, 'App\\Models\\User', 51, 'auth_token', 'd52fc993ff0b23fc659d23b51f36b6393b8cc757cf3f0a6a06a93248b4e543bd', '[\"*\"]', NULL, NULL, '2025-02-19 12:23:25', '2025-02-19 12:23:25'),
(11, 'App\\Models\\User', 51, 'auth_token', 'cf1585068c8239a838665853384d75d218a1b58fb803322030d3d0e7696e83f5', '[\"*\"]', NULL, NULL, '2025-02-19 12:23:50', '2025-02-19 12:23:50'),
(12, 'App\\Models\\User', 51, 'auth_token', '87367d0edadb129c8942535fb1e7b7a13ccdc5b0ae8737ed7658c6acf1164d06', '[\"*\"]', '2025-02-19 12:29:37', NULL, '2025-02-19 12:27:16', '2025-02-19 12:29:37'),
(19, 'App\\Models\\User', 51, 'auth_token', '96d13c7b269f6e99a3509d6511d0613821e0be3ba7c7d48bccd2ceaba4eccb65', '[\"*\"]', '2025-02-19 15:53:51', NULL, '2025-02-19 15:45:59', '2025-02-19 15:53:51'),
(20, 'App\\Models\\User', 53, 'auth_token', '2015e430d0ef35150e30842be12048a74600c68682cb55025821bb63f161cef9', '[\"*\"]', NULL, NULL, '2025-02-19 18:59:09', '2025-02-19 18:59:09'),
(21, 'App\\Models\\User', 54, 'auth_token', '6d32414ac755388e15019201be67b1fcf7f04e38f9dc34999d61db58b591a6f0', '[\"*\"]', NULL, NULL, '2025-02-19 21:21:11', '2025-02-19 21:21:11'),
(24, 'App\\Models\\User', 54, 'auth_token', '7068db3da4785547f8c943dc5b7a568d65ec11628652b65d17365241f8ade14c', '[\"role:user\"]', '2025-02-20 13:00:54', NULL, '2025-02-20 13:00:53', '2025-02-20 13:00:54'),
(25, 'App\\Models\\User', 53, 'auth_token', '42614e95a5301fec5a3233d14099bdd7fd0cb3fbf9e83908abaf5d4e3ef84d9d', '[\"role:user\"]', '2025-02-20 14:21:53', NULL, '2025-02-20 13:46:21', '2025-02-20 14:21:53'),
(26, 'App\\Models\\User', 54, 'auth_token', '54960a174d8f68b4b62624fd857bca352606a65e0c1499ebce245e75b39312db', '[\"role:user\"]', '2025-02-20 14:47:22', NULL, '2025-02-20 14:29:22', '2025-02-20 14:47:22'),
(27, 'App\\Models\\User', 55, 'auth_token', '747d689a01e539e5d169b82ee9954142e5f2f3cfd86feba38366e50b4d852893', '[\"*\"]', NULL, NULL, '2025-02-21 10:07:11', '2025-02-21 10:07:11'),
(31, 'App\\Models\\User', 55, 'auth_token', '56af03fd661d09dc59a7ed2594e90882b39c0d8b5813870ddfc84a9e8c29796e', '[\"role:user\"]', '2025-02-21 11:04:17', NULL, '2025-02-21 11:04:07', '2025-02-21 11:04:17'),
(32, 'App\\Models\\organization', 23, 'auth_token', '9e06df6610595cd5aada145e775aa41bb6d9403567b6bb535c8079568a071966', '[\"role:organization\"]', '2025-02-21 11:10:51', NULL, '2025-02-21 11:10:49', '2025-02-21 11:10:51'),
(33, 'App\\Models\\User', 54, 'auth_token', '46586d3e0573805779808c853ff67e3799488fe2a99bdb3b67fab19049322219', '[\"role:user\"]', '2025-02-21 11:14:56', NULL, '2025-02-21 11:14:55', '2025-02-21 11:14:56'),
(36, 'App\\Models\\User', 51, 'auth_token', 'd7cc977f0b53bacb532bb0bf06f905551dba158f1ce048454b9b6f6e7367fc09', '[\"*\"]', '2025-02-21 17:13:37', NULL, '2025-02-21 17:13:36', '2025-02-21 17:13:37'),
(37, 'App\\Models\\User', 54, 'auth_token', '7cf837d1e1fa2499a84a2f0a80450c1569455a8bf6f196803b2b3a2d2d4edcdf', '[\"role:user\"]', '2025-02-24 11:03:48', NULL, '2025-02-21 19:16:14', '2025-02-24 11:03:48'),
(38, 'App\\Models\\User', 51, 'auth_token', '15b1d6d1936437b9b00b743f4bb07b2a63c76ad108835f8241aa86ed6f83514a', '[\"*\"]', '2025-02-21 20:17:16', NULL, '2025-02-21 19:31:54', '2025-02-21 20:17:16'),
(40, 'App\\Models\\User', 51, 'auth_token', '7d8516e3465b207dd0371e2ad58325ce8c2bdbb2c4bdf5086ac6ab863363b3eb', '[\"*\"]', '2025-02-22 09:12:17', NULL, '2025-02-22 09:12:16', '2025-02-22 09:12:17'),
(41, 'App\\Models\\User', 54, 'auth_token', 'f4ef209399d269cbf4cf34d1ba4ac75831a97318b217f4cdf06ef1fb1239b2d2', '[\"role:user\"]', '2025-02-22 21:59:18', NULL, '2025-02-22 18:37:24', '2025-02-22 21:59:18'),
(47, 'App\\Models\\User', 56, 'auth_token', '56111cac6a466f012eaa89482f4ef94901c0fe33fe59ac31e3dd8a7df8b63421', '[\"*\"]', '2025-02-23 10:06:26', NULL, '2025-02-23 10:06:24', '2025-02-23 10:06:26'),
(48, 'App\\Models\\User', 57, 'auth_token', '0c59e5afaeb23babe7ecf359441141d34fdaa16498dc7d112235660f6aee6496', '[\"*\"]', NULL, NULL, '2025-02-23 10:26:58', '2025-02-23 10:26:58'),
(49, 'App\\Models\\User', 55, 'auth_token', '5c6dc29657e20c5fb88c50e6802bcd14634b56755108a23125921c831d6dc73b', '[\"role:user\"]', '2025-02-23 11:17:53', NULL, '2025-02-23 10:27:24', '2025-02-23 11:17:53'),
(50, 'App\\Models\\User', 57, 'auth_token', '3bc04986b326efb2becca94e9ad821d2129d7fed89aebd7987a9e2636b164cd2', '[\"role:user\"]', '2025-02-23 11:14:03', NULL, '2025-02-23 10:28:06', '2025-02-23 11:14:03'),
(51, 'App\\Models\\User', 58, 'auth_token', 'acd040c475e37419598b6c9c299177392a6aa7c00a15a4a47f8736d503f445e6', '[\"*\"]', NULL, NULL, '2025-02-23 10:28:57', '2025-02-23 10:28:57'),
(52, 'App\\Models\\User', 59, 'auth_token', 'c0697873600bac03412f0ef49ef8b65a2b854f412d49d781726257b4b26b6874', '[\"*\"]', NULL, NULL, '2025-02-23 10:29:43', '2025-02-23 10:29:43'),
(53, 'App\\Models\\User', 60, 'auth_token', 'd780fcde40699412bd04e10c1714f6bdec0d140b81757b67a82972d0707bf5b5', '[\"*\"]', NULL, NULL, '2025-02-23 10:30:11', '2025-02-23 10:30:11'),
(54, 'App\\Models\\User', 61, 'auth_token', '2a2cfff4fa42c524b773a6255c2b1860a4affeb2cad42faf34323535ac006ee8', '[\"*\"]', NULL, NULL, '2025-02-23 10:31:56', '2025-02-23 10:31:56'),
(55, 'App\\Models\\User', 62, 'auth_token', '9520607e9a40142f715158322c384de2ac46b42206b9043b202abccd74aa82aa', '[\"*\"]', NULL, NULL, '2025-02-23 10:32:04', '2025-02-23 10:32:04'),
(56, 'App\\Models\\User', 63, 'auth_token', '14990d94ac106d3836e86cdfde070fdd482af55937f58648b677f7eb9740cc7b', '[\"*\"]', NULL, NULL, '2025-02-23 10:32:33', '2025-02-23 10:32:33'),
(57, 'App\\Models\\User', 56, 'auth_token', '854ce1daf17cc0c7eb7e92c457a55a59bbc1dc7e2284ba3285b0388b8628ed06', '[\"role:user\"]', '2025-02-23 11:20:00', NULL, '2025-02-23 10:33:36', '2025-02-23 11:20:00'),
(58, 'App\\Models\\User', 61, 'auth_token', '7bf73d7b89c7d2e7ab4fcf26ef4cfb834f97cd89c436450005dd2229bb64352e', '[\"role:user\"]', '2025-02-23 10:34:09', NULL, '2025-02-23 10:34:02', '2025-02-23 10:34:09'),
(59, 'App\\Models\\User', 63, 'auth_token', '96793870780b9cc7d3f9b15323a342db500e10cb755482f78cc688c4a2e72511', '[\"role:user\"]', '2025-02-23 11:17:15', NULL, '2025-02-23 10:34:41', '2025-02-23 11:17:15'),
(60, 'App\\Models\\User', 64, 'auth_token', '7c0d08b8ba75c3639bfed7f8256f3dffa5b88aa8285d0051f8cc572015218a27', '[\"*\"]', NULL, NULL, '2025-02-23 10:35:57', '2025-02-23 10:35:57'),
(61, 'App\\Models\\User', 65, 'auth_token', 'b9cc7d5791c9748891edbb52c7c28c2df6ee535d161299a2ea0caa7d7e3c702b', '[\"*\"]', NULL, NULL, '2025-02-23 10:37:15', '2025-02-23 10:37:15'),
(62, 'App\\Models\\User', 64, 'auth_token', 'b3855477b49da78ad3302cd796ebee416b11957b06c2f3dc51041053b7b7ee8b', '[\"role:user\"]', '2025-02-23 10:38:20', NULL, '2025-02-23 10:38:20', '2025-02-23 10:38:20'),
(63, 'App\\Models\\User', 58, 'auth_token', 'f74639a4088e3ed1151b12c5ae0362552643bf86ea64788536003ecc5027815e', '[\"role:user\"]', '2025-02-23 11:28:32', NULL, '2025-02-23 10:39:28', '2025-02-23 11:28:32'),
(64, 'App\\Models\\User', 62, 'auth_token', 'dfb4018c966b6dadb5ffa095779cd0d47c86920ea2b815743a196bc6d3cceeec', '[\"role:user\"]', '2025-02-23 10:39:44', NULL, '2025-02-23 10:39:42', '2025-02-23 10:39:44'),
(65, 'App\\Models\\User', 66, 'auth_token', '0d3acece82658f317a14812791a6da171ede90b2276f73aace17998b631c61b0', '[\"*\"]', NULL, NULL, '2025-02-23 10:42:32', '2025-02-23 10:42:32'),
(66, 'App\\Models\\User', 66, 'auth_token', '64d5ce46d7627c65f359c3d96ce0932ed7812e756458725d3d74052aa481243d', '[\"role:user\"]', '2025-02-23 11:25:26', NULL, '2025-02-23 10:43:16', '2025-02-23 11:25:26'),
(67, 'App\\Models\\User', 67, 'auth_token', '402a6a2a3a8b05e83496247a3a108a61cae4b1c265c5641d7de7c89090f89ab5', '[\"*\"]', NULL, NULL, '2025-02-23 10:44:11', '2025-02-23 10:44:11'),
(69, 'App\\Models\\User', 68, 'auth_token', '571e341d07e51b6a5b7f4148de67f9699602b69c95d3ea57884d6795d580a655', '[\"*\"]', '2025-02-23 11:16:13', NULL, '2025-02-23 10:48:42', '2025-02-23 11:16:13'),
(70, 'App\\Models\\User', 69, 'auth_token', 'eb2bc9316c57ce83dfd3ce56fefac84ddeb005be6e027d695e6df4ad7ae90a6e', '[\"*\"]', NULL, NULL, '2025-02-23 11:01:15', '2025-02-23 11:01:15'),
(71, 'App\\Models\\User', 70, 'auth_token', 'a52f405d35142b1f3ff9284e1402edbb02c8d34198f405da5c661b4a98ede5bd', '[\"*\"]', NULL, NULL, '2025-02-23 11:03:12', '2025-02-23 11:03:12'),
(72, 'App\\Models\\User', 70, 'auth_token', '56459b903783ec3eb58d14de79532bbdfc3e2e0a6c2dc3ab53f970c61a7269d2', '[\"role:user\"]', '2025-02-23 11:37:09', NULL, '2025-02-23 11:05:32', '2025-02-23 11:37:09'),
(73, 'App\\Models\\User', 60, 'auth_token', 'da8990114a10747e37d7e53d513d1d5c64939cd43b7fa0a52582580f63e4224c', '[\"*\"]', '2025-02-23 11:14:14', NULL, '2025-02-23 11:08:51', '2025-02-23 11:14:14'),
(74, 'App\\Models\\User', 67, 'auth_token', '32f3bb4a465afe9518c3f7bb12b4dd771ba178552aad80404ac64a708a7ac8fb', '[\"role:user\"]', '2025-02-23 11:10:28', NULL, '2025-02-23 11:10:24', '2025-02-23 11:10:28'),
(75, 'App\\Models\\User', 53, 'auth_token', '63035e30ef40286d248760c86ad92c5519d1eb66d90c0468e9973da9b12cf18c', '[\"role:user\"]', '2025-02-23 11:13:56', NULL, '2025-02-23 11:12:36', '2025-02-23 11:13:56'),
(76, 'App\\Models\\User', 59, 'auth_token', 'ec859f2fd623ce2f3bb56a4b0a73e58241a90dd8ffb46f8028a5b002791fc7a7', '[\"role:user\"]', '2025-02-23 11:22:25', NULL, '2025-02-23 11:16:33', '2025-02-23 11:22:25'),
(77, 'App\\Models\\User', 63, 'auth_token', '2974926b105628f555f4d6140ba85980600aa5ad44d42fc033077b480bd2d10c', '[\"role:user\"]', '2025-02-23 11:30:15', NULL, '2025-02-23 11:18:20', '2025-02-23 11:30:15'),
(78, 'App\\Models\\User', 69, 'auth_token', '9c16e79f67f9c81013b1bf65da90e9d2cea231dd458925e8993dbb4837a22847', '[\"role:user\"]', '2025-02-24 09:30:23', NULL, '2025-02-23 11:19:21', '2025-02-24 09:30:23'),
(79, 'App\\Models\\User', 65, 'auth_token', 'dd60b39641a2e4b55aff165309ed66a1d863d03ae7f6b0723d7f2ae0b39fd36c', '[\"role:user\"]', '2025-02-23 11:20:45', NULL, '2025-02-23 11:20:43', '2025-02-23 11:20:45'),
(80, 'App\\Models\\User', 54, 'auth_token', '654e34882ff2644fc35e0ffa1df0de9d41d760d3a5880c13b9e392d088e66a4a', '[\"role:user\"]', '2025-02-23 12:07:04', NULL, '2025-02-23 11:23:57', '2025-02-23 12:07:04'),
(81, 'App\\Models\\User', 64, 'auth_token', 'ee1e95271d24adf703958cbafcd37855bbf90ed17d7c59241014b93548070e91', '[\"role:user\"]', '2025-02-23 12:02:53', NULL, '2025-02-23 11:24:37', '2025-02-23 12:02:53'),
(82, 'App\\Models\\User', 66, 'auth_token', '2b08018a0cadf65d5573aefbcc908d2275b15e0a7dcee333ec0a2b13dd06e2f9', '[\"role:user\"]', '2025-02-23 11:25:34', NULL, '2025-02-23 11:25:34', '2025-02-23 11:25:34'),
(83, 'App\\Models\\User', 68, 'auth_token', '13e71f12b351a11428e662d76d04923ee3cc9a8031507000bfe9486f63fe5680', '[\"*\"]', '2025-02-23 11:36:00', NULL, '2025-02-23 11:30:38', '2025-02-23 11:36:00'),
(84, 'App\\Models\\User', 62, 'auth_token', '6a0de00c01ae8032ea0a9d6841442388766de877223a208424916450b22714d8', '[\"role:user\"]', '2025-02-23 11:37:32', NULL, '2025-02-23 11:33:45', '2025-02-23 11:37:32'),
(85, 'App\\Models\\User', 62, 'auth_token', 'cc63815253678b1746a3ecba9d7ae7b8725cd7de8c09822aa80ed496f45a177f', '[\"role:user\"]', '2025-02-23 12:07:11', NULL, '2025-02-23 11:45:29', '2025-02-23 12:07:11'),
(86, 'App\\Models\\User', 71, 'auth_token', 'd968f6d17cf6c363b9d1b72fdd6e81827acefe0fbbd7609fe6b0b911b827add3', '[\"*\"]', NULL, NULL, '2025-02-23 12:27:03', '2025-02-23 12:27:03'),
(87, 'App\\Models\\User', 62, 'auth_token', 'fb393acbe8b29197c6af1a0d1fa2408a9b05a7ee6ceca6b5bb3b911757a4fdae', '[\"role:user\"]', '2025-02-23 15:09:24', NULL, '2025-02-23 15:09:20', '2025-02-23 15:09:24'),
(89, 'App\\Models\\User', 67, 'auth_token', '4c7aec52c048bc9862100e370e2e8f06dc7882e55df07833da036723e8b38ebe', '[\"role:user\"]', '2025-02-23 16:26:06', NULL, '2025-02-23 15:51:20', '2025-02-23 16:26:06'),
(90, 'App\\Models\\User', 64, 'auth_token', 'bdcaa2519f5b72683ac8fe98a9d70a4a43ba8c134ac9a916f500ae5b0021459b', '[\"role:user\"]', '2025-02-23 19:22:54', NULL, '2025-02-23 19:22:53', '2025-02-23 19:22:54'),
(91, 'App\\Models\\User', 57, 'auth_token', '79185dac364e59224333849e0cbba9ea19b37e815fe4c952a5772200148078d1', '[\"role:user\"]', '2025-02-23 19:26:33', NULL, '2025-02-23 19:26:31', '2025-02-23 19:26:33'),
(92, 'App\\Models\\User', 67, 'auth_token', '42df7f9c60a9a4f9ced1abae1ede61bde283e9c9c7332faef39718c14ba54129', '[\"role:user\"]', '2025-02-24 01:30:07', NULL, '2025-02-24 01:27:25', '2025-02-24 01:30:07'),
(93, 'App\\Models\\User', 54, 'auth_token', 'da884495c44ef7e451b427bccbcee240e9c490eb774d7e68d693aefbc629d628', '[\"role:user\"]', '2025-02-24 06:22:18', NULL, '2025-02-24 06:22:07', '2025-02-24 06:22:18'),
(94, 'App\\Models\\User', 59, 'auth_token', 'f3dff08542cc81a13b1d5715ef56b327212f8b4b89d399524306f38e1b3f8b39', '[\"role:user\"]', '2025-02-24 08:17:33', NULL, '2025-02-24 08:17:07', '2025-02-24 08:17:33'),
(95, 'App\\Models\\User', 60, 'auth_token', 'c3241a0657214074b25792187177867d931226f6b9b384b6fc771b3a94d1b5ee', '[\"role:user\"]', '2025-02-24 08:41:19', NULL, '2025-02-24 08:39:21', '2025-02-24 08:41:19'),
(96, 'App\\Models\\User', 64, 'auth_token', '8cc43d6ea6fdebf3f243d620855aacf7f3ba7ca5c9495ce2870ab6eb5be98da6', '[\"role:user\"]', '2025-02-24 08:52:12', NULL, '2025-02-24 08:39:23', '2025-02-24 08:52:12'),
(97, 'App\\Models\\User', 59, 'auth_token', '64e029f4609a57184ece6a84e5f8f2366e262abd52eb015c06741d4b4a267bbd', '[\"role:user\"]', '2025-02-24 09:48:12', NULL, '2025-02-24 08:52:14', '2025-02-24 09:48:12'),
(98, 'App\\Models\\User', 65, 'auth_token', 'afd0cd63352e7d6102f8bbca8565c0df94c284344d1cd5f8e7384c0a9c9924ca', '[\"role:user\"]', '2025-02-24 09:09:31', NULL, '2025-02-24 09:09:30', '2025-02-24 09:09:31'),
(101, 'App\\Models\\User', 56, 'auth_token', 'e3768d777fc8cf21e5a26ae17eda960a262b43b56ad1e5f69e70142f30f80e68', '[\"role:user\"]', '2025-02-24 09:52:30', NULL, '2025-02-24 09:50:45', '2025-02-24 09:52:30'),
(102, 'App\\Models\\User', 63, 'auth_token', 'cb5e8985e2a0a857fc465a95c663bc391ef97fc81700ea22fca7afb00f62c2ea', '[\"role:user\"]', '2025-02-24 09:54:35', NULL, '2025-02-24 09:54:34', '2025-02-24 09:54:35'),
(103, 'App\\Models\\User', 64, 'auth_token', '3f4d07b95ebd892ca439243cfc446a979b58bb588d4eeb1fd2ea70f54a38ba4a', '[\"role:user\"]', '2025-02-24 10:01:28', NULL, '2025-02-24 10:01:27', '2025-02-24 10:01:28'),
(104, 'App\\Models\\User', 56, 'auth_token', '013c3424f7d8a282028b10a285a8f321e19ed610d2cedddf0bf4e5eddcc0ae29', '[\"role:user\"]', '2025-02-24 10:45:45', NULL, '2025-02-24 10:16:43', '2025-02-24 10:45:45'),
(105, 'App\\Models\\User', 60, 'auth_token', 'fa51ad4b411a514ffd05c8eb549b8e888f418b49837c235490d51627b63a8150', '[\"role:user\"]', '2025-02-24 10:23:31', NULL, '2025-02-24 10:22:04', '2025-02-24 10:23:31'),
(107, 'App\\Models\\User', 72, 'auth_token', '67ce12c370b6e5d364fefac5bdd8b345db7ad07d73248370236dd6581114580e', '[\"*\"]', NULL, NULL, '2025-02-24 10:27:00', '2025-02-24 10:27:00'),
(109, 'App\\Models\\User', 55, 'auth_token', '976bee70af6eda77bed8ebd8d10c8022e906a5c486ef06b63184aab3e83b56b2', '[\"role:user\"]', '2025-02-24 11:38:18', NULL, '2025-02-24 11:38:17', '2025-02-24 11:38:18'),
(110, 'App\\Models\\User', 64, 'auth_token', '7d73e01558ab4f622d1043e07661aa42a60ceec679c807e7bb4b5cee0fcd1efa', '[\"role:user\"]', '2025-02-24 12:24:42', NULL, '2025-02-24 11:54:03', '2025-02-24 12:24:42'),
(111, 'App\\Models\\User', 72, 'auth_token', 'a70bd2378ac09a5a16f822432f74f8c46fc706a4f02a456726d6c19a495296e9', '[\"role:user\"]', '2025-02-24 12:15:59', NULL, '2025-02-24 12:14:35', '2025-02-24 12:15:59'),
(112, 'App\\Models\\User', 56, 'auth_token', '8eb5d654cf5bbbd0a7e3386e304ec858ed86cf94d106a530e0e78c968a99b583', '[\"role:user\"]', '2025-02-24 12:50:27', NULL, '2025-02-24 12:50:26', '2025-02-24 12:50:27'),
(113, 'App\\Models\\User', 70, 'auth_token', '4c48445570b42e4cd84525f60d05a2d3b0c6198f8eef3312f9b8f2c5241b4dd9', '[\"role:user\"]', '2025-02-24 12:53:25', NULL, '2025-02-24 12:53:24', '2025-02-24 12:53:25'),
(114, 'App\\Models\\User', 64, 'auth_token', 'b9d088bbde7535fd4b28f26b6b2f514db85788c58d7243ad5b327b0d55361b8e', '[\"role:user\"]', '2025-02-24 13:31:51', NULL, '2025-02-24 13:31:46', '2025-02-24 13:31:51'),
(115, 'App\\Models\\User', 64, 'auth_token', 'ae6049de3e1c69f68597bedb917d9952a40345106693ec3d77dc23df79a38d5c', '[\"role:user\"]', '2025-02-24 14:22:09', NULL, '2025-02-24 14:22:09', '2025-02-24 14:22:09'),
(116, 'App\\Models\\User', 63, 'auth_token', 'b3cbf3be8ec022f9910b34c84dfe83bab68b5d2ae978a93854290197208266a5', '[\"role:user\"]', NULL, NULL, '2025-02-24 14:33:03', '2025-02-24 14:33:03'),
(118, 'App\\Models\\organization', 1, 'auth_token', 'f6ceb28866951a0a80cabb2831038b3b6bd02148e043595bd4fa823289f5bd2d', '[\"role:organization\"]', '2025-02-24 14:47:19', NULL, '2025-02-24 14:45:12', '2025-02-24 14:47:19');

-- --------------------------------------------------------

--
-- Table structure for table `point_cooperations`
--

CREATE TABLE `point_cooperations` (
  `id` bigint UNSIGNED NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_cooperations`
--

INSERT INTO `point_cooperations` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2025-02-19 15:35:42', '2025-02-19 15:35:42'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2025-02-19 15:35:42', '2025-02-19 15:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy_organizations`
--

CREATE TABLE `privacy_policy_organizations` (
  `id` bigint UNSIGNED NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policy_organizations`
--

INSERT INTO `privacy_policy_organizations` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2025-02-19 15:36:22', '2025-02-19 15:36:22'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2025-02-19 15:36:22', '2025-02-19 15:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy_users`
--

CREATE TABLE `privacy_policy_users` (
  `id` bigint UNSIGNED NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policy_users`
--

INSERT INTO `privacy_policy_users` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2025-02-19 15:36:31', '2025-02-19 15:36:31'),
(21, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(22, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(23, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(24, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(25, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(26, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(27, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(28, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(29, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(30, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(31, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(32, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(33, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(34, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(35, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(36, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(37, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(38, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(39, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2025-02-19 15:36:47', '2025-02-19 15:36:47'),
(40, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2025-02-19 15:36:47', '2025-02-19 15:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `promoter_new_users`
--

CREATE TABLE `promoter_new_users` (
  `id` bigint UNSIGNED NOT NULL,
  `promoter_id` bigint UNSIGNED NOT NULL,
  `new_account_id` bigint UNSIGNED NOT NULL,
  `new_account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promoter_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotional_cards`
--

CREATE TABLE `promotional_cards` (
  `id` bigint UNSIGNED NOT NULL,
  `card_id` bigint UNSIGNED NOT NULL,
  `bell_id` bigint UNSIGNED NOT NULL,
  `promoter_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_quantity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotional_cards`
--

INSERT INTO `promotional_cards` (`id`, `card_id`, `bell_id`, `promoter_code`, `order_quantity`, `created_at`, `updated_at`) VALUES
(3, 2, 34, 'HVnUfQtZfo', 1, '2025-02-23 14:27:51', '2025-02-23 14:27:51'),
(4, 3, 34, 'HVnUfQtZfo', 1, '2025-02-23 14:27:51', '2025-02-23 14:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `provisional_data`
--

CREATE TABLE `provisional_data` (
  `id` bigint UNSIGNED NOT NULL,
  `uniqueId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cardsDetailes` json NOT NULL,
  `expire_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provisional_data`
--

INSERT INTO `provisional_data` (`id`, `uniqueId`, `purchase_id`, `cardsDetailes`, `expire_at`, `created_at`, `updated_at`) VALUES
(1, '1349', NULL, '[{\"id\": \"4\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/card_1.jpg\", \"price\": \"9.99\", \"title\": \"Basic Subscription\", \"duration\": \"1 month\", \"quantity\": 1}]', '2025-02-19 16:48:28', '2025-02-19 15:48:28', '2025-02-19 15:48:28'),
(7, '3861', NULL, '[{\"id\": \"1\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (7)_67b64cb3c8d73.png\", \"price\": \"30.00\", \"title\": \"Basic Subscription\", \"duration\": \"3\", \"quantity\": 1}, {\"id\": \"7\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (3)_67b8445121e31.png\", \"price\": \"30.00\", \"title\": \"Basic Subscription\", \"duration\": \"11\", \"quantity\": 2}, {\"id\": \"8\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/card_2_679b299dd99fe.png\", \"price\": \"19.99\", \"title\": \"Pro Subscription\", \"duration\": \"1 month\", \"quantity\": 2}]', '2025-02-21 12:08:22', '2025-02-21 11:08:22', '2025-02-21 11:08:22'),
(9, '4348', NULL, '{\"user_id\": \"51\", \"book_day\": \"2025-02-22\", \"book_time\": \"09:00 AM\", \"expire_in\": \"09:15 AM\", \"organization_id\": \"1\", \"additional_notes\": null}', '2025-02-22 09:17:04', '2025-02-22 08:17:04', '2025-02-22 08:17:04'),
(10, '7429', NULL, '{\"user_id\": \"51\", \"book_day\": \"2025-02-22\", \"book_time\": \"09:00 AM\", \"expire_in\": \"09:15 AM\", \"organization_id\": \"1\", \"additional_notes\": null}', '2025-02-22 09:32:51', '2025-02-22 08:32:51', '2025-02-22 08:32:51'),
(11, '8911', NULL, '{\"user_id\": \"51\", \"book_day\": \"2025-02-22\", \"book_time\": \"09:00 AM\", \"expire_in\": \"09:15 AM\", \"organization_id\": \"1\", \"additional_notes\": null}', '2025-02-22 09:32:58', '2025-02-22 08:32:58', '2025-02-22 08:32:58'),
(12, '5545', NULL, '{\"user_id\": \"51\", \"book_day\": \"2025-02-22\", \"book_time\": \"10:00 AM\", \"expire_in\": \"10:15 AM\", \"organization_id\": \"1\", \"additional_notes\": null}', '2025-02-22 09:36:03', '2025-02-22 08:36:03', '2025-02-22 08:36:03'),
(15, '6573', NULL, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"12\", \"quantity\": 1}, {\"id\": \"3\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png\", \"price\": \"50.00\", \"title\": \"Enterprise Subscription\", \"duration\": \"12\", \"quantity\": 1}]', '2025-02-23 15:22:51', '2025-02-23 14:22:51', '2025-02-23 14:22:51'),
(16, '7039', NULL, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"12\", \"quantity\": 1}, {\"id\": \"3\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png\", \"price\": \"50.00\", \"title\": \"Enterprise Subscription\", \"duration\": \"12\", \"quantity\": 1}]', '2025-02-23 15:22:54', '2025-02-23 14:22:54', '2025-02-23 14:22:54'),
(17, '8674', NULL, '[{\"id\": \"2\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/ARAM CARD (12)_67b64cef43627.png\", \"price\": \"30.00\", \"title\": \"Pro Subscription\", \"duration\": \"12\", \"quantity\": 1}, {\"id\": \"3\", \"image\": \"https://datafromapi-2.aram-gulf.com/images/cardtypes/dr. Shawakh alborsan (6)_67b64d0c0eab1.png\", \"price\": \"50.00\", \"title\": \"Enterprise Subscription\", \"duration\": \"12\", \"quantity\": 1}]', '2025-02-23 15:22:59', '2025-02-23 14:22:59', '2025-02-23 14:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `bell_id` bigint UNSIGNED DEFAULT NULL,
  `buyer_id` bigint UNSIGNED DEFAULT NULL,
  `buyer_type` enum('User','Organization') COLLATE utf8mb4_unicode_ci NOT NULL,
  `promo_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uniqId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `bell_id`, `buyer_id`, `buyer_type`, `promo_code`, `uniqId`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 51, 34, 51, 'User', 'HVnUfQtZfo', '67bb2f37b0e76', 80.00, 'completed', '2025-02-23 14:22:47', '2025-02-23 14:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `question_answers`
--

CREATE TABLE `question_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_answers`
--

INSERT INTO `question_answers` (`id`, `question`, `answer`, `user_id`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 'ما هو Laravel؟', 'Laravel هو إطار عمل PHP مفتوح المصدر يستخدم لتطوير تطبيقات الويب.', 1, 1, NULL, NULL),
(2, 'ما هي RESTful APIs؟', 'RESTful APIs هي واجهات برمجة تطبيقات تعتمد على مبادئ REST، وهي تسمح بالتواصل بين الأنظمة المختلفة باستخدام HTTP.', 2, 1, NULL, NULL),
(3, 'ما هو الفرق بين GET و POST في HTTP؟', 'GET يستخدم لجلب البيانات من السيرفر، بينما POST يستخدم لإرسال البيانات إلى السيرفر.', 3, 1, NULL, NULL),
(4, 'كيف يمكنني إعداد بيئة تطوير Laravel؟', 'يمكن إعداد بيئة Laravel باستخدام Composer لتنصيب الحزم، بالإضافة إلى Homestead أو Valet لتوفير بيئة خادم محلي.', 4, 1, NULL, NULL),
(5, 'ما هو مفهوم MVC؟', 'MVC هو اختصار لـ Model-View-Controller، وهو نمط تصميم يستخدم لفصل منطق الأعمال (Model) عن العرض (View) والتحكم (Controller).', 5, 1, NULL, NULL),
(6, 'كيف يمكنني التعامل مع قواعد البيانات في Laravel؟', 'يمكن التعامل مع قواعد البيانات باستخدام Eloquent ORM الخاص بـ Laravel أو من خلال استعلامات SQL التقليدية باستخدام Query Builder.', 1, 1, NULL, NULL),
(7, 'ما هو مفهوم Middleware في Laravel؟', 'Middleware هو طبقة وسيطة يمكن استخدامها لتنفيذ عمليات قبل أو بعد معالجة الطلب في Laravel.', 2, 1, NULL, NULL),
(8, 'كيف يمكنني إرسال بريد إلكتروني باستخدام Laravel؟', 'يمكنك استخدام مكتبة Mail في Laravel لإرسال بريد إلكتروني باستخدام SMTP أو عبر خدمات مثل Mailgun و SendGrid.', 3, 1, NULL, NULL),
(9, 'ما هي الحزم في Laravel؟', 'الحزم في Laravel هي وحدات قابلة لإعادة الاستخدام تضيف ميزات ووظائف جديدة إلى تطبيق Laravel.', 4, 1, NULL, NULL),
(10, 'ما هو Artisan؟', 'Artisan هو أداة سطر أوامر في Laravel تساعد في تنفيذ المهام الروتينية مثل إنشاء الملفات وتنفيذ الهجرات.', 5, 1, NULL, NULL),
(11, 'كيف يمكنني تأمين تطبيق Laravel؟', 'يمكن تأمين تطبيق Laravel باستخدام الميزات المدمجة مثل التحقق من الصلاحيات Middleware و الحماية من الهجمات عبر CSRF.', 1, 1, NULL, NULL),
(12, 'ما هو مفهوم Service Container في Laravel؟', 'Service Container هو أداة قوية في Laravel تُستخدم لإدارة التبعية بين الكائنات.', 2, 1, NULL, NULL),
(13, 'ما هي الهجرات (Migrations) في Laravel؟', 'الهجرات هي طريقة لإدارة إصدار قاعدة البيانات في Laravel، حيث يمكنك إنشاء وتعديل الجداول بسهولة.', 3, 1, NULL, NULL),
(14, 'ما هو Blade في Laravel؟', 'Blade هو محرك القوالب الخاص بـ Laravel والذي يسمح لك بكتابة قوالب ديناميكية باستخدام تركيبات بسيطة.', 4, 1, NULL, NULL),
(15, 'كيف يمكنني تنفيذ مصادقة المستخدمين في Laravel؟', 'يمكنك تنفيذ مصادقة المستخدمين باستخدام نظام Auth المدمج في Laravel الذي يدعم تسجيل الدخول والتسجيل وإدارة الجلسات.', 5, 1, NULL, NULL),
(16, 'ما هو الفرق بين Vue.js و React؟', 'Vue.js و React كلاهما مكتبتان لبناء واجهات المستخدم، لكن React مكتبة موجهة للمكونات بينما Vue.js إطار أكثر تكاملاً.', 1, 1, NULL, NULL),
(17, 'كيف يمكنني تحسين أداء تطبيق Laravel؟', 'يمكن تحسين الأداء باستخدام التخزين المؤقت (caching)، وضبط قواعد البيانات، وتقليل عدد الاستعلامات.', 2, 1, NULL, NULL),
(18, 'ما هو مفهوم Pivot Table في Laravel؟', 'Pivot Table هو جدول وسيط يستخدم لتمثيل العلاقات المتعددة بين الجداول في قاعدة البيانات.', 3, 1, NULL, NULL),
(19, 'كيف يمكنني إدارة المهام المجدولة في Laravel؟', 'يمكنك استخدام Scheduler في Laravel لإدارة المهام المجدولة عبر أوامر Artisan.', 4, 1, NULL, NULL),
(20, 'ما هو الفرق بين include و require في PHP؟', 'include يتضمن ملفًا خارجيًا في حين أن require يوقف تنفيذ البرنامج إذا كان الملف غير موجود.', 5, 1, NULL, NULL),
(21, 'ما هي بطاقة ارام؟', 'بطاقة ارام بطاقة تخفيضات', 1, 1, '2025-02-21 09:33:44', '2025-02-21 09:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` bigint UNSIGNED NOT NULL,
  `like` tinyint(1) NOT NULL,
  `dislike` tinyint(1) NOT NULL,
  `love` tinyint(1) NOT NULL,
  `laugh` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_likes_checks`
--

CREATE TABLE `review_likes_checks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `review_id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `features` longtext COLLATE utf8mb4_unicode_ci,
  `popularity` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `tags` json DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `organization_ids` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title_en`, `title_ar`, `description_ar`, `description_en`, `icon`, `image`, `features`, `popularity`, `status`, `active`, `tags`, `video_url`, `category_id`, `organization_ids`, `created_at`, `updated_at`) VALUES
(1, 'Eye Care', 'العناية بالعيون', 'فحوصات شاملة للعيون وعلاجات لجميع الأعمار.', 'Comprehensive eye exams and treatments for all ages.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/medicine.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service_4.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 15, '19', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(2, 'Dental Services', 'خدمات طب الأسنان', 'رعاية أسنان عالية الجودة لعائلتك.', 'High-quality dental care for your family.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/activeview_678b1a702a20a.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service_6.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 14, '22', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(3, 'Cardiology', 'أمراض القلب', 'رعاية متخصصة لصحة القلب والحالات القلبية.', 'Expert care for heart health and cardiovascular conditions.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/first-aid-kit.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service_4.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 9, '34', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(4, 'Pediatrics', 'طب الأطفال', 'رعاية صحية مخصصة لأطفالك.', 'Dedicated healthcare for your children.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/activeview_678b1a702a20a.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service-01.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 6, '35', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(5, 'Orthopedics', 'جراحة العظام', 'رعاية متخصصة للعظام والمفاصل.', 'Specialized care for bones and joints.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/hospital.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service-01.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 1, '12', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(6, 'Dermatology', 'الأمراض الجلدية', 'رعاية وعلاج شامل للبشرة.', 'Comprehensive skin care and treatment.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/syringe.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service_5.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 16, '2', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(7, 'Nutrition Counseling', 'الإرشاد الغذائي', 'خطط غذائية شخصية لصحة أفضل.', 'Personalized diet plans for a healthier you.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/medicine.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service-01.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 4, '22', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(8, 'Physical Therapy', 'العلاج الطبيعي', 'تمارين علاجية لاستعادة الحركة.', 'Therapeutic exercises to restore mobility.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/first-aid-kit.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service_6.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 11, '1', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(9, 'Radiology', 'الأشعة', 'تصوير متقدم لتشخيص دقيق.', 'Advanced imaging for accurate diagnoses.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/activeview_678b1a702a20a.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service_4.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 0, NULL, NULL, 4, '49', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(10, 'Mental Health', 'الصحة النفسية', 'رعاية داعمة للرفاهية النفسية.', 'Supportive care for emotional well-being.', 'https://datafromapi-2.aram-gulf.com/images/services/icons/syringe.png', 'https://datafromapi-2.aram-gulf.com/images/services/images/service_4.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 0, NULL, NULL, 10, '8', '2025-02-18 12:39:44', '2025-02-18 12:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `title_ar`, `title_en`, `image`, `created_at`, `updated_at`) VALUES
(1, 'الطب العام', 'General Medicine', 'https://datafromapi-2.aram-gulf.com/images/services_categories/first-aid-kit.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(2, 'طب الأطفال', 'Pediatrics', 'https://datafromapi-2.aram-gulf.com/images/services_categories/cardiogram.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(3, 'طب الأسنان', 'Dentistry', 'https://datafromapi-2.aram-gulf.com/images/services_categories/syringe.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(4, 'الأمراض الجلدية', 'Dermatology', 'https://datafromapi-2.aram-gulf.com/images/services_categories/drugs.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(5, 'طب القلب', 'Cardiology', 'https://datafromapi-2.aram-gulf.com/images/services_categories/first-aid-kit.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(6, 'طب الأعصاب', 'Neurology', 'https://datafromapi-2.aram-gulf.com/images/services_categories/medicine.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(7, 'طب العظام', 'Orthopedics', 'https://datafromapi-2.aram-gulf.com/images/services_categories/hospital.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(8, 'طب النساء', 'Gynecology', 'https://datafromapi-2.aram-gulf.com/images/services_categories/medicine.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(9, 'طب العيون', 'Ophthalmology', 'https://datafromapi-2.aram-gulf.com/images/services_categories/medicine.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(10, 'الطب النفسي', 'Psychiatry', 'https://datafromapi-2.aram-gulf.com/images/services_categories/first-aid-kit.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(11, 'العلاج الطبيعي', 'Physiotherapy', 'https://datafromapi-2.aram-gulf.com/images/services_categories/cardiogram.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(12, 'طب الأورام', 'Oncology', 'https://datafromapi-2.aram-gulf.com/images/services_categories/cardiogram.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(13, 'الأنف والأذن والحنجرة', 'ENT (Ear, Nose, and Throat)', 'https://datafromapi-2.aram-gulf.com/images/services_categories/medicine.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(14, 'التغذية', 'Nutrition', 'https://datafromapi-2.aram-gulf.com/images/services_categories/medicine.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(15, 'الأشعة', 'Radiology', 'https://datafromapi-2.aram-gulf.com/images/services_categories/cardiogram.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(16, 'الجراحة', 'Surgery', 'https://datafromapi-2.aram-gulf.com/images/services_categories/medicine.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(17, 'الصيدلة', 'Pharmacy', 'https://datafromapi-2.aram-gulf.com/images/services_categories/drugs.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(18, 'إعادة التأهيل', 'Rehabilitation', 'https://datafromapi-2.aram-gulf.com/images/services_categories/cardiogram.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(19, 'طب الطوارئ', 'Emergency Medicine', 'https://datafromapi-2.aram-gulf.com/images/services_categories/hospital.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(20, 'طب الأسرة', 'Family Medicine', 'https://datafromapi-2.aram-gulf.com/images/services_categories/cardiogram.png', '2025-02-18 12:39:44', '2025-02-18 12:39:44'),
(21, 'السياحة', 'Tourism', 'https://datafromapi-2.aram-gulf.com/images/categories/map-3578213_1280_67ba299f81c89.jpg', '2025-02-22 19:46:39', '2025-02-22 19:46:39'),
(22, 'تعليم وتدريب', 'Learning', 'https://datafromapi-2.aram-gulf.com/images/categories/never-stop-learning-3653430_1280_67ba2dad8c3de.jpg', '2025-02-22 20:03:57', '2025-02-22 20:03:57'),
(23, 'التسوق', 'Shopping', 'https://datafromapi-2.aram-gulf.com/images/categories/shopping-venture-3154149_1280_67ba2eab1e05e.jpg', '2025-02-22 20:08:11', '2025-02-22 20:08:11'),
(24, 'الصحة والجمال', 'Health and beauty', 'https://datafromapi-2.aram-gulf.com/images/categories/yoga-2587066_1280_67ba2f8d921db.jpg', '2025-02-22 20:11:57', '2025-02-22 20:11:57'),
(25, 'وكالات', 'Agencies', 'https://datafromapi-2.aram-gulf.com/images/categories/tour_67ba306b05d16.png', '2025-02-22 20:15:39', '2025-02-22 20:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_1_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_2_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_3_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_1_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_2_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_3_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image`, `bg_color`, `text_1_ar`, `text_2_ar`, `text_3_ar`, `text_1_en`, `text_2_en`, `text_3_en`, `created_at`, `updated_at`) VALUES
(1, 'https://datafromapi-2.aram-gulf.com/images/slider/portrait-candid-male-doctor-removebg.png', NULL, 'العناية الشخصية والجمال', 'تهمنا', 'اكتشف أفضل العلاجات للعناية الشخصية، الاهتمام الطبي، وعمليات التجميل مع فريقنا المحترف.', 'Personal care and beauty', 'enhancement', 'Discover the best treatments for personal care, medical attention, and cosmetic surgeries with our professional team.', '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(2, 'https://datafromapi-2.aram-gulf.com/images/slider/portrait-candid-male-doctor-removebg.png', NULL, 'العلاجات الطبية', 'الشفاء', 'عيادتنا تقدم علاجات طبية متقدمة لجميع المشاكل الصحية.', 'Medical treatments', 'healing', 'Our clinic offers advanced medical treatments for all health concerns.', '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(3, 'https://datafromapi-2.aram-gulf.com/images/slider/portrait-candid-male-doctor-removebg.png', NULL, 'جراحة التجميل', 'الجمال', 'عزز مظهرك مع جراحينا التجميل المحترفين.', 'Cosmetic Surgery', 'beauty', 'Enhance your appearance with our experienced cosmetic surgeons.', '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(4, 'https://datafromapi-2.aram-gulf.com/images/slider/portrait-candid-male-doctor-removebg.png', NULL, 'علاجات العناية بالشعر', 'النمو', 'نمو وتجديد شعرك مع علاجاتنا المتخصصة.', 'Hair Care Treatments', 'growth', 'Regrow and rejuvenate your hair with our specialized treatments.', '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(5, 'https://datafromapi-2.aram-gulf.com/images/slider/file.png', NULL, 'برامج خسارة الوزن', 'اللياقة', 'كن لائقاً وتخلص من الوزن مع برامجنا المخصصة.', 'Weight Loss Programs', 'fitness', 'Get fit and lose weight with our personalized programs.', '2025-02-18 12:39:52', '2025-02-18 12:39:52'),
(6, 'https://datafromapi-2.aram-gulf.com/images/slider/file.png', NULL, 'حلول العناية بالبشرة', 'التوهج', 'تحقيق بشرة نقية ومتوهجة مع حلول العناية بالبشرة لدينا.', 'Skin Care Solutions', 'glowing', 'Achieve clear and glowing skin with our skin care solutions.', '2025-02-18 12:39:52', '2025-02-18 12:39:52');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `subscribed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_condition_organizations`
--

CREATE TABLE `terms_condition_organizations` (
  `id` bigint UNSIGNED NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_condition_organizations`
--

INSERT INTO `terms_condition_organizations` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2025-02-19 15:38:04', '2025-02-19 15:38:04'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2025-02-19 15:38:04', '2025-02-19 15:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `terms_condition_users`
--

CREATE TABLE `terms_condition_users` (
  `id` bigint UNSIGNED NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_condition_users`
--

INSERT INTO `terms_condition_users` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'ارام الخليج لا تشارك معلوماتك مع اي جهة الا لغرض خدمتك', '2025-02-19 15:36:04', '2025-02-21 10:14:54'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2025-02-19 15:36:04', '2025-02-19 15:36:04'),
(21, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(22, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(23, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(24, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(25, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(26, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(27, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(28, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(29, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(30, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(31, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(32, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(33, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(34, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(35, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(36, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(37, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(38, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(39, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2025-02-19 15:36:55', '2025-02-19 15:36:55'),
(40, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2025-02-19 15:36:55', '2025-02-19 15:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `social_id` text COLLATE utf8mb4_unicode_ci,
  `social_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_signed` tinyint(1) NOT NULL DEFAULT '0',
  `is_promoter` tinyint(1) NOT NULL DEFAULT '0',
  `user_gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `number_of_reservations` int NOT NULL DEFAULT '0',
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `user_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verification_token` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone_number`, `location`, `image`, `role`, `social_id`, `social_type`, `is_signed`, `is_promoter`, `user_gender`, `user_birthdate`, `number_of_reservations`, `account_type`, `user_code`, `verification_code`, `email_verification_token`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Carmela Willms', 'king.jennyfer@example.com', '12345678', '+1 (571) 413-6373', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'admin', NULL, NULL, 0, 0, 'male', '2018-09-03', 0, 'User', 'mE2t1CL8lP', NULL, NULL, NULL, NULL, '2024-11-26 14:12:58', NULL),
(2, 'Amber Hagenes', 'taya.heidenreich@example.org', '12345678', '(279) 491-9916', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'user', NULL, NULL, 0, 0, 'male', '1996-10-22', 0, 'User', 'ARnAHDgcTd', NULL, NULL, NULL, NULL, '2024-09-12 03:17:06', NULL),
(3, 'Miss Verda Deckow Sr.', 'vance37@example.com', '12345678', '434.667.4072', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'user', NULL, NULL, 0, 0, 'female', '2007-03-02', 0, 'User', 'Vp3BMZ3YQi', NULL, NULL, NULL, NULL, '2024-10-20 12:51:58', NULL),
(4, 'Dr. Idella Hodkiewicz', 'orobel@example.net', '12345678', '+15736730377', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'admin', NULL, NULL, 0, 0, 'female', '1977-11-15', 0, 'User', '2UjOGdVUaN', NULL, NULL, NULL, NULL, '2025-01-07 06:33:36', NULL),
(5, 'Mr. Dudley Adams', 'wisoky.karolann@example.net', '12345678', '+1-980-969-6193', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'admin', NULL, NULL, 0, 0, 'female', '1994-11-13', 0, 'User', 'fUDBEBgnj3', NULL, NULL, NULL, NULL, '2024-09-24 22:46:47', NULL),
(6, 'Margaret Howe', 'pollich.stephanie@example.com', '12345678', '+1-947-823-1921', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'user', NULL, NULL, 0, 0, 'male', '1974-08-31', 0, 'User', 'vEJg1YCG7I', NULL, NULL, NULL, NULL, '2024-08-21 08:09:36', NULL),
(7, 'Rosetta Quigley', 'witting.maximillia@example.org', '12345678', '(928) 927-3835', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'editor', NULL, NULL, 0, 0, 'male', '1998-09-07', 0, 'User', '4QaVB65Xeu', NULL, NULL, NULL, NULL, '2024-04-02 18:38:57', NULL),
(8, 'Prof. Kaylin Bruen DVM', 'lbosco@example.com', '12345678', '+1 (409) 977-9015', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'editor', NULL, NULL, 0, 0, 'male', '1990-08-16', 0, 'User', 'bodAxZyPx3', NULL, NULL, NULL, NULL, '2025-01-11 13:20:13', NULL),
(9, 'Aiden Schmidt', 'sammie.osinski@example.com', '12345678', '272-230-7658', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'admin', NULL, NULL, 0, 0, 'male', '1997-12-20', 0, 'User', 'HszJi0GaAL', NULL, NULL, NULL, NULL, '2024-12-07 10:20:36', NULL),
(10, 'Eudora Bogan', 'uhammes@example.com', '12345678', '+1 (503) 499-8437', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'user', NULL, NULL, 0, 0, 'male', '2015-03-15', 0, 'User', 'WjIeJ0pZxZ', NULL, NULL, NULL, NULL, '2024-04-06 22:59:36', NULL),
(11, 'Cornelius Huels', 'adonis55@example.net', '12345678', '223.987.9831', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'user', NULL, NULL, 0, 0, 'male', '1974-06-06', 0, 'User', 'mKVeW72Ohd', NULL, NULL, NULL, NULL, '2024-07-09 23:13:13', NULL),
(12, 'Narciso Langosh II', 'mcclure.yvette@example.com', '12345678', '+1.316.449.5380', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'admin', NULL, NULL, 0, 0, 'male', '2009-03-14', 0, 'User', 'guc7lSHFzL', NULL, NULL, NULL, NULL, '2024-02-20 22:58:17', NULL),
(13, 'Lorine Herman I', 'daron.okeefe@example.org', '12345678', '+1 (737) 931-2288', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'admin', NULL, NULL, 0, 0, 'female', '1979-12-05', 0, 'User', 'G28JwoLOIk', NULL, NULL, NULL, NULL, '2025-02-05 14:59:31', NULL),
(14, 'Dr. Mylene Price', 'candice09@example.com', '12345678', '1-915-484-9690', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'admin', NULL, NULL, 0, 0, 'female', '2008-03-21', 0, 'User', 'ffssZy3rBX', NULL, NULL, NULL, NULL, '2024-11-19 03:48:21', NULL),
(15, 'Fiona Muller', 'lesley36@example.org', '12345678', '(940) 975-8219', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'admin', NULL, NULL, 0, 0, 'male', '2002-12-10', 0, 'User', 'K08TiOd60N', NULL, NULL, NULL, NULL, '2024-08-24 22:22:48', NULL),
(16, 'Dr. Dario Heidenreich', 'sedrick47@example.net', '12345678', '762-438-4618', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'editor', NULL, NULL, 0, 0, 'male', '2007-06-22', 0, 'User', '4NLnTk7NoM', NULL, NULL, NULL, NULL, '2024-03-31 05:33:01', NULL),
(17, 'Talia Roberts', 'carmela58@example.org', '12345678', '+1-270-314-8117', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'admin', NULL, NULL, 0, 0, 'female', '2015-05-15', 0, 'User', 'G5hOD3IItG', NULL, NULL, NULL, NULL, '2024-03-25 18:18:06', NULL),
(18, 'Dr. Lorenzo Bosco', 'kristoffer.kuhic@example.net', '12345678', '(240) 859-8679', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'user', NULL, NULL, 0, 0, 'male', '1982-03-18', 0, 'User', 'hew2mUoQsR', NULL, NULL, NULL, NULL, '2024-03-10 10:13:50', NULL),
(19, 'Emerson Bernier', 'idella56@example.com', '12345678', '(386) 229-9593', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'editor', NULL, NULL, 0, 0, 'male', '1997-10-16', 0, 'User', 'i8bIqPzs4Q', NULL, NULL, NULL, NULL, '2024-08-06 00:49:05', NULL),
(20, 'Miss Jessyca Koepp', 'efrain52@example.net', '12345678', '1-520-937-7812', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082428.png', 'admin', NULL, NULL, 0, 0, 'female', '2024-12-03', 0, 'User', 'NNYssDQjZI', NULL, NULL, NULL, NULL, '2024-11-03 22:58:36', NULL),
(21, 'Florence Spencer', 'bertrand.lueilwitz@example.net', '12345678', '+19034523531', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'admin', NULL, NULL, 0, 0, 'female', '1979-10-07', 0, 'User', 'gp2y1uHusS', NULL, NULL, NULL, NULL, '2024-11-14 01:57:45', NULL),
(22, 'Amelia Shanahan', 'omari.bashirian@example.com', '12345678', '804.982.0933', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/avatar_male_676bac246bed6.png', 'editor', NULL, NULL, 0, 0, 'female', '1984-01-08', 0, 'User', 'mqxGbmGfo6', NULL, NULL, NULL, NULL, '2024-07-13 19:35:21', NULL),
(23, 'Mrs. Jailyn Reilly II', 'nolan.odell@example.org', '12345678', '616-713-7037', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, NULL, 0, 0, 'female', '1978-04-12', 0, 'User', 'wLLa9eShXM', NULL, NULL, NULL, NULL, '2024-02-20 21:14:47', NULL),
(24, 'Mr. Armani Crona III', 'mbrekke@example.org', '12345678', '1-463-791-8974', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'user', NULL, NULL, 0, 0, 'male', '1998-04-16', 0, 'User', 'R4Hi3m2L0X', NULL, NULL, NULL, NULL, '2024-05-03 04:13:50', NULL),
(25, 'Ms. Ana Kihn DDS', 'little.carmelo@example.net', '12345678', '830.705.9606', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'editor', NULL, NULL, 0, 0, 'male', '2021-02-09', 0, 'User', 'KqVV1lLCfS', NULL, NULL, NULL, NULL, '2024-07-18 16:40:25', NULL),
(26, 'Alvera Swift', 'eugene.casper@example.com', '12345678', '+1.417.623.6636', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'user', NULL, NULL, 0, 0, 'male', '1993-09-03', 0, 'User', 'ZLaDfgGJmZ', NULL, NULL, NULL, NULL, '2024-09-20 04:05:19', NULL),
(27, 'Desmond Dooley', 'lhoeger@example.org', '12345678', '+1.862.491.5102', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'admin', NULL, NULL, 0, 0, 'female', '2018-05-31', 0, 'User', 'h1IvhbtxEM', NULL, NULL, NULL, NULL, '2024-02-19 06:38:29', NULL),
(28, 'Dr. Madonna Swift', 'sporer.hester@example.com', '12345678', '+1 (341) 244-1839', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'admin', NULL, NULL, 0, 0, 'female', '2021-04-01', 0, 'User', '4A4lIpP5Qh', NULL, NULL, NULL, NULL, '2025-01-03 01:59:25', NULL),
(29, 'Yvonne Schaefer', 'ines18@example.net', '12345678', '318.288.2846', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082428.png', 'user', NULL, NULL, 0, 0, 'female', '1981-02-16', 0, 'User', 'jqU4cOQzeS', NULL, NULL, NULL, NULL, '2024-08-07 23:41:54', NULL),
(30, 'Dr. Jerrell Bartell', 'dtrantow@example.org', '12345678', '531.998.1445', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'user', NULL, NULL, 0, 0, 'male', '2002-01-20', 0, 'User', 'qj0ZNLkTtq', NULL, NULL, NULL, NULL, '2024-07-01 19:43:30', NULL),
(31, 'Lempi McCullough', 'gweber@example.net', '12345678', '+1 (785) 975-7902', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'editor', NULL, NULL, 0, 0, 'male', '1978-08-07', 0, 'User', '1Pj0CRgz4J', NULL, NULL, NULL, NULL, '2024-08-14 16:31:06', NULL),
(32, 'Dr. Caden Morar DDS', 'dwuckert@example.net', '12345678', '1-217-273-7488', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'editor', NULL, NULL, 0, 0, 'female', '2021-03-15', 0, 'User', 'zoebqRTcT6', NULL, NULL, NULL, NULL, '2024-03-31 23:58:17', NULL),
(33, 'Prof. Tre Yost', 'jessie.herman@example.net', '12345678', '+14349578889', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'admin', NULL, NULL, 0, 0, 'male', '2011-12-29', 0, 'User', '6qT5attywy', NULL, NULL, NULL, NULL, '2025-02-13 09:27:22', NULL),
(34, 'Ross Parisian', 'mgibson@example.net', '12345678', '+1-931-820-3231', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'editor', NULL, NULL, 0, 0, 'male', '1975-11-27', 0, 'User', 'KF13bwSWRC', NULL, NULL, NULL, NULL, '2024-07-08 15:36:44', NULL),
(35, 'Prof. Adolphus Feil', 'savanna23@example.com', '12345678', '1-661-712-3039', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'admin', NULL, NULL, 0, 0, 'male', '1976-04-23', 0, 'User', 'V3GeFsUqTN', NULL, NULL, NULL, NULL, '2025-01-12 04:04:32', NULL),
(36, 'Julien Friesen', 'connelly.amparo@example.com', '12345678', '1-978-813-9657', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082428.png', 'user', NULL, NULL, 0, 0, 'female', '1981-04-07', 0, 'User', 'meK5RpkQad', NULL, NULL, NULL, NULL, '2024-12-12 06:55:17', NULL),
(37, 'Mrs. Elva Grady I', 'erogahn@example.com', '12345678', '1-404-442-4534', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/avatar_male_676bac246bed6.png', 'user', NULL, NULL, 0, 0, 'male', '1993-06-01', 0, 'User', 'djEq2IzT0i', NULL, NULL, NULL, NULL, '2024-12-20 15:49:07', NULL),
(38, 'Ms. Daisha Willms IV', 'nhickle@example.com', '12345678', '(904) 578-1398', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082428.png', 'user', NULL, NULL, 0, 0, 'male', '1991-05-19', 0, 'User', 'apHE4Torxw', NULL, NULL, NULL, NULL, '2024-03-20 01:40:15', NULL),
(39, 'Verona Miller DDS', 'ubotsford@example.org', '12345678', '(909) 896-3084', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'editor', NULL, NULL, 0, 0, 'female', '2024-06-25', 0, 'User', 'BcrIqriAuf', NULL, NULL, NULL, NULL, '2024-09-25 21:02:21', NULL),
(40, 'Sage McLaughlin', 'koss.fleta@example.com', '12345678', '+1-541-258-8163', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'user', NULL, NULL, 0, 0, 'male', '2024-01-27', 0, 'User', 'M8YiSX0p9K', NULL, NULL, NULL, NULL, '2024-11-04 09:06:28', NULL),
(41, 'Marisa Legros', 'freeda29@example.net', '12345678', '805-869-5142', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, NULL, 0, 0, 'female', '2021-03-06', 0, 'User', 'xu5iJqtFIq', NULL, NULL, NULL, NULL, '2024-05-30 04:00:27', NULL),
(42, 'Yadira Leffler', 'erna15@example.net', '12345678', '(325) 635-5330', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'user', NULL, NULL, 0, 0, 'male', '1970-06-13', 0, 'User', 'I51QbQUzuK', NULL, NULL, NULL, NULL, '2025-01-02 07:30:36', NULL),
(43, 'Mr. Barney Reynolds DVM', 'dale.wisozk@example.org', '12345678', '585.261.1776', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67a4556b080db.jpg', 'editor', NULL, NULL, 0, 0, 'male', '1989-06-19', 0, 'User', 'oypVX7JL9R', NULL, NULL, NULL, NULL, '2024-11-24 01:47:18', NULL),
(44, 'Delphine Boyle IV', 'delaney.wyman@example.net', '12345678', '724.585.3950', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082428.png', 'user', NULL, NULL, 0, 0, 'male', '1972-06-08', 0, 'User', 'LSEczjiFZb', NULL, NULL, NULL, NULL, '2024-08-31 11:41:51', NULL),
(45, 'Gilberto Ondricka', 'konopelski.hassan@example.com', '12345678', '+1-772-284-5671', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1335179_67aafeb30662b.png', 'admin', NULL, NULL, 0, 0, 'male', '1995-10-26', 0, 'User', 'ORhsvcKUzU', NULL, NULL, NULL, NULL, '2024-06-12 18:55:07', NULL),
(46, 'Gabrielle Johns', 'ngreenholt@example.com', '12345678', '(424) 888-2814', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'editor', NULL, NULL, 0, 0, 'female', '1989-04-03', 0, 'User', '1Eh5v74iqI', NULL, NULL, NULL, NULL, '2024-07-10 20:08:56', NULL),
(47, 'Domenic Torphy', 'faye73@example.com', '12345678', '+1-330-753-8539', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/1345557_67aafb6cc2856.png', 'editor', NULL, NULL, 0, 0, 'male', '2021-07-20', 0, 'User', '937y5ycFhR', NULL, NULL, NULL, NULL, '2025-01-21 14:26:41', NULL),
(48, 'Sasha Durgan', 'megane.larson@example.com', '12345678', '(475) 678-0782', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'admin', NULL, NULL, 0, 0, 'male', '1971-02-15', 0, 'User', '7wlA2egRi2', NULL, NULL, NULL, NULL, '2024-11-19 21:05:52', NULL),
(49, 'Ashton Ledner', 'lkoepp@example.com', '12345678', '+1-347-346-7219', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/20241201082440.jpg', 'editor', NULL, NULL, 0, 0, 'female', '1977-12-14', 0, 'User', 'VPacjCDHaj', NULL, NULL, NULL, NULL, '2024-06-16 03:22:34', NULL),
(50, 'Cielo Schuster', 'ohara.brandy@example.com', '12345678', '1-830-678-2369', '{\"address\": \"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\", \"latitude\": 21.40281772305478, \"longitude\": 39.84603881835938}', 'https://datafromapi-2.aram-gulf.com/images/users/avatar_male_676bac246bed6.png', 'editor', NULL, NULL, 0, 0, 'female', '2006-04-23', 0, 'User', 'dZ4pTpwfrx', NULL, NULL, NULL, NULL, '2025-02-11 00:09:55', NULL),
(51, 'ahmed esmail', 'failloser1@gmail.com', '$2y$12$ZdXG3c.iHDVNnacdbD3Y5u2zUjCakiDxLxy9lliDDkuBv17pvtwHG', '0101753923', '{\"address\":\"1, شارع سالم الشرقاوى, كفر عنان, الغربية, 31641, مصر\",\"latitude\":30.70543001572216,\"longitude\":31.246737241745}', 'https://datafromapi-2.aram-gulf.com/images/users/4_67bc85d23adb3.jpg', 'Admin', '116126731443459458093', 'google', 0, 1, 'male', '2001-12-25', 1, 'User', 'HVnUfQtZfo', NULL, NULL, '2025-02-24 14:35:57', NULL, '2025-02-18 13:14:30', '2025-02-24 14:44:34'),
(52, 'Dr.Shawakh Alborsan', 'shawakhalborsan@gmail.com', '$2y$12$ChgmhxlvE3SS1jePQq8K2.zO/vIOWRWxTOYGymdLYpTf4XHHlA.Py', NULL, '{\n    \"address\": \"سكة 4213, مسقط, 600, عمان\",\n    \"latitude\": 23.594193731152217,\n    \"longitude\": 58.38583478208626\n}', NULL, 'Admin', '117586391952688662631', 'google', 0, 0, NULL, NULL, 0, 'User', NULL, NULL, NULL, NULL, NULL, '2025-02-19 09:36:54', '2025-02-19 21:22:40'),
(53, 'BOUTROS CHAAYA', 'productionmp@gmail.com', '$2y$12$j8STi.8t0aCNqwk3fPdb3OwcsA785mD/30cSDz/8ze4ptxW5CPT0C', '96383535', '{\"address\": \"مسقط, 133, عمان\", \"latitude\": 23.583179576288785, \"longitude\": 58.410588189736266}', 'https://datafromapi-2.aram-gulf.com/images/users/IMG_3473_67b732aed0913.jpeg', 'user', NULL, NULL, 0, 1, 'male', '1967-04-26', 0, 'User', '2Ppj44jOsW', NULL, NULL, NULL, NULL, '2025-02-19 18:59:09', '2025-02-20 14:20:01'),
(54, 'Shawakh Alborsan', 'shawakh@borsanacademy.com', '$2y$12$e5ie.23PzeImbD0ieSzESuaw1Tpafirp9BwtkcL3A3YO/kTTnHtzm', '0096895965879', '{\"address\": \"\"}', 'https://datafromapi-2.aram-gulf.com/images/users/IMG-20250218-WA0086_67b727d165f19.jpg', 'Admin', NULL, NULL, 0, 1, 'male', '1974-11-15', 0, 'User', 'C3SWmWj4Vp', NULL, NULL, NULL, NULL, '2025-02-19 21:21:11', '2025-02-20 13:02:09'),
(55, 'مهند شاهين', 'mouhanadchaheen@gmail.com', '$2y$12$T9yVB1Au3Jd8OrI2PnsiAuyvAv3MZQqSN7E403N/G1GEBEZxPiEVi', '71072970', '{\"address\":\"منظرية, مسقط, عمان\",\"latitude\":23.337881787643113,\"longitude\":58.55152825501346}', 'https://datafromapi-2.aram-gulf.com/images/users/IMG-20250202-WA0028_67bb03dc61f62.jpeg', 'user', NULL, NULL, 0, 1, 'male', '1981-06-01', 0, 'User', 'jH5ZMGqRhi', NULL, NULL, NULL, NULL, '2025-02-21 10:07:11', '2025-02-24 10:26:58'),
(56, 'yousuf alkatri', 'alkatriyousuf@gmail.com', '$2y$12$COwFSUVTBXlTT66u9IvYQuUGeW3z61nmnSRQ5LsHR7qluAgAHMPUK', '95225445', '{\"address\":\"عمان، الأردن\",\"latitude\":31.9539,\"longitude\":35.9106}', 'https://datafromapi-2.aram-gulf.com/images/users/IMG_9623_67baf9cd850a4.jpeg', 'user', '114562411057195539990', 'google', 0, 1, 'male', '1984-10-06', 0, 'User', NULL, NULL, NULL, NULL, NULL, '2025-02-23 10:06:24', '2025-02-24 10:26:21'),
(57, 'PATRICIA ANN SANTOS FLORES', 'Patriciaannflores17@gmail.com', '$2y$12$2jZX37n0JBc/r4NeVbI4WOdESlyG0YR0tqOppFB4vf/2JimrbwnqS', '+96891170564', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'female', '2000-12-17', 0, 'User', '8HJ3Tb9ruq', NULL, NULL, NULL, NULL, '2025-02-23 10:26:58', '2025-02-24 10:16:54'),
(58, 'Haifa Mohamed Sulaiman Al Bahlani', 'haifam876@gmail.com', '$2y$12$nDp0g6yLqyv2Xbs3mDVM8e9NWgNJOXedkdd8T3V0SX1tdPTjAdinG', '94384642', '{\"address\": \"43, شارع ضرار بن الأزور, جبل اللويبدة, منطقة المدينة, عمان, ناحية عمان, لواء قصبة عمان, عمان, 11110, الأردن\", \"latitude\": 31.95399916908455, \"longitude\": 35.924948612427826}', NULL, 'user', NULL, NULL, 0, 1, 'female', '1981-11-15', 0, 'User', '7PbodJ8T5x', NULL, NULL, NULL, NULL, '2025-02-23 10:28:57', '2025-02-23 11:28:07'),
(59, 'Vaeni Terency Fernando', 'johnnyteren@gmail.com', '$2y$12$EKgfIIbbSVR7HkKq4ArOgup2nfRD5wXXS864rbZpWToEru2KyFPm6', '+968360242', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'female', '2025-03-30', 0, 'User', 'VBU5NUHDbk', NULL, NULL, NULL, NULL, '2025-02-23 10:29:43', '2025-02-24 10:16:31'),
(60, 'Safa Ali Said Mansoor Altamimi', 'safaaltamimi99@gmail.com', '$2y$12$GvYN1oLMLgwB3szX0fmPbOJU90ZvPlz0EnsShQu/yNWWV7u8UC9bi', '79266023', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', 'https://lh3.googleusercontent.com/a/ACg8ocLIttisjYYWoBxdBfKXCi2BZURedbiXOqoRm99xXCzZ9LwlPw=s96-c', 'user', NULL, NULL, 0, 1, 'female', '1999-07-14', 0, 'User', 'xr9j6gcDPX', NULL, NULL, NULL, NULL, '2025-02-23 10:30:11', '2025-02-24 10:16:12'),
(61, 'Aluko Olatunji Sunday', 'sundayomoaluko@gmail.com', '$2y$12$bXsU0dQnuCddB630ScFnn.34GyDR7W9ji3B20CqkTmRUpRcTyxMUi', '+96878341979', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'male', '1976-07-18', 0, 'User', 'qkFSU3AZFS', NULL, NULL, NULL, NULL, '2025-02-23 10:31:56', '2025-02-24 10:16:00'),
(62, 'NASIMA MARZOUQ FAYIL AL BUSAIDI', 'naseema8080@gmail.com', '$2y$12$B1ptOb767DQVIcPw5eiEZ.Ss6tF2lLFnFhRW0lHIT5BJV5uY8hehe', '79753558', '{\"address\": \"موالح, مسقط, 000, عمان\", \"latitude\": 23.600513346614942, \"longitude\": 58.22902066618331}', NULL, 'user', NULL, NULL, 0, 1, 'female', '1975-01-08', 0, 'User', '9G8Bwe2G7A', NULL, NULL, NULL, NULL, '2025-02-23 10:32:04', '2025-02-23 12:07:02'),
(63, 'عبدالله خليفه عبدالله المر المحفوظي', 'abdollah97@icloud.com', '$2y$12$grXepguYnZOVIZTKTINHwOtZKQM0ChJJZ5IFxu0T986K4qSzYOsS2', '92012804', '{\"address\": \"عمان، الأردن\", \"latitude\": 31.9539, \"longitude\": 35.9106}', 'https://datafromapi-2.aram-gulf.com/images/users/IMG_3778_67bb054525244.jpeg', 'user', NULL, NULL, 0, 1, 'male', '1997-11-30', 0, 'User', 't2AL0W1pj8', NULL, NULL, NULL, NULL, '2025-02-23 10:32:33', '2025-02-23 11:29:41'),
(64, 'Nada Mohamed Abdullah Al Balushi', 'nnadaalbalushi@gmail.com', '$2y$12$unJYmmW5aTxJhF87udQTNOGIhB.kg3/iT.Rpzz3wQ1a4HeTnV9z9e', '92420880', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'female', '1996-03-01', 0, 'User', 'LjwiA0wj5j', NULL, NULL, NULL, NULL, '2025-02-23 10:35:57', '2025-02-24 10:15:20'),
(65, 'HANAN KHLIFA ABDULLAH ALGHAFRI', 'hanan95kh@icloud.com', '$2y$12$hu1Ot8ibO6.jeFRVbq1rguYrsFu3mdRp6ky6fHeCQqgKBjJd2L5Oi', '93535508', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'female', '1995-10-09', 0, 'User', 'vhnSinVKrj', NULL, NULL, NULL, NULL, '2025-02-23 10:37:15', '2025-02-24 10:15:00'),
(66, 'ADHARI ABDUL LATIF ABULLAH ALRAISI', 'athari.alraisi11@gmail.com', '$2y$12$oBZF9RyeZtmdZESIKtYGtOGx9DceNxaQJFWsvusvaCH4bYsUxH1yi', '94189401', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'female', '1990-11-11', 0, 'User', 'GT5XIKo7jW', NULL, NULL, NULL, NULL, '2025-02-23 10:42:32', '2025-02-24 10:14:46'),
(67, 'Sumia Hamid Mohamed Hamid', 'semsemhamid23@gmail.com', '$2y$12$tHzl04sDj5fqKm3.lC2ySOMOLb3kPaDYKohvQsHlOCZDuvjnSv4x6', '91300256', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'female', '1980-03-25', 0, 'User', 'JQqLvcL3K4', NULL, NULL, NULL, NULL, '2025-02-23 10:44:11', '2025-02-24 10:14:34'),
(69, 'adnan khemani', 'adnanpakqatar2016@gmail.com', '$2y$12$A.N339eQyKMvk2c6XhWluu3q7uAcVWC5En7R69d1iUk/TLk5PHGfS', '78654036', NULL, NULL, 'user', NULL, NULL, 0, 1, 'male', '1978-12-14', 0, 'User', 'S88FIuo8Dp', NULL, NULL, NULL, NULL, '2025-02-23 11:01:15', '2025-02-24 10:13:28'),
(70, 'JUBER AL RAWAHI', 'juber0201@gmail.com', '$2y$12$yN0zjcImhDOvJ/YPKzSMN.rQAZ1B3mDdQzIaGtZn6YkoOAYNUPFmS', '98191814', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'male', '1974-09-29', 0, 'User', 'dp2e0rIOzD', NULL, NULL, NULL, NULL, '2025-02-23 11:03:12', '2025-02-24 10:13:18'),
(71, 'Waed juma ali altarshi', 'jaberkhater90@gmail.com', '$2y$12$tl7j7UvlxYlSMJIA.YoVruzNc7WGGGu3zagzt/EoTrsQSL.U60ZY.', '93912469', '{\"address\":\"سكة 4213, مسقط, 600, عمان\",\"latitude\":23.594193731152217,\"longitude\":58.38583478208626}', NULL, 'user', NULL, NULL, 0, 1, 'female', '1998-04-12', 0, 'User', 'DS4e9er365', NULL, NULL, NULL, NULL, '2025-02-23 12:27:03', '2025-02-24 10:13:07'),
(72, 'amjad said alfarii', 'am1110jad@gmail.com', '$2y$12$zRKLr5WgB01MyYB1gWo3ieSctlE3QxMfqVXabuwNtD9jCLIHWqhlC', '97666787', '{\"latitude\":22.795347071520997,\"longitude\":58.1648146951015,\"address\":\"خضر, الداخلية, عمان\"}', NULL, 'user', NULL, NULL, 0, 1, 'male', '1982-06-01', 0, 'User', 'c8VaYBM1DZ', NULL, NULL, NULL, NULL, '2025-02-24 10:27:00', '2025-02-24 11:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_article_reactions`
--

CREATE TABLE `user_article_reactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `reaction_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_article_reactions`
--

INSERT INTO `user_article_reactions` (`id`, `user_id`, `article_id`, `reaction_type`, `created_at`, `updated_at`) VALUES
(4, 51, 5, 'laugh', '2025-02-18 13:25:57', '2025-02-18 13:25:57'),
(5, 51, 3, 'like', '2025-02-18 13:26:10', '2025-02-18 13:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `user_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 36, '164.63.40.171', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(2, 16, '84.104.251.144', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(3, 23, '236.217.87.237', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(4, 17, '87.139.148.144', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(5, 7, '104.91.178.97', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(6, 8, '227.66.24.142', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(7, 19, '62.122.112.232', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(8, 25, '108.48.58.151', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(9, 33, '12.44.50.44', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(10, 48, '176.233.212.243', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(11, 18, '221.109.128.93', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(12, 4, '243.212.210.73', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(13, 3, '137.140.191.238', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(14, 45, '98.73.68.113', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(15, 1, '126.130.138.93', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(16, 5, '73.102.28.178', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(17, 24, '81.26.42.135', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(18, 49, '24.177.57.117', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(19, 40, '12.89.92.234', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(20, 3, '53.15.233.230', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(21, 45, '62.82.79.180', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(22, 21, '104.206.169.93', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(23, 34, '206.11.98.149', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(24, 21, '137.247.187.49', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(25, 32, '206.80.50.160', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(26, 17, '152.191.207.150', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(27, 42, '13.250.61.142', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(28, 21, '84.34.84.221', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(29, 43, '62.94.136.136', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(30, 21, '218.5.161.155', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(31, 25, '11.222.56.203', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(32, 39, '6.50.139.201', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(33, 23, '183.162.131.70', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(34, 26, '153.46.24.206', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(35, 10, '253.76.237.43', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(36, 44, '246.52.176.88', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(37, 20, '204.97.244.96', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(38, 43, '72.46.20.176', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(39, 19, '238.87.206.252', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(40, 10, '34.48.48.52', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(41, 28, '56.8.1.222', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(42, 7, '195.244.115.188', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(43, 43, '231.249.126.21', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(44, 30, '62.88.230.74', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(45, 18, '185.43.81.228', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(46, 18, '223.232.69.196', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(47, 1, '26.36.94.127', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(48, 32, '91.229.177.133', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(49, 23, '47.41.196.89', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(50, 5, '28.164.195.12', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(51, 8, '224.31.68.109', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(52, 34, '147.77.152.2', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(53, 5, '187.253.159.14', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(54, 20, '164.54.245.52', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(55, 47, '192.38.4.151', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(56, 45, '73.37.193.177', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(57, 47, '250.66.207.231', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(58, 47, '149.217.126.124', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(59, 48, '238.46.239.17', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(60, 37, '82.46.66.214', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(61, 45, '36.139.119.124', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(62, 44, '53.255.111.147', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(63, 33, '167.218.113.159', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(64, 25, '135.21.207.233', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(65, 48, '130.207.0.84', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(66, 11, '251.9.48.68', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(67, 12, '95.62.152.236', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(68, 30, '200.58.15.187', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(69, 39, '67.160.118.243', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(70, 13, '66.173.209.33', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(71, 37, '201.131.145.219', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(72, 36, '159.114.134.184', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(73, 2, '74.138.42.127', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(74, 40, '88.64.222.50', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(75, 23, '156.31.116.25', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(76, 43, '233.46.117.91', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(77, 18, '87.156.202.40', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(78, 4, '50.101.124.41', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(79, 45, '194.153.219.96', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(80, 24, '66.111.188.73', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(81, 5, '135.79.203.213', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(82, 5, '119.176.178.21', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(83, 35, '85.186.197.32', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(84, 11, '95.87.106.148', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(85, 8, '68.23.222.179', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(86, 45, '149.35.22.227', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(87, 33, '191.131.109.249', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(88, 7, '214.45.19.78', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(89, 3, '222.167.92.97', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(90, 4, '10.10.38.214', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(91, 36, '90.127.101.62', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(92, 32, '88.51.43.75', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(93, 25, '209.33.62.13', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(94, 4, '35.103.156.107', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(95, 12, '126.201.219.176', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(96, 24, '231.237.176.4', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(97, 10, '12.34.172.183', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(98, 11, '252.71.83.40', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(99, 33, '135.166.233.215', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(100, 27, '125.156.20.248', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(101, 22, '44.80.104.57', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(102, 4, '203.240.143.129', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(103, 7, '137.149.150.19', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(104, 22, '100.196.33.90', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(105, 22, '125.0.233.31', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(106, 17, '199.0.165.211', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(107, 1, '27.172.187.53', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(108, 50, '73.132.103.5', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(109, 35, '6.125.109.91', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(110, 20, '79.174.42.114', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(111, 12, '232.31.21.137', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(112, 13, '119.229.27.232', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(113, 21, '157.101.185.24', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(114, 11, '244.209.48.133', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(115, 48, '119.155.121.43', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(116, 39, '26.73.85.20', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(117, 50, '203.90.96.18', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(118, 25, '219.109.160.127', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(119, 22, '154.143.179.135', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(120, 15, '61.250.87.33', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(121, 36, '139.157.248.219', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(122, 38, '71.125.141.248', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(123, 15, '166.58.117.139', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(124, 38, '219.116.181.129', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(125, 26, '74.243.177.227', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(126, 8, '206.244.3.17', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(127, 35, '51.186.196.73', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(128, 44, '61.221.157.8', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(129, 36, '43.127.34.55', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(130, 15, '233.238.63.109', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(131, 37, '107.71.103.8', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(132, 29, '78.245.251.9', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(133, 40, '34.121.98.71', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(134, 14, '169.166.238.246', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(135, 38, '49.251.14.238', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(136, 28, '209.19.10.100', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(137, 5, '223.27.25.136', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(138, 4, '208.239.235.71', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(139, 10, '52.132.143.63', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(140, 41, '163.135.96.126', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(141, 7, '213.9.125.109', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(142, 37, '187.22.173.170', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(143, 8, '235.146.27.222', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(144, 33, '246.36.7.218', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(145, 5, '198.35.252.115', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(146, 16, '80.21.176.153', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(147, 36, '126.127.88.82', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(148, 40, '248.209.191.87', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(149, 30, '248.28.255.153', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(150, 21, '32.231.4.86', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(151, 35, '157.72.148.68', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(152, 41, '61.200.13.13', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(153, 6, '53.145.79.64', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(154, 17, '84.139.116.57', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(155, 14, '37.201.151.52', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(156, 22, '140.12.253.45', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(157, 4, '130.252.33.178', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(158, 28, '253.206.228.255', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(159, 34, '19.33.180.220', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(160, 39, '26.176.152.239', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(161, 25, '133.93.20.169', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(162, 41, '56.112.107.112', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(163, 43, '115.238.100.146', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(164, 21, '68.221.73.109', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(165, 11, '124.117.163.81', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(166, 27, '65.250.33.235', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(167, 13, '38.43.69.207', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(168, 3, '125.222.5.82', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(169, 7, '84.95.247.205', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(170, 21, '61.111.65.83', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(171, 32, '116.152.70.208', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(172, 22, '49.55.117.31', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(173, 14, '212.224.2.102', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(174, 15, '128.191.239.84', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(175, 38, '111.165.149.253', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(176, 5, '210.124.242.170', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(177, 34, '104.64.238.49', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(178, 32, '96.58.60.185', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(179, 47, '62.245.4.95', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(180, 10, '161.168.6.48', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(181, 45, '202.0.136.70', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(182, 36, '37.199.46.11', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(183, 6, '96.77.195.161', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(184, 11, '96.178.205.101', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(185, 9, '73.21.13.248', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(186, 25, '144.84.135.199', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(187, 16, '184.161.23.135', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(188, 11, '152.110.120.253', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(189, 47, '242.227.189.151', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(190, 2, '40.242.92.21', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(191, 15, '57.7.98.97', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(192, 48, '26.133.2.43', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(193, 47, '80.176.2.94', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(194, 42, '102.138.227.2', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(195, 3, '248.61.249.70', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(196, 13, '208.3.144.157', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(197, 41, '232.39.80.92', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(198, 38, '20.183.222.220', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(199, 39, '62.161.134.122', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(200, 11, '160.118.124.31', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(201, 45, '85.203.57.108', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(202, 18, '178.253.73.120', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(203, 19, '75.225.90.236', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(204, 8, '109.157.164.32', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(205, 2, '1.3.218.254', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(206, 22, '1.247.208.19', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(207, 15, '29.75.202.118', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(208, 7, '52.7.74.159', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(209, 27, '37.54.210.157', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(210, 30, '26.35.214.24', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(211, 22, '60.160.56.189', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(212, 34, '34.45.209.215', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(213, 26, '129.88.78.225', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(214, 30, '35.40.210.109', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(215, 26, '92.79.2.10', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(216, 38, '203.91.203.223', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(217, 45, '89.208.160.29', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(218, 25, '30.7.39.172', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(219, 10, '153.244.94.183', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(220, 4, '191.65.17.120', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(221, 26, '40.216.189.212', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(222, 44, '57.81.117.59', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(223, 24, '253.6.227.153', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(224, 46, '183.120.91.79', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(225, 48, '106.149.113.125', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(226, 23, '82.176.206.164', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(227, 41, '18.63.114.253', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(228, 11, '110.31.244.41', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(229, 33, '119.149.153.183', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(230, 47, '249.169.207.96', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(231, 43, '56.132.181.4', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(232, 41, '23.70.184.145', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(233, 29, '56.81.144.76', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(234, 25, '63.175.160.69', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(235, 50, '46.173.101.104', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(236, 37, '184.152.71.131', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(237, 41, '116.230.44.98', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(238, 31, '95.198.111.3', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(239, 9, '145.239.191.10', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(240, 38, '158.247.83.179', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(241, 39, '113.123.140.222', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(242, 15, '53.254.101.78', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(243, 35, '224.30.155.251', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(244, 7, '148.222.32.98', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(245, 42, '157.81.64.50', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(246, 42, '123.64.115.92', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(247, 19, '46.149.238.32', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(248, 8, '111.118.53.5', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(249, 45, '128.181.27.55', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(250, 27, '157.5.228.48', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(251, 44, '231.95.150.112', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(252, 31, '128.7.243.158', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(253, 14, '98.113.190.203', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(254, 25, '35.235.44.196', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(255, 39, '6.238.45.63', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(256, 11, '211.167.211.201', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(257, 12, '136.146.108.190', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(258, 35, '150.203.40.239', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(259, 50, '228.66.143.15', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(260, 16, '203.125.164.167', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(261, 50, '150.91.138.203', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(262, 9, '69.8.32.207', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(263, 34, '48.112.246.25', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(264, 43, '48.27.133.43', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(265, 47, '125.130.108.77', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(266, 26, '50.34.206.4', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(267, 21, '227.5.14.67', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(268, 18, '3.11.179.218', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(269, 4, '187.240.251.73', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(270, 26, '119.56.137.26', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(271, 6, '250.60.230.14', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(272, 44, '2.14.87.22', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(273, 8, '165.38.122.143', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(274, 8, '244.11.74.145', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(275, 34, '229.137.43.63', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(276, 12, '251.220.238.147', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(277, 9, '139.40.212.130', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(278, 50, '87.235.134.162', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(279, 28, '163.38.155.204', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(280, 18, '92.69.161.180', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(281, 29, '23.158.96.108', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(282, 39, '117.227.39.150', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(283, 23, '215.56.98.66', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(284, 9, '65.80.182.51', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(285, 37, '183.185.70.190', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(286, 13, '245.84.55.188', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(287, 23, '155.127.216.113', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(288, 6, '137.11.12.26', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(289, 28, '6.7.78.48', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(290, 18, '221.216.38.150', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(291, 43, '73.245.46.93', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(292, 20, '128.39.39.138', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(293, 29, '50.183.5.224', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(294, 21, '97.189.65.96', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(295, 7, '89.139.5.41', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(296, 41, '190.18.212.186', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(297, 8, '212.76.145.13', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(298, 25, '57.226.60.52', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(299, 6, '74.110.5.93', '2025-02-18 12:39:53', '2025-02-18 12:39:53'),
(300, 12, '239.27.195.89', '2025-02-18 12:39:53', '2025-02-18 12:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawalrequests`
--

CREATE TABLE `withdrawalrequests` (
  `id` bigint UNSIGNED NOT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliate_card_types`
--
ALTER TABLE `affiliate_card_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_card_types_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `affiliate_services`
--
ALTER TABLE `affiliate_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_services_organization_id_foreign` (`organization_id`),
  ADD KEY `affiliate_services_category_id_foreign` (`category_id`);

--
-- Indexes for table `arma__cards`
--
ALTER TABLE `arma__cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `arma__cards_card_number_unique` (`card_number`),
  ADD KEY `arma__cards_user_id_foreign` (`user_id`),
  ADD KEY `arma__cards_cardtype_id_foreign` (`cardtype_id`);

--
-- Indexes for table `artical_categories`
--
ALTER TABLE `artical_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_reactions_count`
--
ALTER TABLE `article_reactions_count`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_reactions_count_article_id_foreign` (`article_id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balances_user_id_index` (`user_id`),
  ADD KEY `balances_organization_id_index` (`organization_id`);

--
-- Indexes for table `bells`
--
ALTER TABLE `bells`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bells_user_id_foreign` (`user_id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_block_relation` (`blocker_id`,`blocker_type`,`blocked_id`,`blocked_type`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_author_id_foreign` (`author_id`),
  ADD KEY `blogs_category_id_foreign` (`category_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_user_id_foreign` (`user_id`),
  ADD KEY `books_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `card_types`
--
ALTER TABLE `card_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_types_category_id_foreign` (`category_id`);

--
-- Indexes for table `card_type_categories`
--
ALTER TABLE `card_type_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card_visits`
--
ALTER TABLE `card_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_visits_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_article_id_foreign` (`article_id`);

--
-- Indexes for table `company_detailes`
--
ALTER TABLE `company_detailes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `copones`
--
ALTER TABLE `copones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `copones_code_unique` (`code`),
  ADD KEY `copones_organization_id_foreign` (`organization_id`),
  ADD KEY `copones_category_id_foreign` (`category_id`);

--
-- Indexes for table `coupon_user`
--
ALTER TABLE `coupon_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_user_user_id_foreign` (`user_id`),
  ADD KEY `coupon_user_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_transactions`
--
ALTER TABLE `financial_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_transactions_user_id_foreign` (`user_id`),
  ADD KEY `financial_transactions_bell_id_foreign` (`bell_id`),
  ADD KEY `financial_transactions_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `footers`
--
ALTER TABLE `footers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mainpages`
--
ALTER TABLE `mainpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_email_unique` (`email`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_conversation_id_foreign` (`conversation_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `offers_code_unique` (`code`),
  ADD KEY `offers_organization_id_foreign` (`organization_id`),
  ADD KEY `offers_category_id_foreign` (`category_id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_reviews`
--
ALTER TABLE `organization_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_reviews_user_id_foreign` (`user_id`),
  ADD KEY `organization_reviews_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participants_conversation_id_foreign` (`conversation_id`),
  ADD KEY `participants_participant_type_participant_id_index` (`participant_type`,`participant_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `point_cooperations`
--
ALTER TABLE `point_cooperations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacy_policy_organizations`
--
ALTER TABLE `privacy_policy_organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacy_policy_users`
--
ALTER TABLE `privacy_policy_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promoter_new_users`
--
ALTER TABLE `promoter_new_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promoter_new_users_promoter_id_foreign` (`promoter_id`);

--
-- Indexes for table `promotional_cards`
--
ALTER TABLE `promotional_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotional_cards_card_id_foreign` (`card_id`),
  ADD KEY `promotional_cards_bell_id_foreign` (`bell_id`);

--
-- Indexes for table `provisional_data`
--
ALTER TABLE `provisional_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_user_id_foreign` (`user_id`),
  ADD KEY `purchases_bell_id_foreign` (`bell_id`);

--
-- Indexes for table `question_answers`
--
ALTER TABLE `question_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_answers_user_id_foreign` (`user_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_likes_checks`
--
ALTER TABLE `review_likes_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_likes_checks_user_id_foreign` (`user_id`),
  ADD KEY `review_likes_checks_review_id_foreign` (`review_id`),
  ADD KEY `review_likes_checks_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `terms_condition_organizations`
--
ALTER TABLE `terms_condition_organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_condition_users`
--
ALTER TABLE `terms_condition_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_user_code_unique` (`user_code`);

--
-- Indexes for table `user_article_reactions`
--
ALTER TABLE `user_article_reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_article_reactions_user_id_article_id_unique` (`user_id`,`article_id`),
  ADD KEY `user_article_reactions_article_id_foreign` (`article_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visits_user_id_foreign` (`user_id`);

--
-- Indexes for table `withdrawalrequests`
--
ALTER TABLE `withdrawalrequests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawalrequests_account_type_account_id_index` (`account_type`,`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_card_types`
--
ALTER TABLE `affiliate_card_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_services`
--
ALTER TABLE `affiliate_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `arma__cards`
--
ALTER TABLE `arma__cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `artical_categories`
--
ALTER TABLE `artical_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `article_reactions_count`
--
ALTER TABLE `article_reactions_count`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bells`
--
ALTER TABLE `bells`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `card_types`
--
ALTER TABLE `card_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `card_type_categories`
--
ALTER TABLE `card_type_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `card_visits`
--
ALTER TABLE `card_visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `company_detailes`
--
ALTER TABLE `company_detailes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `copones`
--
ALTER TABLE `copones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `coupon_user`
--
ALTER TABLE `coupon_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_transactions`
--
ALTER TABLE `financial_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `footers`
--
ALTER TABLE `footers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mainpages`
--
ALTER TABLE `mainpages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `organization_reviews`
--
ALTER TABLE `organization_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `point_cooperations`
--
ALTER TABLE `point_cooperations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `privacy_policy_organizations`
--
ALTER TABLE `privacy_policy_organizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `privacy_policy_users`
--
ALTER TABLE `privacy_policy_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `promoter_new_users`
--
ALTER TABLE `promoter_new_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotional_cards`
--
ALTER TABLE `promotional_cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `provisional_data`
--
ALTER TABLE `provisional_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `question_answers`
--
ALTER TABLE `question_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_likes_checks`
--
ALTER TABLE `review_likes_checks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms_condition_organizations`
--
ALTER TABLE `terms_condition_organizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `terms_condition_users`
--
ALTER TABLE `terms_condition_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `user_article_reactions`
--
ALTER TABLE `user_article_reactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `withdrawalrequests`
--
ALTER TABLE `withdrawalrequests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affiliate_card_types`
--
ALTER TABLE `affiliate_card_types`
  ADD CONSTRAINT `affiliate_card_types_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `affiliate_services`
--
ALTER TABLE `affiliate_services`
  ADD CONSTRAINT `affiliate_services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `affiliate_services_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `arma__cards`
--
ALTER TABLE `arma__cards`
  ADD CONSTRAINT `arma__cards_cardtype_id_foreign` FOREIGN KEY (`cardtype_id`) REFERENCES `card_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arma__cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_reactions_count`
--
ALTER TABLE `article_reactions_count`
  ADD CONSTRAINT `article_reactions_count_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bells`
--
ALTER TABLE `bells`
  ADD CONSTRAINT `bells_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blogs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `artical_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_types`
--
ALTER TABLE `card_types`
  ADD CONSTRAINT `card_types_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `card_type_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_visits`
--
ALTER TABLE `card_visits`
  ADD CONSTRAINT `card_visits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `copones`
--
ALTER TABLE `copones`
  ADD CONSTRAINT `copones_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `copones_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_user`
--
ALTER TABLE `coupon_user`
  ADD CONSTRAINT `coupon_user_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `copones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `financial_transactions`
--
ALTER TABLE `financial_transactions`
  ADD CONSTRAINT `financial_transactions_bell_id_foreign` FOREIGN KEY (`bell_id`) REFERENCES `bells` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `financial_transactions_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `financial_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organization_reviews`
--
ALTER TABLE `organization_reviews`
  ADD CONSTRAINT `organization_reviews_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organization_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promoter_new_users`
--
ALTER TABLE `promoter_new_users`
  ADD CONSTRAINT `promoter_new_users_promoter_id_foreign` FOREIGN KEY (`promoter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotional_cards`
--
ALTER TABLE `promotional_cards`
  ADD CONSTRAINT `promotional_cards_bell_id_foreign` FOREIGN KEY (`bell_id`) REFERENCES `bells` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotional_cards_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `card_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_bell_id_foreign` FOREIGN KEY (`bell_id`) REFERENCES `bells` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_answers`
--
ALTER TABLE `question_answers`
  ADD CONSTRAINT `question_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_likes_checks`
--
ALTER TABLE `review_likes_checks`
  ADD CONSTRAINT `review_likes_checks_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_likes_checks_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `organization_reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_likes_checks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_article_reactions`
--
ALTER TABLE `user_article_reactions`
  ADD CONSTRAINT `user_article_reactions_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_article_reactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
