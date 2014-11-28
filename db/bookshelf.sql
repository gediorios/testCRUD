-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 26 2014 г., 12:31
-- Версия сервера: 5.6.11-log
-- Версия PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `bookshelf`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(64) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `date_added`) VALUES
(7, 'Шпаги над звездами', 'Роман Злотников', '2014-11-06 00:00:00'),
(8, 'Рожденный туманом', 'Брендом Сандерсон', '2014-11-15 00:00:00'),
(9, 'Хроники убийцы короля', 'Патрик Ротфусс', '2014-11-15 00:00:00'),
(10, 'Пикник на обочине', 'Аркадий Стругацкий', '2014-11-15 00:00:00'),
(11, 'Три мушкетера', 'Александр Дюма', '2014-11-22 00:00:00'),
(12, 'Принц и нищий', 'Марк Твен', '2014-11-22 00:00:00'),
(13, 'Путеводитель по науке', 'Айзек Азимов', '2014-11-29 00:00:00'),
(14, 'Мастер и Маргарита', 'Михаил Булгаков', '2014-11-22 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `lib2book`
--

CREATE TABLE IF NOT EXISTS `lib2book` (
  `library_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  UNIQUE KEY `library_id` (`library_id`,`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lib2book`
--

INSERT INTO `lib2book` (`library_id`, `book_id`) VALUES
(3, 7),
(3, 10),
(3, 13),
(4, 8),
(4, 9),
(4, 14),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(5, 11),
(5, 12),
(6, 11),
(6, 12),
(6, 13),
(6, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `libraries`
--

CREATE TABLE IF NOT EXISTS `libraries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `libraries`
--

INSERT INTO `libraries` (`id`, `title`, `date_added`) VALUES
(3, 'Фантастика', '2014-11-01 00:00:00'),
(4, 'Фентези', '2014-11-02 00:00:00'),
(5, 'Приключения', '2014-11-03 00:00:00'),
(6, 'Историческая проза', '2014-11-05 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
