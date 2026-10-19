<?php
require_once __DIR__ . '/Model.php';

class Pengguna extends Model {
    protected $table = 'pengguna';

    public function findByUsername($username) {
        $stmt =$this->db->prepare("SELECT * FROM pengguna WHERE username = :username LIMIT 1");
        $stmt->execute([':username' =>$username]);
        return $stmt->fetch();
    }

    public function findByNis($nis) {
        $stmt =$this->db->prepare("SELECT * FROM pengguna WHERE nis = :nis LIMIT 1");
        $stmt->execute([':nis' =>$nis]);
        return $stmt->fetch();
    }

    public function register($data) {$sql = "INSERT INTO pengguna (nis, nama_lengkap, username, password, role, status) 
                VALUES (:nis, :nama_lengkap, :username, :password, 'user', 'Aktif')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nis' => $data['nis'],
            ':nama_lengkap' => $data['nama_lengkap'],
            ':username' => $data['username'],
            ':password' => $data['password']
        ]);
    }

    public function updateProfile($id,$nama_lengkap, $nis,$password = null) {
        if (!empty($password)) {
            $stmt =$this->db->prepare("UPDATE pengguna SET nama_lengkap = :nama, nis = :nis, password = :pass WHERE id_pengguna = :id");
            return $stmt->execute([
                ':nama' => $nama_lengkap,
                ':nis' => $nis,
                ':pass' => $password,
                ':id' => $id
            ]);
        } else {
            $stmt =$this->db->prepare("UPDATE pengguna SET nama_lengkap = :nama, nis = :nis WHERE id_pengguna = :id");
            return $stmt->execute([
                ':nama' => $nama_lengkap,
                ':nis' => $nis,
                ':id' => $id
            ]);
        }
    }

    public function verifyPassword($inputPassword,$storedPassword) {
        return (md5($inputPassword) ===$storedPassword) or ($inputPassword ===$storedPassword) or password_verify($inputPassword,$storedPassword);
    }

    public function cekPinjamanAktif($id_pengguna) {$sql = "SELECT status FROM transaksi WHERE id_pengguna = :id_pengguna";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_pengguna' =>$id_pengguna]);
        $transaksis =$stmt->fetchAll();

        $jumlahAktif = 0;
        foreach ($transaksis as$trx) {
            $statusTrx = strtolower(trim($trx['status']));
            if ($statusTrx === 'dipinjam' or$statusTrx === 'pending' or $statusTrx === 'menunggu') {$jumlahAktif++;
            }
        }
        
        return $jumlahAktif;
    }

    public function updateStatus($id_pengguna, $statusBaru) {$sql = "UPDATE pengguna SET status = :status WHERE id_pengguna = :id_pengguna";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $statusBaru,
            ':id_pengguna' => $id_pengguna
        ]);
    }

    // Fungsi utama sesuai prosedur UKK: Arsip ke alumni, lalu hapus dari pengguna tanpa merusak riwayat
    public function pindahkanKeAlumni($id_pengguna) {$user = $this->getById('id_pengguna',$id_pengguna);
        if (!$user) {
            return ['status' => false, 'pesan' => 'Data anggota tidak ditemukan.'];
        }

        $jumlahTanggungan = $this->cekPinjamanAktif($id_pengguna);
        if ($jumlahTanggungan > 0) {
            return [
                'status' => false, 
                'pesan' => "Maaf, anggota '{$user['nama_lengkap']}' masih memiliki pinjaman buku dan tidak dapat dihapus."
            ];
        }

        try {
            $this->db->beginTransaction();

            // 1. Simpan salinan data ke tabel `alumni` sebagai arsip resmi UKK
            $sqlAlumni = "INSERT INTO alumni (id_pengguna, nis, nama_lengkap, username, password, role, status) 
                          VALUES (:id_pengguna, :nis, :nama_lengkap, :username, :password, :role, 'Non-Aktif')";
            $stmtAlumni =$this->db->prepare($sqlAlumni);$stmtAlumni->execute([
                ':id_pengguna'  => $user['id_pengguna'],
                ':nis'          => $user['nis'],
                ':nama_lengkap' => $user['nama_lengkap'],
                ':username'     => $user['username'],
                ':password'     => $user['password'],
                ':role'         => $user['role']
            ]);

            // 2. Hapus data dari tabel `pengguna` asal 
            $sqlDelete = "DELETE FROM pengguna WHERE id_pengguna = :id_pengguna";
            $stmtDelete = $this->db->prepare($sqlDelete);
            $stmtDelete->execute([':id_pengguna' =>$id_pengguna]);

            $this->db->commit();

            return [
                'status' => true, 
                'pesan' => "Anggota '{$user['nama_lengkap']}' berhasil dihapus, dipindahkan ke alumni, dan riwayat transaksinya tetap tersimpan aman!"
            ];

        } catch (Exception $e) {$this->db->rollBack();
            return ['status' => false, 'pesan' => 'Terjadi kesalahan sistem: ' . $e->getMessage()];
        }
    }
}
?>