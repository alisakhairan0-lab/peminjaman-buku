<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Pengguna.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/Kategori.php';

class AdminController extends Controller {
    public function dashboard() {
        $this->requireAdmin();

        $bukuModel = new Buku();
        $penggunaModel = new Pengguna();
        $transaksiModel = new Transaksi();
        $kategoriModel = new Kategori();

        $allBooks = $bukuModel->getAll();
        $allMembers = $penggunaModel->getAll();
        $allTransactions = $transaksiModel->getAllTransactions();
        
        // Stats
        $pendingLoans = array_filter($allTransactions, function($t) { return $t['status'] === 'menunggu'; });
        $activeLoans = array_filter($allTransactions, function($t) { return $t['status'] === 'dipinjam'; });
        $returnedLoans = array_filter($allTransactions, function($t) { return $t['status'] === 'dikembalikan'; });

        // Total denda
        $totalDenda = array_reduce($allTransactions, function($acc, $t) {
            return $acc + (int)$t['total_denda'];
        }, 0);

        $todayTransactions = $transaksiModel->getTodayTransactions();

        $data = [
            'pageTitle' => 'Dashboard Administrator',
            'totalBuku' => count($allBooks),
            'totalAnggota' => count($allMembers),
            'totalPending' => count($pendingLoans),
            'totalActive' => count($activeLoans),
            'totalReturned' => count($returnedLoans),
            'totalDenda' => $totalDenda,
            'recentTransactions' => array_slice($allTransactions, 0, 5),
            'todayTransactions' => $todayTransactions
        ];

        $this->view('admin/dashboard', $data);
    }
}
?>
