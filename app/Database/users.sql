-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 12 2024 г., 20:52
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
-- База данных: `phd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `login` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passportSeries` varchar(255) DEFAULT NULL,
  `pnifl` varchar(255) DEFAULT NULL,
  `speciality_name` varchar(255) DEFAULT NULL,
  `speciality_number` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `user_id`, `fullname`, `middlename`, `login`, `password`, `gender`, `passportSeries`, `pnifl`, `speciality_name`, `speciality_number`, `degree`, `image_url`, `role`, `status`, `created_at`) VALUES
(1, 'USER-67485ced924fb', 'Super Admin', 'XXX', 'admin', '$2y$10$WQAHEMuDH0gOnqFT2lHXxOMM0hFUq5g.PXZ5QNwLtTiE6v4sSE9yK', 'Erkak', 'AC1475293', '36556247551234', 'Dasturchi', '777', 'Administrator', 'assets/img/person.png', 'superadmin', 'active', '2024-11-23 16:45:44'),
(2, 'USER-67485d1fcc4c4', 'Oyatillo Anvarov', 'Ozodbek o\'g\'li', 'oyatillo', '$2y$10$zS2xDXKKf4bYCHtM5zEam.82e6cp8/NWz42c.uWUG2GSY9mGoOxuW', 'Erkak', 'AC2805749', '123456781111', 'Muhandis', '666', 'Stajor taqiqotchi (PhD)', 'assets/img/person.png', 'user', 'active', '2024-11-23 16:45:45');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
