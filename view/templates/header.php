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
                            bg: '#F8F9FA',
                            sage: '#8FA89B',
                            sageLight: '#EAF0EC',
                            peach: '#E8A598',
                            peachLight: '#FDF0ED',
                            lavender: '#A29BFE',
                            lavenderLight: '#F1F0FF',
                            sand: '#F7F5F0',
                            card: '#FFFFFF',
                            text: '#2D3748',
                            muted: '#718096',
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; color: #2D3748; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-[#F8F9FA] text-[#2D3748] antialiased">