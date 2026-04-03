-- Database: `smp_pgri_ciomas`
CREATE DATABASE IF NOT EXISTS `smp_pgri_ciomas`;
USE `smp_pgri_ciomas`;

-- --------------------------------------------------------

-- Struktur dari tabel `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data untuk tabel `users`
INSERT INTO `users` (`id`, `username`, `password`, `nama`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator'); -- password is 'password'

-- --------------------------------------------------------

-- Struktur dari tabel `berita`
CREATE TABLE IF NOT EXISTS `berita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `konten` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('publish','draft') DEFAULT 'publish',
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data untuk tabel `berita`
INSERT INTO `berita` (`id`, `judul`, `kategori`, `konten`, `tanggal`, `status`, `gambar`) VALUES
(1, 'Jadwal Tes Seleksi SMP PGRI Ciomas Semester Genap 2024', 'Akademik', 'Konten selengkapnya tentang tes seleksi...', '2025-03-12', 'publish', NULL),
(2, 'Program Green School: Menanam 1000 Pohon', 'Lingkungan', 'Konten kegiatan green school...', '2025-03-18', 'publish', NULL),
(3, 'Halaman Partisipan Akhir Semester Genap 2024', 'Akademik', 'Informasi mengenai partisipan...', '2025-03-15', 'draft', NULL),
(4, 'Pengumuman Penerimaan Siswa Baru TA 2025/2026', 'Penerimaan', 'Pendaftaran telah dibuka untuk siswa baru...', '2025-03-20', 'publish', NULL);

-- --------------------------------------------------------

-- Struktur dari tabel `aspirasi`
CREATE TABLE IF NOT EXISTS `aspirasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `peran` varchar(50) DEFAULT 'Masyarakat',
  `pesan` text NOT NULL,
  `status` enum('baru','dibaca','dibalas') DEFAULT 'baru',
  `prioritas` enum('red','yellow','green','blue') DEFAULT 'green',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data untuk tabel `aspirasi`
INSERT INTO `aspirasi` (`id`, `nama`, `pesan`, `status`, `prioritas`, `created_at`) VALUES
(1, 'Anonim', 'Kantin perlu diperbanyak pilihan menu sehat', 'baru', 'green', '2026-04-03 08:00:00'),
(2, 'Orang Tua', 'Mohon informasi jadwal ujian lebih awal', 'baru', 'yellow', '2026-04-03 05:00:00'),
(3, 'Siswa', 'Lab komputer sering mati lampu', 'baru', 'red', '2026-04-02 10:00:00'),
(4, 'Alumni', 'Semoga fasilitas olahraga ditingkatkan lagi', 'baru', 'blue', '2026-04-01 14:00:00');

-- --------------------------------------------------------

-- Struktur dari tabel `fasilitas`
CREATE TABLE IF NOT EXISTS `fasilitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_fasilitas` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data untuk tabel `fasilitas`
INSERT INTO `fasilitas` (`id`, `nama_fasilitas`, `kategori`, `deskripsi`, `gambar`) VALUES
(1, 'Ruang Kelas Ber-AC', 'Ruang Belajar', 'Terdapat puluhan ruang kelas dengan AC.', NULL),
(2, 'Lab Komputer Modern', 'Laboratorium', 'Mendukung pembelajaran TIK.', NULL),
(3, 'Perpustakaan Digital', 'Ruang Belajar', 'Koleksi buku digital lengkap.', NULL),
(4, 'Lapangan Olahraga', 'Olahraga', 'Lapangan basket dan futsal.', NULL),
(5, 'Musholla Al-Fatih', 'Ibadah', 'Tempat ibadah yang nyaman.', NULL);

-- --------------------------------------------------------

-- Struktur dari tabel `pengaturan`
CREATE TABLE IF NOT EXISTS `pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `npsn` varchar(50) DEFAULT NULL,
  `akreditasi` varchar(100) DEFAULT NULL,
  `tahun_berdiri` varchar(10) DEFAULT NULL,
  `kepala_sekolah` varchar(100) DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data untuk tabel `pengaturan`
INSERT INTO `pengaturan` (`id`, `npsn`, `akreditasi`, `tahun_berdiri`, `kepala_sekolah`, `telp`) VALUES
(1, '20202020', 'A (Sangat Baik)', '1998', 'H. Ahmad Reza, M.Pd', '(0251) 123-456');

-- --------------------------------------------------------

-- Struktur dari tabel `pengunjung`
CREATE TABLE IF NOT EXISTS `pengunjung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `jumlah` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tanggal` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data untuk tabel `pengunjung` (7 hari terakhir)
INSERT INTO `pengunjung` (`id`, `tanggal`, `jumlah`) VALUES
(1, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 180),
(2, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 240),
(3, DATE_SUB(CURDATE(), INTERVAL 4 DAY), 195),
(4, DATE_SUB(CURDATE(), INTERVAL 3 DAY), 310),
(5, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 280),
(6, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 140),
(7, CURDATE(), 90);
