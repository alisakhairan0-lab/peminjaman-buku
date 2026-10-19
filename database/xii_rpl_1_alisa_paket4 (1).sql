-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2026 at 03:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xii_rpl_1_alisa_paket4`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
(1, 'Alisa Khairan(Kepala Pustaka)', 'admin', 'admin123'),
(2, 'Rizky Ramadhan(Petugas Sirkulasi)', 'petugas1', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id_alumni` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_lengkap` varchar(80) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role` enum('user') NOT NULL DEFAULT 'user',
  `status` enum('Aktif','Non-Aktif') NOT NULL DEFAULT 'Non-Aktif',
  `tgl_keluar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id_alumni`, `id_pengguna`, `nis`, `nama_lengkap`, `username`, `password`, `role`, `status`, `tgl_keluar`) VALUES
(1, 16, '20090618', 'Ellen Junithan Daeli', 'ell', 'ellen123', 'user', 'Non-Aktif', '2026-09-24 00:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `penulis` varchar(80) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_penerbit` int(11) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `stok` int(5) NOT NULL DEFAULT 0,
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `id_kategori`, `id_penerbit`, `tahun_terbit`, `stok`, `gambar`) VALUES
(1, 'Pemrograman Web & Perangkat Bergerak SMK Kelas XI', 'Budi Raharjo, M.Kom', 1, 2, '2023', 15, NULL),
(2, 'Basis Data Relasional & MySQL untuk Siswa SMK RPL', 'Dr. Eng. Abdul Kadir', 1, 1, '2022', 13, NULL),
(3, 'Pemrograman Berorientasi Objek dengan Java & PHP', 'Eko Prasetyo, M.T.', 1, 2, '2023', 10, NULL),
(4, 'Arsitektur MVC & Pengembangan Framework Web Modern', 'Rian Pratama, S.Kom', 1, 6, '2024', 8, NULL),
(5, 'Algoritma & Struktur Data Pemrograman Terapan', 'Dr. Antonius Rachmat', 1, 1, '2021', 15, NULL),
(6, 'Rekayasa Perangkat Lunak: Konsep & Implementasi UML', 'Rosa A.S. & M. Shalahuddin', 1, 2, '2022', 11, NULL),
(7, 'Desain Antarmuka Pengguna (UI/UX) Aplikasi Web & Mobile', 'Dika Aditya, S.Ds', 1, 6, '2023', 9, NULL),
(8, 'Pengujian Kualitas Perangkat Lunak (QA & Software Testing)', 'Fajar Nugroho, M.Kom', 1, 1, '2022', 7, NULL),
(9, 'Pengembangan RESTful API & Keamanan Aplikasi Web', 'Yusuf Kurniawan, S.T.', 1, 2, '2023', 13, NULL),
(10, 'Version Control System dengan Git & GitHub untuk Tim Dev', 'Bambang Hariyanto', 1, 6, '2024', 15, NULL),
(11, 'Administrasi Infrastruktur Jaringan (AIJ) SMK Kelas XI', 'Iwan Sofana, S.T.', 2, 2, '2023', 15, NULL),
(12, 'Administrasi Server Jaringan Berbasis Linux Debian & Ubuntu', 'Onno W. Purbo, Ph.D', 2, 1, '2022', 12, NULL),
(13, 'Teknologi Jaringan Berbasis Luas (WAN) SMK Kelas XII', 'Totok Sukardiyono', 2, 4, '2023', 10, NULL),
(14, 'Konfigurasi Router MikroTik MTCNA untuk Laboratorium SMK', 'Rendra Towidjojo', 2, 6, '2024', 14, NULL),
(15, 'Keamanan Jaringan Komputer & Ethical Hacking Dasar', 'Andi Micro', 2, 1, '2022', 9, NULL),
(16, 'Teknologi Layanan Jaringan (TLJ) VoIP & PBX Server', 'M. Syaiful, M.Kom', 2, 2, '2023', 11, NULL),
(17, 'Cloud Computing & Virtualisasi Server Proxmox VE', 'Ari Gunawan, S.Kom', 2, 6, '2024', 8, NULL),
(18, 'Panduan Instalasi & Troubleshooting Jaringan Fiber Optik', 'Budi Sutedjo', 2, 1, '2021', 10, NULL),
(19, 'Monitoring Jaringan Komputer Menggunakan Zabbix & Grafana', 'Ahmad Fauzi', 2, 2, '2023', 7, NULL),
(20, 'Dasar-Dasar Teknik Jaringan Komputer & Telekomunikasi', 'Dwi Maryono', 2, 5, '2022', 18, NULL),
(21, 'Praktikum Akuntansi Perusahaan Jasa & Dagang Kelas XII', 'Dra. Sri Mulyani, M.Pd', 3, 4, '2023', 15, NULL),
(22, 'Komputer Akuntansi Terapan Menggunakan MYOB Premier v19', 'Bimo Sutedjo, S.E.', 3, 1, '2022', 14, NULL),
(23, 'Akuntansi Keuangan Lanjutan untuk SMK Kelas XI', 'Prof. Dr. Slamet Sugiri', 3, 4, '2023', 12, NULL),
(24, 'Pengelolaan Kas & Perbankan Dasar Siswa SMK AKL', 'Endang Mulyani, M.Si', 3, 5, '2022', 15, NULL),
(25, 'Praktikum Akuntansi Lembaga & Instansi Pemerintah', 'Dr. Sony Warsono', 3, 1, '2023', 10, NULL),
(26, 'Administrasi Pajak PPh & PPN Terapan untuk Siswa', 'Mardiasmo, M.B.A.', 3, 4, '2024', 11, NULL),
(27, 'Aplikasi Spreadsheet untuk Pengolahan Data Akuntansi', 'Triyono, S.Pd', 3, 6, '2023', 13, NULL),
(28, 'Audit & Pemeriksaan Keuangan Dasar untuk Asisten Auditor', 'Hery, S.E., M.Si', 3, 3, '2022', 8, NULL),
(29, 'Akuntansi Biaya & Penentuan Harga Pokok Produksi SMK', 'Mulyadi, Ak.', 3, 4, '2023', 9, NULL),
(30, 'Analisis Laporan Keuangan Perusahaan Manufaktur', 'Kasmir, S.E., M.M.', 3, 3, '2022', 10, NULL),
(31, 'Otomatisasi Tata Kelola Kehumasan & Keprotokolan MPLB', 'Drs. Hendra Kusuma', 4, 4, '2023', 14, NULL),
(32, 'Otomatisasi Tata Kelola Kepegawaian & Sumber Daya Manusia', 'Dra. Titik Rahayu', 4, 5, '2022', 12, NULL),
(33, 'Manajemen Kearsipan Digital & Korespondensi Bisnis', 'Dra. Sri Endang R.', 4, 4, '2023', 15, NULL),
(34, 'Tata Kelola Sarana & Prasarana Kantor Modern', 'Joko Parmono, M.Pd', 4, 5, '2022', 11, NULL),
(35, 'Komunikasi Efektif & Layanan Pelanggan Prima (Service Excellence)', 'Dyah Pitaloka, S.Sos', 4, 3, '2023', 13, NULL),
(36, 'Manajemen Pengelolaan Agenda Kerja & Perjalanan Dinas', 'Ratna Juwita, M.M.', 4, 4, '2024', 9, NULL),
(37, 'Etika Profesi & Pengembangan Kepribadian Sekretaris Kantor', 'Siti Fatimah, S.Pd', 4, 5, '2022', 16, NULL),
(38, 'Digital Office: Pemanfaatan Google Workspace & Cloud Office', 'Nurul Huda, S.Kom', 4, 6, '2023', 10, NULL),
(39, 'Pengelolaan Rapat Elektronik & Dokumentasi Notula', 'Agus Mulyanto', 4, 4, '2022', 8, NULL),
(40, 'Otomatisasi Tata Kelola Keuangan Kas Kecil (Petty Cash)', 'Dra. Neni Marlina', 4, 5, '2023', 12, NULL),
(41, 'Strategi Pemasaran Digital & E-Commerce SMK Kelas XI', 'Prof. Rhenald Kasali, Ph.D', 5, 3, '2023', 18, NULL),
(42, 'Pemasaran Media Sosial & Content Marketing untuk UMKM', 'Denny Santoso', 5, 6, '2024', 15, NULL),
(43, 'Riset Pasar Digital & Analisis Tren Konsumen Online', 'Dr. Indrawan Nugroho', 5, 3, '2023', 11, NULL),
(44, 'Search Engine Optimization (SEO) & Copywriting Kreatif', 'Aditya Kristanto', 5, 6, '2022', 12, NULL),
(45, 'Manajemen Operasional Toko Online & Marketplace Live', 'Faisal Rachman', 5, 1, '2023', 14, NULL),
(46, 'Bisnis Ritel & Penataan Produk (Visual Merchandising)', 'Drs. Danang Sunyoto', 5, 4, '2022', 9, NULL),
(47, 'Perencanaan Bisnis & Pitching Proposal Startup SMK', 'Handry Satriago', 5, 3, '2023', 10, NULL),
(48, 'Iklan Digital Berbayar: Meta Ads & Google Ads Praktis', 'Ryan Kristo Muljono', 5, 6, '2024', 8, NULL),
(49, 'Customer Relationship Management (CRM) & Retensi Pembeli', 'Agus Riyanto', 5, 1, '2022', 13, NULL),
(50, 'Manajemen Logistik, Pergudangan & Supply Chain E-Commerce', 'Zulkifli, S.T., M.M.', 5, 4, '2023', 7, NULL),
(51, 'Ilustrasi Digital & Karakter Desain dengan Vector Art', 'Hendi Hendratman, S.T.', 6, 2, '2023', 16, NULL),
(52, 'Prinsip Dasar Tipografi & Desain Layout Grafis Publikasi', 'Surianto Rustan, S.Sn', 6, 3, '2022', 12, NULL),
(53, 'Desain Identitas Visual & Branding Logo Perusahaan Kreatif', 'Danton Sihombing', 6, 3, '2023', 14, NULL),
(54, 'Fotografi Komersial & Produk untuk Studio Desain', 'Darwis Triadi', 6, 3, '2022', 10, NULL),
(55, 'Teknik Animasi 2D Frame by Frame & Motion Graphics', 'Chandra Endroputro', 6, 2, '2023', 8, NULL),
(56, 'Desain Kemasan Produk Kreatif (Packaging Design) SMK DKV', 'Ritzky Karina', 6, 1, '2024', 11, NULL),
(57, 'Pengantar Desain Grafis Komputer Menggunakan Adobe Illustrator', 'Arry Akhmad A.', 6, 2, '2022', 15, NULL),
(58, 'Sinematografi & Pasca-Produksi Video Digital Siswa SMK', 'Tito Imanda', 6, 3, '2023', 9, NULL),
(59, 'Desain UI/UX Mobile Apps: Wireframing & Prototyping Figma', 'Eko Nugroho, M.Ds', 6, 6, '2024', 13, NULL),
(60, 'Storyboarding & Konsep Visual Kreatif Film Iklan', 'Riri Riza & Mira Lesmana', 6, 3, '2021', 7, NULL),
(61, 'Pemeliharaan Mesin Kendaraan Ringan (PMKR) SMK Kelas XI', 'Drs. Buntarto, M.Pd', 7, 1, '2023', 14, NULL),
(62, 'Sistem Kelistrikan Otomotif & Electronic Fuel Injection (EFI)', 'Daryanto, S.Pd', 7, 5, '2022', 12, NULL),
(63, 'Pemeliharaan Sasis & Pemindah Tenaga Kendaraan Ringan', 'Zainal Arifin, M.T.', 7, 1, '2023', 10, NULL),
(64, 'Diagnosa & Troubleshooting Kerusakan Mesin Menggunakan OBD', 'Bambang Sudarmanta', 7, 4, '2024', 8, NULL),
(65, 'Teknologi Kendaraan Listrik (Electric Vehicle) & Baterai', 'Dr. Tri Widodo', 7, 1, '2023', 15, NULL),
(66, 'Perawatan Sistem Pendingin AC Mobil & Sirkulasi Fluida', 'Agus Setiyono', 7, 5, '2022', 9, NULL),
(67, 'Teknologi Mesin Diesel Common Rail Modern', 'Mochamad Cholik, M.T.', 7, 1, '2023', 11, NULL),
(68, 'Tune-Up Konvensional & Perawatan Berkala 10.000 KM', 'Supriyadi, S.T.', 7, 4, '2022', 13, NULL),
(69, 'Sistem Rem ABS & Kontrol Stabilitas Elektronik Kendaraan', 'Heri Sunaryo', 7, 1, '2023', 7, NULL),
(70, 'Keselamatan, Kesehatan Kerja & Lingkungan (K3LH) Bengkel', 'Sudji Munadi', 7, 5, '2022', 15, NULL),
(71, 'Pengantar Kecerdasan Buatan (Artificial Intelligence) Populer', 'Prof. Bambang Riyanto', 8, 2, '2023', 20, NULL),
(72, 'Konsep Data Science & Pengolahan Data Menggunakan Python', 'Dr. Eng. Wisnu Jatmiko', 8, 1, '2023', 17, NULL),
(73, 'Mengenal Internet of Things (IoT) Berbasis Arduino & ESP32', 'M. Fajar Wicaksono', 8, 2, '2022', 14, NULL),
(74, 'Robotika Sederhana & Otomasi Sensor untuk Pemula', 'Widodo Budiharto, S.Si', 8, 6, '2023', 12, NULL),
(75, 'Keamanan Siber & Privasi Data di Era Digital', 'Rudi Lumanto, Ph.D', 8, 3, '2024', 15, NULL),
(76, 'Komputasi Awan (Cloud Infrastructure) Transformasi Digital', 'Budi Rahardjo, Ph.D', 8, 2, '2022', 11, NULL),
(77, 'Big Data & Analitika Prediktif untuk Pengambilan Keputusan', 'Taufik Sutanto, M.Sc', 8, 1, '2023', 9, NULL),
(78, 'Pengenalan Blockchain & Smart Contracts Secara Mudah', 'Ridho Pratama, M.Sc', 8, 6, '2024', 8, NULL),
(79, 'Dasar-Dasar Algoritma Kriptografi & Enkripsi Modern', 'Dr. Rinaldi Munir', 8, 2, '2022', 10, NULL),
(80, 'Sains Fisika Terapan untuk Teknologi Masa Depan', 'Prof. Yohanes Surya, Ph.D', 8, 3, '2021', 13, NULL),
(81, 'Senja di Pelabuhan Kenangan', 'Tere Liye', 9, 3, '2022', 24, NULL),
(82, 'Hujan di Sudut Perpustakaan Sekolah', 'Almira Bastari', 9, 3, '2023', 22, NULL),
(83, 'Bintang di Langit Khatulistiwa', 'Andrea Hirata', 9, 3, '2021', 19, NULL),
(84, 'Melodi Rahasia di Balik Lemari Kaca', 'Dee Lestari', 9, 3, '2023', 17, NULL),
(85, 'Jejak Langkah Sang Penemu Muda', 'Ahmad Fuadi', 9, 3, '2022', 16, NULL),
(86, 'Di Tepian Sungai Waktu', 'Pramoedya Ananta Toer', 9, 3, '2020', 14, NULL),
(87, 'Lentera Jiwa Menembus Batas', 'Ika Natassa', 9, 3, '2023', 18, NULL),
(88, 'Labirin Impian Sang Pemimpi', 'Boy Candra', 9, 3, '2022', 20, NULL),
(89, 'Rona Merah di Ufuk Senja', 'Asma Nadia', 9, 3, '2021', 15, NULL),
(90, 'Sahabat Bintang & Surat Masa Depan', 'Raditya Dika', 9, 3, '2023', 24, NULL),
(91, 'Hujan Bulan Juni: Kumpulan Puisi Pilihan', 'Sapardi Djoko Damono', 10, 3, '2021', 20, NULL),
(92, 'Tirani dan Benteng: Antologi Puisi Perjuangan', 'Taufiq Ismail', 10, 3, '2020', 15, NULL),
(93, 'O Amuk Kapak: Sajak-Sajak Monumental', 'Sutardji Calzoum Bachri', 10, 3, '2021', 12, NULL),
(94, 'Madah Kelana & Nyanyi Sunyi Sastra Klasik', 'Amir Hamzah', 10, 3, '2020', 10, NULL),
(95, 'Robohnya Surau Kami & Cerita Pendek Nusantara', 'A.A. Navis', 10, 3, '2022', 18, NULL),
(96, 'Layar Terkembang & Angkatan Pujangga Baru', 'Sutan Takdir Alisjahbana', 10, 5, '2021', 14, NULL),
(97, 'Cantik Itu Luka: Mahakarya Sastra Kontemporer', 'Eka Kurniawan', 10, 3, '2023', 16, NULL),
(98, 'Bumi Manusia: Tetralogi Pulau Buru Jilid 1', 'Pramoedya Ananta Toer', 10, 3, '2022', 22, NULL),
(99, 'Ronggeng Dukuh Paruk: Kisah Penari Legendaris', 'Ahmad Tohari', 10, 3, '2021', 17, NULL),
(100, 'Saman & Larung: Eksplorasi Sastra Modern', 'Ayu Utami', 10, 3, '2022', 13, NULL),
(101, 'Filosofi Teras: Menemukan Kedamaian Mental Stoisisme', 'Henry Manampiring', 11, 3, '2023', 28, NULL),
(102, 'Berani Tidak Disukai: Psikologi Keberanian Hidup', 'Ichiro Kishimi & Fumitake Koga', 11, 3, '2022', 24, NULL),
(103, 'Seni Berbicara di Depan Publik (Public Speaking Efektif)', 'Charles Bonar Sirait', 11, 3, '2023', 19, NULL),
(104, 'Manajemen Waktu & Produktivitas Generasi Produktif', 'James Clear', 11, 3, '2022', 30, NULL),
(105, 'Mindset: Sukses Melalui Pola Pikir Berkembang', 'Carol S. Dweck, Ph.D', 11, 3, '2021', 16, NULL),
(106, 'Emotional Intelligence: Kecerdasan Emosional Karir', 'Daniel Goleman', 11, 3, '2020', 15, NULL),
(107, 'Start with Why: Cara Pemimpin Menginspirasi Tindakan', 'Simon Sinek', 11, 3, '2022', 18, NULL),
(108, 'Grit: Kekuatan Ketekunan dan Pantang Menyerah', 'Angela Duckworth', 11, 3, '2021', 16, NULL),
(109, 'Membangun Disiplin Diri & Kebiasaan Positif Siswa', 'Stephen R. Covey', 11, 3, '2023', 21, NULL),
(110, 'Seni Mendengarkan & Negosiasi Berdaya Pengaruh Tinggi', 'Dale Carnegie', 11, 3, '2022', 21, NULL),
(111, 'Sejarah Nasional Indonesia: Dari Praaksara hingga Reformasi', 'Prof. Dr. Sartono Kartodirdjo', 12, 5, '2021', 15, NULL),
(112, 'Jejak Peradaban Kerajaan Maritim Nusantara', 'Prof. Dr. Slamet Muljana', 12, 3, '2022', 13, NULL),
(113, 'Riwayat Hidup & Perjuangan Bung Karno Penyambung Lidah', 'Cindy Adams', 12, 5, '2022', 18, NULL),
(114, 'Mohammad Hatta: Biografi Politik & Ekonomi Koperasi', 'Deliar Noer', 12, 3, '2021', 12, NULL),
(115, 'Warisan Busana Batik & Tenun Tradisional Nusantara', 'Iwan Tirta', 12, 3, '2023', 11, NULL),
(116, 'Arsitektur Tradisional Rumah Adat Kepulauan Indonesia', 'Prof. Eko Budihardjo', 12, 1, '2022', 10, NULL),
(117, 'Jalur Rempah Nusantara: Poros Maritim Dunia Masa Silam', 'M. Dien Madjid', 12, 3, '2023', 14, NULL),
(118, 'Sejarah Pergerakan Kebangkitan Nasional 1908-1945', 'Taufik Abdullah', 12, 5, '2021', 16, NULL),
(119, 'Folklor & Mitologi Dongeng Tradisional Nusantara', 'Dr. James Danandjaja', 12, 3, '2022', 17, NULL),
(120, 'Ensiklopedia Tokoh Pahlawan Kemerdekaan Indonesia', 'A. Kardiyat Wiharyanto', 12, 4, '2023', 19, NULL),
(121, 'English for Vocational High School: Teknik & Komputer', 'Dra. Nurhayati, M.Hum', 13, 4, '2023', 22, NULL),
(122, 'English for Business & Secretarial Communication', 'Drs. Bambang Sugeng', 13, 4, '2022', 18, NULL),
(123, 'Practical English Grammar & Everyday Conversation', 'Betty Schrampfer Azar', 13, 4, '2021', 25, NULL),
(124, 'TOEFL Preparation Guide for High School Students', 'Lin Lougheed', 13, 4, '2023', 20, NULL),
(125, 'Professional Email Writing & Business Correspondence', 'Dwi Astuti Wahyu', 13, 6, '2022', 15, NULL),
(126, 'Public Speaking in English: Presentation Skills', 'Michael Duckworth', 13, 3, '2023', 14, NULL),
(127, 'Idioms and Phrasal Verbs in Practical Context', 'Raymond Murphy', 13, 4, '2022', 17, NULL),
(128, 'Academic Reading & Vocabulary Builder for Vocational', 'Adrian Wallwork', 13, 1, '2023', 15, NULL),
(129, 'English for Customer Care and Tourism Hospitality', 'Marianne Celce-Murcia', 13, 4, '2022', 13, NULL),
(130, 'Mastering Job Interview in English for Fresh Graduates', 'Simon Sweeney', 13, 6, '2024', 19, NULL),
(131, 'Ensiklopedia Sains & Alam Semesta Bergambar', 'Tim Pustaka Sains', 14, 4, '2023', 16, NULL),
(132, 'Ensiklopedia Tubuh Manusia & Sistem Biologi', 'Dr. David Macaulay', 14, 3, '2022', 14, NULL),
(133, 'Geografi Dunia: Iklim, Benua & Fenomena Alam', 'National Geographic Indonesia', 14, 3, '2023', 18, NULL),
(134, 'Fakta Dunia Menakjubkan: Sains, Sejarah & Rekor Global', 'Guinness World Records', 14, 3, '2024', 21, NULL),
(135, 'Mengenal Sistem Tata Surya & Penjelajahan Antariksa', 'Dr. Neil deGrasse Tyson', 14, 3, '2022', 15, NULL),
(136, 'Flora & Fauna Endemik Hutan Tropis Indonesia', 'LIPI / BRIN Pustaka', 14, 5, '2023', 13, NULL),
(137, 'Ensiklopedia Inovasi Teknologi Mengubah Peradaban', 'DK Publishing', 14, 3, '2022', 17, NULL),
(138, 'Mengenal Energi Baru & Terbarukan: Surya & Angin', 'Dr. Tri Mulyono', 14, 1, '2023', 12, NULL),
(139, 'Panduan Pertolongan Pertama & Kesehatan Remaja', 'Palang Merah Indonesia', 14, 4, '2022', 18, NULL),
(140, 'Atlas Lengkap Indonesia & 38 Provinsi Nusantara', 'Badan Informasi Geospasial', 14, 4, '2023', 24, NULL),
(141, 'Modul Projek Kreatif & Kewirausahaan (PKK) SMK XII', 'Drs. Hendro, M.M.', 15, 4, '2023', 20, NULL),
(142, 'Membangun Bisnis dari Nol: Panduan Wirausaha Muda', 'Yasa Singgih', 15, 3, '2022', 18, NULL),
(143, 'Lean Startup: Cara Cepat Menguji Ide Usaha Kreatif', 'Eric Ries', 15, 3, '2021', 16, NULL),
(144, 'Desain Model Bisnis (Business Model Canvas) Praktis', 'Alexander Osterwalder', 15, 6, '2023', 17, NULL),
(145, 'Branding Praktis untuk Produk UMKM & Usaha Sekolah', 'Subiakto Priosoedarsono', 15, 3, '2022', 15, NULL),
(146, 'Strategi Penetapan Harga & Manajemen Arus Kas Baru', 'Dr. Kasmir', 15, 1, '2023', 13, NULL),
(147, 'Pemanfaatan Platform Digital untuk Pemasaran Siswa', 'Budi Isman', 15, 6, '2024', 14, NULL),
(148, 'Kewirausahaan Sosial: Membangun Usaha Berdampak', 'Muhammad Yunus', 15, 3, '2022', 11, NULL),
(149, 'Manajemen Risiko Usaha & Perlindungan Hak Merek', 'Prof. Ahmad Ramli', 15, 5, '2023', 20, NULL),
(150, 'a', 'a', 9, 1, '2026', 0, 'default_book.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `jumlah` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_buku`, `jumlah`) VALUES
(20, 27, 142, 1),
(21, 28, 136, 1),
(22, 29, 149, 1),
(23, 30, 148, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'SMK - Rekayasa Perangkat Lunak (RPL)'),
(2, 'SMK - Teknik Komputer & Jaringan (TKJ)'),
(3, 'SMK - Akuntansi & Keuangan Lembaga (AKL)'),
(4, 'SMK - Manajemen Perkantoran & Layanan Bisnis (MPLB)'),
(5, 'SMK - Bisnis Digital & Pemasaran'),
(6, 'SMK - Desain Komunikasi Visual (DKV)'),
(7, 'SMK - Teknik Kendaraan Ringan Otomotif (TKRO)'),
(8, 'Sains & Teknologi Komputasi'),
(9, 'Novel & Fiksi Remaja'),
(10, 'Sastra & Puisi Nusantara'),
(11, 'Pengembangan Diri & Kepemimpinan'),
(12, 'Sejarah & Budaya Nasional'),
(13, 'Bahasa Inggris & Komunikasi Global'),
(14, 'Ensiklopedia & Pengetahuan Umum'),
(15, 'Kewirausahaan & Industri Kreatif');

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `nama_penerbit` varchar(60) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `nama_penerbit`, `alamat`, `telepon`) VALUES
(1, 'Penerbit Andi Yogyakarta', 'Jl. Beo 38-40 Yogyakarta', '0274-561881'),
(2, 'Informatika Bandung', 'Jl. Buah Batu No. 120 Bandung', '022-7303030'),
(3, 'Gramedia Pustaka Utama', 'Gd. Kompas Gramedia, Palmerah Jakarta', '021-53650110'),
(4, 'Erlangga Mandiri', 'Jl. H. Baping Raya No. 100 Jakarta', '021-8717085'),
(5, 'Yudhistira Ghalia Indonesia', 'Jl. Rancamaya KM 1 Bogor', '0251-8240616'),
(6, 'Elex Media Komputindo', 'Palmerah Selatan 22 Jakarta Pusat', '021-5483008');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_lengkap` varchar(80) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user') NOT NULL DEFAULT 'user',
  `status` enum('Aktif','Non-Aktif') NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nis`, `nama_lengkap`, `username`, `password`, `role`, `status`) VALUES
(2, '20241005', 'Rizky Ramadhan', 'riziee', 'user123', 'user', 'Aktif'),
(17, '20081808', 'Tasya Julianti', 'tasa', 'tasya123', 'user', 'Aktif'),
(18, '20080918', 'Irma Diana', 'ima', 'irma123', 'user', 'Aktif'),
(19, '20090211', 'Alisa Sumbandono', 'aliss', 'alisa123', 'user', 'Aktif'),
(22, '1', 'a', 'a', 'a', 'user', 'Aktif'),
(23, '20091418', 'Azalea Inara Makailah', 'azalea', 'lea', 'user', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `tgl_pengajuan` date NOT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `batas_kembali` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` enum('menunggu','dipinjam','menunggu_kembali','dikembalikan','ditolak') NOT NULL DEFAULT 'dipinjam',
  `total_denda` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pengguna`, `id_admin`, `tgl_pengajuan`, `tgl_pinjam`, `batas_kembali`, `tgl_kembali`, `status`, `total_denda`) VALUES
(27, NULL, 1, '2026-09-22', '2026-09-22', '2026-09-29', '2026-09-24', 'dikembalikan', 0.00),
(28, NULL, 1, '2026-09-23', '2026-09-23', '2026-09-30', '2026-09-24', 'dikembalikan', 0.00),
(29, 22, 1, '2026-09-24', '2026-09-24', '2026-10-01', '2026-09-30', 'dikembalikan', 0.00),
(30, 18, 1, '2026-09-24', '2026-09-24', '2026-10-01', NULL, 'dipinjam', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id_alumni`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_buku_kategori` (`id_kategori`),
  ADD KEY `fk_buku_penerbit` (`id_penerbit`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_detail_transaksi` (`id_transaksi`),
  ADD KEY `fk_detail_buku` (`id_buku`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_transaksi_admin` (`id_admin`),
  ADD KEY `fk_transaksi_pengguna` (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id_alumni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_buku_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_buku_penerbit` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `fk_detail_buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
