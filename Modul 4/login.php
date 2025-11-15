<?php
session_start();

// Jika sudah login, lempar ke index.php
if (isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

// Daftar pengguna yang di-hardcode
$users = [
    'admin' => 'admin123',
    'user'  => 'user123'
];

$error = '';

// Logika saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username ada dan password-nya cocok
    if (isset($users[$username]) && $users[$username] == $password) {
        // Sukses login
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Inisialisasi daftar kontak di session jika belum ada
        if (!isset($_SESSION['contacts'])) {
            $_SESSION['contacts'] = [
                // Data dummy awal
                [
                    'nama' => 'Budi Santoso',
                    'email' => 'budi@example.com',
                    'telepon' => '081234567890'
                ],
                [
                    'nama' => 'Ani Wijaya',
                    'email' => 'ani@example.com',
                    'telepon' => '089876543210'
                ]
            ];
        }

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Login Sistem Kontak</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <small>Hint: Coba 'admin' / 'admin123' atau 'user' / 'user123'</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>