CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `initials` varchar(255) NOT NULL,
  `surename` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
INSERT INTO `people` (`id`, `initials`, `surename`, `name`, `last_name`) VALUES 
(1, 'С.П. Королёв', 'Королёв', 'Сергей', 'Павлович'),
(2, 'Ю.А. Гагарин', 'Гагарин', 'Юрий', 'Алексеевич'),
(3, 'В.В. Терешкова', 'Терешкова', 'Валентина', 'Владимировна'),
(4, 'А.А. Леонов', 'Леонов', 'Алексей', 'Архипович');

CREATE TABLE `app_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
INSERT INTO `app_types` (`id`, `type`) VALUES 
(1, 'Спутник'),
(2, 'Ракета');

CREATE TABLE `roles` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
INSERT INTO `roles` (`id`, `role_name`) VALUES 
(1, 'Пользователь'),
(2, 'Модератор'),
(3, 'Оператор БД'),
(4, 'Администратор');

CREATE TABLE `space_achiv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` tinyint(1) NOT NULL,
  `people` int(11) DEFAULT NULL,
  `achiv_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `text` text NOT NULL,
  `type_app` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `space_achiv_fk0` (`people`),
  KEY `space_achiv_fk1` (`type_app`),
  CONSTRAINT `space_achiv_fk0` FOREIGN KEY (`people`) REFERENCES `people` (`id`),
  CONSTRAINT `space_achiv_fk1` FOREIGN KEY (`type_app`) REFERENCES `app_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
INSERT INTO `space_achiv` (`id`, `country`, `people`, `achiv_name`, `date`, `text`, `type_app`) VALUES 
(1, '1', '2', 'Первый полет в космос', '1961-04-12', '12 апреля 1961 года – дата в истории, о которой не надо напоминать: все знают, что именно в этот день состоялся первый в мире полёт человека в космос. 12 апреля 1961 года в 9 час. 07 мин. по московскому времени в нескольких десятках километров севернее по', '2'),
(2, '2', '1', 'Запуск ГЛОНАСС', '1993-10-11', 'Запуск ГЛОНАСС', '1'),
(3, '1', '1', 'Запуск первой в мире межконтинентальной ракеты Р-7', '1957-08-21', '21 августа 1957 г. с космодрома Байконур состоялся запуск межконтинентальной баллистической ракеты Р-7. Ракета успешно прошла заданный маршрут, а её головная часть, имитирующая ядерную боеголовку, точно поразила заданную цель на полуострове Камчатка.', '1'),
(4, '1', '1', 'Запуск первого в мире искуственного спутника Земли Спутник-1', '1957-10-04', '4 октября 1957 г. в 22 ч. 28 мин. по московскому времени с 5-го научно-исследовательского полигона Министерства обороны СССР, получившего впоследствии открытое наименование космодром Байконур, была запущена отечественная ракета-носитель Р-7 («Спутник-1»),', '1'),
(5, '1', '1', 'Первая в мире мягкая посадка спускаемого аппарата на Марс', '1971-05-28', '28 мая 1971 г. с космодрома Байконур в 18 часов 26 минут была запущена АМС «Марс-3». Основная цель полета заключалась в более полном исследовании Марса с орбиты искусственного спутника и на его поверхности. Одна из главных задач состояла в осуществлении с', '1'),
(6, '1', '1', 'Запуск второго искусственного спутника Земли "Спутник-2"', '1957-11-03', 'Второй искусственный спутник Земли «Спутник-2», впервые выведший в космос живое существо, — собаку Лайку. «Спутник-2» представлял собой конической формы капсулу 4-метровой высоты, с диаметром основания 2 метра, содержал несколько отсеков для научной аппар', '1'),
(7, '1', '1', 'Станция «Луна-1» вышла на гелиоцентрическую орбиту', '1959-01-04', 'Станция «Луна-1» прошла на расстоянии 6 тысяч километров от поверхности Луны и вышла на гелиоцентрическую орбиту. Она стала первым в мире искусственным спутником Солнца. Ракета-носитель «Восток-Л» вывела на траекторию полёта к Луне аппарат «Луна-1». Это б', '1'),
(8, '1', '3', 'Первый полет женщины в космос', '1963-07-16', 'Свой космический полёт (первый в мире полёт женщины-космонавта) Валентина совершила 16 июня 1963 года на космическом корабле Восток-6, он продолжался почти трое суток. Одновременно на орбите находился космический корабль Восток-5, пилотируемый космонавтом', '2'),
(9, '1', '4', 'Первый выход человека в космос', '1965-03-18', 'Космонавт Алексей Леонов совершил выход в открытый космос из корабля «Восход-2». Скафандр «Беркут», использованный для первого выхода, был вентиляционного типа и расходовал примерно 30 литров кислорода в минуту при общем запасе в 1666 литров, рассчитанном', '2');

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `role_raise` int(1) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nick_name` (`nick_name`),
  KEY `users_fk0` (`role`),
  KEY `users_fk1` (`role_raise`),
  CONSTRAINT `users_fk0` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  CONSTRAINT `users_fk1` FOREIGN KEY (`role_raise`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
INSERT INTO `users` (`id`, `nick_name`, `role`, `role_raise`, `email`, `password`) VALUES 
(1, 'admin', '4','4', 'admin@cfdb.ru', '$2y$10$HvqPWschJo9ml/BUwzS99OuTF63Yb38oNoysjJIBJiVmAiawoPFPa');

