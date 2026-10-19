<!-- Login Tunggal Terpadu: Siswa & Petugas Perpustakaan -->
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-[#EAF0EC] text-[#557565] flex items-center justify-center text-xl mx-auto shadow-xs">
                <i class="fa-solid fa-right-to-bracket"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Login Perpustakaan</h1>
            <p class="text-xs text-gray-500">Silakan masukkan username atau NIS dan password akun Anda (Siswa maupun Petugas).</p>
        </div>

        <form action="index.php?c=auth&a=login" method="POST" class="space-y-4 text-xs">
            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Username atau NIS</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#557565] focus-within:ring-2 focus-within:ring-[#557565]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-user text-gray-400 mr-2.5"></i>
                    <input type="text" name="username" required autocomplete="off" placeholder="Contoh: budis atau admin" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Password / Kata Sandi</label>
                <div class="flex items-center px-3 py-2.5 rounded-xl border border-gray-200 focus-within:border-[#557565] focus-within:ring-2 focus-within:ring-[#557565]/20 transition bg-gray-50 focus-within:bg-white">
                    <i class="fa-solid fa-lock text-gray-400 mr-2.5"></i>
                    <input type="password" name="password" required autocomplete="new-password" placeholder="Masukkan kata sandi" class="w-full bg-transparent border-none text-gray-800 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-[#557565] hover:bg-[#435e51] text-white font-bold text-xs transition shadow-xs">
                Masuk ke Akun
            </button>
        </form>

        <div class="text-center pt-2 border-t border-gray-100 text-xs">
            <p class="text-gray-500">
                Belum punya akun siswa? <a href="index.php?c=auth&a=register" class="text-[#557565] font-semibold hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>