<!-- Admin CRUD Anggota - Tambah Anggota Siswa -->
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="mb-4">
        <a href="index.php?c=anggota&a=index" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Anggota
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs space-y-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Anggota Siswa Baru</h1>
            <p class="text-xs text-gray-500 mt-1">Daftarkan siswa agar dapat mengakses katalog dan melakukan peminjaman buku.</p>
        </div>

        <form action="index.php?c=anggota&a=tambah" method="POST" class="space-y-4 text-xs">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Nomor Induk Siswa (NIS) <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" required placeholder="Contoh: 23241010" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Nama Lengkap Siswa <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" required placeholder="Contoh: Fajar Ramadhan" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="username" required placeholder="Pilih username" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Password Awal <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required placeholder="Masukkan password" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="index.php?c=anggota&a=index" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold text-xs transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold text-xs transition shadow-xs">
                    Simpan Anggota
                </button>
            </div>
        </form>
    </div>
</div>
