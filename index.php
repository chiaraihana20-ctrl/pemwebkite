<?php
session_start();
include 'koneksi.php'; // WAJIB di paling atas agar $conn aktif

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Query mengambil data villa dari database
$query_villa = "SELECT * FROM villa LIMIT 4";
$result_villa = mysqli_query($conn, $query_villa);

// Panggil header setelah sesi dan koneksi siap
include 'header.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="container my-4">
        
        <!-- HERO BANNER -->
        <div class="hero-section text-left" style="background: linear-gradient(rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.35)), url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80'); background-size: cover; background-position: center; border-radius: 20px; padding: 80px 40px; color: white;">
            <h1 style="font-weight: 700; font-size: 2.5rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">Liburan Impian Anda<br>Dimulai di Sini</h1>
            <p class="mb-4 text-light">Booking Sekarang, Nikmati Kemudian</p>
            <a href="descVilla.php" class="btn btn-pink px-4 py-2">Cari Villa Sekarang</a>
        </div>

        <!-- SEARCH BAR FLOATING CARD -->
        <div class="search-card" style="background-color: #ffffff; border-radius: 15px; padding: 20px 25px; box-shadow: 0 8px 20px rgba(0,0,0,0.06); margin-top: -30px; position: relative; z-index: 10;">
            <form action="descVilla.php" method="GET">
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
        <h4 style="font-weight: 700; color: var(--text-dark); margin-top: 40px; margin-bottom: 20px;">Villa Terpopuler</h4>
        
        <div class="row g-4 mb-5">
            <?php 
            if ($result_villa && mysqli_num_rows($result_villa) > 0) {
                while ($villa = mysqli_fetch_assoc($result_villa)) {
                    ?>
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background: var(--card-bg); transition: transform 0.3s ease;">
                            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=500&q=80" class="card-img-top" style="height: 160px; object-fit: cover;" alt="Foto Villa">
                            <div class="card-body d-flex flex-column justify-content-between p-3">
                                <div>
                                    <h5 class="card-title text-truncate fw-bold fs-6 mb-1"><?php echo htmlspecialchars($villa['nama_villa']); ?></h5>
                                    <div class="text-primary fw-semibold small mb-1">Rp <?php echo number_format($villa['harga'], 0, ',', '.'); ?> / malam</div>
                                    <div class="text-muted small mb-3">
                                        <span>Kapasitas <?php echo htmlspecialchars($villa['kapasitas']); ?> orang</span> • 
                                        <span><?php echo htmlspecialchars($villa['jumlah_kamar']); ?> Kamar</span><br>
                                        <span class="text-success fw-medium">Private Pool</span>
                                    </div>
                                </div>
                                <a href="descVilla.php?id=<?php echo $villa['id_villa']; ?>" class="btn btn-pink btn-sm w-100">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12"><p class="text-muted text-center">Belum ada data villa di database.</p></div>';
            }
            ?>
        </div>

    </div>

<?php 
include 'footer.php'; 
?>