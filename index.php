<?php
session_start();
include 'koneksi.php'; // Diubah karena file koneksi.php berada di satu folder yang sama

// Ambil data villa dari database
$query_villa = "SELECT * FROM villa LIMIT 4";
$result_villa = mysqli_query($conn,$query_villa);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sharky Villa - Liburan Impian Anda</title>
    <!-- Bootstrap 5 CSS (Bootcamp Standard CDN) -->
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

        /* Navbar Styling */
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

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.35)), url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            padding: 80px 40px;
            color: white;
            margin-top: 20px;
        }

        .hero-title {
            font-weight: 700;
            font-size: 2.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Search Bar Floating Card */
        .search-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 20px 25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            margin-top: -30px;
            position: relative;
            z-index: 10;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #CBD5E1;
            font-size: 0.9rem;
        }

        /* Villa Cards */
        .section-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .card-villa {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            background: var(--card-bg);
        }

        .card-villa:hover {
            transform: translateY(-5px);
        }

        .card-villa img {
            height: 160px;
            object-fit: cover;
        }

        .card-villa .card-body {
            padding: 15px;
        }

        .card-villa .card-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .villa-price {
            font-size: 0.85rem;
            color: #2563EB;
            font-weight: 600;
        }

        .villa-spec {
            font-size: 0.75rem;
            color: #64748B;
        }

        /* Footer */
        footer {
            background-color: var(--navbar-blue);
            margin-top: 60px;
            padding: 30px 0;
            border-top: 2px solid var(--pink-accent);
        }

        footer a {
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        footer a:hover {
            color: #1E3A8A;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="pict/pinkie.jpg" alt="Logo Sharky Villa" width="40" height="40" class="me-2 rounded-circle"> 
    Sharky Villa
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
                    <?php if (isset($_SESSION['nama'])): ?>
                        <a href="profil.php" class="me-3 text-decoration-none fw-semibold text-dark">
                            <i class="bi bi-person-circle fs-4 me-1 align-middle"></i> <?= htmlspecialchars($_SESSION['nama']); ?>
                        </a>
                        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout</a>
                    <?php else: ?>
                        <i class="bi bi-person-circle fs-4 me-2 text-secondary"></i>
                        <a href="login.php" class="btn btn-pink">Login / Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="container">
        
        <!-- HERO BANNER -->
        <div class="hero-section text-left">
            <h1 class="hero-title">Liburan Impian Anda<br>Dimulai di Sini</h1>
            <p class="mb-4 text-light">Booking Sekarang, Nikmati Kemudian</p>
            <a href="villa.php" class="btn btn-pink px-4 py-2">Cari Villa Sekarang</a>
        </div>

        <!-- SEARCH BAR FORM -->
        <div class="search-card">
            <form action="villa.php" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Kuta, Bali / Jogja">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Check-in</label>
                        <input type="date" name="check_in" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Check-out</label>
                        <input type="date" name="check_out" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small mb-1">Tamu</label>
                        <select name="tamu" class="form-select">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="4">4 Orang</option>
                            <option value="6">6+ Orang</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-pink w-100 py-2">Cari</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- VILLA TERPOPULER SECTION -->
        <h4 class="section-title">Villa Terpopuler</h4>
        
        <div class="row g-4 mb-5">
            <?php 
            if ($result_villa && mysqli_num_rows($result_villa) > 0): 
                while ($villa = mysqli_fetch_assoc($result_villa)):
            ?>
                <div class="col-md-3">
                    <div class="card card-villa h-100">
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Foto Villa">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title text-truncate"><?= htmlspecialchars($villa['nama_villa']); ?></h5>
                                <div class="villa-price mb-1">Rp <?= number_format($villa['harga'], 0, ',', '.'); ?> / malam</div>
                                <div class="villa-spec mb-3">
                                    <span>Kapasitas <?= $villa['kapasitas']; ?> orang</span> • 
                                    <span><?= $villa['jumlah_kamar']; ?> Kamar Tidur</span><br>
                                    <span class="text-success fw-medium">Private Pool</span>
                                </div>
                            </div>
                            <a href="detail-villa.php?id=<?= $villa['id_villa']; ?>" class="btn btn-pink btn-sm w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile; 
            else: 
            ?>
                <!-- Dummy Static Cards jika database MySQL masih kosong -->
                <div class="col-md-3">
                    <div class="card card-villa h-100">
                        <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Villa Sunset">
                        <div class="card-body">
                            <h5 class="card-title">Villa Sunset</h5>
                            <div class="villa-price mb-1">Rp 1.500.000 / malam</div>
                            <div class="villa-spec mb-3">Kapasitas 4 orang • Private Pool</div>
                            <a href="detail-villa.php?id=1" class="btn btn-pink btn-sm w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-villa h-100">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Villa Coral">
                        <div class="card-body">
                            <h5 class="card-title">Villa Coral</h5>
                            <div class="villa-price mb-1">Rp 1.900.000 / malam</div>
                            <div class="villa-spec mb-3">Kapasitas 6 orang • 4 Kamar Tidur</div>
                            <a href="detail-villa.php?id=2" class="btn btn-pink btn-sm w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-villa h-100">
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Villa Wave">
                        <div class="card-body">
                            <h5 class="card-title">Villa Wave</h5>
                            <div class="villa-price mb-1">Rp 1.200.000 / malam</div>
                            <div class="villa-spec mb-3">Kapasitas 4 orang • Private Pool</div>
                            <a href="detail-villa.php?id=3" class="btn btn-pink btn-sm w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-villa h-100">
                        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Villa Pearl">
                        <div class="card-body">
                            <h5 class="card-title">Villa Pearl</h5>
                            <div class="villa-price mb-1">Rp 1.500.000 / malam</div>
                            <div class="villa-spec mb-3">Kapasitas 8 orang • 4 Kamar Tidur</div>
                            <a href="detail-villa.php?id=4" class="btn btn-pink btn-sm w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <div class="mb-3">
                <a href="#" class="mx-3">Kontak</a>
                <a href="#" class="mx-3">FAQ</a>
                <a href="#" class="mx-3">Syarat & Ketentuan</a>
            </div>
            <div class="mb-3 text-danger fs-5">
                <i class="bi bi-instagram mx-1"></i>
                <i class="bi bi-facebook mx-1"></i>
                <i class="bi bi-twitter-x mx-1"></i>
            </div>
            <small class="text-secondary">&copy; 2026 Sharky Villa. All Rights Reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script
