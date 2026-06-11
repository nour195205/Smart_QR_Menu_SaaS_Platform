-- Complete MySQL Dump for InfinityFree (ALL Laravel Tables)
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `social_links` text COLLATE utf8mb4_unicode_ci,
  `menu_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dynamic',
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `has_unpublished_changes` tinyint(1) NOT NULL DEFAULT '0',
  `last_published_at` timestamp NULL DEFAULT NULL,
  `last_sync_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sync_error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `restaurants_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint unsigned NOT NULL,
  `primary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#FF6B35',
  `secondary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2E294E',
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#FFFFFF',
  `text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1A1A2E',
  `category_title_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1A1A2E',
  `item_title_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1A1A2E',
  `item_description_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#666666',
  `item_price_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#FF6B35',
  `card_background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#FFFFFF',
  `text_alignment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `font_family` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Outfit',
  `card_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rounded',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `layout_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'grid',
  `advanced_settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_restaurant_id_unique` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `qr_styles`;
CREATE TABLE `qr_styles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint unsigned NOT NULL,
  `dot_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rounded',
  `corner_square_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'extra-rounded',
  `corner_dot_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dot',
  `dot_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#000000',
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#FFFFFF',
  `gradient_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `gradient_color_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gradient_color_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gradient_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frame_style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bottom_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qr_styles_restaurant_id_unique` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pdf_menus`;
CREATE TABLE `pdf_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` bigint unsigned NOT NULL,
  `pdf_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_05_27_180103_create_personal_access_tokens_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_01_01_000001_create_restaurants_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_01_01_000002_create_categories_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_01_01_000003_create_items_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_01_01_000004_create_themes_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_01_01_000005_create_qr_styles_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_01_01_000006_create_pdf_menus_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_06_11_143344_add_granular_styles_to_themes_table', '4');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_06_11_153320_add_advanced_settings_to_themes_table', '5');

-- Data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'nour', 'ashournour36@gmail.com', NULL, '$2y$12$QS63BtkawDmR..KD4iGZk.wHz5UDRnQRhzhfH02Gy/rFG/MJBhuXO', NULL, '2026-05-27 18:48:28', '2026-05-27 18:48:28');

-- Data for table `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('2OTnlFjkjh7Z7QuNGB1EN5eJYws8h8TTx5TkcBif', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicmcwZ1BKbTRZTzVYVHhRWEtBQkVzNXlPNnlVWG9EY2tVQ3VzTlVQaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', '1781184473');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('m1WEkdfhMTHI3mPPmsitIaWqPRo9YAouXZhAuFcH', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVVBdXpTR01xRndYcE9HMnBLb3ZrT1JDclhGSk9ZOGFkc081aWhEbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQvdGhlbWUiO3M6NToicm91dGUiO3M6MjA6ImRhc2hib2FyZC50aGVtZS5lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', '1781193123');

-- Data for table `restaurants`
INSERT INTO `restaurants` (`id`, `user_id`, `name`, `slug`, `logo_url`, `cover_url`, `description`, `phone`, `address`, `social_links`, `menu_type`, `currency_code`, `currency_symbol`, `is_active`, `has_unpublished_changes`, `last_published_at`, `last_sync_status`, `sync_error_message`, `created_at`, `updated_at`) VALUES ('1', '1', '300', '300', NULL, NULL, NULL, NULL, NULL, NULL, 'dynamic', 'USD', '$', '1', '0', '2026-06-11 15:52:03', 'success', NULL, '2026-05-27 18:48:28', '2026-06-11 15:52:03');

-- Data for table `themes`
INSERT INTO `themes` (`id`, `restaurant_id`, `primary_color`, `secondary_color`, `background_color`, `text_color`, `font_family`, `card_style`, `dark_mode`, `layout_style`, `created_at`, `updated_at`, `category_title_color`, `item_title_color`, `item_description_color`, `item_price_color`, `card_background_color`, `text_alignment`, `advanced_settings`) VALUES ('1', '1', '#10B981', '#000000', '#F3F4F6', '#1F2937', 'Inter', 'rounded', '0', 'list', '2026-05-27 18:48:28', '2026-06-11 15:49:13', '#111827', '#111827', '#6B7280', '#10B981', '#FFFFFF', 'left', '{\"image_position\":\"left\",\"image_shape\":\"rounded\",\"card_hover_effect\":\"lift\",\"animation_style\":\"fade\",\"animation_speed\":\"normal\"}');

-- Data for table `categories`
INSERT INTO `categories` (`id`, `restaurant_id`, `name`, `description`, `image_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', '1', 'حلو', NULL, NULL, '0', '1', '2026-05-28 14:00:07', '2026-05-28 14:00:07');

-- Data for table `items`
INSERT INTO `items` (`id`, `restaurant_id`, `category_id`, `name`, `description`, `price`, `image_url`, `tags`, `is_available`, `sort_order`, `created_at`, `updated_at`) VALUES ('2', '1', '2', 'تشيز كيك', 'هيبرتهخ', '75', NULL, '[\"\\u0634\\u0643\\u064a\\u0647\\u0627\\u0628\\u0634\\u0647\\u062e\"]', '1', '0', '2026-05-28 14:00:30', '2026-06-11 14:33:04');

-- Data for table `qr_styles`
INSERT INTO `qr_styles` (`id`, `restaurant_id`, `dot_style`, `corner_square_style`, `corner_dot_style`, `dot_color`, `background_color`, `gradient_enabled`, `gradient_color_1`, `gradient_color_2`, `gradient_type`, `logo_url`, `frame_style`, `top_text`, `bottom_text`, `created_at`, `updated_at`) VALUES ('1', '1', 'rounded', 'square', 'square', '#ffffff', '#55171c', '0', '#000000', '#000000', 'linear', NULL, NULL, NULL, NULL, '2026-05-27 18:48:28', '2026-05-27 19:23:36');

-- Data for table `pdf_menus`
INSERT INTO `pdf_menus` (`id`, `restaurant_id`, `pdf_url`, `original_name`, `created_at`, `updated_at`) VALUES ('5', '1', 'http://127.0.0.1:8000/storage/qrmenu/300/pdfs/6a179d50f2e70.tmp', 'QR_compressed.pdf', '2026-05-28 01:41:37', '2026-05-28 01:41:37');

SET FOREIGN_KEY_CHECKS=1;
