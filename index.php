<?php

// Memunculkan error agar kalau ada salah ketik langsung terlihat
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// === AMBIL DATA BERITA TERBARU DARI DATABASE ===
$query_berita = "SELECT * FROM berita ORDER BY id DESC LIMIT 4";
$result_berita = mysqli_query($conn, $query_berita);

// Fungsi format tanggal
function formatTanggal($tanggal) {
    return date('d M Y', strtotime($tanggal));
}

$daftar_fasilitas = [
    [
        "no" => "01",
        "nama" => "Rawat Inap & Intensif",
        "kategori" => "Layanan Perawatan",
        "deskripsi" => "Fasilitas akomodasi medis terpadu mulai dari Kelas 3 hingga SVIP, dilengkapi unit perawatan khusus seperti ICU, NICU, dan PICU dengan pemantauan medis 24 jam."
    ],
    [
        "no" => "02",
        "nama" => "Poliklinik Rawat Jalan",
        "kategori" => "Konsultasi Spesialis",
        "deskripsi" => "Pemeriksaan dan konsultasi komprehensif bersama puluhan dokter spesialis lintas disiplin ilmu medis dengan dukungan sistem antrean digital modern."
    ],
    [
        "no" => "03",
        "nama" => "Instalasi Gawat Darurat 24/7",
        "kategori" => "Penanganan Darurat",
        "deskripsi" => "Unit emergensi siap siaga dengan triase terstandar, didukung dokter bedah, perawat gawat darurat, serta armada ambulans tanggap cepat."
    ],
    [
        "no" => "04",
        "nama" => "Pusat Onkologi & Radiasi",
        "kategori" => "Layanan Unggulan",
        "deskripsi" => "Fasilitas penanganan terapi kanker terpadu menggunakan teknologi radioterapi presisi tinggi guna memberikan hasil terapi optimal bagi pasien."
    ],
    [
        "no" => "05",
        "nama" => "Rehabilitasi Medik & Fisioterapi",
        "kategori" => "Pemulihan Fungsi",
        "deskripsi" => "Layanan terapi restorasi fungsi gerak tubuh untuk pemulihan pascaoperasi, stroke, cedera olahraga, hingga gangguan neuromuskular."
    ],
    [
        "no" => "06",
        "nama" => "Farmasi & Penunjang Medis",
        "kategori" => "Layanan Penunjang",
        "deskripsi" => "Penyediaan obat-obatan terverifikasi secara presisi serta edukasi informasi obat langsung oleh tim apoteker profesional."
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit Cinta Kasih Tzu Chi Cengkareng</title>
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --secondary: #38bdf8;
            --accent: #e0f2fe;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--white);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeInUp 0.8s ease forwards; }

        .hero-banner {
            padding: 40px 2% 40px 2%; 
            background-color: var(--bg-light);
            background-image: radial-gradient(rgba(100, 116, 139, 0.15) 2px, transparent 2px);
            background-size: 35px 35px;
            text-align: center;
            position: relative; 
            overflow: hidden; 
        }

        .water-line {
            position: absolute;
            z-index: 0; 
            pointer-events: none; 
            background: transparent;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }

        .line-left-1 { top: -15%; left: -10%; width: 500px; height: 500px; border: 2px solid rgba(56, 189, 248, 0.4); animation: morphWater 12s ease-in-out infinite, spinWater 25s linear infinite; }
        .line-right-1 { bottom: -20%; right: -10%; width: 550px; height: 550px; border: 2px solid rgba(56, 189, 248, 0.3); animation: morphWater 11s ease-in-out infinite, spinWater 26s linear infinite; }

        @keyframes morphWater {
            0%, 100% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
            34% { border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%; }
            67% { border-radius: 100% 60% 60% 100% / 100% 100% 60% 60%; }
        }
        @keyframes spinWater {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .hero-image-container {
            max-width: 1120px;
            margin: 0 auto 20px auto;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1); 
            display: grid;
            position: relative;
            z-index: 2; 
        }

        .image-wrapper {
            position: relative;
            width: 100%;
            display: grid;
        }

        .image-wrapper img {
            grid-area: 1 / 1;
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .image-wrapper img:nth-child(1) { z-index: 1; opacity: 1; }
        .image-wrapper img:nth-child(n+2) {
            z-index: 2;
            opacity: 0;
            animation: fadeOverlay 16s infinite ease-in-out;
        }

        .image-wrapper img:nth-child(2) { animation-delay: 4s; }
        .image-wrapper img:nth-child(3) { animation-delay: 8s; }
        .image-wrapper img:nth-child(4) { animation-delay: 12s; }

        @keyframes fadeOverlay {
            0% { opacity: 0; }
            5% { opacity: 1; }
            25% { opacity: 1; }
            30% { opacity: 0; }
            100% { opacity: 0; }
        }

        /* Warna teks dibuat sedikit lebih redup (tidak terlalu pekat/terang) tapi tetap tajam dibaca */
        .accreditation-text {
            max-width: 1000px;
            margin: 0 auto;
            font-size: 0.92rem;
            color: #334155;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            padding: 12px 25px;
            border-radius: 30px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(203, 213, 225, 0.8);
            display: inline-block;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        /* --- BAGIAN BERITA --- */
        .section-berita {
            padding: 35px 5% 45px 5%; 
            background-color: var(--white);
            border-bottom: 1px solid #e2e8f0;
        }

        .berita-container {
            max-width: 1120px;
            margin: 0 auto;
        }

        .berita-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .berita-title-area h2 {
            font-size: 1.9rem;
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .berita-title-area p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .btn-semua-berita {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-semua-berita:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .berita-row-layout {
            display: flex;
            gap: 25px;
            justify-content: space-between;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .berita-item-clean {
            flex: 1;
            min-width: 250px;
            display: flex;
            flex-direction: column;
            background: transparent; 
            border: none;
            box-shadow: none;
        }

        .berita-thumb {
            width: 100%;
            height: 140px; 
            border-radius: 10px;
            overflow: hidden;
            background: #e2e8f0;
            margin-bottom: 12px;
        }

        .berita-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .berita-meta-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .berita-item-clean h3 {
            font-size: 1rem; 
            color: var(--text-main);
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .berita-item-clean p {
            font-size: 0.85rem; 
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .berita-link-clean {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: auto;
        }

        .berita-link-clean:hover {
            text-decoration: underline;
        }

        /* --- BAGIAN FASILITAS --- */
        .section-fasilitas-modern {
            padding: 40px 5% 45px 5%; 
            background-color: var(--white);
        }

        .fasilitas-modern-container {
            max-width: 1140px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 50px;
            align-items: start;
        }

        .fasilitas-left-panel {
            padding-right: 10px;
        }

        .fasilitas-tag {
            display: inline-block;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--primary);
            background: var(--accent);
            padding: 6px 14px;
            border-radius: 30px;
            margin-bottom: 16px;
        }

        .fasilitas-left-panel h2 {
            font-size: 2.2rem;
            color: var(--text-main);
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .fasilitas-left-panel p {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .btn-explores {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 26px;
            background-color: var(--primary);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.92rem;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.2);
        }

        .btn-explores:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(2, 132, 199, 0.3);
        }

        .fasilitas-stats-box {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #cbd5e1;
        }

        .stat-item {
            background: var(--bg-light);
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .stat-item h4 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .stat-item p {
            font-size: 0.82rem !important;
            color: var(--text-muted);
            line-height: 1.4 !important;
            margin-bottom: 0 !important;
        }

        .emergency-callout {
            margin-top: 20px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 14px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .callout-badge {
            background: var(--primary);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .callout-text {
            display: flex;
            flex-direction: column;
        }

        .callout-text span {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .callout-text strong {
            font-size: 0.95rem;
            color: var(--primary-dark);
        }

        .fasilitas-right-list {
            display: flex;
            flex-direction: column;
        }

        .fasilitas-row-item {
            display: grid;
            grid-template-columns: 50px 1fr;
            align-items: center;
            padding: 26px 20px;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 12px;
        }

        .fasilitas-row-item:first-child {
            border-top: 1px solid #f1f5f9;
        }

        .fasilitas-row-num {
            font-size: 1.1rem;
            font-weight: 800;
            color: #94a3b8;
        }

        .fasilitas-row-content {
            padding-right: 10px;
        }

        .fasilitas-row-cat {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--primary);
            margin-bottom: 4px;
            display: block;
        }

        .fasilitas-row-content h3 {
            font-size: 1.25rem;
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 6px;
        }

        .fasilitas-row-content p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* --- MITRA KAMI --- */
        .rs-mitra-section {
            padding: 35px 0 45px 0; 
            background: var(--bg-light); 
            border-top: 1px solid #e2e8f0;
            overflow: hidden;
            width: 100%;
            box-sizing: border-box;
            position: relative;
            z-index: 5;
        }

        .rs-mitra-title {
            text-align: center;
            color: var(--text-main);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .rs-mitra-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.95rem;
            max-width: 650px;
            margin: 0 auto 20px auto; 
        }

        .rs-mitra-slider {
            display: flex;
            width: 100%;
            overflow: hidden;
            position: relative;
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }

        .rs-mitra-track {
            display: flex;
            gap: 20px;
            width: max-content;
            align-items: center;
            animation: scrollMitra 20s linear infinite;
        }

        .rs-mitra-item {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            height: 120px; 
            min-width: 180px; 
            background: var(--white);
            padding: 15px 20px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .rs-mitra-item img {
            height: 90px; 
            max-width: 160px; 
            object-fit: contain;
        }

        @keyframes scrollMitra {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        @media (max-width: 900px) {
            .berita-row-layout { flex-direction: column; }
            .fasilitas-modern-container { grid-template-columns: 1fr; gap: 35px; }
            .fasilitas-left-panel { padding-right: 0; }
        }

        @media (max-width: 600px) {
            .fasilitas-row-item { grid-template-columns: 1fr; gap: 10px; padding: 20px 10px; }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section class="hero-banner animate-fade-up">
        <div class="water-line line-left-1"></div>
        <div class="water-line line-right-1"></div>

        <div class="hero-image-container">
            <div class="image-wrapper">
                <img src="BANNER-4.jpg" alt="Banner Mewariskan Cinta Kasih">
                <img src="BANNER-1.jpg" alt="Banner 2">
                <img src="BANNER-2.jpg" alt="Banner 3">
                <img src="BANNER-3.jpg" alt="Banner 4">
            </div>
        </div>

        <div class="accreditation-text">
            Rumah Sakit Cinta Kasih Tzu Chi telah terakreditasi Komisi Akreditasi Rumah Sakit (KARS) dengan Nomor Sertifikat KARS-SERT/265/XI/2022.
        </div>
    </section>

    <!-- BAGIAN BERITA -->
    <section class="section-berita">
        <div class="berita-container">
            <div class="berita-header">
                <div class="berita-title-area">
                    <h2>Berita & Kegiatan Terbaru</h2>
                    <p>Informasi terkini seputar pelayanan medis, edukasi kesehatan, dan program sosial rumah sakit.</p>
                </div>
                <a href="berita.php" class="btn-semua-berita">Lihat Semua Berita &rarr;</a>
            </div>

            <div class="berita-row-layout">
                <?php if ($result_berita && mysqli_num_rows($result_berita) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result_berita)) : ?>
                    <article class="berita-item-clean">
                        <div class="berita-thumb">
                            <img src="uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                        </div>
                        <div class="berita-meta-date"><?php echo formatTanggal($row['tanggal']); ?></div>
                        <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <p><?php echo htmlspecialchars($row['konten']); ?></p>
                        <a href="detail-berita.php?id=<?php echo $row['id']; ?>" class="berita-link-clean">Baca Selengkapnya &rarr;</a>
                    </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; color: var(--text-muted); padding: 20px 0; width: 100%;">Belum ada berita terbaru.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- BAGIAN FASILITAS -->
    <section class="section-fasilitas-modern">
        <div class="fasilitas-modern-container">
            <div class="fasilitas-left-panel">
                <span class="fasilitas-tag">Fasilitas Medis</span>
                <h2>Layanan Kesehatan Terpadu & Modern</h2>
                <p>Kami menghadirkan infrastruktur medis komprehensif, didukung tenaga profesional serta teknologi terdepan untuk kenyamanan dan pemulihan Anda.</p>
                <a href="layanan.php" class="btn-explores">
                    <span>Lihat Selengkapnya</span>
                    <span>&rarr;</span>
                </a>
                
                <div class="fasilitas-stats-box">
                    <div class="stat-item">
                        <h4>IGD 24 Jam</h4>
                        <p>Instalasi Gawat Darurat & Armada Ambulans Tanggap Cepat</p>
                    </div>
                    <div class="stat-item">
                        <h4>50+ Dokter Spesialis</h4>
                        <p>Konsultasi lintas disiplin ilmu medis profesional</p>
                    </div>
                </div>

                <div class="emergency-callout">
                    <div class="callout-badge">IGD</div>
                    <div class="callout-text">
                        <span>Butuh Bantuan Darurat?</span>
                        <strong>(021) 5596-3080</strong>
                    </div>
                </div>
            </div>
            
            <div class="fasilitas-right-list">
                <?php foreach($daftar_fasilitas as $fas) : ?>
                <div class="fasilitas-row-item">
                    <div class="fasilitas-row-num"><?php echo $fas['no']; ?></div>
                    <div class="fasilitas-row-content">
                        <span class="fasilitas-row-cat"><?php echo htmlspecialchars($fas['kategori']); ?></span>
                        <h3><?php echo htmlspecialchars($fas['nama']); ?></h3>
                        <p><?php echo htmlspecialchars($fas['deskripsi']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- BAGIAN MITRA KAMI -->
    <section class="rs-mitra-section">
        <h2 class="rs-mitra-title">Mitra Kami</h2>
        <p class="rs-mitra-subtitle">Kami bangga dapat bekerja sama dengan berbagai instansi terkemuka untuk memberikan pelayanan kesehatan terbaik.</p>
        <div class="rs-mitra-slider">
            <div class="rs-mitra-track">
                <div class="rs-mitra-item"><img src="sinarmas.png" alt="Sinar Mas"></div>
                <div class="rs-mitra-item"><img src="biggy.jpeg" alt="Biggy"></div>
                <div class="rs-mitra-item"><img src="bpjskesehatan.jpeg" alt="BPJS Kesehatan"></div>
                <div class="rs-mitra-item"><img src="jasaraharja.jpeg" alt="Jasa Raharja"></div>
                <div class="rs-mitra-item"><img src="hsrcc.jpeg" alt="HSRCC"></div>
                <div class="rs-mitra-item"><img src="daai.jpeg" alt="DAAI"></div>
                <div class="rs-mitra-item"><img src="cws.jpeg" alt="Church World Services"></div>
                <div class="rs-mitra-item"><img src="asg.jpeg" alt="Agung Sedayu Group"></div>  
                <div class="rs-mitra-item"><img src="sinarmas.png" alt="Sinar Mas"></div>
                <div class="rs-mitra-item"><img src="biggy.jpeg" alt="Biggy"></div>
                <div class="rs-mitra-item"><img src="bpjskesehatan.jpeg" alt="BPJS Kesehatan"></div>
                <div class="rs-mitra-item"><img src="jasaraharja.jpeg" alt="Jasa Raharja"></div>
                <div class="rs-mitra-item"><img src="hsrcc.jpeg" alt="HSRCC"></div>
                <div class="rs-mitra-item"><img src="daai.jpeg" alt="DAAI"></div>
                <div class="rs-mitra-item"><img src="cws.jpeg" alt="Church World Services"></div>
                <div class="rs-mitra-item"><img src="asg.jpeg" alt="Agung Sedayu Group"></div>
            </div>
        </div>
    </section>
    <footer id="kontak">
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>