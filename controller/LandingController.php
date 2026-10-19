<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Kategori.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/Pengguna.php';

class LandingController extends Controller {
    public function index() {
        $bukuModel = new Buku();
        $kategoriModel = new Kategori();
        $transaksiModel = new Transaksi();
        $penggunaModel = new Pengguna();

        // Get stats
        $allBooks = $bukuModel->getAll();
        $allCategories = $kategoriModel->getWithBookCount();
        $allMembers = $penggunaModel->getAll();
        $allTransactions = $transaksiModel->getAll();

        // Latest and featured books
        $latestBooks = array_slice($bukuModel->getAllWithDetails(), 0, 8);

        // Group categories into Jurusan SMK & Novel & Umum
        $smkCategories = array_filter($allCategories, function($k) {
            return strpos($k['nama_kategori'], 'SMK') !== false;
        });

        $novelCategories = array_filter($allCategories, function($k) {
            return strpos($k['nama_kategori'], 'Novel') !== false;
        });

        $data = [
            'pageTitle' => 'Beranda - Perpustakaan Digital SMK Paket 4',
            'totalBuku' => count($allBooks),
            'totalKategori' => count($allCategories),
            'totalAnggota' => count($allMembers),
            'totalTransaksi' => count($allTransactions),
            'latestBooks' => $latestBooks,
            'kategoriList' => $allCategories,
            'smkCategories' => $smkCategories,
            'novelCategories' => $novelCategories
        ];

        $this->view('landing/index', $data);
    }
}
?>