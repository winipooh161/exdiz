-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 08 2024 г., 14:23
-- Версия сервера: 5.7.39
-- Версия PHP: 8.1.9
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- База данных: `express`
--
-- --------------------------------------------------------
--
-- Структура таблицы `commercials`
--
CREATE TABLE `commercials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_1_1` text COLLATE utf8mb4_unicode_ci,
  `question_1_2` text COLLATE utf8mb4_unicode_ci,
  `question_2_1` text COLLATE utf8mb4_unicode_ci,
  `question_2_2` text COLLATE utf8mb4_unicode_ci,
  `question_2_3` text COLLATE utf8mb4_unicode_ci,
  `question_2_4` text COLLATE utf8mb4_unicode_ci,
  `question_2_5` text COLLATE utf8mb4_unicode_ci,
  `question_2_6` text COLLATE utf8mb4_unicode_ci,
  `question_3_1` text COLLATE utf8mb4_unicode_ci,
  `question_3_2` text COLLATE utf8mb4_unicode_ci,
  `question_3_3` text COLLATE utf8mb4_unicode_ci,
  `question_3_4` text COLLATE utf8mb4_unicode_ci,
  `question_3_5` text COLLATE utf8mb4_unicode_ci,
  `question_3_6` text COLLATE utf8mb4_unicode_ci,
  `question_3_7` text COLLATE utf8mb4_unicode_ci,
  `question_3_8` text COLLATE utf8mb4_unicode_ci,
  `question_3_9` text COLLATE utf8mb4_unicode_ci,
  `question_3_10` text COLLATE utf8mb4_unicode_ci,
  `question_3_11` text COLLATE utf8mb4_unicode_ci,
  `question_3_12` text COLLATE utf8mb4_unicode_ci,
  `question_3_13` text COLLATE utf8mb4_unicode_ci,
  `question_4_1` text COLLATE utf8mb4_unicode_ci,
  `question_4_2` text COLLATE utf8mb4_unicode_ci,
  `question_4_3` text COLLATE utf8mb4_unicode_ci,
  `question_4_4` text COLLATE utf8mb4_unicode_ci,
  `question_4_5` text COLLATE utf8mb4_unicode_ci,
  `question_4_6` text COLLATE utf8mb4_unicode_ci,
  `question_5_1` text COLLATE utf8mb4_unicode_ci,
  `question_5_2` text COLLATE utf8mb4_unicode_ci,
  `question_5_3` text COLLATE utf8mb4_unicode_ci,
  `question_5_4` text COLLATE utf8mb4_unicode_ci,
  `question_5_5` text COLLATE utf8mb4_unicode_ci,
  `question_5_6` text COLLATE utf8mb4_unicode_ci,
  `question_5_7` text COLLATE utf8mb4_unicode_ci,
  `question_5_8` text COLLATE utf8mb4_unicode_ci,
  `question_5_9` text COLLATE utf8mb4_unicode_ci,
  `question_5_10` text COLLATE utf8mb4_unicode_ci,
  `question_5_11` text COLLATE utf8mb4_unicode_ci,
  `question_5_12` text COLLATE utf8mb4_unicode_ci,
  `question_5_13` text COLLATE utf8mb4_unicode_ci,
  `question_6_1` text COLLATE utf8mb4_unicode_ci,
  `question_6_2` text COLLATE utf8mb4_unicode_ci,
  `question_6_3` text COLLATE utf8mb4_unicode_ci,
  `question_6_4` text COLLATE utf8mb4_unicode_ci,
  `question_6_5` text COLLATE utf8mb4_unicode_ci,
  `question_6_6` text COLLATE utf8mb4_unicode_ci,
  `question_6_7` text COLLATE utf8mb4_unicode_ci,
  `question_6_8` text COLLATE utf8mb4_unicode_ci,
  `question_6_9` text COLLATE utf8mb4_unicode_ci,
  `question_6_10` text COLLATE utf8mb4_unicode_ci,
  `question_6_11` text COLLATE utf8mb4_unicode_ci,
  `question_6_12` text COLLATE utf8mb4_unicode_ci,
  `question_6_13` text COLLATE utf8mb4_unicode_ci,
  `question_7_1` text COLLATE utf8mb4_unicode_ci,
  `question_7_2` text COLLATE utf8mb4_unicode_ci,
  `question_7_3` text COLLATE utf8mb4_unicode_ci,
  `question_7_4` text COLLATE utf8mb4_unicode_ci,
  `question_7_5` text COLLATE utf8mb4_unicode_ci,
  `question_7_6` text COLLATE utf8mb4_unicode_ci,
  `question_7_7` text COLLATE utf8mb4_unicode_ci,
  `question_7_8` text COLLATE utf8mb4_unicode_ci,
  `question_7_9` text COLLATE utf8mb4_unicode_ci,
  `question_7_10` text COLLATE utf8mb4_unicode_ci,
  `question_7_11` text COLLATE utf8mb4_unicode_ci,
  `question_7_12` text COLLATE utf8mb4_unicode_ci,
  `question_7_13` text COLLATE utf8mb4_unicode_ci,
  `question_7_14` text COLLATE utf8mb4_unicode_ci,
  `question_7_15` text COLLATE utf8mb4_unicode_ci,
  `question_7_16` text COLLATE utf8mb4_unicode_ci,
  `question_7_17` text COLLATE utf8mb4_unicode_ci,
  `question_8_1` text COLLATE utf8mb4_unicode_ci,
  `question_8_2` text COLLATE utf8mb4_unicode_ci,
  `question_8_3` text COLLATE utf8mb4_unicode_ci,
  `question_8_4` text COLLATE utf8mb4_unicode_ci,
  `question_8_5` text COLLATE utf8mb4_unicode_ci,
  `question_8_6` text COLLATE utf8mb4_unicode_ci,
  `question_8_7` text COLLATE utf8mb4_unicode_ci,
  `question_8_8` text COLLATE utf8mb4_unicode_ci,
  `question_8_9` text COLLATE utf8mb4_unicode_ci,
  `question_8_10` text COLLATE utf8mb4_unicode_ci,
  `question_8_11` text COLLATE utf8mb4_unicode_ci,
  `question_8_12` text COLLATE utf8mb4_unicode_ci,
  `question_8_13` text COLLATE utf8mb4_unicode_ci,
  `question_8_14` text COLLATE utf8mb4_unicode_ci,
  `question_9_1` text COLLATE utf8mb4_unicode_ci,
  `question_9_2` text COLLATE utf8mb4_unicode_ci,
  `question_9_3` text COLLATE utf8mb4_unicode_ci,
  `question_9_4` text COLLATE utf8mb4_unicode_ci,
  `question_9_5` text COLLATE utf8mb4_unicode_ci,
  `question_9_6` text COLLATE utf8mb4_unicode_ci,
  `question_9_7` text COLLATE utf8mb4_unicode_ci,
  `question_9_8` text COLLATE utf8mb4_unicode_ci,
  `question_9_9` text COLLATE utf8mb4_unicode_ci,
  `question_9_10` text COLLATE utf8mb4_unicode_ci,
  `question_9_11` text COLLATE utf8mb4_unicode_ci,
  `question_9_12` text COLLATE utf8mb4_unicode_ci,
  `question_9_13` text COLLATE utf8mb4_unicode_ci,
  `question_9_14` text COLLATE utf8mb4_unicode_ci,
  `question_10_1` text COLLATE utf8mb4_unicode_ci,
  `question_10_2` text COLLATE utf8mb4_unicode_ci,
  `question_10_3` text COLLATE utf8mb4_unicode_ci,
  `question_10_4` text COLLATE utf8mb4_unicode_ci,
  `question_10_5` text COLLATE utf8mb4_unicode_ci,
  `question_10_6` text COLLATE utf8mb4_unicode_ci,
  `question_10_7` text COLLATE utf8mb4_unicode_ci,
  `question_10_8` text COLLATE utf8mb4_unicode_ci,
  `question_10_9` text COLLATE utf8mb4_unicode_ci,
  `question_10_10` text COLLATE utf8mb4_unicode_ci,
  `question_10_11` text COLLATE utf8mb4_unicode_ci,
  `question_10_12` text COLLATE utf8mb4_unicode_ci,
  `question_10_13` text COLLATE utf8mb4_unicode_ci,
  `question_10_14` text COLLATE utf8mb4_unicode_ci,
  `question_11_1` text COLLATE utf8mb4_unicode_ci,
  `question_11_2` text COLLATE utf8mb4_unicode_ci,
  `question_11_3` text COLLATE utf8mb4_unicode_ci,
  `question_11_4` text COLLATE utf8mb4_unicode_ci,
  `question_11_5` text COLLATE utf8mb4_unicode_ci,
  `question_11_6` text COLLATE utf8mb4_unicode_ci,
  `question_11_7` text COLLATE utf8mb4_unicode_ci,
  `question_11_8` text COLLATE utf8mb4_unicode_ci,
  `question_11_9` text COLLATE utf8mb4_unicode_ci,
  `question_11_10` text COLLATE utf8mb4_unicode_ci,
  `question_11_11` text COLLATE utf8mb4_unicode_ci,
  `question_11_12` text COLLATE utf8mb4_unicode_ci,
  `question_11_13` text COLLATE utf8mb4_unicode_ci,
  `question_12_1` text COLLATE utf8mb4_unicode_ci,
  `question_12_2` text COLLATE utf8mb4_unicode_ci,
  `question_12_3` text COLLATE utf8mb4_unicode_ci,
  `question_12_4` text COLLATE utf8mb4_unicode_ci,
  `question_12_5` text COLLATE utf8mb4_unicode_ci,
  `question_12_6` text COLLATE utf8mb4_unicode_ci,
  `question_12_7` text COLLATE utf8mb4_unicode_ci,
  `question_12_8` text COLLATE utf8mb4_unicode_ci,
  `question_12_9` text COLLATE utf8mb4_unicode_ci,
  `question_12_10` text COLLATE utf8mb4_unicode_ci,
  `question_12_11` text COLLATE utf8mb4_unicode_ci,
  `question_12_12` text COLLATE utf8mb4_unicode_ci,
  `question_12_13` text COLLATE utf8mb4_unicode_ci,
  `question_13_1` text COLLATE utf8mb4_unicode_ci,
  `question_13_2` text COLLATE utf8mb4_unicode_ci,
  `question_13_3` text COLLATE utf8mb4_unicode_ci,
  `question_13_4` text COLLATE utf8mb4_unicode_ci,
  `question_13_5` text COLLATE utf8mb4_unicode_ci,
  `question_13_6` text COLLATE utf8mb4_unicode_ci,
  `question_13_7` text COLLATE utf8mb4_unicode_ci,
  `question_13_8` text COLLATE utf8mb4_unicode_ci,
  `question_13_9` text COLLATE utf8mb4_unicode_ci,
  `question_13_10` text COLLATE utf8mb4_unicode_ci,
  `question_13_11` text COLLATE utf8mb4_unicode_ci,
  `question_13_12` text COLLATE utf8mb4_unicode_ci,
  `question_13_13` text COLLATE utf8mb4_unicode_ci,
  `question_14_1` text COLLATE utf8mb4_unicode_ci,
  `question_14_2` text COLLATE utf8mb4_unicode_ci,
  `question_14_3` text COLLATE utf8mb4_unicode_ci,
  `question_14_4` text COLLATE utf8mb4_unicode_ci,
  `question_14_5` text COLLATE utf8mb4_unicode_ci,
  `question_14_6` text COLLATE utf8mb4_unicode_ci,
  `question_14_7` text COLLATE utf8mb4_unicode_ci,
  `question_14_8` text COLLATE utf8mb4_unicode_ci,
  `question_14_9` text COLLATE utf8mb4_unicode_ci,
  `question_14_10` text COLLATE utf8mb4_unicode_ci,
  `question_14_11` text COLLATE utf8mb4_unicode_ci,
  `question_14_12` text COLLATE utf8mb4_unicode_ci,
  `question_14_13` text COLLATE utf8mb4_unicode_ci,
  `question_15_1` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `current_page` int(11) NOT NULL DEFAULT '1',
  `documents` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Дамп данных таблицы `commercials`
--
INSERT INTO `commercials` (`id`, `title`, `description`, `status`, `user_id`, `question_1_1`, `question_1_2`, `question_2_1`, `question_2_2`, `question_2_3`, `question_2_4`, `question_2_5`, `question_2_6`, `question_3_1`, `question_3_2`, `question_3_3`, `question_3_4`, `question_3_5`, `question_3_6`, `question_3_7`, `question_3_8`, `question_3_9`, `question_3_10`, `question_3_11`, `question_3_12`, `question_3_13`, `question_4_1`, `question_4_2`, `question_4_3`, `question_4_4`, `question_4_5`, `question_4_6`, `question_5_1`, `question_5_2`, `question_5_3`, `question_5_4`, `question_5_5`, `question_5_6`, `question_5_7`, `question_5_8`, `question_5_9`, `question_5_10`, `question_5_11`, `question_5_12`, `question_5_13`, `question_6_1`, `question_6_2`, `question_6_3`, `question_6_4`, `question_6_5`, `question_6_6`, `question_6_7`, `question_6_8`, `question_6_9`, `question_6_10`, `question_6_11`, `question_6_12`, `question_6_13`, `question_7_1`, `question_7_2`, `question_7_3`, `question_7_4`, `question_7_5`, `question_7_6`, `question_7_7`, `question_7_8`, `question_7_9`, `question_7_10`, `question_7_11`, `question_7_12`, `question_7_13`, `question_7_14`, `question_7_15`, `question_7_16`, `question_7_17`, `question_8_1`, `question_8_2`, `question_8_3`, `question_8_4`, `question_8_5`, `question_8_6`, `question_8_7`, `question_8_8`, `question_8_9`, `question_8_10`, `question_8_11`, `question_8_12`, `question_8_13`, `question_8_14`, `question_9_1`, `question_9_2`, `question_9_3`, `question_9_4`, `question_9_5`, `question_9_6`, `question_9_7`, `question_9_8`, `question_9_9`, `question_9_10`, `question_9_11`, `question_9_12`, `question_9_13`, `question_9_14`, `question_10_1`, `question_10_2`, `question_10_3`, `question_10_4`, `question_10_5`, `question_10_6`, `question_10_7`, `question_10_8`, `question_10_9`, `question_10_10`, `question_10_11`, `question_10_12`, `question_10_13`, `question_10_14`, `question_11_1`, `question_11_2`, `question_11_3`, `question_11_4`, `question_11_5`, `question_11_6`, `question_11_7`, `question_11_8`, `question_11_9`, `question_11_10`, `question_11_11`, `question_11_12`, `question_11_13`, `question_12_1`, `question_12_2`, `question_12_3`, `question_12_4`, `question_12_5`, `question_12_6`, `question_12_7`, `question_12_8`, `question_12_9`, `question_12_10`, `question_12_11`, `question_12_12`, `question_12_13`, `question_13_1`, `question_13_2`, `question_13_3`, `question_13_4`, `question_13_5`, `question_13_6`, `question_13_7`, `question_13_8`, `question_13_9`, `question_13_10`, `question_13_11`, `question_13_12`, `question_13_13`, `question_14_1`, `question_14_2`, `question_14_3`, `question_14_4`, `question_14_5`, `question_14_6`, `question_14_7`, `question_14_8`, `question_14_9`, `question_14_10`, `question_14_11`, `question_14_12`, `question_14_13`, `question_15_1`, `created_at`, `updated_at`, `current_page`, `documents`) VALUES
(13, 'Коммерческий бриф', 'active', 'inactive', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-07 11:40:55', '2024-12-07 11:41:05', 1, '[\"uploads/documents/user/2/brief/13/67545e8196090_ava.png\"]'),
(14, 'Коммерческий бриф', 'active', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-07 11:42:25', '2024-12-07 11:42:25', 1, NULL);
-- --------------------------------------------------------
--
-- Структура таблицы `commons`
--
CREATE TABLE `commons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_1_1` text COLLATE utf8mb4_unicode_ci,
  `question_1_2` text COLLATE utf8mb4_unicode_ci,
  `question_2_1` text COLLATE utf8mb4_unicode_ci,
  `question_2_2` text COLLATE utf8mb4_unicode_ci,
  `question_2_3` text COLLATE utf8mb4_unicode_ci,
  `question_2_4` text COLLATE utf8mb4_unicode_ci,
  `question_2_5` text COLLATE utf8mb4_unicode_ci,
  `question_2_6` text COLLATE utf8mb4_unicode_ci,
  `question_3_1` text COLLATE utf8mb4_unicode_ci,
  `question_3_2` text COLLATE utf8mb4_unicode_ci,
  `question_3_3` text COLLATE utf8mb4_unicode_ci,
  `question_3_4` text COLLATE utf8mb4_unicode_ci,
  `question_3_5` text COLLATE utf8mb4_unicode_ci,
  `question_3_6` text COLLATE utf8mb4_unicode_ci,
  `question_3_7` text COLLATE utf8mb4_unicode_ci,
  `question_3_8` text COLLATE utf8mb4_unicode_ci,
  `question_3_9` text COLLATE utf8mb4_unicode_ci,
  `question_3_10` text COLLATE utf8mb4_unicode_ci,
  `question_3_11` text COLLATE utf8mb4_unicode_ci,
  `question_3_12` text COLLATE utf8mb4_unicode_ci,
  `question_3_13` text COLLATE utf8mb4_unicode_ci,
  `question_4_1` text COLLATE utf8mb4_unicode_ci,
  `question_4_2` text COLLATE utf8mb4_unicode_ci,
  `question_4_3` text COLLATE utf8mb4_unicode_ci,
  `question_4_4` text COLLATE utf8mb4_unicode_ci,
  `question_4_5` text COLLATE utf8mb4_unicode_ci,
  `question_4_6` text COLLATE utf8mb4_unicode_ci,
  `question_5_1` text COLLATE utf8mb4_unicode_ci,
  `question_5_2` text COLLATE utf8mb4_unicode_ci,
  `question_5_3` text COLLATE utf8mb4_unicode_ci,
  `question_5_4` text COLLATE utf8mb4_unicode_ci,
  `question_5_5` text COLLATE utf8mb4_unicode_ci,
  `question_5_6` text COLLATE utf8mb4_unicode_ci,
  `question_5_7` text COLLATE utf8mb4_unicode_ci,
  `question_5_8` text COLLATE utf8mb4_unicode_ci,
  `question_5_9` text COLLATE utf8mb4_unicode_ci,
  `question_5_10` text COLLATE utf8mb4_unicode_ci,
  `question_5_11` text COLLATE utf8mb4_unicode_ci,
  `question_5_12` text COLLATE utf8mb4_unicode_ci,
  `question_5_13` text COLLATE utf8mb4_unicode_ci,
  `question_6_1` text COLLATE utf8mb4_unicode_ci,
  `question_6_2` text COLLATE utf8mb4_unicode_ci,
  `question_6_3` text COLLATE utf8mb4_unicode_ci,
  `question_6_4` text COLLATE utf8mb4_unicode_ci,
  `question_6_5` text COLLATE utf8mb4_unicode_ci,
  `question_6_6` text COLLATE utf8mb4_unicode_ci,
  `question_6_7` text COLLATE utf8mb4_unicode_ci,
  `question_6_8` text COLLATE utf8mb4_unicode_ci,
  `question_6_9` text COLLATE utf8mb4_unicode_ci,
  `question_6_10` text COLLATE utf8mb4_unicode_ci,
  `question_6_11` text COLLATE utf8mb4_unicode_ci,
  `question_6_12` text COLLATE utf8mb4_unicode_ci,
  `question_6_13` text COLLATE utf8mb4_unicode_ci,
  `question_7_1` text COLLATE utf8mb4_unicode_ci,
  `question_7_2` text COLLATE utf8mb4_unicode_ci,
  `question_7_3` text COLLATE utf8mb4_unicode_ci,
  `question_7_4` text COLLATE utf8mb4_unicode_ci,
  `question_7_5` text COLLATE utf8mb4_unicode_ci,
  `question_7_6` text COLLATE utf8mb4_unicode_ci,
  `question_7_7` text COLLATE utf8mb4_unicode_ci,
  `question_7_8` text COLLATE utf8mb4_unicode_ci,
  `question_7_9` text COLLATE utf8mb4_unicode_ci,
  `question_7_10` text COLLATE utf8mb4_unicode_ci,
  `question_7_11` text COLLATE utf8mb4_unicode_ci,
  `question_7_12` text COLLATE utf8mb4_unicode_ci,
  `question_7_13` text COLLATE utf8mb4_unicode_ci,
  `question_7_14` text COLLATE utf8mb4_unicode_ci,
  `question_7_15` text COLLATE utf8mb4_unicode_ci,
  `question_7_16` text COLLATE utf8mb4_unicode_ci,
  `question_7_17` text COLLATE utf8mb4_unicode_ci,
  `question_8_1` text COLLATE utf8mb4_unicode_ci,
  `question_8_2` text COLLATE utf8mb4_unicode_ci,
  `question_8_3` text COLLATE utf8mb4_unicode_ci,
  `question_8_4` text COLLATE utf8mb4_unicode_ci,
  `question_8_5` text COLLATE utf8mb4_unicode_ci,
  `question_8_6` text COLLATE utf8mb4_unicode_ci,
  `question_8_7` text COLLATE utf8mb4_unicode_ci,
  `question_8_8` text COLLATE utf8mb4_unicode_ci,
  `question_8_9` text COLLATE utf8mb4_unicode_ci,
  `question_8_10` text COLLATE utf8mb4_unicode_ci,
  `question_8_11` text COLLATE utf8mb4_unicode_ci,
  `question_8_12` text COLLATE utf8mb4_unicode_ci,
  `question_8_13` text COLLATE utf8mb4_unicode_ci,
  `question_8_14` text COLLATE utf8mb4_unicode_ci,
  `question_9_1` text COLLATE utf8mb4_unicode_ci,
  `question_9_2` text COLLATE utf8mb4_unicode_ci,
  `question_9_3` text COLLATE utf8mb4_unicode_ci,
  `question_9_4` text COLLATE utf8mb4_unicode_ci,
  `question_9_5` text COLLATE utf8mb4_unicode_ci,
  `question_9_6` text COLLATE utf8mb4_unicode_ci,
  `question_9_7` text COLLATE utf8mb4_unicode_ci,
  `question_9_8` text COLLATE utf8mb4_unicode_ci,
  `question_9_9` text COLLATE utf8mb4_unicode_ci,
  `question_9_10` text COLLATE utf8mb4_unicode_ci,
  `question_9_11` text COLLATE utf8mb4_unicode_ci,
  `question_9_12` text COLLATE utf8mb4_unicode_ci,
  `question_9_13` text COLLATE utf8mb4_unicode_ci,
  `question_9_14` text COLLATE utf8mb4_unicode_ci,
  `question_10_1` text COLLATE utf8mb4_unicode_ci,
  `question_10_2` text COLLATE utf8mb4_unicode_ci,
  `question_10_3` text COLLATE utf8mb4_unicode_ci,
  `question_10_4` text COLLATE utf8mb4_unicode_ci,
  `question_10_5` text COLLATE utf8mb4_unicode_ci,
  `question_10_6` text COLLATE utf8mb4_unicode_ci,
  `question_10_7` text COLLATE utf8mb4_unicode_ci,
  `question_10_8` text COLLATE utf8mb4_unicode_ci,
  `question_10_9` text COLLATE utf8mb4_unicode_ci,
  `question_10_10` text COLLATE utf8mb4_unicode_ci,
  `question_10_11` text COLLATE utf8mb4_unicode_ci,
  `question_10_12` text COLLATE utf8mb4_unicode_ci,
  `question_10_13` text COLLATE utf8mb4_unicode_ci,
  `question_10_14` text COLLATE utf8mb4_unicode_ci,
  `question_11_1` text COLLATE utf8mb4_unicode_ci,
  `question_11_2` text COLLATE utf8mb4_unicode_ci,
  `question_11_3` text COLLATE utf8mb4_unicode_ci,
  `question_11_4` text COLLATE utf8mb4_unicode_ci,
  `question_11_5` text COLLATE utf8mb4_unicode_ci,
  `question_11_6` text COLLATE utf8mb4_unicode_ci,
  `question_11_7` text COLLATE utf8mb4_unicode_ci,
  `question_11_8` text COLLATE utf8mb4_unicode_ci,
  `question_11_9` text COLLATE utf8mb4_unicode_ci,
  `question_11_10` text COLLATE utf8mb4_unicode_ci,
  `question_11_11` text COLLATE utf8mb4_unicode_ci,
  `question_11_12` text COLLATE utf8mb4_unicode_ci,
  `question_11_13` text COLLATE utf8mb4_unicode_ci,
  `question_12_1` text COLLATE utf8mb4_unicode_ci,
  `question_12_2` text COLLATE utf8mb4_unicode_ci,
  `question_12_3` text COLLATE utf8mb4_unicode_ci,
  `question_12_4` text COLLATE utf8mb4_unicode_ci,
  `question_12_5` text COLLATE utf8mb4_unicode_ci,
  `question_12_6` text COLLATE utf8mb4_unicode_ci,
  `question_12_7` text COLLATE utf8mb4_unicode_ci,
  `question_12_8` text COLLATE utf8mb4_unicode_ci,
  `question_12_9` text COLLATE utf8mb4_unicode_ci,
  `question_12_10` text COLLATE utf8mb4_unicode_ci,
  `question_12_11` text COLLATE utf8mb4_unicode_ci,
  `question_12_12` text COLLATE utf8mb4_unicode_ci,
  `question_12_13` text COLLATE utf8mb4_unicode_ci,
  `question_13_1` text COLLATE utf8mb4_unicode_ci,
  `question_13_2` text COLLATE utf8mb4_unicode_ci,
  `question_13_3` text COLLATE utf8mb4_unicode_ci,
  `question_13_4` text COLLATE utf8mb4_unicode_ci,
  `question_13_5` text COLLATE utf8mb4_unicode_ci,
  `question_13_6` text COLLATE utf8mb4_unicode_ci,
  `question_13_7` text COLLATE utf8mb4_unicode_ci,
  `question_13_8` text COLLATE utf8mb4_unicode_ci,
  `question_13_9` text COLLATE utf8mb4_unicode_ci,
  `question_13_10` text COLLATE utf8mb4_unicode_ci,
  `question_13_11` text COLLATE utf8mb4_unicode_ci,
  `question_13_12` text COLLATE utf8mb4_unicode_ci,
  `question_13_13` text COLLATE utf8mb4_unicode_ci,
  `question_14_1` text COLLATE utf8mb4_unicode_ci,
  `question_14_2` text COLLATE utf8mb4_unicode_ci,
  `question_14_3` text COLLATE utf8mb4_unicode_ci,
  `question_14_4` text COLLATE utf8mb4_unicode_ci,
  `question_14_5` text COLLATE utf8mb4_unicode_ci,
  `question_14_6` text COLLATE utf8mb4_unicode_ci,
  `question_14_7` text COLLATE utf8mb4_unicode_ci,
  `question_14_8` text COLLATE utf8mb4_unicode_ci,
  `question_14_9` text COLLATE utf8mb4_unicode_ci,
  `question_14_10` text COLLATE utf8mb4_unicode_ci,
  `question_14_11` text COLLATE utf8mb4_unicode_ci,
  `question_14_12` text COLLATE utf8mb4_unicode_ci,
  `question_14_13` text COLLATE utf8mb4_unicode_ci,
  `question_15_1` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `current_page` int(11) NOT NULL DEFAULT '1',
  `documents` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Дамп данных таблицы `commons`
--
INSERT INTO `commons` (`id`, `title`, `description`, `status`, `user_id`, `question_1_1`, `question_1_2`, `question_2_1`, `question_2_2`, `question_2_3`, `question_2_4`, `question_2_5`, `question_2_6`, `question_3_1`, `question_3_2`, `question_3_3`, `question_3_4`, `question_3_5`, `question_3_6`, `question_3_7`, `question_3_8`, `question_3_9`, `question_3_10`, `question_3_11`, `question_3_12`, `question_3_13`, `question_4_1`, `question_4_2`, `question_4_3`, `question_4_4`, `question_4_5`, `question_4_6`, `question_5_1`, `question_5_2`, `question_5_3`, `question_5_4`, `question_5_5`, `question_5_6`, `question_5_7`, `question_5_8`, `question_5_9`, `question_5_10`, `question_5_11`, `question_5_12`, `question_5_13`, `question_6_1`, `question_6_2`, `question_6_3`, `question_6_4`, `question_6_5`, `question_6_6`, `question_6_7`, `question_6_8`, `question_6_9`, `question_6_10`, `question_6_11`, `question_6_12`, `question_6_13`, `question_7_1`, `question_7_2`, `question_7_3`, `question_7_4`, `question_7_5`, `question_7_6`, `question_7_7`, `question_7_8`, `question_7_9`, `question_7_10`, `question_7_11`, `question_7_12`, `question_7_13`, `question_7_14`, `question_7_15`, `question_7_16`, `question_7_17`, `question_8_1`, `question_8_2`, `question_8_3`, `question_8_4`, `question_8_5`, `question_8_6`, `question_8_7`, `question_8_8`, `question_8_9`, `question_8_10`, `question_8_11`, `question_8_12`, `question_8_13`, `question_8_14`, `question_9_1`, `question_9_2`, `question_9_3`, `question_9_4`, `question_9_5`, `question_9_6`, `question_9_7`, `question_9_8`, `question_9_9`, `question_9_10`, `question_9_11`, `question_9_12`, `question_9_13`, `question_9_14`, `question_10_1`, `question_10_2`, `question_10_3`, `question_10_4`, `question_10_5`, `question_10_6`, `question_10_7`, `question_10_8`, `question_10_9`, `question_10_10`, `question_10_11`, `question_10_12`, `question_10_13`, `question_10_14`, `question_11_1`, `question_11_2`, `question_11_3`, `question_11_4`, `question_11_5`, `question_11_6`, `question_11_7`, `question_11_8`, `question_11_9`, `question_11_10`, `question_11_11`, `question_11_12`, `question_11_13`, `question_12_1`, `question_12_2`, `question_12_3`, `question_12_4`, `question_12_5`, `question_12_6`, `question_12_7`, `question_12_8`, `question_12_9`, `question_12_10`, `question_12_11`, `question_12_12`, `question_12_13`, `question_13_1`, `question_13_2`, `question_13_3`, `question_13_4`, `question_13_5`, `question_13_6`, `question_13_7`, `question_13_8`, `question_13_9`, `question_13_10`, `question_13_11`, `question_13_12`, `question_13_13`, `question_14_1`, `question_14_2`, `question_14_3`, `question_14_4`, `question_14_5`, `question_14_6`, `question_14_7`, `question_14_8`, `question_14_9`, `question_14_10`, `question_14_11`, `question_14_12`, `question_14_13`, `question_15_1`, `created_at`, `updated_at`, `current_page`, `documents`) VALUES
(13, 'Общий бриф', 'active', 'inactive', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-07 11:40:55', '2024-12-07 11:41:05', 1, '[\"uploads/documents/user/2/brief/13/67545e8196090_ava.png\"]'),
(14, 'Общий бриф', 'active', 'active', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-07 11:42:25', '2024-12-07 11:42:25', 1, NULL),
(15, 'Общий бриф', 'active', 'inactive', 2, '2', '2', '2', '2', '2', '2', '2', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12313', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123', '213', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123', '2024-12-08 07:26:14', '2024-12-08 07:34:10', 6, '[\"uploads/documents/user/2/brief/15/675576229ca35_ava.png\"]');
-- --------------------------------------------------------
--
-- Структура таблицы `documents`
--
CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Структура таблицы `failed_jobs`
--
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Структура таблицы `migrations`
--
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Дамп данных таблицы `migrations`
--
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 2),
(6, '2024_12_05_113212_add_phone_to_users_table', 2),
(7, '2024_12_06_112452_create_brifs_table', 3),
(8, '2024_12_06_112834_add_user_id_to_brifs_table', 4),
(9, '2024_12_06_175324_add_current_page_to_brifs_table', 5),
(10, '2024_12_07_133254_create_documents_table', 6),
(11, '2024_12_07_140245_add_documents_to_brifs_table', 7),
(12, '2024_12_07_150601_add_verification_code_to_users_table', 8);
-- --------------------------------------------------------
--
-- Структура таблицы `news`
--
CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `time` date DEFAULT NULL,
  `user_img` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `liks` int(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `content_txt` text,
  `content_big_txt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content_url` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Дамп данных таблицы `news`
--
INSERT INTO `news` (`id`, `time`, `user_img`, `title`, `liks`, `username`, `content_txt`, `content_big_txt`, `content_url`, `type`) VALUES
(1, '2019-07-20', 'assets/img/logo/logo-mini.svg', 'с Днем рождения!', 223, 'Дизайн', 'Сегодня мы хотим поздравить основателя компании Экспресс Дизайн с Днем рождения! Счастья, здоровья и исполнения всех мечтаний.', '', 'assets/img/img5.jpg', 'article'),
(2, '2023-09-22', 'assets/img/logo/logo-mini.svg', 'МЫ НЕ ОНИ', 613, 'Дизайн', 'Экспресс-дизайн это НЕ Express Ellis Design. Всё чаще и больше людей путают нашу компанию.  Читайте статью о нас в <a href=\"https://dzen.ru/expressdiz\" tabindex=\"0\">ДЗЕН</a>', '', 'assets/img/img2.jpg', 'article'),
(3, '2023-06-01', 'assets/img/logo/logo-red.svg', 'НОВЫЕ ЦЕНЫ', 175, 'Франшиза', 'Сегодня мы изменили наполняемость наших услуг и ценообразование. При заказе проектов уточняйте всю информацию у своего менеджера!', '', NULL, 'article'),
(89, '2023-05-09', 'assets/img/logo/logo-red.svg', '9 МАЯ', 990, 'Франшиза', 'Команда Экспресс Дизайна поздравляет с Днем Победы! Пусть мирное небо над головой, тепло в сердце и уверенность в завтрашнем дне будут всегда с вами.', '', 'assets/img/img4.jpg', 'article'),
(90, '2023-05-04', 'assets/img/logo/logo-red.svg', 'БЕСПЛАТНЫЙ ВЕБИНАР', 572, 'Франшиза', 'Бесплатный вебинар по франшизе: ответы на множество вопросов! Узнали все о возможностях и преимуществах франшизного бизнеса онлайн.', '', 'assets/img/img7.jpg', 'article'),
(91, '2023-04-06', 'assets/img/logo/logo-mini.svg', 'ВЫПУСТИЛИ КАТАЛОГ', 349, 'Дизайн', 'Мы закончили работу над собственным каталогом. Подготовили много экспертности, магазинов, поставщиков. Покупайте каталог у наших менеджеров.', '', NULL, 'article'),
(92, '2023-03-17', 'assets/img/logo/logo-mini.svg', 'УСЛУГА ЗАКУПКИ', 751, 'Дизайн', 'Мы запустили свой сервис по закупке и доставке материалов на объект. В данный момент сервис работает не во всех городах. Подробности уточняйте у менеджера', '', NULL, 'article'),
(93, '2023-02-13', 'assets/img/logo/logo-mini.svg', 'ПРОЕКТЫ УДАЛЕННО', 48, 'Дизайн', 'Подготовили статью на само часто задаваемые вопросы. Переходите в яндекс дзен и получите о нас еще больше информации.', '', NULL, 'article'),
(94, '2023-02-06', 'assets/img/logo/logo-mini.svg', 'РАССРОЧКА', 531, 'Дизайн', 'Теперь экспресс дизайн-проект возможно купить в рассрочку. Мы запустили партнёрскую программу с 10 крупными банками.', '', 'assets/img/img3.jpg', 'article'),
(95, '2023-02-01', 'assets/img/logo/logo-black.jpeg', 'СКИДКА 15%', 923, 'Ремонт', 'Предъявите билет на этот фильм с его премьеры 23 декабря 2022 года и до окончания показа его в кино - получите нашу скидку 15%.', '', NULL, 'article'),
(96, '2023-01-25', 'assets/img/logo/logo-mini.svg', 'О НАС', 982, 'Дизайн', 'Подготовили для вас статью о нашей студии дизайна. Хотите заказать проект, но есть сомнения? Статья поможет сделать верный выбор.', '', NULL, 'article'),
(169, '2023-09-15', 'assets/img/logo/logo-red.svg', 'ПОЧЕМУ У МЕНЯ ПОЛУЧИЛОСЬ?!', 53, 'Франшиза', 'Доброго времени суток, друзья!?<br>На связи Никита Анненков, и я рад приветствовать вас на странице моей компании.<br>', 'Многие задаются вопросом о том, как я смог добиться таких высоких показателей. И сегодня я готов вам ответить и рассказать, какой была моя мотивация!\',’ Никому не секрет, что в наши дни компания, входящая в список 100 самых инновационных студий дизайна, привлекает большое внимание. И я горжусь тем, что моя компания является единственной в стране, предоставляющей полный спектр услуг в данной ценовой категории, уже на протяжении 4 лет.<br>\n⠀\nМногие мне повторяли, что это невозможно, и наверное, они были частично правы - это было сложно.<br>\n⠀\nКогда я основывал Экспресс Дизайн, мой главный интерес заключался в том, чтобы каждый в нашей стране мог позволить себе создать уникальный дизайн-проект. Поэтому ЦЕНА стала ключевым элементом в этой большой цепи!<br>‘, \'\n⠀\nТолько представьте себе, благодаря нашей большой команде, мы создаем полные проекты за всего 700 рублей, тогда как на рынке аналогичные услуги продаются от 3000 рублей за 1 квадратный метр!<br>\n⠀\nПри этом мы сохраняем высокое качество проектов и делаем их еще более функциональными и понятными – не только для наших клиентов, но и для строителей!<br>\n⠀\nНам удалось воплотить мой социальный проект, и теперь независимо от финансового положения каждый может создать стильный ремонт, сохранив все тренды, что особенно важно, сэкономить сотни тысяч рублей на ремонте с нашей помощью!<br>\n⠀\nА вы давно узнали о нас? Расскажите, пожалуйста, как именно вы о нас услышали, ведь для меня это особенно важно знать\n', '', 'article'),
(185, '2023-08-19', 'assets/img/logo/logo-red.svg', 'Немного юмора', 694, 'Франшиза', NULL, '', 'assets/media/2023-08-19.mp4', 'storis'),
(186, '2023-08-14', 'assets/img/logo/logo-mini.svg', 'Новое сторис', 947, 'Дизайн', NULL, '', 'assets/media/2023-08-14.mp4', 'storis'),
(187, '2023-08-20', 'assets/img/logo/logo-red.svg', 'Новое сторис', 605, 'Франшиза', NULL, '', 'assets/media/2023-08-20.mp4', 'storis'),
(188, '2023-08-21', 'assets/img/logo/logo-mini.svg', 'Новое сторис', 109, 'Дизайн', NULL, '', 'assets/media/2023-08-21.mp4', 'storis'),
(189, '2023-08-22', 'assets/img/logo/logo-red.svg', 'Новое сторис', 977, 'Франшиза', NULL, '', 'assets/media/2023-08-22.mp4', 'storis'),
(190, '2023-09-02', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 617, 'Ремонт', NULL, '', 'assets/media/2023-09-02.mp4', 'storis'),
(191, '2023-09-07', 'assets/img/logo/logo-red.svg', 'Новое сторис', 636, 'Франшиза', NULL, '', 'assets/media/2023-09-07.mp4', 'storis'),
(192, '2023-09-09', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 620, 'Ремонт', NULL, '', 'assets/media/2023-09-09.mp4', 'storis'),
(193, '2023-09-10', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 924, 'Ремонт', NULL, '', 'assets/media/2023-09-10.mp4', 'storis'),
(194, '2023-09-11', 'assets/img/logo/logo-red.svg', 'Новое сторис', 619, 'Франшиза', NULL, '', 'assets/media/2023-09-11.mp4', 'storis'),
(195, '2023-09-12', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 631, 'Ремонт', NULL, '', 'assets/media/2023-09-12.mp4', 'storis'),
(196, '2023-09-13', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 973, 'Ремонт', NULL, '', 'assets/media/2023-09-13.mp4', 'storis'),
(197, '2023-08-14', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 746, 'Ремонт', NULL, '', 'assets/media/2023-08-14.mp4', 'storis'),
(199, '2023-09-15', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 979, 'Ремонт', NULL, '', 'assets/media/2023-09-15.mp4', 'storis'),
(200, '2023-09-16', 'assets/img/logo/logo-red.svg', 'Новое сторис', 266, 'Франшиза', NULL, '', 'assets/media/2023-09-16.mp4', 'storis'),
(201, '2023-09-17', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 639, 'Ремонт', NULL, '', 'assets/media/2023-09-17.mp4', 'storis'),
(202, '2023-09-19', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 355, 'Ремонт', NULL, '', 'assets/media/2023-09-19.mp4', 'storis'),
(203, '2023-09-20', 'assets/img/logo/logo-black.jpeg', 'Новое сторис', 724, 'Ремонт', NULL, '', 'assets/media/2023-09-20.mp4', 'storis'),
(204, '2023-09-22', 'assets/img/logo/logo-red.svg', 'Новое сторис', 676, 'Франшиза', 'Смотрите наши видео и набирайтесь вдохновением на новые свершения. Каждое утро новое сторис и новое вдохновение!', '', 'assets/media/2023-09-22.mp4', 'storis'),
(205, '2023-09-21', 'assets/img/logo/logo-mini.svg', 'Новое сторис', 819, 'Ремонт', NULL, '', 'assets/media/2023-09-21.mp4', 'storis'),
(206, '2021-05-13', 'assets/img/logo/logo-black.jpeg', '3D проект для дома', 617, 'Ремонт', 'Продолжаем делится с Вами нашими работами. ', 'Работы здесь было очень много - дом 170 кв.м \r\n<br>\r\nГлавной задачей было составить дизайн в стиле Минимализм.\r\n<br>\r\nВ данном видео - мы показали 3D визуализацию на весь дом\r\n<br>\r\nОцените нашу работу от 0 до 10 баллов\r\n<br>\r\n____\r\n<br>\r\nНужен дизайн в очень быстрые сроки?\r\n⠀<br>\r\n Пишите в direct или по ссылке в шапке профиля\r\n⠀<br>\r\nРазработаем и реализуем любые ваши идеи в дизайне интерьера', 'assets/media/13.05.2021video.mp4', 'video'),
(207, '2021-05-12', 'assets/img/logo/logo-black.jpeg', 'Минимализм в 360°', 877, 'Ремонт', '360° для гостиной с кухней', 'Клиент получил стилистические коллажи и решил, что хочет ещё увидеть - как все это будет выглядеть ?<br>\r\n\r\nА мы поработали и получилась - вот такая красота. \r\n<br>\r\nСрок исполнения всего 5 дней и по стоимости вышло 9800₽. \r\n<br>\r\nОсталось сделать комплектацию и можно начинать ремонт. ?\r\n<br>\r\nДавайте, оценим работу от 1 до 10??\r\n<br>\r\n____\r\n⠀<br>\r\nНужен дизайн в очень быстрые сроки?\r\n⠀<br>\r\n\r\n⠀\r\n✍️ Пишите в direct или по ссылке в шапке профиля<br>\r\n\r\n⠀\r\nРазработаем и реализуем любые ваши идеи в дизайне интерьера?', 'assets/media/12.05.21video.mp4', 'video'),
(241, '2023-10-27', 'assets/img/logo/logo-mini.svg', 'Три этапа контроля вашего проекта', 512, 'Дизайн', 'Многие клиенты удивляются скорости реализации проекта и его цене. Некоторые думают, что наши проекты делают студенты, или вовсе мы уже выдаем готовые решения.', '<br>И это? только малая часть того, что мы слышим на предложение сделать заказ проекта у нас.<br>⠀<br>Мы уже выпустили много рубрик на эту тему, статей и постов, где говорим, почему это не так, и сейчас затронем тему контроля: \"почему у нас получается делать крутые проекты за такие сроки и такую сумму\".<br>⠀<br>Первый этап контроля:<br>Робот, или, как сейчас принято говорить, искусственный интеллект. Программа, которая помогает контролировать все этапы работы, своевременно информировать всех участников чата, следит за сроками и удовлетворением заказчика.<br>⠀<br>Второй этап:<br>Координатор, куратор - специально обученный человек, который следит за исполнением ТЗ, помогает в коммуникации заказчику и исполнителю. Данный сотрудник всегда оперативно ответит на ваш вопрос или решит поставленную задачу.<br>⠀<br>Третий этап:<br>Главный Дизайнер и Архитектор проекта. Прежде чем проект попадает к заказчику, его проверяют на соответствие всех норм, требований, эргономики пространства и уникальности дизайна.<br>⠀<br>Многие из вас уже видели процесс работы изнутри на нашем мероприятии «Дне открытых дверей» - согласитесь, такого нет ни в одной студии в рамках такого бюджета. Мнение клиента и заказчика, а также его настроение всегда на первом месте!', 'assets/media/IMG_20231027_184100_295.jpg', 'article'),
(243, '2023-10-31', 'assets/img/logo/logo-mini.svg', 'Дарим Экспресс Дизайн Проект', 713, 'Дизайн', 'Друзья, на странице в одной из наших социальных сетей🤫 проходит розыгрыш услуг Экспресс Дизайн.<br>⠀<br>❗Главный приз - Полный Экспресс Дизайн! 💯.', '', 'assets/media/IMG_20231030_180032.jpg', 'article'),
(244, '2023-11-02', 'assets/img/logo/logo-mini.svg', 'Защита интересов!', 278, 'Дизайн', 'С каждым днём мы испытываем все больше давления от студий Дизайна на нашем просторе услуг. Связано это с нашими ценностями, резкими взглядами и смелыми решениями.', 'Все кричат: \"Демпинг! Вы ломаете структуру, обесцениваете работу других студий Дизайна, не даёте зарабатывать и создаёте трудности!\" ⠀ Поступают письма с требованиями и угрозами, шантаж и даже предложения о покупки нашей студии крупным девелопером страны. ⠀ Объяснение одно: если мы создаём такой резонанс, значит, наш подход актуален рынку, люди прекрасно понимают, что лучше  заплатить 80.000₽ и получить проект за месяц, чем заплатить 300.000₽ и ждать свой проект около 6 месяцев. ⠀ Раньше говорили дёшево - значит некачественно, но за 4 года приходит осознание того, что цена на качество не влияет! ⠀ Мы просто изменили подход и сделали так, чтобы Вы не платили деньги за \"воздушное\" время. Мы точно знаем сколько было потрачено часов на то или иное действие - так рассчитывается стоимость услуг. ⠀ ❗Для наших завистников следующая информация: Давайте дружить и сотрудничать! Заказывайте у нас проекты для клиентов под своим брендом, как это делают уже десятки студий. Мы не конкуренты и не враги! Мы самое крупное и сильное производство ДИЗАЙН-ПРОЕКТОВ с ИНДИВИДУАЛЬНЫМ подходом.', 'assets/media/IMG_20231102_071452_011.jpg', 'article'),
(245, '2023-11-03', 'assets/img/logo/logo-mini.svg', 'КАК СОЧЕТАТЬ ЦВЕТА В ИНТЕРЬЕРЕ?', 277, 'Дизайн', 'Масштабный ремонт или небольшая «прокачка» интерьера — и в том и в другом случае важно правильно подобрать цвета, которые будут радовать глаз и гармонично сочетаться между собой.', ' Как это сделать, сегодня расскажет наш ведущий Дизайнер Инна Волощук.<br>⠀<br>Колористика интерьера прямо сказывается на нашем настроении, поведении, самочувствии. Перебор с красным может привести к дискомфорту, зеленые тона умиротворяют, а розовый или белый гармонизируют настроение. Синий цвет оказывает положительное влияние на здоровье, оранжевый может добавить смелости, энтузиазма и стимулировать аппетит.<br>⠀<br>Цвета задают атмосферу в помещении и помогают выразить индивидуальность владельца. Так что выбор палитры обоев, мебели, текстиля для комнаты или всего дома — довольно ответственная задача.<br>⠀<br>Цвета делятся на три главных вида:?<br>⠀<br>✔ Основные - это красный, синий и желтый.<br>Эти цвета нельзя получить при смешивании других.<br>⠀<br>✔ Вторичные - оранжевый, фиолетовый и зеленый. Получаются путем смешивания основных цветов.<br>⠀<br>✔ Третичные - шесть оттенков, которые получают путем смешивания первичных и вторичных цветов.<br>⠀<br>Боясь ошибиться с цветом, многие выбирают нейтральное решение — бежевый и его оттенки.<br>⠀<br>Но именно бежевый требует продуманного и бережного отношения: без должных акцентов и интересных сочетаний комната в бежевых тонах рискует выглядеть скучной и безликой.<br>⠀<br>В этом году большинство компаний-трендсеттеров делают ставку на приглушенные палитры и пастельные оттенки. Также в центре внимания теплые коричневые, яркие и сочные сине-голубые, красно-розовые оттенки. Особенно хороша широкая гамма зеленых оттенков: травяной, изумрудный, бутылочный зеленый и даже яркий лайм.', 'assets/media/IMG_20231103_224434_429.jpg', 'article'),
(246, '2023-11-04', 'assets/img/logo/logo-mini.svg', 'МЫ НА СВЯЗИ 24/7', 554, 'Дизайн', 'Вечер субботы, а впереди еще 2 выходных!<br><br>Значит, настало время расслабиться, насладиться выходными и зарядиться новой энергией!', 'Напоминаем: наши менеджеры ВСЕГДА НА СВЯЗИ и готовы помочь вам решить любые задачи 24/7. <br><br>Отправляем вам виртуальное обнимашки и желаем прекрасных выходных! ??', 'assets/media/IMG_20231104_233711_235.jpg', 'article'),
(247, '2023-11-07', 'assets/img/logo/logo-mini.svg', 'НАШИ СЕМЕЙНЫЕ ЦЕННОСТИ', 257, 'Дизайн', 'Когда мы говорим о дизайне интерьера, мы часто обращаем внимание на цвета, материалы и мебель. Но мало кто задумывается о том, как наш дом может отражать наши семейные ценности и влиять на наших детей.', '<br>⠀<br>Дизайн интерьера может помочь нам укрепить связь с нашими близкими и создать атмосферу, которая будет способствовать развитию и росту наших детей. Вот несколько идей, как это можно сделать:<br>⠀<br>Создайте уютное место для семейных мероприятий. Независимо от того, чем вы любите заниматься, важно создать место, где вы можете проводить время вместе. Может быть, это будет уютный уголок для чтения книг, большой обеденный стол для семейных обедов или красивый огонь в камине для вечерних посиделок.<br>⠀<br>? Сделайте детскую комнату вдохновляющей. Для детей важно иметь свое пространство, где они могут играть, учиться и расти. Создайте детскую комнату, которая будет вдохновлять их на творчество и развитие. Можете использовать яркие цвета, наклейки на стенах или даже создать уголок для чтения и учебы.<br>⠀<br>?? Оставьте место для фотографий семьи. Наша семья - это то, что дает нам силы и вдохновение. Создайте место, где можно повесить фотографии своей семьи и вспоминать самые яркие моменты. Это может быть отдельная стена или просто рамки на полке.<br>⠀<br>? Подумайте о символах, которые важны для вашей семьи. Может быть, ваша семья любит путешествовать или у вас есть общие увлечения. Рассмотрите возможность добавить символы, которые отражают ваши семейные ценности и увлечения в дизайн интерьера.<br>⠀<br>Дизайн интерьера - это не просто украшение нашего дома. Это способ выразить наши семейные ценности и создать атмосферу, которая будет способствовать развитию и росту наших детей.', 'assets/media/IMG_20231107_234234_070.jpg', 'article'),
(248, '2023-11-09', 'assets/img/logo/logo-mini.svg', 'Команда это?!', 561, 'Дизайн', 'Многих удивляет формат удаленной работы.', ' Как можно содержать и следить за командой где трудятся далеко даже не 100 человек?<br><br>В конце 2019 года нас всех ждала неприятная новость, в принудительном порядке нужно было подстраиваться под требования нашего правительства. Мы распустили штат, закрыли офисы и начали совершено другой формат ведения бизнеса и построения online студии дизайна.<br><br>Что нужно понимать в первую очередь, что бы следить за таким количеством людей в нашей компании? Мы разработали собственную CRM-систему и интегрировали ее с бизнес процессами в Bitrix24. Написано более 10.000 протоколов и сценарий для оптимизации всех рабочих процессов.<br><br>Когда мы делаем вам дизайн проект, кто уже пользовался нашими услугами, замечал сколько людей появляется в чате, за каждым из них следит робот, который контролирует сроки и удовлетворенность клиента. И в случае нарушения протокола он незамедлительно оповещает руководителей и ответственных за ваш проект.<br><br>Мы давно уже перешли в эпоху 21 века, мир не стоит на месте, искусственный интеллект оживляет фотографии, поэтому не стоит бояться удаленной работы, стоит бояться попасть к не профессионалу.<br><br>Мы гарантируем качество и сервис на самом высоком уровне!', 'assets/media/IMG_20231109_090142_744.jpg', 'article'),
(249, '2023-11-13', 'assets/img/logo/logo-mini.svg', 'Зачем нужны чертежи?', 491, 'Дизайн', 'Казалось бы все просто: зачем нужны эти чертежи, если можно сделать все просто и без них. Но на деле все выглядит иначе...', '<br>⠀<br>Банальная история?<br>⠀<br>К нам обратилась клиентка на zoom-консультацию с вопросом: \"Какого размера должна быть ниша?\". Ни строители, ни дизайнер интерьера, который разрабатывал для нее дизайн проект, не могли ответить на вопрос и сказали: \"Решайте сами\".?<br>⠀<br>Для нас сложно представить, как обыватель может знать ответы на такие вопросы.<br>⠀<br>Мы объяснили: стандартная ниша – 2 м. 10 см, но ее можно сделать нестандартного размера, при этом каждые 10 см это плюс 20% к стоимости ниши.<br>Конкретно в ее случае оптимально бы выглядела ниша размером 2 м 30 см, но это плюс 40% к стоимости. Мы рассказали об этом и предоставили выбор.<br>⠀<br>Этот пример - яркая демонстрация того, почему чертежи и размеры важны, без них не только строители не смогут выполнить свою работу качественно, но и высока вероятность того, что увеличение запланированного бюджета будет неизбежным.<br>⠀<br>Специалист ПОНИМАЕТ значение эргономики в дизайн проекте. И прежде чем приступить к работе над проектом, он узнает о привычках, образе жизни, характере и физиологических особенностях владельцев.<br>⠀<br>Согласитесь, что комфорт проживания имеет такое же значение, как и внешняя красота интерьера?!', 'assets/media/IMG_20231113_111805_898.jpg', 'article'),
(250, '2023-11-14', 'assets/img/logo/logo-mini.svg', 'СРОКИ ИЗГОТОВЛЕНИЯ 3D-ВИЗУАЛИЗАЦИИ', 32, 'Дизайн', 'Хотим поднять важную тему о сроках выполнения дизайн-проектов! ⠀ Очень много раз мы сталкивались с заказчиками, которые не могут поверить, что разработка проекта для двухкомнатной квартиры займет около месяца?', 'Они смеются, возмущаются, как будто услышали что-то абсурдное! Примерно так: \"Это же просто двухкомнатная квартира, ребята!\" ⠀ История, которую мы расскажем, подтверждает наше наблюдение. Недавно один клиент обратился к нам за проектом двушки с 3D- визуализацией. Но когда дизайнер сказал ему, что срок выполнения проекта составит до 25 дней, он воскликнул: \"А я  за 5 месяцев с коллегами разработал проект большого дома! Как вы можете заниматься столько времени всего лишь двушкой?\" ⠀ Мы привели аргументы о том, что дизайн-проект интерьера с визуализацией отличается от проектной документации, но всё было напрасно. ⠀ Важно понимать, что подготовка обмерочного плана, планировочного решения, рабочих чертежей и развёрток стен, конечно, занимает время, но не столько, сколько визуализация в трёхмерной графике. Один рендер одного ракурса помещения выполняется целые сутки! А у нас обычно делают 2-3 ракурса на каждое помещение. Считайте сами! Даже в стандартной двушке есть 5-6 помещений. Умножим это на 2-3 ракурса и получаем примерно две недели времени только на визуализацию! ⠀ Как ни странно, многие думают, что можно просто так взять и сделать дизайн-проект за одну неделю! Если бы это было так легко и быстро, студии дизайна не брали бы по 2000-3000 рублей за 1 квадратный метр! К слову, у нас средняя цена метра - от 700 рублей! За полный проект, за максимальный пакет! ⠀ Поэтому давайте говорить и понимать друг друга. Качественный дизайн-проект требует времени и усилий. Поверьте нам, мы делаем все возможное, чтобы превратить вашу квартиру в настоящий мир мечты!', 'assets/media/H07A9237.jpg', 'article'),
(251, '2023-11-20', 'assets/img/logo/logo-mini.svg', 'ПСИХОЛОГИЯ ДИЗАЙНА', 682, 'Дизайн', 'Как интерьер влияет на человека?<br>⠀<br>Место, где мы живем, влияет на наше настроение и самочувствие. В своем доме мы должны чувствовать себя комфортно, тепло и безопасно.', '<br>⠀<br>И мы задали вопрос Никите Анненкову, основателю студии «Экспресс Дизайна» эксперта в области дизайна и ремонта с 10 летним опытом: \"На какие факторы необходимо обратить внимание при планировании пространства, чтобы интерьер гармонизировал психологическое состояние и дом стал тем местом, куда хочется возвращаться?\"<br>⠀<br>При создании проекта наша команда старается в первую очередь отразить индивидуальность заказчика, его характер и мировоззрение, создать стильное и красивое пространство, в котором человеку будет комфортно.<br>⠀<br>Часто люди при выборе квартиры или дома ориентируются лишь на количество квадратных метров.  Но мы точно можем сказать: дизайн помещения, декор и цветовая гамма имеют огромное значение для психологического состояния и здоровья его обитателей.<br>⠀<br>Оформление интерьера может как вдохновлять человека, подпитывать его энергией, так и угнетать.<br>⠀<br>Слова немецкого дизайнера Инго Маурера: «Плохой свет делает человека несчастным» — неоднократно подтверждались учеными разных стран.<br>⠀<br>Обустраивая жилье, следует грамотно продумать функциональность каждого помещения и отдельных элементов. Эргономика - правильно спланированное пространство сэкономит ваши нервные клетки.?<br>⠀<br>Мы с командой изучаем внутреннюю психологию дизайна, к каждому клиенту подходим индивидуально, порой можем показаться занудными задавая множество вопросов, но именно такой подход нам помогает передать все, что хотел увидеть клиент в правильной обертке!', 'assets/media/IMG_20231120_173819_556.jpg', 'article'),
(254, '2023-11-23', 'assets/img/logo/logo-mini.svg', 'Ваша обратная связь', 900, 'Видео', '', '', 'assets/media/0231123143524.mp4', 'video'),
(256, '2023-11-23', 'assets/img/logo/logo-mini.svg', 'Природа', 635, 'Дизайн', 'Природные материалы, такие как дерево и зелень, являются ключевыми элементами в создании теплой и уютной атмосферы в комнате.', ' Деревянные отделки и мебель придают естественную красоту и легкость интерьеру, а зелень, будь то живые или искусственные растения, добавляет природный шарм и освежает воздух.<br><br>Сегодня мы с удовольствием показали вам визуализацию комнаты на третьем этаже таунхауса, созданные нашим визуализатором Юлианой Корниенко.<br><br>Наши заказчики предоставили нам техническое задание, в котором особое внимание было уделено природе. Они действительно обожают окружающую природу, и Юлиана сделала все возможное, чтобы передать эту любовь в наших визуализациях.<br><br>Мы с гордостью заявляем, что наша команда смогла превзойти ожидания заказчиков и создать действительно крутой проект.<br><br>Естественно, получившиеся результаты заказчики оценили на 10 баллов!', 'assets/media/IMG_20231123_144810.jpg', 'article'),
(257, '2023-11-24', 'assets/img/logo/logo-mini.svg', 'ЧЁРНАЯ ПЯТНИЦА', 454, 'Дизайн', 'Вы думали, что мы забыли?!<br>Конечно, нет! Знали бы вы, сколько сообщений мы получили за эту неделю с распродажами.', '<br>⠀<br>Поэтому мы приготовили для вас следующие скидки:<br>⠀<br>- При заказе любого проекта СЕГОДНЯ вы получаете скидку 30% (при 100% предоплате).<br>⠀<br>- В эти выходные (25.11-26.11) можно получить скидку 20% при 100% предоплате.<br>⠀<br>- А до КОНЦА ноября действует скидка 10% на все проекты (при 100% предоплате).<br>⠀<br>Внимание! Скидка не распространяется на замеры, ремонт, авторский и технический надзор.', 'assets/media/H07A9495.jpg', 'article'),
(258, '2023-11-28', 'assets/img/logo/logo-mini.svg', 'КРАСОТА И СТИЛЬ ДИЗАЙНЕРА', 0, 'Дизайн', 'Вы когда-нибудь задумывались, почему многие дизайнеры интерьера такие красивые и стильные?', 'Почему все они выглядят как на подбор модельной внешности? Это не просто так!<br>⠀<br>Дизайн интерьера - это не только профессия, но и искусство. И, как и в любом искусстве, важно уметь не только создавать красивые объекты, но и представлять себя в соответствующем свете.<br>⠀<br>Дизайнеры знают, что их работа - это не только создание красивых и удобных пространств, но и продвижение своей личности как бренда.<br>⠀<br>В компании Экспресс Дизайн большинство дизайнеров работают удаленно, но наши дизайнеры всегда доступны для оффлайн общения.<br>⠀<br>Поэтому они следят за своей внешностью и стильными образами, чтобы привлекать внимание к своей персоне и своим работам. Они должны быть примером для своих клиентов и давать им ощущение, что они работают с действительно профессионалами.<br>⠀<br>Конечно, это не значит, что все дизайнеры должны быть красивыми моделями. Но на опыте мы знаем, что это так и есть.', 'assets/media/IMG_20231129_000800_681.jpg', 'article'),
(259, '2023-12-04', 'assets/img/logo/logo-mini.svg', 'ТОП-5 трендов в дизайне интерьера этой зимой', 0, 'Дизайн', 'Сегодня хотим поделиться с вами самыми горячими трендами в дизайне интерьера этого сезона.<br><br>1. Натуральные материалы:<br>В этом сезоне природность и органичность - на пике популярности.', ' Люди все больше и больше стремятся к близости с природой. Дерево, камень, мрамор, ротанг и другие натуральные материалы становятся основой современного интерьера. Добавьте их в декор своего дома и вы прочувствуете гармонию и тепло, которые приносит природа.<br><br>2. Яркие и смелые цветовые решения:<br>Серые стены ушли в прошлое! В этом сезоне мы видим много смелых и насыщенных цветов, таких как синий, зеленый, розовый. Создайте яркое пятно на вашей стене, добавьте яркие акценты мебели или просто используйте яркие аксессуары, чтобы добавить в ваш интерьер яркости и энергии.<br><br>3. Максимализм:<br>Минимализм долго был в моде, но сейчас на смену ему приходит максимализм. Забудьте о пустоте и стерильности - наполните ваш дом предметами и вещами, которые отражают вашу индивидуальность. Эклектические смешения стилей, большие и яркие обои, уникальные арт-объекты - все это создаст неповторимый стиль вашего дома.<br><br>4. Природные мотивы:<br>Флора и фауна - основные источники вдохновения для дизайнеров этого сезона. Используйте обои с цветущими растениями, добавьте подушки с птицами или органические формы в мебели. Ваши стены станут живыми, а душа будет наслаждаться присутствием природы даже в городском интерьере.<br><br>5. Технологические инновации:<br>Современный дизайн не может обойтись без технологий. Интерактивные светильники, умные устройства для дома, интеллектуальные системы автоматизации - все это теперь неотъемлемая часть современного интерьера. Интегрируйте технологии в свой дом, чтобы сделать его более комфортным и функциональным.<br><br>Помните, что самое главное ваша индивидуальность и желание создать неповторимый дом, в котором вам будет комфортно и радостно. Наши дизайнеры вам обязательно в этом помогут!', '', 'article'),
(260, '2023-12-08', 'assets/img/logo/logo-mini.svg', '4 ВАЖНЫХ ФАКТОРА О НАШЕЙ КОМПАНИИ', 2, 'Дизайн', 'Это нужно знать при принятии решения о сотрудничестве с нами:', 'Фактор №1:<br>Гарантия, репутация, качество!<br>За 4 года работы мы применили более 100 разных подходов по реализации проектов, на сегодняшний день наше исполнение - это не просто кабинет, где трудится два человека, а целая команда, где только исполнителей более 700 человек.<br>Все процессы работы автоматизированы, более 50 человек отвечает за ваш проект.<br>⠀<br>Фактор №2:<br>Индивидуальность, сроки, скорость!<br>В месяц по всей России наша студия выдает от 250 готовых дизайн проектов!<br>Это огромная цифра, которая подверждена в наших социальных сетях, где мы ведем отрытый образ нашей деятельности!<br>Как вы думаете, если бы у нас были типовые проекты или очень низкого качества, заявили бы об этом наши клиенты за 4 года?! Конечно ДА, но такого НЕТ и не будет! Все проекты мы делаем индивидуально и не повторяем<br>⠀<br>Фактор №3:<br>Цена!!!<br>Самое больное, что может быть это цена. Никогда даже подумать не могли, что дав возможность купить проект у нас со скидкой до 70% ниже рынка (а именно от 700 рублей за кв. м.) мы получим такую волну отказов и недопонимания!<br>Друзья, мы единственная студия, кто может себе позволить работать по такой стоимости, не потому что у нас тут что-то не так с проектами, сроками, и качеством! Все потому что мы  производим большие объемы, и система работы мотивации для наших исполнителей как в Европе. Поверьте они вам делают проект за такую же заработную плату, как там, где вы покупаете проект за 3000 кв. м.<br>⠀<br>И самый главный 4 фактор:<br>За 4 года мы полностью ломаем стереотипы о цене, сроках! Мы доказали это на 4500 проектов, что это возможно и это работает! Хватит думать! Мы знаем и умеем экономить деньги наших клиентов от разработки дизайн проекта до ремонта.', 'assets/media/H07A6757.jpg', 'article'),
(261, '2023-12-14', 'assets/img/logo/logo-mini.svg', 'Зачем нужна 3D-визуализация', 0, 'Дизайн', 'Благодаря ей владельцы квартиры или дома могут оценить проект в реалистичной обстановке, видя комнаты именно так, как они будут выглядеть после окончания ремонта на объекте.', '<br><br>3D-визуализация помогает подкорректировать оттенки, расположение мебели, выбрать более подходящие к дизайн-проекту аксессуары. Она реально показывает все плюсы и минусы разных типов планировочных решений и помогает точно понять, что вам понравится больше.<br><br>О том, почему не стоит отказываться от 3D-визуализации на этапе формирования интерьера?  Помогает ли это исключать ошибки?  Да, помогает. На этапе проектирования в пространство помещений вписываются определенные предметы интерьера и декор. Очень важно учесть габариты и грамотно и эргономично вписать детали. Плоскостные чертежи в отличие от 3D часто не позволяют почувствовать истинный масштаб мебели.<br><br>Экономическая выгода в том, что клиент не покупает ничего лишнего, а значит, не ошибается: нет возвратов и обменов.<br>Проект можно подогнать под бюджет!<br><br>Полный проект с 3D-визуализацией за 39.900₽ сможет сэкономить ваш бюджет в десятикратном размере!<br><br>Решать, конечно, вам. Что лучше: купить проект за 39.900₽ или переплатить 390.000₽ (при закупках в \"слепую\")?<br><br>А что выбираете вы???!', '', 'article'),
(262, '2023-12-23', 'assets/img/logo/logo-mini.svg', 'Наша география', 2, 'Дизайн', 'Мы не просто так заговорили про нашу географию.<br>⠀<br>Ежедневно мы расширяемся и выходим на рынки новых городов.', '<br>⠀<br>За последние несколько месяцев этого года у нас появились новые партнёры в Казани, Калининграде, Нижнем Новгороде и Петрозаводске.<br>⠀<br>Мы адаптируем наши услуги под спрос наших клиентов.<br>⠀<br>Изучив каждый регион отдельно, мы подбираем услуги в том или ином ценовом сегменте для наших будущих клиентов.<br>⠀<br>Наша миссия - сделать дизайн-проекты ДОСТУПНЫМИ для всех.<br>⠀<br>Благодаря нашей партнерской программе у наших клиентов есть возможность НЕ ПРОСТО УДАЛЕННО воспользоваться нашими услугами, но и заказать выезд нашего представителя на объект, получить консультацию на месте, замеры помещений, комплектацию и даже РЕМОНТ (по окончании реализации вашего дизайн-проекта).<br>⠀<br>Сегодня Экспресс-Дизайн - это не просто студия дизайна, а студия полного комплекса предоставления услуг от А до Я по доступным ценам не теряя качество.', 'assets/media/IMG_20231223_222121_144.jpg', 'article'),
(263, '2023-12-28', 'assets/img/logo/logo-mini.svg', 'Новогодний вечер компании Экспресс Дизайн', 1, 'Дизайн', 'Предновогодний вечер в дружной и теплой атмосфере, где руководители отделов компании и самые преданные сотрудники, у которых была возможность приехать в Москву - собрались вместе, чтобы подвести итоги уходящего года.', '<br>Даже в условиях удаленной работы мы не упускаем возможность провести этот особенный вечер в Москве.<br>⠀<br>Мы дали отдышаться и насладиться непринужденной атмосферой, провели награждение наших лучших сотрудников, которые превзошли все ожидания. Этот вечер стал настоящим праздником, полным веселья и незабываемых впечатлений.<br>⠀<br>Но это еще не все!<br>⠀<br>Мы готовы поделиться с вами нашими эксклюзивными знаниями и накопленным опытом в области дизайна интерьера. Проведение этого мероприятия позволяет нам еще глубже понять желания и потребности наших клиентов, и создать для вас пространство, которое будет вдохновлять и радовать каждый день.', 'assets/media/1163.jpg', 'article'),
(264, '2024-01-05', 'assets/img/logo/logo-mini.svg', 'Знаете ли вы, что каждый новый проект является своего рода маленькой жизнью?', 3, 'Дизайн', 'Это может показаться неочевидным многим, однако наша команда дизайнеров тщательно осознает этот факт.', ' В течение 30 дней работы над проектом они погружаются в эту маленькую жизнь, взаимодействуют и общаются с клиентом.<br>⠀<br>Сегодня мы хотим рассказать вам об особой истории создания одного проекта. Всё началось с тестового задания клиента для наших партнёров из Екатеринбурга: создать визуализации гостиной, которая включала в себя огромную библиотеку.<br>⠀<br>Когда клиент оценил гостиную на 10 баллов, он заказал полный экспресс  проект своего пентхауса площадью около 200 кв.м.<br>⠀<br>Мы гордимся результатом и несколько визуализаций вы можете посмотреть в наших социальных сетях. Проект ещё не завершён, поэтому чуть позже мы обязательно поделимся с вами результатами.<br>⠀<br>В техническом задании клиент подчеркнул, что необходимо избежать привязки к определённому стилю, использовать много камня и создать атмосферу комфорта и уюта.<br>⠀<br>Наши коллеги действительно вкладывали все свои силы в проект. Они стремились воплотить свои идеи и концепции в реальность. Клиент всегда был на связи, подробно описывал свои предпочтения, а дизайнеры внимательно обдумывали все детали.<br>⠀<br>Мы считаем, что детали имеют большое значение, и уверены, что вы сможете оценить нашу работу так же высоко, как и мы.', 'assets/media/Screenshot_2024-01-06-03-27-37-690_com.lemon.lvoverseas-edit.jpg', 'article'),
(265, '2024-01-09', 'assets/img/logo/logo-mini.svg', 'Врываемся в рабочие будни!', 4, 'Дизайн', 'Наступили рабочие будни, но у нас они превращаются в настоящие творческие подвиги! 😊 Мы с превеликим удовольствием предлагаем вам наши услуги по созданию ЭКСПРЕСС ДИЗАЙН ПРОЕКТОВ ИНТЕРЬЕРА.', '<br> <br>Мы заботимся о каждой детали и стремимся сделать ваш дом неповторимым и запоминающимся.<br>Оставьте заявку прямо сейчас, и мы с радостью поможем вам воплотить в жизнь самые смелые идеи!<br> <br>Не упустите возможность получить профессиональный дизайн от наших экспертов по выгодной цене.', 'assets/media/7267.jpg', 'article'),
(266, '2024-01-26', 'assets/img/logo/logo-mini.svg', 'Праздники закончились, но наши творческие возможности только начинают расцветать!', 0, 'Дизайн', 'Если вы в поисках интересных решений для вашего дома, офиса или коммерческого помещения, то студия Экспресс Дизайн с радостью поможет вам воплотить все ваши идеи.', '<br>⠀<br>Независимо от размера проекта, мы гарантируем высокое качество работы и индивидуальный подход к каждому клиенту.<br>⠀<br>Мы специализируемся на различных видах дизайна интерьера, начиная от элегантного классического стиля до смелых современных решений. Наши дизайнеры внимательно выслушают ваши предпочтения и вдохновятся вашими новогодними образами, чтобы создать дизайн, который впишется в вашу жизнь и придется вам по вкусу.<br>⠀<br>И еще раскроем тайну нашей низкой цены - она формируется в зависимости от спроса на наши услуги, а также благодаря удаленному формату работы и большому объему заказов. Это позволяет нам предложить цены до 70% ниже, чем у других студий.', 'assets/media/2.jpg', 'article'),
(267, '2024-01-30', 'assets/img/logo/logo-mini.svg', 'Внимание всем многодетным семьям!', 3, 'Дизайн', 'Президент нашей страны подписал Указ от 23.01.2024 № 63 \"О мерах социальной поддержки многодетных семей\" и компания Экспресс Дизайн с гордостью поддерживает эту инициативу.', '<br>⠀<br>Мы рады объявить вам о специальном предложении от нашей студии! Если у вас в семье трое и более детей в возрасте до 18 лет, то теперь вы имеете право на эксклюзивную скидку до 15% на все наши услуги!<br>⠀<br>Нам очень важно, чтобы вы чувствовали себя особенными, поэтому мы стремимся сделать ваше обращение в студию ещё более выгодным.<br>⠀<br>Чтобы воспользоваться скидкой, просто предоставьте нам свидетельство о рождении ваших детей.☺<br>⠀<br>Мы предлагаем вам воспользоваться этим уникальным предложением. Не упустите шанс получить особое внимание и заботу от нашей студии. Мы ценим каждого нашего клиента и стремимся создать для вас дизайн вашей мечты.', 'assets/media/6916.jpg', 'article'),
(268, '2024-02-05', 'assets/img/logo/logo-mini.svg', 'Товарный знак!', 2, 'Дизайн', 'Товарный знак — это обозначение, которое индивидуализирует бренд и выделяет его среди множества других предложений на рынке.', '<br>⠀<br>Кто следит за развитием нашей студии, знает, что с 2022 года мы неоднократно пытались зарегистрировать товарный знак. И в 2023 году нам пришлось полностью изменить изображение нашего логотипа, так как прежний не проходил экспертизу, и нам отказывали в регистрации.<br>⠀<br>И вот, два года стараний, и этот год мы открыли хорошими новостями! Теперь у нас есть собственный товарный знак, а значит, дальше студию ждут глобальные перемены, конечно же, в лучшую сторону!<br>⠀<br>Впереди нас ждет открытие собственных шоурумов, внедрение современных технологий, доработка мобильного приложения, личного кабинета клиента и еще много-много всего!<br>⠀<br>Все наши услуги имеют уникальность, у нас нет типовых решений, теперь задача — сделать наш товарный знак не просто логотипом, а знаком качества в области дизайна и архитектуры! Пусть наша эмблема \"Э\" будет служить как эталон качества!', 'assets/media/3452.jpg', 'article'),
(269, '2024-02-13', 'assets/img/logo/logo-mini.svg', 'Для чего нужен дизайн-проект?', 1, 'Дизайн', 'Вы наверняка задавались вопросом, зачем тратить время и ресурсы на создание дизайн-проекта для своего жилища или рабочего пространства.', ' Но сегодня мы хотим поделиться с вами несколькими причинами, почему дизайн проект является неотъемлемой частью успешной реализации вашей мечты!<br>⠀<br>1. Индивидуальность: Каждый из нас уникален, и ваш интерьер должен отражать именно вас. Дизайнер поможет превратить ваши предпочтения в реальность, создавая уникальное пространство, которое полностью отвечает вашим потребностям и стилю жизни.<br>⠀<br>2. Оптимизация пространства: Хороший дизайн не только красив, но и функционален. Он помогает использовать доступное пространство наилучшим образом, обеспечивает удобство и эргономику. От максимальной рациональности до создания уютных уголков для отдыха - дизайн проект поможет воплотить ваши идеи в реальность.<br>⠀<br>3. Атмосфера и настроение: Интерьер оказывает непосредственное влияние на нас, формируя настроение и эмоции. С помощью дизайна, вы можете создать гармоничную и уютную атмосферу, которая поможет вам расслабиться, вдохновиться или сосредоточиться - в зависимости от задач, которые вы перед собой ставите.<br>⠀<br>4. Увеличение стоимости объекта: Дизайн проект не только приносит комфорт и удовлетворение, но и является инвестицией в ваше имущество. Качественный и продуманный дизайн повышает стоимость недвижимости и делает ее более привлекательной для потенциальных покупателей или арендаторов.<br>⠀<br>От профессионального дизайна зависит гармония и функциональность вашего жилья или рабочего пространства. Наша команда опытных дизайнеров всегда готова помочь вам воплотить ваши самые смелые идеи в жизнь, чтобы каждый элемент в интерьере подчеркивал ваш стиль и индивидуальность.<br>⠀<br>Кроме того, цены студии Экспресс Дизайн на 70% ниже, чем у других студий дизайна. Мы стремимся сделать процесс получения качественного дизайн-проекта доступным для всех, без ущерба для его качества и оригинальности.', 'assets/media/IMG_20240213_132401_164.jpg', 'article'),
(270, '2024-03-05', 'assets/img/logo/logo-mini.svg', 'Рады поделиться с вами потрясающими новостями!', 1, 'Дизайн', 'На прошлой неделе наша команда Экспресс Дизайн собралась в городе Екатеринбурге на очередной встрече партнеров.<br>⠀<br>Это было очень продуктивное событие, на котором мы обсудили ряд захватывающих тем.', ' Встреча позволила нам обменяться новыми идеями, воплотить самые смелые творческие концепции в реальность и найти вдохновение для будущих проектов.<br>⠀<br>Кроме того, тема продаж и маркетинга была проработана до мелочей. Мы обсудили эффективные стратегии привлечения клиентов, разделили опыт успеха и провалившихся кампаний, чтобы каждый из нас стал настоящим экспертом в своей области. ?<br>⠀<br>Но встреча партнеров - это не только работа, но и отличная возможность провести время в дружеской и приятной атмосфере. Во время перерыва на кофе мы наслаждались общением, посмеялись и окунулись в весёлые истории.', 'assets/media/IMG_20240305_145213_063.jpg', 'article'),
(271, '2024-03-06', 'assets/img/logo/logo-mini.svg', 'Ремонт интерьера – это важный этап в жизни каждого дома.', 3, 'Дизайн', 'Многие задаются вопросом о том, когда наиболее подходящее время для проведения ремонтных работ.', ' В студии интерьеров Экспресс-Дизайн мы подвели статистику и хотим поделиться с вами нашими рекомендациями:<br>⠀<br>Во-первых, намного проще и удобнее делать ремонт, когда погода благоприятна. Поэтому мы рекомендуем планировать ремонт на весну или лето. В это время года можно открыть окна и проветрить помещение, быстрее высохнут краски и клеи. Кроме того, весной часто проводятся распродажи строительных материалов и мебели, что позволит вам сэкономить на ремонте.<br>⠀<br>Осенью также можно проводить ремонтные работы. Высокие температуры и низкая влажность создают идеальные условия для покраски, шпаклевки и других работ. Осень – время перемен, и что может быть лучше, чем преобразить свой интерьер и создать уютную атмосферу перед наступлением холодных зимних дней?<br>⠀<br>Зима – не самый благоприятный сезон для ремонта. Низкие температуры и высокая влажность могут затруднить проведение работ. Однако, если у вас срочная необходимость в ремонте и вы готовы принять эти условия, наша студия всегда готова предоставить вам профессиональную помощь.<br>⠀<br>Кроме сезона, необходимо учитывать и другие факторы. Например, стоит учитывать свои планы и график работы.<br>⠀<br>В студии интерьеров Экспресс Дизайн мы всегда готовы вам помочь с планированием и реализацией ремонта. Наша команда профессионалов знает, как создать гармоничное и функциональное пространство, которое будет отвечать вашим потребностям и желаниям.<br>⠀<br>Не откладывайте свои мечты о идеальном интерьере на потом. Обратитесь в студию интерьеров Экспресс Дизайн и воплотите их в реальность уже сегодня!', 'assets/media/photo_2024-03-07_14-31-31.jpg', 'article'),
(272, '2024-03-08', 'assets/img/logo/logo-mini.svg', 'Дорогие девушки!', 2, 'Дизайн', 'Сердечно поздравляю Вас с праздником весны - 8 Марта!', 'Этот день наполнен радостью, теплом и вниманием ко всем Вам, прекрасным и неповторимым представительницам женского пола!<br>⠀<br>От лица всей команды студии Экспресс Дизайн хочу пожелать вам быть всегда окруженными заботой и вниманием близких, чтобы каждый день был для вас наполнен счастьем и улыбками.<br>⠀<br>Пусть в ваши жизни приносятся только яркие и радостные моменты, а ваши творческие идеи с легкостью превращаются в потрясающие проекты.<br>⠀<br>Пусть ваша уникальность и талант вселяют в вас уверенность и приносят особенные успехи. Не забывайте ценить себя и свою работу, ведь каждая из вас - настоящая гениальная личность, способная творить чудеса!<br>⠀<br>Пусть этот замечательный праздник будет днем радости, веселья и приятных сюрпризов. Счастья вам, удачи и любви! Пусть ваши дни будут полны красоты и вдохновения!<br>⠀<br>С теплыми пожеланиями,<br>Никита Анненков,<br>директор студии Экспресс Дизайн.', 'assets/media/H07A6188.jpg', 'article'),
(273, '2024-03-12', 'assets/img/logo/logo-mini.svg', 'Зачем нужен дизайн-проект?', 2, 'Дизайн', 'Дизайн интерьера играет ключевую роль в том, как мы воспринимаем и чувствуем пространство, в котором мы живем, работаем и проводим свое время.', ' Эстетика интерьера влияет на наше настроение, комфорт и продуктивность. Вот почему дизайн интерьера является необходимым инструментом для создания гармоничной и функциональной обстановки.<br>⠀<br>Когда вы доверяете свое пространство профессионалам, каждая деталь задумывается с учетом вашего стиля, потребностей и предпочтений. Дизайнеры помогут создать уникальное и уютное пространство, отражающее вашу индивидуальность и вкус.<br>⠀<br>Кроме того, дизайн интерьера способствует оптимизации использования пространства и повышению его функциональности. Грамотно спланированный интерьер позволяет оптимально распределить зоны и максимально использовать каждый квадратный метр.<br>⠀<br>Наконец, хороший дизайн интерьера повышает стоимость недвижимости. Красиво оформленный дом или офис привлекает внимание покупателей и арендаторов, что является важным фактором при продаже или сдаче недвижимости.<br>⠀<br>Таким образом, дизайн интерьера не только придает красоту и стиль вашему пространству, но и повышает ваше благополучие, комфорт и удовлетворение от жизни. Обратитесь в студию Экспресс Дизайн, и мы поможем воплотить ваши мечты в реальность!', 'assets/media/H07A9521.jpg', 'article'),
(274, '2024-03-16', 'assets/img/logo/logo-mini.svg', 'Продолжаем знакомить вас с нашими франчайзи по всей России.', 2, 'Дизайн', 'Недавно состоялась встреча в Омске, где собрались наши франчайзи на встречу, в рамках которой прошли обучения в сфере наших услуг.', '<br>⠀<br>Наши Франчайзи активно развивают Экспресс Дизайн у себя в регионе, дают возможность каждому клиенту узнать про нашу студию и воспользоваться услугами по доступней цене. Помогают не только разработать дизайн-проект, но и провести отделочные работы, помочь с закупками.<br>⠀<br>Такого рода встречи проходят в теплой семейной обстановке, где разбираются вопросы развития, ставится задачи по достижению плановых показателей, проходят обучения по продажам и многое дорогое.<br>⠀<br>На нашем сайте вы можете найти еще больше информации в разделе партнеры.', 'assets/media/IMG_20240316_161613_579.jpg', 'article'),
(275, '2024-03-26', 'assets/img/logo/logo-mini.svg', 'Экспресс Дизайн - это?!', 0, 'Дизайн', 'Всем привет, меня зовут Никита Анненков, я генеральный директор и основатель федеральной сети студий дизайна и ремонта.', '<br>⠀<br>Хочу рассказать, что через пару месяцев грядут большие изменения, наших клиентов ждут новые услуги и не только!<br>⠀<br>Кто смотрел мое последнее интервью, уже знает, что с 1 мая мы начинаем открывать шоурумы в городах России - это пилотная версия нашего нового проекта, где теперь наши клиенты смогут получать полный комплекс услуг от одного бренда, а также окунуться в мир современных технологий.<br>⠀<br>Пока предлагаю поговорить о том, каких совершенств мы добились сейчас и что такое Экспресс Дизайн.<br>⠀<br>Мы продолжаем проходить этот сложный путь, выстраивая не просто выгодный сервис и услуги, но и скорость - сохранив качество.<br>⠀<br>Каждый месяц мы просто вынуждены вносить обновление в отдел исполнение, автоматизировать и усовершенствовать все технологические процессы.<br>⠀<br>Наш отдел исполнения, я сравниваю с дуговой сталеплавильной печкой, если остановить процесс реализации проектов, я даже боюсь представить, как быстро могут застыть все механизмы и восстановление или запуск может занять очень большие инвестиции и время, которое будет исчисляться месяцами.<br>⠀<br>5 лет мы оказываем услуги в области дизайна-интерьера, в доступности 8 услуг под любую задачу нашего клиента.<br>⠀<br>В 2024 году компания интегрирует два направления в основные услуги студии, это снабжение/закупки и ремонт под ключ с полным сопровождением.<br>⠀<br>Те, кто давно следит за нами, знает, что каждый год, мы презентуем новые решения компании. Очень много партнерских программ реализовано на сегодняшний день, каждый месяц происходит интеграция разных поставщиков и сервисов.<br>⠀<br>И так, Экспресс Дизайн, это:<br>• самый доступный сервис по получению услуги в области дизайна и архитектуры;<br>• скорость реализации проектов без потери качества;<br>• цена на 70% ниже рынка;<br>• гарантия сервиса!<br>⠀<br>Остались вопросы или есть замечания? На сайте в разделе контакты, есть мой личный WhatsApp, обязательно сообщите мне!<br>⠀<br>Р. S. Не люблю фото в костюмах, поэтому специально для вас поехал в горы и прихватил флаг! Спасибо, что выбрали мою студию - Экспресс Дизайн!', 'assets/media/IMG_20240326_150958_931.jpg', 'article');
INSERT INTO `news` (`id`, `time`, `user_img`, `title`, `liks`, `username`, `content_txt`, `content_big_txt`, `content_url`, `type`) VALUES
(276, '2024-04-01', 'assets/img/logo/logo-mini.svg', 'Классический стиль', 0, 'Дизайн', 'В мире бурлящих тенденций и перемен классический стиль всегда остается надёжным опорным пунктом для создания утонченных и изысканных интерьеров.', '<br>⠀<br>Мы были рады прикоснуться к классическим изысканным формам и элегантным деталям, чтобы продемонстрировать, что красота, вечная гармония и изысканный вкус всегда в цене.<br>⠀<br>Сегодня мы показали квартиру, где будут проживать 4 взрослых  человека и техническое задание было составлено подробно, с указанием классического стиля, но при этом заказчики не понимали как же сделать классику - уютной...<br>⠀<br>Дизайнеры продумали каждую деталь и создали атмосферу уюта наполненную элегантностью и изысканностью. Каждая вещь на своем месте, каждая ткань и текстура подчеркивает статус и вкус хозяев.<br>⠀<br>Заказчики доверились нам и мы помогли воплотить их мечты об идеальном классическом интерьере в реальность. За это нам поставили 10 баллов.<br>⠀<br>Посмотреть больше визуализаций проекта можно в наших социальных сетях.<br>⠀<br>____<br>⠀<br>Исполнители:<br>• Архитектор Дарья Быкова<br>• Визуализатор Михалева София,<br>• Дизайнер Майя Адякина', 'assets/media/IMG_20240331_112232_875.jpg', 'article'),
(277, '2024-04-03', 'assets/img/logo/logo-mini.svg', 'Очередная встреча с франчайзи', 0, 'Дизайн', '.', 'Хотим поделиться радостной новостью - недавно в Сочи прошла встреча с франчайзи студии Экспресс Дизайн!<br>⠀<br>Вместе мы обсудили перспективы развития, прошли обучения и обменялись опытом в области дизайна интерьера.<br>⠀<br>Наши партнеры активно внедряют концепцию Экспресс Дизайн в своих регионах, делая наши услуги доступными для каждого.<br>⠀<br>Они не только создают уникальные дизайн-проекты, но и помогают с выполнением отделочных работ и выбором материалов.<br>⠀<br>Такие встречи – это не просто рабочие совещания, это теплая атмосфера семьи, где решаются важные вопросы и обсуждаются планы по развитию.<br>⠀<br>Подробнее о наших партнёрах вы можете узнать на нашем сайте в разделе \"Партнеры\".', 'assets/media/IMG_20240403_152614_266.jpg', 'article'),
(278, '2024-04-12', 'assets/img/logo/logo-mini.svg', '3D визуализация!', 0, 'Дизайн', 'Благодаря ей владельцы квартиры или дома могут оценить проект в реалистичной обстановке, видя комнаты именно так, как они будут выглядеть после окончания ремонта на объекте.', '<br>⠀<br>3D-визуализация помогает подкорректировать оттенки, расположение мебели, выбрать более подходящие к дизайн-проекту аксессуары. Она реально показывает все плюсы и минусы разных типов планировочных решений и помогает точно понять, что вам понравится больше.<br>⠀<br>О том, почему не стоит отказываться от 3D-визуализации на этапе формирования интерьера?  Помогает ли это исключать ошибки?  Да, помогает. На этапе проектирования в пространство помещений вписываются определенные предметы интерьера и декор. Очень важно учесть габариты и грамотно и эргономично вписать детали. Плоскостные чертежи в отличие от 3D часто не позволяют почувствовать истинный масштаб мебели.<br>⠀<br>Экономическая выгода в том, что клиент не покупает ничего лишнего, а значит, не ошибается: нет возвратов и обменов.<br>Проект можно подогнать под бюджет!<br>⠀<br>Полный проект с 3D-визуализацией за 49.900 рублей сможет сэкономить ваш бюджет в десятикратном размере!', 'assets/media/35.jpg', 'article'),
(279, '2024-04-23', 'assets/img/logo/logo-mini.svg', 'Выбор дизайнера интерьера', 0, 'Дизайн', 'Это – ответственный шаг, который определит облик вашего дома или офиса. Для того чтобы найти идеального специалиста, важно руководствоваться несколькими ключевыми критериями.<br>⠀<br>1.', ' Исследование портфолио. Просмотрите работы потенциальных кандидатов. Убедитесь, что их стиль соответствует вашим предпочтениям, и вы видите взаимопонимание в визуализации пространства.<br>⠀<br>2. Отзывы. Почитайте отзывы клиентов о работе дизайнера. Хорошие рецензии – это отличный показатель профессионализма и качества услуг.<br>⠀<br>3. Обсуждение концепции. Проведите консультации с несколькими специалистами, чтобы понять, насколько они понимают ваше видение проекта и готовы претворить его в жизнь.<br>⠀<br>4. Бюджет. Обсудите с дизайнером финансовые вопросы заранее, чтобы избежать недопониманий и проблем в будущем.<br>⠀<br>5. Профессиональная лицензия. Убедитесь, что у выбранного дизайнера есть соответствующие сертификаты и лицензии, подтверждающие его квалификацию.<br>⠀<br>Студия Экспресс Дизайн готова предложить вам команду профессионалов, способных воплотить ваши мечты в реальность. Мы ценим индивидуальный подход к каждому клиенту и стремимся создать уютное и стильное пространство, отражающее вашу уникальность.<br><br>Выбирайте качество и надежность – выбирайте студию Экспресс Дизайн!', 'assets/media/IMG_20240422_131727_865.jpg', 'article'),
(280, '2024-05-04', 'assets/img/logo/logo-mini.svg', 'Вашему дому нужен особый вздох весеннего обновления?', 0, 'Дизайн', '.', 'Мы знаем, как сделать ваш интерьер прекрасным и уютным!<br>⠀<br>Студия дизайнов готова предложить вам уникальную услугу Экспресс-дизайн!<br>Мы создадим для вас стильный и гармоничный дизайн жилых помещений за кратчайшие сроки и по цене на 70% ниже рыночной стоимости дизайн проектов.<br>⠀<br>Наши профессиональные дизайнеры разработают индивидуальный проект, учитывая ваши пожелания и особенности пространства. Пусть ваш дом станет идеальным уголком для весенних встреч и радостных моментов!<br>⠀<br>Пусть ваш дом наполнится свежими идеями и весенним настроением!<br>⠀<br>Студия Экспресс Дизайн ваш путь к красоте и комфорту! Сделайте эту весну особенной вместе с нами!', 'assets/media/IMG_8264.jpg', 'article'),
(281, '2024-05-21', 'assets/img/logo/logo-mini.svg', 'Совсем скоро лето - время менять интерьер!', 0, 'Дизайн', 'Дайте вашему дому новое дыхание с помощью легких летних изменений!<br>⠀<br>Освежите пространство яркими подушками, легкими шторами и свежими растениями.', ' Добавьте светлые оттенки и натуральные материалы, чтобы создать атмосферу легкости и комфорта.<br>⠀<br>Студия Экспресс Дизайн готова помочь вам воплотить в жизнь ваши идеи и создать уютный летний интерьер, который будет радовать вас каждый день!', 'assets/media/H07A0938.jpg', 'article');
-- --------------------------------------------------------
--
-- Структура таблицы `password_resets`
--
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Структура таблицы `password_reset_tokens`
--
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Структура таблицы `personal_access_tokens`
--
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
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
-- Структура таблицы `users`
--
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Дамп данных таблицы `users`
--
INSERT INTO `users` (`id`, `name`, `status`, `email`, `phone`, `cod`, `avatar_url`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `verification_code`, `verification_code_expires_at`) VALUES
(2, 'w1nishko1', NULL, 'w1nishko@yandex.ru', '+7 (965) 222-44-24', '683024', 'icon/profile.jpg', NULL, '$2y$10$IygNb9BeJpeW0FakKnlMBewum7iII83PB7dq3Pnl73CmARYuPAeDq', NULL, '2024-12-05 08:35:48', '2024-12-08 07:01:57', '8425', '2024-12-08 07:11:57'),
(3, 'w1nishko2', NULL, 'w1nishko2@yandex.ru', '+7 (965) 222-44-20', '7603', NULL, NULL, '$2y$10$zOmdgmUxpw0gwx.ZSSAXqO2N8WJB9Plcg1MsdQ9DHIwrGd3Irus1e', NULL, '2024-12-05 08:35:48', '2024-12-05 09:20:12', NULL, NULL);
--
-- Индексы сохранённых таблиц
--
--
-- Индексы таблицы `commercials`
--
ALTER TABLE `commercials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brifs_user_id_foreign` (`user_id`);
--
-- Индексы таблицы `commons`
--
ALTER TABLE `commons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brifs_user_id_foreign` (`user_id`);
--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);
--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);
--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);
--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);
--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);
--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);
--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);
--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);
--
-- AUTO_INCREMENT для сохранённых таблиц
--
--
-- AUTO_INCREMENT для таблицы `commercials`
--
ALTER TABLE `commercials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `commons`
--
ALTER TABLE `commons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;
--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--
--
-- Ограничения внешнего ключа таблицы `commons`
--
ALTER TABLE `commons`
  ADD CONSTRAINT `brifs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
--
-- Ограничения внешнего ключа таблицы `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
