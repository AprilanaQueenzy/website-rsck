<?php
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit;
}

$host = 'localhost';
$db   = 'db_rumahsakit'; 
$user = 'root';
$pass = 'root'; // Sesuaikan dengan password database Anda

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi Database gagal: " . $conn->connect_error);
}

$alertScript = '';

// Menangkap parameter sukses dari URL untuk SweetAlert
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'register') {
        $alertScript = "Swal.fire({ icon: 'success', title: 'Registrasi Berhasil!', text: 'Silakan masuk menggunakan akun baru Anda.', confirmButtonColor: '#298F65' });";
    } elseif ($_GET['success'] === 'logout') {
        $alertScript = "Swal.fire({ icon: 'success', title: 'Sampai Jumpa!', text: 'Anda telah berhasil keluar dari sistem.', showConfirmButton: false, timer: 2500 });";
    }
}

// Proses form login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                // Set session login
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                // Set session khusus untuk trigger notifikasi sukses di halaman admin
                $_SESSION['notif_login_sukses'] = true;

                header("Location: admin.php");
                exit;
            } else {
                $alertScript = "Swal.fire({ icon: 'error', title: 'Gagal Masuk', text: 'Password yang Anda masukkan salah.', confirmButtonColor: '#d33' });";
            }
        } else {
            $alertScript = "Swal.fire({ icon: 'error', title: 'Gagal Masuk', text: 'Username tidak ditemukan.', confirmButtonColor: '#d33' });";
        }
        $stmt->close();
    } else {
        $alertScript = "Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Harap isi username dan password.', confirmButtonColor: '#f0ad4e' });";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - RS Tzu Chi</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Load SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --tzuchi-blue: #005A8C;
            --tzuchi-blue-dark: #003F63;
            --tzuchi-green: #298F65;
            --soft-text: #4A6572;
            --bg-color: #F8FAFC;
            --white: #FFFFFF;
            --border: #E2E8F0;
        }

        body { font-family: 'Nunito', sans-serif; background-color: var(--bg-color); margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { width: 100%; max-width: 400px; background: var(--white); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid var(--border); overflow: hidden; }
        .card-header { background-color: var(--tzuchi-blue); color: var(--white); padding: 25px 20px; text-align: center; }
        .card-header h2 { margin: 0; font-size: 1.5rem; font-weight: 800; }
        .card-header p { margin: 5px 0 0 0; font-size: 0.9rem; opacity: 0.9; }
        .card-body { padding: 30px 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 700; font-size: 0.9rem; color: var(--tzuchi-blue-dark); }
        .form-group input { width: 100%; padding: 12px 15px; border: 1px solid #CBD5E1; border-radius: 8px; box-sizing: border-box; font-family: inherit; font-size: 0.95rem; }
        .form-group input:focus { outline: none; border-color: var(--tzuchi-blue); box-shadow: 0 0 0 3px rgba(0, 90, 140, 0.1); }
        .btn-submit { width: 100%; padding: 14px; background-color: var(--tzuchi-green); color: var(--white); border: none; border-radius: 8px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background-color: #1E6B4B; }
        .footer-link { text-align: center; margin-top: 20px; font-size: 0.9rem; color: var(--soft-text); }
        .footer-link a { color: var(--tzuchi-blue); text-decoration: none; font-weight: 700; }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <h2>Masuk Admin</h2>
            <p>Portal Karir RS Cinta Kasih Tzu Chi</p>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required placeholder="Masukkan username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password">
                </div>
                <button type="submit" name="login" class="btn-submit">Masuk</button>
            </form>

            
        </div>
    </div>

    <!-- Menjalankan Script Notifikasi jika ada -->
    <?php if (!empty($alertScript)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?= $alertScript ?>
            });
        </script>
    <?php endif; ?>

</body>
</html>