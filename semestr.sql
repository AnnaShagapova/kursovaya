-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 14 2023 г., 23:17
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `semestr`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fine_payment`
--

CREATE TABLE `fine_payment` (
  `offender_id` int(11) DEFAULT NULL,
  `rule_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `fine_payment`
--

INSERT INTO `fine_payment` (`offender_id`, `rule_id`, `payment_date`, `payment_amount`, `payment_id`) VALUES
(1, 1, '2023-12-14', '500.00', 1),
(3, 4, '2023-12-14', '500.00', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `offender`
--

CREATE TABLE `offender` (
  `offender_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `driver_license_number` varchar(20) DEFAULT NULL,
  `car_make` varchar(50) DEFAULT NULL,
  `car_number` varchar(20) DEFAULT NULL,
  `rule_description` varchar(255) DEFAULT NULL,
  `full_name_inspector` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `offender`
--

INSERT INTO `offender` (`offender_id`, `full_name`, `driver_license_number`, `car_make`, `car_number`, `rule_description`, `full_name_inspector`) VALUES
(1, 'Иванов Иван Иванович', NULL, 'Skoda Octavia', NULL, '1 - Превышение установленной скорости движения транспортного средства на величину  более 20, но не более 40 километров в час', 'Волкова Елена Дмитриевна'),
(2, 'Петров Петр Петрович', '753874', 'OPEL ASTRA', 'Р530УУ157', '2 - Превышение установленной скорости движения ТС на величину более 40, но не более 60 километров в час', 'Миронов Михаил Иванович'),
(3, 'Васильев Василий Васильевич', NULL, 'Kia Sportage', NULL, '4 - Управление ТС, на котором установлены стекла, светопропускание которых не соответствует требованиям технического регламента о безопасности колесных ТС. ', 'Миронов Михаил Иванович');

-- --------------------------------------------------------

--
-- Структура таблицы `protocol`
--

CREATE TABLE `protocol` (
  `offender_id` int(11) DEFAULT NULL,
  `violation_date` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `inspector_notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `protocol`
--

INSERT INTO `protocol` (`offender_id`, `violation_date`, `location`, `inspector_notes`) VALUES
(1, '2023-12-06', NULL, NULL),
(2, '2023-03-25', 'Челябинская обл., г.Челябинск, ул.40 лет Победы', 'Водитель превысил скорость на 55 км/ч более положенной на данном участке дороги'),
(3, '2023-12-12', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `rules`
--

CREATE TABLE `rules` (
  `rule_id` int(11) NOT NULL,
  `rule_name` varchar(100) DEFAULT NULL,
  `rule_description` varchar(255) DEFAULT NULL,
  `fine_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `rules`
--

INSERT INTO `rules` (`rule_id`, `rule_name`, `rule_description`, `fine_amount`) VALUES
(1, 'Превышение скорости на 20-40 км/ч', '1 - Превышение установленной скорости движения транспортного средства на величину  более 20, но не более 40 километров в час', '500.00'),
(2, 'Превышение скорости на 40-60 км/ч', '2 - Превышение установленной скорости движения ТС на величину более 40, но не более 60 километров в час', '1500.00'),
(3, 'Управление ТС в состояние опьянения', '3 - Управление ТС в состоянии опьянения либо не имеющего права управления ТС', '20000.00'),
(4, 'Тонировка', '4 - Управление ТС, на котором установлены стекла, светопропускание которых не соответствует требованиям технического регламента о безопасности колесных ТС. ', '500.00'),
(5, 'Неисправная тормозная система', '5 - Управление транспортным средством с заведомо неисправными тормозной системой, рулевым управлением или сцепным устройством', '600.00'),
(6, 'Двойная сплошная ', '6 - Пересечение двойной сплошной', '30000.00'),
(7, 'Проезд на красный сигнал светофора', '7 - КРАСНЫЙ СИГНАЛ, в том числе мигающий, запрещает движение.', '1000.00'),
(8, 'Выключенный сигнал дополнительной секции', '8 - Выключенный сигнал дополнительной секции или включенный световой сигнал красного цвета ее контура означает запрещение движения в направлении, регулируемом этой секцией.', '1000.00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name_inspector` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('inspector','extra','cashier','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `full_name_inspector`, `username`, `password`, `role`) VALUES
(1, 'аня', 'аня', 'аня', 'inspector'),
(2, 'олеся', 'Олеся', 'олеся', 'extra'),
(3, 'юля', 'юля', 'юля', 'cashier'),
(4, 'вика', 'вика', 'вика', 'admin'),
(5, 'Миронов Михаил Иванович', 'Михаил', '123', 'inspector'),
(6, 'Волкова Елена Дмитриевна', 'Елена', '123', 'inspector'),
(7, 'Сергеев Сергей Сергеевич', 'Сергей', '123', 'inspector'),
(8, 'Славина Светлана Владимировна', 'Светлана', '123', 'inspector');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `fine_payment`
--
ALTER TABLE `fine_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `offender_id` (`offender_id`);

--
-- Индексы таблицы `offender`
--
ALTER TABLE `offender`
  ADD PRIMARY KEY (`offender_id`);

--
-- Индексы таблицы `protocol`
--
ALTER TABLE `protocol`
  ADD KEY `offender_id` (`offender_id`);

--
-- Индексы таблицы `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`rule_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `fine_payment`
--
ALTER TABLE `fine_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `offender`
--
ALTER TABLE `offender`
  MODIFY `offender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `rules`
--
ALTER TABLE `rules`
  MODIFY `rule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `fine_payment`
--
ALTER TABLE `fine_payment`
  ADD CONSTRAINT `fine_payment_ibfk_1` FOREIGN KEY (`offender_id`) REFERENCES `offender` (`offender_id`);

--
-- Ограничения внешнего ключа таблицы `protocol`
--
ALTER TABLE `protocol`
  ADD CONSTRAINT `protocol_ibfk_1` FOREIGN KEY (`offender_id`) REFERENCES `offender` (`offender_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
