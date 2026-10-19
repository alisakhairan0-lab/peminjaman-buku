<!-- Halaman Profile User / Admin -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div>
        <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Pengaturan Akun</span>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Profil Pengguna</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            Kelola data akun, informasi identitas, dan perbarui kata sandi Anda.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <!-- Profile Identity Card -->
        <div class="md:col-span-4">
            <div class="bg-white rounded-3xl p-6 border border-gray-200 text-center space-y-4 shadow-xs">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr <?= $userType === 'admin' ? 'from-[#FDF0ED] to-[#E8A598] text-[#E8A598]' : 'from-[#EAF0EC] to-[#8FA89B] text-[#557565]' ?> flex items-center justify-center text-3xl font-bold mx-auto shadow-inner">
                    <?= strtoupper(substr($userType === 'admin' ? ($user['nama_admin'] ?? 'A') : ($user['nama_lengkap'] ?? 'U'), 0, 1)) ?>
                </div>

                <div>
                    <h3 class="font-bold text-gray-900 text-base">
                        <?= htmlspecialchars($userType === 'admin' ? ($user['nama_admin'] ?? 'Administrator') : ($user['nama_lengkap'] ?? 'Siswa')) ?>
                    </h3>
                    <span class="text-xs text-gray-400 block mt-0.5">@<?= htmlspecialchars($user['username'] ?? '') ?></span>
                </div>

                <div class="pt-2">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold <?= $userType === 'admin' ? 'bg-[#FDF0ED] text-[#E8A598]' : 'bg-[#EAF0EC] text-[#557565]' ?>">
                        <?= $userType === 'admin' ? 'Administrator Perpustakaan' : 'Siswa / Anggota Perpustakaan' ?>
                    </span>
                </div>

                <div class="border-t border-gray-100 pt-4 text-xs text-left space-y-2 text-gray-600">
                    <?php if ($userType === 'user'): ?>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Nomor Induk (NIS):</span>
                            <strong class="text-gray-800"><?= htmlspecialchars($user['nis'] ?? '-') ?></strong>
                        </div>
                    <?php else: ?>
                        <div class="flex justify-between">
                            <span class="text-gray-400">ID Admin:</span>
                            <strong class="text-gray-800">ADM-00<?= $user['id_admin'] ?? 1 ?></strong>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status Akun:</span>
                        <span class="text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check text-[10px]"></i> Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="md:col-span-8">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs space-y-6">
                <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">
                    Perbarui Data Profil & Password
                </h3>

                <form action="index.php?c=auth&a=profile" method="POST" class="space-y-4 text-xs">
                    <?php if ($userType === 'admin'): ?>
                        <div class="space-y-1">
                            <label class="font-semibold text-gray-700">Nama Petugas / Administrator</label>
                            <input type="text" name="nama" required value="<?= htmlspecialchars($user['nama_admin'] ?? '') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="font-semibold text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama" required value="<?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                            </div>
                            <div class="space-y-1">
                                <label class="font-semibold text-gray-700">Nomor Induk Siswa (NIS)</label>
                                <input type="text" name="nis" required value="<?= htmlspecialchars($user['nis'] ?? '') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="space-y-1">
                        <label class="font-semibold text-gray-700">Username (Tidak Dapat Diubah)</label>
                        <input type="text" disabled value="<?= htmlspecialchars($user['username'] ?? '') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-1">
                        <label class="font-semibold text-gray-700">Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                        <span class="text-[11px] text-gray-400 block">Biarkan kosong jika Anda hanya ingin memperbarui nama/NIS.</span>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-semibold text-xs transition shadow-xs">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
