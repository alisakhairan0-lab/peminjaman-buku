
<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/User.php';

class AnggotaController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * MENGAMBIL JUMLAH PINJAMAN YANG BELUM SELESAI
     * Untuk mencegah siswa dinonaktifkan saat masih
     * memiliki pengajuan atau pinjaman aktif.
     */
    private function cekPinjamanAktif($idUser) {

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

        return (int) $stmt->fetchColumn();
    }


    /**
     * MENAMPILKAN DAFTAR ANGGOTA
     */
    public function index() {

        $this->requireAdmin();

        $search = trim($_GET['q'] ?? '');

        // Mengambil seluruh siswa dari tabel user.
        $anggota = $this->userModel->getByRole('pengguna');

        // Fitur pencarian anggota.
        if ($search !== '') {

            $anggota = array_filter(
                $anggota,
                function ($user) use ($search) {

                    return
                        stripos($user['nama_lengkap'], $search) !== false ||
                        stripos($user['nis'] ?? '', $search) !== false ||
                        stripos($user['username'], $search) !== false;
                }
            );

            $anggota = array_values($anggota);
        }

        $data = [
            'pageTitle' => 'Kelola Anggota Perpustakaan (Siswa)',
            'anggota' => $anggota,
            'search' => $search
        ];

        $this->view(
            'admin/anggota/index',
            $data
        );
    }


    /**
     * MENAMBAHKAN ANGGOTA BARU
     */
    public function tambah() {

        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nis = trim($_POST['nis'] ?? '');
            $nama = trim($_POST['nama_lengkap'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (
                $nis === '' ||
                $nama === '' ||
                $username === '' ||
                $password === ''
            ) {

                $this->setFlash(
                    'danger',
                    'Semua kolom wajib diisi.'
                );

            } elseif ($this->userModel->isUsernameExist($username)) {

                $this->setFlash(
                    'danger',
                    'Username sudah digunakan!'
                );

            } elseif ($this->userModel->isNisExist($nis)) {

                $this->setFlash(
                    'danger',
                    'NIS sudah terdaftar!'
                );

            } else {

                // Akun siswa disimpan ke tabel user.
                $berhasil = $this->userModel->create([
                    'nis' => $nis,
                    'nama_lengkap' => $nama,
                    'username' => $username,
                    'password' => $password,
                    'role' => 'pengguna',
                    'status' => 'Aktif'
                ]);

                if ($berhasil) {

                    $this->setFlash(
                        'success',
                        'Anggota siswa baru berhasil didaftarkan!'
                    );

                    $this->redirect(
                        'index.php?c=anggota&a=index'
                    );

                } else {

                    $this->setFlash(
                        'danger',
                        'Gagal menambahkan anggota siswa.'
                    );
                }
            }
        }

        $this->view(
            'admin/anggota/tambah',
            [
                'pageTitle' => 'Tambah Anggota Siswa'
            ]
        );
    }


    /**
     * MENGEDIT DATA ANGGOTA
     */
    public function edit() {

        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            $this->setFlash(
                'danger',
                'ID anggota tidak valid.'
            );

            $this->redirect(
                'index.php?c=anggota&a=index'
            );
        }

        // Mengambil data berdasarkan id_user.
        $user = $this->userModel->getById(
            'id_user',
            $id
        );

        // Pastikan data yang diedit adalah siswa.
        if (!$user || $user['role'] !== 'pengguna') {

            $this->setFlash(
                'danger',
                'Data anggota tidak ditemukan.'
            );

            $this->redirect(
                'index.php?c=anggota&a=index'
            );
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nis = trim($_POST['nis'] ?? '');
            $nama = trim($_POST['nama_lengkap'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($nis === '' || $nama === '') {

                $this->setFlash(
                    'danger',
                    'NIS dan Nama Lengkap wajib diisi.'
                );

            } elseif ($this->userModel->isNisExist($nis, $id)) {

                $this->setFlash(
                    'danger',
                    'NIS sudah digunakan oleh anggota lain.'
                );

            } else {

                // Pertahankan username, role, dan status.
                $dataUpdate = [
                    'nis' => $nis,
                    'nama_lengkap' => $nama,
                    'username' => $user['username'],
                    'role' => 'pengguna',
                    'status' => $user['status']
                ];

                // Password hanya diubah jika diisi.
                if ($password !== '') {
                    $dataUpdate['password'] = $password;
                }

                $berhasil = $this->userModel->update(
                    $id,
                    $dataUpdate
                );

                if ($berhasil) {

                    $this->setFlash(
                        'success',
                        'Data anggota berhasil diperbarui!'
                    );

                    $this->redirect(
                        'index.php?c=anggota&a=index'
                    );

                } else {

                    $this->setFlash(
                        'danger',
                        'Gagal memperbarui data anggota.'
                    );
                }
            }

            // Ambil ulang data terbaru.
            $user = $this->userModel->getById(
                'id_user',
                $id
            );
        }

        $this->view(
            'admin/anggota/edit',
            [
                'pageTitle' => 'Edit Anggota: ' . $user['nama_lengkap'],
                'user' => $user
            ]
        );
    }


    /**
     * MENONAKTIFKAN ANGGOTA
     *
     * Data tidak dihapus secara permanen agar
     * riwayat transaksi tetap terhubung.
     */
    public function hapus() {

        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            $this->setFlash(
                'danger',
                'ID anggota tidak valid.'
            );

            $this->redirect(
                'index.php?c=anggota&a=index'
            );
        }

        $user = $this->userModel->getById(
            'id_user',
            $id
        );

        if (!$user || $user['role'] !== 'pengguna') {

            $this->setFlash(
                'danger',
                'Data anggota tidak ditemukan.'
            );

            $this->redirect(
                'index.php?c=anggota&a=index'
            );
        }

        $jumlahPinjaman = $this->cekPinjamanAktif($id);

        if ($jumlahPinjaman > 0) {

            $this->setFlash(
                'danger',
                "Anggota {$user['nama_lengkap']} masih memiliki {$jumlahPinjaman} transaksi yang belum selesai. Selesaikan transaksi terlebih dahulu."
            );

            $this->redirect(
                'index.php?c=anggota&a=index'
            );
        }

        $berhasil = $this->userModel->updateStatus(
            $id,
            'Non-Aktif'
        );

        if ($berhasil) {

            $this->setFlash(
                'success',
                "Anggota {$user['nama_lengkap']} berhasil dinonaktifkan. Riwayat transaksi tetap tersimpan."
            );

        } else {

            $this->setFlash(
                'danger',
                'Gagal menonaktifkan anggota.'
            );
        }

        $this->redirect(
            'index.php?c=anggota&a=index'
        );
    }


    /**
     * MENGAKTIFKAN / MENONAKTIFKAN STATUS ANGGOTA
     */
    public function toggleStatus() {

        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $user = $this->userModel->getById(
            'id_user',
            $id
        );

        if (!$user || $user['role'] !== 'pengguna') {

            $this->setFlash(
                'danger',
                'Data siswa tidak ditemukan.'
            );

            $this->redirect(
                'index.php?c=anggota&a=index'
            );
        }

        $statusSekarang = $user['status'] ?? 'Aktif';

        if ($statusSekarang === 'Aktif') {

            // Periksa pinjaman sebelum menonaktifkan.
            $jumlahPinjaman = $this->cekPinjamanAktif($id);

            if ($jumlahPinjaman > 0) {

                $this->setFlash(
                    'danger',
                    "Gagal menonaktifkan! Siswa {$user['nama_lengkap']} masih memiliki {$jumlahPinjaman} transaksi yang belum selesai."
                );

                $this->redirect(
                    'index.php?c=anggota&a=index'
                );
            }

            $statusBaru = 'Non-Aktif';

        } else {

            $statusBaru = 'Aktif';
        }

        $berhasil = $this->userModel->updateStatus(
            $id,
            $statusBaru
        );

        if ($berhasil) {

            $this->setFlash(
                'success',
                "Status siswa {$user['nama_lengkap']} berhasil diubah menjadi {$statusBaru}."
            );

        } else {

            $this->setFlash(
                'danger',
                'Gagal mengubah status siswa.'
            );
        }

        $this->redirect(
            'index.php?c=anggota&a=index'
        );
    }
}

?>
