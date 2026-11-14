<?php
session_start();
include 'koneksi.php'; // Koneksi database untuk mengambil daftar villa

// Query mengambil data villa terpopuler dari database
$query_villa = "SELECT * FROM villa LIMIT 4";
$result_villa = mysqli_query($conn, $query_villa);

// Panggil header (navbar otomatis menyesuaikan status login/tamu)
include 'header.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="container my-4">
        
        <!-- HERO BANNER -->
        <div class="hero-section text-left" style="background: linear-gradient(rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.35)), url('https://th.bing.com/th/id/OIP.67xdLyuiMav557y-oPlcDAHaEf?w=269&h=180&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3'); background-size: cover; background-position: center; border-radius: 20px; padding: 80px 40px; color: white;">
            <h1 style="font-weight: 700; font-size: 2.5rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">Liburan Impian Anda<br>Dimulai di Sini</h1>
            <p class="mb-4 text-light">Booking Sekarang, Nikmati Kemudian</p>
            <a href="descVilla.php" class="btn btn-pink px-4 py-2">Cari Villa Sekarang</a>
        </div>

       <!-- SEARCH BAR TANPA LOKASI -->
        <div class="search-card" style="background-color: #ffffff; border-radius: 15px; padding: 20px 25px; box-shadow: 0 8px 20px rgba(0,0,0,0.06); margin-top: -30px; position: relative; z-index: 10;">
            <form action="descVilla.php" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Check-in</label>
                        <input type="date" name="check_in" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Check-out</label>
                        <input type="date" name="check_out" class="form-control">
                    </div>
                    <div class="col-md-3">
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
    <h4 style="font-weight: 700; color: var(--text-dark); margin-top: 40px; margin-bottom: 20px;">Villa Populer<h4>
    <div class="row g-4 mb-5">
    <?php 
    if ($result_villa && mysqli_num_rows($result_villa) > 0) {
        while ($villa = mysqli_fetch_assoc($result_villa)) {
            ?>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background: var(--card-bg); transition: transform 0.3s ease;">
                    
                    <!-- PERBAIKAN 1: Mengambil gambar secara dinamis dari database -->
                    <img src="http://localhost/projek/pict/<?php echo htmlspecialchars($villa['gambar']); ?>" class="card-img-top" style="height: 160px; object-fit: cover;" alt="Foto Villa">
                    
                    <div class="card-body d-flex flex-column justify-content-between p-3">
                        <div>
                            <h5 class="card-title text-truncate fw-bold fs-6 mb-1"><?php echo htmlspecialchars($villa['nama_villa']); ?></h5>
                            
                            <!-- PERBAIKAN 2: Membersihkan format harga agar aman dari error -->
                            <div class="text-primary fw-semibold small mb-1">
                                <?php 
                                    $harga_bersih = preg_replace('/[^0-9]/', '', $villa['harga']);
                                    echo "Rp " . number_format((float)$harga_bersih, 0, ',', '.'); 
                                ?> / malam
                            </div>
                            
                            <div class="text-muted small mb-3">
                                <!-- PERBAIKAN 3: Menghapus tanda minus (-) yang nyasar -->
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