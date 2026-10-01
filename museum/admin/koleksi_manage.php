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
    $nama = escape($koneksi, $_POST['nama']);
    $gambar = escape($koneksi, $_POST['gambar']);
    $deskripsi = escape($koneksi, $_POST['deskripsi']);
    
    $query = "INSERT INTO koleksi (nama, gambar, deskripsi) VALUES ('$nama', '$gambar', '$deskripsi')";
    if(mysqli_query($koneksi, $query)) {
        $success = 'Koleksi berhasil ditambahkan!';
    } else {
        $error = 'Gagal menambahkan koleksi!';
    }
}

// Proses Hapus
if(isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $query = "DELETE FROM koleksi WHERE id = $id";
    if(mysqli_query($koneksi, $query)) {
        $success = 'Koleksi berhasil dihapus!';
    } else {
        $error = 'Gagal menghapus koleksi!';
    }
}

// Proses Edit
if(isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama = escape($koneksi, $_POST['nama']);
    $gambar = escape($koneksi, $_POST['gambar']);
    $deskripsi = escape($koneksi, $_POST['deskripsi']);
    
    $query = "UPDATE koleksi SET nama='$nama', gambar='$gambar', deskripsi='$deskripsi' WHERE id=$id";
    if(mysqli_query($koneksi, $query)) {
        $success = 'Koleksi berhasil diupdate!';
    } else {
        $error = 'Gagal mengupdate koleksi!';
    }
}

// Ambil data untuk edit
$edit_data = null;
if(isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $query = "SELECT * FROM koleksi WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $edit_data = mysqli_fetch_assoc($result);
}

// Ambil semua koleksi
$query = "SELECT * FROM koleksi ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

$base_url = '../';
$judul_halaman = 'Kelola Koleksi';
include '../includes/header.php';
?>

<div class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h2>Kelola Koleksi</h2>
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
            <h3><?php echo $edit_data ? 'Edit Koleksi' : 'Tambah Koleksi Baru'; ?></h3>
            <form method="POST" action="">
                <?php if($edit_data): ?>
                <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Nama Koleksi</label>
                    <input type="text" name="nama" required value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Nama File Gambar (contoh: keris.jpg)</label>
                    <input type="text" name="gambar" required value="<?php echo $edit_data ? htmlspecialchars($edit_data['gambar']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" required><?php echo $edit_data ? htmlspecialchars($edit_data['deskripsi']) : ''; ?></textarea>
                </div>
                
                <div style="display: flex;">
                    <button type="submit" name="<?php echo $edit_data ? 'edit' : 'tambah'; ?>" class="btn-submit">
                        <?php echo $edit_data ? 'Update Koleksi' : 'Tambah Koleksi'; ?>
                    </button>
                    
                    <?php if($edit_data): ?>
                    <a href="koleksi_manage.php" class="btn-back" style="display: inline-block; margin-left: 1rem;">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Koleksi -->
        <div class="table-container">
            <h3>Daftar Koleksi</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['gambar']); ?></td>
                        <td><?php echo htmlspecialchars(substr($row['deskripsi'], 0, 80)); ?>...</td>
                        <td>
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            <a href="?hapus=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada koleksi</td>
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