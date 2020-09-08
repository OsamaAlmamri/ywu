-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08 سبتمبر 2020 الساعة 02:25
-- إصدار الخادم: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ywu2`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Adnan Almaqwali', 'admin@test.com', 'IMG-20200906012531.jpeg', NULL, '$2y$10$Yl7B3b.FGmm6jPJdil2DrOFUeESMCklz/UE9DgUuhtMIf.uSx8lPW', NULL, '2020-09-04 17:01:11', '2020-09-05 19:25:31');

-- --------------------------------------------------------

--
-- بنية الجدول `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'المقر الرئيسي', NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'استشارة اسرية', '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(2, 'استشارة نفسية', '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(3, 'استشارة قانونية', '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(4, 'شكاوى', '2020-09-04 17:01:11', '2020-09-04 17:01:11');

-- --------------------------------------------------------

--
-- بنية الجدول `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `is_consonant` tinyint(1) NOT NULL DEFAULT 0,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `is_consonant`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y ', 1, NULL, NULL),
(2, 1, 1, 0, '9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y ', 1, NULL, NULL),
(3, 1, 1, 0, '9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y 9hy9y ', 1, NULL, NULL),
(4, 1, 6, 0, 'طيب استاذي العزيز طالما والاب هو المسؤول الوحيد عن هذا الشي اذا ايش دور الام في الاسرة', 1, '2020-09-07 19:42:41', '2020-09-07 19:42:41'),
(5, 1, 6, 0, 'طيب استاذي العزيز طالما والاب هو المسؤول الوحيد عن هذا الشي اذا ايش دور الام في الاسرة', 1, '2020-09-07 19:51:10', '2020-09-07 19:51:10'),
(6, 3, 6, 1, 'طيب استاذي العزيز طالما والاب هو المسؤول الوحيد عن هذا الشي اذا ايش دور الام في الاسرة', 1, '2020-09-07 19:54:30', '2020-09-07 19:54:30');

-- --------------------------------------------------------

--
-- بنية الجدول `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'it', NULL, NULL),
(2, 'cs', '2020-09-06 19:14:58', '2020-09-06 19:14:58'),
(3, 'is', '2020-09-06 19:15:10', '2020-09-06 19:15:10');

-- --------------------------------------------------------

--
-- بنية الجدول `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `department_id`, `branch_id`, `job_id`) VALUES
(1, 1, 1, 1, 5),
(3, 3, 2, 1, 1),
(4, 9, 1, 1, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `jobs`
--

INSERT INTO `jobs` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'استشاريj', '2020-09-04 17:01:11', '2020-09-06 19:07:25'),
(2, 'مدرب', '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(3, 'اخصائي', '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(4, 'سمكري', '2020-09-04 17:12:47', '2020-09-04 17:12:47'),
(5, 'مهندس', '2020-09-04 17:27:29', '2020-09-04 17:27:29'),
(8, 'kpokjpo;', '2020-09-06 19:07:38', '2020-09-06 19:07:38');

-- --------------------------------------------------------

--
-- بنية الجدول `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `liked_id` int(10) UNSIGNED NOT NULL,
  `type` enum('posts','women_posts') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'posts',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `liked_id`, `type`, `created_at`, `updated_at`) VALUES
(3, 3, 100, 'posts', '2020-09-07 23:34:19', '2020-09-07 23:34:19');

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_07_28_191525_create_categories_table', 1),
(5, '2020_07_28_192317_create_posts_table', 1),
(7, '2020_08_03_204228_create_women_posts_table', 2),
(8, '2020_08_17_204121_create_subject_categories_table', 2),
(9, '2020_08_17_204621_create_subjects_table', 2),
(10, '2020_08_17_210126_create_trainings_table', 2),
(11, '2020_08_17_210340_create_training_titles_table', 2),
(12, '2020_08_17_210432_create_title_contents_table', 2),
(13, '2020_08_29_144938_create_questions_table', 2),
(14, '2020_08_29_222758_create_admins_table', 2),
(15, '2020_09_03_141446_create_share_users_table', 2),
(16, '2020_09_06_192553_create_branches_table', 2),
(17, '2020_09_06_192826_create_departments_table', 2),
(18, '2020_09_06_192845_create_jobs_table', 2),
(19, '2020_09_06_200528_create_results_table', 2),
(20, '2020_09_06_200624_create_user_training_tiltles_table', 2),
(21, '2020_09_07_203200_create_employees_table', 2),
(22, '2020_07_28_192339_create_comments_table', 3),
(23, '2020_09_08_012339_create_likes_table', 4);

-- --------------------------------------------------------

--
-- بنية الجدول `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `favorite` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `user_id`, `category_id`, `status`, `favorite`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Est in quia est et.', 'Rerum alias repellendus harum sed voluptates molestias voluptas. Sed qui non sapiente sit minus. Ullam voluptates necessitatibus facere non velit pariatur et.', 3, 2, 1, 0, NULL, '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(2, 'Sint deserunt facilis quod.', 'Veritatis cumque sint non ex debitis velit officia. Ipsa temporibus facilis ullam cumque distinctio. Aut blanditiis corporis natus iste quia.', 3, 3, 1, 0, '2020-09-07 10:30:09', '2020-09-04 17:01:11', '2020-09-07 10:30:09'),
(4, 'Sint deserunt facilis quod.', 'Veritatis cumque sint non ex debitis velit officia. Ipsa temporibus facilis ullam cumque distinctio. Aut blanditiis corporis natus iste quia.', 3, 3, 1, 0, NULL, '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(5, 'Est in quia est et.', 'Rerum alias repellendus harum sed voluptates molestias voluptas. Sed qui non sapiente sit minus. Ullam voluptates necessitatibus facere non velit pariatur et.', 3, 2, 1, 0, NULL, '2020-09-04 17:01:11', '2020-09-04 17:01:11'),
(6, 'العلاقات الاسرية وما ادراك ما العلاقات الاسرية', 'عنوان الاستشارة غريب نوعا ما ولكن الاهم من ذالك لماذا العلاقات الاسرية نجدها في اغلب الاسر هشة او بمعنى اصح لا يوجد ترابط بين افراد الاسرة ؟', 3, 1, 1, 0, NULL, '2020-09-07 19:40:32', '2020-09-07 19:41:10'),
(7, 'العلاقات الاسرية وما ادراك ما العلاقات الاسرية', 'عنوان الاستشارة غريب نوعا ما ولكن الاهم من ذالك لماذا العلاقات الاسرية نجدها في اغلب الاسر هشة او بمعنى اصح لا يوجد ترابط بين افراد الاسرة ؟', 3, 1, 0, 0, NULL, '2020-09-07 20:57:48', '2020-09-07 20:57:48');

-- --------------------------------------------------------

--
-- بنية الجدول `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option4` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` enum('option1','option2','option3','option4') COLLATE utf8mb4_unicode_ci NOT NULL,
  `training_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `questions`
--

INSERT INTO `questions` (`id`, `text`, `image`, `option1`, `option2`, `option3`, `option4`, `answer`, `training_id`, `created_at`, `updated_at`) VALUES
(2, 'خخخ', 'IMG-20200907154308.PNG', 'خ', 'خ', 'ح', '9', 'option1', 9, '2020-09-07 12:43:08', '2020-09-07 12:43:08'),
(3, '8798lp[lk[', 'IMG-20200907161049.PNG', '11', '22', '33', '44', 'option2', 9, '2020-09-07 13:10:49', '2020-09-07 13:38:57'),
(4, 'nviohoih', NULL, 'ii', 'iiii', '888', '8', 'option4', 9, '2020-09-07 13:45:19', '2020-09-07 13:45:19'),
(5, 'ننج', NULL, 'خ', 'خخ', 'خخ', 'خ', 'option3', 9, '2020-09-07 17:53:04', '2020-09-07 17:53:04');

-- --------------------------------------------------------

--
-- بنية الجدول `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `training_id` bigint(20) UNSIGNED NOT NULL,
  `grade` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `results`
--

INSERT INTO `results` (`id`, `user_id`, `training_id`, `grade`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 95, '2020-09-07 21:00:00', '2020-09-06 21:00:00'),
(2, 3, 9, 50, '2020-09-06 21:00:00', NULL),
(3, 3, 1, 100, '2020-09-07 22:21:26', '2020-09-07 22:21:26'),
(4, 3, 5, 58, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `share_users`
--

CREATE TABLE `share_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('sub_cluster','copartner') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sub_cluster',
  `destination` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `share_users`
--

INSERT INTO `share_users` (`id`, `user_id`, `type`, `destination`) VALUES
(2, 3, 'copartner', 'ihoi'),
(9, 27, 'copartner', 'الجهة'),
(10, 28, 'copartner', 'الجهة');

-- --------------------------------------------------------

--
-- بنية الجدول `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Repellendus pariatur.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(2, 'Qui sit.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(3, 'Qui magnam.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(4, 'Facilis est itaque.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(5, 'Nam deleniti.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(6, 'Eligendi ut dolor.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(7, 'Quaerat molestiae qui.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(8, 'Nostrum sed aliquid.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(9, 'Dolores quia.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(10, 'Itaque et.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(11, 'A accusamus.', 3, NULL, '2020-09-04 17:01:12', '2020-09-06 22:30:23'),
(12, 'Velit placeat.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(13, 'Illum numquam.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(14, 'Eos explicabo.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(15, 'Perferendis adipisci.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(16, 'Ad ea.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(17, 'Non non.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(18, 'Omnis dolor unde.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(19, 'Maxime qui nemo.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(20, 'Optio velit.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(21, 'Labore unde.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(22, 'Libero tenetur.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(23, 'Tenetur magni impedit.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(24, 'Molestiae vero veritatis.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(25, 'Labore et alias.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(26, 'Aut iste.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(27, 'Ea numquam.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(28, 'Qui ut.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(29, 'Cum ad.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(30, 'Molestiae amet.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(31, 'Quo voluptas.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(32, 'Aliquam quis.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(33, 'Corporis blanditiis facere.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(34, 'Aut labore.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(35, 'Sint perspiciatis mollitia.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(36, 'Sint temporibus pariatur.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(37, 'Aut repellat.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(38, 'Suscipit id eligendi.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(39, 'Ad delectus commodi.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(40, 'Soluta et.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(41, 'Omnis totam temporibus.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(42, 'Fugiat sequi.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(43, 'Sed at.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(44, 'Est debitis est.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(45, 'دعم مادي', 2, NULL, '2020-09-04 18:23:23', '2020-09-04 18:23:23'),
(46, 'ojop', 1, NULL, '2020-09-05 16:23:39', '2020-09-05 16:23:39'),
(47, '44', 1, NULL, '2020-09-07 17:14:09', '2020-09-07 17:14:09'),
(48, 'تجويد', 1, NULL, '2020-09-07 21:11:21', '2020-09-07 21:11:21');

-- --------------------------------------------------------

--
-- بنية الجدول `subject_categories`
--

CREATE TABLE `subject_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `subject_categories`
--

INSERT INTO `subject_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'التغطية الاعلامية', '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(2, 'الدعم النفسي', '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(3, 'إدارة الحالة', '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(4, 'الدعم القانوني', '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(5, 'IT', '2020-09-04 17:01:12', '2020-09-04 17:01:12');

-- --------------------------------------------------------

--
-- بنية الجدول `title_contents`
--

CREATE TABLE `title_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sound` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `title_contents`
--

INSERT INTO `title_contents` (`id`, `title`, `body`, `image`, `book`, `sound`, `video_url`, `title_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'pk', 'o', 'IMG-20200907013437.PNG', NULL, NULL, NULL, 11, NULL, '2020-09-06 22:34:37', '2020-09-06 22:34:37'),
(2, '887', '8\r\n8', 'IMG-20200907164249.PNG', NULL, NULL, NULL, 31, NULL, '2020-09-07 13:42:49', '2020-09-07 13:42:49');

-- --------------------------------------------------------

--
-- بنية الجدول `trainings`
--

CREATE TABLE `trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `trainings`
--

INSERT INTO `trainings` (`id`, `name`, `subject_id`, `mark`, `type`, `length`, `start_at`, `end_at`, `thumbnail`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Nihil et minima.', 3, NULL, 'عام', 'hours 1', '2017-03-18 13:40:21', '1971-11-21 18:04:34', '01.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(2, 'Voluptates id enim.', 19, NULL, 'عام', 'hours 2', '1984-05-06 02:44:05', '1994-09-05 17:04:48', '02.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(3, 'Nihil maxime aliquid.', 12, NULL, 'عام', 'hours 3', '2008-06-09 20:23:41', '2011-10-21 08:16:02', '03.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(4, 'Expedita sit.', 19, NULL, 'عام', 'hours 4', '1973-02-25 12:45:43', '1974-02-20 02:16:24', '04.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(5, 'Voluptas itaque.', 25, NULL, 'عام', 'hours 5', '2013-08-10 00:56:25', '2002-10-18 18:21:04', '05.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(6, 'Sunt corrupti.', 28, NULL, 'عام', 'hours 6', '1979-02-09 03:48:21', '1986-11-21 13:11:04', '06.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(7, 'Aut eum.', 18, NULL, 'عام', 'hours 7', '2019-08-18 08:41:26', '1973-04-14 09:38:31', '07.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(8, 'Sit officiis.', 17, NULL, 'عام', 'hours 8', '2003-03-20 04:45:55', '1985-11-09 12:24:28', '08.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(9, 'Alias qui.', 22, NULL, 'عام', 'hours 9', '2004-01-27 00:39:31', '2016-01-28 09:38:19', '09.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(10, 'Possimus eius temporibus.', 12, NULL, 'عام', 'hours 10', '2014-10-05 10:55:00', '1976-02-23 00:51:03', '10.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(11, 'Voluptates dolore.', 19, NULL, 'عام', 'hours 11', '2010-09-12 04:08:24', '2020-07-29 19:03:44', '11.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(12, 'Expedita et.', 38, NULL, 'عام', 'hours 12', '1989-12-27 03:19:22', '2020-07-17 16:50:14', '12.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(13, 'Sed porro.', 28, NULL, 'عام', 'hours 13', '2007-09-21 07:49:27', '2001-02-13 16:28:51', '13.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(14, 'Veniam eum quia.', 34, NULL, 'عام', 'hours 14', '2018-02-06 12:06:21', '2013-10-02 17:47:11', '14.JPG', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(15, 'ادعم نفسك وقع رجال', 45, NULL, 'خاص', NULL, NULL, NULL, 'IMG-20200905002414.jpg', NULL, '2020-09-04 18:24:14', '2020-09-04 18:24:14'),
(16, 'الكريمي', 1, 'مميزة', 'خاص', '4 ساعات', '2020-10-02 17:25:00', NULL, 'IMG-20200905222504.PNG', NULL, '2020-09-05 16:25:04', '2020-09-05 16:25:04');

-- --------------------------------------------------------

--
-- بنية الجدول `training_titles`
--

CREATE TABLE `training_titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `training_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `training_titles`
--

INSERT INTO `training_titles` (`id`, `name`, `training_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Fugit aut eum.', 14, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(2, 'Qui nisi.', 13, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(3, 'Sunt natus dolores.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(4, 'Maxime quis.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(5, 'Ratione sit autem.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(6, 'Quasi eaque nisi.', 9, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(7, 'Magnam consectetur praesentium.', 11, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(8, 'Ut rerum earum.', 6, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(9, 'Nam quam repudiandae.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(10, 'Placeat recusandae provident.', 7, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(11, 'Nisi mollitia.', 9, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(12, 'Omnis consequatur necessitatibus.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(13, 'Dolorem voluptate hic.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(14, 'Voluptatum enim.', 2, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(15, 'Sit beatae.', 5, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(16, 'Ea quia et.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(17, 'Ea rerum.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(18, 'Quia cupiditate.', 12, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(19, 'Necessitatibus tempora.', 1, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(20, 'Voluptatem culpa.', 13, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(21, 'Molestiae aut nisi.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(22, 'Quo molestiae.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(23, 'Sunt est rerum.', 14, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(24, 'Eligendi modi ducimus.', 12, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(25, 'Maxime et ut.', 7, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(26, 'Aut nobis ut.', 14, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(27, 'Adipisci et quis.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(28, 'Similique omnis.', 4, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(29, 'Est ut.', 3, NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(30, 'iohoihoiho', 9, NULL, '2020-09-07 11:01:08', '2020-09-07 11:01:08'),
(31, '000000', 9, NULL, '2020-09-07 12:07:15', '2020-09-07 13:42:09');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('share_users','employees','visitor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'visitor',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Adnan Almaqwali', 774785566, 'admi0n@test.com', '$2y$10$SvVHMfmD/tvvtpUCIgO15eEI/8z316hRIlq5MIZRsx5nbqc3A3yTS', 'employees', 1, NULL, '2020-09-04 17:01:11', '2020-09-06 21:49:54'),
(3, 'صدام حسين', 734455687, NULL, '$2y$10$SvVHMfmD/tvvtpUCIgO15eEI/8z316hRIlq5MIZRsx5nbqc3A3yTS', 'share_users', 1, NULL, '2020-09-04 17:01:11', '2020-09-07 20:59:50'),
(8, 'Osama mohammed Ahmed Al-mamri', 771144755, 'straw4hat@gmail.com', '$2y$10$wjyzg7G/.Hd3W/sjL.RC3OSQDsaVij1wusQeQQEqQlZdKzeYtPKse', 'employees', 1, NULL, '2020-09-06 19:35:46', '2020-09-06 19:35:46'),
(9, 'oj[[[[[[[[[opj', 773569841, 'osama1234887@gmail.com', '$2y$10$bolW38Uex7yYcjdcVqnUj.B68yhBUeJCPSHhFGqbJtCAKi31inIRa', 'employees', 1, NULL, '2020-09-06 19:45:27', '2020-09-06 20:19:25'),
(12, 'صالح مروح', 773569041, NULL, '$2y$10$qMhT0K6q.xK/iBpyCzhtr.k56GP9kw3Hk9S4ROGJwU9t183Yrrh1O', 'visitor', 1, NULL, '2020-09-07 18:52:24', '2020-09-07 18:52:24'),
(26, 'صالح مروح100', 773569970, NULL, '$2y$10$V64mZuxo7kJrUHPoguE14OS4Ogby8ZHuHjBcL.GLauhPxUXC9Ma5.', 'visitor', 1, NULL, '2020-09-07 19:27:47', '2020-09-07 19:27:47'),
(27, 'صالح مروح100', 773569979, NULL, '$2y$10$.FkYc.ajIrgsI4mpEWtIyenYB//hYIBSvyP97WWwMTD6yEutIIVOa', 'share_users', 0, NULL, '2020-09-07 19:28:01', '2020-09-07 19:28:01'),
(28, 'osama', 716556396, NULL, '$2y$10$ZwsjBsWZcYytBOj66dfFS.2lvuwdueymxmoInxQZvefOtF1tZARjS', 'share_users', 0, NULL, '2020-09-07 19:30:30', '2020-09-07 19:30:30'),
(29, 'osama', 716556390, NULL, '$2y$10$NUIWYfWsd6Jx2bOtC61TVeaSPsphE2ZkD4tWUzTULSKottJKZeazC', 'visitor', 1, NULL, '2020-09-07 19:30:51', '2020-09-07 19:30:51');

-- --------------------------------------------------------

--
-- بنية الجدول `user_training_titles`
--

CREATE TABLE `user_training_titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `user_training_titles`
--

INSERT INTO `user_training_titles` (`id`, `user_id`, `title_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2020-09-07 22:17:32', '2020-09-07 22:17:32'),
(2, 3, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `women_posts`
--

CREATE TABLE `women_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_external_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sound` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `women_posts`
--

INSERT INTO `women_posts` (`id`, `title`, `body`, `image`, `book`, `book_external_link`, `sound`, `video_url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Voluptatem quia possimus illum voluptatibus enim provident.', 'Provident voluptatem tenetur aut officiis rerum ut. Aspernatur ab maiores nam unde accusantium aspernatur. Impedit optio cupiditate impedit perspiciatis alias consequuntur exercitationem. Quo aut deserunt nisi dolor sapiente dolore.', '02.JPG', 'book2.pdf', NULL, 'sound2.mp3', 'http//video_url2.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(3, 'Itaque in fugiat quia ut eum.', 'Quod non aperiam qui animi. Ex voluptas dolores et non perspiciatis. Voluptatibus natus ea placeat ex soluta.', '03.JPG', 'book3.pdf', NULL, 'sound3.mp3', 'http//video_url3.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(4, 'Repellat aliquid sit et alias eos vitae delectus.', 'Minus dolores repudiandae doloribus asperiores vel sit inventore. Omnis voluptatibus aut laborum ut. Voluptas nihil qui ipsa aut saepe aliquid repellendus.', '04.JPG', 'book4.pdf', NULL, 'sound4.mp3', 'http//video_url4.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(5, 'Praesentium porro reiciendis molestiae dolores molestiae.', 'Eos voluptatem veniam omnis et eum. Nesciunt sed error at sunt non earum. Aut et molestias quia quod. Maiores eum beatae eligendi reprehenderit quidem rerum.', '05.JPG', 'book5.pdf', NULL, 'sound5.mp3', 'http//video_url5.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(6, 'Cupiditate libero magni minima aperiam.', 'Est fugiat sed sint quos non quas. Dolorum quis id facilis neque nihil ipsa id atque. Alias rerum qui reiciendis tempora optio doloremque. Aperiam esse sit tempora quod doloribus.', '06.JPG', 'book6.pdf', NULL, 'sound6.mp3', 'http//video_url6.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(7, 'iiiiiiiiiiiiiii', 'Suscipit ut rerum est nulla enim quasi ad nobis. Voluptatem tempora vel velit. Fugiat eligendi eos quia dolores voluptatem quia. Aspernatur harum qui harum atque voluptates qui expedita.', NULL, NULL, NULL, 'sound7.mp3', 'http//video_url7.com', NULL, '2020-09-04 17:01:12', '2020-09-05 16:13:39'),
(8, 'Natus quis voluptatum et accusamus consequatur omnis dolores.', 'Nisi officia accusantium sit et quis atque libero. Sunt corrupti sequi cum quia laboriosam iste qui qui. Labore a quisquam nostrum esse eligendi ducimus. Alias laudantium aut consectetur error sit velit.', NULL, NULL, NULL, 'sound8.mp3', 'http//video_url8.com', NULL, '2020-09-04 17:01:12', '2020-09-05 16:14:23'),
(9, 'Odio et officia modi vero veritatis.', 'Error quod commodi at dignissimos ipsam. Dolor ut architecto autem voluptatem. Rerum quos voluptates quibusdam numquam ut quisquam nihil. Iure optio porro sunt aspernatur et doloremque ut.', '09.JPG', 'book9.pdf', NULL, 'sound9.mp3', 'http//video_url9.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(10, 'Ducimus ad delectus sint consequuntur dolor culpa doloribus nihil.', 'Ipsam aut cumque quod aut. Doloribus esse architecto dolor aut dolorum aspernatur facere voluptatem. Voluptas id velit eum vero vitae. Rem est optio nostrum. Ut et non doloribus ad explicabo mollitia expedita.', '10.JPG', 'book10.pdf', NULL, 'sound10.mp3', 'http//video_url10.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(11, 'Qui aliquid cum consequuntur ad autem tenetur qui.', 'Quidem sunt consequatur a aperiam excepturi. Explicabo fuga quaerat rerum qui explicabo ratione. Nulla sint aperiam dolores et a dolorem sit.', '11.JPG', 'book11.pdf', NULL, 'sound11.mp3', 'http//video_url11.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(12, 'Omnis facere consequatur dolores.', 'Laudantium optio voluptatem sit fugiat omnis. Tenetur iste sed culpa sint sunt consequatur. Voluptatibus facere ea qui animi facere consectetur. Quo sunt et est aut reiciendis ut numquam. Est voluptatibus quas exercitationem sapiente odit nesciunt quo.', '12.JPG', 'book12.pdf', NULL, 'sound12.mp3', 'http//video_url12.com', NULL, '2020-09-04 17:01:12', '2020-09-04 17:01:12'),
(13, 'Est tenetur quos cumque est iste corrupti fugit.', 'Voluptas doloribus debitis vitae dolor debitis deleniti beatae ut. Sed neque est facilis modi eum magni hic. Optio assumenda voluptatem consequuntur quod tempore eos qui reiciendis.', NULL, NULL, NULL, 'sound13.mp3', 'http//video_url13.com', NULL, '2020-09-04 17:01:12', '2020-09-05 16:14:02'),
(14, 'Corrupti incidunt porro sunt necessitatibus vitae aut quia.', 'Accusamus et et numquam aut. Repellat sint iusto dolorem. Qui neque nihil ducimus consequatur. Possimus consequatur est hic est natus magni mollitia.', 'IMG-20200907121102.png', NULL, NULL, 'sound14.mp3', 'http//video_url14.com', NULL, '2020-09-04 17:01:12', '2020-09-07 09:11:02'),
(15, 'دينار كويتي', '78\r\n8', 'IMG-20200905214357.PNG', NULL, NULL, NULL, 'http//video_url7.com', NULL, '2020-09-05 15:43:57', '2020-09-05 15:43:57'),
(16, 'ppppppp', 'pppppppp', 'IMG-20200907011134.png', 'BOK-20200907011134.pdf', NULL, NULL, 'http//video_url14.com', NULL, '2020-09-06 22:11:34', '2020-09-06 22:24:13'),
(17, 'o', 'ojopj', NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-07 17:06:36', '2020-09-07 17:06:36'),
(18, '8487498', '888', NULL, NULL, 'http://127.0.0.1:8000/WShow', NULL, NULL, NULL, '2020-09-07 23:05:25', '2020-09-07 23:05:25'),
(19, 'pkp', 'kpokpok', NULL, 'BOK-20200908022718.pdf', NULL, NULL, NULL, NULL, '2020-09-07 23:27:18', '2020-09-07 23:27:18'),
(20, '888', '58', NULL, 'BOK-20200908022912.pdf', NULL, NULL, NULL, NULL, '2020-09-07 23:29:12', '2020-09-07 23:29:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
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
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_branch_id_foreign` (`branch_id`),
  ADD KEY `employees_job_id_foreign` (`job_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_category_id_foreign` (`category_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_training_id_foreign` (`training_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `results_user_id_foreign` (`user_id`),
  ADD KEY `results_training_id_foreign` (`training_id`);

--
-- Indexes for table `share_users`
--
ALTER TABLE `share_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_category_id_foreign` (`category_id`);

--
-- Indexes for table `subject_categories`
--
ALTER TABLE `subject_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `title_contents`
--
ALTER TABLE `title_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title_contents_title_id_foreign` (`title_id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainings_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `training_titles`
--
ALTER TABLE `training_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_titles_training_id_foreign` (`training_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_training_titles`
--
ALTER TABLE `user_training_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_training_titles_user_id_foreign` (`user_id`),
  ADD KEY `user_training_titles_title_id_foreign` (`title_id`);

--
-- Indexes for table `women_posts`
--
ALTER TABLE `women_posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `share_users`
--
ALTER TABLE `share_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `subject_categories`
--
ALTER TABLE `subject_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `title_contents`
--
ALTER TABLE `title_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `training_titles`
--
ALTER TABLE `training_titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_training_titles`
--
ALTER TABLE `user_training_titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `women_posts`
--
ALTER TABLE `women_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `share_users`
--
ALTER TABLE `share_users`
  ADD CONSTRAINT `share_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `subject_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `title_contents`
--
ALTER TABLE `title_contents`
  ADD CONSTRAINT `title_contents_title_id_foreign` FOREIGN KEY (`title_id`) REFERENCES `training_titles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `trainings`
--
ALTER TABLE `trainings`
  ADD CONSTRAINT `trainings_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `training_titles`
--
ALTER TABLE `training_titles`
  ADD CONSTRAINT `training_titles_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `user_training_titles`
--
ALTER TABLE `user_training_titles`
  ADD CONSTRAINT `user_training_titles_title_id_foreign` FOREIGN KEY (`title_id`) REFERENCES `training_titles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_training_titles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
