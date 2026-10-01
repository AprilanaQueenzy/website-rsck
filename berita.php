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

// === AMBIL SEMUA BERITA URUTKAN DARI YANG TERBARU ===
$query_all = "SELECT * FROM berita ORDER BY id DESC";
$res_all   = mysqli_query($conn, $query_all);

$semua_berita = [];
if ($res_all && mysqli_num_rows($res_all) > 0) {
    while ($row = mysqli_fetch_assoc($res_all)) {
        $semua_berita[] = $row;
    }
}

// === TENTUKAN POSISI BERDASARKAN URUTAN TERBARU ===
$utama   = null;
$samping = [];
$bawah   = [];

if (!empty($semua_berita)) {
    // 1. Berita TERBARU (paling atas) langsung jadi UTAMA (Kiri)
    $utama = $semua_berita[0];

    // 2. Berita berikutnya (maksimal 4 berita) masuk ke KANAN (Berita Terkini)
    $samping = array_slice($semua_berita, 1, 4);

    // 3. Sisanya masuk ke BAGIAN BAWAH (Artikel Lainnya) dimulai dari indeks ke-5
    $bawah = array_slice($semua_berita, 5);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Informasi - RS Cinta Kasih Tzu Chi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .berita-page-body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            color: #1e293b;
            line-height: 1.6;
        }

        .berita-container {
            max-width: 1140px;
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

        /* HEADER HALAMAN GAYA EDITORIAL HALUS */
        .page-header-berita {
            padding-bottom: 16px;
            margin-bottom: 36px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .page-header-berita h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin: 0;
        }

        .page-header-berita span {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* BAGIAN UTAMA ATAS (SPLIT EDITORIAL) */
        .top-section-berita {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 48px;
            margin-bottom: 56px;
            align-items: start;
        }

        .top-section-berita.single-article {
            grid-template-columns: 1fr;
        }

        /* BERITA UTAMA (KIRI) */
        .main-article-berita {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .main-img-wrap-berita {
            width: 100%;
            height: 320px;
            border-radius: 6px;
            overflow: hidden;
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .main-img-wrap-berita img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            transition: opacity 0.3s ease;
        }

        .main-article-berita:hover .main-img-wrap-berita img {
            opacity: 0.9;
        }

        .meta-line-berita {
            font-size: 0.775rem;
            margin-bottom: 8px;
            color: #64748b;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .main-title-berita {
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1.35;
            color: #0f172a;
            margin: 0 0 12px 0;
            transition: color 0.2s ease;
        }

        .main-article-berita:hover .main-title-berita {
            color: #0284c7;
        }

        .main-desc-berita {
            font-size: 0.95rem;
            color: #475569;
            line-height: 1.7;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* KOLOM KANAN: BERITA TERKINI */
        .side-articles-berita {
            display: flex;
            flex-direction: column;
            border-left: 1px solid #f1f5f9;
            padding-left: 36px;
        }

        .side-header-title-berita {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .side-item-berita {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #f8fafc;
        }

        .side-item-berita:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .side-date-mini {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .side-title-berita {
            font-size: 1.025rem;
            font-weight: 700;
            line-height: 1.4;
            color: #0f172a;
            margin: 0 0 6px 0;
            transition: color 0.2s ease;
        }

        .side-item-berita:hover .side-title-berita {
            color: #0284c7;
        }

        .side-desc-berita {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        /* SECTION BAWAH: ARTIKEL LAINNYA */
        .section-label-berita {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 28px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .grid-section-berita {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .grid-item-berita {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        .grid-img-wrap-berita {
            width: 100%;
            height: 190px;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 16px;
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .grid-img-wrap-berita img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            transition: opacity 0.3s ease;
        }

        .grid-item-berita:hover .grid-img-wrap-berita img {
            opacity: 0.9;
        }

        .grid-title-berita {
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.4;
            color: #0f172a;
            margin: 0 0 8px 0;
            transition: color 0.2s ease;
        }

        .grid-item-berita:hover .grid-title-berita {
            color: #0284c7;
        }

        .grid-desc-berita {
            font-size: 0.875rem;
            color: #64748b;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.55;
            margin: 0;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 900px) {
            .top-section-berita {
                grid-template-columns: 1fr;
                gap: 36px;
            }
            .side-articles-berita {
                border-left: none;
                padding-left: 0;
                border-top: 1px solid #f1f5f9;
                padding-top: 32px;
            }
            .grid-section-berita {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .grid-section-berita {
                grid-template-columns: 1fr;
            }
            .main-title-berita {
                font-size: 1.35rem;
            }
            .page-header-berita {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }
        }
    </style>
</head>
<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <div class="berita-page-body">
        <main class="berita-container">
            
            <div class="page-header-berita">
                <h1>Berita & Informasi</h1>
                <span>RS Cinta Kasih Tzu Chi</span>
            </div>

            <?php if ($utama): ?>
                <section class="top-section-berita <?php echo empty($samping) ? 'single-article' : ''; ?>">
                    
                    <!-- BERITA UTAMA (KIRI) -->
                    <a href="detail-berita.php?id=<?php echo $utama['id']; ?>" class="main-article-berita">
                        <div class="main-img-wrap-berita">
                            <?php if (!empty($utama['foto'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($utama['foto']); ?>" alt="Foto Berita Utama">
                            <?php else: ?>
                                <div style="color:#cbd5e1; font-size:0.8rem;">No Image</div>
                            <?php endif; ?>
                        </div>
                        <div class="meta-line-berita">
                            <span><?php echo htmlspecialchars($utama['tanggal']); ?></span>
                        </div>
                        <h2 class="main-title-berita"><?php echo htmlspecialchars($utama['judul']); ?></h2>
                        <p class="main-desc-berita"><?php echo htmlspecialchars($utama['konten']); ?></p>
                    </a>

                    <!-- BERITA TERKINI (KANAN - MAKSIMAL 4) -->
                    <?php if (!empty($samping)): ?>
                        <div class="side-articles-berita">
                            <div class="side-header-title-berita">Berita Terkini</div>
                            <?php foreach ($samping as $item): ?>
                                <a href="detail-berita.php?id=<?php echo $item['id']; ?>" class="side-item-berita">
                                    <div class="side-date-mini"><?php echo htmlspecialchars($item['tanggal']); ?></div>
                                    <h3 class="side-title-berita"><?php echo htmlspecialchars($item['judul']); ?></h3>
                                    <p class="side-desc-berita"><?php echo htmlspecialchars($item['konten']); ?></p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </section>

                <!-- ARTIKEL LAINNYA (BAGIAN BAWAH) -->
                <?php if (!empty($bawah)): ?>
                    <div class="section-label-berita">Artikel Lainnya</div>
                    <section class="grid-section-berita">
                        <?php foreach ($bawah as $item): ?>
                            <a href="detail-berita.php?id=<?php echo $item['id']; ?>" class="grid-item-berita">
                                <div class="grid-img-wrap-berita">
                                    <?php if (!empty($item['foto'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($item['foto']); ?>" alt="<?php echo htmlspecialchars($item['judul']); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div style="color:#cbd5e1; font-size:0.75rem;">No Image</div>
                                    <?php endif; ?>
                                </div>
                                <div class="meta-line-berita">
                                    <span><?php echo htmlspecialchars($item['tanggal']); ?></span>
                                </div>
                                <h3 class="grid-title-berita"><?php echo htmlspecialchars($item['judul']); ?></h3>
                                <p class="grid-desc-berita"><?php echo htmlspecialchars($item['konten']); ?></p>
                            </a>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>

            <?php else: ?>
                <p style="text-align: center; color: #64748b; padding: 40px 0;">Belum ada berita yang tersedia.</p>
            <?php endif; ?>
        </main>
    </div>

    <?php if (file_exists('footer.php')) include 'footer.php'; ?>

</body>
</html>