<?php
require_once __DIR__ . '/Model.php';

class DetailTransaksi extends Model {
    protected $table = 'detail_transaksi';

    public function getByTransaksi($id_transaksi) {
        $sql = "SELECT dt.*, b.judul, b.penulis, b.tahun_terbit, b.gambar, k.nama_kategori
                FROM detail_transaksi dt
                JOIN buku b ON dt.id_buku = b.id_buku
                LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                WHERE dt.id_transaksi = :id_transaksi";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_transaksi' => $id_transaksi]);
        return $stmt->fetchAll();
    }
}
?>