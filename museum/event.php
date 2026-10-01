<?php
require_once 'includes/koneksi.php';

// Ambil semua event
$query = "SELECT * FROM event ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);

$judul_halaman = 'Event';
include 'includes/header.php';
?>

<section class="section">
    <div class="container">
        <h2 class="section-title">Event & Pameran</h2>
        <div class="grid">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <div class="card-image">
                    <img src="<?= htmlspecialchars($row['poster']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>" style="width: 100%;">
                </div>
                <div class="card-content">
                    <span class="card-date"><?php echo date('d F Y', strtotime($row['tanggal'])); ?></span>
                    <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                    <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if(mysqli_num_rows($result) == 0): ?>
            <p style="text-align: center; grid-column: 1/-1; padding: 2rem;">Belum ada event yang dijadwalkan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
mysqli_close($koneksi);
include 'includes/footer.php';
?>