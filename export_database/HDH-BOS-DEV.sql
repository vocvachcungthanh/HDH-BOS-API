-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th4 19, 2024 lúc 04:45 AM
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

--
-- Chỉ mục cho các bảng đã đổ
--

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
-- AUTO_INCREMENT cho các bảng đã đổ
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;