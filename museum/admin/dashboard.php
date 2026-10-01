<?php
require_once '../includes/koneksi.php';
start_session_if_needed();

// Cek apakah sudah login
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// itung jumlah data
$query_koleksi = "SELECT COUNT(*) as total FROM koleksi";
$result_koleksi = mysqli_query($koneksi, $query_koleksi);
$total_koleksi = mysqli_fetch_assoc($result_koleksi)['total'];

$query_event = "SELECT COUNT(*) as total FROM event";
$result_event = mysqli_query($koneksi, $query_event);
$total_event = mysqli_fetch_assoc($result_event)['total'];

$base_url = '../';
$judul_halaman = 'Dashboard Admin';
include '../includes/header.php';
?>

<div class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h2>Dashboard Admin</h2>
                <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

        <div class="dashboard-menu">
            <a href="koleksi_manage.php" class="menu-item">
                <h3>Kelola Koleksi</h3>
                <p><?php echo $total_koleksi; ?> koleksi tersedia</p>
                <p style="color: #666; margin-top: 1rem;">Tambah, edit, atau hapus koleksi museum</p>
            </a>

            <a href="event_manage.php" class="menu-item">
                <h3>Kelola Event</h3>
                <p><?php echo $total_event; ?> event terdaftar</p>
                <p style="color: #666; margin-top: 1rem;">Tambah, edit, atau hapus event museum</p>
            </a>
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="../index.php" class="btn">Lihat Website</a>
        </div>
    </div>
</div>

<?php
mysqli_close($koneksi);
include '../includes/footer.php';
?>