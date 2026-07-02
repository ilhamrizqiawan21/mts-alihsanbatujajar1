SET NAMES utf8mb4;
SET foreign_key_checks = 0;

CREATE TABLE IF NOT EXISTS `kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(20) NOT NULL,
  `wali_kelas` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tahun` varchar(9) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `siswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas_id` int unsigned NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp_ortu` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nis` (`nis`),
  KEY `kelas_id` (`kelas_id`),
  CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `jenis_pelanggaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) NOT NULL,
  `poin` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tingkat_prestasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `absensi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` int unsigned NOT NULL,
  `tahun_ajaran_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('H','I','S','A') NOT NULL DEFAULT 'H',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_absensi` (`siswa_id`,`tanggal`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pelanggaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` int unsigned NOT NULL,
  `tahun_ajaran_id` int unsigned NOT NULL,
  `jenis_pelanggaran_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  KEY `jenis_pelanggaran_id` (`jenis_pelanggaran_id`),
  CONSTRAINT `pelanggaran_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pelanggaran_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`),
  CONSTRAINT `pelanggaran_ibfk_3` FOREIGN KEY (`jenis_pelanggaran_id`) REFERENCES `jenis_pelanggaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `kebersihan_kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int unsigned NOT NULL,
  `tahun_ajaran_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `nilai_lantai` tinyint unsigned NOT NULL DEFAULT '0',
  `nilai_sampah` tinyint unsigned NOT NULL DEFAULT '0',
  `nilai_rak` tinyint unsigned NOT NULL DEFAULT '0',
  `nilai_penataan` tinyint unsigned NOT NULL DEFAULT '0',
  `nilai_total` tinyint unsigned NOT NULL DEFAULT '0',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `kebersihan_kelas_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`),
  CONSTRAINT `kebersihan_kelas_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `keterlambatan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` int unsigned NOT NULL,
  `tahun_ajaran_id` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam_datang` time NOT NULL,
  `alasan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `keterlambatan_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `keterlambatan_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `prestasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` int unsigned NOT NULL,
  `tahun_ajaran_id` int unsigned NOT NULL,
  `nama_prestasi` varchar(200) NOT NULL,
  `tingkat_prestasi_id` int unsigned NOT NULL,
  `juara` varchar(50) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `penyelenggara` varchar(150) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  KEY `tingkat_prestasi_id` (`tingkat_prestasi_id`),
  CONSTRAINT `prestasi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prestasi_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`),
  CONSTRAINT `prestasi_ibfk_3` FOREIGN KEY (`tingkat_prestasi_id`) REFERENCES `tingkat_prestasi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `surat_izin` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` int unsigned NOT NULL,
  `tahun_ajaran_id` int unsigned NOT NULL,
  `jenis_izin` enum('pulang','biasa') NOT NULL,
  `tanggal` date NOT NULL,
  `jam_berangkat` time DEFAULT NULL,
  `alasan_pulang` enum('sakit','keluarga','lomba','lainnya') DEFAULT NULL,
  `alasan_biasa` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  CONSTRAINT `fk_surat_izin_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_surat_izin_tahun` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','kepala_sekolah','siswa') NOT NULL DEFAULT 'admin',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tahun_ajaran` (`id`, `tahun`, `semester`, `is_aktif`, `created_at`) VALUES
(1, '2024/2025', '2', 0, '2026-05-02 10:56:02'),
(2, '2025/2026', '2', 1, '2026-05-03 03:56:58')
ON DUPLICATE KEY UPDATE `tahun`=VALUES(`tahun`);

INSERT INTO `kelas` (`id`, `nama_kelas`, `wali_kelas`, `created_at`) VALUES
(14, 'VII-A', 'Astri Yuliasari, S.Pd.', '2026-05-03 01:01:25')
ON DUPLICATE KEY UPDATE `nama_kelas`=VALUES(`nama_kelas`);

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas_id`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp_ortu`, `foto`, `status`, `created_at`) VALUES
(1, '7101', 'ALIFIA NUR FAIZAH', 14, 'P', NULL, NULL, NULL, NULL, NULL, 1, '2026-05-03 04:20:53')
ON DUPLICATE KEY UPDATE `nama`=VALUES(`nama`);

INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `poin`) VALUES
(1, 'Tidak Membawa Alat Sholat', 5),
(2, 'Tidak Membawa Juz Amma', 5)
ON DUPLICATE KEY UPDATE `nama`=VALUES(`nama`);

INSERT INTO `tingkat_prestasi` (`id`, `nama`) VALUES
(1, 'Sekolah'),
(2, 'Kecamatan')
ON DUPLICATE KEY UPDATE `nama`=VALUES(`nama`);

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, '2026-05-02 10:56:00')
ON DUPLICATE KEY UPDATE `username`=VALUES(`username`);

SET foreign_key_checks = 1;
