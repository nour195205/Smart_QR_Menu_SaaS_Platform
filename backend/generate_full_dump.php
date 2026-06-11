<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$schema = <<<SQL
-- Complete MySQL Dump for InfinityFree
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

SQL;

$tables = ['users', 'restaurants', 'themes', 'categories', 'items', 'qr_styles', 'pdf_menus'];

foreach ($tables as $table) {
    $rows = DB::table($table)->get();
    if ($rows->isEmpty()) continue;
    
    $schema .= "\n-- Data for table `$table`\n";
    foreach ($rows as $row) {
        $data = (array) $row;
        $keys = array_map(function ($k) { return "`$k`"; }, array_keys($data));
        $values = array_map(function ($v) {
            if ($v === null) return 'NULL';
            return "'" . addslashes((string)$v) . "'";
        }, array_values($data));
        
        $keysStr = implode(', ', $keys);
        $valuesStr = implode(', ', $values);
        $schema .= "INSERT INTO `$table` ($keysStr) VALUES ($valuesStr);\n";
    }
}

$schema .= "\nSET FOREIGN_KEY_CHECKS=1;\n";

if (!is_dir(__DIR__.'/info')) {
    mkdir(__DIR__.'/info');
}

file_put_contents(__DIR__.'/info/complete_mysql_dump.sql', $schema);
echo "Successfully generated full MySQL dump at info/complete_mysql_dump.sql\n";
