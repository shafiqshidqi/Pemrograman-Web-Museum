<?php
require_once '../includes/koneksi.php';
start_session_if_needed();

// Cek apakah sudah login
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

// Proses Tambah
if(isset($_POST['tambah'])) {
    $judul = escape($koneksi, $_POST['judul']);
    $poster = escape($koneksi, $_POST['poster']);
    $tanggal = escape($koneksi, $_POST['tanggal']);
    $deskripsi = escape($koneksi, $_POST['deskripsi']);
    
    $query = "INSERT INTO event (judul, poster, tanggal, deskripsi) VALUES ('$judul', '$poster', '$tanggal', '$deskripsi')";
    if(mysqli_query($koneksi, $query)) {
        $success = 'Event berhasil ditambahkan!';
    } else {
        $error = 'Gagal menambahkan event!';
    }
}

// Proses Hapus
if(isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $query = "DELETE FROM event WHERE id = $id";
    if(mysqli_query($koneksi, $query)) {
        $success = 'Event berhasil dihapus!';
    } else {
        $error = 'Gagal menghapus event!';
    }
}

// Proses Edit
if(isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $judul = escape($koneksi, $_POST['judul']);
    $poster = escape($koneksi, $_POST['poster']);
    $tanggal = escape($koneksi, $_POST['tanggal']);
    $deskripsi = escape($koneksi, $_POST['deskripsi']);
    
    $query = "UPDATE event SET judul='$judul', poster='$poster', tanggal='$tanggal', deskripsi='$deskripsi' WHERE id=$id";
    if(mysqli_query($koneksi, $query)) {
        $success = 'Event berhasil diupdate!';
    } else {
        $error = 'Gagal mengupdate event!';
    }
}

// Ambil data untuk edit
$edit_data = null;
if(isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $query = "SELECT * FROM event WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $edit_data = mysqli_fetch_assoc($result);
}

// Ambil semua event
$query = "SELECT * FROM event ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);

$base_url = '../';
$judul_halaman = 'Kelola Event';
include '../includes/header.php';
?>

<div class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h2>Kelola Event</h2>
            <a href="dashboard.php" class="btn-logout">← Kembali</a>
        </div>

        <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Form Tambah/Edit -->
        <div class="table-container" style="margin-bottom: 2rem;">
            <h3><?php echo $edit_data ? 'Edit Event' : 'Tambah Event Baru'; ?></h3>
            <form method="POST" action="">
                <?php if($edit_data): ?>
                <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Judul Event</label>
                    <input type="text" name="judul" required value="<?php echo $edit_data ? htmlspecialchars($edit_data['judul']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Nama File Poster (contoh: event1.jpg)</label>
                    <input type="text" name="poster" required value="<?php echo $edit_data ? htmlspecialchars($edit_data['poster']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Tanggal Event</label>
                    <input type="date" name="tanggal" required value="<?php echo $edit_data ? $edit_data['tanggal'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" required><?php echo $edit_data ? htmlspecialchars($edit_data['deskripsi']) : ''; ?></textarea>
                </div>
                
                <div style="display: flex;">
                    <button type="submit" name="<?php echo $edit_data ? 'edit' : 'tambah'; ?>" class="btn-submit">
                        <?php echo $edit_data ? 'Update Event' : 'Tambah Event'; ?>
                    </button>
                    
                    <?php if($edit_data): ?>
                    <a href="event_manage.php" class="btn-back" style="display: inline-block; margin-left: 1rem;">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Event -->
        <div class="table-container">
            <h3>Daftar Event</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Poster</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td><?php echo htmlspecialchars($row['poster']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                        <td><?php echo htmlspecialchars(substr($row['deskripsi'], 0, 60)); ?>...</td>
                        <td>
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            <a href="?hapus=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada event</td>
                    </tr>
                    <?php else: mysqli_data_seek($result, 0); endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
mysqli_close($koneksi);
include '../includes/footer.php';
?>