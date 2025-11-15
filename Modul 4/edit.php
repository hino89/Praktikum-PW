<?php
include 'header.php'; // Sudah include auth.php

$errors = [];

// Dapatkan index kontak dari URL
$index = $_GET['index'];

// Cek apakah index valid
if (!isset($index) || !isset($_SESSION['contacts'][$index])) {
    $_SESSION['message'] = "Kontak tidak ditemukan.";
    header("Location: index.php");
    exit;
}

// Ambil data kontak yang akan diedit
$contact = $_SESSION['contacts'][$index];

// Inisialisasi variabel form dengan data yang ada
$nama = $contact['nama'];
$email = $contact['email'];
$telepon = $contact['telepon'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form yang disubmit
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']); // Ini adalah input mentah dari user

    // --- AWAL PERUBAHAN VALIDASI ---
    
    // 1. Bersihkan input telepon dari spasi, strip, atau kurung
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
    elseif (!preg_match('/^(\+\d{9,15}|0\d{8,15})$/', $telepon_clean)) {
         $errors[] = "Format nomor telepon tidak valid. Harus diawali '+' (misal +6281) atau '0' (misal 081) dan berisi 9-16 digit.";
    }
    
    // --- AKHIR PERUBAHAN VALIDASI ---


    // Jika tidak ada error, update session
    if (empty($errors)) {
        $updated_contact = [
            'nama' => $nama,
            'email' => $email,
            // Simpan nomor yang sudah dibersihkan
            'telepon' => $telepon_clean 
        ];
        
        $_SESSION['contacts'][$index] = $updated_contact; // Update kontak di index tsb
        $_SESSION['message'] = "Kontak berhasil diperbarui!"; // Pesan sukses

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
                    <h3 class="mb-0">Edit Kontak</h3>
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

                    <form action="edit.php?index=<?php echo $index; ?>" method="POST">
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
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>