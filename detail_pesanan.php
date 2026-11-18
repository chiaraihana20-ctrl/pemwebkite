<?php
session_start();
include 'koneksi.php';

// Jika user belum login, alihkan ke login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_booking = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data pemesanan berdasarkan ID booking dan pastikan milik user yang sedang login
$query = "SELECT booking.*, villa.nama_villa, villa.deskripsi, villa.gambar, villa.kapasitas, villa.jumlah_kamar 
          FROM booking 
          JOIN villa ON booking.id_villa = villa.id_villa 
          WHERE booking.id_booking = '$id_booking' AND booking.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Jika data pesanan tidak ditemukan
if (!$row) {
    echo "<script>alert('Detail pesanan tidak ditemukan!'); window.location='riwayatPemesanan.php';</script>";
    exit;
}

// Panggil header navbar
include 'header.php';
?>

<!-- KONTEN DETAIL PESANAN -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <!-- TOMBOL KEMBALI -->
            <div class="mb-4">
                <a href="riwayatPemesanan.php" class="btn fw-bold px-4 py-2" style="background-color: var(--pink-accent); color: #ffffff; border: none; border-radius: 20px;">
                    ← Kembali ke Riwayat
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">Detail Pesanan #<?= $row['id_booking']; ?></h3>
                        <p class="text-muted small mb-0">Informasi lengkap transaksi dan reservasi villa Anda.</p>
                    </div>
                    <div>
                        <?php 
                            $status = $row['status'] ?? 'Pending';
                            $badge_bg = 'bg-secondary';
                            if ($status == 'Pending') $badge_bg = 'bg-warning text-dark';
                            else if ($status == 'Confirmed' || $status == 'Berhasil') $badge_bg = 'bg-success';
                            else if ($status == 'Cancelled') $badge_bg = 'bg-danger';
                        ?>
                        <span class="badge <?= $badge_bg; ?> px-3 py-2 fs-6 rounded-pill"><?= htmlspecialchars($status); ?></span>
                    </div>
                </div>

                <!-- FOTO & NAMA VILLA -->
                <div class="row align-items-center mb-4">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img src="http://localhost/projek/pict/<?= htmlspecialchars($row['gambar']); ?>" alt="Foto Villa" class="img-fluid rounded-4 object-fit-cover shadow-sm" style="height: 160px; width: 100%;">
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold text-dark mb-2"><?= htmlspecialchars($row['nama_villa']); ?></h4>
                        <p class="text-muted small mb-2"><?= htmlspecialchars($row['deskripsi']); ?></p>
                        <span class="badge bg-light text-dark border me-2"><i class="bi bi-people me-1"></i> Kapasitas: <?= htmlspecialchars($row['kapasitas']); ?> Orang</span>
                        <span class="badge bg-light text-dark border"><i class="bi bi-door-open me-1"></i> <?= htmlspecialchars($row['jumlah_kamar']); ?> Kamar</span>
                    </div>
                </div>

                <hr class="text-muted opacity-25 mb-4">

                <!-- RINCIAN WAKTU & BIAYA -->
                <h5 class="fw-bold text-dark mb-3">Rincian Menginap</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block mb-1">Tanggal Check-in</span>
                            <strong class="text-dark"><i class="bi bi-calendar-check me-1 text-primary"></i> <?= htmlspecialchars($row['tanggal_masuk']); ?></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block mb-1">Tanggal Check-out</span>
                            <strong class="text-dark"><i class="bi bi-calendar-x me-1 text-danger"></i> <?= htmlspecialchars($row['tanggal_kelaur']); ?></strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block mb-1">Jumlah Tamu</span>
                            <strong class="text-dark"><i class="bi bi-people me-1 text-success"></i> <?= htmlspecialchars($row['jumlah_tamu']); ?> Orang</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block mb-1">Total Biaya</span>
                            <strong class="text-primary fs-5">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></strong>
                        </div>
                    </div>
                </div>

                <!-- TOMBOL AKSI TAMBAHAN -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="riwayatPemesanan.php" class="btn btn-outline-secondary px-4 py-2 rounded-pill">Kembali</a>
                    <a href="descVilla.php?id=<?= $row['id_villa']; ?>" class="btn btn-pink px-4 py-2 rounded-pill">Lihat Villa Lagi</a>
                </div>

            </div>

        </div>
    </div>
</div>

<?php 
// Panggil footer
include 'footer.php'; 
?>