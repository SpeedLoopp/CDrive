-- CDrive Veritabanı Kurulum Scripti
-- InfinityFree veya herhangi bir MySQL sunucusu için

-- Veritabanını oluştur (eğer yerel sunucuda çalışıyorsanız)
-- CREATE DATABASE IF NOT EXISTS cdrive CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE cdrive;

-- InfinityFree için veritabanı zaten var, sadece tabloları oluşturun
-- USE if0_37354591_db_notest;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Tablo yapısı: migrations
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tablo yapısı: personal_access_tokens
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
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

-- --------------------------------------------------------
-- Tablo yapısı: users
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tablo yapısı: files
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `files` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `download_count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `files_user_id_foreign` (`user_id`),
  CONSTRAINT `files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tablo yapısı: links
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `links` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `custom_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` timestamp NULL DEFAULT NULL,
  `access_count` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `links_custom_link_unique` (`custom_link`),
  KEY `links_file_id_foreign` (`file_id`),
  CONSTRAINT `links_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tablo yapısı: ads
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `ads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('header','footer','popup','sidebar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Başlangıç verileri: users
-- --------------------------------------------------------

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@cdrive.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, NULL, NOW(), NOW()),
(2, 'Test User', 'user@cdrive.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 1, NULL, NOW(), NOW());

-- Şifre: admin123 ve user123 (bcrypt hash)

-- --------------------------------------------------------
-- Başlangıç verileri: ads
-- --------------------------------------------------------

INSERT INTO `ads` (`id`, `type`, `content`, `title`, `active`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'header', '<div style="padding: 20px; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;"><h3 style="margin: 0 0 10px 0;">🎉 Hoş Geldiniz!</h3><p style="margin: 0;">CDrive ile dosyalarınızı güvenle saklayın ve paylaşın</p></div>', 'Üst Banner Reklam', 1, 1, NOW(), NOW()),
(2, 'footer', '<div style="padding: 15px; text-align: center; background: rgba(79, 172, 254, 0.1); border-radius: 8px;"><p style="margin: 0; font-size: 14px;">💡 Premium üyelik ile sınırsız depolama alanı kazanın!</p></div>', 'Alt Banner Reklam', 1, 1, NOW(), NOW()),
(3, 'popup', '<div style="text-align: center;"><h2 style="color: #4facfe; margin-bottom: 15px;">🎁 Özel Teklif!</h2><p style="font-size: 16px; margin-bottom: 20px;">İlk 100 kullanıcıya özel %50 indirim!</p><a href="#" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 5px;">Hemen Başla</a></div>', 'Popup Reklam', 1, 1, NOW(), NOW());

-- --------------------------------------------------------
-- Migration kayıtları
-- --------------------------------------------------------

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_01_000000_create_users_table', 1),
(3, '2024_01_01_000001_create_files_table', 1),
(4, '2024_01_01_000002_create_links_table', 1),
(5, '2024_01_01_000003_create_ads_table', 1);

COMMIT;

-- --------------------------------------------------------
-- NOT: Şifre değiştirmek için
-- --------------------------------------------------------
-- UPDATE users SET password = '$2y$10$YourNewHashHere' WHERE email = 'admin@cdrive.com';
-- 
-- Yeni hash oluşturmak için Laravel'de:
-- php artisan tinker
-- bcrypt('yeni_sifre')
-- --------------------------------------------------------
