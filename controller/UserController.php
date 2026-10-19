<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Pengguna.php';

class UserController extends Controller {
    private function resolveUserId() {
        return $_SESSION['user_id'] 
            ?? $_SESSION['id_pengguna'] 
            ?? $_SESSION['id'] 
            ?? $_SESSION['pengguna_id'] 
             ?? ($_SESSION['user']['id_pengguna'] ?? null) 
            ?? null;
    }

    public function dashboard() {
        $this->requireUser();
        $userId = $this->resolveUserId();
        
        $transaksiModel = new Transaksi();
        $bukuModel = new Buku();

        $myTransactions = $transaksiModel->getByUser($userId);
        $pending = array_filter($myTransactions, fn($t) => $t['status'] === 'menunggu');
        $borrowed = array_filter($myTransactions, fn($t) => $t['status'] === 'dipinjam' || $t['status'] === 'menunggu_kembali' || empty($t['status']));
        $returned = array_filter($myTransactions, fn($t) => $t['status'] === 'dikembalikan');

        $activeLoans = array_merge($pending, $borrowed);

        $totalDenda = array_reduce($myTransactions, function($acc, $t) {
            return $acc + (int)($t['total_denda'] ?? 0);
        }, 0);

        $recommendedBooks = array_slice($bukuModel->getAllWithDetails(), 0, 4);

        $data = [
            'pageTitle' => 'Dashboard Siswa - ' . ($_SESSION['nama'] ?? $_SESSION['user']['nama_lengkap'] ?? 'Siswa'),
            'totalPending' => count($pending),
            'totalActive' => count($borrowed),
            'totalReturned' => count($returned),
            'activeLoans' => $activeLoans,
            'myTransactions' => $myTransactions,
            'totalDenda' => $totalDenda,
            'recommendedBooks' => $recommendedBooks
        ];

        $this->view('user/dashboard', $data);
    }

    public function riwayat() {
        $this->requireUser();
        $userId = $this->resolveUserId();
        
        $transaksiModel = new Transaksi();
        $myTransactions = $transaksiModel->getByUser($userId);

        $data = [
            'pageTitle' => 'Riwayat Peminjaman - ' . ($_SESSION['nama'] ?? $_SESSION['user']['nama_lengkap'] ?? 'Siswa'),
            'myTransactions' => $myTransactions
        ];

        $this->view('user/riwayat', $data);
    }

    public function ajukanKembali() {
        $this->requireUser();
        $userId = $this->resolveUserId();
        
        $id = (int)($_GET['id'] ?? 0);
        $transaksiModel = new Transaksi();
        
        $success = $transaksiModel->ajukanPengembalianSiswa($id, $userId);

        if ($success) {
            $this->setFlash('success', 'Permintaan pengembalian buku berhasil diajukan ke petugas perpustakaan.');
        } else {
            $this->setFlash('danger', 'Gagal mengajukan pengembalian buku.');
        }

        $this->redirect('index.php?c=user&a=riwayat');
    }

    public function toggleStatus() {
        $this->requireAdmin();

        $id_pengguna = (int)($_GET['id'] ?? 0);
        $penggunaModel = new Pengguna();
        
        $user = $penggunaModel->getById('id_pengguna', $id_pengguna);

        if (!$user) {
            $this->setFlash('danger', 'Data siswa tidak ditemukan.');
            $this->redirect('index.php?c=admin&a=siswa');
            return;
        }

        $statusSekarang = $user['status'];

        if ($statusSekarang === 'Aktif') {
            $jumlahTanggungan = $penggunaModel->cekPinjamanAktif($id_pengguna);

            if ($jumlahTanggungan > 0) {
                $this->setFlash('danger', "Gagal menonaktifkan! Siswa '{$user['nama_lengkap']}' masih memiliki {$jumlahTanggungan} buku yang belum dikembalikan.");
                $this->redirect('index.php?c=admin&a=siswa');
                return;
            }

            $penggunaModel->updateStatus($id_pengguna, 'Non-Aktif');
            $this->setFlash('success', "Status siswa '{$user['nama_lengkap']}' berhasil diubah menjadi Non-Aktif.");
        } else {
            $penggunaModel->updateStatus($id_pengguna, 'Aktif');
            $this->setFlash('success', "Status siswa '{$user['nama_lengkap']}' berhasil diaktifkan kembali.");
        }

        $this->redirect('index.php?c=admin&a=siswa');
    }
}
?>