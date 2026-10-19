<!-- Login Administrator / Petugas Perpustakaan -->
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-[#FDF0ED] text-[#E8A598] flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Login Administrator</h1>
            <p class="text-xs text-gray-500">Panel khusus pengelola perpustakaan untuk CRUD buku, anggota, transaksi & laporan.</p>
        </div>

        <form action="index.php?c=auth&a=loginAdmin" method="POST" class="space-y-4 text-xs">
            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Username Admin</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#E8A598] focus-within:ring-2 focus-within:ring-[#E8A598]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-user-shield text-gray-400 mr-2.5"></i>
                    <input type="text" name="username" required autocomplete="off" placeholder="Masukkan username admin" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Password Admin</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#E8A598] focus-within:ring-2 focus-within:ring-[#E8A598]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-key text-gray-400 mr-2.5"></i>
                    <input type="password" name="password" required autocomplete="new-password" placeholder="Masukkan password admin" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-[#E8A598] hover:bg-[#d89386] text-white font-bold text-xs transition shadow-xs">
                Masuk ke Panel Administrator
            </button>
        </form>

        <div class="text-center pt-2 border-t border-gray-100 text-xs">
            <a href="index.php?c=auth&a=login" class="text-gray-500 hover:text-gray-800 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Login Siswa
            </a>
        </div>
    </div>
</div>