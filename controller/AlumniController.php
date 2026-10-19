<?php
require_once __DIR__ . '/Controller.php';

class AlumniController extends Controller {
    public function index() {
        $this->requireAdmin();

        $db = Database::getInstance()->getConnection();
        $search = trim($_GET['q'] ?? '');

        if (!empty($search)) {
            $stmt = $db->prepare("SELECT * FROM alumni WHERE nama_lengkap LIKE :s OR nis LIKE :s OR username LIKE :s ORDER BY tgl_keluar DESC");
            $stmt->execute([':s' => "%{$search}%"]);
            $alumni = $stmt->fetchAll();
        } else {
            $stmt = $db->query("SELECT * FROM alumni ORDER BY tgl_keluar DESC");
            $alumni = $stmt->fetchAll();
        }

        $data = [
            'pageTitle' => 'Data Alumni / Anggota Keluar',
            'alumni' => $alumni,
            'search' => $search
        ];

        $this->view('admin/alumni/index', $data);
    }
}
?>