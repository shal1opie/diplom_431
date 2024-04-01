-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 04 2024 г., 12:37
-- Версия сервера: 10.3.16-MariaDB
-- Версия PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cosmodb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `app_types`
--

CREATE TABLE `app_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `app_types`
--

INSERT INTO `app_types` (`id`, `type`) VALUES
(1, 'Спутник'),
(2, 'Ракета');

-- --------------------------------------------------------

--
-- Структура таблицы `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `initials` varchar(255) NOT NULL,
  `surename` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `people`
--

INSERT INTO `people` (`id`, `initials`, `surename`, `name`, `last_name`) VALUES
(1, 'С.П. Королёв', 'Королёв', 'Сергей', 'Павлович'),
(2, 'Ю.А. Гагарин', 'Гагарин', 'Юрий', 'Алексеевич'),
(3, 'В.В. Терешкова', 'Терешкова', 'Валентина', 'Владимировна'),
(4, 'А.А. Леонов', 'Леонов', 'Алексей', 'Архипович');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(1) NOT NULL,
  `role_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Пользователь'),
(2, 'Модератор'),
(3, 'Оператор БД'),
(4, 'Администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `space_achiv`
--

CREATE TABLE `space_achiv` (
  `id` int(11) NOT NULL,
  `country` tinyint(1) NOT NULL,
  `people` int(11) DEFAULT NULL,
  `achiv_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `text` varchar(255) NOT NULL,
  `type_app` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `space_achiv`
--

INSERT INTO `space_achiv` (`id`, `country`, `people`, `achiv_name`, `date`, `text`, `type_app`) VALUES
(1, 1, 2, 'Первый полет в космос', '1961-04-12', '12 апреля 1961 года – дата в истории, о которой не надо напоминать: все знают, что именно в этот день состоялся первый в мире полёт человека в космос. 12 апреля 1961 года в 9 час. 07 мин. по московскому времени в нескольких десятках километров севернее по', 2),
(2, 2, 1, 'Запуск ГЛОНАСС', '1993-10-11', 'Запуск ГЛОНАСС', 1),
(3, 1, 1, 'Запуск первой в мире межконтинентальной ракеты Р-7', '1957-08-21', '21 августа 1957 г. с космодрома Байконур состоялся запуск межконтинентальной баллистической ракеты Р-7. Ракета успешно прошла заданный маршрут, а её головная часть, имитирующая ядерную боеголовку, точно поразила заданную цель на полуострове Камчатка.', 1),
(4, 1, 1, 'Запуск первого в мире искуственного спутника Земли Спутник-1', '1957-10-04', '4 октября 1957 г. в 22 ч. 28 мин. по московскому времени с 5-го научно-исследовательского полигона Министерства обороны СССР, получившего впоследствии открытое наименование космодром Байконур, была запущена отечественная ракета-носитель Р-7 («Спутник-1»),', 1),
(5, 1, 1, 'Первая в мире мягкая посадка спускаемого аппарата на Марс', '1971-05-28', '28 мая 1971 г. с космодрома Байконур в 18 часов 26 минут была запущена АМС «Марс-3». Основная цель полета заключалась в более полном исследовании Марса с орбиты искусственного спутника и на его поверхности. Одна из главных задач состояла в осуществлении с', 1),
(6, 1, 1, 'Запуск второго искусственного спутника Земли \"Спутник-2\"', '1957-11-03', 'Второй искусственный спутник Земли «Спутник-2», впервые выведший в космос живое существо, — собаку Лайку. «Спутник-2» представлял собой конической формы капсулу 4-метровой высоты, с диаметром основания 2 метра, содержал несколько отсеков для научной аппар', 1),
(7, 1, 1, 'Станция «Луна-1» вышла на гелиоцентрическую орбиту', '1959-01-04', 'Станция «Луна-1» прошла на расстоянии 6 тысяч километров от поверхности Луны и вышла на гелиоцентрическую орбиту. Она стала первым в мире искусственным спутником Солнца. Ракета-носитель «Восток-Л» вывела на траекторию полёта к Луне аппарат «Луна-1». Это б', 1),
(8, 1, 3, 'Первый полет женщины в космос', '1963-07-16', 'Свой космический полёт (первый в мире полёт женщины-космонавта) Валентина совершила 16 июня 1963 года на космическом корабле Восток-6, он продолжался почти трое суток. Одновременно на орбите находился космический корабль Восток-5, пилотируемый космонавтом', 2),
(9, 1, 4, 'Первый выход человека в космос', '1965-03-18', 'Космонавт Алексей Леонов совершил выход в открытый космос из корабля «Восход-2». Скафандр «Беркут», использованный для первого выхода, был вентиляционного типа и расходовал примерно 30 литров кислорода в минуту при общем запасе в 1666 литров, рассчитанном', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nick_name` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `role_raise` int(1) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nick_name`, `role`, `role_raise`, `email`, `password`) VALUES
(1, 'admin', 4, 4, 'admin@cfdb.ru', 'admin1337_KU'),
(2, 'operator', 3, 3, 'changedb@cfdb.ru', 'operation_Z3r0'),
(3, 'moderator', 2, 2, 'moderationdb@cfdb.ru', 'mo_re_D3n_atio'),
(4, 'grigory', 1, 4, 'grisha228@mail.ru', 'gam4rJ_0ba');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `app_types`
--
ALTER TABLE `app_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `space_achiv`
--
ALTER TABLE `space_achiv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `space_achiv_fk0` (`people`),
  ADD KEY `space_achiv_fk1` (`type_app`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick_name` (`nick_name`),
  ADD KEY `users_fk0` (`role`),
  ADD KEY `users_fk1` (`role_raise`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `app_types`
--
ALTER TABLE `app_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `space_achiv`
--
ALTER TABLE `space_achiv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `space_achiv`
--
ALTER TABLE `space_achiv`
  ADD CONSTRAINT `space_achiv_fk0` FOREIGN KEY (`people`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `space_achiv_fk1` FOREIGN KEY (`type_app`) REFERENCES `app_types` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_fk0` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_fk1` FOREIGN KEY (`role_raise`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
