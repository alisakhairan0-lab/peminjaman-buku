<?php
$userType = $_SESSION['user_type'] ?? null;
$userName = $_SESSION['nama'] ?? '';
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$currentController = $_GET['c'] ?? 'landing';
$currentAction = $_GET['a'] ?? 'index';
?>
<!-- Top Notification Banner for Flash Messages -->
<?php if (isset($flash)): ?>
    <div class="bg-<?= $flash['type'] === 'danger' ? 'red-100 border-red-300 text-red-800' : ($flash['type'] === 'success' ? 'emerald-100 border-emerald-300 text-emerald-800' : 'sky-100 border-sky-300 text-sky-800') ?> border-b px-4 py-3 text-center text-sm font-medium flex items-center justify-center gap-2">
        <i class="fa-solid <?= $flash['type'] === 'danger' ? 'fa-circle-exclamation' : ($flash['type'] === 'success' ? 'fa-circle-check' : 'fa-circle-info') ?>"></i>
        <span><?= htmlspecialchars($flash['message']) ?></span>
    </div>
<?php endif; ?>

<!-- Main Header / Navigation -->
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Brand Logo -->
            <a href="index.php?c=landing&a=index" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#557565] to-[#8FA89B] flex items-center justify-center text-white shadow-xs transition-transform group-hover:scale-105">
                    <i class="fa-solid fa-book-open-reader text-lg"></i>
                </div>
                <div>
                    <span class="font-bold text-gray-900 text-base tracking-tight block leading-tight">LibraryVerse</span>
                    <span class="text-[11px] text-gray-500 block">Perpustakaan Digital SMK</span>
                </div>
            </a>

            <!-- RBAC Navigation Links -->
            <nav class="hidden md:flex items-center gap-1 text-sm font-medium text-gray-600">
                <a href="index.php?c=landing&a=index" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'landing') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                    <i class="fa-solid fa-house mr-1.5 text-xs"></i> Beranda
                </a>
                <a href="index.php?c=katalog&a=index" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'katalog') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                    <i class="fa-solid fa-book mr-1.5 text-xs"></i> Katalog Buku
                </a>

                <?php if ($userType === 'admin'): ?>
                    <a href="index.php?c=admin&a=dashboard" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'admin') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i> Dashboard Admin
                    </a>
                    <a href="index.php?c=buku&a=index" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'buku') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                        <i class="fa-solid fa-boxes-stacked mr-1.5 text-xs"></i> Kelola Buku
                    </a>
                    <a href="index.php?c=anggota&a=index" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'anggota') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i> Anggota
                    </a>
                    <a href="index.php?c=transaksi&a=index" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'transaksi' && $currentAction !== 'riwayatUser') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                        <i class="fa-solid fa-receipt mr-1.5 text-xs"></i> Transaksi
                    </a>
                    <a href="index.php?c=laporan&a=index" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'laporan') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                        <i class="fa-solid fa-file-word mr-1.5 text-xs"></i> Laporan
                    </a>
                <?php elseif ($userType === 'user'): ?>
                    <a href="index.php?c=user&a=dashboard" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentController === 'user') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                        <i class="fa-solid fa-clock-rotate-left mr-1.5 text-xs"></i> Riwayat Siswa
                    </a>
                    <!-- <a href="index.php?c=transaksi&a=riwayatUser" class="px-3 py-2 rounded-xl hover:text-gray-900 hover:bg-gray-100 transition <?= ($currentAction === 'riwayatUser') ? 'bg-[#EAF0EC] text-[#557565] font-semibold' : '' ?>">
                        <i class="fa-solid fa-clock-rotate-left mr-1.5 text-xs"></i> Riwayat Pinjam
                    </a> -->
                <?php endif; ?>
            </nav>

            <!-- Right Actions (Cart + Profile/Auth) -->
            <div class="flex items-center gap-3">
                <!-- Cart Button: Only for Siswa or Guest (Not Admin) -->
                <?php if ($userType !== 'admin'): ?>
                    <a href="index.php?c=keranjang&a=index" class="relative p-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition flex items-center gap-1.5 text-sm font-medium" title="Keranjang Peminjaman">
                        <i class="fa-solid fa-cart-shopping text-gray-600"></i>
                        <span class="hidden sm:inline">Keranjang</span>
                        <?php if ($cartCount > 0): ?>
                            <span class="w-5 h-5 rounded-full bg-[#E8A598] text-white text-xs font-bold flex items-center justify-center">
                                <?= $cartCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($userType)): ?>
                    <!-- Profile & Logout Buttons -->
                    <div class="flex items-center gap-2">
                        <a href="index.php?c=auth&a=profile" class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium transition">
                            <div class="w-7 h-7 rounded-xl <?= $userType === 'admin' ? 'bg-[#FDF0ED] text-[#E8A598]' : 'bg-[#EAF0EC] text-[#557565]' ?> flex items-center justify-center text-xs font-bold">
                                <?= strtoupper(substr($userName, 0, 1)) ?>
                            </div>
                            <span class="max-w-[120px] truncate hidden sm:inline font-semibold"><?= htmlspecialchars($userName) ?></span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-white text-gray-600 uppercase font-bold">
                                <?= $userType === 'admin' ? 'Petugas' : 'Siswa' ?>
                            </span>
                        </a>
                        <a href="index.php?c=auth&a=logout" onclick="return confirm('Apakah Anda yakin ingin logout?');" class="p-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition text-sm" title="Logout">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Single Unified Login Button -->
                    <div class="flex items-center gap-2">
                        <a href="index.php?c=auth&a=login" class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-[#557565] hover:bg-[#435e51] transition shadow-xs flex items-center gap-1.5" title="Login Siswa & Petugas">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Login</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
<main class="flex-grow">
