-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Kwi 2020, 01:24
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `eevee`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mapstatus`
--

CREATE TABLE `mapstatus` (
  `md5` text NOT NULL,
  `status` int(11) NOT NULL,
  `rankedby` text NOT NULL,
  `special` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `playername` text NOT NULL,
  `md5pass` text NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `players`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `scores`
--

CREATE TABLE `scores` (
  `scoreid` int(11) NOT NULL,
  `beatmaphash` text NOT NULL,
  `username` text NOT NULL,
  `score` int(11) NOT NULL,
  `maxcombo` int(11) NOT NULL,
  `hit300` int(11) NOT NULL,
  `hit100` int(11) NOT NULL,
  `hit50` int(11) NOT NULL,
  `hit0` int(11) NOT NULL,
  `hitGeki` int(11) NOT NULL,
  `hitKatu` int(11) NOT NULL,
  `perfect` text NOT NULL,
  `mods` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `staff`
--

CREATE TABLE `staff` (
  `userid` int(11) NOT NULL,
  `username` text NOT NULL,
  `privledge` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
