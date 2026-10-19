<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Transaksi.php';

class KeranjangController extends Controller {
    private function getUserId() {
        return $_SESSION['user_id'] 
            ?? $_SESSION['id_pengguna'] 
            ?? $_SESSION['id'] 
            ?? $_SESSION['pengguna_id'] 
            ?? ($_SESSION['user']['id_pengguna'] ?? null) 
            ?? ($_SESSION['user']['user_id'] ?? null);
    }

    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        $books = [];

        if (!empty($cart)) {
            $bukuModel = new Buku();
            foreach ($cart as $bookId) {
                $buku = $bukuModel->getDetail($bookId);
                if ($buku) {
                    $books[] = $buku;
                }
            }
        }

        $data = [
            'pageTitle' => 'Keranjang Peminjaman Buku',
            'cartBooks' => $books
        ];

        $this->view('keranjang/index', $data);
    }

    public function tambah() {
        $id = (int)($_POST['id_buku'] ?? $_GET['id'] ?? 0);
        if ($id <= 0) {
            $this->setFlash('danger', 'ID Buku tidak valid.');
            $this->redirect('index.php?c=katalog&a=index');
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (in_array($id, $_SESSION['cart'])) {
            $this->setFlash('warning', 'Buku ini sudah ada di dalam keranjang peminjaman Anda.');
        } else {
            $bukuModel = new Buku();
            $buku = $bukuModel->getById('id_buku', $id);
            if ($buku && $buku['stok'] > 0) {
                $_SESSION['cart'][] = $id;
                $this->setFlash('success', "Buku '{$buku['judul']}' berhasil ditambahkan ke keranjang!");
            } else {
                $this->setFlash('danger', 'Maaf, stok buku ini sedang habis.');
            }
        }

        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'index.php?c=keranjang&a=index';
        $this->redirect($redirectUrl);
    }

    public function hapus() {
        $id = (int)($_GET['id'] ?? 0);
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_diff($_SESSION['cart'], [$id]);
            $this->setFlash('info', 'Buku berhasil dihapus dari keranjang.');
        }
        $this->redirect('index.php?c=keranjang&a=index');
    }

    public function kosongkan() {
        $_SESSION['cart'] = [];
        $this->setFlash('info', 'Keranjang peminjaman telah dikosongkan.');
        $this->redirect('index.php?c=keranjang&a=index');
    }

    public function checkout() {
        $this->requireUser();

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $this->setFlash('warning', 'Keranjang Anda kosong. Pilih buku terlebih dahulu.');
            $this->redirect('index.php?c=katalog&a=index');
        }

        $id_pengguna = $this->getUserId();
        if (empty($id_pengguna)) {
            die("DEBUG: Sesi id_pengguna tidak terbaca dari session! Isi session: " . json_encode($_SESSION));
        }

        $transaksiModel = new Transaksi();
        $transaksiId = $transaksiModel->createPengajuan($id_pengguna, array_values($cart));

        // --- TAMBAHAN DEBUG ---
        if (!$transaksiId) {
            die("DEBUG GAGAL INSERT: id_pengguna=$id_pengguna | cart=" . json_encode($cart));
        }
        // ----------------------

        if ($transaksiId) {
            $_SESSION['cart'] = []; // Clear cart
            $this->setFlash('success', 'Pengajuan peminjaman berhasil dibuat! Silakan hubungi petugas perpustakaan untuk konfirmasi pengambilan buku.');
            $this->redirect('index.php?c=user&a=riwayat');
        } else {
            $this->setFlash('danger', 'Terjadi kesalahan sistem saat memproses peminjaman.');
            $this->redirect('index.php?c=keranjang&a=index');
        }
    }
}
?>