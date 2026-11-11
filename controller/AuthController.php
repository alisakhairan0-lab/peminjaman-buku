
<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/User.php';

class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * LOGIN ADMIN DAN SISWA
     */
    public function login() {

        // Jika sudah login, arahkan sesuai role.
        if ($this->isAuth()) {

            if ($_SESSION['user_type'] === 'admin') {
                $this->redirect('index.php?c=admin&a=dashboard');
            }

            $this->redirect('index.php?c=user&a=dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($username === '' || $password === '') {

                $this->setFlash(
                    'danger',
                    'Username dan password wajib diisi.'
                );

            } else {

                // Login menggunakan tabel user.
                $user = $this->userModel->login(
                    $username,
                    $password
                );

                if ($user) {

                    // Regenerasi session untuk keamanan.
                    session_regenerate_id(true);

                    // Menyimpan identitas pengguna ke session.
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['user_type'] = $user['role'];
                    $_SESSION['nama'] = $user['nama_lengkap'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['nis'] = $user['nis'] ?? null;

                    // Arahkan berdasarkan role.
                    if ($user['role'] === 'admin') {

                        $this->setFlash(
                            'success',
                            "Selamat datang, {$user['nama_lengkap']} (Administrator)!"
                        );

                        $this->redirect(
                            'index.php?c=admin&a=dashboard'
                        );

                    } elseif ($user['role'] === 'pengguna') {

                        $this->setFlash(
                            'success',
                            "Selamat datang kembali, {$user['nama_lengkap']}!"
                        );

                        $this->redirect(
                            'index.php?c=user&a=dashboard'
                        );

                    } else {

                        // Role tidak dikenal.
                        $_SESSION = [];

                        $this->setFlash(
                            'danger',
                            'Role akun tidak dikenali.'
                        );

                        $this->redirect(
                            'index.php?c=auth&a=login'
                        );
                    }

                } else {

                    $this->setFlash(
                        'danger',
                        'Username atau password salah, atau akun tidak aktif.'
                    );
                }
            }
        }

        $this->view(
            'auth/login',
            [
                'pageTitle' => 'Login Perpustakaan'
            ]
        );
    }


    /**
     * LOGIN ADMIN
     * Menggunakan halaman login yang sama.
     */
    public function loginAdmin() {

        $this->redirect(
            'index.php?c=auth&a=login'
        );
    }


    /**
     * REGISTRASI SISWA
     */
    public function register() {

        // Pengguna yang sudah login tidak perlu registrasi lagi.
        if ($this->isAuth()) {

            if ($_SESSION['user_type'] === 'admin') {
                $this->redirect('index.php?c=admin&a=dashboard');
            }

            $this->redirect('index.php?c=user&a=dashboard');
        }

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
                    'Semua kolom pendaftaran wajib diisi!'
                );

            } elseif ($this->userModel->isUsernameExist($username)) {

                $this->setFlash(
                    'danger',
                    'Username sudah digunakan. Silakan pilih username lain.'
                );

            } elseif ($this->userModel->isNisExist($nis)) {

                $this->setFlash(
                    'danger',
                    'NIS sudah terdaftar.'
                );

            } else {

                // Akun registrasi selalu memiliki role pengguna.
                $success = $this->userModel->create([
                    'nis' => $nis,
                    'nama_lengkap' => $nama,
                    'username' => $username,
                    'password' => $password,
                    'role' => 'pengguna',
                    'status' => 'Aktif'
                ]);

                if ($success) {

                    $this->setFlash(
                        'success',
                        'Registrasi berhasil! Silakan login menggunakan akun kamu.'
                    );

                    $this->redirect(
                        'index.php?c=auth&a=login'
                    );

                } else {

                    $this->setFlash(
                        'danger',
                        'Registrasi gagal. Periksa kembali data yang dimasukkan.'
                    );
                }
            }
        }

        $this->view(
            'auth/register',
            [
                'pageTitle' => 'Daftar Anggota Baru'
            ]
        );
    }


    /**
     * PROFIL ADMIN DAN SISWA
     */
    public function profile() {

        if (!$this->isAuth()) {

            $this->setFlash(
                'danger',
                'Silakan login terlebih dahulu.'
            );

            $this->redirect(
                'index.php?c=auth&a=login'
            );
        }

        $userId = (int) $_SESSION['user_id'];
        $userType = $_SESSION['user_type'];

        // Ambil data user dari tabel user.
        $userData = $this->userModel->getById(
            'id_user',
            $userId
        );

        if (!$userData) {

            $this->setFlash(
                'danger',
                'Data akun tidak ditemukan.'
            );

            $this->redirect(
                'index.php?c=auth&a=logout'
            );
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nama = trim($_POST['nama'] ?? '');
            $nis = trim($_POST['nis'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($nama === '') {

                $this->setFlash(
                    'danger',
                    'Nama lengkap tidak boleh kosong.'
                );

            } else {

                // Pertahankan username, role, dan status lama.
                $updateData = [
                    'nama_lengkap' => $nama,
                    'username' => $userData['username'],
                    'nis' => $nis,
                    'role' => $userData['role'],
                    'status' => $userData['status']
                ];

                // Password hanya diganti jika diisi.
                if ($password !== '') {
                    $updateData['password'] = $password;
                }

                $success = $this->userModel->update(
                    $userId,
                    $updateData
                );

                if ($success) {

                    // Perbarui session setelah perubahan berhasil.
                    $_SESSION['nama'] = $nama;
                    $_SESSION['nis'] = $nis;

                    $this->setFlash(
                        'success',
                        'Profil berhasil diperbarui!'
                    );

                    $this->redirect(
                        'index.php?c=auth&a=profile'
                    );

                } else {

                    $this->setFlash(
                        'danger',
                        'Gagal memperbarui profil. Periksa kembali data kamu.'
                    );
                }
            }

            // Ambil ulang data setelah proses update.
            $userData = $this->userModel->getById(
                'id_user',
                $userId
            );
        }

        $this->view(
            'auth/profile',
            [
                'pageTitle' => 'Profil Saya',
                'user' => $userData,
                'userType' => $userType
            ]
        );
    }


    /**
     * LOGOUT
     */
    public function logout() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kosongkan seluruh data session.
        $_SESSION = [];

        // Hapus cookie session.
        if (ini_get('session.use_cookies')) {

            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Hancurkan session lama.
        session_destroy();

        // Buat session baru agar pesan logout bisa ditampilkan.
        session_start();

        $this->setFlash(
            'info',
            'Kamu berhasil logout.'
        );

        $this->redirect(
            'index.php?c=landing&a=index'
        );
    }
}

?>
