
<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/Kategori.php';

class AdminController extends Controller {

    /**
     * DASHBOARD ADMINISTRATOR
     */
    public function dashboard() {

        // Memastikan hanya admin yang dapat mengakses.
        $this->requireAdmin();

        // Memanggil model.
        $bukuModel = new Buku();
        $userModel = new User();
        $transaksiModel = new Transaksi();
        $kategoriModel = new Kategori();

        // Mengambil seluruh data buku.
        $allBooks = $bukuModel->getAll();

        // Mengambil seluruh siswa dari tabel user.
        // Hanya akun dengan role pengguna.
        $allMembers = $userModel->getByRole('pengguna');

        // Mengambil seluruh transaksi peminjaman.
        $allTransactions = $transaksiModel->getAllTransactions();

        /**
         * STATISTIK TRANSAKSI
         */

        // Jumlah pengajuan yang menunggu persetujuan.
        $pendingLoans = array_filter(
            $allTransactions,
            function ($t) {
                return ($t['status'] ?? '') === 'menunggu';
            }
        );

        // Jumlah buku yang sedang dipinjam.
        $activeLoans = array_filter(
            $allTransactions,
            function ($t) {
                return ($t['status'] ?? '') === 'dipinjam';
            }
        );

        // Jumlah transaksi yang sudah dikembalikan.
        $returnedLoans = array_filter(
            $allTransactions,
            function ($t) {
                return ($t['status'] ?? '') === 'dikembalikan';
            }
        );

        /**
         * TOTAL DENDA
         */

        $totalDenda = array_reduce(
            $allTransactions,
            function ($acc, $t) {
                return $acc + (int) ($t['total_denda'] ?? 0);
            },
            0
        );

        /**
         * TRANSAKSI HARI INI
         */

        $todayTransactions = $transaksiModel->getTodayTransactions();

        /**
         * DATA YANG DIKIRIM KE VIEW
         */

        $data = [

            'pageTitle' => 'Dashboard Administrator',

            // Statistik buku dan anggota.
            'totalBuku' => count($allBooks),
            'totalAnggota' => count($allMembers),

            // Statistik transaksi.
            'totalPending' => count($pendingLoans),
            'totalActive' => count($activeLoans),
            'totalReturned' => count($returnedLoans),

            // Total denda.
            'totalDenda' => $totalDenda,

            // Lima transaksi terbaru.
            'recentTransactions' => array_slice(
                $allTransactions,
                0,
                5
            ),

            // Transaksi hari ini.
            'todayTransactions' => $todayTransactions
        ];

        // Menampilkan halaman dashboard.
        $this->view(
            'admin/dashboard',
            $data
        );
    }
}

?>
