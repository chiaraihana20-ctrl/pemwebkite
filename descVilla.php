<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include 'koneksi.php';

// Mengambil ID villa dari URL (default ke 1 jika tidak ada)
$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

// Mengambil data villa berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM villa WHERE id_villa = $id");
$data = mysqli_fetch_assoc($query);

// Jika villa tidak ditemukan
if (!$data) {
    echo "<div class='container text-center py-5'><h3>Villa tidak ditemukan!</h3><a href='index.php' class='btn btn-pink mt-3'>Kembali ke Beranda</a></div>";
    exit;
}

// Mengambil villa sebelumnya (Prev)
$queryPrev = mysqli_query($conn, "SELECT id_villa FROM villa WHERE id_villa < $id ORDER BY id_villa DESC LIMIT 1");
$prev = mysqli_fetch_assoc($queryPrev);

// Mengambil villa berikutnya (Next)
$queryNext = mysqli_query($conn, "SELECT id_villa FROM villa WHERE id_villa > $id ORDER BY id_villa ASC LIMIT 1");
$next = mysqli_fetch_assoc($queryNext);

// Panggil header (Navbar otomatis menyesuaikan status login)
include 'header.php';
?>

<!-- DETAIL VILLA -->
<section class="py-5">
    <div class="container">

        <!-- TOMBOL KEMBALI -->
        <div class="mb-4">
            <a href="index.php" class="btn fw-bold px-4 py-2" style="background-color: var(--pink-accent); color: #ffffff; border: none; border-radius: 20px;">
                ← Kembali
            </a>
        </div>

        <div class="d-flex align-items-center justify-content-center gap-3">

            <!-- PANAH KIRI -->
            <?php if ($prev) { ?>
                <a href="descVilla.php?id=<?php echo $prev['id_villa']; ?>" 
                   class="btn btn-outline-primary rounded-circle fw-bold d-flex justify-content-center align-items-center flex-shrink-0 bg-white shadow-sm"
                   style="width: 55px; height: 55px; font-size: 22px; border-color: #cbd5e1;">
                    ←
                </a>
            <?php } else { ?>
                <div style="width: 55px;"></div>
            <?php } ?>

            <!-- CARD DETAIL VILLA -->
            <div class="card border-0 rounded-4 overflow-hidden flex-grow-1 shadow-sm" style="background-color: var(--card-bg); max-width: 1100px;">
                <div class="row g-0 align-items-center">
                    
                    <!-- FOTO VILLA -->
                    <div class="col-lg-5 text-center p-4 bg-light">
                        <img src="http://localhost/projek2/pict/<?php echo htmlspecialchars($data['gambar']); ?>" 
                             class="img-fluid rounded-3 shadow-sm" 
                             style="max-height: 380px; width: 100%; object-fit: cover;" 
                             alt="Foto Villa">
                    </div>

                    <!-- INFORMASI VILLA -->
                    <div class="col-lg-7 p-4 p-lg-5">
                        
                        <span class="badge fw-bold px-3 py-2 mb-3" style="background-color: var(--pink-accent); color: #ffffff; font-size: 0.85rem;">
                            DETAIL VILLA
                        </span>

                        <!-- NAMA VILLA -->
                        <h1 class="display-6 fw-bold text-dark mb-2">
                            <?php echo htmlspecialchars($data['nama_villa']); ?>
                        </h1>

                        <!-- HARGA (DIPERBAIKI) -->
                        <h4 class="fw-bold text-primary mb-3">
                            <?php 
                                $harga_bersih = preg_replace('/[^0-9]/', '', $data['harga']);
                                echo "Rp " . number_format((float)$harga_bersih, 0, ',', '.'); 
                            ?> 
                            <span class="text-muted small fw-normal">/ malam</span>
                        </h4>

                        <!-- DESKRIPSI -->
                        <p class="text-muted mb-4" style="line-height: 1.6;">
                            <?php echo htmlspecialchars($data['deskripsi']); ?>
                        </p>

                        <hr class="text-muted opacity-25">

                        <!-- INFORMASI TAMBAHAN -->
                        <div class="row my-3">
                            <div class="col-6">
                                <h6 class="fw-bold text-dark mb-1">
                                    <i class="bi bi-people-fill text-primary me-1"></i> Kapasitas
                                </h6>
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($data['kapasitas']); ?> Orang</p>
                            </div>
                            <div class="col-6">
                                <h6 class="fw-bold text-dark mb-1">
                                    <i class="bi bi-door-open-fill text-primary me-1"></i> Jumlah Kamar
                                </h6>
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($data['jumlah_kamar']); ?> Kamar</p>
                            </div>
                        </div>

                        <!-- TOMBOL BOOKING (Cek Login) -->
                        <div class="mt-4">
                            <?php if (isset($_SESSION['id_user'])): ?>
                                <a href="booking.php?id_villa=<?php echo $data['id_villa']; ?>" class="btn btn-pink px-4 py-2 w-100 fw-bold">
                                    Pesan Sekarang
                                </a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-secondary px-4 py-2 w-100 fw-bold" onclick="alert('Silakan login terlebih dahulu untuk melakukan pemesanan!');">
                                    <i class="bi bi-lock-fill me-1"></i> Login untuk Memesan
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </div>

            <!-- PANAH KANAN -->
            <?php if ($next) { ?>
                <a href="descVilla.php?id=<?php echo $next['id_villa']; ?>" 
                   class="btn btn-outline-primary rounded-circle fw-bold d-flex justify-content-center align-items-center flex-shrink-0 bg-white shadow-sm"
                   style="width: 55px; height: 55px; font-size: 22px; border-color: #cbd5e1;">
                    →
                </a>
            <?php } else { ?>
                <div style="width: 55px;"></div>
            <?php } ?>

        </div>

    </div>
</section>

<?php 
include 'footer.php'; 
?>