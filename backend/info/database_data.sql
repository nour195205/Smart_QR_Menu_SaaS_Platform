-- MySQL Data Export
-- Generated for InfinityFree Migration

-- Data for table `users`
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'nour', 'ashournour36@gmail.com', NULL, '$2y$12$QS63BtkawDmR..KD4iGZk.wHz5UDRnQRhzhfH02Gy/rFG/MJBhuXO', NULL, '2026-05-27 18:48:28', '2026-05-27 18:48:28');

-- Data for table `restaurants`
INSERT IGNORE INTO `restaurants` (`id`, `user_id`, `name`, `slug`, `logo_url`, `cover_url`, `description`, `phone`, `address`, `social_links`, `menu_type`, `currency_code`, `currency_symbol`, `is_active`, `has_unpublished_changes`, `last_published_at`, `last_sync_status`, `sync_error_message`, `created_at`, `updated_at`) VALUES ('1', '1', '300', '300', NULL, NULL, NULL, NULL, NULL, NULL, 'dynamic', 'USD', '$', '1', '0', '2026-06-11 15:52:03', 'success', NULL, '2026-05-27 18:48:28', '2026-06-11 15:52:03');

-- Data for table `themes`
INSERT IGNORE INTO `themes` (`id`, `restaurant_id`, `primary_color`, `secondary_color`, `background_color`, `text_color`, `font_family`, `card_style`, `dark_mode`, `layout_style`, `created_at`, `updated_at`, `category_title_color`, `item_title_color`, `item_description_color`, `item_price_color`, `card_background_color`, `text_alignment`, `advanced_settings`) VALUES ('1', '1', '#10B981', '#000000', '#F3F4F6', '#1F2937', 'Inter', 'rounded', '0', 'list', '2026-05-27 18:48:28', '2026-06-11 15:49:13', '#111827', '#111827', '#6B7280', '#10B981', '#FFFFFF', 'left', '{\"image_position\":\"left\",\"image_shape\":\"rounded\",\"card_hover_effect\":\"lift\",\"animation_style\":\"fade\",\"animation_speed\":\"normal\"}');

-- Data for table `categories`
INSERT IGNORE INTO `categories` (`id`, `restaurant_id`, `name`, `description`, `image_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', '1', 'حلو', NULL, NULL, '0', '1', '2026-05-28 14:00:07', '2026-05-28 14:00:07');

-- Data for table `items`
INSERT IGNORE INTO `items` (`id`, `restaurant_id`, `category_id`, `name`, `description`, `price`, `image_url`, `tags`, `is_available`, `sort_order`, `created_at`, `updated_at`) VALUES ('2', '1', '2', 'تشيز كيك', 'هيبرتهخ', '75', NULL, '[\"\\u0634\\u0643\\u064a\\u0647\\u0627\\u0628\\u0634\\u0647\\u062e\"]', '1', '0', '2026-05-28 14:00:30', '2026-06-11 14:33:04');

-- Data for table `qr_styles`
INSERT IGNORE INTO `qr_styles` (`id`, `restaurant_id`, `dot_style`, `corner_square_style`, `corner_dot_style`, `dot_color`, `background_color`, `gradient_enabled`, `gradient_color_1`, `gradient_color_2`, `gradient_type`, `logo_url`, `frame_style`, `top_text`, `bottom_text`, `created_at`, `updated_at`) VALUES ('1', '1', 'rounded', 'square', 'square', '#ffffff', '#55171c', '0', '#000000', '#000000', 'linear', NULL, NULL, NULL, NULL, '2026-05-27 18:48:28', '2026-05-27 19:23:36');

-- Data for table `pdf_menus`
INSERT IGNORE INTO `pdf_menus` (`id`, `restaurant_id`, `pdf_url`, `original_name`, `created_at`, `updated_at`) VALUES ('5', '1', 'http://127.0.0.1:8000/storage/qrmenu/300/pdfs/6a179d50f2e70.tmp', 'QR_compressed.pdf', '2026-05-28 01:41:37', '2026-05-28 01:41:37');

