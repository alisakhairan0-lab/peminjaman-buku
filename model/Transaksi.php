<?php
require_once __DIR__ . '/Model.php';

class Transaksi extends Model {
    protected $table = 'transaksi';

    public function getAllTransactions($status = '', $startDate = '', $endDate = '', $search = '') {
        // PERBAIKAN: Menambahkan perhitungan denda dinamis (DATEDIFF) jika status masih 'dipinjam' dan melewati batas_kembali
        $sql = "SELECT t.*, 
                       COALESCE(p.nama_lengkap, al.nama_lengkap, CONCAT('Siswa ID #', t.id_pengguna)) AS nama_peminjam, 
                       COALESCE(p.nis, al.nis, '-') AS nis,
                       GROUP_CONCAT(b.judul SEPARATOR ' || ') AS daftar_buku,
                       COUNT(dt.id_buku) AS total_buku,
                       a.nama_admin,
                       CASE 
                           WHEN t.status = 'dipinjam' AND CURDATE() > t.batas_kembali 
                           THEN DATEDIFF(CURDATE(), t.batas_kembali) * 1000 * (SELECT COUNT(*) FROM detail_transaksi WHERE id_transaksi = t.id_transaksi)
                           ELSE t.total_denda 
                       END AS calculated_denda
                FROM transaksi t
                LEFT JOIN pengguna p ON t.id_pengguna = p.id_pengguna
                LEFT JOIN alumni al ON (t.id_pengguna = al.id_pengguna OR t.id_pengguna = al.id_alumni)
                LEFT JOIN admin a ON t.id_admin = a.id_admin
                LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                LEFT JOIN buku b ON dt.id_buku = b.id_buku
                WHERE 1=1";
        $params = [];

        if (!empty($status)) {
            $sql .= " AND t.status = :status";
            $params[':status'] = $status;
        }

        if (!empty($startDate)) {
            $sql .= " AND t.tgl_pengajuan >= :startDate";
            $params[':startDate'] = $startDate;
        }

        if (!empty($endDate)) {
            $sql .= " AND t.tgl_pengajuan <= :endDate";
            $params[':endDate'] = $endDate;
        }

        if (!empty($search)) {
            $sql .= " AND (p.nama_lengkap LIKE :search OR al.nama_lengkap LIKE :search OR p.nis LIKE :search OR al.nis LIKE :search OR b.judul LIKE :search)";
            $params[':search'] = "%{$search}%";
        }

        $sql .= " GROUP BY t.id_transaksi ORDER BY t.id_transaksi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getTodayTransactions() {
        $today = date('Y-m-d');
        $sql = "SELECT t.*, 
                       COALESCE(p.nama_lengkap, al.nama_lengkap, CONCAT('Siswa ID #', t.id_pengguna)) AS nama_peminjam, 
                       COALESCE(p.nis, al.nis, '-') AS nis,
                       GROUP_CONCAT(b.judul SEPARATOR ' || ') AS daftar_buku,
                       COUNT(dt.id_buku) AS total_buku,
                       a.nama_admin,
                       CASE 
                           WHEN t.status = 'dipinjam' AND CURDATE() > t.batas_kembali 
                           THEN DATEDIFF(CURDATE(), t.batas_kembali) * 1000 * (SELECT COUNT(*) FROM detail_transaksi WHERE id_transaksi = t.id_transaksi)
                           ELSE t.total_denda 
                       END AS calculated_denda
                FROM transaksi t
                LEFT JOIN pengguna p ON t.id_pengguna = p.id_pengguna
                LEFT JOIN alumni al ON (t.id_pengguna = al.id_pengguna OR t.id_pengguna = al.id_alumni)
                LEFT JOIN admin a ON t.id_admin = a.id_admin
                LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                LEFT JOIN buku b ON dt.id_buku = b.id_buku
                WHERE t.tgl_pengajuan = ? OR t.tgl_pinjam = ? OR t.tgl_kembali = ?
                GROUP BY t.id_transaksi ORDER BY t.id_transaksi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$today, $today, $today]);
        return $stmt->fetchAll();
    }

    public function getByUser($id_pengguna) {
        if (empty($id_pengguna)) return [];
        $sql = "SELECT t.*,
                       COALESCE(p.nama_lengkap, al.nama_lengkap, CONCAT('Siswa ID #', t.id_pengguna)) AS nama_peminjam,
                       COALESCE(p.nis, al.nis, '-') AS nis,
                       GROUP_CONCAT(b.judul SEPARATOR ' || ') AS daftar_buku,
                       COUNT(dt.id_buku) AS total_buku,
                       a.nama_admin,
                       CASE 
                           WHEN t.status = 'dipinjam' AND CURDATE() > t.batas_kembali 
                           THEN DATEDIFF(CURDATE(), t.batas_kembali) * 1000 * (SELECT COUNT(*) FROM detail_transaksi WHERE id_transaksi = t.id_transaksi)
                           ELSE t.total_denda 
                       END AS calculated_denda
                FROM transaksi t
                LEFT JOIN pengguna p ON t.id_pengguna = p.id_pengguna
                LEFT JOIN alumni al ON (t.id_pengguna = al.id_pengguna OR t.id_pengguna = al.id_alumni)
                LEFT JOIN admin a ON t.id_admin = a.id_admin
                LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                LEFT JOIN buku b ON dt.id_buku = b.id_buku
                WHERE t.id_pengguna = :id_pengguna
                GROUP BY t.id_transaksi ORDER BY t.id_transaksi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_pengguna' => $id_pengguna]);
        return $stmt->fetchAll();
    }

    public function createPengajuan($id_pengguna, $bukuIds, $id_admin = null) {
        if (empty($id_pengguna) || empty($bukuIds) || !is_array($bukuIds)) {
            return false;
        }
        try {
            if ($this->db->inTransaction()) {
                $this->db->commit();
            }
            $this->db->beginTransaction();

            $adminVal = (empty($id_admin) || $id_admin == 0) ? null : $id_admin;

            $sql = "INSERT INTO transaksi (id_pengguna, id_admin, tgl_pengajuan, status, total_denda) 
                    VALUES (:id_pengguna, :id_admin, :tgl_pengajuan, 'menunggu', 0)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_pengguna' => $id_pengguna,
                ':id_admin' => $adminVal,
                ':tgl_pengajuan' => date('Y-m-d')
            ]);
            $transaksiId = $this->db->lastInsertId();

            if (!$transaksiId) {
                throw new Exception("Gagal insert master transaksi");
            }

            $sqlDetail = "INSERT INTO detail_transaksi (id_transaksi, id_buku) VALUES (:id_transaksi, :id_buku)";
            $stmtDetail = $this->db->prepare($sqlDetail);

            foreach ($bukuIds as $bukuId) {
                $stmtDetail->execute([
                    ':id_transaksi' => $transaksiId,
                    ':id_buku' => $bukuId
                ]);
            }

            $this->db->commit();
            return $transaksiId;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("createPengajuan error: " . $e->getMessage());
            return false;
        }
    }

    public function approvePinjam($id_transaksi, $id_admin = null, $tgl_pinjam = null, $batas_kembali = null) {
        try {
            if ($this->db->inTransaction()) $this->db->commit();
            $this->db->beginTransaction();

            $tgl_pinjam = $tgl_pinjam ?: date('Y-m-d');
            $batas_kembali = $batas_kembali ?: date('Y-m-d', strtotime('+7 days', strtotime($tgl_pinjam)));

            $sql = "UPDATE transaksi SET 
                    tgl_pinjam = :tgl_pinjam,
                    batas_kembali = :batas_kembali,
                    id_admin = COALESCE(:id_admin, id_admin),
                    status = 'dipinjam'
                    WHERE id_transaksi = :id_transaksi";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':tgl_pinjam' => $tgl_pinjam,
                ':batas_kembali' => $batas_kembali,
                ':id_admin' => $id_admin,
                ':id_transaksi' => $id_transaksi
            ]);

            $sqlBooks = "SELECT id_buku FROM detail_transaksi WHERE id_transaksi = :id";
            $stmtBooks = $this->db->prepare($sqlBooks);
            $stmtBooks->execute([':id' => $id_transaksi]);
            $books = $stmtBooks->fetchAll();

            $sqlUpdateStock = "UPDATE buku SET stok = GREATEST(0, stok - 1) WHERE id_buku = :id_buku";
            $stmtStock = $this->db->prepare($sqlUpdateStock);
            foreach ($books as $b) {
                $stmtStock->execute([':id_buku' => $b['id_buku']]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            error_log("approvePinjam error: " . $e->getMessage());
            return false;
        }
    }

    public function prosesKembali($id_transaksi, $tgl_kembali, $denda = 0, $id_admin = null) {
        try {
            if ($this->db->inTransaction()) $this->db->commit();
            $this->db->beginTransaction();

            $sql = "UPDATE transaksi SET 
                    tgl_kembali = :tgl_kembali,
                    status = 'dikembalikan',
                    total_denda = :denda,
                    id_admin = COALESCE(:id_admin, id_admin)
                    WHERE id_transaksi = :id_transaksi";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':tgl_kembali' => $tgl_kembali,
                ':denda' => $denda,
                ':id_admin' => $id_admin,
                ':id_transaksi' => $id_transaksi
            ]);

            $sqlBooks = "SELECT id_buku FROM detail_transaksi WHERE id_transaksi = :id";
            $stmtBooks = $this->db->prepare($sqlBooks);
            $stmtBooks->execute([':id' => $id_transaksi]);
            $books = $stmtBooks->fetchAll();

            $sqlUpdateStock = "UPDATE buku SET stok = stok + 1 WHERE id_buku = :id_buku";
            $stmtStock = $this->db->prepare($sqlUpdateStock);
            foreach ($books as $b) {
                $stmtStock->execute([':id_buku' => $b['id_buku']]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            return false;
        }
    }

    public function tolakPengajuan($id_transaksi, $id_admin = null) {
        $stmt = $this->db->prepare("UPDATE transaksi SET status = 'ditolak', id_admin = COALESCE(:id_admin, id_admin) WHERE id_transaksi = :id");
        return $stmt->execute([
            ':id_admin' => $id_admin,
            ':id' => $id_transaksi
        ]);
    }

    public function ajukanPengembalianSiswa($id_transaksi, $id_pengguna) {
        $stmt = $this->db->prepare("UPDATE transaksi SET status = 'menunggu_kembali' WHERE id_transaksi = :id AND id_pengguna = :user");
        return $stmt->execute([
            ':id' => $id_transaksi,
            ':user' => $id_pengguna
        ]);
    }
}
?>