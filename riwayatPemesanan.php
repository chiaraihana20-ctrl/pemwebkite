<?php
session_start();
include 'koneksi.php';

// Jika user belum login, alihkan ke halaman login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data riwayat pemesanan berdasarkan user yang sedang login, di-join dengan tabel villa
$query = "SELECT booking.*, villa.nama_villa, villa.gambar 
          FROM booking 
          JOIN villa ON booking.id_villa = villa.id_villa 
          WHERE booking.id_user = '$id_user' 
          ORDER BY booking.id_booking DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Sharky Villa</title>
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

        .navbar-brand, .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #2563EB !important;
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

        .card-villa {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .card-villa:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-decoration-none" href="index.php">
                <i class="bi bi-water me-2 fs-3 text-primary"></i> Sharky Villa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="descVilla.php">Villa</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold text-primary" href="riwayat_pesanan.php">Riwayat Pemesanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="profile.php" class="text-decoration-none text-dark fw-semibold d-flex align-items-center">
                        <i class="bi bi-person-circle fs-5 me-1"></i> <?= htmlspecialchars($_SESSION['nama'] ?? 'Akun'); ?>
                    </a>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: var(--text-dark);">Riwayat Pemesanan</h2>
                <p class="text-muted">Daftar pemesanan villa yang pernah Anda lakukan.</p>
            </div>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row g-4">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-12">
                        <div class="card card-villa p-4 bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <img src="img/<?= htmlspecialchars($row['gambar']); ?>" alt="Foto Villa" class="img-fluid rounded-4 object-fit-cover" style="height: 140px; width: 100%;">
                                </div>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($row['nama_villa']); ?></h4>
                                    <p class="text-muted small mb-2"><i class="bi bi-calendar-event me-1"></i> <?= htmlspecialchars($row['tanggal_masuk']); ?> s/d <?= htmlspecialchars($row['tanggal_kelaur']); ?></p>
                                    <p class="mb-1 small"><strong>Jumlah Tamu:</strong> <?= htmlspecialchars($row['jumlah_tamu']); ?> Orang</p>
                                    <p class="mb-0 text-primary fw-bold">Total: Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <?php 
                                        $status = $row['status'];
                                        $badge_bg = 'bg-secondary';
                                        if ($status == 'Pending') $badge_bg = 'bg-warning text-dark';
                                        else if ($status == 'Confirmed' || $status == 'Berhasil') $badge_bg = 'bg-success';
                                        else if ($status == 'Cancelled') $badge_bg = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge_bg; ?> px-3 py-2 rounded-pill mb-2"><?= htmlspecialchars($status); ?></span>
                                    <div class="mt-2">
                                        <a href="detail_pesanan.php?id=<?= $row['id_booking']; ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <!-- Jika belum ada riwayat pemesanan -->
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <div class="fs-1 text-muted mb-3"><i class="bi bi-journal-x"></i></div>
                <h5 class="fw-bold text-muted">Belum ada riwayat pemesanan</h5>
                <p class="text-muted small mb-4">Yuk, cari villa impianmu dan mulai liburan sekarang!</p>
                <a href="descVilla.php" class="btn btn-pink px-4">Cari Villa Sekarang</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- FOOTER -->
    <footer class="text-center py-4 bg-white text-muted small shadow-sm mt-5">
        &copy; 2026 Sharky Villa. All Rights Reserved.
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>