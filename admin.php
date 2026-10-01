<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ==========================================
// KONFIGURASI DATABASE & KONEKSI
// ==========================================
$host = 'localhost';
$db   = 'db_rumahsakit'; 
$user = 'root';
$pass = 'root';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Koneksi Database gagal: " . $conn->connect_error);
}

// Otomatis buat database & tabel jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4");
$conn->select_db($db);

$conn->query("CREATE TABLE IF NOT EXISTS job_vacancies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL DEFAULT 'Cengkareng, Jakarta Barat',
    description TEXT NOT NULL,
    requirements TEXT NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;");

$conn->query("CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;");

// Routing Halaman
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// ==========================================
// LOGIKA RESPONSE AJAX (Auto-Update 3 Detik)
// ==========================================
if (isset($_GET['fetch_ajax'])) {
    header('Content-Type: application/json');
    $response = [];

    // 1. Data Counter Statistik
    $response['total_lowongan'] = $conn->query("SELECT COUNT(*) as total FROM job_vacancies")->fetch_assoc()['total'];
    $response['total_pelamar']  = $conn->query("SELECT COUNT(*) as total FROM applications")->fetch_assoc()['total'];

    // 2. Data Tabel Halaman Karir
    if ($page === 'karir') {
        // Render HTML Tabel Lowongan
        ob_start();
        $jobs = $conn->query("SELECT * FROM job_vacancies ORDER BY created_at DESC");
        if ($jobs && $jobs->num_rows > 0):
            $no = 1;
            while ($j = $jobs->fetch_assoc()):
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><strong><?= htmlspecialchars($j['title']) ?></strong></td>
                <td><?= htmlspecialchars($j['department']) ?></td>
                <td>
                    <?php if ($j['is_active']): ?>
                        <span class="badge-status status-active">Aktif</span>
                    <?php else: ?>
                        <span class="badge-status status-inactive">Nonaktif</span>
                    <?php endif; ?>
                </td>
                <td><?= date('d M Y', strtotime($j['created_at'])) ?></td>
                <td>
                    <a href="admin.php?page=karir&action=edit_lowongan&id=<?= $j['id'] ?>" class="btn-sm btn-edit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="admin.php?page=karir&action=toggle_status&id=<?= $j['id'] ?>" class="btn-sm btn-toggle">
                        <i class="fa-solid fa-power-off"></i> <?= $j['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                    </a>
                    <a href="admin.php?page=karir&action=hapus_lowongan&id=<?= $j['id'] ?>" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </a>
                </td>
            </tr>
        <?php 
            endwhile;
        else: 
        ?>
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada lowongan kerja yang ditambahkan.</td>
            </tr>
        <?php endif;
        $response['html_lowongan'] = ob_get_clean();

        // Render HTML Tabel Pelamar
        ob_start();
        $apps = $conn->query("SELECT a.*, j.title as job_title FROM applications a LEFT JOIN job_vacancies j ON a.job_id = j.id ORDER BY a.applied_at DESC");
        if ($apps && $apps->num_rows > 0):
            $no = 1;
            while ($a = $apps->fetch_assoc()):
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><strong><?= htmlspecialchars($a['job_title'] ?? 'Lowongan Dihapus') ?></strong></td>
                <td><?= htmlspecialchars($a['full_name']) ?></td>
                <td>
                    <i class="fa-solid fa-phone" style="font-size:0.8rem; color:var(--text-muted);"></i> <?= htmlspecialchars($a['phone']) ?><br>
                    <i class="fa-solid fa-envelope" style="font-size:0.8rem; color:var(--text-muted);"></i> <?= htmlspecialchars($a['email']) ?>
                </td>
                <td><?= date('d M Y - H:i', strtotime($a['applied_at'])) ?></td>
                <td>
                    <?php if (file_exists($a['resume_path'])): ?>
                        <a href="<?= htmlspecialchars($a['resume_path']) ?>" download class="btn-sm btn-download">
                            <i class="fa-solid fa-download"></i> Download Berkas
                        </a>
                    <?php else: ?>
                        <span style="color: red; font-size:0.85rem;">File Tidak Ada</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php 
            endwhile;
        else: 
        ?>
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada pelamar yang mengirimkan berkas.</td>
            </tr>
        <?php endif;
        $response['html_pelamar'] = ob_get_clean();
    }

    echo json_encode($response);
    exit;
}

// ==========================================
// LOGIKA PROSES ADMIN KARIR
// ==========================================
$msg = '';
$msgClass = '';

// 1. Tambah Lowongan Kerja Baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_lowongan'])) {
    $title       = trim($_POST['title'] ?? '');
    $department  = trim($_POST['department'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $requirements= trim($_POST['requirements'] ?? '');

    if (!empty($title) && !empty($department) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO job_vacancies (title, department, description, requirements) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $department, $description, $requirements);
        if ($stmt->execute()) {
            $msg = "Lowongan kerja baru berhasil ditambahkan! ";
            $msgClass = "success";
        } else {
            $msg = "Gagal menambah lowongan: " . $stmt->error;
            $msgClass = "error";
        }
        $stmt->close();
    } else {
        $msg = "Mohon isi semua kolom yang wajib diisi.";
        $msgClass = "error";
    }
}

// 2. Simpan Perubahan Edit Lowongan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_lowongan'])) {
    $job_id      = intval($_POST['job_id'] ?? 0);
    $title       = trim($_POST['title'] ?? '');
    $department  = trim($_POST['department'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $requirements= trim($_POST['requirements'] ?? '');

    if ($job_id > 0 && !empty($title) && !empty($department) && !empty($description)) {
        $stmt = $conn->prepare("UPDATE job_vacancies SET title = ?, department = ?, description = ?, requirements = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $department, $description, $requirements, $job_id);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: admin.php?page=karir&msg=updated");
            exit;
        } else {
            $msg = "Gagal memperbarui lowongan: " . $stmt->error;
            $msgClass = "error";
        }
    } else {
        $msg = "Mohon isi semua kolom yang wajib diisi.";
        $msgClass = "error";
    }
}

// 3. Toggle Status Aktif/Nonaktif Lowongan
if (isset($_GET['action']) && $_GET['action'] === 'toggle_status' && isset($_GET['id'])) {
    $job_id = intval($_GET['id']);
    $conn->query("UPDATE job_vacancies SET is_active = NOT is_active WHERE id = $job_id");
    header("Location: admin.php?page=karir&msg=status_updated");
    exit;
}

// 4. Hapus Lowongan Kerja
if (isset($_GET['action']) && $_GET['action'] === 'hapus_lowongan' && isset($_GET['id'])) {
    $job_id = intval($_GET['id']);
    $conn->query("DELETE FROM job_vacancies WHERE id = $job_id");
    header("Location: admin.php?page=karir&msg=deleted");
    exit;
}

// Check Mode Edit Lowongan
$editJob = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit_lowongan' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM job_vacancies WHERE id = $edit_id");
    if ($res && $res->num_rows > 0) {
        $editJob = $res->fetch_assoc();
    }
}

// Tangkap Notifikasi dari Redirect

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'status_updated') {
        $msg = "Status lowongan berhasil diperbarui.";
        $msgClass = "success";
    } elseif ($_GET['msg'] === 'deleted') {
        $msg = "Lowongan berhasil dihapus.";
        $msgClass = "success";
    } elseif ($_GET['msg'] === 'updated') {
        $msg = "Data lowongan kerja berhasil diperbarui! ✨";
        $msgClass = "success";
    }
}

$pageTitle = "Dashboard Utama";
if ($page == 'karir') $pageTitle = "Kelola Karir & Lamaran";
if ($page == 'berita') $pageTitle = "Kelola Berita & Artikel";
if ($page == 'dokter') $pageTitle = "Kelola Jadwal Dokter";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rumah Sakit Tzu Chi</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
    /* ... (kode style Anda tetap sama) ... */
        :root {
            --tzuchi-blue: #005A8C;       
            --tzuchi-blue-dark: #002D47;  
            --tzuchi-blue-light: #1E70A0;  
            --tzuchi-green: #298F65;      
            --bg-page: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-main: #1E293B;
            --text-muted: #64748B;         
            --border-light: #E2E8F0; 
            --sidebar-width: 270px;
        }

        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            background-color: var(--bg-page);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR & NAVIGASI ================= */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--tzuchi-blue-dark) 0%, #001B2E 100%);
            color: white;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* KONDISI SIDEBAR TERTUTUP (DESKTOP) */
        body.sidebar-closed .sidebar {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-header i.brand-icon {
            font-size: 1.8rem;
            color: #38BDF8;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #FFFFFF;
        }

        .sidebar-profile {
            margin: 20px 16px 10px 16px;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--tzuchi-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-info .name {
            font-weight: 700;
            font-size: 0.95rem;
            color: #F8FAFC;
        }

        .profile-info .status {
            font-size: 0.78rem;
            color: #94A3B8;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #22C55E;
            border-radius: 50%;
            box-shadow: 0 0 8px #22C55E;
        }

        .menu-label {
            padding: 15px 24px 8px 24px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748B;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 16px;
            margin: 0;
            flex: 1;
        }

        .sidebar-menu li {
            margin-bottom: 6px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: #94A3B8;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 10px;
            transition: all 0.25s ease;
        }

        .sidebar-menu a i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
            transition: 0.25s ease;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }

        .sidebar-menu a:hover i {
            color: #38BDF8;
        }

        .sidebar-menu a.active {
            background: linear-gradient(90deg, var(--tzuchi-blue) 0%, var(--tzuchi-blue-light) 100%);
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0, 90, 140, 0.3);
        }

        .sidebar-menu a.active i {
            color: #FFFFFF;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            background-color: rgba(239, 68, 68, 0.1);
            color: #FCA5A5;
            border: 1px solid rgba(239, 68, 68, 0.2);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #EF4444;
            color: white;
            border-color: #EF4444;
        }

        /* OVERLAY LAYAR UNTUK MOBILE */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 999;
            transition: opacity 0.3s ease;
        }

        /* ================= UTAMA & CONTENT ================= */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 0;
        }

        /* KONDISI UTAMA KETIKA SIDEBAR TERTUTUP (DESKTOP) */
        body.sidebar-closed .main-content {
            margin-left: 0;
        }

        .topbar {
            background-color: white;
            padding: 18px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* TOMBOL TOGGLE UNTUK DESKTOP & MOBILE */
        .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F1F5F9;
            border: 1px solid var(--border-light);
            width: 42px;
            height: 42px;
            border-radius: 10px;
            font-size: 1.2rem;
            color: var(--tzuchi-blue-dark);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .menu-toggle:hover {
            background: var(--tzuchi-blue);
            color: white;
            border-color: var(--tzuchi-blue);
        }

        .topbar h1 {
            margin: 0;
            font-size: 1.4rem;
            color: var(--tzuchi-blue-dark);
            font-weight: 800;
        }

        .live-indicator {
            font-size: 0.8rem;
            font-weight: 700;
            color: #22C55E;
            background: #DCFCE7;
            padding: 4px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .content-wrapper { padding: 30px; flex: 1; }

        .card {
            background: white; padding: 30px; border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid var(--border-light);
            margin-bottom: 30px;
        }
        .card h3 { margin-top: 0; color: var(--tzuchi-blue-dark); font-size: 1.25rem; font-weight: 800; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 700; margin-bottom: 6px; font-size: 0.95rem; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 12px; border: 2px solid var(--border-light);
            border-radius: 10px; box-sizing: border-box; font-family: inherit; font-size: 0.95rem;
        }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: var(--tzuchi-blue); }
        .form-row { display: flex; gap: 20px; }
        .form-row .form-group { flex: 1; }

        .btn-submit {
            padding: 12px 25px; background: var(--tzuchi-blue); color: white;
            border: none; border-radius: 30px; font-weight: 800; cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { background: var(--tzuchi-blue-dark); }
        .btn-cancel {
            padding: 12px 25px; background: #E2E8F0; color: #475569;
            border: none; border-radius: 30px; font-weight: 800; cursor: pointer; text-decoration: none; display: inline-block; margin-left: 10px;
        }
        .btn-cancel:hover { background: #CBD5E1; }

        .btn-sm { padding: 6px 12px; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px; }
        .btn-edit { background: #FEF3C7; color: #92400E; }
        .btn-toggle { background: #E2E8F0; color: #334155; }
        .btn-danger { background: #FEE2E2; color: #991B1B; }
        .btn-download { background: #DCFCE7; color: #166534; }

        .table-responsive { overflow-x: auto; margin-top: 15px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 14px; border-bottom: 1px solid var(--border-light); font-size: 0.95rem; }
        th { background-color: #F8FAFC; color: var(--tzuchi-blue-dark); font-weight: 800; }
        
        .badge-status { padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 0.8rem; }
        .status-active { background-color: #DCFCE7; color: #166534; }
        .status-inactive { background-color: #F1F5F9; color: #64748B; }

        .alert { padding: 15px; border-radius: 10px; margin-bottom: 25px; font-weight: 700; }
        .alert.success { background-color: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .alert.error { background-color: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }

        /* RESPONSIVE UNTUK LAYAR MOBILE (<= 992px) */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0 !important;
            }
            /* Saat sidebar dibuka di Mobile */
            body.sidebar-open .sidebar {
                transform: translateX(0);
            }
            body.sidebar-open .sidebar-overlay {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- OVERLAY LAYAR UNTUK MOBILE -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR NAVIGATION -->
    <aside class="sidebar" id="sidebarNav">
        <div class="sidebar-header">
            <i class="fa-solid fa-hospital brand-icon"></i>
            <h2>TZU CHI ADMIN</h2>
        </div>

        <div class="sidebar-profile">
            <div class="profile-avatar">
                <i class="fa-solid fa-user-gear"></i>
            </div>
            <div class="profile-info">
                <span class="name">Administrator</span>
                <span class="status">
                    <span class="status-dot"></span> Online
                </span>
            </div>
        </div>

        <div class="menu-label">Navigasi Utama</div>
        <ul class="sidebar-menu">
            <li>
                <a href="admin.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="admin.php?page=karir" class="<?= $page == 'karir' ? 'active' : '' ?>">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Kelola Karir</span>
                </a>
            </li>
            <!-- SESUDAH -->
<li>
    <a href="edit-jadwal.php" class="<?= basename($_SERVER['PHP_SELF']) == 'edit-jadwal.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-user-doctor"></i>
        <span>Jadwal Dokter</span>
    </a>
</li>
            <li>
                <a href="admin.php?page=berita" class="<?= $page == 'berita' ? 'active' : '' ?>">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>Kelola Berita</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="logout.php" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Keluar (Logout)</span>
            </a>
        </div>
    </aside>

    <!-- MAIN KONTEN -->
    <main class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <!-- TOMBOL TOGGLE SIDEBAR -->
                <button class="menu-toggle" id="toggleBtn" onclick="toggleSidebar()" title="Buka/Tutup Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1><?= htmlspecialchars($pageTitle) ?></h1>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span class="live-indicator"><span class="status-dot"></span> Aktif</span>
                <div style="font-weight: 700; color: var(--text-muted); font-size: 0.9rem;">
                    RS Tzu Chi Cengkareng
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <?php if ($msg): ?>
                <div class="alert <?= $msgClass ?>"><?= $msg ?></div>
            <?php endif; ?>

            <?php
            // ==========================================
            // KONTEN DASHBOARD
            // ==========================================
            if ($page == 'dashboard') {
                $totalLowongan = $conn->query("SELECT COUNT(*) as total FROM job_vacancies")->fetch_assoc()['total'];
                $totalPelamar  = $conn->query("SELECT COUNT(*) as total FROM applications")->fetch_assoc()['total'];
                ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div class="card" style="margin-bottom:0; display:flex; align-items:center; gap:20px;">
                        <div style="width:60px; height:60px; background:#E0F2FE; color:var(--tzuchi-blue); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.8rem;">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <h2 id="stat-total-lowongan" style="margin:0; color: var(--tzuchi-blue); font-size:1.8rem;"><?= $totalLowongan ?></h2>
                            <p style="margin:0; color: var(--text-muted); font-weight:700;">Total Lowongan Kerja</p>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom:0; display:flex; align-items:center; gap:20px;">
                        <div style="width:60px; height:60px; background:#DCFCE7; color:var(--tzuchi-green); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.8rem;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <h2 id="stat-total-pelamar" style="margin:0; color: var(--tzuchi-green); font-size:1.8rem;"><?= $totalPelamar ?></h2>
                            <p style="margin:0; color: var(--text-muted); font-weight:700;">Total Pelamar</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3>Selamat Datang di Portal Admin Terpadu</h3>
                    <p style="color: var(--text-muted); margin-bottom: 0;">Silakan gunakan menu navigasi di sebelah kiri untuk mengelola informasi Karir, Jadwal Dokter, dan Berita Utama Website.</p>
                </div>
                <?php
            } 

            // ==========================================
            // KONTEN KELOLA KARIR & PELAMAR
            // ==========================================
            elseif ($page == 'karir') {
                ?>
                <!-- 1. Form Tambah / Edit Lowongan -->
                <div class="card" id="form-card">
                    <?php if ($editJob): ?>
                        <h3><i class="fa-solid fa-pen-to-square" style="color:var(--tzuchi-blue);"></i> Edit Lowongan Kerja (ID: <?= $editJob['id'] ?>)</h3>
                        <form method="POST" action="admin.php?page=karir">
                            <input type="hidden" name="job_id" value="<?= $editJob['id'] ?>">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Judul Posisi / Pekerjaan *</label>
                                    <input type="text" name="title" required value="<?= htmlspecialchars($editJob['title']) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Departemen / Divisi *</label>
                                    <input type="text" name="department" required value="<?= htmlspecialchars($editJob['department']) ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Pekerjaan *</label>
                                <textarea name="description" rows="3" required><?= htmlspecialchars($editJob['description']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Kualifikasi / Persyaratan (Gunakan Enter / Baris Baru per poin) *</label>
                                <textarea name="requirements" rows="4" required><?= htmlspecialchars($editJob['requirements']) ?></textarea>
                            </div>

                            <button type="submit" name="update_lowongan" class="btn-submit">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                            </button>
                            <a href="admin.php?page=karir" class="btn-cancel">Batal</a>
                        </form>
                    <?php else: ?>
                        <h3><i class="fa-solid fa-plus-circle" style="color:var(--tzuchi-blue);"></i> Tambah Lowongan Kerja Baru</h3>
                        <form method="POST" action="admin.php?page=karir">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Judul Posisi / Pekerjaan *</label>
                                    <input type="text" name="title" required placeholder="Contoh: Perawat Poliklinik">
                                </div>
                                <div class="form-group">
                                    <label>Departemen / Divisi *</label>
                                    <input type="text" name="department" required placeholder="Contoh: Keperawatan">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Pekerjaan *</label>
                                <textarea name="description" rows="3" required placeholder="Tulis uraian tugas dan tanggung jawab posisi ini..."></textarea>
                            </div>

                            <div class="form-group">
                                <label>Kualifikasi / Persyaratan (Gunakan Enter / Baris Baru per poin) *</label>
                                <textarea name="requirements" rows="4" required placeholder="Pendidikan Min D3&#10;Memiliki STR Aktif&#10;Pengalaman min 1 tahun"></textarea>
                            </div>

                            <button type="submit" name="tambah_lowongan" class="btn-submit">
                                <i class="fa-solid fa-paper-plane"></i> Simpan & Terbitkan Lowongan
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <!-- 2. Tabel Daftar Lowongan Kerja -->
                <div class="card">
                    <h3><i class="fa-solid fa-list-check" style="color:var(--tzuchi-blue);"></i> Daftar Lowongan Kerja Saat Ini</h3>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Posisi Pekerjaan</th>
                                    <th>Departemen</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-lowongan">
                                <?php
                                $jobs = $conn->query("SELECT * FROM job_vacancies ORDER BY created_at DESC");
                                if ($jobs && $jobs->num_rows > 0):
                                    $no = 1;
                                    while ($j = $jobs->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($j['title']) ?></strong></td>
                                        <td><?= htmlspecialchars($j['department']) ?></td>
                                        <td>
                                            <?php if ($j['is_active']): ?>
                                                <span class="badge-status status-active">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge-status status-inactive">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M Y', strtotime($j['created_at'])) ?></td>
                                        <td>
                                            <a href="admin.php?page=karir&action=edit_lowongan&id=<?= $j['id'] ?>" class="btn-sm btn-edit">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <a href="admin.php?page=karir&action=toggle_status&id=<?= $j['id'] ?>" class="btn-sm btn-toggle">
                                                <i class="fa-solid fa-power-off"></i> <?= $j['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                                            </a>
                                            <a href="admin.php?page=karir&action=hapus_lowongan&id=<?= $j['id'] ?>" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    endwhile;
                                else: 
                                ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada lowongan kerja yang ditambahkan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3. Tabel Data Pelamar Masuk -->
                <div class="card">
                    <h3><i class="fa-solid fa-inbox" style="color:var(--tzuchi-blue);"></i> Data Pelamar Masuk</h3>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Posisi Dilamar</th>
                                    <th>Nama Pelamar</th>
                                    <th>Kontak</th>
                                    <th>Tanggal Melamar</th>
                                    <th>Berkas Resume</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-pelamar">
                                <?php
                                $apps = $conn->query("SELECT a.*, j.title as job_title FROM applications a LEFT JOIN job_vacancies j ON a.job_id = j.id ORDER BY a.applied_at DESC");
                                if ($apps && $apps->num_rows > 0):
                                    $no = 1;
                                    while ($a = $apps->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($a['job_title'] ?? 'Lowongan Dihapus') ?></strong></td>
                                        <td><?= htmlspecialchars($a['full_name']) ?></td>
                                        <td>
                                            <i class="fa-solid fa-phone" style="font-size:0.8rem; color:var(--text-muted);"></i> <?= htmlspecialchars($a['phone']) ?><br>
                                            <i class="fa-solid fa-envelope" style="font-size:0.8rem; color:var(--text-muted);"></i> <?= htmlspecialchars($a['email']) ?>
                                        </td>
                                        <td><?= date('d M Y - H:i', strtotime($a['applied_at'])) ?></td>
                                        <td>
                                            <?php if (file_exists($a['resume_path'])): ?>
                                                <a href="<?= htmlspecialchars($a['resume_path']) ?>" download class="btn-sm btn-download">
                                                    <i class="fa-solid fa-download"></i> Download Berkas
                                                </a>
                                            <?php else: ?>
                                                <span style="color: red; font-size:0.85rem;">File Tidak Ada</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php 
                                    endwhile;
                                else: 
                                ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada pelamar yang mengirimkan berkas.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            } 

            // ==========================================
            // KONTEN JADWAL DOKTER
            // ==========================================
            elseif ($page == 'dokter') {
                ?>
                <div class="card">
                    <h3><i class="fa-solid fa-user-doctor" style="color:var(--tzuchi-blue);"></i> Kelola Jadwal Praktik Dokter</h3>
                    <p style="color: var(--text-muted);">Fitur manajemen jadwal dokter akan dihubungkan di sini.</p>
                </div>
                <?php
            } 

            // ==========================================
            // KONTEN BERITA
            // ==========================================
            elseif ($page == 'berita') {
                ?>
                <div class="card">
                    <h3><i class="fa-solid fa-newspaper" style="color:var(--tzuchi-blue);"></i> Kelola Berita & Artikel Website</h3>
                    <p style="color: var(--text-muted);">Fitur publikasi berita dan pengumuman akan dihubungkan di sini.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </main>

    <!-- SCRIPT JAVASCRIPT: TOGGLE SIDEBAR & AJAX AUTO-REFRESH -->
    <script>
        // 1. FUNGSI TOGGLE (BUKA / TUTUP) SIDEBAR
        function toggleSidebar() {
            const isMobile = window.innerWidth <= 992;
            
            if (isMobile) {
                // Di HP: toggle class 'sidebar-open'
                document.body.classList.toggle('sidebar-open');
            } else {
                // Di Desktop: toggle class 'sidebar-closed'
                document.body.classList.toggle('sidebar-closed');
                
                // Simpan status terakhir ke localStorage
                const isClosed = document.body.classList.contains('sidebar-closed');
                localStorage.setItem('tzuchi_sidebar_closed', isClosed ? 'true' : 'false');
            }
        }

        // Restore Status Sidebar Saat Halaman Di-load (Desktop)
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth > 992) {
                const savedState = localStorage.getItem('tzuchi_sidebar_closed');
                if (savedState === 'true') {
                    document.body.classList.add('sidebar-closed');
                }
            }
        });

        // 2. JS AJAX AUTO-REFRESH (Setiap 3 Detik)
        const currentPage = "<?= $page ?>";

        function refreshDataAjax() {
            fetch(`admin.php?fetch_ajax=1&page=${currentPage}`)
                .then(response => response.json())
                .then(data => {
                    // Update counter statistik jika elemen ada
                    const elLowongan = document.getElementById('stat-total-lowongan');
                    const elPelamar = document.getElementById('stat-total-pelamar');
                    if (elLowongan) elLowongan.textContent = data.total_lowongan;
                    if (elPelamar) elPelamar.textContent = data.total_pelamar;

                    // Update isi tabel jika sedang di halaman karir
                    if (currentPage === 'karir') {
                        const tbodyLowongan = document.getElementById('tbody-lowongan');
                        const tbodyPelamar = document.getElementById('tbody-pelamar');
                        if (tbodyLowongan && data.html_lowongan) tbodyLowongan.innerHTML = data.html_lowongan;
                        if (tbodyPelamar && data.html_pelamar) tbodyPelamar.innerHTML = data.html_pelamar;
                    }
                })
                .catch(error => console.error('Gagal mengambil data AJAX:', error));
        }

        // Set Interval 3000 ms (3 detik)
        setInterval(refreshDataAjax, 3000);
    </script>
    <?php if (isset($_SESSION['notif_login_sukses']) && $_SESSION['notif_login_sukses'] === true): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Selamat Datang!',
                    text: 'Anda telah berhasil masuk ke sistem.',
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
        <?php unset($_SESSION['notif_login_sukses']); ?>
    <?php endif; ?>
</body>
</html>