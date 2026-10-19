<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Header Dashboard -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Dashboard Siswa</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Selamat Datang, <?= htmlspecialchars($_SESSION['nama'] ?? $_SESSION['user']['nama_lengkap'] ?? 'Siswa') ?>!</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola peminjaman buku perpustakaan digital kamu dengan mudah di sini.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="index.php?c=katalog&a=index" class="px-4 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                <i class="fa-solid fa-book"></i> Pinjam Buku Baru
            </a>
        </div>
    </div>

    <!-- Tabel Peminjaman / Riwayat di Dashboard -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900">Status Peminjaman & Riwayat</h2>
            <a href="index.php?c=user&a=riwayat" class="text-xs font-semibold text-[#8FA89B] hover:underline">Lihat Semua Riwayat</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">ID Trx</th>
                        <th class="px-5 py-3">Buku yang Dipinjam</th>
                        <th class="px-5 py-3">Tgl Pengajuan</th>
                        <th class="px-5 py-3">Tgl Pinjam / Batas</th>
                        <th class="px-5 py-3">Tgl Dikembalikan</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Denda</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($myTransactions)): ?>
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                                Anda belum memiliki riwayat transaksi peminjaman.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($myTransactions as $t): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono font-semibold text-gray-900">#<?= $t['id_transaksi'] ?></td>
                                <td class="px-5 py-3.5 font-medium text-gray-900 max-w-sm"><?= htmlspecialchars($t['daftar_buku'] ?? '-') ?></td>
                                <td class="px-5 py-3.5"><?= $t['tgl_pengajuan'] ?? '-' ?></td>
                                <td class="px-5 py-3.5">
                                    <?= $t['tgl_pinjam'] ?? '-' ?> <br>
                                    <span class="text-[10px] text-gray-400">s/d <?= $t['batas_kembali'] ?? '-' ?></span>
                                </td>
                                <td class="px-5 py-3.5"><?= $t['tgl_kembali'] ?: '-' ?></td>
                                <td class="px-5 py-3.5">
                                    <?php 
                                        $badgeClass = 'bg-gray-100 text-gray-800';
                                        if ($t['status'] === 'menunggu') $badgeClass = 'bg-amber-100 text-amber-800';
                                        elseif ($t['status'] === 'dipinjam') $badgeClass = 'bg-sky-100 text-sky-800';
                                        elseif ($t['status'] === 'menunggu_kembali') $badgeClass = 'bg-purple-100 text-purple-800';
                                        elseif ($t['status'] === 'dikembalikan') $badgeClass = 'bg-emerald-100 text-emerald-800';
                                        elseif ($t['status'] === 'ditolak') $badgeClass = 'bg-red-100 text-red-800';
                                    ?>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $badgeClass ?>">
                                        <?= $t['status'] === 'menunggu_kembali' ? 'Menunggu Konfirmasi' : ucfirst($t['status']) ?>
                                    </span>
                                </td>
                                <!-- PERBAIKAN: Menggunakan calculated_denda agar denda real-time muncul -->
                                <td class="px-5 py-3.5 font-semibold <?= ($t['calculated_denda'] ?? 0) > 0 ? 'text-rose-600' : 'text-gray-400' ?>">
                                    Rp <?= number_format($t['calculated_denda'] ?? 0, 0, ',', '.') ?>
                                </td>
                                <!-- Kolom Aksi Pengembalian oleh Siswa -->
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <?php if ($t['status'] === 'dipinjam'): ?>
                                        <a href="index.php?c=user&a=ajukanKembali&id=<?= $t['id_transaksi'] ?>" 
                                           onclick="return confirm('Yakin ingin mengajukan pengembalian buku ini ke petugas?');"
                                           class="px-3 py-1.5 rounded-lg bg-[#8FA89B] hover:bg-[#789687] text-white text-[11px] font-semibold transition inline-block">
                                            Ajukan Kembali
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>