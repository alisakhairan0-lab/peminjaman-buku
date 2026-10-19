<?php
require_once __DIR__ . '/Model.php';

class Kategori extends Model {
    protected $table = 'kategori';

    public function create($nama_kategori) {
        $stmt = $this->db->prepare("INSERT INTO kategori (nama_kategori) VALUES (:nama)");
        return $stmt->execute([':nama' => $nama_kategori]);
    }

    public function update($id, $nama_kategori) {
        $stmt = $this->db->prepare("UPDATE kategori SET nama_kategori = :nama WHERE id_kategori = :id");
        return $stmt->execute([':nama' => $nama_kategori, ':id' => $id]);
    }

    public function getWithBookCount() {
        $sql = "SELECT k.*, COUNT(b.id_buku) as total_buku 
                FROM kategori k 
                LEFT JOIN buku b ON k.id_kategori = b.id_kategori 
                GROUP BY k.id_kategori 
                ORDER BY k.id_kategori ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>