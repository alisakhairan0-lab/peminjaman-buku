<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Kategori.php';

class KategoriController extends Controller {
    public function index() {
        $this->requireAdmin();

        $kategoriModel = new Kategori();
        $categories = $kategoriModel->getWithBookCount();

        $data = [
            'pageTitle' => 'Kelola Kategori Buku',
            'categories' => $categories
        ];

        $this->view('admin/kategori/index', $data);
    }

    public function tambah() {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama_kategori'] ?? '');
            if (!empty($nama)) {
                $kategoriModel = new Kategori();
                $kategoriModel->create($nama);
                $this->setFlash('success', 'Kategori baru berhasil ditambahkan!');
            }
        }
        $this->redirect('index.php?c=kategori&a=index');
    }

    public function edit() {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id_kategori'] ?? 0);
            $nama = trim($_POST['nama_kategori'] ?? '');
            if ($id > 0 && !empty($nama)) {
                $kategoriModel = new Kategori();
                $kategoriModel->update($id, $nama);
                $this->setFlash('success', 'Kategori berhasil diperbarui!');
            }
        }
        $this->redirect('index.php?c=kategori&a=index');
    }

    public function hapus() {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $kategoriModel = new Kategori();
        $kategoriModel->delete('id_kategori', $id);

        $this->setFlash('info', 'Kategori berhasil dihapus.');
        $this->redirect('index.php?c=kategori&a=index');
    }
}
?>
