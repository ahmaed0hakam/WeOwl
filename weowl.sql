-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2023 at 08:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weowl`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_new_student`
--

CREATE TABLE `add_new_student` (
  `id` int(11) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `section_id` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_email` varchar(255) NOT NULL,
  `parent_phone` varchar(255) NOT NULL,
  `parent_password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_new_student`
--

INSERT INTO `add_new_student` (`id`, `added_by`, `student_id`, `class_id`, `class_name`, `section_id`, `section`, `first_name`, `last_name`, `parent_id`, `parent_name`, `parent_email`, `parent_phone`, `parent_password`, `created`) VALUES
(1, 'amjadhariry', 7, 1, '1', 1, 'A', 'ahmad', 'mohsen', 7, 'tamer', 'tamermohsen@gmail.com', '0794332231', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-04-28 19:54:30'),
(2, 'eyaalzoubi', 8, 1, '1', 1, 'A', 'Yousef', 'Saeed', 8, 'Ahmad', 'ASaeed@gmail.com', '0778801457', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-04-28 19:59:35'),
(3, 'amjadhariry', 10, 6, '6', 2, 'B', 'Eyadeh', 'AL-Zoubi', 10, 'Mahmoud', 'MahmoudAlzoubi@gmail.com', '0708080808', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-10 13:20:35'),
(4, 'amjadhariry', 11, 5, '5', 1, 'A', 'Ahmad', 'AL-Hafi', 11, 'Hakam', 'HAlhafi@gmail.com', '0708023308', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-11 08:59:53'),
(5, 'eyaalzoubi', 12, 3, '3', 0, 'B', 'Amjad', 'Hariri', 12, 'Nazzal', 'amjadhariri9@gmail.com', '+962778861789', '$2y$10$..nuln0uB81eS2RBgqNNp.8IhlHYwDKfiV9IeyeCjJAKDP2NpxzE.', '2023-05-21 15:03:17'),
(6, 'amjadhariry', 13, 1, '1', 1, 'A', 'Mohamed', 'Hassan', 13, 'Ahmad', 'ahmadhasan@gmail.com', '324239432486123423', '$2y$10$ibh0Qm.qGAW36B9kY7js.eyMBaXM80KV7J1UlSPkAZC.V6507XAdy', '2023-06-01 19:04:20'),
(7, 'amjadhariry', 14, 1, '1', 1, 'A', 'Mohamed', 'Hassan', 14, 'Ahmad', 'ahmadhasan@gmail.com', '324239432486123423', '$2y$10$W18kZf9yTRDVYQjrqaA./uUKpj9WEwa6AGJPBfqhAm0muNyohXMq.', '2023-06-01 19:06:55'),
(8, 'eyaalzoubi', 15, 1, '1', 0, 'A', 'Mohamed', 'Hassan', 15, 'Ahmad', 'ahmadhasan@gmail.com', '07943322311', '$2y$10$GMKYQDCfGghh0OGxi.WJhe6WvOBOpI1mSWZOf9M5OSeCBB6vyBwIq', '2023-06-01 20:18:18'),
(9, 'amjadhariry', 16, 1, '1', 1, 'A', 'Muhmmad', 'Farraj', 16, 'Mustafa', 'mfarraj@gmail.com', '0979525111', '$2y$10$RIH12Ilup1dhbhuipKGd5ug8.WZ4KhRTgy4R.sBoaLak2gWhFW2Oa', '2023-06-04 19:16:56'),
(10, 'amjadhariry', 17, 1, '1', 1, 'A', 'Albara', 'Shehadeh', 17, 'Fawaz', 'fshehadeh@gmail.com', '3456789854', '$2y$10$Cq5wTuxqALGio6tvsAJxbejlHaZOEvhrLwh4bpG3bu3JwlTaaoPWK', '2023-06-04 19:18:56'),
(11, 'eyaalzoubi', 18, 1, '1', 0, 'A', 'Hashem', 'Ali', 18, 'Aljarah', 'alijarah@gmail.com', '014234023', '$2y$10$Qh7JFhsbNC.r0I6MhicbauyGw.UDFFtamGWsxcsjytI6oH4vqJ8Ja', '2023-06-04 19:37:05'),
(12, 'amjadhariry', 19, 3, '3', 3, 'C', 'Bahaa', 'Almousa', 19, 'Ahmad', 'amousa1@gmail.com', '05574378765', '$2y$10$ezPX3HsfADl9yp63Hkj3teKD5NQ9p5fP7t9FyRdHNf.ZOEsqKNRWW', '2023-06-09 11:39:34'),
(13, 'amjadhariry', 20, 1, '1', 1, 'A', 'Bahaa', 'Almousa', 20, 'Mohammed', 'mmousa121@gmail.com', '123456789', '$2y$10$ojbauFK4F99Nxc.jiunwu.A6ep5Tx9v1qRjYjX2v/wqHngGKXOTOe', '2023-06-09 11:41:49'),
(14, 'amjadhariry', 21, 4, '4', 1, 'A', 'Tamer', 'Ahmad', 21, 'Alhariri', 'ahariri14@gmail.com', '04325632', '$2y$10$OyI7HumvgCIlJTCXFZVRGOgZqCkCXFX6lJdeMGfPR8.VKzDD3iU5K', '2023-06-09 11:45:49'),
(15, 'eyaalzoubi', 22, 1, '1', 0, 'A', 'Ahmed ', 'Abdullah', 22, 'Mohammed ', 'ahmedabdullah30@gmail.com', '0789338681', '$2y$10$flgTI2kRD.tO74UmpDUB/OTXkMZMQBaqtBxJWo0.OvbSF0yQ8Oyhu', '2023-06-18 12:16:40'),
(16, 'eyaalzoubi', 23, 1, '1', 0, 'A', 'Omar ', 'Haddad', 23, 'Hassan ', 'omarhaddad28@gmail.com', '12345678', '$2y$10$3sZm0F.acHUmTraR2H/gC.4rfbvMJxYTvvWu0o/NT2YyZN5/rYMcC', '2023-06-18 12:25:49'),
(17, 'eyaalzoubi', 24, 1, '1', 0, 'A', 'Leila ', 'Nasser', 24, 'Mahmoud ', 'leilanasser32@gmail.com', '0789338681', '$2y$10$PvNuIX1EBj6Uqr3UxvwxE.wklziGcPc4utnHWPt/PjOe3Rl5n94wm', '2023-06-18 12:27:47'),
(18, 'eyaalzoubi', 25, 1, '1', 0, 'A', 'Khaled ', 'Mansour', 25, 'Ibrahim ', 'samisalem31@gmail.com', '0789338681', '$2y$10$4W1oV1.OpqxjUNwxhb9Bg.ygHP8e3GkuG3x/DberqqAHa.OLumJrW', '2023-06-18 12:28:44'),
(19, 'eyaalzoubi', 26, 1, '1', 0, 'A', 'Dina ', 'Abu-Hassan', 26, 'Raed ', 'dinaabuhassan29@gmail.com', '0789338681', '$2y$10$FOfAryv1I5tzNYxvINVkneCml26Hpl2S41MampikiVFto8JvYLTZi', '2023-06-18 12:29:32'),
(20, 'eyaalzoubi', 27, 1, '1', 0, 'A', 'Kareem ', 'Qassem', 27, 'Hani ', 'kareemqassem32@gmail.com', '0789338681', '$2y$10$RBCosW9pfQP5H8g8us/lm.8278gcsv1pK8R1a044Drtf5KDuYjhGy', '2023-06-18 12:31:37'),
(21, 'eyaalzoubi', 28, 1, '1', 0, 'A', 'Maya ', 'Dajani', 28, 'Ibrahim ', 'mayadajani31@gmail.com', '0789338681', '$2y$10$sFMIsU1CgzxD7ZJHMyJ5RuTp.sNMO/WEa7iJ0QL.ByTaa1PCfBaoi', '2023-06-18 12:32:21'),
(22, 'eyaalzoubi', 29, 1, '1', 0, 'A', 'Jamal ', 'Hamid', 29, 'Bilal ', 'bilalhamid27@gmail.com', '0789338681', '$2y$10$N9s8GobEdrRMaU7HHgYjAOln.rbE1ChGunWH61VhYcqOtNiZJDNvm', '2023-06-18 12:33:19'),
(23, 'eyaalzoubi', 30, 1, '1', 0, 'A', 'Faisal ', 'Al-Zoubi', 30, 'Khalid ', 'faisalalzoubi33@gmail.com', '0789338681', '$2y$10$yUyHQcw2fLyUTsUBfKKdq.425Wl2oQ72q.W9d6aMoQB1lNRx/bweK', '2023-06-18 12:39:48'),
(24, 'eyaalzoubi', 31, 1, '1', 0, 'A', 'Reem ', ' Khalil', 31, 'Ali ', 'reemkhalil25@gmail.com', '0789338681', '$2y$10$LYn071H/IIJVEQzbyD3zf.bs22WZO/CdBtdMrMX48vBXP8VaYkfsO', '2023-06-18 12:40:46'),
(25, 'eyaalzoubi', 32, 1, '1', 0, 'A', 'Rami ', 'Abu-Saad', 32, 'Kamal ', 'ramiabusaad28@gmail.com', '0789338681', '$2y$10$07ANo/CBQnndB9Zg5y5pouEgSVELnV2ycsUZziSDagE8Qxjt6jmMi', '2023-06-18 12:43:40'),
(26, 'eyaalzoubi', 33, 1, '1', 0, 'A', 'Fatima', 'Khalaf', 33, 'Saleh ', 'fatimakhalaf@gmail.com', '0789338681', '$2y$10$5FbjCTWf5KeBH1/JW0yESuG3VKE1K.FEoOvdMDgLTuDbni9sEaV.2', '2023-06-18 12:45:18'),
(27, 'eyaalzoubi', 34, 1, '1', 0, 'A', 'Ali ', 'Hassan', 34, 'Ahmed ', 'alihassan29@gmail.com', '0789338681', '$2y$10$1i2ZVZahuXprj7wsJarpven.c.yVeysyFacMkXQhSv9NtSDIspgDG', '2023-06-18 12:46:17'),
(28, 'eyaalzoubi', 35, 1, '1', 0, 'A', 'Hamza ', 'Tawfiq', 35, 'Nabil ', 'hamzatawfiq32@gmail.com', '0789338681', '$2y$10$5luEb/uQUZMwG5OVtc92w.GSyR1M/vb6YqZ9Dith3sZ9mYTGetPx2', '2023-06-18 12:47:16'),
(29, 'eyaalzoubi', 36, 1, '1', 0, 'A', 'Nour ', 'Abu-Diab', 36, 'Raed ', 'nourabudiab30@gmail.com', '0789338681', '$2y$10$m15zP1NIBP4rPl1XhESuUe3PErf4TF.FOSu9ywLGOHKivBob8s7vG', '2023-06-18 12:48:13'),
(30, 'eyaalzoubi', 37, 1, '1', 0, 'A', 'Majed ', 'Haddad', 37, 'Tarek ', 'majedhaddad27@gmail.com', '0789338681', '$2y$10$pKwgAkZiVR8T56.bJmUC0u/sobwge7ITlk0F6kp6/Qs5eAwgvBKpy', '2023-06-18 12:48:55'),
(31, 'eyaalzoubi', 38, 1, '1', 0, 'A', 'Zaid ', 'Al-Khatib', 38, 'Hassan ', 'zaidalkhatib33@gmail.com', '0789338681', '$2y$10$CWTu.4yZBiX3BgrxeCl2nu4zxQIuro2ZSPq4Lth.k1CYoas0PoOHG', '2023-06-18 12:50:01'),
(32, 'eyaalzoubi', 39, 1, '1', 0, 'A', 'Mariam ', 'Abu-Rahma', 39, 'Jamal ', 'mariamaburahma25@gmail.com', '0789338681', '$2y$10$Od8yPb2VqbSw.DlL2T9pO.dXJsJEJY2BBDdLf76f7Mau8kjGy94i6', '2023-06-18 12:50:55'),
(33, 'amjadhariry', 40, 2, '2', 1, 'A', 'test', 'test', 40, 'test', 'test@gmail.com', '1234234234', '$2y$10$rvp8W.k3OLj9nxAhv5rZ1..Ui212tLYduygm8DYhuTZC4h8abR2XK', '2023-06-20 15:51:48'),
(34, 'eyaalzoubi', 41, 2, '2', 0, 'A', 'testt', 'testt', 41, 'testt', 'testrt@gmail.com', '132412312', '$2y$10$X/ZbnBS/l0WkQvFf5xCEc.2B8vWdQDhy6bDmDNDd2sq4cHaxvVKRO', '2023-06-20 16:09:28'),
(35, 'eyaalzoubi', 42, 1, '1', 0, 'A', 'Lina', 'Altaie', 42, 'Ahmad', 'ataie@gmail.com', '097952573', '$2y$10$xM5cshzo.jKe3mH/c5DYM.kRYwMiF7EpwDEmNC0aT6xj9lB2Ny5JG', '2023-06-20 16:27:05'),
(36, 'eyaalzoubi', 43, 1, '1', 0, 'A', 'Lina', 'Altaie', 43, 'tamer', 'ttaie@gmail.com', '097952573', '$2y$10$8XWjt3Q7xNVXiUq5Nux7/ecXuAdc2xcaD.IHpz2yAqBnKLzb8Wf6i', '2023-06-20 16:30:50'),
(37, 'eyaalzoubi', 44, 2, '2', 0, 'C', 'Amjadd', 'Haririd', 44, 'Ahmad', 'amjadharirdi9@gmail.com', '+962778861789', '$2y$10$g2bWvGgBHp83NnWZFvVuO.c7aEADcC9PdCWAwH0QsIJ5yAUQ4Jf4.', '2023-06-20 16:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `add_new_teacher`
--

CREATE TABLE `add_new_teacher` (
  `id` int(11) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `teacher_password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_new_teacher`
--

INSERT INTO `add_new_teacher` (`id`, `added_by`, `teacher_id`, `subject_id`, `subject_name`, `class_id`, `class_name`, `first_name`, `last_name`, `email`, `phone`, `teacher_password`, `created`) VALUES
(9, 'eya alzoubi', 42, 3, 'Islamic', 3, '3', 'Amjad', 'AL-Hariri', 'amjad9@gmail.com', '0778861789', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-08 16:32:08'),
(10, 'eya alzoubi', 43, 6, 'Social Studies', 6, '6', 'khalid', 'Arabi', 'ka@cc.com', '0764233312', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-08 16:33:43'),
(11, 'eya alzoubi', 44, 3, 'Islamic', 2, '2', 'ahmad', 'mohsen', 'amohsen@gmail.com', '0794332222', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-09 10:43:35'),
(12, 'eya alzoubi', 45, 1, 'Arabic', 6, '6', 'Yousef', 'Saeed', 'ASaeed@gmail.com', '+962778801457', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-09 11:00:32'),
(13, 'eya alzoubi', 46, 5, 'Science', 3, '3', 'aaaa', 'a', 'ad@c.com', '456789876543', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-09 12:59:56'),
(14, ' ', 47, 0, '', 0, '', 'Amjad', 'Hariri', 'amjadhariri9@gmail.com', '+962778861789', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-10 12:29:31'),
(15, ' ', 48, 0, '', 0, '', 'Raed', 'Salem', 'RS@gmail.com', '+962778806453', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-10 12:32:56'),
(16, ' ', 49, 6, 'Social Studies', 0, '6', 'Ahmad', 'Omar', 'Ao@gmail.com', '0330132032', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-10 12:37:43'),
(20, 'amjad hariry', 50, 6, 'Social Studies', 0, '6', 'Razi', 'Ahmad', 'RA@gmail.com', '098765432345', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-10 12:49:24'),
(21, ' ', 51, 1, 'Arabic', 1, '1', 'Albara', 'Fawaz', 'AlbaraF@gmail.com', '07788466352', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-10 12:54:22'),
(22, 'eya alzoubi', 52, 3, 'Islamic', 6, '6', 'Tawfeeq', 'Mefleh', 'tawfeeqm@gmail.com', '06783336224', '$2y$10$Ykn3I53L2.Pu9sZn2N/2pe6adzMQ3HxCASdC8uMd8aIEKKABlNTkW', '2023-05-13 14:15:34'),
(23, 'amjad hariry', 53, 4, 'Math', 2, '2', 'Salem', 'Jawad', 'salemj@gmail.com', '03304104334', '$2y$10$mDSAzNsMbnc/cQB4ZTaLU.EsL85drw/bvNDbXoc2huxmktdm9c6WW', '2023-05-13 14:17:26'),
(24, 'eya alzoubi', 54, 1, 'Arabic', 1, '1', 'Tarek', 'Al', '', '', '$2y$10$PrpbL4vOE2ZME8U9Md3XZ.hss6Dif9RTcnkJiWOpzPryTjKDhzXiO', '2023-05-21 14:55:59'),
(25, 'eya alzoubi', 55, 1, 'Arabic', 1, '1', 'ahmad', 'mohsen', 'amohsen@gmail.com', '0794332231', '$2y$10$ek.lVz5Z7kURX5Oquqzz5OTdMstiqMLkfbqzjKuF2YOzF3Uege5T.', '2023-06-01 20:24:54'),
(26, 'amjad hariry', 56, 1, 'Arabic', 2, '2', 'wajd', 'eyadeh', 'weyadeh@gmail.com', '234567898754', '$2y$10$tHnIqoizjBmEDmAvSN13vudvtthLU.jfNxDZWZ0h7/UC2wmda/vS6', '2023-06-04 18:48:38'),
(27, 'amjad hariry', 57, 3, 'Islamic', 3, '3', 'leo', 'amjad', 'leoamjad@gmail.com', '23456341122', '$2y$10$nD1K0MZVKq.RH9Ykipz8rOQjzO2fWvm2imVMiHin0gcA/GXbBvUW.', '2023-06-04 18:56:25'),
(28, 'amjad hariry', 58, 6, 'Social Studies', 3, '3', 'w', 'w', 'ww@gmail.com', '013202012', '$2y$10$LWH8t2OnaBKJ5cKOScAkxuOsPFaNGLVDQTChoVZiQbxX97BF8GTl2', '2023-06-04 18:58:05'),
(29, 'amjad hariry', 59, 2, 'English', 3, '3', 'p', 'p', 'pp@gmail.com', '064934242', '$2y$10$veWOTRL94ZVfr9cJEx/IJergpHwPxZmGwCTWTSE4qYRXqPRKLl2Fa', '2023-06-04 19:02:24'),
(30, 'amjad hariry', 60, 1, 'Arabic', 3, '3', 'pp', 'p', 'ppp@gmail.com', '064934242', '$2y$10$xNeBvP45fx97.y/Gi6LaJubq1e8iWt7ImZLxCAKDuaB5olLXh6DK.', '2023-06-04 19:06:11'),
(31, 'amjad hariry', 61, 6, 'Social Studies', 3, '3', 'p', 'p', 'pp@gmail.com', '064934242', '$2y$10$9/fKL0BIVr0sMYksk0o5kehzzW5KR0MDYBPIfP..gDX/tw2SqkBPu', '2023-06-04 19:11:09'),
(32, 'amjad hariry', 62, 3, 'Islamic', 3, '3', 'leo', 'alzoubi', 'leozoubi@gmail.com', '077828282', '$2y$10$HbV0/JfbGizgWHhKuWAfquuVNIQvP9RpY8yvr/nu.em.7H.naM1CS', '2023-06-04 19:13:13'),
(33, 'eya alzoubi', 63, 2, 'English', 1, '1', 'omar', 'aljarah', 'oaljarah@gmail.com', '2473534633', '$2y$10$mgEYrOOczyvihFKVNBzh4u9F8m7yAqThoKicNtdr4CRT30OhQFam6', '2023-06-04 19:35:55'),
(34, 'amjad hariry', 64, 4, 'Math', 2, '2', 'Malek', 'Omari', 'malikomari10@gmail.com', '035932242', '$2y$10$bkVAl9VqcU/q7prpfdQYcuXfbMT.lYltfBtHPMp2l5ONPvyIfNYJK', '2023-06-09 11:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `dates` date NOT NULL,
  `arrival_status` varchar(11) NOT NULL,
  `arrival` time NOT NULL,
  `leaving_status` varchar(11) NOT NULL,
  `leaving` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `class_id`, `student_id`, `dates`, `arrival_status`, `arrival`, `leaving_status`, `leaving`) VALUES
(1389, 1, 1, '2023-04-07', 'Absent', '22:49:13', 'Left', '22:50:59'),
(1390, 1, 4, '2023-04-07', 'Arrived', '22:49:14', 'Left', '22:50:59'),
(1391, 1, 1, '2023-04-09', 'Arrived', '21:30:36', '', '00:00:00'),
(1392, 1, 4, '2023-04-09', 'Arrived', '21:46:19', '', '00:00:00'),
(1393, 1, 1, '2023-04-10', 'Arrived', '00:27:08', 'Left', '00:36:06'),
(1394, 1, 4, '2023-04-10', 'Arrived', '00:27:08', 'Still', '00:36:07'),
(1395, 2, 2, '2023-04-10', '', '00:27:56', 'Still', '00:38:42'),
(1396, 2, 5, '2023-04-10', 'Absent', '00:27:56', 'Left', '00:38:48'),
(1397, 10, 3, '2023-04-10', 'Arrived', '00:41:02', '', '00:00:00'),
(1398, 10, 6, '2023-04-10', 'Arrived', '00:41:03', '', '00:00:00'),
(1399, 1, 1, '2023-04-11', 'Arrived', '16:08:40', 'Left', '16:09:00'),
(1400, 1, 4, '2023-04-11', 'Arrived', '16:08:47', 'Still', '16:09:00'),
(1401, 1, 1, '2023-04-30', 'Absent', '19:29:59', 'Left', '19:30:08'),
(1402, 1, 4, '2023-04-30', 'Arrived', '19:30:00', 'Left', '19:30:08'),
(1403, 1, 7, '2023-04-30', 'Arrived', '21:44:08', 'Left', '19:30:08'),
(1422, 2, 2, '2023-05-10', 'Arrived', '13:40:38', 'Still', '13:42:32'),
(1423, 2, 5, '2023-05-10', 'Absent', '13:40:27', 'Left', '13:42:32'),
(1424, 2, 2, '2023-05-25', 'Absent', '23:52:04', 'Left', '23:52:12'),
(1425, 2, 5, '2023-05-25', 'Arrived', '23:51:16', 'Still', '23:52:36'),
(1602, 2, 5, '2023-06-20', 'Arrived', '19:33:28', '', '00:00:00'),
(1603, 2, 2, '2023-06-20', '', '19:33:28', '', '00:00:00'),
(1604, 2, 40, '2023-06-20', '', '19:33:28', '', '00:00:00'),
(1605, 2, 41, '2023-06-20', '', '19:33:28', '', '00:00:00'),
(1606, 2, 44, '2023-06-20', '', '19:33:28', '', '00:00:00'),
(1607, 1, 20, '2023-06-20', 'Arrived', '19:34:13', '', '00:00:00'),
(1608, 1, 18, '2023-06-20', '', '19:34:13', '', '00:00:00'),
(1609, 1, 43, '2023-06-20', '', '19:34:13', '', '00:00:00'),
(1610, 1, 1, '2023-06-20', 'Arrived', '21:06:42', '', '00:00:00'),
(1611, 1, 16, '2023-06-20', '', '19:34:13', '', '00:00:00'),
(1612, 1, 4, '2023-06-20', '', '19:34:13', 'Left', '21:06:45'),
(1613, 1, 3, '2023-06-20', '', '19:34:13', '', '00:00:00'),
(1614, 1, 6, '2023-06-20', '', '19:34:13', '', '00:00:00'),
(1615, 1, 7, '2023-06-20', '', '19:34:13', '', '00:00:00'),
(1616, 1, 0, '2023-06-20', '', '21:06:42', '', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `name`) VALUES
(1, 'first'),
(2, 'second'),
(3, 'final');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `exam` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_first_name` varchar(255) NOT NULL,
  `student_last_name` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `teacher_first_name` varchar(255) NOT NULL,
  `teacher_last_name` varchar(255) NOT NULL,
  `tsc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade`, `exam`, `student_id`, `student_first_name`, `student_last_name`, `class_id`, `subject_id`, `subject_name`, `teacher_id`, `teacher_first_name`, `teacher_last_name`, `tsc_id`) VALUES
(1, 20, 'first', 1, 'Mohamed', 'Hassan', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(2, 23, 'first', 4, 'Salem', 'Alnaser', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(3, 22, 'first', 3, 'khalid', 'Wael', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(4, 28, 'first', 6, 'khalil', 'Aljasim', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(5, 24, 'first', 7, 'ahmad', 'mohsen', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(6, 22, 'first', 2, 'Bara', 'Alzoubi', 2, 2, 'English', 44, 'ahmad', 'mohsen', 1),
(7, 30, 'first', 5, 'Awad', 'Alomari', 2, 2, 'English', 44, 'ahmad', 'mohsen', 1),
(8, 21, 'second', 2, 'Bara', 'Alzoubi', 2, 2, 'English', 44, 'ahmad', 'mohsen', 1),
(9, 15, 'second', 5, 'Awad', 'Alomari', 2, 2, 'English', 44, 'ahmad', 'mohsen', 1),
(10, 27, 'first', 11, 'Ahmad', 'AL-Hafi', 5, 1, 'Arabic', 45, 'Yousef', 'Saeed', 14),
(11, 28, 'final', 11, 'Ahmad', 'AL-Hafi', 5, 1, 'Arabic', 45, 'Yousef', 'Saeed', 14),
(12, 22, 'second', 11, 'Ahmad', 'AL-Hafi', 5, 1, 'Arabic', 45, 'Yousef', 'Saeed', 14),
(13, 23, 'second', 1, 'Mohamed', 'Hassan', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(14, 15, 'second', 4, 'Salem', 'Alnaser', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(15, 16, 'second', 3, 'khalid', 'Wael', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(16, 19, 'second', 6, 'khalil', 'Aljasim', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(17, 22, 'second', 7, 'ahmad', 'mohsen', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(18, 80, 'final', 1, 'Mohamed', 'Hassan', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(19, 79, 'final', 4, 'Salem', 'Alnaser', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(20, 81, 'final', 3, 'khalid', 'Wael', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(21, 75, 'final', 6, 'khalil', 'Aljasim', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(22, 77, 'final', 7, 'ahmad', 'mohsen', 1, 2, 'English', 44, 'ahmad', 'mohsen', 21),
(23, 26, 'first', 1, 'Mohamed', 'Hassan', 1, 5, 'Science', 0, 'ahmad', 'mohsen', 0),
(24, 25, 'first', 11, 'Ahmad', 'AL-Hafi', 5, 3, 'Islamic', 45, 'Yousef', 'Saeed', 13),
(25, 25, 'first', 2, 'Bara', 'Alzoubi', 2, 6, 'Social Studies', 44, 'ahmad', 'mohsen', 8),
(26, 30, 'first', 5, 'Awad', 'Alomari', 2, 6, 'Social Studies', 44, 'ahmad', 'mohsen', 8),
(27, 24, 'second', 2, 'Bara', 'Alzoubi', 2, 6, 'Social Studies', 44, 'ahmad', 'mohsen', 8),
(28, 26, 'second', 5, 'Awad', 'Alomari', 2, 6, 'Social Studies', 44, 'ahmad', 'mohsen', 8),
(29, 85, 'final', 2, 'Bara', 'Alzoubi', 2, 6, 'Social Studies', 44, 'ahmad', 'mohsen', 8),
(30, 90, 'final', 5, 'Awad', 'Alomari', 2, 6, 'Social Studies', 44, 'ahmad', 'mohsen', 8);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES
(140842, 'eya', 'alzoubi', 'eya@gmail.com', '0778845622', '$2y$10$qb7vmSa2UIBp9FYXVD8rcOPSW2FKITgdWquVfdccr7DQJ/JjyH6q2');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `messag` varchar(255) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `publish_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `messag`, `sender_id`, `receiver_id`, `publish_date`) VALUES
(900, 'salam', 11, 45, '2023-05-27 17:43:28'),
(901, 'how are you?', 11, 45, '2023-05-27 17:43:38'),
(902, 'can we talk', 44, 11, '2023-05-27 18:58:29'),
(903, 'about your son grades', 44, 11, '2023-05-27 19:00:38'),
(904, 'ahmad', 44, 1, '2023-05-27 19:59:57'),
(905, 'hello', 1, 44, '2023-06-01 17:07:22'),
(906, 'we need to discuss something', 44, 1, '2023-06-04 13:30:30'),
(907, 'tomorrow?', 44, 1, '2023-06-04 13:30:37'),
(908, 'okay', 11, 44, '2023-06-04 13:42:13'),
(909, '123\r\n', 1, 51, '2023-06-09 10:56:58'),
(910, 'go', 1, 51, '2023-06-09 10:57:04'),
(911, 'aaa', 51, 1, '2023-06-09 10:58:22'),
(912, 'how', 1, 51, '2023-06-09 11:02:11'),
(913, 'hhhhhh', 45, 10, '2023-06-09 11:03:50'),
(914, 'aaa', 2, 44, '2023-06-09 11:08:37'),
(915, 'hi teacher', 1, 45, '2023-06-18 15:20:52'),
(916, 'hi teacher', 3, 45, '2023-06-18 15:21:51'),
(917, 'hi teacher', 4, 45, '2023-06-18 15:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `viewed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_type`, `user_id`, `title`, `content`, `viewed`) VALUES
(1, 'manager', 140842, 'TEST', 'test notification', 1),
(2, 'manager', 140842, 'Vice Manager added new student', 'student Albara Fawaz Shehadeh has been added to the system', 1),
(3, 'manager', 140842, 'ViceManager added a new student', 'Student Tamer Ahmad Added to the system', 1),
(4, 'manager', 140842, 'ViceManager added a new teacher', 'Teacher Malek Omari Added to the system', 1),
(5, 'parent', 11, 'New Grade added', 'Teacher Yousef Saeed Added first exam grade for Islamic subject', 1),
(6, 'parent', 2, 'New Grade added', 'Teacher ahmad mohsen Added first exam grade for Social Studies subject', 1),
(7, 'parent', 5, 'New Grade added', 'Teacher ahmad mohsen Added first exam grade for Social Studies subject', 0),
(8, 'parent', 2, 'New Grade added', 'Teacher ahmad mohsen Added second exam grade for Social Studies subject', 1),
(9, 'parent', 5, 'New Grade added', 'Teacher ahmad mohsen Added second exam grade for Social Studies subject', 0),
(10, 'parent', 2, 'New Grade added', 'Teacher ahmad mohsen Added final exam grade for Social Studies subject', 1),
(11, 'parent', 5, 'New Grade added', 'Teacher ahmad mohsen Added final exam grade for Social Studies subject', 0),
(12, 'manager', 140842, 'ViceManager added a new student', 'Student test test Added to the system', 0);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `parent_password` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`id`, `first_name`, `last_name`, `email`, `phone`, `parent_password`, `student_id`, `created`, `modified`, `deleted`) VALUES
(1, 'Ahmad', 'Hassan', 'ahmadhasan@gmail.com', '324239432486123423', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 1, '2023-04-27 21:00:00', '2023-04-30 12:24:39', 0),
(2, 'Eyadeh', 'Alzoubi', 'ealzoubi@gmail.com', '2142523423432', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 2, '2023-04-27 21:00:00', '2023-04-27 21:00:00', 0),
(3, 'Amjad', 'Wael', 'awael@gmail.com', '2142523423432', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 3, '2023-04-27 21:00:00', '2023-04-29 12:35:44', 0),
(4, 'Tamer', 'Alnaser', 'Tnaser@gmail.com', '45678987654', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 4, '2023-04-27 21:00:00', '2023-04-27 21:00:00', 0),
(5, 'Raed', 'Alomari', 'Romari@gmail.com', '0798654356', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 5, '2023-04-27 21:00:00', '2023-04-27 21:00:00', 0),
(6, 'Tayseer', 'Aljasim', 'Tjasem@gmail.com', '55736836', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 6, '2023-04-27 21:00:00', '2023-04-29 12:36:41', 0),
(7, 'tamer', 'mohsen', 'tamermohsen@gmail.com', '0794332231', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 7, '2023-04-27 21:00:00', '2023-05-22 09:49:43', 0),
(9, 'Ahmad', 'Saeed', 'ASaeed@gmail.com', '0778801457', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 9, '2023-04-28 19:59:35', '2023-04-28 20:02:37', 1),
(10, 'Mahmoud', 'AL-Zoubi', 'MahmoudAlzoubi@gmail.com', '0708080808', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 10, '2023-05-10 13:20:36', '2023-05-10 13:20:36', 0),
(11, 'Hakam', 'AL-Hafi', 'Halhafi@gmail.com', '0708023308', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 11, '2023-05-11 09:02:11', '2023-05-11 09:02:11', 0),
(12, 'Nazzal', 'Hariri', 'amjadhariri9@gmail.com', '+962778861789', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 12, '2023-05-21 15:03:17', '2023-05-21 15:03:34', 1),
(13, 'Ahmad', 'Hassan', 'ahmadhasssssan@gmail.com', '32241245231', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 13, '2023-06-01 19:04:20', '2023-06-01 19:04:20', 1),
(14, 'd', 'Hassandd', 'ahmadhassand@gmail.com', '324239432486123423', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 14, '2023-06-01 19:06:55', '2023-06-01 19:06:55', 1),
(15, 'Ahmadd', 'sda', 'ahmadhasan@gmail.comd', '07943322311', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 15, '2023-06-01 20:18:18', '2023-06-01 20:18:18', 1),
(16, 'Mustafa', 'Farraj', 'mfarraj@gmail.com', '0979525111', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 16, '2023-06-04 19:16:56', '2023-06-04 19:16:56', 0),
(17, 'Fawaz', 'Shehadeh', 'fshehadeh@gmail.com', '3456789854', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 17, '2023-06-04 19:18:57', '2023-06-20 16:34:02', 0),
(18, 'Aljarah', 'Ali', 'alijarah@gmail.com', '014234023', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 18, '2023-06-04 19:37:05', '2023-06-04 19:37:05', 0),
(19, 'Ahmad', 'Almousa', 'amousa1@gmail.com', '05574378765', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 19, '2023-06-09 11:39:34', '2023-06-09 11:39:34', 0),
(20, 'Mohammed', 'Almousa', 'mmousa121@gmail.com', '123456789', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 20, '2023-06-09 11:41:49', '2023-06-09 11:41:49', 0),
(21, 'Alhariri', 'Ahmad', 'ahariri14@gmail.com', '04325632', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', 21, '2023-06-09 11:45:49', '2023-06-09 11:45:49', 0),
(40, 'test', 'test', 'test@gmail.com', '1234234234', '$2y$10$rvp8W.k3OLj9nxAhv5rZ1..Ui212tLYduygm8DYhuTZC4h8abR2XK', 40, '2023-06-20 15:51:48', '2023-06-20 15:51:48', 0),
(41, 'testt', 'testt', 'testrt@gmail.com', '132412312', '$2y$10$X/ZbnBS/l0WkQvFf5xCEc.2B8vWdQDhy6bDmDNDd2sq4cHaxvVKRO', 41, '2023-06-20 16:09:29', '2023-06-20 16:09:29', 0),
(42, 'Ahmad', 'Altaie', 'ataie@gmail.com', '097952573', '$2y$10$xM5cshzo.jKe3mH/c5DYM.kRYwMiF7EpwDEmNC0aT6xj9lB2Ny5JG', 42, '2023-06-20 16:27:05', '2023-06-20 16:29:22', 1),
(43, 'tamer', 'Altaie', 'ttaie@gmail.com', '097952573', '$2y$10$8XWjt3Q7xNVXiUq5Nux7/ecXuAdc2xcaD.IHpz2yAqBnKLzb8Wf6i', 43, '2023-06-20 16:30:50', '2023-06-20 16:30:50', 1),
(44, 'Ahmad', 'Haririd', 'amjadharirdi9@gmail.com', '+962778861789', '$2y$10$g2bWvGgBHp83NnWZFvVuO.c7aEADcC9PdCWAwH0QsIJ5yAUQ4Jf4.', 44, '2023-06-20 16:33:02', '2023-06-20 16:33:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `publish_date` date NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subjects_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `description`, `publish_date`, `class_id`, `section_id`, `subjects_id`, `teacher_id`) VALUES
(2, 'this is second post', '2023-04-03', 2, 1, 12, 12),
(3, 'this is first post', '2023-04-03', 2, 1, 2, 44),
(4, 'this is second post', '2023-04-03', 2, 1, 2, 44),
(5, 'this is first post for english class 5', '2023-04-23', 5, 1, 2, 44),
(6, 'this is second post english class 5', '2023-05-13', 5, 1, 2, 44),
(7, 'this is first post social studies', '2023-05-03', 2, 1, 6, 44),
(8, 'this is second post for social studies', '2023-05-11', 2, 1, 6, 44),
(11, 'social 2', '2023-05-11', 2, 0, 6, 44),
(12, 'this is english 1', '2023-05-22', 1, 0, 2, 44),
(27, 'this is english post\r\n', '2023-05-27', 1, 0, 2, 44),
(36, 'Prepare for the next Arabic class by reviewing the alphabet and practicing basic sounds. Also, familiarize yourself with common greetings and introductions', '2023-06-18', 1, 0, 1, 45),
(37, 'Homework for the next Arabic class: Review the alphabet, practice sounds, and learn greetings. Get ready for conversational practice next time.', '2023-06-18', 1, 0, 1, 45),
(38, 'Attention Arabic class students! Homework: Refresh alphabet knowledge, practice sounds, and master greetings. Prepare for conversational activities in the next class.', '2023-06-18', 1, 0, 1, 45),
(39, 'Dear students, upcoming Arabic class homework: Alphabet review, sound practice, and greetings. Be ready for engaging conversations in our next session.', '2023-06-18', 1, 0, 1, 45),
(40, 'For the next Arabic class, review alphabet and sounds, and learn greetings. Exciting conversations await in our upcoming session.', '2023-06-18', 1, 0, 1, 45);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `section_id` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `parent_id`, `first_name`, `last_name`, `class_id`, `class_name`, `section_id`, `section`, `created`, `modified`, `deleted`) VALUES
(1, 1, 'Mohamed', 'Hassan', '1', '1', 1, 'A', '2023-04-28 15:04:24', '2023-04-30 12:24:39', 0),
(2, 2, 'Bara', 'Alzoubi', '2', '2', 1, 'A', '2023-04-28 15:04:24', '2023-04-28 15:04:24', 0),
(3, 3, 'khalid', 'Wael', '1', '1', 2, 'B', '2023-04-28 15:04:24', '2023-04-29 12:35:44', 0),
(4, 4, 'Salem', 'Alnaser', '1', '1', 1, 'A', '2023-04-28 15:04:24', '2023-04-28 15:04:24', 0),
(5, 5, 'Awad', 'Alomari', '2', '2', 1, 'A', '2023-04-28 15:04:24', '2023-04-28 15:04:24', 0),
(6, 6, 'khalil', 'Aljasim', '1', '1', 2, 'B', '2023-04-28 15:04:24', '2023-04-29 12:36:41', 0),
(7, 7, 'ahmad', 'mohsen', '1', '1', 4, 'D', '2023-04-28 15:04:24', '2023-05-22 09:49:43', 0),
(9, 9, 'Yousef', 'Saeed', '1', '1', 1, 'A', '2023-04-28 19:59:35', '2023-04-28 20:02:37', 1),
(10, 10, 'Eyadeh', 'ALZoubi', '6', '6', 2, 'B', '2023-05-10 13:20:36', '2023-05-10 13:20:36', 0),
(11, 11, 'Ahmad', 'ALHafi', '5', '5', 1, 'A', '2023-05-11 09:01:09', '2023-05-11 09:01:09', 0),
(12, 12, 'Amjad', 'Hariri', '3', '3', 2, 'B', '2023-05-21 15:03:17', '2023-05-21 15:03:34', 1),
(13, 13, 'Mohameddd', 'Hassand', '1', '1', 1, 'A', '2023-06-01 19:04:20', '2023-06-01 19:04:20', 1),
(14, 14, 'Mohameddddd', 'Hassanddddd', '1', '1', 1, 'A', '2023-06-01 19:06:55', '2023-06-01 19:06:55', 1),
(15, 15, 'Mohamedd', 'Hassana', '1', '1', 1, 'A', '2023-06-01 20:18:18', '2023-06-01 20:18:18', 1),
(16, 16, 'Muhmmad', 'Farraj', '1', '1', 1, 'A', '2023-06-04 19:16:56', '2023-06-04 19:16:56', 0),
(17, 17, 'Albara', 'Shehadeh', '1', '1', 1, 'A', '2023-06-04 19:18:57', '2023-06-20 16:34:02', 0),
(18, 18, 'Hashem', 'Ali', '1', '1', 1, 'A', '2023-06-04 19:37:05', '2023-06-04 19:37:05', 0),
(19, 19, 'Bahaa', 'Almousa', '3', '3', 3, 'C', '2023-06-09 11:39:34', '2023-06-09 11:39:34', 0),
(20, 20, 'Bahaa', 'Almousa', '1', '1', 1, 'A', '2023-06-09 11:41:49', '2023-06-09 11:41:49', 0),
(21, 21, 'Tamer', 'Ahmad', '4', '4', 1, 'A', '2023-06-09 11:45:49', '2023-06-09 11:45:49', 0),
(40, 40, 'test', 'test', '2', '2', 1, 'A', '2023-06-20 15:51:48', '2023-06-20 15:51:48', 0),
(41, 41, 'testt', 'testt', '2', '2', 0, 'A', '2023-06-20 16:09:29', '2023-06-20 16:09:29', 0),
(42, 42, 'Lina', 'Altaie', '1', '1', 0, 'A', '2023-06-20 16:27:05', '2023-06-20 16:29:22', 1),
(43, 43, 'Lina', 'Altaie', '1', '1', 0, 'A', '2023-06-20 16:30:50', '2023-06-20 16:30:50', 1),
(44, 44, 'Amjadd', 'Haririd', '2', '2', 0, 'C', '2023-06-20 16:33:02', '2023-06-20 16:33:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Arabic'),
(2, 'English'),
(3, 'Islamic'),
(4, 'Math'),
(5, 'Science'),
(6, 'Social Studies');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `teacher_password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `first_name`, `last_name`, `email`, `phone`, `teacher_password`, `created`, `modified`, `deleted`) VALUES
(44, 'ahmad', 'mohsen', 'amohsen@gmail.com', '0794332222', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-09 10:43:36', '2023-06-01 20:34:05', 0),
(45, 'Yousef', 'Saeed', 'ASaeed@gmail.com', '+962778801457', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-09 11:00:32', '2023-06-18 13:02:39', 0),
(47, 'Amjad', 'Hariri', 'amjadhariri9@gmail.com', '+962778861789', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-10 12:29:32', '2023-05-10 12:29:32', 0),
(48, 'Raed', 'Salem', 'RS@gmail.com', '+962778806453', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-10 12:32:56', '2023-05-10 12:32:56', 0),
(49, 'Ahmad', 'Omar', 'Ao@gmail.com', '330132032', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-10 12:39:48', '2023-05-10 12:39:48', 1),
(50, 'Razi', 'Ahmad', 'RA@gmail.com', '098765432345', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-10 12:49:24', '2023-05-10 12:49:24', 0),
(51, 'Albara', 'Fawaz', 'AlbaraF@gmail.com', '07788466352', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-10 12:54:23', '2023-05-10 12:54:23', 0),
(52, 'Tawfeeq', 'Mefleh', 'tawfeeqm@gmail.com', '06783336224', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-13 14:15:34', '2023-05-13 14:15:34', 0),
(53, 'Salem', 'Jawad', 'salemj@gmail.com', '03304104334', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-05-13 14:17:26', '2023-05-22 09:38:40', 1),
(55, 'ahmad', 'mohsen', 'amohsedn@gmail.com', '0794332231', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-06-01 20:24:54', '2023-06-01 20:24:54', 1),
(62, 'leo', 'alzoubi', 'leozoubi@gmail.com', '077828282', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-06-04 19:13:13', '2023-06-04 19:13:13', 0),
(63, 'omar', 'aljarah', 'oaljarah@gmail.com', '2473534633', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-06-04 19:35:55', '2023-06-04 19:49:06', 0),
(64, 'Malek', 'Omari', 'malikomari10@gmail.com', '035932242', '$2y$10$ouaYcry7VVVYuNDE5TBTKuUNDPHb187pKpbL4OCFSF9Kq1Z/Pda7a', '2023-06-09 11:51:54', '2023-06-09 11:51:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subject_class`
--

CREATE TABLE `teacher_subject_class` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_subject_class`
--

INSERT INTO `teacher_subject_class` (`id`, `teacher_id`, `teacher_name`, `subject_id`, `subject_name`, `class_id`, `deleted`, `created`, `modified`) VALUES
(1, 44, 'ahmad', 2, 'English', 2, 0, '2023-05-09 12:32:33', '2023-05-09 12:32:33'),
(2, 45, 'Yousef', 3, 'Islamic', 6, 0, '2023-05-09 12:32:33', '2023-05-09 12:32:33'),
(3, 44, 'ahmad', 2, 'English', 5, 0, '2023-05-09 12:32:33', '2023-05-09 12:32:33'),
(4, 45, 'Yousef', 1, 'Arabic', 1, 1, '2023-05-09 12:32:33', '2023-05-09 12:32:45'),
(8, 44, 'ahmad', 6, 'Social Studies', 2, 0, '2023-05-09 13:54:04', '2023-05-09 13:54:04'),
(9, 47, 'Amjad', 3, 'Islamic', 2, 0, '2023-05-10 12:29:32', '2023-05-10 12:29:32'),
(10, 48, 'Raed', 1, 'Arabic', 4, 0, '2023-05-10 12:32:57', '2023-05-10 12:32:57'),
(11, 50, 'Razi', 6, 'Social Studies', 6, 0, '2023-05-10 12:49:24', '2023-05-10 12:49:24'),
(12, 51, 'Albara', 1, 'Arabic', 1, 0, '2023-05-10 12:54:23', '2023-05-10 12:54:23'),
(13, 45, 'Yousef', 3, 'Islamic', 1, 0, '2023-05-09 12:32:33', '2023-05-09 12:32:33'),
(14, 45, 'Yousef', 1, 'Arabic', 5, 0, '2023-05-09 12:32:33', '2023-05-09 12:32:45'),
(15, 46, 'aaaa', 5, 'Science', 5, 1, '2023-05-09 12:59:56', '2023-05-21 17:10:41'),
(16, 46, 'aaaa', 4, 'Math', 5, 1, '2023-05-09 13:52:50', '2023-05-21 17:10:41'),
(17, 44, 'ahmad', 6, 'Social Studies', 5, 0, '2023-05-09 13:54:04', '2023-05-21 15:27:44'),
(18, 52, 'Tawfeeq', 3, 'Islamic', 6, 0, '2023-05-13 14:15:34', '2023-05-13 14:15:34'),
(19, 53, 'Salem', 5, 'Science', 2, 1, '2023-05-13 14:17:26', '2023-05-22 09:38:40'),
(20, 54, 'Tarek', 1, 'Arabic', 6, 1, '2023-05-21 14:56:00', '2023-05-21 17:53:52'),
(21, 44, 'ahmad', 2, 'English', 1, 1, '2023-05-21 17:55:40', '2023-05-21 17:55:43'),
(22, 55, 'ahmad', 1, 'Arabic', 1, 0, '2023-06-01 20:24:54', '2023-06-01 20:24:54'),
(30, 63, 'omar', 2, 'English', 1, 0, '2023-06-04 19:35:55', '2023-06-04 19:35:55'),
(31, 63, 'omar', 2, 'English', 3, 0, '2023-06-04 19:42:07', '2023-06-04 19:42:07'),
(32, 64, 'Malek', 4, 'Math', 2, 0, '2023-06-09 11:51:54', '2023-06-09 11:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `vice`
--

CREATE TABLE `vice` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vice`
--

INSERT INTO `vice` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES
(136832, 'amjad', 'hariry', 'am@gmail.com', '5464654', '$2y$10$qb7vmSa2UIBp9FYXVD8rcOPSW2FKITgdWquVfdccr7DQJ/JjyH6q2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_new_student`
--
ALTER TABLE `add_new_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `add_new_teacher`
--
ALTER TABLE `add_new_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_subject_class`
--
ALTER TABLE `teacher_subject_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vice`
--
ALTER TABLE `vice`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_new_student`
--
ALTER TABLE `add_new_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `add_new_teacher`
--
ALTER TABLE `add_new_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1617;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140844;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=918;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `teacher_subject_class`
--
ALTER TABLE `teacher_subject_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `vice`
--
ALTER TABLE `vice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136834;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
