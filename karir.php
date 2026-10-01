<?php
// Aktifkan pelacak error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi Database
$host = 'localhost';
$db   = 'db_rumahsakit'; 
$user = 'root';
$pass = 'root';

$msg = '';
$msgClass = '';

// Koneksi menggunakan MySQLi
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Koneksi Database gagal: " . $conn->connect_error);
}

// Buat database jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4");
$conn->select_db($db);

// Pastikan tabel job_vacancies ada
$conn->query("CREATE TABLE IF NOT EXISTS job_vacancies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;");

// Pastikan tabel applications ada
$conn->query("CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;");

// Tangkap status sukses dari URL setelah redirect
if (isset($_GET['status']) && $_GET['status'] === 'success') {$msg = "Terima kasih! Lamaran Anda berhasil dikirim dan akan segera kami proses. 🎉";
    $msgClass = "success";
}

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_job'])) {
    $job_id    =$_POST['job_id'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    
    // --- CEK ANTI-SPAM ---
    $checkEmailStmt =$conn->prepare("SELECT id FROM applications WHERE email = ? AND DATE(applied_at) = CURDATE()");
    if ($checkEmailStmt) {
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();$checkEmailStmt->store_result();
        
        if ($checkEmailStmt->num_rows > 0) {$msg = "Mohon maaf, email ini sudah digunakan untuk melamar hari ini. Silakan coba lagi besok ya! 😊";
            $msgClass = "error";
            $checkEmailStmt->close();
        } else {
            $checkEmailStmt->close();$uploadDir = 'uploads/';
            
            if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {$file        = $_FILES['resume'];$fileName    = $file['name'];$fileTmpName = $file['tmp_name'];$fileSize    = $file['size'];$allowedExts = ['zip', 'rar'];
                $fileExt     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                if (in_array($fileExt,$allowedExts)) {
                    if ($fileSize <= 2097152) { // 2MB
                        $newFileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "", $fileName);
                        
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        
                        $fileDestination = $uploadDir .$newFileName;
                        
                        if (move_uploaded_file($fileTmpName,$fileDestination)) {
                            $stmt =$conn->prepare("INSERT INTO applications (job_id, full_name, phone, email, resume_path) VALUES (?, ?, ?, ?, ?)");
                            if ($stmt) {
                                $stmt->bind_param("issss", $job_id, $full_name,$phone, $email,$fileDestination);
                                if ($stmt->execute()) {$stmt->close();
                                    header("Location: karir.php?status=success");
                                    exit;
                                } else {
                                    $msg = "Aduh, gagal menyimpan ke database: " . $stmt->error;
                                    $msgClass = "error";
                                }
                                $stmt->close();
                            } else {
                                $msg = "Gagal menyiapkan statement: " . $conn->error;
                                $msgClass = "error";
                            }
                        } else {
                            $msg = "Mohon maaf, gagal memindahkan file unggahan ke server.";
                            $msgClass = "error";
                        }
                    } else {
                        $msg = "Ups! Ukuran file terlalu besar. Maksimal 2MB ya.";
                        $msgClass = "error";
                    }
                } else {
                    $msg = "Format file tidak didukung. Harap unggah file .zip atau .rar saja.";
                    $msgClass = "error";
                }
            } else {
                if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_INI_SIZE) {$msg = "File yang diunggah melebihi batas maksimal server.";
                } else {
                    $msg = "Mohon lampirkan file resume Anda (.zip / .rar) dengan benar.";
                }
                $msgClass = "error";
            }
        }
    } else {
        $msg = "Gagal melakukan verifikasi email: " . $conn->error;
        $msgClass = "error";
    }
}

$result =$conn->query("SELECT * FROM job_vacancies WHERE is_active = 1 ORDER BY created_at DESC");
$jobs = [];
if ($result) {
    while ($row =$result->fetch_assoc()) {
        $jobs[] =$row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karir - Rumah Sakit Tzu Chi</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Palet Warna Modern & Friendly */
            --tzuchi-blue: #005A8C;       
            --tzuchi-blue-dark: #003F63;  
            --tzuchi-green: #298F65;      
            
            --bg-page: #F8FAFC;
            --bg-card: #FFFFFF;
            
            --text-main: #1E293B;
            --text-soft: #64748B;         
            --border-light: #E2E8F0; 
            
            /* Warna Badge */
            --badge-blue-bg: #E0F2FE;
            --badge-blue-text: #0369A1;
        }

        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: var(--bg-page); 
            margin: 0; 
            color: var(--text-main); 
            line-height: 1.6;
        }

        /* Hero Section dengan Efek Fade ke Latar Halaman */
        .hero { 
            background: url('image.png');
            background-size: cover;
            background-position: center 25%;
            background-repeat: no-repeat;
            padding: 120px 20px 180px 20px; 
            text-align: center; 
            position: relative;
            z-index: 1;
        }

        /* Overlay Gradasi agar menyatu dengan --bg-page (#F8FAFC) */
        .hero::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, rgba(248, 250, 252, 0.4) 0%, rgba(248, 250, 252, 1) 95%); 
            z-index: -1;
        }

        .hero h1 { 
            font-size: 3rem; 
            font-weight: 800; 
            margin-top: 0;
            margin-bottom: 15px; 
            color: var(--tzuchi-blue-dark); 
            letter-spacing: -0.5px;
        }
        
        .hero p { 
            font-size: 1.2rem; 
            color: var(--text-soft); 
            margin: 0 auto; 
            font-weight: 600;
            max-width: 700px;
        }

        /* Container Utama */
        .job-container { 
            max-width: 850px; 
            margin: -90px auto 80px auto; 
            position: relative; 
            z-index: 2; 
            padding: 0 20px;
        }
        
        /* Pesan Alert Friendly */
        .alert { padding: 18px; border-radius: 12px; margin-bottom: 30px; font-weight: 700; text-align: center; transition: all 0.5s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .alert.success { background-color: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .alert.error { background-color: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }

        /* Kartu Lowongan Modern */
        .job-item { 
            background: var(--bg-card);
            border: 1px solid var(--border-light); 
            border-left: 6px solid var(--tzuchi-blue); 
            border-radius: 16px; 
            margin-bottom: 35px; 
            overflow: hidden; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04); 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .job-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }
        
        /* Header Kartu */
        .job-header { 
            padding: 25px 30px; 
            border-bottom: 1px solid var(--border-light); 
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .job-title { 
            font-size: 1.4rem; 
            font-weight: 800; 
            color: var(--text-main); 
        }
        .job-badges { 
            display: flex; 
            gap: 10px; 
            flex-wrap: wrap;
        }
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-dept { background-color: var(--badge-blue-bg); color: var(--badge-blue-text); }

        /* Konten Kartu */
        .job-content { padding: 30px; }
        
        .section-title { 
            color: var(--tzuchi-blue-dark); 
            font-size: 1.1rem; 
            font-weight: 800;
            margin: 0 0 12px 0; 
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .desc-text { 
            color: var(--text-soft); 
            margin-bottom: 30px; 
            font-size: 1rem;
        }

        /* Daftar Checklist Friendly */
        .req-list { 
            list-style: none;
            padding-left: 0; 
            margin-bottom: 35px; 
        }
        .req-list li { 
            margin-bottom: 12px; 
            color: var(--text-soft);
            position: relative;
            padding-left: 28px;
        }
        .req-list li::before {
            content: "✅";
            position: absolute;
            left: 0;
            top: 2px;
            font-size: 0.9rem;
        }

        /* Tombol Aksi */
        .btn-open-form { 
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 30px; 
            background-color: var(--tzuchi-blue); 
            color: white; 
            border: none; 
            border-radius: 30px; 
            font-weight: 800; 
            font-size: 1rem; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            box-shadow: 0 4px 15px rgba(0, 90, 140, 0.2);
        }
        .btn-open-form:hover { 
            background-color: var(--tzuchi-blue-dark); 
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 90, 140, 0.3);
        }

        /* Form Apply Modern */
        .apply-box { 
            display: none; 
            background-color: #F8FAFC; 
            padding: 30px; 
            border-radius: 16px; 
            border: 1px solid var(--border-light); 
            margin-top: 25px; 
            animation: slideDown 0.4s ease-out; 
        }
        @keyframes slideDown { 
            from { opacity: 0; transform: translateY(-10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .apply-box h4 { 
            margin-top: 0; 
            margin-bottom: 25px; 
            font-size: 1.2rem;
            color: var(--text-main);
            border-bottom: 2px dashed var(--border-light);
            padding-bottom: 15px;
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            font-size: 0.95rem; 
            font-weight: 700; 
            color: var(--text-main); 
            margin-bottom: 8px; 
        }
        .form-group input { 
            width: 100%; 
            padding: 14px 16px; 
            border: 2px solid var(--border-light); 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-family: inherit; 
            font-size: 1rem; 
            background-color: white;
            transition: all 0.3s; 
        }
        .form-group input:focus { 
            outline: none; 
            border-color: var(--tzuchi-blue); 
            background-color: #F0F7FF;
        }
        .form-group input[type="file"] { 
            padding: 10px;
            cursor: pointer; 
        }
        .form-row { display: flex; gap: 20px; }
        .form-row .form-group { flex: 1; }
        
        .form-actions { display: flex; gap: 15px; margin-top: 30px; }
        .btn-apply { 
            padding: 14px 24px; 
            background-color: var(--tzuchi-green); 
            color: white; 
            border: none; 
            border-radius: 30px; 
            font-weight: 800; 
            font-size: 1.05rem; 
            cursor: pointer; 
            flex: 2; 
            transition: background 0.3s;
        }
        .btn-apply:hover { background-color: #1E6B4B; }
        
        .btn-cancel { 
            padding: 14px 24px; 
            background-color: white; 
            color: var(--text-soft); 
            border: 2px solid var(--border-light); 
            border-radius: 30px; 
            font-weight: 700; 
            font-size: 1rem; 
            cursor: pointer; 
            flex: 1; 
            transition: all 0.3s;
        }
        .btn-cancel:hover { background-color: var(--border-light); color: var(--text-main); }

        /* Area Informasi Tambahan (Bawah) */
        .info-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 25px; 
            margin-top: 60px; 
        }
        .info-card { 
            background-color: var(--bg-card); 
            border: 1px solid var(--border-light); 
            border-radius: 16px; 
            padding: 30px; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03); 
            transition: transform 0.3s;
            font-weight: 700; /* Teks default tebal di kartu */
            color: var(--text-main);
        }
        .info-card:hover { transform: translateY(-5px); }
        .info-card h3 { 
            margin-top: 0; 
            color: var(--text-main); 
            font-size: 1.2rem; 
            font-weight: 800; 
            margin-bottom: 20px; 
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .info-card p {
            font-weight: 700;
            color: var(--text-main);
        }
        .info-card ul { 
            margin: 0; 
            padding-left: 20px; 
            color: var(--text-main); 
        }
        .info-card ul li { 
            margin-bottom: 8px; 
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .hero { padding: 80px 20px 120px 20px; }
            .hero h1 { font-size: 2.2rem; }
            .job-container { margin-top: -50px; }
            .form-row { flex-direction: column; gap: 0; }
            .form-actions { flex-direction: column; }
            .btn-open-form { width: 100%; }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <!-- Hero dengan transisi halus ke warna halaman -->
    <div class="hero">
        <h1>Mari Melayani dengan Kasih Sayang</h1>
        <p>Kembangkan karir Anda bersama tim kami dalam lingkungan kerja yang bersahabat, profesional, dan humanis.</p>
    </div>

    <div class="job-container">
        <?php if ($msg): ?>
            <div id="alert-box" class="alert <?= $msgClass ?>"><?= $msg ?></div>
        <?php endif; ?>

        <div id="daftar-lowongan">
            <?php if (count($jobs) > 0): ?>
                <?php foreach ($jobs as$job): ?>
                    <div class="job-item">
                        <div class="job-header">
                            <div class="job-title"><?= htmlspecialchars($job['title']) ?></div>
                            <div class="job-badges">
                                <span class="badge badge-dept">🏢 <?= htmlspecialchars($job['department']) ?></span>
                            </div>
                        </div>
                        
                        <div class="job-content">
                            <div class="section-title">📝 Deskripsi Pekerjaan</div>
                            <p class="desc-text"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
                            
                            <div class="section-title">🎯 Kualifikasi Utama</div>
                            <ul class="req-list">
                                <?php 
                                    $req_raw =$job['requirements'];
                                    $req_raw = preg_replace('/<br\s*?\/?>/i', "\n", $req_raw);
                                    $req_lines = preg_split("/\R/u", $req_raw);
                                    
                                    foreach ($req_lines as$line): 
                                        $line = trim(strip_tags($line));
                                        $line = ltrim($line, '-*•· '); 
                                        if ($line !== ''): 
                                ?>
                                    <li><?= htmlspecialchars($line) ?></li>
                                <?php 
                                        endif; 
                                    endforeach; 
                                ?>
                            </ul>

                            <button type="button" class="btn-open-form" onclick="bukaForm(this)">
                                Kirim Lamaran Sekarang 
                            </button>

                            <div class="apply-box">
                                <h4>Formulir Lamaran - <?= htmlspecialchars($job['title']) ?></h4>
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                    
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="full_name" required placeholder="Masukkan nama lengkap sesuai KTP">
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Nomor WhatsApp / Telepon</label>
                                            <input type="tel" name="phone" required placeholder="Contoh: 081234567890">
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Email</label>
                                            <input type="email" name="email" required placeholder="email.anda@domain.com">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Upload Berkas Lamaran (.zip / .rar) <span style="color:var(--text-soft); font-weight:normal;">Maks. 2MB</span></label>
                                        <input type="file" name="resume" accept=".zip,.rar" required>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" name="apply_job" class="btn-apply">Kirim Berkas Lamaran</button>
                                        <button type="button" class="btn-cancel" onclick="tutupForm(this)">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align:center; padding: 60px 20px; background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <div style="font-size: 3rem; margin-bottom: 15px;">🌱</div>
                    <h3 style="color: var(--tzuchi-blue-dark); margin:0 0 10px 0;">Belum ada lowongan baru</h3>
                    <p style="color: var(--text-soft); margin:0;">Silakan kunjungi kembali halaman ini di lain waktu untuk update terbaru.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>🏢 Lokasi Pengiriman Fisik (Opsional)</h3>
                <p style="margin-top:0; font-weight:800;">HRD RS Cinta Kasih Tzu Chi</p>
                <p style="margin-bottom:15px; font-weight:700;">
                    Perumahan Cinta Kasih Tzu Chi<br>
                    Jl. Kamal Raya Outer Ring Road<br>
                    Cengkareng Timur, Jakarta Barat 11730
                </p>
                <p style="margin-bottom:0; font-size:0.95rem; font-weight:700;">
                    📞 Telp: (021) 559 636 80<br>
                    📠 Fax: (021) 559 636 81
                </p>
            </div>

            <div class="info-card">
                <h3>📂 Berkas yang Perlu Dilampirkan</h3>
                <ul>
                    <li>Surat Lamaran Kerja & CV</li>
                    <li>Fotocopy Ijazah & Transkrip Nilai</li>
                    <li>Fotocopy STR (Khusus tenaga medis)</li>
                    <li>Pas Photo 4 x 6 cm (1 Lembar)</li>
                    <li>Fotocopy e-KTP & Kartu Keluarga</li>
                    <li>Fotocopy NPWP</li>
                    <li>Sertifikat Vaksinasi Covid-19</li>
                </ul>
            </div>
        </div>
    </div>
    <footer id="kontak">
        <?php include 'footer.php' ?>
    </footer>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const alertBox = document.getElementById('alert-box');
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alertBox.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });

        function bukaForm(btn) {
            btn.style.display = 'none';
            const formBox = btn.nextElementSibling;
            formBox.style.display = 'block';
            formBox.classList.add('form-is-open');
        }

        function tutupForm(btn) {
            const formBox = btn.closest('.apply-box');
            formBox.style.display = 'none';
            formBox.classList.remove('form-is-open');
            
            const openBtn = formBox.previousElementSibling;
            if (openBtn) {
                openBtn.style.display = 'inline-flex';
            }
        }

        function muatDataOtomatis() {
            const adaFormTerbuka = document.querySelector('.form-is-open');
            const adaInputFokus = document.querySelector('input:focus, textarea:focus');
            
            if (adaFormTerbuka || adaInputFokus) {
                return; 
            }

            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const lowonganBaru = doc.getElementById('daftar-lowongan').innerHTML;
                    
                    document.getElementById('daftar-lowongan').innerHTML = lowonganBaru;
                })
                .catch(err => console.error('Gagal memuat AJAX:', err));
        }

        setInterval(muatDataOtomatis, 4000);
    </script>
</body>
</html>