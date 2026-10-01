<?php
include 'koneksi.php';

// Ambil ID Dokter dari URL
$id_dokter = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Ambil Data Dokter
$q_dok = mysqli_query($conn, "SELECT d.*, p.nama_poli FROM dokter d LEFT JOIN poliklinik p ON d.id_poli = p.id_poli WHERE d.id_dokter = '$id_dokter'");
$dokter = mysqli_fetch_assoc($q_dok);

if (!$dokter) {
    header("Location: jadwal-dokter.php");
    exit();
}

// Ambil Hari Praktik Dokter dari database
$q_jadwal = mysqli_query($conn, "SELECT * FROM jadwal_praktik WHERE id_dokter = '$id_dokter'");
$jadwal_map = [];
while ($j = mysqli_fetch_assoc($q_jadwal)) {
    $hari_db = trim(strtolower($j['hari']));
    
    $j1 = isset($j['jadwal_1']) ? trim($j['jadwal_1']) : '-';
    $j2 = isset($j['jadwal_2']) ? trim($j['jadwal_2']) : '-';
    $status = isset($j['status']) ? intval($j['status']) : 1;

    $ada_jam = (!empty($j1) && $j1 != '-') || (!empty($j2) && $j2 != '-');

    $jadwal_map[$hari_db] = [
        'jadwal_1' => $j1,
        'jadwal_2' => $j2,
        'status'   => $status,
        'tersedia' => ($status != 0 && $ada_jam)
    ];
}

$mapping_hari = [
    'Mon' => 'senin',
    'Tue' => 'selasa',
    'Wed' => 'rabu',
    'Thu' => 'kamis',
    'Fri' => 'jumat',
    'Sat' => 'sabtu',
    'Sun' => 'minggu'
];

$hari_indo_full = [
    'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa',
    'Wed' => 'Rabu',   'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu'
];

// Pengaturan Waktu Real-Time
$tgl_hari_ini_Obj = new DateTime(); 
$tanggal_hari_ini = $tgl_hari_ini_Obj->format('Y-m-d');

$tahun_ini = $tgl_hari_ini_Obj->format('Y');
$bulan_ini = $tgl_hari_ini_Obj->format('m');
$nama_bulan = $tgl_hari_ini_Obj->format('F Y'); 
$jumlah_hari_bulan_ini = intval(date('t', strtotime("$tahun_ini-$bulan_ini-01")));

$hari_pertama_grid = date('w', strtotime("$tahun_ini-$bulan_ini-01")); // 0 = Sun
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Perjanjian - Dr. <?php echo htmlspecialchars($dokter['nama']); ?></title>
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
            color: var(--text-main); 
            margin: 0; 
            padding-bottom: 40px;
        }

        .container { 
            max-width: 1160px; 
            margin: 36px auto; 
            padding: 0 24px; 
        }
        
        /* Profile Header */
        .doctor-header-box {
            background: #ffffff; 
            padding: 24px 28px; 
            border-radius: 12px; 
            border: 1px solid var(--border-color);
            display: flex; 
            gap: 24px; 
            align-items: center; 
            margin-bottom: 24px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .doctor-img { 
            width: 100px; 
            height: 100px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 3px solid #e2e8f0; 
            background: #f1f5f9;
        }
        .doctor-title h2 { 
            margin: 0 0 4px 0; 
            font-size: 20px; 
            color: #0f172a;
            font-weight: 700;
        }
        .doctor-title p { 
            margin: 0 0 14px 0; 
            color: var(--text-muted); 
            font-size: 13.5px; 
        }

        /* Tabel Jadwal Horizontal */
        .schedule-table-horizontal {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .schedule-table-horizontal th {
            background: var(--primary);
            color: #ffffff;
            padding: 10px 8px;
            font-size: 12px;
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .schedule-table-horizontal td {
            background: #ffffff;
            padding: 10px 8px;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            color: #334155;
            font-weight: 500;
        }
        .time-slot-item {
            display: block;
            margin: 2px 0;
        }
        .no-schedule {
            color: #94a3b8;
            font-style: italic;
        }

        /* Calendar Card */
        .calendar-card { 
            background: #ffffff; 
            border-radius: 12px; 
            border: 1px solid var(--border-color); 
            padding: 24px 28px; 
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .calendar-month-title { 
            font-weight: 700; 
            color: #0f172a; 
            font-size: 17px;
            margin-bottom: 16px; 
        }
        .calendar-grid { 
            display: grid; 
            grid-template-columns: repeat(7, 1fr); 
            gap: 1px; 
            background: #cbd5e1; 
            border: 1px solid #cbd5e1; 
            border-radius: 8px;
            overflow: hidden;
        }
        .calendar-header { 
            background: #f1f5f9; 
            text-align: center; 
            font-weight: 700; 
            padding: 10px; 
            font-size: 13px; 
            color: #475569;
        }
        .calendar-header.sun { color: #dc2626; }
        
        /* Kotak Tanggal Standar */
        .calendar-day {
            background: #ffffff; 
            min-height: 55px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: 600; 
            font-size: 14px; 
            color: #94a3b8;
        }

        /* Tanggal yang sudah lewat / tidak ada jadwal (redup & tidak bisa diklik) */
        .calendar-day.past {
            background: #f8fafc;
            color: #cbd5e1;
            cursor: not-allowed;
        }

        /* Hari Minggu (Warna merah & tidak bisa diklik) */
        .calendar-day.sunday {
            color: #dc2626;
            background: #fff5f5;
            cursor: not-allowed;
        }

        /* Kalo Dokter Cuti (Merah redup & tidak bisa diklik) */
        .calendar-day.cuti {
            background: #fdf2f2;
            color: #dc2626;
            cursor: not-allowed;
            font-size: 12px;
            font-weight: 700;
        }

        /* Tanggal Aktif (Bisa diklik) */
        .calendar-day.active {
            color: #0f172a; 
            cursor: pointer; 
            font-weight: 700; 
            transition: all 0.2s ease;
            background: #ffffff;
        }
        .calendar-day.active:hover {
            background: var(--primary-light); 
            color: var(--primary); 
        }

        /* Modal WA Popup */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.4); display: none; justify-content: center; align-items: center; z-index: 999;
        }
        .modal-box {
            background: #ffffff; padding: 24px; border-radius: 12px; width: 90%; max-width: 440px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.15); border: 1px solid var(--border-color);
        }
        .modal-box h3 { font-size: 16px; margin-top: 0; margin-bottom: 16px; color: #0f172a; font-weight: 700; }
        .form-control { width: 100%; padding: 10px 14px; margin-bottom: 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 13.5px; outline: none; font-family: inherit; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12); }
        .form-control[readonly] { background: #f8fafc; color: #64748b; }
        .btn-group { display: flex; gap: 10px; justify-content: flex-end; margin-top: 8px; }
        .btn-kirim { background: var(--primary); color: white; border: none; padding: 9px 18px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13.5px; }
        .btn-kirim:hover { background: var(--primary-dark); }
        .btn-cancel { background: #e2e8f0; color: #334155; border: none; padding: 9px 18px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13.5px; }
        .btn-cancel:hover { background: #cbd5e1; }
    </style>
</head>
<body>

    <?php if (file_exists('header.php')) include 'header.php'; ?>

    <div class="container">
        <!-- Dokter Header -->
        <div class="doctor-header-box">
            <img class="doctor-img" src="<?php echo !empty($dokter['foto']) ? $dokter['foto'] : 'img/default-doctor.png'; ?>" alt="Dokter">
            <div style="flex-grow: 1;">
                <div class="doctor-title">
                    <h2><?php echo htmlspecialchars($dokter['nama']); ?></h2>
                    <p>Silahkan memilih tanggal untuk daftar perjanjian</p>
                </div>
                
                <!-- Tabel Jadwal Horizontal -->
                <table class="schedule-table-horizontal">
                    <thead>
                        <tr>
                            <?php 
                            $hari_list = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                            foreach ($hari_list as $hl) {
                                echo "<th>" . ucfirst($hl) . "</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php 
                            foreach ($hari_list as $hl) {
                                echo "<td>";
                                if (isset($jadwal_map[$hl]) && $jadwal_map[$hl]['status'] != 0) {
                                    $j1 = $jadwal_map[$hl]['jadwal_1'];
                                    $j2 = $jadwal_map[$hl]['jadwal_2'];
                                    
                                    $has_content = false;
                                    if (!empty($j1) && $j1 != '-') {
                                        echo "<span class='time-slot-item'>" . htmlspecialchars($j1) . "</span>";
                                        $has_content = true;
                                    }
                                    if (!empty($j2) && $j2 != '-') {
                                        echo "<span class='time-slot-item'>" . htmlspecialchars($j2) . "</span>";
                                        $has_content = true;
                                    }
                                    if (!$has_content) {
                                        echo "<span class='no-schedule'>-</span>";
                                    }
                                } else {
                                    echo "<span class='no-schedule'>-</span>";
                                }
                                echo "</td>";
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kalender Real-Time Validasi Jadwal Dokter & Cuti -->
        <div class="calendar-card">
            <div class="calendar-month-title"><?php echo $nama_bulan; ?></div>
            <div class="calendar-grid">
                <div class="calendar-header sun">Sun</div>
                <div class="calendar-header">Mon</div>
                <div class="calendar-header">Tues</div>
                <div class="calendar-header">Wed</div>
                <div class="calendar-header">Thu</div>
                <div class="calendar-header">Fri</div>
                <div class="calendar-header">Sat</div>

                <?php
                // Sel kosong sebelum tanggal 1
                for ($i = 0; $i < $hari_pertama_grid; $i++) {
                    echo "<div class='calendar-day'></div>";
                }

                // Fungsi helper untuk merender setiap kotak tanggal dengan cek cuti database
                function renderHariKalender($conn, $id_dokter, $full_date, $d_num, $mapping_hari, $jadwal_map, $tanggal_hari_ini, $hari_indo_full, $bulan_ini, $tahun_ini) {
                    $day_name = date('D', strtotime($full_date)); 
                    $key_hari = isset($mapping_hari[$day_name]) ? $mapping_hari[$day_name] : '';
                    
                    $is_sunday   = ($day_name === 'Sun');
                    $sudah_lewat = ($full_date < $tanggal_hari_ini);
                    
                    // Cek apakah dokter sedang cuti pada tanggal tersebut
                    $safe_id = mysqli_real_escape_string($conn, $id_dokter);
                    $safe_date = mysqli_real_escape_string($conn, $full_date);
                    $q_cuti = mysqli_query($conn, "SELECT * FROM cuti_dokter WHERE id_dokter = '$safe_id' AND tanggal_cuti = '$safe_date'");
                    $is_cuti = ($q_cuti && mysqli_num_rows($q_cuti) > 0);

                    // Cek apakah dokter punya jadwal aktif di hari tersebut
                    $ada_jadwal_dokter = true;
                    if ($key_hari && isset($jadwal_map[$key_hari])) {
                        $ada_jadwal_dokter = $jadwal_map[$key_hari]['tersedia'];
                    } else {
                        $ada_jadwal_dokter = false; 
                    }

                    if ($is_sunday) {
                        echo "<div class='calendar-day sunday' title='Hari Minggu (Libur)'>$d_num</div>";
                    } elseif ($sudah_lewat) {
                        echo "<div class='calendar-day past' title='Tanggal sudah lewat'>$d_num</div>";
                    } elseif ($is_cuti) {
                        echo "<div class='calendar-day cuti' title='Dokter sedang cuti pada tanggal ini'>CUTI</div>";
                    } elseif (!$ada_jadwal_dokter) {
                        echo "<div class='calendar-day past' title='Dokter tidak praktik pada hari ini'>$d_num</div>";
                    } else {
                        $label_lengkap = "hari " . (isset($hari_indo_full[$day_name]) ? $hari_indo_full[$day_name] : $day_name) . " tgl " . $d_num . "-" . intval($bulan_ini) . "-" . $tahun_ini;
                        echo "<div class='calendar-day active' onclick=\"bukaModal('$label_lengkap')\">$d_num</div>";
                    }
                }

                // 1. Render Tanggal 1 sampai Akhir Bulan Berjalan
                for ($d = 1; $d <= $jumlah_hari_bulan_ini; $d++) {
                    $tanggal_str = sprintf("%02d", $d);
                    $full_date = "$tahun_ini-$bulan_ini-$tanggal_str";
                    renderHariKalender($conn, $id_dokter, $full_date, $d, $mapping_hari, $jadwal_map, $tanggal_hari_ini, $hari_indo_full, $bulan_ini, $tahun_ini);
                }

                // 2. Tambahan Ekstra tepat sampai Tanggal 7 di Bulan Berikutnya
                $next_date_obj = new DateTime("$tahun_ini-$bulan_ini-01");
                $next_date_obj->modify('+1 month');
                $next_year = $next_date_obj->format('Y');
                $next_month = $next_date_obj->format('m');
                
                for ($e = 1; $e <= 7; $e++) {
                    $tanggal_str = sprintf("%02d", $e);
                    $full_date = "$next_year-$next_month-$tanggal_str";
                    renderHariKalender($conn, $id_dokter, $full_date, $e, $mapping_hari, $jadwal_map, $tanggal_hari_ini, $hari_indo_full, $next_month, $next_year);
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal WhatsApp Popup -->
    <div class="modal-overlay" id="modalWA">
        <div class="modal-box">
            <h3>Pendaftaran Perjanjian Dokter</h3>
            <input type="text" id="full_name" class="form-control" placeholder="Nama Lengkap Pasien">
            <input type="text" id="phone" class="form-control" placeholder="Nomor Telepon / WhatsApp">
            <input type="text" id="tgl_label" class="form-control" readonly>
            <div class="btn-group">
                <button class="btn-cancel" onclick="tutupModal()">Batal</button>
                <button class="btn-kirim" onclick="kirimKeWhatsApp()">Kirim WhatsApp</button>
            </div>
        </div>
    </div>

    <script>
    function bukaModal(labelTanggal) {
        document.getElementById('tgl_label').value = labelTanggal;
        document.getElementById('modalWA').style.display = 'flex';
    }

    function tutupModal() {
        document.getElementById('modalWA').style.display = 'none';
    }

    function kirimKeWhatsApp() {
        var nama = document.getElementById('full_name').value;
        var phone = document.getElementById('phone').value;
        var tgl = document.getElementById('tgl_label').value;
        var dokter = "<?php echo addslashes($dokter['nama']); ?>";

        if (!nama || !phone) {
            alert("Harap isi Nama dan Nomor Telepon terlebih dahulu!");
            return;
        }

        var no_wa_rs = "6281234567890"; 
        
        var text = "Halo RS Cinta Kasih Tzu Chi, saya ingin mendaftar janji temu dokter:%0A%0A" +
                   "*Nama Pasien:* " + encodeURIComponent(nama) + "%0A" +
                   "*No HP:* " + encodeURIComponent(phone) + "%0A" +
                   "*Dokter:* " + encodeURIComponent(dokter) + "%0A" +
                   "*Jadwal:* " + encodeURIComponent(tgl);

        window.open("https://api.whatsapp.com/send?phone=" + no_wa_rs + "&text=" + text, "_blank");
    }
    </script>

</body>
</html>