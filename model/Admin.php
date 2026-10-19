<?php
require_once __DIR__ . '/Model.php';

class Admin extends Model {
    protected $table = 'admin';

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }

    public function register($data) {
        $sql = "INSERT INTO admin (nama_admin, username, password) VALUES (:nama, :user, :pass)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nama' => $data['nama_admin'],
            ':user' => $data['username'],
            ':pass' => $data['password'] // Compatible with existing plain/hash stored in dump
        ]);
    }

    public function updateProfile($id, $nama, $password = null) {
        if (!empty($password)) {
            $stmt = $this->db->prepare("UPDATE admin SET nama_admin = :nama, password = :pass WHERE id_admin = :id");
            return $stmt->execute([
                ':nama' => $nama,
                ':pass' => $password,
                ':id' => $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE admin SET nama_admin = :nama WHERE id_admin = :id");
            return $stmt->execute([
                ':nama' => $nama,
                ':id' => $id
            ]);
        }
    }

    public function verifyPassword($inputPassword, $storedPassword) {
        return ($inputPassword === $storedPassword) || (md5($inputPassword) === $storedPassword) || password_verify($inputPassword, $storedPassword);
    }
}
?>
