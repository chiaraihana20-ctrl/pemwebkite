<?php
// Pastikan session sudah aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mendeteksi nama file halaman yang sedang dibuka saat ini
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sharky Villa</title>
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
            --text-dark: #0F172A;
            --card-bg: #FFFFFF;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-blue);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .navbar-brand {
            color: var(--text-dark) !important;
            font-weight: 700;
        }

        /* Warna default link navbar */
        .nav-link {
            color: #475569 !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #2563EB !important;
        }

        /* Kelas aktif: Biru tua pekat dan tebal khusus untuk menu yang sedang dibuka */
        .nav-link.active-menu {
            color: var(--text-dark) !important;
            font-weight: 700;
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

        .logo-navbar {
            height: 36px;
            width: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
        <div class="container">
           <a class="navbar-brand d-flex align-items-center text-decoration-none" href="index.php">
            <img src="pict/pinkie.jpg" alt="Logo Sharky Villa" class="logo-navbar me-2"> Sharky Villa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'index.php') ? 'active-menu' : ''; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'descVilla.php') ? 'active-menu' : ''; ?>" href="descVilla.php">Villa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'riwayatPemesanan.php') ? 'active-menu' : ''; ?>" href="riwayatPemesanan.php">Riwayat Pemesanan</a>
                    </li>
                </ul>

                <!-- BAGIAN KANAN NAVBAR (SESSION HANDLING) -->
                <div class="d-flex align-items-center gap-3">
                    <?php if (isset($_SESSION['id_user'])): ?>
                        <!-- Jika user SUDAH login -->
                        <a href="profil.php" class="text-decoration-none text-dark fw-semibold d-flex align-items-center">
                            <i class="bi bi-person-circle fs-5 me-1"></i> <?= htmlspecialchars($_SESSION['nama'] ?? 'Akun'); ?>
                        </a>
                        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
                    <?php else: ?>
                        <!-- Jika user BELUM login -->
                        <a href="login.php" class="text-decoration-none text-dark fw-semibold">Login</a>
                        <a href="register.php" class="btn btn-pink btn-sm rounded-pill px-3">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>