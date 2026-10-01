<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Konfigurasi Database
$host = 'localhost';$db   = 'db_rumahsakit'; 
$user = 'root';$pass = 'root'; // Ubah ke 'root' jika MySQL/XAMPP Anda memakai password

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);$pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4");
    $pdo->exec("USE `$db`");
    
    // Buat tabel admins jika belum ada
    $pdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(100) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("Koneksi Database Gagal: " . $e->getMessage());
}

$alertScript = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password =$_POST['password'] ?? '';
    $confirm_password =$_POST['confirm_password'] ?? '';

    if (empty($username) or empty($password) or empty($confirm_password)) {$alertScript = "Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Semua kolom wajib diisi!', confirmButtonColor: '#f0ad4e' });";
    } elseif ($password !== $confirm_password) {$alertScript = "Swal.fire({ icon: 'error', title: 'Gagal', text: 'Konfirmasi password tidak cocok!', confirmButtonColor: '#d33' });";
    } elseif (strlen($password) < 6) {$alertScript = "Swal.fire({ icon: 'warning', title: 'Password Lemah', text: 'Password minimal terdiri dari 6 karakter.', confirmButtonColor: '#f0ad4e' });";
    } else {
        try {
            $stmt_check =$pdo->prepare("SELECT id FROM admins WHERE username = ?");
            $stmt_check->execute([$username]);

            if ($stmt_check->fetch()) {$alertScript = "Swal.fire({ icon: 'error', title: 'Gagal Registrasi', text: 'Username sudah terdaftar, silakan gunakan username lain.', confirmButtonColor: '#d33' });";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt_insert =$pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
                
                if ($stmt_insert->execute([$username,$hashed_password])) {
                    header("Location: login.php?success=register");
                    exit;
                }
            }
        } catch (PDOException $e) {$alertScript = "Swal.fire({ icon: 'error', title: 'Error Database', text: " . json_encode($e->getMessage()) . ", confirmButtonColor: '#d33' });";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin Baru - RS Tzu Chi</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
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

        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: var(--bg-color); 
            margin: 0; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
        }

        .card { 
            width: 100%; 
            max-width: 400px; 
            background: var(--white); 
            border-radius: 16px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.06); 
            border: 1px solid var(--border); 
            overflow: hidden; 
            margin: 20px 0; 
        }

        .card-header { 
            background-color: var(--tzuchi-blue); 
            color: var(--white); 
            padding: 25px 20px; 
            text-align: center; 
        }
        .card-header h2 { margin: 0; font-size: 1.5rem; font-weight: 800; }
        .card-header p { margin: 5px 0 0 0; font-size: 0.9rem; opacity: 0.9; }

        .card-body { padding: 30px 25px; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 700; font-size: 0.9rem; color: var(--tzuchi-blue-dark); }
        .form-group input { 
            width: 100%; 
            padding: 12px 15px; 
            border: 1px solid #CBD5E1; 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-family: inherit; 
            font-size: 0.95rem; 
        }
        .form-group input:focus { 
            outline: none; 
            border-color: var(--tzuchi-blue); 
            box-shadow: 0 0 0 3px rgba(0, 90, 140, 0.1); 
        }

        .btn-submit { 
            width: 100%; 
            padding: 14px; 
            background-color: var(--tzuchi-green); 
            color: var(--white); 
            border: none; 
            border-radius: 8px; 
            font-weight: 800; 
            font-size: 1rem; 
            cursor: pointer; 
            transition: 0.3s; 
            margin-top: 5px; 
        }
        .btn-submit:hover { background-color: #1E6B4B; }

        .footer-link { text-align: center; margin-top: 20px; font-size: 0.9rem; color: var(--soft-text); }
        .footer-link a { color: var(--tzuchi-blue); text-decoration: none; font-weight: 700; }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <h2>Daftar Admin Baru</h2>
            <p>Portal Karir RS Cinta Kasih Tzu Chi</p>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required placeholder="Buat username baru">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="confirm_password" required placeholder="Ulangi password">
                </div>
                <button type="submit" name="register" class="btn-submit">Daftar Sekarang</button>
            </form>

            <div class="footer-link">
                Sudah punya akun? <a href="login.php">Masuk di sini</a>
            </div>
        </div>
    </div>

    <?php if (!empty($alertScript)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?= $alertScript ?>
            });
        </script>
    <?php endif; ?>

</body>
</html>