-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2023 at 09:20 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `terra_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Programming', 'Programming related activities', '2023-12-04 12:53:34', '2023-12-04 12:53:34', NULL),
(2, 'Testing', 'Testing related activities', '2023-12-04 12:53:34', '2023-12-04 12:53:34', NULL),
(3, 'Learning', 'Activities related to learning and training', '2023-12-04 12:53:34', '2023-12-04 12:53:34', NULL),
(4, 'Research', 'Activities related to research', '2023-12-04 12:53:34', '2023-12-04 12:53:34', NULL),
(5, 'Other', 'Other activities', '2023-12-04 12:53:34', '2023-12-04 12:53:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ch_favorites`
--

CREATE TABLE `ch_favorites` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint NOT NULL,
  `favorite_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ch_messages`
--

CREATE TABLE `ch_messages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint NOT NULL,
  `to_id` bigint NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_messages`
--

INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('3486979e-b810-46ab-89b9-3bb117195a64', 2, 1, 'a', NULL, 1, '2023-12-04 14:30:01', '2023-12-04 14:35:06'),
('838553b3-053a-4391-bebc-3b6bf4a4ba73', 2, 2, 'ds', NULL, 1, '2023-12-04 14:30:57', '2023-12-04 14:32:01'),
('9a956a89-0749-4b44-9f36-c4bc8272c8b7', 2, 2, 'adasdasda', NULL, 1, '2023-12-04 14:30:16', '2023-12-04 14:30:25'),
('af58043b-c8da-49ad-a109-52363f0d9b68', 2, 1, 'assas', NULL, 1, '2023-12-04 13:25:42', '2023-12-04 14:01:56'),
('b1a2f3fc-4b78-4f00-aac3-c807a28825c0', 2, 3, 'aaa', NULL, 0, '2023-12-04 14:34:30', '2023-12-04 14:34:30'),
('d2dbdd11-69dc-4252-8db1-1594b0087533', 1, 2, 'adasda', NULL, 0, '2023-12-04 14:35:34', '2023-12-04 14:35:34'),
('ec05ba66-03c0-475a-a529-ad52581938b6', 2, 1, 'asdasd', NULL, 1, '2023-12-04 14:32:20', '2023-12-04 14:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `epics`
--

CREATE TABLE `epics` (
  `id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_at` date NOT NULL,
  `ends_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_11_02_111430_add_two_factor_columns_to_table', 1),
(6, '2022_11_02_113007_create_permission_tables', 1),
(7, '2022_11_02_124027_create_project_statuses_table', 1),
(8, '2022_11_02_124028_create_projects_table', 1),
(9, '2022_11_02_131753_create_project_users_table', 1),
(10, '2022_11_02_134510_create_media_table', 1),
(11, '2022_11_02_152359_create_project_favorites_table', 1),
(12, '2022_11_02_193241_create_ticket_statuses_table', 1),
(13, '2022_11_02_193242_create_tickets_table', 1),
(14, '2022_11_06_155109_add_tickets_prefix_to_projects', 1),
(15, '2022_11_06_163226_add_code_to_tickets', 1),
(16, '2022_11_06_164004_create_ticket_types_table', 1),
(17, '2022_11_06_165400_add_type_to_ticket', 1),
(18, '2022_11_06_173220_add_order_to_tickets', 1),
(19, '2022_11_06_184448_add_order_to_ticket_statuses', 1),
(20, '2022_11_06_193051_create_ticket_activities_table', 1),
(21, '2022_11_06_194000_create_ticket_priorities_table', 1),
(22, '2022_11_06_194728_add_priority_to_tickets', 1),
(23, '2022_11_06_203702_add_status_type_to_project', 1),
(24, '2022_11_06_204227_add_project_to_ticket_statuses', 1),
(25, '2022_11_07_064347_create_ticket_comments_table', 1),
(26, '2022_11_08_084509_create_ticket_subscribers_table', 1),
(27, '2022_11_08_144611_create_notifications_table', 1),
(28, '2022_11_08_150309_create_jobs_table', 1),
(29, '2022_11_08_163244_create_ticket_relations_table', 1),
(30, '2022_11_08_172846_create_settings_table', 1),
(31, '2022_11_08_173004_general_settings', 1),
(32, '2022_11_08_173852_create_general_settings', 1),
(33, '2022_11_09_085506_create_socialite_users_table', 1),
(34, '2022_11_09_085638_make_user_password_nullable', 1),
(35, '2022_11_09_110740_remove_unique_from_users', 1),
(36, '2022_11_09_110955_add_soft_deletes_to_users', 1),
(37, '2022_11_09_173852_add_social_login_to_general_settings', 1),
(38, '2022_11_10_193214_create_ticket_hours_table', 1),
(39, '2022_11_10_200608_add_estimation_to_tickets', 1),
(40, '2022_11_12_134201_add_creation_token_to_users', 1),
(41, '2022_11_12_142644_create_pending_user_emails_table', 1),
(42, '2022_11_12_173852_add_default_role_to_general_settings', 1),
(43, '2022_11_12_173852_add_login_form_oidc_enabled_flags_to_general_settings', 1),
(44, '2022_11_12_173852_add_site_language_to_general_settings', 1),
(45, '2022_12_15_100852_create_epics_table', 1),
(46, '2022_12_15_101035_add_epic_to_ticket', 1),
(47, '2022_12_16_133836_add_parent_to_epics', 1),
(48, '2022_12_27_082239_add_comment_to_ticket_hours', 1),
(49, '2023_01_05_182946_add_attachments_to_tickets', 1),
(50, '2023_01_09_113159_create_activities_table', 1),
(51, '2023_01_09_113847_add_activity_to_ticket_hours_table', 1),
(52, '2023_01_12_203211_remove_unique_constraint_from_users', 1),
(53, '2023_01_12_204221_drop_attachments', 1),
(54, '2023_01_15_201358_add_type_to_projects', 1),
(55, '2023_01_15_202225_create_sprints_table', 1),
(56, '2023_01_15_204606_add_sprint_to_tickets', 1),
(57, '2023_01_15_214849_add_epic_to_sprints', 1),
(58, '2023_01_16_085329_add_started_ended_at_to_sprints', 1),
(59, '2023_01_24_084637_update_users_for_oidc', 1),
(60, '2023_04_10_123922_add_unique_ticket_prefix_to_projects_table', 1),
(61, '2023_12_04_999999_add_active_status_to_users', 2),
(62, '2023_12_04_999999_add_avatar_to_users', 2),
(63, '2023_12_04_999999_add_dark_mode_to_users', 2),
(64, '2023_12_04_999999_add_messenger_color_to_users', 2),
(65, '2023_12_04_999999_create_chatify_favorites_table', 2),
(66, '2023_12_04_999999_create_chatify_messages_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_user_emails`
--

CREATE TABLE `pending_user_emails` (
  `id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'List permissions', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(2, 'View permission', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(3, 'Create permission', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(4, 'Update permission', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(5, 'Delete permission', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(6, 'List projects', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(7, 'View project', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(8, 'Create project', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(9, 'Update project', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(10, 'Delete project', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(11, 'List project statuses', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(12, 'View project status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(13, 'Create project status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(14, 'Update project status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(15, 'Delete project status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(16, 'List roles', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(17, 'View role', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(18, 'Create role', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(19, 'Update role', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(20, 'Delete role', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(21, 'List tickets', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(22, 'View ticket', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(23, 'Create ticket', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(24, 'Update ticket', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(25, 'Delete ticket', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(26, 'List ticket priorities', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(27, 'View ticket priority', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(28, 'Create ticket priority', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(29, 'Update ticket priority', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(30, 'Delete ticket priority', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(31, 'List ticket statuses', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(32, 'View ticket status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(33, 'Create ticket status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(34, 'Update ticket status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(35, 'Delete ticket status', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(36, 'List ticket types', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(37, 'View ticket type', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(38, 'Create ticket type', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(39, 'Update ticket type', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(40, 'Delete ticket type', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(41, 'List users', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(42, 'View user', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(43, 'Create user', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(44, 'Update user', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(45, 'Delete user', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(46, 'List activities', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(47, 'View activity', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(48, 'Create activity', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(49, 'Update activity', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(50, 'Delete activity', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(51, 'List sprints', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(52, 'View sprint', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(53, 'Create sprint', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(54, 'Update sprint', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(55, 'Delete sprint', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(56, 'Manage general settings', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(57, 'Import from Jira', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(58, 'List timesheet data', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32'),
(59, 'View timesheet dashboard', 'web', '2023-12-04 12:53:32', '2023-12-04 12:53:32');

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

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `owner_id` bigint UNSIGNED NOT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ticket_prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kanban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_favorites`
--

CREATE TABLE `project_favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_statuses`
--

CREATE TABLE `project_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#cecece',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_users`
--

CREATE TABLE `project_users` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Default role', 'web', '2023-12-04 12:53:33', '2023-12-04 12:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `payload` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group`, `name`, `locked`, `payload`, `created_at`, `updated_at`) VALUES
(1, 'general', 'site_name', 0, '\"Project Terra: EPC Command Center\"', '2023-12-04 12:53:16', '2023-12-04 12:53:16'),
(2, 'general', 'site_logo', 0, 'null', '2023-12-04 12:53:16', '2023-12-04 12:53:16'),
(3, 'general', 'enable_registration', 0, 'true', '2023-12-04 12:53:16', '2023-12-04 12:53:16'),
(4, 'general', 'enable_social_login', 0, 'true', '2023-12-04 12:53:17', '2023-12-04 12:53:17'),
(5, 'general', 'default_role', 0, 'null', '2023-12-04 12:53:18', '2023-12-04 12:53:18'),
(6, 'general', 'enable_login_form', 0, 'true', '2023-12-04 12:53:18', '2023-12-04 12:53:18'),
(7, 'general', 'enable_oidc_login', 0, 'true', '2023-12-04 12:53:18', '2023-12-04 12:53:18'),
(8, 'general', 'site_language', 0, '\"en\"', '2023-12-04 12:53:18', '2023-12-04 12:53:18'),
(9, 'general', 'site_name', 0, '\"Project Terra: EPC Command Center\"', '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(10, 'general', 'enable_registration', 0, 'true', '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(11, 'general', 'site_logo', 0, 'null', '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(12, 'general', 'enable_social_login', 0, '\"1\"', '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(13, 'general', 'site_language', 0, '\"en\"', '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(14, 'general', 'default_role', 0, '\"1\"', '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(15, 'general', 'enable_login_form', 0, '\"1\"', '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(16, 'general', 'enable_oidc_login', 0, '\"1\"', '2023-12-04 12:53:33', '2023-12-04 12:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `socialite_users`
--

CREATE TABLE `socialite_users` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sprints`
--

CREATE TABLE `sprints` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_at` date NOT NULL,
  `ends_at` date NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `project_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `epic_id` bigint UNSIGNED DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` bigint UNSIGNED NOT NULL,
  `responsible_id` bigint UNSIGNED DEFAULT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint UNSIGNED NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `priority_id` bigint UNSIGNED NOT NULL,
  `estimation` double(8,2) DEFAULT NULL,
  `epic_id` bigint UNSIGNED DEFAULT NULL,
  `sprint_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_activities`
--

CREATE TABLE `ticket_activities` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `old_status_id` bigint UNSIGNED NOT NULL,
  `new_status_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_hours`
--

CREATE TABLE `ticket_hours` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `value` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `activity_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_priorities`
--

CREATE TABLE `ticket_priorities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#cecece',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_priorities`
--

INSERT INTO `ticket_priorities` (`id`, `name`, `color`, `is_default`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Low', '#008000', 0, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34'),
(2, 'Normal', '#CECECE', 1, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34'),
(3, 'High', '#ff0000', 0, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_relations`
--

CREATE TABLE `ticket_relations` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `relation_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_statuses`
--

CREATE TABLE `ticket_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#cecece',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `project_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_statuses`
--

INSERT INTO `ticket_statuses` (`id`, `name`, `color`, `is_default`, `deleted_at`, `created_at`, `updated_at`, `order`, `project_id`) VALUES
(1, 'Todo', '#cecece', 1, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34', 1, NULL),
(2, 'In progress', '#ff7f00', 0, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34', 2, NULL),
(3, 'Done', '#008000', 0, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34', 3, NULL),
(4, 'Archived', '#ff0000', 0, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_subscribers`
--

CREATE TABLE `ticket_subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE `ticket_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#cecece',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_types`
--

INSERT INTO `ticket_types` (`id`, `name`, `icon`, `color`, `is_default`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Task', 'heroicon-o-check-circle', '#00FFFF', 1, NULL, '2023-12-04 12:53:33', '2023-12-04 12:53:33'),
(2, 'Evolution', 'heroicon-o-clipboard-list', '#008000', 0, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34'),
(3, 'Bug', 'heroicon-o-x', '#ff0000', 0, NULL, '2023-12-04 12:53:34', '2023-12-04 12:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `creation_token` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'db',
  `oidc_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oidc_sub` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `creation_token`, `type`, `oidc_username`, `oidc_sub`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(1, 'Dejvi Uka', 'dejvi.uka@meh.al', '2023-12-04 12:53:32', '$2y$10$O.Vs0eNHdGQi6bUqeaqnOesin29GSDT04TfN4hJ9saqB/xmMCv/cO', NULL, NULL, NULL, NULL, '2023-12-04 12:53:32', '2023-12-04 12:53:32', NULL, NULL, 'db', NULL, NULL, 0, 'avatar.png', 0, NULL),
(2, 'Anxhel Mece', 'anxhel.mece@meh.al', '2023-12-04 12:53:32', '$2y$10$O.Vs0eNHdGQi6bUqeaqnOesin29GSDT04TfN4hJ9saqB/xmMCv/cO', NULL, NULL, NULL, NULL, '2023-12-04 13:06:59', '2023-12-04 13:06:59', NULL, NULL, 'db', NULL, NULL, 0, 'avatar.png', 0, NULL),
(3, 'Adi Gjordeni', 'adi.gjordeni@meh.al', '2023-12-04 12:53:32', '$2y$10$O.Vs0eNHdGQi6bUqeaqnOesin29GSDT04TfN4hJ9saqB/xmMCv/cO', NULL, NULL, NULL, NULL, '2023-12-04 13:07:20', '2023-12-04 13:07:20', NULL, NULL, 'db', NULL, NULL, 0, 'avatar.png', 0, NULL),
(4, 'Marsiona Stafa', 'marsiona.stafa@meh.al', '2023-12-04 12:53:32', '$2y$10$O.Vs0eNHdGQi6bUqeaqnOesin29GSDT04TfN4hJ9saqB/xmMCv/cO', NULL, NULL, NULL, NULL, '2023-12-04 13:07:45', '2023-12-04 13:07:45', NULL, NULL, 'db', NULL, NULL, 0, 'avatar.png', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_favorites`
--
ALTER TABLE `ch_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_messages`
--
ALTER TABLE `ch_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `epics`
--
ALTER TABLE `epics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `epics_project_id_foreign` (`project_id`),
  ADD KEY `epics_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pending_user_emails`
--
ALTER TABLE `pending_user_emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pending_user_emails_user_type_user_id_index` (`user_type`,`user_id`),
  ADD KEY `pending_user_emails_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_ticket_prefix_unique` (`ticket_prefix`),
  ADD KEY `projects_owner_id_foreign` (`owner_id`),
  ADD KEY `projects_status_id_foreign` (`status_id`);

--
-- Indexes for table `project_favorites`
--
ALTER TABLE `project_favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_favorites_user_id_foreign` (`user_id`),
  ADD KEY `project_favorites_project_id_foreign` (`project_id`);

--
-- Indexes for table `project_statuses`
--
ALTER TABLE `project_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_users`
--
ALTER TABLE `project_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_users_user_id_foreign` (`user_id`),
  ADD KEY `project_users_project_id_foreign` (`project_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_group_index` (`group`);

--
-- Indexes for table `socialite_users`
--
ALTER TABLE `socialite_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `socialite_users_provider_provider_id_unique` (`provider`,`provider_id`);

--
-- Indexes for table `sprints`
--
ALTER TABLE `sprints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sprints_project_id_foreign` (`project_id`),
  ADD KEY `sprints_epic_id_foreign` (`epic_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_owner_id_foreign` (`owner_id`),
  ADD KEY `tickets_responsible_id_foreign` (`responsible_id`),
  ADD KEY `tickets_status_id_foreign` (`status_id`),
  ADD KEY `tickets_project_id_foreign` (`project_id`),
  ADD KEY `tickets_type_id_foreign` (`type_id`),
  ADD KEY `tickets_priority_id_foreign` (`priority_id`),
  ADD KEY `tickets_epic_id_foreign` (`epic_id`),
  ADD KEY `tickets_sprint_id_foreign` (`sprint_id`);

--
-- Indexes for table `ticket_activities`
--
ALTER TABLE `ticket_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_activities_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_activities_old_status_id_foreign` (`old_status_id`),
  ADD KEY `ticket_activities_new_status_id_foreign` (`new_status_id`),
  ADD KEY `ticket_activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_comments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `ticket_hours`
--
ALTER TABLE `ticket_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_hours_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_hours_user_id_foreign` (`user_id`),
  ADD KEY `ticket_hours_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `ticket_priorities`
--
ALTER TABLE `ticket_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_relations`
--
ALTER TABLE `ticket_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_relations_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_relations_relation_id_foreign` (`relation_id`);

--
-- Indexes for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_statuses_project_id_foreign` (`project_id`);

--
-- Indexes for table `ticket_subscribers`
--
ALTER TABLE `ticket_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_subscribers_user_id_foreign` (`user_id`),
  ADD KEY `ticket_subscribers_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `epics`
--
ALTER TABLE `epics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `pending_user_emails`
--
ALTER TABLE `pending_user_emails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_favorites`
--
ALTER TABLE `project_favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_statuses`
--
ALTER TABLE `project_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_users`
--
ALTER TABLE `project_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `socialite_users`
--
ALTER TABLE `socialite_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sprints`
--
ALTER TABLE `sprints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_activities`
--
ALTER TABLE `ticket_activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_hours`
--
ALTER TABLE `ticket_hours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_priorities`
--
ALTER TABLE `ticket_priorities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_relations`
--
ALTER TABLE `ticket_relations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_subscribers`
--
ALTER TABLE `ticket_subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `epics`
--
ALTER TABLE `epics`
  ADD CONSTRAINT `epics_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `epics` (`id`),
  ADD CONSTRAINT `epics_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `projects_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `project_statuses` (`id`);

--
-- Constraints for table `project_favorites`
--
ALTER TABLE `project_favorites`
  ADD CONSTRAINT `project_favorites_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `project_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `project_users`
--
ALTER TABLE `project_users`
  ADD CONSTRAINT `project_users_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `project_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sprints`
--
ALTER TABLE `sprints`
  ADD CONSTRAINT `sprints_epic_id_foreign` FOREIGN KEY (`epic_id`) REFERENCES `epics` (`id`),
  ADD CONSTRAINT `sprints_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_epic_id_foreign` FOREIGN KEY (`epic_id`) REFERENCES `epics` (`id`),
  ADD CONSTRAINT `tickets_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `ticket_priorities` (`id`),
  ADD CONSTRAINT `tickets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `tickets_responsible_id_foreign` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_sprint_id_foreign` FOREIGN KEY (`sprint_id`) REFERENCES `sprints` (`id`),
  ADD CONSTRAINT `tickets_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `ticket_statuses` (`id`),
  ADD CONSTRAINT `tickets_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `ticket_types` (`id`);

--
-- Constraints for table `ticket_activities`
--
ALTER TABLE `ticket_activities`
  ADD CONSTRAINT `ticket_activities_new_status_id_foreign` FOREIGN KEY (`new_status_id`) REFERENCES `ticket_statuses` (`id`),
  ADD CONSTRAINT `ticket_activities_old_status_id_foreign` FOREIGN KEY (`old_status_id`) REFERENCES `ticket_statuses` (`id`),
  ADD CONSTRAINT `ticket_activities_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `ticket_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `ticket_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_hours`
--
ALTER TABLE `ticket_hours`
  ADD CONSTRAINT `ticket_hours_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `ticket_hours_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `ticket_hours_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_relations`
--
ALTER TABLE `ticket_relations`
  ADD CONSTRAINT `ticket_relations_relation_id_foreign` FOREIGN KEY (`relation_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `ticket_relations_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Constraints for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  ADD CONSTRAINT `ticket_statuses_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `ticket_subscribers`
--
ALTER TABLE `ticket_subscribers`
  ADD CONSTRAINT `ticket_subscribers_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `ticket_subscribers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
