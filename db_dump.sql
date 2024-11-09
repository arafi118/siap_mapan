-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table siap_mapan.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` bigint unsigned NOT NULL,
  `lev1` int NOT NULL,
  `lev2` int NOT NULL,
  `lev3` int NOT NULL,
  `lev4` int NOT NULL,
  `kode_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_mutasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.accounts: ~0 rows (approximately)
DELETE FROM `accounts`;

-- Dumping structure for table siap_mapan.businesses
CREATE TABLE IF NOT EXISTS `businesses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telpon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.businesses: ~0 rows (approximately)
DELETE FROM `businesses`;
INSERT INTO `businesses` (`id`, `nama`, `alamat`, `telpon`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'Marks Inc', '1595 Jennie Plain Suite 954\nMeggieborough, SD 71522', '08904730156', 'homenick.jordy@example.org', '2024-11-08 20:02:46', '2024-11-08 20:02:46');

-- Dumping structure for table siap_mapan.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` bigint unsigned DEFAULT NULL,
  `desa` bigint unsigned DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_panggilan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` text COLLATE utf8mb4_unicode_ci,
  `tgl_lahir` date DEFAULT NULL,
  `domisi` text COLLATE utf8mb4_unicode_ci,
  `hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pernikahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penjamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_penjamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hubungan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usaha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci,
  `terdaftar` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `petugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.customers: ~0 rows (approximately)
DELETE FROM `customers`;
INSERT INTO `customers` (`id`, `business_id`, `desa`, `nama`, `nama_panggilan`, `nik`, `jk`, `alamat`, `tempat_lahir`, `tgl_lahir`, `domisi`, `hp`, `kk`, `agama`, `pendidikan`, `status_pernikahan`, `penjamin`, `nik_penjamin`, `hubungan`, `nama_ibu`, `tempat_kerja`, `usaha`, `foto`, `terdaftar`, `status`, `petugas`, `created_at`, `updated_at`) VALUES
	(1, NULL, NULL, 'royy', NULL, '1111111111111', NULL, 'sutopati', NULL, NULL, NULL, '085601655650', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-08 20:02:47', '2024-11-08 20:02:47');

-- Dumping structure for table siap_mapan.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table siap_mapan.families
CREATE TABLE IF NOT EXISTS `families` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kekeluargaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.families: ~8 rows (approximately)
DELETE FROM `families`;
INSERT INTO `families` (`id`, `kekeluargaan`, `created_at`, `updated_at`) VALUES
	(1, 'Suami', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(2, 'Istri', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(3, 'Ayah', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(4, 'Ibu', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(5, 'Sdr. Kandung', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(6, 'Anak', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(7, 'Kerabat Lainya', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(8, 'Ketua Kelompok', '2024-11-08 20:02:47', '2024-11-08 20:02:47');

-- Dumping structure for table siap_mapan.installations
CREATE TABLE IF NOT EXISTS `installations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned NOT NULL,
  `desa` bigint unsigned NOT NULL,
  `lokasi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` date NOT NULL,
  `pasang` date NOT NULL,
  `aktif` date NOT NULL,
  `blokir` date NOT NULL,
  `cabut` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.installations: ~0 rows (approximately)
DELETE FROM `installations`;

-- Dumping structure for table siap_mapan.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_10_28_024133_create_businesses_table', 1),
	(6, '2024_10_28_024142_create_customers_table', 1),
	(7, '2024_10_28_024146_create_packages_table', 1),
	(8, '2024_10_28_024203_create_usages_table', 1),
	(9, '2024_10_28_024213_create_installations_table', 1),
	(10, '2024_10_28_024219_create_accounts_table', 1),
	(11, '2024_10_28_024227_create_transactions_table', 1),
	(12, '2024_10_28_024702_create_villages_table', 1),
	(13, '2024_11_08_023550_create_families_table', 1);

-- Dumping structure for table siap_mapan.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` bigint unsigned NOT NULL,
  `paket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abodemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.packages: ~0 rows (approximately)
DELETE FROM `packages`;

-- Dumping structure for table siap_mapan.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table siap_mapan.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping structure for table siap_mapan.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rekening_debit` bigint unsigned NOT NULL,
  `rekening_kredit` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `usage_id` bigint unsigned NOT NULL,
  `total` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.transactions: ~0 rows (approximately)
DELETE FROM `transactions`;

-- Dumping structure for table siap_mapan.usages
CREATE TABLE IF NOT EXISTS `usages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` bigint unsigned NOT NULL,
  `installation_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.usages: ~0 rows (approximately)
DELETE FROM `usages`;

-- Dumping structure for table siap_mapan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` bigint unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telpon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `business_id`, `nama`, `jenis_kelamin`, `alamat`, `telpon`, `jabatan`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Celine Homenick', 'L', '40923 Domingo Light Suite 358\nHomenickfort, WY 99681', '08313714883', '2', 'vstoltenberg', '$2y$12$/Lceu1jH5.Y4Mmrt/QiGN.K1NtwH4op/VJqm1r5seQAM2bAAr0q1a', 'RZsS7PJuzZ', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(2, 1, 'Jayde Barton I', 'P', '577 Okuneva Motorway\nMacmouth, WI 17887-3387', '08583113086', '2', 'reynold49', '$2y$12$B75609dUDYIrPunyM1vbR.ucrl1EJnJ.yNFuOtyHo20005GDmxOnm', 'Dxx63GFJV8', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(3, 1, 'Keanu Turcotte IV', 'P', '534 Domenick Alley\nGulgowskiside, NM 15873-2566', '08043709790', '2', 'stracke.stephania', '$2y$12$0U1PwtzByP5uhG1S51jtTeKxov3jO3SToGuYRTA1MLtONDEAz4Gu6', '6xL8CmV4cF', '2024-11-08 20:02:47', '2024-11-08 20:02:47');

-- Dumping structure for table siap_mapan.villages
CREATE TABLE IF NOT EXISTS `villages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `villages_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siap_mapan.villages: ~3 rows (approximately)
DELETE FROM `villages`;
INSERT INTO `villages` (`id`, `kode`, `nama`, `created_at`, `updated_at`) VALUES
	(1, '123', 'Sutopati', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(2, '124', 'Kajoran', '2024-11-08 20:02:47', '2024-11-08 20:02:47'),
	(3, '125', 'Salaman', '2024-11-08 20:02:47', '2024-11-08 20:02:47');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
