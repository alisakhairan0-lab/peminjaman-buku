
<?php
/**
 * Model User
 * Mengelola data Admin dan Pengguna/Siswa
 * dalam satu tabel bernama user.
 */

require_once __DIR__ . '/Model.php';

class User extends Model {

    protected $table = 'user';

    /**
     * LOGIN
     * Admin dan pengguna login melalui tabel yang sama.
     */
    public function login($username, $password) {

        $sql = "SELECT *
                FROM {$this->table}
                WHERE username = :username
                AND status = 'Aktif'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':username' => $username
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        // Mendukung password lama (teks biasa)
        // dan password baru (password_hash).
        $passwordValid =
            password_verify($password, $user['password']) ||
            hash_equals((string) $user['password'], (string) $password);

        if ($passwordValid) {
            return $user;
        }

        return false;
    }

    /**
     * MENGAMBIL SEMUA USER BERDASARKAN ROLE
     * Role yang tersedia: admin dan pengguna.
     */
    public function getByRole($role) {

        $sql = "SELECT *
                FROM {$this->table}
                WHERE role = :role
                ORDER BY nama_lengkap ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':role' => $role
        ]);

        return $stmt->fetchAll();
    }

    /**
     * MEMERIKSA USERNAME
     * Menghindari username yang sama.
     */
    public function isUsernameExist($username, $excludeId = null) {

        $sql = "SELECT COUNT(*)
                FROM {$this->table}
                WHERE username = :username";

        $params = [
            ':username' => $username
        ];

        if ($excludeId !== null) {
            $sql .= " AND id_user != :id";
            $params[':id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * MEMERIKSA NIS
     * NIS boleh kosong untuk akun admin.
     */
    public function isNisExist($nis, $excludeId = null) {

        if ($nis === null || trim((string) $nis) === '') {
            return false;
        }

        $sql = "SELECT COUNT(*)
                FROM {$this->table}
                WHERE nis = :nis";

        $params = [
            ':nis' => $nis
        ];

        if ($excludeId !== null) {
            $sql .= " AND id_user != :id";
            $params[':id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * MENAMBAHKAN USER BARU
     * Default role adalah pengguna.
     */
    public function create($data) {

        $nama = trim($data['nama_lengkap'] ?? '');
        $username = trim($data['username'] ?? '');
        $password = (string) ($data['password'] ?? '');
        $role = $data['role'] ?? 'pengguna';
        $status = $data['status'] ?? 'Aktif';
        $nis = $data['nis'] ?? null;

        if ($nama === '' || $username === '' || $password === '') {
            return false;
        }

        if (!in_array($role, ['admin', 'pengguna'], true)) {
            return false;
        }

        if (!in_array($status, ['Aktif', 'Non-Aktif'], true)) {
            return false;
        }

        if ($this->isUsernameExist($username)) {
            return false;
        }

        if ($this->isNisExist($nis)) {
            return false;
        }

        // Password baru disimpan dalam bentuk hash.
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "INSERT INTO {$this->table}
                (
                    nis,
                    nama_lengkap,
                    username,
                    password,
                    role,
                    status
                )
                VALUES
                (
                    :nis,
                    :nama_lengkap,
                    :username,
                    :password,
                    :role,
                    :status
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nis' => $nis !== '' ? $nis : null,
            ':nama_lengkap' => $nama,
            ':username' => $username,
            ':password' => $hashedPassword,
            ':role' => $role,
            ':status' => $status
        ]);
    }

    /**
     * MEMPERBARUI DATA USER
     * Password hanya diperbarui jika diisi.
     */
    public function update($id, $data) {

        $userLama = $this->getById('id_user', $id);

        if (!$userLama) {
            return false;
        }

        $nama = trim(
            $data['nama_lengkap'] ?? $userLama['nama_lengkap']
        );

        $username = trim(
            $data['username'] ?? $userLama['username']
        );

        $nis = $data['nis'] ?? $userLama['nis'];

        $role = $data['role'] ?? $userLama['role'];

        $status = $data['status'] ?? $userLama['status'];

        if ($nama === '' || $username === '') {
            return false;
        }

        if (!in_array($role, ['admin', 'pengguna'], true)) {
            return false;
        }

        if (!in_array($status, ['Aktif', 'Non-Aktif'], true)) {
            return false;
        }

        if ($this->isUsernameExist($username, $id)) {
            return false;
        }

        if ($this->isNisExist($nis, $id)) {
            return false;
        }

        $sql = "UPDATE {$this->table}
                SET
                    nis = :nis,
                    nama_lengkap = :nama_lengkap,
                    username = :username,
                    role = :role,
                    status = :status";

        $params = [
            ':id' => $id,
            ':nis' => $nis !== '' ? $nis : null,
            ':nama_lengkap' => $nama,
            ':username' => $username,
            ':role' => $role,
            ':status' => $status
        ];

        // Jika password baru diisi, simpan hash-nya.
        if (
            isset($data['password']) &&
            trim((string) $data['password']) !== ''
        ) {

            $sql .= ", password = :password";

            $params[':password'] = password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            );
        }

        $sql .= " WHERE id_user = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * MEMPERBARUI PROFIL USER
     */
    public function updateProfile(
        $id,
        $nama,
        $nis = null,
        $password = null
    ) {

        $data = [
            'nama_lengkap' => $nama
        ];

        $user = $this->getById('id_user', $id);

        if (!$user) {
            return false;
        }

        $data['username'] = $user['username'];
        $data['nis'] = $nis;
        $data['role'] = $user['role'];
        $data['status'] = $user['status'];

        if (!empty($password)) {
            $data['password'] = $password;
        }

        return $this->update($id, $data);
    }

    /**
     * MENGUBAH STATUS USER
     * Status: Aktif atau Non-Aktif.
     */
    public function updateStatus($id, $status) {

        if (!in_array($status, ['Aktif', 'Non-Aktif'], true)) {
            return false;
        }

        $sql = "UPDATE {$this->table}
                SET status = :status
                WHERE id_user = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }

    /**
     * MENGHITUNG JUMLAH USER BERDASARKAN ROLE
     */
    public function countByRole($role) {

        $sql = "SELECT COUNT(*)
                FROM {$this->table}
                WHERE role = :role";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':role' => $role
        ]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * MENGAMBIL DATA USER AKTIF
     */
    public function getActiveUsers($role = null) {

        $sql = "SELECT *
                FROM {$this->table}
                WHERE status = 'Aktif'";

        $params = [];

        if ($role !== null) {
            $sql .= " AND role = :role";
            $params[':role'] = $role;
        }

        $sql .= " ORDER BY nama_lengkap ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
?>
