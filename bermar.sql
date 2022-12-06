-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.33 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para bermar
CREATE DATABASE IF NOT EXISTS `bermar` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bermar`;

-- Copiando estrutura para tabela bermar.addresses
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enterprise_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_enterprise_id_foreign` (`enterprise_id`),
  CONSTRAINT `addresses_enterprise_id_foreign` FOREIGN KEY (`enterprise_id`) REFERENCES `enterprises` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.addresses: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
REPLACE INTO `addresses` (`id`, `number`, `street`, `district`, `zipcode`, `city`, `state`, `complement`, `enterprise_id`, `created_at`, `updated_at`, `city_id`, `region`) VALUES
	(1, '354', 'R ROLDAO ZAMPIERI', 'HIGIENOPOLIS', '15085-460', 'SAO JOSE DO RIO PRETO', 'SP', 'teste1', 3, '2022-07-20 00:47:04', '2022-07-20 00:47:04', 9659, ''),
	(2, '548', 'A', '369', '38230-000', 'FRONTEIRA', 'MG', 'teste', 4, '2022-07-21 23:22:35', '2022-07-21 23:22:35', 3143, ''),
	(3, '66', 'R ROLDAO ZAMPIERI', 'HIGIENOPOLIS', '15085-460', 'SAO JOSE DO RIO PRETO', 'SP', NULL, 5, '2022-07-21 23:28:19', '2022-07-21 23:28:19', 9659, ''),
	(4, '58', 'R ROLDAO ZAMPIERI', 'HIGIENOPOLIS', '15085-460', 'SAO JOSE DO RIO PRETO', 'SP', 'teste', 6, '2022-09-07 16:24:17', '2022-09-07 16:27:22', 9659, 'Interior'),
	(5, '54', 'R ROLDAO ZAMPIERI', 'HIGIENOPOLIS', '15085-460', 'SAO JOSE DO RIO PRETO', 'SP', 'teste25', 7, '2022-10-17 23:15:16', '2022-10-17 23:15:16', 9659, 'Interior'),
	(6, 'teste25', 'R ROLDAO ZAMPIERI', 'HIGIENOPOLIS', '15085-460', 'SAO JOSE DO RIO PRETO', 'SP', 'teste', 8, '2022-10-17 23:25:07', '2022-10-17 23:25:07', 9659, 'Capital'),
	(7, '556', 'R ROLDAO ZAMPIERI', 'HIGIENOPOLIS', '15085-460', 'SAO JOSE DO RIO PRETO', 'SP', NULL, 9, '2022-10-24 23:23:09', '2022-10-24 23:23:09', 9659, 'Interior');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.budgets
CREATE TABLE IF NOT EXISTS `budgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci,
  `warranty_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `budgets_warranty_id_foreign` (`warranty_id`),
  CONSTRAINT `budgets_warranty_id_foreign` FOREIGN KEY (`warranty_id`) REFERENCES `warranties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.budgets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `budgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `budgets` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.budget_items
CREATE TABLE IF NOT EXISTS `budget_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `budget_id` bigint(20) unsigned NOT NULL,
  `warranty_product_id` bigint(20) unsigned NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `budget_items_budget_id_foreign` (`budget_id`),
  KEY `budget_items_warranty_product_id_foreign` (`warranty_product_id`),
  CONSTRAINT `budget_items_budget_id_foreign` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`),
  CONSTRAINT `budget_items_warranty_product_id_foreign` FOREIGN KEY (`warranty_product_id`) REFERENCES `warranty_products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.budget_items: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `budget_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `budget_items` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.categories: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `slug`) VALUES
	(2, 'Amaciador', '2022-07-07 21:22:00', '2022-07-07 21:22:00', 'amaciador'),
	(3, 'Cilindros', '2022-07-07 21:22:18', '2022-08-20 14:24:31', 'cilindros'),
	(4, 'teste', '2022-08-20 14:25:18', '2022-08-20 14:25:18', 'teste');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `warranty_id` bigint(20) unsigned DEFAULT NULL,
  `enterprise_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_warranty_id_foreign` (`warranty_id`),
  KEY `chat_enterprise_id_foreign` (`enterprise_id`),
  KEY `chat_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_enterprise_id_foreign` FOREIGN KEY (`enterprise_id`) REFERENCES `enterprises` (`id`),
  CONSTRAINT `chat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `chat_warranty_id_foreign` FOREIGN KEY (`warranty_id`) REFERENCES `warranties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.chat: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
REPLACE INTO `chat` (`id`, `status`, `warranty_id`, `enterprise_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(2, 1, 2, 3, 2, '2022-10-18 22:27:22', '2022-10-19 01:15:22');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.chat_messages
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chat_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_chat_id_foreign` (`chat_id`),
  KEY `chat_messages_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`),
  CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.chat_messages: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
REPLACE INTO `chat_messages` (`id`, `message`, `file`, `chat_id`, `created_at`, `updated_at`, `user_id`) VALUES
	(72, 'teste', NULL, 2, '2022-10-19 00:36:07', '2022-10-19 00:36:07', 2),
	(73, 'teste2', NULL, 2, '2022-10-19 00:52:27', '2022-10-19 00:52:27', 3),
	(74, NULL, '634f4a88e4996_&&_Aparelho ortodontico (Story do Instagram).png', 2, '2022-10-19 00:53:28', '2022-10-19 00:53:28', 3),
	(75, 'teste33', NULL, 2, '2022-10-19 01:03:47', '2022-10-19 01:03:47', 1),
	(76, 'A Assistencia Tecnica foi inserida no chat.', NULL, 2, '2022-10-19 01:14:50', '2022-10-19 01:14:50', 0),
	(77, 'A Assistencia Tecnica foi inserida no chat.', NULL, 2, '2022-10-19 01:15:22', '2022-10-19 01:15:22', 0);
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.enterprises
CREATE TABLE IF NOT EXISTS `enterprises` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enterprise_type_id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnpj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enterprises_email_unique` (`email`),
  UNIQUE KEY `enterprises_cnpj_unique` (`cnpj`),
  UNIQUE KEY `enterprises_phone_unique` (`phone`),
  KEY `enterprises_enterprise_type_id_foreign` (`enterprise_type_id`),
  CONSTRAINT `enterprises_enterprise_type_id_foreign` FOREIGN KEY (`enterprise_type_id`) REFERENCES `enterprise_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.enterprises: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `enterprises` DISABLE KEYS */;
REPLACE INTO `enterprises` (`id`, `name`, `enterprise_type_id`, `email`, `cnpj`, `phone`, `created_at`, `updated_at`, `status`) VALUES
	(1, 'Admin', 1, 'admin@bermar.com.br', '147852', '17898785487', '2022-06-30 21:07:52', '2022-06-30 21:07:52', 1),
	(3, 'Assistência 01', 4, 'assistencia@bermar.com', '59.595.848/4892-92', '(65) 46488-1881', '2022-07-20 00:47:03', '2022-07-20 00:47:03', 1),
	(4, 'Assistencia 2', 4, 'assistencia2@bermar.com', '51.848.487/9794-63', '(65) 46486-4849', '2022-07-21 23:22:35', '2022-07-21 23:22:35', 1),
	(5, 'Assisntecia 3', 4, 'assistencia3@teste.com', '64.997.979/7945-11', '(65) 16516-5151', '2022-07-21 23:28:19', '2022-07-21 23:28:19', 1),
	(6, 'teste', 2, 'teste@teste12.com', '48.484.852/6262-62', '(48) 48959-5562', '2022-09-07 16:24:17', '2022-09-07 16:24:17', 1),
	(7, 'Representante 01', 3, 'representante01@teste.com', '56.668.845/5522-22', '(65) 48484-9499', '2022-10-17 23:15:16', '2022-10-17 23:15:16', 1),
	(8, 'Representante 02', 3, 'representante02@teste.com', '05.284.848/5992-92', '(51) 51488-4849', '2022-10-17 23:25:07', '2022-10-17 23:25:07', 1),
	(9, 'Revenda 01', 2, 'revenda01@bermar.com', '95.989.979/4446-41', '(17) 98585-6565', '2022-10-24 23:23:09', '2022-10-24 23:23:09', 1);
/*!40000 ALTER TABLE `enterprises` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.enterprise_products
CREATE TABLE IF NOT EXISTS `enterprise_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `enterprise_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `stock` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enterprise_products_enterprise_id_foreign` (`enterprise_id`),
  KEY `enterprise_products_product_id_foreign` (`product_id`),
  CONSTRAINT `enterprise_products_enterprise_id_foreign` FOREIGN KEY (`enterprise_id`) REFERENCES `enterprises` (`id`),
  CONSTRAINT `enterprise_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.enterprise_products: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `enterprise_products` DISABLE KEYS */;
REPLACE INTO `enterprise_products` (`id`, `enterprise_id`, `product_id`, `stock`, `status`, `created_at`, `updated_at`) VALUES
	(1, 9, 5, 10, 1, '2022-10-24 23:56:07', '2022-10-24 23:56:07'),
	(2, 9, 6, 20, 1, '2022-10-24 23:56:10', '2022-10-24 23:56:10'),
	(3, 9, 11, 10, 1, '2022-10-24 23:56:13', '2022-10-24 23:56:13');
/*!40000 ALTER TABLE `enterprise_products` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.enterprise_types
CREATE TABLE IF NOT EXISTS `enterprise_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.enterprise_types: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `enterprise_types` DISABLE KEYS */;
REPLACE INTO `enterprise_types` (`id`, `name`) VALUES
	(1, 'Bermar'),
	(2, 'Revenda'),
	(3, 'Representante'),
	(4, 'Assistencia Tecnica');
/*!40000 ALTER TABLE `enterprise_types` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_order_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_sale_order_id_foreign` (`sale_order_id`),
  CONSTRAINT `invoices_sale_order_id_foreign` FOREIGN KEY (`sale_order_id`) REFERENCES `sale_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.invoices: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
REPLACE INTO `invoices` (`id`, `name`, `sale_order_id`, `created_at`, `updated_at`) VALUES
	(1, '634dd9613f9ba_&&_2.png', 8, '2022-10-17 22:38:25', '2022-10-17 22:38:25');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.migrations: ~36 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_04_26_002248_enterprise_type', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_03_04_234621_enterprises', 1),
	(6, '2022_04_04_212029_products', 1),
	(7, '2022_04_05_000000_create_users_table', 1),
	(8, '2022_04_26_005524_enterprise_products', 1),
	(9, '2022_05_06_120951_addresses', 1),
	(10, '2022_05_10_181524_create_product_images_table', 1),
	(11, '2022_05_17_011830_create_sale_orders_table', 1),
	(12, '2022_05_17_013116_create_sale_order_items_table', 1),
	(13, '2022_05_17_230856_create_invoices_table', 1),
	(14, '2022_05_19_180528_create_categories_table', 1),
	(15, '2022_05_19_180712_update_products_add_category', 1),
	(16, '2022_05_19_220252_update_category_slug', 1),
	(17, '2022_05_20_002821_update_product_slug', 1),
	(18, '2022_07_01_000501_update_enterprise_add_status', 2),
	(19, '2022_07_02_143555_update_address', 3),
	(22, '2022_07_02_144631_token_delivery', 4),
	(23, '2022_07_02_230851_update_user_add_status', 5),
	(24, '2022_07_03_134241_update_product_add_delivery', 6),
	(25, '2022_07_06_211154_update_products_add_videos', 7),
	(26, '2022_07_08_224505_update_product_datasheet', 8),
	(28, '2022_07_18_231008_chat', 10),
	(29, '2022_07_18_231405_chat_messages', 10),
	(30, '2022_07_19_000414_chat_messages_from', 11),
	(31, '2022_07_25_180746_update_warranty_assistance_id', 12),
	(33, '2022_07_27_150143_warranty_product', 13),
	(34, '2022_08_03_004751_budgets', 14),
	(35, '2022_08_03_005226_budget_items', 14),
	(36, '2022_08_20_153125_update_prduct_add_volts', 15),
	(37, '2022_09_07_160824_update_addresses_add_region', 16),
	(38, '2022_10_12_134703_price_tables', 17),
	(42, '2022_10_12_134955_prices', 18),
	(43, '2022_07_16_133216_warranty', 19);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.personal_access_tokens: ~37 rows (aproximadamente)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
REPLACE INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 1, 'JWT', '99ed3d8b9e14a15b3dd80503d06fce16a92bb9efddeeac21a5edf4ddf6d40bb0', '["*"]', '2022-07-07 14:10:40', '2022-07-01 00:09:46', '2022-07-07 14:10:40'),
	(2, 'App\\Models\\User', 1, 'JWT', '8ec15bca7033bf87c3c7f49eb64f2200bf8a0e0885a3a50f770ede8162ad8d63', '["*"]', NULL, '2022-07-01 01:44:48', '2022-07-01 01:44:48'),
	(3, 'App\\Models\\User', 1, 'JWT', '134f70f69af4dac75577eeaeda91bba7b002eda90d88386aed9f8857ea571c4f', '["*"]', NULL, '2022-07-01 12:33:21', '2022-07-01 12:33:21'),
	(4, 'App\\Models\\User', 1, 'JWT', 'a300d5abdc8bce93df1b323767cd4c6beb16654a98d51e78fbf65fc58b9e0dca', '["*"]', NULL, '2022-07-07 14:23:27', '2022-07-07 14:23:27'),
	(5, 'App\\Models\\User', 1, 'JWT', 'c78b57b415ba0a4bd3c1866e907e1ac5b469b6734d2539fbd9634cfaf2cef8fa', '["*"]', NULL, '2022-07-07 14:44:17', '2022-07-07 14:44:17'),
	(6, 'App\\Models\\User', 1, 'JWT', '7c7e82f76df5e740af3013164a53fafaea7ba4fc357c3b70caa95d3df45b86bd', '["*"]', NULL, '2022-07-07 16:17:57', '2022-07-07 16:17:57'),
	(7, 'App\\Models\\User', 1, 'JWT', '37f3631891c889452fe70283aa4f9306e13724c22c94aee0f24cae6cfd2ad07f', '["*"]', NULL, '2022-07-07 16:17:58', '2022-07-07 16:17:58'),
	(8, 'App\\Models\\User', 1, 'JWT', '673064a204ff686033b3a1b0dca9c7f74d4554f4307d33c4fd5496b76042713e', '["*"]', '2022-07-08 00:03:36', '2022-07-07 21:19:47', '2022-07-08 00:03:36'),
	(9, 'App\\Models\\User', 1, 'JWT', 'b70460d44c250f8fda9c2e281a6a7c4a25c79f127cb5f64fe7f05be77b24c8e5', '["*"]', NULL, '2022-07-13 00:07:03', '2022-07-13 00:07:03'),
	(10, 'App\\Models\\User', 1, 'JWT', '0de83b877a7eb73f0f8fa8cf9d6db330ee35d51508a1c2c1150f4b489ef99d7c', '["*"]', '2022-07-19 02:41:14', '2022-07-15 23:05:10', '2022-07-19 02:41:14'),
	(11, 'App\\Models\\User', 2, 'JWT', 'bfe785c6e4ade28e0e074f37c3e7fa2d61db182f0199520a067b7dc807c694f4', '["*"]', NULL, '2022-07-19 02:42:32', '2022-07-19 02:42:32'),
	(12, 'App\\Models\\User', 2, 'JWT', 'c67331c2456fb4fc30928b0bfaf17d89bd2ac163cad7258680d2b6ca05266ffa', '["*"]', '2022-07-19 21:46:45', '2022-07-19 02:48:30', '2022-07-19 21:46:45'),
	(13, 'App\\Models\\User', 1, 'JWT', '82c764306653285467b65a9438a3f49f3d2c7997738450903af82a73ce174077', '["*"]', '2022-07-25 21:45:12', '2022-07-19 21:47:41', '2022-07-25 21:45:12'),
	(14, 'App\\Models\\User', 3, 'JWT', '12e3e2d43bff4fd7b5ae2ab06046249f5b2ed7e6787422e186f8b36113d4ea78', '["*"]', NULL, '2022-07-25 21:46:59', '2022-07-25 21:46:59'),
	(15, 'App\\Models\\User', 2, 'JWT', '3867359fa4cd6b4a6b07dcce3c22b204711de17c4867a3c91d5a2aeec2ccfd97', '["*"]', NULL, '2022-07-26 00:48:33', '2022-07-26 00:48:33'),
	(16, 'App\\Models\\User', 2, 'JWT', '80736affb013fb3788eab44959c7b617a32a690b21da6a103aeaea168ac2a1a6', '["*"]', NULL, '2022-07-26 00:50:32', '2022-07-26 00:50:32'),
	(17, 'App\\Models\\User', 2, 'JWT', '6bcdce3a3d82955eff0ef1c676d50d20956c53b451fa2d4adb10a43fe6474cc8', '["*"]', NULL, '2022-07-26 00:52:43', '2022-07-26 00:52:43'),
	(18, 'App\\Models\\User', 2, 'JWT', 'd387f95a8dd1dac18d73cc6ab7072492ec7e48de29da703fa16d5acd38da3ae3', '["*"]', NULL, '2022-07-26 00:55:38', '2022-07-26 00:55:38'),
	(19, 'App\\Models\\User', 1, 'JWT', '595caf8fd6d38bb675cd80ca811b1fa6c6151c0a55f8031efbd9b469cded554a', '["*"]', NULL, '2022-07-26 01:09:19', '2022-07-26 01:09:19'),
	(20, 'App\\Models\\User', 2, 'JWT', '98b2f044ac023b0c2a591237e3f36dc242542d056aa970e107da99bda78b7ed6', '["*"]', NULL, '2022-07-26 01:10:08', '2022-07-26 01:10:08'),
	(21, 'App\\Models\\User', 3, 'JWT', '23ee3c33ae64d6273e99b2d553fe0aaa711ffd11884276aded789b835057efd2', '["*"]', NULL, '2022-07-26 01:15:06', '2022-07-26 01:15:06'),
	(22, 'App\\Models\\User', 1, 'JWT', '2f22373f7d6bf3a54b9cfd3d61e125b2ae5dbe16d94b16f8523f087a3d68fdea', '["*"]', NULL, '2022-07-26 01:18:51', '2022-07-26 01:18:51'),
	(23, 'App\\Models\\User', 3, 'JWT', '3da53dd07f87c4c01f61068ed8972de269253632cb064a8280ad5e1fcf43ba74', '["*"]', NULL, '2022-07-26 01:22:00', '2022-07-26 01:22:00'),
	(24, 'App\\Models\\User', 1, 'JWT', '5848dfb957374f713fc240ced9d498871ae560858dbba5e3c1a315699d67b9b1', '["*"]', '2022-07-26 11:21:28', '2022-07-26 01:25:44', '2022-07-26 11:21:28'),
	(25, 'App\\Models\\User', 1, 'JWT', '361d8dab8a9d22dcb155c10a571d863beef09c3ce1ef9463806e5981e60c2fcb', '["*"]', '2022-08-03 01:50:06', '2022-07-26 11:28:33', '2022-08-03 01:50:06'),
	(26, 'App\\Models\\User', 2, 'JWT', 'b6c0c3a2497c9b500049a9fadc931081e324e1dfa0c96124887b3f68a10eb823', '["*"]', NULL, '2022-07-26 17:05:44', '2022-07-26 17:05:44'),
	(27, 'App\\Models\\User', 3, 'JWT', 'a0d76b015992d245c16b51bc5a84188279111c3b762afcb07a1344c771e172ae', '["*"]', NULL, '2022-07-26 17:08:04', '2022-07-26 17:08:04'),
	(28, 'App\\Models\\User', 1, 'JWT', 'f4b25e24acaee856cab91f03982323317c231bb85cd58fda9663af2bcddfcd51', '["*"]', NULL, '2022-08-04 18:34:39', '2022-08-04 18:34:39'),
	(29, 'App\\Models\\User', 1, 'JWT', 'c03f67158c180458505c5ea000a99248f8196b892159eaeb649e4ebb904920bb', '["*"]', NULL, '2022-08-08 12:38:42', '2022-08-08 12:38:42'),
	(30, 'App\\Models\\User', 1, 'JWT', '4476bac8d7299c52f8f5a9806c80f15da3981ef84b45dc8b9a3f267fe06799ee', '["*"]', NULL, '2022-08-08 12:59:02', '2022-08-08 12:59:02'),
	(31, 'App\\Models\\User', 1, 'JWT', '6239ce72e90aaa9e8f16c2ceb28f5206cb6d9d2c1dcc6fa8013b4d5216fa8d1b', '["*"]', '2022-08-08 22:04:07', '2022-08-08 13:12:30', '2022-08-08 22:04:07'),
	(32, 'App\\Models\\User', 1, 'JWT', '43ef4404e9059636271eb2a95fc50a4ce927532fadd41bbf64ae667dc9a11783', '["*"]', '2022-10-17 23:31:55', '2022-08-20 13:48:55', '2022-10-17 23:31:55'),
	(33, 'App\\Models\\User', 4, 'JWT', 'd0ac0e2423db9320d7e365d61f1a51157aa4a5544b4a8a728b4b40d23d731f3f', '["*"]', '2022-10-18 22:27:22', '2022-10-17 23:34:40', '2022-10-18 22:27:22'),
	(34, 'App\\Models\\User', 2, 'JWT', '8a3dc3d82cb7933f0ee368071e09b04819b64a03368f6136c341ed822a39c5ad', '["*"]', NULL, '2022-10-18 22:28:25', '2022-10-18 22:28:25'),
	(35, 'App\\Models\\User', 3, 'JWT', '1c6d11a1ea56c446ff93e99110b74c1b4599deb434564f258379d2824e2fc010', '["*"]', NULL, '2022-10-19 00:42:15', '2022-10-19 00:42:15'),
	(36, 'App\\Models\\User', 3, 'JWT', '81034a065314c3de2c530ff3d06ca3a94453a8d188db1b00ca126a894aa5cf01', '["*"]', NULL, '2022-10-19 00:53:40', '2022-10-19 00:53:40'),
	(37, 'App\\Models\\User', 1, 'JWT', '88002213780d2b3e36d145e95521c90219a34e9c0c5dbec7fa4bcd3e71dd37d6', '["*"]', NULL, '2022-10-19 00:55:27', '2022-10-19 00:55:27'),
	(38, 'App\\Models\\User', 3, 'JWT', '99dc18ab78650190d52f2dd6c047d433eae23b5b7f78341910a7fea7b6bdd478', '["*"]', '2022-10-24 22:10:35', '2022-10-19 01:17:37', '2022-10-24 22:10:35'),
	(39, 'App\\Models\\User', 4, 'JWT', '1f2f93aa054495799e5ae7d71a44df16dd4a866746e11c084ea9b0aa28d6a3f3', '["*"]', NULL, '2022-10-24 22:11:24', '2022-10-24 22:11:24'),
	(40, 'App\\Models\\User', 1, 'JWT', 'ee7f7d8ec601cb3f012230130f62fdf526a030e1cdde5bc5059c66141c1cdabe', '["*"]', NULL, '2022-10-24 22:19:51', '2022-10-24 22:19:51'),
	(41, 'App\\Models\\User', 5, 'JWT', '652b676ac80276980704ea2de82968ff25f81b76ba9102da83fbbed1dd1738bb', '["*"]', '2022-10-25 13:18:25', '2022-10-24 23:24:50', '2022-10-25 13:18:25');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.prices
CREATE TABLE IF NOT EXISTS `prices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `price_table_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prices_price_table_id_foreign` (`price_table_id`),
  KEY `prices_product_id_foreign` (`product_id`),
  CONSTRAINT `prices_price_table_id_foreign` FOREIGN KEY (`price_table_id`) REFERENCES `price_tables` (`id`),
  CONSTRAINT `prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.prices: ~16 rows (aproximadamente)
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
REPLACE INTO `prices` (`id`, `price_table_id`, `product_id`, `price`, `created_at`, `updated_at`) VALUES
	(57, 23, 5, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(58, 23, 6, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(59, 23, 10, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(60, 23, 11, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(61, 23, 12, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(62, 23, 13, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(63, 23, 14, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(64, 23, 15, 10.00, '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(65, 24, 5, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59'),
	(66, 24, 6, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59'),
	(67, 24, 10, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59'),
	(68, 24, 11, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59'),
	(69, 24, 12, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59'),
	(70, 24, 13, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59'),
	(71, 24, 14, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59'),
	(72, 24, 15, 20.00, '2022-10-17 21:19:59', '2022-10-17 21:19:59');
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.price_tables
CREATE TABLE IF NOT EXISTS `price_tables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.price_tables: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `price_tables` DISABLE KEYS */;
REPLACE INTO `price_tables` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(23, 'SP', '2022-10-17 21:19:36', '2022-10-17 21:19:36'),
	(24, 'MG', '2022-10-17 21:19:59', '2022-10-17 21:19:59');
/*!40000 ALTER TABLE `price_tables` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datasheet` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` decimal(8,2) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `length` decimal(8,2) DEFAULT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `power` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voltage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packing_width` decimal(8,2) DEFAULT NULL,
  `packing_weight` decimal(8,2) DEFAULT NULL,
  `packing_length` decimal(8,2) DEFAULT NULL,
  `packing_height` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.products: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
REPLACE INTO `products` (`id`, `name`, `description`, `datasheet`, `image`, `price`, `status`, `created_at`, `updated_at`, `deleted_at`, `category_id`, `slug`, `width`, `weight`, `length`, `height`, `video`, `power`, `voltage`, `packing_width`, `packing_weight`, `packing_length`, `packing_height`) VALUES
	(5, 'AMACIADOR E PREPARADOR DE CARNES EM AÇO INOX COM BOCAL DE 175MM- BM 34 NR PF – BIVOLT', '<p>Teste</p><ol><li>	teste</li><li>teste</li><li>teste</li><li>tete5</li></ol>', NULL, NULL, 5000.00, 1, NULL, NULL, NULL, 2, 'amaciador_e_preparador_de_carnes_em_aco_inox_com_bocal_de_175mm_bm_34_nr_pf_bivolt', 20.00, 30.00, 50.00, 50.00, 'https://www.youtube.com/embed/6xfs4CY5cqY', NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'produto 2', '<p>Teste</p>', '<p>teste</p>', NULL, 500.00, 1, NULL, NULL, NULL, 2, 'produto_2', 50.00, 50.00, 50.00, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(10, 'produto 3', '<p>teste1	</p>', '<p>teste2</p>', NULL, 900.00, 1, NULL, NULL, NULL, 2, 'produto_3', 50.00, 50.00, 50.00, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(11, 'produto 4', '<p>teste</p>', '<p>teste</p>', NULL, 500.00, 1, NULL, NULL, NULL, 2, 'produto_4', 5.00, 5.00, 50.00, 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(12, 'produto 5', '<p>teste1	</p>', '<p>teste2</p>', NULL, 900.00, 1, NULL, NULL, NULL, 2, 'produto_5', 50.00, 50.00, 50.00, 50.00, 'https://www.youtube.com/embed/6xfs4CY5cqY', NULL, NULL, NULL, NULL, NULL, NULL),
	(13, 'Produto 6', '<h1>TESTANDO</h1><p><br></p><ol><li>TESTE1</li><li>TESTE2</li><li>TESTE3</li></ol><p><br></p>', '<p>TESTE</p><ul><li>TESTE</li><li>TESTE</li><li>TESTE</li></ul>', NULL, 5000.00, 1, NULL, NULL, NULL, 2, 'produto_6', 50.00, 50.00, 50.00, 50.00, 'https://www.youtube.com/embed/6xfs4CY5cqY', NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 'teste3', '<p>teste1</p>', '<p>teste2</p>', NULL, 5.00, 1, NULL, NULL, NULL, 3, 'teste3', 50.00, 50.00, 50.00, 50.00, 'https://www.youtube.com/embed/Z9Wjxp8bMlI', '2000', '110', 60.00, 60.00, 60.00, 60.00),
	(15, 'teste renato', '<p>teste</p>', '<p>teste</p>', NULL, 50.00, 1, NULL, NULL, NULL, 2, 'teste_renato', 50.00, 50.00, 50.00, 50.00, 'https://www.youtube.com/embed/tV2zqiu8oy0&t=136', '2000', '220', 70.00, 70.00, 70.00, 70.00);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.product_images: ~15 rows (aproximadamente)
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
REPLACE INTO `product_images` (`id`, `name`, `product_id`, `created_at`, `updated_at`) VALUES
	(28, '62c74f58cdc6b_&&_b2.jpg', 5, '2022-07-07 21:25:44', '2022-07-07 21:25:44'),
	(29, '62c74f5bcbc72_&&_b3.jpg', 5, '2022-07-07 21:25:47', '2022-07-07 21:25:47'),
	(30, '62c74f5f2314e_&&_b4.jpg', 5, '2022-07-07 21:25:51', '2022-07-07 21:25:51'),
	(31, '62ce0cd474ff7_&&_b7.jpg', 6, '2022-07-13 00:07:48', '2022-07-13 00:07:48'),
	(32, '62ce0cd80515b_&&_b6.jpg', 6, '2022-07-13 00:07:52', '2022-07-13 00:07:52'),
	(33, '62ce0cdb52d2e_&&_b5.jpg', 6, '2022-07-13 00:07:55', '2022-07-13 00:07:55'),
	(36, '62ce131d08ddb_&&_b3.jpg', 10, '2022-07-13 00:34:37', '2022-07-13 00:34:37'),
	(37, '62ce1320ab4a6_&&_b4.jpg', 10, '2022-07-13 00:34:40', '2022-07-13 00:34:40'),
	(38, '62ce13c201cd5_&&_b4.jpg', 11, '2022-07-13 00:37:22', '2022-07-13 00:37:22'),
	(39, '62ce13c5387b4_&&_b7.jpg', 11, '2022-07-13 00:37:25', '2022-07-13 00:37:25'),
	(40, '62ce14cc483cb_&&_b3.jpg', 12, '2022-07-13 00:41:48', '2022-07-13 00:41:48'),
	(41, '62ce14cfafb9f_&&_b8.jpg', 12, '2022-07-13 00:41:51', '2022-07-13 00:41:51'),
	(42, '62ce2223be28d_&&_b2.jpg', 13, '2022-07-13 01:38:43', '2022-07-13 01:38:43'),
	(43, '62ce222739e5d_&&_b4.jpg', 13, '2022-07-13 01:38:47', '2022-07-13 01:38:47'),
	(44, '62ce222a9b685_&&_b7.jpg', 13, '2022-07-13 01:38:50', '2022-07-13 01:38:50'),
	(45, '6301210d72fb6_&&_b6.jpg', 14, '2022-08-20 17:59:41', '2022-08-20 17:59:41'),
	(46, '63012111478be_&&_b3.jpg', 14, '2022-08-20 17:59:45', '2022-08-20 17:59:45'),
	(47, '630e065d3fe55_&&_b5.jpg', 15, '2022-08-30 12:45:17', '2022-08-30 12:45:17'),
	(48, '630e06604ea7d_&&_b7.jpg', 15, '2022-08-30 12:45:20', '2022-08-30 12:45:20');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.sale_orders
CREATE TABLE IF NOT EXISTS `sale_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `enterprise_id` bigint(20) unsigned NOT NULL,
  `status` int(11) NOT NULL,
  `status_payment` int(11) NOT NULL,
  `status_delivery` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_orders_user_id_foreign` (`user_id`),
  KEY `sale_orders_enterprise_id_foreign` (`enterprise_id`),
  CONSTRAINT `sale_orders_enterprise_id_foreign` FOREIGN KEY (`enterprise_id`) REFERENCES `enterprises` (`id`),
  CONSTRAINT `sale_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.sale_orders: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `sale_orders` DISABLE KEYS */;
REPLACE INTO `sale_orders` (`id`, `user_id`, `enterprise_id`, `status`, `status_payment`, `status_delivery`, `created_at`, `updated_at`) VALUES
	(4, 2, 1, 1, 1, 1, '2022-07-15 22:55:06', '2022-07-15 22:55:06'),
	(5, 2, 1, 1, 1, 1, '2022-07-16 13:18:03', '2022-07-16 13:18:03'),
	(6, 2, 1, 1, 1, 1, '2022-10-05 01:42:26', '2022-10-05 01:42:26'),
	(8, 1, 3, 1, 1, 1, '2022-10-09 22:20:09', '2022-10-09 22:20:09'),
	(9, 1, 3, 1, 1, 1, '2022-10-12 13:26:15', '2022-10-12 13:26:15'),
	(10, 1, 5, 1, 1, 1, '2022-10-12 13:27:38', '2022-10-12 13:27:38'),
	(11, 1, 4, 1, 1, 1, '2022-10-12 13:33:44', '2022-10-12 13:33:44'),
	(12, 1, 3, 1, 1, 1, '2022-10-12 13:37:38', '2022-10-12 13:37:38'),
	(13, 1, 4, 1, 1, 1, '2022-10-17 22:19:41', '2022-10-17 22:19:41'),
	(14, 1, 5, 1, 1, 1, '2022-10-17 22:37:48', '2022-10-17 22:37:48'),
	(15, 1, 5, 1, 1, 1, '2022-10-17 23:17:39', '2022-10-17 23:17:39'),
	(16, 4, 6, 1, 1, 1, '2022-10-18 00:05:36', '2022-10-18 00:05:36');
/*!40000 ALTER TABLE `sale_orders` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.sale_order_items
CREATE TABLE IF NOT EXISTS `sale_order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sale_order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_order_items_sale_order_id_foreign` (`sale_order_id`),
  KEY `sale_order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `sale_order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sale_order_items_sale_order_id_foreign` FOREIGN KEY (`sale_order_id`) REFERENCES `sale_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.sale_order_items: ~22 rows (aproximadamente)
/*!40000 ALTER TABLE `sale_order_items` DISABLE KEYS */;
REPLACE INTO `sale_order_items` (`id`, `sale_order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
	(1, 4, 5, 1, 5000.00, '2022-07-15 22:55:06', '2022-07-15 22:55:06'),
	(2, 5, 5, 1, 5000.00, '2022-07-16 13:18:03', '2022-07-16 13:18:03'),
	(3, 6, 5, 1, 5000.00, '2022-10-05 01:42:26', '2022-10-05 01:42:26'),
	(4, 8, 5, 1, 5000.00, '2022-10-09 22:20:09', '2022-10-09 22:20:09'),
	(5, 8, 6, 2, 500.00, '2022-10-09 22:20:09', '2022-10-09 22:20:09'),
	(6, 9, 6, 2, 500.00, '2022-10-12 13:26:15', '2022-10-12 13:26:15'),
	(7, 9, 10, 1, 900.00, '2022-10-12 13:26:15', '2022-10-12 13:26:15'),
	(8, 9, 12, 2, 900.00, '2022-10-12 13:26:15', '2022-10-12 13:26:15'),
	(9, 10, 5, 1, 5000.00, '2022-10-12 13:27:38', '2022-10-12 13:27:38'),
	(10, 10, 6, 1, 500.00, '2022-10-12 13:27:38', '2022-10-12 13:27:38'),
	(11, 10, 10, 2, 900.00, '2022-10-12 13:27:38', '2022-10-12 13:27:38'),
	(12, 11, 5, 1, 5000.00, '2022-10-12 13:33:44', '2022-10-12 13:33:44'),
	(13, 11, 6, 1, 500.00, '2022-10-12 13:33:44', '2022-10-12 13:33:44'),
	(14, 12, 5, 1, 5000.00, '2022-10-12 13:37:39', '2022-10-12 13:37:39'),
	(15, 12, 10, 2, 900.00, '2022-10-12 13:37:39', '2022-10-12 13:37:39'),
	(16, 13, 5, 10, 5000.00, '2022-10-17 22:19:41', '2022-10-17 22:19:41'),
	(17, 14, 5, 2, 10.00, '2022-10-17 22:37:48', '2022-10-17 22:37:48'),
	(18, 15, 5, 4, 10.00, '2022-10-17 23:17:39', '2022-10-17 23:17:39'),
	(19, 15, 6, 3, 10.00, '2022-10-17 23:17:39', '2022-10-17 23:17:39'),
	(20, 16, 5, 1, 10.00, '2022-10-18 00:05:36', '2022-10-18 00:05:36'),
	(21, 16, 6, 1, 10.00, '2022-10-18 00:05:36', '2022-10-18 00:05:36'),
	(22, 16, 10, 2, 10.00, '2022-10-18 00:05:36', '2022-10-18 00:05:36');
/*!40000 ALTER TABLE `sale_order_items` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.token_delivery
CREATE TABLE IF NOT EXISTS `token_delivery` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.token_delivery: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `token_delivery` DISABLE KEYS */;
REPLACE INTO `token_delivery` (`id`, `token`, `created_at`, `updated_at`) VALUES
	(3, 'BTuvKwCwKsqQpoOOby6GJAHRT0yX3oPsWcbj7mJvyiQdtKx0LzENbMAGpIRPPG6Ac6BnAmr90zH6XvUXLUE4E8JgyZhlPHuvutqD1LHJzHKR0NKfzcUw1rwtb1QV_epZA_Z5OIBCNRDXBOImmLhBTiedsz_LXbgUf7kxfH2yf4fW35nQ8SneQa8RZA_XNfPGlQrsnIT-5yUXqClsuZlonQdS5LI4BVrhBT8ahNODuLGPqT-XZOpKDle14dqn3_LkKojKle9H8nr7OWUJRHtTjQU4PwVqZhYmYb7x-DbtYrQk_r9LbRezEAIa-S98zeQYiHg3C5_CVp1vlWhg2UgbA-GTQsP0nc85nkC4QpklrwRRydVXuIooFLEX8CPhU7rr2sDh8zWeOAGRUAuoYSReGJqt0XPs_qZCqzZKcqn6CgkVzWViTvDYd_cTT4gp9W8weNs3N1sAqNUp8YM3_xm9_A', '2022-07-02 19:15:03', '2022-10-24 23:22:55');
/*!40000 ALTER TABLE `token_delivery` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enterprise_id` bigint(20) unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_cpf_unique` (`cpf`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_enterprise_id_foreign` (`enterprise_id`),
  CONSTRAINT `users_enterprise_id_foreign` FOREIGN KEY (`enterprise_id`) REFERENCES `enterprises` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.users: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `cpf`, `phone`, `enterprise_id`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
	(0, 'Chat Bot', 'bot@bermar.com.br', '2022-07-25 15:57:52', '$2y$10$SDjqFGLx8j1GRE5cw.XSsugROIxNfyOvReffdReMxsX4o21dCNoSC', '151519595959', '5151848484848', 1, NULL, NULL, NULL, 1),
	(1, 'Admin', 'admin@bermar.com.br', '2022-06-30 21:09:17', '$2y$10$SDjqFGLx8j1GRE5cw.XSsugROIxNfyOvReffdReMxsX4o21dCNoSC', '147.856.987.55', '(17) 96985-8585', 1, NULL, NULL, '2022-07-20 00:54:19', 1),
	(2, 'Ricardo Usario site', 'ricardo@teste.com', '2022-06-30 21:09:17', '$2y$10$SDjqFGLx8j1GRE5cw.XSsugROIxNfyOvReffdReMxsX4o21dCNoSC', '147.856.987.66', '(17) 96985-8566', NULL, NULL, NULL, '2022-07-20 00:54:07', 1),
	(3, 'Fernando Assistencia', 'fernando@assistencia.com', NULL, '$2y$10$SDjqFGLx8j1GRE5cw.XSsugROIxNfyOvReffdReMxsX4o21dCNoSC', '858.585.474.74', '(32) 13215-1565', 3, NULL, '2022-07-20 00:53:52', '2022-07-20 00:53:52', 1),
	(4, 'Renato 1 - Representante', 'renato@teste.com', NULL, '$2y$10$SapOzaXY4YHqbsD6gSYPJut/UbOVhMOnIKQMPLNLppfH57mJPvd6a', '655.994.848.81', '(19) 84655-6597', 8, NULL, '2022-10-17 23:31:54', '2022-10-17 23:31:54', 1),
	(5, 'renato vendas', 'renatovendas@teste.com', NULL, '$2y$10$HjQt6KoZMQzEijtO0IcYWOobdpi6fd0aQSQjl3mp98Lu8A4.GuVm6', '646.454.849.79', '(66) 46444-9497', 9, NULL, '2022-10-24 23:24:34', '2022-10-24 23:24:34', 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.warranties
CREATE TABLE IF NOT EXISTS `warranties` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warranties_product_id_foreign` (`product_id`),
  CONSTRAINT `warranties_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.warranties: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `warranties` DISABLE KEYS */;
REPLACE INTO `warranties` (`id`, `status`, `product_id`, `created_at`, `updated_at`) VALUES
	(2, 1, 11, '2022-10-18 22:27:22', '2022-10-24 23:11:52');
/*!40000 ALTER TABLE `warranties` ENABLE KEYS */;

-- Copiando estrutura para tabela bermar.warranty_products
CREATE TABLE IF NOT EXISTS `warranty_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela bermar.warranty_products: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `warranty_products` DISABLE KEYS */;
REPLACE INTO `warranty_products` (`id`, `name`, `description`, `price`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'teste', NULL, 55.55, 1, '2022-07-28 14:44:58', '2022-07-28 14:44:58', NULL),
	(2, 'teste2', NULL, 5.55, 1, '2022-07-28 14:47:59', '2022-07-28 14:47:59', NULL);
/*!40000 ALTER TABLE `warranty_products` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
