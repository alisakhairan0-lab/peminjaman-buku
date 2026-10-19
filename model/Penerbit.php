<?php
require_once __DIR__ . '/Model.php';

class Penerbit extends Model {
    protected $table = 'penerbit';

    public function create($data) {
        $sql = "INSERT INTO penerbit (nama_penerbit, alamat, telepon) VALUES (:nama, :alamat, :telp)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nama' => $data['nama_penerbit'],
            ':alamat' => $data['alamat'] ?? null,
            ':telp' => $data['telepon'] ?? $data['no_telp'] ?? null
        ]);
    }
}
?>