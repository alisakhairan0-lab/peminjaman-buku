
<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../config/Database.php';

class UserController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * MENGAMBIL ID USER YANG SEDANG LOGIN
     * Sekarang menggunakan id_user dari session.
     */
    private function resolveUserId() {

        return isset($_SESSION['user_id'])
            ? (int) $_SESSION['user_id']
            : null;
    }


    /**
     * DASHBOARD SISWA
     */
    public function dashboard() {

        $this->requireUser();

        $userId = $this->resolveUserId();

        if (!$userId) {
            $this->redirect('index.php?c=auth&a=login');
        }

        $transaksiModel = new Transaksi();
        $bukuModel = new Buku();

        // Mengambil transaksi milik siswa yang login.
        $myTransactions = $transaksiModel->getByUser($userId);

        // Transaksi yang menunggu persetujuan admin.
        $pending = array_filter(
            $myTransactions,
            function ($t) {
                return ($t['status'] ?? '') === 'menunggu';
            }
        );

        // Transaksi yang masih dalam proses peminjaman.
        $borrowed = array_filter(
            $myTransactions,
            function ($t) {
                return in_array(
                    $t['status'] ?? '',
                    ['dipinjam', 'menunggu_kembali'],
                    true
                );
            }
        );

        // Transaksi yang sudah selesai.
        $returned = array_filter(
            $myTransactions,
            function ($t) {
                return ($t['status'] ?? '') === 'dikembalikan';
            }
        );

        // Gabungan transaksi aktif dan menunggu.
        $activeLoans = array_merge(
            $pending,
            $borrowed
        );

        // Menghitung total denda.
        $totalDenda = array_reduce(
            $myTransactions,
            function ($acc, $t) {
                return $acc + (float) ($t['total_denda'] ?? 0);
            },
            0
        );

        // Mengambil empat rekomendasi buku.
        $recommendedBooks = array_slice(
            $bukuModel->getAllWithDetails(),
            0,
            4
        );

        $data = [
            'pageTitle' => 'Dashboard Siswa - ' .
                ($_SESSION['nama'] ?? 'Siswa'),

            'totalPending' => count($pending),

            'totalActive' => count($borrowed),

            'totalReturned' => count($returned),

            'activeLoans' => $activeLoans,

            'myTransactions' => $myTransactions,

            'totalDenda' => $totalDenda,

            'recommendedBooks' => $recommendedBooks
        ];

        $this->view(
            'user/dashboard',
            $data
        );
    }


    /**
     * RIWAYAT PEMINJAMAN SISWA
     */
    public function riwayat() {

        $this->requireUser();

        $userId = $this->resolveUserId();

        if (!$userId) {
            $this->redirect('index.php?c=auth&a=login');
        }

        $transaksiModel = new Transaksi();

        // Mengambil transaksi berdasarkan id_user.
        $myTransactions = $transaksiModel->getByUser($userId);

        $data = [
            'pageTitle' => 'Riwayat Peminjaman - ' .
                ($_SESSION['nama'] ?? 'Siswa'),

            'myTransactions' => $myTransactions
        ];

        $this->view(
            'user/riwayat',
            $data
        );
    }


    /**
     * MENGAJUKAN PENGEMBALIAN BUKU
     */
    public function ajukanKembali() {

        $this->requireUser();

        $userId = $this->resolveUserId();

        if (!$userId) {
            $this->redirect('index.php?c=auth&a=login');
        }

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            $this->setFlash(
                'danger',
                'ID transaksi tidak valid.'
            );

            $this->redirect(
                'index.php?c=user&a=riwayat'
            );
        }

        $transaksiModel = new Transaksi();

        // Model akan memeriksa apakah transaksi
        // benar-benar milik siswa tersebut.
        $success = $transaksiModel->ajukanPengembalianSiswa(
            $id,
            $userId
        );

        if ($success) {

            $this->setFlash(
                'success',
                'Permintaan pengembalian buku berhasil diajukan ke petugas perpustakaan.'
            );

        } else {

            $this->setFlash(
                'danger',
                'Gagal mengajukan pengembalian buku. Periksa status transaksi.'
            );
        }

        $this->redirect(
            'index.php?c=user&a=riwayat'
        );
    }


    /**
     * MENGAKTIFKAN / MENONAKTIFKAN SISWA
     * Fungsi ini hanya dapat diakses admin.
     */
    public function toggleStatus() {

        $this->requireAdmin();

        $idUser = (int) ($_GET['id'] ?? 0);

        if ($idUser <= 0) {

            $this->setFlash(
                'danger',
                'ID siswa tidak valid.'
            );

            $this->redirect(
                'index.php?c=admin&a=siswa'
            );
        }

        // Mengambil siswa dari tabel user.
        $user = $this->userModel->getById(
            'id_user',
            $idUser
        );

        if (!$user || $user['role'] !== 'pengguna') {

            $this->setFlash(
                'danger',
                'Data siswa tidak ditemukan.'
            );

            $this->redirect(
                'index.php?c=admin&a=siswa'
            );
        }

        $statusSekarang = $user['status'];

        if ($statusSekarang === 'Aktif') {

            /**
             * Periksa transaksi yang belum selesai.
             * Siswa tidak boleh dinonaktifkan jika
             * masih memiliki pinjaman atau pengajuan.
             */

            $db = Database::getInstance()->getConnection();

            $sql = "SELECT COUNT(*)
                    FROM transaksi
                    WHERE id_user = :id_user
                    AND status IN (
                        'menunggu',
                        'dipinjam',
                        'menunggu_kembali'
                    )";

            $stmt = $db->prepare($sql);

            $stmt->execute([
                ':id_user' => $idUser
            ]);

            $jumlahTanggungan = (int) $stmt->fetchColumn();

            if ($jumlahTanggungan > 0) {

                $this->setFlash(
                    'danger',
                    "Gagal menonaktifkan! Siswa '{$user['nama_lengkap']}' masih memiliki {$jumlahTanggungan} transaksi yang belum selesai."
                );

                $this->redirect(
                    'index.php?c=admin&a=siswa'
                );
            }

            $statusBaru = 'Non-Aktif';

        } else {

            $statusBaru = 'Aktif';
        }

        // Memperbarui status pada tabel user.
        $berhasil = $this->userModel->updateStatus(
            $idUser,
            $statusBaru
        );

        if ($berhasil) {

            $this->setFlash(
                'success',
                "Status siswa '{$user['nama_lengkap']}' berhasil diubah menjadi {$statusBaru}."
            );

        } else {

            $this->setFlash(
                'danger',
                'Gagal mengubah status siswa.'
            );
        }

        $this->redirect(
            'index.php?c=admin&a=siswa'
        );
    }
}

?>
