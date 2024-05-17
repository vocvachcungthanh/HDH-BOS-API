-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2024 at 02:05 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HDH-BOS-DEV`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(20) DEFAULT NULL,
  `field_id` int(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `block_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `note`, `parent_id`, `field_id`, `status`, `created_at`, `updated_at`, `block_id`) VALUES
(1, 'PB001', 'Công ty', NULL, 0, NULL, 1, '2024-04-13 04:11:53', '2024-04-13 04:14:04', NULL),
(2, 'PB002', 'Khối backoffice', NULL, 1, 3, 1, '2024-04-12 21:18:16', '2024-04-12 21:18:16', 3),
(3, 'PB003', 'Khối kinh doanh', NULL, 1, 1, 1, '2024-04-12 21:26:31', '2024-04-12 21:26:31', 1),
(4, 'PB004', 'Khối sản xuất cung ứng', NULL, 1, 4, 1, '2024-04-12 21:28:41', '2024-04-12 21:28:41', 3),
(5, 'PB005', 'Ban giám đốc', NULL, 2, 3, 1, '2024-04-12 21:31:22', '2024-04-12 21:31:22', 2),
(6, 'PB006', 'Phòng hành chính nhân sự', NULL, 2, 3, 1, '2024-04-12 21:32:49', '2024-04-12 21:32:49', 2),
(7, 'PB007', 'Phòng kỹ thuật', NULL, 2, 3, 1, '2024-04-12 21:37:22', '2024-04-16 10:04:12', 2),
(8, 'PB008', 'Phòng ban 24.2', NULL, 2, 3, 1, '2024-04-12 21:42:26', '2024-04-12 21:42:26', 2),
(9, 'PB009', 'Phòng bán hàng', NULL, 3, 1, 1, '2024-04-12 21:46:00', '2024-04-12 21:46:00', 1),
(10, 'PB010', 'Phòng marketing', NULL, 3, 2, 1, '2024-04-12 21:47:47', '2024-04-12 21:47:47', 1),
(11, 'PB011', 'BP lắp ráp', NULL, 4, 4, 1, '2024-04-12 21:53:24', '2024-04-12 21:53:24', 3),
(12, 'PB012', 'Phòng tổng hợp', NULL, 2, 3, 1, '2024-04-12 21:55:57', '2024-04-12 21:55:57', 2),
(13, 'PB013', 'BP kế toán nội bộ', NULL, 12, 3, 1, '2024-04-12 22:04:43', '2024-04-12 22:04:43', 2),
(14, 'PB014', 'PB kho vận', NULL, 12, 3, 1, '2024-04-12 23:28:58', '2024-04-12 23:28:58', 2),
(15, 'PB015', 'Nhóm kho Đ.A', NULL, 14, 4, 1, '2024-04-12 23:36:43', '2024-04-12 23:50:20', 3),
(16, 'PB016', 'Nhóm hỗ trợ', NULL, 14, 4, 1, '2024-04-12 23:39:44', '2024-04-12 23:39:44', 3),
(17, 'PB017', 'Nhóm kho', NULL, 14, 3, 1, '2024-04-12 23:51:05', '2024-04-12 23:51:05', 2),
(18, 'PB018', 'Nhóm vận chuyển', NULL, 14, 3, 1, '2024-04-12 23:55:11', '2024-04-12 23:55:11', 2),
(19, 'PB019', 'Phòng kiểm thử phần mềm', NULL, 12, 1, 1, '2024-04-12 23:58:34', '2024-04-13 01:27:06', 3),
(20, 'PB020', 'Nhóm nghiên cứu SP', NULL, 7, 3, 1, '2024-04-13 01:29:50', '2024-04-13 03:40:09', 2),
(21, 'PB021', 'Nhóm kỹ thuật BH', NULL, 7, 3, 1, '2024-04-13 01:43:38', '2024-04-13 01:43:38', 2),
(22, 'PB022', 'Nhóm QLCL Kingled', NULL, 7, 3, 1, '2024-04-13 01:44:07', '2024-04-13 03:12:57', 2),
(23, 'PB023', 'A1', NULL, 8, 3, 1, '2024-04-13 01:44:31', '2024-04-13 03:40:09', 2),
(24, 'PB024', 'A2', NULL, 8, 3, 1, '2024-04-13 01:46:11', '2024-04-13 01:46:11', 2),
(25, 'PB025', 'Phòng bán hàng miền bắc', NULL, 9, 1, 1, '2024-04-13 02:22:04', '2024-04-13 02:22:04', 1),
(26, 'PB026', 'Phòng dự án', NULL, 9, 1, 1, '2024-04-13 02:22:45', '2024-04-13 03:35:10', 1),
(27, 'PB027', 'Chi nhánh', NULL, 9, 1, 1, '2024-04-13 02:23:06', '2024-04-13 02:23:06', 1),
(28, 'PB028', 'Hà Nội', NULL, 25, 1, 1, '2024-04-13 02:33:23', '2024-04-13 03:37:55', 1),
(29, 'PB029', 'Miền trung', NULL, 27, 1, 1, '2024-04-13 02:34:58', '2024-04-13 02:34:58', 1),
(30, 'PB030', 'BP digital marketing', NULL, 10, 2, 1, '2024-04-13 03:02:16', '2024-05-02 10:19:58', 1),
(31, 'PB031', 'Bộ phận maketing', NULL, 10, 2, 1, '2024-04-13 03:03:01', '2024-05-08 17:45:33', 1),
(32, 'PB032', 'Tổ lắp ráp 2', NULL, 11, 4, 1, '2024-04-13 03:07:26', '2024-04-15 02:44:31', 3);

-- --------------------------------------------------------

--
-- Table structure for table `LST_Account_Type`
--

CREATE TABLE `LST_Account_Type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `LST_Account_Type`
--

INSERT INTO `LST_Account_Type` (`id`, `name`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Owenr', '', 1, '2024-04-04 00:51:21', NULL),
(2, 'Manager', '', 1, '2024-04-04 00:51:21', NULL),
(3, 'Admin', '', 1, '2024-04-04 00:51:21', NULL),
(4, 'User', '', 1, '2024-04-04 00:51:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `LST_Block`
--

CREATE TABLE `LST_Block` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `LST_Block`
--

INSERT INTO `LST_Block` (`id`, `name`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Khối kinh doanh', 'Khối kinh doanh', 1, '2024-03-13 07:40:20', NULL),
(2, 'Khối backoffice', 'Khối backoffice', 1, '2024-03-13 07:40:20', NULL),
(3, 'Khối sản xuất cung ứng', 'Khối sản xuất cung ứng', 1, '2024-03-13 07:40:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `LST_Es`
--

CREATE TABLE `LST_Es` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Tên trạng thái',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `LST_Es`
--

INSERT INTO `LST_Es` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Đang làm việc', 1, '2024-05-16 08:30:47', '2024-05-16 08:30:47'),
(2, 'Đã nghỉ việc', 1, '2024-05-16 08:30:47', '2024-05-16 08:30:47'),
(3, 'Dự kiến tuyển dụng', 1, '2024-05-16 08:30:47', '2024-05-16 08:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `LST_Field`
--

CREATE TABLE `LST_Field` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `LST_Field`
--

INSERT INTO `LST_Field` (`id`, `name`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lĩnh vực bán hàng', 'Lĩnh vực bán hàng', 1, '2024-03-13 07:40:40', NULL),
(2, 'Lĩnh vực Marketing', 'Lĩnh vực Marketing', 1, '2024-03-13 07:40:40', NULL),
(3, 'Lĩnh vực hỗ trợ', 'Lĩnh vực hỗ trợ', 1, '2024-03-13 07:40:40', NULL),
(4, 'Lĩnh vực cung ứng', 'Lĩnh vực cung ứng', 1, '2024-03-13 07:40:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `LST_Gender`
--

CREATE TABLE `LST_Gender` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Tên giới tính',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `LST_Gender`
--

INSERT INTO `LST_Gender` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nam', 1, '2024-05-16 08:31:10', '2024-05-16 08:31:10'),
(2, 'Nữ', 1, '2024-05-16 08:31:10', '2024-05-16 08:31:10'),
(3, 'Khác', 1, '2024-05-16 08:31:10', '2024-05-16 08:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `LST_Sor`
--

CREATE TABLE `LST_Sor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Tên nguồn hồ sơ',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `LST_Sor`
--

INSERT INTO `LST_Sor` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BOS', 1, '2024-05-16 08:31:23', '2024-05-16 08:31:23'),
(2, 'Sổ bán hàng kế toán', 1, '2024-05-16 08:31:23', '2024-05-16 08:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `LST_Work_Regime`
--

CREATE TABLE `LST_Work_Regime` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Tên chế độ làm việc',
  `note` text DEFAULT NULL COMMENT 'Ghi chú chế độ làm việc',
  `nwd` decimal(8,2) DEFAULT NULL COMMENT 'Số ngày làm việc',
  `ndo` decimal(8,2) DEFAULT NULL COMMENT 'Số ngày nghỉ',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `LST_Work_Regime`
--

INSERT INTO `LST_Work_Regime` (`id`, `name`, `note`, `nwd`, `ndo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Làm đến hết thứ 6', NULL, NULL, NULL, 1, '2024-05-16 08:46:49', '2024-05-16 08:46:49'),
(2, 'Làm đến hết thứ T6 + nửa ngày T7', NULL, NULL, NULL, 1, '2024-05-16 08:46:49', '2024-05-16 08:46:49'),
(3, 'Làm đến hết thứ T6 + thứ 7 cách tuần', NULL, NULL, NULL, 1, '2024-05-16 08:46:49', '2024-05-16 08:46:49'),
(4, 'Làm đến hết ngày thứ 7', NULL, NULL, NULL, 1, '2024-05-16 08:46:49', '2024-05-16 08:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2024_04_04_080955_create_postions_table', 3),
(12, '2024_04_21_162254_create_slicer_setting_table', 5),
(13, '2024_04_21_161909_create_slicer_table', 6),
(14, '2024_05_14_133449_create_staffs_table', 7),
(18, '2024_05_14_152752_create_lst_gender_table', 8),
(19, '2024_05_14_153311_create_sor_table', 9),
(20, '2024_05_16_142537_create_lst_work_regime_table', 10),
(21, '2024_05_16_144238_create_lst_es_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `postions`
--

CREATE TABLE `postions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_type_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `benefits` text DEFAULT NULL,
  `permissions` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postions`
--

INSERT INTO `postions` (`id`, `code`, `name`, `account_type_id`, `department_id`, `benefits`, `permissions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'VT001', 'Tổng giám đốc', 1, 5, NULL, NULL, 1, '2024-04-06 12:47:31', '2024-04-06 12:47:31'),
(2, 'VT002', 'Phó TGĐ nội bộ', 2, 5, 'Được hưởng chế độ như Phó TGĐ nội bộ', 'Quyền hạn của Phó TGĐ nội bộ', 1, '2024-04-06 12:53:58', '2024-04-06 12:53:58'),
(3, 'VT003', 'Admin KD vùng', 3, 21, 'Được hưởng chế độ như Admin Vùng 2', 'Quền hạn của Admin KD vùng 2', 1, '2024-04-08 03:10:55', '2024-04-08 03:10:55'),
(4, 'VT004', 'Trưởng PB ko vận', 2, 8, 'Được hưởng quyền lợi như Trưởng PB kho vận', 'Quyền hạn của Trưởng PB kho vận', 1, '2024-04-08 03:14:08', '2024-04-08 03:14:08'),
(5, 'VT005', 'Phó TGD sản xuất', 1, 5, 'Ban giám đốc	Phó TGĐ sản xuất	Owner	Quyền hạn của Phó TGĐ sản xuất	Được hưởng chế độ như Phó TGĐ sản xuất', 'Quyền hạn của Phó TGĐ sản xuất', 1, '2024-04-08 06:05:51', '2024-04-08 06:05:51'),
(6, 'VT006', 'GĐ kinh doanh toàn quốc', 1, 5, 'Được hưởng chế độ như GĐ kinh doanh toàn quốc', 'Quyền hạn của GĐ kinh doanh toàn quốc', 1, '2024-04-08 06:14:23', '2024-04-08 06:14:23'),
(7, 'VT007', 'GĐ kinh doanh toàn quốc', 2, 16, 'Được hưởng chế độ như GĐ kinh doanh toàn quốc', 'Quyền hạn của GĐ kinh doanh toàn quốc', 1, '2024-04-08 06:15:46', '2024-04-08 06:15:46'),
(8, 'VT008', 'Nhân viên kinh doanh Hà Nội', 4, 19, 'Được hưởng chế độ như Nhân viên kinh doanh Hà Nội', 'Quyền hạn của Nhân viên kinh doanh Hà Nội', 1, '2024-04-08 06:19:38', '2024-04-08 06:19:38'),
(23, 'VT009', 'Thêm phần tử tiếp theo', 2, 2, 'sdfas', 'sdf', 1, '2024-04-09 02:11:52', '2024-04-09 02:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `slicer`
--

CREATE TABLE `slicer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slicer`
--

INSERT INTO `slicer` (`id`, `name`, `note`, `status`, `type`, `created_at`, `updated_at`) VALUES
(1, 'slicerCode', 'slicer mã phòng ban', 1, 'unit', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(2, 'slicerName', 'slicer tên phòng ban', 1, 'unit', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(3, 'slicerBlock', 'slicer khối', 1, 'unit', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(4, 'slicerField', 'slicer lĩnh vực', 1, 'unit', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(5, 'slicerParent', 'slicer Trực thuộc', 1, 'unit', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(6, 'slicerUnit', 'slicer tên phòng ban', 1, 'postion', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(7, 'slicerCodePostion', 'slicer mã vị trí', 1, 'postion', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(8, 'slicerNamePostion', 'slicer tên vị trí', 1, 'postion', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(9, 'slicerAccountType', 'slicer loại tài khoản', 1, 'postion', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(10, 'slicerPermissions', 'slicer quyền hạn', 1, 'postion', '2024-05-05 13:08:02', '2024-05-05 13:08:02'),
(11, 'slicerBenefits', 'slicer quyền lợi', 1, 'postion', '2024-05-05 13:08:02', '2024-05-05 13:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `slicer_setting`
--

CREATE TABLE `slicer_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slicer_id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `count` bigint(20) NOT NULL DEFAULT 2,
  `icon` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slicer_setting`
--

INSERT INTO `slicer_setting` (`id`, `slicer_id`, `title`, `caption`, `count`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mã phòng ban', 'Mã phòng ban', 3, 'barcode', 1, '2024-05-05 13:17:29', '2024-05-13 08:36:46'),
(2, 2, 'Tên phòng ban', 'Tên phòng ban', 2, 'build', 1, '2024-05-05 13:17:29', '2024-05-13 08:36:48'),
(3, 3, 'Khối', 'Khối', 2, 'block', 1, '2024-05-05 13:17:29', '2024-05-13 08:58:09'),
(4, 4, 'Lĩnh vực', 'Lĩnh vực', 2, 'box-plot', 1, '2024-05-05 13:17:29', '2024-05-13 09:17:54'),
(5, 5, 'Trực thuộc', 'Trực thuộc', 2, 'apartment', 1, '2024-05-05 13:17:29', '2024-05-13 08:36:53'),
(6, 6, 'Tên phòng ban', 'Tên phòng ban', 2, 'build', 1, '2024-05-05 13:17:29', '2024-05-13 21:39:43'),
(7, 7, 'Mã vị trí', 'Mã vị trí', 3, 'barcode', 1, '2024-05-05 13:17:29', '2024-05-13 20:37:57'),
(8, 8, 'Tên vị trí', 'Tên vị trí', 2, 'build', 1, '2024-05-05 13:17:29', '2024-05-13 22:05:08'),
(9, 9, 'Loại tài khoản', 'Loại tài khoản', 2, 'account-book', 1, '2024-05-05 13:17:29', '2024-05-13 21:36:36'),
(10, 10, 'Quyền hạn', 'Quyền hạn', 2, 'fire', 1, '2024-05-05 13:17:29', '2024-05-14 06:16:42'),
(11, 11, 'Quyền lợi', 'Quyền lợi', 1, 'funnel-plot', 0, '2024-05-05 13:17:29', '2024-05-13 22:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `sor`
--

CREATE TABLE `sor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL COMMENT 'Mã nhân viên',
  `last_name` varchar(255) NOT NULL COMMENT 'Họ',
  `first_name` varchar(255) NOT NULL COMMENT 'Tên',
  `nickname` varchar(255) DEFAULT NULL COMMENT 'Tên thường gọi',
  `nationnal_id_card` varchar(255) DEFAULT NULL COMMENT 'Căn cước công dân',
  `phone` int(11) DEFAULT NULL COMMENT 'Số điện thoại',
  `email` varchar(255) DEFAULT NULL,
  `date_of_birth` int(11) NOT NULL COMMENT 'Ngày sinh',
  `month_of_birth` int(11) NOT NULL COMMENT 'Tháng sinh',
  `year_of_birth` int(11) NOT NULL COMMENT 'Năm sinh',
  `address` varchar(255) DEFAULT NULL COMMENT 'Địa chỉ',
  `hometown` varchar(255) NOT NULL COMMENT 'Quê quán',
  `avatar` varchar(255) NOT NULL COMMENT 'Ảnh đại diện',
  `start_date_of_employment` datetime NOT NULL COMMENT 'Ngày bắt đầu làm việc',
  `end_date_of_employment` datetime DEFAULT NULL COMMENT 'Ngày nghỉ việc',
  `gender_id` bigint(20) DEFAULT NULL COMMENT 'id giới tinh',
  `department_id` bigint(20) DEFAULT NULL COMMENT 'id phòng ban',
  `postion_id` bigint(20) DEFAULT NULL COMMENT 'id vị trí',
  `work_regime_id` bigint(20) DEFAULT NULL COMMENT 'id chế độ làm việc',
  `sor_id` bigint(20) DEFAULT NULL COMMENT 'id nguồn hồ sơ',
  `es_id` bigint(20) DEFAULT NULL COMMENT 'id trạng thái làm việc',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_id` (`block_id`),
  ADD KEY `block_id_2` (`block_id`),
  ADD KEY `block_id_3` (`block_id`);

--
-- Indexes for table `LST_Account_Type`
--
ALTER TABLE `LST_Account_Type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LST_Block`
--
ALTER TABLE `LST_Block`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LST_Es`
--
ALTER TABLE `LST_Es`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LST_Field`
--
ALTER TABLE `LST_Field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LST_Gender`
--
ALTER TABLE `LST_Gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LST_Sor`
--
ALTER TABLE `LST_Sor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LST_Work_Regime`
--
ALTER TABLE `LST_Work_Regime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postions`
--
ALTER TABLE `postions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slicer`
--
ALTER TABLE `slicer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slicer_setting`
--
ALTER TABLE `slicer_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sor`
--
ALTER TABLE `sor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `LST_Account_Type`
--
ALTER TABLE `LST_Account_Type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `LST_Block`
--
ALTER TABLE `LST_Block`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `LST_Es`
--
ALTER TABLE `LST_Es`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `LST_Field`
--
ALTER TABLE `LST_Field`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `LST_Gender`
--
ALTER TABLE `LST_Gender`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `LST_Sor`
--
ALTER TABLE `LST_Sor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `LST_Work_Regime`
--
ALTER TABLE `LST_Work_Regime`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `postions`
--
ALTER TABLE `postions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `slicer`
--
ALTER TABLE `slicer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `slicer_setting`
--
ALTER TABLE `slicer_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sor`
--
ALTER TABLE `sor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
