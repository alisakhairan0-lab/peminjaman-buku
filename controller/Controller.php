<?php
/**
 * LibraryVerse - Base Controller Class
 * Handles View Rendering, Authentication Guards (RBAC), Flash Messages, and URL Redirects
 */
abstract class Controller {
    protected function view($viewPath, $data = [], $layout = 'default') {
        // Extract data variables to be accessible in views
        extract($data);

        // Flash message helper
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        // Check if layout is requested or partial
        if ($layout === false) {
            require __DIR__ . '/../view/' . $viewPath . '.php';
        } else {
            require __DIR__ . '/../view/templates/header.php';
            require __DIR__ . '/../view/templates/navbar.php';
            require __DIR__ . '/../view/' . $viewPath . '.php';
            require __DIR__ . '/../view/templates/footer.php';
        }
    }

    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }

    protected function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type, // 'success', 'danger', 'info', 'warning'
            'message' => $message
        ];
    }

    /**
     * RBAC Admin Guard:
     * Restricts access strictly to Administrator.
     * Prevents students from accessing admin pages.
     */
    protected function requireAdmin() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user') {
                $this->setFlash('danger', 'Akses Ditolak: Anda masuk sebagai Siswa dan tidak memiliki izin mengakses Panel Petugas/Admin.');
                $this->redirect('index.php?c=user&a=dashboard');
            } else {
                $this->setFlash('danger', 'Silakan login sebagai Petugas/Admin terlebih dahulu.');
                $this->redirect('index.php?c=auth&a=loginAdmin');
            }
        }
    }

    /**
     * RBAC User/Siswa Guard:
     * Restricts access strictly to registered Students.
     * Prevents admins from cluttering student loan portal.
     */
    protected function requireUser() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                $this->setFlash('info', 'Anda masuk sebagai Administrator. Kelola sirkulasi melalui Panel Admin.');
                $this->redirect('index.php?c=admin&a=dashboard');
            } else {
                $this->setFlash('danger', 'Silakan login sebagai Siswa untuk mengakses fitur peminjaman.');
                $this->redirect('index.php?c=auth&a=login');
            }
        }
    }

    protected function isAuth() {
        return isset($_SESSION['user_id']);
    }
}
?>
