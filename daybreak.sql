-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 Haz 2017, 08:10:44
-- Sunucu sürümü: 10.1.10-MariaDB
-- PHP Sürümü: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `daybreak`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `groups`
--

CREATE TABLE `groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `users_id` int(11) UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `groups`
--

INSERT INTO `groups` (`id`, `users_id`, `name`) VALUES
(38, 3, 'User Group 1'),
(39, 3, 'User Group 2'),
(41, 4, 'Deneme Group'),
(42, 3, 'User deneme');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `group_members`
--

CREATE TABLE `group_members` (
  `id` int(11) UNSIGNED NOT NULL,
  `groups_id` int(11) UNSIGNED NOT NULL,
  `members_mail` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `group_members`
--

INSERT INTO `group_members` (`id`, `groups_id`, `members_mail`) VALUES
(1, 39, 'test@hotmail.com'),
(3, 41, 'user@gmail.com'),
(4, 38, 'serhattan@hotmail.com'),
(5, 38, 'testuser@hotmail.com'),
(6, 42, 'testuser@hotmail.com'),
(8, 42, 'deneme@gmail.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `medias`
--

CREATE TABLE `medias` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_groups_id` int(11) NOT NULL,
  `path` varchar(250) CHARACTER SET utf8 NOT NULL,
  `meta_info` text CHARACTER SET utf8 NOT NULL,
  `added_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(120) CHARACTER SET utf8 NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`) VALUES
(3, 'user@gmail.com', 'user', '81dc9bdb52d04dc20036dbd8313ed055'),
(4, 'serhattan@hotmail.com', 'serhat', '81dc9bdb52d04dc20036dbd8313ed055'),
(5, 'test@hotmail.com', 'test', '81dc9bdb52d04dc20036dbd8313ed055'),
(6, 'testuser@hotmail.com', 'testuser', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `users_id` int(11) UNSIGNED NOT NULL,
  `groups_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `user_groups`
--

INSERT INTO `user_groups` (`id`, `users_id`, `groups_id`) VALUES
(71, 3, 38),
(72, 3, 39),
(74, 5, 39),
(77, 3, 41),
(78, 4, 38),
(79, 6, 38),
(80, 3, 42);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Tablo için indeksler `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_id` (`groups_id`);

--
-- Tablo için indeksler `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_groups_id` (`user_groups_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `groups_id` (`groups_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- Tablo için AUTO_INCREMENT değeri `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Tablo için AUTO_INCREMENT değeri `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Tablo için AUTO_INCREMENT değeri `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `users-groups-fk` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `groups-group_members-fk` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `user_groups-medias-fk` FOREIGN KEY (`user_groups_id`) REFERENCES `user_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `groups-user_groups-fk` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users-user_groups-fk` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
