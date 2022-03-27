-- Adminer 4.7.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
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


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2022_03_23_060125_create_plans_table',	2),
(6,	'2016_06_01_000001_create_oauth_auth_codes_table',	3),
(7,	'2016_06_01_000002_create_oauth_access_tokens_table',	3),
(8,	'2016_06_01_000003_create_oauth_refresh_tokens_table',	3),
(9,	'2016_06_01_000004_create_oauth_clients_table',	3),
(10,	'2016_06_01_000005_create_oauth_personal_access_clients_table',	3),
(11,	'2022_03_25_083145_add_column_start_date_and_end_date_at_plans_table',	4);

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1,	'App\\Models\\User',	1,	'API Token',	'c4e03dbf85347d18993921094f840a1e26b98f06758dc9026639fc574db1f5c3',	'[\"*\"]',	NULL,	'2022-03-23 00:28:05',	'2022-03-23 00:28:05'),
(2,	'App\\Models\\User',	1,	'API Token',	'd0492887c316103447bb1e95ed282dd3242fcf004e7126b19bfef7d63185ea6b',	'[\"*\"]',	NULL,	'2022-03-23 00:28:45',	'2022-03-23 00:28:45'),
(3,	'App\\Models\\User',	1,	'API Token',	'6168ce49b9ae654fddd6823218ebfc76f30178017af8c5ce3bd7273d0db9525a',	'[\"*\"]',	NULL,	'2022-03-23 00:30:14',	'2022-03-23 00:30:14'),
(4,	'App\\Models\\User',	1,	'API Token',	'e97ff9d6403ed0fdd3d7665b818b3e08779ce776f3eec8dd7076fb71657cf594',	'[\"*\"]',	NULL,	'2022-03-23 00:37:53',	'2022-03-23 00:37:53'),
(5,	'App\\Models\\User',	1,	'API Token',	'37fecb94aed21efc2ac311df481e98ad3b362c4fea89d8dd29896bfdc7feb44d',	'[\"*\"]',	NULL,	'2022-03-23 00:46:11',	'2022-03-23 00:46:11'),
(6,	'App\\Models\\User',	1,	'API Token',	'89a141c38b6c12e039cdc3a9d422b8a5e25cce3289ea22681088ebd9fea74892',	'[\"*\"]',	NULL,	'2022-03-23 00:46:19',	'2022-03-23 00:46:19'),
(7,	'App\\Models\\User',	2,	'API Token',	'97744a110204bf43b0ea7a0fcee29aa9b0399e55e639ddbec7f202d8c13cb7d8',	'[\"*\"]',	NULL,	'2022-03-23 00:52:01',	'2022-03-23 00:52:01'),
(8,	'App\\Models\\User',	2,	'API Token',	'0eaaf5a169af1fb6c09debb168c5c5b8d5a5cf169ca332f42e8191e6f37b2b43',	'[\"*\"]',	NULL,	'2022-03-23 01:05:25',	'2022-03-23 01:05:25'),
(9,	'App\\Models\\User',	2,	'API Token',	'940344451e2ae4dd35c064a99fc2c464ddb52fa599baee6b2a176534b93ce041',	'[\"*\"]',	NULL,	'2022-03-24 03:27:20',	'2022-03-24 03:27:20'),
(10,	'App\\Models\\User',	2,	'API Token',	'b032b88e6d90d04461220dffcd9c39d5a949692cf18c4c2a743ea6cc65b771f8',	'[\"*\"]',	NULL,	'2022-03-24 03:28:17',	'2022-03-24 03:28:17'),
(11,	'App\\Models\\User',	2,	'API Token',	'eb12dbc1b90c1ccd5f279f9906ce1c1e060e661c76e413d689b4723ef20bbc96',	'[\"*\"]',	NULL,	'2022-03-25 01:03:19',	'2022-03-25 01:03:19');

DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('one-day','time-range') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'one-day',
  `start_date` date NOT NULL DEFAULT '2022-03-25',
  `end_date` date NOT NULL DEFAULT '2022-03-25',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `plans` (`id`, `user_id`, `title`, `origin`, `destination`, `type`, `start_date`, `end_date`, `description`, `created_at`, `updated_at`) VALUES
(2,	2,	'Plan 2',	'Medan',	'Makassar',	'time-range',	'2022-03-29',	'2022-03-31',	'medan ke makasar',	'2022-03-24 17:00:00',	'2022-03-24 17:00:00'),
(3,	1,	'Plan 3',	'Solo',	'Surabaya',	'one-day',	'2022-03-26',	'2022-03-27',	'this is plan 3',	'2022-03-24 17:00:00',	'2022-03-25 05:24:49');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'user1',	'user1@gmail.com',	NULL,	'$2y$10$6j5z8wUtxoCSXUjP7XDGFeNzqF1PiVR7GO8WTAurXKgdmdoEoSVRC',	NULL,	NULL,	NULL),
(2,	'user2',	'user2@gmail.com',	NULL,	'$2y$10$AKjBB6VqqjvBPX7QTaF7EOyXJamnoXiHnv.8P1gteKAhxkog7utxa',	NULL,	'2022-03-23 00:51:48',	'2022-03-23 00:51:48'),
(3,	'user3',	'user3@gmail.com',	NULL,	'$2y$10$XYUubrCrhGK5UdAOK9HsouFVkC/msS//qZ1Sf0FAifXLsiSqpT4Jq',	NULL,	'2022-03-25 10:03:00',	'2022-03-25 10:03:00'),
(6,	'user4',	'user4@gmail.com',	NULL,	'$2y$04$.ey3NOVu1e5NVyYiHPCfA.fVdC.1l0B/K4rwayB7nk3JFgn/xuRhu',	NULL,	'2022-03-25 10:07:33',	'2022-03-25 10:07:33');

-- 2022-03-26 23:09:16
