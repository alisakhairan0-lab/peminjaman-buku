<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Pengguna.php';
require_once __DIR__ . '/../model/Admin.php';

class AuthController extends Controller {
    public function login() {
        if ($this->isAuth()) {
            $this->redirect($_SESSION['user_type'] === 'admin' ? 'index.php?c=admin&a=dashboard' : 'index.php?c=user&a=dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // 1. Cek kredensial Administrator / Petugas Perpustakaan
            $adminModel = new Admin();
            $admin = $adminModel->findByUsername($username);
            if ($admin && $adminModel->verifyPassword($password, $admin['password'])) {
                // SESSION ID ADMIN DISIMPAN DI SINI UNTUK PENCATATAN PETUGAS PEMINJAMAN
                $_SESSION['user_id']   = $admin['id_admin']; 
                $_SESSION['user_type'] = 'admin';
                $_SESSION['nama']      = $admin['nama_admin'];
                $_SESSION['username']  = $admin['username'];

                $this->setFlash('success', "Selamat datang, {$admin['nama_admin']} (Petugas Perpustakaan)!");
                $this->redirect('index.php?c=admin&a=dashboard');
            }

            // 2. Cek kredensial Siswa / Anggota
            $penggunaModel = new Pengguna();
            $user = $penggunaModel->findByUsername($username);
            // Fallback juga cek via NIS
            if (!$user) {
                $user = $penggunaModel->findByNis($username);
            }

            if ($user && $penggunaModel->verifyPassword($password, $user['password'])) {
                $_SESSION['user_id']   = $user['id_pengguna'];
                $_SESSION['user_type'] = 'user';
                $_SESSION['nama']      = $user['nama_lengkap'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['nis']       = $user['nis'];

                $this->setFlash('success', "Selamat datang kembali, {$user['nama_lengkap']}!");
                $this->redirect('index.php?c=user&a=dashboard');
            }

            $this->setFlash('danger', 'Username / NIS atau password yang Anda masukkan tidak sesuai.');
        }

        $this->view('auth/login', ['pageTitle' => 'Login Perpustakaan']);
    }

    public function loginAdmin() {
        // Redirect ke form login tunggal terpadu
        $this->redirect('index.php?c=auth&a=login');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis      = trim($_POST['nis'] ?? '');
            $nama     = trim($_POST['nama_lengkap'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($nis) || empty($nama) || empty($username) || empty($password)) {
                $this->setFlash('danger', 'Semua kolom pendaftaran wajib diisi!');
            } else {
                $penggunaModel = new Pengguna();
                if ($penggunaModel->findByUsername($username)) {
                    $this->setFlash('danger', 'Username sudah digunakan, silakan pilih yang lain.');
                } elseif ($penggunaModel->findByNis($nis)) {
                    $this->setFlash('danger', 'NIS sudah terdaftar!');
                } else {
                    $success = $penggunaModel->register([
                        'nis'          => $nis,
                        'nama_lengkap' => $nama,
                        'username'     => $username,
                        'password'     => $password
                    ]);

                    if ($success) {
                        $this->setFlash('success', 'Registrasi anggota berhasil! Silakan login.');
                        $this->redirect('index.php?c=auth&a=login');
                    } else {
                        $this->setFlash('danger', 'Gagal mendaftar. Silakan coba lagi.');
                    }
                }
            }
        }

        $this->view('auth/register', ['pageTitle' => 'Daftar Anggota Baru']);
    }

    public function profile() {
        if (!$this->isAuth()) {
            $this->redirect('index.php?c=auth&a=login');
        }

        $userType = $_SESSION['user_type'];
        $userId   = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama     = trim($_POST['nama'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($userType === 'admin') {
                $adminModel = new Admin();
                $adminModel->updateProfile($userId, $nama, !empty($password) ? $password : null);
                $_SESSION['nama'] = $nama;
                $this->setFlash('success', 'Profil Administrator berhasil diperbarui!');
            } else {
                $nis = trim($_POST['nis'] ?? '');
                $penggunaModel = new Pengguna();
                $penggunaModel->updateProfile($userId, $nama, $nis, !empty($password) ? $password : null);
                $_SESSION['nama'] = $nama;
                $_SESSION['nis']  = $nis;
                $this->setFlash('success', 'Profil Siswa berhasil diperbarui!');
            }
            $this->redirect('index.php?c=auth&a=profile');
        }

        $userData = null;
        if ($userType === 'admin') {
            $adminModel = new Admin();
            $userData   = $adminModel->getById('id_admin', $userId);
        } else {
            $penggunaModel = new Pengguna();
            $userData      = $penggunaModel->getById('id_pengguna', $userId);
        }

        $this->view('auth/profile', [
            'pageTitle' => 'Profil Saya',
            'user'      => $userData,
            'userType'  => $userType
        ]);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kosongkan semua variabel session
        $_SESSION = array();

        // Hapus cookie session jika ada
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Hancurkan session sepenuhnya
        session_destroy();

        // Kirim header anti-cache agar browser dilarang menyimpan riwayat halaman
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: 0");

        $this->setFlash('info', 'Anda telah berhasil logout.');
        $this->redirect('index.php?c=landing&a=index');
        exit;
    }
}
?>