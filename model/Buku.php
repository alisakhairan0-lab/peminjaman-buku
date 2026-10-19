<?php
require_once __DIR__ . '/Model.php';

class Buku extends Model {
    protected $table = 'buku';

    public function getAllWithDetails($search = '', $kategoriId = null) {
        $sql = "SELECT b.*, k.nama_kategori, p.nama_penerbit 
                FROM buku b
                LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
                WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (b.judul LIKE ? OR b.penulis LIKE ? OR k.nama_kategori LIKE ?)";
            $wildcard = "%{$search}%";
            $params[] = $wildcard;
            $params[] = $wildcard;
            $params[] = $wildcard;
        }

        if (!empty($kategoriId)) {
            $sql .= " AND b.id_kategori = ?";
            $params[] = $kategoriId;
        }

        $sql .= " ORDER BY b.id_buku DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getDetail($id) {
        $sql = "SELECT b.*, k.nama_kategori, p.nama_penerbit, p.alamat AS alamat_penerbit, p.telepon AS telp_penerbit
                FROM buku b
                LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
                WHERE b.id_buku = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO buku (id_kategori, id_penerbit, judul, penulis, tahun_terbit, stok, gambar) 
                VALUES (:id_kategori, :id_penerbit, :judul, :penulis, :tahun_terbit, :stok, :gambar)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_kategori' => $data['id_kategori'],
            ':id_penerbit' => !empty($data['id_penerbit']) ? $data['id_penerbit'] : null,
            ':judul' => $data['judul'],
            ':penulis' => $data['penulis'],
            ':tahun_terbit' => $data['tahun_terbit'],
            ':stok' => $data['stok'],
            ':gambar' => $data['gambar'] ?? 'default_book.jpg'
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE buku SET 
                id_kategori = :id_kategori, 
                id_penerbit = :id_penerbit, 
                judul = :judul, 
                penulis = :penulis, 
                tahun_terbit = :tahun_terbit, 
                stok = :stok";
        $params = [
            ':id' => $id,
            ':id_kategori' => $data['id_kategori'],
            ':id_penerbit' => !empty($data['id_penerbit']) ? $data['id_penerbit'] : null,
            ':judul' => $data['judul'],
            ':penulis' => $data['penulis'],
            ':tahun_terbit' => $data['tahun_terbit'],
            ':stok' => $data['stok']
        ];

        if (!empty($data['gambar'])) {
            $sql .= ", gambar = :gambar";
            $params[':gambar'] = $data['gambar'];
        }

        $sql .= " WHERE id_buku = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function decreaseStock($id_buku, $qty = 1) {
        $stmt = $this->db->prepare("UPDATE buku SET stok = GREATEST(0, stok - :qty) WHERE id_buku = :id");
        return $stmt->execute([':qty' => $qty, ':id' => $id_buku]);
    }

    public function increaseStock($id_buku, $qty = 1) {
        $stmt = $this->db->prepare("UPDATE buku SET stok = stok + :qty WHERE id_buku = :id");
        return $stmt->execute([':qty' => $qty, ':id' => $id_buku]);
    }
}
?>