<!-- Detail & Proses Transaksi -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="mb-4">
        <a href="index.php?c=transaksi&a=index" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Transaksi
        </a>
    </div>

    <!-- Header Transaksi Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 pb-4 gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Transaksi #<?= $transaksi['id_transaksi'] ?></h1>
                    <?php 
                        $statusTrans = trim($transaksi['status'] ?? 'menunggu');
                        if ($statusTrans === '') $statusTrans = 'dipinjam';

                        $badgeBg = 'bg-gray-100 text-gray-800';
                        if ($statusTrans === 'menunggu') $badgeBg = 'bg-amber-100 text-amber-800';
                        elseif ($statusTrans === 'dipinjam') $badgeBg = 'bg-sky-100 text-sky-800';
                        elseif ($statusTrans === 'menunggu_kembali') $badgeBg = 'bg-purple-100 text-purple-800';
                        elseif ($statusTrans === 'dikembalikan') $badgeBg = 'bg-emerald-100 text-emerald-800';
                        elseif ($statusTrans === 'ditolak') $badgeBg = 'bg-red-100 text-red-800';
                    ?>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold <?= $badgeBg ?>">
                        Status: <?= $statusTrans === 'menunggu_kembali' ? 'Menunggu Konfirmasi' : ucfirst($statusTrans) ?>
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Diajukan pada: <strong><?= !empty($transaksi['tgl_pengajuan']) ? date('d F Y', strtotime($transaksi['tgl_pengajuan'])) : '-' ?></strong></p>
            </div>

            <div class="text-left sm:text-right text-xs text-gray-500 space-y-0.5">
                <span class="block">Peminjam: <strong class="text-gray-900"><?= htmlspecialchars($pengguna['nama_lengkap'] ?? $transaksi['nama_peminjam'] ?? '-') ?></strong></span>
                <span class="block">NIS: <code class="bg-gray-100 px-1 py-0.5 rounded text-gray-700"><?= htmlspecialchars($pengguna['nis'] ?? $transaksi['nis'] ?? '-') ?></code></span>
            </div>
        </div>

        <!-- Books List in this transaction -->
        <div class="space-y-3">
            <h3 class="font-bold text-gray-800 text-sm">Daftar Buku dalam Peminjaman Ini:</h3>
            <div class="border border-gray-200 rounded-2xl divide-y divide-gray-100 overflow-hidden text-xs">
                <?php foreach ($detailBuku as $b): ?>
                    <div class="p-3.5 flex items-center justify-between hover:bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-10 bg-[#EAF0EC] rounded text-[#557565] flex items-center justify-center font-bold text-xs">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900 block"><?= htmlspecialchars($b['judul']) ?></strong>
                                <span class="text-gray-500 text-[11px]">Penulis: <?= htmlspecialchars($b['penulis']) ?> • <?= htmlspecialchars($b['nama_kategori'] ?? 'Umum') ?></span>
                            </div>
                        </div>
                        <span class="text-gray-400 font-mono text-[11px]">1 Eksemplar</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Loan Meta Information -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50 rounded-2xl p-4 text-xs border border-gray-100">
            <div>
                <span class="text-gray-400 block mb-0.5">Tanggal Pinjam:</span>
                <strong class="text-gray-800"><?= !empty($transaksi['tgl_pinjam']) ? date('d M Y', strtotime($transaksi['tgl_pinjam'])) : '-' ?></strong>
            </div>
            <div>
                <span class="text-gray-400 block mb-0.5">Batas Pengembalian:</span>
                <strong class="text-gray-800"><?= !empty($transaksi['batas_kembali']) ? date('d M Y', strtotime($transaksi['batas_kembali'])) : '-' ?></strong>
            </div>
            <div>
                <span class="text-gray-400 block mb-0.5">Tanggal Kembali Aktual:</span>
                <strong class="text-gray-800"><?= !empty($transaksi['tgl_kembali']) ? date('d M Y', strtotime($transaksi['tgl_kembali'])) : '-' ?></strong>
            </div>
        </div>

        <!-- Denda Information -->
        <?php if (($transaksi['total_denda'] ?? 0) > 0): ?>
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center justify-between">
                <div>
                    <strong class="block text-sm">Denda Keterlambatan Tercatat</strong>
                    <span class="text-[11px]">Terkena sanksi denda karena terlambat mengembalikan buku dari batas waktu.</span>
                </div>
                <span class="text-lg font-bold">Rp <?= number_format($transaksi['total_denda'], 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>

        <!-- Action Panel with Strict Flow Validation -->
        <div class="pt-4 border-t border-gray-100">
            <?php if ($statusTrans === 'menunggu'): ?>
                <!-- Status Menunggu Persetujuan Peminjaman -->
                <div class="space-y-4">
                    <h3 class="font-bold text-gray-800 text-sm">Persetujuan Transaksi (Approval)</h3>
                    <form action="index.php?c=transaksi&a=approve" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs items-end">
                        <input type="hidden" name="id_transaksi" value="<?= $transaksi['id_transaksi'] ?>">
                        <div class="space-y-1">
                            <label class="font-semibold text-gray-700">Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-white">
                        </div>
                        <div class="space-y-1">
                            <label class="font-semibold text-gray-700">Durasi Peminjaman</label>
                            <select name="durasi_hari" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-white">
                                <option value="7" selected>7 Hari (Standar Siswa)</option>
                                <option value="14">14 Hari (2 Minggu)</option>
                                <option value="3">3 Hari (Ujian Singkat)</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="flex-grow py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition">
                                <i class="fa-solid fa-check mr-1"></i> Setujui Pinjam
                            </button>
                            <a href="index.php?c=transaksi&a=reject&id=<?= $transaksi['id_transaksi'] ?>" onclick="return confirm('Tolak pengajuan peminjaman ini?');" class="py-2 px-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 font-semibold transition">
                                Tolak
                            </a>
                        </div>
                    </form>
                </div>

            <?php elseif ($statusTrans === 'menunggu_kembali'): ?>
                <!-- HANYA MUNCUL JIKA SISWA SUDAH AJUKAN KEMBALI -->
                <?php 
                    $dendaPerHari = 1000;
                    $selisihHari = 0;
                    $estimasiDenda = 0;
                    if (!empty($transaksi['batas_kembali'])) {
                        $batas = strtotime($transaksi['batas_kembali']);
                        $sekarang = strtotime(date('Y-m-d'));
                        if ($sekarang > $batas) {
                            $selisihHari = ceil(($sekarang - $batas) / (60 * 60 * 24));
                            $estimasiDenda = $selisihHari * $dendaPerHari * count($detailBuku);
                        }
                    }
                ?>
                <div class="space-y-4">
                    <div class="p-4 rounded-2xl bg-purple-50 border border-purple-200 text-purple-900 text-xs">
                        <strong class="block text-sm font-bold mb-1">Pengajuan Pengembalian oleh Siswa</strong>
                        <span>Siswa telah mengajukan pengembalian buku. Silakan konfirmasi dan proses pengembalian di bawah ini.</span>
                    </div>

                    <h3 class="font-bold text-gray-800 text-sm">Form Konfirmasi Pengembalian</h3>
                    <form action="index.php?c=transaksi&a=kembalikan" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs items-end">
                        <input type="hidden" name="id_transaksi" value="<?= $transaksi['id_transaksi'] ?>">
                        <div class="space-y-1">
                            <label class="font-semibold text-gray-700">Tanggal Pengembalian</label>
                            <input type="date" name="tgl_kembali" value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-white">
                        </div>
                        <div class="space-y-1">
                            <label class="font-semibold text-gray-700">Total Denda (Rp) <?= $selisihHari > 0 ? "<span class='text-red-500'>(Terlambat {$selisihHari} hari)</span>" : '' ?></label>
                            <input type="number" name="total_denda" value="<?= $estimasiDenda ?>" min="0" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-white font-mono">
                        </div>
                        <div>
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold transition shadow-xs">
                                <i class="fa-solid fa-arrow-down-left-and-up-right-to-center mr-1"></i> Konfirmasi Pengembalian
                            </button>
                        </div>
                    </form>
                </div>

            <?php elseif ($statusTrans === 'dipinjam'): ?>
                <!-- TERKUNCI: MUNCUL KOTAK KUNING JIKA SISWA BELUM MENGAJUKAN PENGEMBALIAN -->
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs space-y-2">
                    <div class="flex items-center gap-2 font-bold text-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Peringatan: Belum Ada Pengajuan dari Siswa</span>
                    </div>
                    <p class="text-[11px] leading-relaxed">
                        Buku ini masih dalam status <strong>Dipinjam</strong> dan siswa <strong>belum mengajukan pengembalian</strong> dari akun mereka. Tombol konfirmasi dikunci secara otomatis sampai siswa menekan tombol pengembalian buku.
                    </p>
                </div>

            <?php else: ?>
                <div class="text-xs text-gray-500 flex items-center justify-between">
                    <span>Transaksi ini telah selesai dan diarsipkan.</span>
                    <a href="index.php?c=laporan&a=exportWord" class="text-[#8FA89B] font-semibold hover:underline">
                        <i class="fa-solid fa-file-word mr-1"></i> Unduh Berita Acara / Laporan
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>