<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Buku.php';
require_once __DIR__ . '/../model/Kategori.php';
require_once __DIR__ . '/../model/Penerbit.php';

class BukuController extends Controller {
    public function index() {
        $this->requireAdmin();

        $bukuModel = new Buku();
        $search = trim($_GET['q'] ?? '');
        $kategoriId = !empty($_GET['kategori']) ? (int)$_GET['kategori'] : null;

        $books = $bukuModel->getAllWithDetails($search, $kategoriId);
        $kategoriModel = new Kategori();
        $categories = $kategoriModel->getAll();

        $data = [
            'pageTitle' => 'Kelola Koleksi Buku',
            'books' => $books,
            'categories' => $categories,
            'search' => $search,
            'selectedKategori' => $kategoriId
        ];

        $this->view('admin/buku/index', $data);
    }

    public function tambah() {
        $this->requireAdmin();

        $kategoriModel = new Kategori();
        $penerbitModel = new Penerbit();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $judul = trim($_POST['judul'] ?? '');
            $penulis = trim($_POST['penulis'] ?? '');
            $id_kategori = (int)($_POST['id_kategori'] ?? 0);
            $id_penerbit = (int)($_POST['id_penerbit'] ?? 0);
            $tahun_terbit = (int)($_POST['tahun_terbit'] ?? date('Y'));
            $stok = (int)($_POST['stok'] ?? 0);

            // Cover handling
            $gambar = 'default_book.jpg';
            if (!empty($_FILES['gambar']['name'])) {
                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $newName = 'buku_' . time() . '.' . $ext;
                $target = __DIR__ . '/../assets/images/covers/' . $newName;
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                    $gambar = $newName;
                }
            }

            if (!empty($judul) && !empty($penulis) && $id_kategori > 0) {
                $bukuModel = new Buku();
                $bukuModel->create([
                    'id_kategori' => $id_kategori,
                    'id_penerbit' => $id_penerbit,
                    'judul' => $judul,
                    'penulis' => $penulis,
                    'tahun_terbit' => $tahun_terbit,
                    'stok' => $stok,
                    'gambar' => $gambar
                ]);

                $this->setFlash('success', 'Buku baru berhasil ditambahkan ke katalog!');
                $this->redirect('index.php?c=buku&a=index');
            } else {
                $this->setFlash('danger', 'Mohon lengkapi judul, penulis, dan kategori buku.');
            }
        }

        $data = [
            'pageTitle' => 'Tambah Buku Baru',
            'categories' => $kategoriModel->getAll(),
            'publishers' => $penerbitModel->getAll()
        ];

        $this->view('admin/buku/tambah', $data);
    }

    public function edit() {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $bukuModel = new Buku();
        $buku = $bukuModel->getDetail($id);

        if (!$buku) {
            $this->setFlash('danger', 'Buku tidak ditemukan.');
            $this->redirect('index.php?c=buku&a=index');
        }

        $kategoriModel = new Kategori();
        $penerbitModel = new Penerbit();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $judul = trim($_POST['judul'] ?? '');
            $penulis = trim($_POST['penulis'] ?? '');
            $id_kategori = (int)($_POST['id_kategori'] ?? 0);
            $id_penerbit = (int)($_POST['id_penerbit'] ?? 0);
            $tahun_terbit = (int)($_POST['tahun_terbit'] ?? date('Y'));
            $stok = (int)($_POST['stok'] ?? 0);

            $updateData = [
                'id_kategori' => $id_kategori,
                'id_penerbit' => $id_penerbit,
                'judul' => $judul,
                'penulis' => $penulis,
                'tahun_terbit' => $tahun_terbit,
                'stok' => $stok
            ];

            if (!empty($_FILES['gambar']['name'])) {
                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $newName = 'buku_' . time() . '.' . $ext;
                $target = __DIR__ . '/../assets/images/covers/' . $newName;
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                    $updateData['gambar'] = $newName;
                }
            }

            $bukuModel->update($id, $updateData);
            $this->setFlash('success', 'Data buku berhasil diperbarui!');
            $this->redirect('index.php?c=buku&a=index');
        }

        $data = [
            'pageTitle' => 'Edit Buku: ' . $buku['judul'],
            'buku' => $buku,
            'categories' => $kategoriModel->getAll(),
            'publishers' => $penerbitModel->getAll()
        ];

        $this->view('admin/buku/edit', $data);
    }

    public function hapus() {
        $this->requireAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $bukuModel = new Buku();
        $bukuModel->delete('id_buku', $id);

        $this->setFlash('info', 'Buku berhasil dihapus dari sistem.');
        $this->redirect('index.php?c=buku&a=index');
    }
}
?>
