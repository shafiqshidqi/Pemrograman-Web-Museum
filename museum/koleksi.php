<?php
require_once 'includes/koneksi.php';

// Ambil semua koleksi
$query = "SELECT * FROM koleksi ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

$judul_halaman = 'Koleksi';
include 'includes/header.php';
?>

<section class="section">
    <div class="container">
        <h2 class="section-title">Koleksi Museum</h2>
        <div class="grid">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <div class="card-image">
                    <img src="<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top object-cover" alt="<?= htmlspecialchars($row['nama']) ?>" style="height: 250px; object-fit: cover;">
                </div>
                <div class="card-content">
                    <h3><?php echo htmlspecialchars($row['nama']); ?></h3>
                    <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if(mysqli_num_rows($result) == 0): ?>
            <p style="text-align: center; grid-column: 1/-1; padding: 2rem;">Belum ada koleksi yang ditampilkan.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
mysqli_close($koneksi);
include 'includes/footer.php';
?>