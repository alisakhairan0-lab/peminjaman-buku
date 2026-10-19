<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Pengguna.php';

class AnggotaController extends Controller {
    public function index() {
        $this->requireAdmin();

        $penggunaModel = new Pengguna();
        $search = trim($_GET['q'] ?? '');

        if (!empty($search)) {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM pengguna WHERE nama_lengkap LIKE :s OR nis LIKE :s OR username LIKE :s ORDER BY id_pengguna DESC");
            $stmt->execute([':s' => "%{$search}%"]);
            $anggota = $stmt->fetchAll();
        } else {
            $anggota = $penggunaModel->getAll();
        }

        $data = [
            'pageTitle' => 'Kelola Anggota Perpustakaan (Siswa)',
            'anggota' => $anggota,
            'search' => $search
        ];

        $this->view('admin/anggota/index', $data);
    }

    public function tambah() {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis = trim($_POST['nis'] ?? '');
            $nama = trim($_POST['nama_lengkap'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($nis) || empty($nama) || empty($username) || empty($password)) {
                $this->setFlash('danger', 'Semua kolom wajib diisi.');
            } else {
                $penggunaModel = new Pengguna();
                if ($penggunaModel->findByUsername($username)) {
                    $this->setFlash('danger', 'Username sudah terpakai!');
                } elseif ($penggunaModel->findByNis($nis)) {
                    $this->setFlash('danger', 'NIS sudah terdaftar!');
                } else {
                    $penggunaModel->register([
                        'nis' => $nis,
                        'nama_lengkap' => $nama,
                        'username' => $username,
                        'password' => $password
                    ]);
                    $this->setFlash('success', 'Anggota siswa baru berhasil didaftarkan!');
                    $this->redirect('index.php?c=anggota&a=index');
                }
            }
        }

        $this->view('admin/anggota/tambah', ['pageTitle' => 'Tambah Anggota Siswa']);
    }

    public function edit() {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $penggunaModel = new Pengguna();
        $user = $penggunaModel->getById('id_pengguna', $id);

        if (!$user) {
            $this->setFlash('danger', 'Anggota tidak ditemukan.');
            $this->redirect('index.php?c=anggota&a=index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis = trim($_POST['nis'] ?? '');
            $nama = trim($_POST['nama_lengkap'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $penggunaModel->updateProfile($id, $nama, $nis, !empty($password) ? $password : null);
            $this->setFlash('success', 'Data anggota berhasil diperbarui!');
            $this->redirect('index.php?c=anggota&a=index');
        }

        $this->view('admin/anggota/edit', [
            'pageTitle' => 'Edit Anggota: ' . $user['nama_lengkap'],
            'user' => $user
        ]);
    }

    public function hapus() {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $penggunaModel = new Pengguna();

        // Panggil fungsi pindah ke alumni & validasi tanggungan buku
        $result = $penggunaModel->pindahkanKeAlumni($id);

        if ($result['status']) {
            $this->setFlash('success', $result['pesan']);
        } else {
            $this->setFlash('danger', $result['pesan']);
        }

        $this->redirect('index.php?c=anggota&a=index');
    }

    public function toggleStatus() {
        $this->requireAdmin();

        $id_pengguna = (int)($_GET['id'] ?? 0);
        $penggunaModel = new Pengguna();
        $user = $penggunaModel->getById('id_pengguna', $id_pengguna);

        if (!$user) {
            $this->setFlash('danger', 'Data siswa tidak ditemukan.');
            $this->redirect('index.php?c=anggota&a=index');
            return;
        }

        $statusSekarang = $user['status'] ?? 'Aktif';

        if ($statusSekarang === 'Aktif') {
            $jumlahTanggungan = $penggunaModel->cekPinjamanAktif($id_pengguna);

            if ($jumlahTanggungan > 0) {
                $this->setFlash('danger', "Gagal menonaktifkan! Siswa '{$user['nama_lengkap']}' masih memiliki {$jumlahTanggungan} buku yang belum dikembalikan.");
                $this->redirect('index.php?c=anggota&a=index');
                return;
            }

            $penggunaModel->updateStatus($id_pengguna, 'Non-Aktif');
            $this->setFlash('success', "Status siswa '{$user['nama_lengkap']}' berhasil diubah menjadi Non-Aktif.");
        } else {
            $penggunaModel->updateStatus($id_pengguna, 'Aktif');
            $this->setFlash('success', "Status siswa '{$user['nama_lengkap']}' berhasil diaktifkan kembali.");
        }

        $this->redirect('index.php?c=anggota&a=index');
    }
}
?>