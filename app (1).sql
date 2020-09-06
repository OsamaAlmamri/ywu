-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: 05 سبتمبر 2020 الساعة 18:21
-- إصدار الخادم: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Adnan Almaqwali', 'adnan@gmail.com', 'IMG-20200904231127.jpg', NULL, '$2y$10$ZFMPZoIG.14i9iFtpVZn/uXM7rT11jMf2jt7uWU238qhtAVj3cAdO', NULL, '2020-09-04 20:01:11', '2020-09-04 20:11:27');

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'استشارة اسرية', '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(2, 'استشارة نفسية', '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(3, 'استشارة قانونية', '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(4, 'شكاوى', '2020-09-04 20:01:11', '2020-09-04 20:01:11');

-- --------------------------------------------------------

--
-- بنية الجدول `category__trainings`
--

DROP TABLE IF EXISTS `category__trainings`;
CREATE TABLE IF NOT EXISTS `category__trainings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `training_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category__trainings_category_id_foreign` (`category_id`),
  KEY `category__trainings_training_id_foreign` (`training_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `category__trainings`
--

INSERT INTO `category__trainings` (`id`, `category_id`, `training_id`, `created_at`, `updated_at`) VALUES
(1, 2, 10, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 1, 1, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 2, 10, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 3, 12, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 2, 9, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 2, 1, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 1, 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 1, 5, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 2, 12, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 2, 9, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 3, 2, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 2, 11, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 1, 14, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 2, 8, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(15, 4, 3, '2020-09-04 20:39:27', '2020-09-04 20:39:27'),
(16, 4, 4, '2020-09-04 20:42:15', '2020-09-04 20:42:15'),
(18, 5, 1, '2020-09-04 21:18:19', '2020-09-04 21:18:19'),
(19, 5, 2, '2020-09-04 21:18:19', '2020-09-04 21:18:19'),
(20, 5, 3, '2020-09-04 21:18:19', '2020-09-04 21:18:19'),
(21, 5, 4, '2020-09-04 21:18:19', '2020-09-04 21:18:19'),
(25, 1, 15, '2020-09-04 21:24:46', '2020-09-04 21:24:46'),
(23, 5, 13, '2020-09-04 21:20:35', '2020-09-04 21:20:35'),
(24, 5, 14, '2020-09-04 21:20:35', '2020-09-04 21:20:35'),
(26, 3, 15, '2020-09-04 21:25:01', '2020-09-04 21:25:01'),
(27, 2, 15, '2020-09-04 21:25:16', '2020-09-04 21:25:16'),
(28, 3, 13, '2020-09-04 21:32:17', '2020-09-04 21:32:17'),
(29, 3, 14, '2020-09-04 21:32:17', '2020-09-04 21:32:17'),
(30, 3, 15, '2020-09-04 21:32:17', '2020-09-04 21:32:17'),
(31, 3, 3, '2020-09-04 21:32:55', '2020-09-04 21:32:55');

-- --------------------------------------------------------

--
-- بنية الجدول `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` int(10) UNSIGNED DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_foreign` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'مفعل',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `category_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'محمد علي المصقري', 'Mo@gmail.com', '$2y$10$K86ycO.Kzu1O1u/yjIhGG.u34om.2LhMw0fFMtUcDIfLAaymGH1/K', 2, 'مفعل', NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(2, 'صالح المرفلي', 'saleh@gmail.com', '$2y$10$EEEh1CI44v418AplCnxlSu5SzwbvFP8QZrjiEBORzKg3EpJNot5Vu', 3, 'مفعل', NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(3, ' محمد المحصلاني', 'mohammed@gmail.com', '$2y$10$zCe3vlqj289eSsD6c9weQuxxkWd6DFB08T0X0lqH9lZ1Kz.Hde7nC', 1, 'مفعل', NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11');

-- --------------------------------------------------------

--
-- بنية الجدول `employee_categories`
--

DROP TABLE IF EXISTS `employee_categories`;
CREATE TABLE IF NOT EXISTS `employee_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employee_categories`
--

INSERT INTO `employee_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'استشاري', '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(2, 'مدرب', '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(3, 'اخصائي', '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(4, 'سمكري', '2020-09-04 20:12:47', '2020-09-04 20:12:47'),
(5, 'مهندس', '2020-09-04 20:27:29', '2020-09-04 20:27:29');

-- --------------------------------------------------------

--
-- بنية الجدول `exams`
--

DROP TABLE IF EXISTS `exams`;
CREATE TABLE IF NOT EXISTS `exams` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `training_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exams_training_id_foreign` (`training_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `exams`
--

INSERT INTO `exams` (`id`, `name`, `training_id`, `created_at`, `updated_at`) VALUES
(1, 'Rerum fugiat itaque.', 12, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'Tempora aut consequatur.', 8, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'Ut quod.', 11, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'Quia magnam ut.', 14, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'Natus quod.', 4, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 'Quibusdam qui odit.', 5, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 'Et corrupti.', 9, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 'Consequatur dolores quia.', 2, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 'Quis necessitatibus.', 5, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 'Dolores numquam expedita.', 1, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 'Et sunt rerum.', 9, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 'Quidem explicabo dolores.', 5, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 'Dolores assumenda.', 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 'Sint eius.', 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(15, 'Voluptates rerum quia.', 9, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(16, 'Consectetur provident eum.', 10, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(17, 'Adipisci aut similique.', 4, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(18, 'Non sint.', 12, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(19, 'Quis nesciunt.', 5, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(20, 'Dolores nostrum a.', 13, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(21, 'Libero omnis.', 6, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(22, 'Cupiditate debitis.', 6, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(23, 'Quia quia.', 13, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(24, 'Aut harum.', 12, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(25, 'Repellat soluta.', 3, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(26, 'Aliquam voluptatem.', 13, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(27, 'Dicta cupiditate.', 11, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(28, 'Recusandae qui et.', 1, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(29, 'Dolor ad.', 9, '2020-09-04 20:01:12', '2020-09-04 20:01:12');

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=680 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(660, '2014_10_12_000000_create_users_table', 1),
(661, '2014_10_12_100000_create_password_resets_table', 1),
(662, '2019_08_19_000000_create_failed_jobs_table', 1),
(663, '2020_07_28_191525_create_categories_table', 1),
(664, '2020_07_28_192317_create_posts_table', 1),
(665, '2020_07_28_192339_create_comments_table', 1),
(666, '2020_07_31_203200_create_employees_table', 1),
(667, '2020_08_03_203941_create_women_categories_table', 1),
(668, '2020_08_03_204228_create_women_posts_table', 1),
(669, '2020_08_17_204621_create_subjects_table', 1),
(670, '2020_08_17_204921_create_subject_categories_table', 1),
(671, '2020_08_17_210126_create_trainings_table', 1),
(672, '2020_08_17_210340_create_training_titles_table', 1),
(673, '2020_08_17_210432_create_title_contents_table', 1),
(674, '2020_08_29_142246_create_exams_table', 1),
(675, '2020_08_29_144938_create_questions_table', 1),
(676, '2020_08_29_222758_create_admins_table', 1),
(677, '2020_09_02_205641_create_employee_categories_table', 1),
(678, '2020_09_03_141446_create_share_users_table', 1),
(679, '2020_09_04_203842_create_category__trainings_table', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `password_resets`
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
-- بنية الجدول `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `favorite` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `user_id`, `category_id`, `status`, `favorite`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Est in quia est et.', 'Rerum alias repellendus harum sed voluptates molestias voluptas. Sed qui non sapiente sit minus. Ullam voluptates necessitatibus facere non velit pariatur et.', 3, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(2, 'Sint deserunt facilis quod.', 'Veritatis cumque sint non ex debitis velit officia. Ipsa temporibus facilis ullam cumque distinctio. Aut blanditiis corporis natus iste quia.', 3, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(3, 'Voluptas placeat veniam fugiat.', 'Et inventore rem distinctio reiciendis quo molestias hic. Aut consequuntur qui illum est. Voluptate at dolorem fuga voluptatem consequatur delectus deleniti.', 1, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(4, 'Dolor illum eos minima.', 'Dicta illo dolor id a qui expedita. Et qui consectetur quae asperiores. Dolore ut inventore tenetur ipsam sit fugiat quod.', 1, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(5, 'Non voluptatem rerum nemo iure.', 'Deleniti atque sint eligendi mollitia iure beatae ut. Quibusdam dolore voluptas illum ducimus laudantium doloribus. Sit fuga quis voluptate dolorum. Et quis odio repellendus voluptatem esse id natus.', 2, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(6, 'Et adipisci sit illo et corporis.', 'Odio iusto ullam voluptatum omnis enim aut cupiditate. Cumque autem impedit id nobis sit necessitatibus delectus voluptatem. Sint omnis a ex et.', 1, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(7, 'Quibusdam vitae labore optio ut.', 'Incidunt optio iste sapiente dolorem. Veniam nobis et ducimus ea facere quis dolore aut. Occaecati suscipit quos dolorum unde earum nostrum voluptates consequatur.', 1, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(8, 'Corrupti quia autem qui consequatur.', 'Voluptatem facere deleniti modi eius. Voluptatem qui incidunt ut ratione. Rerum eius aliquid odio nesciunt nostrum quisquam.', 1, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(9, 'Voluptates suscipit consequatur totam.', 'Et illum qui sit. Labore velit odio et dolor natus vel quas. Explicabo numquam doloribus explicabo numquam voluptatum perspiciatis ut.', 1, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(10, 'Voluptas quaerat nihil doloremque.', 'Sapiente unde in asperiores magni aut. Earum eos non a dolores voluptas. Eaque illum accusantium delectus magnam consequuntur.', 3, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(11, 'Qui laudantium ipsam laborum aut rerum.', 'Itaque ab est ex iusto quia praesentium dolore. Dolore eius tenetur sint earum laudantium sit est. Eum aut placeat repellendus nam qui vel.', 3, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(12, 'In hic voluptatem ducimus.', 'Perferendis qui dolor et enim modi et molestiae. Impedit impedit facere est reiciendis dolor. Vel deserunt veniam sit cumque. Eos voluptas nihil debitis et distinctio cum error. Dolorem dicta hic et repudiandae et molestias laborum.', 2, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(13, 'Nam voluptatem est nesciunt.', 'Atque eaque eius unde sequi impedit. Dolores voluptatem dolore itaque aut. Corporis consequuntur ipsa est. Consequuntur architecto omnis soluta vel laboriosam omnis cumque.', 2, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(14, 'Sed eveniet eum illum.', 'Unde non iure earum voluptate a. Suscipit dicta recusandae et qui tempora praesentium. Quis alias minus occaecati necessitatibus laboriosam. Voluptas et maxime tenetur.', 3, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(15, 'Omnis at dolore ad.', 'Sint exercitationem suscipit et. Pariatur rerum velit modi quia pariatur. Non ab et in illum. Molestias voluptatem velit delectus deleniti sed enim et. Quia quo ad perspiciatis blanditiis nostrum porro consequatur.', 1, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(16, 'Qui et est.', 'Illum quis ex corporis provident. Labore ipsam quisquam accusamus molestiae excepturi aspernatur necessitatibus beatae. Labore rerum sapiente cumque excepturi assumenda qui velit. Maiores nihil nostrum ex atque sed incidunt.', 3, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(17, 'Ut voluptate eveniet provident non.', 'Est rem molestias consequatur est dolorem. Adipisci earum quia labore ea minus explicabo eius. Rerum mollitia quo consequatur perspiciatis perspiciatis soluta id repellendus. Nihil autem reiciendis eum est sed expedita ullam.', 1, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(18, 'Doloremque soluta sit.', 'Error voluptate eaque sequi harum a repudiandae expedita. Maiores voluptatem nihil ut doloribus iure illum. Cupiditate ut explicabo dolores qui reprehenderit et suscipit. Tempore a voluptas modi voluptas quia nisi.', 1, 4, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(19, 'Qui sunt minus aut.', 'Qui dolor reprehenderit dolores aut et. Corrupti magni nostrum tempora ratione eos. Ratione magnam ea nostrum fugiat asperiores.', 3, 3, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(20, 'Quisquam neque sit.', 'Molestiae repellendus aut cumque mollitia omnis quisquam et. Itaque dolorum consequatur alias consequatur voluptas quibusdam. Adipisci non et suscipit possimus exercitationem sit.', 2, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(21, 'Deserunt adipisci qui unde non voluptas.', 'Est nesciunt explicabo laborum. Et explicabo aut omnis laudantium maxime voluptatem quia. Optio aut sint ipsa debitis reiciendis rerum perferendis.', 1, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(22, 'Nam rerum et.', 'Fugiat accusantium et optio est fuga. Iure voluptas sunt et aut est architecto ut. Omnis suscipit debitis tempora dolores eveniet consequatur. Vitae magni atque id soluta delectus repellat.', 2, 4, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(23, 'At et nihil hic a.', 'Officia ipsam deleniti consequatur non sunt. Ut reiciendis error expedita qui. Voluptates nemo vero aut itaque.', 1, 4, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(24, 'Praesentium dolor tempore.', 'Dolorem fugiat laudantium totam quis eum. Vel ea quisquam sed consequatur pariatur perferendis. Maiores hic placeat molestias dolore ut rerum dolor ut.', 3, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(25, 'Iusto et qui.', 'Est amet dolor temporibus voluptatem nobis saepe. Ratione minima vero officiis at nihil distinctio in. Dolore alias iste necessitatibus voluptatem quas. Velit corrupti magni cumque ipsa ex.', 3, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(26, 'Accusantium laboriosam et accusantium voluptatem.', 'Dolorem ea ut veniam perspiciatis voluptate omnis. Quaerat sint asperiores earum sint delectus. Quasi ipsa delectus praesentium repellendus velit quaerat. Vitae aut possimus quisquam aut dolorem suscipit nam.', 2, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(27, 'Iusto neque sed illum quibusdam.', 'Ratione asperiores ea consectetur est fugit. Ut nostrum nemo quia architecto laboriosam quis. Aut illum provident aut possimus error. Hic sint exercitationem autem aut totam et. Perspiciatis enim dolore iure natus nulla qui.', 2, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(28, 'Quaerat ea omnis praesentium nam.', 'Quidem maxime quod quia dolores nesciunt soluta nam. Dolorem dignissimos at distinctio nam. Vel est quasi non quia qui est. Nihil placeat accusamus repudiandae qui ut.', 2, 2, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(29, 'Dignissimos consequatur a.', 'Est molestiae deserunt ut adipisci minus eos vel. Neque facere est magnam. Officiis voluptatem officia maxime cumque magni in beatae.', 1, 1, 0, 0, NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11');

-- --------------------------------------------------------

--
-- بنية الجدول `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option4` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_exam_id_foreign` (`exam_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `questions`
--

INSERT INTO `questions` (`id`, `text`, `image`, `option1`, `option2`, `option3`, `option4`, `answer`, `exam_id`, `created_at`, `updated_at`) VALUES
(1, 'Voluptatum est vitae nisi non ullam et et aut quo id voluptas praesentium incidunt.', '01.JPG', 'Ipsam in.', 'Nam vel.', 'At fuga doloribus.', 'Voluptas ut.', 'Pariatur autem.', 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'Laboriosam aut quis aut eum delectus rerum quasi saepe libero est mollitia.', '02.JPG', 'Corporis aut.', 'Quidem soluta voluptatem.', 'Architecto inventore ullam.', 'Repellat consectetur.', 'Quis quae repellat.', 27, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'Dolorem illum quod fuga magni maiores sunt libero voluptatem molestiae.', '03.JPG', 'Velit quaerat voluptas.', 'Et a.', 'Aliquid sit.', 'Sed quia.', 'Aut non.', 28, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'Corporis deleniti deleniti quae est rerum porro placeat quaerat.', '04.JPG', 'Non ut.', 'Eaque corrupti consequatur.', 'Facere officia quae.', 'Aliquid temporibus dignissimos.', 'Aut iusto provident.', 2, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'Consequatur blanditiis ratione voluptatem aut eaque est nemo cumque dolor.', '05.JPG', 'Ex nostrum aut.', 'Enim tempora libero.', 'Inventore cum qui.', 'Fugiat rem.', 'Aperiam eos molestiae.', 23, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 'Vitae repellat soluta quis quo dolorem doloribus qui repellat doloribus labore eaque provident perspiciatis.', '06.JPG', 'Ea quia perferendis.', 'Deleniti deleniti.', 'Voluptatum repellat praesentium.', 'Et ex enim.', 'Soluta molestiae adipisci.', 23, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 'Alias harum vitae ea delectus quia nihil aut ea beatae nisi tempora rerum non.', '07.JPG', 'Unde ea.', 'Nihil autem.', 'Ratione voluptatem adipisci.', 'Sunt quis.', 'Iste minus.', 23, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 'Rem commodi vero mollitia nobis quas nostrum quidem dolores esse quos veritatis assumenda.', '08.JPG', 'Optio iure.', 'Officia quo eum.', 'Nihil architecto rerum.', 'Voluptas temporibus.', 'Beatae ut.', 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 'Dignissimos facilis animi ut maiores minus tempore ex facilis ex officia corporis sed ullam.', '09.JPG', 'Odio quis vero.', 'Ducimus at quisquam.', 'Perspiciatis id qui.', 'Enim modi.', 'Deserunt quia incidunt.', 25, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 'Et ipsa aut est perferendis quisquam voluptatum facilis velit molestiae.', '10.JPG', 'Ducimus nulla nemo.', 'Veritatis incidunt dolorum.', 'Sed dolorem eius.', 'Dolor velit non.', 'Dolor eos accusamus.', 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 'Optio tenetur eum dicta totam velit sunt dolore.', '11.JPG', 'Et pariatur.', 'Est quaerat et.', 'Harum rerum dolor.', 'Doloribus dolorum adipisci.', 'Aliquid voluptas.', 6, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 'Omnis odio odio modi facere voluptatem voluptatem placeat corrupti aut enim officia.', '12.JPG', 'Fuga nostrum.', 'Et deserunt.', 'Laboriosam temporibus ea.', 'Ex nihil quas.', 'Aut sed.', 8, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 'Quo autem nemo ipsa et aut sit molestiae rerum laudantium.', '13.JPG', 'Tempore aut.', 'Repudiandae totam ad.', 'Aut voluptatem sunt.', 'Nobis autem libero.', 'Cumque eius.', 6, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 'Dolorem ab voluptas ad consequatur error ratione est odit.', '14.JPG', 'Quis enim quia.', 'Et quo nobis.', 'Voluptates harum maxime.', 'Laborum aspernatur perspiciatis.', 'Aperiam dolor.', 26, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(15, 'Reprehenderit nam omnis provident ab molestias quibusdam dolor dolore alias dicta ad voluptas quisquam.', '15.JPG', 'Minima voluptatem.', 'Soluta et.', 'Non in quam.', 'Nulla vel quis.', 'Ipsum non quo.', 26, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(16, 'Dicta similique et nisi harum velit minus optio assumenda id excepturi quisquam nulla voluptas.', '16.JPG', 'Sint debitis mollitia.', 'Eum quis explicabo.', 'Doloremque omnis minus.', 'Perspiciatis et.', 'Deserunt temporibus.', 28, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(17, 'Libero saepe voluptas quo est eligendi quia provident amet.', '17.JPG', 'Ut non.', 'Nihil ut sunt.', 'Voluptas eos.', 'Voluptatum earum maiores.', 'Voluptatem fugit debitis.', 17, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(18, 'In accusantium quae nihil hic veritatis omnis.', '18.JPG', 'Consequuntur aliquid.', 'Voluptas similique excepturi.', 'Beatae rerum eum.', 'Numquam blanditiis sed.', 'Nihil cupiditate perferendis.', 23, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(19, 'In consequuntur accusamus dolor et optio accusamus.', '19.JPG', 'Illum fugit.', 'Eum aut.', 'Magnam est.', 'Ut voluptatibus.', 'Accusantium ex minima.', 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(20, 'Consequuntur maxime sunt dicta et officiis dolores.', '20.JPG', 'Consequatur fuga.', 'Porro dolorum.', 'Illum et.', 'Nemo odit.', 'Qui eveniet.', 20, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(21, 'Quaerat dolorem mollitia et aut voluptate similique modi.', '21.JPG', 'Velit est.', 'Nisi commodi.', 'Aut nesciunt tenetur.', 'Amet dicta.', 'Voluptatem voluptate saepe.', 6, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(22, 'Sit iste maxime sed nihil odit ut autem sit.', '22.JPG', 'Ratione odio.', 'Vel et.', 'Nam quia vitae.', 'Tenetur ratione perspiciatis.', 'Dolore id.', 27, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(23, 'Aut sed autem reprehenderit nesciunt dolorum quo repellat quis velit sunt harum dolorem perspiciatis.', '23.JPG', 'Aut et ea.', 'Et adipisci sapiente.', 'In ea beatae.', 'Deleniti ut aut.', 'Quod dicta distinctio.', 9, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(24, 'Odio commodi eos optio consequatur rerum dolor vitae consectetur eum expedita cumque.', '24.JPG', 'Dolor repellat.', 'Et fugit.', 'Quia quia.', 'Possimus omnis.', 'Doloremque nemo rem.', 15, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(25, 'Occaecati inventore ad officia quia dolor numquam quis non nostrum incidunt labore quibusdam perspiciatis.', '25.JPG', 'Numquam aspernatur et.', 'Cum voluptas.', 'Est quae.', 'Deleniti earum.', 'Exercitationem modi similique.', 13, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(26, 'Est et exercitationem et iusto dolorem aut et nesciunt rerum sit et.', '26.JPG', 'Dolorum ex natus.', 'Ab velit.', 'Iste consectetur.', 'Nulla sed.', 'Et earum.', 28, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(27, 'Ipsa occaecati sed ducimus expedita magni beatae similique quia ut.', '27.JPG', 'Nihil et.', 'Eos in.', 'Iusto iure ipsa.', 'Nobis ut aut.', 'Ea eius minus.', 6, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(28, 'Voluptatem ut rerum delectus temporibus facere voluptatem quia vel quo earum excepturi atque.', '28.JPG', 'Sunt voluptatibus.', 'Ut corrupti consequuntur.', 'Ratione qui.', 'Nisi accusamus.', 'Labore dolorum facilis.', 13, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(29, 'Sint est provident sunt sed eos rem accusamus tenetur reprehenderit est.', '29.JPG', 'Ut et.', 'Fugiat sit praesentium.', 'Tenetur est maxime.', 'Et quia iusto.', 'Hic exercitationem.', 7, '2020-09-04 20:01:12', '2020-09-04 20:01:12');

-- --------------------------------------------------------

--
-- بنية الجدول `share_users`
--

DROP TABLE IF EXISTS `share_users`;
CREATE TABLE IF NOT EXISTS `share_users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'غير مفعل',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `share_users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `share_users`
--

INSERT INTO `share_users` (`id`, `name`, `email`, `password`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'علي مصلح', 'Mo@gmail.com', '$2y$10$BHt2bgDMkhb9.TAAJ7NkZupCgmU8cyaYBRbH4cNi8HDzJjs0RpNMu', 'شريك', 'غير مفعل', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'محمد العزي', 'saleh@gmail.com', '$2y$10$qlwBaIVdmTDdo9WKBtQ5pOowgThXiz9bHG3D4di6/TCtIGsIshq66', 'عضو كتلة', 'غير مفعل', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, ' احمد الهمداني', 'mohammed@gmail.com', '$2y$10$ptepOEqcZnSRRYIIcnul4.K7/fMdBbn4igGB3QLtfTdxg8pwSqcHu', 'شريك', 'مفعل', NULL, '2020-09-04 20:01:12', '2020-09-04 22:09:58');

-- --------------------------------------------------------

--
-- بنية الجدول `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjects_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Repellendus pariatur.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'Qui sit.', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'Qui magnam.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'Facilis est itaque.', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'Nam deleniti.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 'Eligendi ut dolor.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 'Quaerat molestiae qui.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 'Nostrum sed aliquid.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 'Dolores quia.', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 'Itaque et.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 'A accusamus.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 'Velit placeat.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 'Illum numquam.', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 'Eos explicabo.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(15, 'Perferendis adipisci.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(16, 'Ad ea.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(17, 'Non non.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(18, 'Omnis dolor unde.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(19, 'Maxime qui nemo.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(20, 'Optio velit.', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(21, 'Labore unde.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(22, 'Libero tenetur.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(23, 'Tenetur magni impedit.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(24, 'Molestiae vero veritatis.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(25, 'Labore et alias.', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(26, 'Aut iste.', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(27, 'Ea numquam.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(28, 'Qui ut.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(29, 'Cum ad.', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(30, 'Molestiae amet.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(31, 'Quo voluptas.', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(32, 'Aliquam quis.', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(33, 'Corporis blanditiis facere.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(34, 'Aut labore.', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(35, 'Sint perspiciatis mollitia.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(36, 'Sint temporibus pariatur.', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(37, 'Aut repellat.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(38, 'Suscipit id eligendi.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(39, 'Ad delectus commodi.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(40, 'Soluta et.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(41, 'Omnis totam temporibus.', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(42, 'Fugiat sequi.', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(43, 'Sed at.', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(44, 'Est debitis est.', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(45, 'دعم مادي', 2, NULL, '2020-09-04 21:23:23', '2020-09-04 21:23:23');

-- --------------------------------------------------------

--
-- بنية الجدول `subject_categories`
--

DROP TABLE IF EXISTS `subject_categories`;
CREATE TABLE IF NOT EXISTS `subject_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `subject_categories`
--

INSERT INTO `subject_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'التغطية الاعلامية', '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'الدعم النفسي', '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'إدارة الحالة', '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'الدعم القانوني', '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'IT', '2020-09-04 20:01:12', '2020-09-04 20:01:12');

-- --------------------------------------------------------

--
-- بنية الجدول `title_contents`
--

DROP TABLE IF EXISTS `title_contents`;
CREATE TABLE IF NOT EXISTS `title_contents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sound` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title_contents_title_id_foreign` (`title_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `title_contents`
--

INSERT INTO `title_contents` (`id`, `title`, `body`, `image`, `book`, `sound`, `video_url`, `title_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Nemo dolor quod voluptates.', 'Expedita tenetur qui consequatur porro veritatis dolorum corrupti. Incidunt fugiat aut et aut cumque qui. Voluptatem et totam cum libero.', '01.JPG', 'book1.pdf', 'sound1.mp3', 'http//video_url1.com', 27, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'Officiis quaerat aut quasi.', 'Ut eaque et pariatur aut. Et quia est fugiat et sit sit cupiditate. Itaque dicta necessitatibus ut sunt sed eos inventore. Tenetur ipsum aut consequatur distinctio et.', '02.JPG', 'book2.pdf', 'sound2.mp3', 'http//video_url2.com', 22, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'Aut non dolor.', 'Cupiditate inventore aut enim inventore quo sit maxime. Qui quos saepe et ratione dolore veniam molestiae. Necessitatibus optio aperiam nihil modi consequatur totam.', '03.JPG', 'book3.pdf', 'sound3.mp3', 'http//video_url3.com', 27, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'Aliquam ipsam neque.', 'Laborum suscipit ipsum exercitationem. Facilis iure at corporis nemo dolorem voluptatem officiis. Tempore deleniti assumenda nobis corrupti.', '04.JPG', 'book4.pdf', 'sound4.mp3', 'http//video_url4.com', 19, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'Sit iusto sed aliquid.', 'Voluptatibus dicta voluptates vero est saepe non voluptas qui. Quo quod rerum tenetur.', '05.JPG', 'book5.pdf', 'sound5.mp3', 'http//video_url5.com', 8, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 'Repellendus vel quis consequuntur.', 'Pariatur libero vel vero incidunt voluptates officia nihil. Aperiam qui voluptatum aliquam cupiditate nisi voluptatem minus omnis. Optio similique aut dolorem officiis sit nostrum. Qui exercitationem nisi ut eius sequi soluta quo.', '06.JPG', 'book6.pdf', 'sound6.mp3', 'http//video_url6.com', 20, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 'Rerum quae ipsum dolorem officiis.', 'Veritatis consequatur sit itaque atque. Sint porro totam necessitatibus. Et ad non ad rerum nihil. Deserunt suscipit et sequi enim cumque fugit.', '07.JPG', 'book7.pdf', 'sound7.mp3', 'http//video_url7.com', 25, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 'Similique et deserunt.', 'Dicta tempore aperiam accusantium ut nesciunt nam aliquam. Nulla quae repellendus aspernatur. Consequatur impedit dolorem voluptas ea et iste.', '08.JPG', 'book8.pdf', 'sound8.mp3', 'http//video_url8.com', 25, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 'Delectus provident id.', 'Voluptas reiciendis nostrum aut. Voluptates dolorem quisquam nesciunt. Non nam aut quia sed occaecati. Aut quidem qui est qui.', '09.JPG', 'book9.pdf', 'sound9.mp3', 'http//video_url9.com', 10, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 'Iusto laborum nobis est.', 'Laboriosam ea dolorum culpa sed sit. Dolorem cupiditate voluptates in nemo maxime. Sit dolor eaque dolores hic. Nulla qui vero rem est ut.', '10.JPG', 'book10.pdf', 'sound10.mp3', 'http//video_url10.com', 15, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 'Culpa est similique et.', 'Fugit harum facere occaecati laboriosam voluptatem similique. Alias aut explicabo dolorum nemo quos. Qui a eos tenetur dolorum.', '11.JPG', 'book11.pdf', 'sound11.mp3', 'http//video_url11.com', 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 'Maxime rerum nulla consectetur.', 'Velit soluta eaque error mollitia fuga. Earum eum voluptatum quae consequatur itaque error veniam. Aut unde sed voluptas.', '12.JPG', 'book12.pdf', 'sound12.mp3', 'http//video_url12.com', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 'Perferendis repellat ex dolore.', 'Et quis voluptatum non voluptatem occaecati. Natus dolorum quis ratione. Natus maxime non laborum quia libero. Rem dicta placeat fugit iure ex rerum harum.', '13.JPG', 'book13.pdf', 'sound13.mp3', 'http//video_url13.com', 13, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 'Quasi alias neque.', 'Iusto eos molestiae animi eum ut. Sit voluptas voluptatem rem est consequatur adipisci. Et est eum qui velit. Voluptate quia atque quia aut quia reprehenderit. Fuga voluptatum ratione reprehenderit at vel vel sunt nihil.', '14.JPG', 'book14.pdf', 'sound14.mp3', 'http//video_url14.com', 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12');

-- --------------------------------------------------------

--
-- بنية الجدول `trainings`
--

DROP TABLE IF EXISTS `trainings`;
CREATE TABLE IF NOT EXISTS `trainings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `mark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trainings_subject_id_foreign` (`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `trainings`
--

INSERT INTO `trainings` (`id`, `name`, `subject_id`, `mark`, `type`, `length`, `start_at`, `end_at`, `thumbnail`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Nihil et minima.', 3, NULL, 'عام', 'hours 1', '2017-03-18 13:40:21', '1971-11-21 18:04:34', '01.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'Voluptates id enim.', 19, NULL, 'عام', 'hours 2', '1984-05-06 02:44:05', '1994-09-05 17:04:48', '02.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'Nihil maxime aliquid.', 12, NULL, 'عام', 'hours 3', '2008-06-09 20:23:41', '2011-10-21 08:16:02', '03.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'Expedita sit.', 19, NULL, 'عام', 'hours 4', '1973-02-25 12:45:43', '1974-02-20 02:16:24', '04.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'Voluptas itaque.', 25, NULL, 'عام', 'hours 5', '2013-08-10 00:56:25', '2002-10-18 18:21:04', '05.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 'Sunt corrupti.', 28, NULL, 'عام', 'hours 6', '1979-02-09 03:48:21', '1986-11-21 13:11:04', '06.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 'Aut eum.', 18, NULL, 'عام', 'hours 7', '2019-08-18 08:41:26', '1973-04-14 09:38:31', '07.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 'Sit officiis.', 17, NULL, 'عام', 'hours 8', '2003-03-20 04:45:55', '1985-11-09 12:24:28', '08.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 'Alias qui.', 22, NULL, 'عام', 'hours 9', '2004-01-27 00:39:31', '2016-01-28 09:38:19', '09.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 'Possimus eius temporibus.', 12, NULL, 'عام', 'hours 10', '2014-10-05 10:55:00', '1976-02-23 00:51:03', '10.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 'Voluptates dolore.', 19, NULL, 'عام', 'hours 11', '2010-09-12 04:08:24', '2020-07-29 19:03:44', '11.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 'Expedita et.', 38, NULL, 'عام', 'hours 12', '1989-12-27 03:19:22', '2020-07-17 16:50:14', '12.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 'Sed porro.', 28, NULL, 'عام', 'hours 13', '2007-09-21 07:49:27', '2001-02-13 16:28:51', '13.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 'Veniam eum quia.', 34, NULL, 'عام', 'hours 14', '2018-02-06 12:06:21', '2013-10-02 17:47:11', '14.JPG', NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(15, 'ادعم نفسك وقع رجال', 45, NULL, 'خاص', NULL, NULL, NULL, 'IMG-20200905002414.jpg', NULL, '2020-09-04 21:24:14', '2020-09-04 21:24:14');

-- --------------------------------------------------------

--
-- بنية الجدول `training_titles`
--

DROP TABLE IF EXISTS `training_titles`;
CREATE TABLE IF NOT EXISTS `training_titles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isCompleted` tinyint(1) NOT NULL DEFAULT '0',
  `training_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `training_titles_training_id_foreign` (`training_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `training_titles`
--

INSERT INTO `training_titles` (`id`, `name`, `isCompleted`, `training_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Fugit aut eum.', 0, 14, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'Qui nisi.', 0, 13, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'Sunt natus dolores.', 0, 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'Maxime quis.', 0, 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'Ratione sit autem.', 0, 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 'Quasi eaque nisi.', 0, 9, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 'Magnam consectetur praesentium.', 0, 11, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 'Ut rerum earum.', 0, 6, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 'Nam quam repudiandae.', 0, 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 'Placeat recusandae provident.', 0, 7, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 'Nisi mollitia.', 0, 9, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 'Omnis consequatur necessitatibus.', 0, 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 'Dolorem voluptate hic.', 0, 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 'Voluptatum enim.', 0, 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(15, 'Sit beatae.', 0, 5, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(16, 'Ea quia et.', 0, 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(17, 'Ea rerum.', 0, 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(18, 'Quia cupiditate.', 0, 12, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(19, 'Necessitatibus tempora.', 0, 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(20, 'Voluptatem culpa.', 0, 13, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(21, 'Molestiae aut nisi.', 0, 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(22, 'Quo molestiae.', 0, 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(23, 'Sunt est rerum.', 0, 14, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(24, 'Eligendi modi ducimus.', 0, 12, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(25, 'Maxime et ut.', 0, 7, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(26, 'Aut nobis ut.', 0, 14, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(27, 'Adipisci et quis.', 0, 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(28, 'Similique omnis.', 0, 4, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(29, 'Est ut.', 0, 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'مفعل',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `password`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Adnan Almaqwali', 774785566, '$2y$10$SvVHMfmD/tvvtpUCIgO15eEI/8z316hRIlq5MIZRsx5nbqc3A3yTS', 'مفعل', NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(2, 'Ali Almaqwali', 733771547, '$2y$10$ovLgdjUcMmgnHO5P4vxR2O4sPTXd792Rd6t7QKUO0Z3tsUSloV4Nm', 'مفعل', NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11'),
(3, 'Ahmed Almaqwali', 734455687, '$2y$10$yFZoe742yHdqZW7174y6q.AgAbT85I8SO1Ue2rzBTM8j7Hh.3CG/C', 'مفعل', NULL, '2020-09-04 20:01:11', '2020-09-04 20:01:11');

-- --------------------------------------------------------

--
-- بنية الجدول `women_categories`
--

DROP TABLE IF EXISTS `women_categories`;
CREATE TABLE IF NOT EXISTS `women_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `women_categories`
--

INSERT INTO `women_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'تنظيم الاسرة', '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'إجتماعية', '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'ثقافية', '2020-09-04 20:01:12', '2020-09-04 20:01:12');

-- --------------------------------------------------------

--
-- بنية الجدول `women_posts`
--

DROP TABLE IF EXISTS `women_posts`;
CREATE TABLE IF NOT EXISTS `women_posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `book` text COLLATE utf8mb4_unicode_ci,
  `sound` text COLLATE utf8mb4_unicode_ci,
  `video_url` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `women_posts_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `women_posts`
--

INSERT INTO `women_posts` (`id`, `title`, `body`, `image`, `book`, `sound`, `video_url`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Eaque quia quia animi.', 'Qui consequatur unde numquam quas dolor. Commodi dicta maxime repellendus et. Libero vel esse velit voluptatem. Autem eum sed eum id.', '01.JPG', 'book1.pdf', 'sound1.mp3', 'http//video_url1.com', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(2, 'Voluptatem quia possimus illum voluptatibus enim provident.', 'Provident voluptatem tenetur aut officiis rerum ut. Aspernatur ab maiores nam unde accusantium aspernatur. Impedit optio cupiditate impedit perspiciatis alias consequuntur exercitationem. Quo aut deserunt nisi dolor sapiente dolore.', '02.JPG', 'book2.pdf', 'sound2.mp3', 'http//video_url2.com', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(3, 'Itaque in fugiat quia ut eum.', 'Quod non aperiam qui animi. Ex voluptas dolores et non perspiciatis. Voluptatibus natus ea placeat ex soluta.', '03.JPG', 'book3.pdf', 'sound3.mp3', 'http//video_url3.com', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(4, 'Repellat aliquid sit et alias eos vitae delectus.', 'Minus dolores repudiandae doloribus asperiores vel sit inventore. Omnis voluptatibus aut laborum ut. Voluptas nihil qui ipsa aut saepe aliquid repellendus.', '04.JPG', 'book4.pdf', 'sound4.mp3', 'http//video_url4.com', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(5, 'Praesentium porro reiciendis molestiae dolores molestiae.', 'Eos voluptatem veniam omnis et eum. Nesciunt sed error at sunt non earum. Aut et molestias quia quod. Maiores eum beatae eligendi reprehenderit quidem rerum.', '05.JPG', 'book5.pdf', 'sound5.mp3', 'http//video_url5.com', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(6, 'Cupiditate libero magni minima aperiam.', 'Est fugiat sed sint quos non quas. Dolorum quis id facilis neque nihil ipsa id atque. Alias rerum qui reiciendis tempora optio doloremque. Aperiam esse sit tempora quod doloribus.', '06.JPG', 'book6.pdf', 'sound6.mp3', 'http//video_url6.com', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(7, 'A ex suscipit est qui.', 'Suscipit ut rerum est nulla enim quasi ad nobis. Voluptatem tempora vel velit. Fugiat eligendi eos quia dolores voluptatem quia. Aspernatur harum qui harum atque voluptates qui expedita.', '07.JPG', 'book7.pdf', 'sound7.mp3', 'http//video_url7.com', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(8, 'Natus quis voluptatum et accusamus consequatur omnis dolores.', 'Nisi officia accusantium sit et quis atque libero. Sunt corrupti sequi cum quia laboriosam iste qui qui. Labore a quisquam nostrum esse eligendi ducimus. Alias laudantium aut consectetur error sit velit.', '08.JPG', 'book8.pdf', 'sound8.mp3', 'http//video_url8.com', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(9, 'Odio et officia modi vero veritatis.', 'Error quod commodi at dignissimos ipsam. Dolor ut architecto autem voluptatem. Rerum quos voluptates quibusdam numquam ut quisquam nihil. Iure optio porro sunt aspernatur et doloremque ut.', '09.JPG', 'book9.pdf', 'sound9.mp3', 'http//video_url9.com', 3, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(10, 'Ducimus ad delectus sint consequuntur dolor culpa doloribus nihil.', 'Ipsam aut cumque quod aut. Doloribus esse architecto dolor aut dolorum aspernatur facere voluptatem. Voluptas id velit eum vero vitae. Rem est optio nostrum. Ut et non doloribus ad explicabo mollitia expedita.', '10.JPG', 'book10.pdf', 'sound10.mp3', 'http//video_url10.com', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(11, 'Qui aliquid cum consequuntur ad autem tenetur qui.', 'Quidem sunt consequatur a aperiam excepturi. Explicabo fuga quaerat rerum qui explicabo ratione. Nulla sint aperiam dolores et a dolorem sit.', '11.JPG', 'book11.pdf', 'sound11.mp3', 'http//video_url11.com', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(12, 'Omnis facere consequatur dolores.', 'Laudantium optio voluptatem sit fugiat omnis. Tenetur iste sed culpa sint sunt consequatur. Voluptatibus facere ea qui animi facere consectetur. Quo sunt et est aut reiciendis ut numquam. Est voluptatibus quas exercitationem sapiente odit nesciunt quo.', '12.JPG', 'book12.pdf', 'sound12.mp3', 'http//video_url12.com', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(13, 'Est tenetur quos cumque est iste corrupti fugit.', 'Voluptas doloribus debitis vitae dolor debitis deleniti beatae ut. Sed neque est facilis modi eum magni hic. Optio assumenda voluptatem consequuntur quod tempore eos qui reiciendis.', '13.JPG', 'book13.pdf', 'sound13.mp3', 'http//video_url13.com', 1, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12'),
(14, 'Corrupti incidunt porro sunt necessitatibus vitae aut quia.', 'Accusamus et et numquam aut. Repellat sint iusto dolorem. Qui neque nihil ducimus consequatur. Possimus consequatur est hic est natus magni mollitia.', '14.JPG', 'book14.pdf', 'sound14.mp3', 'http//video_url14.com', 2, NULL, '2020-09-04 20:01:12', '2020-09-04 20:01:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
