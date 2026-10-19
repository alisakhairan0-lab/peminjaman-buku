<?php
/**
 * Aplikasi Sistem Peminjaman Buku Perpustakaan Digital SMK (UKK RPL Paket 4)
 * Arsitektur: Object-Oriented Programming (OOP) - Model View Controller (MVC)
 * Database: xii_rpl_1_alisa_paket4.sql
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default timezone ke Waktu Indonesia Barat
date_default_timezone_set('Asia/Jakarta');

// Autoload Core & Models
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/model/Model.php';
require_once __DIR__ . '/model/Buku.php';
require_once __DIR__ . '/model/Pengguna.php';
require_once __DIR__ . '/model/Admin.php';
require_once __DIR__ . '/model/Kategori.php';
require_once __DIR__ . '/model/Penerbit.php';
require_once __DIR__ . '/model/Transaksi.php';
require_once __DIR__ . '/model/DetailTransaksi.php';

// Autoload Base Controller
require_once __DIR__ . '/controller/Controller.php';

// Daftar Controller yang didukung
$controllers = [
    'landing'   => 'LandingController',
    'katalog'   => 'KatalogController',
    'keranjang' => 'KeranjangController',
    'auth'      => 'AuthController',
    'admin'     => 'AdminController',
    'user'      => 'UserController',
    'buku'      => 'BukuController',
    'anggota'   => 'AnggotaController',
    'alumni'    => 'AlumniController',
    'kategori'  => 'KategoriController',
    'transaksi' => 'TransaksiController',
    'laporan'   => 'LaporanController'
];

// Dapatkan parameter Controller (c) dan Action (a)
$c = isset($_GET['c']) ? strtolower(trim($_GET['c'])) : 'landing';
$a = isset($_GET['a']) ? trim($_GET['a']) : 'index';

// Validasi keberadaan controller
if (!array_key_exists($c, $controllers)) {
    $c = 'landing';
}

$controllerClass = $controllers[$c];
$controllerFile  = __DIR__ . '/controller/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();

        if (method_exists($controllerInstance, $a)) {
            $controllerInstance->$a();
            exit;
        } else {
            // Fallback ke index jika method tidak ada
            if (method_exists($controllerInstance, 'index')) {
                $controllerInstance->index();
                exit;
            }
        }
    }
}

// Fallback Default
header("Location: index.php?c=landing&a=index");
exit;
