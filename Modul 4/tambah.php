<?php
include 'header.php'; // Sudah include auth.php

$errors = [];
$nama = '';
$email = '';
$telepon = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);

    // --- AWAL PERUBAHAN VALIDASI ---

    // 1. Bersihkan input telepon dari spasi, strip, atau kurung
    // Ini membantu regex bekerja lebih konsisten
    $telepon_clean = preg_replace('/[\s\-()]/', '', $telepon);

    // Validasi Sederhana
    if (empty($nama)) {
        $errors[] = "Nama wajib diisi.";
    }
    if (empty($email)) {
        $errors[] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }
    if (empty($telepon)) {
        $errors[] = "Telepon wajib diisi.";
    } 
    // 2. Validasi format telepon menggunakan Regex
    // Regex ini memeriksa:
    // - (^(\+\d{9,15})$)    : Mulai dengan '+', diikuti 9-15 digit angka.
    // - ATAU
    // - (^(0\d{8,15})$)     : Mulai dengan '0', diikuti 8-15 digit angka.
    elseif (!preg_match('/^(\+\d{9,15}|0\d{8,15})$/', $telepon_clean)) {
        $errors[] = "Format nomor telepon tidak valid. Harus diawali '+' (misal +6281) atau '0' (misal 081) dan berisi 9-16 digit.";
    }
    // --- AKHIR PERUBAHAN VALIDASI ---


    // Jika tidak ada error, simpan ke session
    if (empty($errors)) {
        $new_contact = [
            'nama' => $nama,
            'email' => $email,
            // Simpan nomor yang sudah dibersihkan
            'telepon' => $telepon_clean 
        ];
        
        $_SESSION['contacts'][] = $new_contact; // Tambahkan kontak baru ke array
        $_SESSION['message'] = "Kontak berhasil ditambahkan!"; // Pesan sukses

        header("Location: index.php");
        exit;
    }
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="mb-0">Tambah Kontak Baru</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <strong>Gagal! Terjadi kesalahan:</strong>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="tambah.php" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="telepon" name="telepon" value="<?php echo htmlspecialchars($telepon); ?>" placeholder="Contoh: +628123... atau 08123..." required>
                        </div>
                        
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>