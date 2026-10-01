<?php
// === KONEKSI DATABASE (Laragon) ===
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "db_rumahsakit";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil tanggal hari ini (real-time) untuk pengecekan cuti
$today_date = date('Y-m-d');

// Ambil filter poliklinik jika dipilih
$filter_poli = isset($_GET['poliklinik']) ? $_GET['poliklinik'] : '';

// Ambil daftar poliklinik untuk dropdown filter
$query_poli = "SELECT * FROM poliklinik ORDER BY nama_poli ASC";
$result_poli = mysqli_query($conn, $query_poli);

// Ambil data dokter
$query_dokter = "SELECT d.*, p.nama_poli FROM dokter d 
                 LEFT JOIN poliklinik p ON d.id_poli = p.id_poli";
if ($filter_poli != '') {
    $safe_poli = mysqli_real_escape_string($conn, $filter_poli);
    $query_dokter .= " WHERE p.id_poli = '$safe_poli'";
}
$query_dokter .= " ORDER BY d.id_dokter ASC";
$result_dokter = mysqli_query($conn, $query_dokter);

// Filter array dokter: hanya ambil yang memiliki minimal satu jadwal aktif
$filtered_doctors = [];
if ($result_dokter && mysqli_num_rows($result_dokter) > 0) {
    while ($dokter = mysqli_fetch_assoc($result_dokter)) {
        $id_dok = $dokter['id_dokter'];
        
        // Cek apakah dokter sedang cuti HARI INI berdasarkan tanggal di tabel cuti_dokter
        $q_cuti = mysqli_query($conn, "SELECT * FROM cuti_dokter WHERE id_dokter = '$id_dok' AND tanggal_cuti = '$today_date'");
        $is_cuti_today = (mysqli_num_rows($q_cuti) > 0);
        $cuti_data = $is_cuti_today ? mysqli_fetch_assoc($q_cuti) : null;

        $q_jadwal = mysqli_query($conn, "SELECT * FROM jadwal_praktik WHERE id_dokter = '$id_dok'");
        $has_active_schedule = false;
        $jadwal_map = [];

        while ($j = mysqli_fetch_assoc($q_jadwal)) {
            $h = strtolower($j['hari']);
            $status = isset($j['status']) ? intval($j['status']) : 1;
            $j1 = isset($j['jadwal_1']) ? trim($j['jadwal_1']) : '-';
            $j2 = isset($j['jadwal_2']) ? trim($j['jadwal_2']) : '-';

            $jadwal_map[$h] = [
                'jadwal_1' => $j1,
                'jadwal_2' => $j2,
                'status'   => $status
            ];

            if ($status === 1 && $j1 !== '-' && $j1 !== '') {
                $has_active_schedule = true;
            }
        }

        // Jika dokter punya jadwal aktif, masukkan ke daftar tampil
        if ($has_active_schedule) {
            $filtered_doctors[] = [
                'data'      => $dokter,
                'jadwal'    => $jadwal_map,
                'is_cuti'   => $is_cuti_today,
                'cuti_info' => $cuti_data
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Dokter - RS Cinta Kasih Tzu Chi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --primary-light: #e0f2fe;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --bg-body: #f8fafc;
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0; padding: 0;
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        .main-container {
            max-width: 1200px;
            margin: 36px auto;
            padding: 0 20px;
        }

        .filter-section {
            background: #ffffff;
            border: 1px solid var(--border-color);
            padding: 20px 24px;
            border-radius: 12px;
            margin-bottom: 28px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .section-title h1 {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .section-title p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin: 0;
        }

        .filter-select {
            padding: 10px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            font-weight: 500;
            background: #ffffff;
            color: var(--text-main);
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 280px;
        }

        .filter-select:hover, .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .doctor-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .doctor-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .doctor-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
            box-shadow: 0 12px 24px -6px rgba(2, 132, 199, 0.12);
        }

        /* JIKA DOKTER CUTI: Kartu jadi merah redup dan tidak bisa dipencet sama sekali */
        .doctor-card.is-cuti-card {
            background: #fdf2f2;
            border-color: #fca5a5;
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.9;
        }

        .doctor-body {
            padding: 24px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .doctor-photo-wrap {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            overflow: hidden;
            background: #f1f5f9;
            border: 3px solid #e2e8f0;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.06);
        }

        .doctor-photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .doctor-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .doctor-name {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            line-height: 1.3;
        }

        .doctor-specialty {
            font-size: 13.5px;
            color: var(--primary);
            font-weight: 600;
            margin: 0;
        }

        .click-instruction {
            font-size: 12px;
            color: var(--text-muted);
            margin: 2px 0 0 0;
            font-weight: 500;
        }

        .cuti-warning-text {
            font-size: 12px;
            color: #dc2626;
            margin: 2px 0 0 0;
            font-weight: 700;
        }

        .poli-badge {
            font-size: 11.5px;
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 600;
            width: fit-content;
            margin-top: 4px;
            border: 1px solid #bae6fd;
        }

        .schedule-horizontal-bar {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 16px 12px;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0;
        }

        .schedule-item-clean {
            text-align: center;
            padding: 0 4px;
            border-right: 1px solid #e2e8f0;
        }

        .schedule-item-clean:last-child {
            border-right: none;
        }

        .schedule-day-title {
            font-size: 10.5px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .schedule-hour-text {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.4;
            margin-bottom: 2px;
        }

        .schedule-cuti-text {
            font-size: 10.5px;
            font-weight: 700;
            color: #dc2626;
            text-transform: uppercase;
        }

        .schedule-off-text {
            font-size: 11px;
            color: #94a3b8;
            font-style: italic;
            font-weight: 500;
        }

        .empty-state {
            grid-column: span 2;
            text-align: center;
            padding: 60px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .doctor-grid { grid-template-columns: 1fr; }
            .filter-section { flex-direction: column; align-items: stretch; }
            .filter-select { width: 100%; }
            .schedule-horizontal-bar { grid-template-columns: repeat(3, 1fr); row-gap: 14px; }
            .schedule-item-clean { border-right: none; }
        }
    </style>
</head>
<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <div class="main-container">
        <div class="filter-section">
            <div class="section-title">
                <h1>Jadwal Praktik Dokter</h1>
                <p>Informasi jadwal dokter spesialis RS Cinta Kasih Tzu Chi</p>
            </div>
            <div>
                <form method="GET" action="">
                    <select name="poliklinik" class="filter-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Poliklinik / Semua Poli --</option>
                        <?php while ($poli = mysqli_fetch_assoc($result_poli)): ?>
                            <option value="<?php echo $poli['id_poli']; ?>" <?php echo ($filter_poli == $poli['id_poli']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($poli['nama_poli']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </form>
            </div>
        </div>

        <div class="doctor-grid">
            <?php 
            if (!empty($filtered_doctors)) {
                foreach ($filtered_doctors as $item) {
                    $dokter     = $item['data'];
                    $jadwal_map = $item['jadwal'];
                    $is_cuti    = $item['is_cuti'];
            ?>
                <!-- JIKA CUTI, BUNGKUS DENGAN DIV BIASA (TIDAK ADA LINK & TIDAK BISA DIPENCET) -->
                <?php if ($is_cuti): ?>
                    <div class="doctor-card is-cuti-card">
                <?php else: ?>
                    <a href="form-dokter.php?id=<?php echo $dokter['id_dokter']; ?>" class="doctor-card-link">
                        <div class="doctor-card">
                <?php endif; ?>

                        <div class="doctor-body">
                            <div class="doctor-photo-wrap">
                                <?php $foto = !empty($dokter['foto']) ? $dokter['foto'] : 'img/default-doctor.png'; ?>
                                <img src="<?php echo htmlspecialchars($foto); ?>" alt="Dr. <?php echo htmlspecialchars($dokter['nama']); ?>">
                            </div>
                            <div class="doctor-info">
                                <h3 class="doctor-name"><?php echo htmlspecialchars($dokter['nama']); ?></h3>
                                <p class="doctor-specialty"><?php echo htmlspecialchars($dokter['spesialis']); ?></p>
                                
                                <?php if ($is_cuti): ?>
                                    <p class="cuti-warning-text">⚠ Sedang Cuti Hari Ini</p>
                                <?php else: ?>
                                    <p class="click-instruction">Klik untuk pilih jadwal &rarr;</p>
                                <?php endif; ?>

                                <?php if (!empty($dokter['nama_poli'])): ?>
                                    <span class="poli-badge"><?php echo htmlspecialchars($dokter['nama_poli']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Baris Jadwal Bawah -->
                        <div class="schedule-horizontal-bar">
                            <?php 
                            $hari_inggris = date('l');
                            $map_hari = [
                                'Monday' => 'senin', 'Tuesday' => 'selasa', 'Wednesday' => 'rabu',
                                'Thursday' => 'kamis', 'Friday' => 'jumat', 'Saturday' => 'sabtu', 'Sunday' => 'minggu'
                            ];
                            $hari_ini_indo = isset($map_hari[$hari_inggris]) ? $map_hari[$hari_inggris] : '';

                            $hari_arr = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                            foreach ($hari_arr as $h) {
                                $day_data = isset($jadwal_map[$h]) ? $jadwal_map[$h] : null;
                                $status   = $day_data ? $day_data['status'] : 1;
                                $j1       = $day_data ? $day_data['jadwal_1'] : '-';
                                $j2       = $day_data ? $day_data['jadwal_2'] : '-';
                                
                                $is_aktif = ($status === 1 && $j1 !== '-' && $j1 !== '');
                                
                                // Jika dokter cuti hari ini, kolom pada hari ini otomatis jadi tulisan CUTI
                                $is_cuti_cell = ($is_cuti && $h === $hari_ini_indo);
                            ?>
                                <div class="schedule-item-clean">
                                    <div class="schedule-day-title"><?php echo ucfirst(substr($h, 0, 3)); ?></div>
                                    
                                    <?php if ($is_cuti_cell): ?>
                                        <div class="schedule-cuti-text">CUTI</div>
                                    <?php elseif (!$is_aktif): ?>
                                        <div class="schedule-off-text">-</div>
                                    <?php else: ?>
                                        <?php if (!empty($j1) && $j1 != '-'): ?>
                                            <div class="schedule-hour-text"><?php echo htmlspecialchars($j1); ?></div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($j2) && $j2 != '-'): ?>
                                            <div class="schedule-hour-text"><?php echo htmlspecialchars($j2); ?></div>
                                        <?php endif; ?>

                                        <?php if ((empty($j1) || $j1 == '-') && (empty($j2) || $j2 == '-')): ?>
                                            <div class="schedule-off-text">-</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php } ?>
                        </div>

                <?php if ($is_cuti): ?>
                    </div>
                <?php else: ?>
                        </div>
                    </a>
                <?php endif; ?>

            <?php 
                }
            } else {
            ?>
                <div class="empty-state">
                    <p>Tidak ada dokter yang memiliki jadwal aktif untuk poliklinik yang dipilih.</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php if (file_exists('footer.php')) include 'footer.php'; ?>

</body>
</html>