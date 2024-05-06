-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 07, 2024 lúc 01:36 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `HDH-BOS-DEV`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
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
-- Đang đổ dữ liệu cho bảng `departments`
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
(31, 'PB031', 'Bộ phận maketing', NULL, 10, 2, 1, '2024-04-13 03:03:01', '2024-04-13 03:45:48', 1),
(32, 'PB032', 'Tổ lắp ráp 2', NULL, 11, 4, 1, '2024-04-13 03:07:26', '2024-04-15 02:44:31', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `LST_Account_Type`
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
-- Đang đổ dữ liệu cho bảng `LST_Account_Type`
--

INSERT INTO `LST_Account_Type` (`id`, `name`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Owenr', '', 1, '2024-04-04 00:51:21', NULL),
(2, 'Manager', '', 1, '2024-04-04 00:51:21', NULL),
(3, 'Admin', '', 1, '2024-04-04 00:51:21', NULL),
(4, 'User', '', 1, '2024-04-04 00:51:21', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `LST_Block`
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
-- Đang đổ dữ liệu cho bảng `LST_Block`
--

INSERT INTO `LST_Block` (`id`, `name`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Khối kinh doanh', 'Khối kinh doanh', 1, '2024-03-13 07:40:20', NULL),
(2, 'Khối backoffice', 'Khối backoffice', 1, '2024-03-13 07:40:20', NULL),
(3, 'Khối sản xuất cung ứng', 'Khối sản xuất cung ứng', 1, '2024-03-13 07:40:20', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `LST_Field`
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
-- Đang đổ dữ liệu cho bảng `LST_Field`
--

INSERT INTO `LST_Field` (`id`, `name`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lĩnh vực bán hàng', 'Lĩnh vực bán hàng', 1, '2024-03-13 07:40:40', NULL),
(2, 'Lĩnh vực Marketing', 'Lĩnh vực Marketing', 1, '2024-03-13 07:40:40', NULL),
(3, 'Lĩnh vực hỗ trợ', 'Lĩnh vực hỗ trợ', 1, '2024-03-13 07:40:40', NULL),
(4, 'Lĩnh vực cung ứng', 'Lĩnh vực cung ứng', 1, '2024-03-13 07:40:40', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2024_04_04_080955_create_postions_table', 3),
(12, '2024_04_21_162254_create_slicer_setting_table', 5),
(13, '2024_04_21_161909_create_slicer_table', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `postions`
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
-- Đang đổ dữ liệu cho bảng `postions`
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
-- Cấu trúc bảng cho bảng `slicer`
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
-- Đang đổ dữ liệu cho bảng `slicer`
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
-- Cấu trúc bảng cho bảng `slicer_setting`
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
-- Đang đổ dữ liệu cho bảng `slicer_setting`
--

INSERT INTO `slicer_setting` (`id`, `slicer_id`, `title`, `caption`, `count`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mã phòng ban', 'Mã phòng ban', 3, 'barcode', 1, '2024-05-05 13:17:29', '2024-05-05 14:33:26'),
(2, 2, 'Tên phòng ban', 'Tên phòng ban', 2, 'build', 0, '2024-05-05 13:17:29', '2024-05-05 14:32:31'),
(3, 3, 'Khối', 'Khối', 2, 'block', 1, '2024-05-05 13:17:29', '2024-05-05 14:29:52'),
(4, 4, 'Lĩnh vực', 'Lĩnh vực', 1, 'box-plot', 1, '2024-05-05 13:17:29', '2024-05-05 14:25:26'),
(5, 5, 'Trực thuộc', 'Trực thuộc', 2, 'apartment', 0, '2024-05-05 13:17:29', '2024-05-05 14:33:30'),
(6, 6, 'Tên phòng ban', 'Tên phòng ban', 2, 'build', 1, '2024-05-05 13:17:29', '2024-05-05 13:17:29'),
(7, 7, 'Mã vị trí', 'Mã vị trí', 2, 'barcode', 1, '2024-05-05 13:17:29', '2024-05-05 13:17:29'),
(8, 8, 'Tên vị trí', 'Tên vị trí', 2, 'build', 1, '2024-05-05 13:17:29', '2024-05-05 13:17:29'),
(9, 9, 'Loại tài khoản', 'Loại tài khoản', 2, 'account-book', 1, '2024-05-05 13:17:29', '2024-05-05 13:17:29'),
(10, 10, 'Quyền hạn', 'Quyền hạn', 2, 'fire', 1, '2024-05-05 13:17:29', '2024-05-05 13:17:29'),
(11, 11, 'Quyền lợi', 'Quyền lợi', 2, 'funnel-plot', 1, '2024-05-05 13:17:29', '2024-05-05 13:17:29');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_id` (`block_id`),
  ADD KEY `block_id_2` (`block_id`),
  ADD KEY `block_id_3` (`block_id`);

--
-- Chỉ mục cho bảng `LST_Account_Type`
--
ALTER TABLE `LST_Account_Type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `LST_Block`
--
ALTER TABLE `LST_Block`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `LST_Field`
--
ALTER TABLE `LST_Field`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `postions`
--
ALTER TABLE `postions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `slicer`
--
ALTER TABLE `slicer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `slicer_setting`
--
ALTER TABLE `slicer_setting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `LST_Account_Type`
--
ALTER TABLE `LST_Account_Type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `LST_Block`
--
ALTER TABLE `LST_Block`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `LST_Field`
--
ALTER TABLE `LST_Field`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `postions`
--
ALTER TABLE `postions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `slicer`
--
ALTER TABLE `slicer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `slicer_setting`
--
ALTER TABLE `slicer_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
