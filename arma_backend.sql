-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 06:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arma_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_services`
--

CREATE TABLE `affiliate_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `features_en` text DEFAULT NULL,
  `features_ar` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `check_status` enum('done','waiting','updated') DEFAULT 'waiting',
  `confirmation_status` tinyint(1) NOT NULL DEFAULT 0,
  `confirmation_price` decimal(8,2) DEFAULT NULL,
  `number_of_orders` int(11) NOT NULL DEFAULT 0,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `affiliate_services`
--

INSERT INTO `affiliate_services` (`id`, `title_ar`, `title_en`, `description_en`, `description_ar`, `features_en`, `features_ar`, `image`, `icon`, `status`, `check_status`, `confirmation_status`, `confirmation_price`, `number_of_orders`, `organization_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'خدمة cupiditate', 'Service est', 'Magni laborum sed inventore laborum id in. Sit nesciunt autem illo reiciendis rerum iusto consequatur. Veniam quam nesciunt delectus sit. Quia et nemo omnis facere.', 'Aut quas aut ut id saepe laboriosam maiores. Rerum asperiores quam fugit commodi odio dignissimos similique. Vero dolores voluptas quisquam debitis.', '[\"error\",\"pariatur\",\"suscipit\"]', '[\"non\",\"minus\",\"ab\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/0099bb?text=icons+eum', 0, 'done', 0, 73.50, 35, 20, 15, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(2, 'خدمة nostrum', 'Service quo', 'Est dolore sint quo sapiente nam sint. Harum culpa incidunt voluptates. Pariatur est deserunt est necessitatibus autem. Facilis quidem necessitatibus ut architecto.', 'Et quia ut dolorem non aut nobis nihil. Repudiandae impedit cupiditate qui asperiores rerum. Et sit odit dolorem ut voluptate quia. Dolore deleniti culpa et neque.', '\"[\\\"enim\\\",\\\"veritatis\\\",\\\"asdasdasdas\\\"]\"', '\"[\\\"aliquid\\\",\\\"dolore\\\",\\\"asdasdasd\\\"]\"', 'http://127.0.0.1:8000/images/affiliateServices/service_3_6794023ebde4d.jpg', 'https://via.placeholder.com/64x64.png/002266?text=icons+ad', 0, 'waiting', 0, 40.00, 23, 20, 2, '2025-01-21 03:04:52', '2025-01-24 19:51:38'),
(3, 'خدمة facere', 'Service vitae', 'Ut qui temporibus voluptatem ut molestiae possimus. Sed amet dolor doloremque nemo atque. Ipsa aut voluptas nemo a ipsam soluta aliquam.', 'Error quia reiciendis dicta facilis suscipit sed doloribus. Culpa blanditiis ea laboriosam. Iusto culpa optio hic architecto iusto reiciendis et.', '[\"doloribus\",\"aut\",\"magni\"]', '[\"rerum\",\"nulla\",\"ex\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/004411?text=icons+ut', 1, 'waiting', 1, 13.15, 5, 20, 4, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(4, 'خدمة distinctio', 'Service voluptas', 'Voluptatem qui eum dolore nisi fugit voluptatem et. Fugiat et tempore dolor quia. Voluptates rerum ex sed sunt. Necessitatibus molestiae cumque id aut quisquam.', 'Qui excepturi voluptatem laudantium explicabo est labore accusamus dolor. Itaque velit laudantium laudantium sunt fuga. Laudantium qui molestiae a voluptas quam nemo excepturi.', '\"[\\\"fuga\\\",\\\"nulla\\\"]\"', '\"[\\\"sed\\\",\\\"est\\\",\\\"consectetur\\\"]\"', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/001155?text=icons+quia', 0, 'waiting', 1, 84.96, 63, 20, 4, '2025-01-21 03:04:52', '2025-01-24 19:59:35'),
(5, 'خدمة sint', 'Service dignissimos', 'Magnam quaerat asperiores consequatur sint enim a non. Perspiciatis voluptatem id iste quidem esse perferendis consequuntur.', 'Perferendis suscipit aut deserunt consequuntur et a voluptatum. Qui error corporis aut. Aspernatur sapiente ut quam maiores ut. Sed corrupti sunt doloremque quis velit et temporibus.', '[\"repellat\",\"unde\",\"quo\"]', '[\"explicabo\",\"et\",\"nobis\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/0011bb?text=icons+tenetur', 1, 'updated', 1, 94.00, 8, 20, 18, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(6, 'خدمة voluptatem', 'Service earum', 'Dolor magnam debitis accusantium nam rerum repellendus. Aliquid voluptatem temporibus numquam veritatis autem corporis dolorem. Et tenetur sed labore aspernatur rerum. Saepe recusandae voluptates nostrum iusto atque totam voluptas.', 'Neque harum iure id fugit distinctio ducimus. Quis ullam rerum quia itaque corrupti omnis hic. Ex quam ipsam quam voluptatem fuga distinctio. Velit eligendi quidem minus ut id optio non.', '[\"facere\",\"occaecati\",\"in\"]', '[\"quod\",\"placeat\",\"enim\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/00ff11?text=icons+est', 1, 'waiting', 1, 27.68, 55, 20, 4, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(7, 'خدمة a', 'Service nobis', 'Harum autem quaerat est. Harum est a minus odio debitis atque.', 'Dignissimos distinctio velit quia sed sit. Quis sint sunt omnis quidem. Enim sit vel mollitia natus impedit.', '[\"aut\",\"commodi\",\"et\"]', '[\"non\",\"perferendis\",\"est\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-02.jpg', 'https://via.placeholder.com/64x64.png/009966?text=icons+debitis', 1, 'waiting', 0, 77.50, 84, 20, 7, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(8, 'خدمة aut', 'Service quam', 'Maiores cumque libero eius dolores eum. Doloribus cumque in atque pariatur a quia architecto. Tempora consectetur cupiditate ab vel repellendus voluptatum error maxime. Voluptatum eum enim quisquam esse aperiam. Magni sint aut non suscipit.', 'Eveniet id maiores quia in doloribus sequi. Similique nam deserunt et amet ea. Quia aliquid aspernatur voluptas. Ad provident eligendi minus pariatur consequatur culpa rerum cupiditate. Sequi corporis eos numquam non facilis quaerat.', '[\"sed\",\"expedita\",\"fuga\"]', '[\"nam\",\"incidunt\",\"ut\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/0000bb?text=icons+at', 1, 'waiting', 0, 42.61, 64, 20, 9, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(9, 'خدمة placeat', 'Service eligendi', 'Perspiciatis nam amet dolorem voluptatem repellendus cupiditate dignissimos. Et autem velit dolores. Et laudantium hic eveniet consectetur et.', 'Numquam sint non nihil culpa et. Quia quia quasi temporibus non suscipit consequatur id nemo. Alias aliquid ratione exercitationem illo sunt. Sit magnam non iure.', '[\"odit\",\"corporis\",\"esse\"]', '[\"unde\",\"blanditiis\",\"corporis\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/0000ee?text=icons+porro', 1, 'updated', 1, 78.20, 13, 16, 11, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(10, 'خدمة unde', 'Service consequatur', 'Nobis ratione id voluptate neque natus. Ipsa atque facilis modi rerum. Quae a incidunt nam qui natus cumque. Consequatur sapiente est eveniet maiores quod porro. Eligendi nihil eos corporis ut porro.', 'Velit odit praesentium provident dolores. Nobis nesciunt unde sed inventore aut placeat nulla in. Quia impedit aliquam molestiae laboriosam. Error quaerat voluptate aspernatur dolorem impedit. Est et laborum provident consequatur fuga cupiditate.', '[\"reprehenderit\",\"voluptatem\",\"incidunt\"]', '[\"non\",\"architecto\",\"sunt\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/007733?text=icons+esse', 1, 'waiting', 1, 69.89, 23, 2, 18, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(11, 'خدمة quo', 'Service aperiam', 'Minima consequuntur voluptatem totam sunt nam fuga. Dolor quas sunt eaque quia veniam omnis sed voluptatem. Et in enim aut.', 'Veritatis fugiat eos unde deserunt. Ut officia quibusdam est adipisci voluptatum est minima. Rerum voluptatem ab perferendis placeat exercitationem asperiores tempore quia.', '[\"et\",\"ea\",\"maiores\"]', '[\"occaecati\",\"reiciendis\",\"voluptate\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-02.jpg', 'https://via.placeholder.com/64x64.png/00bb11?text=icons+suscipit', 0, 'waiting', 1, 56.33, 72, 6, 12, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(12, 'خدمة recusandae', 'Service sint', 'Cumque aut natus dolore. Praesentium doloremque et animi quas consectetur et odit voluptas. Doloremque eos fugit consequatur ut commodi et repellendus.', 'Minus id ut ea quia omnis sunt. Enim aut aliquid odit ut dolorem. Iure labore nobis aspernatur veniam dignissimos. Laborum itaque nemo dolores necessitatibus autem excepturi.', '[\"totam\",\"deleniti\",\"et\"]', '[\"minima\",\"quo\",\"nisi\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/00bb88?text=icons+rem', 0, 'waiting', 1, 63.73, 13, 4, 4, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(13, 'خدمة natus', 'Service est', 'Tempore atque voluptatem ut. Et quidem sunt qui voluptatem sint. Nobis illum inventore cum corrupti velit maxime quia.', 'Voluptatum quia nesciunt modi nisi. Possimus laboriosam assumenda culpa similique. Repellendus dolores sit sint quibusdam quia iusto consectetur.', '[\"esse\",\"maxime\",\"facilis\"]', '[\"enim\",\"ipsam\",\"quis\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/004455?text=icons+excepturi', 1, 'waiting', 1, 29.38, 73, 12, 12, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(14, 'خدمة sunt', 'Service ut', 'Optio quasi et qui velit. Deserunt dolorem vel dolores impedit et earum. Laborum accusantium asperiores soluta. Occaecati corporis magni non laboriosam et. Iste debitis a perferendis et.', 'Saepe rerum officiis non vitae. Recusandae a tenetur iusto est necessitatibus error veniam. Vitae accusamus corrupti totam a quam maiores. Velit vel beatae tempore perferendis. Aut et dolorum ut sit quos saepe eligendi.', '[\"hic\",\"reprehenderit\",\"quia\"]', '[\"cumque\",\"quisquam\",\"voluptas\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/002211?text=icons+consequatur', 1, 'waiting', 1, 28.25, 82, 18, 12, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(15, 'خدمة eum', 'Service aperiam', 'Pariatur dolorum dolores nihil fugit perferendis ut at vel. Eaque et nemo necessitatibus corporis nobis ut. Tenetur nisi qui consequatur aut voluptas non laboriosam nam.', 'Necessitatibus qui sint error expedita repellendus distinctio. Ab enim est expedita expedita enim quia minima minima. Libero iste voluptatem sint consectetur voluptatibus et. Ea reiciendis facere expedita sapiente doloribus. Iure rerum repellat fuga et.', '[\"necessitatibus\",\"sit\",\"qui\"]', '[\"amet\",\"aut\",\"commodi\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/00ff22?text=icons+dolores', 1, 'waiting', 0, 37.61, 0, 19, 19, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(16, 'خدمة veritatis', 'Service reiciendis', 'Et est doloribus optio eaque error dolorem cum. Quia animi eos commodi quo. Explicabo perspiciatis omnis id.', 'Illo provident sint praesentium impedit. Laborum id quia deleniti. Non maxime ullam maxime voluptatem esse.', '[\"odio\",\"ut\",\"temporibus\"]', '[\"explicabo\",\"eligendi\",\"culpa\"]', 'http://127.0.0.1:8000/images/affiliateServices/service_6.jpg', 'https://via.placeholder.com/64x64.png/001100?text=icons+numquam', 1, 'waiting', 1, 83.67, 46, 17, 7, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(17, 'خدمة error', 'Service qui', 'Assumenda maiores et consequatur sed laborum. Est velit voluptatem quod tenetur est quasi.', 'Et quia maiores totam qui debitis possimus. Debitis reiciendis ducimus magnam quia voluptatibus autem. Nesciunt nulla facere consequuntur ea dolorem. Officiis repudiandae autem fugit.', '[\"et\",\"at\",\"sint\"]', '[\"qui\",\"ipsam\",\"non\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/003366?text=icons+et', 0, 'waiting', 1, 96.18, 76, 2, 3, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(18, 'خدمة consequatur', 'Service vel', 'Nobis vel architecto odio. Voluptatem a eaque quo porro maxime sunt minus. Culpa necessitatibus veniam iusto aliquam sequi. Quis ea consectetur quia. Consequatur fugit iste laboriosam voluptatum aut.', 'Quod sunt quia exercitationem culpa ut aut qui. Quia non voluptas voluptates architecto corporis molestias. Id reprehenderit debitis molestiae sed eius error. Enim doloribus dolores ut accusantium id.', '[\"rerum\",\"pariatur\",\"aliquid\"]', '[\"facere\",\"qui\",\"dolorum\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-02.jpg', 'https://via.placeholder.com/64x64.png/002200?text=icons+vel', 0, 'waiting', 0, 16.86, 27, 13, 5, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(19, 'خدمة et', 'Service culpa', 'Delectus minima minus minima occaecati. Non ex vitae culpa eligendi omnis unde sed ut.', 'Doloremque neque et eos praesentium sunt consequatur in. Vitae fugiat quis nam inventore optio. Aut sunt beatae praesentium natus.', '[\"dolores\",\"possimus\",\"omnis\"]', '[\"nemo\",\"qui\",\"maxime\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-02.jpg', 'https://via.placeholder.com/64x64.png/00ee33?text=icons+molestias', 0, 'waiting', 1, 13.64, 43, 11, 17, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(20, 'خدمة qui', 'Service et', 'Rerum architecto amet mollitia amet omnis asperiores quos veniam. Quasi ea velit itaque voluptatem. Iusto illum reiciendis eum nulla dolores aliquid. Qui cumque nostrum maxime.', 'Laborum aut et itaque corporis repellendus. Aspernatur quis dolore omnis explicabo. Aut repellendus soluta ut cumque temporibus provident ipsa cumque.', '[\"qui\",\"et\",\"nesciunt\"]', '[\"possimus\",\"iusto\",\"delectus\"]', 'http://127.0.0.1:8000/images/affiliateServices/service-03_676183f92d229.jpg', 'https://via.placeholder.com/64x64.png/00aadd?text=icons+ex', 1, 'waiting', 0, 14.96, 64, 20, 6, '2025-01-21 03:04:52', '2025-01-21 03:04:52'),
(21, 'asdasdasdasd', 'asdasdasdasdasd', 'asdasdasdasdasdasd', 'asdasdasdsadasdasdasdas', '\"[\\\"asdasdasd\\\",\\\"asdasdasd\\\",\\\"asdasdasd\\\",\\\"asdasdasd\\\"]\"', '\"[\\\"asdasdasd\\\",\\\"asdasdasdasd\\\",\\\"asdasdsad\\\",\\\"asdasdasdasd\\\"]\"', 'http://127.0.0.1:8000/images/affiliateServices/service_3_679476e0ea7e8.jpg', NULL, 1, 'waiting', 0, 39.43, 0, 20, 17, '2025-01-25 03:30:08', '2025-01-25 04:02:18'),
(22, 'asdasdasd', 'asdasdas', 'dsaasdasd', 'sadasdsa', '\"[\\\"ghgh\\\",\\\"fdgfd\\\",\\\"fdgfdgfdg\\\"]\"', '\"[\\\"sfgfdgfdg\\\",\\\"asfsdfsdf\\\",\\\"sdfsdfsdf\\\"]\"', 'http://127.0.0.1:8000/images/affiliateServices/service-02_6794787d2de75.jpg', NULL, 1, 'waiting', 1, 39.43, 0, 20, 1, '2025-01-25 03:37:01', '2025-01-25 04:03:22'),
(23, 'asdasdasd', 'asdasdas', 'dsaasdasd', 'sadasdsa', '\"[\\\"ghgh\\\",\\\"fdgfd\\\",\\\"fdgfdgfdg\\\"]\"', '\"[\\\"sfgfdgfdg\\\",\\\"asfsdfsdf\\\",\\\"sdfsdfsdf\\\"]\"', 'http://127.0.0.1:8000/images/affiliateServices/service-02_6794788ead6d7.jpg', NULL, 1, 'waiting', 1, 39.43, 0, 20, 3, '2025-01-25 03:37:18', '2025-01-25 13:01:33'),
(24, 'asdasdasd', 'asdasdas', 'dsaasdasd', 'sadasdsa', '\"[\\\"ghgh\\\",\\\"fdgfd\\\",\\\"fdgfdgfdg\\\"]\"', '\"[\\\"sfgfdgfdg\\\",\\\"asfsdfsdf\\\",\\\"sdfsdfsdf\\\"]\"', 'http://127.0.0.1:8000/images/affiliateServices/service-02_679478c17a8d1.jpg', NULL, 0, 'updated', 1, 39.43, 0, 20, 3, '2025-01-25 03:38:09', '2025-01-25 17:53:17'),
(25, 'asdsadasdasd', 'assadsadasdsad', 'asdasdasdasdasdasd', 'asdsadasdsad', '\"[\\\"asdsadasd\\\",\\\"sadasdasd\\\",\\\"dasdasd\\\"]\"', '\"[\\\"asdasdasd\\\",\\\"asdasdsa\\\",\\\"asdasds\\\"]\"', 'http://127.0.0.1:8000/images/affiliateServices/service-03_679479c830716.jpg', NULL, 1, 'waiting', 1, 39.43, 0, 20, 19, '2025-01-25 03:42:32', '2025-01-25 03:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `arma__cards`
--

CREATE TABLE `arma__cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `cvv` int(3) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `issue_date` varchar(255) DEFAULT NULL,
  `expiry_date` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','expired') NOT NULL DEFAULT 'inactive',
  `usage_limit` int(11) DEFAULT NULL,
  `current_usage` int(11) NOT NULL DEFAULT 0,
  `cardtype_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arma__cards`
--

INSERT INTO `arma__cards` (`id`, `user_id`, `card_number`, `cvv`, `price`, `issue_date`, `expiry_date`, `status`, `usage_limit`, `current_usage`, `cardtype_id`, `created_at`, `updated_at`) VALUES
(13, 52, '3569785912832179', 813, 49.99, '2025-01-01 17:21:41', '2025-02-01 14:21:41', 'active', NULL, 0, 3, '2025-01-01 15:21:41', '2025-01-01 12:21:41'),
(14, 52, '7882431647841905', 166, 199.99, '2025-01-01 17:21:20', '2025-03-01 14:21:20', 'inactive', NULL, 0, 4, '2025-01-01 15:21:20', '2025-01-01 12:21:20'),
(15, 52, '3111857930403180', 319, 49.99, '2025-01-01 17:22:18', '2025-04-01 14:22:18', 'active', NULL, 0, 8, '2025-01-01 15:22:18', '2025-01-01 12:22:18'),
(16, 23, '8659466538206397', 696, 49.99, '2025-01-09 21:53:29', '2025-02-09 18:53:29', 'active', NULL, 0, 3, '2025-01-09 19:53:29', '2025-01-09 16:53:29'),
(17, 52, NULL, NULL, 49.99, '1 month', NULL, 'inactive', NULL, 0, 3, NULL, NULL),
(18, 52, NULL, NULL, 49.99, '1 month', NULL, 'inactive', NULL, 0, 3, NULL, NULL),
(19, 52, NULL, NULL, 49.99, '1 month', NULL, 'inactive', NULL, 0, 3, NULL, NULL),
(20, 52, NULL, NULL, 199.99, '2 month', NULL, 'inactive', NULL, 0, 4, NULL, NULL),
(21, 52, '7969294693348587', 720, 199.99, '2025-01-10 07:51:06', '2025-03-10 04:51:06', 'active', NULL, 0, 4, '2025-01-10 05:51:06', '2025-01-10 02:51:06'),
(22, 52, '2948062160813630', 574, 199.99, '2025-01-10 07:50:55', '2025-03-10 04:50:55', 'active', NULL, 0, 4, '2025-01-10 05:50:55', '2025-01-10 02:50:55'),
(23, 52, NULL, NULL, 19.99, '1 month', NULL, 'inactive', NULL, 0, 2, NULL, NULL),
(24, 52, '6598993339003395', 781, 19.99, '2025-01-10 07:50:44', '2025-02-10 04:50:44', 'active', NULL, 0, 2, '2025-01-10 05:50:44', '2025-01-10 02:50:44'),
(25, 52, NULL, NULL, 19.99, '1 month', NULL, 'inactive', NULL, 0, 2, NULL, NULL),
(26, 51, '8462199347528234', 517, 19.99, '2025-01-17 10:17:16', '2025-02-17 07:17:16', 'active', NULL, 0, 2, '2025-01-17 08:17:16', '2025-01-17 05:17:16'),
(27, 51, '8082051227243599', 147, 9.99, '2024-01-17 09:31:46', '2024-02-17 06:31:46', 'expired', NULL, 0, 1, '2025-01-17 07:31:46', '2025-01-17 05:16:54'),
(28, 51, '4221274987331610', 158, 19.99, '2025-01-17 10:19:10', '2025-02-17 07:19:10', 'active', NULL, 0, 2, '2025-01-17 08:19:10', '2025-01-17 05:19:10'),
(29, 51, '3119990978612168', 140, 9.99, '2025-01-17 10:20:30', '2025-02-17 07:20:30', 'inactive', NULL, 0, 1, '2025-01-17 08:20:30', '2025-01-17 05:20:30'),
(30, 51, '9177059039154421', 647, 19.99, '2025-01-17 10:22:53', '2025-02-17 07:22:53', 'active', NULL, 0, 2, '2025-01-17 08:22:53', '2025-01-17 05:22:53'),
(31, 51, '1871678684465999', 879, 9.99, '2025-01-17 10:36:43', '2025-02-17 07:36:43', 'active', NULL, 0, 1, '2025-01-17 08:36:43', '2025-01-17 05:36:43'),
(32, 51, '9751216081523577', 975, 19.99, '2025-01-17 10:28:43', '2025-02-17 07:28:43', 'active', NULL, 0, 2, '2025-01-17 08:28:43', '2025-01-17 05:28:43'),
(33, 51, '4686475357879455', 122, 49.99, '2025-01-17 10:34:35', '2025-02-17 07:34:35', 'active', NULL, 0, 3, '2025-01-17 08:34:35', '2025-01-17 05:34:35'),
(35, 51, '1530998769965251', 970, 0.00, '2025-01-17 10:39:36', '2025-01-17 07:39:36', 'expired', NULL, 0, 6, '2025-01-17 08:39:36', '2025-01-26 00:07:56'),
(36, 51, '3385896267984593', 603, 0.00, '2025-01-17 10:40:45', '2025-02-17 07:40:45', 'active', NULL, 0, 2, '2025-01-17 08:40:45', '2025-01-17 05:40:45'),
(37, 51, '7479139493441406', 206, 0.00, '2025-01-17 10:41:05', '2025-02-17 07:41:05', 'active', NULL, 0, 3, '2025-01-17 08:41:05', '2025-01-17 05:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `artical_categories`
--

CREATE TABLE `artical_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artical_categories`
--

INSERT INTO `artical_categories` (`id`, `title_ar`, `title_en`, `image`, `created_at`, `updated_at`) VALUES
(1, 'التقنية', 'Technology', 'http://127.0.0.1:8000/images/articals_categories/newspaper.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(2, 'الصحة', 'Health', 'http://127.0.0.1:8000/images/articals_categories/blog.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(3, 'العلوم', 'Science', 'http://127.0.0.1:8000/images/articals_categories/articles.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(4, 'الاقتصاد', 'Economics', 'http://127.0.0.1:8000/images/articals_categories/articles.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(5, 'البيئة', 'Environment', 'http://127.0.0.1:8000/images/articals_categories/articles.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(6, 'التعليم', 'Education', 'http://127.0.0.1:8000/images/articals_categories/search.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(7, 'الرياضة', 'Sports', 'http://127.0.0.1:8000/images/articals_categories/newspaper.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(8, 'الثقافة', 'Culture', 'http://127.0.0.1:8000/images/articals_categories/newspaper.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(9, 'السفر', 'Travel', 'http://127.0.0.1:8000/images/articals_categories/search.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(10, 'الطعام', 'Food', 'http://127.0.0.1:8000/images/articals_categories/newspaper.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(11, 'الأعمال', 'Business', 'http://127.0.0.1:8000/images/articals_categories/blog.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(12, 'الفن', 'Art', 'http://127.0.0.1:8000/images/articals_categories/blog.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(13, 'التاريخ', 'History', 'http://127.0.0.1:8000/images/articals_categories/search.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(14, 'المالية', 'Finance', 'http://127.0.0.1:8000/images/articals_categories/articles.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(15, 'الأزياء', 'Fashion', 'http://127.0.0.1:8000/images/articals_categories/newspaper.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(16, 'التسويق', 'Marketing', 'http://127.0.0.1:8000/images/articals_categories/articles.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(17, 'التكنولوجيا الحديثة', 'Modern Technology', 'http://127.0.0.1:8000/images/articals_categories/writing.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(18, 'الإعلام', 'Media', 'http://127.0.0.1:8000/images/articals_categories/blog.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(19, 'التحليل السياسي', 'Political Analysis', 'http://127.0.0.1:8000/images/articals_categories/articles.png', '2025-01-18 03:06:04', '2025-01-18 03:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `article_reactions_count`
--

CREATE TABLE `article_reactions_count` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0,
  `loves` int(11) NOT NULL DEFAULT 0,
  `laughs` int(11) NOT NULL DEFAULT 0,
  `total_reactions` int(11) DEFAULT NULL,
  `first_reaction_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ أول تفاعل',
  `last_reaction_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ آخر تفاعل',
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_reactions_count`
--

INSERT INTO `article_reactions_count` (`id`, `likes`, `dislikes`, `loves`, `laughs`, `total_reactions`, `first_reaction_at`, `last_reaction_at`, `article_id`, `created_at`, `updated_at`) VALUES
(1, 495, 98, 206, 121, 920, '2024-03-20 10:38:42', '2024-12-23 10:38:42', 15, NULL, NULL),
(2, 81, 82, 251, 121, 535, '2024-11-02 10:38:42', '2025-01-07 10:38:42', 10, NULL, NULL),
(3, 179, 82, 199, 26, 486, '2024-04-20 10:38:42', '2024-12-20 10:38:42', 7, NULL, NULL),
(4, 235, 10, 85, 0, 330, '2024-01-20 10:38:42', '2024-12-28 10:38:42', 2, NULL, NULL),
(5, 89, 9, 66, 68, 232, '2024-11-10 10:38:42', '2024-12-27 10:38:42', 6, NULL, NULL),
(6, 277, 31, 96, 123, 527, '2024-05-10 09:38:42', '2024-12-21 10:38:42', 11, NULL, NULL),
(7, 79, 92, 154, 193, 518, '2024-02-04 10:38:42', '2025-01-07 10:38:42', 4, NULL, NULL),
(8, 449, 31, 127, 187, 794, '2024-07-01 09:38:42', '2024-12-27 10:38:42', 1, NULL, '2025-01-13 10:40:30'),
(9, 161, 71, 25, 119, 376, '2024-10-27 09:38:42', '2024-12-19 10:38:42', 13, NULL, NULL),
(10, 105, 19, 160, 96, 380, '2024-09-17 09:38:42', '2024-12-24 10:38:42', 5, NULL, NULL),
(11, 376, 62, 153, 116, 707, '2024-04-29 09:38:42', '2024-12-30 10:38:42', 9, NULL, '2025-01-10 10:41:50'),
(12, 69, 81, 222, 91, 462, '2024-03-02 10:38:42', '2024-12-21 10:38:42', 14, NULL, '2025-01-16 10:13:54'),
(13, 367, 62, 265, 83, 777, '2024-03-26 10:38:42', '2024-12-18 10:38:42', 3, NULL, NULL),
(14, 303, 44, 89, 93, 529, '2024-06-05 09:38:42', '2024-12-22 10:38:42', 8, NULL, '2025-01-10 10:39:09'),
(15, 5, 8, 93, 175, 280, '2024-11-15 10:38:42', '2025-01-03 10:38:42', 12, NULL, '2025-01-16 09:56:56'),
(16, 232, 1, 147, 53, 433, '2024-08-07 02:06:04', '2025-01-12 03:06:04', 3, NULL, NULL),
(17, 40, 67, 134, 167, 408, '2024-06-07 02:06:04', '2025-01-10 03:06:04', 5, NULL, NULL),
(18, 203, 9, 283, 116, 611, '2024-08-31 02:06:04', '2025-01-01 03:06:04', 2, NULL, NULL),
(19, 249, 89, 294, 150, 782, '2024-12-10 03:06:04', '2025-01-17 03:06:04', 1, NULL, NULL),
(20, 177, 87, 163, 184, 611, '2024-04-09 03:06:04', '2024-12-20 03:06:04', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bells`
--

CREATE TABLE `bells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bell_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bell_items`)),
  `bell_type` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_type` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bells`
--

INSERT INTO `bells` (`id`, `bell_items`, `bell_type`, `amount`, `user_id`, `account_type`, `created_at`, `updated_at`) VALUES
(5, NULL, 'confirm_booked', '40', 13, 'User', '2025-01-01 12:17:24', '2025-01-01 12:17:24'),
(6, '[{\"id\":\"3\",\"price\":\"49.99\",\"title\":\"Enterprise Subscription\",\"quantity\":1,\"duration\":\"1 month\"},{\"id\":\"4\",\"price\":\"199.99\",\"title\":\"Weekend Getaway\",\"quantity\":1,\"duration\":\"2 month\"},{\"id\":\"8\",\"price\":\"49.99\",\"title\":\"Photography Workshop\",\"quantity\":1,\"duration\":\"3 month\"}]', 'cards_bell', '299.97', 15, 'User', '2025-01-01 12:19:33', '2025-01-01 12:19:33'),
(7, NULL, 'confirm_booked', '40', 51, 'User', '2025-01-02 09:33:25', '2025-01-02 09:33:25'),
(8, '[{\"id\":\"3\",\"price\":\"49.99\",\"title\":\"Enterprise Subscription\",\"quantity\":1,\"duration\":\"1 month\"}]', 'cards_bell', '49.99', 23, 'User', '2025-01-09 16:52:54', '2025-01-09 16:52:54'),
(9, '[{\"id\":\"3\",\"price\":\"49.99\",\"title\":\"Enterprise Subscription\",\"quantity\":3,\"duration\":\"1 month\"},{\"id\":\"4\",\"price\":\"199.99\",\"title\":\"Weekend Getaway\",\"quantity\":3,\"duration\":\"2 month\"},{\"id\":\"2\",\"price\":\"19.99\",\"title\":\"Pro Subscription\",\"quantity\":3,\"duration\":\"1 month\"}]', 'cards_bell', '809.91', 12, 'organization', '2025-01-10 02:49:47', '2025-01-10 02:49:47'),
(10, '[{\"id\":\"2\",\"price\":\"19.99\",\"title\":\"Pro Subscription\",\"quantity\":1,\"duration\":\"1 month\"},{\"id\":\"1\",\"price\":\"9.99\",\"title\":\"Basic Subscription\",\"quantity\":1,\"duration\":\"1 month\"}]', 'cards_bell', '29.98', 51, 'User', '2025-01-13 05:35:05', '2025-01-13 05:35:05'),
(11, '[{\"id\":\"2\",\"price\":\"19.99\",\"title\":\"Pro Subscription\",\"quantity\":1,\"duration\":\"1 month\"},{\"id\":\"1\",\"price\":\"9.99\",\"title\":\"Basic Subscription\",\"quantity\":1,\"duration\":\"1 month\"}]', 'cards_bell', '29.98', 51, 'User', '2025-01-13 05:36:45', '2025-01-13 05:36:45'),
(12, '[{\"id\":\"2\",\"price\":\"19.99\",\"title\":\"Pro Subscription\",\"quantity\":1,\"duration\":\"1 month\"},{\"id\":\"1\",\"price\":\"9.99\",\"title\":\"Basic Subscription\",\"quantity\":1,\"duration\":\"1 month\"}]', 'cards_bell', '29.98', 51, 'User', '2025-01-13 05:39:49', '2025-01-13 05:39:49'),
(13, '[{\"id\":\"2\",\"price\":\"19.99\",\"title\":\"Pro Subscription\",\"quantity\":1,\"duration\":\"1 month\"},{\"id\":\"3\",\"price\":\"49.99\",\"title\":\"Enterprise Subscription\",\"quantity\":1,\"duration\":\"1 month\"}]', 'cards_bell', '69.98', 51, 'User', '2025-01-13 05:44:14', '2025-01-13 05:44:14'),
(14, '{\"book_day\":\"2025-01-22\",\"book_time\":\"09:30 AM\",\"expire_in\":\"09:45 AM\",\"additional_notes\":null,\"user_id\":\"51\",\"organization_id\":\"20\"}', 'confirm_booked', '20', 51, 'User', '2025-01-13 07:47:46', '2025-01-13 07:47:46'),
(15, '{\"book_day\":\"2025-01-31\",\"book_time\":\"05:30 AM\",\"expire_in\":\"05:45 AM\",\"additional_notes\":null,\"user_id\":\"51\",\"organization_id\":\"20\"}', 'confirm_booked', '39.43', 51, 'User', '2025-01-23 22:23:06', '2025-01-23 22:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blocker_id` bigint(20) UNSIGNED NOT NULL,
  `blocker_type` varchar(255) NOT NULL,
  `blocked_id` bigint(20) UNSIGNED NOT NULL,
  `blocked_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blocked_users`
--

INSERT INTO `blocked_users` (`id`, `blocker_id`, `blocker_type`, `blocked_id`, `blocked_type`, `created_at`, `updated_at`) VALUES
(2, 52, 'User', 23, 'Organization', '2025-01-09 06:23:57', '2025-01-09 06:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `content_ar` text NOT NULL,
  `content_en` text NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT '2024-12-25 04:21:16',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `slug`, `image`, `title_ar`, `title_en`, `content_ar`, `content_en`, `author_id`, `active`, `category_id`, `views`, `published_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'http://127.0.0.1:8000/images/services/images/service_6.jpg', 'العناية بالعيون', 'Eye Care', 'نقدم خدمات شاملة للعناية بالعيون لجميع الأعمار، من حديثي الولادة إلى كبار السن. يقدم أطباؤنا المتخصصون في طب العيون فحوصات شاملة للعيون، والكشف المبكر عن أمراض العين، وخيارات علاج لحالات مثل الجلوكوما، إعتام عدسة العين، والتنكس البقعي. كما نخصص خدمات تصحيح الرؤية الشخصية مثل جراحة الليزك، العدسات اللاصقة، والنظارات الطبية. هدفنا هو ضمان صحة عيونك على المدى الطويل ومساعدتك في الحفاظ على رؤية واضحة وصحية طوال حياتك. كما نقدم متابعة دورية ورعاية وقائية للكشف المبكر عن أي مشاكل قد تظهر.', 'We provide comprehensive eye care services for all ages, from newborns to the elderly. Our expert ophthalmologists offer advanced eye exams, early detection of eye diseases, and treatment options for conditions such as glaucoma, cataracts, and macular degeneration. We also specialize in providing personalized vision correction treatments including LASIK surgery, contact lenses, and prescription glasses. Our goal is to ensure the long-term health of your eyes and to help you maintain clear and healthy vision throughout your life. We also offer regular follow-ups and preventative care to catch any potential issues early on.', 29, 1, 15, 0, '2024-12-25 04:21:16', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(2, NULL, 'http://127.0.0.1:8000/images/services/images/service_6.jpg', 'خدمات طب الأسنان', 'Dental Services', 'عيادتنا لطب الأسنان تقدم مجموعة كاملة من الخدمات المصممة للحفاظ على صحة الفم المثلى وتقديم حلول لمختلف القضايا الأسنان. يشمل ذلك الفحوصات الدورية، التنظيف المهني، الحشوات، والعلاجات الوقائية مثل تطبيقات السيلانت والفلواريد. نحن متخصصون في خدمات طب الأسنان التجميلية مثل تبييض الأسنان، الفينير، والتيجان لتحسين مظهر ابتسامتك. كما يعالج فريقنا من المتخصصين في طب الأسنان أمراض اللثة، حساسية الأسنان، ويقوم بعمل قنوات الجذور عند الحاجة. نحن ملتزمون بتقديم رعاية أسنان خالية من الألم وضمان أن كل زيارة مريحة وخالية من التوتر.', 'Our dental clinic offers a full range of dental services designed to maintain optimal oral health and provide solutions for various dental concerns. This includes regular check-ups, professional cleanings, fillings, and preventive treatments such as sealants and fluoride applications. We specialize in cosmetic dentistry services including teeth whitening, veneers, and crowns to enhance the appearance of your smile. Our team of experienced dental professionals also treats gum disease, tooth sensitivity, and performs root canals when necessary. We are dedicated to providing pain-free dental care and ensuring that every visit is comfortable and stress-free.', 14, 1, 2, 0, '2024-12-25 04:21:16', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(3, NULL, 'http://127.0.0.1:8000/images/services/images/service_4.jpg', 'أمراض القلب', 'Cardiology', 'يقدم قسم أمراض القلب لدينا رعاية متخصصة لصحة القلب والأمراض القلبية الوعائية. يقدم فريق من أطباء القلب الخبراء فحوصات قلب شاملة، اختبارات تشخيصية، وخطط علاج مخصصة لحالات مثل أمراض القلب، ارتفاع ضغط الدم، اضطرابات النظم القلبي، وارتفاع الكوليسترول. نحن نقدم تقنيات تشخيصية متطورة مثل تخطيط القلب الكهربائي، تخطيط صدى القلب، واختبارات الإجهاد لمتابعة صحة القلب. بالنسبة للمرضى الذين يعانون من حالات أكثر خطورة، نقدم إجراءات متقدمة مثل بالون الأوعية الدموية، وضع الدعامة، وجراحة القلب. هدفنا هو المساعدة في الوقاية من النوبات القلبية، السكتات الدماغية، والأحداث القلبية الوعائية الأخرى، وضمان أفضل نوعية حياة ممكنة لمرضانا.', 'Our cardiology department offers specialized care for heart health and cardiovascular diseases. Our team of expert cardiologists provides comprehensive heart evaluations, diagnostic testing, and personalized treatment plans for conditions such as heart disease, hypertension, arrhythmias, and high cholesterol. We offer cutting-edge diagnostic technologies such as ECGs, echocardiograms, and stress tests to monitor heart health. For patients with more serious conditions, we provide advanced procedures including angioplasty, stent placement, and heart surgery. Our goal is to help prevent heart attacks, strokes, and other cardiovascular events, ensuring the best possible quality of life for our patients.', 6, 1, 2, 0, '2024-12-25 04:21:16', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(4, NULL, 'http://127.0.0.1:8000/images/services/images/service_4.jpg', 'طب الأطفال', 'Pediatrics', 'نقدم خدمات رعاية صحية متخصصة للأطفال من جميع الأعمار، من حديثي الولادة إلى المراهقين. أطباؤنا المتخصصون في طب الأطفال ملتزمون بتقديم رعاية طبية عالية الجودة، مع التركيز على الوقاية من الأمراض وعلاجها في مرحلة الطفولة. نحن نقدم فحوصات منتظمة لمتابعة النمو والتطور، نقدم التطعيمات، ونوفر العلاجات للمشاكل الصحية الشائعة للأطفال مثل الربو، والحساسية، والتهابات الأذن، وحالات الجلد. كما يتقن أطباؤنا إدارة الحالات المزمنة مثل السكري، فرط النشاط، والتأخر في النمو. نحن نؤكد على النهج الشمولي لصحة الأطفال، حيث ندمج الرفاهية الجسدية والعاطفية في رعايتنا.', 'We provide expert healthcare services for children of all ages, from newborns to adolescents. Our pediatricians are dedicated to providing high-quality medical care, focusing on preventing and treating childhood illnesses. We offer regular check-ups to monitor growth and development, administer vaccinations, and provide treatments for common pediatric issues such as asthma, allergies, ear infections, and skin conditions. Our pediatricians are also skilled in managing chronic conditions like diabetes, ADHD, and developmental delays. We emphasize a holistic approach to children’s health, incorporating both physical and emotional well-being into our care.', 37, 1, 8, 0, '2024-12-25 04:21:16', '2025-01-18 03:06:04', '2025-01-18 03:06:04'),
(5, NULL, 'http://127.0.0.1:8000/images/services/images/service-03.jpg', 'جراحة العظام', 'Orthopedics', 'يقدم قسم جراحة العظام لدينا رعاية متخصصة للعظام والمفاصل والعضلات والأربطة. نحن نقدم علاجات لمجموعة واسعة من المشاكل العظمية مثل الكسور، التهاب المفاصل، الإصابات الرياضية، آلام الظهر، واضطرابات المفاصل. جراحونا المتخصصون في جراحة العظام خبراء في إجراء عمليات مثل استبدال المفاصل، منظار المفصل، وإعادة ترتيب العظام. كما نقدم خدمات العلاج الطبيعي وإعادة التأهيل لمساعدة المرضى على التعافي من الإصابات والجراحة. هدفنا هو استعادة الحركة، تقليل الألم، وتحسين جودة حياة مرضانا.', 'Our orthopedic department provides specialized care for bones, joints, muscles, and ligaments. We offer treatments for a wide range of orthopedic issues including fractures, arthritis, sports injuries, back pain, and joint disorders. Our orthopedic surgeons are experts in performing surgeries such as joint replacements, arthroscopy, and bone realignment. We also provide physical therapy and rehabilitation services to help patients recover from injuries and surgeries. Our goal is to restore mobility, reduce pain, and improve quality of life for our patients.', 8, 1, 11, 0, '2024-12-25 04:21:16', '2025-01-18 03:06:04', '2025-01-18 03:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_day` date DEFAULT NULL,
  `book_time` varchar(255) DEFAULT NULL,
  `expire_in` varchar(255) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `status` enum('done','waiting','expired','acceptable','unacceptable') NOT NULL DEFAULT 'waiting',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `book_day`, `book_time`, `expire_in`, `additional_notes`, `status`, `user_id`, `organization_id`, `created_at`, `updated_at`) VALUES
(1, '2025-01-19', '2025-01-18 18:34:00', '2025-01-24 00:00:00', 'ملاحظات إضافية للموعد رقم 1', 'waiting', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(2, '2025-01-20', '2025-01-18 12:30:00', '2025-02-06 00:00:00', 'ملاحظات إضافية للموعد رقم 2', 'expired', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(3, '2025-01-21', '2025-01-18 13:23:00', '2025-02-08 00:00:00', 'ملاحظات إضافية للموعد رقم 3', 'done', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(4, '2025-01-22', '2025-01-18 12:39:00', '2025-02-16 00:00:00', 'ملاحظات إضافية للموعد رقم 4', 'waiting', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(5, '2025-01-23', '2025-01-18 14:57:00', '2025-02-03 00:00:00', 'ملاحظات إضافية للموعد رقم 5', 'done', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(6, '2025-01-24', '2025-01-18 12:26:00', '2025-01-29 00:00:00', 'ملاحظات إضافية للموعد رقم 6', 'expired', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(7, '2025-01-25', '2025-01-18 10:06:00', '2025-02-07 00:00:00', 'ملاحظات إضافية للموعد رقم 7', 'waiting', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(8, '2025-01-26', '2025-01-18 09:30', '2025-01-29 00:00:00', 'ملاحظات إضافية للموعد رقم 8', 'acceptable', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(9, '2025-01-27', '2025-01-18 08:18:00', '2025-02-13 00:00:00', 'ملاحظات إضافية للموعد رقم 9', 'unacceptable', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(10, '2025-01-28', '2025-01-18 09:11:00', '2025-02-13 00:00:00', 'ملاحظات إضافية للموعد رقم 10', 'expired', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(11, '2025-01-29', '2025-01-18 18:29:00', '2025-02-01 00:00:00', 'ملاحظات إضافية للموعد رقم 11', 'waiting', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(12, '2025-01-30', '2025-01-18 16:49:00', '2025-02-18 00:00:00', 'ملاحظات إضافية للموعد رقم 12', 'expired', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(13, '2025-01-31', '2025-01-18 08:34:00', '2025-02-05 00:00:00', 'ملاحظات إضافية للموعد رقم 13', 'expired', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(14, '2025-02-01', '2025-01-18 16:28:00', '2025-03-02 00:00:00', 'ملاحظات إضافية للموعد رقم 14', 'expired', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(15, '2025-02-02', '2025-01-18 10:46:00', '2025-02-07 00:00:00', 'ملاحظات إضافية للموعد رقم 15', 'unacceptable', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(16, '2025-02-03', '2025-01-18 11:46:00', '2025-02-05 00:00:00', 'ملاحظات إضافية للموعد رقم 16', 'unacceptable', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(17, '2025-02-04', '2025-01-18 08:38:00', '2025-02-22 00:00:00', 'ملاحظات إضافية للموعد رقم 17', 'acceptable', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(18, '2025-02-05', '2025-01-18 09:02:00', '2025-02-07 00:00:00', 'ملاحظات إضافية للموعد رقم 18', 'acceptable', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(19, '2025-02-06', '2025-01-18 10:13:00', '2025-02-10 00:00:00', 'ملاحظات إضافية للموعد رقم 19', 'unacceptable', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(20, '2025-02-07', '2025-01-18 15:04:00', '2025-02-21 00:00:00', 'ملاحظات إضافية للموعد رقم 20', 'expired', 51, 12, '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(21, '2025-01-31', '05:30 AM', '05:45 AM', NULL, 'waiting', 51, 20, '2025-01-23 22:23:00', '2025-01-23 22:23:00'),
(25, '2025-01-27', '06:30 AM', '06:45 AM', NULL, 'waiting', NULL, 20, '2025-01-25 23:55:32', '2025-01-25 23:55:32'),
(29, '2025-01-27', '07:30 AM', '07:45 AM', NULL, 'waiting', NULL, 20, '2025-01-25 23:58:49', '2025-01-25 23:58:49'),
(30, '2025-01-27', '08:30 AM', '08:45 AM', NULL, 'waiting', NULL, 20, '2025-01-25 23:58:49', '2025-01-25 23:58:49'),
(31, '2025-01-27', '08:00 AM', '08:15 AM', NULL, 'waiting', NULL, 20, '2025-01-25 23:58:49', '2025-01-25 23:58:49'),
(32, '2025-01-27', '02:30 PM', '02:45 PM', NULL, 'waiting', NULL, 20, '2025-01-26 00:12:17', '2025-01-26 00:12:17'),
(33, '2025-01-27', '03:00 PM', '03:15 PM', NULL, 'waiting', NULL, 20, '2025-01-26 00:12:17', '2025-01-26 00:12:17');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_types`
--

CREATE TABLE `card_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `description_en` text NOT NULL,
  `description_ar` text NOT NULL,
  `price_before_discount` decimal(8,2) DEFAULT 8.00,
  `price` decimal(8,2) NOT NULL,
  `features_ar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`features_ar`)),
  `features_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`features_en`)),
  `duration` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date DEFAULT '2024-01-18',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `card_types`
--

INSERT INTO `card_types` (`id`, `title_en`, `title_ar`, `description_en`, `description_ar`, `price_before_discount`, `price`, `features_ar`, `features_en`, `duration`, `image`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Basic Subscription', 'الاشتراك الأساسي', 'A starter plan for individuals.', 'خطة بداية مناسبة للأفراد.', 12.99, 9.99, '\"[\\\"\\u0627\\u0644\\u0648\\u0635\\u0648\\u0644 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u0645\\u064a\\u0632\\u0627\\u062a \\u0627\\u0644\\u0623\\u0633\\u0627\\u0633\\u064a\\u0629\\\",\\\"\\u062f\\u0639\\u0645 \\u0627\\u0644\\u0628\\u0631\\u064a\\u062f \\u0627\\u0644\\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a\\\",\\\"\\u062a\\u062d\\u0644\\u064a\\u0644\\u0627\\u062a \\u0628\\u0633\\u064a\\u0637\\u0629\\\",\\\"\\u0644\\u0648\\u062d\\u0629 \\u062a\\u062d\\u0643\\u0645 \\u0645\\u062e\\u0635\\u0635\\u0629\\\"]\"', '\"[\\\"Access to basic features\\\",\\\"Email support\\\",\\\"Simple analytics\\\",\\\"Custom dashboard\\\"]\"', '1 month', 'http://127.0.0.1:8000/images/cardtypes/card_1_6789ff5563f58.jpg', 1, '2024-01-18', '2025-01-17 04:57:25'),
(2, 'Pro Subscription', 'الاشتراك الاحترافي', 'An advanced plan for professionals.', 'خطة متقدمة للمحترفين.', 25.99, 19.99, '\"[\\\"\\u062a\\u062d\\u0644\\u064a\\u0644\\u0627\\u062a \\u0645\\u062a\\u0642\\u062f\\u0645\\u0629\\\",\\\"\\u062f\\u0639\\u0645 \\u0623\\u0648\\u0644\\u0648\\u064a\\u0629\\\",\\\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0641\\u0631\\u0642\\\",\\\"\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u063a\\u064a\\u0631 \\u0645\\u062d\\u062f\\u0648\\u062f\\u0629\\\"]\"', '\"[\\\"Advanced analytics\\\",\\\"Priority support\\\",\\\"Team management\\\",\\\"Unlimited projects\\\"]\"', '1 month', 'http://127.0.0.1:8000/images/cardtypes/card_3_678a06e0217c0.jpg', 1, '2024-01-18', '2025-01-17 05:29:36'),
(3, 'Enterprise Subscription', 'اشتراك الشركات', 'A premium plan for businesses.', 'خطة متميزة للشركات.', 55.99, 49.99, '\"[\\\"\\u0645\\u062f\\u064a\\u0631 \\u062d\\u0633\\u0627\\u0628 \\u0645\\u062e\\u0635\\u0635\\\",\\\"\\u062a\\u0643\\u0627\\u0645\\u0644 \\u0645\\u062e\\u0635\\u0635\\\",\\\"\\u0623\\u0645\\u0627\\u0646 \\u0645\\u062d\\u0633\\u0651\\u0646\\\",\\\"\\u062f\\u0639\\u0645 \\u0639\\u0644\\u0649 \\u0645\\u062f\\u0627\\u0631 \\u0627\\u0644\\u0633\\u0627\\u0639\\u0629\\\"]\"', '\"[\\\"Dedicated account manager\\\",\\\"Custom integrations\\\",\\\"Enhanced security\\\",\\\"24\\/7 support\\\"]\"', '1 year', 'http://127.0.0.1:8000/images/cardtypes/card_2_678a06f5ecce3.png', 1, '2024-01-18', '2025-01-17 05:29:57'),
(4, 'Weekend Getaway', 'عطلة نهاية الأسبوع', 'A two-day escape to nature.', 'هروب لمدة يومين إلى الطبيعة.', 220.99, 199.99, '\"[\\\"\\u0627\\u0644\\u0625\\u0642\\u0627\\u0645\\u0629 \\u0641\\u064a \\u0641\\u0646\\u062f\\u0642\\\",\\\"\\u0648\\u062c\\u0628\\u0627\\u062a \\u0645\\u0634\\u0645\\u0648\\u0644\\u0629\\\",\\\"\\u0645\\u0631\\u0634\\u062f \\u0633\\u064a\\u0627\\u062d\\u064a\\\",\\\"\\u0648\\u0633\\u0627\\u0626\\u0644 \\u0646\\u0642\\u0644\\\"]\"', '\"[\\\"Hotel stay\\\",\\\"Meals included\\\",\\\"Tour guide\\\",\\\"Transportation\\\"]\"', '2 days', 'http://127.0.0.1:8000/images/cardtypes/card_3_678a06ff50f52.jpg', 0, '2024-01-18', '2025-01-17 05:30:07'),
(5, 'Fitness Membership', 'عضوية اللياقة البدنية', 'Full access membership to our gyms.', 'عضوية للوصول الكامل إلى صالاتنا الرياضية.', 39.99, 29.99, '\"[\\\"\\u0627\\u0644\\u0648\\u0635\\u0648\\u0644 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u0635\\u0627\\u0644\\u0629 \\u0627\\u0644\\u0631\\u064a\\u0627\\u0636\\u064a\\u0629 24\\/7\\\",\\\"\\u062c\\u0644\\u0633\\u0627\\u062a \\u062a\\u062f\\u0631\\u064a\\u0628 \\u0645\\u062c\\u0627\\u0646\\u064a\\u0629\\\",\\\"\\u0645\\u062f\\u0631\\u0628 \\u0634\\u062e\\u0635\\u064a\\\",\\\"\\u0627\\u0633\\u062a\\u0634\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u0635\\u062d\\u0629\\\"]\"', '\"[\\\"24\\/7 gym access\\\",\\\"Free training sessions\\\",\\\"Personal trainer\\\",\\\"Wellness consultations\\\"]\"', '1 month', 'http://127.0.0.1:8000/images/cardtypes/card_2_678a070a4cb62.png', 1, '2024-01-18', '2025-01-17 05:30:18'),
(6, 'Online Course', 'دورة تدريبية عبر الإنترنت', 'Learn web development at your own pace.', 'تعلم تطوير الويب بالسرعة التي تناسبك.', 120.99, 99.99, '\"[\\\"\\u0648\\u0635\\u0648\\u0644 \\u0645\\u062f\\u0649 \\u0627\\u0644\\u062d\\u064a\\u0627\\u0629\\\",\\\"\\u0634\\u0647\\u0627\\u062f\\u0629 \\u0625\\u062a\\u0645\\u0627\\u0645\\\",\\\"\\u062f\\u0631\\u0648\\u0633 \\u0641\\u064a\\u062f\\u064a\\u0648\\\",\\\"\\u062c\\u0644\\u0633\\u0627\\u062a \\u0623\\u0633\\u0626\\u0644\\u0629 \\u0648\\u0625\\u062c\\u0627\\u0628\\u0627\\u062a \\u0645\\u0628\\u0627\\u0634\\u0631\\u0629\\\"]\"', '\"[\\\"Lifetime access\\\",\\\"Certificate of completion\\\",\\\"Video tutorials\\\",\\\"Live Q&A sessions\\\"]\"', 'Lifetime', 'http://127.0.0.1:8000/images/cardtypes/card_3_678a071dafe04.jpg', 1, '2024-01-18', '2025-01-17 05:30:37'),
(7, 'Luxury Spa Package', 'باقات السبا الفاخرة', 'Relax and rejuvenate with premium spa services.', 'استرخ واستمتع مع خدمات السبا الفاخرة.', 399.99, 299.99, '\"[\\\"\\u0639\\u0644\\u0627\\u062c \\u062a\\u062f\\u0644\\u064a\\u0643\\\",\\\"\\u0639\\u0644\\u0627\\u062c \\u0644\\u0644\\u0648\\u062c\\u0647\\\",\\\"\\u0627\\u0644\\u062f\\u062e\\u0648\\u0644 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u0633\\u0627\\u0648\\u0646\\u0627\\\",\\\"\\u0627\\u0644\\u0639\\u0644\\u0627\\u062c \\u0628\\u0627\\u0644\\u0631\\u0648\\u0627\\u0626\\u062d\\\"]\"', '\"[\\\"Massage therapy\\\",\\\"Facial treatment\\\",\\\"Sauna access\\\",\\\"Aromatherapy\\\"]\"', '1 day', 'http://127.0.0.1:8000/images/cardtypes/card_3_678a071204b40.jpg', 0, '2024-01-18', '2025-01-17 05:30:26'),
(8, 'Photography Workshop', 'ورشة التصوير الفوتوغرافي', 'Master your photography skills with experts.', 'تعلم مهارات التصوير الفوتوغرافي مع الخبراء.', 59.99, 49.99, '\"[\\\"\\u0645\\u0645\\u0627\\u0631\\u0633\\u0629 \\u0639\\u0645\\u0644\\u064a\\u0629\\\",\\\"\\u062f\\u0644\\u064a\\u0644 \\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a\\\",\\\"\\u0646\\u0635\\u0627\\u0626\\u062d \\u062a\\u062d\\u0631\\u064a\\u0631\\\",\\\"\\u062a\\u0642\\u0646\\u064a\\u0627\\u062a \\u0627\\u0644\\u0625\\u0636\\u0627\\u0621\\u0629\\\"]\"', '\"[\\\"Hands-on practice\\\",\\\"E-book guide\\\",\\\"Editing tips\\\",\\\"Lighting techniques\\\"]\"', '3 hours', 'http://127.0.0.1:8000/images/cardtypes/card_2_678a072815113.png', 1, '2024-01-18', '2025-01-17 05:30:48'),
(9, 'Cooking Masterclass', 'دورة طبخ متقدمة', 'Learn to cook gourmet meals from top chefs.', 'تعلم طهي وجبات فاخرة مع أفضل الطهاة.', 69.99, 59.99, '\"[\\\"\\u062c\\u0644\\u0633\\u0627\\u062a \\u0645\\u0628\\u0627\\u0634\\u0631\\u0629\\\",\\\"\\u0643\\u062a\\u064a\\u0628 \\u0648\\u0635\\u0641\\u0627\\u062a\\\",\\\"\\u0646\\u0635\\u0627\\u0626\\u062d \\u062d\\u0648\\u0644 \\u0627\\u0644\\u0645\\u0643\\u0648\\u0646\\u0627\\u062a\\\",\\\"\\u0625\\u0631\\u0634\\u0627\\u062f\\u0627\\u062a \\u0623\\u062f\\u0648\\u0627\\u062a \\u0627\\u0644\\u0645\\u0637\\u0628\\u062e\\\"]\"', '\"[\\\"Live sessions\\\",\\\"Recipe booklet\\\",\\\"Ingredient tips\\\",\\\"Kitchen tools guidance\\\"]\"', '5 hours', 'http://127.0.0.1:8000/images/cardtypes/card_2_678a073b3045b.png', 1, '2024-01-18', '2025-01-17 05:31:07'),
(10, 'Adventure Package', 'باقة المغامرات', 'Experience the thrill of outdoor adventures.', 'استمتع بإثارة المغامرات الخارجية.', 599.99, 499.99, '\"[\\\"\\u062a\\u0633\\u0644\\u0642 \\u0627\\u0644\\u0635\\u062e\\u0648\\u0631\\\",\\\"\\u0627\\u0644\\u062a\\u062c\\u062f\\u064a\\u0641\\\",\\\"\\u0627\\u0644\\u062a\\u062e\\u064a\\u064a\\u0645\\\",\\\"\\u0627\\u0633\\u062a\\u0643\\u0634\\u0627\\u0641 \\u0627\\u0644\\u0637\\u0628\\u064a\\u0639\\u0629\\\"]\"', '\"[\\\"Rock climbing\\\",\\\"Rafting\\\",\\\"Camping\\\",\\\"Nature exploration\\\"]\"', '3 days', 'http://127.0.0.1:8000/images/cardtypes/card_3_678a0731dcb07.jpg', 0, '2024-01-18', '2025-01-17 05:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(100) DEFAULT 'user',
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `user_type`, `content`, `created_at`, `updated_at`) VALUES
(1, 9, 39, 'Organization', 'Quasi alias mollitia beatae ipsum itaque dolores id accusamus eligendi voluptatum ab et.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(2, 9, 48, 'User', 'Exercitationem cum commodi ullam autem dolor quod aspernatur.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(3, 9, 48, 'User', 'Vel quia maxime maiores ut ipsa id est cupiditate itaque fugit ratione maxime quia.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(4, 9, 30, 'User', 'Ab quia enim nulla quia fugiat quam.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(5, 9, 3, 'User', 'Temporibus nulla et vel architecto tempore id reiciendis a.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(6, 9, 44, 'User', 'Consequatur a nisi non provident doloribus est sint provident.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(7, 9, 22, 'User', 'Sint mollitia eaque adipisci optio laudantium molestiae aspernatur error quia.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(8, 9, 7, 'User', 'Enim fugit ipsum et praesentium quas veniam voluptates expedita adipisci repellat.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(9, 9, 46, 'User', 'Ut hic earum expedita ipsum velit quo.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(10, 9, 38, 'User', 'Ab nobis rerum in id aut quisquam tempore dicta eius aut.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(11, 9, 15, 'Organization', 'Consequuntur hic id ut magni magni molestiae.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(12, 9, 6, 'User', 'Voluptatibus aut eligendi ad sunt facere suscipit architecto quia aut distinctio.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(13, 9, 43, 'User', 'In possimus distinctio architecto et ratione quia et corrupti ipsam eos.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(14, 9, 32, 'User', 'Tempora ullam voluptatibus et sunt et aperiam consequatur.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(15, 9, 21, 'User', 'Magnam eius exercitationem perspiciatis consequuntur itaque nisi.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(16, 9, 18, 'User', 'Expedita enim perspiciatis fugit alias ratione id facilis id veritatis.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(17, 9, 7, 'User', 'Aliquid non alias totam voluptate fugiat omnis.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(18, 9, 36, 'User', 'Ut omnis alias corrupti nam non dolore aut molestiae.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(19, 9, 50, 'User', 'Quidem soluta cumque et animi facilis sunt illum sed.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(20, 9, 4, 'User', 'Voluptas tempora quod error itaque cupiditate architecto vitae nulla deserunt ea consequatur exercitationem quasi.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(21, 9, 43, 'Organization', 'Consequatur optio ipsum fugit consequatur corporis saepe debitis nisi totam placeat voluptatem.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(22, 9, 17, 'User', 'Possimus mollitia dolore enim iure ipsum iusto placeat dolorum explicabo rerum veritatis.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(23, 9, 31, 'User', 'Optio aspernatur tempora quis adipisci rerum non occaecati et.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(24, 9, 17, 'User', 'Accusamus velit nisi maiores voluptas ut est blanditiis nihil.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(25, 9, 25, 'User', 'Id nobis adipisci et velit fugit veritatis suscipit dolorum ut ea ullam tempora.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(26, 9, 1, 'Organization', 'Voluptatem dignissimos id cumque sequi veniam eos ipsa atque sed quam.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(27, 9, 40, 'User', 'Atque dolorem deserunt quia ducimus velit veritatis similique.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(28, 9, 49, 'User', 'Autem cupiditate adipisci sit sequi et repudiandae vero rem voluptatem placeat.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(29, 9, 32, 'Organization', 'Magnam laudantium quam aliquid molestias nostrum eum doloribus.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(30, 9, 46, 'Organization', 'Est expedita laudantium provident sed ad fugiat eius quia.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(31, 9, 17, 'Organization', 'Alias est deleniti aut rerum dignissimos explicabo occaecati cum et repudiandae ut.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(32, 9, 12, 'User', 'Aliquid nihil rem est corrupti debitis est voluptatem ad atque.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(33, 9, 32, 'User', 'Aut facilis omnis et corrupti tempore modi laboriosam ipsa debitis quia quia.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(34, 9, 10, 'Organization', 'Nisi maxime adipisci qui eum placeat consequatur nemo qui omnis nisi dignissimos ipsam alias.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(35, 9, 31, 'User', 'Odit cum totam iste laudantium fugit iure pariatur vitae voluptatibus magnam eum non beatae.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(36, 9, 37, 'User', 'Nihil eveniet quibusdam excepturi consequuntur tempore possimus rem at error voluptatem omnis impedit.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(37, 9, 4, 'User', 'Earum velit vitae distinctio culpa qui saepe dolore voluptatem doloribus.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(38, 9, 38, 'User', 'Sed eum ipsum est veritatis rerum possimus.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(39, 9, 49, 'Organization', 'Deleniti qui laboriosam rerum voluptas consequuntur laudantium.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(40, 9, 16, 'User', 'At earum possimus eligendi et repellendus debitis eius eum rerum dolorum esse qui ut.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(41, 9, 3, 'Organization', 'Impedit aut cumque qui distinctio numquam laborum.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(42, 9, 48, 'Organization', 'Aspernatur cum excepturi tempore minima fuga alias fugiat.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(43, 9, 18, 'Organization', 'Reiciendis hic amet reprehenderit autem exercitationem enim cum et est beatae velit.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(44, 9, 17, 'User', 'Architecto incidunt sunt adipisci dicta architecto omnis unde iure error eveniet.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(45, 9, 38, 'Organization', 'Unde id velit illum tempore dicta mollitia officiis.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(46, 9, 39, 'User', 'Sit vel saepe sunt optio corrupti maiores.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(47, 9, 15, 'User', 'Tempore aut repellat et et similique nesciunt cum beatae eaque sint fugiat magni autem.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(48, 9, 44, 'Organization', 'Libero repellendus dolor nesciunt soluta eius distinctio.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(49, 9, 33, 'Organization', 'Quia est tenetur reiciendis tempora eligendi voluptatem et facilis voluptatem fugiat eligendi.', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(50, 9, 49, 'Organization', 'Minus et asperiores dolores expedita praesentium at incidunt sint totam.', '2025-01-18 03:06:10', '2025-01-18 03:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `company_detailes`
--

CREATE TABLE `company_detailes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `whatsapp_number` text NOT NULL,
  `gmail_account` varchar(255) NOT NULL,
  `facebook_account` varchar(255) NOT NULL,
  `x_account` varchar(255) NOT NULL,
  `youtube_account` varchar(255) NOT NULL,
  `instgram_account` varchar(255) NOT NULL,
  `snapchat_account` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `about_ar` text NOT NULL,
  `about_en` text NOT NULL,
  `vision_ar` text NOT NULL,
  `vision_en` text NOT NULL,
  `goals_ar` text NOT NULL,
  `goals_en` text NOT NULL,
  `values_en` text NOT NULL,
  `values_ar` text NOT NULL,
  `show_map` tinyint(1) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `about_image` varchar(255) DEFAULT NULL,
  `vision_image` varchar(255) DEFAULT NULL,
  `goals_image` varchar(255) DEFAULT NULL,
  `values_image` varchar(255) DEFAULT NULL,
  `main_video` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_detailes`
--

INSERT INTO `company_detailes` (`id`, `whatsapp_number`, `gmail_account`, `facebook_account`, `x_account`, `youtube_account`, `instgram_account`, `snapchat_account`, `image`, `about_ar`, `about_en`, `vision_ar`, `vision_en`, `goals_ar`, `goals_en`, `values_en`, `values_ar`, `show_map`, `address`, `about_image`, `vision_image`, `goals_image`, `values_image`, `main_video`, `created_at`, `updated_at`) VALUES
(1, '+966435345345343', 'acouunt@gmail.com', 'acounnt@facbook.coms', 'acouunt.x.com', 'account.youtube.com', 'account.instgram.com', 'account.sanpchat.com', NULL, 'نحن ملتزمون بتقديم أحدث حلول الجمال لضمان شعورك بالثقة والتألق كل يوم. يجمع فريقنا بين الخبرة والشغف لمساعدتك في تحقيق مظهرك المثالي', 'We are dedicated to providing cutting-edge beauty solutions, ensuring you feel confident and radiant every day. Our team combines expertise with a passion for helping you achieve your desired look.', 'أن نكون المزود الرائد لحلول الجمال الشخصية، ونلهم الثقة والتعبير عن الذات من خلال الابتكار والخبرة.', 'To be the leading provider of personalized beauty solutions, inspiring confidence and self-expression through innovation and expertise.', 'هدفنا هو وضع معايير جديدة في مجال العناية الشخصية والجمال، من خلال تقديم حلول مبتكرة تمكّن عملاءنا من الشعور بأفضل حالاتهم وتحقيق مظهرهم المثالي.', 'Our goal is to set a new standard in personal care and beauty, offering innovative solutions that empower our clients to look and feel their best.', 'We are committed to enhancing beauty and confidence through personalized care, advanced techniques, and a dedication to excellence.', 'نحن ملتزمون بتحسين الجمال والثقة من خلال العناية الشخصية، التقنيات المتقدمة، والالتزام بالتميز', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-16 01:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('pending','reviewed','closed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Janelle Schoen', 'eli.mcclure@example.net', '1-620-831-5669', NULL, 'Rerum modi quo quia sed est exercitationem.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(2, 'Johan Walker', 'hoppe.marian@example.net', '+1 (231) 530-2416', NULL, 'Itaque nobis impedit nulla vero alias ipsam quia.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(3, 'Olen Koss', 'smills@example.com', '+16602521543', NULL, 'Aut quo id ut veritatis exercitationem ipsum.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(4, 'Ms. Lilliana Walsh IV', 'rene11@example.org', '+1 (763) 749-0954', NULL, 'Qui fuga hic reprehenderit saepe est possimus sint qui.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(5, 'Tristin Kautzer', 'obie00@example.net', '+1 (930) 450-5604', NULL, 'Possimus esse consequatur et similique quasi qui.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(6, 'Roselyn Kirlin', 'lynch.bailee@example.com', '+1 (502) 312-0887', NULL, 'Ea odio repellendus ipsum at aut laboriosam.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(7, 'Johnathan Hahn', 'gdooley@example.com', '561-912-2002', NULL, 'Ab assumenda eius non exercitationem doloribus distinctio cum sed exercitationem repudiandae ea.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(8, 'Forrest Towne IV', 'xlebsack@example.com', '248-271-7581', NULL, 'Molestiae voluptate consequatur eius et occaecati beatae non in aliquid est.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(9, 'Westley Murphy', 'htorp@example.net', '510-358-6647', NULL, 'In vitae culpa illum velit tenetur consequatur iste sit voluptatibus veritatis maiores.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(10, 'Mr. Albin Hudson PhD', 'fbernhard@example.com', '+1 (904) 753-0842', NULL, 'Cumque corporis minus magnam corrupti et laboriosam quis sequi mollitia aut quo quo quibusdam.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(11, 'Dr. Adrien Mosciski', 'raven07@example.org', '+1 (562) 451-0983', NULL, 'Omnis porro porro omnis eum quae aut deserunt voluptatem.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(12, 'Cary Howell', 'cole.coty@example.org', '+13867497412', NULL, 'Eos sunt provident fuga explicabo quo dolores quas corrupti excepturi nulla quae.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(13, 'Prof. Twila Streich DVM', 'ppadberg@example.com', '351-554-1230', NULL, 'Laboriosam nobis neque autem maxime suscipit modi.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(14, 'Reba Lind', 'mflatley@example.com', '+1-469-545-6772', NULL, 'Et voluptatem maiores et nostrum provident occaecati non accusamus minima consequuntur ipsam et molestiae.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(15, 'Dr. Henderson Pacocha', 'kzulauf@example.com', '(610) 772-6699', NULL, 'Sed consequatur nobis nulla provident voluptas magni quaerat atque.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(16, 'Eldridge Gislason', 'jabbott@example.org', '(520) 486-9409', NULL, 'Libero facilis veritatis doloremque a doloremque corrupti natus omnis magnam perspiciatis dolor.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(17, 'Andy Considine', 'gloria65@example.com', '(640) 503-1127', NULL, 'Vel culpa nisi soluta libero est dolor sit quo.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(18, 'Cora Wintheiser', 'leannon.audrey@example.org', '740-908-1398', NULL, 'Atque voluptatum dolor non ut pariatur et sit magni aut.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(19, 'Evert Wiegand', 'freeda46@example.net', '1-814-482-9813', NULL, 'Hic ut temporibus dolorem asperiores eaque vitae veritatis doloribus consequatur.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(20, 'Van Olson PhD', 'marcelo91@example.org', '650-884-3745', NULL, 'Quis sunt velit eum magni quos velit accusantium dolorem fugit.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(21, 'Deanna Ryan', 'darron.towne@example.net', '801-401-5446', NULL, 'Vel provident exercitationem consequatur consequatur vitae eos explicabo est ab a impedit sit amet.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(22, 'Ella McDermott', 'hermiston.howell@example.com', '(337) 978-4531', NULL, 'Officia praesentium temporibus sit et et accusamus consequatur occaecati ducimus nostrum veniam ea.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(23, 'April Murphy', 'jaime62@example.net', '+12127643753', NULL, 'Sint qui voluptas ipsam ratione molestias qui neque quasi sequi et modi.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(24, 'Ladarius Sipes', 'landen.okon@example.com', '+1.534.266.2453', NULL, 'Explicabo officiis totam dolores quo totam eius repudiandae optio aliquam labore non consequatur neque ipsam.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(25, 'Elena Waters', 'herman.kay@example.net', '661-541-2674', NULL, 'Facere est non consequuntur occaecati facilis asperiores voluptas exercitationem voluptatem.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(26, 'Carmela Bernier', 'mcglynn.leora@example.com', '1-657-756-3130', NULL, 'Facere autem atque explicabo totam voluptates nisi.', 'reviewed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(27, 'Raul Beer', 'astark@example.org', '520.205.0017', NULL, 'Qui dicta voluptate magnam amet reiciendis necessitatibus sit.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(28, 'Ms. Ada Kessler', 'isabell97@example.net', '+1.954.683.9402', NULL, 'Optio nobis possimus et sequi quos aut molestias et deleniti dolores quam officia.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(29, 'Cordia Torp', 'mayer.elmo@example.com', '+1.312.227.8710', NULL, 'Voluptate possimus enim sit sint consequatur quasi pariatur incidunt sed nulla.', 'closed', '2025-01-18 03:06:10', '2025-01-18 03:06:10'),
(30, 'Montana Fisher', 'korey.macejkovic@example.com', '+1 (972) 530-5647', NULL, 'Perferendis cumque facere dolore consequatur deleniti dolorem fuga aut.', 'pending', '2025-01-18 03:06:10', '2025-01-18 03:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `participant_one_id` bigint(20) UNSIGNED NOT NULL,
  `participant_one_type` varchar(100) NOT NULL,
  `participant_two_id` bigint(20) UNSIGNED NOT NULL,
  `participant_two_type` varchar(100) NOT NULL,
  `deleted_by` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`deleted_by`)),
  `blocked_by` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`blocked_by`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `participant_one_id`, `participant_one_type`, `participant_two_id`, `participant_two_type`, `deleted_by`, `blocked_by`, `created_at`, `updated_at`) VALUES
(2, 52, 'User', 20, 'Organization', NULL, NULL, '2025-01-10 10:13:15', '2025-01-10 10:18:25'),
(3, 51, 'User', 1, 'User', NULL, '[]', '2025-01-26 00:40:01', '2025-01-26 00:58:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footers`
--

CREATE TABLE `footers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `list1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`list1`)),
  `list2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`list2`)),
  `list3` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`list3`)),
  `list4` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`list4`)),
  `list5` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`list5`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footers`
--

INSERT INTO `footers` (`id`, `list1`, `list2`, `list3`, `list4`, `list5`, `created_at`, `updated_at`) VALUES
(1, '\"[{\\\"name\\\":\\\"Home\\\",\\\"url\\\":\\\"\\\\\\/home\\\"},{\\\"name\\\":\\\"About Us\\\",\\\"url\\\":\\\"\\\\\\/about\\\"},{\\\"name\\\":\\\"Contact\\\",\\\"url\\\":\\\"\\\\\\/contact\\\"}]\"', '\"[{\\\"name\\\":\\\"Services\\\",\\\"url\\\":\\\"\\\\\\/services\\\"},{\\\"name\\\":\\\"Portfolio\\\",\\\"url\\\":\\\"\\\\\\/portfolio\\\"},{\\\"name\\\":\\\"Careers\\\",\\\"url\\\":\\\"\\\\\\/careers\\\"}]\"', '\"[{\\\"name\\\":\\\"Blog\\\",\\\"url\\\":\\\"\\\\\\/blog\\\"},{\\\"name\\\":\\\"News\\\",\\\"url\\\":\\\"\\\\\\/news\\\"},{\\\"name\\\":\\\"Press\\\",\\\"url\\\":\\\"\\\\\\/press\\\"}]\"', '\"[{\\\"name\\\":\\\"Privacy Policy\\\",\\\"url\\\":\\\"\\\\\\/privacy-policy\\\"},{\\\"name\\\":\\\"Terms of Service\\\",\\\"url\\\":\\\"\\\\\\/terms\\\"},{\\\"name\\\":\\\"Support\\\",\\\"url\\\":\\\"\\\\\\/support\\\"}]\"', '\"[{\\\"name\\\":\\\"FAQ\\\",\\\"url\\\":\\\"\\\\\\/faq\\\"},{\\\"name\\\":\\\"Help Center\\\",\\\"url\\\":\\\"\\\\\\/help-center\\\"},{\\\"name\\\":\\\"Contact Sales\\\",\\\"url\\\":\\\"\\\\\\/contact-sales\\\"}]\"', '2025-01-13 04:03:47', '2025-01-13 04:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mainpages`
--

CREATE TABLE `mainpages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_screen` tinyint(1) DEFAULT NULL,
  `video` longtext DEFAULT NULL,
  `main_text_en` varchar(255) DEFAULT NULL,
  `main_text_ar` varchar(255) DEFAULT NULL,
  `second_text_en` text DEFAULT NULL,
  `second_text_ar` text DEFAULT NULL,
  `third_text_en` text DEFAULT NULL,
  `third_text_ar` text DEFAULT NULL,
  `forth_text_en` text DEFAULT NULL,
  `forth_text_ar` text DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `image_2` longtext DEFAULT NULL,
  `bg_color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mainpages`
--

INSERT INTO `mainpages` (`id`, `main_screen`, `video`, `main_text_en`, `main_text_ar`, `second_text_en`, `second_text_ar`, `third_text_en`, `third_text_ar`, `forth_text_en`, `forth_text_ar`, `image`, `image_2`, `bg_color`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Access Trusted Medical Information', 'احصل على معلومات طبية موثوقة', 'Explore expert advice from top healthcare professionals.', 'استكشف نصائح الخبراء من أفضل المتخصصين في الرعاية الصحية.', 'Learn about treatments, wellness tips, and more!', 'تعرف على العلاجات، نصائح العناية الصحية، والمزيد!', 'Empower yourself with knowledge to make informed decisions.', 'قم بتمكين نفسك بالمعلومات لاتخاذ قرارات مستنيرة.', 'http://127.0.0.1:8000/images/about/service_6.jpg', 'http://127.0.0.1:8000/images/about/service_6.jpg', NULL, NULL, NULL),
(2, 1, 'http://127.0.0.1:8000/video/mainpage/about_video_678b3b4e2c638.mp4', 'Committed to Your Health and Well-being', 'ملتزمون بصحتك ورفاهيتك', 'Our platform connects you with top medical professionals and trusted healthcare resources, empowering you to make informed decisions about your health.', 'منصتنا تربطك بأفضل المتخصصين الطبيين ومصادر الرعاية الصحية الموثوقة، لنمكنك من اتخاذ قرارات مستنيرة بشأن صحتك.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-18 03:27:53'),
(3, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-18 03:27:53');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `email`, `created_at`, `updated_at`) VALUES
(4, 'failloser1@gmail.com', '2025-01-17 11:28:40', '2025-01-17 11:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` varchar(255) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `message_type` enum('text','image','audio') NOT NULL DEFAULT 'text',
  `is_read` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '0',
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `sender_type`, `content`, `file_path`, `message_type`, `is_read`, `conversation_id`, `created_at`, `updated_at`) VALUES
(58, 52, 'User', 'أهلا', NULL, 'text', '1', 2, '2025-01-10 10:18:08', '2025-01-10 10:26:34'),
(59, 52, 'User', 'كيف الحال', NULL, 'text', '1', 2, '2025-01-10 10:18:18', '2025-01-10 10:26:34'),
(60, 51, 'User', 'Hi', NULL, 'text', '1', 3, '2025-01-26 00:40:43', '2025-01-26 00:57:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_02_112758_create_service_categories_table', 1),
(5, '2024_11_03_110712_create_artical_categories_table', 1),
(6, '2024_11_09_064658_create_card_types_table', 1),
(7, '2024_11_10_133100_create_personal_access_tokens_table', 1),
(8, '2024_11_10_134644_create_categories_table', 1),
(9, '2024_11_10_134740_create_testimonials_table', 1),
(10, '2024_11_10_134752_create_sliders_table', 1),
(11, '2024_11_10_134838_create_payments_table', 1),
(12, '2024_11_19_072748_create_blogs_table', 1),
(13, '2024_11_19_073641_create_comments_table', 1),
(14, '2024_11_19_134443_create_organizations_table', 1),
(15, '2024_11_19_142513_create_company_detailes_table', 1),
(16, '2024_11_20_061453_create_arma__cards_table', 1),
(17, '2024_11_20_181906_create_contact_messages_table', 1),
(18, '2024_11_20_183508_create_services_table', 1),
(19, '2024_11_20_192212_create_subscribers_table', 1),
(20, '2024_12_05_064404_create_mainpages_table', 1),
(21, '2024_12_11_110143_create_members_table', 1),
(22, '2024_12_11_184240_create_privacy_policy_users_table', 1),
(23, '2024_12_11_184357_create_privacy_policy_organizations_table', 1),
(24, '2024_12_11_185127_create_terms_condition_organizations_table', 1),
(25, '2024_12_11_185138_create_terms_condition_users_table', 1),
(26, '2024_12_15_055017_create_provisional_data_table', 1),
(27, '2024_12_15_084805_create_reactions_table', 1),
(28, '2024_12_15_105955_create_bells_table', 1),
(29, '2024_12_16_060801_user_article_reaction', 1),
(30, '2024_12_16_064821_article_reaction_counts', 1),
(31, '2024_12_29_110553_create_books_table', 2),
(32, '2025_01_03_072440_create_notifications_table', 3),
(33, '2025_01_06_060652_create_conversations_table', 4),
(34, '2025_01_06_060708_create_messages_table', 4),
(35, '2025_01_06_061515_create_participants_table', 4),
(36, '2025_01_08_105621_create_blocked_users_table', 5),
(37, '2025_01_13_060059_create_footers_table', 6),
(38, '2025_01_21_015733_create_affiliate_services_table', 7),
(39, '2025_01_21_030426_create_offers_table', 1),
(40, '2025_01_25_144516_create_question__answers_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `account_type`, `is_read`, `user_id`, `created_at`, `updated_at`) VALUES
(49, 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', 'user', 1, 51, '2025-01-05 08:02:36', '2025-01-13 02:57:46'),
(50, 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', 'user', 1, 52, '2025-01-05 09:02:05', '2025-01-06 06:27:30'),
(51, 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', 'user', 1, 52, '2025-01-05 09:06:02', '2025-01-06 06:27:30'),
(52, 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', 'user', 1, 52, '2025-01-05 09:16:29', '2025-01-06 06:27:30'),
(53, 'تم إرسال طلب جديد اليك من ahmed', 'organization', 0, 23, '2025-01-05 09:27:00', '2025-01-05 09:27:00'),
(54, 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'user', 1, 51, '2025-01-05 09:28:51', '2025-01-13 02:57:46'),
(55, 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', 'user', 1, 51, '2025-01-05 09:29:19', '2025-01-13 02:57:46'),
(56, 'تم إرسال طلب جديد اليك من Alberta Rohan III', 'organization', 0, 23, '2025-01-09 16:51:51', '2025-01-09 16:51:51'),
(57, 'تم إرسال طلب جديد اليك من ahmed-2', 'organization', 1, 20, '2025-01-10 09:55:59', '2025-01-14 00:58:32'),
(58, 'تم إرسال طلب جديد اليك من ahmed-2', 'organization', 1, 20, '2025-01-10 10:01:46', '2025-01-14 00:58:32'),
(59, 'تم إرسال طلب جديد اليك من ahmed-2', 'organization', 1, 20, '2025-01-10 10:02:08', '2025-01-14 00:58:32'),
(60, 'تم إرسال طلب جديد اليك من ahmed-2', 'organization', 1, 20, '2025-01-10 10:03:05', '2025-01-14 00:58:32'),
(61, 'تم إرسال طلب جديد اليك من ahmed-2', 'organization', 1, 20, '2025-01-10 10:03:41', '2025-01-14 00:58:32'),
(62, 'sdfafgsfgvfsdgfsdgfdgfdgssfdgffdsdfgfdgfdfgdg', 'User', 1, 51, '2025-01-13 02:56:42', '2025-01-13 02:57:46'),
(63, 'aasdasdasdasdasd', 'User', 0, 44, '2025-01-13 02:59:57', '2025-01-13 02:59:57'),
(64, 'asdasdasdasd', 'User', 0, 19, '2025-01-13 03:02:51', '2025-01-13 03:02:51'),
(65, 'asdafdsfafasdasasasassadassaa', 'Organization', 0, 18, '2025-01-13 03:37:36', '2025-01-13 03:37:36'),
(66, 'تم إرسال طلب جديد اليك من ahmed-2', 'organization', 1, 20, '2025-01-13 07:43:39', '2025-01-14 00:58:32'),
(67, 'تم إرسال طلب جديد اليك من Alexandre Kemmer II', 'organization', 0, 20, '2025-01-14 08:56:22', '2025-01-14 08:56:22'),
(68, 'تمت الموافقة على نشر الخدمة بعنوان asdasdas بنجاح!', 'Organization', 0, 20, '2025-01-25 12:57:43', '2025-01-25 12:57:43'),
(69, 'تمت الموافقة على نشر الخدمة بعنوان asdasdas بنجاح!', 'Organization', 0, 20, '2025-01-25 12:59:00', '2025-01-25 12:59:00'),
(70, 'تمت الموافقة على نشر الخدمة بعنوان asdasdas بنجاح!', 'Organization', 0, 20, '2025-01-25 13:01:34', '2025-01-25 13:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `number_of_uses` int(11) DEFAULT 0,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `title_ar`, `title_en`, `image`, `description_ar`, `description_en`, `code`, `discount_value`, `start_date`, `number_of_uses`, `end_date`, `is_active`, `organization_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'عرض et', 'Offer esse', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-02.jpg', 'Consequatur eum accusantium adipisci quidem quam. Quasi qui qui repellendus magnam.', 'Asperiores autem labore numquam est soluta vero quae. Accusamus commodi fugit delectus alias odit odio. Et sed ad id dolor aperiam earum cupiditate recusandae. Laudantium pariatur rem corrupti eveniet.', 'OFF14201', 7.99, '2025-01-02', 43, '2025-02-26', 1, 8, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(2, 'عرض repellat', 'Offer est', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-03_676183f92d229.jpg', 'Aut dolores magni voluptatem itaque at. A ut earum amet culpa. Aut accusantium facilis aut saepe.', 'Voluptatum facere ullam id consequatur dolores voluptas a. Unde rerum tempora doloribus nihil ea ipsum mollitia. Omnis dolorem repellat dolores voluptatibus.', 'OFF42256', 23.24, '2025-01-19', 0, '2025-02-20', 0, 8, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(3, 'عرض sed', 'Offer minus', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-02.jpg', 'Impedit doloribus nobis repudiandae. Necessitatibus quae cumque inventore voluptatem ut dolore qui. Ratione est tenetur ex dolorem qui. Veniam repudiandae quo dolores neque sed pariatur. Sed et dolores odio quia nam molestias.', 'Ullam consectetur dolorem quod hic. Aspernatur est aliquid sed. Maiores reprehenderit sequi doloremque consectetur.', 'OFF29519', 28.25, '2024-12-26', 0, '2025-02-15', 1, 8, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(4, 'عرض ea', 'Offer quo', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-02.jpg', 'Itaque omnis expedita molestiae quia doloremque eum. Debitis facilis quis assumenda consequuntur. Et incidunt dolorum ipsum et eveniet veritatis sapiente.', 'Blanditiis facere qui id impedit sequi ipsum qui. Sint eligendi quae et dolorem consequatur. Voluptatum ea et consectetur minima nesciunt quam.', 'OFF70607', 30.67, '2025-01-26', 0, '2025-02-23', 1, 1, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(5, 'عرض facilis', 'Offer non', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Recusandae suscipit quia qui velit. Ullam labore ea sunt voluptatum. Voluptatibus pariatur quas repellat quisquam neque.', 'Accusantium placeat impedit laborum veritatis nulla hic. Ut impedit exercitationem error consequatur voluptatibus. Dignissimos vero vero necessitatibus enim error occaecati ipsum. In quo ipsum atque molestiae illo rerum unde. Aspernatur nisi cumque voluptas iure est et porro ut.', 'OFF17653', 31.08, '2025-01-26', 45, '2025-02-05', 0, 21, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(6, 'عرض magni', 'Offer vitae', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Cum quia at aut rerum quia voluptas. Possimus animi harum exercitationem voluptas nihil enim. At repellendus quidem quia cupiditate voluptatem earum sit. Quia quis molestiae qui.', 'Enim aspernatur magni impedit incidunt. Ullam labore occaecati voluptas perspiciatis. Aut temporibus amet magni et exercitationem est fugit. Perspiciatis nobis molestias optio est tempore assumenda soluta.', 'OFF65968', 44.71, '2024-12-31', 0, '2025-02-15', 1, 20, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(7, 'عرض ut', 'Offer sunt', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Ratione sed asperiores inventore eos et ipsam est eos. Eveniet magnam unde quos in quam. Placeat repudiandae voluptates incidunt magnam commodi enim itaque. Maiores quis fuga laborum voluptatem.', 'Ut qui modi sapiente nulla fugiat. Nihil dolor ut itaque molestias exercitationem quod perferendis. Aut magni blanditiis in et error. Debitis non nostrum ipsam dolore beatae provident molestiae.', 'OFF57379', 34.90, '2024-12-26', 0, '2025-02-18', 1, 3, 10, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(8, 'عرض id', 'Offer omnis', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-02.jpg', 'Et nesciunt ratione ut ea iusto. Numquam fuga facilis fugit dolor optio omnis iste illo.', 'Recusandae debitis tempore consequatur qui. Et impedit eos ipsum error et quo sint et. Expedita aut similique necessitatibus mollitia consequatur tempore. Porro est sit nesciunt ratione dolor ipsam soluta.', 'OFF64913', 7.21, '2025-01-11', 0, '2025-02-06', 1, 2, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(9, 'عرض magni', 'Offer quod', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Enim esse eius id veniam quia dolorem deserunt. Quae ex dolore magnam doloribus doloremque error. Ab fugit ut eius aspernatur eum est iste.', 'Distinctio aut ut aut est. Dolore sint enim voluptatem voluptas in reprehenderit. Ipsa ea ipsa ab expedita consequatur. Saepe qui harum et quo doloremque nam laudantium.', 'OFF32143', 9.96, '2025-01-07', 34, '2025-02-05', 1, 10, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(10, 'عرض iusto', 'Offer minima', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Eaque voluptatibus quo laborum aut sit accusamus aut. Rem quia id at quia hic dolorem. Excepturi quia sapiente iste consequatur repellat est excepturi.', 'Eveniet fugiat iste non et. Porro ex quia necessitatibus magnam. Ut dolores quo alias laborum molestiae quia.', 'OFF39423', 38.22, '2025-01-25', 34, '2025-02-10', 1, 20, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(11, 'عرض cum', 'Offer nesciunt', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Consectetur harum reprehenderit molestiae voluptatibus nihil non totam. Minus aut quia velit exercitationem. Suscipit ut voluptatibus consequuntur eaque ducimus non repellendus. Perferendis et itaque quod sit harum facere. Ut alias voluptas ut repellendus.', 'Animi accusamus minus reiciendis harum saepe. Facilis laborum totam qui quibusdam. Deleniti neque in suscipit nihil est voluptatem. Sapiente explicabo laborum et ipsum placeat a natus voluptates.', 'OFF53525', 38.82, '2025-01-03', 0, '2025-02-25', 1, 8, 14, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(12, 'عرض aliquid', 'Offer doloribus', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-03_676183f92d229.jpg', 'Consequuntur nemo tempore facere et sit. Exercitationem quo est est doloribus. Non dolorum officia modi ex.', 'Quod cumque soluta placeat alias aut. Reprehenderit laudantium assumenda cupiditate in eligendi doloribus.', 'OFF04285', 9.98, '2025-01-07', 0, '2025-02-15', 1, 9, 8, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(13, 'عرض velit', 'Offer hic', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Repellendus velit quas et commodi non reprehenderit et. Recusandae ut voluptatem atque saepe maiores.', 'Voluptas non rerum consequatur odio. Molestiae delectus eligendi delectus ad ipsa. Beatae id illum ducimus culpa. Soluta natus assumenda et nesciunt laborum inventore est illum.', 'OFF76679', 46.91, '2025-01-09', 0, '2025-02-01', 0, 21, 11, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(14, 'عرض incidunt', 'Offer qui', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-02.jpg', 'Molestiae ea ut facilis blanditiis unde laborum et amet. Adipisci excepturi ut ut delectus sunt laborum corporis. Consequatur molestias aut voluptatum voluptatem vero repellat. Et est accusantium mollitia dolor.', 'Cupiditate aliquam voluptatem ipsam et quam. Recusandae quibusdam ab doloribus asperiores totam delectus. Nam et at est aliquam dolorem libero.', 'OFF15758', 37.10, '2025-01-21', 0, '2025-01-30', 1, 22, 14, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(15, 'عرض suscipit', 'Offer omnis', 'https://datafromapi.aramgulfunited.com/public/images/offers/service_6.jpg', 'Sit distinctio officia voluptatem sunt. Officiis occaecati sed quia sit. Sit quod molestiae perferendis et beatae.', 'Culpa dolorum aut minima. Et quibusdam consequatur autem sed rerum. Et voluptatem et vel tempore. Qui magnam iusto qui saepe voluptatem laborum.', 'OFF47198', 44.90, '2025-01-23', 0, '2025-02-13', 1, 21, 8, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(16, 'عرض ullam', 'Offer vitae', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-02.jpg', 'Omnis excepturi ut atque qui aut. Exercitationem at voluptas unde ut. Necessitatibus adipisci magni ut maiores est quo deserunt. Consequatur omnis omnis dolorum sint voluptatem delectus recusandae.', 'Nemo ut sunt voluptatibus sequi ipsam voluptatem labore expedita. Omnis sed ipsum voluptas velit rerum quam temporibus. Mollitia officia est est sed reiciendis voluptatem. Quasi sint aliquid illum quasi et explicabo fuga.', 'OFF89288', 26.78, '2025-01-13', 0, '2025-02-11', 1, 18, 5, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(17, 'عرض aperiam', 'Offer asperiores', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-03_676183f92d229.jpg', 'Doloribus corporis enim possimus sint nobis cum. Officia sunt officiis mollitia.', 'Et quis dolorum quibusdam asperiores et ratione consequatur dignissimos. Est qui saepe omnis nobis corrupti vel provident et.', 'OFF22802', 45.16, '2025-01-09', 0, '2025-02-24', 1, 12, 10, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(18, 'عرض aut', 'Offer modi', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-03_676183f92d229.jpg', 'Neque qui incidunt dolor id molestias porro. Voluptas voluptas rerum ducimus iure. Omnis repellat suscipit sunt. Quo asperiores neque voluptatem. Soluta dolores rerum non quia enim.', 'Et odit facilis quia autem tempore eos. Et et velit non sed libero voluptas ex. Deleniti et vero ex facilis. Ut sed quidem perspiciatis natus rerum veritatis aspernatur nam. Vero repudiandae veritatis minima beatae consequatur vel quia est.', 'OFF90747', 42.27, '2025-01-16', 34, '2025-01-31', 1, 8, 6, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(19, 'عرض aut', 'Offer ratione', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-03_676183f92d229.jpg', 'Doloremque animi nobis quia ut et tempora. Voluptas ex vel occaecati praesentium dolorum et.', 'Ullam ullam magnam dignissimos sequi repellendus quibusdam provident. Praesentium numquam hic minus esse officiis quod neque dolorum. Nisi ducimus eligendi saepe labore quia blanditiis quaerat. Inventore rerum unde sed et velit quia alias.', 'OFF71940', 18.50, '2025-01-05', 0, '2025-02-19', 0, 7, 18, '2025-01-26 18:11:25', '2025-01-26 18:11:25'),
(20, 'عرض aliquam', 'Offer magnam', 'https://datafromapi.aramgulfunited.com/public/images/offers/service-02.jpg', 'Dolore et libero aut doloribus dolore nisi. Sint occaecati quis ut quas. Voluptas sit dignissimos modi error odio sunt dolor eaque. Ipsam voluptas omnis autem fuga voluptas enim.', 'Aut aliquam maiores harum sequi nam cum. Omnis cum ea qui nam ea ut aut. Consequatur porro eligendi quidem est eveniet cupiditate libero. Facere voluptas deleniti laborum voluptas est officiis.', 'OFF07966', 19.49, '2025-01-22', 0, '2025-02-11', 1, 5, 13, '2025-01-26 18:11:25', '2025-01-26 18:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `description_ar` longtext NOT NULL,
  `description_en` longtext NOT NULL,
  `features` longtext DEFAULT NULL,
  `accaptable_message` text DEFAULT 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!',
  `unaccaptable_message` text DEFAULT 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.',
  `phone_number` varchar(255) NOT NULL,
  `confirmation_price` decimal(10,0) DEFAULT 20,
  `location` longtext DEFAULT '{"address":"21, شارع السيد رسلان, محمد جعيصه, الغربية, 31521, مصر","latitude":30.8051968,"longitude":30.998528}',
  `open_at` varchar(255) DEFAULT NULL,
  `close_at` varchar(255) DEFAULT NULL,
  `url` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `categories_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '"[\\"15\\",\\"11\\",\\"7\\",\\"6\\",\\"10\\"]"' CHECK (json_valid(`categories_ids`)),
  `confirmation_status` tinyint(1) DEFAULT 0,
  `account_type` varchar(50) DEFAULT 'Organization',
  `number_of_reservations` int(11) DEFAULT 0,
  `is_signed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `email`, `password`, `title_ar`, `title_en`, `description_ar`, `description_en`, `features`, `accaptable_message`, `unaccaptable_message`, `phone_number`, `confirmation_price`, `location`, `open_at`, `close_at`, `url`, `image`, `icon`, `active`, `categories_ids`, `confirmation_status`, `account_type`, `number_of_reservations`, `is_signed`, `created_at`, `updated_at`) VALUES
(1, 'abdullah80@example.com', '$2y$12$qgULkiglhuIZ4jg4Rwv/5e/95GUZeVCSH8ZEJO1rKfND0qum/jnIG', 'مركز الطب العام', 'General Medicine Center', 'مركز يقدم خدمات الطب العام لجميع الأعمار.', 'A center offering general medicine services for all ages.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345678', 20, '{\"address\":\"17, شارع الكيلانى, كفر عنان, الغربية, 31641, مصر\",\"latitude\":30.7050241,\"longitude\":31.2504642}', '08:00 AM', '04:00 PM', 'http://www.rabee.info/', 'http://127.0.0.1:8000/images/organizations/images/service_6_676e9524ac256.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 1, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:04', '2025-01-20 01:13:23'),
(2, 'mohammad.abbad@example.net', '$2y$12$qgULkiglhuIZ4jg4Rwv/5e/95GUZeVCSH8ZEJO1rKfND0qum/jnIG', 'مركز الأسنان', 'Dental Center', 'مركز متكامل لطب الأسنان وجراحة الفم.', 'A comprehensive center for dental care and oral surgery.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345679', 20, '{\"address\":\"5, حارة المغربي, محمد طه, طنطا, الغربية, 31515, مصر\",\"latitude\":30.7888128,\"longitude\":31.0018048}', '09:00 AM', '05:00 PM', 'http://www.nimry.biz/aut-id-eos-dolorem-minima-dolorem-aut-dolore-quo', 'http://127.0.0.1:8000/images/organizations/images/service-02_675bc532eed30.jpg', 'http://127.0.0.1:8000/images/organizations/icons/20241203143808.png', 1, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 1, 'Organization', 0, 0, '2025-01-18 03:06:05', '2025-01-19 11:04:34'),
(3, 'abd.zaloum@example.net', '$2y$12$ZUOhi9uPNF/QBwzctQ8shugD4gRsz0cj9NNuXqt8FfSU8MOdAeIfK', 'مركز الأمراض الجلدية', 'Dermatology Center', 'مركز متخصص في علاج الأمراض الجلدية.', 'A center specializing in dermatological treatments.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345680', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:30 AM', '04:30 PM', 'https://rashwani.com/dolor-incidunt-deserunt-sint-nam-fugiat.html', 'http://127.0.0.1:8000/images/organizations/images/20241208115616.jpg', 'http://127.0.0.1:8000/images/organizations/icons/20241203143808.png', 1, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:05', '2025-01-18 03:06:05'),
(4, 'maanee.omar@example.org', '$2y$12$/h3Q2KMUBtIKe5OOg3fFCOH.QeAuJ24CByDvBDj1y1cKS7gtZe7mi', 'مركز العيون', 'Ophthalmology Center', 'مركز متقدم لعلاج أمراض العيون.', 'An advanced center for eye care.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345681', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:00 AM', '02:00 PM', 'http://hasan.org/', 'http://127.0.0.1:8000/images/organizations/images/20241204121338.jpg', 'http://127.0.0.1:8000/images/organizations/icons/20241203143808.png', 1, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:05', '2025-01-18 03:06:05'),
(5, 'melhem.osama@example.com', '$2y$12$aBH6K8qH1BXS3Qs22/ngiumVuSwkmV2QfB.BIZWUXo1tPLU9SRJMG', 'مركز النساء والتوليد', 'Obstetrics and Gynecology Center', 'مركز يقدم خدمات النساء والتوليد.', 'A center offering obstetrics and gynecology services.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345682', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '09:00 AM', '03:00 PM', 'http://abulebbeh.org/', 'http://127.0.0.1:8000/images/organizations/images/20241204121338.jpg', 'http://127.0.0.1:8000/images/organizations/icons/facebook_6781009e548b1.png', 1, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:05', '2025-01-18 03:06:05'),
(6, 'saleem03@example.org', '$2y$12$1MTkV7D9MM7.eNfjQ5nnUOmvX8IeWphxvVZfGWaMfIQw4Jk1qR5a.', 'مركز العلاج الطبيعي', 'Physical Therapy Center', 'مركز متخصص في العلاج الطبيعي والتأهيل.', 'A center specialized in physical therapy and rehabilitation.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345683', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '07:30 AM', '04:30 PM', 'http://www.karam.sa/', 'http://127.0.0.1:8000/images/organizations/images/20241207191900.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:06', '2025-01-18 03:06:06'),
(7, 'rashwani.saleem@example.net', '$2y$12$Ct1HWbXyXL.QQK72qchQMuHzvH7Ia59qnaxRKAU.9aRY01LwFkVZC', 'مركز أمراض القلب', 'Cardiology Center', 'مركز متخصص في علاج أمراض القلب.', 'A center specialized in treating heart diseases.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345684', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:00 AM', '06:00 PM', 'http://www.shami.biz/necessitatibus-dolore-qui-inventore-ea-dolor-optio-dicta-vel', 'http://127.0.0.1:8000/images/organizations/images/20241204121338.jpg', 'http://127.0.0.1:8000/images/organizations/icons/20241203143808.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:06', '2025-01-18 03:06:06'),
(8, 'uqawasmee@example.com', '$2y$12$r8wTkBF9XYTDOf0v28DFBeJQ7kJBzqMr7/EAZFF.k/4sFBSUki.Xy', 'مركز الأورام', 'Oncology Center', 'مركز متخصص في علاج السرطان والأورام.', 'A center specializing in cancer and oncology treatments.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345685', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:00 AM', '03:00 PM', 'http://rabee.info/atque-quo-similique-sed-suscipit', 'http://127.0.0.1:8000/images/organizations/images/20241207191900.jpg', 'http://127.0.0.1:8000/images/organizations/icons/20241203143808.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:06', '2025-01-18 03:06:06'),
(9, 'jabbad@example.com', '$2y$12$ysYGyD9zevcS83lKpQ0qteEcZN7.xJv55.zBDYlfQKizhGYX5v9H.', 'مركز الأطفال', 'Pediatric Center', 'مركز متخصص في رعاية الأطفال.', 'A center specialized in pediatric care.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345686', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '09:00 AM', '04:00 PM', 'http://abbadi.sa/', 'http://127.0.0.1:8000/images/organizations/images/20241207191900.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:07', '2025-01-18 03:06:07'),
(10, 'layth.karam@example.net', '$2y$12$E2tPIsYerKHNrx4p4gac4.YODaB6pIAAc73XmAiuk3BeLnalaiLmu', 'مركز الطوارئ', 'Emergency Center', 'مركز الطوارئ لتقديم العناية العاجلة.', 'Emergency center for urgent care.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345687', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '24/7', '24/7', 'http://hamad.sa/nulla-autem-maiores-aut-sit', 'http://127.0.0.1:8000/images/organizations/images/20241208115616.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:07', '2025-01-18 03:06:07'),
(11, 'bashar.zaloum@example.com', '$2y$12$/Iqm2tVy855hkRh3LvhsoO/GiQioubhVHD9/2ekG9WcfZiHRwARNa', 'مركز المسالك البولية', 'Urology Center', 'مركز متخصص في علاج المسالك البولية.', 'A center specializing in urology.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345688', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:00 AM', '04:00 PM', 'http://abulebbeh.biz/', 'http://127.0.0.1:8000/images/organizations/images/service_6_676e9524ac256.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:07', '2025-01-18 03:06:07'),
(12, 'akram42@example.com', '$2y$12$lXevQExHDWbbTgDc6Q8vIOwdB..fwEhBwFfhWDkLpq.i/gGHrrM3G', 'مركز الغدد الصماء', 'Endocrinology Center', 'مركز متخصص في علاج أمراض الغدد الصماء.', 'A center specialized in endocrinology.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345689', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '09:00 AM', '05:00 PM', 'https://qasem.org/maxime-ipsum-aut-omnis-facilis.html', 'http://127.0.0.1:8000/images/organizations/images/20241208115616.jpg', 'http://127.0.0.1:8000/images/organizations/icons/facebook_6781009e548b1.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:07', '2025-01-18 03:06:07'),
(13, 'abbad.layth@example.com', '$2y$12$w1sI.G0UNz69Zag6r6ba6u392XZrtRw3/Q5pCOneLh3kA72sdWDJa', 'مركز الباطنة', 'Internal Medicine Center', 'مركز متخصص في علاج الأمراض الباطنية.', 'A center specializing in internal medicine.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345690', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:30 AM', '04:30 PM', 'http://www.nimry.net/', 'http://127.0.0.1:8000/images/organizations/images/service-02_675bc532eed30.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:08', '2025-01-18 03:06:08'),
(14, 'flefel.ibrahim@example.com', '$2y$12$lEXEs4DUbxFTHsHrqmFG/eJmQQltmXu0e6cHUpe.kJKwK0o12.lBe', 'مركز الأذن والأنف والحنجرة', 'ENT Center', 'مركز متخصص في أمراض الأذن والأنف والحنجرة.', 'A center specialized in ENT diseases.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345691', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:00 AM', '03:00 PM', 'http://melhem.info/est-non-sapiente-et-ipsam-ipsam-culpa-quisquam', 'http://127.0.0.1:8000/images/organizations/images/20241204121338.jpg', 'http://127.0.0.1:8000/images/organizations/icons/facebook_6781009e548b1.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:08', '2025-01-18 03:06:08'),
(15, 'hamad.khaled@example.org', '$2y$12$naqMqcLSDSufNqpvAIBpQuTsPpvQrTFGsMzoBiiYjvYInwf84X6wW', 'مركز جراحة العظام', 'Orthopedic Surgery Center', 'مركز متخصص في جراحة العظام.', 'A center specialized in orthopedic surgery.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345692', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '09:00 AM', '05:00 PM', 'https://www.hadi.net/nostrum-atque-nam-nemo-voluptatem-iure', 'http://127.0.0.1:8000/images/organizations/images/service_6_676e9524ac256.jpg', 'http://127.0.0.1:8000/images/organizations/icons/20241203143808.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:08', '2025-01-18 03:06:08'),
(16, 'fadi.karam@example.org', '$2y$12$W7J8//FQBl/6G5NLEW34PO6hpMWDGtrbkLHeUDhHyDMydHDiVMSE.', 'مركز الطب الرياضي', 'Sports Medicine Center', 'مركز متخصص في علاج الإصابات الرياضية.', 'A center specializing in sports injuries treatment.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345693', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '07:00 AM', '04:00 PM', 'https://qawasmee.info/adipisci-facilis-quia-quasi-ut.html', 'http://127.0.0.1:8000/images/organizations/images/service-02_675bc532eed30.jpg', 'http://127.0.0.1:8000/images/organizations/icons/facebook_6781009e548b1.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(17, 'abulebbeh.abdullah@example.net', '$2y$12$g9jhLUAvLapAcUbKxd1AJ.H1cPy6onrWjJ6FmwW1rfqV6nClKrdgC', 'مركز التحاليل الطبية', 'Medical Lab Center', 'مركز لإجراء التحاليل الطبية المخبرية.', 'A center for conducting medical laboratory tests.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345694', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:00 AM', '03:00 PM', 'http://rashwani.biz/eaque-unde-ut-laboriosam-dolorem-sunt-suscipit-accusantium', 'http://127.0.0.1:8000/images/organizations/images/service-02_675bc532eed30.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(18, 'akram.hasan@example.com', '$2y$12$mrHToOf5y0k1Ue2Scxk4FeVBvgFDZHcPpuEn6zr9DpviRBo3htlZ.', 'مركز الصيدلية', 'Pharmacy Center', 'مركز يحتوي على صيدلية تقدم الأدوية والعلاجات.', 'A center with a pharmacy offering medicines and treatments.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345695', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '08:00 ', '22:00 ', 'http://nimry.org/', 'http://127.0.0.1:8000/images/organizations/images/20241204121614.jpg', 'http://127.0.0.1:8000/images/organizations/icons/20241203143808.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(19, 'amr.nimry@example.org', '$2y$12$OQBcs1rA8g/I9dH8ER.Mwe6UZlCa4Pi5HEIGyDUBp7H6j/UINnmlq', 'مركز الصحة العامة', 'Public Health Center', 'مركز يقدم خدمات الصحة العامة الوقائية.', 'A center offering public health and preventive services.', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '0112345696', 20, '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', '09:00 AM', '05:00 PM', 'http://www.abbadi.sa/numquam-debitis-explicabo-quasi', 'http://127.0.0.1:8000/images/organizations/images/20241204121338.jpg', 'http://127.0.0.1:8000/images/organizations/icons/google_6778c7b74881a.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 0, 'Organization', 0, 0, '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(20, 'test-2@gmail.com', '$2y$12$zBHy0ry4ZNYUA4bQe/U19uP2wwFxUmRfQG.lToxKUvJ.MKkpTaWoG', 'test-2', 'test-2', 'test-2', 'test-2', NULL, 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '01322822323', 20, '{\"address\":\"27, شارع ثروت القديم, احمد الباجوري, طنطا, الغربية, 31515, مصر\",\"latitude\":30.7888128,\"longitude\":31.0083584}', '04:00', '18:00', 'http://www.rabee.info/', 'http://127.0.0.1:8000/images/organizations/images/service_3_6792edb5f0040.jpg', 'http://127.0.0.1:8000/images/organizations/icons/facebook_6792edb5f31cd.png', 0, '\"[\\\"15\\\",\\\"11\\\",\\\"7\\\",\\\"6\\\",\\\"10\\\"]\"', 1, 'Organization', 0, 0, '2025-01-23 22:03:26', '2025-01-23 23:32:37'),
(21, 'sadsad@bvn.com', '$2y$12$XXO4d9WWM8Uj1/oRyEE3X.mYNIGyxNI3qsUomMdOQLzYJGFt8sxu.', 'خدمة nostrum', 'خدمة nostrum', 'خدمة nostrum', 'خدمة nostrum', NULL, 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '01322822323', 20, '{\"address\":\"طريق القاهرة, الاسكندرية الزراعى, فخرى جعيصه, الغربية, 31749, مصر\",\"latitude\":30.7953664,\"longitude\":31.014912}', '08:01', '20:01', 'http://www.rabee.info/', 'http://127.0.0.1:8000/images/organizations/images/service_4_6795c17b5d93c.jpg', 'http://127.0.0.1:8000/images/organizations/icons/facebook_6795c17b64fee.png', 0, '\"[\\\"5\\\",\\\"2\\\",\\\"6\\\",\\\"9\\\",\\\"8\\\"]\"', 0, 'Organization', 0, 0, '2025-01-26 03:00:43', '2025-01-26 03:00:43'),
(22, 'asdads@gmail.com', '$2y$12$jFC1pX49MfY4vYt9r/4aKuapbkguEYbAMbH4.Hd31ydNMEFB9eu.S', 'خدمة nostrum', 'خدمة nostrum', 'خدمة nostrum', 'خدمة nostrum', '[\"asdasdasdasd\",\"asdasdasd\",\"asdsadasd\",\"asdasdasd\"]', 'تم تأكيد الحجز بنجاح. شكرًا لك على اختيار خدماتنا!', 'تم رفض الحجز. نأسف على الإزعاج، يرجى المحاولة في وقت لاحق.', '01923343334', 39, '{\"address\":\"طريق القاهرة, الاسكندرية الزراعى, فخرى جعيصه, الغربية, 31749, مصر\",\"latitude\":30.7953664,\"longitude\":31.014912}', '09:15', '09:17', 'http://www.rabee.info/', 'http://127.0.0.1:8000/images/organizations/images/service_6_6795c52596923.jpg', 'http://127.0.0.1:8000/images/organizations/icons/facebook_6795c525a2e33.png', 0, '\"[\\\"7\\\",\\\"11\\\",\\\"15\\\",\\\"14\\\"]\"', 0, 'Organization', 0, 0, '2025-01-26 03:16:21', '2025-01-26 03:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `participant_type` varchar(255) NOT NULL,
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 51, 'auth_token', '1cb52e169fe826b27aa4b8b3aa7ec49b01a5008d74d9bdc0f31d6a7ceb37e9d9', '[\"*\"]', NULL, NULL, '2024-12-25 04:54:28', '2024-12-25 04:54:28'),
(2, 'App\\Models\\User', 51, 'auth_token', 'c1a5609f12b4c89d79e02680e692073c8a8c1f15c892a65a14e5e054794111e1', '[\"role:user\"]', '2024-12-25 04:59:57', NULL, '2024-12-25 04:54:41', '2024-12-25 04:59:57'),
(3, 'App\\Models\\organization', 21, 'auth_token', 'a9dff4d9b07f08cdc369b4e6ae0ea0a5a61ad18a941b11723f23861f35e644e6', '[\"role:organization\"]', '2024-12-28 05:44:38', NULL, '2024-12-27 09:51:24', '2024-12-28 05:44:38'),
(4, 'App\\Models\\User', 51, 'auth_token', 'b90043e0d50f428fed5616e00f1c704195fe3bbacfe2f8e5fe1fe865dbfa729b', '[\"role:user\"]', '2024-12-29 08:31:32', NULL, '2024-12-29 05:22:11', '2024-12-29 08:31:32'),
(5, 'App\\Models\\User', 52, 'auth_token', 'd73d4dac2197d16147c517ec8b365ba605ac84910ba63d02bb858a9d5495d37e', '[\"*\"]', NULL, NULL, '2025-01-01 05:00:48', '2025-01-01 05:00:48'),
(6, 'App\\Models\\User', 52, 'auth_token', 'f733c66c3f04f6a6b4b43b71f1255de31c4ff0d9cd5c968eeb954a7ce0983300', '[\"role:user\"]', '2025-01-01 05:04:03', NULL, '2025-01-01 05:01:07', '2025-01-01 05:04:03'),
(7, 'App\\Models\\User', 52, 'auth_token', 'ac4a440d1a360f4b3403881d61152c657bcfca76f09bdba0276a7a0daddb55ca', '[\"role:user\"]', '2025-01-01 12:25:06', NULL, '2025-01-01 11:41:51', '2025-01-01 12:25:06'),
(8, 'App\\Models\\User', 51, 'auth_token', '1f9b579b4dbd1880d6b99eaf07ce08bb0c8e4346869145e621f6e171b0521468', '[\"role:user\"]', '2025-01-02 09:36:10', NULL, '2025-01-02 08:43:15', '2025-01-02 09:36:10'),
(16, 'App\\Models\\organization', 23, 'auth_token', '586826a766ebbb339e5a748a3047eebd2f11cb949b4ca6475a1c948a311336c8', '[\"role:organization\"]', '2025-01-05 10:09:18', NULL, '2025-01-05 06:00:06', '2025-01-05 10:09:18'),
(18, 'App\\Models\\User', 51, 'auth_token', 'c3886af53614181c3cafb79ae96e6137a107855d14e29af976b23551b6d215c0', '[\"role:user\"]', '2025-01-05 10:17:27', NULL, '2025-01-05 08:05:34', '2025-01-05 10:17:27'),
(19, 'App\\Models\\User', 52, 'auth_token', '0c6897bc1d5111baf62af13c0f82cc6df46c91f747315035fd70be37f4e04663', '[\"role:user\"]', '2025-01-06 10:59:06', NULL, '2025-01-06 03:09:05', '2025-01-06 10:59:06'),
(22, 'App\\Models\\organization', 23, 'auth_token', 'a40279496b84e6cc9a8f55e760be788d59efc86f78786f326e47b9db402239b7', '[\"role:organization\"]', '2025-01-07 05:50:54', NULL, '2025-01-07 00:43:09', '2025-01-07 05:50:54'),
(27, 'App\\Models\\User', 52, 'auth_token', 'b94d794a583487e4bf468be1794a51cc85f01451341172317d2fb549ddc2312b', '[\"role:user\"]', '2025-01-08 10:06:38', NULL, '2025-01-08 04:36:19', '2025-01-08 10:06:38'),
(43, 'App\\Models\\organization', 23, 'auth_token', 'da0830f83af6b11c8054d06df3cd25b7f8e84f84395f8db1778ef0e5f32ad67b', '[\"role:organization\"]', '2025-01-09 17:05:38', NULL, '2025-01-09 14:36:25', '2025-01-09 17:05:38'),
(46, 'App\\Models\\User', 51, 'auth_token', '5d67cb2f7fb049cab06c04a6fd874cd280db9d4abe550e960864a4d9e8b9b617', '[\"*\"]', NULL, NULL, '2025-01-11 02:34:21', '2025-01-11 02:34:21'),
(47, 'App\\Models\\User', 51, 'auth_token', '02073d4c904b3c0278c1a714a5ee18c1ac5ab6fbc175b962eda10b6685bfbfbc', '[\"role:user\"]', '2025-01-11 02:57:20', NULL, '2025-01-11 02:34:31', '2025-01-11 02:57:20'),
(48, 'App\\Models\\User', 51, 'auth_token', '8a619d575b024bf2376ca2bf960f3402e287cf823dbf58756b831876b5d8a4e6', '[\"role:user\"]', '2025-01-13 10:58:31', NULL, '2025-01-13 02:14:51', '2025-01-13 10:58:31'),
(49, 'App\\Models\\organization', 20, 'auth_token', 'bbac8e4e9dd0e59ba7f213055856abc2d7cf0dcdc86383f026001d1384ee7da0', '[\"role:organization\"]', '2025-01-14 10:13:51', NULL, '2025-01-14 00:28:15', '2025-01-14 10:13:51'),
(52, 'App\\Models\\User', 51, 'auth_token', '8bc6f75915dc2eff3e009dec382ebeb7adca901ca9a585e9244977394cb91367', '[\"role:user\"]', '2025-01-17 09:42:02', NULL, '2025-01-17 04:31:09', '2025-01-17 09:42:02'),
(55, 'App\\Models\\User', 51, 'auth_token', 'd52015887fedd126a04ac380251f5fb30047054018ed2cc4486115a30bbb0024', '[\"*\"]', NULL, NULL, '2025-01-18 03:22:04', '2025-01-18 03:22:04'),
(56, 'App\\Models\\User', 51, 'auth_token', '8b1f8bca6c4bfed92e770d561119b3e162bd77633946b162c9e477696ce1b499', '[\"role:user\"]', '2025-01-18 03:25:18', NULL, '2025-01-18 03:22:19', '2025-01-18 03:25:18'),
(57, 'App\\Models\\organization', 2, 'auth_token', '6ca6d621f360d79243f070196e7ff001c785344ef11bb21f9f0e85c885b55c6c', '[\"role:organization\"]', '2025-01-19 11:01:12', NULL, '2025-01-19 11:00:51', '2025-01-19 11:01:12'),
(58, 'App\\Models\\organization', 1, 'auth_token', 'd0403591be739e76ffea964d6a0d0aa7d0b5184b9f25fec0d1139c9219a0547f', '[\"role:organization\"]', '2025-01-20 09:11:41', NULL, '2025-01-20 01:11:19', '2025-01-20 09:11:41'),
(61, 'App\\Models\\organization', 20, 'auth_token', 'e3e4930b2f5a8b272e01a5dc5b0bfe675b31ae3662efef52b99e146ede4b6943', '[\"role:organization\"]', '2025-01-23 23:40:14', NULL, '2025-01-23 22:32:38', '2025-01-23 23:40:14'),
(67, 'App\\Models\\User', 51, 'auth_token', 'eab6d62c4cfe12567b1b46bbde8999c287ef557e1446066ae0545174eeb370e9', '[\"role:user\"]', '2025-01-26 03:20:16', NULL, '2025-01-26 00:13:48', '2025-01-26 03:20:16'),
(69, 'App\\Models\\User', 51, 'auth_token', '8c644ad16f393dab4173306a3846e12d8ccd6889e4f276179e68827b8e269a94', '[\"role:user\"]', '2025-01-27 11:08:29', NULL, '2025-01-27 11:08:04', '2025-01-27 11:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy_organizations`
--

CREATE TABLE `privacy_policy_organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_en` text NOT NULL,
  `content_ar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policy_organizations`
--

INSERT INTO `privacy_policy_organizations` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2024-12-25 04:25:22', '2024-12-25 04:25:22'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2024-12-25 04:25:22', '2024-12-25 04:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policy_users`
--

CREATE TABLE `privacy_policy_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_en` text NOT NULL,
  `content_ar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policy_users`
--

INSERT INTO `privacy_policy_users` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2024-12-25 04:25:37', '2024-12-25 04:25:37'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2024-12-25 04:25:37', '2024-12-25 04:25:37');

-- --------------------------------------------------------

--
-- Table structure for table `provisional_data`
--

CREATE TABLE `provisional_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uniqueId` varchar(255) NOT NULL,
  `cardsDetailes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cardsDetailes`)),
  `expire_at` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provisional_data`
--

INSERT INTO `provisional_data` (`id`, `uniqueId`, `cardsDetailes`, `expire_at`, `created_at`, `updated_at`) VALUES
(15, '9005', '{\"book_day\":\"2025-01-23\",\"book_time\":\"09:00 AM\",\"expire_in\":\"09:15 AM\",\"additional_notes\":null,\"user_id\":\"51\",\"organization_id\":\"23\"}', '2025-01-02 12:31:04', '2025-01-02 09:31:04', '2025-01-02 09:31:04'),
(24, '7589', '{\"book_day\":\"2025-01-31\",\"book_time\":\"05:00 AM\",\"expire_in\":\"05:15 AM\",\"additional_notes\":null,\"user_id\":\"51\",\"organization_id\":\"20\"}', '2025-01-24 01:21:12', '2025-01-23 22:21:12', '2025-01-23 22:21:12'),
(26, '7051', '{\"book_day\":\"2025-01-28\",\"book_time\":\"04:30 PM\",\"expire_in\":\"04:45 PM\",\"additional_notes\":null,\"user_id\":\"20\",\"organization_id\":\"18\"}', '2025-01-24 23:05:08', '2025-01-24 20:05:08', '2025-01-24 20:05:08');

-- --------------------------------------------------------

--
-- Table structure for table `question_answers`
--

CREATE TABLE `question_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
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
(20, 'ما هو الفرق بين include و require في PHP؟', 'include يتضمن ملفًا خارجيًا في حين أن require يوقف تنفيذ البرنامج إذا كان الملف غير موجود.', 5, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `like` tinyint(1) NOT NULL,
  `dislike` tinyint(1) NOT NULL,
  `love` tinyint(1) NOT NULL,
  `laugh` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `description_ar` longtext NOT NULL,
  `description_en` longtext NOT NULL,
  `icon` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `features` longtext DEFAULT NULL,
  `popularity` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `video_url` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `organization_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`organization_ids`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title_en`, `title_ar`, `description_ar`, `description_en`, `icon`, `image`, `features`, `popularity`, `status`, `active`, `tags`, `video_url`, `category_id`, `organization_ids`, `created_at`, `updated_at`) VALUES
(1, 'Eye Care', 'العناية بالعيون', 'فحوصات شاملة للعيون وعلاجات لجميع الأعمار.', 'Comprehensive eye exams and treatments for all ages.', 'http://127.0.0.1:8000/images/services/icons/activeview_678b1a702a20a.png', 'http://127.0.0.1:8000/images/services/images/service-01.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 9, '20', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(2, 'Dental Services', 'خدمات طب الأسنان', 'رعاية أسنان عالية الجودة لعائلتك.', 'High-quality dental care for your family.', 'http://127.0.0.1:8000/images/services/icons/activeview_678b1a702a20a.png', 'http://127.0.0.1:8000/images/services/images/service_6.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 2, '3', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(3, 'Cardiology', 'أمراض القلب', 'رعاية متخصصة لصحة القلب والحالات القلبية.', 'Expert care for heart health and cardiovascular conditions.', 'http://127.0.0.1:8000/images/services/icons/first-aid-kit.png', 'http://127.0.0.1:8000/images/services/images/service_6.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 7, '43', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(4, 'Pediatrics', 'طب الأطفال', 'رعاية صحية مخصصة لأطفالك.', 'Dedicated healthcare for your children.', 'http://127.0.0.1:8000/images/services/icons/medicine.png', 'http://127.0.0.1:8000/images/services/images/service_5.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 3, '29', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(5, 'Orthopedics', 'جراحة العظام', 'رعاية متخصصة للعظام والمفاصل.', 'Specialized care for bones and joints.', 'http://127.0.0.1:8000/images/services/icons/hospital.png', 'http://127.0.0.1:8000/images/services/images/service_5.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 9, '40', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(6, 'Dermatology', 'الأمراض الجلدية', 'رعاية وعلاج شامل للبشرة.', 'Comprehensive skin care and treatment.', 'http://127.0.0.1:8000/images/services/icons/hospital.png', 'http://127.0.0.1:8000/images/services/images/service_5.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 18, '17', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(7, 'Nutrition Counseling', 'الإرشاد الغذائي', 'خطط غذائية شخصية لصحة أفضل.', 'Personalized diet plans for a healthier you.', 'http://127.0.0.1:8000/images/services/icons/first-aid-kit.png', 'http://127.0.0.1:8000/images/services/images/service_6.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 15, '22', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(8, 'Physical Therapy', 'العلاج الطبيعي', 'تمارين علاجية لاستعادة الحركة.', 'Therapeutic exercises to restore mobility.', 'http://127.0.0.1:8000/images/services/icons/activeview_678b1a702a20a.png', 'http://127.0.0.1:8000/images/services/images/service_5.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 7, '34', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(9, 'Radiology', 'الأشعة', 'تصوير متقدم لتشخيص دقيق.', 'Advanced imaging for accurate diagnoses.', 'http://127.0.0.1:8000/images/services/icons/syringe.png', 'http://127.0.0.1:8000/images/services/images/service_4.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 8, '26', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(10, 'Mental Health', 'الصحة النفسية', 'رعاية داعمة للرفاهية النفسية.', 'Supportive care for emotional well-being.', 'http://127.0.0.1:8000/images/services/icons/hospital.png', 'http://127.0.0.1:8000/images/services/images/service-01.jpg', '[\"Access to basic features\",\"Email support\",\"Simple analytics\",\"Custom dashboard\"]', 0, 0, 1, NULL, NULL, 3, '4', '2025-01-18 03:05:58', '2025-01-18 03:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `title_ar`, `title_en`, `image`, `created_at`, `updated_at`) VALUES
(1, 'الطب العام', 'General Medicine', 'http://127.0.0.1:8000/images/services_categories/hospital.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(2, 'طب الأطفال', 'Pediatrics', 'http://127.0.0.1:8000/images/services_categories/first-aid-kit.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(3, 'طب الأسنان', 'Dentistry', 'http://127.0.0.1:8000/images/services_categories/medicine.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(4, 'الأمراض الجلدية', 'Dermatology', 'http://127.0.0.1:8000/images/services_categories/first-aid-kit.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(5, 'طب القلب', 'Cardiology', 'http://127.0.0.1:8000/images/services_categories/syringe.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(6, 'طب الأعصاب', 'Neurology', 'http://127.0.0.1:8000/images/services_categories/cardiogram.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(7, 'طب العظام', 'Orthopedics', 'http://127.0.0.1:8000/images/services_categories/drugs.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(8, 'طب النساء', 'Gynecology', 'http://127.0.0.1:8000/images/services_categories/hospital.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(9, 'طب العيون', 'Ophthalmology', 'http://127.0.0.1:8000/images/services_categories/syringe.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(10, 'الطب النفسي', 'Psychiatry', 'http://127.0.0.1:8000/images/services_categories/cardiogram.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(11, 'العلاج الطبيعي', 'Physiotherapy', 'http://127.0.0.1:8000/images/services_categories/drugs.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(12, 'طب الأورام', 'Oncology', 'http://127.0.0.1:8000/images/services_categories/medicine.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(13, 'الأنف والأذن والحنجرة', 'ENT (Ear, Nose, and Throat)', 'http://127.0.0.1:8000/images/services_categories/hospital.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(14, 'التغذية', 'Nutrition', 'http://127.0.0.1:8000/images/services_categories/drugs.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(15, 'الأشعة', 'Radiology', 'http://127.0.0.1:8000/images/services_categories/cardiogram.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(16, 'الجراحة', 'Surgery', 'http://127.0.0.1:8000/images/services_categories/first-aid-kit.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(17, 'الصيدلة', 'Pharmacy', 'http://127.0.0.1:8000/images/services_categories/first-aid-kit.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(18, 'إعادة التأهيل', 'Rehabilitation', 'http://127.0.0.1:8000/images/services_categories/drugs.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(19, 'طب الطوارئ', 'Emergency Medicine', 'http://127.0.0.1:8000/images/services_categories/medicine.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58'),
(20, 'طب الأسرة', 'Family Medicine', 'http://127.0.0.1:8000/images/services_categories/cardiogram.png', '2025-01-18 03:05:58', '2025-01-18 03:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bg_color` varchar(255) DEFAULT NULL,
  `text_1_ar` varchar(255) DEFAULT NULL,
  `text_2_ar` varchar(255) DEFAULT NULL,
  `text_3_ar` varchar(255) DEFAULT NULL,
  `text_1_en` varchar(255) DEFAULT NULL,
  `text_2_en` varchar(255) DEFAULT NULL,
  `text_3_en` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image`, `bg_color`, `text_1_ar`, `text_2_ar`, `text_3_ar`, `text_1_en`, `text_2_en`, `text_3_en`, `created_at`, `updated_at`) VALUES
(1, 'http://127.0.0.1:8000/images/slider/portrait-candid-male-doctor-removebg.png', NULL, 'العناية الشخصية والجمال', 'تهمنا', 'اكتشف أفضل العلاجات للعناية الشخصية، الاهتمام الطبي، وعمليات التجميل مع فريقنا المحترف.', 'Personal care and beauty', 'enhancement', 'Discover the best treatments for personal care, medical attention, and cosmetic surgeries with our professional team.', '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(2, 'http://127.0.0.1:8000/images/slider/portrait-candid-male-doctor-removebg.png', NULL, 'العلاجات الطبية', 'الشفاء', 'عيادتنا تقدم علاجات طبية متقدمة لجميع المشاكل الصحية.', 'Medical treatments', 'healing', 'Our clinic offers advanced medical treatments for all health concerns.', '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(3, 'http://127.0.0.1:8000/images/slider/file.png', NULL, 'جراحة التجميل', 'الجمال', 'عزز مظهرك مع جراحينا التجميل المحترفين.', 'Cosmetic Surgery', 'beauty', 'Enhance your appearance with our experienced cosmetic surgeons.', '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(4, 'http://127.0.0.1:8000/images/slider/file.png', NULL, 'علاجات العناية بالشعر', 'النمو', 'نمو وتجديد شعرك مع علاجاتنا المتخصصة.', 'Hair Care Treatments', 'growth', 'Regrow and rejuvenate your hair with our specialized treatments.', '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(5, 'http://127.0.0.1:8000/images/slider/file.png', NULL, 'برامج خسارة الوزن', 'اللياقة', 'كن لائقاً وتخلص من الوزن مع برامجنا المخصصة.', 'Weight Loss Programs', 'fitness', 'Get fit and lose weight with our personalized programs.', '2025-01-18 03:06:09', '2025-01-18 03:06:09'),
(6, 'http://127.0.0.1:8000/images/slider/file.png', NULL, 'حلول العناية بالبشرة', 'التوهج', 'تحقيق بشرة نقية ومتوهجة مع حلول العناية بالبشرة لدينا.', 'Skin Care Solutions', 'glowing', 'Achieve clear and glowing skin with our skin care solutions.', '2025-01-18 03:06:09', '2025-01-18 03:06:09');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_condition_organizations`
--

CREATE TABLE `terms_condition_organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_en` text NOT NULL,
  `content_ar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_condition_organizations`
--

INSERT INTO `terms_condition_organizations` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2024-12-25 04:25:45', '2024-12-25 04:25:45'),
(21, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(22, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(23, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(24, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(25, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(26, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(27, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(28, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(29, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(30, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(31, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(32, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(33, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(34, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(35, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(36, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(37, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(38, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(39, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2024-12-25 04:25:49', '2024-12-25 04:25:49'),
(40, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2024-12-25 04:25:49', '2024-12-25 04:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `terms_condition_users`
--

CREATE TABLE `terms_condition_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_en` text NOT NULL,
  `content_ar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_condition_users`
--

INSERT INTO `terms_condition_users` (`id`, `content_en`, `content_ar`, `created_at`, `updated_at`) VALUES
(1, 'We do not share your personal information with third parties without your consent.', 'نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(2, 'All collected data is stored securely.', 'يتم تخزين جميع البيانات التي تم جمعها بشكل آمن.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(3, 'You can request to delete your account at any time.', 'يمكنك طلب حذف حسابك في أي وقت.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(4, 'Cookies are used to improve user experience, not for tracking.', 'يتم استخدام ملفات تعريف الارتباط لتحسين تجربة المستخدم وليس للتتبع.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(5, 'Your email address will only be used for communication related to our services.', 'سيتم استخدام بريدك الإلكتروني فقط للتواصل المتعلق بخدماتنا.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(6, 'We comply with GDPR and other data protection regulations.', 'نحن نلتزم بـ GDPR واللوائح الأخرى لحماية البيانات.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(7, 'Payment information is handled by secure third-party providers.', 'يتم التعامل مع معلومات الدفع بواسطة مزودي خدمات آمنين.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(8, 'Access to personal data is restricted to authorized personnel only.', 'يقتصر الوصول إلى البيانات الشخصية على الموظفين المصرح لهم فقط.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(9, 'We regularly update our security measures.', 'نقوم بتحديث تدابير الأمان لدينا بانتظام.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(10, 'User data is anonymized when used for analytics.', 'يتم إخفاء هوية بيانات المستخدم عند استخدامها للتحليلات.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(11, 'We do not sell your data to advertisers.', 'لا نبيع بياناتك للمعلنين.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(12, 'Users are notified of any data breaches promptly.', 'يتم إخطار المستخدمين بأي اختراقات للبيانات على الفور.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(13, 'We provide tools to manage your privacy settings.', 'نوفر أدوات لإدارة إعدادات الخصوصية الخاصة بك.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(14, 'Your preferences for email subscriptions can be modified anytime.', 'يمكنك تعديل تفضيلاتك للاشتراكات البريدية في أي وقت.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(15, 'Data is only retained as long as necessary for the purposes stated.', 'يتم الاحتفاظ بالبيانات فقط طالما كانت ضرورية للأغراض المحددة.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(16, 'Third-party tools used comply with our privacy standards.', 'الأدوات التي نستخدمها تلتزم بمعايير الخصوصية لدينا.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(17, 'We use encryption to protect sensitive information.', 'نستخدم التشفير لحماية المعلومات الحساسة.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(18, 'Our servers are monitored for security 24/7.', 'تتم مراقبة خوادمنا على مدار الساعة للأمان.', '2024-12-25 04:29:16', '2024-12-25 04:29:16'),
(19, 'Children\'s data is handled in compliance with COPPA.', 'يتم التعامل مع بيانات الأطفال بما يتوافق مع COPPA.', '2024-12-25 04:29:17', '2024-12-25 04:29:17'),
(20, 'We welcome your feedback on privacy practices.', 'نرحب بتعليقاتك حول ممارسات الخصوصية لدينا.', '2024-12-25 04:29:17', '2024-12-25 04:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`location`)),
  `image` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `social_id` text DEFAULT NULL,
  `number_of_reservations` int(11) DEFAULT 0,
  `social_type` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `account_type` varchar(100) DEFAULT 'User',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone_number`, `location`, `image`, `role`, `social_id`, `number_of_reservations`, `social_type`, `email_verified_at`, `account_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Miss Lorna Stiedemann', 'liza24@example.com', '12345678', '+1 (731) 566-5180', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'Admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-15 08:56:50', NULL),
(2, 'Cory Koss', 'lokeefe@example.com', '12345678', '+1 (619) 571-7034', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-04-20 21:09:44', NULL),
(3, 'Jayden Jakubowski', 'mjohnson@example.net', '12345678', '1-878-979-0714', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-05-05 12:59:14', NULL),
(4, 'Eva Muller I', 'emil.oconnell@example.org', '12345678', '360-760-3377', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-13 15:11:04', NULL),
(5, 'Ola Douglas', 'uparisian@example.com', '12345678', '504-792-8274', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-04-11 00:24:09', NULL),
(6, 'Aubrey Reilly', 'dicki.annamae@example.org', '12345678', '+1 (708) 794-6277', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082440.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-03 19:09:14', NULL),
(7, 'Helga Daniel', 'mervin.howell@example.net', '12345678', '+1-620-948-0815', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-07-24 22:41:58', NULL),
(8, 'Evan Bayer', 'zulauf.javon@example.net', '12345678', '(520) 288-5288', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082440.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-10-18 00:16:06', NULL),
(9, 'Tyson Hayes', 'kreiger.micaela@example.org', '12345678', '+1.231.969.1595', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082440.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-07-29 08:46:56', NULL),
(10, 'Prof. Kenyatta Gleichner', 'tyler02@example.org', '12345678', '313-589-6604', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-02-14 02:20:31', NULL),
(11, 'Mrs. Wanda Towne V', 'cory.wilkinson@example.com', '12345678', '(971) 368-5518', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-27 19:56:15', NULL),
(12, 'Dr. Kamryn Schoen', 'rhickle@example.org', '12345678', '(743) 615-1218', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-07-06 02:16:09', NULL),
(13, 'Prof. Augustus Roob', 'macejkovic.weldon@example.org', '12345678', '+14235231534', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-05-23 11:03:10', NULL),
(14, 'Miss Jada Satterfield I', 'tboyer@example.net', '12345678', '+1 (623) 698-4592', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082440.jpg', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-07-28 05:39:28', NULL),
(15, 'Mr. Raven McKenzie', 'hschamberger@example.org', '12345678', '1-608-218-2624', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-11-01 17:34:53', NULL),
(16, 'Dr. Lois Becker V', 'leda.lang@example.com', '12345678', '(928) 934-8150', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-04-01 00:32:45', NULL),
(17, 'Miss Reyna Daniel DDS', 'beer.lamont@example.net', '12345678', '+15676665192', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-02-12 01:04:13', NULL),
(18, 'Garrison Schoen', 'kelton.kilback@example.com', '12345678', '+1 (747) 391-1302', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2025-01-05 03:15:02', NULL),
(19, 'Frederique Jaskolski V', 'fnader@example.com', '12345678', '1-971-671-0086', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-18 23:35:59', NULL),
(20, 'Aileen Ankunding MD', 'purdy.jovani@example.com', '12345678', '283.992.7755', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-10-28 23:49:08', NULL),
(21, 'Brigitte Mohr', 'aglover@example.net', '12345678', '747.770.7220', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-09-18 06:55:53', NULL),
(22, 'Destiney Hickle DVM', 'toby.erdman@example.net', '12345678', '1-520-852-6323', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-01-19 19:42:30', NULL),
(23, 'Melissa Greenfelder', 'king.graciela@example.org', '12345678', '1-747-740-4788', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-12 08:17:27', NULL),
(24, 'Carlie Doyle', 'effertz.della@example.com', '12345678', '1-952-481-1897', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-12-26 21:39:15', NULL),
(25, 'Jaeden Howell', 'josefa20@example.net', '12345678', '+1 (479) 783-9431', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2025-01-14 15:00:02', NULL),
(26, 'Laney Hane MD', 'rempel.filiberto@example.com', '12345678', '531.592.9874', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-10-12 21:29:42', NULL),
(27, 'Ms. Rita Will', 'ellen.heaney@example.com', '12345678', '928.775.5199', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-11-07 08:27:16', NULL),
(28, 'Helga DuBuque DDS', 'jude.kohler@example.com', '12345678', '+1 (240) 298-4884', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082440.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-06-05 04:25:32', NULL),
(29, 'Rollin Balistreri', 'leffler.gennaro@example.org', '12345678', '(785) 807-9156', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2025-01-06 01:01:05', NULL),
(30, 'Mrs. Sandrine Dicki DVM', 'beverly52@example.com', '12345678', '1-541-795-6674', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082440.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-10-13 03:31:05', NULL),
(31, 'Jana Blick', 'klocko.arvid@example.org', '12345678', '(351) 880-4018', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-06-18 13:34:27', NULL),
(32, 'Fay Fritsch', 'qzieme@example.com', '12345678', '1-325-484-8107', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-06-06 23:11:37', NULL),
(33, 'Kamron Luettgen', 'angelica63@example.net', '12345678', '+1 (240) 384-4688', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-11-13 09:26:43', NULL),
(34, 'Morris Will DDS', 'roberta72@example.org', '12345678', '219-214-5923', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082440.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-01 21:10:10', NULL),
(35, 'Maud Parker', 'uriel38@example.org', '12345678', '+1 (909) 352-6439', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-05-20 17:15:23', NULL),
(36, 'Amos Hansen', 'rutherford.ahmed@example.com', '12345678', '+1 (702) 317-3506', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-06-12 21:25:15', NULL),
(37, 'Miss Mya Hammes I', 'schumm.jailyn@example.org', '12345678', '1-425-982-8450', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-06-25 10:49:20', NULL),
(38, 'Dr. Cloyd Stroman MD', 'fay.breanna@example.org', '12345678', '1-920-762-6557', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-11-20 10:40:45', NULL),
(39, 'Coby McGlynn', 'johnnie.denesik@example.com', '12345678', '+1-386-819-4482', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-02-13 21:00:42', NULL),
(40, 'Dr. Elfrieda Borer', 'valentin20@example.com', '12345678', '401-910-6701', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241208064634.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-05-30 13:41:13', NULL),
(41, 'Antwon Collins', 'max55@example.net', '12345678', '(938) 694-3228', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-11-30 21:29:28', NULL),
(42, 'Prof. Chance Bergnaum', 'mkrajcik@example.org', '12345678', '+1.580.577.0154', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-04-15 21:14:32', NULL),
(43, 'Janis Haag', 'myron59@example.net', '12345678', '+1 (920) 263-9976', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-11-05 05:34:28', NULL),
(44, 'Clay Brakus', 'ayost@example.com', '12345678', '715.686.0107', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'user', NULL, 0, NULL, NULL, 'User', NULL, '2024-05-09 07:27:32', NULL),
(45, 'Mrs. Tyra Jast II', 'yost.floyd@example.org', '12345678', '629.484.0514', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-07-19 09:59:47', NULL),
(46, 'Jayda Haley', 'ddouglas@example.net', '12345678', '+1 (816) 259-3111', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-08-07 13:54:26', NULL),
(47, 'Kellen Hill', 'sking@example.com', '12345678', '228-397-3598', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-09-20 09:37:33', NULL),
(48, 'Kirsten Bernhard', 'zella.trantow@example.org', '12345678', '+1-480-336-7605', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/avatar_male_676bac246bed6.png', 'admin', NULL, 0, NULL, NULL, 'User', NULL, '2024-12-30 21:17:47', NULL),
(49, 'Dean Simonis', 'xmayert@example.org', '12345678', '+1-754-270-4364', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/4_6784dcfb52e06.jpg', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-04-25 12:35:22', NULL),
(50, 'Lea Hahn', 'xbins@example.net', '12345678', '570.734.5407', '{\"address\":\"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية\",\"latitude\":21.40281772305478,\"longitude\":39.84603881835938}', 'http://127.0.0.1:8000/images/users/20241201082428.png', 'editor', NULL, 0, NULL, NULL, 'User', NULL, '2024-04-23 05:33:43', NULL),
(51, 'ahmed-2', 'failloser1@gmail.com', '$2y$12$sTXMcCzz7NMKYwzo2ji.iOHaRUulD9FunZ9lOXGVX5BOJ8AeLxXYG', '01923343334', NULL, NULL, 'Admin', NULL, 0, NULL, NULL, 'User', NULL, '2025-01-18 03:22:04', '2025-01-18 03:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_article_reactions`
--

CREATE TABLE `user_article_reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `reaction_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_article_reactions`
--

INSERT INTO `user_article_reactions` (`id`, `user_id`, `article_id`, `reaction_type`, `created_at`, `updated_at`) VALUES
(51, 51, 15, 'like', '2025-01-16 11:36:22', '2025-01-16 11:36:22'),
(58, 51, 12, 'like', '2025-01-16 09:56:56', '2025-01-16 09:56:56'),
(69, 51, 14, 'laugh', '2025-01-16 10:13:54', '2025-01-16 10:13:54');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `comments_article_id_foreign` (`article_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `provisional_data`
--
ALTER TABLE `provisional_data`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_article_reactions`
--
ALTER TABLE `user_article_reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_article_reactions_user_id_article_id_unique` (`user_id`,`article_id`),
  ADD KEY `user_article_reactions_article_id_foreign` (`article_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_services`
--
ALTER TABLE `affiliate_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `arma__cards`
--
ALTER TABLE `arma__cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `artical_categories`
--
ALTER TABLE `artical_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `article_reactions_count`
--
ALTER TABLE `article_reactions_count`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bells`
--
ALTER TABLE `bells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `card_types`
--
ALTER TABLE `card_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `company_detailes`
--
ALTER TABLE `company_detailes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footers`
--
ALTER TABLE `footers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mainpages`
--
ALTER TABLE `mainpages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `privacy_policy_organizations`
--
ALTER TABLE `privacy_policy_organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `privacy_policy_users`
--
ALTER TABLE `privacy_policy_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `provisional_data`
--
ALTER TABLE `provisional_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `question_answers`
--
ALTER TABLE `question_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms_condition_organizations`
--
ALTER TABLE `terms_condition_organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `terms_condition_users`
--
ALTER TABLE `terms_condition_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `user_article_reactions`
--
ALTER TABLE `user_article_reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_answers`
--
ALTER TABLE `question_answers`
  ADD CONSTRAINT `question_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
