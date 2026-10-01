<?php
// === KONEKSI DATABASE ===
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "db_rumahsakit";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// === AMBIL ID BERITA DARI URL ===
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data berita utama berdasarkan ID
$query = "SELECT * FROM berita WHERE id = $id";
$result = mysqli_query($conn, $query);
$berita = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;

// Ambil ID berita yang sedang dibaca dan kumpulkan ID yang akan ditampilkan di sidebar (supaya tidak duplikat di bawah)
$sidebar_ids = [$id];

// 1. Ambil berita untuk sidebar kanan (secara ACAK, maksimal 5 berita)
$query_sidebar = "SELECT * FROM berita WHERE id != $id ORDER BY RAND() LIMIT 5";
$result_sidebar = mysqli_query($conn, $query_sidebar);

$sidebar_fetched_ids = [];
if ($result_sidebar && mysqli_num_rows($result_sidebar) > 0) {
    // Kita simpan dulu datanya ke array agar bisa dipakai untuk mengecualikan ID di bagian bawah
    $sidebar_data = [];
    while ($row = mysqli_fetch_assoc($result_sidebar)) {
        $sidebar_data[] = $row;
        $sidebar_fetched_ids[] = $row['id'];
    }
}

// Gabungkan ID berita utama dan sidebar untuk pengecualian di bagian bawah
$exclude_ids = array_merge([$id], $sidebar_fetched_ids);
$exclude_ids_str = implode(',', $exclude_ids);

// 2. Ambil berita untuk bagian bawah (secara ACAK, maksimal 4 berita, dan pastikan TIDAK ADA yang sama dengan sidebar)
$query_bawah = "SELECT * FROM berita WHERE id NOT IN ($exclude_ids_str) ORDER BY RAND() LIMIT 4";
$result_bawah = mysqli_query($conn, $query_bawah);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $berita ? htmlspecialchars($berita['judul']) : 'Berita Tidak Ditemukan'; ?> - RS Cinta Kasih Tzu Chi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            color: #1e293b;
            line-height: 1.8;
        }

        .berita-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        .berita-container *, 
        .berita-container *::before, 
        .berita-container *::after {
            box-sizing: border-box;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        /* TOMBOL KEMBALI */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #0284c7;
            text-decoration: none;
            margin-bottom: 32px;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #0369a1;
        }

        /* LAYOUT GRID UTAMA */
        .detail-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 48px;
            align-items: start;
            margin-bottom: 60px;
            padding-bottom: 40px;
            border-bottom: 1px solid #e2e8f0;
        }

        .main-article {
            background: transparent;
            padding: 0;
        }

        .detail-header {
            margin-bottom: 24px;
        }

        .detail-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            letter-spacing: -0.02em;
            margin: 0 0 12px 0;
        }

        .detail-meta {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }

        /* FOTO UTAMA KIRI */
        .detail-img-wrap {
            width: 100%;
            max-height: 420px;
            border-radius: 12px;
            overflow: hidden;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
        }

        .detail-img-wrap img {
            width: 100%;
            height: auto;
            max-height: 420px;
            object-fit: contain;
            display: block;
        }

        .detail-content {
            font-size: 1.05rem;
            color: #334155;
            line-height: 1.85;
        }

        .detail-content p {
            margin-bottom: 20px;
        }

        /* SIDEBAR KANAN */
        .sidebar {
            background: transparent;
            padding: 0;
        }

        .sidebar-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #cbd5e1;
        }

        .sidebar-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sidebar-item {
            display: flex;
            flex-direction: column;
            text-decoration: none;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .sidebar-item:hover .sidebar-item-title {
            color: #0284c7;
        }

        .sidebar-item-date {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .sidebar-item-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s ease;
            margin: 0 0 4px 0;
        }

        /* RINGKASAN / EXCERPT DI SIDEBAR KANAN */
        .sidebar-item-excerpt {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        /* BAGIAN BAWAH (DENGAN FOTO) */
        .section-bawah {
            background: transparent;
            padding: 0;
        }

        .section-bawah-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 24px;
        }

        .grid-bawah {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .card-bawah {
            background: transparent;
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }

        .card-bawah:hover .card-bawah-title {
            color: #0284c7;
        }

        .card-bawah-thumb-wrap {
            width: 100%;
            height: 140px;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .card-bawah-thumb-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .card-bawah-date {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .card-bawah-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        /* NOT FOUND */
        .not-found {
            text-align: center;
            padding: 60px 20px;
            grid-column: 1 / -1;
        }

        .not-found h2 {
            font-size: 1.5rem;
            color: #0f172a;
            margin-bottom: 12px;
        }

        .not-found p {
            color: #64748b;
            margin-bottom: 24px;
        }

        @media (max-width: 992px) {
            .detail-layout {
                grid-template-columns: 1fr;
            }
            .grid-bawah {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .detail-title {
                font-size: 1.75rem;
            }
            .grid-bawah {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <main class="berita-container">
        <?php if ($berita): ?>
            <a href="berita.php" class="back-link">
                &larr; Kembali ke Berita & Informasi
            </a>

            <!-- BAGIAN UTAMA -->
            <div class="detail-layout">
                <!-- KOLOM KIRI: ARTIKEL UTAMA -->
                <article class="main-article">
                    <div class="detail-header">
                        <h1 class="detail-title"><?php echo htmlspecialchars($berita['judul']); ?></h1>
                        <div class="detail-meta">
                            <span>Dipublikasikan pada <?php echo htmlspecialchars($berita['tanggal']); ?></span>
                        </div>
                    </div>

                    <?php if (!empty($berita['foto'])): ?>
                        <div class="detail-img-wrap">
                            <img src="uploads/<?php echo htmlspecialchars($berita['foto']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="detail-content">
                        <?php 
                            echo nl2br(htmlspecialchars($berita['konten'])); 
                        ?>
                    </div>
                </article>

                <!-- KOLOM KANAN: SIDEBAR BERITA LAINNYA (ACAK) -->
                <aside class="sidebar">
                    <h3 class="sidebar-title">BERITA TERKINI</h3>
                    <div class="sidebar-list">
                        <?php if (!empty($sidebar_data)): ?>
                            <?php foreach ($sidebar_data as $row): ?>
                                <a href="detail-berita.php?id=<?php echo $row['id']; ?>" class="sidebar-item">
                                    <span class="sidebar-item-date"><?php echo htmlspecialchars($row['tanggal']); ?></span>
                                    <h4 class="sidebar-item-title"><?php echo htmlspecialchars($row['judul']); ?></h4>
                                    <p class="sidebar-item-excerpt"><?php echo htmlspecialchars(substr(strip_tags($row['konten']), 0, 90)); ?>...</p>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="font-size: 0.9rem; color: #64748b; margin: 0;">Belum ada berita lainnya.</p>
                        <?php endif; ?>
                    </div>
                </aside>
            </div>

            <!-- BAGIAN BAWAH: GRID BERITA LAINNYA (DENGAN FOTO, ACAK, DAN TIDAK DUPLIKAT DARI SIDEBAR) -->
            <?php if ($result_bawah && mysqli_num_rows($result_bawah) > 0): ?>
                <section class="section-bawah">
                    <h3 class="section-bawah-title">Berita Terkait Lainnya</h3>
                    <div class="grid-bawah">
                        <?php while ($row_bawah = mysqli_fetch_assoc($result_bawah)): ?>
                            <a href="detail-berita.php?id=<?php echo $row_bawah['id']; ?>" class="card-bawah">
                                <div class="card-bawah-thumb-wrap">
                                    <?php if (!empty($row_bawah['foto'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($row_bawah['foto']); ?>" alt="<?php echo htmlspecialchars($row_bawah['judul']); ?>">
                                    <?php else: ?>
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#cbd5e1; font-size:0.75rem;">No Image</div>
                                    <?php endif; ?>
                                </div>
                                <span class="card-bawah-date"><?php echo htmlspecialchars($row_bawah['tanggal']); ?></span>
                                <h4 class="card-bawah-title"><?php echo htmlspecialchars($row_bawah['judul']); ?></h4>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif; ?>

        <?php else: ?>
            <div class="not-found">
                <h2>Berita Tidak Ditemukan</h2>
                <p>Maaf, berita yang Anda cari mungkin sudah dihapus atau tidak tersedia.</p>
                <a href="berita.php" class="back-link" style="display: inline-block;">&larr; Kembali ke Berita & Informasi</a>
            </div>
        <?php endif; ?>
    </main>

    <?php if (file_exists('footer.php')) include 'footer.php'; ?>

</body>
</html>