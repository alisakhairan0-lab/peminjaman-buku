
<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/DetailTransaksi.php';
require_once __DIR__ . '/../config/Database.php';

class TransaksiController extends Controller {

    /**
     * MENAMPILKAN SELURUH TRANSAKSI
     * Khusus administrator.
     */
    public function index() {

        $this->requireAdmin();

        $transaksiModel = new Transaksi();

        $status = $_GET['status'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $search = trim($_GET['q'] ?? '');

        $transaksiList = $transaksiModel->getAllTransactions(
            $status,
            $startDate,
            $endDate,
            $search
        );

        $data = [
            'pageTitle' => 'Kelola Transaksi Peminjaman Buku',
            'transaksiList' => $transaksiList,
            'selectedStatus' => $status,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'search' => $search
        ];

        $this->view(
            'admin/transaksi/index',
            $data
        );
    }


    /**
     * MENAMPILKAN DETAIL TRANSAKSI
     * Data siswa diambil dari tabel user.
     */
    public function detail() {

        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            $this->setFlash(
                'danger',
                'ID transaksi tidak valid.'
            );

            $this->redirect(
                'index.php?c=transaksi&a=index'
            );
        }

        $transaksiModel = new Transaksi();

        $transaksi = $transaksiModel->getById(
            'id_transaksi',
            $id
        );

        if (!$transaksi) {

            $this->setFlash(
                'danger',
                'Transaksi tidak ditemukan.'
            );

            $this->redirect(
                'index.php?c=transaksi&a=index'
            );
        }

        // Mengambil detail buku dalam transaksi.
        $detailModel = new DetailTransaksi();

        $detailBuku = $detailModel->getByTransaksi($id);

        // Mengambil data siswa dari tabel user.
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare(
            "SELECT *
             FROM `user`
             WHERE id_user = :id
             AND role = 'pengguna'
             LIMIT 1"
        );

        $stmt->execute([
            ':id' => $transaksi['id_user']
        ]);

        $pengguna = $stmt->fetch();

        // Mengambil data admin yang memproses transaksi.
        $admin = null;

        if (!empty($transaksi['id_admin'])) {

            $stmtAdmin = $db->prepare(
                "SELECT *
                 FROM `user`
                 WHERE id_user = :id
                 AND role = 'admin'
                 LIMIT 1"
            );

            $stmtAdmin->execute([
                ':id' => $transaksi['id_admin']
            ]);

            $admin = $stmtAdmin->fetch();
        }

        $data = [
            'pageTitle' => 'Detail Transaksi #' .
                $transaksi['id_transaksi'],

            'transaksi' => $transaksi,

            'detailBuku' => $detailBuku,

            // Nama variabel tetap dipertahankan
            // agar sesuai dengan view lama.
            'pengguna' => $pengguna,

            'admin' => $admin
        ];

        $this->view(
            'admin/transaksi/detail',
            $data
        );
    }


    /**
     * MENYETUJUI PENGAJUAN PEMINJAMAN
     */
    public function approve() {

        $this->requireAdmin();

        $id = (int) (
            $_POST['id_transaksi'] ??
            $_GET['id'] ??
            0
        );

        if ($id <= 0) {

            $this->setFlash(
                'danger',
                'ID transaksi tidak valid.'
            );

            $this->redirect(
                'index.php?c=transaksi&a=index'
            );
        }

        $tgl_pinjam = $_POST['tgl_pinjam'] ?? date('Y-m-d');

        $durasi = (int) ($_POST['durasi_hari'] ?? 7);

        if ($durasi <= 0) {
            $durasi = 7;
        }

        $batas_kembali = date(
            'Y-m-d',
            strtotime("+{$durasi} days", strtotime($tgl_pinjam))
        );

        // ID admin berasal dari tabel user.
        $id_admin = $_SESSION['user_id'] ?? null;

        $transaksiModel = new Transaksi();

        $success = $transaksiModel->approvePinjam(
            $id,
            $id_admin,
            $tgl_pinjam,
            $batas_kembali
        );

        if ($success) {

            $this->setFlash(
                'success',
                "Transaksi #{$id} berhasil disetujui! Batas pengembalian: " .
                date('d M Y', strtotime($batas_kembali))
            );

        } else {

            $this->setFlash(
                'danger',
                'Gagal memproses persetujuan transaksi.'
            );
        }

        $this->redirect(
            'index.php?c=transaksi&a=index'
        );
    }


    /**
     * MENOLAK PENGAJUAN PEMINJAMAN
     */
    public function reject() {

        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            $this->setFlash(
                'danger',
                'ID transaksi tidak valid.'
            );

            $this->redirect(
                'index.php?c=transaksi&a=index'
            );
        }

        $id_admin = $_SESSION['user_id'] ?? null;

        $transaksiModel = new Transaksi();

        $success = $transaksiModel->tolakPengajuan(
            $id,
            $id_admin
        );

        if ($success) {

            $this->setFlash(
                'info',
                "Transaksi #{$id} berhasil ditolak."
            );

        } else {

            $this->setFlash(
                'danger',
                'Gagal menolak pengajuan transaksi.'
            );
        }

        $this->redirect(
            'index.php?c=transaksi&a=index'
        );
    }


    /**
     * MENGONFIRMASI PENGEMBALIAN BUKU
     */
    public function kembalikan() {

        $this->requireAdmin();

        $id = (int) ($_POST['id_transaksi'] ?? 0);

        $tgl_kembali = $_POST['tgl_kembali'] ?? date('Y-m-d');

        $id_admin = $_SESSION['user_id'] ?? null;

        if ($id <= 0) {

            $this->setFlash(
                'danger',
                'ID transaksi tidak valid.'
            );

            $this->redirect(
                'index.php?c=transaksi&a=index'
            );
        }

        $transaksiModel = new Transaksi();

        $transaksi = $transaksiModel->getById(
            'id_transaksi',
            $id
        );

        if (!$transaksi) {

            $this->setFlash(
                'danger',
                'Transaksi tidak ditemukan.'
            );

            $this->redirect(
                'index.php?c=transaksi&a=index'
            );
        }

        // Pengembalian hanya dapat dikonfirmasi
        // jika buku sedang dipinjam atau menunggu kembali.
        $statusDb = trim($transaksi['status'] ?? '');

        if (
            $statusDb !== 'dipinjam' &&
            $statusDb !== 'menunggu_kembali'
        ) {

            $this->setFlash(
                'danger',
                'Transaksi ini sudah selesai atau tidak dapat dikembalikan.'
            );

            $this->redirect(
                'index.php?c=transaksi&a=detail&id=' . $id
            );
        }

        /**
         * PERHITUNGAN DENDA
         * Denda Rp1.000 per hari keterlambatan
         * untuk setiap buku.
         */

        $dendaPerHari = 1000;

        $totalDenda = 0;

        if (!empty($transaksi['batas_kembali'])) {

            $batas = strtotime(
                $transaksi['batas_kembali']
            );

            $kembali = strtotime($tgl_kembali);

            if ($kembali > $batas) {

                $selisihHari = (int) ceil(
                    ($kembali - $batas) / 86400
                );

                $detailModel = new DetailTransaksi();

                $bukuList = $detailModel->getByTransaksi($id);

                $jumlahBuku = count($bukuList);

                $totalDenda =
                    $selisihHari *
                    $dendaPerHari *
                    ($jumlahBuku > 0 ? $jumlahBuku : 1);
            }
        }

        // Jika admin memasukkan denda manual,
        // gunakan nilai tersebut.
        if (
            isset($_POST['total_denda']) &&
            is_numeric($_POST['total_denda'])
        ) {

            $totalDenda = (int) $_POST['total_denda'];
        }

        $success = $transaksiModel->prosesKembali(
            $id,
            $tgl_kembali,
            $totalDenda,
            $id_admin
        );

        if ($success) {

            $this->setFlash(
                'success',
                "Buku pada transaksi #{$id} berhasil dikembalikan! Denda keterlambatan: Rp " .
                number_format($totalDenda, 0, ',', '.')
            );

        } else {

            $this->setFlash(
                'danger',
                'Gagal memproses pengembalian buku.'
            );
        }

        $this->redirect(
            'index.php?c=transaksi&a=index'
        );
    }


    /**
     * MENAMPILKAN RIWAYAT TRANSAKSI SISWA
     */
    public function riwayatUser() {

        $this->requireUser();

        // ID siswa sekarang menggunakan id_user.
        $id_user = $_SESSION['user_id'] ?? null;

        if (!$id_user) {

            $this->redirect(
                'index.php?c=auth&a=login'
            );
        }

        $transaksiModel = new Transaksi();

        $transaksiList = $transaksiModel->getByUser(
            $id_user
        );

        $data = [
            'pageTitle' => 'Riwayat & Status Peminjaman Saya',
            'riwayat' => $transaksiList
        ];

        $this->view(
            'user/riwayat',
            $data
        );
    }
}

?>
