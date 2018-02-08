-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: 192.168.101.144
-- Czas wygenerowania: 08 Lut 2018, 01:34
-- Wersja serwera: 5.6.36-82.1-log
-- Wersja PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `bart494_szpitalpr`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karta_dostepu_pomieszczenie`
--

CREATE TABLE IF NOT EXISTS `karta_dostepu_pomieszczenie` (
  `pomieszczenie_nr` varchar(15) NOT NULL,
  `karta_dostepu_numer` varchar(10) NOT NULL,
  `karta_dostepu_pracownicy_pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`pomieszczenie_nr`,`karta_dostepu_numer`,`karta_dostepu_pracownicy_pesel`),
  KEY `relation_11_karta_dostepu_fk` (`karta_dostepu_numer`,`karta_dostepu_pracownicy_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `karta_dostepu_pomieszczenie`
--

INSERT INTO `karta_dostepu_pomieszczenie` (`pomieszczenie_nr`, `karta_dostepu_numer`, `karta_dostepu_pracownicy_pesel`) VALUES
('00', '1', '1039300868'),
('01', '1', '1039300868'),
('15', '1', '1039300868'),
('00', '2', '4318728319'),
('01', '2', '4318728319'),
('02', '2', '4318728319'),
('03', '2', '4318728319'),
('04', '2', '4318728319'),
('05', '2', '4318728319'),
('06', '2', '4318728319'),
('10', '2', '4318728319'),
('11', '2', '4318728319'),
('13', '2', '4318728319'),
('14', '2', '4318728319');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karty_dostepu`
--

CREATE TABLE IF NOT EXISTS `karty_dostepu` (
  `numer` varchar(10) NOT NULL,
  `pracownicy_pesel` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`numer`,`pracownicy_pesel`),
  UNIQUE KEY `karta_dostepu__idx` (`pracownicy_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `karty_dostepu`
--

INSERT INTO `karty_dostepu` (`numer`, `pracownicy_pesel`) VALUES
('1', '1039300868'),
('2', '4318728319');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `leczenia`
--

CREATE TABLE IF NOT EXISTS `leczenia` (
  `data` date NOT NULL,
  `nazwa_choroby` varchar(50) NOT NULL,
  `pacjenci_pesel` varchar(10) NOT NULL,
  `id_leczenia` varchar(10) NOT NULL,
  `lekarz_pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`pacjenci_pesel`,`id_leczenia`),
  UNIQUE KEY `leczenie__idx` (`pacjenci_pesel`),
  KEY `leczenie_lekarz_fk` (`lekarz_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `leczenia`
--

INSERT INTO `leczenia` (`data`, `nazwa_choroby`, `pacjenci_pesel`, `id_leczenia`, `lekarz_pesel`) VALUES
('2018-02-08', 'Grypa', '0176383131', '5a7b996c', '4318728319'),
('2018-02-08', 'PrzeziÄbienie', '4400980286', '5a7b99e4', '9568496607'),
('2018-02-08', 'ZĹamanie', '8215845069', '5a7b9a89', '9568496607'),
('2018-02-08', 'Grypa', '8249651991', '5a7b9ae2', '4318728319');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `leczenie_leki_w_magazynie`
--

CREATE TABLE IF NOT EXISTS `leczenie_leki_w_magazynie` (
  `zasob_id_leku` varchar(15) NOT NULL,
  `leczenie_pacjenci_pesel` varchar(10) NOT NULL,
  `leczenie_id_leczenia` varchar(10) NOT NULL,
  PRIMARY KEY (`zasob_id_leku`,`leczenie_pacjenci_pesel`,`leczenie_id_leczenia`),
  KEY `relation_7_leczenie_fk` (`leczenie_pacjenci_pesel`,`leczenie_id_leczenia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `leczenie_leki_w_magazynie`
--

INSERT INTO `leczenie_leki_w_magazynie` (`zasob_id_leku`, `leczenie_pacjenci_pesel`, `leczenie_id_leczenia`) VALUES
('3672', '0176383131', '5a7b996c'),
('2244', '4400980286', '5a7b99e4'),
('5288826', '8215845069', '5a7b9a89'),
('65023', '8249651991', '5a7b9ae2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekarze`
--

CREATE TABLE IF NOT EXISTS `lekarze` (
  `pesel` varchar(10) CHARACTER SET utf8 NOT NULL,
  `specjalizacja` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `lekarze`
--

INSERT INTO `lekarze` (`pesel`, `specjalizacja`) VALUES
('4318728319', 'kardiolog'),
('9568496607', 'chirurg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `leki_w_magazynie`
--

CREATE TABLE IF NOT EXISTS `leki_w_magazynie` (
  `nazwa` varchar(40) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ilosc` varchar(15) NOT NULL,
  `id_leku` varchar(15) NOT NULL,
  PRIMARY KEY (`id_leku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `leki_w_magazynie`
--

INSERT INTO `leki_w_magazynie` (`nazwa`, `ilosc`, `id_leku`) VALUES
('Paracetamolum', '100', '1983'),
('Acidum acetylsalicylicum', '100', '2244'),
('Ibuprofenum', '86', '3672'),
('Morphinum', '25', '5288826'),
('Benzylpenicillin', '50', '5904'),
('Oseltamivir', '36', '65023');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `odwiedzajacy`
--

CREATE TABLE IF NOT EXISTS `odwiedzajacy` (
  `pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `odwiedziny`
--

CREATE TABLE IF NOT EXISTS `odwiedziny` (
  `data` date NOT NULL,
  `pacjenci_pesel` varchar(10) NOT NULL,
  `odwiedzajacy_pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`data`,`pacjenci_pesel`,`odwiedzajacy_pesel`),
  KEY `odwiedziny_odwiedzajacy_fk` (`odwiedzajacy_pesel`),
  KEY `odwiedziny_pacjenci_fk` (`pacjenci_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `osoby`
--

CREATE TABLE IF NOT EXISTS `osoby` (
  `imie` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `pesel` varchar(10) CHARACTER SET utf8 NOT NULL,
  `telefon` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `adres` varchar(70) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `osoby`
--

INSERT INTO `osoby` (`imie`, `nazwisko`, `pesel`, `telefon`, `adres`) VALUES
('Dawid', 'SzymaĹski', '0176383131', '648752134', 'ul. Makowa 71 KrakĂłw'),
('Jan', 'ZieliĹski', '1039300868', '655211474', 'al. NiepodlegĹoĹci 78 KrakĂłw'),
('Henryk', 'Nowak', '4318728319', '649761845', 'ul. SĹoneczna 55 KrakĂłw'),
('Beata', 'WoĹşniak', '4400980286', '668572111', 'ul. RĂłĹźana 11 KrakĂłw'),
('Julia', 'WiĹniewska', '5484170921', '998547125', 'ul. Asfaltowa 45 KrakĂłw'),
('Robert', 'KozĹowski', '8215845069', '444411254', 'ul. Towarowa 76 KrakĂłw'),
('Mariusz', 'Jankowski', '8249651991', '123487235', 'ul. WiĹlana 3 KrakĂłw'),
('Anna', 'KamiĹska', '8760727097', '648215346', 'ul. Chabrowa 102 KrakĂłw'),
('Adam', 'Kowalczyk', '9568496607', '587121988', 'ul. DĹuga 18/1 KrakĂłw');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pacjenci`
--

CREATE TABLE IF NOT EXISTS `pacjenci` (
  `pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `pacjenci`
--

INSERT INTO `pacjenci` (`pesel`) VALUES
('0176383131'),
('4400980286'),
('8215845069'),
('8249651991');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pomieszczenia`
--

CREATE TABLE IF NOT EXISTS `pomieszczenia` (
  `nr` varchar(15) CHARACTER SET utf8 NOT NULL,
  `typ_pomieszczenia` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`nr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pomieszczenia`
--

INSERT INTO `pomieszczenia` (`nr`, `typ_pomieszczenia`) VALUES
('00', 'korytarz'),
('01', 'poczekalnia'),
('02', 'sala_chorych'),
('03', 'sala_chorych'),
('04', 'sala_chorych'),
('05', 'gabinet_zabiegowy'),
('06', 'pokoj_lekarski'),
('07', 'pomieszczenie_gospodarcze'),
('10', 'sala_operacyjna'),
('11', 'sala_operacyjna'),
('12', 'magazyn'),
('13', 'sala_chorych'),
('14', 'sala_chorych'),
('15', 'laboratorium'),
('16', 'biuro');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE IF NOT EXISTS `pracownicy` (
  `stanowisko` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `pensja` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `pesel` varchar(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`stanowisko`, `pensja`, `pesel`) VALUES
('laborant', '4700', '1039300868'),
('lekarz', '5500', '4318728319'),
('pielÄgniarka', '3500', '5484170921'),
('asystent', '2500', '8760727097'),
('lekarz', '6000', '9568496607');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przyjecia`
--

CREATE TABLE IF NOT EXISTS `przyjecia` (
  `data` date NOT NULL,
  `rejestracja_data` date NOT NULL,
  `rejestracja_pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`data`,`rejestracja_data`,`rejestracja_pesel`),
  KEY `przyjecie_rejestracja_fk` (`rejestracja_data`,`rejestracja_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rejestracje`
--

CREATE TABLE IF NOT EXISTS `rejestracje` (
  `data` date NOT NULL,
  `pacjenci_pesel` varchar(10) NOT NULL,
  `data_wypisu` date DEFAULT NULL,
  PRIMARY KEY (`data`,`pacjenci_pesel`),
  UNIQUE KEY `rejestracja__idx` (`pacjenci_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `rejestracje`
--

INSERT INTO `rejestracje` (`data`, `pacjenci_pesel`, `data_wypisu`) VALUES
('2018-02-08', '0176383131', NULL),
('2018-02-08', '4400980286', NULL),
('2018-02-08', '8215845069', '2018-02-08'),
('2018-02-08', '8249651991', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samochody`
--

CREATE TABLE IF NOT EXISTS `samochody` (
  `marka` varchar(30) NOT NULL,
  `model` varchar(20) NOT NULL,
  `nr_rejestracyjny` varchar(20) NOT NULL,
  PRIMARY KEY (`nr_rejestracyjny`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samochod_osoba`
--

CREATE TABLE IF NOT EXISTS `samochod_osoba` (
  `osoba_pesel` varchar(10) NOT NULL,
  `samochod_nr_rejestracyjny` varchar(20) NOT NULL,
  PRIMARY KEY (`osoba_pesel`,`samochod_nr_rejestracyjny`),
  KEY `relation_16_samochod_fk` (`samochod_nr_rejestracyjny`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `webmasters`
--

CREATE TABLE IF NOT EXISTS `webmasters` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `webmasters`
--

INSERT INTO `webmasters` (`id`, `login`, `password`) VALUES
(1, 'bartosz', 'FPv9e8sDuKt9'),
(2, 'tadeusz', 'rgmUwsmuMPvi'),
(3, 'admin', 'test');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypisy`
--

CREATE TABLE IF NOT EXISTS `wypisy` (
  `data` date NOT NULL,
  `czy_przezyl` tinyint(1) NOT NULL,
  `rejestracja_data` date NOT NULL,
  `rejestracja_pacjenci_pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`data`,`rejestracja_data`,`rejestracja_pacjenci_pesel`),
  KEY `wypis_rejestracja_fk` (`rejestracja_data`,`rejestracja_pacjenci_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wyplaty`
--

CREATE TABLE IF NOT EXISTS `wyplaty` (
  `data` date NOT NULL,
  `kwota` varchar(15) NOT NULL,
  `pracownicy_pesel` varchar(10) NOT NULL,
  PRIMARY KEY (`data`,`pracownicy_pesel`),
  KEY `wyplata_pracownicy_fk` (`pracownicy_pesel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wyposazenie`
--

CREATE TABLE IF NOT EXISTS `wyposazenie` (
  `typ` varchar(40) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `pomieszczenie_nr` varchar(15) NOT NULL,
  KEY `wyposazenie_pomieszczenie_fk` (`pomieszczenie_nr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE IF NOT EXISTS `zamowienia` (
  `data` date NOT NULL,
  `ilosc` varchar(10) NOT NULL,
  `wartosc` varchar(10) NOT NULL,
  `id_zamowienia` varchar(15) NOT NULL,
  `id_leku` varchar(15) NOT NULL,
  PRIMARY KEY (`id_zamowienia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia_leki_w_magazynie`
--

CREATE TABLE IF NOT EXISTS `zamowienia_leki_w_magazynie` (
  `zasob_id_leku` varchar(15) NOT NULL,
  `zamowienia_id_zamowienia` varchar(15) NOT NULL,
  `zamowienia_id_leku` varchar(15) NOT NULL,
  PRIMARY KEY (`zasob_id_leku`,`zamowienia_id_zamowienia`,`zamowienia_id_leku`),
  KEY `relation_20_zamowienia_fk` (`zamowienia_id_zamowienia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `karta_dostepu_pomieszczenie`
--
ALTER TABLE `karta_dostepu_pomieszczenie`
  ADD CONSTRAINT `relation_11_karta_dostepu_fk` FOREIGN KEY (`karta_dostepu_numer`, `karta_dostepu_pracownicy_pesel`) REFERENCES `karty_dostepu` (`numer`, `pracownicy_pesel`),
  ADD CONSTRAINT `relation_11_pomieszczenie_fk` FOREIGN KEY (`pomieszczenie_nr`) REFERENCES `pomieszczenia` (`nr`);

--
-- Ograniczenia dla tabeli `karty_dostepu`
--
ALTER TABLE `karty_dostepu`
  ADD CONSTRAINT `karta_dostepu_pracownicy_fk` FOREIGN KEY (`pracownicy_pesel`) REFERENCES `pracownicy` (`pesel`);

--
-- Ograniczenia dla tabeli `leczenia`
--
ALTER TABLE `leczenia`
  ADD CONSTRAINT `leczenie_lekarz_fk` FOREIGN KEY (`lekarz_pesel`) REFERENCES `lekarze` (`pesel`),
  ADD CONSTRAINT `leczenie_pacjenci_fk` FOREIGN KEY (`pacjenci_pesel`) REFERENCES `pacjenci` (`pesel`);

--
-- Ograniczenia dla tabeli `leczenie_leki_w_magazynie`
--
ALTER TABLE `leczenie_leki_w_magazynie`
  ADD CONSTRAINT `relation_7_leczenie_fk` FOREIGN KEY (`leczenie_pacjenci_pesel`, `leczenie_id_leczenia`) REFERENCES `leczenia` (`pacjenci_pesel`, `id_leczenia`),
  ADD CONSTRAINT `relation_7_zasob_fk` FOREIGN KEY (`zasob_id_leku`) REFERENCES `leki_w_magazynie` (`id_leku`);

--
-- Ograniczenia dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  ADD CONSTRAINT `lekarz_pracownicy_fk` FOREIGN KEY (`pesel`) REFERENCES `pracownicy` (`pesel`),
  ADD CONSTRAINT `lekarz_pracownicy_fkv2` FOREIGN KEY (`pesel`) REFERENCES `pracownicy` (`pesel`);

--
-- Ograniczenia dla tabeli `odwiedzajacy`
--
ALTER TABLE `odwiedzajacy`
  ADD CONSTRAINT `odwiedzajacy_osoba_fk` FOREIGN KEY (`pesel`) REFERENCES `osoby` (`pesel`),
  ADD CONSTRAINT `odwiedzajacy_osoba_fkv2` FOREIGN KEY (`pesel`) REFERENCES `osoby` (`pesel`);

--
-- Ograniczenia dla tabeli `odwiedziny`
--
ALTER TABLE `odwiedziny`
  ADD CONSTRAINT `odwiedziny_odwiedzajacy_fk` FOREIGN KEY (`odwiedzajacy_pesel`) REFERENCES `odwiedzajacy` (`pesel`),
  ADD CONSTRAINT `odwiedziny_pacjenci_fk` FOREIGN KEY (`pacjenci_pesel`) REFERENCES `pacjenci` (`pesel`);

--
-- Ograniczenia dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  ADD CONSTRAINT `pacjenci_osoba_fk` FOREIGN KEY (`pesel`) REFERENCES `osoby` (`pesel`),
  ADD CONSTRAINT `pacjenci_osoba_fkv2` FOREIGN KEY (`pesel`) REFERENCES `osoby` (`pesel`);

--
-- Ograniczenia dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_osoba_fk` FOREIGN KEY (`pesel`) REFERENCES `osoby` (`pesel`),
  ADD CONSTRAINT `pracownicy_osoba_fkv2` FOREIGN KEY (`pesel`) REFERENCES `osoby` (`pesel`);

--
-- Ograniczenia dla tabeli `przyjecia`
--
ALTER TABLE `przyjecia`
  ADD CONSTRAINT `przyjecie_rejestracja_fk` FOREIGN KEY (`rejestracja_data`, `rejestracja_pesel`) REFERENCES `rejestracje` (`data`, `pacjenci_pesel`);

--
-- Ograniczenia dla tabeli `rejestracje`
--
ALTER TABLE `rejestracje`
  ADD CONSTRAINT `rejestracja_pacjenci_fk` FOREIGN KEY (`pacjenci_pesel`) REFERENCES `pacjenci` (`pesel`);

--
-- Ograniczenia dla tabeli `samochod_osoba`
--
ALTER TABLE `samochod_osoba`
  ADD CONSTRAINT `relation_16_osoba_fk` FOREIGN KEY (`osoba_pesel`) REFERENCES `osoby` (`pesel`),
  ADD CONSTRAINT `relation_16_samochod_fk` FOREIGN KEY (`samochod_nr_rejestracyjny`) REFERENCES `samochody` (`nr_rejestracyjny`);

--
-- Ograniczenia dla tabeli `wypisy`
--
ALTER TABLE `wypisy`
  ADD CONSTRAINT `wypis_rejestracja_fk` FOREIGN KEY (`rejestracja_data`, `rejestracja_pacjenci_pesel`) REFERENCES `rejestracje` (`data`, `pacjenci_pesel`);

--
-- Ograniczenia dla tabeli `wyplaty`
--
ALTER TABLE `wyplaty`
  ADD CONSTRAINT `wyplata_pracownicy_fk` FOREIGN KEY (`pracownicy_pesel`) REFERENCES `pracownicy` (`pesel`);

--
-- Ograniczenia dla tabeli `wyposazenie`
--
ALTER TABLE `wyposazenie`
  ADD CONSTRAINT `wyposazenie_pomieszczenie_fk` FOREIGN KEY (`pomieszczenie_nr`) REFERENCES `pomieszczenia` (`nr`);

--
-- Ograniczenia dla tabeli `zamowienia_leki_w_magazynie`
--
ALTER TABLE `zamowienia_leki_w_magazynie`
  ADD CONSTRAINT `relation_20_zamowienia_fk` FOREIGN KEY (`zamowienia_id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`),
  ADD CONSTRAINT `relation_20_zasob_fk` FOREIGN KEY (`zasob_id_leku`) REFERENCES `leki_w_magazynie` (`id_leku`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
