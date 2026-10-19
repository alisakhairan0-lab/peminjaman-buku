<!-- Admin Dashboard -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#E8A598] uppercase tracking-wider">Pusat Kendali Perpustakaan</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Dashboard Administrator</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Kelola koleksi buku, data siswa, verifikasi peminjaman, serta cetak laporan transaksi.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="index.php?c=buku&a=tambah" class="px-3.5 py-2 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-semibold transition flex items-center gap-1.5 shadow-xs">
                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Buku
            </a>
            <a href="index.php?c=laporan&a=index" class="px-3.5 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5 shadow-xs">
                <i class="fa-solid fa-file-word text-[10px] text-blue-600"></i> Ekspor Laporan
            </a>
        </div>
    </div>

    <!-- Admin Metric Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
            <span class="text-[11px] text-gray-500 font-medium block">Total Buku</span>
            <span class="text-2xl font-bold text-gray-900 block mt-1"><?= $totalBuku ?></span>
            <span class="text-[10px] text-[#8FA89B] font-semibold mt-1 block"><i class="fa-solid fa-book mr-1"></i>Koleksi Aktif</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
            <span class="text-[11px] text-gray-500 font-medium block">Anggota Siswa</span>
            <span class="text-2xl font-bold text-gray-900 block mt-1"><?= $totalAnggota ?></span>
            <span class="text-[10px] text-[#A29BFE] font-semibold mt-1 block"><i class="fa-solid fa-users mr-1"></i>Terdaftar</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
            <span class="text-[11px] text-gray-500 font-medium block">Menunggu Konfirmasi</span>
            <span class="text-2xl font-bold text-amber-600 block mt-1"><?= $totalPending ?></span>
            <span class="text-[10px] text-amber-500 font-semibold mt-1 block"><i class="fa-solid fa-clock mr-1"></i>Perlu Verifikasi</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
            <span class="text-[11px] text-gray-500 font-medium block">Sedang Dipinjam</span>
            <span class="text-2xl font-bold text-[#8FA89B] block mt-1"><?= $totalActive ?></span>
            <span class="text-[10px] text-[#8FA89B] font-semibold mt-1 block"><i class="fa-solid fa-arrow-right-from-bracket mr-1"></i>Buku Beredar</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
            <span class="text-[11px] text-gray-500 font-medium block">Sudah Kembali</span>
            <span class="text-2xl font-bold text-emerald-600 block mt-1"><?= $totalReturned ?></span>
            <span class="text-[10px] text-emerald-500 font-semibold mt-1 block"><i class="fa-solid fa-circle-check mr-1"></i>Selesai</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
            <span class="text-[11px] text-gray-500 font-medium block">Kas Denda</span>
            <span class="text-lg font-bold text-rose-600 block mt-1">Rp <?= number_format($totalDenda, 0, ',', '.') ?></span>
            <span class="text-[10px] text-rose-500 font-semibold mt-1 block"><i class="fa-solid fa-coins mr-1"></i>Keterlambatan</span>
        </div>
    </div>

    <!-- Quick Navigation Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="index.php?c=buku&a=index" class="p-4 rounded-2xl bg-white border border-gray-200 hover:border-[#8FA89B] hover:shadow-xs transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#EAF0EC] text-[#557565] flex items-center justify-center text-lg">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div>
                <strong class="text-xs text-gray-800 block">Koleksi Buku</strong>
                <span class="text-[11px] text-gray-500">Tambah, ubah, hapus buku</span>
            </div>
        </a>

        <a href="index.php?c=anggota&a=index" class="p-4 rounded-2xl bg-white border border-gray-200 hover:border-[#A29BFE] hover:shadow-xs transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#F1F0FF] text-[#A29BFE] flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div>
                <strong class="text-xs text-gray-800 block">Kelola Anggota</strong>
                <span class="text-[11px] text-gray-500">Data siswa & akun peminjam</span>
            </div>
        </a>

        <a href="index.php?c=transaksi&a=index" class="p-4 rounded-2xl bg-white border border-gray-200 hover:border-amber-400 hover:shadow-xs transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#FAF5E8] text-[#D4A373] flex items-center justify-center text-lg">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <div>
                <strong class="text-xs text-gray-800 block">Peminjaman & Kembali</strong>
                <span class="text-[11px] text-gray-500">Approval, status, denda</span>
            </div>
        </a>

        <a href="index.php?c=laporan&a=index" class="p-4 rounded-2xl bg-white border border-gray-200 hover:border-emerald-400 hover:shadow-xs transition flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-file-export"></i>
            </div>
            <div>
                <strong class="text-xs text-gray-800 block">Laporan Word / Excel</strong>
                <span class="text-[11px] text-gray-500">Ekspor harian & arsip</span>
            </div>
        </a>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="p-5 sm:p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900 text-sm sm:text-base">Transaksi Terbaru Hari Ini</h3>
            <a href="index.php?c=transaksi&a=index" class="text-xs font-semibold text-[#8FA89B] hover:underline">
                Kelola Semua Transaksi <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">ID Trx</th>
                        <th class="px-5 py-3">Peminjam</th>
                        <th class="px-5 py-3">Buku yang Dipinjam</th>
                        <th class="px-5 py-3">Tgl Pengajuan</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($recentTransactions)): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada transaksi peminjaman.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentTransactions as $t): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono font-semibold text-gray-800">#<?= $t['id_transaksi'] ?></td>
                                <td class="px-5 py-3.5">
                                    <strong class="text-gray-900 block"><?= htmlspecialchars($t['nama_peminjam']) ?></strong>
                                    <span class="text-[10px] text-gray-400">NIS: <?= $t['nis'] ?></span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="line-clamp-1 max-w-xs" title="<?= htmlspecialchars($t['daftar_buku']) ?>">
                                        <?= htmlspecialchars($t['daftar_buku'] ?: 'Tidak ada buku') ?>
                                    </span>
                                </td>
                                <td class="px-5 py-3.5"><?= $t['tgl_pengajuan'] ?></td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $t['status'] === 'menunggu' ? 'bg-amber-100 text-amber-800' : ($t['status'] === 'dipinjam' ? 'bg-sky-100 text-sky-800' : ($t['status'] === 'dikembalikan' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800')) ?>">
                                        <?= ucfirst($t['status']) ?>
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="index.php?c=transaksi&a=detail&id=<?= $t['id_transaksi'] ?>" class="px-2.5 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                                        Periksa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
