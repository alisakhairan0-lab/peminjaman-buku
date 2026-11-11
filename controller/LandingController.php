
<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Kategori.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/User.php';

class LandingController extends Controller {

    public function index() {

        // Inisialisasi model
        $bukuModel = new Buku();
        $kategoriModel = new Kategori();
        $transaksiModel = new Transaksi();
        $userModel = new User();

        // Mengambil data dari database
        $allBooks = $bukuModel->getAll();
        $allCategories = $kategoriModel->getWithBookCount();

        // Mengambil akun dengan role pengguna (siswa)
        $allMembers = $userModel->getByRole('pengguna');

        $allTransactions = $transaksiModel->getAll();

        // Mengambil 8 buku terbaru
        $latestBooks = array_slice(
            $bukuModel->getAllWithDetails(),
            0,
            8
        );

        // Mengelompokkan kategori SMK
        $smkCategories = array_filter($allCategories, function($k) {
            return strpos($k['nama_kategori'], 'SMK') !== false;
        });

        // Mengelompokkan kategori Novel
        $novelCategories = array_filter($allCategories, function($k) {
            return strpos($k['nama_kategori'], 'Novel') !== false;
        });

        // Menyiapkan data untuk halaman landing
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

        // Menampilkan halaman landing
        $this->view('landing/index', $data);
    }
}

?>
