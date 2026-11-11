
<?php

require_once __DIR__ . '/Model.php';

class Transaksi extends Model {

    protected $table = 'transaksi';


    /**
     * QUERY DASAR TRANSAKSI
     *
     * Mengambil data peminjam dan admin dari tabel user.
     */
    private function getTransactionQuery() {

        return "SELECT
                    t.*,

                    COALESCE(
                        u.nama_lengkap,
                        CONCAT('Siswa ID #', t.id_user)
                    ) AS nama_peminjam,

                    COALESCE(u.nis, '-') AS nis,

                    GROUP_CONCAT(
                        CONCAT(
                            b.judul,
                            IF(
                                dt.jumlah > 1,
                                CONCAT(' (', dt.jumlah, 'x)'),
                                ''
                            )
                        )
                        SEPARATOR ' || '
                    ) AS daftar_buku,

                    COALESCE(SUM(dt.jumlah), 0) AS total_buku,

                    a.nama_lengkap AS nama_admin,

                    CASE
                        WHEN t.status = 'dipinjam'
                             AND t.batas_kembali IS NOT NULL
                             AND CURDATE() > t.batas_kembali
                        THEN
                            DATEDIFF(
                                CURDATE(),
                                t.batas_kembali
                            ) * 1000 * COALESCE(SUM(dt.jumlah), 0)

                        ELSE t.total_denda
                    END AS calculated_denda

                FROM transaksi t

                LEFT JOIN `user` u
                    ON t.id_user = u.id_user

                LEFT JOIN `user` a
                    ON t.id_admin = a.id_user
                    AND a.role = 'admin'

                LEFT JOIN detail_transaksi dt
                    ON t.id_transaksi = dt.id_transaksi

                LEFT JOIN buku b
                    ON dt.id_buku = b.id_buku";
    }


    /**
     * MENGAMBIL SELURUH TRANSAKSI
     * Bisa difilter berdasarkan status, tanggal, dan pencarian.
     */
    public function getAllTransactions(
        $status = '',
        $startDate = '',
        $endDate = '',
        $search = ''
    ) {

        $sql = $this->getTransactionQuery();

        $sql .= " WHERE 1=1";

        $params = [];

        if ($status !== '') {

            $sql .= " AND t.status = :status";

            $params[':status'] = $status;
        }

        if ($startDate !== '') {

            $sql .= " AND t.tgl_pengajuan >= :startDate";

            $params[':startDate'] = $startDate;
        }

        if ($endDate !== '') {

            $sql .= " AND t.tgl_pengajuan <= :endDate";

            $params[':endDate'] = $endDate;
        }

        if ($search !== '') {

            $sql .= " AND (
                u.nama_lengkap LIKE :search
                OR u.nis LIKE :search
                OR u.username LIKE :search
                OR b.judul LIKE :search
            )";

            $params[':search'] = "%{$search}%";
        }

        $sql .= "
            GROUP BY t.id_transaksi
            ORDER BY t.id_transaksi DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }


    /**
     * MENGAMBIL TRANSAKSI HARI INI
     */
    public function getTodayTransactions() {

        $today = date('Y-m-d');

        $sql = $this->getTransactionQuery();

        $sql .= "
            WHERE (
                t.tgl_pengajuan = :pengajuan
                OR t.tgl_pinjam = :pinjam
                OR t.tgl_kembali = :kembali
            )

            GROUP BY t.id_transaksi
            ORDER BY t.id_transaksi DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':pengajuan' => $today,
            ':pinjam' => $today,
            ':kembali' => $today
        ]);

        return $stmt->fetchAll();
    }


    /**
     * MENGAMBIL TRANSAKSI BERDASARKAN ID USER
     *
     * Hanya mengambil transaksi milik siswa tersebut.
     */
    public function getByUser($id_user) {

        if (empty($id_user)) {
            return [];
        }

        $sql = $this->getTransactionQuery();

        $sql .= "
            WHERE t.id_user = :id_user

            GROUP BY t.id_transaksi
            ORDER BY t.id_transaksi DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id_user' => $id_user
        ]);

        return $stmt->fetchAll();
    }


    /**
     * MEMBUAT PENGAJUAN PEMINJAMAN
     *
     * id_user berasal dari akun siswa yang login.
     */
    public function createPengajuan(
        $id_user,
        $bukuIds,
        $id_admin = null
    ) {

        if (
            empty($id_user) ||
            empty($bukuIds) ||
            !is_array($bukuIds)
        ) {
            return false;
        }

        try {

            $this->db->beginTransaction();

            // Pastikan akun benar-benar siswa aktif.
            $stmtUser = $this->db->prepare(
                "SELECT id_user
                 FROM `user`
                 WHERE id_user = :id_user
                 AND role = 'pengguna'
                 AND status = 'Aktif'
                 LIMIT 1"
            );

            $stmtUser->execute([
                ':id_user' => $id_user
            ]);

            if (!$stmtUser->fetch()) {
                throw new Exception('Akun siswa tidak ditemukan atau tidak aktif.');
            }

            // Buat transaksi utama.
            $sql = "INSERT INTO transaksi
                    (
                        id_user,
                        id_admin,
                        tgl_pengajuan,
                        status,
                        total_denda
                    )
                    VALUES
                    (
                        :id_user,
                        :id_admin,
                        :tgl_pengajuan,
                        'menunggu',
                        0
                    )";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':id_user' => $id_user,
                ':id_admin' => $id_admin ?: null,
                ':tgl_pengajuan' => date('Y-m-d')
            ]);

            $transaksiId = $this->db->lastInsertId();

            if (!$transaksiId) {
                throw new Exception('Gagal membuat transaksi.');
            }

            // Simpan setiap buku ke detail transaksi.
            $sqlDetail = "INSERT INTO detail_transaksi
                          (
                              id_transaksi,
                              id_buku,
                              jumlah
                          )
                          VALUES
                          (
                              :id_transaksi,
                              :id_buku,
                              1
                          )";

            $stmtDetail = $this->db->prepare($sqlDetail);

            foreach ($bukuIds as $bukuId) {

                $bukuId = (int) $bukuId;

                if ($bukuId <= 0) {
                    throw new Exception('ID buku tidak valid.');
                }

                $stmtDetail->execute([
                    ':id_transaksi' => $transaksiId,
                    ':id_buku' => $bukuId
                ]);
            }

            $this->db->commit();

            return $transaksiId;

        } catch (Throwable $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            error_log(
                'createPengajuan error: ' . $e->getMessage()
            );

            return false;
        }
    }


    /**
     * MENYETUJUI PEMINJAMAN
     *
     * Stok dikurangi ketika admin menyetujui pengajuan.
     */
    public function approvePinjam(
        $id_transaksi,
        $id_admin = null,
        $tgl_pinjam = null,
        $batas_kembali = null
    ) {

        try {

            $this->db->beginTransaction();

            $tgl_pinjam = $tgl_pinjam ?: date('Y-m-d');

            $batas_kembali = $batas_kembali ?: date(
                'Y-m-d',
                strtotime('+7 days', strtotime($tgl_pinjam))
            );

            // Kunci transaksi agar tidak diproses bersamaan.
            $stmt = $this->db->prepare(
                "SELECT *
                 FROM transaksi
                 WHERE id_transaksi = :id
                 FOR UPDATE"
            );

            $stmt->execute([
                ':id' => $id_transaksi
            ]);

            $transaksi = $stmt->fetch();

            if (
                !$transaksi ||
                $transaksi['status'] !== 'menunggu'
            ) {
                throw new Exception('Transaksi tidak ditemukan atau sudah diproses.');
            }

            // Ambil seluruh buku dan jumlahnya.
            $stmtBooks = $this->db->prepare(
                "SELECT
                    dt.id_buku,
                    dt.jumlah,
                    b.stok
                 FROM detail_transaksi dt
                 INNER JOIN buku b
                    ON dt.id_buku = b.id_buku
                 WHERE dt.id_transaksi = :id
                 FOR UPDATE"
            );

            $stmtBooks->execute([
                ':id' => $id_transaksi
            ]);

            $books = $stmtBooks->fetchAll();

            if (empty($books)) {
                throw new Exception('Detail buku transaksi tidak ditemukan.');
            }

            // Pastikan stok mencukupi.
            foreach ($books as $book) {

                if (
                    (int) $book['stok'] <
                    (int) $book['jumlah']
                ) {
                    throw new Exception(
                        'Stok buku tidak mencukupi untuk menyetujui peminjaman.'
                    );
                }
            }

            // Kurangi stok sesuai jumlah buku.
            // Kurangi stok sesuai jumlah buku.
$stmtStock = $this->db->prepare(
    "UPDATE buku
     SET stok = stok - :jumlah_kurang
     WHERE id_buku = :id_buku
     AND stok >= :jumlah_cek"
);

foreach ($books as $book) {

    $jumlah = (int) $book['jumlah'];

    $stmtStock->execute([
        ':jumlah_kurang' => $jumlah,
        ':id_buku' => $book['id_buku'],
        ':jumlah_cek' => $jumlah
    ]);

    if ($stmtStock->rowCount() !== 1) {
        throw new Exception(
            'Gagal memperbarui stok buku. Stok mungkin tidak mencukupi.'
        );
    }
}

            // Perbarui status transaksi.
            $sql = "UPDATE transaksi
                    SET
                        tgl_pinjam = :tgl_pinjam,
                        batas_kembali = :batas_kembali,
                        id_admin = :id_admin,
                        status = 'dipinjam'
                    WHERE id_transaksi = :id";

            $stmtUpdate = $this->db->prepare($sql);

            $stmtUpdate->execute([
                ':tgl_pinjam' => $tgl_pinjam,
                ':batas_kembali' => $batas_kembali,
                ':id_admin' => $id_admin ?: null,
                ':id' => $id_transaksi
            ]);

            $this->db->commit();

            return true;

        } catch (Throwable $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            error_log(
                'approvePinjam error: ' . $e->getMessage()
            );

            return false;
        }
    }


    /**
     * MEMPROSES PENGEMBALIAN BUKU
     *
     * Stok ditambahkan kembali setelah admin
     * mengonfirmasi pengembalian.
     */
    public function prosesKembali(
        $id_transaksi,
        $tgl_kembali,
        $denda = 0,
        $id_admin = null
    ) {

        try {

            $this->db->beginTransaction();

            // Kunci transaksi.
            $stmt = $this->db->prepare(
                "SELECT *
                 FROM transaksi
                 WHERE id_transaksi = :id
                 FOR UPDATE"
            );

            $stmt->execute([
                ':id' => $id_transaksi
            ]);

            $transaksi = $stmt->fetch();

            if (
                !$transaksi ||
                !in_array(
                    $transaksi['status'],
                    ['dipinjam', 'menunggu_kembali'],
                    true
                )
            ) {
                throw new Exception('Transaksi tidak dapat dikembalikan.');
            }

            // Ambil jumlah setiap buku.
            $stmtBooks = $this->db->prepare(
                "SELECT id_buku, jumlah
                 FROM detail_transaksi
                 WHERE id_transaksi = :id"
            );

            $stmtBooks->execute([
                ':id' => $id_transaksi
            ]);

            $books = $stmtBooks->fetchAll();

            if (empty($books)) {
                throw new Exception('Detail buku tidak ditemukan.');
            }

            // Kembalikan stok buku.
            $stmtStock = $this->db->prepare(
                "UPDATE buku
                 SET stok = stok + :jumlah
                 WHERE id_buku = :id_buku"
            );

            foreach ($books as $book) {

                $stmtStock->execute([
                    ':jumlah' => $book['jumlah'],
                    ':id_buku' => $book['id_buku']
                ]);
            }

            // Perbarui transaksi menjadi selesai.
            $sql = "UPDATE transaksi
                    SET
                        tgl_kembali = :tgl_kembali,
                        status = 'dikembalikan',
                        total_denda = :denda,
                        id_admin = COALESCE(:id_admin, id_admin)
                    WHERE id_transaksi = :id";

            $stmtUpdate = $this->db->prepare($sql);

            $stmtUpdate->execute([
                ':tgl_kembali' => $tgl_kembali,
                ':denda' => $denda,
                ':id_admin' => $id_admin,
                ':id' => $id_transaksi
            ]);

            $this->db->commit();

            return true;

        } catch (Throwable $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            error_log(
                'prosesKembali error: ' . $e->getMessage()
            );

            return false;
        }
    }


    /**
     * MENOLAK PENGAJUAN PEMINJAMAN
     */
    public function tolakPengajuan(
        $id_transaksi,
        $id_admin = null
    ) {

        $sql = "UPDATE transaksi
                SET
                    status = 'ditolak',
                    id_admin = COALESCE(:id_admin, id_admin)
                WHERE id_transaksi = :id
                AND status = 'menunggu'";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_admin' => $id_admin,
            ':id' => $id_transaksi
        ]);
    }


    /**
     * SISWA MENGAJUKAN PENGEMBALIAN
     *
     * Siswa hanya dapat mengajukan pengembalian
     * untuk transaksi miliknya sendiri.
     */
    public function ajukanPengembalianSiswa(
        $id_transaksi,
        $id_user
    ) {

        $sql = "UPDATE transaksi
                SET status = 'menunggu_kembali'
                WHERE id_transaksi = :id
                AND id_user = :id_user
                AND status = 'dipinjam'";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id_transaksi,
            ':id_user' => $id_user
        ]);
    }
}

?>
