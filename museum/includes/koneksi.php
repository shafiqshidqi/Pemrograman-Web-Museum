<?php
// Konfigurasi database
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('db', 'museum_db');

// Koneksi ke database
$koneksi = mysqli_connect(host, user, pass, db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($koneksi, "utf8");

// Fungsi untuk mencegah SQL Injection
function escape($koneksi, $data) {
    return mysqli_real_escape_string($koneksi, trim($data));
}

// Fungsi untuk memulai session jika belum dimulai
function start_session_if_needed() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
?>