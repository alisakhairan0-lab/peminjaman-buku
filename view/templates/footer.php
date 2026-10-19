</main>
<!-- LibraryVerse Authentic School Library Footer -->
<footer class="bg-white border-t border-gray-200 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-[#557565] flex items-center justify-center text-white text-sm font-bold shadow-xs">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base">LibraryVerse</h3>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Perpustakaan Digital Sekolah Menengah Kejuruan. Menyediakan ribuan referensi kejuruan dan literasi umum untuk mendukung kemandirian belajar dan keunggulan siswa.
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-400 pt-1">
                    <span class="inline-flex items-center gap-1 text-[#557565] font-medium"><i class="fa-solid fa-circle-check"></i> Layanan Peminjaman Daring</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1 text-gray-500"><i class="fa-solid fa-book-bookmark"></i> 15 Kategori Buku</span>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Koleksi Kejuruan SMK</h4>
                <ul class="space-y-2 text-xs text-gray-600">
                    <li><a href="index.php?c=katalog&a=index&kategori=1" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-laptop-code text-[10px]"></i> Rekayasa Perangkat Lunak</a></li>
                    <li><a href="index.php?c=katalog&a=index&kategori=2" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-network-wired text-[10px]"></i> Teknik Komputer & Jaringan</a></li>
                    <li><a href="index.php?c=katalog&a=index&kategori=3" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-calculator text-[10px]"></i> Akuntansi & Keuangan</a></li>
                    <li><a href="index.php?c=katalog&a=index&kategori=4" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-briefcase text-[10px]"></i> Manajemen Perkantoran</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Literasi & Pengetahuan</h4>
                <ul class="space-y-2 text-xs text-gray-600">
                    <li><a href="index.php?c=katalog&a=index&kategori=9" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-book text-[10px]"></i> Novel & Fiksi Remaja</a></li>
                    <li><a href="index.php?c=katalog&a=index&kategori=10" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-feather text-[10px]"></i> Sastra & Puisi Nusantara</a></li>
                    <li><a href="index.php?c=katalog&a=index&kategori=11" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-compass text-[10px]"></i> Pengembangan Diri</a></li>
                    <li><a href="index.php?c=katalog&a=index&kategori=14" class="hover:text-[#557565] transition flex items-center gap-1.5"><i class="fa-solid fa-globe text-[10px]"></i> Ensiklopedia Umum</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Jam Layanan Pustaka</h4>
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 text-xs space-y-2 text-gray-600">
                    <p class="flex justify-between"><span>Senin - Jumat:</span> <strong class="text-gray-900">07:30 - 16:00 WIB</strong></p>
                    <p class="flex justify-between"><span>Sabtu:</span> <strong class="text-gray-900">08:00 - 13:00 WIB</strong></p>
                    <p class="flex justify-between"><span>Minggu & Hari Libur:</span> <span class="text-rose-600 font-semibold">Tutup</span></p>
                    <div class="border-t border-gray-200 pt-2 mt-2 text-[11px] text-[#557565] font-medium flex items-center gap-1">
                        <i class="fa-solid fa-clock"></i> Peminjaman Daring Aktif 24 Jam
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-3">
            <p>&copy; <?= date('Y') ?> LibraryVerse — Perpustakaan Digital SMK. Seluruh hak cipta dilindungi.</p>
            <p>Membuka Cakrawala Pengetahuan Digital bagi Generasi Vokasi Berprestasi</p>
        </div>
    </div>
</footer>

<!-- Floating Scroll To Top Button -->
<button id="scrollToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 hidden z-50 p-3.5 rounded-2xl bg-[#557565] hover:bg-[#435e51] text-white shadow-lg transition-all" title="Kembali ke atas">
    <i class="fa-solid fa-arrow-up"></i>
</button>

<script>
window.addEventListener('scroll', function() {
    const btn = document.getElementById('scrollToTopBtn');
    if (btn) {
        if (window.scrollY > 250) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    }
});
</script>

</body>
</html>
