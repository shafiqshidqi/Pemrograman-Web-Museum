<?php
require_once 'includes/koneksi.php';

$query_koleksi = "SELECT * FROM koleksi ORDER BY id DESC LIMIT 3";
$result_koleksi = mysqli_query($koneksi, $query_koleksi);

$query_event = "SELECT * FROM event ORDER BY tanggal DESC LIMIT 2";
$result_event = mysqli_query($koneksi, $query_event);

$judul_halaman = 'Beranda';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h2>Selamat Datang di Museum Nusantara</h2>
        <p>Jelajahi Kekayaan Budaya dan Sejarah Indonesia</p>
        <div class="hero-buttons">
            <a href="koleksi.php" class="btn">Lihat Koleksi</a>
            <a href="event.php" class="btn btn-secondary">Event Kami</a>
        </div>
    </div>
</section>

<!-- Koleksi Unggulan -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Koleksi Unggulan</h2>
        <div class="grid">
            <?php while($row = mysqli_fetch_assoc($result_koleksi)): ?>
            <div class="card">
                <div class="card-image">
                    <img src="<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top object-cover" alt="<?= htmlspecialchars($row['nama']) ?>" style="height: 250px; object-fit: cover;">
                </div>
                <div class="card-content">
                    <h3><?php echo htmlspecialchars($row['nama']); ?></h3>
                    <p><?php echo htmlspecialchars(substr($row['deskripsi'], 0, 100)); ?>...</p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="koleksi.php" class="btn">Lihat Semua Koleksi</a>
        </div>
    </div>
</section>

<!-- Event Terbaru -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Event Mendatang</h2>
        <div class="grid">
            <?php while($row = mysqli_fetch_assoc($result_event)): ?>
            <div class="card">
                <div class="card-image">
                    <img src="<?= htmlspecialchars($row['poster']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>" style="width: 100%;">
                </div>
                <div class="card-content">
                    <span class="card-date"><?php echo date('d F Y', strtotime($row['tanggal'])); ?></span>
                    <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                    <p><?php echo htmlspecialchars(substr($row['deskripsi'], 0, 100)); ?>...</p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="event.php" class="btn">Lihat Semua Event</a>
        </div>
    </div>
</section>

<?php
mysqli_close($koneksi);
include 'includes/footer.php';
?>