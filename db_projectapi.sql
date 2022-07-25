-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2022 at 11:29 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_projectapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `activity_name` text NOT NULL,
  `activity_money` double NOT NULL,
  `activity_place` text NOT NULL,
  `project_id` int(11) NOT NULL,
  `activity_name_all` text NOT NULL,
  `activity_process_id` text NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `activity_name`, `activity_money`, `activity_place`, `project_id`, `activity_name_all`, `activity_process_id`, `user`, `date`) VALUES
(1, 'สตรา', 213, 'ยยย', 1, 'แแแแแกดดดพพ', '2', 1, '2022-07-25 15:00:15'),
(2, 'ทดสอบ', 123, 'ยรนีรีัีทมมมส', 1, 'นยนยนยน', '1', 1, '2022-07-25 15:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `activity_process`
--

CREATE TABLE `activity_process` (
  `activity_process_id` int(11) NOT NULL,
  `activity_process_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_process`
--

INSERT INTO `activity_process` (`activity_process_id`, `activity_process_name`) VALUES
(1, 'ดำเนินการแล้ว'),
(2, 'ยังไม่ได้ดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `admin_email`
--

CREATE TABLE `admin_email` (
  `admin_email_id` int(11) NOT NULL,
  `admin_email_name` text DEFAULT NULL,
  `admin_email_desc` text DEFAULT NULL,
  `admin_email_receive` varchar(200) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amphur`
--

CREATE TABLE `amphur` (
  `amphur_id` varchar(4) NOT NULL COMMENT 'รหัสอำเภอ',
  `amphur_name_thai` varchar(255) NOT NULL COMMENT 'ชื่ออำเภอไทย',
  `amphur_name_eng` varchar(255) NOT NULL COMMENT 'ชื่ออำเภออังกฤษ',
  `province_id` varchar(2) NOT NULL COMMENT 'รหัสจังหวัด'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ข้อมูลอำเภอ' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `province_id` varchar(2) NOT NULL,
  `province_code` varchar(3) NOT NULL COMMENT 'สัญลักษณ์ย่อพื้นที่',
  `user` int(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='พื้นที่เก็บแบบสำรวจ';

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`province_id`, `province_code`, `user`, `date`) VALUES
('1', '95', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE `asset` (
  `home_id` int(11) NOT NULL,
  `item_asset_id` int(11) NOT NULL COMMENT 'รายการทรัพย์สิน',
  `num` int(11) NOT NULL COMMENT 'จำนวน',
  `total` int(11) NOT NULL COMMENT 'รวมเป็นเงิน (บาท/ปี)',
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='32 ทรัพย์สินสำหรับการประกอบอาชีพ';

-- --------------------------------------------------------

--
-- Table structure for table `debt`
--

CREATE TABLE `debt` (
  `home_id` int(11) NOT NULL,
  `item_debt_borrow_id` int(11) NOT NULL COMMENT 'แหล่งหนี้สิน',
  `total` int(11) NOT NULL COMMENT 'จำนวนหนี้สิน (บาท)',
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='31 หนี้สิน';

-- --------------------------------------------------------

--
-- Table structure for table `item_prefix`
--

CREATE TABLE `item_prefix` (
  `item_prefix_id` int(11) NOT NULL,
  `item_prefix_name` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='รายการคำนำหน้าชื่อ';

--
-- Dumping data for table `item_prefix`
--

INSERT INTO `item_prefix` (`item_prefix_id`, `item_prefix_name`, `user`, `date`) VALUES
(1, 'นางสาว', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `program_code` varchar(255) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  `level_desc` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ระดับการใช้งานระบบ';

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `program_code`, `level_name`, `level_desc`) VALUES
(1, 'admin', 'ผู้ดูแลระบบ', '1'),
(2, 'area-admin', 'ผู้ตรวจสอบข้อมูลในระบบ', '2');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `session` text NOT NULL,
  `ip_local` text NOT NULL,
  `json_ip` text NOT NULL,
  `status` varchar(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ประวัติการเข้าสู่ระบบ';

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `session`, `ip_local`, `json_ip`, `status`, `email`, `password`, `user`, `date`) VALUES
(1, '8t5tvmivmdb4r9jk4lha8ojb9g', '::1', '{\"ip\":\"118.174.156.72\",\"city\":\"Yala\",\"region\":\"Yala\",\"country\":\"TH\",\"loc\":\"6.5400,101.2813\",\"org\":\"AS23969 TOT Public Company Limited\",\"postal\":\"95000\",\"timezone\":\"Asia/Bangkok\"}', 'Y', 'Satra.e@yru.ac.th', '123456', 1, '2022-07-25 12:32:35'),
(2, '8t5tvmivmdb4r9jk4lha8ojb9g', '::1', '{\"ip\":\"118.174.156.72\",\"city\":\"Yala\",\"region\":\"Yala\",\"country\":\"TH\",\"loc\":\"6.5400,101.2813\",\"org\":\"AS23969 TOT Public Company Limited\",\"postal\":\"95000\",\"timezone\":\"Asia/Bangkok\"}', 'Y', 'Satra.e@yru.ac.th', '123456', 1, '2022-07-25 15:19:38'),
(3, '8t5tvmivmdb4r9jk4lha8ojb9g', '::1', '{\"ip\":\"118.174.156.72\",\"city\":\"Yala\",\"region\":\"Yala\",\"country\":\"TH\",\"loc\":\"6.5400,101.2813\",\"org\":\"AS23969 TOT Public Company Limited\",\"postal\":\"95000\",\"timezone\":\"Asia/Bangkok\"}', 'Y', 'abc@gmail.com', '123456', 2, '2022-07-25 15:28:38'),
(4, '8t5tvmivmdb4r9jk4lha8ojb9g', '::1', '{\"ip\":\"118.174.156.72\",\"city\":\"Yala\",\"region\":\"Yala\",\"country\":\"TH\",\"loc\":\"6.5400,101.2813\",\"org\":\"AS23969 TOT Public Company Limited\",\"postal\":\"95000\",\"timezone\":\"Asia/Bangkok\"}', 'Y', 'Satra.e@yru.ac.th', '123456', 1, '2022-07-25 15:33:44'),
(5, 'hjib9d0jev15lrp81se0au0u8n', '::1', '{\"ip\":\"118.174.156.72\",\"city\":\"Yala\",\"region\":\"Yala\",\"country\":\"TH\",\"loc\":\"6.5400,101.2813\",\"org\":\"AS23969 TOT Public Company Limited\",\"postal\":\"95000\",\"timezone\":\"Asia/Bangkok\"}', 'Y', 'abc@gmail.com', '123456', 2, '2022-07-25 16:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` text NOT NULL,
  `project_money` double NOT NULL,
  `project_place` text NOT NULL,
  `project_type_id` int(11) NOT NULL,
  `project_name_all` text NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_money`, `project_place`, `project_type_id`, `project_name_all`, `user`, `date`) VALUES
(1, 'ssss', 52, 'qqq', 1, 'qqq', 1, '2022-07-25 14:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `project_type`
--

CREATE TABLE `project_type` (
  `project_type_id` int(11) NOT NULL,
  `project_type_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_type`
--

INSERT INTO `project_type` (`project_type_id`, `project_type_name`) VALUES
(1, 'AA'),
(2, 'dd'),
(3, 'ss');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `province_id` varchar(2) NOT NULL COMMENT 'รหัสจังหวัด',
  `province_name_thai` varchar(200) NOT NULL COMMENT 'ชื่อจังหวัดภาษาไทย',
  `province_name_eng` varchar(200) NOT NULL COMMENT 'ชื่อจังหวัดภาษาอังกฤษ'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ข้อมูลจังหวัด' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`province_id`, `province_name_thai`, `province_name_eng`) VALUES
('1', 'ยะลา', 'yala');

-- --------------------------------------------------------

--
-- Table structure for table `revert_comment`
--

CREATE TABLE `revert_comment` (
  `revert_comment_id` int(11) NOT NULL,
  `home_id` int(11) NOT NULL COMMENT 'รหัสบ้าน',
  `comment` text NOT NULL COMMENT 'เหตุผล',
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='comment ส่งกลับแก้ไข';

-- --------------------------------------------------------

--
-- Table structure for table `tambol`
--

CREATE TABLE `tambol` (
  `tambol_id` varchar(6) NOT NULL COMMENT 'รหัสตำบล',
  `tambol_name_thai` varchar(255) NOT NULL COMMENT 'ชื่อตำบลภาษาไทย',
  `tambol_name_eng` varchar(255) NOT NULL DEFAULT '' COMMENT 'ชื่อตำบลภาษาอังกฤษ',
  `latitude` decimal(6,3) NOT NULL,
  `longitude` decimal(6,3) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `amphur_id` varchar(4) NOT NULL COMMENT 'รหัสอำเภอ'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ข้อมูลตำบล' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `item_prefix_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `user` int(255) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ข้อมูลผู้ใช้งานระบบ';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_lname`, `item_prefix_id`, `email`, `password`, `phone`, `image`, `status`, `user`, `date`) VALUES
(1, 'สตรา', 'เอียตรง', 1, 'Satra.e@yru.ac.th', '123456', '092-9857194', '', 'Y', 1, NULL),
(2, 'AAAA', 'BBBB', 1, 'abc@gmail.com', '123456', '085-2222222', '1658737108.jpg', 'Y', 1, '2022-07-25 15:25:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_area`
--

CREATE TABLE `user_area` (
  `user_id` int(11) NOT NULL,
  `province_id` varchar(2) NOT NULL,
  `is_admin` varchar(1) NOT NULL COMMENT 'Y: เป็นแอดมินพื้นที่\r\nN: ไม่เป็นแอดมินพื้นที่',
  `date` datetime NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ข้อมูลผู้ใช้งานที่อยู่ในพื้นที่';

--
-- Dumping data for table `user_area`
--

INSERT INTO `user_area` (`user_id`, `province_id`, `is_admin`, `date`, `user`) VALUES
(1, '1', 'Y', '2022-07-25 15:25:05', 1),
(2, '1', 'N', '2022-07-25 15:25:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ข้อมูลผู้ใช้งานตามระดับการใช้งาน';

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`user_id`, `level_id`, `date`, `user`) VALUES
(1, 1, '0000-00-00 00:00:00', 0),
(1, 2, '0000-00-00 00:00:00', 1),
(2, 2, '2022-07-25 16:01:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_tmp`
--

CREATE TABLE `user_tmp` (
  `user_id` int(11) NOT NULL,
  `area_province_id` varchar(2) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `item_prefix_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `user` int(255) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ข้อมูลผู้ลงทะเบียนอาสาบันทึกแบบสำรวจ';

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `year_id` int(11) NOT NULL,
  `year_name` varchar(4) NOT NULL COMMENT 'ชื่อปี เช่น 2564',
  `default` varchar(1) NOT NULL COMMENT 'ค่าเริ่มต้นใช่งาน',
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ปีงบประมาณที่เก็บแบบสำรวจ';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `activity_process`
--
ALTER TABLE `activity_process`
  ADD PRIMARY KEY (`activity_process_id`);

--
-- Indexes for table `admin_email`
--
ALTER TABLE `admin_email`
  ADD PRIMARY KEY (`admin_email_id`);

--
-- Indexes for table `amphur`
--
ALTER TABLE `amphur`
  ADD PRIMARY KEY (`amphur_id`) USING BTREE;

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`province_id`) USING BTREE;

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`home_id`,`item_asset_id`) USING BTREE;

--
-- Indexes for table `debt`
--
ALTER TABLE `debt`
  ADD PRIMARY KEY (`home_id`,`item_debt_borrow_id`) USING BTREE;

--
-- Indexes for table `item_prefix`
--
ALTER TABLE `item_prefix`
  ADD PRIMARY KEY (`item_prefix_id`) USING BTREE;

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`) USING BTREE;

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`) USING BTREE;

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_type`
--
ALTER TABLE `project_type`
  ADD PRIMARY KEY (`project_type_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`province_id`) USING BTREE;

--
-- Indexes for table `revert_comment`
--
ALTER TABLE `revert_comment`
  ADD PRIMARY KEY (`revert_comment_id`) USING BTREE;

--
-- Indexes for table `tambol`
--
ALTER TABLE `tambol`
  ADD PRIMARY KEY (`tambol_id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`) USING BTREE;

--
-- Indexes for table `user_area`
--
ALTER TABLE `user_area`
  ADD PRIMARY KEY (`user_id`,`province_id`) USING BTREE;

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`user_id`,`level_id`) USING BTREE;

--
-- Indexes for table `user_tmp`
--
ALTER TABLE `user_tmp`
  ADD PRIMARY KEY (`user_id`) USING BTREE;

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`year_id`) USING BTREE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
