<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($judul_halaman) ? $judul_halaman . ' - ' : ''; ?>Museum Nusantara</title>
    <link rel="stylesheet" href="<?php echo isset($base_url) ? $base_url : ''; ?>assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1 class="logo">Museum Nusantara</h1>
                <nav>
                    <ul>
                        <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>index.php">Beranda</a></li>
                        <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>koleksi.php">Koleksi</a></li>
                        <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>event.php">Event</a></li>
                        <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>tentang.php">Tentang</a></li>
                        <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>kunjungan.php">Informasi</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>