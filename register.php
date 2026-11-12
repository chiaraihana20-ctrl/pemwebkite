<?php
session_start();
include 'koneksi.php';

$pesan = "";
$tipe_alert = "";

if (isset($_POST['register'])) {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Cek apakah email sudah terdaftar di database
    $cek_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    
    if (mysqli_num_rows($cek_email) > 0) {
        $pesan = "Email sudah terdaftar! Silakan gunakan email lain atau masuk.";
        $tipe_alert = "danger";
    } else {
        // Enkripsi password menggunakan password_hash agar aman
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Simpan data ke tabel user
        $query_insert = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$password_hashed')";
        
        if (mysqli_query($conn, $query_insert)) {
            // Redirect ke halaman login dengan membawa pesan sukses
            header("Location: login.php?pesan=registrasi_berhasil");
            exit;
        } else {
            $pesan = "Registrasi gagal, silakan coba lagi: " . mysqli_error($conn);
            $tipe_alert = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sharky Villa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-blue: #D6EFFF;
            --pink-accent: #FFB7C5;
            --pink-hover: #FF9EAA;
            --text-dark: #334E68;
            --card-bg: #FFFFFF;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-blue);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .btn-pink {
            background-color: var(--pink-accent);
            color: #ffffff;
            font-weight: 600;
            border-radius: 20px;
            padding: 8px 20px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-pink:hover {
            background-color: var(--pink-hover);
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                
                <!-- Notifikasi Pesan Error -->
                <?php if (!empty($pesan)): ?>
                    <div class="alert alert-<?= $tipe_alert; ?> alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                        <?= $pesan; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Card Form Registrasi -->
                <div class="card border-0 shadow-lg rounded-4 p-4" style="background: var(--card-bg);">
                    <div class="text-center mb-4">
                        <div class="mb-2 text-primary fs-1">
                            <i class="bi bi-water"></i>
                        </div>
                        <h3 class="fw-bold" style="color: var(--text-dark);">Daftar Akun</h3>
                        <p class="text-muted small">Buat akun Sharky Villa baru Anda</p>
                    </div>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="nama" class="form-control border-start-0 bg-light py-2" placeholder="Nama Lengkap" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 bg-light py-2" placeholder="nama@email.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 bg-light py-2" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" name="register" class="btn btn-pink w-100 py-2 shadow-sm fw-bold">Daftar Sekarang</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="small text-muted">Sudah punya akun? <a href="login.php" class="text-decoration-none fw-bold" style="color: #2563EB;">Masuk disini</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>