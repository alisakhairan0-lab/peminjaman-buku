<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Transaksi.php';
require_once __DIR__ . '/../model/Kategori.php';
require_once __DIR__ . '/../model/Buku.php';

class LaporanController extends Controller {
    public function index() {
        $this->requireAdmin();

        $transaksiModel = new Transaksi();
        $kategoriModel = new Kategori();
        $bukuModel = new Buku();

        $todayTransactions = $transaksiModel->getTodayTransactions();
        $categories = $kategoriModel->getWithBookCount();

        $data = [
            'pageTitle' => 'Laporan Perpustakaan & Ekspor Dokumen',
            'todayTransactions' => $todayTransactions,
            'categories' => $categories
        ];

        $this->view('admin/laporan/index', $data);
    }

    public function exportWord() {
        $this->requireAdmin();

        $transaksiModel = new Transaksi();
        $transaksiList = $transaksiModel->getTodayTransactions();
        $tanggalHariIni = date('d F Y');

        header("Content-Type: application/vnd.ms-word");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Laporan_Transaksi_Perpustakaan_" . date('Ymd') . ".doc");

        echo "<html>";
        echo "<head><meta charset='utf-8'><title>Laporan Transaksi Hari Ini</title>";
        echo "<style>
            body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; color: #000; }
            .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
            .kop h2 { margin: 0; font-size: 16pt; text-transform: uppercase; }
            .kop h3 { margin: 2px 0; font-size: 13pt; }
            .kop p { margin: 0; font-size: 10pt; font-style: italic; }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            th, td { border: 1px solid #000; padding: 6px 8px; font-size: 10pt; }
            th { background-color: #f2f2f2; text-align: center; }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .ttd-box { margin-top: 40px; float: right; width: 250px; text-align: center; }
        </style>";
        echo "</head><body>";

        echo "<div class='kop'>";
        echo "<h2>PEMERINTAH DAERAH PROVINSI - DINAS PENDIDIKAN</h2>";
        echo "<h3>PERPUSTAKAAN DIGITAL SMK NEGERI</h3>";
        echo "<h3>UJI KOMPETENSI KEAHLIAN (UKK) REKAYASA PERANGKAT LUNAK</h3>";
        echo "<p>Jalan Pendidikan No. 4, Telepon: (021) 8573381 - Email: perpustakaan@smk.sch.id</p>";
        echo "</div>";

        echo "<h3 style='text-align: center; text-transform: uppercase; margin-bottom: 5px;'>LAPORAN TRANSAKSI PEMINJAMAN BUKU HARI INI</h3>";
        echo "<p style='text-align: center; margin-top: 0; font-size: 11pt;'>Tanggal Cetak: " . $tanggalHariIni . "</p>";

        echo "<table>";
        echo "<thead><tr>";
        echo "<th>No</th>";
        echo "<th>ID Trx</th>";
        echo "<th>Nama Peminjam / NIS</th>";
        echo "<th>Daftar Buku</th>";
        echo "<th>Tgl Pengajuan</th>";
        echo "<th>Tgl Pinjam</th>";
        echo "<th>Batas Kembali</th>";
        echo "<th>Status</th>";
        echo "<th>Denda</th>";
        echo "</tr></thead><tbody>";

        if (empty($transaksiList)) {
            echo "<tr><td colspan='9' class='text-center'>Tidak ada transaksi pada tanggal hari ini.</td></tr>";
        } else {
            $no = 1;
            $totalDenda = 0;
            foreach ($transaksiList as $t) {
                $totalDenda += (int)$t['total_denda'];
                echo "<tr>";
                echo "<td class='text-center'>" . $no++ . "</td>";
                echo "<td class='text-center'>#" . $t['id_transaksi'] . "</td>";
                echo "<td>" . htmlspecialchars($t['nama_peminjam']) . " (" . $t['nis'] . ")</td>";
                echo "<td>" . htmlspecialchars($t['daftar_buku']) . "</td>";
                echo "<td class='text-center'>" . $t['tgl_pengajuan'] . "</td>";
                echo "<td class='text-center'>" . ($t['tgl_pinjam'] ?: '-') . "</td>";
                echo "<td class='text-center'>" . ($t['batas_kembali'] ?: '-') . "</td>";
                echo "<td class='text-center'>" . ucfirst($t['status']) . "</td>";
                echo "<td class='text-right'>Rp " . number_format($t['total_denda'], 0, ',', '.') . "</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan='8' style='font-weight: bold; text-align: right;'>Total Pendapatan Denda Hari Ini:</td>";
            echo "<td class='text-right' style='font-weight: bold;'>Rp " . number_format($totalDenda, 0, ',', '.') . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";

        echo "<div class='ttd-box'>";
        echo "<p>Mengetahui,<br>Kepala Perpustakaan SMK</p>";
        echo "<br><br><br>";
        echo "<p><b>( " . htmlspecialchars($_SESSION['nama'] ?? 'Petugas Perpustakaan') . " )</b><br>NIP/ID: 19850314 201001 1 008</p>";
        echo "</div>";

        echo "</body></html>";
        exit();
    }

    public function exportExcel() {
        $this->requireAdmin();

        $transaksiModel = new Transaksi();
        $transaksiList = $transaksiModel->getTodayTransactions();

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Laporan_Transaksi_Hari_Ini_" . date('Ymd') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'>";
        echo "<tr><th colspan='9' style='font-size: 16px; background-color: #d1e7dd; height: 35px; text-align: center;'>LAPORAN TRANSAKSI PERPUSTAKAAN HARI INI (" . date('d-m-Y') . ")</th></tr>";
        echo "<tr style='background-color: #f8f9fa; font-weight: bold;'>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Judul Buku</th>
                <th>Tgl Pengajuan</th>
                <th>Batas Kembali</th>
                <th>Status</th>
                <th>Total Denda (Rp)</th>
              </tr>";

        $no = 1;
        $totalDenda = 0;
        foreach ($transaksiList as $t) {
            $totalDenda += (int)$t['total_denda'];
            echo "<tr>
                    <td align='center'>" . $no++ . "</td>
                    <td align='center'>TRX-" . $t['id_transaksi'] . "</td>
                    <td>" . htmlspecialchars($t['nama_peminjam']) . "</td>
                    <td align='center'>'" . $t['nis'] . "</td>
                    <td>" . htmlspecialchars($t['daftar_buku']) . "</td>
                    <td align='center'>" . $t['tgl_pengajuan'] . "</td>
                    <td align='center'>" . ($t['batas_kembali'] ?: '-') . "</td>
                    <td align='center'>" . ucfirst($t['status']) . "</td>
                    <td align='right'>" . $t['total_denda'] . "</td>
                  </tr>";
        }
        echo "<tr style='font-weight: bold; background-color: #e2e3e5;'>
                <td colspan='8' align='right'>TOTAL DENDA TERKUMPUL:</td>
                <td align='right'>Rp " . number_format($totalDenda, 0, ',', '.') . "</td>
              </tr>";
        echo "</table>";
        exit();
    }

    public function uploadLaporan() {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_laporan'])) {
            $file = $_FILES['file_laporan'];
            $allowed = ['doc', 'docx', 'xls', 'xlsx'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $targetDir = __DIR__ . '/../uploads/laporan/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $destination = $targetDir . 'laporan_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $this->setFlash('success', "File laporan berhasil diunggah dan diarsipkan ke server!");
                } else {
                    $this->setFlash('danger', 'Gagal memindahkan file yang diunggah.');
                }
            } else {
                $this->setFlash('danger', 'Hanya format file Word (.doc, .docx) dan Excel (.xls, .xlsx) yang diperbolehkan!');
            }
        }
        $this->redirect('index.php?c=laporan&a=index');
    }
}
?>
