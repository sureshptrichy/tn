-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2016 at 09:29 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `truenorth_fresh_install`
--

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Acl`
--

CREATE TABLE IF NOT EXISTS `tnng_Acl` (
`aid` bigint(20) unsigned NOT NULL,
  `role_id` char(16) NOT NULL,
  `perm_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1222 DEFAULT CHARSET=utf8 COMMENT='Roles to Permissions one-to-many.';

--
-- Dumping data for table `tnng_Acl`
--

INSERT INTO `tnng_Acl` (`aid`, `role_id`, `perm_id`) VALUES
(479, 'V4ZBTCPZPAUtPUth', 'pppppppppppppppa'),
(480, 'V4ZBTCPZPAUtPUth', 'pppppppppppppppb'),
(489, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppppa'),
(490, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppppb'),
(491, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppppc'),
(492, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppppt'),
(493, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppppw'),
(494, 'VTJ5S5r3Y4pt0Qj6', 'ppppppppppppppqp'),
(495, 'VTJ5S5r3Y4pt0Qj6', 'ppppppppppppppqq'),
(496, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppptj'),
(497, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppptk'),
(498, 'VTJ5S5r3Y4pt0Qj6', 'pppppppppppppptl'),
(637, 'EO4u5UXVJYXW4M5Z', 'pppppppppppppppa'),
(638, 'EO4u5UXVJYXW4M5Z', 'pppppppppppppppb'),
(639, 'EO4u5UXVJYXW4M5Z', 'pppppppppppppppc'),
(640, 'EO4u5UXVJYXW4M5Z', 'pppppppppppppppq'),
(641, 'EO4u5UXVJYXW4M5Z', 'pppppppppppppppr'),
(642, 'EO4u5UXVJYXW4M5Z', 'ppppppppppppppps'),
(643, 'EO4u5UXVJYXW4M5Z', 'pppppppppppppppt'),
(713, '20JsSgeKWBjvEn8y', 'pppppppppppppppa'),
(714, '20JsSgeKWBjvEn8y', 'pppppppppppppppc'),
(715, '20JsSgeKWBjvEn8y', 'pppppppppppppppg'),
(716, '20JsSgeKWBjvEn8y', 'pppppppppppppppn'),
(717, '20JsSgeKWBjvEn8y', 'pppppppppppppppu'),
(718, '20JsSgeKWBjvEn8y', 'pppppppppppppppy'),
(719, '20JsSgeKWBjvEn8y', 'ppppppppppppppqg'),
(720, '20JsSgeKWBjvEn8y', 'ppppppppppppppqk'),
(721, '20JsSgeKWBjvEn8y', 'ppppppppppppppqo'),
(722, '20JsSgeKWBjvEn8y', 'ppppppppppppppqs'),
(723, '20JsSgeKWBjvEn8y', 'ppppppppppppppqw'),
(724, '20JsSgeKWBjvEn8y', 'ppppppppppppppra'),
(725, '20JsSgeKWBjvEn8y', 'ppppppppppppppre'),
(726, '20JsSgeKWBjvEn8y', 'ppppppppppppppri'),
(727, '20JsSgeKWBjvEn8y', 'ppppppppppppppti'),
(930, 'rrrrrrrrrrrrrrrb', 'pppppppppppppppb'),
(931, 'rrrrrrrrrrrrrrrb', 'pppppppppppppppc'),
(932, 'rrrrrrrrrrrrrrrb', 'pppppppppppppppg'),
(933, 'rrrrrrrrrrrrrrrb', 'pppppppppppppppn'),
(934, 'rrrrrrrrrrrrrrrb', 'pppppppppppppppu'),
(935, 'rrrrrrrrrrrrrrrb', 'pppppppppppppppy'),
(936, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqg'),
(937, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqk'),
(938, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppql'),
(939, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqm'),
(940, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqn'),
(941, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqo'),
(942, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqp'),
(943, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqq'),
(944, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqr'),
(945, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqs'),
(946, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqt'),
(947, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqu'),
(948, 'rrrrrrrrrrrrrrrb', 'ppppppppppppppqv'),
(949, 'rrrrrrrrrrrrrrrb', 'pppppppppppppepu'),
(950, 'rrrrrrrrrrrrrrra', 'pppppppppppppppa'),
(951, 'rrrrrrrrrrrrrrra', 'pppppppppppppepu'),
(952, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppb'),
(953, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppc'),
(954, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppd'),
(955, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppe'),
(956, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppf'),
(957, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppg'),
(958, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppph'),
(959, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppi'),
(960, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppj'),
(961, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppk'),
(962, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppl'),
(963, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppm'),
(964, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppn'),
(965, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppo'),
(966, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppp'),
(967, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppq'),
(968, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppr'),
(969, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppps'),
(970, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppt'),
(971, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppu'),
(972, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppv'),
(973, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppw'),
(974, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppx'),
(975, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppy'),
(976, 'rrrrrrrrrrrrrrrg', 'pppppppppppppppz'),
(977, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqa'),
(978, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqb'),
(979, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqc'),
(980, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqd'),
(981, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqe'),
(982, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqf'),
(983, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqg'),
(984, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqh'),
(985, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqi'),
(986, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqj'),
(987, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqk'),
(988, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppql'),
(989, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqm'),
(990, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqn'),
(991, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqo'),
(992, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqp'),
(993, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqq'),
(994, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqr'),
(995, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqs'),
(996, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqt'),
(997, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqu'),
(998, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqv'),
(999, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqw'),
(1000, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqx'),
(1001, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqy'),
(1002, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppqz'),
(1003, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppra'),
(1004, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprb'),
(1005, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprc'),
(1006, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprd'),
(1007, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppre'),
(1008, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprf'),
(1009, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprg'),
(1010, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprh'),
(1011, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppri'),
(1012, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprj'),
(1013, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprk'),
(1014, 'rrrrrrrrrrrrrrrg', 'pppppppppppppprl'),
(1015, 'rrrrrrrrrrrrrrrg', 'ppppppppppppppti'),
(1016, 'rrrrrrrrrrrrrrrg', 'pppppppppppppptj'),
(1017, 'rrrrrrrrrrrrrrrg', 'pppppppppppppptk'),
(1018, 'rrrrrrrrrrrrrrrg', 'pppppppppppppptl'),
(1019, 'rrrrrrrrrrrrrrrg', 'pppppppppppppepu'),
(1020, 'rrrrrrrrrrrrrrrg', 'pppppppppppdppre'),
(1021, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppb'),
(1022, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppc'),
(1023, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppg'),
(1024, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppph'),
(1025, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppi'),
(1026, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppj'),
(1027, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppn'),
(1028, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppo'),
(1029, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppp'),
(1030, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppq'),
(1031, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppu'),
(1032, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppv'),
(1033, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppw'),
(1034, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppx'),
(1035, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppy'),
(1036, 'rrrrrrrrrrrrrrrf', 'pppppppppppppppz'),
(1037, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqa'),
(1038, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqb'),
(1039, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqc'),
(1040, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqg'),
(1041, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqh'),
(1042, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqi'),
(1043, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqj'),
(1044, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqk'),
(1045, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppql'),
(1046, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqm'),
(1047, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqn'),
(1048, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqo'),
(1049, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqp'),
(1050, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqq'),
(1051, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqr'),
(1052, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqs'),
(1053, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqt'),
(1054, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqu'),
(1055, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqv'),
(1056, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppqw'),
(1057, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppra'),
(1058, 'rrrrrrrrrrrrrrrf', 'pppppppppppppprb'),
(1059, 'rrrrrrrrrrrrrrrf', 'pppppppppppppprc'),
(1060, 'rrrrrrrrrrrrrrrf', 'pppppppppppppprd'),
(1061, 'rrrrrrrrrrrrrrrf', 'ppppppppppppppti'),
(1062, 'rrrrrrrrrrrrrrrf', 'pppppppppppppptj'),
(1063, 'rrrrrrrrrrrrrrrf', 'pppppppppppppptk'),
(1064, 'rrrrrrrrrrrrrrrf', 'pppppppppppppptl'),
(1065, 'rrrrrrrrrrrrrrrf', 'pppppppppppppepu'),
(1066, 'rrrrrrrrrrrrrrrf', 'pppppppppppdppre'),
(1067, 'rrrrrrrrrrrrrrre', 'pppppppppppppppb'),
(1068, 'rrrrrrrrrrrrrrre', 'pppppppppppppppc'),
(1069, 'rrrrrrrrrrrrrrre', 'pppppppppppppppg'),
(1070, 'rrrrrrrrrrrrrrre', 'pppppppppppppppn'),
(1071, 'rrrrrrrrrrrrrrre', 'pppppppppppppppo'),
(1072, 'rrrrrrrrrrrrrrre', 'pppppppppppppppp'),
(1073, 'rrrrrrrrrrrrrrre', 'pppppppppppppppq'),
(1074, 'rrrrrrrrrrrrrrre', 'pppppppppppppppu'),
(1075, 'rrrrrrrrrrrrrrre', 'pppppppppppppppy'),
(1076, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqg'),
(1077, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqh'),
(1078, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqi'),
(1079, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqj'),
(1080, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqk'),
(1081, 'rrrrrrrrrrrrrrre', 'ppppppppppppppql'),
(1082, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqm'),
(1083, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqn'),
(1084, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqo'),
(1085, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqp'),
(1086, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqq'),
(1087, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqr'),
(1088, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqs'),
(1089, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqt'),
(1090, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqu'),
(1091, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqv'),
(1092, 'rrrrrrrrrrrrrrre', 'ppppppppppppppqw'),
(1093, 'rrrrrrrrrrrrrrre', 'ppppppppppppppra'),
(1094, 'rrrrrrrrrrrrrrre', 'pppppppppppppprb'),
(1095, 'rrrrrrrrrrrrrrre', 'pppppppppppppprc'),
(1096, 'rrrrrrrrrrrrrrre', 'pppppppppppppprd'),
(1097, 'rrrrrrrrrrrrrrre', 'ppppppppppppppti'),
(1098, 'rrrrrrrrrrrrrrre', 'pppppppppppppptj'),
(1099, 'rrrrrrrrrrrrrrre', 'pppppppppppppptk'),
(1100, 'rrrrrrrrrrrrrrre', 'pppppppppppppptl'),
(1101, 'rrrrrrrrrrrrrrre', 'pppppppppppppepu'),
(1102, 'rrrrrrrrrrrrrrre', 'pppppppppppdppre'),
(1103, 'rrrrrrrrrrrrrrrd', 'pppppppppppppppb'),
(1104, 'rrrrrrrrrrrrrrrd', 'pppppppppppppppc'),
(1105, 'rrrrrrrrrrrrrrrd', 'pppppppppppppppg'),
(1106, 'rrrrrrrrrrrrrrrd', 'pppppppppppppppn'),
(1107, 'rrrrrrrrrrrrrrrd', 'pppppppppppppppu'),
(1108, 'rrrrrrrrrrrrrrrd', 'pppppppppppppppy'),
(1109, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqg'),
(1110, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqk'),
(1111, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppql'),
(1112, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqm'),
(1113, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqn'),
(1114, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqo'),
(1115, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqp'),
(1116, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqq'),
(1117, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqr'),
(1118, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqs'),
(1119, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqt'),
(1120, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqu'),
(1121, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqv'),
(1122, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppqw'),
(1123, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppra'),
(1124, 'rrrrrrrrrrrrrrrd', 'pppppppppppppprb'),
(1125, 'rrrrrrrrrrrrrrrd', 'pppppppppppppprc'),
(1126, 'rrrrrrrrrrrrrrrd', 'pppppppppppppprd'),
(1127, 'rrrrrrrrrrrrrrrd', 'ppppppppppppppti'),
(1128, 'rrrrrrrrrrrrrrrd', 'pppppppppppppptj'),
(1129, 'rrrrrrrrrrrrrrrd', 'pppppppppppppptk'),
(1130, 'rrrrrrrrrrrrrrrd', 'pppppppppppppptl'),
(1131, 'rrrrrrrrrrrrrrrd', 'pppppppppppppepu'),
(1132, 'rrrrrrrrrrrrrrrd', 'pppppppppppdppre'),
(1133, 'rrrrrrrrrrrrrrrc', 'pppppppppppppppb'),
(1134, 'rrrrrrrrrrrrrrrc', 'pppppppppppppppc'),
(1135, 'rrrrrrrrrrrrrrrc', 'pppppppppppppppg'),
(1136, 'rrrrrrrrrrrrrrrc', 'pppppppppppppppn'),
(1137, 'rrrrrrrrrrrrrrrc', 'pppppppppppppppu'),
(1138, 'rrrrrrrrrrrrrrrc', 'pppppppppppppppy'),
(1139, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqg'),
(1140, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqk'),
(1141, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppql'),
(1142, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqm'),
(1143, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqn'),
(1144, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqo'),
(1145, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqp'),
(1146, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqq'),
(1147, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqr'),
(1148, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqs'),
(1149, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqt'),
(1150, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqu'),
(1151, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqv'),
(1152, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppqw'),
(1153, 'rrrrrrrrrrrrrrrc', 'ppppppppppppppti'),
(1154, 'rrrrrrrrrrrrrrrc', 'pppppppppppppptj'),
(1155, 'rrrrrrrrrrrrrrrc', 'pppppppppppppptk'),
(1156, 'rrrrrrrrrrrrrrrc', 'pppppppppppppptl'),
(1157, 'rrrrrrrrrrrrrrrc', 'pppppppppppppepu'),
(1158, 'rrrrrrrrrrrrrrrc', 'pppppppppppdppre'),
(1159, 'X1vsMOs8gptsuqBn', 'pppppppppppppppa'),
(1160, 'X1vsMOs8gptsuqBn', 'pppppppppppppppb'),
(1161, 'X1vsMOs8gptsuqBn', 'pppppppppppppppc'),
(1162, 'X1vsMOs8gptsuqBn', 'pppppppppppppppg'),
(1163, 'X1vsMOs8gptsuqBn', 'ppppppppppppppph'),
(1164, 'X1vsMOs8gptsuqBn', 'pppppppppppppppi'),
(1165, 'X1vsMOs8gptsuqBn', 'pppppppppppppppn'),
(1166, 'X1vsMOs8gptsuqBn', 'pppppppppppppppo'),
(1167, 'X1vsMOs8gptsuqBn', 'pppppppppppppppp'),
(1168, 'X1vsMOs8gptsuqBn', 'pppppppppppppppu'),
(1169, 'X1vsMOs8gptsuqBn', 'pppppppppppppppv'),
(1170, 'X1vsMOs8gptsuqBn', 'pppppppppppppppw'),
(1171, 'X1vsMOs8gptsuqBn', 'pppppppppppppppx'),
(1172, 'X1vsMOs8gptsuqBn', 'pppppppppppppppy'),
(1173, 'X1vsMOs8gptsuqBn', 'pppppppppppppppz'),
(1174, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqa'),
(1175, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqg'),
(1176, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqh'),
(1177, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqi'),
(1178, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqj'),
(1179, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqk'),
(1180, 'X1vsMOs8gptsuqBn', 'ppppppppppppppql'),
(1181, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqm'),
(1182, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqn'),
(1183, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqo'),
(1184, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqp'),
(1185, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqq'),
(1186, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqr'),
(1187, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqs'),
(1188, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqt'),
(1189, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqu'),
(1190, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqv'),
(1191, 'X1vsMOs8gptsuqBn', 'ppppppppppppppqw'),
(1192, 'wkBxkNvcwnwAml7w', 'pppppppppppppppb'),
(1193, 'wkBxkNvcwnwAml7w', 'pppppppppppppppc'),
(1194, 'wkBxkNvcwnwAml7w', 'pppppppppppppppg'),
(1195, 'wkBxkNvcwnwAml7w', 'pppppppppppppppn'),
(1196, 'wkBxkNvcwnwAml7w', 'pppppppppppppppu'),
(1197, 'wkBxkNvcwnwAml7w', 'pppppppppppppppy'),
(1198, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqg'),
(1199, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqk'),
(1200, 'wkBxkNvcwnwAml7w', 'ppppppppppppppql'),
(1201, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqm'),
(1202, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqn'),
(1203, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqo'),
(1204, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqp'),
(1205, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqq'),
(1206, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqr'),
(1207, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqs'),
(1208, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqt'),
(1209, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqu'),
(1210, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqv'),
(1211, 'wkBxkNvcwnwAml7w', 'ppppppppppppppqw'),
(1212, 'wkBxkNvcwnwAml7w', 'ppppppppppppppra'),
(1213, 'wkBxkNvcwnwAml7w', 'pppppppppppppprb'),
(1214, 'wkBxkNvcwnwAml7w', 'pppppppppppppprc'),
(1215, 'wkBxkNvcwnwAml7w', 'pppppppppppppprd'),
(1216, 'wkBxkNvcwnwAml7w', 'ppppppppppppppti'),
(1217, 'wkBxkNvcwnwAml7w', 'pppppppppppppptj'),
(1218, 'wkBxkNvcwnwAml7w', 'pppppppppppppptk'),
(1219, 'wkBxkNvcwnwAml7w', 'pppppppppppppptl'),
(1220, 'wkBxkNvcwnwAml7w', 'pppppppppppppepu'),
(1221, 'wkBxkNvcwnwAml7w', 'pppppppppppdppre');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Acl_Perms`
--

CREATE TABLE IF NOT EXISTS `tnng_Acl_Perms` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='Permission names.';

--
-- Dumping data for table `tnng_Acl_Perms`
--

INSERT INTO `tnng_Acl_Perms` (`aid`, `id`, `created`, `status`, `name`) VALUES
(46, 'ppppppppppppppqt', 1380828233, 1, 'addAttachment'),
(26, 'pppppppppppppppz', 1380828233, 1, 'addCompetency'),
(58, 'pppppppppppppprf', 1380828233, 1, 'addCompiledform'),
(30, 'ppppppppppppppqd', 1380828233, 1, 'addDefaultCompetency'),
(18, 'pppppppppppppppr', 1380828233, 1, 'addDefaultDepartment'),
(11, 'pppppppppppppppk', 1380828233, 1, 'addDefaultDivision'),
(15, 'pppppppppppppppo', 1380828233, 1, 'addDepartment'),
(8, 'ppppppppppppppph', 1380828233, 1, 'addDivision'),
(34, 'ppppppppppppppqh', 1380828233, 1, 'addObjective'),
(4, 'pppppppppppppppd', 1380828233, 1, 'addProperty'),
(62, 'pppppppppppppprj', 1380828233, 1, 'addReviewcycle'),
(50, 'ppppppppppppppqx', 1380828233, 1, 'addRole'),
(38, 'ppppppppppppppql', 1380828233, 1, 'addStrategy'),
(54, 'pppppppppppppprb', 1380828233, 1, 'addSubevaluation'),
(42, 'ppppppppppppppqp', 1380828233, 1, 'addTactic'),
(66, 'pppppppppppppptj', 1380828233, 1, 'addTemplate'),
(22, 'pppppppppppppppv', 1380828233, 1, 'addUser'),
(2, 'pppppppppppppppb', 1380828233, 1, 'authenticated'),
(48, 'ppppppppppppppqv', 1380828233, 1, 'deleteAttachment'),
(28, 'ppppppppppppppqb', 1380828233, 1, 'deleteCompetency'),
(60, 'pppppppppppppprh', 1380828233, 1, 'deleteCompiledform'),
(32, 'ppppppppppppppqf', 1380828233, 1, 'deleteDefaultCompetency'),
(20, 'pppppppppppppppt', 1380828233, 1, 'deleteDefaultDepartment'),
(13, 'pppppppppppppppm', 1380828233, 1, 'deleteDefaultDivision'),
(17, 'pppppppppppppppq', 1380828233, 1, 'deleteDepartment'),
(10, 'pppppppppppppppj', 1380828233, 1, 'deleteDivision'),
(36, 'ppppppppppppppqj', 1380828233, 1, 'deleteObjective'),
(6, 'pppppppppppppppf', 1380828233, 1, 'deleteProperty'),
(64, 'pppppppppppppprl', 1380828233, 1, 'deleteReviewcycle'),
(52, 'ppppppppppppppqz', 1380828233, 1, 'deleteRole'),
(40, 'ppppppppppppppqn', 1380828233, 1, 'deleteStrategy'),
(56, 'pppppppppppppprd', 1380828233, 1, 'deleteSubevaluation'),
(44, 'ppppppppppppppqr', 1380828233, 1, 'deleteTactic'),
(68, 'pppppppppppppptl', 1380828233, 1, 'deleteTemplate'),
(24, 'pppppppppppppppx', 1380828233, 1, 'deleteUser'),
(47, 'ppppppppppppppqu', 1380828233, 1, 'editAttachment'),
(27, 'ppppppppppppppqa', 1380828233, 1, 'editCompetency'),
(59, 'pppppppppppppprg', 1380828233, 1, 'editCompiledform'),
(31, 'ppppppppppppppqe', 1380828233, 1, 'editDefaultCompetency'),
(19, 'ppppppppppppppps', 1380828233, 1, 'editDefaultDepartment'),
(12, 'pppppppppppppppl', 1380828233, 1, 'editDefaultDivision'),
(16, 'pppppppppppppppp', 1380828233, 1, 'editDepartment'),
(9, 'pppppppppppppppi', 1380828233, 1, 'editDivision'),
(35, 'ppppppppppppppqi', 1380828233, 1, 'editObjective'),
(5, 'pppppppppppppppe', 1380828233, 1, 'editProperty'),
(63, 'pppppppppppppprk', 1380828233, 1, 'editReviewcycle'),
(51, 'ppppppppppppppqy', 1380828233, 1, 'editRole'),
(39, 'ppppppppppppppqm', 1380828233, 1, 'editStrategy'),
(55, 'pppppppppppppprc', 1380828233, 1, 'editSubevaluation'),
(43, 'ppppppppppppppqq', 1380828233, 1, 'editTactic'),
(67, 'pppppppppppppptk', 1380828233, 1, 'editTemplate'),
(23, 'pppppppppppppppw', 1380828233, 1, 'editUser'),
(29, 'ppppppppppppppqc', 1380828233, 1, 'hideCompetency'),
(69, 'pppppppppppppprm', 1380828233, 1, 'peerReview'),
(45, 'ppppppppppppppqs', 1380828233, 1, 'viewAttachment'),
(70, 'pppppppppppppepu', 1380828233, 1, 'viewCalendar'),
(25, 'pppppppppppppppy', 1380828233, 1, 'viewCompetency'),
(57, 'ppppppppppppppre', 1380828233, 1, 'viewCompiledform'),
(14, 'pppppppppppppppn', 1380828233, 1, 'viewDepartment'),
(7, 'pppppppppppppppg', 1380828233, 1, 'viewDivision'),
(1, 'pppppppppppppppa', 1380828233, 1, 'viewLogin'),
(33, 'ppppppppppppppqg', 1380828233, 1, 'viewObjective'),
(3, 'pppppppppppppppc', 1380828233, 1, 'viewProperty'),
(61, 'ppppppppppppppri', 1380828233, 1, 'viewReviewcycle'),
(49, 'ppppppppppppppqw', 1380828233, 1, 'viewRole'),
(37, 'ppppppppppppppqk', 1380828233, 1, 'viewStrategy'),
(53, 'ppppppppppppppra', 1380828233, 1, 'viewSubevaluation'),
(71, 'pppppppppppdppre', 1380828233, 1, 'viewSummary'),
(41, 'ppppppppppppppqo', 1380828233, 1, 'viewTactic'),
(65, 'ppppppppppppppti', 1380828233, 1, 'viewTemplate'),
(21, 'pppppppppppppppu', 1380828233, 1, 'viewUser');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Acl_Roles`
--

CREATE TABLE IF NOT EXISTS `tnng_Acl_Roles` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '10'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Role names.';

--
-- Dumping data for table `tnng_Acl_Roles`
--

INSERT INTO `tnng_Acl_Roles` (`aid`, `id`, `created`, `status`, `name`, `level`) VALUES
(6, 'rrrrrrrrrrrrrrrf', 1380828233, 1, 'Administration', 5),
(1, 'rrrrrrrrrrrrrrra', 1380828233, 1, 'Anonymous', 0),
(2, 'rrrrrrrrrrrrrrrb', 1380828233, 1, 'Associate', 1),
(13, 'wkBxkNvcwnwAml7w', 1463585569, 1, 'Department Head', 10),
(4, 'rrrrrrrrrrrrrrrd', 1380828233, 1, 'Department Manager', 3),
(5, 'rrrrrrrrrrrrrrre', 1380828233, 1, 'Division Director', 4),
(8, 'V4ZBTCPZPAUtPUth', 1446224052, 1, 'JustLogin', 10),
(10, 'EO4u5UXVJYXW4M5Z', 1453996284, 1, 'New Role', 10),
(11, '20JsSgeKWBjvEn8y', 1456944174, 1, 'ReadOnly', 10),
(7, 'rrrrrrrrrrrrrrrg', 1380828233, 1, 'Super User', 100),
(3, 'rrrrrrrrrrrrrrrc', 1380828233, 1, 'Supervisor', 2),
(9, 'VTJ5S5r3Y4pt0Qj6', 1446650923, 1, 'test role', 10),
(12, 'X1vsMOs8gptsuqBn', 1463166949, 1, 'True North Property Admin', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Attachment`
--

CREATE TABLE IF NOT EXISTS `tnng_Attachment` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `parent_id` char(16) NOT NULL DEFAULT '0',
  `name` varchar(256) DEFAULT NULL,
  `path` varchar(256) NOT NULL,
  `mime` varchar(256) NOT NULL,
  `description` varchar(8192) DEFAULT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attachment storage.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Competency`
--

CREATE TABLE IF NOT EXISTS `tnng_Competency` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort_order` int(11) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='Competency names.';

--
-- Dumping data for table `tnng_Competency`
--

INSERT INTO `tnng_Competency` (`aid`, `id`, `created`, `status`, `sort_order`, `name`, `default`, `cid`) VALUES
(67, '5JQURaiI77jcLlvY', 1463493537, 1, 3, 'Financial Performance', 0, '6v3sWTOdQ6KFK1Se'),
(68, 'aslMAF7Y9B4ECg0w', 1463168895, 1, 1, 'Revenue Generation', 0, '1CyOinx6GOWjXDyp'),
(66, 'h2ky9BCLtDiUg6wU', 1463493512, 1, 2, 'Guest Experience', 0, '6v3sWTOdQ6KFK1Se'),
(17, 'l5Y3PuzfQeSiywTw', 1446650128, 0, NULL, 'test competency', 1, 'uuuuuuuuuuuuuuud'),
(65, 'Mm4NXisjGWjzJAU9', 1463493465, 1, 4, 'Leadership', 0, '6v3sWTOdQ6KFK1Se'),
(71, 'oMQPFFIMBDzVbjkz', 1463493584, 1, 7, 'Process Improvement', 0, '6v3sWTOdQ6KFK1Se'),
(72, 'sC8FI1mbNTbvvovF', 1463579137, 1, 6, 'Brand Initiatives', 0, '1CyOinx6GOWjXDyp'),
(69, 'uAx82aAfNY6WKE5M', 1463493487, 1, 8, 'Work / Life Balance', 0, '6v3sWTOdQ6KFK1Se'),
(70, 'VMuqnbfBSNTjTJbf', 1463493817, 1, 5, 'Property Environment', 0, '1CyOinx6GOWjXDyp'),
(12, 'xnBihqjHQHhUbkVk', 1446489276, 0, NULL, 'Test Competency', 0, 'uuuuuuuuuuuuuuud');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Competency_Objective`
--

CREATE TABLE IF NOT EXISTS `tnng_Competency_Objective` (
`aid` bigint(20) unsigned NOT NULL,
  `competency_id` char(16) NOT NULL,
  `objective_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Competency to Objective one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Competency_Strategy`
--

CREATE TABLE IF NOT EXISTS `tnng_Competency_Strategy` (
`aid` bigint(20) unsigned NOT NULL,
  `competency_id` char(16) NOT NULL,
  `strategy_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Competency to Strategy one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Compiledform`
--

CREATE TABLE IF NOT EXISTS `tnng_Compiledform` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `description` varchar(8192) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `evaltype` varchar(16) NOT NULL,
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cid` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tnng_Compiledform`
--

INSERT INTO `tnng_Compiledform` (`aid`, `id`, `created`, `status`, `name`, `description`, `active`, `evaltype`, `locked`, `cid`) VALUES
(6, '3w8MZBUQwBIIt8mk', 1411160054, 1, 'F&B Manager', 'ffff', 0, 'me', 1, 'IphMs4uKYQz7hwyL'),
(10, '7WPW2XuvKVr7aV8f', 1430240930, 1, 'Test Form for Rating Key Header', 'Test', 0, 'me', 1, 'IphMs4uKYQz7hwyL'),
(3, '8trdWVAnVoe8mjOu', 1398801475, 1, 'Culinary Review', 'Culinary', 0, 'ae', 0, 'IphMs4uKYQz7hwyL'),
(14, '9ME38PPXR4HFNpV1', 1432843373, 1, 'Administrative Leader ', 'Administrative Leader ', 0, 'me', 1, 'uuuuuuuuuuuuuuud'),
(12, 'cTPA7xlGN3QWnmM3', 1430241852, 1, 'True North Objectives Test', 'Test', 0, 'me', 0, 'IphMs4uKYQz7hwyL'),
(1, 'DRwCPN4DWylJahX8', 1398797500, 0, 'Testing', 'Testing', 0, 'me', 0, 'IphMs4uKYQz7hwyL'),
(9, 'duZvftTgB7oaniy2', 1429551542, 1, 'Test Review Form', 'Test', 0, 'me', 1, 'uuuuuuuuuuuuuuud'),
(13, 'EiNHzm8TlOrhQG1C', 1430327332, 1, 'Overall Comments Review Form', 'Do we need this????', 0, 'me', 0, 'IphMs4uKYQz7hwyL'),
(4, 'GOOIlq28a1JAe70x', 1398803321, 0, 'TEST', 'TEST', 0, 'ae', 0, 'uuuuuuuuuuuuuuud'),
(16, 'jX0SjlA4ry34i7Kf', 1439586926, 1, 'test form', 'my form desc\r\n', 0, 'ae', 1, 'uuuuuuuuuuuuuuud'),
(18, 'kUUbPgnVwWqESh6C', 1454003727, 0, 'Commerx', 'test', 0, 'me', 0, 'NQrXkp5jBhARnraK'),
(7, 'laF4VrJPNP5vKnCa', 1425696479, 1, 'Culinary', 'Culinary Performance Review', 0, 'ae', 1, 'uuuuuuuuuuuuuuud'),
(17, 'onT2jRKpEvyX8SzH', 1454003600, 0, 'Commerx test', 'test', 0, 'ae', 0, 'NQrXkp5jBhARnraK'),
(11, 'pdtuAV5qXyVCH6xB', 1430241048, 0, 'TEST', 'TEST', 0, 'me', 1, 'IphMs4uKYQz7hwyL'),
(8, 'q5ua0yeABOJQ07FS', 1438795601, 1, 'Operational Leader', 'Operational Leader Review Form', 0, 'me', 0, 'uuuuuuuuuuuuuuud'),
(15, 'QX1tT3UQgOiwgH66', 1434495143, 0, 'TESTING FORM DO NOT USE', 'DO NOT USE', 0, 'me', 0, 'uuuuuuuuuuuuuuud'),
(5, 'RHNxKTlKuGznMt6r', 1411155557, 1, 'Operations Leader', 'Food & Beverage', 0, 'me', 0, 'IphMs4uKYQz7hwyL'),
(2, 'w9IS5CTuqz9GeAkQ', 1398801207, 1, 'Culinary Review', 'Position Review', 0, 'ae', 1, 'IphMs4uKYQz7hwyL');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Compiledform_Property`
--

CREATE TABLE IF NOT EXISTS `tnng_Compiledform_Property` (
`aid` bigint(20) unsigned NOT NULL,
  `compiledform_id` char(16) NOT NULL,
  `property_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tnng_Compiledform_Property`
--

INSERT INTO `tnng_Compiledform_Property` (`aid`, `compiledform_id`, `property_id`) VALUES
(1, 'DRwCPN4DWylJahX8', 'gGW6XqU3PwIkWXbP'),
(2, 'w9IS5CTuqz9GeAkQ', 'gGW6XqU3PwIkWXbP'),
(3, '8trdWVAnVoe8mjOu', 'gGW6XqU3PwIkWXbP'),
(4, 'GOOIlq28a1JAe70x', 'gGW6XqU3PwIkWXbP'),
(6, 'RHNxKTlKuGznMt6r', 'gGW6XqU3PwIkWXbP'),
(7, '3w8MZBUQwBIIt8mk', 'gGW6XqU3PwIkWXbP'),
(16, 'laF4VrJPNP5vKnCa', 'LM8gM4E3p49HNBtK'),
(17, 'duZvftTgB7oaniy2', 'LM8gM4E3p49HNBtK'),
(18, '7WPW2XuvKVr7aV8f', 'LM8gM4E3p49HNBtK'),
(19, 'pdtuAV5qXyVCH6xB', 'LM8gM4E3p49HNBtK'),
(20, 'cTPA7xlGN3QWnmM3', 'LM8gM4E3p49HNBtK'),
(22, 'EiNHzm8TlOrhQG1C', 'LM8gM4E3p49HNBtK'),
(23, '9ME38PPXR4HFNpV1', 'ayf63xmLCZC9xZJN'),
(24, 'QX1tT3UQgOiwgH66', 'ayf63xmLCZC9xZJN'),
(25, 'q5ua0yeABOJQ07FS', 'ayf63xmLCZC9xZJN'),
(26, 'jX0SjlA4ry34i7Kf', 'ayf63xmLCZC9xZJN'),
(27, 'onT2jRKpEvyX8SzH', 'CoecBl7vDIgn7JAZ'),
(28, 'kUUbPgnVwWqESh6C', 'CoecBl7vDIgn7JAZ');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Compiledform_Sections`
--

CREATE TABLE IF NOT EXISTS `tnng_Compiledform_Sections` (
`aid` bigint(20) unsigned NOT NULL,
  `compiledform_id` char(16) NOT NULL,
  `join_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tnng_Compiledform_Sections`
--

INSERT INTO `tnng_Compiledform_Sections` (`aid`, `compiledform_id`, `join_id`) VALUES
(1, '', 'jFF3qoQgjph59w7t'),
(2, '', 'PvuVQzw0E1KgpAtK'),
(3, 'DRwCPN4DWylJahX8', '7B0MC2DtgSzotvRW'),
(4, '', 'lAnA5JBzhepw3M43'),
(5, 'w9IS5CTuqz9GeAkQ', 'tre5eyTz482GcI3d'),
(6, 'w9IS5CTuqz9GeAkQ', 'uQOZhhZTlys2q0Su'),
(7, 'w9IS5CTuqz9GeAkQ', 'lAnA5JBzhepw3M43'),
(8, '', 'mOnBGkeN8yFi2Q32'),
(9, '8trdWVAnVoe8mjOu', 'mOnBGkeN8yFi2Q32'),
(10, '8trdWVAnVoe8mjOu', 'tre5eyTz482GcI3d'),
(11, '8trdWVAnVoe8mjOu', '2UkGoC7I7kQjU2cX'),
(12, '', '6UdIxDvWm6RSrav7'),
(13, 'GOOIlq28a1JAe70x', 'tre5eyTz482GcI3d'),
(14, 'GOOIlq28a1JAe70x', 'M57C6XB7F2lHjQFs'),
(15, 'GOOIlq28a1JAe70x', '6UdIxDvWm6RSrav7'),
(20, 'RHNxKTlKuGznMt6r', 'DzBCNDn7vmWFJyBe'),
(21, 'RHNxKTlKuGznMt6r', 'oK6SDp4oZnubrUMU'),
(22, 'RHNxKTlKuGznMt6r', 't3IR2j9erTxRvrrZ'),
(23, 'RHNxKTlKuGznMt6r', 'nAonc2nfMcMwVtUS'),
(62, 'laF4VrJPNP5vKnCa', 'PpZRU7uk05kx1N0B'),
(63, 'laF4VrJPNP5vKnCa', 'Y5GeTWjG1Nl4nLSJ'),
(64, 'laF4VrJPNP5vKnCa', '7mgvh9YZyMlnEi3t'),
(65, 'laF4VrJPNP5vKnCa', 'wyzlqGQZ1WgQcDC7'),
(66, 'laF4VrJPNP5vKnCa', 'TVYBihT5HgYSfp9c'),
(67, '', 'FJAVkbVPZlXHrumD'),
(68, 'duZvftTgB7oaniy2', 'FJAVkbVPZlXHrumD'),
(69, 'duZvftTgB7oaniy2', 'QVyydegcqMxLCdNo'),
(70, 'duZvftTgB7oaniy2', 'flUsMFjP7r44ZrRp'),
(71, 'duZvftTgB7oaniy2', 'arIh1XJY5J0f80io'),
(72, '7WPW2XuvKVr7aV8f', 'hIfVhxAgLtrlxSpT'),
(73, 'pdtuAV5qXyVCH6xB', 'hIfVhxAgLtrlxSpT'),
(74, '', '5pc8UsZXVN2obyzp'),
(75, 'cTPA7xlGN3QWnmM3', '7JnbmCD4jWimcEhI'),
(82, 'EiNHzm8TlOrhQG1C', 'KlDcrao4SLd8haY2'),
(83, '9ME38PPXR4HFNpV1', 'DkY1KuVFktAFZ2gj'),
(84, '9ME38PPXR4HFNpV1', 'Xtmc3ymd2kumJW87'),
(85, '9ME38PPXR4HFNpV1', 'IVpb3qKWFU1N2mgw'),
(86, '9ME38PPXR4HFNpV1', 'cw59CVSEzWKXTnLR'),
(87, '9ME38PPXR4HFNpV1', 'WFlBnAvjGXkLdjTV'),
(88, 'QX1tT3UQgOiwgH66', 'DkY1KuVFktAFZ2gj'),
(89, 'q5ua0yeABOJQ07FS', '7JnbmCD4jWimcEhI'),
(90, 'q5ua0yeABOJQ07FS', 'ynRGTgQABNkApOAU'),
(91, 'q5ua0yeABOJQ07FS', 'QVyydegcqMxLCdNo'),
(92, 'q5ua0yeABOJQ07FS', 'vlkmp0IJeLOvmutx'),
(93, 'q5ua0yeABOJQ07FS', 'KlDcrao4SLd8haY2'),
(94, '', '6HWzl3gh5dA67C61'),
(95, 'jX0SjlA4ry34i7Kf', '7mgvh9YZyMlnEi3t'),
(96, 'jX0SjlA4ry34i7Kf', 'XIRWLrW4HwqaX8PD'),
(97, 'jX0SjlA4ry34i7Kf', '6HWzl3gh5dA67C61'),
(98, '3w8MZBUQwBIIt8mk', 'AC7c93ASlRXCBGMA'),
(99, 'onT2jRKpEvyX8SzH', '7mgvh9YZyMlnEi3t'),
(100, 'onT2jRKpEvyX8SzH', 'TVYBihT5HgYSfp9c'),
(101, 'onT2jRKpEvyX8SzH', 'Y5GeTWjG1Nl4nLSJ'),
(102, 'kUUbPgnVwWqESh6C', 'IVpb3qKWFU1N2mgw'),
(103, 'kUUbPgnVwWqESh6C', 'Xtmc3ymd2kumJW87');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Department`
--

CREATE TABLE IF NOT EXISTS `tnng_Department` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `code` int(10) DEFAULT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='Department names.';

--
-- Dumping data for table `tnng_Department`
--

INSERT INTO `tnng_Department` (`aid`, `id`, `created`, `status`, `name`, `default`, `code`, `cid`) VALUES
(119, '0j3nBtJ2096I4eqP', 1463165169, 1, 'Culinary', 0, 1079870463, '1CyOinx6GOWjXDyp'),
(116, '38MczPWsYfd9w58y', 1463165044, 1, 'Housekeeping', 0, 1566124955, '1CyOinx6GOWjXDyp'),
(120, 'bmvBGFb71wnMfND2', 1463165254, 0, 'Spa', 0, 15179249, '1CyOinx6GOWjXDyp'),
(58, 'gy404ySmXlIuj8sN', 1453821222, 0, 'Test Department', 0, 9847, 'ULEyr7eayRZQTSXS'),
(115, 'o4YRbKCWDWdjvcvT', 1463168267, 1, 'Accounting and Human Resources', 0, 1285125699, '1CyOinx6GOWjXDyp'),
(122, 'peHsQnCozjzHj7pT', 1463168380, 1, 'Sales', 0, 2033971972, '1CyOinx6GOWjXDyp'),
(118, 'u5RNkcTWC0oqKvnt', 1463167707, 1, 'Property Operations', 0, 565654204, '1CyOinx6GOWjXDyp'),
(117, 'vTRESqUJxh0noiz3', 1463580229, 1, 'Front Office and Spa', 0, 45608298, '1CyOinx6GOWjXDyp'),
(121, 'wDHK3QYTlKFv8CdN', 1463167794, 1, 'Restaurant / Banquets / Comp', 0, 220947216, '1CyOinx6GOWjXDyp'),
(100, 'Wv5ZKFo3U9NtG7mh', 1459970092, 1, 'test department', 0, 2063748661, 'ULEyr7eayRZQTSXS');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Department_Objective`
--

CREATE TABLE IF NOT EXISTS `tnng_Department_Objective` (
`aid` bigint(20) unsigned NOT NULL,
  `department_id` char(16) NOT NULL,
  `objective_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Department to Objective one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Department_Strategy`
--

CREATE TABLE IF NOT EXISTS `tnng_Department_Strategy` (
`aid` bigint(20) unsigned NOT NULL,
  `department_id` char(16) NOT NULL,
  `strategy_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='Department to Strategy one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Department_Templates`
--

CREATE TABLE IF NOT EXISTS `tnng_Department_Templates` (
`aid` bigint(20) unsigned NOT NULL,
  `template_id` char(16) NOT NULL,
  `department_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Department Templates';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Department_User`
--

CREATE TABLE IF NOT EXISTS `tnng_Department_User` (
`aid` bigint(20) unsigned NOT NULL,
  `department_id` char(16) NOT NULL,
  `user_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Division to User one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Division`
--

CREATE TABLE IF NOT EXISTS `tnng_Division` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COMMENT='Division names.';

--
-- Dumping data for table `tnng_Division`
--

INSERT INTO `tnng_Division` (`aid`, `id`, `created`, `status`, `name`, `default`, `cid`) VALUES
(17, '3sTKN7cQdpkXLwNU', 1446650266, 0, 'test div', 1, 'uuuuuuuuuuuuuuud'),
(72, '4a7aVAyHc6SAqlRE', 1463164939, 1, 'Rooms', 0, '1CyOinx6GOWjXDyp'),
(71, '5PzyX6qodYoofItG', 1463164916, 1, 'Food and Beverage', 0, '1CyOinx6GOWjXDyp'),
(19, 'BZNY3fKloIIBppNI', 1450806714, 0, 'Human Resources', 1, 'IphMs4uKYQz7hwyL'),
(22, 'JLd3vwVCDzuLGHPd', 1457644327, 0, 'Golf', 0, 'mK2reJXZe6InG4RH'),
(74, 'olFKYXwnYwMlp2Tc', 1463686137, 1, 'Administrative and General', 0, 'ULEyr7eayRZQTSXS'),
(49, 'qDmHlw8d7YzikmnS', 1456505176, 0, 'Test Division', 0, 'IphMs4uKYQz7hwyL'),
(21, 'sUzlXinZewyxfXe7', 1453756472, 0, 'New One', 1, 'ULEyr7eayRZQTSXS'),
(73, 'wnv7c3hEFpQ97lOU', 1463168312, 1, 'Sales', 0, '1CyOinx6GOWjXDyp');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Division_Department`
--

CREATE TABLE IF NOT EXISTS `tnng_Division_Department` (
`aid` bigint(20) unsigned NOT NULL,
  `division_id` char(16) NOT NULL,
  `department_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 COMMENT='Division to Department one-to-many.';

--
-- Dumping data for table `tnng_Division_Department`
--

INSERT INTO `tnng_Division_Department` (`aid`, `division_id`, `department_id`) VALUES
(59, 'JLd3vwVCDzuLGHPd', 'gy404ySmXlIuj8sN'),
(114, 'qDmHlw8d7YzikmnS', 'Wv5ZKFo3U9NtG7mh'),
(132, '4a7aVAyHc6SAqlRE', '38MczPWsYfd9w58y'),
(135, '5PzyX6qodYoofItG', '0j3nBtJ2096I4eqP'),
(136, '4a7aVAyHc6SAqlRE', 'bmvBGFb71wnMfND2'),
(139, '4a7aVAyHc6SAqlRE', 'u5RNkcTWC0oqKvnt'),
(140, '5PzyX6qodYoofItG', 'wDHK3QYTlKFv8CdN'),
(141, 'olFKYXwnYwMlp2Tc', 'o4YRbKCWDWdjvcvT'),
(142, 'wnv7c3hEFpQ97lOU', 'peHsQnCozjzHj7pT'),
(143, '4a7aVAyHc6SAqlRE', 'vTRESqUJxh0noiz3');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Division_Objective`
--

CREATE TABLE IF NOT EXISTS `tnng_Division_Objective` (
`aid` bigint(20) unsigned NOT NULL,
  `division_id` char(16) NOT NULL,
  `objective_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Division to Objective one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Division_Strategy`
--

CREATE TABLE IF NOT EXISTS `tnng_Division_Strategy` (
`aid` bigint(20) unsigned NOT NULL,
  `division_id` char(16) NOT NULL,
  `strategy_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='Division to Strategy one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Division_Templates`
--

CREATE TABLE IF NOT EXISTS `tnng_Division_Templates` (
`aid` bigint(20) unsigned NOT NULL,
  `template_id` char(16) NOT NULL,
  `division_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Division Templates';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Division_User`
--

CREATE TABLE IF NOT EXISTS `tnng_Division_User` (
`aid` bigint(20) unsigned NOT NULL,
  `division_id` char(16) NOT NULL,
  `user_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Division to User one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Field`
--

CREATE TABLE IF NOT EXISTS `tnng_Field` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(8192) NOT NULL,
  `type` varchar(64) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COMMENT='Subevaluation Form Component storage.';

--
-- Dumping data for table `tnng_Field`
--

INSERT INTO `tnng_Field` (`aid`, `id`, `created`, `status`, `name`, `title`, `description`, `type`, `active`, `locked`, `cid`) VALUES
(128, '0i46y7RftXCh5VN9', 1432843155, 1, 'Listens', 'Listens', '<ul>\r\n<li>Is an attentive listener, values input from others and seeks to understand</li>\r\n<li>Waits for others to finish speaking before talking</li>\r\n<li>Seeks and acts on feedback</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(51, '0jBfJNaC0ZQPked3', 1425676800, 1, 'Sales-Driven Environment ', 'Sales-Driven Environment ', '<ul>\r\n<li>Champions a sale-driven culture, leads team to focus on goal attainment, driven to succeed.</li>\r\n<li>Manages and communicates sales/revenue goals to team using information from financials, sales, marketing and NVHG operating plans.</li>\r\n<li>Ensures the Resort is a place guests want to be, enjoy being there and are eager to return.</li>\r\n<li>Supports the sales/catering organization, responds quickly to planning questions, and communicates group needs. &nbsp;Ensures Team Members understand all aspects of the sales process.</li>\r\n<li>Manages and works with sales/catering teams to execute contractual obligations.</li>\r\n<li>Provides ongoing opportunities for sales training</li>\r\n<li>Develops innovative sales strategies, forecasts and budgets, annually and monthly. &nbsp;&nbsp;</li>\r\n<li>Weighs the value of each piece of business against Resort and NVHG objectives.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(31, '0jefVgpZHp8t15hA', 1425673170, 1, 'Contributor', 'Contributor', '<p>Actively participates in departmental meetings, pre-shifts, daily line-ups and planning sessions.&nbsp; Advises leadership of ongoing and chronic issues (e.g., supplies, maintenance, equipment, process, systems, and quality).&nbsp; Always accompanies concerns with suggested solutions.</p>', '', 1, 0, 'uuuuuuuuuuuuuuud'),
(131, '0JJgGG5Z36GWz0fS', 1432843155, 1, 'Accountable', 'Accountable', '<ul>\r\n<li>Is responsive</li>\r\n<li>Is goal-oriented and knows what is expected of him/her</li>\r\n<li>Practices excellent problem-solving and decision-making skills</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(144, '0nRNUUhyJp1mEcd5', 1454002955, 1, 'Environmental Awareness', 'Environmental Awareness', '<ul>\r\n<li>Ensures that the Resort&rsquo;s arrival experience sets the tone for outstanding guest experiences.</li>\r\n<li>Ensures outlets, meeting facilities, heart of the house, equipment and storerooms are clean, organized and well-maintained.</li>\r\n<li>Establishes standards and holds Team Members accountable for appropriate ambiance, music, aromas and lighting conditions.</li>\r\n<li>Ensures regular area tours are conducted to assure high standards and trains others to do the same.&nbsp;</li>\r\n<li>Schedules disruptive maintenance tasks at the proper time to minimize guest inconvenience.</li>\r\n<li>Maintains a quiet environment for guests by requiring headsets for radio communications in guest areas.</li>\r\n<li>Works with Resort leadership to establish and execute an effective &ldquo;Green&rdquo; strategy.&nbsp;</li>\r\n<li>Facilitates capital projects and makes capital investment recommendations.</li>\r\n</ul>', 'rating', 1, 0, 'ULEyr7eayRZQTSXS'),
(64, '1WkEbO3HYVkeTqEv', 1425694798, 1, 'Technical Skill', 'Technical Skill', '<p>Excellent knowledge of basic cooking skills, menu, menu ingredients, kitchen equipment, tools, sanitation requirements and plate presentation. Uses NVHG&rsquo;s F&amp;B tools including shift checklists, requisitions, portion control systems and recipe cards. Cooperates with others and other departments so that the operation runs smoothly. Demonstrates culinary creativity. Displays competency in areas in which training has taken place. Uses proper cleaning techniques and demonstrates proper care of equipment. Handles daily workload with minimum supervision. Uses appropriate equipment with appropriate task. Secures and locks up high value items, food, and tools.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(37, '2FtGi89yth7Tnbtt', 1425673473, 1, 'We would like you to focus on next year:', 'We would like you to focus on next year:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(89, '2y4sIaNhp3mn4I1B', 1425699810, 1, 'Guest Service', 'Guest Service', '<ul>\r\n<li>Drives customer service and culture, and ensures it is systemic in the Resort; checks and inspects against established standards.</li>\r\n<li>Ensures all Team Members &nbsp;greet all Guests.</li>\r\n<li>Is engaged daily in guest service. &nbsp;Uses the Northview Schedule Optimizer; makes needed&nbsp;</li>\r\n<li>adjustments to always make sure the right people are in the right place at the right time.</li>\r\n<li>Trains Team Members according to the Resort&rsquo;s Performance Standards, models the way, and uses role playing to demonstrate and develop proper guest service behaviors.</li>\r\n<li>Always aware of the department and Resort&rsquo;s top guest dissatisfiers (e.g., the Dirty Dozen), develops plans to improve performance, and ensures staff is trained to manage chronic issues.</li>\r\n<li>Ensures service scores and goals are posted and reviewed during department meetings.</li>\r\n<li>Nurtures relationships with prospective and existing customers.</li>\r\n<li>Meets NVHG and Brand quality assurance expectations.</li>\r\n<li>Ensures telephones and radios do not interfere with face-to-face guest interactions.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(30, '3iVzA3NLacVS71Zo', 1425673170, 1, 'Uniform, Grooming, and Appearance', 'Uniform, Grooming, and Appearance', '<p>Understands that they are a key part of our guests'' experience. Is always "on" when at work.&nbsp; Always wears appropriate uniform (including appropriate accessories and shoe color) that is well maintained and neatly pressed.&nbsp; Is well groomed and wears their nametag at all times.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(134, '3wgSjpHV8zOZfSR0', 1432843156, 1, 'Planning', 'Planning', '<p>Works together on shared mission and vision to meet overall goals</p>\r\n<p>Strategizes, plans and set goals, gaining a competitive advantage</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(86, '4my2qSxD1Ds4HA3v', 1425696201, 1, 'Team Member Comments:', 'Team Member Comments:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(35, '5IgLP02XotEXKSo9', 1425673407, 1, 'We would like you to focus on next year:', 'We would like you to focus on next year:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(43, '5ZVGd5ZVgekdyVJi', 1425673776, 1, 'Manager’s Comments', 'Manager’s Comments ', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(1, '6cXltsGwnDr3yUtI', 1398801053, 1, 'Personal', 'Personal', '<p><span style="text-align: justify; text-indent: -0.25in; font-size: 9pt; font-family: Arial, sans-serif;">Arrives at work when scheduled. &nbsp;Accurately keeps track of hours worked through the timekeeping system. Is reliable and dependable. &nbsp;Demonstrates a strong commitment to the job and the Resort is a high priority in their life. &nbsp;Shows concern when objectives are not met. &nbsp;Maintains high standards. &nbsp;Speaks well of the Resort to friends and co-workers and shares concerns directly with leadership and refrains from complaining to co-workers.&nbsp; Follows the rules, uses good judgment, and does things the best way.</span></p>\r\n<p class="MsoListParagraph" style="margin-top:6.0pt;margin-right:4.3pt;\r\nmargin-bottom:6.0pt;margin-left:74.75pt;mso-add-space:auto;text-align:justify;\r\ntext-indent:-.25in;mso-list:l0 level1 lfo1">&nbsp;</p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(49, '7PCImLTwDjbAq8sY', 1425675684, 1, 'Team Leadership', 'Team Leadership', '<ul>\r\n<li>Leads by example (words and actions match.)</li>\r\n<li>Builds the best team by being personally involved in the hiring process, utilizing NVHG&rsquo;s behavioral interviewing tools, and being an employer-of-choice.&nbsp;</li>\r\n<li>Shows sincere care for Team Members as our most valuable resource and helps people reach their full potential.</li>\r\n<li>Ensures department orientation, daily line-ups and monthly department meetings are conducted.</li>\r\n<li>Ensures the performance review process provides supportive guidance in an environment that enables personal growth, mutual trust and integrity. &nbsp;Sets appropriate development goals, communicates them and follows up on plans.</li>\r\n<li>Adheres to all human resources policies and procedures and holds Team Members accountable; confronts performance problems and addresses poor performers.</li>\r\n<li>Is passionate and creatively celebrates successes and supports Team Member recognition/incentive programs.</li>\r\n<li>Reviews Team Member satisfaction results and prepares and follows through on action plans.</li>\r\n<li>Provides a proactive approach to safe work practices and acts to minimize workers&rsquo; compensation claims.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(137, '8PPSv7ODT4SBcOpV', 1432843221, 1, 'What we would like you to focus on next year', 'What we would like you to focus on next year', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(18, '9c1eC6wttsSYXUlZ', 1423873647, 1, 'Service Delivery', 'Service Delivery', '<p><span style="font-size: 9.0pt; font-family: ''Arial'',''sans-serif''; mso-fareast-font-family: ''Times New Roman''; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">Demonstrates active and engaged service behaviors and attitudes, professional body language and appearance; greets all Associates.&nbsp; Consistently meets or exceeds established culinary standards for food preparation, sanitation, and ware washing.&nbsp; Adjusts and prioritizes work flow to accommodate business needs.&nbsp; Takes pride and ownership in all tasks.&nbsp; Provides service by anticipating, asking and acting.&nbsp; Effective team player by building internal Associate relations.&nbsp; Supports and responds to the server to ensure guest satisfaction and understands the &ldquo;line of sight to the customer&rdquo;.</span></p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(116, '9rxlp7R5zOjWqAQg', 1432843141, 1, 'Integrity', 'Integrity', '<ul>\r\n<li>Keeps commitments and actions always follow words</li>\r\n<li>Decisions are based on the overall best interest of guests, co-workers and the Company</li>\r\n<li>Communicates in an honest, respectful, direct and professional manner</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(28, 'aCqHymAV4nghb3B7', 1425673170, 1, 'Personal', 'Personal', '<p>Arrives at work when scheduled.&nbsp; Accurately keeps track of hours worked through the timekeeping system. Is reliable and dependable.&nbsp; Demonstrates a strong commitment to the job and the Resort is a high priority in their life.&nbsp; Shows concern when objectives are not met.&nbsp; Maintains high standards.&nbsp; Speaks well of the Resort to friends and co-workers and shares concerns directly with leadership and refrains from complaining to co-workers.&nbsp; Follows the rules, uses good judgment, and does things the best way.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(47, 'APfo3U5ChxkwlRCu', 1425675684, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates in the development of the Annual Operating Plan (AOP). &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</li>\r\n<li>Actively participates in the monthly forecast of revenues and expenses for area.</li>\r\n<li>Utilizes the 14-Day Forecast, Northview Schedule Optimizer, and Daily Flash to adjust spending and labor, makes contingency plans to meet profit and flow-through expectations&nbsp;</li>\r\n<li>Adheres to NVHG accounting standards as measured by the Controller and internal audit.</li>\r\n<li>Analyzes results, determines key reasons for variances to target, and clearly/professionally communicates reasons both verbally and in written form when required.</li>\r\n<li>Ensures invoices are promptly turned in and properly coded.</li>\r\n<li>Ensures controls are in place and Team Members are held accountable.</li>\r\n<li>Utilizes checkbook accounting.</li>\r\n<li>Stays abreast of industry trends, constantly evaluates business processes and seeks to improve efficiency; dedicated to continuous improvement.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(84, 'aZKq1unDaN2Lh5R8', 1425696201, 1, 'What we would like you to focus on next year:', 'What we would like you to focus on next year:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(46, 'B54gGKvg5A21XpBG', 1425675684, 1, 'Sales-Driven Environment ', 'Sales-Driven Environment ', '<ul>\r\n<li>Champions a sale-driven culture, leads team to focus on goal attainment, driven to succeed.</li>\r\n<li>Manages and communicates sales/revenue goals to team using information from financials, sales, marketing and NVHG operating plans.</li>\r\n<li>Ensures the Resort is a place guests want to be, enjoy being there and are eager to return.</li>\r\n<li>Supports the sales/catering organization, responds quickly to planning questions, and communicates group needs. &nbsp;Ensures Team Members understand all aspects of the sales process.</li>\r\n<li>Manages and works with sales/catering teams to execute contractual obligations.</li>\r\n<li>Provides ongoing opportunities for sales training</li>\r\n<li>Develops innovative sales strategies, forecasts and budgets, annually and monthly. &nbsp;&nbsp;</li>\r\n<li>Weighs the value of each piece of business against Resort and NVHG objectives.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(88, 'b7mCJzmagDSdWb2E', 1425699810, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates in the development of the Annual Operating Plan (AOP). &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</li>\r\n<li>Actively participates in the monthly forecast of revenues and expenses for area.</li>\r\n<li>Utilizes the 14-Day Forecast, Northview Schedule Optimizer, and Daily Flash to adjust spending and labor, makes contingency plans to meet profit and flow-through expectations&nbsp;</li>\r\n<li>Adheres to NVHG accounting standards as measured by the Controller and internal audit.</li>\r\n<li>Analyzes results, determines key reasons for variances to target, and clearly/professionally communicates reasons both verbally and in written form when required.</li>\r\n<li>Ensures invoices are promptly turned in and properly coded.</li>\r\n<li>Ensures controls are in place and Team Members are held accountable.</li>\r\n<li>Utilizes checkbook accounting.</li>\r\n<li>Stays abreast of industry trends, constantly evaluates business processes and seeks to improve efficiency; dedicated to continuous improvement.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(141, 'bCvT3slC7f7Wgtrt', 1454002955, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates in the development of the Annual Operating Plan (AOP). &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</li>\r\n<li>Actively participates in the monthly forecast of revenues and expenses for area.</li>\r\n<li>Utilizes the 14-Day Forecast, Northview Schedule Optimizer, and Daily Flash to adjust spending and labor, makes contingency plans to meet profit and flow-through expectations&nbsp;</li>\r\n<li>Adheres to NVHG accounting standards as measured by the Controller and internal audit.</li>\r\n<li>Analyzes results, determines key reasons for variances to target, and clearly/professionally communicates reasons both verbally and in written form when required.</li>\r\n<li>Ensures invoices are promptly turned in and properly coded.</li>\r\n<li>Ensures controls are in place and Team Members are held accountable.</li>\r\n<li>Utilizes checkbook accounting.</li>\r\n<li>Stays abreast of industry trends, constantly evaluates business processes and seeks to improve efficiency; dedicated to continuous improvement.</li>\r\n</ul>', 'rating', 1, 0, 'ULEyr7eayRZQTSXS'),
(125, 'BF2L1f1zTI1H3u8P', 1432843142, 1, 'Culture Comments', 'Culture Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(130, 'CKMuopHPXVkFZcRS', 1432843155, 1, 'Collaborator', 'Collaborator', '<ul>\r\n<li>Communicates honestly and in a timely manner</li>\r\n<li>Keeps others informed</li>\r\n<li>Works with others to make things better</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(93, 'CmtlwbxHlk35sJhH', 1429551446, 1, 'Test', 'Test', '<p>Test</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(5, 'cpm3COw1JdG7SJFO', 1403021630, 1, 'TEST', 'TEST', '<p>TEST</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(129, 'dQQfIilrlclKal5h', 1432843155, 1, 'Respectful', 'Respectful', '<ul>\r\n<li>Treats others with dignity and acts with gratitude and demonstrates humility</li>\r\n<li>Values diversity and individuality</li>\r\n<li>Always gives others the benefit of the doubt</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(143, 'dYGwDieOigApVxQf', 1454002955, 1, 'Team Leadership', 'Team Leadership', '<ul>\r\n<li>Leads by example (words and actions match.)</li>\r\n<li>Builds the best team by being personally involved in the hiring process, utilizing NVHG&rsquo;s behavioral interviewing tools, and being an employer-of-choice.&nbsp;</li>\r\n<li>Shows sincere care for Team Members as our most valuable resource and helps people reach their full potential.</li>\r\n<li>Ensures department orientation, daily line-ups and monthly department meetings are conducted.</li>\r\n<li>Ensures the performance review process provides supportive guidance in an environment that enables personal growth, mutual trust and integrity. &nbsp;Sets appropriate development goals, communicates them and follows up on plans.</li>\r\n<li>Adheres to all human resources policies and procedures and holds Team Members accountable; confronts performance problems and addresses poor performers.</li>\r\n<li>Is passionate and creatively celebrates successes and supports Team Member recognition/incentive programs.</li>\r\n<li>Reviews Team Member satisfaction results and prepares and follows through on action plans.</li>\r\n<li>Provides a proactive approach to safe work practices and acts to minimize workers&rsquo; compensation claims.</li>\r\n</ul>', 'rating', 1, 0, 'ULEyr7eayRZQTSXS'),
(22, 'e5tNGcK4hmXL8mwi', 1423873647, 1, 'Evironmental Focus', 'Evironmental Focus', '<p>All areas of the kitchen are clean, well maintained, sanitized and guarded against cross-contamination. Kitchen working area is well organized with all items properly labeled and stored in proper areas. Work area is well stocked and shift prep is completed daily. Reviews work area, tools and equipment daily in order to correct hazardous conditions. Needed repairs are identified and work orders are submitted and followed to completion.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(104, 'eFQH89vg1l6gGewL', 1432842340, 1, 'Sales-Driven Environment', 'Sales-Driven Environment', '<ul>\r\n<li>Understands their role in the sales process and assists the Sales Department to expedite contracts, approve direct billing requests, and assemble accurate group bills within 72 hours of departure.</li>\r\n<li>Works with Leaders and Team Members to foster excellent relationships with all areas; operations, sales and Resort General Managers to positively impact resort results.</li>\r\n<li>Champions a sales-driven culture, leads Team Members to focus on assisting all departments on goal attainments, driven to succeed.</li>\r\n<li>Assists all Leaders and Team Members in ensuring the Resort is a place Guests want to be, enjoy being there and are eager to return.</li>\r\n<li>Provides direction and training to sales, operational and administrative teams on financial issues.</li>\r\n<li>Asks vendors and business partners for their business.</li>\r\n<li>Ensures the sales team has fast and efficient access to the network and the needed systems and devices to enable sales presentations.</li>\r\n<li>Quickly turns around requests for trip advances and expense reports.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(27, 'er0bcOW3JoxYs5Ur', 1425673147, 1, 'Personal Development', 'Personal Development', '<p>Passionate. Inquisitive.&nbsp; Has a desire to learn everything there is to know about the resort attributes, experiences and local attractions.&nbsp; Maintains an ongoing dialogue with property leadership to discuss personal development opportunities<br />Knows what he/she is good at and where he/she needs to improve.&nbsp; Works well with leadership to develop a plan that coincides with their aspirations.&nbsp; Dedicated to continuous improvement.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(11, 'eUCdsj6K99MGwbuv', 1411155373, 1, 'Additional Comments', 'We would like to congratulate you on:', '<p>TEXT BOX</p>', 'text', 1, 0, 'IphMs4uKYQz7hwyL'),
(146, 'eWk3glz5Kv2opJiq', 1454004757, 0, 'teste', 'teste', '', 'text', 1, 0, 'NQrXkp5jBhARnraK'),
(65, 'FgpaVrtBJ6xUXcmN', 1425694798, 1, 'Safety Awareness', 'Safety Awareness', '<p>Actively participates in NVHG safety program and works in a safe and ergonomic manner. Operates all equipment in a safe and efficient manner. Is engaged and participates in all safety training. Utilizes all safety equipment provided. Cleans all spills immediately. Is committed to overall safety and attentive to potential hazards. Follows all procedures regarding health department codes, ServeSafe and emergency response procedures. Utilizes micro clean bucket in all appropriate areas at proper pH for utensils and tools. Promptly reports any unsafe conditions.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(92, 'FIHGjAk1velrqWuO', 1425699810, 1, 'Results Comments', 'Results Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(33, 'fMKuAhJMJ0SlVO9C', 1425673383, 1, 'We would like to congratulate you on:', 'We would like to congratulate you on:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(70, 'G8X7ipy6XShhdKaR', 1425694823, 1, 'Uniform, Grooming, and Appearance', 'Uniform, Grooming, and Appearance', '<p>Understands that they are a key part of our guests'' experience. Is always "on" when at work.&nbsp; Always wears appropriate uniform (including appropriate accessories and shoe color) that is well maintained and neatly pressed.&nbsp; Is well groomed and wears their nametag at all times.</p>', 'rating', 1, 1, 'uuuuuuuuuuuuuuud'),
(78, 'gcxG6cXZodJ0rBmW', 1425696103, 1, 'Collaborator', 'Collaborator', '<ul>\r\n<li>Communicates honestly and in a timely manner</li>\r\n<li>Keeps others informed</li>\r\n<li>Works with others to make things better</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(61, 'GMzbuozaIY3R0xAw', 1425694709, 1, 'Results Comments', 'Results Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(52, 'GokkacWAJ93Dq0hF', 1425676800, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates in the development of the Annual Operating Plan (AOP). &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</li>\r\n<li>Actively participates in the monthly forecast of revenues and expenses for area.</li>\r\n<li>Utilizes the 14-Day Forecast, Northview Schedule Optimizer, and Daily Flash to adjust spending and labor, makes contingency plans to meet profit and flow-through expectations&nbsp;</li>\r\n<li>Adheres to NVHG accounting standards as measured by the Controller and internal audit.</li>\r\n<li>Analyzes results, determines key reasons for variances to target, and clearly/professionally communicates reasons both verbally and in written form when required.</li>\r\n<li>Ensures invoices are promptly turned in and properly coded.</li>\r\n<li>Ensures controls are in place and Team Members are held accountable.</li>\r\n<li>Utilizes checkbook accounting.</li>\r\n<li>Stays abreast of industry trends, constantly evaluates business processes and seeks to improve efficiency; dedicated to continuous improvement.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(15, 'gvZnbXeUTBhvDlSH', 1417544181, 1, 'Sales-Driven Environment', 'Sales-Driven Environment', '<ul>\r\n<li>Champions</li>\r\n<li>Manages</li>\r\n<li>Ensures</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(57, 'gXzsidRBadKuJERI', 1425694709, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates in the development of the Annual Operating Plan (AOP). &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</li>\r\n<li>Actively participates in the monthly forecast of revenues and expenses for area.</li>\r\n<li>Utilizes the 14-Day Forecast, Northview Schedule Optimizer, and Daily Flash to adjust spending and labor, makes contingency plans to meet profit and flow-through expectations&nbsp;</li>\r\n<li>Adheres to NVHG accounting standards as measured by the Controller and internal audit.</li>\r\n<li>Analyzes results, determines key reasons for variances to target, and clearly/professionally communicates reasons both verbally and in written form when required.</li>\r\n<li>Ensures invoices are promptly turned in and properly coded.</li>\r\n<li>Ensures controls are in place and Team Members are held accountable.</li>\r\n<li>Utilizes checkbook accounting.</li>\r\n<li>Stays abreast of industry trends, constantly evaluates business processes and seeks to improve efficiency; dedicated to continuous improvement.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(96, 'gYFp2LndIy5Traxm', 1430241795, 1, 'True North Objectives', 'True North Objectives', '<p>Quality of Planning and Choosing the Right Priorities, Proactive</p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(90, 'GZAvdoGFTGWAysVS', 1425699810, 1, 'Team Leadership', 'Team Leadership', '<ul>\r\n<li>Leads by example (words and actions match.)</li>\r\n<li>Builds the best team by being personally involved in the hiring process, utilizing NVHG&rsquo;s behavioral interviewing tools, and being an employer-of-choice.&nbsp;</li>\r\n<li>Shows sincere care for Team Members as our most valuable resource and helps people reach their full potential.</li>\r\n<li>Ensures department orientation, daily line-ups and monthly department meetings are conducted.</li>\r\n<li>Ensures the performance review process provides supportive guidance in an environment that enables personal growth, mutual trust and integrity. &nbsp;Sets appropriate development goals, communicates them and follows up on plans.</li>\r\n<li>Adheres to all human resources policies and procedures and holds Team Members accountable; confronts performance problems and addresses poor performers.</li>\r\n<li>Is passionate and creatively celebrates successes and supports Team Member recognition/incentive programs.</li>\r\n<li>Reviews Team Member satisfaction results and prepares and follows through on action plans.</li>\r\n<li>Provides a proactive approach to safe work practices and acts to minimize workers&rsquo; compensation claims.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(122, 'H3CR1gSaDIAbQF0J', 1432843142, 1, 'Professional', 'Professional', '<ul>\r\n<li>Appears, acts and communicates as a steward of our culture and our Company</li>\r\n<li>Practices excellent written and verbal communication skills</li>\r\n<li>Keeps internal business confidential</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(118, 'HJl7CSbp2z5EZB3q', 1432843142, 1, 'Listens', 'Listens', '<ul>\r\n<li>Is an attentive listener, values input from others and seeks to understand</li>\r\n<li>Waits for others to finish speaking before talking</li>\r\n<li>Seeks and acts on feedback</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(119, 'hsb8ESwQdc9x8So7', 1432843142, 1, 'Respectful', 'Respectful', '<ul>\r\n<li>Treats others with dignity and acts with gratitude and demonstrates humility</li>\r\n<li>Values diversity and individuality</li>\r\n<li>Always gives others the benefit of the doubt</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(109, 'iNMDj9UPf3WcsALr', 1432842340, 1, 'Results Comments', 'Results Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(53, 'IP8lyuWagGxB0A5r', 1425676800, 1, 'Guest Service', 'Guest Service', '<ul>\r\n<li>Drives customer service and culture, and ensures it is systemic in the Resort; checks and inspects against established standards.</li>\r\n<li>Ensures all Team Members &nbsp;greet all Guests.</li>\r\n<li>Is engaged daily in guest service. &nbsp;Uses the Northview Schedule Optimizer; makes needed&nbsp;</li>\r\n<li>adjustments to always make sure the right people are in the right place at the right time.</li>\r\n<li>Trains Team Members according to the Resort&rsquo;s Performance Standards, models the way, and uses role playing to demonstrate and develop proper guest service behaviors.</li>\r\n<li>Always aware of the department and Resort&rsquo;s top guest dissatisfiers (e.g., the Dirty Dozen), develops plans to improve performance, and ensures staff is trained to manage chronic issues.</li>\r\n<li>Ensures service scores and goals are posted and reviewed during department meetings.</li>\r\n<li>Nurtures relationships with prospective and existing customers.</li>\r\n<li>Meets NVHG and Brand quality assurance expectations.</li>\r\n<li>Ensures telephones and radios do not interfere with face-to-face guest interactions.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(94, 'IvMAibwRQz6OSs0O', 1429551446, 1, 'Test 2', 'Test 2', '<p>Test Type</p>', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(120, 'j1NfkU5F34RtXR6i', 1432843142, 1, 'Collaborator', 'Collaborator', '<ul>\r\n<li>Communicates honestly and in a timely manner</li>\r\n<li>Keeps others informed</li>\r\n<li>Works with others to make things better</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(91, 'J52isdNvUAGlraGo', 1425699810, 1, 'Environmental Awareness', 'Environmental Awareness', '<ul>\r\n<li>Ensures that the Resort&rsquo;s arrival experience sets the tone for outstanding guest experiences.</li>\r\n<li>Ensures outlets, meeting facilities, heart of the house, equipment and storerooms are clean, organized and well-maintained.</li>\r\n<li>Establishes standards and holds Team Members accountable for appropriate ambiance, music, aromas and lighting conditions.</li>\r\n<li>Ensures regular area tours are conducted to assure high standards and trains others to do the same.&nbsp;</li>\r\n<li>Schedules disruptive maintenance tasks at the proper time to minimize guest inconvenience.</li>\r\n<li>Maintains a quiet environment for guests by requiring headsets for radio communications in guest areas.</li>\r\n<li>Works with Resort leadership to establish and execute an effective &ldquo;Green&rdquo; strategy.&nbsp;</li>\r\n<li>Facilitates capital projects and makes capital investment recommendations.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(3, 'jR8Bx05TQ8yq8tCd', 1398801362, 1, 'Personal', 'Personal', '<p><span style="text-align: justify; text-indent: -0.25in; font-size: 9pt; font-family: Arial, sans-serif;">Arrives at work when scheduled. &nbsp;Accurately keeps track of hours worked through the timekeeping system. Is reliable and dependable. &nbsp;Demonstrates a strong commitment to the job and the Resort is a high priority in their life. &nbsp;Shows concern when objectives are not met. &nbsp;Maintains high standards. &nbsp;Speaks well of the Resort to friends and co-workers and shares concerns directly with leadership and refrains from complaining to co-workers.&nbsp; Follows the rules, uses good judgment, and does things the best way.</span></p>\r\n<p class="MsoListParagraph" style="mso-add-space: auto; text-align: justify; text-indent: -.25in; mso-list: l0 level1 lfo1; margin: 6.0pt 4.3pt 6.0pt 74.75pt;">&nbsp;</p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(25, 'jrallvmQgSPGIzc7', 1425673147, 1, 'Uniform, Grooming, and Appearance', 'Uniform, Grooming, and Appearance', '<p>Understands that they are a key part of our guests'' experience. Is always "on" when at work.&nbsp; Always wears appropriate uniform (including appropriate accessories and shoe color) that is well maintained and neatly pressed.&nbsp; Is well groomed and wears their nametag at all times.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(2, 'jy1bV9kj6ISGHIqL', 1398801053, 1, 'Interpersonal', 'Interpersonal', '<p><span style="font-size: 9.0pt; font-family: ''Arial'',''sans-serif''; mso-fareast-font-family: ''Times New Roman''; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">Team player.&nbsp; Always willing to help.&nbsp; A great listener and waits for people to finish speaking before speaking.&nbsp; Keeps co-workers and leadership informed and works to make things better.&nbsp; Adapts to last minute changes and always works to ensure our guests are well taken care of.&nbsp; Understands their line of sight to the customer and knows that if they are not serving a guest they are serving someone who is.&nbsp; Treats fellow Associates with dignity and acts with gratitude and humility.</span></p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(8, 'JyBbJD0A4wnFWLrV', 1411155116, 1, 'Sales-Driven Environment', 'Sales-Driven Environment', '<ul>\r\n<li>Champions</li>\r\n<li>Manages</li>\r\n<li>Ensures</li>\r\n</ul>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(16, 'K11er7NneYfHFggB', 1417544181, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates</li>\r\n<li>Actively</li>\r\n<li>Utilizes</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(142, 'kIP9sWT8718lQtyq', 1454002955, 1, 'Guest Service', 'Guest Service', '<ul>\r\n<li>Drives customer service and culture, and ensures it is systemic in the Resort; checks and inspects against established standards.</li>\r\n<li>Ensures all Team Members &nbsp;greet all Guests.</li>\r\n<li>Is engaged daily in guest service. &nbsp;Uses the Northview Schedule Optimizer; makes needed&nbsp;</li>\r\n<li>adjustments to always make sure the right people are in the right place at the right time.</li>\r\n<li>Trains Team Members according to the Resort&rsquo;s Performance Standards, models the way, and uses role playing to demonstrate and develop proper guest service behaviors.</li>\r\n<li>Always aware of the department and Resort&rsquo;s top guest dissatisfiers (e.g., the Dirty Dozen), develops plans to improve performance, and ensures staff is trained to manage chronic issues.</li>\r\n<li>Ensures service scores and goals are posted and reviewed during department meetings.</li>\r\n<li>Nurtures relationships with prospective and existing customers.</li>\r\n<li>Meets NVHG and Brand quality assurance expectations.</li>\r\n<li>Ensures telephones and radios do not interfere with face-to-face guest interactions.</li>\r\n</ul>', 'rating', 1, 0, 'ULEyr7eayRZQTSXS'),
(20, 'kKpGWn43syp941oY', 1423873647, 1, 'Technical Skill', 'Technical Skill', '<p>Excellent knowledge of basic cooking skills, menu, menu ingredients, kitchen equipment, tools, sanitation requirements and plate presentation. Uses NVHG&rsquo;s F&amp;B tools including shift checklists, requisitions, portion control systems and recipe cards. Cooperates with others and other departments so that the operation runs smoothly. Demonstrates culinary creativity. Displays competency in areas in which training has taken place. Uses proper cleaning techniques and demonstrates proper care of equipment. Handles daily workload with minimum supervision. Uses appropriate equipment with appropriate task. Secures and locks up high value items, food, and tools.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(77, 'KopsM1x4dqFSbp5E', 1425696103, 1, 'Respectful', 'Respectful', '<ul>\r\n<li>Treats others with dignity and acts with gratitude and demonstrates humility</li>\r\n<li>Values diversity and individuality</li>\r\n<li>Always gives others the benefit of the doubt</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(45, 'lKAu6IVef6GxRijA', 1425674017, 1, 'Manager’s Results Comments ', 'Manager’s Results Comments ', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(139, 'Lp8MBNd2u2bhuHo8', 1432843222, 1, 'Team Member Comments', 'Team Member Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(112, 'LPMfR6QdXhf0juRI', 1432842389, 1, 'Guest Service', 'Guest Service', '<ul>\r\n<li>Helps ensure that key technology systems (e.g., property management system, key encoders, credit authorization, printers, wi-fi) are up-to-date and support customer service that is focused on the Guest and not on the technology.</li>\r\n<li>Ensures strong vendor relations through timely A/P payments, responding to vendor inquiries, and reviewing monthly statements to keep accounts current.</li>\r\n<li>Always aware of the department and Resort&rsquo;s top Guest dissatisfiers (e.g., the Dirty Dozen), develops plans to improve performance, and insures staff is trained to manage chronic issues.</li>\r\n<li>Ensures all Team Members greet Guests and fellow Team Members.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(75, 'LQ3kdjqEpVjdDdCg', 1425696102, 1, 'Passionate', 'Passionate', '<ul>\r\n<li>Is a source of positive energy and inspires excellence</li>\r\n<li>Leads by example, shares the vision and walks the talk</li>\r\n<li>Always eager to learn and grow</li>\r\n<li>Actively works to develop others</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(42, 'lQloxZPrXDsy9YLS', 1425673496, 1, 'Associate Comments:', 'Associate Comments:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(13, 'lzaL2CtbwBg12WpW', 1411156340, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates</li>\r\n<li>Actively</li>\r\n<li>Utilizes</li>\r\n</ul>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(62, 'M1iwBRSzdoMPUzVU', 1425694798, 1, 'Service Delivery', 'Service Delivery', '<p><span style="font-size: 9.0pt; font-family: ''Arial'',''sans-serif''; mso-fareast-font-family: ''Times New Roman''; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">Demonstrates active and engaged service behaviors and attitudes, professional body language and appearance; greets all Associates.&nbsp; Consistently meets or exceeds established culinary standards for food preparation, sanitation, and ware washing.&nbsp; Adjusts and prioritizes work flow to accommodate business needs.&nbsp; Takes pride and ownership in all tasks.&nbsp; Provides service by anticipating, asking and acting.&nbsp; Effective team player by building internal Associate relations.&nbsp; Supports and responds to the server to ensure guest satisfaction and understands the &ldquo;line of sight to the customer&rdquo;.</span></p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(107, 'mKYngkEgpPQxtHX8', 1432842340, 1, 'Team Leadership', 'Team Leadership', '<ul>\r\n<li>Accurately processes Team Members&rsquo; daily work hours, bi-weekly payroll, gratuities and incentive plans.</li>\r\n<li>Leads by example (words and actions match.)</li>\r\n<li>Builds the best team by being personally involved in the hiring process, utilizing NVHG&rsquo;s behavioral interviewing tools, and being an employer of choice. &nbsp;</li>\r\n<li>Confronts performance problems; addresses poor performers.&nbsp;</li>\r\n<li>Ensures the performance review process provides supportive guidance in an environment that enables personal growth, mutual trust and integrity. &nbsp;Sets appropriate development goals, communicates them and reconciles plans.</li>\r\n<li>Adheres to all human resources policies and procedures and holds Team Members accountable.</li>\r\n<li>Is passionate and creatively celebrates successes and supports team recognition and incentive programs.</li>\r\n<li>Reviews Team Member satisfaction results and prepare and follows through on action plans.</li>\r\n<li>Provides a proactive approach to safe work practices and acts to minimize workers&rsquo; compensation losses.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(113, 'mrtSviGDHYCvqlXY', 1432842389, 1, 'Team Leadership', 'Team Leadership', '<ul>\r\n<li>Accurately processes Team Members&rsquo; daily work hours, bi-weekly payroll, gratuities and incentive plans.</li>\r\n<li>Leads by example (words and actions match.)</li>\r\n<li>Builds the best team by being personally involved in the hiring process, utilizing NVHG&rsquo;s behavioral interviewing tools, and being an employer of choice. &nbsp;</li>\r\n<li>Confronts performance problems; addresses poor performers.&nbsp;</li>\r\n<li>Ensures the performance review process provides supportive guidance in an environment that enables personal growth, mutual trust and integrity. &nbsp;Sets appropriate development goals, communicates them and reconciles plans.</li>\r\n<li>Adheres to all human resources policies and procedures and holds Team Members accountable.</li>\r\n<li>Is passionate and creatively celebrates successes and supports team recognition and incentive programs.</li>\r\n<li>Reviews Team Member satisfaction results and prepare and follows through on action plans.</li>\r\n<li>Provides a proactive approach to safe work practices and acts to minimize workers&rsquo; compensation losses.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(99, 'muLkIQnOB28ZqXu9', 1432842054, 1, 'Quality', 'Quality', '<p>&nbsp;</p>\r\n<p style="margin-bottom: 0cm; line-height: 115%;">Quality of Planning and Choosing the Right Priorities, Proactive</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(17, 'n2ceeauiuNVjBpzB', 1423765794, 1, 'RESULTS', 'Service Delivery', '<p><span style="font-size: 9.0pt; font-family: ''Arial'',''sans-serif''; mso-fareast-font-family: ''Times New Roman''; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">Demonstrates active and engaged service behaviors and attitudes, professional body language and appearance; greets all Associates.&nbsp; Consistently meets or exceeds established culinary standards for food preparation, sanitation, and ware washing.&nbsp; Adjusts and prioritizes work flow to accommodate business needs.&nbsp; Takes pride and ownership in all tasks.&nbsp; Provides service by anticipating, asking and acting.&nbsp; Effective team player by building internal Associate relations.&nbsp; Supports and responds to the server to ensure guest satisfaction and understands the &ldquo;line of sight to the customer&rdquo;.</span></p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(145, 'ND7VJMPUgcM5AAXW', 1454002955, 1, 'Results Comments', 'Results Comments', '', 'text', 1, 0, 'ULEyr7eayRZQTSXS'),
(85, 'NEytAQ9ugDjWlZ8T', 1425696201, 1, 'What we can do to help:', 'What we can do to help:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(32, 'Nho7yCjRv1s3btWK', 1425673170, 1, 'Personal Development', 'Personal Development', '<p>Passionate. Inquisitive.&nbsp; Has a desire to learn everything there is to know about the resort attributes, experiences and local attractions.&nbsp; Maintains an ongoing dialogue with property leadership to discuss personal development opportunities<br />Knows what he/she is good at and where he/she needs to improve.&nbsp; Works well with leadership to develop a plan that coincides with their aspirations.&nbsp; Dedicated to continuous improvement.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(98, 'NwTCCINrxto8jplb', 1430326774, 1, 'Quality of Planning and Choosing the Right Priorities, Proactive', 'Quality of Planning and Choosing the Right Priorities, Proactive                                                                             ', '', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(83, 'NZkL8qXRDNKKiSU4', 1425696201, 1, 'What we would like to congratulate you on:', 'What we would like to congratulate you on:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(76, 'O95REb5EqKLzfsMt', 1425696103, 1, 'Listens', 'Listens', '<ul>\r\n<li>Is an attentive listener, values input from others and seeks to understand</li>\r\n<li>Waits for others to finish speaking before talking</li>\r\n<li>Seeks and acts on feedback</li>\r\n</ul>', '', 1, 0, 'uuuuuuuuuuuuuuud'),
(147, 'obC23qsqjB6Mecuo', 1454004757, 0, 'test', 'test', '', 'rating', 1, 0, 'NQrXkp5jBhARnraK'),
(12, 'OdfQrW31aCEaMOSj', 1411156339, 1, 'Sales-Driven Environment', 'Sales-Driven Environment', '<ul>\r\n<li>Champions</li>\r\n<li>Manages</li>\r\n<li>Ensures</li>\r\n</ul>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(106, 'OH6h77Mfbx15ydYK', 1432842340, 1, 'Guest Service', 'Guest Service', '<ul>\r\n<li>Helps ensure that key technology systems (e.g., property management system, key encoders, credit authorization, printers, wi-fi) are up-to-date and support customer service that is focused on the Guest and not on the technology.</li>\r\n<li>Ensures strong vendor relations through timely A/P payments, responding to vendor inquiries, and reviewing monthly statements to keep accounts current.</li>\r\n<li>Always aware of the department and Resort&rsquo;s top Guest dissatisfiers (e.g., the Dirty Dozen), develops plans to improve performance, and insures staff is trained to manage chronic issues.</li>\r\n<li>Ensures all Team Members greet Guests and fellow Team Members.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(140, 'oHzd0Ey2m3dYg0Ny', 1454002955, 1, 'Sales-Driven Environment ', 'Sales-Driven Environment ', '<ul>\r\n<li>Champions a sale-driven culture, leads team to focus on goal attainment, driven to succeed.</li>\r\n<li>Manages and communicates sales/revenue goals to team using information from financials, sales, marketing and NVHG operating plans.</li>\r\n<li>Ensures the Resort is a place guests want to be, enjoy being there and are eager to return.</li>\r\n<li>Supports the sales/catering organization, responds quickly to planning questions, and communicates group needs. &nbsp;Ensures Team Members understand all aspects of the sales process.</li>\r\n<li>Manages and works with sales/catering teams to execute contractual obligations.</li>\r\n<li>Provides ongoing opportunities for sales training</li>\r\n<li>Develops innovative sales strategies, forecasts and budgets, annually and monthly. &nbsp;&nbsp;</li>\r\n<li>Weighs the value of each piece of business against Resort and NVHG objectives.</li>\r\n</ul>', 'rating', 1, 0, 'ULEyr7eayRZQTSXS'),
(114, 'OmgOIai3w2hJz88D', 1432842389, 1, 'Environmental Awareness', 'Environmental Awareness', '<ul>\r\n<li>Ensures that the Resort&rsquo;s arrival experience sets the tone for outstanding guest experiences.</li>\r\n<li>Ensures heart of the house, equipment and storerooms are clean, organized and well-maintained.</li>\r\n<li>Establishes standards and holds Team Members accountable for appropriate ambiance, music, aromas and lighting conditions.</li>\r\n<li>Ensures regular area tours are conducted to assure high standards and trains others to do the same.&nbsp;</li>\r\n<li>Maintains a quiet environment for Guests by requiring headsets for radio communications in public areas.</li>\r\n<li>Supports the Resort&rsquo;s Green Initiatives.</li>\r\n<li>Properly accounts for capital and maintenance projects; assists with the development of the annual and five year capital plans.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(117, 'OMrxfqLd0amS2VUR', 1432843142, 1, 'Passionate', 'Passionate', '<ul>\r\n<li>Is a source of positive energy and inspires excellence</li>\r\n<li>Leads by example, shares the vision and walks the talk</li>\r\n<li>Always eager to learn and grow</li>\r\n<li>Actively works to develop others</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(101, 'ONUbE6saA9F6m4Qf', 1432842054, 1, 'Results', 'Results', '<p>&nbsp;</p>\r\n<p style="margin-bottom: 0cm; line-height: 115%;">Getting the Right Things Accomplished</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(69, 'oPTrxzX4JyPtrGzx', 1425694823, 1, 'Interpersonal', 'Interpersonal', '<p>Team player.&nbsp; Always willing to help.&nbsp; A great listener and waits for people to finish speaking before speaking.&nbsp; Keeps co-workers and leadership informed and works to make things better.&nbsp; Adapts to last minute changes and always works to ensure our guests are well taken care of.&nbsp; Understands their line of sight to the customer and knows that if they are not serving a guest they are serving someone who is.&nbsp; Treats fellow Associates with dignity and acts with gratitude and humility.</p>', 'rating', 1, 1, 'uuuuuuuuuuuuuuud'),
(21, 'OQ5r21Zk3SKXly3H', 1423873647, 1, 'Safety Awareness', 'Safety Awareness', '<p>Actively participates in NVHG safety program and works in a safe and ergonomic manner. Operates all equipment in a safe and efficient manner. Is engaged and participates in all safety training. Utilizes all safety equipment provided. Cleans all spills immediately. Is committed to overall safety and attentive to potential hazards. Follows all procedures regarding health department codes, ServeSafe and emergency response procedures. Utilizes micro clean bucket in all appropriate areas at proper pH for utensils and tools. Promptly reports any unsafe conditions.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(56, 'oytBlsOts63RCVpp', 1425694709, 1, 'Sales-Driven Environment ', 'Sales-Driven Environment ', '<ul>\r\n<li>Champions a sale-driven culture, leads team to focus on goal attainment, driven to succeed.</li>\r\n<li>Manages and communicates sales/revenue goals to team using information from financials, sales, marketing and NVHG operating plans.</li>\r\n<li>Ensures the Resort is a place guests want to be, enjoy being there and are eager to return.</li>\r\n<li>Supports the sales/catering organization, responds quickly to planning questions, and communicates group needs. &nbsp;Ensures Team Members understand all aspects of the sales process.</li>\r\n<li>Manages and works with sales/catering teams to execute contractual obligations.</li>\r\n<li>Provides ongoing opportunities for sales training</li>\r\n<li>Develops innovative sales strategies, forecasts and budgets, annually and monthly. &nbsp;&nbsp;</li>\r\n<li>Weighs the value of each piece of business against Resort and NVHG objectives.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud');
INSERT INTO `tnng_Field` (`aid`, `id`, `created`, `status`, `name`, `title`, `description`, `type`, `active`, `locked`, `cid`) VALUES
(115, 'pCK4pvzYsEFkXa7d', 1432842389, 1, 'Results Comments', 'Results Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(63, 'pDdQWSfGbDxp9zMU', 1425694798, 1, 'Responsiveness', 'Responsiveness', '<p>Demonstrates a sense of urgency and responds in a timely manner. Cooperates and fulfills special requests respectfully. &nbsp;Maintains high energy, positive attitude with the guest always in mind. Owns the request or complaint until it is resolved and guest&rsquo;s satisfaction is confirmed. Completes tasks with speed and efficiency. Demonstrates resourcefulness and a respectful attitude. Works proactively and anticipates what needs to be done by watching for cues, listening thoroughly and acting before being asked. Accommodates guest requests that occur just prior to opening and just after closing.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(111, 'PfQuLiN0QJPPrZtp', 1432842389, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Leads ongoing financial optimization utilizing the 14-Day Forecast, Northview Schedule Optimizer, and Daily Flash reports to train and guide department managers regarding spending and labor, assists in contingency planning to meet profit and flow-through expectations.</li>\r\n<li>Completes daily income and payroll audit; works to establish the Daily Revenue Flash and Daily Labor Flash as accurate and effective tools in managing the business.</li>\r\n<li>Partners with General Manager to complete the Annual Operating Plan (AOP) and presenting annual financial goals to the leadership team. Prepares assumptions and goals for controllable expenses, labor expenses by position, and all revenue departments.</li>\r\n<li>Manages the monthly forecasting process working with sales and revenue management to produce top line revenue and works with property leadership to accurately forecast profit within +/- 5%.</li>\r\n<li>Prepares month-end financial statements for all business units. Conducts monthly P&amp;L reviews in a constructive, educational manner. &nbsp;</li>\r\n<li>Analyzes results, determines key reasons for variances to target, and clearly/professionally communicates reasons both verbally and in written form when required. &nbsp;</li>\r\n<li>Regularly reviews Accounts Receivable ledger to ensure proper collection efforts; conducts monthly meeting with General Manager.</li>\r\n<li>Establishes and maintains an approval based purchasing process, ensures all products are received and stored in accordance with standards; ensures invoices are promptly turned in and properly coded. &nbsp;Has a history of solid food, beverage, and retail cost performance.</li>\r\n<li>Ensures controls are in place and Team Members are held accountable.</li>\r\n<li>Educates property leaders to take full advantage of RealView and ancillary systems (e.g., Kronos, DataVision) Maintains checkbook accounting system for all departments to determine purchase approvals and manage spending limits.</li>\r\n<li>Plans and implements all accounting procedures and systems for the Resort; ensuring adherence to NVHG accounting standards, GAAP, and the Uniform System of Accounts for the Hospitality Industry.</li>\r\n<li>Stays abreast of industry trends, constantly evaluates business processes and seeks to improve efficiency, dedicated to continuous improvement.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(6, 'pJm1cybQkNjjFQwM', 1411155084, 1, 'Sales-Driven Environment', 'Sales-Driven Environment', '<ul>\r\n<li>Champions</li>\r\n<li>Manages</li>\r\n<li>Ensures</li>\r\n</ul>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(73, 'pkDjmdOGVV7Ff3pI', 1425694823, 1, 'Manager''s Comments', 'Manager''s Comments', '', 'text', 1, 1, 'uuuuuuuuuuuuuuud'),
(24, 'PlCIMwlhhHP5EecF', 1425673146, 1, 'Interpersonal', 'Interpersonal', '<p>Team player.&nbsp; Always willing to help.&nbsp; A great listener and waits for people to finish speaking before speaking.&nbsp; Keeps co-workers and leadership informed and works to make things better.&nbsp; Adapts to last minute changes and always works to ensure our guests are well taken care of.&nbsp; Understands their line of sight to the customer and knows that if they are not serving a guest they are serving someone who is.&nbsp; Treats fellow Associates with dignity and acts with gratitude and humility.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(26, 'pMeNcV4PnKearuo5', 1425673147, 1, 'Contributor', 'Contributor', '<p>Actively participates in departmental meetings, pre-shifts, daily line-ups and planning sessions.&nbsp; Advises leadership of ongoing and chronic issues (e.g., supplies, maintenance, equipment, process, systems, and quality).&nbsp; Always accompanies concerns with suggested solutions.</p>', '', 1, 0, 'uuuuuuuuuuuuuuud'),
(103, 'pmPAJDIi1er0cgCS', 1432842054, 1, 'True North Comments', 'True North Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(97, 'qj0BbcwJDYf7WpYL', 1430241930, 1, 'True North Objectives', 'True North Objectives', '<p>Quality of Planning and Choosing the Right Priorities, Proactive</p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(34, 'QnIDJVZdEq4jgpOP', 1425673407, 1, 'We would like to congratulate you on:', 'We would like to congratulate you on:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(41, 'qrAdjOgaP5UN1sMu', 1425673496, 1, 'What can we do to help?', 'What can we do to help?', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(133, 'QVvlMKkdC7dFhCS3', 1432843156, 1, 'Proactive', 'Proactive', '<ul>\r\n<li>Is well-organized and an effective manager of time</li>\r\n<li>Successfully balances career and personal life</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(110, 'r6DI8iWMWqWZx6dJ', 1432842389, 1, 'Sales-Driven Environment', 'Sales-Driven Environment', '<ul>\r\n<li>Understands their role in the sales process and assists the Sales Department to expedite contracts, approve direct billing requests, and assemble accurate group bills within 72 hours of departure.</li>\r\n<li>Works with Leaders and Team Members to foster excellent relationships with all areas; operations, sales and Resort General Managers to positively impact resort results.</li>\r\n<li>Champions a sales-driven culture, leads Team Members to focus on assisting all departments on goal attainments, driven to succeed.</li>\r\n<li>Assists all Leaders and Team Members in ensuring the Resort is a place Guests want to be, enjoy being there and are eager to return.</li>\r\n<li>Provides direction and training to sales, operational and administrative teams on financial issues.</li>\r\n<li>Asks vendors and business partners for their business.</li>\r\n<li>Ensures the sales team has fast and efficient access to the network and the needed systems and devices to enable sales presentations.</li>\r\n<li>Quickly turns around requests for trip advances and expense reports.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(36, 'RAjv0hFMhMyhJQaU', 1425673473, 1, 'We would like to congratulate you on:', 'We would like to congratulate you on:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(102, 'ratM6s1pK3KM6h1X', 1432842054, 1, 'Leading', 'Leading', '<p>&nbsp;</p>\r\n<p style="margin-bottom: 0cm; line-height: 115%;">Using True North Objectives to Effectively Lead Your Team</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(81, 'RhUItGZWvuB2gfRt', 1425696103, 1, 'Proactive', 'Proactive', '<ul>\r\n<li>Is well-organized and an effective manager of time</li>\r\n<li>Successfully balances career and personal life</li>\r\n</ul>', '', 1, 0, 'uuuuuuuuuuuuuuud'),
(82, 'RIFT7TtaGpelPeG8', 1425696103, 1, 'Planning', 'Planning', '<ul>\r\n<li>Works together on shared mission and vision to meet overall goals</li>\r\n<li>Strategizes, plans and set goals, gaining a competitive advantage</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(87, 'RVYVaMXJVz8YerWw', 1425699810, 1, 'Sales-Driven Environment ', 'Sales-Driven Environment ', '<ul>\r\n<li>Champions a sale-driven culture, leads team to focus on goal attainment, driven to succeed.</li>\r\n<li>Manages and communicates sales/revenue goals to team using information from financials, sales, marketing and NVHG operating plans.</li>\r\n<li>Ensures the Resort is a place guests want to be, enjoy being there and are eager to return.</li>\r\n<li>Supports the sales/catering organization, responds quickly to planning questions, and communicates group needs. &nbsp;Ensures Team Members understand all aspects of the sales process.</li>\r\n<li>Manages and works with sales/catering teams to execute contractual obligations.</li>\r\n<li>Provides ongoing opportunities for sales training</li>\r\n<li>Develops innovative sales strategies, forecasts and budgets, annually and monthly. &nbsp;&nbsp;</li>\r\n<li>Weighs the value of each piece of business against Resort and NVHG objectives.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(40, 'rzzTUdOm2PX9Ik95', 1425673496, 1, 'We would like you to focus on next year:', 'We would like you to focus on next year:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(74, 'Se20ApfxjAFEvqI4', 1425696102, 1, 'Integrity', 'Integrityx', '<ul>\r\n<li>Keeps commitments and actions always follow words</li>\r\n<li>Decisions are based on the overall best interest of Guests, Team Members and the Company</li>\r\n<li>Communicates in an honest, respectful, direct and professional manner</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(66, 'SMY6AlUBRZYoHYBn', 1425694798, 1, 'Evironmental Focus', 'Evironmental Focus', '<p>All areas of the kitchen are clean, well maintained, sanitized and guarded against cross-contamination. Kitchen working area is well organized with all items properly labeled and stored in proper areas. Work area is well stocked and shift prep is completed daily. Reviews work area, tools and equipment daily in order to correct hazardous conditions. Needed repairs are identified and work orders are submitted and followed to completion.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(23, 'szbmt1RtQySIE8ch', 1425673146, 1, 'Personal', 'Personal', '<p>Arrives at work when scheduled.&nbsp; Accurately keeps track of hours worked through the timekeeping system. Is reliable and dependable.&nbsp; Demonstrates a strong commitment to the job and the Resort is a high priority in their life.&nbsp; Shows concern when objectives are not met.&nbsp; Maintains high standards.&nbsp; Speaks well of the Resort to friends and co-workers and shares concerns directly with leadership and refrains from complaining to co-workers.&nbsp; Follows the rules, uses good judgment, and does things the best way.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(58, 't8beEpzd2hRF5blz', 1425694709, 1, 'Guest Service', 'Guest Service', '<ul>\r\n<li>Drives customer service and culture, and ensures it is systemic in the Resort; checks and inspects against established standards.</li>\r\n<li>Ensures all Team Members &nbsp;greet all Guests.</li>\r\n<li>Is engaged daily in guest service. &nbsp;Uses the Northview Schedule Optimizer; makes needed&nbsp;</li>\r\n<li>adjustments to always make sure the right people are in the right place at the right time.</li>\r\n<li>Trains Team Members according to the Resort&rsquo;s Performance Standards, models the way, and uses role playing to demonstrate and develop proper guest service behaviors.</li>\r\n<li>Always aware of the department and Resort&rsquo;s top guest dissatisfiers (e.g., the Dirty Dozen), develops plans to improve performance, and ensures staff is trained to manage chronic issues.</li>\r\n<li>Ensures service scores and goals are posted and reviewed during department meetings.</li>\r\n<li>Nurtures relationships with prospective and existing customers.</li>\r\n<li>Meets NVHG and Brand quality assurance expectations.</li>\r\n<li>Ensures telephones and radios do not interfere with face-to-face guest interactions.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(79, 'TJaHqwpOrqzT4bil', 1425696103, 1, 'Accountable', 'Accountable', '<ul>\r\n<li>Is responsive</li>\r\n<li>Is goal-oriented and knows what is expected of him/her</li>\r\n<li>Practices excellent problem-solving and decision-making skills</li>\r\n</ul>', '', 1, 0, 'uuuuuuuuuuuuuuud'),
(59, 'tJq3xp2PPBEdWyxA', 1425694709, 1, 'Team Leadership', 'Team Leadership', '<ul>\r\n<li>Leads by example (words and actions match.)</li>\r\n<li>Builds the best team by being personally involved in the hiring process, utilizing NVHG&rsquo;s behavioral interviewing tools, and being an employer-of-choice.&nbsp;</li>\r\n<li>Shows sincere care for Team Members as our most valuable resource and helps people reach their full potential.</li>\r\n<li>Ensures department orientation, daily line-ups and monthly department meetings are conducted.</li>\r\n<li>Ensures the performance review process provides supportive guidance in an environment that enables personal growth, mutual trust and integrity. &nbsp;Sets appropriate development goals, communicates them and follows up on plans.</li>\r\n<li>Adheres to all human resources policies and procedures and holds Team Members accountable; confronts performance problems and addresses poor performers.</li>\r\n<li>Is passionate and creatively celebrates successes and supports Team Member recognition/incentive programs.</li>\r\n<li>Reviews Team Member satisfaction results and prepares and follows through on action plans.</li>\r\n<li>Provides a proactive approach to safe work practices and acts to minimize workers&rsquo; compensation claims.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(54, 'Tsr3UyPflAdJ4STM', 1425676800, 1, 'Team Leadership', 'Team Leadership', '<ul>\r\n<li>Leads by example (words and actions match.)</li>\r\n<li>Builds the best team by being personally involved in the hiring process, utilizing NVHG&rsquo;s behavioral interviewing tools, and being an employer-of-choice.&nbsp;</li>\r\n<li>Shows sincere care for Team Members as our most valuable resource and helps people reach their full potential.</li>\r\n<li>Ensures department orientation, daily line-ups and monthly department meetings are conducted.</li>\r\n<li>Ensures the performance review process provides supportive guidance in an environment that enables personal growth, mutual trust and integrity. &nbsp;Sets appropriate development goals, communicates them and follows up on plans.</li>\r\n<li>Adheres to all human resources policies and procedures and holds Team Members accountable; confronts performance problems and addresses poor performers.</li>\r\n<li>Is passionate and creatively celebrates successes and supports Team Member recognition/incentive programs.</li>\r\n<li>Reviews Team Member satisfaction results and prepares and follows through on action plans.</li>\r\n<li>Provides a proactive approach to safe work practices and acts to minimize workers&rsquo; compensation claims.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(19, 'ucrd4YDERZBawzln', 1423873647, 1, 'Responsiveness', 'Responsiveness', '<p>Demonstrates a sense of urgency and responds in a timely manner. Cooperates and fulfills special requests respectfully. &nbsp;Maintains high energy, positive attitude with the guest always in mind. Owns the request or complaint until it is resolved and guest&rsquo;s satisfaction is confirmed. Completes tasks with speed and efficiency. Demonstrates resourcefulness and a respectful attitude. Works proactively and anticipates what needs to be done by watching for cues, listening thoroughly and acting before being asked. Accommodates guest requests that occur just prior to opening and just after closing.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(55, 'Uhj1Y9qSxvVKrmqB', 1425676800, 1, 'Environmental Awareness', 'Environmental Awareness', '<ul>\r\n<li>Ensures that the Resort&rsquo;s arrival experience sets the tone for outstanding guest experiences.</li>\r\n<li>Ensures outlets, meeting facilities, heart of the house, equipment and storerooms are clean, organized and well-maintained.</li>\r\n<li>Establishes standards and holds Team Members accountable for appropriate ambiance, music, aromas and lighting conditions.</li>\r\n<li>Ensures regular area tours are conducted to assure high standards and trains others to do the same.&nbsp;</li>\r\n<li>Schedules disruptive maintenance tasks at the proper time to minimize guest inconvenience.</li>\r\n<li>Maintains a quiet environment for guests by requiring headsets for radio communications in guest areas.</li>\r\n<li>Works with Resort leadership to establish and execute an effective &ldquo;Green&rdquo; strategy.&nbsp;</li>\r\n<li>Facilitates capital projects and makes capital investment recommendations.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(7, 'umkILPl1UAtqpNdp', 1411155084, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates</li>\r\n<li>Actively</li>\r\n<li>Utilizes</li>\r\n</ul>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(100, 'umuRazGkiGp4LJGO', 1432842054, 1, 'Process', 'Process', '<p>&nbsp;</p>\r\n<p style="margin-bottom: 0cm; line-height: 115%;">Integrating the Process into Your Schedule</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(4, 'UWtB7EZqvQGI4ahx', 1398801362, 1, 'Interpersonal', 'Interpersonal', '<p><span style="font-size: 9.0pt; font-family: ''Arial'',''sans-serif''; mso-fareast-font-family: ''Times New Roman''; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">Team player.&nbsp; Always willing to help.&nbsp; A great listener and waits for people to finish speaking before speaking.&nbsp; Keeps co-workers and leadership informed and works to make things better.&nbsp; Adapts to last minute changes and always works to ensure our guests are well taken care of.&nbsp; Understands their line of sight to the customer and knows that if they are not serving a guest they are serving someone who is.&nbsp; Treats fellow Associates with dignity and acts with gratitude and humility.</span></p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(108, 'uZOGagw0PhaDFYE6', 1432842340, 1, 'Environmental Awareness', 'Environmental Awareness', '<ul>\r\n<li>Ensures that the Resort&rsquo;s arrival experience sets the tone for outstanding guest experiences.</li>\r\n<li>Ensures heart of the house, equipment and storerooms are clean, organized and well-maintained.</li>\r\n<li>Establishes standards and holds Team Members accountable for appropriate ambiance, music, aromas and lighting conditions.</li>\r\n<li>Ensures regular area tours are conducted to assure high standards and trains others to do the same.&nbsp;</li>\r\n<li>Maintains a quiet environment for Guests by requiring headsets for radio communications in public areas.</li>\r\n<li>Supports the Resort&rsquo;s Green Initiatives.</li>\r\n<li>Properly accounts for capital and maintenance projects; assists with the development of the annual and five year capital plans.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(48, 'VggllHBAKikBrNqJ', 1425675684, 1, 'Guest Service', 'Guest Service', '<ul>\r\n<li>Drives customer service and culture, and ensures it is systemic in the Resort; checks and inspects against established standards.</li>\r\n<li>Ensures all Team Members &nbsp;greet all Guests.</li>\r\n<li>Is engaged daily in guest service. &nbsp;Uses the Northview Schedule Optimizer; makes needed&nbsp;</li>\r\n<li>adjustments to always make sure the right people are in the right place at the right time.</li>\r\n<li>Trains Team Members according to the Resort&rsquo;s Performance Standards, models the way, and uses role playing to demonstrate and develop proper guest service behaviors.</li>\r\n<li>Always aware of the department and Resort&rsquo;s top guest dissatisfiers (e.g., the Dirty Dozen), develops plans to improve performance, and ensures staff is trained to manage chronic issues.</li>\r\n<li>Ensures service scores and goals are posted and reviewed during department meetings.</li>\r\n<li>Nurtures relationships with prospective and existing customers.</li>\r\n<li>Meets NVHG and Brand quality assurance expectations.</li>\r\n<li>Ensures telephones and radios do not interfere with face-to-face guest interactions.</li>\r\n</ul>', '', 1, 0, 'uuuuuuuuuuuuuuud'),
(10, 'vMmFxgCpvgukYtUi', 1411155267, 1, 'Interpersonal', 'Respectful', '<ul>\r\n<li>Treat others</li>\r\n<li>Values</li>\r\n<li>Always</li>\r\n</ul>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(121, 'VpmBq24xQPX0fiQB', 1432843142, 1, 'Accountable', 'Accountable', '<ul>\r\n<li>Is responsive</li>\r\n<li>Is goal-oriented and knows what is expected of him/her</li>\r\n<li>Practices excellent problem-solving and decision-making skills</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(124, 'VVWwEZ1F8yDR8AEM', 1432843142, 1, 'Planning', 'Planning', '<p>Works together on shared mission and vision to meet overall goals</p>\r\n<p>Strategizes, plans and set goals, gaining a competitive advantage</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(29, 'vwoXIWhpDJdrB3lk', 1425673170, 1, 'Interpersonal', 'Interpersonal', '<p>Team player.&nbsp; Always willing to help.&nbsp; A great listener and waits for people to finish speaking before speaking.&nbsp; Keeps co-workers and leadership informed and works to make things better.&nbsp; Adapts to last minute changes and always works to ensure our guests are well taken care of.&nbsp; Understands their line of sight to the customer and knows that if they are not serving a guest they are serving someone who is.&nbsp; Treats fellow Associates with dignity and acts with gratitude and humility.</p>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(9, 'vwtrTUEWj6MhnIUU', 1411155116, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Participates</li>\r\n<li>Actively</li>\r\n<li>Utilizes</li>\r\n</ul>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(123, 'VZwNkTkw6nbEe7gx', 1432843142, 1, 'Proactive', 'Proactive', '<ul>\r\n<li>Is well-organized and an effective manager of time</li>\r\n<li>Successfully balances career and personal life</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(39, 'w83wzhrV3P9UGhpk', 1425673496, 1, 'We would like to congratulate you on:', 'We would like to congratulate you on:', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(126, 'wJKCLP3FEf44ag8O', 1432843155, 1, 'Integrity', 'Integrity', '<ul>\r\n<li>Keeps commitments and actions always follow words</li>\r\n<li>Decisions are based on the overall best interest of guests, co-workers and the Company</li>\r\n<li>Communicates in an honest, respectful, direct and professional manner</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(14, 'wyadxJzfzzdSK5zl', 1411156602, 1, 'Quality', 'Quality of Planning', '<p>&nbsp;&nbsp;</p>', 'rating', 1, 0, 'IphMs4uKYQz7hwyL'),
(127, 'wzcgBBpkuNzIZj9X', 1432843155, 1, 'Passionate', 'Passionate', '<ul>\r\n<li>Is a source of positive energy and inspires excellence</li>\r\n<li>Leads by example, shares the vision and walks the talk</li>\r\n<li>Always eager to learn and grow</li>\r\n<li>Actively works to develop others</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(105, 'x7as3vrNrKYr5rK4', 1432842340, 1, 'Financial Acumen', 'Financial Acumen', '<ul>\r\n<li>Leads ongoing financial optimization utilizing the 14-Day Forecast, Northview Schedule Optimizer, and Daily Flash reports to train and guide department managers regarding spending and labor, assists in contingency planning to meet profit and flow-through expectations.</li>\r\n<li>Completes daily income and payroll audit; works to establish the Daily Revenue Flash and Daily Labor Flash as accurate and effective tools in managing the business.</li>\r\n<li>Partners with General Manager to complete the Annual Operating Plan (AOP) and presenting annual financial goals to the leadership team. Prepares assumptions and goals for controllable expenses, labor expenses by position, and all revenue departments.</li>\r\n<li>Manages the monthly forecasting process working with sales and revenue management to produce top line revenue and works with property leadership to accurately forecast profit within +/- 5%.</li>\r\n<li>Prepares month-end financial statements for all business units. Conducts monthly P&amp;L reviews in a constructive, educational manner. &nbsp;</li>\r\n<li>Analyzes results, determines key reasons for variances to target, and clearly/professionally communicates reasons both verbally and in written form when required. &nbsp;</li>\r\n<li>Regularly reviews Accounts Receivable ledger to ensure proper collection efforts; conducts monthly meeting with General Manager.</li>\r\n<li>Establishes and maintains an approval based purchasing process, ensures all products are received and stored in accordance with standards; ensures invoices are promptly turned in and properly coded. &nbsp;Has a history of solid food, beverage, and retail cost performance.</li>\r\n<li>Ensures controls are in place and Team Members are held accountable.</li>\r\n<li>Educates property leaders to take full advantage of RealView and ancillary systems (e.g., Kronos, DataVision) Maintains checkbook accounting system for all departments to determine purchase approvals and manage spending limits.</li>\r\n<li>Plans and implements all accounting procedures and systems for the Resort; ensuring adherence to NVHG accounting standards, GAAP, and the Uniform System of Accounts for the Hospitality Industry.</li>\r\n<li>Stays abreast of industry trends, constantly evaluates business processes and seeks to improve efficiency, dedicated to continuous improvement.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(136, 'xAP2MDHQXnVaLLWl', 1432843221, 1, 'What we would like to congratulate you on', 'What we would like to congratulate you on', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(44, 'XLeqpV1USMCE2vzY', 1425673991, 1, 'Manager’s CultureComments', 'Manager’s Culture Comments ', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(50, 'XUD4p8HflkeyJQZe', 1425675684, 1, 'Environmental Awareness', 'Environmental Awareness', '<ul>\r\n<li>Ensures that the Resort&rsquo;s arrival experience sets the tone for outstanding guest experiences.</li>\r\n<li>Ensures outlets, meeting facilities, heart of the house, equipment and storerooms are clean, organized and well-maintained.</li>\r\n<li>Establishes standards and holds Team Members accountable for appropriate ambiance, music, aromas and lighting conditions.</li>\r\n<li>Ensures regular area tours are conducted to assure high standards and trains others to do the same.&nbsp;</li>\r\n<li>Schedules disruptive maintenance tasks at the proper time to minimize guest inconvenience.</li>\r\n<li>Maintains a quiet environment for guests by requiring headsets for radio communications in guest areas.</li>\r\n<li>Works with Resort leadership to establish and execute an effective &ldquo;Green&rdquo; strategy.&nbsp;</li>\r\n<li>Facilitates capital projects and makes capital investment recommendations.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(95, 'XwvSeqICdTlyY8C8', 1430240852, 1, 'Rating Key Header', 'Rating Key Header', '<h1>RATING KEY</h1>', 'text', 1, 0, 'IphMs4uKYQz7hwyL'),
(138, 'y0bpXK8XWdG4F2Dn', 1432843222, 1, 'What we can do to help', 'What we can do to help', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(71, 'yIoLES0ZA5K0cmpM', 1425694823, 1, 'Contributor', 'Contributor', '<p>Actively participates in departmental meetings, pre-shifts, daily line-ups and planning sessions.&nbsp; Advises leadership of ongoing and chronic issues (e.g., supplies, maintenance, equipment, process, systems, and quality).&nbsp; Always accompanies concerns with suggested solutions.</p>', '', 1, 1, 'uuuuuuuuuuuuuuud'),
(67, 'yN2rJqxDDoWx3VyO', 1425694798, 1, 'Manager''s Comments', 'Manager''s Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(38, 'ynAtIPRP1eLt5otR', 1425673473, 1, 'What can we do to help?', 'What can we do to help?', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(68, 'YZ6FoxrhyCi2rv9X', 1425694823, 1, 'Personal', 'Personal', '<p>Arrives at work when scheduled.&nbsp; Accurately keeps track of hours worked through the timekeeping system. Is reliable and dependable.&nbsp; Demonstrates a strong commitment to the job and the Resort is a high priority in their life.&nbsp; Shows concern when objectives are not met.&nbsp; Maintains high standards.&nbsp; Speaks well of the Resort to friends and co-workers and shares concerns directly with leadership and refrains from complaining to co-workers.&nbsp; Follows the rules, uses good judgment, and does things the best way.</p>', 'rating', 1, 1, 'uuuuuuuuuuuuuuud'),
(80, 'z2a59UH4XK4wfu7B', 1425696103, 1, 'Professional', 'Professional', '<ul>\r\n<li>Appears, acts and communicates as a steward of our culture and our Company</li>\r\n<li>Practices excellent written and verbal communication skills</li>\r\n<li>Keeps internal business confidential</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(60, 'ZguAC2ejczkc8OLR', 1425694709, 1, 'Environmental Awareness', 'Environmental Awareness', '<ul>\r\n<li>Ensures that the Resort&rsquo;s arrival experience sets the tone for outstanding guest experiences.</li>\r\n<li>Ensures outlets, meeting facilities, heart of the house, equipment and storerooms are clean, organized and well-maintained.</li>\r\n<li>Establishes standards and holds Team Members accountable for appropriate ambiance, music, aromas and lighting conditions.</li>\r\n<li>Ensures regular area tours are conducted to assure high standards and trains others to do the same.&nbsp;</li>\r\n<li>Schedules disruptive maintenance tasks at the proper time to minimize guest inconvenience.</li>\r\n<li>Maintains a quiet environment for guests by requiring headsets for radio communications in guest areas.</li>\r\n<li>Works with Resort leadership to establish and execute an effective &ldquo;Green&rdquo; strategy.&nbsp;</li>\r\n<li>Facilitates capital projects and makes capital investment recommendations.</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(132, 'zgYs51KDje6BKkXE', 1432843155, 1, 'Professional', 'Professional', '<ul>\r\n<li>Appears, acts and communicates as a steward of our culture and our Company</li>\r\n<li>Practices excellent written and verbal communication skills</li>\r\n<li>Keeps internal business confidential</li>\r\n</ul>', 'rating', 1, 0, 'uuuuuuuuuuuuuuud'),
(135, 'ZjA6pzICbzKZPIPS', 1432843156, 1, 'Culture Comments', 'Culture Comments', '', 'text', 1, 0, 'uuuuuuuuuuuuuuud'),
(72, 'ZlPCrGzk2nEEhfO5', 1425694823, 1, 'Personal Development', 'Personal Development', '<p>Passionate. Inquisitive.&nbsp; Has a desire to learn everything there is to know about the resort attributes, experiences and local attractions.&nbsp; Maintains an ongoing dialogue with property leadership to discuss personal development opportunities<br />Knows what he/she is good at and where he/she needs to improve.&nbsp; Works well with leadership to develop a plan that coincides with their aspirations.&nbsp; Dedicated to continuous improvement.</p>', 'rating', 1, 1, 'uuuuuuuuuuuuuuud');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Folder`
--

CREATE TABLE IF NOT EXISTS `tnng_Folder` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `property_id` char(16) NOT NULL,
  `division_id` char(16) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `path` varchar(256) NOT NULL,
  `mime` varchar(256) NOT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Form`
--

CREATE TABLE IF NOT EXISTS `tnng_Form` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `created` bigint(20) unsigned NOT NULL,
  `expires` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='Form tokens and expiries.';

--
-- Dumping data for table `tnng_Form`
--

INSERT INTO `tnng_Form` (`aid`, `id`, `name`, `created`, `expires`) VALUES
(2, '1GAth1A0zUCzVSqc', 'new-strategy', 1463681384, 1463767782),
(15, '7w8x1vo0kPeKppc7', 'edit-subeval', 1463683656, 1463770054),
(9, '8ti1igLWLtmLbOjk', 'edit-subeval', 1463682819, 1463769216),
(11, 'aMb9Xp2E0IjsA1Wj', 'edit-subeval', 1463683124, 1463769522),
(10, 'FnKt3pz5Z6lZPzOQ', 'login', 1463683098, 1463769498),
(5, 'g4l3HJuo0oXi9rgP', 'edit-subeval', 1463682717, 1463769115),
(13, 'g7HcbLsChjwOBOwV', 'edit-subeval', 1463683379, 1463769777),
(7, 'i8DHWn37YX19262T', 'new-subevalcomp-field', 1463682750, 1463769150),
(6, 'jG9vPAHkMk3vJsZh', 'edit-subeval', 1463682747, 1463769144),
(8, 'JsTSvPCZUubbAiO7', 'edit-subeval', 1463682797, 1463769195),
(14, 'n1Lr8Oi42o67MdnJ', 'edit-subeval', 1463683404, 1463769801),
(3, 'pe9cd2BrMXUfe5eR', 'edit-subeval', 1463682659, 1463769056),
(19, 'q1bLco9oLB7A2jjr', 'passwordreset', 1463685839, 1463772239),
(18, 'qhEFhQYpsi7P3fYf', 'passwordreset', 1463685826, 1463772226),
(20, 'qnBDjYqfTEfa1PJS', 'edit-division', 1463686137, 1463772535),
(16, 'tehTP5aj8cXIuapE', 'edit-user', 1463685573, 1463771970),
(12, 'tUMpHe0UL01MQC4I', 'edit-subeval', 1463683210, 1463769607),
(4, 'UhUzYft05bYEG9Nm', 'edit-subeval', 1463682706, 1463769102),
(1, 'whfbCPY06XPMmlAb', 'login', 1463681368, 1463767768),
(17, 'Xw0UfC9nWtMcNVjY', 'login', 1463685824, 1463772224);

-- --------------------------------------------------------

--
-- Table structure for table `tnng_G`
--

CREATE TABLE IF NOT EXISTS `tnng_G` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) CHARACTER SET utf8 NOT NULL,
  `key` varchar(64) CHARACTER SET utf8 NOT NULL,
  `value` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `type` varchar(16) CHARACTER SET utf8 NOT NULL DEFAULT 'string'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Site-wide settings.';

--
-- Dumping data for table `tnng_G`
--

INSERT INTO `tnng_G` (`aid`, `id`, `key`, `value`, `description`, `type`) VALUES
(1, 'ggggggggggggggga', 'defaultController', 'strategiestactics', 'The default controller/page to load if another isn''t specified.', 'string'),
(2, 'gggggggggggggggb', 'defaultLanguage', 'en', 'The default language to use for this instance.', 'string'),
(3, 'gggggggggggggggc', 'defaultMethod', 'index', 'The default method to call if another isn''t specified.', 'string'),
(4, 'gggggggggggggggd', 'defaultRole', 'Anonymous', 'The default role for anonymous users.', 'string'),
(5, 'ggggggggggggggge', 'formExpiry', '86400', 'The number of seconds a form token is valid for.', 'int'),
(6, 'gggggggggggggggf', 'ipAddressesAllowed', '', 'Whitelisted IP addresses - only these IPs will be able to access this instance.', 'string'),
(7, 'gggggggggggggggg', 'ipAddressesBanned', '', 'Blacklisted IP addresses cannot access the instance no matter what.', 'string'),
(8, 'gggggggggggggggh', 'revision', '20131003001', 'An integer used for cache-busting static assets.', 'int'),
(9, 'gggggggggggggggi', 'sessionTimeout', '3600', 'Session timeout in seconds.', 'string'),
(10, 'gggggggggggggggj', 'theme', 'default', 'The folder inside /views/ containing the template files for this instance.', 'string');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Ids`
--

CREATE TABLE IF NOT EXISTS `tnng_Ids` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `type` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12678 DEFAULT CHARSET=utf8 COMMENT='Global ID storage.';

--
-- Dumping data for table `tnng_Ids`
--

INSERT INTO `tnng_Ids` (`aid`, `id`, `type`) VALUES
(7043, '02cIyh1VeyMWK3Ww', 'Division'),
(5191, '065U9fLENQxqDNVQ', 'Division'),
(9774, '09SLdf2iKeogSrGp', 'Property'),
(9147, '0daPKdMWmmTI6VbL', 'Competency'),
(3097, '0FbJxgaWFzmaErnM', 'Property'),
(8004, '0g62kTGQx30wTbmD', 'Department'),
(3842, '0i46y7RftXCh5VN9', 'Field'),
(9797, '0ICN26AvVwEgYA3e', 'Division'),
(11770, '0j3nBtJ2096I4eqP', 'Department'),
(2862, '0jBfJNaC0ZQPked3', 'Field'),
(2776, '0jefVgpZHp8t15hA', 'Field'),
(3845, '0JJgGG5Z36GWz0fS', 'Field'),
(5249, '0nRNUUhyJp1mEcd5', 'Field'),
(9114, '0rLmKQf3lEZxWF9N', 'Division'),
(8002, '0yCaLIZ3REJFMqCD', 'Department'),
(5479, '1CyOinx6GOWjXDyp', 'User'),
(5156, '1EnslHnyOkviS1Y9', 'Competency'),
(5011, '1f4BCIeEyRE6eUnc', 'Division'),
(10790, '1n099YtF1Tk7kfEp', 'User'),
(3111, '1tVnGjK1z8GKErBV', 'Property'),
(2892, '1WkEbO3HYVkeTqEv', 'Field'),
(5266, '1X2WaeBu7MLhvMjV', 'Attachment'),
(837, '1XfvCO1CmQk4abAt', 'Attachment'),
(6367, '20JsSgeKWBjvEn8y', 'Acl_Roles'),
(9829, '2E7H50WSZUBYRCoV', 'Competency'),
(2798, '2FtGi89yth7Tnbtt', 'Field'),
(9586, '2nuEVJ8nb2UOhE77', 'User'),
(12464, '2RJSgd5zFsan8Wa9', 'User'),
(12474, '2UDbOEYKWa2aQzh8', 'User'),
(3072, '2Wek83mCPsx0RMiC', 'Toolbox'),
(8071, '2WzNab9hJc39vs1U', 'Department'),
(2989, '2y4sIaNhp3mn4I1B', 'Field'),
(11764, '38MczPWsYfd9w58y', 'Department'),
(2335, '39RrhcMH5ccw6OsY', 'Attachment'),
(7626, '3cPKg3m3I7VvFWjU', 'Attachment'),
(9827, '3Hvh8XQZ53dLqpul', 'Competency'),
(8061, '3IJrNb8bubNMiBdm', 'User'),
(2775, '3iVzA3NLacVS71Zo', 'Field'),
(5155, '3JxAkwwGeEglKOF5', 'Department'),
(2388, '3p2p9NprutD55XSO', 'Attachment'),
(7984, '3rigMKXrdvVIWjiA', 'Division'),
(4716, '3sTKN7cQdpkXLwNU', 'Division'),
(5086, '3UgMpMF5B0f6uPUt', 'Department'),
(6195, '3v6QWuJ9wCNLs04o', 'User'),
(1575, '3w8MZBUQwBIIt8mk', 'Compiledform'),
(3848, '3wgSjpHV8zOZfSR0', 'Field'),
(7194, '3z2isImvcZBF0e9e', 'Division'),
(337, '44Yg74KA8uBhau4i', 'User'),
(11750, '4a7aVAyHc6SAqlRE', 'Division'),
(11517, '4AGllwmN8A5x0Z1D', 'User'),
(7434, '4BnlMAKaSPcxG5JN', 'Attachment'),
(3356, '4EH4sjFb5UVtim5G', 'User'),
(5107, '4mXcduNoo86aRTZz', 'User'),
(2949, '4my2qSxD1Ds4HA3v', 'Field'),
(9237, '4PYYA0jRXUDv4ItT', 'User'),
(9395, '4qTViG0NGKgJywBp', 'Truenorth_Summary'),
(5888, '57u9ZA06EOR3BaSb', 'User'),
(7211, '5cBjhT0YEKJqN8xZ', 'Division'),
(5383, '5G7WZanU6fXEfkU3', 'Attachment'),
(4878, '5HcBPEhXRrYOdxfu', 'Reviewcycle'),
(2790, '5IgLP02XotEXKSo9', 'Field'),
(11793, '5JQURaiI77jcLlvY', 'Competency'),
(9229, '5LTemdkXB5lNu79s', 'User'),
(9397, '5OWGjWD1plqeHy2u', 'Truenorth_Summary'),
(9604, '5P1m0aKpDacSvrON', 'User'),
(3540, '5pc8UsZXVN2obyzp', 'Static'),
(11748, '5PzyX6qodYoofItG', 'Division'),
(389, '5RMc7KvNjZtEU0MM', 'Department'),
(7675, '5xDl4eVJGnFxhQtg', 'Attachment'),
(4856, '5ywWcQFZBARH3OWd', 'Reviewcycle'),
(2815, '5ZVGd5ZVgekdyVJi', 'Field'),
(760, '6cXltsGwnDr3yUtI', 'Field'),
(7782, '6eGRzhjtl9IfFJRd', 'Competency'),
(4469, '6HWzl3gh5dA67C61', 'Static'),
(12472, '6mgVzJmqH54TdxMb', 'User'),
(3919, '6S52uQJlCTevbxKO', 'Property'),
(2584, '6sl1UvKbpRMdLoq6', 'Department'),
(5385, '6SlnfUPpt3nocyV0', 'Attachment'),
(810, '6UdIxDvWm6RSrav7', 'Static'),
(9965, '6v3sWTOdQ6KFK1Se', 'User'),
(9139, '6YcBepvXV0tCP92m', 'Competency'),
(9427, '7BHaAW335UldZoyG', 'Attachment'),
(5160, '7DJ6XjVcD5kaNvXW', 'Competency'),
(5099, '7HbGiKRyQqfB0PqD', 'User'),
(3547, '7JnbmCD4jWimcEhI', 'Subevaluation'),
(2755, '7mgvh9YZyMlnEi3t', 'Subevaluation'),
(4924, '7P7eiAbsyJQqgBWa', 'Department'),
(2853, '7PCImLTwDjbAq8sY', 'Field'),
(4922, '7Q96ROjjIEchQSIC', 'Department'),
(9969, '7Uk4zRgIYmmqn5d1', 'Truenorth_Summary'),
(9137, '7uwMGFw9QnZOWMl3', 'Competency'),
(3181, '7wAJHrtO5xI1TKaG', 'User'),
(3526, '7WPW2XuvKVr7aV8f', 'Compiledform'),
(8576, '7yQHtABblgDT6f7D', 'Property'),
(9400, '8do299EBYwNbXugy', 'Truenorth_Summary'),
(4602, '8J08gBwroX1Jh2Aq', '#__RC_LAeiFdhKvtIHkWo9_emails'),
(3315, '8moekowqY0isAJIB', 'Attachment'),
(7778, '8p8PGrrby90hFUce', 'Competency'),
(3857, '8PPSv7ODT4SBcOpV', 'Field'),
(4719, '8R29qqbFSRdOjqFK', 'Department'),
(5185, '8RcWKRq5ZmmNIqIi', 'Division'),
(791, '8trdWVAnVoe8mjOu', 'Compiledform'),
(608, '8uSuaHFlqa2HglRO', 'Templates'),
(9815, '96Hr0bAUIlMaIj4M', 'Department'),
(2540, '9c1eC6wttsSYXUlZ', 'Field'),
(10332, '9Ge5rtsopL6wRhSa', 'Department'),
(4926, '9LcWePyOY9L8ZYPw', 'Department'),
(3861, '9ME38PPXR4HFNpV1', 'Compiledform'),
(7064, '9pGWtwRdXztNjzav', 'Department'),
(3819, '9rxlp7R5zOjWqAQg', 'Field'),
(9825, '9VyxuXu6lTjp8gBT', 'Competency'),
(4928, '9yGr7c88LZmQFzB3', 'Department'),
(5451, 'a1ELBFqhFKlNWodX', 'Division'),
(381, 'A4hTOqSCb7NABRt4', 'Department'),
(5170, 'a4l2jO5aEpPRPZWV', 'Division'),
(6003, 'A8gBehWQbugaTYkA', 'Property'),
(1407, 'AbBBY6YQHJIM3Zou', 'User'),
(5416, 'abBChaIoHMnsY6GK', 'Reviewcycle'),
(4950, 'AbT3VGx5EFykHXVv', 'User'),
(5234, 'AC7c93ASlRXCBGMA', 'Static'),
(7213, 'ACmou2zLtLgoSCg8', 'Division'),
(302, 'aCO2JAeUQrvNeNfv', 'Department'),
(2773, 'aCqHymAV4nghb3B7', 'Field'),
(10592, 'AdCu6JSIz4VVqDQY', 'User'),
(2597, 'akidv6YMzRItWsGr', 'User'),
(321, 'aMgFYhF2duo54vge', 'User'),
(319, 'ankusCJqBoo2cNvn', 'User'),
(7203, 'AOGG1oODk3GlqF0l', 'Department'),
(1029, 'Aoz65J6vUL0TCv82', 'Subevaluation'),
(2851, 'APfo3U5ChxkwlRCu', 'Field'),
(6059, 'aqdSKgnptuNHSMr8', 'Department'),
(11795, 'aslMAF7Y9B4ECg0w', 'Competency'),
(6107, 'aVm0xB4a7Qj11FI0', 'Department'),
(599, 'AxDlMqwmJmbfMB27', 'User'),
(5165, 'aXI2WkovYWo4oBtm', 'Competency'),
(7206, 'aXmGn5PcqM0D62eD', 'Competency'),
(3507, 'ayf63xmLCZC9xZJN', 'Property'),
(2947, 'aZKq1unDaN2Lh5R8', 'Field'),
(7215, 'aZSI6TrvGZoLTpX8', 'Division'),
(2850, 'B54gGKvg5A21XpBG', 'Field'),
(323, 'B6qh2C8VKM3bfJpp', 'User'),
(2988, 'b7mCJzmagDSdWb2E', 'Field'),
(4892, 'b7mkLMbFwPC0U95S', 'Field'),
(7986, 'bA98L50mp4hoaAk9', 'User'),
(5246, 'bCvT3slC7f7Wgtrt', 'Field'),
(3828, 'BF2L1f1zTI1H3u8P', 'Field'),
(6320, 'BiqDlFyeM552tyHW', 'User'),
(2333, 'bIWxn4gKPkRTrUAs', 'Attachment'),
(5076, 'bKGo7ggqU9D4n2Jj', 'Department'),
(5183, 'BmiJ1Q0iZwfHcmmn', 'Division'),
(11772, 'bmvBGFb71wnMfND2', 'Department'),
(9405, 'BNAaswjkgdCpPf6M', 'Truenorth_Summary'),
(5450, 'bnCWNiY21NA6SPBd', 'Division'),
(11171, 'bnLKMprpsh2Qz3xx', 'User'),
(8885, 'bREpNatdMHwZpTxg', 'Division'),
(806, 'Bt545BzmaxzdidGx', 'Property'),
(2209, 'BvYEgPMgV2MtOrUC', 'User'),
(5836, 'BweoKKavarpaYouF', 'Department'),
(7917, 'bxLHSr2l7EBqyqQ6', 'User'),
(4916, 'BZNY3fKloIIBppNI', 'Division'),
(5414, 'c32D6f0MBhmw79ow', 'Field'),
(9612, 'c4jxRYJkzEBQATCh', 'User'),
(5446, 'C4r3SCeXXdYMsdPu', 'Division'),
(4659, 'C6qkCZMQDue8wbBm', 'Competency'),
(4668, 'C7J27ZlYQyH7nwk3', 'Division'),
(9401, 'caVKwVaue8mTLosF', 'Truenorth_Summary'),
(111, 'ccccccccccccccca', 'Competency'),
(112, 'cccccccccccccccb', 'Competency'),
(113, 'cccccccccccccccc', 'Competency'),
(114, 'cccccccccccccccd', 'Competency'),
(115, 'ccccccccccccccce', 'Competency'),
(116, 'cccccccccccccccf', 'Competency'),
(117, 'cccccccccccccccg', 'Competency'),
(118, 'ccccccccccccccch', 'Competency'),
(668, 'cKcctxPlyTnJNSlU', 'User'),
(8934, 'CKDBpb54CsEIJNlv', 'Department'),
(11922, 'CkH6uxG8xsf6ofVN', 'User'),
(3844, 'CKMuopHPXVkFZcRS', 'Field'),
(3432, 'CmtlwbxHlk35sJhH', 'Field'),
(4911, 'CoecBl7vDIgn7JAZ', 'Property'),
(1030, 'cpm3COw1JdG7SJFO', 'Field'),
(5376, 'cqbwhlbYAilZKhDC', 'Attachment'),
(126, 'cr4bfJPJQzYFd3Qe', 'Property'),
(5195, 'cRZ5Gmu2ZSci9PB8', 'Division'),
(5200, 'CsghqqWfb92q96yE', 'Competency'),
(3553, 'cTPA7xlGN3QWnmM3', 'Compiledform'),
(4728, 'cYfHZW8daDZcNRR6', 'User'),
(9161, 'd03Q6W5SsZfSieNN', 'Competency'),
(7998, 'D0Bz61WhlKipxwfs', 'Department'),
(7060, 'dABWWHzNH5OPiRia', 'Department'),
(4623, 'DB480Mb4hYtRDJJX', 'User'),
(310, 'dbCFaGiXfLFRMj7s', 'Department'),
(78, 'ddddddddddddddda', 'Division'),
(79, 'dddddddddddddddb', 'Division'),
(80, 'dddddddddddddddc', 'Division'),
(81, 'dddddddddddddddd', 'Division'),
(82, 'ddddddddddddddde', 'Division'),
(83, 'dddddddddddddddf', 'Division'),
(84, 'dddddddddddddddg', 'Division'),
(85, 'dddddddddddddddh', 'Division'),
(86, 'dddddddddddddddi', 'Division'),
(304, 'ddVFyAauXEmBpliI', 'Department'),
(5138, 'DETgNvZ9s5FxO7MK', 'Property'),
(8063, 'dGGFbURvO97wJmfd', 'User'),
(3320, 'DjA7LPe0d5LysUC0', 'Attachment'),
(3774, 'DkY1KuVFktAFZ2gj', 'Subevaluation'),
(9060, 'dMSucxPaex7wH1jC', 'User'),
(7078, 'dmzkhxAMjmothjRK', 'Department'),
(7209, 'dPKgrHjBGLaMNKIm', 'Property'),
(3843, 'dQQfIilrlclKal5h', 'Field'),
(721, 'DRwCPN4DWylJahX8', 'Compiledform'),
(329, 'dTvjwkjxpe32Tmob', 'User'),
(3437, 'duZvftTgB7oaniy2', 'Compiledform'),
(5248, 'dYGwDieOigApVxQf', 'Field'),
(1534, 'DzBCNDn7vmWFJyBe', 'Subevaluation'),
(9546, 'DzZS5CtjwHwtQYII', 'User'),
(9398, 'E5C95AZaK5NexZAX', 'Truenorth_Summary'),
(11024, 'e5hfxc1IT9oKqJGg', 'Truenorth_Summary'),
(2544, 'e5tNGcK4hmXL8mwi', 'Field'),
(4944, 'ED1DHK1dYU3wgY4H', 'User'),
(8703, 'edosBgUv4hXJSilj', 'Attachment'),
(8887, 'EeBxvQGNpA58geFw', 'Department'),
(87, 'eeeeeeeeeeeeeeea', 'Department'),
(88, 'eeeeeeeeeeeeeeeb', 'Department'),
(89, 'eeeeeeeeeeeeeeec', 'Department'),
(90, 'eeeeeeeeeeeeeeed', 'Department'),
(91, 'eeeeeeeeeeeeeeee', 'Department'),
(92, 'eeeeeeeeeeeeeeef', 'Department'),
(93, 'eeeeeeeeeeeeeeeg', 'Department'),
(94, 'eeeeeeeeeeeeeeeh', 'Department'),
(95, 'eeeeeeeeeeeeeeei', 'Department'),
(96, 'eeeeeeeeeeeeeeej', 'Department'),
(97, 'eeeeeeeeeeeeeeek', 'Department'),
(98, 'eeeeeeeeeeeeeeel', 'Department'),
(99, 'eeeeeeeeeeeeeeem', 'Department'),
(100, 'eeeeeeeeeeeeeeen', 'Department'),
(101, 'eeeeeeeeeeeeeeeo', 'Department'),
(102, 'eeeeeeeeeeeeeeep', 'Department'),
(103, 'eeeeeeeeeeeeeeeq', 'Department'),
(104, 'eeeeeeeeeeeeeeer', 'Department'),
(105, 'eeeeeeeeeeeeeees', 'Department'),
(106, 'eeeeeeeeeeeeeeet', 'Department'),
(107, 'eeeeeeeeeeeeeeeu', 'Department'),
(108, 'eeeeeeeeeeeeeeev', 'Department'),
(109, 'eeeeeeeeeeeeeeew', 'Department'),
(110, 'eeeeeeeeeeeeeeex', 'Department'),
(3788, 'eFQH89vg1l6gGewL', 'Field'),
(5077, 'EikXpUAOzvAEncuI', 'Department'),
(3618, 'EiNHzm8TlOrhQG1C', 'Compiledform'),
(7672, 'Ej2DStMzrV4XHjhL', 'Attachment'),
(11890, 'eKrGIT8woaiqyPld', 'User'),
(5214, 'EO4u5UXVJYXW4M5Z', 'Acl_Roles'),
(2760, 'er0bcOW3JoxYs5Ur', 'Field'),
(9125, 'Et8UOa7hBTDRTp67', 'Department'),
(1535, 'eUCdsj6K99MGwbuv', 'Field'),
(5284, 'eWk3glz5Kv2opJiq', 'Field'),
(5217, 'F3kJVZc3z4VXiah5', 'User'),
(5187, 'f41ycU92LLKhiEDB', 'Division'),
(5176, 'fAGOkA30DsOFD3n1', 'Division'),
(5568, 'fFM0V9k7on3mzvWm', 'User'),
(6096, 'ffMoHkhd8uOAT38h', 'Department'),
(2893, 'FgpaVrtBJ6xUXcmN', 'Field'),
(2992, 'FIHGjAk1velrqWuO', 'Field'),
(3436, 'FJAVkbVPZlXHrumD', 'Static'),
(3431, 'flUsMFjP7r44ZrRp', 'Subevaluation'),
(1582, 'FLZjgzjqtkmnz47n', 'User'),
(2785, 'fMKuAhJMJ0SlVO9C', 'Field'),
(12421, 'Fn5gyuGK6VD1DD0Q', 'User'),
(308, 'FPwRzp31fyShCzl7', 'Department'),
(9967, 'fqTeXz7WiaSOQFqb', 'Truenorth_Summary'),
(4320, 'Ftrpd1A2AYgUSaz8', 'Toolbox'),
(7196, 'fy2AXKmeJdYXsTiK', 'Division'),
(123, 'FZvHPBXBjOlkZA0R', 'Property'),
(9495, 'g5s7DCr4bLtedD52', 'Division'),
(2905, 'G8X7ipy6XShhdKaR', 'Field'),
(2935, 'gcxG6cXZodJ0rBmW', 'Field'),
(331, 'gDf6fFqsPcQGf5PT', 'User'),
(1, 'ggggggggggggggga', 'G'),
(2, 'gggggggggggggggb', 'G'),
(3, 'gggggggggggggggc', 'G'),
(4, 'gggggggggggggggd', 'G'),
(5, 'ggggggggggggggge', 'G'),
(6, 'gggggggggggggggf', 'G'),
(7, 'gggggggggggggggg', 'G'),
(8, 'gggggggggggggggh', 'G'),
(9, 'gggggggggggggggi', 'G'),
(10, 'gggggggggggggggj', 'G'),
(283, 'gGW6XqU3PwIkWXbP', 'Property'),
(7624, 'gkEpJGBBJ6u5EPI7', 'Attachment'),
(7080, 'Gl7XHPhxFRMlKVUQ', 'Department'),
(2882, 'GMzbuozaIY3R0xAw', 'Field'),
(5379, 'GO9U4ilj8vRRx5W7', 'Attachment'),
(8851, 'GoIds6KHL5A2ns1w', 'Attachment'),
(2863, 'GokkacWAJ93Dq0hF', 'Field'),
(811, 'GOOIlq28a1JAe70x', 'Compiledform'),
(3113, 'gP3rFGS98AicUwNb', 'User'),
(4786, 'gqJv05oSdUCRC5mt', 'Reviewcycle'),
(2051, 'gvZnbXeUTBhvDlSH', 'Field'),
(377, 'GwvGhrDkspa2PKUf', 'Department'),
(2878, 'gXzsidRBadKuJERI', 'Field'),
(5088, 'gy404ySmXlIuj8sN', 'Department'),
(10313, 'gy6yOtkVvj884pRA', 'User'),
(3548, 'gYFp2LndIy5Traxm', 'Field'),
(2990, 'GZAvdoGFTGWAysVS', 'Field'),
(605, 'h1MK3R5mZpNkbUqA', 'Templates'),
(12676, 'H1NCMjMMa9fm12Fb', 'Truenorth_Summary'),
(11791, 'h2ky9BCLtDiUg6wU', 'Competency'),
(3825, 'H3CR1gSaDIAbQF0J', 'Field'),
(4863, 'HCA1EuamOwwl07u0', 'Reviewcycle'),
(8794, 'He2atSfBs23VPbxO', 'Attachment'),
(3574, 'HflZpcuTstaNsCo5', 'Toolbox'),
(7430, 'Hh1QNuM8Zki7hly6', 'Attachment'),
(3523, 'hIfVhxAgLtrlxSpT', 'Subevaluation'),
(4655, 'hisbCaIpFYslHKTx', 'Competency'),
(1562, 'HJ7UjNAfjNbad5MJ', 'Subevaluation'),
(3821, 'HJl7CSbp2z5EZB3q', 'Field'),
(5016, 'HkFNrIsgJ55UYR1l', 'User'),
(1933, 'Hoq1O0djxHIu9jCz', 'Department'),
(9239, 'hQ5ZciMrhR20EfLQ', 'User'),
(3822, 'hsb8ESwQdc9x8So7', 'Field'),
(8040, 'HxAuhH11h9KIv5kH', 'User'),
(9799, 'iBfwtC2boq5FlfIC', 'Division'),
(4752, 'ICq3q9Eq49CHvZWR', 'User'),
(5438, 'IE7vEb4L98mHXrnZ', 'Division'),
(9121, 'iEbInMKEABMTWXuA', 'Department'),
(4918, 'Ink5kbwAXwyMxLhm', 'Department'),
(3793, 'iNMDj9UPf3WcsALr', 'Field'),
(2864, 'IP8lyuWagGxB0A5r', 'Field'),
(128, 'IphMs4uKYQz7hwyL', 'User'),
(7056, 'itPSkXqo6DdVYwCN', 'Department'),
(11874, 'ITvAgDEtxwRevBHw', 'User'),
(9509, 'iUwF3lTTpFclBz3f', 'Department'),
(9817, 'IvfJ3nBmAKDMPIn0', 'Department'),
(3433, 'IvMAibwRQz6OSs0O', 'Field'),
(3818, 'IVpb3qKWFU1N2mgw', 'Subevaluation'),
(364, 'iw5pyVUjkIHO3QhZ', 'Department'),
(362, 'ixNbqlXk4EHki5mg', 'Department'),
(5231, 'ixYeJoa7S5CDa1TP', 'Field'),
(12499, 'iZPceo1wrxQfLySd', 'User'),
(3823, 'j1NfkU5F34RtXR6i', 'Field'),
(11370, 'j4AG3o9YUlY5f0Cu', 'Competency'),
(8714, 'j4laz9BFyE4JiB36', 'Competency'),
(2991, 'J52isdNvUAGlraGo', 'Field'),
(752, 'j8qNaRJxtput11mZ', 'Templates'),
(7247, 'jd4wnDEHphNJyzUX', 'Competency'),
(3766, 'jdhPqD8kuudtHj9w', 'Attachment'),
(716, 'jFF3qoQgjph59w7t', 'Static'),
(6673, 'JG8UrQJX0DmmK2fB', 'User'),
(7892, 'jJKKAis87EOQfTCR', 'User'),
(5073, 'JLd3vwVCDzuLGHPd', 'Division'),
(1544, 'JpcYwp0FNG4hVv1G', 'Reviewcycle'),
(5103, 'jqAh0T7fE7lgJAmc', 'User'),
(5452, 'JqiDwOgfEzFSQUGF', 'Division'),
(5448, 'JR3dV8Tt7nSE49LI', 'Division'),
(778, 'jR8Bx05TQ8yq8tCd', 'Field'),
(2758, 'jrallvmQgSPGIzc7', 'Field'),
(7690, 'JswuxhBQg4s3N86J', 'Competency'),
(4471, 'jX0SjlA4ry34i7Kf', 'Compiledform'),
(761, 'jy1bV9kj6ISGHIqL', 'Field'),
(1523, 'JyBbJD0A4wnFWLrV', 'Field'),
(9863, 'Jzhdd9T5G3KRUsNl', 'User'),
(4775, 'jZuVVHHz0M0OwQ7M', 'Toolbox'),
(729, 'K02zZMUkWmRrbl7G', 'User'),
(2052, 'K11er7NneYfHFggB', 'Field'),
(9917, 'k3VSdN4ww2QVyDNK', 'Truenorth_Summary'),
(9241, 'K7NATjzjwISXDrot', 'User'),
(7101, 'kauLR3WxugZNOhrv', 'Competency'),
(1406, 'kD31N6J1MeVHL9ZY', 'User'),
(5247, 'kIP9sWT8718lQtyq', 'Field'),
(4657, 'KJxD9rikNB1B56TK', 'Competency'),
(2542, 'kKpGWn43syp941oY', 'Field'),
(2945, 'KlDcrao4SLd8haY2', 'Subevaluation'),
(306, 'KlEjMiBXr3zLKiwC', 'Department'),
(4609, 'kmKGCZkVPp9TEgHI', '#__RC_LAeiFdhKvtIHkWo9_emails'),
(9840, 'kmUW7rrbJYxUbUSO', 'User'),
(2211, 'kOJ5ey7VPYE64yYy', 'User'),
(2934, 'KopsM1x4dqFSbp5E', 'Field'),
(333, 'kQ1eczFYasbljkZ8', 'User'),
(9072, 'kUKdP1fg6nUZVt4R', 'User'),
(5275, 'kUUbPgnVwWqESh6C', 'Compiledform'),
(12427, 'Ky9cwmI8Fw4vI7Gk', 'User'),
(11410, 'KZZlt3hS1YNSt452', 'Truenorth_Summary'),
(5828, 'l4qJgIcn0f4Vos15', 'Property'),
(4708, 'l5Y3PuzfQeSiywTw', 'Competency'),
(7058, 'l6KVKubkOMqt3wG3', 'Department'),
(4593, 'LAeiFdhKvtIHkWo9', 'Reviewcycle'),
(2779, 'laF4VrJPNP5vKnCa', 'Compiledform'),
(765, 'lAnA5JBzhepw3M43', 'Static'),
(3104, 'lbghcnIhr5OgNBUG', 'User'),
(5174, 'LikG9Wi7pezW1Ih7', 'Division'),
(5075, 'LiOB5hazAInZANyn', 'Department'),
(2825, 'lKAu6IVef6GxRijA', 'Field'),
(4571, 'LkTGhuI0UrtkAwTF', 'Property'),
(1922, 'LM8gM4E3p49HNBtK', 'Property'),
(5132, 'Lof5yDjFUMLQyZhT', 'Competency'),
(3859, 'Lp8MBNd2u2bhuHo8', 'Field'),
(3803, 'LPMfR6QdXhf0juRI', 'Field'),
(2932, 'LQ3kdjqEpVjdDdCg', 'Field'),
(2808, 'lQloxZPrXDsy9YLS', 'Field'),
(3354, 'lRXV6o4oMamgx3mm', 'User'),
(11376, 'lVWpHX6b2rtZxIrx', 'Competency'),
(9192, 'lXIzem0TNVqSywvW', 'Competency'),
(1558, 'lzaL2CtbwBg12WpW', 'Field'),
(6637, 'lZdBGv7bQqvJ2qIZ', 'Attachment'),
(7068, 'm0ht3B7gVzsAQZ1v', 'Department'),
(2890, 'M1iwBRSzdoMPUzVU', 'Field'),
(5189, 'm7IFOpAZPFtN7PIh', 'Division'),
(2824, 'MExeEeX2jXBZpYml', 'Subevaluation'),
(121, 'MIooENXcUgHJTziJ', 'Property'),
(5974, 'mK2reJXZe6InG4RH', 'User'),
(317, 'mkP7DPiLrzrSWzmp', 'User'),
(3791, 'mKYngkEgpPQxtHX8', 'Field'),
(11111, 'mKZVwJF0D6Th1WZ9', 'Truenorth_Summary'),
(11789, 'Mm4NXisjGWjzJAU9', 'Competency'),
(789, 'mOnBGkeN8yFi2Q32', 'Static'),
(4573, 'mOpqWj5IMYgh8p8c', 'Division'),
(7776, 'mPMbpuO0T9MK78Gr', 'Competency'),
(8006, 'MpsaqK6vBezbzY19', 'Department'),
(3804, 'mrtSviGDHYCvqlXY', 'Field'),
(3775, 'muLkIQnOB28ZqXu9', 'Field'),
(5198, 'mybqesctGBKLMJwT', 'Competency'),
(9995, 'mYSe1qPDfHgbaj95', 'Truenorth_Summary'),
(2484, 'n2ceeauiuNVjBpzB', 'Field'),
(5833, 'n2FHmwbHjWcaUbbL', 'Division'),
(9809, 'n4d1M3XMBal2zuC1', 'Department'),
(5437, 'N9TQ4Ki29qhqRNrg', 'Division'),
(5250, 'ND7VJMPUgcM5AAXW', 'Field'),
(2948, 'NEytAQ9ugDjWlZ8T', 'Field'),
(6233, 'nFh94MBY7gf3xaPX', 'User'),
(4795, 'NguRqN1gresypGv1', 'Reviewcycle'),
(6635, 'nHkVQjbYBAlnUNs8', 'Attachment'),
(2777, 'Nho7yCjRv1s3btWK', 'Field'),
(10787, 'nKRzOB67x0mbiVhA', 'Truenorth_Summary'),
(4930, 'nlrlBiBWyOBwstC0', 'Department'),
(375, 'nNwMoYQBZ7HeSGM6', 'Attachment'),
(5095, 'NQrXkp5jBhARnraK', 'User'),
(5848, 'Nr2CIeYbwqGkH4L0', 'Toolbox'),
(11374, 'ns1JeFg6vXkxI1xb', 'Competency'),
(3182, 'NvHlH27ivWglfwJY', 'User'),
(3611, 'NwTCCINrxto8jplb', 'Field'),
(4625, 'NYhZ01IjjaPnwcrj', 'User'),
(2946, 'NZkL8qXRDNKKiSU4', 'Field'),
(1920, 'O3TInfzzSiywJqL2', 'Property'),
(11762, 'o4YRbKCWDWdjvcvT', 'Department'),
(9485, 'o6Sn0DqvF74BBxuf', 'Property'),
(8660, 'o90k7th4eO70okWO', 'Attachment'),
(2933, 'O95REb5EqKLzfsMt', 'Field'),
(7784, 'OaZpvgDv1Eyyyv7O', 'Competency'),
(5285, 'obC23qsqjB6Mecuo', 'Field'),
(7971, 'OBlNcCK666sVtmUl', 'User'),
(1557, 'OdfQrW31aCEaMOSj', 'Field'),
(10733, 'oerNctodu7t9vkMz', 'User'),
(3790, 'OH6h77Mfbx15ydYK', 'Field'),
(5245, 'oHzd0Ey2m3dYg0Ny', 'Field'),
(3441, 'OjB7VVkPGo436jvN', 'Reviewcycle'),
(1517, 'oK6SDp4oZnubrUMU', 'Subevaluation'),
(156, 'OL0diB7ZaGu4qxdY', 'User'),
(11754, 'olFKYXwnYwMlp2Tc', 'Division'),
(7915, 'OlJCrkatouaOUopQ', 'User'),
(7900, 'OmcSIBDOjWqLW5lr', 'User'),
(3805, 'OmgOIai3w2hJz88D', 'Field'),
(12018, 'oMQPFFIMBDzVbjkz', 'Competency'),
(3820, 'OMrxfqLd0amS2VUR', 'Field'),
(5273, 'onT2jRKpEvyX8SzH', 'Compiledform'),
(3777, 'ONUbE6saA9F6m4Qf', 'Field'),
(2904, 'oPTrxzX4JyPtrGzx', 'Field'),
(2543, 'OQ5r21Zk3SKXly3H', 'Field'),
(5843, 'Oqj2sSqbuWCbpvVH', 'User'),
(2595, 'oSMufQsWgCdxY2fg', 'User'),
(4942, 'OUEYcCBxmQUZjRtx', 'Department'),
(7982, 'OyQsAJgUgXtxgoHU', 'Division'),
(2877, 'oytBlsOts63RCVpp', 'Field'),
(5145, 'p3Y6FUFh1dVpDJEk', 'Division'),
(7682, 'p89kk4HXqHIgMc3L', 'Attachment'),
(5459, 'p93SO7VDlamuwOqe', 'Department'),
(4777, 'P9PnjeCAWJNLWgso', 'Toolbox'),
(3806, 'pCK4pvzYsEFkXa7d', 'Field'),
(5006, 'pCXWVk77kgqoPb1w', 'Property'),
(2891, 'pDdQWSfGbDxp9zMU', 'Field'),
(8666, 'PDiCYzQTeGqtKIG1', 'Attachment'),
(8000, 'pDk2uy5HC3NyzglV', 'Department'),
(3531, 'pdtuAV5qXyVCH6xB', 'Compiledform'),
(11978, 'peHsQnCozjzHj7pT', 'Department'),
(3802, 'PfQuLiN0QJPPrZtp', 'Field'),
(288, 'Ph4ZPEyETD5EGBtN', 'Division'),
(1518, 'pJm1cybQkNjjFQwM', 'Field'),
(2908, 'pkDjmdOGVV7Ff3pI', 'Field'),
(2757, 'PlCIMwlhhHP5EecF', 'Field'),
(2759, 'pMeNcV4PnKearuo5', 'Field'),
(3779, 'pmPAJDIi1er0cgCS', 'Field'),
(12478, 'PNHji6Rds55pWKZO', 'User'),
(18, 'pppppppppppppppa', 'Acl_Perms'),
(19, 'pppppppppppppppb', 'Acl_Perms'),
(20, 'pppppppppppppppc', 'Acl_Perms'),
(21, 'pppppppppppppppd', 'Acl_Perms'),
(22, 'pppppppppppppppe', 'Acl_Perms'),
(23, 'pppppppppppppppf', 'Acl_Perms'),
(24, 'pppppppppppppppg', 'Acl_Perms'),
(25, 'ppppppppppppppph', 'Acl_Perms'),
(26, 'pppppppppppppppi', 'Acl_Perms'),
(27, 'pppppppppppppppj', 'Acl_Perms'),
(28, 'pppppppppppppppk', 'Acl_Perms'),
(29, 'pppppppppppppppl', 'Acl_Perms'),
(30, 'pppppppppppppppm', 'Acl_Perms'),
(31, 'pppppppppppppppn', 'Acl_Perms'),
(32, 'pppppppppppppppo', 'Acl_Perms'),
(33, 'pppppppppppppppp', 'Acl_Perms'),
(34, 'pppppppppppppppq', 'Acl_Perms'),
(35, 'pppppppppppppppr', 'Acl_Perms'),
(36, 'ppppppppppppppps', 'Acl_Perms'),
(37, 'pppppppppppppppt', 'Acl_Perms'),
(38, 'pppppppppppppppu', 'Acl_Perms'),
(39, 'pppppppppppppppv', 'Acl_Perms'),
(40, 'pppppppppppppppw', 'Acl_Perms'),
(41, 'pppppppppppppppx', 'Acl_Perms'),
(42, 'pppppppppppppppy', 'Acl_Perms'),
(43, 'pppppppppppppppz', 'Acl_Perms'),
(44, 'ppppppppppppppqa', 'Acl_Perms'),
(45, 'ppppppppppppppqb', 'Acl_Perms'),
(46, 'ppppppppppppppqc', 'Acl_Perms'),
(47, 'ppppppppppppppqd', 'Acl_Perms'),
(48, 'ppppppppppppppqe', 'Acl_Perms'),
(49, 'ppppppppppppppqf', 'Acl_Perms'),
(50, 'ppppppppppppppqg', 'Acl_Perms'),
(51, 'ppppppppppppppqh', 'Acl_Perms'),
(52, 'ppppppppppppppqi', 'Acl_Perms'),
(53, 'ppppppppppppppqj', 'Acl_Perms'),
(54, 'ppppppppppppppqk', 'Acl_Perms'),
(55, 'ppppppppppppppql', 'Acl_Perms'),
(56, 'ppppppppppppppqm', 'Acl_Perms'),
(57, 'ppppppppppppppqn', 'Acl_Perms'),
(58, 'ppppppppppppppqo', 'Acl_Perms'),
(59, 'ppppppppppppppqp', 'Acl_Perms'),
(60, 'ppppppppppppppqq', 'Acl_Perms'),
(61, 'ppppppppppppppqr', 'Acl_Perms'),
(62, 'ppppppppppppppqs', 'Acl_Perms'),
(63, 'ppppppppppppppqt', 'Acl_Perms'),
(64, 'ppppppppppppppqu', 'Acl_Perms'),
(65, 'ppppppppppppppqv', 'Acl_Perms'),
(66, 'ppppppppppppppqw', 'Acl_Perms'),
(67, 'ppppppppppppppqx', 'Acl_Perms'),
(68, 'ppppppppppppppqy', 'Acl_Perms'),
(69, 'ppppppppppppppqz', 'Acl_Perms'),
(70, 'ppppppppppppppra', 'Acl_Perms'),
(71, 'pppppppppppppprb', 'Acl_Perms'),
(72, 'pppppppppppppprc', 'Acl_Perms'),
(73, 'pppppppppppppprd', 'Acl_Perms'),
(2964, 'PpZRU7uk05kx1N0B', 'Static'),
(719, 'PvuVQzw0E1KgpAtK', 'Static'),
(5177, 'pZWZnCw2cxZCvyss', 'Division'),
(7774, 'q4ibgrIBmMKworhv', 'Competency'),
(2951, 'q5ua0yeABOJQ07FS', 'Compiledform'),
(10458, 'q71DVwk3MvI1Vys6', 'Attachment'),
(4903, 'q7Jz1aZDwSOmxbn8', 'Reviewcycle'),
(3307, 'q8VtkRQbUHqmLxfQ', 'Attachment'),
(5456, 'qDmHlw8d7YzikmnS', 'Division'),
(2955, 'qEcU1LQxZamaCePF', 'Static'),
(7786, 'QETsnWp6ild7nGHy', 'Competency'),
(5283, 'QFs0CIeULeQ228iA', 'Subevaluation'),
(8664, 'qhCqQUKxBV8AdHnh', 'Attachment'),
(9422, 'QirxrqV1W2mTNEev', 'Attachment'),
(3557, 'qj0BbcwJDYf7WpYL', 'Field'),
(596, 'Qmj1z1ST4Hf8IovX', 'User'),
(3101, 'QMQYZO7z6oSwwDJA', 'User'),
(12677, 'qnBDjYqfTEfa1PJS', 'Form'),
(2789, 'QnIDJVZdEq4jgpOP', 'Field'),
(3052, 'qq5aWOJXfmtQIeDg', 'Toolbox'),
(2807, 'qrAdjOgaP5UN1sMu', 'Field'),
(4611, 'QrS35G22a6tKhPeM', '#__RC_LAeiFdhKvtIHkWo9_emails'),
(3847, 'QVvlMKkdC7dFhCS3', 'Field'),
(2930, 'QVyydegcqMxLCdNo', 'Subevaluation'),
(4100, 'QX1tT3UQgOiwgH66', 'Compiledform'),
(9394, 'QXaMaX39lBg01zCS', 'Truenorth_Summary'),
(335, 'R0EHU2FnwSSXsjhk', 'User'),
(7686, 'R3lnB1KJmFEVUdIo', 'Attachment'),
(3801, 'r6DI8iWMWqWZx6dJ', 'Field'),
(2797, 'RAjv0hFMhMyhJQaU', 'Field'),
(3778, 'ratM6s1pK3KM6h1X', 'Field'),
(4885, 'rCxBBQV0VJgrItlT', 'Reviewcycle'),
(6115, 'RFUPJrIO7zGS98Ot', 'Department'),
(3360, 'rG7ROQ5hyaweG7Vi', 'Attachment'),
(618, 'RH7uPk34PoFvNYBg', 'User'),
(1538, 'RHNxKTlKuGznMt6r', 'Compiledform'),
(2938, 'RhUItGZWvuB2gfRt', 'Field'),
(2939, 'RIFT7TtaGpelPeG8', 'Field'),
(5000, 'RkY24XFoNxSlqkZC', 'Property'),
(5440, 'RlNB5dt8JcQ0OCuo', 'Division'),
(1935, 'RMVw0nJ9wl0Vcr8Z', 'Department'),
(9127, 'rnYtm6gVTNuUlbbi', 'Department'),
(11, 'rrrrrrrrrrrrrrra', 'Acl_Roles'),
(12, 'rrrrrrrrrrrrrrrb', 'Acl_Roles'),
(13, 'rrrrrrrrrrrrrrrc', 'Acl_Roles'),
(14, 'rrrrrrrrrrrrrrrd', 'Acl_Roles'),
(15, 'rrrrrrrrrrrrrrre', 'Acl_Roles'),
(16, 'rrrrrrrrrrrrrrrf', 'Acl_Roles'),
(17, 'rrrrrrrrrrrrrrrg', 'Acl_Roles'),
(7066, 'RUmeAS8j3neUeRHA', 'Department'),
(5444, 'rVwCYfqBE1wQrHPO', 'Division'),
(4666, 'RVXcZZhzFtjpHrs9', 'Division'),
(2987, 'RVYVaMXJVz8YerWw', 'Field'),
(2806, 'rzzTUdOm2PX9Ik95', 'Field'),
(8722, 's583TUTSdf6NkgCv', 'Department'),
(4674, 's7BxjdX7uJsRHLgN', 'Department'),
(9497, 'sa84iV3t7sjST7pW', 'Division'),
(7103, 'sAFXbweflcbKAhMS', 'Competency'),
(12435, 'sC8FI1mbNTbvvovF', 'Competency'),
(2931, 'Se20ApfxjAFEvqI4', 'Field'),
(2894, 'SMY6AlUBRZYoHYBn', 'Field'),
(9149, 'SooZANrnwxwHKLvt', 'Competency'),
(9861, 'SoRg4TVNXaV87j8p', 'User'),
(7070, 'ssKoJBzVOE5ijSTR', 'Department'),
(9807, 'SSqcaGl0rtUOkUlx', 'Department'),
(4670, 'SUDozMQPKFQFKSwX', 'Division'),
(3505, 'Suftd2cO9OKO4QGa', 'Attachment'),
(6043, 'suLFHSMG2rCWwi1f', 'Department'),
(5013, 'sUzlXinZewyxfXe7', 'Division'),
(2756, 'szbmt1RtQySIE8ch', 'Field'),
(1530, 't3IR2j9erTxRvrrZ', 'Subevaluation'),
(2814, 't5tohEzVUuc5CHXm', 'Subevaluation'),
(4940, 't6tohi5OD3bNA7GB', 'Department'),
(7219, 't7hbsBAiix3yX3W9', 'Competency'),
(2879, 't8beEpzd2hRF5blz', 'Field'),
(11240, 't8CCaXDYfzxtjZij', 'User'),
(5436, 'tdyrKuwhI7lbSLuE', 'Division'),
(4622, 'TeB7nsgC4skeaB0k', 'User'),
(7217, 'TfiGtxdrbSJzXqf0', 'Competency'),
(7200, 'tgFalTXVKDRZ72s4', 'Department'),
(2936, 'TJaHqwpOrqzT4bil', 'Field'),
(2880, 'tJq3xp2PPBEdWyxA', 'Field'),
(9527, 'tmQGRYQAoK8ieALd', 'Competency'),
(6088, 'TmsaPIDRUXemFyAd', 'Department'),
(6035, 'TN5x4GE8DiOzEDUX', 'Department'),
(11205, 'tNFjw8ht5zmIoQL9', 'User'),
(759, 'tre5eyTz482GcI3d', 'Subevaluation'),
(9123, 'TsOBAY7bLuiraiHW', 'Department'),
(2865, 'Tsr3UyPflAdJ4STM', 'Field'),
(5101, 'TTxieYv2BNjDA8v9', 'User'),
(7072, 'tvlNkzMz1IxJSE85', 'Department'),
(2784, 'TVYBihT5HgYSfp9c', 'Subevaluation'),
(9221, 'TxpSNSltrkNVqorR', 'Competency'),
(7054, 'tZRJ6TYIFrmQ17nk', 'Department'),
(4849, 'U04k9uVJmo8qIorv', 'Reviewcycle'),
(5258, 'u4krn4HPGRIbMcnL', 'User'),
(7780, 'u5D98PBfczzJOO9J', 'Competency'),
(3116, 'u5r6wBkOxwOmcv3e', 'User'),
(11768, 'u5RNkcTWC0oqKvnt', 'Department'),
(9523, 'U60AqHdoknLr46MR', 'Competency'),
(5193, 'U6ClRbhLKa2nvyL0', 'Division'),
(7973, 'U9ZBBXDnirEMhwkK', 'User'),
(373, 'Uas2iUNz0WGaAiLL', 'Department'),
(11811, 'uAx82aAfNY6WKE5M', 'Competency'),
(9106, 'UBjuNpwPLpldJqm5', 'Property'),
(2541, 'ucrd4YDERZBawzln', 'Field'),
(8713, 'UeUFQ0SxeRijLUph', 'Competency'),
(325, 'Ufc2ulmSCNZjOLAy', 'User'),
(4579, 'ugEc3ohw1OQoLScq', 'Department'),
(9197, 'UGM9pmGCnQp4GTLO', 'Competency'),
(9116, 'uhhT7ghzhPCbM8tR', 'Division'),
(2866, 'Uhj1Y9qSxvVKrmqB', 'Field'),
(733, 'ujiiwrqlXWLXhWj7', 'User'),
(9493, 'ujjmJv3RvWkRpj7D', 'Division'),
(4756, 'ULEyr7eayRZQTSXS', 'User'),
(1519, 'umkILPl1UAtqpNdp', 'Field'),
(8031, 'umsLXLhwokTjjkyA', 'User'),
(3776, 'umuRazGkiGp4LJGO', 'Field'),
(8089, 'uTRz20AthiCF18Vz', 'User'),
(10315, 'uTx06uu0e39BrUq0', 'Division'),
(4676, 'UTysg95mhReLv3Z9', 'Department'),
(74, 'uuuuuuuuuuuuuuua', 'User'),
(75, 'uuuuuuuuuuuuuuub', 'User'),
(76, 'uuuuuuuuuuuuuuuc', 'User'),
(77, 'uuuuuuuuuuuuuuud', 'User'),
(779, 'UWtB7EZqvQGI4ahx', 'Field'),
(4740, 'UxOIh9fTJqXk8WGg', 'Reviewcycle'),
(3792, 'uZOGagw0PhaDFYE6', 'Field'),
(4643, 'V4ZBTCPZPAUtPUth', 'Acl_Roles'),
(5181, 'V91DKnhE9MDbHEhA', 'Division'),
(8658, 'vA3uiFKoA8YAEIPd', 'Attachment'),
(5408, 'vdVSQ7xllVkTOggr', 'Reviewcycle'),
(2852, 'VggllHBAKikBrNqJ', 'Field'),
(9513, 'viN6JvIJMEKQ3bNg', 'Department'),
(5260, 'vJNM2WUEN45WbwGp', 'Attachment'),
(9693, 'VKxECsczPzE4U9rX', 'Truenorth_Summary'),
(1531, 'vMmFxgCpvgukYtUi', 'Field'),
(11813, 'VMuqnbfBSNTjTJbf', 'Competency'),
(5205, 'Vn7DF1Zte5y9njOp', 'Department'),
(9588, 'vNqDC21LmKpf0ayF', 'User'),
(3824, 'VpmBq24xQPX0fiQB', 'Field'),
(4735, 'VTJ5S5r3Y4pt0Qj6', 'Acl_Roles'),
(11766, 'vTRESqUJxh0noiz3', 'Department'),
(6352, 'vu0nzqabfE2O1o0v', 'User'),
(385, 'VucOYGJtCgzMft0c', 'Department'),
(5454, 'vUkCLHYYB7WTZsP3', 'Division'),
(4914, 'VVLpEgznX93AaGJ5', 'Division'),
(613, 'VvONYTE3MWs8n0kZ', 'Templates'),
(3827, 'VVWwEZ1F8yDR8AEM', 'Field'),
(2774, 'vwoXIWhpDJdrB3lk', 'Field'),
(1524, 'vwtrTUEWj6MhnIUU', 'Field'),
(315, 'VYBVZXEeWQUwEJuW', 'Competency'),
(4619, 'VyCA7LRxm7h3JC0H', 'User'),
(5202, 'VZUicUQ6Z2eCsvtR', 'Department'),
(3826, 'VZwNkTkw6nbEe7gx', 'Field'),
(8691, 'W3aWnYC6bDtUN2hd', 'Competency'),
(7684, 'W4f6Sml7wZdFP3CU', 'Attachment'),
(9515, 'W4mmux4snlepHaFa', 'Department'),
(2805, 'w83wzhrV3P9UGhpk', 'Field'),
(766, 'w9IS5CTuqz9GeAkQ', 'Compiledform'),
(7245, 'W9WKKfoxlwLjwA3w', 'Competency'),
(12476, 'WdHCo5hZU3GTqzzI', 'User'),
(11774, 'wDHK3QYTlKFv8CdN', 'Department'),
(5208, 'WDvViBEJdrPtaDdv', 'Department'),
(4891, 'weG4JA03y2qCjNfl', '#__RC_rCxBBQV0VJgrItlT_emails'),
(3855, 'WFlBnAvjGXkLdjTV', 'Subevaluation'),
(5838, 'wIjvu3XCjRUJ4UGY', 'Department'),
(3840, 'wJKCLP3FEf44ag8O', 'Field'),
(12612, 'wkBxkNvcwnwAml7w', 'Acl_Roles'),
(5442, 'wkP8C01WZ0VDmRqL', 'Division'),
(6689, 'wksigFQajUgrRcTG', 'User'),
(6139, 'wLuNrOZucMZoUVYK', 'Competency'),
(9312, 'WmYwef0CEOaFUINX', 'Attachment'),
(11752, 'wnv7c3hEFpQ97lOU', 'Division'),
(5352, 'wQqbWnpQkELgVMJp', 'Toolbox'),
(5105, 'WQQCGR8CPcmhMp25', 'User'),
(8936, 'Wv5ZKFo3U9NtG7mh', 'Department'),
(4713, 'wWpm70jzb5N35JiP', 'Property'),
(1563, 'wyadxJzfzzdSK5zl', 'Field'),
(3841, 'wzcgBBpkuNzIZj9X', 'Field'),
(11899, 'X1vsMOs8gptsuqBn', 'Acl_Roles'),
(3789, 'x7as3vrNrKYr5rK4', 'Field'),
(4582, 'X86ixqXZ0eVIAV5J', 'User'),
(9968, 'xaIQG43ypfbUj6BS', 'Truenorth_Summary'),
(3856, 'xAP2MDHQXnVaLLWl', 'Field'),
(6051, 'XDoOSzI1Gy2Jld63', 'Department'),
(4661, 'xeca0t4Ji5KSARiP', 'Competency'),
(4920, 'XfvUsIYKzSkoP6wl', 'Department'),
(6167, 'XgI2wplUYnshSmSJ', 'User'),
(10156, 'xjBikHUHO8tpEoQF', 'Truenorth_Summary'),
(8932, 'XjVBCghdfwleknQz', 'Division'),
(9525, 'XjxwVxXRDPgOGGtL', 'Competency'),
(2821, 'XLeqpV1USMCE2vzY', 'Field'),
(7062, 'xMm2ZzXX8GMAZ2cF', 'Department'),
(4652, 'xnBihqjHQHhUbkVk', 'Competency'),
(294, 'xo1He11ZSu6yhMJc', 'Division'),
(9849, 'xPnYYV95szOiZFG9', 'User'),
(4621, 'XSr6tdLthCBBn0DT', 'User'),
(3787, 'Xtmc3ymd2kumJW87', 'Subevaluation'),
(2854, 'XUD4p8HflkeyJQZe', 'Field'),
(11231, 'xvddk3egUHJZJF4X', 'Department'),
(3524, 'XwvSeqICdTlyY8C8', 'Field'),
(9511, 'xYdRtCvKXDLVzzkE', 'Department'),
(3858, 'y0bpXK8XWdG4F2Dn', 'Field'),
(7105, 'Y3wwByWg9gaIc075', 'Competency'),
(5461, 'y4bxC4FH0gF2JjcH', 'Department'),
(9396, 'y59co8tiLNMhdDl9', 'Truenorth_Summary'),
(2483, 'Y5GeTWjG1Nl4nLSJ', 'Subevaluation'),
(4894, 'y6Oy4xvgdVu5zN8O', 'Reviewcycle'),
(5840, 'y9RY4RBVw1Cbntlv', 'User'),
(10022, 'YBAHHzAWkaPaV4WU', 'User'),
(3042, 'yBrGSnof7jomeqmf', 'Toolbox'),
(5225, 'ycoaBakwXVvdLAub', 'Reviewcycle'),
(2906, 'yIoLES0ZA5K0cmpM', 'Field'),
(5179, 'yjmO1Xidruc6KA1a', 'Division'),
(2895, 'yN2rJqxDDoWx3VyO', 'Field'),
(4753, 'Yn8oAaAPEWtuNRLK', 'User'),
(2799, 'ynAtIPRP1eLt5otR', 'Field'),
(2849, 'ynRGTgQABNkApOAU', 'Subevaluation'),
(9783, 'YoiuYYP2KzbaaT77', 'User'),
(1931, 'yQwpm9oXLrXM4nTu', 'Division'),
(3064, 'ysQiJDaRWa9QUbQF', 'Toolbox'),
(9135, 'yu928Pi9wwHj23B6', 'Competency'),
(4077, 'yuV4CZ26vHn4OYIx', 'Competency'),
(5149, 'ywhgm9vnndEbIiAf', 'Competency'),
(6067, 'YXOUD4n3H8LPDDjP', 'Department'),
(5729, 'YY28yYrNY2VQxSYq', 'Attachment'),
(2903, 'YZ6FoxrhyCi2rv9X', 'Field'),
(4746, 'z08CDCV3jjDSIp9L', 'Field'),
(615, 'z0EQDjSktc406vOk', 'User'),
(2937, 'z2a59UH4XK4wfu7B', 'Field'),
(9456, 'Z6yqCsJQA0BCusZw', 'Attachment'),
(11372, 'Z88oYIV3PIz3nDle', 'Competency'),
(9399, 'ZCtWO7UbTvuIbSBU', 'Truenorth_Summary'),
(312, 'ZdmeCcVUcC2RBKq1', 'Department'),
(6384, 'ZGOh3vW4OaX1eSBJ', 'Division'),
(2881, 'ZguAC2ejczkc8OLR', 'Field'),
(3846, 'zgYs51KDje6BKkXE', 'Field'),
(3849, 'ZjA6pzICbzKZPIPS', 'Field'),
(12480, 'zK4LpGzQA7hHfuoS', 'User'),
(4555, 'Zk8dfakUf8YSFv1Z', 'Competency'),
(2907, 'ZlPCrGzk2nEEhfO5', 'Field'),
(7041, 'zn98KnyW1vUerUKa', 'Division'),
(9942, 'zpEvMuvrIeFSGqYM', 'Truenorth_Summary'),
(4871, 'zsA4VUi4iuMOTJ4W', 'Reviewcycle'),
(5211, 'zSZvUweOkgmou56e', 'Department'),
(6150, 'ZZD2rgPV3SgQpqpi', 'Competency');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Matrix`
--

CREATE TABLE IF NOT EXISTS `tnng_Matrix` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Compiled Form matrix sections storage.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Northview_Templates`
--

CREATE TABLE IF NOT EXISTS `tnng_Northview_Templates` (
`aid` bigint(20) unsigned NOT NULL,
  `template_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Northview Templates';

--
-- Dumping data for table `tnng_Northview_Templates`
--

INSERT INTO `tnng_Northview_Templates` (`aid`, `template_id`) VALUES
(1, 'h1MK3R5mZpNkbUqA'),
(2, '8uSuaHFlqa2HglRO'),
(3, 'VvONYTE3MWs8n0kZ');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Objective`
--

CREATE TABLE IF NOT EXISTS `tnng_Objective` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `priority` char(2) DEFAULT NULL,
  `private` tinyint(3) DEFAULT NULL,
  `unassigned_obj` tinyint(3) DEFAULT NULL,
  `start` int(10) DEFAULT NULL,
  `due` int(10) DEFAULT NULL,
  `description` varchar(8192) DEFAULT NULL,
  `comment` varchar(8192) DEFAULT NULL,
  `user_id` char(20) DEFAULT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objective storage.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Objective_Strategy`
--

CREATE TABLE IF NOT EXISTS `tnng_Objective_Strategy` (
`aid` bigint(20) unsigned NOT NULL,
  `objective_id` char(16) NOT NULL,
  `strategy_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objective to Strategy one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property`
--

CREATE TABLE IF NOT EXISTS `tnng_Property` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `logo` varchar(256) DEFAULT NULL,
  `openUserView` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `restrictSt` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `restrictAsp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `code` int(10) DEFAULT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='Property storage.';

--
-- Dumping data for table `tnng_Property`
--

INSERT INTO `tnng_Property` (`aid`, `id`, `created`, `status`, `name`, `logo`, `openUserView`, `restrictSt`, `restrictAsp`, `code`, `cid`) VALUES
(11, '6S52uQJlCTevbxKO', 1463153512, 1, 'Embassy Suites La Quinta', '/uploads/pLPm8dcL5U95rboy-esla logo.jpg', 0, 0, 0, 4, '6v3sWTOdQ6KFK1Se');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Competency`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Competency` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `competency_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='Property to Competency one-to-many.';

--
-- Dumping data for table `tnng_Property_Competency`
--

INSERT INTO `tnng_Property_Competency` (`aid`, `property_id`, `competency_id`) VALUES
(4, '6S52uQJlCTevbxKO', 'xnBihqjHQHhUbkVk'),
(9, '6S52uQJlCTevbxKO', 'l5Y3PuzfQeSiywTw'),
(55, '6S52uQJlCTevbxKO', 'Mm4NXisjGWjzJAU9'),
(56, '6S52uQJlCTevbxKO', 'h2ky9BCLtDiUg6wU'),
(57, '6S52uQJlCTevbxKO', '5JQURaiI77jcLlvY'),
(58, '6S52uQJlCTevbxKO', 'aslMAF7Y9B4ECg0w'),
(59, '6S52uQJlCTevbxKO', 'uAx82aAfNY6WKE5M'),
(60, '6S52uQJlCTevbxKO', 'VMuqnbfBSNTjTJbf'),
(61, '6S52uQJlCTevbxKO', 'oMQPFFIMBDzVbjkz'),
(62, '6S52uQJlCTevbxKO', 'sC8FI1mbNTbvvovF');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Department`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Department` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `department_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COMMENT='Property to Department one-to-many.';

--
-- Dumping data for table `tnng_Property_Department`
--

INSERT INTO `tnng_Property_Department` (`aid`, `property_id`, `department_id`) VALUES
(16, '6S52uQJlCTevbxKO', '8R29qqbFSRdOjqFK'),
(68, '6S52uQJlCTevbxKO', 'Wv5ZKFo3U9NtG7mh'),
(83, '6S52uQJlCTevbxKO', 'o4YRbKCWDWdjvcvT'),
(84, '6S52uQJlCTevbxKO', '38MczPWsYfd9w58y'),
(85, '6S52uQJlCTevbxKO', 'vTRESqUJxh0noiz3'),
(86, '6S52uQJlCTevbxKO', 'u5RNkcTWC0oqKvnt'),
(87, '6S52uQJlCTevbxKO', '0j3nBtJ2096I4eqP'),
(88, '6S52uQJlCTevbxKO', 'bmvBGFb71wnMfND2'),
(89, '6S52uQJlCTevbxKO', 'wDHK3QYTlKFv8CdN'),
(90, '6S52uQJlCTevbxKO', 'peHsQnCozjzHj7pT');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Division`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Division` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `division_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='Property to Division one-to-many.';

--
-- Dumping data for table `tnng_Property_Division`
--

INSERT INTO `tnng_Property_Division` (`aid`, `property_id`, `division_id`) VALUES
(6, '6S52uQJlCTevbxKO', '3sTKN7cQdpkXLwNU'),
(8, '6S52uQJlCTevbxKO', 'BZNY3fKloIIBppNI'),
(10, '6S52uQJlCTevbxKO', 'sUzlXinZewyxfXe7'),
(11, '6S52uQJlCTevbxKO', 'JLd3vwVCDzuLGHPd'),
(34, '6S52uQJlCTevbxKO', 'qDmHlw8d7YzikmnS'),
(56, '6S52uQJlCTevbxKO', '5PzyX6qodYoofItG'),
(57, '6S52uQJlCTevbxKO', '4a7aVAyHc6SAqlRE'),
(58, '6S52uQJlCTevbxKO', 'wnv7c3hEFpQ97lOU'),
(59, '6S52uQJlCTevbxKO', 'olFKYXwnYwMlp2Tc');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Exclusions`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Exclusions` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `exclusion_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Competencies, Divisions and Departments to exclude from Properties.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Objective`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Objective` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `objective_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Property to Objective one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Reviewcycle`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Reviewcycle` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `reviewcycle_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='Property to Review Cycle one-to-many.';

--
-- Dumping data for table `tnng_Property_Reviewcycle`
--

INSERT INTO `tnng_Property_Reviewcycle` (`aid`, `property_id`, `reviewcycle_id`) VALUES
(5, 'gGW6XqU3PwIkWXbP', 'JpcYwp0FNG4hVv1G'),
(13, 'LM8gM4E3p49HNBtK', 'OjB7VVkPGo436jvN'),
(21, '6S52uQJlCTevbxKO', 'LAeiFdhKvtIHkWo9'),
(25, 'ayf63xmLCZC9xZJN', 'UxOIh9fTJqXk8WGg'),
(28, '6S52uQJlCTevbxKO', 'gqJv05oSdUCRC5mt'),
(32, '6S52uQJlCTevbxKO', 'NguRqN1gresypGv1'),
(36, 'ayf63xmLCZC9xZJN', 'U04k9uVJmo8qIorv'),
(40, 'ayf63xmLCZC9xZJN', '5ywWcQFZBARH3OWd'),
(44, 'ayf63xmLCZC9xZJN', 'HCA1EuamOwwl07u0'),
(48, 'ayf63xmLCZC9xZJN', 'zsA4VUi4iuMOTJ4W'),
(52, 'ayf63xmLCZC9xZJN', '5HcBPEhXRrYOdxfu'),
(56, 'ayf63xmLCZC9xZJN', 'rCxBBQV0VJgrItlT'),
(60, 'ayf63xmLCZC9xZJN', 'y6Oy4xvgdVu5zN8O'),
(64, 'ayf63xmLCZC9xZJN', 'q7Jz1aZDwSOmxbn8'),
(68, 'CoecBl7vDIgn7JAZ', 'ycoaBakwXVvdLAub'),
(72, 'CoecBl7vDIgn7JAZ', 'vdVSQ7xllVkTOggr'),
(76, 'CoecBl7vDIgn7JAZ', 'abBChaIoHMnsY6GK');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Strategy`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Strategy` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `strategy_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Property to Strategy one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_Templates`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_Templates` (
`aid` bigint(20) unsigned NOT NULL,
  `template_id` char(16) NOT NULL,
  `property_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Property Templates';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Property_User`
--

CREATE TABLE IF NOT EXISTS `tnng_Property_User` (
`aid` bigint(20) unsigned NOT NULL,
  `property_id` char(16) NOT NULL,
  `user_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Property to User one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Reviewcycle`
--

CREATE TABLE IF NOT EXISTS `tnng_Reviewcycle` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `description` varchar(8192) NOT NULL,
  `setup` text,
  `hourlies` varchar(256) DEFAULT NULL,
  `start` int(10) unsigned DEFAULT NULL,
  `due` int(10) unsigned DEFAULT NULL,
  `cid` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tnng_Reviewcycle`
--

INSERT INTO `tnng_Reviewcycle` (`aid`, `id`, `created`, `status`, `locked`, `name`, `description`, `setup`, `hourlies`, `start`, `due`, `cid`) VALUES
(11, '5HcBPEhXRrYOdxfu', 1450305261, 1, 1, 'Cycle5', 'DEsc 5', '{"me":[],"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1450305273, 1451545200, 'IphMs4uKYQz7hwyL'),
(8, '5ywWcQFZBARH3OWd', 1450304306, 1, 1, 'Test Cycle 2', 'Desc', '{"me":[],"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1450304317, 1451545200, 'IphMs4uKYQz7hwyL'),
(17, 'abBChaIoHMnsY6GK', 1454332672, 1, 1, 'test review cycle 2', 'test review cycle 2', '{"me":{"dddddddddddddddf":{"7WPW2XuvKVr7aV8f":"Test Form for Rating Key Header"}},"ae":{"dddddddddddddddf":{"jX0SjlA4ry34i7Kf":"test form"}},"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["NQrXkp5jBhARnraK","AbT3VGx5EFykHXVv"],"AbT3VGx5EFykHXVv":["7HbGiKRyQqfB0PqD"],"7HbGiKRyQqfB0PqD":["TTxieYv2BNjDA8v9","ED1DHK1dYU3wgY4H"],"ED1DHK1dYU3wgY4H":["HkFNrIsgJ55UYR1l","jqAh0T7fE7lgJAmc","WQQCGR8CPcmhMp25"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"],"NQrXkp5jBhARnraK":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS","AbT3VGx5EFykHXVv"]},"emailPeers":[]}', NULL, 1454332710, 1454265000, 'ULEyr7eayRZQTSXS'),
(5, 'gqJv05oSdUCRC5mt', 1449511785, 1, 0, 'Another Test Cycle', 'Cycle Desc', '{"me":{"dddddddddddddddd":{"3w8MZBUQwBIIt8mk":"F&B Manager"},"Hoq1O0djxHIu9jCz":{"RHNxKTlKuGznMt6r":"Operations Leader"}},"ae":{"dddddddddddddddd":{"w9IS5CTuqz9GeAkQ":"Culinary Review"}},"managers":{"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]}}', NULL, NULL, 1450854000, 'uuuuuuuuuuuuuuud'),
(9, 'HCA1EuamOwwl07u0', 1450304765, 1, 1, 'Test Cycle 2', 'Desc 2', '{"me":[],"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1450304803, 1451545200, 'IphMs4uKYQz7hwyL'),
(1, 'JpcYwp0FNG4hVv1G', 1411155861, 1, 0, 'Annual Review Cycle', 'Annual Reviews for Full-Time Associates', '{"me":{"eeeeeeeeeeeeeeem":{"RHNxKTlKuGznMt6r":"Operations Leader"}},"ae":[],"managers":{"ankusCJqBoo2cNvn":["ankusCJqBoo2cNvn","uuuuuuuuuuuuuuub","uuuuuuuuuuuuuuua","uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"],"IphMs4uKYQz7hwyL":["mkP7DPiLrzrSWzmp"],"mkP7DPiLrzrSWzmp":["aMgFYhF2duo54vge","dTvjwkjxpe32Tmob","gDf6fFqsPcQGf5PT","B6qh2C8VKM3bfJpp","Ufc2ulmSCNZjOLAy","kQ1eczFYasbljkZ8"],"dTvjwkjxpe32Tmob":["44Yg74KA8uBhau4i"],"Ufc2ulmSCNZjOLAy":["R0EHU2FnwSSXsjhk"],"44Yg74KA8uBhau4i":["ujiiwrqlXWLXhWj7"]},"peers":{"ankusCJqBoo2cNvn":["uuuuuuuuuuuuuuub","uuuuuuuuuuuuuuua","uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"],"uuuuuuuuuuuuuuub":["ankusCJqBoo2cNvn","uuuuuuuuuuuuuuua","uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"],"uuuuuuuuuuuuuuua":["ankusCJqBoo2cNvn","uuuuuuuuuuuuuuub","uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"],"uuuuuuuuuuuuuuud":["ankusCJqBoo2cNvn","uuuuuuuuuuuuuuub","uuuuuuuuuuuuuuua","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"],"uuuuuuuuuuuuuuuc":["ankusCJqBoo2cNvn","uuuuuuuuuuuuuuub","uuuuuuuuuuuuuuua","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"],"IphMs4uKYQz7hwyL":["ankusCJqBoo2cNvn","uuuuuuuuuuuuuuub","uuuuuuuuuuuuuuua","uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc"],"mkP7DPiLrzrSWzmp":["aMgFYhF2duo54vge"],"aMgFYhF2duo54vge":["mkP7DPiLrzrSWzmp"],"dTvjwkjxpe32Tmob":["mkP7DPiLrzrSWzmp","aMgFYhF2duo54vge","44Yg74KA8uBhau4i","gDf6fFqsPcQGf5PT","B6qh2C8VKM3bfJpp","Ufc2ulmSCNZjOLAy"]},"emailPeers":[]}', NULL, NULL, 1414728000, 'IphMs4uKYQz7hwyL'),
(3, 'LAeiFdhKvtIHkWo9', 1444845649, 1, 1, 'TestCycle', 'TestCycle', '{"me":{"dddddddddddddddd":{"pdtuAV5qXyVCH6xB":"TEST"},"5RMc7KvNjZtEU0MM":{"pdtuAV5qXyVCH6xB":"TEST"}},"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"]},"peers":{"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"],"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc"]},"emailPeers":{"uuuuuuuuuuuuuuud":["suresh.pandian@commerx.com"],"uuuuuuuuuuuuuuuc":["suresh.pandian@commerx.com"],"IphMs4uKYQz7hwyL":["suresh.pandian@commerx.com"]}}', NULL, 1444858109, 1444933800, 'uuuuuuuuuuuuuuud'),
(6, 'NguRqN1gresypGv1', 1449513433, 1, 1, 'Test Cycle Review', 'DEsc', '{"me":[],"ae":[],"managers":{"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1449513542, 1449730800, 'uuuuuuuuuuuuuuud'),
(2, 'OjB7VVkPGo436jvN', 1429813929, 1, 0, 'True North Hotel Test Review Cycle', 'This is a test review cycle', '{"me":{"dddddddddddddddd":{"q5ua0yeABOJQ07FS":"Operational Leader"},"dddddddddddddddf":{"q5ua0yeABOJQ07FS":"Operational Leader"},"dddddddddddddddh":{"q5ua0yeABOJQ07FS":"Operational Leader"},"yQwpm9oXLrXM4nTu":{"q5ua0yeABOJQ07FS":"Operational Leader"}},"ae":[],"managers":{"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","kOJ5ey7VPYE64yYy"]},"peers":{"uuuuuuuuuuuuuuud":["IphMs4uKYQz7hwyL","kOJ5ey7VPYE64yYy"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuud","kOJ5ey7VPYE64yYy"],"kOJ5ey7VPYE64yYy":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, NULL, 1443247200, 'uuuuuuuuuuuuuuud'),
(14, 'q7Jz1aZDwSOmxbn8', 1450307870, 1, 1, 'Cycle 10', 'DEsc', '{"me":{"dddddddddddddddd":{"3w8MZBUQwBIIt8mk":"F&B Manager"}},"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1450307881, 1451545200, 'IphMs4uKYQz7hwyL'),
(12, 'rCxBBQV0VJgrItlT', 1450305338, 1, 1, 'Cycle6', 'Desc6', '{"me":{"dddddddddddddddd":{"pdtuAV5qXyVCH6xB":"TEST"},"yQwpm9oXLrXM4nTu":{"duZvftTgB7oaniy2":"Test Review Form"}},"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":{"uuuuuuuuuuuuuuuc":["muhammad.moazzum@commerx.com"]}}', NULL, 1450305370, 1451545200, 'IphMs4uKYQz7hwyL'),
(7, 'U04k9uVJmo8qIorv', 1450304094, 1, 1, 'Test Cycle', 'Cycle Desc', '{"me":[],"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1450304115, 1451545200, 'IphMs4uKYQz7hwyL'),
(4, 'UxOIh9fTJqXk8WGg', 1446651115, 1, 1, 'new test cycle', 'new test cycle desc', '{"me":{"dddddddddddddddd":{"9ME38PPXR4HFNpV1":"Administrative Leader ","duZvftTgB7oaniy2":"Test Review Form"}},"ae":{"dddddddddddddddd":{"w9IS5CTuqz9GeAkQ":"Culinary Review","laF4VrJPNP5vKnCa":"Culinary","jX0SjlA4ry34i7Kf":"test form"}},"managers":{"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"]},"peers":{"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL"],"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuud","uuuuuuuuuuuuuuuc"]},"emailPeers":[]}', NULL, 1446651143, 1448562600, 'uuuuuuuuuuuuuuud'),
(16, 'vdVSQ7xllVkTOggr', 1454332186, 1, 1, 'test review cycle 1', 'test review cycle 1', '{"me":{"dddddddddddddddd":{"7WPW2XuvKVr7aV8f":"Test Form for Rating Key Header"}},"ae":{"dddddddddddddddd":{"jX0SjlA4ry34i7Kf":"test form"}},"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["NQrXkp5jBhARnraK","AbT3VGx5EFykHXVv"],"AbT3VGx5EFykHXVv":["7HbGiKRyQqfB0PqD"],"7HbGiKRyQqfB0PqD":["TTxieYv2BNjDA8v9","ED1DHK1dYU3wgY4H"],"ED1DHK1dYU3wgY4H":["HkFNrIsgJ55UYR1l","jqAh0T7fE7lgJAmc","WQQCGR8CPcmhMp25"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"],"NQrXkp5jBhARnraK":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS","AbT3VGx5EFykHXVv"],"AbT3VGx5EFykHXVv":["NQrXkp5jBhARnraK"]},"emailPeers":[]}', NULL, 1454332249, 1454351400, 'ULEyr7eayRZQTSXS'),
(13, 'y6Oy4xvgdVu5zN8O', 1450307776, 1, 1, 'Cycle 9', 'Cycle 9', '{"me":[],"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1450307790, 1451545200, 'IphMs4uKYQz7hwyL'),
(15, 'ycoaBakwXVvdLAub', 1453998079, 1, 1, 'New Review Cycle', 'New Review Cycle', '{"me":{"LiOB5hazAInZANyn":{"3w8MZBUQwBIIt8mk":"F&B Manager","7WPW2XuvKVr7aV8f":"Test Form for Rating Key Header"}},"ae":{"LiOB5hazAInZANyn":{"jX0SjlA4ry34i7Kf":"test form"}},"managers":{"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","NQrXkp5jBhARnraK","AbT3VGx5EFykHXVv","7HbGiKRyQqfB0PqD","HkFNrIsgJ55UYR1l","jqAh0T7fE7lgJAmc","WQQCGR8CPcmhMp25"],"uuuuuuuuuuuuuuuc":["ULEyr7eayRZQTSXS"],"7HbGiKRyQqfB0PqD":["TTxieYv2BNjDA8v9","ED1DHK1dYU3wgY4H"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"],"NQrXkp5jBhARnraK":["AbT3VGx5EFykHXVv"],"AbT3VGx5EFykHXVv":["NQrXkp5jBhARnraK"]},"emailPeers":[]}', NULL, 1453998163, 1454178600, 'ULEyr7eayRZQTSXS'),
(10, 'zsA4VUi4iuMOTJ4W', 1450305136, 1, 1, 'Test Cycle 3', 'Cycle 3', '{"me":[],"ae":[],"managers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"]},"peers":{"uuuuuuuuuuuuuuuc":["uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"uuuuuuuuuuuuuuud":["uuuuuuuuuuuuuuuc","IphMs4uKYQz7hwyL","ULEyr7eayRZQTSXS"],"IphMs4uKYQz7hwyL":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","ULEyr7eayRZQTSXS"],"ULEyr7eayRZQTSXS":["uuuuuuuuuuuuuuuc","uuuuuuuuuuuuuuud","IphMs4uKYQz7hwyL"]},"emailPeers":[]}', NULL, 1450305147, 1451545200, 'IphMs4uKYQz7hwyL');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Static`
--

CREATE TABLE IF NOT EXISTS `tnng_Static` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `content` varchar(8192) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Compiled Form static sections storage.';

--
-- Dumping data for table `tnng_Static`
--

INSERT INTO `tnng_Static` (`aid`, `id`, `created`, `status`, `name`, `content`, `active`, `locked`, `cid`) VALUES
(9, '5pc8UsZXVN2obyzp', 1430241492, 1, 'RATING KEY', '<h1>RATING KEY</h1>\r\n<p>5 Outstanding - Consistently exceeds job expectations and is recognized as a leader and role model</p>\r\n<p>4 Above Expectations - Consistently meets and often exceeds job expectations</p>\r\n<p>3 Meets Expectations - Consistently meets expectations</p>\r\n<p>2 Below Expectations - Occasionally fails to meet job expectations</p>\r\n<p>1 Unacceptable - Consistently failes to meet job expectations, on performance improvement plan</p>\r\n<p> </p>\r\n<p> </p>', 0, 0, 'IphMs4uKYQz7hwyL'),
(10, '6HWzl3gh5dA67C61', 1439586864, 1, 'sdfsdfsf', '', 0, 0, 'uuuuuuuuuuuuuuud'),
(5, '6UdIxDvWm6RSrav7', 1398803316, 1, 'TEST', '<p>TEST</p>', 0, 0, 'uuuuuuuuuuuuuuud'),
(11, 'AC7c93ASlRXCBGMA', 1453998295, 1, 'TEST', '', 0, 0, 'ULEyr7eayRZQTSXS'),
(8, 'FJAVkbVPZlXHrumD', 1429551512, 1, 'Test Static', '<p>Testing</p>', 0, 0, 'uuuuuuuuuuuuuuud'),
(1, 'jFF3qoQgjph59w7t', 1398797452, 1, '', '', 0, 0, 'IphMs4uKYQz7hwyL'),
(3, 'lAnA5JBzhepw3M43', 1398801184, 1, 'STATIC ', '<p>Blah, Blah</p>', 0, 0, 'IphMs4uKYQz7hwyL'),
(4, 'mOnBGkeN8yFi2Q32', 1398801450, 1, 'STATIC', 'TESTING', 0, 0, 'IphMs4uKYQz7hwyL'),
(7, 'PpZRU7uk05kx1N0B', 1425696489, 1, 'Rating Key', '<p>Use this rating as a guideline</p>\r\n<ol>\r\n<li>Unacceptable - Consistently fails to meet job expectations and performance improvement is required</li>\r\n<li>Below Expectations - Occasionally fails to meet job expectations</li>\r\n<li>Meets Expectations - Consistently meets job expectations</li>\r\n<li>Above Expectations - Consistently meets and occasionally exceeds job expectations</li>\r\n<li>Outstanding - Consistently exceeds job expectations and is recoqnized as a leader and role model</li>\r\n</ol>', 0, 0, 'uuuuuuuuuuuuuuud'),
(2, 'PvuVQzw0E1KgpAtK', 1398797472, 1, '', '', 0, 0, 'IphMs4uKYQz7hwyL'),
(6, 'qEcU1LQxZamaCePF', 1425696403, 1, 'Rating Key', '<p>Use this rating as a guideline</p>\r\n<ol>\r\n<li>Unacceptable - Consistently fails to meet job expectations and performance improvement is required</li>\r\n<li>Below Expectations - Occasionally fails to meet job expectations</li>\r\n<li>Meets Expectations - Consistently meets job expectations</li>\r\n<li>Above Expectations - Consistently meets and occasionally exceeds job expectations</li>\r\n<li>Outstanding - Consistently exceeds job expectations and is recoqnized as a leader and role model</li>\r\n</ol>', 0, 0, 'uuuuuuuuuuuuuuud');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Strategy`
--

CREATE TABLE IF NOT EXISTS `tnng_Strategy` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `priority` char(2) DEFAULT NULL,
  `private` tinyint(3) DEFAULT NULL,
  `unassigned_strategy` tinyint(4) DEFAULT NULL,
  `start` int(10) DEFAULT NULL,
  `due` int(10) DEFAULT NULL,
  `complete` int(10) DEFAULT NULL,
  `description` varchar(8192) DEFAULT NULL,
  `comment` varchar(8192) DEFAULT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Strategy storage.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Strategy_Tactic`
--

CREATE TABLE IF NOT EXISTS `tnng_Strategy_Tactic` (
`aid` bigint(20) unsigned NOT NULL,
  `strategy_id` char(16) NOT NULL,
  `tactic_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Strategy to Tactic one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Subevaluation`
--

CREATE TABLE IF NOT EXISTS `tnng_Subevaluation` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `description` varchar(8192) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `evaltype` varchar(16) NOT NULL,
  `self` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `manager` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `peer` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cummulation` varchar(256) DEFAULT NULL,
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='Subevaluation Form storage.';

--
-- Dumping data for table `tnng_Subevaluation`
--

INSERT INTO `tnng_Subevaluation` (`aid`, `id`, `created`, `status`, `name`, `description`, `active`, `evaltype`, `self`, `manager`, `peer`, `cummulation`, `locked`, `cid`) VALUES
(17, '7JnbmCD4jWimcEhI', 1430326487, 1, 'True North Objectives', 'First section of a manager''s evaluation', 0, 'me', 1, 1, 0, 'none', 0, 'IphMs4uKYQz7hwyL'),
(8, '7mgvh9YZyMlnEi3t', 1425694807, 1, 'Culinary', 'Annual Performance Review for Culinary Associates', 0, 'ae', 0, 0, 0, 'culture', 1, 'uuuuuuuuuuuuuuud'),
(2, 'Aoz65J6vUL0TCv82', 1403021630, 0, 'TEST', 'TEST', 0, 'me', 0, 1, 0, 'results', 0, 'uuuuuuuuuuuuuuud'),
(18, 'DkY1KuVFktAFZ2gj', 1432842054, 1, 'Administration Leader', 'This is the first section under True North Objectives. This does not part of the Result/Culture Matrix calculation.', 0, 'me', 1, 1, 0, 'none', 1, 'uuuuuuuuuuuuuuud'),
(5, 'DzBCNDn7vmWFJyBe', 1411155373, 0, 'Operations Leader', 'Leads an Operating Department', 0, 'me', 1, 1, 0, 'none', 0, 'IphMs4uKYQz7hwyL'),
(15, 'flUsMFjP7r44ZrRp', 1429551446, 0, 'Test', 'Test', 0, 'me', 0, 0, 1, 'results', 0, 'uuuuuuuuuuuuuuud'),
(16, 'hIfVhxAgLtrlxSpT', 1430240852, 0, 'Rating Key Header', 'The first section of all compiled reviews to remind leaders to understand what it takes to achieve a Meets, Above, or Outstanding Evaluation', 0, 'me', 0, 0, 0, NULL, 0, 'IphMs4uKYQz7hwyL'),
(6, 'HJ7UjNAfjNbad5MJ', 1411156602, 0, 'True North Objectives', 'This is the first section of a Leadership Evaluation', 0, 'me', 1, 1, 0, 'none', 0, 'IphMs4uKYQz7hwyL'),
(20, 'IVpb3qKWFU1N2mgw', 1432843145, 1, 'Administrative Leader ', 'This is the 3rd section under Culture (Northview Guiding Principles).', 0, 'me', 1, 1, 0, 'culture', 1, 'uuuuuuuuuuuuuuud'),
(14, 'KlDcrao4SLd8haY2', 1425696201, 1, 'Overall Comments', 'Overall Comments', 0, 'me', 1, 1, 0, 'none', 0, 'uuuuuuuuuuuuuuud'),
(11, 'MExeEeX2jXBZpYml', 1425674017, 0, 'Manager’s Results Comments ', 'Manager’s Results Comments ', 0, 'ae', 0, 1, 0, 'none', 0, 'uuuuuuuuuuuuuuud'),
(3, 'oK6SDp4oZnubrUMU', 1417544168, 0, 'Operations Leader', 'True North Objectives', 0, 'me', 1, 1, 0, 'results', 0, 'uuuuuuuuuuuuuuud'),
(22, 'QFs0CIeULeQ228iA', 1454004906, 0, 'test', 'test', 0, 'me', 1, 1, 0, 'culture', 0, 'NQrXkp5jBhARnraK'),
(13, 'QVyydegcqMxLCdNo', 1425696102, 1, 'Operational Leader', 'Operational Leader', 0, 'me', 1, 1, 0, 'culture', 1, 'uuuuuuuuuuuuuuud'),
(4, 't3IR2j9erTxRvrrZ', 1411155267, 0, 'Operations Leader', 'Leader of Operating Department', 0, 'me', 0, 0, 1, 'culture', 0, 'IphMs4uKYQz7hwyL'),
(10, 't5tohEzVUuc5CHXm', 1425673827, 0, 'Manager''s Culture Comments', 'Manager''s Culture Comments', 0, 'ae', 0, 1, 0, 'none', 0, 'uuuuuuuuuuuuuuud'),
(1, 'tre5eyTz482GcI3d', 1398801327, 0, 'Culinary', 'Review for Cook', 0, 'ae', 0, 1, 0, 'culture', 0, 'IphMs4uKYQz7hwyL'),
(9, 'TVYBihT5HgYSfp9c', 1425673484, 1, 'Additional Comments', 'Additional Comments', 0, 'ae', 0, 0, 0, 'none', 1, 'uuuuuuuuuuuuuuud'),
(21, 'WFlBnAvjGXkLdjTV', 1432843221, 1, 'Overall Comments', 'Generic comments section', 0, 'me', 1, 1, 0, 'none', 1, 'uuuuuuuuuuuuuuud'),
(19, 'Xtmc3ymd2kumJW87', 1432842360, 1, 'Administrative Leader', 'This is the second section under Results.', 0, 'me', 1, 1, 0, 'results', 1, 'uuuuuuuuuuuuuuud'),
(7, 'Y5GeTWjG1Nl4nLSJ', 1425694737, 1, 'Culinary', 'Annual Performance Review for Culinary Associates', 0, 'ae', 0, 0, 0, 'results', 1, 'uuuuuuuuuuuuuuud'),
(12, 'ynRGTgQABNkApOAU', 1454002944, 1, 'Operational Leader', 'Operational Leader', 0, 'me', 0, 0, 1, 'culture', 0, 'ULEyr7eayRZQTSXS');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Subevaluation_Components`
--

CREATE TABLE IF NOT EXISTS `tnng_Subevaluation_Components` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `subevaluation_id` char(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(8192) NOT NULL,
  `type` varchar(64) NOT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Subevaluation Form Component storage.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Subevaluation_Field`
--

CREATE TABLE IF NOT EXISTS `tnng_Subevaluation_Field` (
`aid` bigint(20) unsigned NOT NULL,
  `Subevaluation_id` char(16) NOT NULL,
  `Field_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tnng_Subevaluation_Field`
--

INSERT INTO `tnng_Subevaluation_Field` (`aid`, `Subevaluation_id`, `Field_id`) VALUES
(3, 'tre5eyTz482GcI3d', 'jR8Bx05TQ8yq8tCd'),
(4, 'tre5eyTz482GcI3d', 'UWtB7EZqvQGI4ahx'),
(5, 'Aoz65J6vUL0TCv82', 'cpm3COw1JdG7SJFO'),
(10, 't3IR2j9erTxRvrrZ', 'vMmFxgCpvgukYtUi'),
(11, 'DzBCNDn7vmWFJyBe', 'eUCdsj6K99MGwbuv'),
(14, 'HJ7UjNAfjNbad5MJ', 'wyadxJzfzzdSK5zl'),
(15, 'oK6SDp4oZnubrUMU', 'gvZnbXeUTBhvDlSH'),
(16, 'oK6SDp4oZnubrUMU', 'K11er7NneYfHFggB'),
(39, 'TVYBihT5HgYSfp9c', 'w83wzhrV3P9UGhpk'),
(40, 'TVYBihT5HgYSfp9c', 'rzzTUdOm2PX9Ik95'),
(41, 'TVYBihT5HgYSfp9c', 'qrAdjOgaP5UN1sMu'),
(42, 'TVYBihT5HgYSfp9c', 'lQloxZPrXDsy9YLS'),
(44, 't5tohEzVUuc5CHXm', 'XLeqpV1USMCE2vzY'),
(45, 'MExeEeX2jXBZpYml', 'lKAu6IVef6GxRijA'),
(62, 'Y5GeTWjG1Nl4nLSJ', 'M1iwBRSzdoMPUzVU'),
(63, 'Y5GeTWjG1Nl4nLSJ', 'pDdQWSfGbDxp9zMU'),
(64, 'Y5GeTWjG1Nl4nLSJ', '1WkEbO3HYVkeTqEv'),
(65, 'Y5GeTWjG1Nl4nLSJ', 'FgpaVrtBJ6xUXcmN'),
(66, 'Y5GeTWjG1Nl4nLSJ', 'SMY6AlUBRZYoHYBn'),
(67, 'Y5GeTWjG1Nl4nLSJ', 'yN2rJqxDDoWx3VyO'),
(68, '7mgvh9YZyMlnEi3t', 'YZ6FoxrhyCi2rv9X'),
(69, '7mgvh9YZyMlnEi3t', 'oPTrxzX4JyPtrGzx'),
(70, '7mgvh9YZyMlnEi3t', 'G8X7ipy6XShhdKaR'),
(71, '7mgvh9YZyMlnEi3t', 'yIoLES0ZA5K0cmpM'),
(72, '7mgvh9YZyMlnEi3t', 'ZlPCrGzk2nEEhfO5'),
(73, '7mgvh9YZyMlnEi3t', 'pkDjmdOGVV7Ff3pI'),
(74, 'QVyydegcqMxLCdNo', 'Se20ApfxjAFEvqI4'),
(75, 'QVyydegcqMxLCdNo', 'LQ3kdjqEpVjdDdCg'),
(76, 'QVyydegcqMxLCdNo', 'O95REb5EqKLzfsMt'),
(77, 'QVyydegcqMxLCdNo', 'KopsM1x4dqFSbp5E'),
(78, 'QVyydegcqMxLCdNo', 'gcxG6cXZodJ0rBmW'),
(79, 'QVyydegcqMxLCdNo', 'TJaHqwpOrqzT4bil'),
(80, 'QVyydegcqMxLCdNo', 'z2a59UH4XK4wfu7B'),
(81, 'QVyydegcqMxLCdNo', 'RhUItGZWvuB2gfRt'),
(82, 'QVyydegcqMxLCdNo', 'RIFT7TtaGpelPeG8'),
(83, 'KlDcrao4SLd8haY2', 'NZkL8qXRDNKKiSU4'),
(84, 'KlDcrao4SLd8haY2', 'aZKq1unDaN2Lh5R8'),
(85, 'KlDcrao4SLd8haY2', 'NEytAQ9ugDjWlZ8T'),
(86, 'KlDcrao4SLd8haY2', '4my2qSxD1Ds4HA3v'),
(93, 'flUsMFjP7r44ZrRp', 'CmtlwbxHlk35sJhH'),
(94, 'flUsMFjP7r44ZrRp', 'IvMAibwRQz6OSs0O'),
(95, 'hIfVhxAgLtrlxSpT', 'XwvSeqICdTlyY8C8'),
(98, '7JnbmCD4jWimcEhI', 'NwTCCINrxto8jplb'),
(99, 'DkY1KuVFktAFZ2gj', 'muLkIQnOB28ZqXu9'),
(100, 'DkY1KuVFktAFZ2gj', 'umuRazGkiGp4LJGO'),
(101, 'DkY1KuVFktAFZ2gj', 'ONUbE6saA9F6m4Qf'),
(102, 'DkY1KuVFktAFZ2gj', 'ratM6s1pK3KM6h1X'),
(103, 'DkY1KuVFktAFZ2gj', 'pmPAJDIi1er0cgCS'),
(110, 'Xtmc3ymd2kumJW87', 'r6DI8iWMWqWZx6dJ'),
(111, 'Xtmc3ymd2kumJW87', 'PfQuLiN0QJPPrZtp'),
(112, 'Xtmc3ymd2kumJW87', 'LPMfR6QdXhf0juRI'),
(113, 'Xtmc3ymd2kumJW87', 'mrtSviGDHYCvqlXY'),
(114, 'Xtmc3ymd2kumJW87', 'OmgOIai3w2hJz88D'),
(115, 'Xtmc3ymd2kumJW87', 'pCK4pvzYsEFkXa7d'),
(126, 'IVpb3qKWFU1N2mgw', 'wJKCLP3FEf44ag8O'),
(127, 'IVpb3qKWFU1N2mgw', 'wzcgBBpkuNzIZj9X'),
(128, 'IVpb3qKWFU1N2mgw', '0i46y7RftXCh5VN9'),
(129, 'IVpb3qKWFU1N2mgw', 'dQQfIilrlclKal5h'),
(130, 'IVpb3qKWFU1N2mgw', 'CKMuopHPXVkFZcRS'),
(131, 'IVpb3qKWFU1N2mgw', '0JJgGG5Z36GWz0fS'),
(132, 'IVpb3qKWFU1N2mgw', 'zgYs51KDje6BKkXE'),
(133, 'IVpb3qKWFU1N2mgw', 'QVvlMKkdC7dFhCS3'),
(134, 'IVpb3qKWFU1N2mgw', '3wgSjpHV8zOZfSR0'),
(135, 'IVpb3qKWFU1N2mgw', 'ZjA6pzICbzKZPIPS'),
(136, 'WFlBnAvjGXkLdjTV', 'xAP2MDHQXnVaLLWl'),
(137, 'WFlBnAvjGXkLdjTV', '8PPSv7ODT4SBcOpV'),
(138, 'WFlBnAvjGXkLdjTV', 'y0bpXK8XWdG4F2Dn'),
(139, 'WFlBnAvjGXkLdjTV', 'Lp8MBNd2u2bhuHo8'),
(140, 'ynRGTgQABNkApOAU', 'oHzd0Ey2m3dYg0Ny'),
(141, 'ynRGTgQABNkApOAU', 'bCvT3slC7f7Wgtrt'),
(142, 'ynRGTgQABNkApOAU', 'kIP9sWT8718lQtyq'),
(143, 'ynRGTgQABNkApOAU', 'dYGwDieOigApVxQf'),
(144, 'ynRGTgQABNkApOAU', '0nRNUUhyJp1mEcd5'),
(145, 'ynRGTgQABNkApOAU', 'ND7VJMPUgcM5AAXW');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Tactic`
--

CREATE TABLE IF NOT EXISTS `tnng_Tactic` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `due` int(10) DEFAULT NULL,
  `complete` int(10) DEFAULT NULL,
  `description` varchar(8192) DEFAULT NULL,
  `comment` varchar(8192) DEFAULT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tactic storage.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Templates`
--

CREATE TABLE IF NOT EXISTS `tnng_Templates` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(8192) DEFAULT NULL,
  `path` varchar(256) NOT NULL,
  `mime` varchar(256) NOT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Templates_Location`
--

CREATE TABLE IF NOT EXISTS `tnng_Templates_Location` (
`aid` bigint(20) unsigned NOT NULL,
  `template_id` char(16) NOT NULL,
  `property_id` char(16) NOT NULL,
  `division_id` char(16) NOT NULL,
  `department_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Toolbox`
--

CREATE TABLE IF NOT EXISTS `tnng_Toolbox` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `folder_id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(8192) DEFAULT NULL,
  `path` varchar(256) DEFAULT NULL,
  `mime` varchar(256) NOT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tnng_Truenorth_Summary`
--

CREATE TABLE IF NOT EXISTS `tnng_Truenorth_Summary` (
`id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `property_id` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tnng_Truenorth_Summary`
--

INSERT INTO `tnng_Truenorth_Summary` (`id`, `user_id`, `property_id`, `created`) VALUES
(1, 'ULEyr7eayRZQTSXS', '6S52uQJlCTevbxKO', '2016-05-19 19:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_User`
--

CREATE TABLE IF NOT EXISTS `tnng_User` (
`aid` bigint(20) unsigned NOT NULL,
  `id` char(16) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `last` int(10) unsigned DEFAULT NULL,
  `remember` char(49) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `password` char(60) NOT NULL,
  `key` char(16) NOT NULL,
  `passwordreset` char(32) DEFAULT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `competencies` longtext,
  `supervisor` varchar(40) DEFAULT NULL,
  `cid` char(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COMMENT='User storage.';

--
-- Dumping data for table `tnng_User`
--

INSERT INTO `tnng_User` (`aid`, `id`, `created`, `status`, `last`, `remember`, `username`, `password`, `key`, `passwordreset`, `firstname`, `lastname`, `competencies`, `supervisor`, `cid`) VALUES
(92, '6v3sWTOdQ6KFK1Se', 1462282982, 1, 1463074029, NULL, 'C2Consulting2016@outlook.com', '$2a$10$QmhuemdKfSMcNRlLRA0NZ.9c.jfOYU2Pthd1L3cwue4BOwU0dOmUW', '', 'L6e3pBhtDaRY0vDPAMpSCwBPzjIyqGU9', 'C2', 'Consulting', 'a:0:{}', 'IphMs4uKYQz7hwyL', '6v3sWTOdQ6KFK1Se'),
(39, 'ULEyr7eayRZQTSXS', 1463685573, 1, 1463685837, NULL, 'suresh.pandian@commerx.com', '$2a$10$iPWrBasRrdx0.hVoRAlgSO9XLUB0ax3u/WxSiQZCWJFxmPSi8P4uu', '', 'VrqFwxCKGPD6euOkFnKK3Ffu0GU7RhdY', 'suresh', 'pandian', 'a:17:{i:0;s:16:"jd4wnDEHphNJyzUX";i:1;s:16:"W9WKKfoxlwLjwA3w";i:2;s:16:"ZZD2rgPV3SgQpqpi";i:3;s:16:"W3aWnYC6bDtUN2hd";i:4;s:16:"JswuxhBQg4s3N86J";i:5;s:16:"8p8PGrrby90hFUce";i:6;s:16:"6eGRzhjtl9IfFJRd";i:7;s:16:"mPMbpuO0T9MK78Gr";i:8;s:16:"OaZpvgDv1Eyyyv7O";i:9;s:16:"QETsnWp6ild7nGHy";i:10;s:16:"q4ibgrIBmMKworhv";i:11;s:16:"u5D98PBfczzJOO9J";i:12;s:16:"jd4wnDEHphNJyzUX";i:13;s:16:"W9WKKfoxlwLjwA3w";i:14;s:16:"ZZD2rgPV3SgQpqpi";i:15;s:16:"W3aWnYC6bDtUN2hd";i:16;s:16:"JswuxhBQg4s3N86J";}', '', 'ULEyr7eayRZQTSXS'),
(3, 'uuuuuuuuuuuuuuuc', 1461614402, 1, 1462993430, NULL, 'muhammad@commerx.com', '$2a$10$fLbYSETIWJmFzcwGehxgNeuTg5KyRIT25MqIyU9xtRp2UEY/bTXpe', '', NULL, 'Muhammad', 'Moazzum', 'a:22:{i:0;s:16:"jd4wnDEHphNJyzUX";i:1;s:16:"W9WKKfoxlwLjwA3w";i:2;s:16:"8p8PGrrby90hFUce";i:3;s:16:"6eGRzhjtl9IfFJRd";i:4;s:16:"mPMbpuO0T9MK78Gr";i:5;s:16:"OaZpvgDv1Eyyyv7O";i:6;s:16:"QETsnWp6ild7nGHy";i:7;s:16:"q4ibgrIBmMKworhv";i:8;s:16:"u5D98PBfczzJOO9J";i:9;s:16:"ZZD2rgPV3SgQpqpi";i:10;s:16:"W3aWnYC6bDtUN2hd";i:11;s:16:"JswuxhBQg4s3N86J";i:12;s:16:"8p8PGrrby90hFUce";i:13;s:16:"6eGRzhjtl9IfFJRd";i:14;s:16:"mPMbpuO0T9MK78Gr";i:15;s:16:"OaZpvgDv1Eyyyv7O";i:16;s:16:"QETsnWp6ild7nGHy";i:17;s:16:"q4ibgrIBmMKworhv";i:18;s:16:"u5D98PBfczzJOO9J";i:19;s:16:"ZZD2rgPV3SgQpqpi";i:20;s:16:"W3aWnYC6bDtUN2hd";i:21;s:16:"JswuxhBQg4s3N86J";}', 'uuuuuuuuuuuuuuud', 'uuuuuuuuuuuuuuuc');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_User_Competency`
--

CREATE TABLE IF NOT EXISTS `tnng_User_Competency` (
`aid` bigint(20) unsigned NOT NULL,
  `user_id` char(16) NOT NULL,
  `competency_id` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User to Competency one-to-many.';

-- --------------------------------------------------------

--
-- Table structure for table `tnng_User_Role`
--

CREATE TABLE IF NOT EXISTS `tnng_User_Role` (
`aid` bigint(20) unsigned NOT NULL,
  `user_id` char(16) NOT NULL,
  `role_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8 COMMENT='User to Role one-to-one.';

--
-- Dumping data for table `tnng_User_Role`
--

INSERT INTO `tnng_User_Role` (`aid`, `user_id`, `role_id`) VALUES
(2, 'uuuuuuuuuuuuuuub', 'rrrrrrrrrrrrrrrg'),
(6, 'OL0diB7ZaGu4qxdY', 'rrrrrrrrrrrrrrrf'),
(7, 'mkP7DPiLrzrSWzmp', 'rrrrrrrrrrrrrrrf'),
(8, 'ankusCJqBoo2cNvn', 'rrrrrrrrrrrrrrrg'),
(9, 'aMgFYhF2duo54vge', 'rrrrrrrrrrrrrrrf'),
(10, 'B6qh2C8VKM3bfJpp', 'rrrrrrrrrrrrrrre'),
(11, 'Ufc2ulmSCNZjOLAy', 'rrrrrrrrrrrrrrre'),
(14, 'kQ1eczFYasbljkZ8', 'rrrrrrrrrrrrrrre'),
(15, 'R0EHU2FnwSSXsjhk', 'rrrrrrrrrrrrrrrd'),
(16, '44Yg74KA8uBhau4i', 'rrrrrrrrrrrrrrre'),
(17, 'dTvjwkjxpe32Tmob', 'rrrrrrrrrrrrrrre'),
(20, 'z0EQDjSktc406vOk', 'rrrrrrrrrrrrrrrf'),
(21, 'RH7uPk34PoFvNYBg', 'rrrrrrrrrrrrrrrf'),
(22, 'ujiiwrqlXWLXhWj7', 'rrrrrrrrrrrrrrrc'),
(23, 'gDf6fFqsPcQGf5PT', 'rrrrrrrrrrrrrrre'),
(24, 'FLZjgzjqtkmnz47n', 'rrrrrrrrrrrrrrrg'),
(25, 'uuuuuuuuuuuuuuua', 'rrrrrrrrrrrrrrrg'),
(26, 'kOJ5ey7VPYE64yYy', 'rrrrrrrrrrrrrrrd'),
(29, 'lbghcnIhr5OgNBUG', 'rrrrrrrrrrrrrrre'),
(31, 'u5r6wBkOxwOmcv3e', 'rrrrrrrrrrrrrrrf'),
(33, '4EH4sjFb5UVtim5G', 'rrrrrrrrrrrrrrrf'),
(34, 'QMQYZO7z6oSwwDJA', 'rrrrrrrrrrrrrrre'),
(38, 'X86ixqXZ0eVIAV5J', 'rrrrrrrrrrrrrrrf'),
(44, 'NYhZ01IjjaPnwcrj', 'rrrrrrrrrrrrrrrf'),
(49, 'cYfHZW8daDZcNRR6', 'rrrrrrrrrrrrrrre'),
(50, 'Yn8oAaAPEWtuNRLK', 'rrrrrrrrrrrrrrrg'),
(56, 'ED1DHK1dYU3wgY4H', 'rrrrrrrrrrrrrrrd'),
(57, 'AbT3VGx5EFykHXVv', 'rrrrrrrrrrrrrrrf'),
(80, 'NQrXkp5jBhARnraK', 'rrrrrrrrrrrrrrrf'),
(81, '7HbGiKRyQqfB0PqD', 'rrrrrrrrrrrrrrre'),
(82, 'TTxieYv2BNjDA8v9', 'rrrrrrrrrrrrrrrd'),
(83, 'jqAh0T7fE7lgJAmc', 'rrrrrrrrrrrrrrrc'),
(84, 'WQQCGR8CPcmhMp25', 'rrrrrrrrrrrrrrrb'),
(85, '4mXcduNoo86aRTZz', 'rrrrrrrrrrrrrrra'),
(88, 'F3kJVZc3z4VXiah5', 'rrrrrrrrrrrrrrrd'),
(89, 'u4krn4HPGRIbMcnL', 'rrrrrrrrrrrrrrre'),
(99, 'HkFNrIsgJ55UYR1l', 'rrrrrrrrrrrrrrrc'),
(111, 'vu0nzqabfE2O1o0v', 'rrrrrrrrrrrrrrrd'),
(113, '3v6QWuJ9wCNLs04o', 'rrrrrrrrrrrrrrre'),
(115, 'XgI2wplUYnshSmSJ', 'rrrrrrrrrrrrrrrb'),
(117, 'JG8UrQJX0DmmK2fB', 'rrrrrrrrrrrrrrrb'),
(118, 'nFh94MBY7gf3xaPX', 'rrrrrrrrrrrrrrrc'),
(119, 'wksigFQajUgrRcTG', 'rrrrrrrrrrrrrrrb'),
(121, 'jJKKAis87EOQfTCR', 'rrrrrrrrrrrrrrrf'),
(123, 'OmcSIBDOjWqLW5lr', 'rrrrrrrrrrrrrrre'),
(124, 'OlJCrkatouaOUopQ', 'rrrrrrrrrrrrrrre'),
(125, 'bxLHSr2l7EBqyqQ6', 'rrrrrrrrrrrrrrre'),
(128, 'bA98L50mp4hoaAk9', 'rrrrrrrrrrrrrrre'),
(135, 'OBlNcCK666sVtmUl', 'rrrrrrrrrrrrrrrd'),
(136, 'umsLXLhwokTjjkyA', 'rrrrrrrrrrrrrrrd'),
(137, 'HxAuhH11h9KIv5kH', 'rrrrrrrrrrrrrrrd'),
(138, '3IJrNb8bubNMiBdm', 'rrrrrrrrrrrrrrrd'),
(139, 'dGGFbURvO97wJmfd', 'rrrrrrrrrrrrrrrd'),
(157, 'Oqj2sSqbuWCbpvVH', 'rrrrrrrrrrrrrrrc'),
(164, 'BiqDlFyeM552tyHW', 'rrrrrrrrrrrrrrrf'),
(165, 'uTRz20AthiCF18Vz', 'rrrrrrrrrrrrrrrb'),
(166, 'U9ZBBXDnirEMhwkK', 'rrrrrrrrrrrrrrrd'),
(182, '57u9ZA06EOR3BaSb', 'rrrrrrrrrrrrrrrg'),
(188, 'uuuuuuuuuuuuuuud', 'rrrrrrrrrrrrrrrg'),
(190, 'dMSucxPaex7wH1jC', 'rrrrrrrrrrrrrrrd'),
(191, 'kUKdP1fg6nUZVt4R', 'rrrrrrrrrrrrrrrf'),
(192, '5LTemdkXB5lNu79s', 'rrrrrrrrrrrrrrrf'),
(193, '4PYYA0jRXUDv4ItT', 'rrrrrrrrrrrrrrre'),
(194, 'hQ5ZciMrhR20EfLQ', 'rrrrrrrrrrrrrrrd'),
(195, 'K7NATjzjwISXDrot', 'rrrrrrrrrrrrrrrc'),
(197, 'DzZS5CtjwHwtQYII', 'rrrrrrrrrrrrrrrf'),
(198, '2nuEVJ8nb2UOhE77', 'rrrrrrrrrrrrrrre'),
(200, 'vNqDC21LmKpf0ayF', 'rrrrrrrrrrrrrrre'),
(201, '5P1m0aKpDacSvrON', 'rrrrrrrrrrrrrrrd'),
(202, 'c4jxRYJkzEBQATCh', 'rrrrrrrrrrrrrrrc'),
(206, 'SoRg4TVNXaV87j8p', 'rrrrrrrrrrrrrrre'),
(210, 'YBAHHzAWkaPaV4WU', 'rrrrrrrrrrrrrrrd'),
(221, 'y9RY4RBVw1Cbntlv', 'rrrrrrrrrrrrrrrc'),
(222, 'gy6yOtkVvj884pRA', 'rrrrrrrrrrrrrrrc'),
(223, 'uuuuuuuuuuuuuuuc', 'rrrrrrrrrrrrrrrg'),
(226, 'kmUW7rrbJYxUbUSO', 'rrrrrrrrrrrrrrrd'),
(227, 'mK2reJXZe6InG4RH', 'rrrrrrrrrrrrrrrg'),
(228, 'YoiuYYP2KzbaaT77', 'rrrrrrrrrrrrrrrf'),
(233, 'AdCu6JSIz4VVqDQY', 'rrrrrrrrrrrrrrrd'),
(234, 'Jzhdd9T5G3KRUsNl', 'rrrrrrrrrrrrrrre'),
(237, '1n099YtF1Tk7kfEp', 'rrrrrrrrrrrrrrre'),
(240, 'IphMs4uKYQz7hwyL', 'rrrrrrrrrrrrrrrg'),
(241, '6v3sWTOdQ6KFK1Se', 'rrrrrrrrrrrrrrrg'),
(244, 'xPnYYV95szOiZFG9', 'rrrrrrrrrrrrrrrd'),
(245, 'bnLKMprpsh2Qz3xx', 'rrrrrrrrrrrrrrrc'),
(246, 'oerNctodu7t9vkMz', 'rrrrrrrrrrrrrrrc'),
(247, 'tNFjw8ht5zmIoQL9', 'rrrrrrrrrrrrrrrd'),
(248, 't8CCaXDYfzxtjZij', 'rrrrrrrrrrrrrrrd'),
(249, '4AGllwmN8A5x0Z1D', 'rrrrrrrrrrrrrrrd'),
(255, 'fFM0V9k7on3mzvWm', 'rrrrrrrrrrrrrrrg'),
(258, '1CyOinx6GOWjXDyp', 'rrrrrrrrrrrrrrrf'),
(259, 'ITvAgDEtxwRevBHw', 'rrrrrrrrrrrrrrre'),
(261, 'eKrGIT8woaiqyPld', 'rrrrrrrrrrrrrrre'),
(262, 'Fn5gyuGK6VD1DD0Q', 'rrrrrrrrrrrrrrrd'),
(263, 'Ky9cwmI8Fw4vI7Gk', 'rrrrrrrrrrrrrrrc'),
(265, '6mgVzJmqH54TdxMb', 'rrrrrrrrrrrrrrrd'),
(266, '2UDbOEYKWa2aQzh8', 'rrrrrrrrrrrrrrrd'),
(267, 'WdHCo5hZU3GTqzzI', 'rrrrrrrrrrrrrrrd'),
(268, 'PNHji6Rds55pWKZO', 'rrrrrrrrrrrrrrrc'),
(269, 'zK4LpGzQA7hHfuoS', 'rrrrrrrrrrrrrrrd'),
(270, '2RJSgd5zFsan8Wa9', 'rrrrrrrrrrrrrrrd'),
(271, 'iZPceo1wrxQfLySd', 'rrrrrrrrrrrrrrrd'),
(272, 'CkH6uxG8xsf6ofVN', 'wkBxkNvcwnwAml7w'),
(274, 'ULEyr7eayRZQTSXS', 'rrrrrrrrrrrrrrrg');

-- --------------------------------------------------------

--
-- Table structure for table `tnng_User_Strategy`
--

CREATE TABLE IF NOT EXISTS `tnng_User_Strategy` (
`aid` bigint(20) unsigned NOT NULL,
  `user_id` char(16) NOT NULL,
  `strategy_id` char(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8 COMMENT='User to Strategy one-to-many.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tnng_Acl`
--
ALTER TABLE `tnng_Acl`
 ADD PRIMARY KEY (`role_id`,`perm_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Acl_Perms`
--
ALTER TABLE `tnng_Acl_Perms`
 ADD PRIMARY KEY (`name`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Acl_Roles`
--
ALTER TABLE `tnng_Acl_Roles`
 ADD PRIMARY KEY (`name`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Attachment`
--
ALTER TABLE `tnng_Attachment`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`), ADD KEY `parent_id` (`parent_id`), ADD KEY `mime` (`mime`(255));

--
-- Indexes for table `tnng_Competency`
--
ALTER TABLE `tnng_Competency`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`), ADD KEY `status` (`status`);

--
-- Indexes for table `tnng_Competency_Objective`
--
ALTER TABLE `tnng_Competency_Objective`
 ADD PRIMARY KEY (`competency_id`,`objective_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Competency_Strategy`
--
ALTER TABLE `tnng_Competency_Strategy`
 ADD PRIMARY KEY (`competency_id`,`strategy_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Compiledform`
--
ALTER TABLE `tnng_Compiledform`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Compiledform_Property`
--
ALTER TABLE `tnng_Compiledform_Property`
 ADD PRIMARY KEY (`aid`), ADD KEY `compiledform_id` (`compiledform_id`);

--
-- Indexes for table `tnng_Compiledform_Sections`
--
ALTER TABLE `tnng_Compiledform_Sections`
 ADD PRIMARY KEY (`aid`), ADD KEY `compiledform_id` (`compiledform_id`);

--
-- Indexes for table `tnng_Department`
--
ALTER TABLE `tnng_Department`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`), ADD KEY `status` (`status`), ADD KEY `code` (`code`);

--
-- Indexes for table `tnng_Department_Objective`
--
ALTER TABLE `tnng_Department_Objective`
 ADD PRIMARY KEY (`department_id`,`objective_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Department_Strategy`
--
ALTER TABLE `tnng_Department_Strategy`
 ADD PRIMARY KEY (`department_id`,`strategy_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Department_Templates`
--
ALTER TABLE `tnng_Department_Templates`
 ADD PRIMARY KEY (`template_id`,`department_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Department_User`
--
ALTER TABLE `tnng_Department_User`
 ADD PRIMARY KEY (`department_id`,`user_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Division`
--
ALTER TABLE `tnng_Division`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`), ADD KEY `status` (`status`);

--
-- Indexes for table `tnng_Division_Department`
--
ALTER TABLE `tnng_Division_Department`
 ADD PRIMARY KEY (`division_id`,`department_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Division_Objective`
--
ALTER TABLE `tnng_Division_Objective`
 ADD PRIMARY KEY (`division_id`,`objective_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Division_Strategy`
--
ALTER TABLE `tnng_Division_Strategy`
 ADD PRIMARY KEY (`division_id`,`strategy_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Division_Templates`
--
ALTER TABLE `tnng_Division_Templates`
 ADD PRIMARY KEY (`template_id`,`division_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Division_User`
--
ALTER TABLE `tnng_Division_User`
 ADD PRIMARY KEY (`division_id`,`user_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Field`
--
ALTER TABLE `tnng_Field`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Folder`
--
ALTER TABLE `tnng_Folder`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Form`
--
ALTER TABLE `tnng_Form`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`), ADD KEY `expires` (`expires`);

--
-- Indexes for table `tnng_G`
--
ALTER TABLE `tnng_G`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Ids`
--
ALTER TABLE `tnng_Ids`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Matrix`
--
ALTER TABLE `tnng_Matrix`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Northview_Templates`
--
ALTER TABLE `tnng_Northview_Templates`
 ADD PRIMARY KEY (`template_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Objective`
--
ALTER TABLE `tnng_Objective`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Objective_Strategy`
--
ALTER TABLE `tnng_Objective_Strategy`
 ADD PRIMARY KEY (`objective_id`,`strategy_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property`
--
ALTER TABLE `tnng_Property`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`), ADD UNIQUE KEY `code` (`code`), ADD KEY `status` (`status`);

--
-- Indexes for table `tnng_Property_Competency`
--
ALTER TABLE `tnng_Property_Competency`
 ADD PRIMARY KEY (`property_id`,`competency_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_Department`
--
ALTER TABLE `tnng_Property_Department`
 ADD PRIMARY KEY (`property_id`,`department_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_Division`
--
ALTER TABLE `tnng_Property_Division`
 ADD PRIMARY KEY (`property_id`,`division_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_Exclusions`
--
ALTER TABLE `tnng_Property_Exclusions`
 ADD PRIMARY KEY (`property_id`,`exclusion_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_Objective`
--
ALTER TABLE `tnng_Property_Objective`
 ADD PRIMARY KEY (`property_id`,`objective_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_Reviewcycle`
--
ALTER TABLE `tnng_Property_Reviewcycle`
 ADD PRIMARY KEY (`property_id`,`reviewcycle_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_Strategy`
--
ALTER TABLE `tnng_Property_Strategy`
 ADD PRIMARY KEY (`property_id`,`strategy_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_Templates`
--
ALTER TABLE `tnng_Property_Templates`
 ADD PRIMARY KEY (`template_id`,`property_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Property_User`
--
ALTER TABLE `tnng_Property_User`
 ADD PRIMARY KEY (`property_id`,`user_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Reviewcycle`
--
ALTER TABLE `tnng_Reviewcycle`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Static`
--
ALTER TABLE `tnng_Static`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Strategy`
--
ALTER TABLE `tnng_Strategy`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Strategy_Tactic`
--
ALTER TABLE `tnng_Strategy_Tactic`
 ADD PRIMARY KEY (`strategy_id`,`tactic_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Subevaluation`
--
ALTER TABLE `tnng_Subevaluation`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Subevaluation_Components`
--
ALTER TABLE `tnng_Subevaluation_Components`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Subevaluation_Field`
--
ALTER TABLE `tnng_Subevaluation_Field`
 ADD PRIMARY KEY (`aid`), ADD KEY `Subevaluation_id` (`Subevaluation_id`);

--
-- Indexes for table `tnng_Tactic`
--
ALTER TABLE `tnng_Tactic`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Templates`
--
ALTER TABLE `tnng_Templates`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Templates_Location`
--
ALTER TABLE `tnng_Templates_Location`
 ADD PRIMARY KEY (`aid`), ADD KEY `template_id` (`template_id`,`property_id`,`division_id`,`department_id`);

--
-- Indexes for table `tnng_Toolbox`
--
ALTER TABLE `tnng_Toolbox`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_Truenorth_Summary`
--
ALTER TABLE `tnng_Truenorth_Summary`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tnng_User`
--
ALTER TABLE `tnng_User`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `aid` (`aid`), ADD UNIQUE KEY `passwordreset` (`passwordreset`), ADD KEY `status` (`status`);

--
-- Indexes for table `tnng_User_Competency`
--
ALTER TABLE `tnng_User_Competency`
 ADD PRIMARY KEY (`user_id`,`competency_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_User_Role`
--
ALTER TABLE `tnng_User_Role`
 ADD PRIMARY KEY (`user_id`,`role_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- Indexes for table `tnng_User_Strategy`
--
ALTER TABLE `tnng_User_Strategy`
 ADD PRIMARY KEY (`user_id`,`strategy_id`), ADD UNIQUE KEY `aid` (`aid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tnng_Acl`
--
ALTER TABLE `tnng_Acl`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1222;
--
-- AUTO_INCREMENT for table `tnng_Acl_Perms`
--
ALTER TABLE `tnng_Acl_Perms`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `tnng_Acl_Roles`
--
ALTER TABLE `tnng_Acl_Roles`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tnng_Attachment`
--
ALTER TABLE `tnng_Attachment`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Competency`
--
ALTER TABLE `tnng_Competency`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `tnng_Competency_Objective`
--
ALTER TABLE `tnng_Competency_Objective`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Competency_Strategy`
--
ALTER TABLE `tnng_Competency_Strategy`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Compiledform`
--
ALTER TABLE `tnng_Compiledform`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tnng_Compiledform_Property`
--
ALTER TABLE `tnng_Compiledform_Property`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tnng_Compiledform_Sections`
--
ALTER TABLE `tnng_Compiledform_Sections`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `tnng_Department`
--
ALTER TABLE `tnng_Department`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `tnng_Department_Objective`
--
ALTER TABLE `tnng_Department_Objective`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Department_Strategy`
--
ALTER TABLE `tnng_Department_Strategy`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `tnng_Department_Templates`
--
ALTER TABLE `tnng_Department_Templates`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Department_User`
--
ALTER TABLE `tnng_Department_User`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Division`
--
ALTER TABLE `tnng_Division`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `tnng_Division_Department`
--
ALTER TABLE `tnng_Division_Department`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `tnng_Division_Objective`
--
ALTER TABLE `tnng_Division_Objective`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Division_Strategy`
--
ALTER TABLE `tnng_Division_Strategy`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `tnng_Division_Templates`
--
ALTER TABLE `tnng_Division_Templates`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Division_User`
--
ALTER TABLE `tnng_Division_User`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Field`
--
ALTER TABLE `tnng_Field`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT for table `tnng_Folder`
--
ALTER TABLE `tnng_Folder`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Form`
--
ALTER TABLE `tnng_Form`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tnng_G`
--
ALTER TABLE `tnng_G`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tnng_Ids`
--
ALTER TABLE `tnng_Ids`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12678;
--
-- AUTO_INCREMENT for table `tnng_Matrix`
--
ALTER TABLE `tnng_Matrix`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Northview_Templates`
--
ALTER TABLE `tnng_Northview_Templates`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tnng_Objective`
--
ALTER TABLE `tnng_Objective`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Objective_Strategy`
--
ALTER TABLE `tnng_Objective_Strategy`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Property`
--
ALTER TABLE `tnng_Property`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `tnng_Property_Competency`
--
ALTER TABLE `tnng_Property_Competency`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `tnng_Property_Department`
--
ALTER TABLE `tnng_Property_Department`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `tnng_Property_Division`
--
ALTER TABLE `tnng_Property_Division`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `tnng_Property_Exclusions`
--
ALTER TABLE `tnng_Property_Exclusions`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Property_Objective`
--
ALTER TABLE `tnng_Property_Objective`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Property_Reviewcycle`
--
ALTER TABLE `tnng_Property_Reviewcycle`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `tnng_Property_Strategy`
--
ALTER TABLE `tnng_Property_Strategy`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Property_Templates`
--
ALTER TABLE `tnng_Property_Templates`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tnng_Property_User`
--
ALTER TABLE `tnng_Property_User`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Reviewcycle`
--
ALTER TABLE `tnng_Reviewcycle`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tnng_Static`
--
ALTER TABLE `tnng_Static`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tnng_Strategy`
--
ALTER TABLE `tnng_Strategy`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Strategy_Tactic`
--
ALTER TABLE `tnng_Strategy_Tactic`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Subevaluation`
--
ALTER TABLE `tnng_Subevaluation`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tnng_Subevaluation_Components`
--
ALTER TABLE `tnng_Subevaluation_Components`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Subevaluation_Field`
--
ALTER TABLE `tnng_Subevaluation_Field`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT for table `tnng_Tactic`
--
ALTER TABLE `tnng_Tactic`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Templates`
--
ALTER TABLE `tnng_Templates`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Templates_Location`
--
ALTER TABLE `tnng_Templates_Location`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Toolbox`
--
ALTER TABLE `tnng_Toolbox`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_Truenorth_Summary`
--
ALTER TABLE `tnng_Truenorth_Summary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tnng_User`
--
ALTER TABLE `tnng_User`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `tnng_User_Competency`
--
ALTER TABLE `tnng_User_Competency`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tnng_User_Role`
--
ALTER TABLE `tnng_User_Role`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=275;
--
-- AUTO_INCREMENT for table `tnng_User_Strategy`
--
ALTER TABLE `tnng_User_Strategy`
MODIFY `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=215;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
