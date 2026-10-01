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

// Proses Update Jadwal / Tambah Cuti via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_update'])) {
    $id_dokter = mysqli_real_escape_string($conn, $_POST['id_dokter']);
    $action_type = isset($_POST['action_type']) ? $_POST['action_type'] : 'jadwal';

    if ($action_type === 'cuti') {
        $tanggal_cuti = mysqli_real_escape_string($conn, $_POST['tanggal_cuti']);
        $keterangan   = isset($_POST['keterangan']) ? mysqli_real_escape_string($conn, $_POST['keterangan']) : "Cuti";

        if (!empty($tanggal_cuti) && !empty($id_dokter)) {
            $cek_cuti = mysqli_query($conn, "SELECT * FROM cuti_dokter WHERE id_dokter = '$id_dokter' AND tanggal_cuti = '$tanggal_cuti'");
            if (!$cek_cuti) {
                echo json_encode(['status' => 'error', 'message' => 'Tabel cuti_dokter belum ada di database! Silakan buat tabelnya dulu.']);
                exit;
            }
            if (mysqli_num_rows($cek_cuti) == 0) {
                $insert = mysqli_query($conn, "INSERT INTO cuti_dokter (id_dokter, tanggal_cuti, keterangan) VALUES ('$id_dokter', '$tanggal_cuti', '$keterangan')");
                if (!$insert) {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal simpan ke database: ' . mysqli_error($conn)]);
                    exit;
                }
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Cuti berhasil ditambahkan!'
        ]);
        exit;
    } else {
        // Proses Update Jadwal Harian Biasa
        $hari      = mysqli_real_escape_string($conn, $_POST['hari']);
        $id_jadwal = trim($_POST['id_jadwal']);
        $is_libur  = isset($_POST['is_libur']) ? true : false;
        $status    = $is_libur ? 0 : 1;
        
        if ($status == 0) {
            $jadwal_1 = '-';
            $jadwal_2 = '-';
        } else {
            $j1_mulai   = trim($_POST['j1_mulai']);
            $j1_selesai = trim($_POST['j1_selesai']);
            $jadwal_1   = (!empty($j1_mulai) && !empty($j1_selesai)) ? $j1_mulai . ' - ' . $j1_selesai : '-';

            $j2_mulai   = trim($_POST['j2_mulai']);
            $j2_selesai = trim($_POST['j2_selesai']);
            $jadwal_2   = (!empty($j2_mulai) && !empty($j2_selesai)) ? $j2_mulai . ' - ' . $j2_selesai : '-';
            
            if ($jadwal_1 == '-' && $jadwal_2 == '-') {
                $status = 0;
            }
        }

        $cek = mysqli_query($conn, "SELECT * FROM jadwal_praktik WHERE id_dokter = '$id_dokter' AND hari = '$hari'");
        if (mysqli_num_rows($cek) > 0) {
            mysqli_query($conn, "UPDATE jadwal_praktik SET jadwal_1 = '$jadwal_1', jadwal_2 = '$jadwal_2', status = '$status' WHERE id_dokter = '$id_dokter' AND hari = '$hari'");
        } else {
            mysqli_query($conn, "INSERT INTO jadwal_praktik (id_jadwal, id_dokter, hari, jadwal_1, jadwal_2, status) VALUES ('$id_jadwal', '$id_dokter', '$hari', '$jadwal_1', '$jadwal_2', '$status')");
        }
        
        echo json_encode([
            'status' => 'success', 
            'message' => 'Berhasil disimpan!',
            'jadwal_1' => $jadwal_1, 
            'jadwal_2' => $jadwal_2, 
            'is_aktif' => $status
        ]);
        exit;
    }
}

// Ambil nomor urut tertinggi untuk inisialisasi ID Jadwal
$res_max = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(id_jadwal, 2) AS UNSIGNED)) as max_num FROM jadwal_praktik");
$row_max = mysqli_fetch_assoc($res_max);
$global_counter = ($row_max && $row_max['max_num']) ? intval($row_max['max_num']) + 1 : 1;

function getNextSequentialId(&$counter) {
    $id = 'J' . str_pad($counter, 3, '0', STR_PAD_LEFT);
    $counter++;
    return $id;
}

$filter_poli = isset($_GET['poliklinik']) ? $_GET['poliklinik'] : '';
$query_poli = "SELECT * FROM poliklinik ORDER BY nama_poli ASC";
$result_poli = mysqli_query($conn, $query_poli);

$query_dokter = "SELECT d.*, p.nama_poli FROM dokter d LEFT JOIN poliklinik p ON d.id_poli = p.id_poli";
if ($filter_poli != '') {
    $safe_poli = mysqli_real_escape_string($conn, $filter_poli);
    $query_dokter .= " WHERE p.id_poli = '$safe_poli'";
}
$query_dokter .= " ORDER BY d.id_dokter ASC";
$result_dokter = mysqli_query($conn, $query_dokter);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Dokter - RS Cinta Kasih Tzu Chi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            background-color: #f4f6f8;
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0; padding: 0;
            line-height: 1.5;
        }
        .breadcrumb-bar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 0;
            font-size: 13px;
            color: #64748b;
        }
        .breadcrumb-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .breadcrumb-container a { color: #0284c7; text-decoration: none; }
        .main-container { max-width: 1200px; margin: 0 auto; padding: 24px 20px 60px 20px; }
        .admin-header-box {
            background: #ffffff; border: 1px solid #cbd5e1; padding: 20px 24px;
            border-radius: 8px; display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 15px;
        }
        .admin-header-box h2 { margin: 0 0 4px 0; font-size: 18px; color: #0f172a; font-weight: 700; }
        .admin-header-box p { margin: 0; font-size: 13px; color: #64748b; }
        .filter-select {
            padding: 9px 14px; border: 1px solid #cbd5e1; border-radius: 6px;
            background: #ffffff; font-size: 13px; color: #334155; outline: none; cursor: pointer; min-width: 240px; font-weight: 500;
        }
        .doctor-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(540px, 1fr)); gap: 18px; }
        .doctor-card { background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; }
        .doctor-card-title {
            padding: 12px 16px; background: #ffffff; border-bottom: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .doctor-card-title h3 { margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; }
        .doctor-card-title span {
            font-size: 12px; color: #0284c7; font-weight: 600; background: #f0f9ff;
            padding: 4px 10px; border-radius: 4px; border: 1px solid #bae6fd;
        }
        .schedule-grid-6 { display: grid; grid-template-columns: repeat(6, 1fr); background: #cbd5e1; gap: 1px; }
        .schedule-cell { background: #ffffff; display: flex; flex-direction: column; cursor: pointer; min-height: 80px; }
        .schedule-cell:hover { background: #f8fafc; }
        .day-header { background: #0284c7; color: #ffffff; font-size: 11px; font-weight: 700; text-align: center; padding: 6px 2px; text-transform: uppercase; }
        .time-body { flex: 1; padding: 8px 4px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; font-size: 11px; text-align: center; }
        .slot { width: 100%; padding: 0; border: none; background: transparent; font-weight: 600; }
        .slot-active { background: transparent; color: #0369a1; border: none; }
        .slot-empty { color: #94a3b8; font-weight: normal; }

        /* TOAST NOTIFICATION */
        #toastNotification {
            visibility: hidden; background-color: #ffffff; color: #0f172a; border: 1px solid #cbd5e1;
            text-align: left; border-radius: 8px; padding: 12px 18px; position: fixed; z-index: 2000;
            right: 24px; bottom: 24px; font-size: 13px; font-weight: 600; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            display: flex; align-items: center; gap: 10px; transform: translateY(20px); opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #toastNotification.show { visibility: visible; transform: translateY(0); opacity: 1; }
        .toast-icon {
            width: 18px; height: 18px; background: #e0f2fe; color: #0284c7; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;
        }

        .modal-backdrop {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.4); z-index: 1000; justify-content: center; align-items: center;
            overflow-y: auto; padding: 20px 0;
        }
        .modal-content {
            background: #ffffff; border-radius: 8px; width: 500px; max-width: 90%;
            border: 1px solid #cbd5e1; box-shadow: 0 10px 25px rgba(0,0,0,0.15); padding: 20px 24px;
            margin: auto; max-height: 90vh; overflow-y: auto;
        }
        .modal-content h3 { margin: 0 0 16px 0; font-size: 16px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
        .tab-menu { display: flex; gap: 8px; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
        .tab-btn { background: #f1f5f9; border: none; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; color: #475569; }
        .tab-btn.active { background: #0284c7; color: #ffffff; }
        .form-row { margin-bottom: 14px; }
        .form-row label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px; }
        .form-row input[type="text"], .form-row input[type="date"] {
            width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 5px;
            font-size: 13px; outline: none; background: #ffffff; color: #1e293b;
        }
        .form-row input[readonly] { background: #f8fafc; color: #0f172a; font-weight: 600; border-color: #cbd5e1; }
        .time-range-group { display: flex; align-items: center; gap: 10px; }
        .time-range-group input[type="time"] {
            border: none; border-bottom: 1px solid #94a3b8; background: transparent; padding: 4px 2px;
            font-size: 14px; font-family: inherit; color: #1e293b; outline: none; width: 110px;
        }
        .time-range-group span { font-size: 12px; color: #64748b; font-weight: 500; }
        .libur-checkbox-wrapper { display: flex; align-items: center; gap: 8px; margin: 14px 0; }
        .libur-checkbox-wrapper input { width: 15px; height: 15px; cursor: pointer; accent-color: #dc2626; }
        .libur-checkbox-wrapper label { margin: 0; font-size: 13px; font-weight: 600; color: #334155; cursor: pointer; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 8px; margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 14px; }
        .btn { padding: 8px 16px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; }
        .btn-submit { background-color: #0284c7; color: #ffffff; }
        .btn-close { background-color: #e2e8f0; color: #334155; }
        .empty-text { grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; color: #64748b; }
    </style>
</head>
<body>
    <?php if (file_exists('header.php')) include 'header.php'; ?>
    <div class="breadcrumb-bar">
        <div class="breadcrumb-container">
            <a href="index.php">Beranda</a> &gt; <span>Kelola Jadwal Dokter</span>
        </div>
    </div>
    
    <!-- Toast Notification -->
    <div id="toastNotification">
        <div class="toast-icon">✓</div>
        <span id="toastMessage">Berhasil disimpan!</span>
    </div>

    <div class="main-container">
        <div class="admin-header-box">
            <div>
                <h2>Kelola Jadwal Praktik Dokter</h2>
                <p>Klik pada kolom hari untuk mengatur jam praktik atau mencatat tanggal cuti dokter.</p>
            </div>
            <div>
                <form method="GET" action="">
                    <select name="poliklinik" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Poliklinik</option>
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
            if (mysqli_num_rows($result_dokter) > 0) {
                while ($dokter = mysqli_fetch_assoc($result_dokter)) {
                    $id_dok    = $dokter['id_dokter'];
                    $nama_dok  = $dokter['nama'];
                    $spesialis = $dokter['spesialis'];
                    $nama_poli = $dokter['nama_poli'] ? $dokter['nama_poli'] : 'Umum';
                    
                    $q_jadwal = mysqli_query($conn, "SELECT * FROM jadwal_praktik WHERE id_dokter = '$id_dok'");
                    $jadwal_map = [];
                    while ($j = mysqli_fetch_assoc($q_jadwal)) {
                        $jadwal_map[strtolower($j['hari'])] = [
                            'id_jadwal' => $j['id_jadwal'],
                            'jadwal_1'  => $j['jadwal_1'],
                            'jadwal_2'  => $j['jadwal_2'],
                            'status'    => isset($j['status']) ? intval($j['status']) : 1
                        ];
                    }
            ?>
                <div class="doctor-card">
                    <div class="doctor-card-title">
                        <div>
                            <h3><?php echo htmlspecialchars($nama_dok); ?></h3>
                            <div style="font-size: 12px; color: #64748b;"><?php echo htmlspecialchars($spesialis); ?></div>
                        </div>
                        <span><?php echo htmlspecialchars($nama_poli); ?></span>
                    </div>
                    <div class="schedule-grid-6">
                        <?php 
                        $hari_arr = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                        foreach ($hari_arr as $h) {
                            $day_data = isset($jadwal_map[$h]) ? $jadwal_map[$h] : null;
                            $id_jdw   = $day_data ? $day_data['id_jadwal'] : getNextSequentialId($global_counter);
                            
                            $j1 = $day_data ? trim($day_data['jadwal_1']) : '-';
                            $j2 = $day_data ? trim($day_data['jadwal_2']) : '-';
                            $status_hari = $day_data ? $day_data['status'] : 1;
                            if ($j1 == '') $j1 = '-';
                            if ($j2 == '') $j2 = '-';

                            $is_aktif = ($status_hari === 1 && $j1 !== '-' && $j1 !== 'CUTI');
                        ?>
                            <div class="schedule-cell" id="cell-<?php echo $id_dok; ?>-<?php echo strtolower($h); ?>" onclick="openModal('<?php echo $id_dok; ?>', '<?php echo htmlspecialchars($nama_dok, ENT_QUOTES); ?>', '<?php echo ucfirst($h); ?>', '<?php echo htmlspecialchars($j1, ENT_QUOTES); ?>', '<?php echo htmlspecialchars($j2, ENT_QUOTES); ?>', '<?php echo $id_jdw; ?>', <?php echo $status_hari; ?>)">
                                <div class="day-header"><?php echo ucfirst(substr($h, 0, 3)); ?></div>
                                <div class="time-body">
                                    <?php if (!$is_aktif): ?>
                                        <div class="slot slot-empty">-</div>
                                    <?php else: ?>
                                        <?php if ($j1 != '-' && $j1 != 'CUTI'): ?><div class="slot slot-active"><?php echo htmlspecialchars($j1); ?></div><?php endif; ?>
                                        <?php if ($j2 != '-'): ?><div class="slot slot-active"><?php echo htmlspecialchars($j2); ?></div><?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php 
                }
            } else {
            ?>
                <div class="empty-text">Data dokter tidak ditemukan.</div>
            <?php } ?>
        </div>
    </div>

    <!-- POPUP MODAL EDIT -->
    <div class="modal-backdrop" id="editModal">
        <div class="modal-content">
            <h3 id="modalTitle">Edit Jadwal Praktik</h3>
            
            <div class="tab-menu">
                <button type="button" class="tab-btn active" id="tabBtnJadwal" onclick="switchTab('jadwal')">Atur Jadwal Harian</button>
                <button type="button" class="tab-btn" id="tabBtnCuti" onclick="switchTab('cuti')">+ Tambah Tanggal Cuti</button>
            </div>

            <!-- FORM JADWAL HARIAN -->
            <form id="formEditJadwal" onsubmit="submitFormAjax(event, 'jadwal')">
                <input type="hidden" name="ajax_update" value="1">
                <input type="hidden" name="action_type" value="jadwal">
                <input type="hidden" name="id_dokter" id="modalIdDokter">
                <input type="hidden" name="hari" id="modalHari">
                <div class="form-row">
                    <label>ID Jadwal</label>
                    <input type="text" name="id_jadwal" id="modalIdJadwal" required>
                </div>
                <div class="form-row">
                    <label>Dokter & Hari</label>
                    <input type="text" id="modalInfo" readonly>
                </div>
                <div class="libur-checkbox-wrapper">
                    <input type="checkbox" name="is_libur" id="modalIsLibur" value="1" onchange="toggleLiburMode(this)">
                    <label for="modalIsLibur">Tidak ada jadwal / Dokter libur di hari ini</label>
                </div>
                <div class="form-row" id="rowJadwal1">
                    <label>Jadwal 1</label>
                    <div class="time-range-group">
                        <input type="time" name="j1_mulai" id="modalJ1Mulai">
                        <span>s/d</span>
                        <input type="time" name="j1_selesai" id="modalJ1Selesai">
                    </div>
                </div>
                <div class="form-row" id="rowJadwal2">
                    <label>Jadwal 2 (Opsional)</label>
                    <div class="time-range-group">
                        <input type="time" name="j2_mulai" id="modalJ2Mulai">
                        <span>s/d</span>
                        <input type="time" name="j2_selesai" id="modalJ2Selesai">
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-close" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan Jadwal</button>
                </div>
            </form>

            <!-- FORM CUTI -->
            <form id="formCutiDokter" style="display: none;" onsubmit="submitFormAjax(event, 'cuti')">
                <input type="hidden" name="ajax_update" value="1">
                <input type="hidden" name="action_type" value="cuti">
                <input type="hidden" name="id_dokter" id="modalCutiIdDokter">
                <div class="form-row">
                    <label>Nama Dokter</label>
                    <input type="text" id="modalCutiInfo" readonly>
                </div>
                <div class="form-row">
                    <label>Pilih Tanggal Cuti (Format: YYYY-MM-DD)</label>
                    <input type="date" name="tanggal_cuti" id="modalTanggalCuti" required>
                </div>
                <div class="form-row">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" value="Cuti" readonly>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-close" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-submit" id="btnSimpanCuti">Simpan Cuti</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let activeIdDokter = '';
        let activeNamaDokter = '';
        let activeHariLower = '';
        let lockedScrollY = 0;

        function showToast(message) {
            var toast = document.getElementById("toastNotification");
            document.getElementById("toastMessage").innerText = message;
            toast.className = "show";
            setTimeout(function(){ 
                toast.className = toast.className.replace("show", ""); 
            }, 2500);
        }

        function switchTab(type) {
            var btnJadwal = document.getElementById('tabBtnJadwal');
            var btnCuti = document.getElementById('tabBtnCuti');
            var formJadwal = document.getElementById('formEditJadwal');
            var formCuti = document.getElementById('formCutiDokter');
            var title = document.getElementById('modalTitle');

            if (type === 'jadwal') {
                btnJadwal.className = 'tab-btn active';
                btnCuti.className = 'tab-btn';
                formJadwal.style.display = 'block';
                formCuti.style.display = 'none';
                title.innerText = "Edit Jadwal - " + document.getElementById('modalHari').value;
            } else {
                btnCuti.className = 'tab-btn active';
                btnJadwal.className = 'tab-btn';
                formCuti.style.display = 'block';
                formJadwal.style.display = 'none';
                title.innerText = "Tambah Cuti - " + activeNamaDokter;
                document.getElementById('modalCutiIdDokter').value = activeIdDokter;
                document.getElementById('modalCutiInfo').value = activeNamaDokter;
            }
        }

        function openModal(idDokter, namaDokter, hari, j1, j2, idJadwal, status) {
            lockedScrollY = window.scrollY;
            activeIdDokter = idDokter;
            activeNamaDokter = namaDokter;
            activeHariLower = hari.toLowerCase();

            switchTab('jadwal');

            document.getElementById('modalIdDokter').value = idDokter;
            document.getElementById('modalHari').value = hari;
            document.getElementById('modalIdJadwal').value = idJadwal;
            
            var cbLibur = document.getElementById('modalIsLibur');
            var j1Mulai = document.getElementById('modalJ1Mulai');
            var j1Selesai = document.getElementById('modalJ1Selesai');
            var j2Mulai = document.getElementById('modalJ2Mulai');
            var j2Selesai = document.getElementById('modalJ2Selesai');

            if (status === 1 && j1 !== '-' && j1 !== 'CUTI') {
                cbLibur.checked = false;
                j1Mulai.disabled = false; j1Selesai.disabled = false;
                j2Mulai.disabled = false; j2Selesai.disabled = false;
                
                if (j1 && j1 !== '-' && j1.includes(' - ')) {
                    var parts1 = j1.split(' - ');
                    j1Mulai.value = parts1[0] ? parts1[0].trim() : '';
                    j1Selesai.value = parts1[1] ? parts1[1].trim() : '';
                } else {
                    j1Mulai.value = ''; j1Selesai.value = '';
                }
                if (j2 && j2 !== '-' && j2.includes(' - ')) {
                    var parts2 = j2.split(' - ');
                    j2Mulai.value = parts2[0] ? parts2[0].trim() : '';
                    j2Selesai.value = parts2[1] ? parts2[1].trim() : '';
                } else {
                    j2Mulai.value = ''; j2Selesai.value = '';
                }
            } else {
                cbLibur.checked = true;
                j1Mulai.value = ''; j1Selesai.value = '';
                j2Mulai.value = ''; j2Selesai.value = '';
                j1Mulai.disabled = true; j1Selesai.disabled = true;
                j2Mulai.disabled = true; j2Selesai.disabled = true;
            }
            document.getElementById('modalInfo').value = namaDokter + " (" + hari + ")";
            document.getElementById('modalTitle').innerText = "Edit Jadwal - " + hari;
            document.getElementById('editModal').style.display = 'flex';
        }

        function submitFormAjax(event, type) {
            event.preventDefault();
            const currentScroll = lockedScrollY || window.scrollY;

            var form = (type === 'cuti') ? document.getElementById('formCutiDokter') : document.getElementById('formEditJadwal');
            var btnSubmit = type === 'cuti' ? document.getElementById('btnSimpanCuti') : form.querySelector('button[type="submit"]');
            
            btnSubmit.disabled = true;
            btnSubmit.innerText = "Menyimpan...";

            var formData = new FormData(form);

            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                btnSubmit.disabled = false;
                btnSubmit.innerText = type === 'cuti' ? "Simpan Cuti" : "Simpan Jadwal";
                
                try {
                    var data = JSON.parse(text);
                    if (data.status === 'success') {
                        closeModal();
                        showToast(data.message);
                        window.scrollTo(0, currentScroll);
                        setTimeout(() => { window.scrollTo(0, currentScroll); }, 10);
                    } else {
                        alert("Gagal: " + (data.message || 'Terjadi kesalahan sistem'));
                    }
                } catch (e) {
                    console.error("Respon Server Bukan JSON:", text);
                    alert("Error Response: " + text);
                }
            })
            .catch(error => {
                btnSubmit.disabled = false;
                btnSubmit.innerText = type === 'cuti' ? "Simpan Cuti" : "Simpan Jadwal";
                console.error('Error:', error);
                alert("Gagal terhubung ke server.");
            });
        }

        function toggleLiburMode(cb) {
            var j1Mulai = document.getElementById('modalJ1Mulai');
            var j1Selesai = document.getElementById('modalJ1Selesai');
            var j2Mulai = document.getElementById('modalJ2Mulai');
            var j2Selesai = document.getElementById('modalJ2Selesai');
            if (cb.checked) {
                j1Mulai.value = ''; j1Selesai.value = '';
                j2Mulai.value = ''; j2Selesai.value = '';
                j1Mulai.disabled = true; j1Selesai.disabled = true;
                j2Mulai.disabled = true; j2Selesai.disabled = true;
            } else {
                j1Mulai.disabled = false; j1Selesai.disabled = false;
                j2Mulai.disabled = false; j2Selesai.disabled = false;
            }
        }

        function closeModal() { 
            document.getElementById('editModal').style.display = 'none'; 
        }

        window.onclick = function(e) { 
            if (e.target == document.getElementById('editModal')) closeModal(); 
        }
    </script>
    <?php if (file_exists('footer.php')) include 'footer.php'; ?>
</body>
</html>