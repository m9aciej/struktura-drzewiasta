-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Sie 2019, 13:07
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `tree`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tree`
--

CREATE TABLE `tree` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_polish_ci NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tree`
--

INSERT INTO `tree` (`id`, `name`, `parent_id`) VALUES
(3, 'Zoo', 0),
(4, 'Gady', 3),
(5, 'Ptaki', 3),
(6, 'Ssaki', 3),
(7, 'Płazy', 3),
(8, 'Jaszczurka zwinka', 4),
(9, 'Żaba', 7),
(10, 'Ropucha', 7),
(11, 'Kot', 6),
(12, 'Pies', 6),
(13, 'Koń', 6),
(14, 'Jeleń', 6),
(15, 'Kura', 5),
(16, 'Kaczka', 5),
(17, 'Jamnik', 12),
(20, 'Miałek', 11),
(21, 'Sarna', 6),
(22, 'Sarna biała', 21);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `tree`
--
ALTER TABLE `tree`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `tree`
--
ALTER TABLE `tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
