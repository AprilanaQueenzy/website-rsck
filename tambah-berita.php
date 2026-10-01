<?php
include 'koneksi.php';

$pesan = '';
$tipe_pesan = '';

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $konten = trim($_POST['konten']);
    $tanggal = $_POST['tanggal'];

    // Validasi input sederhana
    if (empty($judul) || empty($konten) || empty($tanggal)) {
        $pesan = 'Semua field wajib diisi!';
        $tipe_pesan = 'danger';
    } else {
        // Handling upload foto
        $nama_foto = $_FILES['foto']['name'];
        $tmp_foto = $_FILES['foto']['tmp_name'];
        $error_foto = $_FILES['foto']['error'];

        if ($error_foto === 0) {
            $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'webp'];
            $x = explode('.', $nama_foto);
            $ekstensi = strtolower(end($x));

            if (in_array($ekstensi, $ekstensi_diizinkan)) {
                // Buat nama file unik agar tidak bentrok
                $foto_baru = time() . '_' . $nama_foto;
                $folder_tujuan = 'uploads/' . $foto_baru;

                // Buat folder uploads jika belum ada
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                // Pindahkan file ke folder uploads
                if (move_uploaded_file($tmp_foto, $folder_tujuan)) {
                    // Simpan ke database
                    $query = "INSERT INTO berita (judul, konten, tanggal, foto) VALUES ('$judul', '$konten', '$tanggal', '$foto_baru')";
                    
                    if (mysqli_query($conn, $query)) {
                        $pesan = 'Berita berhasil ditambahkan!';
                        $tipe_pesan = 'success';
                    } else {
                        $pesan = 'Gagal menyimpan data ke database: ' . mysqli_error($conn);
                        $tipe_pesan = 'danger';
                    }
                } else {
                    $pesan = 'Gagal mengupload gambar.';
                    $tipe_pesan = 'danger';
                }
            } else {
                $pesan = 'Format gambar harus JPG, JPEG, PNG, atau WEBP.';
                $tipe_pesan = 'danger';
            }
        } else {
            $pesan = 'Pilih gambar berita terlebih dahulu.';
            $tipe_pesan = 'danger';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - Admin Panel</title>
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --danger: #ef4444;
            --success: #22c55e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            padding: 40px 20px;
        }

        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background: var(--white);
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        .form-header {
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-header h2 {
            font-size: 1.5rem;
            color: var(--text-main);
            font-weight: 700;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }

        .btn-submit {
            background-color: var(--primary);
            color: var(--white);
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background-color: var(--primary-dark);
        }

        .btn-kembali {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-kembali:hover {
            color: var(--text-main);
        }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-header">
            <h2>Tambah Berita Baru</h2>
            <a href="berita.php" class="btn-kembali">&larr; Kembali</a>
        </div>

        <?php if (!empty($pesan)): ?>
            <div class="alert alert-<?php echo $tipe_pesan; ?>">
                <?php echo $pesan; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul Berita</label>
                <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan judul berita..." required>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Diterbitkan</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label for="foto">Foto Header / Banner Berita</label>
                <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="konten">Isi Berita</label>
                <textarea name="konten" id="konten" class="form-control" placeholder="Tuliskan isi berita secara lengkap..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Simpan Berita</button>
        </form>
    </div>

</body>
</html>