-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Aug 21. 20:15
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis létrehozása és kiválasztása
--

CREATE DATABASE IF NOT EXISTS `inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;
USE `inventory`;

-- --------------------------------------------------------
CREATE USER 'inventory_admin'@'localhost' IDENTIFIED BY 'Qq6JMtIMrmlstxSO';
GRANT ALL PRIVILEGES ON inventory.* TO 'inventory_admin'@'localhost';
FLUSH PRIVILEGES;
--
-- Tábla szerkezet ehhez a táblához `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `city`, `contact_person`, `contact_email`, `contact_phone`, `created_at`) VALUES
(1, 'TechNova Kft.', 'Váci út 123', 'Budapest', 'Kiss Péter', 'peter.kiss@technova.hu', '+36 1 234 5678', '2025-01-15 08:30:00'),
(2, 'DataFlow Solutions Zrt.', 'Bem tér 5', 'Debrecen', 'Nagy Anna', 'anna.nagy@dataflow.hu', '+36 52 987 654', '2025-02-10 09:15:00'),
(3, 'CloudMaster Kft.', 'Kossuth Lajos utca 45', 'Szeged', 'Szabó Gábor', 'gabor.szabo@cloudmaster.hu', '+36 62 111 222', '2025-03-05 10:45:00'),
(4, 'InfoTech Group Bt.', 'Rákóczi út 78', 'Pécs', 'Kovács Mónika', 'monika.kovacs@infotech.hu', '+36 72 333 444', '2025-03-20 11:20:00'),
(5, 'DigitalWorks Kft.', 'Széchenyi tér 12', 'Győr', 'Tóth László', 'laszlo.toth@digitalworks.hu', '+36 96 555 666', '2025-04-12 14:30:00'),
(6, 'NetSphere Zrt.', 'Petőfi Sándor utca 34', 'Miskolc', 'Horváth Eszter', 'eszter.horvath@netsphere.hu', '+36 46 777 888', '2025-05-08 16:00:00'),
(7, 'ByteCorp Kft.', 'Arany János utca 56', 'Székesfehérvár', 'Varga Tamás', 'tamas.varga@bytecorp.hu', '+36 22 999 000', '2025-06-15 09:45:00'),
(8, 'CyberLink Solutions', 'Dózsa György út 89', 'Nyíregyháza', 'Balogh Katalin', 'katalin.balogh@cyberlink.hu', '+36 42 111 333', '2025-07-02 13:15:00'),
(9, 'SmartTech Innovations', 'Bajcsy-Zsilinszky út 67', 'Kecskemét', 'Farkas Zoltán', 'zoltan.farkas@smarttech.hu', '+36 76 222 444', '2025-07-25 15:30:00'),
(10, 'NextGen IT Services', 'Király utca 23', 'Szombathely', 'Németh Ildikó', 'ildiko.nemeth@nextgen.hu', '+36 94 555 777', '2025-08-10 12:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `device_type` enum('szerver','gép','laptop','monitor','nyomtató','telefon','switch','router') NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` enum('kiadható','kiadva','szerelés alatt','selejtezett') DEFAULT 'kiadható',
  `is_invoiced` tinyint(1) DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `devices`
--

INSERT INTO `devices` (`id`, `device_name`, `device_type`, `serial_number`, `company_id`, `status`, `is_invoiced`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Dell PowerEdge R730', 'szerver', 'SRV-DELL-001', 1, 'kiadva', 1, 'Virtualizációs szerver, 64GB RAM', '2025-01-16 08:00:00', '2025-01-16 08:00:00'),
(2, 'HP ProLiant DL380', 'szerver', 'SRV-HP-002', 2, 'kiadható', 0, 'Adatbázis szerver', '2025-01-17 09:30:00', '2025-01-17 09:30:00'),
(3, 'Lenovo ThinkCentre M720', 'gép', 'PC-LEN-003', 1, 'kiadva', 1, 'Irodai munkaállomás', '2025-01-18 10:15:00', '2025-01-18 10:15:00'),
(4, 'Dell OptiPlex 7090', 'gép', 'PC-DELL-004', 3, 'kiadható', 0, 'CAD workstation', '2025-01-19 11:45:00', '2025-01-19 11:45:00'),
(5, 'MacBook Pro 16"', 'laptop', 'LAP-APPLE-005', 2, 'kiadva', 1, 'Grafikai tervezéshez', '2025-01-20 13:20:00', '2025-01-20 13:20:00'),
(6, 'Lenovo ThinkPad X1 Carbon', 'laptop', 'LAP-LEN-006', 4, 'kiadható', 0, 'Üzleti laptop', '2025-01-21 14:00:00', '2025-01-21 14:00:00'),
(7, 'Dell Latitude 5520', 'laptop', 'LAP-DELL-007', 1, 'szerelés alatt', 0, 'Billentyűzet csere szükséges', '2025-01-22 15:30:00', '2025-01-22 15:30:00'),
(8, 'ASUS ROG Zephyrus', 'laptop', 'LAP-ASUS-008', 5, 'kiadva', 1, 'Fejlesztői gép', '2025-01-23 16:45:00', '2025-01-23 16:45:00'),
(9, 'Samsung C27F390', 'monitor', 'MON-SAM-009', 3, 'kiadható', 0, '27" ívelt monitor', '2025-01-24 08:15:00', '2025-01-24 08:15:00'),
(10, 'LG UltraWide 34"', 'monitor', 'MON-LG-010', 6, 'kiadva', 1, 'Dupla monitor funkcionalitás', '2025-01-25 09:00:00', '2025-01-25 09:00:00'),
(11, 'Dell P2719H', 'monitor', 'MON-DELL-011', 2, 'kiadható', 0, '27" IPS panel', '2025-01-26 10:30:00', '2025-01-26 10:30:00'),
(12, 'HP EliteDisplay 24"', 'monitor', 'MON-HP-012', 7, 'kiadva', 1, 'Irodai monitor', '2025-01-27 11:15:00', '2025-01-27 11:15:00'),
(13, 'Canon i-SENSYS LBP6030', 'nyomtató', 'PRT-CAN-013', 4, 'kiadható', 0, 'Monokróm lézer nyomtató', '2025-01-28 12:45:00', '2025-01-28 12:45:00'),
(14, 'HP LaserJet Pro M404', 'nyomtató', 'PRT-HP-014', 8, 'kiadva', 1, 'Hálózati nyomtató', '2025-01-29 13:30:00', '2025-01-29 13:30:00'),
(15, 'Brother HL-L2375DW', 'nyomtató', 'PRT-BRO-015', 5, 'kiadható', 0, 'WiFi duplex nyomtató', '2025-01-30 14:20:00', '2025-01-30 14:20:00'),
(16, 'Epson EcoTank L3250', 'nyomtató', 'PRT-EPS-016', 9, 'szerelés alatt', 0, 'Tintasugaras, tisztítás szükséges', '2025-01-31 15:00:00', '2025-01-31 15:00:00'),
(17, 'iPhone 13 Pro', 'telefon', 'PHN-APPLE-017', 1, 'kiadva', 1, 'Vezetői telefon', '2025-02-01 08:30:00', '2025-02-01 08:30:00'),
(18, 'Samsung Galaxy S23', 'telefon', 'PHN-SAM-018', 6, 'kiadható', 0, 'Ügyfélszolgálati telefon', '2025-02-02 09:45:00', '2025-02-02 09:45:00'),
(19, 'Google Pixel 7', 'telefon', 'PHN-GOO-019', 3, 'kiadva', 1, 'IT support telefon', '2025-02-03 10:15:00', '2025-02-03 10:15:00'),
(20, 'OnePlus 11', 'telefon', 'PHN-ONE-020', 10, 'kiadható', 0, 'Projektvezető telefon', '2025-02-04 11:30:00', '2025-02-04 11:30:00'),
(21, 'Cisco SG350-28', 'switch', 'SW-CIS-021', 2, 'kiadva', 1, '28 portos managed switch', '2025-02-05 12:00:00', '2025-02-05 12:00:00'),
(22, 'TP-Link TL-SG2210P', 'switch', 'SW-TP-022', 7, 'kiadható', 0, '10 portos PoE switch', '2025-02-06 13:15:00', '2025-02-06 13:15:00'),
(23, 'Netgear GS108', 'switch', 'SW-NET-023', 4, 'kiadva', 1, '8 portos gigabit switch', '2025-02-07 14:45:00', '2025-02-07 14:45:00'),
(24, 'D-Link DGS-1016D', 'switch', 'SW-DLI-024', 8, 'kiadható', 0, '16 portos desktop switch', '2025-02-08 15:30:00', '2025-02-08 15:30:00'),
(25, 'Cisco ISR 4321', 'router', 'RT-CIS-025', 1, 'kiadva', 1, 'Telephelyi router WAN kapcsolattal', '2025-02-09 08:00:00', '2025-02-09 08:00:00'),
(26, 'MikroTik hAP ac2', 'router', 'RT-MIK-026', 5, 'kiadható', 0, 'Kis irodai router WiFi-vel', '2025-02-10 09:30:00', '2025-02-10 09:30:00'),
(27, 'Ubiquiti EdgeRouter X', 'router', 'RT-UBI-027', 9, 'kiadva', 1, 'Költséghatékony router', '2025-02-11 10:45:00', '2025-02-11 10:45:00'),
(28, 'ASUS RT-AX88U', 'router', 'RT-ASUS-028', 6, 'szerelés alatt', 0, 'WiFi 6 router, firmware frissítés', '2025-02-12 11:20:00', '2025-02-12 11:20:00'),
(29, 'Dell PowerEdge R540', 'szerver', 'SRV-DELL-029', 3, 'kiadható', 0, 'Storage szerver', '2025-02-13 12:30:00', '2025-02-13 12:30:00'),
(30, 'HPE ProLiant ML350', 'szerver', 'SRV-HPE-030', 10, 'kiadva', 1, 'Tower szerver', '2025-02-14 13:45:00', '2025-02-14 13:45:00'),
(31, 'Lenovo ThinkStation P340', 'gép', 'PC-LEN-031', 2, 'kiadható', 0, 'Workstation CAD/CAM', '2025-02-15 14:15:00', '2025-02-15 14:15:00'),
(32, 'HP Z4 G4 Workstation', 'gép', 'PC-HP-032', 7, 'kiadva', 1, 'Rendering workstation', '2025-02-16 15:00:00', '2025-02-16 15:00:00'),
(33, 'Surface Laptop Studio', 'laptop', 'LAP-MS-033', 4, 'kiadható', 0, 'Kreatív laptop érintőképernyővel', '2025-02-17 08:30:00', '2025-02-17 08:30:00'),
(34, 'HP EliteBook 850 G8', 'laptop', 'LAP-HP-034', 8, 'kiadva', 1, 'Prémium üzleti laptop', '2025-02-18 09:15:00', '2025-02-18 09:15:00'),
(35, 'ASUS ProArt Display', 'monitor', 'MON-ASUS-035', 5, 'kiadható', 0, 'Színpontos monitor grafikusoknak', '2025-02-19 10:00:00', '2025-02-19 10:00:00'),
(36, 'BenQ PD3220U', 'monitor', 'MON-BEN-036', 1, 'kiadva', 1, '32" 4K designer monitor', '2025-02-20 11:30:00', '2025-02-20 11:30:00'),
(37, 'Xerox WorkCentre 6515', 'nyomtató', 'PRT-XER-037', 9, 'kiadható', 0, 'Színes multifunkciós nyomtató', '2025-02-21 12:45:00', '2025-02-21 12:45:00'),
(38, 'Ricoh MP C3004', 'nyomtató', 'PRT-RIC-038', 6, 'selejtezett', 0, 'Régi fénymásoló, javíthatatlan', '2025-02-22 13:20:00', '2025-02-22 13:20:00'),
(39, 'Xiaomi Redmi Note 12', 'telefon', 'PHN-XIA-039', 3, 'kiadható', 0, 'Dolgozói telefon', '2025-02-23 14:00:00', '2025-02-23 14:00:00'),
(40, 'Motorola Edge 40', 'telefon', 'PHN-MOT-040', 10, 'kiadva', 1, 'Terepi munka telefon', '2025-02-24 15:15:00', '2025-02-24 15:15:00'),
(41, 'Aruba 2530-24G', 'switch', 'SW-ARU-041', 2, 'kiadható', 0, '24 portos enterprise switch', '2025-02-25 08:45:00', '2025-02-25 08:45:00'),
(42, 'Juniper EX2300-24T', 'switch', 'SW-JUN-042', 7, 'kiadva', 1, 'Managed L3 switch', '2025-02-26 09:30:00', '2025-02-26 09:30:00'),
(43, 'Fortinet FortiGate 60F', 'router', 'RT-FOR-043', 4, 'kiadható', 0, 'UTM firewall router', '2025-02-27 10:15:00', '2025-02-27 10:15:00'),
(44, 'pfSense APU2', 'router', 'RT-PFS-044', 8, 'kiadva', 1, 'Open source router', '2025-02-28 11:00:00', '2025-02-28 11:00:00'),
(45, 'Supermicro SuperServer', 'szerver', 'SRV-SUP-045', 5, 'szerelés alatt', 0, 'HDD csere folyamatban', '2025-03-01 12:30:00', '2025-03-01 12:30:00'),
(46, 'Intel NUC 12 Pro', 'gép', 'PC-INT-046', 9, 'kiadható', 0, 'Kompakt mini PC', '2025-03-02 13:15:00', '2025-03-02 13:15:00'),
(47, 'Framework Laptop', 'laptop', 'LAP-FRA-047', 1, 'kiadva', 1, 'Moduláris laptop', '2025-03-03 14:45:00', '2025-03-03 14:45:00'),
(48, 'MSI Creator Z16', 'laptop', 'LAP-MSI-048', 6, 'kiadható', 0, 'Content creation laptop', '2025-03-04 15:30:00', '2025-03-04 15:30:00'),
(49, 'AOC CU34G2X', 'monitor', 'MON-AOC-049', 3, 'kiadva', 1, '34" ultrawide gaming monitor', '2025-03-05 08:00:00', '2025-03-05 08:00:00'),
(50, 'Kyocera ECOSYS P2235', 'nyomtató', 'PRT-KYO-050', 10, 'kiadható', 0, 'Környezetbarát lézer nyomtató', '2025-03-06 09:30:00', '2025-03-06 09:30:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `entity` varchar(50) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `entity`, `entity_id`, `details`, `created_at`) VALUES
(1, 1, 'create', 'device', 1, '{\"data\":{\"device_name\":\"Dell PowerEdge R730\",\"device_type\":\"szerver\",\"serial_number\":\"SRV-DELL-001\",\"company_id\":1,\"status\":\"kiadva\",\"is_invoiced\":1,\"description\":\"Virtualizációs szerver, 64GB RAM\"}}', '2025-01-16 08:00:00'),
(2, 1, 'update', 'device', 5, '{\"changes\":[{\"field\":\"status\",\"old\":\"kiadható\",\"new\":\"kiadva\"}]}', '2025-01-20 14:00:00'),
(3, 2, 'create', 'company', 5, '{\"data\":{\"name\":\"DigitalWorks Kft.\",\"address\":\"Széchenyi tér 12\",\"city\":\"Győr\",\"contact_person\":\"Tóth László\",\"contact_email\":\"laszlo.toth@digitalworks.hu\",\"contact_phone\":\"+36 96 555 666\"}}', '2025-04-12 14:30:00'),
(4, 1, 'update', 'device', 7, '{\"changes\":[{\"field\":\"status\",\"old\":\"kiadható\",\"new\":\"szerelés alatt\"},{\"field\":\"description\",\"old\":\"Üzleti laptop\",\"new\":\"Billentyűzet csere szükséges\"}]}', '2025-01-22 16:00:00'),
(5, 2, 'update', 'device', 38, '{\"changes\":[{\"field\":\"status\",\"old\":\"kiadva\",\"new\":\"selejtezett\"}]}', '2025-02-22 14:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rendszergazda', 'admin', '2025-01-15 08:00:00'),
(2, 'user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Felhasználó', 'user', '2025-01-15 08:05:00');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `company_id` (`company_id`);

--
-- A tábla indexei `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT a táblához `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Megkötések a táblához `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;