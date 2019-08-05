-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2017 at 01:21 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dewsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `role_id` int(11) NOT NULL,
  `municipality_id` int(50) DEFAULT NULL,
  `province_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cellphone_num` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `profile_img`, `role_id`, `municipality_id`, `province_id`, `email`, `password`, `remember_token`, `position`, `designation`, `created_at`, `updated_at`, `cellphone_num`) VALUES
(1, 'Developer', 'Root', 'rootews', 'http://localhost/blog/public/photos/1/123.jpg', 1, 31, 3, 'sangwayjoel@gmail.com', '$2a$04$NJwoDtyzt6yGwjwV0vuuo.t./8YCG70laRxuRVUpB955cK/ML00o.', 'GKgHvnaOJBpvlhfyFyrma32efh0r96jR7lwiIXAzRusnwx9EbNj30RYU6L0u', 'SRSI', 'DEWS', '2016-12-06 02:11:55', '2017-04-11 02:49:35', '09465854398'),
(2, 'Lowil Ray', 'Delos Reyes', 'lowilray_dr', '1486024864.jpg', 1, 31, 3, 'lowildlr10@gmail.com', '$2y$10$THOUczv0J92JbnASXa4hGOELLnEfLGgRXCNKUnsljfP5rENP67TYi', 'fZ9ibgNzuJFsb4wfvzSSBVygZ3o4dP4kF2pAMds5vi9486oyjlWIONqKJp4h', 'PA II', 'Technical', '2016-12-06 02:17:46', '2017-04-10 03:26:43', '09129527475'),
(11, 'Juan Jr.', 'Go', 'juan_jr._g', 'default.jpg', 4, 51, 1, 'abramdrrmo01@gmail.com', '$2y$10$CNOJRanrm.U5Hjd/s6TczeaGdSMDDYlP.E.gJlgNQU4nUo0fA2teO', NULL, '', '', '2016-12-13 01:08:32', '2016-12-13 01:08:32', '09773582452'),
(12, 'Elmer', 'Bersamin', 'elmer_b', 'default.jpg', 2, 51, 1, 'elmerbersamin8@yahoo.com', '$2y$10$rsALv3ryKzmFVh8uARpVgegmPwxgZcRfP4UBf9U29BdA3l2GHrKc.', NULL, '', '', '2016-12-13 01:11:14', '2016-12-13 01:11:14', '09955227013'),
(13, 'Rameses', 'Baay', 'rameses_b', 'default.jpg', 3, 52, 1, 'abramdrrmo02@gmail.com', '$2y$10$1u.x90c7VbP4AqGA1kSSy.KQ5ZqaZs3RQl3XNH2cj7Et//fT71ZTW', NULL, '', '', '2016-12-13 01:11:55', '2016-12-13 01:11:55', '09273103350'),
(14, 'Benjamin Jr.', 'Ballera', 'benjamin_jr._b', 'default.jpg', 4, 53, 1, 'bengonzales449@yahoo.com', '$2y$10$VkpNTdJKlqojIh/j.Io8F.ORV3RSzW1s6K/YDjNS.AMgRZx2vvyDm', NULL, '', '', '2016-12-13 01:12:50', '2016-12-13 01:12:50', '09085552854'),
(15, 'Sandy', 'Lingayo', 'sandy_l', 'default.jpg', 4, 54, 1, 'sandylingayo@yahoo.com', '$2y$10$NpAmvBCtLDkmsjyzSon4HudVSNFsLfhja7W/MURuacQFQ9tNrWCtq', NULL, '', '', '2016-12-13 01:14:25', '2016-12-13 01:14:25', '09179972301'),
(16, 'Douglas Nelson', 'Batalla', 'douglas_nelson_b', 'default.jpg', 4, 55, 1, 'abramdrrmo03@gmail.com', '$2y$10$2TbrzOmhrw3tlBT1PnBWTe2Ci1Ze2GSVuRs62vVsFN45tDVc04/1S', NULL, '', '', '2016-12-13 01:16:00', '2016-12-13 01:16:00', '09272541149'),
(17, 'Rolando', 'Patagui', 'rolando_p', 'default.jpg', 3, 56, 1, 'abramdrrmo04@gmail.com', '$2y$10$u.FluGeooNh5m6/xtCDzC.S8qdoXCuG8ycWLWr9XKYFkveWHnr58O', NULL, '', '', '2016-12-13 01:17:24', '2016-12-13 01:17:24', '09085552813'),
(18, 'Norwin', 'Bisares', 'norwin_b', 'default.jpg', 3, 57, 1, 'norwinzbisares@yahoo.com', '$2y$10$Otprm9ZuU65ICcNWcpqoz.bySx9TMWhYTJakhI9mJtQqFBjs6O.XG', NULL, '', '', '2016-12-13 01:19:17', '2016-12-13 01:19:17', '09155756200'),
(19, 'Frederick', 'Bose', 'frederick_b', 'default.jpg', 4, 58, 1, 'abramdrrmo05@gmail.com', '$2y$10$oE6pHgO05I64Vgdqsg7XTuwyv64sm0TO6f0peZvNUJIBgpYFX8VB.', NULL, '', '', '2016-12-13 01:20:03', '2016-12-13 01:20:03', '09978752186'),
(20, 'Cielo Mar', 'Caoagas', 'cielo_mar_c', 'default.jpg', 4, 59, 1, 'abramdrrmo06@gmail.com', '$2y$10$F4HPMYZLI3CBhKeh6tv4E.r3dubZwVYq3yb.4g1zfNo1jD0pdCoTW', NULL, '', '', '2016-12-13 01:20:33', '2016-12-13 01:20:33', '09972023560'),
(21, 'Micheal', 'Brillantes', 'micheal_b', 'default.jpg', 4, 60, 1, 'daisymadriaga68@gmail.com', '$2y$10$1sMFeSo/C72iAdLHDdW60e6vv4eSUCdPTzmKY4jzwYf/URxl.GXMm', NULL, '', '', '2016-12-13 01:21:04', '2016-12-13 01:21:04', '09165246694'),
(22, 'Daisy', 'Madriaga', 'daisy_m', 'default.jpg', 4, 61, 1, 'abramdrrmo07@gmail.com', '$2y$10$M2lEr9i6Ri9hiT6L.XG1LugZRvW9028Ej0JRIbNjDjqoLLBIOQnqy', NULL, '', '', '2016-12-13 01:21:47', '2016-12-13 01:21:47', '09069488560'),
(23, 'Mark William', 'Osana', 'mark_william_o', 'default.jpg', 4, 62, 1, 'mwb.osana@yahoo.com.ph', '$2y$10$5LQ0v6M.1GH0g29AJWDQauzFz/W3KxdG6zXhny7yjkatBzSieegwa', NULL, '', '', '2016-12-13 01:22:24', '2016-12-13 01:22:24', '09273756760'),
(24, 'Erosbon', 'Sabedo', 'erosbon_s', 'default.jpg', 4, 63, 1, 'erosbon.sabedo@gmail.com', '$2y$10$G1FTvGcbennuPSFv5iTrZebPmYYqwfXc53WMTkE4GODBBhts2e.WW', NULL, '', '', '2016-12-13 01:22:53', '2016-12-13 01:22:53', '09209584769'),
(25, 'Dennis', 'Gayyed', 'dennis_g', 'default.jpg', 4, 64, 1, 'gayyeddennis@gmail.com', '$2y$10$tAUBgblBBOXVu.mC0/fGiO/uWryYDoxn6C5XWOXS4ZHXqDuNeQ0tm', NULL, '', '', '2016-12-13 01:23:28', '2016-12-13 01:23:28', '09175167311'),
(26, 'Jimmy', 'Bacuyag', 'jimmy_b', 'default.jpg', 4, 65, 1, 'ymybacuyag1124@gmail.com', '$2y$10$eeL3dYWdsdvuumQlb3h//eOMywDG.Zr597p0osXoWiwcLPbsQAPWi', NULL, '', '', '2016-12-13 01:24:04', '2016-12-13 01:24:04', '09954306319'),
(27, 'Francis', 'Blancaflor', 'francis_b', 'default.jpg', 4, 66, 1, 'blancaflor_francis@yahoo.com', '$2y$10$YXL01lsx.F7ulHlCWpwZNOuyHYg6w2yTAQ8jvILMYV36bSYuk8/ne', NULL, '', '', '2016-12-13 01:24:43', '2016-12-13 01:24:43', '09178434711'),
(28, 'Myrna', 'Baga', 'myrna_b', 'default.jpg', 3, 67, 1, 'mg_baga@yahoo.com', '$2y$10$0mi5DS7DMSVcyltKRD7vS.K5Ir07LtYIo1.qHIZ.DJWgmrR1xytbu', NULL, '', '', '2016-12-13 01:25:17', '2016-12-13 01:25:17', '09778156924'),
(29, 'Elmer Allan', 'Borja', 'elmer_allan_b', 'default.jpg', 4, 68, 1, 'emerallan17@yahoo.com', '$2y$10$KgThdPjHvTSG2Cv0WAz.9e./xL9VHsDuiFWyH2vVfxc014lMTRf3O', NULL, '', '', '2016-12-13 01:25:45', '2016-12-13 01:25:45', '09750215500'),
(30, 'Petronilo', 'Pamlas', 'petronilo_p', 'default.jpg', 3, 69, 1, 'deltronpamlas@yahoo.com.ph', '$2y$10$bvAX7L9aC8YaEX0vsWt6zeIPitq8R1VNuBfhcJ9iy.MsPX74ZLLza', NULL, '', '', '2016-12-13 01:26:15', '2016-12-13 01:26:15', '09274068196'),
(31, 'Marcelino', 'Manggad', 'marcelino_m', 'default.jpg', 4, 70, 1, 'xo11564@yahoo.com', '$2y$10$kigZoJ9W75xkC70Eafn6F.V5T8eDSdSdRfG7evpMiUM5cx1k6pR0a', NULL, '', '', '2016-12-13 01:26:42', '2016-12-13 01:26:42', '09053001964'),
(32, 'Alexis', 'Santua', 'alexis_s', 'default.jpg', 4, 71, 1, 'dlmbragas@yahoo.com ', '$2y$10$EEJCEjTmkYaMEE01zdXBRetQ7UYcJXcKB7N6hr7rPnI6QSyWEv0kS', NULL, '', '', '2016-12-13 01:27:10', '2016-12-13 01:27:10', '09156407547'),
(33, 'Adelmo', 'Bragas', 'adelmo_b', 'default.jpg', 4, 72, 1, 'abramdrrmo08@gmail.com', '$2y$10$ZSQHTbSfQvmgSKVa58bHW.Zx8acYyztJRZz0OVgTThFfMcJ5OJG8a', NULL, '', '', '2016-12-13 01:27:37', '2016-12-13 01:27:37', '09175693379'),
(34, 'Rudy Jr.', 'Palecpec', 'rudy_jr._p', 'default.jpg', 4, 73, 1, 'abramdrrmo09@gmail.com', '$2y$10$UXgGfOq6Jk6fsx89wVk3C.inmOmRB8ZCZ0jG9HM9ryI6b11kcxOA6', NULL, '', '', '2016-12-13 01:28:03', '2016-12-13 01:28:03', '09268475487'),
(35, 'Ar-bi', 'Arciaga', 'ar-bi_a', 'default.jpg', 4, 74, 1, 'lgu.tayum@yahoo.com', '$2y$10$iFoAy88lsKBoexjzWzCiseRNVe1OCAHbOfiY4gGfVcmtHkIX.lfdm', NULL, '', '', '2016-12-13 01:28:31', '2016-12-13 01:28:31', '09369673988'),
(36, 'Rodolfo', 'Canam', 'rodolfo_c', 'default.jpg', 3, 75, 1, 'abramdrrmo10@gmail.com', '$2y$10$k9Bk.DV624f8k6BCPLZfF.f/vEYMGYSgNZGJfRcp4MPZr1B5Y65Gi', NULL, '', '', '2016-12-13 01:28:57', '2016-12-13 01:28:57', '09154976480'),
(37, 'Regina', 'Tayawa', 'regina_t', 'default.jpg', 3, 76, 1, 'tayawa.regina@yahoo.com.ph', '$2y$10$s3Fv3ciO43TgCSQBVJKKHeGVs3QkprHR.HZQQ4VmRDeLMrnBsoLe2', NULL, '', '', '2016-12-13 01:29:23', '2016-12-13 01:29:23', '09154403540'),
(38, 'Evelyn', 'Vergara', 'evelyn_v', 'default.jpg', 4, 77, 1, 'evelynsvergara72@yahoo.com', '$2y$10$f4yzFmzTUG8IrahkFDIiPO/WxWxBY/ylBN1mmm1RaGeC75ZhNfwgS', NULL, '', '', '2016-12-13 01:29:44', '2016-12-13 01:29:44', '09279870094'),
(39, 'Jeoffrey', 'Borromeo', 'jeoffrey_b', 'default.jpg', 2, 44, 2, 'pdrrmo_apayao@yahoo.com.ph', '$2y$10$Xb6zVTePA7sgBelz2HapXO.cV1zU6MO5S4rVypGHLaoA4iDXmmgh6', NULL, '', '', '2016-12-13 01:32:08', '2016-12-13 01:32:08', '09175053400'),
(40, 'Francisco', 'Florendo', 'francisco_f', 'default.jpg', 4, 44, 2, 'franciscobflorendojr@gmail.com', '$2y$10$uLbJ9YVbbknnH2XjuEXMFeCXa6MJjGqqLnHVOOsSsoB.qqz/KDxWO', NULL, '', '', '2016-12-13 01:32:35', '2016-12-13 01:32:35', '09067701208'),
(41, 'Albert', 'Bacuyag', 'albert_b', 'default.jpg', 4, 45, 2, 'connerlgu@yahoo.com', '$2y$10$RbzHnLzmZMjAbjatrM9nP.2fDaawNq7MhoZScN6jHgX7vP6ezdLA2', NULL, '', '', '2016-12-13 01:34:22', '2016-12-13 01:34:22', '09066991298'),
(42, 'Danillo', 'Vicente', 'danillo_v', 'default.jpg', 4, 46, 2, 'danilitomontanez@gmail.com', '$2y$10$rFtdDnnYH/Tdh7fwS2urEO3istP6DAYmwsDhWrDb2Re6hpxVpSIoi', NULL, '', '', '2016-12-13 01:34:44', '2016-12-13 01:34:44', '09163433184'),
(43, 'Mathew', 'Pulog', 'mathew_p', 'default.jpg', 4, 47, 2, 'lgukabugao@yahoo.com', '$2y$10$WwMtiYqRs/kWTuR6kPhH6uBx94LuKZUrASC.BLnYd.NGmZAo649.S', NULL, '', '', '2016-12-13 01:35:06', '2016-12-13 01:35:06', '09267161598'),
(44, 'Samuel', 'Calilan', 'samuel_c', 'default.jpg', 4, 48, 2, 'apayaomdrrmo01@gmail.com', '$2y$10$Jjr.y6JLnSxIu/sVgp9v6uXA.ElR20MbS3AXrcowhg0LyaF0eFtMi', NULL, '', '', '2016-12-13 01:35:28', '2016-12-13 01:35:28', '09067653388'),
(45, 'Pidencio', 'Castillo', 'pidencio_c', 'default.jpg', 3, 49, 2, 'mpdo_pudtol@yahoo.com', '$2y$10$TViTUSYIp7WNvEOIfZeDROrundp6ZtZVJbJVs6fKHmsUrIk2rwlxO', NULL, '', '', '2016-12-13 01:35:51', '2016-12-13 01:35:51', '09058136738'),
(46, 'Eduardo', 'Mangoba', 'eduardo_m', 'default.jpg', 4, 50, 2, 'eduardojr.mangoba@yahoo.com.ph', '$2y$10$tba6tQoX28OenwJJozpEBuezKueRVbIivy/hElDRG8LLEJ5WY8kFi', NULL, '', '', '2016-12-13 01:36:21', '2016-12-13 01:36:21', '09067653388'),
(47, 'Tuho', 'Chapdian', 'tuho_c', 'default.jpg', 2, 30, 3, 'benguetpdrrmo01@gmail.com', '$2y$10$N4Bjj8TrI1ZRsyn4JBYoLuN1HTh0HJBBIOR3KqynNBjOaIcabOTFu', NULL, '', '', '2016-12-13 01:38:03', '2016-12-13 01:38:03', ''),
(48, 'Jessie', 'Domeris', 'jessie_d', 'default.jpg', 2, 30, 3, 'jcjose_dmrs@yahoo.com', '$2y$10$7cQ5rvAdQQ7CslpQG8CPQ.cSKEQxSeV2Ylp.8HsnoApyCZErwIBWm', NULL, '', '', '2016-12-13 01:39:12', '2016-12-13 01:39:12', '09105440780'),
(49, 'Merlyn', 'Celo', 'merlyn_c', 'default.jpg', 4, 30, 3, 'merlynsscelo@gmail.com', '$2y$10$0lmJkN0AKFZUBvznqIXLJuY/ior3j5hE/5JFFshI30iSIliV7UFGq', NULL, '', '', '2016-12-13 01:40:34', '2016-12-13 01:40:34', '09070102240'),
(50, 'Engr. Yolanda', 'Munar', 'engr._yolanda_m', 'default.jpg', 4, 31, 3, 'benguetmdrrmo01@gmail.com', '$2y$10$4L.C6K9jqI5XrTvFajQKXuQF4WfuntqQu8SBI5AfpEyX4k89ug.qu', NULL, '', '', '2016-12-13 01:41:13', '2016-12-13 01:41:13', '09263082427'),
(51, 'Julius', 'Santos', 'julius_s', 'default.jpg', 4, 31, 3, 'saintjuls@gmail.com', '$2y$10$R34zr6f00hr7zE4iVxKkc.IiGT0fdtoHWbenpniph6pDq/OCotaKG', NULL, '', '', '2016-12-13 01:42:16', '2016-12-13 01:42:16', '09274012981'),
(52, 'Bado', 'Pasule', 'bado_p', 'default.jpg', 2, 32, 3, 'benguetmdrrmo02@gmail.com', '$2y$10$eiSbAYQrD3W.dSMHGWTspen15FVCQ5lBROJoctsVu4cDX0EQBk27C', NULL, '', '', '2016-12-13 01:42:37', '2016-12-13 01:42:37', '09392849400'),
(53, 'Alma', 'Macay', 'alma_m', 'default.jpg', 4, 33, 3, 'benguetmdrrmo03@gmail.com', '$2y$10$qT80mm.3ZQQQ9IbSgFViyuS8UQIjRrBhzr0jnfdbRImxDESJo/SBS', NULL, '', '', '2016-12-13 01:42:56', '2016-12-13 01:42:56', '09202259333'),
(54, 'Satur', 'Payangdo', 'satur_p', 'default.jpg', 4, 34, 3, 'benguetmdrrmo04@gmail.com', '$2y$10$7R9OFTfLimuuli/Lt6fZ/.urJHNGMw5tB0MDbgpFOMf4sF./MRFt.', NULL, '', '', '2016-12-13 01:43:29', '2016-12-13 01:43:29', '09184702848'),
(55, 'Cyril', 'Batcagan', 'cyril_b', 'default.jpg', 4, 35, 3, 'cyrilbatcagan@gmail.com', '$2y$10$MO5dMOi314J.PfGDuF4R6u6KsOdH0Lcedf.pqYnAveYsD6Z/3moFC', NULL, '', '', '2016-12-13 01:44:16', '2016-12-13 01:44:16', '09198916115'),
(56, 'Eugene', 'Daoal', 'eugene_d', 'default.jpg', 4, 36, 3, 'gudzdaoal@gmail.com', '$2y$10$4u5LUg0L98Uv6U25R2/QB.chIzswuJEKsy8AOkzavz.STdt.Ks5rG', NULL, '', '', '2016-12-13 01:44:44', '2016-12-13 01:44:44', '09296424030'),
(57, 'Winston', 'Palaes', 'winston_p', 'default.jpg', 3, 37, 3, 'benguetmdrrmo05@gmail.com', '$2y$10$6/zjzJrn5hQBLukYyZOm4OkJ2hJ6Szr8uUThs6IVbxudEbdIBwT3i', NULL, '', '', '2016-12-13 01:45:10', '2016-12-13 01:45:10', '09485645284'),
(58, 'Elma', 'Eliw', 'elma_e', 'default.jpg', 4, 38, 3, 'emmarie822@gmail.com', '$2y$10$U1Ty7TPZa3TYgRd/gO42cOJuXlqlBJ3P.e/Bw4Sbp/vkSep3XCasa', NULL, '', '', '2016-12-13 01:45:38', '2016-12-13 01:45:38', '09397833666'),
(59, 'Yoshio', 'Labi', 'yoshio_l', 'default.jpg', 3, 39, 3, 'benguetmdrrmo06@gmail.com', '$2y$10$nvelQsKrrG/F8p0t1XAN6uJ6NFYXS6rWiTAnN2EKhJE0BYjRVIp2W', NULL, '', '', '2016-12-13 01:46:05', '2016-12-13 01:46:05', '09995990789'),
(60, 'Mateo Jr.', 'Estalin', 'mateo_jr._e', 'default.jpg', 4, 40, 3, 'mestalinjr@yahoo.com', '$2y$10$iQeddCzTlj2abjmabKLlfO8y6VtmEV5.hwCWschx9e7bVaimy.bhS', NULL, '', '', '2016-12-13 01:46:30', '2016-12-13 01:46:30', '09463225734'),
(61, 'Galo', 'Santa', 'galo_s', 'default.jpg', 4, 41, 3, 'galo_santa@yahoo.com', '$2y$10$4Ajl.k4xqlX5WYcKUMl3/Oh9Dte1I5RDGqkLlc49SyYyQYtXhK/dG', NULL, '', '', '2016-12-13 01:46:52', '2016-12-13 01:46:52', '09074984637'),
(62, 'Clarita', 'Lardizabal', 'clarita_l', 'default.jpg', 4, 42, 3, 'tubamdrrmoclardizabal@gmail.com', '$2y$10$dl7MNlWA2VyUqTBuD4Yi9uzOpH6Uz27OoDnreXOC0KOdxHgEtNjCK', NULL, '', '', '2016-12-13 01:47:16', '2016-12-13 01:47:16', '09205870956'),
(63, 'Abner', 'Lawangen', 'abner_l', 'default.jpg', 4, 43, 3, 'benguetmdrrmo07@gmail.com', '$2y$10$PPsm.3TV8TcqoxsGP5f7keo.9e56i9yEzxfN70FOzkTE8SC90GpcK', NULL, '', '', '2016-12-13 01:47:37', '2016-12-13 01:47:37', '09392495735'),
(64, 'Edna', 'Duhan', 'edna_d', 'default.jpg', 2, 19, 4, 'ifugaopdrrmo01@gmail.com', '$2y$10$zNpQZ6DXkCMZNaI9MXQpv.4onEIaTTHIvVyYDN0erEbRLu1VW5GTK', NULL, '', '', '2016-12-13 01:48:09', '2016-12-13 01:48:09', '09993375146'),
(65, 'Operation Center', '', 'operation_center_', 'default.jpg', 2, 19, 4, 'pdrrmo_ifugao08@yahoo.com', '$2y$10$Z/jCp7t1YSmaeD9JG1nlNexV60gytbiu7XrEBqYVOLAJPwnKLA0hS', NULL, '', '', '2016-12-13 01:48:32', '2016-12-13 01:48:32', '09153805694'),
(66, 'Andres', 'Longatan', 'andres_l', 'default.jpg', 4, 19, 4, 'andreslongatan@yahoo.com', '$2y$10$ExI/yY761z0NNvWUaaM/K.lctpTJz3e3TObtgwxdwt2jK34sCgZGO', NULL, '', '', '2016-12-13 01:48:53', '2016-12-13 01:48:53', '09175958200'),
(67, 'Lolina', 'Tuguinay', 'lolina_t', 'default.jpg', 4, 20, 4, 'lolina.tuguinay@yahoo.com', '$2y$10$s4GYrwduwXovGueDsg/8NOkO3GtVEhiyf4GAvk6dTiJVF0iTEfyEy', NULL, '', '', '2016-12-13 01:49:14', '2016-12-13 01:49:14', '09359138928'),
(68, 'Wesly', 'Daulayan', 'wesly_d', 'default.jpg', 3, 21, 4, 'ifugaomdrrmo01@gmail.com', '$2y$10$VLDswRyQfSPAPbpwp93ybuoaBhp6AZWDF2.a9XiD6Z0ipLoB83TIK', NULL, '', '', '2016-12-13 01:49:42', '2016-12-13 01:49:42', '09392880115'),
(69, 'Ronalyn', 'Tgulingon', 'ronalyn_t', 'default.jpg', 4, 21, 4, 'rtaguilingon@yahoo.com', '$2y$10$mhtnp.3wgEUN05RSGTsk4uTYiwXPZfGzMM80xzL7AHMGoYR6Cgm46', NULL, '', '', '2016-12-13 01:50:14', '2016-12-13 01:50:14', '09368048364'),
(70, 'Antonio', 'Gayyuma', 'antonio_g', 'default.jpg', 4, 22, 4, 'ifugaomdrrmo02@gmail.com', '$2y$10$bJ.yE/RnBiAIU7wGGpQoOOL6HqpcPgEoPGVjrlh91HnrOorp1TJvS', NULL, '', '', '2016-12-13 01:50:36', '2016-12-13 01:50:36', ''),
(71, 'Hazel', 'Gayamo', 'hazel_g', 'default.jpg', 4, 23, 4, 'omayag@yahoo.com', '$2y$10$NGq7HKsojYCkkTLXyZVwaOBtxMpr8juh7TvA3kJIQUFUlujvXZy1O', NULL, '', '', '2016-12-13 01:51:03', '2016-12-13 01:51:03', '09262605241'),
(72, 'Mauro', 'Bandao', 'mauro_b', 'default.jpg', 4, 24, 4, 'mauro_bandao@yahoo.com', '$2y$10$NJCVBOgQoAqicU.ovh6Cgecm2xmmTO2E7Rrs96EqHUaSEV7eLUWOy', NULL, '', '', '2016-12-13 01:51:25', '2016-12-13 01:51:25', ''),
(73, 'Ramil', 'Licyayo', 'ramil_l', 'default.jpg', 3, 25, 4, 'kianganlgu@yahoo.com', '$2y$10$ikKfi8RUxLDCYomcR5XKT.Nq./XvIOYifqGTBQbNrC/RPCzKXozxC', NULL, '', '', '2016-12-13 01:54:17', '2016-12-13 01:54:17', '09062061803'),
(74, 'Noel', 'Campul', 'noel_c', 'default.jpg', 3, 26, 4, 'noelcampul@yahoo.com.ph', '$2y$10$03s7v3c4TjsFp04wIx/nE.KCdjo1HlgZxQFxWaB7cfkbzPGFQqFLq', NULL, '', '', '2016-12-13 01:55:44', '2016-12-13 01:55:44', '09269772819'),
(75, 'Junifer', 'Ngannoy', 'junifer_n', 'default.jpg', 4, 27, 4, 'papaalpha08@yahoo.com', '$2y$10$Q8PrG.DL9/K1y1Tt56n6Ce2Apd7gw.3jcVQsD8SFRu46F8GadlvoG', NULL, '', '', '2016-12-13 01:56:40', '2016-12-13 01:56:40', '09178040423'),
(76, 'Ronald', 'Chug-e', 'ronald_c', 'default.jpg', 3, 28, 4, 'mdrrm_maya@yahoo.com.ph', '$2y$10$hPIY2M6ogm3tH9kWRLnD6.uyg6Q0QBRPuVN4Ebg7FqSKC0ta.plVi', NULL, '', '', '2016-12-13 01:57:58', '2016-12-13 01:57:58', '09776049085'),
(77, 'Rosemarie', 'Caoili', 'rosemarie_c', 'default.jpg', 4, 29, 4, 'payscaoili@gmail.com', '$2y$10$mdqiA7r83ePPiV2v2ZvwbeUCfCNvmrfMmLrfh09FLCXDRI6hsBau6', NULL, '', '', '2016-12-13 01:58:49', '2016-12-13 01:58:49', '09277442338'),
(78, 'Richard', 'Anniban', 'richard_a', 'default.jpg', 2, 11, 5, 'pdrrmc_kalinga@yahoo.com', '$2y$10$GmqkrGO6i53GpMFH0.9y8OjVPq0q7jzRIgKTpxPwHZD3FwSvaX2Ie', NULL, '', '', '2016-12-13 02:04:48', '2016-12-13 02:04:48', '09398243242'),
(79, 'Cristeta', 'Reyes', 'cristeta_r', 'default.jpg', 4, 11, 5, 'cristetamreyes@yahoo.com', '$2y$10$kWyGQECe00R2TPrZZSSArewybYeVOo9jwzGZI2CKkRMZUZBXKNZdy', NULL, '', '', '2016-12-13 02:05:19', '2016-12-13 02:05:19', '09989821078 '),
(80, 'Perlita', 'Tumbali', 'perlita_t', 'default.jpg', 3, 11, 5, 'pellittumbali@yahoo.com', '$2y$10$bId95YmcbA/.sUMZNbrZx.LyHNsiZ14aGqdR3J6LOxY6RddQcMLnm', NULL, '', '', '2016-12-13 02:05:41', '2016-12-13 02:05:41', '09989511284'),
(81, 'Beatriz', 'Massilem', 'beatriz_m', 'default.jpg', 4, 12, 5, 'mswdolubuagan@yahoo.com.ph', '$2y$10$FE7MEhFeiTSUNLpAr59rEOwewy/3w8QhWg6BptFM8eEeKsJpB1pZm', NULL, '', '', '2016-12-13 02:06:11', '2016-12-13 02:06:11', '09282475212'),
(82, 'Marilyn', 'Pagutayao', 'marilyn_p', 'default.jpg', 4, 13, 5, 'lgu_pasil@yahoo.com', '$2y$10$CtHcnHq6gV.M/3gHlT/F1OvvKfivgF7FXM1OBZ5JWlpglUptAtYby', NULL, '', '', '2016-12-13 02:06:40', '2016-12-13 02:06:40', '09083337789'),
(83, 'Fatima', 'Lagayon', 'fatima_l', 'default.jpg', 4, 14, 5, 'kalingamdrrmo01@gmail.com', '$2y$10$EdEvLxHfePwbcIZ4STj4VeJ9LV7QCkkvedwa6DkhePM6Zlg8uKyB.', NULL, '', '', '2016-12-13 02:06:58', '2016-12-13 02:06:58', '09265301732'),
(84, 'Carolina', 'Luzuriaga', 'carolina_l', 'default.jpg', 4, 15, 5, 'rizalkalinga@yahoo.com.ph', '$2y$10$8uvSkMWxdlFNTwxPxDfrYeqFBS/5WQX9oZ65cjaB0xN1Tzf19PbHm', NULL, '', '', '2016-12-13 02:07:26', '2016-12-13 02:07:26', '09173079989'),
(85, 'Christian', 'Luyaben', 'christian_l', 'default.jpg', 2, 16, 5, 'cdrrm.Tabuk@yahoo.com', '$2y$10$YuVnX66XfmY7NeX1W6HhoOkQ92Ihp3hQkjk9dfeak/ofE.6Pt8NJm', NULL, '', '', '2016-12-13 02:07:50', '2016-12-13 02:07:50', '09472983004'),
(86, 'Arles', 'Villanueva', 'arles_v', 'default.jpg', 4, 16, 5, 'ajrv73@yahoo.com', '$2y$10$8mOzWpdCkytPncc0GDrApOBQXs2eUcxrjkzI8p4tW0VxHo8kMBr6u', NULL, '', '', '2016-12-13 02:08:21', '2016-12-13 02:08:21', '09214737540'),
(87, 'Anthony', 'Cosidon', 'anthony_c', 'default.jpg', 4, 17, 5, 'kalingamdrrmo02@gmail.com', '$2y$10$JOMlxKqU4uTyVTc.4RFwSOJbsAYNCIP.3hTTZGk7Mo92u6DvHDtlK', NULL, '', '', '2016-12-13 02:08:42', '2016-12-13 02:08:42', '09204923658'),
(88, 'Denber', 'Alngag', 'denber_a', 'default.jpg', 4, 18, 5, 'denber_alngag@yahoo.com', '$2y$10$ApiqT4RMpYP/u3I3RFdTqOW7OIY/JWVJnMSYOeJNbuIsCNUqbyCVe', NULL, '', '', '2016-12-13 02:09:07', '2016-12-13 02:09:07', '09069277852'),
(89, 'Atty. Edward Jr.', 'Chumawar', 'atty._edward_jr._c', 'default.jpg', 2, 1, 6, 'mppdrrmo01@gmail.com', '$2y$10$YjdZAXdLUR5TUHrvTshye.KyLkcJhS6C2iOrpc1zBfEdtUEd6A4cy', NULL, '', '', '2016-12-13 02:09:42', '2016-12-13 02:09:42', ' 09088150628'),
(90, 'Eric Kristoffer', 'Chan', 'eric_kristoffer_c', 'default.jpg', 4, 1, 6, 'barligmdrrmo@gmail.com', '$2y$10$G1q3KSpTmbj/DOmxWPwJburRH2Uk2jKbInEb3T58cd4qoLMSOHO6e', NULL, '', '', '2016-12-13 02:10:02', '2016-12-13 02:10:02', ' 09754781090'),
(91, 'Clarence', 'Golocan', 'clarence_g', 'default.jpg', 4, 2, 6, 'nacologo3@yahoo.com', '$2y$10$YXdBd6hDKfgMy0FE0PYF6.V16ZfaiE/5s6iQZ6SQF8AjgjBrN7frW', NULL, '', '', '2016-12-13 02:10:32', '2016-12-13 02:10:32', ' 09464153965'),
(92, 'Mildred', 'Piluden', 'mildred_p', 'default.jpg', 3, 3, 6, 'mildred_piluded@yahoo.com', '$2y$10$XPUASazyOQWrs8s11D/BROilyWRfdLbFFzCtZiSjXehJibPhy9/0S', NULL, '', '', '2016-12-13 02:10:51', '2016-12-13 02:10:51', '09999916026 '),
(93, 'Johanna', 'Padaen', 'johanna_p', 'default.jpg', 4, 4, 6, 'mdrrmo_bontoc@yahoo.com', '$2y$10$4RpZSdEkPrgv6/yDlgr.4eb0lypip7ZOqoO0FML4w3gVWQJQaeMEG', NULL, '', '', '2016-12-13 02:11:11', '2016-12-13 02:11:11', ' 09187970514'),
(94, 'Ansel', 'Abuac', 'ansel_a', 'default.jpg', 4, 5, 6, 'mdrrmonatonin@yahoo.com', '$2y$10$r6rb/YcCypysa/BqbZ//r./3/atFwKXj/zELTOOCFWHbSAD2ISFki', NULL, '', '', '2016-12-13 02:11:30', '2016-12-13 02:11:30', ' 09475370093'),
(95, 'Alice', 'Dogwe', 'alice_d', 'default.jpg', 4, 6, 6, 'paracelis_lgu@yahoo.com', '$2y$10$oUre19WAlJdvTX6nTwL5CetKFvJT2YaRVCzxFHhOpoqonRDzXC1Qe', NULL, '', '', '2016-12-13 02:11:49', '2016-12-13 02:11:49', ' 09192825385'),
(96, 'William', 'Rancudo', 'william_r', 'default.jpg', 3, 7, 6, 'riverockwill@gmail.com', '$2y$10$XM8K0Z.jFte388uecpEaOe2lmjWQqjIPjF9fC3V.8MdTh9gEG4Kuy', NULL, '', '', '2016-12-13 02:12:09', '2016-12-13 02:12:09', ' 09082515242'),
(97, 'Shiela', 'Pangod', 'shiela_p', 'default.jpg', 3, 8, 6, 'sheilapangod@yahoo.com', '$2y$10$604dZpW1vgk4u8nUc6g8TO0GdRPVQcBddmYotfQCrJ6m6.4IaiqBu', NULL, '', '', '2016-12-13 02:12:30', '2016-12-13 02:12:30', ' 09752107357'),
(98, 'Aida', 'Abeya', 'aida_a', 'default.jpg', 4, 9, 6, 'aidababeya@yahoo.com', '$2y$10$hKpy1.1M.bW8Jpel.iv33Om7JqMaNSotMztxvpZowVJ6HQJWgTVxm', NULL, '', '', '2016-12-13 02:13:02', '2016-12-13 02:13:02', ' 09999943282'),
(99, 'Jerry', 'Agageo', 'jerry_a', 'default.jpg', 4, 10, 6, 'mdrrmo_tadian@yahoo,com', '$2y$10$eSY.cO9MrYdDb85w/aj4nOsXXX6qW503vhVMdy9VkiaDYgANVph2G', NULL, '', '', '2016-12-13 02:13:20', '2016-12-13 02:13:20', ' 09399044349'),
(100, 'developer', 'devadmin', 'developer_dA', 'default.jpg', 2, 30, 3, 'devadmin@gmail.com', '$2y$10$ofBABLMPx6efhY74LAmm9eqvsTW/A9neC1lDX7ENNjhCxPvlTaw4a', '4xyP9zsnlxuAT7vWivgnYBPr6d7MlfABPdcHJ9u4MXDkBihnWMMSl9WOMMDY', 'My Position', 'Designation', '2017-02-14 01:44:44', '2017-03-09 01:29:51', '123456'),
(102, 'developer', 'devpdrrm', 'developer_dP', 'default.jpg', 3, 30, 3, 'devpdrrm@gmail.com', '$2y$10$1alPoJu3cZl.zXjzKfqb9eZkpaQcsZu.UHptVxQaYGv7ll1V8y7iW', 'qtYxf06i2BgXF7lyasbDHwUxM5egGsAu7MI0ko6fP0zlwgnMOXZKQiLn8CQg', '', '', '2017-02-14 01:48:20', '2017-02-14 02:03:48', '987654'),
(103, 'developer', 'devuser', 'developer_dU', 'default.jpg', 4, 30, 3, 'devuser@gmail.com', '$2y$10$/tnN/3Ft9t0Fwkj70o7/6OXR2IMxGcmpNgtA1jlNGrEFZk2uLDBjS', 'Y18i0ggcBsLkHYDWzUHgFDl0uqEoXjnuwDWDCyhucIjd00ENwNlBFZi9mVTd', '', '', '2017-02-14 01:51:41', '2017-03-09 01:30:20', '123123'),
(104, 'devtest', 'devtest', 'developer_d', 'default.jpg', 0, NULL, 0, 'testdev@gmail.com', '$2y$10$3ZXQk3YGfXATFNHjVxAMyuWv2E6SdRnaQuP00eGq0cg8FBF51Tmqa', 'EQlf0gb5Nrou413ajJzRsd0Uj9K5TYLe53B7zKhEl7V140iQkAEHMAENdi19', '', '', '2017-03-02 09:13:44', '2017-03-02 09:14:01', ''),
(106, 'UserLevel', 'Accountuser', 'userlevel_a', 'http://localhost/blog/public/photos/106/chart.png', 3, NULL, 1, 'useraccount@gmail.com', '$2y$10$hMGyOznkemq3ue21UNjfl.dUrCa4IfAqyjRoFRimePo03syy.lk8C', 'pA3tswxU3cs1wIeo1y1BtMcteXbsKRHnfogPkJgSIF9vRBG78l6qz9Z6iOvK', '', '', '2017-04-11 00:31:56', '2017-04-11 00:50:03', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
