<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas & Layanan - RS Cinta Kasih Tzu Chi</title>
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --text-main: #1e293b;
            --text-sub: #64748b;
            --bg-body: #f8fafc;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
        }

        .breadcrumb-wrap {
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            padding: 12px 0;
        }

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-sub);
        }

        .breadcrumb a {
            color: var(--text-sub);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        .breadcrumb span#breadcrumb-current {
            color: var(--primary);
            font-weight: 600;
        }

        .page-layout {
            display: flex;
            gap: 32px;
            margin: 32px auto 60px;
            align-items: flex-start;
        }

        .sidebar {
            width: 280px;
            flex-shrink: 0;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            position: static;
        }

        .sidebar-header {
            padding: 16px 20px;
            background: #ffffff;
            border-bottom: 2px solid var(--primary);
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-main);
            letter-spacing: 0.3px;
        }

        .sidebar-menu {
            list-style: none;
            max-height: 600px;
            overflow-y: auto;
        }

        .sidebar-item {
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-item:last-child {
            border-bottom: none;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            color: #475569;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .sidebar-link:hover {
            background: #f8fafc;
            color: var(--primary);
        }

        .sidebar-link.active {
            background: #f0f9ff;
            color: var(--primary-dark);
            font-weight: 600;
            border-left: 3px solid var(--primary);
        }

        .sidebar-link .arrow {
            font-size: 1.1rem;
            color: #94a3b8;
            display: inline-block;
            transition: transform 0.2s ease;
        }

        .sidebar-link.active .arrow {
            color: var(--primary);
        }

        /* Sub-menu Dropdown Poliklinik */
        .submenu {
            list-style: none;
            background: #f8fafc;
            display: none;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .submenu.open {
            display: block;
        }

        .submenu-link {
            display: block;
            padding: 10px 20px 10px 36px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.82rem;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .submenu-link:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        .submenu-link.active {
            background: #e0f2fe;
            color: var(--primary-dark);
            font-weight: 600;
        }

        .badge-star {
            color: #d97706;
            font-weight: bold;
            font-size: 0.9rem;
            margin-left: 4px;
        }

        .content-area {
            flex-grow: 1;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 32px;
            min-height: 500px;
        }

        .service-panel {
            display: none;
        }

        .service-panel.active {
            display: block;
        }

        .service-header {
            margin-bottom: 16px;
        }

        .service-subtitle {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 4px;
        }

        .service-title {
            font-size: 1.6rem;
            color: var(--text-main);
            font-weight: 700;
        }

        .service-banner {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 14px;
            border: 1px solid var(--border);
        }

        .service-body {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            border: 1px solid #e2e8f0;
            border-left: 4px solid var(--primary);
            border-radius: 0 8px 8px 0;
            padding: 22px 24px;
        }

        .service-body p {
            margin-bottom: 14px;
            color: #334155;
            font-size: 0.94rem;
            line-height: 1.7;
        }

        .service-body p:last-child {
            margin-bottom: 0;
        }

        .service-body ul {
            list-style: none;
            margin-top: 12px;
            margin-bottom: 12px;
            padding-left: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .service-body ul li {
            background: #ffffff;
            border: 1px solid #edf2f7;
            border-radius: 6px;
            padding: 10px 14px;
            color: #475569;
            font-size: 0.89rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .service-body ul li::before {
            content: "✓";
            color: var(--primary);
            font-weight: bold;
            font-size: 0.95rem;
            line-height: 1.2;
        }

        /* Layout Grid Khusus Laboratorium & Radiologi */
        .lab-category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .lab-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 16px;
        }

        .lab-card h5 {
            color: var(--primary);
            font-size: 0.88rem;
            margin-bottom: 10px;
            font-weight: 600;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 6px;
            text-transform: uppercase;
        }

        .lab-card-list {
            margin: 0 !important;
            padding-left: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
        }

        .lab-card-list li {
            border: none !important;
            background: transparent !important;
            padding: 2px 0 !important;
            font-size: 0.85rem !important;
            color: #334155 !important;
        }

        .lab-card-list li::before {
            content: "•" !important;
            color: var(--primary) !important;
        }

        @media (max-width: 900px) {
            .page-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content-area {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Beranda</a>
                <span>/</span>
                <a href="#">Fasilitas & Layanan</a>
                <span>/</span>
                <span id="breadcrumb-current">IGD</span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-layout">
            <aside class="sidebar">
                <div class="sidebar-header">Daftar Layanan</div>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a class="sidebar-link active" onclick="switchTab('igd', this)">
                            <span>IGD</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>

                    <!-- Poliklinik dengan sistem Dropdown Buka-Tutup -->
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="togglePoliklinik(this)">
                            <span>Poliklinik</span>
                            <span class="arrow" id="poli-arrow">&rsaquo;</span>
                        </a>
                        <ul class="submenu" id="poli-submenu">
                            <li><a class="submenu-link" onclick="switchTab('poli-kesehatan-gigi-anak', this)">Poliklinik Kesehatan Gigi Anak</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-bedah-mulut', this)">Poliklinik Bedah Mulut & Maksilofasial</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-gigi-umum', this)">Poliklinik Gigi Umum</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-jantung', this)">Poliklinik Jantung</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-kebidanan', this)">Poliklinik Kebidanan & Kandungan</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-kulit-kelamin', this)">Poliklinik Kulit & Kelamin, Estetika</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-mata', this)">Poliklinik Mata <span class="badge-star">★</span></a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-neurologi', this)">Poliklinik Neurologi (Saraf)</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-orthodonti', this)">Poliklinik Orthodonti</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-orthopedi', this)">Poliklinik Orthopedi</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-penyakit-dalam', this)">Poliklinik Penyakit Dalam</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-prostodonti', this)">Poliklinik Prostodonti</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-tht', this)">Poliklinik Telinga-Hidung-Tenggorok (THT)</a></li>
                            <li><a class="submenu-link" onclick="switchTab('poli-urologi', this)">Poliklinik Urologi</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('hcu-icu', this)">
                            <span>HCU / ICU</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('isolasi', this)">
                            <span>Isolasi</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('maternity', this)">
                            <span>Maternity</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('perinatal', this)">
                            <span>Perinatal</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('rawat-inap-anak', this)">
                            <span>Rawat Inap Anak</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('rawat-inap-dewasa', this)">
                            <span>Rawat Inap Dewasa</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('farmasi', this)">
                            <span>Farmasi</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('homecare', this)">
                            <span>Homecare <span class="badge-star">★</span></span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('laboratorium', this)">
                            <span>Laboratorium</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('mcu', this)">
                            <span>Medical Check Up</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('radiologi', this)">
                            <span>Radiologi</span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('endoskopi-tht', this)">
                            <span>Endoskopi THT <span class="badge-star">★</span></span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('laser-fotona', this)">
                            <span>Laser Medis Fotona <span class="badge-star">★</span></span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('operasi-katarak', this)">
                            <span>Operasi Katarak Phaco <span class="badge-star">★</span></span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" onclick="switchTab('operasi-laparascopy', this)">
                            <span>Operasi Laparascopy <span class="badge-star">★</span></span>
                            <span class="arrow">&rsaquo;</span>
                        </a>
                    </li>
                </ul>
            </aside>
            <main class="content-area">
                
                <!-- 1. IGD -->
                <div id="igd" class="service-panel active">
                    <div class="service-header">
                        <span class="service-subtitle">Pelayanan Rawat Jalan</span>
                        <h1 class="service-title">IGD (Instalasi Gawat Darurat)</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1587354246490-7e26e63fdb62?auto=format&fit=crop&w=1000&q=80" alt="IGD" class="service-banner">
                    <div class="service-body">
                        <p>IGD RS Cinta Kasih Tzu Chi terus berkomitmen memberikan pelayanan gawat darurat yang semakin baik dari waktu ke waktu. Kami menggunakan sistem Triage untuk memilah tingkat kegawatan pasien, sehingga setiap orang bisa mendapatkan penanganan yang cepat dan tepat sesuai dengan kondisi darurat yang dialaminya.</p>
                        
                        <p style="margin-top: 15px; margin-bottom: 8px;"><strong>Kategori Triage di IGD kami meliputi:</strong></p>
                        <ul style="margin-bottom: 20px;">
                            <li><strong>Prioritas I (Merah)</strong>: Penanganan segera dengan waktu tanggap (respond time) kurang dari 1 menit.</li>
                            <li><strong>Prioritas II (Kuning)</strong>: Penanganan cepat dengan waktu tanggap kurang dari 10 menit.</li>
                            <li><strong>Prioritas III (Hijau)</strong>: Penanganan untuk kondisi ringan dengan waktu tanggap kurang dari 30 menit.</li>
                        </ul>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Fasilitas yang Tersedia</h4>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Ambulance gawat darurat</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• USG Emergency</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Emergency Mechanical Ventilator</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Ruang Resusitasi</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Ruang Ponek</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Ruang Isolasi Emergency</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Tim Emergency Standby 24 jam yang terdiri dari dokter dan perawat emergency</li>
                            </ul>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Keunggulan Layanan</h4>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Layanan Gawat darurat 24 jam oleh tim gawat darurat yang terdiri dari dokter-dokter jaga yang bersertifikat pelatihan Emergency (ACLS/ATLS/ALS) dan perawat Emergency bersertifikat pelatihan Emergency (BTCLS/ALS/PPGD)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Konsultan dokter Spesialis Emergency</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SUB-POLIKLINIK PANELS -->
                <div id="poli-kesehatan-gigi-anak" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis Gigi dan Mulut</span>
                        <h1 class="service-title">Spesialis Kesehatan Gigi Anak</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Kesehatan Gigi Anak" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter gigi dan mulut spesialis kesehatan gigi anak untuk seputar perawatan dan permasalahan gigi dan mulut pada anak-anak, mulai dari bayi hingga remaja.</p>
                    </div>
                </div>

                <div id="poli-bedah-mulut" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis Gigi dan Mulut</span>
                        <h1 class="service-title">Spesialis Bedah Mulut dan Maksilofasial</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Bedah Mulut" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter gigi dan mulut spesialis bedah mulut dan maksilofasial untuk seputar berbagai penyakit dan cedera di daerah kepala, leher, wajah, rahang, dan mulut.</p>
                    </div>
                </div>

                <div id="poli-gigi-umum" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Gigi Umum</span>
                        <h1 class="service-title">Poliklinik Gigi Umum</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Gigi Umum" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan dasar oleh dokter gigi umum untuk seputar kesehatan gigi dan mulut.</p>
                    </div>
                </div>

                <div id="poli-jantung" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis</span>
                        <h1 class="service-title">Spesialis Jantung dan Pembuluh Darah</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Poliklinik Jantung" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis jantung dan pembuluh darah untuk seputar penyakit jantung dan pembuluh darah, di antaranya</p>
                        <ul>
                            <li>Nyeri dada, berdebar-debar, sesak napas karena masalah jantung</li>
                            <li>Serangan jantung atau riwayat serangan jantung</li>
                            <li>Gagal jantung</li>
                            <li>Gangguan irama jantung</li>
                            <li>Hipertensi (tekanan darah tinggi)</li>
                        </ul>
                    </div>
                </div>

                <div id="poli-kebidanan" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis: Spesialis Kandungan dan Kebidanan (Obstetri-Ginekologi)</span>
                        <h1 class="service-title">Poliklinik Kebidanan dan Kandungan</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Kebidanan" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis kandungan dan kebidanan (obstetri-ginekologi) untuk ibu hamil sehat, hamil dengan penyulit, atau masalah organ kewanitaan, di antaranya:</p>
                        <ul>
                            <li>Perencanaan kehamilan yang sehat dan penggunaan kontrasepsi (pil, spiral, suntik hormon, dan kontrasepsi mantap/permanen)</li>
                            <li>Antenatal care (ANC), yaitu layanan pemeriksaan kesehatan berkala rutin mulai dari awal kehamilan hingga persalinan</li>
                            <li>Perencanaan persalinan dengan penyulit, misalnya hipertensi (tekanan darah tinggi) pada kehamilan, panggul sempit, posisi janin sungsang, tali ari-ari yang menghalangi jalan lahir, dan sebagainya</li>
                            <li>Penyakit organ kewanitaan, meliputi penyakit pada vagina, rahim, dan indung telur</li>
                        </ul>
                    </div>
                </div>

                <div id="poli-kulit-kelamin" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis: Spesialis Kulit dan Kelamin (Dermatovenereologi)</span>
                        <h1 class="service-title">Poliklinik Kulit & Kelamin, Estetika</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Kulit" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis kulit dan kelamin untuk seputar penyakit kulit dan kelamin, di antaranya:</p>
                        <ul>
                            <li>Penyakit kulit, seperti gatal-gatal, nyeri di kulit, mati rasa di kulit, kulit kering, kulit berminyak, kulit menebal, kulit menipis, kulit bersisik, lecet atau luka di kulit, kulit melepuh, benjolan di kulit, ruam kulit, dan lain-lain</li>
                            <li>Penyakit kuku, seperti perubahan warna atau bentuk pada kuku serta nyeri pada kuku</li>
                            <li>Penyakit rambut dan kulit kepala, seperti kebotakan, ketombe, dan rambut rontok</li>
                            <li>Penyakit menular seksual, seperti sifilis (raja singa), gonore, jamur kelamin, herpes simpleks, dan kutil kelamin</li>
                        </ul>
                    </div>
                </div>

                <div id="poli-mata" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis: Spesialis Mata</span>
                        <h1 class="service-title">Poliklinik Mata ★</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Mata" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis mata untuk seputar penyakit mata, di antaranya:</p>
                        <ul>
                            <li>Penurunan penglihatan (katarak, rabun jauh, rabun dekat, dan lain-lain)</li>
                            <li>Infeksi dan peradangan pada bagian bola mata atau sekitarnya (kelopak mata, kelenjar air mata, saluran air mata, dan lain-lain)</li>
                            <li>Juling</li>
                            <li>Terlepasnya retina dan gangguan retina karena diabetes melitus atau hipertensi</li>
                        </ul>
                    </div>
                </div>

                <div id="poli-neurologi" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis: Spesialis Neurologi (Saraf)</span>
                        <h1 class="service-title">Poliklinik Neurologi (Saraf)</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Saraf" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis neurologi (saraf) untuk seputar penyakit saraf, di antaranya kejang, pusing berputar, nyeri kepala, epilepsi, pingsan, stroke, mati rasa/baal, gemetar (tremor), lumpuh, dan lain-lain.</p>
                    </div>
                </div>

                <div id="poli-orthodonti" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis Gigi dan Mulut: Spesialis Ortodonti</span>
                        <h1 class="service-title">Poliklinik Orthodonti</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Orthodonti" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter gigi dan mulut spesialis ortodonti untuk seputar permasalahan posisi gigi dan rahang yang tidak tepat.</p>
                    </div>
                </div>

                <div id="poli-orthopedi" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis: Spesialis Ortopedi</span>
                        <h1 class="service-title">Poliklinik Orthopedi</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Orthopedi" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis ortopedi untuk seputar penyakit otot dan tulang, di antaranya:</p>
                        <ul>
                            <li>Cedera otot</li>
                            <li>Cedera atau patah tulang</li>
                            <li>Permasalahan tulang belakang</li>
                        </ul>
                    </div>
                </div>

                <div id="poli-penyakit-dalam" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis Penyakit Dalam</span>
                        <h1 class="service-title">Poliklinik Penyakit Dalam</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Penyakit Dalam" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis penyakit dalam untuk pasien dewasa dan lansia, meliputi berbagai penyakit non-bedah, di antaranya:</p>
                        <ul>
                            <li>Penyakit alergi-imunologi (penyakit yang berhubungan dengan gangguan sistem daya tahan tubuh, seperti HIV dan lupus eritematosus sistemik)</li>
                            <li>Penyakit hematologi-onkologi (penyakit pada darah dan kanker, seperti leukemia, limfoma, dan hemofilia)</li>
                            <li>Penyakit metabolik-endokrin (penyakit yang berhubungan dengan kelenjar endokrin, seperti diabetes melitus, gangguan kelenjar tiroid, dan gangguan kelenjar paratiroid)</li>
                            <li>Penyakit reumatik</li>
                            <li>Penyakit ginjal dan hipertensi</li>
                            <li>Penyakit gastroenterologi (penyakit yang berhubungan dengan lambung dan usus)</li>
                            <li>Penyakit hati</li>
                            <li>Penyakit jantung</li>
                            <li>Penyakit paru-paru</li>
                            <li>Penyakit infeksi (bakteri, virus, cacing, dan jamur)</li>
                        </ul>
                    </div>
                </div>

                <div id="poli-prostodonti" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis Gigi dan Mulut: Spesialis Prostodonti</span>
                        <h1 class="service-title">Poliklinik Prostodonti</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Prostodonti" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter gigi dan mulut spesialis prostodonti untuk seputar permasalahan gigi dan mulut yang membutuhkan prostesis (misalnya gigi tiruan).</p>
                    </div>
                </div>

                <div id="poli-tht" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis: Spesialis Telinga-Hidung-Tenggorok (THT)</span>
                        <h1 class="service-title">Poliklinik Telinga-Hidung-Tenggorok (THT)</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="THT" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis telinga-hidung-tenggorok (THT) untuk seputar penyakit telinga, hidung, dan tenggorok, di antaranya:</p>
                        <ul>
                            <li><strong>Telinga</strong> (pusing berputar, penurunan pendengaran, radang telinga, gendang telinga robek, pembedahan telinga, dan lain-lain)</li>
                            <li><strong>Hidung</strong> (sumbatan hidung, sinusitis, alergi, radang hidung, mimisan, pembedahan hidung, dan lain-lain)</li>
                            <li><strong>Tenggorok</strong> (suara serak atau berubah, pembedahan trakeostomi, dan lain-lain)</li>
                        </ul>
                    </div>
                </div>

                <div id="poli-urologi" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Unit Rawat Jalan Spesialis: Spesialis Urologi</span>
                        <h1 class="service-title">Poliklinik Urologi</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=1000&q=80" alt="Urologi" class="service-banner">
                    <div class="service-body">
                        <p>Pelayanan kesehatan mendalam oleh dokter spesialis urologi untuk seputar penyakit sistem saluran kemih dan organ reproduksi pria, di antaranya:</p>
                        <ul>
                            <li>Penyakit ginjal, seperti batu ginjal, infeksi ginjal, dan pembengkakan ginjal</li>
                            <li>Penyakit ureter (saluran yang menghubungkan ginjal dan kandung kemih)</li>
                            <li>Penyakit kandung kemih</li>
                            <li>Penyakit uretra (saluran yang menghubungkan kandung kemih dan ujung saluran kemih)</li>
                            <li>Penyakit organ reproduksi pria (testis, epididimis, vas deferens, prostat, dan penis)</li>
                        </ul>
                    </div>
                </div>

                <!-- Lainnya -->
                <div id="hcu-icu" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Pelayanan Rawat Inap</span>
                        <h1 class="service-title">High Care Unit dan Intensive Care Unit (HCU-ICU)</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80" alt="HCU ICU" class="service-banner">
                    <div class="service-body">
                        <p>High Care Unit (HCU) dan Intensive Care Unit (ICU) merupakan fasilitas rawat inap bagi pasien yang membutuhkan pengawasan, perawatan, dan pengobatan ketat karena adanya penyakit atau kondisi tertentu yang mengancam jiwa. Berbeda dari rawat inap biasa, setiap pasien di HCU dan ICU diawasi secara ketat selama 24 jam oleh petugas medis kompeten, dilengkapi dengan alat-alat canggih.</p>
                        <p>Perbedaan utama HCU dan ICU adalah penggunaan ventilator. Pasien HCU tidak membutuhkan ventilator, sementara pasien ICU membutuhkan ventilator. Ventilator merupakan mesin alat bantu napas yang diperuntukkan bagi pasien-pasien yang fungsi pernapasannya sangat terganggu sehingga memerlukan bantuan alat bantu napas.</p>
                        <p>Rumah Sakit Cinta Kasih Tzu Chi memiliki 3 bed HCU dan 2 bed ICU.</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 8px; font-weight: 600;">Jadwal Kunjungan Pasien</h4>
                            <p style="margin-bottom: 0; color: #475569;">Agar pasien dapat beristirahat demi segera mendapat kesembuhan, pasien hanya boleh dikunjungi sesuai dengan jadwal kunjungan, yaitu:</p>
                            <p style="margin-top: 8px; margin-bottom: 0; font-weight: 600; color: var(--primary);">Pukul: 17.00 – 18.30 WIB</p>
                        </div>
                    </div>
                </div>

                <div id="isolasi" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Pelayanan Rawat Inap</span>
                        <h1 class="service-title">Ruang Rawat Inap Isolasi</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80" alt="Ruang Rawat Inap Isolasi" class="service-banner">
                    <div class="service-body">
                        <p>Ruang rawat inap isolasi diperuntukkan bagi pasien yang memerlukan perawatan dalam ruangan tersendiri, yaitu pasien yang mempunyai penyakit menular maupun pasien yang rentan tertular penyakit (misalnya pasien dengan gangguan daya tahan tubuh).</p>
                        <p>Rumah Sakit Cinta Kasih Tzu Chi memiliki 1 bed rawat inap isolasi.</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 8px; font-weight: 600;">Jadwal Kunjungan Pasien</h4>
                            <p style="margin-bottom: 0; color: #475569;">Agar pasien dapat beristirahat demi segera mendapat kesembuhan, pasien hanya boleh dikunjungi sesuai dengan jadwal kunjungan, yaitu:</p>
                            <p style="margin-top: 8px; margin-bottom: 0; font-weight: 600; color: var(--primary);">Jam 17.00 – 18.30 WIB</p>
                        </div>
                    </div>
                </div>

                <div id="maternity" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Pelayanan Rawat Inap</span>
                        <h1 class="service-title">Maternity (Kebidanan)</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1000&q=80" alt="Maternity" class="service-banner">
                    <div class="service-body">
                        <p>Rawat inap maternity diperuntukkan bagi pasien hamil atau pasien yang baru menjalani persalinan. Rawat inap maternity Rumah Sakit Cinta Kasih Tzu Chi hanya menyediakan ruangan kelas III yang berisikan 4 bed di setiap ruangan.</p>
                        <p>Rumah Sakit Cinta Kasih Tzu Chi memiliki 12 bed rawat inap maternity.</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 8px; font-weight: 600;">Jadwal Kunjungan Pasien</h4>
                            <p style="margin-bottom: 0; color: #475569;">Agar pasien dapat beristirahat demi segera mendapat kesembuhan, pasien hanya boleh dikunjungi sesuai dengan jadwal kunjungan, yaitu:</p>
                            <p style="margin-top: 8px; margin-bottom: 0; font-weight: 600; color: var(--primary);">Jam 17.00 – 18.30 WIB</p>
                        </div>
                    </div>
                </div>

                <div id="perinatal" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Pelayanan Rawat Inap</span>
                        <h1 class="service-title">Perinatal</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80" alt="Perinatal" class="service-banner">
                    <div class="service-body">
                        <p>Ruang rawat perina diperuntukkan bagi pasien bayi baru lahir (0–28 hari). Ruang rawat perina Rumah Sakit Cinta Kasih Tzu Chi dibedakan menjadi tiga macam, yaitu level 1, 2A, dan 2B. Level 1 digunakan untuk bayi sehat, level 2A digunakan untuk bayi baru lahir dan bayi dengan kondisi tertentu yang membutuhkan pengawasan lebih ketat, dan level 2B digunakan untuk bayi dengan kondisi tidak stabil dan membutuhkan pengawasan ketat (misalnya membutuhkan alat bantu napas).</p>
                        <p>Rumah Sakit Cinta Kasih Tzu Chi memiliki 24 bed rawat inap perina secara total, terdiri atas:</p>
                        <ul>
                            <li>12 bed rawat inap perina level 1</li>
                            <li>8 bed rawat inap perina level 2A</li>
                            <li>4 bed rawat inap perina level 2B</li>
                        </ul>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 8px; font-weight: 600;">Fasilitas</h4>
                            <p style="margin-bottom: 0; color: #475569;">Inkubator bayi (boks penghangat bayi) khusus untuk bayi yang membutuhkan</p>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 8px; font-weight: 600;">Jadwal Kunjungan Pasien</h4>
                            <p style="margin-bottom: 0; color: #475569;">Agar pasien dapat beristirahat demi segera mendapat kesembuhan, pasien hanya boleh dikunjungi sesuai dengan jadwal kunjungan, yaitu:</p>
                            <p style="margin-top: 8px; margin-bottom: 0; font-weight: 600; color: var(--primary);">Jam 17.00 – 18.30 WIB</p>
                        </div>
                    </div>
                </div>

                <div id="rawat-inap-anak" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Pelayanan Rawat Inap</span>
                        <h1 class="service-title">Rawat Inap Anak</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80" alt="Rawat Inap Anak" class="service-banner">
                    <div class="service-body">
                        <p>Ruang rawat inap anak diperuntukkan bagi pasien anak (usia 1 bulan–18 tahun) yang dinilai oleh dokter membutuhkan rawat inap, misalnya membutuhkan pemberian obat melalui infus, pengawasan dari petugas medis, dan lain-lain.</p>
                        <p>Rumah Sakit Cinta Kasih Tzu Chi memiliki 16 bed rawat inap anak secara total. Setiap ruangan berisikan 5–6 bed. Khusus bagi pasien yang usianya di bawah 5 tahun, terdapat 5 bed yang menggunakan penyanggah lebih tinggi untuk menghindari risiko jatuh pada pasien.</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 8px; font-weight: 600;">Jadwal Kunjungan Pasien</h4>
                            <p style="margin-bottom: 0; color: #475569;">Agar pasien dapat beristirahat demi segera mendapat kesembuhan, pasien hanya boleh dikunjungi sesuai dengan jadwal kunjungan, yaitu:</p>
                            <p style="margin-top: 8px; margin-bottom: 0; font-weight: 600; color: var(--primary);">Jam 17.00 – 18.30 WIB</p>
                        </div>
                    </div>
                </div>

                <div id="rawat-inap-dewasa" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Pelayanan Rawat Inap</span>
                        <h1 class="service-title">Rawat Inap Dewasa</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80" alt="Rawat Inap Dewasa" class="service-banner">
                    <div class="service-body">
                        <p>Ruang rawat inap dewasa diperuntukkan bagi pasien yang dinilai oleh dokter perlu rawat inap, misalnya perlu mendapatkan obat-obatan melalui infus, membutuhkan asupan makanan melalui selang makan, persiapan menjalani operasi, perawatan setelah operasi, dan lain-lain.</p>
                        <p>Di Rumah Sakit Cinta Kasih Tzu Chi, setiap ruangan rawat inap dewasa diperuntukkan bagi 5–6 pasien. Ruangan untuk pasien laki-laki dibedakan dengan pasien perempuan. Selain itu, rawat inap dewasa dibagi menjadi dua, yaitu rawat inap dewasa bedah untuk pasien yang akan menjalani dan telah selesai menjalani operasi, serta rawat inap dewasa non-bedah untuk pasien yang tidak menjalani operasi.</p>
                        <p>Rumah Sakit Cinta Kasih Tzu Chi memiliki 30 bed rawat inap dewasa secara total, terdiri atas:</p>
                        <ul>
                            <li>6 bed untuk rawat inap dewasa bedah laki-laki</li>
                            <li>7 bed untuk rawat inap dewasa bedah perempuan</li>
                            <li>6 bed untuk rawat inap dewasa non-bedah laki-laki</li>
                            <li>11 bed untuk rawat inap dewasa non-bedah perempuan</li>
                        </ul>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 8px; font-weight: 600;">Jadwal Kunjungan Pasien</h4>
                            <p style="margin-bottom: 0; color: #475569;">Agar pasien dapat beristirahat demi segera mendapat kesembuhan, pasien hanya boleh dikunjungi sesuai dengan jadwal kunjungan, yaitu:</p>
                            <p style="margin-top: 8px; margin-bottom: 0; font-weight: 600; color: var(--primary);">Jam 17.00 – 18.30 WIB</p>
                        </div>
                    </div>
                </div>

                <div id="farmasi" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Fasilitas Penunjang</span>
                        <h1 class="service-title">Instalasi Farmasi</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1586015555751-63bb77f4322a?auto=format&fit=crop&w=1000&q=80" alt="Farmasi" class="service-banner">
                    <div class="service-body">
                        <p>Dalam memberikan pelayanan terbaik, Rumah Sakit Cinta Kasih Tzu Chi dilengkapi dengan Instalasi Farmasi yang beroperasi selama 24 jam sehingga memudahkan pasien mendapatkan obat-obatan dan alat kesehatan yang dibutuhkan.</p>
                    </div>
                </div>

                <div id="homecare" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Fasilitas Penunjang</span>
                        <h1 class="service-title">Home Care ★</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=80" alt="Home Care" class="service-banner">
                    <div class="service-body">
                        <p>Layanan Home Care Rumah Sakit Cinta Kasih Tzu Chi menjadi solusi bagi pasien yang sulit datang ke rumah sakit. Layanan Home Care diperuntukkan bagi pasien dengan kondisi tertentu yang membutuhkan perawatan di rumah.</p>
                        <p>Kunjungan petugas Home Care dilakukan oleh tim yang terdiri atas dokter dan perawat. Jenis pelayanan yang diberikan berupa:</p>
                        <ul>
                            <li>Perawatan luka/ganti perban</li>
                            <li>Pemasangan atau penggantian kateter urine</li>
                            <li>Penyuntikan obat</li>
                            <li>Pemberian asuhan nutrisi bagi pasien yang menggunakan selang makan (nasogastric tube/NGT)</li>
                            <li>Perawatan geriatri (lansia dengan banyak penyakit), dan lain-lain</li>
                        </ul>
                    </div>
                </div>

                <!-- Modul Laboratorium -->
                <div id="laboratorium" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Fasilitas Penunjang</span>
                        <h1 class="service-title">Instalasi Laboratorium</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1000&q=80" alt="Laboratorium" class="service-banner">
                    <div class="service-body">
                        <p>Instalasi Laboratorium Rumah Sakit Cinta Kasih Tzu Chi merupakan salah satu sarana pelayanan medis di Rumah Sakit Cinta Kasih Tzu Chi yang difungsikan untuk menunjang diagnosis, menilai derajat penyakit, dan mengevaluasi pengobatan penyakit.</p>
                        
                        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 14px 18px; margin: 16px 0;">
                            <p style="margin-bottom: 0; font-size: 0.88rem; color: #b45309;"><strong>Catatan:</strong> Seluruh pemeriksaan di Instalasi Laboratorium Rumah Sakit Cinta Kasih Tzu Chi dilakukan hanya berdasarkan permintaan dari dokter (sesuai indikasi).</p>
                        </div>

                        <h4 style="font-size: 1rem; color: var(--text-main); margin-top: 20px; margin-bottom: 12px; font-weight: 600;">Daftar Pemeriksaan Laboratorium</h4>
                        
                        <div class="lab-category-grid">
                            <!-- Hematologi -->
                            <div class="lab-card">
                                <h5>HEMATOLOGI</h5>
                                <ul class="lab-card-list">
                                    <li>Golongan darah</li>
                                    <li>Darah rutin</li>
                                    <li>Darah lengkap</li>
                                    <li>Laju endap darah</li>
                                    <li>Retikulosit</li>
                                    <li>IT ratio</li>
                                    <li>Morfologi darah tepi</li>
                                    <li>Hitung eosinofil</li>
                                </ul>
                            </div>

                            <!-- Hemostasis -->
                            <div class="lab-card">
                                <h5>HEMOSTASIS</h5>
                                <ul class="lab-card-list">
                                    <li>Masa Perdarahan (bleeding time)</li>
                                    <li>Protrombin time</li>
                                    <li>Activated partial thromboplastin time</li>
                                    <li>Fibrinogen</li>
                                    <li>aPTT mixing study</li>
                                </ul>
                            </div>

                            <!-- Urine & Test Kehamilan -->
                            <div class="lab-card">
                                <h5>URINE & TEST KEHAMILAN</h5>
                                <ul class="lab-card-list">
                                    <li>Urine lengkap</li>
                                    <li>Test kehamilan / hCG urine test</li>
                                </ul>
                            </div>

                            <!-- Kadar Obat / Narkoba -->
                            <div class="lab-card">
                                <h5>KADAR OBAT / NARKOBA</h5>
                                <ul class="lab-card-list">
                                    <li>Amphetamine</li>
                                    <li>Coccain</li>
                                    <li>Marijuana</li>
                                    <li>Test NAPZA</li>
                                </ul>
                            </div>

                            <!-- Kimia Klinik - Faal Hati -->
                            <div class="lab-card">
                                <h5>KIMIA KLINIK - FAAL HATI</h5>
                                <ul class="lab-card-list">
                                    <li>Albumin</li>
                                    <li>SGOT</li>
                                    <li>SGPT</li>
                                    <li>Bilirubin total/direk/indirek</li>
                                    <li>Bilirubin newborn</li>
                                </ul>
                            </div>

                            <!-- Kimia Klinik - Faal Pankreas -->
                            <div class="lab-card">
                                <h5>KIMIA KLINIK - FAAL PANKREAS</h5>
                                <ul class="lab-card-list">
                                    <li>Amilase</li>
                                </ul>
                            </div>

                            <!-- Kimia Klinik - Lemak -->
                            <div class="lab-card">
                                <h5>KIMIA KLINIK - LEMAK</h5>
                                <ul class="lab-card-list">
                                    <li>Cholesterol total</li>
                                    <li>Trigliseride</li>
                                    <li>HDL-cholesterol</li>
                                    <li>LDL-cholesterol</li>
                                </ul>
                            </div>

                            <!-- Kimia Klinik - Faal Ginjal -->
                            <div class="lab-card">
                                <h5>KIMIA KLINIK - FAAL GINJAL</h5>
                                <ul class="lab-card-list">
                                    <li>Ureum</li>
                                    <li>Creatinin</li>
                                    <li>Asam urat</li>
                                    <li>Creatinin clearance test (CCT)</li>
                                    <li>Ureum clearance test (UCT)</li>
                                </ul>
                            </div>

                            <!-- Kimia Klinik - Gula Darah -->
                            <div class="lab-card">
                                <h5>KIMIA KLINIK - GULA DARAH</h5>
                                <ul class="lab-card-list">
                                    <li>Gula darah sewaktu</li>
                                    <li>Gula darah puasa</li>
                                    <li>Gula darah 2 jam pp</li>
                                    <li>Glukosa toleransi tes (GTT)</li>
                                    <li>HbA1C</li>
                                </ul>
                            </div>

                            <!-- Kimia Klinik - Jantung -->
                            <div class="lab-card">
                                <h5>KIMIA KLINIK - JANTUNG</h5>
                                <ul class="lab-card-list">
                                    <li>CKMB</li>
                                    <li>Troponin I</li>
                                </ul>
                            </div>

                            <!-- Kimia Klinik - Elektrolit & AGD -->
                            <div class="lab-card">
                                <h5>KIMIA KLINIK - ELEKTROLIT & AGD</h5>
                                <ul class="lab-card-list">
                                    <li>Na, K, Cl (darah)</li>
                                    <li>Calcium total</li>
                                    <li>Analisa Gas Darah</li>
                                    <li>Na, K, Cl (urine)</li>
                                </ul>
                            </div>

                            <!-- Faeces -->
                            <div class="lab-card">
                                <h5>FAECES</h5>
                                <ul class="lab-card-list">
                                    <li>Faeces lengkap</li>
                                </ul>
                            </div>

                            <!-- Imunologi - Analisa Lain -->
                            <div class="lab-card">
                                <h5>IMUNOLOGI - ANALISA LAIN</h5>
                                <ul class="lab-card-list">
                                    <li>Analisa cairan ascites</li>
                                    <li>Analisa cairan pleura</li>
                                </ul>
                            </div>

                            <!-- Imunologi - Hepatitis -->
                            <div class="lab-card">
                                <h5>IMUNOLOGI - HEPATITIS</h5>
                                <ul class="lab-card-list">
                                    <li>Anti-Hbs</li>
                                    <li>Anti-HCV</li>
                                    <li>HbsAg</li>
                                </ul>
                            </div>

                            <!-- Imunologi - HIV -->
                            <div class="lab-card">
                                <h5>IMUNOLOGI - HIV</h5>
                                <ul class="lab-card-list">
                                    <li>HIV penyaring</li>
                                </ul>
                            </div>

                            <!-- Imunologi - Autoantibodi -->
                            <div class="lab-card">
                                <h5>IMUNOLOGI - AUTOANTIBODI</h5>
                                <ul class="lab-card-list">
                                    <li>CRP kuantitatif</li>
                                    <li>CRP kualitatif</li>
                                </ul>
                            </div>

                            <!-- Imunologi - Imunoserologi Infeksi -->
                            <div class="lab-card">
                                <h5>IMUNOLOGI - IMUNOSEROLOGI INFEKSI</h5>
                                <ul class="lab-card-list">
                                    <li>IgG/IgM anti-Dengue</li>
                                    <li>NS-1 Dengue</li>
                                    <li>Malaria kuantitatif (mikroskopik)</li>
                                    <li>Malaria kualitatif (rapid)</li>
                                    <li>TUBEX TF</li>
                                    <li>WIDAL</li>
                                </ul>
                            </div>

                            <!-- Mikrobiologi -->
                            <div class="lab-card">
                                <h5>MIKROBIOLOGI</h5>
                                <ul class="lab-card-list">
                                    <li>PCR TB (TCM)</li>
                                </ul>
                            </div>

                            <!-- Mikrobiologi - Sediaan Hapusan -->
                            <div class="lab-card">
                                <h5>MIKROBIOLOGI - SEDIAAN HAPUSAN</h5>
                                <ul class="lab-card-list">
                                    <li>KOH jamur</li>
                                    <li>Pewarnaan BTA</li>
                                    <li>Pewarnaan Gram</li>
                                    <li>Trichomonas</li>
                                </ul>
                            </div>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin-top: 20px;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 10px; font-weight: 600;">Keunggulan Instalasi Laboratorium</h4>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 4px 0; margin-bottom: 6px;">• Pengelolaan laboratorium didukung oleh sumber daya manusia yang kompeten dan profesional.</li>
                                <li style="border: none; background: transparent; padding: 4px 0; margin-bottom: 6px;">• Pemeriksaan laboratorium dilakukan menggunakan alat-alat laboratorium medis generasi terbaru dengan akurasi dan presisi tinggi. Alat-alat tersebut mampu melakukan pemeriksaan secara otomatis, terpadu, dan simultan sehingga pemeriksaan dapat dilakukan secara cepat dan tepat dalam jumlah besar.</li>
                                <li style="border: none; background: transparent; padding: 4px 0; margin-bottom: 6px;">• Pengelolaan data laboratorium dilengkapi dengan Laboratory Information System (LIS) dan Hospital Information System (HIS). Sistem tersebut memungkinkan data hasil pemeriksaan laboratorium dikelola secara cepat, akurat, dan mudah diakses secara real time di jaringan rumah sakit.</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- Modul Medical Check Up -->
                <div id="mcu" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Fasilitas Penunjang</span>
                        <h1 class="service-title">Medical Check Up</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1000&q=80" alt="MCU" class="service-banner">
                    <div class="service-body">
                        <p>Medical check up (MCU) adalah pemeriksaan medis yang dilakukan secara berkala pada orang sehat. MCU dilakukan sebagai upaya pencegahan dan deteksi dini, yaitu mendeteksi adanya faktor risiko atau penyakit tertentu selagi belum bergejala dan belum berkembang ke tahap yang lebih serius.</p>
                        
                        <p>MCU terutama ditujukan untuk mencegah atau mendeteksi dini penyakit-penyakit serius yang tidak bisa sembuh atau membahayakan nyawa maupun menimbulkan kecacatan jika terlanjur berkembang ke tahap serius, misalnya penyakit jantung, infeksi virus hepatitis, gagal ginjal, gagal hati, diabetes melitus, tumor, dan lain-lain.</p>

                        <p>Rumah Sakit Cinta Kasih Tzu Chi melayani dua paket medical check up (MCU) yang terbagi antara paket simple dan paket basic. Bagi Anda yang telah berusia 45 tahun ke atas, kami menyarankan untuk mengambil paket basic.</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Medical check up (MCU) Simple Meliputi:</h4>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan fisik oleh dokter</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Elektrokardiografi atau EKG (rekam jantung)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium darah lengkap (hemoglobin, eritrosit, leukosit, hitung jenis leukosit, trombosit, dan laju endap darah)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium urine lengkap (warna urine, kekeruhan urine)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium rontgen dada (rontgen toraks posterior-anterior)</li>
                            </ul>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Medical check up (MCU) Basic Meliputi:</h4>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan fisik oleh dokter</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Elektrokardiografi atau EKG (rekam jantung)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium darah lengkap (hemoglobin, eritrosit, leukosit, hitung jenis leukosit, trombosit, dan laju endap darah)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium urine lengkap</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium fungsi hati (SGOT dan SGPT)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium fungsi ginjal (Ureum kreatinin, Asam urat)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium gula darah (Gula darah sewaktu, Gula darah Puasa, gula darah 2 jam setelah makan)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan laboratorium skrining infeksi virus hepatitis (HbsAg) (Skrining Virus Hepatitis B)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pemeriksaan radiologi rontgen dada (rontgen toraks posterior-anterior)</li>
                            </ul>
                        </div>

                        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; padding: 20px; margin-top: 24px;">
                            <h4 style="font-size: 0.95rem; color: var(--primary-dark); margin-bottom: 10px; font-weight: 600;">Informasi Lebih Lanjut Kontak MCU</h4>
                            <p style="margin-bottom: 6px; color: #334155;"><strong>Unit Layanan Medical Check up:</strong><br>Telp : 021-55963680</p>
                            <p style="margin-bottom: 0; color: #334155;"><strong>Medical Check Up Perusahaan/Corporate:</strong><br>Bagian Umum<br>Telp : 021-55963680 Ext 336</p>
                        </div>
                    </div>
                </div>

                <!-- Modul Radiologi -->
                <div id="radiologi" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Fasilitas Penunjang</span>
                        <h1 class="service-title">Instalasi Radiologi</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1000&q=80" alt="Radiologi" class="service-banner">
                    <div class="service-body">
                        <p>Instalasi Radiologi merupakan salah satu instalasi penunjang medis yang memberikan pelayanan pemeriksaan radiologi dengan hasil pemeriksaan berupa foto untuk membantu dokter yang merawat pasien dalam menegakkan diagnosis.</p>

                        <p>Dalam rangka memberikan pelayanan maksimal, Instalasi Radiologi Rumah Sakit Cinta Kasih Tzu Chi terus berupaya melengkapi pelayanan radiologi dengan peralatan modern, teknologi teranyar, dan penanganan oleh tenaga medis dan paramedis terlatih dan kompeten.</p>

                        <p>Peralatan di Instalasi Radiologi Rumah Sakit Cinta Kasih Tzu Chi telah menggunakan <em>computed radiography</em> (CR), yaitu sistem yang mengubah sistem analog pada radiologi konvensional menjadi radiografi digital sehingga hasil yang dihasilkan lebih jelas dan maksimal dalam menegakkan diagnosis.</p>

                        <p>Secara garis besar, peralatan (pesawat) di Instalasi Radiologi Rumah Sakit Cinta Kasih Tzu Chi terbagi menjadi 2, yaitu berbasis sinar X (rontgen) dan ultrasound (ultrasonografi atau USG).</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 20px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--primary); margin-bottom: 8px; font-weight: 600;">1. Peralatan Berbasis Sinar X (Rontgen)</h4>
                            <p style="margin-bottom: 8px; color: #334155; font-size: 0.9rem;">Menggunakan pancaran sinar X yang ditembakkan oleh alat khusus menembus tubuh, kemudian ditangkap oleh pelat logam. Pelat logam ini dibaca oleh mesin untuk kemudian diterjemahkan ke layar komputer, selanjutnya dicetak sebagai lembaran foto (dikenal sebagai foto rontgen).</p>
                            <p style="margin-bottom: 4px; color: #334155; font-size: 0.88rem;"><strong>Keunggulan:</strong> Mudah dan cepat dilakukan, serta biaya relatif murah.</p>
                            <p style="margin-bottom: 8px; color: #334155; font-size: 0.88rem;"><strong>Kekurangan:</strong> Hasil tangkapan gambar tumpang-tindih karena bersifat dua dimensi sehingga kadang kurang jelas; tidak mampu melihat organ lunak dengan jelas; dan adanya risiko radiasi (minimal) sehingga tidak aman untuk ibu hamil.</p>
                            <p style="margin-bottom: 0; color: #334155; font-size: 0.88rem; font-style: italic;"><strong>Catatan Tambahan:</strong> Pemeriksaan radiologi yang menggunakan sinar X dapat ditunjang dengan kontras. Kontras adalah zat radioaktif yang diminumkan atau disuntikkan. Zat radioaktif tersebut akan membuat tampilan gambar tampak jauh lebih jelas sehingga semakin membantu dokter dalam menegakkan diagnosis atau mengevaluasi penyakit.</p>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 20px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--primary); margin-bottom: 8px; font-weight: 600;">2. Peralatan Berbasis Ultrasound (USG)</h4>
                            <p style="margin-bottom: 8px; color: #334155; font-size: 0.9rem;">Menggunakan pancaran gelombang suara frekuensi tinggi, kemudian pantulan gelombang tersebut ditangkap kembali dan diterjemahkan sebagai gambaran tertentu.</p>
                            <p style="margin-bottom: 4px; color: #334155; font-size: 0.88rem;"><strong>Keunggulan:</strong> Tidak memancarkan radiasi sehingga aman untuk ibu hamil maupun kalangan lainnya.</p>
                            <p style="margin-bottom: 0; color: #334155; font-size: 0.88rem;"><strong>Kekurangan:</strong> Tidak dapat digunakan untuk melihat bagian tubuh tertentu (seperti tulang atau ruangan berongga berisi gas, misalnya usus) dan bergantung pada keahlian operator mesin.</p>
                        </div>

                        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 14px 18px; margin: 16px 0;">
                            <p style="margin-bottom: 0; font-size: 0.88rem; color: #b45309;"><strong>Catatan:</strong> Seluruh pemeriksaan di Instalasi Radiologi Rumah Sakit Cinta Kasih Tzu Chi dilakukan hanya berdasarkan permintaan dari dokter (sesuai indikasi).</p>
                        </div>

                        <h4 style="font-size: 1rem; color: var(--text-main); margin-top: 24px; margin-bottom: 8px; font-weight: 600;">Pemeriksaan Radiologi dengan Sinar X (Rontgen)</h4>
                        <p style="margin-bottom: 16px; font-size: 0.9rem; color: #475569;">Pemeriksaan radiologi dengan sinar X di Instalasi Radiologi Rumah Sakit Cinta Kasih Tzu Chi menggunakan dua pesawat, yaitu pesawat sinar X konvensional Toshiba KXO-2555 dan pesawat sinar X panoramik & cephalometric.</p>

                        <div class="lab-category-grid">
                            <!-- Non-Kontras: Skull / Cranium -->
                            <div class="lab-card">
                                <h5>NON-KONTRAS: SKULL / CRANIUM</h5>
                                <ul class="lab-card-list">
                                    <li>Skull / cranium</li>
                                    <li>Nasal bone</li>
                                    <li>Mastoid</li>
                                    <li>TMJ</li>
                                    <li>SPN (Sinus Paranasal)</li>
                                </ul>
                            </div>

                            <!-- Non-Kontras: Panoramik & Cephalometric -->
                            <div class="lab-card">
                                <h5>NON-KONTRAS: PANORAMIK & CEPHALOMETRIC</h5>
                                <ul class="lab-card-list">
                                    <li>Panoramik</li>
                                    <li>Cephalometric PA</li>
                                    <li>Cephalometric lateral</li>
                                </ul>
                            </div>

                            <!-- Non-Kontras: Toraks -->
                            <div class="lab-card">
                                <h5>NON-KONTRAS: TORAKS</h5>
                                <ul class="lab-card-list">
                                    <li>Toraks AP/PA/lateral</li>
                                    <li>Toraks AP + lateral</li>
                                    <li>Toraks top lordotic</li>
                                </ul>
                            </div>

                            <!-- Non-Kontras: Columna Vertebra -->
                            <div class="lab-card">
                                <h5>NON-KONTRAS: COLUMNA VERTEBRA</h5>
                                <ul class="lab-card-list">
                                    <li>Cervical 2 posisi</li>
                                    <li>Cervical 4 posisi</li>
                                    <li>Thoracal 2 posisi</li>
                                    <li>Thoracal 4 posisi</li>
                                    <li>Lumbosacral 2 posisi</li>
                                    <li>Lumbosacral 4 posisi</li>
                                    <li>Sacral / Coccyx</li>
                                    <li>Pelvis AP</li>
                                </ul>
                            </div>

                            <!-- Non-Kontras: Abdomen -->
                            <div class="lab-card">
                                <h5>NON-KONTRAS: ABDOMEN</h5>
                                <ul class="lab-card-list">
                                    <li>Abdomen AP</li>
                                    <li>Abdomen 2 posisi</li>
                                    <li>Abdomen 3 posisi</li>
                                    <li>BNO</li>
                                    <li>Babygram</li>
                                </ul>
                            </div>

                            <!-- Non-Kontras: Ekstremitas Atas -->
                            <div class="lab-card">
                                <h5>NON-KONTRAS: EKSTREMITAS ATAS</h5>
                                <ul class="lab-card-list">
                                    <li>Digiti</li>
                                    <li>Manus</li>
                                    <li>Wrist joint</li>
                                    <li>Antebrachii</li>
                                    <li>Elbow joint</li>
                                    <li>Humerus</li>
                                    <li>Shoulder joint</li>
                                    <li>Clavicula</li>
                                    <li>Scapula</li>
                                </ul>
                            </div>

                            <!-- Non-Kontras: Ekstremitas Bawah -->
                            <div class="lab-card">
                                <h5>NON-KONTRAS: EKSTREMITAS BAWAH</h5>
                                <ul class="lab-card-list">
                                    <li>Calcaneus</li>
                                    <li>Pedis</li>
                                    <li>Ankle</li>
                                    <li>Cruris</li>
                                    <li>Genu / knee</li>
                                    <li>Patella</li>
                                    <li>Femur</li>
                                    <li>Hip joint</li>
                                </ul>
                            </div>

                            <!-- Kontras -->
                            <div class="lab-card">
                                <h5>DENGAN KONTRAS</h5>
                                <ul class="lab-card-list">
                                    <li>Appendicogram</li>
                                </ul>
                            </div>
                        </div>

                        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; padding: 20px; margin-top: 24px;">
                            <h4 style="font-size: 0.95rem; color: var(--primary-dark); margin-bottom: 8px; font-weight: 600;">Jadwal & Pelayanan Radiologi</h4>
                            <p style="margin-bottom: 6px; color: #334155; font-size: 0.9rem;">Instalasi Radiologi Rumah Sakit Cinta Kasih Tzu Chi memberikan pelayanan <strong>24 jam setiap hari</strong>, termasuk hari Minggu/libur nasional.</p>
                            <p style="margin-bottom: 0; color: #334155; font-size: 0.9rem;">Pemeriksaan radiologi dilakukan oleh dokter spesialis radiologi dan radiografer yang profesional dan kompeten.</p>
                        </div>
                    </div>
                </div>

                <div id="endoskopi-tht" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Layanan Unggulan</span>
                        <h1 class="service-title">Endoskopi THT ★</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1000&q=80" alt="Endoskopi THT" class="service-banner">
                    <div class="service-body">
                        <h3 style="font-size: 1.1rem; color: var(--primary-dark); margin-bottom: 10px; font-weight: 700;">Apakah Itu Endoskopi Hidung?</h3>
                        <p>Endoskopi hidung adalah prosedur pemeriksaan menggunakan alat yang memungkinkan spesialis telinga-hidung-tenggorok (THT) untuk melihat rongga hidung dan saluran sinus. Alat ini berbentuk seperti tabung mini dengan diameter kurang dari 4 mm, dilengkapi dengan kabel fiberoptik di dalamnya yang memancarkan cahaya. Tabung tersebut bersifat lentur sehingga bisa menyusuri rongga hidung dengan mudah. Ukuran dan sifatnya yang lentur meminimalkan rasa tidak nyaman yang dirasakan pasien ketika alat ini dimasukkan ke rongga hidung. Di ujung alat ini, ada kamera. Alat ini dapat dihubungkan dengan monitor untuk menampilkan gambaran rongga hidung maupun struktur lainnya dengan sangat jelas.</p>

                        <h3 style="font-size: 1.1rem; color: var(--primary-dark); margin-top: 20px; margin-bottom: 10px; font-weight: 700;">Bagaimana Prosedur Endoskopi Hidung?</h3>
                        <p>Prosedur endoskopi hidung umumnya dilakukan oleh seorang dokter spesialis THT di poliklinik (rawat jalan). Prosedur ini dilakukan dengan pasien dalam posisi duduk. Bila dibutuhkan untuk meminimalkan rasa tidak nyaman pasien, dokter dapat menyemprotkan atau meneteskan obat bius lokal di hidung sebelum memulai prosedur. Setelah menyiapkan alat, dokter akan mulai memasukkan alat endoskopi hidung secara perlahan sembari mengevaluasi struktur hidung dan sinus. Setelah selesai, dokter akan menarik alat secara perlahan.</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Siapa yang Memerlukan Endoskopi Hidung?</h4>
                            <p style="margin-bottom: 8px;">Anda mungkin memerlukan pemeriksaan menggunakan endoskopi hidung jika mengalami:</p>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Hidung sering tersumbat atau terasa penuh</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Sinusitis (radang pada saluran sinus, ditandai dengan sering timbulnya nyeri pada daerah wajah)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Polip hidung (pertumbuhan selaput lendir rongga hidung yang berlebihan)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Tumor hidung (benjolan abnormal pada rongga hidung)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Mimisan</li>
                            </ul>
                        </div>

                        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; padding: 20px; margin-top: 24px;">
                            <h4 style="font-size: 0.95rem; color: var(--primary-dark); margin-bottom: 8px; font-weight: 600;">Apa yang Harus Saya Persiapkan Sebelum Endoskopi Hidung?</h4>
                            <p style="margin-bottom: 0; color: #334155;">Secara umum, tidak ada persiapan khusus yang harus Anda lakukan sebelum menjalani endoskopi hidung. Namun, bila Anda mengonsumsi obat-obatan pengencer darah, beri tahu dokter Anda terlebih dahulu.</p>
                        </div>
                    </div>
                </div>

                <div id="laser-fotona" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Layanan Unggulan</span>
                        <h1 class="service-title">Laser Medis Fotona ★</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1000&q=80" alt="Laser Fotona" class="service-banner">
                    <div class="service-body">
                        <p>Teknik laser adalah salah satu metode perawatan kesehatan kulit tanpa pembedahan yang efisien, praktis, dengan hasil yang memuaskan. RS Cinta Kasih Tzu Chi telah memperkenalkan teknologi Laser Fotona sejak tanggal 3 Juni 2017.</p>
                        
                        <p>Fotona Laser adalah jenis laser unik yang memiliki kemampuan tidak hanya untuk estetika dan kulit, tetapi juga untuk tindakan bedah dan kesehatan area kewanitaan. Keunikan Laser Fotona terletak pada kombinasi dua jenis gelombang:</p>
                        <ul>
                            <li><strong>Gelombang Nd:YAG</strong>: Sangat efektif mencapai lapisan kulit terdalam.</li>
                            <li><strong>Gelombang Er:YAG</strong>: Ideal untuk mengangkat permukaan kulit yang kusam sehingga tampak lebih cerah dengan hasil yang bertahan lama.</li>
                        </ul>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--primary); margin-bottom: 12px; font-weight: 600;">Layanan berdasarkan Dokter Spesialis</h4>
                            
                            <p style="margin-bottom: 6px; font-weight: 600; color: var(--text-main);">1. Dokter Spesialis Kulit dan Kelamin</p>
                            <ul style="margin-bottom: 16px;">
                                <li>Pengobatan acne scar (lubang bekas jerawat) & active acne (jerawat merah)</li>
                                <li>Pigmentasi / bercak matahari / mencerahkan kulit wajah</li>
                                <li>Celulite (kulit jeruk) & stretchmark (tanda bekas melahirkan)</li>
                                <li>Telangiectasia (pembuluh darah di wajah) & varices</li>
                                <li>Skin tag (tonjolan/daging lebih) & wart (kutil)</li>
                                <li>Hair removal (menyingkirkan rambut berlebih)</li>
                                <li>Eye bag (kantung mata)</li>
                                <li>Skin resurfacing & Skin rejuvenation 4D (peremajaan & pengencangan wajah 4 dimensi)</li>
                                <li>Tightlase (pengencangan leher, lengan, perut, atau paha)</li>
                                <li>Onychomycosis (jamur kuku) & wound healing (penyembuhan luka)</li>
                                <li>Condiloma (kutil kelamin), epidermal nevi (tahi lalat), seborheic keratosis, hemangioma / port wine stain</li>
                            </ul>

                            <p style="margin-bottom: 6px; font-weight: 600; color: var(--text-main);">2. Dokter Spesialis Kebidanan dan Kandungan</p>
                            <ul style="margin-bottom: 16px;">
                                <li>Pengencangan jalan lahir</li>
                                <li>Incontinence (kesulitan menahan buang air kecil)</li>
                                <li>Cystocele (kelemahan dinding jalan lahir)</li>
                            </ul>

                            <p style="margin-bottom: 6px; font-weight: 600; color: var(--text-main);">3. Dokter Spesialis Telinga Hidung Tenggorokan (THT)</p>
                            <ul>
                                <li>Penanganan gangguan mengorok (snoring) untuk mencegah sleep apneu (henti napas saat tidur)</li>
                            </ul>
                        </div>

                        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; padding: 20px; margin-top: 24px;">
                            <h4 style="font-size: 0.95rem; color: var(--primary-dark); margin-bottom: 8px; font-weight: 600;">Keunggulan Utama</h4>
                            <p style="margin-bottom: 0; color: #334155;">Prosedur Fotona Laser bersifat aman, efektif, tanpa rasa nyeri, serta tanpa tindakan pembedahan. Treatment populer meliputi <strong>Fotona 4D</strong> untuk pengencangan wajah dan <strong>Fotona Active Acne</strong> untuk jerawat aktif beserta bekasnya.</p>
                        </div>
                    </div>
                </div>

                <div id="operasi-katarak" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Layanan Unggulan</span>
                        <h1 class="service-title">Operasi Katarak dengan Teknik Phaco ★</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1000&q=80" alt="Operasi Katarak" class="service-banner">
                    <div class="service-body">
                        <p>Operasi katarak masih menjadi hal yang menakutkan bagi sebagian orang[cite: 3]. Namun, dengan perkembangan teknologi yang semakin maju, operasi katarak tidak lagi menakutkan karena operasi katarak dapat dilakukan dengan teknik Phaco Emulsifikasi dan tanpa membuat sayatan lebar, sehingga operasi menjadi cepat, mudah, dan aman tanpa jahitan[cite: 3].</p>
                        
                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--primary); margin-bottom: 8px; font-weight: 600;">Apa yang dimaksud dengan Teknik Phaco Emulsifikasi?</h4>
                            <p style="margin-bottom: 0; color: #334155; font-size: 0.9rem;">Ialah operasi pengangkatan katarak modern dengan menggunakan alat phaco emulsifikasi (awam disebut dengan laser) untuk melunakkan (emulsifikasi) dan mengeluarkan lensa katarak pada saat yang bersamaan[cite: 3]. Setelah itu, lensa intra-okuler (IOL) yang dapat dilipat dimasukkan ke dalam mata[cite: 3]. Setelah operasi, pasien dapat beraktifitas kembali tanpa penutup mata[cite: 3].</p>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Kelebihan dari operasi katarak teknik Phaco Emulsifikasi</h4>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Sayatan sangat kecil (± 2,2 mm)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Proses cepat (± 15 menit)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Tanpa Jahitan</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pasien dapat langsung pulang setelah operasi (One Day Care)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Perawatan dan pemulihan lebih cepat (± 2-5 hari)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Dapat dilakukan pada semua tingkatan katarak</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Mengurangi rasa nyeri, ngeres dan ketidaknyamanan setelah operasi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="operasi-laparascopy" class="service-panel">
                    <div class="service-header">
                        <span class="service-subtitle">Layanan Unggulan</span>
                        <h1 class="service-title">Operasi Laparascopy ★</h1>
                    </div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1000&q=80" alt="Operasi Laparascopy" class="service-banner">
                    <div class="service-body">
                        <p>Laparoskopi atau operasi lubang kunci merupakan prosedur medis yang dilakukan ahli bedah untuk mengakses bagian dalam rongga perut dan panggul. Tidak seperti teknik bedah pada umumnya, laparoskopi memiliki beberapa kelebihan yang menguntungkan pasien.</p>
                        <p>Selama tindakan laparoskopi, Anda akan dibius total. Setelah itu, ahli bedah akan membuat sayatan kecil sekitar 1-1,5 cm di sekitar pusar. Melalui sayatan itu, ahli bedah akan memasukkan sebuah tabung kecil. Kemudian, sebuah alat yang disebut laparoskop, yang memiliki kamera dan lampu kecil pada ujungnya, akan dimasukkan ke dalam perut melalui tabung yang telah dimasukkan sebelumnya. Kamera itu akan memperlihatkan kondisi di dalam rongga perut dan panggul pada sebuah monitor sehingga memudahkan ahli bedah untuk melakukan operasi.</p>
                        <p>Pada saat bersamaan, rongga perut Anda akan diisi oleh gas karbon dioksida agar menggembung. Hal ini memudahkan ahli bedah untuk melihat organ-organ Anda secara jelas.</p>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Kelebihan Bedah Laparoskopi</h4>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Bekas luka lebih sedikit karena tidak memerlukan sayatan besar</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Rasa sakit jauh berkurang dibanding operasi biasa</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pendarahan yang terjadi lebih sedikit</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Bisa langsung pulang pada hari yang sama (atau rawat inap 1 hari jika diperlukan)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Proses penyembuhan total lebih cepat</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Lebih sedikit menimbulkan stres pada tubuh dan komplikasi, sehingga biaya keseluruhan lebih ringan dibanding operasi laparotomi</li>
                            </ul>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--primary); margin-bottom: 12px; font-weight: 600;">Kapan Laparoskopi Diperlukan?</h4>
                            <p style="margin-bottom: 10px; font-size: 0.9rem; color: #334155;">Teknik bedah ini bisa dipakai untuk beberapa kondisi seperti:</p>
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Pengangkatan rahim (histerektomi) untuk mengobati endometriosis dan penyakit radang panggul</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Mengangkat kehamilan ektopik (kehamilan di luar rahim)</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Mengangkat fibroid</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Memperbaiki hernia atau turun berok</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Mengangkat usus buntu yang telah meradang</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Mengangkat organ tubuh yang telah terkena kanker, seperti hati, usus, ginjal, ovarium, prostat atau kandung kemih</li>
                                <li style="border: none; background: transparent; padding: 3px 0; margin-bottom: 4px;">• Mengangkat kantong empedu pada penyakit batu empedu</li>
                            </ul>
                            <p style="margin-top: 10px; margin-bottom: 0; font-size: 0.88rem; color: #64748b; font-style: italic;">Selain mengobati, laparoskopi juga bisa digunakan untuk mendiagnosis berbagai macam penyakit dan memeriksa gejala-gejala penyakit tertentu.</p>
                        </div>

                        <div style="background: #ffffff; border: 1px solid var(--border); border-radius: 6px; padding: 20px; margin: 24px 0;">
                            <h4 style="font-size: 0.95rem; color: var(--text-main); margin-bottom: 12px; font-weight: 600;">Proses Penyembuhan</h4>
                            <p style="margin-bottom: 10px; font-size: 0.9rem;">Usai menjalani prosedur bedah ini, Anda akan diberi tahu cara merawat luka sayatan agar tetap bersih dan bisa pulih sempurna. Ingat baik-baik kapan Anda harus kembali ke rumah sakit untuk melepas jahitan atau melakukan perawatan lainnya.</p>
                            <p style="margin-bottom: 10px; font-size: 0.9rem;">Beberapa jam setelah operasi, mungkin Anda akan merasa pusing, mual, sakit atau bingung akibat efek samping obat bius. Efek samping tersebut akan pulih dengan cepat. Selama beberapa hari setelah operasi, Anda mungkin juga akan merasa nyeri di area sayatan. Rasa nyeri bisa diatasi dengan obat pereda rasa sakit.</p>
                            <p style="margin-bottom: 10px; font-size: 0.9rem;">Jika perut Anda terasa kembung, kram, atau nyeri pada bahu, berarti ada beberapa gas karbondioksida yang masih berada di dalam rongga perut Anda. Tidak perlu khawatir karena hal tersebut bisa pulih dalam satu hingga dua hari.</p>
                            <p style="margin-bottom: 0; font-size: 0.88rem; color: #64748b;">Perlu diingat bahwa proses penyembuhan tidak sama pada setiap orang, tergantung jenis penyakit dan kondisi kesehatan secara menyeluruh (contoh: usus buntu butuh ±2 minggu, sedangkan penanganan kanker memakan waktu ±3 bulan).</p>
                        </div>

                        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px; padding: 20px; margin-top: 24px;">
                            <h4 style="font-size: 0.95rem; color: var(--primary-dark); margin-bottom: 8px; font-weight: 600;">Catatan Penting Sebelum dan Risiko Operasi</h4>
                            <p style="margin-bottom: 8px; color: #334155; font-size: 0.9rem;"><strong>Persiapan:</strong> Diminta berhenti merokok menjelang operasi, menghentikan obat pengencer darah (seperti aspirin), serta berpuasa 6-12 jam sebelum operasi.</p>
                            <p style="margin-bottom: 0; color: #334155; font-size: 0.9rem;"><strong>Risiko & Komplikasi:</strong> Sekitar 1-2% mengalami komplikasi ringan (infeksi, mual, memar). Risiko serius dialami 1 dari 1.000 orang (seperti kerusakan pembuluh darah/organ, reaksi alergi bius, gelembung gas CO2 masuk ke pembuluh darah, atau penggumpalan darah).</p>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
    <footer id="kontak">
        <?php include 'footer.php' ?>
    </footer>
    <script>
        function togglePoliklinik(element) {
            const submenu = document.getElementById('poli-submenu');
            const arrow = document.getElementById('poli-arrow');
            submenu.classList.toggle('open');
            arrow.style.transform = submenu.classList.contains('open') ? 'rotate(90deg)' : 'rotate(0deg)';
        }

        function switchTab(serviceId, element) {
            const panels = document.querySelectorAll('.service-panel');
            panels.forEach(panel => panel.classList.remove('active'));

            const links = document.querySelectorAll('.sidebar-link, .submenu-link');
            links.forEach(link => link.classList.remove('active'));

            const targetPanel = document.getElementById(serviceId);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }

            if (element) {
                element.classList.add('active');
                const titleText = element.querySelector('span') ? element.querySelector('span').innerText.replace('★', '').trim() : element.innerText.replace('★', '').trim();
                document.getElementById('breadcrumb-current').innerText = titleText;

                if(element.classList.contains('submenu-link')) {
                    document.getElementById('poli-submenu').classList.add('open');
                    document.getElementById('poli-arrow').style.transform = 'rotate(90deg)';
                }
            } else {
                const matchingLink = document.querySelector(`[onclick*="'${serviceId}'"]`);
                if (matchingLink) {
                    matchingLink.classList.add('active');
                    const titleText = matchingLink.querySelector('span') ? matchingLink.querySelector('span').innerText.replace('★', '').trim() : matchingLink.innerText.replace('★', '').trim();
                    document.getElementById('breadcrumb-current').innerText = titleText;
                }
            }
        }

        function handleHashChange() {
            const hash = window.location.hash.replace('#', '');
            if (hash) {
                switchTab(hash, null);
            }
        }

        window.addEventListener('DOMContentLoaded', handleHashChange);
        window.addEventListener('hashchange', handleHashChange);

        document.onkeydown = function(e) {
            if(event.keyCode == 123) { return false; }
            if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){ return false; }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){ return false; }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){ return false; }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){ return false; }
            if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){ return false; }
            if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){ return false; }
            if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){ return false; }
            if(e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)){ return false; }
        }
        var message="Function Disabled!";
        function clickdsb(){
            if (event.button==2){ alert(message); return false; }
        }
        function clickbsb(e){
            if (document.layers||document.getElementById&&!document.all){
                if (e.which==2||e.which==3){ alert(message); return false; }
            }
        }
        if (document.layers){
            document.captureEvents(Event.MOUSEDOWN);
            document.onmousedown=clickbsb;
        }
        else if (document.all&&!document.all){
            document.onmousedown=clickdsb;
        }
        document.oncontextmenu=new Function("alert(message);return false");
    </script>
</body>
</html>