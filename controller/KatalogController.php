<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Kategori.php';

class KatalogController extends Controller {
    public function index() {
        $bukuModel = new Buku();
        $kategoriModel = new Kategori();

        $search = trim($_GET['q'] ?? '');
        $kategoriId = !empty($_GET['kategori']) ? (int)$_GET['kategori'] : null;

        $books = $bukuModel->getAllWithDetails($search, $kategoriId);
        $categories = $kategoriModel->getWithBookCount();

        $data = [
            'pageTitle' => 'Katalog Buku Perpustakaan',
            'books' => $books,
            'categories' => $categories,
            'search' => $search,
            'selectedKategori' => $kategoriId
        ];

        $this->view('katalog/index', $data);
    }

    public function detail() {
        $id = (int)($_GET['id'] ?? 0);
        $bukuModel = new Buku();
        $buku = $bukuModel->getDetail($id);

        if (!$buku) {
            $this->setFlash('danger', 'Buku tidak ditemukan.');
            $this->redirect('index.php?c=katalog&a=index');
        }

        $data = [
            'pageTitle' => 'Detail Buku: ' . $buku['judul'],
            'buku' => $buku
        ];

        $this->view('katalog/detail', $data);
    }
}
?>
