-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2026 at 03:53 AM
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

--
-- Dumping data for table `tb_cancelledaccount`
--

INSERT INTO `tb_cancelledaccount` (`id`, `Clinic`, `Address`, `machine`, `Date_Found_out`, `Date_confirmed`, `Personnel`, `Reason`, `Supplier`) VALUES
(1, '3DS Veterinary Services & Supplies', 'Madrid', '', '2026-09-17', '2026-09-17', 'dsadsa', 'asdasd', 'sadas'),
(2, 'AC & W Veterinary Clinic', 'Caloocan', 'Hematology', '2026-09-17', '2026-09-17', 'asdasdas', 'dsadas', 'dasdas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_contract`
--

CREATE TABLE `tb_contract` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_contract`
--

INSERT INTO `tb_contract` (`id`, `location`) VALUES
(1, 'upload/contract/contract_1.pdf'),
(2, 'upload/contract/contract_2.jpg'),
(3, 'upload/contract/contract_3.pdf'),
(4, 'upload/contract/contract_4.pdf'),
(5, 'upload/contract/contract_5.pdf'),
(6, 'upload/contract/contract_6.jpg'),
(7, 'upload/contract/contract_7.jpg'),
(8, 'upload/contract/contract_8.pdf');

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
(6, 'Animedics Veterinary Clinic', 'Bambang', 'Nueva Vizcaya', 'Hematology', '2019-04-06', '', 'KTVET-6300', 'AR0041-2019', 'A', 0),
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
(138, 'RMC Veterinary Clinic', 'San Mateo', 'Rizal', 'Chemistry', '2023-07-28', '', 'CV5', 'DR1174', 'A', 0),
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
(152, 'Abaya Veterinary Clinic', 'Bangued', 'Abra', 'Hematology', '2023-09-07', '08B0708230536', 'VH30', 'DR1325', 'A', 4),
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
(185, 'Abaya Veterinary Clinic', 'Bangued', 'Abra', 'Urine Analyzer', '2023-12-15', 'Ma22070060015', 'VU10', 'DR1619', 'A', 3),
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
(236, 'Agapet Animal Clinic', 'General Trias', 'Cavite', 'Hematology', '2024-08-08', '08B121323066', 'VH30', 'DR2184', 'A', 7),
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
(265, '3KE Pet Solution Animal Clinic', 'Kawit', 'Cavite', 'Hematology', '2025-02-17', '08B0224230440', 'VH30', 'DR2766', 'A', 2),
(266, '3KE Pet Solution Animal Clinic', 'Kawit', 'Cavite', 'Chemistry', '2025-02-17', '63110123200101', 'VP20', 'DR2767', 'A', 1),
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
(296, 'AC & W Veterinary Clinic', 'Caloocan', 'Metro Manila', 'Hematology', '2025-05-16', '08B0909240804', 'VH30', 'DR2925', 'I', 0),
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
(339, 'Addy Paws Animal Clinic', 'Alfonso Lista', 'Ifugao', 'Hematology', '2025-12-13', '08B0607250972', 'VH30', 'DR3862', 'A', 5),
(340, 'ICT Vet Veterinary Clinic', 'Tuguegarao City', 'Cagayan', 'Chemistry', '2026-01-12', '63081823200082', 'VP20', 'DR3863', 'A', 0),
(341, '3DS Veterinary Services & Supplies', 'Madrid', 'Surigao Del Sur', 'Hematology', '2026-01-13', '08B0607250978', 'VH30', 'DR3396', 'I', 8),
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
(368, 'Pets Life Vet Clinic', 'Bagabag, Nueva Vizcaya', 'Nueva Vizcaya', 'UTZ', '2026-07-29', 'G6294311CT028N0001', 'M5 Vet', 'DR4411', 'A', 0);

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

--
-- Dumping data for table `tb_fsr`
--

INSERT INTO `tb_fsr` (`id`, `fsr_number`, `service_engineer`, `account`, `address`, `date`, `machine`, `serial_number`, `technical_concern`, `remarks`, `action_made`, `acknowledge`, `receipt_id`, `created_at`, `updated_at`, `receipt`) VALUES
(1, '00003', 'Joshua Pagulayan', 'Abaya Veterinary Clinic', 'Bangued', '2026-09-17', 'Hematology', '08B0708230536', 'dasdsa', 'asdas', 'dasdas', '1', NULL, '2026-09-17 10:20:37', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_mfs`
--

CREATE TABLE `tb_mfs` (
  `id` int(10) UNSIGNED NOT NULL,
  `mfs_number` varchar(50) NOT NULL,
  `employee` varchar(150) NOT NULL,
  `accounts` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_fillup` date DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `machine` varchar(150) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `consumable_unit` varchar(50) DEFAULT NULL,
  `consumables` varchar(255) DEFAULT NULL,
  `lot_number` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `reason` text DEFAULT NULL,
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

INSERT INTO `tb_mfs` (`id`, `mfs_number`, `employee`, `accounts`, `address`, `date_fillup`, `unit`, `machine`, `serial_number`, `consumable_unit`, `consumables`, `lot_number`, `remarks`, `reason`, `date_status`, `personnel`, `acknowledged`, `returned`, `receipt_id`, `created_at`, `updated_at`, `receipt`) VALUES
(1, '00005', 'Joshua Pagulayan', 'Abaya Veterinary Clinic', 'Bangued', '2026-09-17', '1', 'Hematology', '08B0708230536', '1', '2', '1', 'asdasdas', 'asdasad', '2026-09-17', 'dasdsa', 1, 0, NULL, '2026-09-17 10:20:26', NULL, 9),
(2, '00004', 'Jashrille Faye Pagulayan', 'Abaya Veterinary Clinic', 'Bangued', '2026-09-17', '1', 'Urine Analyzer', 'Ma22070060015', '1', 'lyse , diluent', '', '', '', '2026-09-17', '', 0, 0, NULL, '2026-09-17 17:07:47', NULL, NULL);

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
(1, '00003', 'Joshua Pagulayan', 'Abaya Veterinary Clinic', 'Bangued', '2026-09-17', 'Hematology', '08B0708230536', 'Heavy PMS', '', 1, 1, 8),
(2, '00003', 'Jashrille Pagulayan', 'AC & W Veterinary Clinic', 'Caloocan', '2026-09-17', 'Hematology', '08B0909240804', 'Troubleshooting', '', 0, 0, 11),
(3, '00003', 'Jashrille Pagulayan', 'AC & W Veterinary Clinic', 'Caloocan', '2026-09-17', 'Hematology', '08B0909240804', 'Heavy PMS', '', 0, 0, 11),
(4, '00003', 'Jashrille Pagulayan', 'AC & W Veterinary Clinic', 'Caloocan', '2026-09-17', 'Hematology', '08B0909240804', 'Heavy PMS', '', 0, 0, 11),
(5, '00007', 'Jashrille Pagulayan', 'Abaya Veterinary Clinic', 'Bangued', '2026-09-17', 'Urine Analyzer', 'Ma22070060015', 'For Release', '', 2, 0, 14),
(6, '00001', 'Jashrille Faye Pagulayan', 'Abaya Veterinary Clinic', 'Bangued', '2026-09-17', 'Urine Analyzer', 'Ma22070060015', 'Manual Checking', '', 2, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tb_receipt`
--

CREATE TABLE `tb_receipt` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_location` varchar(255) NOT NULL,
  `date_upload` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_receipt`
--

INSERT INTO `tb_receipt` (`id`, `file_location`, `date_upload`) VALUES
(1, 'uploads/receipts/1789607421_67266d7ea4e5da07eb59.jpg', '2026-09-17 09:10:21'),
(2, 'uploads/receipts/1789607450_ffae7be35f1679c70699.jpg', '2026-09-17 09:10:50'),
(3, 'uploads/receipts/1789607463_78154f9f849baf733664.jpg', '2026-09-17 09:11:03'),
(4, 'uploads/receipts/1789607486_e5ea0f8aca690ba3eede.jpg', '2026-09-17 09:11:26'),
(5, 'uploads/receipts/1789607505_39f92160dd6d250cb4c9.png', '2026-09-17 09:11:45'),
(6, 'uploads/receipts/1789607524_ebad3cc93de924ee1fe1.jpg', '2026-09-17 09:12:04'),
(7, 'uploads/receipts/1789610951_8660a267be92710c6070.jpg', '2026-09-17 10:09:11'),
(8, 'uploads/receipts/1789611603_6d5e0af7ba727886e9e9.jpg', '2026-09-17 10:20:03'),
(9, 'uploads/receipts/1789611626_cbf0250fdcb9b8232eed.jpg', '2026-09-17 10:20:26'),
(10, 'uploads/receipts/1789611637_e5f2dd23e6f85febdccc.jpg', '2026-09-17 10:20:37'),
(11, 'uploads/receipts/1789613792_75a277f654abcf540be6.jpg', '2026-09-17 10:56:32'),
(12, 'uploads/receipts/1789635973_c311e51e0cb5b16cd89a.jpg', '2026-09-17 17:06:13'),
(13, 'uploads/receipts/1790301068_bacf487b16732536fca9.png', '2026-09-25 09:51:08'),
(14, 'uploads/receipts/1790301357_e9834fb54539ec8e8c3d.jpg', '2026-09-25 09:55:57');

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
  `status` varchar(255) NOT NULL,
  `approve_management` tinyint(1) NOT NULL DEFAULT 0,
  `approve_manufacture` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

INSERT INTO `tb_support` (`id`, `ticket_number`, `clinic_name`, `province`, `address`, `machine`, `technician`, `service_engr`, `concern`, `machine_status`, `service_status`, `status`, `remarks`, `returnstat`, `support_date`, `created_at`, `accepted_at`, `status_updated_at`, `update_date`) VALUES
(1, 'SUP-000001', 'Abaya Veterinary Clinic', NULL, NULL, 'Hematology', 'Jashrille Faye Pagulayan', NULL, 'dasdsadas', NULL, NULL, 'on_hold', '', NULL, '2026-09-25', '2026-09-25 04:01:19', '2026-09-25 15:06:07', '2026-09-25 15:10:38', NULL),
(2, 'SUP-000002', 'Abaya Veterinary Clinic', 'Abra', 'Bangued', 'Hematology', 'Jashrille Pagulayan', 'Jashrille Pagulayan', 'asdsadsa', 'Operational', '', 'pullout', '', 'return', '2026-09-25', '2026-09-25 04:12:05', '2026-09-25 12:12:09', '2026-09-25 15:08:13', '2026-09-25 15:08:13'),
(3, 'SUP-000003', 'Addy Paws Animal Clinic', 'Ifugao', 'Alfonso Lista', 'Hematology', 'Jashrille Pagulayan', 'Jashrille Pagulayan', 'sadsadas', 'Operational with Faults', '', 'done', 'sadasdas', NULL, '2026-09-25', '2026-09-25 07:36:58', '2026-09-25 15:37:04', '2026-09-25 15:37:15', NULL);

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
(6, '', 'Jashrille Faye', 'Pagulayan', 'jashrille', '$2y$10$ww.3hQ/2zKScwZX72neLH.3c/QuHoeOemibrscWih8pnHC26zQwJu', 1, 'active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_contract`
--
ALTER TABLE `tb_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_data`
--
ALTER TABLE `tb_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- AUTO_INCREMENT for table `tb_fsr`
--
ALTER TABLE `tb_fsr`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_mfs`
--
ALTER TABLE `tb_mfs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pms`
--
ALTER TABLE `tb_pms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_receipt`
--
ALTER TABLE `tb_receipt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_rotor`
--
ALTER TABLE `tb_rotor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_support`
--
ALTER TABLE `tb_support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
