<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/DetailTransaksi.php';

class TransaksiController extends Controller {
    public function index() {
        $this->requireAdmin();

        $transaksiModel = new Transaksi();
        $status = $_GET['status'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $search = trim($_GET['q'] ?? '');

        $transaksiList = $transaksiModel->getAllTransactions($status, $startDate, $endDate, $search);

        $data = [
            'pageTitle' => 'Kelola Transaksi Peminjaman Buku',
            'transaksiList' => $transaksiList,
            'selectedStatus' => $status,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'search' => $search
        ];

        $this->view('admin/transaksi/index', $data);
    }

    public function detail() {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $transaksiModel = new Transaksi();
        $transaksi = $transaksiModel->getById('id_transaksi', $id);

        if (!$transaksi) {
            $this->setFlash('danger', 'Transaksi tidak ditemukan.');
            $this->redirect('index.php?c=transaksi&a=index');
        }

        $detailModel = new DetailTransaksi();
        $detailBuku = $detailModel->getByTransaksi($id);

        $db = Database::getInstance()->getConnection();
        $stmtP = $db->prepare("SELECT * FROM pengguna WHERE id_pengguna = :id");
        $stmtP->execute([':id' => $transaksi['id_pengguna']]);
        $pengguna = $stmtP->fetch();

        $data = [
            'pageTitle' => 'Detail Transaksi #' . $transaksi['id_transaksi'],
            'transaksi' => $transaksi,
            'detailBuku' => $detailBuku,
            'pengguna' => $pengguna
        ];

        $this->view('admin/transaksi/detail', $data);
    }

    public function approve() {
        $this->requireAdmin();

        $id = (int)($_POST['id_transaksi'] ?? $_GET['id'] ?? 0);
        $tgl_pinjam = $_POST['tgl_pinjam'] ?? date('Y-m-d');
        $durasi = (int)($_POST['durasi_hari'] ?? 7);
        $batas_kembali = date('Y-m-d', strtotime("+$durasi days", strtotime($tgl_pinjam)));
        
        $id_admin = $_SESSION['user_id'] ?? null;

        $transaksiModel = new Transaksi();
        $success = $transaksiModel->approvePinjam($id, $id_admin, $tgl_pinjam, $batas_kembali);

        if ($success) {
            $this->setFlash('success', "Transaksi #{$id} disetujui! Batas pengembalian: " . date('d M Y', strtotime($batas_kembali)));
        } else {
            $this->setFlash('danger', 'Gagal memproses persetujuan transaksi.');
        }

        $this->redirect('index.php?c=transaksi&a=index');
    }

    public function reject() {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $id_admin = $_SESSION['user_id'] ?? null;

        $transaksiModel = new Transaksi();
        $transaksiModel->tolakPengajuan($id, $id_admin);

        $this->setFlash('info', "Transaksi #{$id} telah ditolak.");
        $this->redirect('index.php?c=transaksi&a=index');
    }

    public function kembalikan() {
        $this->requireAdmin();

        $id = (int)($_POST['id_transaksi'] ?? 0);
        $tgl_kembali = $_POST['tgl_kembali'] ?? date('Y-m-d');
        $id_admin = $_SESSION['user_id'] ?? null;
        
        $transaksiModel = new Transaksi();
        $transaksi = $transaksiModel->getById('id_transaksi', $id);

        if (!$transaksi) {
            $this->setFlash('danger', 'Transaksi tidak ditemukan.');
            $this->redirect('index.php?c=transaksi&a=index');
            return;
        }

        // PERBAIKAN: Izinkan konfirmasi jika statusnya 'dipinjam' ATAU 'menunggu_kembali'
        $statusDb = trim($transaksi['status'] ?? 'dipinjam');
        if ($statusDb !== 'dipinjam' && $statusDb !== 'menunggu_kembali' && $statusDb !== '') {
            $this->setFlash('danger', 'Gagal! Transaksi ini sudah selesai atau dibatalkan.');
            $this->redirect('index.php?c=transaksi&a=detail&id=' . $id);
            return;
        }

        // Calculate late fine
        $dendaPerHari = 1000;
        $totalDenda = 0;

        if (!empty($transaksi['batas_kembali'])) {
            $batas = strtotime($transaksi['batas_kembali']);
            $kembali = strtotime($tgl_kembali);

            if ($kembali > $batas) {
                $selisihHari = ceil(($kembali - $batas) / (60 * 60 * 24));
                $detailModel = new DetailTransaksi();
                $bukuList = $detailModel->getByTransaksi($id);
                $jumlahBuku = count($bukuList);
                $totalDenda = $selisihHari * $dendaPerHari * ($jumlahBuku > 0 ? $jumlahBuku : 1);
            }
        }

        if (isset($_POST['total_denda']) && is_numeric($_POST['total_denda'])) {
            $totalDenda = (int)$_POST['total_denda'];
        }

        $transaksiModel->prosesKembali($id, $tgl_kembali, $totalDenda, $id_admin);
        $this->setFlash('success', "Buku pada Transaksi #{$id} berhasil dikembalikan! Denda keterlambatan: Rp " . number_format($totalDenda, 0, ',', '.'));
        $this->redirect('index.php?c=transaksi&a=index');
    }

    public function riwayatUser() {
        $this->requireUser();

        $id_pengguna = $_SESSION['user_id'];
        $transaksiModel = new Transaksi();
        $transaksiList = $transaksiModel->getByUser($id_pengguna);

        $data = [
            'pageTitle' => 'Riwayat & Status Peminjaman Saya',
            'riwayat' => $transaksiList
        ];

        $this->view('user/riwayat', $data);
    }
}
?>