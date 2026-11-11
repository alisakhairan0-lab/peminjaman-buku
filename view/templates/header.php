<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Paksa browser agar selalu memuat ulang halaman dari server dan tidak memakai cache riwayat
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Perpustakaan Digital SMK Paket 4') ?></title>
    <!-- Tailwind CSS CDN for instant styling in XAMPP without build step -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pastel: {
                            bg: '#F8FAFC',
                            sage: '#2563EB',        /* Biru Utama (Primary Blue) */
                            sageLight: '#EFF6FF',   /* Biru Sangat Terang */
                            peach: '#0284C7',       /* Biru Laut / Sky Blue */
                            peachLight: '#E0F2FE',  /* Aksesori Biru Muda */
                            lavender: '#4F46E5',    /* Indigo / Biru Tua */
                            lavenderLight: '#E0E7FF',/* Indigo Terang */
                            sand: '#F0F9FF',        /* Latar Biru Halus */
                            card: '#FFFFFF',
                            text: '#1E293B',
                            muted: '#64748B',
                            border: '#E2E8F0'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; color: #1E293B; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Penimpaan CSS Utama untuk Warna Hex Manual */
        .bg-\[\#8FA89B\], .bg-\[\#557565\], .bg-\[\#6B8E7B\] { background-color: #2563EB !important; }
        .hover\:bg-\[\#789687\]:hover, .hover\:bg-\[\#435e51\]:hover { background-color: #1D4ED8 !important; }
        .text-\[\#557565\], .text-\[\#8FA89B\] { color: #2563EB !important; }
        .border-\[\#8FA89B\] { border-color: #3B82F6 !important; }
        .focus-within\:border-\[\#8FA89B\]:focus-within { border-color: #3B82F6 !important; }
        .bg-\[\#EAF0EC\] { background-color: #EFF6FF !important; }

        /* UNIVERSEL OVERRIDE: Menimpa SEMUA elemen berkelas emerald/hijau menjadi Biru */
        [class*="bg-emerald-"], [class*="bg-[#d1fae5]"], [class*="bg-[#ecfdf5]"] {
            background-color: #DBEAFE !important;
        }
        [class*="text-emerald-"], [class*="text-[#065f46]"] {
            color: #1E40AF !important;
        }
        [class*="border-emerald-"] {
            border-color: #93C5FD !important;
        }

        /* Tombol File Input */
        input[type="file"]::file-selector-button,
        input[type="file"]::-webkit-file-upload-button {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
            border: none !important;
        }
        input[type="file"]::file-selector-button:hover,
        input[type="file"]::-webkit-file-upload-button:hover {
            background-color: #1D4ED8 !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-[#F8FAFC] text-[#1E293B] antialiased">