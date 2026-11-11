
<?php
// Admin CRUD Transaksi Peminjaman - Index
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">
                Sirkulasi Perpustakaan
            </span>

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                Kelola Transaksi Peminjaman
            </h1>

            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Persetujuan pengajuan pinjam, proses pengembalian buku, dan pencatatan denda keterlambatan.
            </p>
        </div>

        <a href="index.php?c=laporan&a=index"
           class="px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5 shadow-xs self-start sm:self-auto">
            <i class="fa-solid fa-file-word text-blue-600"></i>
            Laporan Hari Ini
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
        <form action="index.php"
              method="GET"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">

            <input type="hidden" name="c" value="transaksi">
            <input type="hidden" name="a" value="index">

            <!-- Pencarian -->
            <div class="flex items-center px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 focus-within:bg-white focus-within:border-[#8FA89B]">
                <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2"></i>

                <input
                    type="text"
                    name="q"
                    value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Cari nama / NIS / buku..."
                    class="w-full bg-transparent border-none focus:outline-none"
                >
            </div>

            <!-- Filter Status -->
            <div>
                <select name="status"
                        class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:outline-none">

                    <option value="">-- Semua Status --</option>

                    <option value="menunggu"
                        <?= ($selectedStatus ?? '') === 'menunggu' ? 'selected' : '' ?>>
                        Menunggu Konfirmasi
                    </option>

                    <option value="dipinjam"
                        <?= ($selectedStatus ?? '') === 'dipinjam' ? 'selected' : '' ?>>
                        Sedang Dipinjam
                    </option>

                    <option value="menunggu_kembali"
                        <?= ($selectedStatus ?? '') === 'menunggu_kembali' ? 'selected' : '' ?>>
                        Menunggu Pengembalian
                    </option>

                    <option value="dikembalikan"
                        <?= ($selectedStatus ?? '') === 'dikembalikan' ? 'selected' : '' ?>>
                        Sudah Dikembalikan
                    </option>

                    <option value="ditolak"
                        <?= ($selectedStatus ?? '') === 'ditolak' ? 'selected' : '' ?>>
                        Ditolak
                    </option>
                </select>
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <input
                    type="date"
                    name="start_date"
                    value="<?= htmlspecialchars($startDate ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:outline-none"
                    title="Tanggal Mulai"
                >
            </div>

            <!-- Tanggal Akhir -->
            <div>
                <input
                    type="date"
                    name="end_date"
                    value="<?= htmlspecialchars($endDate ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:outline-none"
                    title="Tanggal Akhir"
                >
            </div>

            <!-- Tombol Filter -->
            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    class="flex-grow py-2 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold transition">
                    Terapkan Filter
                </button>

                <a href="index.php?c=transaksi&a=index"
                   class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-500 text-center"
                   title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">

                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">ID Trx</th>
                        <th class="px-5 py-3">Peminjam</th>
                        <th class="px-5 py-3">Buku Dipinjam</th>
                        <th class="px-5 py-3">Petugas</th>
                        <th class="px-5 py-3">Tgl Pengajuan</th>
                        <th class="px-5 py-3">Tgl Pinjam / Batas</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Denda</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    <?php if (empty($transaksiList)): ?>
                        <tr>
                            <td colspan="9"
                                class="px-5 py-8 text-center text-gray-400">
                                Tidak ada data transaksi yang sesuai filter.
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($transaksiList as $t): ?>

                            <?php
                                $namaPeminjam = $t['nama_peminjam'] ?? '';
                                $nis = $t['nis'] ?? '';
                                $namaAdmin = $t['nama_admin'] ?? '';
                                $status = $t['status'] ?? 'menunggu';
                                $daftarBuku = $t['daftar_buku'] ?? '';
                                $denda = (float) ($t['calculated_denda'] ?? 0);
                                $idTransaksi = (int) ($t['id_transaksi'] ?? 0);
                            ?>

                            <tr class="hover:bg-gray-50/50 transition">

                                <!-- ID Transaksi -->
                                <td class="px-5 py-3.5 font-mono font-semibold text-gray-900">
                                    #<?= $idTransaksi ?>
                                </td>

                                <!-- Data Peminjam dari Tabel User -->
                                <td class="px-5 py-3.5">
                                    <?php if ($namaPeminjam !== ''): ?>

                                        <strong class="text-gray-900 block">
                                            <?= htmlspecialchars($namaPeminjam, ENT_QUOTES, 'UTF-8') ?>
                                        </strong>

                                        <span class="text-[10px] text-gray-400">
                                            NIS:
                                            <?= htmlspecialchars($nis ?: '-', ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                    <?php else: ?>

                                        <strong class="text-amber-600 block italic">
                                            Peminjam tidak tercatat
                                        </strong>

                                        <span class="text-[10px] text-gray-400">
                                            Data user tidak ditemukan
                                        </span>

                                    <?php endif; ?>
                                </td>

                                <!-- Daftar Buku -->
                                <td class="px-5 py-3.5 max-w-xs">
                                    <span
                                        class="line-clamp-2"
                                        title="<?= htmlspecialchars($daftarBuku, ENT_QUOTES, 'UTF-8') ?>">

                                        <?= htmlspecialchars(
                                            $daftarBuku ?: 'Buku tidak tercatat',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </span>
                                </td>

                                <!-- Data Petugas dari Tabel User -->
                                <td class="px-5 py-3.5">
                                    <?php if ($namaAdmin !== ''): ?>

                                        <span class="font-medium text-gray-800">
                                            <?= htmlspecialchars($namaAdmin, ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="text-gray-400 italic">
                                            Belum diproses
                                        </span>

                                    <?php endif; ?>
                                </td>

                                <!-- Tanggal Pengajuan -->
                                <td class="px-5 py-3.5">
                                    <?= htmlspecialchars($t['tgl_pengajuan'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                </td>

                                <!-- Tanggal Pinjam -->
                                <td class="px-5 py-3.5">
                                    <?php if (!empty($t['tgl_pinjam'])): ?>

                                        <span>
                                            <?= htmlspecialchars($t['tgl_pinjam'], ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                        <span class="block text-[10px] text-gray-400">
                                            s/d <?= htmlspecialchars($t['batas_kembali'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="text-gray-400 italic">
                                            Belum diproses
                                        </span>

                                    <?php endif; ?>
                                </td>

                                <!-- Status -->
                                <td class="px-5 py-3.5">
                                    <?php
                                        $statusClass = 'bg-gray-100 text-gray-800';

                                        if ($status === 'menunggu') {
                                            $statusClass = 'bg-amber-100 text-amber-800';
                                        } elseif ($status === 'dipinjam') {
                                            $statusClass = 'bg-sky-100 text-sky-800';
                                        } elseif ($status === 'menunggu_kembali') {
                                            $statusClass = 'bg-purple-100 text-purple-800';
                                        } elseif ($status === 'dikembalikan') {
                                            $statusClass = 'bg-emerald-100 text-emerald-800';
                                        } elseif ($status === 'ditolak') {
                                            $statusClass = 'bg-red-100 text-red-800';
                                        }
                                    ?>

                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $statusClass ?>">
                                        <?= htmlspecialchars(ucfirst($status), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>

                                <!-- Denda -->
                                <td class="px-5 py-3.5 font-semibold <?= $denda > 0 ? 'text-rose-600' : 'text-gray-400' ?>">
                                    Rp <?= number_format($denda, 0, ',', '.') ?>
                                </td>

                                <!-- Aksi -->
                                <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1">
                                    <?php if ($idTransaksi > 0): ?>
                                        <a
                                            href="index.php?c=transaksi&a=detail&id=<?= $idTransaksi ?>"
                                            class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition"
                                            title="Lihat detail dan proses">
                                            Detail / Proses
                                        </a>
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
