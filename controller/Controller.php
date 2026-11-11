
<?php
/**
 * LibraryVerse - Base Controller
 * Mengatur View, Session, Flash Message,
 * Redirect, dan Hak Akses Pengguna.
 */

abstract class Controller {

    // Menampilkan halaman
    protected function view($viewPath, $data = [], $layout = 'default') {

        extract($data);

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        if ($layout === false) {
            require __DIR__ . '/../view/' . $viewPath . '.php';
        } else {
            require __DIR__ . '/../view/templates/header.php';
            require __DIR__ . '/../view/templates/navbar.php';
            require __DIR__ . '/../view/' . $viewPath . '.php';
            require __DIR__ . '/../view/templates/footer.php';
        }
    }

    // Mengarahkan halaman
    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }

    // Menyimpan pesan notifikasi
    protected function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    // Memeriksa apakah user sudah login
    protected function isAuth() {
        return isset($_SESSION['user_id']);
    }

    // Memastikan hanya admin yang bisa mengakses
    protected function requireAdmin() {

        if (!$this->isAuth()) {
            $this->setFlash(
                'danger',
                'Silakan login terlebih dahulu.'
            );

            $this->redirect('index.php?c=auth&a=login');
        }

        if ($_SESSION['user_type'] !== 'admin') {

            $this->setFlash(
                'danger',
                'Akses ditolak! Halaman ini khusus administrator.'
            );

            $this->redirect('index.php?c=user&a=dashboard');
        }
    }

    // Memastikan hanya siswa yang bisa mengakses
    protected function requireUser() {

        if (!$this->isAuth()) {
            $this->setFlash(
                'danger',
                'Silakan login terlebih dahulu.'
            );

            $this->redirect('index.php?c=auth&a=login');
        }

        if ($_SESSION['user_type'] !== 'pengguna') {

            $this->setFlash(
                'danger',
                'Akses ditolak! Halaman ini khusus siswa.'
            );

            $this->redirect('index.php?c=admin&a=dashboard');
        }
    }
}
?>
