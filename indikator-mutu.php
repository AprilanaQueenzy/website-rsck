<?php
// === KONEKSI DATABASE (Laragon) ===
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "db_rumahsakit";

$conn = mysqli_connect($host, $user, $pass, $db);

// Daftar 13 Indikator Mutu Nasional beserta nama file gambarnya di folder 'mutu'
$daftar_indikator = [
    [
        "nama" => "Kepatuhan Kebersihan Tangan",
        "file" => "mutu/kepatuhan_cuci_tangan.jpg"
    ],
    [
        "nama" => "Kepatuhan Penggunaan APD",
        "file" => "mutu/kepatuhan_apd.jpg"
    ],
    [
        "nama" => "Kepatuhan Identifikasi Pasien",
        "file" => "mutu/identifikasi_pasien.jpg"
    ],
    [
        "nama" => "Waktu Tanggap Seksio Sesarea Emergensi",
        "file" => "mutu/analisa_sc.jpg"
    ],
    [
        "nama" => "Waktu Tunggu Rawat Jalan",
        "file" => "mutu/waktu_tunggu.jpg"
    ],
    [
        "nama" => "Penundaan Operasi Elektif",
        "file" => "mutu/tunda_operasi.jpg"
    ],
    [
        "nama" => "Kepatuhan Waktu Visite Dokter",
        "file" => "mutu/visit_dokter.jpg"
    ],
    [
        "nama" => "Pelaporan Hasil Kritis Laboratorium",
        "file" => "mutu/hasil_kritis_lab.jpg"
    ],
    [
        "nama" => "Kepatuhan Penggunaan Formularium Nasional",
        "file" => "mutu/formularium.jpg"
    ],
    [
        "nama" => "Kepatuhan Terhadap Clinical Pathway",
        "file" => "mutu/alur_klinis.jpg"
    ],
    [
        "nama" => "Kepatuhan Upaya Pencegahan Risiko Pasien Jatuh",
        "file" => "mutu/risiko_jatuh.jpg"
    ],
    [
        "nama" => "Kecepatan Waktu Tanggap Terhadap Komplain",
        "file" => "mutu/respon_komplain.jpg"
    ],
    [
        "nama" => "Kepuasan Pasien",
        "file" => "mutu/kepuasan_pasien.jpg"
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indikator Mutu Nasional - RS Cinta Kasih Tzu Chi</title>
    <style>
        body {
            background-color: #f1f5f9;
            color: #1e293b;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Breadcrumb Minimalis */
        .breadcrumb-wrap {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 6px 0;
            font-size: 13px;
            color: #64748b;
        }

        .breadcrumb-body {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .breadcrumb-body a {
            color: #0284c7;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-body a:hover {
            text-decoration: underline;
        }

        /* Container Utama */
        .content-area {
            max-width: 1140px;
            margin: 0 auto;
            padding: 12px 20px 60px 20px;
        }

        /* Header Judul dengan Aksen Garis Modern */
        .page-header-box {
            margin-bottom: 15px;
            border-left: 4px solid #0284c7;
            padding-left: 12px;
        }

        h1.main-heading {
            font-size: 21px;
            color: #0f172a;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .sub-heading-text {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
            margin-bottom: 0;
        }

        /* Kotak Pengantar */
        .intro-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-top: 3px solid #0284c7;
            border-radius: 6px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .intro-box p {
            font-size: 14px;
            color: #334155;
            margin-bottom: 10px;
            text-align: justify;
        }

        .intro-box p:last-child {
            margin-bottom: 0;
        }

        /* Judul Section Bawah */
        .section-title-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .badge-periode {
            background: #e0f2fe;
            color: #0369a1;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Grid 2 Kolom */
        .grid-indikator {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .grid-indikator {
                grid-template-columns: 1fr;
            }
        }

        /* Kartu Indikator */
        .card-item {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 18px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
        }

        .card-item:hover {
            border-color: #0284c7;
            box-shadow: 0 6px 12px rgba(2, 132, 199, 0.08);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .number-badge {
            width: 28px;
            height: 28px;
            background: #0284c7;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(2, 132, 199, 0.2);
        }

        .card-title {
            font-size: 14px;
            color: #1e293b;
            margin: 0;
            font-weight: 600;
        }

        /* Tempat Menampilkan Foto Grafik */
        .chart-container {
            width: 100%;
            height: 220px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Memanggil Header -->
    <?php include 'header.php'; ?>

    <div class="breadcrumb-wrap">
        <div class="breadcrumb-body">
            <a href="index.php">Beranda</a> &gt; Informasi &gt; <span>Indikator Mutu</span>
        </div>
    </div>

    <div class="content-area">
        <div class="page-header-box">
            <h1 class="main-heading">Indikator Mutu Nasional Rumah Sakit</h1>
            <p class="sub-heading-text">Transparansi Mutu Pelayanan & Keselamatan Pasien RS Cinta Kasih Tzu Chi</p>
        </div>
        
        <div class="intro-box">
            <p>
                RS Cinta Kasih Tzu Chi senantiasa berkomitmen untuk memberikan pelayanan kesehatan yang aman, bermutu, dan berorientasi pada keselamatan serta kepuasan pasien. Komitmen ini diwujudkan melalui pemantauan dan evaluasi Indikator Mutu Rumah Sakit secara berkesinambungan sebagai bagian dari upaya peningkatan kualitas pelayanan.
            </p>
            <p>
                Sepanjang tahun 2025, RS Cinta Kasih Tzu Chi telah melaksanakan pemantauan indikator mutu pada berbagai aspek pelayanan, baik klinis, keselamatan pasien, manajemen, maupun tata kelola rumah sakit. Pemantauan ini dilakukan secara sistematis, terukur, dan berkelanjutan sesuai dengan regulasi serta standar akreditasi rumah sakit yang berlaku.
            </p>
            <p>
                Melalui publikasi pencapaian indikator mutu ini, RS Cinta Kasih Tzu Chi berupaya mewujudkan transparansi kepada masyarakat sekaligus sebagai bentuk akuntabilitas dalam penyelenggaraan pelayanan kesehatan. Ke depan, rumah sakit akan terus melakukan evaluasi dan perbaikan berkelanjutan guna memastikan mutu pelayanan yang semakin baik, humanis, dan berlandaskan cinta kasih universal.
            </p>
        </div>

        <div class="section-title-wrapper">
            <span class="section-title">Capaian Indikator Mutu Nasional (INM)</span>
            <span class="badge-periode">Periode Tahun 2025</span>
        </div>

        <div class="grid-indikator">
            <?php foreach ($daftar_indikator as $index => $item): 
                $nomor = $index + 1;
                $file_gambar = $item['file'];
            ?>
                <div class="card-item">
                    <div class="card-header">
                        <div class="number-badge"><?php echo $nomor; ?></div>
                        <h3 class="card-title"><?php echo $item['nama']; ?></h3>
                    </div>
                    <div class="chart-container">
                        <?php if (file_exists($file_gambar)): ?>
                            <img src="<?php echo $file_gambar; ?>" alt="Grafik <?php echo $item['nama']; ?>">
                        <?php else: ?>
                            <span style="color: #64748b; font-size: 12px; text-align: center; padding: 10px; font-weight: 500;">
                                [ File belum diunggah: <?php echo $file_gambar; ?> ]
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php if (file_exists('footer.php')) include 'footer.php'; ?>

</body>
</html>