<!-- Register Siswa / Anggota Baru -->
<div class="max-w-md mx-auto px-4 py-10">
    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-[#EAF0EC] text-[#557565] flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid fa-id-card"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Anggota Siswa</h1>
            <p class="text-xs text-gray-500">Daftarkan diri Anda untuk mulai meminjam buku di perpustakaan sekolah.</p>
        </div>

        <form action="index.php?c=auth&a=register" method="POST" class="space-y-4 text-xs">
            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Nomor Induk Siswa (NIS)</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#8FA89B] focus-within:ring-2 focus-within:ring-[#8FA89B]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-hashtag text-gray-400 mr-2.5"></i>
                    <input type="text" name="nis" required placeholder="Contoh: 23241005" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Nama Lengkap</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#8FA89B] focus-within:ring-2 focus-within:ring-[#8FA89B]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-user text-gray-400 mr-2.5"></i>
                    <input type="text" name="nama_lengkap" required placeholder="Contoh: Siti Nurhaliza" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Username</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#8FA89B] focus-within:ring-2 focus-within:ring-[#8FA89B]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-at text-gray-400 mr-2.5"></i>
                    <input type="text" name="username" required placeholder="Pilih username unik" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Password</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#8FA89B] focus-within:ring-2 focus-within:ring-[#8FA89B]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-lock text-gray-400 mr-2.5"></i>
                    <input type="password" name="password" required placeholder="Buat password akun" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold text-xs transition shadow-xs">
                Selesaikan Pendaftaran
            </button>
        </form>

        <div class="text-center pt-2 border-t border-gray-100 text-xs">
            <p class="text-gray-500">
                Sudah memiliki akun anggota? <a href="index.php?c=auth&a=login" class="text-[#8FA89B] font-semibold hover:underline">Masuk disini</a>
            </p>
        </div>
    </div>
</div>
