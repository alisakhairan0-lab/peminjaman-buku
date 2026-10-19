<!-- Admin CRUD Anggota (Siswa) - Index -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#A29BFE] uppercase tracking-wider">Manajemen Pengguna</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Kelola Anggota (Siswa)</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Data anggota perpustakaan yang memiliki hak akses untuk meminjam buku.
            </p>
        </div>

        <a href="index.php?c=anggota&a=tambah" class="px-4 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs self-start sm:self-auto">
            <i class="fa-solid fa-user-plus"></i> Tambah Anggota Siswa
        </a>
    </div>

    <!-- Search bar -->
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs flex items-center justify-between gap-4">
        <form action="index.php" method="GET" class="flex items-center gap-3 w-full sm:w-96">
            <input type="hidden" name="c" value="anggota">
            <input type="hidden" name="a" value="index">
            <div class="flex-grow flex items-center px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 focus-within:bg-white focus-within:border-[#8FA89B] text-xs">
                <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Cari nama, NIS, atau username..." class="w-full bg-transparent border-none focus:outline-none">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition shrink-0">
                Cari
            </button>
        </form>
        <span class="text-xs text-gray-500 shrink-0">Total: <strong><?= count($anggota) ?></strong> siswa</span>
    </div>

    <!-- Anggota Table -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">No</th>
                        <th class="px-5 py-3">Nama Lengkap</th>
                        <th class="px-5 py-3">NIS</th>
                        <th class="px-5 py-3">Username</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($anggota)): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400">Tidak ada anggota yang cocok dengan pencarian.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($anggota as $u): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono text-gray-400">#<?= $no++ ?></td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-[#EAF0EC] text-[#557565] flex items-center justify-center font-bold text-xs">
                                            <?= strtoupper(substr($u['nama_lengkap'], 0, 1)) ?>
                                        </div>
                                        <strong class="text-gray-900"><?= htmlspecialchars($u['nama_lengkap']) ?></strong>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 font-mono"><?= htmlspecialchars($u['nis']) ?></td>
                                <td class="px-5 py-3.5">@<?= htmlspecialchars($u['username']) ?></td>
                                
                                <!-- Status Badge (Aktif / Non-Aktif) -->
                                <td class="px-5 py-3.5">
                                    <?php if (($u['status'] ?? 'Aktif') === 'Aktif'): ?>
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-[10px] font-bold">
                                            Non-Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Tombol Aksi Lengkap -->
                                <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                    <!-- Tombol Toggle Status (Non-Aktifkan / Aktifkan) -->
                                    <?php if (($u['status'] ?? 'Aktif') === 'Aktif'): ?>
                                        <a href="index.php?c=anggota&a=toggleStatus&id=<?= $u['id_pengguna'] ?>" 
                                           class="px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 transition text-[11px] font-semibold inline-block" 
                                           title="Non-Aktifkan Siswa"
                                           onclick="return confirm('Yakin ingin menonaktifkan siswa <?= htmlspecialchars($u['nama_lengkap']) ?>? (Akan divalidasi jika masih ada tanggungan pinjaman buku)');">
                                            <i class="fa-solid fa-user-slash mr-1"></i> Non-Aktifkan
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?c=anggota&a=toggleStatus&id=<?= $u['id_pengguna'] ?>" 
                                           class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition text-[11px] font-semibold inline-block" 
                                           title="Aktifkan Kembali Siswa">
                                            <i class="fa-solid fa-user-check mr-1"></i> Aktifkan
                                        </a>
                                    <?php endif; ?>

                                    <!-- Tombol Edit -->
                                    <a href="index.php?c=anggota&a=edit&id=<?= $u['id_pengguna'] ?>" class="p-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition inline-block" title="Edit Data Anggota">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Tombol Hapus (Sudah disesuaikan pesannya) -->
                                    <a href="index.php?c=anggota&a=hapus&id=<?= $u['id_pengguna'] ?>" onclick="return confirm('Yakin Anda akan menghapus anggota ini?\n\nCatatan: Jika siswa masih meminjam buku, sistem akan menolak penghapusan.');" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition inline-block" title="Hapus Anggota">
                                        <i class="fa-solid fa-trash-can"></i>
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