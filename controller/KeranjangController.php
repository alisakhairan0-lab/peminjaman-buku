
<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Transaksi.php';

class KeranjangController extends Controller
{
    /**
     * Mengambil ID user yang sedang login.
     * ID diambil dari session user_id.
     */
    private function getUserId()
    {
        return $_SESSION['user_id']
            ?? $_SESSION['id_user']
            ?? $_SESSION['user']['id_user']
            ?? null;
    }

    /**
     * Menampilkan isi keranjang peminjaman.
     */
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        $books = [];

        if (!empty($cart)) {
            $bukuModel = new Buku();

            foreach ($cart as $bookId) {
                $buku = $bukuModel->getDetail((int) $bookId);

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

    /**
     * Menambahkan buku ke keranjang.
     */
    public function tambah()
    {
        $id = (int) (
            $_POST['id_buku']
            ?? $_GET['id']
            ?? 0
        );

        if ($id <= 0) {
            $this->setFlash('danger', 'ID Buku tidak valid.');
            $this->redirect('index.php?c=katalog&a=index');
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (in_array($id, $_SESSION['cart'])) {
            $this->setFlash(
                'warning',
                'Buku ini sudah ada di dalam keranjang peminjaman Anda.'
            );
        } else {
            $bukuModel = new Buku();
            $buku = $bukuModel->getById('id_buku', $id);

            if ($buku && (int) $buku['stok'] > 0) {
                $_SESSION['cart'][] = $id;

                $this->setFlash(
                    'success',
                    "Buku '{$buku['judul']}' berhasil ditambahkan ke keranjang!"
                );
            } else {
                $this->setFlash(
                    'danger',
                    'Maaf, stok buku ini sedang habis.'
                );
            }
        }

        $redirectUrl = $_SERVER['HTTP_REFERER']
            ?? 'index.php?c=keranjang&a=index';

        $this->redirect($redirectUrl);
    }

    /**
     * Menghapus satu buku dari keranjang.
     */
    public function hapus()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0 && isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_values(
                array_diff($_SESSION['cart'], [$id])
            );

            $this->setFlash(
                'info',
                'Buku berhasil dihapus dari keranjang.'
            );
        }

        $this->redirect('index.php?c=keranjang&a=index');
    }

    /**
     * Mengosongkan seluruh keranjang.
     */
    public function kosongkan()
    {
        $_SESSION['cart'] = [];

        $this->setFlash(
            'info',
            'Keranjang peminjaman telah dikosongkan.'
        );

        $this->redirect('index.php?c=keranjang&a=index');
    }

    /**
     * Memproses pengajuan peminjaman buku.
     */
    public function checkout()
    {
        // Memastikan hanya pengguna yang sudah login
        // yang dapat mengajukan peminjaman.
        $this->requireUser();

        $cart = $_SESSION['cart'] ?? [];

        // Memeriksa apakah keranjang kosong.
        if (empty($cart)) {
            $this->setFlash(
                'warning',
                'Keranjang Anda kosong. Pilih buku terlebih dahulu.'
            );

            $this->redirect('index.php?c=katalog&a=index');
            return;
        }

        // Mengambil ID user dari session.
        $id_user = $this->getUserId();

        if (empty($id_user)) {
            $this->setFlash(
                'danger',
                'Sesi pengguna tidak ditemukan. Silakan login kembali.'
            );

            $this->redirect('index.php?c=auth&a=login');
            return;
        }

        // Memastikan ID buku berbentuk angka dan tidak duplikat.
        $cart = array_values(
            array_unique(
                array_map('intval', $cart)
            )
        );

        // Memastikan keranjang masih berisi buku yang valid.
        $cart = array_filter($cart, function ($id) {
            return $id > 0;
        });

        if (empty($cart)) {
            $this->setFlash(
                'warning',
                'Tidak ada buku valid di dalam keranjang.'
            );

            $this->redirect('index.php?c=keranjang&a=index');
            return;
        }

        // Membuat objek model transaksi.
        $transaksiModel = new Transaksi();

        // Membuat pengajuan peminjaman menggunakan id_user.
        $transaksiId = $transaksiModel->createPengajuan(
            $id_user,
            array_values($cart)
        );

        // Jika pengajuan berhasil.
        if ($transaksiId) {
            $_SESSION['cart'] = [];

            $this->setFlash(
                'success',
                'Pengajuan peminjaman berhasil dibuat! Silakan tunggu konfirmasi dari petugas perpustakaan.'
            );

            $this->redirect('index.php?c=user&a=riwayat');
            return;
        }

        // Jika pengajuan gagal.
        $this->setFlash(
            'danger',
            'Terjadi kesalahan sistem saat memproses peminjaman. Silakan coba kembali.'
        );

        $this->redirect('index.php?c=keranjang&a=index');
    }
}

?>
