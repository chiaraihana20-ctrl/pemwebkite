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

// Panggil header agar navbar dan styling utamanya muncul
include 'header.php';
?>

<!-- KONTEN UTAMA RIWAYAT PEMESANAN -->
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--text-dark);">Riwayat Pemesanan</h2>
            <p class="text-muted">Daftar pemesanan villa yang pernah Anda lakukan.</p>
        </div>
    </div>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
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
                                    $status = $row['status'] ?? 'Pending';
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

<?php 
// Panggil footer di bagian bawah
include 'footer.php'; 
?>