<?php
session_start();
include 'koneksi.php';

// Jika user belum login, lempar ke halaman login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_villa = isset($_GET['id_villa']) ? (int)$_GET['id_villa'] : 0;

// Ambil data villa berdasarkan ID
$query_villa = mysqli_query($conn, "SELECT * FROM villa WHERE id_villa = $id_villa");
$villa = mysqli_fetch_assoc($query_villa);

// Jika villa tidak ditemukan di database
if (!$villa) {
    echo "<script>alert('Villa tidak ditemukan!'); window.location='descVilla.php';</script>";
    exit;
}

$pesan_error = "";

// Jika tombol 'Konfirmasi Pesanan' ditekan
if (isset($_POST['konfirmasi_booking'])) {
    $tanggal_masuk = mysqli_real_escape_string($conn, $_POST['tanggal_masuk']);
    $tanggal_keluar = mysqli_real_escape_string($conn, $_POST['tanggal_keluar']);
    $jumlah_tamu = (int)$_POST['jumlah_tamu'];

    if (empty($tanggal_masuk) || empty($tanggal_keluar) || $jumlah_tamu <= 0) {
        $pesan_error = "Semua kolom formulir wajib diisi dengan benar!";
    } else {
        // Hitung selisih hari (malam)
        $ts1 = strtotime($tanggal_masuk);
        $ts2 = strtotime($tanggal_keluar);
        $jumlah_malam = round(($ts2 - $ts1) / (60 * 60 * 24));

        if ($jumlah_malam <= 0) {
            $pesan_error = "Tanggal keluar (check-out) harus setelah tanggal masuk (check-in)!";
        } else {
            // Bersihkan harga dari database
            $harga_per_malam = preg_replace('/[^0-9]/', '', $villa['harga']);
            $total_harga = $jumlah_malam * (float)$harga_per_malam;
            $status = "Pending";

            // Simpan ke tabel booking (Menggunakan 'tanggal_kelaur' sesuai database)
            $query_insert = "INSERT INTO booking (id_user, id_villa, tanggal_masuk, tanggal_kelaur, jumlah_tamu, harga, status) 
                             VALUES ('$id_user', '$id_villa', '$tanggal_masuk', '$tanggal_keluar', '$jumlah_tamu', '$total_harga', '$status')";
            
            if (mysqli_query($conn, $query_insert)) {
                // Jika berhasil, alihkan ke halaman Riwayat Pemesanan
                header("Location: riwayatPemesanan.php");
                exit;
            } else {
                $pesan_error = "Gagal memproses pesanan: " . mysqli_error($conn);
            }
        }
    }
}

// Panggil header navbar
include 'header.php';
?>

<!-- KONTEN FORM BOOKING -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="mb-4">
                <a href="descVilla.php?id=<?= $id_villa; ?>" class="btn fw-bold px-4 py-2" style="background-color: var(--pink-accent); color: #ffffff; border: none; border-radius: 20px;">
                    ← Kembali ke Detail Villa
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h3 class="fw-bold mb-3" style="color: var(--text-dark);">Formulir Pemesanan Villa</h3>
                <p class="text-muted small mb-4">Lengkapi detail waktu menginap dan jumlah tamu Anda.</p>

                <!-- Tampilkan Error jika ada -->
                <?php if (!empty($pesan_error)): ?>
                    <div class="alert alert-danger rounded-3 shadow-sm" role="alert">
                        <?= $pesan_error; ?>
                    </div>
                <?php endif; ?>

                <!-- RINGKASAN VILLA YANG DIPESAN -->
                <div class="p-3 mb-4 rounded-3 bg-light d-flex align-items-center gap-3">
                    <img src="http://localhost/projek2/pict/<?= htmlspecialchars($villa['gambar']); ?>" alt="Foto Villa" class="rounded-3 object-fit-cover" style="width: 90px; height: 70px;">
                    <div>
                        <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($villa['nama_villa']); ?></h5>
                        <p class="text-primary fw-semibold mb-0 small">
                            Rp <?= number_format((float)preg_replace('/[^0-9]/', '', $villa['harga']), 0, ',', '.'); ?> / malam
                        </p>
                    </div>
                </div>

                <!-- FORM INPUT BOOKING -->
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Tanggal Check-in</label>
                            <input type="date" name="tanggal_masuk" class="form-control py-2" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Tanggal Check-out</label>
                            <input type="date" name="tanggal_keluar" class="form-control py-2" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Jumlah Tamu (Orang)</label>
                        <input type="number" name="jumlah_tamu" class="form-control py-2" min="1" max="<?= htmlspecialchars($villa['kapasitas']); ?>" value="1" required>
                        <div class="form-text small">Maksimal kapasitas villa ini: <?= htmlspecialchars($villa['kapasitas']); ?> orang.</div>
                    </div>

                    <button type="submit" name="konfirmasi_booking" class="btn btn-pink w-100 py-2 fw-bold shadow-sm">
                        Konfirmasi & Pesan Sekarang
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>

<?php 
// Panggil footer
include 'footer.php'; 
?>