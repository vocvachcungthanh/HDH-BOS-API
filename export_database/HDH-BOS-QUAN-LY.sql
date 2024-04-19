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
-- Cơ sở dữ liệu: `HDH-BOS-QUAN-LY`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `company`
--

CREATE TABLE `company` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `hosting_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `company`
--

INSERT INTO `company` (`id`, `name`, `address`, `phone`, `email`, `logo`, `tin`, `website`, `hosting_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Công ty CP Giải Pháp Quản Trị BOS', 'Tầng 10, Tòa 15T Nguyễn Thị Định, Phường Trung Hòa, Cầu Giấy, Hà Nội', '0947289966', 'bos11052021@gmail.com', 'https://bos.edu.vn/wp-content/uploads/2022/08/logo_footer.svg', '0108159243', 'https://bos.edu.vn/', 1, 1, '2024-03-12 09:40:44', '2024-03-12 09:40:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hosting`
--

CREATE TABLE `hosting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `db_host` varchar(255) DEFAULT NULL,
  `db_port` varchar(255) DEFAULT NULL,
  `db_database` varchar(255) DEFAULT NULL,
  `db_user_name` varchar(255) DEFAULT NULL,
  `db_password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hosting`
--

INSERT INTO `hosting` (`id`, `db_host`, `db_port`, `db_database`, `db_user_name`, `db_password`, `status`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', '3306', 'HDH-BOS-DEV', 'root', '', 1, '2024-03-12 09:40:44', '2024-03-12 09:40:44');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_02_27_141440_create_company_table', 1),
(4, '2024_02_27_142752_create_hosting_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_session` longtext DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `change_password_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_name`, `remember_token`, `last_session`, `staff_id`, `company_id`, `login_at`, `email_verified_at`, `change_password_at`, `created_at`, `updated_at`) VALUES
(1, 'bosdev', 'vocvachcungthanh@gmail.com', '$2y$12$SMwIlTuf/bhT5HRNnHj6WuzVBduiNnBqUg/HxB.mjs2ZgIVzbl3g6', 'bosdev', '8hhYF1uM50QYlNI8ALKPYyxriQ2cbdckXYDdsxDeNCUE1TDsIawiMlfI3l2O', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vaGRoLWJvcy1kZXYueHl6L2hkaC1ib3MtYXBpL3B1YmxpYy9hcGkvYXV0aC9sb2dpbiIsImlhdCI6MTcxMzQ2MDYyOCwiZXhwIjoxNzEzNDYyNDI4LCJuYmYiOjE3MTM0NjA2MjgsImp0aSI6Imk5SWk2WTFCRFRUbTlwNXAiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.mAzBFIpVNEV4yjwXzblVwQ7zIXztoMTEYHUtGEwhoXw', 1, 1, NULL, NULL, NULL, '2024-03-12 09:40:44', '2024-04-18 10:17:08'),
(2, 'admin2', 'vocvachcungthanh2@gmail.com', '$2y$12$HA3rCNUAAoGY5v7fkW1T/e/RukOupzo7vwm8VTOQy4OAsQJrmu1Nm', 'admin2', 'Rwl9psFOO0KG52XyXwRBZvQai0tzm3dYwH1R008d5JmNUJtMtMdYDLc7WIcJ', NULL, 1, 1, NULL, NULL, NULL, '2024-03-12 09:40:44', '2024-03-12 09:40:44');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hosting`
--
ALTER TABLE `hosting`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `hosting`
--
ALTER TABLE `hosting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
