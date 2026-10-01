<?php
require_once '../includes/koneksi.php';
start_session_if_needed();

// Jika sudah login, redirect ke dashboard
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Proses login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = escape($koneksi, $_POST['username']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        
        // Verifikasi password
        if(password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Username atau password salah
            !';
        }
    } else {
        $error = 'Username atau password salah!';
    }
}

$base_url = '../';
$judul_halaman = 'Login Admin';
include '../includes/header.php';
?>

<div class="admin-container">
    <h2>Login Admin</h2>
    
    <?php if($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        
        <button type="submit" class="btn-submit">Login</button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem;">
        <a href="../index.php" style="color: #d4af37;">← Kembali ke Website</a>
    </div>
    
    <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 5px; font-size: 0.9rem;">
        <strong>Login Default:</strong><br>
        Username: admin<br>
        Password: admin123
    </div>
</div>

<?php
mysqli_close($koneksi);
include '../includes/footer.php';
?>