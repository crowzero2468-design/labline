-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2026 at 05:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cancelledaccount`
--

CREATE TABLE `tb_cancelledaccount` (
  `id` int(11) NOT NULL,
  `Clinic` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `machine` varchar(255) NOT NULL,
  `Date_Found_out` date NOT NULL,
  `Date_confirmed` date NOT NULL,
  `Personnel` varchar(255) NOT NULL,
  `Reason` varchar(255) NOT NULL,
  `Supplier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_contract`
--

CREATE TABLE `tb_contract` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_data`
--

CREATE TABLE `tb_data` (
  `id` int(11) NOT NULL,
  `Clinic_name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Province` varchar(255) NOT NULL,
  `Machine` varchar(255) NOT NULL,
  `Installed_date` date NOT NULL,
  `SN` varchar(255) NOT NULL,
  `Model` varchar(255) NOT NULL,
  `DR_Number` varchar(255) NOT NULL,
  `status` text NOT NULL,
  `contract_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_data`
--

INSERT INTO `tb_data` (`id`, `Clinic_name`, `Address`, `Province`, `Machine`, `Installed_date`, `SN`, `Model`, `DR_Number`, `status`, `contract_id`) VALUES
(1, 'Amazing Grace Diagnostic and Medical Services', 'Ilagan City', 'Isabela', 'Hematology', '2016-03-16', '751208150934', 'KT- 6400', '', 'A', 0),
(2, 'Animal Options Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Hematology', '2016-03-16', '', 'KTVET-6180', '', 'A', 0),
(3, 'Isabela Animates Veterinary Clinic', 'Cauayan City', 'Isabela', 'Hematology', '2016-03-16', '771027161510', 'KTVET-6180', '', 'A', 0),
(4, 'Regional Animal Disease Diagnostic Laboratory', 'Tuguegarao City', 'Cagayan', 'Hematology', '2016-03-16', '', 'KTVET-6180', '', 'A', 0),
(5, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'Isabela', 'Hematology', '2016-03-16', '', 'KTVET-6180', '', 'A', 0),
(6, 'Animedics Veterinary Clinic', 'Bambang', 'Nueva Vizcaya', 'Hematology', '2019-04-06', '0740305193348', 'KTVET-6300', 'AR0041-2019', 'A', 0),
(7, 'Urban Fur Vet Clinic', 'Tuguegarao City', 'Cagayan', 'Hematology', '2019-04-20', '', 'KTVET-6300', 'AR0042-2019', 'A', 0),
(8, 'Pet Terrific Veterinary Clinic', 'Talavera', 'Nueva Ecija', 'Hematology', '2019-06-11', '', 'KTVET-6300', 'AR0060-2019', 'A', 0),
(9, 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Hematology', '2019-07-11', '', 'KTVET-6300', 'AR0074-2019', 'A', 0),
(10, 'Canine-Feline Veterinary Clinic/ Cape Bolinao Veterinary', 'Alaminos City', 'Pangasinan', 'Hematology', '2019-08-06', '', 'KTVET-6300', 'AR0095-2019', 'A', 0),
(11, 'Vets for Pets Animal Clinic', 'Dingras', 'Ilocos Norte', 'Hematology', '2019-09-20', '0740827193878', 'KTVET-6300', 'AR0119-2019', 'A', 0),
(12, 'Nose to Tail Veterinary Clinic', 'Pozzorubio', 'Pangasinan', 'Hematology', '2019-12-02', '', 'KTVET-6300', 'AR0154-2019', 'A', 0),
(13, 'Primecare Animal Recovery Clinic', 'San Fernando', 'La Union', 'Hematology', '2020-07-25', '', 'KTVET-6300', 'DR160', 'A', 0),
(14, 'Nose to Tail Veterinary Clinic', 'Tayug', 'Pangasinan', 'Xray', '2020-07-26', '', 'Portable Xray', 'DR162', 'A', 0),
(15, 'AR Veterinary Clinic', 'Tabuk City', 'Kalinga', 'Hematology', '2020-07-27', '0740628204422', 'KTVET-6300', 'DR164', 'A', 0),
(16, 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Chemistry', '2020-08-28', '21999', 'CV5', 'DR175', 'A', 0),
(17, 'AR Veterinary Clinic', 'Tabuk City', 'Kalinga', 'Hematology', '2020-08-28', '0740727204523', 'KTVET-6300', 'DR177', 'A', 0),
(18, 'Daddy Doc Veterinary Clinic', 'Cabatuan', 'Isabela', 'Hematology', '2020-08-28', '740727204524', 'KTVET-6300', 'DR232', 'A', 0),
(19, 'Pet Terrific Veterinary Clinic', 'Talavera', 'Nueva Ecija', 'Ultrasound', '2020-09-11', '', 'SS-9 Sonostar', 'DR184', 'A', 0),
(20, 'Nose to Tail Veterinary Clinic', 'Tayug', 'Pangasinan', 'Chemistry', '2020-09-22', '22084', 'CV5', 'DR193', 'A', 0),
(21, 'The Shepherd Vet Clinic/ Nose To tail Vet. Clinic', 'Rosario', 'La Union', 'Hematology', '2020-09-22', '0740828204551', 'KTVET-6300', 'DR193', 'A', 0),
(22, 'Animedics Veterinary Clinic', 'Solano', 'Nueva Vizcaya', 'Chemistry', '2020-10-21', '22130', 'CV5', 'DR207', 'A', 0),
(23, 'Pets Place(Animedics) Veterinary Clinic', 'Aritao', 'Nueva Vizcaya', 'Hematology', '2020-10-21', '0740828204562', 'KTVET-6300', 'DR211', 'A', 0),
(24, 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Vet Monitor', '2020-10-22', '', 'Zetop', 'DR213', 'A', 0),
(25, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'Isabela', 'Chemistry', '2020-10-24', '22131', 'CV5', 'DR214', 'A', 0),
(26, 'Primecare Animal Recovery Clinic', 'San Fernando', 'La Union', 'Chemistry', '2020-11-10', '22117', 'CV5', 'DR224', 'A', 0),
(27, 'Animal Haven Veterinary Clinic', 'La Trinidad', 'Benguet', 'Chemistry', '2020-11-11', '22116', 'CV5', 'DR228', 'A', 0),
(28, 'Animal Haven Veterinary Clinic', 'La Trinidad', 'Benguet', 'Hematology', '2020-11-24', '0741015204611', 'KTVET-6300', 'DR235', 'A', 0),
(29, 'Animal Options Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Chemistry', '2020-11-27', '22161', 'CV5', 'DR240', 'A', 0),
(30, 'JPecdaen Veterinary Clinic', 'Tagum City', 'Davao Del Norte', 'Chemistry', '2020-12-24', '22081', 'CV5', 'DR202', 'A', 0),
(31, 'JPecdaen Veterinary Clinic', 'Tagum City', 'Davao Del Norte', 'Hematology', '2021-01-11', '0740828204530', 'KTVET-6300', 'DR259', 'A', 0),
(32, 'Petmax Veterinary Clinic', 'Agoo', 'La Union', 'Hematology', '2021-02-11', '0860108210997', 'VH30', 'DR282', 'A', 0),
(33, 'Pet Terrific Veterinary Clinic', 'Talavera', 'Nueva Ecija', 'Chemistry', '2021-02-17', '22295', 'CV5', 'DR289', 'A', 0),
(34, 'Pet Essentials Veterinary Clinic', 'Binalonan', 'La Union', 'Hematology', '2021-03-14', '0860223211086', 'VH30', 'DR302', 'A', 0),
(35, 'Vets for Pets Animal Clinic', 'Laoag City', 'Ilocos Norte', 'Chemistry', '2021-03-17', '22654', 'CV5', 'DR310', 'A', 0),
(36, 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Ultrasound', '2021-03-29', '0121250115004N0004', 'BW-U6', 'DR317', 'A', 0),
(37, 'Urban Fur Vet Clinic', 'Tuguegarao City', 'Cagayan', 'Chemistry', '2021-04-12', '22676', 'CV5', 'DR323', 'A', 0),
(38, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'Isabela', 'Ultrasound', '2021-05-16', '', 'BW-U6', 'DR353', 'A', 0),
(39, 'Aurora State College of Technology', 'Maria Aurora', 'Aurora', 'Hematology', '2021-06-09', '08B0520211410', 'VH30', 'DR404', 'A', 0),
(40, 'Petmax Veterinary Clinic', 'Agoo', 'La Union', 'Chemistry', '2021-06-11', '22976', 'CV5', 'DR405', 'A', 0),
(41, 'Nose to Tail Veterinary Clinic', 'Calasiao', 'Pangasinan', 'Chemistry', '2021-06-23', '22987', 'CV5', 'DR389', 'A', 0),
(42, 'Nose to Tail Veterinary Clinic', 'Calasiao', 'Pangasinan', 'Hematology', '2021-06-23', '860520211414', 'VH30', 'DR389', 'A', 0),
(43, 'Clinica Animalia Veterinary Clinic', 'Echague', 'Isabela', 'Hematology', '2021-07-14', '0860603211458', 'VH30', 'DR423', 'A', 0),
(44, 'The Shepherd Vet Clinic/ Nose To tail Vet. Clinic', 'Rosario', 'La Union', 'Chemistry', '2021-07-16', '23189', 'CV5', 'DR433', 'A', 0),
(45, 'Clinica Animalia Veterinary Clinic', 'Roxas', 'Isabela', 'Hematology', '2021-07-20', '0860603211485', 'VH30', 'DR453', 'A', 0),
(46, 'Urban Fur Vet Clinic', 'Tuguegarao City', 'Cagayan', 'Ultrasound', '2021-07-21', '', 'BW-U6', 'DR455', 'A', 0),
(47, 'Animedics Veterinary Clinic', 'Bagabag', 'Nueva Vizcaya', 'Hematology', '2021-08-19', '0860416200531', 'VH30', 'DR478', 'A', 0),
(48, 'Doc Jay Veterinary Clinic and Supply/ Jhay Vet. Clinic', 'Cabatuan', 'Isabela', 'Hematology', '2021-09-11', '08B0818210036', 'VH30', 'AR0019-2021', 'A', 0),
(49, 'Buena Vida Animal Clinic', 'Sta. Rosa', 'Nueva Ecija', 'Hematology', '2021-09-22', '08B0909240799', 'VH30', 'DR489', 'A', 0),
(50, 'Capitol Veterinary Clinic', 'San Fernando', 'Pampanga', 'Hematology', '2021-09-25', '08B0818210037', 'VH30', 'AR0035-2021', 'A', 0),
(51, 'Animedics Veterinary Clinic', 'Solano', 'Nueva Vizcaya', 'Hematology', '2021-10-07', '08B0915210052', 'VH30', 'DR494', 'A', 0),
(52, 'JMW Animal Clinic', 'Cabagan', 'Isabela', 'Hematology', '2021-10-18', '08B0915210055', 'VH30', 'DR505', 'A', 0),
(53, 'Bulanao Veterinary Clinic', 'Tabuk City', 'Kalinga', 'Hematology', '2021-10-25', '08b0915210058', 'VH30', 'DR517', 'A', 0),
(54, 'Vet Connections Animal Clinic/ Noah\'s Ark Animal Clinic', 'Cabanatuan/ Gapan', 'Nueva Ecija', 'Hematology', '2021-11-23', '08B1022210135', 'VH30', 'DR530', 'A', 0),
(55, 'Faithful Friend Vet Clinic', 'Baguio City', 'Benguet', 'Hematology', '2021-12-08', '08B0927210098', 'VH30', 'DR573', 'A', 0),
(56, 'Noble Pets Veterinary Clinic', 'San Fernando', 'Pampanga', 'Chemistry', '2021-12-15', '24246', 'CV5', 'DR576', 'A', 0),
(57, 'PetHealth Care Vet Clinic', 'Agoo', 'La Union', 'Hematology', '2022-01-06', '08B1022210117', 'VH30', 'DR006', 'A', 0),
(58, 'Faithful Friend Vet Clinic', 'Baguio City', 'Benguet', 'Chemistry', '2022-02-04', '24257', 'CV5', '', 'A', 0),
(59, 'A_B Housevet Animal Clinic', 'Olongapo City', 'Zambales', 'Hematology', '2022-03-05', '08B1022210132', 'VH30', 'DR\'082', 'A', 0),
(60, 'Maple Vet Clini', 'Guimba', 'Nueva Ecija', 'Hematology', '2022-04-12', '08B1230210178', 'VH30', 'DR165', 'A', 0),
(61, 'Bulanao Veterinary Clinic', 'Tabuk City', 'Kalinga', 'Chemistry', '2022-04-25', '24270', 'CV5', 'DR214', 'A', 0),
(62, 'Gopez Veterinary Clinic', 'Arayat', 'Pampanga', 'Hematology', '2022-05-13', '08B0416220218', 'VH30', 'DR174', 'A', 0),
(63, 'Urban Pets vet Clinic', 'Baguio City', 'Benguet', 'Hematology', '2022-05-14', '08B0416220219', 'VH30', 'DR234', 'A', 0),
(64, 'Pet Landia Animal Clinic', 'Gen. Tinio', 'Nueva Ecija', 'Hematology', '2022-05-26', '08B0416220204', 'VH30', 'DR194', 'A', 0),
(65, 'Francis Paul Benedict Vet Clinic', 'Vigan City', 'Ilocos Sur', 'Hematology', '2022-05-31', '08B416220256', 'VH30', 'DR196', 'A', 0),
(66, 'Vet Grace Animal Clinic', 'Agoo', 'La Union', 'Hematology', '2022-06-20', '08B0416220209', 'VH30', 'DR322', 'A', 0),
(67, 'JC Paws & Claws Veterinary Clinic', 'Batac', 'Ilocos Sur', 'Chemistry', '2022-06-22', '24152', 'CV5', 'DR327', 'A', 0),
(68, 'Bark Avenue Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Chemistry', '2022-07-12', '24818', 'CV5', 'DR346', 'A', 0),
(69, 'Kho Veterinary Clinic', 'Daet', 'Camarines Norte', 'Hematology', '2022-07-12', '08B062S220277', 'VH30', 'DR300', 'A', 0),
(70, 'Doc Sharon Veterinary Clinic', 'Cauayan City', 'Isabela', 'Hematology', '2022-07-12', '08B0628220259', 'VH30', 'DR245', 'A', 0),
(71, 'Animal Aide Veterinary Supplies and Services', 'Ozamis City', 'Misamis Occidental', 'Chemistry', '2022-07-12', '24812', 'CV5', 'DR299', 'A', 0),
(72, 'Vet Next Door Animal Clinic', 'Lupao', 'Ecija', 'Hematology', '2022-07-14', '08B0628220271', 'VH30', 'DR350', 'A', 0),
(73, 'The Pet Pro Veterinary Clinic', 'Baguio City', 'Benguet', 'Chemistry', '2022-07-16', '24810', 'CV5', 'DR354', 'A', 0),
(74, 'AMD Pets and Vets Clinic', 'San Fabian', 'Pangasinan', 'Hematology', '2022-07-26', '08B0628220263', 'VH30', 'DR248', 'A', 0),
(75, 'Pet Central Veterinary Clinic', 'San Isidro', 'Nueva Ecija', 'Hematology', '2022-07-26', '08B0628220273', 'VH30', 'DR412', 'A', 0),
(76, 'Jamel Vets and Furries Animal Clinic', 'Botolan', 'Zambales', 'Hematology', '2022-07-27', '08B0628220272', 'VH30', 'DR416', 'A', 0),
(77, 'Jamel Vets and Furries Animal Clinic', 'Botolan', 'Zambales', 'Chemistry', '2022-07-27', '24965', 'CV5', 'DR416', 'A', 0),
(78, 'De Oro Pets Veterinary Clinic', 'Nabunturan', 'Davao De Oro', 'Hematology', '2022-08-08', '08B0628220276', 'VH30', 'DR419', 'A', 0),
(79, 'Velvet Animal Clinic', 'Luna', 'La Union', 'Hematology', '2022-08-09', '08B0628220275', 'VH30', 'DR505', 'A', 0),
(80, 'JC Paws & Claws Veterinary Clinic', 'Batac', 'Ilocos Sur', 'Hematology', '2022-08-10', '08b0628220274', 'VH30', 'DR506', 'A', 0),
(81, 'Pets Vetfriend Veterinary Clinic', 'Guimba', 'Nueva Ecija', 'Hematology', '2022-08-30', '08B0416220189', 'VH30', 'DR438', 'A', 0),
(82, 'Alicia Animal Clinic', 'Alicia', 'Isabela', 'Hematology', '2022-09-05', '08B0416220191', 'VH30', 'DR497', 'A', 0),
(83, 'Alicia Animal Clinic', 'Alicia', 'Isabela', 'Chemistry', '2022-09-05', '24978', 'CV5', 'DR497', 'A', 0),
(84, 'Paws and Claws Veterinary Clinic', 'Camalaniugan', 'Cagayan', 'Hematology', '2022-09-07', '08B0628220256', 'VH30', 'DR499', 'A', 0),
(85, 'Aso at Pusa Veterinary Clinic', 'Bangued', 'Abra', 'Hematology', '2022-09-08', '08B0628220242', 'VH30', 'DR554', 'A', 0),
(86, 'Animal Options Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Ultrasound', '2022-09-28', '1122943114CTOXN0003', 'M5 Vet', 'DR515', 'A', 0),
(87, 'Vet Connections Animal Clinic', 'Cabanatuan', 'Nueva Ecija', 'Xray', '2022-10-13', 'F05P5697', 'DR V5', 'DR369', 'A', 0),
(88, 'Quirino Pet House', 'Diffun', 'Quirino', 'Hematology', '2022-10-18', '08B0628220247', 'VH30', 'DR523', 'A', 0),
(89, 'Pets Line Animal Clinic', 'Mexico', 'Pampanga', 'Hematology', '2022-10-25', '08B0813220302', 'VH30', 'DR617', 'A', 0),
(90, 'Winterfell Veterinary Clinic', 'Bontoc', 'Mountain Province', 'Hematology', '2022-10-27', '08B0813220299', 'VH30', 'DR652', 'A', 0),
(91, 'Pets Line Animal Clinic', 'Mexico', 'Pampanga', 'Ultrasound', '2022-11-18', 'H22943114CTOXN0002', 'M5 Vet', 'DR629', 'A', 0),
(92, 'Pets Choice Veterinary Clinic', 'Bauang', 'La Union', 'Hematology', '2022-12-08', '08B1017220329', 'VH30', 'DR635', 'A', 0),
(93, 'Bauang Vet Care Clinic', 'Bauang', 'La Union', 'Hematology', '2022-12-08', '08B1017220354', 'VH30', 'DR390', 'A', 0),
(94, 'Vet Tag Animal Clinic', 'Solano/Bambang', 'Nueva Vizcaya', 'Hematology', '2022-12-10', '08B1017220336', 'VH30', 'DR391', 'A', 0),
(95, 'Doc Gregg Veterinary Clinic', 'Olongapo City', 'Zambales', 'Hematology', '2022-12-12', '08B1017220340', 'VH30', 'DR637', 'A', 0),
(96, 'Nose to Tail Veterinary Clinic', 'Tayug', 'Pangasinan', 'Xray', '2022-12-14', 'F05P56F4', 'DR V5', 'DR540', 'A', 0),
(97, 'Pet Landia Animal Clinic', 'Gen. Tinio', 'Nueva Ecija', 'Ultrasound', '2022-12-15', 'H229431146TOXN001', 'M5 Vet', 'DR543', 'A', 0),
(98, 'Dumalsin Veterinary Clinic', 'Bontoc', 'Mountain Province', 'Hematology', '2022-12-19', '08B1017220367', 'VH30', 'DR395', 'A', 0),
(99, 'Winterfell Veterinary Clinic', 'Bontoc', 'Mountain Province', 'Chemistry', '2022-12-20', '27074', 'CV5', 'DR397', 'A', 0),
(100, 'Solana Pets Veterinary Clinic', 'Solana', 'Cagayan', 'Hematology', '2022-12-23', '08B1017220330', 'VH30', 'DR547', 'A', 0),
(101, 'Pet Essentials Veterinary Clinic', 'Rosales', 'Pangasinan', 'Xray', '2023-01-05', 'F05P571F', 'DR V5', 'DR719', 'A', 0),
(102, 'Jhay Veterinary Clinic', 'Cabatuan', 'Isabela', 'Chemistry', '2023-01-16', '27418', 'CV5', 'DR807', 'A', 0),
(103, 'Clinica Animalia Veterinary Clinic', 'Tumauini', 'Isabela', 'Hematology', '2023-01-16', '08B1017220335', 'VH30', 'DR806', 'A', 0),
(104, 'Vets for Pets Animal Clinic', 'Laoag City', 'Ilocos Norte', 'Hematology', '2023-01-18', '08B1017220329', 'VH30', 'DR810', 'A', 0),
(105, 'Pet Central Veterinary Clinic', 'San Isidro', 'Nueva Ecija', 'Chemistry', '2023-01-18', '27421', 'CV5', 'DR735', 'A', 0),
(106, 'Valley Vets Animal Clinic', 'San Fernando', 'La Union', 'Hematology', '2023-01-19', '08B1209220390', 'VH30', 'DR741', 'A', 0),
(107, 'Dr. Vien Veterinary Clinic', 'San Marcelino', 'Zambales', 'Hematology', '2023-01-19', '08B1209220388', 'VH30', 'DR765', 'A', 0),
(108, 'PetHealth Care Vet Clinic', 'Binalonan', 'Pangasinan', 'Hematology', '2023-01-25', '08B1209220386', 'VH30', 'DR909', 'A', 0),
(109, 'Pet Terrific Veterinary Clinic', 'Talavera', 'Nueva Ecija', 'Xray', '2023-02-06', 'F05P574D', 'DR V5', 'DR819', 'A', 0),
(110, 'The Pet Pro Veterinary Clinic', 'Baguio City', 'Benguet', 'Xray', '2023-02-07', 'F05P574A', 'DR V5', 'DR821', 'A', 0),
(111, 'Vet Connections Animal Clinic', 'Cabanatuan', 'Nueva Ecija', 'Chemistry', '2023-03-03', '27449', 'CV5', 'DR835', 'A', 0),
(112, 'Mustangs Veterinary Clinic', 'San Jose', 'Nueva Ecija', 'Hematology', '2023-03-03', '08B1209220378', 'VH30', 'DR784', 'A', 0),
(113, 'RMMN Animal Clinic/ Family Vet Animal Clinic', 'Baler/ La Trinidad', 'Aurora/ Benguet', 'Hematology', '2023-03-04', '08B1208220389', 'VH30', 'DR970', 'A', 0),
(114, 'Evexia Veterinary Clinic', 'Baguio City', 'Benguet', 'Hematology', '2023-03-04', '08B1209220385', 'VH30', 'DR838', 'A', 0),
(115, 'Pawfessional Veterinary Clinic', 'Rodriguez', 'Rizal', 'Hematology', '2023-03-06', '08B1209220384', 'VH30', 'DR786', 'A', 0),
(116, 'Peninsula Veterinary Clinic', 'Pilar', 'Bataan', 'Hematology', '2023-03-07', '08B1209220377', 'VH30', 'DR788', 'A', 0),
(117, 'Pet Palisades Veterinary Clinic', 'Talavera', 'Nueva Ecija', 'Hematology', '2023-03-16', '08B1209220376', 'VH30', 'DR847', 'A', 0),
(118, 'Niedo\'s Animal Clinic', 'Botolan', 'Zambales', 'Xray', '2023-03-24', 'F05P5754', 'DR V5', 'DR961', 'A', 0),
(119, 'Pet Adventure Animal Clinic', 'Sta Maria', 'Bulacan', 'Xray', '2023-03-25', 'F05P5760', 'DR V5', 'DR963', 'A', 0),
(120, 'Petfriends Veterinary Clinic', 'Rodriguez', 'Rizal', 'Chemistry', '2023-03-31', '27464', 'CV5', 'DR857', 'A', 0),
(121, 'Nose to Tail Veterinary Clinic', 'Tayug', 'Pangasinan', 'Hematology', '2023-04-24', '08B0224230441', 'VH30', 'DR1034', 'A', 0),
(122, 'Pets Place(Animedics) Veterinary Clinic', 'Dupax Del Norte', 'Nueva Vizcaya', 'Hematology', '2023-04-24', '08B0224230433', 'VH30', 'DR1033', 'A', 0),
(123, 'Urban Petcare Animal Clinic', 'Bangued', 'Abra', 'Hematology', '2023-04-26', '08B0224230444', 'VH30', 'DR1041', 'A', 0),
(124, 'Paws and Furs Animal Clinic', 'Moncada', 'Tarlac', 'Hematology', '2023-04-27', '08B0224230445', 'VH30', 'DR882', 'A', 0),
(125, 'Happy Tails Pet Care Clinic / Pampang Animal Clinic', 'Angeles City', 'Pampanga', 'Hematology', '2023-04-28', '08B0224230416', 'VH30', 'DR883', 'A', 0),
(126, 'Movet Petcare Inc', 'Baguio City', 'Benguet', 'Xray', '2023-05-11', '', 'DR V5', 'DR1105', 'A', 0),
(127, 'Noble Pets Veterinary Clinic', 'San Fernando', 'Pampanga', 'Hematology', '2023-05-23', '08B0427230493', 'VH30', 'DR1265', 'A', 0),
(128, 'D and R Dog Cat Clinic', 'Calasiao', 'Pangasinan', 'Hematology', '2023-05-24', '08B0426230490', 'VH30', 'DR1266', 'A', 0),
(129, 'Manaoag Veterinary Clinic', 'Manaoag', 'Pangasinan', 'Hematology', '2023-05-24', '08B0427230492', 'VH30', 'DR1267', 'A', 0),
(130, 'Elyu Veterinary Clinic', 'San Juan', 'La Union', 'Hematology', '2023-05-25', '08B0427230487', 'VH30', 'DR1268', 'A', 0),
(131, 'Vetsquad Animal Clinic', 'Pugo', 'La Union', 'Hematology', '2023-05-25', '08B0427230491', 'VH30', 'DR1269', 'A', 0),
(132, 'Nose to Tail Veterinary Clinic', 'Asingan', 'Pangasinan', 'Hematology', '2023-05-31', '08B0427230488', 'VH30', 'DR1069', 'A', 0),
(133, 'Pet Alley Animal Clinic', 'San Jose', 'Nueva Ecija', 'Hematology', '2023-06-29', '08B0427230489', 'VH30', 'DR1096', 'A', 0),
(134, 'Pets Life Vet Clinic', 'Bagabag', 'Nueva Vizcaya', 'Chemistry', '2023-07-08', '27844', 'CV5', 'DR1120', 'A', 0),
(135, 'FMH Animal Clinic/ Tail buddy Animal Clinic', 'Las Pinas City', 'Metro Manila/ Batangas', 'Hematology', '2023-07-20', '08B0427230467', 'VH30', 'DR1173', 'A', 0),
(136, 'Pet Medix Vet Clinic', 'Arayat', 'Pampanga', 'Hematology', '2023-07-24', '08B0427230460', 'VH30', 'DR1297', 'A', 0),
(137, 'RMC Veterinary Clinic', 'San Mateo', 'Rizal', 'Hematology', '2023-07-28', '08B0427230474', 'VH30', 'DR1174', 'A', 0),
(138, 'RMC Veterinary Clinic', 'San Mateo', 'Rizal', 'Chemistry', '2023-07-28', '29227', 'CV5', 'DR1174', 'A', 0),
(139, 'Animal Corner Veterinary Clinic', 'Santiago City', 'Isabela', 'Hematology', '2023-07-31', '08B0427230480', 'VH30', 'DR1125', 'A', 0),
(140, 'Animal Corner Veterinary Clinic', 'Santiago City', 'Isabela', 'Urine Analyzer', '2023-07-31', 'MA21060090087', 'VU10', 'DR1125', 'A', 0),
(141, 'Pet Vet Tumauini Animal Clinic', 'Tumauini', 'Isabela', 'Urine Analyzer', '2023-08-01', '', 'VU10', 'DR1126', 'A', 0),
(142, 'Pet Vet Tumauini Animal Clinic', 'Tumauini', 'Isabela', 'Hematology', '2023-08-01', '08B0427230471', 'VH30', 'DR1126', 'A', 0),
(143, 'Jamel Vets and Furries Animal Clinic', 'Sta. Cruz', 'Zambales', 'Hematology', '2023-08-10', '08B0427230473', 'VH30', 'DR1183', 'A', 0),
(144, 'Jamel Vets and Furries Animal Clinic', 'Sta. Cruz', 'Zambales', 'Urine Analyzer', '2023-08-10', 'Ma211000100012', 'VU10', 'DR1183', 'A', 0),
(145, 'Naki Veterinary Clinic', 'Tagudin', 'Ilocos Sur', 'Urine Analyzer', '2023-08-16', '', 'VU10', 'DR1314', 'A', 0),
(146, 'Naki Veterinary Clinic', 'Tagudin', 'Ilocos Sur', 'Hematology', '2023-08-16', '08B0427230472', 'VH30', 'DR1314', 'A', 0),
(147, 'Doc Hero Veterinary Clinic', 'Cauayan City', 'Isabela', 'Hematology', '2023-08-19', '', 'VH30', 'DR1318', 'A', 0),
(148, 'Doc Hero Veterinary Clinic', 'Cauayan City', 'Isabela', 'Urine Analyzer', '2023-08-19', '', 'VU10', 'DR1318', 'A', 0),
(149, 'Healmark Vet Services/ Vetwise Animal Clinic', 'Tagudin/ Candon', 'Ilocos Sur', 'Hematology', '2023-08-29', '08B0706230545', 'VH30', 'DR1215', 'A', 0),
(150, 'Rural Vet Clinic', 'San Fabian', 'Pangasinan', 'Chemistry', '2023-08-30', '29596', 'CV5', 'DR1216', 'A', 0),
(151, 'Animedics Veterinary Clinic', 'Bambang', 'Nueva Vizcaya', 'Chemistry', '2023-09-05', '29594', 'CV5', 'DR1218', 'A', 0),
(152, 'Abaya Veterinary Clinic', 'Bangued', 'Abra', 'Hematology', '2023-09-07', '08B0708230536', 'VH30', 'DR1325', 'A', 0),
(153, 'Rue St. Roche Vet Clinic', 'San Pablo City', 'Laguna', 'Hematology', '2023-09-07', '08B0708230532', 'VH30', 'DR1224', 'A', 0),
(154, 'Rue St. Roche Vet Clinic', 'San Pablo City', 'Laguna', 'Chemistry', '2023-09-07', '29583', 'CV5', 'DR1224', 'A', 0),
(155, 'Rue St. Roche Vet Clinic', 'San Pablo City', 'Laguna', 'Urine Analyzer', '2023-09-07', 'MA21100010013', 'VU10', 'DR1224', 'A', 0),
(156, 'Galaxy Paws Animal Clinic', 'Caloocan', 'Metro Manila', 'Hematology', '2023-09-07', '08B0706230544', 'VH30', 'DR1221', 'A', 0),
(157, 'Vets Turf Animal Clinic', 'Candon', 'Ilocos Sur', 'Hematology', '2023-09-08', '08B0708230530', 'VH30', 'DR1326', 'A', 0),
(158, 'Mustangs Veterinary Clinic', 'San Jose', 'Nueva Ecija', 'Chemistry', '2023-09-15', '29663', 'CV5', 'DR1397', 'A', 0),
(159, 'Healmark Vet Services/ Vetwise Animal Clinic', 'Tagudin/ Candon', 'Ilocos Sur', 'Chemistry', '2023-09-20', '29653', 'CV5', 'DR1402', 'A', 0),
(160, 'Ecovet Animal Clinic', 'Ibaan', 'Batangas', 'Hematology', '2023-09-28', '08B0708230531', 'VH30', 'DR1226', 'A', 0),
(161, 'Edison Veterinary Services', 'Binan', 'Laguna', 'Xray', '2023-09-28', 'F05P05AA8', 'DR V5', 'DR1228', 'A', 0),
(162, 'PetHealth Care Vet Clinic', 'Binalonan', 'Pangasinan', 'Chemistry', '2023-09-29', '29637', 'CV5', 'DR1341', 'A', 0),
(163, 'Pets Line Animal Clinic', 'Mexico', 'Pampanga', 'Chemistry', '2023-09-29', '29640', 'CV5', 'DR1340', 'A', 0),
(164, 'Pets Life Vet Clinic', 'Bagabag', 'Nueva Vizcaya', 'Hematology', '2023-10-24', '08B1007230556', 'VH30', 'DR1506', 'A', 0),
(165, 'Rural Vet Clinic', 'San Fabian', 'Pangasinan', 'Hematology', '2023-10-25', '08B1007230562', 'VH30', 'DR1508', 'A', 0),
(166, 'The Pet Pro Veterinary Clinic', 'Baguio City', 'Benguet', 'Hematology', '2023-10-26', '08B1007230558', 'VH30', 'DR1509', 'A', 0),
(167, 'Pet Treasures Veterinary Clinic', 'Baguio City', 'Benguet', 'Urine Analyzer', '2023-11-01', '', 'VU10', 'DR1520', 'A', 0),
(168, 'Up North Veterinary Services', 'Tabuk City', 'Kalinga', 'Hematology', '2023-11-03', '08b1007230557', 'VH30', 'DR1229', 'A', 0),
(169, 'Medpaws Veterinary Clinic', 'Quezon City', 'Metro Manila', 'Hematology', '2023-11-11', '08B1007230560', 'VH30', 'DR1479', 'A', 0),
(170, 'Pet Treasures Veterinary Clinic', 'Baguio City', 'Benguet', 'Hematology', '2023-11-23', '08b1017220328', 'VH30', 'DR1520', 'A', 0),
(171, 'Pet Treasures Veterinary Clinic', 'Baguio City', 'Benguet', 'Chemistry', '2023-11-23', 'CV2310003202210479', 'CV5', 'DR1520', 'A', 0),
(172, 'Neervet Animal Clinic', 'Bacnotan', 'La Union', 'Chemistry', '2023-11-24', 'CV231000202210464', 'CV5', 'DR1523', 'A', 0),
(173, 'Neervet Animal Clinic', 'Bacnotan', 'La Union', 'Urine Analyzer', '2023-11-24', 'MA21100010060', 'VU10', 'DR1523', 'A', 0),
(174, 'Infanta Veterinary Clinic', 'Infanta', 'Quezon Province', 'Urine Analyzer', '2023-11-24', 'MA21100010028', 'VU10', 'DR1486', 'A', 0),
(175, 'Infanta Veterinary Clinic', 'Infanta', 'Quezon Province', 'Chemistry', '2023-11-24', '210467', 'CV5', 'DR1486', 'A', 0),
(176, 'Mustangs Veterinary Clinic', 'San Jose', 'Nueva Ecija', 'Xray', '2023-11-25', 'F05P5AF6', 'DR V5', 'DR1529', 'A', 0),
(177, 'Animedics Veterinary Clinic', 'Bambang', 'Nueva Vizcaya', 'Urine Analyzer', '2023-11-26', 'Ma21100010019', 'VU10', 'DR1532', 'A', 0),
(178, 'Vet Tag Animal Clinic', 'Solano', 'Nueva Vizcaya', 'Xray', '2023-11-26', 'F05P5AF8', 'DR V5', 'DR1530', 'A', 0),
(179, 'Pawfessional Veterinary Clinic', 'Rodriguez', 'Rizal', 'Ultrasound', '2023-11-27', 'J3251151cto32110001', 'B/W', 'DR1489', 'A', 0),
(180, 'Galaxy Paws Animal Clinic', 'Caloocan', 'Metro Manila', 'Urine Analyzer', '2023-11-28', 'Ma211000110014', 'VU10', 'DR1488', 'A', 0),
(181, 'Ecovet Animal Clinic', 'Ibaan', 'Batangas', 'Urine Analyzer', '2023-11-29', 'Ma21100010010', 'VU10', 'DR1487', 'A', 0),
(182, 'Rosario Vets Animal Clinic', 'Rosario', 'La Union', 'Hematology', '2023-11-29', '08B0628220255', 'VH30', 'DR1539', 'A', 0),
(183, 'Nose to Tail Veterinary Clinic', 'San Quintin', 'Pangasinan', 'Hematology', '2023-11-29', '08B1007230563', 'VH30', 'DR1536', 'A', 0),
(184, 'JC Paws & Claws Veterinary Clinic', 'Batac', 'Ilocos Sur', 'Xray', '2023-12-14', '', 'DR V5', 'DR1624', 'A', 0),
(185, 'Abaya Veterinary Clinic', 'Bangued', 'Abra', 'Urine Analyzer', '2023-12-15', 'Ma22070060015', 'VU10', 'DR1619', 'A', 0),
(186, 'Animal Corner Vet Clinic', 'Cauayan City', 'Isabela', 'Hematology', '2024-01-08', '08B0628220249', 'VH30', 'DR1853', 'A', 0),
(187, 'Mots Animal Clinic', 'Sta Rosa', 'Laguna', 'Hematology', '2024-01-26', '08B1017220327', 'VH30', 'DR1578', 'A', 0),
(188, 'Northern Valley Veterinary Clinic', 'Ilagan City', 'Isabela', 'Hematology', '2024-02-05', '08B1017220325', 'VH30', 'DR1891', 'A', 0),
(189, 'Pet Landia Animal Clinic', 'Gen. Tinio', 'Nueva Ecija', 'Chemistry', '2024-02-06', '210472', 'CV5', 'DR1701', 'A', 0),
(190, 'Rural Vet Clinic', 'San Fabian', 'Pangasinan', 'Urine Analyzer', '2024-02-13', 'MA21100010008', 'VU10', 'DR1709', 'A', 0),
(191, 'Rural Vet Clinic', 'San Fabian', 'Pangasinan', 'Urine Analyzer', '2024-02-13', 'MA21100010031', 'VU10', 'DR1709', 'A', 0),
(192, 'Pet Care Veterinary Clinic', 'Urdaneta', 'Pangasinan', 'Hematology', '2024-02-13', '08B1007230559', 'VH30', 'DR1708', 'A', 0),
(193, 'Pet Essentials Veterinary Clinic/ San Manuel Vet. Clinic', 'Rosales/ San Manuel', 'Pangasinan', 'Hematology', '2024-02-14', '08B101220321', 'VH30', 'DR1710', 'A', 0),
(194, 'Pet Essentials Veterinary Clinic/ San Manuel Vet. Clinic', 'Rosales/ San Manuel', 'Pangasinan', 'Chemistry', '2024-02-14', '210481', 'CV5', 'DR1710', 'A', 0),
(195, 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Xray', '2024-02-20', '', 'DR V5', 'DR1804', 'A', 0),
(196, 'Mots Animal Clinic', 'Sta Rosa', 'Laguna', 'Chemistry', '2024-02-27', '210470', 'CV5', 'DR1597', 'A', 0),
(197, 'Mots Animal Clinic', 'Sta Rosa', 'Laguna', 'Ultrasound', '2024-02-27', 'L32511510T032N0001', 'B/W', 'DR1597', 'A', 0),
(198, 'Pets Life Vet Clinic', 'Bagabag', 'Nueva Vizcaya', 'Urine Analyzer', '2024-03-05', 'MA21100010025', 'VU10', 'DR1930', 'A', 0),
(199, 'Vets Turf Animal Clinic', 'Candon', 'Ilocos Sur', 'Urine Analyzer', '2024-03-07', 'MA21100010050', 'VU10', 'DR1735', 'A', 0),
(200, 'Gambala Veterinary Clinic', 'Echague', 'Isabela', 'Hematology', '2024-03-11', '08B1017220322', 'VH30', 'DR1806', 'A', 0),
(201, 'Animal Corner Veterinary Clinic', 'Santiago City', 'Isabela', 'Chemistry', '2024-03-27', '210491', 'CV5', 'DR1755', 'A', 0),
(202, 'JMW Animal Clinic', 'Cabagan', 'Isabela', 'Chemistry', '2024-04-02', '210505', 'CV5', 'DR1810', 'A', 0),
(203, 'Howllistic Vet Clinic', 'San Fernando', 'Pampanga', 'Hematology', '2024-04-11', '08B1017220324', 'VH30', 'DR1667', 'A', 0),
(204, 'Jamel Vets and Furries Animal Clinic', 'San Felipe', 'Zambales', 'Hematology', '2024-04-12', '08B0628220250', 'VH30', 'DR1669', 'A', 0),
(205, 'Bauang Vet Care Clinic', 'Bauang', 'La Union', 'Chemistry', '2024-04-19', '210507', 'CV5', 'DR1824', 'A', 0),
(206, 'Northern Valley Veterinary Clinic', 'Ilagan City', 'Isabela', 'Chemistry', '2024-04-22', '210506', 'CV5', 'DR1951', 'A', 0),
(207, 'Vet Soucier Animal Clinic', 'Tarlac City', 'Tarlac', 'Xray', '2024-04-26', 'F05P5BIE', 'DR V5', 'DR1955', 'A', 0),
(208, 'Pines Veterinary Clinic', 'Baguio City', 'Benguet', 'Chemistry', '2024-04-30', '210500/200079', 'CV5/VP20', 'DR1830', 'A', 0),
(209, 'Pines Veterinary Clinic', 'Baguio City', 'Benguet', 'Hematology', '2024-04-30', '08B0628220246', 'VH30', 'DR1830', 'A', 0),
(210, 'Rural Vet Clinic', 'San Fabian', 'Pangasinan', 'Xray', '2024-05-01', 'V126032601000012', 'DRF V1', 'DR1834', 'A', 0),
(211, 'Vet Furpaws Pet Care Services/Pound for Hounds Vet. Clinic', 'Sta Maria/ Barihan Malolos', 'Bulacan', 'Hematology', '2024-05-12', '08B1017220323', 'VH30', 'DR1686', 'A', 0),
(212, 'Faith Pet Clinic', 'Santiago City', 'Isabela', 'Hematology', '2024-05-13', '08B1017220323', 'VH30', 'DR1839', 'A', 0),
(213, 'Pet Care Veterinary Clinic', 'Urdaneta', 'Pangasinan', 'Urine Analyzer', '2024-05-15', 'MA 21100010009', 'VU10', 'DR2016', 'A', 0),
(214, 'Cuddly Care Animal Clinic', 'Marikina City', 'Metro Manila', 'Hematology', '2024-05-16', '08B0628220357', 'VH30', 'DR1689', 'A', 0),
(215, 'Cuddly Care Animal Clinic', 'Marikina City', 'Metro Manila', 'Chemistry', '2024-05-16', '210470', 'CV5', 'DR1689', 'A', 0),
(216, 'NextDoor Pet Care Services', 'San Miguel', 'Bulacan', 'Hematology', '2024-05-17', '08B0628220253', 'VH30', 'DR1691', 'A', 0),
(217, 'Gentle Paws Animal Clinic', 'Bangar', 'La Union', 'Hematology', '2024-05-17', 'OBB1017220319', 'VH30', 'DR1848', 'A', 0),
(218, 'Gentle Paws Animal Clinic', 'Bangar', 'La Union', 'Chemistry', '2024-05-17', 'SN 210475', 'CV5', 'DR1848', 'A', 0),
(219, 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Urine Analyzer', '2024-05-28', 'MA21100010042', 'VU10', 'DR1799', 'A', 0),
(220, 'Doc Gregg Veterinary Clinic', 'Olongapo City', 'Zambales', 'Ultrasound', '2024-05-29', 'D4294311CTO03N0006', 'BW6', 'DR1699', 'A', 0),
(221, 'Doc Jen Veterinary Clinic', 'Sta. Maria', 'Bulacan', 'Hematology', '2024-06-28', '08B1213230655', 'VH30', 'DR1969', 'A', 0),
(222, 'Daddy Doc Veterinary Clinic', 'Cabatuan', 'Isabela', 'Chemistry', '2024-07-08', '6311012300050', 'VP20', 'DR2117', 'A', 0),
(223, 'AMD Pets and Vets Clinic', 'San Fabian', 'Pangasinan', 'Chemistry', '2024-07-09', '6110123200053', 'VP20', 'DR2121', 'A', 0),
(224, 'Pets Choice Veterinary Clinic', 'Bauang', 'La Union', 'Chemistry', '2024-07-10', '63110123200061', 'VP20', 'DR2068', 'A', 0),
(225, 'D and R Dog Cat Clinic', 'Calasiao', 'Pangasinan', 'UTZ', '2024-07-10', 'F4294311CT028N0002', 'M5 Vet', 'DR2070', 'A', 0),
(226, 'NextDoor Pet Care Services', 'San Miguel', 'Bulacan', 'Chemistry', '2024-07-16', '63110123200043', 'VP20', 'DR2175', 'A', 0),
(227, 'Gopets Veterinary Clinic', 'Baguio City', 'Benguet', 'Hematology', '2024-07-24', '08B0628220251', 'VH30', 'DR2140', 'A', 0),
(228, 'Furry Petfriends Veterinary Clinic', 'Tanza', 'Cavite', 'Hematology', '2024-07-27', '08B1213230668', 'VH30', 'DR2179', 'A', 0),
(229, 'Pet Champ Animal Clinic', 'Tanza', 'Cavite', 'Hematology', '2024-07-27', '08B1213230673', 'VH30', 'DR2178', 'A', 0),
(230, 'Carmona Veterinary Clinic', 'Carmona', 'Cavite', 'Hematology', '2024-07-30', '08B1213230669', 'VH30', 'DR2180', 'A', 0),
(231, 'Animal Haven Veterinary Clinic', 'La Trinidad', 'Benguet', 'Xray', '2024-08-01', 'F05R5E1F', '', 'DR2182', 'A', 0),
(232, 'Velvet Animal Clinic', 'Luna', 'La Union', 'Xray', '2024-08-01', 'F05R5E17', '', 'DR1981', 'A', 0),
(233, 'Binalonan Veterinary Clinic', 'Binalonan', 'Pangasinan', 'Xray', '2024-08-01', 'F05R5E2B', '', 'DR2181', 'A', 0),
(234, 'Valley Vets Animal Clinic', 'San Fernando', 'La Union', 'Chemistry', '2024-08-08', '\'063110123200039', 'VP20', '', 'A', 0),
(235, 'Valley Vets Animal Clinic', 'San Fernando', 'La Union', 'VU10', '2024-08-08', '\'Ma23090200029', '', '', 'A', 0),
(236, 'Agapet Animal Clinic', 'General Trias', 'Cavite', 'Hematology', '2024-08-08', '08B121323066', 'VH30', 'DR2184', 'A', 0),
(237, 'Vet Street Veterinary Cinic', 'Muñoz', 'Nueva Ecija', 'Hematology', '2024-08-09', '08B1213230680', 'VH30', 'DR2086', 'A', 0),
(238, 'Vet ni Bantay Animal Clinic', 'Bantay', 'Ilocos Sur', 'Hematology', '2024-09-06', '08B1213230682', 'VH30', 'DR2407', 'A', 0),
(239, 'Narvacan Veterinary Clinic', 'Narvacan', 'Ilocos Sur', 'Hematology', '2024-09-06', '08B1213230674', 'VH30', 'DR2408', 'A', 0),
(240, 'D and R Dog Cat Clinic', 'Sual', 'Pangasinan', 'Hematology', '2024-09-07', '08B1213230690', 'VH30', 'DR2359', 'A', 0),
(241, 'Petfriends Veterinary Clinic', 'General Trias', 'Cavite', 'Hematology', '2024-09-10', '08B1213230683', 'VH30', 'DR1993', 'A', 0),
(242, 'Medpaws Veterinary Clinic', 'Quezon City', 'Metro Manila', 'UTZ', '2024-09-12', 'F4251151CT032N0001', 'B/W', 'DR1994', 'A', 0),
(243, 'Bark Avenue Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Hematology', '2024-09-18', '08G1213230664', 'VH30', 'DR2189', 'A', 0),
(244, 'Pet Care Veterinary Clinic', 'Urdaneta', 'Pangasinan', 'Chemistry', '2024-09-24', '63110123200049', 'VP20', 'DR2422', 'A', 0),
(245, 'Pets Ville Veterinary Clinic', 'Laoc', 'Pangasinan', 'Hematology', '2024-09-24', '08B1213230663', 'VH30', 'DR2424', 'A', 0),
(246, 'Vetlane Animal Clinic', 'Quezon City', 'Metro Manila', 'Hematology', '2024-09-25', '08B1213230681', 'VH30', 'DR2192', 'A', 0),
(247, 'Pawfessional Veterinary Clinic', 'Rodriguez', 'Rizal', 'Chemistry', '2024-09-26', '63110123200066', 'VP20', 'DR1996', 'A', 0),
(248, 'Moergan and Friends Veterinary Clinic', 'Conception', 'Tarlac', 'Chemistry', '2024-09-30', '6311012320072', 'VP20', 'DR2365', 'A', 0),
(249, 'Moergan and Friends Veterinary Clinic', 'Conception', 'Tarlac', 'Hematology', '2024-09-30', '08B12132B0678', 'VH30', 'DR2366', 'A', 0),
(250, 'Zoe\'s Clapier Veterinary Clinic/ Salubrious Toptails Animal Clinic', 'Abucay/ Orion', 'Bataan', 'Hematology', '2024-10-10', '08B1213230688', 'VH30', 'DR2367', 'A', 0),
(251, 'Vetsquad Animal Clinic', 'Pugo', 'La Union', 'Chemistry', '2024-10-18', '63110123200076', 'VP20', 'DR2449', 'A', 0),
(252, 'Kanayunan Animal Clinic', 'Mangatarem', 'Pangasinan', 'Hematology', '2024-10-18', '08B1213230671', 'VH30', 'DR2450', 'A', 0),
(253, 'Kanayunan Animal Clinic', 'Mangatarem', 'Pangasinan', 'Chemistry', '2024-10-18', '63110123200093', 'VP20', 'DR2197', 'A', 0),
(254, 'Caden\'s Pet Care Veterinary Clinic', 'Sta. Ignacia', 'Tarlac', 'Hematology', '2024-10-24', '08B1213230677', 'VH30', 'DR2470', 'A', 0),
(255, 'Gentri Vetcare Animal Cliinic', 'General Trias', 'Cavite', 'Hematology', '2024-11-20', '08B1213230676', 'VH30', 'DR2265', 'A', 0),
(256, 'Gentri Vetcare Animal Cliinic', 'General Trias', 'Cavite', 'Chemistry', '2024-11-20', '63081823200082', 'VP20', 'DR2266', 'A', 0),
(257, 'Carmona Veterinary Clinic', 'Carmona', 'Cavite', 'Chemistry', '2024-11-23', '63090823200032', 'VP20', 'DR2267', 'A', 0),
(258, 'Franjels Veterinary Clinic', 'San Pedro', 'Laguna', 'Hematology', '2024-11-28', '08B1213230650', 'VH30', 'DR2268', 'A', 0),
(259, 'Annapolis Veterinary Care Center', 'San Juan', 'Metro Manila', 'Hematology', '2024-12-13', '08B1213230675', 'VH30', 'DR2285', 'A', 0),
(260, 'Paoay Animal Clinic', 'Paoay', 'Ilocos Norte', 'Hematology', '2025-01-15', 'D8B0909240823', 'VH30', 'DR2571', 'A', 0),
(261, 'Langkaan Animal Clinic', 'Dasmariñas', 'Cavite', 'Hematology', '2025-02-10', '08B0909240830', 'VH30', 'DR2761', 'A', 0),
(262, 'Golden Vet Animal Clinic', 'Imus', 'Cavite', 'Hematology', '2025-02-12', '08B0909240808', 'VH30', 'DR2762', 'A', 0),
(263, 'Golden Vet Animal Clinic', 'Imus', 'Cavite', 'Chemistry', '2025-02-12', '63110123200097', 'VP20', 'DR2763', 'A', 0),
(264, 'Mivet Veterinary Clinic', 'Tagaytay City', 'Cavite', 'Hematology', '2025-02-13', '08B1213230651', 'VH30', 'DR2764', 'A', 0),
(265, '3KE Pet Solution Animal Clinic', 'Kawit', 'Cavite', 'Hematology', '2025-02-17', '08B0224230440', 'VH30', 'DR2766', 'A', 0),
(266, '3KE Pet Solution Animal Clinic', 'Kawit', 'Cavite', 'Chemistry', '2025-02-17', '63110123200101', 'VP20', 'DR2767', 'A', 0),
(267, 'Pet Avenue Veterianry Clinic', 'Diffun', 'Quirino', 'Chemistry', '2025-02-17', '200051', 'VP20', 'DR2589', 'A', 0),
(268, 'Animal Access Veterinary Clinic', 'San Ildefenso', 'Bulacan', 'Chemistry', '2025-02-18', '63110123200083', 'VP20', 'DR2642', 'A', 0),
(269, 'Pet Circle Animal Clinic', 'San Fernando', 'Pampanga', 'Hematology', '2025-02-18', '08B0909240796', 'VH30', 'DR2640', 'A', 0),
(270, 'Collins Animal Clinic', 'Bayambang', 'Pangasinan', 'Hematology', '2025-02-21', '08B0909240797', 'VH30', 'DR2770', 'A', 0),
(271, 'Pet Stop Veterinary', 'Umingan', 'Pangasinan', 'Hematology', '2025-03-06', '08B0909240825', 'VH30', 'DR2813', 'A', 0),
(272, 'Pet Stop Veterinary', 'Umingan', 'Pangasinan', 'Urine Analyzer', '2025-03-06', 'MA23090200016', 'VU10', 'DR2813', 'A', 0),
(273, 'Pawprints Animal Clinic', 'General Trias', 'Cavite', 'Hematology', '2025-03-11', '08B0909240813', 'VH30', 'DR2772', 'A', 0),
(274, 'Pawprints Animal Clinic', 'General Trias', 'Cavite', 'Chemistry', '2025-03-11', '200012', 'VP20', 'DR2773', 'A', 0),
(275, 'Pawsetivety Veterinary Clinic', 'Pagbilao', 'Quezon Province', 'Hematology', '2025-03-13', '08B0909240803', 'VH30', 'DR2906', 'A', 0),
(276, 'Doctor Noah\'s Veterinary Clinic', 'Legazpi City', 'Albay', 'Chemistry', '2025-03-18', '63110123200104', 'VP20', 'DR2907', 'A', 0),
(277, 'Doctor Noah\'s Veterinary Clinic', 'Legazpi City', 'Albay', 'Hematology', '2025-03-18', '08B0909240814', 'VH30', 'DR2908', 'A', 0),
(278, 'B.V. Seda Animal Care Clininc', 'Lemery', 'Batangas', 'Chemistry', '2025-03-20', '200077', 'VP20', 'DR2777', 'A', 0),
(279, 'Vet Street Animal Medical Center / JMIC Animal Medical Center', 'Caloocan', 'Metro Manila', 'Hematology', '2025-03-20', '08B1213230672', 'VH30', 'DR2734', 'A', 0),
(280, 'Infanta Veterinary Clinic', 'Infanta', 'Quezon Province', 'Hematology', '2025-03-25', '08B090924807', 'VH30', 'DR2964', 'A', 0),
(281, 'BK Petaholic Animal Clinic', 'Kumintang Ilaya', 'Batangas', 'Hematology', '2025-04-02', '08B0909240800', 'VH30', 'DR2780', 'A', 0),
(282, 'Puppyko Animal Clinic', 'San Jose Del Monte', 'Bulacan', 'Hematology', '2025-04-02', '08B0909240802', 'VH30', 'DR3008', 'A', 0),
(283, 'B.V. Seda Animal Care Clininc', 'Lemery', 'Batangas', 'Hematology', '2025-04-03', '08B0909240799', 'VH30', 'DR2782', 'A', 0),
(284, 'Favors Animal Clinic', 'Reina Mercedes', 'Isabela', 'Hematology', '2025-04-03', '08B0909240826', 'VH30', 'DR2879', 'A', 0),
(285, 'Agoo Animal Clinic', 'Agoo', 'La Union', 'Hematology', '2025-04-05', '08B0909240816', 'VH30', 'DR2884', 'A', 0),
(286, 'Cats and Dogs Veterinary Clinic', 'Lingayen', 'Pangasinan', 'Hematology', '2025-04-05', '08B0909240822', 'VH30', 'DR2888', 'A', 0),
(287, 'M Street Pet Grooming & Animal Clinic', 'Alfonso', 'Cavite', 'Hematology', '2025-04-07', '08B0909240790', 'VH30', 'DR2783', 'A', 0),
(288, 'Nose to Tail Veterinary Clinic', 'Sta Maria', 'Pangasinan', 'Hematology', '2025-04-14', '08B0909240798', 'VH30', 'DR2840', 'A', 0),
(289, 'Cotton Tails Veterinary Clinic', 'Calamba', 'Laguna', 'Hematology', '2025-04-23', '08B0909240795', 'VH30', 'DR2917', 'A', 0),
(290, 'Doge & Cate Veterinary Clinic & Services', 'Calamba', 'Laguna', 'Hematology', '2025-04-23', '08B0909240806', 'VH30', 'DR2918', 'A', 0),
(291, 'Doge & Cate Veterinary Clinic & Services', 'Calamba', 'Laguna', 'Chemistry', '2025-04-23', '63110123200111', 'VP20', 'DR2919', 'A', 0),
(292, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'Isabela', 'Hematology', '2025-05-06', '08B0909240791', 'VH30', 'DR3056', 'A', 0),
(293, 'Psalms Paws Veterinary Clinic/ Bridgeway', 'Cardona/ Morong', 'Rizal', 'Hematology', '2025-05-07', '08B0909240793', 'VH30', 'DR2922', 'A', 0),
(294, 'Paw Spot Veterinary Clinic', 'Angeles City', 'Pampanga', 'Hematology', '2025-05-10', '08B090924805', 'VH30', 'DR3115', 'A', 0),
(295, 'Paw Spot Veterinary Clinic', 'Angeles City', 'Pampanga', 'Chemistry', '2025-05-10', '063110123200107', 'VP20', 'DR3116', 'A', 0),
(296, 'AC & W Veterinary Clinic', 'Caloocan', 'Metro Manila', 'Hematology', '2025-05-16', '08B0909240804', 'VH30', 'DR2925', 'A', 0),
(297, 'Vetcare Animal Clinic', 'Legazpi City', 'Albay', 'Hematology', '2025-05-17', '08B0909240921', 'VH30', 'DR3025', 'A', 0),
(298, 'Vets and Furries Animal Clinic', 'Masinloc', 'Zambales', 'Hematology', '2025-05-27', '08B0909240827', 'VH30', 'DR3130', 'A', 0),
(299, 'Nose to Tail Veterinary Clinic', 'Pozzorubio', 'Pangasinan', 'Chemistry', '2025-06-19', '063100124200128', 'VP20', 'DR2930', 'A', 0),
(300, 'Furr-fect Paws Animal Clinic', 'GMA', 'Cavite', 'Hematology', '2025-06-20', '08B0909240794', 'VH30', 'DR2978', 'A', 0),
(301, 'Furr-fect Paws Animal Clinic', 'GMA', 'Cavite', 'Chemistry', '2025-06-20', '063100124200131', 'VP20', 'DR2979', 'A', 0),
(302, 'B.V. Seda Animal Care Clininc', 'Lemery', 'Batangas', 'UTZ', '2025-06-21', 'F522072024810n0001', 'M5 Vet', 'DR3035', 'A', 0),
(303, 'Vetcare Animal Clinic', 'Legazpi City', 'Albay', 'Chemistry', '2025-06-23', '63100124200136', 'VP20', 'DR2933', 'A', 0),
(304, 'Vetcare Animal Clinic', 'Legazpi City', 'Albay', 'UTZ', '2025-06-23', 'K42943114CTOXN0005', 'M5 Vet', 'DR2934', 'A', 0),
(305, 'Assumpta Vet Care Animal Clinic', 'Pili', 'Camarines Sur', 'Hematology', '2025-06-24', '08B090924C789', 'VH30', 'DR2937', 'A', 0),
(306, 'Psalms Paws Veterinary Clinic/ Bridgeway', 'Cardona/ Morong', 'Rizal', 'Chemistry', '2025-06-25', '063100124200133', 'VP20', 'DR2982', 'A', 0),
(307, 'Little Paws Haven Veterinary Clinic', 'Angeles City', 'Pampanga', 'Hematology', '2025-06-25', '08B0909240815', 'VH30', 'DR3210', 'A', 0),
(308, 'Kho Veterinary Clinic', 'Daet', 'Camarines Norte', 'Chemistry', '2025-07-14', '6100124200129', 'VP20', 'DR3045', 'A', 0),
(309, 'Kho Veterinary Clinic', 'Daet', 'Camarines Norte', 'Xray', '2025-07-14', 'F05R6228', '', 'DR3046', 'A', 0),
(310, 'Gracious Paws Veterinary Clinic', 'Sta Rosa', 'Laguna', 'Hematology', '2025-07-19', '08B0607250970', 'VH30', 'DR3048', 'A', 0),
(311, 'LA Veterinary Clinic', 'Jones', 'Isabela', 'Hematology', '2025-08-09', '08B0607250975', 'VH30', 'DR3410', 'A', 0),
(312, 'Sursur Animal Clinic', 'Tandag City', 'Surigao Del Sur', 'Hematology', '2025-08-23', '08B0607250973', 'VH30', 'DR3353', 'A', 0),
(313, 'Ryle Animal Clinic', 'Malaybalay City', 'Bukidnon', 'Hematology', '2025-08-24', '08B0607250967', 'VH30', 'DR3354', 'A', 0),
(314, 'Fuzzy Friends Pet Clinic', 'Malaybalay City', 'Bukidnon', 'Chemistry', '2025-08-26', 'D63100124200142', 'VP20', 'DR3355', 'A', 0),
(315, 'Gopets Veterinary Clinic', 'Baguio City', 'Benguet', 'Chemistry', '2025-08-27', '063100124200137', 'VP20', 'DR3519', 'A', 0),
(316, 'Blessed Creatures Veterinary Clinic', 'Camalig', 'Albay', 'Hematology', '2025-09-08', '08B0607250971', 'VH30', 'DR3606', 'A', 0),
(317, 'Blessed Creatures Veterinary Clinic', 'Camalig', 'Albay', 'Chemistry', '2025-09-08', '63100124200127', 'VP20', 'DR3607', 'A', 0),
(318, 'Petserv Animal Clinic', 'Catarman', 'Northern Samar', 'Hematology', '2025-09-11', '08B0909240810', 'VH30', 'DR3312', 'A', 0),
(319, 'Petserv Animal Clinic', 'Catarman', 'Northern Samar', 'Chemistry', '2025-09-11', '063100124200141', 'VP20', 'DR3313', 'A', 0),
(320, 'C & A Pet Clinic', 'Bayombong', 'Nueva Vizcaya', 'Hematology', '2025-09-16', '08B0607250976', 'VH30', 'DR3428', 'A', 0),
(321, 'Dok Aba Animal Clinic', 'Davao City', 'Davao Del Sur', 'Hematology', '2025-09-25', '08B0909240820', 'VH30', 'DR3358', 'A', 0),
(322, 'Galaxy Paws Animal Clinic', 'Caloocan', 'Metro Manila', 'Chemistry', '2025-10-02', '063100124200144', 'VP20', 'DR3673', 'A', 0),
(323, 'D and M Veterinary Services', 'Caticlan', 'Aklan', 'Hematology', '2025-10-02', '08B0607250979', 'VH30', 'DR3801', 'A', 0),
(324, 'Pawfessional Veterinary Clinic', 'Rodriguez', 'Rizal', 'Xray', '2025-10-29', 'F05R6350', '', 'DR3906', 'A', 0),
(325, 'Tailville Veterinary Clinic', 'Rodriguez', 'Rizal', 'Xray', '2025-10-29', 'F05R6353', '', 'DR3905', 'A', 0),
(326, 'Dog-Cat Veterinary Clinic', 'San Francisco', 'Agusan Del Sur', 'Hematology', '2025-11-03', '08B0607250974', 'VH30', 'DR3365', 'A', 0),
(327, 'KJT Veterinary Services', 'Valencia City', 'Bukidnon', 'Hematology', '2025-11-04', '08B0607250982', 'VH30', 'DR3366', 'A', 0),
(328, 'Pets Choice Animal Clinic', 'Sto Tomas', 'Pampanga', 'Chemistry', '2025-11-05', 'CV2310006202210506', 'CV5', 'DR3755', 'A', 0),
(329, 'Pets Choice Animal Clinic', 'Sto Tomas', 'Pampanga', 'Hematology', '2025-11-06', '08B1213230676', 'VH30', 'DR3758', 'A', 0),
(330, 'Alterra JB Paws Pet Clinic', 'Jordan', 'Guimaras', 'Hematology', '2025-11-12', '08B0607250969', 'VH30', 'DR3807', 'A', 0),
(331, 'Pet Royale Clinic and Veterinary', 'Calbayog City', 'Samar', 'UTZ', '2025-11-18', 'J5L94311CT028N0001', 'M5 Vet', 'DR3321', 'A', 0),
(332, 'DogCat Emergency Clinic', 'Koronadal City', 'South Cotabato', 'UTZ', '2025-11-19', 'J5251151CT032N0002', 'B/W', 'DR3367', 'A', 0),
(333, 'Furr-fect Paws Animal Clinic', 'GMA', 'Cavite', 'Urine Analyzer', '2025-11-20', 'MA23090200018', 'VU10', 'DR3625', 'A', 0),
(334, 'Pet House Veterinary Clinic', 'Quezon City', 'Metro Manila', 'Urine Analyzer', '2025-11-20', 'MA23050140100', 'VU10', 'DR3624', 'A', 0),
(335, 'Pawprints Veterinary Clinic', 'Roxas', 'Isabela', 'Urine Analyzer', '2025-12-01', 'MA23090200021', 'VU10', 'DR4001', 'A', 0),
(336, 'Dad\'s Care Veterinary Clinic', 'Tagaytay City', 'Cavite', 'Hematology', '2025-12-10', '08B0607250964', 'VH30', 'DR3290', 'A', 0),
(337, 'Dad\'s Care Veterinary Clinic', 'Tagaytay City', 'Cavite', 'Chemistry', '2025-12-10', '063100124200143', 'VP20', 'DR3291', 'A', 0),
(338, 'NextDoor Pet Care Services', 'San Miguel', 'Bulacan', 'UTZ', '2025-12-13', 'J5251151CT032N0001', 'B/W', 'DR4154', 'A', 0),
(339, 'Addy Paws Animal Clinic', 'Alfonso Lista', 'Ifugao', 'Hematology', '2025-12-13', '08B0607250972', 'VH30', 'DR3862', 'A', 0),
(340, 'ICT Vet Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Chemistry', '2026-01-12', '63081823200082', 'VP20', 'DR3863', 'A', 0),
(341, '3DS Veterinary Services & Supplies', 'Madrid', 'Surigao Del Sur', 'Hematology', '2026-01-13', '08B0607250978', 'VH30', 'DR3396', 'A', 0),
(342, 'Beyond Bark Animal Clinic', 'Marilao', 'Bulacan', 'Hematology', '2026-02-07', '08B0213250797', 'VH30', 'DR3865', 'A', 0),
(343, 'TrustiVet Animal Clinic', 'San Juan', 'Batangas', 'Xray', '2026-02-16', '23012511006', 'ZT-DRF_V1', 'DR4202', 'A', 0),
(344, 'Pet Royale Clinic and Veterinary', 'Calbayog City', 'Samar', 'Hematology', '2026-02-25', '08B0607250977', 'VH30', 'DR3334', 'A', 0),
(345, 'Margavet Animal Clinic', 'Antipolo City', 'Rizal', 'Hematology', '2026-03-04', '08B0213250792', 'VH30', 'DR3647', 'A', 0),
(346, 'Pawrock Veterinary Clinic', 'Porac', 'Pampanga', 'Hematology', '2026-03-05', '08B0909240822', 'VH30', 'DR3868', 'A', 0),
(347, 'Movet Petcare Inc', 'Baguio City', 'Benguet', 'Hematology', '2026-03-06', '08B0607250968', 'VH30', 'DR3869', 'A', 0),
(348, 'Margavet Animal Clinic', 'Antipolo City', 'Rizal', 'Chemistry', '2026-03-13', '063100124200154', 'VP20', 'DR3650', 'A', 0),
(349, 'Pet Aid Veterinary Clinic', 'Quezon City', 'Metro Manila', 'UTZ', '2026-03-13', 'K52251014PAO9N0016', 'B/W', 'DR4359', 'A', 0),
(350, 'Aklan Vet Mobile Animal Clinic', 'Kalibo, Aklan', 'Aklan', 'UTZ', '2026-03-16', 'A6294311CT028N0001', 'M5 Vet', 'DR3815', 'A', 0),
(351, 'Dad\'s Care Veterinary Clinic', 'Tagaytay City', 'Cavite', 'UTZ', '2026-03-25', '06251151CT032N0001', 'B/W', 'DR4211', 'A', 0),
(352, 'Animal\'s Den Veterinary Clinic', 'Itogon', 'Benguet', 'Hematology', '2026-03-28', '08B1213230668', 'VH30', 'DR4087', 'A', 0),
(353, 'DR. E Veterinary Clinic', 'Iligan City', 'Lanao Del Norte', 'Urine Analyzer', '2026-04-08', 'MA23050140040', 'VU10', 'DR3872', 'A', 0),
(354, 'Red Claws Pet Health Center', 'Dasmariñas', 'Cavite', 'Hematology', '2026-04-14', '08B0607250981', 'VH30', 'DR4402', 'A', 0),
(355, 'Red Claws Pet Health Center', 'Dasmariñas', 'Cavite', 'Chemistry', '2026-04-14', '063100124200156', 'VP20', 'DR4403', 'A', 0),
(356, 'Pets & Farms Veterinary Services', 'Nasugbu', 'Batangas', 'Hematology', '2026-04-25', '08B0607250982', 'VH30', 'DR4215', 'A', 0),
(357, 'Centrovet Animal Clinic', 'San Jose', 'Nueva Ecija', 'Hematology', '2026-05-09', '08B0607250980', 'VH30', 'DR4406', 'A', 0),
(358, 'TrustiVet Animal Clinic', 'San Juan', 'Batangas', 'Urine Analyzer', '2026-05-16', 'MA23090200094', 'VU10', 'DR4216', 'A', 0),
(359, 'Pet Direction Veterinary Clinic', 'San Simon', 'Pampanga', 'Hematology', '2026-05-16', '08B0909240796', 'VH30', 'DR3342', 'A', 0),
(360, 'NextDoor Pet Care Services', 'San Miguel', 'Bulacan', 'Xray', '2026-05-26', 'VT28033IPIG3R21022', 'ZT-DR_V1', 'DR3820', 'A', 0),
(361, 'Furry Tales Veterinary Clinic', 'Quezon City', 'Metro Manila', 'Xray', '2026-06-11', 'VT260507P2G3R41001', 'ZT-DRF-V1', 'DR4561', 'A', 0),
(362, 'FMR Animal Clinic', 'Cotabato City', 'Cotabato', 'Urine Analyzer', '2026-06-25', 'MA23090200096', 'VU10', 'DR3878', 'A', 0),
(363, 'Animal Corner Veterinary Clinic', 'Cordon', 'Isabela', 'Hematology', '2026-07-01', '08B1017220325', 'VH30', 'DR4752', 'A', 0),
(364, 'Petmate Veterinary Clinic', 'Iligan City', 'Lanao Del Norte', 'Xray', '2026-07-14', 'VT260604P363R21004', 'ZT-DR_V1', 'DR3881', 'A', 0),
(365, 'Petmate Veterinary Clinic', 'Iligan City', 'Lanao Del Norte', 'UTZ', '2026-07-14', 'E6251151CT032N0001', 'B/W', 'DR3881', 'A', 0),
(366, 'Artemis Veterinary Clinic', 'General Santos City', 'South Cotabato', 'Xray', '2026-07-29', '2804170200291', 'ZT-DR_V1', 'DR3882', 'A', 0),
(367, 'Artemis Veterinary Clinic', 'General Santos City', 'South Cotabato', 'UTZ', '2026-07-29', 'E6251151CT032N0002', 'B/W', 'DR3882', 'A', 0),
(368, 'Pets Life Vet Clinic', 'Bagabag, Nueva Vizcaya', 'Nueva Vizcaya', 'UTZ', '2026-07-29', 'G6294311CT028N0001', 'M5 Vet', 'DR4411', 'A', 0),
(370, 'NextDoor Pet Care Services', 'San Miguel', 'Bulacan', 'Urine Analyzer', '2024-05-17', 'MA21100010027', 'VU10', 'DR1691', 'A', 0),
(371, 'AR Veterinary Clinic', 'Bulanao', 'Kalinga', 'Chemistry Analyzer', '2026-10-01', '47493', 'MNCHIP', 'DRNONE', 'A', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_fsr`
--

CREATE TABLE `tb_fsr` (
  `id` int(10) UNSIGNED NOT NULL,
  `fsr_number` varchar(50) NOT NULL,
  `service_engineer` varchar(150) NOT NULL,
  `account` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `machine` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `technical_concern` text DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `action_made` text DEFAULT NULL,
  `acknowledge` varchar(150) DEFAULT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `receipt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mfs`
--

CREATE TABLE `tb_mfs` (
  `id` int(10) UNSIGNED NOT NULL,
  `mfs_number` varchar(50) NOT NULL,
  `employee` varchar(150) NOT NULL,
  `pull_out_personnel` varchar(150) DEFAULT NULL,
  `service_eng_id` int(11) DEFAULT NULL,
  `accounts` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_fillup` date DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `machine` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `accessories` text DEFAULT NULL,
  `consumable_unit` varchar(50) DEFAULT NULL,
  `consumables` varchar(255) DEFAULT NULL,
  `lot_number` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `date_returned` date DEFAULT NULL,
  `returned_personnel` varchar(150) DEFAULT NULL,
  `date_status` date DEFAULT NULL,
  `personnel` varchar(150) DEFAULT NULL,
  `acknowledged` tinyint(1) NOT NULL DEFAULT 0,
  `returned` tinyint(1) NOT NULL DEFAULT 0,
  `receipt_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `receipt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_mfs`
--

INSERT INTO `tb_mfs` (`id`, `mfs_number`, `employee`, `pull_out_personnel`, `service_eng_id`, `accounts`, `address`, `date_fillup`, `unit`, `machine`, `serial_number`, `accessories`, `consumable_unit`, `consumables`, `lot_number`, `remarks`, `reason`, `date_returned`, `returned_personnel`, `date_status`, `personnel`, `acknowledged`, `returned`, `receipt_id`, `created_at`, `updated_at`, `receipt`) VALUES
(2, '000001', 'Jashrille Pagulayan', 'hgj', 5, '3KE Pet Solution Animal Clinic', 'Kawit', '2026-11-01', '1', 'Hematology', '08B0224230440', 'tdgh | 3; kjjkhjk | 1', '1, 1', 'gbdfg | 2222; fhhgjfh | 45', '', 'dgffggfg', 'sdasda', '2026-11-01', 'ljkiklj', '2026-11-01', 'ljkiklj', 1, 0, NULL, '2026-11-01 11:53:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pms`
--

CREATE TABLE `tb_pms` (
  `id` int(11) NOT NULL,
  `pms_number` varchar(255) NOT NULL,
  `service_tech` varchar(255) NOT NULL,
  `clinic` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `machine` varchar(255) NOT NULL,
  `sn` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `mfs` int(11) NOT NULL,
  `fsr` int(11) NOT NULL,
  `receipt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pms`
--

INSERT INTO `tb_pms` (`id`, `pms_number`, `service_tech`, `clinic`, `address`, `date`, `machine`, `sn`, `status`, `remarks`, `mfs`, `fsr`, `receipt`) VALUES
(3, '000002', 'Jayrald Macanang', 'Nose to Tail Veterinary Clinic', 'San Quintin, Pangasinan', '2025-10-20', 'Hematology Analyzer', '08B1007230563', 'Heavy PMS', '', 0, 0, NULL),
(4, '000003', 'Jayrald Macanang', 'Nose to Tail Veterinary Clinic', 'Tayug, Pangasinan', '2025-10-20', 'Hematology Analyzer', '08B0224230441', 'Heavy PMS', '', 0, 0, NULL),
(5, '000004', 'Jayrald Macanang', 'Rural Vet Clinic', 'San Fabian, Pangasinan', '2025-10-18', 'Hematology Analyzer', '08B1007230562', 'Heavy PMS', '', 0, 0, NULL),
(6, '000005', 'Jayrald Macanang', 'Pet Essentials Veterinary Clinic', 'Binalonan, Pangasinan', '2025-10-18', 'Hematology Analyzer', '8.60223211086E11', 'Heavy PMS', '', 0, 0, NULL),
(7, '000006', 'Jayrald Macanang', 'Pets Ville Veterinary Clinic', 'Laoac, Pangasinan', '2025-10-18', 'Hematology Analyzer', '08B1213230663', 'Heavy PMS', '', 0, 0, NULL),
(8, '000007', 'Jayrald Macanang', 'Nose to Tail Veterinary Clinic', 'Asingan, Pangasinan', '2025-10-21', 'Hematology Analyzer', '08B0427230488', 'Heavy PMS', '', 0, 0, NULL),
(9, '000008', 'Jayrald Macanang', 'Nose to Tail Veterinary Clinic', 'Sta. Maria, Pangasinan', '2025-10-21', 'Hematology Analyzer', '08B0909240798', 'Light PMS', '', 0, 0, NULL),
(10, '000009', 'Jayrald Macanang', 'Favors Animal Clinic', 'Reina Mercedes, Isabela', '2025-10-22', 'Hematology Analyzer', '08B0909240826', 'Light PMS', '', 0, 0, NULL),
(11, '000010', 'Jayrald Macanang', 'Pet Vet Tumauini Animal Clinic', 'Tumauini, Isabela', '2025-10-22', 'Hematology Analyzer', '08B0427230471', 'Light PMS', '', 0, 0, NULL),
(12, '000011', 'Jayrald Macanang', 'Clinica Animalia Veterinary Clinic', 'Tumauini, Isabela', '2025-10-22', 'Hematology Analyzer', '08B1017220335', 'Light PMS', '', 0, 0, NULL),
(13, '000012', 'Jayrald Macanang', 'Bark Avenue Veterinary Clinic', 'Tuguegarao City', '2025-10-29', 'Hematology Analyzer', '08G1213230664', 'Light PMS', '', 0, 0, NULL),
(14, '000013', 'Jayrald Macanang', 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', '2025-10-29', 'Hematology Analyzer', '7.4619193655E10', 'Light PMS', '', 0, 0, NULL),
(15, '000014', 'Jayrald Macanang', 'Animal Options Veterinary Clinic', 'Tuguegarao City', '2025-10-29', 'Hematology Analyzer', '7.71027161514E11', 'Light PMS', '', 0, 0, NULL),
(16, '000015', 'Angelica Mae Salarzon', 'NextDoor Pet Care Services', 'San Miguel, Bulacan', '2025-10-20', 'Hematology Analyzer', '08B0628220253', 'Light PMS', '', 0, 0, NULL),
(17, '000016', 'CANCELLED', 'Animal Access Veterinary Clinic', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(18, '000017', 'Angelica Mae Salarzon', 'Animal Access Veterinary Clinic', 'San Ildefenso, Bulacan', '2025-10-21', 'Chemistry Analyzer', '200083.0', 'Manual cleaning of chemistry', '', 0, 0, NULL),
(19, '000018', 'Angelica Mae Salarzon', 'Vet Furpaws Pet Care Services', 'Sta. Maria, Bulacan', '2025-10-21', 'Hematology Analyzer', '08B1017220320', 'Mid PMS', '', 0, 0, NULL),
(20, '000019', 'Angelica Mae Salarzon', 'Puppyko Animal Clinic', 'pandi bulacan', '2025-10-21', 'Hematology Analyzer', '08B0909240802', 'Mid PMS', '', 0, 0, NULL),
(21, '000020', 'Angelica Mae Salarzon', 'Galaxy Paws Animal Clinic', 'caloocan city', '2025-10-22', 'Hematology Analyzer', '08B0708230544', 'Light PMS', '', 0, 0, NULL),
(22, '000021', 'Angelica Mae Salarzon', 'AC & W Veterinary Clinic', 'caloocan city', '2025-10-22', 'Hematology Analyzer', '08B0909240804', 'Light PMS', '', 0, 0, NULL),
(23, '000022', 'Angelica Mae Salarzon', 'RMC Veterinary Clinic', 'san mateo rizal', '2025-10-22', 'Hematology Analyzer', '08B0427230474', 'Mid PMS', '', 0, 0, NULL),
(24, '000023', 'Angelica Mae Salarzon', 'Petfriends Veterinary Clinic', 'rodriguez rizal', '2025-10-23', 'Chemistry Analyzer', '27464.0', 'Manual cleaning of chemistry', '', 0, 0, NULL),
(25, '000024', 'Angelica Mae Salarzon', 'Psalms Paws Veterinary Clinic', 'morong rizal', '2025-10-23', 'Hematology Analyzer', '08B0909240793', 'Mid PMS', '', 0, 0, NULL),
(26, '000025', 'Angelica Mae Salarzon', 'Vetlane Animal Clinic', 'Quezon Ciy, Manila', '2025-10-24', 'Hematology Analyzer', '08B1213230681', 'Light PMS', '', 0, 0, NULL),
(27, '000026', 'Angelica Mae Salarzon', 'Vet Street / JMIC Animal Medical Center', 'caloocan city', '2025-10-24', 'Hematology Analyzer', '08B1213230672', 'Mid PMS', '', 0, 0, NULL),
(28, '000027', 'Angelica Mae Salarzon', 'Medpaws Veterinary Clinic', 'Quezon Ciy, Manila', '2025-10-24', 'Hematology Analyzer', '08B1007230560', 'Light PMS', '', 0, 0, NULL),
(29, '000028', 'Angelica Mae Salarzon', 'Zoe\'s Clapier Veterinary Clinic', 'Orion, Bataan', '2025-10-27', 'Hematology Analyzer', '08B1213230688', 'Mid PMS', '', 0, 0, NULL),
(30, '000029', 'Angelica Mae Salarzon', 'Peninsula Veterinary Clinic', 'Pilar, Bataan', '2025-10-27', 'Hematology Analyzer', '08B1209220377', 'Mid PMS', '', 0, 0, NULL),
(31, '000030', 'Angelica Mae Salarzon', 'Dr. Vien Veterinary Clinic', 'San Marcelino, Zambales', '2025-10-28', 'Hematology Analyzer', '08B1209220388', 'Mid PMS', '', 0, 0, NULL),
(32, '000031', 'Angelica Mae Salarzon', 'Jamel Vets and Furries Animal Clinic', 'San Felipe, Zambales', '2025-10-28', 'Hematology Analyzer', '08B0628220250', 'Mid PMS', '', 0, 0, NULL),
(33, '000032', 'Angelica Mae Salarzon', 'Doc Gregg Veterinary Clinic', 'Ologapo City, Zambales', '2025-10-28', 'Hematology Analyzer', '8.6052021141E11', 'Mid PMS', '', 0, 0, NULL),
(34, '000033', 'Angelica Mae Salarzon', 'Jamel Vets and Furries Animal Clinic', 'Sta Cruz, Zambales', '2025-10-29', 'Hematology Analyzer', '08B0427230473', 'Mid PMS', '', 0, 0, NULL),
(35, '000034', 'Angelica Mae Salarzon', 'Niedo\'s Animal Clinic', 'Botolan, Zambales', '2025-10-29', 'Hematology Analyzer', '08B0628220272', 'Mid PMS', '', 0, 0, NULL),
(36, '000035', 'Angelica Mae Salarzon', 'Jamel Vets and Furries Animal Clinic', 'Masinloc, Zambales', '2025-10-29', 'Hematology Analyzer', '08B0909240827', 'Mid PMS', '', 0, 0, NULL),
(37, '000036', 'Angelica Mae Salarzon', 'Little Paws Haven Veterinary Clinic', 'Angeles, Pampanga', '2025-10-30', 'Hematology Analyzer', '08B0909240815', 'Mid PMS', '', 0, 0, NULL),
(38, '000037', 'Angelica Mae Salarzon', 'Happy Tails Pet Care Clinic / Pampang Animal Clinic', 'Angeles, Pampanga', '2025-10-30', 'Hematology Analyzer', '08B0224230416', 'Mid PMS', '', 0, 0, NULL),
(39, '000038', 'Randy Fernandez', 'Clinica Animalia Veterinary Clinic', 'Echague, Isabela', '2025-11-04', 'Hematology Analyzer', '8.60603211458E11', 'Mid PMS', '', 0, 0, NULL),
(40, '000039', 'Randy Fernandez', 'Animal Haven Veterinary Clinic', 'La Trinidad, Benguet', '2025-11-06', 'Hematology Analyzer', '7.41015204611E11', 'Mid PMS', '', 0, 0, NULL),
(41, '000040', 'Randy Fernandez', 'Pet Treasures Veterinary Clinic', 'Baguio City, Benguet', '2025-11-07', 'Hematology Analyzer', '08B1017220328', 'Light PMS', '', 0, 0, NULL),
(42, '000041', 'Randy Fernandez', 'Velvet Animal Clinic', 'Luna, La Union', '2025-11-07', 'Hematology Analyzer', '08B0628220275', 'Light PMS', '', 0, 0, NULL),
(43, '000042', 'Jayrald Macanang', 'Amazing Grace Diagnostic and Medical Services', 'Ilagan, Isabela', '2025-11-21', 'Hematology Analyzer', '7.51208150934E11', 'Heavy PMS', '', 0, 0, NULL),
(44, '000043', 'Jayrald Macanang', 'Pets Life Vet Clinic', 'Bagabag, Nueva Vizcaya', '2025-11-25', 'Hematology Analyzer', '08B1007230556', 'Quality Control', '', 0, 0, NULL),
(45, '000044', 'Jayrald Macanang', 'Animedics Veterinary Clinic', 'Bagabag, Nueva Vizcaya', '2025-11-25', 'Hematology Analyzer', '8.60416200531E11', 'Quality Control', '', 0, 0, NULL),
(46, '000045', 'Jayrald Macanang', 'Vet Tag Animal Clinic', 'Solano, Nueva Vizcaya', '2025-11-25', 'Hematology Analyzer', '08B1017220336', 'Quality Control', '', 0, 0, NULL),
(47, '000046', 'Jayrald Macanang', 'Animedics Veterinary Clinic', 'Solano, Nueva Vizcaya', '2025-11-25', 'Hematology Analyzer', '08B0915210052', 'Quality Control', '', 0, 0, NULL),
(48, '000047', 'Jayrald Macanang', 'C & A Pet Clinic', 'Bayombong, Nueva Vizcaya', '2025-11-25', 'Hematology Analyzer', '08B0607250976', 'Quality Control', '', 0, 0, NULL),
(49, '000048', 'Jayrald Macanang', 'Animedics Veterinary Clinic', 'Bambang, Nueva Vizcaya', '2025-11-26', 'Hematology Analyzer', '7.40305193348E11', 'Quality Control', '', 0, 0, NULL),
(50, '000049', 'Jayrald Macanang', 'Pets Place Veterinary Clinic', 'Dupax del Norte, Nueva Vizcaya', '2025-11-26', 'Hematology Analyzer', '08B0224230433', 'Quality Control', '', 0, 0, NULL),
(51, '000050', 'Jayrald Macanang', 'Pets Place Veterinary Clinic', 'Aritao, Nueva Vizcaya', '2025-11-26', 'Hematology Analyzer', '7.40828204562E11', 'Quality Control', '', 0, 0, NULL),
(52, '000051', 'Randy Fernandez', 'Vets for Pets Animal Clinic', 'Laoag, Ilocos Norte', '2025-11-17', 'Hematology Analyzer', '08B1017220329', 'Light PMS', '', 0, 0, NULL),
(53, '000052', 'Randy Fernandez', 'JC Paws & Claws Veterinary Clinic', 'Batac, Ilocos Norte', '2025-11-18', 'Hematology Analyzer', '08B0628220274', 'Light PMS', '', 0, 0, NULL),
(54, '000053', 'Randy Fernandez', 'Paoay Animal Clinic', 'Paoay, Ilocos Norte', '2025-11-18', 'Hematology Analyzer', '08B0909240823', 'Light PMS', '', 0, 0, NULL),
(55, '000054', 'Randy Fernandez', 'Vets for Pets Animal Clinic', 'Dingras, Ilocos Norte', '2025-11-18', 'Hematology Analyzer', '7.40827193878E11', 'Light PMS', '', 0, 0, NULL),
(56, '000055', 'Randy Fernandez', 'Francis Paul Benedict Vet Clinic', 'Vigan, Ilocos Norte', '2025-11-18', 'Hematology Analyzer', '08B416220256', 'Light PMS', '', 0, 0, NULL),
(57, '000056', 'Randy Fernandez', 'Vet ni Bantay Animal Clinic', 'Vigan, Ilocos Norte', '2025-11-18', 'Hematology Analyzer', '08B1213230682', 'Light PMS', '', 0, 0, NULL),
(58, '000057', 'Randy Fernandez', 'Narvacan Veterinary Clinic', 'Narvacan, Ilocos Norte', '2025-11-19', 'Hematology Analyzer', '08B1213230674', 'Light PMS', '', 0, 0, NULL),
(59, '000058', 'Randy Fernandez', 'Vetwise Animal Clinic', 'Candon, Ilocos Sur', '2025-11-19', 'Hematology Analyzer', '08B0706230545', 'Light PMS', '', 0, 0, NULL),
(60, '000059', 'Randy Fernandez', 'Vets Turf Animal Clinic', 'Candon, Ilocos Sur', '2025-11-19', 'Hematology Analyzer', '08B0708230530', 'Light PMS', '', 0, 0, NULL),
(61, '000060', 'Randy Fernandez', 'Gentle Paws Animal Clinic', 'Bangar, La Union', '2025-11-19', 'Hematology Analyzer', 'OBB1017220319', 'Light PMS', '', 0, 0, NULL),
(62, '000061', 'Randy Fernandez', 'Neervet Animal Clinic', 'Bacnotan, La Union', '2025-11-19', 'Chemistry Analyzer', 'MA21100010060', 'Manual cleaning of chemistry', '', 0, 0, NULL),
(63, '000062', 'Randy Fernandez', 'Elyu Veterinary Clinic', 'San Juan, La Union', '2025-11-19', 'Hematology Analyzer', '08B0427230487', 'Light PMS', '', 0, 0, NULL),
(64, '000063', 'Randy Fernandez', 'Valley Vets Animal Clinc', 'San Fernando, La Union', '2025-11-19', 'Hematology Analyzer', '6.3110123200039E13', 'Light PMS', '', 0, 0, NULL),
(65, '000064', 'Randy Fernandez', 'PetHealth Care Vet Clinic', 'Agoo, La Union', '2025-11-20', 'Hematology Analyzer', '08B1209220386', 'Light PMS', '', 0, 0, NULL),
(66, '000065', 'Randy Fernandez', 'D and R Dog Cat Clinic', 'Calasiao, Pangasinan', '2025-11-20', 'Hematology Analyzer', '08B0426230490', 'Light PMS', '', 0, 0, NULL),
(67, '000066', 'Randy Fernandez', 'Manaoag Veterinary Clinic', 'Manaoag, Pangasinan', '2025-11-20', 'Hematology Analyzer', '08B0427230492', 'Light PMS', '', 0, 0, NULL),
(68, '000067', 'Randy Fernandez', 'Pet Essentials Veterinary Clinic', 'Binalonan, Pangasinan', '2025-11-20', 'Hematology Analyzer', '8.60223211086E11', 'Mid PMS', '', 0, 0, NULL),
(69, '000068', 'Randy Fernandez', 'The Pet Pro Veterinary Clinic', 'Baguio City, Benguet', '2025-11-21', 'Hematology Analyzer', '8.60223211086E11', 'Light PMS', '', 0, 0, NULL),
(70, '000069', 'Randy Fernandez', 'Vetsquad Animal Clinic', 'Pugo, La Union', '2025-11-21', 'Hematology Analyzer', '6.3110123200076E13', 'Light PMS', '', 0, 0, NULL),
(71, '000070', 'Jayrald Macanang', 'Nose to Tail Veterinary Clinic', 'Tayug, Pangasinan', '2025-12-10', 'Hematology Analyzer', '08B0224230441', 'Quality Control', '', 0, 0, NULL),
(72, '000071', 'Jayrald Macanang', 'Nose to Tail Veterinary Clinic', 'Sta. Maria, Pangasinan', '2025-12-10', 'Hematology Analyzer', '08B0909240798', 'Quality Control', '', 0, 0, NULL),
(73, '000072', 'Jayrald Macanang', 'Nose to Tail Veterinary Clinic', 'Asingan, Pangasinan', '2025-12-10', 'Hematology Analyzer', '08B0427230488', 'Quality Control', '', 0, 0, NULL),
(74, '000073', 'Jayrald Macanang', 'San Manuel Veterinary Clinic', 'San Manuel, Pangasinan', '2025-12-10', 'Hematology Analyzer', '08B101220321', 'Quality Control', '', 0, 0, NULL),
(75, '000074', 'Randy Fernandez', 'Bark Avenue Veterinary Clinic', 'Tuguegarao City', '2026-01-05', 'Hematology Analyzer', '08B1213230664', 'Light PMS', '', 0, 0, NULL),
(76, '000075', 'Randy Fernandez', 'Jhay Veterinary Clinic', 'Cabatuan, Isabela', '2026-01-19', 'Hematology Analyzer', '08B0818210036', 'Light PMS', '', 0, 0, NULL),
(77, '000076', 'Randy Fernandez', 'Pets Life Vet Clinic', 'Bagabag, Nueva Ecija', '2026-01-19', 'Hematology Analyzer', '08B1007230556', 'Light PMS', '', 0, 0, NULL),
(78, '000077', 'Randy Fernandez', 'Animedics Veterinary Clinic', 'Solano, Nueva Ecija', '2026-01-20', 'Hematology Analyzer', '08B0915210052', 'Light PMS', '', 0, 0, NULL),
(79, '000078', 'Randy Fernandez', 'Animedics Veterinary Clinic', 'Bambang, Nueva Ecija', '2026-01-20', 'Hematology Analyzer', '7.40305193348E11', 'Light PMS', '', 0, 0, NULL),
(80, '000079', 'Randy Fernandez', 'Mustangs Veterinary Clinic', 'San Jose, Nueva Ecija', '2026-01-20', 'Hematology Analyzer', '08B1209220378', 'Light PMS', '', 0, 0, NULL),
(81, '000080', 'Randy Fernandez', 'Pet Alley Animal Clinic', 'San Jose, Nueva Ecija', '2026-01-20', 'Hematology Analyzer', '08B0427230489', 'Light PMS', '', 0, 0, NULL),
(82, '000081', 'Randy Fernandez', 'Pet Landia Animal Clinic', 'Gen Tinio, Nueva Ecija', '2026-01-20', 'Hematology Analyzer', '08B0416220204', 'Light PMS', '', 0, 0, NULL),
(83, '000082', 'Randy Fernandez', 'Pets Vetfriend Veterinary Clinic', 'Guimba, Nueva Ecija', '2026-01-21', 'Hematology Analyzer', '08B0416220189', 'Light PMS', '', 0, 0, NULL),
(84, '000083', 'Randy Fernandez', 'Maple Vet Clinic', 'Guimba, Nueva Ecija', '2026-01-21', 'Hematology Analyzer', '08B1230210178', 'Light PMS', '', 0, 0, NULL),
(85, '000084', 'Randy Fernandez', 'Pet Care Veterinary Clinic', 'Urdaneta, Pangasinan', '2026-01-21', 'Hematology Analyzer', '08B1007230559', 'Light PMS', '', 0, 0, NULL),
(86, '000085', 'Randy Fernandez', 'Nose to Tail Veterinary Clinic', 'Calasiao, Pangasinan', '2026-01-22', 'Hematology Analyzer', '8.60520211414E11', 'Light PMS', '', 0, 0, NULL),
(87, '000086', 'Randy Fernandez', 'D and R Dog Cat Clinic', 'Calasiao, Pangasinan', '2026-01-22', 'Hematology Analyzer', '08B0426230490', 'Light PMS', '', 0, 0, NULL),
(88, '000087', 'Randy Fernandez', 'Manaoag Veterinary Clinic', 'Manaoag, Pangasinan', '2026-01-22', 'Hematology Analyzer', '08B0427230492', 'Light PMS', '', 0, 0, NULL),
(89, '000088', 'Randy Fernandez', 'AMD Pets and Vets Clinic', 'San Fabian, Pangasinan', '2026-01-22', 'Hematology Analyzer', '08B0628220263', 'Light PMS', '', 0, 0, NULL),
(90, '000089', 'Randy Fernandez', 'Rural Vet Clinic', 'San Fabian, Pangasinan', '2026-01-22', 'Hematology Analyzer', '08B1007230562', 'Light PMS', '', 0, 0, NULL),
(91, '000090', 'Randy Fernandez', 'Collins Animal Clinic', 'Bayambang, Pangasinan', '2026-01-22', 'Hematology Analyzer', '08B0909240797', 'Light PMS', '', 0, 0, NULL),
(92, '000091', 'CANCELLED', 'Doc Gregg Veterinary Clinic', 'Olonggapo, City', '2026-01-24', 'Hematology Analyzer', '', 'Troubleshooting', '', 0, 0, NULL),
(93, '000092', 'Randy Fernandez', 'Doc Gregg Veterinary Clinic', 'Olonggapo, City', '2026-01-24', 'Hematology Analyzer', '8.6052021141E11', 'Troubleshooting', '', 0, 0, NULL),
(94, '000093', 'Randy Fernandez', 'Agapet Animal Clinic', 'Gen Trias, Cavite', '2026-02-03', 'Hematology Analyzer', '08B1213230665', 'Light PMS', '', 0, 0, NULL),
(95, '000094', 'Randy Fernandez', 'Pawprints Animal Clinic', 'Gen Trias, Cavite', '2026-02-03', 'Hematology Analyzer', '08B0909240813', 'Light PMS', '', 0, 0, NULL),
(96, '000095', 'Randy Fernandez', 'Petfriends Veterinary Clinic', 'Gen Trias, Cavite', '2026-02-03', 'Hematology Analyzer', '08B1213230683', 'Light PMS', '', 0, 0, NULL),
(97, '000096', 'Randy Fernandez', 'Furr-fect Paws Animal Clinic', 'GMA, Cavite', '2026-02-04', 'Hematology Analyzer', '08B0909240794', 'Light PMS', '', 0, 0, NULL),
(98, '000097', 'Randy Fernandez', 'Cotton Tails Veterinary Clinic', 'Calamba, Laguna', '2026-02-05', 'Hematology Analyzer', '08B0909240795', 'Light PMS', '', 0, 0, NULL),
(99, '000098', 'Randy Fernandez', 'Rue St. Roche Vet Clinic', 'San Pablo City, Laguna', '2026-02-05', 'Hematology Analyzer', '08B0708230532', 'Light PMS', '', 0, 0, NULL),
(100, '000099', 'Randy Fernandez', 'RMC Veterinary Clinic', 'San Mateo, Rizal', '2026-02-06', 'Hematology Analyzer', '08B0427230474', 'Light PMS', '', 0, 0, NULL),
(101, '000100', 'Randy Fernandez', 'Pawfessional Veterinary Clinic', 'Rodriguez, Rizal', '2026-02-06', 'Hematology Analyzer', '08B1209220384', 'Light PMS', '', 0, 0, NULL),
(102, '000101', 'CANCELLED', 'Paw Spot Veterinary Clinic', '', '2025-11-04', '', '', '', '', 0, 0, NULL),
(103, '000102', 'Angel', 'Paws and Furs Animal Clinic', 'Moncada, Tarlac', '2025-11-07', 'Hematology Analyzer', '08B0224230445', 'Mid PMS', '', 0, 0, NULL),
(104, '000103', 'Angel', 'Maple Vet Clinic', 'Guimba, Nueva Ecija', '2025-11-07', 'Hematology Analyzer', '08B1230210178', 'Light PMS', '', 0, 0, NULL),
(105, '000104', 'Angel', 'Vet Street Veterinary Cinic', 'Muñoz, Nueva Ecija', '2025-07-11', 'Hematology Analyzer', '08B1213230680', 'Light PMS', '', 0, 0, NULL),
(106, '000105', 'Angel', 'Vet Next Door Animal Clinic', 'Lupao, Nueva Ecija', '2025-07-11', 'Hematology Analyzer', '08B0628220271', 'Light PMS', '', 0, 0, NULL),
(107, '000106', 'Angel', 'Mustangs Veterinary Clinic', 'San Jose, Nueva Vizcaya', '2025-08-11', 'Hematology Analyzer', '08B1209220378', 'Light PMS', '', 0, 0, NULL),
(108, '000107', 'Angel', 'Pet Alley Animal Clinic', 'San Jose, Nueva Ecija', '2025-08-11', 'Hematology Analyzer', '08B0427230489', 'Light PMS', '', 0, 0, NULL),
(109, '000108', 'Angel', 'Pet Palisades Veterinary Clinic', 'Talavera, Nueva Ecija', '2025-08-11', 'Hematology Analyzer', '08B1209220376', 'Light PMS', '', 0, 0, NULL),
(110, '000109', 'Angel', 'Pet Terrific Veterinary Clinic', 'Talavera, Nueva Ecija', '2025-08-11', 'Hematology Analyzer', '7.40314193437E11', 'Light PMS', '', 0, 0, NULL),
(111, '000110', 'Angel', 'Vet Connections Animal Clinic', 'Cabanatuan, Nueva Ecija', '2025-08-11', 'Chemistry Analyzer', '27449.0', 'Manual cleaning of chemistry', '', 0, 0, NULL),
(112, '000111', 'Angel', 'Buena Vida Animal Clinic', 'Sta Rosa, Nueva Ecija', '2025-08-11', 'Hematology Analyzer', '08B0818210043', 'Mid PMS', '', 0, 0, NULL),
(113, '000112', 'Angel', 'Pet Central Veterinary Clinic', 'San Isidro, Nueva Ecija', '2025-08-11', 'Hematology Analyzer', '08B0628220273', 'Light PMS', '', 0, 0, NULL),
(114, '000113', 'Angel', 'Vet Furpaws Pet Care Services', 'Sta Maria, Bulacan', '2025-11-11', 'Hematology Analyzer', '08B1017220320', 'Mid PMS', '', 0, 0, NULL),
(115, '000114', 'Antonette', 'Buena Vida Animal Clinic', 'Sta Rosa, Nueva Ecija', '2025-11-20', 'Hematology Analyzer', '08B0818210043', 'Quality Control', '', 0, 0, NULL),
(116, '000115', 'Angel', 'Kanayunan Animal Clinic', 'Mangatarem, Pangasinan', '2025-11-17', 'Hematology Analyzer', '08B1213230671', 'Light PMS', '', 0, 0, NULL),
(117, '000116', 'Angel', 'Rural Vet Clinic', 'San Fabian, Pangasinan', '2025-11-17', 'Hematology Analyzer', '08B1007230562', 'Light PMS', '', 0, 0, NULL),
(118, '000117', 'Angel', 'Moergan and Friends Veterinary Clinic', 'Concepcion, Tarlac', '2025-11-19', 'Hematology Analyzer', '08B1213230678', 'Light PMS', '', 0, 0, NULL),
(119, '000118', 'Angel', 'Pet Landia Animal Clinic', 'General Tinio, Nueva Ecija', '2025-11-20', 'Hematology Analyzer', '08B0416220204', 'Light PMS', '', 0, 0, NULL),
(120, '000119', 'Angel', 'Pets Place Veterinary Clinic', 'Aritao, Nueva Vizcaya', '2025-11-22', 'Hematology Analyzer', '7.40828204562E11', 'Light PMS', '', 0, 0, NULL),
(121, '000120', 'Angel', 'Pets Place Veterinary Clinic', 'Dupax Del Norte, Nueva Vizcaya', '2025-11-22', 'Hematology Analyzer', '08B0224230433', 'Light PMS', '', 0, 0, NULL),
(122, '000121', 'Angel', 'Animedics Veterinary Clinic', 'Bambang, Nueva Vizcaya', '2025-11-22', 'Hematology Analyzer', '7.40305193348E11', 'Light PMS', '', 0, 0, NULL),
(123, '000122', 'Angel', 'C & A Pet Clinic', 'Bayombong, Nueva Vizcaya', '2025-11-22', 'Hematology Analyzer', '08BO607250976', 'Light PMS', '', 0, 0, NULL),
(124, '000123', 'Angel', 'Animedics Veterinary Clinic', 'Solano, Nueva Vizcaya', '2025-11-22', 'Hematology Analyzer', '08B0915210052', 'Light PMS', '', 0, 0, NULL),
(125, '000124', 'Angel', 'Vet Tag Animal Clinic', 'Solano, Nueva Vizcaya', '2025-11-22', 'Hematology Analyzer', '08B1017220336', 'Light PMS', '', 0, 0, NULL),
(126, '000125', 'Angel', 'Pets Life Vet Clinic', 'Bagabag, Nueva Vizcaya', '2025-11-22', 'Hematology Analyzer', '08B1007230556', 'Light PMS', '', 0, 0, NULL),
(127, '000126', 'Angel', 'Animal Corner Veterinary Clinic', 'Santiago, Isabela', '2025-11-24', 'Hematology Analyzer', '08B0427230480', 'Light PMS', '', 0, 0, NULL),
(128, '000127', 'Angel', 'Faith Pet Clinic', 'Santiago, Isabela', '2025-11-24', 'Hematology Analyzer', '08B1017220323', 'Manual cleaning of chemistry', '', 0, 0, NULL),
(129, '000128', 'Jashrille', 'Clinica Animalia Veterinary Clinic', 'Roxas, Isabela', '2025-12-11', 'Hematology Analyzer', '8.60603211485E11', 'Light PMS', '', 0, 0, NULL),
(130, '000129', 'Jashrille', 'Urban Fur Vet Clinic', 'Tuguegarao City', '2025-11-25', 'Hematology Analyzer', '7.40305193349E11', 'Quality Control', '', 0, 0, NULL),
(131, '000130', 'Jashrille', 'Waggie Tail Veterinary Clinic', 'Tuguegarao City', '2025-11-25', 'Hematology Analyzer', '7.40619193655E11', 'Quality Control', '', 0, 0, NULL),
(132, '000131', 'Jashrille', 'Animal Options Veterinary Clinic', 'Caritan Sur, Tuguegarao', '2025-11-25', 'Hematology Analyzer', '7.71027161514E11', 'Quality Control', '', 0, 0, NULL),
(133, '000132', 'Jashrille', 'Bark Avenue Veterinary Clinic', 'Tuguegarao City', '2025-11-25', 'Hematology Analyzer', '08G1213230664', 'Quality Control', '', 0, 0, NULL),
(134, '000133', 'Jashrille', 'Bulanao Veterinary Clinic', 'Bulanao Tabuk, Kalinga', '2025-11-28', 'Hematology Analyzer', '08B0915210058', 'Quality Control', '', 0, 0, NULL),
(135, '000134', 'Jashrille', 'AR Veterinary Clinic', 'Dagupan, Kalinga', '2025-11-28', 'Hematology Analyzer', '7.40727204523E11', 'Quality Control', '', 0, 0, NULL),
(136, '000135', 'Jashrille', 'AR Veterinary Clinic', 'Bulanao Tabuk, Kalinga', '2025-11-28', 'Hematology Analyzer', '7.40628204422E11', 'Quality Control', '', 0, 0, NULL),
(137, '000136', 'Jashrille', 'Up North Veterinary Services', 'Tabuk Kalinga', '2025-11-28', 'Hematology Analyzer', '08B1007230557', 'Quality Control', '', 0, 0, NULL),
(138, '000137', 'Jashrille', 'Solana Pets Veterinary Clinic', 'Solana, Cagayan', '2025-11-28', 'Hematology Analyzer', '08B1017220330', 'Quality Control', '', 0, 0, NULL),
(139, '000138', 'Jashrille', 'Clinica Animalia Veterinary Clinic', 'Roxas, Isabela', '2025-01-12', 'Hematology Analyzer', '8.60603211485E11', 'Quality Control', '', 0, 0, NULL),
(140, '000139', 'Jashrille', 'Jhay Veterinary Clinic', 'Cabatuan, Isabela', '2025-01-12', 'Hematology Analyzer', '08B0818210036', 'Quality Control', '', 0, 0, NULL),
(141, '000140', 'Jashrille', 'Faith Pet Clinic', 'Santiago, Isabela', '2025-02-12', 'Hematology Analyzer', '08B1017220323', 'Quality Control', '', 0, 0, NULL),
(142, '000141', 'Jashrille', 'Quirino Pet House', 'Diffun, Quirino', '2025-02-12', 'Hematology Analyzer', '08B0628220247', 'Quality Control', '', 0, 0, NULL),
(143, '000142', 'Jashrille', 'Animal Corner Veterinary Clinic', 'Santiago, Isabela', '2025-02-12', 'Hematology Analyzer', '08B0427230480', 'Quality Control', '', 0, 0, NULL),
(144, '000143', 'Jashrille', 'Alicia Animal Clinic', 'Alicia, Isabela', '2025-03-12', 'Hematology Analyzer', '08B0416220191', 'Quality Control', '', 0, 0, NULL),
(145, '000144', 'Jashrille', 'Clinica Animalia Veterinary Clinic', 'Echague, Isabela', '2025-03-12', 'Hematology Analyzer', '8.60603211458E11', 'Quality Control', '', 0, 0, NULL),
(146, '000145', 'Jashrille', 'Gambala Veterinary Clinic', 'Echague, Isabela', '2025-03-12', 'Hematology Analyzer', '08B1017220322', 'Quality Control', '', 0, 0, NULL),
(147, '000146', 'Jashrille', 'Animal Corner Veterinary Clinic', 'Cauayan, Isabela', '2025-03-12', 'Hematology Analyzer', '08B0628220249', 'Quality Control', '', 0, 0, NULL),
(148, '000147', 'CANCELLED', 'Clinica Animalia Veterinary Clinic', 'Cauayan, Isabela', '0000-00-00', 'Hematology Analyzer', '', '', '', 0, 0, NULL),
(149, '000148', 'Jashrille', 'Clinica Animalia Veterinary Clinic', 'Cauayan, Isabela', '2025-03-12', 'Hematology Analyzer', '08B0909240791', 'Quality Control', '', 0, 0, NULL),
(150, '000149', 'Jashrille', 'Doc Sharon Veterinary Clinic', 'Cauayan, Isabela', '2025-03-12', 'Hematology Analyzer', '08B0628220259', 'Quality Control', '', 0, 0, NULL),
(151, '000150', 'Jashrille', 'Clinica Animalia Veterinary Clinic', 'Tumauini, Isabela', '2025-04-12', 'Hematology Analyzer', '08B1017220335', 'Quality Control', '', 0, 0, NULL),
(152, '000151', 'Jon', 'Doc Jen Veterinary Clinic', 'Sta. Maria, Bulacan', '2025-12-01', 'Hematology Analyzer', '08B1213230655', 'Quality Control', '', 0, 0, NULL),
(153, '000152', 'Jon', 'Vet Furpaws Pet Care Services', 'Sta. Maria, Bulacan', '2025-12-01', 'Hematology Analyzer', '08B1017220323', 'Quality Control', '', 0, 0, NULL),
(154, '000153', 'Jon', 'Puppyko Animal Clinic', 'San Jose Del Monte, Bulacan', '2025-12-01', 'Hematology Analyzer', '08B0909240802', 'Quality Control', '', 0, 0, NULL),
(155, '000154', 'Jon', 'Galaxy Paws Animal Clinic', 'Caloocan City, Manila', '2025-12-02', 'Hematology Analyzer', '08B0706230544', 'Quality Control', '', 0, 0, NULL),
(156, '000155', 'Jon', 'AC & W Veterinary Clinic', 'Caloocan City, Manila', '2025-12-02', 'Hematology Analyzer', '08B0909240804', 'Quality Control', '', 0, 0, NULL),
(157, '000156', 'Jon', 'Rue St. Roche Vet Clinic', 'San Pablo, Laguna', '2025-12-03', 'Hematology Analyzer', '08B0708230532', 'Quality Control', '', 0, 0, NULL),
(158, '000157', 'Jon', 'Infanta Veterinary Clinic', 'Infanta, Quezon', '2025-12-04', 'Hematology Analyzer', '08B090924807', 'Quality Control', '', 0, 0, NULL),
(159, '000158', 'Jon', 'Bridgeway Veterinary Clinic / Psalms Paws Veterinary Clinic', 'Morong, Rizal', '2025-12-04', 'Hematology Analyzer', '08B0909240793', 'Quality Control', '', 0, 0, NULL),
(160, '000159', 'Jon', 'Tail buddy Animal Clinic And Grooming Station', 'Lipa, Batangas', '2025-12-05', 'Hematology Analyzer', '08B0427230467', 'Quality Control', '', 0, 0, NULL),
(161, '000160', 'Jon', 'Ecovet Animal Clinic', 'Ibaan, Batangas', '2025-12-05', 'Hematology Analyzer', '08B0708230531', 'Quality Control', '', 0, 0, NULL),
(162, '000161', 'Jon', 'BK Petaholic Animal Clinic', 'Batangas City, Batangas', '2025-12-05', 'Hematology Analyzer', '08B0909240800', 'Quality Control', '', 0, 0, NULL),
(163, '000162', 'Jon', 'B.V. Seda Animal Care Clininc', 'Lemery, Batangas', '2025-12-05', 'Hematology Analyzer', '08B0909240799', 'Quality Control', '', 0, 0, NULL),
(164, '000163', 'Jon', 'Pawfessional Veterinary Clinic', 'Rodriguez, Rizal', '2025-12-08', 'Hematology Analyzer', '08B1209220384', 'Quality Control', '', 0, 0, NULL),
(165, '000164', 'Jon', 'Petfriends Veterinary Clinic', 'Rodriguez, Rizal', '2025-12-08', 'Hematology Analyzer', '08B1213230683', 'No CBC', '', 0, 0, NULL),
(166, '000165', 'Jon', 'RMC Veterinary Clinic', 'San Mateo, Rizal', '2025-12-08', 'Hematology Analyzer', '08B0427230474', 'Quality Control', '', 0, 0, NULL),
(167, '000166', 'Jon', 'Cuddly Care Animal Clinic', 'Marikina City, Metro Manila', '2025-09-12', 'Hematology Analyzer', '08B0628220357', 'Quality Control', '', 0, 0, NULL),
(168, '000167', 'Jon', 'Vetlane Animal Clinic', 'Cubao, Quezon City', '2025-09-12', 'Hematology Analyzer', '08B1213230681', 'Quality Control', '', 0, 0, NULL),
(169, '000168', 'Jon', 'Annapolis Veterinary Care Center', 'San Juan City, Metro Manila', '2025-09-12', 'Hematology Analyzer', '08B1213230675', 'Quality Control', '', 0, 0, NULL),
(170, '000169', 'Jon', 'Carmona Veterinary Clinic', 'Carmona, Cavite', '2025-11-12', 'Hematology Analyzer', '08B1213230669', 'Quality Control', '', 0, 0, NULL),
(171, '000170', 'Jon', 'Furr-fect Paws Animal Clinic', 'GMA, Cavite', '2025-11-12', 'Hematology Analyzer', '08B0909240794', 'Quality Control', '', 0, 0, NULL),
(172, '000171', 'Jon', 'Langkaan Animal Clinic', 'Dasmariñas City, Cavite', '2025-11-12', 'Hematology Analyzer', '08B0909240830', 'Quality Control', '', 0, 0, NULL),
(173, '000172', 'Jon', 'Petfriends Veterinary Clinic', 'General Trias, Cavite', '2025-12-12', 'Hematology Analyzer', '08B1213230683', 'Quality Control', '', 0, 0, NULL),
(174, '000173', 'Jon', 'Agapet Animal Clinic', 'General Trias, Cavite', '2025-12-12', 'Hematology Analyzer', '08B121323066', 'Quality Control', '', 0, 0, NULL),
(175, '000174', 'Jon', 'Pawprints Animal Clinic', 'General Trias, Cavite', '2025-12-12', 'Hematology Analyzer', '08B0909240813', 'Quality Control', '', 0, 0, NULL),
(176, '000175', 'Jon', 'Pet Champ Animal Clinic', 'Tanza, Cavite', '2025-12-12', 'Hematology Analyzer', '08B1213230673', 'Quality Control', '', 0, 0, NULL),
(177, '000176', 'Jon', 'Furry Petfriends Veterinary Clinic', 'Tanza, Cavite', '2025-12-12', 'Hematology Analyzer', '08B1213230668', 'Quality Control', '', 0, 0, NULL),
(178, '000177', 'Jon', '3KE Pet Solution Animal Clinic', 'Kawit, Cavite', '2025-12-12', 'Hematology Analyzer', '08B0224230440', 'Quality Control', '', 0, 0, NULL),
(179, '000178', 'Jon', 'Gambala Veterinary Clinic', 'Echague, Isabela', '2026-05-01', 'Hematology Analyzer', '08B1017220322', 'Technical Concern - Machine motor is loud we put grease', '', 0, 0, NULL),
(180, '000179', 'Jon', 'Vetlane Animal Clinic', 'Cubao, Quezon City', '2026-01-15', 'Hematology Analyzer', '08B1213230681', 'Light PMS', '', 0, 0, NULL),
(181, '000180', 'Jon', 'Vet Street Animal Medical Center / JMIC Animal Medical Center', 'Caloocan City, Metro Manila', '2026-01-15', 'Hematology Analyzer', '08B1213230672', 'Quality Control', '', 0, 0, NULL),
(182, '000181', 'Jon', 'Pet Express / JMIC Animal Medical Center', 'SM San Lazaro, Metro Manila', '2026-01-16', 'Hematology Analyzer', '08B1213230672', 'Quality Control', '', 0, 0, NULL),
(183, '000182', 'Jon', 'Medpaws Veterinary Clinic', 'Quezon City, Metro Manila', '2026-01-16', 'Hematology Analyzer', '08B1007230560', 'Quality Control', '', 0, 0, NULL),
(184, '000183', 'Jon', 'Pawfessional Veterinary Clinic', 'Rodriguez, Rizal', '2026-01-16', 'Hematology Analyzer', '08B1209220384', 'Light PMS', '', 0, 0, NULL),
(185, '000184', 'Jon', 'Bridgeway Veterinary Clinic / Psalms Paws Veterinary Clinic', 'Morong, Rizal', '2026-01-19', 'Hematology Analyzer', '08B0909240793', 'Heavy PMS', '', 0, 0, NULL),
(186, '000185', 'Jon', 'Puppyko Animal Clinic', 'San Jose Del Monte, Bulacan', '2026-01-20', 'Hematology Analyzer', '08B0909240802', 'Light PMS', '', 0, 0, NULL),
(187, '000186', 'Jon', 'Doc Jen Veterinary Clinic', 'Sta. Maria, Bulacan', '2026-01-20', 'Hematology Analyzer', '08B1213230655', 'Light PMS', '', 0, 0, NULL),
(188, '000187', 'Jon', 'Animal Access Veterinary Clinic', 'San Ildefenso, Bulacan', '2026-01-20', 'Chemistry Analyzer', '6.3110123200083E13', '', '', 0, 0, NULL),
(189, '000188', 'Jon', 'Noah\'s Ark Animal Clinic', 'Gapan, Nueva Ecija', '2026-01-21', 'Hematology Analyzer', '08B1022210135', 'Quality Control', '', 0, 0, NULL),
(190, '000189', 'Jon', 'Mivet Veterinary Clinic', 'Tagaytay City Cavite', '2026-01-22', 'Hematology Analyzer', '08B1213230651', 'Quality Control', '', 0, 0, NULL),
(191, '000190', 'Jon', 'M Street Pet Grooming & Animal Clinic', 'Alfonso, Cavite', '2026-01-23', 'Hematology Analyzer', '08B0909240790', 'Quality Control', '', 0, 0, NULL),
(192, '000191', 'Jon', 'Golden Vet Animal Clinic', 'Imus, Cavite', '2026-01-23', 'Hematology Analyzer', '08B0909240808', 'Quality Control', '', 0, 0, NULL),
(193, '000192', 'Jon', 'Franjels Veterinary Clinic', 'San Pedro, Laguna', '2026-01-24', 'Hematology Analyzer', '08B1213230650', 'Quality Control', '', 0, 0, NULL),
(194, '000193', 'Jon', 'Gracious Paws Veterinary Clinic', 'Santa Rosa, Laguna', '2026-01-24', 'Hematology Analyzer', '08B0607250970', 'Quality Control', '', 0, 0, NULL),
(195, '000194', 'Jon', 'Vet Tag Animal Clinic', 'Solano, Nueva Vizcaya', '2026-01-27', 'Hematology Analyzer', '08B1017220336', 'Heavy PMS', '', 0, 0, NULL),
(196, '000195', 'Jon', 'Animedics Veterinary Clinic', 'Bagabag, Nueva Ecija', '2026-01-27', 'Hematology Analyzer', '8.60416200531E11', 'Heavy PMS', '', 0, 0, NULL),
(197, '000196', 'Jon', 'Daddy Doc Veterinary Clinic', 'Cabatuan, Isabela', '2026-01-27', 'Hematology Analyzer', '7.40727204524E11', 'Heavy PMS', '', 0, 0, NULL),
(198, '000197', 'Jon', 'Kho Veterinary Clinic', 'Daet, Camarines Norte', '2026-02-02', 'Hematology Analyzer', '08B062S220277', 'Quality Control', '', 0, 0, NULL),
(199, '000198', 'Jon', 'Assumpta Vet Care Animal Clinic', 'Goa, Camarines Sur', '2026-04-02', 'Hematology Analyzer', '08B090924C789', 'Quality Control', '', 0, 0, NULL),
(200, '000199', 'Jon', 'Doctor Noah\'s Veterinary Clinic', 'Legazpi City, Albay', '2026-05-02', 'Hematology Analyzer', '08B0909240814', 'Quality Control', '', 0, 0, NULL),
(201, '000200', 'Jon', 'Vetcare Animal Clinic', 'Legazpi City, Albay', '2026-05-02', 'Hematology Analyzer', '08B0909240921', 'Quality Control', '', 0, 0, NULL),
(202, '000201', 'Jayrald', 'Gopets Veterinary Clinic', 'Baguio City, Benguet', '2025-11-26', 'Hematology Analyzer', '08B0628220251', 'Quality Control', '', 0, 0, NULL),
(203, '000202', 'Jayrald', 'Pet Treasures Veterinary Clinic', 'Baguio City, Benguet', '2025-11-27', 'Hematology Analyzer', '08B1017220328', 'Quality Control', '', 0, 0, NULL),
(204, '000203', 'Jayrald', 'Urban Pets vet Clinic', 'Baguio City, Benguet', '2025-11-27', 'Hematology Analyzer', '08B0416220219', 'Quality Control', '', 0, 0, NULL),
(205, '000204', 'Jayrald', 'Faithful Friend Vet Clinic', 'Baguio City, Benguet', '2025-12-27', 'Hematology Analyzer', '08B0927210098', 'Quality Control', '', 0, 0, NULL),
(206, '000205', 'Jayrald', 'Animal Haven Veterinary Clinic', 'La Triinidad, Benguet', '2025-11-27', 'Hematology Analyzer', '7.41015204611E11', 'Quality Control', '', 0, 0, NULL),
(207, '000206', 'Jayrald', 'Family Vet Clinic', 'Baguio City, Benguet', '2025-11-27', 'Hematology Analyzer', '08B1208220389', 'Quality Control', '', 0, 0, NULL),
(208, '000207', 'Jayrald', 'The Pet Pro Veterinary Clinic', 'Baguio City, Benguet', '2025-11-28', 'Hematology Analyzer', '08B1007230558', 'Quality Control', '', 0, 0, NULL),
(209, '000208', 'Jayrald', 'Pines Veterinary Clinic', 'Baguio City, Benguet', '2025-11-28', 'Hematology Analyzer', '08B0628220246', 'Quality Control', '', 0, 0, NULL),
(210, '000209', 'Jayrald', 'Evexia Veterinary Clinic', 'Baguio City, Benguet', '2025-11-28', 'Hematology Analyzer', '08B1209220385', 'Quality Control', '', 0, 0, NULL),
(211, '000210', 'Jayrald', 'Pet Palisades Veterinary Clinic', 'Talavera, Nueva Ecija', '2025-01-12', 'Hematology Analyzer', '08B1209220376', 'Quality Control', '', 0, 0, NULL),
(212, '000211', 'Jayrald', 'Pets Vetfriend Veterinary Clinic', 'Guimba, Nueva Ecija', '2025-01-12', 'Hematology Analyzer', '08B0416220189', '', '', 0, 0, NULL),
(213, '000212', 'Jayrald', 'Maple Vet Clinic', 'Guimba, Nueva Ecija', '2025-01-12', 'Hematology Analyzer', '08B1230210178', 'Quality Control', '', 0, 0, NULL),
(214, '000213', 'Jayrald', 'Vet Street Veterinary Cinic', 'Muñoz, Nueva Ecija', '2025-01-12', 'Hematology Analyzer', '08B1213230680', 'Quality Control', '', 0, 0, NULL),
(215, '000214', 'Jayrald', 'Pet Alley Animal Clinic', 'San Jose, Nueva Ecija', '2025-01-12', 'Hematology Analyzer', '08B0427230489', 'Quality Control', '', 0, 0, NULL),
(216, '000215', 'Jayrald', 'Vet Next Door Animal Clinic', 'Lupao, Nueva Ecija', '2025-01-12', 'Hematology Analyzer', '08B0628220271', 'Quality Control', '', 0, 0, NULL),
(217, '000216', 'Jayrald', 'Pet Central Veterinary Clinic', 'San Isidro, Nueva Ecija', '2025-02-12', 'Hematology Analyzer', '08B0628220273', 'Quality Control', '', 0, 0, NULL),
(218, '000217', 'Jayrald', 'Pet Landia Animal Clinic', 'General Tinio, Nueva Ecija', '2025-02-12', 'Hematology Analyzer', '08B0416220204', 'Quality Control', '', 0, 0, NULL),
(219, '000218', 'Jayrald', 'NextDoor Pet Care Services', 'San Miguel, Bulacan', '2025-02-12', 'Hematology Analyzer', '08B0628220253', 'Quality Control', '', 0, 0, NULL),
(220, '000219', 'Jayrald', 'Gopez Veterinary Clinic', 'Arayat, Pampanga', '2025-02-12', 'Hematology Analyzer', '08B0416220218', 'Quality Control', '', 0, 0, NULL),
(221, '000220', 'Jayrald', 'Pet Medix Vet Clinic', 'Arayat, Pampanga', '2025-02-12', 'Hematology Analyzer', '08B0427230460', 'Quality Control', '', 0, 0, NULL),
(222, '000221', 'Jayrald', 'Paw Spot Veterinary Clinic', 'Angeles, Pampanga', '2025-03-12', 'Hematology Analyzer', '08B090924805', 'Quality Control', '', 0, 0, NULL),
(223, '000222', 'Jayrald', 'Happy Tails Pet Care Clinic / Pampang Animal Clinic', 'Angeles, Pampanga', '2025-03-12', 'Hematology Analyzer', '08B0224230416', 'Quality Control', '', 0, 0, NULL),
(224, '000223', 'Jayrald', 'Little Paws Haven Veterinary Clinic', 'Angeles, Pampanga', '2025-03-12', 'Hematology Analyzer', '08B0909240815', 'Quality Control', '', 0, 0, NULL),
(225, '000224', 'Jayrald', 'Pets Line Mexico Veterinary Clinic', 'Mexico, Pampanga', '2025-03-12', 'Hematology Analyzer', '08B0813220302', 'Quality Control', '', 0, 0, NULL),
(226, '000225', 'Jayrald', 'Capitol Veterinary Clinic / Pawssabilities Animal Clinic', 'Mexico, Pampanga', '2025-03-12', 'Hematology Analyzer', '08B0818210037', 'Quality Control', '', 0, 0, NULL),
(227, '000226', 'Jayrald', 'Howllistic Vet Clinic', 'San Fernando, Pampanga', '2025-03-12', 'Hematology Analyzer', '08B1017220324', 'Quality Control', '', 0, 0, NULL),
(228, '000227', 'Jayrald', 'Noble Pets Veterinary Clinic', 'San Fernando, Pampanga', '2025-04-12', 'Hematology Analyzer', '08B0427230493', 'Quality Control', '', 0, 0, NULL),
(229, '000228', 'CANCELLED', 'Peninsula Veterinary Clinic', 'Pilar, Bataan', '2025-04-12', 'Hematology Analyzer', '08B1209220377', '', '', 0, 0, NULL),
(230, '000229', 'Jayrald', 'Peninsula Veterinary Clinic', 'Pilar, Bataan', '2025-04-12', 'Hematology Analyzer', '08B1209220377', 'Quality Control', '', 0, 0, NULL),
(231, '000230', 'Jayrald', 'Salubrious Toptails Animal Clinic / Zoe\'s Clapier Veterinary Clinic', 'Orion, Bataan', '2025-04-12', 'Hematology Analyzer', '08B1213230688', 'Quality Control', '', 0, 0, NULL),
(232, '000231', 'Jayrald', 'Doc Gregg Veterinary Clinic', 'Olonggapo, Zambales', '2025-05-12', 'Hematology Analyzer', '08B1017220340', 'Quality Control', '', 0, 0, NULL),
(233, '000232', 'Jayrald', 'Jamel Vets and Furries Animal Clinic', 'San Felipe, Zambales', '2025-05-12', 'Hematology Analyzer', '08B0628220250', 'Quality Control', '', 0, 0, NULL),
(234, '000233', 'Jayrald', 'Niedo\'s Animal Clinic', 'Botolan, Zambales', '2025-05-12', 'Hematology Analyzer', '08B0628220272', 'Quality Control', '', 0, 0, NULL),
(235, '000234', 'Jayrald', 'Jamel Vets and Furries Animal Clinic', 'Masinloc, Zambales', '2025-05-12', 'Hematology Analyzer', '', 'Quality Control', '', 0, 0, NULL),
(236, '000235', 'Jayrald', 'Jamel Vets and Furries Animal Clinic', 'Sta. Cruz, Zambales', '2025-05-12', 'Hematology Analyzer', '08B0427230473', 'Quality Control', '', 0, 0, NULL),
(237, '000236', 'Jayrald', 'Cape Bolinao Veterinary Clinic', 'Bolinao, Pangasinan', '2025-06-12', 'Hematology Analyzer', '', 'Quality Control', '', 0, 0, NULL),
(238, '000237', 'Jayrald', 'Kanayunan Animal Clinic', 'Mangatarem, Pangasinan', '2025-06-12', 'Hematology Analyzer', '08B1213230671', 'Quality Control', '', 0, 0, NULL),
(239, '000238', 'Jayrald', 'Caden\'s Pet Care Veterinary Clinic', 'Sta Ignacia, Tarlac', '2025-06-12', 'Hematology Analyzer', '08B1213230677', 'Quality Control', '', 0, 0, NULL),
(240, '000239', 'Jayrald', 'Moergan and Friends Veterinary Clinic', 'Concepcion, Tarlac', '2025-08-12', 'Hematology Analyzer', '08B12132B0678', 'Quality Control', '', 0, 0, NULL),
(241, '000240', 'Jayrald', 'Paws and Furs Animal Clinic', 'Moncada, Tarlac', '2025-08-12', 'Hematology Analyzer', '08B0224230445', 'Quality Control', '', 0, 0, NULL),
(242, '000241', 'Jayrald', 'Collins Animal Clinic', 'Bayambang, Pangasinan', '2025-08-12', 'Hematology Analyzer', '08B0909240797', 'Quality Control', '', 0, 0, NULL),
(243, '000242', 'Jayrald', 'Nose to Tail Veterinary Clinic', 'Calasiao, Pangasinan', '2025-08-12', 'Hematology Analyzer', '8.60520211414E11', 'Quality Control', '', 0, 0, NULL),
(244, '000243', 'Jayrald', 'D and R Dog Cat Clinic', 'Calasiao, Pangasinan', '2025-08-12', 'Hematology Analyzer', '08B0426230490', 'Quality Control', '', 0, 0, NULL),
(245, '000244', 'Jayrald', 'D and R Dog Cat Clinic', 'Sual, Pangasinan', '2025-09-12', 'Hematology Analyzer', '08B1213230690', 'Quality Control', '', 0, 0, NULL),
(246, '000245', 'Jayrald', 'AMD Pets and Vets Clinic', 'San Fabian, Pangasinan', '2025-09-12', 'Hematology Analyzer', '08B0628220263', 'Quality Control', '', 0, 0, NULL),
(247, '000246', 'Jayrald', 'Rural Vet Clinic', 'San Fabian, Pangasinan', '2025-09-12', 'Hematology Analyzer', '08B1007230562', 'Quality Control', '', 0, 0, NULL),
(248, '000247', 'Jayrald', 'Manaoag Veterinary Clinic', 'Manaoag, Pangasinan', '2025-09-12', 'Hematology Analyzer', '08B0427230492', 'Quality Control', '', 0, 0, NULL),
(249, '000248', 'Jayrald', 'Pet Care Veterinary Clinic', 'Urdaneta, Pangasinan', '2025-10-12', 'Hematology Analyzer', '08B1007230559', 'Quality Control', '', 0, 0, NULL),
(250, '000249', 'Jayrald', 'Pet Stop Veterinary', 'Umingan, Pangasinan', '2025-10-12', 'Hematology Analyzer', '08B0909240825', 'Quality Control', '', 0, 0, NULL),
(251, '000250', 'Jayrald', 'Nose to Tail Veterinary Clinic', 'San Quintin, Pangasinan', '2025-10-12', 'Hematology Analyzer', '08B1007230563', 'Quality Control', '', 0, 0, NULL),
(252, '000251', 'Jashrille', 'JMW Animal Clinic', 'Cabagan, Isabela', '2025-12-04', 'Hematology Analyzer', '08B0915210055', 'Quality Control', '', 0, 0, NULL),
(253, '000252', 'Angel', 'Noble Pets Veterinary Clinic', 'San Fernando, Pampanga', '2025-12-10', 'Hematology Analyzer', '08B0427230493', 'Mid PMS', '', 0, 0, NULL),
(254, '000253', 'Angel', 'Pet Terrific Veterinary Clinic', 'Talavera, Nueva Ecija', '2025-12-08', 'Hematology Analyzer', '7.40314193437E11', 'Mid PMS', '', 0, 0, NULL),
(255, '000254', 'Angel', 'Pets Place Veterinary Clinic', 'Aritao, Nueva Ecija', '2025-12-29', 'Hematology Analyzer', '7.40828204562E11', 'Mid PMS', '', 0, 0, NULL),
(256, '000255', 'Angel', 'Noble Pets Veterinary Clinic', 'San Fernando, Pampanga', '2026-01-12', 'Hematology Analyzer', '08B0427230493', 'Mid PMS', '', 0, 0, NULL),
(257, '000256', 'Angel', 'Howllistic Vet Clinic', 'San Fernando, Pampanga', '2026-01-12', 'Hematology Analyzer', '08B1017220324', 'Light PMS', '', 0, 0, NULL),
(258, '000257', 'Angel', 'Capitol Veterinary Clinic / Pawssabilities Animal Clinic', 'San Fernando, Pampanga', '2026-01-12', 'Hematology Analyzer', '08B0818210037', 'Mid PMS', '', 0, 0, NULL),
(259, '000258', 'Angel', 'Buena Vida Animal Clinic', 'Santa Rosa, Nueva Ecija', '2026-01-13', 'Hematology Analyzer', '08B081820043', 'Light PMS', '', 0, 0, NULL),
(260, '000259', 'Angel', 'Vet Street Veterinary Cinic', 'Muñoz, Nueva Ecija', '2026-01-13', 'Hematology Analyzer', '08B1213230680', 'Light PMS', '', 0, 0, NULL),
(261, '000260', 'Angel', 'Pet Central Veterinary Clinic', 'San Isidro, Nueva Ecija', '2026-01-13', 'Hematology Analyzer', '08B0628220273', 'Light PMS', '', 0, 0, NULL),
(262, '000261', 'Angel', 'Noah\'s Ark Animal Clinic', 'Gapan, Nueva Ecija', '2026-01-14', 'Hematology Analyzer', '08B1022210135', 'Light PMS', '', 0, 0, NULL),
(263, '000262', 'Angel', 'NextDoor Pet Care Services', 'San Miguel, Bulacan', '2026-01-14', 'Hematology Analyzer', '08B0628220253', 'Light PMS', '', 0, 0, NULL),
(264, '000263', 'Angel', 'Vet Furpaws Pet Care Services', 'Santa Maria, Bulacan', '2026-01-14', 'Hematology Analyzer', '08B1017220320', 'Light PMS', '', 0, 0, NULL),
(265, '000264', 'Angel', 'Galaxy Paws Animal Clinic', 'Caloocan, Metro Manila', '2026-01-15', 'Hematology Analyzer', '08B0708230544', 'Light PMS', '', 0, 0, NULL),
(266, '000265', 'Angel', 'AC & W Veterinary Clinic', 'Caloocan, Metro Manila', '2026-01-15', 'Hematology Analyzer', '08B0909240804', 'Light PMS', '', 0, 0, NULL),
(267, '000266', 'Angel', 'RMC Veterinary Clinic', 'San Mateo, Rizal', '2026-01-15', 'Hematology Analyzer', '', 'Light PMS', '', 0, 0, NULL),
(268, '000267', 'Angel', 'Niedo\'s Animal Clinic', 'Botolan, Zambales', '2026-01-16', 'Hematology Analyzer', '08B0628220272', 'Light PMS', '', 0, 0, NULL),
(269, '000268', 'Angel', 'Jamel Vets and Furries Animal Clinic', 'San Felipe, Zambales', '2026-01-16', 'Hematology Analyzer', '08B06262202250', 'Light PMS', '', 0, 0, NULL),
(270, '000269', 'Angel', 'Dr. Vien Veterinary Clinic', 'San Marcelino, Zambales', '2026-01-17', 'Hematology Analyzer', '08B1209220388', 'Light PMS', '', 0, 0, NULL),
(271, '000270', 'Angel', 'Doc Gregg Veterinary Clinic', 'Olongapo City, Zambales', '2026-01-17', 'Hematology Analyzer', '8.6052021141E11', 'Mid PMS', '', 0, 0, NULL),
(272, '000271', 'Angel', 'Caden\'s Pet Care Veterinary Clinic', 'Sta. Ignacia, Tarlac', '2026-01-19', 'Hematology Analyzer', '08B1213230677', 'Mid PMS', '', 0, 0, NULL),
(273, '000272', 'Angel', 'Paws and Furs Animal Clinic', 'Moncada, Tarlac', '2026-01-19', 'Hematology Analyzer', '08B0224230445', 'Light PMS', '', 0, 0, NULL),
(274, '000273', 'Angel', 'Moergan and Friends Veterinary Clinic', 'Concepcion, Tarlac', '2026-01-19', 'Hematology Analyzer', '08B1213230678', 'Light PMS', '', 0, 0, NULL),
(275, '000274', 'Angel', 'Paw Spot Veterinary Clinic', 'Angeles City, Pampanga', '2026-01-19', 'Hematology Analyzer', '', 'Mid PMS', '', 0, 0, NULL),
(276, '000275', 'Angel', 'Pets Choice Animal Clinic', 'Sto. Tomas, Pampanga', '2026-01-20', 'Hematology Analyzer', '08B1213230676', 'Light PMS', '', 0, 0, NULL),
(277, '000276', 'Angel', 'Pets Line Mexico Veterinary Clinic', 'Mexico, Pampanga', '2026-01-20', 'Hematology Analyzer', '08B0813220302', 'Mid PMS', '', 0, 0, NULL),
(278, '000277', 'Angel', 'Pet Medix Vet Clinic', 'Arayat, Pampanga', '2026-01-20', 'Hematology Analyzer', '08B0427230460', 'Mid PMS', '', 0, 0, NULL),
(279, '000278', 'Angel', 'Gopez Veterinary Clinic', 'Arayat, Pampanga', '2026-01-20', 'Hematology Analyzer', '08B0416220228', 'Light PMS', '', 0, 0, NULL),
(280, '000279', 'Angel', 'Happy Tails Pet Care Clinic / Pampang Animal Clinic', 'Angeles City, Pampanga', '2026-01-20', 'Hematology Analyzer', '08B0224230416', 'Light PMS', '', 0, 0, NULL),
(281, '000280', 'Angel', 'Cuddly Care Animal Clinic', 'Marikina, Metro Manila', '2026-01-22', 'Hematology Analyzer', '08B0628220257', 'Light PMS', '', 0, 0, NULL),
(282, '000281', 'Angel', 'Annapolis Veterinary Care Center', 'San Juan, Manila', '2026-01-22', 'Hematology Analyzer', '08B1213230675', 'Light PMS', '', 0, 0, NULL),
(283, '000282', 'Angel', '3KE Pet Solution Animal Clinic', 'Kawit, Cavite', '2026-01-23', 'Hematology Analyzer', '08B0224230440', 'Mid PMS', '', 0, 0, NULL),
(284, '000283', 'Angel', 'Pet Champ Animal Clinic', 'Tanza, Cavite', '2026-01-23', 'Hematology Analyzer', '08B1213230673', 'Light PMS', '', 0, 0, NULL),
(285, '000284', 'Angel', 'Furry Petfriends Veterinary Clinic', 'Tanza, Cavite', '2026-01-23', 'Hematology Analyzer', '08B0909240801', 'Light PMS', '', 0, 0, NULL),
(286, '000285', 'Angel', 'Langkaan Animal Clinic', 'Dasmariñas, Cavite', '2026-01-24', 'Hematology Analyzer', '08B0909240830', 'Mid PMS', '', 0, 0, NULL),
(287, '000286', 'Angel', 'Nose to Tail Veterinary Clinic', 'Asingan, Pangasinan', '2026-01-24', 'Hematology Analyzer', '08B0427230488', 'Light PMS', '', 0, 0, NULL),
(288, '000287', 'Angel', 'Nose to Tail Veterinary Clinic', 'Sta. Maria, Bulacan', '2026-01-24', 'Hematology Analyzer', '08B0909240798', 'Light PMS', '', 0, 0, NULL),
(289, '000288', 'Angel', 'Pets Place Veterinary Clinic', 'Aritao, Nueva Ecija', '2026-01-24', 'Hematology Analyzer', '7.40828204562E11', 'Light PMS', '', 0, 0, NULL),
(290, '000289', 'Angel', 'C & A Pet Clinic', 'Bayombong, Nueva Vizcaya', '2026-01-27', 'Hematology Analyzer', '08B0607250976', 'Mid PMS', '', 0, 0, NULL),
(291, '000290', 'Angel', 'Salubrious Toptails Animal Clinic / Zoe\'s Clapier Veterinary Clinic', 'Orion, Bataan', '2026-02-10', 'Hematology Analyzer', '08B1213230688', 'Light PMS', '', 0, 0, NULL),
(292, '000291', 'Angel', 'Peninsula Veterinary Clinic', 'Pilar, Bataan', '2026-02-10', 'Hematology Analyzer', '08B1209220377', 'Light PMS', '', 0, 0, NULL),
(293, '000292', 'Angel', 'Vets and Furries Animal Clinic', 'Sta. Cruz, Zambales', '2026-02-11', 'Hematology Analyzer', '08B0427230473', 'Light PMS', '', 0, 0, NULL),
(294, '000293', 'Angel', 'Jamel Vets and Furries Animal Clinic', 'Masinloc, Zambales', '2026-02-11', 'Hematology Analyzer', '08B0909240827', 'Light PMS', '', 0, 0, NULL),
(295, '000294', 'Angel', 'Dr. Vien Veterinary Clinic', 'San Marcelino, Zambales', '2026-02-11', 'Hematology Analyzer', '08B1209220388', 'Light PMS', '', 0, 0, NULL),
(296, '000295', 'Angel', 'Jamel Vets and Furries Animal Clinic', 'San Felipe, Zambales', '2026-02-12', 'Hematology Analyzer', '08B0628220250', 'Light PMS', '', 0, 0, NULL),
(297, '000296', 'Angel', 'Pets Choice Animal Clinic', 'Sto. Tomas, Pampanga', '2026-02-18', 'Hematology Analyzer', '08B1213230676', 'Light PMS', '', 0, 0, NULL),
(298, '000297', 'Angel', 'Capitol Veterinary Clinic / Pawssabilities Animal Clinic', 'San Fernando, Pampanga', '2026-02-18', 'Hematology Analyzer', '08B0818210037', 'Light PMS', '', 0, 0, NULL),
(299, '000298', 'Angel', 'Noah\'s Ark Animal Clinic', 'Gapan, Nueva Ecija', '2026-02-19', 'Hematology Analyzer', '08B1022210135', 'Light PMS', '', 0, 0, NULL);
INSERT INTO `tb_pms` (`id`, `pms_number`, `service_tech`, `clinic`, `address`, `date`, `machine`, `sn`, `status`, `remarks`, `mfs`, `fsr`, `receipt`) VALUES
(300, '000299', 'Angel', 'Moergan and Friends Veterinary Clinic', 'Concepcion, Tarlac', '2026-02-20', 'Hematology Analyzer', '08B1213230678', 'Light PMS', '', 0, 0, NULL),
(301, '000300', 'Angel', 'Dr. Vien Veterinary Clinic', 'San Marcelino, Zambales', '2026-02-20', 'Hematology Analyzer', '08B1209220388', 'Mid PMS', '', 0, 0, NULL),
(302, '000301', 'Michael', 'JMW Animal Clinic', 'Cabagan, Isabela', '2026-01-15', 'Hematology Analyzer', '', 'Light PMS', '', 0, 0, NULL),
(303, '000302', 'Michael', 'Clinica Animalia Veterinary Clinic', 'Tumauini, Isabela', '2026-01-15', 'Hematology Analyzer', '08B1017220335', 'Light PMS', '', 0, 0, NULL),
(304, '000303', 'Michael', 'Clinica Animalia Veterinary Clinic', 'Roxas, Isabela', '2026-01-15', 'Hematology Analyzer', '8.60603211485E11', 'Light PMS', '', 0, 0, NULL),
(305, '000304', 'Michael', 'Daddy Doc Veterinary Clinic', 'Cabatuan, Isabela', '2026-01-15', 'Hematology Analyzer', '', 'Light PMS', '', 0, 0, NULL),
(306, '000305', 'Michael', 'Pet Avenue Veterianry Clinic', 'Diffun Quirino', '2026-01-16', 'Chemistry Analyzer', '200051.0', 'Manual Cleaning of Chemistry', '', 0, 0, NULL),
(307, '000306', 'Michael', 'Quirino Pet House', 'Diffun Quirino', '2026-01-16', 'Hematology Analyzer', '08B0628220247', 'Light PMS', '', 0, 0, NULL),
(308, '000307', 'Michael', 'Faith Pet Clinic', 'Santiago, Isabela', '2026-01-16', 'Hematology Analyzer', '08B1017220323', 'Light PMS', '', 0, 0, NULL),
(309, '000308', 'Michael', 'Animal Corner Veterinary Clinic', 'Santiago, Isabela', '2026-01-16', 'Hematology Analyzer', '08B0427230480', 'Light PMS', '', 0, 0, NULL),
(310, '000309', 'Michael', 'Gambala Veterinary Clinic', 'Echague, Isabela', '2026-01-16', 'Hematology Analyzer', '08B1017220322', 'Light PMS', '', 0, 0, NULL),
(311, '000310', 'Michael', 'Doc Sharon Veterinary Clinic', 'Cauayan, Isabela', '2026-01-19', 'Hematology Analyzer', '', 'Light PMS', '', 0, 0, NULL),
(312, '000311', 'Michael', 'LA Veterinary Clinic', 'Jones, Isabela', '2026-01-19', 'Hematology Analyzer', '08B0607250975', 'Light PMS', '', 0, 0, NULL),
(313, '000312', 'Michael', 'Alicia Animal Clinic', 'Alicia, Isabela', '2026-01-19', 'Hematology Analyzer', '', 'Light PMS', '', 0, 0, NULL),
(314, '000313', 'Michael', 'Animal Corner Veterinary Clinic', 'Cauayan, Isabela', '2026-01-19', 'Hematology Analyzer', '08B0628220249', 'Light PMS', '', 0, 0, NULL),
(315, '000314', 'Michael', 'Clinica Animalia Veterinary Clinic', 'Cauayan, Isabela', '2026-01-19', 'Hematology Analyzer', '08B0909240791', 'Light PMS', '', 0, 0, NULL),
(316, '000315', 'Michael', 'Favors Animal Clinic', 'Reina Mercedes, Isabela', '2026-01-19', 'Hematology Analyzer', '08B0909240826', 'Light PMS', '', 0, 0, NULL),
(317, '000316', 'Michael', 'Vets for Pets Animal Clinic', 'Laoag, Ilocos Nortes', '2026-02-03', 'Hematology Analyzer', '', 'Mid PMS', '', 0, 0, NULL),
(318, '000317', 'Michael', 'Vets for Pets Animal Clinic', 'Dingras, Ilocos Norte', '2026-02-03', 'Hematology Analyzer', '7.40827193878E11', 'Mid PMS', '', 0, 0, NULL),
(319, '000318', 'Michael', 'JC Paws & Claws Veterinary Clinic', 'Batac, Ilocos Norte', '2026-02-03', 'Hematology Analyzer', '08B0628220274', 'Light PMS', '', 0, 0, NULL),
(320, '000319', 'Michael', 'Paoay Animal Clinic', 'Paoay, Animal Clinic', '2026-02-03', 'Hematology Analyzer', '08B0909240823', 'Light PMS', '', 0, 0, NULL),
(321, '000320', 'Michael', 'Vet ni Bantay Animal Clinic', 'Bantay, Ilocos Sur', '2026-02-04', 'Hematology Analyzer', '08B1213230682', 'Light PMS', '', 0, 0, NULL),
(322, '000321', 'Michael', 'Francis Paul Benedict Vet Clinic', 'Vigan, Ilocos Sur', '2026-02-04', 'Hematology Analyzer', '08B0416220206', 'Mid PMS', '', 0, 0, NULL),
(323, '000322', 'Michael', 'Abaya Veterinary Clinic', 'Bangued, Abra', '2026-02-04', 'Hematology Analyzer', '08B0708230536', 'Light PMS', '', 0, 0, NULL),
(324, '000323', 'Michael', 'Urban Petcare Animal Clinic', 'Bangued, Abra', '2026-02-04', 'Hematology Analyzer', '08B0224230444', 'Light PMS', '', 0, 0, NULL),
(325, '000324', 'Michael', 'Aso at Pusa Veterinary Clinic', 'Bangued, Abra', '2026-02-04', 'Hematology Analyzer', '08B062822042', 'Light PMS', '', 0, 0, NULL),
(326, '000325', 'Michael', 'Narvacan Veterinary Clinic', 'Narvacan, Ilocos Sur', '2026-02-04', 'Hematology Analyzer', '08B1213230674', 'Light PMS', '', 0, 0, NULL),
(327, '000326', 'Michael', 'Vetwise Animal Clinic', 'Candon, Ilocos Sur', '2026-02-05', 'Hematology Analyzer', '08B0708230545', 'Light PMS', '', 0, 0, NULL),
(328, '000327', 'Michael', 'Vets Turf Animal Clinic', 'Candon, Ilocos Sur', '2026-02-05', 'Hematology Analyzer', '08B0708230530', 'Light PMS', '', 0, 0, NULL),
(329, '000328', 'Michael', 'Naki Veterinary Clinic', 'Tagudin, Ilocos Sur', '2026-02-05', 'Hematology Analyzer', '08B0427230472', 'Light PMS', '', 0, 0, NULL),
(330, '000329', 'Michael', 'Velvet Animal Clinic', 'Luna, La Union', '2026-02-05', 'Hematology Analyzer', '08B0628220275', 'Light PMS', '', 0, 0, NULL),
(331, '000330', 'Michael', 'Elyu Veterinary Clinic', 'San Juan, La Union', '2026-02-05', 'Hematology Analyzer', '08B0427232487', 'Light PMS', '', 0, 0, NULL),
(332, '000331', 'Michael', 'Rural Vet Clinic', 'San Fabian, Pangasinan', '2026-02-06', 'Hematology Analyzer', '08B1007230562', 'Mid PMS', '', 0, 0, NULL),
(333, '000332', 'Michael', 'AMD Pets and Vets Clinic', 'San Fabian, Pangasinan', '2026-02-06', 'Hematology Analyzer', '08B0628220263', 'Light PMS', '', 0, 0, NULL),
(334, '000333', 'Michael', 'D and R Dog Cat Clinic', 'Sual, Pangasinan', '2026-02-06', 'Hematology Analyzer', '08B1213230690', 'Light PMS', '', 0, 0, NULL),
(335, '000334', 'Michael', 'Cape Bolinao Veterinary Clinic', 'Bolinao, Pangasinan', '2026-02-06', 'Hematology Analyzer', '', 'Mid PMS', '', 0, 0, NULL),
(336, '000335', 'Michael', 'Pet Care Veterinary Clinic', 'Urdaneta, Pangasinan', '2026-02-09', 'Hematology Analyzer', '08B1007230559', 'Light PMS', '', 0, 0, NULL),
(337, '000336', 'Michael', 'Manaoag Veterinary Clinic', 'Manaoag, Pangasinan', '2026-02-09', 'Hematology Analyzer', '08B042723042', 'Light PMS', '', 0, 0, NULL),
(338, '000337', 'Michael', 'Petmax Veterinary Clinic', 'Agoo, La Union', '2026-02-10', 'Hematology Analyzer', '8.60108210997E11', 'Light PMS', '', 0, 0, NULL),
(339, '000338', 'Michael', 'PetHealth Care Vet Clinic', 'Agoo, La Union', '2026-02-10', 'Hematology Analyzer', '08B0628220255', 'Light PMS', '', 0, 0, NULL),
(340, '000339', 'Michael', 'Bauang Vet Care Clinic', 'Bauang, La Union', '2026-02-10', 'Hematology Analyzer', '08B1017220354', 'Light PMS', '', 0, 0, NULL),
(341, '000340', 'Michael', 'Gopets Veterinary Clinic', 'Baguio City, Benguet', '2026-02-11', 'Hematology Analyzer', '08B0628220251', 'Mid PMS', '', 0, 0, NULL),
(342, '000341', 'Michael', 'Pines Veterinary Clinic', 'Baguio City, Benguet', '2026-02-11', 'Hematology Analyzer', '', 'Light PMS', '', 0, 0, NULL),
(343, '000342', 'Michael', 'Faithful Friend Vet Clinic', 'Baguio City, Benguet', '2026-02-11', 'Hematology Analyzer', '08B0927210098', 'Light PMS', '', 0, 0, NULL),
(344, '000343', 'Michael', 'Addy Paws Animal Clinic', 'Sta Maria, Alfonso Lista, Ifugao', '2026-03-02', 'Hematology Analyzer', '', 'Light PMS', '', 0, 0, NULL),
(345, '000344', 'Michael', 'Vets for Pets Animal Clinic', 'Laoag City, Ilocos Norte', '2026-04-17', 'Hematology Analyzer', '08B1017230329', 'Light PMS', '', 0, 0, NULL),
(346, '000345', 'Michael', 'Paws and Claws Veterinary Clinic', 'Camalaniugan, Cagayan', '2026-04-18', 'Hematology Analyzer', '08B0628220256', 'Light PMS', '', 0, 0, NULL),
(347, '000346', 'Michael', 'AR Veterinary Clinic', 'Dagupan, Tabuk City', '2026-05-08', 'Hematology Analyzer', '7.40727204523E11', 'Mid PMS', '', 0, 0, NULL),
(348, '000347', 'Michael', 'Up North Veterinary Services', 'Tabuk, Kalinga', '2026-05-08', 'Hematology Analyzer', '08B1027230557', 'Light PMS', '', 0, 0, NULL),
(349, '000348', 'Michael', 'AR Veterinary Clinic', 'Bulanao, Tabuk City', '2026-05-08', 'Hematology Analyzer', '7.40628204422E11', 'Mid PMS', '', 0, 0, NULL),
(350, '000349', 'Michael', 'Bulanao Vet Clinic', 'Bulanao, Tabuk City', '2026-05-08', 'Hematology Analyzer', '08B0915210058', 'Light PMS', '', 0, 0, NULL),
(351, '000350', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(352, '000351', 'Jayrald', 'Pet Essentials Veterinary Clinic', 'Binalonan, Pangasinan', '2026-01-12', 'Hematology Analyzer', '8.60223211086E11', 'Heavy PMS', '', 0, 0, NULL),
(353, '000352', 'Jayrald', 'Pets Ville Veterinary Clinic', 'Laoac, Pangasinan', '2026-01-12', 'Hematology Analyzer', '08B1213230663', 'Heavy PMS', '', 0, 0, NULL),
(354, '000353', 'Jayrald', 'Nose to Tail Veterinary Clinic', 'Pozzurobio, Pangasinan', '2026-01-12', 'Hematology Analyzer', '7.40909193931E11', 'Heavy PMS', '', 0, 0, NULL),
(355, '000354', 'Jayrald', 'Nose to Tail Veterinary Clinic', 'Rosario, La Union', '2026-01-12', 'Hematology Analyzer', '7.40828204551E11', 'Heavy PMS/Troubleshoot', '', 0, 0, NULL),
(356, '000355', 'Jayrald', 'Vet Grace Animal Clinic', 'Agoo, La Union', '2026-01-12', 'Hematology Analyzer', '08B0416220209', 'Heavy PMS', '', 0, 0, NULL),
(357, '000356', 'Jayrald', 'Petmax Veterinary Clinic', 'Agoo, La Union', '2026-01-13', 'Hematology Analyzer', '8.60108210997E11', 'Heavy PMS', '', 0, 0, NULL),
(358, '000357', 'Jayrald', 'Pets Choice Veterinary Clinic', 'Bauang, La Union', '2026-01-13', 'Hematology Analyzer', '08B1017230339', 'Heavy PMS', '', 0, 0, NULL),
(359, '000358', 'Jayrald', 'Bauang Vet Care Clinic', 'Bauang, La Union', '2026-01-13', 'Hematology Analyzer', '08B1017220354', 'Light PMS', '', 0, 0, NULL),
(360, '000359', 'Jayrald', 'Valley Vets Animal Clinc', 'San Fernando, La Union', '2026-01-14', 'Hematology Analyzer', '08B1209220390', 'Heavy PMS', '', 0, 0, NULL),
(361, '000360', 'Jayrald', 'Neervet Animal Clinic', 'Bacnotan, La Union', '2026-01-14', 'Chemistry Analyzer', '210464.0', 'Manual Checking of Chemistry', '', 0, 0, NULL),
(362, '000361', 'Jayrald', 'Velvet Animal Clinic', 'Luna, La Union', '2026-01-14', 'Hematology Analyzer', '08B0627270275', 'Heavy PMS', '', 0, 0, NULL),
(363, '000362', 'Jayrald', 'Gentle Paws Animal Clinic', 'Bangar, La Union', '2026-01-14', 'Hematology Analyzer', '08B107220317', 'Heavy PMS', '', 0, 0, NULL),
(364, '000363', 'Jayrald', 'Naki Veterinary Clinic', 'Tagudin, Ilocos Sur', '2026-01-15', 'Hematology Analyzer', '08B0427230472', 'Heavy PMS', '', 0, 0, NULL),
(365, '000364', 'Jayrald', 'Vetwise Animal Clinic', 'Candon, Ilocos Sur', '2026-01-16', 'Hematology Analyzer', '08B0708330545', 'Heavy PMS', '', 0, 0, NULL),
(366, '000365', 'Jayrald', 'Abaya Veterinary Clinic', 'Bangued, Abra', '2026-01-16', 'Hematology Analyzer', '08B0708230536', 'Heavy PMS', '', 0, 0, NULL),
(367, '000366', 'Jayrald', 'Urban Petcare Animal Clinic', 'Bangued, Abra', '2026-01-16', 'Hematology Analyzer', '08B0224230444', 'Heavy PMS', '', 0, 0, NULL),
(368, '000367', 'Jayrald', 'Narvacan Veterinary Clinic', 'Narvacan, Ilocos Sur', '2026-01-16', 'Hematology Analyzer', '08B1213230674', 'Light PMS', '', 0, 0, NULL),
(369, '000368', 'Jayrald', 'Francis Paul Benedict Vet Clinic', 'Vigan City, Ilocos Sur', '2026-01-16', 'Hematology Analyzer', '08B0416220206', 'Light PMS', '', 0, 0, NULL),
(370, '000369', 'Jayrald', 'JC Paws & Claws Veterinary Clinic', 'Batac, Ilocos Norte', '2026-01-17', 'Hematology Analyzer', '08B0628220224', 'Heavy PMS', '', 0, 0, NULL),
(371, '000370', 'Jayrald', 'Vets for Pets Animal Clinic', 'Laoag, Pangasinan', '2026-01-17', 'Hematology Analyzer', '08B1017220329', 'Heavy PMS', '', 0, 0, NULL),
(372, '000371', 'Jayrald', 'Nose to Tail Veterinary Clinic', 'Tayug, Pangasinan', '2026-01-20', 'Hematology Analyzer', '08B0224230441', 'Light PMS', '', 0, 0, NULL),
(373, '000372', 'Jayrald', 'Peninsula Veterinary Clinic', 'Pilar, Bataan', '2026-01-21', 'Hematology Analyzer', '08B1209220377', 'Light PMS', '', 0, 0, NULL),
(374, '000373', 'Jayrald', 'Salubrious Toptails Animal Clinic / Zoe\'s Clapier Veterinary Clinic', 'Orion, Bataan', '2026-01-21', 'Hematology Analyzer', '08B1213230688', 'Light PMS', '', 0, 0, NULL),
(375, '000374', 'Jayrald', 'Kanayunan Animal Clinic', 'Mangatarem, Pangasinan', '2026-01-24', 'Hematology Analyzer', '08B1213230671', 'Light PMS', '', 0, 0, NULL),
(376, '000375', 'Jayrald', 'Rosario Vets Animal Clinic', 'Rosario, La Union', '2026-01-24', 'Hematology Analyzer', '08B0628220255', 'Heavy PMS', '', 0, 0, NULL),
(377, '000376', 'Jayrald', 'Vetsquad Animal Clinic', 'Pugo, La Union', '2026-01-24', 'Hematology Analyzer', '08B0427230491', 'Light PMS', '', 0, 0, NULL),
(378, '000377', 'Jayrald', 'Faithful Friend Vet Clinic', 'Baguio City, Benguet', '2026-01-24', 'Hematology Analyzer', '08B0927210098', 'Light PMS', '', 0, 0, NULL),
(379, '000378', 'Jayrald', 'Gopets Veterinary Clinic', 'Baguio City, Benguet', '2026-01-25', 'Hematology Analyzer', '08B0678220251', 'Light PMS', '', 0, 0, NULL),
(380, '000379', 'Jayrald', 'Up North Veterinary Services', 'Tabuk City, Kalinga', '2026-01-31', 'Hematology Analyzer', '08B1007230557', 'Light PMS', '', 0, 0, NULL),
(381, '000380', 'Jayrald', 'AR Veterinary Clinic', 'Tabuk City, Kalinga', '2026-01-31', 'Hematology Analyzer', '7.40727204523E11', 'Light PMS', '', 0, 0, NULL),
(382, '000381', 'Jayrald', 'Bulanao Veterinary Clinic', 'Tabuk City, Kalinga', '2026-01-31', 'Hematology Analyzer', '08B0915210058', 'Light PMS', '', 0, 0, NULL),
(383, '000382', 'Jayrald', 'AR Veterinary Clinic', 'Tabuk City, Kalinga', '2026-02-02', 'Hematology Analyzer', '7.40628204422E11', 'Light PMS', '', 0, 0, NULL),
(384, '000383', 'Jayrald', 'Animal Haven Veterinary Clinic', 'La Trinidad, Benguet', '2026-02-04', 'Hematology Analyzer', '7.41015204611E11', 'Light PMS', '', 0, 0, NULL),
(385, '000384', 'Jayrald', 'Pines Veterinary Clinic', 'Baguio City, Benguet', '2026-02-04', 'Hematology Analyzer', '08B06232202246', 'Light PMS', '', 0, 0, NULL),
(386, '000385', 'Jayrald', 'Urban Pets vet Clinic', 'Baguio City, Benguet', '2026-02-04', 'Hematology Analyzer', '08B0416220219', 'Light PMS', '', 0, 0, NULL),
(387, '000386', 'Jayrald', 'The Pet Pro Veterinary Clinic', 'Baguio City, Benguet', '2026-02-04', 'Hematology Analyzer', '08B1007230558', 'Light PMS', '', 0, 0, NULL),
(388, '000387', 'Jayrald', 'Rosario Vets Animal Clinic', 'Rosario, La Union', '2026-02-05', 'Hematology Analyzer', '08B1209220386', 'Heavy PMS', '', 0, 0, NULL),
(389, '000388', 'Jayrald', 'Agoo Animal Clinic', 'Agoo, La Union', '2026-02-06', 'Hematology Analyzer', '08B0909240816', 'Heavy PMS', '', 0, 0, NULL),
(390, '000389', 'Jayrald', 'San Manuel Veterinary Clinic', 'San Manuel, Pangasinan', '2026-02-06', 'Hematology Analyzer', '08B1017220321', 'Light PMS', '', 0, 0, NULL),
(391, '000390', 'Jayrald', 'Pet Stop Veterinary', 'Umingan, Pangasinan', '2026-02-06', 'Hematology Analyzer', '08B0909240825', 'Light PMS', '', 0, 0, NULL),
(392, '000391', 'Jayrald', 'Vet Next Door Animal Clinic', 'Lupao, Nueva Ecija', '2026-02-06', 'Hematology Analyzer', '08B06282202271', 'Light PMS', '', 0, 0, NULL),
(393, '000392', 'Jayrald', 'Pet Medix Vet Clinic', 'Arayat, Pampanga', '2026-03-09', 'Hematology Analyzer', '08B0417230460', 'Light PMS', '', 0, 0, NULL),
(394, '000393', 'Jayrald', 'Vet Grace Animal Clinic', 'Agoo, La Union', '2026-03-10', 'Hematology Analyzer', '08B0416220209', 'Light PMS', '', 0, 0, NULL),
(395, '000394', 'Jayrald', 'Doc Hero Veterinary Clinic', 'Cauayan City, Isabela', '2026-03-12', 'Hematology Analyzer', '08B0427830486', 'Heavy PMS', '', 0, 0, NULL),
(396, '000395', 'Jayrald', 'Vets for Pets Animal Clinic', 'Laoag City, Ilocos Norte', '2026-03-24', 'Hematology Analyzer', '08B1017220379', 'Light PMS', '', 0, 0, NULL),
(397, '000396', 'Jayrald', 'Vets for Pets Animal Clinic', 'Dingras, Ilocos Norte', '2026-03-25', 'Hematology Analyzer', '7.40827193878E11', 'Heavy PMS', '', 0, 0, NULL),
(398, '000397', 'Jayrald', 'Paoay Animal Clinic', 'Paoay, Ilocos Norte', '2026-03-25', 'Hematology Analyzer', '08B0909240823', 'Light PMS', '', 0, 0, NULL),
(399, '000398', 'Jayrald', 'Vet ni Bantay Animal Clinic', 'Bantay, Ilocos Sur', '2026-03-25', 'Hematology Analyzer', '08B12132330682', 'Light PMS', '', 0, 0, NULL),
(400, '000399', 'Jayrald', 'Francis Paul Benedict Vet Clinic', 'Vigan City, Ilocos Sur', '2026-03-25', 'Hematology Analyzer', '08B0416220206', 'Light PMS', '', 0, 0, NULL),
(401, '000400', 'Jayrald', 'Aso at Pusa Veterinary Clinic', 'Bangued, Abra', '2026-03-26', 'Hematology Analyzer', '08B0624220242', 'Heavy PMS', '', 0, 0, NULL),
(402, '000401', 'Jeffri', 'Blessed Creatures Veterinary Clinic', 'Camalig, Albay', '2026-06-02', 'Hematology Analyzer', '08B0607250971', 'Quality Control', '', 0, 0, NULL),
(403, '000402', 'Jeffri', 'Pawsetivety Veterinary Clinic', 'Pagbilao, Quezon', '2026-07-02', 'Hematology Analyzer', '08B0909240803', 'Quality Control', '', 0, 0, NULL),
(404, '000403', 'Jeffri', 'Doge & Cate Veterinary Clinic & Services', 'Calamba City, Laguna', '2026-07-02', 'Hematology Analyzer', '08B0909240806', 'Quality Control', '', 0, 0, NULL),
(405, '000404', 'Jeffri', 'D and M Veterinary Services', 'Caticlan, Malay Aklan', '2026-02-14', 'Hematology Analyzer', '08B0607250979', 'Heavy PMS', '', 0, 0, NULL),
(406, '000405', 'Jeffri', 'Doc Jen Veterinary Clinic', 'Sta. Maria, Bulacan', '2026-02-27', 'Hematology Analyzer', '08B1213230655', 'Light PMS', '', 0, 0, NULL),
(407, '000406', 'Jeffri', 'Cuddly Care Animal Clinic', 'Marikina City, Metro Manila', '2026-03-03', 'Hematology Analyzer', '08B0628220357', 'Heavy PMS', '', 0, 0, NULL),
(408, '000407', 'Jeffri', 'Bridgeway Veterinary Clinic / Psalms Paws Veterinary Clinic', 'Morong, Rizal', '2026-04-03', 'Hematology Analyzer', '08B0909240793', 'Light PMS', '', 0, 0, NULL),
(409, '000408', 'Jeffri', 'Pawfessional Veterinary Clinic', 'Rodriguez, Rizal', '2026-05-03', 'Hematology Analyzer', '08B1209220384', 'Heavy PMS', '', 0, 0, NULL),
(410, '000409', 'Jeffri', 'Petfriends Veterinary Clinic', 'Rodriguez, Rizal', '2026-05-03', 'Chemistry Analyzer', '27464.0', 'Manual Checking of Chemistry', '', 0, 0, NULL),
(411, '000410', 'Jeffri', 'JPecdaen Veterinary Clinic', 'Tagum City, Davao Del Norte', '2026-03-16', 'Hematology Analyzer', '7.4082820453E11', 'Heavy PMS', '', 0, 0, NULL),
(412, '000411', 'Jeffri', 'Island Haven Animal Clinic', 'Samal Island, Davao Del Norte', '2026-03-16', 'Hematology Analyzer', '', 'Heavy PMS', '', 0, 0, NULL),
(413, '000412', 'Jeffri', 'Fuzzy Friends Pet Clinic', 'Malaybalay City, Bukidnon', '2026-03-20', 'Chemistry Analyzer', '200142.0', 'Manual Checking of Chemistry', '', 0, 0, NULL),
(414, '000413', 'Jeffri', 'Ryle Animal Clinic', 'Malaybalay City, Bukidnon', '2026-03-20', 'Hematology Analyzer', '08B0607250967', 'Light PMS', '', 0, 0, NULL),
(415, '000414', 'CANCELLED', 'Sursur Animal Clinic', 'Tandag City, Surigao Del Sur', '0000-00-00', '', '', '', '', 0, 0, NULL),
(416, '000415', 'Jeffri', 'Sursur Animal Clinic', 'Tandag City, Surigao Del Sur', '2026-03-24', 'Hematology Analyzer', '08B0607250973', 'Heavy PMS', '', 0, 0, NULL),
(417, '000416', 'Jeffri', '3DS Veterinary Services & Supplies', 'Brgy Linibunan Nat\'l Hi-wayMadrid, Surigao Del Sur', '2026-03-24', 'Hematology Analyzer', '08B0607250978', 'Heavy PMS', '', 0, 0, NULL),
(418, '000417', 'Jeffri', 'Medpaws Veterinary Clinic', 'Quezon City, Metro Manila', '2026-05-07', 'Hematology Analyzer', '08B1007230560', 'Heavy PMS', '', 0, 0, NULL),
(419, '000418', 'Jeffri', 'Pawfessional Veterinary Clinic', 'Rodriguez, Rizal', '2026-05-08', 'Hematology Analyzer', '08B1209220384', 'Heavy PMS', '', 0, 0, NULL),
(420, '000419', 'Jeffri', 'Annapolis Veterinary Care Center', 'San Juan, Metro Manila', '2026-05-14', 'Hematology Analyzer', '08B1213230675', 'Light PMS', '', 0, 0, NULL),
(421, '000420', 'Jeffri', 'Bridgeway Veterinary Clinic / Psalms Paws Veterinary Clinic', 'Morong, Rizal', '2026-05-15', 'Hematology Analyzer', '08B0909240793', 'Light PMS', '', 0, 0, NULL),
(422, '000421', 'Jeffri', 'AC & W Veterinary Clinic', 'Caloocan, Metro Manila', '2026-05-16', 'Hematology Analyzer', '08B0909240804', 'Light PMS', '', 0, 0, NULL),
(423, '000422', 'Jeffri', 'Paws and Furs Animal Clinic', 'Moncada, Tarlac', '2026-05-18', 'Hematology Analyzer', '08B0224230445', 'Troubleshooting', '', 0, 0, NULL),
(424, '000423', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(425, '000424', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(426, '000425', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(427, '000426', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(428, '000427', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(429, '000428', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(430, '000429', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(431, '000430', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(432, '000431', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(433, '000432', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(434, '000433', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(435, '000434', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(436, '000435', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(437, '000436', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(438, '000437', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(439, '000438', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(440, '000439', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(441, '000440', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(442, '000441', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(443, '000442', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(444, '000443', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(445, '000444', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(446, '000445', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(447, '000446', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(448, '000447', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(449, '000448', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(450, '000449', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(451, '000450', '', '', '', '0000-00-00', '', '', '', '', 0, 0, NULL),
(452, '000451', 'Jeffri', 'Sursur Animal Clinic', 'Tandag City, Surigao Del Sur', '2026-01-12', 'Hematology Analyzer', '08B0607250973', 'Light PMS', '', 0, 0, NULL),
(502, '000001', 'Jayrald Macanang', 'Pet Central Veterinary Clinic', 'San Isidro, Nueva Ecija', '2025-10-20', 'Hematology Analyzer', '08B0628220273', 'Heavy PMS', '', 0, 0, NULL),
(503, '000004', 'Jashrille Pagulayan', '3DS Veterinary Services & Supplies', 'Madrid', '2026-10-08', 'Hematology', '08B0607250978', 'Mid PMS', 'asdasd', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_receipt`
--

CREATE TABLE `tb_receipt` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_location` varchar(255) NOT NULL,
  `date_upload` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rotor`
--

CREATE TABLE `tb_rotor` (
  `id` int(10) UNSIGNED NOT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `rotor` varchar(100) DEFAULT NULL,
  `lot_number` varchar(100) DEFAULT NULL,
  `product_code` varchar(100) DEFAULT NULL,
  `concern` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `replaceable` varchar(50) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `replaced` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `approve_management` tinyint(1) NOT NULL DEFAULT 0,
  `approve_manufacture` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_rotor`
--

INSERT INTO `tb_rotor` (`id`, `clinic_name`, `address`, `model`, `rotor`, `lot_number`, `product_code`, `concern`, `date`, `replaceable`, `reason`, `replaced`, `status`, `approve_management`, `approve_manufacture`) VALUES
(2, 'Infanta Veterinary Clinic', 'Infanta', 'CV5', 'Comprehensive', '250851', '', 'Reagent disk fault', '2026-01-10', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(3, 'B.V. Seda Animal Care Clininc', 'Lemery', 'VP20', 'Comprehensive', '20241002', '', 'Disk Error', '2026-01-11', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(4, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Comprehensive', '212169', '', 'Reagent disk fault', '2026-01-14', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(5, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'CV5', 'Comprehensive', '', '', 'Machine Lags', '2026-02-06', 'Yes', 'Machine problem', NULL, 'Delivered', 0, 0),
(6, 'JC Paws & Claws Veterinary Clinic', 'Batac', 'CV5', 'Comprehensive', '250851', '', 'No Foil Strips', '2026-02-17', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(7, 'Pines Veterinary Clinic', 'Baguio City', 'CV5/VP20', 'Comprehensive', '20250406', '', 'Disk Error', '2026-02-20', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(8, 'Daddy Doc Veterinary Clinic', 'Cabatuan', 'VP20', 'Comprehensive', '20250406', '', 'Disk Error', '2026-02-25', 'No', 'The problem is caused by hemolysis of the sample. We recommend that customers use centrifuged plasma for testing whenever possible. Samples with significant hemolysis require repeat blood collection for testing.', NULL, 'Report by Clinic', 0, 0),
(11, 'Pets Line Animal Clinic', 'Mexico', 'CV5', 'Health Checking', '251050', '', 'Reagent disk fault', '2026-02-28', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(12, 'Animedics Veterinary Clinic', 'Solano', 'CV5', 'Comprehensive', '250851', '12-25-048-004', 'Reagent disk fault', '2026-03-02', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(13, 'Winterfell Veterinary Clinic', 'Bontoc', 'CV5', 'Comprehensive', '250280', '', 'Reagent disk fault', '2026-03-03', 'No', 'The clinic is no longer purchasing rotors from the company.', NULL, 'Report by Clinic', 0, 0),
(14, 'Animal Options Veterinary Clinic', 'Tuguegarao City', 'CV5', 'Health Checking', '251151', '01-26-035-005', 'Reagent disk fault', '2026-03-10', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(15, 'Animal Options Veterinary Clinic', 'Tuguegarao City', 'CV5', 'Health Checking', '251151', '01-26-035-004', 'Reagent disk fault', '2026-03-14', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(16, 'Animal Options Veterinary Clinic', 'Tuguegarao City', 'CV5', 'Health Checking', '251151', '01-26-035-010', 'Reagent disk fault', '2026-03-17', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(17, 'Animal Corner Veterinary Clinic', 'Santiago City', 'CV5', 'Health Checking', '250851', '12-25-007-004', 'No Foil Strips', '2026-03-18', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(18, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'CV5', 'Comprehensive', '251152', '01-26-027-006', 'Machine Lags', '2026-03-25', 'Yes', 'Machine problem', NULL, 'Delivered', 0, 0),
(19, 'Pets Line Animal Clinic', 'Mexico', 'CV5', 'Health Checking', '251050', '', 'Reagent disk fault', '2026-03-26', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(20, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Health Checking', '251151', '01-26-039-003', 'Reagent disk fault', '2026-03-29', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(21, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Health Checking', '251151', '01-26-039-004', 'Reagent disk fault', '2026-03-29', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(22, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Health Checking', '251151', '01-26-039-002', 'Reagent disk fault', '2026-03-31', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(23, 'Infanta Veterinary Clinic', 'Infanta', 'CV5', 'Comprehensive', '251152', '01-26-024-007', 'Reagent disk fault', '2026-04-02', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(24, 'Pet Care Veterinary Clinic', 'Urdaneta', 'VP20', 'Comprehensive', '20251204', '01-26-013-010', 'Disk Error', '2026-04-06', 'No', 'Cause: The client failed to properly mix the sample and instead aspirated directly from the bottom of the sample tube; consequently, residual sample remains in the \"full\" position shown in the image. (Under normal circumstances, the circled region should be free of sample.)', NULL, NULL, 0, 0),
(25, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Health Checking', '20251204', '01-26-039-001', 'Reagent disk fault', '2026-04-11', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(26, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Health Checking', '251151', '01-26-039-006', 'Reagent disk fault', '2026-04-17', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(27, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'CV5', 'Comprehensive', '', '', 'Incorrect used of anticoagulant', '2026-04-18', 'No', 'Incorrect used of anticoagulant', NULL, NULL, 0, 0),
(28, 'Rural Vet Clinic', 'San Fabian', 'CV5', 'Health Checking', '251151', '01-26-038-009', 'Reagent disk fault', '2026-04-21', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(29, 'Rural Vet Clinic', 'San Fabian', 'CV5', 'Health Checking', '251151', '01-26-038-007', 'Reagent disk fault', '2026-04-25', 'Yes', 'Rotor problem', NULL, 'Report to Manufacture', 0, 0),
(30, 'JC Paws & Claws Veterinary Clinic', 'Batac', 'CV5', 'Comprehensive', '251152', '01-26-004-002', 'QR can\'t be used', '2026-05-03', 'Yes', 'QR can\'t be used.', NULL, 'Delivered', 0, 0),
(31, 'Animal Corner Veterinary Clinic', 'Santiago City', 'CV5', 'Comprehensive', '260250', '03-26-067-001', 'QR can\'t be used', '2026-05-05', 'Yes', 'QR can\'t be used.', NULL, 'Delivered', 0, 0),
(32, 'Animal Corner Veterinary Clinic', 'Santiago City', 'CV5', 'Comprehensive', '260250', '03-26-067-003', 'QR can\'t be used', '2026-05-05', 'Yes', 'QR can\'t be used.', NULL, 'Delivered', 0, 0),
(33, 'Animal Corner Veterinary Clinic', 'Santiago City', 'CV5', 'Comprehensive', '250851', '', 'QR can\'t be used', '2026-05-05', 'Yes', 'QR can\'t be used.', NULL, 'Report to Manufacture', 0, 0),
(34, 'Bark Avenue Veterinary Clinic', 'Tuguegarao City', 'CV5', 'Comprehensive', '251152', '01-26-038-003', 'Reagent disk fault', '2026-05-06', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(35, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Comprehensive', '251151', '01-26-003-002', 'Reagent disk fault', '2026-05-13', 'Yes', 'Rotor problem', NULL, 'Delivered', 0, 0),
(36, 'Jhay Veterinary Clinic', 'Cabatuan', 'CV5', 'Comprehensive', '251151', '01-26-038-007', 'Reagent disk fault', '2026-05-13', 'Yes', 'Rotor problem', NULL, 'Report to Manufacture', 0, 0),
(37, 'Rural Vet Clinic', 'San Fabian', 'CV5', 'Health Checking', '251151', '01-26-038-003', 'Reagent disk fault', '2026-05-14', 'Yes', 'Rotor problem', NULL, 'Report to Manufacture', 0, 0),
(38, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'CV5', 'Health Checking', '251151', '01-26-017-004', 'Reagent disk fault', '2026-05-14', 'Yes', 'Rotor problem', NULL, 'Report to Manufacture', 0, 0),
(39, 'Clinica Animalia Veterinary Clinic', 'Cauayan City', 'CV5', 'Health Checking', '251151', '01-26-017-003', 'Reagent disk fault', '2026-05-17', 'Yes', 'Rotor problem', NULL, 'Report to Manufacture', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_support`
--

CREATE TABLE `tb_support` (
  `id` int(11) NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `machine` varchar(255) DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `service_engr` varchar(255) DEFAULT NULL,
  `assisting` varchar(255) DEFAULT NULL,
  `concern` text DEFAULT NULL,
  `machine_status` varchar(50) DEFAULT NULL,
  `service_status` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'waiting',
  `remarks` varchar(255) NOT NULL,
  `returnstat` varchar(255) DEFAULT NULL,
  `support_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted_at` datetime DEFAULT NULL,
  `status_updated_at` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_support`
--

INSERT INTO `tb_support` (`id`, `ticket_number`, `clinic_name`, `province`, `address`, `machine`, `technician`, `service_engr`, `assisting`, `concern`, `machine_status`, `service_status`, `status`, `remarks`, `returnstat`, `support_date`, `created_at`, `accepted_at`, `status_updated_at`, `update_date`) VALUES
(6, 'SUP-000001', 'Waggie Tail Veterinary Clinic', 'Cagayan', 'Tuguegarao City', 'Vet Monitor', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Screen is glitching when screen is hardly touch/ Took so long to boot.', 'Not Operational', 'pullout', 'pullout', 'The unit was sent to China for servicing and repair. However, purchasing a new unit may be a more practical option, as the cost of servicing and replacement spare parts is considerably high.', 'return', '2025-02-24', '2026-09-28 05:50:13', '2026-09-28 13:50:16', '2026-09-28 13:57:32', '2026-09-28 13:57:32'),
(7, 'SUP-000002', 'Vet Tag Animal Clinic', 'Nueva Vizcaya', 'Solano/Bambang', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'Diluent sensor is detached due to recurrent of \"No Diluent\"', 'Fully Functional', '', 'done', 'Adjusted the potentiometer value and reattached the sensor.', NULL, '2025-04-07', '2026-09-28 05:56:29', '2026-09-28 13:56:33', '2026-09-28 13:57:17', NULL),
(8, 'SUP-000003', 'Carmona Veterinary Clinic', 'Cavite', 'Carmona', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'Recheck and reclean chamber of cbc.', 'Operational with Faults', '', 'done', 'Recheck and reclean chamber of cbc.', NULL, '2025-04-07', '2026-09-28 05:59:22', '2026-09-28 14:02:34', '2026-09-28 14:02:55', NULL),
(9, 'SUP-000004', 'Pet Adventure Animal Clinic', 'Bulacan', 'Sta Maria', 'Xray', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'Xray table needs to be repainted', 'Fully Functional', '', 'done', 'Repainted', NULL, '2025-04-07', '2026-09-28 06:00:32', '2026-09-28 14:02:10', '2026-09-28 14:02:32', NULL),
(10, 'SUP-000005', 'Vet Street Animal Medical Center / JMIC Animal Medical Center', 'Metro Manila', 'Caloocan', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'There\'s a horizontal grid lines on the screen and it keeps increasing.', 'Operational with Faults', '', 'done', 'Already replaced LCD Screen - Under warranty', NULL, '2025-07-16', '2026-09-28 06:01:25', '2026-09-28 14:01:31', '2026-09-28 14:02:07', NULL),
(11, 'SUP-000006', 'Furry Petfriends Veterinary Clinic', 'Cavite', 'Tanza', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'Result from the machine does not seem to be aligned with the patient conditions', 'Operational with Faults', '', 'done', 'Cleaned the machine.', NULL, '2025-07-17', '2026-09-28 06:04:11', '2026-09-28 14:04:15', '2026-09-28 14:04:50', NULL),
(12, 'SUP-000007', 'Pet Champ Animal Clinic', 'Cavite', 'Tanza', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'Result from the machine does not seem to be aligned with the patient conditions', 'Operational with Faults', '', 'done', 'Cleaned the machine.', NULL, '2025-07-17', '2026-09-28 06:05:41', '2026-09-28 14:05:43', '2026-09-28 14:05:55', NULL),
(13, 'SUP-000008', 'Furr-fect Paws Animal Clinic', 'Cavite', 'GMA', 'Chemistry', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'Machine prompts blank results', 'Operational with Faults', '', 'done', 'Rotor is the problem, already replaced the rotor.', NULL, '2025-07-24', '2026-09-28 06:06:49', '2026-09-28 14:06:51', '2026-09-28 14:07:17', NULL),
(14, 'SUP-000009', 'Kho Veterinary Clinic', 'Camarines Norte', 'Daet', 'Xray', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'Reported on July 18: X-ray PC took a long time to boot up which is unsual. The issue reoccured after 7 days.', 'Operational with Faults', '', 'done', 'Replaced the monitor.', NULL, '2025-07-25', '2026-09-28 06:08:12', '2026-09-28 14:08:15', '2026-09-28 14:08:35', NULL),
(15, 'SUP-000010', 'Kho Veterinary Clinic', 'Camarines Norte', 'Daet', 'Xray', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'The diluent tubing had a hole, and they initially resolved it by taping the tubing. However, the ossie happened again. And the \"No Diluent\" error is recurring. Upon inspection, it was found that the previously taped section has developed a hole again.', 'Operational with Faults', '', 'done', 'Retape the tubing.', NULL, '2025-07-25', '2026-09-28 06:09:12', '2026-09-28 14:09:14', '2026-09-28 14:10:53', NULL),
(16, 'SUP-000011', 'Clinica Animalia Veterinary Clinic', 'Isabela', 'Cauayan City', 'Ultrasound', 'Jayrald Macanang', 'Jayrald Macanang', NULL, 'Ultrasound Machine date is not right and cannot set manually.', 'Operational with Faults', '', 'done', 'Change the CMOS Battery.', NULL, '2025-07-29', '2026-09-28 06:11:52', '2026-09-28 14:11:55', '2026-09-28 14:12:17', NULL),
(17, 'SUP-000012', 'AR Veterinary Clinic', 'Kalinga', 'Tabuk City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'Probe wash assembly is broken.', 'Operational with Faults', '', 'done', 'Replaced probe wash assembly.', NULL, '2025-07-30', '2026-09-28 06:19:55', '2026-09-28 14:20:15', '2026-09-28 14:20:34', NULL),
(18, 'SUP-000013', 'Paws and Claws Veterinary Clinic', 'Cagayan', 'Camalaniugan', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', NULL, 'Unstable Platelet result', 'Operational with Faults', '', 'done', 'Installed proper grounding', NULL, '2025-08-02', '2026-09-28 06:21:16', '2026-09-28 14:21:19', '2026-09-28 14:21:36', NULL),
(19, 'SUP-000014', 'Maple Vet Clini', 'Nueva Ecija', 'Guimba', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'One of the results showed a very high platelet which it should be low and not aligned to the diagnosis.', 'Operational with Faults', '', 'done', 'Assisted ma\'am angel online to clean the machine.', NULL, '2025-08-06', '2026-09-28 06:26:56', '2026-09-28 14:26:59', '2026-09-28 14:27:40', NULL),
(20, 'SUP-000015', 'Elyu Veterinary Clinic', 'La Union', 'San Juan', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', NULL, 'High Platelet results even on blank tests', 'Operational with Faults', '', 'done', 'Cleaned the machine.', NULL, '0000-00-00', '2026-09-28 06:28:27', '2026-09-28 14:28:30', '2026-09-28 14:29:04', NULL),
(21, 'SUP-000016', 'Urban Pets vet Clinic', 'Benguet', 'Baguio City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', NULL, 'There\'s a crystalline residue while wiping the screen.', 'Operational with Faults', '', 'done', 'Advised screen replacement; however, the doctor confirmed that the machine is still functional and opted to defer the replacement for now.', NULL, '2025-07-28', '2026-09-28 06:51:35', '2026-09-28 14:51:38', '2026-09-28 14:52:43', NULL),
(22, 'SUP-000017', 'Rue St. Roche Vet Clinic', 'Laguna', 'San Pablo City', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', NULL, 'There\'s a leak in the probe needle', 'Operational with Faults', '', 'done', 'Manually cleaned the machine.', NULL, '2025-08-18', '2026-09-28 07:10:18', '2026-09-28 15:10:21', '2026-09-28 15:12:54', NULL),
(23, 'SUP-000018', 'Canine-Feline Veterinary Clinic/ Cape Bolinao Veterinary', 'Pangasinan', 'Alaminos City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'There\'s a leak outside the probe needle', 'Operational with Faults', '', 'done', 'Replace probe wash assembly because of the minimal crack and cleaned the machine.', NULL, '2025-08-20', '2026-09-28 07:13:45', '2026-09-28 15:13:47', '2026-09-28 15:16:24', NULL),
(24, 'SUP-000019', 'Psalms Paws Veterinary Clinic/ Bridgeway', 'Rizal', 'Cardona/ Morong', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'Unstable Platelet result', 'Operational with Faults', '', 'done', 'Manually cleaned the machine.', NULL, '2025-08-21', '2026-09-28 07:18:53', '2026-09-28 15:18:56', '2026-09-28 15:19:29', NULL),
(25, 'SUP-000020', 'Velvet Animal Clinic', 'La Union', 'Luna', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'Platelet result is high.', 'Operational with Faults', '', 'done', 'AVR fuse is damaged  - Fixed by Sir Michael', NULL, '2025-08-29', '2026-09-28 07:20:25', '2026-09-28 15:20:28', '2026-09-28 15:21:16', NULL),
(26, 'SUP-000021', 'Favors Animal Clinic', 'Isabela', 'Reina Mercedes', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', NULL, 'Probe button misalligned', 'Operational with Faults', '', 'done', 'Re-glue the probe button using epoxy AnB.', NULL, '2025-09-10', '2026-09-28 07:21:53', '2026-09-28 15:26:06', '2026-09-28 15:28:21', NULL),
(27, 'SUP-000022', 'AMD Pets and Vets Clinic', 'Pangasinan', 'San Fabian', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'WBC and RBC is Asterisk and Platelet is Unstable', 'Operational with Faults', '', 'done', 'Manual cleaning of the machine, soak using zonrox. - assisted Ma\'am Angel', NULL, '2025-09-12', '2026-09-28 07:45:34', '2026-09-28 15:45:37', '2026-09-28 15:46:13', NULL),
(28, 'SUP-000023', 'Pets Vetfriend Veterinary Clinic', 'Nueva Ecija', 'Guimba', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'Heavy PMS Package', 'Operational with Faults', '', 'done', 'Heavy PMS Package', NULL, '2025-09-15', '2026-09-28 07:47:04', '2026-09-28 15:47:06', '2026-09-28 15:47:29', NULL),
(29, 'SUP-000024', 'Buena Vida Animal Clinic', 'Nueva Ecija', 'Sta. Rosa', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'Unstable PLT result', 'Operational with Faults', '', 'done', 'Installed proper grounding', NULL, '2025-09-19', '2026-09-28 07:48:25', '2026-09-28 15:48:29', '2026-09-28 15:48:50', NULL),
(30, 'SUP-000025', 'PetHealth Care Vet Clinic', 'La Union', 'Agoo', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'Background Abnormal - There\'s a result in PLT during Background and Blank Testing', 'Operational with Faults', '', 'done', 'Reprogram the machine', NULL, '2025-09-19', '2026-09-28 07:49:48', '2026-09-28 15:49:51', '2026-09-28 16:18:17', NULL),
(31, 'SUP-000026', 'Animedics Veterinary Clinic', 'Nueva Vizcaya', 'Bambang', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', NULL, 'RBC Clog Error frequently occurs', 'Operational with Faults', '', 'done', 'Manual cleaning of the machine and set the HGB Value.', NULL, '2025-09-23', '2026-09-28 08:19:05', '2026-09-28 16:23:02', '2026-09-28 16:25:28', NULL),
(32, 'SUP-000027', 'Faithful Friend Vet Clinic', 'Benguet', 'Baguio City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', NULL, 'Background Abnormal - There\'s a result in PLT during Background and Blank Testing', 'Operational with Faults', '', 'done', 'Manual cleaning of machine, sanded the chambers terminal and sanded the steel that is connected to grounding.', NULL, '2025-09-24', '2026-09-28 08:29:15', '2026-09-28 16:29:18', '2026-09-28 16:30:33', NULL),
(33, 'SUP-000028', 'Urban Fur Vet Clinic', 'Cagayan', 'Tuguegarao City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', NULL, 'High Platelet results during sample testing', 'Operational with Faults', '', 'done', 'Replaced cracked probe wash assembly.', NULL, '2025-09-28', '2026-09-28 08:31:22', '2026-09-28 16:31:34', '2026-09-29 08:02:54', NULL),
(35, 'SUP-000029', 'PetHealth Care Vet Clinic', 'La Union', 'Agoo', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'HGB Voltage Abnormal Error frequently occurs', 'Operational with Faults', '', 'done', 'Cleaned, Check ground, but still not fix.', NULL, '2025-09-26', '2026-09-29 00:04:23', '2026-09-29 08:16:24', '2026-09-29 09:12:02', NULL),
(37, 'SUP-000030', 'Sursur Animal Clinic', 'Surigao Del Sur', 'Tandag City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Michael Rivera', 'The machine overflows due to insect/bug.', 'Not Operational', '', 'done', 'Manually clean the machine and remove the insects in the chambers.', NULL, '2025-09-26', '2026-09-29 00:24:44', '2026-09-29 09:12:11', '2026-09-29 09:12:50', NULL),
(38, 'SUP-000031', 'Regional Animal Disease Diagnostic Laboratory', 'Cagayan', 'Tuguegarao City', 'Hematology', 'Jashrille Faye Pagulayan, Jayrald Macanang', 'Jashrille Faye Pagulayan, Jayrald Macanang', '', 'WBC has result', 'Operational with Faults', '', 'unservicable', 'We recommend replacing chambers and they said  they need to submit a request from the higher ups.  However, despite our repeated follow-ups, we have not received any further response from them.', NULL, '2025-10-02', '2026-09-29 00:26:08', '2026-09-29 09:12:57', '2026-09-29 09:17:43', NULL),
(39, 'SUP-000032', 'Ecovet Animal Clinic', 'Batangas', 'Ibaan', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Platelet results on blank testing', 'Operational with Faults', '', 'done', 'Manual cleaning of the machine', NULL, '2025-10-01', '2026-09-29 00:27:19', '2026-09-29 09:26:43', '2026-09-29 09:27:39', NULL),
(40, 'SUP-000033', 'Doc Jay Veterinary Clinic and Supply/ Jhay Vet. Clinic', 'Isabela', 'Cabatuan', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'WBC has result', 'Operational with Faults', '', 'done', 'Manual cleaning of the machine.', NULL, '2025-10-12', '2026-09-29 00:37:48', '2026-09-29 09:27:55', '2026-09-29 09:28:09', NULL),
(41, 'SUP-000034', 'Alicia Animal Clinic', 'Isabela', 'Alicia', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Machine cover is rusty, WBC and HGB terminals carbonized so it disconnected.', 'Operational with Faults', '', 'done', 'Pulled Out and reconnect all carbonized and disconnected wire (WBC, HGB)', NULL, '2025-10-16', '2026-09-29 00:38:44', '2026-09-29 09:28:36', '2026-09-29 09:29:32', NULL),
(42, 'SUP-000035', 'Isabela Animates Veterinary Clinic', 'Isabela', 'Cauayan City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Leak from the machine', 'Operational with Faults', '', 'done', 'Reglued the buffer chamber using Epoxy AnB.', NULL, '2025-10-16', '2026-09-29 00:40:00', '2026-09-29 09:29:37', '2026-09-29 09:30:09', NULL),
(43, 'SUP-000036', 'Gambala Veterinary Clinic', 'Isabela', 'Echague', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Probe button misalligned and submerged (screw holder is broken)', 'Operational with Faults', '', 'done', 'Reglued probe button using Epoxy AnB.', NULL, '2025-10-17', '2026-09-29 00:41:09', '2026-09-29 09:30:36', '2026-09-29 09:30:54', NULL),
(44, 'SUP-000037', 'Buena Vida Animal Clinic', 'Nueva Ecija', 'Sta. Rosa', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Angelica Mae Salarzon', 'Suspicious result', 'Operational with Faults', '', 'done', 'Install proper grounding.', NULL, '2025-11-07', '2026-09-29 00:42:32', '2026-09-29 09:31:31', '2026-09-29 09:31:47', NULL),
(45, 'SUP-000038', 'Gopets Veterinary Clinic', 'Benguet', 'Baguio City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Machine printer is faulty causing the machine to turn off.', 'Not Operational', '', 'done', 'Replaced printer.', NULL, '2025-11-26', '2026-09-29 00:44:26', '2026-09-29 09:32:30', '2026-09-29 09:33:09', NULL),
(46, 'SUP-000039', 'Vet Tag Animal Clinic', 'Nueva Vizcaya', 'Solano/Bambang', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', '', 'Xray collimator (Switching board and Main power supply is faulty/broken)', 'Not Operational', '', 'done', 'Replace switching board and Main power supply.', NULL, '2025-12-01', '2026-09-29 00:48:17', '2026-09-29 09:33:18', '2026-09-29 09:33:42', NULL),
(47, 'SUP-000040', 'Vets for Pets Animal Clinic', 'Ilocos Norte', 'Laoag City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Probe needle leakage', 'Not Operational', '', 'done', 'Decompressed the spring of Valve 3.', NULL, '2025-12-09', '2026-09-29 01:37:24', '2026-09-29 09:50:08', '2026-09-29 16:39:37', NULL),
(48, 'SUP-000041', 'Kho Veterinary Clinic', 'Camarines Norte', 'Daet', 'Xray', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Roy Dalungan', 'Probe needle leakage', 'Operational with Faults', '', 'done', 'Clean RAM.', NULL, '2025-12-08', '2026-09-29 01:38:38', '2026-09-29 10:11:40', '2026-09-29 10:18:56', NULL),
(49, 'SUP-000042', 'Noble Pets Veterinary Clinic', 'Pampanga', 'San Fernando', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Angelica Mae Salarzon', 'Unstable Platelet result', 'Operational with Faults', '', 'done', 'Installed proper grounding / Heavy Cleaning / Replaced Diluent because it is contaminated', NULL, '2025-12-10', '2026-09-29 01:40:14', '2026-09-29 10:19:02', '2026-09-29 10:20:03', NULL),
(50, 'SUP-000043', 'Animal Options Veterinary Clinic', 'Cagayan', 'Tuguegarao City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'High Platelet', 'Operational with Faults', '', 'done', 'Manually cleaned the machine and fix their grounding.', NULL, '2025-12-23', '2026-09-29 01:41:45', '2026-09-29 10:20:40', '2026-09-29 16:39:56', NULL),
(51, 'SUP-000044', 'Pets Place(Animedics) Veterinary Clinic', 'Nueva Vizcaya', 'Aritao', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'WBC and RBC recurrent', 'Not Operational', '', 'done', 'Replaced crack probe wash assembly and manually cleaned all valves.', NULL, '2025-12-17', '2026-09-29 01:42:46', '2026-09-29 10:27:31', '2026-09-29 16:40:34', NULL),
(52, 'SUP-000045', 'The Shepherd Vet Clinic/ Nose To tail Vet. Clinic', 'La Union', 'Rosario', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Roy Dalungan', 'Machine front left is leaking', 'Operational with Faults', '', 'done', 'Soak probe needle using zonrox and rinse w/ distilled water. Reconnect probe needle tubing. Lyse sensor disconnect.', NULL, '2025-12-22', '2026-09-29 01:44:15', '2026-09-29 10:32:04', '2026-09-29 10:33:40', NULL),
(53, 'SUP-000046', 'Edison Veterinary Services', 'Laguna', 'Binan', 'Xray', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Jerico Barte', 'Unnecessary sound from collimator', 'Operational with Faults', '', 'done', 'Disconnect and reconnect terminals LCD Board. / Reset IP Address (ncpa.cpl ethernet IPV4)', NULL, '2025-12-22', '2026-09-29 01:45:54', '2026-09-29 10:35:15', '2026-09-29 10:35:31', NULL),
(54, 'SUP-000047', 'Agoo Animal Clinic', 'La Union', 'Agoo', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Roy Dalungan', 'HGB Voltage Abnormal Error / Machine Leakage / Insect from chamber', 'Operational with Faults', '', 'done', 'Manual cleaning of the machine. Remove insects in chambers.', NULL, '2025-12-23', '2026-09-29 01:47:00', '2026-09-29 10:35:49', '2026-09-29 10:36:51', NULL),
(55, 'SUP-000048', 'PetHealth Care Vet Clinic', 'La Union', 'Agoo', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'HGB Voltage Abnormal Error', '', '', 'done', 'Swapped the machine of Rosario and Pethealth care and observed the results of the machine.', NULL, '2026-01-03', '2026-09-29 01:49:38', '2026-09-29 13:37:32', '2026-09-29 16:43:14', NULL),
(56, 'SUP-000049', 'Pet Essentials Veterinary Clinic', 'Pangasinan', 'Rosales', 'Xray', 'Jayrald Macanang', 'Jayrald Macanang', 'Randy Fernandez', 'Unstable connection of flat panel to computer.', 'Operational with Faults', 'done', 'done', 'Disconnect and reconnect cables.', NULL, '2026-01-08', '2026-09-29 02:41:38', '2026-09-29 10:41:54', '2026-09-29 10:42:14', NULL),
(57, 'SUP-000050', 'Vet Connections Animal Clinic/ Noah\'s Ark Animal Clinic', 'Nueva Ecija', 'Cabanatuan/ Gapan', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Angelica Mae Salarzon', 'RBC Chamber continuity is defective', '', '', 'done', 'RBC Clog recurrent / High PLT / HGB Voltage Error', NULL, '2026-01-08', '2026-09-29 02:44:56', '2026-09-29 10:46:06', '2026-09-29 10:46:18', NULL),
(58, 'SUP-000051', 'Vetcare Animal Clinic', 'Albay', 'Legazpi City', 'UTZ', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Roy Dalungan', 'Trackball is defective', 'Operational with Faults', '', 'done', 'Replaced trackball and board - under warranty.', NULL, '2026-01-12', '2026-09-29 02:47:35', '2026-09-29 11:27:55', '2026-09-29 11:28:23', NULL),
(59, 'SUP-000052', 'NextDoor Pet Care Services', 'Bulacan', 'San Miguel', 'Urine Analyzer', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', '', 'UA is faulty', 'Not Operational', '', 'done', 'Replace battery and charger.', NULL, '2026-01-16', '2026-09-29 03:00:00', '2026-09-29 11:28:32', '2026-09-29 11:28:48', NULL),
(60, 'SUP-000053', 'The Shepherd Vet Clinic/ Nose To tail Vet. Clinic', 'La Union', 'Rosario', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Diluent empty / RBC Clog recurrent', 'Operational with Faults', '', 'done', 'Disconnects diluent sensor from the tubing. Manual cleaning of the machine.', NULL, '2026-01-16', '2026-09-29 03:01:30', '2026-09-29 11:29:03', '2026-09-29 11:30:22', NULL),
(61, 'SUP-000054', 'Tailville Veterinary Clinic', 'Rizal', 'Rodriguez', 'Xray', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Jeffri Jon Valdez', 'Drive D corrupted', 'Operational with Faults', '', 'done', 'Reinstall the application and relocate the files on the Drive C.', NULL, '2026-01-17', '2026-09-29 03:06:25', '2026-09-29 11:30:29', '2026-09-29 11:32:00', NULL),
(62, 'SUP-000055', 'Doc Gregg Veterinary Clinic', 'Zambales', 'Olongapo City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'RBC Clog when cat reference range.', 'Operational with Faults', '', 'done', 'Configure RBC Voltage (Gain Value) Recommended Value - 55', NULL, '2026-01-17', '2026-09-29 03:07:09', '2026-09-29 11:33:11', '2026-09-29 11:34:39', NULL),
(63, 'SUP-000056', 'Kho Veterinary Clinic', 'Camarines Norte', 'Daet', 'Xray', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Monitor took too long to boot.', 'Operational with Faults', '', 'done', 'Replace memory module of the PC and opened the PC. Reformat and Reinstall windows.', NULL, '2026-01-20', '2026-09-29 03:25:49', '2026-09-29 11:34:52', '2026-09-29 11:36:01', NULL),
(64, 'SUP-000057', 'Kho Veterinary Clinic', 'Camarines Norte', 'Daet', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', '', 'RBC Clog', '', '', 'done', 'Replaced RBC Chamber.', NULL, '2026-01-20', '2026-09-29 03:27:27', '2026-09-29 11:36:08', '2026-09-29 11:37:02', NULL),
(65, 'SUP-000058', 'Daddy Doc Veterinary Clinic', 'Isabela', 'Cabatuan', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', '', 'WBC and RBC Clog', 'Operational with Faults', '', 'done', 'Manual cleaning of the machine.', NULL, '2026-01-21', '2026-09-29 03:38:21', '2026-09-29 13:24:49', '2026-09-29 13:25:08', NULL),
(66, 'SUP-000059', 'The Shepherd Vet Clinic/ Nose To tail Vet. Clinic', 'La Union', 'Rosario', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Machine leakage from tubing is loose.', 'Operational with Faults', '', 'done', 'Re attached the loose tubing.', NULL, '2026-01-30', '2026-09-29 03:39:32', '2026-09-29 13:25:57', '2026-09-29 13:26:24', NULL),
(67, 'SUP-000060', 'Doctor Noah\'s Veterinary Clinic', 'Albay', 'Legazpi City', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', '', 'RBC Clog due to Waste became diluent.', 'Operational with Faults', '', 'done', 'Manually cleaned the machine and replace diluent.', NULL, '2026-01-31', '2026-09-29 05:11:34', '2026-09-29 13:26:40', '2026-09-29 13:44:54', NULL),
(68, 'SUP-000061', 'Clinica Animalia Veterinary Clinic', 'Isabela', 'Cauayan City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Probe leaking', 'Not Operational', '', 'done', 'Heavy Cleaning then replace Valve 3.', NULL, '2026-02-06', '2026-09-29 05:12:19', '2026-09-29 13:38:21', '2026-09-29 13:38:59', NULL),
(69, 'SUP-000062', 'Gopets Veterinary Clinic', 'Benguet', 'Baguio City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Michael Rivera', 'HGH Voltage (Insect in chamber).', 'Operational with Faults', '', 'done', 'Manually cleaned the machine and remove insect in the chamber.', NULL, '2026-02-08', '2026-09-29 05:13:15', '2026-09-29 13:40:08', '2026-09-29 13:41:21', NULL),
(70, 'SUP-000063', 'Winterfell Veterinary Clinic', 'Mountain Province', 'Bontoc', 'Chemistry', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Can\'t scan QR (Expired even though rotor is not expired) For Upgrade', 'Operational with Faults', '', 'done', 'Assisted the Doctor to insert the file in a flash drive then used it to manually upgrade the machine.', NULL, '2026-02-06', '2026-09-29 05:14:17', '2026-09-29 13:41:29', '2026-09-29 13:43:22', NULL),
(71, 'SUP-000064', 'Amazing Grace Diagnostic and Medical Services', 'Isabela', 'Ilagan City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'RBC and WBC Overflows (Corroded with rust).', 'Operational with Faults', '', 'done', 'Change Valve 8. Rewire WBC and RBC and replaced some tubings.', NULL, '2026-02-15', '2026-09-29 05:15:02', '2026-09-29 13:43:31', '2026-09-29 13:45:43', NULL),
(72, 'SUP-000065', 'Kho Veterinary Clinic', 'Camarines Norte', 'Daet', 'Xray', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Machine took too long to boot.', 'Operational with Faults', '', 'done', 'Replaced monitor.', NULL, '2026-02-12', '2026-09-29 05:16:07', '2026-09-29 13:46:53', '2026-09-29 14:01:11', NULL),
(73, 'SUP-000066', 'Bauang Vet Care Clinic', 'La Union', 'Bauang', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'PLT result is High.', 'Operational with Faults', '', 'done', 'Installed proper grounding. Relocated the machine to another clinic room.', NULL, '2026-03-02', '2026-09-29 05:17:05', '2026-09-29 13:58:53', '2026-09-29 13:59:22', NULL),
(74, 'SUP-000067', 'Rural Vet Clinic', 'Pangasinan', 'San Fabian', 'Xray', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Randy Fernandez', 'Phantom touch in one area.', 'Operational with Faults', '', 'done', 'Disconnect and reconnect all dongles, wireless connection. Open the monitor and reset all connection.', NULL, '2026-03-05', '2026-09-29 05:18:01', '2026-09-29 14:00:01', '2026-09-29 14:00:26', NULL),
(75, 'SUP-000068', 'NextDoor Pet Care Services', 'Bulacan', 'San Miguel', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Probe needle leakage.', 'Operational with Faults', 'done', 'done', 'Manual test and clean Valve 3. De compressed the spring and reinstalled.', NULL, '2026-03-09', '2026-09-29 05:18:54', '2026-09-29 14:18:50', '2026-09-29 14:19:20', NULL),
(76, 'SUP-000069', 'Doc Hero Veterinary Clinic', 'Isabela', 'Cauayan City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Heavy PMS Package', 'Operational with Faults', '', 'done', 'Performed Heavy PMS.', NULL, '2026-03-03', '2026-09-29 05:20:09', '2026-09-29 14:20:42', '2026-09-29 14:21:34', NULL),
(77, 'SUP-000070', 'Vets for Pets Animal Clinic', 'Ilocos Norte', 'Dingras', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'V, H, SP Motor Error', 'Not Operational', '', 'done', 'Replaced power supply and manually cleaned all valves.', NULL, '2026-03-14', '2026-09-29 05:21:00', '2026-09-29 14:21:44', '2026-09-29 14:22:30', NULL),
(78, 'SUP-000071', 'Gopez Veterinary Clinic', 'Pampanga', 'Arayat', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'WBC Clog (Red wire connection of the WBC Chamber is disconnected)', 'Not Operational', '', 'done', 'Repaired WBC Chamber and test continuity.', NULL, '2026-03-26', '2026-09-29 06:45:44', '2026-09-29 14:49:00', '2026-09-29 14:50:01', NULL),
(79, 'SUP-000072', 'Vets for Pets Animal Clinic', 'Ilocos Norte', 'Dingras', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'RBC & WBC Clog.', 'Operational with Faults', '', 'done', 'Manually cleaned all valves.', NULL, '2026-04-07', '2026-09-29 06:59:39', '2026-09-29 15:55:55', '2026-09-29 15:56:21', NULL),
(80, 'SUP-000073', 'Vetsquad Animal Clinic', 'La Union', 'Pugo', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', '\"No Diluent\" can\'t be removed', 'Operational with Faults', '', 'done', 'Adjust potentiometer value.', NULL, '2026-04-07', '2026-09-29 07:03:44', '2026-09-29 15:56:26', '2026-09-29 15:56:50', NULL),
(81, 'SUP-000074', 'Pets Vetfriend Veterinary Clinic', 'Nueva Ecija', 'Guimba', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', '', 'Machine leakage and WBC Clog.', 'Not Operational', '', 'done', 'Remove insects in the chamber and manually cleaned the machine.', NULL, '2026-04-08', '2026-09-29 07:04:48', '2026-09-29 15:56:54', '2026-09-29 15:58:21', NULL),
(82, 'SUP-000075', 'Gopez Veterinary Clinic', 'Pampanga', 'Arayat', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'HGB Background is abnormal.', 'Operational with Faults', '', 'done', 'Reconnect the leaking tube.', NULL, '2026-04-11', '2026-09-29 07:06:54', '2026-09-29 15:58:31', '2026-09-29 15:59:08', NULL),
(83, 'SUP-000076', 'Gopets Veterinary Clinic', 'Benguet', 'Baguio City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'High PLT and RBC Clog (RBC chamber red line have resistance).', 'Not Operational', 'done', 'done', 'Repair RBC Chamber (High resistance)', NULL, '2026-04-11', '2026-09-29 07:08:54', '2026-09-29 15:59:18', '2026-09-29 16:02:26', NULL),
(84, 'SUP-000077', 'Animedics Veterinary Clinic', 'Nueva Vizcaya', 'Solano', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'WBC Clog Recurring', 'Operational with Faults', '', 'done', 'Replace WBC Chamber.', NULL, '2026-04-11', '2026-09-29 07:10:05', '2026-09-29 16:00:32', '2026-09-29 16:03:25', NULL),
(85, 'SUP-000078', 'Pet Adventure Animal Clinic', 'Bulacan', 'Sta Maria', 'Xray', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Xray results have lines.', 'Operational with Faults', '', 'done', 'Xray calibration.', NULL, '2026-04-15', '2026-09-29 07:11:02', '2026-09-29 16:03:33', '2026-09-29 16:05:16', NULL),
(87, 'SUP-000080', 'Animedics Veterinary Clinic', 'Nueva Vizcaya', 'Bambang', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'LCD display is black.', 'Operational with Faults', '', 'done', 'Reconnect LCD flat cable.', NULL, '2026-04-24', '2026-09-29 07:13:34', '2026-09-29 16:08:04', '2026-09-29 16:08:34', NULL),
(88, 'SUP-000081', 'Animal Corner Veterinary Clinic', 'Isabela', 'Santiago City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Angelica Mae Salarzon', 'Low WBC result', 'Operational with Faults', '', 'done', 'Manually cleaned the machine most especially the syringe pump.', NULL, '2026-04-25', '2026-09-29 07:14:37', '2026-09-29 16:08:50', '2026-09-29 16:10:05', NULL),
(89, 'SUP-000082', 'Pet Terrific Veterinary Clinic', 'Nueva Ecija', 'Talavera', 'Xray', 'Jayrald Macanang', 'Jayrald Macanang', '', 'X-ray Disk Drive D not accessible.', 'Not Operational', '', 'done', 'Install new SSD Hard drive.', NULL, '2026-05-02', '2026-09-29 07:15:21', '2026-09-29 16:10:15', '2026-09-29 16:10:36', NULL),
(90, 'SUP-000083', 'Vet Next Door Animal Clinic', 'Ecija', 'Lupao', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'No Diluent can\'t be removed.', 'Operational with Faults', '', 'done', 'Adjust potentiometer value.', NULL, '2026-05-05', '2026-09-29 07:16:08', '2026-09-29 16:10:41', '2026-09-29 16:11:10', NULL),
(91, 'SUP-000084', 'Faithful Friend Vet Clinic', 'Benguet', 'Baguio City', 'Hematology', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Randy Fernandez', 'High / Unstable PLT', 'Operational with Faults', '', 'done', 'Manually cleaned the machine then sanded the chambers terminal.', NULL, '2026-05-12', '2026-09-29 07:17:42', '2026-09-29 16:11:14', '2026-09-29 16:12:26', NULL),
(92, 'SUP-000085', 'TrustiVet Animal Clinic', 'Batangas', 'San Juan', 'Xray', 'Jashrille Faye Pagulayan', 'Jashrille Faye Pagulayan', 'Jerico Barte', 'Install AVR for Xray', 'Fully Functional', '', 'on_hold', 'We are still waiting for the doctor to purchase an AVR.', NULL, '2026-05-12', '2026-09-29 07:18:44', '2026-09-29 16:12:33', '2026-09-29 16:49:38', NULL),
(93, 'SUP-000086', 'Paws and Furs Animal Clinic', 'Tarlac', 'Moncada', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', '', 'High WBC result', 'Operational with Faults', '', 'done', 'Manually cleaned the machine.', NULL, '2026-05-16', '2026-09-29 07:23:57', '2026-09-29 16:12:43', '2026-09-29 16:13:13', NULL),
(94, 'SUP-000087', 'Medpaws Veterinary Clinic', 'Metro Manila', 'Quezon City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'HBG Voltage abnormal can\'t be removed (possible insect in chamber)', 'Operational with Faults', '', 'done', 'Replace UPS.', NULL, '2026-05-25', '2026-09-29 07:25:07', '2026-09-29 16:13:26', '2026-09-29 16:16:54', NULL),
(95, 'SUP-000088', 'Winterfell Veterinary Clinic', 'Mountain Province', 'Bontoc', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'VH30 Card Reader no connection error.', 'Operational with Faults', '', 'done', 'Replace card reader.', NULL, '2026-05-26', '2026-09-29 07:25:58', '2026-09-29 16:16:58', '2026-09-29 16:21:12', NULL),
(96, 'SUP-000089', 'Paws and Claws Veterinary Clinic', 'Cagayan', 'Camalaniugan', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Machine leaking during \"Replacing\"', 'Operational with Faults', '', 'done', 'Replace of Valve 5.', NULL, '2026-05-26', '2026-09-29 07:27:12', '2026-09-29 16:21:29', '2026-09-29 16:23:15', NULL),
(97, 'SUP-000090', 'Dr. Vien Veterinary Clinic', 'Zambales', 'San Marcelino', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'PLT result on blank tests.', '', '', 'done', 'Installed grounding.', NULL, '2026-06-04', '2026-09-29 07:28:14', '2026-09-29 16:23:28', '2026-09-29 16:31:26', NULL),
(98, 'SUP-000091', 'Binalonan Veterinary Clinic', 'Pangasinan', 'Binalonan', 'Xray', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Selelcted specie not reflecting correctly on the image result.', 'Operational with Faults', '', 'done', 'Re-install new Vet app.', NULL, '2026-06-05', '2026-09-29 07:29:01', '2026-09-29 16:23:46', '2026-09-29 16:30:03', NULL),
(99, 'SUP-000092', 'JC Paws & Claws Veterinary Clinic', 'Ilocos Sur', 'Batac', 'Chemistry', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Blood chem machine too noisy during running of rotor and error result.', 'Not Operational', '', 'done', 'Replace disk chunk.', NULL, '2026-06-25', '2026-09-29 07:30:59', '2026-09-29 16:31:12', '2026-09-29 16:31:49', NULL),
(100, 'SUP-000093', 'Pets Place(Animedics) Veterinary Clinic', 'Nueva Vizcaya', 'Aritao', 'Hematology', 'Elmer Celino', 'Elmer Celino', '', 'Recurring WBC Clog on KT Machine.', 'Operational with Faults', '', 'done', 'Manually clean the machine then replace lyse.', NULL, '2026-06-10', '2026-09-29 07:41:46', '2026-09-29 16:31:55', '2026-09-29 16:32:18', NULL),
(101, 'SUP-000094', 'Waggie Tail Veterinary Clinic', 'Cagayan', 'Tuguegarao City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'KT Machine Clog Error Recurring.', 'Operational with Faults', '', 'unservicable', 'They used reagents from other suppliers.', NULL, '2026-06-10', '2026-09-29 07:42:43', '2026-09-29 16:32:23', '2026-09-29 16:32:57', NULL),
(102, 'SUP-000095', 'Dr. Vien Veterinary Clinic', 'Zambales', 'San Marcelino', 'Hematology', 'Vincent Joseph Gaspar', 'Vincent Joseph Gaspar', '', 'VH30 motor noisy.', 'Operational with Faults', '', 'done', 'Replaced power supply.', NULL, '2026-08-07', '2026-09-29 07:45:09', '2026-09-29 16:33:07', '2026-09-29 16:33:27', NULL),
(103, 'SUP-000096', 'Nose to Tail Veterinary Clinic', 'Pangasinan', 'Sta Maria', 'Hematology', 'Jayrald Macanang, Vincent Joseph Gaspar', 'Jayrald Macanang, Vincent Joseph Gaspar', '', 'No Diluent error recurrent', 'Operational with Faults', '', 'done', 'Loose diluent tubing.', NULL, '2026-06-22', '2026-09-29 07:46:46', '2026-09-29 16:33:48', '2026-09-29 16:34:46', NULL),
(104, 'SUP-000097', 'Animedics Veterinary Clinic', 'Nueva Vizcaya', 'Bambang', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'No motor movements, no display, no output.', 'Not Operational', '', 'pullout', 'Board Replacement.', NULL, '2026-04-26', '2026-09-29 07:48:51', '2026-09-29 16:34:55', '2026-09-29 16:35:19', NULL),
(105, 'SUP-000098', 'Animal Haven Veterinary Clinic', 'Benguet', 'La Trinidad', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'High PLT', 'Operational with Faults', 'on_hold', 'on_hold', 'The clinic declined the installation of the grounding.', 'return', '2026-06-27', '2026-09-29 07:49:32', '2026-09-29 16:47:56', '2026-09-29 16:48:10', '2026-09-29 16:46:37'),
(106, 'SUP-000099', 'Isabela Animates Veterinary Clinic', 'Isabela', 'Cauayan City', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'V Motor Error', 'Operational with Faults', '', 'on_hold', 'The doctor does not have the budget for it yet.', NULL, '2026-08-09', '2026-09-29 07:50:12', '2026-09-29 16:46:03', '2026-09-29 16:46:33', NULL),
(107, 'SUP-000100', 'PetHealth Care Vet Clinic', 'La Union', 'Agoo', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'High HCT results', 'Operational with Faults', '', 'on_hold', 'For observation', NULL, '2026-09-12', '2026-09-29 07:50:49', '2026-09-29 16:37:04', '2026-09-29 16:50:11', NULL),
(108, 'SUP-000101', 'Rural Vet Clinic', 'Pangasinan', 'San Fabian', 'Hematology', 'Jashrille Faye Pagulayan, Jayrald Macanang, Vincent Joseph Gaspar', 'Jashrille Faye Pagulayan, Jayrald Macanang, Vincent Joseph Gaspar', '', 'MNCHIP Error 0107', 'Not Operational', '', 'pullout', 'For troubleshoot', NULL, '2026-09-15', '2026-09-29 07:51:57', '2026-09-29 16:37:12', '2026-09-29 16:43:41', NULL),
(109, 'SUP-000102', 'Cuddly Care Animal Clinic', 'Metro Manila', 'Marikina City', 'Hematology', 'Jeffri Jon Valdez', 'Jeffri Jon Valdez', '', 'WBC result is asterisk', 'Operational with Faults', '', 'done', 'Assisted online - they just restarted the machine and machine became okay.', NULL, '2026-09-23', '2026-09-29 07:52:28', '2026-09-29 16:37:31', '2026-09-29 16:38:10', NULL),
(110, 'SUP-000103', 'Pet Essentials Veterinary Clinic', 'La Union', 'Binalonan', 'Hematology', 'Jayrald Macanang', 'Jayrald Macanang', '', 'Unstable PLT', 'Operational with Faults', '', 'ongoing', '', NULL, '2026-09-29', '2026-09-29 07:53:04', '2026-10-01 15:33:36', '2026-10-01 15:33:36', NULL),
(213, 'SUP-000104', '3DS Veterinary Services & Supplies', 'Surigao Del Sur', 'Madrid', 'Hematology', 'Jashrille Pagulayan', 'Jashrille Pagulayan', '', 'dghgdhgdgh', 'Not Operational', '', 'canceled', '', NULL, '2026-10-01', '2026-10-01 07:57:48', '2026-10-01 15:57:51', '2026-10-01 15:57:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `company_id` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `company_id`, `fname`, `lname`, `uname`, `pass`, `role`, `status`) VALUES
(4, '', 'Joshua', 'Pagulayan', 'admin', '$2y$10$BB6bGMrAxaNnZnrNy13moeFfkRJtP/iHDh.Hs2aC0Zw0irtC.01H.', 2, 'active'),
(5, '', 'Jashrille', 'Pagulayan', 'jash', '$2y$10$sDTG5u3.9jJSiwoU2ZyuqueBs04DUZ5yGHYvF1sPBlvEw/dlxxbRS', 1, 'active'),
(6, '', 'Jashrille Faye', 'Pagulayan', 'jashrille', '$2y$10$ww.3hQ/2zKScwZX72neLH.3c/QuHoeOemibrscWih8pnHC26zQwJu', 1, 'active'),
(8, '', 'Jayrald', 'Macanang', 'Jayrald', '$2y$10$yFj1MufJyDUSGKj/Z4o26Ozp7Focqtj8161EqyoSW2NjpOmApzb1G', 1, 'active'),
(9, '', 'Vincent Joseph', 'Gaspar', 'Gaspar', '$2y$10$4u9vOi4ePoRB8I5QqOvuKeFi4ptAZPVP.cScWP.3HwgIqXb/rnvMe', 1, 'active'),
(10, '', 'Elmer', 'Celino', 'Elmer', '$2y$10$3AWKnAAiOmdRt2Sfs838ue6l5MNgv/ehfnNdsaXt8Yhs42GHCqLnS', 1, 'active'),
(11, '', 'Jeffri Jon', 'Valdez', 'Jeffri', '$2y$10$afu46X4Fem72JVNzbjgkG.VcKXLKar0L80TYZKTNoCSHIL6JXg10.', 1, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cancelledaccount`
--
ALTER TABLE `tb_cancelledaccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_contract`
--
ALTER TABLE `tb_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_data`
--
ALTER TABLE `tb_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_fsr`
--
ALTER TABLE `tb_fsr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_mfs`
--
ALTER TABLE `tb_mfs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pms`
--
ALTER TABLE `tb_pms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_receipt`
--
ALTER TABLE `tb_receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_rotor`
--
ALTER TABLE `tb_rotor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_support`
--
ALTER TABLE `tb_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cancelledaccount`
--
ALTER TABLE `tb_cancelledaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_contract`
--
ALTER TABLE `tb_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_data`
--
ALTER TABLE `tb_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- AUTO_INCREMENT for table `tb_fsr`
--
ALTER TABLE `tb_fsr`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_mfs`
--
ALTER TABLE `tb_mfs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pms`
--
ALTER TABLE `tb_pms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=504;

--
-- AUTO_INCREMENT for table `tb_receipt`
--
ALTER TABLE `tb_receipt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_rotor`
--
ALTER TABLE `tb_rotor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tb_support`
--
ALTER TABLE `tb_support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
