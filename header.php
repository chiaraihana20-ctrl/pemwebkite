<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sharky Villa - Liburan Impian Anda</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-blue: #D6EFFF;
            --navbar-blue: #BCE2FF;
            --pink-accent: #FFB7C5;
            --pink-hover: #FF9EAA;
            --text-dark: #334E68;
            --card-bg: #FFFFFF;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-blue);
            color: var(--text-dark);
        }

        .navbar-custom {
            background-color: var(--navbar-blue);
            padding: 12px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: #1E3A8A !important;
            font-size: 1.5rem;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 8px;
        }

        .btn-pink {
            background-color: var(--pink-accent);
            color: #ffffff;
            font-weight: 600;
            border-radius: 20px;
            padding: 6px 20px;
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

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
           <a class="navbar-brand d-flex align-items-center text-decoration-none" href="index.php">
             <img src="pict/ping.png" alt="Logo Sharky Villa" width="40" height="40" class="me-2 rounded-circle object-fit-cover"> 
             <span class="fw-bold" style="color: #1E3A8A;">Sharky Villa</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link fw-bold" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="villa.php">Villa</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat Pemesanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <?php 
                    if (isset($_SESSION['nama'])) {
                        echo '<a href="profil.php" class="me-3 text-decoration-none fw-semibold text-dark">';
                        echo '<i class="bi bi-person-circle fs-4 me-1 align-middle"></i> ' . htmlspecialchars($_SESSION['nama']);
                        echo '</a>';
                        echo '<a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout</a>';
                    } else {
                        echo '<i class="bi bi-person-circle fs-4 me-2 text-secondary"></i>';
                        echo '<a href="login.php" class="btn btn-pink">Login / Daftar</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>